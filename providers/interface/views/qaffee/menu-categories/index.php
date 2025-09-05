<?php

use qaffee\models\MenuCategories;
use helpers\Html;
use yii\helpers\Url;
use helpers\grid\GridView;

/** @var yii\web\View $this */
/** @var qaffee\models\searches\MenuCategorieSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Menu Categories';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="menu-categories-index row">
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
              'text' => 'Add Menu Category',
              'theme' => 'primary',
              'visible' => Yii::$app->user->can('qaffee-menu-categories-create', true)
            ],
            'modal' => ['title' => 'New Menu Categories']
          ]) ?>
          </div> 
        </div>
        <div class="block-content">     
    <div class="menu-categories-search my-3">
    <?= $this->render('_search', ['model' => $searchModel]); ?>
    </div>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'id',
            'name',
            'description:ntext',
            'display_order',
            // 'created_at',
            //'updated_at',
            [
                'class' => \helpers\grid\ActionColumn::className(),
                'template' => '{update} {trash}',
                'headerOptions' => ['width' => '8%'],
                'contentOptions' => ['style'=>'text-align: center;'],
                 'buttons' => [
                    'update' => function ($url, $model, $key) {
                        return Html::customButton(['type' => 'modal', 'url' => Url::toRoute(['update', 'id' => $model->id]), 'modal' => ['title' => 'Update  Menu Categories'], 'appearence' => ['icon' => 'edit', 'theme' => 'info']]);
                    },
                    'trash' => function ($url, $model, $key) {
                        return $model->is_deleted !== 1 ?
                            Html::customButton(['type' => 'link', 'url' => Url::toRoute(['trash', 'id' => $model->id]),  'appearence' => ['icon' => 'trash', 'theme' => 'danger', 'data' => ['message' => 'Do you want to delete this menu categories?']]]) :
                            Html::customButton(['type' => 'link', 'url' => Url::toRoute(['trash', 'id' => $model->id]),  'appearence' => ['icon' => 'undo', 'theme' => 'warning', 'data' => ['message' => 'Do you want to restore this menu categories?']]]);
                    },
                ],
                'visibleButtons' => [
                    'update' => Yii::$app->user->can('qaffee-menu-categories-update',true),
                    'trash' => function ($model){
                         return $model->is_deleted !== 1 ? 
                                Yii::$app->user->can('qaffee-menu-categories-delete',true) : 
                                Yii::$app->user->can('qaffee-menu-categories-restore',true);
                    },
                ],
            ],
        ],
    ]); ?>


</div>
</div>
      </div>
    </div>