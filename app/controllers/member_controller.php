<?php
require('../../config/database.php');
require('../../config/smarty.php');

# initialisations propres à ce controleur
# Accès aux vues
$smarty->setTemplateDir('../../app/views/members');
# Accès au modèle
require('../models/member.php');
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

?>

<?php
  require('application.php');
?>
