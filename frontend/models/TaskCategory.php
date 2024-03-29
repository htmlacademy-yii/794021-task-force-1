<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "task_category".
 *
 * @property int $id
 * @property string $title
 * @property string|null $icon
 *
 * @property ContractorOccupation[] $contractorOccupations
 * @property User[] $contractors
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
     * Gets query for [[ContractorOccupations]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getContractorOccupations()
    {
        return $this->hasMany(ContractorOccupation::className(), ['occupation_id' => 'id']);
    }

    /**
     * Gets query for [[Contractors]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getContractors()
    {
        return $this->hasMany(User::className(), ['id' => 'contractor_id'])->viaTable('contractor_occupation', ['occupation_id' => 'id']);
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
