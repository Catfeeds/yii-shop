		<!-- 主体内容 start  -->
		<div class="container2">
			<section class="laber_teaname">
				<div class="teaname auto">
					<div class="teaname_main">
						<img src="/img/pic9.jpg" />
						<h1></h1>
						<span class="name_tl">陶林</span>
						<div class="name_text">
							<p>国国礼指定普洱茶生产商。</p>
							<p>是2008年奥运会、2010年世博会中</p>
							<p>师不仅为普洱市政府做礼品茶，更</p>
							<p>百姓心中代代相传。多年来，陶老</p>
							<p>王朝进贡。陶氏家族的地位在当地</p>
							<p>朝代中多以“丹漆茶蜜”等向统治</p>
							<p>陶老师原名陶林。陶氏祖上在多个</p>
						</div>
					</div>
				</div>
			</section>
			<section class="laber_core">
				<div class="core auto">
					<div class="core_main">
						<h1>核心工艺</h1>
						<p>“渥堆发酵”是用人工的方法加速茶叶陈化的一种过程，是形成和奠定普洱熟茶特殊品质的关键工艺。通过渥堆发酵，</p>
						<p>可以实现转化茶叶内含物质，减除苦涩味，使滋味变醇，消除青臭气，发展特殊香气的目的。与其他茶的制作</p>
					</div>
				</div>
			</section>
			<div class="contmain2">
				<section class="laber_step">
					<div class="step auto">
						<div class="step_main">
							<div class="step_title">
								<h1></h1>
							</div>
							<div class="step_box">
								<a class="arrow-left01" href="#"></a> 
    		                    <a class="arrow-right01" href="#"></a>
								<div class="swiper-container step_cont">
								  <div class="swiper-wrapper">
								    <div class="swiper-slide">
								    	<img src="/img/pic12.jpg" />
								    	<p>采青</p>
								    </div>
								    <div class="swiper-slide">
								    	<img src="/img/pic13.jpg" />
								    	<p>晾青</p>
								    </div>
								    <div class="swiper-slide">
								    	<img src="/img/pic14.jpg" />
								    	<p>杀青</p>
								    </div>
								    <div class="swiper-slide">
								    	<img src="/img/pic14.jpg" />
								    	<p>杀青</p>
								    </div>
								    <div class="swiper-slide">
								    	<img src="/img/pic14.jpg" />
								    	<p>杀青</p>
								    </div>
								  </div>
								</div>
							</div>							
						</div>
					</div>
				</section>
						<?php include dirname(__DIR__).'/layouts/footer.php'?> 
							</div>			
		</div>
		<!-- 主体内容 end  -->
		<script language="javascript"> 
			var mySwiper = new Swiper('.swiper-container',{
			slidesPerView : 3,
			spaceBetween : 15,
			})
			$('.arrow-left01').on('click', function(e){
			    e.preventDefault()
			    mySwiper.swipePrev()
			})
			$('.arrow-right01').on('click', function(e){
			    e.preventDefault()
			    mySwiper.swipeNext()
			})
		</script>