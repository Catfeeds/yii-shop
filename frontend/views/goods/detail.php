	<div class="container2" id="winwBg">
		<section class="laber_details">
			<div class="details auto clearfix">
				<div class="details_main">
					<div class="details_top">
						<div class="details_fl">
							<div class="data_img">
								<img src="/img/pic14.jpg" alt="茶叶" />
							</div>
							<ul class="view">
								<li v-for="(img, index) in imglis">
									<img :src="img.imgs" alt="茶叶" />
								</li>
							</ul>
							<div class="preve"></div>
							<div class="next"></div>
						</div>
						<div class="details_fr">
							<h1>文榜古树普洱（纯料生茶）10块装</h1>
							<p>¥300</p>
							<div id="" class="data_number">
								<em>购买数量：</em><input class="" type="button" value="-" />
								<input class="sl" type="text" value="1" />
								<input type="button" value="+" />
							</div>
							<a class="gm" href="javascript:;">立即购买</a>
							<a @click="tjCar" href="javascript:;">添加购物车</a>
							<ul>
								<li>
									<span class="li_w">商品编号：<em>03.02.01.02.06</em></span>
									<span>配料：<em>普洱</em></span>
								</li>
								<li>
									<span class="li_w">净含量：<em>40g</em></span>
									<span>等级：<em>特级</em></span>
								</li>
								<li>
									<span class="li_w">保质期：<em>1095</em></span>
									<span>产地：<em>老乌山</em></span>
								</li>
							</ul>
							<strong>生产日期：<em>见包装盒喷码标识</em></strong>
						</div>
					</div>
					<div class="details_center">
						<p><img src="img/pic21.jpg" /></p>
					</div>
				</div>
			</div>
		</section>
		<div>
		<?php include dirname(__DIR__).'/layouts/footer.php'?> 
		</div>
		<div v-show="carShow" @click="carBg" id="carBg" class="carBg"></div>
		<div v-show="popupShow" id="carPopup" class="carPopup">
			<i @click="carQx"></i>
			<span>已成功添加至购物车！</span>
			<div class="linkShop">
				<a href="#">继续逛逛</a>
				<a href="#" class="al1">前往购物车结算</a>
			</div>
		</div>
	</div>
	<!-- 主体内容 end  -->
</body>
	<script src="https://cdn.jsdelivr.net/npm/vue"></script>
	<script type="text/javascript" src="/js/axios.min.js" ></script>
	<script type="text/javascript">
		var goodCar = new Vue({
			el: '#winwBg',
			data: {
				carShow:false,
				popupShow:false,
				goodDeta: [],
				imglis: []
			},
			created: function(){
				var _this = this;
				axios.get('js/good2.json').then(function (response) {
				    _this.goodDeta = response.data.data;
				    for(var n in _this.goodDeta){
				    	_this.imglis = _this.goodDeta[n].imgmain;
				    }
				    console.log(_this.goodDeta);
				    console.log(_this.imglis);
				}).catch(function (error) {
				    console.log(error);
				});
			},
	
            methods: {
            	tjCar: function(){           		
            		this.carShow = true;
            		this.popupShow = true;
            	},
            	carQx: function(){
            		this.carShow = false;
            		this.popupShow = false;
            	}
            }
		})
	</script>