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
use common\models\goods\Category;
use yii\helpers\ArrayHelper;
$this->title = "Category";
?>
<div class="row">
    <div class="col-sm-12">
        <div class="ibox">
            <?= $this->render('/widgets/_ibox-title') ?>
            <div class="ibox-content">
                <?php $form = ActiveForm::begin(); ?>
                <?= $form->field($model, 'parent_id')->label('上级')->dropDownList(Category::getCategoriesName()) ?>
                <div class="hr-line-dashed"></div>
                <?php if(!$model->status) $model->status = 1;?>
          		<?= $form->field($model, 'status')->radioList(['1'=>'显示',2=>'不显示']) ?>
          		<div class="hr-line-dashed"></div>
                <?= $form->field($model, 'brief')->textarea(); ?>
                <div class="hr-line-dashed"></div>
                <?= $form->field($model, 'name')->textInput(['maxlength' => 64]) ?>
                <div class="hr-line-dashed"></div>

                <?= $form->field($model, 'sort')->textInput(['maxlength' => 512,'value' => 1]) ?>
                <div class="hr-line-dashed"></div>
				<?=$form->field($model, 'image')->widget('\common\widgets\images\Images',['type' => 'image', 'saveDB'=>0],['class'=>'c-md-12']);?>
				<div class="hr-line-dashed"></div>
				<?= $form->defaultButtons(['size' => 12]) ?>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>