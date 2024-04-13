<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use Inertia\Testing\AssertableInertia as AssertInertia;

class BookControllerTest extends TestCase
{

    use RefreshDatabase;

    /**
     * @var string
     */
    private string $fileDirPath;

    /**
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

        // この feature テストで使う user を作成、保存
        $this->user = User::factory()->create();
        // ファイルが保存されるディレクトリパス
        $this->fileDirPath = 'books/' . $this->user->id . '/';
    }

    /**
     * test index()
     * @return void
     */
    public function testIndex(): void
    {
        // ログインしていない場合、リダイレクト(302) -> login 画面へ遷移する
        $response = $this->get('/books');
        $response->assertFound()->assertRedirect(route('login'));

        // ログイン済みの場合、books 一覧画面が表示される
        $response = $this->actingAs($this->user)->get('/books');
        $response->assertOk();
        $response->assertInertia(fn(AssertInertia $page) => $page
            ->has('books') // books というプロパティが渡されているか
        );
    }

    /**
     * test store()
     * @return void
     */
    public function testStore(): void
    {
        Storage::fake('public');

        $file = UploadedFile::fake()->image('test.jpg');

        $response = $this
            ->actingAs($this->user)
            ->post(route('books.store'), [
                'file' => $file,
                'filename' => 'filename_test',
                'size' => 10,
                'height' => 10,
                'width' => 10,
                'lastModified' => now(),
            ]);

        // ファイルが生成されたことを確認
        Storage::disk('public')->assertExists($this->fileDirPath . $file->hashName());

        // アップロード後、index にリダイレクトされることを確認
        $response->assertRedirect(route('books.index'));
    }
}
