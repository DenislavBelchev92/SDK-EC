

/* This is needed for the callout detailed info pop window */

$(document).ready(function(){
	/* This enables the tooltip plugin */
	$('[data-toggle="tooltip"]').tooltip(); 
		
	if ($("#callout-detailed-info").hasClass( "hidden" )){
		$('#callout-panel').click(function() {
			$("#news").addClass("hidden");
			$("#callout-detailed-info").removeClass("hidden");
		});
	}
	
	$('.close').click(function() {
		$(this).parent().parent().parent().addClass("hidden");	
		$("#news").removeClass("hidden");
	});
	
});




/*
	$("#callout-detailed-info").data('hidden',true);
	
	<!-- Show detailed info -->
	if($("#callout-detailed-info").data('hidden')) {
		$("#callout-detailed-info").on("show.bs.collapse", function(){
			$("#news").addClass("hidden");
			$("#callout-detailed-info").data('hidden',false);
		});
	}
	
	<!-- hide detailed info -->
	if($("#callout-detailed-info").data('hidden')) {
		$("#callout-detailed-info").on("hide.bs.collapse", function(){
			$("#news").removeClass("hidden");
			$("#callout-detailed-info").data('hidden',false);
		});
	}
*/