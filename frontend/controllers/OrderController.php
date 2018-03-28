<?php

namespace frontend\controllers;

use Yii;
use common\service\goods\GoodsService;
use common\service\order\OrderService;
class OrderController extends BaseController
{	
	
	/**
	* @desc 确认订单页面(此方法数据没有完全分离)
	*/
	public function actionIndex()
	{	
		$key = Yii::$app->params['goods.selectcart'];
		$goods = Yii::$app->session->get($key);
		if(!$goods)
		{
			return $this->redirect('/index/index');
		}
		$data = GoodsService::getListByids($goods);
		foreach($data as $k =>$value)
		{
			$id = (string)$value['_id'];
			foreach($goods as $v)
			{
				if($id == $v['goods_id'])
				{
					$value['goods_num'] = $v['goods_num'];
					break;
				}
			}
			$data[$k] = $value;
		}
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
	    	$key = Yii::$app->params['goods.selectcart'];
	    	Yii::$app->session->set($key,$goods);
	    	return ['status' => 0,'msg' =>'ok'];
    	}
    }

    
    /**
    * @desc 订单创建
    */
    public function actionCreate()
    {
    	$addressId = (int)Yii::$app->request->post('address_id');
    	$message = (string)Yii::$app->request->post('message');
    	if(!$addressId)
    	{
    		return ['status' =>1,'参数错误'];
    	}
    	$orderService = new OrderService();
    	if(!$orderService->create($this->userId, $addressId, $message))
    	{
    		return ['status' => 1,'msg' =>$orderService->errorMsg];
    	}
    	return ['status' => 0,'msg' =>'','order_sn' => $orderService->orderSn];
    }

}