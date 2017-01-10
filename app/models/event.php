<?php
# an event which members can subscribe to
class Event{

  public function __construct(){
    $get_arguments       = func_get_args();
    $number_of_arguments = func_num_args();

    if (method_exists($this, $method_name = '__construct'.$number_of_arguments)) {
      call_user_func_array(array($this, $method_name), $get_arguments);
    }
  }

  # constructor with no parameter
  public function __construct0(){
    if (!empty($_POST)) {
      # Gets event data by $_POST (action: new)
      $this->init($_POST);

    } else {
      # Initializes a new event (action : new)
      $this->init([]);

    }
  }

  # constructor with 1 parameter
  public function __construct1($id){
    global $mysqli;

    $this->id = $id;

    if (!empty($_POST)) {
      # Gets event data via $_POST (action: update)
      $this->init($_POST);

    } else {
      # Gets event data by id (action : edit)
      $query = "SELECT * FROM events WHERE id=$id";
      $result = $mysqli->query($query) or die('Échec de la requête : ' . mysql_error());
      $member = $result->fetch_array();

      $this->init($member);
    }
  }

  # Select all events
  function all() {
    global $mysqli;

    $query = 'SELECT * FROM events ORDER BY id DESC';
    $result = $mysqli->query($query) or die('Échec de la requête : ' . mysql_error());
    $t_result = [];

    while ($line = $result->fetch_object()) {
      $t_result[] = $line;
    }
    return $t_result;
  }

  # Select all active events
  function actifs() {
    global $mysqli;

    $query = 'SELECT * FROM active_events ORDER BY id DESC';
    $result = $mysqli->query($query) or die('Échec de la requête : ' . mysql_error());
    $t_result = [];

    while ($line = $result->fetch_object()) {
      $t_result[] = $line;
    }
    return $t_result;
  }

  # saves new event in database
  function save(){
    global $mysqli;

    $query = "INSERT INTO events (lieu, datedebut, datefin, placedispo, observation, titre, descriptif, cpterendu, image)
              VALUES ('$this->lieu', '$this->datedebut', '$this->datefin',
              '$this->placedispo', '$this->observation', '$this->titre', '$this->descriptif',
              '$this->cpterendu', '$this->image')";
    $result = $mysqli->query($query) or die('Échec de la requête : ' . mysql_error() . $query);
  }

  # updates new event in database
  function update(){
    global $mysqli;

    $query = "UPDATE events
              SET masque='$this->masque', lieu='$this->lieu', datedebut='$this->datedebut', datefin='$this->datefin',
              placedispo='$this->placedispo', observation='$this->observation', titre='$this->titre', descriptif='$this->descriptif',
              cpterendu='$this->cpterendu', image='$this->image'
              WHERE id=$this->id";
    $result = $mysqli->query($query) or die('Échec de la requête : ' . mysql_error() . $query);
  }

   # destroys an event in database
  function destroy(){
    global $mysqli;

    $query = "DELETE FROM events WHERE id=$this->id";
    $result = $mysqli->query($query) or die('Échec de la requête : ' . mysql_error() . $query);
  }

  # initialize objet with array given in parameter
  protected function init($t_init){
    $this->masque = $t_init['masque'];
    $this->lieu = $t_init['lieu' ];
    $this->datedebut = $t_init['datedebut'];
    $this->datefin = $t_init['datefin'];
    $this->placedispo = $t_init['placedispo'];
    $this->observation = $t_init['observation'];
    $this->titre = $t_init['titre'];
    $this->descriptif = $t_init['descriptif'];
    $this->cpterendu = $t_init['cpterendu'];
    $this->image = $t_init['image'];
  }
}

?>
