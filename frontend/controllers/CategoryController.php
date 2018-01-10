<?php

namespace frontend\controllers;

use common\models\goods\mongodb\Goods;
use common\service\CategoryService;


/**
 * Site controller
 */
class CategoryController extends BaseController
{

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $request = $this->myRequest();
        $ids = CategoryService::get_child_id($request['id']);
        $data['goods'] = Goods::find()->select(['_id','name','shop_price','image'])->where(['in','cid',$ids])->andWhere(['status'=>'1'])->orderBy('sort ASC')->asArray()->all();//dd($data);
        return $this->render('index',$data);
    }
}