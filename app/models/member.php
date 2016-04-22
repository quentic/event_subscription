<?php

  // un stagiaire qui peut s'inscrire à un stage
  // a member that can subscribe to an event
  class Member{

    // Sélectionner tous les stages
    function all() {
      $query = 'SELECT * FROM members';
      $result = mysql_query($query) or die('Échec de la requête : ' . mysql_error());
      $t_result = [];

      while ($line = mysql_fetch_object($result)) {
        $t_result[] = $line;
      }
      return $t_result;
    }

  }

?>