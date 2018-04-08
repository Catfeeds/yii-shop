<?php
/**
 * Created by PhpStorm.
 * User: grace
 * Date: 2017\12\7 0007
 * Time: 13:56
 */

namespace common\service\order;

use Yii;
use common\models\order\Shipping;
use common\service\BaseService;

class ShippingService extends BaseService
{	
	
	
	
    public function init()
    {
        parent::init(); // TODO: Change the autogenerated stub
    }
	
   
    public function getList()
    {
    	return  Shipping::find()->select(['shipping_id','shipping_code','name'])->asArray()->all();
    	
    }
    
    
    
}