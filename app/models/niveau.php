<?php

// un niveau de stagiaire
// a level of a member
class Niveau{

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
      // Récupère les données du niveau via $_POST (new)
      $this->init($_POST);

    } else {
      $this->init([]);

    }
  }

  // constructeur avec 1 paramètre
  public function __construct1($id){
    $this->id = $id;

    if (!empty($_POST)) {
      // Récupère les données du niveau via le $_POST
      $this->init($_POST);

    } else {
      // Récupère les données du niveau via son id
      $query = "SELECT * FROM niveaux WHERE id=$id";
      $result = mysql_query($query) or die('Échec de la requête : ' . mysql_error());
      $niveau = mysql_fetch_array($result);

      $this->init($niveau);
    }
  }

  // Sélectionner tous les niveaux
  function all() {
    $query = 'SELECT * FROM niveaux ORDER BY numniveau ASC';;
    $result = mysql_query($query) or die('Échec de la requête : ' . mysql_error());
    $t_result = [];

    while ($line = mysql_fetch_object($result)) {
      $t_result[] = $line;
    }
    return $t_result;
  }

  // Sélectionner tous les niveaux : résultat = tableau associatif numniveau => libniveau
  function all_num_lib() {
    $query = 'SELECT * FROM niveaux ORDER BY numniveau ASC';;
    $result = mysql_query($query) or die('Échec de la requête : ' . mysql_error());
    $t_result = [];

    while ($line = mysql_fetch_object($result)) {
      $t_result[$line->numniveau] = $line->libniveau;
    }
    return $t_result;
  }

  // enregistrer un nouveau niveau dans la base
  function save(){
    $query = "INSERT INTO niveaux (numniveau, libniveau)
              VALUES ('$this->numniveau', '$this->libniveau')";
    $result = mysql_query($query) or die('Échec de la requête : ' . mysql_error() . $query);
    }

  // met à jour un niveau dans la base
  function update(){
    $query = "UPDATE niveaux
              SET numniveau='$this->numniveau', libniveau='$this->libniveau'
              WHERE id=$this->id";
    $result = mysql_query($query) or die('Échec de la requête : ' . mysql_error() . $query);
    }

  // supprimer un niveau de la base
  function destroy(){
    $query = "DELETE FROM niveaux WHERE id=$this->id";
    $result = mysql_query($query) or die('Échec de la requête : ' . mysql_error() . $query);
    }

  # initialise l'objet avec le tableau fourni en paramètre
  protected function init($t_init){
    $this->numniveau = $t_init['numniveau'];
    $this->libniveau = $t_init['libniveau'];
  }

}

?>
