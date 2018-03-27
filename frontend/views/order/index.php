		<div class="container2" id="shopData">
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
            			<span v-show="address1">收货信息：</span>
            			<table v-show="address1" border="0" cellspacing="0" cellpadding="0">
            				<tr class="tr1">
            					<th class="td1"></th>
            					<th class="td2">收件人姓名</th>
            					<th class="td3">详细地址</th>
            					<th class="td4">联系电话</th>
            				</tr>
            				<tr v-for="addList in addressData" class="tr2">
            					<td class="td1 tdct"><em @click="selectedProduct(addList)" v-bind:class="{'check':addList.checked}" ><i></i></em></td>
            					<td class="td2">{{ addList.consignee }}</td>
            					<td class="td3">{{ addList.province }} {{ addList.city }} {{ addList.district }} {{ addList.address }}</td>
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
                        			<input type="text" name="name" id="name" v-model="takeDelivery.consignee" placeholder="请输入您的姓名" />
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
                        			<input type="text" name="tel" id="tel" v-model="takeDelivery.address" placeholder="请填写详细地址"/>
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
            						<a class="d1" href="#">
            							<img :src="imgurl + goodLis.image[0]">
            							<b>{{ goodLis.name }}</b>
            						</a>
            						<p  class="d2">{{ parseInt(goodLis.goods_num) }}</p>
            						<p>{{ parseInt(goodLis.goods_num) * goodLis.shop_price }}</p>
            					</li>
            				</ul>
            				<div class="bz">
            					备注：<input type="text" placeholder="您有什么想备注的呢？（限50字）" />
            				</div>
            			</div>
            			<div class="money">
            				<dl>
            					<dt>商品总额</dt>
            					<dd>￥{{ zjMoney }}</dd>
            				</dl>
            				<dl>
            					<dt>运费</dt>
            					<dd>￥{{ yfMoney}}元</dd>
            				</dl>
            				<dl>
            					<dt class="fs1">支付金额</dt>
            					<dd class="fs1">￥{{ yfMoney + zjMoney }}元</dd>
            				</dl>
            				<a href="javascript" class="money-zf">立即支付</a>
            			</div>
            		</div>
            	</div>
            </section>
			<div>
			<?php include dirname(__DIR__).'/layouts/footer.php'?> 
			</div>
			<div v-show="carShow" @click="carBg" id="carBg" class="carBg"></div>
			<div v-show="addressShow" id="addressPopup" class="addressPopup">
				<span>编辑新地址</span>
                <ul class="address_cont">
                	<li>
                		<div class="lis lis1">
                			<h3>姓名：</h3>
                			<input type="text" name="name" id="name" v-model="takeDelivery.consignee" placeholder="请输入您的姓名" />
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
                			<input type="text" name="tel" id="tel" v-model="takeDelivery.address" placeholder="请填写详细地址"/>
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
    	var goods = '<?=$goods?>';
    	var goods = JSON.parse(goods);
    	console.log(goods);
	</script>
	<script type="text/javascript">
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
                    consignee: '',   //姓名
                    sex: '男',
                    mobile: '',  //电话
                    province: '选择省份', //省
                    city: '选择市',  //市
                    district: '选择区',  //县
                    address: '' //具体地址
                },
                addressData: [],
                goodsData: goods,
                zjMoney: 0, //总价
                yfMoney: 10
       	    },
       	    created: function(){
       	    	var _this = this;
       	    	$.ajax({
       	    		type:"get",
       	    		url:"/address/getlist",
       	    		async:true,
       	    		success: function(data) {
		                if(data.status == 0){
		                    console.log('数据获取成功');		                   
		                    _this.addressData = data.data;
		                    console.log(_this.addressData);	                  
		                }	                 	
		            }
       	    	});
       	    	_this.caleTotalPrice();   	    		    	
       	    },
       	    $nextTick: function(){
       	    	this.disNone();      	    	
       	    },
       	    methods: {
       	    	//总价
       	    	caleTotalPrice:function () {
		            var _this = this;
		            var zjPrice = 0;
		            _this.goodsData.forEach(function (item,index) {
		                   zjPrice += parseInt(item.goods_num) * item.shop_price;
		            });
		            _this.zjMoney = zjPrice;
		        },
       	    	disNone: function(){
       	    		if(this.addressData.length != ''){
	       	    		this.address1 = true;
	       	    		this.address2 = false;
	       	    	}else{
	       	    		this.address1 = false;
	       	    		this.address2 = true;
		       	    } 
       	    	},
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
       	    	bjAddress: function(){
       	    		this.carShow = true;
       	    	    this.addressShow = true;
       	    	},
       	    	carBg: function(){
       	    		this.carShow = false;
       	    	    this.addressShow = false;
       	    	},
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
					    console.log(this.takeDelivery.city)
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
					if(this.takeDelivery.consignee == '' || this.takeDelivery.sex == '' || this.takeDelivery.address == ''){
                		this.messgDz = "地址信息填写有误";
				        this.messgs = true;
				        return false;
	                }else{
	                	this.messgDz = "";
					    this.messgs = false;
					    this.addressData.push(this.takeDelivery);
					    this.address1 = true;
       	    		    this.address2 = false;					    
	                	$.ajax({
				            url:'/address/add',
				            type: 'POST',
				            dataType: 'json',
				            data: this.takeDelivery,
				            success: function(data) {
				                if(data.status == 0){
				                    console.log('提交成功');				                    
				                }	                 	
				            }
				        })
		            }    						
				},
				
				//添加新地址
				bcAdd2: function(){
					var _this = this;
					if(this.takeDelivery.consignee == '' || this.takeDelivery.sex == '' || this.takeDelivery.address == ''){
                		this.messgDz = "地址信息填写有误";
				        this.messgs = true;
				        return false;
	                }else{
	                	this.messgDz = "";
					    this.messgs = false;
					    this.addressData.push(this.takeDelivery);					    
	                	$.ajax({
				            url:'/address/add',
				            type: 'POST',
				            dataType: 'json',
				            data: this.takeDelivery,
				            success: function(data) {
				                if(data.status == 0){
				                    console.log('提交成功');	
				                    _this.carShow = false;
       	    	                    _this.addressShow = false;			                    
				                }	                 	
				            }
				        })
		            }    						
				},
				selectedProduct:function (addList) { // 接收的参数
		            if( typeof addList.checked == 'undefined'){ 
		                Vue.set(addList,"checked",true);
		            }else {
		                addList.checked = !addList.checked;
		            }
		        }
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
			}
        })
	</script>