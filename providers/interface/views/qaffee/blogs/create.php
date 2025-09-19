<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var qaffee\models\Blogs $model */

$this->title = 'Create Blogs';
$this->params['breadcrumbs'][] = ['label' => 'Blogs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="blogs-create">

   

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
