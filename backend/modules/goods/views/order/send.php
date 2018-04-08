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
use common\models\Category;
use common\libs\Constants;
use yii\helpers\Html;
use common\widgets\ueditor\Ueditor;

$this->title = "Articles";
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
                    <div class="col-md-7 droppable sortable ui-droppable ui-sortable">
                    	<div class="form-group">
                    		<label class="col-sm-2 control-label">配送方式</label>
                    		<div class="col-sm-10">
                    			<select>
                    				<?php foreach($data as $v):?>
                    				<option value="<?=$v['id']?>"><?=$v['name']?></option>
                    				<?php endforeach;?>
                    			</select>
                    		</div>
                    	</div>
                    </div>

                    <?php $form = ActiveForm::end() ?>
                </div>
            </div>
        </div>
    </div>
</div>