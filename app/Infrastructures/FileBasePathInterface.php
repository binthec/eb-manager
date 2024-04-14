<?php

namespace App\Infrastructures;


/**
 * ファイルの格納パスを返すメソッド
 */
interface FileBasePathInterface
{
    public function getFileBasePath(): string;
}
