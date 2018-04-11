<?php
/**
 * Author: lf
 * Blog: https://blog.feehi.com
 * Email: job@feehi.com
 * Created at: 2017-03-15 21:16
 */

namespace backend\modules\goods\controllers;

use yii\data\ActiveDataProvider;
use backend\models\order\Order;
use backend\actions\CreateAction;
use backend\actions\UpdateAction;
use backend\actions\IndexAction;
use backend\actions\DeleteAction;
use common\service\order\ShippingService;
use common\service\order\OrderService;
use common\helpers\FuncHelper;

use Yii;
/**
 * FriendLink controller
 */
class OrderController extends \yii\web\Controller
{

    public function actions()
    {
        return [
            'index' => [
                'class' => IndexAction::className(),
                'data' => function(){
                    $searchModel = new Order();
                    $dataProvider = $searchModel->search(yii::$app->getRequest()->getQueryParams());
                    return [
                        'dataProvider' => $dataProvider,
                        'searchModel' => $searchModel
                    ];
                }
            ],
            'update' => [
                'class' => UpdateAction::className(),
                'modelClass' => Order::className(),
            ],
        ];
    }
	
    
    /**
    * @desc 发货
    */
    public function actionSend($id)
    {	
    	if(yii::$app->getRequest()->getIsPost())
    	{
    		if (! $id) throw new BadRequestHttpException(yii::t('app', "Id doesn't exit"));
    		$invoiceNo = Yii::$app->request->post('invoice_no');
    		$shippingId = Yii::$app->request->post('shipping_id');
    		$orderService = new OrderService();
    		if($orderService->send($id, $shippingId, $invoiceNo))
    		{
    			Yii::$app->getSession()->setFlash('success', yii::t('app', 'Success'));
    			return $this->redirect(['index']);
    		}
    		
    		Yii::$app->getSession()->setFlash('error', yii::t('app', 'Error'));
    		return $this->redirect(['index']);
    		
    	}else
    	{
	    	$service = new ShippingService();
	    	$data = $service->getList();
	    	return $this->render('send',['data' => $data]);
    	}
    	
    }
    
    
    public function actionViewLayer($id)
    {
    	$service = new OrderService();
    	$data = $service->getOrderGoodsByOrderId($id);
    	$model = Order::findOne($id);
    	return $this->render('view',['data' => $data,'model' =>$model]);
    }
    
    
    public function actionExport()
    {
    	$searchModel = new Order();
    	$dataProvider = $searchModel->search(yii::$app->getRequest()->getQueryParams());
    	$query = $dataProvider['query'];
    	$count = $query->count();
    	if($count>1000)
    	{
    		return ['code' => 1, 'message' => '导出的数据太于1000条，请筛选一些重试'];
    	}
    	$data = $query->select(['order_sn','trade_no','invoice_no','consignee','mobile','address']);
    	FuncHelper::exportexcel($data);
    }
}
