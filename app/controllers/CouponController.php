<?php
/**
 * User: Xany <762632258@qq.com>
 * Date: 2017/8/24
 * Time: 18:40
 */

namespace app\controllers;


use app\behaviors\LoginBehavior;
use common\models\shop\CouponIndexForm;
use common\models\shop\CouponShareSendForm;

class CouponController extends Controller
{
    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            'login' => [
                'class' => LoginBehavior::className(),
            ],
        ]);
    }

    //我的优惠券列表
    public function actionIndex()
    {
        $form = new CouponIndexForm();
        $form->attributes = \Yii::$app->request->get();
        $form->store_id = $this->store->id;
        $form->user_id = \Yii::$app->user->id;
        $this->renderJson($form->search());
    }

    //分享页面送优惠券
    public function actionShareSend()
    {
        $form = new CouponShareSendForm();
        $form->store_id = $this->store->id;
        $form->user_id = \Yii::$app->user->id;
        $this->renderJson($form->save());
    }
    public function actionReceive()
    {
        $form = new CouponShareSendForm();
        $form->store_id = $this->store->id;
        $form->user_id = \Yii::$app->user->id;
        $form->id = \Yii::$app->request->get('id');
        $this->renderJson($form->send());
    }

}