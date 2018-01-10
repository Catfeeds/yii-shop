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
class Brand extends ActiveRecord
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
        return 'brand';
    }
    
    public function behaviors()
    {
    	return [
    	TimestampBehavior::className(),
    	];
    }
    /**
     * mongodb是没有表结构的，因此不能像mysql那样取出来表结构的字段作为model的属性
     * 因此，需要自己定义model的属性，下面的方法就是这个作用
     */
    public function attributes()
    {
        return [
            '_id',
            'name',//品牌名称
            'image',
            'created_at',
            'updated_at',
       ];
    }
    
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
    	return [
    		[['created_at','updated_at'],'integer'],
    		[['name','image'],'string'],
    		[['name','image'],'required']
    	];
    }
    
   public function attributeLabels()
   {
   	return [
   		'name' =>'品牌名字',
   		'image'=>'品牌logo'
   	];
   }
    
}
