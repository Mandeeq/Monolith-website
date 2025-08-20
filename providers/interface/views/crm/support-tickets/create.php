<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var crm\models\SupportTickets $model */

$this->title = 'Create Support Tickets';
$this->params['breadcrumbs'][] = ['label' => 'Support Tickets', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="support-tickets-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
