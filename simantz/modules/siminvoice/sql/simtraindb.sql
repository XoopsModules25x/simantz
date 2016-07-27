CREATE DATABASE /*!32312 IF NOT EXISTS*/ `simitcom_simtrain` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `simitcom_simtrain`;

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `simtrain`
--

-- --------------------------------------------------------

--
-- Table structure for table `simtrain_qryinventorymovement`
--

DROP TABLE IF EXISTS `simtrain_qryinventorymovement`;
CREATE TABLE IF NOT EXISTS `simtrain_qryinventorymovement` (
  `product_id` int(11) default NULL,
  `product_name` varchar(50) default NULL,
  `qty` bigint(12) default NULL,
  `documentno` varbinary(20) default NULL,
  `date` date default NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `simtrain_qryinventorymovement`
--


-- --------------------------------------------------------

--
-- Table structure for table `visi_avatar`
--

DROP TABLE IF EXISTS `visi_avatar`;
CREATE TABLE IF NOT EXISTS `visi_avatar` (
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
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `visi_avatar`
--


-- --------------------------------------------------------

--
-- Table structure for table `visi_avatar_user_link`
--

DROP TABLE IF EXISTS `visi_avatar_user_link`;
CREATE TABLE IF NOT EXISTS `visi_avatar_user_link` (
  `avatar_id` mediumint(8) unsigned NOT NULL default '0',
  `user_id` mediumint(8) unsigned NOT NULL default '0',
  KEY `avatar_user_id` (`avatar_id`,`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `visi_avatar_user_link`
--


-- --------------------------------------------------------

--
-- Table structure for table `visi_banner`
--

DROP TABLE IF EXISTS `visi_banner`;
CREATE TABLE IF NOT EXISTS `visi_banner` (
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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `visi_banner`
--

INSERT INTO `visi_banner` (`bid`, `cid`, `imptotal`, `impmade`, `clicks`, `imageurl`, `clickurl`, `date`, `htmlbanner`, `htmlcode`) VALUES
(1, 1, 0, 2020, 0, 'http://localhost/simtrain/images/banners/xoops_banner.gif', 'http://www.xoops.org/', 1008813250, 0, ''),
(2, 1, 0, 2100, 0, 'http://localhost/simtrain/images/banners/xoops_banner_2.gif', 'http://www.xoops.org/', 1008813250, 0, ''),
(3, 1, 0, 2181, 0, 'http://localhost/simtrain/images/banners/banner.swf', 'http://www.xoops.org/', 1008813250, 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `visi_bannerclient`
--

DROP TABLE IF EXISTS `visi_bannerclient`;
CREATE TABLE IF NOT EXISTS `visi_bannerclient` (
  `cid` smallint(5) unsigned NOT NULL auto_increment,
  `name` varchar(60) NOT NULL default '',
  `contact` varchar(60) NOT NULL default '',
  `email` varchar(60) NOT NULL default '',
  `login` varchar(10) NOT NULL default '',
  `passwd` varchar(10) NOT NULL default '',
  `extrainfo` text NOT NULL,
  PRIMARY KEY  (`cid`),
  KEY `login` (`login`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `visi_bannerclient`
--

INSERT INTO `visi_bannerclient` (`cid`, `name`, `contact`, `email`, `login`, `passwd`, `extrainfo`) VALUES
(1, 'XOOPS', 'XOOPS Dev Team', 'webmaster@xoops.org', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `visi_bannerfinish`
--

DROP TABLE IF EXISTS `visi_bannerfinish`;
CREATE TABLE IF NOT EXISTS `visi_bannerfinish` (
  `bid` smallint(5) unsigned NOT NULL auto_increment,
  `cid` smallint(5) unsigned NOT NULL default '0',
  `impressions` mediumint(8) unsigned NOT NULL default '0',
  `clicks` mediumint(8) unsigned NOT NULL default '0',
  `datestart` int(10) unsigned NOT NULL default '0',
  `dateend` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`bid`),
  KEY `cid` (`cid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `visi_bannerfinish`
--


-- --------------------------------------------------------

--
-- Table structure for table `visi_block_module_link`
--

DROP TABLE IF EXISTS `visi_block_module_link`;
CREATE TABLE IF NOT EXISTS `visi_block_module_link` (
  `block_id` mediumint(8) unsigned NOT NULL default '0',
  `module_id` smallint(5) NOT NULL default '0',
  KEY `module_id` (`module_id`),
  KEY `block_id` (`block_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `visi_block_module_link`
--

INSERT INTO `visi_block_module_link` (`block_id`, `module_id`) VALUES
(1, 0),
(2, 0),
(3, 0),
(4, 0),
(5, 0),
(6, 0),
(7, 0),
(8, 0),
(9, 0),
(10, 0),
(11, 0),
(12, 0);

-- --------------------------------------------------------

--
-- Table structure for table `visi_config`
--

DROP TABLE IF EXISTS `visi_config`;
CREATE TABLE IF NOT EXISTS `visi_config` (
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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=94 ;

--
-- Dumping data for table `visi_config`
--

INSERT INTO `visi_config` (`conf_id`, `conf_modid`, `conf_catid`, `conf_name`, `conf_title`, `conf_value`, `conf_desc`, `conf_formtype`, `conf_valuetype`, `conf_order`) VALUES
(1, 0, 1, 'sitename', '_MD_AM_SITENAME', 'SimTrain Management System', '_MD_AM_SITENAMEDSC', 'textbox', 'text', 0),
(2, 0, 1, 'slogan', '_MD_AM_SLOGAN', 'Learning is power', '_MD_AM_SLOGANDSC', 'textbox', 'text', 2),
(3, 0, 1, 'language', '_MD_AM_LANGUAGE', 'english', '_MD_AM_LANGUAGEDSC', 'language', 'other', 4),
(4, 0, 1, 'startpage', '_MD_AM_STARTPAGE', '--', '_MD_AM_STARTPAGEDSC', 'startpage', 'other', 6),
(5, 0, 1, 'server_TZ', '_MD_AM_SERVERTZ', '0', '_MD_AM_SERVERTZDSC', 'timezone', 'float', 8),
(6, 0, 1, 'default_TZ', '_MD_AM_DEFAULTTZ', '0', '_MD_AM_DEFAULTTZDSC', 'timezone', 'float', 10),
(7, 0, 1, 'theme_set', '_MD_AM_DTHEME', 'default', '_MD_AM_DTHEMEDSC', 'theme', 'other', 12),
(8, 0, 1, 'anonymous', '_MD_AM_ANONNAME', 'Anonymous', '_MD_AM_ANONNAMEDSC', 'textbox', 'text', 15),
(9, 0, 1, 'gzip_compression', '_MD_AM_USEGZIP', '0', '_MD_AM_USEGZIPDSC', 'yesno', 'int', 16),
(10, 0, 1, 'usercookie', '_MD_AM_USERCOOKIE', 'xoops_user', '_MD_AM_USERCOOKIEDSC', 'textbox', 'text', 18),
(11, 0, 1, 'session_expire', '_MD_AM_SESSEXPIRE', '15', '_MD_AM_SESSEXPIREDSC', 'textbox', 'int', 22),
(12, 0, 1, 'banners', '_MD_AM_BANNERS', '1', '_MD_AM_BANNERSDSC', 'yesno', 'int', 26),
(13, 0, 1, 'debug_mode', '_MD_AM_DEBUGMODE', '0', '_MD_AM_DEBUGMODEDSC', 'select', 'int', 24),
(14, 0, 1, 'my_ip', '_MD_AM_MYIP', '127.0.0.1', '_MD_AM_MYIPDSC', 'textbox', 'text', 29),
(15, 0, 1, 'use_ssl', '_MD_AM_USESSL', '1', '_MD_AM_USESSLDSC', 'yesno', 'int', 30),
(16, 0, 1, 'session_name', '_MD_AM_SESSNAME', 'xoops_session', '_MD_AM_SESSNAMEDSC', 'textbox', 'text', 20),
(17, 0, 2, 'minpass', '_MD_AM_MINPASS', '5', '_MD_AM_MINPASSDSC', 'textbox', 'int', 1),
(18, 0, 2, 'minuname', '_MD_AM_MINUNAME', '3', '_MD_AM_MINUNAMEDSC', 'textbox', 'int', 2),
(19, 0, 2, 'new_user_notify', '_MD_AM_NEWUNOTIFY', '1', '_MD_AM_NEWUNOTIFYDSC', 'yesno', 'int', 4),
(20, 0, 2, 'new_user_notify_group', '_MD_AM_NOTIFYTO', '1', '_MD_AM_NOTIFYTODSC', 'group', 'int', 6),
(21, 0, 2, 'activation_type', '_MD_AM_ACTVTYPE', '0', '_MD_AM_ACTVTYPEDSC', 'select', 'int', 8),
(22, 0, 2, 'activation_group', '_MD_AM_ACTVGROUP', '1', '_MD_AM_ACTVGROUPDSC', 'group', 'int', 10),
(23, 0, 2, 'uname_test_level', '_MD_AM_UNAMELVL', '0', '_MD_AM_UNAMELVLDSC', 'select', 'int', 12),
(24, 0, 2, 'avatar_allow_upload', '_MD_AM_AVATARALLOW', '0', '_MD_AM_AVATARALWDSC', 'yesno', 'int', 14),
(27, 0, 2, 'avatar_width', '_MD_AM_AVATARW', '80', '_MD_AM_AVATARWDSC', 'textbox', 'int', 16),
(28, 0, 2, 'avatar_height', '_MD_AM_AVATARH', '80', '_MD_AM_AVATARHDSC', 'textbox', 'int', 18),
(29, 0, 2, 'avatar_maxsize', '_MD_AM_AVATARMAX', '35000', '_MD_AM_AVATARMAXDSC', 'textbox', 'int', 20),
(30, 0, 1, 'adminmail', '_MD_AM_ADMINML', 'admin@simit.com.my', '_MD_AM_ADMINMLDSC', 'textbox', 'text', 3),
(31, 0, 2, 'self_delete', '_MD_AM_SELFDELETE', '0', '_MD_AM_SELFDELETEDSC', 'yesno', 'int', 22),
(32, 0, 1, 'com_mode', '_MD_AM_COMMODE', 'nest', '_MD_AM_COMMODEDSC', 'select', 'text', 34),
(33, 0, 1, 'com_order', '_MD_AM_COMORDER', '0', '_MD_AM_COMORDERDSC', 'select', 'int', 36),
(34, 0, 2, 'bad_unames', '_MD_AM_BADUNAMES', 'a:3:{i:0;s:9:"webmaster";i:1;s:6:"^xoops";i:2;s:6:"^admin";}', '_MD_AM_BADUNAMESDSC', 'textarea', 'array', 24),
(35, 0, 2, 'bad_emails', '_MD_AM_BADEMAILS', 'a:1:{i:0;s:10:"xoops.org$";}', '_MD_AM_BADEMAILSDSC', 'textarea', 'array', 26),
(36, 0, 2, 'maxuname', '_MD_AM_MAXUNAME', '10', '_MD_AM_MAXUNAMEDSC', 'textbox', 'int', 3),
(37, 0, 1, 'bad_ips', '_MD_AM_BADIPS', 'a:1:{i:0;s:9:"127.0.0.1";}', '_MD_AM_BADIPSDSC', 'textarea', 'array', 42),
(38, 0, 3, 'meta_keywords', '_MD_AM_METAKEY', 'training, tuisyen, tuition center, pmr, spm, stpm', '_MD_AM_METAKEYDSC', 'textarea', 'text', 0),
(39, 0, 3, 'footer', '_MD_AM_FOOTER', 'Developed by Sim IT Sdn. Bhd. Â© 2001-2008 <a href="http://www.simit.com.my/" target="_blank">The Sim IT Project</a>', '_MD_AM_FOOTERDSC', 'textarea', 'text', 20),
(40, 0, 4, 'censor_enable', '_MD_AM_DOCENSOR', '0', '_MD_AM_DOCENSORDSC', 'yesno', 'int', 0),
(41, 0, 4, 'censor_words', '_MD_AM_CENSORWRD', 'a:2:{i:0;s:4:"fuck";i:1;s:4:"shit";}', '_MD_AM_CENSORWRDDSC', 'textarea', 'array', 1),
(42, 0, 4, 'censor_replace', '_MD_AM_CENSORRPLC', '#OOPS#', '_MD_AM_CENSORRPLCDSC', 'textbox', 'text', 2),
(43, 0, 3, 'meta_robots', '_MD_AM_METAROBOTS', 'index,follow', '_MD_AM_METAROBOTSDSC', 'select', 'text', 2),
(44, 0, 5, 'enable_search', '_MD_AM_DOSEARCH', '1', '_MD_AM_DOSEARCHDSC', 'yesno', 'int', 0),
(45, 0, 5, 'keyword_min', '_MD_AM_MINSEARCH', '5', '_MD_AM_MINSEARCHDSC', 'textbox', 'int', 1),
(46, 0, 2, 'avatar_minposts', '_MD_AM_AVATARMP', '0', '_MD_AM_AVATARMPDSC', 'textbox', 'int', 15),
(47, 0, 1, 'enable_badips', '_MD_AM_DOBADIPS', '0', '_MD_AM_DOBADIPSDSC', 'yesno', 'int', 40),
(48, 0, 3, 'meta_rating', '_MD_AM_METARATING', 'general', '_MD_AM_METARATINGDSC', 'select', 'text', 4),
(49, 0, 3, 'meta_author', '_MD_AM_METAAUTHOR', 'SIMTRAIN', '_MD_AM_METAAUTHORDSC', 'textbox', 'text', 6),
(50, 0, 3, 'meta_copyright', '_MD_AM_METACOPYR', 'Copyright Â© 2001-2008', '_MD_AM_METACOPYRDSC', 'textbox', 'text', 8),
(51, 0, 3, 'meta_description', '_MD_AM_METADESC', 'SimTrain is a content management system which enable users manage their training center data via internet to link up each branches and access anytime and anywhere.', '_MD_AM_METADESCDSC', 'textarea', 'text', 1),
(52, 0, 2, 'allow_chgmail', '_MD_AM_ALLWCHGMAIL', '0', '_MD_AM_ALLWCHGMAILDSC', 'yesno', 'int', 3),
(53, 0, 1, 'use_mysession', '_MD_AM_USEMYSESS', '0', '_MD_AM_USEMYSESSDSC', 'yesno', 'int', 19),
(54, 0, 2, 'reg_dispdsclmr', '_MD_AM_DSPDSCLMR', '1', '_MD_AM_DSPDSCLMRDSC', 'yesno', 'int', 30),
(55, 0, 2, 'reg_disclaimer', '_MD_AM_REGDSCLMR', 'While the administrators and moderators of this site will attempt to remove\r\nor edit any generally objectionable material as quickly as possible, it is\r\nimpossible to review every message. Therefore you acknowledge that all posts\r\nmade to this site express the views and opinions of the author and not the\r\nadministrators, moderators or webmaster (except for posts by these people)\r\nand hence will not be held liable. \r\n\r\nYou agree not to post any abusive, obscene, vulgar, slanderous, hateful,\r\nthreatening, sexually-orientated or any other material that may violate any\r\napplicable laws. Doing so may lead to you being immediately and permanently\r\nbanned (and your service provider being informed). The IP address of all\r\nposts is recorded to aid in enforcing these conditions. Creating multiple\r\naccounts for a single user is not allowed. You agree that the webmaster,\r\nadministrator and moderators of this site have the right to remove, edit,\r\nmove or close any topic at any time should they see fit. As a user you agree\r\nto any information you have entered above being stored in a database. While\r\nthis information will not be disclosed to any third party without your\r\nconsent the webmaster, administrator and moderators cannot be held\r\nresponsible for any hacking attempt that may lead to the data being\r\ncompromised. \r\n\r\nThis site system uses cookies to store information on your local computer.\r\nThese cookies do not contain any of the information you have entered above,\r\nthey serve only to improve your viewing pleasure. The email address is used\r\nonly for confirming your registration details and password (and for sending\r\nnew passwords should you forget your current one). \r\n\r\nBy clicking Register below you agree to be bound by these conditions.', '_MD_AM_REGDSCLMRDSC', 'textarea', 'text', 32),
(56, 0, 2, 'allow_register', '_MD_AM_ALLOWREG', '1', '_MD_AM_ALLOWREGDSC', 'yesno', 'int', 0),
(57, 0, 1, 'theme_fromfile', '_MD_AM_THEMEFILE', '0', '_MD_AM_THEMEFILEDSC', 'yesno', 'int', 13),
(58, 0, 1, 'closesite', '_MD_AM_CLOSESITE', '0', '_MD_AM_CLOSESITEDSC', 'yesno', 'int', 26),
(59, 0, 1, 'closesite_okgrp', '_MD_AM_CLOSESITEOK', 'a:1:{i:0;s:1:"1";}', '_MD_AM_CLOSESITEOKDSC', 'group_multi', 'array', 27),
(60, 0, 1, 'closesite_text', '_MD_AM_CLOSESITETXT', 'The site is currently closed for maintenance. Please come back later.', '_MD_AM_CLOSESITETXTDSC', 'textarea', 'text', 28),
(61, 0, 1, 'sslpost_name', '_MD_AM_SSLPOST', 'xoops_ssl', '_MD_AM_SSLPOSTDSC', 'textbox', 'text', 31),
(62, 0, 1, 'module_cache', '_MD_AM_MODCACHE', 'a:1:{i:3;s:1:"0";}', '_MD_AM_MODCACHEDSC', 'module_cache', 'array', 50),
(63, 0, 1, 'template_set', '_MD_AM_DTPLSET', 'default', '_MD_AM_DTPLSETDSC', 'tplset', 'other', 14),
(64, 0, 6, 'mailmethod', '_MD_AM_MAILERMETHOD', 'mail', '_MD_AM_MAILERMETHODDESC', 'select', 'text', 4),
(65, 0, 6, 'smtphost', '_MD_AM_SMTPHOST', 'a:1:{i:0;s:0:"";}', '_MD_AM_SMTPHOSTDESC', 'textarea', 'array', 6),
(66, 0, 6, 'smtpuser', '_MD_AM_SMTPUSER', '', '_MD_AM_SMTPUSERDESC', 'textbox', 'text', 7),
(67, 0, 6, 'smtppass', '_MD_AM_SMTPPASS', '', '_MD_AM_SMTPPASSDESC', 'password', 'text', 8),
(68, 0, 6, 'sendmailpath', '_MD_AM_SENDMAILPATH', '/usr/sbin/sendmail', '_MD_AM_SENDMAILPATHDESC', 'textbox', 'text', 5),
(69, 0, 6, 'from', '_MD_AM_MAILFROM', '', '_MD_AM_MAILFROMDESC', 'textbox', 'text', 1),
(70, 0, 6, 'fromname', '_MD_AM_MAILFROMNAME', '', '_MD_AM_MAILFROMNAMEDESC', 'textbox', 'text', 2),
(71, 0, 1, 'sslloginlink', '_MD_AM_SSLLINK', 'https://192.168.146.1/simtrain/', '_MD_AM_SSLLINKDSC', 'textbox', 'text', 33),
(72, 0, 1, 'theme_set_allowed', '_MD_AM_THEMEOK', 'a:1:{i:0;s:7:"default";}', '_MD_AM_THEMEOKDSC', 'theme_multi', 'array', 13),
(73, 0, 6, 'fromuid', '_MD_AM_MAILFROMUID', '1', '_MD_AM_MAILFROMUIDDESC', 'user', 'int', 3),
(74, 0, 7, 'auth_method', '_MD_AM_AUTHMETHOD', 'xoops', '_MD_AM_AUTHMETHODDESC', 'select', 'text', 1),
(75, 0, 7, 'ldap_port', '_MD_AM_LDAP_PORT', '389', '_MD_AM_LDAP_PORT', 'textbox', 'int', 2),
(76, 0, 7, 'ldap_server', '_MD_AM_LDAP_SERVER', 'your directory server', '_MD_AM_LDAP_SERVER_DESC', 'textbox', 'text', 3),
(77, 0, 7, 'ldap_base_dn', '_MD_AM_LDAP_BASE_DN', 'dc=xoops,dc=org', '_MD_AM_LDAP_BASE_DN_DESC', 'textbox', 'text', 4),
(78, 0, 7, 'ldap_manager_dn', '_MD_AM_LDAP_MANAGER_DN', 'manager_dn', '_MD_AM_LDAP_MANAGER_DN_DESC', 'textbox', 'text', 5),
(79, 0, 7, 'ldap_manager_pass', '_MD_AM_LDAP_MANAGER_PASS', 'manager_pass', '_MD_AM_LDAP_MANAGER_PASS_DESC', 'password', 'text', 6),
(80, 0, 7, 'ldap_version', '_MD_AM_LDAP_VERSION', '3', '_MD_AM_LDAP_VERSION_DESC', 'textbox', 'text', 7),
(81, 0, 7, 'ldap_users_bypass', '_MD_AM_LDAP_USERS_BYPASS', 'a:1:{i:0;s:5:"admin";}', '_MD_AM_LDAP_USERS_BYPASS_DESC', 'textarea', 'array', 8),
(82, 0, 7, 'ldap_loginname_asdn', '_MD_AM_LDAP_LOGINNAME_ASDN', 'uid_asdn', '_MD_AM_LDAP_LOGINNAME_ASDN_D', 'yesno', 'int', 9),
(83, 0, 7, 'ldap_loginldap_attr', '_MD_AM_LDAP_LOGINLDAP_ATTR', 'uid', '_MD_AM_LDAP_LOGINLDAP_ATTR_D', 'textbox', 'text', 10),
(84, 0, 7, 'ldap_filter_person', '_MD_AM_LDAP_FILTER_PERSON', '', '_MD_AM_LDAP_FILTER_PERSON_DESC', 'textbox', 'text', 11),
(85, 0, 7, 'ldap_domain_name', '_MD_AM_LDAP_DOMAIN_NAME', 'mydomain', '_MD_AM_LDAP_DOMAIN_NAME_DESC', 'textbox', 'text', 12),
(86, 0, 7, 'ldap_provisionning', '_MD_AM_LDAP_PROVIS', '0', '_MD_AM_LDAP_PROVIS_DESC', 'yesno', 'int', 13),
(87, 0, 7, 'ldap_provisionning_group', '_MD_AM_LDAP_PROVIS_GROUP', 'a:1:{i:0;s:1:"2";}', '_MD_AM_LDAP_PROVIS_GROUP_DSC', 'group_multi', 'array', 14),
(88, 0, 7, 'ldap_mail_attr', '_MD_AM_LDAP_MAIL_ATTR', 'mail', '_MD_AM_LDAP_MAIL_ATTR_DESC', 'textbox', 'text', 15),
(89, 0, 7, 'ldap_givenname_attr', '_MD_AM_LDAP_GIVENNAME_ATTR', 'givenname', '_MD_AM_LDAP_GIVENNAME_ATTR_DSC', 'textbox', 'text', 16),
(90, 0, 7, 'ldap_surname_attr', '_MD_AM_LDAP_SURNAME_ATTR', 'sn', '_MD_AM_LDAP_SURNAME_ATTR_DESC', 'textbox', 'text', 17),
(91, 0, 7, 'ldap_field_mapping', '_MD_AM_LDAP_FIELD_MAPPING_ATTR', 'email=mail|name=displayname', '_MD_AM_LDAP_FIELD_MAPPING_DESC', 'textarea', 'text', 18),
(92, 0, 7, 'ldap_provisionning_upd', '_MD_AM_LDAP_PROVIS_UPD', '1', '_MD_AM_LDAP_PROVIS_UPD_DESC', 'yesno', 'int', 19),
(93, 0, 7, 'ldap_use_TLS', '_MD_AM_LDAP_USETLS', '0', '_MD_AM_LDAP_USETLS_DESC', 'yesno', 'int', 20);

-- --------------------------------------------------------

--
-- Table structure for table `visi_configcategory`
--

DROP TABLE IF EXISTS `visi_configcategory`;
CREATE TABLE IF NOT EXISTS `visi_configcategory` (
  `confcat_id` smallint(5) unsigned NOT NULL auto_increment,
  `confcat_name` varchar(255) NOT NULL default '',
  `confcat_order` smallint(5) unsigned NOT NULL default '0',
  PRIMARY KEY  (`confcat_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `visi_configcategory`
--

INSERT INTO `visi_configcategory` (`confcat_id`, `confcat_name`, `confcat_order`) VALUES
(1, '_MD_AM_GENERAL', 0),
(2, '_MD_AM_USERSETTINGS', 0),
(3, '_MD_AM_METAFOOTER', 0),
(4, '_MD_AM_CENSOR', 0),
(5, '_MD_AM_SEARCH', 0),
(6, '_MD_AM_MAILER', 0),
(7, '_MD_AM_AUTHENTICATION', 0);

-- --------------------------------------------------------

--
-- Table structure for table `visi_configoption`
--

DROP TABLE IF EXISTS `visi_configoption`;
CREATE TABLE IF NOT EXISTS `visi_configoption` (
  `confop_id` mediumint(8) unsigned NOT NULL auto_increment,
  `confop_name` varchar(255) NOT NULL default '',
  `confop_value` varchar(255) NOT NULL default '',
  `conf_id` smallint(5) unsigned NOT NULL default '0',
  PRIMARY KEY  (`confop_id`),
  KEY `conf_id` (`conf_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=31 ;

--
-- Dumping data for table `visi_configoption`
--

INSERT INTO `visi_configoption` (`confop_id`, `confop_name`, `confop_value`, `conf_id`) VALUES
(1, '_MD_AM_DEBUGMODE1', '1', 13),
(2, '_MD_AM_DEBUGMODE2', '2', 13),
(3, '_NESTED', 'nest', 32),
(4, '_FLAT', 'flat', 32),
(5, '_THREADED', 'thread', 32),
(6, '_OLDESTFIRST', '0', 33),
(7, '_NEWESTFIRST', '1', 33),
(8, '_MD_AM_USERACTV', '0', 21),
(9, '_MD_AM_AUTOACTV', '1', 21),
(10, '_MD_AM_ADMINACTV', '2', 21),
(11, '_MD_AM_STRICT', '0', 23),
(12, '_MD_AM_MEDIUM', '1', 23),
(13, '_MD_AM_LIGHT', '2', 23),
(14, '_MD_AM_DEBUGMODE3', '3', 13),
(15, '_MD_AM_INDEXFOLLOW', 'index,follow', 43),
(16, '_MD_AM_NOINDEXFOLLOW', 'noindex,follow', 43),
(17, '_MD_AM_INDEXNOFOLLOW', 'index,nofollow', 43),
(18, '_MD_AM_NOINDEXNOFOLLOW', 'noindex,nofollow', 43),
(19, '_MD_AM_METAOGEN', 'general', 48),
(20, '_MD_AM_METAO14YRS', '14 years', 48),
(21, '_MD_AM_METAOREST', 'restricted', 48),
(22, '_MD_AM_METAOMAT', 'mature', 48),
(23, '_MD_AM_DEBUGMODE0', '0', 13),
(24, 'PHP mail()', 'mail', 64),
(25, 'sendmail', 'sendmail', 64),
(26, 'SMTP', 'smtp', 64),
(27, 'SMTPAuth', 'smtpauth', 64),
(28, '_MD_AM_AUTH_CONFOPTION_XOOPS', 'xoops', 74),
(29, '_MD_AM_AUTH_CONFOPTION_LDAP', 'ldap', 74),
(30, '_MD_AM_AUTH_CONFOPTION_AD', 'ads', 74);

-- --------------------------------------------------------

--
-- Table structure for table `visi_edito`
--

DROP TABLE IF EXISTS `visi_edito`;
CREATE TABLE IF NOT EXISTS `visi_edito` (
  `Id_content` int(11) NOT NULL auto_increment,
  `uid` int(6) unsigned default '1',
  `datesub` int(11) unsigned NOT NULL default '1033141070',
  `subject` varchar(50) default NULL,
  `informations` text,
  `contents_nohtml` tinyint(1) unsigned default '0',
  `contents_nosmiley` tinyint(1) unsigned default '0',
  `contents_noxcode` tinyint(1) unsigned default '0',
  `contents_notitle` tinyint(1) unsigned default '0',
  `contents_nologo` tinyint(1) unsigned default '0',
  `contents_nomain` tinyint(1) unsigned default '0',
  `contents_noblock` tinyint(1) unsigned default '0',
  `counter` int(8) unsigned default '0',
  `offline` int(11) unsigned default NULL,
  `comments` int(11) unsigned default '0',
  `cancomment` tinyint(1) unsigned default '1',
  `artimage` varchar(255) NOT NULL default 'blank.gif',
  `groups` varchar(255) NOT NULL default '',
  `hidden` tinyint(1) unsigned default '0',
  PRIMARY KEY  (`Id_content`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `visi_edito`
--


-- --------------------------------------------------------

--
-- Table structure for table `visi_groups`
--

DROP TABLE IF EXISTS `visi_groups`;
CREATE TABLE IF NOT EXISTS `visi_groups` (
  `groupid` smallint(5) unsigned NOT NULL auto_increment,
  `name` varchar(50) NOT NULL default '',
  `description` text NOT NULL,
  `group_type` varchar(10) NOT NULL default '',
  PRIMARY KEY  (`groupid`),
  KEY `group_type` (`group_type`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `visi_groups`
--

INSERT INTO `visi_groups` (`groupid`, `name`, `description`, `group_type`) VALUES
(1, 'Webmasters', 'Webmasters of this site', 'Admin'),
(2, 'Registered Users', 'Registered Users Group', 'User'),
(3, 'Anonymous Users', 'Anonymous Users Group', 'Anonymous'),
(5, 'Simtrain', '', ''),
(6, 'SImtrain2', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `visi_groups_users_link`
--

DROP TABLE IF EXISTS `visi_groups_users_link`;
CREATE TABLE IF NOT EXISTS `visi_groups_users_link` (
  `linkid` mediumint(8) unsigned NOT NULL auto_increment,
  `groupid` smallint(5) unsigned NOT NULL default '0',
  `uid` mediumint(8) unsigned NOT NULL default '0',
  PRIMARY KEY  (`linkid`),
  KEY `groupid_uid` (`groupid`,`uid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=68 ;

--
-- Dumping data for table `visi_groups_users_link`
--

INSERT INTO `visi_groups_users_link` (`linkid`, `groupid`, `uid`) VALUES
(33, 5, 1),
(32, 2, 1),
(6, 5, 3),
(34, 5, 10),
(31, 1, 1),
(30, 2, 10),
(62, 2, 11),
(63, 5, 11),
(64, 6, 11),
(51, 2, 13),
(42, 2, 14),
(43, 5, 14),
(47, 2, 15),
(48, 5, 15),
(52, 5, 13),
(53, 6, 1),
(61, 1, 11),
(66, 5, 12),
(67, 6, 16),
(57, 6, 15),
(58, 6, 13),
(59, 6, 10),
(60, 6, 14);

-- --------------------------------------------------------

--
-- Table structure for table `visi_group_permission`
--

DROP TABLE IF EXISTS `visi_group_permission`;
CREATE TABLE IF NOT EXISTS `visi_group_permission` (
  `gperm_id` int(10) unsigned NOT NULL auto_increment,
  `gperm_groupid` smallint(5) unsigned NOT NULL default '0',
  `gperm_itemid` mediumint(8) unsigned NOT NULL default '0',
  `gperm_modid` mediumint(5) unsigned NOT NULL default '0',
  `gperm_name` varchar(50) NOT NULL default '',
  PRIMARY KEY  (`gperm_id`),
  KEY `groupid` (`gperm_groupid`),
  KEY `itemid` (`gperm_itemid`),
  KEY `gperm_modid` (`gperm_modid`,`gperm_name`(10))
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=168 ;

--
-- Dumping data for table `visi_group_permission`
--

INSERT INTO `visi_group_permission` (`gperm_id`, `gperm_groupid`, `gperm_itemid`, `gperm_modid`, `gperm_name`) VALUES
(87, 1, 6, 1, 'block_read'),
(86, 1, 5, 1, 'block_read'),
(85, 1, 4, 1, 'block_read'),
(84, 1, 3, 1, 'block_read'),
(83, 1, 2, 1, 'block_read'),
(82, 1, 1, 1, 'block_read'),
(81, 1, 1, 1, 'module_read'),
(80, 1, 3, 1, 'module_read'),
(79, 1, 1, 1, 'module_admin'),
(78, 1, 3, 1, 'module_admin'),
(77, 1, 2, 1, 'system_admin'),
(76, 1, 11, 1, 'system_admin'),
(75, 1, 15, 1, 'system_admin'),
(74, 1, 12, 1, 'system_admin'),
(73, 1, 3, 1, 'system_admin'),
(72, 1, 4, 1, 'system_admin'),
(71, 1, 8, 1, 'system_admin'),
(141, 2, 1, 1, 'block_read'),
(70, 1, 9, 1, 'system_admin'),
(140, 2, 5, 1, 'block_read'),
(128, 3, 1, 1, 'block_read'),
(139, 2, 12, 1, 'block_read'),
(127, 3, 5, 1, 'block_read'),
(69, 1, 1, 1, 'system_admin'),
(138, 2, 11, 1, 'block_read'),
(126, 3, 12, 1, 'block_read'),
(137, 2, 10, 1, 'block_read'),
(125, 3, 11, 1, 'block_read'),
(68, 1, 7, 1, 'system_admin'),
(136, 2, 9, 1, 'block_read'),
(124, 3, 10, 1, 'block_read'),
(135, 2, 8, 1, 'block_read'),
(123, 3, 9, 1, 'block_read'),
(67, 1, 14, 1, 'system_admin'),
(134, 2, 7, 1, 'block_read'),
(122, 3, 8, 1, 'block_read'),
(133, 2, 6, 1, 'block_read'),
(121, 3, 7, 1, 'block_read'),
(66, 1, 5, 1, 'system_admin'),
(132, 2, 4, 1, 'block_read'),
(120, 3, 6, 1, 'block_read'),
(131, 2, 3, 1, 'block_read'),
(119, 3, 4, 1, 'block_read'),
(65, 1, 13, 1, 'system_admin'),
(130, 2, 2, 1, 'block_read'),
(118, 3, 3, 1, 'block_read'),
(64, 1, 10, 1, 'system_admin'),
(129, 2, 1, 1, 'module_read'),
(117, 3, 2, 1, 'block_read'),
(88, 1, 7, 1, 'block_read'),
(89, 1, 8, 1, 'block_read'),
(90, 1, 9, 1, 'block_read'),
(91, 1, 10, 1, 'block_read'),
(92, 1, 11, 1, 'block_read'),
(93, 1, 12, 1, 'block_read'),
(167, 5, 1, 1, 'block_read'),
(166, 5, 5, 1, 'block_read'),
(165, 5, 1, 1, 'module_read'),
(164, 5, 3, 1, 'module_read'),
(116, 3, 1, 1, 'module_read'),
(162, 6, 3, 1, 'module_read'),
(163, 6, 1, 1, 'module_read');

-- --------------------------------------------------------

--
-- Table structure for table `visi_image`
--

DROP TABLE IF EXISTS `visi_image`;
CREATE TABLE IF NOT EXISTS `visi_image` (
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
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `visi_image`
--


-- --------------------------------------------------------

--
-- Table structure for table `visi_imagebody`
--

DROP TABLE IF EXISTS `visi_imagebody`;
CREATE TABLE IF NOT EXISTS `visi_imagebody` (
  `image_id` mediumint(8) unsigned NOT NULL default '0',
  `image_body` mediumblob,
  KEY `image_id` (`image_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `visi_imagebody`
--


-- --------------------------------------------------------

--
-- Table structure for table `visi_imagecategory`
--

DROP TABLE IF EXISTS `visi_imagecategory`;
CREATE TABLE IF NOT EXISTS `visi_imagecategory` (
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
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `visi_imagecategory`
--


-- --------------------------------------------------------

--
-- Table structure for table `visi_imgset`
--

DROP TABLE IF EXISTS `visi_imgset`;
CREATE TABLE IF NOT EXISTS `visi_imgset` (
  `imgset_id` smallint(5) unsigned NOT NULL auto_increment,
  `imgset_name` varchar(50) NOT NULL default '',
  `imgset_refid` mediumint(8) unsigned NOT NULL default '0',
  PRIMARY KEY  (`imgset_id`),
  KEY `imgset_refid` (`imgset_refid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `visi_imgset`
--

INSERT INTO `visi_imgset` (`imgset_id`, `imgset_name`, `imgset_refid`) VALUES
(1, 'default', 0);

-- --------------------------------------------------------

--
-- Table structure for table `visi_imgsetimg`
--

DROP TABLE IF EXISTS `visi_imgsetimg`;
CREATE TABLE IF NOT EXISTS `visi_imgsetimg` (
  `imgsetimg_id` mediumint(8) unsigned NOT NULL auto_increment,
  `imgsetimg_file` varchar(50) NOT NULL default '',
  `imgsetimg_body` blob NOT NULL,
  `imgsetimg_imgset` smallint(5) unsigned NOT NULL default '0',
  PRIMARY KEY  (`imgsetimg_id`),
  KEY `imgsetimg_imgset` (`imgsetimg_imgset`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `visi_imgsetimg`
--


-- --------------------------------------------------------

--
-- Table structure for table `visi_imgset_tplset_link`
--

DROP TABLE IF EXISTS `visi_imgset_tplset_link`;
CREATE TABLE IF NOT EXISTS `visi_imgset_tplset_link` (
  `imgset_id` smallint(5) unsigned NOT NULL default '0',
  `tplset_name` varchar(50) NOT NULL default '',
  KEY `tplset_name` (`tplset_name`(10))
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `visi_imgset_tplset_link`
--

INSERT INTO `visi_imgset_tplset_link` (`imgset_id`, `tplset_name`) VALUES
(1, 'default');

-- --------------------------------------------------------

--
-- Table structure for table `visi_modules`
--

DROP TABLE IF EXISTS `visi_modules`;
CREATE TABLE IF NOT EXISTS `visi_modules` (
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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `visi_modules`
--

INSERT INTO `visi_modules` (`mid`, `name`, `version`, `last_update`, `weight`, `isactive`, `dirname`, `hasmain`, `hasadmin`, `hassearch`, `hasconfig`, `hascomments`, `hasnotification`) VALUES
(1, 'System', 102, 1205985656, 0, 1, 'system', 0, 1, 0, 0, 0, 0),
(3, 'SimTrain Management System', 90, 1210776371, 1, 1, 'simtrain', 1, 1, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `visi_newblocks`
--

DROP TABLE IF EXISTS `visi_newblocks`;
CREATE TABLE IF NOT EXISTS `visi_newblocks` (
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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `visi_newblocks`
--

INSERT INTO `visi_newblocks` (`bid`, `mid`, `func_num`, `options`, `name`, `title`, `content`, `side`, `weight`, `visible`, `block_type`, `c_type`, `isactive`, `dirname`, `func_file`, `show_func`, `edit_func`, `template`, `bcachetime`, `last_modified`) VALUES
(1, 1, 1, '', 'User Menu', 'User Menu', '', 0, 20, 1, 'S', 'H', 1, 'system', 'system_blocks.php', 'b_system_user_show', '', 'system_block_user.html', 0, 1206512022),
(2, 1, 2, '', 'Login', 'Login', '', 0, 0, 1, 'S', 'H', 1, 'system', 'system_blocks.php', 'b_system_login_show', '', 'system_block_login.html', 0, 1205985656),
(3, 1, 3, '', 'Search', 'Search', '', 0, 0, 0, 'S', 'H', 1, 'system', 'system_blocks.php', 'b_system_search_show', '', 'system_block_search.html', 0, 1205985656),
(4, 1, 4, '', 'Waiting Contents', 'Waiting Contents', '', 0, 0, 0, 'S', 'H', 1, 'system', 'system_blocks.php', 'b_system_waiting_show', '', 'system_block_waiting.html', 0, 1205985656),
(5, 1, 5, '', 'Main Menu', 'Main Menu', '', 0, 10, 1, 'S', 'H', 1, 'system', 'system_blocks.php', 'b_system_main_show', '', 'system_block_mainmenu.html', 0, 1206512022),
(6, 1, 6, '320|190|s_poweredby.gif|1', 'Site Info', 'Site Info', '', 0, 0, 0, 'S', 'H', 1, 'system', 'system_blocks.php', 'b_system_info_show', 'b_system_info_edit', 'system_block_siteinfo.html', 0, 1205985656),
(7, 1, 7, '', 'Who''s Online', 'Who''s Online', '', 0, 0, 0, 'S', 'H', 1, 'system', 'system_blocks.php', 'b_system_online_show', '', 'system_block_online.html', 0, 1205985656),
(8, 1, 8, '10|1', 'Top Posters', 'Top Posters', '', 0, 0, 0, 'S', 'H', 1, 'system', 'system_blocks.php', 'b_system_topposters_show', 'b_system_topposters_edit', 'system_block_topusers.html', 0, 1205985656),
(9, 1, 9, '10|1', 'New Members', 'New Members', '', 0, 0, 0, 'S', 'H', 1, 'system', 'system_blocks.php', 'b_system_newmembers_show', 'b_system_newmembers_edit', 'system_block_newusers.html', 0, 1205985656),
(10, 1, 10, '10', 'Recent Comments', 'Recent Comments', '', 0, 0, 0, 'S', 'H', 1, 'system', 'system_blocks.php', 'b_system_comments_show', 'b_system_comments_edit', 'system_block_comments.html', 0, 1205985656),
(11, 1, 11, '', 'Notification Options', 'Notification Options', '', 0, 0, 0, 'S', 'H', 1, 'system', 'system_blocks.php', 'b_system_notification_show', '', 'system_block_notification.html', 0, 1205985656),
(12, 1, 12, '0|80', 'Themes', 'Themes', '', 0, 0, 0, 'S', 'H', 1, 'system', 'system_blocks.php', 'b_system_themes_show', 'b_system_themes_edit', 'system_block_themes.html', 0, 1205985656);

-- --------------------------------------------------------

--
-- Table structure for table `visi_online`
--

DROP TABLE IF EXISTS `visi_online`;
CREATE TABLE IF NOT EXISTS `visi_online` (
  `online_uid` mediumint(8) unsigned NOT NULL default '0',
  `online_uname` varchar(25) NOT NULL default '',
  `online_updated` int(10) unsigned NOT NULL default '0',
  `online_module` smallint(5) unsigned NOT NULL default '0',
  `online_ip` varchar(15) NOT NULL default '',
  KEY `online_module` (`online_module`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `visi_online`
--


-- --------------------------------------------------------

--
-- Table structure for table `visi_priv_msgs`
--

DROP TABLE IF EXISTS `visi_priv_msgs`;
CREATE TABLE IF NOT EXISTS `visi_priv_msgs` (
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
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `visi_priv_msgs`
--


-- --------------------------------------------------------

--
-- Table structure for table `visi_ranks`
--

DROP TABLE IF EXISTS `visi_ranks`;
CREATE TABLE IF NOT EXISTS `visi_ranks` (
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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `visi_ranks`
--

INSERT INTO `visi_ranks` (`rank_id`, `rank_title`, `rank_min`, `rank_max`, `rank_special`, `rank_image`) VALUES
(1, 'Just popping in', 0, 20, 0, 'rank3e632f95e81ca.gif'),
(2, 'Not too shy to talk', 21, 40, 0, 'rank3dbf8e94a6f72.gif'),
(3, 'Quite a regular', 41, 70, 0, 'rank3dbf8e9e7d88d.gif'),
(4, 'Just can''t stay away', 71, 150, 0, 'rank3dbf8ea81e642.gif'),
(5, 'Home away from home', 151, 10000, 0, 'rank3dbf8eb1a72e7.gif'),
(6, 'Moderator', 0, 0, 1, 'rank3dbf8edf15093.gif'),
(7, 'Webmaster', 0, 0, 1, 'rank3dbf8ee8681cd.gif');

-- --------------------------------------------------------

--
-- Table structure for table `visi_session`
--

DROP TABLE IF EXISTS `visi_session`;
CREATE TABLE IF NOT EXISTS `visi_session` (
  `sess_id` varchar(32) NOT NULL default '',
  `sess_updated` int(10) unsigned NOT NULL default '0',
  `sess_ip` varchar(15) NOT NULL default '',
  `sess_data` text NOT NULL,
  PRIMARY KEY  (`sess_id`),
  KEY `updated` (`sess_updated`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `visi_session`
--

INSERT INTO `visi_session` (`sess_id`, `sess_updated`, `sess_ip`, `sess_data`) VALUES
('5bc8399ab034a9a1c9d0314ea0352e86', 1211506510, '127.0.0.1', 'xoopsUserId|s:1:"1";xoopsUserGroups|a:4:{i:0;s:1:"1";i:1;s:1:"2";i:2;s:1:"5";i:3;s:1:"6";}xoopsUserTheme|s:7:"default";CREATE_STU_SESSION|a:11:{i:1;a:2:{s:2:"id";s:32:"338d9013ee334f668419c616416b9e3e";s:6:"expire";i:1211504751;}i:2;a:2:{s:2:"id";s:32:"9604592f804edfcc3325ae63fed26938";s:6:"expire";i:1211504919;}i:3;a:2:{s:2:"id";s:32:"c823dee3ea1107ca305b20a39b0c020a";s:6:"expire";i:1211504971;}i:4;a:2:{s:2:"id";s:32:"cbf446aee635dcd3c17b824876c440ac";s:6:"expire";i:1211505077;}i:5;a:2:{s:2:"id";s:32:"555309c1e82bec6f5870c56c78cb3161";s:6:"expire";i:1211505098;}i:6;a:2:{s:2:"id";s:32:"8457b0ac1687c44e4b47211d73b3eddb";s:6:"expire";i:1211505105;}i:7;a:2:{s:2:"id";s:32:"2a5d35b7378b9cab5c2422d19d59d4a9";s:6:"expire";i:1211505109;}i:8;a:2:{s:2:"id";s:32:"cdabd9831812eafd80e62b25379061f1";s:6:"expire";i:1211505113;}i:9;a:2:{s:2:"id";s:32:"4f5f6e454b72ca8116d8727baea6fe85";s:6:"expire";i:1211505212;}i:10;a:2:{s:2:"id";s:32:"d2fb49db8b74ed0561e7037dff7c4df1";s:6:"expire";i:1211505263;}i:11;a:2:{s:2:"id";s:32:"fff43317cdbcb07c2f6658f3a5eea933";s:6:"expire";i:1211505277;}}CREATE_ADD_SESSION|a:13:{i:0;a:2:{s:2:"id";s:32:"9d7f6f2d4c4f08b13eb82c655d1b25cd";s:6:"expire";i:1211504753;}i:1;a:2:{s:2:"id";s:32:"fbdd2038b5e033b56ed6e893a22af313";s:6:"expire";i:1211504798;}i:2;a:2:{s:2:"id";s:32:"8ca21974187d780c6bf619f0491beb07";s:6:"expire";i:1211504973;}i:3;a:2:{s:2:"id";s:32:"4ff24d2f9671350044344da14a37aa97";s:6:"expire";i:1211505023;}i:4;a:2:{s:2:"id";s:32:"76bc512765cf13e9979568e2a23debb6";s:6:"expire";i:1211505079;}i:5;a:2:{s:2:"id";s:32:"3a15fecfee4d6c4a41eb97fd53e9a647";s:6:"expire";i:1211505082;}i:6;a:2:{s:2:"id";s:32:"c15014316c114af26bce968d7b9b05f5";s:6:"expire";i:1211505087;}i:7;a:2:{s:2:"id";s:32:"ef19a45fd6b31c0ec788e7fcc0c760f5";s:6:"expire";i:1211505115;}i:8;a:2:{s:2:"id";s:32:"88da98ef6e0e60583f19b46507660c94";s:6:"expire";i:1211505118;}i:9;a:2:{s:2:"id";s:32:"e0f0c9e4d31629c04e8ea7bc4b145eb8";s:6:"expire";i:1211505123;}i:10;a:2:{s:2:"id";s:32:"b8ff91b37f79ad40f8fff7aec8c54e44";s:6:"expire";i:1211505214;}i:11;a:2:{s:2:"id";s:32:"6a2565f8666af440d82244047b38b3f7";s:6:"expire";i:1211505217;}i:12;a:2:{s:2:"id";s:32:"7fd571b77f622387bcbe7d4d7ca59b54";s:6:"expire";i:1211505248;}}CREATE_REGC_SESSION|a:5:{i:0;a:2:{s:2:"id";s:32:"38e3aa8341d01e2bf8219096966222fe";s:6:"expire";i:1211504815;}i:1;a:2:{s:2:"id";s:32:"36d01e1ae042112ef56bb7370efc16ba";s:6:"expire";i:1211504833;}i:2;a:2:{s:2:"id";s:32:"892d45b86f36ec8701fa38a78e112f15";s:6:"expire";i:1211504842;}i:3;a:2:{s:2:"id";s:32:"dabe193418968794763b0bebf4f94151";s:6:"expire";i:1211505040;}i:4;a:2:{s:2:"id";s:32:"f9459c14dae90f027eadc8da53cc435f";s:6:"expire";i:1211505048;}}CREATE_PAY_SESSION|a:2:{i:3;a:2:{s:2:"id";s:32:"b5732a342fdfb3d46cae53e9f7f804c6";s:6:"expire";i:1211504038;}i:4;a:2:{s:2:"id";s:32:"40955537b17af8bed6056f9ebfa7bdb5";s:6:"expire";i:1211504619;}}CREATE_STD_SESSION|a:5:{i:0;a:2:{s:2:"id";s:32:"7d819855fb8b7526325e5550aa8b0615";s:6:"expire";i:1211500796;}i:1;a:2:{s:2:"id";s:32:"79470780c4afd2dd97082e5322ec864d";s:6:"expire";i:1211500800;}i:2;a:2:{s:2:"id";s:32:"3815c6be6b36380e4d5d69cf0bfed900";s:6:"expire";i:1211500807;}i:3;a:2:{s:2:"id";s:32:"27f90b62f7bcc5edffd228ce274db4ea";s:6:"expire";i:1211500823;}i:4;a:2:{s:2:"id";s:32:"8bfa8d52d093d8029bc46039be5dbe3f";s:6:"expire";i:1211500828;}}CREATE_EMP_SESSION|a:9:{i:1;a:2:{s:2:"id";s:32:"18ce2f066eb59244d07b0c0bc0406eb5";s:6:"expire";i:1211502028;}i:2;a:2:{s:2:"id";s:32:"40e0877011ae41e08a1ac711918a6c07";s:6:"expire";i:1211502082;}i:3;a:2:{s:2:"id";s:32:"55e741cc8abee793447339607d46e1ba";s:6:"expire";i:1211502160;}i:4;a:2:{s:2:"id";s:32:"deb4951dbf4a4fb3125d892d14a200e7";s:6:"expire";i:1211502198;}i:5;a:2:{s:2:"id";s:32:"8c0e7fd376def78b68c52181bf176855";s:6:"expire";i:1211502212;}i:6;a:2:{s:2:"id";s:32:"01b50af5b2b7e66333bd26a2a111a573";s:6:"expire";i:1211502259;}i:7;a:2:{s:2:"id";s:32:"8852233fb1d3043f10f877b300246115";s:6:"expire";i:1211502298;}i:8;a:2:{s:2:"id";s:32:"440ea5bccad9e7e9ea28e83ad142bb7c";s:6:"expire";i:1211502326;}i:9;a:2:{s:2:"id";s:32:"238a1b69c8049391ece701fd052d43c0";s:6:"expire";i:1211502336;}}CREATE_CAT_SESSION|a:1:{i:0;a:2:{s:2:"id";s:32:"f7d49d01f79fea7c29be442592c02280";s:6:"expire";i:1211501863;}}CREATE_PRD_SESSION|a:3:{i:0;a:2:{s:2:"id";s:32:"f171271672f322da71a0fe6f28111bac";s:6:"expire";i:1211505354;}i:1;a:2:{s:2:"id";s:32:"321f64885853ead611e35c87f23b3963";s:6:"expire";i:1211505405;}i:2;a:2:{s:2:"id";s:32:"bee89a65dc024f77e5af650bbbdc0d7e";s:6:"expire";i:1211505434;}}CREATE_AREA_SESSION|a:1:{i:0;a:2:{s:2:"id";s:32:"b0cdb5ec8fa2f5006328e5f490adb950";s:6:"expire";i:1211504177;}}CREATE_TPT_SESSION|a:1:{i:0;a:2:{s:2:"id";s:32:"011e80264e0c1821b0c5593484a55890";s:6:"expire";i:1211502022;}}CREATE_CLASS_SESSION|a:3:{i:0;a:2:{s:2:"id";s:32:"19e42a43bbe7e6d324eac4710c6e13c4";s:6:"expire";i:1211504672;}i:1;a:2:{s:2:"id";s:32:"8f4a81e18d62b55036866fa380296885";s:6:"expire";i:1211504681;}i:2;a:2:{s:2:"id";s:32:"7ebe6d792ce91a7db67898610c2da53e";s:6:"expire";i:1211504690;}}XOOPS_TOKEN_SESSION|a:1:{i:0;a:2:{s:2:"id";s:32:"824d38ad71f1869e1a65613e8a641547";s:6:"expire";i:1211503993;}}CREATE_MVM_SESSION|a:12:{i:0;a:2:{s:2:"id";s:32:"7e55536bd82847fbde7aedc601d1b426";s:6:"expire";i:1211505423;}i:1;a:2:{s:2:"id";s:32:"8e4c4534c64eac67a6e50650e044bad2";s:6:"expire";i:1211505609;}i:2;a:2:{s:2:"id";s:32:"78442bacf3cd238e14031254eb7088a4";s:6:"expire";i:1211505614;}i:3;a:2:{s:2:"id";s:32:"fe73a28a0d41bae7ae71662fd6b892b3";s:6:"expire";i:1211505841;}i:4;a:2:{s:2:"id";s:32:"1bf2cbcde9e01b32d3e4ea9f56bd3b9f";s:6:"expire";i:1211505856;}i:5;a:2:{s:2:"id";s:32:"28a3706b51fdb17ac73d2737258be785";s:6:"expire";i:1211505873;}i:6;a:2:{s:2:"id";s:32:"3655ed54f9b7d97981bdd608e5303c5f";s:6:"expire";i:1211505878;}i:7;a:2:{s:2:"id";s:32:"0d0c427ab0ec90f28a858fac1717a50e";s:6:"expire";i:1211505922;}i:8;a:2:{s:2:"id";s:32:"03282ba80c65769c89ca5405df768d72";s:6:"expire";i:1211505926;}i:9;a:2:{s:2:"id";s:32:"33f35b3e0c5d25692737e9ce63baf94a";s:6:"expire";i:1211505931;}i:10;a:2:{s:2:"id";s:32:"282c4d87bea4463b4fa66d0d0e7276af";s:6:"expire";i:1211505942;}i:11;a:2:{s:2:"id";s:32:"b71453d7cd9edfe613ee72023eba8d56";s:6:"expire";i:1211505954;}}');

-- --------------------------------------------------------

--
-- Table structure for table `visi_simtrain_address`
--

DROP TABLE IF EXISTS `visi_simtrain_address`;
CREATE TABLE IF NOT EXISTS `visi_simtrain_address` (
  `address_id` int(11) NOT NULL auto_increment,
  `address_name` varchar(30) NOT NULL,
  `student_id` int(11) NOT NULL,
  `no` varchar(5) NOT NULL,
  `street1` text NOT NULL,
  `area_id` int(11) NOT NULL,
  `postcode` varchar(5) NOT NULL,
  `city` varchar(50) NOT NULL,
  `state` varchar(50) NOT NULL,
  `country` varchar(30) NOT NULL,
  `isactive` char(1) NOT NULL,
  `organization_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `createdby` int(11) NOT NULL,
  `updated` datetime NOT NULL,
  `updatedby` int(11) NOT NULL,
  `street2` varchar(255) NOT NULL,
  PRIMARY KEY  (`address_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `visi_simtrain_address`
--

INSERT INTO `visi_simtrain_address` (`address_id`, `address_name`, `student_id`, `no`, `street1`, `area_id`, `postcode`, `city`, `state`, `country`, `isactive`, `organization_id`, `created`, `createdby`, `updated`, `updatedby`, `street2`) VALUES
(1, 'ORG1', 0, '10B-1', 'Jalan Mawarr 4', 1, '81900', 'Kota Tinggi', 'Johor', 'Malaysia', 'Y', 0, '2008-05-15 09:47:33', 1, '2008-05-15 09:48:07', 1, '-'),
(2, 'ORG2', 0, '93', '-', 1, '81900', '-', '-', '-', 'Y', 0, '2008-05-15 09:48:57', 1, '2008-05-15 09:49:17', 1, '-'),
(3, '', 0, '', '', 1, '', '', '', '', 'Y', 0, '2008-05-15 09:50:19', 1, '2008-05-15 09:50:19', 1, ''),
(4, '', 0, '', '', 1, '', '', '', '', 'Y', 0, '2008-05-15 09:50:40', 1, '2008-05-15 09:50:40', 1, ''),
(5, '', 0, '', '', 1, '', '', '', '', 'Y', 0, '2008-05-15 09:51:18', 1, '2008-05-15 09:51:18', 1, ''),
(6, 'Home', 1, '78', 'Jalan Laksamana', 2, '81900', 'Kota Tinggi', 'Johor', 'Malaysia', 'Y', 0, '2008-05-15 16:35:37', 1, '2008-05-23 09:04:08', 1, 'Taman Kota Besar'),
(7, 'Home', 2, '10', 'Jalan Durian', 2, '81900', 'Kota Tinggi', 'Johor', 'Malaysia', 'Y', 0, '2008-05-16 09:43:02', 1, '2008-05-16 09:43:02', 1, 'Taman Kota Jaya'),
(8, 'Shop', 2, '99', 'Jalan Pisang', 3, '81900', 'Kota Tinggi', 'Johor', 'Malaysia', 'Y', 0, '2008-05-16 09:43:29', 1, '2008-05-16 09:43:29', 1, 'Taman Kota Besar'),
(9, 'Home', 3, '9B', 'Jalan Laksamana', 3, '81900', 'Kota Tinggi', 'Johor', 'Malaysia', 'Y', 0, '2008-05-16 09:51:59', 1, '2008-05-16 09:51:59', 1, '-'),
(10, 'School', 3, '6', 'Jalan Durian 5', 2, '81900', 'Kota Tinggi', 'Johor', 'Malaysia', 'Y', 0, '2008-05-16 09:52:31', 1, '2008-05-16 09:52:31', 1, 'Taman Kota Merdesa'),
(11, 'Home', 4, '10', 'Jalan Moihiong', 2, '83431', 'Johor Bahru', 'Johor', 'Malaysia', 'Y', 0, '2008-05-23 00:18:09', 1, '2008-05-23 00:18:09', 1, '-'),
(12, 'Home', 5, '55', 'Jalan Bakawali', 3, '81900', 'Johor Bahru', 'Johor', 'Malaysua', 'Y', 0, '2008-05-23 08:56:38', 1, '2008-05-23 09:02:02', 1, 'Taman Johor Jaya'),
(13, 'Home', 6, '59', 'Jalan Bakawali', 3, '81900', 'Johor Bahru', 'Johor', 'Malaysia', 'Y', 0, '2008-05-23 09:00:23', 1, '2008-05-23 09:01:27', 1, 'Taman Johor Jaya');

-- --------------------------------------------------------

--
-- Table structure for table `visi_simtrain_area`
--

DROP TABLE IF EXISTS `visi_simtrain_area`;
CREATE TABLE IF NOT EXISTS `visi_simtrain_area` (
  `area_id` int(11) NOT NULL auto_increment,
  `area_name` varchar(30) NOT NULL,
  `area_description` text NOT NULL,
  `organization_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `createdby` int(11) NOT NULL,
  `updated` datetime NOT NULL,
  `updatedby` int(11) NOT NULL,
  PRIMARY KEY  (`area_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `visi_simtrain_area`
--

INSERT INTO `visi_simtrain_area` (`area_id`, `area_name`, `area_description`, `organization_id`, `created`, `createdby`, `updated`, `updatedby`) VALUES
(1, 'Unknown', '-', 0, '2008-05-11 22:41:12', 1, '2008-05-14 22:32:54', 1),
(2, 'Zone A', 'Town,\r\nJln Tun Habab, \r\nTmn Kuso, \r\nTmn Kota Mas, \r\nKota Kecil,\r\nTmn Ria, \r\nTmn Hidayat, \r\nTmn Gunung Emas ', 0, '2008-05-11 22:41:32', 1, '2008-05-14 22:33:28', 1),
(3, 'Zone B', 'Tmn Mawai, Tmn Aman, Lukut Cina, Kg Makam ', 0, '2008-05-14 22:33:42', 1, '2008-05-14 22:33:42', 1),
(4, 'Zone C', 'Tmn Kota Jaya, Tmn Laksamana, Tmn Muhibbah ', 0, '2008-05-14 22:33:59', 1, '2008-05-14 22:33:59', 1),
(5, 'Zone D', 'Tmn Desa Riang, Kg Tembioh 	', 0, '2008-05-14 22:34:12', 1, '2008-05-14 22:34:12', 1),
(6, 'Zone E', 'Tmn Kota Besar, Tmn Sri Lalang, Tmn Ahmad Perang, Tmn Melati Putih 	', 0, '2008-05-14 22:34:20', 1, '2008-05-14 22:34:20', 1),
(7, 'Zone F', 'Tmn Kota Merdesa, Tmn Medan Jaya, Tmn Daiman Jaya, Tmn Kota Intan 	', 0, '2008-05-14 22:34:31', 1, '2008-05-14 22:34:31', 1),
(8, 'Zone G', 'Tmn Kota, Jln Lombong(Bt2 ke atas) 	', 0, '2008-05-14 22:34:40', 1, '2008-05-14 22:34:40', 1);

-- --------------------------------------------------------

--
-- Table structure for table `visi_simtrain_cashtransfer`
--

DROP TABLE IF EXISTS `visi_simtrain_cashtransfer`;
CREATE TABLE IF NOT EXISTS `visi_simtrain_cashtransfer` (
  `cashtransfer_id` int(11) NOT NULL auto_increment,
  `transferdatetime` datetime NOT NULL,
  `amt` float NOT NULL,
  `description` text NOT NULL,
  `organization_id` int(11) NOT NULL,
  `createdby` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `updatedby` int(11) NOT NULL,
  `updated` datetime NOT NULL,
  `fromuser_id` int(11) NOT NULL default '0',
  `cashtransfer_no` int(11) NOT NULL,
  `transport_amt` decimal(10,2) NOT NULL default '0.00',
  PRIMARY KEY  (`cashtransfer_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `visi_simtrain_cashtransfer`
--

INSERT INTO `visi_simtrain_cashtransfer` (`cashtransfer_id`, `transferdatetime`, `amt`, `description`, `organization_id`, `createdby`, `created`, `updatedby`, `updated`, `fromuser_id`, `cashtransfer_no`, `transport_amt`) VALUES
(1, '2008-05-15 16:43:11', 20, '', 1, 1, '2008-05-15 16:43:23', 1, '2008-05-15 16:43:23', 1, 1, 10.00);

-- --------------------------------------------------------

--
-- Table structure for table `visi_simtrain_cloneprocess`
--

DROP TABLE IF EXISTS `visi_simtrain_cloneprocess`;
CREATE TABLE IF NOT EXISTS `visi_simtrain_cloneprocess` (
  `clone_id` int(11) NOT NULL auto_increment,
  `periodfrom_id` int(11) NOT NULL,
  `type` char(1) NOT NULL,
  `created` datetime NOT NULL,
  `createdby` int(11) NOT NULL,
  `updated` datetime NOT NULL,
  `updatedby` int(11) NOT NULL,
  `status` varchar(10) NOT NULL,
  `organization_id` int(11) NOT NULL,
  `periodto_id` int(11) NOT NULL,
  `clonedclass_id` text NOT NULL,
  PRIMARY KEY  (`clone_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `visi_simtrain_cloneprocess`
--

INSERT INTO `visi_simtrain_cloneprocess` (`clone_id`, `periodfrom_id`, `type`, `created`, `createdby`, `updated`, `updatedby`, `status`, `organization_id`, `periodto_id`, `clonedclass_id`) VALUES
(1, 1, 'M', '2008-05-15 16:54:58', 1, '2008-05-16 09:46:43', 1, 'Reversed', 1, 2, '1'),
(2, 1, 'M', '2008-05-22 21:17:26', 1, '2008-05-23 08:51:59', 1, 'Reversed', 1, 2, '1,3,4'),
(3, 1, 'M', '2008-05-23 08:52:28', 1, '2008-05-23 08:52:28', 1, 'Complete', 1, 2, '1,3,4'),
(4, 1, 'M', '2008-05-23 08:52:35', 1, '2008-05-23 08:52:35', 1, 'Complete', 2, 2, '');

-- --------------------------------------------------------

--
-- Table structure for table `visi_simtrain_employee`
--

DROP TABLE IF EXISTS `visi_simtrain_employee`;
CREATE TABLE IF NOT EXISTS `visi_simtrain_employee` (
  `employee_id` int(11) NOT NULL auto_increment,
  `employee_no` varchar(8) NOT NULL,
  `employee_name` varchar(50) NOT NULL,
  `ic_no` varchar(20) NOT NULL,
  `gender` char(1) NOT NULL default 'M',
  `dateofbirth` date NOT NULL default '0000-00-00',
  `epf_no` varchar(15) NOT NULL,
  `socso_no` varchar(14) NOT NULL,
  `account_no` varchar(20) NOT NULL,
  `hp_no` varchar(16) NOT NULL,
  `tel_1` varchar(16) NOT NULL,
  `isactive` char(1) NOT NULL,
  `address_id` int(11) NOT NULL,
  `highestqualification` text NOT NULL,
  `highestteachlvl` text NOT NULL,
  `employeetype` varchar(20) NOT NULL default 'Full Time',
  `subjectsteach` text NOT NULL,
  `cashonhand` float NOT NULL,
  `organization_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `createdby` int(11) NOT NULL,
  `updated` datetime NOT NULL,
  `updatedby` int(11) NOT NULL,
  `uid` int(11) NOT NULL default '0',
  `races_id` int(1) NOT NULL,
  PRIMARY KEY  (`employee_id`),
  UNIQUE KEY `employee_no` (`employee_no`),
  UNIQUE KEY `ic_no` (`ic_no`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `visi_simtrain_employee`
--

INSERT INTO `visi_simtrain_employee` (`employee_id`, `employee_no`, `employee_name`, `ic_no`, `gender`, `dateofbirth`, `epf_no`, `socso_no`, `account_no`, `hp_no`, `tel_1`, `isactive`, `address_id`, `highestqualification`, `highestteachlvl`, `employeetype`, `subjectsteach`, `cashonhand`, `organization_id`, `created`, `createdby`, `updated`, `updatedby`, `uid`, `races_id`) VALUES
(1, '1', 'Tutor 1 org1', '12456676', 'F', '1980-01-01', '-', '-', '-', '-', '-', 'Y', 3, '', '', 'F', '', 0, 1, '2008-05-15 09:50:19', 1, '2008-05-15 09:50:57', 1, 0, 4),
(2, '2', 'Tutor 2 org2', '2', 'F', '2000-01-01', '', '', '', '', '', 'Y', 4, '', '', 'G', '', 0, 2, '2008-05-15 09:50:40', 1, '2008-05-15 09:50:48', 1, 0, 4),
(3, '3', 'Tutor 3 org1', '66', 'F', '1979-01-03', '', '', '', '', '', 'Y', 5, '', '', 'G', '', 0, 1, '2008-05-15 09:51:18', 1, '2008-05-15 09:51:18', 1, 0, 4);

-- --------------------------------------------------------

--
-- Table structure for table `visi_simtrain_inventorymovement`
--

DROP TABLE IF EXISTS `visi_simtrain_inventorymovement`;
CREATE TABLE IF NOT EXISTS `visi_simtrain_inventorymovement` (
  `movement_id` int(11) NOT NULL auto_increment,
  `movement_description` text NOT NULL,
  `createdby` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `updatedby` int(11) NOT NULL,
  `updated` datetime NOT NULL,
  `product_id` int(11) NOT NULL default '0',
  `quantity` int(11) NOT NULL,
  `movementdate` date NOT NULL,
  `organization_id` int(11) NOT NULL,
  `documentno` varchar(20) NOT NULL,
  `student_id` decimal(10,0) NOT NULL default '0',
  `requirepayment` char(1) NOT NULL default '1',
  PRIMARY KEY  (`movement_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `visi_simtrain_inventorymovement`
--

INSERT INTO `visi_simtrain_inventorymovement` (`movement_id`, `movement_description`, `createdby`, `created`, `updatedby`, `updated`, `product_id`, `quantity`, `movementdate`, `organization_id`, `documentno`, `student_id`, `requirepayment`) VALUES
(1, '', 1, '2008-05-15 16:46:34', 1, '2008-05-15 16:46:34', 3, -1, '2008-05-15', 1, 'iii', 1, 'Y'),
(2, '', 1, '2008-05-15 16:47:00', 1, '2008-05-15 16:47:00', 3, 5, '2008-05-15', 1, 'k', 0, 'N'),
(3, '', 1, '2008-05-23 09:14:16', 1, '2008-05-23 09:15:30', 6, 9, '2008-05-23', 1, 'DO001', 0, 'N'),
(4, '', 1, '2008-05-23 09:15:54', 1, '2008-05-23 09:15:54', 6, 7, '2008-05-23', 2, '99', 0, 'N');

-- --------------------------------------------------------

--
-- Table structure for table `visi_simtrain_organization`
--

DROP TABLE IF EXISTS `visi_simtrain_organization`;
CREATE TABLE IF NOT EXISTS `visi_simtrain_organization` (
  `organization_id` int(11) NOT NULL auto_increment,
  `organization_name` varchar(50) NOT NULL,
  `tel_1` varchar(16) NOT NULL,
  `tel_2` varchar(16) NOT NULL,
  `fax` varchar(16) NOT NULL,
  `website` varchar(50) NOT NULL,
  `contactemail` varchar(30) NOT NULL,
  `created` datetime NOT NULL,
  `createdby` int(11) NOT NULL,
  `updated` datetime NOT NULL,
  `updatedby` int(11) NOT NULL,
  `isactive` char(1) NOT NULL,
  `organization_code` varchar(10) NOT NULL,
  `address_id` int(11) NOT NULL default '0',
  `groupid` int(11) NOT NULL,
  `jpn_no` varchar(14) NOT NULL,
  `rob_no` varchar(14) NOT NULL,
  PRIMARY KEY  (`organization_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `visi_simtrain_organization`
--

INSERT INTO `visi_simtrain_organization` (`organization_id`, `organization_name`, `tel_1`, `tel_2`, `fax`, `website`, `contactemail`, `created`, `createdby`, `updated`, `updatedby`, `isactive`, `organization_code`, `address_id`, `groupid`, `jpn_no`, `rob_no`) VALUES
(1, 'Demo Organization 1', '012345678', '012345679', '012345679', 'http://www.simit.com.my', 'sales@simit.com.my', '2008-05-15 09:47:33', 1, '2008-05-15 09:49:36', 1, 'Y', 'ORG1', 1, 5, '45678', '12345'),
(2, 'Demo Organization 2', '0612345678', '0612345679', '0612345679', 'http://www.simit.com.my', 'sales@simit.com.my', '2008-05-15 09:48:57', 1, '2008-05-16 09:10:13', 1, 'Y', 'ORG2', 2, 6, '987656', '8765469');

-- --------------------------------------------------------

--
-- Table structure for table `visi_simtrain_payment`
--

DROP TABLE IF EXISTS `visi_simtrain_payment`;
CREATE TABLE IF NOT EXISTS `visi_simtrain_payment` (
  `payment_id` int(11) NOT NULL auto_increment,
  `payment_datetime` datetime NOT NULL,
  `receipt_no` int(10) NOT NULL,
  `receivedamt` decimal(10,2) NOT NULL default '0.00',
  `payment_description` text NOT NULL,
  `organization_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `createdby` int(11) NOT NULL,
  `updated` datetime NOT NULL,
  `updatedby` int(11) NOT NULL,
  `iscomplete` char(1) NOT NULL,
  `amt` decimal(12,2) NOT NULL default '0.00',
  `returnamt` decimal(12,2) NOT NULL default '0.00',
  `student_id` int(11) NOT NULL,
  `outstandingamt` decimal(10,2) NOT NULL default '0.00',
  PRIMARY KEY  (`payment_id`),
  UNIQUE KEY `receipt_no` (`receipt_no`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `visi_simtrain_payment`
--

INSERT INTO `visi_simtrain_payment` (`payment_id`, `payment_datetime`, `receipt_no`, `receivedamt`, `payment_description`, `organization_id`, `created`, `createdby`, `updated`, `updatedby`, `iscomplete`, `amt`, `returnamt`, `student_id`, `outstandingamt`) VALUES
(2, '2008-05-15 16:38:21', 1, 56.00, '', 1, '2008-05-15 16:38:40', 1, '2008-05-16 09:58:44', 1, 'Y', 56.00, 0.00, 1, 0.00),
(3, '2008-05-15 16:48:23', 2, 10.00, '', 1, '2008-05-15 16:48:32', 1, '2008-05-16 09:58:32', 1, 'Y', 10.00, 0.00, 1, 45.00),
(4, '2008-05-16 09:56:58', 3, 10.00, '', 1, '2008-05-16 09:57:02', 1, '2008-05-16 09:57:54', 1, 'Y', 10.00, 0.00, 1, 0.00),
(5, '2008-05-18 11:21:31', 4, 45.00, '', 1, '2008-05-18 11:21:35', 1, '2008-05-18 11:29:58', 1, 'Y', 45.00, 0.00, 1, 0.00),
(6, '2008-05-22 21:05:12', 5, 20.00, 'vsndgwmf cec emrcgerm cr', 1, '2008-05-22 21:05:40', 1, '2008-05-22 21:10:01', 1, 'Y', 17.00, 3.00, 2, 7.00),
(7, '2008-05-23 00:19:16', 6, 15.00, '', 2, '2008-05-23 00:19:21', 1, '2008-05-23 00:21:54', 1, 'Y', 15.00, 0.00, 4, 15.00);

-- --------------------------------------------------------

--
-- Table structure for table `visi_simtrain_paymentline`
--

DROP TABLE IF EXISTS `visi_simtrain_paymentline`;
CREATE TABLE IF NOT EXISTS `visi_simtrain_paymentline` (
  `paymentline_id` int(11) NOT NULL auto_increment,
  `studentclass_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `payment_id` int(11) NOT NULL,
  `linedescription` varchar(255) default NULL,
  `organization_id` int(11) NOT NULL,
  `createdby` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `updatedby` int(11) NOT NULL,
  `updated` datetime NOT NULL,
  `amt` decimal(10,2) NOT NULL default '0.00',
  `qty` int(11) NOT NULL,
  `unitprice` decimal(10,2) NOT NULL,
  `transportamt` decimal(10,2) NOT NULL default '0.00',
  `trainingamt` decimal(10,2) NOT NULL default '0.00',
  `payable` decimal(10,2) NOT NULL default '0.00' COMMENT 'A special column to indicate what is the outstanding amt, it updated everytime user updatepayment record',
  PRIMARY KEY  (`paymentline_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `visi_simtrain_paymentline`
--

INSERT INTO `visi_simtrain_paymentline` (`paymentline_id`, `studentclass_id`, `product_id`, `payment_id`, `linedescription`, `organization_id`, `createdby`, `created`, `updatedby`, `updated`, `amt`, `qty`, `unitprice`, `transportamt`, `trainingamt`, `payable`) VALUES
(2, 1, 0, 2, NULL, 1, 1, '2008-05-15 16:38:40', 1, '2008-05-15 16:38:40', 36.00, 1, 0.00, 10.00, 26.00, 36.00),
(3, 0, 2, 2, '', 1, 1, '2008-05-15 16:39:47', 1, '2008-05-15 16:39:47', 20.00, 2, 10.00, 0.00, 0.00, 0.00),
(4, 2, 0, 3, NULL, 1, 1, '2008-05-15 16:48:32', 1, '2008-05-15 16:48:32', 0.00, 1, 0.00, 0.00, 0.00, 20.00),
(5, 6, 0, 3, NULL, 1, 1, '2008-05-16 09:55:39', 1, '2008-05-16 09:55:39', 0.00, 0, 0.00, 0.00, 0.00, 25.00),
(6, 0, 2, 3, '', 1, 1, '2008-05-16 09:55:55', 1, '2008-05-16 09:55:55', 10.00, 1, 10.00, 0.00, 0.00, 0.00),
(9, 0, 5, 4, 'New Registration', 1, 1, '2008-05-16 09:57:13', 1, '2008-05-16 09:57:13', 10.00, 1, 10.00, 0.00, 0.00, 0.00),
(10, 6, 0, 5, NULL, 1, 1, '2008-05-18 11:21:35', 1, '2008-05-18 11:21:35', 25.00, 1, 0.00, 5.00, 20.00, 25.00),
(11, 2, 0, 5, NULL, 1, 1, '2008-05-18 11:21:35', 1, '2008-05-18 11:21:35', 20.00, 1, 0.00, 0.00, 20.00, 20.00),
(12, 7, 0, 6, NULL, 1, 1, '2008-05-22 21:05:40', 1, '2008-05-22 21:05:40', 17.00, 1, 0.00, 2.00, 15.00, 24.00),
(13, 12, 0, 7, NULL, 1, 1, '2008-05-23 00:19:21', 1, '2008-05-23 00:19:21', 15.00, 1, 0.00, 5.00, 10.00, 30.00);

-- --------------------------------------------------------

--
-- Table structure for table `visi_simtrain_period`
--

DROP TABLE IF EXISTS `visi_simtrain_period`;
CREATE TABLE IF NOT EXISTS `visi_simtrain_period` (
  `period_id` int(11) NOT NULL auto_increment,
  `period_name` varchar(20) NOT NULL,
  `created` datetime NOT NULL,
  `createdby` int(11) NOT NULL,
  `updated` datetime NOT NULL,
  `updatedby` int(11) NOT NULL,
  `organization_id` int(11) NOT NULL,
  `isactive` char(1) NOT NULL default 'Y',
  `year` int(4) NOT NULL default '0',
  `month` int(2) NOT NULL default '0',
  `period_description` varchar(14) default NULL,
  `period_description2` varchar(14) default NULL,
  PRIMARY KEY  (`period_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `visi_simtrain_period`
--

INSERT INTO `visi_simtrain_period` (`period_id`, `period_name`, `created`, `createdby`, `updated`, `updatedby`, `organization_id`, `isactive`, `year`, `month`, `period_description`, `period_description2`) VALUES
(1, '2008-05', '2008-05-11 23:16:11', 1, '2008-05-12 09:35:26', 10, 0, 'Y', 2008, 5, NULL, NULL),
(2, '2008-06', '2008-05-11 23:16:24', 1, '2008-05-12 09:35:12', 10, 0, 'Y', 2008, 6, NULL, NULL),
(3, '2008-07', '2008-05-11 23:16:43', 1, '2008-05-12 09:35:19', 10, 0, 'Y', 2008, 7, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `visi_simtrain_productcategory`
--

DROP TABLE IF EXISTS `visi_simtrain_productcategory`;
CREATE TABLE IF NOT EXISTS `visi_simtrain_productcategory` (
  `category_id` int(11) NOT NULL auto_increment,
  `category_code` varchar(20) NOT NULL,
  `category_description` text NOT NULL,
  `isactive` char(1) NOT NULL,
  `organization_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `createdby` int(11) NOT NULL,
  `updated` date NOT NULL,
  `updatedby` int(11) NOT NULL,
  `isitem` char(1) NOT NULL default 'N',
  PRIMARY KEY  (`category_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `visi_simtrain_productcategory`
--

INSERT INTO `visi_simtrain_productcategory` (`category_id`, `category_code`, `category_description`, `isactive`, `organization_id`, `created`, `createdby`, `updated`, `updatedby`, `isitem`) VALUES
(1, 'CLASS', 'Tuition Class', 'Y', 1, '2008-05-11 23:09:23', 1, '2008-05-11', 1, 'C'),
(2, 'STOCK', 'Control Stock Items', 'Y', 1, '2008-05-11 23:09:41', 1, '2008-05-11', 1, 'Y'),
(3, 'CHARGE', 'All kind of charges', 'Y', 1, '2008-05-11 23:10:02', 1, '2008-05-12', 1, 'N');

-- --------------------------------------------------------

--
-- Table structure for table `visi_simtrain_productlist`
--

DROP TABLE IF EXISTS `visi_simtrain_productlist`;
CREATE TABLE IF NOT EXISTS `visi_simtrain_productlist` (
  `product_id` int(11) NOT NULL auto_increment,
  `product_no` varchar(20) NOT NULL,
  `product_name` varchar(50) NOT NULL,
  `description` varchar(50) NOT NULL,
  `category_id` int(11) NOT NULL,
  `standard_id` int(11) NOT NULL,
  `amt` decimal(10,2) NOT NULL,
  `weeklyfees` decimal(10,2) NOT NULL,
  `organization_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `createdby` int(11) NOT NULL,
  `updated` datetime NOT NULL,
  `updatedby` int(11) NOT NULL,
  `isactive` char(1) NOT NULL,
  `qty` int(11) NOT NULL default '0',
  `filename` varchar(50) NOT NULL,
  PRIMARY KEY  (`product_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `visi_simtrain_productlist`
--

INSERT INTO `visi_simtrain_productlist` (`product_id`, `product_no`, `product_name`, `description`, `category_id`, `standard_id`, `amt`, `weeklyfees`, `organization_id`, `created`, `createdby`, `updated`, `updatedby`, `isactive`, `qty`, `filename`) VALUES
(1, 'BMF5', 'BMForm 5', 'r', 1, 3, 40.00, 0.00, 1, '2008-05-15 09:54:59', 1, '2008-05-16 09:46:25', 1, 'Y', 0, ''),
(2, 'PTBM01', 'PHOTOSTAT BM001', '-', 3, 1, 10.00, 0.00, 1, '2008-05-15 16:29:39', 1, '2008-05-16 09:56:29', 1, 'Y', 0, ''),
(3, 'Book', 'BM For Form 4(Longman)', '', 2, 2, 20.00, 0.00, 1, '2008-05-15 16:45:32', 1, '2008-05-23 09:11:02', 1, 'Y', 0, ''),
(4, 'BMF4', 'BMForm 4', '', 1, 4, 40.00, 0.00, 1, '2008-05-16 09:45:00', 1, '2008-05-16 09:46:04', 1, 'Y', 0, ''),
(5, 'ENR', 'Enrollment Fees', '', 3, 1, 10.00, 0.00, 1, '2008-05-16 09:56:48', 1, '2008-05-16 09:56:48', 1, 'Y', 0, ''),
(6, 'BBIF4', 'BI For Form 4(Sasbadi)', '', 2, 4, 12.00, 0.00, 1, '2008-05-23 09:15:13', 1, '2008-05-23 09:15:13', 1, 'Y', 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `visi_simtrain_qryfeestransaction`
--

DROP TABLE IF EXISTS `visi_simtrain_qryfeestransaction`;
CREATE TABLE IF NOT EXISTS `visi_simtrain_qryfeestransaction` (
  `uid` mediumint(8) unsigned default NULL,
  `uname` varchar(25) default NULL,
  `student_name` varchar(50) default NULL,
  `payment_datetime` datetime default NULL,
  `fees` double default NULL,
  `transportamt` decimal(32,2) default NULL,
  `returnamt` decimal(18,2) default NULL,
  `docno` int(11) default NULL,
  `type` varchar(1) default NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `visi_simtrain_qryfeestransaction`
--


-- --------------------------------------------------------

--
-- Table structure for table `visi_simtrain_qryinventorymovement`
--

DROP TABLE IF EXISTS `visi_simtrain_qryinventorymovement`;
CREATE TABLE IF NOT EXISTS `visi_simtrain_qryinventorymovement` (
  `product_id` int(11) default NULL,
  `product_name` varchar(50) default NULL,
  `qty` bigint(12) default NULL,
  `documentno` varbinary(20) default NULL,
  `date` date default NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `visi_simtrain_qryinventorymovement`
--


-- --------------------------------------------------------

--
-- Table structure for table `visi_simtrain_races`
--

DROP TABLE IF EXISTS `visi_simtrain_races`;
CREATE TABLE IF NOT EXISTS `visi_simtrain_races` (
  `races_id` int(11) NOT NULL auto_increment,
  `races_name` varchar(20) NOT NULL,
  `isactive` char(1) NOT NULL,
  `organization_id` int(11) NOT NULL,
  `updated` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `updatedby` int(11) NOT NULL,
  `created` timestamp NOT NULL default '0000-00-00 00:00:00',
  `createdby` int(11) NOT NULL,
  `races_description` varchar(255) NOT NULL,
  PRIMARY KEY  (`races_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `visi_simtrain_races`
--

INSERT INTO `visi_simtrain_races` (`races_id`, `races_name`, `isactive`, `organization_id`, `updated`, `updatedby`, `created`, `createdby`, `races_description`) VALUES
(1, 'Unknown', 'Y', 1, '2008-05-14 22:39:54', 1, '2008-05-11 23:05:03', 1, '-'),
(2, 'Malay', 'Y', 1, '2008-05-11 23:05:17', 1, '2008-05-11 23:05:17', 1, 'Malay'),
(3, 'India', 'Y', 1, '2008-05-11 23:05:25', 1, '2008-05-11 23:05:25', 1, 'India'),
(4, 'Chinese', 'Y', 1, '2008-05-14 22:40:06', 1, '2008-05-11 23:05:37', 1, '-');

-- --------------------------------------------------------

--
-- Table structure for table `visi_simtrain_school`
--

DROP TABLE IF EXISTS `visi_simtrain_school`;
CREATE TABLE IF NOT EXISTS `visi_simtrain_school` (
  `school_id` int(11) NOT NULL auto_increment,
  `school_name` varchar(30) NOT NULL,
  `school_description` varchar(255) NOT NULL,
  `isactive` char(1) NOT NULL default 'Y',
  `organization_id` int(11) NOT NULL,
  `updated` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `updatedby` int(11) NOT NULL,
  `created` timestamp NOT NULL default '0000-00-00 00:00:00',
  `createdby` int(11) NOT NULL,
  PRIMARY KEY  (`school_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `visi_simtrain_school`
--

INSERT INTO `visi_simtrain_school` (`school_id`, `school_name`, `school_description`, `isactive`, `organization_id`, `updated`, `updatedby`, `created`, `createdby`) VALUES
(1, 'Unknown', '-', 'Y', 1, '2008-05-14 22:36:46', 1, '2008-05-11 23:06:05', 1),
(2, 'Pei Hua', 'Sek Men Pei Hua', 'Y', 1, '2008-05-11 23:06:22', 1, '2008-05-11 23:06:22', 1),
(3, 'New Kota', 'New Kota', 'Y', 1, '2008-05-19 12:56:21', 1, '2008-05-19 12:56:21', 1);

-- --------------------------------------------------------

--
-- Table structure for table `visi_simtrain_standard`
--

DROP TABLE IF EXISTS `visi_simtrain_standard`;
CREATE TABLE IF NOT EXISTS `visi_simtrain_standard` (
  `standard_id` int(11) NOT NULL auto_increment,
  `standard_name` varchar(30) NOT NULL,
  `standard_description` varchar(255) NOT NULL,
  `isactive` char(1) NOT NULL default 'Y',
  `organization_id` int(11) NOT NULL,
  `created` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `createdby` int(11) NOT NULL,
  `updated` timestamp NOT NULL default '0000-00-00 00:00:00',
  `updatedby` int(11) NOT NULL,
  PRIMARY KEY  (`standard_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `visi_simtrain_standard`
--

INSERT INTO `visi_simtrain_standard` (`standard_id`, `standard_name`, `standard_description`, `isactive`, `organization_id`, `created`, `createdby`, `updated`, `updatedby`) VALUES
(1, 'Unknown', '-', 'Y', 1, '2008-05-14 22:39:23', 1, '2008-05-14 22:39:23', 1),
(2, 'STD1', 'Standard 1', 'Y', 1, '2008-05-15 09:52:23', 1, '2008-05-15 09:52:23', 1),
(3, 'STD5', '', 'Y', 1, '2008-05-16 09:45:10', 1, '2008-05-16 09:45:10', 1),
(4, 'STD4', '', 'Y', 1, '2008-05-16 09:45:16', 1, '2008-05-16 09:45:16', 1);

-- --------------------------------------------------------

--
-- Table structure for table `visi_simtrain_student`
--

DROP TABLE IF EXISTS `visi_simtrain_student`;
CREATE TABLE IF NOT EXISTS `visi_simtrain_student` (
  `student_id` int(11) NOT NULL auto_increment,
  `student_code` varchar(8) NOT NULL,
  `student_name` varchar(50) NOT NULL,
  `dateofbirth` date NOT NULL default '0000-00-00',
  `gender` char(1) NOT NULL default 'M',
  `ic_no` varchar(20) NOT NULL,
  `school_id` int(11) NOT NULL,
  `hp_no` varchar(30) NOT NULL,
  `tel_1` varchar(30) NOT NULL,
  `tel_2` varchar(16) NOT NULL,
  `parent_name` varchar(50) NOT NULL,
  `parent_tel` varchar(16) NOT NULL,
  `isactive` char(1) NOT NULL,
  `organization_id` int(11) NOT NULL,
  `updated` datetime NOT NULL,
  `updatedby` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `createdby` int(11) NOT NULL,
  `standard_id` int(11) NOT NULL,
  `races_id` int(11) NOT NULL,
  `description` varchar(255) NOT NULL,
  `email` varchar(50) NOT NULL,
  `web` varchar(100) NOT NULL,
  PRIMARY KEY  (`student_id`),
  UNIQUE KEY `student_code` (`student_code`),
  UNIQUE KEY `ic_no` (`ic_no`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `visi_simtrain_student`
--

INSERT INTO `visi_simtrain_student` (`student_id`, `student_code`, `student_name`, `dateofbirth`, `gender`, `ic_no`, `school_id`, `hp_no`, `tel_1`, `tel_2`, `parent_name`, `parent_tel`, `isactive`, `organization_id`, `updated`, `updatedby`, `created`, `createdby`, `standard_id`, `races_id`, `description`, `email`, `web`) VALUES
(1, '800002', 'Boo Mei Ling', '1998-05-13', 'F', '76758', 2, '012-7895874', '078876553', '', '', '', 'Y', 2, '2008-05-23 09:04:37', 1, '2008-05-15 09:51:41', 1, 4, 4, '', '', ''),
(2, '800003', 'Amin Bin Ahmad', '1995-01-01', 'M', '888', 3, '01236578458', '0734557458', '0762534675', 'Ahmad Bin Rosli', '0198674593', 'Y', 1, '2008-05-23 07:59:32', 1, '2008-05-15 16:27:30', 1, 4, 2, '-', 'amin@testing.com', 'http://www.testing.com.my'),
(3, '800004', 'Alibaba', '1979-01-01', 'F', '767583', 2, '0127654321', '071234567', '-', '-', '-', 'N', 1, '2008-05-23 08:03:49', 1, '2008-05-16 09:44:28', 1, 2, 4, '-', '-', '--'),
(4, '800001', 'Tan Hong Yu', '1996-12-31', 'M', '961231-01-4567', 2, '0195456434', '07-1235653', '-', 'Tan Hong Jang', '0124567423', 'Y', 2, '2008-05-23 00:17:05', 1, '2008-05-23 00:17:05', 1, 4, 4, '-', '-', '-'),
(5, '800005', 'Tan Kian Heng', '1980-04-01', 'M', '800401-01-8765', 3, '012-78656473', '07-7649234', '-', 'Mr. Tan Jong King', '019-78362344', 'Y', 1, '2008-05-23 08:55:50', 1, '2008-05-23 08:55:50', 1, 2, 4, '-', '-', '-'),
(6, '800006', 'Mohd Ali Bin Abdul', '1991-06-02', 'M', '910602-01-1233', 2, '-', '-', '-', '-', '-', 'Y', 1, '2008-05-23 08:59:31', 1, '2008-05-23 08:59:31', 1, 4, 2, '-', '-', '-');

-- --------------------------------------------------------

--
-- Table structure for table `visi_simtrain_studentclass`
--

DROP TABLE IF EXISTS `visi_simtrain_studentclass`;
CREATE TABLE IF NOT EXISTS `visi_simtrain_studentclass` (
  `studentclass_id` int(11) NOT NULL auto_increment,
  `student_id` int(11) NOT NULL,
  `tuitionclass_id` int(11) NOT NULL default '0',
  `std_form` varchar(50) NOT NULL,
  `isactive` char(1) NOT NULL,
  `comeactive` char(1) NOT NULL,
  `backactive` char(1) NOT NULL,
  `amt` decimal(10,2) NOT NULL,
  `paidamt` decimal(10,2) NOT NULL,
  `transportfees` decimal(10,2) NOT NULL,
  `comeareafrom_id` int(11) NOT NULL,
  `comeareato_id` int(11) NOT NULL,
  `ispaid` char(1) NOT NULL,
  `transactiondate` date NOT NULL,
  `backareafrom_id` int(11) NOT NULL,
  `backareato_id` int(11) NOT NULL,
  `transportationmethod` varchar(5) NOT NULL,
  `organization_id` int(11) NOT NULL,
  `createdby` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `updatedby` int(11) NOT NULL,
  `updated` datetime NOT NULL,
  `clone_id` int(11) NOT NULL,
  `futuretrainingfees` decimal(10,2) NOT NULL default '0.00',
  `futuretransportfees` decimal(10,2) NOT NULL default '0.00',
  `races` char(1) NOT NULL default 'C',
  `movement_id` int(11) NOT NULL default '0',
  `description` varchar(255) NOT NULL,
  PRIMARY KEY  (`studentclass_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

--
-- Dumping data for table `visi_simtrain_studentclass`
--

INSERT INTO `visi_simtrain_studentclass` (`studentclass_id`, `student_id`, `tuitionclass_id`, `std_form`, `isactive`, `comeactive`, `backactive`, `amt`, `paidamt`, `transportfees`, `comeareafrom_id`, `comeareato_id`, `ispaid`, `transactiondate`, `backareafrom_id`, `backareato_id`, `transportationmethod`, `organization_id`, `createdby`, `created`, `updatedby`, `updated`, `clone_id`, `futuretrainingfees`, `futuretransportfees`, `races`, `movement_id`, `description`) VALUES
(1, 1, 1, '', 'Y', 'Y', 'Y', 26.00, 0.00, 10.00, 6, 0, '', '2008-05-15', 0, 6, '', 1, 1, '2008-05-15 16:36:43', 1, '2008-05-15 16:53:09', 0, 2.00, 20.00, 'C', 0, ''),
(2, 1, 0, '', 'N', '', '', 20.00, 0.00, 0.00, 0, 0, '', '2008-05-15', 0, 0, '', 1, 1, '2008-05-15 16:48:11', 1, '2008-05-15 16:48:11', 0, 0.00, 0.00, 'C', 1, ''),
(4, 3, 4, '', 'Y', 'Y', 'Y', 40.00, 0.00, 10.00, 9, 0, '', '2008-05-16', 0, 10, '', 1, 1, '2008-05-16 09:54:14', 1, '2008-05-16 09:54:14', 0, 40.00, 10.00, 'C', 0, ''),
(6, 1, 3, '', 'Y', 'Y', 'N', 20.00, 0.00, 5.00, 6, 0, '', '2008-05-16', 0, 6, '', 1, 1, '2008-05-16 09:55:07', 1, '2008-05-16 09:55:23', 0, 40.00, 10.00, 'C', 0, ''),
(7, 2, 1, '', 'Y', 'Y', 'Y', 20.00, 0.00, 4.00, 7, 0, '', '2008-05-22', 0, 7, '', 1, 1, '2008-05-22 21:00:48', 1, '2008-05-22 21:03:34', 0, 40.00, 10.00, 'C', 0, ''),
(18, 3, 10, '', 'Y', 'Y', 'Y', 40.00, 0.00, 10.00, 9, 0, 'N', '2008-06-01', 0, 10, '', 1, 1, '2008-05-23 08:52:28', 1, '2008-05-23 08:52:28', 3, 40.00, 10.00, 'C', 0, ''),
(17, 1, 9, '', 'Y', 'Y', 'N', 40.00, 0.00, 10.00, 6, 0, 'N', '2008-06-01', 0, 6, '', 1, 1, '2008-05-23 08:52:28', 1, '2008-05-23 08:52:28', 3, 40.00, 10.00, 'C', 0, ''),
(16, 2, 8, '', 'Y', 'Y', 'Y', 40.00, 0.00, 10.00, 7, 0, 'N', '2008-06-01', 0, 7, '', 1, 1, '2008-05-23 08:52:28', 1, '2008-05-23 08:52:28', 3, 40.00, 10.00, 'C', 0, ''),
(15, 1, 8, '', 'Y', 'Y', 'Y', 2.00, 0.00, 20.00, 6, 0, 'N', '2008-06-01', 0, 6, '', 1, 1, '2008-05-23 08:52:28', 1, '2008-05-23 08:52:28', 3, 2.00, 20.00, 'C', 0, ''),
(14, 1, 7, '', 'Y', 'N', 'N', 40.00, 0.00, 0.00, 6, 0, '', '2008-05-23', 0, 6, '', 1, 1, '2008-05-23 08:37:44', 1, '2008-05-23 08:37:44', 0, 40.00, 0.00, 'C', 0, ''),
(13, 4, 7, '', 'Y', 'Y', 'N', 40.00, 0.00, 10.00, 11, 0, '', '2008-05-23', 0, 11, '', 1, 1, '2008-05-23 08:36:43', 1, '2008-05-23 08:36:43', 0, 40.00, 10.00, 'C', 0, ''),
(19, 5, 10, '', 'Y', 'Y', 'Y', 40.00, 0.00, 0.00, 12, 0, '', '2008-05-23', 0, 12, '', 1, 1, '2008-05-23 08:57:21', 1, '2008-05-23 08:57:21', 0, 40.00, 0.00, 'C', 0, ''),
(20, 6, 10, '', 'Y', 'Y', 'Y', 40.00, 0.00, 0.00, 13, 0, '', '2008-05-23', 0, 13, '', 1, 1, '2008-05-23 09:00:47', 1, '2008-05-23 09:00:47', 0, 40.00, 0.00, 'C', 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `visi_simtrain_transport`
--

DROP TABLE IF EXISTS `visi_simtrain_transport`;
CREATE TABLE IF NOT EXISTS `visi_simtrain_transport` (
  `transport_id` int(11) NOT NULL auto_increment,
  `transport_code` varchar(10) NOT NULL,
  `area_id` int(11) NOT NULL,
  `doubletrip_fees` decimal(10,2) NOT NULL,
  `singletrip_fees` decimal(10,2) NOT NULL,
  `organization_id` int(11) NOT NULL,
  `isactive` char(1) NOT NULL,
  `createdby` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `updatedby` int(11) NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY  (`transport_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `visi_simtrain_transport`
--

INSERT INTO `visi_simtrain_transport` (`transport_id`, `transport_code`, `area_id`, `doubletrip_fees`, `singletrip_fees`, `organization_id`, `isactive`, `createdby`, `created`, `updatedby`, `updated`) VALUES
(1, 'A-O1', 2, 20.00, 10.00, 1, 'Y', 1, '2008-05-15 16:31:09', 1, '2008-05-16 09:52:51'),
(2, 'B-O1', 3, 13.00, 7.00, 2, 'Y', 1, '2008-05-16 09:53:08', 1, '2008-05-16 09:53:53'),
(3, 'A-O2', 2, 10.00, 5.00, 1, 'Y', 1, '2008-05-16 09:53:31', 1, '2008-05-16 09:53:31'),
(4, 'B-O1', 3, 10.00, 6.00, 2, 'Y', 1, '2008-05-16 09:53:46', 1, '2008-05-16 09:53:46');

-- --------------------------------------------------------

--
-- Table structure for table `visi_simtrain_tuitionclass`
--

DROP TABLE IF EXISTS `visi_simtrain_tuitionclass`;
CREATE TABLE IF NOT EXISTS `visi_simtrain_tuitionclass` (
  `tuitionclass_id` int(11) NOT NULL auto_increment,
  `product_id` int(11) NOT NULL,
  `period_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `description` text NOT NULL,
  `day` char(3) NOT NULL,
  `starttime` char(4) NOT NULL,
  `attachmenturl` text,
  `isactive` char(1) NOT NULL,
  `endtime` char(4) NOT NULL,
  `organization_id` int(11) NOT NULL,
  `createdby` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `updatedby` int(11) NOT NULL,
  `updated` datetime NOT NULL,
  `clone_id` int(11) NOT NULL default '0',
  `tuitionclass_code` varchar(20) NOT NULL,
  `nextclone_id` int(11) NOT NULL default '0',
  `hours` decimal(3,1) NOT NULL default '0.0',
  PRIMARY KEY  (`tuitionclass_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `visi_simtrain_tuitionclass`
--

INSERT INTO `visi_simtrain_tuitionclass` (`tuitionclass_id`, `product_id`, `period_id`, `employee_id`, `description`, `day`, `starttime`, `attachmenturl`, `isactive`, `endtime`, `organization_id`, `createdby`, `created`, `updatedby`, `updated`, `clone_id`, `tuitionclass_code`, `nextclone_id`, `hours`) VALUES
(1, 1, 1, 1, '', 'MON', '1200', NULL, 'N', '1330', 1, 1, '2008-05-15 16:33:04', 1, '2008-05-15 16:33:04', 0, 'BMF5_1', 3, 1.5),
(3, 1, 1, 2, 'BMForm 5', 'TUE', '1600', NULL, 'N', '1800', 1, 1, '2008-05-16 09:47:13', 1, '2008-05-16 09:48:22', 0, 'BMF5_2', 3, 2.0),
(4, 4, 1, 1, 'BMForm 4', 'THU', '1200', NULL, 'N', '1330', 1, 1, '2008-05-16 09:47:50', 1, '2008-05-22 21:19:15', 0, 'BMF4_1', 3, 1.5),
(9, 1, 2, 2, 'BMForm 5', 'TUE', '1600', NULL, 'Y', '1800', 1, 1, '2008-05-23 08:52:28', 1, '2008-05-23 08:52:28', 3, 'BMF5_2', 0, 2.0),
(8, 1, 2, 1, '', 'MON', '1400', NULL, 'Y', '1530', 1, 1, '2008-05-23 08:52:28', 1, '2008-05-23 09:02:49', 3, 'BMF5_1', 0, 1.5),
(10, 4, 2, 1, 'BMForm 4', 'MON', '1200', NULL, 'Y', '1330', 1, 1, '2008-05-23 08:52:28', 1, '2008-05-23 08:58:00', 3, 'BMF4_1', 0, 1.5);

-- --------------------------------------------------------

--
-- Table structure for table `visi_smiles`
--

DROP TABLE IF EXISTS `visi_smiles`;
CREATE TABLE IF NOT EXISTS `visi_smiles` (
  `id` smallint(5) unsigned NOT NULL auto_increment,
  `code` varchar(50) NOT NULL default '',
  `smile_url` varchar(100) NOT NULL default '',
  `emotion` varchar(75) NOT NULL default '',
  `display` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

--
-- Dumping data for table `visi_smiles`
--

INSERT INTO `visi_smiles` (`id`, `code`, `smile_url`, `emotion`, `display`) VALUES
(1, ':-D', 'smil3dbd4d4e4c4f2.gif', 'Very Happy', 1),
(2, ':-)', 'smil3dbd4d6422f04.gif', 'Smile', 1),
(3, ':-(', 'smil3dbd4d75edb5e.gif', 'Sad', 1),
(4, ':-o', 'smil3dbd4d8676346.gif', 'Surprised', 1),
(5, ':-?', 'smil3dbd4d99c6eaa.gif', 'Confused', 1),
(6, '8-)', 'smil3dbd4daabd491.gif', 'Cool', 1),
(7, ':lol:', 'smil3dbd4dbc14f3f.gif', 'Laughing', 1),
(8, ':-x', 'smil3dbd4dcd7b9f4.gif', 'Mad', 1),
(9, ':-P', 'smil3dbd4ddd6835f.gif', 'Razz', 1),
(10, ':oops:', 'smil3dbd4df1944ee.gif', 'Embaressed', 0),
(11, ':cry:', 'smil3dbd4e02c5440.gif', 'Crying (very sad)', 0),
(12, ':evil:', 'smil3dbd4e1748cc9.gif', 'Evil or Very Mad', 0),
(13, ':roll:', 'smil3dbd4e29bbcc7.gif', 'Rolling Eyes', 0),
(14, ';-)', 'smil3dbd4e398ff7b.gif', 'Wink', 0),
(15, ':pint:', 'smil3dbd4e4c2e742.gif', 'Another pint of beer', 0),
(16, ':hammer:', 'smil3dbd4e5e7563a.gif', 'ToolTimes at work', 0),
(17, ':idea:', 'smil3dbd4e7853679.gif', 'I have an idea', 0);

-- --------------------------------------------------------

--
-- Table structure for table `visi_tplfile`
--

DROP TABLE IF EXISTS `visi_tplfile`;
CREATE TABLE IF NOT EXISTS `visi_tplfile` (
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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=28 ;

--
-- Dumping data for table `visi_tplfile`
--

INSERT INTO `visi_tplfile` (`tpl_id`, `tpl_refid`, `tpl_module`, `tpl_tplset`, `tpl_file`, `tpl_desc`, `tpl_lastmodified`, `tpl_lastimported`, `tpl_type`) VALUES
(1, 1, 'system', 'default', 'system_imagemanager.html', '', 1205985656, 1205985656, 'module'),
(2, 1, 'system', 'default', 'system_imagemanager2.html', '', 1205985656, 1205985656, 'module'),
(3, 1, 'system', 'default', 'system_userinfo.html', '', 1205985656, 1205985656, 'module'),
(4, 1, 'system', 'default', 'system_userform.html', '', 1205985656, 1205985656, 'module'),
(5, 1, 'system', 'default', 'system_rss.html', '', 1205985656, 1205985656, 'module'),
(6, 1, 'system', 'default', 'system_redirect.html', '', 1205985656, 1205985656, 'module'),
(7, 1, 'system', 'default', 'system_comment.html', '', 1205985656, 1205985656, 'module'),
(8, 1, 'system', 'default', 'system_comments_flat.html', '', 1205985656, 1205985656, 'module'),
(9, 1, 'system', 'default', 'system_comments_thread.html', '', 1205985656, 1205985656, 'module'),
(10, 1, 'system', 'default', 'system_comments_nest.html', '', 1205985656, 1205985656, 'module'),
(11, 1, 'system', 'default', 'system_siteclosed.html', '', 1205985656, 1205985656, 'module'),
(12, 1, 'system', 'default', 'system_dummy.html', 'Dummy template file for holding non-template contents. This should not be edited.', 1205985656, 1205985656, 'module'),
(13, 1, 'system', 'default', 'system_notification_list.html', '', 1205985656, 1205985656, 'module'),
(14, 1, 'system', 'default', 'system_notification_select.html', '', 1205985656, 1205985656, 'module'),
(15, 1, 'system', 'default', 'system_block_dummy.html', 'Dummy template for custom blocks or blocks without templates', 1205985656, 1205985656, 'module'),
(16, 1, 'system', 'default', 'system_block_user.html', 'Shows user block', 1205985656, 1205985656, 'block'),
(17, 2, 'system', 'default', 'system_block_login.html', 'Shows login form', 1205985656, 1205985656, 'block'),
(18, 3, 'system', 'default', 'system_block_search.html', 'Shows search form block', 1205985656, 1205985656, 'block'),
(19, 4, 'system', 'default', 'system_block_waiting.html', 'Shows contents waiting for approval', 1205985656, 1205985656, 'block'),
(20, 5, 'system', 'default', 'system_block_mainmenu.html', 'Shows the main navigation menu of the site', 1205985656, 1205985656, 'block'),
(21, 6, 'system', 'default', 'system_block_siteinfo.html', 'Shows basic info about the site and a link to Recommend Us pop up window', 1205985656, 1205985656, 'block'),
(22, 7, 'system', 'default', 'system_block_online.html', 'Displays users/guests currently online', 1205985656, 1205985656, 'block'),
(23, 8, 'system', 'default', 'system_block_topusers.html', 'Top posters', 1205985656, 1205985656, 'block'),
(24, 9, 'system', 'default', 'system_block_newusers.html', 'Shows most recent users', 1205985656, 1205985656, 'block'),
(25, 10, 'system', 'default', 'system_block_comments.html', 'Shows most recent comments', 1205985656, 1205985656, 'block'),
(26, 11, 'system', 'default', 'system_block_notification.html', 'Shows notification options', 1205985656, 1205985656, 'block'),
(27, 12, 'system', 'default', 'system_block_themes.html', 'Shows theme selection box', 1205985656, 1205985656, 'block');

-- --------------------------------------------------------

--
-- Table structure for table `visi_tplset`
--

DROP TABLE IF EXISTS `visi_tplset`;
CREATE TABLE IF NOT EXISTS `visi_tplset` (
  `tplset_id` int(7) unsigned NOT NULL auto_increment,
  `tplset_name` varchar(50) NOT NULL default '',
  `tplset_desc` varchar(255) NOT NULL default '',
  `tplset_credits` text NOT NULL,
  `tplset_created` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`tplset_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `visi_tplset`
--

INSERT INTO `visi_tplset` (`tplset_id`, `tplset_name`, `tplset_desc`, `tplset_credits`, `tplset_created`) VALUES
(1, 'default', 'XOOPS Default Template Set', '', 1205985656);

-- --------------------------------------------------------

--
-- Table structure for table `visi_tplsource`
--

DROP TABLE IF EXISTS `visi_tplsource`;
CREATE TABLE IF NOT EXISTS `visi_tplsource` (
  `tpl_id` mediumint(7) unsigned NOT NULL default '0',
  `tpl_source` mediumtext NOT NULL,
  KEY `tpl_id` (`tpl_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `visi_tplsource`
--

INSERT INTO `visi_tplsource` (`tpl_id`, `tpl_source`) VALUES
(1, '<!DOCTYPE html PUBLIC ''-//W3C//DTD XHTML 1.0 Transitional//EN'' ''http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd''>\r\n<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<{$xoops_langcode}>" lang="<{$xoops_langcode}>">\r\n<head>\r\n<meta http-equiv="content-type" content="text/html; charset=<{$xoops_charset}>" />\r\n<meta http-equiv="content-language" content="<{$xoops_langcode}>" />\r\n<title><{$sitename}> <{$lang_imgmanager}></title>\r\n<script type="text/javascript">\r\n<!--//\r\nfunction appendCode(addCode) {\r\n	var targetDom = window.opener.xoopsGetElementById(''<{$target}>'');\r\n	if (targetDom.createTextRange && targetDom.caretPos){\r\n  		var caretPos = targetDom.caretPos;\r\n		caretPos.text = caretPos.text.charAt(caretPos.text.length - 1) \r\n== '' '' ? addCode + '' '' : addCode;  \r\n	} else if (targetDom.getSelection && targetDom.caretPos){\r\n		var caretPos = targetDom.caretPos;\r\n		caretPos.text = caretPos.text.charat(caretPos.text.length - 1)  \r\n== '' '' ? addCode + '' '' : addCode;\r\n	} else {\r\n		targetDom.value = targetDom.value + addCode;\r\n  	}\r\n	window.close();\r\n	return;\r\n}\r\n//-->\r\n</script>\r\n<style type="text/css" media="all">\r\nbody {margin: 0;}\r\nimg {border: 0;}\r\ntable {width: 100%; margin: 0;}\r\na:link {color: #3a76d6; font-weight: bold; background-color: transparent;}\r\na:visited {color: #9eb2d6; font-weight: bold; background-color: transparent;}\r\na:hover {color: #e18a00; background-color: transparent;}\r\ntable td {background-color: white; font-size: 12px; padding: 0; border-width: 0; vertical-align: top; font-family: Verdana, Arial, Helvetica, sans-serif;}\r\ntable#imagenav td {vertical-align: bottom; padding: 5px;}\r\ntable#imagemain td {border-right: 1px solid silver; border-bottom: 1px solid silver; padding: 5px; vertical-align: middle;}\r\ntable#imagemain th {border: 0; background-color: #2F5376; color:white; font-size: 12px; padding: 5px; vertical-align: top; text-align:center; font-family: Verdana, Arial, Helvetica, sans-serif;}\r\ntable#header td {width: 100%; background-color: #2F5376; vertical-align: middle;}\r\ntable#header td#headerbar {border-bottom: 1px solid silver; background-color: #dddddd;}\r\ndiv#pagenav {text-align:center;}\r\ndiv#footer {text-align:right; padding: 5px;}\r\n</style>\r\n</head>\r\n\r\n<body onload="window.resizeTo(<{$xsize}>, <{$ysize}>);">\r\n  <table id="header" cellspacing="0">\r\n    <tr>\r\n      <td><a href="<{$xoops_url}>/"><img src="<{$xoops_url}>/images/logo.gif" width="150" height="80" alt="" /></a></td><td> </td>\r\n    </tr>\r\n    <tr>\r\n      <td id="headerbar" colspan="2"> </td>\r\n    </tr>\r\n  </table>\r\n\r\n  <form action="imagemanager.php" method="get">\r\n    <table cellspacing="0" id="imagenav">\r\n      <tr>\r\n        <td>\r\n          <select name="cat_id" onchange="location=''<{$xoops_url}>/imagemanager.php?target=<{$target}>&cat_id=''+this.options[this.selectedIndex].value"><{$cat_options}></select> <input type="hidden" name="target" value="<{$target}>" /><input type="submit" value="<{$lang_go}>" />\r\n        </td>\r\n\r\n        <{if $show_cat > 0}>\r\n        <td align="right"><a href="<{$xoops_url}>/imagemanager.php?target=<{$target}>&op=upload&imgcat_id=<{$show_cat}>"><{$lang_addimage}></a></td>\r\n        <{/if}>\r\n\r\n      </tr>\r\n    </table>\r\n  </form>\r\n\r\n  <{if $image_total > 0}>\r\n\r\n  <table cellspacing="0" id="imagemain">\r\n    <tr>\r\n      <th><{$lang_imagename}></th>\r\n      <th><{$lang_image}></th>\r\n      <th><{$lang_imagemime}></th>\r\n      <th><{$lang_align}></th>\r\n    </tr>\r\n\r\n    <{section name=i loop=$images}>\r\n    <tr align="center">\r\n      <td><input type="hidden" name="image_id[]" value="<{$images[i].id}>" /><{$images[i].nicename}></td>\r\n      <td><img src="<{$images[i].src}>" alt="" /></td>\r\n      <td><{$images[i].mimetype}></td>\r\n      <td><a href="#" onclick="javascript:appendCode(''<{$images[i].lxcode}>'');"><img src="<{$xoops_url}>/images/alignleft.gif" alt="Left" /></a> <a href="#" onclick="javascript:appendCode(''<{$images[i].xcode}>'');"><img src="<{$xoops_url}>/images/aligncenter.gif" alt="Center" /></a> <a href="#" onclick="javascript:appendCode(''<{$images[i].rxcode}>'');"><img src="<{$xoops_url}>/images/alignright.gif" alt="Right" /></a></td>\r\n    </tr>\r\n    <{/section}>\r\n  </table>\r\n\r\n  <{/if}>\r\n\r\n  <div id="pagenav"><{$pagenav}></div>\r\n\r\n  <div id="footer">\r\n    <input value="<{$lang_close}>" type="button" onclick="javascript:window.close();" />\r\n  </div>\r\n\r\n  </body>\r\n</html>'),
(2, '<!DOCTYPE html PUBLIC ''-//W3C//DTD XHTML 1.0 Transitional//EN'' ''http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd''>\r\n<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<{$xoops_langcode}>" lang="<{$xoops_langcode}>">\r\n<head>\r\n<meta http-equiv="content-type" content="text/html; charset=<{$xoops_charset}>" />\r\n<meta http-equiv="content-language" content="<{$xoops_langcode}>" />\r\n<title><{$xoops_sitename}> <{$lang_imgmanager}></title>\r\n<{$image_form.javascript}>\r\n<style type="text/css" media="all">\r\nbody {margin: 0;}\r\nimg {border: 0;}\r\ntable {width: 100%; margin: 0;}\r\na:link {color: #3a76d6; font-weight: bold; background-color: transparent;}\r\na:visited {color: #9eb2d6; font-weight: bold; background-color: transparent;}\r\na:hover {color: #e18a00; background-color: transparent;}\r\ntable td {background-color: white; font-size: 12px; padding: 0; border-width: 0; vertical-align: top; font-family: Verdana, Arial, Helvetica, sans-serif;}\r\ntable#imagenav td {vertical-align: bottom; padding: 5px;}\r\ntd.body {padding: 5px; vertical-align: middle;}\r\ntd.caption {border: 0; background-color: #2F5376; color:white; font-size: 12px; padding: 5px; vertical-align: top; text-align:left; font-family: Verdana, Arial, Helvetica, sans-serif;}\r\ntable#imageform {border: 1px solid silver;}\r\ntable#header td {width: 100%; background-color: #2F5376; vertical-align: middle;}\r\ntable#header td#headerbar {border-bottom: 1px solid silver; background-color: #dddddd;}\r\ndiv#footer {text-align:right; padding: 5px;}\r\n</style>\r\n</head>\r\n\r\n<body onload="window.resizeTo(<{$xsize}>, <{$ysize}>);">\r\n  <table id="header" cellspacing="0">\r\n    <tr>\r\n      <td><a href="<{$xoops_url}>/"><img src="<{$xoops_url}>/images/logo.gif" width="150" height="80" alt="" /></a></td><td> </td>\r\n    </tr>\r\n    <tr>\r\n      <td id="headerbar" colspan="2"> </td>\r\n    </tr>\r\n  </table>\r\n\r\n  <table cellspacing="0" id="imagenav">\r\n    <tr>\r\n      <td align="left"><a href="<{$xoops_url}>/imagemanager.php?target=<{$target}>&amp;cat_id=<{$show_cat}>"><{$lang_imgmanager}></a></td>\r\n    </tr>\r\n  </table>\r\n\r\n  <form name="<{$image_form.name}>" id="<{$image_form.name}>" action="<{$image_form.action}>" method="<{$image_form.method}>" <{$image_form.extra}>>\r\n    <table id="imageform" cellspacing="0">\r\n    <!-- start of form elements loop -->\r\n    <{foreach item=element from=$image_form.elements}>\r\n      <{if $element.hidden != true}>\r\n      <tr valign="top">\r\n        <td class="caption"><{$element.caption}></td>\r\n        <td class="body"><{$element.body}></td>\r\n      </tr>\r\n      <{else}>\r\n      <{$element.body}>\r\n      <{/if}>\r\n    <{/foreach}>\r\n    <!-- end of form elements loop -->\r\n    </table>\r\n  </form>\r\n\r\n\r\n  <div id="footer">\r\n    <input value="<{$lang_close}>" type="button" onclick="javascript:window.close();" />\r\n  </div>\r\n\r\n  </body>\r\n</html>'),
(3, '<{if $user_ownpage == true}>\r\n\r\n<form name="usernav" action="user.php" method="post">\r\n\r\n<br /><br />\r\n\r\n<table width="70%" align="center" border="0">\r\n  <tr align="center">\r\n    <td><input type="button" value="<{$lang_editprofile}>" onclick="location=''edituser.php''" />\r\n    <input type="button" value="<{$lang_avatar}>" onclick="location=''edituser.php?op=avatarform''" />\r\n    <input type="button" value="<{$lang_inbox}>" onclick="location=''viewpmsg.php''" />\r\n\r\n    <{if $user_candelete == true}>\r\n    <input type="button" value="<{$lang_deleteaccount}>" onclick="location=''user.php?op=delete''" />\r\n    <{/if}>\r\n\r\n    <input type="button" value="<{$lang_logout}>" onclick="location=''user.php?op=logout''" /></td>\r\n  </tr>\r\n</table>\r\n</form>\r\n\r\n<br /><br />\r\n<{elseif $xoops_isadmin != false}>\r\n\r\n<br /><br />\r\n\r\n<table width="70%" align="center" border="0">\r\n  <tr align="center">\r\n    <td><input type="button" value="<{$lang_editprofile}>" onclick="location=''<{$xoops_url}>/modules/system/admin.php?fct=users&uid=<{$user_uid}>&op=modifyUser''" />\r\n    <input type="button" value="<{$lang_deleteaccount}>" onclick="location=''<{$xoops_url}>/modules/system/admin.php?fct=users&op=delUser&uid=<{$user_uid}>''" />\r\n  </tr>\r\n</table>\r\n\r\n<br /><br />\r\n<{/if}>\r\n\r\n<table width="100%" border="0" cellspacing="5">\r\n  <tr valign="top">\r\n    <td width="50%">\r\n      <table class="outer" cellpadding="4" cellspacing="1" width="100%">\r\n        <tr>\r\n          <th colspan="2" align="center"><{$lang_allaboutuser}></th>\r\n        </tr>\r\n        <tr valign="top">\r\n          <td class="head"><{$lang_avatar}></td>\r\n          <td align="center" class="even"><img src="<{$user_avatarurl}>" alt="Avatar" /></td>\r\n        </tr>\r\n        <tr>\r\n          <td class="head"><{$lang_realname}></td>\r\n          <td align="center" class="odd"><{$user_realname}></td>\r\n        </tr>\r\n        <tr>\r\n          <td class="head"><{$lang_website}></td>\r\n          <td class="even"><{$user_websiteurl}></td>\r\n        </tr>\r\n        <tr valign="top">\r\n          <td class="head"><{$lang_email}></td>\r\n          <td class="odd"><{$user_email}></td>\r\n        </tr>\r\n	<tr valign="top">\r\n          <td class="head"><{$lang_privmsg}></td>\r\n          <td class="even"><{$user_pmlink}></td>\r\n        </tr>\r\n        <tr valign="top">\r\n          <td class="head"><{$lang_icq}></td>\r\n          <td class="odd"><{$user_icq}></td>\r\n        </tr>\r\n        <tr valign="top">\r\n          <td class="head"><{$lang_aim}></td>\r\n          <td class="even"><{$user_aim}></td>\r\n        </tr>\r\n        <tr valign="top">\r\n          <td class="head"><{$lang_yim}></td>\r\n          <td class="odd"><{$user_yim}></td>\r\n        </tr>\r\n        <tr valign="top">\r\n          <td class="head"><{$lang_msnm}></td>\r\n          <td class="even"><{$user_msnm}></td>\r\n        </tr>\r\n        <tr valign="top">\r\n          <td class="head"><{$lang_location}></td>\r\n          <td class="odd"><{$user_location}></td>\r\n        </tr>\r\n        <tr valign="top">\r\n          <td class="head"><{$lang_occupation}></td>\r\n          <td class="even"><{$user_occupation}></td>\r\n        </tr>\r\n        <tr valign="top">\r\n          <td class="head"><{$lang_interest}></td>\r\n          <td class="odd"><{$user_interest}></td>\r\n        </tr>\r\n        <tr valign="top">\r\n          <td class="head"><{$lang_extrainfo}></td>\r\n          <td class="even"><{$user_extrainfo}></td>\r\n        </tr>\r\n      </table>\r\n    </td>\r\n    <td width="50%">\r\n      <table class="outer" cellpadding="4" cellspacing="1" width="100%">\r\n        <tr valign="top">\r\n          <th colspan="2" align="center"><{$lang_statistics}></th>\r\n        </tr>\r\n        <tr valign="top">\r\n          <td class="head"><{$lang_membersince}></td>\r\n          <td align="center" class="even"><{$user_joindate}></td>\r\n        </tr>\r\n        <tr valign="top">\r\n          <td class="head"><{$lang_rank}></td>\r\n          <td align="center" class="odd"><{$user_rankimage}><br /><{$user_ranktitle}></td>\r\n        </tr>\r\n        <tr valign="top">\r\n          <td class="head"><{$lang_posts}></td>\r\n          <td align="center" class="even"><{$user_posts}></td>\r\n        </tr>\r\n	<tr valign="top">\r\n          <td class="head"><{$lang_lastlogin}></td>\r\n          <td align="center" class="odd"><{$user_lastlogin}></td>\r\n        </tr>\r\n      </table>\r\n      <br />\r\n      <table class="outer" cellpadding="4" cellspacing="1" width="100%">\r\n        <tr valign="top">\r\n          <th colspan="2" align="center"><{$lang_signature}></th>\r\n        </tr>\r\n        <tr valign="top">\r\n          <td class="even"><{$user_signature}></td>\r\n        </tr>\r\n      </table>\r\n    </td>\r\n  </tr>\r\n</table>\r\n\r\n<!-- start module search results loop -->\r\n<{foreach item=module from=$modules}>\r\n\r\n<p>\r\n<h4><{$module.name}></h4>\r\n\r\n  <!-- start results item loop -->\r\n  <{foreach item=result from=$module.results}>\r\n\r\n  <img src="<{$result.image}>" alt="<{$module.name}>" /><b><a href="<{$result.link}>"><{$result.title}></a></b><br /><small>(<{$result.time}>)</small><br />\r\n\r\n  <{/foreach}>\r\n  <!-- end results item loop -->\r\n\r\n<{$module.showall_link}>\r\n</p>\r\n\r\n<{/foreach}>\r\n<!-- end module search results loop -->\r\n'),
(4, '<fieldset style="padding: 10px;">\r\n  <legend style="font-weight: bold;"><{$lang_login}></legend>\r\n  <form action="user.php" method="post">\r\n    <{$lang_username}> <input type="text" name="uname" size="26" maxlength="25" value="<{$usercookie}>" /><br />\r\n    <{$lang_password}> <input type="password" name="pass" size="21" maxlength="32" /><br />\r\n    <input type="hidden" name="op" value="login" />\r\n    <input type="hidden" name="xoops_redirect" value="<{$redirect_page}>" />\r\n    <input type="submit" value="<{$lang_login}>" />\r\n  </form>\r\n  <a name="lost"></a>\r\n  <div><{$lang_notregister}><br /></div>\r\n</fieldset>\r\n\r\n<br />\r\n\r\n<fieldset style="padding: 10px;">\r\n  <legend style="font-weight: bold;"><{$lang_lostpassword}></legend>\r\n  <div><br /><{$lang_noproblem}></div>\r\n  <form action="lostpass.php" method="post">\r\n    <{$lang_youremail}> <input type="text" name="email" size="26" maxlength="60" />&nbsp;&nbsp;<input type="hidden" name="op" value="mailpasswd" /><input type="hidden" name="t" value="<{$mailpasswd_token}>" /><input type="submit" value="<{$lang_sendpassword}>" />\r\n  </form>\r\n</fieldset>'),
(5, '<?xml version="1.0" encoding="UTF-8"?>\r\n<rss version="2.0">\r\n  <channel>\r\n    <title><{$channel_title}></title>\r\n    <link><{$channel_link}></link>\r\n    <description><{$channel_desc}></description>\r\n    <lastBuildDate><{$channel_lastbuild}></lastBuildDate>\r\n    <docs>http://backend.userland.com/rss/</docs>\r\n    <generator><{$channel_generator}></generator>\r\n    <category><{$channel_category}></category>\r\n    <managingEditor><{$channel_editor}></managingEditor>\r\n    <webMaster><{$channel_webmaster}></webMaster>\r\n    <language><{$channel_language}></language>\r\n    <{if $image_url != ""}>\r\n    <image>\r\n      <title><{$channel_title}></title>\r\n      <url><{$image_url}></url>\r\n      <link><{$channel_link}></link>\r\n      <width><{$image_width}></width>\r\n      <height><{$image_height}></height>\r\n    </image>\r\n    <{/if}>\r\n    <{foreach item=item from=$items}>\r\n    <item>\r\n      <title><{$item.title}></title>\r\n      <link><{$item.link}></link>\r\n      <description><{$item.description}></description>\r\n      <pubDate><{$item.pubdate}></pubDate>\r\n      <guid><{$item.guid}></guid>\r\n    </item>\r\n    <{/foreach}>\r\n  </channel>\r\n</rss>'),
(6, '<html>\r\n<head>\r\n<meta http-equiv="Content-Type" content="text/html; charset=<{$xoops_charset}>" />\r\n<meta http-equiv="Refresh" content="<{$time}>; url=<{$url}>" />\r\n<title><{$xoops_sitename}></title>\r\n<link rel="stylesheet" type="text/css" media="all" href="<{$xoops_themecss}>" />\r\n</head>\r\n<body>\r\n<div style="text-align:center; background-color: #EBEBEB; border-top: 1px solid #FFFFFF; border-left: 1px solid #FFFFFF; border-right: 1px solid #AAAAAA; border-bottom: 1px solid #AAAAAA; font-weight : bold;">\r\n  <h4><{$message}></h4>\r\n  <p><{$lang_ifnotreload}></p>\r\n</div>\r\n<{if $xoops_logdump != ''''}><div><{$xoops_logdump}></div><{/if}>\r\n</body>\r\n</html>\r\n'),
(7, '<!-- start comment post -->\r\n        <tr>\r\n          <td class="head"><a id="comment<{$comment.id}>"></a> <{$comment.poster.uname}></td>\r\n          <td class="head"><div class="comDate"><span class="comDateCaption"><{$lang_posted}>:</span> <{$comment.date_posted}>&nbsp;&nbsp;<span class="comDateCaption"><{$lang_updated}>:</span> <{$comment.date_modified}></div></td>\r\n        </tr>\r\n        <tr>\r\n\r\n          <{if $comment.poster.id != 0}>\r\n\r\n          <td class="odd"><div class="comUserRank"><div class="comUserRankText"><{$comment.poster.rank_title}></div><img class="comUserRankImg" src="<{$xoops_upload_url}>/<{$comment.poster.rank_image}>" alt="" /></div><img class="comUserImg" src="<{$xoops_upload_url}>/<{$comment.poster.avatar}>" alt="" /><div class="comUserStat"><span class="comUserStatCaption"><{$lang_joined}>:</span> <{$comment.poster.regdate}></div><div class="comUserStat"><span class="comUserStatCaption"><{$lang_from}>:</span> <{$comment.poster.from}></div><div class="comUserStat"><span class="comUserStatCaption"><{$lang_posts}>:</span> <{$comment.poster.postnum}></div><div class="comUserStatus"><{$comment.poster.status}></div></td>\r\n\r\n          <{else}>\r\n\r\n          <td class="odd"> </td>\r\n\r\n          <{/if}>\r\n\r\n          <td class="odd">\r\n            <div class="comTitle"><{$comment.image}><{$comment.title}></div><div class="comText"><{$comment.text}></div>\r\n          </td>\r\n        </tr>\r\n        <tr>\r\n          <td class="even"></td>\r\n\r\n          <{if $xoops_iscommentadmin == true}>\r\n\r\n          <td class="even" align="right">\r\n            <a href="<{$editcomment_link}>&amp;com_id=<{$comment.id}>"><img src="<{$xoops_url}>/images/icons/edit.gif" alt="<{$lang_edit}>" /></a><a href="<{$deletecomment_link}>&amp;com_id=<{$comment.id}>"><img src="<{$xoops_url}>/images/icons/delete.gif" alt="<{$lang_delete}>" /></a><a href="<{$replycomment_link}>&amp;com_id=<{$comment.id}>"><img src="<{$xoops_url}>/images/icons/reply.gif" alt="<{$lang_reply}>" /></a>\r\n          </td>\r\n\r\n          <{elseif $xoops_isuser == true && $xoops_userid == $comment.poster.id}>\r\n\r\n          <td class="even" align="right">\r\n            <a href="<{$editcomment_link}>&amp;com_id=<{$comment.id}>"><img src="<{$xoops_url}>/images/icons/edit.gif" alt="<{$lang_edit}>" /></a><a href="<{$replycomment_link}>&amp;com_id=<{$comment.id}>"><img src="<{$xoops_url}>/images/icons/reply.gif" alt="<{$lang_reply}>" /></a>\r\n          </td>\r\n\r\n          <{elseif $xoops_isuser == true || $anon_canpost == true}>\r\n\r\n          <td class="even" align="right">\r\n            <a href="<{$replycomment_link}>&amp;com_id=<{$comment.id}>"><img src="<{$xoops_url}>/images/icons/reply.gif" alt="<{$lang_reply}>" /></a>\r\n          </td>\r\n\r\n          <{else}>\r\n\r\n          <td class="even"> </td>\r\n\r\n          <{/if}>\r\n\r\n        </tr>\r\n<!-- end comment post -->'),
(8, '<table class="outer" cellpadding="5" cellspacing="1">\r\n  <tr>\r\n    <th width="20%"><{$lang_poster}></th>\r\n    <th><{$lang_thread}></th>\r\n  </tr>\r\n  <{foreach item=comment from=$comments}>\r\n    <{include file="db:system_comment.html" comment=$comment}>\r\n  <{/foreach}>\r\n</table>'),
(9, '<{section name=i loop=$comments}>\r\n<br />\r\n<table cellspacing="1" class="outer">\r\n  <tr>\r\n    <th width="20%"><{$lang_poster}></th>\r\n    <th><{$lang_thread}></th>\r\n  </tr>\r\n  <{include file="db:system_comment.html" comment=$comments[i]}>\r\n</table>\r\n\r\n<{if $show_threadnav == true}>\r\n<div style="text-align:left; margin:3px; padding: 5px;">\r\n<a href="<{$comment_url}>"><{$lang_top}></a> | <a href="<{$comment_url}>&amp;com_id=<{$comments[i].pid}>&amp;com_rootid=<{$comments[i].rootid}>#newscomment<{$comments[i].pid}>"><{$lang_parent}></a>\r\n</div>\r\n<{/if}>\r\n\r\n<{if $comments[i].show_replies == true}>\r\n<!-- start comment tree -->\r\n<br />\r\n<table cellspacing="1" class="outer">\r\n  <tr>\r\n    <th width="50%"><{$lang_subject}></th>\r\n    <th width="20%" align="center"><{$lang_poster}></th>\r\n    <th align="right"><{$lang_posted}></th>\r\n  </tr>\r\n  <{foreach item=reply from=$comments[i].replies}>\r\n  <tr>\r\n    <td class="even"><{$reply.prefix}> <a href="<{$comment_url}>&amp;com_id=<{$reply.id}>&amp;com_rootid=<{$reply.root_id}>"><{$reply.title}></a></td>\r\n    <td class="odd" align="center"><{$reply.poster.uname}></td>\r\n    <td class="even" align="right"><{$reply.date_posted}></td>\r\n  </tr>\r\n  <{/foreach}>\r\n</table>\r\n<!-- end comment tree -->\r\n<{/if}>\r\n\r\n<{/section}>'),
(10, '<{section name=i loop=$comments}>\r\n<br />\r\n<table cellspacing="1" class="outer">\r\n  <tr>\r\n    <th width="20%"><{$lang_poster}></th>\r\n    <th><{$lang_thread}></th>\r\n  </tr>\r\n  <{include file="db:system_comment.html" comment=$comments[i]}>\r\n</table>\r\n\r\n<!-- start comment replies -->\r\n<{foreach item=reply from=$comments[i].replies}>\r\n<br />\r\n<table cellspacing="0" border="0">\r\n  <tr>\r\n    <td width="<{$reply.prefix}>"></td>\r\n    <td>\r\n      <table class="outer" cellspacing="1">\r\n        <tr>\r\n          <th width="20%"><{$lang_poster}></th>\r\n          <th><{$lang_thread}></th>\r\n        </tr>\r\n        <{include file="db:system_comment.html" comment=$reply}>\r\n      </table>\r\n    </td>\r\n  </tr>\r\n</table>\r\n<{/foreach}>\r\n<!-- end comment tree -->\r\n<{/section}>'),
(11, '<!DOCTYPE html PUBLIC ''-//W3C//DTD XHTML 1.0 Transitional//EN'' ''http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd''>\r\n<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<{$xoops_langcode}>" lang="<{$xoops_langcode}>">\r\n<head>\r\n<meta http-equiv="content-type" content="text/html; charset=<{$xoops_charset}>" />\r\n<meta http-equiv="content-language" content="<{$xoops_langcode}>" />\r\n<title><{$xoops_sitename}></title>\r\n<link rel="stylesheet" type="text/css" media="all" href="<{$xoops_url}>/xoops.css" />\r\n\r\n</head>\r\n<body>\r\n  <table cellspacing="0">\r\n    <tr id="header">\r\n      <td style="width: 150px; background-color: #2F5376; vertical-align: middle; text-align:center;"><a href="<{$xoops_url}>/"><img src="<{$xoops_imageurl}>logo.gif" width="150" alt="" /></a></td>\r\n      <td style="width: 100%; background-color: #2F5376; vertical-align: middle; text-align:center;">&nbsp;</td>\r\n    </tr>\r\n    <tr>\r\n      <td style="height: 8px; border-bottom: 1px solid silver; background-color: #dddddd;" colspan="2">&nbsp;</td>\r\n    </tr>\r\n  </table>\r\n\r\n  <table cellspacing="1" align="center" width="80%" border="0" cellpadding="10px;">\r\n    <tr>\r\n      <td align="center"><div style="background-color: #DDFFDF; color: #136C99; text-align: center; border-top: 1px solid #DDDDFF; border-left: 1px solid #DDDDFF; border-right: 1px solid #AAAAAA; border-bottom: 1px solid #AAAAAA; font-weight: bold; padding: 10px;"><{$lang_siteclosemsg}></div></td>\r\n    </tr>\r\n  </table>\r\n  \r\n  <form action="<{$xoops_url}>/user.php" method="post">\r\n    <table cellspacing="0" align="center" style="border: 1px solid silver; width: 200px;">\r\n      <tr>\r\n        <th style="background-color: #2F5376; color: #FFFFFF; padding : 2px; vertical-align : middle;" colspan="2"><{$lang_login}></th>\r\n      </tr>\r\n      <tr>\r\n        <td style="padding: 2px;"><{$lang_username}></td><td style="padding: 2px;"><input type="text" name="uname" size="12" value="" /></td>\r\n      </tr>\r\n      <tr>\r\n        <td style="padding: 2px;"><{$lang_password}></td><td style="padding: 2px;"><input type="password" name="pass" size="12" /></td>\r\n      </tr>\r\n      <tr>\r\n        <td style="padding: 2px;">&nbsp;</td>\r\n        <td style="padding: 2px;">\r\n        	<input type="hidden" name="xoops_redirect" value="<{$xoops_requesturi}>" />\r\n        	<input type="hidden" name="xoops_login" value="1" />\r\n        	<input type="submit" value="<{$lang_login}>" /></td>\r\n      </tr>\r\n    </table>\r\n  </form>\r\n\r\n  <table cellspacing="0" width="100%">\r\n    <tr>\r\n      <td style="height:8px; border-bottom: 1px solid silver; border-top: 1px solid silver; background-color: #dddddd;" colspan="2">&nbsp;</td>\r\n    </tr>\r\n  </table>\r\n\r\n  </body>\r\n</html>'),
(12, '<{$dummy_content}>'),
(13, '<h4><{$lang_activenotifications}></h4>\r\n<form name="notificationlist" action="notifications.php" method="post">\r\n<table class="outer">\r\n  <tr>\r\n	<th><input name="allbox" id="allbox" onclick="xoopsCheckAll(''notificationlist'', ''allbox'');" type="checkbox" value="<{$lang_checkall}>" /></th>\r\n    <th><{$lang_event}></th>\r\n    <th><{$lang_category}></th>\r\n    <th><{$lang_itemid}></th>\r\n    <th><{$lang_itemname}></th>\r\n  </tr>\r\n  <{foreach item=module from=$modules}>\r\n  <tr>\r\n    <td class="head"><input name="del_mod[<{$module.id}>]" id="del_mod[]" onclick="xoopsCheckGroup(''notificationlist'', ''del_mod[<{$module.id}>]'', ''del_not[<{$module.id}>][]'');" type="checkbox" value="<{$module.id}>" /></td>\r\n    <td class="head" colspan="4"><{$lang_module}>: <{$module.name}></td>\r\n  </tr>\r\n  <{foreach item=category from=$module.categories}>\r\n  <{foreach item=item from=$category.items}>\r\n  <{foreach item=notification from=$item.notifications}>\r\n  <tr>\r\n    <{cycle values=odd,even assign=class}>\r\n    <td class="<{$class}>"><input type="checkbox" name="del_not[<{$module.id}>][]" id="del_not[<{$module.id}>][]" value="<{$notification.id}>" /></td>\r\n    <td class="<{$class}>"><{$notification.event_title}></td>\r\n    <td class="<{$class}>"><{$notification.category_title}></td>\r\n    <td class="<{$class}>"><{if $item.id != 0}><{$item.id}><{/if}></td>\r\n    <td class="<{$class}>"><{if $item.id != 0}><{if $item.url != ''''}><a href="<{$item.url}>"><{/if}><{$item.name}><{if $item.url != ''''}></a><{/if}><{/if}></td>\r\n  </tr>\r\n  <{/foreach}>\r\n  <{/foreach}>\r\n  <{/foreach}>\r\n  <{/foreach}>\r\n  <tr>\r\n    <td class="foot" colspan="5">\r\n      <input type="submit" name="delete_cancel" value="<{$lang_cancel}>" />\r\n      <input type="reset" name="delete_reset" value="<{$lang_clear}>" />\r\n      <input type="submit" name="delete" value="<{$lang_delete}>" />\r\n      <input type="hidden" name="XOOPS_TOKEN_REQUEST" value="<{$notification_token}>" />\r\n    </td>\r\n  </tr>\r\n</table>\r\n</form>\r\n'),
(14, '<{if $xoops_notification.show}>\r\n<form name="notification_select" action="<{$xoops_notification.target_page}>" method="post">\r\n<h4 style="text-align:center;"><{$lang_activenotifications}></h4>\r\n<input type="hidden" name="not_redirect" value="<{$xoops_notification.redirect_script}>" />\r\n<input type="hidden" name="XOOPS_TOKEN_REQUEST" value="<{php}>echo $GLOBALS[''xoopsSecurity'']->createToken();<{/php}>" />\r\n<table class="outer">\r\n  <tr><th colspan="3"><{$lang_notificationoptions}></th></tr>\r\n  <tr>\r\n    <td class="head"><{$lang_category}></td>\r\n    <td class="head"><input name="allbox" id="allbox" onclick="xoopsCheckAll(''notification_select'',''allbox'');" type="checkbox" value="<{$lang_checkall}>" /></td>\r\n    <td class="head"><{$lang_events}></td>\r\n  </tr>\r\n  <{foreach name=outer item=category from=$xoops_notification.categories}>\r\n  <{foreach name=inner item=event from=$category.events}>\r\n  <tr>\r\n    <{if $smarty.foreach.inner.first}>\r\n    <td class="even" rowspan="<{$smarty.foreach.inner.total}>"><{$category.title}></td>\r\n    <{/if}>\r\n    <td class="odd">\r\n    <{counter assign=index}>\r\n    <input type="hidden" name="not_list[<{$index}>][params]" value="<{$category.name}>,<{$category.itemid}>,<{$event.name}>" />\r\n    <input type="checkbox" id="not_list[]" name="not_list[<{$index}>][status]" value="1" <{if $event.subscribed}>checked="checked"<{/if}> />\r\n    </td>\r\n    <td class="odd"><{$event.caption}></td>\r\n  </tr>\r\n  <{/foreach}>\r\n  <{/foreach}>\r\n  <tr>\r\n    <td class="foot" colspan="3" align="center"><input type="submit" name="not_submit" value="<{$lang_updatenow}>" /></td>\r\n  </tr>\r\n</table>\r\n<div align="center">\r\n<{$lang_notificationmethodis}>:&nbsp;<{$user_method}>&nbsp;&nbsp;[<a href="<{$editprofile_url}>"><{$lang_change}></a>]\r\n</div>\r\n</form>\r\n<{/if}>'),
(15, '<{$block.content}>'),
(16, '<table cellspacing="0">\r\n  <tr>\r\n    <td id="usermenu">\r\n      <{if $xoops_isadmin}>\r\n        <a class="menuTop" href="<{$xoops_url}>/admin.php"><{$block.lang_adminmenu}></a>\r\n	    <a href="<{$xoops_url}>/user.php"><{$block.lang_youraccount}></a>\r\n      <{else}>\r\n		<a class="menuTop" href="<{$xoops_url}>/user.php"><{$block.lang_youraccount}></a>\r\n      <{/if}>\r\n      <a href="<{$xoops_url}>/edituser.php"><{$block.lang_editaccount}></a>\r\n      <a href="<{$xoops_url}>/notifications.php"><{$block.lang_notifications}></a>\r\n      <{if $block.new_messages > 0}>\r\n        <a class="highlight" href="<{$xoops_url}>/viewpmsg.php"><{$block.lang_inbox}> (<span style="color:#ff0000; font-weight: bold;"><{$block.new_messages}></span>)</a>\r\n      <{else}>\r\n        <a href="<{$xoops_url}>/viewpmsg.php"><{$block.lang_inbox}></a>\r\n      <{/if}>\r\n      <a href="<{$xoops_url}>/user.php?op=logout"><{$block.lang_logout}></a>\r\n    </td>\r\n  </tr>\r\n</table>\r\n'),
(17, '<form style="margin-top: 0px;" action="<{$xoops_url}>/user.php" method="post">\r\n    <{$block.lang_username}><br />\r\n    <input type="text" name="uname" size="12" value="<{$block.unamevalue}>" maxlength="25" /><br />\r\n    <{$block.lang_password}><br />\r\n    <input type="password" name="pass" size="12" maxlength="32" /><br />\r\n    <!-- <input type="checkbox" name="rememberme" value="On" class ="formButton" /><{$block.lang_rememberme}><br /> //-->\r\n    <input type="hidden" name="xoops_redirect" value="<{$xoops_requesturi}>" />\r\n    <input type="hidden" name="op" value="login" />\r\n    <input type="submit" value="<{$block.lang_login}>" /><br />\r\n    <{$block.sslloginlink}>\r\n</form>\r\n<a href="<{$xoops_url}>/user.php#lost"><{$block.lang_lostpass}></a>\r\n<br /><br />\r\n<a href="<{$xoops_url}>/register.php"><{$block.lang_registernow}></a>'),
(18, '<form style="margin-top: 0px;" action="<{$xoops_url}>/search.php" method="get">\r\n  <input type="text" name="query" size="14" /><input type="hidden" name="action" value="results" /><br /><input type="submit" value="<{$block.lang_search}>" />\r\n</form>\r\n<a href="<{$xoops_url}>/search.php"><{$block.lang_advsearch}></a>'),
(19, '<ul>\r\n  <{foreach item=module from=$block.modules}>\r\n  <li><a href="<{$module.adminlink}>"><{$module.lang_linkname}></a>: <{$module.pendingnum}></li>\r\n  <{/foreach}>\r\n</ul>'),
(20, '<table cellspacing="0">\r\n  <tr>\r\n    <td id="mainmenu">\r\n      <a class="menuTop" href="<{$xoops_url}>/"><{$block.lang_home}></a>\r\n      <!-- start module menu loop -->\r\n      <{foreach item=module from=$block.modules}>\r\n      <a class="menuMain" href="<{$xoops_url}>/modules/<{$module.directory}>/"><{$module.name}></a>\r\n        <{foreach item=sublink from=$module.sublinks}>\r\n          <a class="menuSub" href="<{$sublink.url}>"><{$sublink.name}></a>\r\n        <{/foreach}>\r\n      <{/foreach}>\r\n      <!-- end module menu loop -->\r\n    </td>\r\n  </tr>\r\n</table>'),
(21, '<table class="outer" cellspacing="0">\r\n\r\n  <{if $block.showgroups == true}>\r\n\r\n  <!-- start group loop -->\r\n  <{foreach item=group from=$block.groups}>\r\n  <tr>\r\n    <th colspan="2"><{$group.name}></th>\r\n  </tr>\r\n\r\n  <!-- start group member loop -->\r\n  <{foreach item=user from=$group.users}>\r\n  <tr>\r\n    <td class="even" valign="middle" align="center"><img src="<{$user.avatar}>" alt="" width="32" /><br /><a href="<{$xoops_url}>/userinfo.php?uid=<{$user.id}>"><{$user.name}></a></td><td class="odd" width="20%" align="right" valign="middle"><{$user.msglink}></td>\r\n  </tr>\r\n  <{/foreach}>\r\n  <!-- end group member loop -->\r\n\r\n  <{/foreach}>\r\n  <!-- end group loop -->\r\n  <{/if}>\r\n</table>\r\n\r\n<br />\r\n\r\n<div style="margin: 3px; text-align:center;">\r\n  <img src="<{$block.logourl}>" alt="" border="0" /><br /><{$block.recommendlink}>\r\n</div>'),
(22, '<{$block.online_total}><br /><br /><{$block.lang_members}>: <{$block.online_members}><br /><{$block.lang_guests}>: <{$block.online_guests}><br /><br /><{$block.online_names}> <a href="javascript:openWithSelfMain(''<{$xoops_url}>/misc.php?action=showpopups&amp;type=online'',''Online'',420,350);"><{$block.lang_more}></a>'),
(23, '<table cellspacing="1" class="outer">\r\n  <{foreach item=user from=$block.users}>\r\n  <tr class="<{cycle values="even,odd"}>" valign="middle">\r\n    <td><{$user.rank}></td>\r\n    <td align="center">\r\n      <{if $user.avatar != ""}>\r\n      <img src="<{$user.avatar}>" alt="" width="32" /><br />\r\n      <{/if}>\r\n      <a href="<{$xoops_url}>/userinfo.php?uid=<{$user.id}>"><{$user.name}></a>\r\n    </td>\r\n    <td align="center"><{$user.posts}></td>\r\n  </tr>\r\n  <{/foreach}>\r\n</table>\r\n'),
(24, '<table cellspacing="1" class="outer">\r\n  <{foreach item=user from=$block.users}>\r\n    <tr class="<{cycle values="even,odd"}>" valign="middle">\r\n      <td align="center">\r\n      <{if $user.avatar != ""}>\r\n      <img src="<{$user.avatar}>" alt="" width="32" /><br />\r\n      <{/if}>\r\n      <a href="<{$xoops_url}>/userinfo.php?uid=<{$user.id}>"><{$user.name}></a>\r\n      </td>\r\n      <td align="center"><{$user.joindate}></td>\r\n    </tr>\r\n  <{/foreach}>\r\n</table>\r\n'),
(25, '<table width="100%" cellspacing="1" class="outer">\r\n  <{foreach item=comment from=$block.comments}>\r\n  <tr class="<{cycle values="even,odd"}>">\r\n    <td align="center"><img src="<{$xoops_url}>/images/subject/<{$comment.icon}>" alt="" /></td>\r\n    <td><{$comment.title}></td>\r\n    <td align="center"><{$comment.module}></td>\r\n    <td align="center"><{$comment.poster}></td>\r\n    <td align="right"><{$comment.time}></td>\r\n  </tr>\r\n  <{/foreach}>\r\n</table>'),
(26, '<form action="<{$block.target_page}>" method="post">\r\n<table class="outer">\r\n  <{foreach item=category from=$block.categories}>\r\n  <{foreach name=inner item=event from=$category.events}>\r\n  <{if $smarty.foreach.inner.first}>\r\n  <tr>\r\n    <td class="head" colspan="2"><{$category.title}></td>\r\n  </tr>\r\n  <{/if}>\r\n  <tr>\r\n    <td class="odd"><{counter assign=index}><input type="hidden" name="not_list[<{$index}>][params]" value="<{$category.name}>,<{$category.itemid}>,<{$event.name}>" /><input type="checkbox" name="not_list[<{$index}>][status]" value="1" <{if $event.subscribed}>checked="checked"<{/if}> /></td>\r\n    <td class="odd"><{$event.caption}></td>\r\n  </tr>\r\n  <{/foreach}>\r\n  <{/foreach}>\r\n  <tr>\r\n    <td class="foot" colspan="2"><input type="hidden" name="not_redirect" value="<{$block.redirect_script}>"><input type="hidden" value="<{$block.notification_token}>" name="XOOPS_TOKEN_REQUEST" /><input type="submit" name="not_submit" value="<{$block.submit_button}>" /></td>\r\n  </tr>\r\n</table>\r\n</form>'),
(27, '<div style="text-align: center;">\r\n<form action="index.php" method="post">\r\n<{$block.theme_select}>\r\n</form>\r\n</div>');

-- --------------------------------------------------------

--
-- Table structure for table `visi_users`
--

DROP TABLE IF EXISTS `visi_users`;
CREATE TABLE IF NOT EXISTS `visi_users` (
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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

--
-- Dumping data for table `visi_users`
--

INSERT INTO `visi_users` (`uid`, `name`, `uname`, `email`, `url`, `user_avatar`, `user_regdate`, `user_icq`, `user_from`, `user_sig`, `user_viewemail`, `actkey`, `user_aim`, `user_yim`, `user_msnm`, `pass`, `posts`, `attachsig`, `rank`, `level`, `theme`, `timezone_offset`, `last_login`, `umode`, `uorder`, `notify_method`, `notify_mode`, `user_occ`, `bio`, `user_intrest`, `user_mailok`) VALUES
(1, 'I am admin', 'admin', 'admin@simit.com.my', 'http://localhost/simtrain/', 'blank.gif', 1205985656, '', '', '', 1, '', '', '', '', '21232f297a57a5a743894a0e4a801fc3', 0, 0, 7, 5, 'default', 0.0, 1211471127, 'thread', 0, 1, 0, '', '', 'admin', 0),
(10, 'simtrain', 'simtrain', 'test@test.com', '', 'blank.gif', 1209571938, '', '', '', 0, '', '', '', '', 'f6fc1c8112cb561acd57a17c53421b41', 0, 0, 0, 1, '', 0.0, 1210556003, 'nest', 0, 1, 0, '', '', 'admin', 0),
(11, 'chia', 'chia', 'chia@a.com', '', 'blank.gif', 1210776631, '', '', '', 0, '', '', '', '', '202cb962ac59075b964b07152d234b70', 0, 0, 0, 1, '', 0.0, 0, 'nest', 0, 1, 0, '', '', '', 0),
(12, 'lily', 'lily', 'lily@a.com', '', 'blank.gif', 1210776666, '', '', '', 0, '', '', '', '', '202cb962ac59075b964b07152d234b70', 0, 0, 0, 1, '', 0.0, 1210900236, 'nest', 0, 1, 0, '', '', '', 0),
(13, 'puichee', 'puichee', 'puichee@a.com', '', 'blank.gif', 1210776724, '', '', '', 0, '', '', '', '', 'a7dfa58af19da3b474728cd7bde14b00', 0, 0, 0, 1, '', 0.0, 0, 'nest', 0, 1, 0, '', '', '', 0),
(14, 'tieng', 'tieng', 'tieng@a.com', '', 'blank.gif', 1210776762, '', '', '', 0, '', '', '', '', '614c5b28714e5cdc899f52d98c86f1fc', 0, 0, 0, 1, '', 0.0, 0, 'nest', 0, 1, 0, '', '', '', 0),
(15, 'nani', 'nani', 'nani@a.com', '', 'blank.gif', 1210776883, '', '', '', 0, '', '', '', '', '7cac11e2f46ed46c339ec3d569853759', 0, 0, 0, 1, '', 0.0, 0, 'nest', 0, 1, 0, '', '', '', 0),
(16, 'lisa', 'lisa', 'lisa@a.com', '', 'blank.gif', 1210776907, '', '', '', 0, '', '', '', '', '202cb962ac59075b964b07152d234b70', 0, 0, 0, 1, '', 0.0, 0, 'nest', 0, 1, 0, '', '', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `visi_xoopscomments`
--

DROP TABLE IF EXISTS `visi_xoopscomments`;
CREATE TABLE IF NOT EXISTS `visi_xoopscomments` (
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
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `visi_xoopscomments`
--


-- --------------------------------------------------------

--
-- Table structure for table `visi_xoopsnotifications`
--

DROP TABLE IF EXISTS `visi_xoopsnotifications`;
CREATE TABLE IF NOT EXISTS `visi_xoopsnotifications` (
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
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `visi_xoopsnotifications`
--


