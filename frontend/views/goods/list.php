<?php
use yii\helpers\Url;
?>
<!-- 主体内容 start  -->
		<div class="container2">
            <section class="laber_goods">
            	<div class="goods auto clearfix">
            		<div class="goods_main" id="goods">
            			<div v-show="noneCar" class="noneCar">
            				<img src="/img/kong.png"/>
            				<p>您还没有添加任何商品，快去逛逛吧</p>           				
            			</div>
            			<ul>
            				<li v-for="lis in aLis">
            					<a :href="lis.thisUrl">
            						<img v-bind:src="imgurl + lis.image[0]" alt="橘子"/>
            						<span>{{lis.name}}</span>
            						<p class="price">{{'￥' + lis.shop_price}}</p>
            					</a>
            				</li>
            			</ul>
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
		var goods = new Vue({
			el: '#goods',
			data: {
				aLis: [],
				id:'',
				thisUrl:'',
				noneCar: true
			},
			created: function(){
				var _this = this;				
				console.log(goodsUrl)							
				$.ajax({
	                url: '/goods/getlist',
	                type: 'POST',
	                dataType: 'json',
	                data: '',
	                success: function(data) {	                 	
		                if(data.status =='0')
			            {
			            	_this.aLis = data.data;
			                var list = data.data
		                 	for(var i in list){
								_this.id = list[i]._id.$oid;
								list[i].thisUrl = goodsUrl + '?id=' + _this.id;
							}	                 	
		                 	_this.aLis = list;
				        }
	                }
	            })
			}
		})
	</script>
</html>


