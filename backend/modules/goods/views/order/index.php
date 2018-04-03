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

$this->title = "Admin Log";
?>
<div class="row">
    <div class="col-sm-12">
        <div class="ibox">
            <?= $this->render('/widgets/_ibox-title') ?>
            <div class="ibox-content">
                <?= Bar::widget([
                    'template' => '{refresh} {update}'
                ]) ?>
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [
                        [
                            'class' => CheckboxColumn::className(),
                        ],
                        [
                            'attribute' => 'id',
                        ],
                        [
                            'attribute' => 'order_sn',
                        ],
                        [
                            'attribute' => 'trade_no',
                        ],
                		[
                			'attribute' => 'user_id',
                			'value' => function($model){
                				return  $model->user;
                				
                			}
                		],
                       [
							'attribute' => 'created_at',
							'format' => ['date','php:Y-m-d'],
						],
                    ]
                ]); ?>
            </div>
        </div>
    </div>
</div>