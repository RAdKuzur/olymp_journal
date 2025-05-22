<?php

namespace frontend\olymp\models;

use Yii;

/**
 * This is the model class for table "application".
 *
 * @property int $id
 * @property int $participant_id
 * @property string $code
 * @property int $subject_category_id
 *
 * @property Appearance[] $appearances
 * @property Participant $participant
 * @property SubjectCategory $subjectCategory
 * @property TaskApplication[] $taskApplications
 */
class Application extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'application';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['participant_id', 'code', 'subject_category_id'], 'required'],
            [['participant_id', 'subject_category_id'], 'integer'],
            [['code'], 'string', 'max' => 64],
            [['participant_id'], 'exist', 'skipOnError' => true, 'targetClass' => Participant::class, 'targetAttribute' => ['participant_id' => 'id']],
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
            'participant_id' => 'Participant ID',
            'code' => 'Code',
            'subject_category_id' => 'Subject Category ID',
        ];
    }

    /**
     * Gets query for [[Appearances]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAppearances()
    {
        return $this->hasMany(Appearance::class, ['application_id' => 'id']);
    }

    /**
     * Gets query for [[Participant]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getParticipant()
    {
        return $this->hasOne(Participant::class, ['id' => 'participant_id']);
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
        return $this->hasMany(TaskApplication::class, ['application_id' => 'id']);
    }

}