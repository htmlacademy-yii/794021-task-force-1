<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "favorite_contractor".
 *
 * @property int $id
 * @property int $customer_id
 * @property int $contractor_id
 *
 * @property User $contractor
 * @property User $customer
 */
class FavoriteContractor extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'favorite_contractor';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['customer_id', 'contractor_id'], 'required'],
            [['customer_id', 'contractor_id'], 'integer'],
            [['customer_id', 'contractor_id'], 'unique', 'targetAttribute' => ['customer_id', 'contractor_id']],
            [['customer_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['customer_id' => 'id']],
            [['contractor_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['contractor_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'customer_id' => 'Customer ID',
            'contractor_id' => 'Contractor ID',
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
     * Gets query for [[Customer]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCustomer()
    {
        return $this->hasOne(User::className(), ['id' => 'customer_id']);
    }
}
