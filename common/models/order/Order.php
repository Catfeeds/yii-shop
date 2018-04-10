<?php

namespace common\models\order;

use Yii;
use common\models\User;
/**
 * This is the model class for table "{{%order}}".
 *
 * @property string $id
 * @property string $order_sn
 * @property string $shop_id
 * @property string $shop_name
 * @property string $user_id
 * @property integer $order_status
 * @property string $message
 * @property integer $shipping_id
 * @property string $shipping_name
 * @property integer $pay_id
 * @property string $pay_account
 * @property string $trade_no
 * @property string $shipping_fee
 * @property string $invoice_no
 * @property string $goods_amount
 * @property string $cheap_price
 * @property string $order_amount
 * @property string $refund_amount
 * @property string $pay_time
 * @property string $remind_time
 * @property integer $cancel_reson
 * @property string $close_time
 * @property integer $is_show
 * @property string $remark
 * @property integer $platform_type
 * @property string $consignee
 * @property string $mobile
 * @property string $province
 * @property string $city
 * @property string $district
 * @property string $postcode
 * @property string $address
 * @property string $created_at
 * @property string $updated_at
 *
 * @property OrderGoods[] $orderGoods
 */
class Order extends \yii\db\ActiveRecord
{	
	public $orderStatus = [1 =>'未付款',2 =>'待发货',3=>'待收货',4=>'订单关闭',5=>'交易成功'];
	
	public $pay = [1 =>'微信',2=>'支付宝'];
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%order}}';
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
            [['order_sn', 'user_id', 'order_amount', 'consignee', 'mobile', 'province', 'city', 'district',  'address', 'created_at', 'updated_at'], 'required'],
            [['shop_id', 'user_id', 'order_status', 'shipping_id', 'pay_id', 'pay_time', 'remind_time', 'cancel_reson', 'close_time', 'is_show', 'platform_type', 'created_at', 'updated_at'], 'integer'],
            [['shipping_fee', 'goods_amount', 'cheap_price', 'order_amount', 'refund_amount'], 'number'],
            [['order_sn', 'mobile'], 'string', 'max' => 30],
            [['shop_name', 'message', 'remark', 'address'], 'string', 'max' => 255],
            [['shipping_name'], 'string', 'max' => 15],
            [['pay_account', 'consignee'], 'string', 'max' => 100],
            [['trade_no'], 'string', 'max' => 50],
            [['invoice_no','province', 'city', 'district'], 'string', 'max' => 35],
            [['postcode'], 'string', 'max' => 10],
            [['order_sn'], 'unique'],
        ];
    }



    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrderGoods()
    {
        return $this->hasMany(OrderGoods::className(), ['order_id' => 'id']);
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserMobile()
    {
    	$userModel = User::findOne($this->user_id);
    	return $userModel->mobile;
    }
   
}
