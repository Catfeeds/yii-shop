		<!-- 主体内容 start  -->
		<div class="container2">
            <section class="laber_goods">
            	<div class="goods auto clearfix">
            		<div class="goods_main" id="goods">
            			<ul>
            				<li v-for="lis in aLis">
            					<a v-bind:href="lis.url">
            						<img v-bind:src="lis.img" alt="茶叶"/>
            						<span>{{lis.name}}</span>
            						<p class="price">{{'￥' + lis.sprice}}</p>
            					</a>
            				</li>
            			</ul>
            		</div>
            	</div>
            </section>
			<div>
								
				<!-- 底部 start  -->
				<?php include dirname(__DIR__).'/layouts/footer.php'?> 
				<!-- 底部 end  -->
			</div>			
		</div>
		<!-- 主体内容 end  -->
	</body>
	<script src="https://cdn.jsdelivr.net/npm/vue"></script>
	<script type="text/javascript" src="js/axios.min.js" ></script>
	<script type="text/javascript">
		var goods = new Vue({
			el: '#goods',
			data: {
				aLis: []				
			},
			created: function(){
				var _this = this;
				axios.get('js/demo.json').then(function (response) {
				    _this.aLis = response.data.data;
				    console.log(_this.aLis)
				}).catch(function (error) {
				    console.log(error);
				});
			}
		})
	</script>
</html>


