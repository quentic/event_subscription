<?php

// put full path to Smarty.class.php
require('../../smarty/libs/Smarty.class.php');
$smarty = new Smarty();

$smarty->setTemplateDir('../../app/views/events');
$smarty->setCompileDir('../../smarty/templates_c');
$smarty->setCacheDir('../../smarty/cache');
$smarty->setConfigDir('../../smarty/configs');

?>

<?php

    class stage{
        function stage($id, $nom, $periode){
            $this->id = $id;
            $this->nom = $nom;
            $this->periode = $periode;
        }
    }

    function index($smarty){
        // Remplacer ces 2 lignes par un appel mysql sur tous les stages
        $stage1 = new stage('1', 'Vars', 'Février 2016');
        $stage2 = new stage('2', 'Sölden', 'Avril 2016');

        $smarty->assign('stages', array($stage1, $stage2));
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