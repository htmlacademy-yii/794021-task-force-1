<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "task_file".
 *
 * @property int $id
 * @property int $task_id
 * @property string $display_name
 * @property string $saved_name
 *
 * @property Task $task
 */
class TaskFile extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'task_file';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['task_id', 'display_name', 'saved_name'], 'required'],
            [['task_id'], 'integer'],
            [['display_name'], 'string', 'max' => 512],
            [['saved_name'], 'string', 'max' => 255],
            [['task_id'], 'exist', 'skipOnError' => true, 'targetClass' => Task::className(), 'targetAttribute' => ['task_id' => 'id']],
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
            'display_name' => 'Display Name',
            'saved_name' => 'Saved Name',
        ];
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
