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
            				<li><a href="">购物车</a></li>
            				<li><a href="">收货地址</a></li>
            				<li><a href="">我的订单</a></li>
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
        		order_sn
        	},
        	created: function(){
        		this.refreshData();
        	},
        	methods: {
        		refreshData: function(){
        			$.ajax({
			            url:'/order/paystatus',
			            type: 'GET',
			            dataType: 'json',
			            data: '',
			            success: function(data) {
			                if(data.status == 0){
			                    console.log('请求数据成功');
			                }else{
			                	console.log('请求数据出错');
			                }                 	
			            }
			        })
        		}       		
        	}
        })
	</script>