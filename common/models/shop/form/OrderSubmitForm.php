<?php
/**
 * User: Xany <762632258@qq.com>
 * Date: 2017/7/17
 * Time: 11:48
 */

namespace common\models\shop\form;


use common\models\shop\Address;
use common\models\shop\Attr;
use common\models\shop\Product;
use common\models\shop\Cart;
use common\models\shop\Coupon;
use common\models\shop\Goods;
use common\models\shop\Level;
use common\models\shop\SeckillGoods;
use common\models\shop\Order;
use common\models\shop\OrderDetail;
use common\models\shop\OrderForm;
use common\models\shop\PostageRules;
use common\models\shop\PrinterSetting;
use common\models\User;
use common\models\shop\Store;
use common\models\shop\GoodsStore;

use common\models\shop\UserCoupon;
use app\modules\api\controllers\OrderController;
use app\extensions\PinterOrder;
use Yii;
class OrderSubmitForm extends Model
{
    public $store_id;
    public $user_id;
    public $version;

    public $address_id;
    public $cart_id_list;
    public $goods_info;

    public $user_coupon_id;

    public $content;
    public $offline;
    public $address_name;
    public $address_mobile;
    public $shop_id;

    public $use_integral;

    public $form;//自定义表单信息

    public function rules()
    {
        return [
            [['cart_id_list', 'goods_info', 'content', 'address_name', 'address_mobile'], 'string'],
            [['address_id',], 'required', 'on' => "EXPRESS"],
            [['address_name', 'address_mobile'], 'required', 'on' => "OFFLINE"],
            [['user_coupon_id', 'offline', 'shop_id', 'use_integral'], 'integer'],
            [['offline'], 'default', 'value' => 0],
            [['form'], 'safe']
        ];
    }

    public function attributeLabels()
    {
        return [
            'address_id' => '收货地址',
            'address_name' => '收货人',
            'address_mobile' => '联系电话'
        ];
    }

