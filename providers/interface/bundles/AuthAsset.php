<?php

namespace ui\bundles;

use yii\web\AssetBundle;

class AuthAsset extends AssetBundle
{
    public $basePath = '@ui/assets';
    public $baseUrl = '@web/providers/interface/assets';
    public $css = [
        [
            'href' => 'oneui/favicon.png',
            'rel' => 'icon',
            'sizes' => '64x64',
        ],
        'admin/assets/css/style.css',
        'admin/assets/css/bootstrap.min.css',
        // 'admin/assets/font.css',
        "site/fontawesome-free-6.4.0-web/css/all.css",

    ];
    public $js = [
        'admin/assets/js/layout.js',
        //'admin/assets/js/jquery-3.7.1.min.js',
        'admin/assets/js/bootstrap.bundle.min.js',
        'admin/assets/js/theme-settings.js',
        'admin/assets/js/greedynav.js',
        'admin/assets/js/script.js'

    ];
    public $depends = [
        'helpers\widgets\swal\AlertAsset',
        'yii\web\YiiAsset',
    ];
}
