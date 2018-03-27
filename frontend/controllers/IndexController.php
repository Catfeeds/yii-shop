<?php

namespace frontend\controllers;

use common\service\BannerService;
use common\service\CategoryService;
use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
/**
 * Site controller
 */
class IndexController extends BaseController
{
    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $data['banner'] = BannerService::index();
        return $this->render('index',$data);
    }
    

}