<?php

require('../../config/smarty.php');

// initialisations propres à ce controleur
require('../models/event.php');
$smarty->setTemplateDir('../../app/views/events');
?>

<?php

    function index($smarty){
        // Remplacer ces 2 lignes par un appel mysql sur tous les stages
        $event1 = new Event('1', 'Vars', 'Février 2016');
        $event2 = new Event('2', 'Sölden', 'Avril 2016');

        $smarty->assign('events', array($event1, $event2));
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
