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
		url: '/site/newslist?offset='+offset+'&size='+size,
		dataType: 'json',
		success: function(reponse){
			var data = reponse.articles;
			console.log(data)
			var sum = reponse.articles.length;
			var result = '';

			
			for(var i=0; i< sum; i++){
				result += '<div class="item"><a class="link_pic" href="'/site/detail?id='+data[i].id"><img src="'+data[i].thumb+'"></a><span>'+data[i].title+'</span><a class="link_p" href="">'+data[i].summary+'</a></div>'
			}
			$('#news_main').append(result);
			 /*隐藏more按钮*/
            if ( sum < size){
                $(".mores").hide();
            }else{
                $(".mores").show();
            }
		},
		error: function(xhr, type){
	      alert('加载错误');
	    }
	});
}