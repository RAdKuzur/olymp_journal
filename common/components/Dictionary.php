<?php

namespace common\components;

class Dictionary
{
    public const MALE = 0;
    public const FEMALE = 1;
    public const HEALTHY = 0;
    public const DISABILITY = 1;
    public const RUSSIA = 1;

    public static function getSex(){
        return [
            self::MALE => 'Мужской',
            self::FEMALE => 'Женский'
        ];
    }
    public static function getCountry()
    {
        return [
            self::RUSSIA => 'РФ',
        ];
    }
    public static function getOVZ(){
        return [
            self::HEALTHY => 'Нет ОВЗ',
            self::DISABILITY => 'Есть ОВЗ'
        ];
    }
}