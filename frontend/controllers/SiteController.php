<?php
namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use common\models\Article;
use yii\helpers\Url;
use common\widgets\captcha\ValidateCode;
use common\models\User;
use common\service\auth\Qq;
use common\service\auth\Weixin;
use common\service\sms\SendSms;

/**
 * Site controller
 */
class SiteController extends BaseController
{
    
    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {	    	
        return $this->render('index');
    }

    
    public function actionOld()
    {
    	return $this->render('old');
    }
    
    public function actionMember()
    {
    	return $this->render('member');
    }
    
    public function actionSource()
    {
    	return $this->render('source');
    }
    
    public function actionManagement()
    {
    	return $this->render('management');
    }


    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {	
        return $this->render('about');
    }
    
    
    public function actionNews()
    {	
    	return $this->render('news');
    }
    
    
    
    public function actionNewslist()
    {	
    	$offset = (int)Yii::$app->request->get('offset')+0;
    	$size = (int)Yii::$app->request->get('size')+0;
    	if(!$size)
    	{
    		$size = 10;
    	}
    	$articles = Article::getList($offset,$size);
    	foreach($articles as $k=>$value){
    		$value['created_at'] = date('Y-m-d',$value['created_at']);
    		$value['thumb'] = Yii::$app->params['image'].$value['thumb'];
    		$value['url'] = Url::to('/site/detail?id='.$value['id']);
    		$value['summary'] = mb_substr($value['summary'], 0,75);
    		$articles[$k]= $value;
    	}
		return ['status' =>0,'articles' =>$articles ];  	
    }
    
