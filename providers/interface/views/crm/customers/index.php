<?php

use crm\models\Customers;
use helpers\Html;
use yii\helpers\Url;
use helpers\grid\GridView;

/** @var yii\web\View $this */
/** @var crm\models\searches\CustomerSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Customers';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="customers-index row">
  <div class="col-md-12">
    <div class="block block-rounded">
      <div class="block-header block-header-default">
        <h3 class="block-title"><?= Html::encode($this->title) ?> </h3>
        <div class="block-options">
          <?= Html::customButton([
            'type' => 'modal',
            'url' => Url::to(['create']),
            'appearence' => [
              'type' => 'text',
              'text' => 'Create Customers',
              'theme' => 'primary',
              'visible' => Yii::$app->user->can('app-customers-create', true)
            ],
            'modal' => ['title' => 'New Customers']
          ]) ?>
        </div>
      </div>
      <div class="block-content">
        <div class="customers-search my-3">
          <?= $this->render('_search', ['model' => $searchModel]); ?>
        </div>

        <?= GridView::widget([
          'dataProvider' => $dataProvider,
          'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'id',12
            'name',
            'email:email',
            'phone',
            // 'status',
            [
              'attribute' => 'status',
              'format' => 'raw',
              'value' => function ($model) {
                if ($model->status == 10) {
                  return '<span class="badge bg-success-light">Active</span>';
                } else {
                  return '<span class="badge bg-danger-light">Inactive</span>';
                }
              },
            ],
            [
              'class' => \helpers\grid\ActionColumn::className(),
              'template' => '{update} {trash}',
              'header' => 'Actions',
              'headerOptions' => ['width' => '8%'],
              'contentOptions' => ['style' => 'text-align: center;'],
              'buttons' => [
                'update' => function ($url, $model, $key) {
                  return Html::customButton(['type' => 'modal', 'url' => Url::toRoute(['update', 'id' => $model->id]), 'modal' => ['title' => 'Update  Customers'], 'appearence' => ['icon' => 'edit', 'theme' => '',  'class' => 'text-primary']]);
                },
                'trash' => function ($url, $model, $key) {
                  return $model->is_deleted !== 1 ?
                    Html::customButton(['type' => 'link', 'url' => Url::toRoute(['trash', 'id' => $model->id]),  'appearence' => ['icon' => 'trash', 'theme' => '',  'class' => 'text-danger', 'data' => ['message' => 'Do you want to delete this customers?']]]) :
                    Html::customButton(['type' => 'link', 'url' => Url::toRoute(['trash', 'id' => $model->id]),  'appearence' => ['icon' => 'undo', 'theme' => '', 'class' => 'text-danger', 'data' => ['message' => 'Do you want to restore this customers?']]]);
                },
              ],
              'visibleButtons' => [
                'update' => Yii::$app->user->can('app-customers-update', true),
                'trash' => function ($model) {
                  return $model->is_deleted !== 1 ?
                    Yii::$app->user->can('app-customers-delete', true) :
                    Yii::$app->user->can('app-customers-restore', true);
                },
              ],
            ],
          ],
        ]); ?>


      </div>
    </div>
  </div>
</div>