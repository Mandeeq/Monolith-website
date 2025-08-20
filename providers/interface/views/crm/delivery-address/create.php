<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var crm\models\DeliveryAddress $model */

$this->title = 'Create Delivery Address';
$this->params['breadcrumbs'][] = ['label' => 'Delivery Addresses', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="delivery-address-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
