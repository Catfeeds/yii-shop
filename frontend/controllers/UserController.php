<?php

namespace frontend\controllers;

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
use yii\helpers\Url;
use frontend\models\User;
use common\models\user\UserThird;
use common\service\auth\Qq;
use common\service\auth\Weixin;

/**
 * Site controller
 */
class UserController extends BaseController
{
	
    /**
     * 修改密码(用户中心)与Updatepassword对应
     *
     * @return mixed
     */
    public function actionUpdatepwd()
    {	
        if(Yii::$app->request->isPost)
        {
	    	if(Yii::$app->user->isGuest)
	    	{	
	    		return ['status' =>2,'msg' =>'登录过期'];
	    	}
        	$model = User::findOne(['id' => Yii::$app->getUser()->getIdentity()->getId()]);
        	$model->setScenario('self-update');
        	$model->load(['data' =>Yii::$app->request->post()],'data');
        	if($model->selfUpdate())
        	{
        		return ['status' =>0,'msg'=>'修改成功'];
        	}else
        	{
        		$errors = $model->getErrors();
        		$msg = '';
        		foreach ($errors as $v) {
        			$msg= $v[0];break;
        		}
        		return ['status' =>1,'msg' =>$msg];
        	}
        }
    }
    
    
    /**
    * @desc 修改密码页面
    */
    public function actionUpdatepassword()
    {	
    	if(Yii::$app->user->isGuest)
    	{
    		return $this->render('/site/login');
    	}
    	return $this->render('updatepassword');
    }
    
    /**
     * QQ电脑端登录回调
     * */
    public function actionAuth()
    {
    	$qq = new Qq();
    	if($qq->getAccessToken()&&$qq->getOpenid()&&$qq->getUserinfo())
    	{
    		$userInfo = $qq->userInfo;
    		$user = UserThird::findByopenid($userInfo['openid']);
    		$userModel = new User();
    		if(!$user)
    		{
    			$userModel->add($userInfo);
    			Yii::$app->user->switchIdentity($userModel,1800);
    		}else
    		{	
    			$userIdentity = User::findOne($user->user_id);
    			Yii::$app->user->switchIdentity($userIdentity,1800);
    		}
    		
    		return $this->redirect('/');
    	}else{
    		Yii::$app->session->setFlash('msg',$qq->error);
    		return $this->redirect('/');
    	}
    }
    
    
    /**
     * weixin电脑端登录回调
     * */
    public function actionWeixin()
    {
    	$weixin = new Weixin();
    	if($weixin->getAccessToken()&& $weixin->getUserinfo())
    	{
    		$userInfo = $weixin->userInfo;
    		$user = UserThird::findByopenid($userInfo['openid']);
    		$userModel = new User();
    		if(!$user)
    		{
    			$userModel->add($userInfo);
    			Yii::$app->user->switchIdentity($userModel,1800);
    		}else
    		{
    			$userIdentity = User::findOne($user->user_id);
    			Yii::$app->user->switchIdentity($userIdentity,1800);
    		}
    		return $this->redirect('/');
    	}else{
    		return $this->redirect('/');
    	}
    }

}