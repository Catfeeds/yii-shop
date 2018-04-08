<?php
/**
 * Author: lf
 * Blog: https://blog.feehi.com
 * Email: job@feehi.com
 * Created at: 2017-03-15 21:16
 */

namespace backend\modules\goods\controllers;

use yii\data\ActiveDataProvider;
use common\models\order\Order;
use backend\actions\CreateAction;
use backend\actions\UpdateAction;
use backend\actions\IndexAction;
use backend\actions\DeleteAction;
use common\service\order\ShippingService;
use common\service\order\OrderService;

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
}
