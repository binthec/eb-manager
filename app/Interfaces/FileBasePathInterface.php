<?php

namespace App\Interfaces;


/**
 * ファイルの格納パスを返すメソッド
 */
interface FileBasePathInterface
{
    /**
     * ファイル保存用ディレクトリのパスを返す
     * @param string $userId
     * @return string
     */
    public function getFileBasePath(string $userId): string;
}
