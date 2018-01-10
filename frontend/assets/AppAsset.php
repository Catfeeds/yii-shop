<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/iconfont.css',
        'css/common.css',
        'css/index.css',
        'css/center.css',
        'css/cart.css',
        'css/animate.css',
        'css/location.css',
        'css/item.css',
    ];
    public $js = [
        'js/jquery-1.9.1.min.js',
        'js/jquery.SuperSlide.2.1.1.js',
        'js/main.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
