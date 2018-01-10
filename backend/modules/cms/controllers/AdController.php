<?php


namespace backend\modules\cms\controllers;

use yii\data\ActiveDataProvider;
use common\models\Ad;
use backend\actions\CreateAction;
use backend\actions\UpdateAction;
use backend\actions\IndexAction;
use backend\actions\DeleteAction;

/**
 * FriendLink controller
 */
class AdController extends \yii\web\Controller
{

    public function actions()
    {
        return [
            'index' => [
                'class' => IndexAction::className(),
                'data' => function(){
                    $query = Ad::find();
                    $dataProvider = new ActiveDataProvider([
                        'query' => $query,
                        'sort' => [
                            'defaultOrder' => [
                                'sort' => SORT_ASC,
                                'id' => SORT_ASC,
                            ],
                        ]
                    ]);
                    return [
                        'dataProvider' => $dataProvider,
                    ];
                }
            ],
            'create' => [
                'class' => CreateAction::className(),
                'modelClass' => Ad::className(),
            ],
            'update' => [
                'class' => UpdateAction::className(),
                'modelClass' => Ad::className(),
            ],
            'delete' => [
                'class' => DeleteAction::className(),
                'modelClass' => Ad::className(),
            ],
        ];
    }

}
