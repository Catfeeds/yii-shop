<?php
/**
 * User: Xany <762632258@qq.com>
 * Date: 2017/6/24
 * Time: 22:31
 */

namespace app\controllers;


use common\models\shop\User;
use common\models\shop\form\LoginForm;

class PassportController extends Controller
{
    public function actionLogin()
    {
        $form = new LoginForm();
        $form->attributes = \Yii::$app->request->post();
        $form->wechat_app = $this->wechat_app;
        $form->store_id = $this->store->id;
        return $this->renderJson($form->login());
    }
}