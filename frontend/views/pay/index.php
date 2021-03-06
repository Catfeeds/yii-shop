		<div class="container2" id="payment">
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
            		<div class="shop_main" style="margin-bottom: 192px;">
            			<span>选择付款方式</span>
                        <span style="margin-top: 28px;">支付方式：</span>
                        <h3>实付：¥<?=$order['pay_price']?></h3>
            			<div class="shop_zf">
            				<li @click="payment(index)" v-for="(opt, index) in options" v-bind:class="{on1 : ont == index}">
            					<i :class="opt.clas"></i>
            					<span>{{ opt.name }}</span>
            					<p>{{ opt.nameEg }}</p>
            				</li>
            				<button @click="btnFk" type="button">立即付款</button>
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
		var order_id = "<?=$order['order_no']?>";
        var payment = new Vue({
        	el:'#payment',
        	data:{
        		ont: 0, 
        		options:[
        		    {
        		    	active: '1',
        		    	clas: 'wx',
        		    	name: '微信支付',
        		    	nameEg: 'Wechat Pay'
        		    }/*,
        		    {
        		    	active: '2',
        		    	clas: 'zfb',
        		    	name: '支付宝',
        		    	nameEg: 'ALIPAY'
        		    }*/
        		]
        	},
        	methods: {
        		payment: function(index){
        			this.ont = index;
        		},
        		btnFk: function(){
        			window.location = '/pay/weixin' + '?id=' + order_id;
        		}
        	}
        })
	</script>