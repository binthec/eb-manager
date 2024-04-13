<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => 1,
            'filename' => Str::random(10) . '.jpg',
            'invoice' => 0,
            'size' => fake()->numerify,
            'width' => fake()->numerify,
            'height' => fake()->numerify,
            'lastModified' => fake()->date('Y-m-d H:i:s'),
            'filepath' => Str::random(10),
        ];
    }
}
