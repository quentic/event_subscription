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

  # Affiche l'ensemble des inscriptions pour les stages actifs et les membres actifs
  function index($smarty){
    # Récupérer les stages
    $event = new Event();
    $smarty->assign('events',$event->actifs());

    # Récupérer les inscriptions
    $events_member = new EventsMember();
    $smarty->assign('subscriptions', $events_member->all($event->actifs()));
    $smarty->display('index.html');
  }

  # créer l'association membre <=> stage
  function create(){
    $inscription = new EventsMember($_POST['event_id'], $_POST['member_id']);
    $inscription->associer();
  }

  # Affiche la page de modification d'une inscription
  function edit($smarty){
    $events_member = new EventsMember($_GET);

    $smarty->assign('events_member', $events_member);
    $smarty->display('edit.html');
  }

  # Enregistre les modifications d'une inscription
  function update($smarty){
      $member = new EventsMember($_GET);
      $member->update();

      # Ré-affiche la liste des inscriptions
      header( "Location: events_member_controller.php" );
  }

  # détruit l'association membre <=> stage
  function destroy(){
    $desinscription = new EventsMember($_POST);
    $desinscription->dissocier();
  }

  # analyse l'action demandée
  switch ($_GET['action']) {
    case 'create':
      create();
      break;

    case 'edit':
      edit($smarty);
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