    public function save()
    {
        if (!$this->validate())
            return $this->getModelError();
        $t = \Yii::$app->db->beginTransaction();
        $express_price = 0;
        if ($this->offline == 0) {
            $address = Address::findOne([
                '_id' => $this->address_id,
                'user_id' => $this->user_id,
            ]);
            if (!$address) {
                return [
                    'code' => 1,
                    'msg' => '收货地址不存在',
                ];
            }

		//$express_price = PostageRules::getExpressPrice($this->store_id, $address->province_id);
        } else {
            if (!preg_match_all("/1\d{10}/", $this->address_mobile, $arr)) {
                return [
                    'code' => 1,
                    'msg' => '手机号格式错误'
                ];
            }
        }
        $goods_list = [];
        $total_price = 0;

        $resIntegral = [
            'forehead' => 0,
            'forehead_integral' => 0,
        ];
        $goodsIds = [];
        $store = Store::findOne($this->store_id);
        if ($this->cart_id_list) {
            $data = $this->getGoodsListByCartIdList($this->cart_id_list);
            $goods_list = empty($data['list']) ? [] : $data['list'];
            $total_price = 0;
            $goodsList = [];
            foreach ($goods_list as $k => $val) {
                $goods = Goods::findOne([
                    '_id' => $val->goods_id,
                    //'store_id' => $this->store_id,
                ]);
                if($val->product_id)
                {
                	$p = Product::findOne($val->product_id);
                	$goods->shop_price = $p->shop_price;
                	$goods->store = $p->store;
                }else{
                	$storeModel = GoodsStore::findOne(['goods_id' => (string)$val->goods_id]);
                	$goods->store = $storeModel->store;
                }
                if($goods->store < $val->num)
                {
                	continue;
                }
                $new_goods = [
                    'goods_id' =>(string) $goods->_id,
                    'goods_name' => $goods->name,
                    'freight' => 0,
                    'num' => $val->num,
                    'full_cut' => 0,
                    'price' => $goods->shop_price,
                ];
                $total_price += ($new_goods['price'])*$val->num;
                $goodsList[] = $new_goods;

            }
            if ($this->offline == 0) {
                //$resGoodsList = (new Goods)->cutFull($goodsList);
               // $express_price = PostageRules::getExpressPriceMore($this->store_id, $address->province_id, $resGoodsList);
            }

        } elseif ($this->goods_info) {
            $data = $this->getGoodsListByGoodsInfo($this->goods_info);
            $goods_list = empty($data['list']) ? [] : $data['list'];
            $total_price = empty($data['total_price']) ? 0 : $data['total_price'];
            $resIntegral = [
                'forehead' => 0,
                'forehead_integral' => 0,
            ];
            foreach ($goods_list as $k => $val) {
                $goods = Goods::findOne([
                    'id' => $val->goods_id,
                    'is_delete' => 0,
                    'store_id' => $this->store_id,
                    'status' => 1,
                ]);

                if ($this->offline == 0) {
                    if ($goods['full_cut']) {
                        $full_cut = json_decode($goods['full_cut'], true);
                    } else {
                        $full_cut = json_decode([
                            'pieces' => 0,
                            'forehead' => 0,
                        ], true);
                    }

                    if ((empty($full_cut['pieces']) || $val->num < ($full_cut['pieces'] ?: 0)) && (empty($full_cut['forehead']) || $val->price < ($full_cut['forehead'] ?: 0))) {
                        $express_price = PostageRules::getExpressPrice($this->store_id, $address->province_id, $goods, $val->num);
                    }
                }
            }

        }
        if (empty($goods_list)) {
            return [
                'code' => 1,
                'msg' => '订单提交失败，所选商品库存不足或已下架',
            ];
        }


        $total_price_1 = $total_price + $express_price;
        $discount = 10;

        // 获取用户当前积分
        $user = User::findOne(['id' => $this->user_id]);

        // 减去 积分折扣金额
        //$total_price_3 = $total_price - $resIntegral['forehead'];

       // $total_price_2 = max(0.01, round($total_price_3 * $discount / 10, 2)) + $express_price;


        $order = new Order();
        $order->store_id = $this->store_id;
        $order->user_id = $this->user_id;
        $order->order_no = $this->getOrderNo();
        $order->total_price = $total_price_1;
        $order->pay_price = $total_price_1;
        
        $order->express_price = $express_price;
        $order->discount = $discount;
        $order->created_at = time();
        if ($this->offline == 0) {
            $order->address = $address->province . $address->city . $address->district . $address->detail;
            $order->mobile = $address->mobile;
            $order->name = $address->name;
        } else {
            $order->name = $this->address_name;
            $order->mobile = $this->address_mobile;
            $order->shop_id = $this->shop_id;
        }
        $order->first_price = 0;
        $order->second_price = 0;
        $order->third_price = 0;
        $order->content = $this->content;
        $order->is_offline = $this->offline;
        $order->integral = json_encode($resIntegral, JSON_UNESCAPED_UNICODE);
        $order->version = $this->version;

        /*if ($this->user_coupon_id) {
            $coupon = Coupon::find()->alias('c')
                ->leftJoin(['uc' => UserCoupon::tableName()], 'uc.coupon_id=c.id')
                ->where([
                    'uc.id' => $this->user_coupon_id,
                    'uc.is_delete' => 0,
                    'uc.is_use' => 0,
                    'uc.is_expire' => 0,
                    'uc.user_id' => $this->user_id
                ])
                ->select('c.*')->one();
            $goods_total_pay_price = $order->total_price - $order->express_price;//原本需支付的商品总价
            if ($coupon && $goods_total_pay_price >= $coupon->min_price) {
                $goods_price = ($goods_total_pay_price - $coupon->sub_price - $resIntegral['forehead']) * $discount / 10;
                $order->pay_price = max(0.01, round($goods_price, 2)) + $order->express_price;
                $order->coupon_sub_price = $goods_total_pay_price - max(0.01, $goods_total_pay_price - $coupon->sub_price);
                UserCoupon::updateAll(['is_use' => 1], ['id' => $this->user_coupon_id]);
                $order->user_coupon_id = $this->user_coupon_id;
            }
        }*/
        if ($order->save()) {
            foreach ($goods_list as $goods) {
            	$g = Goods::findOne($goods->goods_id);
                $order_detail = new OrderDetail();
                $order_detail->order_id = $order->id;
                $order_detail->product_id = $goods->attr;
                $order_detail->goods_id = $goods->goods_id;
                $order_detail->num = $goods->num;
                $order_detail->total_price = doubleval(sprintf('%.2f', $total_price_1));
                $order_detail->addtime = time();
                $order_detail->is_delete = 0;
                $order_detail->attr = json_encode($goods->attr);
                $order_detail->pic = Yii::$app->params['image'].$g->image[0];
                $order_detail->integral = 0;
                
               /* $_goods = Goods::findOne($goods->goods_id);
                if (!$_goods->numSub($attr_id_list, $order_detail->num)) {
                    $t->rollBack();
                    return [
                        'code' => 1,
                        'msg' => '订单提交失败，商品“' . $_goods->name . '”库存不足',
                        'attr_id_list' => $attr_id_list,
                        'attr_list' => $goods->attr_list,
                    ];
                }*/

                if (!$order_detail->save()) {
                    $t->rollBack();
                    return [
                        'code' => 1,
                        'msg' => '订单提交失败，请稍后再重试',
                    ];
                }
            }

            Cart::deleteAll(['_id' => json_decode($this->cart_id_list,true),'user_id' => $this->user_id]);
            
            $t->commit();
            return [
                'code' => 0,
                'msg' => '订单提交成功',
                'data' => (object)[
                    'order_id' => $order->id,
                ],
            ];
        } else {
            $t->rollBack();
            return $this->getModelError($order);
        }
    }


