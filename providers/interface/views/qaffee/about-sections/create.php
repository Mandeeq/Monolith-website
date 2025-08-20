<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var qaffee\models\AboutSections $model */

$this->title = 'Create About Sections';
$this->params['breadcrumbs'][] = ['label' => 'About Sections', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="about-sections-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
