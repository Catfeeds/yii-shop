<?php

namespace common\models\order;

use Yii;

/**
 * This is the model class for table "{{%user_address}}".
 *
 * @property string $id
 * @property string $user_id
 * @property string $consignee
 * @property string $mobile
 * @property integer $province
 * @property string $city
 * @property string $district
 * @property string $address
 * @property string $postcode
 * @property integer $default_address
 */
class UserAddress extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user_address}}';
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
            [['user_id', 'consignee', 'mobile', 'province', 'city', 'district', 'address', 'postcode'], 'required'],
            [['user_id', 'province', 'city', 'district', 'default_address'], 'integer'],
            [['consignee', 'address'], 'string', 'max' => 100],
            [['mobile'], 'string', 'max' => 20],
            [['postcode'], 'string', 'max' => 10],
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
}
