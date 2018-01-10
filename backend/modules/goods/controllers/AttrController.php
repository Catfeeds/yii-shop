<?php
/**
* 商品属性相关操作
* @Name  AttrController.php
* @Author  Chenling
* @Version  1.0
* @Date:  2017-11-19上午11:30:46
* @Description 
*/
namespace backend\modules\goods\controllers;
use yii;
use common\models\goods\Category;
use common\models\goods\mongodb\Attr;
class AttrController extends \yii\web\Controller
{
	
    
    public function actionIndex()
    {	    	
    	$request = Yii::$app->request;		
    	
    	$cate_id = (int) $request->get('id');
    	$data = Attr::find()->where(['cid'=> $cate_id])->asArray()->all();
    	return $this->render('index',['data' => $data]);
    }
    
    
    
    public function actionUpdate()
    {
    	$request = Yii::$app->request;		
    	$cate_id = (int) $request->post('cate_id');
    	$data =  $request->post( 'attr_value_data' );//销售属性
    	if(!$data)
    	{
    		Attr::deleteAll(['cid'=>$cate_id]);
    		return $this->redirect(['category/index']);//清空
    	}
    	$ids = array_column($data,'id');
    	$existArr = Attr::find()->where(['cid' => $cate_id])->asArray()->all();
    	$existIds = array_column($existArr,'_id');
    	$result = array_diff($existIds, $ids);
    	if($result)
    	{
    		foreach($result as $value)
    		{
    			$model = Attr::findOne($value);
    			$model->delete();
    		}
    	}
    	foreach($data as  $value)
    	{	
    		//update
    		if(isset($value['id']) && strlen($value['id'])>10)
    		{
    			$attr = Attr::findOne(['_id' => $value['id'],'cid' => $cate_id]);
    			$attr->setAttributes($value,false);
    			if($attr->validate() && $attr->save())
    			{
    				Yii::$app->getSession()->setFlash('success', yii::t('app', 'Success'));
    			}else
    			{
    				Yii::$app->getSession()->setFlash('error', '修改失败');
    			}
    		}else
    		{	//add
	    		$value['cid'] = $cate_id;
			    $model = new Attr();
			    $model->setAttributes($value,false);
			    if($model->validate() && $model->save())
			    {
			    		yii::$app->getSession()->setFlash('success', yii::t('app', 'Success'));
			    }else
			    {
			    		$errors = $model->getErrors();
			    		$err = '';
			    		foreach ($errors as $v) {
			    			$err .= $v[0] . '<br>';
			    		}
			    		Yii::$app->getSession()->setFlash('error', $err);
			    }
    		}
    	}
	    return $this->redirect(['index','id' => $cate_id]);
    }
   
    
    
    
}
