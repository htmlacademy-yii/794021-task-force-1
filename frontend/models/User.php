<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $fullname
 * @property string $email
 * @property string $password_hash
 * @property string|null $avatar_file
 * @property string|null $description
 * @property int $city_id
 * @property string|null $birthday
 * @property string|null $phone
 * @property string|null $skype
 * @property string|null $telegram
 * @property int|null $notify_on_message
 * @property int|null $notify_on_task_changes
 * @property int|null $notify_on_review
 * @property int|null $show_contacts_only_to_customer
 * @property int|null $hide_profile
 * @property int|null $is_logged_in
 * @property string $website_last_action_datetime
 * @property string $datetime_created
 *
 * @property City $city
 * @property ContractorApplication[] $contractorApplications
 * @property ContractorOccupation[] $contractorOccupations
 * @property User[] $contractors
 * @property User[] $customers
 * @property FavoriteContractor[] $favoriteContractors
 * @property FavoriteContractor[] $favoriteContractors0
 * @property Message[] $messages
 * @property TaskCategory[] $occupations
 * @property Review[] $reviews
 * @property Review[] $reviews0
 * @property Task[] $tasks
 * @property Task[] $tasks0
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fullname', 'email', 'password_hash', 'city_id'], 'required'],
            [['city_id', 'notify_on_message', 'notify_on_task_changes', 'notify_on_review', 'show_contacts_only_to_customer', 'hide_profile', 'is_logged_in'], 'integer'],
            [['birthday', 'website_last_action_datetime', 'datetime_created'], 'safe'],
            [['fullname', 'password_hash', 'avatar_file', 'description'], 'string', 'max' => 255],
            [['email'], 'string', 'max' => 254],
            [['phone'], 'string', 'max' => 25],
            [['skype', 'telegram'], 'string', 'max' => 100],
            [['email'], 'unique'],
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
            'fullname' => 'Fullname',
            'email' => 'Email',
            'password_hash' => 'Password Hash',
            'avatar_file' => 'Avatar File',
            'description' => 'Description',
            'city_id' => 'City ID',
            'birthday' => 'Birthday',
            'phone' => 'Phone',
            'skype' => 'Skype',
            'telegram' => 'Telegram',
            'notify_on_message' => 'Notify On Message',
            'notify_on_task_changes' => 'Notify On Task Changes',
            'notify_on_review' => 'Notify On Review',
            'show_contacts_only_to_customer' => 'Show Contacts Only To Customer',
            'hide_profile' => 'Hide Profile',
            'is_logged_in' => 'Is Logged In',
            'website_last_action_datetime' => 'Website Last Action Datetime',
            'datetime_created' => 'Datetime Created',
        ];
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
     * Gets query for [[ContractorApplications]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getContractorApplications()
    {
        return $this->hasMany(ContractorApplication::className(), ['applicant_id' => 'id']);
    }

    /**
     * Gets query for [[ContractorOccupations]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getContractorOccupations()
    {
        return $this->hasMany(ContractorOccupation::className(), ['contractor_id' => 'id']);
    }

    /**
     * Gets query for [[Contractors]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getContractors()
    {
        return $this->hasMany(User::className(), ['id' => 'contractor_id'])->viaTable('favorite_contractor', ['customer_id' => 'id']);
    }

    /**
     * Gets query for [[Customers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCustomers()
    {
        return $this->hasMany(User::className(), ['id' => 'customer_id'])->viaTable('favorite_contractor', ['contractor_id' => 'id']);
    }

    /**
     * Gets query for [[FavoriteContractors]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFavoriteContractors()
    {
        return $this->hasMany(FavoriteContractor::className(), ['customer_id' => 'id']);
    }

    /**
     * Gets query for [[FavoriteContractors0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFavoriteContractors0()
    {
        return $this->hasMany(FavoriteContractor::className(), ['contractor_id' => 'id']);
    }

    /**
     * Gets query for [[Messages]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMessages()
    {
        return $this->hasMany(Message::className(), ['sender_id' => 'id']);
    }

    /**
     * Gets query for [[Occupations]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOccupations()
    {
        return $this->hasMany(TaskCategory::className(), ['id' => 'occupation_id'])->viaTable('contractor_occupation', ['contractor_id' => 'id']);
    }

    /**
     * Gets query for [[Reviews]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReviews()
    {
        return $this->hasMany(Review::className(), ['contractor_id' => 'id']);
    }

    /**
     * Gets query for [[Reviews0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReviews0()
    {
        return $this->hasMany(Review::className(), ['customer_id' => 'id']);
    }

    /**
     * Gets query for [[Tasks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTasks()
    {
        return $this->hasMany(Task::className(), ['customer_id' => 'id']);
    }

    /**
     * Gets query for [[Tasks0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTasks0()
    {
        return $this->hasMany(Task::className(), ['contractor_id' => 'id']);
    }
}
