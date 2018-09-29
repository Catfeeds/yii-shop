<?php
/**
 * User: Xany <762632258@qq.com>
 * Date: 2017/7/15
 * Time: 14:33
 */

namespace common\models\shop\form;


use common\models\shop\Attr;
use common\models\shop\Product;
use common\models\shop\Cart;
use common\models\shop\Goods;
use common\models\shop\SeckillGoods;
use yii\data\Pagination;
use Yii;
class CartListForm extends Model
{
    public $store_id;
    public $user_id;
    public $page;
    public $limit;

    public function rules()
    {
        return [
            [['page', 'limit'], 'integer'],
            [['page',], 'default', 'value' => 1],
            [['limit',], 'default', 'value' => 20],
        ];
    }

    public function search()
    {	
        $query = Cart::find()->where(['store_id' => $this->store_id, 'user_id' => $this->user_id]);
        $count = $query->count();
        $pagination = new Pagination(['totalCount' => $count, 'page' => $this->page - 1]);
        /* @var Cart[] $list */
        $list = $query->orderBy('goods_id DESC')->limit($pagination->limit)->offset($pagination->offset)->all();
        $new_list = [];
        foreach ($list as $item) {
            /*$goods = Goods::findOne([
                'id' => $item->goods_id,
                'is_delete' => 0,
                'status' => 1,
            ]);*/
        	if($item->product_id)
        	{
        		$product = Product::findOne($item->product_id);
        		$goods = Goods::findOne(['_id' => $product->goods_id]);
        		$goods->store = $product->store;
        		$goods->shop_price = $product->shop_price;
        	}else
        	{
	            $goods = Goods::findOne(['_id' => $item->goods_id]);
        	}
            if (!$goods){
                continue;
            }
            $new_item = (object)[
                'cart_id' => (string)$item->_id,
                'goods_id' => (string)$goods->_id,
                'product_id'=> $item->product_id,
                'goods_name' => $goods->name,
                'goods_pic' =>Yii::$app->params['image'].$goods->image[0],
                'num' => $item->num,
                'attr_list' => $item->attr,
                'price' => $goods->shop_price,
                'max_num' => $goods->store,
                'disabled' => ($item->num > $goods->store) ? true : false,
            ];

            //秒杀价计算
            /*$seckill_data = $this->getSeckillData($goods, json_decode($item->attr, true));
            if ($seckill_data) {
                $temp_price = $this->getSeckillPrice($seckill_data, $goods, json_decode($item->attr, true), $item->num);
                if ($temp_price !== false)
                    $new_item->price = $temp_price;
            }*/

            $new_list[] = $new_item;
        }
        return [
            'code' => 0,
            'msg' => 'success',
            'data' => [
                'row_count' => $count,
                'page_count' => $pagination->pageCount,
                'list' => $new_list,
            ],
        ];
    }

    /**
     * @param Goods $goods
     * @param array $attr_id_list eg.[12,34,22]
     * @return array ['attr_list'=>[],'seckill_price'=>'秒杀价格','seckill_num'=>'秒杀数量','sell_num'=>'已秒杀商品数量']
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
        return $seckill_data;
    }

    /**
     * 获取商品秒杀价格，若库存不足则使用商品原价，若有部分库存，则部分数量使用秒杀价，部分使用商品原价，商品库存不足返回false
     * @param array $seckill_data ['attr_list'=>[],'seckill_price'=>'秒杀价格','seckill_num'=>'秒杀数量','sell_num'=>'已秒杀商品数量']
     * @param Goods $goods
     * @param array $attr_id_list eg.[12,34,22]
     * @param integer $buy_num 购买数量
     *
     * @return false|float
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
            return $buy_num * $seckill_price;
        }

        $seckill_num = ($seckill_data['seckill_num'] - $seckill_data['sell_num']);
        $original_num = $buy_num - $seckill_num;

        \Yii::warning([
            'res' => '部分充足',
            'price' => $seckill_num * $seckill_price + $original_num * $goods_price,
            'm_data' => $seckill_data,
        ]);
        return $seckill_num * $seckill_price + $original_num * $goods_price;
    }

}