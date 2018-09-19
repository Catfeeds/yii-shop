<?php

namespace frontend\controllers;

use Yii;
use common\service\goods\CartService;
use common\models\shop\form\AddCartForm;
use common\models\shop\form\CartListForm;
use common\models\shop\form\CartDeleteForm;
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
    	$productId = (int)Yii::$app->request->post('product_id');
    	if($goodsNum<1 || !$goodsId)
    	{
    		return ['status' =>1,'msg' =>'参数错误'];
    	}
    	$addCartForm = new AddCartForm();
    	$addCartForm->goods_id = $goodsId;
    	$addCartForm->num = $goodsNum;
    	$addCartForm->product_id = $productId;
    	$addCartForm->store_id = 1;
    	$addCartForm->user_id = $this->userId;
    	$result = $addCartForm->save();
       	return ['status' => $result['code'],'msg'=>$result['msg']];
    }
    
    
    /*购物车列表*/
    public function actionGetlist()
    {
    	$cartListForm = new CartListForm();
    	$cartListForm->store_id = 1;
    	$cartListForm->user_id = $this->userId;
    	$result = $cartListForm->search();
    	return ['status' =>$result['code'],'data' =>$result['data']['list']];
    }
    
    
    /**
    * @desc 删除购物车
    * @return
    */
    public function actionRemove()
    {	
    	$id = Yii::$app->request->post('cart_id');
    	if(!$id)
    	{
    		return ['status' => 1,'msg' =>'参数错误'];
    	}
    	$cartDeleteForm = new CartDeleteForm();
    	$cartDeleteForm->user_id= $this->userId;
    	$cartDeleteForm->cart_id_list = [$id];
    	$cartDeleteForm->save();
    	return ['status' =>0,'msg' =>'删除成功'];
    }
    

}