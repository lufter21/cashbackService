//Select
$('.select').click(function () {
	var slct = $(this);
	if(!slct.hasClass('active')){
		$('.select').removeClass('active').find('.options').slideUp(121);
		slct.addClass('active').find('.options').slideDown(121);
	}
	else{
		slct.find('.options').slideUp(121,function () {
			slct.removeClass('active');
		});
	}
	return false;
});

$('.options a').click(function () {
	var fieldWrap = $(this).parent().parent();
	fieldWrap.find('span').text($(this).text());
	fieldWrap.find('input').val($(this).text());
	fieldWrap.find('.options').slideUp(121,function () {
	fieldWrap.removeClass('active');
	});
	return false;
});


//Tab
$('.tab__btn').click(function() {

	var _ = $(this);

	if(!_.hasClass('tab__btn_active')){

		$('.tab__btn').removeClass('tab__btn_active');
		$('.tab__content').slideUp(321);

		_.addClass('tab__btn_active');
		$(_.attr('href')).slideDown(321);

	}

	return false;
});