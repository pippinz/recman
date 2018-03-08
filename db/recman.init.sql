/*
Navicat MySQL Data Transfer

Source Server         : LOC rawatkul_rml
Source Server Version : 50527
Source Host           : localhost:3306
Source Database       : rawatkul_rml

Target Server Type    : MYSQL
Target Server Version : 50527
File Encoding         : 65001

Date: 2018-03-08 11:26:54
*/

SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for `groups`
-- ----------------------------
DROP TABLE IF EXISTS `groups`;
CREATE TABLE `groups` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `description` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of groups
-- ----------------------------
INSERT INTO `groups` VALUES ('1', 'admin', 'Administrator');
INSERT INTO `groups` VALUES ('2', 'members', 'General User');

-- ----------------------------
-- Table structure for `login_attempts`
-- ----------------------------
DROP TABLE IF EXISTS `login_attempts`;
CREATE TABLE `login_attempts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(15) NOT NULL,
  `login` varchar(100) NOT NULL,
  `time` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of login_attempts
-- ----------------------------

-- ----------------------------
-- Table structure for `tb_file`
-- ----------------------------
DROP TABLE IF EXISTS `tb_file`;
CREATE TABLE `tb_file` (
  `id` mediumint(9) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  `location` varchar(64) NOT NULL COMMENT 'Location',
  `date` date DEFAULT NULL,
  `year` smallint(6) DEFAULT NULL,
  `category` varchar(32) NOT NULL,
  `volume` varchar(64) NOT NULL DEFAULT '0',
  `desc` varchar(4000) DEFAULT NULL,
  `directory` varchar(128) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '0:Inactive; 1:Active',
  `created` datetime DEFAULT NULL,
  `creator` varchar(16) DEFAULT NULL,
  `edited` datetime DEFAULT NULL,
  `editor` varchar(16) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=30 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tb_file
-- ----------------------------
INSERT INTO `tb_file` VALUES ('28', 'Training Module 01', '920-A02', '2017-05-01', '2012', 'history', 'vol-01', 'It\'s only a test\r\nPlease ignore', null, '1', '2017-06-10 18:26:32', 'administrator', '2017-06-11 00:40:26', 'administrator');
INSERT INTO `tb_file` VALUES ('29', 'Training Module 04', '920-A03', null, null, '', '', '', null, '1', '2017-06-11 01:08:48', 'administrator', '2017-06-22 13:13:06', 'administrator');

-- ----------------------------
-- Table structure for `tb_file_doc`
-- ----------------------------
DROP TABLE IF EXISTS `tb_file_doc`;
CREATE TABLE `tb_file_doc` (
  `id` mediumint(9) unsigned NOT NULL AUTO_INCREMENT,
  `fileid` mediumint(9) unsigned NOT NULL,
  `name` varchar(128) NOT NULL,
  `doc_date` date DEFAULT NULL,
  `process_date` date DEFAULT NULL,
  `desc` varchar(4000) DEFAULT NULL,
  `pic` varchar(64) DEFAULT NULL COMMENT 'Person in charge',
  `created` datetime DEFAULT NULL,
  `creator` varchar(16) DEFAULT NULL,
  `edited` datetime DEFAULT NULL,
  `editor` varchar(16) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tb_file_doc
-- ----------------------------
INSERT INTO `tb_file_doc` VALUES ('20', '28', 'Document Dummy', null, null, '', 'ismail', '2017-06-11 00:38:57', 'administrator', '2017-06-21 18:32:44', 'administrator');

-- ----------------------------
-- Table structure for `tb_lkp`
-- ----------------------------
DROP TABLE IF EXISTS `tb_lkp`;
CREATE TABLE `tb_lkp` (
  `id` mediumint(9) unsigned NOT NULL AUTO_INCREMENT,
  `lkp` varchar(64) NOT NULL,
  `access` varchar(8) DEFAULT 'user' COMMENT 'user=users, admin=admin',
  `type` varchar(8) DEFAULT 'str' COMMENT 'num=numeric, str=string',
  `name` varchar(64) NOT NULL,
  `created` datetime DEFAULT NULL,
  `creator` varchar(16) DEFAULT NULL,
  `edited` datetime DEFAULT NULL,
  `editor` varchar(16) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tb_lkp_idx1` (`lkp`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tb_lkp
-- ----------------------------
INSERT INTO `tb_lkp` VALUES ('1', 'file.location', 'user', 'str', 'File Location', null, null, null, null);
INSERT INTO `tb_lkp` VALUES ('2', 'file.category', 'user', 'str', 'File Category', null, null, null, null);
INSERT INTO `tb_lkp` VALUES ('3', 'file.volume', 'user', 'str', 'File Volume', null, null, null, null);
INSERT INTO `tb_lkp` VALUES ('4', 'document.pic', 'user', 'str', 'Document Person In Charge', null, null, null, null);

-- ----------------------------
-- Table structure for `tb_lkpi`
-- ----------------------------
DROP TABLE IF EXISTS `tb_lkpi`;
CREATE TABLE `tb_lkpi` (
  `id` mediumint(9) unsigned NOT NULL AUTO_INCREMENT,
  `lkp` varchar(64) NOT NULL,
  `num` mediumint(9) NOT NULL,
  `str` varchar(64) DEFAULT NULL,
  `name` varchar(64) NOT NULL,
  `created` datetime DEFAULT NULL,
  `creator` varchar(16) DEFAULT NULL,
  `edited` datetime DEFAULT NULL,
  `editor` varchar(16) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tb_lkp_idx1` (`creator`,`lkp`,`str`,`num`)
) ENGINE=MyISAM AUTO_INCREMENT=29 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tb_lkpi
-- ----------------------------
INSERT INTO `tb_lkpi` VALUES ('1', 'file.location', '0', '920-A01', '920-A01', null, 'administrator', '2017-06-25 11:43:19', 'administrator');
INSERT INTO `tb_lkpi` VALUES ('2', 'file.location', '0', '920-A02', '920-A02', null, 'administrator', null, null);
INSERT INTO `tb_lkpi` VALUES ('3', 'file.location', '0', '920-A03', '920-A03', null, 'administrator', null, null);
INSERT INTO `tb_lkpi` VALUES ('4', 'file.location', '0', '920-B01', '920-B01', null, 'administrator', null, null);
INSERT INTO `tb_lkpi` VALUES ('5', 'file.category', '0', 'history', 'History', null, 'administrator', null, null);
INSERT INTO `tb_lkpi` VALUES ('6', 'file.category', '0', 'economics', 'Economics', null, 'administrator', '2017-06-19 03:19:09', 'administrator');
INSERT INTO `tb_lkpi` VALUES ('7', 'file.category', '0', 'finance', 'Finance', null, 'administrator', '2017-06-22 13:18:38', 'administrator');
INSERT INTO `tb_lkpi` VALUES ('8', 'file.volume', '0', 'vol-01', 'Volume 01', null, 'administrator', null, null);
INSERT INTO `tb_lkpi` VALUES ('9', 'file.volume', '0', 'vol-02', 'Volume 02', null, 'administrator', '2017-06-24 12:18:56', 'administrator');
INSERT INTO `tb_lkpi` VALUES ('10', 'document.pic', '0', 'upin-ipin', 'Upin Ipin', null, 'administrator', null, null);
INSERT INTO `tb_lkpi` VALUES ('11', 'document.pic', '0', 'ismail', 'Ismail', null, 'administrator', null, null);
INSERT INTO `tb_lkpi` VALUES ('12', 'document.pic', '0', 'ihsan', 'Ihsan', null, 'administrator', null, null);
INSERT INTO `tb_lkpi` VALUES ('13', 'document.pic', '0', 'jarjit', 'Jarjit Singh', null, 'administrator', null, null);
INSERT INTO `tb_lkpi` VALUES ('14', 'document.pic', '0', 'susanti', 'Susanti', null, 'administrator', '2017-06-19 18:08:55', 'administrator');
INSERT INTO `tb_lkpi` VALUES ('15', 'file.volume', '0', 'vol-03', 'Volume 03', '2017-06-19 03:35:53', 'administrator', '2017-06-19 10:44:26', 'administrator');
INSERT INTO `tb_lkpi` VALUES ('16', 'file.location', '0', '920-A01', '920-A01', '2017-06-19 03:37:19', 'administrator', '2017-06-19 10:35:57', 'administrator');
INSERT INTO `tb_lkpi` VALUES ('17', 'file.location', '0', '920-B02', '920-B02', '2017-06-19 10:36:40', 'administrator', null, null);
INSERT INTO `tb_lkpi` VALUES ('18', 'file.volume', '0', 'vol-04', 'Volume 04', '2017-06-19 10:44:31', 'administrator', '2017-06-19 10:44:49', 'administrator');
INSERT INTO `tb_lkpi` VALUES ('27', 'document.pic', '0', 'izzwan', 'Izzwan', '2017-06-25 11:57:45', 'administrator', null, null);
INSERT INTO `tb_lkpi` VALUES ('28', 'document.pic', '0', 'raidah', 'Raidah', '2017-06-25 11:58:13', 'administrator', null, null);
INSERT INTO `tb_lkpi` VALUES ('24', 'document.pic', '0', 'susanti', 'Susanti', '2017-06-19 18:08:57', 'administrator', null, null);
INSERT INTO `tb_lkpi` VALUES ('25', 'document.pic', '0', 'susanti25', 'Susanti 25', '2017-06-19 18:09:18', 'administrator', '2017-06-21 18:27:35', 'administrator');
INSERT INTO `tb_lkpi` VALUES ('26', 'document.pic', '0', 'susanti dua enam', 'Susanti Dua Enam', '2017-06-21 18:28:29', 'administrator', '2017-06-21 18:35:18', 'administrator');

-- ----------------------------
-- Table structure for `users`
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(45) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `salt` varchar(255) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `activation_code` varchar(40) DEFAULT NULL,
  `forgotten_password_code` varchar(40) DEFAULT NULL,
  `forgotten_password_time` int(11) unsigned DEFAULT NULL,
  `remember_code` varchar(40) DEFAULT NULL,
  `created_on` int(11) unsigned NOT NULL,
  `last_login` int(11) unsigned DEFAULT NULL,
  `active` tinyint(1) unsigned DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `company` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES ('1', '127.0.0.1', 'administrator', '$2a$07$SeBknntpZror9uyftVopmu61qg0ms8Qv1yV6FG.kQOSM.9QhmTo36', '', 'admin@recordsmanager.com', '', 'YsYnSEa82O4vyCE6cQlE7.de1526820366281db8', '1497331309', 'tRBye3PdIx8BzF4khpGrEu', '1268889823', '1510132367', '1', 'Admin', 'istrator', 'ADMIN', '0');
INSERT INTO `users` VALUES ('2', '127.0.0.1', 'userone', '$2y$08$uO9k6abXxVP4bZwj9q26SurZTkZb9R0mPw9F7MiHcz3U.aoZ6xVZC', null, 'user1@recordsmanager.loc', 'c451eb728c79f3e803fe663f172539283d3ec56a', null, null, null, '1498910440', null, '0', 'User', '1 One', 'Co', '+60');
INSERT INTO `users` VALUES ('3', '127.0.0.1', 'johndoe', '$2y$08$6Qm9HyugZZWWfCwtWMWD4.se9tZJa2Wiju4ZRoYDiLrvRxjSKl1E.', null, 'john@doe.com', null, null, null, 'Yx1MEkwZ2kT7P6Y3bxfx5.', '1498932723', '1498934195', '1', 'John', 'Doe', null, null);

-- ----------------------------
-- Table structure for `users_groups`
-- ----------------------------
DROP TABLE IF EXISTS `users_groups`;
CREATE TABLE `users_groups` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `group_id` mediumint(8) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uc_users_groups` (`user_id`,`group_id`),
  KEY `fk_users_groups_users1_idx` (`user_id`),
  KEY `fk_users_groups_groups1_idx` (`group_id`),
  CONSTRAINT `fk_users_groups_groups1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `fk_users_groups_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of users_groups
-- ----------------------------
INSERT INTO `users_groups` VALUES ('1', '1', '1');
INSERT INTO `users_groups` VALUES ('2', '1', '2');
INSERT INTO `users_groups` VALUES ('3', '2', '2');
INSERT INTO `users_groups` VALUES ('4', '3', '2');

-- ----------------------------
-- View structure for `vi_docs_files`
-- ----------------------------
DROP VIEW IF EXISTS `vi_docs_files`;
CREATE VIEW `vi_docs_files` AS select `a`.`id` AS `fileid`,`a`.`name` AS `filename`,`a`.`location` AS `filelocation`,`a`.`date` AS `filedate`,`a`.`year` AS `fileyear`,`a`.`category` AS `filecategory`,`a`.`volume` AS `filevolume`,`a`.`directory` AS `filedirectory`,`a`.`status` AS `filestatus`,`a`.`desc` AS `filedesc`,`a`.`created` AS `filecreated`,`a`.`creator` AS `filecreator`,`b`.`id` AS `docid`,`b`.`name` AS `docname`,`b`.`doc_date` AS `docdate`,`b`.`process_date` AS `docprocessdate`,`b`.`desc` AS `docdesc`,`b`.`pic` AS `docpic`,`b`.`created` AS `doccreated`,`b`.`creator` AS `doccreator` from (`tb_file` `a` join `tb_file_doc` `b` on((`a`.`id` = `b`.`fileid`)));

-- ----------------------------
-- View structure for `vi_files_docs`
-- ----------------------------
DROP VIEW IF EXISTS `vi_files_docs`;
CREATE VIEW `vi_files_docs` AS select `a`.`id` AS `fileid`,`a`.`name` AS `filename`,`a`.`location` AS `filelocation`,`a`.`date` AS `filedate`,`a`.`year` AS `fileyear`,`a`.`category` AS `filecategory`,`a`.`volume` AS `filevolume`,`a`.`directory` AS `filedirectory`,`a`.`status` AS `filestatus`,`a`.`desc` AS `filedesc`,`a`.`created` AS `filecreated`,`a`.`creator` AS `filecreator`,`b`.`id` AS `docid`,`b`.`name` AS `docname`,`b`.`doc_date` AS `docdate`,`b`.`process_date` AS `docprocessdate`,`b`.`desc` AS `docdesc`,`b`.`pic` AS `docpic`,`b`.`created` AS `doccreated`,`b`.`creator` AS `doccreator` from (`tb_file` `a` left join `tb_file_doc` `b` on((`a`.`id` = `b`.`fileid`)));
