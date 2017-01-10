
$(document).ready(function() {
  $("td.inscription input").click(function(case_a_cocher){

    case_a_cocher = $(this)
    inscription = case_a_cocher.is(':checked');

    // for subscription event_id and member_id must be stored in the input tag of checkbox
    event_id = case_a_cocher.attr("data-event_id");
    member_id = case_a_cocher.attr("data-member_id");

    if (inscription) {

      // Subscription
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

      // Cancel subscription
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
