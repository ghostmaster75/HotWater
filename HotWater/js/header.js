$('#menubox').hide();
$('.headlogo').click(function() {
	$('#menubox').slideToggle("fast");
});

$(document).mouseup(function(e) {
	var container = $('#menubox');
	var menubtn = $('.headlogo');

	if (!container.is(e.target) && container.has(e.target).length === 0 && !menubtn.is(e.target) && menubtn.has(e.target).length === 0) {
		container.slideUp("fast");
	}
});