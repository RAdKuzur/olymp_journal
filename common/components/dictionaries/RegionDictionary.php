<?php

namespace common\components\dictionaries;

class RegionDictionary extends BaseDictionary
{
    public const ASTRAKHAN_REGION = 30;
    public function getList(){
        return [
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