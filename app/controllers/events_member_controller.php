<?php

require('../../config/database.php');
require('../../config/smarty.php');

// initialisations propres à ce controleur
$smarty->setTemplateDir('../../app/views/events_members');
require('../models/event.php');
require('../models/member.php');
require('../models/events_member.php');
?>

<?php

  function index($smarty){
    // Remplacer ces 2 lignes par un appel mysql sur tous les stages
    $event1 = new Event('1', 'Vars', 'Février 2016');
    $event2 = new Event('2', 'Sölden', 'Avril 2016');

    $smarty->assign('events', array($event1, $event2));

    // Remplacer ces 3 lignes par un appel mysql sur tous les stages
    $member1 = new Member('1', 'Jeandel', 'Thierry');
    $member2 = new Member('2', 'Quentin', 'Christian');
    $member3 = new Member('3', 'Grandmougin', 'Xavier');

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
      $inscription = new EventsMember();
      $inscription->associer($event_id, $member_id);

      # Affiche la page index
      index($smarty);
      break;

    case 'delete':
      # détruire l'association membre <=> stage
      $desinscription = new EventsMember();
      $desinscription->dissocier($event_id, $member_id);

      # Affiche la page index
      index($smarty);
      break;

    default:
      # Affiche la page index par défaut
      index($smarty);
  }

?>
