<?php

namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use common\service\order\OrderService;
use common\service\pay\weixin\NativePay;
use common\service\pay\weixin\PayNotifyCallBack;
use common\models\shop\Order;
use common\models\shop\OrderDetail;

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
		$orderId  = trim(Yii::$app->request->get('id'),'');
		if(!$orderId)
		{	
			Yii::$app->session->setFlash('msg','参数错误');
			return $this->redirect('/site/msg');
		}
		
		$order = Order::findOne(['id' => $orderId,'user_id' => $this->userId]);
		if(!$order)
		{	
			Yii::$app->session->setFlash('msg','找不到相应的订单');
			return $this->redirect('/site/msg');
		}
		return $this->render('index',['order' => $order]);
	}
	
	
    /**
    * @desc 发起微信支付
    */
    public function actionWeixin()
    {	
    	$orderNo  = trim(Yii::$app->request->get('id'),'');
    	if(!$orderNo)
    	{
    		Yii::$app->session->setFlash('msg','参数错误');
			return $this->redirect('/site/msg');
    	}
    	$order = Order::findOne(['order_no' => $orderNo,'user_id' => $this->userId]);
    	if(!$order)
    	{
    		Yii::$app->session->setFlash('msg','找不到相应的订单');
			return $this->redirect('/site/msg');
    	}
    	if($order['order_status'] !='1')
    	{
    		Yii::$app->session->setFlash('msg','订单已支付过了');
			return $this->redirect('/site/msg');
    	}
    	$detailModel = new OrderDetail();
    	$orderGoods = $detailModel->getList($order['id']);
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
    	$input->SetOut_trade_no($orderNo);
    	
    	$payAmount = $order['pay_price'] * 100;
    	$input->SetTotal_fee($payAmount);
    	
    	$url = Yii::$app->params['weixin.notify'];
    	$input->SetNotify_url($url);

    	$input->SetTime_start(date("YmdHis"));
    	$input->SetTime_expire(date("YmdHis", time() + 600));
    	$input->SetTrade_type("NATIVE");
    	$input->SetProduct_id($orderGoods['goods_id']);
    	$result = $notify->GetPayUrl($input);
		if($result['return_code'] == 'FAIL')
		{	
			echo $result['return_msg'];exit;
		}
		if($result['result_code'] == 'FAIL')
		{
			echo $result['err_code_des'];exit;
		}
    	$url = $result["code_url"];
    	$url = urlencode($url);
    	return $this->render('weixin',['url'=>$url,'orderAmount' =>$order['order_amount'],'id' =>$orderSn]);
    }
    
    
    /**
    * @desc 微信支付生成二维码
    * @param
    */
    public function actionQrcode()
    {	
    	ob_clean();
    	require yii::getAlias('@common').'/service/pay/weixin/phpqrcode/phpqrcode.php';
    	$url = urldecode($_GET["data"]);
    	\QRcode::png($url , $outfile = false, $level = QR_ECLEVEL_L, $size = 6, $margin = 2, $saveandprint=false );
		exit();
    }
    

    
    
    /**
     * @desc 微信异步回调
     */
    public function actionWeixinnotify()
    {
    	$notify = new PayNotifyCallBack();
    	$result = $notify->Handle(false);
    	//验证签名成功
    	if($result)
    	{
    		$xml = file_get_contents('php://input');
	    	file_put_contents("log.txt", var_export($xml,1)."\n",FILE_APPEND);
    		try {
    			$dataBase = new \WxPayDataBase();
    			$result = $dataBase->FromXml($xml);
    			
    			$orderService = new OrderService();
    			$order = $orderService->getOrderByOrdersn($result['out_trade_no']);
    			if($order['order_status']!= '1')
    			{	
    				file_put_contents("log.txt", var_export('订单已支付或者商户订单号不存在',1)."\n",FILE_APPEND);
    				 $notify->setNofity('FAIL','订单已支付或者商户订单号不存在'); return;
    			}
    			$res = $orderService->updateOrderStatus($result['out_trade_no'],$result['transaction_id']);
    			if(!$res)
    			{	
    				file_put_contents("log.txt", var_export('订单状态更新失败',1)."\n",FILE_APPEND);
    				$notify->setNofity('FAIL','订单状态更新失败'); return;
    			}
    			file_put_contents("log.txt", var_export('订单状态更新成功',1)."\n",FILE_APPEND);
    			$notify->setNofity('SUCCESS','订单状态更新成功');return;
    		} catch (WxPayException $e){
    			$msg = $e->errorMessage();
    			$notify->setNofity('FAIL',$msg); return;
    		}
    	}else
    	{
    		file_put_contents("log.txt", var_export("fail",1)."\n",FILE_APPEND);
    		$notify->setNofity('FAIL','数据验证失败'); return;
    	}
    }
    
}