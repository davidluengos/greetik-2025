<?php

namespace App\Services\Automatiza;

use Illuminate\Support\Facades\Log;

/**
 * Capa fina de analitica: cada evento se registra en el canal de log
 * configurable via config('automatiza.analytics.channel'). Cuando en
 * el futuro conectemos GA/Matomo/GTM, este es el unico sitio a tocar.
 */
final class AutomatizaAnalytics
{
    public function track(string $event, array $context = []): void
    {
        $channel = config('automatiza.analytics.channel', 'stack');

        try {
            Log::channel($channel)->info('automatiza.'.$event, $context);
        } catch (\Throwable $e) {
            // Nunca romper el flujo del usuario por un fallo de analitica.
            Log::warning('automatiza.analytics_failed', [
                'event' => $event,
                'error' => $e->getMessage(),
            ]);
        }
    }
}
