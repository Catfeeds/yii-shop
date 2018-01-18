<?php

namespace frontend\controllers;

use common\models\Apply;

/**
 * Site controller
 */
class IndexController extends BaseController
{


    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionCreate()
    {
    	$model = new Apply();
    	if ($model->load(yii::$app->getRequest()->post()) && $model->validate() && $model->save()) {
    		return ['status' =>0,'msg' =>'提交成功'];
    	} else {
    		$errors = $model->getErrors();
    		Yii::$app->getSession()->setFlash('error', $err);
    		return ['status' =>1,'msg' =>$errors[0]];
    	}
    }
}