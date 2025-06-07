<?php

namespace frontend\models\olymp;

use common\components\dictionaries\DisabilityDictionary;
use common\components\dictionaries\GenderDictionary;
use Yii;

/**
 * This is the model class for table "participant".
 *
 * @property int $id
 * @property string $surname
 * @property string $name
 * @property string|null $patronymic
 * @property string $phone_number
 * @property int $sex
 * @property string $birthdate
 * @property int $citizenship
 * @property int $school_id
 * @property int $disability
 * @property int $class
 *
 * @property Application[] $applications
 * @property School $school
 */
class Participant extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'participant';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['patronymic'], 'default', 'value' => null],
            [['surname', 'name', 'phone_number', 'sex', 'birthdate', 'citizenship', 'school_id', 'disability', 'class'], 'required'],
            [['sex', 'citizenship', 'school_id', 'disability', 'class'], 'integer'],
            [['birthdate'], 'safe'],
            [['surname', 'name', 'patronymic'], 'string', 'max' => 256],
            [['phone_number'], 'string', 'max' => 64],
            [['school_id'], 'exist', 'skipOnError' => true, 'targetClass' => School::class, 'targetAttribute' => ['school_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'surname' => 'Surname',
            'name' => 'Name',
            'patronymic' => 'Patronymic',
            'phone_number' => 'Phone Number',
            'sex' => 'Sex',
            'birthdate' => 'Birthdate',
            'citizenship' => 'Citizenship',
            'school_id' => 'School ID',
            'disability' => 'Disability',
            'class' => 'Class',
        ];
    }

    /**
     * Gets query for [[Applications]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getApplications()
    {
        return $this->hasMany(Application::class, ['participant_id' => 'id']);
    }

    /**
     * Gets query for [[School]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSchool()
    {
        return $this->hasOne(School::class, ['id' => 'school_id']);
    }
    public function getFullFio()
    {
        return $this->surname . ' ' . $this->name . ' ' . $this->patronymic;
    }
    public function getGender()
    {
        return $this->sex == GenderDictionary::MALE ? 'Мужской' : 'Женский';
    }
    public function getOvz()
    {
        return $this->disability == DisabilityDictionary::HEALTHY ? 'Нет ОВЗ' : 'Есть ОВЗ';
    }
}