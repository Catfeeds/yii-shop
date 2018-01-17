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
