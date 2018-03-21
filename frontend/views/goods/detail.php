	<div class="container2" id="winwBg">
		<section class="laber_details">
			<div class="details auto clearfix">
				<div class="details_main">
					<div class="details_top">
						<div class="details_fl">
							<div class="data_img">
								<img :src="imgurl + imgArr[num]" alt="柚子" />
							</div>
							<ul class="view">
								<li @click="btnImg(index)" v-for="(img, index) in imgArr">
									<img :src="imgurl + img" alt="柚子" />
								</li>
							</ul>
							<div @click="preve" class="preve"></div>
							<div @click="next" class="next"></div>
						</div>
						<div class="details_fr">
							<h1>{{ goodName }}</h1>
							<p>{{ goodPrice }}</p>
							<div id="" class="data_number">
								<em>购买数量：</em><input @click="btnjj" class="" type="button" value="-" />
								<input class="sl" type="text" v-model="goods_num" />
								<input @click="btnAdd" type="button" value="+" />
							</div>
							<a class="gm" href="javascript:;">立即购买</a>
							<a @click="tjCar" href="javascript:;">添加购物车</a>
							<ul>
								<li>
									<span v-for="arr in keyArr" class="li_w">{{ arr.key }}：<em>{{ arr.value }}</em></span>
								</li>
							</ul>
							<strong>生产日期：<em>见包装盒喷码标识</em></strong>
						</div>
					</div>
					<div class="details_center" v-html="content">
						
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
				<a href="/cart/index" class="al1">前往购物车结算</a>
			</div>
		</div>
	</div>
	<!-- 主体内容 end  -->
</body>
	<script src="https://cdn.jsdelivr.net/npm/vue"></script>
	<script type="text/javascript" src="/js/axios.min.js" ></script>
	<script type="text/javascript">
		var id = "<?=$id?>";
		var num = 0;
		var goodCar = new Vue({
			el: '#winwBg',
			data: {
				carShow:false,
				popupShow:false,
				goodUrl: '/goods/getdetail',
				goodName: '',
				goodPrice: '',				
				imgArr:[],
				id: '',
				keyArr: [],
				goods_num: 1,
				content:''				
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
	                	if(data.status == 0){
	                		_this.goodName = data.data.name;
						    _this.goodPrice = data.data.shop_price;
						    _this.imgArr = data.data.image;
						    _this.keyArr = data.data.ext;
						    _this.content = data.data.content;
						    console.log(_this.imgArr);
						    console.log(_this.keyArr);
	                	}	                 	
	                }
	           })	            
	                       	           
			},	
            methods: {
            	tjCar: function(){
            		var _this = this;
            		$.ajax({
	                url: '/cart/addcart',
	                type: 'POST',
	                dataType: 'json',
	                data: {goods_num: this.goods_num, goods_id: this.id},
	                success: function(data) {
		                	if(data.status == 0){
		                		console.log('添加成功');
		                		_this.carShow = true;
            		            _this.popupShow = true;
		                	}	                 	
		                }
		           })          		            		
            	},
            	carQx: function(){
            		this.carShow = false;
            		this.popupShow = false;
            	},
            	carBg: function(){
            		this.carShow = false;
            		this.popupShow = false;
            	},
            	btnImg:function(index){           		
            		this.toImg = imgurl + this.imgArr[index];
            		num = index;         		
            	},
            	preve: function(){
            		if(num == 0){
            			num = this.imgArr.length;
            		}
            		num--;            		
            	},
            	next: function(){            		
            		if(num == this.imgArr.length - 1){
            			num = -1;
            		}
            		num++;
            		console.log(num)
            	},
            	btnjj:function(){
            		this.goods_num--;
            		if(this.goods_num <= 0){
            			this.goods_num = 0;
            		}
            	},
            	btnAdd:function(){
            		this.goods_num++;
            	}
            }
		})
	</script>