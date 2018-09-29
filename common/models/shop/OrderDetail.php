<?php

namespace common\models\shop;

use Yii;

/**
 * This is the model class for table "{{%order_detail}}".
 *
 * @property integer $id
 * @property integer $order_id
 * @property integer $goods_id
 * @property integer $num
 * @property string $total_price
 * @property integer $addtime
 * @property integer $is_delete
 * @property string $attr
 * @property string $pic
 * @property string $integral
 */
class OrderDetail extends Model
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%order_detail}}';
    }
    
    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
    	return Yii::$app->get('shop');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_id', 'goods_id', 'attr'], 'required'],
            [['order_id', 'num', 'addtime', 'is_delete', 'integral'], 'integer'],
            [['total_price'], 'number'],
            [['attr','pic','goods_id'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'order_id' => 'Order ID',
            'goods_id' => 'Goods ID',
            'num' => '商品数量',
            'total_price' => '此商品的总价',
            'addtime' => 'Addtime',
            'is_delete' => 'Is Delete',
            'attr' => '商品规格',
            'pic' => '商品规格图片',
            'integral' => '获取积分',
        ];
    }
    
    
    public function getList($orderId)
    {
    	$orderGoods = self::find()->select(['*'])->where(['order_id' =>$orderId])->asArray()->all();
    	$orderGoods ?: [];
    	if($orderGoods)
    	{
    		foreach($orderGoods as $k => $v)
    		{
    			$goods = Goods::findOne($v['goods_id']);
    			$v['name'] = $goods['name'];
    			$orderGoods[$k] = $v;
    		}
    	}
    	return $orderGoods;
    }
}
