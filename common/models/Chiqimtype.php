<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "
 * @property int $id
 * @property string $name
 */

class Chiqimtype extends ActiveRecord
{
    public static function tableName()
    {
        return 'chiqimtype';
    }

    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string'],
        ];
    }
}