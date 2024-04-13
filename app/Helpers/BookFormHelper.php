<?php

class BookFormHelper
{
    /**
     * 書類種別ラベル
     */
    private const TYPE_LABEL = [
        1 => '領収書',
        2 => '通帳',
        3 => '入出金明細',
        4 => '納税証明書',
        5 => '払込書'
    ];

    /**
     *
     *
     * @return string[]
     */
    public function getTypeLabel(): array
    {
        return self::TYPE_LABEL;
    }
}
