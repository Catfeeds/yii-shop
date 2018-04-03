		<div class="container2" id="orderList">
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
            			<span>订单信息：</span>
            			<div class="shop_orders">
            				<dl class="head">
            					<dd class="od1">商品详情</dd>
            					<dd class="od2">数量</dd>
            					<dd class="od3">收货人</dd>
            					<dd class="od4">总金额</dd>
            					<dd class="od5">订单状态</dd>
            					<dd>操作</dd>
            				</dl>
            				<ul>
            					<li>
            						<div class="list_i od1">
	            						<a class="order_list" href="#">
	            							<img src="/img/pic14.jpg">
	            							<b>文榜古树普洱（纯料生茶）10块装</b>
	            							<p class="od2">1</p>
	            						</a>
	            						<a class="order_list" href="#">
	            							<img src="/img/pic14.jpg">
	            							<b>文榜古树普洱（纯料生茶）10块装</b>
	            							<p class="od2">1</p>
	            						</a>
	            					</div>
	            						<p class="od3">李美丽</p>
	            						<p class="od4">￥300</p>
	            						<p class="od5">待支付</p>
	            						<div class="btn_cz">
	            							<button class="orders_qx">取消订单</button>
	            							<button class="orders_zf">立即支付</button>
	            							<button class="orders_zf">物流跟踪</button>
	            						</div>
            						
            					</li>
            				</ul>
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
		new Vue({
         	el: '#orderList',
         	data: {
         		ListData: []
         	},
         	created: function(){
         		let _this = this;
         		_this.orderList();
         	},
            methods: {
                orderList: function(){
                	let _this = this;
                	$.ajax({
                		type:"POST",
                		url:"/order/orderlist",
                		dataType: 'json',
                		data:'',
                		success: function(data){
                			if(data.status == 0){
                				console.log('数据获取成功');
                				_this.ListData = data.data;
                			}
                		}
                	});
                }
            }
         })
	</script>