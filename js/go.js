$(document).ready(function() {

	if (adBlock) {
		$('#go-block').hide();
		$('#go-warning').show();
	} else {
		var _timerNum = $('#timer-num'), i = 5;
		_timerNum.html(i);
		function runTimer() {
			if (i > 0) {
				setTimeout(runTimer, 1000);
			} else {
				window.location.href = redUrl;
			}
			_timerNum.html(i);
			i--;
		}
		runTimer();
	}

});