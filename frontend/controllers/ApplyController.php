<?php

namespace frontend\controllers;

use common\models\Apply;
use yii;
/**
 * Site controller
 */
class ApplyController extends BaseController
{


    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionCreate()
    {
    	$model = new Apply();
    	$model->created_at = time();
    	$model->updated_at = time();
    	$model->setAttributes(yii::$app->getRequest()->post(),false);
    	if ($model->validate() && $model->save()) {
    		return json_encode(['status' =>0,'msg' =>'提交成功']);
    	} else {
    		$errors = $model->getErrors();
    		$msg = '';
    		foreach ($errors as $v) {
    			$msg =  $v[0];break;
    		}
    		return json_encode(['status' =>1,'msg' =>$msg]);
    	}
    }
}