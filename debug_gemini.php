<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$key = env('GEMINI_API_KEY');
$model = env('GEMINI_MODEL', 'gemini-3.6-flash');

$response = Illuminate\Support\Facades\Http::timeout(30)
    ->connectTimeout(15)
    ->post(
        'https://generativelanguage.googleapis.com/v1beta/models/' . $model . ':generateContent?key=' . urlencode($key),
        [
            'contents' => [[
                'role' => 'user',
                'parts' => [['text' => 'Hola desde AsoTV']],
            ]],
            'systemInstruction' => [
                'parts' => [['text' => 'Eres un asistente de AsoTV. Responde en español.']],
            ],
            'generationConfig' => [
                'temperature' => 0.4,
                'maxOutputTokens' => 500,
            ],
        ]
    );

var_dump([
    'model' => $model,
    'key_present' => !empty($key),
    'status' => $response->status(),
    'body' => $response->body(),
    'failed' => $response->failed(),
]);
