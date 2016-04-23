<?php
// un stage auquel peuvent s'inscrire des stagiaires
// an event which members can subscribe to
class Event{

  function __construct($t_data){
    $this->id = $t_data['id' ];
    $this->nom = $t_data['nom' ];
    $this->periode = $t_data['periode'];
  }
    
   // Sélectionner tous les stages
   function all() {
     $query = 'SELECT * FROM events';
     $result = mysql_query($query) or die('Échec de la requête : ' . mysql_error());
     $t_result = [];

     while ($line = mysql_fetch_object($result)) {
       $t_result[] = $line;
     }
     return $t_result;
   }
    
   // enregistrer un nouveau event/stage dans la base
   function save(){
     $query = "INSERT INTO events (nom, periode) VALUES ('$this->nom', '$this->periode')";
     $result = mysql_query($query) or die('Échec de la requête : ' . mysql_error() . $query);
     }
    
   // supprimer un event/stage de la base
   function destroy(){
     $query = "DELETE FROM events WHERE id=$this->id";
     $result = mysql_query($query) or die('Échec de la requête : ' . mysql_error() . $query);
     }
}

?>
