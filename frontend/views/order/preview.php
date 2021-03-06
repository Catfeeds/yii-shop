		<div class="container2" id="shopData">
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
            			<h1>填写并核对订单信息</h1>
            			<span v-show="address1">收货信息：</span>
            			<table v-show="address1" border="0" cellspacing="0" cellpadding="0">
            				<tr class="tr1">
            					<th class="td1"></th>
            					<th class="td2">收件人姓名</th>
            					<th class="td3">详细地址</th>
            					<th class="td4">联系电话</th>
            				</tr>
            				<tr v-for="(addList, index) in addressData" class="tr2">
            					<td class="td1 tdct"><em @click="selectedProduct(index)" v-bind:class="{'check':index == currenIndex}" ><i></i></em></td>
            					<td class="td2">{{ addList.name }}</td>
            					<td class="td3">{{ addList.province }} {{ addList.city }} {{ addList.district }} {{ addList.detail }}</td>
            					<td class="td4">{{ addList.mobile }}</td>
            				</tr>
            			</table>
            			<div v-show="address1" class="tj">
            				<a @click="bjAddress" href="javascript:;">添加新地址</a>
            			</div>
                        <ul  v-show="address2" class="address_cont">
                        	<li>
                        		<div class="lis lis1">
                        			<h3>姓名：</h3>
                        			<input type="text" name="name" id="name" v-model="takeDelivery.name" placeholder="请输入您的姓名" />
                        		</div>
                        		<div class="lis">
                        			<h3 style="margin-left: 20px;">称谓：</h3>
                        			<select v-model="takeDelivery.sex" name="title" style="margin-left: 20px;">
                        				<option value="男">男</option>
                        				<option value="女">女</option>
                        			</select>
                        		</div>
                        	</li>
                        	<li>
                        		<div class="lis lis1">
                        			<h3>联系方式：</h3>
                        			<input @blur="mobile" type="text" name="tel" id="tel" v-model="takeDelivery.mobile" placeholder="请输入您的电话号码" />
                        		</div>
                        	</li>
                        	<li>
                        		<div class="lis">
                        			<h3>送货地址：</h3>
                        			<select class="lis1" name="title" v-model="takeDelivery.province">
                        				<option v-for="option in arr" :value="option.name">{{ option.name }}</option>
                        			</select>
                        			<select style="margin-left: 20px;" class="lis1" name="title" v-model="takeDelivery.city">
                        				<option v-for="option in cityArr" :value="option.name">{{ option.name }}</option>
                        			</select>
                        			<select style="margin-top: 20px;" class="lis1" name="title" v-model="takeDelivery.district">
                        				<option v-for="option in districtArr" :value="option.name">{{ option.name }}</option>
                        			</select>
                        		</div>
                        	</li>
                        	<li>
                        		<div class="lis lis2">
                        			<h3>详细地址：（请填写具体路名和门牌号）</h3>
                        			<input type="text" name="tel" id="tel" v-model="takeDelivery.detail" placeholder="请填写详细地址"/>
                        		</div>
                        	</li>
                        	<P v-show="messgs" class="messgDz">{{ messgDz }}</P>
                        	<a @click="bcAdd" href="javascript:;">保存地址</a>
                        </ul>
            			<span>订单信息：</span>
            			<div class="shop_orders">
            				<dl class="head">
            					<dd class="d1">商品详情</dd>
            					<dd class="d2">数量</dd>
            					<dd>总金额</dd>
            				</dl>
            				<ul>
            					<li v-for="goodLis in goodsData">
            						<div class="oli">
            						<a class="d1" :href="goodUrl + '?id=' + goodLis.goods_id">
            							<img :src="goodLis.goods_pic">
            							<b>{{ goodLis.goods_name }}</b>
            						</a>
            						<p  class="d2">{{ parseInt(goodLis.num) }}</p>
            						<p>{{goodLis.price}}</p>
            						</div>
            					</li>
            				</ul>
            				<div class="bz">
            					备注：<input v-model="message" type="text" placeholder="您有什么想备注的呢？（限50字）" />
            				</div>
            			</div>
            			<div class="money">
            				<dl>
            					<dt>商品总额</dt>
            					<dd>￥{{ total_price}}</dd>
            				</dl>
            				<dl>
            					<dt>运费</dt>
            					<dd>￥{{ express_price}}元</dd>
            				</dl>
            				<dl>
            					<dt class="fs1">支付金额</dt>
            					<dd class="fs1">￥{{total_price}}元</dd>
            				</dl>
            				<a @click="moneyZf" href="javascript:;" class="money-zf">立即支付</a>
            			</div>
            		</div>
            	</div>
            </section>
			<div>
			<?php include dirname(__DIR__).'/layouts/footer.php'?> 
			</div>
			<div v-show="carShow" @click="carBg" id="carBg" class="carBg"></div>
			<div v-show="addressShow" id="addressPopup" class="addressPopup">
				<i @click="carQx"></i>
				<span>编辑新地址</span>
                <ul class="address_cont">
                	<li>
                		<div class="lis lis1">
                			<h3>姓名：</h3>
                			<input type="text" name="name" id="name" v-model="takeDelivery.name" placeholder="请输入您的姓名" />
                		</div>
                		<div class="lis">
                			<h3 style="margin-left: 20px;">称谓：</h3>
                			<select v-model="takeDelivery.sex" name="title" style="margin-left: 20px;">
                				<option value="男">男</option>
                				<option value="女">女</option>
                			</select>
                		</div>
                	</li>
                	<li>
                		<div class="lis lis1">
                			<h3>联系方式：</h3>
                			<input @blur="mobile" type="text" name="tel" id="tel" v-model="takeDelivery.mobile" placeholder="请输入您的电话号码" />
                		</div>
                	</li>
                	<li>
                		<div class="lis">
                			<h3>送货地址：</h3>
                			<select class="lis1" name="title" v-model="takeDelivery.province">
                				<option v-for="option in arr" :value="option.name">{{ option.name }}</option>
                			</select>
                			<select style="margin-left: 20px;" class="lis1" name="title" v-model="takeDelivery.city">
                				<option v-for="option in cityArr" :value="option.name">{{ option.name }}</option>
                			</select>
                			<select style="margin-top: 20px;" class="lis1" name="title" v-model="takeDelivery.district">
                				<option v-for="option in districtArr" :value="option.name">{{ option.name }}</option>
                			</select>
                		</div>
                	</li>
                	<li>
                		<div class="lis lis2">
                			<h3>详细地址：（请填写具体路名和门牌号）</h3>
                			<input type="text" name="tel" id="tel" v-model="takeDelivery.detail" placeholder="请填写详细地址"/>
                		</div>
                	</li>
                	<P v-show="messgs" class="messgDz">{{ messgDz }}</P>
                	<a @click="bcAdd2" href="javascript:;">保存地址</a>
                </ul>
			</div>			
		</div>
		<!-- 主体内容 end  -->
	</body>
	<script src="https://cdn.jsdelivr.net/npm/vue"></script>
	<script type="text/javascript" src="/js/axios.min.js" ></script>
	<script type="text/javascript">
    	var cart_id_list = '<?=$cart_id_list?>';
	</script>
	<script type="text/javascript">
		Vue.filter('formatMoney', function(val){
		 	val = val.toString().replace(/\$|\,/g,'');
		    if(isNaN(val)) {
		      val = "0";  
		    } 
		    let sign = (val == (val = Math.abs(val)));
		    val = Math.floor(val*100+0.50000000001);
		    let cents = val%100;
		    val = Math.floor(val/100).toString();
		    if(cents<10) {
		       cents = "0" + cents
		    }
		    for (var i = 0; i < Math.floor((val.length-(1+i))/3); i++) {
		        val = val.substring(0,val.length-(4*i+3))+',' + val.substring(val.length-(4*i+3));
		    }
		
		    return (((sign)?'':'-') + val + '.' + cents);
		})
        var shop = new Vue({
       	    el:'#shopData',
       	    data: {
       	    	carShow: false, 
       	    	addressShow: false, //弹窗
       	    	address1: true,
       	    	address2: false,
       	    	arr: arrAll,
       	    	cityArr: [],
                districtArr: [],
                messgDz: '',
                messgs: false,
                takeDelivery: {
                    name: '',   //姓名
                    sex: '男',
                    mobile: '',  //电话
                    province: '选择省份', //省
                    city: '选择市',  //市
                    district: '选择区',  //县
                    detail: '', //具体地址
                    id :0
                },
                addressData: [],
                goodsData: [],
                total_price: 0, //总价
                express_price: 10,  //邮费                
                addressId: '',  // 传给后端地址ID
                currenIndex:0,  // 默认index
                message: '',
                goodUrl: goodsUrl
       	    },
       	    $nextTick: function(){
       	    	this.disNone();      	    	      	    	       	    	
       	    },
       	    methods: {
       	    	//获取数据
       	    	dressData: function(){
       	    		var _this = this;
	       	    	$.ajax({
	       	    		type:"get",
	       	    		url:"/address/getlist",
	       	    		async:true,
	       	    		success: function(data) {
			                if(data.status == 0){		                   
			                    _this.addressData = data.data;		                    		                    
			                    _this.disNone();
								_this.infor();               
			                }	                 	
			            }
	       	    	});	
       	    	},
		        //判断是否有地址数据
       	    	disNone: function(){
       	    		if(this.addressData.length != 0){
	       	    		this.address1 = true;
	       	    		this.address2 = false;
	       	    	}else{
	       	    		this.address1 = false;
	       	    		this.address2 = true;
		       	    } 
       	    	},
       	    	//验证手机号码
       	    	mobile: function(){
       	    		var telreg = /^(((13[0-9]{1})|(15[0-9]{1})|(18[0-9]{1}))+\d{8})$/; 
					if(this.takeDelivery.mobile == ''){
						this.messgDz = "手机号不能为空";
						this.messgs = true;
						return false;
					}else if(!telreg.test($('#tel').val())){
						this.messgDz = "请输入有效号码";
						this.messgs = true;
						return false;
					}else {
						this.messgDz = '';
						this.messgs = false;
					}
       	    	},
       	    	// 添加新地址弹窗
       	    	bjAddress: function(){
       	    		this.carShow = true;
       	    	    this.addressShow = true;
       	    	},
       	    	// 关闭新地址弹窗
       	    	carBg: function(){
       	    		this.carShow = false;
       	    	    this.addressShow = false;
       	    	},
       	    	carQx:function(){
       	    		this.carShow = false;
       	    	    this.addressShow = false;
       	    	},
       	    	//省市
                updateCity: function () {
					for (var i in this.arr) {
						var obj = this.arr[i];
						if (obj.name == this.takeDelivery.province) {
							this.cityArr = obj.sub;
							break;
						}
					}
					if(this.cityArr && this.cityArr.length > 1 && this.cityArr[1].name) {
						this.takeDelivery.city = this.cityArr[1].name;
					} else {
						this.takeDelivery.city = this.cityArr[0].name;
					}    
					
				},
				updateDistrict: function () {
					for (var i in this.cityArr) {
						var obj = this.cityArr[i];
						if (obj.name == this.takeDelivery.city) {
							this.districtArr = obj.sub;
							break;
						}
					}
					if(this.districtArr && this.districtArr.length > 1 && this.districtArr[1].name) {
						this.takeDelivery.district = this.districtArr[1].name;
					} else {
						this.takeDelivery.district = '';
					}
				},
				//保存地址
				bcAdd: function(){
					var _this = this;
					if(this.takeDelivery.name == '' || this.takeDelivery.sex == '' || this.takeDelivery.detail == ''){
                		this.messgDz = "地址信息填写有误";
				        this.messgs = true;
				        return false;
	               }else{					    
	                	$.ajax({
				            url:'/address/add',
				            type: 'POST',
				            dataType: 'json',
				            data: this.takeDelivery,
				            success: function(data) {
				                if(data.status == 0){
				                    this.messgDz = "";
								    this.messgs = false;
								    _this.takeDelivery.id = data.id;
								    _this.addressId = data.id;
								    _this.addressData.push(_this.takeDelivery);
								    _this.$nextTick( function(){
				                    	_this.dressData();
				                    });
								    _this.address1 = true;
			       	    		    _this.address2 = false; 			                    
				                }	                 	
				            }
				        })
		            }    						
				},
				
				//添加新地址保存
				bcAdd2: function(){
					var _this = this;
					if(this.takeDelivery.name == '' || this.takeDelivery.sex == '' || this.takeDelivery.detail == ''){
                		this.messgDz = "地址信息填写有误";
				        this.messgs = true;
				        return false;
	                }else{
	                					    
	                	$.ajax({
				            url:'/address/add',
				            type: 'POST',
				            dataType: 'json',
				            data: this.takeDelivery,
				            success: function(data) {
				                if(data.status == 0){
				                    this.messgDz = "";
								    this.messgs = false;
								    _this.takeDelivery.id = data.id;
								    _this.addressId = data.id;
								    _this.addressData.push(_this.takeDelivery);	
				                    _this.carShow = false;
       	    	                    _this.addressShow = false;			                    
				                }	                 	
				            }
				        })
		            }    						
				},
				//单选地址
				selectedProduct:function (index) { // 接收的参数
					var _this = this;
					this.currenIndex = index;
					_this.$nextTick( function(){
                    	_this.infor();
                    });
		        },
		        infor: function(){
		        	var _this = this;
		        	_this.addressData.forEach(function(item,index){
		        		if(_this.currenIndex == index){
			        		_this.addressId = item.id;
			        		console.log(_this.addressId)
			        	}
		        	})
		        },
		        moneyZf: function(){
		        	var _this = this;
		        	var linkUrl;
		        	$.ajax({
			            url:'/order/submit',
			            type: 'POST',
			            dataType: 'json',
			            data: {address_id: _this.addressId, message: _this.message,cart_id_list:cart_id_list},
			            success: function(data) {
			                if(data.status == 0){
			                    linkUrl = data.return_url;
			                    window.location = linkUrl;
			                }else{
								alert(data.msg);
				            }	                 	
			            }
			        })
		        } ,
		        getData : function(){
			        var _this = this;
	       	    	$.ajax({
	       	    		type:"get",
	       	    		url:"/order/submit-preview?cart_id_list="+cart_id_list,
	       	    		async:true,
	       	    		success: function(data) {
			                if(data.status == 0){		                   
								_this.goodsData = data.data.list; 
								_this.total_price = data.data.total_price;
								_this.express_price = data.data.express_price;            
			                }	                	
			            }
	       	    	});	
	           	},
       	    },
       	   
       	    beforeMount: function () {
				this.updateCity();
				this.updateDistrict();				
			},
			computed: {
				province: function(){
					return this.takeDelivery.province;
				},
				city: function() {
					return this.takeDelivery.city;
				},				
			},
			watch: {
				province: function () {
					this.updateCity();
					this.updateDistrict();
				},
				city: function () {
					this.updateDistrict();
				}
			},
			mounted :function(){
				this.dressData();     	    	 
       	    	this.infor(); 	
       	    	this.getData();
			}
        })
	</script>