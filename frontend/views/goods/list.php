<?php
use yii\helpers\Url;
?>
<!-- 主体内容 start  -->
		<div class="container2">
            <section class="laber_goods">
            	<div class="goods auto clearfix">
            		<div class="goods_main" id="goods">
            			<ul>
            				<li v-for="lis in aLis">
            					<a :href="thisUrl">
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
				thisUrl:''
			},
			created: function(){
				var _this = this;
				var goodsUrl = "<?=Url::to('/goods/detail/')?>";
				console.log(goodsUrl)				
				$.ajax({
	                url: '/goods/getlist',
	                type: 'POST',
	                dataType: 'json',
	                data: '',
	                success: function(data) {
	                 	_this.aLis = data.data;
	                 	_this.thisUrl = goodsUrl + '?' + 'id=' + data.data._id.$oid[0];
	                 	console.log(_this.aLis)
	                }
	            })
			}
		})
	</script>
</html>


