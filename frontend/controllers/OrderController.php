<?php

namespace frontend\controllers;

use Yii;
use common\service\goods\GoodsService;
use common\service\order\OrderService;
use yii\helpers\Url;
use common\service\order\LogisticsService;
use common\service\order\ShippingService;
class OrderController extends BaseController
{	
	
	public function actionList()
	{
		return $this->render('list');
	}
	
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
    	$returnUrl = Url::to(['/pay/index','id' =>$orderService->orderSn]);
    	return ['status' => 0,'msg' =>'','return_url' => $returnUrl];
    }
    
    /**
    * @desc 查询订单状态 (api)
    * @param
    * @return
    */
    public function actionPaystatus()
    {	
    	$orderSn = trim(Yii::$app->request->get('order_sn'),'');
    	if(!$orderSn)
    	{
    		return ['status' =>1,'msg' => '参数异常' ];
    	}
    	$orderService =new	OrderService();
    	$order =$orderService->getOrderByOrdersn($orderSn);
    	if($order['user_id'] !=$this->userId)
    	{
    		return ['status' =>1,'msg' => '订单号异常' ];
    	}
		return ['status' =>0,'pay_status' => $order['order_status'],'return_url' =>Url::to(['/order/list'])  ];
    }
    
    /**
    * @desc 订单列表api
    */
    public function actionOrderlist()
    {	
    	$orderService = new OrderService();	
    	$size = Yii::$app->request->post('size');
    	$page = Yii::$app->request->post('page');
    	$order_status = Yii::$app->request->post('order_status');
    	if(!$order_status)
    	{
    		$order_status = -1;
    	}
    	$data = $orderService->getList($this->userId,$page,$size,$order_status);
    	return ['status' => 0,'data' => $data];
    }
    
    /**
    * @desc 取消订单api
    */
    public function actionCancel()
    {
    	$id = trim(Yii::$app->request->get('id'));
    	if(!$id)
    	{
    		return ['status' =>1,'msg' => '参数异常' ];
    	}
    	$orderService = new OrderService();
    	if($orderService->cancel($id, $this->userId))
    	{
    		return ['status' =>0,'msg' => '取消成功' ];
    	}
    	return ['status' =>1,'msg' => '取消失败' ];
    }
	
    
    
    public function actionTrace()
    {
    	return $this->render('trace');
    }
    
    
    /**
    * @desc 查询物流
    * @param
    * @return
    */
    public function actionGettrace()
    {
    	$orderSn = trim(Yii::$app->request->get('id'));
    	if(!$orderSn)
    	{
    		return ['status' =>0,'msg' =>'参数错误'];
    	}
    	$orderService = new OrderService();
    	$order = $orderService->getOrderByOrdersn($orderSn);
    	if(!$order['invoice_no'])
    	{
    		return ['status' =>0,'msg' =>'物流单号不存在'];
    	}
    	$shipping = ShippingService::getListArray();
    	$result = LogisticsService::getInfo($shipping[$order['shipping_id']], $order['invoice_no']);
    	var_dump($result);exit;
    }
}