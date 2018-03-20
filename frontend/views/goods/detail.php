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
								<li v-for="img in imgArr">
									<img :src="img" alt="茶叶" />
								</li>
							</ul>
							<div class="preve"></div>
							<div class="next"></div>
						</div>
						<div class="details_fr">
							<h1>{{ goodName }}</h1>
							<p>{{ goodPrice }}</p>
							<div id="" class="data_number">
								<em>购买数量：</em><input class="" type="button" value="-" />
								<input class="sl" type="text" value="1" />
								<input type="button" value="+" />
							</div>
							<a class="gm" href="javascript:;">立即购买</a>
							<a @click="tjCar" href="javascript:;">添加购物车</a>
							<ul>
								<li v-for="key in keyArr">
									<span class="li_w">{{ key.key }}：<em>{{ key.value }}</em></span>
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
		var id = "<?=$id?>";
		var goodCar = new Vue({
			el: '#winwBg',
			data: {
				carShow:false,
				popupShow:false,
				goodUrl: '/goods/getdetail',
				goodName: '',
				goodPrice: '',
				imgArr: [],
				id: '',
				keyArr: []
			},
			created: function(){
				var _this = this;
				_this.id = id;
				console.log(_this.id);
				$.ajax({
	                url: _this.goodUrl + '?id=' + _this.id,
	                type: 'POST',
	                dataType: 'json',
	                data: '',
	                success: function(data) {
	                 	_this.goodName = data.data.name;
					    _this.goodPrice = data.data.shop_price;
					    _this.imgArr = data.data.image;
					    _this.keyArr = data.data.ext;
					    console.log(_this.goodName);
					    console.log(_this.goodPrice);
					    console.log(_this.imgArr);
	                }
	            })
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