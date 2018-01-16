<?php use yii\helpers\Url;
?>
		<div class="container2">
			<section class="laber_news">
				<div class="news auto">
					<div class="news_main">
						<?php if($articles): foreach($articles as $v):?>
						<div class="item">
							<a class="link_pic" href="<?=Url::to('/site/detail?id='.$v['id'])?>"><img src="<?=Yii::$app->params['image'].$v['thumb']?>"></a>
							<span><?=$v['title']?></span>
							<a class="link_p" href="#"><?=$v['summary']?></a>
						</div>
						<?php endforeach;endif;?>
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
	</body>
</html>

