<?php

namespace common\components\dictionaries;

class RegionDictionary extends BaseDictionary
{
    public const RUSSIA = 1;
    public const ASTRAKHAN_REGION = 2;
    public function getList(){
        return [
            self::RUSSIA => 'Россия',
            self::ASTRAKHAN_REGION => 'Астраханская область',
        ];
    }
    public function customSort()
    {
        return [
            self::RUSSIA,
            self::ASTRAKHAN_REGION,
        ];
    }
}