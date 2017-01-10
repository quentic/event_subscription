<?php
require('../../config/database.php');
require('../../config/smarty.php');

# Initializations specific to this controller
# Access to views
$smarty->setTemplateDir('../../app/views/members');
# Access to model
require('../models/member.php');
require('../models/niveau.php');
?>

<?php
    # Displays members
    function index(){
      global $smarty;

      $member = new Member();

      $smarty->assign('members', $member->all());
      $smarty->display('index.html');
    }

    # Displays new member page
    function new_m(){
      global $smarty;

      $member = new Member();
      $smarty->assign('member', $member);

      $smarty->display('new.html');
    }

    # Displays member edit page
    function edit($id){
      global $smarty;

      $member = new Member($id);
      $smarty->assign('member', $member);

      $smarty->display('edit.html');
    }

    # Saves new member
    function create(){
      global $smarty;

      $member = new Member();
      $member->save();

      # on ré-affiche la liste des stagiaires
      $smarty->assign('members', $member->all());
      $smarty->display('index.html');
    }

    # Updates member
    function update($id){
      global $smarty;

      $member = new Member($id);
      $member->update();

      # Displays member list
      $smarty->assign('members', $member->all());
      $smarty->display('index.html');
    }

    # Updates member shown/hidden status
    function update_masque($id){
      global $smarty;

      $member = new Member($id);
      $member->update_masque();

      # Displays member list
      $smarty->assign('members', $member->all());
      $smarty->display('index.html');
    }

    # Destroys a member
    function destroy($id){
      global $smarty;

      $member = new Member($id);
      $member->destroy();

      # Displays member list
      $smarty->assign('members', $member->all());
      $smarty->display('index.html');
    }

?>

<?php
  require('application.php');
?>