    /**
     * 获取购物车商品列表及总价
     * @param string $cart_id_list
     * eg.[1,2,3]
     * @return array 'list'=>商品列表,'total_price'=>总价
     */
    private function getGoodsListByCartIdList($cart_id_list)
    {
        /* @var  Cart[] $cart_list */
        $cart_list = Cart::find()->where([
            'store_id' => $this->store_id,
            'user_id' => $this->user_id,
            '_id' => json_decode($cart_id_list, true),
        ])->all();
        return ['list' => $cart_list,
        ];
    }


    /**
     * @param string $goods_info
     * eg.{"goods_id":"22","attr":[{"attr_group_id":1,"attr_group_name":"颜色","attr_id":3,"attr_name":"橙色"},{"attr_group_id":2,"attr_group_name":"尺码","attr_id":2,"attr_name":"M"}],"num":1}
     */
    private function getGoodsListByGoodsInfo($goods_info)
    {
        $goods_info = json_decode($goods_info);
        $goods = Goods::findOne([
            'id' => $goods_info->goods_id,
            'is_delete' => 0,
            'store_id' => $this->store_id,
            'status' => 1,
        ]);
        if (!$goods) {
            return [
                'total_price' => 0,
                'list' => [],
            ];
        }
        $attr_id_list = [];
        foreach ($goods_info->attr as $item) {
            array_push($attr_id_list, $item->attr_id);
        }
        $total_price = 0;
        $goods_attr_info = $goods->getAttrInfo($attr_id_list);

        $attr_list = Attr::find()->alias('a')
            ->select('a.id attr_id,ag.attr_group_name,a.attr_name')
            ->leftJoin(['ag' => AttrGroup::tableName()], 'a.attr_group_id=ag.id')
            ->where(['a.id' => $attr_id_list])
            ->asArray()->all();
        $goods_pic = isset($goods_attr_info['pic']) ? $goods_attr_info['pic'] ?: $goods->getGoodsPic(0)->pic_url : $goods->getGoodsPic(0)->pic_url;
        $goods_item = (object)[
            'goods_id' => $goods->id,
            'goods_name' => $goods->name,
            'goods_pic' => $goods_pic,
//            'goods_pic' => $goods->getGoodsPic(0)->pic_url,
            'num' => $goods_info->num,
            'price' => doubleval(empty($goods_attr_info['price']) ? $goods->price : $goods_attr_info['price']) * $goods_info->num,
            'attr_list' => $attr_list,
            'give' => 0,
        ];

        //秒杀价计算
        $seckill_data = $this->getSeckillData($goods, $attr_id_list);
        if ($seckill_data) {
            $res = $this->getSeckillPrice($seckill_data, $goods, $attr_id_list, $goods_info->num);
            if ($res !== false) {
                $goods_item->price = $res['total_price'];
                $this->setSeckillSellNum($seckill_data['id'], $attr_id_list, $res['seckill_price_num']);
            }
        }

        $total_price += $goods_item->price;
        return [
            'total_price' => $total_price,
            'list' => [$goods_item],
        ];
    }

    public function getOrderNo()
    {
        $store_id = empty($this->store_id) ? 0 : $this->store_id;
        $order_no = null;
        while (true) {
            $order_no = date('YmdHis') . rand(100000, 999999);
            $exist_order_no = Order::find()->where(['order_no' => $order_no])->exists();
            if (!$exist_order_no)
                break;
        }
        return $order_no;
    }


