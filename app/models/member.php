<?php

# un stagiaire qui peut s'inscrire à un stage
# a member that can subscribe to an event
class Member{

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
      # Récupère les données du event/stage via $_POST (action : create)
      $this->init($_POST);

    } else {
      # Initialise un nouvel adhérent (action : new)
      $this->init([]);
      # Par défaut, il adhère aujourd'hui
      $this->date_adh = date("Y-m-d");
    }
  }

  # constructeur avec 1 paramètre
  public function __construct1($id){
    global $mysqli;

    $this->id = $id;

    if (!empty($_POST)) {
      # Récupère les données du member/stagiaire via le $_POST (action : update)
      $this->init($_POST);

    } else {
      # Récupère les données du member/stagiaire via son id (action : edit)
      $query = "SELECT * FROM members WHERE id=$id";
      $result = $mysqli->query($query) or die('Échec de la requête : ' . mysql_error());
      $member = $result->fetch_array();

      $this->init($member);
    }
  }

  # Sélectionne tous les members/stagiaires
  function all() {
    global $mysqli;

    $query = 'SELECT * FROM members ORDER BY nom, prenom ASC';
    $result = $mysqli->query($query) or die('Échec de la requête : ' . mysql_error());
    $t_result = [];

    while ($line = $result->fetch_object()) {
      $t_result[] = $line;
    }
    return $t_result;
  }

  # enregistrer un nouveau membre/stagiaire dans la base
  function save(){
    global $mysqli;

    $query = "INSERT INTO members (nom, prenom, datenaissance, adresse, cp, ville, email, telfixe, telportable, niveau, photo, observation, date_adh, mono, diplome, photo2)
              VALUES ('$this->nom', '$this->prenom', '$this->datenaissance',
                      '$this->adresse', '$this->cp', '$this->ville',
                      '$this->email', '$this->telfixe', '$this->telportable',
                      '$this->niveau', '$this->photo', '$this->observation', '$this->date_adh',
                      '$this->mono', '$this->diplome', '$this->photo2')";
    $result = $mysqli->query($query) or die('Échec de la requête : ' . mysql_error() . $query);
    }

  # met à jour un membre/stagiaire dans la base
  function update(){
    global $mysqli;

    $query = "UPDATE members
              SET
                masque='$this->masque', nom='$this->nom', prenom='$this->prenom', datenaissance='$this->datenaissance',
                adresse='$this->adresse', cp='$this->cp', ville='$this->ville',
                email='$this->email', telfixe='$this->telfixe', telportable='$this->telportable',
                niveau='$this->niveau', photo='$this->photo', observation='$this->observation', date_adh='$this->date_adh',
                mono='$this->mono', diplome='$this->diplome', photo2='$this->photo2'
              WHERE
                id=$this->id";
    $result = $mysqli->query($query) or die('Échec de la requête : ' . mysql_error() . $query);
    }

  # met à jour l'état de masquage d'un membre/stagiaire dans la base
  function update_masque(){
    global $mysqli;

    $query = "UPDATE members
              SET
                masque='$this->masque'
              WHERE
                id=$this->id";
    $result = $mysqli->query($query) or die('Échec de la requête : ' . mysql_error() . $query);
    }

  # supprimer un membre/stagiaire de la base
  function destroy(){
    global $mysqli;

    $query = "DELETE FROM members WHERE id=$this->id";
    $result = $mysqli->query($query) or die('Échec de la requête : ' . mysql_error() . $query);
    }

  # initialise l'objet avec le tableau fourni en paramètre
  protected function init($t_init){
    $this->masque         = $t_init['masque'];
    $this->nom            = $t_init['nom' ];
    $this->prenom         = $t_init['prenom'];
    $this->datenaissance  = $t_init['datenaissance'];
    $this->adresse        = $t_init['adresse'];
    $this->cp             = $t_init['cp'];
    $this->ville          = $t_init['ville'];
    $this->email          = $t_init['email'];
    $this->telfixe        = $t_init['telfixe'];
    $this->telportable    = $t_init['telportable'];
    $this->niveau         = $t_init['niveau'];
    $this->photo          = $t_init['photo'];
    $this->observation    = $t_init['observation'];
    $this->date_adh       = $t_init['date_adh'];
    $this->mono           = $t_init['mono'];
    $this->diplome        = $t_init['diplome'];
    $this->photo2         = $t_init['photo2'];
  }

}

?>
