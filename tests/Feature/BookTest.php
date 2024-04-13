<?php

namespace Tests\Feature;

use App\Models\Book;
use Faker\Factory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class BookTest extends TestCase
{

    use RefreshDatabase;

    /**
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

        // この feature テストで使う user を作成、保存
        $this->user = User::factory()->create();
    }

    /**
     * A basic feature test example.
     */
    public function testIndex(): void
    {

        $books = Book::factory()->for($this->user)->create();

        // ログインしていない場合、リダイレクト(302) -> login 画面へ遷移する
        $response = $this->get('/books');
        $response->assertFound()->assertRedirect(route('login'));

        // ログイン済みの場合、books 一覧画面が表示される
        $response = $this->actingAs($this->user)->get('/books');
        $response->assertOk();
    }
}
