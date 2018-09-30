<?php

namespace frontend\controllers;

use Yii;
use common\service\order\OrderService;
use yii\helpers\Url;
use common\models\shop\form\OrderSubmitPreviewForm;
use common\models\shop\form\OrderSubmitForm;
use common\models\shop\form\OrderListForm;
use common\models\shop\form\OrderRevokeForm;
class OrderController extends BaseController
{	
	
	public function actionList()
	{
		return $this->render('list');
	}
	
	public function actionPreview()
	{	
		$cart_id_list = Yii::$app->request->get('cart_id_list');
		return $this->render('preview',['cart_id_list' =>$cart_id_list]);
	}
	
	//订单提交前的预览页面
	public function actionSubmitPreview()
	{
		$form = new OrderSubmitPreviewForm();
		$form->cart_id_list = Yii::$app->request->get('cart_id_list');
		$form->store_id = 1;
		$form->user_id = $this->userId;
		$result = $form->search();
		return ['status' => $result['code'],'data' => $result['data']];
	}
	
	
	/*
	 * 订单创建**/
	public function actionSubmit()
	{
		$form = new OrderSubmitForm();
		$model = \Yii::$app->request->post();
		$form->scenario = "EXPRESS";
		$form->offline = 0;
		$form->attributes = $model;
		$form->store_id = 1;
		$form->user_id = $this->userId;
		$result = $form->save();
		
		$returnUrl = Url::to(['/pay/index','id' =>$result['data']->order_id]);
		
		return ['status' => $result['code'],'msg' => $result['msg'],'return_url' => $returnUrl];
		
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
    	$form = new OrderListForm();
        $form->attributes = \Yii::$app->request->get();
        $form->store_id = 1;
        $form->user_id = $this->userId;
        $result = $form->search();
    	return ['status' => $result['code'],'data' => $result['data']['list']];
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
    
    //订单取消
    public function actionRevoke()
    {
    	$form = new OrderRevokeForm();
    	$form->attributes = \Yii::$app->request->get();
    	$form->user_id = $this->userId;
    	$this->renderJson($form->save());
    }
	
    

    /**
     * @desc 查询物流页面
     * @param
     * @return
     */
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
    		return ['status' =>1,'msg' =>'参数错误'];
    	}
    	$orderService = new OrderService();
    	$order = $orderService->getOrderByOrdersn($orderSn);
    	if(!$order['invoice_no'])
    	{
    		return ['status' =>1,'msg' =>'物流单号不存在'];
    	}
    	if($order['user_id'] !=$this->userId)
    	{
    		return ['status' =>1,'msg' =>'参数异常'];
    	}
    	$shipping = ShippingService::getCode();
    	$url = 'https://www.kuaidi100.com/chaxun?com='.$shipping[$order['shipping_id']].'&nu='.$order['invoice_no'];
    	return ['status' =>0,'url' => $url];
    }
    
    
    /**
    * @desc 确认收货
    * @param
    * @return
    */
    public function actionReceive()
    {
    	$orderSn = trim(Yii::$app->request->get('id'));
    	if(!$orderSn)
    	{
    		return ['status' =>1,'msg' =>'参数错误'];
    	}
    	$orderService = new OrderService();
    	$result = $orderService->receive($orderSn,$this->userId);
    	if($result)
    	{
    		return ['status' =>0,'msg' =>'确认收货成功'];
    	}
    	return ['status' =>1,'msg' =>'确认收货失败'];
    }
}