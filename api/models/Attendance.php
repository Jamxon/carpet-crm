<?php

namespace api\models;

use Yii;

/**
 * This is the model class for table "attendance".
 *
 * @property int $id
 * @property int|null $user_id
 * @property string|null $come_time
 * @property string|null $go_time
 * @property int|null $full_time
 * @property int|null $daily_salary
 * @property string|null $comment
 */
class Attendance extends \common\models\Attendance
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'attendance';
    }
    public function fields()
    {
        return [
            'id',
            'user',
            'come_time',
            'go_time',
            'full_time',
            'daily_salary',
            'comment',
        ];
    }
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'full_time', 'daily_salary'], 'integer'],
            [['come_time', 'go_time'], 'safe'],
            [['comment'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'come_time' => 'Come Time',
            'go_time' => 'Go Time',
            'full_time' => 'Full Time',
            'daily_salary' => 'Daily Salary',
            'comment' => 'Comment',
        ];
    }
}
