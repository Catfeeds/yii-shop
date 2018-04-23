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
    	if(!$id)
    	{
    		return ['status' => 1,'msg' =>'参数错误'];
    	}
    	
    	$data = UserAddress::find()->select(['*'])->where(['user_id' =>$this->userId,'id' =>$id])->asArray()->one();
    	$data = $data ?:[];
    	return json_encode(['status' =>0,'data' =>$data]);
    }
    
    
    
	public function actionUpdate()
	{
		
	}   
	
	
	public function actionGetlist()
	{
		$addressModel = new UserAddress();
		$data = $addressModel->getList($this->userId);
		return ['status' => 0,'data' => $data];
	}

	
    /**
     * 添加收获地址
     * */
    public function actionAdd()
    {	
    	$data = Yii::$app->request->post();
    	$gender = ['先生'=>1,'女士' =>2];
    	$data['gender'] = $gender[$data['gender']] ?: 1;
    	
    	$data['user_id'] = $this->userId;
    	$addressModel = new UserAddress();
    	if($addressModel->add($data))
    	{
    		return ['status' => 0,'msg' =>'添加成功','id' => $addressModel->id];
    	}else
    	{
    		return ['status' =>1,'msg' =>$addressModel->errorMsg];
    	}
    }
    
    
    public function actionDelete()
    {
    	$id = (int)Yii::$app->request->get('id');
    	if(!$id)
    	{
    		return ['status' => 1,'msg' =>'参数错误'];
    	}
    	$model =UserAddress::findOne($id);
    	if($model->user_id == $this->userId)
    	{
    		$model->delete();
    		return ['status' =>0,'msg' =>'删除成功'];
    	}
    	return ['status' =>1,'msg' =>'参数异常'];
    }

}
