<?php

namespace App\Services\Admin;

use App\Interfaces\BookRepositoryInterface;
use App\Interfaces\FileBasePathInterface;
use App\Utilities\FormUtility;
use Illuminate\Support\Collection;

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
