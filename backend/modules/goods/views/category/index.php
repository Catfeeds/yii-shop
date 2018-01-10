<?php
/**
 * Author: lf
 * Blog: https://blog.feehi.com
 * Email: job@feehi.com
 * Created at: 2016-03-23 17:51
 */

/**
 * @var $this yii\web\View
 * @var $dataProvider frontend\models\User
 * @var $searchModel backend\models\UserSearch
 */

use backend\grid\GridView;
use frontend\models\User;
use yii\helpers\Html;
use backend\widgets\Bar;
use backend\grid\CheckboxColumn;
use backend\grid\ActionColumn;
use yii\helpers\Url;

$this->title = 'Users';

$attr = function ($url, $model) {
	return Html::a('<i class="fa fa-magnet"></i>属性管理' , Url::to(['attr/index', 'id' => $model['id']]), [
			'title' => 'attr',
			'class' => 'btn btn-white btn-sm'
			]);
};
?>
<div class="row">
    <div class="col-sm-12">
        <div class="ibox">
            <?= $this->render('/widgets/_ibox-title') ?>
            <div class="ibox-content">
                <?= Bar::widget([
                    'template' => '{refresh} {create} {delete}',
                ]) ?>
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'columns' => [
                        [
                            'class' => CheckboxColumn::className(),
                        ],
                        [
                            'attribute' => 'id'
                        ],
                		 [
                            'attribute' => 'name',
                            'label' => yii::t('app', 'Name'),
                            'format' => 'html',
                            'value' => function ($model, $key, $index, $column) {
                                return str_repeat('--', $model['level']) . $model['name'];
                            }
                        ],
                        [
                            'attribute' => 'image',
                			'format' => [
                				'image',['width'=>'84','height'=>'84']
                			],
							'value'=>function($model){
								return Yii::$app->params['image'].$model['image'];
							}
                        ],
                         [
                            'attribute' => 'sort'
                        ],
                        [
                        	'attribute'=>'status',
                			'value' => function($model){
                				$return = [1 =>'显示',0=>'不显示'];
                				return $return[$model['status']];
                			}
                		],
						[
							'attribute' => 'created_at',
							'format' => ['date','php:Y-m-d'],
                			'label' =>'添加时间'
						],
                		[
                			'attribute' => 'updated_at',
                			'format' => ['date','php:Y-m-d'],
                			'label' =>'修改时间'
                		],
                        [
                            'class' => ActionColumn::className(),
                			'template' => '{attr}{update}{delete}',
                			'buttons' => ['attr' => $attr],
                            'width' => '190px'
                        ],
                    ]
                ]); ?>
            </div>
        </div>
    </div>
</div>