    /**
     * @param Goods $goods
     * @param array $attr_id_list eg.[12,34,22]
     * @return array ['id'=>'seckill_goods id','attr_list'=>[],'seckill_price'=>'秒杀价格','seckill_num'=>'秒杀数量','sell_num'=>'已秒杀商品数量']
     */
    private function getSeckillData($goods, $attr_id_list = [])
    {
        $seckill_goods = SeckillGoods::findOne([
            'goods_id' => $goods->id,
            'is_delete' => 0,
            'open_date' => date('Y-m-d'),
            'start_time' => intval(date('H')),
        ]);
        if (!$seckill_goods)
            return null;
        $attr_data = json_decode($seckill_goods->attr, true);
        sort($attr_id_list);
        $seckill_data = null;
        foreach ($attr_data as $i => $attr_data_item) {
            $_tmp_attr_id_list = [];
            foreach ($attr_data_item['attr_list'] as $item) {
                $_tmp_attr_id_list[] = $item['attr_id'];
            }
            sort($_tmp_attr_id_list);
            if ($attr_id_list == $_tmp_attr_id_list) {
                $seckill_data = $attr_data_item;
                break;
            }
        }
        $seckill_data['id'] = $seckill_goods->id;
        return $seckill_data;
    }

    /**
     * 获取商品秒杀价格，若库存不足则使用商品原价，若有部分库存，则部分数量使用秒杀价，部分使用商品原价，商品库存不足返回false
     * @param array $seckill_data ['attr_list'=>[],'seckill_price'=>'秒杀价格','seckill_num'=>'秒杀数量','sell_num'=>'已秒杀商品数量']
     * @param Goods $goods
     * @param array $attr_id_list eg.[12,34,22]
     * @param integer $buy_num 购买数量
     *
     * @return false|array
     */
    private function getSeckillPrice($seckill_data, $goods, $attr_id_list, $buy_num)
    {
        $attr_data = json_decode($goods->attr, true);
        sort($attr_id_list);
        $goost_attr_data = null;
        foreach ($attr_data as $i => $attr_data_item) {
            $_tmp_attr_id_list = [];
            foreach ($attr_data_item['attr_list'] as $item) {
                $_tmp_attr_id_list[] = intval($item['attr_id']);
            }
            sort($_tmp_attr_id_list);
            if ($attr_id_list == $_tmp_attr_id_list) {
                $goost_attr_data = $attr_data_item;
                break;
            }
        }
        $goods_price = $goost_attr_data['price'];
        if (!$goods_price)
            $goods_price = $goods->price;

        $seckill_price = min($seckill_data['seckill_price'], $goods_price);

        if ($buy_num > $goost_attr_data['num'])//商品库存不足
        {
            \Yii::warning([
                'res' => '库存不足',
                'm_data' => $seckill_data,
                'g_data' => $goost_attr_data,
                '$attr_id_list' => $attr_id_list,
            ]);
            return false;
        }

        if ($buy_num <= ($seckill_data['seckill_num'] - $seckill_data['sell_num'])) {
            \Yii::warning([
                'res' => '库存充足',
                'price' => $buy_num * $seckill_price,
                'm_data' => $seckill_data,
            ]);
            return [
                'seckill_price_num' => $buy_num,
                'original_price_num' => 0,
                'total_price' => $buy_num * $seckill_price
            ];
        }

        $seckill_num = ($seckill_data['seckill_num'] - $seckill_data['sell_num']);
        $original_num = $buy_num - $seckill_num;

        \Yii::warning([
            'res' => '部分充足',
            'price' => $seckill_num * $seckill_price + $original_num * $goods_price,
            'm_data' => $seckill_data,
        ]);

        return [
            'seckill_price_num' => $seckill_num,
            'original_price_num' => $original_num,
            'total_price' => $seckill_num * $seckill_price + $original_num * $goods_price,
        ];
    }

    private function setSeckillSellNum($seckill_goods_id, $attr_id_list, $num)
    {
        $seckill_goods = SeckillGoods::findOne($seckill_goods_id);
        if (!$seckill_goods)
            return false;
        sort($attr_id_list);
        $attr_data = json_decode($seckill_goods->attr, true);
        foreach ($attr_data as $i => $attr_row) {
            $_tmp_attr_id_list = [];
            foreach ($attr_row['attr_list'] as $attr) {
                $_tmp_attr_id_list[] = intval($attr['attr_id']);
            }
            sort($_tmp_attr_id_list);
            if ($_tmp_attr_id_list == $attr_id_list) {
                $attr_data[$i]['sell_num'] = intval($attr_data[$i]['sell_num']) + intval($num);
                break;
            }
        }
        $seckill_goods->attr = json_encode($attr_data, JSON_UNESCAPED_UNICODE);
        $res = $seckill_goods->save();
        return $res;
    }

}