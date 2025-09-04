<?php
namespace app\web\bundles;

use yii\web\AssetBundle;

class MainAsset extends AssetBundle
{
    public $basePath = '@webroot/web/assets';
    public $baseUrl = '@web/web/assets';

    public $css = [

        'css/bootstrap.min.css',
        'css/animate.css',
        'css/owl.carousel.min.css',
        'css/themify-icons.css',
        'css/flaticon.css',
        'css/magnific-popup.css',
        'css/slick.css',
        'css/nice-select.css',
        'css/all.css',
        'css/style.css',
    ];

    public $js = [
        'js/jquery-1.12.1.min.js',
        'js/popper.min.js',
        'js/bootstrap.min.js',
        'js/jquery.magnific-popup.js',
        'js/swiper.min.js',
        'js/masonry.pkgd.js',
        'js/owl.carousel.min.js',
        'js/slick.min.js',
        'js/gijgo.min.js',
        'js/jquery.nice-select.min.js',
        'js/custom.js',
    ];

    public $depends = [
        'yii\web\YiiAsset',
    ];
}
