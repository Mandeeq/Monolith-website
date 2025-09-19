<?php
use yii\helpers\Html;
?>
<nav id="sidebar" aria-label="Main Navigation">
    <!-- Side Header -->
    <div class="content-header">
         <div class="  text-center py-3">
        <a href="<?= Yii::$app->urlManager->createUrl(['dashboard/site/dashboard']) ?>" class="d-flex align-items-center justify-content-center">

            <?= Html::img('@web/web/assets/img/logo.jpeg', [
                'alt' => 'RentalMS ',
                'class' => 'img-fluid',
                'style' => '
            max-height: 80px;
             margin-right: 5px;
             margin-top: 30px;
            max-width: 80px;
            border-radius: 50%;
            padding-bottom: -50px;
             
             
             ', // adjust size here
            ]) ?>

        </a>
    </div>
       <a class="fw-semibold text-dual" href="#">
            <span class="smini-visible">
                <i class="fa fa-circle-notch text-primary"></i>
            </span>
          
        </a>
        <!-- Logo -->
        <!-- <a class="fw-semibold text-dual" href="/">
            <span class="smini-visible">
                <i class="fa fa-circle-notch text-primary"></i>
            </span>
            <span class="smini-hide fs-5 tracking-wider"><?= Yii::$app->name ?></span>
        </a> -->
        <!-- END Logo -->

        <!-- Extra -->
        <div>
            <!-- Close Sidebar, Visible only on mobile screens -->
            <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
            <a class="d-lg-none btn btn-sm btn-alt-secondary ms-1" data-toggle="layout" data-action="sidebar_close" href="javascript:void(0)">
                <i class="fa fa-fw fa-times"></i>
            </a>
            <!-- END Close Sidebar -->
        </div>
        <!-- END Extra -->
    </div>
    <div class="js-sidebar-scroll">
        <!-- Side Navigation -->
        <div class="content-side">
            <?= \helpers\Menu::load() ?>
        </div>
    </div>
</nav>