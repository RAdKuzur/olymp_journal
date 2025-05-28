<?php

namespace common\repositories;

use frontend\models\olymp\School;

class SchoolRepository
{
    public function getAll(){
        return School::find()->all();
    }
}