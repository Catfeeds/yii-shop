<?php
/**
 * User: Xany <762632258@qq.com>
 * Date: 2017/8/15
 * Time: 9:56
 */

namespace common\models\shop\form;

use app\extensions\getInfo;
use common\models\shop\Favorite;
use common\models\shop\Goods;
use common\models\shop\GoodsPic;
use common\models\shop\SeckillGoods;
use Yii;
class GoodsForm extends Model
{
    public $id;
    public $user_id;
    public $store_id;
	
    
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['user_id'], 'safe'],
        ];
    }

    /**
     * 排序类型$sort   1--综合排序 2--销量排序
     */
    public function search()
    {
        if (!$this->validate())
            return $this->getModelError();
       /* $goods = Goods::findOne([
            '_id' => $this->id,
            'is_delete' => 0,
            'status' => 1,
            'store_id' => $this->store_id,
        ]);*/
        $goods = Goods::findOne([
        		'_id' => $this->id
        		]);
        if (!$goods)
            return [
                'code' => 1,
                'msg' => '商品不存在或已下架',
            ];
        /*$is_favorite = 0;
        if ($this->user_id) {
            $exist_favorite = Favorite::find()->where(['user_id' => $this->user_id, 'goods_id' => $goods->id, 'is_delete' => 0])->exists();
            if ($exist_favorite)
                $is_favorite = 1;
        }
        $service_list = explode(',', $goods->service);
        $new_service_list = [];
        if (is_array($service_list))
            foreach ($service_list as $item) {
                $item = trim($item);
                if ($item)
                    $new_service_list[] = $item;
            }
        $res_url = getInfo::getVideoInfo($goods->video_url);
        $goods->video_url = $res_url['url'];*/
        $image = [];
        if($goods->image){
        	foreach ($goods->image as $k =>$v){
        		$image[$k] = Yii::$app->params['image'].$v;
        	}
        }
        return [
            'code' => 0,
            'data' => (object)[
                'id' => (string)$goods->_id,
                'pic_list' => $image,
                'name' => $goods->name,
                'price' => floatval($goods->shop_price),
                'detail' => $goods->content,
                'sales_volume' => '',
                'attr_group_list' => $goods->getAttrGroupList(),
                'num' => 10,
                'is_favorite' => 1,
                'service_list' => [],
                'original_price' => floatval($goods->shop_price),
                'video_url' => '',
                'unit' => 0,
                'seckill' => [],
                'use_attr' => [],
            ],
        ];
    }

    //获取商品秒杀数据
    public function getSeckillData($goods_id)
    {
        $seckill_goods = SeckillGoods::findOne([
            'goods_id' => $goods_id,
            'is_delete' => 0,
            'start_time' => intval(date('H')),
            'open_date' => date('Y-m-d'),
        ]);
        if (!$seckill_goods)
            return null;
        $attr_data = json_decode($seckill_goods->attr, true);
        $total_seckill_num = 0;
        $total_sell_num = 0;
        $seckill_price = 0.00;
        foreach ($attr_data as $i => $attr_data_item) {
            $total_seckill_num += $attr_data_item['seckill_num'];
            $total_sell_num += $attr_data_item['sell_num'];
            if ($seckill_price == 0) {
                $seckill_price = $attr_data_item['seckill_price'];
            } else {
                $seckill_price = min($seckill_price, $attr_data_item['seckill_price']);
            }
        }
        return [
            'seckill_num' => $total_seckill_num,
            'sell_num' => $total_sell_num,
            'seckill_price' => (float)$seckill_price,
            'begin_time' => strtotime($seckill_goods->open_date . ' ' . $seckill_goods->start_time . ':00:00'),
            'end_time' => strtotime($seckill_goods->open_date . ' ' . $seckill_goods->start_time . ':59:59'),
            'now_time' => time(),
        ];
    }
}