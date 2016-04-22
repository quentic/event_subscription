<?php

  class EventsMember{

    // Sélectionner toutes les inscriptions
    function all() {
      $subscriptions = [];
      $query = 'SELECT event_id, member_id FROM events_members';
      $result = mysql_query($query) or die('Échec de la requête : ' . mysql_error());

      // on ne veut que les valeurs numériques dans le tableau (pas les clés)
      while ($subscription = mysql_fetch_array($result, MYSQL_NUM)) {
        $subscriptions[] = $subscription;
      }

      return $subscriptions;
    }

    function associer($event_id, $member_id){
      // mysql_query("INSERT INTO events_members (event_id, member_id) VALUE (" . $event_id . "," . $member_id . ")");
      }

    function dissocier($event_id, $member_id){
      // mysql_query("DELETE FROM events_members WHERE event_id=" . $event_id . " AND member_id=" . $member_id);
      }
  }

?>
