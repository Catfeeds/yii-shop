<?php

namespace common\models\shop;

use Yii;
use yii\mongodb\ActiveRecord;

/**
 * This is the model class for table "{{%cart}}".
 *
 * @property integer $id
 * @property integer $store_id
 * @property integer $user_id
 * @property integer $goods_id
 * @property integer $num
 * @property integer $addtime
 * @property integer $is_delete
 * @property string $attr
 */
class Cart extends ActiveRecord
{	
	public static function getDb()
	{
		return \Yii::$app->get('mongodbShop');
	}
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%cart}}';
    }
    
    public function attributes()
    {
    	return [
    	'_id',
    	'store_id',
    	'goods_id',
    	'user_id',
    	'num',
    	'created_at',
    	'attr',
    	'product_id'
    	];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['store_id', 'user_id', 'goods_id'], 'required'],
            [['store_id', 'user_id',  'num', 'created_at','product_id'], 'integer'],
            [['goods_id'], 'string'],
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
            'user_id' => '用户id',
            'goods_id' => '商品id',
            'num' => '商品数量',
            'addtime' => 'Addtime',
            'is_delete' => 'Is Delete',
            'attr' => '规格',
        ];
    }
}
