<?php 
use yii\helpers\Url;
use yii\helpers\Html;
$this->beginPage() ?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title><?= Html::encode($this->params['title']) ?></title>
		<meta name="description" content="<?= Html::encode($this->params['description'])?>" />
		<meta name="keywords" content="<?= Html::encode($this->params['keywords'])?>" />
		<link rel="stylesheet" href="/css/normalize.css">
		<link rel="stylesheet" href="/css/style.css" />
		<link rel="stylesheet" href="/css/idangerous.swiper.css" />
		<link rel="stylesheet" href="/css/video-js.css" />
		<link rel="stylesheet" href="/css/aos.css" />
		<link rel="stylesheet" href="/css/main.css" />
		
		<link rel="icon" href="/img/ico.ico" type="image/x-icon">
		<link rel="shortcut icon" href="/img/ico.ico" mce_href="/img/ico.ico" type="image/x-icon" />
		<script type="text/javascript" src="/js/html5shiv.js" ></script>
		<script type="text/javascript" src="/js/jquery-1.8.1.min.js" ></script>
		<script type="text/javascript" src="/js/idangerous.swiper2.7.6.min.js" ></script>
		<script type="text/javascript" src="/js/aos.js" ></script>
		<script type="text/javascript" src="/js/main.js" ></script>
		<script>
			var imgurl ="<?=Yii::$app->params['image']?>";
			var islogin = <?=$isLogin?>;
		</script>
	</head>
	<body>
	<?php $this->beginBody() ?>
		<!--[if lte IE 8]>
			<p class="browserupgrade">您的浏览器版过低，请到<a href="http://browsehappy.com">这里</a>更新，以获取最佳体验</p>
		<![endif]-->
		<!--[if lte IE 8]>
		<script>
		       (function(){var e="abbr, article, aside, audio, canvas, datalist, details, dialog, eventsource, figure, footer, header, hgroup, mark, menu, meter, nav, output, progress, section, time, video".split(', ');var i=e.length;while(i--){document.createElement(e[i])}})()
		    </script>
		<![endif]-->
		<header>
			<div class="laber_top">
				<div class="top_main auto">
					<div class="login">
						  <?php if(!Yii::$app->user->isGuest):?>
						  	<?php if(Yii::$app->user->identity->mobile):?>
						  		<a href="#"><?=Yii::$app->user->identity->mobile?></a>
						  	<?php else:?>
						  		<a href="#"><?=Yii::$app->user->identity->nickname?></a>
						  	<?php endif;?>
						  	<a href="<?=Url::to('/site/logout')?>">退出</a>
						  <?php else:?>
							<a href="<?=Url::to('/site/login')?>">登录</a><a href="<?=Url::to('/site/signup')?>">注册</a>
						  <?php endif;?>
					</div>
				</div>
			</div>
			<div class="laber_header">
				<div class="header_main auto">
					<a class="logo" href="/"><img src="/img/logo.png"></a>
					<nav class="nav_fr">
						<li <?php if($this->params['controller']=='index'):?>class="on" <?php endif;?>><a href="/">首页</a></li>
						<li <?php if($this->params['action']=='about'):?>class="on"<?php endif;?>><a href="<?=Url::to('/site/about')?>">关于文榜</a></li>
						<li <?php if($this->params['action']=='source'):?>class="on" <?php endif;?>><a href="<?=Url::to('/site/source')?>">文榜茶源地</a></li>
						<li <?php if($this->params['action']=='management'):?>class="on"<?php endif;?>><a href="<?=Url::to('/site/management')?>">经营模式</a></li>
					    <li <?php if($this->params['action']=='old'):?>class="on"<?php endif;?>><a href="<?=Url::to('/site/old')?>">古茶树认养</a></li>
						<li <?php if($this->params['action']=='member'):?> class="on"<?php endif;?>> <a href="<?=Url::to('/site/member')?>">会员服务</a></li>
						<li <?php if($this->params['action']=='news'):?> class="on"<?php endif;?>> <a href="<?=Url::to('/site/news')?>">新闻中心</a></li>	
						<li <?php if($this->params['action']=='list'):?> class="on"<?php endif;?>> <a href="<?=Url::to('/goods/list')?>">在线商城</a></li>					
					</nav>
				</div>				
			</div>
		</header>
		
		<?= $content;?>
		<?php $this->endBody() ?>
	</body>
</html>
<?php $this->endPage() ?>