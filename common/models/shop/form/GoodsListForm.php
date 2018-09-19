<?php
/**
 * User: Xany <762632258@qq.com>
 * Date: 2017/7/1
 * Time: 23:33
 */

namespace common\models\shop\form;


use common\models\shop\Cat;
use common\models\shop\Goods;
use common\models\shop\GoodsPic;
use common\models\shop\Order;
use common\models\shop\OrderDetail;
use yii\data\Pagination;
use Yii;
class GoodsListForm extends Model
{
    public $store_id;
    public $keyword;
    public $cat_id;
    public $page;
    public $limit;

    public $sort;
    public $sort_type;


    public function rules()
    {
        return [
            [['keyword'], 'trim'],
            [['store_id', 'cat_id', 'page', 'limit',], 'integer'],
            [['limit',], 'integer', 'max' => 100],
            [['limit',], 'default', 'value' => 12],
            [['sort', 'sort_type',], 'integer',],
            [['sort',], 'default', 'value' => 0],
        ];
    }

    public function search()
    {
        if (!$this->validate())
            return $this->getModelError();
        $query = Goods::find();
       /* $query = Goods::find()->where([
            'status' => 1,
            'is_delete' => 0,
        ]);
        if ($this->store_id)
            $query->andWhere(['store_id' => $this->store_id]);
        if ($this->cat_id) {
            $query->andWhere(
                [
                    'OR',
                    ['cid' => $this->cat_id],
                    ['cid' => Cat::find()->select('id')->where(['is_delete' => 0, 'parent_id' => $this->cat_id])],
                ]
            );
        }
        if ($this->keyword)
            $query->andWhere(['LIKE', 'name', $this->keyword]);*/
        $count = $query->count();
        $pagination = new Pagination(['totalCount' => $count, 'pageSize' => $this->limit, 'page' => $this->page - 1]);
        if ($this->sort == 0) {
            //综合，自定义排序+时间最新
            $query->orderBy('sort ASC, created_at DESC');
        }
        if ($this->sort == 1) {
            //时间最新
            $query->orderBy('created_at DESC');
        }
        if ($this->sort == 2) {
            //价格
            if ($this->sort_type == 0) {
                $query->orderBy('shop_price ASC');
            } else {
                $query->orderBy('shop_price DESC');
            }
        }
        if ($this->sort == 3) {
            //销量
            $query->orderBy([
                '( IF(gn.num, gn.num, 0) + virtual_sales)' => SORT_DESC,
                'g.addtime' => SORT_DESC,
            ]);
        }

    
        $list = $query->select(['_id','name','shop_price','sales_sum','image','virtual_sales'])
            ->limit($pagination->limit)
            ->offset($pagination->offset)
            ->asArray()->all();

       /* foreach ($list as $i => $item) {
            if (!$item['pic_url']) {
                $list[$i]['pic_url'] = Goods::getGoodsPicStatic($item['id'])->pic_url;
            }
            $list[$i]['sales'] = $this->numToW($item['num'] + $item['virtual_sales']).$item['unit'];
        }*/
        foreach($list as $k => $v)
        {
        	$v['image'][0] = Yii::$app->params['image'].$v['image'][0];
        	$list[$k] = $v;
        }
        return [
            'code' => 0,
            'msg' => 'success',
            'data' => [
                'row_count' => $count,
                'page_count' => $pagination->pageCount,
                'list' => $list,
            ],
        ];
    }

    private function numToW($sales)
    {
        if($sales < 10000){
            return $sales;
        }else{
            return round($sales/10000,2).'W';
        }
    }
}