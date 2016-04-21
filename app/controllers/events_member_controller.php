<?php

// put full path to Smarty.class.php
require('../../smarty/libs/Smarty.class.php');
$smarty = new Smarty();

$smarty->setCompileDir('../../smarty/templates_c');
$smarty->setCacheDir('../../smarty/cache');
$smarty->setConfigDir('../../smarty/configs');

$smarty->setTemplateDir('../../app/views/events_members');
require('../models/events_members.php');
?>

<?php

    class member{
        function member($id, $nom, $prenom){
            $this->id = $id;
            $this->nom = $nom;
            $this->prenom = $prenom;
        }
    }

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

        // Remplacer ces 3 lignes par un appel mysql sur tous les stages
        $member1 = new member('1', 'Jeandel', 'Thierry');
        $member2 = new member('2', 'Quentin', 'Christian');
        $member3 = new member('3', 'Grandmougin', 'Xavier');

		// remplacer ces 3 lignes par un appel mysql sur toutes les inscriptions
		$smarty->assign('subscriptions', array( '1' => ['1' => 1, '2' => 1], '2' => ['1' => 0, '2' => 1], '3' => ['1' => 1, '2' => 1] ));
		
        $smarty->assign('members', array($member1, $member2, $member3));
        $smarty->display('index.html');
    }

	$event_id = $_GET['event_id'];
	$member_id = $_GET['member_id'];
	
    switch ($_GET['action']) {
        case 'create':
			# créer l'association membre <=> stage
			associer($event_id, $member_id);
			
            # Affiche la page index
            index($smarty);
            break;

        case 'delete':
			# détruire l'association membre <=> stage
			dissocier($event_id, $member_id);
			
            # Affiche la page index
            index($smarty);
            break;

        default:
            # Affiche la page index par défaut
            index($smarty);
    }

?>
