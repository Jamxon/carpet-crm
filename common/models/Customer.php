<?php

namespace common\models;

use frontend\models\Order;
use Yii;

/**
 * This is the model class for table "customer".
 *
 * @property int $id
 * @property int|null $employer_id
 * @property string|null $name
 * @property string|null $phone_1
 * @property string|null $phone_2
 * @property string|null $address
 * @property string|null $date
 * @property string|null $source
 * @property string|null $level
 * @property string|null $comment
 * @property string|null $created_at
 * @property Order[] $orders
 */
class Customer extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'customer';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['employer_id'], 'integer'],
            [['name', 'phone_1', 'phone_2', 'address', 'source', 'level', 'comment'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'employer_id' => 'Employer ID',
            'name' => 'Name',
            'phone_1' => 'Phone 1',
            'phone_2' => 'Phone 2',
            'address' => 'Address',
            'date' => 'Date',
            'source' => 'Source',
            'level' => 'Level',
            'comment' => 'Comment',
        ];
    }

    /**
     * Gets query for [[Orders]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Order::class, ['customer_id' => 'id']);
    }
}
