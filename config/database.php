<?php

  // Connexion et sélection de la base
  $hostname = 'localhost';
  $username = 'root';
  $password = 'Pass123.';
  $db_name = 'o2';

  $conn = mysql_connect($hostname, $username, $password)
    or die('Impossible de se connecter : ' . mysql_error());
  //echo 'Connected successfully';

  mysql_select_db($db_name) or die('Impossible de sélectionner la base de données');

  mysql_query("SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_connection = 'utf8', character_set_database = 'utf8', character_set_server = 'utf8'", $conn);
?>