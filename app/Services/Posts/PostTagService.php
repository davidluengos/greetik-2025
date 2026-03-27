<?php

namespace App\Services\Posts;

use App\Models\Post;
use App\Models\Tag;
use Illuminate\Support\Str;

class PostTagService
{
    public function normalize(string $tags): string
    {
        return collect(explode(',', $tags))
            ->map(static fn (string $tag) => trim($tag))
            ->filter()
            ->map(static fn (string $tag) => Str::lower($tag))
            ->unique()
            ->implode(', ');
    }

    public function suggestions(): array
    {
        return Tag::query()
            ->whereNotNull('name')
            ->where('name', '!=', '')
            ->orderBy('name')
            ->pluck('name')
            ->unique()
            ->values()
            ->all();
    }

    public function syncRepetitions(): void
    {
        $counts = [];

        Post::query()->select(['tags'])->chunk(200, function ($posts) use (&$counts): void {
            foreach ($posts as $post) {
                foreach ($post->tags_array as $tagName) {
                    $normalized = Str::lower(trim($tagName));
                    if ($normalized === '') {
                        continue;
                    }

                    // Prefix avoids PHP casting numeric string keys (e.g. "2019") to integers.
                    $internalKey = '__' . $normalized;
                    $counts[$internalKey] = ($counts[$internalKey] ?? 0) + 1;
                }
            }
        });

        foreach ($counts as $internalKey => $repetitions) {
            $name = substr((string) $internalKey, 2);
            Tag::query()->updateOrCreate(
                ['name' => $name, 'project' => 0],
                ['repetitions' => $repetitions]
            );
        }

        // Legacy-safe reset: avoids NOT IN issues with large string lists in some MySQL setups.
        Tag::query()->update(['repetitions' => 0]);

        foreach ($counts as $internalKey => $repetitions) {
            $name = substr((string) $internalKey, 2);
            Tag::query()
                ->where('name', $name)
                ->where('project', 0)
                ->update(['repetitions' => $repetitions]);
        }
    }
}
