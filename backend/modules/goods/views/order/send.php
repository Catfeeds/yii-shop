<?php
/**
 * Author: lf
 * Blog: https://blog.feehi.com
 * Email: job@feehi.com
 * Created at: 2016-03-23 15:49
 */

/**
 * @var $this yii\web\View
 * @var $model backend\models\Article
 */

use backend\widgets\ActiveForm;
use yii\helpers\Html;

$this->title = "订单发货";
?>
<div class="row">
    <div class="col-sm-12">
        <div class="ibox float-e-margins">
            <?= $this->render('/widgets/_ibox-title') ?>
            <div class="ibox-content">
                <div class="row form-body form-horizontal m-t">
					<?php $form = ActiveForm::begin([
                        'options' => [
                            'enctype' => 'multipart/form-data',
                            'class' => 'form-horizontal'
                        ]
                    ]); ?>
                    <!--left start-->
                    <div class="col-md-12 droppable sortable ui-droppable ui-sortable">
                    	<div class="form-group">
                    		<label class="col-sm-2 control-label">配送方式</label>
                    		<div class="col-sm-10">
                    			<select name="shipping_id">
                    				<?php foreach($data as $v):?>
                    				<option value="<?=$v['id']?>"><?=$v['name']?></option>
                    				<?php endforeach;?>
                    			</select>
                    		</div>
                    	</div>
                    </div>
					<div class="col-md-12 droppable sortable ui-droppable ui-sortable">
                    	<div class="form-group">
                    		<label class="col-sm-2 control-label">快递单号</label>
                    		<div class="col-sm-10">
                    			<input type="text" name="invoice_no"/>
                    		</div>
                    	</div>
                    </div>
                    <?= $form->defaultButtons(['size' => 12]) ?>
                    <?php $form = ActiveForm::end() ?>
                </div>
            </div>
        </div>
    </div>
</div>