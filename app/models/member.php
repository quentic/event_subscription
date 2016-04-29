<?php

// un stagiaire qui peut s'inscrire à un stage
// a member that can subscribe to an event
class Member{

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
      $this->nom = $_POST['nom' ];
      $this->prenom = $_POST['prenom'];
      $this->datenaissance = $_POST['datenaissance'];
      $this->adresse = $_POST['adresse'];
      $this->cp = $_POST['cp'];
      $this->ville = $_POST['ville'];
      $this->email = $_POST['email'];
      $this->telfixe = $_POST['telfixe'];
      $this->telportable = $_POST['telportable'];
      $this->photo = $_POST['photo'];
      $this->observation = $_POST['observation'];
      $this->date_adh = $_POST['date_adh'];
      $this->mono = $_POST['mono'];
      $this->diplome = $_POST['diplome'];
      $this->photo2 = $_POST['photo2'];

    } else {
      $this->nom = '';
      $this->prenom = '';
      $this->datenaissance = '';
      $this->adresse = '';
      $this->cp = '';
      $this->ville = '';
      $this->email = '';
      $this->telfixe = '';
      $this->telportable = '';
      $this->photo = '';
      $this->observation = '';
      $this->date_adh = '';
      $this->mono = '';
      $this->diplome = '';
      $this->photo2 = '';

    }
  }

  // constructeur avec 1 paramètre
  public function __construct1($id){
    $this->id = $_GET['id'];

    if (!empty($_POST)) {
      // Récupère les données du member/stagiaire via le $_POST
      $this->masque = $_POST['masque'];
      $this->nom = $_POST['nom' ];
      $this->prenom = $_POST['prenom'];
      $this->datenaissance = $_POST['datenaissance'];
      $this->adresse = $_POST['adresse'];
      $this->cp = $_POST['cp'];
      $this->ville = $_POST['ville'];
      $this->email = $_POST['email'];
      $this->telfixe = $_POST['telfixe'];
      $this->telportable = $_POST['telportable'];
      $this->photo = $_POST['photo'];
      $this->observation = $_POST['observation'];
      $this->date_adh = $_POST['date_adh'];
      $this->mono = $_POST['mono'];
      $this->diplome = $_POST['diplome'];
      $this->photo2 = $_POST['photo2'];

    } else {
      // Récupère les données du member/stagiaire via son id
      $query = "SELECT * FROM members WHERE id=$id";
      $result = mysql_query($query) or die('Échec de la requête : ' . mysql_error());

      $member = mysql_fetch_object($result);

      $this->masque = $member->masque;
      $this->nom = $member->nom;
      $this->prenom = $member->prenom;
      $this->datenaissance = $member->datenaissance;
      $this->adresse = $member->adresse;
      $this->cp = $member->cp;
      $this->ville = $member->ville;
      $this->email = $member->email;
      $this->telfixe = $member->telfixe;
      $this->telportable = $member->telportable;
      $this->photo = $member->photo;
      $this->observation = $member->observation;
      $this->date_adh = $member->date_adh;
      $this->mono = $member->mono;
      $this->diplome = $member->diplome;
      $this->photo2 = $member->photo2;
    }
  }

  // Sélectionner tous les stages
  function all() {
    $query = 'SELECT * FROM members ORDER BY nom, prenom ASC';;
    $result = mysql_query($query) or die('Échec de la requête : ' . mysql_error());
    $t_result = [];

    while ($line = mysql_fetch_object($result)) {
      $t_result[] = $line;
    }
    return $t_result;
  }

  // Sélectionner tous les stages
  function actifs() {
    $query = 'SELECT * FROM members WHERE NOT masque ORDER BY nom, prenom ASC';
    $result = mysql_query($query) or die('Échec de la requête : ' . mysql_error());
    $t_result = [];

    while ($line = mysql_fetch_object($result)) {
      $t_result[] = $line;
    }
    return $t_result;
  }

  // enregistrer un nouveau membre/stagiaire dans la base
  function save(){
    $query = "INSERT INTO members (nom, prenom, datenaissance, adresse, cp, ville, email, telfixe, telportable, photo, observation, date_adh, mono, diplome, photo2)
              VALUES ('$this->nom', '$this->prenom', '$this->datenaissance',
                      '$this->adresse', '$this->cp', '$this->ville',
                      '$this->email', '$this->telfixe', '$this->telportable',
                      '$this->photo', '$this->observation', '$this->date_adh',
                      '$this->mono', '$this->diplome', '$this->photo2')";
    $result = mysql_query($query) or die('Échec de la requête : ' . mysql_error() . $query);
    }

  // met à jour un membre/stagiaire dans la base
  function update(){
    $query = "UPDATE members
              SET masque='$this->masque', nom='$this->nom', prenom='$this->prenom', datenaissance='$this->datenaissance',
              adresse='$this->adresse', cp='$this->cp', ville='$this->ville',
              email='$this->email', telfixe='$this->telfixe', telportable='$this->telportable',
              photo='$this->photo', observation='$this->observation', date_adh='$this->date_adh',
              mono='$this->mono', diplome='$this->diplome', photo2='$this->photo2'
              WHERE id=$this->id";
    $result = mysql_query($query) or die('Échec de la requête : ' . mysql_error() . $query);
    }

  // supprimer un membre/stagiaire de la base
  function destroy(){
    $query = "DELETE FROM members WHERE id=$this->id";
    $result = mysql_query($query) or die('Échec de la requête : ' . mysql_error() . $query);
    }

}

?>
