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

}
