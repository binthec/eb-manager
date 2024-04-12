<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

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
            'user_id' => User::factory(),
            'filename' => fake()->text([255]),
            'invoice' => 0,
            'size' => fake()->numerify,
            'width' => fake()->numerify,
            'height' => fake()->numerify,
            'lastModified' => fake()->date(['YYYY-MM-dd HH:ii:ss']),
            'filepath' => fake()->text([255])
        ];
    }
}
