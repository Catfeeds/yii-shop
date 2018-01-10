<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "ad".
 *
 * @property integer $id
 * @property integer $postion
 * @property string $sort
 * @property string $url
 * @property string $image
 * @property string $title
 * @property string $created_at
 */
class Ad extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ad';
    }
    
    public function behaviors()
    {
    	return [
    	TimestampBehavior::className(),
    	];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['postion', 'sort'], 'integer'],
            [['url', 'image'], 'string', 'max' => 255],
            [['title'], 'string', 'max' => 20],
            [['created_at'], 'string', 'max' => 12],
            [['sort','url','image'],'required']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'postion' => '广告位置',
            'sort' => '排序',
            'url' => '链接地址',
            'image' => '图片',
            'title' => '图片标题',
            'created_at' => '添加时间',
        ];
    }
}
