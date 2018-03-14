<?php 
use yii\helpers\Url;
?>
<div class="container2" id="regist">
			<section class="laber_login">
				<div class="login auto clearfix">
					<div class="login_main">
						<div class="login_center">
							<h1>文榜用户注册</h1>
							<form>
								<div class="list">
									<input @blur="checkphone" type="text" v-model="datainfo.mobile" id="mobile" placeholder="请输入您的手机号码" />
									<strong class="stro1">{{ msgTel }}</strong>
								</div>
								<div class="list">
									<input class="txm" type="text" name="tx_password" id="tx_password" placeholder="请输入图形验证码" />
									<img @click="btnTxm" class="img_txm" :src="txmImg" alt="图形码" />
									<strong class="stro1">{{ msgtx }}</strong>
								</div>
								<div class="list">
									<input  class="txm" type="text" name="dx_password" id="dx_password" placeholder="请输入短信验证码" />
									<button id="btnText" @click="oBtn" type="button">
										<span v-if="sendMsgDisabled">{{ '重新发送' + time }}</span>
										<span v-if="!sendMsgDisabled">发送验证码</span>
									</button>
									<strong class="stro1">{{ msgdx }}</strong>
								</div>
								<div class="list">
									<input @blur="checkpass" type="text" v-model="datainfo.password" name="password" id="password" placeholder="请输入您的6至12位登录密码" />
									<strong class="stro1">{{ msgpass }}</strong>
								</div>
								<div class="list">
									<input @blur="checkpas" type="text" v-model="pas" name="password" id="pass" placeholder="请再次输入您的登录密码" />
									<strong class="stro1">{{ msgpas }}</strong>
								</div>
								<a href="#" class="forget">忘记密码?</a>
								<a @click="register" href="javascript:;" class="immediately">立即登录</a>
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
	<script src="https://cdn.jsdelivr.net/npm/vue"></script>
	<script type="text/javascript" src="/js/axios.min.js" ></script>
	<script type="text/javascript">
		regi.prototype.createdCode = function(){
			code = ""; 
		    var codeLength = 4;//验证码的长度 
		    var random = new Array(0,1,2,3,4,5,6,7,8,9,'A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R', 
		       'S','T','U','V','W','X','Y','Z');//随机数 
		    for(var i = 0; i < codeLength; i++) {
		     //循环操作 
		     var index = Math.floor(Math.random()*36);//取得随机数的索引（0~35） 
		     code += random[index];//根据索引取得随机数加到code上 
		    } 
		    this.txmImg = '/site/sendmsg' + code;//把code值赋给验证码 
		}
		var regi = new Vue({
			el: "#regist",
			data: {
				time: 60,
				sendMsgDisabled: false,
				msgTel: '',				
				msgtx: '',
				msgdx: '',				
				msgpass: '',
				pas: '',
				msgpas: '',
				datainfo: {
					mobile: '',
					password: ''
				},
				txmImg: ''
			},
			methods: {
				btnTxm: function(){    //点击刷新图片
					this.createdCode();
				},
				//验证手机号
				checkphone:function(){
					var telreg = /^(((13[0-9]{1})|(15[0-9]{1})|(18[0-9]{1}))+\d{8})$/; 
					if(this.datainfo.mobile == ''){
						this.msgTel = "手机号不能为空";
						return false;
					}else if(!telreg.test($('#mobile').val())){
						this.msgTel = "请输入有效号码";
						return false;
					}else {
						this.msgTel = '';
					}
				},
				//验证密码
				checkpass:function(){
					if(this.datainfo.password == ''){
						this.msgpass = '密码不能为空！';
						return false;
					}else if(this.datainfo.password.length < 6 || this.datainfo.password.length > 12){
						this.msgpass = '您输入的密码不合法';
						return false;
					}else {
						this.msgpass = '';
					}
				},
				//验证再次输入密码
				checkpas:function(){
					if(this.pas == ''){
					    this.msgpas = '密码不能为空！';	
					    return false;
					}else if(this.pas != this.datainfo.password){
						this.msgpas = '输入密码保持一致';
						return false;
					}else{
						this.msgpas = '';
					}
				},				
				register: function(){
					this.checkphone();
					this.checkpass();
					this.checkpas();
					$.ajax({
		                url: '/site/signup',
		                type: 'POST',
		                dataType: 'json',
		                data: this.datainfo,
		                success: function(data) {
		                    console.log('注册成功')
		                }
		            })
				},
				//验证码倒计时
				
				oBtn: function(){
				  var _this = this;
                  if(!_this.sendMsgDisabled){
                  	var setTime = setInterval(function(){
                  		_this.time--;
                  		if(_this.time <= 0){
                  			_this.time = 60;
                  			_this.sendMsgDisabled = false;
                  			clearInterval(setTime);
                  		}
                  		console.log(_this.time)
                  	},1000)
                  }                  
                  _this.sendMsgDisabled = true;
				}
			}
		})
	</script>