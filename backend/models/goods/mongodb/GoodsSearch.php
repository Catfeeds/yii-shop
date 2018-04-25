<?php


namespace backend\models\goods\mongodb;
use common\models\goods\mongodb\Goods as CommonGoods;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\data\ActiveDataProvider;
use yii\mongodb\ActiveRecord;
use common\models\goods\Product;
use common\models\goods\Store;

/**
 *
 * @property string $id
 * @property string $name
 * @property string $sort
 * @property string $created_at
 * @property string $updated_at
 * @property string $remark
 */
class GoodsSearch extends CommonGoods
{	

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
    	return $dataProvider;
    }
    
  
}