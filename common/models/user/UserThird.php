<?php

namespace common\models\user;

use Yii;
use common\models\User;
/**
 * This is the model class for table "user_third".
 *
 * @property string $id
 * @property string $user_id 用户id
 * @property string $openid 该用户在该appid下的openid
 * @property string $unionid
 * @property string $type 登录类型  1qq,2微信
 */
class UserThird extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_third';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'openid','type'], 'required'],
            [['user_id','type'], 'integer'],
            [['openid'], 'string', 'max' => 50],
            [['unionid'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => '用户id',
            'openid' => '该用户在该appid下的openid',
            'unionid' => 'Unionid',
            'type' => '登录类型  1qq,2微信',
        ];
    }

    
    public static function findByopenid($openid)
    {
    	return self::findOne(['openid' => $openid]);
    }
    
    

}
