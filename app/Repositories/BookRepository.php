<?php

namespace App\Repositories;

use App\Interfaces\BookRepositoryInterface;
use App\Models\Book;
use Illuminate\Support\Collection;


class BookRepository implements BookRepositoryInterface
{
    /**
     * @return Collection
     */
    public function getAllBooks(): Collection
    {
        return Book::all();
    }

    /**
     * @param string $userId
     * @param bool $latest
     * @return Collection
     */
    public function findByUserId(string $userId, bool $latest = true): Collection
    {
        $query = Book::where('user_id', $userId)->with('user:id,name');
        if($latest) $query->latest(); // 昇順指定ある場合は latest() をつける

        return $query->get();
    }

    /**
     * @param $bookId
     * @return Book
     */
    public function findById($bookId): Book
    {
        return Book::findOrFail($bookId);
    }

    /**
     * @param array $bookDetails
     * @return Book
     */
    public function createBook(array $bookDetails) :Book
    {
        return Book::create($bookDetails);
    }

    /**
     * @param $bookId
     * @param array $newDetails
     * @return Book
     */
    public function updateBook($bookId, array $newDetails) :Book
    {
        return Book::whereId($bookId)->update($newDetails);
    }

    /**
     * @param $bookId
     * @return bool
     */
    public function deleteBook($bookId) :bool
    {
        Book::destroy($bookId);
    }
}
