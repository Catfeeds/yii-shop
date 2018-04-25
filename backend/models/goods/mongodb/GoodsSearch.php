<?php


namespace backend\models\goods\mongodb;

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
class GoodsSearch extends Goods
{	
	
	public $create_start_at;
	
	public $create_end_at;
	
    
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


    public function search($params)
    {
    	$query = self::find()->orderBy("_id desc");
    	$dataProvider = new ActiveDataProvider([
    			'query' => $query,
    			]);
    	$this->load($params);
    	if (! $this->validate()) {
    		return $dataProvider;
    	}
    	/*$query ->andFilterWhere(['like', 'name', $this->name]);
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
    	}*/
    	return $dataProvider;
    }

}
