<?php
/**
 * User: Xany <762632258@qq.com>
 * Date: 2017/6/14
 * Time: 9:36
 */

namespace common\models\shop;
use Yii;

class Model extends \yii\db\ActiveRecord
{
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
    

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
    	return Yii::$app->get('shopex');
    }
    
}