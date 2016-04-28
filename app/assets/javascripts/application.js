
$(document).ready(function() {

  // Affiche les calendriers
  $.datepicker.setDefaults({
      showMonthAfterYear: true,
      changeYear: true
  });
  $.datepicker.setDefaults( $.datepicker.regional['fr'] );
  $("input[type=date]").datepicker({ dateFormat: "yy-mm-dd" });

})
