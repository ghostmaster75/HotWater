$("#menu li").click(function() {
	icon = $(this).children('i').clone();
	$("#titleicon").html(icon);
	$("#titlelabel").text($(this).text());
	$("#menubox").slideUp("fast");
	$('#menuarrow').toggleClass("fa-angle-up", "fa-angle-down");
});