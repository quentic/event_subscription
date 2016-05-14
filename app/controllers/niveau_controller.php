<?php

require('../../config/database.php');
require('../../config/smarty.php');

// initialisations propres à ce controleur
require('../models/niveau.php');
$smarty->setTemplateDir('../../app/views/niveaux');
?>

<?php
    // Liste les niveaux
    function index($smarty){
      $niveau = new Niveau();

      $smarty->assign('niveaux', $niveau->all());
      $smarty->display('index.html');
    }

    // Affiche le formulaire pour créer un nouveau niveau
    function new_m($smarty){
      $smarty->display('new.html');
    }

    // Affiche le formulaire pour modifier un niveau
    function edit($smarty, $id){
      $niveau = new Niveau($id);

      $smarty->assign('niveau', $niveau);
      $smarty->display('edit.html');
    }

    // Enregistre un niveau
    function create($smarty){
        $niveau = new Niveau();
        $niveau->save();

        // on ré-affiche la liste des stagiaires
        $smarty->assign('niveaux', $niveau->all());
        $smarty->display('index.html');
    }

    // Enregistre les modifications d'un niveau
    function update($smarty, $id){
        $niveau = new Niveau($id);
        $niveau->update();

        // on ré-affiche la liste des niveaux
        $smarty->assign('niveaux', $niveau->all());
        $smarty->display('index.html');
    }

    // Supprime un niveau
    function destroy($smarty, $id){
        $niveau = new Niveau($id);
        $niveau->destroy();

        // on ré-affiche la liste des stagiaires
        $smarty->assign('niveaux', $niveau->all());
        $smarty->display('index.html');
    }
?>

<?php
  require('application.php');
?>
