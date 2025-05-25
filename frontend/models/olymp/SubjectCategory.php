<?php

namespace frontend\models\olymp;

use Yii;

/**
 * This is the model class for table "subject_category".
 *
 * @property int $id
 * @property int $subject_id
 * @property int $category
 * @property int winner_score
 * @property int prize_score
 *
 * @property Application[] $applications
 * @property Subject $subject
 * @property Task[] $tasks
 */
class SubjectCategory extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'subject_category';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['subject_id', 'category', 'winner_score', 'prize_score'], 'required'],
            [['subject_id', 'category', 'winner_score', 'prize_score'], 'integer'],
            [['subject_id'], 'exist', 'skipOnError' => true, 'targetClass' => Subject::class, 'targetAttribute' => ['subject_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'subject_id' => 'Subject ID',
            'category' => 'Category',
            'winner_score' => 'Winner Score',
            'prize_score' => 'Prize Score',
        ];
    }

    /**
     * Gets query for [[Applications]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getApplications()
    {
        return $this->hasMany(Application::class, ['subject_category_id' => 'id']);
    }

    /**
     * Gets query for [[Subject]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSubject()
    {
        return $this->hasOne(Subject::class, ['id' => 'subject_id']);
    }

    /**
     * Gets query for [[Tasks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTasks()
    {
        return $this->hasMany(Task::class, ['subject_category_id' => 'id']);
    }

}