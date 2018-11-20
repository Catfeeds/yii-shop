<?php
/**
 * User: Xany <762632258@qq.com>
 * Date: 2017/7/2
 * Time: 0:11
 */

namespace common\models\shop\form;


use common\models\shop\Cat;

class CatListForm extends Model
{
    public $store_id;
    public $limit;

    public function rules()
    {
        return [
            [['store_id', 'limit'], 'integer'],
        ];
    }

    public function search()
    {
        if (!$this->validate())
            return $this->getModelError();
        $query = Cat::find()->where([
            'is_delete' => 0,
            'parent_id' => 0,
            'is_show' => 1,
        ]);
        if ($this->store_id)
            $query->andWhere(['store_id' => $this->store_id]);
        if ($this->limit)
            $query->limit($this->limit);
        $query->orderBy('sort ASC');
        $list = $query->select('id,store_id,parent_id,name,pic_url,big_pic_url,advert_pic,advert_url')->asArray()->all();
        foreach ($list as $i => $item) {
            $sub_list = Cat::find()->where([
                'is_delete' => 0,
                'parent_id' => $item['id'],
                'is_show' => 1,
            ])->orderBy('sort ASC')
                ->select('id,store_id,parent_id,name,pic_url,big_pic_url')->asArray()->all();
            $list[$i]['list'] = $sub_list ? $sub_list : [];
        }
        return [
            'code' => 0,
            'msg' => 'success',
            'data' => [
                'list' => $list,
            ],
        ];
    }
}