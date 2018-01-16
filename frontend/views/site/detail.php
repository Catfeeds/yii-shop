		<div class="container2">
			<section class="laber_newDetails">
				<div class="newDetails auto">
					<div class="newDetails_main">
						<a class="back" href="#"><返回</a>
						<div class="new_cont">
							<time><?=date('Y-m-d',$article->created_at)?></time>
							<span><?=$article->title?></span>
							<p><?=$article->content ?></p>
						</div>
					</div>
				</div>
			</section>
			<div class="contmain4">
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