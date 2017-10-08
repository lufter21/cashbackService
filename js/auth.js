function socAuth(data) {
	if(data){
		console.log(data);
		$.ajax({
			url:"functions/auth.php",
			type:"POST",
			dataType:"json",
			data: 'token='+ data, 
			success: function(response){
				$('#js_auth_msg').empty().append('<span>'+ response.msg +'</span>');
				if (response.msg == 'login') {
					window.location.reload();
				}
			},
			error: function() {
				alert('js:Error');
			} 
		});
	}
}


$(document).ready(function(){
	Form.submit('#js-login-form, #js-registration-form', function(form) {
		var _f = $(form);
		$.ajax({
			url: _f.attr('action'),
			type:"POST",
			dataType:"json",
			data: _f.serialize(),
			success: function(response){
				$('#js_auth_msg').empty().append('<span>'+ response.msg +'</span>');
				if (response.msg == 'login') {
					window.location.reload();
				}
			},
			error: function() {
				alert('js:Error');
			}
		});
	});
});