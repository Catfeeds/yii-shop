<?php 
use yii\helpers\Url;
?>
		<div class="container2" id="weixin">
            <section class="laber_shopUser">
            	<div class="shopUser auto clearfix">
            		<div class="shopUser_main">
            			<p>您好，15038384758</p>
            			<ul>
            				<li><a href="">密码管理</a></li>
            				<li><a href="/cart/index">购物车</a></li>
            				<li><a href="/address/index">收货地址</a></li>
            				<li class="on"><a href="/order/list">我的订单</a></li>
            			</ul>
            		</div>
            	</div>
            </section>
            <section class="laber_shop">
            	<div class="shop auto clearfix">
            		<div class="weChat_main">
            			<span>¥<?=$orderAmount?>元</span>
            			<p>打开微信“扫一扫”，立即支付</p>
            			<img src="<?=Url::to(['/pay/qrcode','data'=>$url]);?>" />
            		</div>
            	</div>
            </section>
			<div>
			<?php include dirname(__DIR__).'/layouts/footer.php'?> 
			</div>
			<div v-show="carShow" id="carBg" class="carBg"></div>
			<div v-show="popupShow" id="carPopup" class="carPopup">
				<span>付款成功</span>
				<div class="linkShop">
					<a @click="carSc" href="javascript:;">确定</a>
				</div>
			</div>			
		</div>
		<!-- 主体内容 end  -->
	</body>
	<script src="https://cdn.jsdelivr.net/npm/vue"></script>
	<script type="text/javascript" src="/js/axios.min.js" ></script>
	<script type="text/javascript">
		var id = "<?=$id?>";		
        new Vue({
        	el: '#weixin',
        	data: {
        		carShow: false,
        		popupShow: false,
        		orderId: id,
        		orderUrl: ''
        	},
        	created: function(){ 
        		let self = this;
        		var timer;
			    setInterval(function(){self.refreshData();}, 1500)     		
        	},
        	methods: {
        		refreshData: function(){
        			var _this = this;
        			var orderUrl;
        			$.ajax({
			            url:'/order/paystatus',
			            type: 'GET',
			            dataType: 'json',
			            data: {order_sn: _this.orderId},
			            success: function(data) {
			                if(data.status == 0){
			                    console.log('请求数据成功');
			                    orderUrl = data.return_url;
			                    _this.orderUrl = orderUrl;
			                    console.log(_this.orderUrl);
			                    if(data.pay_status != 1){
			                    	_this.carShow = true;
        		                    _this.popupShow = true;			                    	
			                    }
			                }else{
			                	console.log('请求数据出错');
			                }                 	
			            }
			        })
        		},
        		carSc: function(){
        			var _this = this;
        			window.location = _this.orderUrl;
        		}     		
        	},
        	beforeDestroy: function(){
        		let self = this;
        		clearInterval(function(){self.refreshData()});
        	}
        })
	</script>