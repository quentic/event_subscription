<?php
    # Module d'aiguillage des actions commun à tous les controleurs

    # récupère les paramètres action et id dans l'URL, s'ils existent
    $action = isset($_GET['action']) ? $_GET['action'] : '';
    $id = isset($_GET['id']) ? $_GET['id'] : '';

    # analyse l'action demandée
    switch ($action) {
      case 'new':
        # Affiche la page new.html
        new_m();
        break;

      case 'create':
        create();
        break;

      case 'edit':
        edit($id);
        break;

      case 'update':
        update($id);
        break;

      case 'update_masque':
        update_masque($id);
        break;

      case 'destroy':
        destroy($id);
        break;

      default:
        # Affiche la page index par défaut
        index();
    }

?>
