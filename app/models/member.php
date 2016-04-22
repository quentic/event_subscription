<?php

  // un stagiaire qui peut s'inscrire à un stage
  // a member that can subscribe to an event
  class Member{
    function __construct($id, $nom, $prenom){
      $this->id = $id;
      $this->nom = $nom;
      $this->prenom = $prenom;
    }
  }

?>