<?php
/**
 * User: Xany <762632258@qq.com>
 * Date: 2017/7/25
 * Time: 15:44
 */

namespace common\models\shop\form;


use common\models\shop\District;
use common\models\shop\Address;

class AddressListForm extends Model
{
    public $user_id;

    public function rules()
    {
        return [
            [['user_id',], 'required'],
            [['user_id',], 'integer'],
        ];
    }


    public function search()
    {
        if (!$this->validate())
            return $this->getModelError();
		
        
        $list = Address::find()->select(['id','name','mobile','province_id','province','city_id','city','district_id','district','detail','is_default'])->where([
        		'user_id' => \Yii::$app->user->id
        		])->orderBy('is_default DESC,created_at DESC')->asArray()->all();
        foreach ($list as $i => $item) {
        	$list[$i]['id'] = (string)$item["_id"];
        	$list[$i]['address'] = $item['province'] . $item['city'] . $item['district'] . $item['detail'];
        }
        
        return ['code' => 0,'data' => ['list' => $list]];
    }
}