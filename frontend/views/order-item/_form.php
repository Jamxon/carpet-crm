<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var frontend\models\OrderItem $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="order-item-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'clean_item_id')->textInput() ?>

    <?= $form->field($model, 'order_id')->textInput() ?>

    <?= $form->field($model, 'size')->textInput() ?>

    <?= $form->field($model, 'count')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
