<?php
use yii\helpers\Url;
?>
<!-- 主体内容 start  -->
		<div class="container2">
            <section class="laber_goods">
            	<div class="goods auto clearfix">
            		<div class="goods_main" id="goods">
            			<div class="loadingMain" id="loadMain"></div>
            			<div v-show="noneCar" class="noneCar">
            				<img src="/img/kong.png"/>
            				<p>暂时没有任何商品，商家正在紧急上货中...</p>           				
            			</div>
            			<ul v-show="goooList">
            				<li v-for="lis in aLis">
            					<a :href="lis.thisUrl">
            						<img v-bind:src="lis.image[0]" alt="橘子"/>
            						<span>{{lis.name}}</span>
            						<p class="price">{{'￥' + lis.shop_price}}</p>
            					</a>
            				</li>
            			</ul>
            			<div v-show="pagShow" class="pagMain">
							<div class="itemPage" v-show="current != 1" @click="current-- && goto(current--)">
								<a href="javascript:;">上一页</a>
							</div>
							<div class="itemPage" v-for="index in pages" @click="goto(index)" :class="{'active':current == index}" :key="index">
								<a href="javascript:;">{{index}}</a>
							</div>
							<div class="itemPage" v-show="allpage != current && allpage != 0 " @click="current++ && goto(current++)">
								<a href="javascript:;">下一页</a>
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
				size: 10,
				pagShow: true,
				current: 1,  //当前页
				showItem: 5, // 显示条目
				allpage:1, //总页数
				aLis: [],
				id:'',
				thisUrl:'',
				noneCar: true,
				goooList: true,
				count: 0
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
				}
			},
			created: function(){
				var _this = this;
				_this.dataInfo(_this.current);					
			},
			methods: {
				goto: function(index) {
					var _this = this;
					if(index == _this.current) return;
					_this.current = index;
					//这里可以发送ajax请求
					_this.dataInfo(_this.current);
				},
				
				dataInfo: function(cur){
					var _this = this;
					var aSize = null;				
					$.ajax({
		                url: '/goods/getlist?page=' + cur,
		                type: 'GET',
		                dataType: 'json',
		                data: {size: _this.size},
		                beforeSend: function () {
		                	var load = document.createElement('div');
						    load.className = 'loader circle-round-fade small';
						    for(var i=0;i<8;i++){
						    	load.innerHTML += '<small></small>';
						    }
						    $('#loadMain').html(load);
						    
						},

		                success: function(data) {	                 	
			                if(data.status =='0')
				            {
				            	$('#loadMain').html('');
				            	_this.aLis = data.data;
				            	aSize = Math.ceil(data.count / _this.size);
				            	_this.allpage = aSize;	
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
				}
			}
		})
	</script>
</html>


