$(document).ready(function(){
	$('#inne button').click(function(){
		var data = {
			author: $('input[name=name]').val(),
			post: $('textarea').val()
		}
		$.post('/post', data, function(data){
			$('#usse').html(data);
			$('textarea').val('').focus();
		});
	});
	var aktualisiere = function() {
		$.get('/post', function(data){
			$('#usse').html(data);
		});
	}
	window.setInterval("aktualisiere()", 3000);
});