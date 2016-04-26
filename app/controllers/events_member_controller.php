<?php

require('../../config/database.php');
require('../../config/smarty.php');

// initialisations propres à ce controleur
$smarty->setTemplateDir('../../app/views/events_members');
require('../models/event.php');
require('../models/member.php');
require('../models/events_member.php');
?>

<?php

  function index($smarty){
    // Récupérer les stages
    $event = new Event();
    $smarty->assign('events',$event->all());

    // Récupérer les stagiaires
    $member = new Member();
    $smarty->assign('members',$member->all());

    // Récupérer les inscriptions
    $events_member = new EventsMember();
    $smarty->assign('subscriptions', $events_member->all());

    $smarty->display('index.html');
  }

  $event_id = $_GET['event_id'];
  $member_id = $_GET['member_id'];

  switch ($_GET['action']) {
    case 'create':
      # créer l'association membre <=> stage
      $inscription = new EventsMember();
      $inscription->associer($event_id, $member_id);

      # Affiche la page index
      index($smarty);
      break;

    case 'destroy':
      # détruire l'association membre <=> stage
      $desinscription = new EventsMember();
      $desinscription->dissocier($event_id, $member_id);

      # Affiche la page index
      index($smarty);
      break;

    default:
      # Affiche la page index par défaut
      index($smarty);
  }

?>
