<?php

require('../../config/database.php');
require('../../config/smarty.php');

// initialisations propres à ce controleur
require('../models/member.php');
$smarty->setTemplateDir('../../app/views/members');
?>

<?php

    function index($smarty){
      $member = new Member();

      $smarty->assign('members', $member->all());
      $smarty->display('index.html');
    }

    function new_m($smarty){
      $smarty->display('new.html');
    }

    function edit($smarty){
      $member = new Member();

      $smarty->assign('member', $member);
      $smarty->display('edit.html');
    }

    // Enregistre un member/stagiaire
    function save($smarty){
        $member = new Member();
        $member->save();

        // on ré-affiche la liste des stagiaires
        $smarty->assign('members', $member->all());
        $smarty->display('index.html');
    }

    // Enregistre les modifications d'un member/stagiaire
    function update($smarty){
        $member = new Member();
        $member->update();

        // on ré-affiche la liste des stagiaires
        $smarty->assign('members', $member->all());
        $smarty->display('index.html');
    }

    // Supprime un member / stagiaire
    function destroy($smarty){
        $member = new Member();
        $member->destroy();

        // on ré-affiche la liste des stagiaires
        $smarty->assign('members', $member->all());
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
          edit($smarty);
          break;

        case 'update':
          update($smarty);
          break;

        case 'destroy':
          destroy($smarty);
          break;

        default:
          # Affiche la page index par défaut
          index($smarty);
      }

?>
