<?php
/**
 * Author: lf
 * Blog: https://blog.feehi.com
 * Email: job@feehi.com
 * Created at: 2016-03-21 14:35
 */

/**
 * @var $this yii\web\View
 * @var $model common\models\Category
 */

use backend\widgets\ActiveForm;
use common\models\Category;
use  common\service\order\ShippingService;

$this->title = "修改订单";
?>
<div class="row">
    <div class="col-sm-12">
        <div class="ibox">
            <?= $this->render('/widgets/_ibox-title') ?>
            <div class="ibox-content">
                <?php $form = ActiveForm::begin();?>
                <?= $form->field($model, 'shipping_id')
                    ->label('配送物流')
                    ->dropDownList(ShippingService::getListArray()) ?>
                <div class="hr-line-dashed"></div>
                <?= $form->field($model, 'invoice_no')->textInput(['maxlength' => 64]) ?>
                <div class="hr-line-dashed"></div>
                <?= $form->field($model, 'order_amount')->textInput(['maxlength' => 64]) ?>
                <div class="hr-line-dashed"></div>
                <?= $form->field($model, 'consignee')->textInput(['maxlength' => 64]) ?>
                <div class="hr-line-dashed"></div>
                <?= $form->field($model, 'mobile')->textInput(['maxlength' => 64]) ?>
                 <div class="hr-line-dashed"></div>
                <?= $form->field($model, 'province')->textInput(['maxlength' => 64]) ?>
                <div class="hr-line-dashed"></div>
                <?= $form->field($model, 'city')->textInput(['maxlength' => 64]) ?>
                <div class="hr-line-dashed"></div>
                <?= $form->field($model, 'district')->textInput(['maxlength' => 64]) ?>
                <div class="hr-line-dashed"></div>
                <?= $form->field($model, 'address')->textInput(['maxlength' => 64]) ?>
                <?= $form->defaultButtons() ?>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>