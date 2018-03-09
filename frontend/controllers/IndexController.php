<?php

namespace frontend\controllers;

use common\service\BannerService;
use common\service\CategoryService;
use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;

/**
 * Site controller
 */
class IndexController extends BaseController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

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
    
    
    public function actionTest()
    {
    	//模式一
    	/**
    	* 流程：
    	* 1、组装包含支付信息的url，生成二维码
    	* 2、用户扫描二维码，进行支付
    	* 3、确定支付之后，微信服务器会回调预先配置的回调地址，在【微信开放平台-微信支付-支付配置】中进行配置
    	* 4、在接到回调通知之后，用户进行统一下单支付，并返回支付信息以完成支付（见：native_notify.php）
    	* 5、支付完成之后，微信服务器会通知支付成功
    	* 6、在支付成功通知中需要查单确认是否真正支付成功（见：notify.php）
    	*/
    	$notify = new NativePay();
    	 
    	//模式二
    	/**
    	* 流程：
    	* 1、调用统一下单，取得code_url，生成二维码
    	* 2、用户扫描二维码，进行支付
    	* 3、支付完成之后，微信服务器会通知支付成功
    	* 4、在支付成功通知中需要查单确认是否真正支付成功（见：notify.php）
    	*/
    	$input = new \WxPayUnifiedOrder();
    	$input->SetBody("test");
    	$input->SetAttach("test");
    	$input->SetOut_trade_no(\WxPayConfig::MCHID.date("YmdHis"));
    	$input->SetTotal_fee("1");
    	$input->SetTime_start(date("YmdHis"));
    	$input->SetTime_expire(date("YmdHis", time() + 600));
    	$input->SetGoods_tag("test");
    	$input->SetNotify_url("http://paysdk.weixin.qq.com/example/notify.php");
    	$input->SetTrade_type("NATIVE");
    	$input->SetProduct_id("123456789");
    	$result = $notify->GetPayUrl($input);
    	$url2 = $result["code_url"];
    			return $this->render('test',['url2'=>$url2]);
    }
}