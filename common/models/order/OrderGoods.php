<?php

namespace common\models\order;

use Yii;

/**
 * This is the model class for table "{{%order_goods}}".
 *
 * @property string $id
 * @property string $order_id
 * @property integer $product_id
 * @property string $goods_id
 * @property string $goods_name
 * @property string $goods_photo
 * @property string $attr_string
 * @property string $cheap_price
 * @property string $shop_price
 * @property string $goods_num
 * @property string $shop_id
 * @property integer $aftersales_status
 * @property integer $complaints_status
 * @property string $message
 *
 * @property Order $order
 */
class OrderGoods extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%order_goods}}';
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
            [['order_id', 'goods_id', 'goods_name', 'shop_price', 'goods_num'], 'required'],
            [['order_id', 'product_id', 'goods_id', 'goods_num', 'shop_id', 'aftersales_status', 'complaints_status'], 'integer'],
            [['cheap_price', 'shop_price'], 'number'],
            [['goods_name'], 'string', 'max' => 100],
            [['goods_image'], 'string', 'max' => 255],
            [['goods_id'],'string','max' =>24],
            [['attr_string'], 'string', 'max' => 125],
            [['order_id'], 'exist', 'skipOnError' => true, 'targetClass' => Order::className(), 'targetAttribute' => ['order_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'order_id' => '订单id，关联order表',
            'product_id' => '产品ID',
            'goods_id' => '商品id，关联goods表',
            'goods_name' => '商品名称',
            'goods_photo' => '商品图片',
            'attr_string' => '产品属性',
            'cheap_price' => '优惠价格',
            'shop_price' => '市场销售价格',
            'goods_num' => '购买的商品数量',
            'shop_id' => '商铺id，关联shop表',
            'aftersales_status' => '售后状态1买家已经申请退款，等待卖家同意2卖家已经同意退款，等待买家退货3买家已经退货，等待卖家确认收货4退款成功5:退款关闭6退款中:7:卖家拒绝退款8:卖家已发货',
            'complaints_status' => '1买家未进行投诉2买家投诉，等待平台处理3处理完成4买家撤销投诉5平台关闭投诉，不需要处理直接关闭'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrder()
    {
        return $this->hasOne(Order::className(), ['id' => 'order_id']);
    }
}
