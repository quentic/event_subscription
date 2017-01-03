<?php
require('../../config/database.php');
require('../../config/smarty.php');

# initialization specific to this controller
# Access to views
$smarty->setTemplateDir('../../app/views/events');
# Access to model
require('../models/event.php');
?>

<?php

  # Displays events
  function index(){
	  global $smarty;

    $event = new Event();

    $smarty->assign('events', $event->all());
    $smarty->display('index.html');
  }

  # Displays new event page
  function new_m(){
	  global $smarty;

    $smarty->display('new.html');
  }

  # Displays event edit page
  function edit($id){
    global $smarty;

    $event = new Event($id);

    $smarty->assign('event', $event);
    $smarty->display('edit.html');
  }

  # Saves a new event
  function create(){
    global $smarty;

    $event = new Event();
    $event->save();

    # on ré-affiche la liste des stages
    $smarty->assign('events', $event->all());
    $smarty->display('index.html');
  }

  # Updates an event
  function update($id){
    global $smarty;

    $event = new Event($id);
    $event->update();

    # Displays list of events again
    $smarty->assign('events', $event->all());
    $smarty->display('index.html');
  }

  # Destroys an event
  function destroy($id){
    global $smarty;

    $event = new Event($id);
    $event->destroy();

    # Displays list of events again
    $smarty->assign('events', $event->all());
    $smarty->display('index.html');
  }

?>

<?php
  require('application.php');
?>
