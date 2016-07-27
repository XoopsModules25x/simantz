-- phpMyAdmin SQL Dump
-- version 3.3.2deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 29, 2010 at 06:26 PM
-- Server version: 5.1.41
-- PHP Version: 5.3.2-1ubuntu4.2

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `simantz`
--

-- --------------------------------------------------------

--
-- Table structure for table `sim_address`
--

CREATE TABLE IF NOT EXISTS `sim_address` (
  `address_id` int(11) NOT NULL AUTO_INCREMENT,
  `address_name` varchar(70) NOT NULL,
  `isactive` smallint(6) NOT NULL,
  `isshipment` smallint(6) NOT NULL,
  `isinvoice` smallint(6) NOT NULL,
  `created` int(11) NOT NULL,
  `createdby` int(11) NOT NULL,
  `updated` datetime NOT NULL,
  `updatedby` int(11) NOT NULL,
  `address_street` varchar(255) NOT NULL,
  `address_postcode` varchar(6) NOT NULL,
  `address_city` varchar(40) NOT NULL,
  `region_id` int(11) NOT NULL,
  `country_id` int(11) NOT NULL,
  `organization_id` int(11) NOT NULL,
  `bpartner_id` int(11) NOT NULL,
  `tel_1` varchar(20) NOT NULL,
  `tel_2` varchar(20) NOT NULL,
  `fax` varchar(30) NOT NULL,
  `description` text NOT NULL,
  `seqno` smallint(3) NOT NULL,
  PRIMARY KEY (`address_id`),
  KEY `country_id` (`country_id`),
  KEY `region_id` (`region_id`),
  KEY `bpartner_id` (`bpartner_id`),
  KEY `organization_id` (`organization_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `sim_address`
--


-- --------------------------------------------------------

--
-- Table structure for table `sim_amreview_rate`
--

CREATE TABLE IF NOT EXISTS `sim_amreview_rate` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `rate_review_id` int(5) NOT NULL DEFAULT '0',
  `rate_rating` int(5) NOT NULL DEFAULT '0',
  `rate_uid` int(5) NOT NULL DEFAULT '0',
  `rate_user_ip` varchar(20) NOT NULL DEFAULT '0',
  `rate_user_browser` varchar(50) NOT NULL DEFAULT '0',
  `rate_title` varchar(100) NOT NULL DEFAULT '0',
  `rate_text` text NOT NULL,
  `rate_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `rate_showme` int(5) NOT NULL DEFAULT '1',
  `rate_validated` int(5) NOT NULL DEFAULT '0',
  `rate_useful` varchar(20) NOT NULL DEFAULT '0/0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `sim_amreview_rate`
--


-- --------------------------------------------------------

--
-- Table structure for table `sim_audit`
--

CREATE TABLE IF NOT EXISTS `sim_audit` (
  `tablename` varchar(40) NOT NULL,
  `changedesc` text NOT NULL,
  `category` varchar(2) NOT NULL,
  `uid` int(11) NOT NULL,
  `updated` datetime NOT NULL,
  `record_id` int(11) NOT NULL,
  `eventype` varchar(2) NOT NULL,
  `uname` varchar(40) NOT NULL,
  `audit_id` int(11) NOT NULL AUTO_INCREMENT,
  `ip` varchar(25) NOT NULL,
  `primarykey` varchar(40) NOT NULL,
  `controlvalue` varchar(80) NOT NULL,
  PRIMARY KEY (`audit_id`),
  KEY `record_id` (`record_id`),
  KEY `uid` (`uid`),
  KEY `category` (`category`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=34 ;

--
-- Dumping data for table `sim_audit`
--

INSERT INTO `sim_audit` (`tablename`, `changedesc`, `category`, `uid`, `updated`, `record_id`, `eventype`, `uname`, `audit_id`, `ip`, `primarykey`, `controlvalue`) VALUES
('sim_window', 'seqno=''20'',<br/>parentwindows_id=''118''', 'U', 1, '2010-08-28 17:35:06', 118, 'S', '', 1, '::1', 'window_id', 'Transaction'),
('sim_window', 'seqno=''30'',<br/>parentwindows_id=''118''', 'U', 1, '2010-08-28 17:35:12', 128, 'S', '', 2, '::1', 'window_id', 'Reports'),
('sim_period', 'period_year=''2010''period_name=''2010-01''isactive=''1''seqno=''10''created=''2010-08-28 17:50:24''createdby=''1''updated=''2010-08-28 17:50:24''updatedby=''1''period_month=''01', 'I', 1, '2010-08-28 17:50:24', 1, 'S', 'admin', 3, '::1', 'period_id', '2010'),
('sim_period', 'period_year=''2010''period_name=''2010-02''isactive=''1''seqno=''10''created=''2010-08-28 17:50:24''createdby=''1''updated=''2010-08-28 17:50:24''updatedby=''1''period_month=''2', 'I', 1, '2010-08-28 17:50:25', 2, 'S', 'admin', 4, '::1', 'period_id', '2010'),
('sim_period', 'period_year=''2010''period_name=''2010-03''isactive=''1''seqno=''10''created=''2010-08-28 17:50:24''createdby=''1''updated=''2010-08-28 17:50:24''updatedby=''1''period_month=''3', 'I', 1, '2010-08-28 17:50:25', 3, 'S', 'admin', 5, '::1', 'period_id', '2010'),
('sim_period', 'period_year=''2010''period_name=''2010-04''isactive=''1''seqno=''10''created=''2010-08-28 17:50:24''createdby=''1''updated=''2010-08-28 17:50:24''updatedby=''1''period_month=''4', 'I', 1, '2010-08-28 17:50:25', 4, 'S', 'admin', 6, '::1', 'period_id', '2010'),
('sim_period', 'period_year=''2010''period_name=''2010-05''isactive=''1''seqno=''10''created=''2010-08-28 17:50:24''createdby=''1''updated=''2010-08-28 17:50:24''updatedby=''1''period_month=''5', 'I', 1, '2010-08-28 17:50:25', 5, 'S', 'admin', 7, '::1', 'period_id', '2010'),
('sim_period', 'period_year=''2010''period_name=''2010-06''isactive=''1''seqno=''10''created=''2010-08-28 17:50:24''createdby=''1''updated=''2010-08-28 17:50:24''updatedby=''1''period_month=''6', 'I', 1, '2010-08-28 17:50:25', 6, 'S', 'admin', 8, '::1', 'period_id', '2010'),
('sim_period', 'period_year=''2010''period_name=''2010-07''isactive=''1''seqno=''10''created=''2010-08-28 17:50:24''createdby=''1''updated=''2010-08-28 17:50:24''updatedby=''1''period_month=''7', 'I', 1, '2010-08-28 17:50:25', 7, 'S', 'admin', 9, '::1', 'period_id', '2010'),
('sim_period', 'period_year=''2010''period_name=''2010-08''isactive=''1''seqno=''10''created=''2010-08-28 17:50:24''createdby=''1''updated=''2010-08-28 17:50:24''updatedby=''1''period_month=''8', 'I', 1, '2010-08-28 17:50:25', 8, 'S', 'admin', 10, '::1', 'period_id', '2010'),
('sim_period', 'period_year=''2010''period_name=''2010-09''isactive=''1''seqno=''10''created=''2010-08-28 17:50:24''createdby=''1''updated=''2010-08-28 17:50:24''updatedby=''1''period_month=''09', 'I', 1, '2010-08-28 17:50:25', 9, 'S', 'admin', 11, '::1', 'period_id', '2010'),
('sim_period', 'period_year=''2010''period_name=''2010-10''isactive=''1''seqno=''10''created=''2010-08-28 17:50:24''createdby=''1''updated=''2010-08-28 17:50:24''updatedby=''1''period_month=''10', 'I', 1, '2010-08-28 17:50:25', 10, 'S', 'admin', 12, '::1', 'period_id', '2010'),
('sim_period', 'period_year=''2010''period_name=''2010-11''isactive=''1''seqno=''10''created=''2010-08-28 17:50:24''createdby=''1''updated=''2010-08-28 17:50:24''updatedby=''1''period_month=''11', 'I', 1, '2010-08-28 17:50:25', 11, 'S', 'admin', 13, '::1', 'period_id', '2010'),
('sim_period', 'period_year=''2010''period_name=''2010-12''isactive=''1''seqno=''10''created=''2010-08-28 17:50:24''createdby=''1''updated=''2010-08-28 17:50:24''updatedby=''1''period_month=''12', 'I', 1, '2010-08-28 17:50:25', 12, 'S', 'admin', 14, '::1', 'period_id', '2010'),
('sim_simbiz_batch', 'period_id=''8''batchno=''1''batch_name=''asd''batchdate=''2010-08-12''description=''''totaldebit=''50.00''totalcredit=''50.00''created=''10/08/28 17:50:34''createdby=''admin(1)''updated=''10/08/28 17:50:34''updatedby=''admin(1)''organization_id=''1''tax_type=''1''reuse=''0''track1_name=''Consultant''track2_name=''Salesman''track3_name=''Others', 'I', 1, '2010-08-28 17:50:35', 1, 'S', 'admin', 15, '::1', 'batch_id', '1'),
('sim_simbiz_transaction', 'batch_id=''1''document_no=''''amt=''-20''originalamt=''-20''tax_id=''''currency_id=''3''document_no2=''''accounts_id=''52''multiplyconversion=''1''seqno=''1''reference_id=''0''bpartner_id=''''isreconciled=''''bankreconcilation_id=''''transtype=''''linedesc=''paysalary''reconciledate=''''branch_id=''1''track_id1=''''track_id2=''''track_id3=''''created=''2010-08-28 17:50:35''createdby=''1''row_typeline=''1''temp_parent_id=''1', 'I', 1, '2010-08-28 17:50:35', 19, 'S', 'admin', 16, '::1', 'trans_id', '0'),
('sim_simbiz_transaction', 'batch_id=''1''document_no=''''amt=''30''originalamt=''30''tax_id=''''currency_id=''3''document_no2=''MBB823233''accounts_id=''50''multiplyconversion=''1''seqno=''4''reference_id=''0''bpartner_id=''''isreconciled=''''bankreconcilation_id=''''transtype=''''linedesc=''Transfer fund from place 1 to 2''reconciledate=''''branch_id=''1''track_id1=''0''track_id2=''''track_id3=''''created=''2010-08-28 17:50:35''createdby=''1''row_typeline=''1''temp_parent_id=''2', 'I', 1, '2010-08-28 17:50:35', 20, 'S', 'admin', 17, '::1', 'trans_id', '0'),
('sim_simbiz_transaction', 'batch_id=''1''document_no=''''amt=''10''originalamt=''10''tax_id=''''currency_id=''3''document_no2=''''accounts_id=''45''multiplyconversion=''1''seqno=''2''reference_id=''19''bpartner_id=''''isreconciled=''''bankreconcilation_id=''''transtype=''''linedesc=''''reconciledate=''''branch_id=''1''track_id1=''''track_id2=''''track_id3=''''created=''2010-08-28 17:50:35''createdby=''1''row_typeline=''2''temp_parent_id=''1', 'I', 1, '2010-08-28 17:50:35', 21, 'S', 'admin', 18, '::1', 'trans_id', '0'),
('sim_simbiz_transaction', 'batch_id=''1''document_no=''''amt=''10''originalamt=''10''tax_id=''''currency_id=''3''document_no2=''''accounts_id=''46''multiplyconversion=''1''seqno=''3''reference_id=''19''bpartner_id=''''isreconciled=''''bankreconcilation_id=''''transtype=''''linedesc=''''reconciledate=''''branch_id=''1''track_id1=''''track_id2=''''track_id3=''''created=''2010-08-28 17:50:35''createdby=''1''row_typeline=''2''temp_parent_id=''1', 'I', 1, '2010-08-28 17:50:35', 22, 'S', 'admin', 19, '::1', 'trans_id', '0'),
('sim_simbiz_transaction', 'batch_id=''1''document_no=''''amt=''-30.00''originalamt=''-30.00''tax_id=''''currency_id=''3''document_no2=''''accounts_id=''52''multiplyconversion=''1''seqno=''5''reference_id=''20''bpartner_id=''''isreconciled=''''bankreconcilation_id=''''transtype=''''linedesc=''''reconciledate=''''branch_id=''1''track_id1=''''track_id2=''''track_id3=''''created=''2010-08-28 17:50:35''createdby=''1''row_typeline=''2''temp_parent_id=''2', 'I', 1, '2010-08-28 17:50:35', 23, 'S', 'admin', 20, '::1', 'trans_id', '0'),
('sim_simbiz_batch', 'description=''f werrt''', 'U', 1, '2010-08-28 17:50:46', 1, 'S', 'admin', 21, '::1', 'batch_id', '1'),
('sim_simbiz_batch', 'description=''Sample''', 'U', 1, '2010-08-28 17:50:56', 1, 'S', 'admin', 22, '::1', 'batch_id', '1'),
('sim_simbiz_batch', 'batchno=''201008001''', 'U', 1, '2010-08-28 17:51:16', 1, 'S', 'admin', 23, '::1', 'batch_id', '201008001'),
('sim_simbiz_batch', 'iscomplete=''1''', 'U', 1, '2010-08-28 17:51:26', 1, 'S', 'admin', 24, '::1', 'batch_id', '201008001'),
('sim_simbiz_transaction', 'document_no=''-'',<br/>isreconciled='''',<br/>bankreconcilation_id='''',<br/>reconciledate=''''', 'U', 1, '2010-08-28 17:51:26', 19, 'S', 'admin', 25, '::1', 'trans_id', '19'),
('sim_simbiz_transaction', 'document_no=''-'',<br/>isreconciled='''',<br/>bankreconcilation_id='''',<br/>reconciledate=''''', 'U', 1, '2010-08-28 17:51:26', 21, 'S', 'admin', 26, '::1', 'trans_id', '21'),
('sim_simbiz_transaction', 'document_no=''-'',<br/>isreconciled='''',<br/>bankreconcilation_id='''',<br/>reconciledate=''''', 'U', 1, '2010-08-28 17:51:26', 22, 'S', 'admin', 27, '::1', 'trans_id', '22'),
('sim_simbiz_transaction', 'document_no=''-'',<br/>isreconciled='''',<br/>bankreconcilation_id='''',<br/>reconciledate=''''', 'U', 1, '2010-08-28 17:51:27', 20, 'S', 'admin', 28, '::1', 'trans_id', '20'),
('sim_simbiz_transaction', 'document_no=''-'',<br/>isreconciled='''',<br/>bankreconcilation_id='''',<br/>reconciledate=''''', 'U', 1, '2010-08-28 17:51:27', 23, 'S', 'admin', 29, '::1', 'trans_id', '23'),
('sim_simbiz_batch', 'period_id=''8''batchno=''201008002''batch_name=''sadadeewr''batchdate=''2010-08-19''description=''qweqwhj''totaldebit=''400.00''totalcredit=''400.00''created=''10/08/28 17:54:02''createdby=''admin(1)''updated=''10/08/28 17:54:02''updatedby=''admin(1)''organization_id=''1''tax_type=''1''reuse=''0''track1_name=''Consultant''track2_name=''Salesman''track3_name=''Others', 'I', 1, '2010-08-28 17:54:02', 2, 'S', 'admin', 30, '::1', 'batch_id', '201008002'),
('sim_simbiz_transaction', 'batch_id=''2''document_no=''''amt=''-400''originalamt=''-400''tax_id=''''currency_id=''3''document_no2=''''accounts_id=''31''multiplyconversion=''1''seqno=''1''reference_id=''0''bpartner_id=''''isreconciled=''''bankreconcilation_id=''''transtype=''''linedesc=''''reconciledate=''''branch_id=''1''track_id1=''''track_id2=''''track_id3=''''created=''2010-08-28 17:54:02''createdby=''1''row_typeline=''1''temp_parent_id=''1', 'I', 1, '2010-08-28 17:54:02', 24, 'S', 'admin', 31, '::1', 'trans_id', '0'),
('sim_simbiz_transaction', 'batch_id=''2''document_no=''''amt=''400''originalamt=''400''tax_id=''''currency_id=''3''document_no2=''''accounts_id=''52''multiplyconversion=''1''seqno=''2''reference_id=''24''bpartner_id=''''isreconciled=''''bankreconcilation_id=''''transtype=''''linedesc=''''reconciledate=''''branch_id=''1''track_id1=''''track_id2=''''track_id3=''''created=''2010-08-28 17:54:02''createdby=''1''row_typeline=''2''temp_parent_id=''1', 'I', 1, '2010-08-28 17:54:02', 25, 'S', 'admin', 32, '::1', 'trans_id', '0'),
('sim_simbiz_batch', 'iscomplete=''1''', 'U', 1, '2010-08-28 17:54:06', 2, 'S', 'admin', 33, '::1', 'batch_id', '201008002');

-- --------------------------------------------------------

--
-- Table structure for table `sim_avatar`
--

CREATE TABLE IF NOT EXISTS `sim_avatar` (
  `avatar_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `avatar_file` varchar(30) NOT NULL DEFAULT '',
  `avatar_name` varchar(100) NOT NULL DEFAULT '',
  `avatar_mimetype` varchar(30) NOT NULL DEFAULT '',
  `avatar_created` int(10) NOT NULL DEFAULT '0',
  `avatar_display` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `avatar_weight` smallint(5) unsigned NOT NULL DEFAULT '0',
  `avatar_type` char(1) NOT NULL DEFAULT '',
  PRIMARY KEY (`avatar_id`),
  KEY `avatar_type` (`avatar_type`,`avatar_display`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `sim_avatar`
--


-- --------------------------------------------------------

--
-- Table structure for table `sim_avatar_user_link`
--

CREATE TABLE IF NOT EXISTS `sim_avatar_user_link` (
  `avatar_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `user_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  KEY `avatar_user_id` (`avatar_id`,`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sim_avatar_user_link`
--


-- --------------------------------------------------------

--
-- Table structure for table `sim_banner`
--

CREATE TABLE IF NOT EXISTS `sim_banner` (
  `bid` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `cid` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `imptotal` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `impmade` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `clicks` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `imageurl` varchar(255) NOT NULL DEFAULT '',
  `clickurl` varchar(255) NOT NULL DEFAULT '',
  `date` int(10) NOT NULL DEFAULT '0',
  `htmlbanner` tinyint(1) NOT NULL DEFAULT '0',
  `htmlcode` text,
  PRIMARY KEY (`bid`),
  KEY `idxbannercid` (`cid`),
  KEY `idxbannerbidcid` (`bid`,`cid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `sim_banner`
--

INSERT INTO `sim_banner` (`bid`, `cid`, `imptotal`, `impmade`, `clicks`, `imageurl`, `clickurl`, `date`, `htmlbanner`, `htmlcode`) VALUES
(1, 1, 0, 162453, 0, 'http://localhost/simtrain/images/banners/xoops_banner.gif', 'http://www.xoops.org/', 1008813250, 0, ''),
(2, 1, 0, 163050, 0, 'http://localhost/simtrain/images/banners/xoops_banner_2.gif', 'http://www.xoops.org/', 1008813250, 0, ''),
(3, 1, 0, 161579, 0, 'http://localhost/simtrain/images/banners/banner.swf', 'http://www.xoops.org/', 1008813250, 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `sim_bannerclient`
--

CREATE TABLE IF NOT EXISTS `sim_bannerclient` (
  `cid` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(60) NOT NULL DEFAULT '',
  `contact` varchar(60) NOT NULL DEFAULT '',
  `email` varchar(60) NOT NULL DEFAULT '',
  `login` varchar(10) NOT NULL DEFAULT '',
  `passwd` varchar(10) NOT NULL DEFAULT '',
  `extrainfo` text,
  PRIMARY KEY (`cid`),
  KEY `login` (`login`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `sim_bannerclient`
--

INSERT INTO `sim_bannerclient` (`cid`, `name`, `contact`, `email`, `login`, `passwd`, `extrainfo`) VALUES
(1, 'XOOPS', 'XOOPS Dev Team', 'webmaster@xoops.org', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `sim_bannerfinish`
--

CREATE TABLE IF NOT EXISTS `sim_bannerfinish` (
  `bid` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `cid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `impressions` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `clicks` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `datestart` int(10) unsigned NOT NULL DEFAULT '0',
  `dateend` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`bid`),
  KEY `cid` (`cid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `sim_bannerfinish`
--


-- --------------------------------------------------------

--
-- Table structure for table `sim_block_module_link`
--

CREATE TABLE IF NOT EXISTS `sim_block_module_link` (
  `block_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `module_id` smallint(5) NOT NULL DEFAULT '0',
  PRIMARY KEY (`module_id`,`block_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sim_block_module_link`
--

INSERT INTO `sim_block_module_link` (`block_id`, `module_id`) VALUES
(13, -1),
(20, -1),
(21, -1),
(22, -1),
(23, -1),
(24, -1),
(25, -1),
(46, -1),
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
-- Table structure for table `sim_bpartner`
--

CREATE TABLE IF NOT EXISTS `sim_bpartner` (
  `bpartner_id` int(11) NOT NULL AUTO_INCREMENT,
  `bpartnergroup_id` int(11) NOT NULL,
  `bpartner_no` varchar(10) NOT NULL,
  `bpartner_name` varchar(50) NOT NULL,
  `isactive` smallint(6) NOT NULL,
  `seqno` smallint(6) NOT NULL,
  `created` datetime NOT NULL,
  `createdby` int(11) NOT NULL,
  `updated` datetime NOT NULL,
  `updatedby` int(11) NOT NULL,
  `currency_id` int(11) NOT NULL,
  `terms_id` int(11) NOT NULL,
  `salescreditlimit` decimal(12,2) NOT NULL,
  `organization_id` int(11) NOT NULL,
  `bpartner_url` varchar(100) NOT NULL,
  `debtoraccounts_id` int(11) NOT NULL,
  `description` text NOT NULL,
  `shortremarks` varchar(100) NOT NULL,
  `tax_id` int(11) NOT NULL,
  `currentbalance` decimal(12,2) NOT NULL,
  `creditoraccounts_id` int(11) NOT NULL,
  `isdebtor` smallint(1) NOT NULL,
  `iscreditor` smallint(1) NOT NULL,
  `istransporter` smallint(1) NOT NULL,
  `purchasecreditlimit` decimal(14,2) NOT NULL,
  `enforcesalescreditlimit` smallint(1) NOT NULL,
  `enforcepurchasecreditlimit` smallint(1) NOT NULL,
  `currentsalescreditstatus` decimal(14,2) NOT NULL,
  `currentpurchasecreditstatus` decimal(14,2) NOT NULL,
  `bankaccountname` varchar(50) NOT NULL,
  `bankname` varchar(30) NOT NULL,
  `bankaccountno` varchar(30) NOT NULL,
  `isdealer` smallint(1) NOT NULL,
  `isprospect` smallint(1) NOT NULL,
  `employeecount` int(11) NOT NULL,
  `alternatename` varchar(40) NOT NULL,
  `companyno` varchar(20) NOT NULL,
  `industry_id` int(11) NOT NULL,
  `tooltips` varchar(255) NOT NULL,
  `salespricelist_id` int(11) NOT NULL,
  `purchasepricelist_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `inchargeperson` varchar(35) NOT NULL,
  `isdeleted` smallint(6) NOT NULL,
  PRIMARY KEY (`bpartner_id`),
  UNIQUE KEY `bpartner_no` (`bpartner_no`,`organization_id`),
  KEY `bpartnergroup_id` (`bpartnergroup_id`),
  KEY `currency_id` (`currency_id`),
  KEY `terms_id` (`terms_id`),
  KEY `organization_id` (`organization_id`),
  KEY `tax_id` (`tax_id`),
  KEY `creditoraccounts_id` (`creditoraccounts_id`),
  KEY `debtoraccounts_id` (`debtoraccounts_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `sim_bpartner`
--

INSERT INTO `sim_bpartner` (`bpartner_id`, `bpartnergroup_id`, `bpartner_no`, `bpartner_name`, `isactive`, `seqno`, `created`, `createdby`, `updated`, `updatedby`, `currency_id`, `terms_id`, `salescreditlimit`, `organization_id`, `bpartner_url`, `debtoraccounts_id`, `description`, `shortremarks`, `tax_id`, `currentbalance`, `creditoraccounts_id`, `isdebtor`, `iscreditor`, `istransporter`, `purchasecreditlimit`, `enforcesalescreditlimit`, `enforcepurchasecreditlimit`, `currentsalescreditstatus`, `currentpurchasecreditstatus`, `bankaccountname`, `bankname`, `bankaccountno`, `isdealer`, `isprospect`, `employeecount`, `alternatename`, `companyno`, `industry_id`, `tooltips`, `salespricelist_id`, `purchasepricelist_id`, `employee_id`, `inchargeperson`, `isdeleted`) VALUES
(0, 0, '', '', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, 0, 0, '0.00', 0, '', 0, '', '', 0, '0.00', 0, 0, 0, 0, '0.00', 0, 0, '0.00', '0.00', '', '', '', 0, 0, 0, '', '', 0, '', 0, 0, 0, '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `sim_bpartnergroup`
--

CREATE TABLE IF NOT EXISTS `sim_bpartnergroup` (
  `bpartnergroup_id` int(11) NOT NULL AUTO_INCREMENT,
  `bpartnergroup_name` varchar(50) NOT NULL,
  `isactive` smallint(6) NOT NULL,
  `seqno` smallint(6) NOT NULL,
  `created` datetime NOT NULL,
  `createdby` int(11) NOT NULL,
  `updated` datetime NOT NULL,
  `updatedby` int(11) NOT NULL,
  `organization_id` int(11) NOT NULL,
  `description` varchar(100) NOT NULL,
  `debtoraccounts_id` int(11) NOT NULL,
  `creditoraccounts_id` int(11) NOT NULL,
  `isdeleted` smallint(6) NOT NULL,
  PRIMARY KEY (`bpartnergroup_id`),
  UNIQUE KEY `bpartnergroup_name` (`bpartnergroup_name`),
  KEY `organization_id` (`organization_id`),
  KEY `accounts_id` (`debtoraccounts_id`),
  KEY `creditoraccounts_id` (`creditoraccounts_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `sim_bpartnergroup`
--

INSERT INTO `sim_bpartnergroup` (`bpartnergroup_id`, `bpartnergroup_name`, `isactive`, `seqno`, `created`, `createdby`, `updated`, `updatedby`, `organization_id`, `description`, `debtoraccounts_id`, `creditoraccounts_id`, `isdeleted`) VALUES
(0, '', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, 0, '', 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `sim_cache_model`
--

CREATE TABLE IF NOT EXISTS `sim_cache_model` (
  `cache_key` varchar(64) NOT NULL DEFAULT '',
  `cache_expires` int(10) unsigned NOT NULL DEFAULT '0',
  `cache_data` text,
  PRIMARY KEY (`cache_key`),
  KEY `cache_expires` (`cache_expires`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sim_cache_model`
--


-- --------------------------------------------------------

--
-- Table structure for table `sim_config`
--

CREATE TABLE IF NOT EXISTS `sim_config` (
  `conf_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `conf_modid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `conf_catid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `conf_name` varchar(25) NOT NULL DEFAULT '',
  `conf_title` varchar(255) NOT NULL DEFAULT '',
  `conf_value` text,
  `conf_desc` varchar(255) NOT NULL DEFAULT '',
  `conf_formtype` varchar(15) NOT NULL DEFAULT '',
  `conf_valuetype` varchar(10) NOT NULL DEFAULT '',
  `conf_order` smallint(5) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`conf_id`),
  KEY `conf_mod_cat_id` (`conf_modid`,`conf_catid`),
  KEY `conf_order` (`conf_order`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=299 ;

--
-- Dumping data for table `sim_config`
--

INSERT INTO `sim_config` (`conf_id`, `conf_modid`, `conf_catid`, `conf_name`, `conf_title`, `conf_value`, `conf_desc`, `conf_formtype`, `conf_valuetype`, `conf_order`) VALUES
(1, 0, 1, 'sitename', '_MD_AM_SITENAME', 'HIUMEN', '_MD_AM_SITENAMEDSC', 'textbox', 'text', 0),
(2, 0, 1, 'slogan', '_MD_AM_SLOGAN', 'Because Of You, We Are Here', '_MD_AM_SLOGANDSC', 'textbox', 'text', 2),
(3, 0, 1, 'language', '_MD_AM_LANGUAGE', 'english', '_MD_AM_LANGUAGEDSC', 'language', 'other', 4),
(4, 0, 1, 'startpage', '_MD_AM_STARTPAGE', 'bpartner', '_MD_AM_STARTPAGEDSC', 'startpage', 'other', 6),
(5, 0, 1, 'server_TZ', '_MD_AM_SERVERTZ', '8', '_MD_AM_SERVERTZDSC', 'timezone', 'float', 8),
(6, 0, 1, 'default_TZ', '_MD_AM_DEFAULTTZ', '8', '_MD_AM_DEFAULTTZDSC', 'timezone', 'float', 10),
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
(27, 0, 2, 'avatar_width', '_MD_AM_AVATARW', '120', '_MD_AM_AVATARWDSC', 'textbox', 'int', 16),
(28, 0, 2, 'avatar_height', '_MD_AM_AVATARH', '120', '_MD_AM_AVATARHDSC', 'textbox', 'int', 18),
(29, 0, 2, 'avatar_maxsize', '_MD_AM_AVATARMAX', '35000', '_MD_AM_AVATARMAXDSC', 'textbox', 'int', 20),
(30, 0, 1, 'adminmail', '_MD_AM_ADMINML', 'admin@hiumen.com', '_MD_AM_ADMINMLDSC', 'textbox', 'text', 3),
(31, 0, 2, 'self_delete', '_MD_AM_SELFDELETE', '0', '_MD_AM_SELFDELETEDSC', 'yesno', 'int', 22),
(32, 0, 1, 'com_mode', '_MD_AM_COMMODE', 'nest', '_MD_AM_COMMODEDSC', 'select', 'text', 34),
(33, 0, 1, 'com_order', '_MD_AM_COMORDER', '0', '_MD_AM_COMORDERDSC', 'select', 'int', 36),
(34, 0, 2, 'bad_unames', '_MD_AM_BADUNAMES', 'a:3:{i:0;s:9:"webmaster";i:1;s:6:"^xoops";i:2;s:6:"^admin";}', '_MD_AM_BADUNAMESDSC', 'textarea', 'array', 24),
(35, 0, 2, 'bad_emails', '_MD_AM_BADEMAILS', 'a:1:{i:0;s:10:"xoops.org$";}', '_MD_AM_BADEMAILSDSC', 'textarea', 'array', 26),
(36, 0, 2, 'maxuname', '_MD_AM_MAXUNAME', '10', '_MD_AM_MAXUNAMEDSC', 'textbox', 'int', 3),
(37, 0, 1, 'bad_ips', '_MD_AM_BADIPS', 'a:1:{i:0;s:9:"127.0.0.1";}', '_MD_AM_BADIPSDSC', 'textarea', 'array', 42),
(38, 0, 3, 'meta_keywords', '_MD_AM_METAKEY', '', '_MD_AM_METAKEYDSC', 'textarea', 'text', 0),
(39, 0, 3, 'footer', '_MD_AM_FOOTER', 'Powered by <a href="http://www.simit.com.my/" target="_blank">SIMIT</a> @ 2010 <a href="http://www.hiumen.com/" target="_blank">The HIUMEN Project</a>', '_MD_AM_FOOTERDSC', 'textarea', 'text', 20),
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
(50, 0, 3, 'meta_copyright', '_MD_AM_METACOPYR', 'Copyright @ 2010', '_MD_AM_METACOPYRDSC', 'textbox', 'text', 8),
(51, 0, 3, 'meta_description', '_MD_AM_METADESC', 'HIUMEN Project', '_MD_AM_METADESCDSC', 'textarea', 'text', 1),
(52, 0, 2, 'allow_chgmail', '_MD_AM_ALLWCHGMAIL', '0', '_MD_AM_ALLWCHGMAILDSC', 'yesno', 'int', 3),
(53, 0, 1, 'use_mysession', '_MD_AM_USEMYSESS', '0', '_MD_AM_USEMYSESSDSC', 'yesno', 'int', 19),
(54, 0, 2, 'reg_dispdsclmr', '_MD_AM_DSPDSCLMR', '1', '_MD_AM_DSPDSCLMRDSC', 'yesno', 'int', 30),
(55, 0, 2, 'reg_disclaimer', '_MD_AM_REGDSCLMR', 'While the administrators and moderators of this site will attempt to remove\r\nor edit any generally objectionable material as quickly as possible, it is\r\nimpossible to review every message. Therefore you acknowledge that all posts\r\nmade to this site express the views and opinions of the author and not the\r\nadministrators, moderators or webmaster (except for posts by these people)\r\nand hence will not be held liable.\r\n\r\nYou agree not to post any abusive, obscene, vulgar, slanderous, hateful,\r\nthreatening, sexually-orientated or any other material that may violate any\r\napplicable laws. Doing so may lead to you being immediately and permanently\r\nbanned (and your service provider being informed). The IP address of all\r\nposts is recorded to aid in enforcing these conditions. Creating multiple\r\naccounts for a single user is not allowed. You agree that the webmaster,\r\nadministrator and moderators of this site have the right to remove, edit,\r\nmove or close any topic at any time should they see fit. As a user you agree\r\nto any information you have entered above being stored in a database. While\r\nthis information will not be disclosed to any third party without your\r\nconsent the webmaster, administrator and moderators cannot be held\r\nresponsible for any hacking attempt that may lead to the data being\r\ncompromised.\r\n\r\nThis site system uses cookies to store information on your local computer.\r\nThese cookies do not contain any of the information you have entered above,\r\nthey serve only to improve your viewing pleasure. The email address is used\r\nonly for confirming your registration details and password (and for sending\r\nnew passwords should you forget your current one).\r\n\r\nBy clicking Register below you agree to be bound by these conditions.', '_MD_AM_REGDSCLMRDSC', 'textarea', 'text', 32),
(56, 0, 2, 'allow_register', '_MD_AM_ALLOWREG', '1', '_MD_AM_ALLOWREGDSC', 'yesno', 'int', 0),
(57, 0, 1, 'theme_fromfile', '_MD_AM_THEMEFILE', '0', '_MD_AM_THEMEFILEDSC', 'yesno', 'int', 13),
(58, 0, 1, 'closesite', '_MD_AM_CLOSESITE', '0', '_MD_AM_CLOSESITEDSC', 'yesno', 'int', 26),
(59, 0, 1, 'closesite_okgrp', '_MD_AM_CLOSESITEOK', 'a:1:{i:0;s:1:"1";}', '_MD_AM_CLOSESITEOKDSC', 'group_multi', 'array', 27),
(60, 0, 1, 'closesite_text', '_MD_AM_CLOSESITETXT', 'The site is currently closed for maintenance. Please come back later.', '_MD_AM_CLOSESITETXTDSC', 'textarea', 'text', 28),
(61, 0, 1, 'sslpost_name', '_MD_AM_SSLPOST', 'xoops_ssl', '_MD_AM_SSLPOSTDSC', 'textbox', 'text', 31),
(62, 0, 1, 'module_cache', '_MD_AM_MODCACHE', 'a:6:{i:61;s:1:"0";i:2;s:1:"0";i:3;s:1:"0";i:66;s:1:"0";i:70;s:1:"0";i:68;s:1:"0";}', '_MD_AM_MODCACHEDSC', 'module_cache', 'array', 50),
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
(82, 0, 7, 'ldap_loginname_asdn', '_MD_AM_LDAP_LOGINNAME_ASDN', '0', '_MD_AM_LDAP_LOGINNAME_ASDN_D', 'yesno', 'int', 9),
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
(93, 0, 7, 'ldap_use_TLS', '_MD_AM_LDAP_USETLS', '0', '_MD_AM_LDAP_USETLS_DESC', 'yesno', 'int', 20),
(94, 0, 1, 'cpanel', '_MD_AM_CPANEL', 'oxygen', '_MD_AM_CPANELDSC', 'cpanel', 'other', 11),
(95, 0, 2, 'welcome_type', '_MD_AM_WELCOMETYPE', '1', '_MD_AM_WELCOMETYPE_DESC', 'select', 'int', 3),
(96, 2, 0, 'perpage', '_PM_MI_PERPAGE', '20', '_PM_MI_PERPAGE_DESC', 'textbox', 'int', 0),
(97, 2, 0, 'max_save', '_PM_MI_MAXSAVE', '10', '_PM_MI_MAXSAVE_DESC', 'textbox', 'int', 1),
(98, 2, 0, 'prunesubject', '_PM_MI_PRUNESUBJECT', 'Messages deleted during cleanup', '_PM_MI_PRUNESUBJECT_DESC', 'textbox', 'text', 2),
(99, 2, 0, 'prunemessage', '_PM_MI_PRUNEMESSAGE', 'During a cleanup of the Private Messaging, we have deleted {PM_COUNT} of the messages in your inbox to save space and resources', '_PM_MI_PRUNEMESSAGE_DESC', 'textarea', 'text', 3),
(100, 3, 0, 'profile_search', '_PROFILE_MI_PROFILE_SEARCH', '1', '', 'yesno', 'int', 0),
(101, 4, 0, 'global_disabled', '_MI_PROTECTOR_GLOBAL_DISBL', '0', '_MI_PROTECTOR_GLOBAL_DISBLDSC', 'yesno', 'int', 0),
(102, 4, 0, 'default_lang', '_MI_PROTECTOR_DEFAULT_LANG', 'english', '_MI_PROTECTOR_DEFAULT_LANGDSC', 'text', 'text', 1),
(103, 4, 0, 'log_level', '_MI_PROTECTOR_LOG_LEVEL', '255', '', 'select', 'int', 2),
(104, 4, 0, 'banip_time0', '_MI_PROTECTOR_BANIP_TIME0', '86400', '', 'text', 'int', 3),
(105, 4, 0, 'reliable_ips', '_MI_PROTECTOR_RELIABLE_IPS', 'a:2:{i:0;s:9:"^192.168.";i:1;s:9:"127.0.0.1";}', '_MI_PROTECTOR_RELIABLE_IPSDSC', 'textarea', 'array', 4),
(106, 4, 0, 'session_fixed_topbit', '_MI_PROTECTOR_HIJACK_TOPBIT', '24', '_MI_PROTECTOR_HIJACK_TOPBITDSC', 'text', 'int', 5),
(107, 4, 0, 'groups_denyipmove', '_MI_PROTECTOR_HIJACK_DENYGP', 'a:1:{i:0;i:1;}', '_MI_PROTECTOR_HIJACK_DENYGPDSC', 'group_multi', 'array', 6),
(108, 4, 0, 'san_nullbyte', '_MI_PROTECTOR_SAN_NULLBYTE', '1', '_MI_PROTECTOR_SAN_NULLBYTEDSC', 'yesno', 'int', 7),
(109, 4, 0, 'die_badext', '_MI_PROTECTOR_DIE_BADEXT', '1', '_MI_PROTECTOR_DIE_BADEXTDSC', 'yesno', 'int', 8),
(110, 4, 0, 'contami_action', '_MI_PROTECTOR_CONTAMI_ACTION', '3', '_MI_PROTECTOR_CONTAMI_ACTIONDS', 'select', 'int', 9),
(111, 4, 0, 'isocom_action', '_MI_PROTECTOR_ISOCOM_ACTION', '0', '_MI_PROTECTOR_ISOCOM_ACTIONDSC', 'select', 'int', 10),
(112, 4, 0, 'union_action', '_MI_PROTECTOR_UNION_ACTION', '0', '_MI_PROTECTOR_UNION_ACTIONDSC', 'select', 'int', 11),
(113, 4, 0, 'id_forceintval', '_MI_PROTECTOR_ID_INTVAL', '0', '_MI_PROTECTOR_ID_INTVALDSC', 'yesno', 'int', 12),
(114, 4, 0, 'file_dotdot', '_MI_PROTECTOR_FILE_DOTDOT', '1', '_MI_PROTECTOR_FILE_DOTDOTDSC', 'yesno', 'int', 13),
(115, 4, 0, 'bf_count', '_MI_PROTECTOR_BF_COUNT', '10', '_MI_PROTECTOR_BF_COUNTDSC', 'text', 'int', 14),
(116, 4, 0, 'bwlimit_count', '_MI_PROTECTOR_BWLIMIT_COUNT', '0', '_MI_PROTECTOR_BWLIMIT_COUNTDSC', 'text', 'int', 15),
(117, 4, 0, 'dos_skipmodules', '_MI_PROTECTOR_DOS_SKIPMODS', '', '_MI_PROTECTOR_DOS_SKIPMODSDSC', 'text', 'text', 16),
(118, 4, 0, 'dos_expire', '_MI_PROTECTOR_DOS_EXPIRE', '60', '_MI_PROTECTOR_DOS_EXPIREDSC', 'text', 'int', 17),
(119, 4, 0, 'dos_f5count', '_MI_PROTECTOR_DOS_F5COUNT', '20', '_MI_PROTECTOR_DOS_F5COUNTDSC', 'text', 'int', 18),
(120, 4, 0, 'dos_f5action', '_MI_PROTECTOR_DOS_F5ACTION', 'exit', '', 'select', 'text', 19),
(121, 4, 0, 'dos_crcount', '_MI_PROTECTOR_DOS_CRCOUNT', '40', '_MI_PROTECTOR_DOS_CRCOUNTDSC', 'text', 'int', 20),
(122, 4, 0, 'dos_craction', '_MI_PROTECTOR_DOS_CRACTION', 'exit', '', 'select', 'text', 21),
(123, 4, 0, 'dos_crsafe', '_MI_PROTECTOR_DOS_CRSAFE', '/(msnbot|Googlebot|Yahoo! Slurp)/i', '_MI_PROTECTOR_DOS_CRSAFEDSC', 'text', 'text', 22),
(124, 4, 0, 'bip_except', '_MI_PROTECTOR_BIP_EXCEPT', 'a:1:{i:0;i:1;}', '_MI_PROTECTOR_BIP_EXCEPTDSC', 'group_multi', 'array', 23),
(125, 4, 0, 'disable_features', '_MI_PROTECTOR_DISABLES', '1', '', 'select', 'int', 24),
(126, 4, 0, 'enable_dblayertrap', '_MI_PROTECTOR_DBLAYERTRAP', '1', '_MI_PROTECTOR_DBLAYERTRAPDSC', 'yesno', 'int', 25),
(127, 4, 0, 'dblayertrap_wo_server', '_MI_PROTECTOR_DBTRAPWOSRV', '0', '_MI_PROTECTOR_DBTRAPWOSRVDSC', 'yesno', 'int', 26),
(128, 4, 0, 'enable_bigumbrella', '_MI_PROTECTOR_BIGUMBRELLA', '1', '_MI_PROTECTOR_BIGUMBRELLADSC', 'yesno', 'int', 27),
(129, 4, 0, 'spamcount_uri4user', '_MI_PROTECTOR_SPAMURI4U', '0', '_MI_PROTECTOR_SPAMURI4UDSC', 'textbox', 'int', 28),
(130, 4, 0, 'spamcount_uri4guest', '_MI_PROTECTOR_SPAMURI4G', '5', '_MI_PROTECTOR_SPAMURI4GDSC', 'textbox', 'int', 29);

-- --------------------------------------------------------

--
-- Table structure for table `sim_configcategory`
--

CREATE TABLE IF NOT EXISTS `sim_configcategory` (
  `confcat_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `confcat_name` varchar(255) NOT NULL DEFAULT '',
  `confcat_order` smallint(5) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`confcat_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `sim_configcategory`
--

INSERT INTO `sim_configcategory` (`confcat_id`, `confcat_name`, `confcat_order`) VALUES
(1, '_MD_AM_GENERAL', 0),
(2, '_MD_AM_USERSETTINGS', 0),
(3, '_MD_AM_METAFOOTER', 0),
(4, '_MD_AM_CENSOR', 0),
(5, '_MD_AM_SEARCH', 0),
(6, '_MD_AM_MAILER', 0),
(7, '_MD_AM_AUTHENTICATION', 0);

-- --------------------------------------------------------

--
-- Table structure for table `sim_configoption`
--

CREATE TABLE IF NOT EXISTS `sim_configoption` (
  `confop_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `confop_name` varchar(255) NOT NULL DEFAULT '',
  `confop_value` varchar(255) NOT NULL DEFAULT '',
  `conf_id` smallint(5) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`confop_id`),
  KEY `conf_id` (`conf_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=214 ;

--
-- Dumping data for table `sim_configoption`
--

INSERT INTO `sim_configoption` (`confop_id`, `confop_name`, `confop_value`, `conf_id`) VALUES
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
(30, '_MD_AM_AUTH_CONFOPTION_AD', 'ads', 74),
(31, '_NO', '0', 95),
(32, '_MD_AM_WELCOMETYPE_EMAIL', '1', 95),
(33, '_MD_AM_WELCOMETYPE_PM', '2', 95),
(34, '_MD_AM_WELCOMETYPE_BOTH', '3', 95),
(35, '_MI_PROTECTOR_LOGLEVEL0', '0', 103),
(36, '_MI_PROTECTOR_LOGLEVEL15', '15', 103),
(37, '_MI_PROTECTOR_LOGLEVEL63', '63', 103),
(38, '_MI_PROTECTOR_LOGLEVEL255', '255', 103),
(39, '_MI_PROTECTOR_OPT_NONE', '0', 110),
(40, '_MI_PROTECTOR_OPT_EXIT', '3', 110),
(41, '_MI_PROTECTOR_OPT_BIPTIME0', '7', 110),
(42, '_MI_PROTECTOR_OPT_BIP', '15', 110),
(43, '_MI_PROTECTOR_OPT_NONE', '0', 111),
(44, '_MI_PROTECTOR_OPT_SAN', '1', 111),
(45, '_MI_PROTECTOR_OPT_EXIT', '3', 111),
(46, '_MI_PROTECTOR_OPT_BIPTIME0', '7', 111),
(47, '_MI_PROTECTOR_OPT_BIP', '15', 111),
(48, '_MI_PROTECTOR_OPT_NONE', '0', 112),
(49, '_MI_PROTECTOR_OPT_SAN', '1', 112),
(50, '_MI_PROTECTOR_OPT_EXIT', '3', 112),
(51, '_MI_PROTECTOR_OPT_BIPTIME0', '7', 112),
(52, '_MI_PROTECTOR_OPT_BIP', '15', 112),
(53, '_MI_PROTECTOR_DOSOPT_NONE', 'none', 120),
(54, '_MI_PROTECTOR_DOSOPT_SLEEP', 'sleep', 120),
(55, '_MI_PROTECTOR_DOSOPT_EXIT', 'exit', 120),
(56, '_MI_PROTECTOR_DOSOPT_BIPTIME0', 'biptime0', 120),
(57, '_MI_PROTECTOR_DOSOPT_BIP', 'bip', 120),
(58, '_MI_PROTECTOR_DOSOPT_HTA', 'hta', 120),
(59, '_MI_PROTECTOR_DOSOPT_NONE', 'none', 122),
(60, '_MI_PROTECTOR_DOSOPT_SLEEP', 'sleep', 122),
(61, '_MI_PROTECTOR_DOSOPT_EXIT', 'exit', 122),
(62, '_MI_PROTECTOR_DOSOPT_BIPTIME0', 'biptime0', 122),
(63, '_MI_PROTECTOR_DOSOPT_BIP', 'bip', 122),
(64, '_MI_PROTECTOR_DOSOPT_HTA', 'hta', 122),
(65, 'xmlrpc', '1', 125),
(66, 'xmlrpc + 2.0.9.2 bugs', '1025', 125),
(67, '_NONE', '0', 125);

-- --------------------------------------------------------

--
-- Table structure for table `sim_contacts`
--

CREATE TABLE IF NOT EXISTS `sim_contacts` (
  `contacts_id` int(11) NOT NULL AUTO_INCREMENT,
  `contacts_name` varchar(60) NOT NULL,
  `alternatename` varchar(60) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `greeting` varchar(40) NOT NULL,
  `email` varchar(60) NOT NULL,
  `hpno` varchar(20) NOT NULL,
  `tel_1` varchar(20) NOT NULL,
  `tel_2` varchar(20) NOT NULL,
  `fax` varchar(20) NOT NULL,
  `address_id` int(11) NOT NULL,
  `position` varchar(30) NOT NULL,
  `department` varchar(30) NOT NULL,
  `uid` int(11) NOT NULL,
  `bpartner_id` int(11) NOT NULL,
  `description` varchar(255) NOT NULL,
  `organization_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `createdby` smallint(6) NOT NULL,
  `updated` datetime NOT NULL,
  `updatedby` smallint(6) NOT NULL,
  `isactive` smallint(1) NOT NULL,
  `seqno` smallint(6) NOT NULL,
  `religion_id` int(11) NOT NULL,
  `races_id` int(11) NOT NULL,
  PRIMARY KEY (`contacts_id`),
  KEY `organization_id` (`organization_id`),
  KEY `address_id` (`address_id`),
  KEY `uid` (`uid`),
  KEY `bpartner_id` (`bpartner_id`),
  KEY `hpno` (`hpno`),
  KEY `contact_name` (`contacts_name`),
  KEY `religion_id` (`religion_id`),
  KEY `races_id` (`races_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `sim_contacts`
--


-- --------------------------------------------------------

--
-- Table structure for table `sim_country`
--

CREATE TABLE IF NOT EXISTS `sim_country` (
  `country_id` int(11) NOT NULL AUTO_INCREMENT,
  `country_code` varchar(20) NOT NULL,
  `country_name` varchar(50) NOT NULL,
  `citizenship` varchar(30) NOT NULL,
  `isactive` smallint(6) NOT NULL,
  `seqno` smallint(6) NOT NULL,
  `created` datetime NOT NULL,
  `createdby` int(11) NOT NULL,
  `updated` datetime NOT NULL,
  `updatedby` int(11) NOT NULL,
  `isdeleted` smallint(1) NOT NULL,
  `organization_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`country_id`),
  UNIQUE KEY `country_code` (`country_code`),
  UNIQUE KEY `citizenship` (`citizenship`),
  UNIQUE KEY `country_name` (`country_name`,`organization_id`),
  KEY `organization_id` (`organization_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `sim_country`
--

INSERT INTO `sim_country` (`country_id`, `country_code`, `country_name`, `citizenship`, `isactive`, `seqno`, `created`, `createdby`, `updated`, `updatedby`, `isdeleted`, `organization_id`) VALUES
(0, '--', '', '', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, 0, 1),
(2, 'SG', 'Singapore', 'Singaporian', 1, 20, '2010-07-25 15:19:14', 1, '2010-07-25 15:19:14', 1, 0, 1),
(3, 'MY', 'Malaysia', 'Malaysian', 1, 10, '2010-07-25 15:19:14', 1, '2010-08-04 10:49:29', 1, 1, 1),
(5, 'TH', 'Thailan', 'Thai', 1, 10, '2010-08-12 17:26:26', 1870, '2010-08-12 17:26:26', 1870, 0, 1),
(6, 'IN', 'Indonesia', 'Indonesian', 1, 10, '2010-08-12 17:26:41', 1870, '2010-08-15 11:31:23', 1, 0, 1),
(7, 'US', 'United States', 'American', 1, 10, '2010-08-12 17:27:03', 1870, '2010-08-12 17:27:03', 1870, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `sim_currency`
--

CREATE TABLE IF NOT EXISTS `sim_currency` (
  `currency_id` int(11) NOT NULL AUTO_INCREMENT,
  `currency_code` varchar(3) NOT NULL,
  `currency_name` varchar(30) NOT NULL,
  `seqno` smallint(6) NOT NULL,
  `isactive` smallint(6) NOT NULL,
  `created` datetime NOT NULL,
  `createdby` int(11) NOT NULL,
  `updated` datetime NOT NULL,
  `updatedby` int(11) NOT NULL,
  `country_id` int(11) NOT NULL,
  `isdeleted` smallint(1) NOT NULL,
  PRIMARY KEY (`currency_id`),
  UNIQUE KEY `currency_code` (`currency_code`),
  KEY `country_id` (`country_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `sim_currency`
--

INSERT INTO `sim_currency` (`currency_id`, `currency_code`, `currency_name`, `seqno`, `isactive`, `created`, `createdby`, `updated`, `updatedby`, `country_id`, `isdeleted`) VALUES
(0, '--', '', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, 0, 0),
(2, 'SGD', 'Singpore Dollar', 20, 1, '2010-07-25 15:19:45', 1, '2010-07-25 15:19:45', 1, 2, 0),
(3, 'MYR', 'Malaysia Ringgit', 10, 1, '2010-07-25 15:19:45', 1, '2010-07-25 15:19:45', 1, 3, 0),
(5, 'US', 'United States Dollar', 10, 1, '2010-08-12 17:27:39', 1870, '2010-08-12 17:27:39', 1870, 7, 0);

-- --------------------------------------------------------

--
-- Table structure for table `sim_followup`
--

CREATE TABLE IF NOT EXISTS `sim_followup` (
  `followup_id` int(11) NOT NULL AUTO_INCREMENT,
  `bpartner_id` int(11) NOT NULL,
  `followuptype_id` int(11) NOT NULL,
  `followup_name` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `issuedate` date NOT NULL,
  `nextfollowupdate` date NOT NULL,
  `contactperson` varchar(40) NOT NULL,
  `contactnumber` varchar(20) NOT NULL,
  `isactive` smallint(6) NOT NULL,
  `created` datetime NOT NULL,
  `createdby` int(11) NOT NULL,
  `updated` datetime NOT NULL,
  `updatedby` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  PRIMARY KEY (`followup_id`),
  KEY `bpartner_id` (`bpartner_id`),
  KEY `followuptype_id` (`followuptype_id`),
  KEY `nextfollowupdate` (`nextfollowupdate`),
  KEY `issuedate` (`issuedate`),
  KEY `employee_id` (`employee_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `sim_followup`
--


-- --------------------------------------------------------

--
-- Table structure for table `sim_followuptype`
--

CREATE TABLE IF NOT EXISTS `sim_followuptype` (
  `followuptype_id` int(11) NOT NULL AUTO_INCREMENT,
  `followuptype_name` varchar(40) NOT NULL,
  `isactive` smallint(6) NOT NULL,
  `seqno` smallint(6) NOT NULL,
  `organization_id` int(11) NOT NULL,
  `description` varchar(255) NOT NULL,
  `created` datetime NOT NULL,
  `createdby` int(11) NOT NULL,
  `updated` datetime NOT NULL,
  `updatedby` int(11) NOT NULL,
  PRIMARY KEY (`followuptype_id`),
  KEY `organization` (`organization_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `sim_followuptype`
--

INSERT INTO `sim_followuptype` (`followuptype_id`, `followuptype_name`, `isactive`, `seqno`, `organization_id`, `description`, `created`, `createdby`, `updated`, `updatedby`) VALUES
(0, '', 0, 0, 0, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `sim_groups`
--

CREATE TABLE IF NOT EXISTS `sim_groups` (
  `groupid` smallint(5) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '',
  `description` text,
  `group_type` varchar(10) NOT NULL DEFAULT '',
  PRIMARY KEY (`groupid`),
  KEY `group_type` (`group_type`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `sim_groups`
--

INSERT INTO `sim_groups` (`groupid`, `name`, `description`, `group_type`) VALUES
(1, 'Webmasters', 'Webmasters of this site', 'Admin'),
(2, 'Registered Users', 'Registered Users Group', 'User'),
(3, 'Anonymous Users', 'Anonymous Users Group', 'Anonymous'),
(4, 'HR Admin', 'HR Admin Users Group', ''),
(5, 'HR Officer', 'HR Officer Users Group', '');

-- --------------------------------------------------------

--
-- Table structure for table `sim_groups_users_link`
--

CREATE TABLE IF NOT EXISTS `sim_groups_users_link` (
  `linkid` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `groupid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `uid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`linkid`),
  KEY `groupid_uid` (`groupid`,`uid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4146 ;

--
-- Dumping data for table `sim_groups_users_link`
--

INSERT INTO `sim_groups_users_link` (`linkid`, `groupid`, `uid`) VALUES
(4145, 2, 1),
(3835, 1, 534),
(4144, 1, 1),
(3527, 2, 3),
(3364, 2, 4),
(251, 2, 6),
(253, 2, 7),
(255, 2, 8),
(257, 2, 9),
(259, 2, 10),
(261, 2, 11),
(263, 2, 12),
(265, 2, 13),
(267, 2, 14),
(269, 2, 15),
(271, 2, 16),
(273, 2, 17),
(275, 2, 18),
(277, 2, 19),
(279, 2, 20),
(281, 2, 21),
(283, 2, 22),
(285, 2, 23),
(287, 2, 24),
(289, 2, 25),
(291, 2, 26),
(293, 2, 27),
(295, 2, 28),
(297, 2, 29),
(299, 2, 30),
(301, 2, 31),
(303, 2, 32),
(305, 2, 33),
(307, 2, 34),
(309, 2, 35),
(311, 2, 36),
(313, 2, 37),
(315, 2, 38),
(317, 2, 39),
(319, 2, 40),
(321, 2, 41),
(323, 2, 42),
(325, 2, 43),
(327, 2, 44),
(329, 2, 45),
(331, 2, 46),
(333, 2, 47),
(335, 2, 48),
(337, 2, 49),
(339, 2, 50),
(341, 2, 51),
(343, 2, 52),
(345, 2, 53),
(347, 2, 54),
(349, 2, 55),
(351, 2, 56),
(353, 2, 57),
(355, 2, 58),
(357, 2, 59),
(359, 2, 60),
(361, 2, 61),
(363, 2, 62),
(365, 2, 63),
(367, 2, 64),
(369, 2, 65),
(371, 2, 66),
(373, 2, 67),
(375, 2, 68),
(377, 2, 69),
(379, 2, 70),
(381, 2, 71),
(383, 2, 72),
(385, 2, 73),
(387, 2, 74),
(389, 2, 75),
(391, 2, 76),
(393, 2, 77),
(395, 2, 78),
(397, 2, 79),
(399, 2, 80),
(401, 2, 81),
(403, 2, 82),
(405, 2, 83),
(407, 2, 84),
(409, 2, 85),
(411, 2, 86),
(413, 2, 87),
(415, 2, 88),
(417, 2, 89),
(419, 2, 90),
(421, 2, 91),
(423, 2, 92),
(425, 2, 93),
(427, 2, 94),
(429, 2, 95),
(431, 2, 96),
(433, 2, 97),
(435, 2, 98),
(437, 2, 99),
(439, 2, 100),
(441, 2, 101),
(443, 2, 102),
(445, 2, 103),
(447, 2, 104),
(449, 2, 105),
(451, 2, 106),
(453, 2, 107),
(455, 2, 108),
(457, 2, 109),
(459, 2, 110),
(461, 2, 111),
(463, 2, 112),
(465, 2, 113),
(467, 2, 114),
(469, 2, 115),
(471, 2, 116),
(473, 2, 117),
(475, 2, 118),
(477, 2, 119),
(479, 2, 120),
(481, 2, 121),
(483, 2, 122),
(485, 2, 123),
(487, 2, 124),
(489, 2, 125),
(491, 2, 126),
(493, 2, 127),
(495, 2, 128),
(497, 2, 129),
(499, 2, 130),
(501, 2, 131),
(503, 2, 132),
(505, 2, 133),
(507, 2, 134),
(509, 2, 135),
(511, 2, 136),
(513, 2, 137),
(515, 2, 138),
(517, 2, 139),
(519, 2, 140),
(521, 2, 141),
(523, 2, 142),
(525, 2, 143),
(527, 2, 144),
(529, 2, 145),
(531, 2, 146),
(533, 2, 147),
(535, 2, 148),
(537, 2, 149),
(539, 2, 150),
(541, 2, 151),
(543, 2, 152),
(545, 2, 153),
(547, 2, 154),
(549, 2, 155),
(551, 2, 156),
(553, 2, 157),
(555, 2, 158),
(557, 2, 159),
(559, 2, 160),
(561, 2, 161),
(563, 2, 162),
(565, 2, 163),
(567, 2, 164),
(569, 2, 165),
(571, 2, 166),
(573, 2, 167),
(575, 2, 168),
(577, 2, 169),
(579, 2, 170),
(581, 2, 171),
(583, 2, 172),
(585, 2, 173),
(587, 2, 174),
(589, 2, 175),
(591, 2, 176),
(593, 2, 177),
(595, 2, 178),
(597, 2, 179),
(599, 2, 180),
(601, 2, 181),
(603, 2, 182),
(605, 2, 183),
(1235, 2, 184),
(609, 2, 185),
(611, 2, 186),
(613, 2, 187),
(615, 2, 188),
(617, 2, 189),
(619, 2, 190),
(621, 2, 191),
(623, 2, 192),
(625, 2, 193),
(627, 2, 194),
(629, 2, 195),
(631, 2, 196),
(633, 2, 197),
(635, 2, 198),
(637, 2, 199),
(639, 2, 200),
(641, 2, 201),
(643, 2, 202),
(645, 2, 203),
(647, 2, 204),
(649, 2, 205),
(651, 2, 206),
(653, 2, 207),
(655, 2, 208),
(657, 2, 209),
(659, 2, 210),
(661, 2, 211),
(663, 2, 212),
(665, 2, 213),
(667, 2, 214),
(669, 2, 215),
(671, 2, 216),
(673, 2, 217),
(675, 2, 218),
(677, 2, 219),
(679, 2, 220),
(681, 2, 221),
(683, 2, 222),
(685, 2, 223),
(687, 2, 224),
(689, 2, 225),
(691, 2, 226),
(693, 2, 227),
(695, 2, 228),
(697, 2, 229),
(699, 2, 230),
(701, 2, 231),
(703, 2, 232),
(705, 2, 233),
(707, 2, 234),
(709, 2, 235),
(711, 2, 236),
(713, 2, 237),
(715, 2, 238),
(717, 2, 239),
(719, 2, 240),
(721, 2, 241),
(723, 2, 242),
(725, 2, 243),
(727, 2, 244),
(729, 2, 245),
(731, 2, 246),
(733, 2, 247),
(735, 2, 248),
(737, 2, 249),
(739, 2, 250),
(741, 2, 251),
(743, 2, 252),
(745, 2, 253),
(747, 2, 254),
(749, 2, 255),
(751, 2, 256),
(753, 2, 257),
(755, 2, 258),
(757, 2, 259),
(759, 2, 260),
(761, 2, 261),
(763, 2, 262),
(765, 2, 263),
(767, 2, 264),
(769, 2, 265),
(771, 2, 266),
(773, 2, 267),
(775, 2, 268),
(777, 2, 269),
(779, 2, 270),
(781, 2, 271),
(783, 2, 272),
(785, 2, 273),
(787, 2, 274),
(789, 2, 275),
(791, 2, 276),
(793, 2, 277),
(795, 2, 278),
(797, 2, 279),
(799, 2, 280),
(801, 2, 281),
(803, 2, 282),
(805, 2, 283),
(807, 2, 284),
(809, 2, 285),
(811, 2, 286),
(813, 2, 287),
(815, 2, 288),
(817, 2, 289),
(819, 2, 290),
(821, 2, 291),
(823, 2, 292),
(825, 2, 293),
(827, 2, 294),
(829, 2, 295),
(831, 2, 296),
(833, 2, 297),
(835, 2, 298),
(837, 2, 299),
(839, 2, 300),
(841, 2, 301),
(843, 2, 302),
(845, 2, 303),
(847, 2, 304),
(849, 2, 305),
(1281, 2, 306),
(853, 2, 307),
(855, 2, 308),
(857, 2, 309),
(859, 2, 310),
(861, 2, 311),
(863, 2, 312),
(865, 2, 313),
(867, 2, 314),
(869, 2, 315),
(871, 2, 316),
(873, 2, 317),
(875, 2, 318),
(877, 2, 319),
(879, 2, 320),
(881, 2, 321),
(883, 2, 322),
(885, 2, 323),
(887, 2, 324),
(889, 2, 325),
(891, 2, 326),
(893, 2, 327),
(895, 2, 328),
(897, 2, 329),
(899, 2, 330),
(901, 2, 331),
(903, 2, 332),
(905, 2, 333),
(907, 2, 334),
(909, 2, 335),
(911, 2, 336),
(913, 2, 337),
(915, 2, 338),
(917, 2, 339),
(919, 2, 340),
(921, 2, 341),
(923, 2, 342),
(925, 2, 343),
(927, 2, 344),
(929, 2, 345),
(931, 2, 346),
(933, 2, 347),
(935, 2, 348),
(937, 2, 349),
(939, 2, 350),
(941, 2, 351),
(943, 2, 352),
(945, 2, 353),
(947, 2, 354),
(949, 2, 355),
(951, 2, 356),
(953, 2, 357),
(955, 2, 358),
(957, 2, 359),
(959, 2, 360),
(961, 2, 361),
(963, 2, 362),
(965, 2, 363),
(967, 2, 364),
(969, 2, 365),
(971, 2, 366),
(973, 2, 367),
(975, 2, 368),
(977, 2, 369),
(979, 2, 370),
(981, 2, 371),
(983, 2, 372),
(985, 2, 373),
(987, 2, 374),
(989, 2, 375),
(991, 2, 376),
(993, 2, 377),
(995, 2, 378),
(997, 2, 379),
(999, 2, 380),
(1001, 2, 381),
(1003, 2, 382),
(1005, 2, 383),
(1007, 2, 384),
(1009, 2, 385),
(1011, 2, 386),
(1013, 2, 387),
(1015, 2, 388),
(1017, 2, 389),
(1019, 2, 390),
(1021, 2, 391),
(1023, 2, 392),
(1025, 2, 393),
(1027, 2, 394),
(1029, 2, 395),
(1031, 2, 396),
(1033, 2, 397),
(1035, 2, 398),
(1037, 2, 399),
(1039, 2, 400),
(1041, 2, 401),
(1043, 2, 402),
(1045, 2, 403),
(1047, 2, 404),
(1049, 2, 405),
(1051, 2, 406),
(1053, 2, 407),
(1055, 2, 408),
(1057, 2, 409),
(1059, 2, 410),
(1061, 2, 411),
(1063, 2, 412),
(1065, 2, 413),
(1067, 2, 414),
(1069, 2, 415),
(1071, 2, 416),
(1073, 2, 417),
(1237, 2, 418),
(1077, 2, 419),
(1079, 2, 420),
(1081, 2, 421),
(1083, 2, 422),
(1085, 2, 423),
(1087, 2, 424),
(1089, 2, 425),
(1091, 2, 426),
(1093, 2, 427),
(1095, 2, 428),
(1097, 2, 429),
(1099, 2, 430),
(1101, 2, 431),
(1103, 2, 432),
(1105, 2, 433),
(1107, 2, 434),
(1109, 2, 435),
(1111, 2, 436),
(1113, 2, 437),
(1115, 2, 438),
(1117, 2, 439),
(1119, 2, 440),
(1121, 2, 441),
(1123, 2, 442),
(1125, 2, 443),
(1127, 2, 444),
(1129, 2, 445),
(1131, 2, 446),
(1133, 2, 447),
(1135, 2, 448),
(1137, 2, 449),
(1139, 2, 450),
(1141, 2, 451),
(1143, 2, 452),
(1145, 2, 453),
(1147, 2, 454),
(1149, 2, 455),
(1151, 2, 456),
(1153, 2, 457),
(1155, 2, 458),
(1157, 2, 459),
(1159, 2, 460),
(1161, 2, 461),
(1163, 2, 462),
(1165, 2, 463),
(1167, 2, 464),
(1169, 2, 465),
(1171, 2, 466),
(1173, 2, 467),
(1175, 2, 468),
(1177, 2, 469),
(1179, 2, 470),
(1181, 2, 471),
(1183, 2, 472),
(1185, 2, 473),
(1187, 2, 474),
(1189, 2, 475),
(1191, 2, 476),
(1193, 2, 477),
(1195, 2, 478),
(1197, 2, 479),
(1199, 2, 480),
(1201, 2, 481),
(1203, 2, 482),
(1205, 2, 483),
(1207, 2, 484),
(1209, 2, 485),
(1211, 2, 486),
(1213, 2, 487),
(1215, 2, 488),
(1217, 2, 489),
(1219, 2, 490),
(1221, 2, 491),
(1223, 2, 492),
(1225, 2, 493),
(1227, 2, 494),
(1229, 2, 495),
(1231, 2, 496),
(1233, 2, 497),
(1239, 2, 498),
(1241, 2, 499),
(1243, 2, 500),
(1245, 2, 501),
(1247, 2, 502),
(1249, 2, 503),
(1251, 2, 504),
(1253, 2, 505),
(1255, 2, 506),
(1257, 2, 507),
(1259, 2, 508),
(1261, 2, 509),
(1263, 2, 510),
(1265, 2, 511),
(1267, 2, 512),
(1269, 2, 513),
(1271, 2, 514),
(1273, 2, 515),
(1275, 2, 516),
(1277, 2, 517),
(1279, 2, 518),
(1283, 2, 519),
(1285, 2, 520),
(1289, 2, 521),
(1301, 2, 522),
(1303, 2, 523),
(3334, 2, 524),
(3825, 2, 525),
(3166, 2, 526),
(1307, 2, 527),
(1309, 2, 528),
(1311, 2, 529),
(1313, 2, 530),
(1322, 2, 532),
(1318, 2, 533),
(3836, 2, 534),
(1324, 2, 535),
(1325, 2, 536),
(1326, 2, 537),
(1327, 2, 538),
(1328, 2, 539),
(1330, 2, 540),
(1342, 2, 541),
(1334, 2, 542),
(1336, 2, 543),
(1338, 2, 544),
(1340, 2, 545),
(1344, 2, 546),
(1345, 2, 547),
(1346, 2, 548),
(4112, 2, 549),
(1349, 2, 550),
(3128, 2, 551),
(1352, 2, 552),
(1354, 2, 553),
(1356, 2, 554),
(1358, 2, 555),
(1360, 2, 556),
(1362, 2, 557),
(1364, 2, 558),
(1366, 2, 559),
(1368, 2, 560),
(1370, 2, 561),
(1372, 2, 562),
(1374, 2, 563),
(1376, 2, 564),
(1378, 2, 565),
(1380, 2, 566),
(1382, 2, 567),
(1384, 2, 568),
(1386, 2, 569),
(1388, 2, 570),
(1390, 2, 571),
(1392, 2, 572),
(1394, 2, 573),
(1396, 2, 574),
(1398, 2, 575),
(1400, 2, 576),
(1402, 2, 577),
(1404, 2, 578),
(1406, 2, 579),
(1408, 2, 580),
(1410, 2, 581),
(1412, 2, 582),
(1414, 2, 583),
(1416, 2, 584),
(1418, 2, 585),
(1420, 2, 586),
(1422, 2, 587),
(1424, 2, 588),
(1426, 2, 589),
(1428, 2, 590),
(1430, 2, 591),
(1432, 2, 592),
(1434, 2, 593),
(1436, 2, 594),
(1438, 2, 595),
(1440, 2, 596),
(1442, 2, 597),
(1444, 2, 598),
(1446, 2, 599),
(1448, 2, 600),
(1450, 2, 601),
(1452, 2, 602),
(1454, 2, 603),
(1456, 2, 604),
(1458, 2, 605),
(1460, 2, 606),
(1462, 2, 607),
(1464, 2, 608),
(1466, 2, 609),
(1468, 2, 610),
(1470, 2, 611),
(1472, 2, 612),
(1474, 2, 613),
(1476, 2, 614),
(1478, 2, 615),
(1480, 2, 616),
(1482, 2, 617),
(1484, 2, 618),
(1486, 2, 619),
(1488, 2, 620),
(1490, 2, 621),
(1492, 2, 622),
(1494, 2, 623),
(1496, 2, 624),
(1498, 2, 625),
(1500, 2, 626),
(1502, 2, 627),
(1504, 2, 628),
(1506, 2, 629),
(1508, 2, 630),
(1510, 2, 631),
(1512, 2, 632),
(1514, 2, 633),
(1516, 2, 634),
(3800, 2, 635),
(1520, 2, 636),
(1522, 2, 637),
(1524, 2, 638),
(1526, 2, 639),
(1528, 2, 640),
(1530, 2, 641),
(1532, 2, 642),
(1534, 2, 643),
(1536, 2, 644),
(1538, 2, 645),
(1540, 2, 646),
(1542, 2, 647),
(1544, 2, 648),
(1546, 2, 649),
(1548, 2, 650),
(1550, 2, 651),
(1552, 2, 652),
(1554, 2, 653),
(1556, 2, 654),
(1558, 2, 655),
(1560, 2, 656),
(1562, 2, 657),
(1564, 2, 658),
(1566, 2, 659),
(1568, 2, 660),
(1570, 2, 661),
(1572, 2, 662),
(1574, 2, 663),
(1576, 2, 664),
(1578, 2, 665),
(1580, 2, 666),
(1582, 2, 667),
(1584, 2, 668),
(1586, 2, 669),
(1588, 2, 670),
(1590, 2, 671),
(1592, 2, 672),
(1594, 2, 673),
(1596, 2, 674),
(1598, 2, 675),
(1600, 2, 676),
(1602, 2, 677),
(1604, 2, 678),
(1606, 2, 679),
(1608, 2, 680),
(1610, 2, 681),
(1612, 2, 682),
(1614, 2, 683),
(1616, 2, 684),
(1618, 2, 685),
(1620, 2, 686),
(1622, 2, 687),
(1624, 2, 688),
(1626, 2, 689),
(1628, 2, 690),
(1630, 2, 691),
(1632, 2, 692),
(3801, 2, 693),
(1636, 2, 694),
(1638, 2, 695),
(1640, 2, 696),
(1642, 2, 697),
(1644, 2, 698),
(1646, 2, 699),
(1648, 2, 700),
(1650, 2, 701),
(1652, 2, 702),
(1654, 2, 703),
(1656, 2, 704),
(1658, 2, 705),
(1660, 2, 706),
(1662, 2, 707),
(1664, 2, 708),
(1666, 2, 709),
(1668, 2, 710),
(1670, 2, 711),
(1672, 2, 712),
(1674, 2, 713),
(1676, 2, 714),
(1678, 2, 715),
(1680, 2, 716),
(1682, 2, 717),
(1684, 2, 718),
(1686, 2, 719),
(1688, 2, 720),
(1690, 2, 721),
(1692, 2, 722),
(1694, 2, 723),
(1696, 2, 724),
(1698, 2, 725),
(1700, 2, 726),
(1702, 2, 727),
(1704, 2, 728),
(1706, 2, 729),
(1708, 2, 730),
(1710, 2, 731),
(1712, 2, 732),
(1714, 2, 733),
(1716, 2, 734),
(1718, 2, 735),
(1720, 2, 736),
(1722, 2, 737),
(1724, 2, 738),
(1726, 2, 739),
(1728, 2, 740),
(1730, 2, 741),
(1732, 2, 742),
(1734, 2, 743),
(1736, 2, 744),
(1738, 2, 745),
(1740, 2, 746),
(1742, 2, 747),
(1744, 2, 748),
(1746, 2, 749),
(1748, 2, 750),
(1750, 2, 751),
(1752, 2, 752),
(1754, 2, 753),
(1756, 2, 754),
(1758, 2, 755),
(1760, 2, 756),
(1762, 2, 757),
(1764, 2, 758),
(1766, 2, 759),
(1768, 2, 760),
(1770, 2, 761),
(1772, 2, 762),
(1774, 2, 763),
(1776, 2, 764),
(1778, 2, 765),
(1780, 2, 766),
(1782, 2, 767),
(1784, 2, 768),
(1786, 2, 769),
(1788, 2, 770),
(1790, 2, 771),
(1792, 2, 772),
(1794, 2, 773),
(1796, 2, 774),
(1798, 2, 775),
(1800, 2, 776),
(1802, 2, 777),
(1804, 2, 778),
(1806, 2, 779),
(1808, 2, 780),
(1810, 2, 781),
(1812, 2, 782),
(1814, 2, 783),
(1816, 2, 784),
(1818, 2, 785),
(1820, 2, 786),
(1822, 2, 787),
(1824, 2, 788),
(1826, 2, 789),
(1828, 2, 790),
(1830, 2, 791),
(1832, 2, 792),
(1834, 2, 793),
(1836, 2, 794),
(1838, 2, 795),
(1840, 2, 796),
(1842, 2, 797),
(1844, 2, 798),
(1846, 2, 799),
(1848, 2, 800),
(1850, 2, 801),
(1852, 2, 802),
(1854, 2, 803),
(1856, 2, 804),
(1858, 2, 805),
(1860, 2, 806),
(1862, 2, 807),
(1864, 2, 808),
(1866, 2, 809),
(1868, 2, 810),
(1870, 2, 811),
(1872, 2, 812),
(1874, 2, 813),
(1876, 2, 814),
(1878, 2, 815),
(1880, 2, 816),
(1882, 2, 817),
(1884, 2, 818),
(1886, 2, 819),
(1888, 2, 820),
(1890, 2, 821),
(1892, 2, 822),
(1894, 2, 823),
(1896, 2, 824),
(1898, 2, 825),
(1900, 2, 826),
(1902, 2, 827),
(1904, 2, 828),
(1906, 2, 829),
(1908, 2, 830),
(1910, 2, 831),
(1912, 2, 832),
(1914, 2, 833),
(1916, 2, 834),
(1918, 2, 835),
(1920, 2, 836),
(1922, 2, 837),
(1924, 2, 838),
(1926, 2, 839),
(1928, 2, 840),
(1930, 2, 841),
(1932, 2, 842),
(1934, 2, 843),
(1936, 2, 844),
(1938, 2, 845),
(1940, 2, 846),
(1942, 2, 847),
(1944, 2, 848),
(1946, 2, 849),
(1948, 2, 850),
(1950, 2, 851),
(1952, 2, 852),
(1954, 2, 853),
(1956, 2, 854),
(1958, 2, 855),
(1960, 2, 856),
(1962, 2, 857),
(1964, 2, 858),
(1966, 2, 859),
(1968, 2, 860),
(1970, 2, 861),
(1972, 2, 862),
(1974, 2, 863),
(1976, 2, 864),
(1978, 2, 865),
(1980, 2, 866),
(1982, 2, 867),
(1984, 2, 868),
(1986, 2, 869),
(1988, 2, 870),
(1990, 2, 871),
(1992, 2, 872),
(1994, 2, 873),
(1996, 2, 874),
(1998, 2, 875),
(2000, 2, 876),
(2002, 2, 877),
(2004, 2, 878),
(2006, 2, 879),
(2008, 2, 880),
(2010, 2, 881),
(2012, 2, 882),
(2014, 2, 883),
(2016, 2, 884),
(2018, 2, 885),
(2020, 2, 886),
(2022, 2, 887),
(2024, 2, 888),
(2026, 2, 889),
(2028, 2, 890),
(2030, 2, 891),
(2032, 2, 892),
(2034, 2, 893),
(2036, 2, 894),
(2038, 2, 895),
(2040, 2, 896),
(2042, 2, 897),
(2044, 2, 898),
(2046, 2, 899),
(2048, 2, 900),
(2050, 2, 901),
(2052, 2, 902),
(2054, 2, 903),
(2056, 2, 904),
(2058, 2, 905),
(2060, 2, 906),
(2062, 2, 907),
(2064, 2, 908),
(2066, 2, 909),
(2068, 2, 910),
(2070, 2, 911),
(2072, 2, 912),
(2074, 2, 913),
(2076, 2, 914),
(2078, 2, 915),
(2080, 2, 916),
(2082, 2, 917),
(2084, 2, 918),
(2086, 2, 919),
(2088, 2, 920),
(2090, 2, 921),
(2092, 2, 922),
(2094, 2, 923),
(2096, 2, 924),
(2098, 2, 925),
(2100, 2, 926),
(2102, 2, 927),
(2104, 2, 928),
(2106, 2, 929),
(2108, 2, 930),
(2110, 2, 931),
(2112, 2, 932),
(2114, 2, 933),
(2116, 2, 934),
(2118, 2, 935),
(2120, 2, 936),
(2122, 2, 937),
(2124, 2, 938),
(2126, 2, 939),
(2128, 2, 940),
(2130, 2, 941),
(2132, 2, 942),
(2134, 2, 943),
(2136, 2, 944),
(2138, 2, 945),
(2140, 2, 946),
(2142, 2, 947),
(2144, 2, 948),
(2146, 2, 949),
(2148, 2, 950),
(2150, 2, 951),
(2152, 2, 952),
(2154, 2, 953),
(2156, 2, 954),
(2158, 2, 955),
(2160, 2, 956),
(2162, 2, 957),
(2164, 2, 958),
(2166, 2, 959),
(2168, 2, 960),
(2170, 2, 961),
(2172, 2, 962),
(2174, 2, 963),
(2176, 2, 964),
(2178, 2, 965),
(2180, 2, 966),
(2182, 2, 967),
(2184, 2, 968),
(2186, 2, 969),
(2188, 2, 970),
(2190, 2, 971),
(2192, 2, 972),
(2194, 2, 973),
(2196, 2, 974),
(2198, 2, 975),
(2200, 2, 976),
(2202, 2, 977),
(2204, 2, 978),
(2206, 2, 979),
(2208, 2, 980),
(2210, 2, 981),
(2212, 2, 982),
(2214, 2, 983),
(2216, 2, 984),
(2218, 2, 985),
(2220, 2, 986),
(2222, 2, 987),
(2224, 2, 988),
(2226, 2, 989),
(2228, 2, 990),
(2230, 2, 991),
(2232, 2, 992),
(2234, 2, 993),
(2236, 2, 994),
(2238, 2, 995),
(2240, 2, 996),
(2242, 2, 997),
(2244, 2, 998),
(2246, 2, 999),
(2248, 2, 1000),
(2250, 2, 1001),
(2252, 2, 1002),
(2254, 2, 1003),
(2256, 2, 1004),
(2258, 2, 1005),
(2260, 2, 1006),
(2262, 2, 1007),
(2264, 2, 1008),
(2266, 2, 1009),
(2268, 2, 1010),
(2270, 2, 1011),
(2272, 2, 1012),
(2274, 2, 1013),
(2276, 2, 1014),
(2278, 2, 1015),
(2280, 2, 1016),
(2282, 2, 1017),
(2284, 2, 1018),
(2286, 2, 1019),
(2288, 2, 1020),
(2290, 2, 1021),
(2292, 2, 1022),
(2294, 2, 1023),
(2296, 2, 1024),
(2298, 2, 1025),
(2300, 2, 1026),
(2302, 2, 1027),
(2304, 2, 1028),
(2306, 2, 1029),
(2308, 2, 1030),
(2310, 2, 1031),
(2312, 2, 1032),
(2314, 2, 1033),
(2316, 2, 1034),
(2318, 2, 1035),
(2320, 2, 1036),
(2322, 2, 1037),
(2324, 2, 1038),
(2326, 2, 1039),
(2328, 2, 1040),
(2330, 2, 1041),
(2332, 2, 1042),
(2334, 2, 1043),
(2336, 2, 1044),
(2338, 2, 1045),
(2340, 2, 1046),
(2342, 2, 1047),
(2344, 2, 1048),
(2346, 2, 1049),
(2348, 2, 1050),
(2350, 2, 1051),
(2352, 2, 1052),
(2354, 2, 1053),
(2356, 2, 1054),
(2358, 2, 1055),
(2360, 2, 1056),
(2362, 2, 1057),
(2364, 2, 1058),
(2366, 2, 1059),
(2368, 2, 1060),
(2370, 2, 1061),
(2372, 2, 1062),
(2374, 2, 1063),
(2376, 2, 1064),
(2378, 2, 1065),
(2380, 2, 1066),
(2382, 2, 1067),
(2384, 2, 1068),
(2386, 2, 1069),
(2388, 2, 1070),
(2390, 2, 1071),
(2392, 2, 1072),
(2394, 2, 1073),
(2396, 2, 1074),
(2398, 2, 1075),
(2400, 2, 1076),
(2402, 2, 1077),
(2404, 2, 1078),
(2406, 2, 1079),
(2408, 2, 1080),
(2410, 2, 1081),
(2412, 2, 1082),
(2414, 2, 1083),
(2416, 2, 1084),
(2418, 2, 1085),
(2420, 2, 1086),
(2422, 2, 1087),
(2424, 2, 1088),
(2426, 2, 1089),
(2428, 2, 1090),
(2430, 2, 1091),
(2432, 2, 1092),
(2434, 2, 1093),
(2436, 2, 1094),
(2438, 2, 1095),
(2440, 2, 1096),
(2442, 2, 1097),
(2444, 2, 1098),
(2446, 2, 1099),
(2448, 2, 1100),
(2450, 2, 1101),
(2452, 2, 1102),
(2454, 2, 1103),
(2456, 2, 1104),
(2458, 2, 1105),
(2460, 2, 1106),
(2462, 2, 1107),
(2464, 2, 1108),
(2466, 2, 1109),
(2468, 2, 1110),
(2470, 2, 1111),
(2472, 2, 1112),
(2474, 2, 1113),
(2476, 2, 1114),
(2478, 2, 1115),
(2480, 2, 1116),
(2482, 2, 1117),
(2484, 2, 1118),
(2486, 2, 1119),
(2488, 2, 1120),
(2490, 2, 1121),
(2492, 2, 1122),
(2494, 2, 1123),
(2496, 2, 1124),
(2498, 2, 1125),
(2500, 2, 1126),
(2502, 2, 1127),
(2504, 2, 1128),
(2506, 2, 1129),
(2508, 2, 1130),
(2510, 2, 1131),
(2512, 2, 1132),
(2514, 2, 1133),
(2516, 2, 1134),
(2518, 2, 1135),
(2520, 2, 1136),
(2522, 2, 1137),
(2524, 2, 1138),
(2526, 2, 1139),
(2528, 2, 1140),
(2530, 2, 1141),
(2532, 2, 1142),
(2534, 2, 1143),
(2536, 2, 1144),
(2538, 2, 1145),
(2540, 2, 1146),
(2542, 2, 1147),
(2544, 2, 1148),
(2546, 2, 1149),
(2548, 2, 1150),
(2550, 2, 1151),
(2552, 2, 1152),
(2554, 2, 1153),
(2556, 2, 1154),
(2558, 2, 1155),
(2560, 2, 1156),
(2562, 2, 1157),
(2564, 2, 1158),
(2566, 2, 1159),
(2568, 2, 1160),
(2570, 2, 1161),
(2572, 2, 1162),
(2574, 2, 1163),
(2576, 2, 1164),
(2578, 2, 1165),
(2580, 2, 1166),
(2582, 2, 1167),
(2584, 2, 1168),
(2586, 2, 1169),
(2588, 2, 1170),
(2590, 2, 1171),
(2592, 2, 1172),
(2594, 2, 1173),
(2596, 2, 1174),
(2598, 2, 1175),
(2600, 2, 1176),
(2602, 2, 1177),
(2604, 2, 1178),
(2606, 2, 1179),
(2608, 2, 1180),
(2610, 2, 1181),
(2612, 2, 1182),
(2614, 2, 1183),
(2616, 2, 1184),
(2618, 2, 1185),
(2620, 2, 1186),
(2622, 2, 1187),
(2624, 2, 1188),
(2626, 2, 1189),
(2628, 2, 1190),
(2630, 2, 1191),
(2632, 2, 1192),
(2634, 2, 1193),
(2636, 2, 1194),
(2638, 2, 1195),
(2640, 2, 1196),
(2642, 2, 1197),
(2644, 2, 1198),
(2646, 2, 1199),
(2648, 2, 1200),
(2650, 2, 1201),
(2652, 2, 1202),
(2654, 2, 1203),
(2656, 2, 1204),
(2658, 2, 1205),
(2660, 2, 1206),
(2662, 2, 1207),
(2664, 2, 1208),
(2666, 2, 1209),
(2668, 2, 1210),
(2670, 2, 1211),
(2672, 2, 1212),
(2674, 2, 1213),
(2676, 2, 1214),
(2678, 2, 1215),
(2680, 2, 1216),
(2682, 2, 1217),
(2684, 2, 1218),
(2686, 2, 1219),
(2688, 2, 1220),
(2690, 2, 1221),
(2692, 2, 1222),
(2694, 2, 1223),
(2696, 2, 1224),
(2698, 2, 1225),
(2700, 2, 1226),
(2702, 2, 1227),
(2704, 2, 1228),
(2706, 2, 1229),
(2708, 2, 1230),
(2710, 2, 1231),
(2712, 2, 1232),
(2714, 2, 1233),
(2716, 2, 1234),
(2718, 2, 1235),
(2720, 2, 1236),
(2722, 2, 1237),
(2724, 2, 1238),
(2726, 2, 1239),
(2728, 2, 1240),
(2730, 2, 1241),
(2732, 2, 1242),
(2734, 2, 1243),
(2736, 2, 1244),
(2738, 2, 1245),
(2740, 2, 1246),
(2742, 2, 1247),
(2744, 2, 1248),
(2746, 2, 1249),
(2748, 2, 1250),
(2750, 2, 1251),
(2752, 2, 1252),
(2754, 2, 1253),
(2756, 2, 1254),
(2758, 2, 1255),
(2760, 2, 1256),
(2762, 2, 1257),
(2764, 2, 1258),
(2766, 2, 1259),
(2768, 2, 1260),
(2770, 2, 1261),
(2772, 2, 1262),
(2774, 2, 1263),
(2776, 2, 1264),
(2778, 2, 1265),
(2780, 2, 1266),
(2782, 2, 1267),
(2784, 2, 1268),
(2786, 2, 1269),
(2788, 2, 1270),
(2790, 2, 1271),
(2792, 2, 1272),
(2794, 2, 1273),
(2796, 2, 1274),
(2798, 2, 1275),
(2800, 2, 1276),
(2802, 2, 1277),
(2804, 2, 1278),
(2806, 2, 1279),
(2808, 2, 1280),
(2810, 2, 1281),
(2812, 2, 1282),
(2814, 2, 1283),
(2816, 2, 1284),
(2818, 2, 1285),
(2820, 2, 1286),
(2822, 2, 1287),
(2824, 2, 1288),
(2826, 2, 1289),
(2828, 2, 1290),
(2830, 2, 1291),
(2832, 2, 1292),
(2834, 2, 1293),
(2836, 2, 1294),
(2838, 2, 1295),
(2840, 2, 1296),
(2842, 2, 1297),
(2844, 2, 1298),
(2846, 2, 1299),
(2848, 2, 1300),
(2850, 2, 1301),
(2852, 2, 1302),
(2854, 2, 1303),
(2856, 2, 1304),
(2858, 2, 1305),
(2860, 2, 1306),
(2862, 2, 1307),
(2864, 2, 1308),
(2866, 2, 1309),
(2868, 2, 1310),
(2870, 2, 1311),
(2872, 2, 1312),
(2874, 2, 1313),
(2876, 2, 1314),
(2878, 2, 1315),
(2880, 2, 1316),
(2882, 2, 1317),
(2884, 2, 1318),
(2886, 2, 1319),
(2888, 2, 1320),
(2890, 2, 1321),
(2892, 2, 1322),
(2894, 2, 1323),
(2896, 2, 1324),
(2898, 2, 1325),
(2900, 2, 1326),
(2902, 2, 1327),
(2904, 2, 1328),
(2906, 2, 1329),
(2908, 2, 1330),
(2910, 2, 1331),
(2912, 2, 1332),
(2914, 2, 1333),
(2916, 2, 1334),
(2918, 2, 1335),
(2920, 2, 1336),
(2922, 2, 1337),
(2924, 2, 1338),
(2926, 2, 1339),
(2928, 2, 1340),
(2930, 2, 1341),
(2932, 2, 1342),
(2934, 2, 1343),
(2936, 2, 1344),
(2938, 2, 1345),
(2940, 2, 1346),
(2942, 2, 1347),
(2944, 2, 1348),
(2946, 2, 1349),
(2948, 2, 1350),
(2950, 2, 1351),
(2952, 2, 1352),
(2954, 2, 1353),
(2956, 2, 1354),
(2958, 2, 1355),
(2960, 2, 1356),
(2962, 2, 1357),
(2964, 2, 1358),
(2966, 2, 1359),
(2968, 2, 1360),
(2970, 2, 1361),
(2972, 2, 1362),
(2974, 2, 1363),
(2976, 2, 1364),
(2978, 2, 1365),
(2980, 2, 1366),
(2982, 2, 1367),
(2984, 2, 1368),
(2986, 2, 1369),
(2988, 2, 1370),
(2990, 2, 1371),
(2992, 2, 1372),
(2994, 2, 1373),
(2996, 2, 1374),
(2998, 2, 1375),
(3000, 2, 1376),
(3002, 2, 1377),
(3004, 2, 1378),
(3006, 2, 1379),
(3008, 2, 1380),
(3010, 2, 1381),
(3012, 2, 1382),
(3014, 2, 1383),
(3016, 2, 1384),
(3018, 2, 1385),
(3020, 2, 1386),
(3022, 2, 1387),
(3024, 2, 1388),
(3026, 2, 1389),
(3028, 2, 1390),
(3030, 2, 1391),
(3032, 2, 1392),
(3034, 2, 1393),
(3036, 2, 1394),
(3038, 2, 1395),
(3040, 2, 1396),
(3042, 2, 1397),
(3044, 2, 1398),
(3046, 2, 1399),
(3048, 2, 1400),
(3050, 2, 1401),
(3052, 2, 1402),
(3054, 2, 1403),
(3056, 2, 1404),
(3058, 2, 1405),
(3060, 2, 1406),
(3062, 2, 1407),
(3064, 2, 1408),
(3066, 2, 1409),
(3068, 2, 1410),
(3070, 2, 1411),
(3072, 2, 1412),
(3074, 2, 1413),
(3076, 2, 1414),
(3078, 2, 1415),
(3080, 2, 1416),
(3082, 2, 1417),
(3084, 2, 1418),
(3086, 2, 1419),
(3088, 2, 1420),
(3090, 2, 1421),
(3092, 2, 1422),
(3094, 2, 1423),
(3096, 2, 1424),
(3098, 2, 1425),
(3100, 2, 1426),
(3102, 2, 1427),
(3104, 2, 1428),
(3106, 2, 1429),
(3108, 2, 1430),
(3110, 2, 1431),
(3112, 2, 1432),
(3114, 2, 1433),
(3116, 2, 1434),
(3118, 2, 1435),
(3120, 2, 1436),
(3122, 2, 1437),
(3124, 2, 1438),
(3126, 2, 1439),
(3130, 2, 1440),
(3131, 2, 1441),
(3133, 2, 1442),
(3135, 2, 1443),
(3137, 2, 1444),
(3138, 2, 1445),
(3139, 2, 1446),
(3140, 2, 1447),
(3141, 2, 1448),
(3142, 2, 1449),
(3143, 2, 1450),
(3144, 2, 1451),
(3145, 2, 1452),
(3146, 2, 1453),
(3147, 2, 1454),
(3148, 2, 1455),
(3149, 2, 1456),
(3150, 2, 1457),
(3151, 2, 1458),
(3152, 2, 1459),
(3153, 2, 1460),
(3154, 2, 1461),
(3155, 2, 1462),
(3156, 2, 1463),
(3157, 2, 1464),
(3158, 2, 1465),
(3159, 2, 1466),
(3160, 2, 1467),
(3161, 2, 1468),
(3162, 2, 1469),
(3362, 2, 1471),
(3863, 2, 1472),
(3473, 2, 1473),
(3459, 2, 1474),
(3455, 2, 1475),
(3376, 2, 1476),
(4028, 2, 1478),
(3475, 2, 1482),
(4109, 2, 1483),
(3411, 2, 1484),
(3496, 2, 1485),
(4129, 2, 1487),
(3856, 2, 1488),
(4116, 2, 1490),
(4024, 2, 1491),
(3457, 2, 1492),
(3842, 2, 1493),
(4017, 2, 1494),
(3829, 2, 1495),
(3440, 2, 1496),
(3751, 2, 1497),
(3753, 2, 1501),
(3755, 2, 1505),
(3759, 2, 1506),
(3762, 2, 1507),
(3504, 2, 1509),
(3506, 2, 1510),
(3823, 2, 1511),
(3512, 2, 1512),
(3525, 2, 1513),
(3844, 2, 1514),
(3491, 2, 1515),
(3778, 2, 1516),
(3766, 2, 1517),
(3768, 2, 1518),
(3852, 2, 1519),
(3846, 2, 1520),
(3387, 2, 1521),
(3523, 2, 1522),
(3502, 2, 1523),
(4121, 2, 1524),
(3510, 2, 1525),
(3780, 2, 1526),
(3854, 2, 1527),
(3494, 2, 1528),
(3514, 2, 1529),
(3498, 2, 1530),
(3757, 2, 1531),
(3508, 2, 1532),
(3764, 2, 1533),
(3518, 2, 1534),
(3858, 2, 1544),
(4105, 2, 1546),
(3770, 2, 1548),
(3814, 2, 1549),
(3867, 2, 1550),
(3870, 2, 1551),
(3806, 2, 1552),
(3399, 2, 1554),
(3774, 2, 1555),
(4124, 2, 1557),
(3782, 2, 1558),
(3369, 2, 1559),
(4093, 2, 1562),
(3336, 2, 1568),
(4090, 2, 1605),
(3178, 2, 1622),
(3338, 2, 1624),
(3340, 2, 1625),
(3341, 2, 1626),
(3349, 2, 1627),
(3350, 2, 1628),
(3351, 2, 1629),
(3352, 2, 1630),
(3366, 2, 1631),
(3404, 2, 1632),
(3449, 2, 1633),
(3479, 2, 1634),
(3486, 2, 1635),
(3531, 2, 1636),
(3533, 2, 1637),
(3535, 2, 1638),
(3537, 2, 1639),
(3539, 2, 1640),
(3541, 2, 1641),
(3543, 2, 1642),
(3545, 2, 1643),
(3547, 2, 1644),
(3549, 2, 1645),
(3551, 2, 1646),
(3553, 2, 1647),
(3555, 2, 1648),
(3557, 2, 1649),
(3559, 2, 1650),
(3561, 2, 1651),
(3563, 2, 1652),
(3565, 2, 1653),
(3567, 2, 1654),
(3569, 2, 1655),
(3571, 2, 1656),
(3573, 2, 1657),
(3575, 2, 1658),
(3577, 2, 1659),
(3579, 2, 1660),
(3581, 2, 1661),
(3583, 2, 1662),
(3585, 2, 1663),
(3587, 2, 1664),
(3589, 2, 1665),
(3591, 2, 1666),
(3593, 2, 1667),
(3595, 2, 1668),
(3597, 2, 1669),
(3599, 2, 1670),
(3601, 2, 1671),
(3603, 2, 1672),
(3605, 2, 1673),
(3607, 2, 1674),
(3609, 2, 1675),
(3611, 2, 1676),
(3613, 2, 1677),
(3615, 2, 1678),
(3617, 2, 1679),
(3619, 2, 1680),
(3621, 2, 1681),
(3623, 2, 1682),
(3625, 2, 1683),
(3627, 2, 1684),
(3629, 2, 1685),
(3631, 2, 1686),
(3633, 2, 1687),
(3635, 2, 1688),
(3637, 2, 1689),
(3639, 2, 1690),
(3641, 2, 1691),
(3643, 2, 1692),
(3645, 2, 1693),
(3647, 2, 1694),
(3649, 2, 1695),
(3651, 2, 1696),
(3653, 2, 1697),
(3655, 2, 1698),
(3657, 2, 1699),
(3659, 2, 1700),
(3661, 2, 1701),
(3663, 2, 1702),
(3665, 2, 1703),
(3667, 2, 1704),
(3669, 2, 1705),
(3671, 2, 1706),
(3673, 2, 1707),
(3675, 2, 1708),
(3677, 2, 1709),
(3679, 2, 1710),
(3681, 2, 1711),
(3683, 2, 1712),
(3685, 2, 1713),
(3687, 2, 1714),
(3689, 2, 1715),
(3691, 2, 1716),
(3693, 2, 1717),
(3695, 2, 1718),
(3697, 2, 1719),
(3699, 2, 1720),
(3701, 2, 1721),
(3703, 2, 1722),
(3705, 2, 1723),
(3707, 2, 1724),
(3709, 2, 1725),
(3711, 2, 1726),
(3713, 2, 1727),
(3715, 2, 1728),
(3717, 2, 1729),
(3719, 2, 1730),
(3721, 2, 1731),
(3723, 2, 1732),
(3725, 2, 1733),
(3727, 2, 1734),
(3729, 2, 1735),
(3731, 2, 1736),
(3733, 2, 1737),
(3735, 2, 1738),
(3737, 2, 1739),
(3739, 2, 1740),
(3741, 2, 1741),
(3743, 2, 1742),
(3745, 2, 1743),
(3747, 2, 1744),
(3749, 2, 1745),
(3802, 2, 1746),
(3873, 2, 1747),
(3849, 2, 1748),
(3860, 2, 1749),
(3861, 2, 1750),
(3862, 2, 1751),
(3865, 2, 1752),
(3866, 2, 1753),
(4021, 2, 1754),
(3876, 2, 1755),
(3878, 2, 1756),
(3880, 2, 1757),
(3882, 2, 1758),
(3884, 2, 1759),
(3886, 2, 1760),
(3888, 2, 1761),
(3890, 2, 1762),
(3892, 2, 1763),
(3894, 2, 1764),
(3896, 2, 1765),
(3898, 2, 1766),
(3900, 2, 1767),
(3902, 2, 1768),
(3904, 2, 1769),
(3906, 2, 1770),
(3908, 2, 1771),
(3910, 2, 1772),
(3912, 2, 1773),
(3914, 2, 1774),
(3916, 2, 1775),
(3918, 2, 1776),
(3920, 2, 1777),
(3922, 2, 1778),
(3924, 2, 1779),
(3926, 2, 1780),
(3928, 2, 1781),
(3930, 2, 1782),
(3932, 2, 1783),
(3934, 2, 1784),
(3936, 2, 1785),
(3938, 2, 1786),
(3940, 2, 1787),
(3942, 2, 1788),
(3944, 2, 1789),
(3946, 2, 1790),
(3948, 2, 1791),
(3950, 2, 1792),
(3952, 2, 1793),
(3954, 2, 1794),
(3956, 2, 1795),
(3958, 2, 1796),
(3960, 2, 1797),
(3962, 2, 1798),
(3964, 2, 1799),
(3966, 2, 1800),
(3968, 2, 1801),
(3970, 2, 1802),
(3972, 2, 1803),
(3974, 2, 1804),
(3976, 2, 1805),
(3978, 2, 1806),
(3980, 2, 1807),
(3982, 2, 1808),
(3984, 2, 1809),
(3986, 2, 1810),
(3988, 2, 1811),
(3990, 2, 1812),
(3992, 2, 1813),
(3994, 2, 1814),
(3996, 2, 1815),
(3998, 2, 1816),
(4000, 2, 1817),
(4002, 2, 1818),
(4004, 2, 1819),
(4006, 2, 1820),
(4008, 2, 1821),
(4010, 2, 1822),
(4011, 2, 1823),
(4013, 2, 1824),
(4015, 2, 1825),
(4023, 2, 1826),
(4032, 2, 1827),
(4034, 2, 1828),
(4036, 2, 1829),
(4038, 2, 1830),
(4040, 2, 1831),
(4042, 2, 1832),
(4044, 2, 1833),
(4046, 2, 1834),
(4048, 2, 1835),
(4050, 2, 1836),
(4052, 2, 1837),
(4054, 2, 1838),
(4056, 2, 1839),
(4058, 2, 1840),
(4060, 2, 1841),
(4062, 2, 1842),
(4064, 2, 1843),
(4066, 2, 1844),
(4068, 2, 1845),
(4070, 2, 1846),
(4072, 2, 1847),
(4074, 2, 1848),
(4076, 2, 1849),
(4082, 2, 1850),
(4083, 2, 1851),
(4086, 2, 1852),
(4087, 2, 1853),
(4088, 2, 1854),
(4089, 2, 1855),
(4096, 2, 1856),
(4097, 2, 1857),
(4098, 2, 1858),
(4099, 2, 1859),
(4100, 2, 1860),
(4101, 2, 1861),
(4108, 2, 1862),
(4115, 2, 1863),
(4120, 2, 1864),
(4127, 2, 1865),
(4128, 2, 1866),
(4142, 4, 1868),
(4143, 5, 1869),
(4140, 1, 1870),
(4141, 2, 1870);

-- --------------------------------------------------------

--
-- Table structure for table `sim_group_permission`
--

CREATE TABLE IF NOT EXISTS `sim_group_permission` (
  `gperm_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `gperm_groupid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `gperm_itemid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `gperm_modid` mediumint(5) unsigned NOT NULL DEFAULT '0',
  `gperm_name` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`gperm_id`),
  KEY `groupid` (`gperm_groupid`),
  KEY `itemid` (`gperm_itemid`),
  KEY `gperm_modid` (`gperm_modid`,`gperm_name`(10))
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1820 ;

--
-- Dumping data for table `sim_group_permission`
--

INSERT INTO `sim_group_permission` (`gperm_id`, `gperm_groupid`, `gperm_itemid`, `gperm_modid`, `gperm_name`) VALUES
(1703, 2, 46, 1, 'block_read'),
(1532, 1, 1, 1, 'module_read'),
(1786, 3, 46, 1, 'block_read'),
(1521, 1, 3, 1, 'module_read'),
(1520, 1, 2, 1, 'module_read'),
(1519, 1, 1, 1, 'module_admin'),
(64, 1, 1, 3, 'profile_edit'),
(65, 2, 1, 3, 'profile_edit'),
(66, 1, 1, 3, 'profile_search'),
(67, 2, 1, 3, 'profile_search'),
(68, 1, 2, 3, 'profile_edit'),
(69, 2, 2, 3, 'profile_edit'),
(70, 1, 2, 3, 'profile_search'),
(71, 2, 2, 3, 'profile_search'),
(72, 1, 3, 3, 'profile_edit'),
(73, 2, 3, 3, 'profile_edit'),
(74, 1, 3, 3, 'profile_search'),
(75, 2, 3, 3, 'profile_search'),
(76, 1, 4, 3, 'profile_edit'),
(77, 2, 4, 3, 'profile_edit'),
(78, 1, 4, 3, 'profile_search'),
(79, 2, 4, 3, 'profile_search'),
(80, 1, 5, 3, 'profile_edit'),
(81, 2, 5, 3, 'profile_edit'),
(82, 1, 5, 3, 'profile_search'),
(83, 2, 5, 3, 'profile_search'),
(84, 1, 6, 3, 'profile_edit'),
(85, 2, 6, 3, 'profile_edit'),
(86, 1, 6, 3, 'profile_search'),
(87, 2, 6, 3, 'profile_search'),
(88, 1, 7, 3, 'profile_search'),
(89, 2, 7, 3, 'profile_search'),
(90, 1, 8, 3, 'profile_edit'),
(91, 2, 8, 3, 'profile_edit'),
(92, 1, 8, 3, 'profile_search'),
(93, 2, 8, 3, 'profile_search'),
(94, 1, 9, 3, 'profile_edit'),
(95, 2, 9, 3, 'profile_edit'),
(96, 1, 9, 3, 'profile_search'),
(97, 2, 9, 3, 'profile_search'),
(98, 1, 10, 3, 'profile_edit'),
(99, 2, 10, 3, 'profile_edit'),
(100, 1, 10, 3, 'profile_search'),
(101, 2, 10, 3, 'profile_search'),
(102, 1, 11, 3, 'profile_edit'),
(103, 2, 11, 3, 'profile_edit'),
(104, 1, 11, 3, 'profile_search'),
(105, 2, 11, 3, 'profile_search'),
(106, 1, 12, 3, 'profile_edit'),
(107, 2, 12, 3, 'profile_edit'),
(108, 1, 12, 3, 'profile_search'),
(109, 2, 12, 3, 'profile_search'),
(110, 1, 13, 3, 'profile_edit'),
(111, 2, 13, 3, 'profile_edit'),
(112, 1, 13, 3, 'profile_search'),
(113, 2, 13, 3, 'profile_search'),
(114, 1, 14, 3, 'profile_edit'),
(115, 2, 14, 3, 'profile_edit'),
(116, 1, 14, 3, 'profile_search'),
(117, 2, 14, 3, 'profile_search'),
(118, 1, 15, 3, 'profile_edit'),
(119, 2, 15, 3, 'profile_edit'),
(120, 1, 15, 3, 'profile_search'),
(121, 2, 15, 3, 'profile_search'),
(122, 1, 16, 3, 'profile_edit'),
(123, 2, 16, 3, 'profile_edit'),
(124, 1, 16, 3, 'profile_search'),
(125, 2, 16, 3, 'profile_search'),
(126, 1, 17, 3, 'profile_edit'),
(127, 2, 17, 3, 'profile_edit'),
(128, 1, 17, 3, 'profile_search'),
(129, 2, 17, 3, 'profile_search'),
(130, 1, 18, 3, 'profile_edit'),
(131, 2, 18, 3, 'profile_edit'),
(132, 1, 18, 3, 'profile_search'),
(133, 2, 18, 3, 'profile_search'),
(134, 1, 19, 3, 'profile_edit'),
(135, 2, 19, 3, 'profile_edit'),
(136, 1, 19, 3, 'profile_search'),
(137, 2, 19, 3, 'profile_search'),
(138, 1, 20, 3, 'profile_edit'),
(139, 2, 20, 3, 'profile_edit'),
(140, 1, 20, 3, 'profile_search'),
(141, 2, 20, 3, 'profile_search'),
(142, 1, 21, 3, 'profile_search'),
(143, 2, 21, 3, 'profile_search'),
(144, 1, 22, 3, 'profile_edit'),
(145, 1, 22, 3, 'profile_search'),
(146, 2, 22, 3, 'profile_search'),
(147, 1, 23, 3, 'profile_search'),
(148, 2, 23, 3, 'profile_search'),
(149, 1, 24, 3, 'profile_edit'),
(150, 2, 24, 3, 'profile_edit'),
(151, 1, 24, 3, 'profile_search'),
(152, 2, 24, 3, 'profile_search'),
(153, 1, 1, 3, 'profile_access'),
(154, 1, 2, 3, 'profile_access'),
(155, 2, 2, 3, 'profile_access'),
(156, 3, 2, 3, 'profile_access'),
(1785, 3, 1, 1, 'module_read'),
(1507, 1, 4, 1, 'module_admin'),
(1506, 1, 3, 1, 'module_admin'),
(1505, 1, 2, 1, 'module_admin'),
(1504, 1, 2, 1, 'system_admin'),
(1503, 1, 11, 1, 'system_admin'),
(1502, 1, 15, 1, 'system_admin'),
(1784, 3, 68, 1, 'module_read'),
(1501, 1, 12, 1, 'system_admin'),
(1500, 1, 3, 1, 'system_admin'),
(1499, 1, 4, 1, 'system_admin'),
(1498, 1, 8, 1, 'system_admin'),
(1497, 1, 9, 1, 'system_admin'),
(1496, 1, 1, 1, 'system_admin'),
(1495, 1, 7, 1, 'system_admin'),
(1702, 2, 61, 1, 'module_read'),
(1818, 3, 80, 1, 'module_admin'),
(1782, 3, 66, 1, 'module_read'),
(1537, 2, 1, 1, 'module_read'),
(1534, 2, 3, 1, 'module_read'),
(1533, 2, 2, 1, 'module_read'),
(1494, 1, 14, 1, 'system_admin'),
(1493, 1, 5, 1, 'system_admin'),
(1492, 1, 13, 1, 'system_admin'),
(1491, 1, 10, 1, 'system_admin'),
(1699, 1, 61, 1, 'module_admin'),
(1700, 1, 61, 1, 'module_read'),
(1701, 1, 46, 1, 'block_read'),
(1732, 2, 68, 1, 'module_read'),
(1731, 1, 68, 1, 'module_read'),
(1730, 1, 68, 1, 'module_admin'),
(1781, 3, 61, 1, 'module_read'),
(1722, 1, 66, 1, 'module_admin'),
(1723, 1, 66, 1, 'module_read'),
(1724, 2, 66, 1, 'module_read'),
(1780, 3, 3, 1, 'module_read'),
(1779, 3, 2, 1, 'module_read'),
(1817, 2, 80, 1, 'module_read'),
(1816, 1, 80, 1, 'module_read'),
(1778, 3, 3, 1, 'module_admin'),
(1800, 4, 3, 1, 'module_read'),
(1799, 4, 2, 1, 'module_read'),
(1798, 4, 61, 1, 'module_read'),
(1819, 3, 80, 1, 'module_read'),
(1801, 4, 66, 1, 'module_read'),
(1803, 4, 68, 1, 'module_read'),
(1804, 4, 1, 1, 'module_read'),
(1805, 4, 46, 1, 'block_read'),
(1807, 5, 61, 1, 'module_read'),
(1808, 5, 2, 1, 'module_read'),
(1809, 5, 3, 1, 'module_read'),
(1810, 5, 66, 1, 'module_read'),
(1815, 1, 80, 1, 'module_admin'),
(1812, 5, 68, 1, 'module_read'),
(1813, 5, 1, 1, 'module_read'),
(1814, 5, 46, 1, 'block_read');

-- --------------------------------------------------------

--
-- Table structure for table `sim_image`
--

CREATE TABLE IF NOT EXISTS `sim_image` (
  `image_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `image_name` varchar(30) NOT NULL DEFAULT '',
  `image_nicename` varchar(255) NOT NULL DEFAULT '',
  `image_mimetype` varchar(30) NOT NULL DEFAULT '',
  `image_created` int(10) unsigned NOT NULL DEFAULT '0',
  `image_display` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `image_weight` smallint(5) unsigned NOT NULL DEFAULT '0',
  `imgcat_id` smallint(5) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`image_id`),
  KEY `imgcat_id` (`imgcat_id`),
  KEY `image_display` (`image_display`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `sim_image`
--


-- --------------------------------------------------------

--
-- Table structure for table `sim_imagebody`
--

CREATE TABLE IF NOT EXISTS `sim_imagebody` (
  `image_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `image_body` mediumblob,
  KEY `image_id` (`image_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sim_imagebody`
--


-- --------------------------------------------------------

--
-- Table structure for table `sim_imagecategory`
--

CREATE TABLE IF NOT EXISTS `sim_imagecategory` (
  `imgcat_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `imgcat_name` varchar(100) NOT NULL DEFAULT '',
  `imgcat_maxsize` int(8) unsigned NOT NULL DEFAULT '0',
  `imgcat_maxwidth` smallint(3) unsigned NOT NULL DEFAULT '0',
  `imgcat_maxheight` smallint(3) unsigned NOT NULL DEFAULT '0',
  `imgcat_display` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `imgcat_weight` smallint(3) unsigned NOT NULL DEFAULT '0',
  `imgcat_type` char(1) NOT NULL DEFAULT '',
  `imgcat_storetype` varchar(5) NOT NULL DEFAULT '',
  PRIMARY KEY (`imgcat_id`),
  KEY `imgcat_display` (`imgcat_display`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `sim_imagecategory`
--


-- --------------------------------------------------------

--
-- Table structure for table `sim_imgset`
--

CREATE TABLE IF NOT EXISTS `sim_imgset` (
  `imgset_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `imgset_name` varchar(50) NOT NULL DEFAULT '',
  `imgset_refid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`imgset_id`),
  KEY `imgset_refid` (`imgset_refid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `sim_imgset`
--

INSERT INTO `sim_imgset` (`imgset_id`, `imgset_name`, `imgset_refid`) VALUES
(1, 'default', 0);

-- --------------------------------------------------------

--
-- Table structure for table `sim_imgsetimg`
--

CREATE TABLE IF NOT EXISTS `sim_imgsetimg` (
  `imgsetimg_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `imgsetimg_file` varchar(50) NOT NULL DEFAULT '',
  `imgsetimg_body` blob,
  `imgsetimg_imgset` smallint(5) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`imgsetimg_id`),
  KEY `imgsetimg_imgset` (`imgsetimg_imgset`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `sim_imgsetimg`
--


-- --------------------------------------------------------

--
-- Table structure for table `sim_imgset_tplset_link`
--

CREATE TABLE IF NOT EXISTS `sim_imgset_tplset_link` (
  `imgset_id` smallint(5) unsigned NOT NULL DEFAULT '0',
  `tplset_name` varchar(50) NOT NULL DEFAULT '',
  KEY `tplset_name` (`tplset_name`(10))
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sim_imgset_tplset_link`
--

INSERT INTO `sim_imgset_tplset_link` (`imgset_id`, `tplset_name`) VALUES
(1, 'default');

-- --------------------------------------------------------

--
-- Table structure for table `sim_industry`
--

CREATE TABLE IF NOT EXISTS `sim_industry` (
  `industry_id` int(11) NOT NULL AUTO_INCREMENT,
  `industry_name` varchar(50) NOT NULL,
  `description` text,
  `created` datetime NOT NULL,
  `createdby` int(11) NOT NULL,
  `updated` datetime NOT NULL,
  `updatedby` int(11) NOT NULL,
  `isactive` smallint(1) NOT NULL,
  `seqno` smallint(3) NOT NULL,
  `organization_id` int(11) NOT NULL,
  `isdeleted` smallint(6) NOT NULL,
  PRIMARY KEY (`industry_id`),
  UNIQUE KEY `industry_name` (`industry_name`,`organization_id`),
  KEY `organization_id` (`organization_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `sim_industry`
--

INSERT INTO `sim_industry` (`industry_id`, `industry_name`, `description`, `created`, `createdby`, `updated`, `updatedby`, `isactive`, `seqno`, `organization_id`, `isdeleted`) VALUES
(0, '', NULL, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, 0, 0, 1, 0),
(1, 'Medical', NULL, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, 1, 10, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `sim_loginevent`
--

CREATE TABLE IF NOT EXISTS `sim_loginevent` (
  `event_id` int(11) NOT NULL AUTO_INCREMENT,
  `eventdatetime` datetime NOT NULL,
  `activity` char(1) NOT NULL,
  `uid` int(11) NOT NULL,
  `ip` varchar(20) NOT NULL,
  PRIMARY KEY (`event_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `sim_loginevent`
--

INSERT INTO `sim_loginevent` (`event_id`, `eventdatetime`, `activity`, `uid`, `ip`) VALUES
(1, '2010-08-28 05:08:28', 'I', 1, '::1'),
(2, '2010-08-29 06:08:29', 'I', 1, '::1');

-- --------------------------------------------------------

--
-- Table structure for table `sim_modules`
--

CREATE TABLE IF NOT EXISTS `sim_modules` (
  `mid` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL DEFAULT '',
  `version` smallint(5) unsigned NOT NULL DEFAULT '100',
  `last_update` int(10) unsigned NOT NULL DEFAULT '0',
  `weight` smallint(3) unsigned NOT NULL DEFAULT '0',
  `isactive` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `dirname` varchar(25) NOT NULL DEFAULT '',
  `hasmain` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `hasadmin` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `hassearch` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `hasconfig` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `hascomments` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `hasnotification` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`mid`),
  KEY `hasmain` (`hasmain`),
  KEY `hasadmin` (`hasadmin`),
  KEY `hassearch` (`hassearch`),
  KEY `hasnotification` (`hasnotification`),
  KEY `dirname` (`dirname`),
  KEY `name` (`name`(15)),
  KEY `isactive` (`isactive`),
  KEY `weight` (`weight`),
  KEY `hascomments` (`hascomments`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=81 ;

--
-- Dumping data for table `sim_modules`
--

INSERT INTO `sim_modules` (`mid`, `name`, `version`, `last_update`, `weight`, `isactive`, `dirname`, `hasmain`, `hasadmin`, `hassearch`, `hasconfig`, `hascomments`, `hasnotification`) VALUES
(1, 'System', 200, 1268966326, 0, 1, 'system', 0, 1, 0, 0, 0, 0),
(2, 'Private Messaging', 103, 1268966480, 1, 1, 'pm', 1, 1, 0, 1, 0, 0),
(3, 'User Profile', 157, 1268966480, 1, 1, 'profile', 1, 1, 0, 1, 0, 0),
(4, 'Protector', 340, 1268966480, 1, 1, 'protector', 0, 1, 0, 1, 0, 0),
(61, 'Setup', 90, 1282987091, 1, 1, 'simantz', 1, 1, 0, 0, 0, 0),
(68, 'Pending Approval', 90, 1281348596, 50, 1, 'approval', 1, 1, 0, 0, 0, 0),
(66, 'Business Partner', 90, 1281348596, 20, 1, 'bpartner', 1, 1, 0, 0, 0, 0),
(80, 'SimBiz Accounting System', 90, 1282987622, 1, 1, 'simbiz', 1, 1, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `sim_newblocks`
--

CREATE TABLE IF NOT EXISTS `sim_newblocks` (
  `bid` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `mid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `func_num` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `options` varchar(255) NOT NULL DEFAULT '',
  `name` varchar(150) NOT NULL DEFAULT '',
  `title` varchar(255) NOT NULL DEFAULT '',
  `content` text,
  `side` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `weight` smallint(5) unsigned NOT NULL DEFAULT '0',
  `visible` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `block_type` char(1) NOT NULL DEFAULT '',
  `c_type` char(1) NOT NULL DEFAULT '',
  `isactive` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `dirname` varchar(50) NOT NULL DEFAULT '',
  `func_file` varchar(50) NOT NULL DEFAULT '',
  `show_func` varchar(50) NOT NULL DEFAULT '',
  `edit_func` varchar(50) NOT NULL DEFAULT '',
  `template` varchar(50) NOT NULL DEFAULT '',
  `bcachetime` int(10) unsigned NOT NULL DEFAULT '0',
  `last_modified` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`bid`),
  KEY `mid` (`mid`),
  KEY `visible` (`visible`),
  KEY `isactive_visible_mid` (`isactive`,`visible`,`mid`),
  KEY `mid_funcnum` (`mid`,`func_num`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=47 ;

--
-- Dumping data for table `sim_newblocks`
--

INSERT INTO `sim_newblocks` (`bid`, `mid`, `func_num`, `options`, `name`, `title`, `content`, `side`, `weight`, `visible`, `block_type`, `c_type`, `isactive`, `dirname`, `func_file`, `show_func`, `edit_func`, `template`, `bcachetime`, `last_modified`) VALUES
(46, 61, 1, '10', 'History', 'History', '', 0, 0, 0, 'M', 'H', 1, 'simitframework', 'historyblock.php', 'showHistory', 'editHistoryCount', 'sideblockshortcut.html', 0, 1280070992);

-- --------------------------------------------------------

--
-- Table structure for table `sim_online`
--

CREATE TABLE IF NOT EXISTS `sim_online` (
  `online_uid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `online_uname` varchar(25) NOT NULL DEFAULT '',
  `online_updated` int(10) unsigned NOT NULL DEFAULT '0',
  `online_module` smallint(5) unsigned NOT NULL DEFAULT '0',
  `online_ip` varchar(15) NOT NULL DEFAULT '',
  KEY `online_module` (`online_module`),
  KEY `online_updated` (`online_updated`),
  KEY `online_uid` (`online_uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sim_online`
--


-- --------------------------------------------------------

--
-- Table structure for table `sim_organization`
--

CREATE TABLE IF NOT EXISTS `sim_organization` (
  `organization_id` int(11) NOT NULL AUTO_INCREMENT,
  `organization_code` varchar(7) NOT NULL,
  `organization_name` varchar(50) NOT NULL,
  `companyno` varchar(15) NOT NULL,
  `street1` varchar(100) NOT NULL,
  `street2` varchar(100) NOT NULL,
  `street3` varchar(100) NOT NULL,
  `city` varchar(40) NOT NULL,
  `state` varchar(30) NOT NULL,
  `country_id` int(11) NOT NULL,
  `tel_1` varchar(30) NOT NULL,
  `tel_2` varchar(30) NOT NULL,
  `fax` varchar(30) NOT NULL,
  `url` varchar(120) NOT NULL,
  `email` varchar(120) NOT NULL,
  `seqno` smallint(6) NOT NULL,
  `isactive` smallint(6) NOT NULL,
  `createdby` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `updatedby` int(11) NOT NULL,
  `updated` datetime NOT NULL,
  `currency_id` int(11) NOT NULL,
  `groupid` smallint(5) NOT NULL,
  `postcode` varchar(6) NOT NULL,
  `accrued_acc` int(11) NOT NULL,
  `socso_acc` int(11) NOT NULL,
  `epf_acc` int(11) NOT NULL,
  `salary_acc` int(11) NOT NULL,
  PRIMARY KEY (`organization_id`),
  UNIQUE KEY `organization_code` (`organization_code`),
  UNIQUE KEY `organization_name` (`organization_name`),
  KEY `currency_id` (`currency_id`),
  KEY `country_id` (`country_id`),
  KEY `group_id` (`groupid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `sim_organization`
--

INSERT INTO `sim_organization` (`organization_id`, `organization_code`, `organization_name`, `companyno`, `street1`, `street2`, `street3`, `city`, `state`, `country_id`, `tel_1`, `tel_2`, `fax`, `url`, `email`, `seqno`, `isactive`, `createdby`, `created`, `updatedby`, `updated`, `currency_id`, `groupid`, `postcode`, `accrued_acc`, `socso_acc`, `epf_acc`, `salary_acc`) VALUES
(0, '--', '--', '', '', '', '', '', '', 0, '', '', '', '', '', 0, 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, 1, '', 0, 0, 0, 0),
(1, 'HIUMEN', 'SIM IT SDN BHD', '792899-U', '01-39, Jalan Mutiara Emas 9/3', 'Taman Mount Austin', '', 'Johor Bahru', 'Johor', 3, '0197725330', '073511757', '073511757', 'http://www.simit.com.my', 'sales@simit.com.my', 10, 1, 1, '2009-01-06 22:58:05', 1, '2010-08-21 09:24:51', 3, 2, '81100', 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `sim_period`
--

CREATE TABLE IF NOT EXISTS `sim_period` (
  `period_id` int(11) NOT NULL AUTO_INCREMENT,
  `period_name` varchar(50) NOT NULL,
  `isactive` smallint(6) NOT NULL,
  `seqno` smallint(6) NOT NULL,
  `period_year` smallint(6) NOT NULL,
  `period_month` smallint(6) NOT NULL,
  `created` datetime NOT NULL,
  `createdby` int(11) NOT NULL,
  `updated` datetime NOT NULL,
  `updatedby` int(11) NOT NULL,
  `isdeleted` smallint(1) NOT NULL,
  PRIMARY KEY (`period_id`),
  UNIQUE KEY `period_name` (`period_name`),
  UNIQUE KEY `period_year` (`period_year`,`period_month`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `sim_period`
--

INSERT INTO `sim_period` (`period_id`, `period_name`, `isactive`, `seqno`, `period_year`, `period_month`, `created`, `createdby`, `updated`, `updatedby`, `isdeleted`) VALUES
(0, '', 0, 0, 0, 0, '0000-00-00 00:00:00', 1, '0000-00-00 00:00:00', 0, 0),
(1, '2010-01', 1, 10, 2010, 1, '2010-08-28 17:50:24', 1, '2010-08-28 17:50:24', 1, 0),
(2, '2010-02', 1, 10, 2010, 2, '2010-08-28 17:50:24', 1, '2010-08-28 17:50:24', 1, 0),
(3, '2010-03', 1, 10, 2010, 3, '2010-08-28 17:50:24', 1, '2010-08-28 17:50:24', 1, 0),
(4, '2010-04', 1, 10, 2010, 4, '2010-08-28 17:50:24', 1, '2010-08-28 17:50:24', 1, 0),
(5, '2010-05', 1, 10, 2010, 5, '2010-08-28 17:50:24', 1, '2010-08-28 17:50:24', 1, 0),
(6, '2010-06', 1, 10, 2010, 6, '2010-08-28 17:50:24', 1, '2010-08-28 17:50:24', 1, 0),
(7, '2010-07', 1, 10, 2010, 7, '2010-08-28 17:50:24', 1, '2010-08-28 17:50:24', 1, 0),
(8, '2010-08', 1, 10, 2010, 8, '2010-08-28 17:50:24', 1, '2010-08-28 17:50:24', 1, 0),
(9, '2010-09', 1, 10, 2010, 9, '2010-08-28 17:50:24', 1, '2010-08-28 17:50:24', 1, 0),
(10, '2010-10', 1, 10, 2010, 10, '2010-08-28 17:50:24', 1, '2010-08-28 17:50:24', 1, 0),
(11, '2010-11', 1, 10, 2010, 11, '2010-08-28 17:50:24', 1, '2010-08-28 17:50:24', 1, 0),
(12, '2010-12', 1, 10, 2010, 12, '2010-08-28 17:50:24', 1, '2010-08-28 17:50:24', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `sim_permission`
--

CREATE TABLE IF NOT EXISTS `sim_permission` (
  `permission_id` int(11) NOT NULL AUTO_INCREMENT,
  `window_id` smallint(5) NOT NULL DEFAULT '0',
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `createdby` int(5) NOT NULL DEFAULT '0',
  `updated` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updatedby` int(5) NOT NULL DEFAULT '0',
  `groupid` smallint(6) NOT NULL DEFAULT '0',
  `permissionsetting` varchar(255) NOT NULL,
  `validuntil` date NOT NULL,
  `isreadonlyperm` smallint(6) NOT NULL,
  `iswriteperm` smallint(6) NOT NULL,
  PRIMARY KEY (`permission_id`),
  KEY `groupid` (`groupid`),
  KEY `window_id` (`window_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2335 ;

--
-- Dumping data for table `sim_permission`
--

INSERT INTO `sim_permission` (`permission_id`, `window_id`, `created`, `createdby`, `updated`, `updatedby`, `groupid`, `permissionsetting`, `validuntil`, `isreadonlyperm`, `iswriteperm`) VALUES
(1, 1, '2010-07-25 15:18:31', 1, '2010-07-25 15:18:31', 1, 1, '', '0000-00-00', 0, 1),
(2, 3, '2010-07-25 15:18:31', 1, '2010-07-25 15:18:31', 1, 1, '', '0000-00-00', 0, 1),
(3, 4, '2010-07-25 15:18:31', 1, '2010-07-25 15:18:31', 1, 1, '', '0000-00-00', 0, 1),
(4, 5, '2010-07-25 15:18:31', 1, '2010-07-25 15:18:31', 1, 1, '', '0000-00-00', 0, 1),
(5, 6, '2010-07-25 15:18:31', 1, '2010-07-25 15:18:31', 1, 1, '', '0000-00-00', 0, 1),
(6, 7, '2010-07-25 15:18:31', 1, '2010-07-25 15:18:31', 1, 1, '', '0000-00-00', 0, 1),
(7, 8, '2010-07-25 15:18:31', 1, '2010-07-25 15:18:31', 1, 1, '', '0000-00-00', 0, 1),
(8, 2, '2010-07-25 15:18:31', 1, '2010-07-25 15:18:31', 1, 1, '', '0000-00-00', 0, 1),
(9, 9, '2010-07-25 15:18:31', 1, '2010-07-25 15:18:31', 1, 1, '', '0000-00-00', 0, 1),
(10, 10, '2010-07-25 15:18:31', 1, '2010-07-25 15:18:31', 1, 1, '', '0000-00-00', 0, 1),
(11, 11, '2010-07-25 15:18:31', 1, '2010-07-25 15:18:31', 1, 1, '', '0000-00-00', 0, 1),
(12, 12, '2010-07-25 15:18:31', 1, '2010-07-25 15:18:31', 1, 1, '', '0000-00-00', 0, 1),
(13, 13, '2010-07-25 15:18:31', 1, '2010-07-25 15:18:31', 1, 1, '', '0000-00-00', 0, 1),
(356, 1, '2010-08-03 08:57:07', 1, '2010-08-03 08:57:07', 1, 2, '', '0000-00-00', 0, 0),
(357, 3, '2010-08-03 08:57:07', 1, '2010-08-03 08:57:07', 1, 2, '', '0000-00-00', 0, 0),
(358, 4, '2010-08-03 08:57:07', 1, '2010-08-03 08:57:07', 1, 2, '', '0000-00-00', 0, 0),
(359, 5, '2010-08-03 08:57:07', 1, '2010-08-03 08:57:07', 1, 2, '', '0000-00-00', 0, 0),
(360, 6, '2010-08-03 08:57:07', 1, '2010-08-03 08:57:07', 1, 2, '', '0000-00-00', 0, 0),
(361, 7, '2010-08-03 08:57:07', 1, '2010-08-03 08:57:07', 1, 2, '', '0000-00-00', 0, 0),
(362, 8, '2010-08-03 08:57:07', 1, '2010-08-03 08:57:07', 1, 2, '', '0000-00-00', 0, 0),
(363, 2, '2010-08-03 08:57:07', 1, '2010-08-03 08:57:07', 1, 2, '', '0000-00-00', 0, 0),
(364, 9, '2010-08-03 08:57:07', 1, '2010-08-03 08:57:07', 1, 2, '', '0000-00-00', 0, 0),
(365, 10, '2010-08-03 08:57:07', 1, '2010-08-03 08:57:07', 1, 2, '', '0000-00-00', 0, 0),
(366, 11, '2010-08-03 08:57:07', 1, '2010-08-03 08:57:07', 1, 2, '', '0000-00-00', 0, 0),
(367, 12, '2010-08-03 08:57:07', 1, '2010-08-03 08:57:07', 1, 2, '', '0000-00-00', 0, 0),
(368, 13, '2010-08-03 08:57:07', 1, '2010-08-03 08:57:07', 1, 2, '', '0000-00-00', 0, 0),
(429, 51, '2010-08-05 14:08:37', 1, '2010-08-05 14:08:37', 1, 1, '', '0000-00-00', 0, 1),
(430, 52, '2010-08-05 14:08:37', 1, '2010-08-05 14:08:37', 1, 1, '', '0000-00-00', 0, 1),
(431, 53, '2010-08-10 06:44:04', 1, '2010-08-10 06:44:04', 1, 1, '', '0000-00-00', 0, 1),
(432, 34, '2010-08-10 06:44:04', 1, '2010-08-10 06:44:04', 1, 1, '', '0000-00-00', 0, 1),
(433, 54, '2010-08-10 06:44:04', 1, '2010-08-10 06:44:04', 1, 1, '', '0000-00-00', 0, 1),
(434, 35, '2010-08-10 06:44:04', 1, '2010-08-10 06:44:04', 1, 1, '', '0000-00-00', 0, 1),
(435, 36, '2010-08-10 06:44:04', 1, '2010-08-10 06:44:04', 1, 1, '', '0000-00-00', 0, 1),
(436, 37, '2010-08-10 06:44:04', 1, '2010-08-10 06:44:04', 1, 1, '', '0000-00-00', 0, 1),
(446, 58, '2010-08-12 11:53:42', 1, '2010-08-12 11:53:42', 1, 1, '', '0000-00-00', 0, 1),
(447, 59, '2010-08-12 11:53:42', 1, '2010-08-12 11:53:42', 1, 1, '', '0000-00-00', 0, 1),
(448, 60, '2010-08-12 11:53:42', 1, '2010-08-12 11:53:42', 1, 1, '', '0000-00-00', 0, 1),
(694, 32, '2010-08-15 15:53:53', 1, '2010-08-15 15:53:53', 1, 1, '', '0000-00-00', 0, 1),
(695, 76, '2010-08-15 15:53:53', 1, '2010-08-15 15:53:53', 1, 1, '', '0000-00-00', 0, 1),
(696, 77, '2010-08-15 15:53:53', 1, '2010-08-15 15:53:53', 1, 1, '', '0000-00-00', 0, 1),
(840, 15, '2010-08-17 13:30:47', 1, '2010-08-17 13:30:47', 1, 5, '', '0000-00-00', 0, 1),
(841, 71, '2010-08-17 13:30:47', 1, '2010-08-17 13:30:47', 1, 5, '', '0000-00-00', 0, 1),
(842, 72, '2010-08-17 13:30:47', 1, '2010-08-17 13:30:47', 1, 5, '', '0000-00-00', 0, 1),
(843, 73, '2010-08-17 13:30:47', 1, '2010-08-17 13:30:47', 1, 5, '', '0000-00-00', 0, 1),
(844, 21, '2010-08-17 13:30:47', 1, '2010-08-17 13:30:47', 1, 5, '', '0000-00-00', 0, 1),
(845, 69, '2010-08-17 13:30:47', 1, '2010-08-17 13:30:47', 1, 5, '', '0000-00-00', 0, 1),
(846, 70, '2010-08-17 13:30:47', 1, '2010-08-17 13:30:47', 1, 5, '', '0000-00-00', 0, 1),
(847, 19, '2010-08-17 13:30:47', 1, '2010-08-17 13:30:47', 1, 5, '', '0000-00-00', 0, 1),
(848, 23, '2010-08-17 13:30:47', 1, '2010-08-17 13:30:47', 1, 5, '', '0000-00-00', 0, 1),
(849, 20, '2010-08-17 13:30:47', 1, '2010-08-17 13:30:47', 1, 5, '', '0000-00-00', 0, 1),
(850, 22, '2010-08-17 13:30:47', 1, '2010-08-17 13:30:47', 1, 5, '', '0000-00-00', 0, 1),
(851, 18, '2010-08-17 13:30:47', 1, '2010-08-17 13:30:47', 1, 5, '', '0000-00-00', 0, 1),
(852, 24, '2010-08-17 13:30:47', 1, '2010-08-17 13:30:47', 1, 5, '', '0000-00-00', 0, 1),
(853, 78, '2010-08-17 13:30:47', 1, '2010-08-17 13:30:47', 1, 5, '', '0000-00-00', 0, 1),
(854, 16, '2010-08-17 13:30:47', 1, '2010-08-17 13:30:47', 1, 5, '', '0000-00-00', 0, 1),
(855, 74, '2010-08-17 13:30:47', 1, '2010-08-17 13:30:47', 1, 5, '', '0000-00-00', 0, 1),
(856, 27, '2010-08-17 13:30:47', 1, '2010-08-17 13:30:47', 1, 5, '', '0000-00-00', 0, 1),
(857, 28, '2010-08-17 13:30:47', 1, '2010-08-17 13:30:47', 1, 5, '', '0000-00-00', 0, 1),
(858, 29, '2010-08-17 13:30:47', 1, '2010-08-17 13:30:47', 1, 5, '', '0000-00-00', 0, 1),
(859, 30, '2010-08-17 13:30:47', 1, '2010-08-17 13:30:47', 1, 5, '', '0000-00-00', 0, 1),
(860, 31, '2010-08-17 13:30:47', 1, '2010-08-17 13:30:47', 1, 5, '', '0000-00-00', 0, 1),
(861, 75, '2010-08-17 13:30:47', 1, '2010-08-17 13:30:47', 1, 5, '', '0000-00-00', 0, 1),
(862, 25, '2010-08-17 13:30:47', 1, '2010-08-17 13:30:47', 1, 5, '', '0000-00-00', 0, 1),
(863, 26, '2010-08-17 13:30:47', 1, '2010-08-17 13:30:47', 1, 5, '', '0000-00-00', 0, 1),
(864, 17, '2010-08-17 13:30:47', 1, '2010-08-17 13:30:47', 1, 5, '', '0000-00-00', 0, 1),
(865, 38, '2010-08-17 13:30:47', 1, '2010-08-17 13:30:47', 1, 5, '', '0000-00-00', 0, 1),
(866, 39, '2010-08-17 13:30:47', 1, '2010-08-17 13:30:47', 1, 5, '', '0000-00-00', 0, 1),
(867, 40, '2010-08-17 13:30:47', 1, '2010-08-17 13:30:47', 1, 5, '', '0000-00-00', 0, 1),
(868, 41, '2010-08-17 13:30:47', 1, '2010-08-17 13:30:47', 1, 5, '', '0000-00-00', 0, 1),
(869, 42, '2010-08-17 13:30:47', 1, '2010-08-17 13:30:47', 1, 5, '', '0000-00-00', 0, 1),
(870, 43, '2010-08-17 13:30:47', 1, '2010-08-17 13:30:47', 1, 5, '', '0000-00-00', 0, 1),
(871, 44, '2010-08-17 13:30:47', 1, '2010-08-17 13:30:47', 1, 5, '', '0000-00-00', 0, 1),
(872, 45, '2010-08-17 13:30:47', 1, '2010-08-17 13:30:47', 1, 5, '', '0000-00-00', 0, 1),
(873, 46, '2010-08-17 13:30:47', 1, '2010-08-17 13:30:47', 1, 5, '', '0000-00-00', 0, 1),
(874, 47, '2010-08-17 13:30:47', 1, '2010-08-17 13:30:47', 1, 5, '', '0000-00-00', 0, 1),
(875, 48, '2010-08-17 13:30:47', 1, '2010-08-17 13:30:47', 1, 5, '', '0000-00-00', 0, 1),
(876, 49, '2010-08-17 13:30:47', 1, '2010-08-17 13:30:47', 1, 5, '', '0000-00-00', 0, 1),
(877, 50, '2010-08-17 13:30:47', 1, '2010-08-17 13:30:47', 1, 5, '', '0000-00-00', 0, 1),
(878, 67, '2010-08-17 13:30:47', 1, '2010-08-17 13:30:47', 1, 5, '', '0000-00-00', 0, 1),
(879, 68, '2010-08-17 13:30:47', 1, '2010-08-17 13:30:47', 1, 5, '', '0000-00-00', 0, 1),
(880, 79, '2010-08-17 13:30:47', 1, '2010-08-17 13:30:47', 1, 5, '', '0000-00-00', 0, 1),
(881, 61, '2010-08-17 13:30:47', 1, '2010-08-17 13:30:47', 1, 5, '', '0000-00-00', 0, 1),
(882, 62, '2010-08-17 13:30:47', 1, '2010-08-17 13:30:47', 1, 5, '', '0000-00-00', 0, 1),
(883, 63, '2010-08-17 13:30:47', 1, '2010-08-17 13:30:47', 1, 5, '', '0000-00-00', 0, 1),
(884, 64, '2010-08-17 13:30:47', 1, '2010-08-17 13:30:47', 1, 5, '', '0000-00-00', 0, 1),
(885, 65, '2010-08-17 13:30:47', 1, '2010-08-17 13:30:47', 1, 5, '', '0000-00-00', 0, 1),
(886, 66, '2010-08-17 13:30:47', 1, '2010-08-17 13:30:47', 1, 5, '', '0000-00-00', 0, 1),
(887, 33, '2010-08-17 13:30:47', 1, '2010-08-17 13:30:47', 1, 5, '', '0000-00-00', 0, 1),
(936, 15, '2010-08-17 13:35:39', 1, '2010-08-17 13:35:39', 1, 4, '', '0000-00-00', 0, 1),
(937, 71, '2010-08-17 13:35:39', 1, '2010-08-17 13:35:39', 1, 4, '', '0000-00-00', 0, 1),
(938, 72, '2010-08-17 13:35:39', 1, '2010-08-17 13:35:39', 1, 4, '', '0000-00-00', 0, 1),
(939, 73, '2010-08-17 13:35:39', 1, '2010-08-17 13:35:39', 1, 4, '', '0000-00-00', 0, 1),
(940, 21, '2010-08-17 13:35:39', 1, '2010-08-17 13:35:39', 1, 4, '', '0000-00-00', 0, 1),
(941, 69, '2010-08-17 13:35:39', 1, '2010-08-17 13:35:39', 1, 4, '', '0000-00-00', 0, 1),
(942, 70, '2010-08-17 13:35:39', 1, '2010-08-17 13:35:39', 1, 4, '', '0000-00-00', 0, 1),
(943, 19, '2010-08-17 13:35:39', 1, '2010-08-17 13:35:39', 1, 4, '', '0000-00-00', 0, 1),
(944, 23, '2010-08-17 13:35:39', 1, '2010-08-17 13:35:39', 1, 4, '', '0000-00-00', 0, 1),
(945, 20, '2010-08-17 13:35:39', 1, '2010-08-17 13:35:39', 1, 4, '', '0000-00-00', 0, 1),
(946, 22, '2010-08-17 13:35:39', 1, '2010-08-17 13:35:39', 1, 4, '', '0000-00-00', 0, 1),
(947, 18, '2010-08-17 13:35:39', 1, '2010-08-17 13:35:39', 1, 4, '', '0000-00-00', 0, 1),
(948, 24, '2010-08-17 13:35:39', 1, '2010-08-17 13:35:39', 1, 4, '$viewappraisal=1,$viewpayroll=1', '0000-00-00', 0, 1),
(949, 78, '2010-08-17 13:35:39', 1, '2010-08-17 13:35:39', 1, 4, '', '0000-00-00', 0, 1),
(950, 16, '2010-08-17 13:35:39', 1, '2010-08-17 13:35:39', 1, 4, '', '0000-00-00', 0, 1),
(951, 74, '2010-08-17 13:35:39', 1, '2010-08-17 13:35:39', 1, 4, '', '0000-00-00', 0, 1),
(952, 27, '2010-08-17 13:35:39', 1, '2010-08-17 13:35:39', 1, 4, '', '0000-00-00', 0, 1),
(953, 28, '2010-08-17 13:35:39', 1, '2010-08-17 13:35:39', 1, 4, '', '0000-00-00', 0, 1),
(954, 29, '2010-08-17 13:35:39', 1, '2010-08-17 13:35:39', 1, 4, '', '0000-00-00', 0, 1),
(955, 30, '2010-08-17 13:35:39', 1, '2010-08-17 13:35:39', 1, 4, '', '0000-00-00', 0, 1),
(956, 31, '2010-08-17 13:35:39', 1, '2010-08-17 13:35:39', 1, 4, '', '0000-00-00', 0, 1),
(957, 75, '2010-08-17 13:35:39', 1, '2010-08-17 13:35:39', 1, 4, '', '0000-00-00', 0, 1),
(958, 25, '2010-08-17 13:35:39', 1, '2010-08-17 13:35:39', 1, 4, '', '0000-00-00', 0, 1),
(959, 26, '2010-08-17 13:35:39', 1, '2010-08-17 13:35:39', 1, 4, '', '0000-00-00', 0, 1),
(960, 17, '2010-08-17 13:35:39', 1, '2010-08-17 13:35:39', 1, 4, '', '0000-00-00', 0, 1),
(961, 38, '2010-08-17 13:35:39', 1, '2010-08-17 13:35:39', 1, 4, '', '0000-00-00', 0, 1),
(962, 39, '2010-08-17 13:35:39', 1, '2010-08-17 13:35:39', 1, 4, '', '0000-00-00', 0, 1),
(963, 40, '2010-08-17 13:35:39', 1, '2010-08-17 13:35:39', 1, 4, '', '0000-00-00', 0, 1),
(964, 41, '2010-08-17 13:35:39', 1, '2010-08-17 13:35:39', 1, 4, '', '0000-00-00', 0, 1),
(965, 42, '2010-08-17 13:35:39', 1, '2010-08-17 13:35:39', 1, 4, '', '0000-00-00', 0, 1),
(966, 43, '2010-08-17 13:35:39', 1, '2010-08-17 13:35:39', 1, 4, '', '0000-00-00', 0, 1),
(967, 44, '2010-08-17 13:35:39', 1, '2010-08-17 13:35:39', 1, 4, '', '0000-00-00', 0, 1),
(968, 45, '2010-08-17 13:35:39', 1, '2010-08-17 13:35:39', 1, 4, '', '0000-00-00', 0, 1),
(969, 46, '2010-08-17 13:35:39', 1, '2010-08-17 13:35:39', 1, 4, '', '0000-00-00', 0, 1),
(970, 47, '2010-08-17 13:35:39', 1, '2010-08-17 13:35:39', 1, 4, '', '0000-00-00', 0, 1),
(971, 48, '2010-08-17 13:35:39', 1, '2010-08-17 13:35:39', 1, 4, '', '0000-00-00', 0, 1),
(972, 49, '2010-08-17 13:35:39', 1, '2010-08-17 13:35:39', 1, 4, '', '0000-00-00', 0, 1),
(973, 50, '2010-08-17 13:35:39', 1, '2010-08-17 13:35:39', 1, 4, '', '0000-00-00', 0, 1),
(974, 67, '2010-08-17 13:35:39', 1, '2010-08-17 13:35:39', 1, 4, '', '0000-00-00', 0, 1),
(975, 68, '2010-08-17 13:35:39', 1, '2010-08-17 13:35:39', 1, 4, '', '0000-00-00', 0, 1),
(976, 79, '2010-08-17 13:35:39', 1, '2010-08-17 13:35:39', 1, 4, '', '0000-00-00', 0, 1),
(977, 61, '2010-08-17 13:35:39', 1, '2010-08-17 13:35:39', 1, 4, '', '0000-00-00', 0, 1),
(978, 62, '2010-08-17 13:35:39', 1, '2010-08-17 13:35:39', 1, 4, '', '0000-00-00', 0, 1),
(979, 63, '2010-08-17 13:35:39', 1, '2010-08-17 13:35:39', 1, 4, '', '0000-00-00', 0, 1),
(980, 64, '2010-08-17 13:35:39', 1, '2010-08-17 13:35:39', 1, 4, '', '0000-00-00', 0, 1),
(981, 65, '2010-08-17 13:35:39', 1, '2010-08-17 13:35:39', 1, 4, '', '0000-00-00', 0, 1),
(982, 66, '2010-08-17 13:35:39', 1, '2010-08-17 13:35:39', 1, 4, '', '0000-00-00', 0, 1),
(983, 33, '2010-08-17 13:35:39', 1, '2010-08-17 13:35:39', 1, 4, '', '0000-00-00', 0, 1),
(2123, 15, '2010-08-17 16:20:38', 1, '2010-08-17 16:20:38', 1, 2, '', '0000-00-00', 0, 0),
(2124, 21, '2010-08-17 16:20:38', 1, '2010-08-17 16:20:38', 1, 2, '', '0000-00-00', 0, 0),
(2125, 19, '2010-08-17 16:20:38', 1, '2010-08-17 16:20:38', 1, 2, '', '0000-00-00', 0, 0),
(2126, 23, '2010-08-17 16:20:38', 1, '2010-08-17 16:20:38', 1, 2, '', '0000-00-00', 0, 0),
(2127, 20, '2010-08-17 16:20:38', 1, '2010-08-17 16:20:38', 1, 2, '', '0000-00-00', 0, 0),
(2128, 22, '2010-08-17 16:20:38', 1, '2010-08-17 16:20:38', 1, 2, '', '0000-00-00', 0, 0),
(2129, 18, '2010-08-17 16:20:38', 1, '2010-08-17 16:20:38', 1, 2, '', '0000-00-00', 0, 0),
(2130, 24, '2010-08-17 16:20:38', 1, '2010-08-17 16:20:38', 1, 2, '', '0000-00-00', 0, 0),
(2131, 16, '2010-08-17 16:20:38', 1, '2010-08-17 16:20:38', 1, 2, '', '0000-00-00', 0, 0),
(2132, 27, '2010-08-17 16:20:38', 1, '2010-08-17 16:20:38', 1, 2, '', '0000-00-00', 0, 0),
(2133, 28, '2010-08-17 16:20:38', 1, '2010-08-17 16:20:38', 1, 2, '', '0000-00-00', 0, 0),
(2134, 29, '2010-08-17 16:20:38', 1, '2010-08-17 16:20:38', 1, 2, '', '0000-00-00', 0, 0),
(2135, 30, '2010-08-17 16:20:38', 1, '2010-08-17 16:20:38', 1, 2, '', '0000-00-00', 0, 0),
(2136, 31, '2010-08-17 16:20:38', 1, '2010-08-17 16:20:38', 1, 2, '', '0000-00-00', 0, 0),
(2137, 25, '2010-08-17 16:20:38', 1, '2010-08-17 16:20:38', 1, 2, '', '0000-00-00', 0, 0),
(2138, 26, '2010-08-17 16:20:38', 1, '2010-08-17 16:20:38', 1, 2, '', '0000-00-00', 0, 0),
(2139, 17, '2010-08-17 16:20:38', 1, '2010-08-17 16:20:38', 1, 2, '', '0000-00-00', 0, 0),
(2140, 33, '2010-08-17 16:20:38', 1, '2010-08-17 16:20:38', 1, 2, '', '0000-00-00', 0, 0),
(2240, 15, '2010-08-19 11:39:57', 1, '2010-08-19 11:39:57', 1, 1, '', '0000-00-00', 0, 1),
(2241, 69, '2010-08-19 11:39:57', 1, '2010-08-19 11:39:57', 1, 1, '', '0000-00-00', 0, 1),
(2242, 70, '2010-08-19 11:39:57', 1, '2010-08-19 11:39:57', 1, 1, '', '0000-00-00', 0, 1),
(2243, 71, '2010-08-19 11:39:57', 1, '2010-08-19 11:39:57', 1, 1, '', '0000-00-00', 0, 1),
(2244, 72, '2010-08-19 11:39:57', 1, '2010-08-19 11:39:57', 1, 1, '', '0000-00-00', 0, 1),
(2245, 19, '2010-08-19 11:39:57', 1, '2010-08-19 11:39:57', 1, 1, '', '0000-00-00', 0, 1),
(2246, 20, '2010-08-19 11:39:57', 1, '2010-08-19 11:39:57', 1, 1, '', '0000-00-00', 0, 1),
(2247, 18, '2010-08-19 11:39:57', 1, '2010-08-19 11:39:57', 1, 1, '', '0000-00-00', 0, 1),
(2248, 22, '2010-08-19 11:39:57', 1, '2010-08-19 11:39:57', 1, 1, '', '0000-00-00', 0, 1),
(2249, 80, '2010-08-19 11:39:57', 1, '2010-08-19 11:39:57', 1, 1, '', '0000-00-00', 0, 1),
(2250, 21, '2010-08-19 11:39:57', 1, '2010-08-19 11:39:57', 1, 1, '', '0000-00-00', 0, 1),
(2251, 23, '2010-08-19 11:39:57', 1, '2010-08-19 11:39:57', 1, 1, '', '0000-00-00', 0, 1),
(2252, 81, '2010-08-19 11:39:57', 1, '2010-08-19 11:39:57', 1, 1, '', '0000-00-00', 0, 1),
(2253, 24, '2010-08-19 11:39:57', 1, '2010-08-19 11:39:57', 1, 1, '$viewappraisal=1,$viewpayroll=1', '0000-00-00', 0, 1),
(2254, 78, '2010-08-19 11:39:57', 1, '2010-08-19 11:39:57', 1, 1, '', '0000-00-00', 0, 1),
(2255, 73, '2010-08-19 11:39:57', 1, '2010-08-19 11:39:57', 1, 1, '', '0000-00-00', 0, 1),
(2256, 16, '2010-08-19 11:39:57', 1, '2010-08-19 11:39:57', 1, 1, '', '0000-00-00', 0, 1),
(2257, 74, '2010-08-19 11:39:57', 1, '2010-08-19 11:39:57', 1, 1, '', '0000-00-00', 0, 1),
(2258, 27, '2010-08-19 11:39:57', 1, '2010-08-19 11:39:57', 1, 1, '', '0000-00-00', 0, 1),
(2259, 28, '2010-08-19 11:39:57', 1, '2010-08-19 11:39:57', 1, 1, '', '0000-00-00', 0, 1),
(2260, 29, '2010-08-19 11:39:57', 1, '2010-08-19 11:39:57', 1, 1, '', '0000-00-00', 0, 1),
(2261, 30, '2010-08-19 11:39:57', 1, '2010-08-19 11:39:57', 1, 1, '', '0000-00-00', 0, 1),
(2262, 31, '2010-08-19 11:39:57', 1, '2010-08-19 11:39:57', 1, 1, '', '0000-00-00', 0, 1),
(2263, 75, '2010-08-19 11:39:57', 1, '2010-08-19 11:39:57', 1, 1, '', '0000-00-00', 0, 1),
(2264, 25, '2010-08-19 11:39:57', 1, '2010-08-19 11:39:57', 1, 1, '', '0000-00-00', 0, 1),
(2265, 82, '2010-08-19 11:39:57', 1, '2010-08-19 11:39:57', 1, 1, '', '0000-00-00', 0, 1),
(2266, 26, '2010-08-19 11:39:57', 1, '2010-08-19 11:39:57', 1, 1, '', '0000-00-00', 0, 1),
(2267, 17, '2010-08-19 11:39:57', 1, '2010-08-19 11:39:57', 1, 1, '', '0000-00-00', 0, 1),
(2268, 39, '2010-08-19 11:39:57', 1, '2010-08-19 11:39:57', 1, 1, '', '0000-00-00', 0, 1),
(2269, 48, '2010-08-19 11:39:57', 1, '2010-08-19 11:39:57', 1, 1, '', '0000-00-00', 0, 1),
(2270, 67, '2010-08-19 11:39:57', 1, '2010-08-19 11:39:57', 1, 1, '', '0000-00-00', 0, 1),
(2271, 68, '2010-08-19 11:39:57', 1, '2010-08-19 11:39:57', 1, 1, '', '0000-00-00', 0, 1),
(2272, 61, '2010-08-19 11:39:57', 1, '2010-08-19 11:39:57', 1, 1, '', '0000-00-00', 0, 1),
(2273, 62, '2010-08-19 11:39:57', 1, '2010-08-19 11:39:57', 1, 1, '', '0000-00-00', 0, 1),
(2274, 63, '2010-08-19 11:39:57', 1, '2010-08-19 11:39:57', 1, 1, '', '0000-00-00', 0, 1),
(2275, 64, '2010-08-19 11:39:57', 1, '2010-08-19 11:39:57', 1, 1, '', '0000-00-00', 0, 1),
(2276, 65, '2010-08-19 11:39:57', 1, '2010-08-19 11:39:57', 1, 1, '', '0000-00-00', 0, 1),
(2277, 66, '2010-08-19 11:39:57', 1, '2010-08-19 11:39:57', 1, 1, '', '0000-00-00', 0, 1),
(2278, 38, '2010-08-19 11:39:57', 1, '2010-08-19 11:39:57', 1, 1, '', '0000-00-00', 0, 1),
(2279, 40, '2010-08-19 11:39:57', 1, '2010-08-19 11:39:57', 1, 1, '', '0000-00-00', 0, 1),
(2280, 41, '2010-08-19 11:39:57', 1, '2010-08-19 11:39:57', 1, 1, '', '0000-00-00', 0, 1),
(2281, 42, '2010-08-19 11:39:57', 1, '2010-08-19 11:39:57', 1, 1, '', '0000-00-00', 0, 1),
(2282, 43, '2010-08-19 11:39:57', 1, '2010-08-19 11:39:57', 1, 1, '', '0000-00-00', 0, 1),
(2283, 44, '2010-08-19 11:39:57', 1, '2010-08-19 11:39:57', 1, 1, '', '0000-00-00', 0, 1),
(2284, 45, '2010-08-19 11:39:57', 1, '2010-08-19 11:39:57', 1, 1, '', '0000-00-00', 0, 1),
(2285, 46, '2010-08-19 11:39:57', 1, '2010-08-19 11:39:57', 1, 1, '', '0000-00-00', 0, 1),
(2286, 47, '2010-08-19 11:39:57', 1, '2010-08-19 11:39:57', 1, 1, '', '0000-00-00', 0, 1),
(2287, 79, '2010-08-19 11:39:57', 1, '2010-08-19 11:39:57', 1, 1, '', '0000-00-00', 0, 1),
(2288, 49, '2010-08-19 11:39:57', 1, '2010-08-19 11:39:57', 1, 1, '', '0000-00-00', 0, 1),
(2289, 50, '2010-08-19 11:39:57', 1, '2010-08-19 11:39:57', 1, 1, '', '0000-00-00', 0, 1),
(2290, 33, '2010-08-19 11:39:57', 1, '2010-08-19 11:39:57', 1, 1, '', '0000-00-00', 0, 1),
(2291, 116, '2010-08-28 17:34:29', 1, '2010-08-28 17:34:29', 1, 1, '', '0000-00-00', 0, 1),
(2292, 117, '2010-08-28 17:34:29', 1, '2010-08-28 17:34:29', 1, 1, '', '0000-00-00', 0, 1),
(2293, 121, '2010-08-28 17:34:29', 1, '2010-08-28 17:34:29', 1, 1, '', '0000-00-00', 0, 1),
(2294, 122, '2010-08-28 17:34:29', 1, '2010-08-28 17:34:29', 1, 1, '', '0000-00-00', 0, 1),
(2295, 123, '2010-08-28 17:34:29', 1, '2010-08-28 17:34:29', 1, 1, '', '0000-00-00', 0, 1),
(2296, 118, '2010-08-28 17:34:29', 1, '2010-08-28 17:34:29', 1, 1, '', '0000-00-00', 0, 1),
(2297, 119, '2010-08-28 17:34:29', 1, '2010-08-28 17:34:29', 1, 1, '', '0000-00-00', 0, 1),
(2298, 124, '2010-08-28 17:34:29', 1, '2010-08-28 17:34:29', 1, 1, '', '0000-00-00', 0, 1),
(2299, 125, '2010-08-28 17:34:29', 1, '2010-08-28 17:34:29', 1, 1, '', '0000-00-00', 0, 1),
(2300, 126, '2010-08-28 17:34:29', 1, '2010-08-28 17:34:29', 1, 1, '', '0000-00-00', 0, 1),
(2301, 120, '2010-08-28 17:34:29', 1, '2010-08-28 17:34:29', 1, 1, '', '0000-00-00', 0, 1),
(2302, 150, '2010-08-28 17:34:29', 1, '2010-08-28 17:34:29', 1, 1, '', '0000-00-00', 0, 1),
(2303, 128, '2010-08-28 17:34:29', 1, '2010-08-28 17:34:29', 1, 1, '', '0000-00-00', 0, 1),
(2304, 129, '2010-08-28 17:34:29', 1, '2010-08-28 17:34:29', 1, 1, '', '0000-00-00', 0, 1),
(2305, 127, '2010-08-28 17:34:29', 1, '2010-08-28 17:34:29', 1, 1, '', '0000-00-00', 0, 1),
(2306, 130, '2010-08-28 17:34:29', 1, '2010-08-28 17:34:29', 1, 1, '', '0000-00-00', 0, 1),
(2307, 131, '2010-08-28 17:34:29', 1, '2010-08-28 17:34:29', 1, 1, '', '0000-00-00', 0, 1),
(2308, 132, '2010-08-28 17:34:29', 1, '2010-08-28 17:34:29', 1, 1, '', '0000-00-00', 0, 1),
(2309, 133, '2010-08-28 17:34:29', 1, '2010-08-28 17:34:29', 1, 1, '', '0000-00-00', 0, 1),
(2310, 134, '2010-08-28 17:34:29', 1, '2010-08-28 17:34:29', 1, 1, '', '0000-00-00', 0, 1),
(2311, 135, '2010-08-28 17:34:29', 1, '2010-08-28 17:34:29', 1, 1, '', '0000-00-00', 0, 1),
(2312, 136, '2010-08-28 17:34:29', 1, '2010-08-28 17:34:29', 1, 1, '', '0000-00-00', 0, 1),
(2313, 137, '2010-08-28 17:34:29', 1, '2010-08-28 17:34:29', 1, 1, '', '0000-00-00', 0, 1),
(2314, 138, '2010-08-28 17:34:29', 1, '2010-08-28 17:34:29', 1, 1, '', '0000-00-00', 0, 1),
(2315, 139, '2010-08-28 17:34:29', 1, '2010-08-28 17:34:29', 1, 1, '', '0000-00-00', 0, 1),
(2316, 140, '2010-08-28 17:34:29', 1, '2010-08-28 17:34:29', 1, 1, '', '0000-00-00', 0, 1),
(2317, 141, '2010-08-28 17:34:29', 1, '2010-08-28 17:34:29', 1, 1, '', '0000-00-00', 0, 1),
(2318, 142, '2010-08-28 17:34:29', 1, '2010-08-28 17:34:29', 1, 1, '', '0000-00-00', 0, 1),
(2319, 143, '2010-08-28 17:34:29', 1, '2010-08-28 17:34:29', 1, 1, '', '0000-00-00', 0, 1),
(2320, 144, '2010-08-28 17:34:29', 1, '2010-08-28 17:34:29', 1, 1, '', '0000-00-00', 0, 1),
(2321, 145, '2010-08-28 17:34:29', 1, '2010-08-28 17:34:29', 1, 1, '', '0000-00-00', 0, 1),
(2322, 146, '2010-08-28 17:34:29', 1, '2010-08-28 17:34:29', 1, 1, '', '0000-00-00', 0, 1),
(2323, 148, '2010-08-28 17:34:29', 1, '2010-08-28 17:34:29', 1, 1, '', '0000-00-00', 0, 1),
(2324, 149, '2010-08-28 17:34:29', 1, '2010-08-28 17:34:29', 1, 1, '', '0000-00-00', 0, 1),
(2325, 158, '2010-08-28 17:34:29', 1, '2010-08-28 17:34:29', 1, 1, '', '0000-00-00', 0, 1),
(2326, 157, '2010-08-28 17:34:29', 1, '2010-08-28 17:34:29', 1, 1, '', '0000-00-00', 0, 1),
(2327, 156, '2010-08-28 17:34:29', 1, '2010-08-28 17:34:29', 1, 1, '', '0000-00-00', 0, 1),
(2328, 153, '2010-08-28 17:34:29', 1, '2010-08-28 17:34:29', 1, 1, '', '0000-00-00', 0, 1),
(2329, 159, '2010-08-28 17:34:29', 1, '2010-08-28 17:34:29', 1, 1, '', '0000-00-00', 0, 1),
(2330, 154, '2010-08-28 17:34:29', 1, '2010-08-28 17:34:29', 1, 1, '', '0000-00-00', 0, 1),
(2331, 152, '2010-08-28 17:34:29', 1, '2010-08-28 17:34:29', 1, 1, '', '0000-00-00', 0, 1),
(2332, 151, '2010-08-28 17:34:29', 1, '2010-08-28 17:34:29', 1, 1, '', '0000-00-00', 0, 1),
(2333, 160, '2010-08-28 17:34:29', 1, '2010-08-28 17:34:29', 1, 1, '', '0000-00-00', 0, 1),
(2334, 155, '2010-08-28 17:34:29', 1, '2010-08-28 17:34:29', 1, 1, '', '0000-00-00', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `sim_priv_msgs`
--

CREATE TABLE IF NOT EXISTS `sim_priv_msgs` (
  `msg_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `msg_image` varchar(100) DEFAULT NULL,
  `subject` varchar(255) NOT NULL DEFAULT '',
  `from_userid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `to_userid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `msg_time` int(10) unsigned NOT NULL DEFAULT '0',
  `msg_text` text,
  `read_msg` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `from_delete` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `from_save` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `to_delete` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `to_save` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`msg_id`),
  KEY `to_userid` (`to_userid`),
  KEY `touseridreadmsg` (`to_userid`,`read_msg`),
  KEY `msgidfromuserid` (`from_userid`,`msg_id`),
  KEY `prune` (`msg_time`,`read_msg`,`from_save`,`to_delete`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=23 ;

--
-- Dumping data for table `sim_priv_msgs`
--


-- --------------------------------------------------------

--
-- Table structure for table `sim_profile_category`
--

CREATE TABLE IF NOT EXISTS `sim_profile_category` (
  `cat_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `cat_title` varchar(255) NOT NULL DEFAULT '',
  `cat_description` text,
  `cat_weight` smallint(5) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`cat_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `sim_profile_category`
--


-- --------------------------------------------------------

--
-- Table structure for table `sim_profile_field`
--

CREATE TABLE IF NOT EXISTS `sim_profile_field` (
  `field_id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `cat_id` smallint(5) unsigned NOT NULL DEFAULT '0',
  `field_type` varchar(30) NOT NULL DEFAULT '',
  `field_valuetype` tinyint(2) unsigned NOT NULL DEFAULT '0',
  `field_name` varchar(255) NOT NULL DEFAULT '',
  `field_title` varchar(255) NOT NULL DEFAULT '',
  `field_description` text,
  `field_required` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `field_maxlength` smallint(6) unsigned NOT NULL DEFAULT '0',
  `field_weight` smallint(6) unsigned NOT NULL DEFAULT '0',
  `field_default` text,
  `field_notnull` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `field_edit` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `field_show` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `field_config` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `field_options` text,
  `step_id` smallint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`field_id`),
  UNIQUE KEY `field_name` (`field_name`),
  KEY `step` (`step_id`,`field_weight`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `sim_profile_field`
--


-- --------------------------------------------------------

--
-- Table structure for table `sim_profile_profile`
--

CREATE TABLE IF NOT EXISTS `sim_profile_profile` (
  `profile_id` int(12) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`profile_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sim_profile_profile`
--


-- --------------------------------------------------------

--
-- Table structure for table `sim_profile_regstep`
--

CREATE TABLE IF NOT EXISTS `sim_profile_regstep` (
  `step_id` smallint(3) unsigned NOT NULL AUTO_INCREMENT,
  `step_name` varchar(255) NOT NULL DEFAULT '',
  `step_desc` text,
  `step_order` smallint(3) unsigned NOT NULL DEFAULT '0',
  `step_save` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`step_id`),
  KEY `sort` (`step_order`,`step_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `sim_profile_regstep`
--


-- --------------------------------------------------------

--
-- Table structure for table `sim_profile_visibility`
--

CREATE TABLE IF NOT EXISTS `sim_profile_visibility` (
  `field_id` int(12) unsigned NOT NULL DEFAULT '0',
  `user_group` smallint(5) unsigned NOT NULL DEFAULT '0',
  `profile_group` smallint(5) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`field_id`,`user_group`,`profile_group`),
  KEY `visible` (`user_group`,`profile_group`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sim_profile_visibility`
--


-- --------------------------------------------------------

--
-- Table structure for table `sim_protector_access`
--

CREATE TABLE IF NOT EXISTS `sim_protector_access` (
  `ip` varchar(255) NOT NULL DEFAULT '0.0.0.0',
  `request_uri` varchar(255) NOT NULL DEFAULT '',
  `malicious_actions` varchar(255) NOT NULL DEFAULT '',
  `expire` int(11) NOT NULL DEFAULT '0',
  KEY `ip` (`ip`),
  KEY `request_uri` (`request_uri`),
  KEY `malicious_actions` (`malicious_actions`),
  KEY `expire` (`expire`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sim_protector_access`
--

INSERT INTO `sim_protector_access` (`ip`, `request_uri`, `malicious_actions`, `expire`) VALUES
('::1', '/simantz/modules/hr/chartleave_1month.php', '', 1282239272);

-- --------------------------------------------------------

--
-- Table structure for table `sim_protector_log`
--

CREATE TABLE IF NOT EXISTS `sim_protector_log` (
  `lid` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `uid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `ip` varchar(255) NOT NULL DEFAULT '0.0.0.0',
  `type` varchar(255) NOT NULL DEFAULT '',
  `agent` varchar(255) NOT NULL DEFAULT '',
  `description` text,
  `extra` text,
  `timestamp` datetime DEFAULT NULL,
  PRIMARY KEY (`lid`),
  KEY `uid` (`uid`),
  KEY `ip` (`ip`),
  KEY `type` (`type`),
  KEY `timestamp` (`timestamp`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=44 ;

--
-- Dumping data for table `sim_protector_log`
--

INSERT INTO `sim_protector_log` (`lid`, `uid`, `ip`, `type`, `agent`, `description`, `extra`, `timestamp`) VALUES
(18, 1, '::1', 'CRAWLER', 'Mozilla/5.0 (X11; U; Linux i686; en-US; rv:1.9.2.6) Gecko/20100628 Ubuntu/10.04 (lucid) Firefox/3.6.6 GTB7.1', '', NULL, '2010-07-24 13:09:15'),
(19, 1, '::1', 'DoS', 'Mozilla/5.0 (X11; U; Linux i686; en-US; rv:1.9.2.6) Gecko/20100628 Ubuntu/10.04 (lucid) Firefox/3.6.6 GTB7.1', '', NULL, '2010-07-24 13:10:12'),
(20, 1, '::1', 'CRAWLER', 'Mozilla/5.0 (Macintosh; U; Intel Mac OS X 10.6; en-US; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3 GTB7.1', '', NULL, '2010-07-25 21:56:00'),
(21, 0, '::1', 'UPLOAD', 'Mozilla/5.0 (X11; U; Linux x86_64; en-US; rv:1.9.2.8) Gecko/20100723 Ubuntu/10.04 (lucid) Firefox/3.6.8', 'Attempt to upload camouflaged image file Screenshot1.jpeg.\n', NULL, '2010-07-28 16:02:10'),
(22, 0, '::1', 'UPLOAD', 'Mozilla/5.0 (X11; U; Linux x86_64; en-US; rv:1.9.2.8) Gecko/20100723 Ubuntu/10.04 (lucid) Firefox/3.6.8', 'Attempt to upload camouflaged image file Screenshot1.jpeg.\n', NULL, '2010-07-28 16:02:27'),
(23, 0, '::1', 'UPLOAD', 'Mozilla/5.0 (X11; U; Linux x86_64; en-US; rv:1.9.2.8) Gecko/20100723 Ubuntu/10.04 (lucid) Firefox/3.6.8', 'Attempt to upload camouflaged image file Screenshot1.jpeg.\n', NULL, '2010-07-28 16:05:43'),
(24, 0, '::1', 'UPLOAD', 'Mozilla/5.0 (X11; U; Linux x86_64; en-US; rv:1.9.2.8) Gecko/20100723 Ubuntu/10.04 (lucid) Firefox/3.6.8', 'Attempt to upload camouflaged image file Screenshot1.jpeg.\n', NULL, '2010-07-28 16:06:05'),
(25, 0, '::1', 'UPLOAD', 'Mozilla/5.0 (X11; U; Linux x86_64; en-US; rv:1.9.2.8) Gecko/20100723 Ubuntu/10.04 (lucid) Firefox/3.6.8', 'Attempt to upload camouflaged image file Screenshot1.jpeg.\n', NULL, '2010-07-28 16:06:36'),
(26, 1, '::1', 'CRAWLER', 'Mozilla/5.0 (X11; U; Linux x86_64; en-US; rv:1.9.2.8) Gecko/20100723 Ubuntu/10.04 (lucid) Firefox/3.6.8', '', NULL, '2010-07-28 16:06:43'),
(27, 0, '::1', 'UPLOAD', 'Mozilla/5.0 (X11; U; Linux x86_64; en-US; rv:1.9.2.8) Gecko/20100723 Ubuntu/10.04 (lucid) Firefox/3.6.8', 'Attempt to upload camouflaged image file Screenshot1.jpeg.\n', NULL, '2010-07-28 17:31:51'),
(28, 1, '::1', 'CRAWLER', 'Mozilla/5.0 (X11; U; Linux x86_64; en-US; rv:1.9.2.8) Gecko/20100723 Ubuntu/10.04 (lucid) Firefox/3.6.8', '', NULL, '2010-07-28 22:51:10'),
(29, 0, '::1', 'SQL Injection', 'Mozilla/5.0 (X11; U; Linux x86_64; en-US; rv:1.9.2.8) Gecko/20100723 Ubuntu/10.04 (lucid) Firefox/3.6.8', 'INSERT INTO sim_audit(tablename,primarykey,record_id,category,eventype,uid,uname,ip,changedesc,updated,controlvalue) VALUES\n            (''sim_hr_department'',''department_id'',''33'',''I'',''S'',1,''admin'',''::1'',''department_no=\\''\\'' \\"dfds\\''department_name=\\''\\'' \\"dfds\\''defaultlevel=\\''10\\''description=\\''\\''department_parent=\\''0\\''isactive=\\''1\\''created=\\''2010-07-29 18:07:23\\''createdby=\\''1\\''updated=\\''2010-07-29 18:07:23\\''updatedby=\\''1\\''organization_id=\\''1\\''department_head=\\''0'',''10/07/29 18:07:23'','''' "dfds'')', NULL, '2010-07-29 18:07:23'),
(30, 1, '::1', 'CRAWLER', 'Mozilla/5.0 (X11; U; Linux x86_64; en-US; rv:1.9.2.8) Gecko/20100723 Ubuntu/10.04 (lucid) Firefox/3.6.8', '', NULL, '2010-07-29 18:55:52'),
(31, 1, '::1', 'DoS', 'Mozilla/5.0 (X11; U; Linux x86_64; en-US; rv:1.9.2.8) Gecko/20100723 Ubuntu/10.04 (lucid) Firefox/3.6.8', '', NULL, '2010-07-30 06:26:24'),
(32, 1, '::1', 'CRAWLER', 'Mozilla/5.0 (X11; U; Linux i686; en-US; rv:1.9.2.6) Gecko/20100625 Firefox/3.6.6', '', NULL, '2010-07-30 19:43:53'),
(33, 1, '::1', 'DoS', 'Mozilla/5.0 (X11; U; Linux i686; en-US; rv:1.9.2.6) Gecko/20100625 Firefox/3.6.6', '', NULL, '2010-07-30 20:37:12'),
(34, 1, '::1', 'CRAWLER', 'Mozilla/5.0 (X11; U; Linux i686; en-US; rv:1.9.2.6) Gecko/20100625 Firefox/3.6.6', '', NULL, '2010-07-30 20:37:25'),
(35, 1, '::1', 'DoS', 'Mozilla/5.0 (X11; U; Linux x86_64; en-US; rv:1.9.2.8) Gecko/20100723 Ubuntu/10.04 (lucid) Firefox/3.6.8', '', NULL, '2010-08-13 16:47:46'),
(36, 1, '::1', 'CRAWLER', 'Mozilla/5.0 (X11; U; Linux x86_64; en-US; rv:1.9.2.8) Gecko/20100723 Ubuntu/10.04 (lucid) Firefox/3.6.8', '', NULL, '2010-08-13 17:19:37'),
(37, 0, '::1', 'DoS', 'Mozilla/5.0 (X11; U; Linux i686; en-US; rv:1.9.2.8) Gecko/20100723 Ubuntu/10.04 (lucid) Firefox/3.6.8 GTB7.1', '', NULL, '2010-08-15 00:19:48'),
(38, 1, '::1', 'CRAWLER', 'Mozilla/5.0 (X11; U; Linux i686; en-US; rv:1.9.2.8) Gecko/20100723 Ubuntu/10.04 (lucid) Firefox/3.6.8 GTB7.1', '', NULL, '2010-08-15 15:39:01'),
(39, 0, '127.0.0.1', 'SQL Injection', 'Mozilla/5.0 (X11; U; Linux x86_64; en-US; rv:1.9.2.8) Gecko/20100723 Ubuntu/10.04 (lucid) Firefox/3.6.8', 'INSERT INTO sim_permission (window_id,groupid,updated,updatedby,\n				created,createdby,permissionsetting,validuntil,iswriteperm) VALUES\n                                (24,1,''10/08/17 13:39:07'',1,''10/08/17 13:39:07'',\n                            1,''''viewappraisal''=>''1'',''viewpayroll''=''1'''',''0000-00-00'',\n                                1)', NULL, '2010-08-17 13:39:08'),
(40, 0, '127.0.0.1', 'SQL Injection', 'Mozilla/5.0 (X11; U; Linux x86_64; en-US; rv:1.9.2.8) Gecko/20100723 Ubuntu/10.04 (lucid) Firefox/3.6.8', 'INSERT INTO sim_permission (window_id,groupid,updated,updatedby,\n				created,createdby,permissionsetting,validuntil,iswriteperm) VALUES\n                                (24,1,''10/08/17 13:39:30'',1,''10/08/17 13:39:30'',\n                            1,''''viewappraisal''=>''1'',''viewpayroll''=''1'''','''',\n                                1)', NULL, '2010-08-17 13:39:30'),
(41, 1869, '::1', 'CRAWLER', 'Mozilla/5.0 (X11; U; Linux x86_64; en-US; rv:1.9.2.8) Gecko/20100723 Ubuntu/10.04 (lucid) Firefox/3.6.8', '', NULL, '2010-08-17 16:33:57'),
(42, 0, '::1', 'UPLOAD', 'Mozilla/5.0 (X11; U; Linux x86_64; en-US; rv:1.9.2.8) Gecko/20100723 Ubuntu/10.04 (lucid) Firefox/3.6.8', 'Attempt to upload camouflaged image file Screenshot1.jpeg.\n', NULL, '2010-08-19 09:35:20'),
(43, 0, '::1', 'UPLOAD', 'Mozilla/5.0 (X11; U; Linux x86_64; en-US; rv:1.9.2.8) Gecko/20100723 Ubuntu/10.04 (lucid) Firefox/3.6.8', 'Attempt to upload camouflaged image file Screenshot1.jpeg.\n', NULL, '2010-08-19 09:41:51');

-- --------------------------------------------------------

--
-- Table structure for table `sim_races`
--

CREATE TABLE IF NOT EXISTS `sim_races` (
  `races_id` int(11) NOT NULL AUTO_INCREMENT,
  `races_name` varchar(20) NOT NULL DEFAULT '',
  `isactive` smallint(1) NOT NULL,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updatedby` int(11) NOT NULL DEFAULT '0',
  `created` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `createdby` int(11) NOT NULL DEFAULT '0',
  `races_description` varchar(255) NOT NULL DEFAULT '',
  `isdeleted` smallint(6) NOT NULL,
  `seqno` int(11) NOT NULL,
  `organization_id` int(11) NOT NULL,
  PRIMARY KEY (`races_id`),
  UNIQUE KEY `races_name` (`races_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `sim_races`
--

INSERT INTO `sim_races` (`races_id`, `races_name`, `isactive`, `updated`, `updatedby`, `created`, `createdby`, `races_description`, `isdeleted`, `seqno`, `organization_id`) VALUES
(0, '--', 0, '2010-08-12 11:43:33', 1, '0000-00-00 00:00:00', 0, '', 1, 0, 0),
(1, 'Chinese', 1, '2010-08-02 15:46:41', 1, '2010-07-27 09:53:56', 1, 'C', 0, 10, 1),
(2, 'Malay', 1, '2010-07-27 09:57:33', 1, '2010-07-27 09:53:56', 1, 'M', 0, 10, 1),
(3, 'Indian', 1, '2010-07-27 09:57:33', 1, '2010-07-27 09:53:56', 1, 'I', 0, 10, 1),
(4, 'Bumiputra', 1, '2010-08-15 18:44:02', 1, '2010-07-27 09:53:56', 1, 'B', 0, 10, 1),
(5, 'Others', 1, '2010-08-12 17:18:19', 1870, '2010-08-02 15:47:10', 1, 'O', 0, 999, 1);

-- --------------------------------------------------------

--
-- Table structure for table `sim_ranks`
--

CREATE TABLE IF NOT EXISTS `sim_ranks` (
  `rank_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `rank_title` varchar(50) NOT NULL DEFAULT '',
  `rank_min` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `rank_max` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `rank_special` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `rank_image` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`rank_id`),
  KEY `rank_min` (`rank_min`),
  KEY `rank_max` (`rank_max`),
  KEY `rankminrankmaxranspecial` (`rank_min`,`rank_max`,`rank_special`),
  KEY `rankspecial` (`rank_special`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `sim_ranks`
--


-- --------------------------------------------------------

--
-- Table structure for table `sim_region`
--

CREATE TABLE IF NOT EXISTS `sim_region` (
  `region_id` int(11) NOT NULL AUTO_INCREMENT,
  `country_id` int(11) NOT NULL,
  `region_name` varchar(40) NOT NULL,
  `isactive` smallint(1) NOT NULL,
  `seqno` smallint(3) NOT NULL,
  `created` datetime NOT NULL,
  `createdby` int(11) NOT NULL,
  `updated` datetime NOT NULL,
  `updatedby` int(11) NOT NULL,
  `organization_id` int(11) NOT NULL,
  `isdeleted` smallint(6) NOT NULL,
  PRIMARY KEY (`region_id`),
  KEY `organization_id` (`organization_id`),
  KEY `country_id` (`country_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

--
-- Dumping data for table `sim_region`
--

INSERT INTO `sim_region` (`region_id`, `country_id`, `region_name`, `isactive`, `seqno`, `created`, `createdby`, `updated`, `updatedby`, `organization_id`, `isdeleted`) VALUES
(1, 3, 'Johor', 1, 10, '2010-08-10 09:57:49', 1, '2010-08-15 20:31:21', 1, 1, 0),
(2, 3, 'Kuantan', 1, 10, '2010-08-10 10:02:40', 1, '2010-08-12 17:24:51', 1870, 1, 0),
(3, 3, 'Pulau Pinang', 1, 10, '2010-08-10 10:06:48', 1, '2010-08-12 17:25:36', 1870, 1, 0),
(9, 3, 'Negeri Sembilan', 1, 10, '2010-08-12 17:24:51', 1870, '2010-08-12 17:24:51', 1870, 1, 0),
(10, 3, 'Selangor', 1, 10, '2010-08-12 17:24:51', 1870, '2010-08-12 17:24:51', 1870, 1, 0),
(11, 3, 'Pahang', 1, 10, '2010-08-12 17:24:51', 1870, '2010-08-12 17:24:51', 1870, 1, 0),
(12, 3, 'Perak', 1, 10, '2010-08-12 17:24:51', 1870, '2010-08-12 17:24:51', 1870, 1, 0),
(13, 3, 'Kedah', 1, 10, '2010-08-12 17:24:51', 1870, '2010-08-12 17:24:51', 1870, 1, 0),
(14, 3, 'Terengganu', 1, 10, '2010-08-12 17:24:51', 1870, '2010-08-12 17:24:51', 1870, 1, 0),
(15, 3, 'Sabah', 1, 10, '2010-08-12 17:24:51', 1870, '2010-08-12 17:24:51', 1870, 1, 0),
(16, 3, 'Sarawak', 1, 10, '2010-08-12 17:24:51', 1870, '2010-08-12 17:24:51', 1870, 1, 0),
(17, 3, 'Perlis', 1, 10, '2010-08-12 17:25:36', 1870, '2010-08-12 17:25:36', 1870, 1, 0),
(18, 3, 'Kelantan', 1, 10, '2010-08-12 17:25:55', 1870, '2010-08-12 17:25:55', 1870, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `sim_religion`
--

CREATE TABLE IF NOT EXISTS `sim_religion` (
  `religion_id` int(11) NOT NULL AUTO_INCREMENT,
  `religion_name` varchar(20) NOT NULL,
  `isactive` char(1) NOT NULL DEFAULT '',
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updatedby` int(11) NOT NULL DEFAULT '0',
  `created` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `createdby` int(11) NOT NULL DEFAULT '0',
  `religion_description` varchar(255) NOT NULL,
  `isdeleted` smallint(6) NOT NULL,
  `seqno` smallint(6) NOT NULL,
  `organization_id` int(11) NOT NULL,
  PRIMARY KEY (`religion_id`),
  UNIQUE KEY `religion_name` (`religion_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `sim_religion`
--

INSERT INTO `sim_religion` (`religion_id`, `religion_name`, `isactive`, `updated`, `updatedby`, `created`, `createdby`, `religion_description`, `isdeleted`, `seqno`, `organization_id`) VALUES
(0, '--', '0', '2010-08-12 18:20:40', 0, '0000-00-00 00:00:00', 0, '', 0, 0, 0),
(1, 'Buddhist', '1', '2010-08-17 17:43:21', 1, '2010-07-27 10:05:07', 1, 'B', 0, 10, 1),
(2, 'Christian', '1', '2010-07-27 10:05:23', 1, '2010-07-27 10:05:07', 1, 'C', 0, 10, 1),
(3, 'Hindu', '1', '2010-07-27 10:05:23', 1, '2010-07-27 10:05:07', 1, 'H', 0, 10, 1),
(4, 'Muslim', '1', '2010-07-27 10:05:07', 1, '2010-07-27 10:05:07', 1, 'M', 0, 10, 1),
(5, 'Bumiputra', '1', '2010-08-12 17:20:47', 1870, '2010-08-03 09:02:36', 1, 'P', 0, 10, 1);

-- --------------------------------------------------------

--
-- Table structure for table `sim_session`
--

CREATE TABLE IF NOT EXISTS `sim_session` (
  `sess_id` varchar(32) NOT NULL DEFAULT '',
  `sess_updated` int(10) unsigned NOT NULL DEFAULT '0',
  `sess_ip` varchar(15) NOT NULL DEFAULT '',
  `sess_data` text,
  PRIMARY KEY (`sess_id`),
  KEY `updated` (`sess_updated`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sim_session`
--

INSERT INTO `sim_session` (`sess_id`, `sess_updated`, `sess_ip`, `sess_data`) VALUES
('v6o5erusfn390a8848gknftsv3', 1283076878, '::1', 'xoopsUserId|s:1:"1";xoopsUserGroups|a:2:{i:0;s:1:"1";i:1;s:1:"2";}xoopsUserTheme|s:7:"default";defaultorganization_id|s:1:"1";sql_txt_20100829181345|s:0:"";sql_txt_20100829181347|s:0:"";sql_txt_20100829181348|s:0:"";sql_txt_20100829181349|s:0:"";sql_txt_20100829181352|s:0:"";sql_txt_20100829181353|s:0:"";sql_txt_20100829181355|s:0:"";sql_txt_20100829181403|s:0:"";sql_txt_20100829181404|s:0:"";sql_txt_20100829181405|s:0:"";sql_txt_20100829181406|s:0:"";sql_txt_20100829181414|s:0:"";sql_txt_20100829181415|s:0:"";sql_txt_20100829181438|s:0:"";');

-- --------------------------------------------------------

--
-- Table structure for table `sim_simbiz_accountclass`
--

CREATE TABLE IF NOT EXISTS `sim_simbiz_accountclass` (
  `accountclass_id` int(11) NOT NULL AUTO_INCREMENT,
  `accountclass_name` varchar(40) NOT NULL,
  `defaultlevel` smallint(5) NOT NULL DEFAULT '10',
  `isactive` smallint(5) NOT NULL DEFAULT '1',
  `classtype` char(2) NOT NULL,
  PRIMARY KEY (`accountclass_id`),
  UNIQUE KEY `accountclass_name` (`accountclass_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `sim_simbiz_accountclass`
--

INSERT INTO `sim_simbiz_accountclass` (`accountclass_id`, `accountclass_name`, `defaultlevel`, `isactive`, `classtype`) VALUES
(0, 'Unknown', 10, 1, ''),
(1, 'Assets', 10, 1, '5A'),
(2, 'Liabilities', 10, 1, '6L'),
(3, 'Equity', 10, 1, '7E'),
(4, 'Sales', 10, 1, '1S'),
(5, 'Costs Of Sales', 10, 1, '2C'),
(6, 'Memo', 10, 1, '8M'),
(7, 'Expenses', 10, 1, '4X'),
(8, 'Others Income', 10, 1, '3O');

-- --------------------------------------------------------

--
-- Table structure for table `sim_simbiz_accountgroup`
--

CREATE TABLE IF NOT EXISTS `sim_simbiz_accountgroup` (
  `accountgroup_id` int(11) NOT NULL AUTO_INCREMENT,
  `accountgroup_name` varchar(40) NOT NULL,
  `isactive` smallint(6) NOT NULL,
  `defaultlevel` smallint(6) NOT NULL,
  `description` varchar(100) NOT NULL,
  `accountclass_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `createdby` int(11) NOT NULL,
  `updated` datetime NOT NULL,
  `updatedby` int(11) NOT NULL,
  `organization_id` int(11) NOT NULL,
  `initial` smallint(6) NOT NULL,
  PRIMARY KEY (`accountgroup_id`),
  KEY `accountclass_id` (`accountclass_id`),
  KEY `organization_id` (`organization_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `sim_simbiz_accountgroup`
--

INSERT INTO `sim_simbiz_accountgroup` (`accountgroup_id`, `accountgroup_name`, `isactive`, `defaultlevel`, `description`, `accountclass_id`, `created`, `createdby`, `updated`, `updatedby`, `organization_id`, `initial`) VALUES
(0, '', 0, 0, '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, 0, 0),
(1, 'Assets', 1, 10, '', 1, '2009-08-23 14:02:34', 1, '2010-03-22 11:21:08', 1, 1, 1),
(2, 'COGS', 1, 10, '', 5, '2009-08-23 14:02:34', 1, '2009-11-10 13:02:53', 528, 1, 5),
(3, 'Sales', 1, 10, '', 4, '2009-08-23 14:02:34', 1, '2009-11-10 13:02:38', 528, 1, 4),
(4, 'Liabilities', 1, 10, '', 2, '2009-08-23 14:02:34', 1, '2009-11-10 13:02:29', 528, 1, 2),
(5, 'Equity', 1, 10, '', 3, '2009-08-23 14:02:34', 1, '2009-11-10 13:02:13', 528, 1, 3),
(6, 'Others Income', 1, 10, '', 8, '2009-08-23 14:02:34', 1, '2009-11-10 13:03:18', 528, 1, 7),
(7, 'Memo', 1, 10, '', 6, '2009-08-23 14:02:34', 1, '2009-11-10 13:03:27', 528, 1, 8),
(8, 'Expenses', 1, 10, '', 7, '2009-08-23 14:02:34', 1, '2009-11-10 13:03:04', 528, 1, 6);

-- --------------------------------------------------------

--
-- Table structure for table `sim_simbiz_accounts`
--

CREATE TABLE IF NOT EXISTS `sim_simbiz_accounts` (
  `accounts_id` int(11) NOT NULL AUTO_INCREMENT,
  `created` datetime NOT NULL,
  `createdby` int(11) NOT NULL,
  `updated` datetime NOT NULL,
  `updatedby` int(11) NOT NULL,
  `accounts_code` varchar(10) NOT NULL,
  `accounts_name` varchar(80) NOT NULL,
  `accountgroup_id` int(11) NOT NULL,
  `openingbalance` decimal(12,2) NOT NULL,
  `parentaccounts_id` int(11) NOT NULL,
  `placeholder` smallint(6) NOT NULL,
  `tax_id` int(11) NOT NULL,
  `lastbalance` decimal(12,2) NOT NULL,
  `organization_id` int(11) NOT NULL,
  `ishide` smallint(6) NOT NULL,
  `defaultlevel` smallint(6) NOT NULL,
  `description` varchar(50) NOT NULL,
  `treelevel` smallint(6) NOT NULL,
  `account_type` int(11) NOT NULL DEFAULT '0',
  `hierarchy` varchar(200) DEFAULT NULL,
  `accountcode_full` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`accounts_id`),
  UNIQUE KEY `accountcode_full` (`accountcode_full`),
  KEY `account_code` (`accounts_code`),
  KEY `parentaccount_id` (`parentaccounts_id`),
  KEY `accountgroup_id` (`accountgroup_id`),
  KEY `tax_id` (`tax_id`),
  KEY `organization_id` (`organization_id`),
  KEY `account_name` (`accounts_name`),
  KEY `hierarchy` (`hierarchy`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=59 ;

--
-- Dumping data for table `sim_simbiz_accounts`
--

INSERT INTO `sim_simbiz_accounts` (`accounts_id`, `created`, `createdby`, `updated`, `updatedby`, `accounts_code`, `accounts_name`, `accountgroup_id`, `openingbalance`, `parentaccounts_id`, `placeholder`, `tax_id`, `lastbalance`, `organization_id`, `ishide`, `defaultlevel`, `description`, `treelevel`, `account_type`, `hierarchy`, `accountcode_full`) VALUES
(0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '', 0, '0.00', 0, 0, 0, '0.00', 0, 0, 0, '', 0, 0, '', NULL),
(28, '2009-08-23 14:02:34', 1, '2009-08-23 14:02:34', 1, '1', 'Assets', 1, '0.00', 0, 1, 0, '19634.00', 1, 0, 10, '', 1, 1, '[28]', '1'),
(29, '2009-08-23 14:02:34', 1, '2009-08-23 14:02:34', 1, '2', 'Liabilities', 4, '0.00', 0, 1, 0, '0.00', 1, 0, 10, '', 1, 1, '[29]', '2'),
(30, '2009-08-23 14:02:34', 1, '2009-08-23 14:02:34', 1, '3', 'Equity', 5, '0.00', 0, 1, 0, '0.00', 1, 0, 10, '', 1, 1, '[30]', '3'),
(31, '2009-08-23 14:02:34', 1, '2009-08-23 14:02:34', 1, '4', 'Sales', 3, '0.00', 0, 1, 0, '-19134.00', 1, 0, 10, '', 1, 1, '[31]', '4'),
(32, '2009-08-23 14:02:34', 1, '2009-08-23 14:02:34', 1, '5', 'Cost Of Sales', 2, '0.00', 0, 1, 0, '3.00', 1, 0, 10, '', 1, 1, '[32]', '5'),
(33, '2009-08-23 14:02:34', 1, '2010-05-30 15:28:50', 1, '6', 'Expenses', 8, '0.00', 0, 1, 0, '-503.00', 1, 0, 10, '', 1, 1, '[33]', '6'),
(34, '2009-08-23 14:02:34', 1, '2009-08-23 14:02:34', 1, '7', 'Others Income', 6, '0.00', 0, 1, 0, '0.00', 1, 0, 10, '', 1, 1, '[34]', '7'),
(35, '2009-08-23 14:02:34', 1, '2009-08-23 14:02:34', 1, '8', 'Memo', 7, '0.00', 0, 1, 0, '0.00', 1, 0, 10, '', 1, 1, '[35]', '8'),
(36, '2009-08-23 14:02:34', 1, '2009-08-23 14:02:34', 1, '1', 'Current Asset', 1, '0.00', 28, 1, 0, '19284.00', 1, 0, 10, '', 2, 1, '[28][36]', '11'),
(37, '2009-08-23 14:02:34', 1, '2009-08-23 14:02:34', 1, '2', 'Fixed Asset', 1, '0.00', 28, 1, 0, '350.00', 1, 0, 10, '', 2, 1, '[28][37]', '12'),
(38, '2009-08-23 14:02:34', 1, '2009-08-23 14:02:34', 1, '1', 'Trade Creditor', 4, '0.00', 29, 0, 0, '0.00', 1, 0, 10, '', 2, 3, '[29][38]', '21'),
(39, '2009-08-23 14:02:34', 1, '2009-08-23 14:02:34', 1, '1', 'Opening Balance', 5, '0.00', 30, 0, 0, '0.00', 1, 0, 10, '', 2, 5, '[30][39]', '31'),
(40, '2009-08-23 14:02:34', 1, '2009-08-23 14:02:34', 1, '2', 'Retain Earning', 5, '0.00', 30, 0, 0, '0.00', 1, 0, 10, '', 2, 6, '[30][40]', '32'),
(41, '2009-08-23 14:02:34', 1, '2009-08-23 14:02:34', 1, '3', 'Capital', 5, '0.00', 30, 0, 0, '0.00', 1, 0, 10, '', 2, 1, '[30][41]', '33'),
(42, '2009-08-23 14:02:34', 1, '2009-08-23 14:02:34', 1, '1', 'Sales', 3, '0.00', 31, 0, 0, '-19534.00', 1, 0, 10, '', 2, 1, '[31][42]', '41'),
(43, '2009-08-23 14:02:34', 1, '2009-08-23 14:02:34', 1, '1', 'Purchase', 2, '0.00', 32, 0, 0, '3.00', 1, 0, 10, '', 2, 1, '[32][43]', '51'),
(44, '2009-08-23 14:02:34', 1, '2009-08-23 14:02:34', 1, '1', 'Salary', 8, '0.00', 33, 0, 0, '-500.00', 1, 0, 10, '', 2, 1, '[33][44]', '61'),
(45, '2009-08-23 14:02:34', 1, '2009-08-23 14:02:34', 1, '2', 'EPF', 8, '0.00', 33, 0, 0, '300.00', 1, 0, 10, '', 2, 1, '[33][45]', '62'),
(46, '2009-08-23 14:02:34', 1, '2009-08-23 14:02:34', 1, '3', 'Socso', 8, '0.00', 33, 0, 0, '-3.00', 1, 0, 10, '', 2, 1, '[33][46]', '63'),
(47, '2009-08-23 14:02:34', 1, '2009-08-23 14:02:34', 1, '4', 'Electric', 8, '0.00', 33, 0, 0, '-300.00', 1, 0, 10, '', 2, 1, '[33][47]', '64'),
(48, '2009-08-23 14:02:34', 1, '2009-08-23 14:02:34', 1, '5', 'Depreciation', 8, '0.00', 33, 0, 0, '0.00', 1, 0, 10, '', 2, 1, '[33][48]', '65'),
(49, '2009-08-23 14:02:34', 1, '2009-08-23 14:02:34', 1, '1', 'Retain Earning(Reverse Entry)', 7, '0.00', 35, 0, 0, '0.00', 1, 0, 10, '', 2, 1, '[35][49]', '81'),
(50, '2009-08-23 14:02:34', 1, '2009-08-23 14:02:34', 1, '1', 'Checking Account', 1, '0.00', 36, 0, 0, '8231.00', 1, 0, 10, '', 3, 4, '[28][36][50]', '111'),
(51, '2009-08-23 14:02:34', 1, '2009-08-23 14:02:34', 1, '2', 'Trade Debtor', 1, '0.00', 36, 0, 0, '4093.00', 1, 0, 10, '', 3, 2, '[28][36][51]', '112'),
(52, '2009-08-23 14:02:34', 1, '2010-08-01 13:36:44', 1, '3', 'Petty Cash', 1, '0.00', 36, 0, 0, '5100.00', 1, 0, 10, '', 3, 7, '[28][36][52]', '113'),
(53, '2009-08-23 14:02:34', 1, '2009-08-23 14:02:34', 1, '1', 'Office Furniture', 1, '0.00', 37, 0, 0, '350.00', 1, 0, 10, '', 3, 1, '[28][37][53]', '121'),
(54, '2009-08-23 14:02:34', 1, '2009-08-23 14:02:34', 1, '2', 'Accum. Depreciation Of Office Furniture', 1, '0.00', 37, 0, 0, '0.00', 1, 0, 10, '', 3, 1, '[28][37][54]', '122'),
(55, '2009-11-10 12:51:24', 528, '2009-11-10 12:51:24', 528, '2', 'Yuran Pengajian', 3, '0.00', 31, 0, 0, '400.00', 1, 0, 10, '', 2, 1, '[31][55]', '42'),
(56, '2010-03-28 16:19:23', 1, '2010-08-25 11:03:12', 1, '4', 'Cash Drawer', 1, '0.00', 36, 0, 0, '1960.00', 1, 0, 10, '', 3, 1, '[28][36][56]', '114'),
(57, '2010-03-28 17:57:59', 1, '2010-03-28 17:57:59', 1, '5', 'Student', 1, '0.00', 36, 0, 0, '-100.00', 1, 0, 10, '', 3, 2, '[28][36][57]', '115'),
(58, '2010-08-01 17:41:05', 1, '2010-08-01 17:41:05', 1, '', 'Accrued Expenses', 1, '0.00', 29, 0, 0, '0.00', 1, 0, 10, '', 0, 1, NULL, '22');

-- --------------------------------------------------------

--
-- Table structure for table `sim_simbiz_bankreconcilation`
--

CREATE TABLE IF NOT EXISTS `sim_simbiz_bankreconcilation` (
  `bankreconcilation_id` int(11) NOT NULL AUTO_INCREMENT,
  `bankreconcilationdate` date NOT NULL,
  `accounts_id` int(11) NOT NULL,
  `organization_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `createdby` int(11) NOT NULL,
  `updated` datetime NOT NULL,
  `updatedby` int(11) NOT NULL,
  `iscomplete` smallint(6) NOT NULL,
  `bankreconcilationno` varchar(20) NOT NULL,
  `statementbalance` decimal(14,2) NOT NULL,
  `account_balance` decimal(14,2) NOT NULL,
  `differenceamt` decimal(14,2) NOT NULL,
  `laststatementdate` date NOT NULL,
  `laststatementbalance` decimal(14,2) NOT NULL,
  `period_id` int(11) NOT NULL,
  `reconcilamt` decimal(14,2) NOT NULL,
  `unreconcilamt` decimal(14,2) NOT NULL,
  PRIMARY KEY (`bankreconcilation_id`),
  UNIQUE KEY `reconcilationno` (`organization_id`,`bankreconcilationno`),
  KEY `date` (`bankreconcilationdate`),
  KEY `accounts_id` (`accounts_id`),
  KEY `organization_id` (`organization_id`),
  KEY `documentno` (`bankreconcilationno`),
  KEY `period_id` (`period_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `sim_simbiz_bankreconcilation`
--

INSERT INTO `sim_simbiz_bankreconcilation` (`bankreconcilation_id`, `bankreconcilationdate`, `accounts_id`, `organization_id`, `created`, `createdby`, `updated`, `updatedby`, `iscomplete`, `bankreconcilationno`, `statementbalance`, `account_balance`, `differenceamt`, `laststatementdate`, `laststatementbalance`, `period_id`, `reconcilamt`, `unreconcilamt`) VALUES
(0, '0000-00-00', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, 0, '', '0.00', '0.00', '0.00', '0000-00-00', '0.00', 0, '0.00', '0.00'),
(11, '2010-08-01', 50, 1, '2010-08-01 13:39:39', 0, '2010-08-25 16:05:51', 1, 0, '1', '2909.00', '7432.00', '0.00', '2010-04-30', '1900.00', 6, '1009.00', '0.00');

-- --------------------------------------------------------

--
-- Table structure for table `sim_simbiz_batch`
--

CREATE TABLE IF NOT EXISTS `sim_simbiz_batch` (
  `batch_id` int(11) NOT NULL AUTO_INCREMENT,
  `organization_id` int(11) NOT NULL,
  `period_id` int(11) NOT NULL,
  `iscomplete` int(11) NOT NULL,
  `batchno` int(10) NOT NULL,
  `batch_name` varchar(50) NOT NULL,
  `description` varchar(255) NOT NULL,
  `created` datetime NOT NULL,
  `createdby` int(11) NOT NULL,
  `updated` datetime NOT NULL,
  `updatedby` int(11) NOT NULL,
  `reuse` smallint(6) NOT NULL,
  `totaldebit` decimal(12,2) NOT NULL,
  `totalcredit` decimal(12,2) NOT NULL,
  `fromsys` varchar(10) NOT NULL,
  `batchdate` date NOT NULL,
  `isreadonly` smallint(6) NOT NULL,
  `tax_type` smallint(1) NOT NULL DEFAULT '1',
  `track1_name` varchar(100) NOT NULL,
  `track2_name` varchar(100) NOT NULL,
  `track3_name` varchar(100) NOT NULL,
  PRIMARY KEY (`batch_id`),
  KEY `organization_id` (`organization_id`),
  KEY `period_id` (`period_id`),
  KEY `batchdate` (`batchdate`),
  KEY `batchno` (`batchno`),
  KEY `batch_name` (`batch_name`),
  KEY `updatedby` (`updatedby`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `sim_simbiz_batch`
--

INSERT INTO `sim_simbiz_batch` (`batch_id`, `organization_id`, `period_id`, `iscomplete`, `batchno`, `batch_name`, `description`, `created`, `createdby`, `updated`, `updatedby`, `reuse`, `totaldebit`, `totalcredit`, `fromsys`, `batchdate`, `isreadonly`, `tax_type`, `track1_name`, `track2_name`, `track3_name`) VALUES
(-1, 0, 0, 0, 2, 'asa', '', '0000-00-00 00:00:00', 0, '2010-08-13 10:45:28', 1, 0, '0.00', '0.00', '', '2010-08-18', 0, 1, '', '', ''),
(0, 0, 0, -1, 0, '', '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, 0, '0.00', '0.00', '', '0000-00-00', 0, 1, '', '', ''),
(1, 1, 8, 1, 201008001, 'asd', 'Sample', '2010-08-28 17:50:34', 1, '2010-08-28 17:51:26', 1, 0, '50.00', '50.00', '', '2010-08-12', 0, 1, 'Consultant', 'Salesman', 'Others'),
(2, 1, 8, 1, 201008002, 'sadadeewr', 'qweqwhj', '2010-08-28 17:54:02', 1, '2010-08-28 17:54:06', 1, 0, '400.00', '400.00', '', '2010-08-19', 0, 1, 'Consultant', 'Salesman', 'Others');

-- --------------------------------------------------------

--
-- Table structure for table `sim_simbiz_closing`
--

CREATE TABLE IF NOT EXISTS `sim_simbiz_closing` (
  `closing_id` int(11) NOT NULL AUTO_INCREMENT,
  `closing_no` varchar(10) NOT NULL,
  `period_id` int(11) NOT NULL,
  `isactive` smallint(6) NOT NULL,
  `created` datetime NOT NULL,
  `createdby` int(11) NOT NULL,
  `updated` datetime NOT NULL,
  `updatedby` int(11) NOT NULL,
  `organization_id` int(11) NOT NULL,
  `closing_description` varchar(100) DEFAULT NULL,
  `iscomplete` smallint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`closing_id`),
  KEY `organization_id` (`organization_id`),
  KEY `period_id` (`period_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `sim_simbiz_closing`
--


-- --------------------------------------------------------

--
-- Table structure for table `sim_simbiz_debitcreditnote`
--

CREATE TABLE IF NOT EXISTS `sim_simbiz_debitcreditnote` (
  `debitcreditnote_id` int(11) NOT NULL AUTO_INCREMENT,
  `document_no` varchar(20) NOT NULL,
  `organization_id` int(11) NOT NULL,
  `documenttype` smallint(1) NOT NULL,
  `document_date` date NOT NULL,
  `batch_id` int(11) NOT NULL,
  `amt` decimal(12,2) NOT NULL,
  `currency_id` int(11) NOT NULL,
  `exchangerate` decimal(12,2) NOT NULL,
  `originalamt` decimal(12,2) NOT NULL,
  `created` datetime NOT NULL,
  `createdby` int(11) NOT NULL,
  `updated` datetime NOT NULL,
  `updatedby` int(11) NOT NULL,
  `itemqty` int(11) NOT NULL,
  `ref_no` varchar(30) NOT NULL,
  `description` varchar(255) NOT NULL,
  `bpartner_id` int(11) NOT NULL,
  `iscomplete` smallint(1) NOT NULL,
  `bpartneraccounts_id` int(11) NOT NULL,
  `debitcreditnote_prefix` varchar(10) NOT NULL,
  PRIMARY KEY (`debitcreditnote_id`),
  UNIQUE KEY `documentno` (`organization_id`,`document_no`,`documenttype`),
  KEY `document_no` (`document_no`),
  KEY `bpartner_id` (`bpartner_id`),
  KEY `bpartneraccounts_id` (`bpartneraccounts_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `sim_simbiz_debitcreditnote`
--


-- --------------------------------------------------------

--
-- Table structure for table `sim_simbiz_debitcreditnoteline`
--

CREATE TABLE IF NOT EXISTS `sim_simbiz_debitcreditnoteline` (
  `debitcreditnoteline_id` int(11) NOT NULL AUTO_INCREMENT,
  `debitcreditnote_id` int(11) NOT NULL,
  `subject` varchar(60) NOT NULL,
  `amt` decimal(12,2) NOT NULL,
  `qty` decimal(12,2) NOT NULL,
  `description` text NOT NULL,
  `uom` varchar(10) NOT NULL,
  `unitprice` decimal(12,4) NOT NULL,
  `accounts_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`debitcreditnoteline_id`),
  KEY `debitcreditnote_id` (`debitcreditnote_id`),
  KEY `subject` (`subject`),
  KEY `accounts_id` (`accounts_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `sim_simbiz_debitcreditnoteline`
--


-- --------------------------------------------------------

--
-- Table structure for table `sim_simbiz_financialyear`
--

CREATE TABLE IF NOT EXISTS `sim_simbiz_financialyear` (
  `financialyear_id` int(11) NOT NULL AUTO_INCREMENT,
  `organization_id` int(11) NOT NULL,
  `periodqty` smallint(6) NOT NULL,
  `defaultlevel` smallint(6) NOT NULL,
  `isclosed` smallint(6) NOT NULL,
  `created` datetime NOT NULL,
  `createdby` int(11) NOT NULL,
  `updated` datetime NOT NULL,
  `description` varchar(255) NOT NULL,
  `financialyear_name` smallint(4) NOT NULL,
  `updatedby` int(11) NOT NULL,
  PRIMARY KEY (`financialyear_id`),
  UNIQUE KEY `notallowsamefinancialyearinorg` (`organization_id`,`financialyear_name`),
  KEY `organization_id` (`organization_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `sim_simbiz_financialyear`
--

INSERT INTO `sim_simbiz_financialyear` (`financialyear_id`, `organization_id`, `periodqty`, `defaultlevel`, `isclosed`, `created`, `createdby`, `updated`, `description`, `financialyear_name`, `updatedby`) VALUES
(1, 1, 11, 10, 0, '2010-04-13 17:26:21', 1, '2010-08-01 19:07:36', 'Financial Year 2010', 2010, 1);

-- --------------------------------------------------------

--
-- Table structure for table `sim_simbiz_financialyearline`
--

CREATE TABLE IF NOT EXISTS `sim_simbiz_financialyearline` (
  `financialyearline_id` int(11) NOT NULL AUTO_INCREMENT,
  `financialyear_id` int(11) NOT NULL,
  `period_id` int(11) NOT NULL,
  `isclosed` smallint(1) NOT NULL,
  `incomestatementamt` decimal(14,2) NOT NULL,
  `balancesheetamt` decimal(14,2) NOT NULL,
  `organization_id` int(11) NOT NULL,
  `batch_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`financialyearline_id`),
  UNIQUE KEY `notallowconfliglineperiodidinorg` (`period_id`,`organization_id`),
  KEY `financialyear_id` (`financialyear_id`),
  KEY `period_id` (`period_id`),
  KEY `organization_id` (`organization_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `sim_simbiz_financialyearline`
--

INSERT INTO `sim_simbiz_financialyearline` (`financialyearline_id`, `financialyear_id`, `period_id`, `isclosed`, `incomestatementamt`, `balancesheetamt`, `organization_id`, `batch_id`) VALUES
(1, 1, 1, 0, '0.00', '0.00', 1, 0),
(2, 1, 2, 0, '0.00', '0.00', 1, 0),
(3, 1, 4, 0, '0.00', '0.00', 1, 0),
(4, 1, 3, 0, '0.00', '0.00', 1, 0),
(5, 1, 5, 0, '0.00', '0.00', 1, 0),
(6, 1, 6, 0, '0.00', '0.00', 1, 0),
(7, 1, 7, 0, '0.00', '0.00', 1, 0),
(8, 1, 8, 0, '0.00', '0.00', 1, 0),
(9, 1, 9, 0, '0.00', '0.00', 1, 0),
(10, 1, 11, 0, '0.00', '0.00', 1, 0),
(11, 1, 12, 0, '0.00', '0.00', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `sim_simbiz_invoice`
--

CREATE TABLE IF NOT EXISTS `sim_simbiz_invoice` (
  `invoice_id` int(11) NOT NULL AUTO_INCREMENT,
  `document_no` varchar(20) NOT NULL,
  `organization_id` int(11) NOT NULL,
  `documenttype` smallint(1) NOT NULL,
  `document_date` date NOT NULL,
  `batch_id` int(11) NOT NULL,
  `amt` decimal(12,2) NOT NULL,
  `currency_id` int(11) NOT NULL,
  `exchangerate` decimal(12,2) NOT NULL,
  `originalamt` decimal(12,2) NOT NULL,
  `created` datetime NOT NULL,
  `createdby` int(11) NOT NULL,
  `updated` datetime NOT NULL,
  `updatedby` int(11) NOT NULL,
  `itemqty` int(11) NOT NULL,
  `ref_no` varchar(30) NOT NULL,
  `description` varchar(255) NOT NULL,
  `bpartner_id` int(11) NOT NULL,
  `iscomplete` smallint(1) NOT NULL,
  `bpartneraccounts_id` int(11) NOT NULL,
  `spinvoice_prefix` varchar(20) NOT NULL,
  PRIMARY KEY (`invoice_id`),
  UNIQUE KEY `documentno` (`organization_id`,`document_no`,`documenttype`),
  KEY `document_no` (`document_no`),
  KEY `bpartner_id` (`bpartner_id`),
  KEY `bpartneraccounts_id` (`bpartneraccounts_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `sim_simbiz_invoice`
--


-- --------------------------------------------------------

--
-- Table structure for table `sim_simbiz_invoiceline`
--

CREATE TABLE IF NOT EXISTS `sim_simbiz_invoiceline` (
  `invoiceline_id` int(11) NOT NULL AUTO_INCREMENT,
  `invoice_id` int(11) NOT NULL,
  `subject` varchar(60) NOT NULL,
  `amt` decimal(12,2) NOT NULL,
  `qty` decimal(12,2) NOT NULL,
  `description` text NOT NULL,
  `uom` varchar(10) NOT NULL,
  `unitprice` decimal(12,4) NOT NULL,
  `accounts_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`invoiceline_id`),
  KEY `debitcreditnote_id` (`invoice_id`),
  KEY `subject` (`subject`),
  KEY `accounts_id` (`accounts_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `sim_simbiz_invoiceline`
--


-- --------------------------------------------------------

--
-- Table structure for table `sim_simbiz_paymentvoucher`
--

CREATE TABLE IF NOT EXISTS `sim_simbiz_paymentvoucher` (
  `paymentvoucher_id` int(11) NOT NULL AUTO_INCREMENT,
  `paymentvoucher_no` varchar(20) NOT NULL,
  `paidto` varchar(60) NOT NULL,
  `organization_id` int(11) NOT NULL,
  `description` varchar(255) NOT NULL,
  `currency_id` int(11) NOT NULL,
  `exchangerate` decimal(12,4) NOT NULL,
  `accountsfrom_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `createdby` int(11) NOT NULL,
  `updated` datetime NOT NULL,
  `updatedby` int(11) NOT NULL,
  `originalamt` decimal(12,2) NOT NULL,
  `amt` decimal(12,2) NOT NULL,
  `batch_id` int(11) NOT NULL,
  `paymentvoucher_date` date NOT NULL,
  `preparedby` varchar(40) NOT NULL,
  `iscomplete` smallint(1) NOT NULL,
  `chequeno` varchar(10) NOT NULL,
  `paymentvoucher_type` char(1) NOT NULL DEFAULT 'B',
  `paymentvoucher_prefix` varchar(10) NOT NULL,
  PRIMARY KEY (`paymentvoucher_id`),
  UNIQUE KEY `paymentvoucher_no` (`paymentvoucher_no`,`organization_id`,`paymentvoucher_type`),
  KEY `receipt_no` (`paymentvoucher_no`),
  KEY `subject` (`paidto`),
  KEY `organization_id` (`organization_id`),
  KEY `currency_id` (`currency_id`),
  KEY `batch_id` (`batch_id`),
  KEY `paymentvoucher_date` (`paymentvoucher_date`),
  KEY `fromaccounts_id` (`accountsfrom_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `sim_simbiz_paymentvoucher`
--

INSERT INTO `sim_simbiz_paymentvoucher` (`paymentvoucher_id`, `paymentvoucher_no`, `paidto`, `organization_id`, `description`, `currency_id`, `exchangerate`, `accountsfrom_id`, `created`, `createdby`, `updated`, `updatedby`, `originalamt`, `amt`, `batch_id`, `paymentvoucher_date`, `preparedby`, `iscomplete`, `chequeno`, `paymentvoucher_type`, `paymentvoucher_prefix`) VALUES
(0, '0', '', 0, '', 0, '0.0000', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0.00', '0.00', 0, '0000-00-00', '', 0, '', 'B', '');

-- --------------------------------------------------------

--
-- Table structure for table `sim_simbiz_paymentvoucherline`
--

CREATE TABLE IF NOT EXISTS `sim_simbiz_paymentvoucherline` (
  `paymentvoucherline_id` int(11) NOT NULL AUTO_INCREMENT,
  `paymentvoucher_id` int(11) NOT NULL,
  `subject` varchar(60) NOT NULL,
  `amt` decimal(12,2) NOT NULL,
  `description` text NOT NULL,
  `accounts_id` int(11) NOT NULL DEFAULT '0',
  `bpartner_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`paymentvoucherline_id`),
  KEY `paymentvoucher_id` (`paymentvoucher_id`),
  KEY `subject` (`subject`),
  KEY `accounts_id` (`accounts_id`),
  KEY `bpartner_id` (`bpartner_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `sim_simbiz_paymentvoucherline`
--

INSERT INTO `sim_simbiz_paymentvoucherline` (`paymentvoucherline_id`, `paymentvoucher_id`, `subject`, `amt`, `description`, `accounts_id`, `bpartner_id`) VALUES
(0, 0, '', '0.00', '', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `sim_simbiz_permission`
--

CREATE TABLE IF NOT EXISTS `sim_simbiz_permission` (
  `permission_id` int(11) NOT NULL AUTO_INCREMENT,
  `window_id` smallint(5) NOT NULL DEFAULT '0',
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `createdby` int(5) NOT NULL DEFAULT '0',
  `updated` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updatedby` int(5) NOT NULL DEFAULT '0',
  `groupid` smallint(6) NOT NULL DEFAULT '0',
  PRIMARY KEY (`permission_id`),
  KEY `groupid` (`groupid`),
  KEY `window_id` (`window_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=765 ;

--
-- Dumping data for table `sim_simbiz_permission`
--

INSERT INTO `sim_simbiz_permission` (`permission_id`, `window_id`, `created`, `createdby`, `updated`, `updatedby`, `groupid`) VALUES
(457, 1, '2009-11-03 23:12:50', 1, '2009-11-03 23:12:50', 1, 11),
(458, 3, '2009-11-03 23:12:50', 1, '2009-11-03 23:12:50', 1, 11),
(459, 5, '2009-11-03 23:12:50', 1, '2009-11-03 23:12:50', 1, 11),
(460, 29, '2009-11-03 23:12:50', 1, '2009-11-03 23:12:50', 1, 11),
(461, 30, '2009-11-03 23:12:50', 1, '2009-11-03 23:12:50', 1, 11),
(462, 51, '2009-11-03 23:12:50', 1, '2009-11-03 23:12:50', 1, 11),
(463, 80, '2009-11-03 23:12:50', 1, '2009-11-03 23:12:50', 1, 11),
(464, 72, '2009-11-03 23:12:50', 1, '2009-11-03 23:12:50', 1, 11),
(465, 73, '2009-11-03 23:12:50', 1, '2009-11-03 23:12:50', 1, 11),
(466, 76, '2009-11-03 23:12:50', 1, '2009-11-03 23:12:50', 1, 11),
(467, 8, '2009-11-03 23:12:50', 1, '2009-11-03 23:12:50', 1, 11),
(468, 38, '2009-11-03 23:12:50', 1, '2009-11-03 23:12:50', 1, 11),
(469, 39, '2009-11-03 23:12:50', 1, '2009-11-03 23:12:50', 1, 11),
(470, 44, '2009-11-03 23:12:50', 1, '2009-11-03 23:12:50', 1, 11),
(471, 41, '2009-11-03 23:12:50', 1, '2009-11-03 23:12:50', 1, 11),
(472, 47, '2009-11-03 23:12:50', 1, '2009-11-03 23:12:50', 1, 11),
(473, 52, '2009-11-03 23:12:50', 1, '2009-11-03 23:12:50', 1, 11),
(474, 81, '2009-11-03 23:12:50', 1, '2009-11-03 23:12:50', 1, 11),
(475, 54, '2009-11-03 23:12:50', 1, '2009-11-03 23:12:50', 1, 11),
(476, 55, '2009-11-03 23:12:50', 1, '2009-11-03 23:12:50', 1, 11),
(477, 56, '2009-11-03 23:12:50', 1, '2009-11-03 23:12:50', 1, 11),
(478, 62, '2009-11-03 23:12:50', 1, '2009-11-03 23:12:50', 1, 11),
(479, 64, '2009-11-03 23:12:50', 1, '2009-11-03 23:12:50', 1, 11),
(480, 65, '2009-11-03 23:12:50', 1, '2009-11-03 23:12:50', 1, 11),
(481, 66, '2009-11-03 23:12:50', 1, '2009-11-03 23:12:50', 1, 11),
(482, 69, '2009-11-03 23:12:50', 1, '2009-11-03 23:12:50', 1, 11),
(483, 70, '2009-11-03 23:12:50', 1, '2009-11-03 23:12:50', 1, 11),
(484, 78, '2009-11-03 23:12:50', 1, '2009-11-03 23:12:50', 1, 11),
(485, 79, '2009-11-03 23:12:50', 1, '2009-11-03 23:12:50', 1, 11),
(486, 10, '2009-11-03 23:12:50', 1, '2009-11-03 23:12:50', 1, 11),
(487, 11, '2009-11-03 23:12:50', 1, '2009-11-03 23:12:50', 1, 11),
(488, 14, '2009-11-03 23:12:50', 1, '2009-11-03 23:12:50', 1, 11),
(489, 24, '2009-11-03 23:12:50', 1, '2009-11-03 23:12:50', 1, 11),
(490, 15, '2009-11-03 23:12:50', 1, '2009-11-03 23:12:50', 1, 11),
(491, 16, '2009-11-03 23:12:50', 1, '2009-11-03 23:12:50', 1, 11),
(492, 18, '2009-11-03 23:12:50', 1, '2009-11-03 23:12:50', 1, 11),
(493, 19, '2009-11-03 23:12:50', 1, '2009-11-03 23:12:50', 1, 11),
(494, 20, '2009-11-03 23:12:50', 1, '2009-11-03 23:12:50', 1, 11),
(495, 21, '2009-11-03 23:12:50', 1, '2009-11-03 23:12:50', 1, 11),
(496, 22, '2009-11-03 23:12:50', 1, '2009-11-03 23:12:50', 1, 11),
(497, 25, '2009-11-03 23:12:50', 1, '2009-11-03 23:12:50', 1, 11),
(498, 26, '2009-11-03 23:12:50', 1, '2009-11-03 23:12:50', 1, 11),
(499, 27, '2009-11-03 23:12:50', 1, '2009-11-03 23:12:50', 1, 11),
(500, 28, '2009-11-03 23:12:50', 1, '2009-11-03 23:12:50', 1, 11),
(501, 31, '2009-11-03 23:12:50', 1, '2009-11-03 23:12:50', 1, 11),
(502, 32, '2009-11-03 23:12:50', 1, '2009-11-03 23:12:50', 1, 11),
(503, 33, '2009-11-03 23:12:50', 1, '2009-11-03 23:12:50', 1, 11),
(504, 34, '2009-11-03 23:12:50', 1, '2009-11-03 23:12:50', 1, 11),
(505, 35, '2009-11-03 23:12:50', 1, '2009-11-03 23:12:50', 1, 11),
(506, 36, '2009-11-03 23:12:50', 1, '2009-11-03 23:12:50', 1, 11),
(507, 37, '2009-11-03 23:12:50', 1, '2009-11-03 23:12:50', 1, 11),
(508, 40, '2009-11-03 23:12:50', 1, '2009-11-03 23:12:50', 1, 11),
(509, 42, '2009-11-03 23:12:50', 1, '2009-11-03 23:12:50', 1, 11),
(510, 43, '2009-11-03 23:12:50', 1, '2009-11-03 23:12:50', 1, 11),
(511, 45, '2009-11-03 23:12:50', 1, '2009-11-03 23:12:50', 1, 11),
(512, 46, '2009-11-03 23:12:50', 1, '2009-11-03 23:12:50', 1, 11),
(513, 48, '2009-11-03 23:12:50', 1, '2009-11-03 23:12:50', 1, 11),
(514, 49, '2009-11-03 23:12:50', 1, '2009-11-03 23:12:50', 1, 11),
(515, 50, '2009-11-03 23:12:50', 1, '2009-11-03 23:12:50', 1, 11),
(516, 82, '2009-11-03 23:12:50', 1, '2009-11-03 23:12:50', 1, 11),
(517, 83, '2009-11-03 23:12:50', 1, '2009-11-03 23:12:50', 1, 11),
(518, 84, '2009-11-03 23:12:50', 1, '2009-11-03 23:12:50', 1, 11),
(519, 53, '2009-11-03 23:12:50', 1, '2009-11-03 23:12:50', 1, 11),
(520, 85, '2009-11-03 23:12:50', 1, '2009-11-03 23:12:50', 1, 11),
(521, 86, '2009-11-03 23:12:50', 1, '2009-11-03 23:12:50', 1, 11),
(522, 87, '2009-11-03 23:12:50', 1, '2009-11-03 23:12:50', 1, 11),
(523, 57, '2009-11-03 23:12:50', 1, '2009-11-03 23:12:50', 1, 11),
(524, 58, '2009-11-03 23:12:50', 1, '2009-11-03 23:12:50', 1, 11),
(525, 59, '2009-11-03 23:12:50', 1, '2009-11-03 23:12:50', 1, 11),
(526, 60, '2009-11-03 23:12:50', 1, '2009-11-03 23:12:50', 1, 11),
(527, 61, '2009-11-03 23:12:50', 1, '2009-11-03 23:12:50', 1, 11),
(528, 63, '2009-11-03 23:12:50', 1, '2009-11-03 23:12:50', 1, 11),
(529, 67, '2009-11-03 23:12:50', 1, '2009-11-03 23:12:50', 1, 11),
(530, 68, '2009-11-03 23:12:50', 1, '2009-11-03 23:12:50', 1, 11),
(531, 71, '2009-11-03 23:12:50', 1, '2009-11-03 23:12:50', 1, 11),
(532, 74, '2009-11-03 23:12:50', 1, '2009-11-03 23:12:50', 1, 11),
(533, 75, '2009-11-03 23:12:50', 1, '2009-11-03 23:12:50', 1, 11),
(534, 1, '2009-11-10 22:47:49', 1, '2009-11-10 22:47:49', 1, 20),
(535, 3, '2009-11-10 22:47:49', 1, '2009-11-10 22:47:49', 1, 20),
(536, 5, '2009-11-10 22:47:49', 1, '2009-11-10 22:47:49', 1, 20),
(537, 29, '2009-11-10 22:47:49', 1, '2009-11-10 22:47:49', 1, 20),
(538, 30, '2009-11-10 22:47:49', 1, '2009-11-10 22:47:49', 1, 20),
(539, 51, '2009-11-10 22:47:49', 1, '2009-11-10 22:47:49', 1, 20),
(540, 80, '2009-11-10 22:47:49', 1, '2009-11-10 22:47:49', 1, 20),
(541, 72, '2009-11-10 22:47:49', 1, '2009-11-10 22:47:49', 1, 20),
(542, 73, '2009-11-10 22:47:49', 1, '2009-11-10 22:47:49', 1, 20),
(543, 76, '2009-11-10 22:47:49', 1, '2009-11-10 22:47:49', 1, 20),
(544, 8, '2009-11-10 22:47:49', 1, '2009-11-10 22:47:49', 1, 20),
(545, 38, '2009-11-10 22:47:49', 1, '2009-11-10 22:47:49', 1, 20),
(546, 39, '2009-11-10 22:47:49', 1, '2009-11-10 22:47:49', 1, 20),
(547, 44, '2009-11-10 22:47:49', 1, '2009-11-10 22:47:49', 1, 20),
(548, 41, '2009-11-10 22:47:49', 1, '2009-11-10 22:47:49', 1, 20),
(549, 47, '2009-11-10 22:47:49', 1, '2009-11-10 22:47:49', 1, 20),
(550, 52, '2009-11-10 22:47:49', 1, '2009-11-10 22:47:49', 1, 20),
(551, 81, '2009-11-10 22:47:49', 1, '2009-11-10 22:47:49', 1, 20),
(552, 54, '2009-11-10 22:47:49', 1, '2009-11-10 22:47:49', 1, 20),
(553, 55, '2009-11-10 22:47:49', 1, '2009-11-10 22:47:49', 1, 20),
(554, 56, '2009-11-10 22:47:49', 1, '2009-11-10 22:47:49', 1, 20),
(555, 62, '2009-11-10 22:47:49', 1, '2009-11-10 22:47:49', 1, 20),
(556, 64, '2009-11-10 22:47:49', 1, '2009-11-10 22:47:49', 1, 20),
(557, 65, '2009-11-10 22:47:49', 1, '2009-11-10 22:47:49', 1, 20),
(558, 66, '2009-11-10 22:47:49', 1, '2009-11-10 22:47:49', 1, 20),
(559, 69, '2009-11-10 22:47:49', 1, '2009-11-10 22:47:49', 1, 20),
(560, 70, '2009-11-10 22:47:49', 1, '2009-11-10 22:47:49', 1, 20),
(561, 78, '2009-11-10 22:47:49', 1, '2009-11-10 22:47:49', 1, 20),
(562, 79, '2009-11-10 22:47:49', 1, '2009-11-10 22:47:49', 1, 20),
(563, 10, '2009-11-10 22:47:49', 1, '2009-11-10 22:47:49', 1, 20),
(564, 11, '2009-11-10 22:47:49', 1, '2009-11-10 22:47:49', 1, 20),
(565, 14, '2009-11-10 22:47:49', 1, '2009-11-10 22:47:49', 1, 20),
(566, 24, '2009-11-10 22:47:49', 1, '2009-11-10 22:47:49', 1, 20),
(567, 15, '2009-11-10 22:47:49', 1, '2009-11-10 22:47:49', 1, 20),
(568, 16, '2009-11-10 22:47:49', 1, '2009-11-10 22:47:49', 1, 20),
(569, 18, '2009-11-10 22:47:49', 1, '2009-11-10 22:47:49', 1, 20),
(570, 19, '2009-11-10 22:47:49', 1, '2009-11-10 22:47:49', 1, 20),
(571, 20, '2009-11-10 22:47:49', 1, '2009-11-10 22:47:49', 1, 20),
(572, 21, '2009-11-10 22:47:49', 1, '2009-11-10 22:47:49', 1, 20),
(573, 22, '2009-11-10 22:47:49', 1, '2009-11-10 22:47:49', 1, 20),
(574, 23, '2009-11-10 22:47:49', 1, '2009-11-10 22:47:49', 1, 20),
(575, 25, '2009-11-10 22:47:49', 1, '2009-11-10 22:47:49', 1, 20),
(576, 26, '2009-11-10 22:47:49', 1, '2009-11-10 22:47:49', 1, 20),
(577, 27, '2009-11-10 22:47:49', 1, '2009-11-10 22:47:49', 1, 20),
(578, 28, '2009-11-10 22:47:49', 1, '2009-11-10 22:47:49', 1, 20),
(579, 31, '2009-11-10 22:47:49', 1, '2009-11-10 22:47:49', 1, 20),
(580, 32, '2009-11-10 22:47:49', 1, '2009-11-10 22:47:49', 1, 20),
(581, 33, '2009-11-10 22:47:49', 1, '2009-11-10 22:47:49', 1, 20),
(582, 34, '2009-11-10 22:47:49', 1, '2009-11-10 22:47:49', 1, 20),
(583, 35, '2009-11-10 22:47:49', 1, '2009-11-10 22:47:49', 1, 20),
(584, 36, '2009-11-10 22:47:49', 1, '2009-11-10 22:47:49', 1, 20),
(585, 37, '2009-11-10 22:47:49', 1, '2009-11-10 22:47:49', 1, 20),
(586, 40, '2009-11-10 22:47:49', 1, '2009-11-10 22:47:49', 1, 20),
(587, 42, '2009-11-10 22:47:49', 1, '2009-11-10 22:47:49', 1, 20),
(588, 43, '2009-11-10 22:47:49', 1, '2009-11-10 22:47:49', 1, 20),
(589, 45, '2009-11-10 22:47:49', 1, '2009-11-10 22:47:49', 1, 20),
(590, 46, '2009-11-10 22:47:49', 1, '2009-11-10 22:47:49', 1, 20),
(591, 48, '2009-11-10 22:47:49', 1, '2009-11-10 22:47:49', 1, 20),
(592, 49, '2009-11-10 22:47:49', 1, '2009-11-10 22:47:49', 1, 20),
(593, 50, '2009-11-10 22:47:49', 1, '2009-11-10 22:47:49', 1, 20),
(594, 82, '2009-11-10 22:47:49', 1, '2009-11-10 22:47:49', 1, 20),
(595, 83, '2009-11-10 22:47:49', 1, '2009-11-10 22:47:49', 1, 20),
(596, 84, '2009-11-10 22:47:49', 1, '2009-11-10 22:47:49', 1, 20),
(597, 53, '2009-11-10 22:47:49', 1, '2009-11-10 22:47:49', 1, 20),
(598, 85, '2009-11-10 22:47:49', 1, '2009-11-10 22:47:49', 1, 20),
(599, 86, '2009-11-10 22:47:49', 1, '2009-11-10 22:47:49', 1, 20),
(600, 87, '2009-11-10 22:47:49', 1, '2009-11-10 22:47:49', 1, 20),
(601, 57, '2009-11-10 22:47:49', 1, '2009-11-10 22:47:49', 1, 20),
(602, 58, '2009-11-10 22:47:49', 1, '2009-11-10 22:47:49', 1, 20),
(603, 59, '2009-11-10 22:47:49', 1, '2009-11-10 22:47:49', 1, 20),
(604, 60, '2009-11-10 22:47:49', 1, '2009-11-10 22:47:49', 1, 20),
(605, 61, '2009-11-10 22:47:49', 1, '2009-11-10 22:47:49', 1, 20),
(606, 63, '2009-11-10 22:47:49', 1, '2009-11-10 22:47:49', 1, 20),
(607, 67, '2009-11-10 22:47:49', 1, '2009-11-10 22:47:49', 1, 20),
(608, 68, '2009-11-10 22:47:49', 1, '2009-11-10 22:47:49', 1, 20),
(609, 71, '2009-11-10 22:47:49', 1, '2009-11-10 22:47:49', 1, 20),
(610, 74, '2009-11-10 22:47:49', 1, '2009-11-10 22:47:49', 1, 20),
(611, 75, '2009-11-10 22:47:49', 1, '2009-11-10 22:47:49', 1, 20),
(687, 1, '2010-03-28 18:49:44', 1, '2010-03-28 18:49:44', 1, 1),
(688, 3, '2010-03-28 18:49:44', 1, '2010-03-28 18:49:44', 1, 1),
(689, 5, '2010-03-28 18:49:44', 1, '2010-03-28 18:49:44', 1, 1),
(690, 29, '2010-03-28 18:49:44', 1, '2010-03-28 18:49:44', 1, 1),
(691, 30, '2010-03-28 18:49:44', 1, '2010-03-28 18:49:44', 1, 1),
(692, 51, '2010-03-28 18:49:44', 1, '2010-03-28 18:49:44', 1, 1),
(693, 80, '2010-03-28 18:49:44', 1, '2010-03-28 18:49:44', 1, 1),
(694, 72, '2010-03-28 18:49:44', 1, '2010-03-28 18:49:44', 1, 1),
(695, 73, '2010-03-28 18:49:44', 1, '2010-03-28 18:49:44', 1, 1),
(696, 76, '2010-03-28 18:49:44', 1, '2010-03-28 18:49:44', 1, 1),
(697, 8, '2010-03-28 18:49:44', 1, '2010-03-28 18:49:44', 1, 1),
(698, 38, '2010-03-28 18:49:44', 1, '2010-03-28 18:49:44', 1, 1),
(699, 39, '2010-03-28 18:49:44', 1, '2010-03-28 18:49:44', 1, 1),
(700, 44, '2010-03-28 18:49:44', 1, '2010-03-28 18:49:44', 1, 1),
(701, 41, '2010-03-28 18:49:44', 1, '2010-03-28 18:49:44', 1, 1),
(702, 52, '2010-03-28 18:49:44', 1, '2010-03-28 18:49:44', 1, 1),
(703, 81, '2010-03-28 18:49:44', 1, '2010-03-28 18:49:44', 1, 1),
(704, 54, '2010-03-28 18:49:44', 1, '2010-03-28 18:49:44', 1, 1),
(705, 55, '2010-03-28 18:49:44', 1, '2010-03-28 18:49:44', 1, 1),
(706, 56, '2010-03-28 18:49:44', 1, '2010-03-28 18:49:44', 1, 1),
(707, 62, '2010-03-28 18:49:44', 1, '2010-03-28 18:49:44', 1, 1),
(708, 64, '2010-03-28 18:49:44', 1, '2010-03-28 18:49:44', 1, 1),
(709, 65, '2010-03-28 18:49:44', 1, '2010-03-28 18:49:44', 1, 1),
(710, 66, '2010-03-28 18:49:44', 1, '2010-03-28 18:49:44', 1, 1),
(711, 69, '2010-03-28 18:49:44', 1, '2010-03-28 18:49:44', 1, 1),
(712, 70, '2010-03-28 18:49:44', 1, '2010-03-28 18:49:44', 1, 1),
(713, 78, '2010-03-28 18:49:44', 1, '2010-03-28 18:49:44', 1, 1),
(714, 79, '2010-03-28 18:49:44', 1, '2010-03-28 18:49:44', 1, 1),
(715, 10, '2010-03-28 18:49:44', 1, '2010-03-28 18:49:44', 1, 1),
(716, 11, '2010-03-28 18:49:44', 1, '2010-03-28 18:49:44', 1, 1),
(717, 14, '2010-03-28 18:49:44', 1, '2010-03-28 18:49:44', 1, 1),
(718, 24, '2010-03-28 18:49:44', 1, '2010-03-28 18:49:44', 1, 1),
(719, 15, '2010-03-28 18:49:44', 1, '2010-03-28 18:49:44', 1, 1),
(720, 16, '2010-03-28 18:49:44', 1, '2010-03-28 18:49:44', 1, 1),
(721, 18, '2010-03-28 18:49:44', 1, '2010-03-28 18:49:44', 1, 1),
(722, 19, '2010-03-28 18:49:44', 1, '2010-03-28 18:49:44', 1, 1),
(723, 20, '2010-03-28 18:49:44', 1, '2010-03-28 18:49:44', 1, 1),
(724, 21, '2010-03-28 18:49:44', 1, '2010-03-28 18:49:44', 1, 1),
(725, 22, '2010-03-28 18:49:44', 1, '2010-03-28 18:49:44', 1, 1),
(726, 23, '2010-03-28 18:49:44', 1, '2010-03-28 18:49:44', 1, 1),
(727, 25, '2010-03-28 18:49:44', 1, '2010-03-28 18:49:44', 1, 1),
(728, 26, '2010-03-28 18:49:44', 1, '2010-03-28 18:49:44', 1, 1),
(729, 27, '2010-03-28 18:49:44', 1, '2010-03-28 18:49:44', 1, 1),
(730, 28, '2010-03-28 18:49:44', 1, '2010-03-28 18:49:44', 1, 1),
(731, 31, '2010-03-28 18:49:44', 1, '2010-03-28 18:49:44', 1, 1),
(732, 32, '2010-03-28 18:49:44', 1, '2010-03-28 18:49:44', 1, 1),
(733, 33, '2010-03-28 18:49:44', 1, '2010-03-28 18:49:44', 1, 1),
(734, 34, '2010-03-28 18:49:44', 1, '2010-03-28 18:49:44', 1, 1),
(735, 35, '2010-03-28 18:49:44', 1, '2010-03-28 18:49:44', 1, 1),
(736, 36, '2010-03-28 18:49:44', 1, '2010-03-28 18:49:44', 1, 1),
(737, 37, '2010-03-28 18:49:44', 1, '2010-03-28 18:49:44', 1, 1),
(738, 40, '2010-03-28 18:49:44', 1, '2010-03-28 18:49:44', 1, 1),
(739, 42, '2010-03-28 18:49:44', 1, '2010-03-28 18:49:44', 1, 1),
(740, 43, '2010-03-28 18:49:44', 1, '2010-03-28 18:49:44', 1, 1),
(741, 45, '2010-03-28 18:49:44', 1, '2010-03-28 18:49:44', 1, 1),
(742, 46, '2010-03-28 18:49:44', 1, '2010-03-28 18:49:44', 1, 1),
(743, 48, '2010-03-28 18:49:44', 1, '2010-03-28 18:49:44', 1, 1),
(744, 49, '2010-03-28 18:49:44', 1, '2010-03-28 18:49:44', 1, 1),
(745, 50, '2010-03-28 18:49:44', 1, '2010-03-28 18:49:44', 1, 1),
(746, 82, '2010-03-28 18:49:44', 1, '2010-03-28 18:49:44', 1, 1),
(747, 83, '2010-03-28 18:49:44', 1, '2010-03-28 18:49:44', 1, 1),
(748, 84, '2010-03-28 18:49:44', 1, '2010-03-28 18:49:44', 1, 1),
(749, 53, '2010-03-28 18:49:44', 1, '2010-03-28 18:49:44', 1, 1),
(750, 85, '2010-03-28 18:49:44', 1, '2010-03-28 18:49:44', 1, 1),
(751, 86, '2010-03-28 18:49:44', 1, '2010-03-28 18:49:44', 1, 1),
(752, 87, '2010-03-28 18:49:44', 1, '2010-03-28 18:49:44', 1, 1),
(753, 57, '2010-03-28 18:49:44', 1, '2010-03-28 18:49:44', 1, 1),
(754, 58, '2010-03-28 18:49:44', 1, '2010-03-28 18:49:44', 1, 1),
(755, 59, '2010-03-28 18:49:44', 1, '2010-03-28 18:49:44', 1, 1),
(756, 60, '2010-03-28 18:49:44', 1, '2010-03-28 18:49:44', 1, 1),
(757, 61, '2010-03-28 18:49:44', 1, '2010-03-28 18:49:44', 1, 1),
(758, 63, '2010-03-28 18:49:44', 1, '2010-03-28 18:49:44', 1, 1),
(759, 67, '2010-03-28 18:49:44', 1, '2010-03-28 18:49:44', 1, 1),
(760, 68, '2010-03-28 18:49:44', 1, '2010-03-28 18:49:44', 1, 1),
(761, 71, '2010-03-28 18:49:44', 1, '2010-03-28 18:49:44', 1, 1),
(762, 74, '2010-03-28 18:49:44', 1, '2010-03-28 18:49:44', 1, 1),
(763, 75, '2010-03-28 18:49:44', 1, '2010-03-28 18:49:44', 1, 1),
(764, 88, '2010-03-28 18:49:44', 1, '2010-03-28 18:49:44', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `sim_simbiz_receipt`
--

CREATE TABLE IF NOT EXISTS `sim_simbiz_receipt` (
  `receipt_id` int(11) NOT NULL AUTO_INCREMENT,
  `receipt_no` varchar(20) NOT NULL,
  `paidfrom` varchar(60) NOT NULL,
  `organization_id` int(11) NOT NULL,
  `description` varchar(255) NOT NULL,
  `currency_id` int(11) NOT NULL,
  `exchangerate` decimal(12,4) NOT NULL,
  `accountsfrom_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `createdby` int(11) NOT NULL,
  `updated` datetime NOT NULL,
  `updatedby` int(11) NOT NULL,
  `originalamt` decimal(12,2) NOT NULL,
  `amt` decimal(12,2) NOT NULL,
  `batch_id` int(11) NOT NULL,
  `bpartner_id` int(11) NOT NULL,
  `receipt_date` date NOT NULL,
  `receivedby` varchar(40) NOT NULL,
  `iscomplete` smallint(1) NOT NULL,
  `receipt_prefix` varchar(10) NOT NULL,
  PRIMARY KEY (`receipt_id`),
  UNIQUE KEY `receipt_noconstrain` (`receipt_no`,`organization_id`),
  KEY `receipt_no` (`receipt_no`),
  KEY `subject` (`paidfrom`),
  KEY `organization_id` (`organization_id`),
  KEY `currency_id` (`currency_id`),
  KEY `fromaccounts_id` (`accountsfrom_id`),
  KEY `batch_id` (`batch_id`),
  KEY `bpartner_id` (`bpartner_id`),
  KEY `receipt_date` (`receipt_date`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `sim_simbiz_receipt`
--


-- --------------------------------------------------------

--
-- Table structure for table `sim_simbiz_receiptline`
--

CREATE TABLE IF NOT EXISTS `sim_simbiz_receiptline` (
  `receiptline_id` int(11) NOT NULL AUTO_INCREMENT,
  `receipt_id` int(11) NOT NULL,
  `subject` varchar(60) NOT NULL,
  `amt` decimal(12,2) NOT NULL,
  `description` text NOT NULL,
  `accounts_id` int(11) NOT NULL DEFAULT '0',
  `chequeno` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`receiptline_id`),
  KEY `receipt_id` (`receipt_id`),
  KEY `subject` (`subject`),
  KEY `accounts_id` (`accounts_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `sim_simbiz_receiptline`
--


-- --------------------------------------------------------

--
-- Table structure for table `sim_simbiz_tax`
--

CREATE TABLE IF NOT EXISTS `sim_simbiz_tax` (
  `tax_id` int(11) NOT NULL AUTO_INCREMENT,
  `tax_name` varchar(50) NOT NULL,
  `istax` smallint(6) NOT NULL,
  `isactive` smallint(6) NOT NULL,
  `created` datetime NOT NULL,
  `createdby` int(11) NOT NULL,
  `updated` datetime NOT NULL,
  `updatedby` int(11) NOT NULL,
  `organization_id` int(11) NOT NULL,
  `defaultlevel` smallint(6) NOT NULL,
  `description` varchar(70) NOT NULL,
  `total_tax` decimal(12,2) NOT NULL,
  PRIMARY KEY (`tax_id`),
  KEY `organization_id` (`organization_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `sim_simbiz_tax`
--

INSERT INTO `sim_simbiz_tax` (`tax_id`, `tax_name`, `istax`, `isactive`, `created`, `createdby`, `updated`, `updatedby`, `organization_id`, `defaultlevel`, `description`, `total_tax`) VALUES
(0, ' ', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, 0, 0, '', '0.00'),
(1, 'Tax on purhase', 1, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, 1, 0, '', '8.25'),
(2, 'Tax on Goods', 1, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, 1, 0, '', '7.25'),
(3, 'Tax exempt', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, 1, 0, '', '0.00');

-- --------------------------------------------------------

--
-- Table structure for table `sim_simbiz_track`
--

CREATE TABLE IF NOT EXISTS `sim_simbiz_track` (
  `track_id` int(11) NOT NULL AUTO_INCREMENT,
  `trackheader_id` int(11) NOT NULL,
  `track_name` varchar(40) NOT NULL,
  `isactive` smallint(1) NOT NULL,
  `seqno` smallint(3) NOT NULL,
  `created` datetime NOT NULL,
  `createdby` int(11) NOT NULL,
  `updated` datetime NOT NULL,
  `updatedby` int(11) NOT NULL,
  `organization_id` int(11) NOT NULL,
  `isdeleted` smallint(6) NOT NULL,
  PRIMARY KEY (`track_id`),
  KEY `trackheader_id` (`trackheader_id`),
  KEY `organization_id` (`organization_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `sim_simbiz_track`
--

INSERT INTO `sim_simbiz_track` (`track_id`, `trackheader_id`, `track_name`, `isactive`, `seqno`, `created`, `createdby`, `updated`, `updatedby`, `organization_id`, `isdeleted`) VALUES
(0, 0, ' ', 1, 0, '2010-08-10 09:57:49', 1, '2010-08-10 10:24:20', 1, 1, 0),
(1, 3, 'Track 3b', 1, 10, '2010-08-12 15:54:43', 1, '2010-08-24 17:14:14', 1, 1, 0),
(2, 2, 'Track 2', 1, 10, '2010-08-12 15:58:07', 1, '2010-08-12 16:17:23', 1, 1, 0),
(3, 1, 'Track 1', 1, 10, '2010-08-12 15:58:07', 1, '2010-08-12 15:58:07', 1, 1, 0),
(4, 3, 'Track 3a', 1, 10, '2010-08-24 17:12:07', 1, '2010-08-24 17:14:14', 1, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `sim_simbiz_trackheader`
--

CREATE TABLE IF NOT EXISTS `sim_simbiz_trackheader` (
  `trackheader_id` int(11) NOT NULL AUTO_INCREMENT,
  `trackheader_code` varchar(100) NOT NULL,
  `trackheader_name` varchar(100) NOT NULL,
  `trackheader_description` varchar(100) NOT NULL,
  `isactive` smallint(6) NOT NULL,
  `seqno` smallint(6) NOT NULL,
  `created` datetime NOT NULL,
  `createdby` int(11) NOT NULL,
  `updated` datetime NOT NULL,
  `updatedby` int(11) NOT NULL,
  `isdeleted` smallint(1) NOT NULL,
  `organization_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`trackheader_id`),
  UNIQUE KEY `trackheader_code` (`trackheader_code`),
  UNIQUE KEY `trackheader_name` (`trackheader_name`,`organization_id`),
  KEY `organization_id` (`organization_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `sim_simbiz_trackheader`
--

INSERT INTO `sim_simbiz_trackheader` (`trackheader_id`, `trackheader_code`, `trackheader_name`, `trackheader_description`, `isactive`, `seqno`, `created`, `createdby`, `updated`, `updatedby`, `isdeleted`, `organization_id`) VALUES
(0, '', '', '', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, 0, 1),
(1, 'T1', 'Consultant', 'Tracking 1', 1, 1, '0000-00-00 00:00:00', 0, '2010-08-25 09:49:34', 1, 0, 1),
(2, 'T2', 'Salesman', 'Tracking 2', 1, 2, '0000-00-00 00:00:00', 0, '2010-08-25 09:49:34', 1, 0, 1),
(3, 'T3', 'Others', 'Tracking 3', 1, 3, '0000-00-00 00:00:00', 0, '2010-08-25 09:49:34', 1, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `sim_simbiz_transaction`
--

CREATE TABLE IF NOT EXISTS `sim_simbiz_transaction` (
  `trans_id` int(11) NOT NULL AUTO_INCREMENT,
  `document_no` varchar(14) NOT NULL,
  `batch_id` int(11) NOT NULL,
  `amt` decimal(12,2) NOT NULL,
  `originalamt` decimal(12,2) NOT NULL,
  `tax_id` int(11) NOT NULL,
  `currency_id` int(11) NOT NULL,
  `document_no2` varchar(16) NOT NULL,
  `accounts_id` int(11) NOT NULL,
  `multiplyconversion` decimal(12,4) NOT NULL,
  `seqno` int(11) NOT NULL,
  `reference_id` int(11) NOT NULL,
  `bpartner_id` int(11) NOT NULL DEFAULT '0',
  `isreconciled` smallint(1) NOT NULL,
  `bankreconcilation_id` int(11) NOT NULL,
  `transtype` varchar(2) NOT NULL,
  `linedesc` text,
  `reconciledate` date NOT NULL,
  `created` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `createdby` int(11) NOT NULL DEFAULT '0',
  `branch_id` int(11) NOT NULL DEFAULT '0',
  `track_id1` int(11) NOT NULL DEFAULT '0',
  `track_id2` int(11) NOT NULL DEFAULT '0',
  `track_id3` int(11) NOT NULL DEFAULT '0',
  `row_typeline` smallint(1) NOT NULL DEFAULT '1',
  `temp_parent_id` int(11) NOT NULL,
  PRIMARY KEY (`trans_id`),
  KEY `document_no` (`document_no`),
  KEY `batch_id` (`batch_id`),
  KEY `tax_id` (`tax_id`),
  KEY `currency_id` (`currency_id`),
  KEY `document_no2` (`document_no2`),
  KEY `accounts_id` (`accounts_id`),
  KEY `reference_id` (`reference_id`),
  KEY `bpartner_id` (`bpartner_id`),
  KEY `bankreconcilation_id` (`bankreconcilation_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=26 ;

--
-- Dumping data for table `sim_simbiz_transaction`
--

INSERT INTO `sim_simbiz_transaction` (`trans_id`, `document_no`, `batch_id`, `amt`, `originalamt`, `tax_id`, `currency_id`, `document_no2`, `accounts_id`, `multiplyconversion`, `seqno`, `reference_id`, `bpartner_id`, `isreconciled`, `bankreconcilation_id`, `transtype`, `linedesc`, `reconciledate`, `created`, `createdby`, `branch_id`, `track_id1`, `track_id2`, `track_id3`, `row_typeline`, `temp_parent_id`) VALUES
(19, '-', 1, '-20.00', '-20.00', 0, 3, '', 52, '1.0000', 1, 0, 0, 0, 0, '', 'paysalary', '0000-00-00', '2010-08-28 17:51:26', 1, 1, 0, 0, 0, 1, 1),
(20, '-', 1, '30.00', '30.00', 0, 3, 'MBB823233', 50, '1.0000', 4, 0, 0, 0, 0, '', 'Transfer fund from place 1 to 2', '0000-00-00', '2010-08-28 17:51:26', 1, 1, 0, 0, 0, 1, 2),
(21, '-', 1, '10.00', '10.00', 0, 3, '', 45, '1.0000', 2, 19, 0, 0, 0, '', '', '0000-00-00', '2010-08-28 17:51:26', 1, 1, 0, 0, 0, 2, 1),
(22, '-', 1, '10.00', '10.00', 0, 3, '', 46, '1.0000', 3, 19, 0, 0, 0, '', '', '0000-00-00', '2010-08-28 17:51:26', 1, 1, 0, 0, 0, 2, 1),
(23, '-', 1, '-30.00', '-30.00', 0, 3, '', 52, '1.0000', 5, 20, 0, 0, 0, '', '', '0000-00-00', '2010-08-28 17:51:26', 1, 1, 0, 0, 0, 2, 2),
(24, '', 2, '-400.00', '-400.00', 0, 3, '', 31, '1.0000', 1, 0, 0, 0, 0, '', '', '0000-00-00', '2010-08-28 17:54:02', 1, 1, 0, 0, 0, 1, 1),
(25, '', 2, '400.00', '400.00', 0, 3, '', 52, '1.0000', 2, 24, 0, 0, 0, '', '', '0000-00-00', '2010-08-28 17:54:02', 1, 1, 0, 0, 0, 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `sim_simbiz_transsummary`
--

CREATE TABLE IF NOT EXISTS `sim_simbiz_transsummary` (
  `transum_id` int(11) NOT NULL AUTO_INCREMENT,
  `period_id` int(11) NOT NULL,
  `accounts_id` int(11) NOT NULL,
  `organization_id` int(11) NOT NULL DEFAULT '0',
  `bpartner_id` int(11) NOT NULL,
  `lastbalance` decimal(14,2) NOT NULL,
  `transactionamt` decimal(14,2) NOT NULL,
  PRIMARY KEY (`transum_id`),
  KEY `period_id` (`period_id`),
  KEY `account_id` (`accounts_id`),
  KEY `organization_id` (`organization_id`),
  KEY `bpartner_id` (`bpartner_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=27 ;

--
-- Dumping data for table `sim_simbiz_transsummary`
--

INSERT INTO `sim_simbiz_transsummary` (`transum_id`, `period_id`, `accounts_id`, `organization_id`, `bpartner_id`, `lastbalance`, `transactionamt`) VALUES
(1, 3, 51, 1, 7, '-900.00', '-900.00'),
(2, 3, 50, 1, 0, '0.00', '0.00'),
(3, 3, 52, 1, 0, '1000.00', '1000.00'),
(4, 3, 51, 1, 0, '-100.00', '-100.00'),
(9, 6, 43, 1, 0, '3.00', '3.00'),
(10, 6, 46, 1, 0, '-3.00', '-3.00'),
(11, 6, 45, 1, 0, '300.00', '300.00'),
(12, 6, 44, 1, 0, '0.00', '0.00'),
(13, 6, 47, 1, 0, '-300.00', '-300.00'),
(14, 6, 42, 1, 0, '-12250.00', '-7450.00'),
(15, 6, 41, 1, 0, '0.00', '0.00'),
(16, 6, 53, 1, 0, '50.00', '50.00'),
(17, 6, 55, 1, 0, '400.00', '400.00'),
(18, 11, 51, 1, 0, '-2096.00', '-1996.00'),
(19, 11, 50, 1, 0, '1996.00', '1996.00'),
(20, 11, 52, 1, 0, '1200.00', '200.00'),
(21, 6, 51, 1, 2, '0.00', '0.00'),
(22, 6, 51, 1, 1, '7000.00', '7000.00'),
(23, 5, 42, 1, 0, '-4800.00', '-800.00'),
(24, 5, 50, 1, 0, '2796.00', '800.00'),
(25, 4, 52, 1, 0, '5200.00', '4000.00'),
(26, 4, 42, 1, 0, '-4000.00', '-4000.00');

-- --------------------------------------------------------

--
-- Table structure for table `sim_simbiz_window`
--

CREATE TABLE IF NOT EXISTS `sim_simbiz_window` (
  `window_id` smallint(5) NOT NULL AUTO_INCREMENT,
  `filename` varchar(50) NOT NULL DEFAULT '',
  `isactive` char(1) NOT NULL DEFAULT 'Y',
  `window_name` varchar(50) NOT NULL DEFAULT '',
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updatedby` int(11) NOT NULL DEFAULT '0',
  `created` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `createdby` int(11) NOT NULL DEFAULT '0',
  `functiontype` char(1) NOT NULL DEFAULT 'W',
  `seqno` int(5) NOT NULL DEFAULT '0',
  `mid` mediumint(5) NOT NULL DEFAULT '0',
  `table_name` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`window_id`),
  KEY `filename` (`filename`),
  KEY `functiontype` (`functiontype`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=89 ;

--
-- Dumping data for table `sim_simbiz_window`
--

INSERT INTO `sim_simbiz_window` (`window_id`, `filename`, `isactive`, `window_name`, `updated`, `updatedby`, `created`, `createdby`, `functiontype`, `seqno`, `mid`, `table_name`) VALUES
(1, 'accounts.php', 'Y', 'Chart Of Accounts', '2010-03-22 11:15:25', 1, '2008-11-10 22:48:54', 1, 'M', 10, 0, NULL),
(3, 'accountgroup.php', 'Y', 'Account Group', '2008-11-28 09:38:34', 1, '2008-11-11 16:33:00', 1, 'M', 18, 0, NULL),
(5, 'tax.php', 'Y', 'Tax', '2008-11-11 23:47:08', 1, '2008-11-11 23:47:08', 1, 'M', 50, 0, NULL),
(8, 'batch.php', 'Y', 'Journal Entry', '2008-11-13 23:13:17', 1, '2008-11-13 03:30:55', 1, 'T', 80, 0, NULL),
(10, 'viewtrialbalancesummary.php', 'N', 'Trial Balance Summary (PDF)', '2009-01-04 21:11:37', 1, '2008-11-15 23:22:01', 1, 'V', 100, 0, NULL),
(11, 'viewtrialbalancedetail.php', 'N', 'Trial Balance Detail (PDF)', '2009-01-04 21:11:50', 1, '2008-11-16 01:28:58', 1, 'V', 110, 0, NULL),
(14, 'ledgerreport.php', 'Y', 'Ledger Report', '2008-12-25 15:37:53', 1, '2008-11-29 07:28:45', 1, 'V', 140, 0, NULL),
(15, 'incomestatement.php', 'Y', 'Income Statement', '2008-12-31 20:09:47', 1, '2008-11-29 13:40:45', 1, 'V', 150, 0, NULL),
(16, 'balancesheet.php', 'Y', 'Balance Sheet', '2009-01-04 21:13:01', 1, '2008-12-01 09:43:33', 1, 'V', 160, 0, NULL),
(18, 'accountbalancereport.php', 'Y', 'Account Balance Report', '2008-12-27 02:33:05', 1, '2008-12-24 14:04:48', 1, 'V', 180, 0, NULL),
(19, 'viewsingleledger.php', 'N', 'Single Ledger Report (PDF)', '2008-12-25 20:55:32', 1, '2008-12-25 20:54:22', 1, 'V', 190, 0, NULL),
(20, 'viewmultiledger.php', 'N', 'Multi Ledger Report(PDF)', '2008-12-25 22:25:10', 1, '2008-12-25 20:55:24', 1, 'V', 200, 0, NULL),
(21, 'viewdebtorledger.php', 'N', 'Debtor Ledger Report (PDF)', '2008-12-25 20:55:55', 1, '2008-12-25 20:55:55', 1, 'V', 210, 0, NULL),
(22, 'viewcreditorledger.php', 'N', 'Creditor Ledger Report(PDF)', '2009-01-04 21:12:43', 1, '2008-12-25 20:56:14', 1, 'V', 220, 0, NULL),
(23, 'test.php', 'N', 'test.php', '2009-02-15 14:16:16', 1, '2008-12-26 19:56:04', 1, 'V', 230, 0, NULL),
(24, 'trialbalancereport.php', 'Y', 'Trial Balance Report', '2009-02-15 18:42:01', 1, '2008-12-27 00:04:16', 1, 'V', 145, 0, NULL),
(25, 'viewaccountbalancereport.php', 'N', 'View Account Balance (PDF)', '2008-12-27 13:30:06', 1, '2008-12-27 13:30:06', 1, 'V', 250, 0, NULL),
(26, 'viewbpartnerbalancereport.php', 'N', 'Business Partner Account Balance Report (PDF)', '2009-01-04 21:12:03', 1, '2008-12-27 13:50:36', 1, 'V', 260, 0, NULL),
(27, 'bpartnerstatement.php', 'Y', 'Business Partner Statement Report', '2008-12-27 15:13:07', 1, '2008-12-27 15:13:07', 1, 'V', 270, 0, NULL),
(28, 'viewbpartnerstatement.php', 'N', 'Business Partner Statement Report(PDF)', '2009-01-05 17:44:45', 1, '2008-12-27 15:35:05', 1, 'V', 280, 0, NULL),
(29, 'financialyear.php', 'Y', 'Financial Year', '2009-01-02 11:14:01', 1, '2009-01-02 11:14:01', 1, 'M', 290, 0, NULL),
(30, 'recordinfo.php', 'N', 'Record Info', '2009-02-15 14:16:06', 1, '2009-01-02 12:41:18', 1, 'M', 300, 0, NULL),
(31, 'viewincomestatement_singlecol.php', 'N', 'Single Period Income Statement (PDF)', '2009-09-23 13:10:09', 1, '2009-01-02 14:00:11', 1, 'V', 310, 0, NULL),
(32, 'viewincomestatement_duocol.php', 'N', 'Income Statement (PDF Compare 2 month)', '2009-09-23 13:10:23', 1, '2009-01-02 18:13:41', 1, 'V', 320, 0, NULL),
(33, 'htmlincomestatement_multipleperiod.php', 'N', 'Income Statement (Compare multi period)', '2009-09-23 13:10:52', 1, '2009-01-02 20:03:33', 1, 'V', 330, 0, NULL),
(34, 'htmlincomestatement_chartgenerator.php', 'N', 'Income Statement (Chart Generator)', '2009-09-23 13:11:12', 1, '2009-01-02 21:59:37', 1, 'V', 340, 0, NULL),
(35, 'viewbalancesheet_singlecol.php', 'N', 'Balance Sheet (Single Period PDF)', '2009-09-23 13:11:27', 1, '2009-01-04 22:41:12', 1, 'V', 350, 0, NULL),
(36, 'viewbalancesheet_duocol.php', 'N', 'Balance Sheet (Duol Period PDF)', '2009-09-23 13:11:38', 1, '2009-01-05 17:40:39', 1, 'V', 360, 0, NULL),
(37, 'transactionsummary.php', 'N', 'Transaction Summary', '2009-01-10 03:10:17', 1, '2009-01-06 13:43:08', 1, 'V', 370, 0, NULL),
(38, 'debitcreditnote.php', 'Y', 'Debit/Credit Note', '2009-02-02 19:15:02', 1, '2009-02-02 19:15:02', 1, 'T', 380, 0, NULL),
(39, 'receipt.php', 'Y', 'Receipt', '2009-02-02 19:15:55', 1, '2009-02-02 19:15:55', 1, 'T', 390, 0, NULL),
(40, 'viewdebitcreditnote.php', 'N', 'Debit/Credit Note (PDF)', '2009-02-15 14:14:36', 1, '2009-02-03 23:58:12', 1, 'V', 400, 0, NULL),
(41, 'bankreconcilation.php', 'Y', 'Bank Reconcilation', '2009-02-06 15:55:12', 1, '2009-02-06 15:50:20', 1, 'T', 410, 0, NULL),
(42, 'viewbankreconcilationreport.php', 'N', 'Bank Reconcilation Report', '2009-02-15 14:14:51', 1, '2009-02-10 12:13:21', 1, 'V', 420, 0, NULL),
(43, 'viewreceipt.php', 'N', 'Preview Receipt (PDF)', '2009-02-10 23:14:04', 1, '2009-02-10 23:14:04', 1, 'V', 430, 0, NULL),
(44, 'paymentvoucher.php', 'Y', 'Payment Voucher', '2009-02-17 11:54:10', 1, '2009-02-11 14:21:06', 1, 'T', 400, 0, NULL),
(45, 'viewpaymentvoucher.php', 'N', 'Payment Voucher (PDF)', '2009-02-15 14:14:08', 1, '2009-02-11 14:58:21', 1, 'V', 450, 0, NULL),
(46, 'viewprintcheque.php', 'N', 'Print Cheque (PDF)', '2009-02-15 14:14:18', 1, '2009-02-11 16:35:32', 1, 'V', 460, 0, NULL),
(47, 'invoice.php', 'Y', 'Sales/Purchase Invoice', '2009-02-17 11:54:29', 1, '2009-02-16 12:52:09', 1, 'T', 470, 0, NULL),
(48, 'viewinvoice.php', 'N', 'Invoice (PDF)', '2009-02-17 11:54:50', 1, '2009-02-16 12:52:40', 1, 'V', 480, 0, NULL),
(49, 'viewincomestatement_periodyear.php', 'N', 'Year To Date vs Period (Income Statement)', '2009-03-11 09:50:11', 1, '2009-03-11 09:50:11', 1, 'V', 490, 0, NULL),
(50, 'viewagingstatement.php', 'N', 'View Aging Statement (pdf)', '2010-03-19 21:57:06', 2, '2009-05-27 10:39:51', 2, 'V', 500, 29, ''),
(51, 'courseinvoice.php', 'Y', 'Item Invoice By Course', '2010-03-19 21:57:06', 1, '2009-07-30 12:25:31', 1, 'M', 510, 29, 'sim_simedu_courseinvoice'),
(52, 'generateinvoice.php', 'Y', 'View / Generate Student Invoice By Semester', '2010-03-19 21:57:06', 1, '2009-07-31 14:29:37', 1, 'T', 520, 29, 'sim_simedu_generatestudentinvoice'),
(53, 'viewstudentinvoice.php', 'N', 'View Student Invoice (PDF)', '2010-03-19 21:57:06', 1, '2009-08-03 12:41:05', 1, 'V', 530, 29, ''),
(54, 'studentinvoice.php', 'Y', 'Student Invoice', '2010-03-19 21:57:06', 1, '2009-08-04 10:07:41', 1, 'T', 540, 29, 'sim_simedu_studentinvoice'),
(55, 'studentcharges.php', 'Y', 'Create Student Charges', '2009-08-04 15:20:21', 1, '2009-08-04 15:20:21', 1, 'T', 550, 0, 'sim_simedu_student'),
(56, 'studentpayment.php', 'Y', 'Student Payment', '2010-03-19 21:57:06', 1, '2009-08-05 10:02:19', 1, 'T', 560, 29, 'sim_simedu_studentpayment'),
(57, 'viewstudentpayment.php', 'N', 'View Student Payment (PDF)', '2010-03-19 21:57:06', 1, '2009-08-05 15:01:02', 1, 'V', 570, 29, ''),
(58, 'viewdailyreceipt.php', 'N', 'View Daily Receipt Report', '2010-03-19 21:57:06', 1, '2009-08-07 09:25:01', 1, 'V', 580, 29, ''),
(59, 'viewoutstandingpayment.php', 'Y', 'Outstanding Payment Report', '2010-03-19 21:57:06', 1, '2009-08-07 10:41:40', 1, 'V', 590, 29, ''),
(60, 'viewstudentaccountstatement.php', 'Y', 'View Student Account Statement', '2010-03-19 21:57:06', 1, '2009-08-07 12:11:26', 1, 'V', 600, 29, ''),
(61, 'viewstudentaccountstatementreport.php', 'N', 'View Student Account Statement (PDF)', '2010-03-19 21:57:06', 1, '2009-08-07 14:27:27', 1, 'V', 610, 29, ''),
(62, 'studentfeedback.php', 'Y', 'Student Feedback', '2010-03-19 21:57:06', 1, '2009-08-09 12:37:49', 1, 'T', 620, 29, 'sim_simedu_studentfeedback'),
(63, 'viewstudentfeedback.php', 'N', 'View Student Feedback (Form)', '2010-03-19 21:57:06', 1, '2009-08-09 12:41:49', 1, 'V', 630, 29, ''),
(64, 'overtime.php', 'N', 'Overtime Claim (Line)', '2010-03-19 21:57:06', 1, '2009-08-11 15:35:32', 1, 'T', 640, 29, 'sim_simedu_overtime'),
(65, 'otapproval.php', 'Y', 'Overtime Claim', '2010-03-19 21:57:06', 1, '2009-08-12 09:54:51', 1, 'T', 650, 29, 'sim_simedu_overtime'),
(66, 'payslip.php', 'Y', 'Payslip', '2010-03-19 21:57:06', 1, '2009-08-14 09:26:00', 1, 'T', 660, 29, 'sim_simedu_payslip'),
(67, 'printpayslip.php', 'N', 'Payslip (PDF)', '2010-03-19 21:57:06', 1, '2009-08-14 09:27:07', 1, 'V', 670, 29, ''),
(68, 'listpayslip.php', 'N', 'List Payslip', '2010-03-19 21:57:06', 1, '2009-08-14 10:04:28', 1, 'V', 680, 29, ''),
(69, 'studentonline.php', 'Y', 'Check Online Application', '2010-03-19 21:57:06', 1, '2009-08-18 14:59:23', 1, 'T', 690, 29, 'sim_simedu_studentonline'),
(70, 'studentapplication.php', 'Y', 'Student Quit Application', '2010-03-19 21:57:06', 1, '2009-08-20 10:19:34', 1, 'T', 700, 29, 'sim_simedu_mainapplication'),
(71, 'viewovertime.php', 'N', 'View Overtime (PDF)', '2010-03-19 21:57:06', 1, '2009-08-20 13:33:42', 1, 'V', 710, 29, ''),
(72, 'employee.php', 'Y', 'Employee Profile', '2010-03-19 21:57:06', 1, '2009-08-20 17:47:15', 1, 'M', 720, 29, 'sim_simedu_employee'),
(73, 'student.php', 'Y', 'Student Profile', '2010-03-19 21:57:06', 1, '2009-08-20 18:18:11', 1, 'M', 730, 29, 'sim_simedu_student'),
(74, 'viewpayrollreport.php', 'Y', 'View Payroll Report', '2010-03-19 21:57:06', 1, '2009-08-21 10:02:31', 1, 'V', 740, 29, ''),
(75, 'viewpayrollsummary.php', 'Y', 'View Payroll Summary', '2010-03-19 21:57:06', 1, '2009-09-09 10:39:38', 1, 'V', 750, 29, 'sim_simedu_employee'),
(76, 'reminder.php', 'Y', 'Reminder', '2010-03-19 21:57:06', 1, '2009-09-17 09:42:34', 1, 'M', 760, 29, ''),
(78, 'studentreminder.php', 'Y', 'Student Reminder', '2010-03-19 21:57:06', 1, '2009-09-17 11:19:06', 1, 'T', 780, 29, ''),
(79, 'studentchase.php', 'Y', 'Outstanding Payment Student History', '2010-03-19 21:57:06', 1, '2009-10-06 09:44:55', 1, 'T', 790, 29, 'sim_simedu_studentchase'),
(80, 'courseloan.php', 'Y', 'Item Loan By Course', '2010-03-19 21:57:06', 1, '2009-10-06 10:54:53', 1, 'M', 600, 29, 'sim_simedu_courseloan'),
(81, 'loangenerate.php', 'Y', 'Auto Generate Student Loan', '2010-03-19 21:57:06', 1, '2009-10-06 12:23:43', 1, 'T', 530, 29, 'sim_simedu_student'),
(82, 'chartsalesexpenses_6month.php', 'N', 'Chart for 6 months Sales and Expenses', '2010-03-19 21:57:06', 1, '2009-09-18 23:43:07', 1, 'V', 510, 29, NULL),
(83, 'chartretainearning_6month.php', 'N', 'Chart for 6 months Profit and Lost', '2010-03-19 21:57:06', 1, '2009-09-18 23:43:35', 1, 'V', 520, 29, NULL),
(84, 'viewtransaction.php', 'Y', 'Transaction Report', '2010-03-19 21:57:06', 1, '2009-09-21 13:41:48', 1, 'V', 530, 29, NULL),
(85, 'htmlincomestatement_multipleperiod.php', 'N', 'Income Statement (Multiple Month)', '2010-03-19 21:57:06', 1, '2009-09-21 18:14:56', 1, 'V', 540, 29, NULL),
(86, 'htmlbalancesheet_multipleperiod.php', 'N', 'HTML Balance Sheet (Compare multiple period)', '2010-03-19 21:57:06', 1, '2009-09-23 13:12:11', 1, 'V', 550, 29, NULL),
(87, 'htmlbalancesheet_chartgenerator.php', 'N', 'HTML Balance Sheet (Chart Generator)', '2010-04-19 16:57:26', 1, '2009-09-23 19:58:16', 1, 'V', 560, 29, NULL),
(88, 'viewincomestatement_singleperiod.php', 'N', 'Income Statement Report (PDF)', '2010-03-22 11:33:21', 1, '2010-03-22 11:33:21', 1, 'V', 800, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sim_smiles`
--

CREATE TABLE IF NOT EXISTS `sim_smiles` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(50) NOT NULL DEFAULT '',
  `smile_url` varchar(100) NOT NULL DEFAULT '',
  `emotion` varchar(75) NOT NULL DEFAULT '',
  `display` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=18 ;

--
-- Dumping data for table `sim_smiles`
--


-- --------------------------------------------------------

--
-- Table structure for table `sim_terms`
--

CREATE TABLE IF NOT EXISTS `sim_terms` (
  `terms_id` int(11) NOT NULL AUTO_INCREMENT,
  `terms_name` varchar(50) NOT NULL,
  `seqno` smallint(6) NOT NULL,
  `isactive` smallint(6) NOT NULL,
  `created` datetime NOT NULL,
  `createdby` int(11) NOT NULL,
  `updated` datetime NOT NULL,
  `updatedby` int(11) NOT NULL,
  `organization_id` int(11) NOT NULL,
  `daycount` smallint(6) NOT NULL,
  `description` varchar(70) NOT NULL,
  PRIMARY KEY (`terms_id`),
  KEY `organization_id` (`organization_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `sim_terms`
--

INSERT INTO `sim_terms` (`terms_id`, `terms_name`, `seqno`, `isactive`, `created`, `createdby`, `updated`, `updatedby`, `organization_id`, `daycount`, `description`) VALUES
(0, '', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, 0, 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `sim_tplfile`
--

CREATE TABLE IF NOT EXISTS `sim_tplfile` (
  `tpl_id` mediumint(7) unsigned NOT NULL AUTO_INCREMENT,
  `tpl_refid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `tpl_module` varchar(25) NOT NULL DEFAULT '',
  `tpl_tplset` varchar(50) NOT NULL DEFAULT '',
  `tpl_file` varchar(50) NOT NULL DEFAULT '',
  `tpl_desc` varchar(255) NOT NULL DEFAULT '',
  `tpl_lastmodified` int(10) unsigned NOT NULL DEFAULT '0',
  `tpl_lastimported` int(10) unsigned NOT NULL DEFAULT '0',
  `tpl_type` varchar(20) NOT NULL DEFAULT '',
  PRIMARY KEY (`tpl_id`),
  KEY `tpl_refid` (`tpl_refid`,`tpl_type`),
  KEY `tpl_tplset` (`tpl_tplset`,`tpl_file`(10))
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=121 ;

--
-- Dumping data for table `sim_tplfile`
--

INSERT INTO `sim_tplfile` (`tpl_id`, `tpl_refid`, `tpl_module`, `tpl_tplset`, `tpl_file`, `tpl_desc`, `tpl_lastmodified`, `tpl_lastimported`, `tpl_type`) VALUES
(1, 1, 'system', 'default', 'system_imagemanager.html', '', 1268966326, 1268966326, 'module'),
(2, 1, 'system', 'default', 'system_imagemanager2.html', '', 1268966326, 1268966326, 'module'),
(3, 1, 'system', 'default', 'system_userinfo.html', '', 1268966326, 1268966326, 'module'),
(4, 1, 'system', 'default', 'system_userform.html', '', 1268966326, 1268966326, 'module'),
(5, 1, 'system', 'default', 'system_rss.html', '', 1268966326, 1268966326, 'module'),
(6, 1, 'system', 'default', 'system_redirect.html', '', 1268966326, 1268966326, 'module'),
(7, 1, 'system', 'default', 'system_comment.html', '', 1268966326, 1268966326, 'module'),
(8, 1, 'system', 'default', 'system_comments_flat.html', '', 1268966326, 1268966326, 'module'),
(9, 1, 'system', 'default', 'system_comments_thread.html', '', 1268966326, 1268966326, 'module'),
(10, 1, 'system', 'default', 'system_comments_nest.html', '', 1268966326, 1268966326, 'module'),
(11, 1, 'system', 'default', 'system_siteclosed.html', '', 1268966326, 1268966326, 'module'),
(12, 1, 'system', 'default', 'system_dummy.html', 'Dummy template file for holding non-template contents. This should not be edited.', 1268966326, 1268966326, 'module'),
(13, 1, 'system', 'default', 'system_notification_list.html', '', 1268966326, 1268966326, 'module'),
(14, 1, 'system', 'default', 'system_notification_select.html', '', 1268966326, 1268966326, 'module'),
(15, 1, 'system', 'default', 'system_block_dummy.html', 'Dummy template for custom blocks or blocks without templates', 1268966326, 1268966326, 'module'),
(16, 1, 'system', 'default', 'system_homepage.html', 'Homepage template', 1268966326, 1268966326, 'module'),
(17, 1, 'system', 'default', 'system_bannerlogin.html', 'Banner Login', 1268966326, 1268966326, 'module'),
(18, 1, 'system', 'default', 'system_banner.html', 'Banner Login', 1268966326, 1268966326, 'module'),
(19, 1, 'system', 'default', 'system_bannerdisplay.html', 'Banner Login', 1268966326, 1268966326, 'module'),
(20, 1, 'system', 'default', 'system_block_user.html', 'Shows user block', 1268966326, 1268966326, 'block'),
(21, 2, 'system', 'default', 'system_block_login.html', 'Shows login form', 1268966326, 1268966326, 'block'),
(22, 3, 'system', 'default', 'system_block_search.html', 'Shows search form block', 1268966326, 1268966326, 'block'),
(23, 4, 'system', 'default', 'system_block_waiting.html', 'Shows contents waiting for approval', 1268966326, 1268966326, 'block'),
(24, 5, 'system', 'default', 'system_block_mainmenu.html', 'Shows the main navigation menu of the site', 1268966326, 1268966326, 'block'),
(25, 6, 'system', 'default', 'system_block_siteinfo.html', 'Shows basic info about the site and a link to Recommend Us pop up window', 1268966326, 1268966326, 'block'),
(26, 7, 'system', 'default', 'system_block_online.html', 'Displays users/guests currently online', 1268966326, 1268966326, 'block'),
(27, 8, 'system', 'default', 'system_block_topusers.html', 'Top posters', 1268966326, 1268966326, 'block'),
(28, 9, 'system', 'default', 'system_block_newusers.html', 'Shows most recent users', 1268966326, 1268966326, 'block'),
(29, 10, 'system', 'default', 'system_block_comments.html', 'Shows most recent comments', 1268966326, 1268966326, 'block'),
(30, 11, 'system', 'default', 'system_block_notification.html', 'Shows notification options', 1268966326, 1268966326, 'block'),
(31, 12, 'system', 'default', 'system_block_themes.html', 'Shows theme selection box', 1268966326, 1268966326, 'block'),
(32, 2, 'pm', 'default', 'pm_pmlite.html', '', 1268966480, 0, 'module'),
(33, 2, 'pm', 'default', 'pm_readpmsg.html', '', 1268966480, 0, 'module'),
(34, 2, 'pm', 'default', 'pm_lookup.html', '', 1268966480, 0, 'module'),
(35, 2, 'pm', 'default', 'pm_viewpmsg.html', '', 1268966480, 0, 'module'),
(36, 3, 'profile', 'default', 'profile_breadcrumbs.html', '', 1268966480, 0, 'module'),
(37, 3, 'profile', 'default', 'profile_form.html', '', 1268966480, 0, 'module'),
(38, 3, 'profile', 'default', 'profile_admin_fieldlist.html', '', 1268966480, 0, 'module'),
(39, 3, 'profile', 'default', 'profile_userinfo.html', '', 1268966480, 0, 'module'),
(40, 3, 'profile', 'default', 'profile_admin_categorylist.html', '', 1268966480, 0, 'module'),
(41, 3, 'profile', 'default', 'profile_search.html', '', 1268966480, 0, 'module'),
(42, 3, 'profile', 'default', 'profile_results.html', '', 1268966480, 0, 'module'),
(43, 3, 'profile', 'default', 'profile_admin_visibility.html', '', 1268966480, 0, 'module'),
(44, 3, 'profile', 'default', 'profile_admin_steplist.html', '', 1268966480, 0, 'module'),
(45, 3, 'profile', 'default', 'profile_register.html', '', 1268966480, 0, 'module'),
(46, 3, 'profile', 'default', 'profile_changepass.html', '', 1268966480, 0, 'module'),
(47, 3, 'profile', 'default', 'profile_editprofile.html', '', 1268966480, 0, 'module'),
(48, 3, 'profile', 'default', 'profile_userform.html', '', 1268966480, 0, 'module'),
(49, 3, 'profile', 'default', 'profile_avatar.html', '', 1268966480, 0, 'module'),
(50, 3, 'profile', 'default', 'profile_email.html', '', 1268966480, 0, 'module'),
(51, 13, 'simitframework', 'default', 'sideblockshortcut.html', 'This is a Block for the access history link', 1268980710, 0, 'block'),
(96, 22, 'newbb', 'default', 'newbb_block.html', 'Shows recent replied topics', 1269335107, 0, 'block'),
(97, 23, 'newbb', 'default', 'newbb_block_topic.html', 'Shows recent topics in the forums', 1269335107, 0, 'block'),
(98, 24, 'newbb', 'default', 'newbb_block_post.html', 'Shows recent posts in the forums', 1269335107, 0, 'block'),
(99, 25, 'newbb', 'default', 'newbb_block_author.html', 'Shows authors stats', 1269335107, 0, 'block'),
(120, 46, 'simitframework', 'default', 'sideblockshortcut.html', 'This is a Block for the access history link', 1280070992, 0, 'block');

-- --------------------------------------------------------

--
-- Table structure for table `sim_tplset`
--

CREATE TABLE IF NOT EXISTS `sim_tplset` (
  `tplset_id` int(7) unsigned NOT NULL AUTO_INCREMENT,
  `tplset_name` varchar(50) NOT NULL DEFAULT '',
  `tplset_desc` varchar(255) NOT NULL DEFAULT '',
  `tplset_credits` text,
  `tplset_created` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`tplset_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `sim_tplset`
--

INSERT INTO `sim_tplset` (`tplset_id`, `tplset_name`, `tplset_desc`, `tplset_credits`, `tplset_created`) VALUES
(1, 'default', 'XOOPS Default Template Set', '', 1205985656);

-- --------------------------------------------------------

--
-- Table structure for table `sim_tplsource`
--

CREATE TABLE IF NOT EXISTS `sim_tplsource` (
  `tpl_id` mediumint(7) unsigned NOT NULL DEFAULT '0',
  `tpl_source` mediumtext,
  KEY `tpl_id` (`tpl_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sim_tplsource`
--

INSERT INTO `sim_tplsource` (`tpl_id`, `tpl_source`) VALUES
(1, '<!DOCTYPE html PUBLIC ''-//W3C//DTD XHTML 1.0 Transitional//EN'' ''http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd''>\r\n<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<{$xoops_langcode}>" lang="<{$xoops_langcode}>">\r\n<head>\r\n<meta http-equiv="content-type" content="text/html; charset=<{$xoops_charset}>" />\r\n<meta http-equiv="content-language" content="<{$xoops_langcode}>" />\r\n<title><{$sitename}> <{$lang_imgmanager}></title>\r\n<script type="text/javascript">\r\n<!--//\r\nfunction appendCode(addCode) {\r\n	var targetDom = window.opener.xoopsGetElementById(''<{$target}>'');\r\n	if (targetDom.createTextRange && targetDom.caretPos){\r\n  		var caretPos = targetDom.caretPos;\r\n		caretPos.text = caretPos.text.charAt(caretPos.text.length - 1) == '' '' ? addCode + '' '' : addCode;  \r\n	} else if (targetDom.getSelection && targetDom.caretPos) {\r\n		var caretPos = targetDom.caretPos;\r\n		caretPos.text = caretPos.text.charat(caretPos.text.length - 1) == '' '' ? addCode + '' '' : addCode;\r\n	} else {\r\n		targetDom.value = targetDom.value + addCode;\r\n  	}\r\n	window.close();\r\n	return;\r\n}\r\n//-->\r\n</script>\r\n<style type="text/css" media="all">\r\nbody {margin: 0;}\r\nimg {border: 0;}\r\ntable {width: 100%; margin: 0;}\r\na:link {color: #3a76d6; font-weight: bold; background-color: transparent;}\r\na:visited {color: #9eb2d6; font-weight: bold; background-color: transparent;}\r\na:hover {color: #e18a00; background-color: transparent;}\r\ntable td {background-color: white; font-size: 12px; padding: 0; border-width: 0; vertical-align: top; font-family: Verdana, Arial, Helvetica, sans-serif;}\r\ntable#imagenav td {vertical-align: bottom; padding: 5px;}\r\ntable#imagemain td {border-right: 1px solid silver; border-bottom: 1px solid silver; padding: 5px; vertical-align: middle;}\r\ntable#imagemain th {border: 0; background-color: #2F5376; color:white; font-size: 12px; padding: 5px; vertical-align: top; text-align:center; font-family: Verdana, Arial, Helvetica, sans-serif;}\r\ntable#header td {width: 100%; background-color: #2F5376; vertical-align: middle;}\r\ntable#header td#headerbar {border-bottom: 1px solid silver; background-color: #dddddd;}\r\ndiv#pagenav {text-align:center;}\r\ndiv#footer {text-align:right; padding: 5px;}\r\n</style>\r\n\r\n<{php}> \r\n$language = $GLOBALS[''xoopsConfig''][''language''];\r\nif(file_exists(XOOPS_ecitycommy_PATH.''/language/''.$language.''/style.css'')){ \r\necho "<link rel=\\"stylesheet\\" type=\\"text/css\\" media=\\"all\\" href=\\"language/$language/style.css\\" />";\r\n}\r\n<{/php}>\r\n\r\n</head>\r\n\r\n<body onload="window.resizeTo(<{$xsize}>, <{$ysize}>);">\r\n  <table id="header" cellspacing="0">\r\n    <tr>\r\n      <td><a href="<{$xoops_url}>/" title=""><img src="<{$xoops_url}>/images/logo.gif" width="150" height="80" alt="" /></a></td><td> </td>\r\n    </tr>\r\n    <tr>\r\n      <td id="headerbar" colspan="2"> </td>\r\n    </tr>\r\n  </table>\r\n\r\n  <form action="imagemanager.php" method="get">\r\n    <table cellspacing="0" id="imagenav">\r\n      <tr>\r\n        <td>\r\n          <select name="cat_id" onchange="location=''<{$xoops_url}>/imagemanager.php?target=<{$target}>&cat_id=''+this.options[this.selectedIndex].value"><{$cat_options}></select> <input type="hidden" name="target" value="<{$target}>" /><input type="submit" value="<{$lang_go}>" />\r\n        </td>\r\n\r\n        <{if $show_cat > 0}>\r\n        <td align="right"><a href="<{$xoops_url}>/imagemanager.php?target=<{$target}>&op=upload&imgcat_id=<{$show_cat}>" title="<{$lang_addimage}>"><{$lang_addimage}></a></td>\r\n        <{/if}>\r\n\r\n      </tr>\r\n    </table>\r\n  </form>\r\n\r\n  <{if $image_total > 0}>\r\n\r\n  <table cellspacing="0" id="imagemain">\r\n    <tr>\r\n      <th><{$lang_imagename}></th>\r\n      <th><{$lang_image}></th>\r\n      <th><{$lang_imagemime}></th>\r\n      <th><{$lang_align}></th>\r\n    </tr>\r\n\r\n    <{section name=i loop=$images}>\r\n    <tr align="center">\r\n      <td><input type="hidden" name="image_id[]" value="<{$images[i].id}>" /><{$images[i].nicename}></td>\r\n      <td><img src="<{$images[i].src}>" alt="" /></td>\r\n      <td><{$images[i].mimetype}></td>\r\n      <td><a href="#" title="" onclick="javascript:appendCode(''<{$images[i].lxcode}>'');"><img src="<{$xoops_url}>/images/alignleft.gif" alt="Left" /></a> <a href="#" title="" onclick="javascript:appendCode(''<{$images[i].xcode}>'');"><img src="<{$xoops_url}>/images/aligncenter.gif" alt="Center" /></a> <a href="#" title="" onclick="javascript:appendCode(''<{$images[i].rxcode}>'');"><img src="<{$xoops_url}>/images/alignright.gif" alt="Right" /></a></td>\r\n    </tr>\r\n    <{/section}>\r\n  </table>\r\n\r\n  <{/if}>\r\n\r\n  <div id="pagenav"><{$pagenav}></div>\r\n\r\n  <div id="footer">\r\n    <input value="<{$lang_close}>" type="button" onclick="javascript:window.close();" />\r\n  </div>\r\n\r\n  </body>\r\n</html>'),
(2, '<!DOCTYPE html PUBLIC ''-//W3C//DTD XHTML 1.0 Transitional//EN'' ''http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd''>\r\n<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<{$xoops_langcode}>" lang="<{$xoops_langcode}>">\r\n<head>\r\n<meta http-equiv="content-type" content="text/html; charset=<{$xoops_charset}>" />\r\n<meta http-equiv="content-language" content="<{$xoops_langcode}>" />\r\n<title><{$xoops_sitename}> <{$lang_imgmanager}></title>\r\n<{$image_form.javascript}>\r\n<style type="text/css" media="all">\r\nbody {margin: 0;}\r\nimg {border: 0;}\r\ntable {width: 100%; margin: 0;}\r\na:link {color: #3a76d6; font-weight: bold; background-color: transparent;}\r\na:visited {color: #9eb2d6; font-weight: bold; background-color: transparent;}\r\na:hover {color: #e18a00; background-color: transparent;}\r\ntable td {background-color: white; font-size: 12px; padding: 0; border-width: 0; vertical-align: top; font-family: Verdana, Arial, Helvetica, sans-serif;}\r\ntable#imagenav td {vertical-align: bottom; padding: 5px;}\r\ntd.body {padding: 5px; vertical-align: middle;}\r\ntd.caption {border: 0; background-color: #2F5376; color:white; font-size: 12px; padding: 5px; vertical-align: top; text-align:left; font-family: Verdana, Arial, Helvetica, sans-serif;}\r\ntable#imageform {border: 1px solid silver;}\r\ntable#header td {width: 100%; background-color: #2F5376; vertical-align: middle;}\r\ntable#header td#headerbar {border-bottom: 1px solid silver; background-color: #dddddd;}\r\ndiv#footer {text-align:right; padding: 5px;}\r\n</style>\r\n\r\n<{php}> \r\n$language = $GLOBALS[''xoopsConfig''][''language''];\r\nif(file_exists(XOOPS_ecitycommy_PATH.''/language/''.$language.''/style.css'')){ \r\necho "<link rel=\\"stylesheet\\" type=\\"text/css\\" media=\\"all\\" href=\\"language/$language/style.css\\" />";\r\n}\r\n<{/php}>\r\n\r\n</head>\r\n\r\n<body onload="window.resizeTo(<{$xsize}>, <{$ysize}>);">\r\n  <table id="header" cellspacing="0">\r\n    <tr>\r\n      <td><a href="<{$xoops_url}>/" title=""><img src="<{$xoops_url}>/images/logo.gif" width="150" height="80" alt="" /></a></td><td> </td>\r\n    </tr>\r\n    <tr>\r\n      <td id="headerbar" colspan="2"> </td>\r\n    </tr>\r\n  </table>\r\n\r\n  <table cellspacing="0" id="imagenav">\r\n    <tr>\r\n      <td align="left"><a href="<{$xoops_url}>/imagemanager.php?target=<{$target}>&amp;cat_id=<{$show_cat}>" title="<{$lang_imgmanager}>"><{$lang_imgmanager}></a></td>\r\n    </tr>\r\n  </table>\r\n\r\n  <form name="<{$image_form.name}>" id="<{$image_form.name}>" action="<{$image_form.action}>" method="<{$image_form.method}>" <{$image_form.extra}>>\r\n    <table id="imageform" cellspacing="0">\r\n    <!-- start of form elements loop -->\r\n    <{foreach item=element from=$image_form.elements}>\r\n      <{if $element.hidden != true}>\r\n      <tr valign="top">\r\n        <td class="caption"><{$element.caption}></td>\r\n        <td class="body"><{$element.body}></td>\r\n      </tr>\r\n      <{else}>\r\n      <{$element.body}>\r\n      <{/if}>\r\n    <{/foreach}>\r\n    <!-- end of form elements loop -->\r\n    </table>\r\n  </form>\r\n\r\n\r\n  <div id="footer">\r\n    <input value="<{$lang_close}>" type="button" onclick="javascript:window.close();" />\r\n  </div>\r\n\r\n  </body>\r\n</html>'),
(3, '<{if $user_ownpage == true}>\n\n<form name="usernav" action="user.php" method="post">\n\n<br /><br />\n\n<table width="70%" align="center" border="0">\n  <tr align="center">\n    <td><input type="button" value="<{$lang_editprofile}>" onclick="location=''edituser.php''" />\n    <input type="button" value="<{$lang_avatar}>" onclick="location=''edituser.php?op=avatarform''" />\n    <input type="button" value="<{$lang_inbox}>" onclick="location=''viewpmsg.php''" />\n\n    <{if $user_candelete == true}>\n    <input type="button" value="<{$lang_deleteaccount}>" onclick="location=''user.php?op=delete''" />\n    <{/if}>\n\n    <input type="button" value="<{$lang_logout}>" onclick="location=''user.php?op=logout''" /></td>\n  </tr>\n</table>\n</form>\n\n<br /><br />\n<{elseif $xoops_isadmin != false}>\n\n<br /><br />\n\n<table width="70%" align="center" border="0">\n  <tr align="center">\n    <td><input type="button" value="<{$lang_editprofile}>" onclick="location=''<{$xoops_url}>/modules/system/admin.php?fct=users&amp;uid=<{$user_uid}>&amp;op=modifyUser''" />\n    <input type="button" value="<{$lang_deleteaccount}>" onclick="location=''<{$xoops_url}>/modules/system/admin.php?fct=users&amp;op=delUser&amp;uid=<{$user_uid}>''" />\n  </tr>\n</table>\n\n<br /><br />\n<{/if}>\n\n<table width="100%" border="0" cellspacing="5">\n  <tr valign="top">\n    <td width="50%">\n      <table class="outer" cellpadding="4" cellspacing="1" width="100%">\n        <tr>\n          <th colspan="2" align="center"><{$lang_allaboutuser}></th>\n        </tr>\n        <tr valign="top">\n          <td class="head"><{$lang_avatar}></td>\n          <td align="center" class="even"><img src="<{$user_avatarurl}>" alt="Avatar" /></td>\n        </tr>\n        <tr>\n          <td class="head"><{$lang_realname}></td>\n          <td align="center" class="odd"><{$user_realname}></td>\n        </tr>\n        <tr>\n          <td class="head"><{$lang_website}></td>\n          <td class="even"><{$user_websiteurl}></td>\n        </tr>\n        <tr valign="top">\n          <td class="head"><{$lang_email}></td>\n          <td class="odd"><{$user_email}></td>\n        </tr>\n        <{if !$user_ownpage == true}>\n        <tr valign="top">\n          <td class="head"><{$lang_privmsg}></td>\n          <td class="even"><{$user_pmlink}></td>\n        </tr>\n        <{/if}>\n        <tr valign="top">\n          <td class="head"><{$lang_icq}></td>\n          <td class="odd"><{$user_icq}></td>\n        </tr>\n        <tr valign="top">\n          <td class="head"><{$lang_aim}></td>\n          <td class="even"><{$user_aim}></td>\n        </tr>\n        <tr valign="top">\n          <td class="head"><{$lang_yim}></td>\n          <td class="odd"><{$user_yim}></td>\n        </tr>\n        <tr valign="top">\n          <td class="head"><{$lang_msnm}></td>\n          <td class="even"><{$user_msnm}></td>\n        </tr>\n        <tr valign="top">\n          <td class="head"><{$lang_location}></td>\n          <td class="odd"><{$user_location}></td>\n        </tr>\n        <tr valign="top">\n          <td class="head"><{$lang_occupation}></td>\n          <td class="even"><{$user_occupation}></td>\n        </tr>\n        <tr valign="top">\n          <td class="head"><{$lang_interest}></td>\n          <td class="odd"><{$user_interest}></td>\n        </tr>\n        <tr valign="top">\n          <td class="head"><{$lang_extrainfo}></td>\n          <td class="even"><{$user_extrainfo}></td>\n        </tr>\n      </table>\n    </td>\n    <td width="50%">\n      <table class="outer" cellpadding="4" cellspacing="1" width="100%">\n        <tr valign="top">\n          <th colspan="2" align="center"><{$lang_statistics}></th>\n        </tr>\n        <tr valign="top">\n          <td class="head"><{$lang_membersince}></td>\n          <td align="center" class="even"><{$user_joindate}></td>\n        </tr>\n        <tr valign="top">\n          <td class="head"><{$lang_rank}></td>\n          <td align="center" class="odd"><{$user_rankimage}><br /><{$user_ranktitle}></td>\n        </tr>\n        <tr valign="top">\n          <td class="head"><{$lang_posts}></td>\n          <td align="center" class="even"><{$user_posts}></td>\n        </tr>\n    <tr valign="top">\n          <td class="head"><{$lang_lastlogin}></td>\n          <td align="center" class="odd"><{$user_lastlogin}></td>\n        </tr>\n      </table>\n      <br />\n      <table class="outer" cellpadding="4" cellspacing="1" width="100%">\n        <tr valign="top">\n          <th colspan="2" align="center"><{$lang_signature}></th>\n        </tr>\n        <tr valign="top">\n          <td class="even"><{$user_signature}></td>\n        </tr>\n      </table>\n    </td>\n  </tr>\n</table>\n\n<!-- start module search results loop -->\n<{foreach item=module from=$modules}>\n\n<br style="clear: both;" />\n<h4><{$module.name}></h4>\n\n  <!-- start results item loop -->\n  <{foreach item=result from=$module.results}>\n\n  <img src="<{$result.image}>" alt="<{$module.name}>" /><b><a href="<{$result.link}>" title="<{$result.title}>"><{$result.title}></a></b><br /><small>(<{$result.time}>)</small><br />\n\n  <{/foreach}>\n  <!-- end results item loop -->\n\n<{$module.showall_link}>\n\n\n<{/foreach}>\n<!-- end module search results loop -->\n'),
(4, '<fieldset style="padding: 10px;">\r\n  <legend style="font-weight: bold;"><{$lang_login}></legend>\r\n  <form action="user.php" method="post">\r\n    <{$lang_username}> <input type="text" name="uname" size="26" maxlength="25" value="<{$usercookie}>" /><br /><br />\r\n    <{$lang_password}> <input type="password" name="pass" size="21" maxlength="32" /><br /><br />\r\n    <{if isset($lang_rememberme)}>\r\n        <input type="checkbox" name="rememberme" value="On" checked /> <{$lang_rememberme}><br /><br />\r\n    <{/if}>\r\n    \r\n    <input type="hidden" name="op" value="login" />\r\n    <input type="hidden" name="xoops_redirect" value="<{$redirect_page}>" />\r\n    <input type="submit" value="<{$lang_login}>" />\r\n  </form>\r\n  <br />\r\n  <a name="lost"></a>\r\n  <div><{$lang_notregister}><br /></div>\r\n</fieldset>\r\n\r\n<br />\r\n\r\n<fieldset style="padding: 10px;">\r\n  <legend style="font-weight: bold;"><{$lang_lostpassword}></legend>\r\n  <div><br /><{$lang_noproblem}></div>\r\n  <form action="lostpass.php" method="post">\r\n    <{$lang_youremail}> <input type="text" name="email" size="26" maxlength="60" />&nbsp;&nbsp;<input type="hidden" name="op" value="mailpasswd" /><input type="hidden" name="t" value="<{$mailpasswd_token}>" /><input type="submit" value="<{$lang_sendpassword}>" />\r\n  </form>\r\n</fieldset>'),
(5, '<?xml version="1.0" encoding="UTF-8"?>\r\n<rss version="2.0">\r\n  <channel>\r\n    <title><{$channel_title}></title>\r\n    <link><{$channel_link}></link>\r\n    <description><{$channel_desc}></description>\r\n    <lastBuildDate><{$channel_lastbuild}></lastBuildDate>\r\n    <docs>http://backend.userland.com/rss/</docs>\r\n    <generator><{$channel_generator}></generator>\r\n    <category><{$channel_category}></category>\r\n    <managingEditor><{$channel_editor}></managingEditor>\r\n    <webMaster><{$channel_webmaster}></webMaster>\r\n    <language><{$channel_language}></language>\r\n    <{if $image_url != ""}>\r\n    <image>\r\n      <title><{$channel_title}></title>\r\n      <url><{$image_url}></url>\r\n      <link><{$channel_link}></link>\r\n      <width><{$image_width}></width>\r\n      <height><{$image_height}></height>\r\n    </image>\r\n    <{/if}>\r\n    <{foreach item=item from=$items}>\r\n    <item>\r\n      <title><{$item.title}></title>\r\n      <link><{$item.link}></link>\r\n      <description><{$item.description}></description>\r\n      <pubDate><{$item.pubdate}></pubDate>\r\n      <guid><{$item.guid}></guid>\r\n    </item>\r\n    <{/foreach}>\r\n  </channel>\r\n</rss>'),
(6, '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">\r\n<html>\r\n<head>\r\n<meta http-equiv="Content-Type" content="text/html; charset=<{$xoops_charset}>" />\r\n<meta http-equiv="Refresh" content="<{$time}>; url=<{$url}>" />\r\n<meta name="generator" content="XOOPS" />\r\n<link rel="shortcut icon" type="image/ico" href="<{$xoops_url}>/favicon.ico" />\r\n<title><{$xoops_sitename}></title>\r\n<link rel="stylesheet" type="text/css" media="all" href="<{$xoops_themecss}>" />\r\n</head>\r\n<body>\r\n<div style="text-align:center; background-color: #EBEBEB; border-top: 1px solid #FFFFFF; border-left: 1px solid #FFFFFF; border-right: 1px solid #AAAAAA; border-bottom: 1px solid #AAAAAA; font-weight : bold;">\r\n  <h4><{$message}></h4>\r\n  <p><{$lang_ifnotreload}></p>\r\n</div>\r\n<{if $xoops_logdump != ''''}><div><{$xoops_logdump}></div><{/if}>\r\n</body>\r\n</html>\r\n'),
(7, '<!-- start comment post -->\r\n        <tr>\r\n          <td class="head"><a id="comment<{$comment.id}>"></a> <{$comment.poster.uname}></td>\r\n          <td class="head"><div class="comDate"><span class="comDateCaption"><{$lang_posted}>:</span> <{$comment.date_posted}>&nbsp;&nbsp;<span class="comDateCaption"><{$lang_updated}>:</span> <{$comment.date_modified}></div></td>\r\n        </tr>\r\n        <tr>\r\n\r\n          <{if $comment.poster.id != 0}>\r\n\r\n          <td class="odd"><div class="comUserRank"><div class="comUserRankText"><{$comment.poster.rank_title}></div><img class="comUserRankImg" src="<{$xoops_upload_url}>/<{$comment.poster.rank_image}>" alt="" /></div><img class="comUserImg" src="<{$xoops_upload_url}>/<{$comment.poster.avatar}>" alt="" /><div class="comUserStat"><span class="comUserStatCaption"><{$lang_joined}>:</span> <{$comment.poster.regdate}></div><div class="comUserStat"><span class="comUserStatCaption"><{$lang_from}>:</span> <{$comment.poster.from}></div><div class="comUserStat"><span class="comUserStatCaption"><{$lang_posts}>:</span> <{$comment.poster.postnum}></div><div class="comUserStatus"><{$comment.poster.status}></div></td>\r\n\r\n          <{else}>\r\n\r\n          <td class="odd"> </td>\r\n\r\n          <{/if}>\r\n\r\n          <td class="odd">\r\n            <div class="comTitle"><{$comment.image}><{$comment.title}></div><div class="comText"><{$comment.text}></div>\r\n          </td>\r\n        </tr>\r\n        <tr>\r\n          <td class="even"></td>\r\n\r\n          <{if $xoops_iscommentadmin == true}>\r\n\r\n          <td class="even" align="right">\r\n            <a href="<{$editcomment_link}>&amp;com_id=<{$comment.id}>" title="<{$lang_edit}>"><img src="<{$xoops_url}>/images/icons/edit.gif" alt="<{$lang_edit}>" /></a><a href="<{$deletecomment_link}>&amp;com_id=<{$comment.id}>" title="<{$lang_delete}>"><img src="<{$xoops_url}>/images/icons/delete.gif" alt="<{$lang_delete}>" /></a><a href="<{$replycomment_link}>&amp;com_id=<{$comment.id}>" title="<{$lang_reply}>"><img src="<{$xoops_url}>/images/icons/reply.gif" alt="<{$lang_reply}>" /></a>\r\n          </td>\r\n\r\n          <{elseif $xoops_isuser == true && $xoops_userid == $comment.poster.id}>\r\n\r\n          <td class="even" align="right">\r\n            <a href="<{$editcomment_link}>&amp;com_id=<{$comment.id}>" title="<{$lang_edit}>"><img src="<{$xoops_url}>/images/icons/edit.gif" alt="<{$lang_edit}>" /></a><a href="<{$replycomment_link}>&amp;com_id=<{$comment.id}>" title="<{$lang_reply}>"><img src="<{$xoops_url}>/images/icons/reply.gif" alt="<{$lang_reply}>" /></a>\r\n          </td>\r\n\r\n          <{elseif $xoops_isuser == true || $anon_canpost == true}>\r\n\r\n          <td class="even" align="right">\r\n            <a href="<{$replycomment_link}>&amp;com_id=<{$comment.id}>"><img src="<{$xoops_url}>/images/icons/reply.gif" alt="<{$lang_reply}>" /></a>\r\n          </td>\r\n\r\n          <{else}>\r\n\r\n          <td class="even"> </td>\r\n\r\n          <{/if}>\r\n\r\n        </tr>\r\n<!-- end comment post -->'),
(8, '<table class="outer" cellpadding="5" cellspacing="1">\r\n  <tr>\r\n    <th width="20%"><{$lang_poster}></th>\r\n    <th><{$lang_thread}></th>\r\n  </tr>\r\n  <{foreach item=comment from=$comments}>\r\n    <{include file="db:system_comment.html" comment=$comment}>\r\n  <{/foreach}>\r\n</table>'),
(9, '<{section name=i loop=$comments}>\r\n<br />\r\n<table cellspacing="1" class="outer">\r\n  <tr>\r\n    <th width="20%"><{$lang_poster}></th>\r\n    <th><{$lang_thread}></th>\r\n  </tr>\r\n  <{include file="db:system_comment.html" comment=$comments[i]}>\r\n</table>\r\n\r\n<{if $show_threadnav == true}>\r\n<div style="text-align:left; margin:3px; padding: 5px;">\r\n<a href="<{$comment_url}>" title="<{$lang_top}>"><{$lang_top}></a> | <a href="<{$comment_url}>&amp;com_id=<{$comments[i].pid}>&amp;com_ecitycommyid=<{$comments[i].ecitycommyid}>#newscomment<{$comments[i].pid}>"><{$lang_parent}></a>\r\n</div>\r\n<{/if}>\r\n\r\n<{if $comments[i].show_replies == true}>\r\n<!-- start comment tree -->\r\n<br />\r\n<table cellspacing="1" class="outer">\r\n  <tr>\r\n    <th width="50%"><{$lang_subject}></th>\r\n    <th width="20%" align="center"><{$lang_poster}></th>\r\n    <th align="right"><{$lang_posted}></th>\r\n  </tr>\r\n  <{foreach item=reply from=$comments[i].replies}>\r\n  <tr>\r\n    <td class="even"><{$reply.prefix}> <a href="<{$comment_url}>&amp;com_id=<{$reply.id}>&amp;com_ecitycommyid=<{$reply.ecitycommy_id}>" title="<{$reply.title}>"><{$reply.title}></a></td>\r\n    <td class="odd" align="center"><{$reply.poster.uname}></td>\r\n    <td class="even" align="right"><{$reply.date_posted}></td>\r\n  </tr>\r\n  <{/foreach}>\r\n</table>\r\n<!-- end comment tree -->\r\n<{/if}>\r\n\r\n<{/section}>'),
(10, '<{section name=i loop=$comments}>\r\n<br />\r\n<table cellspacing="1" class="outer">\r\n  <tr>\r\n    <th width="20%"><{$lang_poster}></th>\r\n    <th><{$lang_thread}></th>\r\n  </tr>\r\n  <{include file="db:system_comment.html" comment=$comments[i]}>\r\n</table>\r\n\r\n<!-- start comment replies -->\r\n<{foreach item=reply from=$comments[i].replies}>\r\n<br />\r\n<table cellspacing="0" border="0">\r\n  <tr>\r\n    <td width="<{$reply.prefix}>"></td>\r\n    <td>\r\n      <table class="outer" cellspacing="1">\r\n        <tr>\r\n          <th width="20%"><{$lang_poster}></th>\r\n          <th><{$lang_thread}></th>\r\n        </tr>\r\n        <{include file="db:system_comment.html" comment=$reply}>\r\n      </table>\r\n    </td>\r\n  </tr>\r\n</table>\r\n<{/foreach}>\r\n<!-- end comment tree -->\r\n<{/section}>'),
(11, '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">\r\n<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<{$xoops_langcode}>" lang="<{$xoops_langcode}>">\r\n<head>\r\n	<meta http-equiv="content-type" content="text/html; charset=<{$xoops_charset}>" />\r\n	<meta http-equiv="content-language" content="<{$xoops_langcode}>" />\r\n	<title><{$xoops_sitename}></title>\r\n	<meta name="robots" content="<{$xoops_meta_robots}>" />\r\n	<meta name="keywords" content="<{$xoops_meta_keywords}>" />\r\n	<meta name="description" content="<{$xoops_meta_description}>" />\r\n	<meta name="rating" content="<{$xoops_meta_rating}>" />\r\n	<meta name="author" content="<{$xoops_meta_author}>" />\r\n	<meta name="copyright" content="<{$xoops_meta_copyright}>" />\r\n	<meta name="generator" content="XOOPS" />\r\n	\r\n	<link rel="stylesheet" type="text/css" media="all" href="<{$xoops_url}>/xoops.css" />\r\n	<link rel="shortcut icon" type="image/ico" href="<{xoAppUrl favicon.ico}>" />\r\n	\r\n</head>\r\n<body>\r\n  <table cellspacing="0">\r\n    <tr id="header">\r\n      <td style="width: 150px; background-color: #2F5376; vertical-align: middle; text-align:center;"><a href="<{$xoops_url}>/" title=""><img src="<{$xoops_imageurl}>logo.gif" width="150" alt="" /></a></td>\r\n      <td style="width: 100%; background-color: #2F5376; vertical-align: middle; text-align:center;">&nbsp;</td>\r\n    </tr>\r\n    <tr>\r\n      <td style="height: 8px; border-bottom: 1px solid silver; background-color: #dddddd;" colspan="2">&nbsp;</td>\r\n    </tr>\r\n  </table>\r\n\r\n  <table cellspacing="1" align="center" width="80%" border="0" cellpadding="10">\r\n    <tr>\r\n      <td align="center"><div style="background-color: #DDFFDF; color: #136C99; text-align: center; border-top: 1px solid #DDDDFF; border-left: 1px solid #DDDDFF; border-right: 1px solid #AAAAAA; border-bottom: 1px solid #AAAAAA; font-weight: bold; padding: 10px;"><{$lang_siteclosemsg}></div></td>\r\n    </tr>\r\n  </table>\r\n  \r\n  <form action="<{$xoops_url}>/user.php" method="post">\r\n    <table cellspacing="0" align="center" style="border: 1px solid silver; width: 200px;">\r\n      <tr>\r\n        <th style="background-color: #2F5376; color: #FFFFFF; padding : 2px; vertical-align : middle;" colspan="2"><{$lang_login}></th>\r\n      </tr>\r\n      <tr>\r\n        <td style="padding: 2px;"><{$lang_username}></td><td style="padding: 2px;"><input type="text" name="uname" size="12" value="" /></td>\r\n      </tr>\r\n      <tr>\r\n        <td style="padding: 2px;"><{$lang_password}></td><td style="padding: 2px;"><input type="password" name="pass" size="12" /></td>\r\n      </tr>\r\n      <tr>\r\n        <td style="padding: 2px;">&nbsp;</td>\r\n        <td style="padding: 2px;">\r\n        	<input type="hidden" name="xoops_redirect" value="<{$xoops_requesturi}>" />\r\n        	<input type="hidden" name="xoops_login" value="1" />\r\n        	<input type="submit" value="<{$lang_login}>" /></td>\r\n      </tr>\r\n    </table>\r\n  </form>\r\n\r\n  <table cellspacing="0" width="100%">\r\n    <tr>\r\n      <td style="height:8px; border-bottom: 1px solid silver; border-top: 1px solid silver; background-color: #dddddd;" colspan="2">&nbsp;</td>\r\n    </tr>\r\n  </table>\r\n\r\n  </body>\r\n</html>'),
(12, '<{$dummy_content}>'),
(13, '<h4><{$lang_activenotifications}></h4>\r\n<form name="notificationlist" action="notifications.php" method="post">\r\n<table class="outer">\r\n  <tr>\r\n	<th><input name="allbox" id="allbox" onclick="xoopsCheckAll(''notificationlist'', ''allbox'');" type="checkbox" value="<{$lang_checkall}>" /></th>\r\n    <th><{$lang_event}></th>\r\n    <th><{$lang_category}></th>\r\n    <th><{$lang_itemid}></th>\r\n    <th><{$lang_itemname}></th>\r\n  </tr>\r\n  <{foreach item=module from=$modules}>\r\n  <tr>\r\n    <td class="head"><input name="del_mod[<{$module.id}>]" id="del_mod[]" onclick="xoopsCheckGroup(''notificationlist'', ''del_mod[<{$module.id}>]'', ''del_not[<{$module.id}>][]'');" type="checkbox" value="<{$module.id}>" /></td>\r\n    <td class="head" colspan="4"><{$lang_module}>: <{$module.name}></td>\r\n  </tr>\r\n  <{foreach item=category from=$module.categories}>\r\n  <{foreach item=item from=$category.items}>\r\n  <{foreach item=notification from=$item.notifications}>\r\n  <tr>\r\n    <{cycle values=odd,even assign=class}>\r\n    <td class="<{$class}>"><input type="checkbox" name="del_not[<{$module.id}>][]" id="del_not[<{$module.id}>]" value="<{$notification.id}>" /></td>\r\n    <td class="<{$class}>"><{$notification.event_title}></td>\r\n    <td class="<{$class}>"><{$notification.category_title}></td>\r\n    <td class="<{$class}>"><{if $item.id != 0}><{$item.id}><{/if}></td>\r\n    <td class="<{$class}>"><{if $item.id != 0}><{if $item.url != ''''}><a href="<{$item.url}>" title="<{$item.name}>"><{/if}><{$item.name}><{if $item.url != ''''}></a><{/if}><{/if}></td>\r\n  </tr>\r\n  <{/foreach}>\r\n  <{/foreach}>\r\n  <{/foreach}>\r\n  <{/foreach}>\r\n  <tr>\r\n    <td class="foot" colspan="5">\r\n      <input type="submit" name="delete_cancel" value="<{$lang_cancel}>" />\r\n      <input type="reset" name="delete_reset" value="<{$lang_clear}>" />\r\n      <input type="submit" name="delete" value="<{$lang_delete}>" />\r\n      <input type="hidden" name="XOOPS_TOKEN_REQUEST" value="<{$notification_token}>" />\r\n    </td>\r\n  </tr>\r\n</table>\r\n</form>\r\n'),
(14, '<{if $xoops_notification.show}>\r\n<form name="notification_select" action="<{$xoops_notification.target_page}>" method="post">\r\n<h4 style="text-align:center;"><{$lang_activenotifications}></h4>\r\n<input type="hidden" name="not_redirect" value="<{$xoops_notification.redirect_script}>" />\r\n<input type="hidden" name="XOOPS_TOKEN_REQUEST" value="<{php}>echo $GLOBALS[''xoopsSecurity'']->createToken();<{/php}>" />\r\n<table class="outer">\r\n  <tr><th colspan="3"><{$lang_notificationoptions}></th></tr>\r\n  <tr>\r\n    <td class="head"><{$lang_category}></td>\r\n    <td class="head"><input name="allbox" id="allbox" onclick="xoopsCheckAll(''notification_select'',''allbox'');" type="checkbox" value="<{$lang_checkall}>" /></td>\r\n    <td class="head"><{$lang_events}></td>\r\n  </tr>\r\n  <{foreach name=outer item=category from=$xoops_notification.categories}>\r\n  <{foreach name=inner item=event from=$category.events}>\r\n  <tr>\r\n    <{if $smarty.foreach.inner.first}>\r\n    <td class="even" rowspan="<{$smarty.foreach.inner.total}>"><{$category.title}></td>\r\n    <{/if}>\r\n    <td class="odd">\r\n    <{counter assign=index}>\r\n    <input type="hidden" name="not_list[<{$index}>][params]" value="<{$category.name}>,<{$category.itemid}>,<{$event.name}>" />\r\n    <input type="checkbox" id="not_list[]" name="not_list[<{$index}>][status]" value="1" <{if $event.subscribed}>checked="checked"<{/if}> />\r\n    </td>\r\n    <td class="odd"><{$event.caption}></td>\r\n  </tr>\r\n  <{/foreach}>\r\n  <{/foreach}>\r\n  <tr>\r\n    <td class="foot" colspan="3" align="center"><input type="submit" name="not_submit" value="<{$lang_updatenow}>" /></td>\r\n  </tr>\r\n</table>\r\n<div align="center">\r\n<{$lang_notificationmethodis}>:&nbsp;<{$user_method}>&nbsp;&nbsp;[<a href="<{$editprofile_url}>" title="<{$lang_change}>"><{$lang_change}></a>]\r\n</div>\r\n</form>\r\n<{/if}>'),
(15, '<{$block.content}>'),
(16, '\n'),
(17, '<div id="login_window">\n<h2 class=''content_title''><{$smarty.const._BANNERS_LOGIN_TITLE}></h2>\n<form method=''post'' action=''banners.php'' class=''login_form''>\n <div class=''credentials''>\n  <label for=''login_form-login''><{$smarty.const._BANNERS_LOGIN_LOGIN}></label>\n  <input type=''text'' name=''login'' id=''login_form-login'' value='''' /><br />\n  <label for=''login_form-password''><{$smarty.const._BANNERS_LOGIN_PASS}></label>\n  <input type=''password'' name=''pass'' id=''login_form-password'' value='''' /><br />\n </div>\n <div class=''actions''>\n 	<input type=''hidden'' name=''op'' value=''list'' />\n	<button type=''submit''><{$smarty.const._BANNERS_LOGIN_OK}></button></div>\n <div class=''login_info''><{$smarty.const._BANNERS_LOGIN_INFO}></div>\n <{$TOKEN}>\n</form>\n</div>'),
(18, '<h1><{$smarty.const._BANNERS_MANAGEMENT}></h1>\n<h5><{$welcomeuser}></h5>\n<div style="text-align: center;"><a href="banners.php?op=logout" title="<{$smarty.const._BANNERS_LOGOUT}>"><{$smarty.const._BANNERS_LOGOUT}></a></div>\n<h4 class="content_title"><{$smarty.const._BANNERS_TITLE}></h4>\n<table cellpadding="2" cellspacing="1" summary="" class="outer">\n	<tr style="text-align: center;">\n		<th><{$smarty.const._BANNERS_NO}></th>\n		<th><{$smarty.const._BANNERS_IMP_MADE}></th>\n		<th><{$smarty.const._BANNERS_IMP_TOTAL}></th>\n		<th><{$smarty.const._BANNERS_IMP_LEFT}></th>\n		<th><{$smarty.const._BANNERS_CLICKS}></th>\n		<th><{$smarty.const._BANNERS_PER_CLICKS}></th>\n		<th><{$smarty.const._BANNERS_FUNCTIONS}></th>\n	</tr>\n	<{if $bcount}>\n		<{foreach item=banner from=$banners}>\n			<tr style=''text-align: center;'' class=''even''>\n				<td><{$banner.bid}></td>\n			    <td><{$banner.impmade}></td>\n			    <td><{$banner.imptotal}></td>\n			    <td><{$banner.left}></td>\n			    <td><{$banner.clicks}></td>\n			    <td><{$banner.percent}>%</td>\n			    <td>\n					<a href="banners.php?op=banner_email&amp;cid=<{$banner.cid}>&amp;bid=<{$banner.bid}>" title="<{$smarty.const._BANNERS_STATS}>"><{$smarty.const._BANNERS_STATS}></a>\n			        <a href="banners.php?op=banner_display&amp;cid=<{$banner.cid}>" title="<{$banner.bid}>"><{$smarty.const._BANNERS_SHOWBANNER}></a>\n				</td>\n			</tr>\n		<{/foreach}>\n	<{else}>\n		<tr>\n			<td class=''even'' style=''text-align: center;'' colspan=''7''><{$smarty.const._BANNERS_NOTHINGFOUND}></td>\n		</tr>\n	<{/if}>\n	<tr>\n		<td class="head" colspan="7">&nbsp;</td>\n	</tr>\n</table><br /><br />\n\n<h4 class=''content_title''><{$smarty.const._BANNERS_FINISHED}></h4>\n\n<table cellpadding=''2'' cellspacing=''1'' summary='''' class = ''outer''>\n	<tr style=''text-align: center;''>\n		<th><{$smarty.const._BANNERS_NO}></th>\n		<th><{$smarty.const._BANNERS_IMP_MADE}></th>\n		<th><{$smarty.const._BANNERS_CLICKS}></th>\n		<th><{$smarty.const._BANNERS_PER_CLICKS}></th>\n		<th><{$smarty.const._BANNERS_STARTED}></th>\n		<th><{$smarty.const._BANNERS_ENDED}></th>\n	</tr>\n	<{if $bcount}>\n		<{foreach item=ebanner from=$ebanners}>\n			<tr style=''text-align: center;'' class=''even''>\n				<td><{$ebanner.bid}></td>\n			    <td><{$ebanner.impressions}></td>\n			    <td><{$ebanner.clicks}></td>\n			    <td><{$ebanner.percent}></td>\n			    <td><{$ebanner.datestart}></td>\n			    <td><{$ebanner.dateend}>%</td>\n			</tr>\n		<{/foreach}>\n	<{else}>\n		<tr>\n			<td class=''even'' style=''text-align: center;'' colspan=''7''><{$smarty.const._BANNERS_NOTHINGFOUND}></td>\n		</tr>\n	<{/if}>\n	<tr>\n		<td class=''head'' colspan=''7''>&nbsp;</td>\n	</tr>\n</table><br />'),
(19, '<h1><{$smarty.const._BANNERS_MANAGEMENT}></h1>\n<h5><{$welcomeuser}></h5>\n<div style="text-align: center;"><a href="banners.php?op=logout" title="<{$smarty.const._BANNERS_LOGOUT}>"><{$smarty.const._BANNERS_LOGOUT}></a></div>\n<div style="text-align: center;"><a href="banners.php?op=list" title="<{$smarty.const._BANNERS_BACK}>"><{$smarty.const._BANNERS_BACK}></a></div>\n<div><{$banneractive}></div><br />\n<{if $count}>\n	<{foreach item=banner from=$banners}>\n		<form action="banners.php" method="post">\n			<table width="100%" cellspacing="1" class="outer">\n				<th colspan="2"><{$smarty.const._BANNERS_ID}> <{$banner.bid}></th>\n				<tr>\n					<td width="50%" class="head">\n					<div><{$banner.sendstats}></div>\n					<div><{$banner.bannerpoints}></div>\n					<{if !$banner.htmlbanner}>\n					<div></div>\n					<div><{$smarty.const._BANNERS_URL}>\n						<input type="text" name="url" size="50" maxlength="200" value="<{$banner.clickurl}>" />\n						<input type="hidden" name="bid" value="<{$banner.bid}>" />\n						<input type="hidden" name="cid" value="<{$banner.cid}>" />\n						<input type="submit" name="op" value="save" />\n						<{$TOKEN}>\n					</div>\n					<{/if}>\n					</td>\n					<td class="even" style="text-align: center;" ><{$banner.banner_url}></td>\n				</tr>\n				<tr>\n					<td class=''head'' colspan=''2''>&nbsp;</td>\n				</tr>\n			</table><br />\n		</form>\n	<{/foreach}>\n<{/if}>'),
(20, '<table cellspacing="0">\r\n  <tr>\r\n    <td id="usermenu">\r\n      <{if $xoops_isadmin}>\r\n        <a class="menuTop" href="<{$xoops_url}>/admin.php" title="<{$block.lang_adminmenu}>"><{$block.lang_adminmenu}></a>\r\n	    <a href="<{$xoops_url}>/user.php" title="<{$block.lang_youraccount}>"><{$block.lang_youraccount}></a>\r\n      <{else}>\r\n		<a class="menuTop" href="<{$xoops_url}>/user.php" title="<{$block.lang_youraccount}>"><{$block.lang_youraccount}></a>\r\n      <{/if}>\r\n      <a href="<{$xoops_url}>/edituser.php" title="<{$block.lang_editaccount}>"><{$block.lang_editaccount}></a>\r\n      <a href="<{$xoops_url}>/notifications.php" title="<{$block.lang_notifications}>"><{$block.lang_notifications}></a>\r\n      <{if $block.new_messages > 0}>\r\n        <a class="highlight" href="<{$xoops_url}>/viewpmsg.php" title="<{$block.lang_inbox}>"><{$block.lang_inbox}> (<span style="color:#ff0000; font-weight: bold;"><{$block.new_messages}></span>)</a>\r\n      <{else}>\r\n        <a href="<{$xoops_url}>/viewpmsg.php" title="<{$block.lang_inbox}>"><{$block.lang_inbox}></a>\r\n      <{/if}>\r\n      <a href="<{$xoops_url}>/user.php?op=logout" title="<{$block.lang_logout}>"><{$block.lang_logout}></a>\r\n    </td>\r\n  </tr>\r\n</table>\r\n'),
(21, '<form style="margin-top: 0px;" action="<{$xoops_url}>/user.php" method="post">\r\n    <{$block.lang_username}><br />\r\n    <input type="text" name="uname" size="12" value="<{$block.unamevalue}>" maxlength="25" /><br />\r\n    <{$block.lang_password}><br />\r\n    <input type="password" name="pass" size="12" maxlength="32" /><br />\r\n    <{if isset($block.lang_rememberme)}>\r\n        <input type="checkbox" name="rememberme" value="On" class ="formButton" /><{$block.lang_rememberme}><br />\r\n    <{/if}>\r\n    <br />\r\n    <input type="hidden" name="xoops_redirect" value="<{$xoops_requesturi}>" />\r\n    <input type="hidden" name="op" value="login" />\r\n    <input type="submit" value="<{$block.lang_login}>" /><br />\r\n    <{$block.sslloginlink}>\r\n</form>\r\n<br />\r\n<a href="<{$xoops_url}>/user.php#lost" title="<{$block.lang_lostpass}>"><{$block.lang_lostpass}></a>\r\n<br /><br />\r\n<a href="<{$xoops_url}>/register.php" title="<{$block.lang_registernow}>"><{$block.lang_registernow}></a>'),
(22, '<form style="margin-top: 0px;" action="<{$xoops_url}>/search.php" method="get">\r\n  <input type="text" name="query" size="14" /><input type="hidden" name="action" value="results" /><br /><input type="submit" value="<{$block.lang_search}>" />\r\n</form>\r\n<a href="<{$xoops_url}>/search.php" title="<{$block.lang_advsearch}>"><{$block.lang_advsearch}></a>'),
(23, '<ul>\r\n  <{foreach item=module from=$block.modules}>\r\n  <li><a href="<{$module.adminlink}>" title="<{$module.lang_linkname}>"><{$module.lang_linkname}></a>: <{$module.pendingnum}></li>\r\n  <{/foreach}>\r\n</ul>'),
(24, '<table cellspacing="0">\r\n  <tr>\r\n    <td id="mainmenu">\r\n      <a class="menuTop" href="<{$xoops_url}>/"><{$block.lang_home}></a>\r\n      <!-- start module menu loop -->\r\n      <{foreach item=module from=$block.modules}>\r\n      <a class="menuMain" href="<{$xoops_url}>/modules/<{$module.directory}>/" title="<{$module.name}>"><{$module.name}></a>\r\n        <{foreach item=sublink from=$module.sublinks}>\r\n          <a class="menuSub" href="<{$sublink.url}>" title="<{$sublink.name}>"><{$sublink.name}></a>\r\n        <{/foreach}>\r\n      <{/foreach}>\r\n      <!-- end module menu loop -->\r\n    </td>\r\n  </tr>\r\n</table>'),
(25, '<table class="outer" cellspacing="0">\r\n\r\n  <{if $block.showgroups == true}>\r\n\r\n  <!-- start group loop -->\r\n  <{foreach item=group from=$block.groups}>\r\n  <tr>\r\n    <th colspan="2"><{$group.name}></th>\r\n  </tr>\r\n\r\n  <!-- start group member loop -->\r\n  <{foreach item=user from=$group.users}>\r\n  <tr>\r\n    <td class="even" valign="middle" align="center">\r\n        <img src="<{$user.avatar}>" alt="<{$user.name}>" width="32" /><br />\r\n        <a href="<{$xoops_url}>/userinfo.php?uid=<{$user.id}>" title="<{$user.name}>"><{$user.name}></a>\r\n    </td>\r\n    <td class="odd" width="20%" align="right" valign="middle">\r\n        <{$user.msglink}>\r\n    </td>\r\n  </tr>\r\n  <{/foreach}>\r\n  <!-- end group member loop -->\r\n\r\n  <{/foreach}>\r\n  <!-- end group loop -->\r\n  <{/if}>\r\n</table>\r\n\r\n<br />\r\n\r\n<div style="margin: 3px; text-align:center;">\r\n  <img src="<{$block.logourl}>" alt="" border="0" /><br /><{$block.recommendlink}>\r\n</div>'),
(26, '<{$block.online_total}><br /><br />\r\n<{$block.lang_members}>: <{$block.online_members}><br />\r\n<{$block.lang_guests}>: <{$block.online_guests}><br /><br />\r\n<{$block.online_names}>\r\n<a href="javascript:openWithSelfMain(''<{$xoops_url}>/misc.php?action=showpopups&amp;type=online'',''Online'',420,350);" title="<{$block.lang_more}>">\r\n    <{$block.lang_more}>\r\n</a>'),
(27, '<table cellspacing="1" class="outer">\r\n  <{foreach item=user from=$block.users}>\r\n  <tr class="<{cycle values="even,odd"}>" valign="middle">\r\n    <td><{$user.rank}></td>\r\n    <td align="center">\r\n      <{if $user.avatar != ""}>\r\n      <img src="<{$user.avatar}>" alt="<{$user.name}>" width="32" /><br />\r\n      <{/if}>\r\n      <a href="<{$xoops_url}>/userinfo.php?uid=<{$user.id}>" title="<{$user.name}>"><{$user.name}></a>\r\n    </td>\r\n    <td align="center"><{$user.posts}></td>\r\n  </tr>\r\n  <{/foreach}>\r\n</table>\r\n'),
(28, '<table cellspacing="1" class="outer">\r\n  <{foreach item=user from=$block.users}>\r\n    <tr class="<{cycle values="even,odd"}>" valign="middle">\r\n      <td align="center">\r\n      <{if $user.avatar != ""}>\r\n      <img src="<{$user.avatar}>" alt="<{$user.name}>" width="32" /><br />\r\n      <{/if}>\r\n      <a href="<{$xoops_url}>/userinfo.php?uid=<{$user.id}>" title="<{$user.name}>"><{$user.name}></a>\r\n      </td>\r\n      <td align="center"><{$user.joindate}></td>\r\n    </tr>\r\n  <{/foreach}>\r\n</table>\r\n'),
(29, '<table width="100%" cellspacing="1" class="outer">\r\n  <{foreach item=comment from=$block.comments}>\r\n  <tr class="<{cycle values="even,odd"}>">\r\n    <td align="center"><img src="<{$xoops_url}>/images/subject/<{$comment.icon}>" alt="" /></td>\r\n    <td><{$comment.title}></td>\r\n    <td align="center"><{$comment.module}></td>\r\n    <td align="center"><{$comment.poster}></td>\r\n    <td align="right"><{$comment.time}></td>\r\n  </tr>\r\n  <{/foreach}>\r\n</table>'),
(30, '<form action="<{$block.target_page}>" method="post">\r\n<table class="outer">\r\n  <{foreach item=category from=$block.categories}>\r\n  <{foreach name=inner item=event from=$category.events}>\r\n  <{if $smarty.foreach.inner.first}>\r\n  <tr>\r\n    <td class="head" colspan="2"><{$category.title}></td>\r\n  </tr>\r\n  <{/if}>\r\n  <tr>\r\n    <td class="odd"><{counter assign=index}><input type="hidden" name="not_list[<{$index}>][params]" value="<{$category.name}>,<{$category.itemid}>,<{$event.name}>" /><input type="checkbox" name="not_list[<{$index}>][status]" value="1" <{if $event.subscribed}>checked="checked"<{/if}> /></td>\r\n    <td class="odd"><{$event.caption}></td>\r\n  </tr>\r\n  <{/foreach}>\r\n  <{/foreach}>\r\n  <tr>\r\n    <td class="foot" colspan="2"><input type="hidden" name="not_redirect" value="<{$block.redirect_script}>"><input type="hidden" value="<{$block.notification_token}>" name="XOOPS_TOKEN_REQUEST" /><input type="submit" name="not_submit" value="<{$block.submit_button}>" /></td>\r\n  </tr>\r\n</table>\r\n</form>'),
(31, '<div style="text-align: center;">\r\n<form action="index.php" method="post">\r\n<{$block.theme_select}>\r\n</form>\r\n</div>'),
(32, '<{$pmform.javascript}>\r\n<form name="<{$pmform.name}>" id="<{$pmform.name}>" action="<{$pmform.action}>" method="<{$pmform.method}>" <{$pmform.extra}> >\r\n    <table width=''300'' align=''center'' class=''outer''>\r\n        <tr>\r\n            <td class=''head'' width=''30%''><{$smarty.const._PM_TO}></td>\r\n            <td class=''even''><{if $pmform.elements.to_userid.hidden != 1}><{$pmform.elements.to_userid.body}><{/if}><{$to_username}></td>\r\n        </tr>\r\n        <tr>\r\n            <td class=''head'' width=''30%''><{$smarty.const._PM_SUBJECTC}></td>\r\n            <td class=''even''><{$pmform.elements.subject.body}></td>\r\n        </tr>\r\n        <tr valign=''top''>\r\n            <td class=''head'' width=''30%''><{$smarty.const._PM_MESSAGEC}></td>\r\n            <td class=''even''><{$pmform.elements.message.body}></td>\r\n        </tr>\r\n        <tr valign=''top''>\r\n            <td class=''head'' width=''30%''><{$smarty.const._PM_SAVEINOUTBOX}></td>\r\n            <td class=''even''><{$pmform.elements.savecopy.body}></td>\r\n        </tr>\r\n        <tr>\r\n            <td class=''head''>&nbsp;</td>\r\n            <td class=''even''>\r\n                <{foreach item=element from=$pmform.elements}>\r\n                    <{if $element.hidden == 1}>\r\n                        <{$element.body}>\r\n                    <{/if}>\r\n                <{/foreach}>\r\n                <{$pmform.elements.submit.body}>&nbsp;\r\n                <{$pmform.elements.reset.body}>&nbsp;\r\n                <{$pmform.elements.cancel.body}>\r\n            </td>\r\n        </tr>\r\n    </table>\r\n</form>'),
(33, '<div>\r\n    <h4><{$smarty.const._PM_PRIVATEMESSAGE}></h4>\r\n</div><br />\r\n<{if $op==out}>\r\n    <a href=''viewpmsg.php?op=out''><{$smarty.const._PM_OUTBOX}></a>&nbsp;\r\n<{elseif $op == "save"}>\r\n    <a href=''viewpmsg.php?op=save''><{$smarty.const._PM_SAVEBOX}></a>&nbsp;\r\n<{else}>\r\n    <a href=''viewpmsg.php?op=in''><{$smarty.const._PM_INBOX}></a>&nbsp;\r\n<{/if}>\r\n\r\n<{if $message}>\r\n    <span style=''font-weight:bold;''>&raquo;&raquo;</span>&nbsp;<{$message.subject}><br />\r\n    <form name="<{$pmform.name}>" id="<{$pmform.name}>" action="<{$pmform.action}>" method="<{$pmform.method}>" <{$pmform.extra}> >\r\n        <table border=''0'' cellpadding=''4'' cellspacing=''1'' class=''outer'' width=''100%''>\r\n            <tr>\r\n                <th colspan=''2''><{if $op==out}><{$smarty.const._PM_TO}><{else}><{$smarty.const._PM_FROM}><{/if}></th>\r\n            </tr>\r\n            <tr class=''even''>\r\n                <td valign=''top''>\r\n                    <{if ( $poster != false ) }>\r\n                        <a href=''<{$xoops_url}>/userinfo.php?uid=<{$poster->getVar("uid")}>''><{$poster->getVar("uname")}></a><br />\r\n                        <{if ( $poster->getVar("user_avatar") != "" ) }>\r\n                            <img src=''<{$xoops_url}>/uploads/<{$poster->getVar("user_avatar")}>'' alt='''' /><br />\r\n                        <{/if}>\r\n                        <{if ( $poster->getVar("user_from") != "" ) }>\r\n                            <{$smarty.const._PM_FROMC}><{$poster->getVar("user_from")}><br /><br />\r\n                        <{/if}>\r\n                        <{if ( $poster->isOnline() ) }>\r\n                            <span style=''color:#ee0000;font-weight:bold;''><{$smarty.const._PM_ONLINE}></span><br /><br />\r\n                        <{/if}>\r\n                    <{else}>\r\n                        <{$anonymous}>\r\n                    <{/if}>\r\n                </td>\r\n                <td>\r\n                    <!-- \r\n                    <img src=''<{$xoops_url}>/images/subject/<{$message.msg_image}>'' alt='''' />&nbsp;\r\n                    -->\r\n                    <{$smarty.const._PM_SENTC}><{$message.msg_time}>\r\n                    <hr />\r\n                    <b><{$message.subject}></b><br />\r\n                    <br />\r\n                    <{$message.msg_text}><br />\r\n                    <br />\r\n                </td>\r\n            </tr>\r\n            <tr class=''foot''>\r\n                <td width=''20%'' colspan=''2'' align=''left''>\r\n                    <{foreach item=element from=$pmform.elements}>\r\n                        <{$element.body}>\r\n                    <{/foreach}>\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <td colspan=''2'' align=''right''>\r\n                    <{if ( $previous >= 0 ) }>\r\n                        <a href=''readpmsg.php?start=<{$previous}>&amp;total_messages=<{$total_messages}>&amp;op=<{$op}>''>\r\n                            <{$smarty.const._PM_PREVIOUS}>\r\n                        </a>&nbsp|&nbsp;\r\n                    <{else}>\r\n                        <{$smarty.const._PM_PREVIOUS}>&nbsp;|&nbsp;\r\n                    <{/if}>\r\n                    <{if ( $next < $total_messages ) }>\r\n                        <a href=''readpmsg.php?start=<{$next}>&amp;total_messages=<{$total_messages}>&amp;op=<{$op}>''>\r\n                            <{$smarty.const._PM_NEXT}>\r\n                        </a>\r\n                    <{else}>\r\n                        <{$smarty.const._PM_NEXT}>\r\n                    <{/if}>\r\n                </td>\r\n            </tr>\r\n        </table>\r\n    </form>\r\n<{else}>\r\n    <br /><br /><{$smarty.const._PM_YOUDONTHAVE}>\r\n<{/if}>');
INSERT INTO `sim_tplsource` (`tpl_id`, `tpl_source`) VALUES
(35, '<h4 style=''text-align:center;''><{$smarty.const._PM_PRIVATEMESSAGE}></h4><br />\r\n<div style="float:right; width: 18%; text-align: right;">\r\n    <{if $op == "out"}>\r\n        <a href=''viewpmsg.php?op=in''><{$smarty.const._PM_INBOX}></a> | <a href=''viewpmsg.php?op=save''><{$smarty.const._PM_SAVEBOX}></a>\r\n    <{elseif $op == "save"}>\r\n        <a href=''viewpmsg.php?op=in''><{$smarty.const._PM_INBOX}></a> | <a href=''viewpmsg.php?op=out''><{$smarty.const._PM_OUTBOX}></a>\r\n    <{elseif $op == "in"}>\r\n        <a href=''viewpmsg.php?op=out''><{$smarty.const._PM_OUTBOX}></a> | <a href=''viewpmsg.php?op=save''><{$smarty.const._PM_SAVEBOX}></a>\r\n    <{/if}>\r\n</div>\r\n<div style="float:left; width: 80%;">\r\n    <{if $op == "out"}><{$smarty.const._PM_OUTBOX}>\r\n    <{elseif $op == "save"}><{$smarty.const._PM_SAVEBOX}>\r\n    <{else}><{$smarty.const._PM_INBOX}><{/if}>\r\n</div>\r\n<br />\r\n<br />\r\n<{if $msg}>\r\n    <div class="confirmMsg"><{$msg}></div>\r\n<{/if}>\r\n<{if $errormsg}>\r\n    <div class="errorMsg"><{$errormsg}></div>\r\n<{/if}>\r\n\r\n<{if $pagenav}>\r\n    <div style="padding: 5px; float: right; text-align:right;">\r\n    <{$pagenav}>\r\n    </div>\r\n    <br style="clear: both;" />\r\n<{/if}>\r\n\r\n<form name="<{$pmform.name}>" id="<{$pmform.name}>" action="<{$pmform.action}>" method="<{$pmform.method}>" <{$pmform.extra}> >\r\n    <table border=''0'' cellspacing=''1'' cellpadding=''4'' width=''100%'' class=''outer''>\r\n    \r\n        <tr align=''center'' valign=''middle''>\r\n            <th><input name=''allbox'' id=''allbox'' onclick=''xoopsCheckAll("<{$pmform.name}>", "allbox");'' type=''checkbox'' value=''Check All'' /></th>\r\n            <th><img src=''<{$xoops_url}>/images/download.gif'' alt='''' border=''0'' /></th>\r\n            <th>&nbsp;</th>\r\n            <{if $op == "out"}>\r\n                <th><{$smarty.const._PM_TO}></th>\r\n            <{else}>\r\n                <th><{$smarty.const._PM_FROM}></th>\r\n            <{/if}>\r\n            <th><{$smarty.const._PM_SUBJECT}></th>\r\n            <th align=''center''><{$smarty.const._PM_DATE}></th>\r\n        </tr>\r\n        \r\n        <{if $total_messages == 0}>\r\n            <tr>\r\n                <td class=''even'' colspan=''6'' align=''center''><{$smarty.const._PM_YOUDONTHAVE}></td>\r\n            </tr>\r\n        <{/if}>\r\n        <{foreach item=message from=$messages}>\r\n            <tr align=''left'' class=''<{cycle values="odd, even"}>''>\r\n                <td valign=''top'' width=''2%'' align=''center''>\r\n                    <input type=''checkbox'' id=''msg_id_<{$message.msg_id}>'' name=''msg_id[]'' value=''<{$message.msg_id}>'' />\r\n                </td>\r\n                <{if $message.read_msg == 1}>\r\n                    <td valign=''top'' width=''5%'' align=''center''>&nbsp;</td>\r\n                <{else}>\r\n                    <td valign=''top'' width=''5%'' align=''center''><img src=''images/read.gif'' alt=''<{$smarty.const._PM_NOTREAD}>'' /></td>\r\n                <{/if}>\r\n                <td valign=''top'' width=''5%'' align=''center''>\r\n                    <{if $message.msg_image != ""}>\r\n                        <img src=''<{$xoops_url}>/images/subject/<{$message.msg_image}>'' alt='''' />\r\n                    <{/if}>\r\n                </td>\r\n                <td valign=''middle'' width=''10%''>\r\n                    <{if $message.postername != ""}>\r\n                        <a href=''<{$xoops_url}>/userinfo.php?uid=<{$message.posteruid}>''><{$message.postername}></a>\r\n                    <{else}>\r\n                        <{$anonymous}>\r\n                    <{/if}>\r\n                </td>\r\n                <td valign=''middle''>\r\n                    <a href=''readpmsg.php?msg_id=<{$message.msg_id}>&amp;start=<{$message.msg_no}>&amp;total_messages=<{$total_messages}>&amp;op=<{$op}>''>\r\n                        <{$message.subject}>\r\n                    </a>\r\n                </td>\r\n                <td valign=''middle'' align=''center'' width=''20%''>\r\n                    <{$message.msg_time}>\r\n                </td>\r\n            </tr>\r\n        <{/foreach}>\r\n        <tr class=''bg2'' align=''left''>\r\n            <td colspan=''6'' align=''left''>\r\n                <{$pmform.elements.send.body}>\r\n                <{if $display}>\r\n                    &nbsp;<{$pmform.elements.move_messages.body}>\r\n                    &nbsp;<{$pmform.elements.delete_messages.body}>\r\n                    &nbsp;<{$pmform.elements.empty_messages.body}>\r\n                <{/if}>\r\n                <{foreach item=element from=$pmform.elements}>\r\n                    <{if $element.hidden == 1}>\r\n                        <{$element.body}>\r\n                    <{/if}>\r\n                <{/foreach}>\r\n            </td>\r\n        </tr>\r\n    </table>\r\n</form>\r\n<{if $pagenav}>\r\n<div style="padding: 5px;float: right; text-align:right;">\r\n<{$pagenav}>\r\n</div>\r\n<{/if}>'),
(36, '<div class="breadcrumbs">\r\n    <{foreach item=itm from=$xoBreadcrumbs name=bcloop}>\r\n        <span class="item">\r\n        <{if $itm.link}>\r\n            <a href="<{$itm.link}>" title="<{$itm.title}>"><{$itm.title}></a>\r\n        <{else}>\r\n            <{$itm.title}>\r\n        <{/if}>\r\n        </span>\r\n        \r\n        <{if !$smarty.foreach.bcloop.last}>\r\n            <span class="delimiter">&raquo;</span>\r\n        <{/if}>\r\n    <{/foreach}>\r\n</div>\r\n<br style="clear: both;" />'),
(37, '<{$xoForm.javascript}>\r\n    <form id="<{$xoForm.name}>" name="<{$xoForm.name}>" action="<{$xoForm.action}>" method="<{$xoForm.method}>" <{$xoForm.extra}> >\r\n        <table class="profile-form" id="profile-form-<{$xoForm.name}>">\r\n            <{foreach item=element from=$xoForm.elements}>\r\n                <{if !$element.hidden}>\r\n                    <tr>\r\n                        <td class="head">\r\n				            <div class=''xoops-form-element-caption<{if $element.required}>-required<{/if}>''>\r\n				                <span class=''caption-text''><{$element.caption}></span>\r\n				                <span class=''caption-marker''>*</span>\r\n				            </div>\r\n                            <{if $element.description != ""}>\r\n                                <div class=''xoops-form-element-help''><{$element.description}></div>\r\n                            <{/if}>\r\n                        </td>\r\n                        <td class="<{cycle values=''odd, even''}>">\r\n                            <{$element.body}>\r\n                        </td>\r\n                    </tr>\r\n                <{/if}>\r\n            <{/foreach}>\r\n        </table>\r\n        <{foreach item=element from=$xoForm.elements}>\r\n            <{if $element.hidden}>\r\n                <{$element.body}>\r\n            <{/if}>\r\n        <{/foreach}>\r\n    </form>'),
(38, '<div><a href="field.php?op=new"><{$smarty.const._ADD}> <{$smarty.const._PROFILE_AM_FIELD}></a></div>\r\n<form action="field.php" method="post" id="fieldform">\r\n    <table>\r\n        <th><{$smarty.const._PROFILE_AM_NAME}></th>\r\n        <th><{$smarty.const._PROFILE_AM_TITLE}></th>\r\n        <th><{$smarty.const._PROFILE_AM_DESCRIPTION}></th>\r\n        <th><{$smarty.const._PROFILE_AM_TYPE}></th>\r\n        <th><{$smarty.const._PROFILE_AM_CATEGORY}></th>\r\n        <th><{$smarty.const._PROFILE_AM_WEIGHT}></th>\r\n        <th></th>\r\n        <{foreach item=category from=$fieldcategories}>\r\n            <{foreach item=field from=$category}>\r\n                <tr class="<{cycle values=''odd, even''}>">\r\n                    <td><{$field.field_name}></td>\r\n                    <td><{$field.field_title}></td>\r\n                    <td><{$field.field_description}></td>\r\n                    <td><{$field.fieldtype}></td>\r\n                    <td>\r\n                        <{if $field.canEdit}>\r\n                            <select name="category[<{$field.field_id}>]"><{html_options options=$categories selected=$field.cat_id}></select>\r\n                        <{/if}>\r\n                    </td>\r\n                    <td>\r\n                        <{if $field.canEdit}>\r\n                            <input type="text" name="weight[<{$field.field_id}>]" size="5" maxlength="5" value="<{$field.field_weight}>" />\r\n                        <{/if}>\r\n                    </td>\r\n                    <td>\r\n                        <{if $field.canEdit}>\r\n                            <input type="hidden" name="oldweight[<{$field.field_id}>]" value="<{$field.field_weight}>" />\r\n                            <input type="hidden" name="oldcat[<{$field.field_id}>]" value="<{$field.cat_id}>" />\r\n                            <input type="hidden" name="field_ids[]" value="<{$field.field_id}>" />\r\n                            <a href="field.php?id=<{$field.field_id}>" title="<{$smarty.const._EDIT}>"><{$smarty.const._EDIT}></a>\r\n                        <{/if}>\r\n                        <{if $field.canDelete}>\r\n                            &nbsp;<a href="field.php?op=delete&amp;id=<{$field.field_id}>" title="<{$smarty.const._DELETE}>"><{$smarty.const._DELETE}></a>\r\n                        <{/if}>\r\n                    </td>\r\n                </tr>\r\n            <{/foreach}>\r\n        <{/foreach}>\r\n        <tr class="<{cycle values=''odd, even''}>">\r\n            <td colspan="5">\r\n            </td>\r\n            <td>\r\n                <{$token}>\r\n                <input type="hidden" name="op" value="reorder" />\r\n                <input type="submit" name="submit" value="<{$smarty.const._SUBMIT}>" />\r\n            </td>\r\n            <td colspan="2">\r\n            </td>\r\n        </tr>\r\n    </table>\r\n</form>'),
(39, '<{includeq file="db:profile_breadcrumbs.html"}>\r\n\r\n<div>\r\n    <{if $avatar}>\r\n        <div style="float: left; padding: 5px;">\r\n            <img align="left" src="<{$avatar}>" alt="<{$uname}>" />\r\n        </div>\r\n    <{/if}>\r\n    <div style="float: left; display: block; padding: 10px;">\r\n        <strong><{$uname}></strong>\r\n        <{if $email}>\r\n            <{$email}> <br />\r\n        <{/if}>\r\n        <{if !$user_ownpage && $xoops_isuser == true}>\r\n        <form name="usernav" action="user.php" method="post">\r\n            <input type="button" value="<{$smarty.const._PROFILE_MA_SENDPM}>" onclick="javascript:openWithSelfMain(''<{$xoops_url}>/pmlite.php?send2=1&amp;to_userid=<{$user_uid}>'', ''pmlite'', 450, 380);" />\r\n        </form>\r\n        <{/if}>        \r\n    </div>\r\n</div>\r\n<br style="clear: both;" />\r\n\r\n<{if $user_ownpage == true}>\r\n<div style="float: left; padding: 5px;">\r\n    <form name="usernav" action="user.php" method="post">\r\n        <input type="button" value="<{$lang_editprofile}>" onclick="location=''<{$xoops_url}>/modules/<{$xoops_dirname}>/edituser.php''" />\r\n        <input type="button" value="<{$lang_changepassword}>" onclick="location=''<{$xoops_url}>/modules/<{$xoops_dirname}>/changepass.php''" />\r\n        <{if $user_changeemail}>\r\n            <input type="button" value="<{$smarty.const._PROFILE_MA_CHANGEMAIL}>" onclick="location=''<{$xoops_url}>/modules/<{$xoops_dirname}>/changemail.php''" />\r\n        <{/if}>\r\n\r\n        <{if $user_candelete == true}>\r\n            <form method="post" action="<{$xoops_url}>/modules/<{$xoops_dirname}>/user.php">\r\n                <input type="hidden" name="op" value="delete">\r\n                <input type="hidden" name="uid" value="<{$user_uid}>">\r\n                <input type="button" value="<{$lang_deleteaccount}>" onclick="submit();" />\r\n            </form>\r\n        <{/if}>\r\n\r\n        <input type="button" value="<{$lang_avatar}>" onclick="location=''edituser.php?op=avatarform''" />\r\n        <input type="button" value="<{$lang_inbox}>" onclick="location=''<{$xoops_url}>/viewpmsg.php''" />\r\n        <input type="button" value="<{$lang_logout}>" onclick="location=''<{$xoops_url}>/modules/<{$xoops_dirname}>/user.php?op=logout''" />\r\n    </form>\r\n</div>\r\n<{elseif $xoops_isadmin != false}>\r\n<div style="float: left; padding: 5px;">\r\n        <form method="post" action="<{$xoops_url}>/modules/<{$xoops_dirname}>/admin/deactivate.php">\r\n        <input type="button" value="<{$lang_editprofile}>" onclick="location=''<{$xoops_url}>/modules/<{$xoops_dirname}>/admin/user.php?op=edit&amp;id=<{$user_uid}>''" />\r\n        <input type="hidden" name="uid" value="<{$user_uid}>" />\r\n        <{if $userlevel == 1}>\r\n            <input type="hidden" name="level" value="0" />\r\n            <input type="button" value="<{$smarty.const._PROFILE_MA_DEACTIVATE}>" onclick="submit();" />\r\n        <{else}>\r\n            <input type="hidden" name="level" value="1" />\r\n            <input type="button" value="<{$smarty.const._PROFILE_MA_ACTIVATE}>" onclick="submit();" />\r\n        <{/if}>\r\n        </form>\r\n</div>\r\n<{/if}>\r\n\r\n<br style="clear: both;" />\r\n\r\n<{foreach item=category from=$categories}>\r\n    <{if isset($category.fields)}>\r\n        <div class="profile-list-category" id="profile-category-<{$category.cat_id}>">\r\n            <table class="outer" cellpadding="4" cellspacing="1">\r\n                <tr>\r\n                  <th colspan="2" align="center"><{$category.cat_title}></th>\r\n                </tr>\r\n                <{foreach item=field from=$category.fields}>\r\n                    <tr>\r\n                        <td class="head"><{$field.title}></td>\r\n                        <td class="even"><{$field.value}></td>\r\n                    </tr>\r\n                <{/foreach}>\r\n            </table>\r\n        </div>\r\n    <{/if}>\r\n<{/foreach}>\r\n\r\n<{if $modules}>\r\n<br style="clear: both;" />\r\n<div class="profile-list-activity">\r\n    <h2><{$recent_activity}></h2>\r\n    <!-- start module search results loop -->\r\n    <{foreach item=module from=$modules}>\r\n\r\n    <h4><{$module.name}></h4>\r\n\r\n      <!-- start results item loop -->\r\n          <{foreach item=result from=$module.results}>\r\n\r\n          <img src="<{$result.image}>" alt="<{$module.name}>" />&nbsp;<b><a href="<{$result.link}>"><{$result.title}></a></b><br /><small>(<{$result.time}>)</small><br />\r\n\r\n          <{/foreach}>\r\n          <!-- end results item loop -->\r\n\r\n    <{$module.showall_link}>\r\n\r\n    <{/foreach}>\r\n    <!-- end module search results loop -->\r\n</div>    \r\n<{/if}>'),
(40, '<div><a href="category.php?op=new"><{$smarty.const._ADD}> <{$smarty.const._PROFILE_AM_CATEGORY}></a></div>\r\n<table>\r\n    <tr>\r\n    <th><{$smarty.const._PROFILE_AM_TITLE}></th>\r\n    <th><{$smarty.const._PROFILE_AM_DESCRIPTION}></th>\r\n    <th><{$smarty.const._PROFILE_AM_WEIGHT}></th>\r\n    <th></th>\r\n    </tr>\r\n    <{foreach item=category from=$categories}>\r\n        <tr class="<{cycle values=''odd, even''}>">\r\n            <td><{$category.cat_title}></td>\r\n            <td><{$category.cat_description}></td>\r\n            <td><{$category.cat_weight}></td>\r\n            <td>\r\n                <a href="category.php?id=<{$category.cat_id}>" title="<{$smarty.const._EDIT}>"><{$smarty.const._EDIT}></a>\r\n                &nbsp;<a href="category.php?op=delete&amp;id=<{$category.cat_id}>" title="<{$smarty.const._DELETE}>"><{$smarty.const._DELETE}></a>\r\n            </td>\r\n        </tr>\r\n    <{/foreach}>\r\n</table>'),
(41, '<{includeq file="db:profile_breadcrumbs.html"}>\r\n<div>( <{$total_users}> )</div>\r\n<{includeq file="db:profile_form.html" xoForm=$searchform}>'),
(42, '<{includeq file="db:profile_breadcrumbs.html"}>\r\n<div>( <{$total_users}> )</div>\r\n<{if $users}>\r\n    <table>\r\n        <tr>\r\n            <{foreach item=caption from=$captions}>\r\n                <th><{$caption}></th>\r\n            <{/foreach}>\r\n        </tr>\r\n        <{foreach item=user from=$users}>\r\n            <tr class="<{cycle values=''odd, even''}>">\r\n                <{foreach item=fieldvalue from=$user.output}>\r\n                    <td><{$fieldvalue}></td>\r\n                <{/foreach}>\r\n            </tr>\r\n        <{/foreach}>\r\n    </table>\r\n    \r\n    <{$nav}>\r\n<{else}>\r\n    <div class="errorMsg">\r\n        <{$smarty.const._PROFILE_MA_NOUSERSFOUND}>\r\n    </div>\r\n<{/if}>'),
(43, '<br />\r\n<div class="head">\r\n    <form id="<{$addform.name}>" method="<{$addform.method}>" action="<{$addform.action}>">\r\n        <{foreach item=element from=$addform.elements}>\r\n            <{$element.caption}> <{$element.body}>\r\n        <{/foreach}>\r\n    </form>\r\n</div>\r\n\r\n<table>\r\n    <{foreach item=field from=$fields key=field_id}>\r\n        <tr class="<{cycle values=''odd,even''}>">\r\n            <td style="width: 20%;"><{$field}></td>\r\n            <td>\r\n                <{if isset($visibilities.$field_id)}>\r\n                    <ul>\r\n                        <{foreach item=visibility from=$visibilities.$field_id}>\r\n                            <{assign var=user_gid value=$visibility.user_group}>\r\n                            <{assign var=profile_gid value=$visibility.profile_group}>\r\n                            <li>\r\n                                <{$smarty.const._PROFILE_AM_FIELDVISIBLEFOR}> <{$groups.$user_gid}>\r\n                                <{$smarty.const._PROFILE_AM_FIELDVISIBLEON}> <{$groups.$profile_gid}>\r\n                                <a href="visibility.php?op=del&amp;field_id=<{$field_id}>&amp;ug=<{$user_gid}>&amp;pg=<{$profile_gid}>" title="<{$smarty.const._DELETE}>">\r\n                                    <img src="<{$xoops_url}>/modules/profile/images/no.png" alt="<{$smarty.const._DELETE}>" />\r\n                                </a>\r\n                            </li>\r\n                        <{/foreach}>\r\n                    </ul>\r\n                <{else}>\r\n                    <{$smarty.const._PROFILE_AM_FIELDNOTVISIBLE}>\r\n                <{/if}>\r\n            </td>\r\n        </tr>\r\n    <{/foreach}>\r\n</table>'),
(44, '<div><a href="step.php?op=new"><{$smarty.const._ADD}> <{$smarty.const._PROFILE_AM_STEP}></a></div>\r\n<table>\r\n    <th><{$smarty.const._PROFILE_AM_STEPNAME}></th>\r\n    <th><{$smarty.const._PROFILE_AM_STEPORDER}></th>\r\n    <th><{$smarty.const._PROFILE_AM_STEPSAVE}></th>\r\n    <th></th>\r\n    <{foreach item=step from=$steps}>\r\n        <tr class="<{cycle values=''odd, even''}>">\r\n            <td><{$step.step_name}></td>\r\n            <td><{$step.step_order}></td>\r\n            <td><{if $step.step_save == 1}><img src="<{$xoops_url}>/modules/profile/images/yes.png" alt="<{$smarty.const._YES}>" /><{else}><img src="<{$xoops_url}>/modules/profile/images/no.png" alt="<{$smarty.const._NO}>" /><{/if}></td>\r\n            <td>\r\n                <a href="step.php?id=<{$step.step_id}>" title="<{$smarty.const._EDIT}>"><{$smarty.const._EDIT}></a>\r\n                &nbsp;<a href="step.php?op=delete&amp;id=<{$step.step_id}>" title="<{$smarty.const._DELETE}>"><{$smarty.const._DELETE}></a>\r\n            </td>\r\n        </tr>\r\n    <{/foreach}>\r\n</table>'),
(45, '<{includeq file="db:profile_breadcrumbs.html"}>\r\n\r\n<{if $steps|@count > 1 AND $current_step >= 0}>\r\n    <div class=''register-steps''>\r\n        <span class=''caption''><{$lang_register_steps}></span>\r\n        <{foreachq item=step from=$steps key=stepno name=steploop}>\r\n            <{if $stepno == $current_step}>\r\n                <span class=''item current''><{$step.step_name}></span>\r\n            <{else}>\r\n                <span class=''item''><{$step.step_name}></span>\r\n            <{/if}>\r\n            <{if !$smarty.foreach.steploop.last}>\r\n                <span class=''delimiter''>&raquo;</span>\r\n            <{/if}>\r\n        <{/foreach}>\r\n    </div>\r\n<{/if}>\r\n\r\n<{if $stop}>\r\n    <div class=''errorMsg'' style="text-align: left;"><{$stop}></div>\r\n    <br style=''clear: both;'' />\r\n<{/if}>\r\n\r\n<{if $confirm}>\r\n    <{foreach item=msg from=$confirm}>\r\n        <div class=''confirmMsg'' style="text-align: left;"><{$msg}></div>\r\n        <br style=''clear: both;'' />\r\n    <{/foreach}>\r\n<{/if}>\r\n\r\n<{if $regform}>\r\n    <h3><{$regform.title}></h3>\r\n    <{includeq file="db:profile_form.html" xoForm=$regform}>\r\n<{elseif $finish}>\r\n    <h1><{$finish}></h1>\r\n    <{if $finish_message}><p><{$finish_message}></p><{/if}>\r\n    <{if $finish_login}>\r\n    <form id=''register_login'' name=''register_login'' action=''user.php'' method=''post''>\r\n    <input type=''submit'' value="<{$finish_login}>">\r\n    <input type=''hidden'' name="op" id="op" value="login">\r\n    <input type=''hidden'' name="uname" id="uname" value="<{$finish_uname}>">\r\n    <input type=''hidden'' name="pass" id="pass" value="<{$finish_pass}>">\r\n    </form>\r\n    <{/if}>\r\n<{/if}>'),
(46, '<{includeq file="db:profile_breadcrumbs.html"}>\r\n\r\n<{includeq file="db:profile_form.html" xoForm=$form}>'),
(47, '<{includeq file="db:profile_breadcrumbs.html"}>\r\n\r\n\r\n<{if $stop}>\r\n    <div class=''errorMsg'' style="text-align: left;"><{$stop}></div>\r\n    <br style=''clear: both;'' />\r\n<{/if}>\r\n\r\n<{includeq file="db:profile_form.html" xoForm=$userinfo}>'),
(48, '<fieldset style="padding: 10px;">\r\n  <legend style="font-weight: bold;"><{$lang_login}></legend>\r\n  <form action="user.php" method="post">\r\n    <{$lang_username}> <input type="text" name="uname" size="26" maxlength="25" value="<{$usercookie}>" /><br /><br />\r\n    <{$lang_password}> <input type="password" name="pass" size="21" maxlength="32" /><br /><br />\r\n    <{if isset($lang_rememberme)}>\r\n        <input type="checkbox" name="rememberme" value="On" checked /> <{$lang_rememberme}><br /><br />\r\n    <{/if}>\r\n    \r\n    <input type="hidden" name="op" value="login" />\r\n    <input type="hidden" name="xoops_redirect" value="<{$redirect_page}>" />\r\n    <input type="submit" value="<{$lang_login}>" />\r\n  </form>\r\n  <br />\r\n  <a name="lost"></a>\r\n  <div><{$lang_notregister}><br /></div>\r\n</fieldset>\r\n\r\n<br />\r\n\r\n<fieldset style="padding: 10px;">\r\n  <legend style="font-weight: bold;"><{$lang_lostpassword}></legend>\r\n  <div><br /><{$lang_noproblem}></div>\r\n  <form action="lostpass.php" method="post">\r\n    <{$lang_youremail}> <input type="text" name="email" size="26" maxlength="60" />&nbsp;&nbsp;<input type="hidden" name="op" value="mailpasswd" /><input type="hidden" name="t" value="<{$mailpasswd_token}>" /><input type="submit" value="<{$lang_sendpassword}>" />\r\n  </form>\r\n</fieldset>'),
(49, '<{includeq file="db:profile_breadcrumbs.html"}>\r\n\r\n<{if $old_avatar}>\r\n    <div style="padding: 10px;">\r\n        <h4 style="color:#ff0000; font-weight:bold;"><{$smarty.const._US_OLDDELETED}></h4>\r\n        <img src="<{$old_avatar}>" alt="" />\r\n    </div>\r\n<{/if}>\r\n\r\n<{if $uploadavatar}>\r\n<{$uploadavatar.javascript}>\r\n<form name="<{$uploadavatar.name}>" action="<{$uploadavatar.action}>" method="<{$uploadavatar.method}>" <{$uploadavatar.extra}>>\r\n  <table class="outer" cellspacing="1">\r\n    <tr>\r\n    <th colspan="2"><{$uploadavatar.title}></th>\r\n    </tr>\r\n    <!-- start of form elements loop -->\r\n    <{foreach item=element from=$uploadavatar.elements}>\r\n      <{if $element.hidden != true}>\r\n      <tr>\r\n        <td class="head"><{$element.caption}>\r\n        <{if $element.description}>\r\n        	<div style="font-weight: normal"><{$element.description}></div>\r\n        <{/if}>\r\n        </td>\r\n        <td class="<{cycle values="even,odd"}>"><{$element.body}></td>\r\n      </tr>\r\n      <{else}>\r\n      <{$element.body}>\r\n      <{/if}>\r\n    <{/foreach}>\r\n    <!-- end of form elements loop -->\r\n  </table>\r\n</form>\r\n<br />\r\n<{/if}>\r\n\r\n<br />\r\n<{$chooseavatar.javascript}>\r\n<form name="<{$chooseavatar.name}>" action="<{$chooseavatar.action}>" method="<{$chooseavatar.method}>" <{$chooseavatar.extra}>>\r\n  <table class="outer" cellspacing="1">\r\n    <tr>\r\n    <th colspan="2"><{$chooseavatar.title}></th>\r\n    </tr>\r\n    <!-- start of form elements loop -->\r\n    <{foreach item=element from=$chooseavatar.elements}>\r\n      <{if $element.hidden != true}>\r\n      <tr>\r\n        <td class="head"><{$element.caption}>\r\n        <{if $element.description}>\r\n        	<div style="font-weight: normal"><{$element.description}></div>\r\n        <{/if}>\r\n        </td>\r\n        <td class="<{cycle values="even,odd"}>"><{$element.body}></td>\r\n      </tr>\r\n      <{else}>\r\n      <{$element.body}>\r\n      <{/if}>\r\n    <{/foreach}>\r\n    <!-- end of form elements loop -->\r\n  </table>\r\n</form>'),
(50, '<{includeq file="db:profile_breadcrumbs.html"}>\r\n\r\n<{includeq file="db:profile_form.html" xoForm=$emailform}>'),
(51, '<small>\r\n<{foreach  item=i from=$block.index}>\r\n<a href="<{$block.history.$i}>"><{$block.historyname.$i}><a><br/>\r\n\r\n<{/foreach}>\r\n</small>'),
(96, '<table class="outer" cellspacing="1">\r\n\r\n  <{if $block.disp_mode == 0}>\r\n  <tr>\r\n    <th class="head" nowrap="nowrap"><{$smarty.const._MB_NEWBB_FORUM}></th>\r\n    <th class="head" nowrap="nowrap"><{$smarty.const._MB_NEWBB_TOPIC}></th>\r\n    <th class="head" align="center" nowrap="nowrap"><{$smarty.const._MB_NEWBB_RPLS}></th>\r\n    <th class="head" align="center" nowrap="nowrap"><{$smarty.const._MB_NEWBB_VIEWS}></th>\r\n    <th class="head" align="center" nowrap="nowrap"><{$smarty.const._MB_NEWBB_LPOST}></th>\r\n  </tr>\r\n\r\n  <{foreach item=topic from=$block.topics}>\r\n  <tr class="<{cycle values="even,odd"}>">\r\n    <td><a href="<{$xoops_url}>/modules/newbb/viewforum.php?forum=<{$topic.forum_id}>"><{$topic.forum_name}></a></td>\r\n    <td><a href="<{$xoops_url}>/modules/newbb/viewtopic.php?topic_id=<{$topic.id}>&amp;forum=<{$topic.forum_id}>&amp;post_id=<{$topic.post_id}>#forumpost<{$topic.post_id}>">\r\n		<{if $topic.topic_subject}>\r\n		<{$topic.topic_subject}>\r\n		<{/if}>\r\n		<{$topic.title}></a><{$topic.topic_page_jump}></td>\r\n    <td align="center"><{$topic.replies}></td>\r\n    <td align="center"><{$topic.views}></td>\r\n    <td align="right"><{$topic.time}><br /><{$topic.topic_poster}></td>\r\n  </tr>\r\n  <{/foreach}>\r\n\r\n  <{elseif $block.disp_mode == 1}>\r\n\r\n  <tr>\r\n    <th class="head" nowrap="nowrap"><{$smarty.const._MB_NEWBB_TOPIC}></th>\r\n    <th class="head" align="center" nowrap="nowrap"><{$smarty.const._MB_NEWBB_RPLS}></th>\r\n    <th class="head" align="center" nowrap="nowrap"><{$smarty.const._MB_NEWBB_LPOST}></th>\r\n  </tr>\r\n\r\n  <{foreach item=topic from=$block.topics}>\r\n  <tr class="<{cycle values="even,odd"}>">\r\n    <td><a href="<{$xoops_url}>/modules/newbb/viewtopic.php?topic_id=<{$topic.id}>&amp;forum=<{$topic.forum_id}>&amp;post_id=<{$topic.post_id}>#forumpost<{$topic.post_id}>"><{$topic.title}></a></td>\r\n    <td align="center"><{$topic.replies}></td>\r\n    <td align="right"><{$topic.time}><br /><{$topic.topic_poster}></td>\r\n  </tr>\r\n  <{/foreach}>\r\n\r\n  <{elseif $block.disp_mode == 2}>\r\n\r\n  <{foreach item=topic from=$block.topics}>\r\n  <tr class="<{cycle values="even,odd"}>">\r\n    <td><a href="<{$xoops_url}>/modules/newbb/viewtopic.php?topic_id=<{$topic.id}>&amp;forum=<{$topic.forum_id}>&amp;post_id=<{$topic.post_id}>#forumpost<{$topic.post_id}>"><{$topic.title}></a></td>\r\n  </tr>\r\n  <{/foreach}>\r\n\r\n  <{/if}>\r\n\r\n</table>\r\n\r\n<{if $block.indexNav}>\r\n<div style="text-align:right; padding: 5px;">\r\n<a href="<{$xoops_url}>/modules/newbb/viewpost.php"><{$smarty.const._MB_NEWBB_ALLPOSTS}></a> |\r\n<a href="<{$xoops_url}>/modules/newbb/viewall.php"><{$smarty.const._MB_NEWBB_ALLTOPICS}></a> |\r\n<a href="<{$xoops_url}>/modules/newbb/"><{$smarty.const._MB_NEWBB_VSTFRMS}></a>\r\n</div>\r\n<{/if}>'),
(97, '<table class="outer" cellspacing="1">\r\n\r\n  <{if $block.disp_mode == 0}>\r\n  <tr>\r\n    <th class="head" nowrap="nowrap"><{$smarty.const._MB_NEWBB_FORUM}></th>\r\n    <th class="head" nowrap="nowrap"><{$smarty.const._MB_NEWBB_TITLE}></th>\r\n    <th class="head" align="center" nowrap="nowrap"><{$smarty.const._MB_NEWBB_RPLS}></th>\r\n    <th class="head" align="center" nowrap="nowrap"><{$smarty.const._MB_NEWBB_VIEWS}></th>\r\n    <th class="head" align="center" nowrap="nowrap"><{$smarty.const._MB_NEWBB_AUTHOR}></th>\r\n  </tr>\r\n\r\n  <{foreach item=topic from=$block.topics}>\r\n  <tr class="<{cycle values="even,odd"}>">\r\n    <td><a href="<{$xoops_url}>/modules/newbb/viewforum.php?forum=<{$topic.forum_id}>"><{$topic.forum_name}></a></td>\r\n    <td><a href="<{$xoops_url}>/modules/newbb/viewtopic.php?topic_id=<{$topic.id}>&amp;forum=<{$topic.forum_id}>">\r\n		<{if $topic.topic_subject}>\r\n		<{$topic.topic_subject}>\r\n		<{/if}>\r\n		<{$topic.title}></a>\r\n	</td>\r\n    <td align="center"><{$topic.replies}></td>\r\n    <td align="center"><{$topic.views}></td>\r\n    <td align="right"><{$topic.time}><br /><{$topic.topic_poster}></td>\r\n  </tr>\r\n  <{/foreach}>\r\n\r\n  <{elseif $block.disp_mode == 1}>\r\n\r\n  <tr>\r\n    <th class="head" nowrap="nowrap"><{$smarty.const._MB_NEWBB_TOPIC}></th>\r\n    <th class="head" align="center" nowrap="nowrap"><{$smarty.const._MB_NEWBB_AUTHOR}></th>\r\n  </tr>\r\n\r\n  <{foreach item=topic from=$block.topics}>\r\n  <tr class="<{cycle values="even,odd"}>">\r\n    <td><a href="<{$xoops_url}>/modules/newbb/viewtopic.php?topic_id=<{$topic.id}>&amp;forum=<{$topic.forum_id}>">\r\n		<{if $topic.topic_subject}>\r\n		<{$topic.topic_subject}>\r\n		<{/if}>\r\n		<{$topic.title}></a><{$topic.topic_page_jump}>\r\n	</td>\r\n    <td align="right"><{$topic.time}><br /><{$topic.topic_poster}></td>\r\n  </tr>\r\n  <{/foreach}>\r\n\r\n  <{elseif $block.disp_mode == 2}>\r\n\r\n  <{foreach item=topic from=$block.topics}>\r\n  <tr class="<{cycle values="even,odd"}>">\r\n    <td><a href="<{$xoops_url}>/modules/newbb/viewtopic.php?topic_id=<{$topic.id}>&amp;forum=<{$topic.forum_id}>">\r\n		<{if $topic.topic_subject}>\r\n		<{$topic.topic_subject}>\r\n		<{/if}>\r\n		<{$topic.title}></a>\r\n	</td>\r\n  </tr>\r\n  <{/foreach}>\r\n\r\n  <{/if}>\r\n\r\n</table>\r\n\r\n<{if $block.indexNav}>\r\n<div style="text-align:right; padding: 5px;">\r\n<a href="<{$xoops_url}>/modules/newbb/viewall.php"><{$smarty.const._MB_NEWBB_ALLTOPICS}></a> |\r\n<a href="<{$xoops_url}>/modules/newbb/"><{$smarty.const._MB_NEWBB_VSTFRMS}></a>\r\n</div>\r\n<{/if}>'),
(98, '<table class="outer" cellspacing="1">\r\n\r\n  <{if $block.disp_mode == 0}>\r\n  <tr>\r\n    <th class="head" nowrap="nowrap"><{$smarty.const._MB_NEWBB_FORUM}></th>\r\n    <th class="head" nowrap="nowrap"><{$smarty.const._MB_NEWBB_TITLE}></th>\r\n    <th class="head" align="center" nowrap="nowrap"><{$smarty.const._MB_NEWBB_AUTHOR}></th>\r\n  </tr>\r\n\r\n  <{foreach item=topic from=$block.topics}>\r\n  <tr class="<{cycle values="even,odd"}>">\r\n    <td><a href="<{$xoops_url}>/modules/newbb/viewforum.php?forum=<{$topic.forum_id}>"><{$topic.forum_name}></a></td>\r\n    <td><a href="<{$xoops_url}>/modules/newbb/viewtopic.php?forum=<{$topic.forum_id}>&amp;post_id=<{$topic.post_id}>#forumpost<{$topic.post_id}>"><{$topic.title}></a></td>\r\n    <td align="right"><{$topic.time}><br /><{$topic.topic_poster}></td>\r\n  </tr>\r\n  <{/foreach}>\r\n\r\n  <{elseif $block.disp_mode == 1}>\r\n\r\n  <tr>\r\n    <th class="head" nowrap="nowrap"><{$smarty.const._MB_NEWBB_TOPIC}></th>\r\n    <th class="head" align="center" nowrap="nowrap"><{$smarty.const._MB_NEWBB_AUTHOR}></th>\r\n  </tr>\r\n\r\n  <{foreach item=topic from=$block.topics}>\r\n  <tr class="<{cycle values="even,odd"}>">\r\n    <td><a href="<{$xoops_url}>/modules/newbb/viewtopic.php?forum=<{$topic.forum_id}>&amp;post_id=<{$topic.post_id}>#forumpost<{$topic.post_id}>"><{$topic.title}></a></td>\r\n    <td align="right"><{$topic.time}><br /><{$topic.topic_poster}></td>\r\n  </tr>\r\n  <{/foreach}>\r\n\r\n  <{elseif $block.disp_mode == 2}>\r\n\r\n  <{foreach item=topic from=$block.topics}>\r\n  <tr class="<{cycle values="even,odd"}>">\r\n    <td><a href="<{$xoops_url}>/modules/newbb/viewtopic.php?forum=<{$topic.forum_id}>&amp;post_id=<{$topic.post_id}>#forumpost<{$topic.post_id}>"><{$topic.title}></a></td>\r\n  </tr>\r\n  <{/foreach}>\r\n\r\n  <{else}>\r\n  <tr><td>\r\n	<{foreach item=topic from=$block.topics}>\r\n	<div><strong><a href="<{$xoops_url}>/modules/newbb/viewtopic.php?forum=<{$topic.forum_id}>&amp;post_id=<{$topic.post_id}>#forumpost<{$topic.post_id}>"><{$topic.title}></a></strong></div>\r\n	<div>\r\n	<a href="<{$xoops_url}>/modules/newbb/viewforum.php?forum=<{$topic.forum_id}>"><{$topic.forum_name}></a> | \r\n	<{$topic.topic_poster}> | <{$topic.time}>\r\n	</div>\r\n	<div style="padding: 5px 0px 10px 0px;"><{$topic.post_text}></div>\r\n	<{/foreach}>\r\n  </td></tr>\r\n  <{/if}>\r\n\r\n</table>\r\n\r\n<{if $block.indexNav}>\r\n<div style="text-align:right; padding: 5px;">\r\n<a href="<{$xoops_url}>/modules/newbb/viewpost.php"><{$smarty.const._MB_NEWBB_ALLPOSTS}></a> |\r\n<a href="<{$xoops_url}>/modules/newbb/"><{$smarty.const._MB_NEWBB_VSTFRMS}></a>\r\n</div>\r\n<{/if}>'),
(99, '<table class="outer" cellspacing="1">\r\n\r\n  <{if $block.disp_mode == 0}>\r\n  <tr>\r\n    <th class="head" nowrap="nowrap"><{$smarty.const._MB_NEWBB_AUTHOR}></th>\r\n    <th class="head" align="center" nowrap="nowrap"><{$smarty.const._MB_NEWBB_COUNT}></th>\r\n  </tr>\r\n\r\n  <{foreach item=author key=uid from=$block.authors}>\r\n  <tr class="<{cycle values="even,odd"}>">\r\n    <td><a href="<{$xoops_url}>/userinfo.php?uid=<{$uid}>"><{$author.name}></a></td>\r\n    <td align="center"><{$author.count}></td>\r\n  </tr>\r\n  <{/foreach}>\r\n\r\n  <{elseif $block.disp_mode == 1}>\r\n\r\n  <{foreach item=author key=uid from=$block.authors}>\r\n  <tr class="<{cycle values="even,odd"}>">\r\n    <td><a href="<{$xoops_url}>/userinfo.php?uid=<{$uid}>"><{$author.name}></a> <{$author.count}></td>\r\n  </tr>\r\n  <{/foreach}>\r\n\r\n  <{/if}>\r\n\r\n</table>\r\n<{if $block.indexNav}>\r\n<div style="text-align:right; padding: 5px;">\r\n<a href="<{$xoops_url}>/modules/newbb/"><{$smarty.const._MB_NEWBB_VSTFRMS}></a>\r\n</div>\r\n<{/if}>'),
(120, '<small>\r\n<{foreach  item=i from=$block.index}>\r\n<a href="<{$block.history.$i}>"><{$block.historyname.$i}><a><br/>\r\n\r\n<{/foreach}>\r\n</small>');

-- --------------------------------------------------------

--
-- Table structure for table `sim_Tree`
--

CREATE TABLE IF NOT EXISTS `sim_Tree` (
  `Node` int(11) NOT NULL AUTO_INCREMENT,
  `ParentNode` int(11) DEFAULT NULL,
  `DeptID` int(11) NOT NULL,
  `Depth` tinyint(4) DEFAULT NULL,
  `Lineage` varchar(255) DEFAULT NULL,
  `uid` mediumint(8) NOT NULL,
  PRIMARY KEY (`Node`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `sim_Tree`
--


-- --------------------------------------------------------

--
-- Table structure for table `sim_users`
--

CREATE TABLE IF NOT EXISTS `sim_users` (
  `uid` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(60) NOT NULL DEFAULT '',
  `uname` varchar(25) NOT NULL DEFAULT '',
  `email` varchar(60) NOT NULL DEFAULT '',
  `url` varchar(100) NOT NULL DEFAULT '',
  `user_avatar` varchar(30) NOT NULL DEFAULT 'blank.gif',
  `user_regdate` int(10) unsigned NOT NULL DEFAULT '0',
  `user_icq` varchar(15) NOT NULL DEFAULT '',
  `user_from` varchar(100) NOT NULL DEFAULT '',
  `user_sig` tinytext,
  `user_viewemail` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `actkey` varchar(8) NOT NULL DEFAULT '',
  `user_aim` varchar(18) NOT NULL DEFAULT '',
  `user_yim` varchar(25) NOT NULL DEFAULT '',
  `user_msnm` varchar(100) NOT NULL DEFAULT '',
  `pass` varchar(32) NOT NULL DEFAULT '',
  `posts` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `attachsig` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `rank` smallint(5) unsigned NOT NULL DEFAULT '0',
  `level` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `theme` varchar(100) NOT NULL DEFAULT '',
  `timezone_offset` float(3,1) NOT NULL DEFAULT '0.0',
  `last_login` int(10) unsigned NOT NULL DEFAULT '0',
  `umode` varchar(10) NOT NULL DEFAULT '',
  `uorder` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `notify_method` tinyint(1) NOT NULL DEFAULT '1',
  `notify_mode` tinyint(1) NOT NULL DEFAULT '0',
  `user_occ` varchar(100) NOT NULL DEFAULT '',
  `bio` tinytext,
  `user_intrest` varchar(150) NOT NULL DEFAULT '',
  `user_mailok` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `user_isactive` smallint(1) NOT NULL DEFAULT '0',
  `isstudent` smallint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`uid`),
  KEY `uname` (`uname`),
  KEY `email` (`email`),
  KEY `uiduname` (`uid`,`uname`),
  KEY `unamepass` (`uname`,`pass`),
  KEY `level` (`level`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `sim_users`
--

INSERT INTO `sim_users` (`uid`, `name`, `uname`, `email`, `url`, `user_avatar`, `user_regdate`, `user_icq`, `user_from`, `user_sig`, `user_viewemail`, `actkey`, `user_aim`, `user_yim`, `user_msnm`, `pass`, `posts`, `attachsig`, `rank`, `level`, `theme`, `timezone_offset`, `last_login`, `umode`, `uorder`, `notify_method`, `notify_mode`, `user_occ`, `bio`, `user_intrest`, `user_mailok`, `user_isactive`, `isstudent`) VALUES
(1, '--', 'admin', 'ymsong@simit.com.my', 'http://localhost/simedu/', 'blank.gif', 1205985656, 'e', '', '', 0, '', '', '', '', '21232f297a57a5a743894a0e4a801fc3', 0, 0, 0, 5, 'default', 8.0, 1283076854, 'thread', 0, 1, 0, '', '', 'admin', 0, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `sim_version`
--

CREATE TABLE IF NOT EXISTS `sim_version` (
  `releasedate` date NOT NULL,
  `version` varchar(20) NOT NULL,
  `description` text NOT NULL,
  `upgradescript` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sim_version`
--


-- --------------------------------------------------------

--
-- Table structure for table `sim_window`
--

CREATE TABLE IF NOT EXISTS `sim_window` (
  `window_id` smallint(5) NOT NULL AUTO_INCREMENT,
  `filename` varchar(50) NOT NULL DEFAULT '',
  `isactive` smallint(1) NOT NULL DEFAULT '1',
  `window_name` varchar(50) NOT NULL DEFAULT '',
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updatedby` int(11) NOT NULL DEFAULT '0',
  `created` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `createdby` int(11) NOT NULL DEFAULT '0',
  `parentwindows_id` int(11) NOT NULL,
  `seqno` int(5) NOT NULL DEFAULT '0',
  `mid` int(11) NOT NULL,
  `windowsetting` text NOT NULL,
  `description` varchar(255) NOT NULL,
  `isdeleted` smallint(1) NOT NULL,
  `table_name` varchar(50) DEFAULT NULL,
  `helpurl` text NOT NULL,
  PRIMARY KEY (`window_id`),
  KEY `filename` (`filename`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=161 ;

--
-- Dumping data for table `sim_window`
--

INSERT INTO `sim_window` (`window_id`, `filename`, `isactive`, `window_name`, `updated`, `updatedby`, `created`, `createdby`, `parentwindows_id`, `seqno`, `mid`, `windowsetting`, `description`, `isdeleted`, `table_name`, `helpurl`) VALUES
(0, '', 1, 'Top Parent', '2010-07-25 23:16:41', 1, '2010-07-24 13:16:24', 1, -1, 10, 61, '', '', 0, '', ''),
(1, '', 1, 'Master Data', '2010-07-25 23:16:41', 1, '2010-07-24 13:16:24', 1, 0, 10, 61, '', '', 0, '', ''),
(2, '', 1, 'Help/Support', '2010-07-25 23:16:41', 1, '2010-07-24 13:16:42', 1, 0, 20, 61, '', '', 0, '', ''),
(3, 'currency.php', 1, 'Add/Edit Currency', '2010-07-25 23:16:41', 1, '2010-07-24 13:17:16', 1, 1, 10, 61, '', '', 0, '', ''),
(4, 'country.php', 1, 'Add/Edit Country', '2010-07-25 23:16:41', 1, '2010-07-24 13:17:28', 1, 1, 10, 61, '', '', 0, '', ''),
(5, 'races.php', 1, 'Add/Edit Races', '2010-07-25 23:16:41', 1, '2010-07-24 13:17:51', 1, 1, 10, 61, '', '', 0, '', ''),
(6, 'religion.php', 1, 'Add/Edit Religion', '2010-07-25 23:16:41', 1, '2010-07-24 13:18:07', 1, 1, 10, 61, '', '', 0, '', ''),
(7, 'region.php', 0, 'Add/Edit Region', '2010-08-03 09:34:05', 1, '2010-07-24 13:18:19', 1, 1, 10, 61, '', '', 0, '', ''),
(8, 'period.php', 1, 'Add/Edit Period', '2010-07-25 23:16:41', 1, '2010-07-24 13:18:30', 1, 1, 10, 61, '', '', 0, '', ''),
(9, '', 1, 'License', '2010-07-25 23:16:41', 1, '2010-07-24 13:22:00', 1, 2, 10, 61, '', '', 0, '', ''),
(10, '', 1, 'Developer Help', '2010-07-25 23:16:41', 1, '2010-07-24 13:22:35', 1, 2, 10, 61, '', '', 0, '', ''),
(11, '', 1, 'About SIMIT Framework', '2010-07-25 23:16:41', 1, '2010-07-24 13:22:47', 1, 2, 10, 61, '', '', 0, '', ''),
(12, '', 1, 'Forums', '2010-07-25 23:16:41', 1, '2010-07-24 13:22:53', 1, 2, 10, 61, '', '', 0, '', ''),
(13, 'http://www.simit.com.my/wiki', 1, 'Wiki', '2010-07-25 23:16:41', 1, '2010-07-24 13:22:58', 1, 2, 10, 61, '', '', 0, '', ''),
(15, '', 1, 'Master Data', '2010-08-09 11:11:07', 1, '2010-07-26 12:31:42', 1, 0, 10, 70, '', '', 0, '', ''),
(16, '', 1, 'Transaction', '2010-08-09 11:11:07', 1, '2010-07-26 12:32:04', 1, 0, 20, 70, '', '', 0, '', ''),
(17, '', 1, 'Reports', '2010-08-09 11:11:07', 1, '2010-07-26 12:32:17', 1, 0, 30, 70, '', '', 0, '', ''),
(18, 'employeegroup.php', 1, 'Employee Group', '2010-08-18 21:02:54', 1, '2010-07-26 12:56:53', 1, 15, 70, 70, '', '', 0, 'sim_hr_employeegroup', ''),
(19, 'department.php', 1, 'Department', '2010-08-18 21:02:40', 1, '2010-07-26 13:34:39', 1, 15, 50, 70, '', '', 0, 'sim_hr_department', ''),
(20, 'jobposition.php', 1, 'Job Position', '2010-08-18 21:02:49', 1, '2010-07-26 13:35:04', 1, 15, 60, 70, '', '', 0, 'sim_hr_jobposition', ''),
(21, 'leavetype.php', 1, 'Leave Type', '2010-08-18 21:03:11', 1, '2010-07-26 13:35:27', 1, 15, 90, 70, '', '', 0, 'sim_hr_leavetype', ''),
(22, 'disciplinetype.php', 1, 'Discipline Type', '2010-08-15 16:06:30', 1, '2010-07-26 13:35:57', 1, 15, 80, 70, 'd', '', 0, 'sim_hr_disciplinetype', ''),
(23, 'trainingtype.php', 1, 'Training Type', '2010-08-18 21:03:19', 1, '2010-07-26 13:36:46', 1, 15, 100, 70, '', '', 0, 'sim_hr_trainingtype', ''),
(24, 'employee.php', 1, 'Employee', '2010-08-18 21:04:01', 1, '2010-07-26 13:37:31', 1, 15, 120, 70, '', '', 0, 'sim_hr_employee', ''),
(25, 'panelclinics.php', 1, 'Panel Clinic Visits', '2010-08-15 15:39:30', 1, '2010-07-26 13:37:54', 1, 75, 10, 70, '', '', 0, '', ''),
(26, 'leaveadjustment.php', 1, 'Leave Adjustment', '2010-08-15 15:39:37', 1, '2010-07-26 13:38:17', 1, 75, 20, 70, '', '', 0, 'sim_hr_leaveadjustment', ''),
(27, 'leave.php', 1, 'Apply Leave', '2010-08-15 15:39:49', 1, '2010-07-26 13:38:41', 1, 74, 10, 70, '', '', 0, 'sim_hr_leave', ''),
(28, 'generalclaim.php', 1, 'General Claim', '2010-08-19 18:33:22', 1, '2010-07-26 13:39:17', 1, 74, 50, 70, '', '', 0, 'sim_hr_generalclaim', 'http://www.hiumen.com/wiki/index.php/Online_Application#General_Claim'),
(29, 'travellingclaim.php', 1, 'Travelling Claim', '2010-08-15 15:39:55', 1, '2010-07-26 13:39:39', 1, 74, 60, 70, '', '', 0, 'sim_hr_travellingclaim', ''),
(30, 'medicalclaim.php', 1, 'Medical Claim', '2010-08-15 15:40:06', 1, '2010-07-26 13:40:03', 1, 74, 70, 70, '', '', 0, 'sim_hr_medicalclaim', ''),
(31, 'overtimeclaim.php', 1, 'Overtime Claim', '2010-08-15 15:40:31', 1, '2010-07-26 13:40:26', 1, 74, 80, 70, '', '', 0, 'sim_hr_overtimeclaim', ''),
(32, 'approvallist.php', 0, 'Approval List', '2010-08-15 15:52:39', 1, '2010-07-26 18:16:29', 1, 0, 10, 68, '', '', 0, '', ''),
(33, 'recordinfo.php', 0, 'Record Info', '2010-08-09 11:11:07', 1, '2010-07-27 09:39:33', 1, 17, 400, 70, '', '', 0, '', ''),
(34, 'bpartner.php', 1, 'Business Partner', '2010-08-10 06:43:07', 1, '2010-07-28 19:00:06', 1, 53, 10, 66, '', '', 0, 'sim_bpartner', ''),
(35, 'bpartnergroup.php', 1, 'Business Partner Group', '2010-08-10 06:43:07', 1, '2010-07-28 19:00:51', 1, 53, 20, 66, '', '', 0, 'sim_bpartnergroup', ''),
(36, 'industry.php', 1, 'Industry', '2010-08-10 06:43:07', 1, '2010-07-28 19:01:20', 1, 53, 30, 66, '', '', 0, 'sim_industry', ''),
(37, 'terms.php', 1, 'Terms', '2010-08-10 06:43:07', 1, '0000-00-00 00:00:00', 1, 53, 40, 66, '', '', 0, 'sim_terms', ''),
(38, 'printemployeelist.php', 0, 'Print Employee List', '2010-08-18 21:04:28', 1, '2010-07-30 10:56:47', 1, 17, 100, 70, '', '', 0, '', ''),
(39, 'panelclinicrep.php', 1, 'Panel Clinic Visit', '2010-08-09 11:11:07', 1, '2010-07-30 12:15:22', 1, 17, 10, 70, '', '', 0, '', ''),
(40, 'printapplyleavelist.php', 0, 'Print Apply Leave List', '2010-08-18 21:04:34', 1, '2010-07-30 12:29:50', 1, 17, 110, 70, '', '', 0, '', ''),
(41, 'printgeneralclaimlist.php', 0, 'Print General Claim List', '2010-08-18 21:04:37', 1, '2010-07-30 15:44:09', 1, 17, 120, 70, '', '', 0, '', ''),
(42, 'printtravellingclaimlist.php', 0, 'Print Travelling Claim List', '2010-08-18 21:04:41', 1, '2010-07-30 15:59:36', 1, 17, 130, 70, '', '', 0, '', ''),
(43, 'printmedicalclaimlist.php', 0, 'Print Medical Claim List', '2010-08-18 21:04:45', 1, '2010-07-30 16:09:06', 1, 17, 140, 70, '', '', 0, '', ''),
(44, 'printovertimeclaimlist.php', 0, 'Print Overtime Claim List', '2010-08-18 21:04:48', 1, '2010-07-30 16:09:30', 1, 17, 150, 70, '', '', 0, '', ''),
(45, 'printadjustmentleavelist.php', 0, 'Print Adjustment Leave List', '2010-08-18 21:04:52', 1, '2010-07-30 16:29:17', 1, 17, 160, 70, '', '', 0, '', ''),
(46, 'employeeprofile.php', 0, 'Print Employee Cover', '2010-08-18 21:05:21', 1, '2010-08-02 15:44:00', 1, 17, 170, 70, '', '', 0, '', ''),
(47, 'viewemployeeprofile.php', 0, 'Print Employee Details', '2010-08-18 21:05:26', 1, '2010-08-02 15:44:25', 1, 17, 180, 70, '', '', 0, '', ''),
(48, 'statistics.php', 1, 'Statistics', '2010-08-09 11:11:07', 1, '2010-08-03 16:15:56', 1, 17, 10, 70, '', '', 0, '', ''),
(49, 'chartleave_1month.php', 0, 'Chart leave', '2010-08-18 21:05:45', 1, '2010-08-03 17:47:54', 1, 17, 200, 70, '', '', 0, '', ''),
(50, 'turnover_1month.php', 0, 'Turnover month', '2010-08-18 21:05:50', 1, '2010-08-03 17:48:16', 1, 17, 210, 70, '', '', 0, '', ''),
(51, '', 1, 'Master Data', '2010-08-05 14:07:20', 1, '2010-08-05 14:07:20', 1, 0, 10, 69, '', '', 0, '', ''),
(52, 'accounts.php', 1, 'Chart Of Accounts', '2010-08-05 14:08:02', 1, '2010-08-05 14:08:02', 1, 51, 10, 69, '', '', 0, '', ''),
(53, '', 1, 'Master Data', '2010-08-10 06:42:36', 1, '2010-08-10 06:42:10', 1, 0, 10, 66, '', '', 0, '', ''),
(54, 'followuptype.php', 1, 'Follow up Type', '2010-08-10 06:43:38', 1, '2010-08-10 06:43:38', 1, 53, 10, 66, '', '', 0, 'sim_followuptype', ''),
(55, 'payslip.php', 1, 'Generate Payslip', '2010-08-12 10:28:54', 1, '2010-08-12 10:26:27', 1, 56, 10, 71, '', '', 0, 'sim_hr_payslip', ''),
(56, '', 1, 'Transaction', '2010-08-12 10:29:02', 1, '2010-08-12 10:28:41', 1, 0, 10, 71, '', '', 0, '', ''),
(57, 'listpayslip.php', 1, 'Payroll History', '2010-08-12 10:29:35', 1, '2010-08-12 10:29:35', 1, 56, 20, 71, '', '', 0, '', ''),
(58, '', 1, 'Transaction', '2010-08-12 11:52:30', 1, '2010-08-12 11:52:30', 1, 0, 10, 79, '', '', 0, '', ''),
(59, 'payslip.php', 1, 'Generate Payslip', '2010-08-12 11:53:07', 1, '2010-08-12 11:53:07', 1, 58, 10, 79, '', '', 0, 'sim_hr_payslip', ''),
(60, '', 1, 'Payroll History', '2010-08-13 10:21:45', 1, '2010-08-12 11:53:18', 1, 58, 20, 79, '', '', 0, '', ''),
(61, 'panelclinics.php?action=search', 1, 'Panel Clinic Visit List', '2010-08-13 16:35:30', 1, '2010-08-13 16:35:30', 1, 17, 30, 70, '', '', 0, '', ''),
(62, 'leave.php?action=search', 1, 'Leave List', '2010-08-13 16:36:24', 1, '2010-08-13 16:36:24', 1, 17, 40, 70, '', '', 0, '', ''),
(63, 'generalclaim.php?action=search', 1, 'General Claim List', '2010-08-13 16:37:11', 1, '2010-08-13 16:37:11', 1, 17, 50, 70, '', '', 0, '', ''),
(64, 'travellingclaim.php?action=search', 1, 'Travelling Claim List', '2010-08-13 16:52:21', 1, '2010-08-13 16:52:21', 1, 17, 60, 70, '', '', 0, '', ''),
(65, 'medicalclaim.php?action=search', 1, 'Medical Claim List', '2010-08-13 16:53:45', 1, '2010-08-13 16:53:45', 1, 17, 70, 70, '', '', 0, '', ''),
(66, 'overtimeclaim.php?action=search', 1, 'Over Time Claim List', '2010-08-13 16:54:26', 1, '2010-08-13 16:54:26', 1, 17, 80, 70, '', '', 0, '', ''),
(67, 'viewappraisalreport.php', 1, 'Appraisal Report', '2010-08-14 01:17:04', 1, '2010-08-14 01:17:04', 1, 17, 10, 70, '', '', 0, '', ''),
(68, 'viewservicetermanalysis.php', 1, 'Service Term Analysis', '2010-08-14 02:02:06', 1, '2010-08-14 02:01:24', 1, 17, 10, 70, '', '', 0, '', ''),
(69, 'races.php', 1, 'Races', '2010-08-18 21:01:58', 1, '2010-08-15 11:30:02', 1, 15, 10, 70, '', '', 0, 'sim_races', ''),
(70, 'religion.php', 1, 'Religion', '2010-08-18 21:02:08', 1, '2010-08-15 11:30:14', 1, 15, 20, 70, '', '', 0, 'sim_religion', ''),
(71, 'country.php', 1, 'Country', '2010-08-19 13:19:24', 1, '2010-08-15 11:30:28', 1, 15, 30, 70, '', '', 0, 'sim_country', 'http://www.hiumen.com/wiki/index.php?title=Edit_Country&action=edit&redlink=1'),
(72, 'currency.php', 1, 'Currency', '2010-08-18 21:02:29', 1, '2010-08-15 15:36:17', 1, 15, 40, 70, '', '', 0, 'sim_currency', 'http://www.hiumen.com/wiki/index.php?title=Edit_Position&action=edit&redlink=1'),
(73, 'organization.php', 1, 'Organization Info', '2010-08-18 21:04:15', 1, '2010-08-15 15:37:32', 1, 15, 140, 70, '', '', 0, 'sim_organization', ''),
(74, '', 1, 'Online Application', '2010-08-15 15:39:13', 1, '2010-08-15 15:39:13', 1, 16, 10, 70, '', '', 0, '', ''),
(75, '', 1, 'HR Transaction', '2010-08-15 15:39:22', 1, '2010-08-15 15:39:22', 1, 16, 10, 70, '', '', 0, '', ''),
(76, 'newmobile.php', 0, 'mobileweb', '2010-08-15 15:53:25', 1, '2010-08-15 15:53:25', 1, 0, 10, 68, '', '', 0, '', ''),
(77, 'basicmobile', 0, 'basicmobile', '2010-08-15 15:53:38', 1, '2010-08-15 15:53:38', 1, 0, 10, 68, '', '', 0, '', ''),
(78, 'workflow.php', 1, 'WorkFlow Setting', '2010-08-18 21:04:08', 1, '2010-08-17 09:33:28', 1, 15, 130, 70, '', '', 0, '', ''),
(79, 'printpanelclinicvisitlist.php', 0, 'Print Panelclinic Visit List', '2010-08-18 21:05:32', 1, '2010-08-17 11:43:35', 1, 17, 190, 70, '', '', 0, '', ''),
(80, 'followuptype.php', 1, 'Followup Type', '2010-08-18 21:03:04', 1, '2010-08-17 22:29:02', 1, 15, 80, 70, '', '', 0, 'sim_hr_followuptype', ''),
(81, 'activitytype.php', 1, 'Activity Type', '2010-08-18 21:03:53', 1, '2010-08-18 21:01:31', 1, 15, 110, 70, '', '', 0, 'sim_hr_ativitytype', ''),
(116, '', 1, 'Master Data', '2010-08-01 10:25:24', 1, '2010-08-01 10:25:24', 1, 0, 10, 80, '', '', 0, '', ''),
(117, 'financialyear.php', 1, 'Financial Year', '2010-08-01 10:26:00', 1, '2010-08-01 10:26:00', 1, 116, 10, 80, '', '', 0, 'sim_simbiz_financialyear', ''),
(118, '', 1, 'Transaction', '2010-08-28 17:36:50', 1, '2010-08-01 10:26:50', 1, 0, 20, 80, '', '', 0, '', ''),
(119, 'batch.php', 1, 'Journal Entry', '2010-08-01 10:27:21', 1, '2010-08-01 10:27:21', 1, 118, 10, 80, '', '', 0, 'sim_simbiz_batch', ''),
(120, 'payment.php', 0, 'Payment Voucher', '2010-08-01 17:10:42', 1, '2010-08-01 10:28:05', 1, 118, 400, 80, '', '', 0, 'sim_simbiz_paymentvoucher', ''),
(121, 'accounts.php', 1, 'Chart Of Accounts', '2010-08-01 12:38:06', 1, '2010-08-01 12:38:06', 1, 116, 10, 80, '', '', 0, 'sim_simbiz_accounts', ''),
(122, 'accountgroup.php', 0, 'Account Group', '2010-08-01 17:10:22', 1, '2010-08-01 12:38:39', 1, 116, 10, 80, '', '', 0, 'sim_simbiz_accountgroup', ''),
(123, 'tax.php', 0, 'Tax', '2010-08-01 17:10:10', 1, '2010-08-01 12:38:59', 1, 116, 10, 80, '', '', 0, 'sim_simbiz_tax', ''),
(124, 'debitcreditnote.php', 0, 'Debit/Credit Note', '2010-08-01 17:10:46', 1, '2010-08-01 12:39:35', 1, 118, 10, 80, '', '', 0, '', ''),
(125, 'receipt.php', 0, 'Receipt', '2010-08-01 17:10:36', 1, '2010-08-01 12:39:54', 1, 118, 10, 80, '', '', 0, '390', ''),
(126, 'invoice.php', 0, 'Sales/Purchase Invoice', '2010-08-01 17:10:39', 1, '2010-08-01 12:40:31', 1, 118, 10, 80, '', '', 0, 'sim_simbiz_invoice.php', ''),
(127, 'viewtrialbalancesummary.php', 0, 'Trial Balance Summary (PDF)', '2010-08-01 12:42:24', 1, '2010-08-01 12:41:07', 1, 128, 110, 80, '', '', 0, '', ''),
(128, '', 1, 'Reports', '2010-08-28 17:37:33', 1, '2010-08-01 12:41:32', 1, 0, 30, 80, '', '', 0, '', ''),
(129, 'viewtrialbalancedetail.php', 0, 'Trial Balance Detail (PDF)', '2010-08-01 12:42:21', 1, '2010-08-01 12:41:55', 1, 128, 10, 80, '', '', 0, '', ''),
(130, 'ledgerreport.php', 1, 'Ledger Report', '2010-08-01 12:42:15', 1, '2010-08-01 12:42:15', 1, 128, 140, 80, '', '', 0, '', ''),
(131, 'trialbalancereport.php', 1, 'Trial Balance Report', '2010-08-01 12:42:46', 1, '2010-08-01 12:42:46', 1, 128, 145, 80, '', '', 0, '', ''),
(132, 'incomestatement.php', 1, 'Income Statement', '2010-08-01 12:43:06', 1, '2010-08-01 12:43:06', 1, 128, 150, 80, '', '', 0, '', ''),
(133, 'balancesheet.php', 1, 'Balance Sheet', '2010-08-01 12:43:24', 1, '2010-08-01 12:43:24', 1, 128, 160, 80, '', '', 0, '', ''),
(134, 'viewsingleledger.php', 0, 'Single Ledger Report (PDF)', '2010-08-01 12:43:54', 1, '2010-08-01 12:43:54', 1, 128, 190, 80, '', '', 0, '', ''),
(135, 'viewmultiledger.php', 0, 'Multi Ledger Report(PDF)', '2010-08-01 12:44:13', 1, '2010-08-01 12:44:13', 1, 128, 200, 80, '', '', 0, '', ''),
(136, 'viewdebtorledger.php', 0, 'Debtor Ledger Report (PDF)', '2010-08-01 12:44:35', 1, '2010-08-01 12:44:35', 1, 128, 210, 80, '', '', 0, '', ''),
(137, 'viewcreditorledger.php', 0, 'Creditor Ledger Report(PDF)', '2010-08-01 12:44:57', 1, '2010-08-01 12:44:57', 1, 128, 220, 80, '', '', 0, '', ''),
(138, 'bpartnerstatement.php', 1, 'Business Partner Statement Report', '2010-08-01 12:45:30', 1, '2010-08-01 12:45:30', 1, 128, 270, 80, '', '', 0, '', ''),
(139, 'viewbpartnerstatement.php', 0, 'Business Partner Statement Report(PDF)', '2010-08-01 12:46:01', 1, '2010-08-01 12:46:01', 1, 128, 280, 80, '', '', 0, '', ''),
(140, 'viewincomestatement_singlecol.php', 0, 'Single Period Income Statement (PDF)', '2010-08-01 12:46:25', 1, '2010-08-01 12:46:25', 1, 128, 310, 80, '', '', 0, '', ''),
(141, 'viewincomestatement_duocol.php', 0, 'Income Statement (PDF Compare 2 month)', '2010-08-01 12:46:52', 1, '2010-08-01 12:46:52', 1, 128, 320, 80, '', '', 0, '', ''),
(142, 'viewincomestatement_duocol.php', 0, 'Income Statement (PDF Compare 2 month)', '2010-08-01 12:47:13', 1, '2010-08-01 12:47:13', 1, 128, 320, 80, '', '', 0, '', ''),
(143, '', 0, 'Income Statement (Compare multi period)', '2010-08-01 12:47:32', 1, '2010-08-01 12:47:32', 1, 128, 330, 80, '', '', 0, '', ''),
(144, 'htmlincomestatement_chartgenerator.php', 0, 'Income Statement (Chart Generator)', '2010-08-01 12:47:54', 1, '2010-08-01 12:47:54', 1, 128, 340, 80, '', '', 0, '', ''),
(145, 'viewbalancesheet_singlecol.php', 0, 'Balance Sheet (Single Period PDF)', '2010-08-01 12:48:13', 1, '2010-08-01 12:48:13', 1, 128, 350, 80, '', '', 0, '', ''),
(146, 'viewbalancesheet_duocol.php', 0, 'Balance Sheet (Duol Period PDF)', '2010-08-01 12:48:52', 1, '2010-08-01 12:48:52', 1, 128, 360, 80, '', '', 0, '', ''),
(148, 'viewdebitcreditnote.php', 0, 'Debit/Credit Note (PDF)', '2010-08-01 12:49:54', 1, '2010-08-01 12:49:54', 1, 128, 400, 80, '', '', 0, '', ''),
(149, 'viewbankreconcilationreport.php', 0, 'Bank Reconcilation Report', '2010-08-01 12:50:19', 1, '2010-08-01 12:50:19', 1, 128, 420, 80, '', '', 0, '', ''),
(150, 'bankreconcilation.php', 1, 'Bank Reconcilation', '2010-08-01 12:50:52', 1, '2010-08-01 12:50:52', 1, 118, 410, 80, '', '', 0, '', ''),
(151, 'htmlbalancesheet_chartgenerator.php', 0, 'HTML Balance Sheet (Chart Generator)', '2010-08-01 12:51:40', 1, '2010-08-01 12:51:40', 1, 128, 560, 80, '', '', 0, '', ''),
(152, 'viewtransaction.php', 1, 'Transaction Report', '2010-08-01 12:52:12', 1, '2010-08-01 12:52:12', 1, 128, 530, 80, '', '', 0, '', ''),
(153, 'chartsalesexpenses_6month.php', 0, 'Chart for 6 months Sales and Expenses', '2010-08-01 12:52:41', 1, '2010-08-01 12:52:31', 1, 128, 510, 80, '', '', 0, '', ''),
(154, 'chartretainearning_6month.php', 0, 'Chart for 6 months Profit and Lost', '2010-08-01 12:53:04', 1, '2010-08-01 12:53:04', 1, 128, 520, 80, '', '', 0, '', ''),
(155, 'viewinvoice.php', 0, 'Invoice (PDF)', '2010-08-01 12:53:32', 1, '2010-08-01 12:53:32', 1, 128, 10480, 80, '', '', 0, '', ''),
(156, 'viewprintcheque.php', 0, 'Print Cheque (PDF)', '2010-08-01 12:53:54', 1, '2010-08-01 12:53:54', 1, 128, 460, 80, '', '', 0, '', ''),
(157, 'viewpaymentvoucher.php', 0, 'Payment Voucher (PDF)', '2010-08-01 12:54:13', 1, '2010-08-01 12:54:13', 1, 128, 450, 80, '', '', 0, '', ''),
(158, 'viewreceipt.php', 0, 'Preview Receipt (PDF)', '2010-08-01 12:54:43', 1, '2010-08-01 12:54:34', 1, 128, 430, 80, '', '', 0, '', ''),
(159, 'htmlincomestatement_multipleperiod.php', 0, 'HTML Income Statement', '2010-08-01 20:06:54', 1, '2010-08-01 20:06:54', 1, 128, 510, 80, '', '', 0, '', ''),
(160, 'htmlbalancesheet_multipleperiod.php', 0, 'HTML Balance Sheet Multiple Period', '2010-08-01 20:14:30', 1, '2010-08-01 20:14:05', 1, 128, 565, 80, '', '', 0, '', '');

-- --------------------------------------------------------

--
-- Table structure for table `sim_workflow`
--

CREATE TABLE IF NOT EXISTS `sim_workflow` (
  `workflow_id` int(11) NOT NULL AUTO_INCREMENT,
  `workflow_code` varchar(10) NOT NULL,
  `workflow_name` varchar(100) NOT NULL DEFAULT '',
  `isactive` smallint(1) NOT NULL,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updatedby` int(11) NOT NULL DEFAULT '0',
  `created` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `createdby` int(11) NOT NULL DEFAULT '0',
  `workflow_description` varchar(255) NOT NULL DEFAULT '',
  `workflow_owneruid` mediumint(8) NOT NULL DEFAULT '0',
  `workflow_ownergroup` smallint(5) NOT NULL DEFAULT '0',
  `workflow_email` text NOT NULL,
  `isdeleted` smallint(6) NOT NULL,
  `organization_id` int(11) NOT NULL,
  PRIMARY KEY (`workflow_id`),
  UNIQUE KEY `workflow_code` (`workflow_code`),
  KEY `organization_id` (`organization_id`),
  KEY `workflow_owneruid` (`workflow_owneruid`,`workflow_ownergroup`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `sim_workflow`
--

INSERT INTO `sim_workflow` (`workflow_id`, `workflow_code`, `workflow_name`, `isactive`, `updated`, `updatedby`, `created`, `createdby`, `workflow_description`, `workflow_owneruid`, `workflow_ownergroup`, `workflow_email`, `isdeleted`, `organization_id`) VALUES
(0, '', '', 1, '2010-06-18 15:53:31', 0, '0000-00-00 00:00:00', 0, '', 0, 0, '', 0, 0),
(1, 'LEAVE', 'Leave Application', 1, '2010-08-18 10:56:33', 1, '0000-00-00 00:00:00', 0, 'leave workflow', 0, 0, 'marhan@simit.com.my', 0, 1),
(3, 'OT', 'Overtime Application', 1, '2010-08-18 10:56:33', 1, '2010-06-22 12:20:25', 1, 'overtime workflow', 0, 0, 'adminhr@simit.com.my', 0, 1),
(4, 'GENERCLAIM', 'General Claim Application', 1, '2010-08-18 10:56:33', 1, '2010-06-22 15:22:29', 1, 'general claim workflow', 0, 0, 'lister@simit.com.my', 0, 1),
(6, 'FEEDBACK', 'Student Feedback ', 1, '2010-08-18 10:56:33', 1, '2010-06-22 16:37:12', 1, 'feedback', 0, 0, '', 0, 1),
(8, 'LEAVEADJ', 'Leave Adjustment', 1, '2010-08-18 10:56:33', 1, '2010-07-23 17:13:38', 1, 'leave adjustment', 0, 0, '', 0, 1),
(9, 'OVERCLAIM', 'Overtime Claim Application', 1, '2010-08-18 10:56:33', 1, '2010-07-24 19:01:06', 1, 'overtime claim workflow', 0, 0, '', 0, 1),
(10, 'MEDICCLAIM', 'Medical Claim Application', 1, '2010-08-18 10:56:33', 1, '2010-07-24 19:01:06', 1, 'medical claim workflow', 0, 0, '', 0, 1),
(11, 'TRAVECLAIM', 'Travelling Claim Application', 1, '2010-08-18 10:56:33', 1, '2010-07-24 19:01:06', 1, 'travelling claim workflow', 0, 0, '', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `sim_workflownode`
--

CREATE TABLE IF NOT EXISTS `sim_workflownode` (
  `workflownode_id` int(11) NOT NULL AUTO_INCREMENT,
  `workflow_id` int(11) NOT NULL DEFAULT '0',
  `workflowstatus_id` int(11) NOT NULL DEFAULT '0',
  `workflowuserchoice_id` int(11) NOT NULL DEFAULT '0',
  `target_groupid` smallint(5) NOT NULL DEFAULT '0',
  `target_uid` mediumint(8) NOT NULL DEFAULT '0',
  `targetparameter_name` text,
  `email_list` text,
  `sms_list` text,
  `email_subject` text NOT NULL,
  `email_body` text,
  `sms_body` text,
  `isemail` smallint(6) NOT NULL DEFAULT '0',
  `issms` smallint(6) NOT NULL DEFAULT '0',
  `parentnode_id` int(11) NOT NULL DEFAULT '0',
  `sequence_no` int(11) NOT NULL DEFAULT '0',
  `workflow_procedure` varchar(100) NOT NULL DEFAULT '',
  `workflow_sql` text NOT NULL,
  `workflow_bypass` text NOT NULL,
  `parameter_used` text,
  `isactive` smallint(1) NOT NULL,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updatedby` int(11) NOT NULL DEFAULT '0',
  `created` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `createdby` int(11) NOT NULL DEFAULT '0',
  `workflow_description` varchar(255) NOT NULL DEFAULT '',
  `organization_id` int(11) NOT NULL,
  `hyperlink` text NOT NULL,
  `issubmit_node` smallint(1) NOT NULL DEFAULT '1',
  `iscomplete_node` smallint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`workflownode_id`),
  KEY `organization_id` (`organization_id`),
  KEY `workflow_id` (`workflow_id`),
  KEY `target_groupid` (`target_groupid`),
  KEY `target_uid` (`target_uid`),
  KEY `workflowstatus_id` (`workflowstatus_id`),
  KEY `workflowuserchoice_id` (`workflowuserchoice_id`),
  KEY `parentnode_id` (`parentnode_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=39 ;

--
-- Dumping data for table `sim_workflownode`
--

INSERT INTO `sim_workflownode` (`workflownode_id`, `workflow_id`, `workflowstatus_id`, `workflowuserchoice_id`, `target_groupid`, `target_uid`, `targetparameter_name`, `email_list`, `sms_list`, `email_subject`, `email_body`, `sms_body`, `isemail`, `issms`, `parentnode_id`, `sequence_no`, `workflow_procedure`, `workflow_sql`, `workflow_bypass`, `parameter_used`, `isactive`, `updated`, `updatedby`, `created`, `createdby`, `workflow_description`, `organization_id`, `hyperlink`, `issubmit_node`, `iscomplete_node`) VALUES
(0, 0, 0, 0, 0, 0, NULL, NULL, NULL, '', NULL, NULL, 0, 0, 0, 0, '', '', '', NULL, 1, '2010-07-20 12:45:18', 0, '0000-00-00 00:00:00', 0, '', 0, '', 1, 0),
(6, 3, 1, 1, 35, 28, '1', '2', '3', '', '5', '6', 1, 1, 0, 1, '4', '', '', '9', 1, '2010-07-20 12:45:18', 1, '2010-06-28 15:04:14', 1, '7', 0, '', 1, 0),
(7, 3, 2, 2, 30, 69, 'ok', 'a', '', '', '', '', 1, 1, 6, 110, '', '', '', '', 1, '2010-07-20 12:45:18', 1, '2010-06-28 15:34:08', 1, '', 0, '', 1, 0),
(8, 3, 4, 2, 31, 69, '', '', '', '', '', '', 1, 1, 6, 120, '', '', '', '', 1, '2010-07-20 12:45:18', 1, '2010-06-28 15:35:22', 1, '', 0, '', 1, 0),
(9, 4, 1, 0, 1, 0, '{hod_uid}', '{own_uid},{hod_uid}', '', '', '{approvalling}\nTotal Amount : {total_amount}\n{detail}\n', '{approvalling}\nTotal Amount : {total_amount}\n{detail}\n', 1, 0, 0, 1, '', ',issubmit=1', '', '', 1, '2010-08-19 19:53:09', 1, '2010-06-28 16:27:02', 1, '{approvalling}\nTotal Amount : {total_amount}\n{detail}\n', 0, '../hr/generalclaim.php', 1, 0),
(10, 1, 1, 0, 1, 0, '{hod_uid}', '{own_uid},{hod_uid}', '{hod_uid}', '', '{approvalling}\nLeave Date : {leave_apply_date}\nReasons : {leave_reasons}\n', '{approvalling}\nLeave Date : {leave_apply_date}\nReasons : {leave_reasons}\n', 1, 1, 0, 10, '', '', '', '', 1, '2010-08-19 19:14:44', 1, '2010-07-05 14:50:14', 1, 'Leave Date : {leave_apply_date}\nReasons : {leave_reasons}\n', 0, '../hr/leave.php', 1, 0),
(11, 1, 2, 1, 1, 0, '{hod_uid}', '', '', '', '', '', 1, 0, 10, 10, '', '', '{bypassapprove}', '', 1, '2010-08-19 20:08:17', 1, '2010-07-06 10:01:53', 1, '', 0, '../hr/leave.php', 1, 1),
(12, 1, 4, 2, 1, 0, '{hod_uid}', '', '', '', '', '', 1, 0, 10, 10, '', '', '', '', 1, '2010-08-19 20:08:25', 1, '2010-07-06 10:02:11', 1, '', 0, '../hr/leave.php', 1, 1),
(13, 1, 5, 3, 1, 0, '{own_uid}', '', '', '', '', '', 0, 0, 10, 10, '', ', issubmit = 0', '{bypassapprove}', '', 1, '2010-08-19 18:41:40', 1, '2010-07-06 10:06:13', 1, '', 0, '../hr/leave.php', 0, 0),
(19, 4, 2, 1, 1, 0, '{hod_uid}', '{hod_uid}', '{hod_uid}', '', '', '', 1, 0, 9, 10, '', ',iscomplete=1', '', '', 1, '2010-08-19 20:08:43', 1, '2010-07-20 17:08:23', 1, 'Claim for {claim_details}', 0, '../hr/generalclaim.php', 1, 1),
(20, 4, 4, 2, 1, 0, '{hod_uid}', '{hod_uid}', '{hod_uid}', '', '', '', 1, 0, 9, 10, '', ',iscomplete=1', '', '', 1, '2010-08-19 20:08:34', 1, '2010-07-20 18:48:40', 1, '', 0, '../hr/generalclaim.php', 1, 1),
(21, 8, 1, 0, 1, 0, '{hod_uid}', '{own_uid},{hod_uid}', '{own_uid},{hod_uid}', '', '{approvalling}\n{detail}', '{approvalling}\n{detail}', 1, 0, 0, 10, '', ',issubmit=1', '', '', 1, '2010-08-19 19:11:42', 1, '2010-07-23 17:14:33', 1, '{approvalling}\n{detail}', 0, '../hr/leaveadjustment.php', 1, 0),
(22, 8, 2, 1, 1, 0, '{hod_uid}', '{hod_uid}', '{hod_uid}', '', '', '', 1, 0, 21, 10, '', ',issubmit=1,iscomplete=1', '', '', 1, '2010-08-19 20:09:12', 1, '2010-07-23 17:15:10', 1, '', 0, '../hr/leaveadjustment.php', 1, 1),
(23, 8, 4, 2, 1, 0, '{hod_uid}', '{hod_uid}', '{hod_uid}', '', '', '', 1, 0, 21, 10, '', ',issubmit=1,iscomplete=1', '', '', 1, '2010-08-19 20:08:56', 1, '2010-07-23 17:15:44', 1, '', 0, '', 1, 1),
(24, 8, 5, 3, 1, 0, '{own_uid}', '', '', '', '', '', 0, 0, 21, 10, '', ',issubmit=0,iscomplete=0', '', '', 1, '2010-08-19 09:07:29', 1, '2010-07-24 16:24:22', 1, '', 0, '../hr/leaveadjustment.php', 0, 0),
(25, 10, 1, 0, 1, 0, '{hod_uid}', '{own_uid},{hod_uid}', '{own_uid},{hod_uid}', '', '{approvalling}\nClinic Name : {clinic_name}\nTreatment for : {treatment}\nTotal Amount : {total_amount}', '{approvalling}\nClinic Name : {clinic_name}\nTreatment for : {treatment}\nTotal Amount : {total_amount}', 1, 0, 0, 10, '../hr/medicalclaim.php', ',issubmit=1', '', '', 1, '2010-08-19 19:15:06', 1, '2010-07-24 22:00:11', 1, 'Clinic Name : {clinic_name}\nTreatment for : {treatment}\nTotal Amount : {total_amount}\n', 0, '../hr/medicalclaim.php', 1, 0),
(26, 10, 2, 1, 1, 0, '{hod_uid}', '{hod_uid}', '{hod_uid}', '', '', '', 1, 0, 25, 10, '', ',issubmit=1,iscomplete=1', '', '', 1, '2010-08-19 20:05:41', 1, '2010-07-24 22:01:34', 1, '', 0, '../hr/medicalclaim.php', 1, 1),
(27, 9, 1, 0, 1, 0, '{hod_uid}', '{own_uid},{hod_uid}', '', '', '{approvalling}\nTotal Hours : {total_hour}\n{detail}', '{approvalling}\nTotal Hours : {total_hour}\n{detail}', 1, 0, 0, 10, '', ',issubmit=1', '', '', 1, '2010-08-19 19:56:02', 1, '2010-07-24 22:01:52', 1, 'Total Hours : {total_hour}\n{detail}', 0, '../hr/overtimeclaim.php', 1, 0),
(28, 9, 2, 1, 1, 0, '{hod_uid}', '{hod_uid}', '{hod_uid}', '', '', '', 1, 1, 27, 10, '', ',issubmit=1,iscomplete=1', '', '', 1, '2010-08-02 18:39:02', 1, '2010-07-24 22:02:23', 1, '', 0, '../hr/overtimeclaim.php', 1, 1),
(29, 9, 4, 2, 1, 0, '{hod_uid}', '{hod_uid}', '', '', '', '', 1, 0, 27, 10, '', ',issubmit=1,iscomplete=1', '', '', 1, '2010-08-17 10:40:25', 1, '2010-07-24 22:02:39', 1, '', 0, '../hr/overtimeclaim.php', 1, 1),
(30, 11, 1, 0, 1, 0, '{hod_uid}', '{own_uid},{hod_uid}', '', '', '{approvalling}\nTotal Amount : {total_amount}\nMode of Transportation : {transportation}\n{detail}', '{approvalling}\nTotal Amount : {total_amount}\nMode of Transportation : {transportation}\n{detail}', 1, 0, 0, 10, '', ',issubmit=1', '', '', 1, '2010-08-19 20:00:24', 1, '2010-07-24 22:10:05', 1, 'Total Amount : {total_amount}\nMode of Transportation : {transportation}\n{detail}', 0, '../hr/travellingclaim.php', 1, 0),
(31, 11, 2, 1, 1, 0, '{hod_uid}', '{hod_uid}', '{hod_uid}', '', '', '', 1, 1, 30, 10, '', ',issubmit=1,iscomplete=1', '', '', 1, '2010-08-02 18:39:37', 1, '2010-07-24 22:11:33', 1, '', 0, '../hr/travellingclaim.php', 1, 1),
(32, 11, 4, 2, 1, 0, '{hod_uid}', '{hod_uid}', '{hod_uid}', '', '', '', 1, 1, 30, 10, '', ',issubmit=1,iscomplete=1', '', '', 1, '2010-08-02 18:40:25', 1, '2010-07-24 22:12:06', 1, '', 0, '../hr/travellingclaim.php', 1, 1),
(33, 10, 4, 2, 1, 0, '{hod_uid}', '{hod_uid}', '{hod_uid}', '', '', '', 1, 0, 25, 10, '', ',issubmit=1,iscomplete=1', '', '', 1, '2010-08-19 20:09:56', 1, '2010-07-24 22:12:31', 1, '', 0, '../hr/medicalclaim.php', 1, 1),
(34, 4, 5, 3, 1, 0, '{own_uid}', '', '', '', '', '', 0, 0, 9, 10, '', ',issubmit = 0, iscomplete = 0', '', '', 1, '2010-08-13 18:14:58', 1, '2010-07-27 12:19:23', 1, '', 0, '', 0, 0),
(35, 11, 5, 3, 0, 0, '{own_uid}', '', '', '', '', '', 0, 0, 30, 10, '', ', issubmit=0, iscomplete=0', '', '', 1, '2010-08-02 17:01:17', 1, '2010-07-27 12:35:16', 1, '', 0, '../hr/travellingclaim.php', 0, 0),
(36, 9, 5, 3, 0, 0, '{own_uid}', '', '', '', '', '', 0, 0, 27, 10, '', ',issubmit=0,iscomplete=0', '', '', 1, '2010-08-17 10:40:08', 1, '2010-07-27 14:03:23', 1, '', 0, '', 0, 0),
(37, 0, 0, 0, 0, 0, '', '', '', '', '', '', 0, 0, 0, 0, '', '', '', '', 1, '2010-07-27 14:03:26', 1, '2010-07-27 14:03:26', 1, '', 0, '', 0, 0),
(38, 10, 5, 3, 1, 0, '{own_uid}', '', '', '', '', '', 0, 0, 25, 10, '', ',issubmit=0,iscomplete=0', '', '', 1, '2010-08-19 09:08:39', 1, '2010-07-27 14:03:57', 1, '', 0, '', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `sim_workflowstatus`
--

CREATE TABLE IF NOT EXISTS `sim_workflowstatus` (
  `workflowstatus_id` int(11) NOT NULL AUTO_INCREMENT,
  `image_path` varchar(100) NOT NULL,
  `workflowstatus_name` varchar(100) NOT NULL DEFAULT '',
  `isactive` smallint(1) NOT NULL,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updatedby` int(11) NOT NULL DEFAULT '0',
  `created` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `createdby` int(11) NOT NULL DEFAULT '0',
  `workflowstatus_description` varchar(255) NOT NULL DEFAULT '',
  `isdeleted` smallint(6) NOT NULL,
  `organization_id` int(11) NOT NULL,
  PRIMARY KEY (`workflowstatus_id`),
  KEY `organization_id` (`organization_id`),
  KEY `workflowstatus_name` (`workflowstatus_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `sim_workflowstatus`
--

INSERT INTO `sim_workflowstatus` (`workflowstatus_id`, `image_path`, `workflowstatus_name`, `isactive`, `updated`, `updatedby`, `created`, `createdby`, `workflowstatus_description`, `isdeleted`, `organization_id`) VALUES
(0, '', '', 1, '2010-06-18 15:54:13', 0, '0000-00-00 00:00:00', 0, '', 0, 0),
(1, '', 'NEW', 1, '2010-06-22 16:17:32', 0, '0000-00-00 00:00:00', 0, '', 0, 1),
(2, '', 'APPROVE', 1, '2010-06-22 16:17:53', 0, '0000-00-00 00:00:00', 0, '', 0, 1),
(3, '', 'COMPLETE', 1, '2010-06-28 15:28:36', 0, '0000-00-00 00:00:00', 0, '', 0, 1),
(4, '', 'REJECT', 1, '2010-06-28 15:35:01', 0, '0000-00-00 00:00:00', 0, '', 0, 1),
(5, '', 'CANCEL', 1, '2010-07-06 10:03:40', 0, '0000-00-00 00:00:00', 0, '', 0, 1),
(6, '', 'RECOMMEND', 1, '2010-08-19 14:10:23', 0, '0000-00-00 00:00:00', 0, 'Recommend', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `sim_workflowtransaction`
--

CREATE TABLE IF NOT EXISTS `sim_workflowtransaction` (
  `workflowtransaction_id` int(11) NOT NULL AUTO_INCREMENT,
  `workflowtransaction_datetime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `target_groupid` smallint(5) NOT NULL DEFAULT '0',
  `target_uid` mediumint(8) NOT NULL DEFAULT '0',
  `targetparameter_name` text,
  `workflowstatus_id` int(11) NOT NULL DEFAULT '0',
  `workflow_id` int(11) NOT NULL DEFAULT '0',
  `tablename` varchar(100) NOT NULL DEFAULT '',
  `primarykey_name` varchar(100) NOT NULL DEFAULT '',
  `primarykey_value` varchar(100) NOT NULL DEFAULT '',
  `hyperlink` varchar(100) NOT NULL DEFAULT '',
  `title_description` text NOT NULL,
  `created` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `createdby` int(11) NOT NULL DEFAULT '0',
  `list_parameter` text NOT NULL,
  `workflowtransaction_description` varchar(255) NOT NULL DEFAULT '',
  `workflowtransaction_feedback` text NOT NULL,
  `iscomplete` smallint(1) NOT NULL DEFAULT '0',
  `email_list` text NOT NULL,
  `sms_list` text NOT NULL,
  `email_body` text NOT NULL,
  `sms_body` text NOT NULL,
  `person_id` int(11) NOT NULL DEFAULT '0',
  `issubmit` smallint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`workflowtransaction_id`),
  KEY `workflow_id` (`workflow_id`),
  KEY `target_groupid` (`target_groupid`),
  KEY `target_uid` (`target_uid`),
  KEY `workflowstatus_id` (`workflowstatus_id`),
  KEY `person_id` (`person_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `sim_workflowtransaction`
--


-- --------------------------------------------------------

--
-- Table structure for table `sim_workflowtransactionhistory`
--

CREATE TABLE IF NOT EXISTS `sim_workflowtransactionhistory` (
  `workflowtransactionhistory_id` int(11) NOT NULL AUTO_INCREMENT,
  `workflowtransaction_id` int(11) NOT NULL DEFAULT '0',
  `workflowstatus_id` int(11) NOT NULL DEFAULT '0',
  `workflowtransaction_datetime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `uid` mediumint(8) NOT NULL DEFAULT '0',
  `workflowtransactionhistory_description` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`workflowtransactionhistory_id`),
  KEY `workflowtransaction_id` (`workflowtransaction_id`),
  KEY `uid` (`uid`),
  KEY `workflowstatus_id` (`workflowstatus_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `sim_workflowtransactionhistory`
--


-- --------------------------------------------------------

--
-- Table structure for table `sim_workflowuserchoice`
--

CREATE TABLE IF NOT EXISTS `sim_workflowuserchoice` (
  `workflowuserchoice_id` int(11) NOT NULL AUTO_INCREMENT,
  `workflowuserchoice_name` varchar(100) NOT NULL DEFAULT '',
  `isactive` smallint(1) NOT NULL,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updatedby` int(11) NOT NULL DEFAULT '0',
  `created` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `createdby` int(11) NOT NULL DEFAULT '0',
  `workflowuserchoice_description` varchar(255) NOT NULL DEFAULT '',
  `isdeleted` smallint(6) NOT NULL,
  `organization_id` int(11) NOT NULL,
  PRIMARY KEY (`workflowuserchoice_id`),
  KEY `organization_id` (`organization_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `sim_workflowuserchoice`
--

INSERT INTO `sim_workflowuserchoice` (`workflowuserchoice_id`, `workflowuserchoice_name`, `isactive`, `updated`, `updatedby`, `created`, `createdby`, `workflowuserchoice_description`, `isdeleted`, `organization_id`) VALUES
(0, '', 0, '2010-06-18 15:54:35', 0, '0000-00-00 00:00:00', 0, '', 0, 0),
(1, 'APPROVE', 1, '2010-07-06 10:42:32', 0, '0000-00-00 00:00:00', 0, '', 0, 1),
(2, 'REJECT', 1, '2010-07-06 10:42:52', 0, '0000-00-00 00:00:00', 0, '', 0, 1),
(3, 'CANCEL', 1, '2010-07-06 10:04:36', 0, '0000-00-00 00:00:00', 0, '', 0, 1),
(4, 'COMPLETE', 1, '2010-07-06 15:20:33', 0, '0000-00-00 00:00:00', 0, '', 0, 1),
(5, 'RECOMMEND', 1, '2010-08-19 14:11:14', 0, '0000-00-00 00:00:00', 0, '', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `sim_workflowuserchoiceline`
--

CREATE TABLE IF NOT EXISTS `sim_workflowuserchoiceline` (
  `workflowuserchoiceline_id` int(11) NOT NULL AUTO_INCREMENT,
  `workflowuserchoiceline_name` varchar(100) NOT NULL DEFAULT '',
  `workflowuserchoice_id` int(11) NOT NULL DEFAULT '0',
  `workflowstatus_id` int(11) NOT NULL DEFAULT '0',
  `isactive` smallint(1) NOT NULL,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updatedby` int(11) NOT NULL DEFAULT '0',
  `created` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `createdby` int(11) NOT NULL DEFAULT '0',
  `workflowuserchoiceline_description` varchar(255) NOT NULL DEFAULT '',
  `isdeleted` smallint(6) NOT NULL,
  PRIMARY KEY (`workflowuserchoiceline_id`),
  KEY `workflowuserchoice_id` (`workflowuserchoice_id`),
  KEY `workflowstatus_id` (`workflowstatus_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `sim_workflowuserchoiceline`
--

INSERT INTO `sim_workflowuserchoiceline` (`workflowuserchoiceline_id`, `workflowuserchoiceline_name`, `workflowuserchoice_id`, `workflowstatus_id`, `isactive`, `updated`, `updatedby`, `created`, `createdby`, `workflowuserchoiceline_description`, `isdeleted`) VALUES
(1, 'Approve', 1, 2, 1, '2010-07-05 17:15:27', 0, '0000-00-00 00:00:00', 0, '', 0),
(2, 'Reject', 2, 4, 1, '2010-07-06 10:45:03', 0, '0000-00-00 00:00:00', 0, '', 0),
(3, 'Cancel', 3, 5, 1, '2010-07-06 10:05:26', 0, '0000-00-00 00:00:00', 0, '', 0),
(4, 'Complete', 4, 3, 1, '2010-07-06 10:46:26', 0, '0000-00-00 00:00:00', 0, '', 0),
(5, 'Recommend', 5, 6, 1, '2010-08-19 14:13:12', 0, '0000-00-00 00:00:00', 0, '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `sim_year`
--

CREATE TABLE IF NOT EXISTS `sim_year` (
  `year_id` int(11) NOT NULL AUTO_INCREMENT,
  `year_name` varchar(20) NOT NULL DEFAULT '',
  `isactive` smallint(1) NOT NULL,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updatedby` int(11) NOT NULL DEFAULT '0',
  `created` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `createdby` int(11) NOT NULL DEFAULT '0',
  `year_description` text,
  PRIMARY KEY (`year_id`),
  UNIQUE KEY `year_name` (`year_name`),
  UNIQUE KEY `year_name_2` (`year_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `sim_year`
--

INSERT INTO `sim_year` (`year_id`, `year_name`, `isactive`, `updated`, `updatedby`, `created`, `createdby`, `year_description`) VALUES
(0, '', 0, '2009-06-09 09:19:46', 0, '0000-00-00 00:00:00', 0, NULL),
(1, '2010', 1, '2010-08-17 11:18:49', 1, '2009-06-09 09:27:15', 1, ''),
(2, '2011', 1, '2010-08-17 11:18:55', 1, '2009-06-09 09:28:34', 1, ''),
(3, '2012', 1, '2010-08-17 11:19:03', 1, '2009-07-01 18:17:38', 1, ''),
(4, '2013', 1, '2010-08-17 11:19:16', 1, '2009-07-01 18:17:47', 1, ''),
(5, '2014', 1, '2010-08-17 11:19:25', 1, '2010-03-06 00:37:12', 1, '');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `sim_bpartner`
--
ALTER TABLE `sim_bpartner`
  ADD CONSTRAINT `sim_bpartner_ibfk_1` FOREIGN KEY (`organization_id`) REFERENCES `sim_organization` (`organization_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sim_bpartner_ibfk_2` FOREIGN KEY (`currency_id`) REFERENCES `sim_currency` (`currency_id`),
  ADD CONSTRAINT `sim_bpartner_ibfk_3` FOREIGN KEY (`terms_id`) REFERENCES `sim_terms` (`terms_id`),
  ADD CONSTRAINT `sim_bpartner_ibfk_4` FOREIGN KEY (`bpartnergroup_id`) REFERENCES `sim_bpartnergroup` (`bpartnergroup_id`);

--
-- Constraints for table `sim_contacts`
--
ALTER TABLE `sim_contacts`
  ADD CONSTRAINT `sim_contacts_ibfk_1` FOREIGN KEY (`bpartner_id`) REFERENCES `sim_bpartner` (`bpartner_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sim_contacts_ibfk_3` FOREIGN KEY (`races_id`) REFERENCES `sim_races` (`races_id`),
  ADD CONSTRAINT `sim_contacts_ibfk_4` FOREIGN KEY (`religion_id`) REFERENCES `sim_religion` (`religion_id`);

--
-- Constraints for table `sim_country`
--
ALTER TABLE `sim_country`
  ADD CONSTRAINT `sim_country_ibfk_1` FOREIGN KEY (`organization_id`) REFERENCES `sim_organization` (`organization_id`) ON DELETE CASCADE;

--
-- Constraints for table `sim_currency`
--
ALTER TABLE `sim_currency`
  ADD CONSTRAINT `sim_currency_ibfk_1` FOREIGN KEY (`country_id`) REFERENCES `sim_country` (`country_id`);

--
-- Constraints for table `sim_followup`
--
ALTER TABLE `sim_followup`
  ADD CONSTRAINT `sim_followup_ibfk_3` FOREIGN KEY (`bpartner_id`) REFERENCES `sim_bpartner` (`bpartner_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sim_followup_ibfk_4` FOREIGN KEY (`followuptype_id`) REFERENCES `sim_followuptype` (`followuptype_id`),
  ADD CONSTRAINT `sim_followup_ibfk_5` FOREIGN KEY (`employee_id`) REFERENCES `sim_hr_employee` (`employee_id`);

--
-- Constraints for table `sim_followuptype`
--
ALTER TABLE `sim_followuptype`
  ADD CONSTRAINT `sim_followuptype_ibfk_1` FOREIGN KEY (`organization_id`) REFERENCES `sim_organization` (`organization_id`) ON DELETE CASCADE;

--
-- Constraints for table `sim_region`
--
ALTER TABLE `sim_region`
  ADD CONSTRAINT `sim_region_ibfk_1` FOREIGN KEY (`country_id`) REFERENCES `sim_country` (`country_id`) ON DELETE CASCADE;

--
-- Constraints for table `sim_simbiz_accountgroup`
--
ALTER TABLE `sim_simbiz_accountgroup`
  ADD CONSTRAINT `sim_simbiz_accountgroup_ibfk_1` FOREIGN KEY (`accountclass_id`) REFERENCES `sim_simbiz_accountclass` (`accountclass_id`),
  ADD CONSTRAINT `sim_simbiz_accountgroup_ibfk_2` FOREIGN KEY (`organization_id`) REFERENCES `sim_organization` (`organization_id`) ON DELETE CASCADE;

--
-- Constraints for table `sim_simbiz_accounts`
--
ALTER TABLE `sim_simbiz_accounts`
  ADD CONSTRAINT `sim_simbiz_accounts_ibfk_2` FOREIGN KEY (`accountgroup_id`) REFERENCES `sim_simbiz_accountgroup` (`accountgroup_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sim_simbiz_accounts_ibfk_5` FOREIGN KEY (`organization_id`) REFERENCES `sim_organization` (`organization_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sim_simbiz_accounts_ibfk_7` FOREIGN KEY (`tax_id`) REFERENCES `sim_simbiz_tax` (`tax_id`);

--
-- Constraints for table `sim_simbiz_bankreconcilation`
--
ALTER TABLE `sim_simbiz_bankreconcilation`
  ADD CONSTRAINT `sim_simbiz_bankreconcilation_ibfk_1` FOREIGN KEY (`accounts_id`) REFERENCES `sim_simbiz_accounts` (`accounts_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sim_simbiz_bankreconcilation_ibfk_3` FOREIGN KEY (`period_id`) REFERENCES `sim_period` (`period_id`),
  ADD CONSTRAINT `sim_simbiz_bankreconcilation_ibfk_4` FOREIGN KEY (`organization_id`) REFERENCES `sim_organization` (`organization_id`) ON DELETE CASCADE;

--
-- Constraints for table `sim_simbiz_batch`
--
ALTER TABLE `sim_simbiz_batch`
  ADD CONSTRAINT `sim_simbiz_batch_ibfk_1` FOREIGN KEY (`organization_id`) REFERENCES `sim_organization` (`organization_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sim_simbiz_batch_ibfk_2` FOREIGN KEY (`period_id`) REFERENCES `sim_period` (`period_id`);

--
-- Constraints for table `sim_simbiz_debitcreditnote`
--
ALTER TABLE `sim_simbiz_debitcreditnote`
  ADD CONSTRAINT `sim_simbiz_debitcreditnote_ibfk_5` FOREIGN KEY (`organization_id`) REFERENCES `sim_organization` (`organization_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sim_simbiz_debitcreditnote_ibfk_6` FOREIGN KEY (`bpartner_id`) REFERENCES `sim_bpartner` (`bpartner_id`),
  ADD CONSTRAINT `sim_simbiz_debitcreditnote_ibfk_7` FOREIGN KEY (`bpartneraccounts_id`) REFERENCES `sim_simbiz_accounts` (`accounts_id`) ON DELETE CASCADE;

--
-- Constraints for table `sim_simbiz_debitcreditnoteline`
--
ALTER TABLE `sim_simbiz_debitcreditnoteline`
  ADD CONSTRAINT `sim_simbiz_debitcreditnoteline_ibfk_1` FOREIGN KEY (`debitcreditnote_id`) REFERENCES `sim_simbiz_debitcreditnote` (`debitcreditnote_id`) ON DELETE CASCADE;

--
-- Constraints for table `sim_simbiz_financialyear`
--
ALTER TABLE `sim_simbiz_financialyear`
  ADD CONSTRAINT `sim_simbiz_financialyear_ibfk_1` FOREIGN KEY (`organization_id`) REFERENCES `sim_organization` (`organization_id`) ON DELETE CASCADE;

--
-- Constraints for table `sim_simbiz_financialyearline`
--
ALTER TABLE `sim_simbiz_financialyearline`
  ADD CONSTRAINT `sim_simbiz_financialyearline_ibfk_1` FOREIGN KEY (`financialyear_id`) REFERENCES `sim_simbiz_financialyear` (`financialyear_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sim_simbiz_financialyearline_ibfk_2` FOREIGN KEY (`period_id`) REFERENCES `sim_period` (`period_id`) ON DELETE CASCADE;

--
-- Constraints for table `sim_simbiz_invoiceline`
--
ALTER TABLE `sim_simbiz_invoiceline`
  ADD CONSTRAINT `sim_simbiz_invoiceline_ibfk_1` FOREIGN KEY (`invoice_id`) REFERENCES `sim_simbiz_invoice` (`invoice_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `sim_simbiz_paymentvoucher`
--
ALTER TABLE `sim_simbiz_paymentvoucher`
  ADD CONSTRAINT `sim_simbiz_paymentvoucher_ibfk_38` FOREIGN KEY (`organization_id`) REFERENCES `sim_organization` (`organization_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sim_simbiz_paymentvoucher_ibfk_39` FOREIGN KEY (`currency_id`) REFERENCES `sim_currency` (`currency_id`),
  ADD CONSTRAINT `sim_simbiz_paymentvoucher_ibfk_40` FOREIGN KEY (`accountsfrom_id`) REFERENCES `sim_simbiz_accounts` (`accounts_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sim_simbiz_paymentvoucher_ibfk_41` FOREIGN KEY (`batch_id`) REFERENCES `sim_simbiz_batch` (`batch_id`);

--
-- Constraints for table `sim_simbiz_paymentvoucherline`
--
ALTER TABLE `sim_simbiz_paymentvoucherline`
  ADD CONSTRAINT `sim_simbiz_paymentvoucherline_ibfk_1` FOREIGN KEY (`paymentvoucher_id`) REFERENCES `sim_simbiz_paymentvoucher` (`paymentvoucher_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sim_simbiz_paymentvoucherline_ibfk_2` FOREIGN KEY (`bpartner_id`) REFERENCES `sim_bpartner` (`bpartner_id`);

--
-- Constraints for table `sim_simbiz_receipt`
--
ALTER TABLE `sim_simbiz_receipt`
  ADD CONSTRAINT `sim_simbiz_receipt_ibfk_10` FOREIGN KEY (`currency_id`) REFERENCES `sim_currency` (`currency_id`),
  ADD CONSTRAINT `sim_simbiz_receipt_ibfk_11` FOREIGN KEY (`accountsfrom_id`) REFERENCES `sim_simbiz_accounts` (`accounts_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sim_simbiz_receipt_ibfk_12` FOREIGN KEY (`batch_id`) REFERENCES `sim_simbiz_batch` (`batch_id`),
  ADD CONSTRAINT `sim_simbiz_receipt_ibfk_13` FOREIGN KEY (`bpartner_id`) REFERENCES `sim_bpartner` (`bpartner_id`),
  ADD CONSTRAINT `sim_simbiz_receipt_ibfk_9` FOREIGN KEY (`organization_id`) REFERENCES `sim_organization` (`organization_id`) ON DELETE CASCADE;

--
-- Constraints for table `sim_simbiz_receiptline`
--
ALTER TABLE `sim_simbiz_receiptline`
  ADD CONSTRAINT `sim_simbiz_receiptline_ibfk_1` FOREIGN KEY (`receipt_id`) REFERENCES `sim_simbiz_receipt` (`receipt_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `sim_simbiz_trackheader`
--
ALTER TABLE `sim_simbiz_trackheader`
  ADD CONSTRAINT `sim_simbiz_trackheader_ibfk_1` FOREIGN KEY (`organization_id`) REFERENCES `sim_organization` (`organization_id`) ON DELETE CASCADE;

--
-- Constraints for table `sim_simbiz_transaction`
--
ALTER TABLE `sim_simbiz_transaction`
  ADD CONSTRAINT `sim_simbiz_transaction_ibfk_20` FOREIGN KEY (`accounts_id`) REFERENCES `sim_simbiz_accounts` (`accounts_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `sim_simbiz_transaction_ibfk_41` FOREIGN KEY (`batch_id`) REFERENCES `sim_simbiz_batch` (`batch_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sim_simbiz_transaction_ibfk_42` FOREIGN KEY (`tax_id`) REFERENCES `sim_simbiz_tax` (`tax_id`),
  ADD CONSTRAINT `sim_simbiz_transaction_ibfk_43` FOREIGN KEY (`currency_id`) REFERENCES `sim_currency` (`currency_id`),
  ADD CONSTRAINT `sim_simbiz_transaction_ibfk_45` FOREIGN KEY (`bpartner_id`) REFERENCES `sim_bpartner` (`bpartner_id`) ON DELETE CASCADE;

--
-- Constraints for table `sim_simbiz_transsummary`
--
ALTER TABLE `sim_simbiz_transsummary`
  ADD CONSTRAINT `sim_simbiz_transsummary_ibfk_1` FOREIGN KEY (`bpartner_id`) REFERENCES `sim_bpartner` (`bpartner_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sim_simbiz_transsummary_ibfk_2` FOREIGN KEY (`accounts_id`) REFERENCES `sim_simbiz_accounts` (`accounts_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sim_simbiz_transsummary_ibfk_3` FOREIGN KEY (`organization_id`) REFERENCES `sim_organization` (`organization_id`) ON DELETE CASCADE;

--
-- Constraints for table `sim_terms`
--
ALTER TABLE `sim_terms`
  ADD CONSTRAINT `sim_terms_ibfk_1` FOREIGN KEY (`organization_id`) REFERENCES `sim_organization` (`organization_id`) ON DELETE CASCADE;

--
-- Constraints for table `sim_workflow`
--
ALTER TABLE `sim_workflow`
  ADD CONSTRAINT `sim_workflow_ibfk_1` FOREIGN KEY (`organization_id`) REFERENCES `sim_organization` (`organization_id`) ON DELETE CASCADE;

--
-- Constraints for table `sim_workflownode`
--
ALTER TABLE `sim_workflownode`
  ADD CONSTRAINT `sim_workflownode_ibfk_1` FOREIGN KEY (`workflow_id`) REFERENCES `sim_workflow` (`workflow_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sim_workflownode_ibfk_2` FOREIGN KEY (`workflowstatus_id`) REFERENCES `sim_workflowstatus` (`workflowstatus_id`),
  ADD CONSTRAINT `sim_workflownode_ibfk_3` FOREIGN KEY (`workflowuserchoice_id`) REFERENCES `sim_workflowuserchoice` (`workflowuserchoice_id`),
  ADD CONSTRAINT `sim_workflownode_ibfk_4` FOREIGN KEY (`parentnode_id`) REFERENCES `sim_workflownode` (`workflownode_id`),
  ADD CONSTRAINT `sim_workflownode_ibfk_5` FOREIGN KEY (`organization_id`) REFERENCES `sim_organization` (`organization_id`) ON DELETE CASCADE;

--
-- Constraints for table `sim_workflowstatus`
--
ALTER TABLE `sim_workflowstatus`
  ADD CONSTRAINT `sim_workflowstatus_ibfk_1` FOREIGN KEY (`organization_id`) REFERENCES `sim_organization` (`organization_id`) ON DELETE CASCADE;

--
-- Constraints for table `sim_workflowtransaction`
--
ALTER TABLE `sim_workflowtransaction`
  ADD CONSTRAINT `sim_workflowtransaction_ibfk_1` FOREIGN KEY (`workflowstatus_id`) REFERENCES `sim_workflowstatus` (`workflowstatus_id`),
  ADD CONSTRAINT `sim_workflowtransaction_ibfk_2` FOREIGN KEY (`workflow_id`) REFERENCES `sim_workflow` (`workflow_id`);

--
-- Constraints for table `sim_workflowtransactionhistory`
--
ALTER TABLE `sim_workflowtransactionhistory`
  ADD CONSTRAINT `sim_workflowtransactionhistory_ibfk_1` FOREIGN KEY (`workflowtransaction_id`) REFERENCES `sim_workflowtransaction` (`workflowtransaction_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sim_workflowtransactionhistory_ibfk_2` FOREIGN KEY (`workflowstatus_id`) REFERENCES `sim_workflowstatus` (`workflowstatus_id`);

--
-- Constraints for table `sim_workflowuserchoice`
--
ALTER TABLE `sim_workflowuserchoice`
  ADD CONSTRAINT `sim_workflowuserchoice_ibfk_1` FOREIGN KEY (`organization_id`) REFERENCES `sim_organization` (`organization_id`) ON DELETE CASCADE;

--
-- Constraints for table `sim_workflowuserchoiceline`
--
ALTER TABLE `sim_workflowuserchoiceline`
  ADD CONSTRAINT `sim_workflowuserchoiceline_ibfk_1` FOREIGN KEY (`workflowuserchoice_id`) REFERENCES `sim_workflowuserchoice` (`workflowuserchoice_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sim_workflowuserchoiceline_ibfk_2` FOREIGN KEY (`workflowstatus_id`) REFERENCES `sim_workflowstatus` (`workflowstatus_id`);

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`simantz`@`localhost` PROCEDURE `fillTree`()
BEGIN

WHILE EXISTS (SELECT * FROM sim_Tree WHERE Depth Is Null) DO
UPDATE sim_Tree T
INNER JOIN sim_Tree P ON (T.ParentNode=P.Node) 
SET T.depth = P.Depth + 1, T.Lineage = concat(P.Lineage, T.ParentNode, '/' )
WHERE P.Depth>=0 
AND P.Lineage Is Not Null 
AND T.Depth Is Null;
END WHILE;

END$$

DELIMITER ;
SET FOREIGN_KEY_CHECKS=1;
