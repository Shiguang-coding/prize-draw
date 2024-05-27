/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50540
Source Host           : localhost:3306
Source Database       : 1776

Target Server Type    : MYSQL
Target Server Version : 50540
File Encoding         : 65001

Date: 2020-11-10 16:24:49
*/

SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for `1776_award`
-- ----------------------------
DROP TABLE IF EXISTS `1776_award`;
CREATE TABLE `1776_award` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `prize` varchar(100) CHARACTER SET utf8 DEFAULT '',
  `v` int(11) DEFAULT '1',
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT '',
  `rotate` int(11) DEFAULT '0',
  `pic` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `qty` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='奖项';

-- ----------------------------
-- Records of 1776_award
-- ----------------------------
INSERT INTO `1776_award` VALUES ('1', '一等奖', '0', 'LV正品包包', '1', 'upload/20201110150150.png', '1');
INSERT INTO `1776_award` VALUES ('2', '二等奖', '0', 'iphone11', '2', 'upload/20201110150218.png', '29');
INSERT INTO `1776_award` VALUES ('3', '三等奖', '0', 'AJ运动鞋', '3', 'upload/20201110150232.png', '40');
INSERT INTO `1776_award` VALUES ('4', '四等奖', '1', '云南6天5晚双人游', '4', 'upload/20201110150259.gif', '0');
INSERT INTO `1776_award` VALUES ('5', '五等奖', '1', 'ipad', '5', 'upload/20201110150317.png', '91');
INSERT INTO `1776_award` VALUES ('6', '六等奖', '1', '瑞士钟表', '6', 'upload/20201110150334.png', '0');
INSERT INTO `1776_award` VALUES ('7', '七等奖', '1', '停车场道闸破解器', '7', 'upload/20201110150357.gif', '0');
INSERT INTO `1776_award` VALUES ('8', '八等奖', '96', '祛痘组合', '8', 'upload/20201110150411.jpg', '800');

-- ----------------------------
-- Table structure for `1776_cjm`
-- ----------------------------
DROP TABLE IF EXISTS `1776_cjm`;
CREATE TABLE `1776_cjm` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `no` varchar(100) CHARACTER SET utf8 DEFAULT '',
  `state` int(11) DEFAULT '0',
  `addtime` datetime DEFAULT NULL,
  `award_id` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='抽奖码';

-- ----------------------------
-- Records of 1776_cjm
-- ----------------------------
INSERT INTO `1776_cjm` VALUES ('1', '3S0KT6K41J', '0', '2020-09-06 14:22:42', '4');
INSERT INTO `1776_cjm` VALUES ('2', 'DJNO5HMS2Z', '0', '2020-09-06 14:22:42', '4');
INSERT INTO `1776_cjm` VALUES ('3', 'U32CRTSQBJ', '0', '2020-09-06 14:22:42', '4');
INSERT INTO `1776_cjm` VALUES ('4', 'W48U4VURJZ', '0', '2020-09-06 14:22:42', '4');
INSERT INTO `1776_cjm` VALUES ('5', 'JQ5TSF0TC2', '0', '2020-09-06 14:22:42', '4');
INSERT INTO `1776_cjm` VALUES ('6', '2PQYRUWUC5', '0', '2020-09-06 14:22:42', '4');
INSERT INTO `1776_cjm` VALUES ('7', 'RVZE2KA6S0', '0', '2020-09-06 14:22:42', '0');
INSERT INTO `1776_cjm` VALUES ('8', '0J5ZQQY4MJ', '0', '2020-09-06 14:22:42', '0');
INSERT INTO `1776_cjm` VALUES ('9', '5SFRUWWRZQ', '0', '2020-09-06 14:22:42', '0');
INSERT INTO `1776_cjm` VALUES ('10', '7JZQ3H8HO7', '0', '2020-09-06 14:22:42', '0');

-- ----------------------------
-- Table structure for `1776_lottory`
-- ----------------------------
DROP TABLE IF EXISTS `1776_lottory`;
CREATE TABLE `1776_lottory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf8 DEFAULT '',
  `tel` varchar(11) COLLATE utf8_unicode_ci DEFAULT '',
  `award_id` int(11) DEFAULT '0',
  `award_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT '',
  `adddate` date DEFAULT NULL,
  `addtime` datetime DEFAULT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `award_prize` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `state` int(11) DEFAULT '0',
  `province` varchar(255) COLLATE utf8_unicode_ci DEFAULT '',
  `city` varchar(255) COLLATE utf8_unicode_ci DEFAULT '',
  `area` varchar(255) COLLATE utf8_unicode_ci DEFAULT '',
  `ip` varchar(255) COLLATE utf8_unicode_ci DEFAULT '',
  `cjm` varchar(255) COLLATE utf8_unicode_ci DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='抽奖记录';

-- ----------------------------
-- Records of 1776_lottory
-- ----------------------------
