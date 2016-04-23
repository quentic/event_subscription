<?php

require('../../config/database.php');
require('../../config/smarty.php');

// initialisations propres à ce controleur
require('../models/event.php');
$smarty->setTemplateDir('../../app/views/events');
?>

<?php

    function index($smarty){
        $event = new Event($_POST);

        $smarty->assign('events', $event->all());
        $smarty->display('index.html');
    }

    function new_m($smarty){
        $smarty->display('new.html');
    }

    function save($smarty){
        $event = new Event($_POST);
        $event->save();

        $smarty->assign('events', $event->all());
        $smarty->display('index.html');
    }

    if (!isset($_GET["action"]))
      # Affiche la page index par défaut
      index($smarty);

    else
      switch ($_GET["action"]) {
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

          case 'delete':
              break;

          default:
              # Affiche la page index par défaut
              index($smarty);
      }

?>
