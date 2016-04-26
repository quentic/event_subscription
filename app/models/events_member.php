<?php

class EventsMember{

  // constructeur sans paramètre
  public function __construct(){
    if (!empty($_POST)) {
      // Récupère les données d'inscription via $_POST (create, destroy)
      $this->event_id = $_POST['event_id' ];
      $this->member_id = $_POST['member_id'];

    } else {
      $this->event_id = '';
      $this->member_id = '';

    }
  }

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

  function associer() {
    $result = mysql_query("INSERT INTO events_members (event_id, member_id) VALUE ($this->event_id, $this->member_id)");
    }

  function dissocier() {
    $result = mysql_query("DELETE FROM events_members WHERE event_id=$this->event_id AND member_id= $this->member_id");
    }
}

?>
