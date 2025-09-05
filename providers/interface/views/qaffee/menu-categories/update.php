<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var qaffee\models\MenuCategories $model */

$this->title = 'Update Menu Categories: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Menu Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="menu-categories-update">

  

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
