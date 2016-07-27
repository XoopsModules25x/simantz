-- MySQL dump 10.11
--
-- Host: localhost    Database: simbill
-- ------------------------------------------------------
-- Server version	5.0.45-Debian_1ubuntu3.3-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Current Database: `simbill`
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `simbill` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `simbill`;

--
-- Table structure for table `mega_avatar`
--

DROP TABLE IF EXISTS `mega_avatar`;
CREATE TABLE `mega_avatar` (
  `avatar_id` mediumint(8) unsigned NOT NULL auto_increment,
  `avatar_file` varchar(30) NOT NULL default '',
  `avatar_name` varchar(100) NOT NULL default '',
  `avatar_mimetype` varchar(30) NOT NULL default '',
  `avatar_created` int(10) NOT NULL default '0',
  `avatar_display` tinyint(1) unsigned NOT NULL default '0',
  `avatar_weight` smallint(5) unsigned NOT NULL default '0',
  `avatar_type` char(1) NOT NULL default '',
  PRIMARY KEY  (`avatar_id`),
  KEY `avatar_type` (`avatar_type`,`avatar_display`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mega_avatar`
--

LOCK TABLES `mega_avatar` WRITE;
/*!40000 ALTER TABLE `mega_avatar` DISABLE KEYS */;
/*!40000 ALTER TABLE `mega_avatar` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mega_avatar_user_link`
--

DROP TABLE IF EXISTS `mega_avatar_user_link`;
CREATE TABLE `mega_avatar_user_link` (
  `avatar_id` mediumint(8) unsigned NOT NULL default '0',
  `user_id` mediumint(8) unsigned NOT NULL default '0',
  KEY `avatar_user_id` (`avatar_id`,`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mega_avatar_user_link`
--

LOCK TABLES `mega_avatar_user_link` WRITE;
/*!40000 ALTER TABLE `mega_avatar_user_link` DISABLE KEYS */;
/*!40000 ALTER TABLE `mega_avatar_user_link` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mega_banner`
--

DROP TABLE IF EXISTS `mega_banner`;
CREATE TABLE `mega_banner` (
  `bid` smallint(5) unsigned NOT NULL auto_increment,
  `cid` tinyint(3) unsigned NOT NULL default '0',
  `imptotal` mediumint(8) unsigned NOT NULL default '0',
  `impmade` mediumint(8) unsigned NOT NULL default '0',
  `clicks` mediumint(8) unsigned NOT NULL default '0',
  `imageurl` varchar(255) NOT NULL default '',
  `clickurl` varchar(255) NOT NULL default '',
  `date` int(10) NOT NULL default '0',
  `htmlbanner` tinyint(1) NOT NULL default '0',
  `htmlcode` text NOT NULL,
  PRIMARY KEY  (`bid`),
  KEY `idxbannercid` (`cid`),
  KEY `idxbannerbidcid` (`bid`,`cid`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mega_banner`
--

LOCK TABLES `mega_banner` WRITE;
/*!40000 ALTER TABLE `mega_banner` DISABLE KEYS */;
INSERT INTO `mega_banner` VALUES (1,1,0,1,0,'http://localhost/simbill/images/banners/xoops_banner.gif','http://www.xoops.org/',1008813250,0,''),(2,1,0,1,0,'http://localhost/simbill/images/banners/xoops_banner_2.gif','http://www.xoops.org/',1008813250,0,''),(3,1,0,1,0,'http://localhost/simbill/images/banners/banner.swf','http://www.xoops.org/',1008813250,0,'');
/*!40000 ALTER TABLE `mega_banner` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mega_bannerclient`
--

DROP TABLE IF EXISTS `mega_bannerclient`;
CREATE TABLE `mega_bannerclient` (
  `cid` smallint(5) unsigned NOT NULL auto_increment,
  `name` varchar(60) NOT NULL default '',
  `contact` varchar(60) NOT NULL default '',
  `email` varchar(60) NOT NULL default '',
  `login` varchar(10) NOT NULL default '',
  `passwd` varchar(10) NOT NULL default '',
  `extrainfo` text NOT NULL,
  PRIMARY KEY  (`cid`),
  KEY `login` (`login`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mega_bannerclient`
--

LOCK TABLES `mega_bannerclient` WRITE;
/*!40000 ALTER TABLE `mega_bannerclient` DISABLE KEYS */;
INSERT INTO `mega_bannerclient` VALUES (1,'XOOPS','XOOPS Dev Team','webmaster@xoops.org','','','');
/*!40000 ALTER TABLE `mega_bannerclient` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mega_bannerfinish`
--

DROP TABLE IF EXISTS `mega_bannerfinish`;
CREATE TABLE `mega_bannerfinish` (
  `bid` smallint(5) unsigned NOT NULL auto_increment,
  `cid` smallint(5) unsigned NOT NULL default '0',
  `impressions` mediumint(8) unsigned NOT NULL default '0',
  `clicks` mediumint(8) unsigned NOT NULL default '0',
  `datestart` int(10) unsigned NOT NULL default '0',
  `dateend` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`bid`),
  KEY `cid` (`cid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mega_bannerfinish`
--

LOCK TABLES `mega_bannerfinish` WRITE;
/*!40000 ALTER TABLE `mega_bannerfinish` DISABLE KEYS */;
/*!40000 ALTER TABLE `mega_bannerfinish` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mega_block_module_link`
--

DROP TABLE IF EXISTS `mega_block_module_link`;
CREATE TABLE `mega_block_module_link` (
  `block_id` mediumint(8) unsigned NOT NULL default '0',
  `module_id` smallint(5) NOT NULL default '0',
  KEY `module_id` (`module_id`),
  KEY `block_id` (`block_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mega_block_module_link`
--

LOCK TABLES `mega_block_module_link` WRITE;
/*!40000 ALTER TABLE `mega_block_module_link` DISABLE KEYS */;
INSERT INTO `mega_block_module_link` VALUES (1,0),(2,0),(3,0),(4,0),(5,0),(6,0),(7,0),(8,0),(9,0),(10,0),(11,0),(12,0);
/*!40000 ALTER TABLE `mega_block_module_link` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mega_config`
--

DROP TABLE IF EXISTS `mega_config`;
CREATE TABLE `mega_config` (
  `conf_id` smallint(5) unsigned NOT NULL auto_increment,
  `conf_modid` smallint(5) unsigned NOT NULL default '0',
  `conf_catid` smallint(5) unsigned NOT NULL default '0',
  `conf_name` varchar(25) NOT NULL default '',
  `conf_title` varchar(255) NOT NULL default '',
  `conf_value` text NOT NULL,
  `conf_desc` varchar(255) NOT NULL default '',
  `conf_formtype` varchar(15) NOT NULL default '',
  `conf_valuetype` varchar(10) NOT NULL default '',
  `conf_order` smallint(5) unsigned NOT NULL default '0',
  PRIMARY KEY  (`conf_id`),
  KEY `conf_mod_cat_id` (`conf_modid`,`conf_catid`)
) ENGINE=MyISAM AUTO_INCREMENT=94 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mega_config`
--

LOCK TABLES `mega_config` WRITE;
/*!40000 ALTER TABLE `mega_config` DISABLE KEYS */;
INSERT INTO `mega_config` VALUES (1,0,1,'sitename','_MD_AM_SITENAME','XOOPS Site','_MD_AM_SITENAMEDSC','textbox','text',0),(2,0,1,'slogan','_MD_AM_SLOGAN','Just Use it!','_MD_AM_SLOGANDSC','textbox','text',2),(3,0,1,'language','_MD_AM_LANGUAGE','english','_MD_AM_LANGUAGEDSC','language','other',4),(4,0,1,'startpage','_MD_AM_STARTPAGE','--','_MD_AM_STARTPAGEDSC','startpage','other',6),(5,0,1,'server_TZ','_MD_AM_SERVERTZ','0','_MD_AM_SERVERTZDSC','timezone','float',8),(6,0,1,'default_TZ','_MD_AM_DEFAULTTZ','0','_MD_AM_DEFAULTTZDSC','timezone','float',10),(7,0,1,'theme_set','_MD_AM_DTHEME','default','_MD_AM_DTHEMEDSC','theme','other',12),(8,0,1,'anonymous','_MD_AM_ANONNAME','Anonymous','_MD_AM_ANONNAMEDSC','textbox','text',15),(9,0,1,'gzip_compression','_MD_AM_USEGZIP','0','_MD_AM_USEGZIPDSC','yesno','int',16),(10,0,1,'usercookie','_MD_AM_USERCOOKIE','xoops_user','_MD_AM_USERCOOKIEDSC','textbox','text',18),(11,0,1,'session_expire','_MD_AM_SESSEXPIRE','15','_MD_AM_SESSEXPIREDSC','textbox','int',22),(12,0,1,'banners','_MD_AM_BANNERS','1','_MD_AM_BANNERSDSC','yesno','int',26),(13,0,1,'debug_mode','_MD_AM_DEBUGMODE','0','_MD_AM_DEBUGMODEDSC','select','int',24),(14,0,1,'my_ip','_MD_AM_MYIP','127.0.0.1','_MD_AM_MYIPDSC','textbox','text',29),(15,0,1,'use_ssl','_MD_AM_USESSL','0','_MD_AM_USESSLDSC','yesno','int',30),(16,0,1,'session_name','_MD_AM_SESSNAME','xoops_session','_MD_AM_SESSNAMEDSC','textbox','text',20),(17,0,2,'minpass','_MD_AM_MINPASS','5','_MD_AM_MINPASSDSC','textbox','int',1),(18,0,2,'minuname','_MD_AM_MINUNAME','3','_MD_AM_MINUNAMEDSC','textbox','int',2),(19,0,2,'new_user_notify','_MD_AM_NEWUNOTIFY','1','_MD_AM_NEWUNOTIFYDSC','yesno','int',4),(20,0,2,'new_user_notify_group','_MD_AM_NOTIFYTO','1','_MD_AM_NOTIFYTODSC','group','int',6),(21,0,2,'activation_type','_MD_AM_ACTVTYPE','0','_MD_AM_ACTVTYPEDSC','select','int',8),(22,0,2,'activation_group','_MD_AM_ACTVGROUP','1','_MD_AM_ACTVGROUPDSC','group','int',10),(23,0,2,'uname_test_level','_MD_AM_UNAMELVL','0','_MD_AM_UNAMELVLDSC','select','int',12),(24,0,2,'avatar_allow_upload','_MD_AM_AVATARALLOW','0','_MD_AM_AVATARALWDSC','yesno','int',14),(27,0,2,'avatar_width','_MD_AM_AVATARW','80','_MD_AM_AVATARWDSC','textbox','int',16),(28,0,2,'avatar_height','_MD_AM_AVATARH','80','_MD_AM_AVATARHDSC','textbox','int',18),(29,0,2,'avatar_maxsize','_MD_AM_AVATARMAX','35000','_MD_AM_AVATARMAXDSC','textbox','int',20),(30,0,1,'adminmail','_MD_AM_ADMINML','admin@simit.com.my','_MD_AM_ADMINMLDSC','textbox','text',3),(31,0,2,'self_delete','_MD_AM_SELFDELETE','0','_MD_AM_SELFDELETEDSC','yesno','int',22),(32,0,1,'com_mode','_MD_AM_COMMODE','nest','_MD_AM_COMMODEDSC','select','text',34),(33,0,1,'com_order','_MD_AM_COMORDER','0','_MD_AM_COMORDERDSC','select','int',36),(34,0,2,'bad_unames','_MD_AM_BADUNAMES','a:3:{i:0;s:9:\"webmaster\";i:1;s:6:\"^xoops\";i:2;s:6:\"^admin\";}','_MD_AM_BADUNAMESDSC','textarea','array',24),(35,0,2,'bad_emails','_MD_AM_BADEMAILS','a:1:{i:0;s:10:\"xoops.org$\";}','_MD_AM_BADEMAILSDSC','textarea','array',26),(36,0,2,'maxuname','_MD_AM_MAXUNAME','10','_MD_AM_MAXUNAMEDSC','textbox','int',3),(37,0,1,'bad_ips','_MD_AM_BADIPS','a:1:{i:0;s:9:\"127.0.0.1\";}','_MD_AM_BADIPSDSC','textarea','array',42),(38,0,3,'meta_keywords','_MD_AM_METAKEY','news, technology, headlines, xoops, xoop, nuke, myphpnuke, myphp-nuke, phpnuke, SE, geek, geeks, hacker, hackers, linux, software, download, downloads, free, community, mp3, forum, forums, bulletin, board, boards, bbs, php, survey, poll, polls, kernel, comment, comments, portal, odp, open, source, opensource, FreeSoftware, gnu, gpl, license, Unix, *nix, mysql, sql, database, databases, web site, weblog, guru, module, modules, theme, themes, cms, content management','_MD_AM_METAKEYDSC','textarea','text',0),(39,0,3,'footer','_MD_AM_FOOTER','Powered by XOOPS 2.0 &copy; 2001-2008 <a href=\"http://xoops.sourceforge.net/\" target=\"_blank\">The XOOPS Project</a>','_MD_AM_FOOTERDSC','textarea','text',20),(40,0,4,'censor_enable','_MD_AM_DOCENSOR','0','_MD_AM_DOCENSORDSC','yesno','int',0),(41,0,4,'censor_words','_MD_AM_CENSORWRD','a:2:{i:0;s:4:\"fuck\";i:1;s:4:\"shit\";}','_MD_AM_CENSORWRDDSC','textarea','array',1),(42,0,4,'censor_replace','_MD_AM_CENSORRPLC','#OOPS#','_MD_AM_CENSORRPLCDSC','textbox','text',2),(43,0,3,'meta_robots','_MD_AM_METAROBOTS','index,follow','_MD_AM_METAROBOTSDSC','select','text',2),(44,0,5,'enable_search','_MD_AM_DOSEARCH','1','_MD_AM_DOSEARCHDSC','yesno','int',0),(45,0,5,'keyword_min','_MD_AM_MINSEARCH','5','_MD_AM_MINSEARCHDSC','textbox','int',1),(46,0,2,'avatar_minposts','_MD_AM_AVATARMP','0','_MD_AM_AVATARMPDSC','textbox','int',15),(47,0,1,'enable_badips','_MD_AM_DOBADIPS','0','_MD_AM_DOBADIPSDSC','yesno','int',40),(48,0,3,'meta_rating','_MD_AM_METARATING','general','_MD_AM_METARATINGDSC','select','text',4),(49,0,3,'meta_author','_MD_AM_METAAUTHOR','XOOPS','_MD_AM_METAAUTHORDSC','textbox','text',6),(50,0,3,'meta_copyright','_MD_AM_METACOPYR','Copyright &copy; 2001-2008','_MD_AM_METACOPYRDSC','textbox','text',8),(51,0,3,'meta_description','_MD_AM_METADESC','XOOPS is a dynamic Object Oriented based open source portal script written in PHP.','_MD_AM_METADESCDSC','textarea','text',1),(52,0,2,'allow_chgmail','_MD_AM_ALLWCHGMAIL','0','_MD_AM_ALLWCHGMAILDSC','yesno','int',3),(53,0,1,'use_mysession','_MD_AM_USEMYSESS','0','_MD_AM_USEMYSESSDSC','yesno','int',19),(54,0,2,'reg_dispdsclmr','_MD_AM_DSPDSCLMR','1','_MD_AM_DSPDSCLMRDSC','yesno','int',30),(55,0,2,'reg_disclaimer','_MD_AM_REGDSCLMR','While the administrators and moderators of this site will attempt to remove\r\nor edit any generally objectionable material as quickly as possible, it is\r\nimpossible to review every message. Therefore you acknowledge that all posts\r\nmade to this site express the views and opinions of the author and not the\r\nadministrators, moderators or webmaster (except for posts by these people)\r\nand hence will not be held liable. \r\n\r\nYou agree not to post any abusive, obscene, vulgar, slanderous, hateful,\r\nthreatening, sexually-orientated or any other material that may violate any\r\napplicable laws. Doing so may lead to you being immediately and permanently\r\nbanned (and your service provider being informed). The IP address of all\r\nposts is recorded to aid in enforcing these conditions. Creating multiple\r\naccounts for a single user is not allowed. You agree that the webmaster,\r\nadministrator and moderators of this site have the right to remove, edit,\r\nmove or close any topic at any time should they see fit. As a user you agree\r\nto any information you have entered above being stored in a database. While\r\nthis information will not be disclosed to any third party without your\r\nconsent the webmaster, administrator and moderators cannot be held\r\nresponsible for any hacking attempt that may lead to the data being\r\ncompromised. \r\n\r\nThis site system uses cookies to store information on your local computer.\r\nThese cookies do not contain any of the information you have entered above,\r\nthey serve only to improve your viewing pleasure. The email address is used\r\nonly for confirming your registration details and password (and for sending\r\nnew passwords should you forget your current one). \r\n\r\nBy clicking Register below you agree to be bound by these conditions.','_MD_AM_REGDSCLMRDSC','textarea','text',32),(56,0,2,'allow_register','_MD_AM_ALLOWREG','1','_MD_AM_ALLOWREGDSC','yesno','int',0),(57,0,1,'theme_fromfile','_MD_AM_THEMEFILE','0','_MD_AM_THEMEFILEDSC','yesno','int',13),(58,0,1,'closesite','_MD_AM_CLOSESITE','0','_MD_AM_CLOSESITEDSC','yesno','int',26),(59,0,1,'closesite_okgrp','_MD_AM_CLOSESITEOK','a:1:{i:0;s:1:\"1\";}','_MD_AM_CLOSESITEOKDSC','group_multi','array',27),(60,0,1,'closesite_text','_MD_AM_CLOSESITETXT','The site is currently closed for maintenance. Please come back later.','_MD_AM_CLOSESITETXTDSC','textarea','text',28),(61,0,1,'sslpost_name','_MD_AM_SSLPOST','xoops_ssl','_MD_AM_SSLPOSTDSC','textbox','text',31),(62,0,1,'module_cache','_MD_AM_MODCACHE','','_MD_AM_MODCACHEDSC','module_cache','array',50),(63,0,1,'template_set','_MD_AM_DTPLSET','default','_MD_AM_DTPLSETDSC','tplset','other',14),(64,0,6,'mailmethod','_MD_AM_MAILERMETHOD','mail','_MD_AM_MAILERMETHODDESC','select','text',4),(65,0,6,'smtphost','_MD_AM_SMTPHOST','a:1:{i:0;s:0:\"\";}','_MD_AM_SMTPHOSTDESC','textarea','array',6),(66,0,6,'smtpuser','_MD_AM_SMTPUSER','','_MD_AM_SMTPUSERDESC','textbox','text',7),(67,0,6,'smtppass','_MD_AM_SMTPPASS','','_MD_AM_SMTPPASSDESC','password','text',8),(68,0,6,'sendmailpath','_MD_AM_SENDMAILPATH','/usr/sbin/sendmail','_MD_AM_SENDMAILPATHDESC','textbox','text',5),(69,0,6,'from','_MD_AM_MAILFROM','','_MD_AM_MAILFROMDESC','textbox','text',1),(70,0,6,'fromname','_MD_AM_MAILFROMNAME','','_MD_AM_MAILFROMNAMEDESC','textbox','text',2),(71,0,1,'sslloginlink','_MD_AM_SSLLINK','https://','_MD_AM_SSLLINKDSC','textbox','text',33),(72,0,1,'theme_set_allowed','_MD_AM_THEMEOK','a:1:{i:0;s:7:\"default\";}','_MD_AM_THEMEOKDSC','theme_multi','array',13),(73,0,6,'fromuid','_MD_AM_MAILFROMUID','1','_MD_AM_MAILFROMUIDDESC','user','int',3),(74,0,7,'auth_method','_MD_AM_AUTHMETHOD','xoops','_MD_AM_AUTHMETHODDESC','select','text',1),(75,0,7,'ldap_port','_MD_AM_LDAP_PORT','389','_MD_AM_LDAP_PORT','textbox','int',2),(76,0,7,'ldap_server','_MD_AM_LDAP_SERVER','your directory server','_MD_AM_LDAP_SERVER_DESC','textbox','text',3),(77,0,7,'ldap_base_dn','_MD_AM_LDAP_BASE_DN','dc=xoops,dc=org','_MD_AM_LDAP_BASE_DN_DESC','textbox','text',4),(78,0,7,'ldap_manager_dn','_MD_AM_LDAP_MANAGER_DN','manager_dn','_MD_AM_LDAP_MANAGER_DN_DESC','textbox','text',5),(79,0,7,'ldap_manager_pass','_MD_AM_LDAP_MANAGER_PASS','manager_pass','_MD_AM_LDAP_MANAGER_PASS_DESC','password','text',6),(80,0,7,'ldap_version','_MD_AM_LDAP_VERSION','3','_MD_AM_LDAP_VERSION_DESC','textbox','text',7),(81,0,7,'ldap_users_bypass','_MD_AM_LDAP_USERS_BYPASS','a:1:{i:0;s:5:\"admin\";}','_MD_AM_LDAP_USERS_BYPASS_DESC','textarea','array',8),(82,0,7,'ldap_loginname_asdn','_MD_AM_LDAP_LOGINNAME_ASDN','uid_asdn','_MD_AM_LDAP_LOGINNAME_ASDN_D','yesno','int',9),(83,0,7,'ldap_loginldap_attr','_MD_AM_LDAP_LOGINLDAP_ATTR','uid','_MD_AM_LDAP_LOGINLDAP_ATTR_D','textbox','text',10),(84,0,7,'ldap_filter_person','_MD_AM_LDAP_FILTER_PERSON','','_MD_AM_LDAP_FILTER_PERSON_DESC','textbox','text',11),(85,0,7,'ldap_domain_name','_MD_AM_LDAP_DOMAIN_NAME','mydomain','_MD_AM_LDAP_DOMAIN_NAME_DESC','textbox','text',12),(86,0,7,'ldap_provisionning','_MD_AM_LDAP_PROVIS','0','_MD_AM_LDAP_PROVIS_DESC','yesno','int',13),(87,0,7,'ldap_provisionning_group','_MD_AM_LDAP_PROVIS_GROUP','a:1:{i:0;s:1:\"2\";}','_MD_AM_LDAP_PROVIS_GROUP_DSC','group_multi','array',14),(88,0,7,'ldap_mail_attr','_MD_AM_LDAP_MAIL_ATTR','mail','_MD_AM_LDAP_MAIL_ATTR_DESC','textbox','text',15),(89,0,7,'ldap_givenname_attr','_MD_AM_LDAP_GIVENNAME_ATTR','givenname','_MD_AM_LDAP_GIVENNAME_ATTR_DSC','textbox','text',16),(90,0,7,'ldap_surname_attr','_MD_AM_LDAP_SURNAME_ATTR','sn','_MD_AM_LDAP_SURNAME_ATTR_DESC','textbox','text',17),(91,0,7,'ldap_field_mapping','_MD_AM_LDAP_FIELD_MAPPING_ATTR','email=mail|name=displayname','_MD_AM_LDAP_FIELD_MAPPING_DESC','textarea','text',18),(92,0,7,'ldap_provisionning_upd','_MD_AM_LDAP_PROVIS_UPD','1','_MD_AM_LDAP_PROVIS_UPD_DESC','yesno','int',19),(93,0,7,'ldap_use_TLS','_MD_AM_LDAP_USETLS','0','_MD_AM_LDAP_USETLS_DESC','yesno','int',20);
/*!40000 ALTER TABLE `mega_config` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mega_configcategory`
--

DROP TABLE IF EXISTS `mega_configcategory`;
CREATE TABLE `mega_configcategory` (
  `confcat_id` smallint(5) unsigned NOT NULL auto_increment,
  `confcat_name` varchar(255) NOT NULL default '',
  `confcat_order` smallint(5) unsigned NOT NULL default '0',
  PRIMARY KEY  (`confcat_id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mega_configcategory`
--

LOCK TABLES `mega_configcategory` WRITE;
/*!40000 ALTER TABLE `mega_configcategory` DISABLE KEYS */;
INSERT INTO `mega_configcategory` VALUES (1,'_MD_AM_GENERAL',0),(2,'_MD_AM_USERSETTINGS',0),(3,'_MD_AM_METAFOOTER',0),(4,'_MD_AM_CENSOR',0),(5,'_MD_AM_SEARCH',0),(6,'_MD_AM_MAILER',0),(7,'_MD_AM_AUTHENTICATION',0);
/*!40000 ALTER TABLE `mega_configcategory` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mega_configoption`
--

DROP TABLE IF EXISTS `mega_configoption`;
CREATE TABLE `mega_configoption` (
  `confop_id` mediumint(8) unsigned NOT NULL auto_increment,
  `confop_name` varchar(255) NOT NULL default '',
  `confop_value` varchar(255) NOT NULL default '',
  `conf_id` smallint(5) unsigned NOT NULL default '0',
  PRIMARY KEY  (`confop_id`),
  KEY `conf_id` (`conf_id`)
) ENGINE=MyISAM AUTO_INCREMENT=31 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mega_configoption`
--

LOCK TABLES `mega_configoption` WRITE;
/*!40000 ALTER TABLE `mega_configoption` DISABLE KEYS */;
INSERT INTO `mega_configoption` VALUES (1,'_MD_AM_DEBUGMODE1','1',13),(2,'_MD_AM_DEBUGMODE2','2',13),(3,'_NESTED','nest',32),(4,'_FLAT','flat',32),(5,'_THREADED','thread',32),(6,'_OLDESTFIRST','0',33),(7,'_NEWESTFIRST','1',33),(8,'_MD_AM_USERACTV','0',21),(9,'_MD_AM_AUTOACTV','1',21),(10,'_MD_AM_ADMINACTV','2',21),(11,'_MD_AM_STRICT','0',23),(12,'_MD_AM_MEDIUM','1',23),(13,'_MD_AM_LIGHT','2',23),(14,'_MD_AM_DEBUGMODE3','3',13),(15,'_MD_AM_INDEXFOLLOW','index,follow',43),(16,'_MD_AM_NOINDEXFOLLOW','noindex,follow',43),(17,'_MD_AM_INDEXNOFOLLOW','index,nofollow',43),(18,'_MD_AM_NOINDEXNOFOLLOW','noindex,nofollow',43),(19,'_MD_AM_METAOGEN','general',48),(20,'_MD_AM_METAO14YRS','14 years',48),(21,'_MD_AM_METAOREST','restricted',48),(22,'_MD_AM_METAOMAT','mature',48),(23,'_MD_AM_DEBUGMODE0','0',13),(24,'PHP mail()','mail',64),(25,'sendmail','sendmail',64),(26,'SMTP','smtp',64),(27,'SMTPAuth','smtpauth',64),(28,'_MD_AM_AUTH_CONFOPTION_XOOPS','xoops',74),(29,'_MD_AM_AUTH_CONFOPTION_LDAP','ldap',74),(30,'_MD_AM_AUTH_CONFOPTION_AD','ads',74);
/*!40000 ALTER TABLE `mega_configoption` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mega_group_permission`
--

DROP TABLE IF EXISTS `mega_group_permission`;
CREATE TABLE `mega_group_permission` (
  `gperm_id` int(10) unsigned NOT NULL auto_increment,
  `gperm_groupid` smallint(5) unsigned NOT NULL default '0',
  `gperm_itemid` mediumint(8) unsigned NOT NULL default '0',
  `gperm_modid` mediumint(5) unsigned NOT NULL default '0',
  `gperm_name` varchar(50) NOT NULL default '',
  PRIMARY KEY  (`gperm_id`),
  KEY `groupid` (`gperm_groupid`),
  KEY `itemid` (`gperm_itemid`),
  KEY `gperm_modid` (`gperm_modid`,`gperm_name`(10))
) ENGINE=MyISAM AUTO_INCREMENT=56 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mega_group_permission`
--

LOCK TABLES `mega_group_permission` WRITE;
/*!40000 ALTER TABLE `mega_group_permission` DISABLE KEYS */;
INSERT INTO `mega_group_permission` VALUES (1,1,1,1,'module_admin'),(2,1,1,1,'module_read'),(3,2,1,1,'module_read'),(4,3,1,1,'module_read'),(5,1,1,1,'system_admin'),(6,1,2,1,'system_admin'),(7,1,3,1,'system_admin'),(8,1,4,1,'system_admin'),(9,1,5,1,'system_admin'),(10,1,6,1,'system_admin'),(11,1,7,1,'system_admin'),(12,1,8,1,'system_admin'),(13,1,9,1,'system_admin'),(14,1,10,1,'system_admin'),(15,1,11,1,'system_admin'),(16,1,12,1,'system_admin'),(17,1,13,1,'system_admin'),(18,1,14,1,'system_admin'),(19,1,15,1,'system_admin'),(20,1,1,1,'block_read'),(21,2,1,1,'block_read'),(22,3,1,1,'block_read'),(23,1,2,1,'block_read'),(24,2,2,1,'block_read'),(25,3,2,1,'block_read'),(26,1,3,1,'block_read'),(27,2,3,1,'block_read'),(28,3,3,1,'block_read'),(29,1,4,1,'block_read'),(30,2,4,1,'block_read'),(31,3,4,1,'block_read'),(32,1,5,1,'block_read'),(33,2,5,1,'block_read'),(34,3,5,1,'block_read'),(35,1,6,1,'block_read'),(36,2,6,1,'block_read'),(37,3,6,1,'block_read'),(38,1,7,1,'block_read'),(39,2,7,1,'block_read'),(40,3,7,1,'block_read'),(41,1,8,1,'block_read'),(42,2,8,1,'block_read'),(43,3,8,1,'block_read'),(44,1,9,1,'block_read'),(45,2,9,1,'block_read'),(46,3,9,1,'block_read'),(47,1,10,1,'block_read'),(48,2,10,1,'block_read'),(49,3,10,1,'block_read'),(50,1,11,1,'block_read'),(51,2,11,1,'block_read'),(52,3,11,1,'block_read'),(53,1,12,1,'block_read'),(54,2,12,1,'block_read'),(55,3,12,1,'block_read');
/*!40000 ALTER TABLE `mega_group_permission` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mega_groups`
--

DROP TABLE IF EXISTS `mega_groups`;
CREATE TABLE `mega_groups` (
  `groupid` smallint(5) unsigned NOT NULL auto_increment,
  `name` varchar(50) NOT NULL default '',
  `description` text NOT NULL,
  `group_type` varchar(10) NOT NULL default '',
  PRIMARY KEY  (`groupid`),
  KEY `group_type` (`group_type`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mega_groups`
--

LOCK TABLES `mega_groups` WRITE;
/*!40000 ALTER TABLE `mega_groups` DISABLE KEYS */;
INSERT INTO `mega_groups` VALUES (1,'Webmasters','Webmasters of this site','Admin'),(2,'Registered Users','Registered Users Group','User'),(3,'Anonymous Users','Anonymous Users Group','Anonymous');
/*!40000 ALTER TABLE `mega_groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mega_groups_users_link`
--

DROP TABLE IF EXISTS `mega_groups_users_link`;
CREATE TABLE `mega_groups_users_link` (
  `linkid` mediumint(8) unsigned NOT NULL auto_increment,
  `groupid` smallint(5) unsigned NOT NULL default '0',
  `uid` mediumint(8) unsigned NOT NULL default '0',
  PRIMARY KEY  (`linkid`),
  KEY `groupid_uid` (`groupid`,`uid`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mega_groups_users_link`
--

LOCK TABLES `mega_groups_users_link` WRITE;
/*!40000 ALTER TABLE `mega_groups_users_link` DISABLE KEYS */;
INSERT INTO `mega_groups_users_link` VALUES (1,1,1),(2,2,1);
/*!40000 ALTER TABLE `mega_groups_users_link` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mega_image`
--

DROP TABLE IF EXISTS `mega_image`;
CREATE TABLE `mega_image` (
  `image_id` mediumint(8) unsigned NOT NULL auto_increment,
  `image_name` varchar(30) NOT NULL default '',
  `image_nicename` varchar(255) NOT NULL default '',
  `image_mimetype` varchar(30) NOT NULL default '',
  `image_created` int(10) unsigned NOT NULL default '0',
  `image_display` tinyint(1) unsigned NOT NULL default '0',
  `image_weight` smallint(5) unsigned NOT NULL default '0',
  `imgcat_id` smallint(5) unsigned NOT NULL default '0',
  PRIMARY KEY  (`image_id`),
  KEY `imgcat_id` (`imgcat_id`),
  KEY `image_display` (`image_display`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mega_image`
--

LOCK TABLES `mega_image` WRITE;
/*!40000 ALTER TABLE `mega_image` DISABLE KEYS */;
/*!40000 ALTER TABLE `mega_image` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mega_imagebody`
--

DROP TABLE IF EXISTS `mega_imagebody`;
CREATE TABLE `mega_imagebody` (
  `image_id` mediumint(8) unsigned NOT NULL default '0',
  `image_body` mediumblob,
  KEY `image_id` (`image_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mega_imagebody`
--

LOCK TABLES `mega_imagebody` WRITE;
/*!40000 ALTER TABLE `mega_imagebody` DISABLE KEYS */;
/*!40000 ALTER TABLE `mega_imagebody` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mega_imagecategory`
--

DROP TABLE IF EXISTS `mega_imagecategory`;
CREATE TABLE `mega_imagecategory` (
  `imgcat_id` smallint(5) unsigned NOT NULL auto_increment,
  `imgcat_name` varchar(100) NOT NULL default '',
  `imgcat_maxsize` int(8) unsigned NOT NULL default '0',
  `imgcat_maxwidth` smallint(3) unsigned NOT NULL default '0',
  `imgcat_maxheight` smallint(3) unsigned NOT NULL default '0',
  `imgcat_display` tinyint(1) unsigned NOT NULL default '0',
  `imgcat_weight` smallint(3) unsigned NOT NULL default '0',
  `imgcat_type` char(1) NOT NULL default '',
  `imgcat_storetype` varchar(5) NOT NULL default '',
  PRIMARY KEY  (`imgcat_id`),
  KEY `imgcat_display` (`imgcat_display`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mega_imagecategory`
--

LOCK TABLES `mega_imagecategory` WRITE;
/*!40000 ALTER TABLE `mega_imagecategory` DISABLE KEYS */;
/*!40000 ALTER TABLE `mega_imagecategory` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mega_imgset`
--

DROP TABLE IF EXISTS `mega_imgset`;
CREATE TABLE `mega_imgset` (
  `imgset_id` smallint(5) unsigned NOT NULL auto_increment,
  `imgset_name` varchar(50) NOT NULL default '',
  `imgset_refid` mediumint(8) unsigned NOT NULL default '0',
  PRIMARY KEY  (`imgset_id`),
  KEY `imgset_refid` (`imgset_refid`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mega_imgset`
--

LOCK TABLES `mega_imgset` WRITE;
/*!40000 ALTER TABLE `mega_imgset` DISABLE KEYS */;
INSERT INTO `mega_imgset` VALUES (1,'default',0);
/*!40000 ALTER TABLE `mega_imgset` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mega_imgset_tplset_link`
--

DROP TABLE IF EXISTS `mega_imgset_tplset_link`;
CREATE TABLE `mega_imgset_tplset_link` (
  `imgset_id` smallint(5) unsigned NOT NULL default '0',
  `tplset_name` varchar(50) NOT NULL default '',
  KEY `tplset_name` (`tplset_name`(10))
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mega_imgset_tplset_link`
--

LOCK TABLES `mega_imgset_tplset_link` WRITE;
/*!40000 ALTER TABLE `mega_imgset_tplset_link` DISABLE KEYS */;
INSERT INTO `mega_imgset_tplset_link` VALUES (1,'default');
/*!40000 ALTER TABLE `mega_imgset_tplset_link` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mega_imgsetimg`
--

DROP TABLE IF EXISTS `mega_imgsetimg`;
CREATE TABLE `mega_imgsetimg` (
  `imgsetimg_id` mediumint(8) unsigned NOT NULL auto_increment,
  `imgsetimg_file` varchar(50) NOT NULL default '',
  `imgsetimg_body` blob NOT NULL,
  `imgsetimg_imgset` smallint(5) unsigned NOT NULL default '0',
  PRIMARY KEY  (`imgsetimg_id`),
  KEY `imgsetimg_imgset` (`imgsetimg_imgset`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mega_imgsetimg`
--

LOCK TABLES `mega_imgsetimg` WRITE;
/*!40000 ALTER TABLE `mega_imgsetimg` DISABLE KEYS */;
/*!40000 ALTER TABLE `mega_imgsetimg` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mega_modules`
--

DROP TABLE IF EXISTS `mega_modules`;
CREATE TABLE `mega_modules` (
  `mid` smallint(5) unsigned NOT NULL auto_increment,
  `name` varchar(150) NOT NULL default '',
  `version` smallint(5) unsigned NOT NULL default '100',
  `last_update` int(10) unsigned NOT NULL default '0',
  `weight` smallint(3) unsigned NOT NULL default '0',
  `isactive` tinyint(1) unsigned NOT NULL default '0',
  `dirname` varchar(25) NOT NULL default '',
  `hasmain` tinyint(1) unsigned NOT NULL default '0',
  `hasadmin` tinyint(1) unsigned NOT NULL default '0',
  `hassearch` tinyint(1) unsigned NOT NULL default '0',
  `hasconfig` tinyint(1) unsigned NOT NULL default '0',
  `hascomments` tinyint(1) unsigned NOT NULL default '0',
  `hasnotification` tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (`mid`),
  KEY `hasmain` (`hasmain`),
  KEY `hasadmin` (`hasadmin`),
  KEY `hassearch` (`hassearch`),
  KEY `hasnotification` (`hasnotification`),
  KEY `dirname` (`dirname`),
  KEY `name` (`name`(15))
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mega_modules`
--

LOCK TABLES `mega_modules` WRITE;
/*!40000 ALTER TABLE `mega_modules` DISABLE KEYS */;
INSERT INTO `mega_modules` VALUES (1,'System',102,1208196917,0,1,'system',0,1,0,0,0,0);
/*!40000 ALTER TABLE `mega_modules` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mega_newblocks`
--

DROP TABLE IF EXISTS `mega_newblocks`;
CREATE TABLE `mega_newblocks` (
  `bid` mediumint(8) unsigned NOT NULL auto_increment,
  `mid` smallint(5) unsigned NOT NULL default '0',
  `func_num` tinyint(3) unsigned NOT NULL default '0',
  `options` varchar(255) NOT NULL default '',
  `name` varchar(150) NOT NULL default '',
  `title` varchar(255) NOT NULL default '',
  `content` text NOT NULL,
  `side` tinyint(1) unsigned NOT NULL default '0',
  `weight` smallint(5) unsigned NOT NULL default '0',
  `visible` tinyint(1) unsigned NOT NULL default '0',
  `block_type` char(1) NOT NULL default '',
  `c_type` char(1) NOT NULL default '',
  `isactive` tinyint(1) unsigned NOT NULL default '0',
  `dirname` varchar(50) NOT NULL default '',
  `func_file` varchar(50) NOT NULL default '',
  `show_func` varchar(50) NOT NULL default '',
  `edit_func` varchar(50) NOT NULL default '',
  `template` varchar(50) NOT NULL default '',
  `bcachetime` int(10) unsigned NOT NULL default '0',
  `last_modified` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`bid`),
  KEY `mid` (`mid`),
  KEY `visible` (`visible`),
  KEY `isactive_visible_mid` (`isactive`,`visible`,`mid`),
  KEY `mid_funcnum` (`mid`,`func_num`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mega_newblocks`
--

LOCK TABLES `mega_newblocks` WRITE;
/*!40000 ALTER TABLE `mega_newblocks` DISABLE KEYS */;
INSERT INTO `mega_newblocks` VALUES (1,1,1,'','User Menu','User Menu','',0,0,1,'S','H',1,'system','system_blocks.php','b_system_user_show','','system_block_user.html',0,1208196917),(2,1,2,'','Login','Login','',0,0,1,'S','H',1,'system','system_blocks.php','b_system_login_show','','system_block_login.html',0,1208196917),(3,1,3,'','Search','Search','',0,0,0,'S','H',1,'system','system_blocks.php','b_system_search_show','','system_block_search.html',0,1208196917),(4,1,4,'','Waiting Contents','Waiting Contents','',0,0,0,'S','H',1,'system','system_blocks.php','b_system_waiting_show','','system_block_waiting.html',0,1208196917),(5,1,5,'','Main Menu','Main Menu','',0,0,1,'S','H',1,'system','system_blocks.php','b_system_main_show','','system_block_mainmenu.html',0,1208196917),(6,1,6,'320|190|s_poweredby.gif|1','Site Info','Site Info','',0,0,0,'S','H',1,'system','system_blocks.php','b_system_info_show','b_system_info_edit','system_block_siteinfo.html',0,1208196917),(7,1,7,'','Who\'s Online','Who\'s Online','',0,0,0,'S','H',1,'system','system_blocks.php','b_system_online_show','','system_block_online.html',0,1208196917),(8,1,8,'10|1','Top Posters','Top Posters','',0,0,0,'S','H',1,'system','system_blocks.php','b_system_topposters_show','b_system_topposters_edit','system_block_topusers.html',0,1208196917),(9,1,9,'10|1','New Members','New Members','',0,0,0,'S','H',1,'system','system_blocks.php','b_system_newmembers_show','b_system_newmembers_edit','system_block_newusers.html',0,1208196917),(10,1,10,'10','Recent Comments','Recent Comments','',0,0,0,'S','H',1,'system','system_blocks.php','b_system_comments_show','b_system_comments_edit','system_block_comments.html',0,1208196917),(11,1,11,'','Notification Options','Notification Options','',0,0,0,'S','H',1,'system','system_blocks.php','b_system_notification_show','','system_block_notification.html',0,1208196917),(12,1,12,'0|80','Themes','Themes','',0,0,0,'S','H',1,'system','system_blocks.php','b_system_themes_show','b_system_themes_edit','system_block_themes.html',0,1208196917);
/*!40000 ALTER TABLE `mega_newblocks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mega_online`
--

DROP TABLE IF EXISTS `mega_online`;
CREATE TABLE `mega_online` (
  `online_uid` mediumint(8) unsigned NOT NULL default '0',
  `online_uname` varchar(25) NOT NULL default '',
  `online_updated` int(10) unsigned NOT NULL default '0',
  `online_module` smallint(5) unsigned NOT NULL default '0',
  `online_ip` varchar(15) NOT NULL default '',
  KEY `online_module` (`online_module`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mega_online`
--

LOCK TABLES `mega_online` WRITE;
/*!40000 ALTER TABLE `mega_online` DISABLE KEYS */;
/*!40000 ALTER TABLE `mega_online` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mega_priv_msgs`
--

DROP TABLE IF EXISTS `mega_priv_msgs`;
CREATE TABLE `mega_priv_msgs` (
  `msg_id` mediumint(8) unsigned NOT NULL auto_increment,
  `msg_image` varchar(100) default NULL,
  `subject` varchar(255) NOT NULL default '',
  `from_userid` mediumint(8) unsigned NOT NULL default '0',
  `to_userid` mediumint(8) unsigned NOT NULL default '0',
  `msg_time` int(10) unsigned NOT NULL default '0',
  `msg_text` text NOT NULL,
  `read_msg` tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (`msg_id`),
  KEY `to_userid` (`to_userid`),
  KEY `touseridreadmsg` (`to_userid`,`read_msg`),
  KEY `msgidfromuserid` (`msg_id`,`from_userid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mega_priv_msgs`
--

LOCK TABLES `mega_priv_msgs` WRITE;
/*!40000 ALTER TABLE `mega_priv_msgs` DISABLE KEYS */;
/*!40000 ALTER TABLE `mega_priv_msgs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mega_ranks`
--

DROP TABLE IF EXISTS `mega_ranks`;
CREATE TABLE `mega_ranks` (
  `rank_id` smallint(5) unsigned NOT NULL auto_increment,
  `rank_title` varchar(50) NOT NULL default '',
  `rank_min` mediumint(8) unsigned NOT NULL default '0',
  `rank_max` mediumint(8) unsigned NOT NULL default '0',
  `rank_special` tinyint(1) unsigned NOT NULL default '0',
  `rank_image` varchar(255) default NULL,
  PRIMARY KEY  (`rank_id`),
  KEY `rank_min` (`rank_min`),
  KEY `rank_max` (`rank_max`),
  KEY `rankminrankmaxranspecial` (`rank_min`,`rank_max`,`rank_special`),
  KEY `rankspecial` (`rank_special`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mega_ranks`
--

LOCK TABLES `mega_ranks` WRITE;
/*!40000 ALTER TABLE `mega_ranks` DISABLE KEYS */;
INSERT INTO `mega_ranks` VALUES (1,'Just popping in',0,20,0,'rank3e632f95e81ca.gif'),(2,'Not too shy to talk',21,40,0,'rank3dbf8e94a6f72.gif'),(3,'Quite a regular',41,70,0,'rank3dbf8e9e7d88d.gif'),(4,'Just can\'t stay away',71,150,0,'rank3dbf8ea81e642.gif'),(5,'Home away from home',151,10000,0,'rank3dbf8eb1a72e7.gif'),(6,'Moderator',0,0,1,'rank3dbf8edf15093.gif'),(7,'Webmaster',0,0,1,'rank3dbf8ee8681cd.gif');
/*!40000 ALTER TABLE `mega_ranks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mega_session`
--

DROP TABLE IF EXISTS `mega_session`;
CREATE TABLE `mega_session` (
  `sess_id` varchar(32) NOT NULL default '',
  `sess_updated` int(10) unsigned NOT NULL default '0',
  `sess_ip` varchar(15) NOT NULL default '',
  `sess_data` text NOT NULL,
  PRIMARY KEY  (`sess_id`),
  KEY `updated` (`sess_updated`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mega_session`
--

LOCK TABLES `mega_session` WRITE;
/*!40000 ALTER TABLE `mega_session` DISABLE KEYS */;
INSERT INTO `mega_session` VALUES ('66dc4ebbe47d5d0c759d599be9bc0c54',1208197378,'127.0.0.1','xoopsUserId|s:1:\"1\";xoopsUserGroups|a:2:{i:0;s:1:\"1\";i:1;s:1:\"2\";}xoopsUserTheme|s:7:\"default\";XOOPS_TOKEN_SESSION|a:1:{i:0;a:2:{s:2:\"id\";s:32:\"95dc2d7579ce92c0191a69f364384681\";s:6:\"expire\";i:1208197836;}}');
/*!40000 ALTER TABLE `mega_session` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mega_smiles`
--

DROP TABLE IF EXISTS `mega_smiles`;
CREATE TABLE `mega_smiles` (
  `id` smallint(5) unsigned NOT NULL auto_increment,
  `code` varchar(50) NOT NULL default '',
  `smile_url` varchar(100) NOT NULL default '',
  `emotion` varchar(75) NOT NULL default '',
  `display` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mega_smiles`
--

LOCK TABLES `mega_smiles` WRITE;
/*!40000 ALTER TABLE `mega_smiles` DISABLE KEYS */;
INSERT INTO `mega_smiles` VALUES (1,':-D','smil3dbd4d4e4c4f2.gif','Very Happy',1),(2,':-)','smil3dbd4d6422f04.gif','Smile',1),(3,':-(','smil3dbd4d75edb5e.gif','Sad',1),(4,':-o','smil3dbd4d8676346.gif','Surprised',1),(5,':-?','smil3dbd4d99c6eaa.gif','Confused',1),(6,'8-)','smil3dbd4daabd491.gif','Cool',1),(7,':lol:','smil3dbd4dbc14f3f.gif','Laughing',1),(8,':-x','smil3dbd4dcd7b9f4.gif','Mad',1),(9,':-P','smil3dbd4ddd6835f.gif','Razz',1),(10,':oops:','smil3dbd4df1944ee.gif','Embaressed',0),(11,':cry:','smil3dbd4e02c5440.gif','Crying (very sad)',0),(12,':evil:','smil3dbd4e1748cc9.gif','Evil or Very Mad',0),(13,':roll:','smil3dbd4e29bbcc7.gif','Rolling Eyes',0),(14,';-)','smil3dbd4e398ff7b.gif','Wink',0),(15,':pint:','smil3dbd4e4c2e742.gif','Another pint of beer',0),(16,':hammer:','smil3dbd4e5e7563a.gif','ToolTimes at work',0),(17,':idea:','smil3dbd4e7853679.gif','I have an idea',0);
/*!40000 ALTER TABLE `mega_smiles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mega_tplfile`
--

DROP TABLE IF EXISTS `mega_tplfile`;
CREATE TABLE `mega_tplfile` (
  `tpl_id` mediumint(7) unsigned NOT NULL auto_increment,
  `tpl_refid` smallint(5) unsigned NOT NULL default '0',
  `tpl_module` varchar(25) NOT NULL default '',
  `tpl_tplset` varchar(50) NOT NULL default '',
  `tpl_file` varchar(50) NOT NULL default '',
  `tpl_desc` varchar(255) NOT NULL default '',
  `tpl_lastmodified` int(10) unsigned NOT NULL default '0',
  `tpl_lastimported` int(10) unsigned NOT NULL default '0',
  `tpl_type` varchar(20) NOT NULL default '',
  PRIMARY KEY  (`tpl_id`),
  KEY `tpl_refid` (`tpl_refid`,`tpl_type`),
  KEY `tpl_tplset` (`tpl_tplset`,`tpl_file`(10))
) ENGINE=MyISAM AUTO_INCREMENT=28 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mega_tplfile`
--

LOCK TABLES `mega_tplfile` WRITE;
/*!40000 ALTER TABLE `mega_tplfile` DISABLE KEYS */;
INSERT INTO `mega_tplfile` VALUES (1,1,'system','default','system_imagemanager.html','',1208196917,1208196917,'module'),(2,1,'system','default','system_imagemanager2.html','',1208196917,1208196917,'module'),(3,1,'system','default','system_userinfo.html','',1208196917,1208196917,'module'),(4,1,'system','default','system_userform.html','',1208196917,1208196917,'module'),(5,1,'system','default','system_rss.html','',1208196917,1208196917,'module'),(6,1,'system','default','system_redirect.html','',1208196917,1208196917,'module'),(7,1,'system','default','system_comment.html','',1208196917,1208196917,'module'),(8,1,'system','default','system_comments_flat.html','',1208196917,1208196917,'module'),(9,1,'system','default','system_comments_thread.html','',1208196917,1208196917,'module'),(10,1,'system','default','system_comments_nest.html','',1208196917,1208196917,'module'),(11,1,'system','default','system_siteclosed.html','',1208196917,1208196917,'module'),(12,1,'system','default','system_dummy.html','Dummy template file for holding non-template contents. This should not be edited.',1208196917,1208196917,'module'),(13,1,'system','default','system_notification_list.html','',1208196917,1208196917,'module'),(14,1,'system','default','system_notification_select.html','',1208196917,1208196917,'module'),(15,1,'system','default','system_block_dummy.html','Dummy template for custom blocks or blocks without templates',1208196917,1208196917,'module'),(16,1,'system','default','system_block_user.html','Shows user block',1208196917,1208196917,'block'),(17,2,'system','default','system_block_login.html','Shows login form',1208196917,1208196917,'block'),(18,3,'system','default','system_block_search.html','Shows search form block',1208196917,1208196917,'block'),(19,4,'system','default','system_block_waiting.html','Shows contents waiting for approval',1208196917,1208196917,'block'),(20,5,'system','default','system_block_mainmenu.html','Shows the main navigation menu of the site',1208196917,1208196917,'block'),(21,6,'system','default','system_block_siteinfo.html','Shows basic info about the site and a link to Recommend Us pop up window',1208196917,1208196917,'block'),(22,7,'system','default','system_block_online.html','Displays users/guests currently online',1208196917,1208196917,'block'),(23,8,'system','default','system_block_topusers.html','Top posters',1208196917,1208196917,'block'),(24,9,'system','default','system_block_newusers.html','Shows most recent users',1208196917,1208196917,'block'),(25,10,'system','default','system_block_comments.html','Shows most recent comments',1208196917,1208196917,'block'),(26,11,'system','default','system_block_notification.html','Shows notification options',1208196917,1208196917,'block'),(27,12,'system','default','system_block_themes.html','Shows theme selection box',1208196917,1208196917,'block');
/*!40000 ALTER TABLE `mega_tplfile` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mega_tplset`
--

DROP TABLE IF EXISTS `mega_tplset`;
CREATE TABLE `mega_tplset` (
  `tplset_id` int(7) unsigned NOT NULL auto_increment,
  `tplset_name` varchar(50) NOT NULL default '',
  `tplset_desc` varchar(255) NOT NULL default '',
  `tplset_credits` text NOT NULL,
  `tplset_created` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`tplset_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mega_tplset`
--

LOCK TABLES `mega_tplset` WRITE;
/*!40000 ALTER TABLE `mega_tplset` DISABLE KEYS */;
INSERT INTO `mega_tplset` VALUES (1,'default','XOOPS Default Template Set','',1208196917);
/*!40000 ALTER TABLE `mega_tplset` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mega_tplsource`
--

DROP TABLE IF EXISTS `mega_tplsource`;
CREATE TABLE `mega_tplsource` (
  `tpl_id` mediumint(7) unsigned NOT NULL default '0',
  `tpl_source` mediumtext NOT NULL,
  KEY `tpl_id` (`tpl_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mega_tplsource`
--

LOCK TABLES `mega_tplsource` WRITE;
/*!40000 ALTER TABLE `mega_tplsource` DISABLE KEYS */;
INSERT INTO `mega_tplsource` VALUES (1,'<!DOCTYPE html PUBLIC \'-//W3C//DTD XHTML 1.0 Transitional//EN\' \'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\'>\r\n<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"<{$xoops_langcode}>\" lang=\"<{$xoops_langcode}>\">\r\n<head>\r\n<meta http-equiv=\"content-type\" content=\"text/html; charset=<{$xoops_charset}>\" />\r\n<meta http-equiv=\"content-language\" content=\"<{$xoops_langcode}>\" />\r\n<title><{$sitename}> <{$lang_imgmanager}></title>\r\n<script type=\"text/javascript\">\r\n<!--//\r\nfunction appendCode(addCode) {\r\n	var targetDom = window.opener.xoopsGetElementById(\'<{$target}>\');\r\n	if (targetDom.createTextRange && targetDom.caretPos){\r\n  		var caretPos = targetDom.caretPos;\r\n		caretPos.text = caretPos.text.charAt(caretPos.text.length - 1) \r\n== \' \' ? addCode + \' \' : addCode;  \r\n	} else if (targetDom.getSelection && targetDom.caretPos){\r\n		var caretPos = targetDom.caretPos;\r\n		caretPos.text = caretPos.text.charat(caretPos.text.length - 1)  \r\n== \' \' ? addCode + \' \' : addCode;\r\n	} else {\r\n		targetDom.value = targetDom.value + addCode;\r\n  	}\r\n	window.close();\r\n	return;\r\n}\r\n//-->\r\n</script>\r\n<style type=\"text/css\" media=\"all\">\r\nbody {margin: 0;}\r\nimg {border: 0;}\r\ntable {width: 100%; margin: 0;}\r\na:link {color: #3a76d6; font-weight: bold; background-color: transparent;}\r\na:visited {color: #9eb2d6; font-weight: bold; background-color: transparent;}\r\na:hover {color: #e18a00; background-color: transparent;}\r\ntable td {background-color: white; font-size: 12px; padding: 0; border-width: 0; vertical-align: top; font-family: Verdana, Arial, Helvetica, sans-serif;}\r\ntable#imagenav td {vertical-align: bottom; padding: 5px;}\r\ntable#imagemain td {border-right: 1px solid silver; border-bottom: 1px solid silver; padding: 5px; vertical-align: middle;}\r\ntable#imagemain th {border: 0; background-color: #2F5376; color:white; font-size: 12px; padding: 5px; vertical-align: top; text-align:center; font-family: Verdana, Arial, Helvetica, sans-serif;}\r\ntable#header td {width: 100%; background-color: #2F5376; vertical-align: middle;}\r\ntable#header td#headerbar {border-bottom: 1px solid silver; background-color: #dddddd;}\r\ndiv#pagenav {text-align:center;}\r\ndiv#footer {text-align:right; padding: 5px;}\r\n</style>\r\n</head>\r\n\r\n<body onload=\"window.resizeTo(<{$xsize}>, <{$ysize}>);\">\r\n  <table id=\"header\" cellspacing=\"0\">\r\n    <tr>\r\n      <td><a href=\"<{$xoops_url}>/\"><img src=\"<{$xoops_url}>/images/logo.gif\" width=\"150\" height=\"80\" alt=\"\" /></a></td><td> </td>\r\n    </tr>\r\n    <tr>\r\n      <td id=\"headerbar\" colspan=\"2\"> </td>\r\n    </tr>\r\n  </table>\r\n\r\n  <form action=\"imagemanager.php\" method=\"get\">\r\n    <table cellspacing=\"0\" id=\"imagenav\">\r\n      <tr>\r\n        <td>\r\n          <select name=\"cat_id\" onchange=\"location=\'<{$xoops_url}>/imagemanager.php?target=<{$target}>&cat_id=\'+this.options[this.selectedIndex].value\"><{$cat_options}></select> <input type=\"hidden\" name=\"target\" value=\"<{$target}>\" /><input type=\"submit\" value=\"<{$lang_go}>\" />\r\n        </td>\r\n\r\n        <{if $show_cat > 0}>\r\n        <td align=\"right\"><a href=\"<{$xoops_url}>/imagemanager.php?target=<{$target}>&op=upload&imgcat_id=<{$show_cat}>\"><{$lang_addimage}></a></td>\r\n        <{/if}>\r\n\r\n      </tr>\r\n    </table>\r\n  </form>\r\n\r\n  <{if $image_total > 0}>\r\n\r\n  <table cellspacing=\"0\" id=\"imagemain\">\r\n    <tr>\r\n      <th><{$lang_imagename}></th>\r\n      <th><{$lang_image}></th>\r\n      <th><{$lang_imagemime}></th>\r\n      <th><{$lang_align}></th>\r\n    </tr>\r\n\r\n    <{section name=i loop=$images}>\r\n    <tr align=\"center\">\r\n      <td><input type=\"hidden\" name=\"image_id[]\" value=\"<{$images[i].id}>\" /><{$images[i].nicename}></td>\r\n      <td><img src=\"<{$images[i].src}>\" alt=\"\" /></td>\r\n      <td><{$images[i].mimetype}></td>\r\n      <td><a href=\"#\" onclick=\"javascript:appendCode(\'<{$images[i].lxcode}>\');\"><img src=\"<{$xoops_url}>/images/alignleft.gif\" alt=\"Left\" /></a> <a href=\"#\" onclick=\"javascript:appendCode(\'<{$images[i].xcode}>\');\"><img src=\"<{$xoops_url}>/images/aligncenter.gif\" alt=\"Center\" /></a> <a href=\"#\" onclick=\"javascript:appendCode(\'<{$images[i].rxcode}>\');\"><img src=\"<{$xoops_url}>/images/alignright.gif\" alt=\"Right\" /></a></td>\r\n    </tr>\r\n    <{/section}>\r\n  </table>\r\n\r\n  <{/if}>\r\n\r\n  <div id=\"pagenav\"><{$pagenav}></div>\r\n\r\n  <div id=\"footer\">\r\n    <input value=\"<{$lang_close}>\" type=\"button\" onclick=\"javascript:window.close();\" />\r\n  </div>\r\n\r\n  </body>\r\n</html>'),(2,'<!DOCTYPE html PUBLIC \'-//W3C//DTD XHTML 1.0 Transitional//EN\' \'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\'>\r\n<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"<{$xoops_langcode}>\" lang=\"<{$xoops_langcode}>\">\r\n<head>\r\n<meta http-equiv=\"content-type\" content=\"text/html; charset=<{$xoops_charset}>\" />\r\n<meta http-equiv=\"content-language\" content=\"<{$xoops_langcode}>\" />\r\n<title><{$xoops_sitename}> <{$lang_imgmanager}></title>\r\n<{$image_form.javascript}>\r\n<style type=\"text/css\" media=\"all\">\r\nbody {margin: 0;}\r\nimg {border: 0;}\r\ntable {width: 100%; margin: 0;}\r\na:link {color: #3a76d6; font-weight: bold; background-color: transparent;}\r\na:visited {color: #9eb2d6; font-weight: bold; background-color: transparent;}\r\na:hover {color: #e18a00; background-color: transparent;}\r\ntable td {background-color: white; font-size: 12px; padding: 0; border-width: 0; vertical-align: top; font-family: Verdana, Arial, Helvetica, sans-serif;}\r\ntable#imagenav td {vertical-align: bottom; padding: 5px;}\r\ntd.body {padding: 5px; vertical-align: middle;}\r\ntd.caption {border: 0; background-color: #2F5376; color:white; font-size: 12px; padding: 5px; vertical-align: top; text-align:left; font-family: Verdana, Arial, Helvetica, sans-serif;}\r\ntable#imageform {border: 1px solid silver;}\r\ntable#header td {width: 100%; background-color: #2F5376; vertical-align: middle;}\r\ntable#header td#headerbar {border-bottom: 1px solid silver; background-color: #dddddd;}\r\ndiv#footer {text-align:right; padding: 5px;}\r\n</style>\r\n</head>\r\n\r\n<body onload=\"window.resizeTo(<{$xsize}>, <{$ysize}>);\">\r\n  <table id=\"header\" cellspacing=\"0\">\r\n    <tr>\r\n      <td><a href=\"<{$xoops_url}>/\"><img src=\"<{$xoops_url}>/images/logo.gif\" width=\"150\" height=\"80\" alt=\"\" /></a></td><td> </td>\r\n    </tr>\r\n    <tr>\r\n      <td id=\"headerbar\" colspan=\"2\"> </td>\r\n    </tr>\r\n  </table>\r\n\r\n  <table cellspacing=\"0\" id=\"imagenav\">\r\n    <tr>\r\n      <td align=\"left\"><a href=\"<{$xoops_url}>/imagemanager.php?target=<{$target}>&amp;cat_id=<{$show_cat}>\"><{$lang_imgmanager}></a></td>\r\n    </tr>\r\n  </table>\r\n\r\n  <form name=\"<{$image_form.name}>\" id=\"<{$image_form.name}>\" action=\"<{$image_form.action}>\" method=\"<{$image_form.method}>\" <{$image_form.extra}>>\r\n    <table id=\"imageform\" cellspacing=\"0\">\r\n    <!-- start of form elements loop -->\r\n    <{foreach item=element from=$image_form.elements}>\r\n      <{if $element.hidden != true}>\r\n      <tr valign=\"top\">\r\n        <td class=\"caption\"><{$element.caption}></td>\r\n        <td class=\"body\"><{$element.body}></td>\r\n      </tr>\r\n      <{else}>\r\n      <{$element.body}>\r\n      <{/if}>\r\n    <{/foreach}>\r\n    <!-- end of form elements loop -->\r\n    </table>\r\n  </form>\r\n\r\n\r\n  <div id=\"footer\">\r\n    <input value=\"<{$lang_close}>\" type=\"button\" onclick=\"javascript:window.close();\" />\r\n  </div>\r\n\r\n  </body>\r\n</html>'),(3,'<{if $user_ownpage == true}>\r\n\r\n<form name=\"usernav\" action=\"user.php\" method=\"post\">\r\n\r\n<br /><br />\r\n\r\n<table width=\"70%\" align=\"center\" border=\"0\">\r\n  <tr align=\"center\">\r\n    <td><input type=\"button\" value=\"<{$lang_editprofile}>\" onclick=\"location=\'edituser.php\'\" />\r\n    <input type=\"button\" value=\"<{$lang_avatar}>\" onclick=\"location=\'edituser.php?op=avatarform\'\" />\r\n    <input type=\"button\" value=\"<{$lang_inbox}>\" onclick=\"location=\'viewpmsg.php\'\" />\r\n\r\n    <{if $user_candelete == true}>\r\n    <input type=\"button\" value=\"<{$lang_deleteaccount}>\" onclick=\"location=\'user.php?op=delete\'\" />\r\n    <{/if}>\r\n\r\n    <input type=\"button\" value=\"<{$lang_logout}>\" onclick=\"location=\'user.php?op=logout\'\" /></td>\r\n  </tr>\r\n</table>\r\n</form>\r\n\r\n<br /><br />\r\n<{elseif $xoops_isadmin != false}>\r\n\r\n<br /><br />\r\n\r\n<table width=\"70%\" align=\"center\" border=\"0\">\r\n  <tr align=\"center\">\r\n    <td><input type=\"button\" value=\"<{$lang_editprofile}>\" onclick=\"location=\'<{$xoops_url}>/modules/system/admin.php?fct=users&uid=<{$user_uid}>&op=modifyUser\'\" />\r\n    <input type=\"button\" value=\"<{$lang_deleteaccount}>\" onclick=\"location=\'<{$xoops_url}>/modules/system/admin.php?fct=users&op=delUser&uid=<{$user_uid}>\'\" />\r\n  </tr>\r\n</table>\r\n\r\n<br /><br />\r\n<{/if}>\r\n\r\n<table width=\"100%\" border=\"0\" cellspacing=\"5\">\r\n  <tr valign=\"top\">\r\n    <td width=\"50%\">\r\n      <table class=\"outer\" cellpadding=\"4\" cellspacing=\"1\" width=\"100%\">\r\n        <tr>\r\n          <th colspan=\"2\" align=\"center\"><{$lang_allaboutuser}></th>\r\n        </tr>\r\n        <tr valign=\"top\">\r\n          <td class=\"head\"><{$lang_avatar}></td>\r\n          <td align=\"center\" class=\"even\"><img src=\"<{$user_avatarurl}>\" alt=\"Avatar\" /></td>\r\n        </tr>\r\n        <tr>\r\n          <td class=\"head\"><{$lang_realname}></td>\r\n          <td align=\"center\" class=\"odd\"><{$user_realname}></td>\r\n        </tr>\r\n        <tr>\r\n          <td class=\"head\"><{$lang_website}></td>\r\n          <td class=\"even\"><{$user_websiteurl}></td>\r\n        </tr>\r\n        <tr valign=\"top\">\r\n          <td class=\"head\"><{$lang_email}></td>\r\n          <td class=\"odd\"><{$user_email}></td>\r\n        </tr>\r\n	<tr valign=\"top\">\r\n          <td class=\"head\"><{$lang_privmsg}></td>\r\n          <td class=\"even\"><{$user_pmlink}></td>\r\n        </tr>\r\n        <tr valign=\"top\">\r\n          <td class=\"head\"><{$lang_icq}></td>\r\n          <td class=\"odd\"><{$user_icq}></td>\r\n        </tr>\r\n        <tr valign=\"top\">\r\n          <td class=\"head\"><{$lang_aim}></td>\r\n          <td class=\"even\"><{$user_aim}></td>\r\n        </tr>\r\n        <tr valign=\"top\">\r\n          <td class=\"head\"><{$lang_yim}></td>\r\n          <td class=\"odd\"><{$user_yim}></td>\r\n        </tr>\r\n        <tr valign=\"top\">\r\n          <td class=\"head\"><{$lang_msnm}></td>\r\n          <td class=\"even\"><{$user_msnm}></td>\r\n        </tr>\r\n        <tr valign=\"top\">\r\n          <td class=\"head\"><{$lang_location}></td>\r\n          <td class=\"odd\"><{$user_location}></td>\r\n        </tr>\r\n        <tr valign=\"top\">\r\n          <td class=\"head\"><{$lang_occupation}></td>\r\n          <td class=\"even\"><{$user_occupation}></td>\r\n        </tr>\r\n        <tr valign=\"top\">\r\n          <td class=\"head\"><{$lang_interest}></td>\r\n          <td class=\"odd\"><{$user_interest}></td>\r\n        </tr>\r\n        <tr valign=\"top\">\r\n          <td class=\"head\"><{$lang_extrainfo}></td>\r\n          <td class=\"even\"><{$user_extrainfo}></td>\r\n        </tr>\r\n      </table>\r\n    </td>\r\n    <td width=\"50%\">\r\n      <table class=\"outer\" cellpadding=\"4\" cellspacing=\"1\" width=\"100%\">\r\n        <tr valign=\"top\">\r\n          <th colspan=\"2\" align=\"center\"><{$lang_statistics}></th>\r\n        </tr>\r\n        <tr valign=\"top\">\r\n          <td class=\"head\"><{$lang_membersince}></td>\r\n          <td align=\"center\" class=\"even\"><{$user_joindate}></td>\r\n        </tr>\r\n        <tr valign=\"top\">\r\n          <td class=\"head\"><{$lang_rank}></td>\r\n          <td align=\"center\" class=\"odd\"><{$user_rankimage}><br /><{$user_ranktitle}></td>\r\n        </tr>\r\n        <tr valign=\"top\">\r\n          <td class=\"head\"><{$lang_posts}></td>\r\n          <td align=\"center\" class=\"even\"><{$user_posts}></td>\r\n        </tr>\r\n	<tr valign=\"top\">\r\n          <td class=\"head\"><{$lang_lastlogin}></td>\r\n          <td align=\"center\" class=\"odd\"><{$user_lastlogin}></td>\r\n        </tr>\r\n      </table>\r\n      <br />\r\n      <table class=\"outer\" cellpadding=\"4\" cellspacing=\"1\" width=\"100%\">\r\n        <tr valign=\"top\">\r\n          <th colspan=\"2\" align=\"center\"><{$lang_signature}></th>\r\n        </tr>\r\n        <tr valign=\"top\">\r\n          <td class=\"even\"><{$user_signature}></td>\r\n        </tr>\r\n      </table>\r\n    </td>\r\n  </tr>\r\n</table>\r\n\r\n<!-- start module search results loop -->\r\n<{foreach item=module from=$modules}>\r\n\r\n<p>\r\n<h4><{$module.name}></h4>\r\n\r\n  <!-- start results item loop -->\r\n  <{foreach item=result from=$module.results}>\r\n\r\n  <img src=\"<{$result.image}>\" alt=\"<{$module.name}>\" /><b><a href=\"<{$result.link}>\"><{$result.title}></a></b><br /><small>(<{$result.time}>)</small><br />\r\n\r\n  <{/foreach}>\r\n  <!-- end results item loop -->\r\n\r\n<{$module.showall_link}>\r\n</p>\r\n\r\n<{/foreach}>\r\n<!-- end module search results loop -->\r\n'),(4,'<fieldset style=\"padding: 10px;\">\r\n  <legend style=\"font-weight: bold;\"><{$lang_login}></legend>\r\n  <form action=\"user.php\" method=\"post\">\r\n    <{$lang_username}> <input type=\"text\" name=\"uname\" size=\"26\" maxlength=\"25\" value=\"<{$usercookie}>\" /><br />\r\n    <{$lang_password}> <input type=\"password\" name=\"pass\" size=\"21\" maxlength=\"32\" /><br />\r\n    <input type=\"hidden\" name=\"op\" value=\"login\" />\r\n    <input type=\"hidden\" name=\"xoops_redirect\" value=\"<{$redirect_page}>\" />\r\n    <input type=\"submit\" value=\"<{$lang_login}>\" />\r\n  </form>\r\n  <a name=\"lost\"></a>\r\n  <div><{$lang_notregister}><br /></div>\r\n</fieldset>\r\n\r\n<br />\r\n\r\n<fieldset style=\"padding: 10px;\">\r\n  <legend style=\"font-weight: bold;\"><{$lang_lostpassword}></legend>\r\n  <div><br /><{$lang_noproblem}></div>\r\n  <form action=\"lostpass.php\" method=\"post\">\r\n    <{$lang_youremail}> <input type=\"text\" name=\"email\" size=\"26\" maxlength=\"60\" />&nbsp;&nbsp;<input type=\"hidden\" name=\"op\" value=\"mailpasswd\" /><input type=\"hidden\" name=\"t\" value=\"<{$mailpasswd_token}>\" /><input type=\"submit\" value=\"<{$lang_sendpassword}>\" />\r\n  </form>\r\n</fieldset>'),(5,'<?xml version=\"1.0\" encoding=\"UTF-8\"?>\r\n<rss version=\"2.0\">\r\n  <channel>\r\n    <title><{$channel_title}></title>\r\n    <link><{$channel_link}></link>\r\n    <description><{$channel_desc}></description>\r\n    <lastBuildDate><{$channel_lastbuild}></lastBuildDate>\r\n    <docs>http://backend.userland.com/rss/</docs>\r\n    <generator><{$channel_generator}></generator>\r\n    <category><{$channel_category}></category>\r\n    <managingEditor><{$channel_editor}></managingEditor>\r\n    <webMaster><{$channel_webmaster}></webMaster>\r\n    <language><{$channel_language}></language>\r\n    <{if $image_url != \"\"}>\r\n    <image>\r\n      <title><{$channel_title}></title>\r\n      <url><{$image_url}></url>\r\n      <link><{$channel_link}></link>\r\n      <width><{$image_width}></width>\r\n      <height><{$image_height}></height>\r\n    </image>\r\n    <{/if}>\r\n    <{foreach item=item from=$items}>\r\n    <item>\r\n      <title><{$item.title}></title>\r\n      <link><{$item.link}></link>\r\n      <description><{$item.description}></description>\r\n      <pubDate><{$item.pubdate}></pubDate>\r\n      <guid><{$item.guid}></guid>\r\n    </item>\r\n    <{/foreach}>\r\n  </channel>\r\n</rss>'),(6,'<html>\r\n<head>\r\n<meta http-equiv=\"Content-Type\" content=\"text/html; charset=<{$xoops_charset}>\" />\r\n<meta http-equiv=\"Refresh\" content=\"<{$time}>; url=<{$url}>\" />\r\n<title><{$xoops_sitename}></title>\r\n<link rel=\"stylesheet\" type=\"text/css\" media=\"all\" href=\"<{$xoops_themecss}>\" />\r\n</head>\r\n<body>\r\n<div style=\"text-align:center; background-color: #EBEBEB; border-top: 1px solid #FFFFFF; border-left: 1px solid #FFFFFF; border-right: 1px solid #AAAAAA; border-bottom: 1px solid #AAAAAA; font-weight : bold;\">\r\n  <h4><{$message}></h4>\r\n  <p><{$lang_ifnotreload}></p>\r\n</div>\r\n<{if $xoops_logdump != \'\'}><div><{$xoops_logdump}></div><{/if}>\r\n</body>\r\n</html>\r\n'),(7,'<!-- start comment post -->\r\n        <tr>\r\n          <td class=\"head\"><a id=\"comment<{$comment.id}>\"></a> <{$comment.poster.uname}></td>\r\n          <td class=\"head\"><div class=\"comDate\"><span class=\"comDateCaption\"><{$lang_posted}>:</span> <{$comment.date_posted}>&nbsp;&nbsp;<span class=\"comDateCaption\"><{$lang_updated}>:</span> <{$comment.date_modified}></div></td>\r\n        </tr>\r\n        <tr>\r\n\r\n          <{if $comment.poster.id != 0}>\r\n\r\n          <td class=\"odd\"><div class=\"comUserRank\"><div class=\"comUserRankText\"><{$comment.poster.rank_title}></div><img class=\"comUserRankImg\" src=\"<{$xoops_upload_url}>/<{$comment.poster.rank_image}>\" alt=\"\" /></div><img class=\"comUserImg\" src=\"<{$xoops_upload_url}>/<{$comment.poster.avatar}>\" alt=\"\" /><div class=\"comUserStat\"><span class=\"comUserStatCaption\"><{$lang_joined}>:</span> <{$comment.poster.regdate}></div><div class=\"comUserStat\"><span class=\"comUserStatCaption\"><{$lang_from}>:</span> <{$comment.poster.from}></div><div class=\"comUserStat\"><span class=\"comUserStatCaption\"><{$lang_posts}>:</span> <{$comment.poster.postnum}></div><div class=\"comUserStatus\"><{$comment.poster.status}></div></td>\r\n\r\n          <{else}>\r\n\r\n          <td class=\"odd\"> </td>\r\n\r\n          <{/if}>\r\n\r\n          <td class=\"odd\">\r\n            <div class=\"comTitle\"><{$comment.image}><{$comment.title}></div><div class=\"comText\"><{$comment.text}></div>\r\n          </td>\r\n        </tr>\r\n        <tr>\r\n          <td class=\"even\"></td>\r\n\r\n          <{if $xoops_iscommentadmin == true}>\r\n\r\n          <td class=\"even\" align=\"right\">\r\n            <a href=\"<{$editcomment_link}>&amp;com_id=<{$comment.id}>\"><img src=\"<{$xoops_url}>/images/icons/edit.gif\" alt=\"<{$lang_edit}>\" /></a><a href=\"<{$deletecomment_link}>&amp;com_id=<{$comment.id}>\"><img src=\"<{$xoops_url}>/images/icons/delete.gif\" alt=\"<{$lang_delete}>\" /></a><a href=\"<{$replycomment_link}>&amp;com_id=<{$comment.id}>\"><img src=\"<{$xoops_url}>/images/icons/reply.gif\" alt=\"<{$lang_reply}>\" /></a>\r\n          </td>\r\n\r\n          <{elseif $xoops_isuser == true && $xoops_userid == $comment.poster.id}>\r\n\r\n          <td class=\"even\" align=\"right\">\r\n            <a href=\"<{$editcomment_link}>&amp;com_id=<{$comment.id}>\"><img src=\"<{$xoops_url}>/images/icons/edit.gif\" alt=\"<{$lang_edit}>\" /></a><a href=\"<{$replycomment_link}>&amp;com_id=<{$comment.id}>\"><img src=\"<{$xoops_url}>/images/icons/reply.gif\" alt=\"<{$lang_reply}>\" /></a>\r\n          </td>\r\n\r\n          <{elseif $xoops_isuser == true || $anon_canpost == true}>\r\n\r\n          <td class=\"even\" align=\"right\">\r\n            <a href=\"<{$replycomment_link}>&amp;com_id=<{$comment.id}>\"><img src=\"<{$xoops_url}>/images/icons/reply.gif\" alt=\"<{$lang_reply}>\" /></a>\r\n          </td>\r\n\r\n          <{else}>\r\n\r\n          <td class=\"even\"> </td>\r\n\r\n          <{/if}>\r\n\r\n        </tr>\r\n<!-- end comment post -->'),(8,'<table class=\"outer\" cellpadding=\"5\" cellspacing=\"1\">\r\n  <tr>\r\n    <th width=\"20%\"><{$lang_poster}></th>\r\n    <th><{$lang_thread}></th>\r\n  </tr>\r\n  <{foreach item=comment from=$comments}>\r\n    <{include file=\"db:system_comment.html\" comment=$comment}>\r\n  <{/foreach}>\r\n</table>'),(9,'<{section name=i loop=$comments}>\r\n<br />\r\n<table cellspacing=\"1\" class=\"outer\">\r\n  <tr>\r\n    <th width=\"20%\"><{$lang_poster}></th>\r\n    <th><{$lang_thread}></th>\r\n  </tr>\r\n  <{include file=\"db:system_comment.html\" comment=$comments[i]}>\r\n</table>\r\n\r\n<{if $show_threadnav == true}>\r\n<div style=\"text-align:left; margin:3px; padding: 5px;\">\r\n<a href=\"<{$comment_url}>\"><{$lang_top}></a> | <a href=\"<{$comment_url}>&amp;com_id=<{$comments[i].pid}>&amp;com_rootid=<{$comments[i].rootid}>#newscomment<{$comments[i].pid}>\"><{$lang_parent}></a>\r\n</div>\r\n<{/if}>\r\n\r\n<{if $comments[i].show_replies == true}>\r\n<!-- start comment tree -->\r\n<br />\r\n<table cellspacing=\"1\" class=\"outer\">\r\n  <tr>\r\n    <th width=\"50%\"><{$lang_subject}></th>\r\n    <th width=\"20%\" align=\"center\"><{$lang_poster}></th>\r\n    <th align=\"right\"><{$lang_posted}></th>\r\n  </tr>\r\n  <{foreach item=reply from=$comments[i].replies}>\r\n  <tr>\r\n    <td class=\"even\"><{$reply.prefix}> <a href=\"<{$comment_url}>&amp;com_id=<{$reply.id}>&amp;com_rootid=<{$reply.root_id}>\"><{$reply.title}></a></td>\r\n    <td class=\"odd\" align=\"center\"><{$reply.poster.uname}></td>\r\n    <td class=\"even\" align=\"right\"><{$reply.date_posted}></td>\r\n  </tr>\r\n  <{/foreach}>\r\n</table>\r\n<!-- end comment tree -->\r\n<{/if}>\r\n\r\n<{/section}>'),(10,'<{section name=i loop=$comments}>\r\n<br />\r\n<table cellspacing=\"1\" class=\"outer\">\r\n  <tr>\r\n    <th width=\"20%\"><{$lang_poster}></th>\r\n    <th><{$lang_thread}></th>\r\n  </tr>\r\n  <{include file=\"db:system_comment.html\" comment=$comments[i]}>\r\n</table>\r\n\r\n<!-- start comment replies -->\r\n<{foreach item=reply from=$comments[i].replies}>\r\n<br />\r\n<table cellspacing=\"0\" border=\"0\">\r\n  <tr>\r\n    <td width=\"<{$reply.prefix}>\"></td>\r\n    <td>\r\n      <table class=\"outer\" cellspacing=\"1\">\r\n        <tr>\r\n          <th width=\"20%\"><{$lang_poster}></th>\r\n          <th><{$lang_thread}></th>\r\n        </tr>\r\n        <{include file=\"db:system_comment.html\" comment=$reply}>\r\n      </table>\r\n    </td>\r\n  </tr>\r\n</table>\r\n<{/foreach}>\r\n<!-- end comment tree -->\r\n<{/section}>'),(11,'<!DOCTYPE html PUBLIC \'-//W3C//DTD XHTML 1.0 Transitional//EN\' \'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\'>\r\n<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"<{$xoops_langcode}>\" lang=\"<{$xoops_langcode}>\">\r\n<head>\r\n<meta http-equiv=\"content-type\" content=\"text/html; charset=<{$xoops_charset}>\" />\r\n<meta http-equiv=\"content-language\" content=\"<{$xoops_langcode}>\" />\r\n<title><{$xoops_sitename}></title>\r\n<link rel=\"stylesheet\" type=\"text/css\" media=\"all\" href=\"<{$xoops_url}>/xoops.css\" />\r\n\r\n</head>\r\n<body>\r\n  <table cellspacing=\"0\">\r\n    <tr id=\"header\">\r\n      <td style=\"width: 150px; background-color: #2F5376; vertical-align: middle; text-align:center;\"><a href=\"<{$xoops_url}>/\"><img src=\"<{$xoops_imageurl}>logo.gif\" width=\"150\" alt=\"\" /></a></td>\r\n      <td style=\"width: 100%; background-color: #2F5376; vertical-align: middle; text-align:center;\">&nbsp;</td>\r\n    </tr>\r\n    <tr>\r\n      <td style=\"height: 8px; border-bottom: 1px solid silver; background-color: #dddddd;\" colspan=\"2\">&nbsp;</td>\r\n    </tr>\r\n  </table>\r\n\r\n  <table cellspacing=\"1\" align=\"center\" width=\"80%\" border=\"0\" cellpadding=\"10px;\">\r\n    <tr>\r\n      <td align=\"center\"><div style=\"background-color: #DDFFDF; color: #136C99; text-align: center; border-top: 1px solid #DDDDFF; border-left: 1px solid #DDDDFF; border-right: 1px solid #AAAAAA; border-bottom: 1px solid #AAAAAA; font-weight: bold; padding: 10px;\"><{$lang_siteclosemsg}></div></td>\r\n    </tr>\r\n  </table>\r\n  \r\n  <form action=\"<{$xoops_url}>/user.php\" method=\"post\">\r\n    <table cellspacing=\"0\" align=\"center\" style=\"border: 1px solid silver; width: 200px;\">\r\n      <tr>\r\n        <th style=\"background-color: #2F5376; color: #FFFFFF; padding : 2px; vertical-align : middle;\" colspan=\"2\"><{$lang_login}></th>\r\n      </tr>\r\n      <tr>\r\n        <td style=\"padding: 2px;\"><{$lang_username}></td><td style=\"padding: 2px;\"><input type=\"text\" name=\"uname\" size=\"12\" value=\"\" /></td>\r\n      </tr>\r\n      <tr>\r\n        <td style=\"padding: 2px;\"><{$lang_password}></td><td style=\"padding: 2px;\"><input type=\"password\" name=\"pass\" size=\"12\" /></td>\r\n      </tr>\r\n      <tr>\r\n        <td style=\"padding: 2px;\">&nbsp;</td>\r\n        <td style=\"padding: 2px;\">\r\n        	<input type=\"hidden\" name=\"xoops_redirect\" value=\"<{$xoops_requesturi}>\" />\r\n        	<input type=\"hidden\" name=\"xoops_login\" value=\"1\" />\r\n        	<input type=\"submit\" value=\"<{$lang_login}>\" /></td>\r\n      </tr>\r\n    </table>\r\n  </form>\r\n\r\n  <table cellspacing=\"0\" width=\"100%\">\r\n    <tr>\r\n      <td style=\"height:8px; border-bottom: 1px solid silver; border-top: 1px solid silver; background-color: #dddddd;\" colspan=\"2\">&nbsp;</td>\r\n    </tr>\r\n  </table>\r\n\r\n  </body>\r\n</html>'),(12,'<{$dummy_content}>'),(13,'<h4><{$lang_activenotifications}></h4>\r\n<form name=\"notificationlist\" action=\"notifications.php\" method=\"post\">\r\n<table class=\"outer\">\r\n  <tr>\r\n	<th><input name=\"allbox\" id=\"allbox\" onclick=\"xoopsCheckAll(\'notificationlist\', \'allbox\');\" type=\"checkbox\" value=\"<{$lang_checkall}>\" /></th>\r\n    <th><{$lang_event}></th>\r\n    <th><{$lang_category}></th>\r\n    <th><{$lang_itemid}></th>\r\n    <th><{$lang_itemname}></th>\r\n  </tr>\r\n  <{foreach item=module from=$modules}>\r\n  <tr>\r\n    <td class=\"head\"><input name=\"del_mod[<{$module.id}>]\" id=\"del_mod[]\" onclick=\"xoopsCheckGroup(\'notificationlist\', \'del_mod[<{$module.id}>]\', \'del_not[<{$module.id}>][]\');\" type=\"checkbox\" value=\"<{$module.id}>\" /></td>\r\n    <td class=\"head\" colspan=\"4\"><{$lang_module}>: <{$module.name}></td>\r\n  </tr>\r\n  <{foreach item=category from=$module.categories}>\r\n  <{foreach item=item from=$category.items}>\r\n  <{foreach item=notification from=$item.notifications}>\r\n  <tr>\r\n    <{cycle values=odd,even assign=class}>\r\n    <td class=\"<{$class}>\"><input type=\"checkbox\" name=\"del_not[<{$module.id}>][]\" id=\"del_not[<{$module.id}>][]\" value=\"<{$notification.id}>\" /></td>\r\n    <td class=\"<{$class}>\"><{$notification.event_title}></td>\r\n    <td class=\"<{$class}>\"><{$notification.category_title}></td>\r\n    <td class=\"<{$class}>\"><{if $item.id != 0}><{$item.id}><{/if}></td>\r\n    <td class=\"<{$class}>\"><{if $item.id != 0}><{if $item.url != \'\'}><a href=\"<{$item.url}>\"><{/if}><{$item.name}><{if $item.url != \'\'}></a><{/if}><{/if}></td>\r\n  </tr>\r\n  <{/foreach}>\r\n  <{/foreach}>\r\n  <{/foreach}>\r\n  <{/foreach}>\r\n  <tr>\r\n    <td class=\"foot\" colspan=\"5\">\r\n      <input type=\"submit\" name=\"delete_cancel\" value=\"<{$lang_cancel}>\" />\r\n      <input type=\"reset\" name=\"delete_reset\" value=\"<{$lang_clear}>\" />\r\n      <input type=\"submit\" name=\"delete\" value=\"<{$lang_delete}>\" />\r\n      <input type=\"hidden\" name=\"XOOPS_TOKEN_REQUEST\" value=\"<{$notification_token}>\" />\r\n    </td>\r\n  </tr>\r\n</table>\r\n</form>\r\n'),(14,'<{if $xoops_notification.show}>\r\n<form name=\"notification_select\" action=\"<{$xoops_notification.target_page}>\" method=\"post\">\r\n<h4 style=\"text-align:center;\"><{$lang_activenotifications}></h4>\r\n<input type=\"hidden\" name=\"not_redirect\" value=\"<{$xoops_notification.redirect_script}>\" />\r\n<input type=\"hidden\" name=\"XOOPS_TOKEN_REQUEST\" value=\"<{php}>echo $GLOBALS[\'xoopsSecurity\']->createToken();<{/php}>\" />\r\n<table class=\"outer\">\r\n  <tr><th colspan=\"3\"><{$lang_notificationoptions}></th></tr>\r\n  <tr>\r\n    <td class=\"head\"><{$lang_category}></td>\r\n    <td class=\"head\"><input name=\"allbox\" id=\"allbox\" onclick=\"xoopsCheckAll(\'notification_select\',\'allbox\');\" type=\"checkbox\" value=\"<{$lang_checkall}>\" /></td>\r\n    <td class=\"head\"><{$lang_events}></td>\r\n  </tr>\r\n  <{foreach name=outer item=category from=$xoops_notification.categories}>\r\n  <{foreach name=inner item=event from=$category.events}>\r\n  <tr>\r\n    <{if $smarty.foreach.inner.first}>\r\n    <td class=\"even\" rowspan=\"<{$smarty.foreach.inner.total}>\"><{$category.title}></td>\r\n    <{/if}>\r\n    <td class=\"odd\">\r\n    <{counter assign=index}>\r\n    <input type=\"hidden\" name=\"not_list[<{$index}>][params]\" value=\"<{$category.name}>,<{$category.itemid}>,<{$event.name}>\" />\r\n    <input type=\"checkbox\" id=\"not_list[]\" name=\"not_list[<{$index}>][status]\" value=\"1\" <{if $event.subscribed}>checked=\"checked\"<{/if}> />\r\n    </td>\r\n    <td class=\"odd\"><{$event.caption}></td>\r\n  </tr>\r\n  <{/foreach}>\r\n  <{/foreach}>\r\n  <tr>\r\n    <td class=\"foot\" colspan=\"3\" align=\"center\"><input type=\"submit\" name=\"not_submit\" value=\"<{$lang_updatenow}>\" /></td>\r\n  </tr>\r\n</table>\r\n<div align=\"center\">\r\n<{$lang_notificationmethodis}>:&nbsp;<{$user_method}>&nbsp;&nbsp;[<a href=\"<{$editprofile_url}>\"><{$lang_change}></a>]\r\n</div>\r\n</form>\r\n<{/if}>'),(15,'<{$block.content}>'),(16,'<table cellspacing=\"0\">\r\n  <tr>\r\n    <td id=\"usermenu\">\r\n      <{if $xoops_isadmin}>\r\n        <a class=\"menuTop\" href=\"<{$xoops_url}>/admin.php\"><{$block.lang_adminmenu}></a>\r\n	    <a href=\"<{$xoops_url}>/user.php\"><{$block.lang_youraccount}></a>\r\n      <{else}>\r\n		<a class=\"menuTop\" href=\"<{$xoops_url}>/user.php\"><{$block.lang_youraccount}></a>\r\n      <{/if}>\r\n      <a href=\"<{$xoops_url}>/edituser.php\"><{$block.lang_editaccount}></a>\r\n      <a href=\"<{$xoops_url}>/notifications.php\"><{$block.lang_notifications}></a>\r\n      <{if $block.new_messages > 0}>\r\n        <a class=\"highlight\" href=\"<{$xoops_url}>/viewpmsg.php\"><{$block.lang_inbox}> (<span style=\"color:#ff0000; font-weight: bold;\"><{$block.new_messages}></span>)</a>\r\n      <{else}>\r\n        <a href=\"<{$xoops_url}>/viewpmsg.php\"><{$block.lang_inbox}></a>\r\n      <{/if}>\r\n      <a href=\"<{$xoops_url}>/user.php?op=logout\"><{$block.lang_logout}></a>\r\n    </td>\r\n  </tr>\r\n</table>\r\n'),(17,'<form style=\"margin-top: 0px;\" action=\"<{$xoops_url}>/user.php\" method=\"post\">\r\n    <{$block.lang_username}><br />\r\n    <input type=\"text\" name=\"uname\" size=\"12\" value=\"<{$block.unamevalue}>\" maxlength=\"25\" /><br />\r\n    <{$block.lang_password}><br />\r\n    <input type=\"password\" name=\"pass\" size=\"12\" maxlength=\"32\" /><br />\r\n    <!-- <input type=\"checkbox\" name=\"rememberme\" value=\"On\" class =\"formButton\" /><{$block.lang_rememberme}><br /> //-->\r\n    <input type=\"hidden\" name=\"xoops_redirect\" value=\"<{$xoops_requesturi}>\" />\r\n    <input type=\"hidden\" name=\"op\" value=\"login\" />\r\n    <input type=\"submit\" value=\"<{$block.lang_login}>\" /><br />\r\n    <{$block.sslloginlink}>\r\n</form>\r\n<a href=\"<{$xoops_url}>/user.php#lost\"><{$block.lang_lostpass}></a>\r\n<br /><br />\r\n<a href=\"<{$xoops_url}>/register.php\"><{$block.lang_registernow}></a>'),(18,'<form style=\"margin-top: 0px;\" action=\"<{$xoops_url}>/search.php\" method=\"get\">\r\n  <input type=\"text\" name=\"query\" size=\"14\" /><input type=\"hidden\" name=\"action\" value=\"results\" /><br /><input type=\"submit\" value=\"<{$block.lang_search}>\" />\r\n</form>\r\n<a href=\"<{$xoops_url}>/search.php\"><{$block.lang_advsearch}></a>'),(19,'<ul>\r\n  <{foreach item=module from=$block.modules}>\r\n  <li><a href=\"<{$module.adminlink}>\"><{$module.lang_linkname}></a>: <{$module.pendingnum}></li>\r\n  <{/foreach}>\r\n</ul>'),(20,'<table cellspacing=\"0\">\r\n  <tr>\r\n    <td id=\"mainmenu\">\r\n      <a class=\"menuTop\" href=\"<{$xoops_url}>/\"><{$block.lang_home}></a>\r\n      <!-- start module menu loop -->\r\n      <{foreach item=module from=$block.modules}>\r\n      <a class=\"menuMain\" href=\"<{$xoops_url}>/modules/<{$module.directory}>/\"><{$module.name}></a>\r\n        <{foreach item=sublink from=$module.sublinks}>\r\n          <a class=\"menuSub\" href=\"<{$sublink.url}>\"><{$sublink.name}></a>\r\n        <{/foreach}>\r\n      <{/foreach}>\r\n      <!-- end module menu loop -->\r\n    </td>\r\n  </tr>\r\n</table>'),(21,'<table class=\"outer\" cellspacing=\"0\">\r\n\r\n  <{if $block.showgroups == true}>\r\n\r\n  <!-- start group loop -->\r\n  <{foreach item=group from=$block.groups}>\r\n  <tr>\r\n    <th colspan=\"2\"><{$group.name}></th>\r\n  </tr>\r\n\r\n  <!-- start group member loop -->\r\n  <{foreach item=user from=$group.users}>\r\n  <tr>\r\n    <td class=\"even\" valign=\"middle\" align=\"center\"><img src=\"<{$user.avatar}>\" alt=\"\" width=\"32\" /><br /><a href=\"<{$xoops_url}>/userinfo.php?uid=<{$user.id}>\"><{$user.name}></a></td><td class=\"odd\" width=\"20%\" align=\"right\" valign=\"middle\"><{$user.msglink}></td>\r\n  </tr>\r\n  <{/foreach}>\r\n  <!-- end group member loop -->\r\n\r\n  <{/foreach}>\r\n  <!-- end group loop -->\r\n  <{/if}>\r\n</table>\r\n\r\n<br />\r\n\r\n<div style=\"margin: 3px; text-align:center;\">\r\n  <img src=\"<{$block.logourl}>\" alt=\"\" border=\"0\" /><br /><{$block.recommendlink}>\r\n</div>'),(22,'<{$block.online_total}><br /><br /><{$block.lang_members}>: <{$block.online_members}><br /><{$block.lang_guests}>: <{$block.online_guests}><br /><br /><{$block.online_names}> <a href=\"javascript:openWithSelfMain(\'<{$xoops_url}>/misc.php?action=showpopups&amp;type=online\',\'Online\',420,350);\"><{$block.lang_more}></a>'),(23,'<table cellspacing=\"1\" class=\"outer\">\r\n  <{foreach item=user from=$block.users}>\r\n  <tr class=\"<{cycle values=\"even,odd\"}>\" valign=\"middle\">\r\n    <td><{$user.rank}></td>\r\n    <td align=\"center\">\r\n      <{if $user.avatar != \"\"}>\r\n      <img src=\"<{$user.avatar}>\" alt=\"\" width=\"32\" /><br />\r\n      <{/if}>\r\n      <a href=\"<{$xoops_url}>/userinfo.php?uid=<{$user.id}>\"><{$user.name}></a>\r\n    </td>\r\n    <td align=\"center\"><{$user.posts}></td>\r\n  </tr>\r\n  <{/foreach}>\r\n</table>\r\n'),(24,'<table cellspacing=\"1\" class=\"outer\">\r\n  <{foreach item=user from=$block.users}>\r\n    <tr class=\"<{cycle values=\"even,odd\"}>\" valign=\"middle\">\r\n      <td align=\"center\">\r\n      <{if $user.avatar != \"\"}>\r\n      <img src=\"<{$user.avatar}>\" alt=\"\" width=\"32\" /><br />\r\n      <{/if}>\r\n      <a href=\"<{$xoops_url}>/userinfo.php?uid=<{$user.id}>\"><{$user.name}></a>\r\n      </td>\r\n      <td align=\"center\"><{$user.joindate}></td>\r\n    </tr>\r\n  <{/foreach}>\r\n</table>\r\n'),(25,'<table width=\"100%\" cellspacing=\"1\" class=\"outer\">\r\n  <{foreach item=comment from=$block.comments}>\r\n  <tr class=\"<{cycle values=\"even,odd\"}>\">\r\n    <td align=\"center\"><img src=\"<{$xoops_url}>/images/subject/<{$comment.icon}>\" alt=\"\" /></td>\r\n    <td><{$comment.title}></td>\r\n    <td align=\"center\"><{$comment.module}></td>\r\n    <td align=\"center\"><{$comment.poster}></td>\r\n    <td align=\"right\"><{$comment.time}></td>\r\n  </tr>\r\n  <{/foreach}>\r\n</table>'),(26,'<form action=\"<{$block.target_page}>\" method=\"post\">\r\n<table class=\"outer\">\r\n  <{foreach item=category from=$block.categories}>\r\n  <{foreach name=inner item=event from=$category.events}>\r\n  <{if $smarty.foreach.inner.first}>\r\n  <tr>\r\n    <td class=\"head\" colspan=\"2\"><{$category.title}></td>\r\n  </tr>\r\n  <{/if}>\r\n  <tr>\r\n    <td class=\"odd\"><{counter assign=index}><input type=\"hidden\" name=\"not_list[<{$index}>][params]\" value=\"<{$category.name}>,<{$category.itemid}>,<{$event.name}>\" /><input type=\"checkbox\" name=\"not_list[<{$index}>][status]\" value=\"1\" <{if $event.subscribed}>checked=\"checked\"<{/if}> /></td>\r\n    <td class=\"odd\"><{$event.caption}></td>\r\n  </tr>\r\n  <{/foreach}>\r\n  <{/foreach}>\r\n  <tr>\r\n    <td class=\"foot\" colspan=\"2\"><input type=\"hidden\" name=\"not_redirect\" value=\"<{$block.redirect_script}>\"><input type=\"hidden\" value=\"<{$block.notification_token}>\" name=\"XOOPS_TOKEN_REQUEST\" /><input type=\"submit\" name=\"not_submit\" value=\"<{$block.submit_button}>\" /></td>\r\n  </tr>\r\n</table>\r\n</form>'),(27,'<div style=\"text-align: center;\">\r\n<form action=\"index.php\" method=\"post\">\r\n<{$block.theme_select}>\r\n</form>\r\n</div>');
/*!40000 ALTER TABLE `mega_tplsource` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mega_users`
--

DROP TABLE IF EXISTS `mega_users`;
CREATE TABLE `mega_users` (
  `uid` mediumint(8) unsigned NOT NULL auto_increment,
  `name` varchar(60) NOT NULL default '',
  `uname` varchar(25) NOT NULL default '',
  `email` varchar(60) NOT NULL default '',
  `url` varchar(100) NOT NULL default '',
  `user_avatar` varchar(30) NOT NULL default 'blank.gif',
  `user_regdate` int(10) unsigned NOT NULL default '0',
  `user_icq` varchar(15) NOT NULL default '',
  `user_from` varchar(100) NOT NULL default '',
  `user_sig` tinytext NOT NULL,
  `user_viewemail` tinyint(1) unsigned NOT NULL default '0',
  `actkey` varchar(8) NOT NULL default '',
  `user_aim` varchar(18) NOT NULL default '',
  `user_yim` varchar(25) NOT NULL default '',
  `user_msnm` varchar(100) NOT NULL default '',
  `pass` varchar(32) NOT NULL default '',
  `posts` mediumint(8) unsigned NOT NULL default '0',
  `attachsig` tinyint(1) unsigned NOT NULL default '0',
  `rank` smallint(5) unsigned NOT NULL default '0',
  `level` tinyint(3) unsigned NOT NULL default '1',
  `theme` varchar(100) NOT NULL default '',
  `timezone_offset` float(3,1) NOT NULL default '0.0',
  `last_login` int(10) unsigned NOT NULL default '0',
  `umode` varchar(10) NOT NULL default '',
  `uorder` tinyint(1) unsigned NOT NULL default '0',
  `notify_method` tinyint(1) NOT NULL default '1',
  `notify_mode` tinyint(1) NOT NULL default '0',
  `user_occ` varchar(100) NOT NULL default '',
  `bio` tinytext NOT NULL,
  `user_intrest` varchar(150) NOT NULL default '',
  `user_mailok` tinyint(1) unsigned NOT NULL default '1',
  PRIMARY KEY  (`uid`),
  KEY `uname` (`uname`),
  KEY `email` (`email`),
  KEY `uiduname` (`uid`,`uname`),
  KEY `unamepass` (`uname`,`pass`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mega_users`
--

LOCK TABLES `mega_users` WRITE;
/*!40000 ALTER TABLE `mega_users` DISABLE KEYS */;
INSERT INTO `mega_users` VALUES (1,'','admin','admin@simit.com.my','http://localhost/simbill/','blank.gif',1208196917,'','','',1,'','','','','21232f297a57a5a743894a0e4a801fc3',0,0,7,5,'default',0.0,1208196932,'thread',0,1,0,'','','',0);
/*!40000 ALTER TABLE `mega_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mega_xoopscomments`
--

DROP TABLE IF EXISTS `mega_xoopscomments`;
CREATE TABLE `mega_xoopscomments` (
  `com_id` mediumint(8) unsigned NOT NULL auto_increment,
  `com_pid` mediumint(8) unsigned NOT NULL default '0',
  `com_rootid` mediumint(8) unsigned NOT NULL default '0',
  `com_modid` smallint(5) unsigned NOT NULL default '0',
  `com_itemid` mediumint(8) unsigned NOT NULL default '0',
  `com_icon` varchar(25) NOT NULL default '',
  `com_created` int(10) unsigned NOT NULL default '0',
  `com_modified` int(10) unsigned NOT NULL default '0',
  `com_uid` mediumint(8) unsigned NOT NULL default '0',
  `com_ip` varchar(15) NOT NULL default '',
  `com_title` varchar(255) NOT NULL default '',
  `com_text` text NOT NULL,
  `com_sig` tinyint(1) unsigned NOT NULL default '0',
  `com_status` tinyint(1) unsigned NOT NULL default '0',
  `com_exparams` varchar(255) NOT NULL default '',
  `dohtml` tinyint(1) unsigned NOT NULL default '0',
  `dosmiley` tinyint(1) unsigned NOT NULL default '0',
  `doxcode` tinyint(1) unsigned NOT NULL default '0',
  `doimage` tinyint(1) unsigned NOT NULL default '0',
  `dobr` tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (`com_id`),
  KEY `com_pid` (`com_pid`),
  KEY `com_itemid` (`com_itemid`),
  KEY `com_uid` (`com_uid`),
  KEY `com_title` (`com_title`(40))
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mega_xoopscomments`
--

LOCK TABLES `mega_xoopscomments` WRITE;
/*!40000 ALTER TABLE `mega_xoopscomments` DISABLE KEYS */;
/*!40000 ALTER TABLE `mega_xoopscomments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mega_xoopsnotifications`
--

DROP TABLE IF EXISTS `mega_xoopsnotifications`;
CREATE TABLE `mega_xoopsnotifications` (
  `not_id` mediumint(8) unsigned NOT NULL auto_increment,
  `not_modid` smallint(5) unsigned NOT NULL default '0',
  `not_itemid` mediumint(8) unsigned NOT NULL default '0',
  `not_category` varchar(30) NOT NULL default '',
  `not_event` varchar(30) NOT NULL default '',
  `not_uid` mediumint(8) unsigned NOT NULL default '0',
  `not_mode` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`not_id`),
  KEY `not_modid` (`not_modid`),
  KEY `not_itemid` (`not_itemid`),
  KEY `not_class` (`not_category`),
  KEY `not_uid` (`not_uid`),
  KEY `not_event` (`not_event`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mega_xoopsnotifications`
--

LOCK TABLES `mega_xoopsnotifications` WRITE;
/*!40000 ALTER TABLE `mega_xoopsnotifications` DISABLE KEYS */;
/*!40000 ALTER TABLE `mega_xoopsnotifications` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2008-04-14 18:25:31
