<?php
require('../../config/database.php');
require('../../config/smarty.php');

# Initializations specific to this controller
# Access to views
$smarty->setTemplateDir('../../app/views/events_members');
# Access to model
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

  # Destroys subscription
  function destroy(){
    $events_member = new EventsMember($_POST['event_id'], $_POST['member_id']);
    $events_member->dissocier();
  }

?>
