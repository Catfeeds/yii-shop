<?php
/**
 * @desc 微信第三方登录
 * @author 20140624
 *
 */
namespace common\service\auth;
use common\helpers\FuncHelper;
use Yii;
class Weixin{
	
	public  $appid = '';//APP_ID
	public  $secret = '';//密钥
	public $openid;
	public $accessToken;
	public $userInfo;
	public function __construct(){
		$weixin = Yii::$app->params['weixin'];
		$this->appid = $weixin['appid'];
		$this->secret = $weixin['appsecret'];
	}
	
	
	public function url()
	{	
		$redirect = urlencode(Yii::$app->params['weixin']['callback']);
		$state = md5(time());
		return 'https://open.weixin.qq.com/connect/qrconnect?appid='.$this->appid.'&redirect_uri='.$redirect.'&response_type=code&scope=snsapi_login&state='.$state.'#wechat_redirect';
	}
	
	public function getAccessToken()
	{
		$code = Yii::$app->request->get('code');
		$url = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid='.$this->appid.'&secret='.$this->secret.'&code='.$code.'&grant_type=authorization_code';
		$response = FuncHelper::get($url);
		$response = json_decode($response,true);
		if(isset($response['errcode']))
		{
			return false;
		}
		$this->openid = $response['openid'];
		$this->accessToken = $response['access_token'];
		return true;
	}
 
	
	
	//获取用户基本信息
	public function getUserinfo(){
		$url = 'https://api.weixin.qq.com/sns/userinfo?access_token='.$this->accessToken.'&openid='.$this->openid;
		$response = FuncHelper::get($url);
		$response = json_decode($response,true);
		$userinfo=[];
		if(isset($response['errcode']))
		{
			return false;
		}
		if($response)
		{
			$userinfo['avatar'] = $response['headimgurl'];
			$userinfo['nickname'] = $response['nickname'];
			$userinfo['type'] = 2;
			$userinfo['openid'] = $this->openid;
			$userinfo['unionid']= '';
			if($response['unionid'])
			{
				$userinfo['unionid'] = $response['unionid'];
			}
			$this->userInfo = $userinfo;
			return true;
		}
		return false;
	}
	
	
}


