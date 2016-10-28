$(function() {
	$('main').scrollTop($('#last').length?$('#last').offset().top:0);
	$('.login-text').click(function(){
		var target = '[data-id='+$(this).attr('id')+']';
		$('.login-box').addClass('closed');
		$(target).removeClass('closed');
	});
});