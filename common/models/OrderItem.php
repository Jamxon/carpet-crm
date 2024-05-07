<?php

namespace common\models;

use frontend\models\CleanItem;
use frontend\models\Order;
use Yii;

/**
 * This is the model class for table "order_item".
 *
 * @property int|null $clean_item_id
 * @property int|null $order_id
 * @property int|null $size
 * @property int|null $count
 *
 * @property Cleanitem $cleanItem
 * @property Order $order
 */
class OrderItem extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'order_item';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['clean_item_id', 'order_id',  'count'], 'integer'],
            [['clean_item_id'], 'exist', 'skipOnError' => true, 'targetClass' => CleanItem::class, 'targetAttribute' => ['clean_item_id' => 'id']],
            [['order_id'], 'exist', 'skipOnError' => true, 'targetClass' => Order::class, 'targetAttribute' => ['order_id' => 'id']],
        ];
    }
    public function fields()
    {
        return [
            'id',
            'cleanItem' => function () {
                return $this->cleanItem;
            },
            'order' => function () {
                return $this->order;
            },
            'order_id',
            'clean_item_id',
            'size',
            'count',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'clean_item_id' => 'Clean Item ID',
            'order_id' => 'Order ID',
            'size' => 'Size',
            'count' => 'Count',
        ];
    }

    /**
     * Gets query for [[CleanItem]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCleanItem()
    {
        return $this->hasOne(\common\models\Cleanitem::class, ['id' => 'clean_item_id']);
    }

    /**
     * Gets query for [[Order]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrder()
    {
        return $this->hasOne(Order::class, ['id' => 'order_id']);
    }
}
