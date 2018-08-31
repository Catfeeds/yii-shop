<?php
/**
 * FecShop file.
 *
 * @link http://www.fecshop.com/
 * @copyright Copyright (c) 2016 FecShop Software LLC
 * @license http://www.fecshop.com/license/
 */

namespace common\models\shop;

use yii\mongodb\ActiveRecord;
use yii\behaviors\TimestampBehavior;

/**
 * @author Terry Zhao <2358269014@qq.com>
 * @since 1.0
 */
class Attr extends ActiveRecord
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
        return 'attr';
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
            'cid', //栏目id
            'name',//属性名称
            'value_model',//输入模式 1-单选 2-多选 3自定义，卖家可以自己输入 默认3
            'is_allow_img',//该属性是否允许上传图片0：不允许 1：允许，只有可销售属性才可以上传 默认0
            'created_at',
            'updated_at',
            'value'
       ];
    }
    
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
    	return [
    		[['cid','value_model','is_allow_img','created_at','updated_at'],'integer'],
    		[['name','value'],'required']
    	];
    }
    
   
    public static function getAttrByCid($cid = 0)
    {	
    	return Attr::find()->where(['cid' => (int)$cid])->asArray()->all();
    }
}
