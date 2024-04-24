<?php

namespace common\models;

use frontend\models\OrderItem;
use Yii;

/**
 * This is the model class for table "clean_item".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $size
 * @property int|null $price
 * @property int|null $min_price
 *
 * @property OrderItem[] $orderItems
 */
class Cleanitem extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'clean_item';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['price','operator_min_price','status'], 'integer'],
            [['name', 'size'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'size' => 'Size',
            'price' => 'Price',
            'operator_min_price' => 'Min price for Operator',
            'status' => 'Status',
        ];
    }

    /**
     * Gets query for [[OrderItems]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrderItems()
    {
        return $this->hasMany(OrderItem::class, ['clean_item_id' => 'id']);
    }
}
