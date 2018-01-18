<?php


namespace backend\modules\cms\controllers;

use yii\data\ActiveDataProvider;
use common\models\Apply;
use backend\actions\CreateAction;
use backend\actions\UpdateAction;
use backend\actions\IndexAction;
use backend\actions\DeleteAction;

/**
 * FriendLink controller
 */
class ApplyController extends \yii\web\Controller
{

    public function actions()
    {
        return [
            'index' => [
                'class' => IndexAction::className(),
                'data' => function(){
                    $query = Apply::find();
                    $dataProvider = new ActiveDataProvider([
                        'query' => $query,
                        'sort' => [
                            'defaultOrder' => [
                                'id' => SORT_ASC,
                            ],
                        ]
                    ]);
                    return [
                        'dataProvider' => $dataProvider,
                    ];
                }
            ],
            'delete' => [
                'class' => DeleteAction::className(),
                'modelClass' => Apply::className(),
            ],
        ];
    }

}
