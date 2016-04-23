<?php

// un stagiaire qui peut s'inscrire à un stage
// a member that can subscribe to an event
class Member{

  function __construct($t_data){
    $this->id = $t_data['id' ];
    $this->nom = $t_data['nom' ];
    $this->prenom = $t_data['prenom'];
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
    
  // supprimer un membre/stagiaire de la base
  function destroy(){
    $query = "DELETE FROM members WHERE id=$this->id";
    $result = mysql_query($query) or die('Échec de la requête : ' . mysql_error() . $query);
    }

}

?>
