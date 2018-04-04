		<div class="container2" id="update">
			<section class="laber_shopUser">
            	<div class="shopUser auto clearfix">
            		<div class="shopUser_main">
            			<p>您好，15038384758</p>
            			<ul>
            				<li class="on"><a href="">密码管理</a></li>
            				<li><a href="/cart/index">购物车</a></li>
            				<li><a href="/address/index">收货地址</a></li>
            				<li><a href="/order/list">我的订单</a></li>
            			</ul>
            		</div>
            	</div>
            </section>
			<section class="laber_login">
				<div class="login auto clearfix">
					<div class="login_main">
						<div class="login_center">
							<h1>修改密码</h1>
							<form id="form">
								<div class="list">
									<input @blur="oldPassword" v-model='updataPass.old_password' type="text" name="old_password" id="old_password" placeholder="请输入旧密码" />
									<strong class="stro1">{{ oldMsg }}</strong>
								</div>
								<div class="list">
									<input @blur="password1" v-model='updataPass.password'  type="text" name="password" id="password" placeholder="请输入新密码" />
									<strong class="stro1">{{ newMsg1 }}</strong>
								</div>
								<div class="list">
									<input @blur="pass" v-model='password2'  type="text" name="password" id="password" placeholder="请再次确认新密码" />
									<strong class="stro1">{{ newMsg2 }}</strong>
								</div>
								<button @click="keep" style="margin: 76px 0 322px;" type="button" :disabled="disabled2" class="immediately" :class="{active1: isactive1, active2: isactive2}">保存修改</button>
							</form>
						</div>
					</div>
				</div>
			</section>
			<div>
				<?php include dirname(__DIR__).'/layouts/footer.php'?> 
			</div>
			<div v-show="carShow" id="carBg" class="carBg"></div>
			<div v-show="popupShow" id="carPopup" class="carPopup">
				<span>密码修改成功</span>
				<div class="linkShop">
					<a @click="confirm" href="javascript:;">确定</a>
				</div>
			</div>
		</div>
		<!-- 主体内容 end  -->
		<script src="https://cdn.jsdelivr.net/npm/vue"></script>
	    <script type="text/javascript" src="/js/axios.min.js" ></script>
	    <script type="text/javascript">
	    	new Vue({
	    		el: '#update',
	    		data: {
	    			disabled2: true,
	    			isactive1: false,
				    isactive2: true,
				    carShow: false,
				    popupShow: false,
	    			oldMsg:'',
	    			newMsg1:'',
	    			newMsg2:'',
	    			password2: '',
	    			updataPass: {
	    				old_password: '',
	    				password:''
	    			}
	    		},
	    		methods: {
	    			oldPassword: function(){
	    				if(this.updataPass.old_password == ''){
							this.newMsg1 = '新密码不能为空！';
							return false;
						}else if(this.updataPass.old_password.length < 6 || this.updataPass.old_password.length > 12){
							this.newMsg1 = '您输入6-12位密码';
							return false;
						}else {
							this.newMsg1 = '';
							this.disabled2 = false;
							this.isactive1 = true;
							this.isactive2 = false;
						}
	    			},
	    		    //验证密码
					password1:function(){
						if(this.updataPass.password == ''){
							this.newMsg1 = '新密码不能为空！';
							return false;
						}else if(this.updataPass.password.length < 6 || this.updataPass.password.length > 12){
							this.newMsg1 = '您输入6-12位密码';
							return false;
						}else {
							this.newMsg1 = '';
						}
					},
					//验证再次输入密码
					pass:function(){
						if(this.password2 == ''){
						    this.newMsg2 = '新密码不能为空！';	
						    return false;
						}else if(this.password2 != this.updataPass.password){
							this.newMsg2 = '两次输入密码保持一致';
							return false;
						}else{
							this.newMsg2 = '';
						}
					},
					keep: function(){
						var _this = this;
						_this.oldPassword();
						_this.password1();
						_this.pass();
						$.ajax({
			                url: '/user/updatepwd',
			                type: 'POST',
			                dataType: 'json',
			                data: {old_password: _this.updataPass.old_password, password: _this.updataPass.password},
			                success: function(data) {
			                	if(data.status == 0){
			                		console.log('获取成功');
			                		_this.carShow = true;
			                		_this.popupShow = true;	
			                	}else if(data.status == 1){
			                		console.log('修改失败');
			                	}else if(data.status == 2){
			                		console.log('登录过期');
			                	}else{
			                		console.log('数据错误');
			                	}       	
			                }
			            })
					},
					confirm: function(){
						window.location = '/goods/list';
					}
	    		}
	    	})
	    </script>