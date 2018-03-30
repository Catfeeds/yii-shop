<?php

namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use common\service\order\OrderService;
use common\service\pay\weixin\NativePay;
use common\models\order\Order;
/**
 * Site controller
 */
class PayController extends BaseController
{	
	private $weixinNotify = '';
	/**
	* @desc 支付页面
	*/
	public function actionIndex()
	{
		$orderSn  = trim(Yii::$app->request->get('id'),'');
		if(!$orderSn)
		{
			return $this->redirect('/');
		}
		$orderService = new OrderService();
		$order = $orderService->getOrderByOrdersn($orderSn);
		if(!$order)
		{
			return $this->redirect('/');
		}
		return $this->render('index',['order' => $order]);
	}
	
	
    /**
    * @desc 发起微信支付
    */
    public function actionWeixin()
    {	
    	$orderSn  = trim(Yii::$app->request->get('id'),'');
    	if(!$orderSn)
    	{
    		return $this->redirect('/');
    	}
    	$orderService = new OrderService();
    	$order = $orderService->getOrderByOrdersn($orderSn);
    	if(!$order)
    	{
    		return $this->redirect('/');
    	}
    	if($order['order_status'] !='1')
    	{
    		return $this->redirect('/');//已经支付
    	}
    	$orderGoods = $orderService->getOrderGoodsByOrderId($order['id']);
    	/**
    	* 流程：
    	* 1、组装包含支付信息的url，生成二维码
    	* 2、用户扫描二维码，进行支付
    	* 3、确定支付之后，微信服务器会回调预先配置的回调地址，在【微信开放平台-微信支付-支付配置】中进行配置
    	* 4、在接到回调通知之后，用户进行统一下单支付，并返回支付信息以完成支付（见：native_notify.php）
    	* 5、支付完成之后，微信服务器会通知支付成功
    	* 6、在支付成功通知中需要查单确认是否真正支付成功（见：notify.php）
    	*/
    	$notify = new NativePay();
    	 
    	//模式二
    	/**
    	* 流程：
    	* 1、调用统一下单，取得code_url，生成二维码
    	* 2、用户扫描二维码，进行支付
    	* 3、支付完成之后，微信服务器会通知支付成功
    	* 4、在支付成功通知中需要查单确认是否真正支付成功（见：notify.php）
    	*/
    	$input = new \WxPayUnifiedOrder();
    	$input->SetBody($orderGoods['goods_name']);
    	$input->SetAttach($orderGoods['goods_name']);
    	$input->SetGoods_tag($orderGoods['goods_name']);
    	$input->SetOut_trade_no($orderSn);
    	$input->SetTotal_fee($order['order_amount']);
    	
    	$url = Yii::$app->params['weixin.notify'];
    	$input->SetNotify_url($url);

    	$input->SetTime_start(date("YmdHis"));
    	$input->SetTime_expire(date("YmdHis", time() + 600));
    	$input->SetTrade_type("NATIVE");
    	$input->SetProduct_id($orderGoods['goods_id']);
    	$result = $notify->GetPayUrl($input);
    	$url = urlencode($result["code_url"]);
    	var_dump($url);exit;
    	$url ='http://paysdk.weixin.qq.com/example/qrcode.php?data='.$url;
    	return $this->render('test',['url'=>$url]);
    }
    
    
    public function actionWeixinnotify()
    {
    	
    }
}