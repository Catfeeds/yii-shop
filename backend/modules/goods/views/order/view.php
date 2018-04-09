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

$this->title = "订单请情";
?>
<div class="row">
    <div class="col-sm-12">
        <div class="ibox float-e-margins">
            <?= $this->render('/widgets/_ibox-title') ?>
            <div class="ibox-content">
				<div id="w1" class="fixed-table-header" style="margin-right: 0px;">
					<div class="ibox-title"><h5>订单商品</h5></div>
					<table class="table table-hover">
						<thead>
							<tr><th>商品名称</th><th>数量</th><th>单价</th><th>退款情况</th></tr>	
						</thead>
						<tbody>
							<?php foreach($data as $v):?>
							<tr><td><?=$v['goods_name']?></td><td><?=$v['goods_num']?></td><td><?=$v['shop_price']?></td></tr>
							<?php endforeach;?>
						</tbody>
					</table>
					<div class="ibox-title" style="margin-top:50px;"><h5>订单信息</h5></div>
					
					<table class="table table-hover">
						<thead>
							<tr><th>订单号：</th><th>订单状态</th><th>下单会员</th></tr>	
						</thead>
						<tbody>
							<tr><th><?=$model->order_sn?></th><th><?=$model->orderStatus[$model->order_status]?></th><th><?=$model->getUserMobile()?></th></tr>	
						</tbody>
					</table>
					<div class="ibox-title" style="margin-top:50px;"><h5>订单收货人</h5></div>
					<table class="table table-hover" >
						<thead>
							<tr><th>收货人</th><th>地址：</th><th>手机号码</th><th>订单留言</th><th>物流公司：</th><td>快递单号：</td></tr>	
						</thead>
						<tbody>
							<tr><th><?=$model->consignee?></th><th><?=$model->address?></th><th><?=$model->mobile?></th><th><?=$model->message?></th><th><?=$model->pay[$model->pay_id]?></th><th><?=$model->trade_no?></th><th>物流公司</th><td><?=$model->invoice_no?></td></tr>	
						</tbody>
					</table>
				</div>
            </div>
        </div>
    </div>
</div>