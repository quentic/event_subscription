<?php

require('../../config/database.php');
require('../../config/smarty.php');

# initialisations propres à ce controleur
require('../models/member.php');
$smarty->setTemplateDir('../../app/views/members');
?>

<?php
    # Liste les stagiaires
    function index($smarty){
      $member = new Member();

      $smarty->assign('members', $member->all());
      $smarty->display('index.html');
    }

    # Affiche la page pour créer un nouveau stagiaire
    function new_m($smarty){
      $smarty->display('new.html');
    }

    # Affiche la page pour modifier un stagiaire
    function edit($smarty, $id){
      $member = new Member($id);

      $smarty->assign('member', $member);
      $smarty->display('edit.html');
    }

    # Enregistre un member/stagiaire
    function create($smarty){
        $member = new Member();
        $member->save();

        # on ré-affiche la liste des stagiaires
        $smarty->assign('members', $member->all());
        $smarty->display('index.html');
    }

    # Enregistre les modifications d'un member/stagiaire
    function update($smarty, $id){
        $member = new Member($id);
        $member->update();

        # on ré-affiche la liste des stagiaires
        $smarty->assign('members', $member->all());
        $smarty->display('index.html');
    }

    # Supprime un member / stagiaire
    function destroy($smarty, $id){
        $member = new Member($id);
        $member->destroy();

        # on ré-affiche la liste des stagiaires
        $smarty->assign('members', $member->all());
        $smarty->display('index.html');
    }

    # récupère les paramètres action et id dans l'URL, s'ils existent
    $action = isset($_GET['action']) ? $_GET['action'] : '';
    $id = isset($_GET['id']) ? $_GET['id'] : '';

    # analyse l'action demandée
    switch ($action) {
      case 'new':
        # Affiche la page new.html
        new_m($smarty);
        break;

      case 'create':
        create($smarty);
        break;

      case 'edit':
        edit($smarty, $id);
        break;

      case 'update':
        update($smarty, $id);
        break;

      case 'destroy':
        destroy($smarty, $id);
        break;

      default:
        # Affiche la page index par défaut
        index($smarty);
    }

?>
