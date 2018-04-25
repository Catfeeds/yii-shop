<?php


namespace common\models\goods\mongodb;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\data\ActiveDataProvider;
use yii\mongodb\ActiveRecord;
use common\models\goods\Product;
use common\models\goods\Store;
use common\service\goods\GoodsService;

/**
 *
 * @property string $id
 * @property string $name
 * @property string $sort
 * @property string $created_at
 * @property string $updated_at
 * @property string $remark
 */
class Goods extends ActiveRecord
{	
	
	public static function getDb()
	{
		return \Yii::$app->get('mongodbShop');
	}
	
	
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%goods}}';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }
    
    

}
