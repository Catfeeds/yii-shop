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
use yii\data\ArrayDataProvider;

use common\models\goods\mongodb\Attr;
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
class Category extends \yii\db\ActiveRecord
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
        return '{{%category}}';
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
            [['sort', 'parent_id', 'created_at', 'updated_at','is_leaf','status'], 'integer'],
            [['name', 'image', 'parent_url','brief'], 'string', 'max' => 255],
            [['name','image','sort'], 'required'],
        ];
    }


    /**
     * @return array|\yii\db\ActiveRecord[]
     */
    protected static function _getCategories()
    {
        return self::find()->orderBy("sort asc,parent_id asc")->asArray()->all();
    }

    /**
     * @return array
     */
    public static function getCategories()
    {
        $categories = self::_getCategories();
        $familyTree = new FamilyTree($categories);
        $array = $familyTree->getDescendants(0);
        return ArrayHelper::index($array, 'id');
    }

    /**
     * @return array
     */
    public static function getCategoriesName()
    {
        $categories = self::getCategories();
        $data = [];
        foreach ($categories as $v){
            $data[$v['id']] = str_repeat('--', $v['level']) . $v['name'];
        }
        return $data;
    }

    /**
     * @param $id
     * @return array
     */
    public static function getDescendants($id)
    {
        $familyTree = new FamilyTree(self::_getCategories());
        return $familyTree->getDescendants($id);
    }

    /**
     * @inheritdoc 子栏目 不能删除
     */
    public function beforeDelete()
    {
        $categories = self::find()->orderBy("sort asc,parent_id asc")->asArray()->all();
        $familyTree = new FamilyTree( $categories );
        $subs = $familyTree->getDescendants($this->id);
        if (! empty($subs)) {
            $this->addError('id', yii::t('app', 'Allowed not to be deleted, sub level exsited.'));
            return false;
        }
        if(Attr::findOne(['cid' => $this->id]))
        {
        	$this->addError('id', yii::t('app', '该栏目下还有属性，不能被删除'));
        	return false;
        }
        return parent::beforeDelete();
    }

    /**
     * @inheritdoc
     */
    public function afterValidate()
    {
        if (! $this->getIsNewRecord() ) {
            if( $this->id == $this->parent_id ) {
                $this->addError('parent_id', yii::t('app', 'Cannot be themself sub.'));
                return false;
            }
            $familyTree = new FamilyTree(self::_getCategories());
            $descendants = $familyTree->getDescendants($this->id);
            $descendants = array_column($descendants, 'id');
            if( in_array($this->parent_id, $descendants) ){
                $this->addError('parent_id', yii::t('app', 'Cannot be themselves descendants sub'));
                return false;
            }
        }
    }
    
    /**
     * 添加 修改前业务处理
     * */
    public function beforeSave($insert)
    {	
    	if(!$this->parent_id)
    	{
    		$this->parent_id = 0;
    	}
    	$parent = self::findOne($this->parent_id);
    	if($parent['is_leaf'] == 1)
    	{
    		$this->addError('is_leaf','上级分类为叶节点，不可在设置子分类');
    		return false;
    	}
    	if( trim( $parent['parent_url'] ,'-' ) ){
    		$this->parent_url = '-' .trim( $parent['parent_url'] ,'-' ) .'-'.$this->parent_id.'-';
    	}else{
    		$this->parent_url = '-'.$this->parent_id.'-';
    	}
    	return parent::beforeSave($insert);
    }
	
    

    public function search($params)
    {	
    	$categories = self::_getCategories();
    	$familyTree = new FamilyTree($categories);
    	$array = $familyTree->getDescendants(0);
    	$data = ArrayHelper::index($array, 'id');
    	
    	$dataProvider = new ArrayDataProvider([
    			'allModels' => $data,
                'pagination' => [
                            'pageSize' => -1
                        ]
    			]);
    	return $dataProvider;
    }
    
    
    public function attributeLabels()
    {
    	return [
    		'name' =>'栏目名称',
    		'sort'=>'排序',
    		'status' =>'是否显示',
    		'brief'=>'简介',
    		'image'=>'图片'
    	];
    }
}
