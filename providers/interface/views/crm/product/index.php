<?php

use crm\models\Product;
use helpers\Html;
use yii\helpers\Url;
use helpers\grid\GridView;

/** @var yii\web\View $this */
/** @var crm\models\searches\ProductSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Products';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-index row">
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
              'text' => 'Create Product',
              'theme' => 'primary',
              'visible' => Yii::$app->user->can('crm-product-create', true)
            ],
            'modal' => ['title' => 'New Product']
          ]) ?>
          </div> 
        </div>
        <div class="block-content">     
    <div class="product-search my-3">
    <?= $this->render('_search', ['model' => $searchModel]); ?>
    </div>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'description:ntext',
            'price',
            'stock',
            //'created_at',
            //'updated_at',
            //'is_deleted:boolean',
            [
                'class' => \helpers\grid\ActionColumn::className(),
                'template' => '{cart},{update} {trash}',
                'headerOptions' => ['width' => '8%'],
                'contentOptions' => ['style'=>'text-align: center;'],
                 'buttons' => [
                    'update' => function ($url, $model, $key) {
                        return Html::customButton(['type' => 'modal', 'url' => Url::toRoute(['update', 'id' => $model->id]), 'modal' => ['title' => 'Update  Product'], 'appearence' => ['icon' => 'edit', 'theme' => 'info']]);
                    },
                    'trash' => function ($url, $model, $key) {
                        return $model->is_deleted !== 1 ?
                            Html::customButton(['type' => 'link', 'url' => Url::toRoute(['trash', 'id' => $model->id]),  'appearence' => ['icon' => 'trash', 'theme' => 'danger', 'data' => ['message' => 'Do you want to delete this product?']]]) :
                            Html::customButton(['type' => 'link', 'url' => Url::toRoute(['trash', 'id' => $model->id]),  'appearence' => ['icon' => 'undo', 'theme' => 'warning', 'data' => ['message' => 'Do you want to restore this product?']]]);
                    },
                       'cart' => function ($url, $model, $key) {
            return Html::customButton([
                'type' => 'link',
                'url' => Url::to(['add', 'product_id' => $model->id]),
                'appearence' => [
                    'icon' => 'shopping-cart', // You can use 'text' instead of 'icon' if preferred
                    'theme' => 'success',
                    'title' => 'Add to Cart',
                ]
            ]);
        },
                ],
                'visibleButtons' => [
                    'update' => Yii::$app->user->can('crm-product-update',true),
                    'trash' => function ($model){
                         return $model->is_deleted !== 1 ? 
                                Yii::$app->user->can('crm-product-delete',true) : 
                                Yii::$app->user->can('crm-product-restore',true);
                    },
                ],
            ],
        ],
    ]); ?>


</div>
</div>
      </div>
    </div>