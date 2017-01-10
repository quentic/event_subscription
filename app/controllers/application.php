<?php
    # Module common to all controllers : calls the method corresponding to the action required

    # get action and id in URL, if present
    $action = isset($_GET['action']) ? $_GET['action'] : '';
    $id = isset($_GET['id']) ? $_GET['id'] : '';

    # analyze action required
    switch ($action) {
      case 'new':
        # Displays the new.html page
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
        # By default, displays the index page
        index();
    }

?>
