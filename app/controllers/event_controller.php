<?php

// put full path to Smarty.class.php
require('../../smarty/libs/Smarty.class.php');
$smarty = new Smarty();

$smarty->setCompileDir('../../smarty/templates_c');
$smarty->setCacheDir('../../smarty/cache');
$smarty->setConfigDir('../../smarty/configs');

$smarty->setTemplateDir('../../app/views/events');
?>

<?php

    class event{
        function event($id, $nom, $periode){
            $this->id = $id;
            $this->nom = $nom;
            $this->periode = $periode;
        }
    }

    function index($smarty){
        // Remplacer ces 2 lignes par un appel mysql sur tous les stages
        $event1 = new event('1', 'Vars', 'Février 2016');
        $event2 = new event('2', 'Sölden', 'Avril 2016');

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
