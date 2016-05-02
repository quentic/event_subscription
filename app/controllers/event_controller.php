<?php
require('../../config/database.php');
require('../../config/smarty.php');

# initialisations propres à ce controleur
# Accès aux vues
$smarty->setTemplateDir('../../app/views/events');
# Accès au modèle
require('../models/event.php');
?>

<?php

    # Liste les stages
    function index($smarty){
        $event = new Event();

        $smarty->assign('events', $event->all());
        $smarty->display('index.html');
    }

    # Affiche la page de création d'un nouveau stage
    function new_m($smarty){
        $smarty->display('new.html');
    }

    # Affiche la page de modification d'un stage
    function edit($smarty, $id){
      $event = new Event($id);

      $smarty->assign('event', $event);
      $smarty->display('edit.html');
    }

    # Enregistre un event / stage
    function create($smarty){
        $event = new Event();
        $event->save();

        # on ré-affiche la liste des stages
        $smarty->assign('events', $event->all());
        $smarty->display('index.html');
    }

    # Enregistre les modifications d'un event / stage
    function update($smarty, $id){
        $event = new Event($id);
        $event->update();

        # on ré-affiche la liste des stagiaires
        $smarty->assign('events', $event->all());
        $smarty->display('index.html');
    }

    # Supprime un event / stage
    function destroy($smarty, $id){
        $event = new Event($id);
        $event->destroy();

        # on ré-affiche la liste des stages
        $smarty->assign('events', $event->all());
        $smarty->display('index.html');
    }

?>

<?php
  require('application.php');
?>
