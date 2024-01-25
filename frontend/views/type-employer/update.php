<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var frontend\models\TypeEmployer $model */

$this->title = 'Update Type Employer: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Type Employers', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="type-employer-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
