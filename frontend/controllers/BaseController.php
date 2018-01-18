<?php
namespace frontend\controllers;

use yii\web\Controller;
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
		$view->params['title'] = '文榜茶业';
		$view->params['keywords'] = '文榜茶业';
		$view->params['description'] = '文榜茶业';
        return true;
    }

}