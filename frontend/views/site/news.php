<?php use yii\helpers\Url;
?>
		<div class="container2">
			<section class="laber_news">
				<div class="news auto">
					<div class="news_main" id="news_main">

						<!--<div class="item">
							<a class="link_pic" href="<?=Url::to('/site/detail?id='.$v['id'])?>"><img src="<?=Yii::$app->params['image'].$v['thumb']?>"></a>
							<span><?=$v['title']?></span>
							<a class="link_p" href="#"><?=$v['summary']?></a>
						</div>-->

					</div>
					<div class="look_more">
						<a class="more" href="javascript:;">浏览更多</a>
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
		<script type="text/javascript">
			$(function(){
			    /*初始化*/
			    var counter = 0; /*计数器*/
			    var pageStart = 0; /*offset*/
			    var pageSize = 6; /*size*/
			    
			    /*首次加载*/
			    getData(pageStart, pageSize);
			    
			    /*监听加载更多*/
			    $(document).on('click', '.more', function(){
			        counter ++;
			        pageStart = counter * pageSize;
			        
			        getData(pageStart, pageSize);
			    });
			});
		</script>
	</body>
</html>

