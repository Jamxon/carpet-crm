<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var frontend\models\Attendance $model */

$this->title = 'Create Attendance';
$this->params['breadcrumbs'][] = ['label' => 'Attendances', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="attendance-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
