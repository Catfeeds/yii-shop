<?php
/**
 * User: Xany <762632258@qq.com>
 * Date: 2017/6/19
 * Time: 15:14
 */

namespace app\controllers;

use Yii;
use common\models\shop\Store;
use common\models\shop\WechatApp;
use xanyext\wechat\Wechat;
use yii\web\Response;
use common\behaviors\CouponBehavior;
use common\behaviors\OrderBehavior;
use common\behaviors\PintuanBehavior;
/**
 * @property Store $store
 * @property WechatApp $wechat_app
 * @property Wechat $wechat 小程序的
 * @property Wechat $wechat_of_platform 公众号的
 */
class Controller extends \yii\web\Controller
{
    public $store_id;
    public $store;
    public $wechat_app;
    public $wechat;
    public $wechat_of_platform;
    public $version;

    public function init()
    {
        $this->enableCsrfValidation = false;
        $this->version = $this->getVersion();

        // 商城ID
        //$this->store_id = Yii::$app->request->get('store_id') ?: Yii::$app->request->post('store_id');
        $this->store_id = 1;
        
        !$this->store_id && $this->renderJson([
            'code' => 1,
            'msg' => 'Store ID Is Null',
        ]);

        // 商城基本信息
        $this->store = Store::findOne($this->store_id);

        !$this->store && $this->renderJson([
            'code' => 1,
            'msg' => 'Store Is Null',
        ]);

        $this->store_id = $this->store->id;
        $this->wechat_app = WechatApp::findOne($this->store->wechat_app_id);
        if (!$this->wechat_app)
            $this->renderJson([
                'code' => 1,
                'msg' => 'Wechat App Is Null',
            ]);

        if (!is_dir(Yii::$app->runtimePath . '/pem')) {
            mkdir(Yii::$app->runtimePath . '/pem');
            file_put_contents(Yii::$app->runtimePath . '/pem/index.html', '');
        }

        $cert_pem_file = null;
        if ($this->wechat_app->cert_pem) {
            $cert_pem_file = Yii::$app->runtimePath . '/pem/' . md5($this->wechat_app->cert_pem);
            if (!file_exists($cert_pem_file))
                file_put_contents($cert_pem_file, $this->wechat_app->cert_pem);
        }

        $key_pem_file = null;
        if ($this->wechat_app->key_pem) {
            $key_pem_file = Yii::$app->runtimePath . '/pem/' . md5($this->wechat_app->key_pem);
            if (!file_exists($key_pem_file))
                file_put_contents($key_pem_file, $this->wechat_app->key_pem);
        }

        $this->wechat = new Wechat([
            'appId' => $this->wechat_app->app_id,
            'appSecret' => $this->wechat_app->app_secret,
            'mchId' => $this->wechat_app->mch_id,
            'apiKey' => $this->wechat_app->key,
            'cachePath' => Yii::$app->runtimePath . '/cache',
            'certPem' => $cert_pem_file,
            'keyPem' => $key_pem_file,
        ]);

        $access_token = Yii::$app->request->get('access_token');
        if (!$access_token) {
            $access_token = Yii::$app->request->post('access_token');
        }
        if ($access_token) {
            Yii::$app->user->loginByAccessToken($access_token);
        }

        parent::init();
    }
	
    
    
    /**
     * 返回json格式数据，将执行 \Yii::$app->end() 操作
     * @param array|string $data 返回的数据，数组或json字符串
     * @return null
     */
    public function renderJson($data = [])
    {
    	if (is_array($data)) {
    		if (!isset($data['code']))
    			$data['code'] = 0;
    		if (!isset($data['msg']))
    			$data['msg'] = '';
    		if (!isset($data['data']))
    			$data['data'] = (object)null;
    		$data = json_encode($data, JSON_UNESCAPED_UNICODE);
    	}
    	if (is_object($data)) {
    		if (!isset($data->code))
    			$data->code = 0;
    		if (!isset($data->msg))
    			$data->msg = '';
    		if (!isset($data->data))
    			$data->data = (object)null;
    		$data = json_encode($data, JSON_UNESCAPED_UNICODE);
    	}
    	\Yii::$app->response->format = Response::FORMAT_JSON;
    	echo $data;
    	exit();
    	//\Yii::$app->end(0,true);
    	//return null;
    }
    
    public function behaviors()
    {
    	return [
    	'order' => [
    	'class' => OrderBehavior::className(),
    	],
    	'coupon' => [
    	'class' => CouponBehavior::className(),
    	],
    	'pintuan' => [
    	'class' => PintuanBehavior::className(),
    	],
    	];
    }
    
    /**
     * 获取系统版本号
     * @return null
     */
    public function getVersion()
    {
    	$file = \Yii::$app->basePath . '/version.json';
    	if (!file_exists($file))
    		return null;
    	$content = @json_decode(file_get_contents($file), true);
    	if (!$content)
    		return null;
    	if (isset($content['version']))
    		return $content['version'];
    	return null;
    }

}