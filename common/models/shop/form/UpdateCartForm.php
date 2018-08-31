<?php
/**
 * User: Xany <762632258@qq.com>
 * Date: 2017/7/15
 * Time: 13:40
 */

namespace common\models\shop\form;


use common\models\shop\Cart;

class UpdateCartForm extends Model
{
    public $cart_goods;
    public $store_id;
    public $user_id;
    public $num;

    public function rules()
    {
        return [
            [['cart_goods'], 'required'],
        ];
    }

    public function save()
    {
        if (!$this->validate())
            return $this->getModelError();

        $this->cart_goods = json_decode($this->cart_goods, true);
        try{
            foreach ($this->cart_goods as $item) {
                $cart = Cart::findOne($item['cart_id']);
                $cart->num = $item['num'];
                $cart->save();
            }
            return [
                'code' => 0,
                'msg' => '成功',
            ];
        }catch (\Exception $e){
            return [
                'code' => 1,
                'msg' => '失败',
            ];
        }
    }
}