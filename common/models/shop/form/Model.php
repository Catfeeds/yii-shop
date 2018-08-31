<?php
/**
 * User: Xany <762632258@qq.com>
 * Date: 2017/7/5
 * Time: 16:01
 */

namespace common\models\shop\form;
use Yii;

use xanyext\wechat\Wechat;

class Model extends \yii\base\Model
{
    /**
     * @return Wechat
     */
    public function getWechat()
    {
        return isset(\Yii::$app->controller->wechat) ? \Yii::$app->controller->wechat : null;
    }
    
    
    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
    	return Yii::$app->get('shopex');
    }

    public function getModelError($model = null)
    {
    	if (!$model)
    		$model = $this;
    	foreach ($model->errors as $errors)
    		return [
    		'code' => 1,
    		'msg' => $errors[0],
    		];
    }
    
}