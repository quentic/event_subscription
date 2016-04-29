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
    // Récupère les données d'inscription via $_POST (destroy)
    // ou via $_GET(edit)
    $this->id = $t_data['id'];

    if (!empty($_POST)) {
      // Récupère les données du event/stage via $_POST (update)
      $this->moniteur = $_POST['moniteur'];
      $this->pieton = $_POST['pieton' ];
      $this->materiel = $_POST['materiel'];

    } else {
      // Récupère les données de l'inscription via son id
      $query = "SELECT materiel, moniteur, pieton, nom, prenom, lieu FROM events_members
                INNER JOIN events ON events_members.event_id = events.id
                INNER JOIN members ON events_members.member_id = members.id
                WHERE events_members.id=$this->id";
      $result = mysql_query($query) or die('Échec de la requête : ' . mysql_error());

      $events_member = mysql_fetch_object($result);

      $this->moniteur = $events_member->moniteur;
      $this->pieton = $events_member->pieton;
      $this->materiel = $events_member->materiel;

      // bonus : pour l'affichage de la page edit
      $this->nom = $events_member->nom;
      $this->prenom = $events_member->prenom;
      $this->lieu = $events_member->lieu;

    }

  }

  // constructeur avec 2 paramètres (event_id et member_id)
  public function __construct2($event_id, $member_id){

    // Récupère les données du stage et du membre à associer
    $this->event_id = $event_id;
    $this->member_id = $member_id;

  }

  // Sélectionner toutes les inscriptions
  function all($events_actifs) {
    $subscriptions = [];
    $select = [];

    // Construction de la requête toutes les inscription des membres actifs aux stages actifs
    $query = 'SELECT ';
    foreach ($events_actifs as $event) {
      $select[] =  "MAX(IF(event_id=$event->id, events_members.id, 0)) AS s_$event->id";
      }
    $query .= join(', ', $select);
    $query .= ', member_id, active_members.nom, active_members.prenom';
    $query .= ' FROM active_members
                LEFT JOIN events_members ON events_members.member_id = active_members.id
                LEFT JOIN active_events ON events_members.event_id = active_events.id
                GROUP BY active_members.id
                ORDER BY active_members.nom';
    $result = mysql_query($query) or die('Échec de la requête : ' . mysql_error());

    // on ne veut que les valeurs numériques dans le tableau (pas les clés)
    while ($subscription = mysql_fetch_array($result)) {
      $subscriptions[] = $subscription;
    }

    return $subscriptions;
  }

  function associer() {
    echo("INSERT INTO events_members (event_id, member_id) VALUE ($this->event_id, $this->member_id)");
    $result = mysql_query("INSERT INTO events_members (event_id, member_id) VALUE ($this->event_id, $this->member_id)");
    }

  function dissocier() {
    $result = mysql_query("DELETE FROM events_members WHERE id=$this->id");
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
