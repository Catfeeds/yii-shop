		<!-- 导航 end -->
		<!-- 主体内容 start  -->
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
            		<div class="shop_main" style="margin-bottom: 466px;">
            			<span>收货地址：</span>
            			<table border="0" cellspacing="0" cellpadding="0">
            				<tr class="tr1">
            					<th style="padding-left:20px; width:262px;" class="td2">收件人姓名</th>
            					<th style="width: 562px;" class="td3">详细地址</th>
            					<th style="width: 232px;" class="td4">联系电话</th>
            					<th class="td4">操作</th>
            				</tr>
            				<tr class="tr2">
            					<td style="padding-left:20px; width:262px;" class="td2">李美丽</td>
            					<td style="width: 562px;" class="td3">广东省深圳市福田区深南大道大庆大厦</td>
            					<td style="width: 232px;" class="td4">13045682375</td>
            					<td class="td4"><p>编辑</p><p>删除</p></td>
            				</tr>
            			</table>
            			<div class="tj">
            				<a href="javascript:;">添加新地址</a>
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
	<script type="text/javascript" src="js/axios.min.js" ></script>
	<script type="text/javascript">
        var shop = new Vue({
       	    el:'#shopData',
       	    data: {
       	    	address1: false,
       	    	address2: true,
       	    	arr: arrAll,
       	    	cityArr: [],
                districtArr: [],
                takeDelivery: {
                    consignee: '',   //姓名
                    mobile: '',  //电话
                    province: '选择省份', //省
                    city: '选择市',  //市
                    district: '选择区',  //县
                    address: '' //具体地址
                }
       	    },
       	    created: function(){
       	    	console.log(this.arr)
       	    	for(var i in this.arr){
       	    		
       	    	}
       	    },
       	    methods: {
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
				bcAdd: function(){
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
				}
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