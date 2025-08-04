<?php

use crm\models\DeliveryAddress;
use helpers\Html;
use yii\helpers\Url;
use helpers\grid\GridView;

/** @var yii\web\View $this */
/** @var crm\models\searches\DeliveryAddressSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Delivery Addresses';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="delivery-address-index row">
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
              'text' => 'Create Delivery Address',
              'theme' => 'primary',
              'visible' => Yii::$app->user->can('crm-delivery-address-create', true)
            ],
            'modal' => ['title' => 'New Delivery Address']
          ]) ?>
          </div> 
        </div>
        <div class="block-content">     
    <div class="delivery-address-search my-3">
    <?= $this->render('_search', ['model' => $searchModel]); ?>
    </div>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'customer_id',
            'label',
            'address:ntext',
            'city',
            //'postal_code',
            //'is_default',
            //'created_at',
            //'updated_at',
            [
                'class' => \helpers\grid\ActionColumn::className(),
                'template' => '{update} {trash}',
                'headerOptions' => ['width' => '8%'],
                'contentOptions' => ['style'=>'text-align: center;'],
                 'buttons' => [
                    'update' => function ($url, $model, $key) {
                        return Html::customButton(['type' => 'modal', 'url' => Url::toRoute(['update', 'id' => $model->id]), 'modal' => ['title' => 'Update  Delivery Address'], 'appearence' => ['icon' => 'edit', 'theme' => 'info']]);
                    },
                    'trash' => function ($url, $model, $key) {
                        return $model->is_deleted !== 1 ?
                            Html::customButton(['type' => 'link', 'url' => Url::toRoute(['trash', 'id' => $model->id]),  'appearence' => ['icon' => 'trash', 'theme' => 'danger', 'data' => ['message' => 'Do you want to delete this delivery address?']]]) :
                            Html::customButton(['type' => 'link', 'url' => Url::toRoute(['trash', 'id' => $model->id]),  'appearence' => ['icon' => 'undo', 'theme' => 'warning', 'data' => ['message' => 'Do you want to restore this delivery address?']]]);
                    },
                ],
                'visibleButtons' => [
                    'update' => Yii::$app->user->can('crm-delivery-address-update',true),
                    'trash' => function ($model){
                         return $model->is_deleted !== 1 ? 
                                Yii::$app->user->can('crm-delivery-address-delete',true) : 
                                Yii::$app->user->can('crm-delivery-address-restore',true);
                    },
                ],
            ],
        ],
    ]); ?>


</div>
</div>
      </div>
    </div>