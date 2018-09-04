<?php

namespace backend\models\order;

use Yii;
use common\models\shop\Order as ShopOrder;
use common\models\User;
use common\models\shop\OrderDetail;
use yii\data\ActiveDataProvider;
/**
 * This is the model class for table "{{%order}}".
 *
 * @property string $id
 * @property string $order_no
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
class Order extends ShopOrder
{	
	public $orderStatus = [1 =>'未付款',2 =>'待发货',3=>'待收货',4=>'订单关闭',5=>'交易成功'];
	
	public $pay = [1 =>'微信',2=>'支付宝'];
	
	public $create_start_at;
	
	public $create_end_at;

     /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['store_id', 'user_id', 'pay_type', 'pay_time', 'send_time', 'confirm_time', 'is_comment',  'created_at', 'is_delete', 'is_price', 'parent_id', 'is_offline', 'clerk_id', 'shop_id', 'user_coupon_id', 'give_integral', 'parent_id_1', 'parent_id_2', 'is_sale'], 'integer'],
            [['total_price', 'pay_price', 'express_price', 'first_price', 'second_price', 'third_price', 'coupon_sub_price', 'before_update_price', 'discount'], 'number'],
            [['content', 'offline_qrcode', 'integral', 'words','trade_no'], 'string'],
            [['order_no', 'name', 'mobile', 'express', 'express_no', 'version'], 'string', 'max' => 255],
            [['address', 'remark'], 'string', 'max' => 1000],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'store_id' => 'Store ID',
            'user_id' => '用户',
            'order_no' => '订单号',
            'total_price' => '订单总费用(包含运费）',
            'pay_price' => '实际支付总费用(含运费）',
            'express_price' => '运费',
            'name' => '收货人姓名',
            'mobile' => '收货人手机',
            'address' => '收货地址',
            'remark' => '订单备注',
            'is_pay' => '支付状态：0=未支付，1=已支付',
            'pay_type' => '支付方式：1=微信支付',
            'pay_time' => '支付时间',
            'is_send' => '发货状态：0=未发货，1=已发货',
            'send_time' => '发货时间',
            'express' => '物流公司',
            'express_no' => '快递单号',
            'is_confirm' => '确认收货状态：0=未确认，1=已确认收货',
            'confirm_time' => '确认收货时间',
            'is_comment' => '是否已评价：0=未评价，1=已评价',
            'apply_delete' => '是否申请取消订单：0=否，1=申请取消订单',
            'addtime' => 'Addtime',
            'is_delete' => 'Is Delete',
            'is_price' => '是否发放佣金',
            'parent_id' => '用户上级ID',
            'first_price' => '一级佣金',
            'second_price' => '二级佣金',
            'third_price' => '三级佣金',
            'coupon_sub_price' => '优惠券抵消金额',
            'address_data' => '收货地址信息，json格式',
            'content' => '备注',
            'is_offline' => '是否到店自提 0--否 1--是',
            'clerk_id' => '核销员user_id',
            'is_cancel' => '是否取消',
            'offline_qrcode' => '核销码',
            'before_update_price' => '修改前的价格',
            'shop_id' => '自提门店ID',
            'discount' => '会员折扣',
            'user_coupon_id' => '使用的优惠券ID',
            'integral' => '积分使用',
            'give_integral' => '是否发放积分',
            'parent_id_1' => '用户上二级ID',
            'parent_id_2' => '用户上三级ID',
            'is_sale' => '是否超过售后时间',
            'words' => '商家留言',
            'version' => '版本',
            'trade_no' => '交易号'
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
    	if($this->user_id)
    	{
    		$userModel = User::findOne(['mobile' =>$this->user_id]);
    		$query->andFilterWhere(['user_id' => $userModel->id]);
    	}
    	$query->andFilterWhere(['order_no' => $this->order_no])
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
    
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserMobile()
    {
    	$userModel = User::findOne($this->user_id);
    	return $userModel->mobile ? $$userModel->mobile :$userModel->nickname;
    }
    
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrderGoods()
    {
    	return $this->hasMany(OrderDetail::className(), ['order_id' => 'id']);
    }
}
