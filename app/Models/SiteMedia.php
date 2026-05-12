<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SiteMedia extends Model
{
    protected $table = 'site_media';

    protected $fillable = [
        'path',
        'original_filename',
        'mime_type',
        'size_bytes',
        'alt_text',
        'user_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function publicUrl(): string
    {
        return asset($this->path);
    }

    public function isImage(): bool
    {
        $mime = (string) $this->mime_type;

        return str_starts_with($mime, 'image/');
    }

    public function deleteStoredFile(): void
    {
        if (! Str::startsWith($this->path, 'storage/')) {
            return;
        }

        Storage::disk('public')->delete(Str::after($this->path, 'storage/'));
    }

    protected static function booted(): void
    {
        static::deleting(function (SiteMedia $siteMedia): void {
            $siteMedia->deleteStoredFile();
        });
    }
}
