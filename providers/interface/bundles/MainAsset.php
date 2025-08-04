<?php

namespace ui\bundles;

use yii\web\AssetBundle;

class MainAsset extends AssetBundle
{
    public $basePath = '@ui/assets';
    public $baseUrl = '@web/providers/interface/assets';
    public $css = [
        [
            'href' => 'oneui/favicon.png',
            'rel' => 'icon',
            'sizes' => '64x64',
            // 'admin/assets/img/favicon.png',

        ],
        // 'oneui/css/dashboard.css',


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
        'admin/custom.css'

    ];
    public $js = [
        [
            'src' => 'admin/assets/js/jquery-3.7.1.min.js',
            'type' => 'a6198a1a8153d4da5e6d6c13-text/javascript',
        ],
        [
            'src' => 'admin/assets/js/bootstrap.bundle.min.js',
            'type' => 'a6198a1a8153d4da5e6d6c13-text/javascript',
        ],
        [
            'src' => 'admin/assets/js/feather.min.js',
            'type' => 'a6198a1a8153d4da5e6d6c13-text/javascript',
        ],
        [
            'src' => 'admin/assets/plugins/slimscroll/jquery.slimscroll.min.js',
            'type' => 'a6198a1a8153d4da5e6d6c13-text/javascript',
        ],
        [
            'src' => 'admin/assets/plugins/apexchart/apexcharts.min.js',
            'type' => 'a6198a1a8153d4da5e6d6c13-text/javascript',
        ],
        [
            'src' => 'admin/assets/plugins/apexchart/chart-data.js',
            'type' => 'a6198a1a8153d4da5e6d6c13-text/javascript',
        ],
        [
            'src' => 'admin/assets/js/theme-settings.js',
            'type' => 'a6198a1a8153d4da5e6d6c13-text/javascript',
        ],
        [
            'src' => 'admin/assets/js/greedynav.js',
            'type' => 'a6198a1a8153d4da5e6d6c13-text/javascript',
        ],
        [
            'src' => 'admin/assets/js/script.js',
            'type' => 'a6198a1a8153d4da5e6d6c13-text/javascript',
        ],
        [
            'src' => '../../cdn-cgi/scripts/7d0fa10a/cloudflare-static/rocket-loader.min.js',
            'data-cf-settings' => 'a6198a1a8153d4da5e6d6c13-|49',
            'defer' => true,
        ],
    ];
    public $depends = [
        'helpers\widgets\swal\AlertAsset',
        'yii\web\YiiAsset',
    ];
}
