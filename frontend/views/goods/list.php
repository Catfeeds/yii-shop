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
            				<p>暂时没有任何商品，商家正在紧急上货中...</p>           				
            			</div>
            			<ul v-show="goooList">
            				<li v-for="lis in aLis">
            					<a :href="lis.thisUrl">
            						<img v-bind:src="imgurl + lis.image[0]" alt="橘子"/>
            						<span>{{lis.name}}</span>
            						<p class="price">{{'￥' + lis.shop_price}}</p>
            					</a>
            				</li>
            			</ul>
            			<div v-show="pagShow" class="pagMain">
							<div class="itemPage" v-show="current != 1" @click="current-- && goto(current)">
								<a href="#">上一页</a>
							</div>
							<div class="itemPage" v-for="index in pages" @click="goto(index)" :class="{'active':current == index}" :key="index">
								<a href="#">{{index}}</a>
							</div>
							<div class="itemPage" v-show="allpage != current && allpage != 0 " @click="current++ && goto(current++)">
								<a href="#">下一页</a>
							</div>
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
				size: 4,
				pagShow: true,
				current: 1,  //当前页
				showItem: 5, // 显示条目
				allpage:4, //总页数
				aLis: [],
				id:'',
				thisUrl:'',
				noneCar: true,
				goooList: true
			},
			computed: {
				pages: function() {
					var pag = [];
					if(this.current < this.showItem) { //如果当前的激活的项 小于要显示的条数
						//总页数和要显示的条数那个大就显示多少条
						var i = Math.min(this.showItem, this.allpage);
						while(i) {
							pag.unshift(i--);
						}
					} else { //当前页数大于显示页数了
						var middle = this.current - Math.floor(this.showItem / 2), //从哪里开始
							i = this.showItem;
						if(middle > (this.allpage - this.showItem)) {
							middle = (this.allpage - this.showItem) + 1
						}
						while(i--) {
							pag.push(middle++);
						}
					}
					return pag
				},
				data: function(){
					var _this = this;
					$.ajax({
		                url: '/goods/getlist?page=' + _this.current,
		                type: 'GET',
		                dataType: 'json',
		                data: '',
		                success: function(data) {	                 	
			                if(data.status =='0')
				            {
				            	_this.aLis = data.data;
				            	
				            	if(_this.aLis.length != 0){
					            	_this.goooList = true;
					            	_this.noneCar = false;
					            	_this.pagShow = true;
					            }else{
					            	_this.goooList = false;
					            	_this.noneCar = true;
					            	_this.pagShow = false;
					            }
				                var list = data.data
			                 	for(var i in list){
									_this.id = list[i]._id.$oid;
									list[i].thisUrl = goodsUrl + '?id=' + _this.id;
								}	                 	
					        }else{
					        	alert('页面信息错误');
					        }
		                }
		            })	
//					var main = [];
//					var length = (_this.current - 1) * _this.size;
//					console.log(length)
//					for(var i=length;i < length +  _this.size;i++){
//						console.log(_this.list[i]);
//						if(!_this.list[i]){
//							console.log('没数据了');
//						}else{
//							main.push(_this.list[i]);
//						}
//					}
//					return main;
				}
			},
			created: function(){
				this.data;
			},
//			created: function(){
//				var _this = this;										
//				$.ajax({
//	                url: '/goods/getlist',
//	                type: 'POST',
//	                dataType: 'json',
//	                data: '',
//	                success: function(data) {	                 	
//		                if(data.status =='0')
//			            {
//			            	_this.aLis = data.data;
//			            	
//			            	if(_this.aLis.length != 0){
//				            	_this.goooList = true;
//				            	_this.noneCar = false;
//				            }else{
//				            	_this.goooList = false;
//				            	_this.noneCar = true;
//				            }
//			                var list = data.data
//		                 	for(var i in list){
//								_this.id = list[i]._id.$oid;
//								list[i].thisUrl = goodsUrl + '?id=' + _this.id;
//							}	                 	
//				        }else{
//				        	alert('页面信息错误');
//				        }
//	                }
//	            })	            
//			},
			meathods: {
				goto: function(index) {
					if(index == this.current) return;
					this.current = index;
					//这里可以发送ajax请求
					this.data;
				}
			}
		})
	</script>
</html>


