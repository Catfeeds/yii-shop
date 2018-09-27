<?php
namespace frontend\controllers;
use common\models\shop\form\AddressSaveForm;
use common\models\shop\form\AddressListForm;
use Yii;
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
    	return ['status' =>0,'data' =>$data];
    }
    
    
    
	public function actionUpdate()
	{	
		$data = Yii::$app->request->post();
		$id = $data['id'] +0;
		if(!$id)
		{
			return ['status' => 1,'msg' =>'参数错误'];
		}
		$addressModel = UserAddress::findOne(['id' => $id,'user_id' => $this->userId]);
		$addressModel->setAttributes($data,false);
		if($addressModel->save())
		{
			return ['status' => 0,'msg' =>'修改成功'];
		}
		return ['status' => 1,'msg' =>'修改失败'];
	}   
	
	
	public function actionGetlist()
	{
		$addressListForm = new AddressListForm();
		$addressListForm->user_id = $this->userId;
		$result= $addressListForm->search();
		return ['status' => $result['code'],'data' => $result['data']['list']];
	}

	
    /**
     * 添加收获地址
     * */
    public function actionAdd()
    {	
    	$addressAddForm = new AddressSaveForm();
    	$addressAddForm->setScenario('pc');
    	$addressAddForm->attributes = Yii::$app->request->post();
    	$addressAddForm->user_id = $this->userId;
    	$result = $addressAddForm->saveIgnore();
    	return ['status' => $result['code'],'msg' => $result['msg']];
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
