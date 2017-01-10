<?php

  // Connexion et sélection de la base
  $hostname = 'localhost';
  $username = 'root';
  $password = 'root';
  $db_name = 'o2';

  $mysqli = new mysqli($hostname, $username, $password, $db_name);
  if (mysqli_connect_errno($mysqli)) {
    echo "Echec lors de la connexion à MySQL : " . mysqli_connect_error();
  }

  $mysqli->query("SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_connection = 'utf8', character_set_database = 'utf8', character_set_server = 'utf8'");

  // database table creation
  function database_table_init(){
  	$mysqli->query("
      SET NAMES utf8;
      SET foreign_key_checks = 0;
      SET time_zone = 'SYSTEM';
      SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

      DROP TABLE IF EXISTS `events`;
      CREATE TABLE `events` (
        `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
        `datedebut` date NOT NULL DEFAULT '0000-00-00' COMMENT ' Date début du stage',
        `datefin` date NOT NULL DEFAULT '0000-00-00' COMMENT ' Date fin du stage',
        `lieu` varchar(50) COLLATE latin1_general_ci NOT NULL DEFAULT '' COMMENT ' Ex : Sölden',
        `masque` tinyint(1) NOT NULL DEFAULT '0',
        PRIMARY KEY (`id`),
        KEY `masquer` (`masque`)
      ) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;


      DROP TABLE IF EXISTS `events_members`;
      CREATE TABLE `events_members` (
        `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
        `member_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'id de l’adhérent',
        `event_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'id du stage',
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
        `masque` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1 to hide member in displays',
        PRIMARY KEY (`id`),
        KEY `masquer` (`masque`),
        KEY `nom` (`nom`),
        KEY `prenom` (`prenom`)
      ) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;


      DROP VIEW IF EXISTS `active_events`;
      CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `active_events` AS select count(`events_members`.`member_id`) AS `nb_inscrits`,`events`.`id` AS `id`,`events`.`datedebut` AS `datedebut`,`events`.`datefin` AS `datefin`,`events`.`lieu` AS `lieu`,`events`.`placedispo` AS `placedispo`,`events`.`observation` AS `observation`,`events`.`titre` AS `titre`,`events`.`descriptif` AS `descriptif`,`events`.`cpterendu` AS `cpterendu`,`events`.`image` AS `image`,`events`.`masque` AS `masque` from (`events` join `events_members` on((`events_members`.`event_id` = `events`.`id`))) where (not(`events`.`masque`)) group by `events`.`id`;

      DROP VIEW IF EXISTS `active_members`;
      CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `active_members` AS select `members`.`id` AS `id`,`members`.`nom` AS `nom`,`members`.`prenom` AS `prenom`,`members`.`masque` AS `masque` from `members` where (not(`members`.`masque`)) order by `members`.`nom`,`members`.`prenom`;

      DROP VIEW IF EXISTS `membres sans stage`;
      CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `membres sans stage` AS select `members`.`id` AS `id` from ((`members` left join `events_members` on((`events_members`.`member_id` = `members`.`id`))) left join `events` on((`events_members`.`event_id` = `events`.`id`))) group by `members`.`id` having (sum(if((`events`.`id` is not null),1,0)) = 0);
   ");
  }
?>
