<?php

namespace App\Services\Seo;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use RuntimeException;
use Throwable;

class OpenAiMetaDescriptionGenerator
{
    public function generate(string $title, string $tags, string $body): string
    {
        $apiKey = config('services.openai.key') ?: env('OPENAI_API_KEY');
        if (!$apiKey) {
            throw new RuntimeException('OPENAI_API_KEY no configurada. Añadela en el .env para generar con IA.', 422);
        }

        $cleanTitle = trim($title);
        $cleanTags = trim($tags);
        $cleanBody = trim(strip_tags($body));
        $cleanBody = Str::limit(preg_replace('/\s+/', ' ', $cleanBody) ?: '', 1400, '');

        if ($cleanTitle === '' && $cleanBody === '') {
            throw new RuntimeException('Faltan datos para generar la meta description.', 422);
        }

        $model = env('OPENAI_MODEL', 'gpt-4o-mini');
        $prompt = "Genera una metadescription SEO en español (140-160 caracteres), clara, natural y sin comillas.\n"
            . "Devuelve SOLO una frase final.\n\n"
            . "Título: {$cleanTitle}\n"
            . "Tags: {$cleanTags}\n"
            . "Contenido: {$cleanBody}";

        try {
            $response = Http::withToken($apiKey)
                ->timeout(30)
                ->post('https://api.openai.com/v1/responses', [
                    'model' => $model,
                    'input' => $prompt,
                    'temperature' => 0.4,
                    'max_output_tokens' => 120,
                ]);
        } catch (Throwable $exception) {
            logger()->error('OpenAI request failed', [
                'message' => $exception->getMessage(),
                'class' => get_class($exception),
            ]);
            throw new RuntimeException('Error de conexión con OpenAI.', 500, $exception);
        }

        if (!$response->ok()) {
            $apiError = $response->json('error.message') ?: $response->body();
            logger()->warning('OpenAI non-ok response', [
                'status' => $response->status(),
                'body' => $response->json() ?: $response->body(),
            ]);

            $message = is_string($apiError) && trim($apiError) !== ''
                ? $apiError
                : 'No se pudo generar la descripción con IA.';

            throw new RuntimeException($message, $response->status());
        }

        $json = $response->json();
        $text = (string) ($json['output_text'] ?? '');
        if ($text === '') {
            $text = $this->extractTextFromOutput($json['output'] ?? []);
        }

        $text = trim(preg_replace('/\s+/', ' ', $text) ?: '');
        $text = trim($text, "\"' \t\n\r\0\x0B");
        $text = Str::limit($text, 160, '');

        if ($text === '') {
            logger()->warning('OpenAI empty meta-description response', [
                'status' => $response->status(),
                'body' => $response->json(),
            ]);
            throw new RuntimeException('La IA no devolvio una descripción valida.', 500);
        }

        return $text;
    }

    private function extractTextFromOutput(array $output): string
    {
        $chunks = [];
        foreach ($output as $item) {
            if (!isset($item['content']) || !is_array($item['content'])) {
                continue;
            }

            foreach ($item['content'] as $contentItem) {
                $candidate = $contentItem['text']
                    ?? $contentItem['output_text']
                    ?? $contentItem['value']
                    ?? '';

                if (is_string($candidate) && trim($candidate) !== '') {
                    $chunks[] = $candidate;
                }
            }
        }

        return implode(' ', $chunks);
    }
}
