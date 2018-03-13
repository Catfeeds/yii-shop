		<div class="container2">
			<section class="laber_login">
				<div class="login auto clearfix">
					<div class="login_main">
						<div class="login_center">
							<h1>文榜用户登录</h1>
							<form id="form">
								<div class="list">
									<input type="text" name="user_name" id="user_name" placeholder="请输入您的手机号码" />
									<strong class="stro1">您输入的手机号码有误</strong>
								</div>
								<div class="list">
									<input type="text" name="password" id="password" placeholder="请输入您的密码" />
									<strong class="stro1">您输入的密码有误</strong>
								</div>
								<a href="#" class="forget">忘记密码?</a>
								<a href="javascript:;" class="immediately">立即登录</a>
								<p>若您没有账号，可点击这里<a href="#">注册</a></p>
								<div class="qt">
									<b class="b1"></b>
									<p>其它方式登录</p>
									<b class="b2"></b>
								</div>
								<div class="dsf">
									<a href="<?=$qqUrl?>" class="a_fl">
										<i class="i1"></i>
										QQ登录
									</a>
                                    <a href="<?=$weixinUrl?>" class="a_fr">
										<i class="i2"></i>
										微信登录
									</a>
								</div>
							</form>
						</div>
					</div>
				</div>
			</section>
			<div class="contmain7">
				<?php include dirname(__DIR__).'/layouts/footer.php'?> 
			</div>			
		</div>