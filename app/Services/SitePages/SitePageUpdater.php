<?php

namespace App\Services\SitePages;

use App\Models\SitePage;

class SitePageUpdater
{
    public function update(SitePage $sitePage, array $data, bool $isActive): void
    {
        $sitePage->title = $data['title'];
        $sitePage->meta_title = $data['meta_title'] ?? null;
        $sitePage->meta_description = $data['meta_description'] ?? null;
        $sitePage->body = $data['body'] ?? null;
        $sitePage->is_active = $isActive;
        $sitePage->extra = $this->buildExtraData($sitePage, $data);
        $sitePage->save();
    }

    private function buildExtraData(SitePage $sitePage, array $data): array
    {
        $extra = is_array($sitePage->extra) ? $sitePage->extra : [];

        if ($sitePage->slug === 'contacto') {
            $extra['address_title'] = $data['address_title'] ?? '';
            $extra['address'] = $data['address'] ?? '';
            $extra['hours_title'] = $data['hours_title'] ?? '';
            $extra['hours'] = $data['hours'] ?? '';
            $extra['phones_title'] = $data['phones_title'] ?? '';
            $extra['phones'] = $this->buildPhones((string) ($data['phones_text'] ?? ''));
            $extra['form_heading'] = $data['form_heading'] ?? '';
            $extra['map_embed'] = $data['map_embed'] ?? '';
            $extra['product_form_id'] = $data['product_form_id'] ?? null;
        }

        if ($sitePage->slug === 'sobre-nosotros') {
            $extra['hero_image'] = $data['hero_image'] ?? '';
            $extra['carousel'] = $this->decodeArray($data['carousel_json'] ?? null);
        }

        return $extra;
    }

    private function buildPhones(string $phonesText): array
    {
        $lines = preg_split('/\r\n|\r|\n/', $phonesText);

        return array_values(array_filter(array_map('trim', $lines ?: [])));
    }

    private function decodeArray(?string $json): array
    {
        $decoded = json_decode((string) ($json ?? '[]'), true);

        return is_array($decoded) ? $decoded : [];
    }
}
