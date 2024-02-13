<?php

namespace api\models;

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
class Company extends \common\models\Company
{
    /**
     * {@inheritdoc}
     */

    public function fields()
    {
        return [
            'name',
            'image',
            'address',
            'phone',
            'status'
        ];
    }
}
