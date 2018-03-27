		<!-- 导航 end -->
		<!-- 主体内容 start  -->
		<div class="container2" id="addressList">
            <section class="laber_shopUser">
            	<div class="shopUser auto clearfix">
            		<div class="shopUser_main">
            			<p>您好，15038384758</p>
            			<ul>
            				<li><a href="">密码管理</a></li>
            				<li><a href="">购物车</a></li>
            				<li><a href="">收货地址</a></li>
            				<li><a href="">我的订单</a></li>
            			</ul>
            		</div>
            	</div>
            </section>
            <section class="laber_shop">
            	<div class="shop auto clearfix">
            		<div class="shop_main" style="margin-bottom: 466px;">
            			<span>收货地址：</span>
            			<table border="0" cellspacing="0" cellpadding="0">
            				<tr class="tr1">
            					<th style="padding-left:20px; width:262px;" class="td2">收件人姓名</th>
            					<th style="width: 562px;" class="td3">详细地址</th>
            					<th style="width: 232px;" class="td4">联系电话</th>
            					<th class="td4">操作</th>
            				</tr>
            				<tr v-for="addList in addressData" class="tr2">
            					<td  style="padding-left:20px; width:262px;" class="td2">{{ addList.consignee }}</td>
            					<td style="width: 562px;" class="td3">{{ addList.province }} {{ addList.city }} {{ addList.district }} {{ addList.address }}</td>
            					<td style="width: 232px;" class="td4">{{ addList.mobile }}</td>
            					<td class="td4"><p>编辑</p><p>删除</p></td>
            				</tr>
            			</table>
            			<div class="tj">
            				<a href="javascript:;">添加新地址</a>
            			</div>
            		</div>
            	</div>
            </section>
			<div>
				<?php include dirname(__DIR__).'/layouts/footer.php'?> 
			</div>			
		</div>
		<!-- 主体内容 end  -->
	</body>
	<script src="https://cdn.jsdelivr.net/npm/vue"></script>
	<script type="text/javascript" src="/js/axios.min.js" ></script>
	<script type="text/javascript">
        var shop = new Vue({
       	    el: '#addressList',
       	    data: {
       	    	addressData:[]
       	    },
       	    created: function(){
       	    	var _this = this;
       	    	$.ajax({
       	    		type:"get",
       	    		url:"/address/getlist",
       	    		async:true,
       	    		success: function(data) {
		                if(data.status == 0){
		                    console.log('数据获取成功');		                   
		                    _this.addressData = data.data;
		                    console.log(_this.addressData);	                  
		                }	                 	
		            }
       	    	});      	    	   		    	
       	    },
        })
	</script>