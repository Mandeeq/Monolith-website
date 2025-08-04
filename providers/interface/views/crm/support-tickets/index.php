<?php

use crm\models\SupportTickets;
use helpers\Html;
use yii\helpers\Url;
use helpers\grid\GridView;

/** @var yii\web\View $this */
/** @var crm\models\searches\SupportTicketSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Support Tickets';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="support-tickets-index row">
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
              'text' => 'Create Support Tickets',
              'theme' => 'primary',
              'visible' => Yii::$app->user->can('app-support-ticket-create', true)
            ],
            'modal' => ['title' => 'New Support Tickets']
          ]) ?>
          </div> 
        </div>
        <div class="block-content">     
    <div class="support-tickets-search my-3">
    <?= $this->render('_search', ['model' => $searchModel]); ?>
    </div>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'customer_id',
            'subject',
            'description:ntext',
            'is_deleted',
            //'status',
            //'created_at',
            [
                'class' => \helpers\grid\ActionColumn::className(),
                'template' => '{update} {trash}',
                'headerOptions' => ['width' => '8%'],
                'contentOptions' => ['style'=>'text-align: center;'],
                 'buttons' => [
                    'update' => function ($url, $model, $key) {
                        return Html::customButton(['type' => 'modal', 'url' => Url::toRoute(['update', 'id' => $model->id]), 'modal' => ['title' => 'Update  Support Tickets'], 'appearence' => ['icon' => 'edit', 'theme' => 'info']]);
                    },
                    'trash' => function ($url, $model, $key) {
                        return $model->is_deleted !== 1 ?
                            Html::customButton(['type' => 'link', 'url' => Url::toRoute(['trash', 'id' => $model->id]),  'appearence' => ['icon' => 'trash', 'theme' => 'danger', 'data' => ['message' => 'Do you want to delete this support tickets?']]]) :
                            Html::customButton(['type' => 'link', 'url' => Url::toRoute(['trash', 'id' => $model->id]),  'appearence' => ['icon' => 'undo', 'theme' => 'warning', 'data' => ['message' => 'Do you want to restore this support tickets?']]]);
                    },
                ],
                'visibleButtons' => [
                    'update' => Yii::$app->user->can('app-support-ticket-update',true),
                    'trash' => function ($model){
                         return $model->is_deleted !== 1 ? 
                                Yii::$app->user->can('app-support-ticket-delete',true) : 
                                Yii::$app->user->can('app-support-ticket-restore',true);
                    },
                ],
            ],
        ],
    ]); ?>


</div>
</div>
      </div>
    </div>