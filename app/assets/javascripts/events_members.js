
$(document).ready(function() {
  $("td.inscription input").click(function(case_a_cocher){

    case_a_cocher = $(this)
    inscription = case_a_cocher.is(':checked');

    // pour l'inscription event_id et member_id sont stockés dans la balise input de la case à cocher
    event_id = case_a_cocher.attr("data-event_id");
    member_id = case_a_cocher.attr("data-member_id");

    if (inscription) {

      // Inscription
      $.post("events_member_controller.php?action=create",
          {
            event_id: event_id,
            member_id: member_id
          },
          function(data){
            case_a_cocher.parent().append("<a href='events_member_controller.php?action=edit&id=" + data + "' class='edit'></a>");
            alert('Subscription saved');
          });

    } else {

      // Désinscription
      $.post("events_member_controller.php?action=destroy",
          {
            event_id: event_id,
            member_id: member_id
          },
          function(data){
            case_a_cocher.siblings().remove();
            alert('Subscription canceled');
          });
    }
  });
})
