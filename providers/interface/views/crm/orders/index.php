<?php

use crm\models\Orders;
use helpers\Html;
use yii\helpers\Url;
use helpers\grid\GridView;

/** @var yii\web\View $this */
/** @var crm\models\searches\OrderSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Orders';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="orders-index row">
    <div class="col-md-12">
      <div class="block block-rounded">
        <div class="block-header block-header-default">
          <h3 class="block-title"><?= Html::encode($this->title) ?> </h3>
          <div class="block-options">
          <?=  Html::customButton([
            'type' => 'modal',
            'url' => Url::to(['create']),
            'appearence' => [
              'type' => 'text',
              'text' => 'Create Orders',
              'theme' => 'primary',
              'visible' => Yii::$app->user->can('crm-orders-create', true)
            ],
            'modal' => ['title' => 'New Orders']
          ]) ?>
          </div> 
        </div>
        <div class="block-content">     
    <div class="orders-search my-3">
    <?= $this->render('_search', ['model' => $searchModel]); ?>
    </div>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'order_number',
            'customer_id',
            [
              'attribute' => 'status',
              'format' => 'raw',
              'value' => function ($model) {
                switch ($model->status) {
                  case 1:
                    return '<span class="badge bg-success">Delivered</span>';
                  case 0:
                    return '<span class="badge bg-danger">Cancelled</span>';
                  case 2:
                    return '<span class="badge bg-info">Processing</span>';
                  case 3:
                    return '<span class="badge bg-primary">Shipped</span>';
                  case 4:
                    return '<span class="badge bg-danger">Cancelled</span>';
                  default:
                    return '<span class="badge bg-secondary">Unknown</span>';
                }
              },
            ],
            'payment_method',
            //'total_amount',
            //'created_at',
            //'updated_at',
            //'is_deleted',
            [
                'class' => \helpers\grid\ActionColumn::className(),
                'template' => '{update} {trash}',
                'headerOptions' => ['width' => '8%'],
                'contentOptions' => ['style'=>'text-align: center;'],
                 'buttons' => [
                    'update' => function ($url, $model, $key) {
                        return Html::customButton(['type' => 'modal', 'url' => Url::toRoute(['update', 'id' => $model->id]), 'modal' => ['title' => 'Update  Orders'], 'appearence' => ['icon' => 'edit', 'theme' => '', 'class' => 'text-primary']]);
                    },
                    'trash' => function ($url, $model, $key) {
                        return $model->is_deleted !== 1 ?
                            Html::customButton(['type' => 'link', 'url' => Url::toRoute(['trash', 'id' => $model->id]),  'appearence' => ['icon' => 'trash', 'theme' => '', 'class' => 'text-danger', 'data' => ['message' => 'Do you want to delete this orders?']]]) :
                            Html::customButton(['type' => 'link', 'url' => Url::toRoute(['trash', 'id' => $model->id]),  'appearence' => ['icon' => 'undo', 'theme' => '', 'class' => 'text-danger', 'data' => ['message' => 'Do you want to restore this orders?']]]);
                    },
                ],
                'visibleButtons' => [
                    'update' => Yii::$app->user->can('crm-orders-update',true),
                    'trash' => function ($model){
                         return $model->is_deleted !== 1 ? 
                                Yii::$app->user->can('crm-orders-delete',true) : 
                                Yii::$app->user->can('crm-orders-restore',true);
                    },
                ],
            ],
        ],
    ]); ?>


</div>
</div>
      </div>
    </div>