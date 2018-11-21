$(document).ready(function() {

	$(".tabmenumenu > li").click(function(e){
		var index = 1;
		
		var daDiv = document.getElementById("tabP" + index);
		while (daDiv != null)
		{
			var daRealId = "tabP" + index;
			if (e.target.id == daRealId)
			{
				$("#" + daRealId).addClass("active");
				$("div." + daRealId).fadeIn();
			}
			else
			{
				$("#" + daRealId).removeClass("active");
				$("div." + daRealId).css("display", "none");
			}
			
			index++;
			daDiv = document.getElementById("tabP" + index);
		}

		return false;
	});


});