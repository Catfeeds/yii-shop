<?php
/**
 * Author: lf
 * Blog: https://blog.feehi.com
 * Email: job@feehi.com
 * Created at: 2016-03-23 17:51
 */

/**
 * @var $this yii\web\View
 * @var $dataProvider backend\models\AdminLog
 * @var $searchModel backend\models\AdminLogSearch
 */

use backend\grid\GridView;
use yii\helpers\Html;
use yii\helpers\StringHelper;
use backend\widgets\Bar;
use backend\grid\CheckboxColumn;
use backend\grid\ActionColumn;
use yii\helpers\Url;
use common\libs\Constants;

$this->title = "Admin Log";
$send = function ($url, $model) {
	if($model->order_status != '2') return '';
	return Html::a('<i class="fa fa-truck"></i>发货' , Url::to(['order/send', 'id' => $model->id]), [
			'title' => '发货',
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
                    'template' => '{refresh} {export}'
                ]) ?>
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [
                       /* [
                            'class' => CheckboxColumn::className(),
                        ],*/
                        [
                            'attribute' => 'id',
                        ],
                        [
                            'attribute' => 'order_no',
                        ],
                		[
                			'attribute' =>'total_price'
                		],
                		
                        [
                            'attribute' => 'trade_no',
                        ],
                		[
                			'attribute' => 'user_id',
                			'value' => function($model){
                				return  $model->getUserMobile();
                				
                			}
                		],
                       [
							'attribute' => 'created_at',
							'format' => ['date','php:Y-m-d'],
							'filter' => Html::activeInput('text', $searchModel, 'create_start_at', [
									'class' => 'form-control layer-date',
									'placeholder' => '',
									'onclick' => "laydate({istime: true, format: 'YYYY-MM-DD hh:mm:ss'});"
									]) . Html::activeInput('text', $searchModel, 'create_end_at', [
											'class' => 'form-control layer-date',
											'placeholder' => '',
											'onclick' => "laydate({istime: true, format: 'YYYY-MM-DD hh:mm:ss'})"
									]),
						],
						[
							'attribute' => 'order_status',
							'value' =>function($model){
                				return $model->orderStatus[$model->order_status];
                			},
                			'filter' =>Constants::getOrderStatus()
						],
						[
							'class' => ActionColumn::className(),
							'template' => '{send} {view-layer} {update}',
							'buttons' => ['send' => $send],
							'width' => '190px'
						],
                    ]
                ]); ?>
            </div>
        </div>
    </div>
</div>