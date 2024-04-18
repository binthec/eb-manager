<?php

namespace App\Services\Admin;

use App\Interfaces\BookRepositoryInterface;
use App\Interfaces\FileBasePathInterface;
use App\Models\Book;
use App\Utilities\FormUtility;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class BookService extends AdminService implements FileBasePathInterface
{

    /**
     * @var BookRepositoryInterface
     */
    private BookRepositoryInterface $bookRepository;

    /**
     * @param BookRepositoryInterface $bookRepository
     */
    public function __construct(BookRepositoryInterface $bookRepository)
    {
        $this->bookRepository = $bookRepository;
    }

    /**
     * @param string $userId
     * @param bool $latest
     * @return Collection
     */
    public function findByUserId(string $userId, bool $latest = true): Collection
    {
        return $this->bookRepository->findByUserId($userId, $latest);
    }

    /**
     * @param array $bookDetails
     * @return Book
     */
    public function create(array $bookDetails): Book
    {
        return $this->bookRepository->create($bookDetails);
    }

    /**
     * @param string $bookId
     * @param array $bookDetail
     * @return bool
     */
    public function update(string $bookId, array $bookDetail) :bool
    {
        return $this->bookRepository->update($bookId, $bookDetail);
    }

    /**
     * @param string $bookId
     * @return bool
     */
    public function destroy(string $bookId) :bool
    {
        return $this->bookRepository->destroy($bookId);
    }

    /**
     * ファイル保存用ディレクトリのパス
     * @param string $userId
     * @return string
     */
    public function getFileBasePath(string $userId): string
    {
        return 'books/' . $userId;
    }

    /**
     * 書類種別ラベル
     *
     * @return array
     */
    public function getTypeLabel(): array
    {
        return FormUtility::BOOK_TYPE_LABEL;
    }
}
