		<div class="container2">
			<section class="laber_merchants">
				<div class="merchants auto">
					<div class="merchants_main">
						<h1>全国招商正式开放，一起来重新定义中国好茶！</h1>
						<p>“志于道、据于德、依于仁、游于艺”，中国文化向来讲究文以载道，而茶极大地在生活中滋养人们，形成一种独特的生活方式。自汉武帝开启丝绸之路，茶的角色愈加重要，成为经济贸易的卓越贡献者，随着经济的发展，中国茶传至日本、韩国、乃至欧洲和美洲，“东方树叶”成为中国的代名词。然而，当茶走出国门，影响了全世界时，越来越多的中国人却习惯了添加奶与方糖的各式咖啡，忘记了中国茶的韵味；都市人习惯了上班前匆匆一杯星巴克，忘记了中国茶的恬静。当这些西方舶来品涌进现代人的生活，以“做中国好茶，做好中国茶”为己任的小罐茶应运而生，试图以茶为媒，用创意打造属于当下中国人的品质生活方式，再次唤醒国人对中国茶的热爱。</p>
						<p>正值春茶上市之际，小罐茶创始人杜国楹邀请8位来自不同领域的大咖与一条、罗辑思维等媒体的爱茶之人，加入小罐茶“寻找春天礼”活动，用生活美学释放中国文化之美。</p>
						<span>现将招商相关事宜公布如下：</span>
						<em>要求:</em>
						<ul>
							<li><i>1、</i>具备创新思维，具备实干精神，认同文榜茶叶品牌理念；</li>
							<li><i>2、</i>有固定的消费客户，熟悉当地茶叶消费状况，在当地有丰富的人脉资源，有一定影响力。</li>
						</ul>
						<em>权益:</em>
						<ul>
							<li><i>1、</i>享有文榜全系列茶叶及茶具产品的经营权；</li>
							<li><i>2、</i>享有文榜店面形象、物料的支持</li>
							<li><i>3、</i>享有文榜茶产品、销售、推广等方面创新思维和工具的全套培训；</li>
						</ul>
						<h4>报名方式：</h4>						
						<div class="btm_bm">
							<em>第一种：在线报名</em>
							<img id="enrolBtn" src="/img/bmbtn.png" />
							<em>第二种：电话报名</em>
							<p>联系电话：0755 - 8827 8006</p>
							<p>（周一至周五 时间：9:00-17:00）</p>
						</div>
					</div>
				</div>
			</section>
			<div class="contmain4">
			<?php include dirname(__DIR__).'/layouts/footer.php'?> 
			</div>			
		</div>
		<div class="laber_hbg" style="display: none;"></div>
		<div class="laber_enrol" style="display: none;">
			<div class="enrol_main">
				<div class="enrol_title">
					<span>联系人信息</span>
					<p>我们会在5个工作日内与您联络</p>
				</div>
				<div class="btn_qx"></div>
				<form id="formid">
					<div class="item">
						<span>姓 名：</span>
						<input name="name" id="name" type="text" />
					</div>
					<div class="item">
						<span>微信：</span>
						<input name="weixin" id="wei" type="text" />
					</div>
					<div class="item">
						<span>省份：</span>
						<input name="province" id="provinces" type="text" placeholder="请填写代理或加盟的省份" />
					</div>
					<div class="item">
						<span>城市：</span>
						<input name="city" id="city" type="text" placeholder="请填写您要代理或加盟的城市" />
					</div>
					<div class="item">
						<span>性别：</span>
						<label for="radio1" class="tg-icheck-radio tg-icheck-flat-radio">
							<input type="radio" id="radio1" name="gender" checked value="0">
							<div class="tg-icheck-media">男士</div>
						</label>
						<label for="radio2" class="tg-icheck-radio tg-icheck-flat-radio">
							<input type="radio" id="radio2" name="gender"  value="1">
							<div class="tg-icheck-media">女士</div>
						</label>					
					</div>
					<div class="item">
						<span>手机：</span>
						<input name="mobile" id="tel" type="text" />
					</div>
					<div class="item">
						<span>留言：</span>
						<textarea name="content"></textarea>
					</div>
					<a href="javascript:;" id="tj_btn"><img src="/img/tjbtn.png"></a>
				</form>
			</div>
		</div>
		<!-- 主体内容 end  -->
		<script>			
			$('#tj_btn').click(function(){
				$.ajax({
					type:"POST",
					url:"/apply/create",
					dataType: 'json',
					data: $('#formid').serialize(),
					success: function(request){
						
						if(reqeust.status!=1){
							window.location.reload();
						}
					},
					error:function(request){      
					  alert("提交失败");
					}
				});
			})			
		</script>