var url='tchatAjax.php';
var lastid=0;
var timer = setInterval(getMessages,5000);

$(function(){
	$('#tchatForm form').submit(function(){
		clearInterval(timer);
		showLoader('#tchatForm');
		var message = $('#tchatForm form input[name=message]').val();
		$.post(url,{action:"addMessage", message:message},function(data){
			if(data.erreur=='ok'){
				getMessages();
				$('#tchatForm form input[name=message]').val('');
			}
			else{
				alert(data.erreur);
			}
			timer = setInterval(getMessages,5000);
			hideLoader('#tchatForm');
		},'json');
		return false;
	});
});

$(function(){
	$('#tchatFormRefresh form').submit(function(){
		refreshTchat(html);
	});
});

function getMessages(){
	$.post(url,{action:"getMessages", lastid:lastid},function(data){
	if(data.erreur=='ok'){
		$('#tchat').append(data.result);
		lastid=data.lastid;
	}
	else{
		alert(data.erreur);
	}
	hideLoader('#tchatForm');
	},'json');
	return false;
}

function showLoader(div){
	$(div).append('<div class="loader"></div>');
	$('.loader').fadeTo(500,0.6);
}

function hideLoader(div){
	$('.loader').fadeOut(500,function(){
		$('.loader').remove();
	});
}

function refreshTchat(data){
	$("#tchat").empty();
	$("#tchat").append(data);
}