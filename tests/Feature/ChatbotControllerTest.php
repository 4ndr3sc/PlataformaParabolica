<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
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
}
