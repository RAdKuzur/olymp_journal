<?php

namespace common\components\dictionaries;

class CategoryDictionary extends BaseDictionary
{
    public const CATEGORY_9 = 9;
    public const CATEGORY_10 = 10;
    public const CATEGORY_11 = 11;
    public function getList(){
        return [
            self::CATEGORY_9 => '9 класс',
            self::CATEGORY_10 => '10 класс',
            self::CATEGORY_11 => '11 класс',
        ];
    }
    public function customSort()
    {
        return [
            self::CATEGORY_9,
            self::CATEGORY_10,
            self::CATEGORY_11,
        ];
    }
}