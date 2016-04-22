<?php

  // un stage auquel peuvent s'inscrire des stagiaires
  // an event which members can subscribe to
  class Event{
    function __construct($id, $nom, $periode){
      $this->id = $id;
      $this->nom = $nom;
      $this->periode = $periode;
    }
  }

?>