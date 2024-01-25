<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var frontend\models\CleanItem $model */

$this->title = 'Create Clean Item';
$this->params['breadcrumbs'][] = ['label' => 'Clean Items', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="clean-item-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
