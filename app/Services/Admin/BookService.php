<?php

namespace App\Services\Admin;

use App\Infrastructures\FileBasePathInterface;
use App\Utilities\FormUtility;

class BookService extends AdminService implements FileBasePathInterface
{
    /**
     * ファイル保存用ディレクトリを返す
     *
     * @param string|null $user_id
     * @return string
     */
    public function getFileBasePath(string $user_id = null): string
    {
        return 'books/' . $this->user->id . '/';
    }

    /**
     * 書類種別ラベル
     *
     * @return array
     */
    public function getTypeLabel() : array
    {
        return FormUtility::BOOK_TYPE_LABEL;
    }
}
