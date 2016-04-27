<?php

require('../../config/database.php');
require('../../config/smarty.php');

// initialisations propres à ce controleur
require('../models/event.php');
$smarty->setTemplateDir('../../app/views/events');
?>

<?php

    // Liste les stages
    function index($smarty){
        $event = new Event();

        $smarty->assign('events', $event->all());
        $smarty->display('index.html');
    }

    // Affiche le formulaire pour créer un nouveau stage
    function new_m($smarty){
        $smarty->display('new.html');
    }

    // Affiche le formulaire pour modifier un stage
    function edit($smarty, $id){
      $event = new Event($id);

      $smarty->assign('event', $event);
      $smarty->display('edit.html');
    }

    // Enregistre un event / stage
    function create($smarty){
        $event = new Event();
        $event->save();

        // on ré-affiche la liste des stages
        $smarty->assign('events', $event->all());
        $smarty->display('index.html');
    }

    // Enregistre les modifications d'un event / stage
    function update($smarty, $id){
        $event = new Event($id);
        $event->update();

        // on ré-affiche la liste des stagiaires
        $smarty->assign('events', $event->all());
        $smarty->display('index.html');
    }

    // Supprime un event / stage
    function destroy($smarty, $id){
        $event = new Event($id);
        $event->destroy();

        // on ré-affiche la liste des stages
        $smarty->assign('events', $event->all());
        $smarty->display('index.html');
    }

    // récupère les paramètres action et id dans l'URL, s'ils existent
    $action = isset($_GET['action']) ? $_GET['action'] : '';
    $id = isset($_GET['id']) ? $_GET['id'] : '';

    // analyse l'action demandée
    switch ($action) {
      case 'new':
        # Affiche la page new.html
        new_m($smarty);
        break;

      case 'create':
        create($smarty);
        break;

      case 'edit':
        edit($smarty, $id);
        break;

      case 'update':
        update($smarty, $id);
        break;

      case 'destroy':
        destroy($smarty, $id);
        break;

      default:
        # Affiche la page index par défaut
        index($smarty);
    }

?>
