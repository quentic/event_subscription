<?php

require('../../config/database.php');
require('../../config/smarty.php');

// initialisations propres à ce controleur
require('../models/event.php');
$smarty->setTemplateDir('../../app/views/events');
?>

<?php

    function index($smarty){
        $event = new Event();

        $smarty->assign('events', $event->all());
        $smarty->display('index.html');
    }

    function new_m($smarty){
        $smarty->display('new.html');
    }

    function edit($smarty){
      $event = new Event();

      $smarty->assign('event', $event);
      $smarty->display('edit.html');
    }

    // Enregistre un event / stage
    function save($smarty){
        $event = new Event();
        $event->save();

        // on ré-affiche la liste des stages
        $smarty->assign('events', $event->all());
        $smarty->display('index.html');
    }

    // Enregistre les modifications d'un event / stage
    function update($smarty){
        $event = new Event();
        $event->update();

        // on ré-affiche la liste des stagiaires
        $smarty->assign('events', $event->all());
        $smarty->display('index.html');
    }

    // Supprime un event / stage
    function destroy($smarty){
        $event = new Event();
        $event->destroy();

        // on ré-affiche la liste des stages
        $smarty->assign('events', $event->all());
        $smarty->display('index.html');
    }

    if (!isset($_GET["action"]))
      # Affiche la page index par défaut
      index($smarty);

    else
      // analyse l'action demandée
      switch ($_GET["action"]) {
        case 'new':
          # Affiche la page new.html
          new_m($smarty);
          break;

        case 'create':
          save($smarty);
          break;

        case 'edit':
          edit($smarty);
          break;

        case 'update':
          update($smarty);
          break;

        case 'destroy':
          destroy($smarty);
          break;

        default:
          # Affiche la page index par défaut
          index($smarty);
      }

?>
