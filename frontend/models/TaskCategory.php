<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "task_category".
 *
 * @property int $id
 * @property string $title
 * @property string|null $icon
 *
 * @property Task[] $tasks
 */
class TaskCategory extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'task_category';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['title'], 'string', 'max' => 30],
            [['icon'], 'string', 'max' => 255],
            [['title'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'icon' => 'Icon',
        ];
    }

    /**
     * Gets query for [[Tasks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTasks()
    {
        return $this->hasMany(Task::className(), ['category_id' => 'id']);
    }
}
