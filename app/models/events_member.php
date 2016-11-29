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
      $result = mysql_query($query) or die('Échec de la requête : ' . mysql_error());
      $events_member = mysql_fetch_array($result);

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

    $query .= ', member_id, am.nom, am.prenom';
    $query .= " FROM active_members am
                LEFT JOIN events_members ON events_members.member_id = am.id
                GROUP BY am.id
                ORDER BY inscrit_dernier_stage DESC, am.nom ASC, am.prenom ASC";

    $result = mysql_query($query) or die('Échec de la requête : ' . mysql_error());

    while ($subscription = mysql_fetch_array($result)) {
      $subscriptions[] = $subscription;
    }

    return $subscriptions;
  }

  # Inscript un membre à un event/stage
  function associer() {
    $result = mysql_query("INSERT INTO events_members (event_id, member_id) VALUE ($this->event_id, $this->member_id)");
    }

  # Désinscript un membre d'un event/stage
  function dissocier() {
    $result = mysql_query("DELETE FROM events_members WHERE id=$this->id");
    }

  # met à jour une inscription dans la base
  function update(){
    $query = "UPDATE events_members
              SET moniteur='$this->moniteur', pieton='$this->pieton', materiel='$this->materiel'
              WHERE id=$this->id";
    $result = mysql_query($query) or die('Échec de la requête : ' . mysql_error() . $query);
    }

  # initialise l'objet avec le tableau fourni en paramètre
  protected function init($t_init){
    $this->moniteur = $t_init['moniteur'];
    $this->pieton = $t_init['pieton' ];
    $this->materiel = $t_init['materiel'];
  }

}

?>
