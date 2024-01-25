<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var frontend\models\CleanItem $model */

$this->title = 'Update Clean Item: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Clean Items', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="clean-item-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
