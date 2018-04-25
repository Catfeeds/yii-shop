<?php


namespace backend\models\goods\mongodb;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\data\ActiveDataProvider;
use yii\mongodb\ActiveRecord;
use common\models\goods\Product;
use common\models\goods\Store;
use common\service\goods\GoodsService;
use common\models\goods\mongodb\Goods as CommonGoods;
/**
 *
 * @property string $id
 * @property string $name
 * @property string $sort
 * @property string $created_at
 * @property string $updated_at
 * @property string $remark
 */
class Goods extends CommonGoods
{	
	
	public $create_start_at;
	
	public $create_end_at;
	
    
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

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'short_name', 'brief','weight','content','bid'], 'string'],
            [['shop_price','cost_price'],'double'],
            [['cid',  'shop_id','shipping_id','status','is_audit','sort','created_at','updated_at','comment_sum','collect_sum','sales_sum','is_product'], 'integer'],
            [['name','image','short_name','shop_price','content','bid','sort'], 'required'],
        ];
    }

    public function attributeLabels()
    {
    	return [
    	'name' =>'商品名字',
    	'short_name' =>'商品简称',
    	'brief'=>'商品简介',
    	'shop_price' =>'销售价',
    	'cost_price' =>'成本价',
    	'weight' =>'商品重量',
    	'content' =>'商品描述',
    	'bid' =>'品牌',
    	'status'=>'上下架状态',
    	'is_audit'=>'审核状态',
    	'sort' =>'排序',
    	'image'=>'图片'
    	];
    }

    public function search($params)
    {
    	$query = self::find()->orderBy("id desc");
    	$dataProvider = new ActiveDataProvider([
    			'query' => $query,
    			]);
    	$this->load($params);
    	if (! $this->validate()) {
    		return $dataProvider;
    	}
    	$query ->andFilterWhere(['like', 'name', $this->name]);
    	$create_start_at_unixtimestamp = $create_end_at_unixtimestamp = '';
    	if ($this->create_start_at != '') {
    		$create_start_at_unixtimestamp = strtotime($this->create_start_at);
    	}
    	if ($this->create_end_at != '') {
    		$create_end_at_unixtimestamp = strtotime($this->create_end_at);
    	}
    	if ($create_start_at_unixtimestamp != '' && $create_end_at_unixtimestamp == '') {
    		$query->andFilterWhere(['>', 'created_at', $create_start_at_unixtimestamp]);
    	} elseif ($create_start_at_unixtimestamp == '' && $create_end_at_unixtimestamp != '') {
    		$query->andFilterWhere(['<', 'created_at', $create_end_at_unixtimestamp]);
    	} else {
    		$query->andFilterWhere([
    				'between',
    				'created_at',
    				$create_start_at_unixtimestamp,
    				$create_end_at_unixtimestamp
    				]);
    	}
    	return $dataProvider;
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
    
    

    /**
     * 添加 修改前业务处理
     * */
    public function beforeSave($insert)
    {	
    	if(!isset($this->is_audit))
    	{
    		$this->is_audit = 1;
    	}
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
    
    
    public function getStore()
    {
    	if($this->is_product == 1)
    	{
    		return 0;
    	}else
    	{
    		return GoodsService::getStore((string)$this->_id);
    	}
    }
}
