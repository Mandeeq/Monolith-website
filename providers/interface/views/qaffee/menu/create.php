<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var qaffee\models\FoodMenus $model */

$this->title = 'Create Food Menus';
$this->params['breadcrumbs'][] = ['label' => 'Food Menuses', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="food-menus-create">

  

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
