
$(document).ready(function() {
	$("input.inscrire").click(function(){
		stage_id = $(this).attr("data-stage-id");
		member_id = $(this).attr("data-member-id");

		inscription = $(this).is(':checked');
		if (inscription) {
			alert("inscription enregistrée");
			window.location.href = "events_member_controller.php?action=create&stage_id=" + stage_id + "&member_id=" + member_id ;
		} else {
			alert("désinscription enregistrée");
			window.location.href = "events_member_controller.php?action=delete&stage_id=" + stage_id + "&member_id=" + member_id ;
		}
	})
})
