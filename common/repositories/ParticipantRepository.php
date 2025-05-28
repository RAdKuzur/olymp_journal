<?php

namespace common\repositories;

use frontend\models\olymp\Participant;

class ParticipantRepository
{
    public function get($id)
    {
        return Participant::findOne($id);
    }
    public function getAll()
    {
        return Participant::find()->all();
    }
    public function save(Participant $participant){
        if(!$participant->save()){
            throw new \RuntimeException('Saving error.');
        }
    }
    public function delete(Participant $participant){
        if(!$participant->delete()){
            throw new \RuntimeException('Delete error.');
        }
    }
}