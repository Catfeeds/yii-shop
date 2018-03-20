<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\helpers\Url;
use common\models\order\UserAddress;
/**
 * Site controller
 */
class AddressController extends BaseController
{
    
    


    public function actionIndex()
    {
    	return $this->render('index');
    }
    
    
    
    
    
    public function actionEdit()
    {	
    	$id = (int)Yii::$app->request->get('id');
    	if($id)
    	{
	    	return $this->render('edit',['id' =>$id]);
    	}else
    	{
    		return $this->render('add');
    	}
    }
    
    
    public function actionGetone()
    {	
    	$id = (int)Yii::$app->request->get('id');
    	$data = $UserAddress::findOne($id);
    	return ['status' =>0,'data' =>$data];
    }
    
    
    
	public function actionUpdate()
	{
		
	}   
	
	
	public function actionGetlist()
	{
		$userId = Yii::$app->user->identity->user_id;
		$addressModel = new UserAddress();
		$data = $addressModel->getList($userId);
		return ['status' => 0,'data' => $data];
	}

	
    /**
     * 添加收获地址
     * */
    public function actionAdd()
    {	
    	$data = Yii::$app->request->post();
    	$addressModel = new UserAddress();
    	if($addressModel->add($data))
    	{
    		return ['status' => 0,'msg' =>'添加成功'];
    	}else
    	{
    		return ['status' =>1,'msg' =>$addressModel->errorMsg];
    	}
    }

}