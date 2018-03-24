<?php

namespace frontend\controllers;

use Yii;
use common\service\goods\GoodsService;
class OrderController extends BaseController
{	
	
	public function actionIndex()
	{
		$goods = Yii::$app->request->post('goods');
		$data = GoodsService::getListByids($goods);
		return $this->render('index',['goods' =>json_encode($data)]);
	}
	
	
	
    /**
    * @desc 订单确认
    */
    public function actionConfirm()
    {	
    }

    
    
    

}