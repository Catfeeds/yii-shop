<?php

namespace common\models\shop;

use Yii;
use Codeception\PHPUnit\ResultPrinter\HTML;

/**
 * This is the model class for table "{{%order}}".
 *
 * @property integer $id
 * @property integer $store_id
 * @property integer $user_id
 * @property string $order_no
 * @property string $total_price
 * @property string $pay_price
 * @property string $express_price
 * @property string $name
 * @property string $mobile
 * @property string $address
 * @property string $remark
 * @property integer $is_pay
 * @property integer $pay_type
 * @property integer $pay_time
 * @property integer $is_send
 * @property integer $send_time
 * @property string $express
 * @property string $express_no
 * @property integer $is_confirm
 * @property integer $confirm_time
 * @property integer $is_comment
 * @property integer $apply_delete
 * @property integer $addtime
 * @property integer $is_delete
 * @property integer $is_price
 * @property integer $parent_id
 * @property string $first_price
 * @property string $second_price
 * @property string $third_price
 * @property string $coupon_sub_price
 * @property string $address_data
 * @property string $content
 * @property integer $is_offline
 * @property integer $clerk_id
 * @property integer $is_cancel
 * @property string $offline_qrcode
 * @property string $before_update_price
 * @property integer $shop_id
 * @property string $discount
 * @property integer $user_coupon_id
 * @property integer $integral
 * @property integer $give_integral
 * @property integer $parent_id_1
 * @property integer $parent_id_2
 * @property integer $is_sale
 * @property string $words
 * @property string $version
 */
class Order extends Model
{
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
            [['store_id', 'user_id', 'order_no', 'first_price', 'second_price', 'third_price'], 'required'],
            [['store_id', 'user_id', 'pay_type', 'pay_time', 'send_time', 'confirm_time', 'is_comment',  'created_at', 'is_delete', 'is_price', 'parent_id', 'is_offline', 'clerk_id', 'shop_id', 'user_coupon_id', 'give_integral', 'parent_id_1', 'parent_id_2', 'is_sale'], 'integer'],
            [['total_price', 'pay_price', 'express_price', 'first_price', 'second_price', 'third_price', 'coupon_sub_price', 'before_update_price', 'discount'], 'number'],
            [['content', 'offline_qrcode', 'integral', 'words','trade_no'], 'string'],
            [['order_no', 'name', 'mobile', 'express', 'express_no', 'version'], 'string', 'max' => 255],
            [['address', 'remark'], 'string', 'max' => 1000],
        ];
    }


    public function getOrderDetail()
    {
        return $this->hasMany(OrderDetail::className(),['order_id'=>'id'])->alias('od')
            ->leftJoin(Goods::tableName().' g','g.id=od.goods_id')->select(['od.*','g.name']);
    }
    public function getGoods()
    {
        return $this->hasMany(Goods::className(),['id'=>'goods_id'])->alias('g')
            ->viaTable(OrderDetail::tableName().' od', ['order_id' => 'id']);
    }

    public function beforeSave($insert)
    {
        $this->content = \yii\helpers\Html::encode($this->content);
        return parent::beforeSave($insert);
    }
}
