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
        `lieu` varchar(50) COLLATE latin1_general_ci NOT NULL DEFAULT '' COMMENT ' Ex : Sölden',
        `placedispo` tinyint(3) unsigned DEFAULT '0' COMMENT ' Nb de places maximum',
        `observation` varchar(255) COLLATE latin1_general_ci DEFAULT NULL,
        `titre` varchar(255) COLLATE latin1_general_ci DEFAULT NULL,
        `descriptif` text COLLATE latin1_general_ci,
        `cpterendu` text COLLATE latin1_general_ci,
        `image` varchar(255) COLLATE latin1_general_ci DEFAULT NULL,
        `masque` tinyint(1) NOT NULL DEFAULT '0',
        PRIMARY KEY (`id`),
        KEY `masquer` (`masque`)
      ) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;


      DROP TABLE IF EXISTS `events_members`;
      CREATE TABLE `events_members` (
        `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
        `member_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'id de l’adhérent',
        `event_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'id du stage',
        `materiel` varchar(255) COLLATE latin1_general_ci DEFAULT '0' COMMENT ' Matériel à prêter (crampons, etc..)',
        `moniteur` tinyint(1) NOT NULL DEFAULT '0' COMMENT '=1 si le stagiaire est mono de ce stage',
        `pieton` tinyint(1) NOT NULL DEFAULT '0' COMMENT ' Non skieur',
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
        `datenaissance` date NOT NULL DEFAULT '0000-00-00',
        `adresse` varchar(255) COLLATE latin1_general_ci NOT NULL DEFAULT '',
        `cp` int(11) NOT NULL DEFAULT '0' COMMENT 'Code postal',
        `ville` varchar(100) COLLATE latin1_general_ci NOT NULL DEFAULT '',
        `email` varchar(100) COLLATE latin1_general_ci DEFAULT NULL,
        `telfixe` varchar(18) COLLATE latin1_general_ci DEFAULT NULL,
        `telportable` varchar(18) COLLATE latin1_general_ci DEFAULT NULL,
        `niveau` smallint(6) DEFAULT NULL COMMENT 'Niveau de ski (nombre) ',
        `photo` varchar(50) COLLATE latin1_general_ci DEFAULT NULL COMMENT 'Nom du fichier photo',
        `observation` varchar(255) COLLATE latin1_general_ci DEFAULT NULL,
        `date_adh` date DEFAULT NULL COMMENT 'Date de première adhésion',
        `mono` varchar(1) COLLATE latin1_general_ci DEFAULT NULL COMMENT 'Si c’est un mono ou pas',
        `diplome` varchar(250) COLLATE latin1_general_ci DEFAULT NULL COMMENT 'Nom de son diplôme (pas utilisé)',
        `photo2` varchar(250) COLLATE latin1_general_ci NOT NULL COMMENT 'Pas utilisé',
        `masque` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1 pour masquer le membre dans les affichages',
        PRIMARY KEY (`id`),
        KEY `masquer` (`masque`),
        KEY `nom` (`nom`),
        KEY `prenom` (`prenom`)
      ) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;


      DROP TABLE IF EXISTS `niveaux`;
      CREATE TABLE `niveaux` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `numniveau` smallint(6) NOT NULL DEFAULT '0',
        `libniveau` varchar(16) COLLATE latin1_general_ci NOT NULL DEFAULT '',
        PRIMARY KEY (`id`),
        UNIQUE KEY `numniveau` (`numniveau`)
      ) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;


      DROP VIEW IF EXISTS `active_events`;
      CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `active_events` AS select `events`.`id` AS `id`,`events`.`datedebut` AS `datedebut`,`events`.`datefin` AS `datefin`,`events`.`lieu` AS `lieu`,`events`.`placedispo` AS `placedispo`,`events`.`observation` AS `observation`,`events`.`titre` AS `titre`,`events`.`descriptif` AS `descriptif`,`events`.`cpterendu` AS `cpterendu`,`events`.`image` AS `image`,`events`.`masque` AS `masque` from `events` where (not(`events`.`masque`));

      DROP VIEW IF EXISTS `active_members`;
      CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `active_members` AS select `members`.`id` AS `id`,`members`.`nom` AS `nom`,`members`.`prenom` AS `prenom`,`members`.`datenaissance` AS `datenaissance`,`members`.`adresse` AS `adresse`,`members`.`cp` AS `cp`,`members`.`ville` AS `ville`,`members`.`email` AS `email`,`members`.`telfixe` AS `telfixe`,`members`.`telportable` AS `telportable`,`members`.`niveau` AS `niveau`,`members`.`photo` AS `photo`,`members`.`observation` AS `observation`,`members`.`date_adh` AS `date_adh`,`members`.`mono` AS `mono`,`members`.`diplome` AS `diplome`,`members`.`photo2` AS `photo2`,`members`.`masque` AS `masque` from `members` where (not(`members`.`masque`)) order by `members`.`nom`,`members`.`prenom`;

      DROP VIEW IF EXISTS `membres sans stage`;
      CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `membres sans stage` AS select `members`.`id` AS `id` from ((`members` left join `events_members` on((`events_members`.`member_id` = `members`.`id`))) left join `events` on((`events_members`.`event_id` = `events`.`id`))) group by `members`.`id` having (sum(if((`events`.`id` is not null),1,0)) = 0);

      DROP VIEW IF EXISTS `membres_dernier_stage_en_2014`;
      CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `membres_dernier_stage_en_2014` AS select `events_members`.`member_id` AS `member_id` from ((`events_members` join `events` on((`events_members`.`event_id` = `events`.`id`))) join `members` on((`events_members`.`member_id` = `members`.`id`))) group by `events_members`.`member_id` having (max(`events`.`datedebut`) <= '2014-12-31') order by `events_members`.`member_id`;
   ");
  }
?>
