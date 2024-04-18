<?php

namespace App\Interfaces;

use App\Models\Book;
use Illuminate\Support\Collection;

interface BookRepositoryInterface
{
    /**
     * 全ての book を取得
     * @return Collection
     */
    public function getAllBooks() :Collection;

    /**
     * ユーザーに紐づく book を全て取得
     * 基本は降順で取得する
     * @param string $userId
     * @param bool $latest
     * @return Collection
     */
    public function findByUserId(string $userId, bool $latest = true) : Collection;

    /**
     * book を取得
     * @param $bookId
     * @return Book
     */
    public function findById($bookId) :Book;

    /**
     * book を作成
     * @param array $bookDetails
     * @return Book
     */
    public function create(array $bookDetails) :Book;

    /**
     * book を更新
     * @param $bookId
     * @param array $bookDetails
     * @return bool
     */
    public function update($bookId, array $bookDetails) :bool;

    /**
     * book を削除
     * @param $bookId
     * @return bool
     */
    public function destroy($bookId):bool;

}
