<?php
// un stage auquel peuvent s'inscrire des stagiaires
// an event which members can subscribe to
class Event{

  public function __construct(){
    $get_arguments       = func_get_args();
    $number_of_arguments = func_num_args();

    if (method_exists($this, $method_name = '__construct'.$number_of_arguments)) {
      call_user_func_array(array($this, $method_name), $get_arguments);
    }
  }

  // constructeur sans paramètre
  public function __construct0(){
    if (!empty($_POST)) {
      // Récupère les données du event/stage via $_POST (new)
      $this->lieu = $_POST['lieu' ];
      $this->datedebut = $_POST['datedebut'];
      $this->datefin = $_POST['datefin'];
      $this->placedispo = $_POST['placedispo'];
      $this->observation = $_POST['observation'];
      $this->titre = $_POST['titre'];
      $this->descriptif = $_POST['descriptif'];
      $this->cpterendu = $_POST['cpterendu'];
      $this->image = $_POST['image'];

    } else {
      $this->lieu = '';
      $this->datedebut = '';
      $this->datefin = '';
      $this->placedispo = '';
      $this->observation = '';
      $this->titre = '';
      $this->descriptif = '';
      $this->cpterendu = '';
      $this->image = '';

    }
  }

  // constructeur avec 1 paramètre
  public function __construct1($id){
    $this->id = $id;

    if (!empty($_POST)) {
      // Récupère les données du event/stage via $_POST (update)
      $this->masque = $_POST['masque'];
      $this->lieu = $_POST['lieu' ];
      $this->datedebut = $_POST['datedebut'];
      $this->datefin = $_POST['datefin'];
      $this->placedispo = $_POST['placedispo'];
      $this->observation = $_POST['observation'];
      $this->titre = $_POST['titre'];
      $this->descriptif = $_POST['descriptif'];
      $this->cpterendu = $_POST['cpterendu'];
      $this->image = $_POST['image'];

    } else {
      // Récupère les données du event/stage via son id
      $query = "SELECT * FROM events WHERE id=$id";
      $result = mysql_query($query) or die('Échec de la requête : ' . mysql_error());

      $member = mysql_fetch_object($result);

      $this->masque = $member->masque;
      $this->lieu = $member->lieu;
      $this->datedebut = $member->datedebut;
      $this->datefin = $member->datefin;
      $this->placedispo = $member->placedispo;
      $this->observation = $member->observation;
      $this->titre = $member->titre;
      $this->descriptif = $member->descriptif;
      $this->cpterendu = $member->cpterendu;
      $this->image = $member->image;
    }
  }

   // Sélectionner tous les stages
  function all() {
    $query = 'SELECT * FROM events ORDER BY id DESC';
    $result = mysql_query($query) or die('Échec de la requête : ' . mysql_error());
    $t_result = [];

    while ($line = mysql_fetch_object($result)) {
      $t_result[] = $line;
    }
    return $t_result;
  }

   // Sélectionner tous les stages actifs
  function actifs() {
    $query = 'SELECT * FROM events WHERE NOT masque ORDER BY id DESC';
    $result = mysql_query($query) or die('Échec de la requête : ' . mysql_error());
    $t_result = [];

    while ($line = mysql_fetch_object($result)) {
      $t_result[] = $line;
    }
    return $t_result;
  }

   // enregistrer un nouveau event/stage dans la base
  function save(){
    $query = "INSERT INTO events (lieu, datedebut, datefin, placedispo, observation, titre, descriptif, cpterendu, image)
              VALUES ('$this->lieu', '$this->datedebut', '$this->datefin',
              '$this->placedispo', '$this->observation', '$this->titre', '$this->descriptif',
              '$this->cpterendu', '$this->image')";
    $result = mysql_query($query) or die('Échec de la requête : ' . mysql_error() . $query);
  }

  // met à jour un event/stage dans la base
  function update(){
    $query = "UPDATE events
              SET masque='$this->masque', lieu='$this->lieu', datedebut='$this->datedebut', datefin='$this->datefin',
              placedispo='$this->placedispo', observation='$this->observation', titre='$this->titre', descriptif='$this->descriptif',
              cpterendu='$this->cpterendu', image='$this->image'
              WHERE id=$this->id";
    $result = mysql_query($query) or die('Échec de la requête : ' . mysql_error() . $query);
  }

   // supprimer un event/stage de la base
  function destroy(){
    $query = "DELETE FROM events WHERE id=$this->id";
    $result = mysql_query($query) or die('Échec de la requête : ' . mysql_error() . $query);
  }
}

?>
