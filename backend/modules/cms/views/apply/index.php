<?php
/**
 * Author: lf
 * Blog: https://blog.feehi.com
 * Email: job@feehi.com
 * Created at: 2016-03-21 14:14
 */

/**
 * @var $this yii\web\View
 * @var $dataProvider yii\data\ActiveDataProvider
 */

use backend\grid\GridView;
use backend\widgets\Bar;
use yii\helpers\Html;
use backend\models\FriendLink;
use yii\helpers\Url;
use common\libs\Constants;
use backend\grid\CheckboxColumn;
use backend\grid\ActionColumn;

$this->title = "Friendly Links";
?>
<div class="row">
    <div class="col-sm-12">
        <div class="ibox">
            <?= $this->render('/widgets/_ibox-title') ?>
            <div class="ibox-content">
                <?= Bar::widget([
                    'template' => "{refresh} {delete}",
                ]) ?>
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'columns' => [
                        [
                            'class' => CheckboxColumn::className(),
                        ],
                		[
                		'attribute' => 'name'
                		],
                		[
                		'attribute' => 'mobile'
                		],
                        [
                          'attribute' => 'weixin',
                        ],
						[
						'attribute' => 'content',
						],
                        [
                            'attribute' => 'created_at',
                            'format' => 'date',
                        ],
                        [
                            'class' => ActionColumn::className(),
                			'template' => '{delete}',
                            'width' => '190px'
                        ],
                    ]
                ]) ?>
            </div>
        </div>
    </div>
</div>