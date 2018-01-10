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
$this->title = "选择商品分类";
?>
<div class="row">
    <div class="col-sm-12">
        <div class="ibox">
            <?= $this->render('/widgets/_ibox-title') ?>
            <div class="ibox-content">
                <?php $form = ActiveForm::begin(); ?>
                <?= $form->field($model, 'cid')->label('分类')->dropDownList(Category::getCategoriesName()) ?>
                <div class="hr-line-dashed"></div>
                <div class="form-group">
                                <div class="col-sm-12 col-sm-offset-2">
                                    <button class="btn btn-primary" type="submit">下一步</button>
                                </div>
                </div
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>