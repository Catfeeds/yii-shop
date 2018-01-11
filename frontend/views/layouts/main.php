<?php $this->beginPage() ?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>首页</title>
		<link rel="stylesheet" href="/css/normalize.css">
		<link rel="stylesheet" href="/css/style.css" />
		<link rel="stylesheet" href="/css/swiper.min.css" />
		<link rel="stylesheet" href="/css/video-js.css" />
		<script type="text/javascript" src="/js/html5shiv.js" ></script>
		<script type="text/javascript" src="/js/jquery-1.8.1.min.js" ></script>
		<script type="text/javascript" src="/js/swiper.min.js" ></script>
	</head>
	<body>
	<?php $this->beginBody() ?>
		<header>
			<div class="laber_top">
				<div class="top_main auto">
					<div class="login">
						<a href="#">登录</a><a href="#">注册</a>
					</div>
				</div>
			</div>
			<div class="laber_header">
				<div class="header_main auto">
					<nav class="nav_fl">
						<li class="on"><a href="#">首页</a></li>
						<li><a href="#">文榜茶叶</a></li>
						<li><a href="#">制茶大师</a></li>
					</nav>
					<a class="logo" href="#"><img src="/img/logo.png"></a>
					<nav class="nav_fr">
						<li><a href="#">文榜茶具</a></li>
						<li><a href="#">健康喝茶</a></li>
						<li><a href="#">新闻中心</a></li>
					</nav>
				</div>				
			</div>
		</header>
		<!-- 导航 end -->
		<!-- banner start  -->
		
		<?= $content;?>
		<script>        
		  var mySwiper = new Swiper ('.swiper-container', {
		    direction: 'horizontal',
		    loop: true,
		    autoplay:3000,
		    pagination: '.swiper-pagination',
		    nextButton: '.swiper-button-next',
	        prevButton: '.swiper-button-prev',
	        effect : 'flip',
		  })
		</script>
		<script type="text/javascript" src="js/video.min.js" ></script>
		<?php $this->endBody() ?>
	</body>
</html>
<?php $this->endPage() ?>