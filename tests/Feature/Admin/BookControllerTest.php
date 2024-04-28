<?php

namespace Tests\Feature\Admin;

use App\Models\Book;
use App\Models\User;
use App\Repositories\BookRepository;
use App\Services\Admin\BookService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use Inertia\Testing\AssertableInertia as AssertInertia;

class BookControllerTest extends TestCase
{

    use RefreshDatabase;

    /**
     * @var Book
     */
    private Book $book;

    /**
     * @var BookService
     */
    private BookService $service;

    /**
     * @var string
     */
    private string $fileBasePath;

    /**
     * @var UploadedFile
     */
    private UploadedFile $uploadFile;

    /**
     * @var BookRepository
     */
    private BookRepository $bookRepository;

    /**
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

        // この feature テストで使う user を作成、保存
        $this->user = User::factory()->create();
        Auth::setUser($this->user); // ログインユーザーとしてセット

        // ファイルが保存されるディレクトリパス
        $this->service = new BookService(new BookRepository());

        // ファイル格納用ディレクトリパス
        $this->fileBasePath = $this->service->getFileBasePath($this->user->id);

        // テスト用の book
        $this->book = Book::factory()->for($this->user)->create();

        // テスト用のアップロードファイル
        Storage::fake('public');
        $this->uploadFile = UploadedFile::fake()->image('defaultTest.jpg');
    }

    /**
     * test index()
     * @return void
     */
    public function testIndex(): void
    {
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
        $response = $this
            ->actingAs($this->user)
            ->post(route('books.store'), [
                'file' => $this->uploadFile,
                'filename' => 'filename_test',
                'size' => 10,
                'height' => 10,
                'width' => 10,
                'lastModified' => now(),
            ]);

        // ファイルが生成されたことを確認
        Storage::disk('public')->assertExists($this->fileBasePath . '/' .  $this->uploadFile->hashName());

        // アップロード後、index にリダイレクトされることを確認
        $response->assertRedirect(route('books.index'));
    }

    /**
     * @return void
     */
    public function testEdit(): void
    {
        $response = $this->actingAs($this->user)
            ->get(route('books.edit', $this->book->id));

        $response->assertOk();
        $response->assertInertia(fn(AssertInertia $page) => $page
            ->has('book')
            ->has('types')
        );
    }

    /**
     * @return void
     */
    public function testUpdate(): void
    {
        $response = $this
            ->actingAs($this->user)
            ->patch(route('books.update', $this->book->id));

        $response->assertRedirect(route('books.edit', $this->book->id));
    }

    /**
     * @return void
     */
    public function testDestroy() :void
    {
        $response = $this
            ->actingAs($this->user)
            ->delete(route('books.destroy', $this->book->id));

        $response->assertRedirect(route('books.index'));
    }
}
