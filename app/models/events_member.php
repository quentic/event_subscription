<?php

class EventsMember{

  public function __construct(){
    $get_arguments       = func_get_args();
    $number_of_arguments = func_num_args();

    if (method_exists($this, $method_name = '__construct'.$number_of_arguments)) {
      call_user_func_array(array($this, $method_name), $get_arguments);
    }
  }

  # constructeur sans paramètre
  public function __construct0(){
    $this->event_id = '';
    $this->member_id = '';
  }

  # constructeur avec 1 paramètre (un tableau de données)
  public function __construct1($t_data){
    global $mysqli;

    # Récupère les données d'inscription via $_POST (destroy)
    # ou via $_GET(edit)
    $this->id = $t_data['id'];

    if (!empty($_POST)) {
      # Récupère les données du event/stage via $_POST (update)
      $this->init($_POST);

    } else {
      # Récupère les données de l'inscription via son id
      $query = "SELECT materiel, moniteur, pieton, nom, prenom, lieu FROM events_members
                INNER JOIN events ON events_members.event_id = events.id
                INNER JOIN members ON events_members.member_id = members.id
                WHERE events_members.id=$this->id";
      $result = $mysqli->query($query) or die('Échec de la requête : ' . mysql_error());
      $events_member = $result->fetch_array();

      $this->init($events_member);

      # bonus : pour l'affichage de la page edit
      $this->nom = $events_member['nom'];
      $this->prenom = $events_member['prenom'];
      $this->lieu = $events_member['lieu'];

    }

  }

  # constructeur avec 2 paramètres (event_id et member_id)
  public function __construct2($event_id, $member_id){

    # Récupère les données du stage et du membre à associer
    $this->event_id = $event_id;
    $this->member_id = $member_id;

  }

  # Sélectionner toutes les inscriptions
  function all($events_actifs) {
    global $mysqli;

    $subscriptions = [];
    $select = [];
    $dernier_stage_id = $events_actifs[0]->id;

    # Construction de la requête toutes les inscription des membres actifs aux stages actifs
    $query = 'SELECT ';

    # Construit un indicateur d'inscription au dernier stage pour trier sur cette information
    $query .= "MAX(IF(event_id=$dernier_stage_id, 1, 0)) AS inscrit_dernier_stage,  ";

    # Ajoute une colonne par stage actif et évalue si le member/stagiaire y est inscrit
    # S'il est inscrit, on récupère l'id de l'inscription (qui pourra servir à le désinscrire)
    foreach ($events_actifs as $event) {
      $select[] =  "MAX(IF(event_id=$event->id, events_members.id, 0))";
      }
    $query .= join(', ', $select);

    $query .= ', am.id AS member_id, am.nom, am.prenom';
    $query .= " FROM active_members am
                LEFT JOIN events_members ON events_members.member_id = am.id
                GROUP BY am.id
                ORDER BY inscrit_dernier_stage DESC, am.nom ASC, am.prenom ASC";

    $result = $mysqli->query($query) or die('Échec de la requête : ' . mysql_error());

    while ($subscription = $result->fetch_array()) {
      $subscriptions[] = $subscription;
    }

    return $subscriptions;
  }

  # Inscrit un membre à un event/stage
  function associer() {
    global $mysqli;

    $result = $mysqli->query("INSERT INTO events_members (event_id, member_id) VALUE ($this->event_id, $this->member_id)");

    $result = $mysqli->query("SELECT id FROM events_members ORDER BY id DESC LIMIT 1");
    $subscription_id = $result->fetch_row()[0];

    return $subscription_id;
    }

  # Désinscrit un membre d'un event/stage
  function dissocier() {
    global $mysqli;

    $result = $mysqli->query("DELETE FROM events_members WHERE event_id=$this->event_id AND member_id=$this->member_id");
    }

  # met à jour une inscription dans la base
  function update(){
    global $mysqli;

    $query = "UPDATE events_members
              SET moniteur='$this->moniteur', pieton='$this->pieton', materiel='$this->materiel'
              WHERE id=$this->id";
    $result = $mysqli->query($query) or die('Échec de la requête : ' . mysql_error() . $query);
    }

  # Fournit les inscrits au stage
  function inscrits_au_stage($event_id){
    global $mysqli;

    $liste_emails = "";

    # Construction de la requête toutes les inscription des membres actifs aux stages actifs
    $query = 'SELECT ';
    $query .= ' m.email';
    $query .= " FROM members m
                INNER JOIN events_members em ON em.member_id = m.id
                WHERE em.event_id = $event_id
                AND m.email != ''
                ORDER BY m.nom
                ";

    $result = $mysqli->query($query) or die('Échec de la requête : ' . mysql_error());

    while ($subscription = $result->fetch_array()) {
      $liste_emails .= $subscription["email"] . ";";
    }

    return $liste_emails;
  }

  # initialise l'objet avec le tableau fourni en paramètre
  protected function init($t_init){
    $this->moniteur = $t_init['moniteur'];
    $this->pieton = $t_init['pieton' ];
    $this->materiel = $t_init['materiel'];
  }

}

?>
