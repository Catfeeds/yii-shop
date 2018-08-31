<?php
/**
 * User: Xany <762632258@qq.com>
 * Date: 2017/7/1
 * Time: 16:52
 */

namespace common\models\shop\form;


use common\models\shop\Setting;
use common\models\shop\Share;
use common\models\User;
use common\models\shop\form\Model;
use Curl\Curl;
use EasyWeChat\Factory;
use common\models\user\UserThird;
class LoginForm extends Model
{
    public $wechat_app;

    public $code;
    public $user_info;
    public $encrypted_data;
    public $iv;
    public $signature;

    public $store_id;
    public $avatarUrl;
    public $nickName;
    public $gender;
    public $country;
    public $province;
    public $city;
    public $language;

    public function rules()
    {
        return [
            [['wechat_app', 'code', 'user_info', 'encrypted_data', 'iv', 'signature',], 'required'],
            [['avatarUrl','nickName','gender','country','province','city','language'],'trim']
        ];
    }

    public function login()
    {
        if (!$this->validate())
            return $this->getModelError();
        $res = $this->getOpenid($this->code);
        if (!$res || empty($res['openid'])) {
            return [
                'code' => 1,
                'msg' => '获取用户OpenId失败',
                'data' => $res,
            ];
        }
        $user_info = $this->user_info;
        if ($res['openid']) {
            $third = UserThird::findOne(['openid' => $res['openid']]);
            if (!$third) {
                $user = new User();
                $user->setScenario('union');
                $user->access_token = \Yii::$app->security->generateRandomString();
                $user->nickname = isset($user_info['nickName']) ? preg_replace('/[\xf0-\xf7].{3}/', '', $user_info['nickName']) : 'Naked-'.rand(100000,999999);
                $user->avatar = isset($user_info['avatarUrl']) ? $user_info['avatarUrl'] : '';
                $user->save();
                
                
	            $userThird = new UserThird();
	            $userThird->openid = $res['openid'];
	            $userThird->unionid = isset($res['unionid']) ? $res['unionid'] : '';
	            $userThird->type = 2;
	            $userThird->user_id = $user->id;
	            $userThird->save();
            }else{
            	$user = User::findOne($third->user_id);
            }
            //更改用户信息
            if($this->avatarUrl and $this->avatarUrl !== $user->avatar){
                $user->avatar = $this->avatarUrl ? $this->avatarUrl : '';
                $user->save();
            }
            if($this->nickName and $this->nickName !== $user->nickname){
                $user->nickname = $this->nickName ? $this->nickName : '';
                $user->save();
            }
            // 分销商
            /*$share = Share::findOne(['user_id' => $user->parent_id]);
            $parent = '总店';
            if (!empty($share)) {
                $share_user = User::findOne(['id' => $share->user_id]);
                $parent = $share->name ? $share->name : $share_user->nickname;
            }*/

            return [
                'code' => 0,
                'msg' => 'success',
                'data' => (object)[
                    'access_token' => $user->access_token,
                    'nickname' => $user->nickname,
                    'avatar_url' => $user->avatar,
                    'is_distributor' => 0,
                    'id' => $user->id,
                    'parent' => 0,
                    'is_clerk' => 0,
                    'integral' => 0
                ],
            ];
        } else {
            return [
                'code' => 1,
                'msg' => '登录失败',
            ];
        }
    }

    private function getOpenid($code)
    {
        $api = "https://api.weixin.qq.com/sns/jscode2session?appid={$this->wechat_app->app_id}&secret={$this->wechat_app->app_secret}&js_code={$code}&grant_type=authorization_code";
        $curl = new Curl();
        $curl->setOpt(CURLOPT_SSL_VERIFYPEER, false);
        $curl->get($api);
        $res = $curl->response;
        $res = json_decode($res, true);
        return $res;
    }
}