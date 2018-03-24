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
            			<div v-show="noneCar" class="noneCar">
            				<img src="/img/kong.png"/>
            				<p>您还没有添加任何商品，快去逛逛吧</p>
            				<div class="goshop">
            					<a class="aShop" href="/goods/list">前往商城</a>
            				</div>            				
            			</div>
            			<span v-show="sp">全部商品：</span>
            			<div v-show="cartOrders" class="cart_orders">
            				<dl class="head">
            					<dd class="dd1"><em @click="allCheck(true)" :class="{'check': checkAllFlag}">
            						<i></i>
            					</em></dd>
            					<dd class="dd2">全选</dd>
            					<dd class="dd3">单价（元）</dd>
            					<dd class="dd4">数量</dd>
            					<dd class="dd5">小计（元）</dd>
            					<dd>操作</dd>
            				</dl>
            				<ul>
            					<li v-for="(item, index) in message">
            						<div for="" class="checkd dd1">
            							<em @click="selectedProduct(item)" v-bind:class="{'check':item.checked}">
            								<i></i>
            							</em>
            						</div>            						
            						<a class="dd2" class="d1" :href="item.shopUrl">
            							<img :src="imgurl + item.image">
            							<b>{{item.name}}</b>
            						</a>
            						<p class="dd3">{{item.shop_price}}</p>
            						<div id="" class="data_number dd4">
										<input @click="btnMinus(index)" class="" type="button" value="-" />
										<input class="sl" type="text" v-model="item.goods_num" />
										<input @click="btnAdd(index)" type="button" value="+" />
									</div>
									<label for="price1" class="dd5">{{ item.goods_num * item.shop_price }}</label>
									<p @click="deletes(item)" class="delete">删除</p>
            					</li>
            				</ul>
            				<div class="js">
	        					<div class="cart_zj">
	        						<p>总计：{{ zjPrice }}元</p>
	        						<a @click="cart_js" class="cart_js" href="javascript:;">立即结算</a>
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
					<a @click="carSc" href="javascript:;">确定</a>
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
				noneCar:false,
				sp:true,
				cartOrders:true,
				checkAllFlag: false, //定义是否全选
				zjPrice: 0,  //总金额
				curProduct: '', //保存删除的商品
				message: [],
				zjPrice: 0,
				id: '',
				shopUrl: '',
				dataForm: [
				   {
				   	goods_id:'',
				   	goods_num: '',
				   	id: ''
				   }
				]	
			},
			created: function(){
				var _this = this;
				var goodId;
				$.ajax({
	                url: '/cart/getlist',
	                type: 'GET',
	                dataType: 'json',
	                data: '',
	                success: function(data) {
	                	if(data.status == 0){
	                		console.log('获取成功');
	                		_this.message = data.data;
	                		console.log(_this.message);
	                		if(_this.message.length != ''){
								_this.sp = true;
							    _this.cartOrders = true;
							    _this.noneCar = false;
							}else{
								_this.sp = false;
							    _this.cartOrders = false;
							    _this.noneCar = true;
							}
							for(var i in  _this.message){
								goodId = _this.message[i].goods_id;
								_this.message[i].shopUrl = goodsUrl + '?id=' + goodId;
							}						
	                	}          	
	                }
	            })
					           
			},
            methods: {
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
            		_this.caleTotalPrice();
            	},            	
            	btnAdd: function(index) {
            		var _this = this;
            		_this.message[index].goods_num++;
            		_this.caleTotalPrice();
            	},
            	deletes: function(item) {
            		this.carShow = true;
				    this.popupShow = true;
				    this.curProduct = item;
				    this.id = item.id.$oid;
				    console.log(this.id);
            	},
            	carSc: function(){
            		// 通过indexof 来搜索当前选中的商品 找到索引 index
            		var _this = this;
            		var index = _this.message.indexOf(_this.curProduct);
            		$.ajax({
            			type:"POST",
            			url:"/cart/remove",
            			dataType: 'json',
	                    data: {id: _this.id},
	                    success: function(data){
	                    	if(data.status == 0){
	                    		console.log('成功');
		            // 获取索引 后删除元素 splice(index，1) 两个参数  第一个参数索引 第二个参数 删除个数
					            _this.message.splice(index ,1);// 从当前索引开始删，删除一个元素
					            _this.carShow = false;
							    _this.popupShow = false; // 删除后 弹框消失
							    if(_this.message.length != ''){
									_this.sp = true;
								    _this.cartOrders = true;
								    _this.noneCar = false;
								}else{
									_this.sp = false;
								    _this.cartOrders = false;
								    _this.noneCar = true;
								}
	                    	}else{
	                    		console.log('失败');
	                    	}
	                    }
            		});
            	},
            	cart_js: function(){
            		var _this = this;
            		_this.message.forEach(function (item,index){
                		if(item.checked){
                			_this.dataForm.goods_id = item.id.$oid; //商品ID
//              			_this.dataForm[index].id = item.goods_id; //购物车ID 
//              			_this.dataForm[index].goods_num = item.goods_num;
//              			console.log(_this.dataForm[index].goods_id);
                		}
                	}
            		$.ajax({
            			type:"POST",
            			url:" /order/confirm",
            			dataType: 'json',
	                    data: dataForm,
	                    success: function(data){

	                    }
            		});
            	},
            	//如何让Vue 监听一个不存在的变量 单选操作
            	selectedProduct:function (item) { // 接收的参数
		            if( typeof item.checked == 'undefined'){ 
		                Vue.set(item,"checked",true);
		            }else {
		                item.checked = !item.checked;
		                this.checkAllFlag = false ;
		            }
		            this.caleTotalPrice();
		        },
		        //全选
		        allCheck:function (flag) {
		        	var _this = this;
		        	if(_this.checkAllFlag == false){
		        		_this.checkAllFlag = flag ;
			            _this.message.forEach(function (item,index) { // 用forEach来遍历 message
			                if(typeof item.checked == 'undefined'){ // 先判断 是否有这个 item.checked
			                    Vue.set(item,"checked", _this.checkAllFlag);  // 没有 先注
			                }else {
			                    item.checked = _this.checkAllFlag;
			                    
			                }
			            });
		        	}else if(_this.checkAllFlag == true){
		        		_this.checkAllFlag = false;
			            _this.message.forEach(function (item,index) { 
			                    item.checked = _this.checkAllFlag;
			            });
		        	}
		           
		            this.caleTotalPrice();
		        },
		        //选中商品总价
		        caleTotalPrice:function () {
		            var _this = this;
		            this.zjPrice = 0;
		            this.message.forEach(function (item,index) {
		               if(item.checked){
		                   _this.zjPrice += item.shop_price * item.goods_num;
		               }
		            });
		        }
            }
         })
	</script>