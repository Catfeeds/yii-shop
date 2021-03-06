<?php

namespace common\models\shop;

use Yii;

/**
 * This is the model class for table "{{%sms_setting}}".
 *
 * @property integer $id
 * @property integer $store_id
 * @property string $AccessKeyId
 * @property string $AccessKeySecret
 * @property string $name
 * @property string $sign
 * @property string $tpl
 * @property string $msg
 * @property integer $status
 * @property string $mobile
 * @property integer $is_delete
 * @property integer $addtime
 */
class SmsSetting extends Model
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%sms_setting}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['store_id', 'status', 'is_delete', 'addtime'], 'integer'],
            [['AccessKeyId', 'AccessKeySecret', 'name', 'sign', 'tpl', 'msg','mobile'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'store_id' => 'Store ID',
            'AccessKeyId' => '阿里云AccessKeyId',
            'AccessKeySecret' => '阿里云AccessKeySecret',
            'name' => '短信模板名称',
            'sign' => '短信模板签名',
            'tpl' => '短信模板code',
            'msg' => '短信模板参数',
            'status' => '开启状态 0--关闭 1--开启',
            'mobile' => '接受短信手机号',
            'is_delete' => 'Is Delete',
            'addtime' => 'Addtime',
        ];
    }
}
