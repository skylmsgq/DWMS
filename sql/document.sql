/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50613
Source Host           : localhost:3306
Source Database       : dwms

Target Server Type    : MYSQL
Target Server Version : 50613
File Encoding         : 65001

Date: 2014-03-06 23:49:43
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
  `document_hash_string` varchar(255) DEFAULT NULL,
  `document_upload_time` datetime DEFAULT NULL,
  `document_delete_time` datetime DEFAULT NULL,
  `document_type` tinyint(4) DEFAULT NULL,
  `document_status` tinyint(4) DEFAULT NULL,
  `jurisdiction_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`document_id`),
  KEY `fk_jurisdiction_id_document` (`jurisdiction_id`),
  CONSTRAINT `fk_jurisdiction_id_document` FOREIGN KEY (`jurisdiction_id`) REFERENCES `jurisdiction` (`jurisdiction_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of document
-- ----------------------------
INSERT INTO `document` VALUES ('1', 'document', './Uploads/', 'Getting Started.pdf', 'Getting Started.pdf', '249159', 'application/pdf', 'pdf', '595ffb9bb8ca1a98b01e86a8674fa9f2', '2014-03-06 15:12:26', '2014-03-06 16:15:39', '1', '1', '3');
INSERT INTO `document` VALUES ('2', 'document', './Uploads/', 'Getting Started.pdf', 'Getting Started.pdf', '249159', 'application/pdf', 'pdf', '595ffb9bb8ca1a98b01e86a8674fa9f2', '2014-03-06 15:16:57', null, '1', '0', '3');
INSERT INTO `document` VALUES ('3', 'document', './Uploads/', '国家危险废物名录.pdf', '国家危险废物名录.pdf', '465877', 'application/pdf', 'pdf', 'f1a28e4b10dbb0492ba24ae3d63b9324', '2014-03-06 15:31:59', null, '0', '0', '3');
INSERT INTO `document` VALUES ('4', 'document', './Uploads/', '国民经济行业（GBT4754-2011）分类.doc', '国民经济行业（GBT4754-2011）分类.doc', '2329600', 'application/msword', 'doc', '27668f7b7f54fe78c3aa0c621fd0faf1', '2014-03-06 15:35:26', null, '0', '0', '3');
INSERT INTO `document` VALUES ('5', 'document', './Uploads/', '危险废弃物监控终端设备分析.pdf', '危险废弃物监控终端设备分析.pdf', '424525', 'application/pdf', 'pdf', '70fa3c5510beefd76000e3009da08dc1', '2014-03-06 17:01:15', null, '2', '0', '3');
INSERT INTO `document` VALUES ('6', 'document', './Uploads/', '“十二五”危险废物污染防治规划.pdf', '“十二五”危险废物污染防治规划.pdf', '391937', 'application/pdf', 'pdf', 'c616aca1aa56059c3a7b46a7aaf45d15', '2014-03-06 17:02:58', null, '0', '0', '3');
