<?php

namespace App\View\Composers;

use App\Models\Project;
use App\Models\Service;
use App\Models\SitePage;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;

class FrontHeaderComposer
{
    public function compose(View $view): void
    {
        $menuServices = collect();
        $menuProjects = collect();
        $contactPhone = null;
        $contactPhoneHref = null;
        $contactEmail = config('mail.from.address');
        $contactWhatsappHref = null;

        if (Schema::hasTable('services')) {
            $menuServices = Service::query()
                ->where('is_active', true)
                ->orderBy('menu_order')
                ->orderBy('title')
                ->get(['title', 'slug']);
        }

        if (Schema::hasTable('projects')) {
            $menuProjects = Project::query()
                ->where('is_active', true)
                ->orderBy('menu_order')
                ->orderBy('title')
                ->get(['title', 'slug']);
        }

        if (Schema::hasTable('site_pages')) {
            $contactPage = SitePage::query()
                ->where('slug', 'contacto')
                ->where('is_active', true)
                ->first();

            $extra = is_array($contactPage?->extra) ? $contactPage->extra : [];
            $phones = $extra['phones'] ?? [];

            if (is_array($phones) && !empty($phones[0])) {
                $contactPhone = trim((string) $phones[0]);
                $normalizedPhone = preg_replace('/[^\d+]/', '', $contactPhone);
                $whatsappPhone = preg_replace('/\D/', '', $contactPhone);

                if (!empty($normalizedPhone)) {
                    $contactPhoneHref = 'tel:' . $normalizedPhone;
                }

                if (!empty($whatsappPhone)) {
                    $contactWhatsappHref = 'https://wa.me/' . $whatsappPhone . '?text=' . rawurlencode('Hola, me interesa solicitar presupuesto.');
                }
            }

            if (!empty($extra['email'])) {
                $contactEmail = (string) $extra['email'];
            }
        }

        $view->with([
            'menuServices' => $menuServices,
            'menuProjects' => $menuProjects,
            'contactPhone' => $contactPhone,
            'contactPhoneHref' => $contactPhoneHref,
            'contactEmail' => $contactEmail,
            'contactWhatsappHref' => $contactWhatsappHref,
        ]);
    }
}
