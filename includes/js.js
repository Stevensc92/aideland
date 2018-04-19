$(function(){
	$('#refreshCaptcha form').submit(function(){
		refreshCaptcha(html);
	});
});

function refreshCaptcha(data){
	$('#refreshCaptcha').empty();
}