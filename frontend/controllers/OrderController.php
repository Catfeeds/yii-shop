<?php

namespace frontend\controllers;

use Yii;
use common\service\goods\CartService;
class OrderController extends BaseController
{	
	
	public function actionIndex()
	{
		return $this->render('index');
	}
	
    /**
    * @desc 订单确认
    */
    public function actionConfirm()
    {	
    }

    
    
    

}