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
      $this->nom = $_POST['nom' ];
      $this->periode = $_POST['periode'];

    } else {
      $this->nom = '';
      $this->periode = '';

    }
  }

  // constructeur avec 1 paramètre
  public function __construct1($id){
    $this->id = $id;

    if (!empty($_POST)) {
      // Récupère les données du event/stage via $_POST (update)
      $this->masquer = $_POST['masquer'];
      $this->nom = $_POST['nom' ];
      $this->periode = $_POST['periode'];

    } else {
      // Récupère les données du event/stage via son id
      $query = "SELECT * FROM events WHERE id=$id";
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
