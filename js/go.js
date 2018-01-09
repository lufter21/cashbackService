$(document).ready(function() {

	if (adBlock || unknownUser) {
		$('#go-block').hide();
		$('#go-warning').show();
	} else {
		var TimerNum = $('#timer-num'),
		i = 5;

		TimerNum.html(i);
		
		function runTimer() {
			if (i > 0) {
				setTimeout(runTimer, 1000);
			} else {
				window.location.href = redUrl;
			}
			TimerNum.html(i);
			i--;
		}
		runTimer();
	}

});