<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "task".
 *
 * @property int $id
 * @property string $title
 * @property string|null $text
 * @property int $category_id
 * @property int $state_id
 * @property int $customer_id
 * @property int|null $contractor_id
 * @property int|null $city_id
 * @property string|null $address
 * @property float|null $latitude
 * @property float|null $longitude
 * @property string|null $address_comment
 * @property int|null $budget
 * @property string $due_date
 * @property string $datetime_created
 *
 * @property TaskCategory $category
 * @property City $city
 * @property User $contractor
 * @property ContractorApplication[] $contractorApplications
 * @property User $customer
 * @property Message[] $messages
 * @property Review $review
 * @property TaskState $state
 * @property TaskFile[] $taskFiles
 */
class Task extends \yii\db\ActiveRecord
{
    const STATE_NEW = 1;
    const STATE_DONE = 4;

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
            [['title', 'category_id', 'state_id', 'customer_id', 'due_date'], 'required'],
            [['category_id', 'state_id', 'customer_id', 'contractor_id', 'city_id', 'budget'], 'integer'],
            [['latitude', 'longitude'], 'number'],
            [['due_date', 'datetime_created'], 'safe'],
            [['title', 'address', 'address_comment'], 'string', 'max' => 255],
            [['text'], 'string', 'max' => 2000],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => TaskCategory::className(), 'targetAttribute' => ['category_id' => 'id']],
            [['state_id'], 'exist', 'skipOnError' => true, 'targetClass' => TaskState::className(), 'targetAttribute' => ['state_id' => 'id']],
            [['customer_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['customer_id' => 'id']],
            [['contractor_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['contractor_id' => 'id']],
            [['city_id'], 'exist', 'skipOnError' => true, 'targetClass' => City::className(), 'targetAttribute' => ['city_id' => 'id']],
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
            'text' => 'Text',
            'category_id' => 'Category ID',
            'state_id' => 'State ID',
            'customer_id' => 'Customer ID',
            'contractor_id' => 'Contractor ID',
            'city_id' => 'City ID',
            'address' => 'Address',
            'latitude' => 'Latitude',
            'longitude' => 'Longitude',
            'address_comment' => 'Address Comment',
            'budget' => 'Budget',
            'due_date' => 'Due Date',
            'datetime_created' => 'Datetime Created',
        ];
    }

    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(TaskCategory::className(), ['id' => 'category_id']);
    }

    /**
     * Gets query for [[City]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCity()
    {
        return $this->hasOne(City::className(), ['id' => 'city_id']);
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
     * Gets query for [[ContractorApplications]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getContractorApplications()
    {
        return $this->hasMany(ContractorApplication::className(), ['task_id' => 'id']);
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

    /**
     * Gets query for [[Messages]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMessages()
    {
        return $this->hasMany(Message::className(), ['task_id' => 'id']);
    }

    /**
     * Gets query for [[Review]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReview()
    {
        return $this->hasOne(Review::className(), ['task_id' => 'id']);
    }

    /**
     * Gets query for [[State]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getState()
    {
        return $this->hasOne(TaskState::className(), ['id' => 'state_id']);
    }

    /**
     * Gets query for [[TaskFiles]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTaskFiles()
    {
        return $this->hasMany(TaskFile::className(), ['task_id' => 'id']);
    }
}
