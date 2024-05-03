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
            'user',
            'type',
            'miqdori',
            'comment',
        ];
    }

    public function rules()
    {
        return [
            [['type_id', 'miqdori','user_id'], 'required'],
            [['type_id','miqdori','user_id'], 'integer'],
            [['comment','miqdori'], 'string'],
            [['created_at'], 'safe'],
        ];
    }

    public function getType()
    {
        return $this->hasOne(Chiqimtype::className(), ['id' => 'type_id']);
    }
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}