$(document).ready(function () {
	$('#shops-form select').change(function () {
		$('#shops-form').submit();
	});

	$('#coupons-form input').change(function () {
		if (!$(this).attr('name')) {
			$(this).closest('tr').find('input').each(function () {
				$(this).attr('name', $(this).attr('data-name'));
			});
		}
	});
});