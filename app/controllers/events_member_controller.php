<?php
require('../../config/database.php');
require('../../config/smarty.php');

# initialisations propres à ce controleur
# Accès aux vues
$smarty->setTemplateDir('../../app/views/events_members');
# Accès aux modèles
require('../models/event.php');
require('../models/events_member.php');
?>

<?php

  # Displays all subscriptions for active events and active members
  function index(){
    global $smarty;

    # Gets active events
    $event = new Event();
    $smarty->assign('events',$event->actifs());

    # Gets subscriptions
    $events_member = new EventsMember();
    $smarty->assign('subscriptions', $events_member->all( $event->actifs() ));
    $smarty->display('index.html');
  }

  # Associates member <=> event
  function create(){
    $inscription = new EventsMember($_POST['event_id'], $_POST['member_id']);
    $event_member_id = $inscription->associer();

    # outputs this, so that event_members.js AJAX call is able to collect this value in its "data" parameter
    echo $event_member_id;
  }

  # Displays subscription edit page
  function edit(){
    global $smarty;

    $events_member = new EventsMember($_GET);

    $smarty->assign('events_member', $events_member);
    $smarty->display('edit.html');
  }

  # Updates subscription
  function update(){
    global $smarty;

    $member = new EventsMember($_GET);
    $member->update();

    # Displays subscriptions
    header( "Location: events_member_controller.php" );
  }

  # détruit l'association membre <=> stage
  function destroy(){
    $desinscription = new EventsMember($_POST['event_id'], $_POST['member_id']);
    $desinscription->dissocier();
  }

  function liste_emails(){
    global $smarty;

    # Récupère le stage dont on veut la liste des inscrits
    $event = new Event($_GET["event_id"]);

    # Récupère les inscriptions
    $events_member = new EventsMember();
    $smarty->assign('liste_emails', $events_member->inscrits_au_stage( $event->id ));
    $smarty->display('liste_emails.html');
  }

?>

<?php
  # récupère les paramètres action et id dans l'URL, s'ils existent
  $action = isset($_GET['action']) ? $_GET['action'] : '';
  $id = isset($_GET['id']) ? $_GET['id'] : '';

  # analyse l'action demandée
  switch ($action) {
    case 'liste_emails':
      liste_emails();
      break;
    default:
      require('application.php');
  }

?>
