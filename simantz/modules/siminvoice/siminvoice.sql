-- phpMyAdmin SQL Dump
-- version 2.10.3deb1ubuntu0.2
-- http://www.phpmyadmin.net
-- 
-- Host: localhost
-- Generation Time: Jul 28, 2008 at 04:34 PM
-- Server version: 5.0.45
-- PHP Version: 5.2.3-1ubuntu6.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

-- 
-- Database: `siminvoice`
-- 

-- --------------------------------------------------------

-- 
-- Table structure for table `siminvoice_avatar`
-- 
use siminvoice;

CREATE TABLE IF NOT EXISTS `siminvoice_avatar` (
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
-- Dumping data for table `siminvoice_avatar`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `siminvoice_avatar_user_link`
-- 

CREATE TABLE IF NOT EXISTS `siminvoice_avatar_user_link` (
  `avatar_id` mediumint(8) unsigned NOT NULL default '0',
  `user_id` mediumint(8) unsigned NOT NULL default '0',
  KEY `avatar_user_id` (`avatar_id`,`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- Dumping data for table `siminvoice_avatar_user_link`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `siminvoice_banner`
-- 

CREATE TABLE IF NOT EXISTS `siminvoice_banner` (
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
-- Dumping data for table `siminvoice_banner`
-- 

INSERT INTO `siminvoice_banner` (`bid`, `cid`, `imptotal`, `impmade`, `clicks`, `imageurl`, `clickurl`, `date`, `htmlbanner`, `htmlcode`) VALUES 
(1, 1, 0, 2028, 0, 'http://localhost/siminvoice/images/banners/xoops_banner.gif', 'http://www.xoops.org/', 1008813250, 0, ''),
(2, 1, 0, 2089, 0, 'http://localhost/siminvoice/images/banners/xoops_banner_2.gif', 'http://www.xoops.org/', 1008813250, 0, ''),
(3, 1, 0, 2057, 0, 'http://localhost/siminvoice/images/banners/banner.swf', 'http://www.xoops.org/', 1008813250, 0, '');

-- --------------------------------------------------------

-- 
-- Table structure for table `siminvoice_bannerclient`
-- 

CREATE TABLE IF NOT EXISTS `siminvoice_bannerclient` (
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
-- Dumping data for table `siminvoice_bannerclient`
-- 

INSERT INTO `siminvoice_bannerclient` (`cid`, `name`, `contact`, `email`, `login`, `passwd`, `extrainfo`) VALUES 
(1, 'XOOPS', 'XOOPS Dev Team', 'webmaster@xoops.org', '', '', '');

-- --------------------------------------------------------

-- 
-- Table structure for table `siminvoice_bannerfinish`
-- 

CREATE TABLE IF NOT EXISTS `siminvoice_bannerfinish` (
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
-- Dumping data for table `siminvoice_bannerfinish`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `siminvoice_block_module_link`
-- 

CREATE TABLE IF NOT EXISTS `siminvoice_block_module_link` (
  `block_id` mediumint(8) unsigned NOT NULL default '0',
  `module_id` smallint(5) NOT NULL default '0',
  KEY `module_id` (`module_id`),
  KEY `block_id` (`block_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- Dumping data for table `siminvoice_block_module_link`
-- 

INSERT INTO `siminvoice_block_module_link` (`block_id`, `module_id`) VALUES 
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
-- Table structure for table `siminvoice_config`
-- 

CREATE TABLE IF NOT EXISTS `siminvoice_config` (
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
-- Dumping data for table `siminvoice_config`
-- 

INSERT INTO `siminvoice_config` (`conf_id`, `conf_modid`, `conf_catid`, `conf_name`, `conf_title`, `conf_value`, `conf_desc`, `conf_formtype`, `conf_valuetype`, `conf_order`) VALUES 
(1, 0, 1, 'sitename', '_MD_AM_SITENAME', 'SimBill', '_MD_AM_SITENAMEDSC', 'textbox', 'text', 0),
(2, 0, 1, 'slogan', '_MD_AM_SLOGAN', 'Simplified, Burdenless.', '_MD_AM_SLOGANDSC', 'textbox', 'text', 2),
(3, 0, 1, 'language', '_MD_AM_LANGUAGE', 'english', '_MD_AM_LANGUAGEDSC', 'language', 'other', 4),
(4, 0, 1, 'startpage', '_MD_AM_STARTPAGE', 'siminvoice', '_MD_AM_STARTPAGEDSC', 'startpage', 'other', 6),
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
(15, 0, 1, 'use_ssl', '_MD_AM_USESSL', '0', '_MD_AM_USESSLDSC', 'yesno', 'int', 30),
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
(38, 0, 3, 'meta_keywords', '_MD_AM_METAKEY', 'news, technology, headlines, xoops, xoop, nuke, myphpnuke, myphp-nuke, phpnuke, SE, geek, geeks, hacker, hackers, linux, software, download, downloads, free, community, mp3, forum, forums, bulletin, board, boards, bbs, php, survey, poll, polls, kernel, comment, comments, portal, odp, open, source, opensource, FreeSoftware, gnu, gpl, license, Unix, *nix, mysql, sql, database, databases, web site, weblog, guru, module, modules, theme, themes, cms, content management', '_MD_AM_METAKEYDSC', 'textarea', 'text', 0),
(39, 0, 3, 'footer', '_MD_AM_FOOTER', 'Powered bySim IT Sdn. Bhd. <a href="http://www.simit.com.my" target="_blank"> The SimBill Project</a>', '_MD_AM_FOOTERDSC', 'textarea', 'text', 20),
(40, 0, 4, 'censor_enable', '_MD_AM_DOCENSOR', '0', '_MD_AM_DOCENSORDSC', 'yesno', 'int', 0),
(41, 0, 4, 'censor_words', '_MD_AM_CENSORWRD', 'a:2:{i:0;s:4:"fuck";i:1;s:4:"shit";}', '_MD_AM_CENSORWRDDSC', 'textarea', 'array', 1),
(42, 0, 4, 'censor_replace', '_MD_AM_CENSORRPLC', '#OOPS#', '_MD_AM_CENSORRPLCDSC', 'textbox', 'text', 2),
(43, 0, 3, 'meta_robots', '_MD_AM_METAROBOTS', 'index,follow', '_MD_AM_METAROBOTSDSC', 'select', 'text', 2),
(44, 0, 5, 'enable_search', '_MD_AM_DOSEARCH', '1', '_MD_AM_DOSEARCHDSC', 'yesno', 'int', 0),
(45, 0, 5, 'keyword_min', '_MD_AM_MINSEARCH', '5', '_MD_AM_MINSEARCHDSC', 'textbox', 'int', 1),
(46, 0, 2, 'avatar_minposts', '_MD_AM_AVATARMP', '0', '_MD_AM_AVATARMPDSC', 'textbox', 'int', 15),
(47, 0, 1, 'enable_badips', '_MD_AM_DOBADIPS', '0', '_MD_AM_DOBADIPSDSC', 'yesno', 'int', 40),
(48, 0, 3, 'meta_rating', '_MD_AM_METARATING', 'general', '_MD_AM_METARATINGDSC', 'select', 'text', 4),
(49, 0, 3, 'meta_author', '_MD_AM_METAAUTHOR', 'Sim IT Sdn Bhd', '_MD_AM_METAAUTHORDSC', 'textbox', 'text', 6),
(50, 0, 3, 'meta_copyright', '_MD_AM_METACOPYR', 'Copyright Â© 2001-2008', '_MD_AM_METACOPYRDSC', 'textbox', 'text', 8),
(51, 0, 3, 'meta_description', '_MD_AM_METADESC', 'siminvoice is an foreign worker management system, it help user to manage the foreign worker master data, employment history, loan/payment history, medical checkup history and permit expiry history,', '_MD_AM_METADESCDSC', 'textarea', 'text', 1),
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
(62, 0, 1, 'module_cache', '_MD_AM_MODCACHE', 'a:1:{i:7;s:1:"0";}', '_MD_AM_MODCACHEDSC', 'module_cache', 'array', 50),
(63, 0, 1, 'template_set', '_MD_AM_DTPLSET', 'default', '_MD_AM_DTPLSETDSC', 'tplset', 'other', 14),
(64, 0, 6, 'mailmethod', '_MD_AM_MAILERMETHOD', 'mail', '_MD_AM_MAILERMETHODDESC', 'select', 'text', 4),
(65, 0, 6, 'smtphost', '_MD_AM_SMTPHOST', 'a:1:{i:0;s:0:"";}', '_MD_AM_SMTPHOSTDESC', 'textarea', 'array', 6),
(66, 0, 6, 'smtpuser', '_MD_AM_SMTPUSER', '', '_MD_AM_SMTPUSERDESC', 'textbox', 'text', 7),
(67, 0, 6, 'smtppass', '_MD_AM_SMTPPASS', '', '_MD_AM_SMTPPASSDESC', 'password', 'text', 8),
(68, 0, 6, 'sendmailpath', '_MD_AM_SENDMAILPATH', '/usr/sbin/sendmail', '_MD_AM_SENDMAILPATHDESC', 'textbox', 'text', 5),
(69, 0, 6, 'from', '_MD_AM_MAILFROM', '', '_MD_AM_MAILFROMDESC', 'textbox', 'text', 1),
(70, 0, 6, 'fromname', '_MD_AM_MAILFROMNAME', '', '_MD_AM_MAILFROMNAMEDESC', 'textbox', 'text', 2),
(71, 0, 1, 'sslloginlink', '_MD_AM_SSLLINK', 'https://', '_MD_AM_SSLLINKDSC', 'textbox', 'text', 33),
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
-- Table structure for table `siminvoice_configcategory`
-- 

CREATE TABLE IF NOT EXISTS `siminvoice_configcategory` (
  `confcat_id` smallint(5) unsigned NOT NULL auto_increment,
  `confcat_name` varchar(255) NOT NULL default '',
  `confcat_order` smallint(5) unsigned NOT NULL default '0',
  PRIMARY KEY  (`confcat_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

-- 
-- Dumping data for table `siminvoice_configcategory`
-- 

INSERT INTO `siminvoice_configcategory` (`confcat_id`, `confcat_name`, `confcat_order`) VALUES 
(1, '_MD_AM_GENERAL', 0),
(2, '_MD_AM_USERSETTINGS', 0),
(3, '_MD_AM_METAFOOTER', 0),
(4, '_MD_AM_CENSOR', 0),
(5, '_MD_AM_SEARCH', 0),
(6, '_MD_AM_MAILER', 0),
(7, '_MD_AM_AUTHENTICATION', 0);

-- --------------------------------------------------------

-- 
-- Table structure for table `siminvoice_configoption`
-- 

CREATE TABLE IF NOT EXISTS `siminvoice_configoption` (
  `confop_id` mediumint(8) unsigned NOT NULL auto_increment,
  `confop_name` varchar(255) NOT NULL default '',
  `confop_value` varchar(255) NOT NULL default '',
  `conf_id` smallint(5) unsigned NOT NULL default '0',
  PRIMARY KEY  (`confop_id`),
  KEY `conf_id` (`conf_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=31 ;

-- 
-- Dumping data for table `siminvoice_configoption`
-- 

INSERT INTO `siminvoice_configoption` (`confop_id`, `confop_name`, `confop_value`, `conf_id`) VALUES 
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
-- Table structure for table `siminvoice_groups`
-- 

CREATE TABLE IF NOT EXISTS `siminvoice_groups` (
  `groupid` smallint(5) unsigned NOT NULL auto_increment,
  `name` varchar(50) NOT NULL default '',
  `description` text NOT NULL,
  `group_type` varchar(10) NOT NULL default '',
  PRIMARY KEY  (`groupid`),
  KEY `group_type` (`group_type`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

-- 
-- Dumping data for table `siminvoice_groups`
-- 

INSERT INTO `siminvoice_groups` (`groupid`, `name`, `description`, `group_type`) VALUES 
(1, 'Webmasters', 'Webmasters of this site', 'Admin'),
(2, 'Registered Users', 'Registered Users Group', 'User'),
(3, 'Anonymous Users', 'Anonymous Users Group', 'Anonymous');

-- --------------------------------------------------------

-- 
-- Table structure for table `siminvoice_groups_users_link`
-- 

CREATE TABLE IF NOT EXISTS `siminvoice_groups_users_link` (
  `linkid` mediumint(8) unsigned NOT NULL auto_increment,
  `groupid` smallint(5) unsigned NOT NULL default '0',
  `uid` mediumint(8) unsigned NOT NULL default '0',
  PRIMARY KEY  (`linkid`),
  KEY `groupid_uid` (`groupid`,`uid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- 
-- Dumping data for table `siminvoice_groups_users_link`
-- 

INSERT INTO `siminvoice_groups_users_link` (`linkid`, `groupid`, `uid`) VALUES 
(1, 1, 1),
(2, 2, 1);

-- --------------------------------------------------------

-- 
-- Table structure for table `siminvoice_group_permission`
-- 

CREATE TABLE IF NOT EXISTS `siminvoice_group_permission` (
  `gperm_id` int(10) unsigned NOT NULL auto_increment,
  `gperm_groupid` smallint(5) unsigned NOT NULL default '0',
  `gperm_itemid` mediumint(8) unsigned NOT NULL default '0',
  `gperm_modid` mediumint(5) unsigned NOT NULL default '0',
  `gperm_name` varchar(50) NOT NULL default '',
  PRIMARY KEY  (`gperm_id`),
  KEY `groupid` (`gperm_groupid`),
  KEY `itemid` (`gperm_itemid`),
  KEY `gperm_modid` (`gperm_modid`,`gperm_name`(10))
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=76 ;

-- 
-- Dumping data for table `siminvoice_group_permission`
-- 

INSERT INTO `siminvoice_group_permission` (`gperm_id`, `gperm_groupid`, `gperm_itemid`, `gperm_modid`, `gperm_name`) VALUES 
(1, 1, 1, 1, 'module_admin'),
(2, 1, 1, 1, 'module_read'),
(3, 2, 1, 1, 'module_read'),
(4, 3, 1, 1, 'module_read'),
(5, 1, 1, 1, 'system_admin'),
(6, 1, 2, 1, 'system_admin'),
(7, 1, 3, 1, 'system_admin'),
(8, 1, 4, 1, 'system_admin'),
(9, 1, 5, 1, 'system_admin'),
(10, 1, 6, 1, 'system_admin'),
(11, 1, 7, 1, 'system_admin'),
(12, 1, 8, 1, 'system_admin'),
(13, 1, 9, 1, 'system_admin'),
(14, 1, 10, 1, 'system_admin'),
(15, 1, 11, 1, 'system_admin'),
(16, 1, 12, 1, 'system_admin'),
(17, 1, 13, 1, 'system_admin'),
(18, 1, 14, 1, 'system_admin'),
(19, 1, 15, 1, 'system_admin'),
(20, 1, 1, 1, 'block_read'),
(21, 2, 1, 1, 'block_read'),
(22, 3, 1, 1, 'block_read'),
(23, 1, 2, 1, 'block_read'),
(24, 2, 2, 1, 'block_read'),
(25, 3, 2, 1, 'block_read'),
(26, 1, 3, 1, 'block_read'),
(27, 2, 3, 1, 'block_read'),
(28, 3, 3, 1, 'block_read'),
(29, 1, 4, 1, 'block_read'),
(30, 2, 4, 1, 'block_read'),
(31, 3, 4, 1, 'block_read'),
(32, 1, 5, 1, 'block_read'),
(33, 2, 5, 1, 'block_read'),
(34, 3, 5, 1, 'block_read'),
(35, 1, 6, 1, 'block_read'),
(36, 2, 6, 1, 'block_read'),
(37, 3, 6, 1, 'block_read'),
(38, 1, 7, 1, 'block_read'),
(39, 2, 7, 1, 'block_read'),
(40, 3, 7, 1, 'block_read'),
(41, 1, 8, 1, 'block_read'),
(42, 2, 8, 1, 'block_read'),
(43, 3, 8, 1, 'block_read'),
(44, 1, 9, 1, 'block_read'),
(45, 2, 9, 1, 'block_read'),
(46, 3, 9, 1, 'block_read'),
(47, 1, 10, 1, 'block_read'),
(48, 2, 10, 1, 'block_read'),
(49, 3, 10, 1, 'block_read'),
(50, 1, 11, 1, 'block_read'),
(51, 2, 11, 1, 'block_read'),
(52, 3, 11, 1, 'block_read'),
(53, 1, 12, 1, 'block_read'),
(54, 2, 12, 1, 'block_read'),
(55, 3, 12, 1, 'block_read'),
(73, 1, 7, 1, 'module_read'),
(74, 2, 7, 1, 'module_read'),
(67, 1, 5, 1, 'module_read'),
(66, 1, 5, 1, 'module_admin'),
(65, 1, 4, 1, 'module_read'),
(64, 1, 4, 1, 'module_admin'),
(72, 1, 7, 1, 'module_admin'),
(75, 3, 7, 1, 'module_read');

-- --------------------------------------------------------

-- 
-- Table structure for table `siminvoice_image`
-- 

CREATE TABLE IF NOT EXISTS `siminvoice_image` (
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
-- Dumping data for table `siminvoice_image`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `siminvoice_imagebody`
-- 

CREATE TABLE IF NOT EXISTS `siminvoice_imagebody` (
  `image_id` mediumint(8) unsigned NOT NULL default '0',
  `image_body` mediumblob,
  KEY `image_id` (`image_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- Dumping data for table `siminvoice_imagebody`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `siminvoice_imagecategory`
-- 

CREATE TABLE IF NOT EXISTS `siminvoice_imagecategory` (
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
-- Dumping data for table `siminvoice_imagecategory`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `siminvoice_imgset`
-- 

CREATE TABLE IF NOT EXISTS `siminvoice_imgset` (
  `imgset_id` smallint(5) unsigned NOT NULL auto_increment,
  `imgset_name` varchar(50) NOT NULL default '',
  `imgset_refid` mediumint(8) unsigned NOT NULL default '0',
  PRIMARY KEY  (`imgset_id`),
  KEY `imgset_refid` (`imgset_refid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- 
-- Dumping data for table `siminvoice_imgset`
-- 

INSERT INTO `siminvoice_imgset` (`imgset_id`, `imgset_name`, `imgset_refid`) VALUES 
(1, 'default', 0);

-- --------------------------------------------------------

-- 
-- Table structure for table `siminvoice_imgsetimg`
-- 

CREATE TABLE IF NOT EXISTS `siminvoice_imgsetimg` (
  `imgsetimg_id` mediumint(8) unsigned NOT NULL auto_increment,
  `imgsetimg_file` varchar(50) NOT NULL default '',
  `imgsetimg_body` blob NOT NULL,
  `imgsetimg_imgset` smallint(5) unsigned NOT NULL default '0',
  PRIMARY KEY  (`imgsetimg_id`),
  KEY `imgsetimg_imgset` (`imgsetimg_imgset`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `siminvoice_imgsetimg`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `siminvoice_imgset_tplset_link`
-- 

CREATE TABLE IF NOT EXISTS `siminvoice_imgset_tplset_link` (
  `imgset_id` smallint(5) unsigned NOT NULL default '0',
  `tplset_name` varchar(50) NOT NULL default '',
  KEY `tplset_name` (`tplset_name`(10))
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- Dumping data for table `siminvoice_imgset_tplset_link`
-- 

INSERT INTO `siminvoice_imgset_tplset_link` (`imgset_id`, `tplset_name`) VALUES 
(1, 'default');

-- --------------------------------------------------------

-- 
-- Table structure for table `siminvoice_modules`
-- 

CREATE TABLE IF NOT EXISTS `siminvoice_modules` (
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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

-- 
-- Dumping data for table `siminvoice_modules`
-- 

INSERT INTO `siminvoice_modules` (`mid`, `name`, `version`, `last_update`, `weight`, `isactive`, `dirname`, `hasmain`, `hasadmin`, `hassearch`, `hasconfig`, `hascomments`, `hasnotification`) VALUES 
(1, 'System', 102, 1212942798, 0, 1, 'system', 0, 1, 0, 0, 0, 0),
(7, 'SimInvoice System', 10, 1216372842, 1, 1, 'siminvoice', 1, 1, 0, 0, 0, 0);

-- --------------------------------------------------------

-- 
-- Table structure for table `siminvoice_newblocks`
-- 

CREATE TABLE IF NOT EXISTS `siminvoice_newblocks` (
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
-- Dumping data for table `siminvoice_newblocks`
-- 

INSERT INTO `siminvoice_newblocks` (`bid`, `mid`, `func_num`, `options`, `name`, `title`, `content`, `side`, `weight`, `visible`, `block_type`, `c_type`, `isactive`, `dirname`, `func_file`, `show_func`, `edit_func`, `template`, `bcachetime`, `last_modified`) VALUES 
(1, 1, 1, '', 'User Menu', 'User Menu', '', 0, 2, 1, 'S', 'H', 1, 'system', 'system_blocks.php', 'b_system_user_show', '', 'system_block_user.html', 0, 1217218071),
(2, 1, 2, '', 'Login', 'Login', '', 0, 0, 1, 'S', 'H', 1, 'system', 'system_blocks.php', 'b_system_login_show', '', 'system_block_login.html', 0, 1212942798),
(3, 1, 3, '', 'Search', 'Search', '', 0, 0, 0, 'S', 'H', 1, 'system', 'system_blocks.php', 'b_system_search_show', '', 'system_block_search.html', 0, 1212942798),
(4, 1, 4, '', 'Waiting Contents', 'Waiting Contents', '', 0, 0, 0, 'S', 'H', 1, 'system', 'system_blocks.php', 'b_system_waiting_show', '', 'system_block_waiting.html', 0, 1212942798),
(5, 1, 5, '', 'Main Menu', 'Main Menu', '', 0, 0, 1, 'S', 'H', 1, 'system', 'system_blocks.php', 'b_system_main_show', '', 'system_block_mainmenu.html', 0, 1212942798),
(6, 1, 6, '320|190|s_poweredby.gif|1', 'Site Info', 'Site Info', '', 0, 0, 0, 'S', 'H', 1, 'system', 'system_blocks.php', 'b_system_info_show', 'b_system_info_edit', 'system_block_siteinfo.html', 0, 1212942798),
(7, 1, 7, '', 'Who''s Online', 'Who''s Online', '', 0, 0, 0, 'S', 'H', 1, 'system', 'system_blocks.php', 'b_system_online_show', '', 'system_block_online.html', 0, 1212942798),
(8, 1, 8, '10|1', 'Top Posters', 'Top Posters', '', 0, 0, 0, 'S', 'H', 1, 'system', 'system_blocks.php', 'b_system_topposters_show', 'b_system_topposters_edit', 'system_block_topusers.html', 0, 1212942798),
(9, 1, 9, '10|1', 'New Members', 'New Members', '', 0, 0, 0, 'S', 'H', 1, 'system', 'system_blocks.php', 'b_system_newmembers_show', 'b_system_newmembers_edit', 'system_block_newusers.html', 0, 1212942798),
(10, 1, 10, '10', 'Recent Comments', 'Recent Comments', '', 0, 0, 0, 'S', 'H', 1, 'system', 'system_blocks.php', 'b_system_comments_show', 'b_system_comments_edit', 'system_block_comments.html', 0, 1212942798),
(11, 1, 11, '', 'Notification Options', 'Notification Options', '', 0, 0, 0, 'S', 'H', 1, 'system', 'system_blocks.php', 'b_system_notification_show', '', 'system_block_notification.html', 0, 1212942798),
(12, 1, 12, '0|80', 'Themes', 'Themes', '', 0, 0, 0, 'S', 'H', 1, 'system', 'system_blocks.php', 'b_system_themes_show', 'b_system_themes_edit', 'system_block_themes.html', 0, 1212942798);

-- --------------------------------------------------------

-- 
-- Table structure for table `siminvoice_online`
-- 

CREATE TABLE IF NOT EXISTS `siminvoice_online` (
  `online_uid` mediumint(8) unsigned NOT NULL default '0',
  `online_uname` varchar(25) NOT NULL default '',
  `online_updated` int(10) unsigned NOT NULL default '0',
  `online_module` smallint(5) unsigned NOT NULL default '0',
  `online_ip` varchar(15) NOT NULL default '',
  KEY `online_module` (`online_module`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- Dumping data for table `siminvoice_online`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `siminvoice_priv_msgs`
-- 

CREATE TABLE IF NOT EXISTS `siminvoice_priv_msgs` (
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
-- Dumping data for table `siminvoice_priv_msgs`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `siminvoice_ranks`
-- 

CREATE TABLE IF NOT EXISTS `siminvoice_ranks` (
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
-- Dumping data for table `siminvoice_ranks`
-- 

INSERT INTO `siminvoice_ranks` (`rank_id`, `rank_title`, `rank_min`, `rank_max`, `rank_special`, `rank_image`) VALUES 
(1, 'Just popping in', 0, 20, 0, 'rank3e632f95e81ca.gif'),
(2, 'Not too shy to talk', 21, 40, 0, 'rank3dbf8e94a6f72.gif'),
(3, 'Quite a regular', 41, 70, 0, 'rank3dbf8e9e7d88d.gif'),
(4, 'Just can''t stay away', 71, 150, 0, 'rank3dbf8ea81e642.gif'),
(5, 'Home away from home', 151, 10000, 0, 'rank3dbf8eb1a72e7.gif'),
(6, 'Moderator', 0, 0, 1, 'rank3dbf8edf15093.gif'),
(7, 'Webmaster', 0, 0, 1, 'rank3dbf8ee8681cd.gif');

-- --------------------------------------------------------

-- 
-- Table structure for table `siminvoice_session`
-- 

CREATE TABLE IF NOT EXISTS `siminvoice_session` (
  `sess_id` varchar(32) NOT NULL default '',
  `sess_updated` int(10) unsigned NOT NULL default '0',
  `sess_ip` varchar(15) NOT NULL default '',
  `sess_data` text NOT NULL,
  PRIMARY KEY  (`sess_id`),
  KEY `updated` (`sess_updated`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- Dumping data for table `siminvoice_session`
-- 

INSERT INTO `siminvoice_session` (`sess_id`, `sess_updated`, `sess_ip`, `sess_data`) VALUES 
('95267faa608e030548dbf6796fe6529f', 1217234027, '192.168.0.56', 'xoopsUserId|s:1:"1";xoopsUserGroups|a:2:{i:0;s:1:"1";i:1;s:1:"2";}xoopsUserTheme|s:7:"default";CREATE_CUST_SESSION|a:3:{i:0;a:2:{s:2:"id";s:32:"e2012e0c616a1cc5bb4c8a397832772b";s:6:"expire";i:1217231930;}i:1;a:2:{s:2:"id";s:32:"2c8b3068c9c0798dffdc544fb637e50b";s:6:"expire";i:1217231974;}i:2;a:2:{s:2:"id";s:32:"b413a71192e8782ae40b6bb720f87cdb";s:6:"expire";i:1217232033;}}CREATE_QUO_SESSION|a:1:{i:0;a:2:{s:2:"id";s:32:"eb3c9c0b973de33152ad86d3d10bd5b4";s:6:"expire";i:1217227154;}}CREATE_INV_SESSION|a:2:{i:7;a:2:{s:2:"id";s:32:"043586b0de800c37074375f902f4ca30";s:6:"expire";i:1217232152;}i:8;a:2:{s:2:"id";s:32:"50fe15d7ab0b5923f325252eef554bf1";s:6:"expire";i:1217232224;}}CREATE_PAY_SESSION|a:1:{i:0;a:2:{s:2:"id";s:32:"e64e0b4fbf6b0b245351d9cab97106c4";s:6:"expire";i:1217227173;}}'),
('43d39721658b8f98cb855de433e2e610', 1217233844, '192.168.0.59', 'xoopsUserId|s:1:"1";xoopsUserGroups|a:2:{i:0;s:1:"1";i:1;s:1:"2";}xoopsUserTheme|s:7:"default";CREATE_INV_SESSION|a:1:{i:0;a:2:{s:2:"id";s:32:"24eed1ece06a2267d755f17f67a2aac7";s:6:"expire";i:1217231778;}}CREATE_QUO_SESSION|a:1:{i:0;a:2:{s:2:"id";s:32:"8d8077dbc6daf03e6c24c3da131d3062";s:6:"expire";i:1217225331;}}CREATE_PAY_SESSION|a:1:{i:0;a:2:{s:2:"id";s:32:"507a1b43daa6012735c7bb2596d477a6";s:6:"expire";i:1217229177;}}CREATE_CAT_SESSION|a:1:{i:0;a:2:{s:2:"id";s:32:"1d946c22b8cb224bb5533a2ed27cb9c0";s:6:"expire";i:1217225635;}}CREATE_ITEM_SESSION|a:1:{i:0;a:2:{s:2:"id";s:32:"ef0a279786c1432fa4c70b8f9f55aeb2";s:6:"expire";i:1217226003;}}CREATE_CUST_SESSION|a:3:{i:0;a:2:{s:2:"id";s:32:"c9a3e26c55c114e84e94345ba5ba97e4";s:6:"expire";i:1217233947;}i:1;a:2:{s:2:"id";s:32:"07810c923d8adb86248c156cc2f47149";s:6:"expire";i:1217233959;}i:2;a:2:{s:2:"id";s:32:"c593f14a6ebd24cbbd4e37a018b93f18";s:6:"expire";i:1217233964;}}'),
('61ab65d639f19aea135ba7132b89fa6e', 1217234008, '192.168.0.1', 'xoopsUserId|s:1:"1";xoopsUserGroups|a:2:{i:0;s:1:"1";i:1;s:1:"2";}xoopsUserTheme|s:7:"default";CREATE_INV_SESSION|a:6:{i:14;a:2:{s:2:"id";s:32:"ebee3f77625ca39cfdfef79c169bcc8c";s:6:"expire";i:1217234065;}i:15;a:2:{s:2:"id";s:32:"97baecf4d90ef6eb5481ac563bfaab79";s:6:"expire";i:1217234067;}i:16;a:2:{s:2:"id";s:32:"04d3cb4ce14c025a07d2a6670845d9ad";s:6:"expire";i:1217234079;}i:17;a:2:{s:2:"id";s:32:"f9fbdf79adca513875472d19828c575b";s:6:"expire";i:1217234082;}i:18;a:2:{s:2:"id";s:32:"e9ec8b6a6614db2d68fb9ddb907dce57";s:6:"expire";i:1217234126;}i:19;a:2:{s:2:"id";s:32:"6676c01efe5ee3afa7f6a15c4edd5acd";s:6:"expire";i:1217234128;}}');

-- --------------------------------------------------------

-- 
-- Table structure for table `siminvoice_siminvoice_checkup`
-- 

CREATE TABLE IF NOT EXISTS `siminvoice_siminvoice_checkup` (
  `checkup_id` int(11) NOT NULL auto_increment,
  `worker_id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `checkup_date` date NOT NULL,
  `document_no` varchar(20) NOT NULL,
  `expired_date` date NOT NULL,
  `clinic` varchar(40) NOT NULL,
  `doctor` varchar(40) NOT NULL,
  `result` char(1) NOT NULL,
  `createdby` int(11) NOT NULL,
  `created` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `updated` timestamp NOT NULL default '0000-00-00 00:00:00',
  `updatedby` int(11) NOT NULL,
  `description` varchar(255) NOT NULL,
  `othersinfo` text NOT NULL,
  PRIMARY KEY  (`checkup_id`),
  KEY `worker_id` (`worker_id`),
  KEY `company_id` (`company_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

-- 
-- Dumping data for table `siminvoice_siminvoice_checkup`
-- 

INSERT INTO `siminvoice_siminvoice_checkup` (`checkup_id`, `worker_id`, `company_id`, `checkup_date`, `document_no`, `expired_date`, `clinic`, `doctor`, `result`, `createdby`, `created`, `updated`, `updatedby`, `description`, `othersinfo`) VALUES 
(1, 1, 1, '2008-07-02', 'sss', '2008-08-04', 'jasfh', 'kk', 'P', 1, '2008-07-03 13:59:03', '2008-07-03 13:59:03', 1, 'ekj', 'kk'),
(2, 3, 2, '2008-07-02', 'nnnn', '0000-00-00', '', '', 'P', 1, '2008-07-03 11:27:06', '2008-07-03 11:27:06', 1, '', ''),
(3, 3, 1, '2008-07-02', 'mmmm', '2008-07-25', '', '', 'P', 1, '2008-07-03 13:58:56', '2008-07-03 13:58:56', 1, '', ''),
(4, 1, 1, '2008-07-04', 'kkgkrg', '2009-07-02', 'ggg', 'fff', 'P', 1, '2008-07-04 21:37:17', '2008-07-04 21:37:17', 1, '', '');

-- --------------------------------------------------------

-- 
-- Table structure for table `siminvoice_siminvoice_company`
-- 

CREATE TABLE IF NOT EXISTS `siminvoice_siminvoice_company` (
  `company_id` int(11) NOT NULL auto_increment,
  `company_no` varchar(14) NOT NULL,
  `company_name` varchar(50) NOT NULL,
  `street1` varchar(50) NOT NULL,
  `street2` varchar(50) NOT NULL,
  `postcode` varchar(5) NOT NULL,
  `city` varchar(30) NOT NULL,
  `state1` varchar(30) NOT NULL,
  `country` varchar(20) NOT NULL,
  `contactperson` varchar(40) NOT NULL,
  `contactperson_no` varchar(16) NOT NULL,
  `tel1` varchar(16) NOT NULL,
  `tel2` varchar(16) NOT NULL,
  `fax` varchar(16) NOT NULL,
  `description` varchar(255) NOT NULL,
  `created` datetime NOT NULL,
  `createdby` int(11) NOT NULL,
  `updated` datetime NOT NULL,
  `updatedby` int(11) NOT NULL,
  `isactive` int(11) NOT NULL,
  `isdefault` int(11) NOT NULL default '0',
  `currency_id` int(11) NOT NULL,
  PRIMARY KEY  (`company_id`),
  KEY `company_no` (`company_no`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- 
-- Dumping data for table `siminvoice_siminvoice_company`
-- 

INSERT INTO `siminvoice_siminvoice_company` (`company_id`, `company_no`, `company_name`, `street1`, `street2`, `postcode`, `city`, `state1`, `country`, `contactperson`, `contactperson_no`, `tel1`, `tel2`, `fax`, `description`, `created`, `createdby`, `updated`, `updatedby`, `isactive`, `isdefault`, `currency_id`) VALUES 
(1, '1001', 'Customer 1', 'C1, Street 1', 'Street 2', '81900', 'Kota Tinggi', 'Johor', 'Malaysia', 'Manager 1', '01278990034', '078823234', '07865435', '0872345', '-', '0000-00-00 00:00:00', 8, '2008-06-30 18:08:21', 1, 1, 0, 1),
(2, '1002', 'Customer 2', 'C2, Street1', 'C2, Street2', '88764', 'Johor Jata', 'Johor', 'Malaysia', 'Customer 2 Supervisor', '0876458', '987564786', '6854576', '6745765', 'adjf', '0000-00-00 00:00:00', 8, '0000-00-00 00:00:00', 8, 1, 0, 1);

-- --------------------------------------------------------

-- 
-- Table structure for table `siminvoice_siminvoice_currency`
-- 

CREATE TABLE IF NOT EXISTS `siminvoice_siminvoice_currency` (
  `currency_id` int(11) NOT NULL auto_increment,
  `currency_symbol` varchar(3) NOT NULL,
  `currency_description` varchar(30) NOT NULL,
  `created` datetime NOT NULL,
  `createdby` int(11) NOT NULL,
  `updated` datetime NOT NULL,
  `updatedby` int(11) NOT NULL,
  `isactive` int(11) NOT NULL,
  `isdefault` int(11) NOT NULL,
  PRIMARY KEY  (`currency_id`),
  UNIQUE KEY `currency_symbol` (`currency_symbol`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- 
-- Dumping data for table `siminvoice_siminvoice_currency`
-- 

INSERT INTO `siminvoice_siminvoice_currency` (`currency_id`, `currency_symbol`, `currency_description`, `created`, `createdby`, `updated`, `updatedby`, `isactive`, `isdefault`) VALUES 
(1, 'MYR', 'Malaysia Ringgit', '2008-07-02 23:21:21', 1, '2008-07-02 23:21:21', 1, 1, 0);

-- --------------------------------------------------------

-- 
-- Table structure for table `siminvoice_siminvoice_loanpayment`
-- 

CREATE TABLE IF NOT EXISTS `siminvoice_siminvoice_loanpayment` (
  `loanpayment_id` int(11) NOT NULL auto_increment,
  `worker_id` int(11) NOT NULL,
  `amount` decimal(12,2) NOT NULL,
  `installment_amt` decimal(12,2) NOT NULL,
  `monthcount` int(11) NOT NULL,
  `nextpayment_date` date NOT NULL,
  `loanpayment_date` date NOT NULL,
  `description` varchar(255) NOT NULL,
  `created` timestamp NULL default CURRENT_TIMESTAMP,
  `createdby` int(11) NOT NULL,
  `updated` timestamp NOT NULL default '0000-00-00 00:00:00',
  `updatedby` int(11) NOT NULL,
  `type` int(11) NOT NULL,
  `reference_id` int(11) NOT NULL,
  `document_no` varchar(20) NOT NULL,
  `loanpayment_status` int(11) NOT NULL default '0',
  PRIMARY KEY  (`loanpayment_id`),
  KEY `worker_id` (`worker_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

-- 
-- Dumping data for table `siminvoice_siminvoice_loanpayment`
-- 

INSERT INTO `siminvoice_siminvoice_loanpayment` (`loanpayment_id`, `worker_id`, `amount`, `installment_amt`, `monthcount`, `nextpayment_date`, `loanpayment_date`, `description`, `created`, `createdby`, `updated`, `updatedby`, `type`, `reference_id`, `document_no`, `loanpayment_status`) VALUES 
(1, 3, 1200.00, 100.00, 12, '2008-07-02', '2008-07-03', '', '2008-07-03 14:33:52', 1, '2008-07-03 14:33:52', 1, 1, 0, 'fefre', 1),
(3, 3, 100.00, 0.00, 0, '2008-08-02', '2008-07-03', '', '2008-07-03 14:35:15', 1, '2008-07-03 14:35:15', 1, -1, 1, 'jjuii', 1),
(4, 3, 100.00, 0.00, 0, '2008-09-02', '2008-07-18', '', '2008-07-18 14:54:27', 1, '2008-07-18 14:54:27', 1, -1, 1, 'eew', 1);

-- --------------------------------------------------------

-- 
-- Table structure for table `siminvoice_siminvoice_nationality`
-- 

CREATE TABLE IF NOT EXISTS `siminvoice_siminvoice_nationality` (
  `nationality_id` int(11) NOT NULL auto_increment,
  `nationality_name` varchar(20) NOT NULL,
  `nationality_description` varchar(100) NOT NULL,
  `created` datetime NOT NULL,
  `createdby` int(11) NOT NULL,
  `updated` datetime NOT NULL,
  `updatedby` int(11) NOT NULL,
  `isactive` int(11) NOT NULL,
  `isdefault` int(11) NOT NULL,
  PRIMARY KEY  (`nationality_id`),
  UNIQUE KEY `nationality_name` (`nationality_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- 
-- Dumping data for table `siminvoice_siminvoice_nationality`
-- 

INSERT INTO `siminvoice_siminvoice_nationality` (`nationality_id`, `nationality_name`, `nationality_description`, `created`, `createdby`, `updated`, `updatedby`, `isactive`, `isdefault`) VALUES 
(1, 'MY', 'Malaysian', '2008-06-30 18:03:42', 1, '2008-06-30 18:03:42', 1, 1, 0),
(2, 'SG', 'Singaporian', '2008-06-30 18:03:53', 1, '2008-06-30 18:03:53', 1, 1, 0);

-- --------------------------------------------------------

-- 
-- Table structure for table `siminvoice_siminvoice_races`
-- 

CREATE TABLE IF NOT EXISTS `siminvoice_siminvoice_races` (
  `races_id` int(11) NOT NULL auto_increment,
  `races_name` varchar(20) NOT NULL,
  `races_description` varchar(100) NOT NULL,
  `created` datetime NOT NULL,
  `createdby` int(11) NOT NULL,
  `updated` datetime NOT NULL,
  `updatedby` int(11) NOT NULL,
  `isactive` int(11) NOT NULL,
  `isdefault` int(11) NOT NULL,
  PRIMARY KEY  (`races_id`),
  UNIQUE KEY `races_name` (`races_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- 
-- Dumping data for table `siminvoice_siminvoice_races`
-- 

INSERT INTO `siminvoice_siminvoice_races` (`races_id`, `races_name`, `races_description`, `created`, `createdby`, `updated`, `updatedby`, `isactive`, `isdefault`) VALUES 
(1, 'Chinese', 'Chinese', '2008-06-30 18:03:10', 1, '2008-06-30 18:03:10', 1, 1, 0),
(2, 'India', '-', '2008-06-30 18:03:20', 1, '2008-06-30 18:03:20', 1, 1, 0);

-- --------------------------------------------------------

-- 
-- Table structure for table `siminvoice_siminvoice_worker`
-- 

CREATE TABLE IF NOT EXISTS `siminvoice_siminvoice_worker` (
  `worker_id` int(11) NOT NULL auto_increment,
  `worker_no` varchar(12) NOT NULL,
  `worker_code` varchar(12) NOT NULL,
  `worker_name` varchar(40) NOT NULL,
  `dateofbirth` date NOT NULL,
  `ic_no` varbinary(20) NOT NULL,
  `gender` char(1) NOT NULL,
  `races_id` int(11) NOT NULL,
  `nationality_id` int(11) NOT NULL,
  `passport_no` varchar(20) NOT NULL,
  `home_street1` varchar(100) NOT NULL,
  `home_street2` varchar(100) NOT NULL,
  `home_postcode` varchar(5) NOT NULL,
  `home_city` varchar(30) NOT NULL,
  `home_state` varchar(30) NOT NULL,
  `home_country` varchar(20) NOT NULL,
  `email` varchar(40) NOT NULL,
  `home_tel1` varchar(16) NOT NULL,
  `home_tel2` varchar(16) NOT NULL,
  `handphone` varchar(16) NOT NULL,
  `maritalstatus` char(1) NOT NULL,
  `family_contactname` varchar(40) NOT NULL,
  `family_contactno` varchar(16) NOT NULL,
  `relationship` varchar(30) NOT NULL,
  `skill` varchar(255) NOT NULL,
  `educationlevel` varchar(255) NOT NULL,
  `bank_name` varchar(30) NOT NULL,
  `bank_acc` varchar(30) NOT NULL,
  `bankacc_type` varchar(30) NOT NULL,
  `description` varchar(255) NOT NULL,
  `created` datetime NOT NULL,
  `createdby` int(11) NOT NULL,
  `updated` datetime NOT NULL,
  `updatedby` int(11) NOT NULL,
  `isactive` int(11) NOT NULL,
  `arrivaldate` date NOT NULL,
  `workerstatus` varchar(10) NOT NULL,
  `departuredate` date NOT NULL default '0000-00-00',
  PRIMARY KEY  (`worker_id`),
  UNIQUE KEY `worker_code` (`worker_code`),
  KEY `races_id` (`races_id`),
  KEY `nationality_id` (`nationality_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

-- 
-- Dumping data for table `siminvoice_siminvoice_worker`
-- 

INSERT INTO `siminvoice_siminvoice_worker` (`worker_id`, `worker_no`, `worker_code`, `worker_name`, `dateofbirth`, `ic_no`, `gender`, `races_id`, `nationality_id`, `passport_no`, `home_street1`, `home_street2`, `home_postcode`, `home_city`, `home_state`, `home_country`, `email`, `home_tel1`, `home_tel2`, `handphone`, `maritalstatus`, `family_contactname`, `family_contactno`, `relationship`, `skill`, `educationlevel`, `bank_name`, `bank_acc`, `bankacc_type`, `description`, `created`, `createdby`, `updated`, `updatedby`, `isactive`, `arrivaldate`, `workerstatus`, `departuredate`) VALUES 
(1, 're', '1001', 'Ali', '2008-07-13', 0x373833363738373636, 'M', 1, 1, '5678087659876', 'street1', 'street2', '81900', 'Kota Tinggi', 'Johor', 'Malaysia', 'email', '0864374', '847285', 'hp no', 'S', 'alibaba', '93445459', 'relationshop', 'I have manu many skill ti sh\r\nshare witha lot\r\nof people.\r\nHpoe can sr\r\nrijw\r\nDME\r\nGRG R3 34', 'Diploma', 'PBB', '9248736', 'SAVING', '40 RTK\r\nRGR', '2008-07-01 10:02:38', 1, '2008-07-04 16:19:03', 1, 1, '2008-07-01', 'Normal', '2008-07-31'),
(3, '', '1002', 'Worker 1', '0000-00-00', '', 'M', 1, 1, '', '', '', '', '', '', '', '', '', '', 'rr', 'S', '', '', '', '', 'Diploma', '', '', '', '', '2008-07-02 21:36:10', 1, '2008-07-04 16:18:36', 1, 1, '0000-00-00', 'Normal', '0000-00-00'),
(4, 'A001', '1003', 'Teh Moi Chuv', '0000-00-00', 0x2d66, 'M', 1, 1, 'IU03843483', '', '', '', '', '', '', '', '', '', '', 'S', '', '', '', '', '', '', '', '', '', '2008-07-04 16:19:46', 1, '2008-07-04 16:31:08', 1, 1, '0000-00-00', 'Normal', '0000-00-00'),
(5, 'fgr', '1004', 'Worker zzz', '0000-00-00', 0x686768, 'M', 1, 1, '', '', '', '', '', '', '', '', '', '', '', 'S', '', '', '', '', '', '', '', '', '', '2008-07-04 21:48:43', 1, '2008-07-04 21:48:43', 1, 1, '0000-00-00', 'Normal', '0000-00-00');

-- --------------------------------------------------------

-- 
-- Table structure for table `siminvoice_siminvoice_workercompany`
-- 

CREATE TABLE IF NOT EXISTS `siminvoice_siminvoice_workercompany` (
  `workercompany_id` int(11) NOT NULL auto_increment,
  `worker_id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `department` varchar(20) NOT NULL,
  `salary` decimal(12,2) NOT NULL,
  `joindate` date NOT NULL,
  `resigndate` date NOT NULL,
  `street1` varchar(200) NOT NULL,
  `street2` varchar(200) NOT NULL,
  `postcode` varchar(5) NOT NULL,
  `city` varchar(30) NOT NULL,
  `state1` varchar(20) NOT NULL,
  `country` varchar(30) NOT NULL,
  `payfrequency` varchar(10) NOT NULL,
  `position` varchar(30) NOT NULL,
  `currency_id` int(11) NOT NULL,
  `supervisor` varchar(40) NOT NULL,
  `supervisor_contact` varchar(16) NOT NULL,
  `usecompany_address` int(1) NOT NULL,
  `workerstatus` varchar(10) NOT NULL,
  `created` datetime NOT NULL,
  `createdby` int(11) NOT NULL,
  `updated` datetime NOT NULL,
  `updatedby` int(11) NOT NULL,
  `worker_no` varchar(20) NOT NULL,
  `othersinfo` varchar(255) NOT NULL,
  PRIMARY KEY  (`workercompany_id`),
  KEY `worker_id` (`worker_id`),
  KEY `company_id` (`company_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

-- 
-- Dumping data for table `siminvoice_siminvoice_workercompany`
-- 

INSERT INTO `siminvoice_siminvoice_workercompany` (`workercompany_id`, `worker_id`, `company_id`, `department`, `salary`, `joindate`, `resigndate`, `street1`, `street2`, `postcode`, `city`, `state1`, `country`, `payfrequency`, `position`, `currency_id`, `supervisor`, `supervisor_contact`, `usecompany_address`, `workerstatus`, `created`, `createdby`, `updated`, `updatedby`, `worker_no`, `othersinfo`) VALUES 
(1, 3, 1, 'dd', 120.00, '2008-07-02', '0000-00-00', 'C1, Street 1', 'Street 2', '81900', 'Kota Tinggi', 'Johor', 'Malaysia', 'monthly', 'po', 1, 'kkkll', 'kjk', 1, 'active', '2008-07-03 01:39:05', 1, '2008-07-03 01:39:05', 1, 'kdjs', ''),
(2, 3, 1, 'efe', 0.00, '2008-07-03', '0000-00-00', 'C1, Street 1', 'Street 2', '81900', 'Kota Tinggi', 'Johor', 'Malaysia', '', '', 1, '', '', 1, 'active', '2008-07-03 01:20:49', 1, '2008-07-03 01:20:49', 1, 'fffefef', ''),
(3, 4, 1, 'QA', 1000.00, '2008-07-04', '0000-00-00', 'C1, Street 1', 'Street 2', '81900', 'Kota Tinggi', 'Johor', 'Malaysia', '', 'Operator', 1, '', '', 1, 'active', '2008-07-04 21:34:27', 1, '2008-07-04 21:34:27', 1, 'A001', ''),
(4, 4, 2, 'ENG', 0.00, '2008-07-04', '2008-07-04', 'C2, Street1', 'C2, Street2', '88764', 'Johor Jata', 'Johor', 'Malaysia', '', '', 1, '', '', 1, 'resigned', '2008-07-04 21:35:10', 1, '2008-07-04 21:35:10', 1, 'B001', '');

-- --------------------------------------------------------

-- 
-- Table structure for table `siminvoice_siminvoice_workpermit`
-- 

CREATE TABLE IF NOT EXISTS `siminvoice_siminvoice_workpermit` (
  `workpermit_id` int(11) NOT NULL auto_increment,
  `worker_id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `register_date` date NOT NULL,
  `document_no` varchar(20) NOT NULL,
  `expired_date` date NOT NULL,
  `permitstatus` char(1) NOT NULL,
  `createdby` int(11) NOT NULL,
  `created` timestamp NOT NULL default '0000-00-00 00:00:00',
  `updated` timestamp NOT NULL default '0000-00-00 00:00:00' on update CURRENT_TIMESTAMP,
  `updatedby` int(11) NOT NULL,
  `description` varchar(255) NOT NULL,
  `othersinfo` text NOT NULL,
  PRIMARY KEY  (`workpermit_id`),
  KEY `worker_id` (`worker_id`),
  KEY `company_id` (`company_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

-- 
-- Dumping data for table `siminvoice_siminvoice_workpermit`
-- 

INSERT INTO `siminvoice_siminvoice_workpermit` (`workpermit_id`, `worker_id`, `company_id`, `register_date`, `document_no`, `expired_date`, `permitstatus`, `createdby`, `created`, `updated`, `updatedby`, `description`, `othersinfo`) VALUES 
(1, 1, 1, '2008-07-03', 'lkked', '2008-07-17', 'I', 1, '2008-07-04 21:38:24', '2008-07-04 21:38:24', 1, '', ''),
(2, 1, 2, '2008-07-03', 'kkwkek', '2008-08-04', 'P', 1, '2008-07-03 11:41:39', '2008-07-03 11:41:39', 1, '', ''),
(3, 3, 1, '2008-07-03', 'efef,', '2008-10-08', 'P', 1, '2008-07-03 11:41:58', '2008-07-03 11:41:58', 1, 'vlve,kl\\\\', '');

-- --------------------------------------------------------

-- 
-- Table structure for table `siminvoice_smiles`
-- 

CREATE TABLE IF NOT EXISTS `siminvoice_smiles` (
  `id` smallint(5) unsigned NOT NULL auto_increment,
  `code` varchar(50) NOT NULL default '',
  `smile_url` varchar(100) NOT NULL default '',
  `emotion` varchar(75) NOT NULL default '',
  `display` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

-- 
-- Dumping data for table `siminvoice_smiles`
-- 

INSERT INTO `siminvoice_smiles` (`id`, `code`, `smile_url`, `emotion`, `display`) VALUES 
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
-- Table structure for table `siminvoice_tblcategory`
-- 

CREATE TABLE IF NOT EXISTS `siminvoice_tblcategory` (
  `category_id` int(11) NOT NULL auto_increment,
  `category_code` varchar(20) NOT NULL,
  `category_desc` varchar(50) NOT NULL,
  `category_type` char(1) default NULL,
  `isactive` char(1) default NULL,
  `created` date default NULL,
  `createdby` int(11) default NULL,
  `updated` date default NULL,
  `updatedby` int(11) default NULL,
  PRIMARY KEY  (`category_id`),
  UNIQUE KEY `category_code` (`category_code`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

-- 
-- Dumping data for table `siminvoice_tblcategory`
-- 

INSERT INTO `siminvoice_tblcategory` (`category_id`, `category_code`, `category_desc`, `category_type`, `isactive`, `created`, `createdby`, `updated`, `updatedby`) VALUES 
(1, '1', 'desc 2', 'S', '1', '0000-00-00', 8, '2008-07-23', 1),
(2, '2', 'desc1', 'T', '1', '0000-00-00', 8, '2008-07-21', 1),
(3, '3', 'desc 3', 'S', '1', '0000-00-00', 8, '2008-07-21', 1),
(4, '4', 'desc 4', 'T', '1', '0000-00-00', 8, '0000-00-00', 8);

-- --------------------------------------------------------

-- 
-- Table structure for table `siminvoice_tblcustomer`
-- 

CREATE TABLE IF NOT EXISTS `siminvoice_tblcustomer` (
  `customer_id` int(11) NOT NULL auto_increment,
  `customer_no` char(20) NOT NULL,
  `customer_name` varchar(40) NOT NULL,
  `customer_street1` varchar(100) default NULL,
  `customer_street2` varchar(100) default NULL,
  `customer_postcode` int(5) NOT NULL,
  `customer_city` varchar(50) NOT NULL,
  `customer_state` varchar(50) NOT NULL,
  `state` varchar(50) NOT NULL,
  `customer_country` varchar(50) NOT NULL,
  `customer_tel1` char(20) default NULL,
  `customer_tel2` char(20) default NULL,
  `customer_fax` char(20) default NULL,
  `customer_contactperson` varchar(30) default NULL,
  `customer_contactno` varchar(20) default NULL,
  `customer_contactnohp` varchar(20) default NULL,
  `customer_contactfax` varchar(20) default NULL,
  `isactive` int(11) NOT NULL,
  `customer_desc` text,
  `terms_id` int(11) default NULL,
  `customer_accbank` varchar(20) default NULL,
  `customer_bank` varchar(20) default NULL,
  `created` date default NULL,
  `createdby` int(11) default NULL,
  `updated` date default NULL,
  `updatedby` int(11) default NULL,
  PRIMARY KEY  (`customer_id`),
  UNIQUE KEY `customer_no` (`customer_no`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

-- 
-- Dumping data for table `siminvoice_tblcustomer`
-- 

INSERT INTO `siminvoice_tblcustomer` (`customer_id`, `customer_no`, `customer_name`, `customer_street1`, `customer_street2`, `customer_postcode`, `customer_city`, `customer_state`, `state`, `customer_country`, `customer_tel1`, `customer_tel2`, `customer_fax`, `customer_contactperson`, `customer_contactno`, `customer_contactnohp`, `customer_contactfax`, `isactive`, `customer_desc`, `terms_id`, `customer_accbank`, `customer_bank`, `created`, `createdby`, `updated`, `updatedby`) VALUES 
(1, '10000001', 'name2', 'street1', 'street212', 0, '', '', '', '', 'tel1', 'tel2', 'fax', 'contact person', 'contact no', NULL, NULL, 1, 'desc', 0, 'acc no', 'bank name', '0000-00-00', 8, '2008-07-21', 1),
(2, '10000002', 'cust name', 's1', 's2', 0, '', '', '', '', 't2', 't2', '2323', 'Contact Person', 'cn', '0127095123', 'ee', 1, 'desc', 1, 'an', 'bn', '0000-00-00', 8, '2008-07-28', 1),
(3, '10000003', 'name2', '', '', 0, '', '', '', '', '', '', '', '', '', NULL, NULL, 1, '', 0, '', '', '0000-00-00', 8, '0000-00-00', 8),
(4, '10000004', 'ABC', '', '', 0, '', '', '', '', '', '', '', '', '', '', '', 0, '', 0, '', '', '0000-00-00', 8, '2008-07-25', 1),
(5, '10000005', 'Microsoft', '', '', 0, '', '', '', '', '', '', '', 'Bill Gate', '0012556666', '01236549', '07-7896225', 1, '', 0, '', '', '0000-00-00', 8, '2008-07-24', 1),
(6, '10000006', 'Proton', 'jalan 1', 'jalan 2', 0, '', '', '', '', '012-2589663', '012566688', '07-58956323', 'mr proton', '07-78996966', '019-78956630', '07-78996366', 1, 'description ok', 0, '12566', 'CIMB', '0000-00-00', 8, '2008-07-24', 1),
(7, '10000007', 'testing ', '', '', 0, '', '', '', '', '', '', '', '', '', '', '', 1, '', 0, '', '', '0000-00-00', 8, '0000-00-00', 8),
(8, '10000008', 'SIM IT SDN. BHD.', '10B-1, Jalan Mawar 4,', '', 81900, 'Kota Tinggi.', 'Johor.', '', 'Malaysia.', '078825296', '', '', 'Feen Hoo', '078825296', '0177477296', '078835330', 1, '', 1, '3143213408', 'PBB', '2008-07-28', 1, '2008-07-28', 1);

-- --------------------------------------------------------

-- 
-- Table structure for table `siminvoice_tblinvoice`
-- 

CREATE TABLE IF NOT EXISTS `siminvoice_tblinvoice` (
  `invoice_id` int(11) NOT NULL auto_increment,
  `invoice_no` varchar(20) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `invoice_date` date default NULL,
  `invoice_terms` varchar(20) default NULL,
  `iscomplete` char(1) default NULL,
  `invoice_attn` varchar(50) default NULL,
  `invoice_preparedby` varchar(50) default NULL,
  `invoice_attntel` varchar(20) default NULL,
  `invoice_attntelhp` varchar(20) default NULL,
  `invoice_attnfax` varchar(30) default NULL,
  `invoice_remarks` text,
  `invoice_totalamount` decimal(12,2) default NULL,
  `terms_id` int(11) default NULL,
  `created` date default NULL,
  `createdby` int(11) default NULL,
  `updated` date default NULL,
  `updatedby` int(11) default NULL,
  PRIMARY KEY  (`invoice_id`),
  UNIQUE KEY `invoice_no` (`invoice_no`),
  KEY `customer_id` (`customer_id`),
  KEY `terms_id` (`terms_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=55 ;

-- 
-- Dumping data for table `siminvoice_tblinvoice`
-- 

INSERT INTO `siminvoice_tblinvoice` (`invoice_id`, `invoice_no`, `customer_id`, `invoice_date`, `invoice_terms`, `iscomplete`, `invoice_attn`, `invoice_preparedby`, `invoice_attntel`, `invoice_attntelhp`, `invoice_attnfax`, `invoice_remarks`, `invoice_totalamount`, `terms_id`, `created`, `createdby`, `updated`, `updatedby`) VALUES 
(13, '100000', 1, '0000-00-00', '', '0', 'contact personll', 'marhan', 'contact no', 'dd', '', 'remarks for invoice', 0.00, 1, '0000-00-00', 8, '2008-07-28', 1),
(14, '100001', 1, '0000-00-00', '', '0', 'contact person', '1sdad', 'contact no', '', '', '', 0.00, 1, '0000-00-00', 8, '2008-07-28', 1),
(15, '100002', 5, '0000-00-00', '', '0', '', '0', '', NULL, '', '', NULL, 1, '0000-00-00', 8, '0000-00-00', 8),
(16, '100003', 4, '0000-00-00', '', '0', '', '0', '', NULL, '', '', NULL, 1, '0000-00-00', 8, '0000-00-00', 8),
(17, '100004', 4, '0000-00-00', '', '0', '', '0', '', NULL, '', '', NULL, 1, '0000-00-00', 8, '0000-00-00', 8),
(18, '100005', 4, '0000-00-00', '', '0', '', '0', '', NULL, '', '', NULL, 1, '0000-00-00', 8, '0000-00-00', 8),
(19, '100006', 4, '0000-00-00', '', '0', '', '0', '', NULL, '', '', NULL, 1, '0000-00-00', 8, '0000-00-00', 8),
(20, '100007', 4, '0000-00-00', '', '0', '', '0', '', NULL, '', '', NULL, 1, '0000-00-00', 8, '0000-00-00', 8),
(21, '100008', 4, '0000-00-00', '', '0', '', '0', '', NULL, '', '', NULL, 1, '0000-00-00', 8, '0000-00-00', 8),
(22, '100009', 4, '0000-00-00', '', '0', '', '0', '', NULL, '', 'remarks 100009', NULL, 1, '0000-00-00', 8, '0000-00-00', 8),
(23, '100010', 4, '0000-00-00', '', '0', '', '0', '', NULL, '', '', NULL, 1, '0000-00-00', 8, '0000-00-00', 8),
(24, '100011', 4, '0000-00-00', '', '0', '', '0', '', NULL, '', 'remarks 100011', NULL, 1, '0000-00-00', 8, '0000-00-00', 8),
(25, '100012', 4, '0000-00-00', '', '0', '', '0', '', NULL, '', '', NULL, 1, '0000-00-00', 8, '0000-00-00', 8),
(26, '100013', 5, '0000-00-00', '', '0', '', '0', '', '', '', '100013', 0.00, 1, '0000-00-00', 8, '2008-07-25', 1),
(27, '100014', 4, '0000-00-00', '', '0', '', '0', '', NULL, '', '', NULL, 1, '0000-00-00', 8, '0000-00-00', 8),
(28, '100015', 4, '0000-00-00', '', '0', '', '0', '', NULL, '', 'remarks 100015', NULL, 1, '0000-00-00', 8, '0000-00-00', 8),
(29, '100016', 4, '0000-00-00', '', '0', '', '0', '', NULL, '', '', NULL, 1, '0000-00-00', 8, '0000-00-00', 8),
(30, '100017', 4, '0000-00-00', '', '0', '', '0', '', NULL, '', '', NULL, 1, '0000-00-00', 8, '0000-00-00', 8),
(31, '100018', 1, '0000-00-00', '', '0', '', '0', '', NULL, '', '', NULL, 1, '0000-00-00', 8, '2008-07-23', 1),
(32, '100019', 4, '0000-00-00', '', '0', '', '0', '', NULL, '', '', NULL, 1, '0000-00-00', 8, '0000-00-00', 8),
(33, '100020', 4, '0000-00-00', '', '0', '', '0', '', NULL, '', '', NULL, 1, '0000-00-00', 8, '0000-00-00', 8),
(34, '100021', 4, '0000-00-00', '', '0', '', '0', '', NULL, '', '100021', NULL, 1, '0000-00-00', 8, '0000-00-00', 8),
(35, '100022', 4, '0000-00-00', '', '0', '', '0', '', NULL, '', '', NULL, 1, '0000-00-00', 8, '2008-07-22', 1),
(36, '100023', 4, '0000-00-00', '', '0', '', '0', '', NULL, '', '', NULL, 1, '0000-00-00', 8, '2008-07-23', 1),
(37, '100024', 4, '0000-00-00', '', '0', '', '0', '', NULL, '', '', NULL, 1, '0000-00-00', 8, '2008-07-22', 1),
(38, '100025', 4, '0000-00-00', '', '0', '', '0', '', NULL, '', 'remarks 25', NULL, 1, '0000-00-00', 8, '2008-07-22', 1),
(39, '100026', 4, '0000-00-00', '', '0', '', '0', '', NULL, '', '', NULL, 1, '0000-00-00', 8, '2008-07-22', 1),
(40, '100027', 4, '0000-00-00', '', '0', '', '0', '', NULL, '', 'remarks for 100027', NULL, 1, '0000-00-00', 8, '2008-07-23', 1),
(41, '100028', 1, '0000-00-00', '', '0', 'contact person', 'admin name', 'contact no', NULL, '', '', NULL, 1, '0000-00-00', 8, '2008-07-23', 1),
(42, '100029', 5, '0000-00-00', '', '1', 'Bill Gate', 'admin name', '0012556666', '', '', '', 36.36, 1, '0000-00-00', 8, '2008-07-25', 1),
(43, '100030', 5, '0000-00-00', '', '0', 'Bill Gate', 'admin name', '0012556666', NULL, '', 'remarks 1', NULL, 1, '0000-00-00', 8, '2008-07-24', 1),
(44, '100031', 5, '0000-00-00', '', '0', 'Bill Gate', 'admin name', '0012556666', '', '', '', 138.00, 1, '0000-00-00', 8, '2008-07-24', 1),
(45, '100032', 6, '0000-00-00', '', '0', 'mr proton', 'admin name', '07-78996966', '019-78956630', '07-78996366', 'proton cust', 0.00, 2, '0000-00-00', 8, '2008-07-25', 1),
(46, '100033', 6, '0000-00-00', '', '0', 'mr proton', 'admin name', '07-78996966', '019-78956630', '07-78996366', 'proton 2', 27.32, 4, '0000-00-00', 8, '2008-07-25', 1),
(47, '100034', 1, '0000-00-00', '', '0', 'contact person', 'admin name', 'contact no', '', '', '', NULL, 1, '0000-00-00', 8, '2008-07-24', 1),
(48, '100035', 2, '0000-00-00', '', '0', 'cp', 'admin name', 'cn', '', '', '', NULL, 1, '0000-00-00', 8, '0000-00-00', 8),
(49, '100036', 2, '0000-00-00', '', '0', 'cp', 'admin name', 'cn', '', '', '', 36.12, 1, '0000-00-00', 8, '2008-07-24', 1),
(50, '100037', 5, '0000-00-00', '', '0', 'Bill Gate', 'admin name', '0012556666', '01236549', '07-7896225', '', 0.00, 1, '0000-00-00', 8, '2008-07-25', 1),
(51, '100038', 5, '2008-07-25', '', '0', 'Bill Gate', 'admin name', '0012556666', '01236549', '07-7896225', '', NULL, 3, '2008-07-25', 1, '2008-07-25', 1),
(52, '100039', 1, '2008-07-25', '', '0', 'contact person', 'admin name', 'contact no', '', '', '', 0.00, 5, '2008-07-25', 1, '2008-07-25', 1),
(53, '100040', 5, '2008-07-25', '', '1', 'Bill Gate', 'admin name', '0012556666', '01236549', '07-7896225', '', 10.56, 5, '2008-07-25', 1, '2008-07-25', 1),
(54, '100041', 8, '2008-07-28', '', '0', 'Feen Hoo', 'Tan Chang Perng', '078825296', '0177477296', '078835330', '* Goods sold are not refundable.\r\n* Goods sold in good condition.', 116.04, 5, '2008-07-28', 1, '2008-07-28', 1);

-- --------------------------------------------------------

-- 
-- Table structure for table `siminvoice_tblinvoiceline`
-- 

CREATE TABLE IF NOT EXISTS `siminvoice_tblinvoiceline` (
  `invoiceline_id` int(11) NOT NULL auto_increment,
  `invoice_seq` int(11) NOT NULL,
  `invoice_id` int(11) NOT NULL,
  `invoice_desc` text,
  `item_id` int(11) default NULL,
  `item_name` varchar(50) default NULL,
  `invoice_qty` int(11) default NULL,
  `invoice_unitprice` decimal(12,3) default NULL,
  `invoice_amount` decimal(12,2) default NULL,
  `invoice_discount` decimal(10,2) default NULL,
  `iscustomprice` smallint(6) NOT NULL default '0',
  PRIMARY KEY  (`invoiceline_id`),
  KEY `invoice_id` (`invoice_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=816 ;

-- 
-- Dumping data for table `siminvoice_tblinvoiceline`
-- 

INSERT INTO `siminvoice_tblinvoiceline` (`invoiceline_id`, `invoice_seq`, `invoice_id`, `invoice_desc`, `item_id`, `item_name`, `invoice_qty`, `invoice_unitprice`, `invoice_amount`, `invoice_discount`, `iscustomprice`) VALUES 
(32, 10, 36, 'item 1', 0, NULL, 0, 0.000, 0.00, NULL, 0),
(33, 20, 36, 'item 2', 0, NULL, 0, 0.000, 0.00, NULL, 0),
(34, 30, 36, 'item 222', 0, NULL, 0, 0.000, 0.00, NULL, 0),
(35, 10, 37, 'item 2', 0, NULL, 1, 12.000, 0.00, NULL, 0),
(36, 20, 37, 'item 1', 0, NULL, 4, 0.000, 0.00, NULL, 0),
(37, 30, 37, 'item 3', 0, NULL, 3, 3.000, 3.00, NULL, 0),
(38, 40, 37, 'item 4', 0, NULL, 4, 4.000, 4.00, NULL, 0),
(39, 10, 37, 'item 5', 0, NULL, 5, 0.000, 0.00, NULL, 0),
(40, 10, 37, 'item 6', 0, NULL, 6, 0.000, 0.00, NULL, 0),
(41, 10, 37, '', 0, NULL, 0, 0.000, 0.00, NULL, 0),
(42, 10, 37, '', 0, NULL, 0, 0.000, 0.00, NULL, 0),
(43, 10, 38, '', 0, NULL, 0, 0.000, 0.00, NULL, 0),
(48, 10, 39, 'item 100026', 0, NULL, 2, 0.000, 0.00, NULL, 0),
(49, 20, 39, 'item 2 100026', 0, NULL, 1, 0.000, 0.00, NULL, 0),
(50, 30, 39, '', 0, NULL, 0, 0.000, 0.00, NULL, 0),
(70, 10, 40, 'ietm 1', 1, NULL, 0, 0.000, 0.00, NULL, 0),
(71, 20, 40, 'ietm 2', 2, NULL, 0, 0.000, 0.00, NULL, 0),
(72, 30, 40, 'ietm 3', 3, NULL, 0, 0.000, 0.00, NULL, 0),
(73, 40, 40, 'ietm 4', 2, NULL, 0, 0.000, 0.00, NULL, 0),
(74, 50, 40, '', 0, NULL, 0, 0.000, 0.00, NULL, 0),
(102, 10, 43, '1', 1, NULL, 11, 111.000, 1111.00, NULL, 0),
(103, 20, 43, '2', 2, NULL, 22, 222.000, 1111.00, NULL, 0),
(189, 10, 41, '', 1, NULL, 0, 0.000, 0.00, NULL, 0),
(190, 20, 41, '222', 2, NULL, 0, 0.000, 0.00, NULL, 0),
(191, 30, 41, '', 3, NULL, 0, 0.000, 0.00, NULL, 0),
(469, 10, 49, '', 1, 'item 1', 2, 12.000, 24.00, 0.00, 0),
(470, 20, 49, '', 0, 'item cf', 3, 4.500, 12.12, 10.20, 0),
(540, 50, 42, '', 8, 'item 4', 1, 13.000, 12.84, 1.20, 0),
(541, 20, 42, '', 1, 'item 1', 2, 12.000, 23.52, 2.00, 0),
(595, 10, 46, '', 0, '', 0, 0.000, 0.00, 0.00, 0),
(596, 20, 46, '', 0, '', 0, 0.000, 0.00, 0.00, 0),
(597, 20, 46, 'dis desc', 0, 'item name 2', 1, 14.000, 12.32, 12.00, 0),
(598, 30, 46, 'desc 3', 3, 'item 3', 1, 15.000, 15.00, 0.00, 0),
(599, 50, 46, 'sda', 5, 'FF', 0, 12.000, 0.00, 0.00, 0),
(601, 10, 52, '', 7, 'desc', 0, 1221.000, 0.00, 0.00, 0),
(609, 10, 53, '', 1, 'item 1', 1, 12.000, 10.56, 12.00, 0),
(712, 10, 54, 'Special offer 2 set per order.', 1, 'item 1', 2, 12.000, 23.52, 2.00, 0),
(713, 20, 54, '', 2, 'item 2', 3, 22.000, 64.02, 3.00, 0),
(714, 30, 54, '', 3, 'item 3', 2, 15.000, 28.50, 5.00, 0),
(799, 10, 14, '00ii', 1, 'item 1', 0, 12.000, 0.00, 9.00, 0),
(800, 20, 14, '', 0, '', 0, 0.000, 0.00, 0.00, 0),
(801, 30, 14, '', 5, 'FF', 0, 12.000, 0.00, 0.00, 0),
(802, 40, 14, '', 0, '', 0, 0.000, 0.00, 0.00, 0),
(803, 50, 14, '', 0, '', 0, 0.000, 0.00, 0.00, 0),
(812, 10, 13, 'asdasd', 1, 'item 1', 0, 12.000, 0.00, 0.00, 0),
(813, 20, 13, 'as', 0, 'FFsad', 0, 12.000, 0.00, 0.00, 0),
(814, 30, 13, '', 2, 'item 2', 0, 22.000, 0.00, 0.00, 0),
(815, 40, 13, '', 1, 'item 1', 0, 12.000, 0.00, 0.00, 0);

-- --------------------------------------------------------

-- 
-- Table structure for table `siminvoice_tblitem`
-- 

CREATE TABLE IF NOT EXISTS `siminvoice_tblitem` (
  `item_id` int(11) NOT NULL auto_increment,
  `item_code` varchar(20) NOT NULL,
  `item_desc` varchar(50) NOT NULL,
  `category_id` int(11) NOT NULL,
  `item_amount` decimal(12,3) default NULL,
  `item_cost` decimal(12,3) default NULL,
  `isactive` char(1) default NULL,
  `created` date default NULL,
  `createdby` int(11) default NULL,
  `updated` date default NULL,
  `updatedby` int(11) default NULL,
  PRIMARY KEY  (`item_id`),
  UNIQUE KEY `item_code` (`item_code`),
  KEY `category_id` (`category_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

-- 
-- Dumping data for table `siminvoice_tblitem`
-- 

INSERT INTO `siminvoice_tblitem` (`item_id`, `item_code`, `item_desc`, `category_id`, `item_amount`, `item_cost`, `isactive`, `created`, `createdby`, `updated`, `updatedby`) VALUES 
(1, '10000', 'item 1', 1, 12.000, 122.000, '1', '0000-00-00', 8, '2008-07-23', 1),
(2, '10001', 'item 2', 3, 22.000, 24.000, '1', '0000-00-00', 8, '2008-07-23', 1),
(3, '10002', 'item 3', 1, 15.000, 15.800, '1', '0000-00-00', 8, '2008-07-22', 1),
(4, '0', ' ', 1, 0.000, 0.000, '1', '0000-00-00', 8, '2008-07-23', 1),
(5, '10003', 'FF', 3, 12.000, 13.000, '1', '0000-00-00', 8, '0000-00-00', 8),
(6, '10004', 'aa', 1, 0.000, 0.000, '1', '0000-00-00', 8, '0000-00-00', 8),
(7, '10005', 'desc', 1, 1221.000, 1221.000, '1', '0000-00-00', 8, '2008-07-24', 1),
(8, '10006', 'item 4', 1, 13.000, 10.000, '1', '0000-00-00', 8, '0000-00-00', 8);

-- --------------------------------------------------------

-- 
-- Table structure for table `siminvoice_tblpayment`
-- 

CREATE TABLE IF NOT EXISTS `siminvoice_tblpayment` (
  `payment_id` int(11) NOT NULL auto_increment,
  `payment_no` varchar(10) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `payment_type` int(11) default NULL,
  `payment_date` date default NULL,
  `payment_amount` decimal(12,2) default NULL,
  `payment_chequeno` varchar(30) default NULL,
  `payment_desc` text,
  `payment_person` int(11) default NULL,
  `payment_receivedby` varchar(30) default NULL,
  `created` date default NULL,
  `createdby` int(11) default NULL,
  `updated` date default NULL,
  `updatedby` int(11) default NULL,
  PRIMARY KEY  (`payment_id`),
  UNIQUE KEY `payment_no` (`payment_no`),
  KEY `customer_id` (`customer_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

-- 
-- Dumping data for table `siminvoice_tblpayment`
-- 

INSERT INTO `siminvoice_tblpayment` (`payment_id`, `payment_no`, `customer_id`, `payment_type`, `payment_date`, `payment_amount`, `payment_chequeno`, `payment_desc`, `payment_person`, `payment_receivedby`, `created`, `createdby`, `updated`, `updatedby`) VALUES 
(1, '1000000', 5, 2, '2008-07-25', 0.00, '', '', 1, '', '2008-07-24', 1, '2008-07-25', 1),
(2, '1000001', 5, 1, '2008-07-25', 12.00, '', '', 1, '', '2008-07-25', 1, '2008-07-25', 1),
(3, '1000002', 5, 2, '2008-07-25', 0.00, '', '', 1, '', '2008-07-25', 1, '2008-07-25', 1),
(4, '1000003', 5, 1, '2008-07-25', 10.00, '', '', 1, '', '2008-07-25', 1, '2008-07-25', 1),
(5, '1000004', 2, 1, '2008-07-28', 0.00, '', '', 1, '', '2008-07-28', 1, '2008-07-28', 1),
(6, '1000005', 8, 1, '2008-07-28', 50.00, '', '', 1, '', '2008-07-28', 1, '2008-07-28', 1);

-- --------------------------------------------------------

-- 
-- Table structure for table `siminvoice_tblpaymentline`
-- 

CREATE TABLE IF NOT EXISTS `siminvoice_tblpaymentline` (
  `paymentline_id` int(11) NOT NULL auto_increment,
  `payment_id` int(11) NOT NULL,
  `invoice_id` int(11) NOT NULL,
  `paymentline_amount` decimal(12,2) default NULL,
  `paymentline_desc` varchar(50) default NULL,
  PRIMARY KEY  (`paymentline_id`),
  KEY `payment_id` (`payment_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;

-- 
-- Dumping data for table `siminvoice_tblpaymentline`
-- 

INSERT INTO `siminvoice_tblpaymentline` (`paymentline_id`, `payment_id`, `invoice_id`, `paymentline_amount`, `paymentline_desc`) VALUES 
(9, 2, 26, 12.00, ''),
(12, 1, 26, 12.00, ''),
(13, 1, 42, 23.00, ''),
(15, 4, 53, 10.00, ''),
(16, 5, 0, 0.00, ''),
(17, 5, 0, 0.00, ''),
(19, 6, 54, 50.00, '');

-- --------------------------------------------------------

-- 
-- Table structure for table `siminvoice_tblquotation`
-- 

CREATE TABLE IF NOT EXISTS `siminvoice_tblquotation` (
  `quotation_id` int(11) NOT NULL auto_increment,
  `quotation_no` varchar(20) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `quotation_date` date default NULL,
  `quotation_terms` varchar(20) default NULL,
  `iscomplete` char(1) default NULL,
  `quotation_attn` varchar(50) default NULL,
  `quotation_preparedby` varchar(50) default NULL,
  `quotation_attntel` varchar(20) default NULL,
  `quotation_attntelhp` varchar(20) default NULL,
  `quotation_attnfax` varchar(30) default NULL,
  `quotation_remarks` text,
  `quotation_totalamount` decimal(12,2) default NULL,
  `terms_id` int(11) default NULL,
  `created` date default NULL,
  `createdby` int(11) default NULL,
  `updated` date default NULL,
  `updatedby` int(11) default NULL,
  PRIMARY KEY  (`quotation_id`),
  UNIQUE KEY `quotation_no` (`quotation_no`),
  UNIQUE KEY `terms_id` (`terms_id`),
  KEY `customer_id` (`customer_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

-- 
-- Dumping data for table `siminvoice_tblquotation`
-- 

INSERT INTO `siminvoice_tblquotation` (`quotation_id`, `quotation_no`, `customer_id`, `quotation_date`, `quotation_terms`, `iscomplete`, `quotation_attn`, `quotation_preparedby`, `quotation_attntel`, `quotation_attntelhp`, `quotation_attnfax`, `quotation_remarks`, `quotation_totalamount`, `terms_id`, `created`, `createdby`, `updated`, `updatedby`) VALUES 
(1, '1', 5, '0000-00-00', '', '0', 'Bill Gate', 'admin name', '0012556666', '01236549', '07-7896225', '', 12.00, 5, '0000-00-00', 8, '2008-07-28', 1),
(2, '2', 6, '0000-00-00', '', '0', 'mr proton', 'admin name', '07-78996966', '019-78956630', '07-78996366', 'sdssd', 1243.88, 1, '0000-00-00', 8, '2008-07-25', 1),
(3, '3', 5, '2008-07-25', '', '0', 'Bill Gate', 'admin name', '0012556666', '01236549', '07-7896225', '', 0.00, 4, '2008-07-25', 1, '2008-07-25', 1),
(4, '4', 6, '2008-07-25', '', '0', 'mr proton', 'admin name', '07-78996966', '019-78956630', '07-78996366', '', 0.00, 2, '2008-07-25', 1, '2008-07-25', 1);

-- --------------------------------------------------------

-- 
-- Table structure for table `siminvoice_tblquotationline`
-- 

CREATE TABLE IF NOT EXISTS `siminvoice_tblquotationline` (
  `quotationline_id` int(11) NOT NULL auto_increment,
  `quotation_seq` int(11) NOT NULL,
  `quotation_id` int(11) NOT NULL,
  `quotation_desc` text,
  `item_id` int(11) default NULL,
  `item_name` varchar(50) default NULL,
  `quotation_qty` int(11) default NULL,
  `quotation_unitprice` decimal(12,3) default NULL,
  `quotation_amount` decimal(12,2) default NULL,
  `quotation_discount` decimal(10,2) default NULL,
  PRIMARY KEY  (`quotationline_id`),
  KEY `quotation_id` (`quotation_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=26 ;

-- 
-- Dumping data for table `siminvoice_tblquotationline`
-- 

INSERT INTO `siminvoice_tblquotationline` (`quotationline_id`, `quotation_seq`, `quotation_id`, `quotation_desc`, `item_id`, `item_name`, `quotation_qty`, `quotation_unitprice`, `quotation_amount`, `quotation_discount`) VALUES 
(17, 10, 2, '', 7, 'desc', 1, 1221.000, 1221.00, 0.00),
(19, 10, 3, '', 0, 'aa', 0, 0.000, 0.00, 0.00),
(20, 20, 3, '', 7, 'desc', 0, 1221.000, 0.00, 0.00),
(21, 10, 4, '', 0, '1', 0, 0.000, 0.00, 0.00),
(22, 20, 4, '', 0, '2', 0, 0.000, 0.00, 0.00),
(23, 30, 4, '', 0, '3', 0, 0.000, 0.00, 0.00),
(24, 10, 1, '', 1, 'item 1', 1, 12.000, 12.00, 0.00),
(25, 20, 1, '', 0, '', 0, 0.000, 0.00, 0.00);

-- --------------------------------------------------------

-- 
-- Table structure for table `siminvoice_tblstate`
-- 

CREATE TABLE IF NOT EXISTS `siminvoice_tblstate` (
  `customer_state` int(11) NOT NULL,
  `state` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- Dumping data for table `siminvoice_tblstate`
-- 

INSERT INTO `siminvoice_tblstate` (`customer_state`, `state`) VALUES 
(14, 'Johor'),
(1, 'Melaka'),
(2, 'Selangor'),
(3, 'Negeri Sembilan'),
(4, 'Perak'),
(5, 'Pahang'),
(6, 'Pulau Penang'),
(7, 'Kedah'),
(8, 'Perlis'),
(9, 'Terengganu'),
(10, 'Kelantan'),
(11, 'Sabah'),
(12, 'Sarawak'),
(13, 'Kuala Lumpur');

-- --------------------------------------------------------

-- 
-- Table structure for table `siminvoice_tblterms`
-- 

CREATE TABLE IF NOT EXISTS `siminvoice_tblterms` (
  `terms_id` int(11) NOT NULL auto_increment,
  `terms_code` varchar(20) NOT NULL,
  `terms_desc` varchar(50) default NULL,
  `terms_days` int(11) default NULL,
  `isactive` char(1) default NULL,
  `created` date default NULL,
  `createdby` int(11) default NULL,
  `updated` date default NULL,
  `updatedby` int(11) default NULL,
  PRIMARY KEY  (`terms_id`),
  UNIQUE KEY `terms_no` (`terms_code`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

-- 
-- Dumping data for table `siminvoice_tblterms`
-- 

INSERT INTO `siminvoice_tblterms` (`terms_id`, `terms_code`, `terms_desc`, `terms_days`, `isactive`, `created`, `createdby`, `updated`, `updatedby`) VALUES 
(1, '100000', '30 days', 30, '1', '2008-07-25', 1, '2008-07-25', 1),
(2, '100001', '15 Days', 15, '1', '2008-07-25', 1, '2008-07-25', 1),
(3, '100002', '60 Days', 60, '1', '2008-07-25', 1, '2008-07-25', 1),
(4, '100003', 'Cash on delivery', 0, '1', '2008-07-25', 1, '2008-07-25', 1),
(5, '100004', '120 Days', 120, '1', '2008-07-25', 1, '2008-07-25', 1);

-- --------------------------------------------------------

-- 
-- Table structure for table `siminvoice_tplfile`
-- 

CREATE TABLE IF NOT EXISTS `siminvoice_tplfile` (
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
-- Dumping data for table `siminvoice_tplfile`
-- 

INSERT INTO `siminvoice_tplfile` (`tpl_id`, `tpl_refid`, `tpl_module`, `tpl_tplset`, `tpl_file`, `tpl_desc`, `tpl_lastmodified`, `tpl_lastimported`, `tpl_type`) VALUES 
(1, 1, 'system', 'default', 'system_imagemanager.html', '', 1212942798, 1212942798, 'module'),
(2, 1, 'system', 'default', 'system_imagemanager2.html', '', 1212942798, 1212942798, 'module'),
(3, 1, 'system', 'default', 'system_userinfo.html', '', 1212942798, 1212942798, 'module'),
(4, 1, 'system', 'default', 'system_userform.html', '', 1212942798, 1212942798, 'module'),
(5, 1, 'system', 'default', 'system_rss.html', '', 1212942798, 1212942798, 'module'),
(6, 1, 'system', 'default', 'system_redirect.html', '', 1212942798, 1212942798, 'module'),
(7, 1, 'system', 'default', 'system_comment.html', '', 1212942798, 1212942798, 'module'),
(8, 1, 'system', 'default', 'system_comments_flat.html', '', 1212942798, 1212942798, 'module'),
(9, 1, 'system', 'default', 'system_comments_thread.html', '', 1212942798, 1212942798, 'module'),
(10, 1, 'system', 'default', 'system_comments_nest.html', '', 1212942798, 1212942798, 'module'),
(11, 1, 'system', 'default', 'system_siteclosed.html', '', 1212942798, 1212942798, 'module'),
(12, 1, 'system', 'default', 'system_dummy.html', 'Dummy template file for holding non-template contents. This should not be edited.', 1212942798, 1212942798, 'module'),
(13, 1, 'system', 'default', 'system_notification_list.html', '', 1212942798, 1212942798, 'module'),
(14, 1, 'system', 'default', 'system_notification_select.html', '', 1212942798, 1212942798, 'module'),
(15, 1, 'system', 'default', 'system_block_dummy.html', 'Dummy template for custom blocks or blocks without templates', 1212942798, 1212942798, 'module'),
(16, 1, 'system', 'default', 'system_block_user.html', 'Shows user block', 1212942798, 1212942798, 'block'),
(17, 2, 'system', 'default', 'system_block_login.html', 'Shows login form', 1212942798, 1212942798, 'block'),
(18, 3, 'system', 'default', 'system_block_search.html', 'Shows search form block', 1212942798, 1212942798, 'block'),
(19, 4, 'system', 'default', 'system_block_waiting.html', 'Shows contents waiting for approval', 1212942798, 1212942798, 'block'),
(20, 5, 'system', 'default', 'system_block_mainmenu.html', 'Shows the main navigation menu of the site', 1212942798, 1212942798, 'block'),
(21, 6, 'system', 'default', 'system_block_siteinfo.html', 'Shows basic info about the site and a link to Recommend Us pop up window', 1212942798, 1212942798, 'block'),
(22, 7, 'system', 'default', 'system_block_online.html', 'Displays users/guests currently online', 1212942798, 1212942798, 'block'),
(23, 8, 'system', 'default', 'system_block_topusers.html', 'Top posters', 1212942798, 1212942798, 'block'),
(24, 9, 'system', 'default', 'system_block_newusers.html', 'Shows most recent users', 1212942798, 1212942798, 'block'),
(25, 10, 'system', 'default', 'system_block_comments.html', 'Shows most recent comments', 1212942798, 1212942798, 'block'),
(26, 11, 'system', 'default', 'system_block_notification.html', 'Shows notification options', 1212942798, 1212942798, 'block'),
(27, 12, 'system', 'default', 'system_block_themes.html', 'Shows theme selection box', 1212942798, 1212942798, 'block');

-- --------------------------------------------------------

-- 
-- Table structure for table `siminvoice_tplset`
-- 

CREATE TABLE IF NOT EXISTS `siminvoice_tplset` (
  `tplset_id` int(7) unsigned NOT NULL auto_increment,
  `tplset_name` varchar(50) NOT NULL default '',
  `tplset_desc` varchar(255) NOT NULL default '',
  `tplset_credits` text NOT NULL,
  `tplset_created` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`tplset_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- 
-- Dumping data for table `siminvoice_tplset`
-- 

INSERT INTO `siminvoice_tplset` (`tplset_id`, `tplset_name`, `tplset_desc`, `tplset_credits`, `tplset_created`) VALUES 
(1, 'default', 'XOOPS Default Template Set', '', 1212942798);

-- --------------------------------------------------------

-- 
-- Table structure for table `siminvoice_tplsource`
-- 

CREATE TABLE IF NOT EXISTS `siminvoice_tplsource` (
  `tpl_id` mediumint(7) unsigned NOT NULL default '0',
  `tpl_source` mediumtext NOT NULL,
  KEY `tpl_id` (`tpl_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- Dumping data for table `siminvoice_tplsource`
-- 

INSERT INTO `siminvoice_tplsource` (`tpl_id`, `tpl_source`) VALUES 
(1, '<!DOCTYPE html PUBLIC ''-//W3C//DTD XHTML 1.0 Transitional//EN'' ''http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd''>\r\n<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<{$xoops_langcode}>" lang="<{$xoops_langcode}>">\r\n<head>\r\n<meta http-equiv="content-type" content="text/html; charset=<{$xoops_charset}>" />\r\n<meta http-equiv="content-language" content="<{$xoops_langcode}>" />\r\n<title><{$sitename}> <{$lang_imgmanager}></title>\r\n<script type="text/javascript">\r\n<!--//\r\nfunction appendCode(addCode) {\r\n	var targetDom = window.opener.xoopsGetElementById(''<{$target}>'');\r\n	if (targetDom.createTextRange && targetDom.caretPos){\r\n  		var caretPos = targetDom.caretPos;\r\n		caretPos.text = caretPos.text.charAt(caretPos.text.length - 1) \r\n== '' '' ? addCode + '' '' : addCode;  \r\n	} else if (targetDom.getSelection && targetDom.caretPos){\r\n		var caretPos = targetDom.caretPos;\r\n		caretPos.text = caretPos.text.charat(caretPos.text.length - 1)  \r\n== '' '' ? addCode + '' '' : addCode;\r\n	} else {\r\n		targetDom.value = targetDom.value + addCode;\r\n  	}\r\n	window.close();\r\n	return;\r\n}\r\n//-->\r\n</script>\r\n<style type="text/css" media="all">\r\nbody {margin: 0;}\r\nimg {border: 0;}\r\ntable {width: 100%; margin: 0;}\r\na:link {color: #3a76d6; font-weight: bold; background-color: transparent;}\r\na:visited {color: #9eb2d6; font-weight: bold; background-color: transparent;}\r\na:hover {color: #e18a00; background-color: transparent;}\r\ntable td {background-color: white; font-size: 12px; padding: 0; border-width: 0; vertical-align: top; font-family: Verdana, Arial, Helvetica, sans-serif;}\r\ntable#imagenav td {vertical-align: bottom; padding: 5px;}\r\ntable#imagemain td {border-right: 1px solid silver; border-bottom: 1px solid silver; padding: 5px; vertical-align: middle;}\r\ntable#imagemain th {border: 0; background-color: #2F5376; color:white; font-size: 12px; padding: 5px; vertical-align: top; text-align:center; font-family: Verdana, Arial, Helvetica, sans-serif;}\r\ntable#header td {width: 100%; background-color: #2F5376; vertical-align: middle;}\r\ntable#header td#headerbar {border-bottom: 1px solid silver; background-color: #dddddd;}\r\ndiv#pagenav {text-align:center;}\r\ndiv#footer {text-align:right; padding: 5px;}\r\n</style>\r\n</head>\r\n\r\n<body onload="window.resizeTo(<{$xsize}>, <{$ysize}>);">\r\n  <table id="header" cellspacing="0">\r\n    <tr>\r\n      <td><a href="<{$xoops_url}>/"><img src="<{$xoops_url}>/images/logo.gif" width="150" height="80" alt="" /></a></td><td> </td>\r\n    </tr>\r\n    <tr>\r\n      <td id="headerbar" colspan="2"> </td>\r\n    </tr>\r\n  </table>\r\n\r\n  <form action="imagemanager.php" method="get">\r\n    <table cellspacing="0" id="imagenav">\r\n      <tr>\r\n        <td>\r\n          <select name="cat_id" onchange="location=''<{$xoops_url}>/imagemanager.php?target=<{$target}>&cat_id=''+this.options[this.selectedIndex].value"><{$cat_options}></select> <input type="hidden" name="target" value="<{$target}>" /><input type="submit" value="<{$lang_go}>" />\r\n        </td>\r\n\r\n        <{if $show_cat > 0}>\r\n        <td align="right"><a href="<{$xoops_url}>/imagemanager.php?target=<{$target}>&op=upload&imgcat_id=<{$show_cat}>"><{$lang_addimage}></a></td>\r\n        <{/if}>\r\n\r\n      </tr>\r\n    </table>\r\n  </form>\r\n\r\n  <{if $image_total > 0}>\r\n\r\n  <table cellspacing="0" id="imagemain">\r\n    <tr>\r\n      <th><{$lang_imagename}></th>\r\n      <th><{$lang_image}></th>\r\n      <th><{$lang_imagemime}></th>\r\n      <th><{$lang_align}></th>\r\n    </tr>\r\n\r\n    <{section name=i loop=$images}>\r\n    <tr align="center">\r\n      <td><input type="hidden" name="image_id[]" value="<{$images[i].id}>" /><{$images[i].nicename}></td>\r\n      <td><img src="<{$images[i].src}>" alt="" /></td>\r\n      <td><{$images[i].mimetype}></td>\r\n      <td><a href="#" onclick="javascript:appendCode(''<{$images[i].lxcode}>'');"><img src="<{$xoops_url}>/images/alignleft.gif" alt="Left" /></a> <a href="#" onclick="javascript:appendCode(''<{$images[i].xcode}>'');"><img src="<{$xoops_url}>/images/aligncenter.gif" alt="Center" /></a> <a href="#" onclick="javascript:appendCode(''<{$images[i].rxcode}>'');"><img src="<{$xoops_url}>/images/alignright.gif" alt="Right" /></a></td>\r\n    </tr>\r\n    <{/section}>\r\n  </table>\r\n\r\n  <{/if}>\r\n\r\n  <div id="pagenav"><{$pagenav}></div>\r\n\r\n  <div id="footer">\r\n    <input value="<{$lang_close}>" type="button" onclick="javascript:window.close();" />\r\n  </div>\r\n\r\n  </body>\r\n</html>'),
(2, '<!DOCTYPE html PUBLIC ''-//W3C//DTD XHTML 1.0 Transitional//EN'' ''http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd''>\r\n<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<{$xoops_langcode}>" lang="<{$xoops_langcode}>">\r\n<head>\r\n<meta http-equiv="content-type" content="text/html; charset=<{$xoops_charset}>" />\r\n<meta http-equiv="content-language" content="<{$xoops_langcode}>" />\r\n<title><{$xoops_sitename}> <{$lang_imgmanager}></title>\r\n<{$image_form.javascript}>\r\n<style type="text/css" media="all">\r\nbody {margin: 0;}\r\nimg {border: 0;}\r\ntable {width: 100%; margin: 0;}\r\na:link {color: #3a76d6; font-weight: bold; background-color: transparent;}\r\na:visited {color: #9eb2d6; font-weight: bold; background-color: transparent;}\r\na:hover {color: #e18a00; background-color: transparent;}\r\ntable td {background-color: white; font-size: 12px; padding: 0; border-width: 0; vertical-align: top; font-family: Verdana, Arial, Helvetica, sans-serif;}\r\ntable#imagenav td {vertical-align: bottom; padding: 5px;}\r\ntd.body {padding: 5px; vertical-align: middle;}\r\ntd.caption {border: 0; background-color: #2F5376; color:white; font-size: 12px; padding: 5px; vertical-align: top; text-align:left; font-family: Verdana, Arial, Helvetica, sans-serif;}\r\ntable#imageform {border: 1px solid silver;}\r\ntable#header td {width: 100%; background-color: #2F5376; vertical-align: middle;}\r\ntable#header td#headerbar {border-bottom: 1px solid silver; background-color: #dddddd;}\r\ndiv#footer {text-align:right; padding: 5px;}\r\n</style>\r\n</head>\r\n\r\n<body onload="window.resizeTo(<{$xsize}>, <{$ysize}>);">\r\n  <table id="header" cellspacing="0">\r\n    <tr>\r\n      <td><a href="<{$xoops_url}>/"><img src="<{$xoops_url}>/images/logo.gif" width="150" height="80" alt="" /></a></td><td> </td>\r\n    </tr>\r\n    <tr>\r\n      <td id="headerbar" colspan="2"> </td>\r\n    </tr>\r\n  </table>\r\n\r\n  <table cellspacing="0" id="imagenav">\r\n    <tr>\r\n      <td align="left"><a href="<{$xoops_url}>/imagemanager.php?target=<{$target}>&amp;cat_id=<{$show_cat}>"><{$lang_imgmanager}></a></td>\r\n    </tr>\r\n  </table>\r\n\r\n  <form name="<{$image_form.name}>" id="<{$image_form.name}>" action="<{$image_form.action}>" method="<{$image_form.method}>" <{$image_form.extra}>>\r\n    <table id="imageform" cellspacing="0">\r\n    <!-- start of form elements loop -->\r\n    <{foreach item=element from=$image_form.elements}>\r\n      <{if $element.hidden != true}>\r\n      <tr valign="top">\r\n        <td class="caption"><{$element.caption}></td>\r\n        <td class="body"><{$element.body}></td>\r\n      </tr>\r\n      <{else}>\r\n      <{$element.body}>\r\n      <{/if}>\r\n    <{/foreach}>\r\n    <!-- end of form elements loop -->\r\n    </table>\r\n  </form>\r\n\r\n\r\n  <div id="footer">\r\n    <input value="<{$lang_close}>" type="button" onclick="javascript:window.close();" />\r\n  </div>\r\n\r\n  </body>\r\n</html>'),
(3, '<{if $user_ownpage == true}>\r\n\r\n<form name="usernav" action="user.php" method="post">\r\n\r\n<br /><br />\r\n\r\n<table width="70%" align="center" border="0">\r\n  <tr align="center">\r\n    <td><input type="button" value="<{$lang_editprofile}>" onclick="location=''edituser.php''" />\r\n    <input type="button" value="<{$lang_avatar}>" onclick="location=''edituser.php?op=avatarform''" />\r\n    <input type="button" value="<{$lang_inbox}>" onclick="location=''viewpmsg.php''" />\r\n\r\n    <{if $user_candelete == true}>\r\n    <input type="button" value="<{$lang_deleteaccount}>" onclick="location=''user.php?op=delete''" />\r\n    <{/if}>\r\n\r\n    <input type="button" value="<{$lang_logout}>" onclick="location=''user.php?op=logout''" /></td>\r\n  </tr>\r\n</table>\r\n</form>\r\n\r\n<br /><br />\r\n<{elseif $xoops_isadmin != false}>\r\n\r\n<br /><br />\r\n\r\n<table width="70%" align="center" border="0">\r\n  <tr align="center">\r\n    <td><input type="button" value="<{$lang_editprofile}>" onclick="location=''<{$xoops_url}>/modules/system/admin.php?fct=users&uid=<{$user_uid}>&op=modifyUser''" />\r\n    <input type="button" value="<{$lang_deleteaccount}>" onclick="location=''<{$xoops_url}>/modules/system/admin.php?fct=users&op=delUser&uid=<{$user_uid}>''" />\r\n  </tr>\r\n</table>\r\n\r\n<br /><br />\r\n<{/if}>\r\n\r\n<table width="100%" border="0" cellspacing="5">\r\n  <tr valign="top">\r\n    <td width="50%">\r\n      <table class="outer" cellpadding="4" cellspacing="1" width="100%">\r\n        <tr>\r\n          <th colspan="2" align="center"><{$lang_allaboutuser}></th>\r\n        </tr>\r\n        <tr valign="top">\r\n          <td class="head"><{$lang_avatar}></td>\r\n          <td align="center" class="even"><img src="<{$user_avatarurl}>" alt="Avatar" /></td>\r\n        </tr>\r\n        <tr>\r\n          <td class="head"><{$lang_realname}></td>\r\n          <td align="center" class="odd"><{$user_realname}></td>\r\n        </tr>\r\n        <tr>\r\n          <td class="head"><{$lang_website}></td>\r\n          <td class="even"><{$user_websiteurl}></td>\r\n        </tr>\r\n        <tr valign="top">\r\n          <td class="head"><{$lang_email}></td>\r\n          <td class="odd"><{$user_email}></td>\r\n        </tr>\r\n	<tr valign="top">\r\n          <td class="head"><{$lang_privmsg}></td>\r\n          <td class="even"><{$user_pmlink}></td>\r\n        </tr>\r\n        <tr valign="top">\r\n          <td class="head"><{$lang_icq}></td>\r\n          <td class="odd"><{$user_icq}></td>\r\n        </tr>\r\n        <tr valign="top">\r\n          <td class="head"><{$lang_aim}></td>\r\n          <td class="even"><{$user_aim}></td>\r\n        </tr>\r\n        <tr valign="top">\r\n          <td class="head"><{$lang_yim}></td>\r\n          <td class="odd"><{$user_yim}></td>\r\n        </tr>\r\n        <tr valign="top">\r\n          <td class="head"><{$lang_msnm}></td>\r\n          <td class="even"><{$user_msnm}></td>\r\n        </tr>\r\n        <tr valign="top">\r\n          <td class="head"><{$lang_location}></td>\r\n          <td class="odd"><{$user_location}></td>\r\n        </tr>\r\n        <tr valign="top">\r\n          <td class="head"><{$lang_occupation}></td>\r\n          <td class="even"><{$user_occupation}></td>\r\n        </tr>\r\n        <tr valign="top">\r\n          <td class="head"><{$lang_interest}></td>\r\n          <td class="odd"><{$user_interest}></td>\r\n        </tr>\r\n        <tr valign="top">\r\n          <td class="head"><{$lang_extrainfo}></td>\r\n          <td class="even"><{$user_extrainfo}></td>\r\n        </tr>\r\n      </table>\r\n    </td>\r\n    <td width="50%">\r\n      <table class="outer" cellpadding="4" cellspacing="1" width="100%">\r\n        <tr valign="top">\r\n          <th colspan="2" align="center"><{$lang_statistics}></th>\r\n        </tr>\r\n        <tr valign="top">\r\n          <td class="head"><{$lang_membersince}></td>\r\n          <td align="center" class="even"><{$user_joindate}></td>\r\n        </tr>\r\n        <tr valign="top">\r\n          <td class="head"><{$lang_rank}></td>\r\n          <td align="center" class="odd"><{$user_rankimage}><br /><{$user_ranktitle}></td>\r\n        </tr>\r\n        <tr valign="top">\r\n          <td class="head"><{$lang_posts}></td>\r\n          <td align="center" class="even"><{$user_posts}></td>\r\n        </tr>\r\n	<tr valign="top">\r\n          <td class="head"><{$lang_lastlogin}></td>\r\n          <td align="center" class="odd"><{$user_lastlogin}></td>\r\n        </tr>\r\n      </table>\r\n      <br />\r\n      <table class="outer" cellpadding="4" cellspacing="1" width="100%">\r\n        <tr valign="top">\r\n          <th colspan="2" align="center"><{$lang_signature}></th>\r\n        </tr>\r\n        <tr valign="top">\r\n          <td class="even"><{$user_signature}></td>\r\n        </tr>\r\n      </table>\r\n    </td>\r\n  </tr>\r\n</table>\r\n\r\n<!-- start module search results loop -->\r\n<{foreach item=module from=$modules}>\r\n\r\n<p>\r\n<h4><{$module.name}></h4>\r\n\r\n  <!-- start results item loop -->\r\n  <{foreach item=result from=$module.results}>\r\n\r\n  <img src="<{$result.image}>" alt="<{$module.name}>" /><b><a href="<{$result.link}>"><{$result.title}></a></b><br /><small>(<{$result.time}>)</small><br />\r\n\r\n  <{/foreach}>\r\n  <!-- end results item loop -->\r\n\r\n<{$module.showall_link}>\r\n</p>\r\n\r\n<{/foreach}>\r\n<!-- end module search results loop -->\r\n'),
(4, '<fieldset style="padding: 10px;">\r\n  <legend style="font-weight: bold;"><{$lang_login}></legend>\r\n  <form action="user.php" method="post">\r\n    <{$lang_username}> <input type="text" name="uname" size="26" maxlength="25" value="<{$usercookie}>" /><br />\r\n    <{$lang_password}> <input type="password" name="pass" size="21" maxlength="32" /><br />\r\n    <input type="hidden" name="op" value="login" />\r\n    <input type="hidden" name="xoops_redirect" value="<{$redirect_page}>" />\r\n    <input type="submit" value="<{$lang_login}>" />\r\n  </form>\r\n  <a name="lost"></a>\r\n  <div><{$lang_notregister}><br /></div>\r\n</fieldset>\r\n\r\n<br />\r\n\r\n<fieldset style="padding: 10px;">\r\n  <legend style="font-weight: bold;"><{$lang_lostpassword}></legend>\r\n  <div><br /><{$lang_noproblem}></div>\r\n  <form action="lostpass.php" method="post">\r\n    <{$lang_youremail}> <input type="text" name="email" size="26" maxlength="60" />&nbsp;&nbsp;<input type="hidden" name="op" value="mailpasswd" /><input type="hidden" name="t" value="<{$mailpasswd_token}>" /><input type="submit" value="<{$lang_sendpassword}>" />\r\n  </form>\r\n</fieldset>'),
(5, '<?xml version="1.0" encoding="UTF-8"?>\r\n<rss version="2.0">\r\n  <channel>\r\n    <title><{$channel_title}></title>\r\n    <link><{$channel_link}></link>\r\n    <description><{$channel_desc}></description>\r\n    <lastBuildDate><{$channel_lastbuild}></lastBuildDate>\r\n    <docs>http://backend.userland.com/rss/</docs>\r\n    <generator><{$channel_generator}></generator>\r\n    <category><{$channel_category}></category>\r\n    <managingEditor><{$channel_editor}></managingEditor>\r\n    <webMaster><{$channel_webmaster}></webMaster>\r\n    <language><{$channel_language}></language>\r\n    <{if $image_url != ""}>\r\n    <image>\r\n      <title><{$channel_title}></title>\r\n      <url><{$image_url}></url>\r\n      <link><{$channel_link}></link>\r\n      <width><{$image_width}></width>\r\n      <height><{$image_height}></height>\r\n    </image>\r\n    <{/if}>\r\n    <{foreach item=item from=$items}>\r\n    <item>\r\n      <title><{$item.title}></title>\r\n      <link><{$item.link}></link>\r\n      <description><{$item.description}></description>\r\n      <pubDate><{$item.pubdate}></pubDate>\r\n      <guid><{$item.guid}></guid>\r\n    </item>\r\n    <{/foreach}>\r\n  </channel>\r\n</rss>'),
(6, '<!DOCTYPE html PUBLIC ''-//W3C//DTD XHTML 1.0 Transitional//EN'' ''http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd''>\r\n<html>\r\n<head>\r\n<meta http-equiv="Content-Type" content="text/html; charset=<{$xoops_charset}>" />\r\n<meta http-equiv="Refresh" content="<{$time}>; url=<{$url}>" />\r\n<title><{$xoops_sitename}></title>\r\n<link rel="stylesheet" type="text/css" media="all" href="<{$xoops_themecss}>" />\r\n</head>\r\n<body>\r\n<div style="text-align:center; background-color: #EBEBEB; border-top: 1px solid #FFFFFF; border-left: 1px solid #FFFFFF; border-right: 1px solid #AAAAAA; border-bottom: 1px solid #AAAAAA; font-weight : bold;">\r\n  <h4><{$message}></h4>\r\n  <p><{$lang_ifnotreload}></p>\r\n</div>\r\n<{if $xoops_logdump != ''''}><div><{$xoops_logdump}></div><{/if}>\r\n</body>\r\n</html>\r\n'),
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
-- Table structure for table `siminvoice_users`
-- 

CREATE TABLE IF NOT EXISTS `siminvoice_users` (
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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- 
-- Dumping data for table `siminvoice_users`
-- 

INSERT INTO `siminvoice_users` (`uid`, `name`, `uname`, `email`, `url`, `user_avatar`, `user_regdate`, `user_icq`, `user_from`, `user_sig`, `user_viewemail`, `actkey`, `user_aim`, `user_yim`, `user_msnm`, `pass`, `posts`, `attachsig`, `rank`, `level`, `theme`, `timezone_offset`, `last_login`, `umode`, `uorder`, `notify_method`, `notify_mode`, `user_occ`, `bio`, `user_intrest`, `user_mailok`) VALUES 
(1, 'admin name', 'admin', 'admin@simit.com.my', 'http://localhost/siminvoice/', 'blank.gif', 1212942798, '', '', '', 1, '', '', '', '', '21232f297a57a5a743894a0e4a801fc3', 0, 0, 7, 5, 'default', 0.0, 1217232511, 'thread', 0, 1, 0, '', '', '', 0);

-- --------------------------------------------------------

-- 
-- Table structure for table `siminvoice_xoopscomments`
-- 

CREATE TABLE IF NOT EXISTS `siminvoice_xoopscomments` (
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
-- Dumping data for table `siminvoice_xoopscomments`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `siminvoice_xoopsnotifications`
-- 

CREATE TABLE IF NOT EXISTS `siminvoice_xoopsnotifications` (
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
-- Dumping data for table `siminvoice_xoopsnotifications`
-- 


-- 
-- Constraints for dumped tables
-- 

-- 
-- Constraints for table `siminvoice_siminvoice_checkup`
-- 
ALTER TABLE `siminvoice_siminvoice_checkup`
  ADD CONSTRAINT `siminvoice_siminvoice_checkup_ibfk_3` FOREIGN KEY (`worker_id`) REFERENCES `siminvoice_siminvoice_worker` (`worker_id`),
  ADD CONSTRAINT `siminvoice_siminvoice_checkup_ibfk_4` FOREIGN KEY (`company_id`) REFERENCES `siminvoice_siminvoice_company` (`company_id`);

-- 
-- Constraints for table `siminvoice_siminvoice_loanpayment`
-- 
ALTER TABLE `siminvoice_siminvoice_loanpayment`
  ADD CONSTRAINT `siminvoice_siminvoice_loanpayment_ibfk_1` FOREIGN KEY (`worker_id`) REFERENCES `siminvoice_siminvoice_worker` (`worker_id`);

-- 
-- Constraints for table `siminvoice_siminvoice_worker`
-- 
ALTER TABLE `siminvoice_siminvoice_worker`
  ADD CONSTRAINT `siminvoice_siminvoice_worker_ibfk_1` FOREIGN KEY (`races_id`) REFERENCES `siminvoice_siminvoice_races` (`races_id`),
  ADD CONSTRAINT `siminvoice_siminvoice_worker_ibfk_2` FOREIGN KEY (`nationality_id`) REFERENCES `siminvoice_siminvoice_nationality` (`nationality_id`);

-- 
-- Constraints for table `siminvoice_siminvoice_workercompany`
-- 
ALTER TABLE `siminvoice_siminvoice_workercompany`
  ADD CONSTRAINT `siminvoice_siminvoice_workercompany_ibfk_2` FOREIGN KEY (`worker_id`) REFERENCES `siminvoice_siminvoice_worker` (`worker_id`),
  ADD CONSTRAINT `siminvoice_siminvoice_workercompany_ibfk_3` FOREIGN KEY (`company_id`) REFERENCES `siminvoice_siminvoice_company` (`company_id`);

-- 
-- Constraints for table `siminvoice_siminvoice_workpermit`
-- 
ALTER TABLE `siminvoice_siminvoice_workpermit`
  ADD CONSTRAINT `siminvoice_siminvoice_workpermit_ibfk_1` FOREIGN KEY (`worker_id`) REFERENCES `siminvoice_siminvoice_worker` (`worker_id`),
  ADD CONSTRAINT `siminvoice_siminvoice_workpermit_ibfk_2` FOREIGN KEY (`company_id`) REFERENCES `siminvoice_siminvoice_company` (`company_id`);

-- 
-- Constraints for table `siminvoice_tblinvoice`
-- 
ALTER TABLE `siminvoice_tblinvoice`
  ADD CONSTRAINT `siminvoice_tblinvoice_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `siminvoice_tblcustomer` (`customer_id`),
  ADD CONSTRAINT `siminvoice_tblinvoice_ibfk_2` FOREIGN KEY (`terms_id`) REFERENCES `siminvoice_tblterms` (`terms_id`);

-- 
-- Constraints for table `siminvoice_tblinvoiceline`
-- 
ALTER TABLE `siminvoice_tblinvoiceline`
  ADD CONSTRAINT `siminvoice_tblinvoiceline_ibfk_1` FOREIGN KEY (`invoice_id`) REFERENCES `siminvoice_tblinvoice` (`invoice_id`);

-- 
-- Constraints for table `siminvoice_tblitem`
-- 
ALTER TABLE `siminvoice_tblitem`
  ADD CONSTRAINT `siminvoice_tblitem_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `siminvoice_tblcategory` (`category_id`);

-- 
-- Constraints for table `siminvoice_tblpayment`
-- 
ALTER TABLE `siminvoice_tblpayment`
  ADD CONSTRAINT `siminvoice_tblpayment_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `siminvoice_tblcustomer` (`customer_id`);

-- 
-- Constraints for table `siminvoice_tblpaymentline`
-- 
ALTER TABLE `siminvoice_tblpaymentline`
  ADD CONSTRAINT `siminvoice_tblpaymentline_ibfk_1` FOREIGN KEY (`payment_id`) REFERENCES `siminvoice_tblpayment` (`payment_id`);

-- 
-- Constraints for table `siminvoice_tblquotation`
-- 
ALTER TABLE `siminvoice_tblquotation`
  ADD CONSTRAINT `siminvoice_tblquotation_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `siminvoice_tblcustomer` (`customer_id`),
  ADD CONSTRAINT `siminvoice_tblquotation_ibfk_2` FOREIGN KEY (`terms_id`) REFERENCES `siminvoice_tblterms` (`terms_id`);

-- 
-- Constraints for table `siminvoice_tblquotationline`
-- 
ALTER TABLE `siminvoice_tblquotationline`
  ADD CONSTRAINT `siminvoice_tblquotationline_ibfk_1` FOREIGN KEY (`quotation_id`) REFERENCES `siminvoice_tblquotation` (`quotation_id`);
