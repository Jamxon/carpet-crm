<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var frontend\models\CustomerSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="customer-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'employer_id') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'phone_1') ?>

    <?= $form->field($model, 'phone_2') ?>

    <?php // echo $form->field($model, 'address') ?>

    <?php // echo $form->field($model, 'source') ?>

    <?php // echo $form->field($model, 'level') ?>

    <?php // echo $form->field($model, 'comment') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
