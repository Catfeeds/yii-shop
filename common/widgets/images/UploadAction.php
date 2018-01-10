<?php
namespace common\widgets\images;

use Yii;
use yii\base\Action;
use common\helpers\FuncHelper;
use Qiniu\Auth;
use Qiniu\Storage\UploadManager;
/**
 * 上传图片控制器
 */
class UploadAction extends Action
{
    /**
     * ---------------------------------------
     * 上传base64格式的图片
     * @return void
     * ---------------------------------------
     */
    public function run(){
        $json = [
            'boo'  => false,
            'msg'  => '上传失败',
            'data' => [
                'id' => 0,
                'url' => '',
            ]
        ];
        $imgbase64 = Yii::$app->request->post('imgbase64');
        $saveDB = Yii::$app->request->post('saveDB',0);
        if (empty($imgbase64)) {
            $this->ajaxReturn($json);
        }
        $url = FuncHelper::uploadImage($imgbase64);
        if ($url) {
            $json['data']['url'] = '/' . $url;
            /* 保存图片到picture表 */
            if ($saveDB) {
                $pic = $this->savePic($url);
                if (!$pic) {
                    $this->ajaxReturn($json);
                }
                $json['data']['id']  = $pic['id'];
                $json['data']['url'] = $pic['path'];
            }
            $json['boo']  = true;
            $json['msg']  = '上传成功';
        }
        $this->qiniu('/'.$url);
        $this->ajaxReturn($json);
    }

   
    public function ajaxReturn($data) {
        // 返回JSON数据格式到客户端 包含状态信息
        header('Content-Type:application/json; charset=utf-8');
        exit(json_encode($data));
    }
	
    /**
    * @desc 七牛云上传 
    * @param
    */
    public function qiniu($url)
    {	
    	$params = Yii::$app->params['qiniu'];
    	$auth =  new Auth($params['access_key'],$params['secret_key']);
    	$token = $auth->uploadToken($params['bucket']);
    	$upload = new UploadManager();
		$upload->putFile($token, $url, Yii::getAlias('@image').'/'.$url);
    }
}
