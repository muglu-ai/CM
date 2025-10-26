<?php

namespace Database\Factories;

use App\Models\Speaker;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class SpeakerFactory extends Factory
{
    protected $model = Speaker::class;

    public function definition(): array
    {
        $name = $this->faker->name();

        return [
            'name' => $name,
            'slug' => Str::slug($name) . '-' . $this->faker->unique()->numberBetween(1, 9999),
            'title' => $this->faker->jobTitle(),
            'company' => $this->faker->company(),
            'bio' => $this->faker->paragraphs(2, true),
            'twitter' => '@' . $this->faker->userName(),
            'website' => $this->faker->url(),
        ];
    }
}

