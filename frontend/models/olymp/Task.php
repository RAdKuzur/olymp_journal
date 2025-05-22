<?php

namespace frontend\models\olymp;

use Yii;

/**
 * This is the model class for table "task".
 *
 * @property int $id
 * @property int $subject_category_id
 * @property int $number
 * @property int $max_points
 *
 * @property SubjectCategory $subjectCategory
 * @property TaskApplication[] $taskApplications
 */
class Task extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'task';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['subject_category_id', 'number', 'max_points'], 'required'],
            [['subject_category_id', 'number', 'max_points'], 'integer'],
            [['subject_category_id'], 'exist', 'skipOnError' => true, 'targetClass' => SubjectCategory::class, 'targetAttribute' => ['subject_category_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'subject_category_id' => 'Subject Category ID',
            'number' => 'Number',
            'max_points' => 'Max Points',
        ];
    }

    /**
     * Gets query for [[SubjectCategory]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSubjectCategory()
    {
        return $this->hasOne(SubjectCategory::class, ['id' => 'subject_category_id']);
    }

    /**
     * Gets query for [[TaskApplications]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTaskApplications()
    {
        return $this->hasMany(TaskApplication::class, ['task_id' => 'id']);
    }

}
