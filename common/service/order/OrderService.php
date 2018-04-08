<?php
/**
 * Created by PhpStorm.
 * User: grace
 * Date: 2017\12\7 0007
 * Time: 13:56
 */

namespace common\service\order;

use Yii;
use common\models\goods\mongodb\Goods;
use common\models\goods\Category;
use common\service\BaseService;
use common\models\goods\Store;
use common\models\goods\Product;
use common\models\order\UserAddress;
use common\service\goods\GoodsService;
use common\models\order\Order;
use common\models\order\OrderGoods;
use common\models\goods\mongodb\Cart;
class OrderService extends BaseService
{	
	public $errorMsg;
	
	public $data = [];//购物车商品数据
	
	
	public $orderSn;
	
    public function init()
    {
        parent::init(); // TODO: Change the autogenerated stub
    }
	
    
    /**
    * @desc 创建订单
    */
    public function  create($userId,$addressId,$message)
    {
    	$address = UserAddress::findOne($addressId);
    	if(!$address)
    	{
    		$this->errorMsg = '找不到相应的收获地址';
    		return false;
    	}
    	$orderAmount = $this->getOrderAmount();
    	if(!$orderAmount)
    	{
    		return false;
    	}
    	$orderSn = $this->getOrderId();
    	$orderData = ['order_amount' =>$orderAmount,'consignee' =>$address['consignee'],'mobile' =>$address['mobile'],'province' =>$address['province'],
    					'city' =>$address['city'],'district' => $address['district'],'address' => $address['address'],'created_at' =>time(),'updated_at' => time(),
    					'order_sn' =>$orderSn,'message' => $message,'user_id' => $userId,'order_status' => 1
    	];
    	$orderModel = new Order();
    	$transaction = Order::getDb()->beginTransaction();
    	$orderModel->setAttributes($orderData,false);
    	if($orderModel->save())
    	{
	    	if($this->createOrderGoods($orderModel->id))
	    	{
	    		$transaction->commit();
	    		$this->orderSn = $orderSn;
	    		$this->removeCart($userId);
	    		return true;
	    	}
	    		$transaction->rollBack();
	    		$this->errorMsg = '生成订单商品失败';
	    		return false;
    	}
    	$this->errorMsg = '生成订单失败';
    	$transaction->rollBack();
    	return false;
    }
    
    /**
    * @desc 生成订单号 
    * @param
    */
    private function getOrderId()
    {
    	return date('Ymd').uniqid();
    }
    
    /**
    * @desc 计算总金额 
    * @param
    */
    private function getOrderAmount()
    {
    	$key = Yii::$app->params['goods.selectcart'];
    	$goods= Yii::$app->session->get($key);
    	if(!$goods)
    	{
    		$this->errorMsg = '购物车数据错误，重新提交确认订单';
    		return false;
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
		$this->data = $data;
    	$total = 0;
		foreach($data as $v)
		{
			$total += round($v['shop_price'] * $v['goods_num'],2);	
		}
		return $total;
    }
    
    /**
    * @desc  入库商品详情表
    * @param
    */
    private function createOrderGoods($orderId)
    {
    	foreach ($this->data as $value)
    	{	
	    	$model = new OrderGoods();
    		$model->order_id = $orderId;
    		$model->goods_num = $value['goods_num'];
    		$model->shop_price = $value['shop_price'];
    		$model->goods_name = $value['name'];
    		$model->goods_image = $value['image'][0];
    		$model->goods_id = (string)$value['_id'];
    		if(!$model->save())
    		{	
    			return false;
    		}
    	}
    	return true;
    	
    }
    
    /**
    * @desc 生成数据后清空相应的购物车数据(一般不采用deleteAll)
    * 直接购买可以省略这一步
    */
    private function removeCart($userId)
    {
    	foreach($this->data as $v)
    	{	
    		$cartModel = Cart::findOne(['user_id' =>$userId,'goods_id' =>(string)$v['_id']]);
    		
    		if($cartModel)
    		{
    			$cartModel->delete();
    		}
    	}
    	return true;
    }
    
    /**
    * @desc  根据order_sn查询 
    * @param
    */
    public function getOrderByOrdersn($orderSn)
    {
    	$order = Order::find()->select(['*'])->where(['order_sn' =>$orderSn])->asArray()->one();
    	return $order ?: [];
    }
    
    
    public function getOrderGoodsByOrderId($orderId)
    {
    	$orderGoods = OrderGoods::find()->select(['*'])->where(['order_id' =>$orderId])->asArray()->one();
    	return $orderGoods ?: [];
    }
    
    /**
    * @desc  更新订单状态
    * @param
    */
    public function updateOrderStatus($orderSn,$tradeNo)
    {
    	 $orderModel = Order::findOne(['order_sn' => $orderSn,'order_status' =>1]);
    	 if($orderModel)
    	 {
    	 	$orderModel->order_status = 2;
    	 	$orderModel->trade_no = $tradeNo;
    	 	$orderModel->save();
    	 	return true;
    	 }
    	 return false;
    }
    
    /**
    * @desc订单列表 
    * @param
    * @return
    */
    public function getList($userId,$page=0,$size=10,$orderStatus=-1)
    {	
    	$size = $size ?: 10 ;
    	$page = $page ?: 0;
    	$offset = $page*$size;
    	$where = ['user_id' => $userId];
    	if($orderStatus !=-1)
    	{
    		$where['order_status'] = $orderStatus;
    	}
    	$orderData = Order::find()->select(['order_status','order_sn','order_amount','consignee','id'])->where($where)->offset($offset)->limit($size)->asArray()->all();
    	foreach($orderData as $k =>$v)
    	{	
    		$goodsList = OrderGoods::find()->select(['*'])->where(['order_id' =>$v['id']])->asArray()->all();
    		$v['goods_list'] = $goodsList;
    		$orderData[$k] = $v;
    	}
    	return $orderData ?: [];
    }
    
    /**
    * @desc 取消订单
    */
    public function cancel($orderSn,$userId)
    {
    	$orderModel = Order::findOne(['order_sn' => $orderSn,'user_id' =>$userId]);
    	if($orderModel->order_status == '1')
    	{
    		$orderModel->order_status = 4;
    		$orderModel->save();
    		return true;
    	}
    	return false;
    }
    
    /**
    * @desc 商家发货
    * @param $id primary key
    * @param $shippingId 配送方式id
    * @param 发货订单号
    */
    public function send($id,$shippingId,$invoiceNo)
    {
    	$model = Order::findOne($id);
    	if($model)
    	{
    		$model->shipping_id = $shippingId;
    		$model->invoice_no = $invoiceNo;
    		if($model->save())
    		{
    			return true;
    		}
    	}
    	return false;
    }
}