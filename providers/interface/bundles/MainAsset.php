<?php

namespace ui\bundles;

use yii\web\AssetBundle;

class MainAsset extends AssetBundle
{
    public $basePath = '@ui/assets';
    public $baseUrl = '@web/providers/interface/assets';

    public $css = [
        'admin/assets/plugins/fontawesome/css/fontawesome.min.css',
        'admin/assets/plugins/fontawesome/css/all.min.css',
        'admin/assets/plugins/feather/feather.css',
        'admin/assets/plugins/datatables/datatables.min.css',
        'admin/assets/plugins/select2/css/select2.min.css',
        'admin/assets/css/bootstrap.min.css',
        'admin/assets/css/dataTables.bootstrap5.min.css',
        'admin/assets/css/bootstrap-datetimepicker.min.css',
        'admin/assets/css/owl.carousel.min.css',
        'admin/assets/css/style.css',
    ];

    public $js = [
        // 'admin/assets/js/jquery-3.7.1.min.js',
        'admin/assets/js/bootstrap.bundle.min.js',
        'admin/assets/js/feather.min.js',
        'admin/assets/plugins/slimscroll/jquery.slimscroll.min.js',
        'admin/assets/plugins/apexchart/apexcharts.min.js',
        'admin/assets/plugins/apexchart/chart-data.js',
        'admin/assets/js/theme-settings.js',
        'admin/assets/js/greedynav.js',
        'admin/assets/js/script.js',
    ];

    public $depends = [
        'yii\web\YiiAsset',
    ];
}
