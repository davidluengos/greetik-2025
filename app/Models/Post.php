<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $table = 'post';

    public const CREATED_AT = 'createdat';
    public const UPDATED_AT = 'lastedit';

    protected $fillable = [
        'title',
        'tags',
        'metatitle',
        'metadescription',
        'createdat',
        'lastedit',
        'user',
        'body',
        'publishdate',
        'enddate',
        'extra',
    ];

    protected function casts(): array
    {
        return [
            'createdat' => 'datetime',
            'lastedit' => 'datetime',
            'publishdate' => 'datetime',
            'enddate' => 'datetime',
        ];
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query
            ->whereNotNull('publishdate')
            ->where('publishdate', '<=', now())
            ->where(function (Builder $builder) {
                $builder->whereNull('enddate')->orWhere('enddate', '>=', now());
            });
    }

    public function getTagsArrayAttribute(): array
    {
        if (!$this->tags) {
            return [];
        }

        $rawTags = (string) $this->tags;
        $decoded = $this->decodeLegacyTags($rawTags);

        if (is_array($decoded)) {
            return collect($decoded)
                ->map(static fn ($tag) => trim((string) $tag))
                ->filter()
                ->unique()
                ->values()
                ->all();
        }

        return collect(explode(',', (string) $decoded))
            ->map(static fn (string $tag) => trim($tag))
            ->filter()
            ->unique()
            ->values()
            ->all();
    }

    private function decodeLegacyTags(string $rawTags): string|array
    {
        $rawTags = trim($rawTags);

        // Legacy formats detected in older versions: PHP serialized arrays.
        if ($this->looksSerialized($rawTags)) {
            $unserialized = @unserialize($rawTags, ['allowed_classes' => false]);
            if (is_array($unserialized)) {
                return $unserialized;
            }
        }

        // Some installations may store tags as JSON arrays.
        $jsonDecoded = json_decode($rawTags, true);
        if (json_last_error() === JSON_ERROR_NONE && is_array($jsonDecoded)) {
            return $jsonDecoded;
        }

        return $rawTags;
    }

    private function looksSerialized(string $value): bool
    {
        return str_starts_with($value, 'a:')
            || str_starts_with($value, 's:')
            || str_starts_with($value, 'i:')
            || str_starts_with($value, 'b:')
            || str_starts_with($value, 'N;');
    }
}
