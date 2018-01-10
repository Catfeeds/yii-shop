<?php
/**
 * Author: lf
 * Blog: https://blog.feehi.com
 * Email: job@feehi.com
 * Created at: 2016-04-01 23:26
 */

namespace backend\modules\user\controllers;

use common\widgets\ueditor\UeditorAction;

class UploadController extends \yii\web\Controller
{

    public function actions()
    {
        return [
              /* ueditor文件上传*/
            'ueditor' => [
                'class' => UeditorAction::className()
            ], 
            /* 单图、多图上传 */
            'uploadimage' => [
                'class' => 'common\widgets\images\UploadAction',
            ],
        ];
    }

}