<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Track extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
    ];

    public function sessions()
    {
        return $this->hasMany(Session::class, 'track_id');
    }

    /**
     * Many-to-many relation: Track has many Speakers.
     */
    public function speakers()
    {
        return $this->belongsToMany(Speaker::class, 'speaker_track', 'track_id', 'speaker_id')
            ->withTimestamps();
    }
}
