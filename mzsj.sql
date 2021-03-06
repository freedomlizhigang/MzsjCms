/*
SQLyog Ultimate v12.09 (64 bit)
MySQL - 5.1.69 : Database - xs118267
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
/*Table structure for table `mzsj_admin` */

DROP TABLE IF EXISTS `mzsj_admin`;

CREATE TABLE `mzsj_admin` (
  `adminid` mediumint(6) unsigned NOT NULL AUTO_INCREMENT,
  `roleid` tinyint(3) unsigned DEFAULT NULL,
  `adminname` varchar(20) DEFAULT NULL,
  `password` varchar(32) DEFAULT NULL,
  `encrypt` varchar(10) DEFAULT NULL COMMENT '加密因子',
  `realname` varchar(20) DEFAULT NULL,
  `email` varchar(30) DEFAULT NULL,
  `tel` varchar(20) DEFAULT NULL,
  `lastip` char(15) DEFAULT NULL,
  `lasttime` int(10) unsigned DEFAULT NULL,
  `status` tinyint(1) unsigned DEFAULT '1' COMMENT '状态',
  PRIMARY KEY (`adminid`),
  KEY `adminname` (`adminname`),
  KEY `adminid` (`adminid`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

/*Data for the table `mzsj_admin` */

insert  into `mzsj_admin`(`adminid`,`roleid`,`adminname`,`password`,`encrypt`,`realname`,`email`,`tel`,`lastip`,`lasttime`,`status`) values (1,1,'mzadmin','1a4dccbb454db37a39dedb0d71ed98e9','ynTJUj','李','dasf@qq.com','123222122','116.255.245.42',1452664818,1),(4,2,'adminss','7e3c0d5f20c1c5024b0c6b494c398e7d',NULL,'adminss','fsad@qq.com','13221321234','192.168.10.42',1452310427,1);

/*Table structure for table `mzsj_admin_priv` */

DROP TABLE IF EXISTS `mzsj_admin_priv`;

CREATE TABLE `mzsj_admin_priv` (
  `roleid` tinyint(3) unsigned NOT NULL,
  `url` char(100) NOT NULL,
  KEY `roleid` (`roleid`,`url`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `mzsj_admin_priv` */

insert  into `mzsj_admin_priv`(`roleid`,`url`) values (2,'Mzsj/Admin/addadmin'),(2,'Mzsj/Admin/deladmin'),(2,'Mzsj/Admin/editadmin'),(2,'Mzsj/Admin/index'),(2,'Mzsj/Admin/manage'),(2,'Mzsj/Index/editsite'),(2,'Mzsj/Index/index'),(2,'Mzsj/Index/sitelist'),(3,'Mzsj/Admin/addadmin'),(3,'Mzsj/Admin/addrole'),(3,'Mzsj/Admin/index'),(3,'Mzsj/Admin/manage'),(3,'Mzsj/Admin/rolelist'),(3,'Mzsj/Index/index');

/*Table structure for table `mzsj_article` */

DROP TABLE IF EXISTS `mzsj_article`;

CREATE TABLE `mzsj_article` (
  `artid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `catid` smallint(5) unsigned NOT NULL COMMENT '栏目ID',
  `title` varchar(150) DEFAULT NULL,
  `thumb` varchar(100) DEFAULT NULL,
  `keyword` varchar(50) DEFAULT NULL,
  `description` varchar(300) DEFAULT NULL,
  `content` mediumtext,
  `listorder` int(10) DEFAULT NULL,
  `islink` tinyint(1) unsigned DEFAULT '0' COMMENT '是否外链',
  `url` varchar(100) DEFAULT NULL,
  `posid` varchar(20) NOT NULL DEFAULT '0' COMMENT '是否推荐',
  `inputtime` int(10) unsigned DEFAULT NULL,
  `updatetime` int(10) unsigned DEFAULT NULL,
  `status` tinyint(1) unsigned DEFAULT '0' COMMENT '状态',
  PRIMARY KEY (`artid`),
  KEY `artid` (`artid`),
  KEY `catid` (`catid`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

/*Data for the table `mzsj_article` */

insert  into `mzsj_article`(`artid`,`catid`,`title`,`thumb`,`keyword`,`description`,`content`,`listorder`,`islink`,`url`,`posid`,`inputtime`,`updatetime`,`status`) values (1,2,'fdsadddddsss','','木子设计,网站建设,系统开发','','fadsadfdsa',0,0,'','2',NULL,1425002560,1),(2,2,'fdsa','/mzsj/Upload/2015-02-26/54ee83dd88065.jpg','','ddddd','faddddddddddss&lt;img src=&quot;/mzsj/Upload/2015-02-26/54ee840ddbb2c.jpg&quot; alt=&quot;&quot; /&gt;',0,0,'','1',1424917402,1424917523,1),(3,2,'323432432','','','','fdsafdsa',0,0,'','0',NULL,NULL,1),(4,2,'fdsadddd','','','das','fdasd',0,0,'','0',NULL,NULL,0),(5,2,'2222222222222222','','','','dddd',0,0,'','0',NULL,NULL,1);

/*Table structure for table `mzsj_attr` */

DROP TABLE IF EXISTS `mzsj_attr`;

CREATE TABLE `mzsj_attr` (
  `attid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` char(10) DEFAULT NULL COMMENT '素材类型',
  `localurl` varchar(150) NOT NULL COMMENT '本地url',
  `media_id` varchar(100) DEFAULT NULL COMMENT '微信的ID',
  `url` varchar(200) DEFAULT NULL COMMENT '下载下来后的url',
  `inputtime` int(10) unsigned NOT NULL COMMENT '上传时间',
  `islocal` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否是微信永久素材：0否',
  PRIMARY KEY (`attid`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

/*Data for the table `mzsj_attr` */

insert  into `mzsj_attr`(`attid`,`type`,`localurl`,`media_id`,`url`,`inputtime`,`islocal`) values (1,'image','/Upload/wx/2016-01-10/5691fdf311c7c.jpg','zy_YJtr2WaMMEooLyd1DNJ0LGRi244fuSAb7ZeiwinQ','https://mmbiz.qlogo.cn/mmbiz/x9rmG7ic6DTPEsAFwWD7QyOqS1Oa5OV6w8Mjru4DfCfd8TVFZgN8JoajibeGjg574VGMOAyJxGd5kAODtLVDEmDg/0?wx_fmt=jpeg',1452408365,1),(3,'video','/Upload/wx/2016-01-10/569215f5312df.mp4','zy_YJtr2WaMMEooLyd1DNLPKer1l9SVr7Kz1zjS2d8g',NULL,1452414464,1),(4,'video','/Upload/wx/2016-01-10/569215f5312df.mp4','zy_YJtr2WaMMEooLyd1DNPWWAzol376MGhmsEaAHJyw',NULL,1452415180,1),(7,'image','/Upload/2016-01-11/5693540a18496.png',NULL,NULL,1452495882,0),(6,'image','/Upload/2016-01-11/569353225cb5c.png',NULL,NULL,1452495650,0),(8,'image','/Upload/2016-01-11/5693540a805bd.png',NULL,NULL,1452495882,0);

/*Table structure for table `mzsj_category` */

DROP TABLE IF EXISTS `mzsj_category`;

CREATE TABLE `mzsj_category` (
  `catid` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `parentid` smallint(5) unsigned DEFAULT NULL COMMENT '父ID',
  `arrparentid` varchar(255) DEFAULT NULL COMMENT '所有父ID',
  `child` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否存在子分类：1存在',
  `arrchildid` varchar(255) DEFAULT NULL COMMENT '所有子分类',
  `catname` varchar(30) DEFAULT NULL,
  `catdir` varchar(20) DEFAULT NULL,
  `image` varchar(100) DEFAULT NULL,
  `keyword` varchar(100) DEFAULT NULL,
  `description` varchar(300) DEFAULT NULL,
  `content` mediumtext,
  `listorder` smallint(5) unsigned DEFAULT NULL,
  `ismenu` tinyint(1) unsigned DEFAULT '1',
  `islink` tinyint(1) unsigned DEFAULT '0',
  `url` varchar(100) DEFAULT NULL,
  `ispage` tinyint(1) unsigned DEFAULT '0' COMMENT '是否是单网页',
  `cattpl` char(20) DEFAULT NULL COMMENT '栏目模板',
  `arttpl` char(20) DEFAULT NULL COMMENT '文章模板',
  `shenhe` tinyint(1) unsigned DEFAULT '0' COMMENT '是否要审核，0为不审核，直接发表',
  PRIMARY KEY (`catid`),
  KEY `catid` (`catid`),
  KEY `catname` (`catname`),
  KEY `parentid` (`parentid`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

/*Data for the table `mzsj_category` */

insert  into `mzsj_category`(`catid`,`parentid`,`arrparentid`,`child`,`arrchildid`,`catname`,`catdir`,`image`,`keyword`,`description`,`content`,`listorder`,`ismenu`,`islink`,`url`,`ispage`,`cattpl`,`arttpl`,`shenhe`) values (1,0,'0',0,'1','关于我们','about','','','','这就是个测试的栏目',0,1,0,'',0,'cate','show',0),(2,6,'0,6',0,'2','加个二级试试','subnav','','','','f二级一个',0,1,0,'',0,'cate','show',0),(3,0,'0',0,'3','联系我们','contact','/Upload/2016-01-11/569353225cb5c.png','','f','<p>\r\n	<img src=\"/Upload/2016-01-11/5693540a18496.png\" alt=\"\" />\r\n</p>\r\n<p>\r\n	<br />\r\n</p>\r\n<p>\r\n	<img src=\"/Upload/2016-01-11/5693540a805bd.png\" alt=\"\" />\r\n</p>\r\n<h2>\r\n	fda fdsass<span style=\"color:#4C33E5;\"></span> \r\n</h2>\r\n<h2>\r\n	<span style=\"color:#4C33E5;\">dsaffdassss</span> \r\n</h2>',3,1,0,'',1,'page','show',1),(6,0,'0',1,'6,2','主营业务','case','','业务','业务们','压根',0,1,0,'',0,'cate','show',0);

/*Table structure for table `mzsj_group` */

DROP TABLE IF EXISTS `mzsj_group`;

CREATE TABLE `mzsj_group` (
  `groupid` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '组ID',
  `groupname` varchar(20) DEFAULT NULL COMMENT '组名',
  `status` tinyint(1) unsigned DEFAULT '1' COMMENT '状态',
  `listorder` smallint(5) unsigned DEFAULT NULL COMMENT '排序',
  PRIMARY KEY (`groupid`),
  KEY `groupid` (`groupid`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `mzsj_group` */

insert  into `mzsj_group`(`groupid`,`groupname`,`status`,`listorder`) values (1,'新注册用户',1,0),(2,'中级用户',1,0);

/*Table structure for table `mzsj_link` */

DROP TABLE IF EXISTS `mzsj_link`;

CREATE TABLE `mzsj_link` (
  `linkid` mediumint(5) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) DEFAULT NULL,
  `url` varchar(100) DEFAULT NULL,
  `image` varchar(100) DEFAULT NULL,
  `listorder` mediumint(5) unsigned DEFAULT NULL,
  PRIMARY KEY (`linkid`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `mzsj_link` */

insert  into `mzsj_link`(`linkid`,`name`,`url`,`image`,`listorder`) values (1,'百度一下','http://www.baidu.com','/mzsj/Upload/2015-02-26/54eec6bdf3f12.jpg',3),(2,'谷歌啊','http://www.google.com.hk','',0);

/*Table structure for table `mzsj_linkage` */

DROP TABLE IF EXISTS `mzsj_linkage`;

CREATE TABLE `mzsj_linkage` (
  `linkageid` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(30) DEFAULT NULL,
  `parentid` smallint(5) unsigned DEFAULT NULL,
  `listorder` smallint(5) unsigned DEFAULT NULL,
  PRIMARY KEY (`linkageid`),
  KEY `linkageid` (`linkageid`),
  KEY `parentid` (`parentid`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

/*Data for the table `mzsj_linkage` */

insert  into `mzsj_linkage`(`linkageid`,`name`,`parentid`,`listorder`) values (1,'地区',0,0);

/*Table structure for table `mzsj_log` */

DROP TABLE IF EXISTS `mzsj_log`;

CREATE TABLE `mzsj_log` (
  `logid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `url` varchar(50) DEFAULT NULL,
  `data` varchar(20) DEFAULT NULL,
  `adminid` mediumint(6) unsigned DEFAULT NULL,
  `adminname` varchar(20) DEFAULT NULL,
  `ip` char(15) DEFAULT NULL,
  `time` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`logid`)
) ENGINE=MyISAM AUTO_INCREMENT=301 DEFAULT CHARSET=utf8;

/*Data for the table `mzsj_log` */

insert  into `mzsj_log`(`logid`,`url`,`data`,`adminid`,`adminname`,`ip`,`time`) values (244,'/Mzsj/Menu/editmenu/','menuid=1',1,'mzadmin','192.168.10.42',1452322999),(243,'/Mzsj/Menu/editmenu/','menuid=1',1,'mzadmin','192.168.10.42',1452322979),(242,'/Mzsj/Menu/editmenu/','menuid=1',1,'mzadmin','192.168.10.42',1452322942),(241,'/Mzsj/Menu/editmenu/','menuid=1',1,'mzadmin','192.168.10.42',1452322676),(208,'/Mzsj/Public/login/','',1,'mzadmin','192.168.10.42',1452300204),(209,'/Mzsj/Adminedit/editpassword/','adminid=1',1,'mzadmin','192.168.10.42',1452302193),(210,'/Mzsj/Adminedit/editadmin/','adminid=1',1,'mzadmin','192.168.10.42',1452302461),(211,'/Mzsj/Adminedit/editadmin/','adminid=1',1,'mzadmin','192.168.10.42',1452302474),(212,'/Mzsj/Admin/editpassword/','adminid=1',1,'mzadmin','192.168.10.42',1452303193),(213,'/Mzsj/Admin/editpassword/','adminid=1',1,'mzadmin','192.168.10.42',1452303334),(214,'/Mzsj/Admin/editpassword/','adminid=1',1,'mzadmin','192.168.10.42',1452303459),(215,'/Mzsj/Admin/editpassword/','adminid=1',1,'mzadmin','192.168.10.42',1452303626),(216,'/Mzsj/Admin/editpassword/','adminid=1',1,'mzadmin','192.168.10.42',1452303638),(217,'/Mzsj/Public/login/','',1,'mzadmin','192.168.10.42',1452303869),(218,'/Mzsj/Public/login/','',1,'mzadmin','192.168.10.42',1452306317),(219,'/Mzsj/Menu/editmenu/','menuid=1',1,'mzadmin','192.168.10.42',1452308733),(220,'/Mzsj/Admin/addadmin/','adminid=4',1,'mzadmin','192.168.10.42',1452310399),(221,'/Mzsj/Public/login/','',4,'adminss','192.168.10.42',1452310427),(222,'/Mzsj/Admin/adminpriv/','roleid=2',1,'mzadmin','192.168.10.42',1452310454),(223,'/Mzsj/Public/login/','',1,'mzadmin','192.168.10.42',1452311522),(224,'/Mzsj/Public/login/','',1,'mzadmin','192.168.10.42',1452311858),(225,'/Mzsj/Public/login/','',1,'mzadmin','192.168.10.42',1452311907),(226,'/Mzsj/Public/login/','',1,'mzadmin','192.168.10.42',1452311994),(227,'/Mzsj/Public/login/','',1,'mzadmin','192.168.10.42',1452318719),(228,'/Mzsj/Public/login/','',1,'mzadmin','192.168.10.42',1452318782),(229,'/Mzsj/Public/login/','',1,'mzadmin','192.168.10.42',1452318900),(230,'/Mzsj/Public/login/','',1,'mzadmin','192.168.10.42',1452318963),(231,'/Mzsj/Public/login/','',1,'mzadmin','192.168.10.42',1452319297),(232,'/Mzsj/Public/login/','',1,'mzadmin','192.168.10.42',1452319435),(233,'/Mzsj/Public/login/','',1,'mzadmin','192.168.10.42',1452319948),(234,'/Mzsj/Public/login/','',1,'mzadmin','192.168.10.42',1452320368),(235,'/Mzsj/Public/login/','',1,'mzadmin','192.168.10.42',1452320442),(236,'/Mzsj/Public/login/','',1,'mzadmin','192.168.10.42',1452320475),(237,'/Mzsj/Public/login/','',1,'mzadmin','192.168.10.42',1452320508),(238,'/Mzsj/Public/login/','',1,'mzadmin','192.168.10.42',1452320528),(239,'/Mzsj/Public/login/','',1,'mzadmin','192.168.10.42',1452320794),(240,'/Mzsj/Public/login/','',1,'mzadmin','192.168.10.42',1452321451),(245,'/Mzsj/Public/login/','',1,'mzadmin','116.255.233.170',1452385800),(246,'/Mzsj/Wx/wxconfig/','',1,'mzadmin','116.255.233.172',1452386017),(247,'/Mzsj/Wx/editmsg/','msgid=1',1,'mzadmin','116.255.233.170',1452386628),(248,'/Mzsj/Wx/editmenu/','menuid=1',1,'mzadmin','116.255.233.170',1452386866),(249,'/Mzsj/Wx/editmenu/','menuid=1',1,'mzadmin','116.255.233.172',1452388950),(250,'/Mzsj/Menu/addmenu/','menuid=142',1,'mzadmin','116.255.233.172',1452389304),(251,'/Mzsj/Menu/addmenu/','menuid=143',1,'mzadmin','116.255.233.170',1452389650),(252,'/Mzsj/Menu/addmenu/','menuid=144',1,'mzadmin','116.255.233.170',1452389680),(253,'/Mzsj/Index/editsite/','',1,'mzadmin','116.255.233.172',1452392783),(254,'/Mzsj/Index/editsite/','',1,'mzadmin','116.255.233.172',1452392850),(255,'/Mzsj/Public/login/','',1,'mzadmin','116.255.233.170',1452393000),(256,'/Mzsj/Public/login/','',1,'mzadmin','116.255.233.170',1452405831),(257,'/Mzsj/Public/login/','',1,'mzadmin','116.255.233.170',1452413529),(258,'/Mzsj/Wx/addmsg/','msgid=9',1,'mzadmin','116.255.233.170',1452415777),(259,'/Mzsj/Wx/addmenu/','menuid=8',1,'mzadmin','116.255.233.172',1452417639),(260,'/Mzsj/Wx/editmsg/','msgid=1',1,'mzadmin','116.255.233.172',1452417988),(261,'/Mzsj/Wx/editmsg/','msgid=1',1,'mzadmin','116.255.233.172',1452418051),(262,'/Mzsj/Public/login/','',1,'mzadmin','116.255.233.172',1452472070),(263,'/Mzsj/Wx/addmenu/','menuid=9',1,'mzadmin','116.255.233.172',1452472957),(264,'/Mzsj/Wx/addmenu/','menuid=10',1,'mzadmin','116.255.233.172',1452473134),(265,'/Mzsj/Wx/editlinkage/','wxlinkageid=1',1,'mzadmin','116.255.233.172',1452474819),(266,'/Mzsj/Wx/editlinkage/','wxlinkageid=1',1,'mzadmin','116.255.233.172',1452474940),(267,'/Mzsj/Wx/editlinkage/','wxlinkageid=1',1,'mzadmin','116.255.233.172',1452474955),(268,'/Mzsj/Wx/editlinkage/','wxlinkageid=1',1,'mzadmin','116.255.233.172',1452474960),(269,'/Mzsj/Wx/editlinkage/','wxlinkageid=1',1,'mzadmin','116.255.233.172',1452474970),(270,'/Mzsj/Wx/editlinkage/','wxlinkageid=1',1,'mzadmin','116.255.233.172',1452474976),(271,'/Mzsj/Wx/editlinkage/','wxlinkageid=1',1,'mzadmin','116.255.233.172',1452475002),(272,'/Mzsj/Menu/editmenu/','menuid=1',1,'mzadmin','116.255.233.172',1452475842),(273,'/Mzsj/Wx/dellinkage/','wxlinkageid=7',1,'mzadmin','116.255.233.172',1452476158),(274,'/Mzsj/Wx/dellinkage/','wxlinkageid=6',1,'mzadmin','116.255.233.172',1452476165),(275,'/Mzsj/Public/login/','',1,'mzadmin','116.255.247.105',1452483185),(276,'/Mzsj/Public/login/','',1,'mzadmin','116.255.247.105',1452492064),(277,'/Mzsj/Menu/addmenu/','menuid=145',1,'mzadmin','116.255.247.105',1452495291),(278,'/Mzsj/Menu/addmenu/','menuid=146',1,'mzadmin','116.255.247.105',1452495315),(279,'/Mzsj/Content/editcate/','catid=1',1,'mzadmin','116.255.233.172',1452495652),(280,'/Mzsj/Content/editcate/','catid=1',1,'mzadmin','116.255.247.105',1452495903),(281,'/Mzsj/Public/login/','',1,'mzadmin','116.255.233.172',1452501958),(282,'/Mzsj/Menu/addmenu/','menuid=147',1,'mzadmin','116.255.233.172',1452502500),(283,'/Mzsj/Public/login/','',1,'mzadmin','116.255.233.175',1452644010),(284,'/Mzsj/Menu/addmenu/','menuid=148',1,'mzadmin','116.255.233.172',1452645582),(285,'/Mzsj/Menu/editmenu/','menuid=1',1,'mzadmin','116.255.233.172',1452645600),(286,'/Mzsj/Menu/editmenu/','menuid=1',1,'mzadmin','116.255.233.172',1452645609),(287,'/Mzsj/Menu/addmenu/','menuid=149',1,'mzadmin','116.255.233.172',1452645631),(288,'/Mzsj/Menu/addmenu/','menuid=150',1,'mzadmin','116.255.233.172',1452645665),(289,'/Mzsj/Menu/addmenu/','menuid=151',1,'mzadmin','116.255.233.172',1452645689),(290,'/Mzsj/Menu/addmenu/','menuid=152',1,'mzadmin','116.255.233.172',1452645705),(291,'/Mzsj/Menu/addmenu/','menuid=153',1,'mzadmin','116.255.247.105',1452648405),(292,'/Mzsj/Menu/editmenu/','menuid=1',1,'mzadmin','116.255.245.42',1452651152),(293,'/Mzsj/Public/login/','',1,'mzadmin','116.255.247.105',1452651430),(294,'/Mzsj/Menu/addmenu/','menuid=154',1,'mzadmin','116.255.247.105',1452651470),(295,'/Mzsj/Wxuser/updateuser/','',1,'mzadmin','116.255.233.172',1452657253),(296,'/Mzsj/Public/login/','',1,'mzadmin','116.255.245.42',1452664818),(297,'/Mzsj/Wxuser/remark/','userid=',1,'mzadmin','116.255.233.175',1452666318),(298,'/Mzsj/Wxgroup/editgroup/','id=102',1,'mzadmin','116.255.245.42',1452668822),(299,'/Mzsj/Menu/addmenu/','menuid=155',1,'mzadmin','116.255.233.172',1452669864),(300,'/Mzsj/Menu/addmenu/','menuid=156',1,'mzadmin','116.255.233.172',1452669890);

/*Table structure for table `mzsj_menu` */

DROP TABLE IF EXISTS `mzsj_menu`;

CREATE TABLE `mzsj_menu` (
  `menuid` mediumint(5) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) DEFAULT NULL,
  `parentid` mediumint(5) unsigned DEFAULT NULL,
  `url` char(100) DEFAULT NULL,
  `listorder` mediumint(5) unsigned DEFAULT NULL,
  `display` tinyint(1) unsigned DEFAULT '1',
  PRIMARY KEY (`menuid`),
  KEY `menuid` (`menuid`),
  KEY `parentid` (`parentid`),
  KEY `module` (`url`)
) ENGINE=MyISAM AUTO_INCREMENT=157 DEFAULT CHARSET=utf8;

/*Data for the table `mzsj_menu` */

insert  into `mzsj_menu`(`menuid`,`name`,`parentid`,`url`,`listorder`,`display`) values (52,'内容管理',51,'Mzsj/Content/mamange',0,1),(46,'用户管理',42,'Mzsj/Admin/manage',2,1),(45,'菜单管理',43,'Mzsj/Menu/index',0,1),(51,'内容',0,'Mzsj/Content/manage',0,1),(50,'删除',45,'Mzsj/Menu/delmenu',0,0),(49,'修改',45,'Mzsj/Menu/editmenu',0,0),(48,'新增',45,'Mzsj/Menu/addmenu',0,1),(47,'用户列表',46,'Mzsj/Admin/index',0,1),(44,'站点列表',43,'Mzsj/Index/sitelist',0,1),(43,'系统管理',42,'Mzsj/Index/index',1,1),(42,'系统',0,'Mzsj/Index/index',0,1),(53,'文章管理',52,'Mzsj/Content/index',0,1),(54,'栏目管理',52,'Mzsj/Content/cate',0,1),(55,'角色列表',46,'Mzsj/Admin/rolelist',0,1),(56,'添加角色',55,'Mzsj/Admin/addrole',0,1),(57,'修改角色',55,'Mzsj/Admin/editrole',0,0),(58,'删除角色',55,'Mzsj/Admin/delrole',0,0),(59,'新增用户',47,'Mzsj/Admin/addadmin',0,1),(60,'修改用户',47,'Mzsj/Admin/editadmin',0,0),(61,'删除用户',47,'Mzsj/Admin/deladmin',0,0),(62,'权限管理',55,'Mzsj/Admin/adminpriv',0,0),(63,'编辑',44,'Mzsj/Index/editsite',0,0),(64,'添加',54,'Mzsj/Content/addcate',0,1),(65,'修改',54,'Mzsj/Content/editcate',0,0),(66,'删除菜单',54,'Mzsj/Content/delcate',0,0),(67,'添加文章',53,'Mzsj/Content/addarticle',0,1),(68,'修改文章',53,'Mzsj/Content/editarticle',0,0),(69,'删除文章',53,'Mzsj/Content/delarticle',0,0),(70,'其它内容',51,'Mzsj/Content/other',0,1),(71,'友情链接',70,'Mzsj/Link/index',0,1),(72,'关联菜单',70,'Mzsj/Linkage/index',0,1),(73,'添加友链',71,'Mzsj/Link/addlink',0,1),(74,'修改友链',71,'Mzsj/Link/editlink',0,0),(75,'删除友链',71,'Mzsj/Link/dellink',0,0),(76,'添加关联',72,'Mzsj/Linkage/addlinkage',0,1),(77,'修改关联',72,'Mzsj/Linkage/editlinkage',0,0),(78,'删除关联',72,'Mzsj/Linkage/dellinkage',0,0),(79,'推荐位管理',70,'Mzsj/Position/index',0,1),(80,'添加推荐位',79,'Mzsj/Position/addpos',0,1),(81,'修改推荐位',79,'Mzsj/Position/editpos',0,0),(82,'删除推荐位',79,'Mzsj/Position/delpos',0,0),(86,'用户日志',43,'Mzsj/Index/loglist',0,1),(87,'清除7天前日志',86,'Mzsj/Index/clear',0,1),(88,'添加站点',44,'Mzsj/Index/addsite',0,0),(89,'删除站点',44,'Mzsj/Index/delsite',0,0),(90,'更新全站缓存',43,'Mzsj/Index/updatecache',0,1),(91,'查看文章',53,'Mzsj/Content/showart',0,0),(92,'审核文章',53,'Mzsj/Content/shenheart',0,0),(93,'个人信息',42,'Mzsj/Adminedit/admininfo',3,1),(94,'修改个人信息',93,'Mzsj/Adminedit/editadmin',0,1),(95,'修改密码',93,'Mzsj/Adminedit/editpassword',0,1),(96,'修改密码',47,'Mzsj/Admin/editpassword',0,0),(97,'用户',0,'Mzsj/User/index',0,1),(98,'用户管理',97,'Mzsj/User/index',0,1),(99,'用户列表',98,'Mzsj/User/index',0,1),(100,'添加用户',99,'Mzsj/User/adduser',0,1),(101,'修改用户信息',99,'Mzsj/User/editinfo',0,0),(102,'用户密码修改',99,'Mzsj/User/edituser',0,0),(103,'查看用户信息',99,'Mzsj/User/showuser',0,0),(104,'删除用户',99,'Mzsj/User/deluser',0,0),(105,'用户组管理',98,'Mzsj/Group/index',0,1),(106,'添加用户组',105,'Mzsj/Group/addgroup',0,1),(107,'修改用户组',105,'Mzsj/Group/editgroup',0,0),(108,'删除用户组',105,'Mzsj/Group/delgroup',0,0),(109,'更新组权限',105,'Mzsj/Group/grouppriv',0,0),(110,'用户菜单管理',98,'Mzsj/UserMenu/index',0,1),(111,'添加菜单',110,'Mzsj/UserMenu/addusermenu',0,1),(112,'修改用户菜单',110,'Mzsj/UserMenu/editusermenu',0,0),(113,'删除用户菜单',110,'Mzsj/UserMenu/delusermenu',0,0),(122,'微信',0,'Mzsj/Wx/wxmanage',0,1),(118,'类别列表',70,'Mzsj/Type/index',0,1),(119,'添加类别',118,'Mzsj/Type/addtype',0,1),(120,'修改类别',118,'Mzsj/Type/edittype',0,0),(121,'删除类别',118,'Mzsj/Type/deltype',0,0),(123,'微信管理',122,'Mzsj/Wx/wxmanages',0,1),(124,'基本设置',123,'Mzsj/Wx/wxconfig',0,1),(125,'关键字回复',123,'Mzsj/Wx/wxmsg',0,1),(126,'添加回复',125,'Mzsj/Wx/addmsg',0,1),(127,'修改回复',125,'Mzsj/Wx/editmsg',0,0),(128,'删除回复',125,'Mzsj/Wx/delmsg',0,0),(129,'自定义菜单',123,'Mzsj/Wx/menulist',0,1),(130,'添加菜单',129,'Mzsj/Wx/addmenu',0,1),(131,'修改菜单',129,'Mzsj/Wx/editmenu',0,0),(132,'删除菜单',129,'Mzsj/Wx/delmenu',0,0),(133,'更新菜单',129,'Mzsj/Wx/updatemenu',0,1),(134,'用户列表',148,'Mzsj/Wxuser/index',0,1),(135,'清理数据',122,'Mzsj/Wx/clearwx',10,1),(136,'清理缓存',135,'Mzsj/Wx/clearcache',0,1),(137,'清理用户',135,'Mzsj/Wx/clearwx',0,0),(138,'微信菜单',123,'Mzsj/Wx/wxlinkage',0,1),(139,'添加菜单',138,'Mzsj/Wx/addlinkage',0,1),(140,'修改菜单',138,'Mzsj/Wx/editlinkage',0,0),(141,'删除菜单',138,'Mzsj/Wx/dellinkage',0,0),(142,'素材管理',123,'Mzsj/Wxattr/index',0,1),(143,'添加素材',142,'Mzsj/Wxattr/addattr',0,1),(144,'删除素材',142,'Mzsj/Wxattr/delattr',0,0),(145,'附件管理',70,'Mzsj/Attr/index',0,1),(146,'删除附件',145,'Mzsj/Attr/delattr',0,0),(147,'素材数',142,'Mzsj/Wxattr/attrnums',0,1),(148,'用户管理',122,'Mzsj/Wx/usermanage',0,1),(149,'用户分组',148,'Mzsj/Wxgroup/index',0,1),(150,'创建分组',149,'Mzsj/Wxgroup/addgroup',0,1),(151,'修改分组',149,'Mzsj/Wxgroup/editgroup',0,0),(152,'删除分组',149,'Mzsj/Wxgroup/delgroup',0,0),(153,'同步分组',149,'Mzsj/Wxgroup/updategroup',0,1),(154,'获取用户列表',134,'Mzsj/Wxuser/updateuser',0,1),(155,'移动分组',134,'Mzsj/Wxuser/togroup',0,0),(156,'设置备注',134,'Mzsj/Wxuser/remark',0,0);

/*Table structure for table `mzsj_position` */

DROP TABLE IF EXISTS `mzsj_position`;

CREATE TABLE `mzsj_position` (
  `posid` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`posid`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `mzsj_position` */

insert  into `mzsj_position`(`posid`,`name`) values (1,'首页大图2'),(2,'首页大图1');

/*Table structure for table `mzsj_role` */

DROP TABLE IF EXISTS `mzsj_role`;

CREATE TABLE `mzsj_role` (
  `roleid` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `rolename` varchar(20) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`roleid`),
  KEY `roleid` (`roleid`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*Data for the table `mzsj_role` */

insert  into `mzsj_role`(`roleid`,`rolename`,`status`) values (1,'管理员',1),(2,'编辑',1),(3,'小号',1);

/*Table structure for table `mzsj_session` */

DROP TABLE IF EXISTS `mzsj_session`;

CREATE TABLE `mzsj_session` (
  `session_id` varchar(40) NOT NULL,
  `session_expire` int(11) unsigned NOT NULL DEFAULT '0',
  `session_data` varchar(255) DEFAULT NULL,
  UNIQUE KEY `session_id` (`session_id`)
) ENGINE=MEMORY DEFAULT CHARSET=utf8;

/*Data for the table `mzsj_session` */

insert  into `mzsj_session`(`session_id`,`session_expire`,`session_data`) values ('u3ebo43ssb3b829t557lkt5sh1',1452677496,'mzsj_|a:3:{s:10:\"mz_adminid\";s:1:\"1\";s:12:\"mz_adminname\";s:7:\"mzadmin\";s:9:\"mz_roleid\";s:1:\"1\";}');

/*Table structure for table `mzsj_site` */

DROP TABLE IF EXISTS `mzsj_site`;

CREATE TABLE `mzsj_site` (
  `siteid` tinyint(5) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(30) DEFAULT NULL COMMENT '系统名',
  `siteurl` varchar(200) NOT NULL COMMENT '站点域名',
  `sitedir` varchar(30) DEFAULT NULL COMMENT '站点目录',
  `sitename` varchar(100) DEFAULT NULL COMMENT '站点标题',
  `keyword` varchar(150) DEFAULT NULL COMMENT '关键字',
  `description` varchar(300) DEFAULT NULL COMMENT '描述',
  `linkman` varchar(50) DEFAULT NULL COMMENT '联系人',
  `tel` varchar(50) DEFAULT NULL COMMENT '电话',
  `qq` varchar(50) DEFAULT NULL COMMENT 'qq',
  `address` varchar(500) DEFAULT NULL COMMENT '地址',
  `contact` varchar(500) DEFAULT NULL COMMENT '联系方式及版权等',
  `template` varchar(50) NOT NULL COMMENT '默认模板名称',
  PRIMARY KEY (`siteid`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*Data for the table `mzsj_site` */

insert  into `mzsj_site`(`siteid`,`name`,`siteurl`,`sitedir`,`sitename`,`keyword`,`description`,`linkman`,`tel`,`qq`,`address`,`contact`,`template`) values (1,'木子设计','http://xs118267.gotoip2.com','/','木子设计cms','fdsa','fdsa','222','213','3222','ddd','fdsa','default');

/*Table structure for table `mzsj_type` */

DROP TABLE IF EXISTS `mzsj_type`;

CREATE TABLE `mzsj_type` (
  `typeid` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `parentid` smallint(5) unsigned NOT NULL COMMENT '父ID',
  `arrparentid` varchar(255) NOT NULL COMMENT '所有父ID',
  `child` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否存在子分类：1存在',
  `arrchildid` varchar(255) NOT NULL COMMENT '所有子分类',
  `typename` varchar(100) NOT NULL COMMENT '分类名',
  `typedir` varchar(100) NOT NULL COMMENT '分类路径',
  `listorder` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `display` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否显示：1-显示',
  PRIMARY KEY (`typeid`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

/*Data for the table `mzsj_type` */

insert  into `mzsj_type`(`typeid`,`parentid`,`arrparentid`,`child`,`arrchildid`,`typename`,`typedir`,`listorder`,`display`) values (1,0,'0',1,'1,2,3,4','客服','kf',0,1),(2,1,'0,1',0,'2','P2P','p2p',0,1),(3,1,'0,1',0,'3','理财','lc',0,1),(4,1,'0,1',0,'4','众筹','zc',0,1);

/*Table structure for table `mzsj_user` */

DROP TABLE IF EXISTS `mzsj_user`;

CREATE TABLE `mzsj_user` (
  `userid` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `openid` varchar(100) DEFAULT NULL COMMENT 'QQ/sina',
  `ucenterid` mediumint(8) unsigned DEFAULT NULL COMMENT 'Ucenter ID',
  `groupid` smallint(5) unsigned DEFAULT NULL COMMENT '组ID',
  `username` varchar(32) DEFAULT NULL COMMENT '用户名',
  `password` varchar(32) DEFAULT NULL COMMENT '密码',
  `nickname` varchar(20) DEFAULT NULL COMMENT '昵称',
  `thumb` varchar(150) DEFAULT NULL COMMENT '头像',
  `email` varchar(30) DEFAULT NULL COMMENT '邮箱',
  `tel` varchar(20) DEFAULT NULL COMMENT '电话',
  `point` smallint(5) unsigned DEFAULT NULL COMMENT '积分',
  `lastip` char(15) DEFAULT NULL COMMENT '最后登陆IP',
  `lasttime` int(10) unsigned DEFAULT NULL COMMENT '最后登陆时间',
  `regtime` int(10) unsigned DEFAULT NULL COMMENT '注册时间',
  `status` tinyint(1) unsigned DEFAULT '0' COMMENT '状态',
  PRIMARY KEY (`userid`),
  KEY `userid` (`userid`),
  KEY `username` (`username`)
) ENGINE=MyISAM AUTO_INCREMENT=41 DEFAULT CHARSET=utf8;

/*Data for the table `mzsj_user` */

insert  into `mzsj_user`(`userid`,`openid`,`ucenterid`,`groupid`,`username`,`password`,`nickname`,`thumb`,`email`,`tel`,`point`,`lastip`,`lasttime`,`regtime`,`status`) values (1,NULL,NULL,2,'admin','8e1e02ca3401f4667cd586cdf03758fd','fdsa',NULL,'','',0,'127.0.0.1',1439446895,NULL,1);

/*Table structure for table `mzsj_user_menu` */

DROP TABLE IF EXISTS `mzsj_user_menu`;

CREATE TABLE `mzsj_user_menu` (
  `menuid` mediumint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `name` varchar(20) DEFAULT NULL COMMENT '菜单名',
  `parentid` mediumint(5) unsigned DEFAULT NULL COMMENT '父ID',
  `module` char(20) NOT NULL COMMENT '模块',
  `controller` char(20) NOT NULL COMMENT '控制器',
  `action` char(20) NOT NULL COMMENT '方法',
  `data` char(50) DEFAULT NULL COMMENT '参数',
  `listorder` mediumint(5) unsigned DEFAULT NULL COMMENT '排序',
  `display` tinyint(1) unsigned DEFAULT '1' COMMENT '显示：否',
  `level` smallint(5) unsigned DEFAULT NULL COMMENT '层',
  PRIMARY KEY (`menuid`),
  KEY `menuid` (`menuid`),
  KEY `parentid` (`parentid`),
  KEY `module` (`module`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

/*Data for the table `mzsj_user_menu` */

insert  into `mzsj_user_menu`(`menuid`,`name`,`parentid`,`module`,`controller`,`action`,`data`,`listorder`,`display`,`level`) values (1,'个人信息展示',0,'Index','User','index','',0,0,1),(2,'个人信息修改',0,'Index','User','userinfo','',0,1,1),(3,'修改资料',2,'Index','User','userinfo','',0,1,2),(4,'修改密码',2,'Index','User','editpwd','',0,1,2);

/*Table structure for table `mzsj_user_priv` */

DROP TABLE IF EXISTS `mzsj_user_priv`;

CREATE TABLE `mzsj_user_priv` (
  `groupid` tinyint(3) unsigned NOT NULL COMMENT '组ID',
  `menuid` mediumint(6) unsigned NOT NULL COMMENT '菜单ID',
  `module` char(20) NOT NULL COMMENT '模块',
  `controller` char(20) NOT NULL COMMENT '控制器',
  `action` char(20) NOT NULL COMMENT '方法',
  `data` char(50) DEFAULT NULL COMMENT '参数',
  KEY `groupid` (`groupid`,`module`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `mzsj_user_priv` */

insert  into `mzsj_user_priv`(`groupid`,`menuid`,`module`,`controller`,`action`,`data`) values (2,4,'Index','User','editpwd',''),(1,4,'Index','User','editpwd',''),(2,3,'Index','User','userinfo',''),(2,2,'Index','User','userinfo',''),(2,1,'Index','User','index',''),(1,3,'Index','User','userinfo',''),(1,2,'Index','User','userinfo',''),(1,1,'Index','User','index','');

/*Table structure for table `mzsj_wxconfig` */

DROP TABLE IF EXISTS `mzsj_wxconfig`;

CREATE TABLE `mzsj_wxconfig` (
  `wxid` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `appid` char(100) DEFAULT NULL,
  `appsecret` char(100) DEFAULT NULL,
  `rzurl` char(100) DEFAULT NULL,
  `token` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`wxid`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `mzsj_wxconfig` */

insert  into `mzsj_wxconfig`(`wxid`,`appid`,`appsecret`,`rzurl`,`token`) values (1,'wx1bb03278d5d74909','d8f9f0b33a89b1b78038c9fbe9b9d29a','http://xs118267.gotoip2.com/wx/index.html','dddddddd');

/*Table structure for table `mzsj_wxgroup` */

DROP TABLE IF EXISTS `mzsj_wxgroup`;

CREATE TABLE `mzsj_wxgroup` (
  `id` smallint(5) unsigned NOT NULL,
  `name` varchar(100) NOT NULL,
  `count` int(10) DEFAULT '0' COMMENT '用户数量',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `mzsj_wxgroup` */

insert  into `mzsj_wxgroup`(`id`,`name`,`count`) values (0,'未分组',7),(1,'黑名单',0),(2,'星标组',0),(102,'奔在d',0);

/*Table structure for table `mzsj_wxlinkage` */

DROP TABLE IF EXISTS `mzsj_wxlinkage`;

CREATE TABLE `mzsj_wxlinkage` (
  `linkageid` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(30) DEFAULT NULL,
  `val` varchar(30) DEFAULT NULL,
  `parentid` smallint(5) unsigned DEFAULT NULL,
  `listorder` smallint(5) unsigned DEFAULT NULL,
  PRIMARY KEY (`linkageid`),
  KEY `linkageid` (`linkageid`),
  KEY `parentid` (`parentid`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

/*Data for the table `mzsj_wxlinkage` */

insert  into `mzsj_wxlinkage`(`linkageid`,`name`,`val`,`parentid`,`listorder`) values (1,'回复类型','msgtype',0,0),(8,'文本','text',1,0),(9,'图片','image',1,0),(10,'图文','news',1,0),(11,'视频','video',1,0),(12,'语音','voice',1,0),(13,'音乐','music',1,0),(14,'自定义菜单类型','selfmenu',0,0),(15,'点击','click',14,0),(16,'跳转URL','view',14,0);

/*Table structure for table `mzsj_wxmenu` */

DROP TABLE IF EXISTS `mzsj_wxmenu`;

CREATE TABLE `mzsj_wxmenu` (
  `menuid` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `parentid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `name` varchar(50) NOT NULL,
  `type` varchar(20) NOT NULL,
  `key` varchar(50) NOT NULL,
  `url` varchar(300) NOT NULL,
  `listorder` smallint(5) NOT NULL DEFAULT '0',
  PRIMARY KEY (`menuid`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

/*Data for the table `mzsj_wxmenu` */

insert  into `mzsj_wxmenu`(`menuid`,`parentid`,`name`,`type`,`key`,`url`,`listorder`) values (7,0,'木子','view','','http://www.muzisheji.com',0),(8,0,'视频','click','子','',0),(9,8,'子','click','视频','',0),(10,8,'集赞','click','集赞','',0);

/*Table structure for table `mzsj_wxmsg` */

DROP TABLE IF EXISTS `mzsj_wxmsg`;

CREATE TABLE `mzsj_wxmsg` (
  `msgid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `msgtype` char(10) DEFAULT NULL COMMENT '消息类型',
  `msgcon` char(150) DEFAULT NULL COMMENT '消息内容',
  `title` varchar(200) DEFAULT NULL COMMENT '回复标题',
  `content` varbinary(500) DEFAULT NULL COMMENT '回复内容',
  `mediaid` varchar(200) DEFAULT NULL COMMENT '多媒体素材',
  `url` varchar(200) DEFAULT NULL COMMENT '链接地址',
  `music_url` varchar(150) DEFAULT NULL COMMENT '音乐链接',
  `hq_music_url` varchar(150) DEFAULT NULL COMMENT '高品质音乐',
  PRIMARY KEY (`msgid`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

/*Data for the table `mzsj_wxmsg` */

insert  into `mzsj_wxmsg`(`msgid`,`msgtype`,`msgcon`,`title`,`content`,`mediaid`,`url`,`music_url`,`hq_music_url`) values (7,'text','集赞','','<a href=\"http://www.muzisheji.com/wx/oauth/index/\">参与集赞</a>',NULL,'',NULL,NULL),(8,'news','子','这是个测试的','子是子','https://mmbiz.qlogo.cn/mmbiz/x9rmG7ic6DTPEsAFwWD7QyOqS1Oa5OV6w8Mjru4DfCfd8TVFZgN8JoajibeGjg574VGMOAyJxGd5kAODtLVDEmDg/0?wx_fmt=jpeg','',NULL,NULL),(9,'video','视频','看看永久素材能用不','<span>看看永久素材能用不 哈哈哈哈</span>','zy_YJtr2WaMMEooLyd1DNPWWAzol376MGhmsEaAHJyw','',NULL,NULL);

/*Table structure for table `mzsj_wxuser` */

DROP TABLE IF EXISTS `mzsj_wxuser`;

CREATE TABLE `mzsj_wxuser` (
  `userid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `groupid` smallint(5) unsigned NOT NULL COMMENT '用户所在的分组ID',
  `openid` char(100) DEFAULT NULL COMMENT '微信用户id',
  `nickname` varchar(100) DEFAULT NULL COMMENT '微信昵称',
  `sex` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '性别',
  `headimgurl` varchar(100) DEFAULT NULL COMMENT '头像',
  `subscribe_time` int(10) unsigned NOT NULL COMMENT '关注时间',
  `remark` varchar(100) DEFAULT NULL COMMENT '对粉丝的备注',
  `city` varchar(100) DEFAULT NULL COMMENT '城市',
  `country` varchar(100) DEFAULT NULL COMMENT '国家',
  `province` varchar(100) DEFAULT NULL COMMENT '省份',
  `language` varchar(50) DEFAULT NULL COMMENT '语言',
  `subscribe` tinyint(1) DEFAULT '0' COMMENT '是否关注：0为末关注',
  `unionid` varchar(100) DEFAULT NULL COMMENT 'unionid',
  PRIMARY KEY (`userid`),
  KEY `openid` (`openid`),
  KEY `groupid` (`groupid`)
) ENGINE=MyISAM AUTO_INCREMENT=1195 DEFAULT CHARSET=utf8;

/*Data for the table `mzsj_wxuser` */

insert  into `mzsj_wxuser`(`userid`,`groupid`,`openid`,`nickname`,`sex`,`headimgurl`,`subscribe_time`,`remark`,`city`,`country`,`province`,`language`,`subscribe`,`unionid`) values (1188,102,'odUCXs7knkXSkWkQve7NnC-7D3E4','陈佩雷',1,'http://wx.qlogo.cn/mmopen/Q3auHgzwzM6a5O6JN1vNneoILrS6tFAO6bQp3CPnOibauB29YayPD7TrpFvksDUzlCY4tJliab',1441766444,'','','China','Beijing','zh_CN',1,'o-sW_swq6zq2DbzUSA9GgvILeoqM'),(1189,102,'odUCXs4hbAYe76d9456oVxX0i5JM','李志刚',0,'http://wx.qlogo.cn/mmopen/Jmznrnds3WahyHQkyRSxf7HsibomMZmfDeVNVOibaCcibiaMvjA0VDGtkTtTPfJNv8DpoXj8EB',1452473270,'','','','','zh_CN',1,'o-sW_szupt2dT_H5UyEXZSdZXCp8'),(1190,2,'odUCXs56JX0q8p5LlDI2yAkRlbvk','小倩',2,'http://wx.qlogo.cn/mmopen/ouOcEN9N6uyrg04yicm5fwneRkaEChMsnBdzR8aft2qicVQqXjmyl0hx8tsqZpHbjjSaoYrMUb',1439221443,'','Hengshui','China','Hebei','zh_CN',1,'o-sW_sxrsRarP2HaQgXP90HFANUM'),(1191,2,'odUCXs8T0mHaq9KWarX2WOTVzqUY','叶兵',1,'http://wx.qlogo.cn/mmopen/Jmznrnds3WYZoOgUKzcun7Pw88eIcVZlibykc00CMlUicyxRxM5UKkmHkWamlvxjJZjweav6He',1439221441,'','','Papua New Guinea','','zh_CN',1,'o-sW_s7XXaeTGw0buhFjtTiH1GNw'),(1192,102,'odUCXsyiwnm-ZQ4qWLofTqG7YvIY','羽化成仙',2,'http://wx.qlogo.cn/mmopen/MgUJSNwEdQlzibSEzUHt1M2AZG0IGuZC3iaV0t2INK3M9HNZO8u7hl5r3DCPCsdIBNvqrMW4Kh',1452503456,'','Hengshui','China','Hebei','zh_CN',1,'o-sW_s936WYPyHv8SVwePG-LhwNs'),(1193,102,'odUCXs-M1ij0cbzublh0RyodiiOQ','额',2,'http://wx.qlogo.cn/mmopen/Q3auHgzwzM5eibicqaKw3a7hB9Rn0JPA6Sch0ib1ZV2tqGzCRGS23ib8Czahq6OUEyrXbqhtSD',1439222136,'','Zhenjiang','China','Jiangsu','zh_CN',1,'o-sW_s-5TP-LV7uioTM0obo9eFnM'),(1194,102,'odUCXs20NOqb5JoupbFjhMyjjKuo','云淡风轻',2,'http://wx.qlogo.cn/mmopen/MgUJSNwEdQlzibSEzUHt1M98npxp6FJOqBXF9tZef1z88pcYNs7DibKyK4XflvSBh5hyjTBibB',1439264965,'ddd','','Andorra','','zh_CN',1,'o-sW_s77fpG7W9l8B35JiqCkP3Gc');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
