<?php

class EventsMember{

  public function __construct(){
    $get_arguments       = func_get_args();
    $number_of_arguments = func_num_args();

    if (method_exists($this, $method_name = '__construct'.$number_of_arguments)) {
      call_user_func_array(array($this, $method_name), $get_arguments);
    }
  }

  // constructeur sans paramètre
  public function __construct0(){
    $this->event_id = '';
    $this->member_id = '';
  }

  // constructeur avec 1 paramètre (un tableau de données)
  public function __construct1($t_data){
    // Récupère les données d'inscription via $_POST (new, destroy)
    // ou via $_GET(edit)
    $this->event_id = $t_data['event_id'];
    $this->member_id = $t_data['member_id'];

    // Avec update, l'id est transmis dans l'URL
    $this->id = $t_data['id'];
    if ($this->id == ''){
      // Si l'enregistrement existe, on récupère son id
      $query = "SELECT id FROM events_members WHERE event_id=$this->event_id AND member_id= $this->member_id";
      $result = mysql_query($query) or die('Échec de la requête : ' . mysql_error());

      $event_member = mysql_fetch_object($result);

      $this->id = $event_member->id;
    }

    if (!empty($_POST)) {
      // Récupère les données du event/stage via $_POST (update)
      $this->moniteur = $_POST['moniteur'];
      $this->pieton = $_POST['pieton' ];
      $this->materiel = $_POST['materiel'];

    } else {
      // Récupère les données de l'inscription via son id
      $query = "SELECT * FROM events_members WHERE id=$this->id";
      $result = mysql_query($query) or die('Échec de la requête : ' . mysql_error());

      $events_member = mysql_fetch_object($result);

      $this->moniteur = $events_member->moniteur;
      $this->pieton = $events_member->pieton;
      $this->materiel = $events_member->materiel;
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

  // met à jour une inscription dans la base
  function update(){
    $query = "UPDATE events_members
              SET moniteur='$this->moniteur', pieton='$this->pieton', materiel='$this->materiel'
              WHERE id=$this->id";
    $result = mysql_query($query) or die('Échec de la requête : ' . mysql_error() . $query);
    }

}

?>
