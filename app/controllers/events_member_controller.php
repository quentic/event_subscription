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
    $smarty->assign('events',$event->actifs());

    // Récupérer les stagiaires
    $member = new Member();
    $smarty->assign('members',$member->actifs());

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

  function edit($smarty, $event_id, $member_id){
    echo($_GET['member_id']);
    $events_member = new EventsMember($_GET);

    $smarty->assign('events_member', $events_member);
    $smarty->display('edit.html');
  }

  // Enregistre les modifications d'une inscription
  function update($smarty){
      $member = new EventsMember($_GET);
      $member->update();

      // on ré-affiche la liste des stagiaires
      index($smarty);
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

    case 'edit':
      edit($smarty, $event_id, $member_id);
      break;

    case 'update':
      update($smarty);
      break;

    case 'destroy':
      destroy();
      break;

    default:
      # Affiche la page index par défaut
      index($smarty);
  }

?>
