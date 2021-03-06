<?php

namespace common\models\shop;

use Yii;

/**
 * This is the model class for table "{{%yy_order}}".
 *
 * @property string $id
 * @property string $goods_id
 * @property string $user_id
 * @property string $order_no
 * @property string $total_price
 * @property string $pay_price
 * @property integer $is_pay
 * @property integer $pay_type
 * @property string $pay_time
 * @property integer $is_use
 * @property string $is_comment
 * @property integer $apply_delete
 * @property integer $addtime
 * @property integer $is_delete
 * @property string $offline_qrcode
 * @property integer $is_cancel
 * @property string $store_id
 * @property string $use_time
 * @property string $clerk_id
 * @property string $shop_id
 * @property integer $is_refund
 * @property string $form_id
 */
class YyOrder extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%yy_order}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['goods_id', 'user_id', 'order_no', 'store_id', 'form_id'], 'required'],
            [['goods_id', 'user_id', 'is_pay', 'pay_type', 'pay_time', 'is_use', 'is_comment', 'apply_delete', 'addtime', 'is_delete', 'is_cancel', 'store_id', 'use_time', 'clerk_id', 'shop_id', 'is_refund'], 'integer'],
            [['total_price', 'pay_price'], 'number'],
            [['offline_qrcode'], 'string'],
            [['order_no', 'form_id'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'goods_id' => '商品id',
            'user_id' => '用户id',
            'order_no' => '订单号',
            'total_price' => '订单总费用',
            'pay_price' => '实际支付总费用',
            'is_pay' => '支付状态：0=未支付，1=已支付',
            'pay_type' => '支付方式：1=微信支付',
            'pay_time' => '支付时间',
            'is_use' => '是否使用',
            'is_comment' => '是否评论',
            'apply_delete' => '是否申请取消订单：0=否，1=申请取消订单',
            'addtime' => 'Addtime',
            'is_delete' => 'Is Delete',
            'offline_qrcode' => '核销码',
            'is_cancel' => '是否取消',
            'store_id' => 'Store ID',
            'use_time' => '核销时间',
            'clerk_id' => '核销员user_id',
            'shop_id' => '自提门店ID',
            'is_refund' => '是否退款',
            'form_id' => '表单ID',
        ];
    }
}
