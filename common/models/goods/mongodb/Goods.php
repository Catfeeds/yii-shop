<?php


namespace common\models\goods\mongodb;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\data\ActiveDataProvider;
use yii\mongodb\ActiveRecord;
use common\models\goods\Product;
use common\models\goods\Store;
use common\service\goods\GoodsService;

/**
 *
 * @property string $id
 * @property string $name
 * @property string $sort
 * @property string $created_at
 * @property string $updated_at
 * @property string $remark
 */
class Goods extends ActiveRecord
{	

	public function attributes()
	{
		return [
		'_id',
		'cid', //栏目id
		'bid',//品牌id
		'shop_id',//商家id
		'shipping_id',//运费模板ID
		'status',//状态 1-上架 0-下架
		'is_audit',//0-未审核  1-通过审核  2拒绝审核
		'sort',//排序
		'created_at',
		'updated_at',
		'comment_sum',//评论数量
		'collect_sum',//收藏数量
		'sales_sum',//销售数量
		'name',//名字
		'short_name',//短名称
		'brief',//商品短介绍
		'image',//相册
		'shop_price',//销售价
		'cost_price',//成本价格
		'weight',//重量
		'content',//详情
		'ext',//扩展属性
		'is_product'//是否生成product
		];
	}
	
	
	public static function getDb()
	{
		return \Yii::$app->get('mongodbShop');
	}
	
	
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%goods}}';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }
    
    

}
