<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "
 * @property int $id
 * @property string $type_id
 * @property string $miqdor
 * @property string $comment
 * @property string $created_at
 */

class Chiqim extends ActiveRecord
{
    public static function tableName()
    {
        return 'chiqim';
    }

    public function fields()
    {
        return [
            'id',
            'chiqimtype',
            'miqdor',
            'comment',
        ];
    }

    public function rules()
    {
        return [
            [['type_id', 'miqdor'], 'required'],
            [['type_id', 'miqdor'], 'string'],
            [['comment'], 'string'],
            [['created_at'], 'safe'],
        ];
    }

    public function getChiqimtype()
    {
        return $this->hasOne(Chiqimtype::className(), ['id' => 'type_id']);
    }
}