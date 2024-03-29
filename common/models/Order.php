<?php

namespace common\models;

use frontend\models\Customer;
use common\models\OrderItem;
use Yii;

/**
 * This is the model class for table "order".
 *
 * @property int $id
 * @property int|null $customer_id
 * @property int|null $record_id
 * @property string|null $date
 * @property string|null $submit_date
 * @property string|null $status
 * @property string|null $discount_type
 * @property string|null $discount_item
 * @property string|null $discount_amount
 * @property string|null $finish_discount_price
 * @property string|null $driver_id
 * @property string|null $is_reclean
 * @property string|null $comment
 * @property string|null $created_at
 *
 * @property Customer $customer
 * @property OrderItem[] $orderItems
 */
class Order extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'order';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['customer_id', 'record_id','finish_discount_price'], 'integer'],
            [['date'], 'safe'],
            [['status', 'comment'], 'string', 'max' => 255],
            [['customer_id'], 'exist', 'skipOnError' => true, 'targetClass' => Customer::class, 'targetAttribute' => ['customer_id' => 'id']],
        ];
    }
    public function fields()
    {
        return [
            'id',
            'customer',
            'orderitem',
            'record_id',
            'date',
            'status',
            'finish_discount_price',
            'driver',
            'comment',
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
            'record_id' => 'Record ID',
            'date' => 'Date',
            'status' => 'Status',
            'finish_discount_price' => 'Finish Discount Price', // Add this line
            'comment' => 'Comment',
        ];
    }

    /**
     * Gets query for [[Customer]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCustomer()
    {
        return $this->hasOne(Customer::class, ['id' => 'customer_id']);
    }

    /**
     * Gets query for [[OrderItems]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrderitem()
    {
        return $this->hasMany(OrderItem::class, ['order_id' => 'id']);
    }
    public function getDriver()
    {
        if ($this->driver_id == 0){
            return $this->driver_id;
        }else{
            return $this->hasOne(User::class, ['id' => 'driver_id']);
        }
    }
}
