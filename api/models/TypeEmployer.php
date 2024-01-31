<?php

namespace api\models;

use Yii;

/**
 * This is the model class for table "type_employer".
 *
 * @property int $id
 * @property string|null $name
 */
class TypeEmployer extends \common\models\TypeEmployer
{
    /**
     * {@inheritdoc}
     */
    public function fields()
    {
        return [
            'name'
        ];
    }
}
