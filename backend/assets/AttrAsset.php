<?php
/**
 * Author: lf
 * Blog: https://blog.feehi.com
 * Email: job@feehi.com
 * Created at: 2017-03-15 21:16
 */

namespace backend\assets;

use yii;

class AttrAsset extends \yii\web\AssetBundle
{
    public function init()
    {
        parent::init();
        if( yii::$app->getRequest()->getBaseUrl() !== "" ){
            $this->sourcePath = '@backend/web';
        }
    }


    public $js = [
        'static/js/template.js',
        'static/js/attr-edit.js',
        'static/js/jquery.formValid.js'
    ];

    public $depends = [
        'feehi\assets\JqueryAsset',
    ];
}
