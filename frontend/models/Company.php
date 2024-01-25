<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "company".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $image
 * @property string|null $address
 * @property string|null $phone
 * @property int|null $status
 * @property string|null $started_at
 */
class Company extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'company';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status'], 'integer'],
            [['started_at'], 'safe'],
            [['name', 'image', 'address', 'phone'], 'string', 'max' => 255],
            [['name'], 'unique'],
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
            'image' => 'Image',
            'address' => 'Address',
            'phone' => 'Phone',
            'status' => 'Status',
            'started_at' => 'Started At',
        ];
    }
}
