<?php

namespace frontend\controllers;

use Yii;
use common\service\goods\GoodsService;
class OrderController extends BaseController
{	
	protected  $selectTmp = 'selectcart';
	
	/**
	* @desc 确认订单页面(此方法数据没有完全分离)
	*/
	public function actionIndex()
	{
		$goods = Yii::$app->session->get($this->selectTmp);
		if(!$goods)
		{
			return $this->redirect('/index/index');
		}
		$data = GoodsService::getListByids($goods);
		return $this->render('index',['goods' =>json_encode($data)]);
	}
	
	
	
    /**
    * @desc 订单确认(临时保存用户选择的数据)
    */
    public function actionConfirm()
    {	
    	if(Yii::$app->request->isAjax)
    	{	
	    	$goods = Yii::$app->request->post('goods');
	    	if(count($goods) <1)
	    	{
	    		return ['status' =>1,'msg' =>'参数提交错误'];
	    	}
	    	Yii::$app->session->set($this->selectTmp,$goods);
	    	return ['status' => 0,'msg' =>'ok'];
    	}
    }

    
    
    

}