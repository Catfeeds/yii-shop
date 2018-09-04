<?php

namespace common\models\shop;

use Yii;
use yii\behaviors\TimestampBehavior;


/**
 * This is the model class for table "ushop_goods".
 *
 * @property integer $id
 * @property integer $store_id
 * @property string $name
 * @property string $price
 * @property string $original_price
 * @property string $detail
 * @property string $cat_id
 * @property integer $status
 * @property integer $addtime
 * @property integer $is_delete
 * @property string $attr
 * @property string $service
 * @property integer $sort
 * @property integer $virtual_sales
 * @property string $cover_pic
 * @property string $video_url
 * @property string $unit
 * @property integer $individual_share
 * @property string $share_commission_first
 * @property string $share_commission_second
 * @property string $share_commission_third
 * @property double $weight
 * @property string $freight
 * @property string $full_cut
 * @property string $integral
 * @property integer $use_attr
 * @property integer $share_type
 */
class Product extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%product}}';
    }
	
    public function behaviors()
    {
    	return [
    	TimestampBehavior::className(),
    	];
    }
    

	public static function getDb()
	{
		return \Yii::$app->get('shop');
	}
	
	
	public function attributes()
	{
		return [
		'id',
		'goods_id', //栏目id
		'shop_price',//品牌id
		'code',//商家id
		'attr',//运费模板ID
		'store_id',
		'created_at',
		'updated_at',
		'store'
		];
	}
	
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['goods_id', 'shop_price', 'attr'], 'required'],
            [['store_id', 'updated_at', 'created_at'], 'integer'],
            [['attr','goods_id'], 'string']
        ];
    }

   
    

}
