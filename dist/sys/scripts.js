$(document).ready(function () {
	$('#shops-form select').change(function () {
		$('#shops-form').submit();
	});

	$('#coupons-form input[type="checkbox"]').change(function () {
		if (!$(this).attr('name')) {
			$(this).closest('tr').find('input[type="checkbox"]').each(function () {
				$(this).attr('name', $(this).attr('data-name'));
			});
		}
	});

	$('#coupons-form input[type="text"]').change(function () {
		if (!$(this).attr('name')) {
			$(this).attr('name', $(this).attr('data-name'));
		}
	});
});