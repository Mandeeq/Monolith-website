<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var qaffee\models\HomeSections $model */

$this->title = 'Create Home Sections';
$this->params['breadcrumbs'][] = ['label' => 'Home Sections', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="home-sections-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
