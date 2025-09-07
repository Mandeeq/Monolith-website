<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var qaffee\models\FoodMenus $model */

$this->title = 'Update Food Menus: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Food Menuses', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="food-menus-update">

    

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
