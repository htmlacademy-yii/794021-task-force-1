<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "message".
 *
 * @property int $id
 * @property int $task_id
 * @property int $sender_id
 * @property string $text
 * @property string $datetime_created
 *
 * @property User $sender
 * @property Task $task
 */
class Message extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'message';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['task_id', 'sender_id', 'text'], 'required'],
            [['task_id', 'sender_id'], 'integer'],
            [['datetime_created'], 'safe'],
            [['text'], 'string', 'max' => 200],
            [['task_id'], 'exist', 'skipOnError' => true, 'targetClass' => Task::className(), 'targetAttribute' => ['task_id' => 'id']],
            [['sender_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['sender_id' => 'id']],
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
            'sender_id' => 'Sender ID',
            'text' => 'Text',
            'datetime_created' => 'Datetime Created',
        ];
    }

    /**
     * Gets query for [[Sender]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSender()
    {
        return $this->hasOne(User::className(), ['id' => 'sender_id']);
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
