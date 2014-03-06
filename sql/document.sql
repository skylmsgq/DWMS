/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50613
Source Host           : localhost:3306
Source Database       : dwms

Target Server Type    : MYSQL
Target Server Version : 50613
File Encoding         : 65001

Date: 2014-03-06 14:59:40
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `document`
-- ----------------------------
DROP TABLE IF EXISTS `document`;
CREATE TABLE `document` (
  `document_id` int(11) NOT NULL AUTO_INCREMENT,
  `form_name` varchar(255) DEFAULT NULL,
  `document_save_path` varchar(255) DEFAULT NULL,
  `document_original_name` varchar(255) DEFAULT NULL,
  `document_save_name` varchar(255) DEFAULT NULL,
  `document_size` varchar(255) DEFAULT NULL,
  `document_mime_type` varchar(255) DEFAULT NULL,
  `document_suffix_type` varchar(255) DEFAULT NULL,
  `document_hash_string` text,
  `document_upload_time` datetime DEFAULT NULL,
  `document_delete_time` datetime DEFAULT NULL,
  `document_status` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`document_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of document
-- ----------------------------
