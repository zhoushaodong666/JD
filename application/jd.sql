/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50714
Source Host           : localhost:3306
Source Database       : jd

Target Server Type    : MYSQL
Target Server Version : 50714
File Encoding         : 65001

Date: 2018-06-24 16:59:13
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for jd_cate
-- ----------------------------
DROP TABLE IF EXISTS `jd_cate`;
CREATE TABLE `jd_cate` (
  `cate_id` int(10) NOT NULL AUTO_INCREMENT,
  `cate_name` varchar(50) NOT NULL,
  `cate_pid` int(10) NOT NULL,
  `cate_sort` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`cate_id`)
) ENGINE=MyISAM AUTO_INCREMENT=39 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of jd_cate
-- ----------------------------
INSERT INTO `jd_cate` VALUES ('1', '家用电器', '0', '0');
INSERT INTO `jd_cate` VALUES ('2', '电视', '1', '0');
INSERT INTO `jd_cate` VALUES ('3', '冰箱', '1', '6');
INSERT INTO `jd_cate` VALUES ('4', '洗衣机', '1', '7');
INSERT INTO `jd_cate` VALUES ('38', '手机1', '37', '0');
INSERT INTO `jd_cate` VALUES ('36', '手机', '0', '0');
INSERT INTO `jd_cate` VALUES ('7', '组装机', '8', '0');
INSERT INTO `jd_cate` VALUES ('8', '电脑', '0', '0');
INSERT INTO `jd_cate` VALUES ('9', '合资品牌', '2', '2');
INSERT INTO `jd_cate` VALUES ('11', '笔记本电脑', '8', '0');
INSERT INTO `jd_cate` VALUES ('12', '国产品牌', '2', '3');
INSERT INTO `jd_cate` VALUES ('13', '互联网品牌', '2', '0');
INSERT INTO `jd_cate` VALUES ('14', '多门', '3', '0');
INSERT INTO `jd_cate` VALUES ('15', '对门', '3', '0');
INSERT INTO `jd_cate` VALUES ('16', '三门', '3', '0');
INSERT INTO `jd_cate` VALUES ('37', '手机通讯', '36', '0');
INSERT INTO `jd_cate` VALUES ('23', '点心/蛋糕', '0', '0');
INSERT INTO `jd_cate` VALUES ('25', '绿豆饼', '24', '0');
INSERT INTO `jd_cate` VALUES ('24', '点心', '23', '0');
INSERT INTO `jd_cate` VALUES ('26', '糯米糍', '24', '0');
INSERT INTO `jd_cate` VALUES ('27', '蛋糕', '23', '0');
INSERT INTO `jd_cate` VALUES ('28', '蒸蛋糕', '27', '0');
INSERT INTO `jd_cate` VALUES ('29', '滚筒式', '4', '0');
INSERT INTO `jd_cate` VALUES ('30', '名人堂', '7', '0');
INSERT INTO `jd_cate` VALUES ('31', '华硕', '11', '0');
INSERT INTO `jd_cate` VALUES ('32', '食品', '0', '0');
INSERT INTO `jd_cate` VALUES ('33', '休闲食品', '32', '0');
INSERT INTO `jd_cate` VALUES ('35', '坚果炒货', '33', '0');

