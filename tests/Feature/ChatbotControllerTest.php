<?php

namespace Tests\Feature;

use App\Http\Controllers\ChatbotController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class ChatbotControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_uses_a_supported_gemini_model_and_falls_back_on_api_errors(): void
    {
        config()->set('services.gemini.key', 'test-key');
        config()->set('services.gemini.model', 'gemini-3.6-flash');

        Http::fake([
            'https://generativelanguage.googleapis.com/*' => Http::response([
                'error' => ['code' => 400, 'message' => 'Invalid model'],
            ], 400),
        ]);

        $response = $this->postJson('/chatbot/reply', [
            'message' => '¿Cuáles son los planes?',
            'history' => [],
            'page' => 'planes',
        ]);

        $response->assertOk();
        $response->assertJsonPath('fallback', true);

        Http::assertSent(function ($request) {
            $url = $request->url();

            return str_contains($url, 'models/gemini-3.6-flash:generateContent')
                && str_contains($url, 'key=test-key');
        });
    }

    public function test_it_returns_the_chatbot_answer_even_if_the_interaction_cannot_be_saved(): void
    {
        config()->set('services.gemini.key', 'test-key');
        config()->set('services.gemini.model', 'gemini-3.6-flash');

        Http::fake([
            'https://generativelanguage.googleapis.com/*' => Http::response([
                'candidates' => [[
                    'content' => [
                        'parts' => [[
                            'text' => 'Aquí tienes la información sobre los planes de AsoTV.',
                        ]],
                    ],
                ]],
            ], 200),
        ]);

        $controller = new class extends ChatbotController {
            protected function createInteractionRecord(array $attributes): void
            {
                throw new \RuntimeException('DB unavailable');
            }
        };

        $request = Request::create('/chatbot/reply', 'POST', [
            'message' => '¿Qué planes tienen?',
            'history' => [],
            'page' => 'planes',
        ]);

        $response = $controller->reply($request);

        $this->assertSame(200, $response->getStatusCode());
        $this->assertSame(
            'Aquí tienes la información sobre los planes de AsoTV.',
            json_decode($response->getContent(), true)['message']
        );
    }
}
