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
		return json_encode(['status' =>0,'articles' =>$articles ]);  	
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
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
    	try {
    		$model = new ResetPasswordForm($token);
    	} catch (InvalidParamException $e) {
    		throw new BadRequestHttpException($e->getMessage());
    	}
    
    	if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
    		Yii::$app->session->setFlash('success', 'New password saved.');
    
    		return $this->goHome();
    	}
    
    	return $this->render('resetPassword', [
    			'model' => $model,
    			]);
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
    	ob_clean();
    	$captcha = new ValidateCode();
    	$captcha->doimg();
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
    			//TODO 发送短信
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
    		if(strtolower(Yii::$app->session->get('captcha')) != strtolower($captcha))
    		{
    			return ['status' =>1,'msg' =>'验证码不正确'];
    		}
    		if(User::findByMobile($mobile))
    		{
    			//TODO 发送短信
    			return ['status' =>0,'msg' =>'发送成功'];
    		}else
    		{
    			return ['status' =>1,'msg' =>'手机号未注册'];
    		}
    	}
    }

}
