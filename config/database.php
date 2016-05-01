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

  // database table creation
  function database_table_init(){
  	mysql_query("
      SET NAMES utf8;
      SET foreign_key_checks = 0;
      SET time_zone = 'SYSTEM';
      SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

      DROP TABLE IF EXISTS `events`;
      CREATE TABLE `events` (
        `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
        `datedebut` date NOT NULL DEFAULT '0000-00-00' COMMENT ' Date début du stage',
        `datefin` date NOT NULL DEFAULT '0000-00-00' COMMENT ' Date fin du stage',
        `lieu` varchar(50) COLLATE latin1_general_ci NOT NULL DEFAULT '',
        `masque` tinyint(1) NOT NULL DEFAULT '0',
        PRIMARY KEY (`id`),
        KEY `masquer` (`masque`)
      ) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;


      DROP TABLE IF EXISTS `events_members`;
      CREATE TABLE `events_members` (
        `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
        `member_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'id de l’adhérent',
        `event_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'id du stage',
        `subscription_data1` varchar(255) COLLATE latin1_general_ci DEFAULT '0' COMMENT ' Data specific to subscription',
        PRIMARY KEY (`id`),
        UNIQUE KEY `event_id_member_id` (`event_id`,`member_id`),
        KEY `event_id` (`event_id`),
        KEY `member_id` (`member_id`),
        CONSTRAINT `events_members_ibfk_1` FOREIGN KEY (`member_id`) REFERENCES `members` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
        CONSTRAINT `events_members_ibfk_2` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
      ) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;


      DROP TABLE IF EXISTS `members`;
      CREATE TABLE `members` (
        `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
        `nom` varchar(50) COLLATE latin1_general_ci NOT NULL DEFAULT '',
        `prenom` varchar(50) COLLATE latin1_general_ci NOT NULL DEFAULT '',
        `masque` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1 pour masquer le membre dans les affichages',
        PRIMARY KEY (`id`),
        KEY `masquer` (`masque`),
        KEY `nom` (`nom`),
        KEY `prenom` (`prenom`)
      ) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;


      DROP VIEW IF EXISTS `active_events`;
      CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `active_events` AS select `events`.`id` AS `id`,`events`.`datedebut` AS `datedebut`,`events`.`datefin` AS `datefin`,`events`.`lieu` AS `lieu`,`events`.`masque` AS `masque` from `events` where (not(`events`.`masque`));

      DROP VIEW IF EXISTS `active_members`;
      CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `active_members` AS select `members`.`id` AS `id`,`members`.`nom` AS `nom`,`members`.`prenom` AS `prenom`, members`.`masque` AS `masque` from `members` where (not(`members`.`masque`)) order by `members`.`nom`,`members`.`prenom`;
   ");
  }
?>
