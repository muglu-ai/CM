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

        return  $path;
    }

    /**
     * Check whether a remote URL exists by making a proper HTTP request.
     * Returns true for 2xx and 3xx responses, follows redirects properly.
     */
    protected function remoteUrlExists(string $url): bool
    {
        // Cache the result to avoid many remote requests on page render.
        $cacheKey = 'speaker_image_exists:' . md5($url);
        return Cache::remember($cacheKey, now()->addHours(6), function () use ($url) {
            // Use cURL for more reliable URL checking
            $ch = curl_init();
            curl_setopt_array($ch, [
                CURLOPT_URL => $url,
                CURLOPT_NOBODY => true, // HEAD request only
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_FOLLOWLOCATION => true, // Follow redirects
                CURLOPT_MAXREDIRS => 5, // Limit redirects
                CURLOPT_TIMEOUT => 10, // 10 second timeout
                CURLOPT_CONNECTTIMEOUT => 5, // 5 second connection timeout
                CURLOPT_SSL_VERIFYPEER => false, // For self-signed certificates
                CURLOPT_SSL_VERIFYHOST => false,
                CURLOPT_USERAGENT => 'Mozilla/5.0 (compatible; Conference Management System)',
                CURLOPT_HTTPHEADER => [
                    'Accept: image/*,*/*;q=0.8',
                ],
            ]);

            $result = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $error = curl_error($ch);
            curl_close($ch);

            // Check for cURL errors
            if ($result === false || !empty($error)) {
                return false;
            }

            // Return true for 2xx and 3xx status codes
            return $httpCode >= 200 && $httpCode < 400;
        });
    }
}
