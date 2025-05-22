<?php

namespace frontend\models\olymp;

use Yii;

/**
 * This is the model class for table "appearance".
 *
 * @property int $id
 * @property int $application_id
 * @property int $status
 * @property int $auditorium
 *
 * @property Application $application
 */
class Appearance extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'appearance';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['application_id', 'status', 'auditorium'], 'required'],
            [['application_id', 'status', 'auditorium'], 'integer'],
            [['application_id'], 'exist', 'skipOnError' => true, 'targetClass' => Application::class, 'targetAttribute' => ['application_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'application_id' => 'Application ID',
            'status' => 'Status',
            'auditorium' => 'Auditorium',
        ];
    }

    /**
     * Gets query for [[Application]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getApplication()
    {
        return $this->hasOne(Application::class, ['id' => 'application_id']);
    }

}