<?php
/**
 * Author: lf
 * Blog: https://blog.feehi.com
 * Email: job@feehi.com
 * Created at: 2017-03-15 21:16
 */

namespace backend\assets;

use yii;

class GoodsAsset extends \yii\web\AssetBundle
{
    public function init()
    {
        parent::init();
        if( yii::$app->getRequest()->getBaseUrl() !== "" ){
            $this->sourcePath = '@backend/web';
        }
    }


    public $js = [
        'static/js/plugins/sku/liandong.js',
    ];
	
    public $css = [
    	'static/js/plugins/sku/liandong.css',
    ];
    
    public $depends = [
        'feehi\assets\JqueryAsset',
    ];
}
