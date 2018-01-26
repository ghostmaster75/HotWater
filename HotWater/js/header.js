$('#menubox').hide();
$('.headlogo').click(function() {
	$('#menubox').slideToggle("fast");
	$('#menuarrow').toggleClass("fa-angle-up", "fa-angle-down");
});

$(document).mouseup(function(e) {
	var container = $('#menubox');
	var menubtn = $('.headlogo');
	var menuarrow = $('#menuarrow');

	if (!container.is(e.target) && container.has(e.target).length === 0 && !menubtn.is(e.target) && menubtn.has(e.target).length === 0) {
		container.slideUp("fast");
		menuarrow.toggleClass("fa-angle-up", "fa-angle-down");
	}
});