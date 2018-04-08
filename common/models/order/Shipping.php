<?php

namespace common\models\order;

use Yii;

/**
 * This is the model class for table "shipping".
 *
 * @property int $shipping_id 配送方式id
 * @property string $shipping_code 配送方式编号
 * @property string $name 配送名称
 */
class Shipping extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'shipping';
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
            [['shipping_code', 'name'], 'required'],
            [['shipping_code'], 'string', 'max' => 15],
            [['name'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '配送方式id',
            'shipping_code' => '配送方式编号',
            'name' => '配送名称',
        ];
    }
}
