<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var frontend\models\TypeEmployer $model */

$this->title = 'Create Type Employer';
$this->params['breadcrumbs'][] = ['label' => 'Type Employers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="type-employer-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
