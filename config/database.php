<?php

  // Connexion et sélection de la base
  $hostname = 'localhost';
  $username = 'root';
  $password = 'root';
  $db_name = 'o2';

  $conn = mysql_connect($hostname, $username, $password)
    or die('Impossible de se connecter : ' . mysql_error());
  //echo 'Connected successfully';

  mysql_select_db($db_name) or die('Impossible de sélectionner la base de données');

  mysql_query("SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_connection = 'utf8', character_set_database = 'utf8', character_set_server = 'utf8'", $conn);
  
  // o2 database table creation
  //funtion database_table_init(){
	  //mysql_query("CREATE TABLE IF NOT EXISTS members
		//(id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
		//nom VARCHAR(100),
		//prenom VARCHAR(100)
		//)  ENGINE='MyISAM' COLLATE 'utf8_general_ci';
	  //");  

	  //mysql_query("CREATE TABLE IF NOT EXISTS events
		//(id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
		//nom VARCHAR(100),
		//periode VARCHAR(100)
		//)  ENGINE='MyISAM' COLLATE 'utf8_general_ci';
	  //"); 

	  //mysql_query("CREATE TABLE IF NOT EXISTS events_members
		//(id INT NOT NULL AUTO_INCREMENT PRIMARY KEY, event_id int, 
		//member_id int, UNIQUE (event_id, member_id) )  
		//ENGINE='MyISAM';
	  //"); 
  //}
?>
