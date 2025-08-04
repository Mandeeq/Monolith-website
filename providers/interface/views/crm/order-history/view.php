<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var crm\models\OrderHistory $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Order Histories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="order-history-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'customer_id',
            'order_number',
            'product_id',
            'product_name',
            'quantity',
            'unit_price',
            'total_price',
            'order_status',
            'payment_status',
            'ordered_at',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
