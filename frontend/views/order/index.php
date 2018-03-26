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
            			<span v-show="">收货信息：</span>
            			<table v-show="address1" border="0" cellspacing="0" cellpadding="0">
            				<tr class="tr1">
            					<th class="td1"></th>
            					<th class="td2">收件人姓名</th>
            					<th class="td3">详细地址</th>
            					<th class="td4">联系电话</th>
            				</tr>
            				<tr class="tr2">
            					<td class="td1 tdct"><em name="xz" type="checkbox" ></em></td>
            					<td class="td2">李美丽</td>
            					<td class="td3">广东省深圳市福田区深南大道大庆大厦</td>
            					<td class="td4">13045682375</td>
            				</tr>
            				<tr class="tr2">
            					<td class="td1 tdct"><em name="xz" type="checkbox" ></em></td>
            					<td class="td2">李美丽</td>
            					<td class="td3">广东省深圳市福田区深南大道大庆大厦</td>
            					<td class="td4">13045682375</td>
            				</tr>
            			</table>
            			<div v-show="address1" class="tj">
            				<a href="javascript:;">添加新地址</a>
            			</div>
                        <ul  v-show="address2" class="address_cont">
                        	<li>
                        		<div class="lis lis1">
                        			<h3>姓名：</h3>
                        			<input type="text" name="name" id="name" v-model="takeDelivery.consignee" placeholder="请输入您的姓名" />
                        		</div>
                        		<div class="lis">
                        			<h3>称谓：</h3>
                        			<select name="title" style="margin-left: 20px;">
                        				<option value="先生">先生</option>
                        				<option value="女士">女士</option>
                        			</select>
                        		</div>
                        	</li>
                        	<li>
                        		<div class="lis lis1">
                        			<h3>联系方式：</h3>
                        			<input type="text" name="tel" id="tel" v-model="takeDelivery.mobile" placeholder="请输入您的电话号码" />
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
                        	<a @click="bcAdd" href="javascript:;">保存地址</a>
                        </ul>
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
    	var goods = JSON.parse(goods);
    	console.log(goods);
	</script>
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