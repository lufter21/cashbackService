$(document).ready(function(){
	
	$('.upd-cats tr').click(function(){
		if(!$(this).hasClass('checked')){
			var rowId = $(this).attr('data-id');
			
			var cellNav = $('#nav'+rowId).text();
			$('#nav'+rowId).html('<input type="text" name="param['+rowId+'][nav]" value="'+cellNav+'">');
			
			var cellKeys = $('#key_s'+rowId).text();
			$('#key_s'+rowId).html('<input type="text" name="param['+rowId+'][key_s]" value="'+cellKeys+'">');
			
			var cellName = $('#name'+rowId).text();
			$('#name'+rowId).html('<input type="text" name="param['+rowId+'][name]" value="'+cellName+'">');
			
			var cellTitle = $('#title'+rowId).text();
			$('#title'+rowId).html('<input type="text" name="param['+rowId+'][title]" value="'+cellTitle+'">');
			
			var cellDescription = $('#description'+rowId).text();
			$('#description'+rowId).html('<textarea name="param['+rowId+'][description]">'+cellDescription+'</textarea>');
			
			var cellText = $('#text'+rowId).text();
			$('#text'+rowId).html('<textarea name="param['+rowId+'][text]">'+cellText+'</textarea>');
			
			var cellCat = $('#category'+rowId).text();
			$('#category'+rowId).html('<input type="text" name="param['+rowId+'][category]" value="'+cellCat+'">');
			
			$('#id'+rowId).prepend('<input type="checkbox" name="del_cat[]" value="'+rowId+'">');
			
			$(this).addClass('checked');
		}
	});
	
	$('#fixed-top-btn').click(function(){
		$('#fixed-top-block').stop().animate({top:0},321);
		$(this).hide();
		return false;
	});
	$('#fixed-top-close').click(function(){
		$('#fixed-top-block').stop().animate({top:"-221px"},321);
		$('#fixed-top-btn').show();
		return false;
	});
	
	$('#shops-form select').change(function(){
		$('#shops-form').submit();
	});
	
});