		<div class="container2" id="logins">
			<section class="laber_login">
				<div class="login auto clearfix">
					<div class="login_main">
						<div class="login_center">
							<h1>文榜用户登录</h1>
							<form id="form">
								<div class="list">
									<input @blur="phone" v-model='logindata.mobile' type="text" name="user_name" id="user_name" placeholder="请输入您的手机号码" />
									<strong class="stro1">{{ logPhoneMsg }}</strong>
								</div>
								<div class="list">
									<input @blur="password" v-model='logindata.password'  type="password" name="password" id="password" placeholder="请输入您的密码" />
									<strong class="stro1">{{ logPassMsg }}</strong>
								</div>
								<a href="#" class="forget">忘记密码?</a>
								<a @click="login" href="javascript:;" class="immediately">立即登录</a>
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
			<div v-show="carShow" id="carBg" class="carBg"></div>
			<div v-show="popupShow" id="carPopup" class="carPopup">
				<i @click="carQx"></i>
				<span>登录成功！</span>
				<div class="linkShop">
					<a href="javascript:;">确定</a>
				</div>
			</div>			
		</div>
		<script src="https://cdn.jsdelivr.net/npm/vue"></script>
	    <script type="text/javascript" src="/js/axios.min.js" ></script>
	    <script type="text/javascript">
	    	var logins = new Vue({
	    		el: '#logins',
	    		data: {
	    			carShow: false,
	    			popupShow: false,
	    			logPhoneMsg:'',
	    			logPassMsg:'',
	    			logindata: {
	    				mobile: '',
	    				password:''
	    			},
	    			mobile:''
	    		},
	    		methods: {
	    			carQx: function(){
	    				this.carShow = false;
	    			    this.popupShow = false;
	    			},
	    			phone: function(){
	    				var telreg = /^(((13[0-9]{1})|(15[0-9]{1})|(18[0-9]{1}))+\d{8})$/; 
						if(this.logindata.mobile == ''){
							this.logPhoneMsg = "手机号不能为空";
							return false;
						}else if(!telreg.test(this.logindata.mobile)){
							this.logPhoneMsg = "请输入有效号码";
							return false;
						}else {
							this.logPhoneMsg = '';
						}
	    		   },
	    		   password: function(){
	    		   	   if(this.logindata.password == ''){
	    		   	   	    this.logPassMsg = '密码不能为空';
	    		   	   }else {
	    		   	   	    this.logPassMsg = '';
	    		   	   }
	    		   },
	    		   login: function(){
	    		   	    var _This = this;
	    		   	    _This.phone();
	    		   	    $.ajax({
			                url: '/site/login',
			                type: 'POST',
			                dataType: 'json',
			                data: _This.logindata,
			                success: function(data) {
			                	if(data.status == 0){
			                		console.log(data);
			                		_This.carShow = true;
	    			    			_This.popupShow = true;
			                	}else{
			                		_This.logPassMsg = '账号或密码错误！';
			                	}			                    
			                }
			            })
	    		   }
	    		}
	    	})
	    </script>