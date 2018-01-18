<?php
namespace frontend\controllers;

use yii\web\Controller;
use common\models\Options;
use Yii;

/**
 * Base controller
 */
class BaseController extends Controller
{
 	public function beforeAction($action)
    {
        //用于底部四个导航图片样式的判断
    	$controller = $action->controller->id;
        $act = $action->controller->action->id;
        $view = Yii::$app->view;
        $view->params['controller'] = strtolower($controller);
		$view->params['action'] = strtolower($act);
		$options = Options::find()->where(['<','id',4])->select('*')->asArray()->all();
		$view->params['title'] = $options[2]['value'];
		$view->params['keywords'] = $options[0]['value'];
		$view->params['description'] = $options[1]['value'];
        return true;
    }

}