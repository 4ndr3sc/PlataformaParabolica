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
                && str_contains($systemInstruction, 'Responde en el mismo idioma que el último mensaje del usuario (español o inglés)')
                && str_contains($systemInstruction, 'Responde únicamente sobre ASO TV y sus servicios, o sobre la reflexión transhumanista')
                && str_contains($systemInstruction, 'no el texto íntegro de la Declaración')
                && str_contains($systemInstruction, 'CONTEXTO AUTORIZADO (única fuente factual)')
                && str_contains($systemInstruction, 'ANÁLISIS Y CONSULTA')
                && str_contains($systemInstruction, 'no respondas con planes, precios o una descripción general de internet')
                && str_contains($systemInstruction, '"reportar_falla_de_senal"')
                && str_contains($systemInstruction, '"reflexion_transhumana"')
                && str_contains($systemInstruction, '"horario_de_oficina": null');
        });
    }

    public function test_it_uses_the_documented_support_procedure_for_internet_fault_questions(): void
    {
        config()->set('services.gemini.key', 'test-key');
        Http::fake();

        $response = $this->postJson('/chatbot/reply', [
            'message' => 'como reporto una falla en mi internet',
        ]);

        $response->assertOk();
        $response->assertJsonMissingPath('fallback');
        $this->assertStringContainsString('crea un ticket de soporte', $response->json('message'));
        $this->assertStringContainsString('Tipo de PQR, selecciona Falla Técnica', $response->json('message'));
        $this->assertStringContainsString('describe detalladamente la falla', $response->json('message'));
        $this->assertStringContainsString(url('/soporte/crear'), $response->json('message'));
        $this->assertStringNotContainsString('El plan Solo WiFi', $response->json('message'));

        Http::assertNothingSent();
    }

    public function test_it_answers_internet_fault_questions_in_english(): void
    {
        config()->set('services.gemini.key', null);

        $response = $this->postJson('/chatbot/reply', [
            'message' => 'How do I report an internet outage?',
        ]);

        $response->assertOk();
        $this->assertStringContainsString('create a support ticket', $response->json('message'));
        $this->assertStringContainsString('Technical Fault', $response->json('message'));
        $this->assertStringContainsString(url('/soporte/crear'), $response->json('message'));
    }

    public function test_it_answers_transhumanist_questions_when_gemini_is_unavailable(): void
    {
        config()->set('services.gemini.key', null);

        $response = $this->postJson('/chatbot/reply', [
            'message' => '¿De qué manera el agente respeta la dignidad y autonomía en el aprendizaje y la interacción tecnológica?',
        ]);

        $response->assertOk();
        $response->assertJsonPath('fallback', true);
        $this->assertStringContainsString('el chatbot pone a las personas en el centro', $response->json('message'));
        $this->assertStringContainsString('apoyar el aprendizaje y la alfabetización digital', $response->json('message'));
        $this->assertStringContainsString('no el texto íntegro de la Declaración', $response->json('message'));
    }

    public function test_it_answers_transhumanist_questions_in_english_when_gemini_is_unavailable(): void
    {
        config()->set('services.gemini.key', null);

        $response = $this->postJson('/chatbot/reply', [
            'message' => 'How does the implemented AI agent/chatbot align with and support the Transhuman Person Declaration of Universidad de Cundinamarca regarding ethical AI integration, human augmentation, and educational transformation?',
        ]);

        $response->assertOk();
        $response->assertJsonPath('fallback', true);
        $this->assertStringContainsString('the chatbot puts people first', $response->json('message'));
        $this->assertStringContainsString('support learning and digital literacy', $response->json('message'));
        $this->assertStringContainsString('not the full text of the Declaration', $response->json('message'));
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
