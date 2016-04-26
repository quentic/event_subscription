
$(document).ready(function() {
	$("td.inscription input").click(function(){
		event_id = $(this).attr("data-event-id");
		member_id = $(this).attr("data-member-id");

		inscription = $(this).is(':checked');
		if (inscription) {
      // Inscription
      $.post("events_member_controller.php?action=create",
          {
            event_id: event_id,
            member_id: member_id
          },
          function(data, status){
            alert('Inscription ' + (status=='success' ? '' : 'non ') + 'enregistrée');
          });
          
		} else {
      // Désinscription
      $.post("events_member_controller.php?action=destroy",
          {
            event_id: event_id,
            member_id: member_id
          },
          function(data, status){
            alert('Désinscription ' + (status=='success' ? '' : 'non ') + 'enregistrée');
          });	
		}
	})
})
