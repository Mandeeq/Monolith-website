<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var qaffee\models\AboutSections $model */

$this->title = 'Update About Sections: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'About Sections', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="about-sections-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
