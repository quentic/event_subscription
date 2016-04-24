<?php
// un stage auquel peuvent s'inscrire des stagiaires
// an event which members can subscribe to
class Event{

  function __construct(){
    $this->id = $_GET['id'];

    if (!empty($_POST)) {
      // Récupère les données du event/stage via le $_POST
      $this->masquer = $_POST['masquer'];
      $this->nom = $_POST['nom' ];
      $this->periode = $_POST['periode'];
      
    } else if($this->id != '') {
      // Récupère les données du event/stage via son id
      $query = "SELECT * FROM events WHERE id=$this->id";
      $result = mysql_query($query) or die('Échec de la requête : ' . mysql_error());
      
      $member = mysql_fetch_object($result);

      $this->masquer = $member->masquer;
      $this->nom = $member->nom;
      $this->periode = $member->periode;
    }
  }
    
   // Sélectionner tous les stages
   function all() {
     $query = 'SELECT * FROM events ORDER BY id';
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
    
  // met à jour un event/stage dans la base
  function update(){
    $query = "UPDATE events SET masquer='$this->masquer', nom='$this->nom', periode='$this->periode' WHERE id=$this->id";
    $result = mysql_query($query) or die('Échec de la requête : ' . mysql_error() . $query);
    }
    
   // supprimer un event/stage de la base
   function destroy(){
     $query = "DELETE FROM events WHERE id=$this->id";
     $result = mysql_query($query) or die('Échec de la requête : ' . mysql_error() . $query);
     }
}

?>
