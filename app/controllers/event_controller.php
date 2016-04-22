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
        $smarty->assign('events',$event->all());

        $smarty->display('index.html');
    }

    switch ($_GET['action']) {
        case 'new':
            break;

        case 'create':
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
