<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Cache;

class Speaker extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'title',
        'company',
        'bio',
        'twitter',
        'linkedin',
        'image_path',
        'website',
    ];

    public function sessions()
    {
        return $this->belongsToMany(Session::class, 'session_speaker', 'speaker_id', 'session_id')
            ->withPivot('role')
            ->withTimestamps();
    }

    /**
     * Many-to-many relation: Speaker belongs to many Tracks.
     */
    public function tracks()
    {
        return $this->belongsToMany(Track::class, 'speaker_track', 'speaker_id', 'track_id')
            ->withTimestamps();
    }

    /**
     * Return a safe URL for the speaker image.
     *
     * Priority:
     * 1) If `image_path` is an absolute URL and the remote resource responds (HTTP 2xx/3xx) -> return it.
     * 2) If `image_path` is a local path that exists under `public/` -> return asset($image_path).
     * 3) If `image_path` is stored under `storage/app/public` -> return asset('storage/...') when exists.
     * 4) Fallback to a default placeholder image.
     *
     * Note: Remote checks use `@get_headers()` which will perform a quick HTTP request. If you render many
     * speakers on one page this can slow the page load; consider caching the check or validating image paths
     * when saving/updating speakers instead.
     *
     * Usage in Blade: <img src="{{ $speaker->image_url }}"> or $speaker->image_url
     */
    public function getImageUrlAttribute()
    {
        $default = 'https://bengalurutechsummit.com/img/speakers-25/demo.jpg';

        $path = trim((string) ($this->image_path ?? ''));
        if ($path === '') {
            return $default;
        }

        // If absolute URL
        if (preg_match('#^https?://#i', $path)) {
            if ($this->remoteUrlExists($path)) {
                return $path;
            }

            return $default;
        }

        // Treat as local relative path (public/)
        // $publicPath = public_path($path);
        // if (file_exists($publicPath)) {
        //     return asset($path);
        // }

        // // Maybe stored in storage/app/public
        // $storageCandidate = storage_path('app/public/' . ltrim($path, '/'));
        // if (file_exists($storageCandidate)) {
        //     return asset('storage/' . ltrim($path, '/'));
        // }

        return $default;
    }

    /**
     * Check whether a remote URL exists by inspecting headers.
     * Returns true for 2xx and 3xx responses.
     */
    protected function remoteUrlExists(string $url): bool
    {
        // Cache the result to avoid many remote requests on page render.
        $cacheKey = 'speaker_image_exists:' . md5($url);
        return Cache::remember($cacheKey, now()->addHours(6), function () use ($url) {
            // Suppress warnings in case allow_url_fopen is disabled or DNS fails
            $headers = @get_headers($url, 1);
            if (!is_array($headers) || empty($headers)) {
                return false;
            }

            // First header contains HTTP status line
            $statusLine = $headers[0] ?? '';
            if (preg_match('#^HTTP/\d(?:\.\d)?\s+(\d{3})#i', $statusLine, $m)) {
                $code = (int) ($m[1] ?? 0);
                return $code >= 200 && $code < 400; // 2xx and 3xx OK
            }

            return false;
        });
    }
}
