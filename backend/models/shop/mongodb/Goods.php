<?php

namespace backend\models\shop\mongodb;

use Yii;
use yii\helpers\VarDumper;
use yii\mongodb\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\data\ActiveDataProvider;
use common\models\shop\Product;
use common\models\goods\Store;
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
class Goods extends ActiveRecord
{	
	public	$goodsStatus = [0=>'下架',1 =>'上架'];
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%goods}}';
    }
	
    

	public static function getDb()
	{
		return \Yii::$app->get('mongodbShop');
	}
	
	public function behaviors()
	{
		return [
		TimestampBehavior::className(),
		];
	}
	
	public function attributes()
	{
		return [
		'_id',
		'cid', //栏目id
		'bid',//品牌id
		'store_id',//商家id
		'status',//状态 1-上架 0-下架
		'is_delete',//0没有删除1已经删除
		'sort',//排序
		'created_at',
		'updated_at',
		'comment_sum',//评论数量
		'collect_sum',//收藏数量
		'sales_sum',//销售数量
		'virtual_sales',//虚拟销售数量
		'name',//名字
		'short_name',//短名称
		'brief',//商品短介绍
		'image',//相册
		'shop_price',//销售价
		'weight',//重量
		'content',//详情
		'ext',//扩展属性
		'store',
		'integral',//积分
		'is_product'//是否生成product
		];
	}
	
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name','image','short_name','shop_price','content','bid','sort'], 'required'],
            [['name', 'short_name', 'brief','content','bid','virtual_sales'], 'string'],
            [['shop_price'],'double'],
            [['cid',  'store_id','status','sort','created_at','updated_at','comment_sum','collect_sum','sales_sum','is_product'], 'integer'],
        ];
    }

    public function attributeLabels()
    {
    	return [
    	'name' =>'商品名字',
    	'short_name' =>'商品简称',
    	'brief'=>'商品简介',
    	'shop_price' =>'销售价',
    	'virtual_sales' =>'虚拟销售量',
    	'weight' =>'商品重量',
    	'content' =>'商品描述',
    	'bid' =>'品牌',
    	'status'=>'状态',
    	'sort' =>'排序',
    	'image'=>'图片'
    	];
    }
    
    /**
     * 添加 修改前业务处理
     * */
    public function beforeSave($insert)
    {
    	if(!isset($this->comment_sum))
    	{
    		$this->comment_sum = 0;
    	}
    	if(!isset($this->collect_sum))
    	{
    		$this->collect_sum = 0;
    	}
    	if(!isset($this->sales_sum))
    	{
    		$this->sales_sum = 0;
    	}
    	if(isset($this->cid))
    	{
    		$this->cid = (int)$this->cid;
    	}
    	if(isset($this->status))
    	{
    		$this->status = (int)$this->status;
    	}
    	if(isset($this->sort))
    	{
    		$this->sort = (int)$this->sort;
    	}
    	if($this->is_product =='1')
    	{
    		$this->is_product = 1;
    	}else
    	{
    		$this->is_product = 0;
    	}
    	return parent::beforeSave($insert);
    }



    public function afterDelete()
    {
    	$products = Product::findAll(['goods_id' => $this->_id]);
    	if(count($products)>=1)
    	{
    		foreach($products as $product)
    		{
    			$product->delete();
    		}
    	}
    	$store = Store::findOne(['goods_id' => $this->_id]);
    	if($store)
    	{
    		$store->delete();
    	}
    }



    public function search($params)
    {
    	$query = self::find();
    	$dataProvider = new ActiveDataProvider([
    			'query' => $query,
    			'sort' => [
	    			'defaultOrder' => [
	    				'created_at' => SORT_DESC,
	    				'updated_at' => SORT_DESC,
	    			]
    			]
    	]);
    	$this->load($params);
    	if($this->name){
	    	$query->andFilterWhere(['name' => ['$regex' => $this->name]]);
    	}
    	 
    	return $dataProvider;
    }


}
