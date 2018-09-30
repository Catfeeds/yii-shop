<?php
/**
 * User: Xany <762632258@qq.com>
 * Date: 2017/7/20
 * Time: 10:25
 */

namespace common\models\shop\form;


use common\models\shop\Order;
class OrderRevokeForm extends Model
{
    public $store_id;
    public $user_id;
    public $order_no;
    public $delete_pass = false;

    public function rules()
    {
        return [
            [['order_no'], 'required'],
        ];
    }

    public function save()
    {
        if (!$this->validate()) {
            return $this->getModelError();
        }
        $order = Order::findOne([
            'user_id' => $this->user_id,
            'order_no' => $this->order_no,
        ]);
        if (!$order) {
            return [
                'code' => 1,
                'msg' => '订单不存在'
            ];
        }
        //已支付订单需要后台先审核
        if ($order->order_status == 1) {
            $order->order_status = 6;
            //应该发短信发邮件通知
            if ($order->save()) {
                return [
                    'code' => 0,
                    'msg' => '订单取消申请已提交，请等候管理员审核'
                ];
            } else {
                return $this->getModelError($order);
            }
        }else if($order->order_status <1 )
        {
        	$order->order_status = 4;
        	if ($order->save()) {
        		return [
        		'code' => 0,
        		'msg' => '订单取消成功'
        		];
        	} else {
        		return $this->getModelError($order);
        	}
        }

    }
}