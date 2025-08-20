<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var crm\models\CartItems $model */

$this->title = 'Create Cart Items';
$this->params['breadcrumbs'][] = ['label' => 'Cart Items', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cart-items-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
