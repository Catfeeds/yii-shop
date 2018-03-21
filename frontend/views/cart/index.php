		<div class="container2" id="cartmain">
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
            			<span>全部商品：</span>
            			<div class="cart_orders">
            				<dl class="head">
            					<dd class="dd1"><input type="checkbox" id="" value="" /></dd>
            					<dd class="dd2">全选</dd>
            					<dd class="dd3">单价（元）</dd>
            					<dd class="dd4">数量</dd>
            					<dd class="dd5">小计（元）</dd>
            					<dd>操作</dd>
            				</dl>
            				<ul>
            					<li v-for="(item, index) in shopMessage">
            						<div for="" class="checkd dd1">
            							<input type="checkbox" id="price1" value="xj" />
            						</div>            						
            						<a class="dd2" class="d1" href="#">
            							<img :src="imgurl + item.image">
            							<b>{{item.name}}</b>
            						</a>
            						<p class="dd3">{{item.unitPrice}}</p>
            						<div id="" class="data_number dd4">
										<input @click="btnMinus(index)" class="" type="button" value="-" />
										<input class="sl" type="text" v-model="item.goods_num" />
										<input @click="btnAdd(index)" type="button" value="+" />
									</div>
									<label for="price1" class="dd5">{{ item.quantity * item.unitPrice }}</label>
									<p @click="deletes(index)" class="delete">删除</p>
            					</li>
            				</ul>
            				<div class="js">
	        					<button>删除选中</button>
	        					<div class="cart_zj">
	        						<p>总计：{{ zjPrice }}元</p>
	        						<a class="cart_js" href="javascript:;">立即结算</a>
	        					</div>
	        				</div>
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
				<span>确认删除此项？</span>
				<div class="linkShop">
					<a href="#">删除</a>
					<a @click="carQx2" href="javascript:;" class="al1">取消</a>
				</div>
			</div>
		</div>
		<!-- 主体内容 end  -->
	</body>
	<script src="https://cdn.jsdelivr.net/npm/vue"></script>
	<script type="text/javascript" src="/js/axios.min.js" ></script>
	<script type="text/javascript">
         var cartMain = new Vue({
         	el: '#cartmain',
         	data: {
				carShow:false,
				popupShow:false,
				message: []	
			},
			computed: {
				zjPrice: function() {
					var zjPrice = 0;
					for(var i in this.message){
						zjPrice += parseInt(this.message[i].goods_num * this.message[i].unitPrice);
					}
					return zjPrice;
				}
			},
			created: function(){
				$.ajax({
	                url: '/cart/getlist',
	                type: 'GET',
	                dataType: 'json',
	                data: '',
	                success: function(data) {
	                	if(data.status == 0){
	                		console.log('获取成功');
	                		this.message = data.data;
	                		console.log(this.message);
	                	}	                 	
	                }
	           })
			},
            methods: {
            	deletes: function(){           		
            		this.carShow = true;
            		this.popupShow = true;           		
            	},
            	carQx2: function(){
        			this.carShow = false;
    		        this.popupShow = false;
        		},
            	carQx: function(){
            		this.carShow = false;
            		this.popupShow = false;
            	},
            	carBg: function(){
            		this.carShow = false;
            		this.popupShow = false;
            	},
            	btnMinus: function(index) {
            		var _this = this;
            		_this.message[index].goods_num--;
            		if(_this.message[index].goods_num <= 0){
            			_this.message[index].goods_num = 1;
            		}
            	},           	
            	btnAdd: function(index) {
            		var _this = this;
            		_this.message[index].goods_num++;
            	},
            	deletes: function(index) {
            		var _this = this;
            		_this.message.splice(index, 1);
            		if(_this.message.length == 0){
            			window.location = 'http://www.baidu.com';
            		}
            	}
            }
         })
	</script>