<?php
/**
 * FecShop file.
 *
 * @link http://www.fecshop.com/
 * @copyright Copyright (c) 2016 FecShop Software LLC
 * @license http://www.fecshop.com/license/
 */

namespace common\models\goods\mongodb;

use yii\mongodb\ActiveRecord;
use yii\behaviors\TimestampBehavior;

/**
 * @author Terry Zhao <2358269014@qq.com>
 * @since 1.0
 */
class Cart extends ActiveRecord
{
    
    public static function getDb()
    {
    	return \Yii::$app->get('mongodbShop');
    }

    
    /**
     * mongodb collection 的名字，相当于mysql的table name
     */
    public static function collectionName()
    {
        return 'cart';
    }
    
    /**
     * mongodb是没有表结构的，因此不能像mysql那样取出来表结构的字段作为model的属性
     * 因此，需要自己定义model的属性，下面的方法就是这个作用
     */
    public function attributes()
    {
        return [
            '_id',
            'user_id',//品牌名称
            'goods_id',
            'product_id',
            'goods_num',
            'created_at'
       ];
    }
    
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
    	return [
    		[['created_at','product_id','goods_num'],'integer'],
    		[['goods_id'],'string'],
    		[['goods_id','user_id','goods_num'],'required']
    	];
    }
    
}
