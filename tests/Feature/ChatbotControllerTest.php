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
        $response->assertJsonPath('message', 'Tenemos tres opciones: Solo WiFi por $47.900, Solo Televisión por $27.000 y WiFi + TV por $74.900. Todos incluyen soporte técnico 24/7.');

        Http::assertSent(function ($request) {
            $url = $request->url();
            $systemInstruction = data_get($request->data(), 'systemInstruction.parts.0.text');

            return str_contains($url, 'models/gemini-3.6-flash:generateContent')
                && str_contains($url, 'key=test-key')
                && str_contains($systemInstruction, 'Responde en el mismo idioma que el último mensaje del usuario (español o inglés)');
        });
    }

    public function test_it_uses_english_for_english_fallback_questions(): void
    {
        config()->set('services.gemini.key', null);

        $response = $this->postJson('/chatbot/reply', [
            'message' => 'What can I do in this section?',
            'page' => 'dashboard',
        ]);

        $response->assertOk();
        $response->assertJsonPath('fallback', true);
        $this->assertStringContainsString(
            'This is AsoTV\'s public section. You can learn about Digital TV, Canal 8, and internet services',
            $response->json('message')
        );
        $this->assertStringContainsString(
            'you cannot access private account information, invoices, support tickets, or administration',
            $response->json('message')
        );
    }

    public function test_it_gives_a_complete_spanish_fallback_for_current_section_questions(): void
    {
        config()->set('services.gemini.key', null);

        $response = $this->postJson('/chatbot/reply', [
            'message' => '¿Qué puedo realizar en este apartado?',
            'page' => 'dashboard',
        ]);

        $response->assertOk();
        $response->assertJsonPath('fallback', true);
        $this->assertStringContainsString(
            'Este es el apartado público de AsoTV. Puedes conocer los servicios de Televisión Digital, Canal 8 e internet',
            $response->json('message')
        );
        $this->assertStringContainsString(
            'no puedes acceder a información privada de cuentas, facturas, tickets de soporte ni administración',
            $response->json('message')
        );
    }

    public function test_it_uses_english_for_english_fallback_plan_questions(): void
    {
        config()->set('services.gemini.key', null);

        $response = $this->postJson('/chatbot/reply', [
            'message' => 'What plans do you offer?',
        ]);

        $response->assertOk();
        $response->assertJsonPath('fallback', true);
        $response->assertJsonPath('message', 'We offer three plans: Solo WiFi for $47,900, Solo Television for $27,000, and WiFi + TV for $74,900. All plans include 24/7 technical support.');
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
