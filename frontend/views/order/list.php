		<div class="container2" id="orderList">
            <section class="laber_shopUser">
            	<div class="shopUser auto clearfix">
            		<div class="shopUser_main">
            			<ul>
            				<li><a href="/user/updatepassword">密码管理</a></li>
            				<li><a href="/cart/index">购物车</a></li>
            				<li><a href="/address/index">收货地址</a></li>
            				<li class="on"><a href="/order/list">我的订单</a></li>
            			</ul>
            		</div>
            	</div>
            </section>
            <section class="laber_shop">
            	<div class="shop auto clearfix">
            		<div class="shop_main">
            			<div v-show="noneCar" class="noneCar">
            				<img src="/img/kong.png"/>
            				<p>您还没有任何订单，赶快去商城逛逛吧...</p>
            				<div class="goshop">
            					<a class="aShop" href="/goods/list">前往商城</a>
            				</div>            				
            			</div>
            			<span v-show="shopOrders">订单信息：</span>
            			<div v-show="shopOrders" class="shop_orders">
            				<dl class="head">
            					<dd class="od1">商品详情</dd>
            					<dd class="od2">数量</dd>
            					<dd class="od3">收货人</dd>
            					<dd class="od4">总金额</dd>
            					<dd class="od5">订单状态</dd>
            					<dd>操作</dd>
            				</dl>
            				<ul>
            					<li v-for="(list, index) in ListData">
            						<div class="orderNumber">
            							<p>订单编号：{{ list.order_no }}</p>
            						</div>
            						<div class="oli">
            						<div class="list_i od1" :class="{'lisBorder': list.goods_list.length > 1}">
	            						<a v-for="item in list.goods_list" class="order_list" :href="goodUrl + '?id=' + item.goods_id">
	            							<img :src="item.goods_pic">
	            							<b>{{ item.goods_name }}</b>
	            							<p class="od2">{{ item.num }}</p>
	            						</a>
	            					</div>
	            						<p class="od3">{{ list.name }}</p>
	            						<p class="od4">{{ list.pay_price }}</p>
	            						<p v-show="list.order_status == 1" class="od5">未付款</p>
	            						<p v-show="list.order_status == 2" class="od5">待发货</p>
	            						<p v-show="list.order_status == 3" class="od5">待收货</p>
	            						<p v-show="list.order_status == 4" class="od5">订单关闭</p>
	            						<p v-show="list.order_status == 5" class="od5">交易成功</p>
	            						<div class="btn_cz">
	            							<button @click="orders_qx(list)" type="button" v-show="list.order_status == 1" class="orders_qx">取消订单</button>
	            							<button @click="orders_zf(list)" type="button" v-show="list.order_status == 1" class="orders_zf">立即支付</button>
	            							<button @click="orders_qr(list)" type="button" v-show="list.order_status == 3" class="orders_zf">确认收货</button>
	            							<button @click="orders_gz(list)" type="button" v-show="list.order_status == 3" class="orders_zf">物流跟踪</button>
	            							<em v-show="list.order_status == 5" class="orders_zf">交易完成</em>
	            						</div>
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
			<div v-show="carShow" @click="carBg" id="carBg" class="carBg"></div>
			<div v-show="popupShow" id="carPopup" class="carPopup">
				<i @click="carQx"></i>
				<span>{{messageText}}</span>
				<div class="linkShop">
					<a v-if="show1" @click="carSc" id='0' href="javascript:;">确定</a>
					<a v-else="show2" @click="orderTrue" id='1' href="javascript:;">确定</a>
					<a @click="carQx2" href="javascript:;" class="al1">取消</a>
				</div>
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
         		carShow: false,
         		popupShow: false,
         		show1: true,
         		noneCar: true,
         		shopOrders: false,
         		ListData: [],
         		goodList: [],
         		statusNum: 0,
         		imgUrl: imgurl,
         		goodUrl: goodsUrl,
         		messageText: '',
         		id: '',
         		newUrl: ''
         	},
         	created: function(){
         		let _this = this;
         		_this.orderList();
         	},
            methods: {
                orderList: function(){
                	let _this = this;
                	var goodList;
                	$.ajax({
                		type:"POST",
                		url:"/order/orderlist",
                		dataType: 'json',
                		data:'',
                		success: function(data){
                			if(data.status == 0){
                				_this.ListData = data.data;            				
                				if(_this.ListData.length != 0){
                					_this.shopOrders = true;
                					_this.noneCar = false;
                				}else{
                					_this.shopOrders = false;
                					_this.noneCar = true;
                				}            				
                			}else{
                				alert('订单信息有误');
                			}
                		}
                	});
                },                
                //立即支付
                orders_zf: function(list){
                	window.location = '/pay/index?id=' + list.order_sn;
                },
                //取消订单
                orders_qx: function(item){
                	let _this = this;
                	_this.carShow = true;
         		    _this.popupShow = true;
         		    _this.messageText = '确定取消订单？'
         		    _this.show1 = true;
                	_this.id = item.order_no;
                	
                },
//              orders_gz: function(item){
//              	window.location.href = '/order/trace?id=' + item.order_sn;
//              },
                //物流
                orders_gz: function(item){
                	let _this = this;
                	var urlLogistics = null;
                	var wd = window.open();
                	$.ajax({
                		type:"GET",
                		url:"/order/gettrace",
                		dataType: 'json',
                		data:{id:item.order_sn},
                		success: function(data){
                			if(data.status == 0){
       				             urlLogistics = data.url;
       				             wd.location.href = urlLogistics;
                			}else{
                				alert('物流信息有误');
                			}
                		}
                	});
                	
                },
                //确认收货
                orders_qr: function(item){
                	let _this = this;             	
                	_this.carShow = true;
	                _this.popupShow = true;
	                _this.messageText = '您要确认收货吗？'
	                _this.show1 = false;
                	_this.id = item.order_sn;
                },
                orderTrue: function(){
                	let _this = this;
                	$.ajax({
                		type:"GET",
                		url:"/order/receive",
                		dataType: 'json',
                		data:{id:_this.id},
                		success: function(data){
                			if(data.status == 0){
       				            _this.carShow = false;
			         		    _this.popupShow = false;
			         		    _this.$nextTick( function(){
			                    	_this.orderList();
			                    });
                			}else{
                				alert('确认收货失败');
                			}
                		}
                	});               	
                },
                //确定删除订单
                carSc: function(){
                	let _this = this;
                	$.ajax({
                		type:"GET",
                		url:"/order/revoke",
                		dataType: 'json',
                		data: {order_no:_this.id},
                		success: function(data){
                			if(data.status == 0){
                				_this.carShow = false;
         		                _this.popupShow = false;
                				_this.$nextTick( function(){
			                    	_this.orderList();
			                    });
                			}else{
                				alert('取消失败');
                			}
                		}
                	});
                },
                //取消删除
                carQx2: function(){
                	let _this = this;
                	_this.carShow = false;
         		    _this.popupShow = false;
                },
                carQx: function(){
                	let _this = this;
                	_this.carShow = false;
         		    _this.popupShow = false;
                }
            }
         })
	</script>