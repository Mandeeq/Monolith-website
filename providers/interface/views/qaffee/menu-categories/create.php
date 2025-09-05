<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var qaffee\models\MenuCategories $model */

$this->title = 'Create Menu Categories';
$this->params['breadcrumbs'][] = ['label' => 'Menu Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="menu-categories-create">



    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
