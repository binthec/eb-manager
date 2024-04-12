<?php

namespace Tests\Feature;

use App\Models\Book;
use Faker\Factory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BookTest extends TestCase
{

    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $user = User::factory()->create();
        $books = Book::factory()->create();

        $response = $this
            ->actingAs($user)
            ->get('/books');

        $response->assertOk();
    }
}
