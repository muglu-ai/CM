<?php

namespace Database\Factories;

use App\Models\Session;
use App\Models\Event;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class SessionFactory extends Factory
{
    protected $model = Session::class;

    public function definition(): array
    {
        $title = $this->faker->sentence(6);

        return [
            'event_id' => Event::factory(),
            'title' => $title,
            'slug' => Str::slug($title) . '-' . $this->faker->unique()->numberBetween(1, 9999),
            'description' => $this->faker->paragraphs(2, true),
            'starts_at' => $this->faker->dateTimeBetween('now', '+2 weeks'),
            'ends_at' => $this->faker->dateTimeBetween('+2 weeks', '+3 weeks'),
            'format' => $this->faker->randomElement(['Talk', 'Workshop', 'Panel']),
            'language' => $this->faker->randomElement(['English', 'Spanish', 'French']),
            'level' => $this->faker->randomElement(['Beginner', 'Intermediate', 'Advanced']),
            'track' => $this->faker->randomElement(['Web', 'API', 'Security', 'DevOps']),
            'tags' => $this->faker->randomElements(['laravel','php','livewire','testing','security'], 2),
            'location' => $this->faker->city(),
            'room' => 'Room ' . $this->faker->numberBetween(1, 10),
            'ceu_hours' => $this->faker->randomFloat(2, 0, 4),
            'capacity' => $this->faker->numberBetween(10, 200),
        ];
    }
}

