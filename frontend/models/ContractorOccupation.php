<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "contractor_occupation".
 *
 * @property int $id
 * @property int $contractor_id
 * @property int $occupation_id
 *
 * @property User $contractor
 * @property TaskCategory $occupation
 */
class ContractorOccupation extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'contractor_occupation';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['contractor_id', 'occupation_id'], 'required'],
            [['contractor_id', 'occupation_id'], 'integer'],
            [['contractor_id', 'occupation_id'], 'unique', 'targetAttribute' => ['contractor_id', 'occupation_id']],
            [['contractor_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['contractor_id' => 'id']],
            [['occupation_id'], 'exist', 'skipOnError' => true, 'targetClass' => TaskCategory::className(), 'targetAttribute' => ['occupation_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'contractor_id' => 'Contractor ID',
            'occupation_id' => 'Occupation ID',
        ];
    }

    /**
     * Gets query for [[Contractor]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getContractor()
    {
        return $this->hasOne(User::className(), ['id' => 'contractor_id']);
    }

    /**
     * Gets query for [[Occupation]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOccupation()
    {
        return $this->hasOne(TaskCategory::className(), ['id' => 'occupation_id']);
    }
}
