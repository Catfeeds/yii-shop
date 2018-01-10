<?php
/**
 * Author: lf
 * Blog: https://blog.feehi.com
 * Email: job@feehi.com
 * Created at: 2017-03-15 21:16
 */

namespace common\models\goods;

use Yii;
use common\helpers\FamilyTree;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;;
use yii\data\ActiveDataProvider;

/**
 * This is the model class for table "{{%category}}".
 *
 * @property string $id
 * @property string $name
 * @property string $sort
 * @property string $created_at
 * @property string $updated_at
 * @property string $remark
 */
class Product extends \yii\db\ActiveRecord
{	
	
	public static function getDb()
	{
		return Yii::$app->shop;
	}
	
	
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%product}}';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['goods_id', 'shop_price', 'code','attr'], 'string','max' => 255],
            [['updated_at', 'created_at', 'status','store','shop_id'], 'integer'],
            [['goods_id','store'], 'required'],
        ];
    }

}
