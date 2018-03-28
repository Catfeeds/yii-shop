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

class OrderService extends BaseService
{	
	public $errorMsg;
	
	public $data = [];//购物车商品数据
	
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
	    		return true;
	    	}
	    		$transaction->rollBack();
	    		$this->errorMsg = '生成订单商品失败';
	    		return false;
    	}
    	//$this->errorMsg = '生成订单失败';
    	$errors = $orderModel->getErrors();
    	foreach($errors as $v)
    	{
    		$this->errorMsg = $v;break;
    	}
    	$transaction->rollBack();
    	return false;
    }
    
    /**
    * @desc 生成订单号 
    * @param
    */
    private function getOrderId()
    {
    	return microtime().rand(10000, 99999).uniqid();
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
    	$this->data = $data = GoodsService::getListByids($goods);
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
    		if(!$model->save())
    		{	
    			return false;
    		}
    	}
    	return true;
    	
    }
}