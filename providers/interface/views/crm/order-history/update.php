<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var crm\models\OrderHistory $model */

$this->title = 'Update Order History: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Order Histories', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="order-history-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
