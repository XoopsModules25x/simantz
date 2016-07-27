-- phpMyAdmin SQL Dump
-- version 2.11.3deb1ubuntu1.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 17, 2008 at 04:31 PM
-- Server version: 5.0.51
-- PHP Version: 5.2.4-2ubuntu5.4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `simsalon`
--

-- --------------------------------------------------------

--
-- Table structure for table `simit_avatar`
--

CREATE TABLE IF NOT EXISTS `simit_avatar` (
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
-- Dumping data for table `simit_avatar`
--


-- --------------------------------------------------------

--
-- Table structure for table `simit_avatar_user_link`
--

CREATE TABLE IF NOT EXISTS `simit_avatar_user_link` (
  `avatar_id` mediumint(8) unsigned NOT NULL default '0',
  `user_id` mediumint(8) unsigned NOT NULL default '0',
  KEY `avatar_user_id` (`avatar_id`,`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `simit_avatar_user_link`
--


-- --------------------------------------------------------

--
-- Table structure for table `simit_banner`
--

CREATE TABLE IF NOT EXISTS `simit_banner` (
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
-- Dumping data for table `simit_banner`
--

INSERT INTO `simit_banner` (`bid`, `cid`, `imptotal`, `impmade`, `clicks`, `imageurl`, `clickurl`, `date`, `htmlbanner`, `htmlcode`) VALUES
(1, 1, 0, 30409, 0, 'http://localhost/simtrain/images/banners/xoops_banner.gif', 'http://www.xoops.org/', 1008813250, 0, ''),
(2, 1, 0, 30476, 0, 'http://localhost/simtrain/images/banners/xoops_banner_2.gif', 'http://www.xoops.org/', 1008813250, 0, ''),
(3, 1, 0, 30765, 0, 'http://localhost/simtrain/images/banners/banner.swf', 'http://www.xoops.org/', 1008813250, 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `simit_bannerclient`
--

CREATE TABLE IF NOT EXISTS `simit_bannerclient` (
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
-- Dumping data for table `simit_bannerclient`
--

INSERT INTO `simit_bannerclient` (`cid`, `name`, `contact`, `email`, `login`, `passwd`, `extrainfo`) VALUES
(1, 'XOOPS', 'XOOPS Dev Team', 'webmaster@xoops.org', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `simit_bannerfinish`
--

CREATE TABLE IF NOT EXISTS `simit_bannerfinish` (
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
-- Dumping data for table `simit_bannerfinish`
--


-- --------------------------------------------------------

--
-- Table structure for table `simit_block_module_link`
--

CREATE TABLE IF NOT EXISTS `simit_block_module_link` (
  `block_id` mediumint(8) unsigned NOT NULL default '0',
  `module_id` smallint(5) NOT NULL default '0',
  KEY `module_id` (`module_id`),
  KEY `block_id` (`block_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `simit_block_module_link`
--

INSERT INTO `simit_block_module_link` (`block_id`, `module_id`) VALUES
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
-- Table structure for table `simit_config`
--

CREATE TABLE IF NOT EXISTS `simit_config` (
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
-- Dumping data for table `simit_config`
--

INSERT INTO `simit_config` (`conf_id`, `conf_modid`, `conf_catid`, `conf_name`, `conf_title`, `conf_value`, `conf_desc`, `conf_formtype`, `conf_valuetype`, `conf_order`) VALUES
(1, 0, 1, 'sitename', '_MD_AM_SITENAME', 'SimSalon Management System', '_MD_AM_SITENAMEDSC', 'textbox', 'text', 0),
(2, 0, 1, 'slogan', '_MD_AM_SLOGAN', 'Simplified, Burdenless.', '_MD_AM_SLOGANDSC', 'textbox', 'text', 2),
(3, 0, 1, 'language', '_MD_AM_LANGUAGE', 'english', '_MD_AM_LANGUAGEDSC', 'language', 'other', 4),
(4, 0, 1, 'startpage', '_MD_AM_STARTPAGE', 'salon', '_MD_AM_STARTPAGEDSC', 'startpage', 'other', 6),
(5, 0, 1, 'server_TZ', '_MD_AM_SERVERTZ', '5', '_MD_AM_SERVERTZDSC', 'timezone', 'float', 8),
(6, 0, 1, 'default_TZ', '_MD_AM_DEFAULTTZ', '5', '_MD_AM_DEFAULTTZDSC', 'timezone', 'float', 10),
(7, 0, 1, 'theme_set', '_MD_AM_DTHEME', 'default', '_MD_AM_DTHEMEDSC', 'theme', 'other', 12),
(8, 0, 1, 'anonymous', '_MD_AM_ANONNAME', 'Anonymous', '_MD_AM_ANONNAMEDSC', 'textbox', 'text', 15),
(9, 0, 1, 'gzip_compression', '_MD_AM_USEGZIP', '0', '_MD_AM_USEGZIPDSC', 'yesno', 'int', 16),
(10, 0, 1, 'usercookie', '_MD_AM_USERCOOKIE', 'simit_user', '_MD_AM_USERCOOKIEDSC', 'textbox', 'text', 18),
(11, 0, 1, 'session_expire', '_MD_AM_SESSEXPIRE', '1440', '_MD_AM_SESSEXPIREDSC', 'textbox', 'int', 22),
(12, 0, 1, 'banners', '_MD_AM_BANNERS', '1', '_MD_AM_BANNERSDSC', 'yesno', 'int', 26),
(13, 0, 1, 'debug_mode', '_MD_AM_DEBUGMODE', '0', '_MD_AM_DEBUGMODEDSC', 'select', 'int', 24),
(14, 0, 1, 'my_ip', '_MD_AM_MYIP', '127.0.0.1', '_MD_AM_MYIPDSC', 'textbox', 'text', 29),
(15, 0, 1, 'use_ssl', '_MD_AM_USESSL', '0', '_MD_AM_USESSLDSC', 'yesno', 'int', 30),
(16, 0, 1, 'session_name', '_MD_AM_SESSNAME', 'simit_session', '_MD_AM_SESSNAMEDSC', 'textbox', 'text', 20),
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
(38, 0, 3, 'meta_keywords', '_MD_AM_METAKEY', 'salon', '_MD_AM_METAKEYDSC', 'textarea', 'text', 0),
(39, 0, 3, 'footer', '_MD_AM_FOOTER', 'Developed by Sim IT Sdn. Bhd. Ã‚Â© 2007-2008 <a href="http://www.simit.com.my/" target="_blank">The SIMIT Project</a>', '_MD_AM_FOOTERDSC', 'textarea', 'text', 20),
(40, 0, 4, 'censor_enable', '_MD_AM_DOCENSOR', '0', '_MD_AM_DOCENSORDSC', 'yesno', 'int', 0),
(41, 0, 4, 'censor_words', '_MD_AM_CENSORWRD', 'a:2:{i:0;s:4:"fuck";i:1;s:4:"shit";}', '_MD_AM_CENSORWRDDSC', 'textarea', 'array', 1),
(42, 0, 4, 'censor_replace', '_MD_AM_CENSORRPLC', '#OOPS#', '_MD_AM_CENSORRPLCDSC', 'textbox', 'text', 2),
(43, 0, 3, 'meta_robots', '_MD_AM_METAROBOTS', 'index,follow', '_MD_AM_METAROBOTSDSC', 'select', 'text', 2),
(44, 0, 5, 'enable_search', '_MD_AM_DOSEARCH', '1', '_MD_AM_DOSEARCHDSC', 'yesno', 'int', 0),
(45, 0, 5, 'keyword_min', '_MD_AM_MINSEARCH', '5', '_MD_AM_MINSEARCHDSC', 'textbox', 'int', 1),
(46, 0, 2, 'avatar_minposts', '_MD_AM_AVATARMP', '0', '_MD_AM_AVATARMPDSC', 'textbox', 'int', 15),
(47, 0, 1, 'enable_badips', '_MD_AM_DOBADIPS', '0', '_MD_AM_DOBADIPSDSC', 'yesno', 'int', 40),
(48, 0, 3, 'meta_rating', '_MD_AM_METARATING', 'general', '_MD_AM_METARATINGDSC', 'select', 'text', 4),
(49, 0, 3, 'meta_author', '_MD_AM_METAAUTHOR', 'SIMIT', '_MD_AM_METAAUTHORDSC', 'textbox', 'text', 6),
(50, 0, 3, 'meta_copyright', '_MD_AM_METACOPYR', 'Copyright Ã‚Â© 2008', '_MD_AM_METACOPYRDSC', 'textbox', 'text', 8),
(51, 0, 3, 'meta_description', '_MD_AM_METADESC', 'SimSalon is a content management system which enable users manage their salon data via internet to link up each branches and access anytime and anywhere.', '_MD_AM_METADESCDSC', 'textarea', 'text', 1),
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
(62, 0, 1, 'module_cache', '_MD_AM_MODCACHE', 'a:1:{i:6;s:1:"0";}', '_MD_AM_MODCACHEDSC', 'module_cache', 'array', 50),
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
-- Table structure for table `simit_configcategory`
--

CREATE TABLE IF NOT EXISTS `simit_configcategory` (
  `confcat_id` smallint(5) unsigned NOT NULL auto_increment,
  `confcat_name` varchar(255) NOT NULL default '',
  `confcat_order` smallint(5) unsigned NOT NULL default '0',
  PRIMARY KEY  (`confcat_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `simit_configcategory`
--

INSERT INTO `simit_configcategory` (`confcat_id`, `confcat_name`, `confcat_order`) VALUES
(1, '_MD_AM_GENERAL', 0),
(2, '_MD_AM_USERSETTINGS', 0),
(3, '_MD_AM_METAFOOTER', 0),
(4, '_MD_AM_CENSOR', 0),
(5, '_MD_AM_SEARCH', 0),
(6, '_MD_AM_MAILER', 0),
(7, '_MD_AM_AUTHENTICATION', 0);

-- --------------------------------------------------------

--
-- Table structure for table `simit_configoption`
--

CREATE TABLE IF NOT EXISTS `simit_configoption` (
  `confop_id` mediumint(8) unsigned NOT NULL auto_increment,
  `confop_name` varchar(255) NOT NULL default '',
  `confop_value` varchar(255) NOT NULL default '',
  `conf_id` smallint(5) unsigned NOT NULL default '0',
  PRIMARY KEY  (`confop_id`),
  KEY `conf_id` (`conf_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=31 ;

--
-- Dumping data for table `simit_configoption`
--

INSERT INTO `simit_configoption` (`confop_id`, `confop_name`, `confop_value`, `conf_id`) VALUES
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
-- Table structure for table `simit_edito`
--

CREATE TABLE IF NOT EXISTS `simit_edito` (
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
-- Dumping data for table `simit_edito`
--


-- --------------------------------------------------------

--
-- Table structure for table `simit_groups`
--

CREATE TABLE IF NOT EXISTS `simit_groups` (
  `groupid` smallint(5) unsigned NOT NULL auto_increment,
  `name` varchar(50) NOT NULL default '',
  `description` text NOT NULL,
  `group_type` varchar(10) NOT NULL default '',
  PRIMARY KEY  (`groupid`),
  KEY `group_type` (`group_type`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `simit_groups`
--

INSERT INTO `simit_groups` (`groupid`, `name`, `description`, `group_type`) VALUES
(1, 'Webmasters', 'Webmasters of this site', 'Admin'),
(2, 'Registered Users', 'Registered Users Group', 'User'),
(3, 'Anonymous Users', 'Anonymous Users Group', 'Anonymous'),
(4, 'user', 'user', '');

-- --------------------------------------------------------

--
-- Table structure for table `simit_groups_users_link`
--

CREATE TABLE IF NOT EXISTS `simit_groups_users_link` (
  `linkid` mediumint(8) unsigned NOT NULL auto_increment,
  `groupid` smallint(5) unsigned NOT NULL default '0',
  `uid` mediumint(8) unsigned NOT NULL default '0',
  PRIMARY KEY  (`linkid`),
  KEY `groupid_uid` (`groupid`,`uid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=161 ;

--
-- Dumping data for table `simit_groups_users_link`
--

INSERT INTO `simit_groups_users_link` (`linkid`, `groupid`, `uid`) VALUES
(159, 1, 1),
(155, 1, 3),
(157, 1, 4),
(160, 2, 1),
(148, 2, 2),
(156, 2, 3),
(158, 2, 4),
(149, 4, 2);

-- --------------------------------------------------------

--
-- Table structure for table `simit_group_permission`
--

CREATE TABLE IF NOT EXISTS `simit_group_permission` (
  `gperm_id` int(10) unsigned NOT NULL auto_increment,
  `gperm_groupid` smallint(5) unsigned NOT NULL default '0',
  `gperm_itemid` mediumint(8) unsigned NOT NULL default '0',
  `gperm_modid` mediumint(5) unsigned NOT NULL default '0',
  `gperm_name` varchar(50) NOT NULL default '',
  PRIMARY KEY  (`gperm_id`),
  KEY `groupid` (`gperm_groupid`),
  KEY `itemid` (`gperm_itemid`),
  KEY `gperm_modid` (`gperm_modid`,`gperm_name`(10))
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=222 ;

--
-- Dumping data for table `simit_group_permission`
--

INSERT INTO `simit_group_permission` (`gperm_id`, `gperm_groupid`, `gperm_itemid`, `gperm_modid`, `gperm_name`) VALUES
(87, 1, 6, 1, 'block_read'),
(86, 1, 5, 1, 'block_read'),
(85, 1, 4, 1, 'block_read'),
(84, 1, 3, 1, 'block_read'),
(83, 1, 2, 1, 'block_read'),
(82, 1, 1, 1, 'block_read'),
(81, 1, 1, 1, 'module_read'),
(79, 1, 1, 1, 'module_admin'),
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
(211, 3, 1, 1, 'block_read'),
(139, 2, 12, 1, 'block_read'),
(210, 3, 5, 1, 'block_read'),
(69, 1, 1, 1, 'system_admin'),
(138, 2, 11, 1, 'block_read'),
(209, 3, 12, 1, 'block_read'),
(137, 2, 10, 1, 'block_read'),
(208, 3, 11, 1, 'block_read'),
(68, 1, 7, 1, 'system_admin'),
(136, 2, 9, 1, 'block_read'),
(207, 3, 10, 1, 'block_read'),
(135, 2, 8, 1, 'block_read'),
(206, 3, 9, 1, 'block_read'),
(67, 1, 14, 1, 'system_admin'),
(134, 2, 7, 1, 'block_read'),
(205, 3, 8, 1, 'block_read'),
(133, 2, 6, 1, 'block_read'),
(204, 3, 7, 1, 'block_read'),
(66, 1, 5, 1, 'system_admin'),
(132, 2, 4, 1, 'block_read'),
(203, 3, 6, 1, 'block_read'),
(131, 2, 3, 1, 'block_read'),
(202, 3, 4, 1, 'block_read'),
(65, 1, 13, 1, 'system_admin'),
(130, 2, 2, 1, 'block_read'),
(201, 3, 3, 1, 'block_read'),
(64, 1, 10, 1, 'system_admin'),
(129, 2, 1, 1, 'module_read'),
(200, 3, 2, 1, 'block_read'),
(88, 1, 7, 1, 'block_read'),
(89, 1, 8, 1, 'block_read'),
(90, 1, 9, 1, 'block_read'),
(91, 1, 10, 1, 'block_read'),
(92, 1, 11, 1, 'block_read'),
(93, 1, 12, 1, 'block_read'),
(197, 2, 6, 1, 'module_read'),
(196, 1, 6, 1, 'module_read'),
(195, 1, 6, 1, 'module_admin'),
(199, 3, 1, 1, 'module_read'),
(221, 4, 1, 1, 'block_read'),
(220, 4, 5, 1, 'block_read'),
(219, 4, 2, 1, 'block_read'),
(218, 4, 1, 1, 'module_read'),
(217, 4, 6, 1, 'module_read');

-- --------------------------------------------------------

--
-- Table structure for table `simit_image`
--

CREATE TABLE IF NOT EXISTS `simit_image` (
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
-- Dumping data for table `simit_image`
--


-- --------------------------------------------------------

--
-- Table structure for table `simit_imagebody`
--

CREATE TABLE IF NOT EXISTS `simit_imagebody` (
  `image_id` mediumint(8) unsigned NOT NULL default '0',
  `image_body` mediumblob,
  KEY `image_id` (`image_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `simit_imagebody`
--


-- --------------------------------------------------------

--
-- Table structure for table `simit_imagecategory`
--

CREATE TABLE IF NOT EXISTS `simit_imagecategory` (
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
-- Dumping data for table `simit_imagecategory`
--


-- --------------------------------------------------------

--
-- Table structure for table `simit_imgset`
--

CREATE TABLE IF NOT EXISTS `simit_imgset` (
  `imgset_id` smallint(5) unsigned NOT NULL auto_increment,
  `imgset_name` varchar(50) NOT NULL default '',
  `imgset_refid` mediumint(8) unsigned NOT NULL default '0',
  PRIMARY KEY  (`imgset_id`),
  KEY `imgset_refid` (`imgset_refid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `simit_imgset`
--

INSERT INTO `simit_imgset` (`imgset_id`, `imgset_name`, `imgset_refid`) VALUES
(1, 'default', 0);

-- --------------------------------------------------------

--
-- Table structure for table `simit_imgsetimg`
--

CREATE TABLE IF NOT EXISTS `simit_imgsetimg` (
  `imgsetimg_id` mediumint(8) unsigned NOT NULL auto_increment,
  `imgsetimg_file` varchar(50) NOT NULL default '',
  `imgsetimg_body` blob NOT NULL,
  `imgsetimg_imgset` smallint(5) unsigned NOT NULL default '0',
  PRIMARY KEY  (`imgsetimg_id`),
  KEY `imgsetimg_imgset` (`imgsetimg_imgset`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `simit_imgsetimg`
--


-- --------------------------------------------------------

--
-- Table structure for table `simit_imgset_tplset_link`
--

CREATE TABLE IF NOT EXISTS `simit_imgset_tplset_link` (
  `imgset_id` smallint(5) unsigned NOT NULL default '0',
  `tplset_name` varchar(50) NOT NULL default '',
  KEY `tplset_name` (`tplset_name`(10))
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `simit_imgset_tplset_link`
--

INSERT INTO `simit_imgset_tplset_link` (`imgset_id`, `tplset_name`) VALUES
(1, 'default');

-- --------------------------------------------------------

--
-- Table structure for table `simit_modules`
--

CREATE TABLE IF NOT EXISTS `simit_modules` (
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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `simit_modules`
--

INSERT INTO `simit_modules` (`mid`, `name`, `version`, `last_update`, `weight`, `isactive`, `dirname`, `hasmain`, `hasadmin`, `hassearch`, `hasconfig`, `hascomments`, `hasnotification`) VALUES
(1, 'System', 102, 1205985656, 0, 1, 'system', 0, 1, 0, 0, 0, 0),
(6, 'SimSalon Management System', 100, 1219073945, 1, 1, 'salon', 1, 1, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `simit_newblocks`
--

CREATE TABLE IF NOT EXISTS `simit_newblocks` (
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
-- Dumping data for table `simit_newblocks`
--

INSERT INTO `simit_newblocks` (`bid`, `mid`, `func_num`, `options`, `name`, `title`, `content`, `side`, `weight`, `visible`, `block_type`, `c_type`, `isactive`, `dirname`, `func_file`, `show_func`, `edit_func`, `template`, `bcachetime`, `last_modified`) VALUES
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
-- Table structure for table `simit_online`
--

CREATE TABLE IF NOT EXISTS `simit_online` (
  `online_uid` mediumint(8) unsigned NOT NULL default '0',
  `online_uname` varchar(25) NOT NULL default '',
  `online_updated` int(10) unsigned NOT NULL default '0',
  `online_module` smallint(5) unsigned NOT NULL default '0',
  `online_ip` varchar(15) NOT NULL default '',
  KEY `online_module` (`online_module`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `simit_online`
--


-- --------------------------------------------------------

--
-- Table structure for table `simit_priv_msgs`
--

CREATE TABLE IF NOT EXISTS `simit_priv_msgs` (
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
-- Dumping data for table `simit_priv_msgs`
--


-- --------------------------------------------------------

--
-- Table structure for table `simit_ranks`
--

CREATE TABLE IF NOT EXISTS `simit_ranks` (
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
-- Dumping data for table `simit_ranks`
--

INSERT INTO `simit_ranks` (`rank_id`, `rank_title`, `rank_min`, `rank_max`, `rank_special`, `rank_image`) VALUES
(1, 'Just popping in', 0, 20, 0, 'rank3e632f95e81ca.gif'),
(2, 'Not too shy to talk', 21, 40, 0, 'rank3dbf8e94a6f72.gif'),
(3, 'Quite a regular', 41, 70, 0, 'rank3dbf8e9e7d88d.gif'),
(4, 'Just can''t stay away', 71, 150, 0, 'rank3dbf8ea81e642.gif'),
(5, 'Home away from home', 151, 10000, 0, 'rank3dbf8eb1a72e7.gif'),
(6, 'Moderator', 0, 0, 1, 'rank3dbf8edf15093.gif'),
(7, 'Webmaster', 0, 0, 1, 'rank3dbf8ee8681cd.gif');

-- --------------------------------------------------------

--
-- Table structure for table `simit_session`
--

CREATE TABLE IF NOT EXISTS `simit_session` (
  `sess_id` varchar(32) NOT NULL default '',
  `sess_updated` int(10) unsigned NOT NULL default '0',
  `sess_ip` varchar(15) NOT NULL default '',
  `sess_data` text NOT NULL,
  PRIMARY KEY  (`sess_id`),
  KEY `updated` (`sess_updated`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `simit_session`
--

INSERT INTO `simit_session` (`sess_id`, `sess_updated`, `sess_ip`, `sess_data`) VALUES
('cc29ca607b507add82ce5f7dd57341f0', 1229395506, '127.0.0.1', ''),
('72c56722dc41e26234feda229687a540', 1229417361, '192.168.0.1', 'xoopsUserId|s:1:"1";xoopsUserGroups|a:2:{i:0;s:1:"1";i:1;s:1:"2";}xoopsUserTheme|s:7:"default";CREATE_VEN_SESSION|a:4:{i:0;a:2:{s:2:"id";s:32:"f75fdccbfd255b2936a8585751a2dfd2";s:6:"expire";i:1229478230;}i:1;a:2:{s:2:"id";s:32:"85351e16ae537ab0ae82cc892afc167f";s:6:"expire";i:1229478235;}i:2;a:2:{s:2:"id";s:32:"0a6495aeaa9f1dc72e96e02ae94e63f6";s:6:"expire";i:1229481845;}i:3;a:2:{s:2:"id";s:32:"09599bc346ed1b204b9eabf318ad4a7a";s:6:"expire";i:1229503752;}}CREATE_EMP_SESSION|a:6:{i:0;a:2:{s:2:"id";s:32:"9c8fab83d620fdbab313a7bb7a68b877";s:6:"expire";i:1229480387;}i:1;a:2:{s:2:"id";s:32:"523d23108e8c07146b7e859ba12b7623";s:6:"expire";i:1229480390;}i:2;a:2:{s:2:"id";s:32:"a4fca43cbc14d0c16124c810fb79f143";s:6:"expire";i:1229489811;}i:3;a:2:{s:2:"id";s:32:"dbef31947412153e5050ecaaa8f0c774";s:6:"expire";i:1229490328;}i:4;a:2:{s:2:"id";s:32:"8518a50fdfff481c321b43b352f17d8a";s:6:"expire";i:1229490331;}i:5;a:2:{s:2:"id";s:32:"9f975d2c28b63ccdef0f648065dfa81b";s:6:"expire";i:1229495815;}}CREATE_EXP_SESSION|a:56:{i:0;a:2:{s:2:"id";s:32:"3f472bd7a9956016cc0992aecd1616bb";s:6:"expire";i:1229480750;}i:1;a:2:{s:2:"id";s:32:"078e44ba7b7ca092870ad11b35f9316c";s:6:"expire";i:1229480893;}i:2;a:2:{s:2:"id";s:32:"62d0b930617bddc220f1a189a200b9e1";s:6:"expire";i:1229480903;}i:3;a:2:{s:2:"id";s:32:"e1e564057f233d72b19d17f32beb94a8";s:6:"expire";i:1229480919;}i:4;a:2:{s:2:"id";s:32:"5132893dedbb376d6477bdd12be4588d";s:6:"expire";i:1229480938;}i:5;a:2:{s:2:"id";s:32:"f9256ffaec5ee65a95bc979310618997";s:6:"expire";i:1229481229;}i:6;a:2:{s:2:"id";s:32:"8233d942f1850316b6d29a230300e254";s:6:"expire";i:1229481238;}i:7;a:2:{s:2:"id";s:32:"3ceea7a7b16972c99df373f868227354";s:6:"expire";i:1229481249;}i:8;a:2:{s:2:"id";s:32:"15b56278adc3bca5a2ef9173e86a7b4d";s:6:"expire";i:1229481304;}i:9;a:2:{s:2:"id";s:32:"cf4b910a837b8fc2442297cd04a73b97";s:6:"expire";i:1229481312;}i:10;a:2:{s:2:"id";s:32:"ced9bfd6b683c1920b45ec5be3ba2603";s:6:"expire";i:1229481316;}i:11;a:2:{s:2:"id";s:32:"76213802b369d5617b98a9c1ae12afcb";s:6:"expire";i:1229481333;}i:12;a:2:{s:2:"id";s:32:"19357be3b6b60660e649a96bd568952c";s:6:"expire";i:1229481339;}i:13;a:2:{s:2:"id";s:32:"61d7367d65b886c89af1e8ac343cabe0";s:6:"expire";i:1229481550;}i:14;a:2:{s:2:"id";s:32:"f75f6bbe159b60f8e60f6f17f8eb2eeb";s:6:"expire";i:1229481555;}i:15;a:2:{s:2:"id";s:32:"1911803ea5656227f790c192f68de461";s:6:"expire";i:1229481559;}i:16;a:2:{s:2:"id";s:32:"264374f67c203ce2ce3eefae15b2495f";s:6:"expire";i:1229481592;}i:17;a:2:{s:2:"id";s:32:"1e88c1609183a494700d32b0ec2a10e5";s:6:"expire";i:1229481594;}i:18;a:2:{s:2:"id";s:32:"3ca437fa26afd30c6451bd3277c8f604";s:6:"expire";i:1229481598;}i:19;a:2:{s:2:"id";s:32:"e05632af5117d175759cbdaac96a572e";s:6:"expire";i:1229481603;}i:20;a:2:{s:2:"id";s:32:"b26a547d049bc1022a909f7bb8ce15cb";s:6:"expire";i:1229481649;}i:21;a:2:{s:2:"id";s:32:"ee9480b339f6b3daabd714e8ed4b8002";s:6:"expire";i:1229481698;}i:22;a:2:{s:2:"id";s:32:"9e862905f885a778a4cb4129d61c1e9b";s:6:"expire";i:1229481705;}i:23;a:2:{s:2:"id";s:32:"3e478aaf66413ee03f2b7034bec3ba05";s:6:"expire";i:1229481715;}i:24;a:2:{s:2:"id";s:32:"e9385a618c2732396141d4434917be15";s:6:"expire";i:1229481724;}i:25;a:2:{s:2:"id";s:32:"0d97fb3fef202f4a52b5b11fbf915705";s:6:"expire";i:1229481910;}i:26;a:2:{s:2:"id";s:32:"922e64d1264f47070b7b96e054dc8467";s:6:"expire";i:1229481926;}i:27;a:2:{s:2:"id";s:32:"7f666fbb13787dadc150102ac6f5392f";s:6:"expire";i:1229481935;}i:28;a:2:{s:2:"id";s:32:"0c84bc8fde1dcc157f2d9f6fc5bc2bb8";s:6:"expire";i:1229481965;}i:29;a:2:{s:2:"id";s:32:"888ce036140402b32e788378d624198d";s:6:"expire";i:1229481978;}i:30;a:2:{s:2:"id";s:32:"2f6e02e172465d5b415b62cb4152861b";s:6:"expire";i:1229482001;}i:31;a:2:{s:2:"id";s:32:"4a05cbce39574b157aaa4747b2cc5200";s:6:"expire";i:1229482162;}i:32;a:2:{s:2:"id";s:32:"68920cd3e09a606a5340c1e075bbb831";s:6:"expire";i:1229482915;}i:33;a:2:{s:2:"id";s:32:"88006e76c5cf6556d6801c1b2ef4327c";s:6:"expire";i:1229490511;}i:34;a:2:{s:2:"id";s:32:"4f93c335d5cebcc37ede696a9eb9aede";s:6:"expire";i:1229490514;}i:35;a:2:{s:2:"id";s:32:"5ec0d11e614cb4abc9639070049bed62";s:6:"expire";i:1229491245;}i:36;a:2:{s:2:"id";s:32:"7474ac6ff6471394471c8401995d5e1d";s:6:"expire";i:1229491258;}i:37;a:2:{s:2:"id";s:32:"6d1d3049acb3b9cc9b6e5e204d94e0c4";s:6:"expire";i:1229491431;}i:38;a:2:{s:2:"id";s:32:"ecc9dfbff14de396fcb1af97279e35d5";s:6:"expire";i:1229492808;}i:39;a:2:{s:2:"id";s:32:"308c685ad3124bd240defaaf851e2b17";s:6:"expire";i:1229492855;}i:40;a:2:{s:2:"id";s:32:"b9ac81f14a14227878939bf4268cbfc2";s:6:"expire";i:1229493343;}i:41;a:2:{s:2:"id";s:32:"41019eb8066a10c2ea5249f9e677cea6";s:6:"expire";i:1229493704;}i:42;a:2:{s:2:"id";s:32:"d9d6969f7e6dd88c2650fc395997b2f8";s:6:"expire";i:1229494714;}i:43;a:2:{s:2:"id";s:32:"75475fefcfb535bf40e0ac62d32a4662";s:6:"expire";i:1229494779;}i:44;a:2:{s:2:"id";s:32:"753d851cb570987c1f920b641a61d846";s:6:"expire";i:1229494968;}i:45;a:2:{s:2:"id";s:32:"ae9d27bba030dd15857d90ed44043be9";s:6:"expire";i:1229494973;}i:46;a:2:{s:2:"id";s:32:"6f44f5ef393ed14baed37bc36b79fbeb";s:6:"expire";i:1229494986;}i:47;a:2:{s:2:"id";s:32:"e279680aed90ce62a9e40d36b36202bd";s:6:"expire";i:1229495422;}i:48;a:2:{s:2:"id";s:32:"6cb1092a3d34317605b515496c920d32";s:6:"expire";i:1229495434;}i:49;a:2:{s:2:"id";s:32:"42102d2e099c62f95220ae014bace390";s:6:"expire";i:1229495448;}i:50;a:2:{s:2:"id";s:32:"6db853f236418e190a673f3ed793ca42";s:6:"expire";i:1229495453;}i:51;a:2:{s:2:"id";s:32:"e20c105afc17cb27c3dc8fa5bcdd2410";s:6:"expire";i:1229495466;}i:52;a:2:{s:2:"id";s:32:"6a04edac4f00f3c4d45047edc658ca13";s:6:"expire";i:1229495649;}i:53;a:2:{s:2:"id";s:32:"b88ad8d5d0454542d07431a00c14671c";s:6:"expire";i:1229495694;}i:54;a:2:{s:2:"id";s:32:"c44b16258b8df61368bac92a2452a4ee";s:6:"expire";i:1229495765;}i:55;a:2:{s:2:"id";s:32:"a79c55075358111663dfac74eb9ab34b";s:6:"expire";i:1229495900;}}');

-- --------------------------------------------------------

--
-- Table structure for table `simit_simsalon_address`
--

CREATE TABLE IF NOT EXISTS `simit_simsalon_address` (
  `address_id` int(11) NOT NULL auto_increment,
  `address_name` varchar(30) NOT NULL default '',
  `student_id` int(11) default NULL,
  `no` varchar(5) NOT NULL default '',
  `street1` text NOT NULL,
  `area_id` int(11) NOT NULL default '0',
  `postcode` varchar(5) NOT NULL default '',
  `city` varchar(50) NOT NULL default '',
  `state` varchar(50) NOT NULL default '',
  `country` varchar(30) NOT NULL default '',
  `isactive` char(1) NOT NULL default '',
  `organization_id` int(11) NOT NULL default '0',
  `created` datetime NOT NULL default '0000-00-00 00:00:00',
  `createdby` int(11) NOT NULL default '0',
  `updated` datetime NOT NULL default '0000-00-00 00:00:00',
  `updatedby` int(11) NOT NULL default '0',
  `street2` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`address_id`),
  KEY `area_id` (`area_id`),
  KEY `student_id` (`student_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `simit_simsalon_address`
--

INSERT INTO `simit_simsalon_address` (`address_id`, `address_name`, `student_id`, `no`, `street1`, `area_id`, `postcode`, `city`, `state`, `country`, `isactive`, `organization_id`, `created`, `createdby`, `updated`, `updatedby`, `street2`) VALUES
(0, '', 0, '', '', 1, '', '', '', '', 'Y', 0, '2008-08-21 17:02:50', 1, '2008-08-21 17:02:50', 1, ''),
(2, '', 0, '', '', 1, '', '', '', '', 'Y', 0, '2008-08-21 17:04:37', 1, '2008-08-21 17:04:37', 1, ''),
(3, '', 0, '', '', 1, '', '', '', '', 'Y', 0, '2008-08-21 17:09:23', 1, '2008-08-21 17:09:23', 1, ''),
(4, '', 0, '', '', 1, '', '', '', '', 'Y', 0, '2008-08-21 17:10:13', 1, '2008-08-21 17:10:13', 1, ''),
(5, '', 0, '', '', 1, '', '', '', '', 'Y', 0, '2008-08-21 18:37:34', 1, '2008-08-21 18:37:34', 1, ''),
(6, '', 0, '', '', 1, '', '', '', '', 'Y', 0, '2008-08-21 23:13:16', 1, '2008-08-21 23:13:16', 1, ''),
(7, '', 0, '', '', 1, '', '', '', '', 'Y', 0, '2008-08-21 23:36:55', 1, '2008-08-21 23:36:55', 1, ''),
(8, '', 0, '', '', 1, '', '', '', '', 'Y', 0, '2008-08-21 23:37:36', 1, '2008-08-21 23:37:36', 1, ''),
(9, '', 0, '', '', 1, '', '', '', '', 'Y', 0, '2008-08-21 23:40:11', 1, '2008-08-21 23:40:11', 1, ''),
(10, '', 0, '', '', 1, '', '', '', '', 'Y', 0, '2008-08-21 23:41:16', 1, '2008-08-21 23:41:16', 1, ''),
(11, '', 0, '', '', 1, '', '', '', '', 'Y', 0, '2008-08-21 23:42:15', 1, '2008-08-21 23:42:15', 1, '');

-- --------------------------------------------------------

--
-- Table structure for table `simit_simsalon_allowanceline`
--

CREATE TABLE IF NOT EXISTS `simit_simsalon_allowanceline` (
  `allowanceline_id` int(11) NOT NULL auto_increment,
  `allowanceline_no` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL default '0',
  `allowanceline_name` varchar(100) default NULL,
  `allowanceline_amount` decimal(12,2) default '0.00',
  `allowanceline_epf` char(1) default 'N',
  `allowanceline_socso` char(1) default 'N',
  `allowanceline_active` char(1) default 'Y',
  PRIMARY KEY  (`allowanceline_id`),
  KEY `employee_id` (`employee_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `simit_simsalon_allowanceline`
--


-- --------------------------------------------------------

--
-- Table structure for table `simit_simsalon_allowancepayroll`
--

CREATE TABLE IF NOT EXISTS `simit_simsalon_allowancepayroll` (
  `allowancepayroll_id` int(11) NOT NULL auto_increment,
  `allowancepayroll_name` varchar(100) default NULL,
  `payroll_id` int(11) NOT NULL default '0',
  `allowancepayroll_amount` decimal(12,2) default '0.00',
  `allowancepayroll_epf` char(1) default 'N',
  `allowancepayroll_socso` char(1) default 'N',
  PRIMARY KEY  (`allowancepayroll_id`),
  KEY `payroll_id` (`payroll_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `simit_simsalon_allowancepayroll`
--


-- --------------------------------------------------------

--
-- Table structure for table `simit_simsalon_area`
--

CREATE TABLE IF NOT EXISTS `simit_simsalon_area` (
  `area_id` int(11) NOT NULL auto_increment,
  `area_name` varchar(50) NOT NULL,
  PRIMARY KEY  (`area_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `simit_simsalon_area`
--

INSERT INTO `simit_simsalon_area` (`area_id`, `area_name`) VALUES
(1, 'Johor'),
(2, 'Melaka'),
(3, 'Pahang'),
(4, 'Selangor'),
(5, 'Negeri Sembilan'),
(6, 'Perak'),
(7, 'Kedah'),
(8, 'Perlis'),
(9, 'Pulau Penang'),
(10, 'Terengganu'),
(11, 'Kelantan'),
(12, 'Sabah'),
(13, 'Sarawak');

-- --------------------------------------------------------

--
-- Table structure for table `simit_simsalon_commission`
--

CREATE TABLE IF NOT EXISTS `simit_simsalon_commission` (
  `commission_id` int(11) NOT NULL auto_increment,
  `commission_no` varchar(20) NOT NULL default '',
  `commission_name` varchar(50) NOT NULL default '',
  `commission_type` char(1) NOT NULL default '',
  `commission_amount` decimal(12,2) default '0.00',
  `commission_amountmax` decimal(12,2) NOT NULL default '0.00',
  `organization_id` int(1) NOT NULL,
  `commission_remarks` text,
  `created` datetime NOT NULL default '0000-00-00 00:00:00',
  `createdby` int(11) NOT NULL default '0',
  `updated` datetime NOT NULL default '0000-00-00 00:00:00',
  `updatedby` int(11) NOT NULL default '0',
  `isactive` char(1) NOT NULL default '',
  `commission_percent` decimal(12,2) NOT NULL default '0.00',
  PRIMARY KEY  (`commission_id`),
  UNIQUE KEY `commission_no` (`commission_no`),
  KEY `organization_id` (`organization_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `simit_simsalon_commission`
--

INSERT INTO `simit_simsalon_commission` (`commission_id`, `commission_no`, `commission_name`, `commission_type`, `commission_amount`, `commission_amountmax`, `organization_id`, `commission_remarks`, `created`, `createdby`, `updated`, `updatedby`, `isactive`, `commission_percent`) VALUES
(2, '0001', '5% Product', 'P', 0.00, 349.00, 0, '', '2008-09-09 17:01:58', 1, '2008-11-12 15:04:00', 1, 'Y', 5.00),
(3, '0002', '10% Product', 'P', 349.01, 500.00, 0, '', '2008-09-24 14:08:59', 1, '2008-10-20 16:51:39', 1, 'Y', 10.00),
(4, '0003', '15% Product', 'P', 500.01, 1000.00, 0, '', '2008-10-09 15:38:18', 1, '2008-10-20 16:51:31', 1, 'Y', 15.00),
(5, '0004', '20% Product', 'P', 1000.01, 99999999.00, 0, '', '2008-10-20 16:51:16', 1, '2008-10-20 16:51:16', 1, 'Y', 20.00),
(6, '0005', '8% Service', 'S', 1000.00, 3000.00, 0, '', '2008-10-20 16:53:09', 1, '2008-10-20 16:53:42', 1, 'Y', 8.00),
(7, '0006', '10% Service', 'S', 3000.01, 6000.00, 0, '', '2008-10-20 16:54:10', 1, '2008-10-20 16:54:10', 1, 'Y', 10.00),
(8, '0007', '12% Service', 'S', 6000.01, 9000.00, 0, '', '2008-10-20 16:54:36', 1, '2008-10-20 16:54:36', 1, 'Y', 12.00),
(9, '0008', '15% Service', 'S', 9000.01, 12000.00, 0, '', '2008-10-20 16:55:11', 1, '2008-10-20 16:55:11', 1, 'Y', 15.00),
(10, '0009', '18% Service', 'S', 12000.01, 99999999.00, 0, '', '2008-10-20 16:55:52', 1, '2008-10-20 16:55:52', 1, 'Y', 18.00);

-- --------------------------------------------------------

--
-- Table structure for table `simit_simsalon_customer`
--

CREATE TABLE IF NOT EXISTS `simit_simsalon_customer` (
  `customer_id` int(11) NOT NULL auto_increment,
  `customer_no` varchar(8) NOT NULL,
  `customer_name` varchar(50) NOT NULL,
  `ic_no` varchar(20) NOT NULL default '',
  `gender` char(1) NOT NULL default 'M',
  `dateofbirth` date NOT NULL default '0000-00-00',
  `hp_no` varchar(16) NOT NULL default '',
  `tel_1` varchar(16) NOT NULL default '',
  `isactive` char(1) NOT NULL default '',
  `address_id` int(11) NOT NULL default '0',
  `street_1` varchar(100) default NULL,
  `street_2` varchar(100) default NULL,
  `customertype` int(11) NOT NULL,
  `organization_id` int(11) NOT NULL default '0',
  `created` datetime NOT NULL default '0000-00-00 00:00:00',
  `createdby` int(11) NOT NULL default '0',
  `updated` datetime NOT NULL default '0000-00-00 00:00:00',
  `updatedby` int(11) NOT NULL default '0',
  `uid` int(11) NOT NULL default '0',
  `races_id` int(1) NOT NULL default '0',
  `remarks` text,
  `country` varchar(20) default NULL,
  `state` varchar(30) default NULL,
  `postcode` varchar(10) default NULL,
  `isdefault` char(1) default NULL,
  `joindate` date default '0000-00-00',
  `city` varchar(30) default NULL,
  PRIMARY KEY  (`customer_id`),
  UNIQUE KEY `employee_no` (`customer_no`),
  UNIQUE KEY `ic_no` (`ic_no`),
  KEY `races_id` (`races_id`),
  KEY `organization_id` (`organization_id`),
  KEY `customertype` (`customertype`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=124 ;

--
-- Dumping data for table `simit_simsalon_customer`
--

INSERT INTO `simit_simsalon_customer` (`customer_id`, `customer_no`, `customer_name`, `ic_no`, `gender`, `dateofbirth`, `hp_no`, `tel_1`, `isactive`, `address_id`, `street_1`, `street_2`, `customertype`, `organization_id`, `created`, `createdby`, `updated`, `updatedby`, `uid`, `races_id`, `remarks`, `country`, `state`, `postcode`, `isdefault`, `joindate`, `city`) VALUES
(0, '0', '', '', 'F', '0000-00-00', '', '', 'Y', 0, '', '', 0, 0, '2008-09-02 14:14:17', 1, '2008-09-10 12:44:20', 1, 0, 2, '', 'asd', 'as', '845', 'Y', '0000-00-00', NULL),
(1, '1', 'Walk in 1-12', 'Walk in 1-12', 'F', '0000-00-00', '', '', 'Y', 0, '', '', 1, 0, '2008-10-23 18:30:03', 3, '2008-10-23 18:49:26', 3, 0, 2, '', '', '', '', 'Y', '2008-10-23', NULL),
(2, '2', 'Walk in 13-21', 'Walk in 13-21', 'F', '0000-00-00', '', '', 'Y', 0, '', '', 2, 0, '2008-10-23 18:31:01', 3, '2008-10-23 18:49:49', 3, 0, 2, '', '', '', '', 'Y', '2008-10-23', NULL),
(3, '3', 'Walk in 22-35', 'Walk in 22-35', 'F', '0000-00-00', '', '', 'Y', 0, '', '', 3, 0, '2008-10-23 18:31:42', 3, '2008-10-23 18:50:02', 3, 0, 2, '', '', '', '', 'Y', '2008-10-23', NULL),
(4, '4', 'Walk in 36-100', 'Walk in 36-100', 'F', '0000-00-00', '', '', 'Y', 0, '', '', 4, 0, '2008-10-23 18:32:14', 3, '2008-10-23 18:50:19', 3, 0, 2, '', '', '', '', 'Y', '2008-10-23', NULL),
(5, '5', 'Janet Own', '710723015000', 'F', '1971-07-23', '0292477259', '', 'Y', 0, '60,Jln Bakawali 24,', 'Tmn Johor Jaya', 4, 0, '2008-10-23 18:38:37', 3, '2008-10-23 18:38:37', 3, 0, 2, '', '', 'Johor', '81100', 'N', '2008-10-23', NULL),
(7, '7', 'Cyndi', '841223015004', 'F', '2008-12-23', '0127599888', '', 'Y', 0, '', '', 3, 0, '2008-10-25 18:49:46', 3, '2008-10-25 18:50:23', 3, 0, 2, '', '', '', '', 'N', '2008-10-25', NULL),
(8, '8', 'Siti Norasimah Bt Md Zan', '851126235004', 'F', '2008-11-26', '0177440339', '', 'Y', 0, '', '', 3, 0, '2008-10-25 18:52:47', 3, '2008-10-25 18:52:47', 3, 0, 3, '', '', '', '', 'N', '2008-10-25', NULL),
(9, '9', 'Tee Bee Lin', '740430015004', 'F', '2008-04-30', '0126032177', '', 'Y', 0, '', '', 4, 0, '2008-10-25 18:54:38', 3, '2008-10-25 18:54:38', 3, 0, 2, '', '', '', '', 'N', '2008-10-25', NULL),
(11, '11', 'Ling Poh Chin', '600405085006', 'F', '2008-04-05', '0137779393', '', 'Y', 0, '', '', 4, 0, '2008-10-25 19:05:01', 3, '2008-10-25 19:05:01', 3, 0, 2, '', '', '', '', 'N', '2008-10-25', NULL),
(13, '13', 'Ng Chew Ling ', '820627015008', 'F', '2008-06-26', '0167353550', '', 'Y', 0, '50,Jln Besar', 'Tmn. Kota Besar', 3, 0, '2008-10-25 19:17:06', 3, '2008-10-25 19:17:06', 3, 0, 2, '', '', 'Johor', '81900', 'N', '2008-10-25', NULL),
(14, '14', 'Perinalenney A/p Sangaran', '810525015008', 'F', '2008-05-25', '0137308826', '072326572', 'Y', 0, '22,Jln Bkt Kempas 1/12', 'Tmn Bukit Kempas', 3, 0, '2008-10-25 19:22:11', 3, '2008-10-25 19:26:26', 3, 0, 4, '', '', 'Johor', '81200', 'N', '2008-10-25', NULL),
(15, '15', 'Haw Lee Siang ', '690502045016', 'F', '2008-05-02', '0197139898', '', 'Y', 0, 'No,8 Jln Bayam 3', 'Tmn. Sri Lalang', 4, 0, '2008-10-25 19:31:18', 3, '2008-10-25 19:31:18', 3, 0, 2, '', '', 'Johor', '81900', 'N', '2008-10-25', NULL),
(16, '16', 'Low Xiao Wei', '860505095018', 'F', '2008-05-05', '0290073763', '', 'Y', 0, '134A,Koon Seng Road', '', 3, 0, '2008-10-25 19:36:33', 3, '2008-10-25 19:36:33', 3, 0, 2, '', 'Singapore', '', '427064', 'N', '2008-10-25', NULL),
(17, '17', 'Wong Yan Ping ', '840125015022', 'F', '2008-01-25', '0197618808', '', 'Y', 0, '68,Jln Durian ', 'Tmn KOta Jaya', 3, 0, '2008-10-25 19:40:08', 3, '2008-10-25 19:40:08', 3, 0, 2, '', '', 'Johor', '81900 ', 'N', '2008-10-25', NULL),
(18, '18', 'Simirahayu Bt Sisis', '880101015024', 'F', '2008-01-01', '0177266745', '', 'Y', 0, '67A,Felda Pasak', '', 2, 0, '2008-10-25 19:43:12', 3, '2008-10-25 19:43:12', 3, 0, 3, '', '', 'Johor ', '81900', 'N', '2008-10-25', NULL),
(20, '20', 'Xu Mei Na', '670218025028', 'F', '2008-02-18', '0197016651', '', 'Y', 0, '', '', 4, 0, '2008-11-04 18:43:18', 3, '2008-11-04 18:43:18', 3, 0, 2, '', '', '', '', 'N', '2008-11-04', ''),
(21, '21', 'Suhana Sulaiman', '851203055032', 'F', '1985-12-03', '0197718583', '', 'Y', 0, '2,Jln Melor 4,', 'Tmn Guru, Kota Kecil', 3, 0, '2008-11-04 18:53:07', 3, '2008-11-04 18:53:07', 3, 0, 3, '', 'Malaysia', 'Johor', '81900', 'N', '2008-11-04', 'Kota Tinggi'),
(22, '22', 'sharon tan', '620811016012', 'F', '1962-08-11', '0127921148', '', 'Y', 0, '19 jalan padang  kota tinggi', '', 0, 0, '2008-11-05 15:09:11', 3, '2008-11-05 15:09:11', 3, 0, 2, '', '', 'johor', '81900', 'N', '2008-11-05', 'JB'),
(23, '23', 'Regina Hoo', '850318045032', 'F', '1985-03-18', '0197399755', '', 'Y', 0, '', '', 3, 0, '2008-11-05 15:55:14', 3, '2008-11-05 15:55:14', 3, 0, 2, '', '', '', '', 'N', '2008-11-05', ''),
(24, '24', 'Evon Chong', '801030085034', 'F', '1980-10-30', '0165460885', '', 'Y', 0, '', '', 3, 0, '2008-11-05 15:58:05', 3, '2008-11-05 16:01:20', 3, 0, 2, '', '', '', '', 'N', '2008-11-05', ''),
(25, '25', 'Ong Yoek Siew', '690122015036', 'F', '1969-01-22', '', '', 'Y', 0, '', '', 4, 0, '2008-11-05 16:00:35', 3, '2008-11-05 16:00:35', 3, 0, 2, '', '', '', '', 'N', '2008-11-05', ''),
(26, '26', 'Siti Susila Bt Makpol', '780305015036', 'F', '1978-03-05', '0137105895', '', 'Y', 0, '93,1B,Jln Sg. Siput', 'Kota Kecil', 3, 0, '2008-11-05 16:48:27', 3, '2008-11-05 16:48:27', 3, 0, 4, '', '', 'Johor', '81900', 'N', '2008-11-05', 'Kota Tinggi'),
(27, '27', 'Chang Lii Siew', '791129085038', 'F', '1979-11-29', '0167322775', '', 'Y', 0, '', '', 3, 0, '2008-11-05 17:59:01', 3, '2008-11-05 17:59:01', 3, 0, 2, '', '', '', '', 'N', '2008-11-05', ''),
(28, '28', 'Roshaliza Roslan', '820130065042', 'F', '1982-01-30', '0127362805', '', 'Y', 0, '', '', 3, 0, '2008-11-05 18:02:27', 3, '2008-11-05 18:02:27', 3, 0, 3, '', '', '', '', 'N', '2008-11-05', ''),
(29, '29', 'Noor Asykeen Bt Suraiman', '850616015042', 'F', '1985-06-16', '0177923589', '', 'Y', 0, 'No 25,SS7/1', 'Tmn. Sri Saujana', 3, 0, '2008-11-05 18:06:16', 3, '2008-11-05 18:06:16', 3, 0, 3, '', '', 'Johor', '81900', 'N', '2008-11-05', 'Kota Tinggi'),
(30, '30', 'Joanne Lew', '790717015046', 'F', '1979-07-17', '0137280488', '', 'Y', 0, '', '', 3, 0, '2008-11-05 18:08:01', 3, '2008-11-05 18:08:01', 3, 0, 2, '', '', '', '', 'N', '2008-11-05', ''),
(31, '31', 'Vanitha Moniandy', '830423015048', 'F', '1983-04-23', '0127387105/01978', '', 'Y', 0, '15,Jln Melati 1', 'Tmn Melati', 3, 0, '2008-11-05 18:13:54', 3, '2008-11-05 18:13:54', 3, 0, 4, '', '', 'Johor', '81900', 'N', '2008-11-05', 'Kota Tinggi'),
(32, '32', 'Jocelyn Low', '610404015048', 'F', '1961-04-04', '0127200000', '', 'Y', 0, '', '', 4, 0, '2008-11-05 18:48:22', 3, '2008-11-05 18:48:22', 3, 0, 2, '', '', '', '', 'N', '2008-11-05', ''),
(33, '33', 'Wong See Wan', '820716015050', 'F', '1982-07-16', '0127368697', '', 'Y', 0, '', '', 3, 0, '2008-11-05 18:50:31', 3, '2008-11-05 18:50:31', 3, 0, 2, '', '', '', '', 'N', '2008-11-05', ''),
(34, '34', 'Maria Tahir', '790910015056', 'F', '1979-09-10', '', '', 'Y', 0, '', '', 3, 0, '2008-11-05 18:52:53', 3, '2008-11-05 18:52:53', 3, 0, 3, '', '', '', '', 'N', '2008-11-05', ''),
(35, '35', 'Irene Low', '760508095058', 'F', '1976-05-08', '0124161421', '', 'Y', 0, '', '', 3, 0, '2008-11-05 18:55:13', 3, '2008-11-05 18:55:13', 3, 0, 2, '', '', '', '', 'N', '2008-11-05', ''),
(36, '36', 'Chow Eng Forn', '540614065060', 'F', '1954-06-14', '019772186', '', 'Y', 0, '', '', 4, 0, '2008-11-05 19:02:24', 3, '2008-11-05 19:02:24', 3, 0, 2, 'Confirm IC num with customer again!', '', '', '', 'N', '2008-11-05', ''),
(37, '37', 'Lim Yen Yen', '720616065060', 'F', '1972-06-16', '0167461463', '', 'Y', 0, '', '', 4, 0, '2008-11-05 19:04:20', 3, '2008-11-05 19:04:20', 3, 0, 2, '', '', '', '', 'N', '2008-11-05', ''),
(38, '38', 'Diana', '800426015062', 'F', '1980-04-26', '0166986890', '', 'Y', 0, '', '', 3, 0, '2008-11-05 19:06:26', 3, '2008-11-05 19:06:26', 3, 0, 3, 'Check back races', '', '', '', 'N', '2008-11-05', ''),
(39, '39', 'Tan Eik Ling', '84111701506', 'F', '1984-11-17', '0127257306', '', 'Y', 0, '', '', 3, 0, '2008-11-05 19:08:36', 3, '2008-11-05 19:08:36', 3, 0, 2, '', '', '', '', 'N', '2008-11-05', ''),
(40, '40', 'Ng', '781029015068', 'F', '1978-10-29', '0127698848', '', 'Y', 0, '', '', 3, 0, '2008-11-05 19:10:48', 3, '2008-11-05 19:10:48', 3, 0, 2, 'Get full name with customer!', '', '', '', 'N', '2008-11-05', ''),
(41, '41', 'Chong Lei Peng', '811230085070', 'F', '1981-12-30', '', '', 'Y', 0, '', '', 3, 0, '2008-11-05 19:14:16', 3, '2008-11-05 19:14:16', 3, 0, 2, 'Get IC no with customer', '', '', '', 'N', '2008-11-05', ''),
(42, '42', 'Chua Wan Ching', '880520435074', 'F', '1988-05-20', '0167107637', '', 'Y', 0, '', '', 2, 0, '2008-11-05 19:16:18', 3, '2008-11-05 19:16:18', 3, 0, 2, '', '', '', '', 'N', '2008-11-05', ''),
(43, '43', 'Carol Kok Lai Fung', '730802055076', 'F', '1973-08-02', '0297559177', '', 'Y', 0, 'No3,Jln Kota Merdesa', 'Tmn Kota Merdesa', 3, 0, '2008-11-05 19:36:22', 3, '2008-11-05 19:36:22', 3, 0, 2, '', '', 'Johor', '81900', 'N', '2008-11-05', 'Kota Tinggi'),
(44, '44', 'Mrs Anne', '660606045080', 'F', '1966-06-06', '0197311666', '', 'Y', 0, '', '', 4, 0, '2008-11-05 19:38:01', 3, '2008-11-05 19:38:50', 3, 0, 2, 'Get full name!', '', '', '', 'N', '2008-11-05', ''),
(45, '45', 'Teh Lee See', '830407015080', 'F', '1983-04-07', '0127262232', '', 'Y', 0, '', '', 3, 0, '2008-11-05 19:40:35', 3, '2008-11-05 19:40:35', 3, 0, 2, '', '', '', '', 'N', '2008-11-05', ''),
(46, '46', 'Chin Chee Fei', '831018015081', 'F', '1983-10-18', '0167393893', '', 'Y', 0, '', '', 3, 0, '2008-11-05 19:41:54', 3, '2008-11-05 19:41:54', 3, 0, 2, '', '', '', '', 'N', '2008-11-05', ''),
(47, '47', 'Cheong Chai Vean', '850211105082', 'F', '1985-02-12', '0137668822', '', 'Y', 0, '22,Jln Manggis 2', 'Tmn KOta Jaya', 3, 0, '2008-11-06 16:15:59', 3, '2008-11-06 16:15:59', 3, 0, 2, '', '', 'Johor', '81900', 'N', '2008-11-06', 'Kota Tinggi'),
(48, '48', 'Tan Mee Wei', '850523055084', 'F', '1985-05-23', '0167371883', '', 'Y', 0, '', '', 3, 0, '2008-11-06 16:19:23', 3, '2008-11-06 16:19:23', 3, 0, 2, '', '', '', '', 'N', '2008-11-06', ''),
(49, '49', 'Chia Yen Hui', '881108105086', 'F', '1988-11-08', '0167246908', '', 'Y', 0, '', '', 2, 0, '2008-11-06 16:21:35', 3, '2008-11-06 16:21:35', 3, 0, 2, '', '', '', '', 'N', '2008-11-06', ''),
(50, '50', 'Teo Eng Seng', '810309015089', 'F', '1981-03-09', '0127666963', '', 'Y', 0, '79,Jln Haji Omar', 'Tmn. Kota Besar', 3, 0, '2008-11-06 16:24:03', 3, '2008-11-06 16:24:03', 3, 0, 2, '', '', 'Johor', '81900', 'N', '2008-11-06', 'Kota Tinggi'),
(51, '51', 'Rashita A.Hadi', '800302025090', 'F', '1980-03-02', '0197050526', '', 'Y', 0, '', '', 3, 0, '2008-11-06 16:26:56', 3, '2008-11-06 16:26:56', 3, 0, 3, '', '', '', '', 'N', '2008-11-06', ''),
(52, '52', 'Tay Hui Ying', '850628015090', 'F', '1985-06-28', '0127699023', '', 'Y', 0, '', '', 3, 0, '2008-11-06 16:29:37', 3, '2008-11-06 16:29:37', 3, 0, 2, '', '', '', '', 'N', '2008-11-06', ''),
(53, '53', 'Mrs Wang', '560917035092', 'F', '1956-09-17', '0127182983', '', 'Y', 0, '', '', 4, 0, '2008-11-06 16:31:28', 3, '2008-11-06 16:32:12', 3, 0, 2, 'Get full name with customer!', '', '', '', 'N', '2008-11-06', ''),
(54, '54', 'Man Lian', '700315045092', 'F', '1970-03-15', '0137209800', '', 'Y', 0, '', '', 4, 0, '2008-11-06 16:35:44', 3, '2008-11-06 16:35:44', 3, 0, 2, '', '', '', '', 'N', '2008-11-06', ''),
(55, '55', 'Hong Ying Ning', '831110015092', 'F', '1983-11-10', '0167877617', '', 'Y', 0, '', '', 3, 0, '2008-11-06 16:37:23', 3, '2008-11-06 16:37:23', 3, 0, 2, '', '', '', '', 'N', '2008-11-06', ''),
(56, '56', 'Foong Yan Li', '830610015094', 'F', '1983-06-10', '0127559515', '', 'Y', 0, '', '', 3, 0, '2008-11-06 16:40:06', 3, '2008-11-06 16:40:06', 3, 0, 2, '', '', '', '', 'N', '2008-11-06', ''),
(57, '57', 'Sharon', '811110015094', 'F', '1981-11-10', '0167454559', '', 'Y', 0, '', '', 3, 0, '2008-11-06 16:41:40', 3, '2008-11-06 16:41:40', 3, 0, 2, '', '', '', '', 'N', '2008-11-06', ''),
(58, '58', 'Noor Hafidza Sahli', '850210115094', 'F', '1985-02-10', '0132566444', '', 'Y', 0, '', '', 3, 0, '2008-11-06 16:44:02', 3, '2008-11-06 16:44:02', 3, 0, 3, '', '', '', '', 'N', '2008-11-06', ''),
(59, '59', 'Noorlisa Bt Saleh', '770612015096', 'F', '1977-06-12', '', '', 'Y', 0, '', '', 3, 0, '2008-11-06 16:45:44', 3, '2008-11-06 16:45:44', 3, 0, 3, 'Get the phone num.', '', '', '', 'N', '2008-11-06', ''),
(60, '60', 'Tan Xiao Feng', '801206015102', 'F', '1980-12-06', '0127330122', '', 'Y', 0, '', '', 3, 0, '2008-11-06 16:47:42', 3, '2008-11-06 16:47:42', 3, 0, 2, '', '', '', '', 'N', '2008-11-06', ''),
(61, '61', 'Heng Shih Yean', '810526015106', 'F', '1981-05-26', '0127879737', '', 'Y', 0, '11,Jln Kangkong 5', 'Tmn. Sri Lalang', 3, 0, '2008-11-07 15:53:00', 3, '2008-11-07 15:53:00', 3, 0, 2, '', '', 'Johor', '81900', 'N', '2008-11-07', 'Kota Tinggi'),
(62, '62', 'Athletchumy', '921023015106', 'F', '1992-10-23', '0177333674', '', 'Y', 0, '', '', 2, 0, '2008-11-07 15:55:30', 3, '2008-11-07 16:54:59', 3, 0, 4, '', '', '', '', 'N', '2008-11-07', ''),
(63, '63', 'Daphne Lu swee Yap', '820708015114', 'F', '1982-07-08', '0197409773', '', 'Y', 0, '', '', 3, 0, '2008-11-07 16:15:37', 3, '2008-11-07 16:15:37', 3, 0, 2, '', '', '', '', 'N', '2008-11-07', ''),
(64, '64', 'Cheng siew choo', '810420015116', 'F', '1981-04-20', '0167972020', '', 'Y', 0, '', '', 0, 0, '2008-11-07 16:20:39', 3, '2008-11-07 16:20:39', 3, 0, 2, 'Not clear!', '', '', '', 'N', '2008-11-07', ''),
(65, '65', 'Chia Choon Fong', '810421015118', 'F', '1981-04-21', '0127655653', '', 'Y', 0, '', '', 3, 0, '2008-11-07 16:24:43', 3, '2008-11-07 16:24:43', 3, 0, 2, '', '', '', '', 'N', '2008-11-07', ''),
(66, '66', 'Ng Siew Mee', '621011015120', 'F', '1962-01-11', '0127372886', '', 'Y', 0, '9, Jln Bayam', 'Tmn. Sri Lalang', 4, 0, '2008-11-07 16:29:45', 3, '2008-11-07 16:29:45', 3, 0, 2, '', '', '', '', 'N', '2008-11-07', ''),
(67, '67', 'Teo Chui yun', '871120235124', 'F', '1987-11-20', '0197399221', '', 'Y', 0, '', '', 2, 0, '2008-11-07 16:32:47', 3, '2008-11-07 16:32:47', 3, 0, 2, '', '', '', '', 'N', '2008-11-07', ''),
(68, '68', 'Kiauw Siam Gouw', '561105715126', 'F', '1956-11-05', '0127133819', '', 'Y', 0, '', '', 4, 0, '2008-11-07 16:48:49', 3, '2008-11-07 16:48:49', 3, 0, 2, '', '', '', '', 'N', '2008-11-07', ''),
(69, '69', 'Sharmila A/P Damodharan', '920525015128', 'F', '1992-05-25', '0167391052', '', 'Y', 0, '32,Jln Kobis', 'Tmn. Sri Lalang', 2, 0, '2008-11-07 16:51:43', 3, '2008-11-07 16:51:43', 3, 0, 4, '', '', 'Johor', '81900', 'N', '2008-11-07', 'Kota Tinggi'),
(70, '70', 'Yasotha', '840613015128', 'F', '1984-06-13', '0127173107', '', 'Y', 0, '', '', 3, 0, '2008-11-07 16:53:19', 3, '2008-11-07 16:53:19', 3, 0, 3, '', '', '', '', 'N', '2008-11-07', ''),
(71, '71', 'Thong Yip Ling', '811026065128', 'F', '1981-10-26', '0169332210', '', 'Y', 0, '', '', 3, 0, '2008-11-07 16:54:47', 3, '2008-11-07 16:54:47', 3, 0, 2, '', '', '', '', 'N', '2008-11-07', ''),
(72, '72', 'Noorlydiawati Bt Saleh', '820628055132', 'F', '1982-06-28', '0166111022', '', 'Y', 0, '', '', 3, 0, '2008-11-07 16:58:27', 3, '2008-11-07 16:58:27', 3, 0, 3, '', '', '', '', 'N', '2008-11-07', ''),
(74, '74', 'Shelly Low', '620207085134', 'F', '1962-02-07', '012-7046631', '', 'Y', 0, '7, Jln Berlian 5', 'Tmn. Daiman', 4, 0, '2008-11-07 17:41:53', 3, '2008-11-07 17:41:53', 3, 0, 2, '', 'Malaysia', 'Johor', '81900', 'N', '2008-11-07', 'Kota Tinggi'),
(75, '75', 'Angela Chai Pay Fen', '801226015134', 'F', '1980-12-26', '0197729338', '07-3528526', 'Y', 0, '10,Jln Danau 31', 'Tmn Desa Jaya', 3, 0, '2008-11-07 17:45:05', 3, '2008-11-07 17:45:05', 3, 0, 2, '', '', 'Johor', '81100', 'N', '2008-11-07', 'JB'),
(76, '76', 'DC Chan', '830520065135', 'F', '1983-05-20', '0177557000', '', 'Y', 0, '', '', 3, 0, '2008-11-07 17:46:46', 3, '2008-11-07 17:46:46', 3, 0, 2, '', '', '', '', 'N', '2008-11-07', ''),
(77, '77', 'Ah Qin', '811130145136', 'F', '1981-11-30', '02-93625558', '', 'Y', 0, '', '', 3, 0, '2008-11-07 17:49:09', 3, '2008-11-07 17:49:09', 3, 0, 2, '', '', '', '', 'N', '2008-11-07', ''),
(78, '78', 'Lim Sien Ling', '831118015142', 'F', '1983-11-18', '0127256636', '', 'Y', 0, '', '', 3, 0, '2008-11-07 17:53:05', 3, '2008-11-07 17:53:05', 3, 0, 2, '', '', '', '', 'N', '2008-11-07', ''),
(79, '79', 'Jenny ', '770502135142', 'F', '1977-05-02', '0167864517', '', 'Y', 0, '', '', 3, 0, '2008-11-07 18:13:14', 3, '2008-11-07 18:13:14', 3, 0, 2, 'Get full name', '', '', '', 'N', '2008-11-07', ''),
(80, '80', 'Lim Sue Zann', '830730015144', 'F', '1983-07-30', '0197404862', '078833089', 'Y', 0, '1,JLn Sawi', 'Tmn. Sri Lalang', 3, 0, '2008-11-07 18:16:07', 3, '2008-11-07 18:16:07', 3, 0, 2, '', '', 'Johor', '81900', 'N', '2008-11-07', 'Kota Tinggi'),
(81, '81', 'Haine', '730422015144', 'F', '1973-04-22', '017-7140822', '', 'Y', 0, '', 'Tmn KOta Jaya', 4, 0, '2008-11-07 18:18:36', 3, '2008-11-07 18:18:36', 3, 0, 3, '', '', '', '', 'N', '2008-11-07', ''),
(82, '82', 'Lim Soo Chin', '800410015148', 'F', '1980-04-10', '016-7769280', '', 'Y', 0, '59,Jln Remia 6', 'Tmn KOta Jaya', 3, 0, '2008-11-07 18:21:22', 3, '2008-11-07 18:21:22', 3, 0, 2, '', '', 'Johor', '81900', 'N', '2008-11-07', 'Kota Tinggi'),
(83, '83', 'Gan Hui Shi', '831225015148', 'F', '1983-12-25', '0197323760', '07-8836701', 'Y', 0, 'Lot 475,Batu 2.Jln Lombong', '', 3, 0, '2008-11-07 18:25:28', 3, '2008-11-07 18:26:09', 3, 0, 2, '', '', '', '81900', 'N', '2008-11-07', 'Kota Tinggi'),
(84, '84', 'Chia Kuang Tan', '841217015155', 'F', '1984-12-17', '0127300177', '', 'Y', 0, '', '', 3, 0, '2008-11-07 18:27:45', 3, '2008-11-07 18:27:45', 3, 0, 2, '', '', '', '', 'N', '2008-11-07', ''),
(85, '85', 'Lee Sweet Nee', '851007015156', 'F', '1985-10-07', '0168530249', '', 'Y', 0, '', '', 3, 0, '2008-11-07 18:30:30', 3, '2008-11-07 18:30:30', 3, 0, 2, '', '', '', '', 'N', '2008-11-07', ''),
(86, '86', 'Maggie Chong', '710503015164', 'F', '1971-05-03', '016-7804000', '', 'Y', 0, '20,Jln Binjai', 'Tmn KOta Jaya', 4, 0, '2008-11-07 18:32:59', 3, '2008-11-07 18:32:59', 3, 0, 2, '', '', 'Johor', '81900', 'N', '2008-11-07', 'Kota Tinggi'),
(87, '87', 'YIng Miao', '85092901516', 'F', '1985-09-29', '016-7977742/016-', '', 'Y', 0, '', '', 3, 0, '2008-11-07 18:35:02', 3, '2008-11-07 18:35:02', 3, 0, 2, '', '', '', '', 'N', '2008-11-07', ''),
(88, '88', 'Chong Ci Hui', '871206235168', 'F', '1987-12-06', '012-7953170', '', 'Y', 0, '26,JLn Mentimun', 'Tmn Ahmad Perang', 2, 0, '2008-11-07 18:38:56', 3, '2008-11-07 18:38:56', 3, 0, 2, '', '', 'Johor', '81900', 'N', '2008-11-07', 'Kota Tinggi'),
(89, '89', 'Chun BONG Kiok', '560505015626', 'F', '1956-05-05', '0197622520', '', 'Y', 0, '', '', 4, 0, '2008-11-07 18:57:09', 3, '2008-11-07 18:57:09', 3, 0, 2, '', '', '', '', 'N', '2008-11-07', ''),
(90, '90', 'Jurianah Abu Bakar', '820215115168', 'F', '1982-02-15', '016-7003626', '', 'Y', 0, '53,Jln Cempedak ', 'Tmn Muhibah', 3, 0, '2008-11-07 19:02:28', 3, '2008-11-07 19:02:28', 3, 0, 3, '', '', 'Johor', '81900', 'N', '2008-11-07', 'Kota Tinggi'),
(91, '91', 'Sumathi', '720525015172', 'F', '1972-05-25', '', '078826280', 'Y', 0, '', '', 0, 0, '2008-11-09 13:03:47', 3, '2008-11-09 13:03:47', 3, 0, 3, '', '', '', '', 'N', '2008-11-09', ''),
(92, '92', 'Chris', '870918145174', 'F', '1987-09-18', '0163325262', '', 'Y', 0, 'P/3/14 Prisma Perdana Jln Midah', '8A Tmn. Midah ', 2, 0, '2008-11-09 13:09:38', 3, '2008-11-09 13:09:38', 3, 0, 2, '', '', 'kuala Lumpur', '56000', 'N', '2008-11-09', 'Cheras'),
(93, '93', 'Tiu Chai Liy', '800605055174', 'F', '1980-06-05', '0127349797', '', 'Y', 0, '', '', 3, 0, '2008-11-09 13:12:32', 3, '2008-11-09 13:12:32', 3, 0, 2, '', '', '', '', 'N', '2008-11-09', ''),
(94, '94', 'Chia Hui Qiu', '830320015176', 'F', '1983-03-20', '0298374200', '', 'Y', 0, '29,Jln Mohideen', 'Kota Kecil', 3, 0, '2008-11-09 18:47:03', 3, '2008-11-09 18:47:03', 3, 0, 2, '', '', 'Johor', '81900', 'N', '2008-11-09', 'Kota Tinggi'),
(95, '95', 'Kelly Yap', '761229145176', 'F', '1976-12-29', '0122992403', '', 'Y', 0, '', '', 3, 0, '2008-11-09 18:50:23', 3, '2008-11-09 18:50:23', 3, 0, 2, '', '', '', '', 'N', '2008-11-09', ''),
(96, '96', 'Nirmala A/P Ramanamy', '690320015182', 'F', '1969-03-20', '0167325117', '', 'Y', 0, 'No16,Jln Kepayang', 'Tmn KOta Jaya', 4, 0, '2008-11-09 18:53:29', 3, '2008-11-09 18:53:29', 3, 0, 4, '', '', 'Johor', '81900', 'N', '2008-11-09', 'Kota Tinggi'),
(97, '97', 'Noorhaslinda Bt Saimin', '860602235182', 'F', '1986-11-02', '019-3841470/017-', '', 'Y', 0, '312,Felda Tenggaroh 1,', '', 3, 0, '2008-11-09 18:59:59', 3, '2008-11-09 18:59:59', 3, 0, 3, '', '', 'Johor', '86810', 'N', '2008-11-09', 'Mersing'),
(98, '98', 'Logeswari Marimuthu', '810822085184', 'F', '1981-08-22', '012-4965665', '', 'Y', 0, '', '', 3, 0, '2008-11-09 19:01:42', 3, '2008-11-09 19:01:42', 3, 0, 4, '', '', '', '', 'N', '2008-11-09', ''),
(99, '99', 'Gigi Low', '790525015184', 'F', '1976-05-25', '019-7850888', '', 'Y', 0, '', '', 3, 0, '2008-11-09 19:03:08', 3, '2008-11-09 19:03:08', 3, 0, 2, '', '', '', '', 'N', '2008-11-09', ''),
(100, '100', 'Chia Yin', '800421015186', 'F', '1980-04-21', '012-7320227', '', 'Y', 0, '', '', 3, 0, '2008-11-09 19:04:35', 3, '2008-11-09 19:04:35', 3, 0, 2, '', '', '', '', 'N', '2008-11-09', ''),
(101, '101', 'Qadaria Bt Md Isa', '840627015188', 'F', '1984-06-27', '017-7999790', '', 'Y', 0, '49,Jln Bunga Raya Besar', '', 3, 0, '2008-11-09 19:09:46', 3, '2008-11-09 19:09:46', 3, 0, 3, '', '', 'Johor', '81100', 'N', '2008-11-09', 'JB'),
(102, '102', 'Connie', '820204015188', 'F', '1982-02-04', '016-7608189', '', 'Y', 0, '', '', 3, 0, '2008-11-09 19:11:02', 3, '2008-11-09 19:11:02', 3, 0, 2, '', '', '', '', 'N', '2008-11-09', ''),
(103, '103', 'Noor Aine Bt Harun', '770504115190', 'F', '1977-05-04', '012-7327984', '', 'Y', 0, 'No 5,Jln Binjai', 'Tmn KOta Jaya', 3, 0, '2008-11-09 19:12:55', 3, '2008-11-09 19:12:55', 3, 0, 3, '', '', 'Johor', '81900', 'N', '2008-11-09', 'Kota Tinggi'),
(104, '104', 'Nur Mazlinda Bt Mohd', '930611015190', 'F', '1993-06-11', '017-7848374', '', 'Y', 0, 'No22,Jln Mohideen', 'Kota Kecil', 2, 0, '2008-11-09 19:14:47', 3, '2008-11-09 19:15:58', 3, 0, 3, '', '', 'Johor', '81900', 'N', '2008-11-09', 'Kota Tinggi'),
(105, '105', 'Ni Li Wen', '880213085190', 'F', '1988-02-13', '016-7448383', '', 'Y', 0, '', '', 2, 0, '2008-11-09 19:17:54', 3, '2008-11-09 19:17:54', 3, 0, 2, '', '', '', '', 'N', '2008-11-09', ''),
(106, '106', 'Foo Rhung Rhung', '870517015192', 'F', '1987-05-17', '013-7555955', '07-8826387', 'Y', 0, '', '', 2, 0, '2008-11-09 19:20:07', 3, '2008-11-09 19:20:07', 3, 0, 2, '', '', '', '', 'N', '2008-11-09', ''),
(107, '107', 'Wan Nyuk Heng', '740922055192', 'F', '1974-09-22', '012-7181700', '', 'Y', 0, '7,Jln Kembia 14,', 'Tmn Puteri Wangsa', 3, 0, '2008-11-09 19:22:38', 3, '2008-11-09 19:22:38', 3, 0, 2, '', '', 'Johor', '81800 ', 'N', '2008-11-09', 'Ulu Tiram'),
(108, '108', 'Wzti Bt Saidi', '680816715196', 'F', '1968-08-16', '012-7764547', '', 'Y', 0, 'HS Qtrs. Klinik Kesihatan', 'Bandar Mas', 4, 0, '2008-11-09 19:26:10', 3, '2008-11-09 19:26:10', 3, 0, 3, '', '', '', '', 'N', '2008-11-09', ''),
(109, '109', 'Regina Siow', '671229015196', 'F', '1967-12-29', '019-7341398', '', 'Y', 0, '', '', 4, 0, '2008-11-09 19:27:23', 3, '2008-11-09 19:27:23', 3, 0, 2, '', '', '', '', 'N', '2008-11-09', ''),
(110, '110', 'Tan Xiao Lin', '720717075196', 'F', '1972-07-17', '019-7980413', '', 'Y', 0, '', '', 4, 0, '2008-11-09 19:28:53', 3, '2008-11-09 19:28:53', 3, 0, 2, '', '', '', '', 'N', '2008-11-09', ''),
(111, '111', 'Chong Fung Mei', '840122065198', 'F', '1984-01-22', '016-9223970/017-', '', 'Y', 0, '71,Jln Rumbia 79', 'Tmn Daya', 3, 0, '2008-11-09 19:31:47', 3, '2008-11-09 19:31:47', 3, 0, 2, '', '', 'Johor', '81100', 'N', '2008-11-09', 'JB'),
(112, '112', 'Rohamah Chik', '630705115200', 'F', '1963-07-05', '013-7093685', '', 'Y', 0, '103,Block B', 'Tmn. Laksama', 4, 0, '2008-11-11 13:47:14', 3, '2008-11-11 13:47:14', 3, 0, 3, '', '', '', '', 'N', '2008-11-11', 'Kota Tinggi'),
(113, '113', 'Thagamah A/P Veerappan', '740308145200', 'F', '1074-03-08', '012-7072443', '', 'Y', 0, '', '', 3, 0, '2008-11-11 13:49:17', 3, '2008-11-11 13:49:17', 3, 0, 4, '', '', '', '', 'N', '2008-11-11', ''),
(114, '114', 'Tan Yong Chee', '840207015202', 'F', '1984-02-07', '012-7188915', '', 'Y', 0, '', '', 3, 0, '2008-11-11 13:50:58', 3, '2008-11-11 13:50:58', 3, 0, 2, '', '', '', '', 'N', '2008-11-11', ''),
(115, '115', 'YEE POI FOONG', '630410015204', 'F', '1963-04-10', '019-7408633', '', 'Y', 0, '32,JLN ANGGERIK UTAMA', 'TMN. MEDAN JAYA', 4, 0, '2008-11-11 13:53:32', 3, '2008-11-11 13:53:32', 3, 0, 2, '', '', 'Johor', '81900', 'N', '2008-11-11', 'Kota Tinggi'),
(116, '116', 'LEE WEI + LEE YI', '880721235204', 'F', '1988-07-21', '', '07-8831334', 'Y', 0, 'LADANG MAWAI', '', 2, 0, '2008-11-11 13:56:07', 3, '2008-11-11 13:56:07', 3, 0, 2, '', '', '', '', 'N', '2008-11-11', ''),
(117, '117', 'CHONG KAR PENG', '881203015206', 'F', '1988-12-03', '016-7793935', '', 'Y', 0, '', '', 0, 0, '2008-11-11 13:57:44', 3, '2008-11-11 13:57:44', 3, 0, 2, '', '', '', '', 'N', '2008-11-11', ''),
(118, '118', 'MENG PING', '881211015206', 'F', '1988-12-11', '016-7650196', '', 'Y', 0, '19,LORONG ABD AZIZ 2', '', 2, 0, '2008-11-11 13:59:40', 3, '2008-11-11 13:59:40', 3, 0, 2, '', 'Malaysia', 'Johor', '81900', 'N', '2008-11-11', 'Kota Tinggi'),
(119, '119', 'FADZILAH BT TALIB', '771127015206', 'F', '1977-11-27', '013-7136121', '', 'Y', 0, '', '', 3, 0, '2008-11-11 14:01:11', 3, '2008-11-11 14:01:11', 3, 0, 3, '', '', '', '', 'N', '2008-11-11', ''),
(120, '120', 'CHEONG SEET SAN', '810706085208', 'F', '1981-07-06', '016-7028533', '', 'Y', 0, '', '', 3, 0, '2008-11-11 14:06:57', 3, '2008-11-11 14:06:57', 3, 0, 2, '', '', '', '', 'N', '2008-11-11', ''),
(121, '121', 'CHIA YANN PEY', '830808105212', 'F', '1983-08-08', '012-7328996', '', 'Y', 0, '', '', 3, 0, '2008-11-11 14:09:58', 3, '2008-11-11 14:09:58', 3, 0, 2, '', '', '', '', 'N', '2008-11-11', ''),
(122, '122', 'TAN CHOON MEE', '490114015214', 'F', '1949-01-14', '016-7933112', '07-8833804', 'Y', 0, '', '', 4, 0, '2008-11-11 14:11:45', 3, '2008-11-11 14:11:45', 3, 0, 2, '', '', '', '', 'N', '2008-11-11', ''),
(123, '123', 'MEI XIANG', '641102015220', 'F', '1964-11-02', '', '07-8836736', 'Y', 0, '', '', 4, 0, '2008-11-11 14:13:50', 3, '2008-11-11 14:13:50', 3, 0, 2, '', '', '', '', 'N', '2008-11-11', '');

-- --------------------------------------------------------

--
-- Table structure for table `simit_simsalon_customerservice`
--

CREATE TABLE IF NOT EXISTS `simit_simsalon_customerservice` (
  `customerservice_id` int(11) NOT NULL auto_increment,
  `customerservice_no` varchar(20) NOT NULL,
  `employee_id` int(11) NOT NULL default '0',
  `customer_id` int(11) NOT NULL default '0',
  `customerservice_date` date NOT NULL default '0000-00-00',
  `organization_id` int(11) NOT NULL default '0',
  `created` datetime NOT NULL default '0000-00-00 00:00:00',
  `createdby` int(11) NOT NULL default '0',
  `updated` datetime NOT NULL default '0000-00-00 00:00:00',
  `updatedby` int(11) NOT NULL default '0',
  `isactive` char(1) NOT NULL default '',
  `filename` varchar(50) NOT NULL default '',
  `remarks` text,
  PRIMARY KEY  (`customerservice_id`),
  UNIQUE KEY `customerservice_no` (`customerservice_no`),
  KEY `employee_id` (`employee_id`),
  KEY `customer_id` (`customer_id`),
  KEY `organization_id` (`organization_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `simit_simsalon_customerservice`
--

INSERT INTO `simit_simsalon_customerservice` (`customerservice_id`, `customerservice_no`, `employee_id`, `customer_id`, `customerservice_date`, `organization_id`, `created`, `createdby`, `updated`, `updatedby`, `isactive`, `filename`, `remarks`) VALUES
(2, '2', 2, 10, '2008-11-05', 0, '2008-11-05 11:32:02', 3, '2008-11-05 11:32:02', 3, 'Y', '', ''),
(3, '3', 2, 77, '2008-11-11', 0, '2008-11-11 14:48:54', 3, '2008-12-12 14:28:11', 1, 'Y', '3.png', 'ok'),
(4, '4', 2, 77, '2008-11-11', 0, '2008-11-11 15:02:35', 3, '2008-11-11 15:03:00', 3, 'Y', '4.png', ''),
(9, '5', 3, 77, '2008-12-12', 0, '2008-12-12 14:41:33', 1, '2008-12-12 14:41:33', 1, 'Y', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `simit_simsalon_customertype`
--

CREATE TABLE IF NOT EXISTS `simit_simsalon_customertype` (
  `customertype_id` int(11) NOT NULL auto_increment,
  `filename` varchar(50) default NULL,
  `customertype_code` varchar(20) NOT NULL default '',
  `customertype_description` text NOT NULL,
  `isactive` char(1) NOT NULL default '',
  `organization_id` int(11) NOT NULL default '0',
  `created` datetime NOT NULL default '0000-00-00 00:00:00',
  `createdby` int(11) NOT NULL default '0',
  `updated` date NOT NULL default '0000-00-00',
  `updatedby` int(11) NOT NULL default '0',
  `remarks` text,
  PRIMARY KEY  (`customertype_id`),
  UNIQUE KEY `customertype_code` (`customertype_code`),
  KEY `organization_id` (`organization_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `simit_simsalon_customertype`
--

INSERT INTO `simit_simsalon_customertype` (`customertype_id`, `filename`, `customertype_code`, `customertype_description`, `isactive`, `organization_id`, `created`, `createdby`, `updated`, `updatedby`, `remarks`) VALUES
(0, NULL, '0', '', 'Y', 0, '0000-00-00 00:00:00', 0, '0000-00-00', 0, NULL),
(1, NULL, '1', '1-12', 'Y', 0, '2008-10-23 18:26:05', 3, '2008-10-23', 3, '1-12\r\n'),
(2, NULL, '2', '13-21', 'Y', 0, '2008-10-23 18:26:59', 3, '2008-10-23', 3, ''),
(3, NULL, '3', '22-35', 'Y', 0, '2008-10-23 18:27:27', 3, '2008-10-23', 3, ''),
(4, NULL, '4', '36-100', 'Y', 0, '2008-10-23 18:27:48', 3, '2008-10-23', 3, ''),
(5, NULL, '5', 'Unknown', 'Y', 0, '2008-10-23 18:43:09', 3, '2008-10-23', 3, '');

-- --------------------------------------------------------

--
-- Table structure for table `simit_simsalon_employee`
--

CREATE TABLE IF NOT EXISTS `simit_simsalon_employee` (
  `employee_id` int(11) NOT NULL auto_increment,
  `employee_no` varchar(8) NOT NULL default '',
  `employee_name` varchar(50) NOT NULL default '',
  `ic_no` varchar(20) NOT NULL default '',
  `gender` char(1) NOT NULL default 'M',
  `dateofbirth` date NOT NULL default '0000-00-00',
  `epf_no` varchar(15) NOT NULL default '',
  `socso_no` varchar(14) NOT NULL default '',
  `account_no` varchar(20) NOT NULL default '',
  `hp_no` varchar(16) NOT NULL default '',
  `tel_1` varchar(16) NOT NULL default '',
  `isactive` char(1) NOT NULL default '',
  `address_id` int(11) NOT NULL default '0',
  `stafftype_id` int(11) NOT NULL default '0',
  `cashonhand` float NOT NULL default '0',
  `organization_id` int(11) NOT NULL default '0',
  `created` datetime NOT NULL default '0000-00-00 00:00:00',
  `createdby` int(11) NOT NULL default '0',
  `updated` datetime NOT NULL default '0000-00-00 00:00:00',
  `updatedby` int(11) NOT NULL default '0',
  `uid` int(11) NOT NULL default '0',
  `races_id` int(1) NOT NULL default '0',
  `remarks` text,
  `basic_salary` decimal(12,2) default '0.00',
  `allowance1` decimal(12,2) default '0.00',
  `allowance_name1` varchar(50) default NULL,
  `allowance2` decimal(12,2) default '0.00',
  `allowance_name2` varchar(50) default NULL,
  `allowance3` decimal(12,2) default '0.00',
  `allowance_name3` varchar(50) default NULL,
  `socso_employee` decimal(12,2) NOT NULL default '0.00',
  `socso_employer` decimal(12,2) NOT NULL default '0.00',
  `epf_employee` decimal(12,2) NOT NULL default '0.00',
  `epf_employer` decimal(12,2) NOT NULL default '0.00',
  `joindate` date default NULL,
  `street1` varchar(100) default NULL,
  `street2` varchar(100) default NULL,
  `postcode` varchar(10) default NULL,
  `city` varchar(30) default NULL,
  `state` varchar(30) default NULL,
  `country` varchar(30) default NULL,
  `isdefault` char(1) default 'N',
  PRIMARY KEY  (`employee_id`),
  UNIQUE KEY `employee_no` (`employee_no`),
  UNIQUE KEY `ic_no` (`ic_no`),
  KEY `races_id` (`races_id`),
  KEY `organization_id` (`organization_id`),
  KEY `stafftype_id` (`stafftype_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `simit_simsalon_employee`
--

INSERT INTO `simit_simsalon_employee` (`employee_id`, `employee_no`, `employee_name`, `ic_no`, `gender`, `dateofbirth`, `epf_no`, `socso_no`, `account_no`, `hp_no`, `tel_1`, `isactive`, `address_id`, `stafftype_id`, `cashonhand`, `organization_id`, `created`, `createdby`, `updated`, `updatedby`, `uid`, `races_id`, `remarks`, `basic_salary`, `allowance1`, `allowance_name1`, `allowance2`, `allowance_name2`, `allowance3`, `allowance_name3`, `socso_employee`, `socso_employer`, `epf_employee`, `epf_employer`, `joindate`, `street1`, `street2`, `postcode`, `city`, `state`, `country`, `isdefault`) VALUES
(0, '0', '', '', 'M', '0000-00-00', '', '', '', '', '', '', 0, 0, 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, 0, 0, NULL, 0.00, 0.00, NULL, 0.00, NULL, 0.00, NULL, 0.00, 0.00, 0.00, 0.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Y'),
(1, '1', 'Sang Jiunn Siang', '851013016403', 'M', '1985-10-13', '', '', '', '0143887611', '', 'Y', 0, 1, 0, 0, '2008-10-29 15:09:53', 3, '2008-11-05 12:09:53', 3, 0, 2, '', 1000.00, 0.00, '', 0.00, '', 0.00, '', 0.00, 0.00, 0.00, 0.00, '2008-03-15', '', '', '', '', '', '', 'N'),
(2, '2', 'Candy', '860102236592', 'F', '1986-01-02', '', '', '', '0197963397', '', 'Y', 0, 1, 0, 0, '2008-10-29 15:12:46', 3, '2008-11-05 12:12:31', 3, 0, 2, '', 1300.00, 0.00, '', 0.00, '', 0.00, '', 0.00, 0.00, 0.00, 0.00, '2006-03-15', '', '', '', '', '', '', 'N'),
(3, '3', 'Eva', '680706016314', 'F', '1968-07-06', '', '', '', '0127511177', '', 'Y', 0, 1, 0, 0, '2008-10-29 15:16:25', 3, '2008-11-05 12:05:07', 3, 0, 2, '', 1650.00, 0.00, '', 0.00, '', 0.00, '', 0.00, 0.00, 0.00, 0.00, '2005-01-01', '', '', '', '', '', '', 'N'),
(4, '4', 'Liely', '900209016702', 'F', '1990-02-09', '', '', '', '0177066976', '', 'Y', 0, 2, 0, 0, '2008-10-29 15:18:00', 3, '2008-11-05 12:07:24', 3, 0, 3, '', 580.00, 0.00, '', 0.00, '', 0.00, '', 0.00, 0.00, 0.00, 0.00, '2008-03-16', '', '', '', '', '', '', 'N'),
(5, '5', 'Viki', '810312016496', 'F', '1981-03-12', '', '', '', '0197898555', '', 'Y', 0, 1, 0, 0, '2008-10-29 15:20:25', 3, '2008-11-05 12:11:58', 3, 0, 2, '', 800.00, 0.00, '', 0.00, '', 0.00, '', 0.00, 0.00, 0.00, 0.00, '2008-09-01', '', '', '', '', '', '', 'N'),
(6, '6', 'Seren', '770304015940', 'F', '1977-03-04', '', '', '', '0127131055', '', 'Y', 0, 3, 0, 0, '2008-10-29 15:22:44', 3, '2008-11-05 12:10:53', 3, 0, 2, '', 5000.00, 0.00, '', 0.00, '', 0.00, '', 0.00, 0.00, 0.00, 0.00, '2003-09-15', '', '', '', '', '', '', 'N'),
(7, '7', 'Ng Shu Ting', '930924016178', 'F', '1993-09-24', '', '', '', '0167513724', '', 'Y', 0, 2, 0, 0, '2008-11-05 11:57:02', 3, '2008-11-05 12:08:17', 3, 0, 2, '', 450.00, 0.00, '', 0.00, '', 0.00, '', 0.00, 0.00, 0.00, 0.00, '2008-10-01', '', '', '', '', '', '', 'N'),
(8, '8', 'Wai Fung Sin', '920421015844', 'F', '1992-04-21', '', '', '', '0167037267', '', 'Y', 0, 2, 0, 0, '2008-11-05 12:01:48', 3, '2008-11-05 12:01:48', 3, 0, 2, '', 300.00, 0.00, '', 0.00, '', 0.00, '', 0.00, 0.00, 0.00, 0.00, '2008-10-01', '', '', '', '', '', '', 'N');

-- --------------------------------------------------------

--
-- Table structure for table `simit_simsalon_epftable`
--

CREATE TABLE IF NOT EXISTS `simit_simsalon_epftable` (
  `epf_id` int(11) NOT NULL auto_increment,
  `amtfrom` decimal(12,2) NOT NULL,
  `amtto` decimal(12,2) NOT NULL,
  `employer_amt` decimal(12,2) NOT NULL,
  `employee_amt` decimal(12,2) NOT NULL,
  `totalamt` decimal(12,2) NOT NULL,
  PRIMARY KEY  (`epf_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=402 ;

--
-- Dumping data for table `simit_simsalon_epftable`
--

INSERT INTO `simit_simsalon_epftable` (`epf_id`, `amtfrom`, `amtto`, `employer_amt`, `employee_amt`, `totalamt`) VALUES
(1, 0.01, 10.00, 0.00, 0.00, 0.00),
(2, 10.01, 20.00, 3.00, 3.00, 6.00),
(3, 20.01, 40.00, 5.00, 5.00, 10.00),
(4, 40.01, 60.00, 8.00, 7.00, 15.00),
(5, 60.01, 80.00, 10.00, 9.00, 19.00),
(6, 80.01, 100.00, 12.00, 11.00, 23.00),
(7, 100.01, 120.00, 15.00, 14.00, 29.00),
(8, 120.01, 140.00, 17.00, 16.00, 33.00),
(9, 140.01, 160.00, 20.00, 18.00, 38.00),
(10, 160.01, 180.00, 22.00, 20.00, 42.00),
(11, 180.01, 200.00, 24.00, 22.00, 46.00),
(12, 200.01, 220.00, 27.00, 25.00, 52.00),
(13, 220.01, 240.00, 29.00, 27.00, 56.00),
(14, 240.01, 260.00, 32.00, 29.00, 61.00),
(15, 260.01, 280.00, 34.00, 31.00, 65.00),
(16, 280.01, 300.00, 36.00, 33.00, 69.00),
(17, 300.01, 320.00, 39.00, 36.00, 75.00),
(18, 320.01, 340.00, 41.00, 38.00, 79.00),
(19, 340.01, 360.00, 44.00, 40.00, 84.00),
(20, 360.01, 380.00, 46.00, 42.00, 88.00),
(21, 380.01, 400.00, 48.00, 44.00, 92.00),
(22, 400.01, 420.00, 51.00, 47.00, 98.00),
(23, 420.01, 440.00, 53.00, 49.00, 102.00),
(24, 440.01, 460.00, 56.00, 51.00, 107.00),
(25, 460.01, 480.00, 58.00, 53.00, 111.00),
(26, 480.01, 500.00, 60.00, 55.00, 115.00),
(27, 500.01, 520.00, 63.00, 58.00, 121.00),
(28, 520.01, 540.00, 65.00, 60.00, 125.00),
(29, 540.01, 560.00, 68.00, 62.00, 130.00),
(30, 560.01, 580.00, 70.00, 64.00, 134.00),
(31, 580.01, 600.00, 72.00, 66.00, 138.00),
(32, 600.01, 620.00, 75.00, 69.00, 144.00),
(33, 620.01, 640.00, 77.00, 71.00, 148.00),
(34, 640.01, 660.00, 80.00, 73.00, 153.00),
(35, 660.01, 680.00, 82.00, 75.00, 157.00),
(36, 680.01, 700.00, 84.00, 77.00, 161.00),
(37, 700.01, 720.00, 87.00, 80.00, 167.00),
(38, 720.01, 740.00, 89.00, 82.00, 171.00),
(39, 740.01, 760.00, 92.00, 84.00, 176.00),
(40, 760.01, 780.00, 94.00, 86.00, 180.00),
(41, 780.01, 800.00, 96.00, 88.00, 184.00),
(42, 800.01, 820.00, 99.00, 91.00, 190.00),
(43, 820.01, 840.00, 101.00, 93.00, 194.00),
(44, 840.01, 860.00, 104.00, 95.00, 199.00),
(45, 860.01, 880.00, 106.00, 97.00, 203.00),
(46, 880.01, 900.00, 108.00, 99.00, 207.00),
(47, 900.01, 920.00, 111.00, 102.00, 213.00),
(48, 920.01, 940.00, 113.00, 104.00, 217.00),
(49, 940.01, 960.00, 116.00, 106.00, 222.00),
(50, 960.01, 980.00, 118.00, 108.00, 226.00),
(51, 980.01, 1000.00, 120.00, 110.00, 230.00),
(52, 1000.01, 1020.00, 123.00, 113.00, 236.00),
(53, 1020.01, 1040.00, 125.00, 115.00, 240.00),
(54, 1040.01, 1060.00, 128.00, 117.00, 245.00),
(55, 1060.01, 1080.00, 130.00, 119.00, 249.00),
(56, 1080.01, 1100.00, 132.00, 121.00, 253.00),
(57, 1100.01, 1120.00, 135.00, 124.00, 259.00),
(58, 1120.01, 1140.00, 137.00, 126.00, 263.00),
(59, 1140.01, 1160.00, 140.00, 128.00, 268.00),
(60, 1160.01, 1180.00, 142.00, 130.00, 272.00),
(61, 1180.01, 1200.00, 144.00, 132.00, 276.00),
(62, 1200.01, 1220.00, 147.00, 135.00, 282.00),
(63, 1220.01, 1240.00, 149.00, 137.00, 286.00),
(64, 1240.01, 1260.00, 152.00, 139.00, 291.00),
(65, 1260.01, 1280.00, 154.00, 141.00, 295.00),
(66, 1280.01, 1300.00, 156.00, 143.00, 299.00),
(67, 1300.01, 1320.00, 159.00, 146.00, 305.00),
(68, 1320.01, 1340.00, 161.00, 148.00, 309.00),
(69, 1340.01, 1360.00, 164.00, 150.00, 314.00),
(70, 1360.01, 1380.00, 166.00, 152.00, 318.00),
(71, 1380.01, 1400.00, 168.00, 154.00, 322.00),
(72, 1400.01, 1420.00, 171.00, 157.00, 328.00),
(73, 1420.01, 1440.00, 173.00, 159.00, 332.00),
(74, 1440.01, 1460.00, 176.00, 161.00, 337.00),
(75, 1460.01, 1480.00, 178.00, 163.00, 341.00),
(76, 1480.01, 1500.00, 180.00, 165.00, 345.00),
(77, 1500.01, 1520.00, 183.00, 168.00, 351.00),
(78, 1520.01, 1540.00, 185.00, 170.00, 355.00),
(79, 1540.01, 1560.00, 188.00, 172.00, 360.00),
(80, 1560.01, 1580.00, 190.00, 174.00, 364.00),
(81, 1580.01, 1600.00, 192.00, 176.00, 368.00),
(82, 1600.01, 1620.00, 195.00, 179.00, 374.00),
(83, 1620.01, 1640.00, 197.00, 181.00, 378.00),
(84, 1640.01, 1660.00, 200.00, 183.00, 383.00),
(85, 1660.01, 1680.00, 202.00, 185.00, 387.00),
(86, 1680.01, 1700.00, 204.00, 187.00, 391.00),
(87, 1700.01, 1720.00, 207.00, 190.00, 397.00),
(88, 1720.01, 1740.00, 209.00, 192.00, 401.00),
(89, 1740.01, 1760.00, 212.00, 194.00, 406.00),
(90, 1760.01, 1780.00, 214.00, 196.00, 410.00),
(91, 1780.01, 1800.00, 216.00, 198.00, 414.00),
(92, 1800.01, 1820.00, 219.00, 201.00, 420.00),
(93, 1820.01, 1840.00, 221.00, 203.00, 424.00),
(94, 1840.01, 1860.00, 224.00, 205.00, 429.00),
(95, 1860.01, 1880.00, 226.00, 207.00, 433.00),
(96, 1880.01, 1900.00, 228.00, 209.00, 437.00),
(97, 1900.01, 1920.00, 231.00, 212.00, 443.00),
(98, 1920.01, 1940.00, 233.00, 214.00, 447.00),
(99, 1940.01, 1960.00, 236.00, 216.00, 452.00),
(100, 1960.01, 1980.00, 238.00, 218.00, 456.00),
(101, 1980.01, 2000.00, 240.00, 220.00, 460.00),
(102, 2000.01, 2020.00, 243.00, 223.00, 466.00),
(103, 2020.01, 2040.00, 245.00, 225.00, 470.00),
(104, 2040.01, 2060.00, 248.00, 227.00, 475.00),
(105, 2060.01, 2080.00, 250.00, 229.00, 479.00),
(106, 2080.01, 2100.00, 252.00, 231.00, 483.00),
(107, 2100.01, 2120.00, 255.00, 234.00, 489.00),
(108, 2120.01, 2140.00, 257.00, 236.00, 493.00),
(109, 2140.01, 2160.00, 260.00, 238.00, 498.00),
(110, 2160.01, 2180.00, 262.00, 240.00, 502.00),
(111, 2180.01, 2200.00, 264.00, 242.00, 506.00),
(112, 2200.01, 2220.00, 267.00, 245.00, 512.00),
(113, 2220.01, 2240.00, 269.00, 247.00, 516.00),
(114, 2240.01, 2260.00, 272.00, 249.00, 521.00),
(115, 2260.01, 2280.00, 274.00, 251.00, 525.00),
(116, 2280.01, 2300.00, 276.00, 253.00, 529.00),
(117, 2300.01, 2320.00, 279.00, 256.00, 535.00),
(118, 2320.01, 2340.00, 281.00, 258.00, 539.00),
(119, 2340.01, 2360.00, 284.00, 260.00, 544.00),
(120, 2360.01, 2380.00, 286.00, 262.00, 548.00),
(121, 2380.01, 2400.00, 288.00, 264.00, 552.00),
(122, 2400.01, 2420.00, 291.00, 267.00, 558.00),
(123, 2420.01, 2440.00, 293.00, 269.00, 562.00),
(124, 2440.01, 2460.00, 296.00, 271.00, 567.00),
(125, 2460.01, 2480.00, 298.00, 273.00, 571.00),
(126, 2480.01, 2500.00, 300.00, 275.00, 575.00),
(127, 2500.01, 2520.00, 303.00, 278.00, 581.00),
(128, 2520.01, 2540.00, 305.00, 280.00, 585.00),
(129, 2540.01, 2560.00, 308.00, 282.00, 590.00),
(130, 2560.01, 2580.00, 310.00, 284.00, 594.00),
(131, 2580.01, 2600.00, 312.00, 286.00, 598.00),
(132, 2600.01, 2620.00, 315.00, 289.00, 604.00),
(133, 2620.01, 2640.00, 317.00, 291.00, 608.00),
(134, 2640.01, 2660.00, 320.00, 293.00, 613.00),
(135, 2660.01, 2680.00, 322.00, 295.00, 617.00),
(136, 2680.01, 2700.00, 324.00, 297.00, 621.00),
(137, 2700.01, 2720.00, 327.00, 300.00, 627.00),
(138, 2720.01, 2740.00, 329.00, 302.00, 631.00),
(139, 2740.01, 2760.00, 332.00, 304.00, 636.00),
(140, 2760.01, 2780.00, 334.00, 306.00, 640.00),
(141, 2780.01, 2800.00, 336.00, 308.00, 644.00),
(142, 2800.01, 2820.00, 339.00, 311.00, 650.00),
(143, 2820.01, 2840.00, 341.00, 313.00, 654.00),
(144, 2840.01, 2860.00, 344.00, 315.00, 659.00),
(145, 2860.01, 2880.00, 346.00, 317.00, 663.00),
(146, 2880.01, 2900.00, 348.00, 319.00, 667.00),
(147, 2900.01, 2920.00, 351.00, 322.00, 673.00),
(148, 2920.01, 2940.00, 353.00, 324.00, 677.00),
(149, 2940.01, 2960.00, 356.00, 326.00, 682.00),
(150, 2960.01, 2980.00, 358.00, 328.00, 686.00),
(151, 2980.01, 3000.00, 360.00, 330.00, 690.00),
(152, 3000.01, 3020.00, 363.00, 333.00, 696.00),
(153, 3020.01, 3040.00, 365.00, 335.00, 700.00),
(154, 3040.01, 3060.00, 368.00, 337.00, 705.00),
(155, 3060.01, 3080.00, 370.00, 339.00, 709.00),
(156, 3080.01, 3100.00, 372.00, 341.00, 713.00),
(157, 3100.01, 3120.00, 375.00, 344.00, 719.00),
(158, 3120.01, 3140.00, 377.00, 346.00, 723.00),
(159, 3140.01, 3160.00, 380.00, 348.00, 728.00),
(160, 3160.01, 3180.00, 382.00, 350.00, 732.00),
(161, 3180.01, 3200.00, 384.00, 352.00, 736.00),
(162, 3200.01, 3220.00, 387.00, 355.00, 742.00),
(163, 3220.01, 3240.00, 389.00, 357.00, 746.00),
(164, 3240.01, 3260.00, 392.00, 359.00, 751.00),
(165, 3260.01, 3280.00, 394.00, 361.00, 755.00),
(166, 3280.01, 3300.00, 396.00, 363.00, 759.00),
(167, 3300.01, 3320.00, 399.00, 366.00, 765.00),
(168, 3320.01, 3340.00, 401.00, 368.00, 769.00),
(169, 3340.01, 3360.00, 404.00, 370.00, 774.00),
(170, 3360.01, 3380.00, 406.00, 372.00, 778.00),
(171, 3380.01, 3400.00, 408.00, 374.00, 782.00),
(172, 3400.01, 3420.00, 411.00, 377.00, 788.00),
(173, 3420.01, 3440.00, 413.00, 379.00, 792.00),
(174, 3440.01, 3460.00, 416.00, 381.00, 797.00),
(175, 3460.01, 3480.00, 418.00, 383.00, 801.00),
(176, 3480.01, 3500.00, 420.00, 385.00, 805.00),
(177, 3500.01, 3520.00, 423.00, 388.00, 811.00),
(178, 3520.01, 3540.00, 425.00, 390.00, 815.00),
(179, 3540.01, 3560.00, 428.00, 392.00, 820.00),
(180, 3560.01, 3580.00, 430.00, 394.00, 824.00),
(181, 3580.01, 3600.00, 432.00, 396.00, 828.00),
(182, 3600.01, 3620.00, 435.00, 399.00, 834.00),
(183, 3620.01, 3640.00, 437.00, 401.00, 838.00),
(184, 3640.01, 3660.00, 440.00, 403.00, 843.00),
(185, 3660.01, 3680.00, 442.00, 405.00, 847.00),
(186, 3680.01, 3700.00, 444.00, 407.00, 851.00),
(187, 3700.01, 3720.00, 447.00, 410.00, 857.00),
(188, 3720.01, 3740.00, 449.00, 412.00, 861.00),
(189, 3740.01, 3760.00, 452.00, 414.00, 866.00),
(190, 3760.01, 3780.00, 454.00, 416.00, 870.00),
(191, 3780.01, 3800.00, 456.00, 418.00, 874.00),
(192, 3800.01, 3820.00, 459.00, 421.00, 880.00),
(193, 3820.01, 3840.00, 461.00, 423.00, 884.00),
(194, 3840.01, 3860.00, 464.00, 425.00, 889.00),
(195, 3860.01, 3880.00, 466.00, 427.00, 893.00),
(196, 3880.01, 3900.00, 468.00, 429.00, 897.00),
(197, 3900.01, 3920.00, 471.00, 432.00, 903.00),
(198, 3920.01, 3940.00, 473.00, 434.00, 907.00),
(199, 3940.01, 3960.00, 476.00, 436.00, 912.00),
(200, 3960.01, 3980.00, 478.00, 438.00, 916.00),
(201, 3980.01, 4000.00, 480.00, 440.00, 920.00),
(202, 4000.01, 4020.00, 483.00, 443.00, 926.00),
(203, 4020.01, 4040.00, 485.00, 445.00, 930.00),
(204, 4040.01, 4060.00, 488.00, 447.00, 935.00),
(205, 4060.01, 4080.00, 490.00, 449.00, 939.00),
(206, 4080.01, 4100.00, 492.00, 451.00, 943.00),
(207, 4100.01, 4120.00, 495.00, 454.00, 949.00),
(208, 4120.01, 4140.00, 497.00, 456.00, 953.00),
(209, 4140.01, 4160.00, 500.00, 458.00, 958.00),
(210, 4160.01, 4180.00, 502.00, 460.00, 962.00),
(211, 4180.01, 4200.00, 504.00, 462.00, 966.00),
(212, 4200.01, 4220.00, 507.00, 465.00, 972.00),
(213, 4220.01, 4240.00, 509.00, 467.00, 976.00),
(214, 4240.01, 4260.00, 512.00, 469.00, 981.00),
(215, 4260.01, 4280.00, 514.00, 471.00, 985.00),
(216, 4280.01, 4300.00, 516.00, 473.00, 989.00),
(217, 4300.01, 4320.00, 519.00, 476.00, 995.00),
(218, 4320.01, 4340.00, 521.00, 478.00, 999.00),
(219, 4340.01, 4360.00, 524.00, 480.00, 1004.00),
(220, 4360.01, 4380.00, 526.00, 482.00, 1008.00),
(221, 4380.01, 4400.00, 528.00, 484.00, 1012.00),
(222, 4400.01, 4420.00, 531.00, 487.00, 1018.00),
(223, 4420.01, 4440.00, 533.00, 489.00, 1022.00),
(224, 4440.01, 4460.00, 536.00, 491.00, 1027.00),
(225, 4460.01, 4480.00, 538.00, 493.00, 1031.00),
(226, 4480.01, 4500.00, 540.00, 495.00, 1035.00),
(227, 4500.01, 4520.00, 543.00, 498.00, 1041.00),
(228, 4520.01, 4540.00, 545.00, 500.00, 1045.00),
(229, 4540.01, 4560.00, 548.00, 502.00, 1050.00),
(230, 4560.01, 4580.00, 550.00, 504.00, 1054.00),
(231, 4580.01, 4600.00, 552.00, 506.00, 1058.00),
(232, 4600.01, 4620.00, 555.00, 509.00, 1064.00),
(233, 4620.01, 4640.00, 557.00, 511.00, 1068.00),
(234, 4640.01, 4660.00, 560.00, 513.00, 1073.00),
(235, 4660.01, 4680.00, 562.00, 515.00, 1077.00),
(236, 4680.01, 4700.00, 564.00, 517.00, 1081.00),
(237, 4700.01, 4720.00, 567.00, 520.00, 1087.00),
(238, 4720.01, 4740.00, 569.00, 522.00, 1091.00),
(239, 4740.01, 4760.00, 572.00, 524.00, 1096.00),
(240, 4760.01, 4780.00, 574.00, 526.00, 1100.00),
(241, 4780.01, 4800.00, 576.00, 528.00, 1104.00),
(242, 4800.01, 4820.00, 579.00, 531.00, 1110.00),
(243, 4820.01, 4840.00, 581.00, 533.00, 1114.00),
(244, 4840.01, 4860.00, 584.00, 535.00, 1119.00),
(245, 4860.01, 4880.00, 586.00, 537.00, 1123.00),
(246, 4880.01, 4900.00, 588.00, 539.00, 1127.00),
(247, 4900.01, 4920.00, 591.00, 542.00, 1133.00),
(248, 4920.01, 4940.00, 593.00, 544.00, 1137.00),
(249, 4940.01, 4960.00, 596.00, 546.00, 1142.00),
(250, 4960.01, 4980.00, 598.00, 548.00, 1146.00),
(251, 4980.01, 5000.00, 600.00, 550.00, 1150.00),
(252, 5000.01, 5100.00, 612.00, 561.00, 1173.00),
(253, 5100.01, 5200.00, 624.00, 572.00, 1196.00),
(254, 5200.01, 5300.00, 636.00, 583.00, 1219.00),
(255, 5300.01, 5400.00, 648.00, 594.00, 1242.00),
(256, 5400.01, 5500.00, 660.00, 605.00, 1265.00),
(257, 5500.01, 5600.00, 672.00, 616.00, 1288.00),
(258, 5600.01, 5700.00, 684.00, 627.00, 1311.00),
(259, 5700.01, 5800.00, 696.00, 638.00, 1334.00),
(260, 5800.01, 5900.00, 708.00, 649.00, 1357.00),
(261, 5900.01, 6000.00, 720.00, 660.00, 1380.00),
(262, 6000.01, 6100.00, 732.00, 671.00, 1403.00),
(263, 6100.01, 6200.00, 744.00, 682.00, 1426.00),
(264, 6200.01, 6300.00, 756.00, 693.00, 1449.00),
(265, 6300.01, 6400.00, 768.00, 704.00, 1472.00),
(266, 6400.01, 6500.00, 780.00, 715.00, 1495.00),
(267, 6500.01, 6600.00, 792.00, 726.00, 1518.00),
(268, 6600.01, 6700.00, 804.00, 737.00, 1541.00),
(269, 6700.01, 6800.00, 816.00, 748.00, 1564.00),
(270, 6800.01, 6900.00, 828.00, 759.00, 1587.00),
(271, 6900.01, 7000.00, 840.00, 770.00, 1610.00),
(272, 7000.01, 7100.00, 852.00, 781.00, 1633.00),
(273, 7100.01, 7200.00, 864.00, 792.00, 1656.00),
(274, 7200.01, 7300.00, 876.00, 803.00, 1679.00),
(275, 7300.01, 7400.00, 888.00, 814.00, 1702.00),
(276, 7400.01, 7500.00, 900.00, 825.00, 1725.00),
(277, 7500.01, 7600.00, 912.00, 836.00, 1748.00),
(278, 7600.01, 7700.00, 924.00, 847.00, 1771.00),
(279, 7700.01, 7800.00, 936.00, 858.00, 1794.00),
(280, 7800.01, 7900.00, 948.00, 869.00, 1817.00),
(281, 7900.01, 8000.00, 960.00, 880.00, 1840.00),
(282, 8000.01, 8100.00, 972.00, 891.00, 1863.00),
(283, 8100.01, 8200.00, 984.00, 902.00, 1886.00),
(284, 8200.01, 8300.00, 996.00, 913.00, 1909.00),
(285, 8300.01, 8400.00, 1008.00, 924.00, 1932.00),
(286, 8400.01, 8500.00, 1020.00, 935.00, 1955.00),
(287, 8500.01, 8600.00, 1032.00, 946.00, 1978.00),
(288, 8600.01, 8700.00, 1044.00, 957.00, 2001.00),
(289, 8700.01, 8800.00, 1056.00, 968.00, 2024.00),
(290, 8800.01, 8900.00, 1068.00, 979.00, 2047.00),
(291, 8900.01, 9000.00, 1080.00, 990.00, 2070.00),
(292, 9000.01, 9100.00, 1092.00, 1001.00, 2093.00),
(293, 9100.01, 9200.00, 1104.00, 1012.00, 2116.00),
(294, 9200.01, 9300.00, 1116.00, 1023.00, 2139.00),
(295, 9300.01, 9400.00, 1128.00, 1034.00, 2162.00),
(296, 9400.01, 9500.00, 1140.00, 1045.00, 2185.00),
(297, 9500.01, 9600.00, 1152.00, 1056.00, 2208.00),
(298, 9600.01, 9700.00, 1164.00, 1067.00, 2231.00),
(299, 9700.01, 9800.00, 1176.00, 1078.00, 2254.00),
(300, 9800.01, 9900.00, 1188.00, 1089.00, 2277.00),
(301, 9900.01, 10000.00, 1200.00, 1100.00, 2300.00),
(302, 10000.01, 10100.00, 1212.00, 1111.00, 2323.00),
(303, 10100.01, 10200.00, 1224.00, 1122.00, 2346.00),
(304, 10200.01, 10300.00, 1236.00, 1133.00, 2369.00),
(305, 10300.01, 10400.00, 1248.00, 1144.00, 2392.00),
(306, 10400.01, 10500.00, 1260.00, 1155.00, 2415.00),
(307, 10500.01, 10600.00, 1272.00, 1166.00, 2438.00),
(308, 10600.01, 10700.00, 1284.00, 1177.00, 2461.00),
(309, 10700.01, 10800.00, 1296.00, 1188.00, 2484.00),
(310, 10800.01, 10900.00, 1308.00, 1199.00, 2507.00),
(311, 10900.01, 11000.00, 1320.00, 1210.00, 2530.00),
(312, 11000.01, 11100.00, 1332.00, 1221.00, 2553.00),
(313, 11100.01, 11200.00, 1344.00, 1232.00, 2576.00),
(314, 11200.01, 11300.00, 1356.00, 1243.00, 2599.00),
(315, 11300.01, 11400.00, 1368.00, 1254.00, 2622.00),
(316, 11400.01, 11500.00, 1380.00, 1265.00, 2645.00),
(317, 11500.01, 11600.00, 1392.00, 1276.00, 2668.00),
(318, 11600.01, 11700.00, 1404.00, 1287.00, 2691.00),
(319, 11700.01, 11800.00, 1416.00, 1298.00, 2714.00),
(320, 11800.01, 11900.00, 1428.00, 1309.00, 2737.00),
(321, 11900.01, 12000.00, 1440.00, 1320.00, 2760.00),
(322, 12000.01, 12100.00, 1452.00, 1331.00, 2783.00),
(323, 12100.01, 12200.00, 1464.00, 1342.00, 2806.00),
(324, 12200.01, 12300.00, 1476.00, 1353.00, 2829.00),
(325, 12300.01, 12400.00, 1488.00, 1364.00, 2852.00),
(326, 12400.01, 12500.00, 1500.00, 1375.00, 2875.00),
(327, 12500.01, 12600.00, 1512.00, 1386.00, 2898.00),
(328, 12600.01, 12700.00, 1524.00, 1397.00, 2921.00),
(329, 12700.01, 12800.00, 1536.00, 1408.00, 2944.00),
(330, 12800.01, 12900.00, 1548.00, 1419.00, 2967.00),
(331, 12900.01, 13000.00, 1560.00, 1430.00, 2990.00),
(332, 13000.01, 13100.00, 1572.00, 1441.00, 3013.00),
(333, 13100.01, 13200.00, 1584.00, 1452.00, 3036.00),
(334, 13200.01, 13300.00, 1596.00, 1463.00, 3059.00),
(335, 13300.01, 13400.00, 1608.00, 1474.00, 3082.00),
(336, 13400.01, 13500.00, 1620.00, 1485.00, 3105.00),
(337, 13500.01, 13600.00, 1632.00, 1496.00, 3128.00),
(338, 13600.01, 13700.00, 1644.00, 1507.00, 3151.00),
(339, 13700.01, 13800.00, 1656.00, 1518.00, 3174.00),
(340, 13800.01, 13900.00, 1668.00, 1529.00, 3197.00),
(341, 13900.01, 14000.00, 1680.00, 1540.00, 3220.00),
(342, 14000.01, 14100.00, 1692.00, 1551.00, 3243.00),
(343, 14100.01, 14200.00, 1704.00, 1562.00, 3266.00),
(344, 14200.01, 14300.00, 1716.00, 1573.00, 3289.00),
(345, 14300.01, 14400.00, 1728.00, 1584.00, 3312.00),
(346, 14400.01, 14500.00, 1740.00, 1595.00, 3335.00),
(347, 14500.01, 14600.00, 1752.00, 1606.00, 3358.00),
(348, 14600.01, 14700.00, 1764.00, 1617.00, 3381.00),
(349, 14700.01, 14800.00, 1776.00, 1628.00, 3404.00),
(350, 14800.01, 14900.00, 1788.00, 1639.00, 3427.00),
(351, 14900.01, 15000.00, 1800.00, 1650.00, 3450.00),
(352, 15000.01, 15100.00, 1812.00, 1661.00, 3473.00),
(353, 15100.01, 15200.00, 1824.00, 1672.00, 3496.00),
(354, 15200.01, 15300.00, 1836.00, 1683.00, 3519.00),
(355, 15300.01, 15400.00, 1848.00, 1694.00, 3542.00),
(356, 15400.01, 15500.00, 1860.00, 1705.00, 3565.00),
(357, 15500.01, 15600.00, 1872.00, 1716.00, 3588.00),
(358, 15600.01, 15700.00, 1884.00, 1727.00, 3611.00),
(359, 15700.01, 15800.00, 1896.00, 1738.00, 3634.00),
(360, 15800.01, 15900.00, 1908.00, 1749.00, 3657.00),
(361, 15900.01, 16000.00, 1920.00, 1760.00, 3680.00),
(362, 16000.01, 16100.00, 1932.00, 1771.00, 3703.00),
(363, 16100.01, 16200.00, 1944.00, 1782.00, 3726.00),
(364, 16200.01, 16300.00, 1956.00, 1793.00, 3749.00),
(365, 16300.01, 16400.00, 1968.00, 1804.00, 3772.00),
(366, 16400.01, 16500.00, 1980.00, 1815.00, 3795.00),
(367, 16500.01, 16600.00, 1992.00, 1826.00, 3818.00),
(368, 16600.01, 16700.00, 2004.00, 1837.00, 3841.00),
(369, 16700.01, 16800.00, 2016.00, 1848.00, 3864.00),
(370, 16800.01, 16900.00, 2028.00, 1859.00, 3887.00),
(371, 16900.01, 17000.00, 2040.00, 1870.00, 3910.00),
(372, 17000.01, 17100.00, 2052.00, 1881.00, 3933.00),
(373, 17100.01, 17200.00, 2064.00, 1892.00, 3956.00),
(374, 17200.01, 17300.00, 2076.00, 1903.00, 3979.00),
(375, 17300.01, 17400.00, 2088.00, 1914.00, 4002.00),
(376, 17400.01, 17500.00, 2100.00, 1925.00, 4025.00),
(377, 17500.01, 17600.00, 2112.00, 1936.00, 4048.00),
(378, 17600.01, 17700.00, 2124.00, 1947.00, 4071.00),
(379, 17700.01, 17800.00, 2136.00, 1958.00, 4094.00),
(380, 17800.01, 17900.00, 2148.00, 1969.00, 4117.00),
(381, 17900.01, 18000.00, 2160.00, 1980.00, 4140.00),
(382, 18000.01, 18100.00, 2172.00, 1991.00, 4163.00),
(383, 18100.01, 18200.00, 2184.00, 2002.00, 4186.00),
(384, 18200.01, 18300.00, 2196.00, 2013.00, 4209.00),
(385, 18300.01, 18400.00, 2208.00, 2024.00, 4232.00),
(386, 18400.01, 18500.00, 2220.00, 2035.00, 4255.00),
(387, 18500.01, 18600.00, 2232.00, 2046.00, 4278.00),
(388, 18600.01, 18700.00, 2244.00, 2057.00, 4301.00),
(389, 18700.01, 18800.00, 2256.00, 2068.00, 4324.00),
(390, 18800.01, 18900.00, 2268.00, 2079.00, 4347.00),
(391, 18900.01, 19000.00, 2280.00, 2090.00, 4370.00),
(392, 19000.01, 19100.00, 2292.00, 2101.00, 4393.00),
(393, 19100.01, 19200.00, 2304.00, 2112.00, 4416.00),
(394, 19200.01, 19300.00, 2316.00, 2123.00, 4439.00),
(395, 19300.01, 19400.00, 2328.00, 2134.00, 4462.00),
(396, 19400.01, 19500.00, 2340.00, 2145.00, 4485.00),
(397, 19500.01, 19600.00, 2352.00, 2156.00, 4508.00),
(398, 19600.01, 19700.00, 2364.00, 2167.00, 4531.00),
(399, 19700.01, 19800.00, 2376.00, 2178.00, 4554.00),
(400, 19800.01, 19900.00, 2388.00, 2189.00, 4577.00),
(401, 19900.01, 20000.00, 2400.00, 2200.00, 4600.00);

-- --------------------------------------------------------

--
-- Table structure for table `simit_simsalon_expenses`
--

CREATE TABLE IF NOT EXISTS `simit_simsalon_expenses` (
  `expenses_id` int(11) NOT NULL auto_increment,
  `expenses_no` varchar(20) NOT NULL default '',
  `expenses_date` date NOT NULL default '0000-00-00',
  `iscomplete` char(1) NOT NULL,
  `expenses_remarks` text,
  `created` datetime NOT NULL default '0000-00-00 00:00:00',
  `createdby` int(11) NOT NULL default '0',
  `updated` datetime NOT NULL default '0000-00-00 00:00:00',
  `updatedby` int(11) NOT NULL default '0',
  `isactive` char(1) NOT NULL default '',
  `expenses_totalamount` decimal(12,2) default NULL,
  `expenseslist_id` int(11) NOT NULL default '0',
  `expenses_qty` int(11) NOT NULL default '0',
  `expenses_price` decimal(12,2) NOT NULL default '0.00',
  PRIMARY KEY  (`expenses_id`),
  UNIQUE KEY `expenses_no` (`expenses_no`),
  KEY `expenseslist_id` (`expenseslist_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `simit_simsalon_expenses`
--

INSERT INTO `simit_simsalon_expenses` (`expenses_id`, `expenses_no`, `expenses_date`, `iscomplete`, `expenses_remarks`, `created`, `createdby`, `updated`, `updatedby`, `isactive`, `expenses_totalamount`, `expenseslist_id`, `expenses_qty`, `expenses_price`) VALUES
(1, '1', '2008-10-29', 'N', '', '2008-10-29 16:42:40', 3, '2008-10-29 16:42:40', 3, 'Y', 100.00, 1, 1, 100.00);

-- --------------------------------------------------------

--
-- Table structure for table `simit_simsalon_expensescategory`
--

CREATE TABLE IF NOT EXISTS `simit_simsalon_expensescategory` (
  `category_id` int(11) NOT NULL auto_increment,
  `category_code` varchar(20) NOT NULL default '',
  `category_description` text NOT NULL,
  `isactive` char(1) NOT NULL default '',
  `organization_id` int(11) NOT NULL default '0',
  `created` datetime NOT NULL default '0000-00-00 00:00:00',
  `createdby` int(11) NOT NULL default '0',
  `updated` date NOT NULL default '0000-00-00',
  `updatedby` int(11) NOT NULL default '0',
  `isitem` char(1) NOT NULL default 'N',
  `remarks` text,
  PRIMARY KEY  (`category_id`),
  UNIQUE KEY `category_code` (`category_code`),
  KEY `organization_id` (`organization_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `simit_simsalon_expensescategory`
--

INSERT INTO `simit_simsalon_expensescategory` (`category_id`, `category_code`, `category_description`, `isactive`, `organization_id`, `created`, `createdby`, `updated`, `updatedby`, `isitem`, `remarks`) VALUES
(0, '0', '', 'Y', 0, '0000-00-00 00:00:00', 0, '0000-00-00', 0, 'N', NULL),
(1, '1', 'Bill', 'Y', 0, '2008-10-29 16:40:42', 3, '2008-10-29', 3, 'C', '');

-- --------------------------------------------------------

--
-- Table structure for table `simit_simsalon_expensesline`
--

CREATE TABLE IF NOT EXISTS `simit_simsalon_expensesline` (
  `expensesline_id` int(11) NOT NULL auto_increment,
  `expensesline_no` int(11) NOT NULL,
  `expenses_id` int(11) NOT NULL,
  `expenseslist_id` int(11) NOT NULL default '0',
  `expensesline_qty` int(11) default NULL,
  `expensesline_price` decimal(12,2) default NULL,
  `expensesline_amount` decimal(12,2) default '0.00',
  `expensesline_remarks` text,
  PRIMARY KEY  (`expensesline_id`),
  KEY `expenses_id` (`expenses_id`),
  KEY `expenseslist_id` (`expenseslist_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `simit_simsalon_expensesline`
--


-- --------------------------------------------------------

--
-- Table structure for table `simit_simsalon_expenseslist`
--

CREATE TABLE IF NOT EXISTS `simit_simsalon_expenseslist` (
  `expenseslist_id` int(11) NOT NULL auto_increment,
  `expenseslist_no` varchar(20) NOT NULL default '',
  `expenseslist_name` varchar(50) NOT NULL default '',
  `description` varchar(50) NOT NULL default '',
  `category_id` int(11) NOT NULL default '0',
  `amt` decimal(10,2) NOT NULL default '0.00',
  `organization_id` int(11) NOT NULL default '0',
  `created` datetime NOT NULL default '0000-00-00 00:00:00',
  `createdby` int(11) NOT NULL default '0',
  `updated` datetime NOT NULL default '0000-00-00 00:00:00',
  `updatedby` int(11) NOT NULL default '0',
  `isactive` char(1) NOT NULL default '',
  `qty` int(11) NOT NULL default '0',
  `filename` varchar(50) NOT NULL default '',
  `remarks` text,
  `uom_id` int(11) NOT NULL default '0',
  PRIMARY KEY  (`expenseslist_id`),
  UNIQUE KEY `expenseslist_no` (`expenseslist_no`),
  KEY `category_id` (`category_id`),
  KEY `organization_id` (`organization_id`),
  KEY `uom_id` (`uom_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `simit_simsalon_expenseslist`
--

INSERT INTO `simit_simsalon_expenseslist` (`expenseslist_id`, `expenseslist_no`, `expenseslist_name`, `description`, `category_id`, `amt`, `organization_id`, `created`, `createdby`, `updated`, `updatedby`, `isactive`, `qty`, `filename`, `remarks`, `uom_id`) VALUES
(0, '0', '', '', 0, 0.00, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, 'Y', 0, '', NULL, 0),
(1, '1', 'Water Bill', '', 1, 100.00, 0, '2008-10-29 16:41:53', 3, '2008-10-29 16:41:53', 3, 'Y', 0, '', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `simit_simsalon_internal`
--

CREATE TABLE IF NOT EXISTS `simit_simsalon_internal` (
  `internal_id` int(11) NOT NULL auto_increment,
  `internal_no` varchar(20) NOT NULL default '',
  `internal_date` date NOT NULL default '0000-00-00',
  `internal_type` char(1) default NULL,
  `employee_id` int(11) NOT NULL default '0',
  `iscomplete` char(1) NOT NULL,
  `internal_remarks` text,
  `created` datetime NOT NULL default '0000-00-00 00:00:00',
  `createdby` int(11) NOT NULL default '0',
  `updated` datetime NOT NULL default '0000-00-00 00:00:00',
  `updatedby` int(11) NOT NULL default '0',
  `isactive` char(1) NOT NULL default '',
  PRIMARY KEY  (`internal_id`,`internal_no`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `simit_simsalon_internal`
--

INSERT INTO `simit_simsalon_internal` (`internal_id`, `internal_no`, `internal_date`, `internal_type`, `employee_id`, `iscomplete`, `internal_remarks`, `created`, `createdby`, `updated`, `updatedby`, `isactive`) VALUES
(2, '1', '2008-10-29', 'A', 2, 'N', '', '2008-10-29 16:34:11', 3, '2008-10-29 16:34:11', 3, 'Y'),
(4, '3', '2008-11-01', 'I', 0, 'Y', '', '2008-11-01 19:43:27', 3, '2008-11-01 19:44:00', 3, 'Y');

-- --------------------------------------------------------

--
-- Table structure for table `simit_simsalon_internalline`
--

CREATE TABLE IF NOT EXISTS `simit_simsalon_internalline` (
  `internalline_id` int(11) NOT NULL auto_increment,
  `internalline_no` int(11) NOT NULL,
  `internal_id` int(11) NOT NULL,
  `internalline_type` char(1) default NULL,
  `product_id` int(11) NOT NULL default '0',
  `internalline_qty` int(11) default NULL,
  `internalline_remarks` text,
  `employee_id` int(11) NOT NULL default '0',
  PRIMARY KEY  (`internalline_id`),
  KEY `internal_id` (`internal_id`),
  KEY `product_id` (`product_id`),
  KEY `employee_id` (`employee_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=63 ;

--
-- Dumping data for table `simit_simsalon_internalline`
--

INSERT INTO `simit_simsalon_internalline` (`internalline_id`, `internalline_no`, `internal_id`, `internalline_type`, `product_id`, `internalline_qty`, `internalline_remarks`, `employee_id`) VALUES
(5, 3, 2, NULL, 24, 0, NULL, 0),
(6, 4, 2, NULL, 53, 0, NULL, 0),
(16, 14, 2, NULL, 63, 0, NULL, 0),
(17, 15, 2, NULL, 64, 0, NULL, 0),
(18, 16, 2, NULL, 65, 0, NULL, 0),
(19, 17, 2, NULL, 66, 0, NULL, 0),
(20, 18, 2, NULL, 68, 0, NULL, 0),
(21, 19, 2, NULL, 69, 0, NULL, 0),
(22, 20, 2, NULL, 70, 0, NULL, 0),
(23, 21, 2, NULL, 71, 0, NULL, 0),
(24, 22, 2, NULL, 72, 0, NULL, 0),
(25, 23, 2, NULL, 73, 0, NULL, 0),
(26, 24, 2, NULL, 74, 0, NULL, 0),
(27, 25, 2, NULL, 75, 0, NULL, 0),
(28, 26, 2, NULL, 76, 0, NULL, 0),
(29, 27, 2, NULL, 77, 0, NULL, 0),
(30, 28, 2, NULL, 78, 0, NULL, 0),
(31, 29, 2, NULL, 79, 0, NULL, 0),
(32, 30, 2, NULL, 80, 0, NULL, 0),
(33, 31, 2, NULL, 81, 0, NULL, 0),
(34, 32, 2, NULL, 82, 0, NULL, 0),
(35, 33, 2, NULL, 83, 0, NULL, 0),
(36, 34, 2, NULL, 84, 0, NULL, 0),
(37, 35, 2, NULL, 85, 0, NULL, 0),
(38, 36, 2, NULL, 86, 0, NULL, 0),
(39, 37, 2, NULL, 87, 0, NULL, 0),
(40, 38, 2, NULL, 88, 0, NULL, 0),
(41, 39, 2, NULL, 89, 0, NULL, 0),
(42, 40, 2, NULL, 90, 0, NULL, 0),
(43, 41, 2, NULL, 91, 0, NULL, 0),
(44, 42, 2, NULL, 92, 0, NULL, 0),
(45, 43, 2, NULL, 93, 0, NULL, 0),
(46, 44, 2, NULL, 94, 0, NULL, 0),
(47, 45, 2, NULL, 96, 0, NULL, 0),
(48, 46, 2, NULL, 97, 0, NULL, 0),
(49, 47, 2, NULL, 98, 0, NULL, 0),
(50, 48, 2, NULL, 99, 0, NULL, 0),
(62, 1, 4, NULL, 0, 1, '', 5);

-- --------------------------------------------------------

--
-- Table structure for table `simit_simsalon_leave`
--

CREATE TABLE IF NOT EXISTS `simit_simsalon_leave` (
  `leave_id` int(11) NOT NULL auto_increment,
  `leave_code` varchar(20) NOT NULL default '',
  `leave_description` text NOT NULL,
  `isactive` char(1) NOT NULL default '',
  `organization_id` int(11) NOT NULL default '0',
  `created` datetime NOT NULL default '0000-00-00 00:00:00',
  `createdby` int(11) NOT NULL default '0',
  `updated` date NOT NULL default '0000-00-00',
  `updatedby` int(11) NOT NULL default '0',
  `remarks` text,
  PRIMARY KEY  (`leave_id`),
  UNIQUE KEY `leave_code` (`leave_code`),
  KEY `organization_id` (`organization_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `simit_simsalon_leave`
--

INSERT INTO `simit_simsalon_leave` (`leave_id`, `leave_code`, `leave_description`, `isactive`, `organization_id`, `created`, `createdby`, `updated`, `updatedby`, `remarks`) VALUES
(1, '1', 'Unpaid Leave', 'Y', 0, '2008-10-15 15:38:04', 1, '2008-10-15', 1, ''),
(2, '2', 'Sick Leave', 'Y', 0, '2008-10-15 15:38:18', 1, '2008-10-15', 1, ''),
(3, '3', 'Annual Leave', 'Y', 0, '2008-10-15 15:39:06', 1, '2008-10-15', 1, ''),
(4, '4', 'Emergency Leave', 'Y', 0, '2008-10-15 15:40:23', 1, '2008-10-15', 1, '');

-- --------------------------------------------------------

--
-- Table structure for table `simit_simsalon_leaveline`
--

CREATE TABLE IF NOT EXISTS `simit_simsalon_leaveline` (
  `leaveline_id` int(11) NOT NULL auto_increment,
  `leaveline_name` varchar(100) default NULL,
  `payroll_id` int(11) NOT NULL,
  `leaveline_qty` int(11) default NULL,
  `leaveline_amount` decimal(12,2) default '0.00',
  PRIMARY KEY  (`leaveline_id`),
  KEY `payroll_id` (`payroll_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `simit_simsalon_leaveline`
--

INSERT INTO `simit_simsalon_leaveline` (`leaveline_id`, `leaveline_name`, `payroll_id`, `leaveline_qty`, `leaveline_amount`) VALUES
(1, 'Unpaid Leave', 1, 0, 0.00),
(2, 'Sick Leave', 1, 0, 0.00),
(3, 'Annual Leave', 1, 0, 0.00),
(4, 'Emergency Leave', 1, 0, 0.00);

-- --------------------------------------------------------

--
-- Table structure for table `simit_simsalon_organization`
--

CREATE TABLE IF NOT EXISTS `simit_simsalon_organization` (
  `organization_id` int(11) NOT NULL auto_increment,
  `organization_name` varchar(50) NOT NULL default '',
  `tel_1` varchar(16) NOT NULL default '',
  `tel_2` varchar(16) NOT NULL default '',
  `fax` varchar(16) NOT NULL default '',
  `website` varchar(50) NOT NULL default '',
  `contactemail` varchar(30) NOT NULL default '',
  `created` datetime NOT NULL default '0000-00-00 00:00:00',
  `createdby` int(11) NOT NULL default '0',
  `updated` datetime NOT NULL default '0000-00-00 00:00:00',
  `updatedby` int(11) NOT NULL default '0',
  `isactive` char(1) NOT NULL default '',
  `organization_code` varchar(10) NOT NULL default '',
  `address_id` int(11) NOT NULL default '0',
  `groupid` smallint(5) NOT NULL default '0',
  `rob_no` varchar(14) NOT NULL default '',
  PRIMARY KEY  (`organization_id`),
  KEY `groupid` (`groupid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `simit_simsalon_organization`
--

INSERT INTO `simit_simsalon_organization` (`organization_id`, `organization_name`, `tel_1`, `tel_2`, `fax`, `website`, `contactemail`, `created`, `createdby`, `updated`, `updatedby`, `isactive`, `organization_code`, `address_id`, `groupid`, `rob_no`) VALUES
(0, 'Galaxy', '+607-8827107', '+6012-7131055', '', 'http://www.galaxyhairsalon.com', 'wecare@galaxyhairsalon.com', '0000-00-00 00:00:00', 0, '2008-08-21 17:47:31', 1, 'Y', 'GLX', 0, 1, '');

-- --------------------------------------------------------

--
-- Table structure for table `simit_simsalon_payroll`
--

CREATE TABLE IF NOT EXISTS `simit_simsalon_payroll` (
  `payroll_id` int(11) NOT NULL auto_increment,
  `payroll_no` varchar(20) NOT NULL default '',
  `employee_id` int(11) NOT NULL default '0',
  `payroll_date` date NOT NULL default '0000-00-00',
  `payroll_value_ot1` decimal(2,1) default '0.0',
  `payroll_value_ot2` decimal(2,1) default '0.0',
  `payroll_value_ot3` decimal(2,1) default '0.0',
  `payroll_value_ot4` decimal(2,1) default '0.0',
  `payroll_qty_ot1` decimal(6,2) NOT NULL default '0.00',
  `payroll_qty_ot2` decimal(6,2) NOT NULL default '0.00',
  `payroll_qty_ot3` decimal(6,2) NOT NULL default '0.00',
  `payroll_qty_ot4` decimal(6,2) NOT NULL default '0.00',
  `payroll_amt_ot1` decimal(12,2) NOT NULL default '0.00',
  `payroll_amt_ot2` decimal(12,2) NOT NULL default '0.00',
  `payroll_amt_ot3` decimal(12,2) NOT NULL default '0.00',
  `payroll_amt_ot4` decimal(12,2) NOT NULL default '0.00',
  `payroll_qty_ul` decimal(5,2) NOT NULL default '0.00',
  `payroll_qty_sl` decimal(5,2) NOT NULL default '0.00',
  `payroll_qty_al` decimal(5,2) NOT NULL default '0.00',
  `payroll_qty_el` decimal(5,2) NOT NULL default '0.00',
  `payroll_amt_ul` decimal(12,2) NOT NULL default '0.00',
  `payroll_amt_sl` decimal(12,2) NOT NULL default '0.00',
  `payroll_amt_al` decimal(12,2) NOT NULL default '0.00',
  `payroll_amt_el` decimal(12,2) NOT NULL default '0.00',
  `payroll_amt_comm` decimal(12,2) NOT NULL default '0.00',
  `payroll_amt_allowance1` decimal(12,2) NOT NULL default '0.00',
  `payroll_amt_allowance2` decimal(12,2) NOT NULL default '0.00',
  `payroll_amt_allowance3` decimal(12,2) NOT NULL default '0.00',
  `payroll_monthof` char(2) default '0',
  `payroll_yearof` int(11) default '0',
  `iscomplete` char(1) NOT NULL default '',
  `isactive` char(1) NOT NULL default '',
  `created` datetime NOT NULL default '0000-00-00 00:00:00',
  `createdby` int(11) NOT NULL default '0',
  `updated` date NOT NULL default '0000-00-00',
  `updatedby` int(11) NOT NULL default '0',
  `remarks` text,
  `payroll_totalamount` decimal(12,2) default '0.00',
  `payroll_socsoemployee` decimal(12,2) NOT NULL default '0.00',
  `payroll_socsoemployer` decimal(12,2) NOT NULL default '0.00',
  `payroll_epfemployee` decimal(12,2) NOT NULL default '0.00',
  `payroll_epfemployer` decimal(12,2) NOT NULL default '0.00',
  `payroll_epfbase` decimal(12,2) default '0.00',
  `payroll_socsobase` decimal(12,2) default '0.00',
  `payroll_remarks2` text,
  `payroll_basicsalary` decimal(12,2) default '0.00',
  `issocsoot` char(1) default 'N',
  `isepfot` char(1) default 'N',
  PRIMARY KEY  (`payroll_id`),
  UNIQUE KEY `payroll_no` (`payroll_no`),
  KEY `employee_id` (`employee_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `simit_simsalon_payroll`
--

INSERT INTO `simit_simsalon_payroll` (`payroll_id`, `payroll_no`, `employee_id`, `payroll_date`, `payroll_value_ot1`, `payroll_value_ot2`, `payroll_value_ot3`, `payroll_value_ot4`, `payroll_qty_ot1`, `payroll_qty_ot2`, `payroll_qty_ot3`, `payroll_qty_ot4`, `payroll_amt_ot1`, `payroll_amt_ot2`, `payroll_amt_ot3`, `payroll_amt_ot4`, `payroll_qty_ul`, `payroll_qty_sl`, `payroll_qty_al`, `payroll_qty_el`, `payroll_amt_ul`, `payroll_amt_sl`, `payroll_amt_al`, `payroll_amt_el`, `payroll_amt_comm`, `payroll_amt_allowance1`, `payroll_amt_allowance2`, `payroll_amt_allowance3`, `payroll_monthof`, `payroll_yearof`, `iscomplete`, `isactive`, `created`, `createdby`, `updated`, `updatedby`, `remarks`, `payroll_totalamount`, `payroll_socsoemployee`, `payroll_socsoemployer`, `payroll_epfemployee`, `payroll_epfemployer`, `payroll_epfbase`, `payroll_socsobase`, `payroll_remarks2`, `payroll_basicsalary`, `issocsoot`, `isepfot`) VALUES
(1, '1', 2, '2008-11-05', 1.0, 1.5, 2.0, 3.0, 2.00, 0.00, 0.00, 0.00, 20.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, '11', 2008, 'Y', 'Y', '2008-11-05 10:56:43', 3, '2008-11-05', 3, '', 1349.90, 6.25, 21.85, 143.00, 156.00, 1300.00, 1300.00, 'If you have any queries for the above payroll, please clarify with HR within 7 days after received this payslip', 1300.00, 'N', 'N');

-- --------------------------------------------------------

--
-- Table structure for table `simit_simsalon_productcategory`
--

CREATE TABLE IF NOT EXISTS `simit_simsalon_productcategory` (
  `category_id` int(11) NOT NULL auto_increment,
  `category_code` varchar(20) NOT NULL default '',
  `category_description` text NOT NULL,
  `isactive` char(1) NOT NULL default '',
  `organization_id` int(11) NOT NULL default '0',
  `created` datetime NOT NULL default '0000-00-00 00:00:00',
  `createdby` int(11) NOT NULL default '0',
  `updated` date NOT NULL default '0000-00-00',
  `updatedby` int(11) NOT NULL default '0',
  `isitem` char(1) NOT NULL default 'N',
  `remarks` text,
  `filename` varchar(50) default NULL,
  `isdefault` char(1) default 'N',
  `issales` char(1) default 'Y',
  PRIMARY KEY  (`category_id`),
  UNIQUE KEY `category_code` (`category_code`),
  KEY `organization_id` (`organization_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=30 ;

--
-- Dumping data for table `simit_simsalon_productcategory`
--

INSERT INTO `simit_simsalon_productcategory` (`category_id`, `category_code`, `category_description`, `isactive`, `organization_id`, `created`, `createdby`, `updated`, `updatedby`, `isitem`, `remarks`, `filename`, `isdefault`, `issales`) VALUES
(0, '0', '', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00', 0, 'N', NULL, NULL, 'N', 'Y'),
(1, '1', 'Coloring-Loreal', 'Y', 0, '2008-10-21 17:29:17', 3, '2008-10-21', 3, 'C', '', NULL, 'N', 'Y'),
(2, '2', 'Coloring-Diacolor/AHA', 'Y', 0, '2008-10-21 17:34:08', 3, '2008-10-21', 3, 'C', '', NULL, 'N', 'Y'),
(3, '3', 'Coloring-Artitaz', 'Y', 0, '2008-10-21 17:34:45', 3, '2008-10-21', 3, 'C', '', NULL, 'N', 'Y'),
(4, '4', 'Coloring-Highlight', 'Y', 0, '2008-10-21 17:35:52', 3, '2008-10-21', 3, 'C', '', NULL, 'N', 'Y'),
(5, '5', 'Loreal Product', 'Y', 0, '2008-10-21 18:24:12', 3, '2008-10-31', 3, 'N', '', NULL, 'N', 'Y'),
(6, '6', 'Expreme Product', 'Y', 0, '2008-10-21 18:25:01', 3, '2008-10-31', 3, 'N', '', NULL, 'N', 'Y'),
(7, '7', 'Rebonding-Normal', 'Y', 0, '2008-10-21 18:40:59', 3, '2008-10-21', 3, 'C', '', NULL, 'N', 'Y'),
(8, '8', 'Rebonding-Relaxer', 'Y', 0, '2008-10-21 18:41:54', 3, '2008-10-21', 3, 'C', '', NULL, 'N', 'Y'),
(9, '9', 'Perming-Digital', 'Y', 0, '2008-10-21 18:51:25', 3, '2008-10-21', 3, 'C', '', NULL, 'N', 'Y'),
(10, '10', 'Perming-Ionic (Machine)', 'Y', 0, '2008-10-21 18:52:28', 3, '2008-10-21', 3, 'C', '', NULL, 'N', 'Y'),
(11, '11', 'Perming-Z-ion', 'Y', 0, '2008-10-21 18:53:16', 3, '2008-10-21', 3, 'C', '', NULL, 'N', 'Y'),
(12, '12', 'Perming-Cold perm', 'Y', 0, '2008-10-21 18:54:27', 3, '2008-10-21', 3, 'C', '', NULL, 'N', 'Y'),
(13, '13', 'Perming-Cold perm (Box)', 'Y', 0, '2008-10-21 18:55:25', 3, '2008-10-21', 3, 'C', '', NULL, 'N', 'Y'),
(14, '14', 'Touchup Coloring Loreal', 'Y', 0, '2008-10-21 19:20:38', 3, '2008-10-21', 3, 'C', '', NULL, 'N', 'Y'),
(15, '15', 'Others Services', 'Y', 0, '2008-10-21 19:21:22', 3, '2008-10-21', 3, 'Y', '', NULL, 'N', 'Y'),
(16, '16', 'Touchup Rebonding Relaxer', 'Y', 0, '2008-10-21 19:24:24', 3, '2008-10-21', 3, 'C', '', NULL, 'N', 'Y'),
(17, '17', 'Touchup Rebonding Normal', 'Y', 0, '2008-10-21 19:24:43', 3, '2008-10-21', 3, 'C', '', NULL, 'N', 'Y'),
(18, '18', 'Touchup Coloring Artitaz', 'Y', 0, '2008-10-21 19:25:35', 3, '2008-10-21', 3, 'C', '', NULL, 'N', 'Y'),
(19, '19', 'Consumable', 'Y', 0, '2008-10-23 18:56:46', 3, '2008-10-23', 3, 'N', '', NULL, 'N', 'Y'),
(20, '20', 'Artitaz', 'Y', 0, '2008-10-28 11:50:18', 3, '2008-10-28', 3, 'N', '', NULL, 'N', 'Y'),
(21, '21', 'Wash(Blow)', 'Y', 0, '2008-10-29 16:05:29', 3, '2008-10-29', 3, 'C', '', NULL, 'N', 'Y'),
(25, '22', 'Hair Cut', 'Y', 0, '2008-10-29 16:20:18', 3, '2008-10-29', 3, 'C', '', NULL, 'N', 'Y'),
(26, '23', 'Wash (Iron/set)', 'Y', 0, '2008-10-29 16:56:54', 3, '2008-10-29', 3, 'C', '', NULL, 'N', 'Y'),
(27, '24', 'Iron/set', 'Y', 0, '2008-10-29 16:57:54', 3, '2008-10-29', 3, 'C', '', NULL, 'N', 'Y'),
(28, '25', 'Wash+Stiming', 'Y', 0, '2008-10-29 16:59:08', 3, '2008-10-29', 3, 'C', '', NULL, 'N', 'Y'),
(29, '26', 'Treatment', 'Y', 0, '2008-10-29 18:34:38', 3, '2008-10-29', 3, 'C', '', NULL, 'N', 'Y');

-- --------------------------------------------------------

--
-- Table structure for table `simit_simsalon_productlist`
--

CREATE TABLE IF NOT EXISTS `simit_simsalon_productlist` (
  `product_id` int(11) NOT NULL auto_increment,
  `product_no` varchar(20) NOT NULL default '',
  `product_name` varchar(50) NOT NULL default '',
  `description` varchar(50) NOT NULL default '',
  `category_id` int(11) NOT NULL default '0',
  `amt` decimal(10,2) NOT NULL default '0.00',
  `lastpurchasecost` decimal(10,2) default '0.00',
  `sellingprice` decimal(10,2) NOT NULL default '0.00',
  `organization_id` int(11) NOT NULL default '0',
  `created` datetime NOT NULL default '0000-00-00 00:00:00',
  `createdby` int(11) NOT NULL default '0',
  `updated` datetime NOT NULL default '0000-00-00 00:00:00',
  `updatedby` int(11) NOT NULL default '0',
  `isactive` char(1) NOT NULL default '',
  `qty` int(11) NOT NULL default '0',
  `filename` varchar(50) NOT NULL default '',
  `remarks` text,
  `uom_id` int(11) default '0',
  `safety_level` int(11) default '0',
  `isdefault` char(1) default 'N',
  `issales` char(1) default 'Y',
  PRIMARY KEY  (`product_id`),
  UNIQUE KEY `product_no` (`product_no`),
  KEY `category_id` (`category_id`),
  KEY `organization_id` (`organization_id`),
  KEY `uom_id` (`uom_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=213 ;

--
-- Dumping data for table `simit_simsalon_productlist`
--

INSERT INTO `simit_simsalon_productlist` (`product_id`, `product_no`, `product_name`, `description`, `category_id`, `amt`, `lastpurchasecost`, `sellingprice`, `organization_id`, `created`, `createdby`, `updated`, `updatedby`, `isactive`, `qty`, `filename`, `remarks`, `uom_id`, `safety_level`, `isdefault`, `issales`) VALUES
(0, '0', '', '0', 0, 0.00, 0.00, 0.00, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, 'Y', 0, '', NULL, NULL, 0, 'Y', 'Y'),
(2, '2', 'Coloring-Loreal Middle (90-135)', '', 1, 0.00, 0.00, 90.00, 0, '2008-10-21 17:45:31', 3, '2008-10-21 17:45:31', 3, 'Y', 0, '', '', 3, 0, 'N', 'Y'),
(3, '3', 'Coloring-Loreal Long (140-165)', '', 1, 0.00, 0.00, 140.00, 0, '2008-10-21 17:46:38', 3, '2008-10-21 17:46:38', 3, 'Y', 0, '', '', 3, 0, 'N', 'Y'),
(4, '4', 'Coloring-Loreal EX Long (170-230)', '', 1, 0.00, 0.00, 170.00, 0, '2008-10-21 17:48:15', 3, '2008-10-21 17:48:15', 3, 'Y', 0, '', '', 3, 0, 'N', 'Y'),
(5, '5', 'Coloring-Diacolor/AHA Short (50-75)', '', 2, 0.00, 0.00, 50.00, 0, '2008-10-21 17:50:25', 3, '2008-10-21 17:50:25', 3, 'Y', 0, '', '', 3, 0, 'N', 'Y'),
(6, '6', 'Coloring-Diacolor/AHA Middle (80-125)', '', 2, 0.00, 0.00, 80.00, 0, '2008-10-21 17:52:21', 3, '2008-10-21 17:52:21', 3, 'Y', 0, '', '', 3, 0, 'N', 'Y'),
(7, '7', 'Coloring-Diacolor/AHA Long (125-145)', '', 2, 0.00, 0.00, 125.00, 0, '2008-10-21 17:53:43', 3, '2008-10-21 17:53:43', 3, 'Y', 0, '', '', 3, 0, 'N', 'Y'),
(8, '8', 'Coloring-Diacolor/AHA EX Long(150-205)', '', 2, 0.00, 0.00, 150.00, 0, '2008-10-21 17:54:47', 3, '2008-10-21 17:54:47', 3, 'Y', 0, '', '', 3, 0, 'N', 'Y'),
(9, '9', 'Coloring-Artitaz Short (40-65)', '', 3, 0.00, 0.00, 40.00, 0, '2008-10-21 17:57:01', 3, '2008-10-21 17:57:01', 3, 'Y', 0, '', '', 3, 0, 'N', 'Y'),
(10, '10', 'Coloring-Artitaz Middle (65-110)', '', 3, 0.00, 0.00, 65.00, 0, '2008-10-21 17:58:08', 3, '2008-10-21 17:58:08', 3, 'Y', 0, '', '', 3, 0, 'N', 'Y'),
(11, '11', 'Coloring-Artitaz Long (110-145)', '', 3, 0.00, 0.00, 110.00, 0, '2008-10-21 17:59:02', 3, '2008-10-21 17:59:02', 3, 'Y', 0, '', '', 3, 0, 'N', 'Y'),
(12, '12', 'Coloring-Artitaz EX Long (150-200)', '', 3, 0.00, 0.00, 150.00, 0, '2008-10-21 18:00:01', 3, '2008-10-21 18:00:01', 3, 'Y', 0, '', '', 3, 0, 'N', 'Y'),
(13, '13', 'Coloring-Loreal 2D (+15%)', '', 1, 0.00, 0.00, 0.00, 0, '2008-10-21 18:08:10', 3, '2008-10-21 18:08:10', 3, 'Y', 0, '', '', 3, 0, 'N', 'Y'),
(14, '14', 'Coloring-Loreal 3D (+30%)', '', 1, 0.00, 0.00, 0.00, 0, '2008-10-21 18:09:03', 3, '2008-10-21 18:09:03', 3, 'Y', 0, '', '', 3, 0, 'N', 'Y'),
(15, '15', 'Coloring-Artitaz 2D (+15%)', '', 3, 0.00, 0.00, 0.00, 0, '2008-10-21 18:10:15', 3, '2008-10-21 18:10:15', 3, 'Y', 0, '', '', 3, 0, 'N', 'Y'),
(16, '16', 'Coloring-Artitaz 3D (+30%)', '', 3, 0.00, 0.00, 0.00, 0, '2008-10-21 18:10:55', 3, '2008-10-21 18:10:55', 3, 'Y', 0, '', '', 3, 0, 'N', 'Y'),
(17, '17', 'Coloring-Highlight Short (55)', '', 4, 0.00, 0.00, 55.00, 0, '2008-10-21 18:13:38', 3, '2008-10-21 18:13:38', 3, 'Y', 0, '', '', 3, 0, 'N', 'Y'),
(18, '18', 'Coloring-Highlight Middle (75)', '', 4, 0.00, 0.00, 75.00, 0, '2008-10-21 18:14:39', 3, '2008-10-21 18:14:39', 3, 'Y', 0, '', '', 3, 0, 'N', 'Y'),
(19, '19', 'Coloring-Highlight Long (105)', '', 4, 0.00, 0.00, 105.00, 0, '2008-10-21 18:16:14', 3, '2008-10-21 18:16:14', 3, 'Y', 0, '', '', 3, 0, 'N', 'Y'),
(20, '20', 'Coloring-Highlight EX Long (145)', '', 4, 0.00, 0.00, 145.00, 0, '2008-10-21 18:17:57', 3, '2008-10-21 18:17:57', 3, 'Y', 0, '', '', 3, 0, 'N', 'Y'),
(21, '21', 'Coloring-Highlight (Piece) Long', '', 4, 0.00, 0.00, 8.00, 0, '2008-10-21 18:21:01', 3, '2008-11-04 18:30:43', 3, 'Y', 0, '', '', 1, 0, 'N', 'Y'),
(24, '24', 'Expreme Revitalizing Conditioner 350ml', '', 6, 0.00, 0.00, 28.00, 0, '2008-10-21 18:35:29', 3, '2008-10-21 18:35:29', 3, 'Y', 0, '', '', 4, 0, 'N', 'Y'),
(25, '25', 'Rebonding Short', '', 7, 0.00, 0.00, 99.00, 0, '2008-10-21 18:43:49', 3, '2008-10-21 18:43:49', 3, 'Y', 0, '', '', 3, 0, 'N', 'Y'),
(26, '26', 'Rebonding Middle', '', 7, 0.00, 0.00, 149.00, 0, '2008-10-21 18:44:41', 3, '2008-10-21 18:44:41', 3, 'Y', 0, '', '', 3, 0, 'N', 'Y'),
(27, '27', 'Rebonding Long', '', 7, 0.00, 0.00, 189.00, 0, '2008-10-21 18:45:20', 3, '2008-10-21 18:45:20', 3, 'Y', 0, '', '', 3, 0, 'N', 'Y'),
(28, '28', 'Rebonding Ex Long', '', 7, 0.00, 0.00, 249.00, 0, '2008-10-21 18:46:08', 3, '2008-10-21 18:46:08', 3, 'Y', 0, '', '', 3, 0, 'N', 'Y'),
(29, '29', 'Rebonding Relaxer Short', '', 8, 0.00, 0.00, 159.00, 0, '2008-10-21 18:47:10', 3, '2008-10-21 18:47:10', 3, 'Y', 0, '', '', 3, 0, 'N', 'Y'),
(30, '30', 'Rebonding Relaxer Middle', '', 8, 0.00, 0.00, 219.00, 0, '2008-10-21 18:47:51', 3, '2008-10-21 18:47:51', 3, 'Y', 0, '', '', 3, 0, 'N', 'Y'),
(31, '31', 'Rebonding Relaxer Long', '', 8, 0.00, 0.00, 259.00, 0, '2008-10-21 18:48:40', 3, '2008-10-21 18:48:40', 3, 'Y', 0, '', '', 3, 0, 'N', 'Y'),
(32, '32', 'Rebonding Relaxer Ex Long', '', 8, 0.00, 0.00, 309.00, 0, '2008-10-21 18:49:38', 3, '2008-10-21 18:49:38', 3, 'Y', 0, '', '', 3, 0, 'N', 'Y'),
(33, '33', 'Perming Digital Short', '', 9, 0.00, 0.00, 189.00, 0, '2008-10-21 18:56:59', 3, '2008-10-21 18:56:59', 3, 'Y', 0, '', '', 3, 0, 'N', 'Y'),
(34, '34', 'Perming Digital Middle', '', 9, 0.00, 0.00, 229.00, 0, '2008-10-21 18:57:45', 3, '2008-10-21 18:57:45', 3, 'Y', 0, '', '', 3, 0, 'N', 'Y'),
(35, '35', 'Perming Digital Long', '', 9, 0.00, 0.00, 259.00, 0, '2008-10-21 18:58:16', 3, '2008-10-21 18:58:16', 3, 'Y', 0, '', '', 3, 0, 'N', 'Y'),
(36, '36', 'Perming Digital Ex Long', '', 9, 0.00, 0.00, 289.00, 0, '2008-10-21 18:58:53', 3, '2008-10-21 18:58:53', 3, 'Y', 0, '', '', 3, 0, 'N', 'Y'),
(37, '37', 'Perming Ionic(Mc) Short', '', 10, 0.00, 0.00, 149.00, 0, '2008-10-21 19:00:16', 3, '2008-10-21 19:00:16', 3, 'Y', 0, '', '', 3, 0, 'N', 'Y'),
(38, '38', 'Perming Ionic(Mc) Middle', '', 10, 0.00, 0.00, 199.00, 0, '2008-10-21 19:00:49', 3, '2008-10-21 19:00:49', 3, 'Y', 0, '', '', 3, 0, 'N', 'Y'),
(39, '39', 'Perming Ionic(Mc) Long', '', 10, 0.00, 0.00, 239.00, 0, '2008-10-21 19:01:32', 3, '2008-10-21 19:01:32', 3, 'Y', 0, '', '', 3, 0, 'N', 'Y'),
(40, '40', 'Perming Ionic(Mc) Ex Long', '', 10, 0.00, 0.00, 269.00, 0, '2008-10-21 19:03:11', 3, '2008-10-21 19:03:11', 3, 'Y', 0, '', '', 3, 0, 'N', 'Y'),
(41, '41', 'Perming ZIon Short', '', 11, 0.00, 0.00, 79.00, 0, '2008-10-21 19:06:08', 3, '2008-10-21 19:06:08', 3, 'Y', 0, '', '', 3, 0, 'N', 'Y'),
(42, '42', 'Perming ZIon Middle', '', 11, 0.00, 0.00, 109.00, 0, '2008-10-21 19:07:14', 3, '2008-10-21 19:07:14', 3, 'Y', 0, '', '', 3, 0, 'N', 'Y'),
(43, '43', 'Perming ZIon Long', '', 11, 0.00, 0.00, 139.00, 0, '2008-10-21 19:08:05', 3, '2008-10-21 19:08:05', 3, 'Y', 0, '', '', 3, 0, 'N', 'Y'),
(44, '44', 'Perming ZIon Ex Long', '', 11, 0.00, 0.00, 169.00, 0, '2008-10-21 19:09:26', 3, '2008-10-21 19:09:26', 3, 'Y', 0, '', '', 3, 0, 'N', 'Y'),
(45, '45', 'Perming Cold perm Short', '', 12, 0.00, 0.00, 45.00, 0, '2008-10-21 19:10:57', 3, '2008-10-21 19:10:57', 3, 'Y', 0, '', '', 3, 0, 'N', 'Y'),
(46, '46', 'Perming Cold perm Middle', '', 12, 0.00, 0.00, 65.00, 0, '2008-10-21 19:11:39', 3, '2008-10-21 19:11:39', 3, 'Y', 0, '', '', 3, 0, 'N', 'Y'),
(47, '47', 'Perming Cold perm Long', '', 12, 0.00, 0.00, 85.00, 0, '2008-10-21 19:12:19', 3, '2008-10-21 19:12:19', 3, 'Y', 0, '', '', 3, 0, 'N', 'Y'),
(48, '48', 'Perming Cold perm Ex Long', '', 12, 0.00, 0.00, 105.00, 0, '2008-10-21 19:13:02', 3, '2008-10-21 19:13:02', 3, 'Y', 0, '', '', 3, 0, 'N', 'Y'),
(49, '49', 'Perming Cold perm (box) Short', '', 13, 0.00, 0.00, 60.00, 0, '2008-10-21 19:13:53', 3, '2008-10-21 19:13:53', 3, 'Y', 0, '', '', 3, 0, 'N', 'Y'),
(50, '50', 'Perming Cold perm (box) Middle', '', 13, 0.00, 0.00, 80.00, 0, '2008-10-21 19:14:54', 3, '2008-10-21 19:14:54', 3, 'Y', 0, '', '', 3, 0, 'N', 'Y'),
(51, '51', 'Perming Cold perm (box) Long', '', 13, 0.00, 0.00, 100.00, 0, '2008-10-21 19:17:03', 3, '2008-10-21 19:17:03', 3, 'Y', 0, '', '', 3, 0, 'N', 'Y'),
(52, '52', 'Perming Cold perm (box) Ex Long', '', 13, 0.00, 0.00, 120.00, 0, '2008-10-21 19:18:07', 3, '2008-10-21 19:18:07', 3, 'Y', 0, '', '', 3, 0, 'N', 'Y'),
(53, '53', 'Black Glove', '', 19, 14.00, 28.00, 0.00, 0, '2008-10-23 19:00:02', 3, '2008-10-23 19:00:23', 3, 'Y', 0, '', '', 5, 2, 'N', 'Y'),
(63, '63', 'AA Bio Perm', '', 20, 28.00, 28.00, 0.00, 0, '2008-10-28 11:54:34', 3, '2008-10-28 11:54:34', 3, 'Y', 0, '', '', 5, 3, 'N', 'Y'),
(64, '64', 'AA Colour', '', 20, 26.00, 26.00, 0.00, 0, '2008-10-28 11:55:38', 3, '2008-10-28 11:55:38', 3, 'Y', 0, '', '', 1, 3, 'N', 'Y'),
(65, '65', 'AA Bleach Powder', '', 20, 68.00, 68.00, 0.00, 0, '2008-10-28 11:59:14', 3, '2008-10-28 11:59:14', 3, 'Y', 0, '', '', 4, 3, 'N', 'Y'),
(66, '66', 'AA Perm Lotion 1. 900ml', '', 20, 14.00, 14.00, 0.00, 0, '2008-10-28 12:01:46', 3, '2008-10-28 12:01:46', 3, 'Y', 0, '', '', 4, 2, 'N', 'Y'),
(67, '67', 'Loreal Vitamino Colour Shampoo 250ml', '', 5, 0.00, 0.00, 48.00, 0, '2008-10-28 12:20:50', 3, '2008-11-04 18:26:43', 3, 'Y', 0, '', '', 4, 3, 'N', 'Y'),
(68, '68', 'Loreal Vitamino Colour Shampoo 500ml', '', 5, 0.00, 0.00, 75.00, 0, '2008-10-28 12:22:57', 3, '2008-10-28 13:11:12', 3, 'Y', 0, '', '', 4, 3, 'N', 'Y'),
(69, '69', 'Loreal Vitamino Colour Conditional 150ml', '', 5, 0.00, 0.00, 45.00, 0, '2008-10-28 12:24:19', 3, '2008-10-28 13:11:40', 3, 'Y', 0, '', '', 4, 3, 'N', 'Y'),
(70, '70', 'Loreal Vitamino Colour Leave-in 150ml', '', 5, 0.00, 0.00, 50.00, 0, '2008-10-28 12:25:54', 3, '2008-10-28 13:11:57', 3, 'Y', 0, '', '', 4, 3, 'N', 'Y'),
(71, '71', 'Loreal Vitamino Colour Masque 200ml', '', 5, 0.00, 0.00, 64.00, 0, '2008-10-28 12:28:40', 3, '2008-10-28 13:12:25', 3, 'Y', 0, '', '', 4, 3, 'N', 'Y'),
(72, '72', 'Loreal Shine Wave Shampoo 250ml', '', 5, 0.00, 0.00, 48.00, 0, '2008-10-28 12:34:13', 3, '2008-10-28 13:14:59', 3, 'Y', 0, '', '', 4, 3, 'N', 'Y'),
(73, '73', 'Loreal Shine Wave Shampoo 500ml', '', 5, 0.00, 0.00, 75.00, 0, '2008-10-28 12:35:21', 3, '2008-10-28 13:32:48', 3, 'Y', 0, '', '', 4, 3, 'N', 'Y'),
(74, '74', 'Loreal Shine Wave Shampoo 200ml', '', 5, 0.00, 0.00, 64.00, 0, '2008-10-28 12:36:39', 3, '2008-10-28 13:33:15', 3, 'Y', 0, '', '', 4, 3, 'N', 'Y'),
(75, '75', 'Loreal Shine Wave Conditional 150ml', '', 5, 0.00, 0.00, 45.00, 0, '2008-10-28 12:38:05', 3, '2008-10-28 13:33:33', 3, 'Y', 0, '', '', 4, 3, 'N', 'Y'),
(76, '76', 'Loreal Shine Wave Lotion/Spray 150ml', '', 5, 0.00, 0.00, 64.00, 0, '2008-10-28 12:39:11', 3, '2008-10-28 13:33:55', 3, 'Y', 0, '', '', 4, 3, 'N', 'Y'),
(77, '77', 'Loreal Shine Wave Control Cream 150ml', '', 5, 0.00, 0.00, 50.00, 0, '2008-10-28 12:40:32', 3, '2008-10-28 13:34:35', 3, 'Y', 0, '', '', 4, 3, 'N', 'Y'),
(78, '78', 'Loreal Liss Ultime Shampoo 250ml', '', 5, 0.00, 0.00, 48.00, 0, '2008-10-28 12:42:39', 3, '2008-10-28 13:34:50', 3, 'Y', 0, '', '', 4, 3, 'N', 'Y'),
(79, '79', 'Loreal Liss Ultime Shampoo 500ml', '', 5, 0.00, 0.00, 75.00, 0, '2008-10-28 12:44:00', 3, '2008-10-28 13:35:04', 3, 'Y', 0, '', '', 4, 3, 'N', 'Y'),
(80, '80', 'Loreal Liss Ultime Masque 200ml', '', 5, 0.00, 0.00, 64.00, 0, '2008-10-28 12:44:56', 3, '2008-10-28 13:35:57', 3, 'Y', 0, '', '', 4, 3, 'N', 'Y'),
(81, '81', 'Loreal Liss Ultime Shine Perfecting 125ml', '', 5, 0.00, 0.00, 64.00, 0, '2008-10-28 12:46:23', 3, '2008-10-28 13:36:13', 3, 'Y', 0, '', '', 4, 3, 'N', 'Y'),
(82, '82', 'Loreal Liss Ultime Nuit 125ml', '', 5, 0.00, 0.00, 75.00, 0, '2008-10-28 12:47:24', 3, '2008-10-28 13:36:34', 3, 'Y', 0, '', '', 4, 3, 'N', 'Y'),
(83, '83', 'Loreal Absolut Repair Shampoo 250ml', '', 5, 0.00, 0.00, 48.00, 0, '2008-10-28 12:49:23', 3, '2008-10-28 13:36:55', 3, 'Y', 0, '', '', 4, 3, 'N', 'Y'),
(84, '84', 'Loreal Absolut Repair Shampoo 500ml', '', 5, 0.00, 0.00, 48.00, 0, '2008-10-28 12:51:24', 3, '2008-10-28 13:37:26', 3, 'Y', 0, '', '', 4, 3, 'N', 'Y'),
(85, '85', 'Loreal Absolut Repair Conditional 150ml', '', 5, 0.00, 0.00, 45.00, 0, '2008-10-28 12:52:46', 3, '2008-11-11 15:32:20', 3, 'Y', 0, '-', '', 4, 3, 'N', 'Y'),
(86, '86', 'Loreal Absolut Repair Masque 200ml', '', 5, 0.00, 0.00, 64.00, 0, '2008-10-28 12:54:41', 3, '2008-10-28 13:38:08', 3, 'Y', 0, '', '', 4, 3, 'N', 'Y'),
(87, '87', 'Loreal Absolut Repair Leave-in 150ml', '', 5, 0.00, 0.00, 50.00, 0, '2008-10-28 12:55:54', 3, '2008-10-28 13:38:21', 3, 'Y', 0, '', '', 4, 3, 'N', 'Y'),
(88, '88', 'Loreal Age Densiforce Shampoo 250ml', '', 5, 0.00, 0.00, 48.00, 0, '2008-10-28 12:57:49', 3, '2008-10-28 13:38:36', 3, 'Y', 0, '', '', 4, 3, 'N', 'Y'),
(89, '89', 'Loreal Age Densiforce Shampoo 500ml', '', 5, 0.00, 0.00, 75.00, 0, '2008-10-28 12:58:33', 3, '2008-10-28 13:38:51', 3, 'Y', 0, '', '', 4, 3, 'N', 'Y'),
(90, '90', 'Loreal Age Densiforce Masque 200ml', '', 5, 0.00, 0.00, 64.00, 0, '2008-10-28 12:59:29', 3, '2008-10-28 13:39:05', 3, 'Y', 0, '', '', 4, 3, 'N', 'Y'),
(91, '91', 'Loreal Sensi Balance Shampoo 250ml', '', 5, 0.00, 0.00, 48.00, 0, '2008-10-28 13:00:44', 3, '2008-10-28 13:39:17', 3, 'Y', 0, '', '', 4, 3, 'N', 'Y'),
(92, '92', 'Loreal Sensi Balance Shampoo 500ml', '', 5, 0.00, 0.00, 75.00, 0, '2008-10-28 13:01:29', 3, '2008-10-28 13:39:34', 3, 'Y', 0, '', '', 4, 3, 'N', 'Y'),
(93, '93', 'Loreal Sensi Hydra Lotion 125ml', '', 5, 0.00, 0.00, 64.00, 0, '2008-10-28 13:02:35', 3, '2008-10-28 13:39:56', 3, 'Y', 0, '', '', 4, 3, 'N', 'Y'),
(94, '94', 'Loreal Sensi Nutri-Massage Conditional 250ml', '', 5, 0.00, 0.00, 64.00, 0, '2008-10-28 13:04:29', 3, '2008-10-28 13:40:10', 3, 'Y', 0, '', '', 4, 3, 'N', 'Y'),
(96, '95', 'Loreal Instant Clear Shampoo 250ml', '', 5, 0.00, 0.00, 48.00, 0, '2008-10-28 13:43:36', 3, '2008-10-28 13:43:36', 3, 'Y', 0, '', '', 4, 3, 'N', 'Y'),
(97, '96', 'Loreal Instant Clear Shampoo 500ml', '', 5, 0.00, 0.00, 75.00, 0, '2008-10-28 13:44:28', 3, '2008-10-28 13:44:28', 3, 'Y', 0, '', '', 4, 3, 'N', 'Y'),
(98, '97', 'Loreal Pure Resource Shampoo 250ml', '', 5, 0.00, 0.00, 48.00, 0, '2008-10-28 13:45:45', 3, '2008-10-28 13:45:45', 3, 'Y', 0, '', '', 4, 3, 'N', 'Y'),
(99, '98', 'Loreal Pure Resource Shampoo 500ml', '', 5, 0.00, 0.00, 75.00, 0, '2008-10-28 13:46:26', 3, '2008-11-11 15:31:06', 3, 'Y', 0, '99.png', '', 4, 3, 'N', 'Y'),
(110, '109', 'Wash(Blow) Short', '', 21, 0.00, 0.00, 13.00, 0, '2008-10-29 16:14:37', 3, '2008-10-29 16:14:37', 3, 'Y', 0, '', '', 3, 0, 'N', 'Y'),
(111, '110', 'Wash(Blow) Middle', '', 21, 0.00, 0.00, 15.00, 0, '2008-10-29 16:15:45', 3, '2008-10-29 16:15:45', 3, 'Y', 0, '', '', 3, 0, 'N', 'Y'),
(112, '111', 'Wash(Blow) Long', '', 21, 0.00, 0.00, 17.00, 0, '2008-10-29 16:16:39', 3, '2008-10-29 16:16:39', 3, 'Y', 0, '', '', 3, 0, 'N', 'Y'),
(113, '112', 'Wash(Blow) Ex long', '', 21, 0.00, 0.00, 18.00, 0, '2008-10-29 16:17:12', 3, '2008-10-29 16:17:12', 3, 'Y', 0, '', '', 3, 0, 'N', 'Y'),
(114, '113', 'Hair Cut (Master) Child', '', 25, 0.00, 0.00, 10.00, 0, '2008-10-29 16:23:06', 3, '2008-10-29 18:40:09', 3, 'Y', 0, '', '', 3, 0, 'N', 'Y'),
(115, '114', 'Wash (Iron/set) Short', '', 26, 0.00, 0.00, 14.00, 0, '2008-10-29 17:04:08', 3, '2008-10-29 17:04:08', 3, 'Y', 0, '', '', 3, 0, 'N', 'Y'),
(116, '115', 'Wash (Iron/set) Middle', '', 26, 0.00, 0.00, 19.00, 0, '2008-10-29 17:04:55', 3, '2008-10-29 17:04:55', 3, 'Y', 0, '', '', 3, 0, 'N', 'Y'),
(117, '116', 'Wash (Iron/set) Long', '', 26, 0.00, 0.00, 21.00, 0, '2008-10-29 17:05:41', 3, '2008-10-29 17:05:41', 3, 'Y', 0, '', '', 3, 0, 'N', 'Y'),
(118, '117', 'Wash (Iron/set) Ex Long', '', 26, 0.00, 0.00, 28.00, 0, '2008-10-29 17:07:05', 3, '2008-10-29 17:07:05', 3, 'Y', 0, '', '', 3, 0, 'N', 'Y'),
(119, '118', ' Iron /set Short', '', 27, 0.00, 0.00, 10.00, 0, '2008-10-29 17:08:15', 3, '2008-10-29 17:08:15', 3, 'Y', 0, '', '', 3, 0, 'N', 'Y'),
(120, '119', 'Iron/set Middle', '', 27, 0.00, 0.00, 12.00, 0, '2008-10-29 17:09:03', 3, '2008-10-29 17:10:15', 3, 'Y', 0, '', '', 3, 0, 'N', 'Y'),
(121, '120', 'Iron/set Long', '', 27, 0.00, 0.00, 14.00, 0, '2008-10-29 17:12:10', 3, '2008-10-29 17:12:10', 3, 'Y', 0, '', '', 3, 0, 'N', 'Y'),
(122, '121', 'Iron/set Ex Long', '', 27, 0.00, 0.00, 18.00, 0, '2008-10-29 17:13:12', 3, '2008-10-29 17:13:12', 3, 'Y', 0, '', '', 3, 0, 'N', 'Y'),
(123, '122', 'Wash+Stiming Short', '', 28, 0.00, 0.00, 19.00, 0, '2008-10-29 17:14:33', 3, '2008-10-29 17:14:33', 3, 'Y', 0, '', '', 3, 0, 'N', 'Y'),
(124, '123', 'Wash+Stiming Middle', '', 28, 0.00, 0.00, 23.00, 0, '2008-10-29 17:15:20', 3, '2008-10-29 17:15:20', 3, 'Y', 0, '', '', 3, 0, 'N', 'Y'),
(125, '124', 'Wash+Stiming Long', '', 28, 0.00, 0.00, 28.00, 0, '2008-10-29 17:16:15', 3, '2008-10-29 17:16:15', 3, 'Y', 0, '', '', 3, 0, 'N', 'Y'),
(126, '125', 'Wash+Stiming Ex Long', '', 28, 0.00, 0.00, 30.00, 0, '2008-10-29 17:16:45', 3, '2008-10-29 17:16:45', 3, 'Y', 0, '', '', 3, 0, 'N', 'Y'),
(127, '126', 'Touchup Loreal Colour 1 Tenth', '', 14, 0.00, 0.00, 50.00, 0, '2008-10-29 17:46:12', 3, '2008-10-29 18:20:53', 3, 'Y', 0, '', '', 3, 0, 'N', 'Y'),
(128, '127', 'Touchup Loreal Colour 2 Tenth', '', 14, 0.00, 0.00, 55.00, 0, '2008-10-29 17:49:04', 3, '2008-10-29 18:21:31', 3, 'Y', 0, '', '', 3, 0, 'N', 'Y'),
(129, '128', 'Touchup Loreal Colour 3 Tenth', '', 14, 0.00, 0.00, 60.00, 0, '2008-10-29 17:49:34', 3, '2008-10-29 18:21:49', 3, 'Y', 0, '', '', 3, 0, 'N', 'Y'),
(130, '129', 'Touchup Loreal Colour 4 Tenth', '', 14, 0.00, 0.00, 65.00, 0, '2008-10-29 17:50:22', 3, '2008-10-29 18:22:08', 3, 'Y', 0, '', '', 3, 0, 'N', 'Y'),
(131, '130', 'Touchup Loreal Colour 5 Tenth', '', 14, 0.00, 0.00, 70.00, 0, '2008-10-29 17:50:51', 3, '2008-10-29 18:22:46', 3, 'Y', 0, '', '', 3, 0, 'N', 'Y'),
(132, '131', 'Touchup AA Colour 1 Tenth', '', 18, 0.00, 0.00, 40.00, 0, '2008-10-29 17:52:48', 3, '2008-10-29 18:17:29', 3, 'Y', 0, '', '', 3, 0, 'N', 'Y'),
(133, '132', 'Touchup AA Colour 2 Tenth', '', 18, 0.00, 0.00, 45.00, 0, '2008-10-29 17:54:02', 3, '2008-10-29 18:18:28', 3, 'Y', 0, '', '', 3, 0, 'N', 'Y'),
(134, '133', 'Touchup AA Colour 3 Tenth', '', 18, 0.00, 0.00, 50.00, 0, '2008-10-29 17:54:40', 3, '2008-10-29 18:19:35', 3, 'Y', 0, '', '', 3, 0, 'N', 'Y'),
(135, '134', 'Touchup AA Colour 4 Tenth', '', 18, 0.00, 0.00, 55.00, 0, '2008-10-29 17:55:08', 3, '2008-10-29 18:19:58', 3, 'Y', 0, '', '', 3, 0, 'N', 'Y'),
(136, '135', 'Touchup AA Colour 5 Tenth', '', 18, 0.00, 0.00, 60.00, 0, '2008-10-29 17:55:38', 3, '2008-10-29 18:20:17', 3, 'Y', 0, '', '', 3, 0, 'N', 'Y'),
(137, '136', 'Touchup Relaxer  1 Tenth', '', 16, 0.00, 0.00, 119.00, 0, '2008-10-29 18:15:13', 3, '2008-10-29 18:26:04', 3, 'Y', 0, '', '', 3, 0, 'N', 'Y'),
(138, '137', 'Touchup Relaxer  2 Tenth', '', 16, 0.00, 0.00, 129.00, 0, '2008-10-29 18:26:40', 3, '2008-10-29 18:26:40', 3, 'Y', 0, '', '', 3, 0, 'N', 'Y'),
(139, '138', 'Touchup Relaxer  3 Tenth', '', 16, 0.00, 0.00, 139.00, 0, '2008-10-29 18:27:07', 3, '2008-10-29 18:27:07', 3, 'Y', 0, '', '', 3, 0, 'N', 'Y'),
(140, '139', 'Touchup Relaxer  4 Tenth', '', 16, 0.00, 0.00, 149.00, 0, '2008-10-29 18:27:40', 3, '2008-10-29 18:27:40', 3, 'Y', 0, '', '', 3, 0, 'N', 'Y'),
(141, '140', 'Touchup Relaxer  5 Tenth', '', 16, 0.00, 0.00, 159.00, 0, '2008-10-29 18:28:25', 3, '2008-10-29 18:28:25', 3, 'Y', 0, '', '', 3, 0, 'N', 'Y'),
(142, '141', 'Touchup Rebonding Normal 1Tenth', '', 7, 0.00, 0.00, 99.00, 0, '2008-10-29 18:30:31', 3, '2008-10-29 18:30:31', 3, 'Y', 0, '', '', 3, 0, 'N', 'Y'),
(143, '142', 'Touchup Rebonding Normal 2 Tenth', '', 17, 0.00, 0.00, 109.00, 0, '2008-10-29 18:30:58', 3, '2008-10-29 18:30:58', 3, 'Y', 0, '', '', 3, 0, 'N', 'Y'),
(144, '143', 'Touchup Rebonding Normal 3 Tenth', '', 17, 0.00, 0.00, 119.00, 0, '2008-10-29 18:31:35', 3, '2008-10-29 18:31:35', 3, 'Y', 0, '', '', 3, 0, 'N', 'Y'),
(145, '144', 'Touchup Rebonding Normal 4 Tenth', '', 17, 0.00, 0.00, 129.00, 0, '2008-10-29 18:32:00', 3, '2008-10-29 18:32:00', 3, 'Y', 0, '', '', 3, 0, 'N', 'Y'),
(146, '145', 'Touchup Rebonding Normal 5 Tenth', '', 17, 0.00, 0.00, 139.00, 0, '2008-10-29 18:32:30', 3, '2008-10-29 18:32:30', 3, 'Y', 0, '', '', 3, 0, 'N', 'Y'),
(147, '146', 'Hair Cut (Master) Short', '', 25, 0.00, 0.00, 15.00, 0, '2008-10-29 18:35:59', 3, '2008-10-29 18:40:33', 3, 'Y', 0, '', '', 3, 0, 'N', 'Y'),
(148, '147', 'Hair Cut (Master) Long', '', 25, 0.00, 0.00, 20.00, 0, '2008-10-29 18:36:34', 3, '2008-10-29 18:40:52', 3, 'Y', 0, '', '', 3, 0, 'N', 'Y'),
(149, '148', 'Hair Cut (Stylist) Short', '', 25, 0.00, 0.00, 12.00, 0, '2008-10-29 18:37:51', 3, '2008-10-29 18:37:51', 3, 'Y', 0, '', '', 3, 0, 'N', 'Y'),
(150, '149', 'Hair Cut (Stylist) Long', '', 25, 0.00, 0.00, 15.00, 0, '2008-10-29 18:38:26', 3, '2008-10-29 18:38:26', 3, 'Y', 0, '', '', 3, 0, 'N', 'Y'),
(151, '150', 'Hair Cut (Stylist) Baby', '', 25, 0.00, 0.00, 4.00, 0, '2008-10-29 18:57:43', 3, '2008-10-29 18:57:43', 3, 'Y', 0, '', '', 3, 0, 'N', 'Y'),
(152, '151', 'Hair Cut (Stylist) Tadika', '', 25, 0.00, 0.00, 6.00, 0, '2008-10-29 18:58:29', 3, '2008-10-29 18:58:29', 3, 'Y', 0, '', '', 3, 0, 'N', 'Y'),
(153, '152', 'Hair Cut (Stylist) D.Rendah', '', 25, 0.00, 0.00, 7.00, 0, '2008-10-29 19:00:17', 3, '2008-10-29 19:00:17', 3, 'Y', 0, '', '', 3, 0, 'N', 'Y'),
(154, '153', 'Hair Cut (Stylist) Menengah-Short', '', 25, 0.00, 0.00, 10.00, 0, '2008-10-29 19:02:17', 3, '2008-10-29 19:02:17', 3, 'Y', 0, '', '', 3, 0, 'N', 'Y'),
(155, '154', 'Hair Cut (Stylist) Menengah-Long', '', 25, 0.00, 0.00, 12.00, 0, '2008-10-29 19:02:40', 3, '2008-10-29 19:02:40', 3, 'Y', 0, '', '', 3, 0, 'N', 'Y'),
(160, '159', 'Inner Logic', '', 29, 0.00, 0.00, 50.00, 0, '2008-10-31 12:31:47', 3, '2008-10-31 12:31:47', 3, 'Y', 0, '', '', 3, 0, 'N', 'Y'),
(161, '160', 'Powerdose', '', 29, 0.00, 0.00, 50.00, 0, '2008-10-31 12:34:03', 3, '2008-10-31 12:34:03', 3, 'Y', 0, '', '', 3, 0, 'N', 'Y'),
(162, '161', 'AA Colour Ampur', '', 29, 0.00, 0.00, 16.00, 0, '2008-10-31 12:35:31', 3, '2008-10-31 12:35:31', 3, 'Y', 0, '', '', 3, 0, 'N', 'Y'),
(163, '162', 'AA Blow Ampur', '', 29, 0.00, 0.00, 16.00, 0, '2008-10-31 12:36:28', 3, '2008-10-31 12:36:28', 3, 'Y', 0, '', '', 3, 0, 'N', 'Y'),
(164, '163', 'Loreal Masque', '', 29, 0.00, 0.00, 25.00, 0, '2008-10-31 12:38:00', 3, '2008-10-31 12:38:00', 3, 'Y', 0, '', '', 3, 0, 'N', 'Y'),
(165, '164', 'Renew C', '', 29, 0.00, 0.00, 35.00, 0, '2008-10-31 12:39:19', 3, '2008-10-31 12:39:19', 3, 'Y', 0, '', '', 3, 0, 'N', 'Y'),
(166, '165', 'Coloring-Loreal Short (60-85)', '', 1, 0.00, 0.00, 60.00, 0, '2008-10-31 12:42:24', 3, '2008-10-31 12:42:24', 3, 'Y', 0, '', '', 3, 0, 'N', 'Y'),
(167, '166', 'Softpeel + Sensipost', '', 29, 0.00, 0.00, 90.00, 0, '2008-10-31 12:47:29', 3, '2008-10-31 12:47:29', 3, 'Y', 0, '', '', 3, 0, 'N', 'Y'),
(168, '167', 'Softpeel + Power Clear', '', 29, 0.00, 0.00, 85.00, 0, '2008-10-31 12:48:27', 3, '2008-11-11 15:25:07', 3, 'Y', 0, '168.png', '', 3, 0, 'Y', 'Y'),
(169, '168', 'Hair Spa Treatment Short', '', 29, 0.00, 0.00, 69.00, 0, '2008-10-31 12:50:22', 3, '2008-10-31 12:50:22', 3, 'Y', 0, '', '', 3, 0, 'N', 'Y'),
(170, '169', 'Hair Spa Treatment Middle', '', 29, 0.00, 0.00, 79.00, 0, '2008-10-31 12:50:43', 3, '2008-10-31 12:50:43', 3, 'Y', 0, '', '', 3, 0, 'N', 'Y'),
(171, '170', 'Hair Spa Treatment Long', '', 29, 0.00, 0.00, 89.00, 0, '2008-10-31 12:51:09', 3, '2008-10-31 12:51:09', 3, 'Y', 0, '', '', 3, 0, 'N', 'Y'),
(172, '171', 'Hair Spa Treatment Ex Long', '', 29, 0.00, 0.00, 109.00, 0, '2008-10-31 12:51:40', 3, '2008-10-31 12:51:40', 3, 'Y', 0, '', '', 3, 0, 'N', 'Y'),
(173, '172', 'Hair Spa Ampur', '', 29, 0.00, 0.00, 0.00, 0, '2008-10-31 12:53:52', 3, '2008-10-31 12:53:52', 3, 'Y', 0, '', '', 3, 0, 'N', 'Y'),
(174, '173', 'Loreal Aminexil', '', 29, 0.00, 0.00, 16.00, 0, '2008-10-31 12:54:57', 3, '2008-10-31 12:54:57', 3, 'Y', 0, '', '', 3, 0, 'N', 'Y'),
(175, '174', 'Ineral optimal', '', 29, 0.00, 0.00, 38.00, 0, '2008-10-31 12:56:30', 3, '2008-10-31 12:56:30', 3, 'Y', 0, '', '', 3, 0, 'N', 'Y'),
(176, '175', 'P.dose-Power density', '', 29, 0.00, 0.00, 65.00, 0, '2008-10-31 12:58:32', 3, '2008-10-31 12:58:32', 3, 'Y', 0, '', '', 3, 0, 'N', 'Y'),
(177, '176', 'Power define', '', 29, 0.00, 0.00, 65.00, 0, '2008-10-31 12:59:46', 3, '2008-10-31 12:59:46', 3, 'Y', 0, '', '', 3, 0, 'N', 'Y'),
(179, '177', 'Loreal Density Advance Shampo 500ml', '', 5, 0.00, 0.00, 75.00, 0, '2008-10-31 13:25:39', 3, '2008-10-31 13:25:39', 3, 'Y', 0, '', '', 4, 3, 'N', 'Y'),
(180, '178', 'Loreal Density Advance Shampo 250ml', '', 5, 0.00, 0.00, 48.00, 0, '2008-10-31 13:26:12', 3, '2008-10-31 13:26:12', 3, 'Y', 0, '', '', 4, 3, 'N', 'Y'),
(181, '179', 'Loreal Lumino Contrast Shampoo 500ml', '', 5, 0.00, 0.00, 75.00, 0, '2008-10-31 13:26:49', 3, '2008-10-31 13:26:49', 3, 'Y', 0, '', '', 4, 3, 'N', 'Y'),
(182, '180', 'Loreal Lumino Contrast Shampoo 250ml', '', 5, 0.00, 0.00, 48.00, 0, '2008-10-31 13:27:10', 3, '2008-10-31 13:27:10', 3, 'Y', 0, '', '', 4, 3, 'N', 'Y'),
(183, '181', 'Loreal Lumino Contrast Masque 200ml', '', 5, 0.00, 0.00, 64.00, 0, '2008-10-31 13:28:49', 3, '2008-10-31 13:28:49', 3, 'Y', 0, '', '', 4, 3, 'N', 'Y'),
(184, '182', 'Loreal Lumino Contrast Serum 50ml', '', 5, 0.00, 0.00, 64.00, 0, '2008-10-31 13:29:26', 3, '2008-10-31 13:29:26', 3, 'Y', 0, '', '', 4, 3, 'N', 'Y'),
(185, '183', 'Loreal Lumi oil-1 Water 50ml', '', 5, 0.00, 0.00, 45.00, 0, '2008-10-31 14:08:59', 3, '2008-10-31 16:41:57', 3, 'Y', 0, '', '', 4, 3, 'N', 'Y'),
(186, '184', 'Loreal Lumi oil-2  Serum 50ml', '', 5, 0.00, 0.00, 45.00, 0, '2008-10-31 14:12:12', 3, '2008-10-31 16:42:26', 3, 'Y', 0, '', '', 4, 3, 'N', 'Y'),
(187, '185', 'Loreal Lumi oil-3 Gel 50ml', '', 5, 0.00, 0.00, 45.00, 0, '2008-10-31 14:16:13', 3, '2008-10-31 16:42:39', 3, 'Y', 0, '', '', 4, 3, 'N', 'Y'),
(188, '186', 'Loreal Play Ball Deviation Paste 100ml', '', 5, 0.00, 0.00, 50.00, 0, '2008-10-31 14:17:54', 3, '2008-10-31 16:42:58', 3, 'Y', 0, '', '', 4, 3, 'N', 'Y'),
(189, '187', 'Loreal Play Ball Motion Gelee 100ml', '', 5, 0.00, 0.00, 50.00, 0, '2008-10-31 14:21:51', 3, '2008-10-31 16:43:15', 3, 'Y', 0, '', '', 4, 3, 'N', 'Y'),
(190, '188', 'Loreal Play Ball Motion Beach Cream 100ml', '', 5, 0.00, 0.00, 50.00, 0, '2008-10-31 14:22:47', 3, '2008-10-31 16:43:34', 3, 'Y', 0, '', '', 4, 3, 'N', 'Y'),
(191, '189', 'Loreal Play Ball Density Material 100ml', '', 5, 0.00, 0.00, 50.00, 0, '2008-10-31 14:30:01', 3, '2008-10-31 16:44:00', 3, 'Y', 0, '', '', 4, 3, 'N', 'Y'),
(192, '190', 'Loreal Play Ball Extreme Honey 100ml', '', 5, 0.00, 0.00, 50.00, 0, '2008-10-31 14:30:56', 3, '2008-10-31 16:44:21', 3, 'Y', 0, '', '', 4, 3, 'N', 'Y'),
(193, '191', 'Loreal TNA Mousse Full Volume 250ml', '', 5, 0.00, 0.00, 40.00, 0, '2008-10-31 16:29:05', 3, '2008-10-31 16:44:34', 3, 'Y', 0, '', '', 4, 3, 'N', 'Y'),
(194, '192', 'Loreal TNA Aque Gloss 150ml', '', 5, 0.00, 0.00, 45.00, 0, '2008-10-31 16:30:09', 3, '2008-10-31 16:44:49', 3, 'Y', 0, '', '', 4, 3, 'N', 'Y'),
(195, '193', 'Loreal TNA Gloss Wax 50ml', '', 5, 0.00, 0.00, 45.00, 0, '2008-10-31 16:31:03', 3, '2008-10-31 16:45:24', 3, 'Y', 0, '', '', 4, 3, 'N', 'Y'),
(196, '194', 'Loreal TNA Antifrizz Aero(4) 250ml', '', 5, 0.00, 0.00, 40.00, 0, '2008-10-31 16:32:31', 3, '2008-10-31 16:45:50', 3, 'Y', 0, '', '', 4, 3, 'N', 'Y'),
(197, '195', 'Loreal TNA Air Fix Aero(5) 250ml', '', 5, 0.00, 0.00, 40.00, 0, '2008-10-31 16:34:32', 3, '2008-10-31 16:46:04', 3, 'Y', 0, '', '', 4, 3, 'N', 'Y'),
(198, '196', 'Loreal TNA Liss Control+ 50ml', '', 5, 0.00, 0.00, 50.00, 0, '2008-10-31 16:36:00', 3, '2008-10-31 16:46:19', 3, 'Y', 0, '', '', 4, 3, 'N', 'Y'),
(199, '197', 'Loreal TNA Liss Control  150ml', '', 5, 0.00, 0.00, 45.00, 0, '2008-10-31 16:37:21', 3, '2008-10-31 16:46:32', 3, 'Y', 0, '', '', 4, 3, 'N', 'Y'),
(200, '198', 'Loreal TNA Fix Max 200ml', '', 5, 0.00, 0.00, 40.00, 0, '2008-10-31 16:39:11', 3, '2008-10-31 16:46:47', 3, 'Y', 0, '', '', 4, 3, 'N', 'Y'),
(201, '199', 'Loreal TNA Fix Move 100ml', '', 5, 0.00, 0.00, 45.00, 0, '2008-10-31 16:39:59', 3, '2008-10-31 16:46:59', 3, 'Y', 0, '', '', 4, 3, 'N', 'Y'),
(202, '200', 'Loreal TNA Define Wax 75ml', '', 5, 0.00, 0.00, 50.00, 0, '2008-10-31 16:49:04', 3, '2008-10-31 16:49:04', 3, 'Y', 0, '', '', 4, 3, 'N', 'Y'),
(203, '201', 'Loreal TNA Crart Mud 50g', '', 5, 0.00, 0.00, 50.00, 0, '2008-10-31 17:17:42', 3, '2008-10-31 17:17:42', 3, 'Y', 0, '', '', 4, 3, 'N', 'Y'),
(204, '202', 'Loreal Elnett Laque 500ml', '', 5, 0.00, 0.00, 50.00, 0, '2008-10-31 17:18:42', 3, '2008-10-31 17:18:42', 3, 'Y', 0, '', '', 4, 3, 'N', 'Y'),
(205, '203', 'Loreal Hotstyle Constructor(Cream) 150ml', '', 5, 0.00, 0.00, 50.00, 0, '2008-10-31 17:20:12', 3, '2008-10-31 17:20:12', 3, 'Y', 0, '', '', 4, 3, 'N', 'Y'),
(206, '204', 'Loreal Hotstyle Iron Finish(Spray) 150ml', '', 5, 0.00, 0.00, 50.00, 0, '2008-10-31 18:14:16', 3, '2008-10-31 18:14:16', 3, 'Y', 0, '', '', 4, 3, 'N', 'Y'),
(207, '205', 'TNA a.head Clay 50ml', '', 5, 0.00, 0.00, 50.00, 0, '2008-10-31 18:18:05', 3, '2008-10-31 18:18:05', 3, 'Y', 0, '', '', 4, 3, 'N', 'Y'),
(208, '206', 'TNA a.head Glue 150ml', '', 5, 0.00, 0.00, 50.00, 0, '2008-10-31 18:19:32', 3, '2008-10-31 18:19:32', 3, 'Y', 0, '', '', 4, 3, 'N', 'Y'),
(209, '207', 'TNA a.head Web 150ml', '', 5, 0.00, 0.00, 50.00, 0, '2008-10-31 18:20:48', 3, '2008-10-31 18:20:48', 3, 'Y', 0, '', '', 4, 3, 'N', 'Y'),
(210, '208', 'TNA a.head Fever 200ml', '', 5, 0.00, 0.00, 50.00, 0, '2008-10-31 18:21:31', 3, '2008-10-31 18:21:31', 3, 'Y', 0, '', '', 4, 3, 'N', 'Y'),
(211, '209', 'TNA a.head Sprax 150ml', '', 5, 0.00, 0.00, 50.00, 0, '2008-10-31 18:22:21', 3, '2008-10-31 18:22:21', 3, 'Y', 0, '', '', 4, 3, 'N', 'Y'),
(212, '210', 'Coloring-Highlight (Piece) Short', '', 4, 0.00, 0.00, 6.00, 0, '2008-11-04 18:30:30', 3, '2008-11-04 18:30:30', 3, 'Y', 0, '', '', 3, 0, 'N', 'Y');

-- --------------------------------------------------------

--
-- Table structure for table `simit_simsalon_promotion`
--

CREATE TABLE IF NOT EXISTS `simit_simsalon_promotion` (
  `promotion_id` int(11) NOT NULL auto_increment,
  `promotion_no` varchar(20) NOT NULL default '',
  `promotion_desc` varchar(100) NOT NULL,
  `promotion_type` char(1) NOT NULL default '',
  `customer_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `promotion_price` decimal(12,2) default '0.00',
  `promotion_expiry` date default '0000-00-00',
  `promotion_remarks` text,
  `organization_id` int(11) default NULL,
  `created` datetime NOT NULL default '0000-00-00 00:00:00',
  `createdby` int(11) NOT NULL default '0',
  `updated` datetime NOT NULL default '0000-00-00 00:00:00',
  `updatedby` int(11) NOT NULL default '0',
  `isactive` char(1) NOT NULL default '',
  `promotion_buy` int(11) default '0',
  `promotion_free` int(11) default '0',
  `isonepayment` char(1) default 'Y',
  `promotion_effective` date default '0000-00-00',
  PRIMARY KEY  (`promotion_id`),
  UNIQUE KEY `promotion_no` (`promotion_no`),
  KEY `customer_id` (`customer_id`),
  KEY `product_id` (`product_id`),
  KEY `organization_id` (`organization_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `simit_simsalon_promotion`
--

INSERT INTO `simit_simsalon_promotion` (`promotion_id`, `promotion_no`, `promotion_desc`, `promotion_type`, `customer_id`, `product_id`, `promotion_price`, `promotion_expiry`, `promotion_remarks`, `organization_id`, `created`, `createdby`, `updated`, `updatedby`, `isactive`, `promotion_buy`, `promotion_free`, `isonepayment`, `promotion_effective`) VALUES
(1, '1', 'aaa', 'F', 0, 168, 0.00, '2008-12-31', 'zza', 0, '2008-12-15 10:30:10', 1, '2008-12-16 14:38:19', 1, 'Y', 3, 1, 'Y', '2008-12-01'),
(2, '2', 'asas', 'S', 0, 0, 1233.00, '0000-00-00', '', 0, '2008-12-15 10:35:07', 1, '2008-12-15 10:35:07', 1, 'Y', 0, 0, 'N', '0000-00-00'),
(5, '3', 'bbb', 'F', 0, 163, 0.00, '2008-12-31', '', 0, '2008-12-15 14:07:24', 1, '2008-12-16 10:49:20', 1, 'Y', 2, 1, 'Y', '2008-12-01'),
(10, '4', '3A', 'P', 0, 162, 14.00, '2008-12-31', '', 0, '2008-12-16 13:20:44', 1, '2008-12-16 14:30:33', 1, 'Y', 0, 0, 'Y', '2008-12-15'),
(11, '5', 'SPECIAL FREE HARI RAYA', 'S', 0, 0, 0.00, '2008-12-18', '', 0, '2008-12-16 13:47:34', 1, '2008-12-16 14:31:05', 1, 'Y', 0, 0, 'Y', '2008-12-15');

-- --------------------------------------------------------

--
-- Table structure for table `simit_simsalon_races`
--

CREATE TABLE IF NOT EXISTS `simit_simsalon_races` (
  `races_id` int(11) NOT NULL auto_increment,
  `races_name` varchar(20) NOT NULL default '',
  `isactive` char(1) NOT NULL default '',
  `organization_id` int(11) NOT NULL default '0',
  `updated` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `updatedby` int(11) NOT NULL default '0',
  `created` timestamp NOT NULL default '0000-00-00 00:00:00',
  `createdby` int(11) NOT NULL default '0',
  `races_description` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`races_id`),
  KEY `organization_id` (`organization_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `simit_simsalon_races`
--

INSERT INTO `simit_simsalon_races` (`races_id`, `races_name`, `isactive`, `organization_id`, `updated`, `updatedby`, `created`, `createdby`, `races_description`) VALUES
(2, 'Chinese', 'Y', 0, '2008-08-21 15:31:41', 0, '0000-00-00 00:00:00', 0, 'Chinese'),
(3, 'Malays', 'Y', 0, '2008-08-21 15:31:41', 0, '0000-00-00 00:00:00', 0, 'Malays'),
(4, 'Indians', 'Y', 0, '2008-08-21 15:32:24', 0, '0000-00-00 00:00:00', 0, 'Indians'),
(5, 'Others', 'Y', 0, '2008-08-21 15:32:57', 0, '0000-00-00 00:00:00', 0, 'Others');

-- --------------------------------------------------------

--
-- Table structure for table `simit_simsalon_sales`
--

CREATE TABLE IF NOT EXISTS `simit_simsalon_sales` (
  `sales_id` int(11) NOT NULL auto_increment,
  `sales_no` varchar(20) NOT NULL default '',
  `sales_date` date NOT NULL default '0000-00-00',
  `customer_id` int(11) NOT NULL,
  `iscomplete` char(1) NOT NULL,
  `sales_remarks` text,
  `created` datetime NOT NULL default '0000-00-00 00:00:00',
  `createdby` int(11) NOT NULL default '0',
  `updated` datetime NOT NULL default '0000-00-00 00:00:00',
  `updatedby` int(11) NOT NULL default '0',
  `isactive` char(1) NOT NULL default '',
  `sales_totalamount` decimal(12,2) default NULL,
  `sales_paidamount` decimal(12,2) default '0.00',
  PRIMARY KEY  (`sales_id`),
  UNIQUE KEY `sales_no` (`sales_no`),
  KEY `customer_id` (`customer_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=28 ;

--
-- Dumping data for table `simit_simsalon_sales`
--

INSERT INTO `simit_simsalon_sales` (`sales_id`, `sales_no`, `sales_date`, `customer_id`, `iscomplete`, `sales_remarks`, `created`, `createdby`, `updated`, `updatedby`, `isactive`, `sales_totalamount`, `sales_paidamount`) VALUES
(5, '1', '2008-11-05', 2, 'Y', '', '2008-11-05 11:45:14', 3, '2008-11-05 11:47:00', 3, 'Y', 15.00, 20.00),
(6, '2', '2008-11-05', 9, 'Y', '', '2008-11-05 11:48:08', 3, '2008-12-12 15:13:30', 1, 'Y', 90.00, 100.00),
(26, '4', '2008-12-14', 77, 'N', '', '2008-12-14 10:29:33', 1, '2008-12-16 14:39:31', 1, 'Y', 202.00, 200.00),
(27, '5', '2008-12-15', 2, 'N', '', '2008-12-15 13:09:28', 1, '2008-12-16 14:26:54', 1, 'Y', 186.00, 0.00);

-- --------------------------------------------------------

--
-- Table structure for table `simit_simsalon_salesemployeeline`
--

CREATE TABLE IF NOT EXISTS `simit_simsalon_salesemployeeline` (
  `salesemployeeline_id` int(11) NOT NULL auto_increment,
  `salesline_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL default '0',
  `percent` decimal(12,2) NOT NULL default '0.00',
  PRIMARY KEY  (`salesemployeeline_id`),
  KEY `employee_id` (`employee_id`),
  KEY `salesline_id` (`salesline_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=39 ;

--
-- Dumping data for table `simit_simsalon_salesemployeeline`
--

INSERT INTO `simit_simsalon_salesemployeeline` (`salesemployeeline_id`, `salesline_id`, `employee_id`, `percent`) VALUES
(1, 1, 1, 100.00),
(2, 1, 3, 0.00),
(3, 2, 2, 100.00),
(9, 8, 0, 100.00),
(28, 27, 0, 100.00),
(29, 28, 0, 100.00),
(30, 29, 0, 100.00),
(34, 33, 0, 100.00),
(36, 35, 0, 100.00),
(37, 36, 0, 100.00),
(38, 37, 0, 100.00);

-- --------------------------------------------------------

--
-- Table structure for table `simit_simsalon_salesline`
--

CREATE TABLE IF NOT EXISTS `simit_simsalon_salesline` (
  `salesline_id` int(11) NOT NULL auto_increment,
  `salesline_no` int(11) NOT NULL,
  `sales_id` int(11) NOT NULL,
  `employee_id` int(11) default '0',
  `salesline_type` char(1) default NULL,
  `product_id` int(11) NOT NULL default '0',
  `salesline_qty` int(11) default NULL,
  `salesline_price` decimal(12,2) default NULL,
  `salesline_amount` decimal(12,2) default '0.00',
  `salesline_remarks` text,
  `salesline_oprice` decimal(12,2) default '0.00',
  `isfree` char(1) default 'N',
  PRIMARY KEY  (`salesline_id`),
  KEY `sales_id` (`sales_id`),
  KEY `product_id` (`product_id`),
  KEY `employee_id` (`employee_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=38 ;

--
-- Dumping data for table `simit_simsalon_salesline`
--

INSERT INTO `simit_simsalon_salesline` (`salesline_id`, `salesline_no`, `sales_id`, `employee_id`, `salesline_type`, `product_id`, `salesline_qty`, `salesline_price`, `salesline_amount`, `salesline_remarks`, `salesline_oprice`, `isfree`) VALUES
(1, 1, 5, 0, NULL, 147, 1, 15.00, 15.00, NULL, 15.00, 'N'),
(2, 1, 6, 0, NULL, 2, 1, 90.00, 90.00, NULL, 90.00, 'N'),
(8, 1, 27, 0, NULL, 168, 1, 85.00, 85.00, NULL, 0.00, 'N'),
(27, 19, 26, 0, NULL, 163, 1, 16.00, 16.00, NULL, 0.00, 'N'),
(28, 20, 26, 0, NULL, 163, 1, 16.00, 16.00, NULL, 16.00, 'N'),
(29, 2, 27, 0, NULL, 168, 1, 85.00, 85.00, NULL, 0.00, 'N'),
(33, 3, 27, 0, NULL, 162, 1, 16.00, 16.00, NULL, 0.00, 'N'),
(35, 21, 26, 0, NULL, 168, 1, 85.00, 85.00, NULL, 0.00, 'N'),
(36, 22, 26, 0, NULL, 168, 1, 85.00, 85.00, NULL, 0.00, 'N'),
(37, 23, 26, 0, NULL, 168, 1, 0.00, 0.00, NULL, 85.00, 'Y');

-- --------------------------------------------------------

--
-- Table structure for table `simit_simsalon_saleslist`
--

CREATE TABLE IF NOT EXISTS `simit_simsalon_saleslist` (
  `line` int(11) NOT NULL auto_increment,
  `windows_id` varchar(14) default '0',
  `sales_id` int(11) NOT NULL default '0',
  PRIMARY KEY  (`line`),
  KEY `sales_id` (`sales_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

--
-- Dumping data for table `simit_simsalon_saleslist`
--

INSERT INTO `simit_simsalon_saleslist` (`line`, `windows_id`, `sales_id`) VALUES
(15, '200812151', 27),
(17, '200812161', 26);

-- --------------------------------------------------------

--
-- Table structure for table `simit_simsalon_socsotable`
--

CREATE TABLE IF NOT EXISTS `simit_simsalon_socsotable` (
  `socso_id` int(11) NOT NULL auto_increment,
  `amtfrom` decimal(12,2) NOT NULL,
  `amtto` decimal(12,2) NOT NULL,
  `employer_amt` decimal(12,2) NOT NULL,
  `employee_amt` decimal(12,2) NOT NULL,
  `totalamt` decimal(12,2) NOT NULL,
  `employer_amt2` decimal(12,2) NOT NULL,
  PRIMARY KEY  (`socso_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=35 ;

--
-- Dumping data for table `simit_simsalon_socsotable`
--

INSERT INTO `simit_simsalon_socsotable` (`socso_id`, `amtfrom`, `amtto`, `employer_amt`, `employee_amt`, `totalamt`, `employer_amt2`) VALUES
(1, 0.00, 30.00, 0.40, 0.10, 0.50, 0.30),
(2, 30.01, 50.00, 0.70, 0.20, 0.90, 0.50),
(3, 50.01, 70.00, 1.10, 0.30, 1.40, 0.80),
(4, 70.01, 100.00, 1.50, 0.40, 1.90, 1.10),
(5, 100.01, 140.00, 2.10, 0.60, 2.70, 1.50),
(6, 140.01, 200.00, 2.95, 0.85, 3.80, 2.10),
(7, 200.01, 300.00, 4.35, 1.25, 5.60, 3.10),
(8, 300.01, 400.00, 6.15, 1.75, 7.90, 4.40),
(9, 400.01, 500.00, 7.85, 2.25, 10.10, 5.60),
(10, 500.01, 600.00, 9.65, 2.75, 12.40, 6.90),
(11, 600.01, 700.00, 11.35, 3.25, 14.60, 8.10),
(12, 700.01, 800.00, 13.15, 3.75, 16.90, 9.40),
(13, 800.01, 900.00, 14.85, 4.25, 19.10, 10.60),
(14, 900.01, 1000.00, 16.65, 4.75, 21.40, 11.90),
(15, 1000.01, 1100.00, 18.35, 5.25, 23.60, 13.10),
(16, 1100.01, 1200.00, 20.15, 5.75, 25.90, 14.40),
(17, 1200.01, 1300.00, 21.85, 6.25, 28.10, 15.60),
(18, 1300.01, 1400.00, 23.65, 6.75, 30.40, 16.90),
(19, 1400.01, 1500.00, 25.35, 7.25, 32.60, 18.10),
(20, 1500.01, 1600.00, 27.15, 7.75, 34.90, 19.40),
(21, 1600.01, 1700.00, 28.85, 8.25, 37.10, 20.60),
(22, 1700.01, 1800.00, 30.65, 8.75, 39.40, 21.90),
(23, 1800.01, 1900.00, 32.35, 9.25, 41.60, 23.10),
(24, 1900.01, 2000.00, 34.15, 9.75, 43.90, 24.40),
(25, 2000.01, 2100.00, 35.85, 10.25, 46.10, 25.60),
(26, 2100.01, 2200.00, 37.65, 10.75, 48.40, 26.90),
(27, 2200.01, 2300.00, 39.35, 11.25, 50.60, 28.10),
(28, 2300.01, 2400.00, 41.15, 11.75, 52.90, 29.40),
(29, 2400.01, 2500.00, 42.85, 12.25, 55.10, 30.60),
(30, 2500.01, 2600.00, 44.65, 12.75, 57.40, 31.90),
(31, 2600.01, 2700.00, 46.35, 13.25, 59.60, 33.10),
(32, 2700.01, 2800.00, 48.15, 13.75, 61.90, 34.40),
(33, 2800.01, 2900.00, 49.85, 14.25, 64.10, 35.60),
(34, 2900.01, 99999999.00, 51.65, 14.75, 66.40, 36.90);

-- --------------------------------------------------------

--
-- Table structure for table `simit_simsalon_stafftype`
--

CREATE TABLE IF NOT EXISTS `simit_simsalon_stafftype` (
  `stafftype_id` int(11) NOT NULL auto_increment,
  `stafftype_code` varchar(20) NOT NULL default '',
  `stafftype_description` text NOT NULL,
  `isactive` char(1) NOT NULL default '',
  `organization_id` int(11) NOT NULL default '0',
  `created` datetime NOT NULL default '0000-00-00 00:00:00',
  `createdby` int(11) NOT NULL default '0',
  `updated` date NOT NULL default '0000-00-00',
  `updatedby` int(11) NOT NULL default '0',
  `remarks` text,
  PRIMARY KEY  (`stafftype_id`),
  UNIQUE KEY `stafftype_code` (`stafftype_code`),
  KEY `organization_id` (`organization_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `simit_simsalon_stafftype`
--

INSERT INTO `simit_simsalon_stafftype` (`stafftype_id`, `stafftype_code`, `stafftype_description`, `isactive`, `organization_id`, `created`, `createdby`, `updated`, `updatedby`, `remarks`) VALUES
(0, '0', '', 'Y', 0, '0000-00-00 00:00:00', 0, '0000-00-00', 0, NULL),
(1, '0001', 'Hair Stylist', 'Y', 0, '2008-09-16 16:02:59', 1, '2008-11-05', 3, ''),
(2, '0002', 'Shampoo Girl', 'Y', 0, '2008-10-29 15:04:02', 3, '2008-10-29', 3, ''),
(3, '0003', 'Master Stylist', 'Y', 0, '2008-10-29 15:05:04', 3, '2008-10-29', 3, '');

-- --------------------------------------------------------

--
-- Table structure for table `simit_simsalon_tblwindows`
--

CREATE TABLE IF NOT EXISTS `simit_simsalon_tblwindows` (
  `windows_id` int(11) NOT NULL auto_increment,
  `windows_no` varchar(20) NOT NULL,
  `windows_name` varchar(50) NOT NULL,
  `windows_filename` varchar(30) default NULL,
  `windows_type` char(1) default NULL,
  `groupid` int(11) NOT NULL,
  `isactive` char(1) default NULL,
  `created` date default NULL,
  `createdby` int(11) default NULL,
  `updated` date default NULL,
  `updatedby` int(11) default NULL,
  PRIMARY KEY  (`windows_id`),
  UNIQUE KEY `windows_no` (`windows_no`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=38 ;

--
-- Dumping data for table `simit_simsalon_tblwindows`
--

INSERT INTO `simit_simsalon_tblwindows` (`windows_id`, `windows_no`, `windows_name`, `windows_filename`, `windows_type`, `groupid`, `isactive`, `created`, `createdby`, `updated`, `updatedby`) VALUES
(1, '1', 'Terms', 'terms.php', 'M', 0, '1', NULL, NULL, NULL, NULL),
(2, '2', 'Vendor', 'vendor.php', 'M', 0, '1', NULL, NULL, NULL, NULL),
(3, '3', 'Customer Type', 'customertype.php', 'M', 0, '1', NULL, NULL, NULL, NULL),
(4, '4', 'Customer', 'customer.php', 'M', 0, '1', NULL, NULL, NULL, NULL),
(5, '5', 'Employee Type', 'stafftype.php', 'M', 0, '1', NULL, NULL, NULL, NULL),
(6, '6', 'Employee', 'employee.php', 'M', 0, '1', NULL, NULL, NULL, NULL),
(7, '7', 'Unit Of Measurement', 'uom.php', 'M', 0, '1', NULL, NULL, NULL, NULL),
(8, '8', 'Product Category', 'category.php', 'M', 0, '1', NULL, NULL, NULL, NULL),
(9, '9', 'Product List', 'product.php', 'M', 0, '1', NULL, NULL, NULL, NULL),
(10, '10', 'Expenses Category', 'expensescategory.php', 'M', 0, '1', NULL, NULL, NULL, NULL),
(11, '11', 'Expenses List', 'expenseslist.php', 'M', 0, '1', NULL, NULL, NULL, NULL),
(12, '12', 'Promotion Package List', 'promotion.php', 'M', 0, '1', NULL, NULL, NULL, NULL),
(13, '13', 'Commission', 'commission.php', 'M', 0, '1', NULL, NULL, NULL, NULL),
(14, '14', 'Leave', 'leave.php', 'M', 0, '1', NULL, NULL, NULL, NULL),
(15, '15', 'Sales (Payment)', 'payment.php', 'T', 0, '1', NULL, NULL, NULL, NULL),
(16, '16', 'Sales (Payment) History', 'sales.php', 'T', 0, '1', NULL, NULL, NULL, NULL),
(17, '17', 'Payroll', 'payroll.php', 'T', 0, '1', NULL, NULL, NULL, NULL),
(18, '18', 'Expenses', 'expenses.php', 'T', 0, '1', NULL, NULL, NULL, NULL),
(19, '19', 'Vendor Invoice', 'vinvoice.php', 'T', 0, '1', NULL, NULL, NULL, NULL),
(20, '20', 'Internal Use', 'internal.php', 'T', 0, '1', NULL, NULL, NULL, NULL),
(21, '21', 'Adjustment', 'adjustment.php', 'T', 0, '1', NULL, NULL, NULL, NULL),
(22, '22', 'Customer Service Details', 'customerservice.php', 'T', 0, '1', NULL, NULL, NULL, NULL),
(23, '23', 'Profit & Loss Statement', 'profitnloss.php', 'R', 0, '1', NULL, NULL, NULL, NULL),
(24, '24', 'On Hand Stock Report', 'liststock.php', 'R', 0, '1', NULL, NULL, NULL, NULL),
(25, '25', 'Perfomance Summary Report', 'salary.php', 'R', 0, '1', NULL, NULL, NULL, NULL),
(26, '26', 'Stock Movement Summary Report', 'stockmovement.php', 'R', 0, 'Y', NULL, NULL, NULL, NULL),
(27, '27', 'Customer History Report', 'customerhistory.php', 'R', 0, 'Y', NULL, NULL, NULL, NULL),
(28, '28', 'Sales Analysis Report', 'salesanalysis.php', 'R', 0, 'Y', NULL, NULL, NULL, NULL),
(29, '29', 'Inactive Customer Report', 'inactivecustomerrpt.php', 'R', 0, 'Y', NULL, NULL, NULL, NULL),
(30, '30', 'Join Date Customer Report', 'joindate.php', 'R', 0, 'Y', NULL, NULL, NULL, NULL),
(31, '31', 'Sales Turn Over Report', 'salesturnover.php', 'R', 0, 'Y', NULL, NULL, NULL, NULL),
(32, '32', 'Customer Type Report', 'typecustomer.php', 'R', 0, 'Y', NULL, NULL, NULL, NULL),
(33, '33', 'Stock Replenish Report', 'purchasestock.php', 'R', 0, 'Y', NULL, NULL, NULL, NULL),
(35, '35', 'Stock Summary Report', 'stocksummary.php', 'R', 0, 'Y', NULL, NULL, NULL, NULL),
(36, '36', 'Invoice Summary Report', 'invoicesummary.php', 'R', 0, 'Y', NULL, NULL, NULL, NULL),
(37, '37', 'Expenses Summary Report', 'expensessummary.php', 'R', 0, 'Y', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `simit_simsalon_tblwindowsgroup`
--

CREATE TABLE IF NOT EXISTS `simit_simsalon_tblwindowsgroup` (
  `windowsgroupline_id` int(11) NOT NULL auto_increment,
  `windows_id` int(11) NOT NULL,
  `windows_name` varchar(50) NOT NULL,
  `groupid` int(11) NOT NULL,
  `isaccess` int(11) NOT NULL default '0',
  `allowadd` int(11) NOT NULL default '0',
  `allowedit` int(11) NOT NULL default '0',
  `created` date default NULL,
  `createdby` int(11) default NULL,
  `updated` date default NULL,
  `updatedby` int(11) default NULL,
  PRIMARY KEY  (`windowsgroupline_id`),
  KEY `windows_id` (`windows_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=87 ;

--
-- Dumping data for table `simit_simsalon_tblwindowsgroup`
--

INSERT INTO `simit_simsalon_tblwindowsgroup` (`windowsgroupline_id`, `windows_id`, `windows_name`, `groupid`, `isaccess`, `allowadd`, `allowedit`, `created`, `createdby`, `updated`, `updatedby`) VALUES
(1, 1, '', 1, 1, 1, 1, '2008-10-19', 1, '2008-11-11', 3),
(2, 2, '', 1, 1, 1, 1, '2008-10-19', 1, '2008-11-11', 3),
(3, 3, '', 1, 1, 1, 1, '2008-10-19', 1, '2008-11-11', 3),
(4, 4, '', 1, 1, 1, 1, '2008-10-19', 1, '2008-11-11', 3),
(5, 5, '', 1, 1, 1, 1, '2008-10-19', 1, '2008-11-11', 3),
(6, 6, '', 1, 1, 1, 1, '2008-10-19', 1, '2008-11-11', 3),
(7, 7, '', 1, 1, 1, 1, '2008-10-19', 1, '2008-11-11', 3),
(8, 8, '', 1, 1, 1, 1, '2008-10-19', 1, '2008-11-11', 3),
(9, 9, '', 1, 1, 1, 1, '2008-10-19', 1, '2008-11-11', 3),
(10, 10, '', 1, 1, 1, 1, '2008-10-19', 1, '2008-11-11', 3),
(11, 11, '', 1, 1, 1, 1, '2008-10-19', 1, '2008-11-11', 3),
(12, 12, '', 1, 1, 1, 1, '2008-10-19', 1, '2008-11-11', 3),
(13, 13, '', 1, 1, 1, 1, '2008-10-19', 1, '2008-11-11', 3),
(14, 14, '', 1, 1, 1, 1, '2008-10-19', 1, '2008-11-11', 3),
(15, 15, '', 1, 1, 1, 1, '2008-10-19', 1, '2008-11-11', 3),
(16, 16, '', 1, 1, 1, 1, '2008-10-19', 1, '2008-11-11', 3),
(17, 17, '', 1, 1, 1, 1, '2008-10-19', 1, '2008-11-11', 3),
(18, 18, '', 1, 1, 1, 1, '2008-10-19', 1, '2008-11-11', 3),
(19, 19, '', 1, 1, 1, 1, '2008-10-19', 1, '2008-11-11', 3),
(20, 20, '', 1, 1, 1, 1, '2008-10-19', 1, '2008-11-11', 3),
(21, 21, '', 1, 1, 1, 1, '2008-10-19', 1, '2008-11-11', 3),
(22, 22, '', 1, 1, 1, 1, '2008-10-19', 1, '2008-11-11', 3),
(23, 23, '', 1, 1, 1, 1, '2008-10-19', 1, '2008-11-11', 3),
(24, 24, '', 1, 1, 1, 1, '2008-10-19', 1, '2008-11-11', 3),
(25, 1, '', 2, 0, 0, 0, '2008-10-19', 1, NULL, NULL),
(26, 2, '', 2, 0, 0, 0, '2008-10-19', 1, NULL, NULL),
(27, 3, '', 2, 0, 0, 0, '2008-10-19', 1, NULL, NULL),
(28, 4, '', 2, 0, 0, 0, '2008-10-19', 1, NULL, NULL),
(29, 5, '', 2, 0, 0, 0, '2008-10-19', 1, NULL, NULL),
(30, 6, '', 2, 0, 0, 0, '2008-10-19', 1, NULL, NULL),
(31, 7, '', 2, 0, 0, 0, '2008-10-19', 1, NULL, NULL),
(32, 8, '', 2, 0, 0, 0, '2008-10-19', 1, NULL, NULL),
(33, 9, '', 2, 0, 0, 0, '2008-10-19', 1, NULL, NULL),
(34, 10, '', 2, 0, 0, 0, '2008-10-19', 1, NULL, NULL),
(35, 11, '', 2, 0, 0, 0, '2008-10-19', 1, NULL, NULL),
(36, 12, '', 2, 0, 0, 0, '2008-10-19', 1, NULL, NULL),
(37, 13, '', 2, 0, 0, 0, '2008-10-19', 1, NULL, NULL),
(38, 14, '', 2, 0, 0, 0, '2008-10-19', 1, NULL, NULL),
(39, 15, '', 2, 0, 0, 0, '2008-10-19', 1, NULL, NULL),
(40, 16, '', 2, 0, 0, 0, '2008-10-19', 1, NULL, NULL),
(41, 17, '', 2, 0, 0, 0, '2008-10-19', 1, NULL, NULL),
(42, 18, '', 2, 0, 0, 0, '2008-10-19', 1, NULL, NULL),
(43, 19, '', 2, 0, 0, 0, '2008-10-19', 1, NULL, NULL),
(44, 20, '', 2, 0, 0, 0, '2008-10-19', 1, NULL, NULL),
(45, 21, '', 2, 0, 0, 0, '2008-10-19', 1, NULL, NULL),
(46, 22, '', 2, 0, 0, 0, '2008-10-19', 1, NULL, NULL),
(47, 23, '', 2, 0, 0, 0, '2008-10-19', 1, NULL, NULL),
(48, 24, '', 2, 0, 0, 0, '2008-10-19', 1, NULL, NULL),
(49, 25, '', 1, 1, 1, 1, '2008-10-20', 1, '2008-11-11', 3),
(50, 26, '', 1, 1, 1, 1, '2008-10-20', 1, '2008-11-11', 3),
(51, 1, '', 4, 0, 0, 0, '2008-10-20', 1, '2008-10-20', 1),
(52, 2, '', 4, 0, 0, 0, '2008-10-20', 1, '2008-10-20', 1),
(53, 3, '', 4, 0, 0, 0, '2008-10-20', 1, '2008-10-20', 1),
(54, 4, '', 4, 0, 0, 0, '2008-10-20', 1, '2008-10-20', 1),
(55, 5, '', 4, 0, 0, 0, '2008-10-20', 1, '2008-10-20', 1),
(56, 6, '', 4, 0, 0, 0, '2008-10-20', 1, '2008-10-20', 1),
(57, 7, '', 4, 0, 0, 0, '2008-10-20', 1, '2008-10-20', 1),
(58, 8, '', 4, 0, 0, 0, '2008-10-20', 1, '2008-10-20', 1),
(59, 9, '', 4, 0, 0, 0, '2008-10-20', 1, '2008-10-20', 1),
(60, 10, '', 4, 0, 0, 0, '2008-10-20', 1, '2008-10-20', 1),
(61, 11, '', 4, 0, 0, 0, '2008-10-20', 1, '2008-10-20', 1),
(62, 12, '', 4, 0, 0, 0, '2008-10-20', 1, '2008-10-20', 1),
(63, 13, '', 4, 0, 0, 0, '2008-10-20', 1, '2008-10-20', 1),
(64, 14, '', 4, 0, 0, 0, '2008-10-20', 1, '2008-10-20', 1),
(65, 15, '', 4, 1, 0, 0, '2008-10-20', 1, '2008-10-20', 1),
(66, 16, '', 4, 0, 0, 0, '2008-10-20', 1, '2008-10-20', 1),
(67, 17, '', 4, 0, 0, 0, '2008-10-20', 1, '2008-10-20', 1),
(68, 18, '', 4, 0, 0, 0, '2008-10-20', 1, '2008-10-20', 1),
(69, 19, '', 4, 1, 0, 0, '2008-10-20', 1, '2008-10-20', 1),
(70, 20, '', 4, 1, 0, 0, '2008-10-20', 1, '2008-10-20', 1),
(71, 21, '', 4, 1, 0, 0, '2008-10-20', 1, '2008-10-20', 1),
(72, 22, '', 4, 0, 0, 0, '2008-10-20', 1, '2008-10-20', 1),
(73, 23, '', 4, 0, 0, 0, '2008-10-20', 1, '2008-10-20', 1),
(74, 24, '', 4, 0, 0, 0, '2008-10-20', 1, '2008-10-20', 1),
(75, 25, '', 4, 0, 0, 0, '2008-10-20', 1, '2008-10-20', 1),
(76, 26, '', 4, 0, 0, 0, '2008-10-20', 1, '2008-10-20', 1),
(77, 27, '', 1, 1, 1, 1, '2008-10-21', 1, '2008-11-11', 3),
(78, 28, '', 1, 1, 1, 1, '2008-10-29', 3, '2008-11-11', 3),
(79, 29, '', 1, 1, 1, 1, '2008-10-29', 3, '2008-11-11', 3),
(80, 30, '', 1, 1, 1, 1, '2008-10-29', 3, '2008-11-11', 3),
(81, 31, '', 1, 1, 1, 1, '2008-10-29', 3, '2008-11-11', 3),
(82, 32, '', 1, 1, 1, 1, '2008-10-29', 3, '2008-11-11', 3),
(83, 33, '', 1, 1, 1, 1, '2008-10-29', 3, '2008-11-11', 3),
(84, 35, '', 1, 1, 0, 0, '2008-11-11', 3, '2008-11-11', 3),
(85, 36, '', 1, 1, 0, 0, '2008-11-11', 3, '2008-11-11', 3),
(86, 37, '', 1, 1, 0, 0, '2008-11-11', 3, '2008-11-11', 3);

-- --------------------------------------------------------

--
-- Table structure for table `simit_simsalon_terms`
--

CREATE TABLE IF NOT EXISTS `simit_simsalon_terms` (
  `terms_id` int(11) NOT NULL auto_increment,
  `terms_code` varchar(20) NOT NULL default '',
  `terms_description` text NOT NULL,
  `isactive` char(1) NOT NULL default '',
  `organization_id` int(11) NOT NULL default '0',
  `created` datetime NOT NULL default '0000-00-00 00:00:00',
  `createdby` int(11) NOT NULL default '0',
  `updated` date NOT NULL default '0000-00-00',
  `updatedby` int(11) NOT NULL default '0',
  `remarks` text,
  PRIMARY KEY  (`terms_id`),
  UNIQUE KEY `terms_code` (`terms_code`),
  KEY `organization_id` (`organization_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `simit_simsalon_terms`
--

INSERT INTO `simit_simsalon_terms` (`terms_id`, `terms_code`, `terms_description`, `isactive`, `organization_id`, `created`, `createdby`, `updated`, `updatedby`, `remarks`) VALUES
(0, '0', '', 'Y', 0, '0000-00-00 00:00:00', 0, '0000-00-00', 0, NULL),
(1, '30 Days', '30 Days', 'Y', 0, '2008-09-13 03:19:30', 1, '2008-10-21', 1, '30 Days'),
(2, '60 Days', '60 Days', 'Y', 0, '2008-09-13 03:19:46', 1, '2008-10-21', 1, '60 Days'),
(3, 'C.O.D', 'Cash On Delivery', 'Y', 0, '2008-10-21 14:12:14', 1, '2008-10-21', 1, ''),
(4, '15 Days', '15 Days', 'Y', 0, '2008-10-21 14:12:56', 1, '2008-10-21', 1, '');

-- --------------------------------------------------------

--
-- Table structure for table `simit_simsalon_uom`
--

CREATE TABLE IF NOT EXISTS `simit_simsalon_uom` (
  `uom_id` int(11) NOT NULL auto_increment,
  `uom_code` varchar(20) NOT NULL default '',
  `uom_description` text NOT NULL,
  `isactive` char(1) NOT NULL default '',
  `organization_id` int(11) NOT NULL default '0',
  `created` datetime NOT NULL default '0000-00-00 00:00:00',
  `createdby` int(11) NOT NULL default '0',
  `updated` date NOT NULL default '0000-00-00',
  `updatedby` int(11) NOT NULL default '0',
  `remarks` text,
  PRIMARY KEY  (`uom_id`),
  UNIQUE KEY `uom_code` (`uom_code`),
  KEY `organization_id` (`organization_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `simit_simsalon_uom`
--

INSERT INTO `simit_simsalon_uom` (`uom_id`, `uom_code`, `uom_description`, `isactive`, `organization_id`, `created`, `createdby`, `updated`, `updatedby`, `remarks`) VALUES
(0, '0', '', 'Y', 0, '0000-00-00 00:00:00', 0, '0000-00-00', 0, NULL),
(1, '001', 'PCS', 'Y', 0, '2008-09-16 16:07:42', 1, '2008-09-16', 1, ''),
(3, '003', 'JOB', 'Y', 0, '2008-09-16 16:08:16', 1, '2008-09-16', 1, ''),
(4, '004', 'BTL', 'Y', 0, '2008-10-21 18:29:07', 3, '2008-10-21', 3, 'Bottle'),
(5, '005', 'Box', 'Y', 0, '2008-10-23 18:59:12', 3, '2008-10-23', 3, '');

-- --------------------------------------------------------

--
-- Table structure for table `simit_simsalon_vendor`
--

CREATE TABLE IF NOT EXISTS `simit_simsalon_vendor` (
  `vendor_id` int(11) NOT NULL auto_increment,
  `vendor_no` varchar(20) NOT NULL default '',
  `vendor_name` varchar(50) NOT NULL default '',
  `vendor_hpno` varchar(20) default NULL,
  `vendor_telno` varchar(20) default NULL,
  `vendor_faxno` varchar(20) default NULL,
  `vendor_pic` varchar(50) default NULL,
  `vendor_street1` varchar(100) default NULL,
  `vendor_street2` varchar(100) default NULL,
  `organization_id` int(1) NOT NULL,
  `vendor_remarks` text,
  `created` datetime NOT NULL default '0000-00-00 00:00:00',
  `createdby` int(11) NOT NULL default '0',
  `updated` datetime NOT NULL default '0000-00-00 00:00:00',
  `updatedby` int(11) NOT NULL default '0',
  `isactive` char(1) NOT NULL default '',
  `isdefault` char(1) NOT NULL default '',
  `vendor_country` varchar(20) default NULL,
  `vendor_state` varchar(30) default NULL,
  `vendor_postcode` varchar(10) default NULL,
  `terms_id` int(11) NOT NULL default '0',
  `vendor_city` varchar(40) NOT NULL,
  PRIMARY KEY  (`vendor_id`),
  UNIQUE KEY `vendor_no` (`vendor_no`),
  KEY `organization_id` (`organization_id`),
  KEY `terms_id` (`terms_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `simit_simsalon_vendor`
--

INSERT INTO `simit_simsalon_vendor` (`vendor_id`, `vendor_no`, `vendor_name`, `vendor_hpno`, `vendor_telno`, `vendor_faxno`, `vendor_pic`, `vendor_street1`, `vendor_street2`, `organization_id`, `vendor_remarks`, `created`, `createdby`, `updated`, `updatedby`, `isactive`, `isdefault`, `vendor_country`, `vendor_state`, `vendor_postcode`, `terms_id`, `vendor_city`) VALUES
(0, '0', '', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, 'Y', '', NULL, NULL, NULL, 0, ''),
(1, '1', 'Loreal Malaysia Sdn Bhd', '0197289483', '', '', 'Jane', 'Level 13A & 15, Uptown 2, No 2, Jln SS 21/37,', 'Damansara Uptown,', 0, '', '2008-10-23 18:06:23', 3, '2008-10-23 18:19:28', 3, 'Y', '', '', 'Selangor', '47400', 2, 'Petaling Jaya'),
(2, '2', 'Vernal Enterprise', '01277608880', '0166617838', '', 'Ah Bee', 'L1-06, Regent Court,Prima Regency Service Apt.', 'Jalan Masai Baru', 0, '', '2008-10-23 18:13:56', 3, '2008-11-05 11:44:00', 3, 'Y', '', '', 'Johor', '81750', 3, ''),
(3, '3', 'New Teck Lee Supplier', '0197792458', '073322722', '073328724', '', '83,Jln Kuning', 'Taman Pelangi', 0, '', '2008-10-23 18:23:22', 3, '2008-10-23 18:23:22', 3, 'Y', '', '', 'Johor', '80400', 2, 'Johor Bahru');

-- --------------------------------------------------------

--
-- Table structure for table `simit_simsalon_vinvoice`
--

CREATE TABLE IF NOT EXISTS `simit_simsalon_vinvoice` (
  `vinvoice_id` int(11) NOT NULL auto_increment,
  `vinvoice_no` varchar(20) NOT NULL default '',
  `vinvoice_date` date NOT NULL default '0000-00-00',
  `vendor_id` int(11) NOT NULL,
  `terms_id` int(11) default '0',
  `iscomplete` char(1) NOT NULL,
  `vinvoice_remarks` text,
  `vinvoice_receiveby` varchar(50) default NULL,
  `created` datetime NOT NULL default '0000-00-00 00:00:00',
  `createdby` int(11) NOT NULL default '0',
  `updated` datetime NOT NULL default '0000-00-00 00:00:00',
  `updatedby` int(11) NOT NULL default '0',
  `isactive` char(1) NOT NULL default '',
  `vinvoice_totalamount` decimal(12,2) default NULL,
  PRIMARY KEY  (`vinvoice_id`),
  UNIQUE KEY `vinvoice_no` (`vinvoice_no`),
  KEY `vendor_id` (`vendor_id`),
  KEY `terms_id` (`terms_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `simit_simsalon_vinvoice`
--

INSERT INTO `simit_simsalon_vinvoice` (`vinvoice_id`, `vinvoice_no`, `vinvoice_date`, `vendor_id`, `terms_id`, `iscomplete`, `vinvoice_remarks`, `vinvoice_receiveby`, `created`, `createdby`, `updated`, `updatedby`, `isactive`, `vinvoice_totalamount`) VALUES
(1, '0227', '2008-09-05', 2, 3, 'Y', '', 'serena', '2008-10-23 18:54:12', 3, '2008-10-23 19:01:43', 3, 'Y', 56.00),
(2, '8000062017', '2008-10-21', 1, 2, 'Y', '', 'serena', '2008-10-23 19:05:01', 3, '2008-10-23 19:36:14', 3, 'Y', 803.90),
(3, '0995', '2008-10-24', 2, 3, 'Y', '', 'serena', '2008-10-28 11:31:55', 3, '2008-10-28 12:14:45', 3, 'Y', 798.00),
(4, '8000062018', '2008-10-29', 3, 2, 'N', '', 'serena', '2008-10-29 16:25:25', 3, '2008-10-29 16:25:25', 3, 'Y', 0.00),
(5, '8000062019', '2008-10-29', 1, 2, 'N', '', 'serena', '2008-10-29 19:17:13', 3, '2008-10-29 19:17:13', 3, 'Y', 0.00),
(6, '8000062020', '2008-11-05', 2, 3, 'N', '', 'serena', '2008-11-05 11:12:23', 3, '2008-11-05 11:12:34', 3, 'Y', 0.00);

-- --------------------------------------------------------

--
-- Table structure for table `simit_simsalon_vinvoiceline`
--

CREATE TABLE IF NOT EXISTS `simit_simsalon_vinvoiceline` (
  `vinvoiceline_id` int(11) NOT NULL auto_increment,
  `vinvoiceline_no` int(11) NOT NULL,
  `vinvoice_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL default '0',
  `vinvoiceline_qty` int(11) default NULL,
  `vinvoiceline_price` decimal(12,2) default NULL,
  `vinvoiceline_discount` decimal(12,2) default '0.00',
  `vinvoiceline_amount` decimal(12,2) default '0.00',
  `vinvoiceline_remarks` text,
  `vinvoiceline_discounttype` int(11) default '1',
  `vinvoiceline_checkamount` char(1) default 'N',
  PRIMARY KEY  (`vinvoiceline_id`),
  KEY `vinvoice_id` (`vinvoice_id`),
  KEY `product_id` (`product_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=22 ;

--
-- Dumping data for table `simit_simsalon_vinvoiceline`
--

INSERT INTO `simit_simsalon_vinvoiceline` (`vinvoiceline_id`, `vinvoiceline_no`, `vinvoice_id`, `product_id`, `vinvoiceline_qty`, `vinvoiceline_price`, `vinvoiceline_discount`, `vinvoiceline_amount`, `vinvoiceline_remarks`, `vinvoiceline_discounttype`, `vinvoiceline_checkamount`) VALUES
(1, 1, 1, 53, 2, 28.00, 0.00, 56.00, '', 1, 'N'),
(10, 1, 3, 63, 12, 28.00, 0.00, 336.00, '', 1, 'N'),
(11, 2, 3, 64, 12, 26.00, 0.00, 312.00, '', 1, 'N'),
(12, 3, 3, 65, 2, 68.00, 0.00, 136.00, '', 1, 'N'),
(13, 4, 3, 66, 1, 14.00, 0.00, 14.00, '', 1, 'N'),
(14, 1, 4, 0, 0, 0.00, 0.00, 0.00, NULL, 1, 'N'),
(15, 2, 4, 0, 0, 0.00, 0.00, 0.00, NULL, 1, 'N'),
(16, 3, 4, 0, 0, 0.00, 0.00, 0.00, NULL, 1, 'N'),
(17, 4, 4, 0, 0, 0.00, 0.00, 0.00, NULL, 1, 'N'),
(18, 1, 6, 0, 0, 0.00, 0.00, 0.00, NULL, 1, 'N'),
(19, 2, 6, 0, 0, 0.00, 0.00, 0.00, NULL, 1, 'N'),
(20, 3, 6, 0, 0, 0.00, 0.00, 0.00, NULL, 1, 'N'),
(21, 4, 6, 0, 0, 0.00, 0.00, 0.00, NULL, 1, 'N');

-- --------------------------------------------------------

--
-- Table structure for table `simit_smiles`
--

CREATE TABLE IF NOT EXISTS `simit_smiles` (
  `id` smallint(5) unsigned NOT NULL auto_increment,
  `code` varchar(50) NOT NULL default '',
  `smile_url` varchar(100) NOT NULL default '',
  `emotion` varchar(75) NOT NULL default '',
  `display` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

--
-- Dumping data for table `simit_smiles`
--

INSERT INTO `simit_smiles` (`id`, `code`, `smile_url`, `emotion`, `display`) VALUES
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
-- Table structure for table `simit_tplfile`
--

CREATE TABLE IF NOT EXISTS `simit_tplfile` (
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
-- Dumping data for table `simit_tplfile`
--

INSERT INTO `simit_tplfile` (`tpl_id`, `tpl_refid`, `tpl_module`, `tpl_tplset`, `tpl_file`, `tpl_desc`, `tpl_lastmodified`, `tpl_lastimported`, `tpl_type`) VALUES
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
-- Table structure for table `simit_tplset`
--

CREATE TABLE IF NOT EXISTS `simit_tplset` (
  `tplset_id` int(7) unsigned NOT NULL auto_increment,
  `tplset_name` varchar(50) NOT NULL default '',
  `tplset_desc` varchar(255) NOT NULL default '',
  `tplset_credits` text NOT NULL,
  `tplset_created` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`tplset_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `simit_tplset`
--

INSERT INTO `simit_tplset` (`tplset_id`, `tplset_name`, `tplset_desc`, `tplset_credits`, `tplset_created`) VALUES
(1, 'default', 'XOOPS Default Template Set', '', 1205985656);

-- --------------------------------------------------------

--
-- Table structure for table `simit_tplsource`
--

CREATE TABLE IF NOT EXISTS `simit_tplsource` (
  `tpl_id` mediumint(7) unsigned NOT NULL default '0',
  `tpl_source` mediumtext NOT NULL,
  KEY `tpl_id` (`tpl_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `simit_tplsource`
--

INSERT INTO `simit_tplsource` (`tpl_id`, `tpl_source`) VALUES
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
-- Table structure for table `simit_users`
--

CREATE TABLE IF NOT EXISTS `simit_users` (
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
  `user_isactive` smallint(1) NOT NULL,
  PRIMARY KEY  (`uid`),
  KEY `uname` (`uname`),
  KEY `email` (`email`),
  KEY `uiduname` (`uid`,`uname`),
  KEY `unamepass` (`uname`,`pass`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `simit_users`
--

INSERT INTO `simit_users` (`uid`, `name`, `uname`, `email`, `url`, `user_avatar`, `user_regdate`, `user_icq`, `user_from`, `user_sig`, `user_viewemail`, `actkey`, `user_aim`, `user_yim`, `user_msnm`, `pass`, `posts`, `attachsig`, `rank`, `level`, `theme`, `timezone_offset`, `last_login`, `umode`, `uorder`, `notify_method`, `notify_mode`, `user_occ`, `bio`, `user_intrest`, `user_mailok`, `user_isactive`) VALUES
(1, 'I am admin', 'admin', 'admin@simit.com.my', 'http://localhost/simtrain/', 'blank.gif', 1205985656, '', '', '', 1, '', '', '', '', '21232f297a57a5a743894a0e4a801fc3', 0, 0, 7, 5, 'default', 0.0, 1229391826, 'thread', 0, 1, 0, '', '', 'admin', 0, 0),
(2, '', 'galaxy', 'galaxy', '', 'blank.gif', 1224580164, '', '', '', 0, '', '', '', '', 'e03239b27e34a5f7f3bde739459dd537', 0, 0, 0, 1, '', 8.0, 1224589158, 'nest', 0, 1, 0, '', '', '', 0, 0),
(3, '', 'serena', 'serena', '', 'blank.gif', 1224580214, '', '', '', 0, '', '', '', '', '7812e8b74f6837fba66f86fe86688a2b', 0, 0, 0, 1, '', 8.0, 1226392564, 'nest', 0, 1, 0, '', '', '', 0, 0),
(4, '', 'candy', 'candy', '', 'blank.gif', 1224580449, '', '', '', 0, '', '', '', '', '94f3b3a16d8ce064c808b16bee5003c5', 0, 0, 0, 1, '', 8.0, 0, 'nest', 0, 1, 0, '', '', '', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `simit_xoopscomments`
--

CREATE TABLE IF NOT EXISTS `simit_xoopscomments` (
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
-- Dumping data for table `simit_xoopscomments`
--


-- --------------------------------------------------------

--
-- Table structure for table `simit_xoopsnotifications`
--

CREATE TABLE IF NOT EXISTS `simit_xoopsnotifications` (
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
-- Dumping data for table `simit_xoopsnotifications`
--


--
-- Constraints for dumped tables
--

--
-- Constraints for table `simit_simsalon_allowanceline`
--
ALTER TABLE `simit_simsalon_allowanceline`
  ADD CONSTRAINT `simit_simsalon_allowanceline_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `simit_simsalon_employee` (`employee_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `simit_simsalon_allowancepayroll`
--
ALTER TABLE `simit_simsalon_allowancepayroll`
  ADD CONSTRAINT `simit_simsalon_allowancepayroll_ibfk_2` FOREIGN KEY (`payroll_id`) REFERENCES `simit_simsalon_payroll` (`payroll_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `simit_simsalon_customer`
--
ALTER TABLE `simit_simsalon_customer`
  ADD CONSTRAINT `simit_simsalon_customer_ibfk_1` FOREIGN KEY (`customertype`) REFERENCES `simit_simsalon_customertype` (`customertype_id`);

--
-- Constraints for table `simit_simsalon_employee`
--
ALTER TABLE `simit_simsalon_employee`
  ADD CONSTRAINT `simit_simsalon_employee_ibfk_1` FOREIGN KEY (`stafftype_id`) REFERENCES `simit_simsalon_stafftype` (`stafftype_id`);

--
-- Constraints for table `simit_simsalon_expenses`
--
ALTER TABLE `simit_simsalon_expenses`
  ADD CONSTRAINT `simit_simsalon_expenses_ibfk_1` FOREIGN KEY (`expenseslist_id`) REFERENCES `simit_simsalon_expenseslist` (`expenseslist_id`);

--
-- Constraints for table `simit_simsalon_expensesline`
--
ALTER TABLE `simit_simsalon_expensesline`
  ADD CONSTRAINT `simit_simsalon_expensesline_ibfk_6` FOREIGN KEY (`expenses_id`) REFERENCES `simit_simsalon_expenses` (`expenses_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `simit_simsalon_expensesline_ibfk_7` FOREIGN KEY (`expenseslist_id`) REFERENCES `simit_simsalon_expenseslist` (`expenseslist_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `simit_simsalon_expenseslist`
--
ALTER TABLE `simit_simsalon_expenseslist`
  ADD CONSTRAINT `simit_simsalon_expenseslist_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `simit_simsalon_expensescategory` (`category_id`),
  ADD CONSTRAINT `simit_simsalon_expenseslist_ibfk_2` FOREIGN KEY (`uom_id`) REFERENCES `simit_simsalon_uom` (`uom_id`);

--
-- Constraints for table `simit_simsalon_internalline`
--
ALTER TABLE `simit_simsalon_internalline`
  ADD CONSTRAINT `simit_simsalon_internalline_ibfk_7` FOREIGN KEY (`product_id`) REFERENCES `simit_simsalon_productlist` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `simit_simsalon_internalline_ibfk_8` FOREIGN KEY (`internal_id`) REFERENCES `simit_simsalon_internal` (`internal_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `simit_simsalon_internalline_ibfk_9` FOREIGN KEY (`employee_id`) REFERENCES `simit_simsalon_employee` (`employee_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `simit_simsalon_leaveline`
--
ALTER TABLE `simit_simsalon_leaveline`
  ADD CONSTRAINT `simit_simsalon_leaveline_ibfk_1` FOREIGN KEY (`payroll_id`) REFERENCES `simit_simsalon_payroll` (`payroll_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `simit_simsalon_productlist`
--
ALTER TABLE `simit_simsalon_productlist`
  ADD CONSTRAINT `simit_simsalon_productlist_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `simit_simsalon_productcategory` (`category_id`),
  ADD CONSTRAINT `simit_simsalon_productlist_ibfk_2` FOREIGN KEY (`uom_id`) REFERENCES `simit_simsalon_uom` (`uom_id`);

--
-- Constraints for table `simit_simsalon_promotion`
--
ALTER TABLE `simit_simsalon_promotion`
  ADD CONSTRAINT `simit_simsalon_promotion_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `simit_simsalon_customer` (`customer_id`),
  ADD CONSTRAINT `simit_simsalon_promotion_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `simit_simsalon_productlist` (`product_id`);

--
-- Constraints for table `simit_simsalon_sales`
--
ALTER TABLE `simit_simsalon_sales`
  ADD CONSTRAINT `simit_simsalon_sales_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `simit_simsalon_customer` (`customer_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `simit_simsalon_salesemployeeline`
--
ALTER TABLE `simit_simsalon_salesemployeeline`
  ADD CONSTRAINT `simsalon_salesemployeeline_ibfk_1` FOREIGN KEY (`salesline_id`) REFERENCES `simit_simsalon_salesline` (`salesline_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `simsalon_salesemployeeline_ibfk_2` FOREIGN KEY (`employee_id`) REFERENCES `simit_simsalon_employee` (`employee_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `simit_simsalon_salesline`
--
ALTER TABLE `simit_simsalon_salesline`
  ADD CONSTRAINT `simit_simsalon_salesline_ibfk_4` FOREIGN KEY (`sales_id`) REFERENCES `simit_simsalon_sales` (`sales_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `simit_simsalon_salesline_ibfk_5` FOREIGN KEY (`employee_id`) REFERENCES `simit_simsalon_employee` (`employee_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `simit_simsalon_salesline_ibfk_6` FOREIGN KEY (`product_id`) REFERENCES `simit_simsalon_productlist` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `simit_simsalon_vinvoice`
--
ALTER TABLE `simit_simsalon_vinvoice`
  ADD CONSTRAINT `simit_simsalon_vinvoice_ibfk_1` FOREIGN KEY (`vendor_id`) REFERENCES `simit_simsalon_vendor` (`vendor_id`),
  ADD CONSTRAINT `simit_simsalon_vinvoice_ibfk_2` FOREIGN KEY (`terms_id`) REFERENCES `simit_simsalon_terms` (`terms_id`);

--
-- Constraints for table `simit_simsalon_vinvoiceline`
--
ALTER TABLE `simit_simsalon_vinvoiceline`
  ADD CONSTRAINT `simit_simsalon_vinvoiceline_ibfk_6` FOREIGN KEY (`vinvoice_id`) REFERENCES `simit_simsalon_vinvoice` (`vinvoice_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `simit_simsalon_vinvoiceline_ibfk_7` FOREIGN KEY (`product_id`) REFERENCES `simit_simsalon_productlist` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE;
