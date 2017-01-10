<?php

class EventsMember{

  public function __construct(){
    $get_arguments       = func_get_args();
    $number_of_arguments = func_num_args();

    if (method_exists($this, $method_name = '__construct'.$number_of_arguments)) {
      call_user_func_array(array($this, $method_name), $get_arguments);
    }
  }

  # constructor with no parameter
  public function __construct0(){
    $this->event_id = '';
    $this->member_id = '';
  }

  # constructor with 1 parameter (an array of data)
  public function __construct1($t_data){
    global $mysqli;

    # Gets subscription data via $_POST (destroy)
    # or via $_GET (edit)
    $this->id = $t_data['id'];

    if (!empty($_POST)) {
      # Gets event data via $_POST (update)
      $this->init($_POST);

    } else {
      # Gets subscription data by id
      $query = "SELECT nom, prenom, lieu FROM events_members
                INNER JOIN events ON events_members.event_id = events.id
                INNER JOIN members ON events_members.member_id = members.id
                WHERE events_members.id=$this->id";
      $result = $mysqli->query($query) or die('Échec de la requête : ' . mysql_error());
      $events_member = $result->fetch_array();

      $this->init($events_member);

      # bonus : to display edit page
      $this->nom = $events_member['nom'];
      $this->prenom = $events_member['prenom'];
      $this->lieu = $events_member['lieu'];

    }

  }

  # constructor with 2 parameters (event_id and member_id)
  public function __construct2($event_id, $member_id){

    # Gets data of event and member to connect
    $this->event_id = $event_id;
    $this->member_id = $member_id;

  }

  # Select all subscriptions
  function all($events_actifs) {
    global $mysqli;

    $subscriptions = [];
    $select = [];
    $dernier_stage_id = $events_actifs[0]->id;

    # Build query of active members to active events subscriptions
    $query = 'SELECT ';

    # Builds a subscription-to-last-event indicator to be able to sort on that data
    $query .= "MAX(IF(event_id=$dernier_stage_id, 1, 0)) AS inscrit_dernier_stage,  ";

    # Adds a column for each active event and finds out if the member subscribed to the event
    # If subscribed, we get the subscription id (which will be used to cancel subscription)
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

  # Subscribe a member to an event
  function associer() {
    global $mysqli;

    $result = $mysqli->query("INSERT INTO events_members (event_id, member_id) VALUE ($this->event_id, $this->member_id)");

    $result = $mysqli->query("SELECT id FROM events_members ORDER BY id DESC LIMIT 1");
    $subscription_id = $result->fetch_row()[0];

    return $subscription_id;
    }

  # Cancel a subscription
  function dissocier() {
    global $mysqli;

    $result = $mysqli->query("DELETE FROM events_members WHERE event_id=$this->event_id AND member_id=$this->member_id");
    }

  # updates a subscription
  function update(){
    global $mysqli;

    #$query = "UPDATE events_members
    #          SET materiel='$this->materiel'
    #          WHERE id=$this->id";
    #$result = $mysqli->query($query) or die('Échec de la requête : ' . mysql_error() . $query);
    }

  # initializes objet with the array given as a parameter
  protected function init($t_init){
    $this->moniteur = $t_init['moniteur'];
    $this->pieton = $t_init['pieton' ];
    $this->materiel = $t_init['materiel'];
  }

}

?>
