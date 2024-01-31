<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var frontend\models\Attendance $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="attendance-form">
    <?php $form = ActiveForm::begin(); ?>

    <?php //user select option
    $user = \frontend\models\User::find()->all();
    $listData = \yii\helpers\ArrayHelper::map($user,'id','username');
    echo $form->field($model, 'user_id')->dropDownList($listData,['prompt'=>'Select...']);

    ?>

    <?= $form->field($model, 'come_time')->input('datetime-local') ?>

    <?= $form->field($model, 'go_time')->input('datetime-local') ?>

    <?= $form->field($model, 'full_time')->input('number') ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'daily_salary')->textInput() ?>

    <?= $form->field($model, 'comment')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