    public function actionDetail()
    {	
    	$id =(int) Yii::$app->request->get('id');
    	$data['article'] = Article::getArticleById($id);
    	$view = Yii::$app->view;
    	$view->params['title'] = $data['article']['seo_title'];
    	$view->params['keywords'] = $data['article']['seo_keywords'];
    	$view->params['description'] = $data['article']['seo_description'];
    	return $this->render('detail',$data);
    }
    
    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
    	if(Yii::$app->request->isAjax)
    	{
    		$model = new LoginForm();
    		if ($model->load(['data' =>Yii::$app->request->post()],'data') && $model->login()) {
    			return ['status' =>0,'msg' =>''];
    		} else {
    			return ['status' =>1,'msg' =>'用户名或者密码错误'];
    		}
    	}else
    	{
    		if (!Yii::$app->user->isGuest) {
    			return $this->goHome();
    		}
    		$returnUrl = '/';
    		$qq = new Qq();
    		$weixin = new Weixin();
    		return $this->render('login', ['returnUrl' => $returnUrl,'qqUrl' =>$qq->url(),'weixinUrl' =>$weixin->url()]);
    	}
    }
    
    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
    	Yii::$app->user->logout();
    
    	return $this->goHome();
    }
    
    
    
    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {	
    	$model = new User();
    	$model->setScenario('create');
    	if (yii::$app->request->isAjax && $model->load(['data' =>Yii::$app->request->post()],'data')) {
	    	
    		$code = Yii::$app->request->post('code');
	    	$mobile = Yii::$app->request->post('mobile');
	    	if(!$code || !$mobile)
	    	{
	    		return ['status' =>1,'msg'=>'参数错误'];
	    	}
	    	$redisCode = Yii::$app->redis->get('register'.$mobile);
	    	if(!$redisCode || ($redisCode!=$code))
	    	{
	    		return ['status' => 1,'msg' =>'验证码过期或者错误'];
	    	}
	    	
    		if ($model->validate()&& $model->save()) {
    			if (Yii::$app->getUser()->login($model)) {
    				return ['status' =>0,'msg' =>''];
    			}
    		}else{
    			return ['status' =>1,'msg' =>''];
    		}
    	}
    	$qq = new Qq();
    	$weixin = new Weixin();
    	return $this->render('signup', ['qqUrl' =>$qq->url(),'weixinUrl' =>$weixin->url()]);
    }
    
    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestpasswordreset()
    {
    	return $this->render('requestpasswordreset');
    }
    
    /**
     * Resets password.
     *
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetpassword()
    {
    	if(Yii::$app->request->isAjax)
    	{	
    		//TODO 做手机验证码验证
    		$code = Yii::$app->request->post('code');
	    	$mobile = Yii::$app->request->post('mobile');
	    	$pasword = Yii::$app->request->post('password');
	    	if(!$code || !$mobile || !$pasword)
	    	{
	    		return ['status' => 1,'msg' =>'参数异常'];
	    	}
	    	$redisCode = Yii::$app->redis->get('resetpwd'.$mobile);
	    	if(!$redisCode || ($code != $redisCode))
	    	{
	    		return ['status' => 1,'msg' =>'验证码过期或者错误'];
	    	}
	    	try {
	    		$model = new ResetPasswordForm($mobile);
	    	} catch (InvalidParamException $e) {
	    		return ['status' =>1,'msg' =>$e->getMessage()];
	    	}
	    	
	    	$model->password = $pasword;
	    	if(!$model->validate())
	    	{	
	    		$erros = $model->getErrors();
	    		$msg = '';
	    		foreach ($erros as $v)
	    		{
	    			$msg = $v;break;
	    		}
	    		return ['status' => 1,'msg' =>$msg];
	    	}
	    	if ($model->resetPassword()) {
	    		return ['status' =>0,'msg'=>'修改成功'];
	    	}
	    	return ['status' =>1,'msg' =>'修改失败'];
    	}
    	
    }
    
    
    public function actionCheckMobile()
    {
    	if(Yii::$app->request->isAjax)
    	{
    		$mobile = Yii::$app->request->get('mobile');
    		if(User::findByMobile($mobile))
    		{
    			return ['status' =>1,'msg' =>'手机号被使用'];
    		}else
    		{
    			return ['status' =>0,'msg' =>''];
    		}
    	}
    }
	
    
    
    public function actionCaptcha()
    {	
    	ob_end_clean();
    	$captcha = new ValidateCode();
    	$captcha->outimg();
    	Yii::$app->session->set('captcha',$captcha->getCode());
    }
    
    /**
     * 发送短信(注册)api
     * */
    public function actionSendmsg()
    {
    	if(Yii::$app->request->isAjax)
    	{
    		$mobile = Yii::$app->request->post('mobile');
    		$captcha = Yii::$app->request->post('captcha');
    		if(!$captcha)
    		{
    			return ['status' =>1,'msg' =>'验证码不能为空'];
    		}
    		if(strtolower(Yii::$app->session->get('captcha')) != strtolower($captcha))
    		{
    			return ['status' =>1,'msg' =>'验证码不正确'];
    		}
    		if(User::findByMobile($mobile))
    		{
    			return ['status' =>1,'msg' =>'手机号被使用'];
    		}else
    		{	
    			$code = rand(100000, 999999);
    			$sms = new SendSms();
    			$result = $sms->send($mobile, $code);
    			if($result['Code'] !='OK')
    			{
    				return ['status' =>1,'msg' =>'发送失败'];
    			}
    			$redis =Yii::$app->redis;
    			$redis->set('register'.$mobile,$code);
    			$redis->expire('register'.$mobile,300);
    			return ['status' =>0,'msg' =>'发送成功'];
    		}
    	}
    }
    
    
    /**
     * 发送短信(忘记密码)api
     * */
    public function actionResetpasswordsendmsg()
    {
    	if(Yii::$app->request->isAjax)
    	{
    		$mobile = Yii::$app->request->post('mobile');
    		$captcha = Yii::$app->request->post('captcha');
    		if(!$captcha)
    		{
    			return ['status' =>1,'msg' =>'验证码不能为空'];
    		}
    		if(strlen($mobile) != 11)
    		{
    			return ['status' =>1,'msg' =>'手机格式不对'];
    		}
    		if(strtolower(Yii::$app->session->get('captcha')) != strtolower($captcha))
    		{
    			return ['status' =>1,'msg' =>'验证码不正确'];
    		}
    		if(User::findByMobile($mobile))
    		{
    			$code = rand(100000, 999999);
    			$sms = new SendSms();
    			$result = $sms->send($mobile, $code,'Template_Resetpwd');
    			if($result['Code'] !='OK')
    			{
    				return ['status' =>1,'msg' =>'发送失败'];
    			}
    			
    			$redis =Yii::$app->redis;
    			$redis->set('resetpwd'.$mobile,$code);
    			$redis->expire('resetpwd'.$mobile,300);
    			return ['status' =>0,'msg' =>'发送成功'];
    		}else
    		{
    			return ['status' =>1,'msg' =>'手机号未注册'];
    		}
    	}
    }
    
	
    
    public function actionMsg()
    {	
    	return $this->render('msg');
    }
}
