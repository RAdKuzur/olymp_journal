<?php

namespace frontend\models\olymp;

use Yii;

/**
 * This is the model class for table "subject".
 *
 * @property int $id
 * @property string $name
 *
 * @property SubjectCategory[] $subjectCategories
 */
class Subject extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'subject';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 1000],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
        ];
    }

    /**
     * Gets query for [[SubjectCategories]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSubjectCategories()
    {
        return $this->hasMany(SubjectCategory::class, ['subject_id' => 'id']);
    }

}