<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreSiteMediaRequest;
use App\Http\Requests\Admin\UpdateSiteMediaRequest;
use App\Models\SiteMedia;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class SiteMediaController extends Controller
{
    public function index(): View
    {
        $this->authorize('viewAny', SiteMedia::class);

        $mediaItems = SiteMedia::query()
            ->orderByDesc('id')
            ->paginate(24)
            ->withQueryString();

        return view('admin.site-media.index', compact('mediaItems'));
    }

    public function pickerItems(Request $request): JsonResponse
    {
        $this->authorize('viewAny', SiteMedia::class);

        $imagesOnly = $request->boolean('images_only', true);

        $query = SiteMedia::query()->orderByDesc('id')->limit(120);

        if ($imagesOnly) {
            $query->where('mime_type', 'like', 'image/%');
        }

        $items = $query->get(['id', 'path', 'original_filename', 'alt_text', 'mime_type']);

        return response()->json([
            'items' => $items->map(static function (SiteMedia $media) {
                return [
                    'id' => $media->id,
                    'url' => $media->publicUrl(),
                    'title' => $media->alt_text ?: $media->original_filename,
                    'mime_type' => $media->mime_type,
                ];
            }),
        ]);
    }

    public function store(StoreSiteMediaRequest $request): RedirectResponse
    {
        $this->authorize('create', SiteMedia::class);

        $userId = Auth::id();
        $count = 0;

        foreach ($request->file('files', []) as $file) {
            $storedPath = $file->store('site-media', 'public');
            SiteMedia::create([
                'path' => 'storage/'.$storedPath,
                'original_filename' => $file->getClientOriginalName(),
                'mime_type' => $file->getClientMimeType(),
                'size_bytes' => $file->getSize(),
                'alt_text' => null,
                'user_id' => $userId,
            ]);
            $count++;
        }

        return redirect()
            ->route('admin.site-media.index')
            ->with('status', $count === 1 ? 'Archivo subido correctamente.' : "{$count} archivos subidos correctamente.");
    }

    public function update(UpdateSiteMediaRequest $request, SiteMedia $siteMedia): RedirectResponse
    {
        $this->authorize('update', $siteMedia);

        $siteMedia->update($request->validated());

        return redirect()
            ->route('admin.site-media.index')
            ->with('status', 'Medio actualizado.');
    }

    public function destroy(SiteMedia $siteMedia): RedirectResponse
    {
        $this->authorize('delete', $siteMedia);

        $siteMedia->delete();

        return redirect()
            ->route('admin.site-media.index')
            ->with('status', 'Archivo eliminado.');
    }
}
