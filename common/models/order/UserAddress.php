<?php

namespace common\models\order;

use Yii;

/**
 * This is the model class for table "user_address".
 *
 * @property string $id
 * @property string $user_id 用户id
 * @property string $consignee 收货人姓名
 * @property string $mobile 联系电话
 * @property string $province 收货地址，省份
 * @property string $city 收货地址：市
 * @property string $district 收货地址：县区
 * @property string $address 收货详细地址
 * @property string $postcode 邮政编码，非必填
 * @property int $default_address 是否为默认收货地址1:是0否
 */
class UserAddress extends \yii\db\ActiveRecord
{	
	
	public $errorMsg = '';
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_address';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('shop');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'consignee', 'mobile', 'province', 'city', 'district', 'address'], 'required'],
            [['user_id'], 'integer'],
            [['consignee', 'address'], 'string', 'max' => 100],
            [['mobile', 'province', 'city', 'district'], 'string', 'max' => 20],
            [['postcode'], 'string', 'max' => 10],
            [['default_address','gender'], 'integer', 'max' => 1],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => '用户id',
            'consignee' => '收货人姓名',
            'mobile' => '联系电话',
            'province' => '收货地址，省份',
            'city' => '收货地址：市',
            'district' => '收货地址：县区',
            'address' => '收货详细地址',
            'postcode' => '邮政编码，非必填',
            'default_address' => '是否为默认收货地址1:是0否',
        ];
    }
    
    
    public function add( array $data)
    {	
    	$this->setAttributes($data);
    	if(!$this->save())
    	{
    		foreach ($this->getErrors() as $v)
    		{
    			$this->errorMsg = $v; break;
    		}
    		return false;
    	}
    	return true;
    }
    
    
    public function getList($userId)
    {
    	$data = $this->find()->where(['user_id' =>$userId])->select(['user_id','consignee','mobile','province','city','district','address','default_address'])->asArray()->all();
    	return $data ?: [];
    }
}
