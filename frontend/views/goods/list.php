<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>商城</title>
		<link rel="stylesheet" href="css/normalize.css">
		<link rel="stylesheet" href="css/style.css" />
		<link rel="stylesheet" href="css/idangerous.swiper.css" />
		<link rel="stylesheet" href="css/video-js.css" />
		<link rel="stylesheet" type="text/css" href="css/aos.css"/>
		<link rel="stylesheet" type="text/css" href="css/main.css"/>
		<script type="text/javascript" src="js/html5shiv.js" ></script>		
		<script type="text/javascript" src="js/jquery-1.8.1.min.js" ></script>
		<script type="text/javascript" src="js/swiper.min.js" ></script>
		<script type="text/javascript" src="js/main.js" ></script>
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
					<a class="logo" href="#"><img src="img/logo.png"></a>
					<nav class="nav_fr">
						<li><a href="#">首页</a></li>
						<li class="on"><a href="#">关于文榜</a></li>
						<li><a href="#">文榜茶源地</a></li>
						<li><a href="#">经营模式</a></li>
						<li><a href="#">古茶树认养</a></li>
						<li><a href="#">会员服务</a></li>
						<li><a href="#">新闻中心</a></li>						
					</nav>
				</div>				
			</div>
		</header>
		<!-- 导航 end -->
		<!-- 主体内容 start  -->
		<div class="container2">
            <section class="laber_goods">
            	<div class="goods auto clearfix">
            		<div class="goods_main" id="goods">
            			<ul>
            				<li v-for="lis in aLis">
            					<a v-bind:href="lis.url">
            						<img v-bind:src="lis.img" alt="茶叶"/>
            						<span>{{lis.name}}</span>
            						<p class="price">{{'￥' + lis.sprice}}</p>
            					</a>
            				</li>
            			</ul>
            		</div>
            	</div>
            </section>
			<div>
								
				<!-- 底部 start  -->
				<footer>
				    <div class="laber_footer auto">
				    	<div class="footer">
				    		<div class="foot_main">
					    		<ul>
					    			<li><a href="#">新闻中心</a></li>
					    			<li><a href="#">文榜茶师</a></li>
					    			<li><a href="#">会员服务</a></li>
					    		</ul>
					    		<div class="footer_wx">
					    			<p id="gfwx"><i></i>官方微信</p>
					    			<em style="display: none;" class="ewm"><img src="img/ewm.jpg"></em>
					    		</div>
					    		<b>亲临品鉴：</b><span>深圳市南山区蛇口街道岸湾六街鸿威海怡湾畔花<br/>园138号商铺</span>
					    		<div class="tel"><p>品茗预约电话：</p>0755 - 8827 8006</div>
				    		</div>
				    		<em>Copyright © 2016 reallytalent.cn        粤ICP备17036121号-1</em>
				    	</div>
				    </div>
				</footer>
				<!-- 底部 end  -->
			</div>			
		</div>
		<!-- 主体内容 end  -->
	</body>
	<script src="https://cdn.jsdelivr.net/npm/vue"></script>
	<script type="text/javascript" src="js/axios.min.js" ></script>
	<script type="text/javascript">
		var goods = new Vue({
			el: '#goods',
			data: {
				aLis: []				
			},
			created: function(){
				var _this = this;
				axios.get('js/demo.json').then(function (response) {
				    _this.aLis = response.data.data;
				    console.log(_this.aLis)
				}).catch(function (error) {
				    console.log(error);
				});
			}
		})
	</script>
</html>


