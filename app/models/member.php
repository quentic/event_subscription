<?php

# a member who can subscribe to an event
class Member{

  public function __construct(){
    $get_arguments       = func_get_args();
    $number_of_arguments = func_num_args();

    if (method_exists($this, $method_name = '__construct'.$number_of_arguments)) {
      call_user_func_array(array($this, $method_name), $get_arguments);
    }
  }

  # constructor with no parameter
  public function __construct0(){
    if (!empty($_POST)) {
      # Gets event data by $_POST (action : create)
      $this->init($_POST);

    } else {
      # Initializes a new member (action : new)
      $this->init([]);
      # By default, he subscribes today
      $this->date_adh = date("Y-m-d");
    }
  }

  # constructor with 1 parameter
  public function __construct1($id){
    global $mysqli;

    $this->id = $id;

    if (!empty($_POST)) {
      # Gets member data via $_POST (action : update)
      $this->init($_POST);

    } else {
      # Gets member data by id (action : edit)
      $query = "SELECT * FROM members WHERE id=$id";
      $result = $mysqli->query($query) or die('Échec de la requête : ' . mysql_error());
      $member = $result->fetch_array();

      $this->init($member);
    }
  }

  # Select all members
  function all() {
    global $mysqli;

    $query = 'SELECT * FROM members ORDER BY nom, prenom ASC';
    $result = $mysqli->query($query) or die('Échec de la requête : ' . mysql_error());
    $t_result = [];

    while ($line = $result->fetch_object()) {
      $t_result[] = $line;
    }
    return $t_result;
  }

  # saves new member in database
  function save(){
    global $mysqli;

    $query = "INSERT INTO members (nom, prenom)
              VALUES ('$this->nom', '$this->prenom')";
    $result = $mysqli->query($query) or die('Échec de la requête : ' . mysql_error() . $query);
    }

  # updates new member in database
  function update(){
    global $mysqli;

    $query = "UPDATE members
              SET
                masque='$this->masque', nom='$this->nom', prenom='$this->prenom'
              WHERE
                id=$this->id";
    $result = $mysqli->query($query) or die('Échec de la requête : ' . mysql_error() . $query);
    }

  # updates shown/hidden indicator in database
  function update_masque(){
    global $mysqli;

    $query = "UPDATE members
              SET
                masque='$this->masque'
              WHERE
                id=$this->id";
    $result = $mysqli->query($query) or die('Échec de la requête : ' . mysql_error() . $query);
    }

   # destroys a member in database
  function destroy(){
    global $mysqli;

    $query = "DELETE FROM members WHERE id=$this->id";
    $result = $mysqli->query($query) or die('Échec de la requête : ' . mysql_error() . $query);
    }

  # initialize objet with array given in parameter
  protected function init($t_init){
    $this->masque         = $t_init['masque'];
    $this->nom            = $t_init['nom' ];
    $this->prenom         = $t_init['prenom'];
  }

}

?>
