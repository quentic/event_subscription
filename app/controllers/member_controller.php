<?php

require('../../config/database.php');
require('../../config/smarty.php');

// initialisations propres à ce controleur
require('../models/member.php');
$smarty->setTemplateDir('../../app/views/members');
?>

<?php

    function index($smarty){
        $member = new Member($_POST);

        $smarty->assign('members', $member->all());
        $smarty->display('index.html');
    }

    function new_m($smarty){
      $smarty->display('new.html');
    }

    // Enregistre un stagiaire / member
    function save($smarty){
        $event = new Member($_POST);
        $event->save();

        // on ré-affiche la liste des stagiaires
        $smarty->assign('members', $event->all());
        $smarty->display('index.html');
    }

    // Supprime un member / stagiaire
    function destroy($smarty){
        $event = new Member($_GET);
        $event->destroy();

        // on ré-affiche la liste des stagiaires
        $smarty->assign('members', $event->all());
        $smarty->display('index.html');
    }

    if (!isset($_GET["action"]))
      # Affiche la page index par défaut
      index($smarty);

    else
      // analyse l'action demandée
      switch ($_GET['action']) {
        case 'new':
          # Affiche la page new.html
          new_m($smarty);
          break;

        case 'create':
          save($smarty);
          break;

        case 'edit':
          break;

        case 'update':
          break;

        case 'show':
          break;

        case 'destroy':
          destroy($smarty);
          break;

        default:
          # Affiche la page index par défaut
          index($smarty);
      }

?>
