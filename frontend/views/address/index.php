		<!-- 导航 end -->
		<!-- 主体内容 start  -->
		<div class="container2" id="addressList">
            <section class="laber_shopUser">
            	<div class="shopUser auto clearfix">
            		<div class="shopUser_main">
            			<ul>
            				<li><a href="/user/updatepassword">密码管理</a></li>
            				<li><a href="/cart/index">购物车</a></li>
            				<li class="on"><a href="/address/index">收货地址</a></li>
            				<li><a href="/order/list">我的订单</a></li>
            			</ul>
            		</div>
            	</div>
            </section>
            <section class="laber_shop">
            	<div class="shop auto clearfix">
            		<div class="shop_main" style="margin-bottom: 466px;">
            			<div v-show="noneCar" class="noneCar">
            				<img src="/img/kong.png"/>
            				<p>您还没有添加任何地址，快去添加吧</p>
            				<div class="goshop">
            					<a @click="bjAddress" class="aShop" href="javascript:;">添加地址</a>
            				</div>            				
            			</div>
            			<span v-show="sp">收货地址：</span>
            			<table  v-show="cartOrders" border="0" cellspacing="0" cellpadding="0">
            				<tr class="tr1">
            					<th style="padding-left:20px; width:262px;" class="td2">收件人姓名</th>
            					<th style="width: 562px;" class="td3">详细地址</th>
            					<th style="width: 232px;" class="td4">联系电话</th>
            					<th class="td4">操作</th>
            				</tr>
            				<tr v-for="(addList, index) in addressData" class="tr2">
            					<td  style="padding-left:20px; width:262px;" class="td2">{{ addList.consignee }}</td>
            					<td style="width: 562px;" class="td3">{{ addList.province }} {{ addList.city }} {{ addList.district }} {{ addList.address }}</td>
            					<td style="width: 232px;" class="td4">{{ addList.mobile }}</td>
            					<td class="td4"><p @click="editAddres(addList)">编辑</p><p @click="addressSc(addList)">删除</p></td>
            				</tr>
            			</table>
            			<div v-show="cartOrders" class="tj">
            				<a @click="bjAddress" href="javascript:;">添加新地址</a>
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
				<span>确认删除此地址？</span>
				<div class="linkShop">
					<a @click="carSc" href="javascript:;">确定</a>
					<a @click="carQx2" href="javascript:;" class="al1">取消</a>
				</div>
			</div>
			<div v-show="addressShow" id="addressPopup" class="addressPopup">
				<i @click="carQx"></i>
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
			
			<!--编辑地址-->
			<div v-show="addressShow2" id="addressPopup" class="addressPopup">
				<i @click="carQx"></i>
				<span>编辑地址</span>
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
        var shop = new Vue({
       	    el: '#addressList',
       	    data: {
       	    	carShow: false, 
       	    	popupShow:false,
       	    	addressShow: false, //弹窗
       	    	addressShow2: false,
       	    	noneCar:true,
				sp:true,
				cartOrders:true,
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
                    address: '',//具体地址#
                    id: 0 
                },
                addressData:[],
                curAddress: '',  //保存要删除地址
                id: '' //删除的地址ID
       	    },
       	    created: function(){
       	    	this.dressData();  		    	
       	    },
       	    methods: {
//     	    	disNone: function(){
//     	    		if(this.addressData.length != 0){
//	       	    		this.address1 = true;
//	       	    		this.address2 = false;
//	       	    	}else{
//	       	    		this.address1 = false;
//	       	    		this.address2 = true;
//		       	    } 
//     	    	},
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
			                    console.log(_this.addressData)		                    
			                    if(_this.addressData.length != 0){
									_this.sp = true;
								    _this.cartOrders = true;
								    _this.noneCar = false;
								}else{
									_this.sp = false;
								    _this.cartOrders = false;
								    _this.noneCar = true;
								}               
			                }	                 	
			            }
	       	    	});	
       	    	},
       	    	//添加新地址
       	    	bjAddress: function(){
       	    		this.carShow = true;
       	    	    this.addressShow = true;
       	    	},
       	    	// 关闭新地址弹窗
       	    	carBg: function(){
       	    		this.carShow = false;
       	    	    this.addressShow = false;
       	    	    this.popupShow = false;
       	    	},
       	    	carQx:function(){
       	    		this.carShow = false;
       	    	    this.addressShow = false;
       	    	    this.popupShow = false;
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
				bcAdd2: function(){
					var _this = this;
					if(this.takeDelivery.consignee == '' || this.takeDelivery.sex == '' || this.takeDelivery.address == ''){
                		this.messgDz = "地址信息填写有误";
				        this.messgs = true;
				        return false;
	                }else{
	                	this.messgDz = "";
					    this.messgs = false;					   				    					    
	                	$.ajax({
				            url:'/address/add',
				            type: 'POST',
				            dataType: 'json',
				            data: this.takeDelivery,
				            success: function(data) {
				                if(data.status == 0){
				                    let add = {
				                    	consignee: _this.takeDelivery.consignee,   //姓名
					                    sex: _this.takeDelivery.sex,
					                    mobile: _this.takeDelivery.mobile,  //电话
					                    province: _this.takeDelivery.province, //省
					                    city: _this.takeDelivery.city,  //市
					                    district: _this.takeDelivery.district,  //县
					                    address: _this.takeDelivery.address,//具体地址#
					                    id: 0
				                    }
				                    _this.addressData.push(add);
				                    _this.$nextTick( function(){
				                    	_this.dressData();
				                    });
				                    _this.takeDelivery.consignee = '';
				                    _this.takeDelivery.sex = '男';
				                    _this.takeDelivery.mobile = '';
				                    _this.takeDelivery.province = '选择省份';
				                    _this.takeDelivery.city = '选择市';
				                    _this.takeDelivery.district = '选择区';
				                    _this.takeDelivery.address = '';
				                    _this.takeDelivery.id = 0;
				                    _this.carShow = false;
       	    	                    _this.addressShow = false;			                    
				                }	                 	
				            }
				        })
		            }    						
				},
				addressSc: function(addList){
					this.carShow = true;
				    this.popupShow = true;
				    this.curAddress = addList;
				    this.id = addList.id;
				},
				carSc: function(){
					var _this = this;
            		var index = _this.addressData.indexOf(_this.curAddress);
            		$.ajax({
            			type:"get",
            			url:"/address/delete",
            			dataType: 'json',
	                    data: {id: _this.id},
	                    success: function(data){
	                    	if(data.status == 0){
		            // 获取索引 后删除元素 splice(index，1) 两个参数  第一个参数索引 第二个参数 删除个数
					            _this.addressData.splice(index ,1);// 从当前索引开始删，删除一个元素
					            _this.carShow = false;
							    _this.popupShow = false; // 删除后 弹框消失
							    if(_this.addressData.length != 0){
									_this.sp = true;
								    _this.cartOrders = true;
								    _this.noneCar = false;
								}else{
									_this.sp = false;
								    _this.cartOrders = false;
								    _this.noneCar = true;
								}
	                    	}else{
	                    		alert('失败');
	                    	}
	                    }
            		});
 
				},
				carQx2: function(){
        			this.carShow = false;
    		        this.popupShow = false;
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
			},
			
			
			
			//编辑
			editAddres: function(item){
				var _this = this;
				var useId = item.id;		
				$.ajax({
		            url:'/address/getone',
		            type: 'GET',
		            dataType: 'json',
		            data: {id:useId},
		            success: function(data) {
		                if(data.status == 0){
		                   console.log(data);                  
		                }	                 	
		            }
		        })
			}
        })
	</script>