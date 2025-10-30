<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Speaker;
use App\Models\Track;

class Session extends Model
{
    use HasFactory;

    protected $table = 'event_sessions';

    protected $fillable = [
        'event_id',
        'title',
        'slug',
        'description',
        'starts_at',
        'ends_at',
        'format',
        'language',
        'level',
        'tags',
        'location',
        'room',
        'event_day', // newly added column to store day1, day2, etc.
        'ceu_hours',
        'capacity',
        'track_id',
    ];

    protected $casts = [
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
        'tags' => 'array',
        'ceu_hours' => 'float',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id');
    }

    public function speakers()
    {
        return $this->belongsToMany(Speaker::class, 'session_speaker', 'session_id', 'speaker_id')
            ->withPivot('role')
            ->withTimestamps();
    }

    public function track()
    {
        return $this->belongsTo(Track::class, 'track_id', 'id');
    }
}
