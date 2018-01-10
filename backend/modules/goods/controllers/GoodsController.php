<?php

namespace backend\modules\goods\controllers;

use yii;
use backend\actions\IndexAction;
use backend\actions\DeleteAction;
use common\models\goods\mongodb\Goods;
use common\models\goods\mongodb\Attr;
use common\models\goods\Store;
use common\models\goods\Product;
class GoodsController extends \yii\web\Controller
{

    public function actions()
    {	
        return [
            'index' => [
                'class' => IndexAction::className(),
                'data' => function(){
                    $searchModel = new Goods();
                    $dataProvider = $searchModel->search(yii::$app->getRequest()->getQueryParams());
                    return [
                        'dataProvider' => $dataProvider,
                        'searchModel' => $searchModel,
                    ];
                }
            ],
            'delete' => [
            	'class' =>DeleteAction::className(),
            	'modelClass' =>Goods::className()
            ]
        ];
    }
    
    
    
    public function actionSelectcate()
    {	
    	$request = Yii::$app->request;
    	if($request->isPost)
    	{
    		$cid =(int)$request->post('Goods')['cid'];
    		return $this->redirect(['create','cid' => $cid]);
    	}else
    	{
	    	$model = new Goods();
	    	return $this->render('selectcate',['model' => $model]);
    	}
	}
    
	
	public function actionCreate()
	{	
		$request = Yii::$app->request;
		if($request->isPost)
		{	
			$goods = $request->post('Goods');
			$store = $request->post('store');
			if($goods['is_product'] != 1 && $store <1)
			{
				Yii::$app->getSession()->setFlash('error', '库存必填');
				return $this->redirect(['index']);
			}
			$model = new Goods();
			$model->setAttributes($goods,false);
			$err = '';
			if($model->validate() && $model->save())
			{	if($goods['is_product'] == 1)
				{
					$product = $request->post('product');
					foreach($product as $value)
					{	
						$tmp = [];
						foreach($value['attr'] as $v)
						{	
							$tmp[] =json_decode($v,true);
						}
						if($value['disabled']=='2')
						{
							continue;
						}
						$product =new Product();	//生成prduct表
						$product->setAttributes($value, false);
						$product->goods_id = (string)$model->_id;
						$product->attr = json_encode($tmp);						
						if(!$product->validate()|| !$product->save())
						{
							$errors = $product->getErrors();
							foreach ($errors as $v) {
								$err .= $v[0] . '<br>';
							}
							Yii::$app->getSession()->setFlash('error', $err);
						}else
						{
							Yii::$app->getSession()->setFlash('success', yii::t('app', 'Success'));
						}
					}
					return $this->redirect(['index']);
				}else
				{
					//插入goods_store表
					$storeModel = new Store();
					
					$storeModel->goods_id =(string) $model->_id;
					$storeModel->store =  $store;
					if($storeModel->validate() && $storeModel->save())
					{
						Yii::$app->getSession()->setFlash('success', yii::t('app', 'Success'));
					}else
					{
						$errors = $storeModel->getErrors();
						foreach ($errors as $v) {
							$err .= $v[0] . '<br>';
						}
						Yii::$app->getSession()->setFlash('error', $err);
					}
					return $this->redirect(['index']);
				}
			}else
			{
				$errors = $model->getErrors();
				foreach ($errors as $v) {
					$err .= $v[0] . '<br>';
				}
				Yii::$app->getSession()->setFlash('error', $err);
				return $this->redirect(['index']);
			}
		
		}
		$cid = (int)Yii::$app->request->get('cid');
		if($cid <1)
		{	
			Yii::$app->getSession()->setFlash('error', '栏目必须选择');
			return $this->redirect(['index']);	
		}
		$attr = Attr::getAttrByCid($cid);//销售属性和扩展属性
		$model = new Goods();
		$model->cid  = $cid;
		return $this->render('create',['attr' => $attr,'model' => $model]);
	}
	
	
	public function actionUpdate()
	{	
		$request = Yii::$app->request;
		$id =(string)$request->get('id');
		
		if($request->isPost)
		{	
			$err = '';
			$goods = $request->post('Goods');
			$product = $request->post('product');
			$goodsModel = Goods::findOne($id);
			$goodsModel->setAttributes($goods,false);
			if(!$goodsModel->validate() || !$goodsModel->save())
			{
				$errors = $goodsModel->getErrors();
				foreach ($errors as $v) {
					$err .= $v[0] . '<br>';
				}
				Yii::$app->getSession()->setFlash('error', $err);
				return $this->redirect(['index']);
			}
			if($goods['is_product'] ==1)
			{	
				foreach($product as $p )
				{	
					if($p['id'])
					{
						$productModel = Product::findOne($p['id']);
						$productModel->setAttributes($p);
						$productModel->save();
					}else
					{
						$tmp = [];
						foreach($p['attr'] as $v)
						{
							$tmp[] =json_decode($v,true);
						}
						if($p['disabled']=='2')
						{
							continue;
						}
						$productModel = new Product();
						$p['attr'] = json_encode($tmp);
						$productModel->setAttributes($p);
					}
				}
			}else
			{
				$storeModel = Store::findOne(['goods_id'=>$id]);
				$storeModel->store = $request->post('store');
				$storeModel->save();
			}
			Yii::$app->getSession()->setFlash('success', yii::t('app', 'Success'));
			return $this->redirect(['index']);
		}else{
			$model = Goods::findOne($id);
			$attr = Attr::getAttrByCid($model->cid);
			$products = [];
			$checkedSku = [];
			$checkedAttrid = [];
			$head = [];
			$store = [];
			$jsAttr = [];
			if($model->is_product ==1)
			{
				$products = Product::find()->where(['goods_id' => $id])->asArray()->all();
				foreach($products as $key=>$value)
				{	
					$prodctAttr = json_decode($value['attr'],true);
					$checkedAttrid = array_column($prodctAttr,'attr_id');
					foreach($prodctAttr as $sku)
					{
						$checkedSku[] = $sku['value'];
					}
					$value['attr_name'] = array_column($prodctAttr,'value');
					$jsAttr[] = array_column($prodctAttr,'value');
					$products[$key] = $value;
				}
				$head = Attr::find()->where(['in','_id',$checkedAttrid])->select(['name'])->asArray()->all();
			}else
			{
				$store =Store::find()->where(['goods_id' => $id])->asArray()->one();
			}
			return $this->render('update',['model' => $model,'attr' => $attr,'products' => $products,'checkedSku' => $checkedSku,'head' => $head,'store'=>$store,'jsAttr'=>json_encode($jsAttr)]);
	
		}
	}
	
}