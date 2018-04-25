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
