<?php

  // un stage auquel peuvent s'inscrire des stagiaires
  // an event which members can subscribe to
  class Event{

    // Sélectionner tous les stages
    function all() {
      $query = 'SELECT * FROM events';
      $result = mysql_query($query) or die('Échec de la requête : ' . mysql_error());
      $t_result = [];

      while ($line = mysql_fetch_object($result)) {
        $t_result[] = $line;
      }
      return $t_result;
    }
  }

?>