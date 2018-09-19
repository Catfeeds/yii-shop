<?php
/**
 * User: Xany <762632258@qq.com>
 * Date: 2017/7/28
 * Time: 16:24
 */

namespace common\models\shop\form;


use common\models\shop\Cart;

class CartDeleteForm extends Model
{
    public $store_id;
    public $user_id;
    public $cart_id_list; //array

    public function rules()
    {
        return [
            [['cart_id_list'], 'required'],
        ];
    }

    public function save()
    {
        if (!$this->validate())
        {
            return $this->getModelError();
        }
        if(!is_array($this->cart_id_list))
        {
	        $this->cart_id_list = json_decode($this->cart_id_list, true);
        }
        foreach ($this->cart_id_list as $cart_id) {
            Cart::deleteAll([
               // 'store_id' => $this->store_id,
                'user_id' => $this->user_id,
                '_id' => $cart_id,
            ]);
        }
        return [
            'code' => 0,
            'msg' => '删除完成',
        ];
    }
}