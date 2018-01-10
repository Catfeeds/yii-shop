<?php
/**
 * Author: lf
 * Blog: https://blog.feehi.com
 * Email: job@feehi.com
 * Created at: 2016-03-21 14:35
 */

/**
 * @var $this yii\web\View
 * @var $model backend\models\FriendLink
 */

use backend\widgets\ActiveForm;
use common\libs\Constants;

$this->title = "Friendly Links";
?>
<div class="row">
    <div class="col-sm-12">
        <div class="ibox">
            <?= $this->render('/widgets/_ibox-title') ?>
            <div class="ibox-content">
                <?php $form = ActiveForm::begin([
                    'options' => [
                        'enctype' => 'multipart/form-data',
                        'class' => 'form-horizontal'
                    ]
                ]); ?>
                <div class="hr-line-dashed"></div>
                <?php if(!$model->postion) $model->postion = 1;?>
                <?= $form->field($model, 'postion')->radioList(['1'=>'首页']) ?>
                <div class="hr-line-dashed"></div>
                <?= $form->field($model, 'image')->widget('\common\widgets\images\Images',['type' => 'image', 'saveDB'=>0],['class'=>'c-md-12'])->label('logo')?>
                <div class="hr-line-dashed"></div>
                <?= $form->field($model, 'url')->textInput(['maxlength' => 512]) ?>
                <div class="hr-line-dashed"></div>
                <?= $form->field($model, 'sort')->textInput(['maxlength' => 64,'value' =>1]) ?>
                <div class="hr-line-dashed"></div>
                <?= $form->field($model, 'title')->textInput(['maxlength' => 512]) ?>
                <?= $form->defaultButtons() ?>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>