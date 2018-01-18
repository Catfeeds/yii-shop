<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "apply".
 *
 * @property integer $id
 * @property string $name
 * @property string $weixin
 * @property string $province
 * @property integer $gender
 * @property string $mobile
 * @property string $content
 * @property integer $created
 * @property integer $updated
 */
class Apply extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'apply';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['gender', 'created_at', 'updated_at'], 'integer'],
            [['created_at','name','mobile','content'], 'required'],
            [['name'], 'string', 'max' => 25],
            [['weixin', 'province'], 'string', 'max' => 50],
            [['mobile'], 'string', 'max' => 11],
            [['content'], 'string', 'max' => 500],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '产品ID',
            'name' => '姓名',
            'weixin' => '微信',
            'province' => '省份',
            'gender' => '性别 ',
            'mobile' => '手机号',
            'content' => '留言内容',
            'created_at' => '更新时间',
            'updated_at' => '添加时间',
        ];
    }
}
