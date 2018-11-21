$(document).ready(function() {
	
	// Expand Panel
	$("#open").click(function(){
		$("div#panel").slideDown("slow");
	});	
	
	// Collapse Panel
	$("#close").click(function(){
		$("div#panel").slideUp("slow");	
	});		
	
	// Switch buttons from "Log In | Register" to "Close Panel" on click
	$("#toggle a").click(function () {
		$("#toggle a").toggle();
	});		
		
        // Lateral Menu Sliding
        $("#dock li").hover(function() {
	        $(this).find("ul").animate({left:"0px"}, 600);
           }, function(){
		$(this).find("ul.free").animate({left:"-181px"}, 600);
	}); 
});