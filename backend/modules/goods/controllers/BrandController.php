<?php
/**
 * Author: lf
 * Blog: https://blog.feehi.com
 * Email: job@feehi.com
 * Created at: 2017-03-15 21:16
 */

namespace backend\modules\goods\controllers;

use yii\data\ActiveDataProvider;
use common\models\goods\mongodb\Brand;
use backend\actions\CreateAction;
use backend\actions\UpdateAction;
use backend\actions\IndexAction;
use backend\actions\DeleteAction;

/**
 * FriendLink controller
 */
class BrandController extends \yii\web\Controller
{

    public function actions()
    {
        return [
            'index' => [
                'class' => IndexAction::className(),
                'data' => function(){
                    $query = Brand::find();
                    $dataProvider = new ActiveDataProvider([
                        'query' => $query
                    ]);
                    return [
                        'dataProvider' => $dataProvider,
                    ];
                }
            ],
            'create' => [
                'class' => CreateAction::className(),
                'modelClass' => Brand::className(),
            ],
            'update' => [
                'class' => UpdateAction::className(),
                'modelClass' => Brand::className(),
            ],
            'delete' => [
                'class' => DeleteAction::className(),
                'modelClass' => Brand::className(),
            ],
        ];
    }

}
