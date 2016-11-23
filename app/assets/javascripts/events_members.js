
$(document).ready(function() {
	$("td.inscription input").click(function(){

		inscription = $(this).is(':checked');
		if (inscription) {
      // pour l'inscription event_id et member_id sont stockés dans la balise input de la case à cocher
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
      // pour la désinscription l'id de events_members est l'id de la balise input de la case à cocher
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
