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

  function create(){
    # créer l'association membre <=> stage
    $inscription = new EventsMember($_POST);
    $inscription->associer();
  }

  function destroy(){
    # détruire l'association membre <=> stage
    $desinscription = new EventsMember($_POST);
    $desinscription->dissocier();
  }


  // analyse l'action demandée
  switch ($_GET['action']) {
    case 'create':
      create();
      break;

    case 'destroy':
      destroy();
      break;

    default:
      # Affiche la page index par défaut
      index($smarty);
  }

?>