-- ----------------------------
-- Table structure for jd_goodproperty
-- ----------------------------
DROP TABLE IF EXISTS `jd_goodproperty`;
CREATE TABLE `jd_goodproperty` (
  `goodsproperty_id` int(10) NOT NULL AUTO_INCREMENT,
  `goodsproperty_name` varchar(50) NOT NULL,
  `goodsproperty_content` varchar(50) NOT NULL,
  `goods_id` int(10) NOT NULL COMMENT '所属商品id',
  PRIMARY KEY (`goodsproperty_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of jd_goodproperty
-- ----------------------------

-- ----------------------------
-- Table structure for jd_goods
-- ----------------------------
DROP TABLE IF EXISTS `jd_goods`;
CREATE TABLE `jd_goods` (
  `goods_id` int(11) NOT NULL AUTO_INCREMENT,
  `goods_name` varchar(200) NOT NULL,
  `goods_thumb` varchar(200) NOT NULL,
  `goods_price` decimal(20,2) NOT NULL,
  `goods_after_price` decimal(20,2) NOT NULL,
  `goods_status` tinyint(2) NOT NULL DEFAULT '1',
  `goods_sales` int(10) NOT NULL DEFAULT '0',
  `goods_inventory` int(10) NOT NULL DEFAULT '0',
  `goods_pid` int(10) NOT NULL,
  PRIMARY KEY (`goods_id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of jd_goods
-- ----------------------------
INSERT INTO `jd_goods` VALUES ('3', 'Apple 苹果 iphone x', '\\jd\\public\\uploads\\20180619\\fbf192a695853c009888db31650e9cb9.jpg', '7499.00', '5999.00', '0', '1645', '7895', '38');
INSERT INTO `jd_goods` VALUES ('4', '三星（SAMSUNG）UA65KUC30SJXXZ 65寸', '\\jd\\public\\uploads\\20180619\\41fb93919e1f7e71ec5087e3ea13ea26.jpg', '5638.00', '0.00', '1', '39000', '56123', '13');
INSERT INTO `jd_goods` VALUES ('5', '努比亚 nubia Z18mini', '\\jd\\public\\uploads\\20180603\\23654df5bd37702675f0c600cbea9c23.jpg', '2099.00', '1888.00', '1', '9332', '3213', '38');
INSERT INTO `jd_goods` VALUES ('6', '黑鲨游戏手机  极夜黑 ', '\\jd\\public\\uploads\\20180603\\5f334e8c380110594b503aaf7fa71754.jpg', '2999.00', '0.00', '1', '36789', '5457', '38');
INSERT INTO `jd_goods` VALUES ('8', '一加手机6  亮瓷黑 全面屏双摄游戏手机', '\\jd\\public\\uploads\\20180603\\493a75543322c9f73bc17529ba5f60c5.jpg', '3599.00', '0.00', '1', '93000', '568522', '38');
INSERT INTO `jd_goods` VALUES ('12', '苹果8', '\\jd\\public\\uploads\\20180617\\5bba6e1b683f896fc683230b86bae548.jpg', '6888.00', '6333.00', '1', '849', '659', '38');
INSERT INTO `jd_goods` VALUES ('11', '苹果7', '\\jd\\public\\uploads\\20180617\\e97b81550a5d5153976086362b506d1b.jpg', '6888.00', '5999.00', '1', '522', '65', '38');
INSERT INTO `jd_goods` VALUES ('13', '111', '\\jd\\public\\uploads\\20180620\\a1790373bfdc2e43214445d9ba8bf301.jpg', '123.00', '120.00', '1', '12354', '45645', '35');
INSERT INTO `jd_goods` VALUES ('14', '1122', '\\jd\\public\\uploads\\20180622\\6525179fbe1df24db4b4451ae27d8d0d.jpg', '1235.00', '123.00', '1', '138465', '456', '38');

-- ----------------------------
-- Table structure for jd_goods_keywords
-- ----------------------------
DROP TABLE IF EXISTS `jd_goods_keywords`;
CREATE TABLE `jd_goods_keywords` (
  `goods_id` int(11) NOT NULL,
  `keywords_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of jd_goods_keywords
-- ----------------------------
INSERT INTO `jd_goods_keywords` VALUES ('5', '13');
INSERT INTO `jd_goods_keywords` VALUES ('3', '4');
INSERT INTO `jd_goods_keywords` VALUES ('5', '15');
INSERT INTO `jd_goods_keywords` VALUES ('5', '14');

-- ----------------------------
-- Table structure for jd_img
-- ----------------------------
DROP TABLE IF EXISTS `jd_img`;
CREATE TABLE `jd_img` (
  `img_id` int(10) NOT NULL AUTO_INCREMENT,
  `url` varchar(100) NOT NULL,
  `goods_id` int(10) NOT NULL,
  PRIMARY KEY (`img_id`)
) ENGINE=MyISAM AUTO_INCREMENT=42 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of jd_img
-- ----------------------------
INSERT INTO `jd_img` VALUES ('11', '\\jd\\public\\uploads\\img\\20180619\\f04b488c11005575f221b4800237f7db.jpg', '12');
INSERT INTO `jd_img` VALUES ('10', '\\jd\\public\\uploads\\img\\20180619\\92f01728694ffdbdb7e05191c02f2b7c.jpg', '12');
INSERT INTO `jd_img` VALUES ('9', '\\jd\\public\\uploads\\img\\20180619\\b4a6729fcf4b9df5c5c123532fc7b40c.jpg', '12');
INSERT INTO `jd_img` VALUES ('12', '\\jd\\public\\uploads\\img\\20180619\\f04b488c11005575f221b4800237f7db.jpg', '12');
INSERT INTO `jd_img` VALUES ('13', '\\jd\\public\\uploads\\img\\20180619\\92f01728694ffdbdb7e05191c02f2b7c.jpg', '12');
INSERT INTO `jd_img` VALUES ('14', '\\jd\\public\\uploads\\img\\20180619\\b4a6729fcf4b9df5c5c123532fc7b40c.jpg', '12');
INSERT INTO `jd_img` VALUES ('15', '\\jd\\public\\uploads\\img\\20180619\\6ffb32d2accf7e1aa195077e448bf057.png', '4');
INSERT INTO `jd_img` VALUES ('16', '\\jd\\public\\uploads\\img\\20180619\\6ffb32d2accf7e1aa195077e448bf057.png', '4');
INSERT INTO `jd_img` VALUES ('17', '\\jd\\public\\uploads\\img\\20180619\\6ffb32d2accf7e1aa195077e448bf057.png', '4');
INSERT INTO `jd_img` VALUES ('18', '\\jd\\public\\uploads\\img\\20180619\\6ffb32d2accf7e1aa195077e448bf057.png', '4');
INSERT INTO `jd_img` VALUES ('19', '\\jd\\public\\uploads\\img\\20180619\\6ffb32d2accf7e1aa195077e448bf057.png', '4');
INSERT INTO `jd_img` VALUES ('20', '\\jd\\public\\uploads\\img\\20180619\\6ffb32d2accf7e1aa195077e448bf057.png', '4');
INSERT INTO `jd_img` VALUES ('21', '\\jd\\public\\uploads\\img\\20180619\\6ffb32d2accf7e1aa195077e448bf057.png', '4');
INSERT INTO `jd_img` VALUES ('22', '\\jd\\public\\uploads\\img\\20180619\\6ffb32d2accf7e1aa195077e448bf057.png', '4');
INSERT INTO `jd_img` VALUES ('23', '\\jd\\public\\uploads\\img\\20180619\\355eece2bfbc84aa38de3a5c6a28c574.jpg', '3');
INSERT INTO `jd_img` VALUES ('36', '\\jd\\public\\uploads\\img\\20180622\\6d74f7f783b01419d73b5dfb47117e04.jpg', '13');
INSERT INTO `jd_img` VALUES ('33', '\\jd\\public\\uploads\\img\\20180622\\32722a4c5c9e6a7633fe3555cbef941e.jpg', '13');
INSERT INTO `jd_img` VALUES ('32', '\\jd\\public\\uploads\\img\\20180622\\293f84f914c9e24cd05dc4263149a3ec.jpg', '13');
INSERT INTO `jd_img` VALUES ('31', '\\jd\\public\\uploads\\img\\20180622\\08dec7b0d75f14aae5904a16e921eaf3.jpg', '13');
INSERT INTO `jd_img` VALUES ('37', '\\jd\\public\\uploads\\img\\20180622\\4fb34b5bdaa0beb1967ff10cc2def459.jpg', '14');
INSERT INTO `jd_img` VALUES ('38', '\\jd\\public\\uploads\\img\\20180622\\615a1caaa9a6da586cdfce6eefba8f3d.jpg', '14');
INSERT INTO `jd_img` VALUES ('39', '\\jd\\public\\uploads\\img\\20180622\\b6f39f055d6002f0b94dd2f37edc0628.jpg', '14');
INSERT INTO `jd_img` VALUES ('40', '\\jd\\public\\uploads\\img\\20180622\\ee9f82cd17f74349558a5b4345063284.jpg', '14');
INSERT INTO `jd_img` VALUES ('41', '\\jd\\public\\uploads\\img\\20180622\\8fc689a2bfa8e558a39cdd6fead30dab.jpg', '14');

-- ----------------------------
-- Table structure for jd_keywords
-- ----------------------------
DROP TABLE IF EXISTS `jd_keywords`;
CREATE TABLE `jd_keywords` (
  `keywords_id` int(10) NOT NULL AUTO_INCREMENT,
  `keywords_name` varchar(200) NOT NULL,
  PRIMARY KEY (`keywords_id`),
  UNIQUE KEY `keywords_name` (`keywords_name`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of jd_keywords
-- ----------------------------
INSERT INTO `jd_keywords` VALUES ('1', '华为');
INSERT INTO `jd_keywords` VALUES ('2', 'HuaWei');
INSERT INTO `jd_keywords` VALUES ('3', '荣耀');
INSERT INTO `jd_keywords` VALUES ('4', '64G');
INSERT INTO `jd_keywords` VALUES ('5', '32G');
INSERT INTO `jd_keywords` VALUES ('6', '128G');
INSERT INTO `jd_keywords` VALUES ('7', '4G');
INSERT INTO `jd_keywords` VALUES ('8', '1G');
INSERT INTO `jd_keywords` VALUES ('10', '2G');
INSERT INTO `jd_keywords` VALUES ('11', '星空灰');
INSERT INTO `jd_keywords` VALUES ('12', '苹果');
INSERT INTO `jd_keywords` VALUES ('13', '全面屏手机');
INSERT INTO `jd_keywords` VALUES ('14', '努比亚 ');
INSERT INTO `jd_keywords` VALUES ('15', '手机');

-- ----------------------------
-- Table structure for jd_property
-- ----------------------------
DROP TABLE IF EXISTS `jd_property`;
CREATE TABLE `jd_property` (
  `property_id` int(10) NOT NULL AUTO_INCREMENT,
  `property_name` varchar(30) NOT NULL,
  `property_pid` int(10) DEFAULT NULL,
  PRIMARY KEY (`property_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of jd_property
-- ----------------------------
INSERT INTO `jd_property` VALUES ('2', '电脑内存', '31');
INSERT INTO `jd_property` VALUES ('3', '商品名称', '35');
INSERT INTO `jd_property` VALUES ('4', '商品毛重', '38');
INSERT INTO `jd_property` VALUES ('5', '商品质保期', '38');
