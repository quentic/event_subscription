<?php

// un stagiaire qui peut s'inscrire à un stage
// a member that can subscribe to an event
class Member{

  function __construct(){
    
    $this->id = $_GET['id'];

    if (!empty($_POST)) {
      // Récupère les données du member/stagiaire via le $_POST
      $this->nom = $_POST['nom' ];
      $this->prenom = $_POST['prenom'];
      
    } else if($this->id != '') {
      // Récupère les données du member/stagiaire via son id
      $query = "SELECT * FROM members WHERE id=$this->id";
      $result = mysql_query($query) or die('Échec de la requête : ' . mysql_error());
      
      $member = mysql_fetch_object($result);

      $this->nom = $member->nom;
      $this->prenom = $member->prenom;
    }
  }
    
  // Sélectionner tous les stages
  function all() {
    $query = 'SELECT * FROM members';
    $result = mysql_query($query) or die('Échec de la requête : ' . mysql_error());
    $t_result = [];

    while ($line = mysql_fetch_object($result)) {
      $t_result[] = $line;
    }
    return $t_result;
  }

  // enregistrer un nouveau membre/stagiaire dans la base
  function save(){
    $query = "INSERT INTO members (nom, prenom) VALUES ('$this->nom', '$this->prenom')";
    $result = mysql_query($query) or die('Échec de la requête : ' . mysql_error() . $query);
    }
    
  // met à jour un membre/stagiaire dans la base
  function update(){
    $query = "UPDATE members SET nom='$this->nom', prenom='$this->prenom' WHERE id=$this->id";
    $result = mysql_query($query) or die('Échec de la requête : ' . mysql_error() . $query);
    }
    
  // supprimer un membre/stagiaire de la base
  function destroy(){
    $query = "DELETE FROM members WHERE id=$this->id";
    $result = mysql_query($query) or die('Échec de la requête : ' . mysql_error() . $query);
    }

}

?>
