<?php use yii\helpers\Url;?>
<div class="ad">
	        <a class="arrow-left" href="#"></a> 
    		<a class="arrow-right" href="#"></a>
			<div class="swiper-container">
			    <div class="swiper-wrapper swiper-list">
			    	<?php if ($banner) : ?>
                    <?php foreach ($banner as $k1 => $v1) : ?>
			        <div class="swiper-slide">
			        	<a href="#" style="background: url(<?= Yii::$app->params['image'].($v1['image']) ?>) no-repeat center;"></a>
			        </div>
			        <?php endforeach;?>
                	<?php endif; ?>
			    </div>
			    <div class="pagination"></div>
			</div>
		</div>
		<div class="container">
			<!-- 走进文榜 start  -->
			<section class="laber_wenbang">
				<div class="wenbang auto">
					<div class="wenbang_main">
						<div class="wenbang_fl">
							<img src="img/zjwb.png" />
							<p class="p1">一<br>笔<br>留<br>给<br>子<br>孙<br>后<br>代<br>的<br>宝<br>贵<br>财<br>富<br>。</p>
							<p>良<br>种<br>子<br>基<br>因<br>库<br>；<br>每<br>一<br>棵<br>古<br>茶<br>树<br>，<br>就<br>是</p>
							<p>发<br>展<br>史<br>；<br>每<br>一<br>棵<br>古<br>茶<br>树<br>，<br>就<br>是<br>一<br>座<br>优</p>
							<p>每<br>一<br>棵<br>古<br>茶<br>树<br>，<br>就<br>是<br>一<br>部<br>自<br>然<br>与<br>社<br>会</p>							
						</div>
						<div class="wenbang_fr">
						    <video id="my-video" class="video-js vjs-big-play-centered" controls preload="auto" width="898" height="505" poster="img/pic1.jpg" data-setup="{}">
						    	<source src="http://p301ah80l.bkt.clouddn.com/wenbang.mp4" type="video/mp4">
						    </video>
						</div>
					</div>
				</div>
			</section>
			<!-- 走进文榜 end  -->
			<!-- 文榜服务 start  -->
			<section class="laber_service">
				<div class="service auto">
					<div class="service_main">
						<a href="<?=Url::to('/site/make')?>"><img src="img/pic2.jpg"></a>
						<a href="<?=Url::to('/site/pack')?>"><img src="img/pic3.jpg"></a>
						<a href="<?=Url::to('/site/experience')?>"><img src="img/pic4.jpg"></a>
					</div>
				</div>
			</section>
						<?php include dirname(__DIR__).'/layouts/footer.php'?> 
		</div>
		<script>        
		  var mySwiper = new Swiper ('.swiper-container', {
		    direction: 'horizontal',
		    loop: true,
		    autoplay:3000,
		    pagination : '.pagination',
		    grabCursor: true,
		    paginationClickable :true,
	        effect : 'flip',
		  })
		  $('.arrow-left').on('click', function(e){
		    e.preventDefault()
		    mySwiper.swipePrev()
		  })
		  $('.arrow-right').on('click', function(e){
		    e.preventDefault()
		    mySwiper.swipeNext()
		  })
		</script>
		<script type="text/javascript" src="js/video.min.js" ></script>
		<script type="text/javascript">
			var myPlayer = videojs('my-video');
		    videojs("my-video").ready(function(){
			  var myPlayer = this;
			  myPlayer.play();
		    });
		</script>