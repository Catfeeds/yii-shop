$(function(){
	$('#gfwx').mouseover(function(){
		$('.ewm').show();
	});
	$('#gfwx').mouseout(function(){
		$('.ewm').hide();
	});
	$('#enrolBtn').click(function(){
		$('.laber_hbg, .laber_enrol').show();
	});
	$('.laber_hbg, .btn_qx').click(function(){
		$('.laber_hbg, .laber_enrol').hide();
	})
})
function getData(offset,size){
	$.ajax({
		type: "GET",
		url: "/site/newslist?offset=0&size=2",
		dataType: 'json',
		success: function(reponse){
			var data = reponse.articles;
			console.log(data)
			var sum = reponse.articles.length;
			var result = '';
			
			//不够一页的数量
			if(sum - offset < size){
				size = sum - offset;
			}
			
			for(var i=offset;i<(offset + size);i++){
				result += '<div class="item"><a class="link_pic" href=""><img src="'+data[i].thumb+'"></a><span>'+data[i].title+'</span><a class="link_p" href="">'+data[i].summary+'</a></div>'
			}
			$('#news_main').append(result);
			if ( (offset + size) >= sum){
			  isEnd = true;//没有更多了
			}
		},
		error: function(xhr, type){
	      alert('加载错误');
	    }
	});
}