		<div class="container2" id="logins">
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
									<input v-model='logindata.old_password' type="text" name="old_password" id="old_password" placeholder="请输入旧密码" />
									<strong class="stro1">{{ oldMsg }}</strong>
								</div>
								<div class="list">
									<input @blur="password1" v-model='logindata.password'  type="text" name="password" id="password" placeholder="请输入新密码" />
									<strong class="stro1">{{ newMsg1 }}</strong>
								</div>
								<div class="list">
									<input @blur="password2" v-model='password2'  type="text" name="password" id="password" placeholder="请再次确认新密码" />
									<strong class="stro1">{{ newMsg2 }}</strong>
								</div>
								<button style="margin: 76px 0 322px;" type="button" :disabled="disabled2" class="immediately" :class="{active1: isactive1, active2: isactive2}">保存修改</button>
							</form>
						</div>
					</div>
				</div>
			</section>
			<div>
				<?php include dirname(__DIR__).'/layouts/footer.php'?> 
			</div>
		</div>
		<!-- 主体内容 end  -->
		<script src="https://cdn.jsdelivr.net/npm/vue"></script>
	    <script type="text/javascript" src="/js/axios.min.js" ></script>
	    <script type="text/javascript">
	    	var logins = new Vue({
	    		el: '#logins',
	    		data: {
	    			disabled2: true,
	    			isactive1: false,
				    isactive2: true,
	    			oldMsg:'',
	    			newMsg1:'',
	    			newMsg2:'',
	    			password2: '',
	    			logindata: {
	    				old_password: '',
	    				password:''
	    			}
	    		},
	    		methods: {
	    		    //验证密码
					password1:function(){
						if(this.datainfo.password == ''){
							this.newMsg1 = '新密码不能为空！';
							return false;
						}else if(this.datainfo.password.length < 6 || this.datainfo.password.length > 12){
							this.newMsg1 = '您输入6-12位密码';
							return false;
						}else {
							this.newMsg1 = '';
						}
					},
					//验证再次输入密码
					password2:function(){
						if(this.password2 == ''){
						    this.newMsg2 = '新密码不能为空！';	
						    return false;
						}else if(this.password2 != this.datainfo.password){
							this.newMsg2 = '两次输入密码保持一致';
							return false;
						}else{
							this.newMsg2 = '';
						}
					}
	    		}
	    	})
	    </script>