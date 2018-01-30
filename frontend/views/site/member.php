		<div class="container2">
            <div class="laber_heart">
				<img src="/img/pic59.jpg" />
			</div>
			<section class="laber_contact">
				<div class="contact auto">
					<div class="contact_main">
						<div class="contact_text">
							<p>除了让会员喝到真正的百年古树茶，文榜更旨在提供至尊的服务，为此文榜茶业在<em>深圳南山区</em>提供了<em>环境优雅的品茗会所</em>供认养人品茶、会友、商务活动等。会所还会不定期举行茶文化沙龙、中国传统文化论坛等，为爱茶人提供茶文化交流契机与场地。</p>
							<p>品茗预约电话：<em>0755-8827800</em></p>
							<p style="margin-top: 20px;">您的私人茶树管家：<em>甘小姐 13926575880</em></p>
							<div class="address">
								<i></i>
								深圳市南山区蛇口街道岸湾六街鸿威海怡湾畔花园138号商铺
							</div>
						</div>
						<div  id="map_dt" class="map_dt"></div>
						<img src="/img/pic60.jpg"/>
						<img src="/img/pic61.jpg"/>
						<img src="/img/pic62.jpg"/>
					</div>
				</div>
			</section>
			<div class="contmain6">								
			<?php include dirname(__DIR__).'/layouts/footer.php'?> 
			</div>			
		</div>
		<!-- 主体内容 end  -->
		<script src="http://api.map.baidu.com/api?v=2.0&ak=A1LU7iHS0avqQwPLAxbhKn0UYSQCuRVH"></script>
		<script type="text/javascript" src="/js/jquery.baiduMap.min.js" ></script>
		<script type="text/javascript">
			new BaiduMap({
				id: "map_dt",
				title: {
					text: "文榜茶叶",
					className: "title"
				},
				content: {
					className: "content",
					text: ["地址：深圳市南山区蛇口街道岸湾六街鸿威海怡湾畔花园138号商铺"]
				},
				point: {
					lng: "113.949185",
					lat: "22.497128"
				},
				level: 15,
				zoom: true,
				type: ["地图", "卫星", "三维"],
				width: 320,
				height: 70,
				icon: {
					url: "/img/dd.png",
					width: 24,
					height: 34
				}
			});
			
		</script>