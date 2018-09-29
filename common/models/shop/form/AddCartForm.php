<?php
/**
 * User: Xany <762632258@qq.com>
 * Date: 2017/7/15
 * Time: 13:40
 */

namespace common\models\shop\form;


use common\models\shop\Cart;
use common\models\shop\Goods;
use yii\helpers\VarDumper;

class AddCartForm extends Model
{
    public $user_id;
    public $store_id;
    public $goods_id;
    public $attr;
    public $num;
    public $product_id;
	
    
    
    public function rules()
    {
        return [
            [['goods_id', 'num'], 'required'],
            [['num','product_id'], 'integer'],
            [['num'], 'integer', 'min' => 1],
        ];
    }

    public function save()
    {
        if (!$this->validate())
        {
            return $this->getModelError();
        }
        $goods = Goods::findOne(['_id' => $this->goods_id,'status'=>1]);
        if (!$goods) {
            return [
                'code' => 1,
                'msg' => '商品不存在或已下架',
            ];
        }

        $attr = [];
        $this->attr = json_decode($this->attr, true);
        if(count($this->attr)>= 1){
	        foreach ($this->attr as $item) {
	            $attr[$item['attr_group_name']] = $item['attr_name'];
	        }
        }
        $where = [
            'goods_id' => $this->goods_id,
            'user_id' => $this->user_id,
        ];
        if($this->product_id)
        {
        	$where['product_id'] = $this->product_id;
        }
        $cart = Cart::findOne($where);
        if (!$cart) {
            $cart = new Cart();
            $cart->store_id = $this->store_id;
            $cart->goods_id = $this->goods_id;
            $cart->user_id = $this->user_id;
            $cart->num = 0;
            $cart->created_at = time();
            $cart->attr = $attr;
            $cart->product_id = $this->product_id;
        }
        $cart->num += $this->num;
        if ($cart->save()) {
            return [
                'code' => 0,
                'msg' => '添加购物车成功',
            ];
        } else {
            return $this->getModelError($cart);
        }
    }
}