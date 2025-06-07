<?php

namespace common\components\dictionaries;

use function Symfony\Component\String\s;

class CountryDictionary extends BaseDictionary
{
    public const RUSSIA = 1;
    public function getList(){
        return [
            self::RUSSIA => 'Россия'
        ];
    }
    public function customSort()
    {
        return [
            self::RUSSIA
        ];
    }
}