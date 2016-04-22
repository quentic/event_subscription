
$(document).ready(function() {
	$("input.inscrire").click(function(){
		event_id = $(this).attr("data-event-id");
		member_id = $(this).attr("data-member-id");

		inscription = $(this).is(':checked');
		if (inscription) {
			alert("inscription enregistrée");
			window.location.href = "events_member_controller.php?action=create&event_id=" + event_id + "&member_id=" + member_id ;
		} else {
			alert("désinscription enregistrée");
			window.location.href = "events_member_controller.php?action=delete&event_id=" +event_id + "&member_id=" + member_id ;
		}
	})
})
