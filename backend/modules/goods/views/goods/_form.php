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
use common\models\goods\mongodb\Brand;
use yii\helpers\ArrayHelper;
use common\helpers\FuncHelper;
use common\widgets\ueditor\Ueditor;
use backend\assets\GoodsAsset;
use backend\assets\AttrAsset;
use yii\helpers\Html;
use common\widgets\JsBlock;
$this->title = "商品管理";
GoodsAsset::register($this);
AttrAsset::register($this);
$ext = $model->ext;
?>
<style>
.div_ext ul li{
	display: inline-block;
	width:80px;
	text-align: center;
}
</style>
<div class="row">
    <div class="col-sm-12">
        <div class="ibox float-e-margins">
            <?= $this->render('/widgets/_ibox-title') ?>
            <div class="ibox-content">
            	<div class="row form-body form-horizontal m-t">
            		<div class="col-md-12 droppable sortable ui-droppable ui-sortable" style="display: none;"></div>
	                 <?php $form = ActiveForm::begin([
                        'options' => [
                            'enctype' => 'multipart/form-data',
                            'class' => 'form-horizontal'
                        ]
                    ]); ?>
                    <!--left start-->
                    <div class="col-md-7 droppable sortable ui-droppable ui-sortable" style="">
		                <?= $form->field($model, 'name')->textInput(['maxlength' => 255]) ?>
		                <?= $form->field($model, 'short_name')->textInput(['maxlength' => 50]) ?>
		                <?= $form->field($model, 'weight')->textInput(['maxlength' => 50]) ?>
		               	<?= $form->field($model, 'shop_price')->textInput(['maxlength' => 50]) ?>
		                <?= $form->field($model, 'cost_price')->textInput(['maxlength' => 50]) ?>
		                <?= $form->field($model, 'sort')->label('排序')->textInput(['maxlength' => 512,'value' =>1]) ?>
		                <?= $form->field($model, 'bid')->dropDownList(FuncHelper::toStr(Brand::find()->select(['_id','name'])->asArray()->all())) ?>
		                <?php if(!$model->status) $model->status=1;?>
		                <?= $form->field($model, 'status')->radioList(['1'=>'上架',0=>'下架']) ?>
		                <?= $form->field($model, 'image')->widget('\common\widgets\images\Images',['type' => 'images', 'saveDB'=>0],['class'=>'c-md-12'])?>
						<?= $form->field($model, 'brief')->textarea(); ?>
						<?= $form->field($model, 'content')->widget(Ueditor::className()) ?>
						</div>
						<div class="col-md-5 droppable sortable ui-droppable ui-sortable" style="">
						<?php if(!in_array($model->is_product,[1,0]))$model->is_product=1;?>
                    	<div class="form-group field-goods-store" <?php if($model->is_product == 1):?>style="display:none"<?php endif;?>>
							<label class="col-sm-2 control-label" for="goods-store">库存</label>
							<div class="col-sm-10"><input type="text" id="goods-store" class="form-control" name="store" maxlength="50" <?php if(isset($store['store']))echo 'value="'.$store['store'].'"'?>>
								<div class="help-block m-b-none"></div>
							</div>
						</div>
						<?= $form->field($model, 'is_product')->label('是否有sku')->radioList([1=>'是',0=>'否']) ?>
						<div class="form-group">
							<div class="ibox-content" style="margin-left:12%">
				                <div class="div_title"><h5>扩展属性</h5>
				                	<a id="add-sku" class="btn btn-white btn-sm" href="javascript:;" title="创建" data-pjax="0"><i class="fa fa-plus"></i> 创建</a>
				                </div>
				                <div class="div_ext">
				                    <?php if(count($attr)>=1): foreach($attr as $val):?>
				                    <?php if($val['is_sale']==1) continue;?>
				                        <ul><li><?=$val['name']?>:</li>
				                        <li><select class="f_fl" name="Goods[ext][<?=$val['_id']?>]">
                            							<option value="0">请选择</option>
                            							<?php foreach($val['value'] as $v):?>
                                                        <option value="<?=$v?>" <?php if($ext["{$val['_id']}"] == $v) echo 'selected';?>><?=$v?></option>
                                                        <?php endforeach;?>
                                         </select>
                                         
                                         
                                <table class="table table-hover u_tab">
								<thead><tr><th>属性名称</th><th>属性值</th><th>操作</th></tr></thead>
								<tbody>
									<?php if($ext):foreach($ext as $k=>$v):?>
									<tr class="cate_attr">
										<td>  <input type="text" name="Goods[ext][][key]"></td>
										<td>  <input type="text" name="Goods[ext][][value]"></td>
										<td><a href="javascript:;" class="attr-del">删除</a></td>
            						</tr>
									<?php endforeach; endif;?>
								</tbody>
							</table>
                                         </li>
				                        </ul>
				                       	
				                    <?php endforeach; endif;?>
				                </div>
           					 </div>
						</div>
						<div class="form-group" <?php if($model->is_product==2):?>style="display:none"<?php endif;?>>
							<div class="ibox-content" style="margin-left:12%" id="sku-content">
							    <div style="padding: 5px 8px;" class="div_content">
				                    <div class="div_title"><h5>产品规格</h5></div>
				                    <div class="div_contentlist">
				                    	 <?php $i=0; $k=0;if(count($attr)>=1): foreach($attr as $val):?>
				                    	 <?php if($val['is_sale']!=1) continue;?>
				                        	<ul class="Father_Title"><li><?=$val['name']?></li></ul>
				                        	<ul class="Father_Item<?=$k++?>">
				                        		<?php foreach($val['value'] as $v):?>
				                            	<li class="li_width"><label><input id="Checkbox<?=++$i?>" type="checkbox" class="chcBox_Width" value="<?=$v?>" <?php if(isset($checkedSku)&&in_array($v,$checkedSku))echo 'checked';?> name="<?=$val['_id']?>" ><?=$v?><span class="li_empty"> </span></label></li>
				                        		<?php endforeach;?>
				                        	</ul>
				                        	<br>
				                         <?php endforeach; endif;?>
				                    </div>
				                    <div class="div_contentlist2">
				                        <ul>
				                            <li>
				                            	<div id="createTable">
				                            		<?php if(isset($products) && count($products)>=1):?>
				                            			<table id="process" border="1" cellpadding="1" cellspacing="0" style="width:100%;padding:5px;"><thead><tr>
				                            			<?php foreach($head as $th):?>
				                            			<th><?=$th['name']?></th>
				                            			<?php endforeach;?>
				                            			<th style="width:70px;">价格</th>
				                            			<th style="width:70px;">库存</th><th style="width:70px;">商品编码</th><th style="width:70px;">操作</th><th style="width:70px;">是否录入商品</th></tr></thead>
				                            			<tbody>
				                            				<?php foreach($products as $key=>$value):?>
				                            				<tr class="multi_select">
				                            				<?php foreach($value['attr_name'] as $n):?>
				                            				<td><?=$n?></td>
				                            				<?php endforeach;?>
				                            				<td><input name="product[<?=$key?>][shop_price]" class="l-text" type="text" value="<?=$value['shop_price']?>"></td>
				                            				<td><input name="product[<?=$key?>][store]" class="l-text" type="text" value="<?=$value['store']?>"></td>
				                            				<td><input name="product[<?=$key?>][code]" class="l-text" type="text" value="<?=$value['code']?>"></td>
				                            				<td><select name="product[<?=$key?>][status]">
				                            						<option value="1" <?php if($value['status']==1) echo 'selected';?>>上架</option>
				                            						<option value="2" <?php if($value['status']==2) echo 'selected';?>>下架</option></select>
				                            				</td>
				                            				<td><select name="product[<?=$key?>][disabled]" class="is_write">
				                            					<option value="1" selected>是</option>
				                            					<option value="2">否</option></select>
				                            					<input type="hidden" name="product[<?=$key?>][id]" value="<?=$value['id']?>" >
				                            				</td></tr>
				                            				<?php endforeach;?>
				                            				</tbody></table>
				                            		<?php endif;?>
				                            	</div>
				                            </li>
				                        </ul>
				                    </div>
			                	</div>
			           		</div>
						</div>
						
						
                    </div>
                    <input type="hidden" name="Goods[cid]" value="<?=$model->cid?>"/>
                    <?= $form->defaultButtons(['size' => 12]) ?>
                    <!--left end-->
	                <?php ActiveForm::end(); ?>
            	</div>
            </div>
        </div>
    </div>
</div>
<script type="text/html" id="add-attr-ext">
	<tr class="cate_attr">
		<td><input type="text" name="Goods[ext][][key]"></td>
		<td><input type="text" name="Goods[ext][][value]"></td>
		<td><a href="javascript:;" class="attr-del">删除</a></td>
    </tr>
</script>
<?php JsBlock::begin() ?>
<script>
	 var jsAttr = <?=$jsAttr?>;
</script>
<?php JsBlock::end();?>