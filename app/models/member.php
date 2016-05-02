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
      # Récupère les données du event/stage via $_POST (new)
      $this->nom = $_POST['nom' ];
      $this->prenom = $_POST['prenom'];

    } else {
      $this->nom = '';
      $this->prenom = '';
      $this->datenaissance = '';

    }
  }

  # constructeur avec 1 paramètre
  public function __construct1($id){
    $this->id = $_GET['id'];

    if (!empty($_POST)) {
      # Récupère les données du member/stagiaire via le $_POST
      $this->masque = $_POST['masque'];
      $this->nom = $_POST['nom' ];
      $this->prenom = $_POST['prenom'];

    } else {
      # Récupère les données du member/stagiaire via son id
      $query = "SELECT * FROM members WHERE id=$id";
      $result = mysql_query($query) or die('Échec de la requête : ' . mysql_error());

      $member = mysql_fetch_object($result);

      $this->masque = $member->masque;
      $this->nom = $member->nom;
      $this->prenom = $member->prenom;
    }
  }

  # Sélectionne tous les members/stagiaires
  function all() {
    $query = 'SELECT * FROM members ORDER BY nom, prenom ASC';;
    $result = mysql_query($query) or die('Échec de la requête : ' . mysql_error());
    $t_result = [];

    while ($line = mysql_fetch_object($result)) {
      $t_result[] = $line;
    }
    return $t_result;
  }

  # enregistrer un nouveau membre/stagiaire dans la base
  function save(){
    $query = "INSERT INTO members (nom, prenom)
              VALUES ('$this->nom', '$this->prenom')";
    $result = mysql_query($query) or die('Échec de la requête : ' . mysql_error() . $query);
    }

  # met à jour un membre/stagiaire dans la base
  function update(){
    $query = "UPDATE members
              SET masque='$this->masque', nom='$this->nom', prenom='$this->prenom'
              WHERE id=$this->id";
    $result = mysql_query($query) or die('Échec de la requête : ' . mysql_error() . $query);
    }

  # supprimer un membre/stagiaire de la base
  function destroy(){
    $query = "DELETE FROM members WHERE id=$this->id";
    $result = mysql_query($query) or die('Échec de la requête : ' . mysql_error() . $query);
    }

}

?>
