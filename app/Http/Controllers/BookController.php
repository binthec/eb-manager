<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookStoreRequest;
use App\Http\Requests\BookUpdateRequest;
use App\Models\Book;
use App\Services\Admin\BookService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class BookController extends Controller
{
    /**
     * @var BookService
     */
    private BookService $service;

    /**
     * @var string
     */
    private string $fileBasePath;

    /**
     * @param BookService $service
     */
    public function __construct(BookService $service)
    {
        $this->service = $service;
        $this->fileBasePath = $this->service->getFileBasePath(Auth::id());
    }

    /**
     * 一覧
     * @return Response
     */
    public function index(): Response
    {
        return Inertia::render('Books/Index', [
            'books' => $this->service->findByUserId(Auth::id()),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * 新規登録処理
     * @param BookStoreRequest $request
     * @return RedirectResponse
     */
    public function store(BookStoreRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        // ファイルをストレージに保存
        $validated['filepath'] = $request->file->store($this->fileBasePath, 'public');
        // DBに情報を保存
        $this->service->create($validated);

        return redirect(route('books.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        //
    }

    /**
     * 編集画面表示
     * @param Book $book
     * @return Response
     */
    public function edit(Book $book): Response
    {
        return Inertia::render('Books/Edit', [
            'book' => $book,
            'types' => $this->service->getTypeLabel(),
        ]);
    }

    /**
     * 更新処理
     * @param BookUpdateRequest $request
     * @param Book $book
     * @return RedirectResponse
     */
    public function update(BookUpdateRequest $request, Book $book): RedirectResponse
    {
        sleep(1);
        Gate::authorize('update', $book);

        $validated = $request->validated();
        $this->service->update($book->id, $validated);

        return redirect(route('books.edit', $book->id));
    }

    /**
     * 削除処理
     * @param Book $book
     * @return RedirectResponse
     */
    public function destroy(Book $book): RedirectResponse
    {
        sleep(1);

        Gate::authorize('delete', $book);

        // ファイルの実体を削除。削除出来たら、DBレコードも削除
        if (Storage::delete($book->filepath)) {
            $book->delete();
        }

        return redirect(route('books.index'));
    }
}
