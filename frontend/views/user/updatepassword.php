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
									<input @blur="usedPass" v-model='logindata.mobile' type="text" name="user_name" id="user_name" placeholder="请输入旧密码" />
									<strong class="stro1">{{ logPhoneMsg }}</strong>
								</div>
								<div class="list">
									<input @blur="password" v-model='logindata.password'  type="text" name="password" id="password" placeholder="请输入新密码" />
									<strong class="stro1">{{ logPassMsg }}</strong>
								</div>
								<div class="list">
									<input @blur="password" v-model='logindata.password'  type="text" name="password" id="password" placeholder="请再次确认新密码" />
									<strong class="stro1">{{ logPassMsg }}</strong>
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
	    			logPhoneMsg:'',
	    			logPassMsg:'',
	    			logindata: {
	    				usedPass: '',
	    				password:''
	    			}
	    		},
	    		methods: {
	    			usedPass: function(){
	    				var telreg = /^(((13[0-9]{1})|(15[0-9]{1})|(18[0-9]{1}))+\d{8})$/; 
						if(this.logindata.mobile == ''){
							this.logPhoneMsg = "手机号不能为空";
							return false;
						}else if(!telreg.test($('#user_name').val())){
							this.logPhoneMsg = "请输入有效号码";
							return false;
						}else {
							this.logPhoneMsg = '';
						}
	    		   },
	    		   password: function(){
	    		   	   if(this.logindata.password == ''){
	    		   	   	    this.logPassMsg = '手机号不能为空';
	    		   	   }else {
	    		   	   	    this.logPassMsg = '';
	    		   	   }
	    		   }
	    		}
	    	})
	    </script>