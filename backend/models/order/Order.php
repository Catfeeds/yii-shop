<?php

namespace backend\models\order;

use Yii;
use common\models\order\Order as CommonOrder;
use yii\data\ActiveDataProvider;
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
class Order extends CommonOrder
{	
	public $create_start_at;
	
	public $create_end_at;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['shop_id', 'user_id', 'order_status', 'shipping_id', 'pay_id', 'pay_time', 'remind_time', 'cancel_reson', 'close_time', 'is_show', 'platform_type', 'created_at', 'updated_at'], 'integer'],
            [['shipping_fee', 'goods_amount', 'cheap_price', 'order_amount', 'refund_amount'], 'number'],
            [['trade_no','order_sn','create_start_at','create_end_at'],'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'order_sn' => '订单号',
            'shop_id' => '商铺id，订单所属商家',
            'shop_name' => '商家名称',
            'user_id' => '用户',
            'order_status' => '订单状态',
            'message' => '用户留言',
            'shipping_id' => '发货方式，具体查看配置文件',
            'shipping_name' => '配送方式名称，取值shipping',
            'pay_id' => '支付方式1:微信',
            'pay_account' => '支付的账号',
            'trade_no' => '交易号',
            'shipping_fee' => '订单运费',
            'invoice_no' => '发货单号',
            'goods_amount' => '订单中商品金额',
            'cheap_price' => '优惠价格',
            'order_amount' => '订单金额',
            'refund_amount' => ' 退款金额，其中微信退款以分为单位',
            'pay_time' => '付款时间',
            'remind_time' => '买家提醒发货时间，只有已付款待发货状态下，才可提醒',
            'cancel_reson' => '取消订单原因 1：我不想买了 2：信息填写错误 3：卖家缺货 4：其他',
            'close_time' => '订单关闭时间',
            'is_show' => '是否显示订单，仅对用户订单列表有效 1:显示 0:不显示',
            'remark' => '订单备注',
            'platform_type' => '订单来源平台1:Andriod 2:ios 3:触屏版',
            'consignee' => '收货人',
            'mobile' => '收货人联系电话',
            'province' => '收货地址：省份',
            'city' => '收货地址：市',
            'district' => '收货地址：县区',
            'postcode' => '邮政编码，非必填',
            'address' => '收货地址：详细地址',
            'created_at' => '下单时间',
            'updated_at' => '修改时间',
        ];
    }

    
    /**
     * @param $params
     * @return \yii\data\ActiveDataProvider
     */
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
    	$query->andFilterWhere(['order_sn' => $this->order_sn])
    	->andFilterWhere(['trade_no' => $this->trade_no])
    	->andFilterWhere(['order_status' => $this->order_status]);
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
}
