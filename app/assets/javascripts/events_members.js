
$(document).ready(function() {
	$("td.inscription input").click(function(){

		inscription = $(this).is(':checked');
		if (inscription) {
      event_id = $(this).attr("data-event_id");
      member_id = $(this).attr("data-member_id");

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
      id = $(this).attr("id");

      // Désinscription
      $.post("events_member_controller.php?action=destroy",
          {
            id: id
          },
          function(data, status){
            alert('Désinscription ' + (status=='success' ? '' : 'non ') + 'enregistrée');
          });
		}
	});

})
