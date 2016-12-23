
$(document).ready(function() {
	$("input.js_masque").click(function(){

    // member_id est stocké dans l'id de la balise input de la case à cocher
    member_id = $(this).attr("id");

		masquer = $(this).is(':checked');

		if (masquer) {
      // Masquer
      $.post("member_controller.php?action=update_masque&id=" + member_id,
          {
            masque: 1
          },
          function(data, status){
            alert('Stagiaire masqué ' + (status=='success' ? 'bien ' : 'non ') + 'enregistré');
          });


		} else {
      // Démasquer
      $.post("member_controller.php?action=update_masque&id=" + member_id,
          {
            id: member_id,
            masque: 0
          },
          function(data, status){
            alert('Stagiaire non masqué ' + (status=='success' ? 'bien ' : 'non ') + 'enregistré');
          });
		}
	});

})
