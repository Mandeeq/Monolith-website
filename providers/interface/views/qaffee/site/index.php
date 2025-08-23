<?php

/** @var yii\web\View $this */

$this->title = 'My Yii Application';
?> 

<?= $this->render('@components/qaffee/home/banner') ?>
<?= $this->render('@components/qaffee/home/about') ?>
<?= $this->render('@components/qaffee/home/foodmenu') ?>
<?= $this->render('@components/qaffee/home/videointro') ?>

<?= $this->render('@components/qaffee/home/review') ?>

<?= $this->render('@components/qaffee/home/contact') ?>