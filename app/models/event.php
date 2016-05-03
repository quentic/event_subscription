<?php
# un stage auquel peuvent s'inscrire des stagiaires
# an event which members can subscribe to
class Event{

  public function __construct(){
    $get_arguments       = func_get_args();
    $number_of_arguments = func_num_args();

    if (method_exists($this, $method_name = '__construct'.$number_of_arguments)) {
      call_user_func_array(array($this, $method_name), $get_arguments);
    }
  }

  # constructeur sans paramètre
  public function __construct0(){
    if (!empty($_POST)) {
      # Récupère les données du event/stage via $_POST (new)
      $this->init($_POST);

    } else {
      $this->init([]);

    }
  }

  # constructeur avec 1 paramètre
  public function __construct1($id){
    $this->id = $id;

    if (!empty($_POST)) {
      # Récupère les données du event/stage via $_POST (update)
      $this->init($_POST);

    } else {
      # Récupère les données du event/stage via son id
      $query = "SELECT * FROM events WHERE id=$id";
      $result = mysql_query($query) or die('Échec de la requête : ' . mysql_error());
      $member = mysql_fetch_array($result);

      $this->init($member);
    }
  }

  # Sélectionner tous les stages
  function all() {
    $query = 'SELECT * FROM events ORDER BY id DESC';
    $result = mysql_query($query) or die('Échec de la requête : ' . mysql_error());
    $t_result = [];

    while ($line = mysql_fetch_object($result)) {
      $t_result[] = $line;
    }
    return $t_result;
  }

  # Sélectionner tous les stages actifs
  function actifs() {
    $query = 'SELECT * FROM active_events ORDER BY id DESC';
    $result = mysql_query($query) or die('Échec de la requête : ' . mysql_error());
    $t_result = [];

    while ($line = mysql_fetch_object($result)) {
      $t_result[] = $line;
    }
    return $t_result;
  }

  # enregistrer un nouveau event/stage dans la base
  function save(){
    $query = "INSERT INTO events (lieu, datedebut, datefin)
              VALUES ('$this->lieu', '$this->datedebut', '$this->datefin')";
    $result = mysql_query($query) or die('Échec de la requête : ' . mysql_error() . $query);
  }

  # met à jour un event/stage dans la base
  function update(){
    $query = "UPDATE events
              SET masque='$this->masque', lieu='$this->lieu', datedebut='$this->datedebut', datefin='$this->datefin'
              WHERE id=$this->id";
    $result = mysql_query($query) or die('Échec de la requête : ' . mysql_error() . $query);
  }

   # supprimer un event/stage de la base
  function destroy(){
    $query = "DELETE FROM events WHERE id=$this->id";
    $result = mysql_query($query) or die('Échec de la requête : ' . mysql_error() . $query);
  }

  protected function init($t_init){
    $this->masque = $t_init['masque'];
    $this->lieu = $t_init['lieu' ];
    $this->datedebut = $t_init['datedebut'];
    $this->datefin = $t_init['datefin'];
  }

}

?>
