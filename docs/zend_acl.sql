/*

Source Server         : MySQL
Source Server Version : 50707
Source Host           : localhost:3306
Source Database       : zend_acl

Target Server Type    : MYSQL
Target Server Version : 50707
File Encoding         : 65001

*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `acl`
-- ----------------------------
DROP TABLE IF EXISTS `acl`;
CREATE TABLE `acl` (
  `id_acl` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `controller` varchar(100) NOT NULL,
  `action` varchar(100) NOT NULL,
  PRIMARY KEY (`id_acl`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of acl
-- ----------------------------
INSERT INTO `acl` VALUES ('1', 'auth', 'index');
INSERT INTO `acl` VALUES ('2', 'auth', 'login');
INSERT INTO `acl` VALUES ('3', 'noticias', 'index');
INSERT INTO `acl` VALUES ('4', 'noticias', 'adicionar');
INSERT INTO `acl` VALUES ('5', 'usuarios', 'writer');
INSERT INTO `acl` VALUES ('6', 'usuarios', 'adicionar');
INSERT INTO `acl` VALUES ('7', 'auth', 'logout');

-- ----------------------------
-- Table structure for `acl_roles`
-- ----------------------------
DROP TABLE IF EXISTS `acl_roles`;
CREATE TABLE `acl_roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_role` int(10) unsigned NOT NULL,
  `id_acl` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_role` (`id_role`),
  KEY `fk_acl` (`id_acl`),
  CONSTRAINT `fk_acl` FOREIGN KEY (`id_acl`) REFERENCES `acl` (`id_acl`),
  CONSTRAINT `fk_role` FOREIGN KEY (`id_role`) REFERENCES `roles` (`id_role`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of acl_roles
-- ----------------------------
INSERT INTO `acl_roles` VALUES ('1', '1', '1');
INSERT INTO `acl_roles` VALUES ('2', '1', '2');
INSERT INTO `acl_roles` VALUES ('3', '2', '3');
INSERT INTO `acl_roles` VALUES ('4', '2', '4');
INSERT INTO `acl_roles` VALUES ('5', '3', '5');
INSERT INTO `acl_roles` VALUES ('6', '3', '6');
INSERT INTO `acl_roles` VALUES ('7', '2', '7');

-- ----------------------------
-- Table structure for `inherit`
-- ----------------------------
DROP TABLE IF EXISTS `inherit`;
CREATE TABLE `inherit` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_role` int(10) unsigned NOT NULL,
  `id_role_rel` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of inherit
-- ----------------------------
INSERT INTO `inherit` VALUES ('1', '2', '1');
INSERT INTO `inherit` VALUES ('2', '3', '2');

-- ----------------------------
-- Table structure for `roles`
-- ----------------------------
DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles` (
  `id_role` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `role` varchar(20) NOT NULL,
  `role_default` bit(1) NOT NULL DEFAULT b'1',
  PRIMARY KEY (`id_role`),
  UNIQUE KEY `idx_role` (`role`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of roles
-- ----------------------------
INSERT INTO `roles` VALUES ('1', 'guest', '');
INSERT INTO `roles` VALUES ('2', 'writer', '');
INSERT INTO `roles` VALUES ('3', 'admin', '');

-- ----------------------------
-- Table structure for `users`
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id_user` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_role` int(11) NOT NULL,
  `login` varchar(30) NOT NULL,
  `password` varchar(60) NOT NULL,
  `nome` varchar(100) NOT NULL,
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES ('1', '2', 'rossano', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'Rossano');
INSERT INTO `users` VALUES ('2', '3', 'root', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'root');
