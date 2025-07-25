<?php

/** @var yii\web\View $this */
/** @var string $content */

use yii\helpers\Html;
use ui\bundles\AdminAsset;

AdminAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">

<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title === null ? Yii::$app->name : Yii::$app->name . ' - ' . $this->title) ?></title>
    <?php $this->head() ?>
</head>

<body>
    <?php $this->beginBody() ?>
    <div id="page-container" class="main-wrapper">
        <?= $this->render('sections/admin/_header.php') ?>
        <?= $this->render('sections/admin/_sideBar') ?>
        <div id="main-container" class="page-wrapper">
            <div class="content container-fluid">
                <?= \helpers\widgets\swal\Alert::widget() ?>
                <?= $content ?>
            </div>
        </div>
        <div class="modal custom-modal modal-lg fade" id="modal-block-vcenter" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modal-block-vcenter" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-md">
                <div class="modal-content">
                    <div class="modal-header border-0 pb-0">
                        <div class="form-header modal-header-title text-start mb-0">
                            <h3 id="modalHeader" class="mb-0"><?= Yii::$app->name ?></h3>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div id="modalContent" class="modal-body">
                        <div style="text-align:center">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php
        $this->registerJs("
        $(function(){
            $('.loadModal').click(function(){
                $('#modal-block-vcenter').modal('show')
                    .find('#modalContent')
                    .load($(this).attr('data-payload'))
                    document.getElementById('modalHeader').innerHTML = $(this).attr('data-title');
                    $('.modal-dialog').addClass($(this).attr('data-size'));
            });
        });
        yii.confirm = function (message, okCallback, cancelCallback) {
            Swal.fire({
                title:'<h4>' + message + '</h4>',
                icon: 'warning',
                showCancelButton: true,
                closeOnConfirm: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, proceed',
            }).then((result) => {
                if (result.isConfirmed) {
                    okCallback();
                }
            })
        };
    ");

        ?>
        <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>