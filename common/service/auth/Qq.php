<?php
/* PHP SDK
 * @version 2.0.0
 * @author connect@qq.com
 * @copyright © 2013, Tencent Corporation. All rights reserved.
 */
namespace common\service\auth;
use common\helpers\FuncHelper;
use Yii;
class Qq{

    const VERSION = "2.0";
    const GET_AUTH_CODE_URL = "https://graph.qq.com/oauth2.0/authorize";
    const GET_ACCESS_TOKEN_URL = "https://graph.qq.com/oauth2.0/token";
    const GET_USERINFO_URL = 'https://graph.qq.com/user/get_user_info';
    const GET_OPENID_URL = "https://graph.qq.com/oauth2.0/me";

    public $error;
    private $accessToken;
	public $openid;
	public $qq;
	public $userInfo;
	public function __construct()
	{
		$this->qq = Yii::$app->params['qq'];
	}
	
    public  function url($invite_code=""){
        //-------生成唯一随机串防CSRF攻击
        $state = md5(uniqid(rand(), TRUE));
		Yii::$app->session->set('state',$state);
        //-------构造请求参数列表
        $keysArr = array(
            "response_type" => "code",
            "client_id" => $this->qq['appid'],
            "redirect_uri" => $this->qq['callback'],
            "state" => $state,
            "scope" => $this->qq['scope'],
            "invite_code"=>$invite_code
        );
        $params = http_build_query($keysArr);
        return self::GET_AUTH_CODE_URL.'?'.$params;
    }

    public function getAccessToken(){
		$state = Yii::$app->session->get('state');
		$returnState = Yii::$app->request->get('state');
        //--------验证state防止CSRF攻击
        if($returnState != $state){
            $this->error ='The state does not match. You may be a victim of CSRF';
        	return false;
        }
        $qq = Yii::$app->params['qq'];
        //-------请求参数列表
        $keysArr = array(
            "grant_type" => "authorization_code",
            "client_id" => $this->qq['appid'],
            "redirect_uri" => urlencode($qq['callback']),
            "client_secret" => $this->qq["appkey"],
            "code" => Yii::$app->request->get('code')
        );
        //------构造请求access_token的url
		$token_url = FuncHelper::combineURL(self::GET_ACCESS_TOKEN_URL, $keysArr);
		$response = FuncHelper::get($token_url);

        if(strpos($response, "callback") !== false){

            $lpos = strpos($response, "(");
            $rpos = strrpos($response, ")");
            $response  = substr($response, $lpos + 1, $rpos - $lpos -1);
            $msg = json_decode($response);

            if(isset($msg->error)){
            	$this->error = $msg->error_description;
            	return false;
            }
        }

        $params = [];
        parse_str($response, $params);
        $this->accessToken = $params["access_token"];
		return true;
    }

    public function getOpenid(){

        //-------请求参数列表
        $keysArr = array(
            "access_token" =>  $this->accessToken
        );
		$graph_url = FuncHelper::combineURL(self::GET_OPENID_URL, $keysArr);
		$response = FuncHelper::get($graph_url);

        //--------检测错误是否发生
        if(strpos($response, "callback") !== false){

            $lpos = strpos($response, "(");
            $rpos = strrpos($response, ")");
            $response = substr($response, $lpos + 1, $rpos - $lpos -1);
        }

        $user = json_decode($response);
        if(isset($user->error)){
        	$this->error = $user->error_description;
        	return false;
        }
		$this->openid =  $user->openid;
		return true;
    }
    
    
    
    public function getUserinfo()
    {	
    	$keysArr = array(
    			"access_token" =>  $this->accessToken,
    			"oauth_consumer_key" =>$this->qq['appid'],
    			"openid" =>$this->openid
    	);
    	$url = FuncHelper::combineURL(self::GET_USERINFO_URL, $keysArr);
    	$response = FuncHelper::get($url);
    	$response = json_decode($response,true);
    	if($response['ret']!='0'){
    		$this->error = $response['msg'];
    		return false;
    	}
    	$userInfo = [
    		'avatar' =>$response['figureurl_qq_2'],
    		'nickname'=>$response['nickname'],
    		'openid' =>$this->openid,
    		'type' =>1
    	];
		$this->userInfo = $userInfo;
		return true;	   
    }
}