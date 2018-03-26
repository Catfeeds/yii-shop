		<div class="container2">
            <section class="laber_shopUser">
            	<div class="shopUser auto clearfix">
            		<div class="shopUser_main">
            			<p>您好，15038384758</p>
            			<ul>
            				<li><a href="">密码管理</a></li>
            				<li><a href="">购物车</a></li>
            				<li><a href="">收货地址</a></li>
            				<li><a href="">我的订单</a></li>
            			</ul>
            		</div>
            	</div>
            </section>
            <section class="laber_shop">
            	<div class="shop auto clearfix">
            		<div class="shop_main">
            			<h1>填写并核对订单信息</h1>
            			<span>收货信息：</span>
            			<table border="0" cellspacing="0" cellpadding="0">
            				<tr class="tr1">
            					<th class="td1"></th>
            					<th class="td2">收件人姓名</th>
            					<th class="td3">详细地址</th>
            					<th class="td4">联系电话</th>
            				</tr>
            				<tr class="tr2">
            					<td class="td1 tdct"><input name="xz" type="checkbox" /></td>
            					<td class="td2">李美丽</td>
            					<td class="td3">广东省深圳市福田区深南大道大庆大厦</td>
            					<td class="td4">13045682375</td>
            				</tr>
            				<tr class="tr2">
            					<td class="td1 tdct"><input name="xz" type="checkbox" /></td>
            					<td class="td2">李美丽</td>
            					<td class="td3">广东省深圳市福田区深南大道大庆大厦</td>
            					<td class="td4">13045682375</td>
            				</tr>
            			</table>
            			<div class="tj">
            				<a href="javascript:;">添加新地址</a>
            			</div>
            			<span>支付方式：</span>
            			<div class="shop_zf">
            				<li class="on">
            					<i class="wx"></i>
            					<span>微信支付</span>
            					<p>Wechat Pay</p>
            				</li>
            				<li>
            					<i class="zfb"></i>
            					<span>支付宝</span>
            					<p class="lp1">ALIPAY</p>
            				</li>
            			</div>
            			<span>订单信息：</span>
            			<div class="shop_orders">
            				<dl class="head">
            					<dd class="d1">商品详情</dd>
            					<dd class="d2">数量</dd>
            					<dd>金额</dd>
            				</dl>
            				<ul>
            					<li>
            						<a class="d1" href="#">
            							<img src="img/pic14.jpg">
            							<b>文榜古树普洱（纯料生茶）10块装</b>
            						</a>
            						<p  class="d2">1</p>
            						<p>300</p>
            					</li>
            					<li>
            						<a class="d1" href="#">
            							<img src="img/pic14.jpg">
            							<b>文榜古树普洱（纯料生茶）10块装</b>
            						</a>
            						<p class="d2">1</p>
            						<p>300</p>
            					</li>
            				</ul>
            				<div class="bz">
            					备注：<input type="text" placeholder="您有什么想备注的呢？（限50字）" />
            				</div>
            			</div>
            			<div class="money">
            				<dl>
            					<dt>商品总额</dt>
            					<dd>￥300元</dd>
            				</dl>
            				<dl>
            					<dt>运费</dt>
            					<dd>￥10元</dd>
            				</dl>
            				<dl>
            					<dt class="fs1">支付金额</dt>
            					<dd class="fs1">￥310元</dd>
            				</dl>
            				<a href="javascript" class="money-zf">立即支付</a>
            			</div>
            		</div>
            	</div>
            </section>
			<div>
			<?php include dirname(__DIR__).'/layouts/footer.php'?> 
			</div>			
		</div>
		<!-- 主体内容 end  -->
	</body>
	<script src="https://cdn.jsdelivr.net/npm/vue"></script>
	<script type="text/javascript" src="/js/axios.min.js" ></script>
	<script type="text/javascript">
    	var goods = '<?=$goods?>';
    	console.log(goods[0].name);
	</script>