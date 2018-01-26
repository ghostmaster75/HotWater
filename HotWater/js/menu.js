$("#menu li").click(function() {
	$("#label").text($(this).text());
	$("#menubox").slideUp("fast");
	$('#menuarrow').toggleClass("fa-angle-up", "fa-angle-down");
});