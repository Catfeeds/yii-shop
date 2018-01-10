<?php

namespace backend\modules\goods\controllers;
use yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use backend\actions\CreateAction;
use backend\actions\UpdateAction;
use backend\actions\IndexAction;
use backend\actions\DeleteAction;
use backend\actions\SortAction;
use backend\actions\StatusAction;
use common\models\goods\Category;
class CategoryController extends \yii\web\Controller
{
	
	public function actions()
    {	
        return [
            'index' => [
                'class' => IndexAction::className(),
                'data' => function(){
                    $searchModel = new Category();
                    $dataProvider = $searchModel->search(yii::$app->getRequest()->getQueryParams());
                    return [
                        'dataProvider' => $dataProvider,
                    ];
                }
              
            ],
            'create' => [
            	'class' => CreateAction::className(),
            	'modelClass' => Category::className(),
            ],
            'update' => [
            	'class' => UpdateAction::className(),
            	'modelClass' => Category::className(),
            ],
            'delete' => [
            	'class' => DeleteAction::className(),
            	'modelClass' => Category::className(),
            ],
           
        ];
    }
    
    
   
    
}
