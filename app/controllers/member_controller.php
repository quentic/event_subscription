<?php

require('../../config/database.php');
require('../../config/smarty.php');

// initialisations propres à ce controleur
require('../models/member.php');
$smarty->setTemplateDir('../../app/views/members');
?>

<?php

    function index($smarty){
        // Remplacer ces 3 lignes par un appel mysql sur tous les stages
        $member1 = new Member('1', 'Jeandel', 'Thierry');
        $member2 = new Member('2', 'Quentin', 'Christian');
        $member3 = new Member('3', 'Grandmougin', 'Xavier');

        $smarty->assign('members', array($member1, $member2, $member3));
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
