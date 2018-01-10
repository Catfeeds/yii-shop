<?php
/**
* 商品属性相关操作
* @Name  AttrController.php
* @Author  Chenling
* @Version  1.0
* @Date:  2017-11-19上午11:30:46
* @Description 
*/
namespace backend\modules\goods\controllers;
use yii;
use common\models\goods\Category;
use common\models\goods\mongodb\Attr;
use common\helpers\FuncHelper;
class TestController extends \yii\web\Controller
{
	
    
    public function actionIndex()
    {	 
    	$id = Yii::$app->queue->push(new \backend\jobs\Email([
    		'email' => '1245010531@qq.com',
		]));
    	var_dump($id);
    	
    }
    
}
