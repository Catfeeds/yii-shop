<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>新闻中心</title>
		<link rel="stylesheet" href="css/normalize.css">
		<link rel="stylesheet" href="css/style.css" />
		<link rel="stylesheet" href="css/idangerous.swiper.css" />
		<link rel="stylesheet" href="css/video-js.css" />
		<script type="text/javascript" src="js/html5shiv.js" ></script>
		<script type="text/javascript" src="js/jquery-1.8.1.min.js" ></script>
		<script type="text/javascript" src="js/idangerous.swiper2.7.6.min.js" ></script>
	</head>
	<body>
		<!--
        	作者：laber0926@163.com
        	时间：2018-01-10
        	描述：文榜茶叶首页
        -->
        <!--[if lte IE 8]>
			<p class="browserupgrade">您的浏览器版过低，请到<a href="http://browsehappy.com">这里</a>更新，以获取最佳体验</p>
		<![endif]-->
		<!--[if lte IE 8]>
		<script>
		       (function(){var e="abbr, article, aside, audio, canvas, datalist, details, dialog, eventsource, figure, footer, header, hgroup, mark, menu, meter, nav, output, progress, section, time, video".split(', ');var i=e.length;while(i--){document.createElement(e[i])}})()
		    </script>
		<![endif]-->
        
        <!-- 导航 start  -->
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
					<a class="logo" href="#"><img src="img/logo.png"></a>
					<nav class="nav_fr">
						<li><a href="#">文榜茶具</a></li>
						<li><a href="#">健康喝茶</a></li>
						<li><a href="#">新闻中心</a></li>
					</nav>
				</div>				
			</div>
		</header>
		<!-- 导航 end -->
		<!-- 主体内容 start  -->
		<div class="container2">
			<section class="laber_news">
				<div class="news auto">
					<div class="news_main">
						<div class="item">
							<a class="link_pic" href="#"><img src="/img/pic1.jpg"></a>
							<span>传统与现代碰撞，文榜茶打造中国式</span>
							<a class="link_p" href="#">文榜茶业，保留茶山最原始的自然环境，请茶农专门打理，365天24小时全天候视频监控；每棵树都有属于自己的身份编码，全程溯源；</a>
						</div>
						<div class="item">
							<a class="link_pic" href="#"><img src="/img/pic1.jpg"></a>
							<span>传统与现代碰撞，文榜茶打造中国式</span>
							<a class="link_p" href="#">文榜茶业，保留茶山最原始的自然环境，请茶农专门打理，365天24小时全天候视频监控；每棵树都有属于自己的身份编码，全程溯源；</a>
						</div>
						<div class="item">
							<a class="link_pic" href="#"><img src="/img/pic1.jpg"></a>
							<span>传统与现代碰撞，文榜茶打造中国式传统与现代碰撞，文榜茶打造中国式</span>
							<a class="link_p" href="#">文榜茶业，保留茶山最原始的自然环境，请茶农专门打理，365天24小时全天候视频监控；每棵树都有属于自己的身份编码，全程溯源；</a>
						</div>
						<div class="item">
							<a class="link_pic" href="#"><img src="/img/pic1.jpg"></a>
							<span>传统与现代碰撞，文榜茶打造中国式</span>
							<a class="link_p" href="#">文榜茶业，保留茶山最原始的自然环境，请茶农专门打理，365天24小时全天候视频监控；每棵树都有属于自己的身份编码，全程溯源；</a>
						</div>
					</div>
				</div>
			</section>
			<div class="contmain4">
			<?php include __DIR__.'/layouts/footer.php'?> 
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

