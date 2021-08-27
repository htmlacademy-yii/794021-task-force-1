<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "contractor_application".
 *
 * @property int $id
 * @property int $task_id
 * @property int $applicant_id
 * @property int $budget
 * @property string|null $text
 * @property string $datetime_created
 *
 * @property User $applicant
 * @property Task $task
 */
class ContractorApplication extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'contractor_application';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['task_id', 'applicant_id', 'budget'], 'required'],
            [['task_id', 'applicant_id', 'budget'], 'integer'],
            [['datetime_created'], 'safe'],
            [['text'], 'string', 'max' => 2000],
            [['task_id'], 'exist', 'skipOnError' => true, 'targetClass' => Task::className(), 'targetAttribute' => ['task_id' => 'id']],
            [['applicant_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['applicant_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'task_id' => 'Task ID',
            'applicant_id' => 'Applicant ID',
            'budget' => 'Budget',
            'text' => 'Text',
            'datetime_created' => 'Datetime Created',
        ];
    }

    /**
     * Gets query for [[Applicant]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getApplicant()
    {
        return $this->hasOne(User::className(), ['id' => 'applicant_id']);
    }

    /**
     * Gets query for [[Task]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTask()
    {
        return $this->hasOne(Task::className(), ['id' => 'task_id']);
    }
}
