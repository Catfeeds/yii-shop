<?php

namespace frontend\controllers;

use Yii;
use common\service\goods\CartService;
use common\service\goods\GoodsService;
class CartController extends BaseController
{
	
    
    public function actionIndex()
    {	
    	return $this->render('index');
    }

    /**
     * 添加购物车
     * Displays homepage.
     */
    public function actionAddcart()
    {	
    	$goodsNum = (int)Yii::$app->request->post('goods_num');
    	$goodsId = (string)Yii::$app->request->post('goods_id');
    	if($goodsNum<1 || !$goodsId)
    	{
    		return ['status' =>1,'msg' =>'参数错误'];
    	}
    	$store = GoodsService::getStore($goodsId);
    	//检查库存
    	if($store < $goodsNum)
    	{
    		return ['status' =>1,'msg' =>'库存不足'];
    	}
    	CartService::addLoginCart($goodsNum, $goodsId);	
        
       	return ['status' => 0,'msg'=>'添加成功'];
    }
    
    
    /*购物车列表*/
    public function actionGetlist()
    {
    	$data = CartService::getCartData();
    	return ['status' =>0,'data' =>$data];
    }
    
    
    /**
    * @desc 删除购物车
    * @return
    */
    public function actionRemove()
    {	
    	$id = Yii::$app->request->post('id');
    	if(!$id)
    	{
    		return ['status' => 1,'msg' =>'参数错误'];
    	}
    	CartService::remove($id);	
    	return ['status' =>0,'msg' =>'删除成功'];
    }
    

}