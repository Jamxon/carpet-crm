<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var frontend\models\OrderItem $model */

$this->title = 'Create Order Item';
$this->params['breadcrumbs'][] = ['label' => 'Order Items', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-item-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
