-- phpMyAdmin SQL Dump
-- version 3.2.2.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 05, 2010 at 02:23 PM
-- Server version: 5.1.37
-- PHP Version: 5.2.10-2ubuntu6.4

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
-- Table structure for table `sim_amreview_rate`
--

DROP TABLE IF EXISTS `sim_amreview_rate`;
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

DROP TABLE IF EXISTS `sim_audit`;
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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1878 ;

--
-- Dumping data for table `sim_audit`
--

INSERT INTO `sim_audit` (`tablename`, `changedesc`, `category`, `uid`, `updated`, `record_id`, `eventype`, `uname`, `audit_id`, `ip`, `primarykey`, `controlvalue`) VALUES
('sim_organization', 'currency_id='''',<br/>country_id=''''', 'U', 0, '2010-07-25 15:18:01', 1, 'S', '', 1, '::1', 'organization_id', 'SIMIT'),
('sim_country', 'country_code=''SG''country_name=''Singapore''isactive=''1''seqno=''20''created=''2010-07-25 15:19:14''createdby=''1''updated=''2010-07-25 15:19:14''updatedby=''1''citizenship=''Singaporian', 'I', 1, '2010-07-25 15:19:14', 2, 'S', 'admin', 2, '::1', 'country_id', 'SG'),
('sim_country', 'country_code=''MY''country_name=''Malaysia''isactive=''1''seqno=''10''created=''2010-07-25 15:19:14''createdby=''1''updated=''2010-07-25 15:19:14''updatedby=''1''citizenship=''Malaysian', 'I', 1, '2010-07-25 15:19:14', 3, 'S', 'admin', 3, '::1', 'country_id', 'MY'),
('sim_currency', 'currency_code=''SGD''currency_name=''Singpore Dollar''isactive=''1''seqno=''20''created=''2010-07-25 15:19:45''createdby=''1''updated=''2010-07-25 15:19:45''updatedby=''1''country_id=''2', 'I', 1, '2010-07-25 15:19:45', 2, 'S', 'admin', 4, '::1', 'currency_id', 'SGD'),
('sim_currency', 'currency_code=''MYR''currency_name=''Malaysia Ringgit''isactive=''1''seqno=''10''created=''2010-07-25 15:19:45''createdby=''1''updated=''2010-07-25 15:19:45''updatedby=''1''country_id=''3', 'I', 1, '2010-07-25 15:19:45', 3, 'S', 'admin', 5, '::1', 'currency_id', 'MYR'),
('sim_organization', 'currency_id=''3'',<br/>country_id=''3''', 'U', 0, '2010-07-25 15:20:01', 1, 'S', '', 6, '::1', 'organization_id', 'SIMIT'),
('sim_window', 'mid=''64''windowsetting=''''seqno=''10''description=''''parentwindows_id=''''filename=''''isactive=''1''window_name=''Master Data''created=''2010-07-26 12:31:42''createdby=''1''updated=''2010-07-26 12:31:42''updatedby=''1''table_name=''', 'I', 0, '2010-07-26 12:31:42', 15, 'S', '', 7, '127.0.0.1', 'window_id', 'Master Data'),
('sim_window', 'mid=''64''windowsetting=''''seqno=''10''description=''''parentwindows_id=''''filename=''''isactive=''1''window_name=''Transaction''created=''2010-07-26 12:32:04''createdby=''1''updated=''2010-07-26 12:32:04''updatedby=''1''table_name=''', 'I', 0, '2010-07-26 12:32:04', 16, 'S', '', 8, '127.0.0.1', 'window_id', 'Transaction'),
('sim_window', 'mid=''64''windowsetting=''''seqno=''10''description=''''parentwindows_id=''''filename=''''isactive=''1''window_name=''Reports''created=''2010-07-26 12:32:17''createdby=''1''updated=''2010-07-26 12:32:17''updatedby=''1''table_name=''', 'I', 0, '2010-07-26 12:32:17', 17, 'S', '', 9, '127.0.0.1', 'window_id', 'Reports'),
('sim_window', 'parentwindows_id=''15''', 'U', 0, '2010-07-26 12:39:38', 15, 'S', '', 10, '127.0.0.1', 'window_id', 'Master Data'),
('sim_window', 'seqno=''20'',<br/>parentwindows_id=''15''', 'U', 0, '2010-07-26 12:54:09', 16, 'S', '', 11, '127.0.0.1', 'window_id', 'Transaction'),
('sim_window', 'mid=''64''windowsetting=''''seqno=''10''description=''''parentwindows_id=''15''filename=''employeegroup.php''isactive=''1''window_name=''Employee Group''created=''2010-07-26 12:56:53''createdby=''1''updated=''2010-07-26 12:56:53''updatedby=''1''table_name=''sim_hr_employeegroup', 'I', 0, '2010-07-26 12:56:53', 18, 'S', '', 12, '127.0.0.1', 'window_id', 'Employee Group'),
('sim_window', 'mid=''64''windowsetting=''''seqno=''20''description=''''parentwindows_id=''15''filename=''department.php''isactive=''1''window_name=''Department''created=''2010-07-26 13:34:39''createdby=''1''updated=''2010-07-26 13:34:39''updatedby=''1''table_name=''sim_simedu_department', 'I', 0, '2010-07-26 13:34:39', 19, 'S', '', 13, '127.0.0.1', 'window_id', 'Department'),
('sim_window', 'mid=''64''windowsetting=''''seqno=''30''description=''''parentwindows_id=''15''filename=''jobposition.php''isactive=''1''window_name=''Job Position''created=''2010-07-26 13:35:04''createdby=''1''updated=''2010-07-26 13:35:04''updatedby=''1''table_name=''sim_simedu_jobposition', 'I', 0, '2010-07-26 13:35:04', 20, 'S', '', 14, '127.0.0.1', 'window_id', 'Job Position'),
('sim_window', 'mid=''64''windowsetting=''''seqno=''40''description=''''parentwindows_id=''15''filename=''leavetype.php''isactive=''1''window_name=''leave type''created=''2010-07-26 13:35:27''createdby=''1''updated=''2010-07-26 13:35:27''updatedby=''1''table_name=''sim_simedu_leavetype', 'I', 0, '2010-07-26 13:35:27', 21, 'S', '', 15, '127.0.0.1', 'window_id', 'leave type'),
('sim_window', 'mid=''64''windowsetting=''''seqno=''50''description=''''parentwindows_id=''15''filename=''disciplinetype.php''isactive=''1''window_name=''Discipline Type''created=''2010-07-26 13:35:57''createdby=''1''updated=''2010-07-26 13:35:57''updatedby=''1''table_name=''sim_hr_disciplinetype', 'I', 0, '2010-07-26 13:35:58', 22, 'S', '', 16, '127.0.0.1', 'window_id', 'Discipline Type'),
('sim_window', 'table_name=''sim_hr_leavetype''', 'U', 0, '2010-07-26 13:36:03', 21, 'S', '', 17, '127.0.0.1', 'window_id', 'leave type'),
('sim_window', 'table_name=''sim_hr_jobposition''', 'U', 0, '2010-07-26 13:36:08', 20, 'S', '', 18, '127.0.0.1', 'window_id', 'Job Position'),
('sim_window', 'table_name=''sim_hr_department''', 'U', 0, '2010-07-26 13:36:15', 19, 'S', '', 19, '127.0.0.1', 'window_id', 'Department'),
('sim_window', 'mid=''64''windowsetting=''''seqno=''60''description=''''parentwindows_id=''15''filename=''trainingtype.php''isactive=''1''window_name=''Training Type''created=''2010-07-26 13:36:46''createdby=''1''updated=''2010-07-26 13:36:46''updatedby=''1''table_name=''sim_hr_trainingtype', 'I', 0, '2010-07-26 13:36:47', 23, 'S', '', 20, '127.0.0.1', 'window_id', 'Training Type'),
('sim_window', 'mid=''64''windowsetting=''''seqno=''70''description=''''parentwindows_id=''15''filename=''employee.php''isactive=''1''window_name=''Employee''created=''2010-07-26 13:37:31''createdby=''1''updated=''2010-07-26 13:37:31''updatedby=''1''table_name=''sim_hr_employee', 'I', 0, '2010-07-26 13:37:31', 24, 'S', '', 21, '127.0.0.1', 'window_id', 'Employee'),
('sim_window', 'mid=''64''windowsetting=''''seqno=''10''description=''''parentwindows_id=''16''filename=''panelclinics.php''isactive=''1''window_name=''Panel Clinic Visits''created=''2010-07-26 13:37:54''createdby=''1''updated=''2010-07-26 13:37:54''updatedby=''1''table_name=''', 'I', 0, '2010-07-26 13:37:54', 25, 'S', '', 22, '127.0.0.1', 'window_id', 'Panel Clinic Visits'),
('sim_window', 'mid=''64''windowsetting=''''seqno=''10''description=''''parentwindows_id=''16''filename=''leaveadjustment.php''isactive=''1''window_name=''Leave Adjustment''created=''2010-07-26 13:38:17''createdby=''1''updated=''2010-07-26 13:38:17''updatedby=''1''table_name=''sim_hr_leaveadjustment', 'I', 0, '2010-07-26 13:38:17', 26, 'S', '', 23, '127.0.0.1', 'window_id', 'Leave Adjustment'),
('sim_window', 'mid=''64''windowsetting=''''seqno=''30''description=''''parentwindows_id=''16''filename=''leave.php''isactive=''1''window_name=''Apply Leave''created=''2010-07-26 13:38:41''createdby=''1''updated=''2010-07-26 13:38:41''updatedby=''1''table_name=''sim_hr_leave', 'I', 0, '2010-07-26 13:38:41', 27, 'S', '', 24, '127.0.0.1', 'window_id', 'Apply Leave'),
('sim_window', 'seqno=''20''', 'U', 0, '2010-07-26 13:38:47', 26, 'S', '', 25, '127.0.0.1', 'window_id', 'Leave Adjustment'),
('sim_window', 'mid=''64''windowsetting=''''seqno=''50''description=''''parentwindows_id=''16''filename=''generalclaim.php''isactive=''1''window_name=''General Claim''created=''2010-07-26 13:39:17''createdby=''1''updated=''2010-07-26 13:39:17''updatedby=''1''table_name=''sim_hr_generalclaim', 'I', 0, '2010-07-26 13:39:17', 28, 'S', '', 26, '127.0.0.1', 'window_id', 'General Claim'),
('sim_window', 'mid=''64''windowsetting=''''seqno=''60''description=''''parentwindows_id=''16''filename=''travellingclaim.php''isactive=''1''window_name=''Travelling Claim''created=''2010-07-26 13:39:39''createdby=''1''updated=''2010-07-26 13:39:39''updatedby=''1''table_name=''sim_hr_travellingclaim', 'I', 0, '2010-07-26 13:39:40', 29, 'S', '', 27, '127.0.0.1', 'window_id', 'Travelling Claim'),
('sim_window', 'mid=''64''windowsetting=''''seqno=''70''description=''''parentwindows_id=''16''filename=''medicalclaim.php''isactive=''1''window_name=''Medical Claim''created=''2010-07-26 13:40:03''createdby=''1''updated=''2010-07-26 13:40:03''updatedby=''1''table_name=''sim_hr_medicalclaim', 'I', 0, '2010-07-26 13:40:03', 30, 'S', '', 28, '127.0.0.1', 'window_id', 'Medical Claim'),
('sim_window', 'mid=''64''windowsetting=''''seqno=''80''description=''''parentwindows_id=''16''filename=''overtimeclaim.php''isactive=''1''window_name=''Overtime Claim''created=''2010-07-26 13:40:26''createdby=''1''updated=''2010-07-26 13:40:26''updatedby=''1''table_name=''sim_hr_overtimeclaim', 'I', 0, '2010-07-26 13:40:26', 31, 'S', '', 29, '127.0.0.1', 'window_id', 'Overtime Claim'),
('sim_hr_employeegroup', 'employeegroup_no=''13''employeegroup_name=''ww''islecturer=''1''isovertime=''1''isparttime=''1''isactive=''1''defaultlevel=''10''created=''2010-07-26 16:31:22''createdby=''1''updated=''2010-07-26 16:31:22''updatedby=''1''organization_id=''1''description=''', 'I', 1, '2010-07-26 16:31:22', 10, 'S', '', 30, '127.0.0.1', 'employeegroup_id', '13'),
('sim_hr_employeegroup', 'employeegroup_no=''12''employeegroup_name=''qq''islecturer=''1''isovertime=''1''isparttime=''1''isactive=''1''defaultlevel=''10''created=''2010-07-26 16:31:22''createdby=''1''updated=''2010-07-26 16:31:22''updatedby=''1''organization_id=''1''description=''', 'I', 1, '2010-07-26 16:31:22', 11, 'S', '', 31, '127.0.0.1', 'employeegroup_id', '12'),
('sim_hr_employeegroup', 'islecturer=''0'',<br/>isovertime=''0''', 'U', 1, '2010-07-26 16:31:34', 11, 'S', '', 32, '127.0.0.1', 'employeegroup_id', '12'),
('sim_hr_employeegroup', 'isparttime=''0''', 'U', 1, '2010-07-26 16:31:34', 10, 'S', '', 33, '127.0.0.1', 'employeegroup_id', '13'),
('sim_hr_jobposition', 'jobposition_no=''2''jobposition_name=''BB''isactive=''1''defaultlevel=''10''created=''2010-07-26 17:26:17''createdby=''1''updated=''2010-07-26 17:26:17''updatedby=''1''organization_id=''1''description=''', 'I', 1, '2010-07-26 17:26:17', 52, 'S', '', 34, '127.0.0.1', 'jobposition_id', '2'),
('sim_hr_jobposition', 'jobposition_no=''1''jobposition_name=''AA''isactive=''1''defaultlevel=''10''created=''2010-07-26 17:26:17''createdby=''1''updated=''2010-07-26 17:26:17''updatedby=''1''organization_id=''1''description=''', 'I', 1, '2010-07-26 17:26:17', 53, 'S', '', 35, '127.0.0.1', 'jobposition_id', '1'),
('sim_hr_disciplinetype', 'disciplinetype_name=''AA''isactive=''1''defaultlevel=''10''created=''2010-07-26 17:26:46''createdby=''1''updated=''2010-07-26 17:26:46''updatedby=''1''organization_id=''1''description=''', 'I', 1, '2010-07-26 17:26:46', 14, 'S', '', 36, '127.0.0.1', 'disciplinetype_id', 'AA'),
('sim_hr_disciplinetype', 'disciplinetype_name=''VB''isactive=''1''defaultlevel=''10''created=''2010-07-26 17:26:46''createdby=''1''updated=''2010-07-26 17:26:46''updatedby=''1''organization_id=''1''description=''', 'I', 1, '2010-07-26 17:26:46', 15, 'S', '', 37, '127.0.0.1', 'disciplinetype_id', 'VB'),
('sim_hr_employee', 'employee_name=''asda''employee_cardno=''''employee_no=''1312''uid=''''place_dob=''''employee_dob=''2010-07-01''races_id=''0''religion_id=''0''gender=''M''marital_status=''S''employee_citizenship=''2''employee_newicno=''''employee_oldicno=''''ic_color=''B''employee_passport=''''employee_bloodgroup=''''department_id=''''jobposition_id=''''employeegroup_id=''11''employee_joindate=''2010-07-26''filephoto=''''created=''2010-07-26 17:59:56''createdby=''1''updated=''2010-07-26 17:59:56''updatedby=''1''defaultlevel=''''organization_id=''''employee_transport=''''employee_status=''1', 'I', 1, '2010-07-26 17:59:56', 14, 'S', '', 38, '127.0.0.1', 'employee_id', 'asda'),
('sim_hr_employee', 'employee_name=''WW''employee_cardno=''''employee_no=''ew''uid=''''place_dob=''''employee_dob=''2010-07-14''races_id=''0''religion_id=''0''gender=''M''marital_status=''S''employee_citizenship=''3''employee_newicno=''''employee_oldicno=''''ic_color=''B''employee_passport=''''employee_bloodgroup=''''department_id=''''jobposition_id=''''employeegroup_id=''10''employee_joindate=''2010-07-26''filephoto=''''created=''2010-07-26 18:01:49''createdby=''1''updated=''2010-07-26 18:01:49''updatedby=''1''defaultlevel=''''organization_id=''''employee_transport=''''employee_status=''1', 'I', 1, '2010-07-26 18:01:49', 15, 'S', '', 39, '127.0.0.1', 'employee_id', 'WW'),
('sim_hr_generalclaim', 'employee_id=''WW(15)''generalclaim_date=''2010-07-26''generalclaim_docno=''sada''generalclaim_remark=''''period_id=''2010(2)''created=''10/07/26 18:13:19''createdby=''admin(1)''updated=''10/07/26 18:13:19''updatedby=''admin(1)''organization_id=''1', 'I', 1, '2010-07-26 18:13:20', 2, 'S', '', 40, '127.0.0.1', 'generalclaim_id', 'sada'),
('sim_hr_generalclaimline', 'generalclaim_id=''2''generalclaimline_date=''1900-01-01''generalclaimline_details=''''generalclaimline_porpose=''''generalclaimline_billno=''''generalclaimline_amount=''011''remarks=''''generalclaimline_acccode=''''created=''2010-07-26 18:13:28''createdby=''1''updated=''2010-07-26 18:13:28''updatedby=''1', 'I', 1, '2010-07-26 18:13:28', 11, 'S', '', 41, '127.0.0.1', 'generalclaimline_id', ''),
('sim_hr_generalclaimline', 'generalclaim_id=''2''generalclaimline_date=''1900-01-01''generalclaimline_details=''''generalclaimline_porpose=''''generalclaimline_billno=''''generalclaimline_amount=''011''remarks=''''generalclaimline_acccode=''''created=''2010-07-26 18:13:28''createdby=''1''updated=''2010-07-26 18:13:28''updatedby=''1', 'I', 1, '2010-07-26 18:13:29', 12, 'S', '', 42, '127.0.0.1', 'generalclaimline_id', ''),
('sim_hr_generalclaim', 'employee_id=''15WW'',<br/>issubmit=''1''', 'U', 1, '2010-07-26 18:14:08', 2, 'S', '', 43, '127.0.0.1', 'generalclaim_id', 'sada'),
('sim_hr_generalclaim', 'issubmit=''0''', 'U', 1, '2010-07-26 18:14:08', 2, 'S', '', 44, '127.0.0.1', 'generalclaim_id', '2'),
('sim_window', 'mid=''65''windowsetting=''''seqno=''10''description=''''parentwindows_id=''''filename=''approvallist.php''isactive=''0''window_name=''Approval List''created=''2010-07-26 18:16:29''createdby=''1''updated=''2010-07-26 18:16:29''updatedby=''1''table_name=''', 'I', 0, '2010-07-26 18:16:29', 32, 'S', '', 45, '192.168.1.202', 'window_id', 'Approval List'),
('sim_hr_generalclaim', 'employee_id=''15WW'',<br/>issubmit=''1''', 'U', 1, '2010-07-26 18:16:54', 2, 'S', '', 46, '127.0.0.1', 'generalclaim_id', 'sada'),
('sim_workflowtransaction', 'workflowtransaction_datetime=''10/07/26 18:16:54''target_groupid=''25''target_uid=''1''targetparameter_name=''''workflowstatus_id=''1''workflow_id=''4''tablename=''sim_hr_generalclaim''primarykey_name=''generalclaim_id''primarykey_value=''2''hyperlink=''''title_description=''''created=''10/07/26 18:16:54''list_parameter=''''workflowtransaction_description=''Ok done''workflowtransaction_feedback=''''iscomplete=''0''createdby=''1''email_list=''''sms_list=''''email_body=''''sms_body=''''person_id=''15''issubmit=''1', 'I', 1, '2010-07-26 18:16:54', 1, 'S', '', 47, '127.0.0.1', 'workflowtransaction_id', 'sim_hr_generalclaim'),
('sim_workflowtransactionhistory', 'workflowtransaction_id=''1''workflowstatus_id=''1''workflowtransaction_datetime=''10/07/26 18:16:54''uid=''1''workflowtransactionhistory_description=''', 'I', 1, '2010-07-26 18:16:54', 0, 'S', '', 48, '127.0.0.1', 'workflowtransactionhistory_id', ''),
('sim_workflowtransaction', 'workflowtransaction_datetime=''10/07/26 18:17:09''target_groupid=''1''target_uid=''0''targetparameter_name=''''workflowstatus_id=''2''workflow_id=''4''tablename=''sim_hr_generalclaim''primarykey_name=''generalclaim_id''primarykey_value=''2''hyperlink=''../hr/claim.php''title_description=''''created=''10/07/26 18:17:09''list_parameter=''''workflowtransaction_description=''Claim for {claim_details}''workflowtransaction_feedback=''''iscomplete=''1''createdby=''1''email_list=''''sms_list=''''email_body=''''sms_body=''''person_id=''15''issubmit=''1', 'I', 1, '2010-07-26 18:17:09', 2, 'S', '', 49, '127.0.0.1', 'workflowtransaction_id', 'sim_hr_generalclaim'),
('sim_workflowtransactionhistory', 'workflowtransaction_id=''2''workflowstatus_id=''2''workflowtransaction_datetime=''10/07/26 18:17:09''uid=''1''workflowtransactionhistory_description=''', 'I', 1, '2010-07-26 18:17:09', 0, 'S', '', 50, '127.0.0.1', 'workflowtransactionhistory_id', ''),
('sim_hr_generalclaim', 'employee_id=''WW(15)''generalclaim_date=''2010-07-14''generalclaim_docno=''''generalclaim_remark=''''period_id=''2010(2)''created=''10/07/26 18:17:51''createdby=''admin(1)''updated=''10/07/26 18:17:51''updatedby=''admin(1)''organization_id=''1', 'I', 1, '2010-07-26 18:17:51', 3, 'S', '', 51, '127.0.0.1', 'generalclaim_id', ''),
('sim_hr_generalclaim', 'employee_id=''15WW'',<br/>issubmit=''1''', 'U', 1, '2010-07-26 18:18:36', 3, 'S', '', 52, '127.0.0.1', 'generalclaim_id', ''),
('sim_workflowtransaction', 'workflowtransaction_datetime=''10/07/26 18:18:36''target_groupid=''25''target_uid=''1''targetparameter_name=''''workflowstatus_id=''1''workflow_id=''4''tablename=''sim_hr_generalclaim''primarykey_name=''generalclaim_id''primarykey_value=''3''hyperlink=''''title_description=''''created=''10/07/26 18:18:36''list_parameter=''''workflowtransaction_description=''Ok done''workflowtransaction_feedback=''''iscomplete=''0''createdby=''1''email_list=''''sms_list=''''email_body=''''sms_body=''''person_id=''15''issubmit=''1', 'I', 1, '2010-07-26 18:18:36', 3, 'S', '', 53, '127.0.0.1', 'workflowtransaction_id', 'sim_hr_generalclaim'),
('sim_workflowtransactionhistory', 'workflowtransaction_id=''3''workflowstatus_id=''1''workflowtransaction_datetime=''10/07/26 18:18:36''uid=''1''workflowtransactionhistory_description=''', 'I', 1, '2010-07-26 18:18:36', 0, 'S', '', 54, '127.0.0.1', 'workflowtransactionhistory_id', ''),
('sim_hr_leavetype', 'leavetype_name=''WE''adjustment_id=''''isactive=''1''isvalidate=''1''defaultlevel=''10''created=''2010-07-26 18:19:59''createdby=''1''updated=''2010-07-26 18:19:59''updatedby=''1''organization_id=''1''description=''', 'I', 1, '2010-07-26 18:19:59', 8, 'S', '', 55, '127.0.0.1', 'leavetype_id', 'WE'),
('sim_hr_leaveadjustment', 'leavetype_id=''WE(8)''created=''10/07/26 18:20:14''createdby=''admin(1)''updated=''10/07/26 18:20:14''updatedby=''admin(1)''organization_id=''1', 'I', 1, '2010-07-26 18:20:14', 4, 'S', '', 56, '127.0.0.1', 'leaveadjustment_id', 'admin'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''4''employee_id=''14''leaveadjustmentline_totalday=''2''created=''2010-07-26 18:20:14''createdby=''1''updated=''2010-07-26 18:20:14''updatedby=''1', 'I', 1, '2010-07-26 18:20:14', 317, 'S', '', 57, '127.0.0.1', 'leaveadjustmentline_id', '4'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''4''employee_id=''15''leaveadjustmentline_totalday=''2''created=''2010-07-26 18:20:14''createdby=''1''updated=''2010-07-26 18:20:14''updatedby=''1', 'I', 1, '2010-07-26 18:20:14', 318, 'S', '', 58, '127.0.0.1', 'leaveadjustmentline_id', '4'),
('sim_hr_leaveadjustment', 'issubmit=''1''', 'U', 1, '2010-07-26 18:20:24', 4, 'S', '', 59, '127.0.0.1', 'leaveadjustment_id', '4'),
('sim_workflowtransaction', 'workflowtransaction_datetime=''10/07/26 18:20:24''target_groupid=''1''target_uid=''1''targetparameter_name=''''workflowstatus_id=''1''workflow_id=''8''tablename=''sim_hr_leaveadjustment''primarykey_name=''leaveadjustment_id''primarykey_value=''4''hyperlink=''''title_description=''''created=''10/07/26 18:20:24''list_parameter=''''workflowtransaction_description=''''workflowtransaction_feedback=''''iscomplete=''1''createdby=''1''email_list=''''sms_list=''''email_body=''''sms_body=''''person_id=''10/07/26 18:20:24''issubmit=''1', 'I', 1, '2010-07-26 18:20:24', 4, 'S', '', 60, '127.0.0.1', 'workflowtransaction_id', 'sim_hr_leaveadjustment'),
('sim_workflowtransactionhistory', 'workflowtransaction_id=''4''workflowstatus_id=''1''workflowtransaction_datetime=''10/07/26 18:20:24''uid=''1''workflowtransactionhistory_description=''', 'I', 1, '2010-07-26 18:20:24', 0, 'S', '', 61, '127.0.0.1', 'workflowtransactionhistory_id', ''),
('sim_hr_leavetype', 'isvalidate=''0''', 'U', 1, '2010-07-26 18:22:00', 8, 'S', '', 62, '127.0.0.1', 'leavetype_id', 'WE'),
('sim_hr_leave', 'leave_no=''''leave_date=''2010-07-26''employee_id=''asda(14)''leave_fromdate=''2010-07-29''leave_todate=''2010-07-30''leave_day=''2''time_from=''08:00:00''time_to=''08:00:00''total_hours=''00:00:00''leave_address=''''leave_telno=''''leavetype_id=''WE(8)''lecturer_remarks=''''description=''sasd''created=''10/07/26 18:22:23''createdby=''1''updated=''10/07/26 18:22:23''updatedby=''1''organization_id=''1''panelclinic_id=''0''table_type=''L', 'I', 1, '2010-07-26 18:22:23', 19, 'S', '', 63, '192.168.1.202', 'leave_id', ''),
('sim_hr_leave', 'issubmit=''1''', 'U', 1, '2010-07-26 18:22:26', 19, 'S', '', 64, '192.168.1.202', 'leave_id', ''),
('sim_workflowtransaction', 'workflowtransaction_datetime=''10/07/26 18:22:26''target_groupid=''1''target_uid=''20''targetparameter_name=''10''workflowstatus_id=''1''workflow_id=''1''tablename=''sim_hr_leave''primarykey_name=''leave_id''primarykey_value=''19''hyperlink=''../hr/leave.php''title_description=''''created=''10/07/26 18:22:26''list_parameter=''''workflowtransaction_description=''Leave Date : 2010-07-29-2010-07-30<br/>\nReasons : sasd\n''workflowtransaction_feedback=''''iscomplete=''0''createdby=''1''email_list=''1,10''sms_list=''1,10''email_body=''''sms_body=''''person_id=''14''issubmit=''1', 'I', 1, '2010-07-26 18:22:26', 5, 'S', '', 65, '192.168.1.202', 'workflowtransaction_id', 'sim_hr_leave'),
('sim_workflowtransactionhistory', 'workflowtransaction_id=''5''workflowstatus_id=''1''workflowtransaction_datetime=''10/07/26 18:22:26''uid=''1''workflowtransactionhistory_description=''', 'I', 1, '2010-07-26 18:22:26', 0, 'S', '', 66, '192.168.1.202', 'workflowtransactionhistory_id', ''),
('sim_workflownode', 'target_uid='''',<br/>hyperlink=''../hr/generalclaim.php''', 'U', 0, '2010-07-26 18:23:55', 19, 'S', '', 67, '127.0.0.1', 'workflownode_id', '10'),
('sim_hr_travellingclaim', 'employee_id=''WW(15)''travellingclaim_date=''2010-07-12''travellingclaim_docno=''''travellingclaim_remark=''''travellingclaim_transport=''das''period_id=''2010(2)''created=''10/07/26 18:24:34''createdby=''admin(1)''updated=''10/07/26 18:24:34''updatedby=''admin(1)''organization_id=''1', 'I', 1, '2010-07-26 18:24:34', 2, 'S', '', 68, '127.0.0.1', 'travellingclaim_id', ''),
('sim_hr_medicalclaim', 'employee_id=''asda(14)''medicalclaim_date=''2010-07-07''medicalclaim_clinic=''asd''medicalclaim_docno=''asd''medicalclaim_amount=''56''medicalclaim_treatment=''asd''medicalclaim_remark=''''period_id=''2010(2)''created=''10/07/26 18:25:20''createdby=''admin(1)''updated=''10/07/26 18:25:20''updatedby=''admin(1)''organization_id=''1', 'I', 1, '2010-07-26 18:25:20', 2, 'S', '', 69, '192.168.1.202', 'medicalclaim_id', 'asd'),
('sim_hr_medicalclaim', 'issubmit=''1''', 'U', 1, '2010-07-26 18:25:23', 2, 'S', '', 70, '192.168.1.202', 'medicalclaim_id', 'asd'),
('sim_workflowtransaction', 'workflowtransaction_datetime=''10/07/26 18:25:23''target_groupid=''1''target_uid=''1''targetparameter_name=''''workflowstatus_id=''1''workflow_id=''10''tablename=''sim_hr_medicalclaim''primarykey_name=''medicalclaim_id''primarykey_value=''2''hyperlink=''''title_description=''''created=''10/07/26 18:25:23''list_parameter=''''workflowtransaction_description=''''workflowtransaction_feedback=''''iscomplete=''1''createdby=''1''email_list=''''sms_list=''''email_body=''''sms_body=''''person_id=''14''issubmit=''1', 'I', 1, '2010-07-26 18:25:24', 6, 'S', '', 71, '192.168.1.202', 'workflowtransaction_id', 'sim_hr_medicalclaim'),
('sim_workflowtransactionhistory', 'workflowtransaction_id=''6''workflowstatus_id=''1''workflowtransaction_datetime=''10/07/26 18:25:24''uid=''1''workflowtransactionhistory_description=''', 'I', 1, '2010-07-26 18:25:24', 0, 'S', '', 72, '192.168.1.202', 'workflowtransactionhistory_id', ''),
('sim_hr_travellingclaim', 'issubmit=''1''', 'U', 1, '2010-07-26 18:25:45', 2, 'S', '', 73, '127.0.0.1', 'travellingclaim_id', ''),
('sim_workflowtransaction', 'workflowtransaction_datetime=''10/07/26 18:25:45''target_groupid=''1''target_uid=''1''targetparameter_name=''''workflowstatus_id=''1''workflow_id=''11''tablename=''sim_hr_travellingclaim''primarykey_name=''travellingclaim_id''primarykey_value=''2''hyperlink=''''title_description=''''created=''10/07/26 18:25:45''list_parameter=''''workflowtransaction_description=''''workflowtransaction_feedback=''''iscomplete=''1''createdby=''1''email_list=''''sms_list=''''email_body=''''sms_body=''''person_id=''15''issubmit=''1', 'I', 1, '2010-07-26 18:25:45', 7, 'S', '', 74, '127.0.0.1', 'workflowtransaction_id', 'sim_hr_travellingclaim'),
('sim_workflowtransactionhistory', 'workflowtransaction_id=''7''workflowstatus_id=''1''workflowtransaction_datetime=''10/07/26 18:25:45''uid=''1''workflowtransactionhistory_description=''', 'I', 1, '2010-07-26 18:25:45', 0, 'S', '', 75, '127.0.0.1', 'workflowtransactionhistory_id', ''),
('sim_workflownode', 'target_uid='''',<br/>iscomplete_node=''0''', 'U', 0, '2010-07-26 18:27:15', 25, 'S', '', 76, '192.168.1.202', 'workflownode_id', '10'),
('sim_hr_medicalclaim', 'employee_id=''asda(14)''medicalclaim_date=''2010-07-08''medicalclaim_clinic=''as''medicalclaim_docno=''asd''medicalclaim_amount=''22''medicalclaim_treatment=''sdad''medicalclaim_remark=''''period_id=''2010(2)''created=''10/07/26 18:27:40''createdby=''admin(1)''updated=''10/07/26 18:27:40''updatedby=''admin(1)''organization_id=''1', 'I', 1, '2010-07-26 18:27:40', 3, 'S', '', 77, '192.168.1.202', 'medicalclaim_id', 'asd'),
('sim_hr_medicalclaim', 'issubmit=''1''', 'U', 1, '2010-07-26 18:27:42', 3, 'S', '', 78, '192.168.1.202', 'medicalclaim_id', 'asd'),
('sim_workflowtransaction', 'workflowtransaction_datetime=''10/07/26 18:27:42''target_groupid=''1''target_uid=''0''targetparameter_name=''''workflowstatus_id=''1''workflow_id=''10''tablename=''sim_hr_medicalclaim''primarykey_name=''medicalclaim_id''primarykey_value=''3''hyperlink=''''title_description=''''created=''10/07/26 18:27:42''list_parameter=''''workflowtransaction_description=''''workflowtransaction_feedback=''''iscomplete=''0''createdby=''1''email_list=''''sms_list=''''email_body=''''sms_body=''''person_id=''14''issubmit=''1', 'I', 1, '2010-07-26 18:27:43', 8, 'S', '', 79, '192.168.1.202', 'workflowtransaction_id', 'sim_hr_medicalclaim'),
('sim_workflowtransactionhistory', 'workflowtransaction_id=''8''workflowstatus_id=''1''workflowtransaction_datetime=''10/07/26 18:27:43''uid=''1''workflowtransactionhistory_description=''', 'I', 1, '2010-07-26 18:27:43', 0, 'S', '', 80, '192.168.1.202', 'workflowtransactionhistory_id', ''),
('sim_workflownode', 'target_uid='''',<br/>iscomplete_node=''0''', 'U', 0, '2010-07-26 18:28:04', 30, 'S', '', 81, '127.0.0.1', 'workflownode_id', '10'),
('sim_workflownode', 'target_uid='''',<br/>iscomplete_node=''0''', 'U', 0, '2010-07-26 18:28:13', 21, 'S', '', 82, '127.0.0.1', 'workflownode_id', '10'),
('sim_workflownode', 'target_uid='''',<br/>iscomplete_node=''0''', 'U', 0, '2010-07-26 18:28:26', 27, 'S', '', 83, '127.0.0.1', 'workflownode_id', '10'),
('sim_hr_leaveadjustment', 'leavetype_id=''WE(8)''created=''10/07/26 18:28:52''createdby=''admin(1)''updated=''10/07/26 18:28:52''updatedby=''admin(1)''organization_id=''1', 'I', 1, '2010-07-26 18:28:52', 5, 'S', '', 84, '127.0.0.1', 'leaveadjustment_id', 'admin'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''5''employee_id=''14''leaveadjustmentline_totalday=''2''created=''2010-07-26 18:28:52''createdby=''1''updated=''2010-07-26 18:28:52''updatedby=''1', 'I', 1, '2010-07-26 18:28:52', 319, 'S', '', 85, '127.0.0.1', 'leaveadjustmentline_id', '5'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''5''employee_id=''15''leaveadjustmentline_totalday=''2''created=''2010-07-26 18:28:52''createdby=''1''updated=''2010-07-26 18:28:52''updatedby=''1', 'I', 1, '2010-07-26 18:28:52', 320, 'S', '', 86, '127.0.0.1', 'leaveadjustmentline_id', '5'),
('sim_hr_leaveadjustment', 'issubmit=''1''', 'U', 1, '2010-07-26 18:29:15', 5, 'S', '', 87, '127.0.0.1', 'leaveadjustment_id', '5'),
('sim_workflowtransaction', 'workflowtransaction_datetime=''10/07/26 18:29:15''target_groupid=''1''target_uid=''0''targetparameter_name=''''workflowstatus_id=''1''workflow_id=''8''tablename=''sim_hr_leaveadjustment''primarykey_name=''leaveadjustment_id''primarykey_value=''5''hyperlink=''''title_description=''''created=''10/07/26 18:29:15''list_parameter=''''workflowtransaction_description=''''workflowtransaction_feedback=''''iscomplete=''0''createdby=''1''email_list=''''sms_list=''''email_body=''''sms_body=''''person_id=''10/07/26 18:29:15''issubmit=''1', 'I', 1, '2010-07-26 18:29:15', 9, 'S', '', 88, '127.0.0.1', 'workflowtransaction_id', 'sim_hr_leaveadjustment'),
('sim_workflowtransactionhistory', 'workflowtransaction_id=''9''workflowstatus_id=''1''workflowtransaction_datetime=''10/07/26 18:29:15''uid=''1''workflowtransactionhistory_description=''', 'I', 1, '2010-07-26 18:29:15', 0, 'S', '', 89, '127.0.0.1', 'workflowtransactionhistory_id', ''),
('sim_hr_travellingclaim', 'employee_id=''asda(14)''travellingclaim_date=''2010-07-18''travellingclaim_docno=''das''travellingclaim_remark=''''travellingclaim_transport=''das''period_id=''2010(2)''created=''10/07/26 18:29:43''createdby=''admin(1)''updated=''10/07/26 18:29:43''updatedby=''admin(1)''organization_id=''1', 'I', 1, '2010-07-26 18:29:43', 3, 'S', '', 90, '127.0.0.1', 'travellingclaim_id', 'das'),
('sim_hr_travellingclaim', 'issubmit=''1''', 'U', 1, '2010-07-26 18:29:45', 3, 'S', '', 91, '127.0.0.1', 'travellingclaim_id', 'das'),
('sim_workflowtransaction', 'workflowtransaction_datetime=''10/07/26 18:29:45''target_groupid=''1''target_uid=''0''targetparameter_name=''''workflowstatus_id=''1''workflow_id=''11''tablename=''sim_hr_travellingclaim''primarykey_name=''travellingclaim_id''primarykey_value=''3''hyperlink=''''title_description=''''created=''10/07/26 18:29:45''list_parameter=''''workflowtransaction_description=''''workflowtransaction_feedback=''''iscomplete=''0''createdby=''1''email_list=''''sms_list=''''email_body=''''sms_body=''''person_id=''14''issubmit=''1', 'I', 1, '2010-07-26 18:29:45', 10, 'S', '', 92, '127.0.0.1', 'workflowtransaction_id', 'sim_hr_travellingclaim'),
('sim_workflowtransactionhistory', 'workflowtransaction_id=''10''workflowstatus_id=''1''workflowtransaction_datetime=''10/07/26 18:29:45''uid=''1''workflowtransactionhistory_description=''', 'I', 1, '2010-07-26 18:29:45', 0, 'S', '', 93, '127.0.0.1', 'workflowtransactionhistory_id', ''),
('sim_hr_overtimeclaim', 'employee_id=''asda(14)''overtimeclaim_date=''2010-07-13''overtimeclaim_docno=''''overtimeclaim_remark=''''created=''10/07/26 18:29:58''createdby=''admin(1)''updated=''10/07/26 18:29:58''updatedby=''admin(1)''organization_id=''1', 'I', 1, '2010-07-26 18:29:58', 2, 'S', '', 94, '127.0.0.1', 'overtimeclaim_id', ''),
('sim_hr_overtimeclaim', 'issubmit=''1''', 'U', 1, '2010-07-26 18:30:01', 2, 'S', '', 95, '127.0.0.1', 'overtimeclaim_id', ''),
('sim_workflowtransaction', 'workflowtransaction_datetime=''10/07/26 18:30:01''target_groupid=''1''target_uid=''0''targetparameter_name=''''workflowstatus_id=''1''workflow_id=''9''tablename=''sim_hr_overtimeclaim''primarykey_name=''overtimeclaim_id''primarykey_value=''2''hyperlink=''''title_description=''''created=''10/07/26 18:30:01''list_parameter=''''workflowtransaction_description=''''workflowtransaction_feedback=''''iscomplete=''0''createdby=''1''email_list=''''sms_list=''''email_body=''''sms_body=''''person_id=''14''issubmit=''1', 'I', 1, '2010-07-26 18:30:01', 11, 'S', '', 96, '127.0.0.1', 'workflowtransaction_id', 'sim_hr_overtimeclaim'),
('sim_workflowtransactionhistory', 'workflowtransaction_id=''11''workflowstatus_id=''1''workflowtransaction_datetime=''10/07/26 18:30:01''uid=''1''workflowtransactionhistory_description=''', 'I', 1, '2010-07-26 18:30:01', 0, 'S', '', 97, '127.0.0.1', 'workflowtransactionhistory_id', ''),
('sim_workflowtransaction', 'workflowtransaction_datetime=''10/07/26 18:30:31''target_groupid=''1''target_uid=''1''targetparameter_name=''''workflowstatus_id=''2''workflow_id=''9''tablename=''sim_hr_overtimeclaim''primarykey_name=''overtimeclaim_id''primarykey_value=''2''hyperlink=''''title_description=''''created=''10/07/26 18:30:31''list_parameter=''''workflowtransaction_description=''''workflowtransaction_feedback=''sadasd''iscomplete=''1''createdby=''1''email_list=''''sms_list=''''email_body=''''sms_body=''''person_id=''14''issubmit=''1', 'I', 1, '2010-07-26 18:30:31', 12, 'S', '', 98, '192.168.1.202', 'workflowtransaction_id', 'sim_hr_overtimeclaim'),
('sim_workflowtransactionhistory', 'workflowtransaction_id=''12''workflowstatus_id=''2''workflowtransaction_datetime=''10/07/26 18:30:31''uid=''1''workflowtransactionhistory_description=''', 'I', 1, '2010-07-26 18:30:31', 0, 'S', '', 99, '192.168.1.202', 'workflowtransactionhistory_id', ''),
('sim_hr_leaveadjustment', 'leavetype_id=''WE(8)''created=''10/07/26 18:32:07''createdby=''admin(1)''updated=''10/07/26 18:32:07''updatedby=''admin(1)''organization_id=''1', 'I', 1, '2010-07-26 18:32:07', 6, 'S', '', 100, '127.0.0.1', 'leaveadjustment_id', 'admin'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''6''employee_id=''14''leaveadjustmentline_totalday=''2''created=''2010-07-26 18:32:08''createdby=''1''updated=''2010-07-26 18:32:08''updatedby=''1', 'I', 1, '2010-07-26 18:32:08', 321, 'S', '', 101, '127.0.0.1', 'leaveadjustmentline_id', '6'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''6''employee_id=''15''leaveadjustmentline_totalday=''2''created=''2010-07-26 18:32:08''createdby=''1''updated=''2010-07-26 18:32:08''updatedby=''1', 'I', 1, '2010-07-26 18:32:08', 322, 'S', '', 102, '127.0.0.1', 'leaveadjustmentline_id', '6'),
('sim_hr_leaveadjustment', 'issubmit=''1''', 'U', 1, '2010-07-26 18:32:34', 6, 'S', '', 103, '127.0.0.1', 'leaveadjustment_id', '6'),
('sim_workflowtransaction', 'workflowtransaction_datetime=''10/07/26 18:32:34''target_groupid=''1''target_uid=''0''targetparameter_name=''''workflowstatus_id=''1''workflow_id=''8''tablename=''sim_hr_leaveadjustment''primarykey_name=''leaveadjustment_id''primarykey_value=''6''hyperlink=''''title_description=''''created=''10/07/26 18:32:34''list_parameter=''''workflowtransaction_description=''''workflowtransaction_feedback=''''iscomplete=''0''createdby=''1''email_list=''''sms_list=''''email_body=''''sms_body=''''person_id=''10/07/26 18:32:34''issubmit=''1', 'I', 1, '2010-07-26 18:32:34', 13, 'S', '', 104, '127.0.0.1', 'workflowtransaction_id', 'sim_hr_leaveadjustment'),
('sim_workflowtransactionhistory', 'workflowtransaction_id=''13''workflowstatus_id=''1''workflowtransaction_datetime=''10/07/26 18:32:34''uid=''1''workflowtransactionhistory_description=''', 'I', 1, '2010-07-26 18:32:34', 0, 'S', '', 105, '127.0.0.1', 'workflowtransactionhistory_id', ''),
('sim_workflowtransaction', 'workflowtransaction_datetime=''10/07/26 18:39:50''target_groupid=''''target_uid=''''targetparameter_name=''''workflowstatus_id=''''workflow_id=''''tablename=''sim_hr_leaveadjustment''primarykey_name=''leaveadjustment_id''primarykey_value=''6''hyperlink=''''title_description=''''created=''10/07/26 18:39:50''list_parameter=''''workflowtransaction_description=''''workflowtransaction_feedback=''''iscomplete=''''createdby=''1''email_list=''''sms_list=''''email_body=''''sms_body=''''person_id=''0''issubmit=''', 'I', 1, '2010-07-26 18:39:50', 14, 'S', '', 106, '192.168.1.202', 'workflowtransaction_id', 'sim_hr_leaveadjustment'),
('sim_workflowtransactionhistory', 'workflowtransaction_id=''14''workflowstatus_id=''''workflowtransaction_datetime=''10/07/26 18:39:50''uid=''1''workflowtransactionhistory_description=''', 'I', 1, '2010-07-26 18:39:50', 0, 'S', '', 107, '192.168.1.202', 'workflowtransactionhistory_id', ''),
('sim_hr_leaveadjustment', 'leavetype_id=''WE(8)''created=''10/07/26 18:40:00''createdby=''admin(1)''updated=''10/07/26 18:40:00''updatedby=''admin(1)''organization_id=''1', 'I', 1, '2010-07-26 18:40:00', 7, 'S', '', 108, '127.0.0.1', 'leaveadjustment_id', 'admin'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''7''employee_id=''14''leaveadjustmentline_totalday=''2''created=''2010-07-26 18:40:00''createdby=''1''updated=''2010-07-26 18:40:00''updatedby=''1', 'I', 1, '2010-07-26 18:40:00', 323, 'S', '', 109, '127.0.0.1', 'leaveadjustmentline_id', '7'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''7''employee_id=''15''leaveadjustmentline_totalday=''2''created=''2010-07-26 18:40:00''createdby=''1''updated=''2010-07-26 18:40:00''updatedby=''1', 'I', 1, '2010-07-26 18:40:00', 324, 'S', '', 110, '127.0.0.1', 'leaveadjustmentline_id', '7'),
('sim_hr_leaveadjustment', 'issubmit=''1''', 'U', 1, '2010-07-26 18:40:08', 7, 'S', '', 111, '127.0.0.1', 'leaveadjustment_id', '7'),
('sim_workflowtransaction', 'workflowtransaction_datetime=''10/07/26 18:40:08''target_groupid=''1''target_uid=''0''targetparameter_name=''''workflowstatus_id=''1''workflow_id=''8''tablename=''sim_hr_leaveadjustment''primarykey_name=''leaveadjustment_id''primarykey_value=''7''hyperlink=''''title_description=''''created=''10/07/26 18:40:08''list_parameter=''''workflowtransaction_description=''''workflowtransaction_feedback=''''iscomplete=''0''createdby=''1''email_list=''''sms_list=''''email_body=''''sms_body=''''person_id=''10/07/26 18:40:08''issubmit=''1', 'I', 1, '2010-07-26 18:40:09', 15, 'S', '', 112, '127.0.0.1', 'workflowtransaction_id', 'sim_hr_leaveadjustment'),
('sim_workflowtransactionhistory', 'workflowtransaction_id=''15''workflowstatus_id=''1''workflowtransaction_datetime=''10/07/26 18:40:09''uid=''1''workflowtransactionhistory_description=''', 'I', 1, '2010-07-26 18:40:09', 0, 'S', '', 113, '127.0.0.1', 'workflowtransactionhistory_id', ''),
('sim_hr_leaveadjustment', 'leavetype_id=''WE(8)''created=''10/07/26 18:43:26''createdby=''admin(1)''updated=''10/07/26 18:43:26''updatedby=''admin(1)''organization_id=''1', 'I', 1, '2010-07-26 18:43:26', 8, 'S', '', 114, '127.0.0.1', 'leaveadjustment_id', 'admin'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''8''employee_id=''14''leaveadjustmentline_totalday=''2''created=''2010-07-26 18:43:26''createdby=''1''updated=''2010-07-26 18:43:26''updatedby=''1', 'I', 1, '2010-07-26 18:43:26', 325, 'S', '', 115, '127.0.0.1', 'leaveadjustmentline_id', '8'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''8''employee_id=''15''leaveadjustmentline_totalday=''2''created=''2010-07-26 18:43:26''createdby=''1''updated=''2010-07-26 18:43:26''updatedby=''1', 'I', 1, '2010-07-26 18:43:26', 326, 'S', '', 116, '127.0.0.1', 'leaveadjustmentline_id', '8'),
('sim_hr_leaveadjustment', 'issubmit=''1''', 'U', 1, '2010-07-26 18:43:33', 8, 'S', '', 117, '127.0.0.1', 'leaveadjustment_id', '8'),
('sim_workflowtransaction', 'workflowtransaction_datetime=''10/07/26 18:43:33''target_groupid=''1''target_uid=''0''targetparameter_name=''''workflowstatus_id=''1''workflow_id=''8''tablename=''sim_hr_leaveadjustment''primarykey_name=''leaveadjustment_id''primarykey_value=''8''hyperlink=''''title_description=''''created=''10/07/26 18:43:33''list_parameter=''''workflowtransaction_description=''''workflowtransaction_feedback=''''iscomplete=''0''createdby=''1''email_list=''''sms_list=''''email_body=''''sms_body=''''person_id=''10/07/26 18:43:33''issubmit=''1', 'I', 1, '2010-07-26 18:43:33', 16, 'S', '', 118, '127.0.0.1', 'workflowtransaction_id', 'sim_hr_leaveadjustment'),
('sim_workflowtransactionhistory', 'workflowtransaction_id=''16''workflowstatus_id=''1''workflowtransaction_datetime=''10/07/26 18:43:33''uid=''1''workflowtransactionhistory_description=''', 'I', 1, '2010-07-26 18:43:33', 0, 'S', '', 119, '127.0.0.1', 'workflowtransactionhistory_id', ''),
('sim_workflowtransaction', 'workflowtransaction_datetime=''10/07/26 18:45:50''target_groupid=''''target_uid=''''targetparameter_name=''''workflowstatus_id=''''workflow_id=''''tablename=''sim_hr_leaveadjustment''primarykey_name=''leaveadjustment_id''primarykey_value=''8''hyperlink=''''title_description=''''created=''10/07/26 18:45:50''list_parameter=''''workflowtransaction_description=''''workflowtransaction_feedback=''''iscomplete=''''createdby=''1''email_list=''''sms_list=''''email_body=''''sms_body=''''person_id=''0''issubmit=''', 'I', 1, '2010-07-26 18:45:50', 17, 'S', '', 120, '192.168.1.202', 'workflowtransaction_id', 'sim_hr_leaveadjustment'),
('sim_workflowtransactionhistory', 'workflowtransaction_id=''17''workflowstatus_id=''''workflowtransaction_datetime=''10/07/26 18:45:50''uid=''1''workflowtransactionhistory_description=''', 'I', 1, '2010-07-26 18:45:50', 0, 'S', '', 121, '192.168.1.202', 'workflowtransactionhistory_id', ''),
('sim_workflowtransaction', 'workflowtransaction_datetime=''10/07/26 18:46:01''target_groupid=''''target_uid=''''targetparameter_name=''''workflowstatus_id=''''workflow_id=''''tablename=''sim_hr_leaveadjustment''primarykey_name=''leaveadjustment_id''primarykey_value=''7''hyperlink=''''title_description=''''created=''10/07/26 18:46:01''list_parameter=''''workflowtransaction_description=''''workflowtransaction_feedback=''''iscomplete=''''createdby=''1''email_list=''''sms_list=''''email_body=''''sms_body=''''person_id=''0''issubmit=''', 'I', 1, '2010-07-26 18:46:01', 18, 'S', '', 122, '192.168.1.202', 'workflowtransaction_id', 'sim_hr_leaveadjustment'),
('sim_workflowtransactionhistory', 'workflowtransaction_id=''18''workflowstatus_id=''''workflowtransaction_datetime=''10/07/26 18:46:01''uid=''1''workflowtransactionhistory_description=''', 'I', 1, '2010-07-26 18:46:01', 0, 'S', '', 123, '192.168.1.202', 'workflowtransactionhistory_id', ''),
('sim_hr_leaveadjustment', 'leavetype_id=''WE(8)''created=''10/07/26 18:47:08''createdby=''admin(1)''updated=''10/07/26 18:47:08''updatedby=''admin(1)''organization_id=''1', 'I', 1, '2010-07-26 18:47:08', 9, 'S', '', 124, '127.0.0.1', 'leaveadjustment_id', 'admin'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''9''employee_id=''14''leaveadjustmentline_totalday=''2''created=''2010-07-26 18:47:08''createdby=''1''updated=''2010-07-26 18:47:08''updatedby=''1', 'I', 1, '2010-07-26 18:47:08', 327, 'S', '', 125, '127.0.0.1', 'leaveadjustmentline_id', '9'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''9''employee_id=''15''leaveadjustmentline_totalday=''2''created=''2010-07-26 18:47:08''createdby=''1''updated=''2010-07-26 18:47:08''updatedby=''1', 'I', 1, '2010-07-26 18:47:08', 328, 'S', '', 126, '127.0.0.1', 'leaveadjustmentline_id', '9'),
('sim_hr_leaveadjustment', 'issubmit=''1''', 'U', 1, '2010-07-26 18:47:15', 9, 'S', '', 127, '127.0.0.1', 'leaveadjustment_id', '9'),
('sim_workflowtransaction', 'workflowtransaction_datetime=''10/07/26 18:47:15''target_groupid=''1''target_uid=''0''targetparameter_name=''''workflowstatus_id=''1''workflow_id=''8''tablename=''sim_hr_leaveadjustment''primarykey_name=''leaveadjustment_id''primarykey_value=''9''hyperlink=''''title_description=''''created=''10/07/26 18:47:15''list_parameter=''''workflowtransaction_description=''''workflowtransaction_feedback=''''iscomplete=''0''createdby=''1''email_list=''''sms_list=''''email_body=''''sms_body=''''person_id=''0''issubmit=''1', 'I', 1, '2010-07-26 18:47:15', 19, 'S', '', 128, '127.0.0.1', 'workflowtransaction_id', 'sim_hr_leaveadjustment'),
('sim_workflowtransactionhistory', 'workflowtransaction_id=''19''workflowstatus_id=''1''workflowtransaction_datetime=''10/07/26 18:47:15''uid=''1''workflowtransactionhistory_description=''', 'I', 1, '2010-07-26 18:47:15', 0, 'S', '', 129, '127.0.0.1', 'workflowtransactionhistory_id', ''),
('sim_workflowtransaction', 'workflowtransaction_datetime=''10/07/26 19:01:20''target_groupid=''1''target_uid=''1''targetparameter_name=''''workflowstatus_id=''2''workflow_id=''8''tablename=''sim_hr_leaveadjustment''primarykey_name=''leaveadjustment_id''primarykey_value=''9''hyperlink=''''title_description=''''created=''10/07/26 19:01:20''list_parameter=''''workflowtransaction_description=''''workflowtransaction_feedback=''dfs''iscomplete=''1''createdby=''1''email_list=''''sms_list=''''email_body=''''sms_body=''''person_id=''0''issubmit=''1', 'I', 1, '2010-07-26 19:01:20', 20, 'S', '', 130, '192.168.1.202', 'workflowtransaction_id', 'sim_hr_leaveadjustment'),
('sim_workflowtransactionhistory', 'workflowtransaction_id=''20''workflowstatus_id=''2''workflowtransaction_datetime=''10/07/26 19:01:20''uid=''1''workflowtransactionhistory_description=''', 'I', 1, '2010-07-26 19:01:20', 0, 'S', '', 131, '192.168.1.202', 'workflowtransactionhistory_id', ''),
('sim_workflowtransaction', 'workflowtransaction_datetime=''10/07/26 19:01:52''target_groupid=''''target_uid=''''targetparameter_name=''''workflowstatus_id=''''workflow_id=''''tablename=''sim_hr_leaveadjustment''primarykey_name=''leaveadjustment_id''primarykey_value=''5''hyperlink=''''title_description=''''created=''10/07/26 19:01:52''list_parameter=''''workflowtransaction_description=''''workflowtransaction_feedback=''''iscomplete=''''createdby=''1''email_list=''''sms_list=''''email_body=''''sms_body=''''person_id=''10''issubmit=''', 'I', 1, '2010-07-26 19:01:52', 21, 'S', '', 132, '192.168.1.202', 'workflowtransaction_id', 'sim_hr_leaveadjustment'),
('sim_workflowtransactionhistory', 'workflowtransaction_id=''21''workflowstatus_id=''''workflowtransaction_datetime=''10/07/26 19:01:52''uid=''1''workflowtransactionhistory_description=''', 'I', 1, '2010-07-26 19:01:52', 0, 'S', '', 133, '192.168.1.202', 'workflowtransactionhistory_id', ''),
('sim_hr_employee', 'uid=''1'',<br/>religion_id='''',<br/>defaultlevel='''',<br/>organization_id='''',<br/>employee_status=''''', 'U', 1, '2010-07-26 19:04:23', 14, 'S', '', 134, '127.0.0.1', 'employee_id', '1312'),
('sim_hr_leaveadjustment', 'leavetype_id=''WE(8)''created=''10/07/26 19:04:52''createdby=''admin(1)''updated=''10/07/26 19:04:52''updatedby=''admin(1)''organization_id=''1', 'I', 1, '2010-07-26 19:04:52', 10, 'S', '', 135, '127.0.0.1', 'leaveadjustment_id', 'admin'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''10''employee_id=''14''leaveadjustmentline_totalday=''2''created=''2010-07-26 19:04:52''createdby=''1''updated=''2010-07-26 19:04:52''updatedby=''1', 'I', 1, '2010-07-26 19:04:52', 329, 'S', '', 136, '127.0.0.1', 'leaveadjustmentline_id', '10'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''10''employee_id=''15''leaveadjustmentline_totalday=''2''created=''2010-07-26 19:04:52''createdby=''1''updated=''2010-07-26 19:04:52''updatedby=''1', 'I', 1, '2010-07-26 19:04:52', 330, 'S', '', 137, '127.0.0.1', 'leaveadjustmentline_id', '10'),
('sim_hr_leaveadjustment', 'issubmit=''1''', 'U', 1, '2010-07-26 19:04:59', 10, 'S', '', 138, '127.0.0.1', 'leaveadjustment_id', '10'),
('sim_workflowtransaction', 'workflowtransaction_datetime=''10/07/26 19:04:59''target_groupid=''1''target_uid=''0''targetparameter_name=''''workflowstatus_id=''1''workflow_id=''8''tablename=''sim_hr_leaveadjustment''primarykey_name=''leaveadjustment_id''primarykey_value=''10''hyperlink=''''title_description=''''created=''10/07/26 19:04:59''list_parameter=''''workflowtransaction_description=''''workflowtransaction_feedback=''''iscomplete=''0''createdby=''1''email_list=''''sms_list=''''email_body=''''sms_body=''''person_id=''0''issubmit=''1', 'I', 1, '2010-07-26 19:05:00', 22, 'S', '', 139, '127.0.0.1', 'workflowtransaction_id', 'sim_hr_leaveadjustment'),
('sim_workflowtransactionhistory', 'workflowtransaction_id=''22''workflowstatus_id=''1''workflowtransaction_datetime=''10/07/26 19:05:00''uid=''1''workflowtransactionhistory_description=''', 'I', 1, '2010-07-26 19:05:00', 0, 'S', '', 140, '127.0.0.1', 'workflowtransactionhistory_id', ''),
('sim_hr_leaveadjustment', 'leavetype_id=''WE(8)''created=''10/07/26 19:06:11''createdby=''admin(1)''updated=''10/07/26 19:06:11''updatedby=''admin(1)''organization_id=''1', 'I', 1, '2010-07-26 19:06:11', 11, 'S', '', 141, '127.0.0.1', 'leaveadjustment_id', 'admin'),
('sim_hr_leaveadjustment', 'leavetype_id=''WE(8)''created=''10/07/26 19:08:49''createdby=''admin(1)''updated=''10/07/26 19:08:49''updatedby=''admin(1)''organization_id=''1', 'I', 1, '2010-07-26 19:08:49', 12, 'S', '', 142, '127.0.0.1', 'leaveadjustment_id', 'admin'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''12''employee_id=''14''leaveadjustmentline_totalday=''2''created=''2010-07-26 19:08:49''createdby=''1''updated=''2010-07-26 19:08:49''updatedby=''1', 'I', 1, '2010-07-26 19:08:49', 331, 'S', '', 143, '127.0.0.1', 'leaveadjustmentline_id', '12'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''12''employee_id=''15''leaveadjustmentline_totalday=''2''created=''2010-07-26 19:08:49''createdby=''1''updated=''2010-07-26 19:08:49''updatedby=''1', 'I', 1, '2010-07-26 19:08:50', 332, 'S', '', 144, '127.0.0.1', 'leaveadjustmentline_id', '12'),
('sim_hr_leaveadjustment', 'leavetype_id=''WE(8)''created=''10/07/26 19:09:20''createdby=''admin(1)''updated=''10/07/26 19:09:20''updatedby=''admin(1)''organization_id=''1', 'I', 1, '2010-07-26 19:09:20', 13, 'S', '', 145, '127.0.0.1', 'leaveadjustment_id', 'admin'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''13''employee_id=''14''leaveadjustmentline_totalday=''2''created=''2010-07-26 19:09:20''createdby=''1''updated=''2010-07-26 19:09:20''updatedby=''1', 'I', 1, '2010-07-26 19:09:20', 333, 'S', '', 146, '127.0.0.1', 'leaveadjustmentline_id', '13'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''13''employee_id=''15''leaveadjustmentline_totalday=''2''created=''2010-07-26 19:09:20''createdby=''1''updated=''2010-07-26 19:09:20''updatedby=''1', 'I', 1, '2010-07-26 19:09:20', 334, 'S', '', 147, '127.0.0.1', 'leaveadjustmentline_id', '13'),
('sim_hr_leaveadjustment', 'issubmit=''1''', 'U', 1, '2010-07-26 19:09:31', 13, 'S', '', 148, '127.0.0.1', 'leaveadjustment_id', '13');
INSERT INTO `sim_audit` (`tablename`, `changedesc`, `category`, `uid`, `updated`, `record_id`, `eventype`, `uname`, `audit_id`, `ip`, `primarykey`, `controlvalue`) VALUES
('sim_workflowtransaction', 'workflowtransaction_datetime=''10/07/26 19:09:31''target_groupid=''1''target_uid=''0''targetparameter_name=''''workflowstatus_id=''1''workflow_id=''8''tablename=''sim_hr_leaveadjustment''primarykey_name=''leaveadjustment_id''primarykey_value=''13''hyperlink=''''title_description=''''created=''10/07/26 19:09:31''list_parameter=''''workflowtransaction_description=''''workflowtransaction_feedback=''''iscomplete=''0''createdby=''1''email_list=''''sms_list=''''email_body=''''sms_body=''''person_id=''14''issubmit=''1', 'I', 1, '2010-07-26 19:09:31', 23, 'S', '', 149, '127.0.0.1', 'workflowtransaction_id', 'sim_hr_leaveadjustment'),
('sim_workflowtransactionhistory', 'workflowtransaction_id=''23''workflowstatus_id=''1''workflowtransaction_datetime=''10/07/26 19:09:31''uid=''1''workflowtransactionhistory_description=''', 'I', 1, '2010-07-26 19:09:31', 0, 'S', '', 150, '127.0.0.1', 'workflowtransactionhistory_id', ''),
('sim_workflowtransaction', 'workflowtransaction_datetime=''10/07/26 19:09:55''target_groupid=''1''target_uid=''1''targetparameter_name=''''workflowstatus_id=''2''workflow_id=''8''tablename=''sim_hr_leaveadjustment''primarykey_name=''leaveadjustment_id''primarykey_value=''13''hyperlink=''''title_description=''''created=''10/07/26 19:09:55''list_parameter=''''workflowtransaction_description=''''workflowtransaction_feedback=''''iscomplete=''1''createdby=''1''email_list=''''sms_list=''''email_body=''''sms_body=''''person_id=''14''issubmit=''1', 'I', 1, '2010-07-26 19:09:55', 24, 'S', '', 151, '192.168.1.202', 'workflowtransaction_id', 'sim_hr_leaveadjustment'),
('sim_workflowtransactionhistory', 'workflowtransaction_id=''24''workflowstatus_id=''2''workflowtransaction_datetime=''10/07/26 19:09:55''uid=''1''workflowtransactionhistory_description=''', 'I', 1, '2010-07-26 19:09:55', 0, 'S', '', 152, '192.168.1.202', 'workflowtransactionhistory_id', ''),
('sim_hr_employeegroup', 'employeegroup_no=''LF''employeegroup_name=''Lecturer (Fulltime)''islecturer=''1''isovertime=''1''isparttime=''0''isactive=''1''defaultlevel=''10''created=''2010-07-27 09:06:18''createdby=''1''updated=''2010-07-27 09:06:18''updatedby=''1''organization_id=''1''description=''', 'I', 1, '2010-07-27 09:06:18', 12, 'S', '', 153, '::1', 'employeegroup_id', 'LF'),
('sim_hr_employeegroup', 'employeegroup_no=''CLF''employeegroup_name=''Cos-Lecturer (Fulltime)''islecturer=''1''isovertime=''1''isparttime=''0''isactive=''1''defaultlevel=''10''created=''2010-07-27 09:06:18''createdby=''1''updated=''2010-07-27 09:06:18''updatedby=''1''organization_id=''1''description=''', 'I', 1, '2010-07-27 09:06:18', 13, 'S', '', 154, '::1', 'employeegroup_id', 'CLF'),
('sim_hr_employeegroup', 'employeegroup_no=''OF''employeegroup_name=''Other (Full time)''islecturer=''0''isovertime=''1''isparttime=''1''isactive=''1''defaultlevel=''10''created=''2010-07-27 09:06:18''createdby=''1''updated=''2010-07-27 09:06:18''updatedby=''1''organization_id=''1''description=''', 'I', 1, '2010-07-27 09:06:18', 14, 'S', '', 155, '::1', 'employeegroup_id', 'OF'),
('sim_hr_employeegroup', 'employeegroup_no=''DF'',<br/>employeegroup_name=''Driver (Full Time)'',<br/>isparttime=''0''', 'U', 1, '2010-07-27 09:06:18', 11, 'S', '', 156, '::1', 'employeegroup_id', 'DF'),
('sim_hr_employeegroup', 'employeegroup_no=''LP'',<br/>employeegroup_name=''Lecturer (Part-time)'',<br/>isparttime=''1''', 'U', 1, '2010-07-27 09:06:18', 10, 'S', '', 157, '::1', 'employeegroup_id', 'LP'),
('sim_hr_employeegroup', 'employeegroup_no=''T''employeegroup_name=''Tesing''islecturer=''1''isovertime=''1''isparttime=''1''isactive=''1''defaultlevel=''10''created=''2010-07-27 09:13:42''createdby=''1''updated=''2010-07-27 09:13:42''updatedby=''1''organization_id=''1''description=''', 'I', 1, '2010-07-27 09:13:42', 15, 'S', '', 158, '127.0.0.1', 'employeegroup_id', 'T'),
('sim_hr_employeegroup', 'islecturer=''1''', 'U', 1, '2010-07-27 09:13:49', 11, 'S', '', 159, '127.0.0.1', 'employeegroup_id', 'DF'),
('sim_hr_employeegroup', 'isovertime=''0''', 'U', 1, '2010-07-27 09:13:49', 12, 'S', '', 160, '127.0.0.1', 'employeegroup_id', 'LF'),
('sim_hr_employeegroup', 'isovertime=''0''', 'U', 1, '2010-07-27 09:13:49', 10, 'S', '', 161, '127.0.0.1', 'employeegroup_id', 'LP'),
('sim_hr_employeegroup', 'isovertime=''0''', 'U', 1, '2010-07-27 09:13:49', 14, 'S', '', 162, '127.0.0.1', 'employeegroup_id', 'OF'),
('sim_hr_employeegroup', 'isovertime=''0''', 'U', 1, '2010-07-27 09:13:49', 15, 'S', '', 163, '127.0.0.1', 'employeegroup_id', 'T'),
('sim_hr_employeegroup', 'isdeleted=', 'D', 1, '2010-07-27 09:13:57', 15, 'S', '', 164, '127.0.0.1', 'employeegroup_id', ''),
('sim_hr_employeegroup', 'isdeleted=', 'D', 1, '2010-07-27 09:14:00', 15, 'S', '', 165, '127.0.0.1', 'employeegroup_id', ''),
('sim_hr_employeegroup', 'isdeleted=', 'D', 1, '2010-07-27 09:14:05', 15, 'S', '', 166, '127.0.0.1', 'employeegroup_id', ''),
('sim_hr_employeegroup', 'isdeleted=', 'D', 1, '2010-07-27 09:16:03', 15, 'S', '', 167, '127.0.0.1', 'employeegroup_id', ''),
('sim_hr_employeegroup', 'isdeleted=', 'D', 1, '2010-07-27 09:17:16', 15, 'S', '', 168, '127.0.0.1', 'employeegroup_id', ''),
('sim_hr_employeegroup', 'isdeleted=', 'D', 1, '2010-07-27 09:17:39', 15, 'S', '', 169, '127.0.0.1', 'employeegroup_id', ''),
('sim_hr_employeegroup', 'Record deleted permanentl', 'E', 1, '2010-07-27 09:18:23', 15, 'S', '', 170, '127.0.0.1', 'employeegroup_id', 'T'),
('sim_hr_jobposition', 'jobposition_no=''5''jobposition_name=''Juruteknik Komputer''isactive=''1''defaultlevel=''10''created=''2010-07-27 09:19:26''createdby=''1''updated=''2010-07-27 09:19:26''updatedby=''1''organization_id=''1''description=''', 'I', 1, '2010-07-27 09:19:26', 54, 'S', '', 171, '127.0.0.1', 'jobposition_id', '5'),
('sim_hr_jobposition', 'jobposition_no=''4''jobposition_name=''Pegawai Tadbir Akademik''isactive=''1''defaultlevel=''10''created=''2010-07-27 09:19:26''createdby=''1''updated=''2010-07-27 09:19:26''updatedby=''1''organization_id=''1''description=''', 'I', 1, '2010-07-27 09:19:26', 55, 'S', '', 172, '127.0.0.1', 'jobposition_id', '4'),
('sim_hr_jobposition', 'jobposition_no=''3''jobposition_name=''Pembantu Pustakawan''isactive=''1''defaultlevel=''10''created=''2010-07-27 09:19:26''createdby=''1''updated=''2010-07-27 09:19:26''updatedby=''1''organization_id=''1''description=''', 'I', 1, '2010-07-27 09:19:26', 56, 'S', '', 173, '127.0.0.1', 'jobposition_id', '3'),
('sim_hr_jobposition', 'jobposition_name=''Kaunselor''', 'U', 1, '2010-07-27 09:19:26', 53, 'S', '', 174, '127.0.0.1', 'jobposition_id', '1'),
('sim_hr_jobposition', 'jobposition_name=''Pensyarah''', 'U', 1, '2010-07-27 09:19:26', 52, 'S', '', 175, '127.0.0.1', 'jobposition_id', '2'),
('sim_hr_jobposition', 'isactive=''0''', 'U', 1, '2010-07-27 09:20:41', 52, 'S', '', 176, '127.0.0.1', 'jobposition_id', '2'),
('sim_hr_jobposition', 'isactive=''0''', 'U', 1, '2010-07-27 09:20:41', 55, 'S', '', 177, '127.0.0.1', 'jobposition_id', '4'),
('sim_hr_jobposition', 'isactive=''1''', 'U', 1, '2010-07-27 09:20:57', 52, 'S', '', 178, '127.0.0.1', 'jobposition_id', '2'),
('sim_hr_jobposition', 'isactive=''1''', 'U', 1, '2010-07-27 09:20:57', 55, 'S', '', 179, '127.0.0.1', 'jobposition_id', '4'),
('sim_hr_jobposition', 'jobposition_no=''W''jobposition_name=''E''isactive=''1''defaultlevel=''10''created=''2010-07-27 09:21:05''createdby=''1''updated=''2010-07-27 09:21:05''updatedby=''1''organization_id=''1''description=''', 'I', 1, '2010-07-27 09:21:05', 57, 'S', '', 180, '127.0.0.1', 'jobposition_id', 'W'),
('sim_hr_jobposition', 'isdeleted=', 'D', 1, '2010-07-27 09:21:09', 57, 'S', '', 181, '127.0.0.1', 'jobposition_id', 'W'),
('sim_hr_jobposition', 'Record deleted permanentl', 'E', 1, '2010-07-27 09:21:15', 57, 'S', '', 182, '127.0.0.1', 'jobposition_id', 'W'),
('sim_hr_leavetype', 'leavetype_name=''Mecdical Leave''isactive=''1''isvalidate=''0''defaultlevel=''10''created=''2010-07-27 09:34:52''createdby=''1''updated=''2010-07-27 09:34:52''updatedby=''1''organization_id=''1''description=''', 'I', 1, '2010-07-27 09:34:52', 9, 'S', '', 183, '127.0.0.1', 'leavetype_id', 'Mecdical Leave'),
('sim_hr_leavetype', 'leavetype_name=''Birthday Leave''isactive=''1''isvalidate=''0''defaultlevel=''10''created=''2010-07-27 09:34:52''createdby=''1''updated=''2010-07-27 09:34:52''updatedby=''1''organization_id=''1''description=''', 'I', 1, '2010-07-27 09:34:52', 10, 'S', '', 184, '127.0.0.1', 'leavetype_id', 'Birthday Leave'),
('sim_hr_leavetype', 'leavetype_name=''Annul Leave''', 'U', 1, '2010-07-27 09:34:52', 8, 'S', '', 185, '127.0.0.1', 'leavetype_id', 'Annul Leave'),
('sim_hr_leavetype', 'isvalidate=''1''', 'U', 1, '2010-07-27 09:35:18', 10, 'S', '', 186, '127.0.0.1', 'leavetype_id', 'Birthday Leave'),
('sim_hr_leavetype', 'description=''das''', 'U', 1, '2010-07-27 09:35:24', 9, 'S', '', 187, '127.0.0.1', 'leavetype_id', 'Mecdical Leave'),
('sim_hr_leavetype', 'description=''saa''', 'U', 1, '2010-07-27 09:35:24', 8, 'S', '', 188, '127.0.0.1', 'leavetype_id', 'Annul Leave'),
('sim_hr_leavetype', 'description=''aaa''', 'U', 1, '2010-07-27 09:35:24', 10, 'S', '', 189, '127.0.0.1', 'leavetype_id', 'Birthday Leave'),
('sim_window', 'mid=''64''windowsetting=''''seqno=''400''description=''''parentwindows_id=''17''filename=''recordinfo.php''isactive=''0''window_name=''Record Info''created=''2010-07-27 09:39:33''createdby=''1''updated=''2010-07-27 09:39:33''updatedby=''1''table_name=''', 'I', 0, '2010-07-27 09:39:33', 33, 'S', '', 190, '127.0.0.1', 'window_id', 'Record Info'),
('sim_hr_leavetype', 'leavetype_name=''sss''isactive=''1''isvalidate=''1''defaultlevel=''10''created=''2010-07-27 09:40:46''createdby=''1''updated=''2010-07-27 09:40:46''updatedby=''1''organization_id=''1''description=''', 'I', 1, '2010-07-27 09:40:46', 11, 'S', '', 191, '127.0.0.1', 'leavetype_id', 'sss'),
('sim_hr_leavetype', 'leavetype_name=''sss''isactive=''1''isvalidate=''1''defaultlevel=''10''created=''2010-07-27 09:40:53''createdby=''1''updated=''2010-07-27 09:40:53''updatedby=''1''organization_id=''1''description=''ddd', 'I', 1, '2010-07-27 09:40:53', 12, 'S', '', 192, '127.0.0.1', 'leavetype_id', 'sss'),
('sim_hr_leavetype', 'isdeleted=', 'D', 1, '2010-07-27 09:40:58', 12, 'S', '', 193, '127.0.0.1', 'leavetype_id', 'sss'),
('sim_hr_leavetype', 'isdeleted=', 'D', 1, '2010-07-27 09:41:03', 11, 'S', '', 194, '127.0.0.1', 'leavetype_id', 'sss'),
('sim_hr_leavetype', 'Record deleted permanentl', 'E', 1, '2010-07-27 09:41:06', 11, 'S', '', 195, '127.0.0.1', 'leavetype_id', 'sss'),
('sim_hr_leavetype', 'Record deleted permanentl', 'E', 1, '2010-07-27 09:41:09', 12, 'S', '', 196, '127.0.0.1', 'leavetype_id', 'sss'),
('sim_hr_disciplinetype', 'disciplinetype_name=''Gumming''isactive=''1''defaultlevel=''10''created=''2010-07-27 09:44:05''createdby=''1''updated=''2010-07-27 09:44:05''updatedby=''1''organization_id=''1''description=''', 'I', 1, '2010-07-27 09:44:05', 16, 'S', '', 197, '127.0.0.1', 'disciplinetype_id', 'Gumming'),
('sim_hr_disciplinetype', 'disciplinetype_name=''Rompa''isactive=''1''defaultlevel=''10''created=''2010-07-27 09:44:05''createdby=''1''updated=''2010-07-27 09:44:05''updatedby=''1''organization_id=''1''description=''', 'I', 1, '2010-07-27 09:44:05', 17, 'S', '', 198, '127.0.0.1', 'disciplinetype_id', 'Rompa'),
('sim_hr_disciplinetype', 'disciplinetype_name=''Touching''isactive=''1''defaultlevel=''10''created=''2010-07-27 09:44:05''createdby=''1''updated=''2010-07-27 09:44:05''updatedby=''1''organization_id=''1''description=''', 'I', 1, '2010-07-27 09:44:05', 18, 'S', '', 199, '127.0.0.1', 'disciplinetype_id', 'Touching'),
('sim_hr_disciplinetype', 'disciplinetype_name=''Chating''', 'U', 1, '2010-07-27 09:44:05', 14, 'S', '', 200, '127.0.0.1', 'disciplinetype_id', 'Chating'),
('sim_hr_disciplinetype', 'disciplinetype_name=''Puching''', 'U', 1, '2010-07-27 09:44:05', 15, 'S', '', 201, '127.0.0.1', 'disciplinetype_id', 'Puching'),
('sim_hr_disciplinetype', 'description=''s''', 'U', 1, '2010-07-27 09:44:14', 16, 'S', '', 202, '127.0.0.1', 'disciplinetype_id', 'Gumming'),
('sim_hr_disciplinetype', 'description=''sa''', 'U', 1, '2010-07-27 09:44:14', 14, 'S', '', 203, '127.0.0.1', 'disciplinetype_id', 'Chating'),
('sim_hr_disciplinetype', 'description=''q''', 'U', 1, '2010-07-27 09:44:14', 18, 'S', '', 204, '127.0.0.1', 'disciplinetype_id', 'Touching'),
('sim_hr_disciplinetype', 'description=''e''', 'U', 1, '2010-07-27 09:44:14', 15, 'S', '', 205, '127.0.0.1', 'disciplinetype_id', 'Puching'),
('sim_hr_disciplinetype', 'description=''w''', 'U', 1, '2010-07-27 09:44:14', 17, 'S', '', 206, '127.0.0.1', 'disciplinetype_id', 'Rompa'),
('sim_hr_disciplinetype', 'disciplinetype_name=''ss''isactive=''1''defaultlevel=''10''created=''2010-07-27 09:44:30''createdby=''1''updated=''2010-07-27 09:44:30''updatedby=''1''organization_id=''1''description=''', 'I', 1, '2010-07-27 09:44:30', 19, 'S', '', 207, '127.0.0.1', 'disciplinetype_id', 'ss'),
('sim_hr_disciplinetype', 'disciplinetype_name=''sss''isactive=''1''defaultlevel=''10''created=''2010-07-27 09:44:30''createdby=''1''updated=''2010-07-27 09:44:30''updatedby=''1''organization_id=''1''description=''', 'I', 1, '2010-07-27 09:44:30', 20, 'S', '', 208, '127.0.0.1', 'disciplinetype_id', 'sss'),
('sim_hr_disciplinetype', 'isdeleted=', 'D', 1, '2010-07-27 09:44:34', 19, 'S', '', 209, '127.0.0.1', 'disciplinetype_id', 'ss'),
('sim_hr_disciplinetype', 'isdeleted=', 'D', 1, '2010-07-27 09:44:37', 20, 'S', '', 210, '127.0.0.1', 'disciplinetype_id', 'sss'),
('sim_hr_disciplinetype', 'Record deleted permanentl', 'E', 1, '2010-07-27 09:44:40', 19, 'S', '', 211, '127.0.0.1', 'disciplinetype_id', 'ss'),
('sim_hr_disciplinetype', 'Record deleted permanentl', 'E', 1, '2010-07-27 09:44:43', 20, 'S', '', 212, '127.0.0.1', 'disciplinetype_id', 'sss'),
('sim_hr_disciplinetype', 'description=''sggfg''', 'U', 1, '2010-07-27 09:49:24', 16, 'S', '', 213, '127.0.0.1', 'disciplinetype_id', 'Gumming'),
('sim_hr_disciplinetype', 'disciplinetype_name=''eee''isactive=''1''defaultlevel=''10''created=''2010-07-27 09:49:29''createdby=''1''updated=''2010-07-27 09:49:29''updatedby=''1''organization_id=''1''description=''', 'I', 1, '2010-07-27 09:49:29', 21, 'S', '', 214, '127.0.0.1', 'disciplinetype_id', 'eee'),
('sim_hr_disciplinetype', 'isdeleted=', 'D', 1, '2010-07-27 09:49:33', 21, 'S', '', 215, '127.0.0.1', 'disciplinetype_id', 'eee'),
('sim_hr_disciplinetype', 'Record deleted permanentl', 'E', 1, '2010-07-27 09:49:36', 21, 'S', '', 216, '127.0.0.1', 'disciplinetype_id', 'eee'),
('sim_hr_trainingtype', 'trainingtype_name=''Maintain Skill''isactive=''1''defaultlevel=''10''created=''2010-07-27 09:50:10''createdby=''1''updated=''2010-07-27 09:50:10''updatedby=''1''organization_id=''1''description=''', 'I', 1, '2010-07-27 09:50:10', 10, 'S', '', 217, '127.0.0.1', 'trainingtype_id', 'Maintain Skill'),
('sim_hr_trainingtype', 'trainingtype_name=''Update''isactive=''1''defaultlevel=''10''created=''2010-07-27 09:50:10''createdby=''1''updated=''2010-07-27 09:50:10''updatedby=''1''organization_id=''1''description=''', 'I', 1, '2010-07-27 09:50:10', 11, 'S', '', 218, '127.0.0.1', 'trainingtype_id', 'Update'),
('sim_hr_trainingtype', 'trainingtype_name=''Repair''isactive=''1''defaultlevel=''10''created=''2010-07-27 09:50:10''createdby=''1''updated=''2010-07-27 09:50:10''updatedby=''1''organization_id=''1''description=''', 'I', 1, '2010-07-27 09:50:10', 12, 'S', '', 219, '127.0.0.1', 'trainingtype_id', 'Repair'),
('sim_hr_trainingtype', 'isactive=''0'',<br/>description=''ww''', 'U', 1, '2010-07-27 09:50:18', 11, 'S', '', 220, '127.0.0.1', 'trainingtype_id', 'Update'),
('sim_hr_trainingtype', 'isactive=''0'',<br/>description=''qq''', 'U', 1, '2010-07-27 09:50:18', 10, 'S', '', 221, '127.0.0.1', 'trainingtype_id', 'Maintain Skill'),
('sim_hr_trainingtype', 'description=''ee''', 'U', 1, '2010-07-27 09:50:18', 12, 'S', '', 222, '127.0.0.1', 'trainingtype_id', 'Repair'),
('sim_hr_trainingtype', 'trainingtype_name=''s''isactive=''1''defaultlevel=''10''created=''2010-07-27 09:50:49''createdby=''1''updated=''2010-07-27 09:50:49''updatedby=''1''organization_id=''1''description=''', 'I', 1, '2010-07-27 09:50:49', 13, 'S', '', 223, '127.0.0.1', 'trainingtype_id', 's'),
('sim_hr_trainingtype', 'isdeleted=', 'D', 1, '2010-07-27 09:50:52', 13, 'S', '', 224, '127.0.0.1', 'trainingtype_id', 's'),
('sim_hr_trainingtype', 'Record deleted permanentl', 'E', 1, '2010-07-27 09:50:56', 13, 'S', '', 225, '127.0.0.1', 'trainingtype_id', 's'),
('sim_hr_trainingtype', 'trainingtype_name=''eee''isactive=''0''defaultlevel=''10''created=''2010-07-27 09:52:13''createdby=''1''updated=''2010-07-27 09:52:13''updatedby=''1''organization_id=''1''description=''', 'I', 1, '2010-07-27 09:52:13', 14, 'S', '', 226, '127.0.0.1', 'trainingtype_id', 'eee'),
('sim_hr_trainingtype', 'trainingtype_name=''wwe''isactive=''0''defaultlevel=''10''created=''2010-07-27 09:52:13''createdby=''1''updated=''2010-07-27 09:52:13''updatedby=''1''organization_id=''1''description=''', 'I', 1, '2010-07-27 09:52:13', 15, 'S', '', 227, '127.0.0.1', 'trainingtype_id', 'wwe'),
('sim_hr_trainingtype', 'isactive=''1'',<br/>description=''ff''', 'U', 1, '2010-07-27 09:52:21', 15, 'S', '', 228, '127.0.0.1', 'trainingtype_id', 'wwe'),
('sim_hr_trainingtype', 'description=''f''', 'U', 1, '2010-07-27 09:52:21', 14, 'S', '', 229, '127.0.0.1', 'trainingtype_id', 'eee'),
('sim_hr_trainingtype', 'isdeleted=', 'D', 1, '2010-07-27 09:52:25', 15, 'S', '', 230, '127.0.0.1', 'trainingtype_id', 'wwe'),
('sim_hr_trainingtype', 'isdeleted=', 'D', 1, '2010-07-27 09:52:28', 14, 'S', '', 231, '127.0.0.1', 'trainingtype_id', 'eee'),
('sim_hr_trainingtype', 'Record deleted permanentl', 'E', 1, '2010-07-27 09:52:31', 15, 'S', '', 232, '127.0.0.1', 'trainingtype_id', 'wwe'),
('sim_hr_trainingtype', 'isdeleted=''0''', 'U', 1, '2010-07-27 09:52:36', 14, 'S', '', 233, '127.0.0.1', 'trainingtype_id', 'eee'),
('sim_hr_trainingtype', 'isdeleted=', 'D', 1, '2010-07-27 09:52:39', 14, 'S', '', 234, '127.0.0.1', 'trainingtype_id', 'eee'),
('sim_hr_trainingtype', 'Record deleted permanentl', 'E', 1, '2010-07-27 09:52:42', 14, 'S', '', 235, '127.0.0.1', 'trainingtype_id', 'eee'),
('sim_races', 'races_description=''C''races_name=''China''isactive=''1''seqno=''0''created=''2010-07-27 09:53:56''createdby=''1''updated=''2010-07-27 09:53:56''updatedby=''1''organization_id=''1', 'I', 1, '2010-07-27 09:53:57', 1, 'S', 'admin', 236, '127.0.0.1', 'races_id', 'C'),
('sim_races', 'races_description=''M''races_name=''Malay''isactive=''1''seqno=''0''created=''2010-07-27 09:53:56''createdby=''1''updated=''2010-07-27 09:53:56''updatedby=''1''organization_id=''1', 'I', 1, '2010-07-27 09:53:57', 2, 'S', 'admin', 237, '127.0.0.1', 'races_id', 'M'),
('sim_races', 'races_description=''I''races_name=''Indian''isactive=''1''seqno=''0''created=''2010-07-27 09:53:56''createdby=''1''updated=''2010-07-27 09:53:56''updatedby=''1''organization_id=''1', 'I', 1, '2010-07-27 09:53:57', 3, 'S', 'admin', 238, '127.0.0.1', 'races_id', 'I'),
('sim_races', 'races_description=''P''races_name=''Peribumi''isactive=''1''seqno=''0''created=''2010-07-27 09:53:56''createdby=''1''updated=''2010-07-27 09:53:56''updatedby=''1''organization_id=''1', 'I', 1, '2010-07-27 09:53:57', 4, 'S', 'admin', 239, '127.0.0.1', 'races_id', 'P'),
('sim_races', 'seqno=''010''', 'U', 1, '2010-07-27 09:57:33', 1, 'S', 'admin', 240, '127.0.0.1', 'races_id', 'C'),
('sim_races', 'seqno=''10''', 'U', 1, '2010-07-27 09:57:34', 3, 'S', 'admin', 241, '127.0.0.1', 'races_id', 'I'),
('sim_races', 'seqno=''10''', 'U', 1, '2010-07-27 09:57:34', 2, 'S', 'admin', 242, '127.0.0.1', 'races_id', 'M'),
('sim_races', 'seqno=''10''', 'U', 1, '2010-07-27 09:57:34', 4, 'S', 'admin', 243, '127.0.0.1', 'races_id', 'P'),
('sim_races', 'races_description=''we''races_name=''we''isactive=''1''seqno=''10''created=''2010-07-27 09:57:41''createdby=''1''updated=''2010-07-27 09:57:41''updatedby=''1''organization_id=''1', 'I', 1, '2010-07-27 09:57:41', 5, 'S', 'admin', 244, '127.0.0.1', 'races_id', 'we'),
('sim_races', 'Record deleted permanentl', 'E', 1, '2010-07-27 09:57:45', 5, 'S', 'admin', 245, '127.0.0.1', 'races_id', 'we'),
('sim_races', 'races_description=''we''races_name=''rr''isactive=''1''seqno=''10''created=''2010-07-27 10:02:06''createdby=''1''updated=''2010-07-27 10:02:06''updatedby=''1''organization_id=''1', 'I', 1, '2010-07-27 10:02:06', 6, 'S', 'admin', 246, '127.0.0.1', 'races_id', 'we'),
('sim_races', 'isactive=''0''', 'U', 1, '2010-07-27 10:02:11', 6, 'S', 'admin', 247, '127.0.0.1', 'races_id', 'we'),
('sim_races', 'isdeleted=', 'D', 1, '2010-07-27 10:02:15', 6, 'S', 'admin', 248, '127.0.0.1', 'races_id', 'we'),
('sim_races', 'Record deleted permanentl', 'E', 1, '2010-07-27 10:02:19', 6, 'S', 'admin', 249, '127.0.0.1', 'races_id', 'we'),
('sim_religion', 'religion_description=''B''religion_name=''Buddhist''isactive=''1''seqno=''10''created=''2010-07-27 10:05:07''createdby=''1''updated=''2010-07-27 10:05:07''updatedby=''1''organization_id=''1', 'I', 1, '2010-07-27 10:05:07', 1, 'S', 'admin', 250, '127.0.0.1', 'religion_id', 'B'),
('sim_religion', 'religion_description=''C''religion_name=''Christian''isactive=''1''seqno=''10''created=''2010-07-27 10:05:07''createdby=''1''updated=''2010-07-27 10:05:07''updatedby=''1''organization_id=''1', 'I', 1, '2010-07-27 10:05:07', 2, 'S', 'admin', 251, '127.0.0.1', 'religion_id', 'C'),
('sim_religion', 'religion_description=''H''religion_name=''Hindu''isactive=''1''seqno=''10''created=''2010-07-27 10:05:07''createdby=''1''updated=''2010-07-27 10:05:07''updatedby=''1''organization_id=''1', 'I', 1, '2010-07-27 10:05:07', 3, 'S', 'admin', 252, '127.0.0.1', 'religion_id', 'H'),
('sim_religion', 'religion_description=''M''religion_name=''Muslim''isactive=''1''seqno=''10''created=''2010-07-27 10:05:07''createdby=''1''updated=''2010-07-27 10:05:07''updatedby=''1''organization_id=''1', 'I', 1, '2010-07-27 10:05:07', 4, 'S', 'admin', 253, '127.0.0.1', 'religion_id', 'M'),
('sim_religion', 'religion_description=''ss''religion_name=''ss''isactive=''1''seqno=''10''created=''2010-07-27 10:05:13''createdby=''1''updated=''2010-07-27 10:05:13''updatedby=''1''organization_id=''1', 'I', 1, '2010-07-27 10:05:13', 5, 'S', 'admin', 254, '127.0.0.1', 'religion_id', 'ss'),
('sim_religion', 'isactive=''0''', 'U', 1, '2010-07-27 10:05:18', 2, 'S', 'admin', 255, '127.0.0.1', 'religion_id', 'C'),
('sim_religion', 'isactive=''0''', 'U', 1, '2010-07-27 10:05:18', 3, 'S', 'admin', 256, '127.0.0.1', 'religion_id', 'H'),
('sim_religion', 'isactive=''0''', 'U', 1, '2010-07-27 10:05:18', 5, 'S', 'admin', 257, '127.0.0.1', 'religion_id', 'ss'),
('sim_religion', 'isactive=''1''', 'U', 1, '2010-07-27 10:05:23', 3, 'S', 'admin', 258, '127.0.0.1', 'religion_id', 'H'),
('sim_religion', 'isactive=''1''', 'U', 1, '2010-07-27 10:05:23', 2, 'S', 'admin', 259, '127.0.0.1', 'religion_id', 'C'),
('sim_religion', 'isactive=''1''', 'U', 1, '2010-07-27 10:05:23', 5, 'S', 'admin', 260, '127.0.0.1', 'religion_id', 'ss'),
('sim_religion', 'Record deleted permanentl', 'E', 1, '2010-07-27 10:05:27', 5, 'S', 'admin', 261, '127.0.0.1', 'religion_id', 'ss'),
('sim_religion', 'religion_description=''2''religion_name=''3''isactive=''1''seqno=''10''created=''2010-07-27 10:06:27''createdby=''1''updated=''2010-07-27 10:06:27''updatedby=''1''organization_id=''1', 'I', 1, '2010-07-27 10:06:27', 6, 'S', 'admin', 262, '127.0.0.1', 'religion_id', '2'),
('sim_religion', 'isdeleted=', 'D', 1, '2010-07-27 10:06:31', 6, 'S', 'admin', 263, '127.0.0.1', 'religion_id', '2'),
('sim_religion', 'Record deleted permanentl', 'E', 1, '2010-07-27 10:06:34', 6, 'S', 'admin', 264, '127.0.0.1', 'religion_id', '2'),
('sim_country', 'country_code=''sad''country_name=''dsa''isactive=''1''seqno=''10''created=''2010-07-27 10:09:27''createdby=''1''updated=''2010-07-27 10:09:27''updatedby=''1''citizenship=''das', 'I', 1, '2010-07-27 10:09:27', 4, 'S', 'admin', 265, '127.0.0.1', 'country_id', 'sad'),
('sim_country', 'country_code=''saddd'',<br/>country_name=''dsaaaa'',<br/>citizenship=''dasaaa''', 'U', 1, '2010-07-27 10:09:34', 4, 'S', 'admin', 266, '127.0.0.1', 'country_id', 'saddd'),
('sim_country', 'isactive=''0''', 'U', 1, '2010-07-27 10:09:39', 4, 'S', 'admin', 267, '127.0.0.1', 'country_id', 'saddd'),
('sim_country', 'isdeleted=', 'D', 1, '2010-07-27 10:09:58', 4, 'S', 'admin', 268, '127.0.0.1', 'country_id', 'saddd'),
('sim_country', 'Record deleted permanentl', 'E', 1, '2010-07-27 10:10:02', 4, 'S', 'admin', 269, '127.0.0.1', 'country_id', 'saddd'),
('sim_hr_employee', 'employee_name=''A-Tester''employee_cardno=''S23''employee_no=''EM001''uid=''''place_dob=''Johor''employee_dob=''1991-07-17''races_id=''4''religion_id=''4''gender=''M''marital_status=''M''employee_citizenship=''3''employee_newicno=''432423423''employee_oldicno=''''ic_color=''R''employee_passport=''1231231''employee_bloodgroup=''B''department_id=''''jobposition_id=''53''employeegroup_id=''12''employee_joindate=''2010-07-28''filephoto=''1280197189_photofile.png''created=''2010-07-27 10:19:49''createdby=''1''updated=''2010-07-27 10:19:49''updatedby=''1''defaultlevel=''''organization_id=''''employee_transport=''car''employee_status=''1', 'I', 1, '2010-07-27 10:19:49', 16, 'S', '', 270, '127.0.0.1', 'employee_id', 'A-Tester'),
('sim_hr_employee', 'employee_name=''B-Hunter''employee_cardno=''W312''employee_no=''EM002''uid=''''place_dob=''Johor''employee_dob=''2002-07-25''races_id=''3''religion_id=''3''gender=''M''marital_status=''S''employee_citizenship=''3''employee_newicno=''123456''employee_oldicno=''''ic_color=''B''employee_passport=''DSA''employee_bloodgroup=''B+''department_id=''''jobposition_id=''53''employeegroup_id=''10''employee_joindate=''2010-06-08''filephoto=''1280197375_photofile.png''created=''2010-07-27 10:22:55''createdby=''1''updated=''2010-07-27 10:22:55''updatedby=''1''defaultlevel=''''organization_id=''''employee_transport=''CAR''employee_status=''1', 'I', 1, '2010-07-27 10:22:55', 17, 'S', '', 271, '127.0.0.1', 'employee_id', 'B-Hunter'),
('sim_hr_qualificationline', 'qualification_type=''3''qualification_name=''ABC-Diploma''qualification_institution=''ABC College''qualification_month=''1900-01-01''created=''2010-07-27 10:26:44''createdby=''1''updated=''2010-07-27 10:26:44''updatedby=''1''employee_id=''17', 'I', 1, '2010-07-27 10:26:44', 12, 'S', '', 272, '127.0.0.1', 'qualification_id', 'ABC-Diploma'),
('sim_hr_qualificationline', 'qualification_type=''4''qualification_name=''ACN-Digree''qualification_institution=''ACN Univicitive''qualification_month=''2010-07-19 00:00:00''created=''2010-07-27 10:28:14''createdby=''1''updated=''2010-07-27 10:28:14''updatedby=''1''employee_id=''17', 'I', 1, '2010-07-27 10:28:14', 13, 'S', '', 273, '127.0.0.1', 'qualification_id', 'ACN-Digree'),
('sim_hr_qualificationline', 'qualification_type=''sss''qualification_name=''sss''qualification_institution=''''qualification_month=''1900-01-01''created=''2010-07-27 10:28:20''createdby=''1''updated=''2010-07-27 10:28:20''updatedby=''1''employee_id=''17', 'I', 1, '2010-07-27 10:28:20', 14, 'S', '', 274, '127.0.0.1', 'qualification_id', 'sss'),
('sim_hr_qualificationline', 'isdeleted=', 'D', 1, '2010-07-27 10:29:35', 14, 'S', '', 275, '127.0.0.1', 'qualification_id', 'sss'),
('sim_hr_qualificationline', 'qualification_type=''s''qualification_name=''ds''qualification_institution=''''qualification_month=''1900-01-01''created=''2010-07-27 10:33:21''createdby=''1''updated=''2010-07-27 10:33:21''updatedby=''1''employee_id=''17', 'I', 1, '2010-07-27 10:33:22', 15, 'S', '', 276, '127.0.0.1', 'qualification_id', 'ds'),
('sim_hr_qualificationline', 'Record deleted permanentl', 'E', 1, '2010-07-27 10:33:22', 14, 'S', '', 277, '127.0.0.1', 'qualification_id', 'sss'),
('sim_hr_qualificationline', 'isdeleted=', 'D', 1, '2010-07-27 10:33:59', 15, 'S', '', 278, '127.0.0.1', 'qualification_id', 'ds'),
('sim_hr_qualificationline', 'Record deleted permanentl', 'E', 1, '2010-07-27 10:34:02', 15, 'S', '', 279, '127.0.0.1', 'qualification_id', 'ds'),
('sim_hr_supervisorline', 'supervisorline_supervisorid=''16''isdirect=''1''supervisorline_remarks=''sss''created=''2010-07-27 10:42:08''createdby=''1''updated=''2010-07-27 10:42:08''updatedby=''1''employee_id=''17', 'I', 1, '2010-07-27 10:42:08', 24, 'S', '', 280, '127.0.0.1', 'supervisorline_id', '16'),
('sim_hr_employee', 'defaultlevel='''',<br/>organization_id='''',<br/>ic_placeissue=''ddd'',<br/>employee_passport_placeissue=''sss'',<br/>employee_passport_issuedate=''2010-07-21'',<br/>employee_passport_expirydate=''2010-07-28'',<br/>employee_confirmdate=''2010-07-21'',<br/>employee_enddate=''2010-09-29''', 'U', 1, '2010-07-27 10:43:52', 17, 'S', '', 281, '127.0.0.1', 'employee_id', 'EM002'),
('sim_hr_employeespouse', 'employee_id=''17''spouse_name=''CAVIN''spouse_dob=''2010-07-14''spouse_placedob=''dasddasdas''spouse_placeissue=''asdas''spouse_races=''1''spouse_religion=''2''spouse_gender=''F''spouse_bloodgroup=''C''spouse_occupation=''sdas''spouse_citizenship=''2''spouse_newicno=''DSDS''spouse_oldicno=''''spouse_ic_color=''R''spouse_passport=''''spouse_issuedate=''2010-07-18''spouse_expirydate=''2010-07-27''created=''2010-07-27 10:44:39''createdby=''1''updated=''2010-07-27 10:44:39''updatedby=''1', 'I', 1, '2010-07-27 10:44:39', 4, 'S', '', 282, '127.0.0.1', 'spouse_id', 'CAVIN'),
('sim_hr_employeefamily', 'employeefamily_name=''BABA''relationship_id=''1''employeefamily_dob=''2010-07-22 00:00:00''employeefamily_age=''34''employeefamily_occupation=''dsda''employeefamily_contactno=''1122''isnok=''1''isemergency=''1''employeefamily_remark=''''created=''2010-07-27 10:45:49''createdby=''1''updated=''2010-07-27 10:45:49''updatedby=''1''employee_id=''17', 'I', 1, '2010-07-27 10:45:49', 1, 'S', '', 283, '127.0.0.1', 'employeefamily_id', 'BABA'),
('sim_hr_employeefamily', 'isdeleted=', 'D', 1, '2010-07-27 10:49:14', 1, 'S', '', 284, '127.0.0.1', 'employeefamily_id', 'BABA'),
('sim_hr_employeefamily', 'Record deleted permanentl', 'E', 1, '2010-07-27 10:49:18', 1, 'S', '', 285, '127.0.0.1', 'employeefamily_id', 'BABA'),
('sim_hr_employee', 'employee_hpno=''65431'',<br/>employee_officeno=''123456'',<br/>employee_email=''www@hotmail.com'',<br/>employee_networkacc=''AA'',<br/>employee_msgacc=''BB'',<br/>permanent_address=''SSDD'',<br/>permanent_postcode=''CC'',<br/>permanent_city=''GG'',<br/>permanent_state=''DD'',<br/>permanent_country=''3'',<br/>permanent_telno=''789'',<br/>contact_address=''DDSS'',<br/>contact_postcode=''EE'',<br/>contact_city=''HH'',<br/>contact_state=''FF'',<br/>contact_country=''2'',<br/>contact_telno=''987''', 'U', 1, '2010-07-27 10:50:07', 17, 'S', '', 286, '127.0.0.1', 'employee_id', ''),
('sim_hr_attachmentline', 'attachmentline_name=''CheckVerion''attachmentline_file=''1280199053_17.pdf''attachmentline_remarks='' ''employee_id=''17''created=''2010-07-27 10:50:53''createdby=''1''updated=''2010-07-27 10:50:53''updatedby=''1', 'I', 1, '2010-07-27 10:50:53', 1, 'S', '', 287, '127.0.0.1', 'attachmentline_id', 'CheckVerion'),
('sim_hr_attachmentline', 'isdeleted=', 'D', 1, '2010-07-27 10:58:59', 1, 'S', '', 288, '127.0.0.1', 'attachmentline_id', ''),
('sim_hr_attachmentline', 'Record deleted permanentl', 'E', 1, '2010-07-27 10:59:13', 1, 'S', '', 289, '127.0.0.1', 'attachmentline_id', ''),
('sim_hr_attachmentline', 'attachmentline_name=''ss''attachmentline_file=''1280199663_17.pdf''attachmentline_remarks=''ss''employee_id=''17''created=''2010-07-27 11:01:03''createdby=''1''updated=''2010-07-27 11:01:03''updatedby=''1', 'I', 1, '2010-07-27 11:01:04', 2, 'S', '', 290, '127.0.0.1', 'attachmentline_id', 'ss'),
('sim_hr_attachmentline', 'isdeleted=', 'D', 1, '2010-07-27 11:01:14', 2, 'S', '', 291, '127.0.0.1', 'attachmentline_id', ''),
('sim_hr_attachmentline', 'Record deleted permanentl', 'E', 1, '2010-07-27 11:02:11', 2, 'S', '', 292, '127.0.0.1', 'attachmentline_id', ''),
('sim_hr_portfolioline', 'portfolioline_datefrom=''2010-07-11 00:00:00''portfolioline_dateto=''2010-07-22 00:00:00''portfolioline_name=''CC''portfolioline_remarks=''CCVV''created=''2010-07-27 11:02:42''createdby=''1''updated=''2010-07-27 11:02:42''updatedby=''1''isdeleted=''0''employee_id=''17', 'I', 1, '2010-07-27 11:02:42', 1, 'S', '', 293, '127.0.0.1', 'portfolioline_id', 'CC'),
('sim_hr_portfolioline', 'portfolioline_datefrom=''2010-07-06 00:00:00''portfolioline_dateto=''2010-07-29 00:00:00''portfolioline_name=''AA''portfolioline_remarks=''BB''created=''2010-07-27 11:02:42''createdby=''1''updated=''2010-07-27 11:02:42''updatedby=''1''isdeleted=''0''employee_id=''17', 'I', 1, '2010-07-27 11:02:42', 2, 'S', '', 294, '127.0.0.1', 'portfolioline_id', 'AA'),
('sim_hr_portfolioline', 'isdeleted=', 'D', 1, '2010-07-27 11:02:58', 2, 'S', '', 295, '127.0.0.1', 'portfolioline_id', ''),
('sim_hr_portfolioline', 'Record deleted permanentl', 'E', 1, '2010-07-27 11:03:02', 2, 'S', '', 296, '127.0.0.1', 'portfolioline_id', ''),
('sim_hr_portfolioline', 'portfolioline_name=''CCsss'',<br/>portfolioline_remarks=''CCVVsss''', 'U', 1, '2010-07-27 11:03:09', 1, 'S', '', 297, '127.0.0.1', 'portfolioline_id', 'CCsss'),
('sim_hr_activityline', 'activityline_datefrom=''1900-01-01''activityline_dateto=''1900-01-01''activityline_type=''1''employee_id=''17''activityline_name=''aa''activityline_remarks=''ss''created=''2010-07-27 11:11:03''createdby=''1''updated=''2010-07-27 11:11:03''updatedby=''1''isdeleted=''0', 'I', 1, '2010-07-27 11:11:04', 3, 'S', '', 298, '127.0.0.1', 'activityline_id', 'aa'),
('sim_hr_activityline', 'activityline_datefrom=''1900-01-01''activityline_dateto=''1900-01-01''activityline_type=''1''employee_id=''17''activityline_name=''ff''activityline_remarks=''ff''created=''2010-07-27 11:11:12''createdby=''1''updated=''2010-07-27 11:11:12''updatedby=''1''isdeleted=''0', 'I', 1, '2010-07-27 11:11:12', 4, 'S', '', 299, '127.0.0.1', 'activityline_id', 'ff'),
('sim_hr_activityline', 'activityline_name=''aaaa'',<br/>activityline_remarks=''ssss''', 'U', 1, '2010-07-27 11:11:18', 3, 'S', '', 300, '127.0.0.1', 'activityline_id', 'aaaa'),
('sim_hr_activityline', 'activityline_remarks=''ffaa''', 'U', 1, '2010-07-27 11:11:30', 4, 'S', '', 301, '127.0.0.1', 'activityline_id', 'ff'),
('sim_hr_activityline', 'activityline_remarks=''ssssaa''', 'U', 1, '2010-07-27 11:11:30', 3, 'S', '', 302, '127.0.0.1', 'activityline_id', 'aaaa'),
('sim_hr_activityline', 'isdeleted=', 'D', 1, '2010-07-27 11:11:57', 4, 'S', '', 303, '127.0.0.1', 'activityline_id', 'ff'),
('sim_hr_activityline', 'Record deleted permanentl', 'E', 1, '2010-07-27 11:12:00', 4, 'S', '', 304, '127.0.0.1', 'activityline_id', 'ff'),
('sim_hr_trainingtype', 'isactive=''1''', 'U', 1, '2010-07-27 11:12:24', 10, 'S', '', 305, '127.0.0.1', 'trainingtype_id', 'Maintain Skill'),
('sim_hr_trainingtype', 'isactive=''1''', 'U', 1, '2010-07-27 11:12:24', 11, 'S', '', 306, '127.0.0.1', 'trainingtype_id', 'Update'),
('sim_hr_trainingline', 'trainingline_name=''SS''trainingtype_id=''12''trainingline_venue=''DD''trainingline_purpose=''FF''trainingline_startdate=''1900-01-01''trainingline_enddate=''1900-01-01''trainingline_trainerid=''''trainingline_result=''12''trainingline_hodcom=''312''trainingline_hrcom=''312''trainingline_remarks=''df''isdeleted=''0''created=''2010-07-27 11:17:15''createdby=''1''updated=''2010-07-27 11:17:15''updatedby=''1''employee_id=''17', 'I', 1, '2010-07-27 11:17:15', 11, 'S', '', 307, '127.0.0.1', 'trainingline_id', 'SS'),
('sim_hr_trainingline', 'isdeleted=', 'D', 1, '2010-07-27 11:17:34', 11, 'S', '', 308, '127.0.0.1', 'trainingline_id', 'SS'),
('sim_hr_trainingline', 'Record deleted permanentl', 'E', 1, '2010-07-27 11:17:38', 11, 'S', '', 309, '127.0.0.1', 'trainingline_id', 'SS'),
('sim_hr_employee', 'employee_epfno=''RR'',<br/>employee_socsono=''CC'',<br/>employee_taxno=''TT'',<br/>employee_pencenno=''SS'',<br/>employee_accno=''SS'',<br/>employee_bankname=''EE''', 'U', 1, '2010-07-27 11:17:59', 17, 'S', '', 310, '127.0.0.1', 'employee_id', ''),
('sim_hr_appraisalline', 'appraisalline_name=''WW''appraisalline_date=''1900-01-01''appraisalline_datedue=''1900-01-01''appraisalline_increment=''01200''appraisalline_result=''E''appraisalline_remarks=''''isdeleted=''0''created=''2010-07-27 11:18:15''createdby=''1''updated=''2010-07-27 11:18:15''updatedby=''1''employee_id=''17', 'I', 1, '2010-07-27 11:18:15', 1, 'S', '', 311, '127.0.0.1', 'appraisalline_id', 'WW'),
('sim_hr_appraisalline', 'appraisalline_name=''DD''appraisalline_date=''1900-01-01''appraisalline_datedue=''1900-01-01''appraisalline_increment=''02700''appraisalline_result=''D''appraisalline_remarks=''''isdeleted=''0''created=''2010-07-27 11:18:33''createdby=''1''updated=''2010-07-27 11:18:33''updatedby=''1''employee_id=''17', 'I', 1, '2010-07-27 11:18:34', 2, 'S', '', 312, '127.0.0.1', 'appraisalline_id', 'DD'),
('sim_hr_appraisalline', 'appraisalline_increment=''2700232'',<br/>appraisalline_remarks=''ss''', 'U', 1, '2010-07-27 11:19:05', 2, 'S', '', 313, '127.0.0.1', 'appraisalline_id', 'DD'),
('sim_hr_appraisalline', 'appraisalline_increment=''120032'',<br/>appraisalline_remarks=''ss''', 'U', 1, '2010-07-27 11:19:06', 1, 'S', '', 314, '127.0.0.1', 'appraisalline_id', 'WW'),
('sim_hr_appraisalline', 'isdeleted=', 'D', 1, '2010-07-27 11:20:58', 2, 'S', '', 315, '127.0.0.1', 'appraisalline_id', 'DD'),
('sim_hr_appraisalline', 'Record deleted permanentl', 'E', 1, '2010-07-27 11:21:03', 2, 'S', '', 316, '127.0.0.1', 'appraisalline_id', 'DD'),
('sim_hr_disciplineline', 'disciplineline_date=''1900-01-01''disciplinetype_id=''15''employee_id=''17''disciplineline_name=''WW''disciplineline_remarks=''DD''created=''2010-07-27 11:32:58''createdby=''1''updated=''2010-07-27 11:32:58''updatedby=''1''isdeleted=''0', 'I', 1, '2010-07-27 11:32:58', 15, 'S', '', 317, '127.0.0.1', 'disciplinetype_id', 'WW'),
('sim_hr_disciplineline', 'disciplineline_name=''WWSS''', 'U', 1, '2010-07-27 11:33:27', 1, 'S', '', 318, '127.0.0.1', 'disciplineline_id', 'WWSS'),
('sim_hr_disciplineline', 'isdeleted=', 'D', 1, '2010-07-27 11:34:15', 1, 'S', '', 319, '127.0.0.1', 'disciplineline_id', 'WWSS'),
('sim_hr_disciplineline', 'Record deleted permanentl', 'E', 1, '2010-07-27 11:34:18', 1, 'S', '', 320, '127.0.0.1', 'disciplineline_id', 'WWSS'),
('sim_hr_department', 'department_no=''sd''department_name=''DS''defaultlevel=''10''description=''''department_parent=''0''isactive=''1''created=''2010-07-27 11:52:51''createdby=''1''updated=''2010-07-27 11:52:51''updatedby=''1''organization_id=''1''department_head=''16', 'I', 1, '2010-07-27 11:52:51', 1, 'S', '', 321, '127.0.0.1', 'department_id', 'DS'),
('sim_hr_department', 'department_name=''DSs'',<br/>description=''dasdas''', 'U', 1, '2010-07-27 11:57:42', 1, 'S', '', 322, '127.0.0.1', 'department_id', 'DSs'),
('sim_hr_department', 'department_no=''s''department_name=''dd''defaultlevel=''10''description=''''department_parent=''0''isactive=''1''created=''2010-07-27 11:57:57''createdby=''1''updated=''2010-07-27 11:57:57''updatedby=''1''organization_id=''1''department_head=''0', 'I', 1, '2010-07-27 11:57:57', 2, 'S', '', 323, '127.0.0.1', 'department_id', 'dd'),
('sim_hr_department', 'department_no=''W''department_name=''RR''defaultlevel=''10''description=''''department_parent=''1''isactive=''1''created=''2010-07-27 11:59:49''createdby=''1''updated=''2010-07-27 11:59:49''updatedby=''1''organization_id=''1''department_head=''15', 'I', 1, '2010-07-27 11:59:49', 4, 'S', '', 324, '127.0.0.1', 'department_id', 'RR'),
('sim_hr_department', 'Record deleted permanentl', 'E', 1, '2010-07-27 12:00:10', 2, 'S', '', 325, '127.0.0.1', 'department_id', 's'),
('sim_hr_department', 'Record deleted permanentl', 'E', 1, '2010-07-27 12:00:58', 4, 'S', '', 326, '127.0.0.1', 'department_id', 'W'),
('sim_hr_department', 'department_no=''s''department_name=''ds''defaultlevel=''10''description=''''department_parent=''0''isactive=''1''created=''2010-07-27 12:02:02''createdby=''1''updated=''2010-07-27 12:02:02''updatedby=''1''organization_id=''1''department_head=''0', 'I', 1, '2010-07-27 12:02:02', 5, 'S', '', 327, '127.0.0.1', 'department_id', 'ds'),
('sim_hr_department', 'Record deleted permanentl', 'E', 1, '2010-07-27 12:02:08', 5, 'S', '', 328, '127.0.0.1', 'department_id', 's'),
('sim_hr_department', 'department_no=''aa''department_name=''ds''defaultlevel=''10''description=''''department_parent=''0''isactive=''1''created=''2010-07-27 12:02:13''createdby=''1''updated=''2010-07-27 12:02:13''updatedby=''1''organization_id=''1''department_head=''0', 'I', 1, '2010-07-27 12:02:13', 6, 'S', '', 329, '127.0.0.1', 'department_id', 'ds'),
('sim_hr_department', 'Record deleted permanentl', 'E', 1, '2010-07-27 12:02:18', 6, 'S', '', 330, '127.0.0.1', 'department_id', 'aa'),
('sim_hr_department', 'department_no=''asda''department_name=''dsa''defaultlevel=''10''description=''''department_parent=''0''isactive=''1''created=''2010-07-27 12:03:09''createdby=''1''updated=''2010-07-27 12:03:09''updatedby=''1''organization_id=''1''department_head=''0', 'I', 1, '2010-07-27 12:03:09', 7, 'S', '', 331, '127.0.0.1', 'department_id', 'dsa'),
('sim_hr_department', 'Record deleted permanentl', 'E', 1, '2010-07-27 12:03:14', 7, 'S', '', 332, '127.0.0.1', 'department_id', 'asda'),
('sim_hr_leaveadjustment', 'leavetype_id=''Mecdical Leave(9)''created=''10/07/27 12:05:07''createdby=''admin(1)''updated=''10/07/27 12:05:07''updatedby=''admin(1)''organization_id=''1', 'I', 1, '2010-07-27 12:05:07', 14, 'S', '', 333, '127.0.0.1', 'leaveadjustment_id', 'admin'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''14''employee_id=''16''leaveadjustmentline_totalday=''5''created=''2010-07-27 12:05:07''createdby=''1''updated=''2010-07-27 12:05:07''updatedby=''1', 'I', 1, '2010-07-27 12:05:08', 335, 'S', '', 334, '127.0.0.1', 'leaveadjustmentline_id', '14'),
('sim_hr_leaveadjustment', 'issubmit=''1''', 'U', 1, '2010-07-27 12:05:15', 14, 'S', '', 335, '127.0.0.1', 'leaveadjustment_id', '14'),
('sim_workflowtransaction', 'workflowtransaction_datetime=''10/07/27 12:05:15''target_groupid=''1''target_uid=''0''targetparameter_name=''''workflowstatus_id=''1''workflow_id=''8''tablename=''sim_hr_leaveadjustment''primarykey_name=''leaveadjustment_id''primarykey_value=''14''hyperlink=''''title_description=''''created=''10/07/27 12:05:15''list_parameter=''''workflowtransaction_description=''''workflowtransaction_feedback=''''iscomplete=''0''createdby=''1''email_list=''''sms_list=''''email_body=''''sms_body=''''person_id=''14''issubmit=''1', 'I', 1, '2010-07-27 12:05:15', 25, 'S', '', 336, '127.0.0.1', 'workflowtransaction_id', 'sim_hr_leaveadjustment'),
('sim_workflowtransactionhistory', 'workflowtransaction_id=''25''workflowstatus_id=''1''workflowtransaction_datetime=''10/07/27 12:05:15''uid=''1''workflowtransactionhistory_description=''', 'I', 1, '2010-07-27 12:05:15', 0, 'S', '', 337, '127.0.0.1', 'workflowtransactionhistory_id', ''),
('sim_workflowtransaction', 'workflowtransaction_datetime=''10/07/27 12:05:21''target_groupid=''1''target_uid=''1''targetparameter_name=''''workflowstatus_id=''2''workflow_id=''8''tablename=''sim_hr_leaveadjustment''primarykey_name=''leaveadjustment_id''primarykey_value=''14''hyperlink=''''title_description=''''created=''10/07/27 12:05:21''list_parameter=''''workflowtransaction_description=''''workflowtransaction_feedback=''''iscomplete=''1''createdby=''1''email_list=''''sms_list=''''email_body=''''sms_body=''''person_id=''14''issubmit=''1', 'I', 1, '2010-07-27 12:05:21', 26, 'S', '', 338, '127.0.0.1', 'workflowtransaction_id', 'sim_hr_leaveadjustment'),
('sim_workflowtransactionhistory', 'workflowtransaction_id=''26''workflowstatus_id=''2''workflowtransaction_datetime=''10/07/27 12:05:21''uid=''1''workflowtransactionhistory_description=''', 'I', 1, '2010-07-27 12:05:21', 0, 'S', '', 339, '127.0.0.1', 'workflowtransactionhistory_id', ''),
('sim_workflowtransaction', 'workflowtransaction_datetime=''10/07/27 12:11:29''target_groupid=''''target_uid=''''targetparameter_name=''''workflowstatus_id=''''workflow_id=''''tablename=''sim_hr_leaveadjustment''primarykey_name=''leaveadjustment_id''primarykey_value=''8''hyperlink=''''title_description=''''created=''10/07/27 12:11:29''list_parameter=''''workflowtransaction_description=''''workflowtransaction_feedback=''''iscomplete=''''createdby=''1''email_list=''''sms_list=''''email_body=''''sms_body=''''person_id=''14''issubmit=''', 'I', 1, '2010-07-27 12:11:29', 27, 'S', '', 340, '127.0.0.1', 'workflowtransaction_id', 'sim_hr_leaveadjustment'),
('sim_workflowtransactionhistory', 'workflowtransaction_id=''27''workflowstatus_id=''''workflowtransaction_datetime=''10/07/27 12:11:29''uid=''1''workflowtransactionhistory_description=''', 'I', 1, '2010-07-27 12:11:29', 0, 'S', '', 341, '127.0.0.1', 'workflowtransactionhistory_id', ''),
('sim_workflownode', 'target_groupid=''0'',<br/>target_uid='''',<br/>targetparameter_name=''{own_uid}'',<br/>iscomplete_node=''0''', 'U', 0, '2010-07-27 12:18:33', 24, 'S', '', 342, '127.0.0.1', 'workflownode_id', '10'),
('sim_workflownode', 'workflownode_id=''0''workflow_id=''4''sequence_no=''10''parentnode_id=''9''workflowstatus_id=''5''workflowuserchoice_id=''3''target_groupid=''0''target_uid=''''targetparameter_name=''{own_uid}''email_list=''''sms_list=''''workflow_procedure=''''email_body=''''sms_body=''''isemail=''1''issms=''1''workflow_description=''''parameter_used=''''created=''2010-07-27 12:19:23''createdby=''1''updated=''2010-07-27 12:19:23''updatedby=''1''isactive=''1''organization_id=''0''workflow_sql='',issubmit = 0''workflow_bypass=''''hyperlink=''''issubmit_node=''1''iscomplete_node=''0', 'I', 0, '2010-07-27 12:19:23', 34, 'S', '', 343, '127.0.0.1', 'workflownode_id', '10'),
('sim_workflownode', 'target_groupid=''1'',<br/>target_uid='''',<br/>targetparameter_name=''{hod_uid}'',<br/>email_list=''{own_uid},{hod_uid}'',<br/>sms_list=''{own_uid},{hod_uid}'',<br/>workflow_procedure=''../hr/generalclaim.php''', 'U', 0, '2010-07-27 12:22:01', 9, 'S', '', 344, '127.0.0.1', 'workflownode_id', '1'),
('sim_workflownode', 'target_uid='''',<br/>targetparameter_name=''{hod_uid}'',<br/>email_list=''{own_uid},{hod_uid}'',<br/>sms_list=''{own_uid},{hod_uid}'',<br/>workflow_procedure=''../hr/medicalclaim.php'',<br/>workflow_sql='',issubmit=1''', 'U', 0, '2010-07-27 12:25:17', 25, 'S', '', 345, '127.0.0.1', 'workflownode_id', '10'),
('sim_workflownode', 'target_uid='''',<br/>targetparameter_name=''{hod_uid}'',<br/>email_list=''{own_uid},{hod_uid}'',<br/>sms_list=''{own_uid},{hod_uid}'',<br/>workflow_procedure=''../hr/overtimeclaim.php'',<br/>workflow_sql='',issubmit=1''', 'U', 0, '2010-07-27 12:27:04', 27, 'S', '', 346, '127.0.0.1', 'workflownode_id', '10'),
('sim_workflownode', 'target_uid='''',<br/>targetparameter_name=''{hod_uid}'',<br/>email_list=''{own_uid},{hod_uid}'',<br/>sms_list=''{own_uid},{hod_uid}'',<br/>workflow_procedure=''../hr/travellingclaim.php'',<br/>workflow_sql='',issubmit=1''', 'U', 0, '2010-07-27 12:27:26', 30, 'S', '', 347, '127.0.0.1', 'workflownode_id', '10'),
('sim_workflownode', 'target_uid=''''', 'U', 0, '2010-07-27 12:30:47', 25, 'S', '', 348, '127.0.0.1', 'workflownode_id', '10'),
('sim_workflownode', 'target_uid='''',<br/>hyperlink=''../hr/medicalclaim.php''', 'U', 0, '2010-07-27 12:31:07', 26, 'S', '', 349, '127.0.0.1', 'workflownode_id', '10'),
('sim_workflownode', 'target_uid='''',<br/>hyperlink=''../hr/medicalclaim.php''', 'U', 0, '2010-07-27 12:32:56', 33, 'S', '', 350, '127.0.0.1', 'workflownode_id', '10'),
('sim_workflownode', 'target_uid='''',<br/>hyperlink=''../hr/generalclaim.php''', 'U', 0, '2010-07-27 12:33:29', 20, 'S', '', 351, '127.0.0.1', 'workflownode_id', '10'),
('sim_workflownode', 'target_uid='''',<br/>workflow_sql='',issubmit = 0, iscomplete = 0''', 'U', 0, '2010-07-27 12:34:11', 34, 'S', '', 352, '127.0.0.1', 'workflownode_id', '10'),
('sim_workflownode', 'target_uid='''',<br/>issubmit_node=''0''', 'U', 0, '2010-07-27 12:34:19', 34, 'S', '', 353, '127.0.0.1', 'workflownode_id', '10'),
('sim_workflownode', 'target_uid='''',<br/>isemail=''0'',<br/>issms=''0''', 'U', 0, '2010-07-27 12:34:24', 34, 'S', '', 354, '127.0.0.1', 'workflownode_id', '10'),
('sim_workflownode', 'workflownode_id=''0''workflow_id=''11''sequence_no=''10''parentnode_id=''30''workflowstatus_id=''5''workflowuserchoice_id=''3''target_groupid=''0''target_uid=''''targetparameter_name=''{own_uid}''email_list=''''sms_list=''''workflow_procedure=''''email_body=''''sms_body=''''isemail=''0''issms=''0''workflow_description=''''parameter_used=''''created=''2010-07-27 12:35:16''createdby=''1''updated=''2010-07-27 12:35:16''updatedby=''1''isactive=''1''organization_id=''0''workflow_sql=''''workflow_bypass=''''hyperlink=''''issubmit_node=''0''iscomplete_node=''0', 'I', 0, '2010-07-27 12:35:16', 35, 'S', '', 355, '127.0.0.1', 'workflownode_id', '10'),
('sim_workflownode', 'target_uid=''''', 'U', 0, '2010-07-27 12:35:25', 35, 'S', '', 356, '127.0.0.1', 'workflownode_id', '10'),
('sim_workflownode', 'target_uid='''',<br/>workflow_sql='', issubmit=0, iscomplete=0''', 'U', 0, '2010-07-27 12:35:59', 35, 'S', '', 357, '127.0.0.1', 'workflownode_id', '10'),
('sim_workflownode', 'workflownode_id=''0''workflow_id=''9''sequence_no=''10''parentnode_id=''27''workflowstatus_id=''5''workflowuserchoice_id=''3''target_groupid=''0''target_uid=''''targetparameter_name=''{own_uid}''email_list=''''sms_list=''''workflow_procedure=''''email_body=''''sms_body=''''isemail=''1''issms=''1''workflow_description=''''parameter_used=''''created=''2010-07-27 14:03:23''createdby=''1''updated=''2010-07-27 14:03:23''updatedby=''1''isactive=''1''organization_id=''0''workflow_sql=''''workflow_bypass=''''hyperlink=''''issubmit_node=''0''iscomplete_node=''0', 'I', 0, '2010-07-27 14:03:23', 36, 'S', '', 358, '127.0.0.1', 'workflownode_id', '10');
INSERT INTO `sim_audit` (`tablename`, `changedesc`, `category`, `uid`, `updated`, `record_id`, `eventype`, `uname`, `audit_id`, `ip`, `primarykey`, `controlvalue`) VALUES
('sim_workflownode', 'workflownode_id=''0''workflow_id=''0''sequence_no=''0''parentnode_id=''0''workflowstatus_id=''0''workflowuserchoice_id=''0''target_groupid=''0''target_uid=''''targetparameter_name=''''email_list=''''sms_list=''''workflow_procedure=''''email_body=''''sms_body=''''isemail=''0''issms=''0''workflow_description=''''parameter_used=''''created=''2010-07-27 14:03:26''createdby=''1''updated=''2010-07-27 14:03:26''updatedby=''1''isactive=''1''organization_id=''0''workflow_sql=''''workflow_bypass=''''hyperlink=''''issubmit_node=''0''iscomplete_node=''0', 'I', 0, '2010-07-27 14:03:26', 37, 'S', '', 359, '127.0.0.1', 'workflownode_id', '0'),
('sim_workflownode', 'target_uid='''',<br/>issms=''0''', 'U', 0, '2010-07-27 14:03:42', 36, 'S', '', 360, '127.0.0.1', 'workflownode_id', '10'),
('sim_workflownode', 'workflownode_id=''0''workflow_id=''10''sequence_no=''10''parentnode_id=''25''workflowstatus_id=''5''workflowuserchoice_id=''3''target_groupid=''0''target_uid=''''targetparameter_name=''{own_uid}''email_list=''''sms_list=''''workflow_procedure=''''email_body=''''sms_body=''''isemail=''1''issms=''1''workflow_description=''''parameter_used=''''created=''2010-07-27 14:03:57''createdby=''1''updated=''2010-07-27 14:03:57''updatedby=''1''isactive=''1''organization_id=''0''workflow_sql=''''workflow_bypass=''''hyperlink=''''issubmit_node=''1''iscomplete_node=''0', 'I', 0, '2010-07-27 14:03:57', 38, 'S', '', 361, '127.0.0.1', 'workflownode_id', '10'),
('sim_workflownode', 'target_uid='''',<br/>issubmit_node=''0''', 'U', 0, '2010-07-27 14:04:03', 38, 'S', '', 362, '127.0.0.1', 'workflownode_id', '10'),
('sim_workflownode', 'target_uid='''',<br/>isemail=''0'',<br/>issms=''0''', 'U', 0, '2010-07-27 14:04:08', 38, 'S', '', 363, '127.0.0.1', 'workflownode_id', '10'),
('sim_workflownode', 'target_uid='''',<br/>workflow_procedure=''../hr/overtimeclaim.php''', 'U', 0, '2010-07-27 14:04:44', 28, 'S', '', 364, '127.0.0.1', 'workflownode_id', '10'),
('sim_workflownode', 'target_uid='''',<br/>workflow_procedure=''../hr/overtimeclaim.php'',<br/>workflow_sql='',issubmit=1,iscomplete=1''', 'U', 0, '2010-07-27 14:05:03', 29, 'S', '', 365, '127.0.0.1', 'workflownode_id', '10'),
('sim_workflownode', 'target_uid='''',<br/>workflow_procedure=''../hr/travellingclaim.php'',<br/>workflow_sql='',issubmit=1,iscomplete=1''', 'U', 0, '2010-07-27 14:06:16', 31, 'S', '', 366, '127.0.0.1', 'workflownode_id', '10'),
('sim_workflownode', 'target_uid='''',<br/>workflow_sql='',issubmit=1,iscomplete=1''', 'U', 0, '2010-07-27 14:06:29', 32, 'S', '', 367, '127.0.0.1', 'workflownode_id', '10'),
('sim_workflownode', 'target_uid='''',<br/>workflow_procedure=''../hr/travellingclaim.php''', 'U', 0, '2010-07-27 14:06:38', 32, 'S', '', 368, '127.0.0.1', 'workflownode_id', '10'),
('sim_workflownode', 'target_uid='''',<br/>workflow_procedure='''',<br/>hyperlink=''../hr/overtimeclaim.php''', 'U', 0, '2010-07-27 14:07:15', 28, 'S', '', 369, '127.0.0.1', 'workflownode_id', '10'),
('sim_workflownode', 'target_uid='''',<br/>workflow_procedure='''',<br/>hyperlink=''../hr/generalclaim.php''', 'U', 0, '2010-07-27 14:07:25', 9, 'S', '', 370, '127.0.0.1', 'workflownode_id', '1'),
('sim_workflownode', 'target_uid='''',<br/>workflow_procedure='''',<br/>hyperlink=''../hr/travellingclaim.php''', 'U', 0, '2010-07-27 14:08:04', 30, 'S', '', 371, '127.0.0.1', 'workflownode_id', '10'),
('sim_workflownode', 'target_uid='''',<br/>workflow_procedure='''',<br/>hyperlink=''../hr/travellingclaim.php''', 'U', 0, '2010-07-27 14:08:13', 31, 'S', '', 372, '127.0.0.1', 'workflownode_id', '10'),
('sim_workflownode', 'target_uid='''',<br/>hyperlink=''../hr/travellingclaim.php'',<br/>issubmit_node=''1''', 'U', 0, '2010-07-27 14:08:21', 35, 'S', '', 373, '127.0.0.1', 'workflownode_id', '10'),
('sim_workflownode', 'target_uid='''',<br/>workflow_procedure='''',<br/>hyperlink=''../hr/overtimeclaim.php''', 'U', 0, '2010-07-27 14:08:34', 27, 'S', '', 374, '127.0.0.1', 'workflownode_id', '10'),
('sim_workflownode', 'target_uid='''',<br/>workflow_procedure='''',<br/>hyperlink=''../hr/overtimeclaim.php''', 'U', 0, '2010-07-27 14:08:46', 29, 'S', '', 375, '127.0.0.1', 'workflownode_id', '10'),
('sim_hr_employeegroup', 'employeegroup_no=''WE''employeegroup_name=''Webmaster''islecturer=''1''isovertime=''1''isparttime=''1''isactive=''1''defaultlevel=''10''created=''2010-07-27 14:13:22''createdby=''1''updated=''2010-07-27 14:13:22''updatedby=''1''organization_id=''1''description=''EEER', 'I', 1, '2010-07-27 14:13:22', 16, 'S', '', 376, '127.0.0.1', 'employeegroup_id', 'WE'),
('sim_hr_employeegroup', 'description=''ERRR''', 'U', 1, '2010-07-27 14:14:53', 13, 'S', '', 377, '127.0.0.1', 'employeegroup_id', 'CLF'),
('sim_hr_employeegroup', 'isdeleted=', 'D', 1, '2010-07-27 14:15:23', 16, 'S', '', 378, '127.0.0.1', 'employeegroup_id', 'WE'),
('sim_hr_employeegroup', 'Record deleted permanentl', 'E', 1, '2010-07-27 14:15:36', 16, 'S', '', 379, '127.0.0.1', 'employeegroup_id', 'WE'),
('sim_hr_employeegroup', 'isdeleted=', 'D', 1, '2010-07-27 14:18:11', 13, 'S', '', 380, '127.0.0.1', 'employeegroup_id', 'CLF'),
('sim_hr_employeegroup', 'isdeleted=', 'D', 1, '2010-07-27 14:20:11', 14, 'S', '', 381, '127.0.0.1', 'employeegroup_id', 'OF'),
('sim_hr_employeegroup', 'isdeleted=''0''', 'U', 1, '2010-07-27 14:20:37', 13, 'S', '', 382, '127.0.0.1', 'employeegroup_id', 'CLF'),
('sim_hr_employeegroup', 'isdeleted=''0''', 'U', 1, '2010-07-27 14:20:37', 14, 'S', '', 383, '127.0.0.1', 'employeegroup_id', 'OF'),
('sim_hr_employeegroup', 'isdeleted=', 'D', 1, '2010-07-27 14:20:37', 10, 'S', '', 384, '127.0.0.1', 'employeegroup_id', 'LP'),
('sim_hr_employeegroup', 'isdeleted=''0''', 'U', 1, '2010-07-27 14:20:44', 10, 'S', '', 385, '127.0.0.1', 'employeegroup_id', 'LP'),
('sim_hr_employeegroup', 'isdeleted=', 'D', 1, '2010-07-27 14:20:44', 14, 'S', '', 386, '127.0.0.1', 'employeegroup_id', 'OF'),
('sim_hr_employeegroup', 'isdeleted=', 'D', 1, '2010-07-27 14:20:47', 13, 'S', '', 387, '127.0.0.1', 'employeegroup_id', 'CLF'),
('sim_hr_employeegroup', 'isdeleted=''0''', 'U', 1, '2010-07-27 14:20:57', 13, 'S', '', 388, '127.0.0.1', 'employeegroup_id', 'CLF'),
('sim_hr_employeegroup', 'isdeleted=''0''', 'U', 1, '2010-07-27 14:20:57', 14, 'S', '', 389, '127.0.0.1', 'employeegroup_id', 'OF'),
('sim_hr_employeegroup', 'isdeleted=', 'D', 1, '2010-07-27 14:20:57', 10, 'S', '', 390, '127.0.0.1', 'employeegroup_id', 'LP'),
('sim_hr_employeegroup', 'isdeleted=', 'D', 1, '2010-07-27 14:24:48', 13, 'S', '', 391, '127.0.0.1', 'employeegroup_id', 'CLF'),
('sim_hr_employeegroup', 'isdeleted=', 'D', 1, '2010-07-27 14:24:51', 14, 'S', '', 392, '127.0.0.1', 'employeegroup_id', 'OF'),
('sim_hr_employeegroup', 'isdeleted=''0''', 'U', 1, '2010-07-27 14:24:59', 13, 'S', '', 393, '127.0.0.1', 'employeegroup_id', 'CLF'),
('sim_hr_employeegroup', 'isdeleted=''0''', 'U', 1, '2010-07-27 14:25:00', 14, 'S', '', 394, '127.0.0.1', 'employeegroup_id', 'OF'),
('sim_hr_employeegroup', 'isdeleted=', 'D', 1, '2010-07-27 14:25:00', 11, 'S', '', 395, '127.0.0.1', 'employeegroup_id', 'DF'),
('sim_hr_employeegroup', 'isdeleted=''0''', 'U', 1, '2010-07-27 14:26:26', 11, 'S', '', 396, '127.0.0.1', 'employeegroup_id', 'DF'),
('sim_hr_employeegroup', 'isdeleted=''0''', 'U', 1, '2010-07-27 14:26:26', 10, 'S', '', 397, '127.0.0.1', 'employeegroup_id', 'LP'),
('sim_hr_employeegroup', 'isdeleted=', 'D', 1, '2010-07-27 14:27:55', 13, 'S', '', 398, '127.0.0.1', 'employeegroup_id', 'CLF'),
('sim_hr_department', 'department_no=''dd''department_name=''FF''defaultlevel=''10''description=''dfdfds''department_parent=''1''isactive=''1''created=''2010-07-27 14:37:24''createdby=''1''updated=''2010-07-27 14:37:24''updatedby=''1''organization_id=''1''department_head=''0', 'I', 1, '2010-07-27 14:37:24', 8, 'S', '', 399, '127.0.0.1', 'department_id', 'FF'),
('sim_hr_department', 'department_no=''D''department_name=''SD''defaultlevel=''10''description=''''department_parent=''8''isactive=''1''created=''2010-07-27 14:41:39''createdby=''1''updated=''2010-07-27 14:41:39''updatedby=''1''organization_id=''1''department_head=''0', 'I', 1, '2010-07-27 14:41:39', 9, 'S', '', 400, '127.0.0.1', 'department_id', 'SD'),
('sim_hr_department', 'department_no=''16''department_name=''1''defaultlevel=''10''description=''''department_parent=''9''isactive=''1''created=''2010-07-27 14:41:44''createdby=''1''updated=''2010-07-27 14:41:44''updatedby=''1''organization_id=''1''department_head=''0', 'I', 1, '2010-07-27 14:41:45', 10, 'S', '', 401, '127.0.0.1', 'department_id', '1'),
('sim_hr_department', 'department_no=''2''department_name=''2''defaultlevel=''10''description=''''department_parent=''10''isactive=''1''created=''2010-07-27 14:41:48''createdby=''1''updated=''2010-07-27 14:41:48''updatedby=''1''organization_id=''1''department_head=''0', 'I', 1, '2010-07-27 14:41:48', 11, 'S', '', 402, '127.0.0.1', 'department_id', '2'),
('sim_hr_department', 'department_no=''3''department_name=''3''defaultlevel=''10''description=''''department_parent=''11''isactive=''1''created=''2010-07-27 14:41:52''createdby=''1''updated=''2010-07-27 14:41:52''updatedby=''1''organization_id=''1''department_head=''0', 'I', 1, '2010-07-27 14:41:52', 12, 'S', '', 403, '127.0.0.1', 'department_id', '3'),
('sim_hr_department', 'department_no=''4''department_name=''4''defaultlevel=''10''description=''''department_parent=''8''isactive=''1''created=''2010-07-27 14:41:59''createdby=''1''updated=''2010-07-27 14:41:59''updatedby=''1''organization_id=''1''department_head=''0', 'I', 1, '2010-07-27 14:41:59', 13, 'S', '', 404, '127.0.0.1', 'department_id', '4'),
('sim_hr_department', 'department_no=''5''department_name=''5''defaultlevel=''10''description=''''department_parent=''9''isactive=''1''created=''2010-07-27 14:42:04''createdby=''1''updated=''2010-07-27 14:42:04''updatedby=''1''organization_id=''1''department_head=''0', 'I', 1, '2010-07-27 14:42:04', 14, 'S', '', 405, '127.0.0.1', 'department_id', '5'),
('sim_hr_department', 'department_no=''6''department_name=''6''defaultlevel=''10''description=''''department_parent=''13''isactive=''1''created=''2010-07-27 14:42:18''createdby=''1''updated=''2010-07-27 14:42:18''updatedby=''1''organization_id=''1''department_head=''0', 'I', 1, '2010-07-27 14:42:18', 15, 'S', '', 406, '127.0.0.1', 'department_id', '6'),
('sim_hr_department', 'department_no=''7''department_name=''7''defaultlevel=''10''description=''''department_parent=''11''isactive=''1''created=''2010-07-27 14:42:24''createdby=''1''updated=''2010-07-27 14:42:24''updatedby=''1''organization_id=''1''department_head=''0', 'I', 1, '2010-07-27 14:42:24', 16, 'S', '', 407, '127.0.0.1', 'department_id', '7'),
('sim_hr_department', 'department_no=''8''department_name=''8''defaultlevel=''10''description=''''department_parent=''16''isactive=''1''created=''2010-07-27 14:42:56''createdby=''1''updated=''2010-07-27 14:42:56''updatedby=''1''organization_id=''1''department_head=''0', 'I', 1, '2010-07-27 14:42:56', 17, 'S', '', 408, '127.0.0.1', 'department_id', '8'),
('sim_hr_department', 'department_no=''9''department_name=''9''defaultlevel=''10''description=''''department_parent=''12''isactive=''1''created=''2010-07-27 14:43:02''createdby=''1''updated=''2010-07-27 14:43:02''updatedby=''1''organization_id=''1''department_head=''0', 'I', 1, '2010-07-27 14:43:02', 18, 'S', '', 409, '127.0.0.1', 'department_id', '9'),
('sim_hr_department', 'department_no=''10''department_name=''10''defaultlevel=''10''description=''''department_parent=''18''isactive=''1''created=''2010-07-27 14:43:09''createdby=''1''updated=''2010-07-27 14:43:09''updatedby=''1''organization_id=''1''department_head=''0', 'I', 1, '2010-07-27 14:43:09', 19, 'S', '', 410, '127.0.0.1', 'department_id', '10'),
('sim_hr_department', 'department_no=''34''department_name=''34''defaultlevel=''10''description=''''department_parent=''10''isactive=''1''created=''2010-07-27 14:43:24''createdby=''1''updated=''2010-07-27 14:43:24''updatedby=''1''organization_id=''1''department_head=''0', 'I', 1, '2010-07-27 14:43:24', 20, 'S', '', 411, '127.0.0.1', 'department_id', '34'),
('sim_hr_department', 'department_no=''as''department_name=''sa''defaultlevel=''10''description=''''department_parent=''12''isactive=''1''created=''2010-07-27 14:44:37''createdby=''1''updated=''2010-07-27 14:44:37''updatedby=''1''organization_id=''1''department_head=''0', 'I', 1, '2010-07-27 14:44:37', 21, 'S', '', 412, '127.0.0.1', 'department_id', 'sa'),
('sim_hr_jobposition', 'isdeleted=', 'D', 1, '2010-07-27 15:27:34', 54, 'S', '', 413, '127.0.0.1', 'jobposition_id', '5'),
('sim_window', 'window_name=''Leave Type''', 'U', 0, '2010-07-27 15:31:15', 21, 'S', '', 414, '127.0.0.1', 'window_id', 'Leave Type'),
('sim_hr_disciplinetype', 'disciplinetype_name=''WW''isactive=''1''defaultlevel=''10''created=''2010-07-27 15:33:07''createdby=''1''updated=''2010-07-27 15:33:07''updatedby=''1''organization_id=''1''description=''dd', 'I', 1, '2010-07-27 15:33:07', 22, 'S', '', 415, '127.0.0.1', 'disciplinetype_id', 'WW'),
('sim_hr_disciplinetype', 'description=''eeee''', 'U', 1, '2010-07-27 15:33:23', 22, 'S', '', 416, '127.0.0.1', 'disciplinetype_id', 'WW'),
('sim_hr_disciplinetype', 'description=''eeeee''', 'U', 1, '2010-07-27 15:33:23', 15, 'S', '', 417, '127.0.0.1', 'disciplinetype_id', 'Puching'),
('sim_hr_employee', 'employee_name=''GoD''employee_cardno=''''employee_no=''EM0023''uid=''''place_dob=''''employee_dob=''1945-07-29''races_id=''0''religion_id=''4''gender=''M''marital_status=''M''employee_citizenship=''3''employee_newicno=''''employee_oldicno=''''ic_color=''B''employee_passport=''''employee_bloodgroup=''A+B''department_id=''''jobposition_id=''55''employeegroup_id=''12''employee_joindate=''2010-07-21''filephoto=''1280217372_photofile.png''created=''2010-07-27 15:56:12''createdby=''1''updated=''2010-07-27 15:56:12''updatedby=''1''defaultlevel=''''organization_id=''''employee_transport=''Car''employee_status=''1', 'I', 1, '2010-07-27 15:56:12', 18, 'S', '', 418, '127.0.0.1', 'employee_id', 'GoD'),
('sim_hr_employee', 'defaultlevel='''',<br/>organization_id=''''', 'U', 1, '2010-07-27 15:58:30', 18, 'S', '', 419, '127.0.0.1', 'employee_id', 'EM0023'),
('sim_hr_employee', 'defaultlevel='''',<br/>organization_id=''''', 'U', 1, '2010-07-27 16:01:52', 18, 'S', '', 420, '127.0.0.1', 'employee_id', 'EM0023'),
('sim_hr_attachmentline', 'attachmentline_name=''select''attachmentline_file=''1280219330_18.pdf''attachmentline_remarks='' ''employee_id=''18''created=''2010-07-27 16:28:50''createdby=''1''updated=''2010-07-27 16:28:50''updatedby=''1', 'I', 1, '2010-07-27 16:28:50', 3, 'S', '', 421, '127.0.0.1', 'attachmentline_id', 'select'),
('sim_hr_leaveadjustment', 'leavetype_id=''Mecdical Leave(9)''created=''10/07/27 17:21:53''createdby=''admin(1)''updated=''10/07/27 17:21:53''updatedby=''admin(1)''organization_id=''1', 'I', 1, '2010-07-27 17:21:53', 15, 'S', '', 422, '127.0.0.1', 'leaveadjustment_id', 'admin'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''15''employee_id=''14''leaveadjustmentline_totalday=''0''created=''2010-07-27 17:21:53''createdby=''1''updated=''2010-07-27 17:21:53''updatedby=''1', 'I', 1, '2010-07-27 17:21:53', 336, 'S', '', 423, '127.0.0.1', 'leaveadjustmentline_id', '15'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''15''employee_id=''14''leaveadjustmentline_totalday=''3''created=''2010-07-27 17:21:53''createdby=''1''updated=''2010-07-27 17:21:53''updatedby=''1', 'I', 1, '2010-07-27 17:21:53', 337, 'S', '', 424, '127.0.0.1', 'leaveadjustmentline_id', '15'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''15''employee_id=''16''leaveadjustmentline_totalday=''4''created=''2010-07-27 17:21:53''createdby=''1''updated=''2010-07-27 17:21:53''updatedby=''1', 'I', 1, '2010-07-27 17:21:53', 338, 'S', '', 425, '127.0.0.1', 'leaveadjustmentline_id', '15'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''15''employee_id=''17''leaveadjustmentline_totalday=''5''created=''2010-07-27 17:21:53''createdby=''1''updated=''2010-07-27 17:21:53''updatedby=''1', 'I', 1, '2010-07-27 17:21:53', 339, 'S', '', 426, '127.0.0.1', 'leaveadjustmentline_id', '15'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''15''employee_id=''18''leaveadjustmentline_totalday=''4''created=''2010-07-27 17:21:53''createdby=''1''updated=''2010-07-27 17:21:53''updatedby=''1', 'I', 1, '2010-07-27 17:21:53', 340, 'S', '', 427, '127.0.0.1', 'leaveadjustmentline_id', '15'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''15''employee_id=''15''leaveadjustmentline_totalday=''1''created=''2010-07-27 17:21:53''createdby=''1''updated=''2010-07-27 17:21:53''updatedby=''1', 'I', 1, '2010-07-27 17:21:53', 341, 'S', '', 428, '127.0.0.1', 'leaveadjustmentline_id', '15'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''15''employee_id=''14''leaveadjustmentline_totalday=''3''created=''2010-07-27 17:21:53''createdby=''1''updated=''2010-07-27 17:21:53''updatedby=''1', 'I', 1, '2010-07-27 17:21:53', 342, 'S', '', 429, '127.0.0.1', 'leaveadjustmentline_id', '15'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''15''employee_id=''16''leaveadjustmentline_totalday=''3''created=''2010-07-27 17:21:53''createdby=''1''updated=''2010-07-27 17:21:53''updatedby=''1', 'I', 1, '2010-07-27 17:21:53', 343, 'S', '', 430, '127.0.0.1', 'leaveadjustmentline_id', '15'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''15''employee_id=''17''leaveadjustmentline_totalday=''3''created=''2010-07-27 17:21:53''createdby=''1''updated=''2010-07-27 17:21:53''updatedby=''1', 'I', 1, '2010-07-27 17:21:53', 344, 'S', '', 431, '127.0.0.1', 'leaveadjustmentline_id', '15'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''15''employee_id=''18''leaveadjustmentline_totalday=''3''created=''2010-07-27 17:21:53''createdby=''1''updated=''2010-07-27 17:21:53''updatedby=''1', 'I', 1, '2010-07-27 17:21:53', 345, 'S', '', 432, '127.0.0.1', 'leaveadjustmentline_id', '15'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''15''employee_id=''15''leaveadjustmentline_totalday=''3''created=''2010-07-27 17:21:53''createdby=''1''updated=''2010-07-27 17:21:53''updatedby=''1', 'I', 1, '2010-07-27 17:21:53', 346, 'S', '', 433, '127.0.0.1', 'leaveadjustmentline_id', '15'),
('sim_hr_leaveadjustment', 'issubmit=''1''', 'U', 1, '2010-07-27 17:22:31', 15, 'S', '', 434, '127.0.0.1', 'leaveadjustment_id', '15'),
('sim_workflowtransaction', 'workflowtransaction_datetime=''10/07/27 17:22:31''target_groupid=''1''target_uid=''0''targetparameter_name=''''workflowstatus_id=''1''workflow_id=''8''tablename=''sim_hr_leaveadjustment''primarykey_name=''leaveadjustment_id''primarykey_value=''15''hyperlink=''''title_description=''''created=''10/07/27 17:22:31''list_parameter=''''workflowtransaction_description=''''workflowtransaction_feedback=''''iscomplete=''0''createdby=''1''email_list=''''sms_list=''''email_body=''''sms_body=''''person_id=''14''issubmit=''1', 'I', 1, '2010-07-27 17:22:31', 28, 'S', '', 435, '127.0.0.1', 'workflowtransaction_id', 'sim_hr_leaveadjustment'),
('sim_workflowtransactionhistory', 'workflowtransaction_id=''28''workflowstatus_id=''1''workflowtransaction_datetime=''10/07/27 17:22:31''uid=''1''workflowtransactionhistory_description=''', 'I', 1, '2010-07-27 17:22:31', 0, 'S', '', 436, '127.0.0.1', 'workflowtransactionhistory_id', ''),
('sim_workflowtransaction', 'workflowtransaction_datetime=''10/07/27 17:23:32''target_groupid=''1''target_uid=''1''targetparameter_name=''''workflowstatus_id=''2''workflow_id=''8''tablename=''sim_hr_leaveadjustment''primarykey_name=''leaveadjustment_id''primarykey_value=''15''hyperlink=''''title_description=''''created=''10/07/27 17:23:32''list_parameter=''''workflowtransaction_description=''''workflowtransaction_feedback=''WWW''iscomplete=''1''createdby=''1''email_list=''''sms_list=''''email_body=''''sms_body=''''person_id=''14''issubmit=''1', 'I', 1, '2010-07-27 17:23:32', 29, 'S', '', 437, '127.0.0.1', 'workflowtransaction_id', 'sim_hr_leaveadjustment'),
('sim_workflowtransactionhistory', 'workflowtransaction_id=''29''workflowstatus_id=''2''workflowtransaction_datetime=''10/07/27 17:23:32''uid=''1''workflowtransactionhistory_description=''', 'I', 1, '2010-07-27 17:23:32', 0, 'S', '', 438, '127.0.0.1', 'workflowtransactionhistory_id', ''),
('sim_hr_employee', 'employee_name=''KS Tan''employee_cardno=''''employee_no=''K001''uid=''''place_dob=''''employee_dob=''2010-07-20''races_id=''1''religion_id=''1''gender=''M''marital_status=''M''employee_citizenship=''2''employee_newicno=''''employee_oldicno=''''ic_color=''B''employee_passport=''''employee_bloodgroup=''''department_id=''''jobposition_id=''''employeegroup_id=''12''employee_joindate=''2010-07-14''filephoto=''''created=''2010-07-27 17:27:04''createdby=''1''updated=''2010-07-27 17:27:04''updatedby=''1''defaultlevel=''''organization_id=''''employee_transport=''''employee_status=''1', 'I', 1, '2010-07-27 17:27:04', 19, 'S', '', 439, '127.0.0.1', 'employee_id', 'KS Tan'),
('sim_hr_leaveadjustment', 'leavetype_id=''Mecdical Leave(9)''created=''10/07/27 17:27:46''createdby=''admin(1)''updated=''10/07/27 17:27:46''updatedby=''admin(1)''organization_id=''1', 'I', 1, '2010-07-27 17:27:46', 16, 'S', '', 440, '127.0.0.1', 'leaveadjustment_id', 'admin'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''16''employee_id=''19''leaveadjustmentline_totalday=''3''created=''2010-07-27 17:27:46''createdby=''1''updated=''2010-07-27 17:27:46''updatedby=''1', 'I', 1, '2010-07-27 17:27:46', 347, 'S', '', 441, '127.0.0.1', 'leaveadjustmentline_id', '16'),
('sim_hr_leaveadjustment', 'leavetype_id=''Annul Leave(8)''created=''10/07/27 17:28:37''createdby=''admin(1)''updated=''10/07/27 17:28:37''updatedby=''admin(1)''organization_id=''1', 'I', 1, '2010-07-27 17:28:37', 17, 'S', '', 442, '127.0.0.1', 'leaveadjustment_id', 'admin'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''17''employee_id=''19''leaveadjustmentline_totalday=''5''created=''2010-07-27 17:28:37''createdby=''1''updated=''2010-07-27 17:28:37''updatedby=''1', 'I', 1, '2010-07-27 17:28:37', 348, 'S', '', 443, '127.0.0.1', 'leaveadjustmentline_id', '17'),
('sim_hr_leaveadjustment', 'leavetype_id=''Birthday Leave(10)''created=''10/07/27 17:29:19''createdby=''admin(1)''updated=''10/07/27 17:29:19''updatedby=''admin(1)''organization_id=''1', 'I', 1, '2010-07-27 17:29:19', 18, 'S', '', 444, '127.0.0.1', 'leaveadjustment_id', 'admin'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''18''employee_id=''19''leaveadjustmentline_totalday=''6''created=''2010-07-27 17:29:19''createdby=''1''updated=''2010-07-27 17:29:19''updatedby=''1', 'I', 1, '2010-07-27 17:29:19', 349, 'S', '', 445, '127.0.0.1', 'leaveadjustmentline_id', '18'),
('sim_hr_leaveadjustment', 'leavetype_id=''Birthday Leave(10)''created=''10/07/27 17:37:43''createdby=''admin(1)''updated=''10/07/27 17:37:43''updatedby=''admin(1)''organization_id=''1', 'I', 1, '2010-07-27 17:37:43', 19, 'S', '', 446, '127.0.0.1', 'leaveadjustment_id', 'admin'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''19''employee_id=''14''leaveadjustmentline_totalday=''1''created=''2010-07-27 17:37:43''createdby=''1''updated=''2010-07-27 17:37:43''updatedby=''1', 'I', 1, '2010-07-27 17:37:43', 350, 'S', '', 447, '127.0.0.1', 'leaveadjustmentline_id', '19'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''19''employee_id=''16''leaveadjustmentline_totalday=''0''created=''2010-07-27 17:37:43''createdby=''1''updated=''2010-07-27 17:37:43''updatedby=''1', 'I', 1, '2010-07-27 17:37:43', 351, 'S', '', 448, '127.0.0.1', 'leaveadjustmentline_id', '19'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''19''employee_id=''17''leaveadjustmentline_totalday=''1''created=''2010-07-27 17:37:43''createdby=''1''updated=''2010-07-27 17:37:43''updatedby=''1', 'I', 1, '2010-07-27 17:37:43', 352, 'S', '', 449, '127.0.0.1', 'leaveadjustmentline_id', '19'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''19''employee_id=''18''leaveadjustmentline_totalday=''1''created=''2010-07-27 17:37:43''createdby=''1''updated=''2010-07-27 17:37:43''updatedby=''1', 'I', 1, '2010-07-27 17:37:43', 353, 'S', '', 450, '127.0.0.1', 'leaveadjustmentline_id', '19'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''19''employee_id=''15''leaveadjustmentline_totalday=''0''created=''2010-07-27 17:37:43''createdby=''1''updated=''2010-07-27 17:37:43''updatedby=''1', 'I', 1, '2010-07-27 17:37:43', 354, 'S', '', 451, '127.0.0.1', 'leaveadjustmentline_id', '19'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''19''employee_id=''19''leaveadjustmentline_totalday=''1''created=''2010-07-27 17:37:43''createdby=''1''updated=''2010-07-27 17:37:43''updatedby=''1', 'I', 1, '2010-07-27 17:37:43', 355, 'S', '', 452, '127.0.0.1', 'leaveadjustmentline_id', '19'),
('sim_hr_leaveadjustmentline', 'Record deleted permanentl', 'E', 1, '2010-07-27 17:40:25', 354, 'S', '', 453, '127.0.0.1', 'leaveadjustmentline_id', 'No Have'),
('sim_hr_leaveadjustmentline', 'leaveadjustmentline_totalday=''6''', 'U', 1, '2010-07-27 17:40:53', 351, 'S', '', 454, '127.0.0.1', 'leaveadjustmentline_id', ''),
('sim_hr_leaveadjustment', 'Record deleted permanentl', 'E', 1, '2010-07-27 17:43:53', 19, 'S', '', 455, '127.0.0.1', 'leaveadjustment_id', '19'),
('sim_hr_leaveadjustment', 'Record deleted permanentl', 'E', 1, '2010-07-27 17:45:53', 17, 'S', '', 456, '127.0.0.1', 'leaveadjustment_id', '17'),
('sim_workflowtransaction', 'workflowtransaction_datetime=''10/07/27 17:48:34''target_groupid=''''target_uid=''''targetparameter_name=''''workflowstatus_id=''''workflow_id=''''tablename=''sim_hr_leaveadjustment''primarykey_name=''leaveadjustment_id''primarykey_value=''4''hyperlink=''''title_description=''''created=''10/07/27 17:48:34''list_parameter=''''workflowtransaction_description=''''workflowtransaction_feedback=''''iscomplete=''''createdby=''1''email_list=''''sms_list=''''email_body=''''sms_body=''''person_id=''14''issubmit=''', 'I', 1, '2010-07-27 17:48:34', 30, 'S', '', 457, '127.0.0.1', 'workflowtransaction_id', 'sim_hr_leaveadjustment'),
('sim_workflowtransactionhistory', 'workflowtransaction_id=''30''workflowstatus_id=''''workflowtransaction_datetime=''10/07/27 17:48:34''uid=''1''workflowtransactionhistory_description=''', 'I', 1, '2010-07-27 17:48:34', 0, 'S', '', 458, '127.0.0.1', 'workflowtransactionhistory_id', ''),
('sim_workflowtransaction', 'workflowtransaction_datetime=''10/07/27 18:07:23''target_groupid=''1''target_uid=''0''targetparameter_name=''''workflowstatus_id=''2''workflow_id=''1''tablename=''sim_hr_leave''primarykey_name=''leave_id''primarykey_value=''19''hyperlink=''../hr/leave.php''title_description=''''created=''10/07/27 18:07:23''list_parameter=''''workflowtransaction_description=''''workflowtransaction_feedback=''''iscomplete=''0''createdby=''1''email_list=''''sms_list=''''email_body=''''sms_body=''''person_id=''14''issubmit=''1', 'I', 1, '2010-07-27 18:07:24', 31, 'S', '', 459, '127.0.0.1', 'workflowtransaction_id', 'sim_hr_leave'),
('sim_workflowtransactionhistory', 'workflowtransaction_id=''31''workflowstatus_id=''2''workflowtransaction_datetime=''10/07/27 18:07:24''uid=''1''workflowtransactionhistory_description=''', 'I', 1, '2010-07-27 18:07:24', 0, 'S', '', 460, '127.0.0.1', 'workflowtransactionhistory_id', ''),
('sim_workflowtransaction', 'workflowtransaction_datetime=''10/07/27 18:07:31''target_groupid=''31''target_uid=''0''targetparameter_name=''1''workflowstatus_id=''3''workflow_id=''1''tablename=''sim_hr_leave''primarykey_name=''leave_id''primarykey_value=''19''hyperlink=''../hr/leave.php''title_description=''''created=''10/07/27 18:07:31''list_parameter=''''workflowtransaction_description=''''workflowtransaction_feedback=''''iscomplete=''1''createdby=''1''email_list=''''sms_list=''''email_body=''''sms_body=''''person_id=''14''issubmit=''1', 'I', 1, '2010-07-27 18:07:31', 32, 'S', '', 461, '127.0.0.1', 'workflowtransaction_id', 'sim_hr_leave'),
('sim_workflowtransactionhistory', 'workflowtransaction_id=''32''workflowstatus_id=''3''workflowtransaction_datetime=''10/07/27 18:07:31''uid=''1''workflowtransactionhistory_description=''', 'I', 1, '2010-07-27 18:07:31', 0, 'S', '', 462, '127.0.0.1', 'workflowtransactionhistory_id', ''),
('sim_workflowtransaction', 'workflowtransaction_datetime=''10/07/27 18:07:35''target_groupid=''''target_uid=''''targetparameter_name=''''workflowstatus_id=''''workflow_id=''''tablename=''sim_hr_leaveadjustment''primarykey_name=''leaveadjustment_id''primarykey_value=''10''hyperlink=''''title_description=''''created=''10/07/27 18:07:35''list_parameter=''''workflowtransaction_description=''''workflowtransaction_feedback=''''iscomplete=''''createdby=''1''email_list=''''sms_list=''''email_body=''''sms_body=''''person_id=''0''issubmit=''', 'I', 1, '2010-07-27 18:07:35', 33, 'S', '', 463, '127.0.0.1', 'workflowtransaction_id', 'sim_hr_leaveadjustment'),
('sim_workflowtransactionhistory', 'workflowtransaction_id=''33''workflowstatus_id=''''workflowtransaction_datetime=''10/07/27 18:07:35''uid=''1''workflowtransactionhistory_description=''', 'I', 1, '2010-07-27 18:07:35', 0, 'S', '', 464, '127.0.0.1', 'workflowtransactionhistory_id', ''),
('sim_workflowtransaction', 'workflowtransaction_datetime=''10/07/27 18:07:39''target_groupid=''1''target_uid=''0''targetparameter_name=''''workflowstatus_id=''2''workflow_id=''11''tablename=''sim_hr_travellingclaim''primarykey_name=''travellingclaim_id''primarykey_value=''3''hyperlink=''../hr/travellingclaim.php''title_description=''''created=''10/07/27 18:07:39''list_parameter=''''workflowtransaction_description=''''workflowtransaction_feedback=''''iscomplete=''1''createdby=''1''email_list=''''sms_list=''''email_body=''''sms_body=''''person_id=''14''issubmit=''1', 'I', 1, '2010-07-27 18:07:39', 34, 'S', '', 465, '127.0.0.1', 'workflowtransaction_id', 'sim_hr_travellingclaim'),
('sim_workflowtransactionhistory', 'workflowtransaction_id=''34''workflowstatus_id=''2''workflowtransaction_datetime=''10/07/27 18:07:39''uid=''1''workflowtransactionhistory_description=''', 'I', 1, '2010-07-27 18:07:39', 0, 'S', '', 466, '127.0.0.1', 'workflowtransactionhistory_id', ''),
('sim_workflowtransaction', 'workflowtransaction_datetime=''10/07/27 18:07:54''target_groupid=''1''target_uid=''0''targetparameter_name=''''workflowstatus_id=''4''workflow_id=''4''tablename=''sim_hr_generalclaim''primarykey_name=''generalclaim_id''primarykey_value=''3''hyperlink=''../hr/generalclaim.php''title_description=''''created=''10/07/27 18:07:54''list_parameter=''''workflowtransaction_description=''''workflowtransaction_feedback=''''iscomplete=''1''createdby=''1''email_list=''''sms_list=''''email_body=''''sms_body=''''person_id=''15''issubmit=''1', 'I', 1, '2010-07-27 18:07:54', 35, 'S', '', 467, '127.0.0.1', 'workflowtransaction_id', 'sim_hr_generalclaim'),
('sim_workflowtransactionhistory', 'workflowtransaction_id=''35''workflowstatus_id=''4''workflowtransaction_datetime=''10/07/27 18:07:54''uid=''1''workflowtransactionhistory_description=''', 'I', 1, '2010-07-27 18:07:54', 0, 'S', '', 468, '127.0.0.1', 'workflowtransactionhistory_id', ''),
('sim_hr_generalclaim', 'employee_id=''KS Tan(19)''generalclaim_date=''2010-07-12''generalclaim_docno=''D3432''generalclaim_remark=''''period_id=''2010(2)''created=''10/07/27 18:11:45''createdby=''admin(1)''updated=''10/07/27 18:11:45''updatedby=''admin(1)''organization_id=''1', 'I', 1, '2010-07-27 18:11:45', 4, 'S', '', 469, '127.0.0.1', 'generalclaim_id', 'D3432'),
('sim_hr_generalclaimline', 'generalclaim_id=''4''generalclaimline_date=''2010-07-15 00:00:00''generalclaimline_details=''sss''generalclaimline_porpose=''ddd''generalclaimline_billno=''213''generalclaimline_amount=''01222''remarks=''''generalclaimline_acccode=''''created=''2010-07-27 18:12:13''createdby=''1''updated=''2010-07-27 18:12:13''updatedby=''1', 'I', 1, '2010-07-27 18:12:13', 13, 'S', '', 470, '127.0.0.1', 'generalclaimline_id', 'sss'),
('sim_hr_generalclaimline', 'generalclaim_id=''4''generalclaimline_date=''1900-01-01''generalclaimline_details=''d''generalclaimline_porpose=''ddsa''generalclaimline_billno=''das''generalclaimline_amount=''03232''remarks=''''generalclaimline_acccode=''''created=''2010-07-27 18:12:13''createdby=''1''updated=''2010-07-27 18:12:13''updatedby=''1', 'I', 1, '2010-07-27 18:12:13', 14, 'S', '', 471, '127.0.0.1', 'generalclaimline_id', 'd'),
('sim_hr_generalclaim', 'employee_id=''KS Tan(19)''generalclaim_date=''2010-07-07''generalclaim_docno=''''generalclaim_remark=''''period_id=''2010(2)''created=''10/07/27 18:14:06''createdby=''admin(1)''updated=''10/07/27 18:14:06''updatedby=''admin(1)''organization_id=''1', 'I', 1, '2010-07-27 18:14:06', 5, 'S', '', 472, '127.0.0.1', 'generalclaim_id', ''),
('sim_hr_generalclaim', 'employee_id=''19KS Tan'',<br/>issubmit=''1''', 'U', 1, '2010-07-27 18:17:06', 5, 'S', '', 473, '127.0.0.1', 'generalclaim_id', ''),
('sim_workflowtransaction', 'workflowtransaction_datetime=''10/07/27 18:17:06''target_groupid=''1''target_uid=''0''targetparameter_name=''10''workflowstatus_id=''1''workflow_id=''4''tablename=''sim_hr_generalclaim''primarykey_name=''generalclaim_id''primarykey_value=''5''hyperlink=''../hr/generalclaim.php''title_description=''''created=''10/07/27 18:17:06''list_parameter=''''workflowtransaction_description=''Ok done''workflowtransaction_feedback=''''iscomplete=''0''createdby=''1''email_list=''1,10''sms_list=''1,10''email_body=''''sms_body=''''person_id=''19''issubmit=''1', 'I', 1, '2010-07-27 18:17:06', 36, 'S', '', 474, '127.0.0.1', 'workflowtransaction_id', 'sim_hr_generalclaim'),
('sim_workflowtransactionhistory', 'workflowtransaction_id=''36''workflowstatus_id=''1''workflowtransaction_datetime=''10/07/27 18:17:06''uid=''1''workflowtransactionhistory_description=''', 'I', 1, '2010-07-27 18:17:06', 0, 'S', '', 475, '127.0.0.1', 'workflowtransactionhistory_id', ''),
('sim_workflowtransaction', 'workflowtransaction_datetime=''10/07/27 18:17:19''target_groupid=''1''target_uid=''0''targetparameter_name=''''workflowstatus_id=''2''workflow_id=''4''tablename=''sim_hr_generalclaim''primarykey_name=''generalclaim_id''primarykey_value=''5''hyperlink=''../hr/generalclaim.php''title_description=''''created=''10/07/27 18:17:19''list_parameter=''''workflowtransaction_description=''Claim for {claim_details}''workflowtransaction_feedback=''''iscomplete=''1''createdby=''1''email_list=''''sms_list=''''email_body=''''sms_body=''''person_id=''19''issubmit=''1', 'I', 1, '2010-07-27 18:17:19', 37, 'S', '', 476, '127.0.0.1', 'workflowtransaction_id', 'sim_hr_generalclaim'),
('sim_workflowtransactionhistory', 'workflowtransaction_id=''37''workflowstatus_id=''2''workflowtransaction_datetime=''10/07/27 18:17:19''uid=''1''workflowtransactionhistory_description=''', 'I', 1, '2010-07-27 18:17:19', 0, 'S', '', 477, '127.0.0.1', 'workflowtransactionhistory_id', ''),
('sim_hr_generalclaim', 'employee_id=''GoD(18)''generalclaim_date=''2010-07-11''generalclaim_docno=''''generalclaim_remark=''''period_id=''2010(2)''created=''10/07/27 18:18:31''createdby=''admin(1)''updated=''10/07/27 18:18:31''updatedby=''admin(1)''organization_id=''1', 'I', 1, '2010-07-27 18:18:31', 6, 'S', '', 478, '127.0.0.1', 'generalclaim_id', ''),
('sim_hr_leaveadjustment', 'leavetype_id=''Annul Leave(8)''created=''10/07/27 18:21:48''createdby=''admin(1)''updated=''10/07/27 18:21:48''updatedby=''admin(1)''organization_id=''1', 'I', 1, '2010-07-27 18:21:48', 20, 'S', '', 479, '127.0.0.1', 'leaveadjustment_id', 'admin'),
('sim_hr_generalclaimline', 'generalclaim_id=''6''generalclaimline_date=''1900-01-01''generalclaimline_details=''''generalclaimline_porpose=''''generalclaimline_billno=''''generalclaimline_amount=''012''remarks=''''generalclaimline_acccode=''''created=''2010-07-27 18:23:21''createdby=''1''updated=''2010-07-27 18:23:21''updatedby=''1', 'I', 1, '2010-07-27 18:23:22', 15, 'S', '', 480, '127.0.0.1', 'generalclaimline_id', ''),
('sim_hr_generalclaimline', 'generalclaim_id=''6''generalclaimline_date=''1900-01-01''generalclaimline_details=''''generalclaimline_porpose=''''generalclaimline_billno=''''generalclaimline_amount=''012''remarks=''''generalclaimline_acccode=''''created=''2010-07-27 18:23:21''createdby=''1''updated=''2010-07-27 18:23:21''updatedby=''1', 'I', 1, '2010-07-27 18:23:22', 16, 'S', '', 481, '127.0.0.1', 'generalclaimline_id', ''),
('sim_hr_generalclaimline', 'generalclaimline_details=''      ddassa''', 'U', 1, '2010-07-27 18:31:27', 15, 'S', '', 482, '127.0.0.1', 'generalclaimline_id', '      ddassa'),
('sim_hr_overtimeclaim', 'employee_id=''A-Tester(16)''overtimeclaim_date=''2010-07-22''overtimeclaim_docno=''''overtimeclaim_remark=''''created=''10/07/27 18:37:05''createdby=''admin(1)''updated=''10/07/27 18:37:05''updatedby=''admin(1)''organization_id=''1', 'I', 1, '2010-07-27 18:37:05', 3, 'S', '', 483, '127.0.0.1', 'overtimeclaim_id', ''),
('sim_hr_overtimeclaimline', 'overtimeclaim_id=''3''overtimeclaimline_date=''1900-01-01''overtimeclaimline_starttime=''02:30:00''overtimeclaimline_endtime=''00:00:00''overtimeclaimline_totalhour=''-02:30:0''overtimeclaimline_purpose=''''overtimeclaimline_remark=''''created=''2010-07-27 18:38:04''createdby=''1''updated=''2010-07-27 18:38:04''updatedby=''1', 'I', 1, '2010-07-27 18:38:04', 1, 'S', '', 484, '127.0.0.1', 'overtimeclaimline_id', ''),
('sim_hr_overtimeclaimline', 'overtimeclaim_id=''3''overtimeclaimline_date=''1900-01-01''overtimeclaimline_starttime=''00:00:00''overtimeclaimline_endtime=''00:00:00''overtimeclaimline_totalhour=''00:00:00''overtimeclaimline_purpose=''''overtimeclaimline_remark=''''created=''2010-07-27 18:38:04''createdby=''1''updated=''2010-07-27 18:38:04''updatedby=''1', 'I', 1, '2010-07-27 18:38:04', 2, 'S', '', 485, '127.0.0.1', 'overtimeclaimline_id', ''),
('sim_hr_overtimeclaimline', 'overtimeclaim_id=''3''overtimeclaimline_date=''1900-01-01''overtimeclaimline_starttime=''00:00:00''overtimeclaimline_endtime=''00:00:00''overtimeclaimline_totalhour=''00:00:00''overtimeclaimline_purpose=''''overtimeclaimline_remark=''''created=''2010-07-27 18:38:04''createdby=''1''updated=''2010-07-27 18:38:04''updatedby=''1', 'I', 1, '2010-07-27 18:38:04', 3, 'S', '', 486, '127.0.0.1', 'overtimeclaimline_id', ''),
('sim_workflownode', 'target_uid='''',<br/>isemail=''0'',<br/>issms=''0'',<br/>workflow_description=''Leave Date : {leave_apply_date}\nReasons : {leave_reasons}\n''', 'U', 0, '2010-07-28 09:37:55', 10, 'S', '', 487, '::1', 'workflownode_id', '10'),
('sim_hr_leave', 'leave_no=''''leave_date=''2010-07-28''employee_id=''asda(14)''leave_fromdate=''2010-07-05''leave_todate=''2010-07-13''leave_day=''9''time_from=''08:00:00''time_to=''08:00:00''total_hours=''00:00:00''leave_address=''''leave_telno=''''leavetype_id=''Annul Leave(8)''lecturer_remarks=''''description=''''created=''10/07/28 09:40:41''createdby=''1''updated=''10/07/28 09:40:41''updatedby=''1''organization_id=''1''panelclinic_id=''0''table_type=''L', 'I', 1, '2010-07-28 09:40:41', 25, 'S', '', 488, '::1', 'leave_id', ''),
('sim_hr_jobposition', 'isdeleted=', 'D', 1, '2010-07-28 10:06:19', 55, 'S', '', 489, '::1', 'jobposition_id', '4'),
('sim_hr_disciplinetype', 'isdeleted=', 'D', 1, '2010-07-28 10:40:41', 22, 'S', '', 490, '::1', 'disciplinetype_id', 'WW'),
('sim_hr_leavetype', 'leavetype_name=''eqweqw''isactive=''1''isvalidate=''1''defaultlevel=''10''created=''2010-07-28 10:41:41''createdby=''1''updated=''2010-07-28 10:41:41''updatedby=''1''organization_id=''1''description=''', 'I', 1, '2010-07-28 10:41:41', 13, 'S', '', 491, '::1', 'leavetype_id', 'eqweqw'),
('sim_hr_leavetype', 'isdeleted=', 'D', 1, '2010-07-28 10:41:46', 13, 'S', '', 492, '::1', 'leavetype_id', 'eqweqw'),
('sim_hr_trainingtype', 'trainingtype_name=''rwer''isactive=''1''defaultlevel=''10''created=''2010-07-28 10:44:11''createdby=''1''updated=''2010-07-28 10:44:11''updatedby=''1''organization_id=''1''description=''', 'I', 1, '2010-07-28 10:44:11', 16, 'S', '', 493, '::1', 'trainingtype_id', 'rwer'),
('sim_hr_trainingtype', 'isdeleted=', 'D', 1, '2010-07-28 10:44:16', 16, 'S', '', 494, '::1', 'trainingtype_id', 'rwer'),
('sim_hr_employeegroup', 'isdeleted=''0''', 'U', 1, '2010-07-28 10:50:27', 13, 'S', '', 495, '::1', 'employeegroup_id', 'CLF'),
('sim_hr_employeegroup', 'isdeleted=', 'D', 1, '2010-07-28 11:30:17', 13, 'S', '', 496, '::1', 'employeegroup_id', 'CLF'),
('sim_hr_department', 'department_no=''sss''department_name=''ssss''defaultlevel=''10''description=''dasdas''department_parent=''0''isactive=''1''created=''2010-07-28 11:34:28''createdby=''1''updated=''2010-07-28 11:34:28''updatedby=''1''organization_id=''1''department_head=''0', 'I', 1, '2010-07-28 11:34:28', 22, 'S', '', 497, '::1', 'department_id', 'ssss'),
('sim_hr_department', 'department_no=''dsa''department_name=''dasdas''defaultlevel=''10''description=''''department_parent=''0''isactive=''1''created=''2010-07-28 11:35:28''createdby=''1''updated=''2010-07-28 11:35:28''updatedby=''1''organization_id=''1''department_head=''0', 'I', 1, '2010-07-28 11:35:28', 23, 'S', '', 498, '::1', 'department_id', 'dasdas'),
('sim_hr_department', 'department_no=''da''department_name=''asd''defaultlevel=''10''description=''das''department_parent=''1''isactive=''1''created=''2010-07-28 11:35:35''createdby=''1''updated=''2010-07-28 11:35:35''updatedby=''1''organization_id=''1''department_head=''18', 'I', 1, '2010-07-28 11:35:35', 24, 'S', '', 499, '::1', 'department_id', 'asd'),
('sim_hr_department', 'department_no=''das''department_name=''dasdas''defaultlevel=''10''description=''''department_parent=''1''isactive=''1''created=''2010-07-28 11:35:41''createdby=''1''updated=''2010-07-28 11:35:41''updatedby=''1''organization_id=''1''department_head=''0', 'I', 1, '2010-07-28 11:35:41', 25, 'S', '', 500, '::1', 'department_id', 'dasdas'),
('sim_hr_department', 'department_no=''aa''department_name=''ddd''defaultlevel=''10''description=''''department_parent=''9''isactive=''1''created=''2010-07-28 11:35:56''createdby=''1''updated=''2010-07-28 11:35:56''updatedby=''1''organization_id=''1''department_head=''0', 'I', 1, '2010-07-28 11:35:56', 27, 'S', '', 501, '::1', 'department_id', 'ddd'),
('sim_hr_employeegroup', 'islecturer=''1''', 'U', 1, '2010-07-28 12:02:15', 14, 'S', '', 502, '::1', 'employeegroup_id', 'OF'),
('sim_hr_employeegroup', 'islecturer=''0''', 'U', 1, '2010-07-28 12:03:40', 14, 'S', '', 503, '::1', 'employeegroup_id', 'OF'),
('sim_hr_employeegroup', 'islecturer=''1''', 'U', 1, '2010-07-28 12:06:10', 14, 'S', '', 504, '::1', 'employeegroup_id', 'OF'),
('sim_hr_employeegroup', 'islecturer=''0''', 'U', 1, '2010-07-28 12:07:06', 10, 'S', '', 505, '::1', 'employeegroup_id', 'LP'),
('sim_hr_employee', 'religion_id=''4'',<br/>department_id=''27'',<br/>defaultlevel='''',<br/>organization_id='''',<br/>employee_status=''1''', 'U', 1, '2010-07-28 12:56:03', 14, 'S', '', 506, '::1', 'employee_id', '1312'),
('sim_hr_employeespouse', 'employee_id=''14''spouse_name=''sss''spouse_dob=''2010-07-12''spouse_placedob=''''spouse_placeissue=''''spouse_races=''0''spouse_religion=''4''spouse_gender=''M''spouse_bloodgroup=''''spouse_occupation=''''spouse_citizenship=''3''spouse_newicno=''''spouse_oldicno=''''spouse_ic_color=''B''spouse_passport=''''spouse_issuedate=''''spouse_expirydate=''''created=''2010-07-28 13:19:20''createdby=''1''updated=''2010-07-28 13:19:20''updatedby=''1', 'I', 1, '2010-07-28 13:19:20', 5, 'S', '', 507, '::1', 'spouse_id', 'sss'),
('sim_hr_qualificationline', 'qualification_type=''3''qualification_name=''''qualification_institution=''''qualification_month=''1900-01-01''created=''2010-07-28 15:46:31''createdby=''1''updated=''2010-07-28 15:46:31''updatedby=''1''employee_id=''14', 'I', 1, '2010-07-28 15:46:31', 16, 'S', '', 508, '::1', 'qualification_id', ''),
('sim_hr_supervisorline', 'supervisorline_supervisorid=''16''isdirect=''1''supervisorline_remarks=''''created=''2010-07-28 15:49:38''createdby=''1''updated=''2010-07-28 15:49:38''updatedby=''1''employee_id=''14', 'I', 1, '2010-07-28 15:49:38', 25, 'S', '', 509, '::1', 'supervisorline_id', '16'),
('sim_hr_supervisorline', 'isdirect=''0''', 'U', 1, '2010-07-28 15:51:26', 25, 'S', '', 510, '::1', 'supervisorline_id', '16'),
('sim_hr_supervisorline', 'isdeleted=', 'D', 1, '2010-07-28 15:51:31', 25, 'S', '', 511, '::1', 'supervisorline_id', '16'),
('sim_hr_supervisorline', 'supervisorline_supervisorid=''18''isdirect=''1''supervisorline_remarks=''''created=''2010-07-28 15:51:57''createdby=''1''updated=''2010-07-28 15:51:57''updatedby=''1''employee_id=''14', 'I', 1, '2010-07-28 15:51:57', 26, 'S', '', 512, '::1', 'supervisorline_id', '18'),
('sim_hr_supervisorline', 'Record deleted permanentl', 'E', 1, '2010-07-28 15:52:01', 26, 'S', '', 513, '::1', 'supervisorline_id', '18'),
('sim_hr_supervisorline', 'Record deleted permanentl', 'E', 1, '2010-07-28 15:52:04', 25, 'S', '', 514, '::1', 'supervisorline_id', '16'),
('sim_hr_qualificationline', 'qualification_type=''3''qualification_name=''dasd''qualification_institution=''dasdas''qualification_month=''2010-07-06 00:00:00''created=''2010-07-28 15:53:46''createdby=''1''updated=''2010-07-28 15:53:46''updatedby=''1''employee_id=''14', 'I', 1, '2010-07-28 15:53:46', 17, 'S', '', 515, '::1', 'qualification_id', 'dasd'),
('sim_hr_qualificationline', 'isdeleted=', 'D', 1, '2010-07-28 15:53:59', 17, 'S', '', 516, '::1', 'qualification_id', 'dasd'),
('sim_hr_qualificationline', 'qualification_type=''3''qualification_name=''sss''qualification_institution=''''qualification_month=''1900-01-01''created=''2010-07-28 15:58:51''createdby=''1''updated=''2010-07-28 15:58:51''updatedby=''1''employee_id=''19', 'I', 1, '2010-07-28 15:58:51', 18, 'S', '', 517, '::1', 'qualification_id', 'sss'),
('sim_hr_employee', 'filephoto=''1280303949_photofile19.png'',<br/>defaultlevel='''',<br/>organization_id=''''', 'U', 1, '2010-07-28 15:59:09', 19, 'S', '', 518, '::1', 'employee_id', 'K001'),
('sim_hr_employee', 'defaultlevel='''',<br/>organization_id=''''', 'U', 1, '2010-07-28 16:01:52', 19, 'S', '', 519, '::1', 'employee_id', 'K001'),
('sim_hr_employee', 'filephoto=''1280304428_photofile19.png'',<br/>defaultlevel='''',<br/>organization_id=''''', 'U', 1, '2010-07-28 16:07:08', 19, 'S', '', 520, '::1', 'employee_id', 'K001'),
('sim_hr_employee', 'defaultlevel='''',<br/>organization_id=''''', 'U', 1, '2010-07-28 16:14:23', 19, 'S', '', 521, '::1', 'employee_id', 'K001'),
('sim_hr_attachmentline', 'attachmentline_name=''ss''attachmentline_file=''1280305563_14.png''attachmentline_remarks='' ''employee_id=''14''created=''2010-07-28 16:26:03''createdby=''1''updated=''2010-07-28 16:26:03''updatedby=''1', 'I', 1, '2010-07-28 16:26:03', 4, 'S', '', 522, '::1', 'attachmentline_id', 'ss'),
('sim_hr_portfolioline', 'portfolioline_datefrom=''1900-01-01''portfolioline_dateto=''1900-01-01''portfolioline_name=''''portfolioline_remarks=''''created=''2010-07-28 16:49:52''createdby=''1''updated=''2010-07-28 16:49:52''updatedby=''1''working_experience=''''employee_id=''14', 'I', 1, '2010-07-28 16:49:52', 2, 'S', '', 523, '::1', 'portfolioline_id', ''),
('sim_hr_portfolioline', 'portfolioline_name=''s'',<br/>portfolioline_remarks=''f'',<br/>working_experience=''d''', 'U', 1, '2010-07-28 16:49:59', 2, 'S', '', 524, '::1', 'portfolioline_id', 's'),
('sim_hr_portfolioline', 'portfolioline_datefrom=''1900-01-01''portfolioline_dateto=''1900-01-01''portfolioline_name=''a''portfolioline_remarks=''d''created=''2010-07-28 16:50:07''createdby=''1''updated=''2010-07-28 16:50:07''updatedby=''1''working_experience=''s''employee_id=''14', 'I', 1, '2010-07-28 16:50:07', 3, 'S', '', 525, '::1', 'portfolioline_id', 'a'),
('sim_hr_portfolioline', 'isdeleted=', 'D', 1, '2010-07-28 16:50:10', 3, 'S', '', 526, '::1', 'portfolioline_id', 'a'),
('sim_hr_appraisalline', 'appraisalline_name=''''appraisalline_date=''1900-01-01''appraisalline_datedue=''1900-01-01''appraisalline_increment=''0''appraisalline_result=''''appraisalline_remarks=''''isdeleted=''''created=''2010-07-28 16:54:00''createdby=''1''updated=''2010-07-28 16:54:00''updatedby=''1''employee_id=''14', 'I', 1, '2010-07-28 16:54:00', 2, 'S', '', 527, '::1', 'appraisalline_id', ''),
('sim_hr_appraisalline', 'appraisalline_name=''''appraisalline_date=''1900-01-01''appraisalline_datedue=''1900-01-01''appraisalline_increment=''0''appraisalline_result=''''appraisalline_remarks=''''isdeleted=''''created=''2010-07-28 16:54:00''createdby=''1''updated=''2010-07-28 16:54:00''updatedby=''1''employee_id=''14', 'I', 1, '2010-07-28 16:54:00', 3, 'S', '', 528, '::1', 'appraisalline_id', ''),
('sim_hr_appraisalline', 'appraisalline_name=''qq'',<br/>appraisalline_increment=''0123'',<br/>appraisalline_result=''ee'',<br/>appraisalline_remarks=''ff''', 'U', 1, '2010-07-28 16:54:33', 3, 'S', '', 529, '::1', 'appraisalline_id', 'qq'),
('sim_hr_appraisalline', 'appraisalline_name=''ww'',<br/>appraisalline_increment=''0123'',<br/>appraisalline_result=''qq'',<br/>appraisalline_remarks=''ads''', 'U', 1, '2010-07-28 16:54:33', 2, 'S', '', 530, '::1', 'appraisalline_id', 'ww'),
('sim_hr_appraisalline', 'Record deleted permanentl', 'E', 1, '2010-07-28 16:54:37', 3, 'S', '', 531, '::1', 'appraisalline_id', 'qq'),
('sim_hr_trainingline', 'trainingline_name=''a''trainingtype_id=''10''trainingline_venue=''f''trainingline_purpose=''d''trainingline_startdate=''1900-01-01''trainingline_enddate=''1900-01-01''trainingline_trainerid=''''trainingline_result=''a''trainingline_hodcom=''s''trainingline_hrcom=''d''trainingline_remarks=''''trainingline_trainer =''''created=''2010-07-28 17:02:23''createdby=''1''updated=''2010-07-28 17:02:23''updatedby=''1''employee_id=''14', 'I', 1, '2010-07-28 17:02:23', 12, 'S', '', 532, '::1', 'trainingline_id', 'a'),
('sim_hr_trainingline', 'trainingline_trainer =''ds''', 'U', 1, '2010-07-28 17:03:10', 12, 'S', '', 533, '::1', 'trainingline_id', 'a'),
('sim_hr_trainingline', 'Record deleted permanentl', 'E', 1, '2010-07-28 17:03:14', 12, 'S', '', 534, '::1', 'trainingline_id', 'a');
INSERT INTO `sim_audit` (`tablename`, `changedesc`, `category`, `uid`, `updated`, `record_id`, `eventype`, `uname`, `audit_id`, `ip`, `primarykey`, `controlvalue`) VALUES
('sim_hr_employeefamily', 'employeefamily_name=''''relationship_id=''1''employeefamily_dob=''1900-01-01''employeefamily_age=''0''employeefamily_occupation=''''employeefamily_contactno=''''isnok=''1''isemergency=''1''employeefamily_remark=''''created=''2010-07-28 17:11:11''createdby=''1''updated=''2010-07-28 17:11:11''updatedby=''1''employee_id=''14', 'I', 1, '2010-07-28 17:11:12', 3, 'S', '', 535, '::1', 'employeefamily_id', ''),
('sim_hr_employee', 'employee_name=''WWW''employee_cardno=''ASAS''employee_no=''DDD''uid=''''place_dob=''''employee_dob=''2010-07-14''races_id=''0''religion_id=''4''gender=''M''marital_status=''S''employee_citizenship=''2''employee_newicno=''''employee_oldicno=''''ic_color=''B''employee_passport=''''employee_bloodgroup=''''department_id=''''jobposition_id=''''employeegroup_id=''12''employee_joindate=''2010-07-20''filephoto=''''created=''2010-07-28 17:32:56''createdby=''1''updated=''2010-07-28 17:32:56''updatedby=''1''defaultlevel=''''organization_id=''''employee_transport=''''employee_status=''1', 'I', 1, '2010-07-28 17:32:56', 20, 'S', '', 536, '::1', 'employee_id', 'WWW'),
('sim_hr_employee', 'defaultlevel='''',<br/>organization_id=''''', 'U', 1, '2010-07-28 17:36:12', 14, 'S', '', 537, '::1', 'employee_id', '1312'),
('sim_hr_employee', 'employee_name=''FD''employee_cardno=''''employee_no=''DS''uid=''''place_dob=''''employee_dob=''2010-06-17''races_id=''0''religion_id=''4''gender=''M''marital_status=''S''employee_citizenship=''3''employee_newicno=''''employee_oldicno=''''ic_color=''B''employee_passport=''''employee_bloodgroup=''''department_id=''''jobposition_id=''''employeegroup_id=''12''employee_joindate=''2010-07-28''filephoto=''1280309843_photofile.png''created=''2010-07-28 17:37:23''createdby=''1''updated=''2010-07-28 17:37:23''updatedby=''1''defaultlevel=''''organization_id=''''employee_transport=''''employee_status=''1', 'I', 1, '2010-07-28 17:37:23', 21, 'S', '', 538, '::1', 'employee_id', 'FD'),
('sim_hr_employee', 'employee_name=''DSA''employee_cardno=''dasda''employee_no=''EW232''uid=''1868''place_dob=''q''employee_dob=''2010-07-19''races_id=''2''religion_id=''2''gender=''F''marital_status=''M''employee_citizenship=''3''employee_newicno=''e''employee_oldicno=''w''ic_color=''B''employee_passport=''r''employee_bloodgroup=''dS''department_id=''20''jobposition_id=''52''employeegroup_id=''12''employee_joindate=''2010-07-08''filephoto=''1280309956_photofile.png''created=''2010-07-28 17:39:16''createdby=''1''updated=''2010-07-28 17:39:16''updatedby=''1''defaultlevel=''''organization_id=''''employee_transport=''''employee_status=''1', 'I', 1, '2010-07-28 17:39:16', 22, 'S', '', 539, '::1', 'employee_id', 'DSA'),
('sim_hr_employee', 'employee_name=''a''employee_cardno=''d''employee_no=''c''uid=''1868''place_dob=''f''employee_dob=''2010-07-01''races_id=''4''religion_id=''3''gender=''F''marital_status=''M''employee_citizenship=''3''employee_newicno=''j''employee_oldicno=''h''ic_color=''R''employee_passport=''i''employee_bloodgroup=''g''department_id=''19''jobposition_id=''56''employeegroup_id=''12''employee_joindate=''2010-07-04''filephoto=''''created=''2010-07-28 18:03:10''createdby=''1''updated=''2010-07-28 18:03:10''updatedby=''1''defaultlevel=''''organization_id=''''employee_transport=''e''employee_status=''1', 'I', 1, '2010-07-28 18:03:10', 23, 'S', '', 540, '127.0.0.1', 'employee_id', 'a'),
('sim_hr_employee', 'employee_name=''ssqweq''employee_cardno=''''employee_no=''eqweqw''uid=''''place_dob=''''employee_dob=''2010-07-07''races_id=''0''religion_id=''4''gender=''M''marital_status=''S''employee_citizenship=''2''employee_newicno=''''employee_oldicno=''''ic_color=''B''employee_passport=''''employee_bloodgroup=''''department_id=''''jobposition_id=''''employeegroup_id=''12''employee_joindate=''2010-07-20''filephoto=''''created=''2010-07-28 18:05:52''createdby=''1''updated=''2010-07-28 18:05:52''updatedby=''1''defaultlevel=''''organization_id=''''employee_transport=''''employee_status=''1', 'I', 1, '2010-07-28 18:05:52', 24, 'S', '', 541, '127.0.0.1', 'employee_id', 'ssqweq'),
('sim_hr_employee', 'employee_name=''A''employee_cardno=''D''employee_no=''CD''uid=''1868''place_dob=''F''employee_dob=''2010-07-20''races_id=''2''religion_id=''3''gender=''M''marital_status=''S''employee_citizenship=''2''employee_newicno=''J''employee_oldicno=''H''ic_color=''B''employee_passport=''I''employee_bloodgroup=''G''department_id=''15''jobposition_id=''56''employeegroup_id=''12''employee_joindate=''2010-07-06''filephoto=''''updated=''2010-07-28 18:13:04''updatedby=''1''defaultlevel=''''organization_id=''''employee_transport=''E''employee_status=''2''isactive=''''employee_altname=''B''ic_placeissue=''L''employee_passport_placeissue=''k''employee_passport_issuedate=''2010-07-14''employee_passport_expirydate=''2010-07-15''employee_confirmdate=''2010-07-05''employee_enddate=''2010-07-05', 'I', 1, '2010-07-28 18:13:04', 24, 'S', '', 542, '127.0.0.1', 'employee_id', 'A'),
('sim_hr_employee', 'employee_name=''WEW''employee_cardno=''QWQ''employee_no=''ASDDS''uid=''1868''place_dob=''WEW''employee_dob=''2010-07-20''races_id=''1''religion_id=''2''gender=''F''marital_status=''M''employee_citizenship=''2''employee_newicno=''WE''employee_oldicno=''WEW''ic_color=''R''employee_passport=''WEW''employee_bloodgroup=''WEW''department_id=''14''jobposition_id=''56''employeegroup_id=''12''employee_joindate=''2010-07-07''filephoto=''''updated=''2010-07-28 18:14:45''updatedby=''1''defaultlevel=''''organization_id=''''employee_transport=''EWEWE''employee_status=''2''isactive=''1''employee_altname=''QWEQWEQW''ic_placeissue=''ERERE''employee_passport_placeissue=''EW''employee_passport_issuedate=''2010-07-02''employee_passport_expirydate=''2010-07-09''employee_confirmdate=''2010-06-16''employee_enddate=''2010-07-13', 'I', 1, '2010-07-28 18:14:45', 24, 'S', '', 543, '127.0.0.1', 'employee_id', 'WEW'),
('sim_hr_generalclaim', 'employee_id=''A-Tester(16)''generalclaim_date=''2010-07-07''generalclaim_docno=''''generalclaim_remark=''''period_id=''2010(2)''created=''10/07/28 18:18:11''createdby=''admin(1)''updated=''10/07/28 18:18:11''updatedby=''admin(1)''organization_id=''1', 'I', 1, '2010-07-28 18:18:11', 7, 'S', '', 544, '192.168.1.202', 'generalclaim_id', ''),
('sim_hr_generalclaim', 'employee_id=''a(23)''generalclaim_date=''2010-07-18''generalclaim_docno=''''generalclaim_remark=''''period_id=''2010(2)''created=''10/07/28 18:18:11''createdby=''admin(1)''updated=''10/07/28 18:18:11''updatedby=''admin(1)''organization_id=''1', 'I', 1, '2010-07-28 18:18:11', 8, 'S', '', 545, '127.0.0.1', 'generalclaim_id', ''),
('sim_hr_generalclaimline', 'generalclaim_id=''7''generalclaimline_date=''1900-01-01''generalclaimline_details=''asd''generalclaimline_porpose=''asd''generalclaimline_billno=''''generalclaimline_amount=''0444''remarks=''''generalclaimline_acccode=''''created=''2010-07-28 18:18:20''createdby=''1''updated=''2010-07-28 18:18:20''updatedby=''1', 'I', 1, '2010-07-28 18:18:20', 17, 'S', '', 546, '192.168.1.202', 'generalclaimline_id', 'asd'),
('sim_hr_generalclaimline', 'generalclaim_id=''8''generalclaimline_date=''1900-01-01''generalclaimline_details=''''generalclaimline_porpose=''''generalclaimline_billno=''''generalclaimline_amount=''0123''remarks=''''generalclaimline_acccode=''''created=''2010-07-28 18:18:22''createdby=''1''updated=''2010-07-28 18:18:22''updatedby=''1', 'I', 1, '2010-07-28 18:18:22', 18, 'S', '', 547, '127.0.0.1', 'generalclaimline_id', ''),
('sim_hr_generalclaimline', 'generalclaim_id=''8''generalclaimline_date=''1900-01-01''generalclaimline_details=''''generalclaimline_porpose=''''generalclaimline_billno=''''generalclaimline_amount=''01231''remarks=''''generalclaimline_acccode=''''created=''2010-07-28 18:18:22''createdby=''1''updated=''2010-07-28 18:18:22''updatedby=''1', 'I', 1, '2010-07-28 18:18:22', 19, 'S', '', 548, '127.0.0.1', 'generalclaimline_id', ''),
('sim_hr_employee', 'employee_name=''WWW''employee_cardno=''FFFF''employee_no=''DDDD''uid=''1868''place_dob=''dasdas''employee_dob=''2010-07-27''races_id=''2''religion_id=''4''gender=''M''marital_status=''S''employee_citizenship=''2''employee_newicno=''dasdas''employee_oldicno=''dsadas''ic_color=''B''employee_passport=''dsdsds''employee_bloodgroup=''dasdas''department_id=''14''jobposition_id=''56''employeegroup_id=''12''employee_joindate=''2010-07-07''filephoto=''''updated=''2010-07-28 18:21:01''updatedby=''1''defaultlevel=''''organization_id=''''created=''2010-07-28 18:21:01''createdby=''1''employee_transport=''dsds''employee_status=''2''isactive=''''employee_altname=''SSS''ic_placeissue=''dasdasd''employee_passport_placeissue=''dasdas''employee_passport_issuedate=''2010-07-14''employee_passport_expirydate=''2010-07-14''employee_confirmdate=''2010-07-21''employee_enddate=''2010-07-22', 'I', 1, '2010-07-28 18:21:01', 31, 'S', '', 549, '127.0.0.1', 'employee_id', 'WWW'),
('sim_window', 'mid=''66''windowsetting=''''seqno=''10''description=''''parentwindows_id=''''filename=''bpartner.php''isactive=''1''window_name=''Business Partner''created=''2010-07-28 19:00:06''createdby=''1''updated=''2010-07-28 19:00:06''updatedby=''1''table_name=''sim_bpartner', 'I', 0, '2010-07-28 19:00:06', 34, 'S', '', 550, '127.0.0.1', 'window_id', 'Business Partner'),
('sim_window', 'mid=''66''windowsetting=''''seqno=''10''description=''''parentwindows_id=''''filename=''bpartnergroup.php''isactive=''1''window_name=''Business Partner Group''created=''2010-07-28 19:00:51''createdby=''1''updated=''2010-07-28 19:00:51''updatedby=''1''table_name=''sim_bpartnergroup', 'I', 0, '2010-07-28 19:00:51', 35, 'S', '', 551, '127.0.0.1', 'window_id', 'Business Partner Group'),
('sim_window', 'mid=''66''windowsetting=''''seqno=''30''description=''''parentwindows_id=''''filename=''industry.php''isactive=''1''window_name=''Industry''created=''2010-07-28 19:01:20''createdby=''1''updated=''2010-07-28 19:01:20''updatedby=''1''table_name=''sim_industry', 'I', 0, '2010-07-28 19:01:20', 36, 'S', '', 552, '127.0.0.1', 'window_id', 'Industry'),
('sim_window', 'seqno=''20'',<br/>parentwindows_id=''''', 'U', 0, '2010-07-28 19:01:26', 35, 'S', '', 553, '127.0.0.1', 'window_id', 'Business Partner Group'),
('sim_window', 'mid=''66''windowsetting=''''seqno=''10''description=''''parentwindows_id=''34''filename=''''isactive=''1''window_name=''Master Data''created=''2010-07-28 19:02:52''createdby=''1''updated=''2010-07-28 19:02:52''updatedby=''1''table_name=''', 'I', 0, '2010-07-28 19:02:52', 37, 'S', '', 554, '127.0.0.1', 'window_id', 'Master Data'),
('sim_window', 'parentwindows_id=''35''', 'U', 0, '2010-07-28 19:03:08', 34, 'S', '', 555, '127.0.0.1', 'window_id', 'Business Partner'),
('sim_window', 'parentwindows_id=''37''', 'U', 0, '2010-07-28 19:03:16', 36, 'S', '', 556, '127.0.0.1', 'window_id', 'Industry'),
('sim_window', 'parentwindows_id=''37''', 'U', 0, '2010-07-28 19:03:21', 34, 'S', '', 557, '127.0.0.1', 'window_id', 'Business Partner'),
('sim_hr_travellingclaim', 'employee_id=''A-Tester(16)''travellingclaim_date=''2010-07-26''travellingclaim_docno=''''travellingclaim_remark=''''travellingclaim_transport=''das''period_id=''2010(2)''created=''10/07/28 19:39:32''createdby=''admin(1)''updated=''10/07/28 19:39:32''updatedby=''admin(1)''organization_id=''1', 'I', 1, '2010-07-28 19:39:33', 4, 'S', '', 558, '127.0.0.1', 'travellingclaim_id', ''),
('sim_hr_trainingtype', 'isdeleted=''0''', 'U', 1, '2010-07-28 19:47:31', 16, 'S', '', 559, '127.0.0.1', 'trainingtype_id', 'rwer'),
('sim_hr_employeegroup', 'isdeleted=''0''', 'U', 1, '2010-07-28 19:59:30', 13, 'S', '', 560, '127.0.0.1', 'employeegroup_id', 'CLF'),
('sim_hr_employeegroup', 'isdeleted=', 'D', 1, '2010-07-28 19:59:39', 13, 'S', '', 561, '127.0.0.1', 'employeegroup_id', 'CLF'),
('sim_hr_trainingtype', 'isdeleted=', 'D', 1, '2010-07-28 20:02:33', 16, 'S', '', 562, '127.0.0.1', 'trainingtype_id', 'rwer'),
('sim_hr_employee', 'defaultlevel='''',<br/>organization_id=''''', 'U', 1, '2010-07-28 20:25:11', 30, 'S', '', 563, '127.0.0.1', 'employee_id', 'ASDDS'),
('sim_hr_employee', 'defaultlevel='''',<br/>organization_id=''''', 'U', 1, '2010-07-28 20:27:15', 30, 'S', '', 564, '127.0.0.1', 'employee_id', 'ASDDS'),
('sim_hr_employee', 'defaultlevel='''',<br/>organization_id=''''', 'U', 1, '2010-07-28 20:38:35', 30, 'S', '', 565, '127.0.0.1', 'employee_id', 'ASDDS'),
('sim_hr_employee', 'defaultlevel='''',<br/>organization_id=''''', 'U', 1, '2010-07-28 20:40:49', 30, 'S', '', 566, '127.0.0.1', 'employee_id', 'ASDDS'),
('sim_hr_employeegroup', 'isdeleted=''0''', 'U', 1, '2010-07-28 21:36:39', 13, 'S', '', 567, '::1', 'employeegroup_id', 'CLF'),
('sim_hr_employeegroup', 'isdeleted=', 'D', 1, '2010-07-28 21:36:46', 13, 'S', '', 568, '::1', 'employeegroup_id', 'CLF'),
('sim_hr_employee', 'marital_status=''S'',<br/>defaultlevel='''',<br/>organization_id=''''', 'U', 1, '2010-07-28 22:15:12', 30, 'S', '', 569, '::1', 'employee_id', 'ASDDS'),
('sim_hr_employee', 'marital_status=''2'',<br/>defaultlevel='''',<br/>organization_id=''''', 'U', 1, '2010-07-28 22:17:32', 30, 'S', '', 570, '::1', 'employee_id', 'ASDDS'),
('sim_hr_employee', 'employee_dob=''1993-07-21'',<br/>defaultlevel='''',<br/>organization_id='''',<br/>employee_status=''1''', 'U', 1, '2010-07-28 22:17:55', 30, 'S', '', 571, '::1', 'employee_id', 'ASDDS'),
('sim_hr_employee', 'employee_hpno=''asdsad'',<br/>employee_officeno=''dasdas'',<br/>employee_email=''dasd'',<br/>employee_networkacc=''dasd'',<br/>employee_msgacc=''dsadas'',<br/>permanent_address=''dasd'',<br/>permanent_postcode=''das'',<br/>permanent_city=''das'',<br/>permanent_state=''das'',<br/>permanent_telno=''dasdas'',<br/>contact_address=''das'',<br/>contact_postcode=''aa'',<br/>contact_city=''ss'',<br/>contact_state=''dd'',<br/>contact_telno=''dasd''', 'U', 1, '2010-07-28 22:27:14', 30, 'S', '', 572, '::1', 'employee_id', ''),
('sim_hr_employee', 'permanent_country=''3'',<br/>contact_country=''2''', 'U', 1, '2010-07-28 22:28:03', 30, 'S', '', 573, '::1', 'employee_id', ''),
('sim_hr_employee', 'employee_citizenship='''',<br/>defaultlevel='''',<br/>organization_id=''''', 'U', 1, '2010-07-28 22:50:31', 30, 'S', '', 574, '::1', 'employee_id', 'ASDDS'),
('sim_hr_employeespouse', 'employee_id=''30''spouse_name=''dasds''spouse_dob=''2010-07-06''spouse_placedob=''''spouse_placeissue=''''spouse_races=''0''spouse_religion=''4''spouse_gender=''M''spouse_bloodgroup=''''spouse_occupation=''''spouse_citizenship=''3''spouse_newicno=''''spouse_oldicno=''''spouse_ic_color=''B''spouse_passport=''''spouse_issuedate=''''spouse_expirydate=''''created=''2010-07-28 22:51:25''createdby=''1''updated=''2010-07-28 22:51:25''updatedby=''1', 'I', 1, '2010-07-28 22:51:25', 6, 'S', '', 575, '::1', 'spouse_id', 'dasds'),
('sim_hr_employeespouse', 'spouse_hpno=''das''', 'U', 1, '2010-07-28 22:55:42', 6, 'S', '', 576, '::1', 'spouse_id', ''),
('sim_hr_leaveadjustment', 'leavetype_id=''Annul Leave(8)''created=''10/07/28 23:02:35''createdby=''admin(1)''updated=''10/07/28 23:02:35''updatedby=''admin(1)''organization_id=''1', 'I', 1, '2010-07-28 23:02:35', 21, 'S', '', 577, '::1', 'leaveadjustment_id', 'admin'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''21''employee_id=''30''leaveadjustmentline_totalday=''4''created=''2010-07-28 23:02:35''createdby=''1''updated=''2010-07-28 23:02:35''updatedby=''1', 'I', 1, '2010-07-28 23:02:35', 350, 'S', '', 578, '::1', 'leaveadjustmentline_id', '21'),
('sim_hr_leaveadjustment', 'issubmit=''1''', 'U', 1, '2010-07-28 23:02:43', 21, 'S', '', 579, '::1', 'leaveadjustment_id', '21'),
('sim_workflowtransaction', 'workflowtransaction_datetime=''10/07/28 23:02:43''target_groupid=''1''target_uid=''0''targetparameter_name=''''workflowstatus_id=''1''workflow_id=''8''tablename=''sim_hr_leaveadjustment''primarykey_name=''leaveadjustment_id''primarykey_value=''21''hyperlink=''''title_description=''''created=''10/07/28 23:02:43''list_parameter=''''workflowtransaction_description=''''workflowtransaction_feedback=''''iscomplete=''0''createdby=''1''email_list=''''sms_list=''''email_body=''''sms_body=''''person_id=''14''issubmit=''1', 'I', 1, '2010-07-28 23:02:43', 38, 'S', '', 580, '::1', 'workflowtransaction_id', 'sim_hr_leaveadjustment'),
('sim_workflowtransactionhistory', 'workflowtransaction_id=''38''workflowstatus_id=''1''workflowtransaction_datetime=''10/07/28 23:02:43''uid=''1''workflowtransactionhistory_description=''', 'I', 1, '2010-07-28 23:02:44', 0, 'S', '', 581, '::1', 'workflowtransactionhistory_id', ''),
('sim_workflowtransaction', 'workflowtransaction_datetime=''10/07/28 23:02:49''target_groupid=''1''target_uid=''1''targetparameter_name=''''workflowstatus_id=''2''workflow_id=''8''tablename=''sim_hr_leaveadjustment''primarykey_name=''leaveadjustment_id''primarykey_value=''21''hyperlink=''''title_description=''''created=''10/07/28 23:02:49''list_parameter=''''workflowtransaction_description=''''workflowtransaction_feedback=''''iscomplete=''1''createdby=''1''email_list=''''sms_list=''''email_body=''''sms_body=''''person_id=''14''issubmit=''1', 'I', 1, '2010-07-28 23:02:49', 39, 'S', '', 582, '::1', 'workflowtransaction_id', 'sim_hr_leaveadjustment'),
('sim_workflowtransactionhistory', 'workflowtransaction_id=''39''workflowstatus_id=''2''workflowtransaction_datetime=''10/07/28 23:02:49''uid=''1''workflowtransactionhistory_description=''', 'I', 1, '2010-07-28 23:02:49', 0, 'S', '', 583, '::1', 'workflowtransactionhistory_id', ''),
('sim_hr_leave', 'leave_no=''''leave_date=''2010-07-28''employee_id=''WEW(30)''leave_fromdate=''2010-07-12''leave_todate=''2010-07-29''leave_day=''18''time_from=''08:00:00''time_to=''08:00:00''total_hours=''00:00:00''leave_address=''''leave_telno=''''leavetype_id=''Annul Leave(8)''lecturer_remarks=''''description=''''created=''10/07/28 23:08:14''createdby=''1''updated=''10/07/28 23:08:14''updatedby=''1''organization_id=''1''panelclinic_id=''0''table_type=''L', 'I', 1, '2010-07-28 23:08:14', 26, 'S', '', 584, '::1', 'leave_id', ''),
('sim_hr_leave', 'leave_no=''''leave_date=''2010-07-28''employee_id=''WEW(30)''leave_fromdate=''2010-07-15''leave_todate=''2010-07-15''leave_day=''1''time_from=''08:00:00''time_to='' 11:15:00''total_hours=''03:15:00''leave_address=''''leave_telno=''''leavetype_id=''Annul Leave(8)''lecturer_remarks=''''description=''''created=''10/07/28 23:17:38''createdby=''1''updated=''10/07/28 23:17:38''updatedby=''1''organization_id=''1''panelclinic_id=''0''table_type=''L', 'I', 1, '2010-07-28 23:17:38', 27, 'S', '', 585, '::1', 'leave_id', ''),
('sim_hr_leave', 'issubmit=''1''', 'U', 1, '2010-07-28 23:19:29', 26, 'S', '', 586, '::1', 'leave_id', ''),
('sim_workflowtransaction', 'workflowtransaction_datetime=''10/07/28 23:19:29''target_groupid=''1''target_uid=''0''targetparameter_name=''10''workflowstatus_id=''1''workflow_id=''1''tablename=''sim_hr_leave''primarykey_name=''leave_id''primarykey_value=''26''hyperlink=''../hr/leave.php''title_description=''''created=''10/07/28 23:19:29''list_parameter=''''workflowtransaction_description=''Leave Date : 2010-07-12-2010-07-29\nReasons : \n''workflowtransaction_feedback=''''iscomplete=''0''createdby=''1''email_list=''1,10''sms_list=''1,10''email_body=''''sms_body=''''person_id=''30''issubmit=''1', 'I', 1, '2010-07-28 23:19:29', 40, 'S', '', 587, '::1', 'workflowtransaction_id', 'sim_hr_leave'),
('sim_workflowtransactionhistory', 'workflowtransaction_id=''40''workflowstatus_id=''1''workflowtransaction_datetime=''10/07/28 23:19:29''uid=''1''workflowtransactionhistory_description=''', 'I', 1, '2010-07-28 23:19:29', 0, 'S', '', 588, '::1', 'workflowtransactionhistory_id', ''),
('sim_workflowtransaction', 'workflowtransaction_datetime=''10/07/28 23:19:42''target_groupid=''1''target_uid=''0''targetparameter_name=''''workflowstatus_id=''2''workflow_id=''1''tablename=''sim_hr_leave''primarykey_name=''leave_id''primarykey_value=''26''hyperlink=''../hr/leave.php''title_description=''''created=''10/07/28 23:19:42''list_parameter=''''workflowtransaction_description=''''workflowtransaction_feedback=''''iscomplete=''0''createdby=''1''email_list=''''sms_list=''''email_body=''''sms_body=''''person_id=''30''issubmit=''1', 'I', 1, '2010-07-28 23:19:42', 41, 'S', '', 589, '::1', 'workflowtransaction_id', 'sim_hr_leave'),
('sim_workflowtransactionhistory', 'workflowtransaction_id=''41''workflowstatus_id=''2''workflowtransaction_datetime=''10/07/28 23:19:42''uid=''1''workflowtransactionhistory_description=''', 'I', 1, '2010-07-28 23:19:42', 0, 'S', '', 590, '::1', 'workflowtransactionhistory_id', ''),
('sim_workflowtransaction', 'workflowtransaction_datetime=''10/07/28 23:20:05''target_groupid=''31''target_uid=''0''targetparameter_name=''1''workflowstatus_id=''3''workflow_id=''1''tablename=''sim_hr_leave''primarykey_name=''leave_id''primarykey_value=''26''hyperlink=''../hr/leave.php''title_description=''''created=''10/07/28 23:20:05''list_parameter=''''workflowtransaction_description=''''workflowtransaction_feedback=''''iscomplete=''1''createdby=''1''email_list=''''sms_list=''''email_body=''''sms_body=''''person_id=''30''issubmit=''1', 'I', 1, '2010-07-28 23:20:05', 42, 'S', '', 591, '::1', 'workflowtransaction_id', 'sim_hr_leave'),
('sim_workflowtransactionhistory', 'workflowtransaction_id=''42''workflowstatus_id=''3''workflowtransaction_datetime=''10/07/28 23:20:05''uid=''1''workflowtransactionhistory_description=''', 'I', 1, '2010-07-28 23:20:05', 0, 'S', '', 592, '::1', 'workflowtransactionhistory_id', ''),
('sim_hr_portfolioline', 'portfolioline_datefrom=''1900-01-01''portfolioline_dateto=''1900-01-01''portfolioline_name=''aa''portfolioline_remarks=''dd''created=''2010-07-28 23:21:49''createdby=''1''updated=''2010-07-28 23:21:49''updatedby=''1''working_experience=''ww''employee_id=''30', 'I', 1, '2010-07-28 23:21:49', 4, 'S', '', 593, '::1', 'portfolioline_id', 'aa'),
('sim_hr_portfolioline', 'portfolioline_name=''dd'',<br/>portfolioline_remarks=''ddddd'',<br/>working_experience=''wwass''', 'U', 1, '2010-07-28 23:21:59', 4, 'S', '', 594, '::1', 'portfolioline_id', 'dd'),
('sim_hr_portfolioline', 'Record deleted permanentl', 'E', 1, '2010-07-28 23:22:02', 4, 'S', '', 595, '::1', 'portfolioline_id', 'dd'),
('sim_hr_department', 'department_no=''aaaa''department_name=''ddaaa''defaultlevel=''10''description=''''department_parent=''0''isactive=''1''created=''2010-07-29 05:34:15''createdby=''1868''updated=''2010-07-29 05:34:15''updatedby=''1868''organization_id=''1''department_head=''0', 'I', 1868, '2010-07-29 05:34:15', 29, 'S', '', 596, '::1', 'department_id', 'ddaaa'),
('sim_hr_attachmentline', 'attachmentline_name=''dd''attachmentline_file=''1280356019_$this->employee_id.png''attachmentline_remarks='' ''employee_id=''$this->employee_id''created=''2010-07-29 06:26:59''createdby=''1''updated=''2010-07-29 06:26:59''updatedby=''1', 'I', 1, '2010-07-29 06:26:59', 5, 'S', '', 597, '127.0.0.1', 'attachmentline_id', 'dd'),
('sim_hr_employeefamily', 'employeefamily_name=''dasd''relationship_id=''1''employeefamily_dob=''1900-01-01''employeefamily_age=''0''employeefamily_occupation=''''employeefamily_contactno=''''isnok=''1''isemergency=''1''employeefamily_remark=''''created=''2010-07-29 06:27:18''createdby=''1''updated=''2010-07-29 06:27:18''updatedby=''1''employee_id=''14', 'I', 1, '2010-07-29 06:27:18', 4, 'S', '', 598, '127.0.0.1', 'employeefamily_id', 'dasd'),
('sim_hr_employee', 'employee_epfno=''W'',<br/>employee_socsono=''R'',<br/>employee_taxno=''G'',<br/>employee_pencenno=''T'',<br/>employee_accno=''E'',<br/>employee_bankname=''Q''', 'U', 1, '2010-07-29 06:28:51', 14, 'S', '', 599, '127.0.0.1', 'employee_id', ''),
('sim_hr_attachmentline', 'attachmentline_name=''tt''attachmentline_file=''1280356274_$this->employee_id.png''attachmentline_remarks='' jj''employee_id=''$this->employee_id''created=''2010-07-29 06:31:14''createdby=''1''updated=''2010-07-29 06:31:14''updatedby=''1', 'I', 1, '2010-07-29 06:31:14', 6, 'S', '', 600, '127.0.0.1', 'attachmentline_id', 'tt'),
('sim_hr_attachmentline', 'attachmentline_name=''ghgg''attachmentline_file=''1280356346_14.jpeg''attachmentline_remarks='' ''employee_id=''14''created=''2010-07-29 06:32:26''createdby=''1''updated=''2010-07-29 06:32:26''updatedby=''1', 'I', 1, '2010-07-29 06:32:27', 7, 'S', '', 601, '127.0.0.1', 'attachmentline_id', 'ghgg'),
('sim_hr_employeefamily', 'employeefamily_dob=''2010-07-07 00:00:00''', 'U', 1, '2010-07-29 07:05:39', 4, 'S', '', 602, '127.0.0.1', 'employeefamily_id', 'dasd'),
('sim_hr_employeefamily', 'employeefamily_dob=''2010-07-01 00:00:00''', 'U', 1, '2010-07-29 07:05:39', 3, 'S', '', 603, '127.0.0.1', 'employeefamily_id', ''),
('sim_hr_employeegroup', 'isdeleted=''0''', 'U', 1, '2010-07-29 10:57:22', 13, 'S', '', 604, '::1', 'employeegroup_id', 'CLF'),
('sim_hr_employeegroup', 'isdeleted=', 'D', 1, '2010-07-29 10:57:29', 13, 'S', '', 605, '::1', 'employeegroup_id', 'CLF'),
('sim_hr_employeegroup', 'Record deleted permanentl', 'E', 1, '2010-07-29 10:57:35', 13, 'S', '', 606, '::1', 'employeegroup_id', 'CLF'),
('sim_hr_employee', 'marital_status=''2'',<br/>defaultlevel='''',<br/>organization_id=''''', 'U', 1, '2010-07-29 10:59:26', 14, 'S', '', 607, '::1', 'employee_id', '1312'),
('sim_hr_generalclaim', 'employee_id=''A-Tester(16)''generalclaim_date=''2010-07-27''generalclaim_docno=''''generalclaim_remark=''''period_id=''2010(2)''created=''10/07/29 11:10:31''createdby=''admin(1)''updated=''10/07/29 11:10:31''updatedby=''admin(1)''organization_id=''1', 'I', 1, '2010-07-29 11:10:31', 9, 'S', '', 608, '::1', 'generalclaim_id', ''),
('sim_hr_supervisorline', 'supervisorline_supervisorid=''23''isdirect=''1''supervisorline_remarks=''''created=''2010-07-29 11:54:22''createdby=''1''updated=''2010-07-29 11:54:22''updatedby=''1''employee_id=''14', 'I', 1, '2010-07-29 11:54:22', 25, 'S', '', 609, '::1', 'supervisorline_id', '23'),
('sim_hr_employeefamily', 'employeefamily_dob=''2000-07-07''', 'U', 1, '2010-07-29 12:05:42', 4, 'S', '', 610, '::1', 'employeefamily_id', 'dasd'),
('sim_hr_employeefamily', 'employeefamily_dob=''2000-07-01''', 'U', 1, '2010-07-29 12:05:42', 3, 'S', '', 611, '::1', 'employeefamily_id', ''),
('sim_hr_employeespouse', 'spouse_hpno=''2312''', 'U', 1, '2010-07-29 12:06:59', 5, 'S', '', 612, '::1', 'spouse_id', ''),
('sim_hr_attachmentline', 'Record deleted permanentl', 'E', 1, '2010-07-29 12:20:02', 4, 'S', '', 613, '::1', 'attachmentline_id', ''),
('sim_industry', 'industry_name=''qwe''isactive=''1''defaultlevel=''10''created=''2010-07-29 12:52:14''createdby=''1''updated=''2010-07-29 12:52:14''updatedby=''1''organization_id=''1''description=''dasda', 'I', 1, '2010-07-29 12:52:14', 1, 'S', 'admin', 614, '127.0.0.1', 'industry_id', 'qwe'),
('sim_industry', 'industry_name=''Medical''', 'U', 1, '2010-07-29 12:52:23', 1, 'S', 'admin', 615, '127.0.0.1', 'industry_id', 'Medical'),
('sim_industry', 'industry_name=''rfer''isactive=''1''defaultlevel=''10''created=''2010-07-29 12:55:39''createdby=''1''updated=''2010-07-29 12:55:39''updatedby=''1''organization_id=''1''description=''', 'I', 1, '2010-07-29 12:55:39', 2, 'S', 'admin', 616, '127.0.0.1', 'industry_id', 'rfer'),
('sim_industry', 'isdeleted=', 'D', 1, '2010-07-29 12:55:43', 2, 'S', 'admin', 617, '127.0.0.1', 'industry_id', ''),
('sim_hr_panelclinics', 'employee_id=''A-Tester(16)''panelclinics_date=''2010-07-08''panelclinics_ismc=''''panelclinics_totalday=''''bpartner_id=''Clinic Ali(1)''panelclinics_amount=''312''panelclinics_costbreakdown=''''organization_id=''1''created=''10/07/29 13:06:07''createdby=''admin(1)''updated=''10/07/29 13:06:07''updatedby=''admin(1)', 'I', 1, '2010-07-29 13:06:07', 11, 'S', 'admin', 618, '127.0.0.1', 'panelclinics_id', '2010-07-08'),
('sim_hr_generalclaim', 'employee_id=''DSA(22)''generalclaim_date=''2010-07-13''generalclaim_docno=''''generalclaim_remark=''''period_id=''2010(2)''created=''10/07/29 13:21:09''createdby=''admin(1)''updated=''10/07/29 13:21:09''updatedby=''admin(1)''organization_id=''1', 'I', 1, '2010-07-29 13:21:09', 10, 'S', 'admin', 619, '127.0.0.1', 'generalclaim_id', ''),
('sim_hr_generalclaim', 'employee_id=''asda(14)''generalclaim_date=''2010-07-20''generalclaim_docno=''''generalclaim_remark=''''period_id=''2010(2)''created=''10/07/29 13:21:56''createdby=''admin(1)''updated=''10/07/29 13:21:56''updatedby=''admin(1)''organization_id=''1', 'I', 1, '2010-07-29 13:21:56', 11, 'S', 'admin', 620, '127.0.0.1', 'generalclaim_id', ''),
('sim_hr_travellingclaim', 'employee_id=''asda(14)''travellingclaim_date=''2010-07-12''travellingclaim_docno=''''travellingclaim_remark=''''travellingclaim_transport=''www''period_id=''2010(2)''created=''10/07/29 13:29:53''createdby=''admin(1)''updated=''10/07/29 13:29:53''updatedby=''admin(1)''organization_id=''1', 'I', 1, '2010-07-29 13:29:53', 5, 'S', 'admin', 621, '127.0.0.1', 'travellingclaim_id', ''),
('sim_hr_travellingclaim', 'issubmit='''',<br/>=''0''', 'U', 1, '2010-07-29 13:30:18', 5, 'S', 'admin', 622, '127.0.0.1', 'travellingclaim_id', ''),
('sim_hr_travellingclaimline', 'travellingclaim_id=''5''travellingclaimline_date=''1900-01-01''travellingclaimline_from=''ds''travellingclaimline_to=''dss''travellingclaimline_distance=''123''travellingclaimline_purpose=''adsa''travellingclaimline_amount=''0122''travellingclaimline_receipt=''''remarks=''''travellingclaimline_acccode=''''created=''2010-07-29 13:30:18''createdby=''1''updated=''2010-07-29 13:30:18''updatedby=''1', 'I', 1, '2010-07-29 13:30:18', 5, 'S', 'admin', 623, '127.0.0.1', 'travellingclaim_id', 'adsa'),
('sim_hr_travellingclaimline', 'travellingclaim_id=''5''travellingclaimline_date=''1900-01-01''travellingclaimline_from=''ads''travellingclaimline_to=''dsa''travellingclaimline_distance=''12''travellingclaimline_purpose=''sada''travellingclaimline_amount=''032''travellingclaimline_receipt=''''remarks=''''travellingclaimline_acccode=''''created=''2010-07-29 13:30:18''createdby=''1''updated=''2010-07-29 13:30:18''updatedby=''1', 'I', 1, '2010-07-29 13:30:18', 5, 'S', 'admin', 624, '127.0.0.1', 'travellingclaim_id', 'sada'),
('sim_hr_medicalclaim', 'employee_id=''B-Hunter(17)''medicalclaim_date=''2010-07-18''medicalclaim_clinic=''eqw''medicalclaim_docno=''123''medicalclaim_amount=''123''medicalclaim_treatment=''eqw''medicalclaim_remark=''''period_id=''2010(2)''created=''10/07/29 13:35:41''createdby=''admin(1)''updated=''10/07/29 13:35:41''updatedby=''admin(1)''organization_id=''1', 'I', 1, '2010-07-29 13:35:41', 4, 'S', 'admin', 625, '127.0.0.1', 'medicalclaim_id', '123'),
('sim_hr_generalclaim', 'employee_id=''A-Tester(16)''generalclaim_date=''2010-07-10''generalclaim_docno=''''generalclaim_remark=''''period_id=''2010(2)''created=''10/07/29 15:47:13''createdby=''admin(1)''updated=''10/07/29 15:47:13''updatedby=''admin(1)''organization_id=''1', 'I', 1, '2010-07-29 15:47:13', 12, 'S', 'admin', 626, '127.0.0.1', 'generalclaim_id', ''),
('sim_hr_generalclaim', 'employee_id=''B-Hunter(17)''generalclaim_date=''2010-07-13''generalclaim_docno=''''generalclaim_remark=''''period_id=''2010(2)''created=''10/07/29 15:47:34''createdby=''admin(1)''updated=''10/07/29 15:47:34''updatedby=''admin(1)''organization_id=''1', 'I', 1, '2010-07-29 15:47:34', 13, 'S', 'admin', 627, '::1', 'generalclaim_id', ''),
('sim_hr_generalclaim', 'employee_id=''DSA(22)''generalclaim_date=''2010-07-06''generalclaim_docno=''''generalclaim_remark=''''period_id=''2010(2)''created=''10/07/29 15:47:46''createdby=''admin(1)''updated=''10/07/29 15:47:46''updatedby=''admin(1)''organization_id=''1', 'I', 1, '2010-07-29 15:47:46', 14, 'S', 'admin', 628, '127.0.0.1', 'generalclaim_id', ''),
('sim_hr_generalclaim', 'employee_id=''B-Hunter(17)''generalclaim_date=''2010-07-13''generalclaim_docno=''''generalclaim_remark=''''period_id=''2010(2)''created=''10/07/29 16:14:00''createdby=''admin(1)''updated=''10/07/29 16:14:00''updatedby=''admin(1)''organization_id=''1', 'I', 1, '2010-07-29 16:14:00', 15, 'S', 'admin', 629, '127.0.0.1', 'generalclaim_id', ''),
('sim_hr_travellingclaim', 'employee_id=''A-Tester(16)''travellingclaim_date=''2010-07-19''travellingclaim_docno=''''travellingclaim_remark=''''travellingclaim_transport=''fre''period_id=''2010(2)''created=''10/07/29 16:23:58''createdby=''admin(1)''updated=''10/07/29 16:23:58''updatedby=''admin(1)''organization_id=''1', 'I', 1, '2010-07-29 16:23:58', 6, 'S', 'admin', 630, '::1', 'travellingclaim_id', ''),
('sim_hr_travellingclaim', 'issubmit='''',<br/>=''0''', 'U', 1, '2010-07-29 16:24:12', 6, 'S', 'admin', 631, '::1', 'travellingclaim_id', ''),
('sim_hr_travellingclaimline', 'travellingclaim_id=''6''travellingclaimline_date=''1900-01-01''travellingclaimline_from=''sad''travellingclaimline_to=''dsa''travellingclaimline_distance=''''travellingclaimline_purpose=''dsa''travellingclaimline_amount=''0''travellingclaimline_receipt=''''remarks=''''travellingclaimline_acccode=''''created=''2010-07-29 16:24:12''createdby=''1''updated=''2010-07-29 16:24:12''updatedby=''1', 'I', 1, '2010-07-29 16:24:12', 6, 'S', 'admin', 632, '::1', 'travellingclaim_id', 'dsa'),
('sim_hr_travellingclaimline', 'travellingclaim_id=''6''travellingclaimline_date=''1900-01-01''travellingclaimline_from=''asd''travellingclaimline_to=''''travellingclaimline_distance=''''travellingclaimline_purpose=''das''travellingclaimline_amount=''0123''travellingclaimline_receipt=''''remarks=''''travellingclaimline_acccode=''''created=''2010-07-29 16:24:12''createdby=''1''updated=''2010-07-29 16:24:12''updatedby=''1', 'I', 1, '2010-07-29 16:24:12', 6, 'S', 'admin', 633, '::1', 'travellingclaim_id', 'das'),
('sim_hr_overtimeclaim', 'employee_id=''DSA(22)''overtimeclaim_date=''2010-07-21''overtimeclaim_docno=''''overtimeclaim_remark=''''created=''10/07/29 16:33:10''createdby=''admin(1)''updated=''10/07/29 16:33:10''updatedby=''admin(1)''organization_id=''1', 'I', 1, '2010-07-29 16:33:10', 4, 'S', 'admin', 634, '::1', 'overtimeclaim_id', ''),
('sim_hr_employee', 'employee_name=''DSDS''employee_cardno=''123dasd''employee_no=''das12312''uid=''''place_dob=''''employee_dob=''2010-07-07''races_id=''3''religion_id=''3''gender=''F''marital_status=''2''employee_citizenship=''2''employee_newicno=''''employee_oldicno=''''ic_color=''B''employee_passport=''''employee_bloodgroup=''''department_id=''13''jobposition_id=''56''employeegroup_id=''12''employee_joindate=''2010-07-07''filephoto=''''updated=''2010-07-29 17:30:44''updatedby=''1''defaultlevel=''''organization_id=''''created=''2010-07-29 17:30:44''createdby=''1''employee_transport=''dasdas''employee_status=''1''isactive=''''employee_altname=''asd''ic_placeissue=''''employee_passport_placeissue=''''employee_passport_issuedate=''''employee_passport_expirydate=''''employee_confirmdate=''''employee_enddate=''', 'I', 1, '2010-07-29 17:30:44', 32, 'S', 'admin', 635, '::1', 'employee_id', 'DSDS'),
('sim_hr_employee', 'defaultlevel='''',<br/>organization_id='''',<br/>isactive=''''', 'U', 1, '2010-07-29 17:30:55', 32, 'S', 'admin', 636, '::1', 'employee_id', 'das12312'),
('sim_hr_overtimeclaim', 'employee_id=''A-Tester(16)''overtimeclaim_date=''2010-07-19''overtimeclaim_docno=''''overtimeclaim_remark=''''created=''10/07/29 17:57:56''createdby=''admin(1)''updated=''10/07/29 17:57:56''updatedby=''admin(1)''organization_id=''1', 'I', 1, '2010-07-29 17:57:56', 5, 'S', 'admin', 637, '::1', 'overtimeclaim_id', ''),
('sim_hr_employeegroup', 'employeegroup_no=''we''employeegroup_name=''ee''islecturer=''1''isovertime=''1''isparttime=''1''isactive=''1''defaultlevel=''10''created=''2010-07-29 18:04:55''createdby=''1''updated=''2010-07-29 18:04:55''updatedby=''1''organization_id=''1''description=''', 'I', 1, '2010-07-29 18:04:56', 15, 'S', 'admin', 638, '::1', 'employeegroup_id', 'we'),
('sim_hr_employeegroup', 'isdeleted=', 'D', 1, '2010-07-29 18:05:00', 15, 'S', 'admin', 639, '::1', 'employeegroup_id', 'we'),
('sim_hr_department', 'department_no=''DSSS''department_name=''SSDSDS''defaultlevel=''10''description=''''department_parent=''0''isactive=''1''created=''2010-07-29 18:06:27''createdby=''1''updated=''2010-07-29 18:06:27''updatedby=''1''organization_id=''1''department_head=''0', 'I', 1, '2010-07-29 18:06:27', 30, 'S', 'admin', 640, '::1', 'department_id', 'SSDSDS'),
('sim_hr_department', 'department_no=''DSDS''department_name=''12312''defaultlevel=''10''description=''''department_parent=''0''isactive=''1''created=''2010-07-29 18:06:32''createdby=''1''updated=''2010-07-29 18:06:32''updatedby=''1''organization_id=''1''department_head=''0', 'I', 1, '2010-07-29 18:06:32', 31, 'S', 'admin', 641, '::1', 'department_id', '12312'),
('sim_hr_department', 'department_no=''aasd''department_name=''asdas''defaultlevel=''10''description=''''department_parent=''0''isactive=''1''created=''2010-07-29 18:06:37''createdby=''1''updated=''2010-07-29 18:06:37''updatedby=''1''organization_id=''1''department_head=''0', 'I', 1, '2010-07-29 18:06:37', 32, 'S', 'admin', 642, '::1', 'department_id', 'asdas'),
('sim_hr_jobposition', 'jobposition_name=''Kaunselors''', 'U', 1, '2010-07-29 18:09:15', 53, 'S', 'admin', 643, '::1', 'jobposition_id', '1'),
('sim_hr_jobposition', 'jobposition_no=''Wd''jobposition_name=''WWW''isactive=''1''defaultlevel=''10''created=''2010-07-29 18:09:47''createdby=''1''updated=''2010-07-29 18:09:47''updatedby=''1''organization_id=''1''description=''', 'I', 1, '2010-07-29 18:09:47', 58, 'S', 'admin', 644, '::1', 'jobposition_id', 'Wd'),
('sim_hr_employee', 'employee_name=''Lister''employee_cardno=''JK20C''employee_no=''J001''uid=''1869''place_dob=''''employee_dob=''2010-07-13''races_id=''1''religion_id=''2''gender=''M''marital_status=''''employee_citizenship=''2''employee_newicno=''''employee_oldicno=''123312''ic_color=''B''employee_passport=''WW''employee_bloodgroup=''''department_id=''13''jobposition_id=''56''employeegroup_id=''12''employee_joindate=''2010-07-13''filephoto=''1280398365_photofile.png''updated=''2010-07-29 18:12:45''updatedby=''1''defaultlevel=''''organization_id=''''created=''2010-07-29 18:12:45''createdby=''1''employee_transport=''CVS''employee_status=''0''isactive=''1''employee_altname=''Lister Jay''ic_placeissue=''''employee_passport_placeissue=''''employee_passport_issuedate=''''employee_passport_expirydate=''''employee_confirmdate=''''employee_enddate=''', 'I', 1, '2010-07-29 18:12:45', 33, 'S', 'admin', 645, '::1', 'employee_id', 'Lister'),
('sim_hr_qualificationline', 'qualification_type=''4''qualification_name=''Dipdas''qualification_institution=''dsada''qualification_month=''2010-07-05 00:00:00''created=''2010-07-29 18:14:47''createdby=''1''updated=''2010-07-29 18:14:47''updatedby=''1''employee_id=''33', 'I', 1, '2010-07-29 18:14:47', 19, 'S', 'admin', 646, '::1', 'qualification_id', 'Dipdas'),
('sim_hr_employee', 'marital_status=''2'',<br/>defaultlevel='''',<br/>organization_id='''',<br/>employee_status=''1'',<br/>employee_passport_issuedate=''2010-07-06''', 'U', 1, '2010-07-29 18:15:25', 33, 'S', 'admin', 647, '::1', 'employee_id', 'J001'),
('sim_hr_employee', 'employee_name=''FDD''employee_cardno=''''employee_no=''WDS@#''uid=''''place_dob=''''employee_dob=''2010-07-06''races_id=''3''religion_id=''4''gender=''M''marital_status=''2''employee_citizenship=''2''employee_newicno=''''employee_oldicno=''''ic_color=''B''employee_passport=''''employee_bloodgroup=''''department_id=''14''jobposition_id=''52''employeegroup_id=''12''employee_joindate=''2010-07-12''filephoto=''''updated=''2010-07-29 18:16:17''updatedby=''1''defaultlevel=''''organization_id=''''created=''2010-07-29 18:16:17''createdby=''1''employee_transport=''''employee_status=''1''isactive=''''employee_altname=''WDW''ic_placeissue=''''employee_passport_placeissue=''''employee_passport_issuedate=''''employee_passport_expirydate=''''employee_confirmdate=''''employee_enddate=''', 'I', 1, '2010-07-29 18:16:17', 34, 'S', 'admin', 648, '::1', 'employee_id', 'FDD'),
('sim_hr_employee', 'employee_hpno=''3213'',<br/>employee_officeno=''312312'',<br/>employee_email=''adas'',<br/>employee_networkacc=''TTTT'',<br/>employee_msgacc=''RRRR'',<br/>permanent_address=''UUUU'',<br/>permanent_postcode=''QQ'',<br/>permanent_city=''WW'',<br/>permanent_state=''SS'',<br/>permanent_country=''3'',<br/>permanent_telno=''1111'',<br/>contact_address=''YYYY'',<br/>contact_postcode=''DD'',<br/>contact_city=''EE'',<br/>contact_state=''FF'',<br/>contact_country=''2'',<br/>contact_telno=''2222''', 'U', 1, '2010-07-29 18:16:59', 34, 'S', 'admin', 649, '::1', 'employee_id', ''),
('sim_hr_employeespouse', 'employee_id=''34''spouse_name=''DSDS''spouse_dob=''2010-07-15''spouse_placedob=''''spouse_placeissue=''''spouse_hpno=''''spouse_races=''3''spouse_religion=''4''spouse_gender=''M''spouse_bloodgroup=''''spouse_occupation=''''spouse_citizenship=''3''spouse_newicno=''''spouse_oldicno=''''spouse_ic_color=''B''spouse_passport=''''spouse_issuedate=''''spouse_expirydate=''''created=''2010-07-29 18:17:31''createdby=''1''updated=''2010-07-29 18:17:31''updatedby=''1', 'I', 1, '2010-07-29 18:17:31', 7, 'S', 'admin', 650, '::1', 'spouse_id', 'DSDS'),
('sim_hr_attachmentline', 'attachmentline_name=''das''attachmentline_file=''1280398750_34.jpeg''attachmentline_remarks='' ''employee_id=''34''created=''2010-07-29 18:19:10''createdby=''1''updated=''2010-07-29 18:19:10''updatedby=''1', 'I', 1, '2010-07-29 18:19:10', 8, 'S', 'admin', 651, '::1', 'attachmentline_id', 'das'),
('sim_hr_portfolioline', 'portfolioline_datefrom=''2010-07-06 00:00:00''portfolioline_dateto=''2010-07-29 00:00:00''portfolioline_name=''QWE''portfolioline_remarks=''SDS''created=''2010-07-29 18:22:50''createdby=''1''updated=''2010-07-29 18:22:50''updatedby=''1''working_experience=''EWQ''employee_id=''34', 'I', 1, '2010-07-29 18:22:50', 4, 'S', 'admin', 652, '::1', 'portfolioline_id', 'QWE'),
('sim_hr_trainingline', 'trainingline_name=''rwe''trainingtype_id=''10''trainingline_venue=''wer''trainingline_purpose=''fsd''trainingline_startdate=''1900-01-01''trainingline_enddate=''1900-01-01''trainingline_trainerid=''1''trainingline_result=''ww''trainingline_hodcom=''ee''trainingline_hrcom=''rr''trainingline_remarks=''ttt''trainingline_trainer =''ewr''created=''2010-07-29 18:25:53''createdby=''1''updated=''2010-07-29 18:25:53''updatedby=''1''employee_id=''34', 'I', 1, '2010-07-29 18:25:53', 13, 'S', 'admin', 653, '::1', 'trainingline_id', 'rwe'),
('sim_hr_employee', 'employee_epfno=''FF'',<br/>employee_socsono=''GG'',<br/>employee_taxno=''RR'',<br/>employee_pencenno=''TT'',<br/>employee_accno=''WWW'',<br/>employee_bankname=''QQQ''', 'U', 1, '2010-07-29 18:26:59', 34, 'S', 'admin', 654, '::1', 'employee_id', ''),
('sim_hr_appraisalline', 'appraisalline_name=''das''appraisalline_date=''1900-01-01''appraisalline_datedue=''1900-01-01''appraisalline_increment=''012''appraisalline_result=''das''appraisalline_remarks=''''isdeleted=''''created=''2010-07-29 18:27:15''createdby=''1''updated=''2010-07-29 18:27:15''updatedby=''1''employee_id=''34', 'I', 1, '2010-07-29 18:27:16', 3, 'S', 'admin', 655, '::1', 'appraisalline_id', 'das'),
('sim_hr_panelclinics', 'employee_id=''A-Tester(16)''panelclinics_date=''2010-07-08''panelclinics_ismc=''''panelclinics_totalday=''''bpartner_id=''Clinic Ali(1)''panelclinics_amount=''1231''panelclinics_costbreakdown=''''organization_id=''1''created=''10/07/29 18:39:38''createdby=''admin(1)''updated=''10/07/29 18:39:38''updatedby=''admin(1)', 'I', 1, '2010-07-29 18:39:38', 12, 'S', 'admin', 656, '::1', 'panelclinics_id', '2010-07-08'),
('sim_hr_panelclinics', 'panelclinics_ismc='''',<br/>panelclinics_totalday='''',<br/>panelclinics_costbreakdown=''sASA''', 'U', 1, '2010-07-29 18:43:00', 11, 'S', 'admin', 657, '::1', 'panelclinics_id', '2010-07-08'),
('sim_hr_generalclaim', 'employee_id=''B-Hunter(17)''generalclaim_date=''2010-07-06''generalclaim_docno=''xz''generalclaim_remark=''''period_id=''2010(2)''created=''10/07/29 18:44:30''createdby=''admin(1)''updated=''10/07/29 18:44:30''updatedby=''admin(1)''organization_id=''1', 'I', 1, '2010-07-29 18:44:30', 16, 'S', 'admin', 658, '::1', 'generalclaim_id', 'xz'),
('sim_hr_generalclaim', 'issubmit=''''', 'U', 1, '2010-07-29 18:45:19', 16, 'S', 'admin', 659, '::1', 'generalclaim_id', 'xz'),
('sim_hr_generalclaimline', 'generalclaim_id=''16''generalclaimline_date=''1900-01-01''generalclaimline_details=''das''generalclaimline_porpose=''aa''generalclaimline_billno=''dd''generalclaimline_amount=''01200''remarks=''das''generalclaimline_acccode=''''created=''2010-07-29 18:45:19''createdby=''1''updated=''2010-07-29 18:45:19''updatedby=''1', 'I', 1, '2010-07-29 18:45:19', 20, 'S', 'admin', 660, '::1', 'generalclaimline_id', 'das'),
('sim_hr_generalclaimline', 'generalclaim_id=''16''generalclaimline_date=''1900-01-01''generalclaimline_details=''das''generalclaimline_porpose=''aa''generalclaimline_billno=''dd''generalclaimline_amount=''01300''remarks=''aa''generalclaimline_acccode=''''created=''2010-07-29 18:45:19''createdby=''1''updated=''2010-07-29 18:45:19''updatedby=''1', 'I', 1, '2010-07-29 18:45:19', 21, 'S', 'admin', 661, '::1', 'generalclaimline_id', 'das'),
('sim_hr_generalclaimline', 'generalclaim_id=''16''generalclaimline_date=''1900-01-01''generalclaimline_details=''das''generalclaimline_porpose=''sdas''generalclaimline_billno=''''generalclaimline_amount=''0222''remarks=''''generalclaimline_acccode=''''created=''2010-07-29 18:45:19''createdby=''1''updated=''2010-07-29 18:45:19''updatedby=''1', 'I', 1, '2010-07-29 18:45:19', 22, 'S', 'admin', 662, '::1', 'generalclaimline_id', 'das'),
('sim_hr_generalclaim', 'employee_id=''17B-Hunter'',<br/>issubmit=''1''', 'U', 1, '2010-07-29 18:47:04', 16, 'S', 'admin', 663, '::1', 'generalclaim_id', 'xz'),
('sim_workflowtransaction', 'workflowtransaction_datetime=''10/07/29 18:47:04''target_groupid=''1''target_uid=''0''targetparameter_name=''10''workflowstatus_id=''1''workflow_id=''4''tablename=''sim_hr_generalclaim''primarykey_name=''generalclaim_id''primarykey_value=''16''hyperlink=''../hr/generalclaim.php''title_description=''''created=''10/07/29 18:47:04''list_parameter=''''workflowtransaction_description=''Ok done''workflowtransaction_feedback=''''iscomplete=''0''createdby=''1''email_list=''1,10''sms_list=''1,10''email_body=''''sms_body=''''person_id=''17''issubmit=''1', 'I', 1, '2010-07-29 18:47:04', 43, 'S', 'admin', 664, '::1', 'workflowtransaction_id', 'sim_hr_generalclaim'),
('sim_workflowtransactionhistory', 'workflowtransaction_id=''43''workflowstatus_id=''1''workflowtransaction_datetime=''10/07/29 18:47:04''uid=''1''workflowtransactionhistory_description=''', 'I', 1, '2010-07-29 18:47:04', 0, 'S', 'admin', 665, '::1', 'workflowtransactionhistory_id', ''),
('sim_hr_leaveadjustment', 'leavetype_id=''Birthday Leave(10)''created=''10/07/29 18:51:40''createdby=''admin(1)''updated=''10/07/29 18:51:40''updatedby=''admin(1)''organization_id=''1', 'I', 1, '2010-07-29 18:51:40', 22, 'S', 'admin', 666, '::1', 'leaveadjustment_id', 'admin'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''22''employee_id=''14''leaveadjustmentline_totalday=''2''created=''2010-07-29 18:51:40''createdby=''1''updated=''2010-07-29 18:51:40''updatedby=''1', 'I', 1, '2010-07-29 18:51:40', 351, 'S', 'admin', 667, '::1', 'leaveadjustmentline_id', '22'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''22''employee_id=''30''leaveadjustmentline_totalday=''2''created=''2010-07-29 18:51:40''createdby=''1''updated=''2010-07-29 18:51:40''updatedby=''1', 'I', 1, '2010-07-29 18:51:40', 352, 'S', 'admin', 668, '::1', 'leaveadjustmentline_id', '22'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''22''employee_id=''23''leaveadjustmentline_totalday=''2''created=''2010-07-29 18:51:40''createdby=''1''updated=''2010-07-29 18:51:40''updatedby=''1', 'I', 1, '2010-07-29 18:51:40', 353, 'S', 'admin', 669, '::1', 'leaveadjustmentline_id', '22'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''22''employee_id=''20''leaveadjustmentline_totalday=''2''created=''2010-07-29 18:51:40''createdby=''1''updated=''2010-07-29 18:51:40''updatedby=''1', 'I', 1, '2010-07-29 18:51:40', 354, 'S', 'admin', 670, '::1', 'leaveadjustmentline_id', '22'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''22''employee_id=''21''leaveadjustmentline_totalday=''2''created=''2010-07-29 18:51:40''createdby=''1''updated=''2010-07-29 18:51:40''updatedby=''1', 'I', 1, '2010-07-29 18:51:40', 355, 'S', 'admin', 671, '::1', 'leaveadjustmentline_id', '22'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''22''employee_id=''16''leaveadjustmentline_totalday=''2''created=''2010-07-29 18:51:40''createdby=''1''updated=''2010-07-29 18:51:40''updatedby=''1', 'I', 1, '2010-07-29 18:51:40', 356, 'S', 'admin', 672, '::1', 'leaveadjustmentline_id', '22'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''22''employee_id=''17''leaveadjustmentline_totalday=''2''created=''2010-07-29 18:51:40''createdby=''1''updated=''2010-07-29 18:51:40''updatedby=''1', 'I', 1, '2010-07-29 18:51:40', 357, 'S', 'admin', 673, '::1', 'leaveadjustmentline_id', '22'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''22''employee_id=''18''leaveadjustmentline_totalday=''2''created=''2010-07-29 18:51:40''createdby=''1''updated=''2010-07-29 18:51:40''updatedby=''1', 'I', 1, '2010-07-29 18:51:40', 358, 'S', 'admin', 674, '::1', 'leaveadjustmentline_id', '22'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''22''employee_id=''24''leaveadjustmentline_totalday=''2''created=''2010-07-29 18:51:40''createdby=''1''updated=''2010-07-29 18:51:40''updatedby=''1', 'I', 1, '2010-07-29 18:51:40', 359, 'S', 'admin', 675, '::1', 'leaveadjustmentline_id', '22'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''22''employee_id=''15''leaveadjustmentline_totalday=''2''created=''2010-07-29 18:51:40''createdby=''1''updated=''2010-07-29 18:51:40''updatedby=''1', 'I', 1, '2010-07-29 18:51:41', 360, 'S', 'admin', 676, '::1', 'leaveadjustmentline_id', '22'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''22''employee_id=''22''leaveadjustmentline_totalday=''2''created=''2010-07-29 18:51:40''createdby=''1''updated=''2010-07-29 18:51:40''updatedby=''1', 'I', 1, '2010-07-29 18:51:41', 361, 'S', 'admin', 677, '::1', 'leaveadjustmentline_id', '22');
INSERT INTO `sim_audit` (`tablename`, `changedesc`, `category`, `uid`, `updated`, `record_id`, `eventype`, `uname`, `audit_id`, `ip`, `primarykey`, `controlvalue`) VALUES
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''22''employee_id=''33''leaveadjustmentline_totalday=''2''created=''2010-07-29 18:51:40''createdby=''1''updated=''2010-07-29 18:51:40''updatedby=''1', 'I', 1, '2010-07-29 18:51:41', 362, 'S', 'admin', 678, '::1', 'leaveadjustmentline_id', '22'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''22''employee_id=''19''leaveadjustmentline_totalday=''2''created=''2010-07-29 18:51:40''createdby=''1''updated=''2010-07-29 18:51:40''updatedby=''1', 'I', 1, '2010-07-29 18:51:41', 363, 'S', 'admin', 679, '::1', 'leaveadjustmentline_id', '22'),
('sim_hr_medicalclaim', 'employee_id=''A-Tester(16)''medicalclaim_date=''2010-07-14''medicalclaim_clinic=''das''medicalclaim_docno=''das''medicalclaim_amount=''123''medicalclaim_treatment=''das''medicalclaim_remark=''''period_id=''2010(2)''created=''10/07/29 18:59:43''createdby=''admin(1)''updated=''10/07/29 18:59:43''updatedby=''admin(1)''organization_id=''1', 'I', 1, '2010-07-29 18:59:44', 5, 'S', 'admin', 680, '::1', 'medicalclaim_id', 'das'),
('sim_hr_medicalclaim', 'employee_id=''B-Hunter(17)''medicalclaim_date=''2010-07-13''medicalclaim_clinic=''e''medicalclaim_docno=''w''medicalclaim_amount=''23''medicalclaim_treatment=''r''medicalclaim_remark=''''period_id=''2010(2)''created=''10/07/29 19:02:31''createdby=''admin(1)''updated=''10/07/29 19:02:31''updatedby=''admin(1)''organization_id=''1', 'I', 1, '2010-07-29 19:02:32', 6, 'S', 'admin', 681, '::1', 'medicalclaim_id', 'w'),
('sim_hr_medicalclaim', 'issubmit=''1''', 'U', 1, '2010-07-29 19:02:36', 6, 'S', 'admin', 682, '::1', 'medicalclaim_id', 'w'),
('sim_workflowtransaction', 'workflowtransaction_datetime=''10/07/29 19:02:36''target_groupid=''1''target_uid=''0''targetparameter_name=''10''workflowstatus_id=''1''workflow_id=''10''tablename=''sim_hr_medicalclaim''primarykey_name=''medicalclaim_id''primarykey_value=''6''hyperlink=''''title_description=''''created=''10/07/29 19:02:36''list_parameter=''''workflowtransaction_description=''''workflowtransaction_feedback=''''iscomplete=''0''createdby=''1''email_list=''1,10''sms_list=''1,10''email_body=''''sms_body=''''person_id=''17''issubmit=''1', 'I', 1, '2010-07-29 19:02:36', 44, 'S', 'admin', 683, '::1', 'workflowtransaction_id', 'sim_hr_medicalclaim'),
('sim_workflowtransactionhistory', 'workflowtransaction_id=''44''workflowstatus_id=''1''workflowtransaction_datetime=''10/07/29 19:02:36''uid=''1''workflowtransactionhistory_description=''', 'I', 1, '2010-07-29 19:02:36', 0, 'S', 'admin', 684, '::1', 'workflowtransactionhistory_id', ''),
('sim_hr_overtimeclaim', 'employee_id=''A-Tester(16)''overtimeclaim_date=''2010-07-26''overtimeclaim_docno=''''overtimeclaim_remark=''''created=''10/07/29 19:03:11''createdby=''admin(1)''updated=''10/07/29 19:03:11''updatedby=''admin(1)''organization_id=''1', 'I', 1, '2010-07-29 19:03:11', 6, 'S', 'admin', 685, '::1', 'overtimeclaim_id', ''),
('sim_hr_employeefamily', 'employeefamily_name=''ddas''relationship_id=''1''employeefamily_dob=''1900-01-01''employeefamily_occupation=''''employeefamily_contactno=''''isnok=''1''isemergency=''1''employeefamily_remark=''''created=''2010-07-29 19:26:12''createdby=''1''updated=''2010-07-29 19:26:12''updatedby=''1''employee_id=''23', 'I', 1, '2010-07-29 19:26:12', 5, 'S', 'admin', 686, '::1', 'employeefamily_id', 'ddas'),
('sim_hr_employeefamily', 'employeefamily_name=''adas''relationship_id=''1''employeefamily_dob=''1900-01-01''employeefamily_occupation=''''employeefamily_contactno=''''isnok=''1''isemergency=''1''employeefamily_remark=''''created=''2010-07-29 19:29:22''createdby=''1''updated=''2010-07-29 19:29:22''updatedby=''1''employee_id=''23', 'I', 1, '2010-07-29 19:29:22', 6, 'S', 'admin', 687, '::1', 'employeefamily_id', 'adas'),
('sim_hr_employeegroup', 'employeegroup_no=''DFS''', 'U', 1, '2010-07-29 19:36:51', 11, 'S', 'admin', 688, '::1', 'employeegroup_id', 'DFS'),
('sim_hr_employeegroup', 'employeegroup_no=''LFS''', 'U', 1, '2010-07-29 19:37:23', 12, 'S', 'admin', 689, '::1', 'employeegroup_id', 'LFS'),
('sim_hr_jobposition', 'jobposition_no=''12S''', 'U', 1, '2010-07-29 19:37:36', 53, 'S', 'admin', 690, '::1', 'jobposition_id', '12S'),
('sim_hr_leavetype', 'isvalidate=''1''', 'U', 1, '2010-07-29 19:38:04', 8, 'S', 'admin', 691, '::1', 'leavetype_id', 'Annul Leave'),
('sim_hr_leavetype', 'isvalidate=''1''', 'U', 1, '2010-07-29 19:38:34', 9, 'S', 'admin', 692, '::1', 'leavetype_id', 'Mecdical Leave'),
('sim_hr_disciplinetype', 'isactive=''0''', 'U', 1, '2010-07-29 19:39:10', 14, 'S', 'admin', 693, '::1', 'disciplinetype_id', 'Chating'),
('sim_hr_disciplinetype', 'isactive=''1''', 'U', 1, '2010-07-29 19:39:45', 14, 'S', 'admin', 694, '::1', 'disciplinetype_id', 'Chating'),
('sim_hr_panelclinics', 'employee_id=''A-Tester(16)''panelclinics_date=''2010-07-07''panelclinics_ismc=''''panelclinics_totalday=''''bpartner_id=''Clinic Ali(1)''panelclinics_amount=''123''panelclinics_costbreakdown=''''organization_id=''1''created=''10/07/30 05:57:47''createdby=''admin(1)''updated=''10/07/30 05:57:47''updatedby=''admin(1)', 'I', 1, '2010-07-30 05:57:47', 13, 'S', 'admin', 695, '::1', 'panelclinics_id', '2010-07-07'),
('sim_hr_panelclinics', 'employee_id=''FD(21)''panelclinics_date=''2010-07-17''panelclinics_ismc=''''panelclinics_totalday=''''bpartner_id=''Clinic Ali(1)''panelclinics_amount=''123''panelclinics_costbreakdown=''''organization_id=''1''created=''10/07/30 05:58:48''createdby=''admin(1)''updated=''10/07/30 05:58:48''updatedby=''admin(1)', 'I', 1, '2010-07-30 05:58:48', 14, 'S', 'admin', 696, '::1', 'panelclinics_id', '2010-07-17'),
('sim_hr_employeegroup', 'employeegroup_no=''DF''', 'U', 1, '2010-07-30 06:46:42', 11, 'S', 'admin', 697, '::1', 'employeegroup_id', 'DF'),
('sim_hr_jobposition', 'jobposition_no=''12Sd''', 'U', 1, '2010-07-30 06:46:51', 53, 'S', 'admin', 698, '::1', 'jobposition_id', '12Sd'),
('sim_hr_leavetype', 'isvalidate=''0''', 'U', 1, '2010-07-30 06:47:02', 8, 'S', 'admin', 699, '::1', 'leavetype_id', 'Annul Leave'),
('sim_hr_leavetype', 'isvalidate=''0''', 'U', 1, '2010-07-30 06:47:02', 10, 'S', 'admin', 700, '::1', 'leavetype_id', 'Birthday Leave'),
('sim_hr_leavetype', 'isvalidate=''0''', 'U', 1, '2010-07-30 06:47:02', 9, 'S', 'admin', 701, '::1', 'leavetype_id', 'Mecdical Leave'),
('sim_hr_disciplinetype', 'description=''dasas''', 'U', 1, '2010-07-30 06:47:13', 15, 'S', 'admin', 702, '::1', 'disciplinetype_id', 'Puching'),
('sim_hr_disciplinetype', 'description=''sadasda''', 'U', 1, '2010-07-30 06:47:20', 14, 'S', 'admin', 703, '::1', 'disciplinetype_id', 'Chating'),
('sim_hr_disciplinetype', 'description=''sadasdaasdadasdas''', 'U', 1, '2010-07-30 06:47:27', 14, 'S', 'admin', 704, '::1', 'disciplinetype_id', 'Chating'),
('sim_hr_trainingtype', 'description=''qqsdas''', 'U', 1, '2010-07-30 06:47:40', 10, 'S', 'admin', 705, '::1', 'trainingtype_id', 'Maintain Skill'),
('sim_hr_medicalclaim', 'employee_id=''asda(14)''medicalclaim_date=''2010-07-20''medicalclaim_clinic=''dasd''medicalclaim_docno=''das''medicalclaim_amount=''123''medicalclaim_treatment=''das''medicalclaim_remark=''''period_id=''2010(2)''created=''10/07/30 07:12:22''createdby=''admin(1)''updated=''10/07/30 07:12:22''updatedby=''admin(1)''organization_id=''1', 'I', 1, '2010-07-30 07:12:22', 7, 'S', 'admin', 706, '::1', 'medicalclaim_id', 'das'),
('sim_hr_travellingclaim', 'employee_id=''a(23)''travellingclaim_date=''2010-07-23''travellingclaim_docno=''''travellingclaim_remark=''''travellingclaim_transport=''adas''period_id=''2010(2)''created=''10/07/30 07:23:14''createdby=''admin(1)''updated=''10/07/30 07:23:14''updatedby=''admin(1)''organization_id=''1', 'I', 1, '2010-07-30 07:23:14', 7, 'S', 'admin', 707, '::1', 'travellingclaim_id', ''),
('sim_hr_travellingclaim', 'issubmit='''',<br/>=''0''', 'U', 1, '2010-07-30 07:23:58', 7, 'S', 'admin', 708, '::1', 'travellingclaim_id', ''),
('sim_hr_travellingclaimline', 'travellingclaim_id=''7''travellingclaimline_date=''1900-01-01''travellingclaimline_from=''''travellingclaimline_to=''''travellingclaimline_distance=''''travellingclaimline_purpose=''''travellingclaimline_amount=''0''travellingclaimline_receipt=''''remarks=''''travellingclaimline_acccode=''''created=''2010-07-30 07:23:58''createdby=''1''updated=''2010-07-30 07:23:58''updatedby=''1', 'I', 1, '2010-07-30 07:23:58', 7, 'S', 'admin', 709, '::1', 'travellingclaim_id', ''),
('sim_hr_travellingclaimline', 'travellingclaim_id=''7''travellingclaimline_date=''1900-01-01''travellingclaimline_from=''''travellingclaimline_to=''''travellingclaimline_distance=''''travellingclaimline_purpose=''''travellingclaimline_amount=''0''travellingclaimline_receipt=''''remarks=''''travellingclaimline_acccode=''''created=''2010-07-30 07:23:58''createdby=''1''updated=''2010-07-30 07:23:58''updatedby=''1', 'I', 1, '2010-07-30 07:23:58', 7, 'S', 'admin', 710, '::1', 'travellingclaim_id', ''),
('sim_hr_travellingclaim', 'employee_id=''asda(14)''travellingclaim_date=''2010-07-21''travellingclaim_docno=''''travellingclaim_remark=''''travellingclaim_transport=''das''period_id=''2010(2)''created=''10/07/30 07:26:42''createdby=''admin(1)''updated=''10/07/30 07:26:42''updatedby=''admin(1)''organization_id=''1', 'I', 1, '2010-07-30 07:26:42', 8, 'S', 'admin', 711, '::1', 'travellingclaim_id', ''),
('sim_hr_generalclaim', 'employee_id=''A-Tester(16)''generalclaim_date=''2010-07-28''generalclaim_docno=''''generalclaim_remark=''''period_id=''2010(2)''created=''10/07/30 07:27:58''createdby=''admin(1)''updated=''10/07/30 07:27:58''updatedby=''admin(1)''organization_id=''1', 'I', 1, '2010-07-30 07:27:58', 17, 'S', 'admin', 712, '::1', 'generalclaim_id', ''),
('sim_hr_generalclaim', 'issubmit=''''', 'U', 1, '2010-07-30 07:28:58', 17, 'S', 'admin', 713, '::1', 'generalclaim_id', ''),
('sim_hr_generalclaimline', 'generalclaim_id=''17''generalclaimline_date=''1900-01-01''generalclaimline_details=''''generalclaimline_porpose=''''generalclaimline_billno=''''generalclaimline_amount=''0''remarks=''''generalclaimline_acccode=''''created=''2010-07-30 07:28:58''createdby=''1''updated=''2010-07-30 07:28:58''updatedby=''1', 'I', 1, '2010-07-30 07:28:59', 23, 'S', 'admin', 714, '::1', 'generalclaimline_id', ''),
('sim_hr_generalclaimline', 'generalclaim_id=''17''generalclaimline_date=''1900-01-01''generalclaimline_details=''''generalclaimline_porpose=''''generalclaimline_billno=''''generalclaimline_amount=''0''remarks=''''generalclaimline_acccode=''''created=''2010-07-30 07:28:58''createdby=''1''updated=''2010-07-30 07:28:58''updatedby=''1', 'I', 1, '2010-07-30 07:28:59', 24, 'S', 'admin', 715, '::1', 'generalclaimline_id', ''),
('sim_hr_generalclaim', 'employee_id=''A-Tester(16)''generalclaim_date=''2010-07-28''generalclaim_docno=''''generalclaim_remark=''''period_id=''2010(2)''created=''10/07/30 09:05:33''createdby=''admin(1)''updated=''10/07/30 09:05:33''updatedby=''admin(1)''organization_id=''1', 'I', 1, '2010-07-30 09:05:33', 18, 'S', 'admin', 716, '::1', 'generalclaim_id', ''),
('sim_hr_generalclaim', 'employee_id=''asda(14)''generalclaim_date=''2010-08-12''generalclaim_docno=''''generalclaim_remark=''''period_id=''2010(2)''created=''10/07/30 09:07:18''createdby=''admin(1)''updated=''10/07/30 09:07:18''updatedby=''admin(1)''organization_id=''1', 'I', 1, '2010-07-30 09:07:18', 19, 'S', 'admin', 717, '::1', 'generalclaim_id', ''),
('sim_window', 'mid=''64''windowsetting=''''seqno=''10''description=''''parentwindows_id=''17''filename=''printemployeelist.php''isactive=''0''window_name=''Print Employee List''created=''2010-07-30 10:56:47''createdby=''1''updated=''2010-07-30 10:56:47''updatedby=''1''table_name=''', 'I', 0, '2010-07-30 10:56:47', 38, 'S', '', 718, '::1', 'window_id', 'Print Employee List'),
('sim_window', 'mid=''64''windowsetting=''''seqno=''10''description=''''parentwindows_id=''17''filename=''printpanelclinicvisitlist.php''isactive=''0''window_name=''Panel Clinic Visit''created=''2010-07-30 12:15:22''createdby=''1''updated=''2010-07-30 12:15:22''updatedby=''1''table_name=''', 'I', 0, '2010-07-30 12:15:22', 39, 'S', '', 719, '::1', 'window_id', 'Panel Clinic Visit'),
('sim_window', 'mid=''64''windowsetting=''''seqno=''10''description=''''parentwindows_id=''17''filename=''printapplyleave.php''isactive=''0''window_name=''Print Apply Leave List''created=''2010-07-30 12:29:50''createdby=''1''updated=''2010-07-30 12:29:50''updatedby=''1''table_name=''', 'I', 0, '2010-07-30 12:29:50', 40, 'S', '', 720, '::1', 'window_id', 'Print Apply Leave List'),
('sim_window', 'filename=''printapplyleavelist.php''', 'U', 0, '2010-07-30 12:30:39', 40, 'S', '', 721, '::1', 'window_id', 'Print Apply Leave List'),
('sim_hr_leave', 'leave_no=''asasd''', 'U', 1, '2010-07-30 12:31:28', 25, 'S', 'admin', 722, '::1', 'leave_id', 'asasd'),
('sim_window', 'mid=''64''windowsetting=''''seqno=''10''description=''''parentwindows_id=''17''filename=''printgeneralclaimlist.php''isactive=''0''window_name=''Print General Claim List''created=''2010-07-30 15:44:09''createdby=''1''updated=''2010-07-30 15:44:09''updatedby=''1''table_name=''', 'I', 0, '2010-07-30 15:44:09', 41, 'S', '', 723, '::1', 'window_id', 'Print General Claim List'),
('sim_window', 'mid=''64''windowsetting=''''seqno=''10''description=''''parentwindows_id=''17''filename=''printtravellingclaimlist.php''isactive=''0''window_name=''Print Travelling Claim List''created=''2010-07-30 15:59:36''createdby=''1''updated=''2010-07-30 15:59:36''updatedby=''1''table_name=''', 'I', 0, '2010-07-30 15:59:36', 42, 'S', '', 724, '::1', 'window_id', 'Print Travelling Claim List'),
('sim_window', 'mid=''64''windowsetting=''''seqno=''10''description=''''parentwindows_id=''17''filename=''printmedicalclaimlist.php''isactive=''0''window_name=''Print Medical Claim List''created=''2010-07-30 16:09:06''createdby=''1''updated=''2010-07-30 16:09:06''updatedby=''1''table_name=''', 'I', 0, '2010-07-30 16:09:06', 43, 'S', '', 725, '::1', 'window_id', 'Print Medical Claim List'),
('sim_window', 'mid=''64''windowsetting=''''seqno=''10''description=''''parentwindows_id=''17''filename=''printovertimeclaimlist.php''isactive=''0''window_name=''Print Overtime Claim List''created=''2010-07-30 16:09:30''createdby=''1''updated=''2010-07-30 16:09:30''updatedby=''1''table_name=''', 'I', 0, '2010-07-30 16:09:30', 44, 'S', '', 726, '::1', 'window_id', 'Print Overtime Claim List'),
('sim_window', 'mid=''64''windowsetting=''''seqno=''10''description=''''parentwindows_id=''15''filename=''printadjustmentleavelist.php''isactive=''0''window_name=''Print Adjustment Leave List''created=''2010-07-30 16:29:17''createdby=''1''updated=''2010-07-30 16:29:17''updatedby=''1''table_name=''', 'I', 0, '2010-07-30 16:29:17', 45, 'S', '', 727, '::1', 'window_id', 'Print Adjustment Leave List'),
('sim_window', 'parentwindows_id=''17''', 'U', 0, '2010-07-30 16:29:29', 45, 'S', '', 728, '::1', 'window_id', 'Print Adjustment Leave List'),
('sim_hr_leaveadjustmentline', 'leaveadjustmentline_totalday=''3''', 'U', 1, '2010-07-30 20:01:43', 105, 'S', 'admin', 729, '::1', 'leaveadjustmentline_id', ''),
('sim_hr_leaveadjustmentline', 'leaveadjustmentline_totalday=''6''', 'U', 1, '2010-07-30 20:02:00', 106, 'S', 'admin', 730, '::1', 'leaveadjustmentline_id', ''),
('sim_hr_leaveadjustment', 'issubmit=''1''', 'U', 1, '2010-07-30 20:02:26', 2, 'S', 'admin', 731, '::1', 'leaveadjustment_id', '2'),
('sim_workflowtransaction', 'workflowtransaction_datetime=''10/07/30 20:02:26''target_groupid=''1''target_uid=''0''targetparameter_name=''''workflowstatus_id=''1''workflow_id=''8''tablename=''sim_hr_leaveadjustment''primarykey_name=''leaveadjustment_id''primarykey_value=''2''hyperlink=''''title_description=''''created=''10/07/30 20:02:26''list_parameter=''''workflowtransaction_description=''''workflowtransaction_feedback=''''iscomplete=''0''createdby=''1''email_list=''''sms_list=''''email_body=''''sms_body=''''person_id=''14''issubmit=''1', 'I', 1, '2010-07-30 20:02:26', 45, 'S', 'admin', 732, '::1', 'workflowtransaction_id', 'sim_hr_leaveadjustment'),
('sim_workflowtransactionhistory', 'workflowtransaction_id=''45''workflowstatus_id=''1''workflowtransaction_datetime=''10/07/30 20:02:26''uid=''1''workflowtransactionhistory_description=''', 'I', 1, '2010-07-30 20:02:26', 0, 'S', 'admin', 733, '::1', 'workflowtransactionhistory_id', ''),
('sim_hr_employeegroup', 'employeegroup_no=''DS''employeegroup_name=''WE''islecturer=''1''isovertime=''1''isparttime=''1''isactive=''1''defaultlevel=''10''created=''2010-08-01 16:54:12''createdby=''1''updated=''2010-08-01 16:54:12''updatedby=''1''organization_id=''1''description=''', 'I', 1, '2010-08-01 16:54:12', 16, 'S', 'admin', 734, '::1', 'employeegroup_id', 'DS'),
('sim_hr_employeegroup', 'employeegroup_name=''WEDS''', 'U', 1, '2010-08-01 16:54:18', 16, 'S', 'admin', 735, '::1', 'employeegroup_id', 'DS'),
('sim_hr_employeegroup', 'islecturer=''0'',<br/>isovertime=''0'',<br/>isparttime=''0'',<br/>isactive=''0''', 'U', 1, '2010-08-01 16:54:23', 16, 'S', 'admin', 736, '::1', 'employeegroup_id', 'DS'),
('sim_hr_employeegroup', 'islecturer=''1'',<br/>isovertime=''1'',<br/>isparttime=''1'',<br/>isactive=''1''', 'U', 1, '2010-08-01 16:54:28', 16, 'S', 'admin', 737, '::1', 'employeegroup_id', 'DS'),
('sim_hr_attachmentline', 'attachmentline_name=''qw''attachmentline_file=''1280654246_19.jpeg''attachmentline_remarks='' ''employee_id=''19''created=''2010-08-01 17:17:26''createdby=''1''updated=''2010-08-01 17:17:26''updatedby=''1', 'I', 1, '2010-08-01 17:17:26', 9, 'S', 'admin', 738, '::1', 'attachmentline_id', 'qw'),
('sim_hr_disciplineline', 'disciplineline_date=''1900-01-01''disciplinetype_id=''15''employee_id=''19''disciplineline_name=''3''disciplineline_remarks=''4''created=''2010-08-01 17:31:04''createdby=''1''updated=''2010-08-01 17:31:04''updatedby=''1', 'I', 1, '2010-08-01 17:31:04', 15, 'S', 'admin', 739, '127.0.0.1', 'disciplinetype_id', '3'),
('sim_hr_disciplineline', 'disciplineline_date=''1900-01-01''disciplinetype_id=''14''employee_id=''19''disciplineline_name=''1''disciplineline_remarks=''2''created=''2010-08-01 17:31:04''createdby=''1''updated=''2010-08-01 17:31:04''updatedby=''1', 'I', 1, '2010-08-01 17:31:04', 15, 'S', 'admin', 740, '127.0.0.1', 'disciplinetype_id', '1'),
('sim_hr_disciplineline', 'disciplineline_name=''35'',<br/>disciplineline_remarks=''46''', 'U', 1, '2010-08-01 17:31:17', 1, 'S', 'admin', 741, '127.0.0.1', 'disciplineline_id', '35'),
('sim_hr_disciplineline', 'disciplineline_name=''17'',<br/>disciplineline_remarks=''28''', 'U', 1, '2010-08-01 17:31:17', 2, 'S', 'admin', 742, '127.0.0.1', 'disciplineline_id', '17'),
('sim_hr_disciplineline', 'Record deleted permanentl', 'E', 1, '2010-08-01 17:31:23', 2, 'S', 'admin', 743, '127.0.0.1', 'disciplineline_id', '17'),
('sim_hr_disciplineline', 'Record deleted permanentl', 'E', 1, '2010-08-01 17:31:26', 1, 'S', 'admin', 744, '127.0.0.1', 'disciplineline_id', '35'),
('sim_hr_employeegroup', 'employeegroup_name=''Other (Full time)1'',<br/>description=''55''', 'U', 1, '2010-08-01 17:32:38', 14, 'S', 'admin', 745, '127.0.0.1', 'employeegroup_id', 'OF'),
('sim_hr_employeegroup', 'employeegroup_name=''Lecturer (Fulltime)2'',<br/>description=''33''', 'U', 1, '2010-08-01 17:32:38', 12, 'S', 'admin', 746, '127.0.0.1', 'employeegroup_id', 'LFS'),
('sim_hr_employeegroup', 'employeegroup_name=''WEDS3'',<br/>description=''11''', 'U', 1, '2010-08-01 17:32:38', 16, 'S', 'admin', 747, '127.0.0.1', 'employeegroup_id', 'DS'),
('sim_hr_employeegroup', 'description=''22''', 'U', 1, '2010-08-01 17:32:38', 11, 'S', 'admin', 748, '127.0.0.1', 'employeegroup_id', 'DF'),
('sim_hr_employeegroup', 'description=''44''', 'U', 1, '2010-08-01 17:32:38', 10, 'S', 'admin', 749, '127.0.0.1', 'employeegroup_id', 'LP'),
('sim_hr_employeegroup', 'islecturer=''1'',<br/>isovertime=''1'',<br/>isparttime=''0'',<br/>isactive=''1''', 'U', 1, '2010-08-01 17:32:48', 10, 'S', 'admin', 750, '127.0.0.1', 'employeegroup_id', 'LP'),
('sim_hr_employeegroup', 'employeegroup_name=''Lecturer (Fulltime)''', 'U', 1, '2010-08-01 17:32:55', 12, 'S', 'admin', 751, '127.0.0.1', 'employeegroup_id', 'LFS'),
('sim_hr_employeegroup', 'employeegroup_name=''Other (Full time)''', 'U', 1, '2010-08-01 17:32:56', 14, 'S', 'admin', 752, '127.0.0.1', 'employeegroup_id', 'OF'),
('sim_hr_employeegroup', 'employeegroup_no=''RE''employeegroup_name=''ER''islecturer=''1''isovertime=''1''isparttime=''1''isactive=''1''defaultlevel=''10''created=''2010-08-01 17:33:11''createdby=''1''updated=''2010-08-01 17:33:11''updatedby=''1''organization_id=''1''description=''ee', 'I', 1, '2010-08-01 17:33:11', 17, 'S', 'admin', 753, '127.0.0.1', 'employeegroup_id', 'RE'),
('sim_hr_department', 'department_no=''qw''department_name=''das''defaultlevel=''10''description=''''department_parent=''0''isactive=''1''created=''2010-08-01 17:34:41''createdby=''1''updated=''2010-08-01 17:34:41''updatedby=''1''organization_id=''1''department_head=''0', 'I', 1, '2010-08-01 17:34:41', 35, 'S', 'admin', 754, '127.0.0.1', 'department_id', 'das'),
('sim_hr_department', 'department_no=''dass''department_name=''aa''defaultlevel=''10''description=''''department_parent=''0''isactive=''1''created=''2010-08-01 17:34:51''createdby=''1''updated=''2010-08-01 17:34:51''updatedby=''1''organization_id=''1''department_head=''0', 'I', 1, '2010-08-01 17:34:51', 36, 'S', 'admin', 755, '127.0.0.1', 'department_id', 'aa'),
('sim_hr_jobposition', 'jobposition_no=''12Sd1'',<br/>jobposition_name=''Kaunselors1'',<br/>isactive=''0'',<br/>defaultlevel=''101'',<br/>description=''22''', 'U', 1, '2010-08-01 17:35:28', 53, 'S', 'admin', 756, '127.0.0.1', 'jobposition_id', '12Sd1'),
('sim_hr_jobposition', 'jobposition_no=''21'',<br/>jobposition_name=''Pensyarah1'',<br/>isactive=''0'',<br/>defaultlevel=''101'',<br/>description=''33''', 'U', 1, '2010-08-01 17:35:28', 52, 'S', 'admin', 757, '127.0.0.1', 'jobposition_id', '21'),
('sim_hr_jobposition', 'jobposition_no=''31'',<br/>jobposition_name=''Pembantu Pustakawan1'',<br/>isactive=''0'',<br/>defaultlevel=''101'',<br/>description=''44''', 'U', 1, '2010-08-01 17:35:28', 56, 'S', 'admin', 758, '127.0.0.1', 'jobposition_id', '31'),
('sim_hr_jobposition', 'jobposition_no=''Wd1'',<br/>jobposition_name=''WWW1'',<br/>isactive=''0'',<br/>defaultlevel=''101'',<br/>description=''55''', 'U', 1, '2010-08-01 17:35:28', 58, 'S', 'admin', 759, '127.0.0.1', 'jobposition_id', 'Wd1'),
('sim_hr_leavetype', 'isvalidate=''1''', 'U', 1, '2010-08-01 17:35:59', 8, 'S', 'admin', 760, '127.0.0.1', 'leavetype_id', 'Annul Leave'),
('sim_hr_leavetype', 'isvalidate=''1''', 'U', 1, '2010-08-01 17:35:59', 9, 'S', 'admin', 761, '127.0.0.1', 'leavetype_id', 'Mecdical Leave'),
('sim_hr_leavetype', 'isvalidate=''1''', 'U', 1, '2010-08-01 17:35:59', 10, 'S', 'admin', 762, '127.0.0.1', 'leavetype_id', 'Birthday Leave'),
('sim_hr_jobposition', 'isactive=''1''', 'U', 1, '2010-08-01 17:39:14', 53, 'S', 'admin', 763, '127.0.0.1', 'jobposition_id', '12Sd1'),
('sim_hr_jobposition', 'isactive=''1''', 'U', 1, '2010-08-01 17:39:14', 52, 'S', 'admin', 764, '127.0.0.1', 'jobposition_id', '21'),
('sim_hr_jobposition', 'isactive=''1''', 'U', 1, '2010-08-01 17:39:14', 56, 'S', 'admin', 765, '127.0.0.1', 'jobposition_id', '31'),
('sim_hr_jobposition', 'isactive=''1''', 'U', 1, '2010-08-01 17:39:14', 58, 'S', 'admin', 766, '127.0.0.1', 'jobposition_id', 'Wd1'),
('sim_hr_employee', 'marital_status=''2'',<br/>department_id=''23'',<br/>defaultlevel='''',<br/>organization_id=''''', 'U', 1, '2010-08-01 17:39:22', 19, 'S', 'admin', 767, '127.0.0.1', 'employee_id', 'K001'),
('sim_hr_generalclaim', 'employee_id=''KS Tan(19)''generalclaim_date=''2010-08-18''generalclaim_docno=''''generalclaim_remark=''''period_id=''2010(2)''created=''10/08/01 17:39:42''createdby=''admin(1)''updated=''10/08/01 17:39:42''updatedby=''admin(1)''organization_id=''1', 'I', 1, '2010-08-01 17:39:42', 20, 'S', 'admin', 768, '127.0.0.1', 'generalclaim_id', ''),
('sim_hr_generalclaim', 'issubmit=''''', 'U', 1, '2010-08-01 17:39:53', 20, 'S', 'admin', 769, '127.0.0.1', 'generalclaim_id', ''),
('sim_hr_generalclaimline', 'generalclaim_id=''20''generalclaimline_date=''1900-01-01''generalclaimline_details=''''generalclaimline_porpose=''''generalclaimline_billno=''''generalclaimline_amount=''022''remarks=''''generalclaimline_acccode=''''created=''2010-08-01 17:39:53''createdby=''1''updated=''2010-08-01 17:39:53''updatedby=''1', 'I', 1, '2010-08-01 17:39:53', 25, 'S', 'admin', 770, '127.0.0.1', 'generalclaimline_id', ''),
('sim_hr_generalclaimline', 'generalclaim_id=''20''generalclaimline_date=''1900-01-01''generalclaimline_details=''''generalclaimline_porpose=''''generalclaimline_billno=''''generalclaimline_amount=''011''remarks=''''generalclaimline_acccode=''''created=''2010-08-01 17:39:53''createdby=''1''updated=''2010-08-01 17:39:53''updatedby=''1', 'I', 1, '2010-08-01 17:39:53', 26, 'S', 'admin', 771, '127.0.0.1', 'generalclaimline_id', ''),
('sim_hr_generalclaim', 'employee_id=''19KS Tan'',<br/>issubmit=''1''', 'U', 1, '2010-08-01 17:39:58', 20, 'S', 'admin', 772, '127.0.0.1', 'generalclaim_id', ''),
('sim_workflowtransaction', 'workflowtransaction_datetime=''10/08/01 17:39:58''target_groupid=''1''target_uid=''0''targetparameter_name=''10''workflowstatus_id=''1''workflow_id=''4''tablename=''sim_hr_generalclaim''primarykey_name=''generalclaim_id''primarykey_value=''20''hyperlink=''../hr/generalclaim.php''title_description=''''created=''10/08/01 17:39:58''list_parameter=''''workflowtransaction_description=''Ok done''workflowtransaction_feedback=''''iscomplete=''0''createdby=''1''email_list=''1,10''sms_list=''1,10''email_body=''''sms_body=''''person_id=''19''issubmit=''1', 'I', 1, '2010-08-01 17:39:58', 46, 'S', 'admin', 773, '127.0.0.1', 'workflowtransaction_id', 'sim_hr_generalclaim'),
('sim_workflowtransactionhistory', 'workflowtransaction_id=''46''workflowstatus_id=''1''workflowtransaction_datetime=''10/08/01 17:39:58''uid=''1''workflowtransactionhistory_description=''', 'I', 1, '2010-08-01 17:39:58', 0, 'S', 'admin', 774, '127.0.0.1', 'workflowtransactionhistory_id', ''),
('sim_hr_travellingclaim', 'employee_id=''KS Tan(19)''travellingclaim_date=''2010-08-16''travellingclaim_docno=''''travellingclaim_remark=''''travellingclaim_transport=''weq''period_id=''2010(2)''created=''10/08/01 17:41:10''createdby=''admin(1)''updated=''10/08/01 17:41:10''updatedby=''admin(1)''organization_id=''1', 'I', 1, '2010-08-01 17:41:10', 9, 'S', 'admin', 775, '127.0.0.1', 'travellingclaim_id', ''),
('sim_hr_travellingclaim', 'issubmit='''',<br/>=''0''', 'U', 1, '2010-08-01 17:41:19', 9, 'S', 'admin', 776, '127.0.0.1', 'travellingclaim_id', ''),
('sim_hr_travellingclaimline', 'travellingclaim_id=''9''travellingclaimline_date=''1900-01-01''travellingclaimline_from=''''travellingclaimline_to=''''travellingclaimline_distance=''''travellingclaimline_purpose=''''travellingclaimline_amount=''012''travellingclaimline_receipt=''''remarks=''''travellingclaimline_acccode=''''created=''2010-08-01 17:41:19''createdby=''1''updated=''2010-08-01 17:41:19''updatedby=''1', 'I', 1, '2010-08-01 17:41:19', 9, 'S', 'admin', 777, '127.0.0.1', 'travellingclaim_id', ''),
('sim_hr_travellingclaim', 'issubmit=''1''', 'U', 1, '2010-08-01 17:41:25', 9, 'S', 'admin', 778, '127.0.0.1', 'travellingclaim_id', ''),
('sim_workflowtransaction', 'workflowtransaction_datetime=''10/08/01 17:41:25''target_groupid=''1''target_uid=''0''targetparameter_name=''10''workflowstatus_id=''1''workflow_id=''11''tablename=''sim_hr_travellingclaim''primarykey_name=''travellingclaim_id''primarykey_value=''9''hyperlink=''../hr/travellingclaim.php''title_description=''''created=''10/08/01 17:41:25''list_parameter=''''workflowtransaction_description=''''workflowtransaction_feedback=''''iscomplete=''0''createdby=''1''email_list=''1,10''sms_list=''1,10''email_body=''''sms_body=''''person_id=''19''issubmit=''1', 'I', 1, '2010-08-01 17:41:25', 47, 'S', 'admin', 779, '127.0.0.1', 'workflowtransaction_id', 'sim_hr_travellingclaim'),
('sim_workflowtransactionhistory', 'workflowtransaction_id=''47''workflowstatus_id=''1''workflowtransaction_datetime=''10/08/01 17:41:25''uid=''1''workflowtransactionhistory_description=''', 'I', 1, '2010-08-01 17:41:26', 0, 'S', 'admin', 780, '127.0.0.1', 'workflowtransactionhistory_id', ''),
('sim_hr_generalclaim', 'employee_id=''KS Tan(19)''generalclaim_date=''2010-08-17''generalclaim_docno=''''generalclaim_remark=''''period_id=''2010(2)''created=''10/08/01 18:02:46''createdby=''admin(1)''updated=''10/08/01 18:02:46''updatedby=''admin(1)''organization_id=''1', 'I', 1, '2010-08-01 18:02:46', 21, 'S', 'admin', 781, '127.0.0.1', 'generalclaim_id', ''),
('sim_hr_generalclaim', 'employee_id=''19KS Tan'',<br/>issubmit=''1''', 'U', 1, '2010-08-01 18:02:50', 21, 'S', 'admin', 782, '127.0.0.1', 'generalclaim_id', ''),
('sim_workflowtransaction', 'workflowtransaction_datetime=''10/08/01 18:02:50''target_groupid=''1''target_uid=''0''targetparameter_name=''10''workflowstatus_id=''1''workflow_id=''4''tablename=''sim_hr_generalclaim''primarykey_name=''generalclaim_id''primarykey_value=''21''hyperlink=''../hr/generalclaim.php''title_description=''''created=''10/08/01 18:02:50''list_parameter=''''workflowtransaction_description=''Ok done''workflowtransaction_feedback=''''iscomplete=''0''createdby=''1''email_list=''1,10''sms_list=''1,10''email_body=''''sms_body=''''person_id=''19''issubmit=''1', 'I', 1, '2010-08-01 18:02:50', 48, 'S', 'admin', 783, '127.0.0.1', 'workflowtransaction_id', 'sim_hr_generalclaim'),
('sim_workflowtransactionhistory', 'workflowtransaction_id=''48''workflowstatus_id=''1''workflowtransaction_datetime=''10/08/01 18:02:50''uid=''1''workflowtransactionhistory_description=''', 'I', 1, '2010-08-01 18:02:50', 0, 'S', 'admin', 784, '127.0.0.1', 'workflowtransactionhistory_id', ''),
('sim_hr_leave', 'leave_no=''''leave_date=''2010-08-01''employee_id=''KS Tan(19)''leave_fromdate=''2010-08-17''leave_todate=''2010-08-18''leave_day=''2''time_from=''08:00:00''time_to=''08:00:00''total_hours=''00:00:00''leave_address=''''leave_telno=''''leavetype_id=''Mecdical Leave(9)''lecturer_remarks=''''description=''''created=''10/08/01 21:43:43''createdby=''1''updated=''10/08/01 21:43:43''updatedby=''1''organization_id=''1''panelclinic_id=''0''table_type=''L', 'I', 1, '2010-08-01 21:43:43', 28, 'S', 'admin', 785, '::1', 'leave_id', ''),
('sim_hr_leave', 'issubmit=''1''', 'U', 1, '2010-08-01 21:43:47', 28, 'S', 'admin', 786, '::1', 'leave_id', ''),
('sim_workflowtransaction', 'workflowtransaction_datetime=''10/08/01 21:43:47''target_groupid=''1''target_uid=''0''targetparameter_name=''10''workflowstatus_id=''1''workflow_id=''1''tablename=''sim_hr_leave''primarykey_name=''leave_id''primarykey_value=''28''hyperlink=''../hr/leave.php''title_description=''''created=''10/08/01 21:43:47''list_parameter=''''workflowtransaction_description=''Leave Date : 2010-08-17-2010-08-18\nReasons : \n''workflowtransaction_feedback=''''iscomplete=''0''createdby=''1''email_list=''1,10''sms_list=''1,10''email_body=''''sms_body=''''person_id=''19''issubmit=''1', 'I', 1, '2010-08-01 21:43:47', 49, 'S', 'admin', 787, '::1', 'workflowtransaction_id', 'sim_hr_leave'),
('sim_workflowtransactionhistory', 'workflowtransaction_id=''49''workflowstatus_id=''1''workflowtransaction_datetime=''10/08/01 21:43:47''uid=''1''workflowtransactionhistory_description=''', 'I', 1, '2010-08-01 21:43:47', 0, 'S', 'admin', 788, '::1', 'workflowtransactionhistory_id', ''),
('sim_workflowtransaction', 'workflowtransaction_datetime=''10/08/01 21:43:51''target_groupid=''1''target_uid=''0''targetparameter_name=''''workflowstatus_id=''2''workflow_id=''1''tablename=''sim_hr_leave''primarykey_name=''leave_id''primarykey_value=''28''hyperlink=''../hr/leave.php''title_description=''''created=''10/08/01 21:43:51''list_parameter=''''workflowtransaction_description=''''workflowtransaction_feedback=''''iscomplete=''0''createdby=''1''email_list=''''sms_list=''''email_body=''''sms_body=''''person_id=''19''issubmit=''1', 'I', 1, '2010-08-01 21:43:51', 50, 'S', 'admin', 789, '::1', 'workflowtransaction_id', 'sim_hr_leave'),
('sim_workflowtransactionhistory', 'workflowtransaction_id=''50''workflowstatus_id=''2''workflowtransaction_datetime=''10/08/01 21:43:51''uid=''1''workflowtransactionhistory_description=''', 'I', 1, '2010-08-01 21:43:51', 0, 'S', 'admin', 790, '::1', 'workflowtransactionhistory_id', ''),
('sim_hr_generalclaim', 'employee_id=''KS Tan(19)''generalclaim_date=''2010-08-23''generalclaim_docno=''''generalclaim_remark=''''period_id=''2010(2)''created=''10/08/01 21:44:07''createdby=''admin(1)''updated=''10/08/01 21:44:07''updatedby=''admin(1)''organization_id=''1', 'I', 1, '2010-08-01 21:44:07', 22, 'S', 'admin', 791, '::1', 'generalclaim_id', ''),
('sim_hr_generalclaim', 'employee_id=''19KS Tan'',<br/>issubmit=''1''', 'U', 1, '2010-08-01 21:44:13', 22, 'S', 'admin', 792, '::1', 'generalclaim_id', ''),
('sim_workflowtransaction', 'workflowtransaction_datetime=''10/08/01 21:44:13''target_groupid=''1''target_uid=''0''targetparameter_name=''10''workflowstatus_id=''1''workflow_id=''4''tablename=''sim_hr_generalclaim''primarykey_name=''generalclaim_id''primarykey_value=''22''hyperlink=''../hr/generalclaim.php''title_description=''''created=''10/08/01 21:44:13''list_parameter=''''workflowtransaction_description=''Ok done''workflowtransaction_feedback=''''iscomplete=''0''createdby=''1''email_list=''1,10''sms_list=''1,10''email_body=''''sms_body=''''person_id=''19''issubmit=''1', 'I', 1, '2010-08-01 21:44:13', 51, 'S', 'admin', 793, '::1', 'workflowtransaction_id', 'sim_hr_generalclaim'),
('sim_workflowtransactionhistory', 'workflowtransaction_id=''51''workflowstatus_id=''1''workflowtransaction_datetime=''10/08/01 21:44:13''uid=''1''workflowtransactionhistory_description=''', 'I', 1, '2010-08-01 21:44:13', 0, 'S', 'admin', 794, '::1', 'workflowtransactionhistory_id', ''),
('sim_hr_generalclaim', 'employee_id=''KS Tan(19)''generalclaim_date=''2010-08-24''generalclaim_docno=''''generalclaim_remark=''''period_id=''2010(2)''created=''10/08/01 21:57:05''createdby=''admin(1)''updated=''10/08/01 21:57:05''updatedby=''admin(1)''organization_id=''1', 'I', 1, '2010-08-01 21:57:06', 23, 'S', 'admin', 795, '::1', 'generalclaim_id', ''),
('sim_hr_generalclaim', 'employee_id=''19KS Tan'',<br/>issubmit=''1''', 'U', 1, '2010-08-01 21:57:09', 23, 'S', 'admin', 796, '::1', 'generalclaim_id', ''),
('sim_workflowtransaction', 'workflowtransaction_datetime=''10/08/01 21:57:09''target_groupid=''1''target_uid=''0''targetparameter_name=''10''workflowstatus_id=''1''workflow_id=''4''tablename=''sim_hr_generalclaim''primarykey_name=''generalclaim_id''primarykey_value=''23''hyperlink=''../hr/generalclaim.php''title_description=''''created=''10/08/01 21:57:09''list_parameter=''''workflowtransaction_description=''Ok done''workflowtransaction_feedback=''''iscomplete=''0''createdby=''1''email_list=''1,10''sms_list=''1,10''email_body=''''sms_body=''''person_id=''19''issubmit=''1', 'I', 1, '2010-08-01 21:57:09', 52, 'S', 'admin', 797, '::1', 'workflowtransaction_id', 'sim_hr_generalclaim'),
('sim_workflowtransactionhistory', 'workflowtransaction_id=''52''workflowstatus_id=''1''workflowtransaction_datetime=''10/08/01 21:57:09''uid=''1''workflowtransactionhistory_description=''', 'I', 1, '2010-08-01 21:57:09', 0, 'S', 'admin', 798, '::1', 'workflowtransactionhistory_id', ''),
('sim_hr_generalclaim', 'employee_id=''KS Tan(19)''generalclaim_date=''2010-08-26''generalclaim_docno=''''generalclaim_remark=''''period_id=''2010(2)''created=''10/08/01 21:59:28''createdby=''admin(1)''updated=''10/08/01 21:59:28''updatedby=''admin(1)''organization_id=''1', 'I', 1, '2010-08-01 21:59:28', 24, 'S', 'admin', 799, '::1', 'generalclaim_id', ''),
('sim_hr_generalclaim', 'employee_id=''19KS Tan'',<br/>issubmit=''1''', 'U', 1, '2010-08-01 21:59:38', 24, 'S', 'admin', 800, '::1', 'generalclaim_id', ''),
('sim_workflowtransaction', 'workflowtransaction_datetime=''10/08/01 21:59:38''target_groupid=''1''target_uid=''0''targetparameter_name=''10''workflowstatus_id=''1''workflow_id=''4''tablename=''sim_hr_generalclaim''primarykey_name=''generalclaim_id''primarykey_value=''24''hyperlink=''../hr/generalclaim.php''title_description=''''created=''10/08/01 21:59:38''list_parameter=''''workflowtransaction_description=''Ok done''workflowtransaction_feedback=''''iscomplete=''0''createdby=''1''email_list=''1,10''sms_list=''1,10''email_body=''''sms_body=''''person_id=''19''issubmit=''1', 'I', 1, '2010-08-01 21:59:38', 53, 'S', 'admin', 801, '::1', 'workflowtransaction_id', 'sim_hr_generalclaim'),
('sim_workflowtransactionhistory', 'workflowtransaction_id=''53''workflowstatus_id=''1''workflowtransaction_datetime=''10/08/01 21:59:38''uid=''1''workflowtransactionhistory_description=''', 'I', 1, '2010-08-01 21:59:38', 0, 'S', 'admin', 802, '::1', 'workflowtransactionhistory_id', ''),
('sim_workflowtransaction', 'workflowtransaction_datetime=''10/08/01 21:59:47''target_groupid=''1''target_uid=''0''targetparameter_name=''''workflowstatus_id=''2''workflow_id=''4''tablename=''sim_hr_generalclaim''primarykey_name=''generalclaim_id''primarykey_value=''24''hyperlink=''../hr/generalclaim.php''title_description=''''created=''10/08/01 21:59:47''list_parameter=''''workflowtransaction_description=''Claim for {claim_details}''workflowtransaction_feedback=''''iscomplete=''1''createdby=''1''email_list=''''sms_list=''''email_body=''''sms_body=''''person_id=''19''issubmit=''1', 'I', 1, '2010-08-01 21:59:47', 54, 'S', 'admin', 803, '::1', 'workflowtransaction_id', 'sim_hr_generalclaim'),
('sim_workflowtransactionhistory', 'workflowtransaction_id=''54''workflowstatus_id=''2''workflowtransaction_datetime=''10/08/01 21:59:47''uid=''1''workflowtransactionhistory_description=''', 'I', 1, '2010-08-01 21:59:47', 0, 'S', 'admin', 804, '::1', 'workflowtransactionhistory_id', ''),
('sim_hr_generalclaim', 'employee_id=''KS Tan(19)''generalclaim_date=''2010-08-16''generalclaim_docno=''''generalclaim_remark=''''period_id=''2010(2)''created=''10/08/01 22:00:20''createdby=''admin(1)''updated=''10/08/01 22:00:20''updatedby=''admin(1)''organization_id=''1', 'I', 1, '2010-08-01 22:00:20', 25, 'S', 'admin', 805, '::1', 'generalclaim_id', ''),
('sim_hr_generalclaim', 'issubmit=''''', 'U', 1, '2010-08-01 22:00:27', 25, 'S', 'admin', 806, '::1', 'generalclaim_id', ''),
('sim_hr_generalclaimline', 'generalclaim_id=''25''generalclaimline_date=''1900-01-01''generalclaimline_details=''''generalclaimline_porpose=''''generalclaimline_billno=''''generalclaimline_amount=''0123''remarks=''''generalclaimline_acccode=''''created=''2010-08-01 22:00:28''createdby=''1''updated=''2010-08-01 22:00:28''updatedby=''1', 'I', 1, '2010-08-01 22:00:28', 27, 'S', 'admin', 807, '::1', 'generalclaimline_id', ''),
('sim_hr_generalclaim', 'employee_id=''19KS Tan'',<br/>issubmit=''1''', 'U', 1, '2010-08-01 22:00:32', 25, 'S', 'admin', 808, '::1', 'generalclaim_id', ''),
('sim_workflowtransaction', 'workflowtransaction_datetime=''10/08/01 22:00:32''target_groupid=''1''target_uid=''0''targetparameter_name=''10''workflowstatus_id=''1''workflow_id=''4''tablename=''sim_hr_generalclaim''primarykey_name=''generalclaim_id''primarykey_value=''25''hyperlink=''../hr/generalclaim.php''title_description=''''created=''10/08/01 22:00:32''list_parameter=''''workflowtransaction_description=''Ok done''workflowtransaction_feedback=''''iscomplete=''0''createdby=''1''email_list=''1,10''sms_list=''1,10''email_body=''''sms_body=''''person_id=''19''issubmit=''1', 'I', 1, '2010-08-01 22:00:32', 55, 'S', 'admin', 809, '::1', 'workflowtransaction_id', 'sim_hr_generalclaim'),
('sim_workflowtransactionhistory', 'workflowtransaction_id=''55''workflowstatus_id=''1''workflowtransaction_datetime=''10/08/01 22:00:32''uid=''1''workflowtransactionhistory_description=''', 'I', 1, '2010-08-01 22:00:32', 0, 'S', 'admin', 810, '::1', 'workflowtransactionhistory_id', ''),
('sim_hr_medicalclaim', 'employee_id=''KS Tan(19)''medicalclaim_date=''2010-08-24''medicalclaim_clinic=''ass''medicalclaim_docno=''das''medicalclaim_amount=''1231''medicalclaim_treatment=''sds''medicalclaim_remark=''''period_id=''2010(2)''created=''10/08/01 22:13:37''createdby=''admin(1)''updated=''10/08/01 22:13:37''updatedby=''admin(1)''organization_id=''1', 'I', 1, '2010-08-01 22:13:37', 8, 'S', 'admin', 811, '::1', 'medicalclaim_id', 'das'),
('sim_hr_medicalclaim', 'issubmit=''1''', 'U', 1, '2010-08-01 22:13:42', 8, 'S', 'admin', 812, '::1', 'medicalclaim_id', 'das'),
('sim_workflowtransaction', 'workflowtransaction_datetime=''10/08/01 22:13:42''target_groupid=''1''target_uid=''0''targetparameter_name=''10''workflowstatus_id=''1''workflow_id=''10''tablename=''sim_hr_medicalclaim''primarykey_name=''medicalclaim_id''primarykey_value=''8''hyperlink=''''title_description=''''created=''10/08/01 22:13:42''list_parameter=''''workflowtransaction_description=''''workflowtransaction_feedback=''''iscomplete=''0''createdby=''1''email_list=''1,10''sms_list=''1,10''email_body=''''sms_body=''''person_id=''19''issubmit=''1', 'I', 1, '2010-08-01 22:13:42', 56, 'S', 'admin', 813, '::1', 'workflowtransaction_id', 'sim_hr_medicalclaim'),
('sim_workflowtransactionhistory', 'workflowtransaction_id=''56''workflowstatus_id=''1''workflowtransaction_datetime=''10/08/01 22:13:42''uid=''1''workflowtransactionhistory_description=''', 'I', 1, '2010-08-01 22:13:42', 0, 'S', 'admin', 814, '::1', 'workflowtransactionhistory_id', ''),
('sim_workflowtransaction', 'workflowtransaction_datetime=''10/08/01 22:13:46''target_groupid=''1''target_uid=''0''targetparameter_name=''''workflowstatus_id=''2''workflow_id=''10''tablename=''sim_hr_medicalclaim''primarykey_name=''medicalclaim_id''primarykey_value=''8''hyperlink=''../hr/medicalclaim.php''title_description=''''created=''10/08/01 22:13:46''list_parameter=''''workflowtransaction_description=''''workflowtransaction_feedback=''''iscomplete=''1''createdby=''1''email_list=''''sms_list=''''email_body=''''sms_body=''''person_id=''19''issubmit=''1', 'I', 1, '2010-08-01 22:13:46', 57, 'S', 'admin', 815, '::1', 'workflowtransaction_id', 'sim_hr_medicalclaim'),
('sim_workflowtransactionhistory', 'workflowtransaction_id=''57''workflowstatus_id=''2''workflowtransaction_datetime=''10/08/01 22:13:46''uid=''1''workflowtransactionhistory_description=''', 'I', 1, '2010-08-01 22:13:46', 0, 'S', 'admin', 816, '::1', 'workflowtransactionhistory_id', ''),
('sim_hr_generalclaim', 'employee_id=''A-Tester(16)''generalclaim_date=''2010-08-04''generalclaim_docno=''''generalclaim_remark=''''period_id=''2010(2)''created=''10/08/02 09:26:36''createdby=''admin(1)''updated=''10/08/02 09:26:36''updatedby=''admin(1)''organization_id=''1', 'I', 1, '2010-08-02 09:26:36', 26, 'S', 'admin', 817, '::1', 'generalclaim_id', ''),
('sim_hr_generalclaim', 'issubmit=''''', 'U', 1, '2010-08-02 09:27:11', 26, 'S', 'admin', 818, '::1', 'generalclaim_id', ''),
('sim_hr_generalclaimline', 'generalclaim_id=''26''generalclaimline_date=''1900-01-01''generalclaimline_details=''''generalclaimline_porpose=''''generalclaimline_billno=''''generalclaimline_amount=''0''remarks=''''generalclaimline_acccode=''''created=''2010-08-02 09:27:11''createdby=''1''updated=''2010-08-02 09:27:11''updatedby=''1', 'I', 1, '2010-08-02 09:27:11', 28, 'S', 'admin', 819, '::1', 'generalclaimline_id', ''),
('sim_hr_generalclaim', 'employee_id=''16A-Tester'',<br/>issubmit=''1''', 'U', 1, '2010-08-02 09:27:15', 26, 'S', 'admin', 820, '::1', 'generalclaim_id', ''),
('sim_workflowtransaction', 'workflowtransaction_datetime=''10/08/02 09:27:15''target_groupid=''1''target_uid=''0''targetparameter_name=''10''workflowstatus_id=''1''workflow_id=''4''tablename=''sim_hr_generalclaim''primarykey_name=''generalclaim_id''primarykey_value=''26''hyperlink=''../hr/generalclaim.php''title_description=''''created=''10/08/02 09:27:15''list_parameter=''''workflowtransaction_description=''Ok done''workflowtransaction_feedback=''''iscomplete=''0''createdby=''1''email_list=''1,10''sms_list=''1,10''email_body=''''sms_body=''''person_id=''16''issubmit=''1', 'I', 1, '2010-08-02 09:27:15', 58, 'S', 'admin', 821, '::1', 'workflowtransaction_id', 'sim_hr_generalclaim'),
('sim_workflowtransactionhistory', 'workflowtransaction_id=''58''workflowstatus_id=''1''workflowtransaction_datetime=''10/08/02 09:27:15''uid=''1''workflowtransactionhistory_description=''', 'I', 1, '2010-08-02 09:27:15', 0, 'S', 'admin', 822, '::1', 'workflowtransactionhistory_id', ''),
('sim_workflowtransaction', 'workflowtransaction_datetime=''10/08/02 09:27:22''target_groupid=''1''target_uid=''0''targetparameter_name=''''workflowstatus_id=''2''workflow_id=''4''tablename=''sim_hr_generalclaim''primarykey_name=''generalclaim_id''primarykey_value=''26''hyperlink=''../hr/generalclaim.php''title_description=''''created=''10/08/02 09:27:22''list_parameter=''''workflowtransaction_description=''Claim for {claim_details}''workflowtransaction_feedback=''''iscomplete=''1''createdby=''1''email_list=''''sms_list=''''email_body=''''sms_body=''''person_id=''16''issubmit=''1', 'I', 1, '2010-08-02 09:27:22', 59, 'S', 'admin', 823, '::1', 'workflowtransaction_id', 'sim_hr_generalclaim'),
('sim_workflowtransactionhistory', 'workflowtransaction_id=''59''workflowstatus_id=''2''workflowtransaction_datetime=''10/08/02 09:27:22''uid=''1''workflowtransactionhistory_description=''', 'I', 1, '2010-08-02 09:27:22', 0, 'S', 'admin', 824, '::1', 'workflowtransactionhistory_id', ''),
('sim_hr_generalclaim', 'employee_id=''KS Tan(19)''generalclaim_date=''2010-08-24''generalclaim_docno=''''generalclaim_remark=''''period_id=''2010(2)''created=''10/08/02 09:36:39''createdby=''admin(1)''updated=''10/08/02 09:36:39''updatedby=''admin(1)''organization_id=''1', 'I', 1, '2010-08-02 09:36:39', 27, 'S', 'admin', 825, '::1', 'generalclaim_id', ''),
('sim_hr_generalclaim', 'issubmit=''''', 'U', 1, '2010-08-02 09:38:35', 27, 'S', 'admin', 826, '::1', 'generalclaim_id', ''),
('sim_hr_generalclaim', 'issubmit=''''', 'U', 1, '2010-08-02 09:39:36', 27, 'S', 'admin', 827, '::1', 'generalclaim_id', ''),
('sim_hr_generalclaimline', 'generalclaim_id=''27''generalclaimline_date=''1900-01-01''generalclaimline_details=''''generalclaimline_porpose=''''generalclaimline_billno=''''generalclaimline_amount=''0123''remarks=''''generalclaimline_acccode=''''created=''2010-08-02 09:39:36''createdby=''1''updated=''2010-08-02 09:39:36''updatedby=''1', 'I', 1, '2010-08-02 09:39:36', 29, 'S', 'admin', 828, '::1', 'generalclaimline_id', ''),
('sim_hr_generalclaim', 'employee_id=''KS Tan(19)''generalclaim_date=''2010-08-17''generalclaim_docno=''''generalclaim_remark=''''period_id=''2010(2)''created=''10/08/02 09:41:44''createdby=''admin(1)''updated=''10/08/02 09:41:44''updatedby=''admin(1)''organization_id=''1', 'I', 1, '2010-08-02 09:41:44', 28, 'S', 'admin', 829, '::1', 'generalclaim_id', ''),
('sim_workflownode', 'target_uid='''',<br/>hyperlink=''../hr/medicalclaim.php''', 'U', 0, '2010-08-02 10:21:16', 25, 'S', '', 830, '127.0.0.1', 'workflownode_id', '10'),
('sim_workflownode', 'target_groupid=''1'',<br/>target_uid=''''', 'U', 0, '2010-08-02 10:22:22', 33, 'S', '', 831, '127.0.0.1', 'workflownode_id', '10'),
('sim_hr_employeegroup', 'isdeleted=''0''', 'U', 1, '2010-08-02 10:39:24', 15, 'S', 'admin', 832, '192.168.1.204', 'employeegroup_id', 'we'),
('sim_hr_trainingtype', 'trainingtype_name=''Update''isactive=''1''defaultlevel=''10''created=''2010-08-02 10:48:05''createdby=''1''updated=''2010-08-02 10:48:05''updatedby=''1''organization_id=''1''description=''', 'I', 1, '2010-08-02 10:48:05', 17, 'S', 'admin', 833, '192.168.1.204', 'trainingtype_id', 'Update'),
('sim_hr_overtimeclaim', 'employee_id=''KS Tan(19)''overtimeclaim_date=''2010-08-16''overtimeclaim_docno=''''overtimeclaim_remark=''''created=''10/08/02 11:08:13''createdby=''admin(1)''updated=''10/08/02 11:08:13''updatedby=''admin(1)''organization_id=''1', 'I', 1, '2010-08-02 11:08:13', 7, 'S', 'admin', 834, '127.0.0.1', 'overtimeclaim_id', ''),
('sim_hr_overtimeclaimline', 'overtimeclaim_id=''7''overtimeclaimline_date=''1900-01-01''overtimeclaimline_starttime=''00:00:00''overtimeclaimline_endtime=''00:00:00''overtimeclaimline_totalhour=''00:00:00''overtimeclaimline_purpose=''''overtimeclaimline_remark=''''created=''2010-08-02 11:08:19''createdby=''1''updated=''2010-08-02 11:08:19''updatedby=''1', 'I', 1, '2010-08-02 11:08:19', 4, 'S', 'admin', 835, '127.0.0.1', 'overtimeclaimline_id', ''),
('sim_hr_generalclaim', 'employee_id=''A-Tester(16)''generalclaim_date=''2010-08-03''generalclaim_docno=''''generalclaim_remark=''''period_id=''2010(2)''created=''10/08/02 11:08:58''createdby=''admin(1)''updated=''10/08/02 11:08:58''updatedby=''admin(1)''organization_id=''1', 'I', 1, '2010-08-02 11:08:58', 29, 'S', 'admin', 836, '192.168.1.204', 'generalclaim_id', ''),
('sim_hr_generalclaim', 'issubmit=''''', 'U', 1, '2010-08-02 11:09:10', 29, 'S', 'admin', 837, '192.168.1.204', 'generalclaim_id', ''),
('sim_hr_generalclaimline', 'generalclaim_id=''29''generalclaimline_date=''1900-01-01''generalclaimline_details=''sdfdsf''generalclaimline_porpose=''sdfsdf''generalclaimline_billno=''sdfsdf''generalclaimline_amount=''012''remarks=''''generalclaimline_acccode=''''created=''2010-08-02 11:09:10''createdby=''1''updated=''2010-08-02 11:09:10''updatedby=''1', 'I', 1, '2010-08-02 11:09:10', 30, 'S', 'admin', 838, '192.168.1.204', 'generalclaimline_id', 'sdfdsf'),
('sim_hr_generalclaim', 'employee_id=''KS Tan(19)''generalclaim_date=''2010-08-17''generalclaim_docno=''''generalclaim_remark=''''period_id=''2010(2)''created=''10/08/02 12:03:44''createdby=''admin(1)''updated=''10/08/02 12:03:44''updatedby=''admin(1)''organization_id=''1', 'I', 1, '2010-08-02 12:03:44', 30, 'S', 'admin', 839, '127.0.0.1', 'generalclaim_id', ''),
('sim_hr_generalclaim', 'issubmit=''''', 'U', 1, '2010-08-02 12:03:49', 30, 'S', 'admin', 840, '127.0.0.1', 'generalclaim_id', ''),
('sim_hr_generalclaim', 'issubmit=''''', 'U', 1, '2010-08-02 12:03:56', 30, 'S', 'admin', 841, '127.0.0.1', 'generalclaim_id', '');
INSERT INTO `sim_audit` (`tablename`, `changedesc`, `category`, `uid`, `updated`, `record_id`, `eventype`, `uname`, `audit_id`, `ip`, `primarykey`, `controlvalue`) VALUES
('sim_hr_generalclaimline', 'generalclaim_id=''30''generalclaimline_date=''1900-01-01''generalclaimline_details=''''generalclaimline_porpose=''''generalclaimline_billno=''''generalclaimline_amount=''0''remarks=''''generalclaimline_acccode=''''created=''2010-08-02 12:03:57''createdby=''1''updated=''2010-08-02 12:03:57''updatedby=''1', 'I', 1, '2010-08-02 12:03:57', 31, 'S', 'admin', 842, '127.0.0.1', 'generalclaimline_id', ''),
('sim_hr_travellingclaim', 'employee_id=''Lister(33)''travellingclaim_date=''2010-08-18''travellingclaim_docno=''''travellingclaim_remark=''''travellingclaim_transport=''adas''period_id=''2010(2)''created=''10/08/02 12:04:19''createdby=''admin(1)''updated=''10/08/02 12:04:19''updatedby=''admin(1)''organization_id=''1', 'I', 1, '2010-08-02 12:04:19', 10, 'S', 'admin', 843, '127.0.0.1', 'travellingclaim_id', ''),
('sim_hr_travellingclaim', 'issubmit='''',<br/>=''0''', 'U', 1, '2010-08-02 12:04:24', 10, 'S', 'admin', 844, '127.0.0.1', 'travellingclaim_id', ''),
('sim_hr_travellingclaimline', 'travellingclaim_id=''10''travellingclaimline_date=''1900-01-01''travellingclaimline_from=''''travellingclaimline_to=''''travellingclaimline_distance=''''travellingclaimline_purpose=''''travellingclaimline_amount=''0''travellingclaimline_receipt=''''remarks=''''travellingclaimline_acccode=''''created=''2010-08-02 12:04:24''createdby=''1''updated=''2010-08-02 12:04:24''updatedby=''1', 'I', 1, '2010-08-02 12:04:25', 10, 'S', 'admin', 845, '127.0.0.1', 'travellingclaim_id', ''),
('sim_hr_overtimeclaim', 'employee_id=''KS Tan(19)''overtimeclaim_date=''2010-08-17''overtimeclaim_docno=''''overtimeclaim_remark=''''created=''10/08/02 12:04:39''createdby=''admin(1)''updated=''10/08/02 12:04:39''updatedby=''admin(1)''organization_id=''1', 'I', 1, '2010-08-02 12:04:39', 8, 'S', 'admin', 846, '127.0.0.1', 'overtimeclaim_id', ''),
('sim_hr_overtimeclaimline', 'overtimeclaim_id=''8''overtimeclaimline_date=''1900-01-01''overtimeclaimline_starttime=''00:00:00''overtimeclaimline_endtime=''00:00:00''overtimeclaimline_totalhour=''00:00:00''overtimeclaimline_purpose=''''overtimeclaimline_remark=''''created=''2010-08-02 12:04:47''createdby=''1''updated=''2010-08-02 12:04:47''updatedby=''1', 'I', 1, '2010-08-02 12:04:47', 5, 'S', 'admin', 847, '127.0.0.1', 'overtimeclaimline_id', ''),
('sim_hr_overtimeclaim', 'employee_id=''B-Hunter(17)''overtimeclaim_date=''2010-08-18''overtimeclaim_docno=''''overtimeclaim_remark=''''created=''10/08/02 12:11:13''createdby=''admin(1)''updated=''10/08/02 12:11:13''updatedby=''admin(1)''organization_id=''1', 'I', 1, '2010-08-02 12:11:13', 9, 'S', 'admin', 848, '127.0.0.1', 'overtimeclaim_id', ''),
('sim_hr_overtimeclaimline', 'overtimeclaim_id=''9''overtimeclaimline_date=''1900-01-01''overtimeclaimline_starttime=''00:00:00''overtimeclaimline_endtime=''00:00:00''overtimeclaimline_totalhour=''00:00:00''overtimeclaimline_purpose=''''overtimeclaimline_remark=''''created=''2010-08-02 12:11:24''createdby=''1''updated=''2010-08-02 12:11:24''updatedby=''1', 'I', 1, '2010-08-02 12:11:24', 6, 'S', 'admin', 849, '127.0.0.1', 'overtimeclaimline_id', ''),
('sim_hr_overtimeclaim', 'overtimeclaim_remark=''ss''', 'U', 1, '2010-08-02 12:12:11', 9, 'S', 'admin', 850, '127.0.0.1', 'overtimeclaim_id', ''),
('sim_hr_overtimeclaim', 'employee_id=''GoD(18)''overtimeclaim_date=''2010-08-12''overtimeclaim_docno=''''overtimeclaim_remark=''''created=''10/08/02 12:29:38''createdby=''admin(1)''updated=''10/08/02 12:29:38''updatedby=''admin(1)''organization_id=''1', 'I', 1, '2010-08-02 12:29:38', 10, 'S', 'admin', 851, '127.0.0.1', 'overtimeclaim_id', ''),
('sim_hr_medicalclaim', 'employee_id=''KS Tan(19)''medicalclaim_date=''2010-08-09''medicalclaim_clinic=''asd''medicalclaim_docno=''das''medicalclaim_amount=''1231''medicalclaim_treatment=''das''medicalclaim_remark=''''period_id=''2010(2)''created=''10/08/02 12:33:04''createdby=''admin(1)''updated=''10/08/02 12:33:04''updatedby=''admin(1)''organization_id=''1', 'I', 1, '2010-08-02 12:33:04', 9, 'S', 'admin', 852, '127.0.0.1', 'medicalclaim_id', 'das'),
('sim_hr_medicalclaim', 'issubmit=''1''', 'U', 1, '2010-08-02 12:33:07', 9, 'S', 'admin', 853, '127.0.0.1', 'medicalclaim_id', 'das'),
('sim_workflowtransaction', 'workflowtransaction_datetime=''10/08/02 12:33:07''target_groupid=''1''target_uid=''0''targetparameter_name=''10''workflowstatus_id=''1''workflow_id=''10''tablename=''sim_hr_medicalclaim''primarykey_name=''medicalclaim_id''primarykey_value=''9''hyperlink=''../hr/medicalclaim.php''title_description=''''created=''10/08/02 12:33:07''list_parameter=''''workflowtransaction_description=''''workflowtransaction_feedback=''''iscomplete=''0''createdby=''1''email_list=''1,10''sms_list=''1,10''email_body=''''sms_body=''''person_id=''19''issubmit=''1', 'I', 1, '2010-08-02 12:33:07', 60, 'S', 'admin', 854, '127.0.0.1', 'workflowtransaction_id', 'sim_hr_medicalclaim'),
('sim_workflowtransactionhistory', 'workflowtransaction_id=''60''workflowstatus_id=''1''workflowtransaction_datetime=''10/08/02 12:33:07''uid=''1''workflowtransactionhistory_description=''', 'I', 1, '2010-08-02 12:33:07', 0, 'S', 'admin', 855, '127.0.0.1', 'workflowtransactionhistory_id', ''),
('sim_hr_overtimeclaim', 'employee_id=''GoD(18)''overtimeclaim_date=''2010-08-10''overtimeclaim_docno=''''overtimeclaim_remark=''''created=''10/08/02 12:33:31''createdby=''admin(1)''updated=''10/08/02 12:33:31''updatedby=''admin(1)''organization_id=''1', 'I', 1, '2010-08-02 12:33:31', 11, 'S', 'admin', 856, '127.0.0.1', 'overtimeclaim_id', ''),
('sim_hr_overtimeclaimline', 'overtimeclaim_id=''11''overtimeclaimline_date=''1900-01-01''overtimeclaimline_starttime=''00:00:00''overtimeclaimline_endtime=''00:00:00''overtimeclaimline_totalhour=''00:00:00''overtimeclaimline_purpose=''''overtimeclaimline_remark=''''created=''2010-08-02 12:33:36''createdby=''1''updated=''2010-08-02 12:33:36''updatedby=''1', 'I', 1, '2010-08-02 12:33:36', 7, 'S', 'admin', 857, '127.0.0.1', 'overtimeclaimline_id', ''),
('sim_hr_employeegroup', 'employeegroup_no=''''employeegroup_name=''''islecturer=''1''isovertime=''1''isparttime=''1''isactive=''1''defaultlevel=''0''created=''2010-08-02 12:36:57''createdby=''1''updated=''2010-08-02 12:36:57''updatedby=''1''organization_id=''1''description=''', 'I', 1, '2010-08-02 12:36:57', 18, 'S', 'admin', 858, '127.0.0.1', 'employeegroup_id', ''),
('sim_hr_employeegroup', 'isdeleted=', 'D', 1, '2010-08-02 12:37:59', 15, 'S', 'admin', 859, '127.0.0.1', 'employeegroup_id', 'we'),
('sim_hr_overtimeclaim', 'employee_id=''B-Hunter(17)''overtimeclaim_date=''2010-08-18''overtimeclaim_docno=''''overtimeclaim_remark=''''created=''10/08/02 12:44:23''createdby=''admin(1)''updated=''10/08/02 12:44:23''updatedby=''admin(1)''organization_id=''1', 'I', 1, '2010-08-02 12:44:23', 12, 'S', 'admin', 860, '127.0.0.1', 'overtimeclaim_id', ''),
('sim_hr_overtimeclaim', 'overtimeclaim_remark=''asd''', 'U', 1, '2010-08-02 12:48:07', 12, 'S', 'admin', 861, '127.0.0.1', 'overtimeclaim_id', ''),
('sim_hr_overtimeclaimline', 'overtimeclaim_id=''12''overtimeclaimline_date=''1900-01-01''overtimeclaimline_starttime=''01:23:00''overtimeclaimline_endtime=''00:22:00''overtimeclaimline_totalhour=''-01:01:0''overtimeclaimline_purpose=''''overtimeclaimline_remark=''''created=''2010-08-02 12:48:20''createdby=''1''updated=''2010-08-02 12:48:20''updatedby=''1', 'I', 1, '2010-08-02 12:48:20', 8, 'S', 'admin', 862, '127.0.0.1', 'overtimeclaimline_id', ''),
('sim_hr_overtimeclaim', 'employee_id=''KS Tan(19)''overtimeclaim_date=''2010-08-16''overtimeclaim_docno=''''overtimeclaim_remark=''''created=''10/08/02 12:53:48''createdby=''admin(1)''updated=''10/08/02 12:53:48''updatedby=''admin(1)''organization_id=''1', 'I', 1, '2010-08-02 12:53:48', 13, 'S', 'admin', 863, '127.0.0.1', 'overtimeclaim_id', ''),
('sim_hr_overtimeclaim', 'issubmit=''''', 'U', 1, '2010-08-02 12:53:54', 13, 'S', 'admin', 864, '127.0.0.1', 'overtimeclaim_id', ''),
('sim_hr_overtimeclaim', 'issubmit=''''', 'U', 1, '2010-08-02 12:54:01', 13, 'S', 'admin', 865, '127.0.0.1', 'overtimeclaim_id', ''),
('sim_hr_overtimeclaimline', 'overtimeclaim_id=''13''overtimeclaimline_date=''1900-01-01''overtimeclaimline_starttime=''00:00:00''overtimeclaimline_endtime=''00:00:00''overtimeclaimline_totalhour=''00:00:00''overtimeclaimline_purpose=''''overtimeclaimline_remark=''''created=''2010-08-02 12:54:00''createdby=''1''updated=''2010-08-02 12:54:00''updatedby=''1', 'I', 1, '2010-08-02 12:54:01', 9, 'S', 'admin', 866, '127.0.0.1', 'overtimeclaimline_id', ''),
('sim_hr_overtimeclaim', 'issubmit=''1''', 'U', 1, '2010-08-02 12:54:04', 13, 'S', 'admin', 867, '127.0.0.1', 'overtimeclaim_id', ''),
('sim_workflowtransaction', 'workflowtransaction_datetime=''10/08/02 12:54:04''target_groupid=''1''target_uid=''0''targetparameter_name=''10''workflowstatus_id=''1''workflow_id=''9''tablename=''sim_hr_overtimeclaim''primarykey_name=''overtimeclaim_id''primarykey_value=''13''hyperlink=''../hr/overtimeclaim.php''title_description=''''created=''10/08/02 12:54:04''list_parameter=''''workflowtransaction_description=''''workflowtransaction_feedback=''''iscomplete=''0''createdby=''1''email_list=''1,10''sms_list=''1,10''email_body=''''sms_body=''''person_id=''19''issubmit=''1', 'I', 1, '2010-08-02 12:54:04', 61, 'S', 'admin', 868, '127.0.0.1', 'workflowtransaction_id', 'sim_hr_overtimeclaim'),
('sim_workflowtransactionhistory', 'workflowtransaction_id=''61''workflowstatus_id=''1''workflowtransaction_datetime=''10/08/02 12:54:04''uid=''1''workflowtransactionhistory_description=''', 'I', 1, '2010-08-02 12:54:04', 0, 'S', 'admin', 869, '127.0.0.1', 'workflowtransactionhistory_id', ''),
('sim_hr_overtimeclaim', 'employee_id=''KS Tan(19)''overtimeclaim_date=''2010-08-16''overtimeclaim_docno=''''overtimeclaim_remark=''''created=''10/08/02 12:59:28''createdby=''admin(1)''updated=''10/08/02 12:59:28''updatedby=''admin(1)''organization_id=''1', 'I', 1, '2010-08-02 12:59:28', 14, 'S', 'admin', 870, '127.0.0.1', 'overtimeclaim_id', ''),
('sim_hr_overtimeclaim', 'issubmit=''''', 'U', 1, '2010-08-02 12:59:35', 14, 'S', 'admin', 871, '127.0.0.1', 'overtimeclaim_id', ''),
('sim_hr_overtimeclaimline', 'overtimeclaim_id=''14''overtimeclaimline_date=''1900-01-01''overtimeclaimline_starttime=''12:30:00''overtimeclaimline_endtime=''14:00:00''overtimeclaimline_totalhour=''01:30:00''overtimeclaimline_purpose=''''overtimeclaimline_remark=''''created=''2010-08-02 13:00:36''createdby=''1''updated=''2010-08-02 13:00:36''updatedby=''1', 'I', 1, '2010-08-02 13:00:36', 10, 'S', 'admin', 872, '127.0.0.1', 'overtimeclaimline_id', ''),
('sim_hr_overtimeclaim', 'issubmit=''''', 'U', 1, '2010-08-02 13:00:36', 14, 'S', 'admin', 873, '127.0.0.1', 'overtimeclaim_id', ''),
('sim_hr_overtimeclaim', 'issubmit=''1''', 'U', 1, '2010-08-02 13:00:39', 14, 'S', 'admin', 874, '127.0.0.1', 'overtimeclaim_id', ''),
('sim_workflowtransaction', 'workflowtransaction_datetime=''10/08/02 13:00:39''target_groupid=''1''target_uid=''0''targetparameter_name=''10''workflowstatus_id=''1''workflow_id=''9''tablename=''sim_hr_overtimeclaim''primarykey_name=''overtimeclaim_id''primarykey_value=''14''hyperlink=''../hr/overtimeclaim.php''title_description=''''created=''10/08/02 13:00:39''list_parameter=''''workflowtransaction_description=''''workflowtransaction_feedback=''''iscomplete=''0''createdby=''1''email_list=''1,10''sms_list=''1,10''email_body=''''sms_body=''''person_id=''19''issubmit=''1', 'I', 1, '2010-08-02 13:00:39', 62, 'S', 'admin', 875, '127.0.0.1', 'workflowtransaction_id', 'sim_hr_overtimeclaim'),
('sim_workflowtransactionhistory', 'workflowtransaction_id=''62''workflowstatus_id=''1''workflowtransaction_datetime=''10/08/02 13:00:39''uid=''1''workflowtransactionhistory_description=''', 'I', 1, '2010-08-02 13:00:39', 0, 'S', 'admin', 876, '127.0.0.1', 'workflowtransactionhistory_id', ''),
('sim_country', 'isdeleted=', 'D', 1, '2010-08-02 13:03:16', 3, 'S', 'admin', 877, '127.0.0.1', 'country_id', 'MY'),
('sim_country', 'country_code=''ss''country_name=''ss''isactive=''1''seqno=''10''created=''2010-08-02 13:03:28''createdby=''1''updated=''2010-08-02 13:03:28''updatedby=''1''citizenship=''', 'I', 1, '2010-08-02 13:03:28', 4, 'S', 'admin', 878, '127.0.0.1', 'country_id', 'ss'),
('sim_country', 'isdeleted=', 'D', 1, '2010-08-02 13:03:35', 4, 'S', 'admin', 879, '127.0.0.1', 'country_id', 'ss'),
('sim_country', 'Record deleted permanentl', 'E', 1, '2010-08-02 13:03:38', 4, 'S', 'admin', 880, '127.0.0.1', 'country_id', 'ss'),
('sim_country', 'country_code=''EE''country_name=''we''isactive=''1''seqno=''10''created=''2010-08-02 13:31:34''createdby=''1''updated=''2010-08-02 13:31:34''updatedby=''1''citizenship=''', 'I', 1, '2010-08-02 13:31:34', 5, 'S', 'admin', 881, '127.0.0.1', 'country_id', 'EE'),
('sim_country', 'isdeleted=', 'D', 1, '2010-08-02 13:31:45', 5, 'S', 'admin', 882, '127.0.0.1', 'country_id', 'EE'),
('sim_country', 'Record deleted permanentl', 'E', 1, '2010-08-02 13:31:50', 5, 'S', 'admin', 883, '127.0.0.1', 'country_id', 'EE'),
('sim_workflowtransaction', 'workflowtransaction_datetime=''10/08/02 13:37:29''target_groupid=''1''target_uid=''0''targetparameter_name=''''workflowstatus_id=''2''workflow_id=''9''tablename=''sim_hr_overtimeclaim''primarykey_name=''overtimeclaim_id''primarykey_value=''13''hyperlink=''../hr/overtimeclaim.php''title_description=''''created=''10/08/02 13:37:29''list_parameter=''''workflowtransaction_description=''''workflowtransaction_feedback=''f fwew''iscomplete=''1''createdby=''1''email_list=''''sms_list=''''email_body=''''sms_body=''''person_id=''19''issubmit=''1', 'I', 1, '2010-08-02 13:37:29', 63, 'S', '', 884, '192.168.1.203', 'workflowtransaction_id', 'sim_hr_overtimeclaim'),
('sim_workflowtransactionhistory', 'workflowtransaction_id=''63''workflowstatus_id=''2''workflowtransaction_datetime=''10/08/02 13:37:29''uid=''1''workflowtransactionhistory_description=''', 'I', 1, '2010-08-02 13:37:29', 0, 'S', '', 885, '192.168.1.203', 'workflowtransactionhistory_id', ''),
('sim_workflowtransaction', 'workflowtransaction_datetime=''10/08/02 13:37:46''target_groupid=''31''target_uid=''0''targetparameter_name=''1''workflowstatus_id=''3''workflow_id=''1''tablename=''sim_hr_leave''primarykey_name=''leave_id''primarykey_value=''28''hyperlink=''../hr/leave.php''title_description=''''created=''10/08/02 13:37:46''list_parameter=''''workflowtransaction_description=''''workflowtransaction_feedback='' rwer''iscomplete=''1''createdby=''1''email_list=''''sms_list=''''email_body=''''sms_body=''''person_id=''19''issubmit=''1', 'I', 1, '2010-08-02 13:37:46', 64, 'S', '', 886, '192.168.1.203', 'workflowtransaction_id', 'sim_hr_leave'),
('sim_workflowtransactionhistory', 'workflowtransaction_id=''64''workflowstatus_id=''3''workflowtransaction_datetime=''10/08/02 13:37:46''uid=''1''workflowtransactionhistory_description=''', 'I', 1, '2010-08-02 13:37:46', 0, 'S', '', 887, '192.168.1.203', 'workflowtransactionhistory_id', ''),
('sim_workflowtransaction', 'workflowtransaction_datetime=''10/08/02 13:48:14''target_groupid=''''target_uid=''''targetparameter_name=''''workflowstatus_id=''''workflow_id=''''tablename=''sim_hr_generalclaim''primarykey_name=''generalclaim_id''primarykey_value=''20''hyperlink=''''title_description=''''created=''10/08/02 13:48:14''list_parameter=''''workflowtransaction_description=''''workflowtransaction_feedback=''''iscomplete=''''createdby=''1''email_list=''''sms_list=''''email_body=''''sms_body=''''person_id=''19''issubmit=''', 'I', 1, '2010-08-02 13:48:14', 65, 'S', 'admin', 888, '192.168.1.203', 'workflowtransaction_id', 'sim_hr_generalclaim'),
('sim_workflowtransactionhistory', 'workflowtransaction_id=''65''workflowstatus_id=''''workflowtransaction_datetime=''10/08/02 13:48:14''uid=''1''workflowtransactionhistory_description=''', 'I', 1, '2010-08-02 13:48:14', 0, 'S', 'admin', 889, '192.168.1.203', 'workflowtransactionhistory_id', ''),
('sim_workflowtransaction', 'workflowtransaction_datetime=''10/08/02 13:48:20''target_groupid=''''target_uid=''''targetparameter_name=''''workflowstatus_id=''''workflow_id=''''tablename=''sim_hr_generalclaim''primarykey_name=''generalclaim_id''primarykey_value=''20''hyperlink=''''title_description=''''created=''10/08/02 13:48:20''list_parameter=''''workflowtransaction_description=''''workflowtransaction_feedback=''''iscomplete=''''createdby=''1''email_list=''''sms_list=''''email_body=''''sms_body=''''person_id=''19''issubmit=''', 'I', 1, '2010-08-02 13:48:20', 66, 'S', 'admin', 890, '192.168.1.203', 'workflowtransaction_id', 'sim_hr_generalclaim'),
('sim_workflowtransactionhistory', 'workflowtransaction_id=''66''workflowstatus_id=''''workflowtransaction_datetime=''10/08/02 13:48:20''uid=''1''workflowtransactionhistory_description=''', 'I', 1, '2010-08-02 13:48:20', 0, 'S', 'admin', 891, '192.168.1.203', 'workflowtransactionhistory_id', ''),
('sim_workflowtransaction', 'workflowtransaction_datetime=''10/08/02 13:48:31''target_groupid=''''target_uid=''''targetparameter_name=''''workflowstatus_id=''''workflow_id=''''tablename=''sim_hr_generalclaim''primarykey_name=''generalclaim_id''primarykey_value=''20''hyperlink=''''title_description=''''created=''10/08/02 13:48:31''list_parameter=''''workflowtransaction_description=''''workflowtransaction_feedback=''''iscomplete=''''createdby=''1''email_list=''''sms_list=''''email_body=''''sms_body=''''person_id=''19''issubmit=''', 'I', 1, '2010-08-02 13:48:31', 67, 'S', '', 892, '192.168.1.203', 'workflowtransaction_id', 'sim_hr_generalclaim'),
('sim_workflowtransactionhistory', 'workflowtransaction_id=''67''workflowstatus_id=''''workflowtransaction_datetime=''10/08/02 13:48:31''uid=''1''workflowtransactionhistory_description=''', 'I', 1, '2010-08-02 13:48:31', 0, 'S', '', 893, '192.168.1.203', 'workflowtransactionhistory_id', ''),
('sim_workflowtransaction', 'workflowtransaction_datetime=''10/08/02 13:48:37''target_groupid=''''target_uid=''''targetparameter_name=''''workflowstatus_id=''''workflow_id=''''tablename=''sim_hr_overtimeclaim''primarykey_name=''overtimeclaim_id''primarykey_value=''14''hyperlink=''''title_description=''''created=''10/08/02 13:48:37''list_parameter=''''workflowtransaction_description=''''workflowtransaction_feedback=''''iscomplete=''''createdby=''1''email_list=''''sms_list=''''email_body=''''sms_body=''''person_id=''19''issubmit=''', 'I', 1, '2010-08-02 13:48:37', 68, 'S', '', 894, '192.168.1.203', 'workflowtransaction_id', 'sim_hr_overtimeclaim'),
('sim_workflowtransactionhistory', 'workflowtransaction_id=''68''workflowstatus_id=''''workflowtransaction_datetime=''10/08/02 13:48:37''uid=''1''workflowtransactionhistory_description=''', 'I', 1, '2010-08-02 13:48:37', 0, 'S', '', 895, '192.168.1.203', 'workflowtransactionhistory_id', ''),
('sim_workflowtransaction', 'workflowtransaction_datetime=''10/08/02 13:48:57''target_groupid=''''target_uid=''''targetparameter_name=''''workflowstatus_id=''''workflow_id=''''tablename=''sim_hr_generalclaim''primarykey_name=''generalclaim_id''primarykey_value=''21''hyperlink=''''title_description=''''created=''10/08/02 13:48:57''list_parameter=''''workflowtransaction_description=''''workflowtransaction_feedback=''''iscomplete=''''createdby=''1''email_list=''''sms_list=''''email_body=''''sms_body=''''person_id=''19''issubmit=''', 'I', 1, '2010-08-02 13:48:57', 69, 'S', '', 896, '192.168.1.203', 'workflowtransaction_id', 'sim_hr_generalclaim'),
('sim_workflowtransactionhistory', 'workflowtransaction_id=''69''workflowstatus_id=''''workflowtransaction_datetime=''10/08/02 13:48:57''uid=''1''workflowtransactionhistory_description=''', 'I', 1, '2010-08-02 13:48:57', 0, 'S', '', 897, '192.168.1.203', 'workflowtransactionhistory_id', ''),
('sim_workflowtransaction', 'workflowtransaction_datetime=''10/08/02 13:49:03''target_groupid=''0''target_uid=''0''targetparameter_name=''1''workflowstatus_id=''5''workflow_id=''10''tablename=''sim_hr_medicalclaim''primarykey_name=''medicalclaim_id''primarykey_value=''6''hyperlink=''''title_description=''''created=''10/08/02 13:49:03''list_parameter=''''workflowtransaction_description=''''workflowtransaction_feedback=''''iscomplete=''0''createdby=''1''email_list=''''sms_list=''''email_body=''''sms_body=''''person_id=''17''issubmit=''0', 'I', 1, '2010-08-02 13:49:03', 70, 'S', '', 898, '192.168.1.203', 'workflowtransaction_id', 'sim_hr_medicalclaim'),
('sim_workflowtransactionhistory', 'workflowtransaction_id=''70''workflowstatus_id=''5''workflowtransaction_datetime=''10/08/02 13:49:03''uid=''1''workflowtransactionhistory_description=''', 'I', 1, '2010-08-02 13:49:03', 0, 'S', '', 899, '192.168.1.203', 'workflowtransactionhistory_id', ''),
('sim_workflowtransaction', 'workflowtransaction_datetime=''10/08/02 13:49:13''target_groupid=''''target_uid=''''targetparameter_name=''''workflowstatus_id=''''workflow_id=''''tablename=''sim_hr_medicalclaim''primarykey_name=''medicalclaim_id''primarykey_value=''3''hyperlink=''''title_description=''''created=''10/08/02 13:49:13''list_parameter=''''workflowtransaction_description=''''workflowtransaction_feedback=''''iscomplete=''''createdby=''1''email_list=''''sms_list=''''email_body=''''sms_body=''''person_id=''14''issubmit=''', 'I', 1, '2010-08-02 13:49:13', 71, 'S', '', 900, '192.168.1.203', 'workflowtransaction_id', 'sim_hr_medicalclaim'),
('sim_workflowtransactionhistory', 'workflowtransaction_id=''71''workflowstatus_id=''''workflowtransaction_datetime=''10/08/02 13:49:13''uid=''1''workflowtransactionhistory_description=''', 'I', 1, '2010-08-02 13:49:13', 0, 'S', '', 901, '192.168.1.203', 'workflowtransactionhistory_id', ''),
('sim_workflowtransaction', 'workflowtransaction_datetime=''10/08/02 13:49:18''target_groupid=''0''target_uid=''0''targetparameter_name=''1''workflowstatus_id=''5''workflow_id=''11''tablename=''sim_hr_travellingclaim''primarykey_name=''travellingclaim_id''primarykey_value=''9''hyperlink=''../hr/travellingclaim.php''title_description=''''created=''10/08/02 13:49:18''list_parameter=''''workflowtransaction_description=''''workflowtransaction_feedback=''''iscomplete=''0''createdby=''1''email_list=''''sms_list=''''email_body=''''sms_body=''''person_id=''19''issubmit=''1', 'I', 1, '2010-08-02 13:49:18', 72, 'S', '', 902, '192.168.1.203', 'workflowtransaction_id', 'sim_hr_travellingclaim'),
('sim_workflowtransactionhistory', 'workflowtransaction_id=''72''workflowstatus_id=''5''workflowtransaction_datetime=''10/08/02 13:49:18''uid=''1''workflowtransactionhistory_description=''', 'I', 1, '2010-08-02 13:49:18', 0, 'S', '', 903, '192.168.1.203', 'workflowtransactionhistory_id', ''),
('sim_workflowtransaction', 'workflowtransaction_datetime=''10/08/02 13:49:26''target_groupid=''''target_uid=''''targetparameter_name=''''workflowstatus_id=''''workflow_id=''''tablename=''sim_hr_medicalclaim''primarykey_name=''medicalclaim_id''primarykey_value=''9''hyperlink=''''title_description=''''created=''10/08/02 13:49:26''list_parameter=''''workflowtransaction_description=''''workflowtransaction_feedback=''''iscomplete=''''createdby=''1''email_list=''''sms_list=''''email_body=''''sms_body=''''person_id=''19''issubmit=''', 'I', 1, '2010-08-02 13:49:26', 73, 'S', '', 904, '192.168.1.203', 'workflowtransaction_id', 'sim_hr_medicalclaim'),
('sim_workflowtransactionhistory', 'workflowtransaction_id=''73''workflowstatus_id=''''workflowtransaction_datetime=''10/08/02 13:49:26''uid=''1''workflowtransactionhistory_description=''', 'I', 1, '2010-08-02 13:49:26', 0, 'S', '', 905, '192.168.1.203', 'workflowtransactionhistory_id', ''),
('sim_workflowtransaction', 'workflowtransaction_datetime=''10/08/02 13:49:32''target_groupid=''''target_uid=''''targetparameter_name=''''workflowstatus_id=''''workflow_id=''''tablename=''sim_hr_generalclaim''primarykey_name=''generalclaim_id''primarykey_value=''23''hyperlink=''''title_description=''''created=''10/08/02 13:49:32''list_parameter=''''workflowtransaction_description=''''workflowtransaction_feedback=''''iscomplete=''''createdby=''1''email_list=''''sms_list=''''email_body=''''sms_body=''''person_id=''19''issubmit=''', 'I', 1, '2010-08-02 13:49:32', 74, 'S', '', 906, '192.168.1.203', 'workflowtransaction_id', 'sim_hr_generalclaim'),
('sim_workflowtransactionhistory', 'workflowtransaction_id=''74''workflowstatus_id=''''workflowtransaction_datetime=''10/08/02 13:49:32''uid=''1''workflowtransactionhistory_description=''', 'I', 1, '2010-08-02 13:49:32', 0, 'S', '', 907, '192.168.1.203', 'workflowtransactionhistory_id', ''),
('sim_workflowtransaction', 'workflowtransaction_datetime=''10/08/02 13:49:48''target_groupid=''''target_uid=''''targetparameter_name=''''workflowstatus_id=''''workflow_id=''''tablename=''sim_hr_generalclaim''primarykey_name=''generalclaim_id''primarykey_value=''25''hyperlink=''''title_description=''''created=''10/08/02 13:49:48''list_parameter=''''workflowtransaction_description=''''workflowtransaction_feedback=''''iscomplete=''''createdby=''1''email_list=''''sms_list=''''email_body=''''sms_body=''''person_id=''19''issubmit=''', 'I', 1, '2010-08-02 13:49:48', 75, 'S', 'admin', 908, '192.168.1.203', 'workflowtransaction_id', 'sim_hr_generalclaim'),
('sim_workflowtransactionhistory', 'workflowtransaction_id=''75''workflowstatus_id=''''workflowtransaction_datetime=''10/08/02 13:49:48''uid=''1''workflowtransactionhistory_description=''', 'I', 1, '2010-08-02 13:49:48', 0, 'S', 'admin', 909, '192.168.1.203', 'workflowtransactionhistory_id', ''),
('sim_workflowtransaction', 'workflowtransaction_datetime=''10/08/02 13:49:59''target_groupid=''''target_uid=''''targetparameter_name=''''workflowstatus_id=''''workflow_id=''''tablename=''sim_hr_generalclaim''primarykey_name=''generalclaim_id''primarykey_value=''25''hyperlink=''''title_description=''''created=''10/08/02 13:49:59''list_parameter=''''workflowtransaction_description=''''workflowtransaction_feedback=''''iscomplete=''''createdby=''1''email_list=''''sms_list=''''email_body=''''sms_body=''''person_id=''19''issubmit=''', 'I', 1, '2010-08-02 13:49:59', 76, 'S', '', 910, '192.168.1.203', 'workflowtransaction_id', 'sim_hr_generalclaim'),
('sim_workflowtransactionhistory', 'workflowtransaction_id=''76''workflowstatus_id=''''workflowtransaction_datetime=''10/08/02 13:49:59''uid=''1''workflowtransactionhistory_description=''', 'I', 1, '2010-08-02 13:50:00', 0, 'S', '', 911, '192.168.1.203', 'workflowtransactionhistory_id', ''),
('sim_workflowtransaction', 'workflowtransaction_datetime=''10/08/02 13:50:15''target_groupid=''''target_uid=''''targetparameter_name=''''workflowstatus_id=''''workflow_id=''''tablename=''sim_hr_generalclaim''primarykey_name=''generalclaim_id''primarykey_value=''22''hyperlink=''''title_description=''''created=''10/08/02 13:50:15''list_parameter=''''workflowtransaction_description=''''workflowtransaction_feedback=''''iscomplete=''''createdby=''1''email_list=''''sms_list=''''email_body=''''sms_body=''''person_id=''19''issubmit=''', 'I', 1, '2010-08-02 13:50:15', 77, 'S', 'admin', 912, '192.168.1.203', 'workflowtransaction_id', 'sim_hr_generalclaim'),
('sim_workflowtransactionhistory', 'workflowtransaction_id=''77''workflowstatus_id=''''workflowtransaction_datetime=''10/08/02 13:50:15''uid=''1''workflowtransactionhistory_description=''', 'I', 1, '2010-08-02 13:50:15', 0, 'S', 'admin', 913, '192.168.1.203', 'workflowtransactionhistory_id', ''),
('sim_workflowtransaction', 'workflowtransaction_datetime=''10/08/02 13:51:14''target_groupid=''''target_uid=''''targetparameter_name=''''workflowstatus_id=''''workflow_id=''''tablename=''sim_hr_generalclaim''primarykey_name=''generalclaim_id''primarykey_value=''16''hyperlink=''''title_description=''''created=''10/08/02 13:51:14''list_parameter=''''workflowtransaction_description=''''workflowtransaction_feedback=''''iscomplete=''''createdby=''1''email_list=''''sms_list=''''email_body=''''sms_body=''''person_id=''17''issubmit=''', 'I', 1, '2010-08-02 13:51:14', 78, 'S', 'admin', 914, '192.168.1.203', 'workflowtransaction_id', 'sim_hr_generalclaim'),
('sim_workflowtransactionhistory', 'workflowtransaction_id=''78''workflowstatus_id=''''workflowtransaction_datetime=''10/08/02 13:51:14''uid=''1''workflowtransactionhistory_description=''', 'I', 1, '2010-08-02 13:51:14', 0, 'S', 'admin', 915, '192.168.1.203', 'workflowtransactionhistory_id', ''),
('sim_hr_employee', 'department_id=''10'',<br/>jobposition_id=''53'',<br/>defaultlevel='''',<br/>organization_id=''''', 'U', 1, '2010-08-02 13:53:16', 19, 'S', 'admin', 916, '127.0.0.1', 'employee_id', 'K001'),
('sim_hr_employeegroup', 'isdeleted=', 'D', 1, '2010-08-02 13:53:37', 12, 'S', 'admin', 917, '127.0.0.1', 'employeegroup_id', 'LFS'),
('sim_hr_employeegroup', 'Record deleted permanentl', 'E', 1, '2010-08-02 13:53:43', 12, 'F', 'admin', 918, '127.0.0.1', 'employeegroup_id', 'LFS'),
('sim_hr_employeegroup', 'Record deleted permanentl', 'E', 1, '2010-08-02 13:53:51', 12, 'F', 'admin', 919, '127.0.0.1', 'employeegroup_id', 'LFS'),
('sim_hr_department', 'department_no=''Adm''department_name=''Admin''defaultlevel=''10''description=''''department_parent=''1''isactive=''1''created=''2010-08-02 13:58:29''createdby=''1''updated=''2010-08-02 13:58:29''updatedby=''1''organization_id=''1''department_head=''0', 'I', 1, '2010-08-02 13:58:29', 37, 'S', 'admin', 920, '192.168.1.203', 'department_id', 'Admin'),
('sim_hr_employeegroup', 'employeegroup_no=''GN'',<br/>employeegroup_name=''General'',<br/>islecturer=''0''', 'U', 1, '2010-08-02 13:59:25', 18, 'S', 'admin', 921, '192.168.1.203', 'employeegroup_id', 'GN'),
('sim_hr_employee', 'employee_name=''Ali Bin Ahmad'',<br/>place_dob=''JB'',<br/>employee_dob=''1980-07-01'',<br/>races_id=''2'',<br/>employee_newicno=''800701-01-3321'',<br/>employee_bloodgroup=''A'',<br/>department_id=''37'',<br/>jobposition_id=''56'',<br/>employeegroup_id=''18'',<br/>defaultlevel='''',<br/>organization_id='''',<br/>employee_transport=''Car'',<br/>employee_altname=''Ali'',<br/>ic_placeissue=''JB'',<br/>employee_confirmdate=''2010-05-03''', 'U', 1, '2010-08-02 13:59:39', 14, 'S', 'admin', 922, '192.168.1.203', 'employee_id', '1312'),
('sim_hr_qualificationline', 'qualification_type=''4'',<br/>qualification_name=''Computer Science'',<br/>qualification_institution=''USM'',<br/>qualification_month=''2007-04-01''', 'U', 1, '2010-08-02 14:00:24', 17, 'S', 'admin', 923, '192.168.1.203', 'qualification_id', 'Computer Science'),
('sim_hr_qualificationline', 'qualification_name=''Computer Science'',<br/>qualification_institution=''USM'',<br/>qualification_month=''2005-06-02''', 'U', 1, '2010-08-02 14:00:24', 16, 'S', 'admin', 924, '192.168.1.203', 'qualification_id', 'Computer Science'),
('sim_hr_employee', 'employee_hpno=''0127895432'',<br/>employee_officeno=''078834212-120'',<br/>employee_email=''ali@simit.com.my'',<br/>permanent_address=''10, Jalan Durian,\nTaman Kota Jaya,\n81900 Kota Tinggi,\nJohor'',<br/>permanent_postcode=''81900'',<br/>permanent_city=''Kota Tinggi'',<br/>permanent_state=''Johor'',<br/>permanent_country=''3'',<br/>permanent_telno=''078833422''', 'U', 1, '2010-08-02 14:01:30', 14, 'S', 'admin', 925, '192.168.1.203', 'employee_id', ''),
('sim_hr_employee', 'contact_address=''10, Jalan Durian,\nTaman Kota Jaya,\n81900 Kota Tinggi,\nJohor'',<br/>contact_postcode=''81900'',<br/>contact_city=''Kota Tinggi'',<br/>contact_state=''Johor'',<br/>contact_country=''3'',<br/>contact_telno=''078833422''', 'U', 1, '2010-08-02 14:02:12', 14, 'S', 'admin', 926, '192.168.1.203', 'employee_id', ''),
('sim_hr_employeespouse', 'spouse_name=''Anita Bth Othman'',<br/>spouse_hpno=''08331323''', 'U', 1, '2010-08-02 14:02:36', 5, 'S', 'admin', 927, '192.168.1.203', 'spouse_id', ''),
('sim_hr_employeefamily', 'employeefamily_name=''Muhd Bahan''', 'U', 1, '2010-08-02 14:03:17', 4, 'S', 'admin', 928, '192.168.1.203', 'employeefamily_id', 'Muhd Bahan'),
('sim_hr_employeefamily', 'Record deleted permanentl', 'E', 1, '2010-08-02 14:03:17', 3, 'S', 'admin', 929, '192.168.1.203', 'employeefamily_id', ''),
('sim_hr_employeespouse', 'spouse_races=''2''', 'U', 1, '2010-08-02 14:03:28', 5, 'S', 'admin', 930, '192.168.1.203', 'spouse_id', ''),
('sim_hr_generalclaim', 'employee_id=''Ali Bin Ahmad(14)''generalclaim_date=''2010-08-10''generalclaim_docno=''''generalclaim_remark=''''period_id=''2010(2)''created=''10/08/02 14:07:08''createdby=''admin(1)''updated=''10/08/02 14:07:08''updatedby=''admin(1)''organization_id=''1', 'I', 1, '2010-08-02 14:07:08', 31, 'S', 'admin', 931, '192.168.1.203', 'generalclaim_id', ''),
('sim_hr_generalclaim', 'issubmit=''''', 'U', 1, '2010-08-02 14:10:30', 31, 'S', 'admin', 932, '192.168.1.203', 'generalclaim_id', ''),
('sim_hr_generalclaimline', 'generalclaim_id=''31''generalclaimline_date=''2010-08-01 00:00:00''generalclaimline_details=''Petrol''generalclaimline_porpose=''To Seminar''generalclaimline_billno=''''generalclaimline_amount=''50''remarks=''''generalclaimline_acccode=''''created=''2010-08-02 14:10:31''createdby=''1''updated=''2010-08-02 14:10:31''updatedby=''1', 'I', 1, '2010-08-02 14:10:31', 32, 'S', 'admin', 933, '192.168.1.203', 'generalclaimline_id', 'Petrol'),
('sim_hr_generalclaimline', 'generalclaim_id=''31''generalclaimline_date=''2010-08-01 00:00:00''generalclaimline_details=''Toll''generalclaimline_porpose=''To Seminar''generalclaimline_billno=''''generalclaimline_amount=''20''remarks=''''generalclaimline_acccode=''''created=''2010-08-02 14:10:31''createdby=''1''updated=''2010-08-02 14:10:31''updatedby=''1', 'I', 1, '2010-08-02 14:10:31', 33, 'S', 'admin', 934, '192.168.1.203', 'generalclaimline_id', 'Toll'),
('sim_hr_generalclaim', 'employee_id=''14Ali Bin Ahmad'',<br/>issubmit=''1''', 'U', 1, '2010-08-02 14:10:37', 31, 'S', 'admin', 935, '192.168.1.203', 'generalclaim_id', ''),
('sim_workflowtransaction', 'workflowtransaction_datetime=''10/08/02 14:10:37''target_groupid=''1''target_uid=''0''targetparameter_name=''10''workflowstatus_id=''1''workflow_id=''4''tablename=''sim_hr_generalclaim''primarykey_name=''generalclaim_id''primarykey_value=''31''hyperlink=''../hr/generalclaim.php''title_description=''''created=''10/08/02 14:10:37''list_parameter=''''workflowtransaction_description=''Ok done''workflowtransaction_feedback=''''iscomplete=''0''createdby=''1''email_list=''1,10''sms_list=''1,10''email_body=''''sms_body=''''person_id=''14''issubmit=''1', 'I', 1, '2010-08-02 14:10:37', 79, 'S', 'admin', 936, '192.168.1.203', 'workflowtransaction_id', 'sim_hr_generalclaim'),
('sim_workflowtransactionhistory', 'workflowtransaction_id=''79''workflowstatus_id=''1''workflowtransaction_datetime=''10/08/02 14:10:37''uid=''1''workflowtransactionhistory_description=''', 'I', 1, '2010-08-02 14:10:37', 0, 'S', 'admin', 937, '192.168.1.203', 'workflowtransactionhistory_id', ''),
('sim_hr_employeegroup', 'Record deleted permanentl', 'E', 1, '2010-08-02 14:58:32', 17, 'S', 'admin', 938, '127.0.0.1', 'employeegroup_id', 'RE'),
('sim_hr_employeegroup', 'Record deleted permanentl', 'E', 1, '2010-08-02 15:00:39', 14, 'S', 'admin', 939, '127.0.0.1', 'employeegroup_id', 'OF'),
('sim_hr_employeegroup', 'Record deleted permanentl', 'E', 1, '2010-08-02 15:00:43', 10, 'F', 'admin', 940, '127.0.0.1', 'employeegroup_id', 'LP'),
('sim_hr_employeegroup', 'Record deleted permanentl', 'E', 1, '2010-08-02 15:00:48', 10, 'F', 'admin', 941, '127.0.0.1', 'employeegroup_id', 'LP'),
('sim_hr_employeegroup', 'Record deleted permanentl', 'E', 1, '2010-08-02 15:00:52', 11, 'S', 'admin', 942, '127.0.0.1', 'employeegroup_id', 'DF'),
('sim_hr_employeegroup', 'Record deleted permanentl', 'E', 1, '2010-08-02 15:00:55', 16, 'S', 'admin', 943, '127.0.0.1', 'employeegroup_id', 'DS'),
('sim_hr_employeegroup', 'Record deleted permanentl', 'E', 1, '2010-08-02 15:00:57', 18, 'F', 'admin', 944, '127.0.0.1', 'employeegroup_id', 'GN'),
('sim_hr_leavetype', 'leavetype_name=''DS''isactive=''1''isvalidate=''1''defaultlevel=''10''created=''2010-08-02 15:06:44''createdby=''1''updated=''2010-08-02 15:06:44''updatedby=''1''organization_id=''1''description=''', 'I', 1, '2010-08-02 15:06:44', 14, 'S', 'admin', 945, '127.0.0.1', 'leavetype_id', 'DS'),
('sim_hr_leavetype', 'Record deleted permanentl', 'E', 1, '2010-08-02 15:06:59', 14, 'S', 'admin', 946, '127.0.0.1', 'leavetype_id', 'DS'),
('sim_hr_employeegroup', 'employeegroup_no=''FE''employeegroup_name=''re''islecturer=''1''isovertime=''1''isparttime=''1''isactive=''1''seqno=''10''created=''2010-08-02 15:15:30''createdby=''1''updated=''2010-08-02 15:15:30''updatedby=''1''organization_id=''1''description=''', 'I', 1, '2010-08-02 15:15:30', 22, 'S', 'admin', 947, '127.0.0.1', 'employeegroup_id', 'FE'),
('sim_hr_employeegroup', 'description=''fdsa''', 'U', 1, '2010-08-02 15:15:47', 22, 'S', 'admin', 948, '127.0.0.1', 'employeegroup_id', 'FE'),
('sim_hr_employeegroup', 'Record deleted permanentl', 'E', 1, '2010-08-02 15:15:50', 22, 'S', 'admin', 949, '127.0.0.1', 'employeegroup_id', 'FE'),
('sim_hr_department', 'department_no=''AD''department_name=''Admin''seqno=''10''description=''das''department_parent=''0''isactive=''1''created=''2010-08-02 15:17:42''createdby=''1''updated=''2010-08-02 15:17:42''updatedby=''1''organization_id=''1''department_head=''0', 'I', 1, '2010-08-02 15:17:42', 3, 'S', 'admin', 950, '127.0.0.1', 'department_id', 'Admin'),
('sim_window', 'mid=''64''windowsetting=''''seqno=''10''description=''''parentwindows_id=''17''filename=''employeeprofile.php''isactive=''0''window_name=''Print Employee Cover''created=''2010-08-02 15:44:00''createdby=''1''updated=''2010-08-02 15:44:00''updatedby=''1''table_name=''', 'I', 0, '2010-08-02 15:44:00', 46, 'S', '', 951, '127.0.0.1', 'window_id', 'Print Employee Cover'),
('sim_window', 'mid=''64''windowsetting=''''seqno=''10''description=''''parentwindows_id=''17''filename=''viewemployeeprofile.php''isactive=''0''window_name=''Print Employee Details''created=''2010-08-02 15:44:25''createdby=''1''updated=''2010-08-02 15:44:25''updatedby=''1''table_name=''', 'I', 0, '2010-08-02 15:44:25', 47, 'S', '', 952, '127.0.0.1', 'window_id', 'Print Employee Details'),
('sim_races', 'races_name=''Chinese''', 'U', 1, '2010-08-02 15:46:42', 1, 'S', 'admin', 953, '127.0.0.1', 'races_id', 'C'),
('sim_races', 'races_description=''O''races_name=''Others''isactive=''1''seqno=''10''created=''2010-08-02 15:47:10''createdby=''1''updated=''2010-08-02 15:47:10''updatedby=''1''organization_id=''1', 'I', 1, '2010-08-02 15:47:10', 5, 'S', 'admin', 954, '127.0.0.1', 'races_id', 'O'),
('sim_hr_employee', 'seqno='''',<br/>organization_id=''''', 'U', 1, '2010-08-02 15:52:43', 19, 'S', 'admin', 955, '127.0.0.1', 'employee_id', 'K001'),
('sim_hr_employee', 'filephoto=''1280735600_photofile19.jpeg'',<br/>seqno='''',<br/>organization_id=''''', 'U', 1, '2010-08-02 15:53:20', 19, 'S', 'admin', 956, '127.0.0.1', 'employee_id', 'K001'),
('sim_hr_employee', 'seqno='''',<br/>organization_id=''''', 'U', 1, '2010-08-02 15:53:39', 19, 'S', 'admin', 957, '127.0.0.1', 'employee_id', 'K001'),
('sim_hr_employee', 'filephoto=''1280735636_photofile19.jpeg'',<br/>seqno='''',<br/>organization_id=''''', 'U', 1, '2010-08-02 15:53:56', 19, 'S', 'admin', 958, '127.0.0.1', 'employee_id', 'K001'),
('sim_hr_generalclaim', 'employee_id=''KS Tan(19)''generalclaim_date=''2010-08-09''generalclaim_docno=''''generalclaim_remark=''''period_id=''2010(2)''created=''10/08/02 16:29:39''createdby=''admin(1)''updated=''10/08/02 16:29:39''updatedby=''admin(1)''organization_id=''1', 'I', 1, '2010-08-02 16:29:39', 32, 'S', 'admin', 959, '127.0.0.1', 'generalclaim_id', ''),
('sim_hr_travellingclaim', 'employee_id=''Ali Bin Ahmad(14)''travellingclaim_date=''2010-08-10''travellingclaim_docno=''''travellingclaim_remark=''''travellingclaim_transport=''dasds''period_id=''2010(2)''created=''10/08/02 16:34:55''createdby=''admin(1)''updated=''10/08/02 16:34:55''updatedby=''admin(1)''organization_id=''1', 'I', 1, '2010-08-02 16:34:55', 11, 'S', 'admin', 960, '127.0.0.1', 'travellingclaim_id', ''),
('sim_hr_travellingclaim', 'travellingclaim_date='''',<br/>issubmit=''1''', 'U', 1, '2010-08-02 16:35:04', 11, 'S', 'admin', 961, '127.0.0.1', 'travellingclaim_id', ''),
('sim_workflowtransaction', 'workflowtransaction_datetime=''10/08/02 16:35:04''target_groupid=''1''target_uid=''0''targetparameter_name=''10''workflowstatus_id=''1''workflow_id=''11''tablename=''sim_hr_travellingclaim''primarykey_name=''travellingclaim_id''primarykey_value=''11''hyperlink=''../hr/travellingclaim.php''title_description=''''created=''10/08/02 16:35:04''list_parameter=''''workflowtransaction_description=''''workflowtransaction_feedback=''''iscomplete=''0''createdby=''1''email_list=''1,10''sms_list=''1,10''email_body=''''sms_body=''''person_id=''14''issubmit=''1', 'I', 1, '2010-08-02 16:35:05', 80, 'S', 'admin', 962, '127.0.0.1', 'workflowtransaction_id', 'sim_hr_travellingclaim'),
('sim_workflowtransactionhistory', 'workflowtransaction_id=''80''workflowstatus_id=''1''workflowtransaction_datetime=''10/08/02 16:35:05''uid=''1''workflowtransactionhistory_description=''', 'I', 1, '2010-08-02 16:35:05', 0, 'S', 'admin', 963, '127.0.0.1', 'workflowtransactionhistory_id', ''),
('sim_hr_travellingclaim', 'employee_id=''KS Tan(19)''travellingclaim_date=''2010-08-11''travellingclaim_docno=''''travellingclaim_remark=''''travellingclaim_transport=''das''period_id=''2010(2)''created=''10/08/02 16:38:48''createdby=''admin(1)''updated=''10/08/02 16:38:48''updatedby=''admin(1)''organization_id=''1', 'I', 1, '2010-08-02 16:38:48', 12, 'S', 'admin', 964, '127.0.0.1', 'travellingclaim_id', ''),
('sim_hr_travellingclaim', 'issubmit='''',<br/>=''0''', 'U', 1, '2010-08-02 16:38:55', 12, 'S', 'admin', 965, '127.0.0.1', 'travellingclaim_id', ''),
('sim_hr_travellingclaimline', 'travellingclaim_id=''12''travellingclaimline_date=''1900-01-01''travellingclaimline_from=''''travellingclaimline_to=''''travellingclaimline_distance=''''travellingclaimline_purpose=''''travellingclaimline_amount=''01231''travellingclaimline_receipt=''''remarks=''''travellingclaimline_acccode=''''created=''2010-08-02 16:38:56''createdby=''1''updated=''2010-08-02 16:38:56''updatedby=''1', 'I', 1, '2010-08-02 16:38:56', 12, 'S', 'admin', 966, '127.0.0.1', 'travellingclaim_id', ''),
('sim_hr_travellingclaim', 'employee_id=''KS Tan(19)''travellingclaim_date=''2010-08-17''travellingclaim_docno=''''travellingclaim_remark=''''travellingclaim_transport=''DS''period_id=''2010(2)''created=''10/08/02 16:41:48''createdby=''admin(1)''updated=''10/08/02 16:41:48''updatedby=''admin(1)''organization_id=''1', 'I', 1, '2010-08-02 16:41:48', 13, 'S', 'admin', 967, '127.0.0.1', 'travellingclaim_id', ''),
('sim_hr_travellingclaim', 'employee_id=''KS Tan(19)''travellingclaim_date=''2010-08-10''travellingclaim_docno=''''travellingclaim_remark=''''travellingclaim_transport=''dsa''period_id=''2010(2)''created=''10/08/02 16:43:07''createdby=''admin(1)''updated=''10/08/02 16:43:07''updatedby=''admin(1)''organization_id=''1', 'I', 1, '2010-08-02 16:43:07', 14, 'S', 'admin', 968, '127.0.0.1', 'travellingclaim_id', ''),
('sim_hr_travellingclaim', 'employee_id=''KS Tan(19)''travellingclaim_date=''2010-08-17''travellingclaim_docno=''''travellingclaim_remark=''''travellingclaim_transport=''das''period_id=''2010(2)''created=''10/08/02 16:44:10''createdby=''admin(1)''updated=''10/08/02 16:44:10''updatedby=''admin(1)''organization_id=''1', 'I', 1, '2010-08-02 16:44:10', 15, 'S', 'admin', 969, '127.0.0.1', 'travellingclaim_id', ''),
('sim_hr_medicalclaim', 'employee_id=''DSA(22)''medicalclaim_date=''2010-08-17''medicalclaim_clinic=''das''medicalclaim_docno=''das''medicalclaim_amount=''123''medicalclaim_treatment=''das''medicalclaim_remark=''''period_id=''2010(2)''created=''10/08/02 16:45:50''createdby=''admin(1)''updated=''10/08/02 16:45:50''updatedby=''admin(1)''organization_id=''1', 'I', 1, '2010-08-02 16:45:50', 10, 'S', 'admin', 970, '127.0.0.1', 'medicalclaim_id', 'das'),
('sim_hr_medicalclaim', 'medicalclaim_clinic='''',<br/>medicalclaim_docno='''',<br/>medicalclaim_treatment='''',<br/>issubmit=''1''', 'U', 1, '2010-08-02 16:46:03', 10, 'S', 'admin', 971, '127.0.0.1', 'medicalclaim_id', ''),
('sim_workflowtransaction', 'workflowtransaction_datetime=''10/08/02 16:46:03''target_groupid=''1''target_uid=''0''targetparameter_name=''10''workflowstatus_id=''1''workflow_id=''10''tablename=''sim_hr_medicalclaim''primarykey_name=''medicalclaim_id''primarykey_value=''10''hyperlink=''../hr/medicalclaim.php''title_description=''''created=''10/08/02 16:46:03''list_parameter=''''workflowtransaction_description=''''workflowtransaction_feedback=''''iscomplete=''0''createdby=''1''email_list=''1,10''sms_list=''1,10''email_body=''''sms_body=''''person_id=''22''issubmit=''1', 'I', 1, '2010-08-02 16:46:03', 81, 'S', 'admin', 972, '127.0.0.1', 'workflowtransaction_id', 'sim_hr_medicalclaim'),
('sim_workflowtransactionhistory', 'workflowtransaction_id=''81''workflowstatus_id=''1''workflowtransaction_datetime=''10/08/02 16:46:03''uid=''1''workflowtransactionhistory_description=''', 'I', 1, '2010-08-02 16:46:03', 0, 'S', 'admin', 973, '127.0.0.1', 'workflowtransactionhistory_id', ''),
('sim_workflownode', 'target_uid='''',<br/>workflow_sql='',iscomplete=1''', 'U', 0, '2010-08-02 16:54:07', 20, 'S', '', 974, '127.0.0.1', 'workflownode_id', '10'),
('sim_workflownode', 'target_groupid=''1'',<br/>target_uid=''''', 'U', 0, '2010-08-02 16:54:29', 34, 'S', '', 975, '127.0.0.1', 'workflownode_id', '10'),
('sim_hr_generalclaim', 'employee_id=''KS Tan(19)''generalclaim_date=''2010-08-09''generalclaim_docno=''DD''generalclaim_remark=''''period_id=''2010(2)''created=''10/08/02 16:54:50''createdby=''admin(1)''updated=''10/08/02 16:54:50''updatedby=''admin(1)''organization_id=''1', 'I', 1, '2010-08-02 16:54:50', 33, 'S', 'admin', 976, '127.0.0.1', 'generalclaim_id', 'DD'),
('sim_hr_generalclaim', 'issubmit=''''', 'U', 1, '2010-08-02 16:55:06', 33, 'S', 'admin', 977, '127.0.0.1', 'generalclaim_id', 'DD'),
('sim_hr_generalclaimline', 'generalclaim_id=''33''generalclaimline_date=''1900-01-01''generalclaimline_details=''''generalclaimline_porpose=''''generalclaimline_billno=''''generalclaimline_amount=''120''remarks=''''generalclaimline_acccode=''''created=''2010-08-02 16:55:06''createdby=''1''updated=''2010-08-02 16:55:06''updatedby=''1', 'I', 1, '2010-08-02 16:55:06', 34, 'S', 'admin', 978, '127.0.0.1', 'generalclaimline_id', ''),
('sim_hr_generalclaim', 'employee_id=''19KS Tan'',<br/>issubmit=''1''', 'U', 1, '2010-08-02 16:55:10', 33, 'S', 'admin', 979, '127.0.0.1', 'generalclaim_id', 'DD'),
('sim_workflowtransaction', 'workflowtransaction_datetime=''10/08/02 16:55:10''target_groupid=''1''target_uid=''0''targetparameter_name=''10''workflowstatus_id=''1''workflow_id=''4''tablename=''sim_hr_generalclaim''primarykey_name=''generalclaim_id''primarykey_value=''33''hyperlink=''../hr/generalclaim.php''title_description=''''created=''10/08/02 16:55:10''list_parameter=''''workflowtransaction_description=''Ok done''workflowtransaction_feedback=''''iscomplete=''0''createdby=''1''email_list=''1,10''sms_list=''1,10''email_body=''''sms_body=''''person_id=''19''issubmit=''1', 'I', 1, '2010-08-02 16:55:10', 82, 'S', 'admin', 980, '127.0.0.1', 'workflowtransaction_id', 'sim_hr_generalclaim'),
('sim_workflowtransactionhistory', 'workflowtransaction_id=''82''workflowstatus_id=''1''workflowtransaction_datetime=''10/08/02 16:55:10''uid=''1''workflowtransactionhistory_description=''', 'I', 1, '2010-08-02 16:55:10', 0, 'S', 'admin', 981, '127.0.0.1', 'workflowtransactionhistory_id', ''),
('sim_hr_generalclaim', 'employee_id=''KS Tan(19)''generalclaim_date=''2010-08-11''generalclaim_docno=''''generalclaim_remark=''''period_id=''2010(2)''created=''10/08/02 16:57:37''createdby=''admin(1)''updated=''10/08/02 16:57:37''updatedby=''admin(1)''organization_id=''1', 'I', 1, '2010-08-02 16:57:37', 34, 'S', 'admin', 982, '127.0.0.1', 'generalclaim_id', ''),
('sim_hr_generalclaim', 'employee_id=''19KS Tan'',<br/>issubmit=''1''', 'U', 1, '2010-08-02 16:57:41', 34, 'S', 'admin', 983, '127.0.0.1', 'generalclaim_id', ''),
('sim_workflowtransaction', 'workflowtransaction_datetime=''10/08/02 16:57:41''target_groupid=''1''target_uid=''0''targetparameter_name=''10''workflowstatus_id=''1''workflow_id=''4''tablename=''sim_hr_generalclaim''primarykey_name=''generalclaim_id''primarykey_value=''34''hyperlink=''../hr/generalclaim.php''title_description=''''created=''10/08/02 16:57:41''list_parameter=''''workflowtransaction_description=''Ok done''workflowtransaction_feedback=''''iscomplete=''0''createdby=''1''email_list=''1,10''sms_list=''1,10''email_body=''''sms_body=''''person_id=''19''issubmit=''1', 'I', 1, '2010-08-02 16:57:41', 83, 'S', 'admin', 984, '127.0.0.1', 'workflowtransaction_id', 'sim_hr_generalclaim'),
('sim_workflowtransactionhistory', 'workflowtransaction_id=''83''workflowstatus_id=''1''workflowtransaction_datetime=''10/08/02 16:57:41''uid=''1''workflowtransactionhistory_description=''', 'I', 1, '2010-08-02 16:57:41', 0, 'S', 'admin', 985, '127.0.0.1', 'workflowtransactionhistory_id', ''),
('sim_workflowtransaction', 'workflowtransaction_datetime=''10/08/02 16:57:51''target_groupid=''1''target_uid=''0''targetparameter_name=''''workflowstatus_id=''2''workflow_id=''4''tablename=''sim_hr_generalclaim''primarykey_name=''generalclaim_id''primarykey_value=''34''hyperlink=''../hr/generalclaim.php''title_description=''''created=''10/08/02 16:57:51''list_parameter=''''workflowtransaction_description=''Claim for {claim_details}''workflowtransaction_feedback=''''iscomplete=''1''createdby=''1''email_list=''''sms_list=''''email_body=''''sms_body=''''person_id=''19''issubmit=''1', 'I', 1, '2010-08-02 16:57:52', 84, 'S', 'admin', 986, '127.0.0.1', 'workflowtransaction_id', 'sim_hr_generalclaim'),
('sim_workflowtransactionhistory', 'workflowtransaction_id=''84''workflowstatus_id=''2''workflowtransaction_datetime=''10/08/02 16:57:52''uid=''1''workflowtransactionhistory_description=''', 'I', 1, '2010-08-02 16:57:52', 0, 'S', 'admin', 987, '127.0.0.1', 'workflowtransactionhistory_id', '');
INSERT INTO `sim_audit` (`tablename`, `changedesc`, `category`, `uid`, `updated`, `record_id`, `eventype`, `uname`, `audit_id`, `ip`, `primarykey`, `controlvalue`) VALUES
('sim_hr_generalclaim', 'employee_id=''Ali Bin Ahmad(14)''generalclaim_date=''2010-08-09''generalclaim_docno=''''generalclaim_remark=''''period_id=''2010(2)''created=''10/08/02 16:58:09''createdby=''admin(1)''updated=''10/08/02 16:58:09''updatedby=''admin(1)''organization_id=''1', 'I', 1, '2010-08-02 16:58:09', 35, 'S', 'admin', 988, '127.0.0.1', 'generalclaim_id', ''),
('sim_hr_generalclaim', 'employee_id=''14Ali Bin Ahmad'',<br/>issubmit=''1''', 'U', 1, '2010-08-02 16:58:16', 35, 'S', 'admin', 989, '127.0.0.1', 'generalclaim_id', ''),
('sim_workflowtransaction', 'workflowtransaction_datetime=''10/08/02 16:58:16''target_groupid=''1''target_uid=''0''targetparameter_name=''10''workflowstatus_id=''1''workflow_id=''4''tablename=''sim_hr_generalclaim''primarykey_name=''generalclaim_id''primarykey_value=''35''hyperlink=''../hr/generalclaim.php''title_description=''''created=''10/08/02 16:58:16''list_parameter=''''workflowtransaction_description=''Ok done''workflowtransaction_feedback=''''iscomplete=''0''createdby=''1''email_list=''1,10''sms_list=''1,10''email_body=''''sms_body=''''person_id=''14''issubmit=''1', 'I', 1, '2010-08-02 16:58:16', 85, 'S', 'admin', 990, '127.0.0.1', 'workflowtransaction_id', 'sim_hr_generalclaim'),
('sim_workflowtransactionhistory', 'workflowtransaction_id=''85''workflowstatus_id=''1''workflowtransaction_datetime=''10/08/02 16:58:16''uid=''1''workflowtransactionhistory_description=''', 'I', 1, '2010-08-02 16:58:16', 0, 'S', 'admin', 991, '127.0.0.1', 'workflowtransactionhistory_id', ''),
('sim_workflowtransaction', 'workflowtransaction_datetime=''10/08/02 16:58:21''target_groupid=''1''target_uid=''0''targetparameter_name=''1''workflowstatus_id=''5''workflow_id=''4''tablename=''sim_hr_generalclaim''primarykey_name=''generalclaim_id''primarykey_value=''35''hyperlink=''''title_description=''''created=''10/08/02 16:58:21''list_parameter=''''workflowtransaction_description=''''workflowtransaction_feedback=''''iscomplete=''0''createdby=''1''email_list=''''sms_list=''''email_body=''''sms_body=''''person_id=''14''issubmit=''0', 'I', 1, '2010-08-02 16:58:22', 86, 'S', 'admin', 992, '127.0.0.1', 'workflowtransaction_id', 'sim_hr_generalclaim'),
('sim_workflowtransactionhistory', 'workflowtransaction_id=''86''workflowstatus_id=''5''workflowtransaction_datetime=''10/08/02 16:58:22''uid=''1''workflowtransactionhistory_description=''', 'I', 1, '2010-08-02 16:58:22', 0, 'S', 'admin', 993, '127.0.0.1', 'workflowtransactionhistory_id', ''),
('sim_workflownode', 'target_uid='''',<br/>workflow_sql='',issubmit=1,iscomplete=1''', 'U', 0, '2010-08-02 16:59:20', 33, 'S', '', 994, '127.0.0.1', 'workflownode_id', '10'),
('sim_workflownode', 'target_uid='''',<br/>workflow_sql='',issubmit=0,iscomplete=0''', 'U', 0, '2010-08-02 16:59:47', 38, 'S', '', 995, '127.0.0.1', 'workflownode_id', '10'),
('sim_workflownode', 'target_uid='''',<br/>workflow_sql='',issubmit=0,iscomplete=0''', 'U', 0, '2010-08-02 17:00:23', 36, 'S', '', 996, '127.0.0.1', 'workflownode_id', '10'),
('sim_workflownode', 'target_uid='''',<br/>workflow_procedure='''',<br/>hyperlink=''../hr/travellingclaim.php''', 'U', 0, '2010-08-02 17:01:06', 32, 'S', '', 997, '127.0.0.1', 'workflownode_id', '10'),
('sim_workflownode', 'target_uid='''',<br/>issubmit_node=''0''', 'U', 0, '2010-08-02 17:01:17', 35, 'S', '', 998, '127.0.0.1', 'workflownode_id', '10'),
('sim_workflownode', 'target_uid='''',<br/>issubmit_node=''0''', 'U', 0, '2010-08-02 17:01:30', 24, 'S', '', 999, '127.0.0.1', 'workflownode_id', '10'),
('sim_workflownode', 'target_uid=''''', 'U', 0, '2010-08-02 17:01:34', 24, 'S', '', 1000, '127.0.0.1', 'workflownode_id', '10'),
('sim_workflownode', 'target_uid=''''', 'U', 0, '2010-08-02 17:01:39', 24, 'S', '', 1001, '127.0.0.1', 'workflownode_id', '10'),
('sim_workflownode', 'target_uid='''',<br/>hyperlink=''../hr/leaveadjustment.php''', 'U', 0, '2010-08-02 17:02:09', 21, 'S', '', 1002, '127.0.0.1', 'workflownode_id', '10'),
('sim_workflownode', 'target_uid='''',<br/>hyperlink=''../hr/leaveadjustment.php''', 'U', 0, '2010-08-02 17:02:27', 22, 'S', '', 1003, '127.0.0.1', 'workflownode_id', '10'),
('sim_workflownode', 'target_uid='''',<br/>issms=''0'',<br/>hyperlink=''../hr/leaveadjustment.php''', 'U', 0, '2010-08-02 17:02:37', 24, 'S', '', 1004, '127.0.0.1', 'workflownode_id', '10'),
('sim_workflownode', 'target_uid='''',<br/>issms=''1''', 'U', 0, '2010-08-02 17:02:42', 24, 'S', '', 1005, '127.0.0.1', 'workflownode_id', '10'),
('sim_workflownode', 'target_uid='''',<br/>issms=''0''', 'U', 0, '2010-08-02 17:02:52', 24, 'S', '', 1006, '127.0.0.1', 'workflownode_id', '10'),
('sim_workflownode', 'target_uid=''''', 'U', 0, '2010-08-02 17:03:29', 38, 'S', '', 1007, '127.0.0.1', 'workflownode_id', '10'),
('sim_hr_generalclaim', 'employee_id=''14Ali Bin Ahmad'',<br/>issubmit=''1''', 'U', 1, '2010-08-02 17:04:21', 35, 'S', 'admin', 1008, '127.0.0.1', 'generalclaim_id', ''),
('sim_workflowtransaction', 'workflowtransaction_datetime=''10/08/02 17:04:21''target_groupid=''1''target_uid=''0''targetparameter_name=''10''workflowstatus_id=''1''workflow_id=''4''tablename=''sim_hr_generalclaim''primarykey_name=''generalclaim_id''primarykey_value=''35''hyperlink=''../hr/generalclaim.php''title_description=''''created=''10/08/02 17:04:21''list_parameter=''''workflowtransaction_description=''Ok done''workflowtransaction_feedback=''''iscomplete=''0''createdby=''1''email_list=''1,10''sms_list=''1,10''email_body=''''sms_body=''''person_id=''14''issubmit=''1', 'I', 1, '2010-08-02 17:04:21', 87, 'S', 'admin', 1009, '127.0.0.1', 'workflowtransaction_id', 'sim_hr_generalclaim'),
('sim_workflowtransactionhistory', 'workflowtransaction_id=''87''workflowstatus_id=''1''workflowtransaction_datetime=''10/08/02 17:04:21''uid=''1''workflowtransactionhistory_description=''', 'I', 1, '2010-08-02 17:04:21', 0, 'S', 'admin', 1010, '127.0.0.1', 'workflowtransactionhistory_id', ''),
('sim_hr_employeegroup', 'employeegroup_no=''''employeegroup_name=''''islecturer=''1''isovertime=''1''isparttime=''1''isactive=''1''seqno=''10''created=''2010-08-02 17:08:10''createdby=''1''updated=''2010-08-02 17:08:10''updatedby=''1''organization_id=''1''description=''', 'I', 1, '2010-08-02 17:08:10', 23, 'S', 'admin', 1011, '127.0.0.1', 'employeegroup_id', ''),
('sim_hr_employeegroup', 'Record deleted permanentl', 'E', 1, '2010-08-02 17:08:17', 23, 'S', 'admin', 1012, '127.0.0.1', 'employeegroup_id', ''),
('sim_hr_department', 'department_no=''MIS''department_name=''Management Information System''seqno=''10''description=''''department_parent=''0''isactive=''1''created=''2010-08-02 17:14:04''createdby=''1''updated=''2010-08-02 17:14:04''updatedby=''1''organization_id=''1''department_head=''19', 'I', 1, '2010-08-02 17:14:04', 4, 'S', 'admin', 1013, '192.168.1.203', 'department_id', 'Management Information System'),
('sim_hr_employeegroup', 'employeegroup_no=''EW''employeegroup_name=''WE''islecturer=''1''isovertime=''1''isparttime=''1''isactive=''1''seqno=''10''created=''2010-08-02 17:16:10''createdby=''1''updated=''2010-08-02 17:16:10''updatedby=''1''organization_id=''1''description=''', 'I', 1, '2010-08-02 17:16:10', 24, 'S', 'admin', 1014, '127.0.0.1', 'employeegroup_id', 'EW'),
('sim_hr_employeegroup', 'employeegroup_no=''''employeegroup_name=''''islecturer=''1''isovertime=''1''isparttime=''1''isactive=''1''seqno=''10''created=''2010-08-02 17:19:10''createdby=''1''updated=''2010-08-02 17:19:10''updatedby=''1''organization_id=''1''description=''', 'I', 1, '2010-08-02 17:19:10', 25, 'S', 'admin', 1015, '127.0.0.1', 'employeegroup_id', ''),
('sim_hr_employeegroup', 'employeegroup_no=''DF'',<br/>employeegroup_name=''WEDF''', 'U', 1, '2010-08-02 17:20:03', 25, 'S', 'admin', 1016, '127.0.0.1', 'employeegroup_id', 'DF'),
('sim_hr_employeegroup', 'employeegroup_name=''WE''', 'U', 1, '2010-08-02 17:21:53', 25, 'F', 'admin', 1017, '127.0.0.1', 'employeegroup_id', 'DF'),
('sim_hr_employeegroup', 'employeegroup_name=''we''', 'U', 1, '2010-08-02 17:22:03', 25, 'F', 'admin', 1018, '127.0.0.1', 'employeegroup_id', 'DF'),
('sim_hr_department', 'department_no=''STK''department_name=''Stock''seqno=''10''description=''''department_parent=''3''isactive=''1''created=''2010-08-02 17:22:11''createdby=''1''updated=''2010-08-02 17:22:11''updatedby=''1''organization_id=''1''department_head=''0', 'I', 1, '2010-08-02 17:22:11', 5, 'S', 'admin', 1019, '192.168.1.203', 'department_id', 'Stock'),
('sim_hr_department', 'department_no=''HR'',<br/>department_name=''Human Resource'',<br/>organization_id=''1''', 'U', 1, '2010-08-02 17:22:19', 2, 'S', 'admin', 1020, '192.168.1.203', 'department_id', 'Human Resource'),
('sim_hr_department', 'department_no=''RC''department_name=''Recruitment''seqno=''10''description=''''department_parent=''2''isactive=''1''created=''2010-08-02 17:22:29''createdby=''1''updated=''2010-08-02 17:22:29''updatedby=''1''organization_id=''1''department_head=''0', 'I', 1, '2010-08-02 17:22:29', 6, 'S', 'admin', 1021, '192.168.1.203', 'department_id', 'Recruitment'),
('sim_hr_department', 'department_no=''TRN''department_name=''Training''seqno=''10''description=''''department_parent=''2''isactive=''1''created=''2010-08-02 17:22:42''createdby=''1''updated=''2010-08-02 17:22:42''updatedby=''1''organization_id=''1''department_head=''0', 'I', 1, '2010-08-02 17:22:42', 7, 'S', 'admin', 1022, '192.168.1.203', 'department_id', 'Training'),
('sim_hr_department', 'department_no=''TRP''department_name=''Transport''seqno=''10''description=''''department_parent=''3''isactive=''1''created=''2010-08-02 17:22:48''createdby=''1''updated=''2010-08-02 17:22:48''updatedby=''1''organization_id=''1''department_head=''0', 'I', 1, '2010-08-02 17:22:48', 8, 'S', 'admin', 1023, '192.168.1.203', 'department_id', 'Transport'),
('sim_hr_overtimeclaim', 'employee_id=''A-Tester(16)''overtimeclaim_date=''2010-08-30''overtimeclaim_docno=''''overtimeclaim_remark=''''created=''10/08/02 17:23:08''createdby=''admin(1)''updated=''10/08/02 17:23:08''updatedby=''admin(1)''organization_id=''1', 'I', 1, '2010-08-02 17:23:08', 15, 'S', 'admin', 1024, '127.0.0.1', 'overtimeclaim_id', ''),
('sim_hr_department', 'department_no=''Sales''department_name=''Sales''seqno=''10''description=''''department_parent=''0''isactive=''1''created=''2010-08-02 17:23:10''createdby=''1''updated=''2010-08-02 17:23:10''updatedby=''1''organization_id=''1''department_head=''0', 'I', 1, '2010-08-02 17:23:10', 9, 'S', 'admin', 1025, '192.168.1.203', 'department_id', 'Sales'),
('sim_hr_overtimeclaim', 'issubmit=''1''', 'U', 1, '2010-08-02 17:23:14', 15, 'S', 'admin', 1026, '127.0.0.1', 'overtimeclaim_id', ''),
('sim_workflowtransaction', 'workflowtransaction_datetime=''10/08/02 17:23:14''target_groupid=''1''target_uid=''0''targetparameter_name=''10''workflowstatus_id=''1''workflow_id=''9''tablename=''sim_hr_overtimeclaim''primarykey_name=''overtimeclaim_id''primarykey_value=''15''hyperlink=''../hr/overtimeclaim.php''title_description=''''created=''10/08/02 17:23:14''list_parameter=''''workflowtransaction_description=''''workflowtransaction_feedback=''''iscomplete=''0''createdby=''1''email_list=''1,10''sms_list=''1,10''email_body=''''sms_body=''''person_id=''16''issubmit=''1', 'I', 1, '2010-08-02 17:23:14', 88, 'S', 'admin', 1027, '127.0.0.1', 'workflowtransaction_id', 'sim_hr_overtimeclaim'),
('sim_workflowtransactionhistory', 'workflowtransaction_id=''88''workflowstatus_id=''1''workflowtransaction_datetime=''10/08/02 17:23:14''uid=''1''workflowtransactionhistory_description=''', 'I', 1, '2010-08-02 17:23:14', 0, 'S', 'admin', 1028, '127.0.0.1', 'workflowtransactionhistory_id', ''),
('sim_hr_employeegroup', 'employeegroup_no=''FD''employeegroup_name=''SD''islecturer=''1''isovertime=''1''isparttime=''1''isactive=''1''seqno=''10''created=''2010-08-02 17:39:03''createdby=''1''updated=''2010-08-02 17:39:03''updatedby=''1''organization_id=''1''description=''', 'I', 1, '2010-08-02 17:39:03', 26, 'S', 'admin', 1029, '127.0.0.1', 'employeegroup_id', 'FD'),
('sim_hr_trainingtype', 'trainingtype_name=''''isactive=''1''seqno=''10''created=''2010-08-02 17:42:05''createdby=''1''updated=''2010-08-02 17:42:05''updatedby=''1''organization_id=''1''description=''', 'I', 1, '2010-08-02 17:42:05', 18, 'S', 'admin', 1030, '127.0.0.1', 'trainingtype_id', ''),
('sim_hr_jobposition', 'jobposition_no=''FD''jobposition_name=''ER''isactive=''1''seqno=''10''created=''2010-08-02 17:48:02''createdby=''1''updated=''2010-08-02 17:48:02''updatedby=''1''organization_id=''1''description=''', 'I', 1, '2010-08-02 17:48:02', 59, 'S', 'admin', 1031, '127.0.0.1', 'jobposition_id', 'FD'),
('sim_hr_jobposition', 'jobposition_name=''FDD''', 'U', 1, '2010-08-02 17:48:18', 56, 'S', 'admin', 1032, '127.0.0.1', 'jobposition_id', '31'),
('sim_hr_jobposition', 'jobposition_no=''DS''', 'U', 1, '2010-08-02 17:48:18', 58, 'S', 'admin', 1033, '127.0.0.1', 'jobposition_id', 'DS'),
('sim_hr_qualificationline', 'qualification_type=''''qualification_name=''''qualification_institution=''''qualification_month=''1900-01-01''created=''2010-08-02 17:48:52''createdby=''1''updated=''2010-08-02 17:48:52''updatedby=''1''employee_id=''19', 'I', 1, '2010-08-02 17:48:52', 20, 'S', 'admin', 1034, '127.0.0.1', 'qualification_id', ''),
('sim_hr_qualificationline', 'qualification_type=''3''', 'U', 1, '2010-08-02 17:53:23', 20, 'S', 'admin', 1035, '127.0.0.1', 'qualification_id', ''),
('sim_workflowtransaction', 'workflowtransaction_datetime=''10/08/02 18:01:13''target_groupid=''1''target_uid=''0''targetparameter_name=''''workflowstatus_id=''2''workflow_id=''4''tablename=''sim_hr_generalclaim''primarykey_name=''generalclaim_id''primarykey_value=''33''hyperlink=''../hr/generalclaim.php''title_description=''''created=''10/08/02 18:01:13''list_parameter=''''workflowtransaction_description=''Claim for {claim_details}''workflowtransaction_feedback=''hi hi''iscomplete=''1''createdby=''1''email_list=''''sms_list=''''email_body=''''sms_body=''''person_id=''19''issubmit=''1', 'I', 1, '2010-08-02 18:01:13', 89, 'S', '', 1036, '192.168.1.201', 'workflowtransaction_id', 'sim_hr_generalclaim'),
('sim_workflowtransactionhistory', 'workflowtransaction_id=''89''workflowstatus_id=''2''workflowtransaction_datetime=''10/08/02 18:01:13''uid=''1''workflowtransactionhistory_description=''', 'I', 1, '2010-08-02 18:01:13', 0, 'S', '', 1037, '192.168.1.201', 'workflowtransactionhistory_id', ''),
('sim_workflowtransaction', 'workflowtransaction_datetime=''10/08/02 18:03:45''target_groupid=''''target_uid=''''targetparameter_name=''''workflowstatus_id=''''workflow_id=''''tablename=''sim_hr_generalclaim''primarykey_name=''generalclaim_id''primarykey_value=''31''hyperlink=''''title_description=''''created=''10/08/02 18:03:45''list_parameter=''''workflowtransaction_description=''''workflowtransaction_feedback=''Please check email.''iscomplete=''''createdby=''1''email_list=''''sms_list=''''email_body=''''sms_body=''''person_id=''14''issubmit=''', 'I', 1, '2010-08-02 18:03:45', 90, 'S', '', 1038, '192.168.1.201', 'workflowtransaction_id', 'sim_hr_generalclaim'),
('sim_workflowtransactionhistory', 'workflowtransaction_id=''90''workflowstatus_id=''''workflowtransaction_datetime=''10/08/02 18:03:45''uid=''1''workflowtransactionhistory_description=''', 'I', 1, '2010-08-02 18:03:45', 0, 'S', '', 1039, '192.168.1.201', 'workflowtransactionhistory_id', ''),
('sim_workflowtransaction', 'workflowtransaction_datetime=''10/08/02 18:07:08''target_groupid=''1''target_uid=''0''targetparameter_name=''''workflowstatus_id=''2''workflow_id=''9''tablename=''sim_hr_overtimeclaim''primarykey_name=''overtimeclaim_id''primarykey_value=''15''hyperlink=''../hr/overtimeclaim.php''title_description=''''created=''10/08/02 18:07:08''list_parameter=''''workflowtransaction_description=''''workflowtransaction_feedback=''''iscomplete=''1''createdby=''1''email_list=''''sms_list=''''email_body=''''sms_body=''''person_id=''16''issubmit=''1', 'I', 1, '2010-08-02 18:07:08', 91, 'S', '', 1040, '192.168.1.201', 'workflowtransaction_id', 'sim_hr_overtimeclaim'),
('sim_workflowtransactionhistory', 'workflowtransaction_id=''91''workflowstatus_id=''2''workflowtransaction_datetime=''10/08/02 18:07:08''uid=''1''workflowtransactionhistory_description=''', 'I', 1, '2010-08-02 18:07:08', 0, 'S', '', 1041, '192.168.1.201', 'workflowtransactionhistory_id', ''),
('sim_hr_trainingtype', 'trainingtype_name=''Update''', 'U', 1, '2010-08-02 18:23:34', 18, 'F', 'admin', 1042, '127.0.0.1', 'trainingtype_id', 'Update'),
('sim_hr_trainingtype', 'trainingtype_name=''DS''', 'U', 1, '2010-08-02 18:23:44', 18, 'S', 'admin', 1043, '127.0.0.1', 'trainingtype_id', 'DS'),
('sim_workflownode', 'Record deleted permanentl', 'E', 0, '2010-08-02 18:34:22', 14, 'S', '', 1044, '127.0.0.1', 'workflownode_id', '5'),
('sim_workflownode', 'Record deleted permanentl', 'E', 0, '2010-08-02 18:34:34', 16, 'S', '', 1045, '127.0.0.1', 'workflownode_id', '3'),
('sim_workflownode', 'Record deleted permanentl', 'E', 0, '2010-08-02 18:34:45', 15, 'S', '', 1046, '127.0.0.1', 'workflownode_id', '5'),
('sim_workflownode', 'Record deleted permanentl', 'E', 0, '2010-08-02 18:34:56', 17, 'S', '', 1047, '127.0.0.1', 'workflownode_id', '3'),
('sim_workflownode', 'target_uid='''',<br/>targetparameter_name=''{hod_uid}''', 'U', 0, '2010-08-02 18:35:48', 11, 'S', '', 1048, '127.0.0.1', 'workflownode_id', '10'),
('sim_workflownode', 'target_uid='''',<br/>iscomplete_node=''1''', 'U', 0, '2010-08-02 18:35:54', 11, 'S', '', 1049, '127.0.0.1', 'workflownode_id', '10'),
('sim_workflownode', 'target_groupid=''1'',<br/>target_uid='''',<br/>targetparameter_name=''{hod_uid}'',<br/>iscomplete_node=''1''', 'U', 0, '2010-08-02 18:36:07', 12, 'S', '', 1050, '127.0.0.1', 'workflownode_id', '10'),
('sim_workflownode', 'target_groupid=''1'',<br/>target_uid='''',<br/>issubmit_node=''0''', 'U', 0, '2010-08-02 18:36:50', 13, 'S', '', 1051, '127.0.0.1', 'workflownode_id', '10'),
('sim_workflownode', 'target_uid='''',<br/>targetparameter_name=''{hod_uid}'',<br/>email_list=''{hod_uid}'',<br/>sms_list=''{hod_uid}''', 'U', 0, '2010-08-02 18:37:12', 19, 'S', '', 1052, '127.0.0.1', 'workflownode_id', '10'),
('sim_workflownode', 'target_uid='''',<br/>targetparameter_name=''{hod_uid}'',<br/>email_list=''{hod_uid}'',<br/>sms_list=''{hod_uid}''', 'U', 0, '2010-08-02 18:37:35', 20, 'S', '', 1053, '127.0.0.1', 'workflownode_id', '10'),
('sim_workflownode', 'target_uid='''',<br/>targetparameter_name=''{hod_uid}'',<br/>email_list=''{hod_uid}'',<br/>sms_list=''{hod_uid}''', 'U', 0, '2010-08-02 18:37:46', 21, 'S', '', 1054, '127.0.0.1', 'workflownode_id', '10'),
('sim_workflownode', 'target_uid='''',<br/>targetparameter_name=''{hod_uid}'',<br/>email_list=''{hod_uid}'',<br/>sms_list=''{hod_uid}''', 'U', 0, '2010-08-02 18:37:54', 22, 'S', '', 1055, '127.0.0.1', 'workflownode_id', '10'),
('sim_workflownode', 'target_uid='''',<br/>targetparameter_name=''{hod_uid}'',<br/>email_list=''{hod_uid}'',<br/>sms_list=''{hod_uid}''', 'U', 0, '2010-08-02 18:38:06', 23, 'S', '', 1056, '127.0.0.1', 'workflownode_id', '10'),
('sim_workflownode', 'target_uid='''',<br/>targetparameter_name=''{hod_uid}'',<br/>email_list=''{hod_uid}'',<br/>sms_list=''{hod_uid}''', 'U', 0, '2010-08-02 18:38:20', 26, 'S', '', 1057, '127.0.0.1', 'workflownode_id', '10'),
('sim_workflownode', 'target_uid='''',<br/>targetparameter_name=''{hod_uid}'',<br/>email_list=''{hod_uid}'',<br/>sms_list=''{hod_uid}''', 'U', 0, '2010-08-02 18:38:47', 33, 'S', '', 1058, '127.0.0.1', 'workflownode_id', '10'),
('sim_workflownode', 'target_uid='''',<br/>targetparameter_name=''{hod_uid}'',<br/>email_list=''{hod_uid}'',<br/>sms_list=''{hod_uid}''', 'U', 0, '2010-08-02 18:39:02', 28, 'S', '', 1059, '127.0.0.1', 'workflownode_id', '10'),
('sim_workflownode', 'target_uid='''',<br/>targetparameter_name=''{hod_uid}'',<br/>email_list=''{hod_uid}''', 'U', 0, '2010-08-02 18:39:16', 29, 'S', '', 1060, '127.0.0.1', 'workflownode_id', '10'),
('sim_workflownode', 'target_uid='''',<br/>targetparameter_name=''{hod_uid}'',<br/>email_list=''{hod_uid}'',<br/>sms_list=''{hod_uid}''', 'U', 0, '2010-08-02 18:39:37', 31, 'S', '', 1061, '127.0.0.1', 'workflownode_id', '10'),
('sim_workflownode', 'target_uid='''',<br/>targetparameter_name=''{hod_uid}'',<br/>email_list=''{hod_uid}'',<br/>sms_list=''{hod_uid}''', 'U', 0, '2010-08-02 18:40:25', 32, 'S', '', 1062, '127.0.0.1', 'workflownode_id', '10'),
('sim_hr_employeegroup', 'Record deleted permanentl', 'E', 1, '2010-08-02 19:16:21', 10, 'F', 'admin', 1063, '127.0.0.1', 'employeegroup_id', 'LP'),
('sim_hr_employeegroup', 'Record deleted permanentl', 'E', 1, '2010-08-02 19:20:07', 10, 'F', 'admin', 1064, '127.0.0.1', 'employeegroup_id', 'LP'),
('sim_hr_employeegroup', 'Record deleted permanentl', 'E', 1, '2010-08-02 19:20:34', 10, 'F', 'admin', 1065, '127.0.0.1', 'employeegroup_id', 'LP'),
('sim_hr_employeegroup', 'employeegroup_no=''ER''employeegroup_name=''FD''islecturer=''''isovertime=''1''isparttime=''1''isactive=''1''seqno=''10''created=''2010-08-02 20:41:24''createdby=''1''updated=''2010-08-02 20:41:24''updatedby=''1''organization_id=''1''description=''DFDD', 'I', 1, '2010-08-02 20:41:24', 27, 'S', 'admin', 1066, '::1', 'employeegroup_id', 'ER'),
('sim_hr_employeegroup', 'employeegroup_name=''FDD'',<br/>isovertime=''0'',<br/>isparttime=''0'',<br/>isactive=''0'',<br/>description=''DFDDssss''', 'U', 1, '2010-08-02 20:41:48', 27, 'S', 'admin', 1067, '::1', 'employeegroup_id', 'ER'),
('sim_hr_employeegroup', 'Record deleted permanentl', 'E', 1, '2010-08-02 20:42:03', 27, 'S', 'admin', 1068, '::1', 'employeegroup_id', 'ER'),
('sim_hr_trainingtype', 'Record deleted permanentl', 'E', 1, '2010-08-02 20:42:59', 12, 'S', 'admin', 1069, '::1', 'trainingtype_id', 'Repair'),
('sim_hr_trainingtype', 'Record deleted permanentl', 'E', 1, '2010-08-02 20:43:03', 11, 'S', 'admin', 1070, '::1', 'trainingtype_id', 'Update'),
('sim_hr_trainingtype', 'Record deleted permanentl', 'E', 1, '2010-08-02 20:43:06', 10, 'S', 'admin', 1071, '::1', 'trainingtype_id', 'Maintain Skill'),
('sim_hr_trainingtype', 'Record deleted permanentl', 'E', 1, '2010-08-02 20:47:33', 18, 'F', 'admin', 1072, '::1', 'trainingtype_id', 'DS'),
('sim_hr_employeegroup', 'Record deleted permanentl', 'E', 1, '2010-08-02 20:48:32', 10, 'F', 'admin', 1073, '::1', 'employeegroup_id', 'LP'),
('sim_hr_trainingtype', 'Record deleted permanentl', 'E', 1, '2010-08-02 20:48:39', 18, 'F', 'admin', 1074, '::1', 'trainingtype_id', 'DS'),
('sim_hr_jobposition', 'Record deleted permanentl', 'E', 1, '2010-08-02 20:51:48', 53, 'F', 'admin', 1075, '::1', 'jobposition_id', '12Sd1'),
('sim_hr_disciplineline', 'disciplineline_date=''1900-01-01''disciplinetype_id=''14''employee_id=''19''disciplineline_name=''''disciplineline_remarks=''''created=''2010-08-02 20:52:42''createdby=''1''updated=''2010-08-02 20:52:42''updatedby=''1', 'I', 1, '2010-08-02 20:52:42', 14, 'S', 'admin', 1076, '::1', 'disciplinetype_id', ''),
('sim_hr_disciplinetype', 'Record deleted permanentl', 'E', 1, '2010-08-02 20:52:57', 14, 'S', 'admin', 1077, '::1', 'disciplinetype_id', 'Chating'),
('sim_hr_jobposition', 'Record deleted permanentl', 'E', 1, '2010-08-02 21:05:36', 53, 'F', 'admin', 1078, '::1', 'jobposition_id', '12Sd1'),
('sim_hr_trainingtype', 'Record deleted permanentl', 'E', 1, '2010-08-02 21:18:32', 18, 'F', 'admin', 1079, '::1', 'trainingtype_id', 'DS'),
('sim_hr_disciplineline', 'disciplineline_date=''1900-01-01''disciplinetype_id=''''employee_id=''19''disciplineline_name=''''disciplineline_remarks=''''created=''2010-08-02 21:19:04''createdby=''1''updated=''2010-08-02 21:19:04''updatedby=''1', 'I', 1, '2010-08-02 21:19:04', 15, 'S', 'admin', 1080, '::1', 'disciplinetype_id', ''),
('sim_hr_disciplineline', 'disciplinetype_id=''16''', 'U', 1, '2010-08-02 21:19:55', 2, 'S', 'admin', 1081, '::1', 'disciplineline_id', ''),
('sim_hr_disciplinetype', 'Record deleted permanentl', 'E', 1, '2010-08-02 21:20:06', 16, 'F', 'admin', 1082, '::1', 'disciplinetype_id', 'Gumming'),
('sim_hr_leaveadjustment', 'adjustment_for=''Annul Leave(8)''created=''10/08/02 21:21:23''createdby=''admin(1)''updated=''10/08/02 21:21:23''updatedby=''admin(1)''organization_id=''1', 'I', 1, '2010-08-02 21:21:23', 1, 'S', 'admin', 1083, '::1', 'leaveadjustment_id', 'admin'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''1''employee_id=''23''leavetype_id=''8''leaveadjustmentline_totalday=''1''created=''2010-08-02 21:21:23''createdby=''1''updated=''2010-08-02 21:21:23''updatedby=''1', 'I', 1, '2010-08-02 21:21:24', 114, 'S', 'admin', 1084, '::1', 'leaveadjustmentline_id', '1'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''1''employee_id=''16''leavetype_id=''8''leaveadjustmentline_totalday=''1''created=''2010-08-02 21:21:23''createdby=''1''updated=''2010-08-02 21:21:23''updatedby=''1', 'I', 1, '2010-08-02 21:21:24', 115, 'S', 'admin', 1085, '::1', 'leaveadjustmentline_id', '1'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''1''employee_id=''14''leavetype_id=''8''leaveadjustmentline_totalday=''1''created=''2010-08-02 21:21:23''createdby=''1''updated=''2010-08-02 21:21:23''updatedby=''1', 'I', 1, '2010-08-02 21:21:24', 116, 'S', 'admin', 1086, '::1', 'leaveadjustmentline_id', '1'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''1''employee_id=''17''leavetype_id=''8''leaveadjustmentline_totalday=''1''created=''2010-08-02 21:21:23''createdby=''1''updated=''2010-08-02 21:21:23''updatedby=''1', 'I', 1, '2010-08-02 21:21:24', 117, 'S', 'admin', 1087, '::1', 'leaveadjustmentline_id', '1'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''1''employee_id=''22''leavetype_id=''8''leaveadjustmentline_totalday=''1''created=''2010-08-02 21:21:23''createdby=''1''updated=''2010-08-02 21:21:23''updatedby=''1', 'I', 1, '2010-08-02 21:21:24', 118, 'S', 'admin', 1088, '::1', 'leaveadjustmentline_id', '1'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''1''employee_id=''21''leavetype_id=''8''leaveadjustmentline_totalday=''1''created=''2010-08-02 21:21:23''createdby=''1''updated=''2010-08-02 21:21:23''updatedby=''1', 'I', 1, '2010-08-02 21:21:24', 119, 'S', 'admin', 1089, '::1', 'leaveadjustmentline_id', '1'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''1''employee_id=''18''leavetype_id=''8''leaveadjustmentline_totalday=''1''created=''2010-08-02 21:21:23''createdby=''1''updated=''2010-08-02 21:21:23''updatedby=''1', 'I', 1, '2010-08-02 21:21:24', 120, 'S', 'admin', 1090, '::1', 'leaveadjustmentline_id', '1'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''1''employee_id=''19''leavetype_id=''8''leaveadjustmentline_totalday=''1''created=''2010-08-02 21:21:23''createdby=''1''updated=''2010-08-02 21:21:23''updatedby=''1', 'I', 1, '2010-08-02 21:21:24', 121, 'S', 'admin', 1091, '::1', 'leaveadjustmentline_id', '1'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''1''employee_id=''33''leavetype_id=''8''leaveadjustmentline_totalday=''1''created=''2010-08-02 21:21:23''createdby=''1''updated=''2010-08-02 21:21:23''updatedby=''1', 'I', 1, '2010-08-02 21:21:24', 122, 'S', 'admin', 1092, '::1', 'leaveadjustmentline_id', '1'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''1''employee_id=''24''leavetype_id=''8''leaveadjustmentline_totalday=''1''created=''2010-08-02 21:21:23''createdby=''1''updated=''2010-08-02 21:21:23''updatedby=''1', 'I', 1, '2010-08-02 21:21:24', 123, 'S', 'admin', 1093, '::1', 'leaveadjustmentline_id', '1'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''1''employee_id=''30''leavetype_id=''8''leaveadjustmentline_totalday=''1''created=''2010-08-02 21:21:23''createdby=''1''updated=''2010-08-02 21:21:23''updatedby=''1', 'I', 1, '2010-08-02 21:21:25', 124, 'S', 'admin', 1094, '::1', 'leaveadjustmentline_id', '1'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''1''employee_id=''15''leavetype_id=''8''leaveadjustmentline_totalday=''1''created=''2010-08-02 21:21:23''createdby=''1''updated=''2010-08-02 21:21:23''updatedby=''1', 'I', 1, '2010-08-02 21:21:25', 125, 'S', 'admin', 1095, '::1', 'leaveadjustmentline_id', '1'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''1''employee_id=''20''leavetype_id=''8''leaveadjustmentline_totalday=''1''created=''2010-08-02 21:21:23''createdby=''1''updated=''2010-08-02 21:21:23''updatedby=''1', 'I', 1, '2010-08-02 21:21:25', 126, 'S', 'admin', 1096, '::1', 'leaveadjustmentline_id', '1'),
('sim_hr_leavetype', 'Record deleted permanentl', 'E', 1, '2010-08-02 21:22:08', 8, 'F', 'admin', 1097, '::1', 'leavetype_id', 'Annul Leave'),
('sim_hr_leavetype', 'leavetype_name=''DS''isactive=''1''isvalidate=''1''seqno=''10''created=''2010-08-02 21:22:15''createdby=''1''updated=''2010-08-02 21:22:15''updatedby=''1''organization_id=''1''description=''', 'I', 1, '2010-08-02 21:22:15', 16, 'S', 'admin', 1098, '::1', 'leavetype_id', 'DS'),
('sim_hr_leavetype', 'isvalidate=''0''', 'U', 1, '2010-08-02 21:22:19', 16, 'S', 'admin', 1099, '::1', 'leavetype_id', 'DS'),
('sim_hr_leave', 'leave_no=''''leave_date=''2010-08-02''employee_id=''KS Tan(19)''leave_fromdate=''2010-08-17''leave_todate=''2010-08-18''leave_day=''2''time_from=''08:00:00''time_to=''08:00:00''total_hours=''00:00:00''leave_address=''''leave_telno=''''leavetype_id=''DS(16)''lecturer_remarks=''''description=''''created=''10/08/02 21:22:47''createdby=''1''updated=''10/08/02 21:22:47''updatedby=''1''organization_id=''1''panelclinic_id=''0''table_type=''L', 'I', 1, '2010-08-02 21:22:47', 29, 'S', 'admin', 1100, '::1', 'leave_id', ''),
('sim_hr_leavetype', 'Record deleted permanentl', 'E', 1, '2010-08-02 21:23:33', 16, 'F', 'admin', 1101, '::1', 'leavetype_id', 'DS'),
('sim_hr_employee', 'employee_name=''A1''employee_cardno=''D4''employee_no=''C3''uid=''1868''place_dob=''F6''employee_dob=''2010-08-01''races_id=''0''religion_id=''1''gender=''M''marital_status=''2''employee_citizenship=''2''employee_newicno=''312''employee_oldicno=''123''ic_color=''R''employee_passport=''456''employee_bloodgroup=''G8''department_id=''3''jobposition_id=''53''employeegroup_id=''10''employee_joindate=''2010-08-03''filephoto=''1280755950_photofile.png''updated=''2010-08-02 21:32:30''updatedby=''1''seqno=''''organization_id=''''created=''2010-08-02 21:32:30''createdby=''1''employee_transport=''E5''employee_status=''1''isactive=''1''employee_altname=''B2''ic_placeissue=''FF''employee_passport_placeissue=''654''employee_passport_issuedate=''2010-08-01''employee_passport_expirydate=''2010-08-02''employee_confirmdate=''2010-08-04''employee_enddate=''2010-08-05', 'I', 1, '2010-08-02 21:32:30', 35, 'S', 'admin', 1102, '::1', 'employee_id', 'A1'),
('sim_hr_employee', 'races_id=''1'',<br/>gender=''F'',<br/>seqno='''',<br/>organization_id='''',<br/>employee_status=''2'',<br/>isactive=''''', 'U', 1, '2010-08-02 21:32:55', 35, 'S', 'admin', 1103, '::1', 'employee_id', 'C3'),
('sim_hr_qualificationline', 'qualification_type=''4''qualification_name=''''qualification_institution=''''qualification_month=''1900-01-01''created=''2010-08-02 21:33:43''createdby=''1''updated=''2010-08-02 21:33:43''updatedby=''1''employee_id=''35', 'I', 1, '2010-08-02 21:33:43', 22, 'S', 'admin', 1104, '::1', 'qualification_id', ''),
('sim_hr_employee', 'seqno='''',<br/>organization_id='''',<br/>employee_status=''1'',<br/>isactive=''1''', 'U', 1, '2010-08-02 21:39:21', 35, 'S', 'admin', 1105, '::1', 'employee_id', 'C3'),
('sim_hr_leave', 'leave_no=''''leave_date=''2010-08-02''employee_id=''A1(35)''leave_fromdate=''2010-08-09''leave_todate=''2010-08-10''leave_day=''2''time_from=''08:00:00''time_to=''08:00:00''total_hours=''00:00:00''leave_address=''''leave_telno=''''leavetype_id=''DS(16)''lecturer_remarks=''''description=''''created=''10/08/02 21:39:44''createdby=''1''updated=''10/08/02 21:39:44''updatedby=''1''organization_id=''1''panelclinic_id=''0''table_type=''L', 'I', 1, '2010-08-02 21:39:44', 30, 'S', 'admin', 1106, '::1', 'leave_id', ''),
('sim_hr_employeegroup', 'employeegroup_no=''DS''employeegroup_name=''SSD''islecturer=''''isovertime=''1''isparttime=''1''isactive=''1''seqno=''10''created=''2010-08-02 21:50:53''createdby=''1''updated=''2010-08-02 21:50:53''updatedby=''1''organization_id=''1''description=''', 'I', 1, '2010-08-02 21:50:53', 28, 'S', 'admin', 1107, '::1', 'employeegroup_id', 'DS'),
('sim_hr_employeegroup', 'Record deleted permanentl', 'E', 1, '2010-08-02 21:51:28', 28, 'S', 'admin', 1108, '::1', 'employeegroup_id', 'DS'),
('sim_hr_employee', 'employeegroup_id=''28'',<br/>seqno='''',<br/>organization_id=''''', 'U', 1, '2010-08-02 21:51:38', 35, 'F', 'admin', 1109, '::1', 'employee_id', 'C3'),
('sim_hr_medicalclaim', 'employee_id=''A1(35)''medicalclaim_date=''2010-08-11''medicalclaim_clinic=''sa''medicalclaim_docno=''DS''medicalclaim_amount=''1231''medicalclaim_treatment=''das''medicalclaim_remark=''''period_id=''2010(2)''created=''10/08/02 22:05:50''createdby=''admin(1)''updated=''10/08/02 22:05:50''updatedby=''admin(1)''organization_id=''1', 'I', 1, '2010-08-02 22:05:50', 11, 'S', 'admin', 1110, '::1', 'medicalclaim_id', 'DS'),
('sim_hr_medicalclaim', 'issubmit=''1''', 'U', 1, '2010-08-02 22:05:58', 11, 'S', 'admin', 1111, '::1', 'medicalclaim_id', 'DS'),
('sim_workflowtransaction', 'workflowtransaction_datetime=''10/08/02 22:05:58''target_groupid=''1''target_uid=''0''targetparameter_name=''0,23''workflowstatus_id=''1''workflow_id=''10''tablename=''sim_hr_medicalclaim''primarykey_name=''medicalclaim_id''primarykey_value=''11''hyperlink=''../hr/medicalclaim.php''title_description=''''created=''10/08/02 22:05:58''list_parameter=''''workflowtransaction_description=''''workflowtransaction_feedback=''''iscomplete=''0''createdby=''1''email_list=''1,0,23''sms_list=''1,0,23''email_body=''''sms_body=''''person_id=''35''issubmit=''1', 'I', 1, '2010-08-02 22:05:58', 92, 'S', 'admin', 1112, '::1', 'workflowtransaction_id', 'sim_hr_medicalclaim'),
('sim_workflowtransactionhistory', 'workflowtransaction_id=''92''workflowstatus_id=''1''workflowtransaction_datetime=''10/08/02 22:05:58''uid=''1''workflowtransactionhistory_description=''', 'I', 1, '2010-08-02 22:05:58', 0, 'S', 'admin', 1113, '::1', 'workflowtransactionhistory_id', ''),
('sim_workflowtransaction', 'workflowtransaction_datetime=''10/08/02 22:06:22''target_groupid=''0''target_uid=''0''targetparameter_name=''1''workflowstatus_id=''5''workflow_id=''10''tablename=''sim_hr_medicalclaim''primarykey_name=''medicalclaim_id''primarykey_value=''11''hyperlink=''''title_description=''''created=''10/08/02 22:06:22''list_parameter=''''workflowtransaction_description=''''workflowtransaction_feedback=''''iscomplete=''0''createdby=''1''email_list=''''sms_list=''''email_body=''''sms_body=''''person_id=''35''issubmit=''0', 'I', 1, '2010-08-02 22:06:22', 93, 'S', 'admin', 1114, '::1', 'workflowtransaction_id', 'sim_hr_medicalclaim'),
('sim_workflowtransactionhistory', 'workflowtransaction_id=''93''workflowstatus_id=''5''workflowtransaction_datetime=''10/08/02 22:06:22''uid=''1''workflowtransactionhistory_description=''', 'I', 1, '2010-08-02 22:06:22', 0, 'S', 'admin', 1115, '::1', 'workflowtransactionhistory_id', ''),
('sim_hr_medicalclaim', 'issubmit=''1''', 'U', 1, '2010-08-02 22:06:29', 11, 'S', 'admin', 1116, '::1', 'medicalclaim_id', 'DS'),
('sim_workflowtransaction', 'workflowtransaction_datetime=''10/08/02 22:06:29''target_groupid=''1''target_uid=''0''targetparameter_name=''0,23''workflowstatus_id=''1''workflow_id=''10''tablename=''sim_hr_medicalclaim''primarykey_name=''medicalclaim_id''primarykey_value=''11''hyperlink=''../hr/medicalclaim.php''title_description=''''created=''10/08/02 22:06:29''list_parameter=''''workflowtransaction_description=''''workflowtransaction_feedback=''''iscomplete=''0''createdby=''1''email_list=''1,0,23''sms_list=''1,0,23''email_body=''''sms_body=''''person_id=''35''issubmit=''1', 'I', 1, '2010-08-02 22:06:29', 94, 'S', 'admin', 1117, '::1', 'workflowtransaction_id', 'sim_hr_medicalclaim'),
('sim_workflowtransactionhistory', 'workflowtransaction_id=''94''workflowstatus_id=''1''workflowtransaction_datetime=''10/08/02 22:06:29''uid=''1''workflowtransactionhistory_description=''', 'I', 1, '2010-08-02 22:06:29', 0, 'S', 'admin', 1118, '::1', 'workflowtransactionhistory_id', ''),
('sim_workflowtransaction', 'workflowtransaction_datetime=''10/08/02 22:06:33''target_groupid=''0''target_uid=''0''targetparameter_name=''1''workflowstatus_id=''5''workflow_id=''10''tablename=''sim_hr_medicalclaim''primarykey_name=''medicalclaim_id''primarykey_value=''11''hyperlink=''''title_description=''''created=''10/08/02 22:06:33''list_parameter=''''workflowtransaction_description=''''workflowtransaction_feedback=''''iscomplete=''0''createdby=''1''email_list=''''sms_list=''''email_body=''''sms_body=''''person_id=''35''issubmit=''0', 'I', 1, '2010-08-02 22:06:33', 95, 'S', 'admin', 1119, '::1', 'workflowtransaction_id', 'sim_hr_medicalclaim'),
('sim_workflowtransactionhistory', 'workflowtransaction_id=''95''workflowstatus_id=''5''workflowtransaction_datetime=''10/08/02 22:06:33''uid=''1''workflowtransactionhistory_description=''', 'I', 1, '2010-08-02 22:06:33', 0, 'S', 'admin', 1120, '::1', 'workflowtransactionhistory_id', ''),
('sim_hr_employee', 'seqno='''',<br/>organization_id=''''', 'U', 1, '2010-08-02 22:44:37', 19, 'S', 'admin', 1121, '::1', 'employee_id', 'K001'),
('sim_hr_employee', 'filephoto=''1280760308_photofile19.jpg'',<br/>seqno='''',<br/>organization_id=''''', 'U', 1, '2010-08-02 22:45:08', 19, 'S', 'admin', 1122, '::1', 'employee_id', 'K001'),
('sim_hr_employee', 'employee_name=''dasda''employee_cardno=''''employee_no=''dasdas''uid=''''place_dob=''''employee_dob=''2010-08-10''races_id=''0''religion_id=''1''gender=''M''marital_status=''2''employee_citizenship=''2''employee_newicno=''''employee_oldicno=''''ic_color=''B''employee_passport=''''employee_bloodgroup=''''department_id=''9''jobposition_id=''53''employeegroup_id=''10''employee_joindate=''2010-08-11''filephoto=''''updated=''2010-08-02 22:54:41''updatedby=''1''seqno=''''organization_id=''''created=''2010-08-02 22:54:41''createdby=''1''employee_transport=''''employee_status=''1''isactive=''1''employee_altname=''''ic_placeissue=''''employee_passport_placeissue=''''employee_passport_issuedate=''''employee_passport_expirydate=''''employee_confirmdate=''''employee_enddate=''', 'I', 1, '2010-08-02 22:54:41', 36, 'S', 'admin', 1123, '::1', 'employee_id', 'dasda'),
('sim_hr_employee', 'seqno='''',<br/>organization_id=''''', 'U', 1, '2010-08-02 22:54:53', 36, 'S', 'admin', 1124, '::1', 'employee_id', 'dasdas'),
('sim_hr_employee', 'filephoto=''1280761060_photofile36.jpg'',<br/>seqno='''',<br/>organization_id=''''', 'U', 1, '2010-08-02 22:57:40', 36, 'S', 'admin', 1125, '::1', 'employee_id', 'dasdas'),
('sim_hr_employee', 'seqno='''',<br/>organization_id=''''', 'U', 1, '2010-08-02 22:58:06', 36, 'S', 'admin', 1126, '::1', 'employee_id', 'dasdas'),
('sim_hr_employee', 'seqno='''',<br/>organization_id=''''', 'U', 1, '2010-08-02 22:58:34', 36, 'S', 'admin', 1127, '::1', 'employee_id', 'dasdas'),
('sim_hr_employee', 'seqno='''',<br/>organization_id=''''', 'U', 1, '2010-08-02 23:00:33', 36, 'S', 'admin', 1128, '::1', 'employee_id', 'dasdas'),
('sim_hr_employee', 'seqno='''',<br/>organization_id=''''', 'U', 1, '2010-08-02 23:01:50', 36, 'S', 'admin', 1129, '::1', 'employee_id', 'dasdas'),
('sim_hr_employee', 'filephoto=''1280761357_photofile36.jpg'',<br/>seqno='''',<br/>organization_id=''''', 'U', 1, '2010-08-02 23:02:37', 36, 'S', 'admin', 1130, '::1', 'employee_id', 'dasdas'),
('sim_hr_employee', 'seqno='''',<br/>organization_id=''''', 'U', 1, '2010-08-02 23:03:09', 36, 'S', 'admin', 1131, '::1', 'employee_id', 'dasdas'),
('sim_hr_employee', 'seqno='''',<br/>organization_id=''''', 'U', 1, '2010-08-02 23:03:41', 36, 'S', 'admin', 1132, '::1', 'employee_id', 'dasdas'),
('sim_hr_employee', 'seqno='''',<br/>organization_id=''''', 'U', 1, '2010-08-02 23:04:19', 36, 'S', 'admin', 1133, '::1', 'employee_id', 'dasdas'),
('sim_hr_employee', 'seqno='''',<br/>organization_id=''''', 'U', 1, '2010-08-02 23:05:04', 36, 'S', 'admin', 1134, '::1', 'employee_id', 'dasdas'),
('sim_hr_employee', 'filephoto=''no-photo.jpg'',<br/>seqno='''',<br/>organization_id=''''', 'U', 1, '2010-08-02 23:07:30', 36, 'S', 'admin', 1135, '::1', 'employee_id', 'dasdas'),
('sim_hr_employee', 'filephoto=''1280761677_photofile36.jpg'',<br/>seqno='''',<br/>organization_id=''''', 'U', 1, '2010-08-02 23:07:57', 36, 'S', 'admin', 1136, '::1', 'employee_id', 'dasdas'),
('sim_hr_employee', 'filephoto=''no-photo.jpg'',<br/>seqno='''',<br/>organization_id=''''', 'U', 1, '2010-08-02 23:08:30', 36, 'S', 'admin', 1137, '::1', 'employee_id', 'dasdas'),
('sim_country', 'country_code=''ss''country_name=''ss''isactive=''1''seqno=''10''created=''2010-08-03 08:52:08''createdby=''1''updated=''2010-08-03 08:52:08''updatedby=''1''citizenship=''', 'I', 1, '2010-08-03 08:52:08', 6, 'S', 'admin', 1138, '::1', 'country_id', 'ss'),
('sim_country', 'isdeleted=', 'D', 1, '2010-08-03 08:53:06', 6, 'S', 'admin', 1139, '::1', 'country_id', 'ss'),
('sim_country', 'Record deleted permanentl', 'E', 1, '2010-08-03 08:53:51', 6, 'S', 'admin', 1140, '::1', 'country_id', 'ss'),
('sim_country', 'Record deleted permanentl', 'E', 1, '2010-08-03 08:53:58', 2, 'F', 'admin', 1141, '::1', 'country_id', 'SG'),
('sim_country', 'Record deleted permanentl', 'E', 1, '2010-08-03 08:54:08', 3, 'F', 'admin', 1142, '::1', 'country_id', 'MY'),
('sim_religion', 'religion_description=''DS''religion_name=''sd''isactive=''1''seqno=''10''created=''2010-08-03 09:02:36''createdby=''1''updated=''2010-08-03 09:02:36''updatedby=''1''organization_id=''1', 'I', 1, '2010-08-03 09:02:36', 5, 'S', 'admin', 1143, '127.0.0.1', 'religion_id', 'DS'),
('sim_religion', 'religion_description=''D''religion_name=''Buddhist''isactive=''1''seqno=''10''created=''2010-08-03 09:06:25''createdby=''1''updated=''2010-08-03 09:06:25''updatedby=''1''organization_id=''1', 'I', 1, '2010-08-03 09:06:25', 6, 'S', 'admin', 1144, '127.0.0.1', 'religion_id', 'D'),
('sim_window', 'isactive=''0''', 'U', 0, '2010-08-03 09:34:05', 7, 'S', '', 1145, '127.0.0.1', 'window_id', 'Add/Edit Region'),
('sim_hr_generalclaim', 'employee_id=''A1(35)''generalclaim_date=''2010-08-13''generalclaim_docno=''''generalclaim_remark=''''period_id=''2010(2)''created=''10/08/03 09:46:28''createdby=''admin(1)''updated=''10/08/03 09:46:28''updatedby=''admin(1)''organization_id=''1', 'I', 1, '2010-08-03 09:46:28', 36, 'S', 'admin', 1146, '127.0.0.1', 'generalclaim_id', ''),
('sim_hr_employee', 'filephoto=''no-photo.jpg'',<br/>seqno='''',<br/>organization_id=''''', 'U', 1, '2010-08-03 10:05:39', 33, 'S', 'admin', 1147, '192.168.1.204', 'employee_id', 'J001'),
('sim_hr_employee', 'filephoto=''1280801181_photofile33.jpg'',<br/>seqno='''',<br/>organization_id=''''', 'U', 1, '2010-08-03 10:06:21', 33, 'S', 'admin', 1148, '192.168.1.204', 'employee_id', 'J001'),
('sim_hr_employee', 'filephoto=''no-photo.jpg'',<br/>seqno='''',<br/>organization_id=''''', 'U', 1, '2010-08-03 10:06:57', 33, 'S', 'admin', 1149, '192.168.1.204', 'employee_id', 'J001'),
('sim_hr_employee', 'filephoto=''1280801239_photofile33.png'',<br/>seqno='''',<br/>organization_id=''''', 'U', 1, '2010-08-03 10:07:19', 33, 'S', 'admin', 1150, '192.168.1.204', 'employee_id', 'J001'),
('sim_hr_employee', 'employee_citizenship=''2'',<br/>filephoto=''1280801598_photofile30.jpg'',<br/>seqno='''',<br/>organization_id=''''', 'U', 1, '2010-08-03 10:13:18', 30, 'S', 'admin', 1151, '192.168.1.204', 'employee_id', 'ASDDS'),
('sim_religion', 'religion_description=''AA''religion_name=''AA''isactive=''1''seqno=''10''created=''2010-08-03 10:58:23''createdby=''1''updated=''2010-08-03 10:58:23''updatedby=''1''organization_id=''1', 'I', 1, '2010-08-03 10:58:23', 8, 'S', 'admin', 1152, '127.0.0.1', 'religion_id', 'AA'),
('sim_religion', 'religion_description=''AAs'',<br/>religion_name=''AAdd''', 'U', 1, '2010-08-03 10:58:31', 8, 'S', 'admin', 1153, '127.0.0.1', 'religion_id', 'AAs'),
('sim_religion', 'isactive=''0'',<br/>seqno=''101''', 'U', 1, '2010-08-03 10:58:39', 8, 'S', 'admin', 1154, '127.0.0.1', 'religion_id', 'AAs'),
('sim_religion', 'isactive=''1'',<br/>seqno=''10''', 'U', 1, '2010-08-03 10:58:48', 8, 'S', 'admin', 1155, '127.0.0.1', 'religion_id', 'AAs'),
('sim_religion', 'Record deleted permanentl', 'E', 1, '2010-08-03 10:59:35', 8, 'S', 'admin', 1156, '127.0.0.1', 'religion_id', 'AAs'),
('sim_religion', 'Record deleted permanentl', 'E', 1, '2010-08-03 10:59:47', 2, 'F', 'admin', 1157, '127.0.0.1', 'religion_id', 'C'),
('sim_races', 'races_description=''DS''races_name=''SS''isactive=''1''seqno=''10''created=''2010-08-03 11:00:11''createdby=''1''updated=''2010-08-03 11:00:11''updatedby=''1''organization_id=''1', 'I', 1, '2010-08-03 11:00:11', 6, 'S', 'admin', 1158, '127.0.0.1', 'races_id', 'DS'),
('sim_races', 'races_description=''DSdsds'',<br/>races_name=''SSdsds''', 'U', 1, '2010-08-03 11:00:25', 6, 'S', 'admin', 1159, '127.0.0.1', 'races_id', 'DSdsds'),
('sim_races', 'isdeleted=', 'D', 1, '2010-08-03 11:00:30', 6, 'S', 'admin', 1160, '127.0.0.1', 'races_id', 'DSdsds'),
('sim_races', 'Record deleted permanentl', 'E', 1, '2010-08-03 11:01:11', 6, 'S', 'admin', 1161, '127.0.0.1', 'races_id', 'DSdsds'),
('sim_races', 'races_description=''asda''races_name=''asdas''isactive=''1''seqno=''10''created=''2010-08-03 11:01:17''createdby=''1''updated=''2010-08-03 11:01:17''updatedby=''1''organization_id=''1', 'I', 1, '2010-08-03 11:01:17', 7, 'S', 'admin', 1162, '127.0.0.1', 'races_id', 'asda'),
('sim_races', 'Record deleted permanentl', 'E', 1, '2010-08-03 11:01:21', 7, 'S', 'admin', 1163, '127.0.0.1', 'races_id', 'asda'),
('sim_currency', 'currency_code=''WE''currency_name=''FD''isactive=''1''seqno=''0''created=''2010-08-03 11:05:44''createdby=''1''updated=''2010-08-03 11:05:44''updatedby=''1''country_id=''', 'I', 1, '2010-08-03 11:05:44', 4, 'S', 'admin', 1164, '127.0.0.1', 'currency_id', 'WE'),
('sim_currency', 'country_id=''2''', 'U', 1, '2010-08-03 11:05:52', 4, 'S', 'admin', 1165, '127.0.0.1', 'currency_id', 'WE'),
('sim_currency', 'currency_code=''das''currency_name=''dasd''isactive=''1''seqno=''10''created=''2010-08-03 11:09:24''createdby=''1''updated=''2010-08-03 11:09:24''updatedby=''1''country_id=''3', 'I', 1, '2010-08-03 11:09:24', 5, 'S', 'admin', 1166, '127.0.0.1', 'currency_id', 'das'),
('sim_currency', 'currency_code=''dasdasdas'',<br/>currency_name=''dasddas'',<br/>country_id=''2''', 'U', 1, '2010-08-03 11:09:37', 5, 'S', 'admin', 1167, '127.0.0.1', 'currency_id', 'dasdasdas'),
('sim_currency', 'Record deleted permanentl', 'E', 1, '2010-08-03 11:09:41', 5, 'S', 'admin', 1168, '127.0.0.1', 'currency_id', 'das'),
('sim_period', 'isactive=''0''', 'U', 1, '2010-08-03 11:44:36', 2, 'S', 'admin', 1169, '127.0.0.1', 'period_id', '2010'),
('sim_period', 'period_year=''123''period_name=''1312''isactive=''1''seqno=''10''created=''2010-08-03 11:58:17''createdby=''1''updated=''2010-08-03 11:58:17''updatedby=''1''period_month=''312', 'I', 1, '2010-08-03 11:58:17', 8, 'S', 'admin', 1170, '127.0.0.1', 'period_id', '123'),
('sim_period', 'period_name=''dadas''', 'U', 1, '2010-08-03 11:58:23', 8, 'S', 'admin', 1171, '127.0.0.1', 'period_id', '123'),
('sim_period', 'period_month=''34''', 'U', 1, '2010-08-03 12:01:45', 8, 'S', 'admin', 1172, '127.0.0.1', 'period_id', '123'),
('sim_period', 'period_year=''2010''', 'U', 1, '2010-08-03 12:01:55', 8, 'S', 'admin', 1173, '127.0.0.1', 'period_id', '2010'),
('sim_period', 'period_year=''3''', 'U', 1, '2010-08-03 12:02:03', 2, 'S', 'admin', 1174, '127.0.0.1', 'period_id', '3'),
('sim_period', 'period_year=''2010''', 'U', 1, '2010-08-03 12:02:11', 2, 'S', 'admin', 1175, '127.0.0.1', 'period_id', '2010'),
('sim_period', 'seqno=''12''', 'U', 1, '2010-08-03 12:02:17', 2, 'S', 'admin', 1176, '127.0.0.1', 'period_id', '2010'),
('sim_period', 'period_month=''12''', 'U', 1, '2010-08-03 12:07:53', 8, 'S', 'admin', 1177, '127.0.0.1', 'period_id', '2010'),
('sim_period', 'period_year=''2010''period_name=''rwerw''isactive=''1''seqno=''10''created=''2010-08-03 12:08:15''createdby=''1''updated=''2010-08-03 12:08:15''updatedby=''1''period_month=''4', 'I', 1, '2010-08-03 12:08:15', 9, 'S', 'admin', 1178, '127.0.0.1', 'period_id', '2010'),
('sim_period', 'period_year=''2010''period_name=''wer''isactive=''1''seqno=''10''created=''2010-08-03 12:08:15''createdby=''1''updated=''2010-08-03 12:08:15''updatedby=''1''period_month=''3', 'I', 1, '2010-08-03 12:08:15', 10, 'S', 'admin', 1179, '127.0.0.1', 'period_id', '2010'),
('sim_period', 'period_year=''2009'',<br/>period_month=''8''', 'U', 1, '2010-08-03 12:08:36', 9, 'S', 'admin', 1180, '127.0.0.1', 'period_id', '2009'),
('sim_period', 'period_year=''2008'',<br/>period_month=''11''', 'U', 1, '2010-08-03 12:08:36', 10, 'S', 'admin', 1181, '127.0.0.1', 'period_id', '2008'),
('sim_period', 'isactive=''0''', 'U', 1, '2010-08-03 12:08:41', 10, 'S', 'admin', 1182, '127.0.0.1', 'period_id', '2008'),
('sim_period', 'isactive=''0''', 'U', 1, '2010-08-03 12:08:41', 9, 'S', 'admin', 1183, '127.0.0.1', 'period_id', '2009'),
('sim_period', 'isactive=''1''', 'U', 1, '2010-08-03 12:15:08', 10, 'S', 'admin', 1184, '127.0.0.1', 'period_id', '2008'),
('sim_period', 'isactive=''1''', 'U', 1, '2010-08-03 12:15:08', 9, 'S', 'admin', 1185, '127.0.0.1', 'period_id', '2009'),
('sim_period', 'isactive=''1''', 'U', 1, '2010-08-03 12:15:08', 2, 'S', 'admin', 1186, '127.0.0.1', 'period_id', '2010'),
('sim_period', 'Record deleted permanentl', 'E', 1, '2010-08-03 12:15:15', 9, 'S', 'admin', 1187, '127.0.0.1', 'period_id', ''),
('sim_hr_generalclaim', 'employee_id=''A-Tester(16)''generalclaim_date=''2010-08-18''generalclaim_docno=''''generalclaim_remark=''''period_id=''dadas(8)''created=''10/08/03 12:19:43''createdby=''admin(1)''updated=''10/08/03 12:19:43''updatedby=''admin(1)''organization_id=''1', 'I', 1, '2010-08-03 12:19:43', 37, 'S', 'admin', 1188, '127.0.0.1', 'generalclaim_id', ''),
('sim_hr_generalclaim', 'issubmit=''''', 'U', 1, '2010-08-03 12:19:49', 37, 'S', 'admin', 1189, '127.0.0.1', 'generalclaim_id', '');
INSERT INTO `sim_audit` (`tablename`, `changedesc`, `category`, `uid`, `updated`, `record_id`, `eventype`, `uname`, `audit_id`, `ip`, `primarykey`, `controlvalue`) VALUES
('sim_hr_generalclaimline', 'generalclaim_id=''37''generalclaimline_date=''1900-01-01''generalclaimline_details=''''generalclaimline_porpose=''''generalclaimline_billno=''''generalclaimline_amount=''0123''remarks=''''generalclaimline_acccode=''''created=''2010-08-03 12:19:49''createdby=''1''updated=''2010-08-03 12:19:49''updatedby=''1', 'I', 1, '2010-08-03 12:19:49', 35, 'S', 'admin', 1190, '127.0.0.1', 'generalclaimline_id', ''),
('sim_hr_generalclaim', 'employee_id=''16A-Tester'',<br/>issubmit=''1''', 'U', 1, '2010-08-03 12:19:53', 37, 'S', 'admin', 1191, '127.0.0.1', 'generalclaim_id', ''),
('sim_workflowtransaction', 'workflowtransaction_datetime=''10/08/03 12:19:53''target_groupid=''1''target_uid=''0''targetparameter_name=''0,23''workflowstatus_id=''1''workflow_id=''4''tablename=''sim_hr_generalclaim''primarykey_name=''generalclaim_id''primarykey_value=''37''hyperlink=''../hr/generalclaim.php''title_description=''''created=''10/08/03 12:19:53''list_parameter=''''workflowtransaction_description=''Ok done''workflowtransaction_feedback=''''iscomplete=''0''createdby=''1''email_list=''1,0,23''sms_list=''1,0,23''email_body=''''sms_body=''''person_id=''16''issubmit=''1', 'I', 1, '2010-08-03 12:19:53', 96, 'S', 'admin', 1192, '127.0.0.1', 'workflowtransaction_id', 'sim_hr_generalclaim'),
('sim_workflowtransactionhistory', 'workflowtransaction_id=''96''workflowstatus_id=''1''workflowtransaction_datetime=''10/08/03 12:19:53''uid=''1''workflowtransactionhistory_description=''', 'I', 1, '2010-08-03 12:19:53', 0, 'S', 'admin', 1193, '127.0.0.1', 'workflowtransactionhistory_id', ''),
('sim_period', 'Record deleted permanentl', 'E', 1, '2010-08-03 12:20:03', 8, 'S', 'admin', 1194, '127.0.0.1', 'period_id', ''),
('sim_hr_department', 'Record deleted permanentl', 'E', 1, '2010-08-03 13:07:35', 0, 'S', 'admin', 1195, '127.0.0.1', 'department_id', ''),
('sim_hr_department', 'Record deleted permanentl', 'E', 1, '2010-08-03 13:07:42', 0, 'S', 'admin', 1196, '127.0.0.1', 'department_id', ''),
('sim_hr_department', 'Record deleted permanentl', 'E', 1, '2010-08-03 13:07:51', 0, 'S', 'admin', 1197, '127.0.0.1', 'department_id', ''),
('sim_hr_department', 'department_no=''111''department_name=''111''seqno=''10''description=''''department_parent=''0''isactive=''1''created=''2010-08-03 13:10:27''createdby=''1''updated=''2010-08-03 13:10:27''updatedby=''1''organization_id=''1''department_head=''0', 'I', 1, '2010-08-03 13:10:27', 10, 'S', 'admin', 1198, '127.0.0.1', 'department_id', '111'),
('sim_hr_department', 'department_no=''222''department_name=''222''seqno=''10''description=''''department_parent=''10''isactive=''1''created=''2010-08-03 13:10:42''createdby=''1''updated=''2010-08-03 13:10:42''updatedby=''1''organization_id=''1''department_head=''0', 'I', 1, '2010-08-03 13:10:42', 12, 'S', 'admin', 1199, '127.0.0.1', 'department_id', '222'),
('sim_hr_department', 'Record deleted permanentl', 'E', 1, '2010-08-03 13:10:46', 10, 'S', 'admin', 1200, '127.0.0.1', 'department_id', '111'),
('sim_hr_department', 'Record deleted permanentl', 'E', 1, '2010-08-03 13:16:56', 2, 'F', 'admin', 1201, '127.0.0.1', 'department_id', 'HR'),
('sim_hr_department', 'department_no=''WE''department_name=''DS''seqno=''10''description=''''department_parent=''0''isactive=''1''created=''2010-08-03 13:17:10''createdby=''1''updated=''2010-08-03 13:17:10''updatedby=''1''organization_id=''1''department_head=''0', 'I', 1, '2010-08-03 13:17:10', 14, 'S', 'admin', 1202, '127.0.0.1', 'department_id', 'DS'),
('sim_hr_department', 'department_no=''WDEW''department_name=''WEw''seqno=''10''description=''''department_parent=''0''isactive=''1''created=''2010-08-03 13:17:37''createdby=''1''updated=''2010-08-03 13:17:37''updatedby=''1''organization_id=''1''department_head=''0', 'I', 1, '2010-08-03 13:17:37', 16, 'S', 'admin', 1203, '127.0.0.1', 'department_id', 'WEw'),
('sim_hr_department', 'department_no=''das''department_name=''asdas''seqno=''10''description=''''department_parent=''16''isactive=''1''created=''2010-08-03 13:18:55''createdby=''1''updated=''2010-08-03 13:18:55''updatedby=''1''organization_id=''1''department_head=''0', 'I', 1, '2010-08-03 13:18:55', 17, 'S', 'admin', 1204, '127.0.0.1', 'department_id', 'asdas'),
('sim_hr_department', 'Record deleted permanentl', 'E', 1, '2010-08-03 13:19:03', 16, 'F', 'admin', 1205, '127.0.0.1', 'department_id', 'WDEW'),
('sim_hr_department', 'Record deleted permanentl', 'E', 1, '2010-08-03 13:19:07', 17, 'S', 'admin', 1206, '127.0.0.1', 'department_id', 'das'),
('sim_hr_department', 'Record deleted permanentl', 'E', 1, '2010-08-03 13:19:10', 16, 'S', 'admin', 1207, '127.0.0.1', 'department_id', 'WDEW'),
('sim_hr_employeegroup', 'employeegroup_no=''FX''employeegroup_name=''FX''islecturer=''''isovertime=''0''isparttime=''0''isactive=''0''seqno=''101''created=''2010-08-03 13:29:15''createdby=''1''updated=''2010-08-03 13:29:15''updatedby=''1''organization_id=''1''description=''22', 'I', 1, '2010-08-03 13:29:15', 27, 'S', 'admin', 1208, '127.0.0.1', 'employeegroup_id', 'FX'),
('sim_hr_employeegroup', 'employeegroup_no=''QA''employeegroup_name=''QA''islecturer=''''isovertime=''1''isparttime=''1''isactive=''1''seqno=''10''created=''2010-08-03 13:29:15''createdby=''1''updated=''2010-08-03 13:29:15''updatedby=''1''organization_id=''1''description=''11', 'I', 1, '2010-08-03 13:29:15', 28, 'S', 'admin', 1209, '127.0.0.1', 'employeegroup_id', 'QA'),
('sim_hr_employeegroup', 'employeegroup_name=''FX123'',<br/>isovertime=''1'',<br/>isparttime=''1'',<br/>isactive=''1'',<br/>seqno=''10'',<br/>description=''11''', 'U', 1, '2010-08-03 13:29:46', 27, 'S', 'admin', 1210, '127.0.0.1', 'employeegroup_id', 'FX'),
('sim_hr_employeegroup', 'employeegroup_no=''QA123'',<br/>employeegroup_name=''QA321'',<br/>isovertime=''0'',<br/>isparttime=''0'',<br/>isactive=''0'',<br/>seqno=''110'',<br/>description=''22''', 'U', 1, '2010-08-03 13:29:46', 28, 'S', 'admin', 1211, '127.0.0.1', 'employeegroup_id', 'QA123'),
('sim_hr_employeegroup', 'Record deleted permanentl', 'E', 1, '2010-08-03 13:29:54', 28, 'S', 'admin', 1212, '127.0.0.1', 'employeegroup_id', 'QA123'),
('sim_hr_employeegroup', 'Record deleted permanentl', 'E', 1, '2010-08-03 13:29:58', 27, 'S', 'admin', 1213, '127.0.0.1', 'employeegroup_id', 'FX'),
('sim_hr_jobposition', 'jobposition_no=''QQ''jobposition_name=''QQ''isactive=''1''seqno=''10''created=''2010-08-03 13:30:16''createdby=''1''updated=''2010-08-03 13:30:16''updatedby=''1''organization_id=''1''description=''', 'I', 1, '2010-08-03 13:30:16', 60, 'S', 'admin', 1214, '127.0.0.1', 'jobposition_id', 'QQ'),
('sim_hr_jobposition', 'jobposition_no=''WW''jobposition_name=''WW''isactive=''1''seqno=''10''created=''2010-08-03 13:30:16''createdby=''1''updated=''2010-08-03 13:30:16''updatedby=''1''organization_id=''1''description=''', 'I', 1, '2010-08-03 13:30:16', 61, 'S', 'admin', 1215, '127.0.0.1', 'jobposition_id', 'WW'),
('sim_hr_jobposition', 'jobposition_no=''qw''jobposition_name=''eqw''isactive=''0''seqno=''101''created=''2010-08-03 13:30:28''createdby=''1''updated=''2010-08-03 13:30:28''updatedby=''1''organization_id=''1''description=''eqw', 'I', 1, '2010-08-03 13:30:29', 62, 'S', 'admin', 1216, '127.0.0.1', 'jobposition_id', 'qw'),
('sim_hr_jobposition', 'jobposition_no=''qwe''jobposition_name=''qwe''isactive=''0''seqno=''101''created=''2010-08-03 13:30:41''createdby=''1''updated=''2010-08-03 13:30:41''updatedby=''1''organization_id=''1''description=''qwe', 'I', 1, '2010-08-03 13:30:41', 63, 'S', 'admin', 1217, '127.0.0.1', 'jobposition_id', 'qwe'),
('sim_hr_jobposition', 'jobposition_no=''qweqweqw'',<br/>jobposition_name=''eqweqwqw'',<br/>description=''eqweqweqw''', 'U', 1, '2010-08-03 13:30:56', 62, 'S', 'admin', 1218, '127.0.0.1', 'jobposition_id', 'qweqweqw'),
('sim_hr_jobposition', 'jobposition_name=''WWW1eqw''', 'U', 1, '2010-08-03 13:31:02', 58, 'S', 'admin', 1219, '127.0.0.1', 'jobposition_id', 'DS'),
('sim_hr_jobposition', 'jobposition_name=''qweeqw''', 'U', 1, '2010-08-03 13:31:02', 63, 'S', 'admin', 1220, '127.0.0.1', 'jobposition_id', 'qwe'),
('sim_hr_jobposition', 'Record deleted permanentl', 'E', 1, '2010-08-03 13:31:07', 63, 'S', 'admin', 1221, '127.0.0.1', 'jobposition_id', 'qwe'),
('sim_hr_jobposition', 'Record deleted permanentl', 'E', 1, '2010-08-03 13:31:10', 58, 'S', 'admin', 1222, '127.0.0.1', 'jobposition_id', 'DS'),
('sim_hr_jobposition', 'jobposition_no=''KS'',<br/>jobposition_name=''Kaunselors''', 'U', 1, '2010-08-03 13:31:23', 53, 'S', 'admin', 1223, '127.0.0.1', 'jobposition_id', 'KS'),
('sim_hr_jobposition', 'jobposition_no=''PY'',<br/>jobposition_name=''Pensyarah''', 'U', 1, '2010-08-03 13:31:23', 52, 'S', 'admin', 1224, '127.0.0.1', 'jobposition_id', 'PY'),
('sim_hr_jobposition', 'Record deleted permanentl', 'E', 1, '2010-08-03 13:31:27', 62, 'S', 'admin', 1225, '127.0.0.1', 'jobposition_id', 'qweqweqw'),
('sim_hr_leavetype', 'leavetype_name=''DD''isactive=''0''isvalidate=''0''seqno=''101''created=''2010-08-03 13:31:49''createdby=''1''updated=''2010-08-03 13:31:49''updatedby=''1''organization_id=''1''description=''1221', 'I', 1, '2010-08-03 13:31:49', 17, 'S', 'admin', 1226, '127.0.0.1', 'leavetype_id', 'DD'),
('sim_hr_leavetype', 'leavetype_name=''WW''isactive=''1''isvalidate=''1''seqno=''10''created=''2010-08-03 13:31:49''createdby=''1''updated=''2010-08-03 13:31:49''updatedby=''1''organization_id=''1''description=''112', 'I', 1, '2010-08-03 13:31:49', 18, 'S', 'admin', 1227, '127.0.0.1', 'leavetype_id', 'WW'),
('sim_hr_leavetype', 'leavetype_name=''DDdad'',<br/>isactive=''1'',<br/>isvalidate=''1'',<br/>description=''asdas''', 'U', 1, '2010-08-03 13:32:02', 17, 'S', 'admin', 1228, '127.0.0.1', 'leavetype_id', 'DDdad'),
('sim_hr_leavetype', 'leavetype_name=''WWsa'',<br/>isactive=''0'',<br/>isvalidate=''0'',<br/>description=''12312''', 'U', 1, '2010-08-03 13:32:02', 18, 'S', 'admin', 1229, '127.0.0.1', 'leavetype_id', 'WWsa'),
('sim_hr_leavetype', 'Record deleted permanentl', 'E', 1, '2010-08-03 13:32:07', 17, 'S', 'admin', 1230, '127.0.0.1', 'leavetype_id', 'DDdad'),
('sim_hr_leavetype', 'Record deleted permanentl', 'E', 1, '2010-08-03 13:32:10', 18, 'S', 'admin', 1231, '127.0.0.1', 'leavetype_id', 'WWsa'),
('sim_hr_disciplinetype', 'disciplinetype_name=''BB''isactive=''0''seqno=''110''created=''2010-08-03 13:32:35''createdby=''1''updated=''2010-08-03 13:32:35''updatedby=''1''organization_id=''1''description=''321312', 'I', 1, '2010-08-03 13:32:35', 23, 'S', 'admin', 1232, '127.0.0.1', 'disciplinetype_id', 'BB'),
('sim_hr_disciplinetype', 'disciplinetype_name=''AA''isactive=''1''seqno=''10''created=''2010-08-03 13:32:35''createdby=''1''updated=''2010-08-03 13:32:35''updatedby=''1''organization_id=''1''description=''', 'I', 1, '2010-08-03 13:32:35', 24, 'S', 'admin', 1233, '127.0.0.1', 'disciplinetype_id', 'AA'),
('sim_hr_disciplinetype', 'disciplinetype_name=''BB22'',<br/>isactive=''1'',<br/>seqno=''10'',<br/>description=''321312dasdasda''', 'U', 1, '2010-08-03 13:32:51', 23, 'S', 'admin', 1234, '127.0.0.1', 'disciplinetype_id', 'BB22'),
('sim_hr_disciplinetype', 'disciplinetype_name=''AA11'',<br/>description=''312312''', 'U', 1, '2010-08-03 13:32:51', 24, 'S', 'admin', 1235, '127.0.0.1', 'disciplinetype_id', 'AA11'),
('sim_hr_disciplinetype', 'Record deleted permanentl', 'E', 1, '2010-08-03 13:32:56', 23, 'S', 'admin', 1236, '127.0.0.1', 'disciplinetype_id', 'BB22'),
('sim_hr_disciplinetype', 'Record deleted permanentl', 'E', 1, '2010-08-03 13:32:59', 24, 'S', 'admin', 1237, '127.0.0.1', 'disciplinetype_id', 'AA11'),
('sim_hr_trainingtype', 'trainingtype_name=''WE''isactive=''1''seqno=''10''created=''2010-08-03 13:33:13''createdby=''1''updated=''2010-08-03 13:33:13''updatedby=''1''organization_id=''1''description=''', 'I', 1, '2010-08-03 13:33:13', 19, 'S', 'admin', 1238, '127.0.0.1', 'trainingtype_id', 'WE'),
('sim_hr_trainingtype', 'trainingtype_name=''EW''isactive=''1''seqno=''10''created=''2010-08-03 13:33:13''createdby=''1''updated=''2010-08-03 13:33:13''updatedby=''1''organization_id=''1''description=''', 'I', 1, '2010-08-03 13:33:13', 20, 'S', 'admin', 1239, '127.0.0.1', 'trainingtype_id', 'EW'),
('sim_hr_trainingtype', 'description=''eqweqw''', 'U', 1, '2010-08-03 13:33:22', 19, 'S', 'admin', 1240, '127.0.0.1', 'trainingtype_id', 'WE'),
('sim_hr_trainingtype', 'trainingtype_name=''qweq''isactive=''1''seqno=''10''created=''2010-08-03 13:33:27''createdby=''1''updated=''2010-08-03 13:33:27''updatedby=''1''organization_id=''1''description=''ewqeqw', 'I', 1, '2010-08-03 13:33:28', 21, 'S', 'admin', 1241, '127.0.0.1', 'trainingtype_id', 'qweq'),
('sim_hr_trainingtype', 'trainingtype_name=''22''isactive=''1''seqno=''10''created=''2010-08-03 13:33:40''createdby=''1''updated=''2010-08-03 13:33:40''updatedby=''1''organization_id=''1''description=''22', 'I', 1, '2010-08-03 13:33:40', 22, 'S', 'admin', 1242, '127.0.0.1', 'trainingtype_id', '22'),
('sim_hr_trainingtype', 'trainingtype_name=''11''isactive=''1''seqno=''10''created=''2010-08-03 13:33:40''createdby=''1''updated=''2010-08-03 13:33:40''updatedby=''1''organization_id=''1''description=''22', 'I', 1, '2010-08-03 13:33:40', 23, 'S', 'admin', 1243, '127.0.0.1', 'trainingtype_id', '11'),
('sim_hr_trainingtype', 'trainingtype_name=''33''isactive=''1''seqno=''10''created=''2010-08-03 13:34:18''createdby=''1''updated=''2010-08-03 13:34:18''updatedby=''1''organization_id=''1''description=''33', 'I', 1, '2010-08-03 13:34:18', 24, 'S', 'admin', 1244, '127.0.0.1', 'trainingtype_id', '33'),
('sim_hr_trainingtype', 'trainingtype_name=''55''isactive=''1''seqno=''10''created=''2010-08-03 13:34:29''createdby=''1''updated=''2010-08-03 13:34:29''updatedby=''1''organization_id=''1''description=''55', 'I', 1, '2010-08-03 13:34:29', 25, 'S', 'admin', 1245, '127.0.0.1', 'trainingtype_id', '55'),
('sim_hr_trainingtype', 'trainingtype_name=''44''isactive=''1''seqno=''10''created=''2010-08-03 13:34:29''createdby=''1''updated=''2010-08-03 13:34:29''updatedby=''1''organization_id=''1''description=''44', 'I', 1, '2010-08-03 13:34:29', 26, 'S', 'admin', 1246, '127.0.0.1', 'trainingtype_id', '44'),
('sim_hr_trainingtype', 'description=''22a''', 'U', 1, '2010-08-03 13:34:41', 23, 'S', 'admin', 1247, '127.0.0.1', 'trainingtype_id', '11'),
('sim_hr_trainingtype', 'description=''22b''', 'U', 1, '2010-08-03 13:34:41', 22, 'S', 'admin', 1248, '127.0.0.1', 'trainingtype_id', '22'),
('sim_hr_trainingtype', 'description=''33c''', 'U', 1, '2010-08-03 13:34:41', 24, 'S', 'admin', 1249, '127.0.0.1', 'trainingtype_id', '33'),
('sim_hr_trainingtype', 'description=''44d''', 'U', 1, '2010-08-03 13:34:41', 26, 'S', 'admin', 1250, '127.0.0.1', 'trainingtype_id', '44'),
('sim_hr_trainingtype', 'description=''55e''', 'U', 1, '2010-08-03 13:34:41', 25, 'S', 'admin', 1251, '127.0.0.1', 'trainingtype_id', '55'),
('sim_hr_trainingtype', 'Record deleted permanentl', 'E', 1, '2010-08-03 13:34:47', 25, 'S', 'admin', 1252, '127.0.0.1', 'trainingtype_id', '55'),
('sim_hr_trainingtype', 'Record deleted permanentl', 'E', 1, '2010-08-03 13:34:49', 23, 'S', 'admin', 1253, '127.0.0.1', 'trainingtype_id', '11'),
('sim_hr_trainingtype', 'Record deleted permanentl', 'E', 1, '2010-08-03 13:34:51', 22, 'S', 'admin', 1254, '127.0.0.1', 'trainingtype_id', '22'),
('sim_hr_trainingtype', 'Record deleted permanentl', 'E', 1, '2010-08-03 13:34:54', 24, 'S', 'admin', 1255, '127.0.0.1', 'trainingtype_id', '33'),
('sim_hr_trainingtype', 'Record deleted permanentl', 'E', 1, '2010-08-03 13:34:57', 26, 'S', 'admin', 1256, '127.0.0.1', 'trainingtype_id', '44'),
('sim_hr_trainingtype', 'Record deleted permanentl', 'E', 1, '2010-08-03 13:35:01', 18, 'F', 'admin', 1257, '127.0.0.1', 'trainingtype_id', 'DS'),
('sim_hr_trainingtype', 'Record deleted permanentl', 'E', 1, '2010-08-03 13:35:07', 21, 'S', 'admin', 1258, '127.0.0.1', 'trainingtype_id', 'qweq'),
('sim_hr_panelclinics', 'employee_id=''Ali Bin Ahmad(14)''panelclinics_date=''2010-08-13''panelclinics_ismc=''''panelclinics_totalday=''''bpartner_id=''Clinic MM(2)''panelclinics_amount=''123''panelclinics_costbreakdown=''adasd''organization_id=''1''created=''10/08/03 13:38:41''createdby=''admin(1)''updated=''10/08/03 13:38:41''updatedby=''admin(1)', 'I', 1, '2010-08-03 13:38:41', 15, 'S', 'admin', 1259, '127.0.0.1', 'panelclinics_id', '2010-08-13'),
('sim_hr_panelclinics', 'employee_id=''B-Hunter(17)''panelclinics_date=''2010-08-03''panelclinics_ismc=''1''panelclinics_totalday=''das''bpartner_id=''Clinic Ali(1)''panelclinics_amount=''1231''panelclinics_costbreakdown=''asdsa''organization_id=''1''created=''10/08/03 13:39:01''createdby=''admin(1)''updated=''10/08/03 13:39:01''updatedby=''admin(1)', 'I', 1, '2010-08-03 13:39:01', 16, 'S', 'admin', 1260, '127.0.0.1', 'panelclinics_id', '2010-08-03'),
('sim_hr_panelclinics', 'employee_id=''A1(35)''panelclinics_date=''2010-08-12''panelclinics_ismc=''1''panelclinics_totalday=''123''bpartner_id=''Clinic MM(2)''panelclinics_amount=''123''panelclinics_costbreakdown=''dasd''organization_id=''1''created=''10/08/03 13:39:37''createdby=''admin(1)''updated=''10/08/03 13:39:37''updatedby=''admin(1)', 'I', 1, '2010-08-03 13:39:37', 17, 'S', 'admin', 1261, '127.0.0.1', 'panelclinics_id', '2010-08-12'),
('sim_hr_panelclinics', 'employee_id=''A-Tester(16)''panelclinics_date=''2010-08-11''panelclinics_ismc=''1''panelclinics_totalday=''2''bpartner_id=''Clinic MM(2)''panelclinics_amount=''123''panelclinics_costbreakdown=''dsadasd''organization_id=''1''created=''10/08/03 13:40:10''createdby=''admin(1)''updated=''10/08/03 13:40:10''updatedby=''admin(1)', 'I', 1, '2010-08-03 13:40:10', 18, 'S', 'admin', 1262, '127.0.0.1', 'panelclinics_id', '2010-08-11'),
('sim_hr_overtimeclaim', 'employee_id=''A-Tester(16)''overtimeclaim_date=''2010-08-10''overtimeclaim_docno=''''overtimeclaim_remark=''''created=''10/08/03 13:41:05''createdby=''admin(1)''updated=''10/08/03 13:41:05''updatedby=''admin(1)''organization_id=''1', 'I', 1, '2010-08-03 13:41:05', 16, 'S', 'admin', 1263, '127.0.0.1', 'overtimeclaim_id', ''),
('sim_hr_employee', 'employee_name=''asddsadas''employee_cardno=''''employee_no=''asdas''uid=''''place_dob=''''employee_dob=''2010-08-17''races_id=''3''religion_id=''1''gender=''M''marital_status=''2''employee_citizenship=''2''employee_newicno=''''employee_oldicno=''''ic_color=''B''employee_passport=''''employee_bloodgroup=''''department_id=''4''jobposition_id=''53''employeegroup_id=''10''employee_joindate=''2010-08-13''filephoto=''''updated=''2010-08-03 15:00:46''updatedby=''1''seqno=''''organization_id=''''created=''2010-08-03 15:00:46''createdby=''1''employee_transport=''''employee_status=''1''isactive=''1''employee_altname=''''ic_placeissue=''''employee_passport_placeissue=''''employee_passport_issuedate=''''employee_passport_expirydate=''''employee_confirmdate=''''employee_enddate=''', 'I', 1, '2010-08-03 15:00:47', 37, 'S', 'admin', 1264, '127.0.0.1', 'employee_id', 'asddsadas'),
('sim_hr_employee', 'employee_officeno=''03-123''', 'U', 1, '2010-08-03 15:41:11', 23, 'S', 'admin', 1265, '127.0.0.1', 'employee_id', ''),
('sim_hr_employee', 'employee_hpno=''031-3123-123''', 'U', 1, '2010-08-03 15:41:43', 23, 'S', 'admin', 1266, '127.0.0.1', 'employee_id', ''),
('sim_hr_employee', 'employee_email=''dasdas''', 'U', 1, '2010-08-03 15:46:07', 23, 'S', 'admin', 1267, '127.0.0.1', 'employee_id', ''),
('sim_hr_employee', 'employee_email=''dasdas@gmail.com''', 'U', 1, '2010-08-03 15:52:35', 23, 'S', 'admin', 1268, '127.0.0.1', 'employee_id', ''),
('sim_hr_employee', 'employee_email=''dasdas''', 'U', 1, '2010-08-03 15:54:02', 23, 'S', 'admin', 1269, '127.0.0.1', 'employee_id', ''),
('sim_hr_employee', 'employee_email=''dasdas@gmail.com''', 'U', 1, '2010-08-03 15:59:09', 23, 'S', 'admin', 1270, '127.0.0.1', 'employee_id', ''),
('sim_hr_employee', 'employee_email=''''', 'U', 1, '2010-08-03 16:00:38', 23, 'S', 'admin', 1271, '127.0.0.1', 'employee_id', ''),
('sim_hr_employee', 'employee_email=''eaw@das.com''', 'U', 1, '2010-08-03 16:00:52', 23, 'S', 'admin', 1272, '127.0.0.1', 'employee_id', ''),
('sim_hr_employee', 'employee_email=''eaw@das.''', 'U', 1, '2010-08-03 16:01:00', 23, 'S', 'admin', 1273, '127.0.0.1', 'employee_id', ''),
('sim_hr_employee', 'employee_email=''''', 'U', 1, '2010-08-03 16:01:13', 23, 'S', 'admin', 1274, '127.0.0.1', 'employee_id', ''),
('sim_window', 'isactive=''1''', 'U', 0, '2010-08-03 16:15:28', 39, 'S', '', 1275, '192.168.1.204', 'window_id', 'Panel Clinic Visit'),
('sim_window', 'mid=''64''windowsetting=''''seqno=''10''description=''''parentwindows_id=''17''filename=''statistics.php''isactive=''1''window_name=''Statistics''created=''2010-08-03 16:15:56''createdby=''1''updated=''2010-08-03 16:15:56''updatedby=''1''table_name=''', 'I', 0, '2010-08-03 16:15:56', 48, 'S', '', 1276, '192.168.1.204', 'window_id', 'Statistics'),
('sim_window', 'filename=''panelclinicrep.php''', 'U', 0, '2010-08-03 16:16:31', 39, 'S', '', 1277, '192.168.1.204', 'window_id', 'Panel Clinic Visit'),
('sim_hr_employee', 'permanent_postcode=''dsa'',<br/>contact_postcode=''das''', 'U', 1, '2010-08-03 16:28:41', 23, 'S', 'admin', 1278, '127.0.0.1', 'employee_id', ''),
('sim_hr_employee', 'permanent_postcode=''123'',<br/>contact_postcode=''123''', 'U', 1, '2010-08-03 16:32:20', 23, 'S', 'admin', 1279, '127.0.0.1', 'employee_id', ''),
('sim_hr_employee', 'permanent_telno=''312-312-31'',<br/>contact_telno=''12301231''', 'U', 1, '2010-08-03 16:32:34', 23, 'S', 'admin', 1280, '127.0.0.1', 'employee_id', ''),
('sim_hr_employee', 'permanent_country=''2'',<br/>contact_country=''2''', 'U', 1, '2010-08-03 16:36:28', 23, 'S', 'admin', 1281, '127.0.0.1', 'employee_id', ''),
('sim_hr_employee', 'marital_status=''2'',<br/>seqno='''',<br/>organization_id=''''', 'U', 1, '2010-08-03 17:10:24', 16, 'S', 'admin', 1282, '127.0.0.1', 'employee_id', 'EM001'),
('sim_hr_disciplineline', 'disciplineline_date=''1900-01-01''disciplinetype_id=''15''employee_id=''19''disciplineline_name=''''disciplineline_remarks=''''created=''2010-08-03 17:19:05''createdby=''1''updated=''2010-08-03 17:19:05''updatedby=''1', 'I', 1, '2010-08-03 17:19:05', 16, 'S', 'admin', 1283, '127.0.0.1', 'disciplinetype_id', ''),
('sim_hr_disciplineline', 'disciplineline_date=''1900-01-01''disciplinetype_id=''''employee_id=''19''disciplineline_name=''''disciplineline_remarks=''''created=''2010-08-03 17:19:11''createdby=''1''updated=''2010-08-03 17:19:11''updatedby=''1', 'I', 1, '2010-08-03 17:19:11', 16, 'S', 'admin', 1284, '127.0.0.1', 'disciplinetype_id', ''),
('sim_hr_disciplineline', 'disciplinetype_id=''15''', 'U', 1, '2010-08-03 17:19:20', 4, 'S', 'admin', 1285, '127.0.0.1', 'disciplineline_id', ''),
('sim_hr_disciplineline', 'disciplinetype_id=''17''', 'U', 1, '2010-08-03 17:19:41', 4, 'S', 'admin', 1286, '127.0.0.1', 'disciplineline_id', ''),
('sim_hr_disciplineline', 'disciplineline_date=''1900-01-01''disciplinetype_id=''''employee_id=''19''disciplineline_name=''''disciplineline_remarks=''''created=''2010-08-03 17:19:44''createdby=''1''updated=''2010-08-03 17:19:44''updatedby=''1', 'I', 1, '2010-08-03 17:19:44', 17, 'S', 'admin', 1287, '127.0.0.1', 'disciplinetype_id', ''),
('sim_hr_disciplineline', 'disciplineline_date=''1900-01-01''disciplinetype_id=''''employee_id=''19''disciplineline_name=''''disciplineline_remarks=''''created=''2010-08-03 17:28:06''createdby=''1''updated=''2010-08-03 17:28:06''updatedby=''1', 'I', 1, '2010-08-03 17:28:07', 17, 'S', 'admin', 1288, '127.0.0.1', 'disciplinetype_id', ''),
('sim_hr_disciplineline', 'disciplineline_date=''1900-01-01''disciplinetype_id=''16''employee_id=''19''disciplineline_name=''dasdas''disciplineline_remarks=''''created=''2010-08-03 17:29:05''createdby=''1''updated=''2010-08-03 17:29:05''updatedby=''1', 'I', 1, '2010-08-03 17:29:05', 17, 'S', 'admin', 1289, '127.0.0.1', 'disciplinetype_id', 'dasdas'),
('sim_hr_disciplineline', 'disciplineline_name=''das''', 'U', 1, '2010-08-03 17:29:05', 1, 'S', 'admin', 1290, '127.0.0.1', 'disciplineline_id', 'das'),
('sim_hr_disciplineline', 'disciplineline_name=''das''', 'U', 1, '2010-08-03 17:29:05', 2, 'S', 'admin', 1291, '127.0.0.1', 'disciplineline_id', 'das'),
('sim_hr_disciplineline', 'disciplineline_name=''das''', 'U', 1, '2010-08-03 17:29:05', 3, 'S', 'admin', 1292, '127.0.0.1', 'disciplineline_id', 'das'),
('sim_hr_disciplineline', 'disciplineline_name=''das''', 'U', 1, '2010-08-03 17:29:05', 4, 'S', 'admin', 1293, '127.0.0.1', 'disciplineline_id', 'das'),
('sim_hr_disciplineline', 'disciplineline_name=''das''', 'U', 1, '2010-08-03 17:29:05', 5, 'S', 'admin', 1294, '127.0.0.1', 'disciplineline_id', 'das'),
('sim_hr_disciplineline', 'disciplineline_name=''as''', 'U', 1, '2010-08-03 17:29:05', 6, 'S', 'admin', 1295, '127.0.0.1', 'disciplineline_id', 'as'),
('sim_hr_disciplineline', 'disciplineline_date=''1900-01-01''disciplinetype_id=''15''employee_id=''19''disciplineline_name=''das''disciplineline_remarks=''''created=''2010-08-03 17:29:23''createdby=''1''updated=''2010-08-03 17:29:23''updatedby=''1', 'I', 1, '2010-08-03 17:29:23', 17, 'S', 'admin', 1296, '127.0.0.1', 'disciplinetype_id', 'das'),
('sim_hr_disciplineline', 'disciplinetype_id=''16''', 'U', 1, '2010-08-03 17:29:23', 6, 'S', 'admin', 1297, '127.0.0.1', 'disciplineline_id', 'as'),
('sim_hr_disciplineline', 'disciplinetype_id=''17''', 'U', 1, '2010-08-03 17:29:23', 5, 'S', 'admin', 1298, '127.0.0.1', 'disciplineline_id', 'das'),
('sim_hr_employee', 'employee_epfno=''BB'',<br/>employee_socsono=''EE'',<br/>employee_taxno=''CC'',<br/>employee_pencenno=''FF'',<br/>employee_accno=''DD'',<br/>employee_bankname=''AA''', 'U', 1, '2010-08-03 17:31:38', 19, 'S', 'admin', 1299, '127.0.0.1', 'employee_id', ''),
('sim_hr_appraisalline', 'appraisalline_name=''dasdas''appraisalline_date=''1900-01-01''appraisalline_datedue=''1900-01-01''appraisalline_increment=''0''appraisalline_result=''''appraisalline_remarks=''''isdeleted=''''created=''2010-08-03 17:32:02''createdby=''1''updated=''2010-08-03 17:32:02''updatedby=''1''employee_id=''19', 'I', 1, '2010-08-03 17:32:03', 4, 'S', 'admin', 1300, '127.0.0.1', 'appraisalline_id', 'dasdas'),
('sim_hr_activityline', 'activityline_datefrom=''1900-01-01''activityline_dateto=''1900-01-01''activityline_type=''''employee_id=''19''activityline_name=''''activityline_remarks=''''created=''2010-08-03 17:35:19''createdby=''1''updated=''2010-08-03 17:35:19''updatedby=''1', 'I', 1, '2010-08-03 17:35:19', 4, 'S', 'admin', 1301, '127.0.0.1', 'activityline_id', ''),
('sim_hr_trainingline', 'trainingline_name=''das''trainingtype_id=''19''trainingline_venue=''''trainingline_purpose=''''trainingline_startdate=''1900-01-01''trainingline_enddate=''1900-01-01''trainingline_trainerid=''''trainingline_result=''''trainingline_hodcom=''''trainingline_hrcom=''''trainingline_remarks=''''trainingline_trainer =''''created=''2010-08-03 17:37:58''createdby=''1''updated=''2010-08-03 17:37:58''updatedby=''1''employee_id=''19', 'I', 1, '2010-08-03 17:37:58', 14, 'S', 'admin', 1302, '127.0.0.1', 'trainingline_id', 'das'),
('sim_hr_activityline', 'activityline_type=''1'',<br/>activityline_name=''dasa''', 'U', 1, '2010-08-03 17:41:12', 4, 'S', 'admin', 1303, '127.0.0.1', 'activityline_id', 'dasa'),
('sim_hr_activityline', 'activityline_datefrom=''1900-01-01''activityline_dateto=''1900-01-01''activityline_type=''1''employee_id=''19''activityline_name=''das''activityline_remarks=''''created=''2010-08-03 17:41:19''createdby=''1''updated=''2010-08-03 17:41:19''updatedby=''1', 'I', 1, '2010-08-03 17:41:19', 5, 'S', 'admin', 1304, '127.0.0.1', 'activityline_id', 'das'),
('sim_hr_activityline', 'activityline_datefrom=''1900-01-01''activityline_dateto=''1900-01-01''activityline_type=''1''employee_id=''19''activityline_name=''das''activityline_remarks=''''created=''2010-08-03 17:41:29''createdby=''1''updated=''2010-08-03 17:41:29''updatedby=''1', 'I', 1, '2010-08-03 17:41:29', 6, 'S', 'admin', 1305, '127.0.0.1', 'activityline_id', 'das'),
('sim_hr_activityline', 'activityline_datefrom=''1900-01-01''activityline_dateto=''1900-01-01''activityline_type=''1''employee_id=''19''activityline_name=''das''activityline_remarks=''''created=''2010-08-03 17:41:29''createdby=''1''updated=''2010-08-03 17:41:29''updatedby=''1', 'I', 1, '2010-08-03 17:41:29', 7, 'S', 'admin', 1306, '127.0.0.1', 'activityline_id', 'das'),
('sim_hr_portfolioline', 'portfolioline_datefrom=''1900-01-01''portfolioline_dateto=''1900-01-01''portfolioline_name=''''portfolioline_remarks=''''created=''2010-08-03 17:43:31''createdby=''1''updated=''2010-08-03 17:43:31''updatedby=''1''working_experience=''''employee_id=''19', 'I', 1, '2010-08-03 17:43:31', 5, 'S', 'admin', 1307, '127.0.0.1', 'portfolioline_id', ''),
('sim_hr_portfolioline', 'portfolioline_datefrom=''1900-01-01''portfolioline_dateto=''1900-01-01''portfolioline_name=''''portfolioline_remarks=''''created=''2010-08-03 17:43:31''createdby=''1''updated=''2010-08-03 17:43:31''updatedby=''1''working_experience=''''employee_id=''19', 'I', 1, '2010-08-03 17:43:31', 6, 'S', 'admin', 1308, '127.0.0.1', 'portfolioline_id', ''),
('sim_hr_portfolioline', 'portfolioline_datefrom=''1900-01-01''portfolioline_dateto=''1900-01-01''portfolioline_name=''''portfolioline_remarks=''''created=''2010-08-03 17:43:36''createdby=''1''updated=''2010-08-03 17:43:36''updatedby=''1''working_experience=''''employee_id=''19', 'I', 1, '2010-08-03 17:43:36', 7, 'S', 'admin', 1309, '127.0.0.1', 'portfolioline_id', ''),
('sim_hr_portfolioline', 'portfolioline_name=''dasd''', 'U', 1, '2010-08-03 17:44:40', 5, 'S', 'admin', 1310, '127.0.0.1', 'portfolioline_id', 'dasd'),
('sim_hr_portfolioline', 'portfolioline_name=''das''', 'U', 1, '2010-08-03 17:44:40', 6, 'S', 'admin', 1311, '127.0.0.1', 'portfolioline_id', 'das'),
('sim_hr_portfolioline', 'portfolioline_name=''dadas''', 'U', 1, '2010-08-03 17:44:40', 7, 'S', 'admin', 1312, '127.0.0.1', 'portfolioline_id', 'dadas'),
('sim_window', 'mid=''64''windowsetting=''''seqno=''10''description=''''parentwindows_id=''17''filename=''chartleave_1month.php''isactive=''0''window_name=''Chart leave''created=''2010-08-03 17:47:54''createdby=''1''updated=''2010-08-03 17:47:54''updatedby=''1''table_name=''', 'I', 0, '2010-08-03 17:47:54', 49, 'S', '', 1313, '127.0.0.1', 'window_id', 'Chart leave'),
('sim_window', 'mid=''64''windowsetting=''''seqno=''10''description=''''parentwindows_id=''17''filename=''turnover_1month.php''isactive=''0''window_name=''Turnover month''created=''2010-08-03 17:48:16''createdby=''1''updated=''2010-08-03 17:48:16''updatedby=''1''table_name=''', 'I', 0, '2010-08-03 17:48:16', 50, 'S', '', 1314, '127.0.0.1', 'window_id', 'Turnover month'),
('sim_hr_employeefamily', 'employeefamily_name=''das''relationship_id=''1''employeefamily_dob=''1900-01-01''employeefamily_occupation=''''employeefamily_contactno=''''isnok=''1''isemergency=''1''employeefamily_remark=''''created=''2010-08-03 17:52:54''createdby=''1''updated=''2010-08-03 17:52:54''updatedby=''1''employee_id=''16', 'I', 1, '2010-08-03 17:52:54', 8, 'S', 'admin', 1315, '127.0.0.1', 'employeefamily_id', 'das'),
('sim_hr_supervisorline', 'supervisorline_supervisorid=''''isdirect=''1''supervisorline_remarks=''''created=''2010-08-03 17:54:02''createdby=''1''updated=''2010-08-03 17:54:02''updatedby=''1''employee_id=''16', 'I', 1, '2010-08-03 17:54:02', 26, 'S', 'admin', 1316, '127.0.0.1', 'supervisorline_id', ''),
('sim_hr_supervisorline', 'supervisorline_supervisorid=''35''isdirect=''1''supervisorline_remarks=''''created=''2010-08-03 17:59:38''createdby=''1''updated=''2010-08-03 17:59:38''updatedby=''1''employee_id=''16', 'I', 1, '2010-08-03 17:59:38', 27, 'S', 'admin', 1317, '127.0.0.1', 'supervisorline_id', '35'),
('sim_hr_supervisorline', 'supervisorline_supervisorid=''35''', 'U', 1, '2010-08-03 17:59:38', 26, 'S', 'admin', 1318, '127.0.0.1', 'supervisorline_id', '35'),
('sim_hr_employeefamily', 'isemergency=''0''', 'U', 1, '2010-08-03 18:15:48', 8, 'S', 'admin', 1319, '127.0.0.1', 'employeefamily_id', 'das'),
('sim_hr_employeefamily', 'employeefamily_name=''eqw''relationship_id=''1''employeefamily_dob=''1900-01-01''employeefamily_occupation=''''employeefamily_contactno=''''isnok=''1''isemergency=''0''employeefamily_remark=''''created=''2010-08-03 18:16:11''createdby=''1''updated=''2010-08-03 18:16:11''updatedby=''1''employee_id=''16', 'I', 1, '2010-08-03 18:16:11', 9, 'S', 'admin', 1320, '127.0.0.1', 'employeefamily_id', 'eqw'),
('sim_hr_employeefamily', 'employeefamily_name=''eqw''relationship_id=''2''employeefamily_dob=''1900-01-01''employeefamily_occupation=''''employeefamily_contactno=''''isnok=''1''isemergency=''0''employeefamily_remark=''''created=''2010-08-03 18:16:11''createdby=''1''updated=''2010-08-03 18:16:11''updatedby=''1''employee_id=''16', 'I', 1, '2010-08-03 18:16:11', 10, 'S', 'admin', 1321, '127.0.0.1', 'employeefamily_id', 'eqw'),
('sim_hr_medicalclaim', 'employee_id=''Ali Bin Ahmad(14)''medicalclaim_date=''2010-08-17''medicalclaim_clinic=''eqw''medicalclaim_docno=''eqwew''medicalclaim_amount=''12312''medicalclaim_treatment=''qweqw''medicalclaim_remark=''''period_id=''wer(10)''created=''10/08/03 18:24:13''createdby=''admin(1)''updated=''10/08/03 18:24:13''updatedby=''admin(1)''organization_id=''1', 'I', 1, '2010-08-03 18:24:13', 1, 'S', 'admin', 1322, '127.0.0.1', 'medicalclaim_id', 'eqwew'),
('sim_hr_medicalclaim', 'issubmit=''1''', 'U', 1, '2010-08-03 18:24:27', 1, 'S', 'admin', 1323, '127.0.0.1', 'medicalclaim_id', 'eqwew'),
('sim_workflowtransaction', 'workflowtransaction_datetime=''10/08/03 18:24:27''target_groupid=''1''target_uid=''0''targetparameter_name=''0,23''workflowstatus_id=''1''workflow_id=''10''tablename=''sim_hr_medicalclaim''primarykey_name=''medicalclaim_id''primarykey_value=''1''hyperlink=''../hr/medicalclaim.php''title_description=''''created=''10/08/03 18:24:27''list_parameter=''''workflowtransaction_description=''''workflowtransaction_feedback=''''iscomplete=''0''createdby=''1''email_list=''1,0,23''sms_list=''1,0,23''email_body=''''sms_body=''''person_id=''14''issubmit=''1', 'I', 1, '2010-08-03 18:24:27', 97, 'S', 'admin', 1324, '127.0.0.1', 'workflowtransaction_id', 'sim_hr_medicalclaim'),
('sim_workflowtransactionhistory', 'workflowtransaction_id=''97''workflowstatus_id=''1''workflowtransaction_datetime=''10/08/03 18:24:27''uid=''1''workflowtransactionhistory_description=''', 'I', 1, '2010-08-03 18:24:27', 0, 'S', 'admin', 1325, '127.0.0.1', 'workflowtransactionhistory_id', ''),
('sim_hr_jobposition', 'isactive=''0''', 'U', 1, '2010-08-03 18:40:38', 60, 'S', 'admin', 1326, '127.0.0.1', 'jobposition_id', 'QQ'),
('sim_hr_department', 'Record deleted permanentl', 'E', 1, '2010-08-03 19:09:01', 3, 'F', 'admin', 1327, '127.0.0.1', 'department_id', 'AD'),
('sim_hr_department', 'department_no=''dsa''department_name=''asda''seqno=''10''description=''''department_parent=''0''isactive=''1''created=''2010-08-03 19:09:47''createdby=''1''updated=''2010-08-03 19:09:47''updatedby=''1''organization_id=''1''department_head=''0', 'I', 1, '2010-08-03 19:09:47', 18, 'S', 'admin', 1328, '127.0.0.1', 'department_id', 'asda'),
('sim_hr_department', 'Record deleted permanentl', 'E', 1, '2010-08-03 19:09:52', 18, 'S', 'admin', 1329, '127.0.0.1', 'department_id', 'dsa'),
('sim_hr_department', 'department_no=''dasdas''department_name=''dasdas''seqno=''10''description=''''department_parent=''0''isactive=''1''created=''2010-08-03 19:10:00''createdby=''1''updated=''2010-08-03 19:10:00''updatedby=''1''organization_id=''1''department_head=''0', 'I', 1, '2010-08-03 19:10:00', 19, 'S', 'admin', 1330, '127.0.0.1', 'department_id', 'dasdas'),
('sim_hr_department', 'Record deleted permanentl', 'E', 1, '2010-08-03 19:10:25', 19, 'F', 'admin', 1331, '127.0.0.1', 'department_id', 'dasdas'),
('sim_hr_department', 'Record deleted permanentl', 'E', 1, '2010-08-03 19:19:51', 2, 'F', 'admin', 1332, '127.0.0.1', 'department_id', 'HR'),
('sim_hr_employeegroup', 'employeegroup_no=''aa''employeegroup_name=''aa''islecturer=''''isovertime=''1''isparttime=''1''isactive=''1''seqno=''10''created=''2010-08-03 19:39:04''createdby=''1''updated=''2010-08-03 19:39:04''updatedby=''1''organization_id=''1''description=''', 'I', 1, '2010-08-03 19:39:05', 30, 'S', 'admin', 1333, '127.0.0.1', 'employeegroup_id', 'aa'),
('sim_hr_employee', 'employee_citizenship='''',<br/>department_id=''3'',<br/>seqno='''',<br/>organization_id=''''', 'U', 1, '2010-08-03 19:48:22', 19, 'S', 'admin', 1334, '127.0.0.1', 'employee_id', 'K001'),
('sim_workflowtransaction', 'workflowtransaction_datetime=''10/08/03 19:56:47''target_groupid=''1''target_uid=''0''targetparameter_name=''0,23''workflowstatus_id=''2''workflow_id=''10''tablename=''sim_hr_medicalclaim''primarykey_name=''medicalclaim_id''primarykey_value=''1''hyperlink=''../hr/medicalclaim.php''title_description=''''created=''10/08/03 19:56:47''list_parameter=''''workflowtransaction_description=''''workflowtransaction_feedback=''''iscomplete=''1''createdby=''1''email_list=''0,23''sms_list=''0,23''email_body=''''sms_body=''''person_id=''14''issubmit=''1', 'I', 1, '2010-08-03 19:56:47', 98, 'S', '', 1335, '127.0.0.1', 'workflowtransaction_id', 'sim_hr_medicalclaim'),
('sim_workflowtransactionhistory', 'workflowtransaction_id=''98''workflowstatus_id=''2''workflowtransaction_datetime=''10/08/03 19:56:47''uid=''1''workflowtransactionhistory_description=''', 'I', 1, '2010-08-03 19:56:47', 0, 'S', '', 1336, '127.0.0.1', 'workflowtransactionhistory_id', ''),
('sim_hr_employee', 'Record deleted permanentl', 'E', 1, '2010-08-04 06:56:40', 0, 'F', 'admin', 1337, '::1', 'employee_id', '1312'),
('sim_hr_employee', 'Record deleted permanentl', 'E', 1, '2010-08-04 06:56:54', 0, 'F', 'admin', 1338, '::1', 'employee_id', '1312'),
('sim_hr_employee', 'Record deleted permanentl', 'E', 1, '2010-08-04 06:57:50', 0, 'F', 'admin', 1339, '127.0.0.1', 'employee_id', '1312'),
('sim_hr_employee', 'Record deleted permanentl', 'E', 1, '2010-08-04 07:03:28', 0, 'F', 'admin', 1340, '127.0.0.1', 'employee_id', '1312'),
('sim_hr_employee', 'Record deleted permanentl', 'E', 1, '2010-08-04 07:05:49', 0, 'F', 'admin', 1341, '127.0.0.1', 'employee_id', 'c'),
('sim_hr_employee', 'Record deleted permanentl', 'E', 1, '2010-08-04 07:06:18', 0, 'F', 'admin', 1342, '127.0.0.1', 'employee_id', 'DS'),
('sim_hr_employee', 'Record deleted permanentl', 'E', 1, '2010-08-04 07:07:52', 0, 'F', 'admin', 1343, '127.0.0.1', 'employee_id', 'DDDD'),
('sim_hr_employee', 'Record deleted permanentl', 'E', 1, '2010-08-04 07:08:00', 0, 'F', 'admin', 1344, '127.0.0.1', 'employee_id', 'DDDD'),
('sim_hr_employee', 'employee_name=''qqqqq''employee_cardno=''''employee_no=''qqqq''uid=''''place_dob=''''employee_dob=''2010-08-17''races_id=''0''religion_id=''1''gender=''M''marital_status=''0''employee_citizenship=''2''employee_newicno=''''employee_oldicno=''''ic_color=''B''employee_passport=''''employee_bloodgroup=''''department_id=''2''jobposition_id=''56''employeegroup_id=''10''employee_joindate=''2010-08-04''filephoto=''''updated=''2010-08-04 07:08:28''updatedby=''1''seqno=''''organization_id=''''created=''2010-08-04 07:08:28''createdby=''1''employee_transport=''''employee_status=''1''isactive=''1''employee_altname=''''ic_placeissue=''''employee_passport_placeissue=''''employee_passport_issuedate=''''employee_passport_expirydate=''''employee_confirmdate=''''employee_enddate=''', 'I', 1, '2010-08-04 07:08:28', 37, 'S', 'admin', 1345, '127.0.0.1', 'employee_id', 'qqqqq'),
('sim_hr_employee', 'Record deleted permanentl', 'E', 1, '2010-08-04 07:08:36', 0, 'F', 'admin', 1346, '127.0.0.1', 'employee_id', 'qqqq'),
('sim_hr_employee', 'Record deleted permanentl', 'E', 1, '2010-08-04 07:09:41', 0, 'F', 'admin', 1347, '127.0.0.1', 'employee_id', 'qqqq'),
('sim_hr_employee', 'Record deleted permanentl', 'E', 1, '2010-08-04 07:10:43', 0, 'F', 'admin', 1348, '127.0.0.1', 'employee_id', 'qqqq'),
('sim_hr_employee', 'Record deleted permanentl', 'E', 1, '2010-08-04 07:11:39', 37, 'S', 'admin', 1349, '127.0.0.1', 'employee_id', 'qqqq'),
('sim_hr_employee', 'employee_name=''QQ''employee_cardno=''''employee_no=''QQ''uid=''''place_dob=''''employee_dob=''2010-08-10''races_id=''0''religion_id=''1''gender=''M''marital_status=''0''employee_citizenship=''2''employee_newicno=''''employee_oldicno=''''ic_color=''B''employee_passport=''''employee_bloodgroup=''''department_id=''2''jobposition_id=''53''employeegroup_id=''10''employee_joindate=''2010-08-04''filephoto=''''updated=''2010-08-04 07:12:05''updatedby=''1''seqno=''''organization_id=''''created=''2010-08-04 07:12:05''createdby=''1''employee_transport=''''employee_status=''1''isactive=''1''employee_altname=''''ic_placeissue=''''employee_passport_placeissue=''''employee_passport_issuedate=''''employee_passport_expirydate=''''employee_confirmdate=''''employee_enddate=''', 'I', 1, '2010-08-04 07:12:05', 38, 'S', 'admin', 1350, '127.0.0.1', 'employee_id', 'QQ'),
('sim_hr_department', 'Record deleted permanentl', 'E', 1, '2010-08-04 07:19:00', 2, 'F', 'admin', 1351, '127.0.0.1', 'department_id', 'HR'),
('sim_hr_generalclaim', 'employee_id=''A-Tester(16)''generalclaim_date=''2010-08-11''generalclaim_docno=''''generalclaim_remark=''''period_id=''wer(10)''created=''10/08/04 10:29:03''createdby=''admin(1)''updated=''10/08/04 10:29:03''updatedby=''admin(1)''organization_id=''1', 'I', 1, '2010-08-04 10:29:03', 1, 'S', 'admin', 1352, '::1', 'generalclaim_id', ''),
('sim_hr_medicalclaim', 'employee_id=''Ali Bin Ahmad(14)''medicalclaim_date=''2010-08-11''medicalclaim_clinic=''asd''medicalclaim_docno=''asd''medicalclaim_amount=''123''medicalclaim_treatment=''asd''medicalclaim_remark=''''period_id=''wer(10)''created=''10/08/04 10:29:35''createdby=''admin(1)''updated=''10/08/04 10:29:35''updatedby=''admin(1)''organization_id=''1', 'I', 1, '2010-08-04 10:29:35', 2, 'S', 'admin', 1353, '::1', 'medicalclaim_id', 'asd'),
('sim_hr_generalclaim', 'employee_id=''A1(35)''generalclaim_date=''2010-08-17''generalclaim_docno=''''generalclaim_remark=''''period_id=''wer(10)''created=''10/08/04 10:34:04''createdby=''admin(1)''updated=''10/08/04 10:34:04''updatedby=''admin(1)''organization_id=''1', 'I', 1, '2010-08-04 10:34:04', 2, 'S', 'admin', 1354, '::1', 'generalclaim_id', ''),
('sim_hr_generalclaim', 'employee_id=''35A1'',<br/>issubmit=''1''', 'U', 1, '2010-08-04 10:34:08', 2, 'S', 'admin', 1355, '::1', 'generalclaim_id', ''),
('sim_workflowtransaction', 'workflowtransaction_datetime=''10/08/04 10:34:08''target_groupid=''1''target_uid=''0''targetparameter_name=''0,23''workflowstatus_id=''1''workflow_id=''4''tablename=''sim_hr_generalclaim''primarykey_name=''generalclaim_id''primarykey_value=''2''hyperlink=''../hr/generalclaim.php''title_description=''''created=''10/08/04 10:34:08''list_parameter=''''workflowtransaction_description=''Ok done''workflowtransaction_feedback=''''iscomplete=''0''createdby=''1''email_list=''1,0,23''sms_list=''1,0,23''email_body=''''sms_body=''''person_id=''35''issubmit=''1', 'I', 1, '2010-08-04 10:34:08', 99, 'S', 'admin', 1356, '::1', 'workflowtransaction_id', 'sim_hr_generalclaim'),
('sim_workflowtransactionhistory', 'workflowtransaction_id=''99''workflowstatus_id=''1''workflowtransaction_datetime=''10/08/04 10:34:08''uid=''1''workflowtransactionhistory_description=''', 'I', 1, '2010-08-04 10:34:08', 0, 'S', 'admin', 1357, '::1', 'workflowtransactionhistory_id', ''),
('sim_country', 'isactive=''1''', 'U', 1, '2010-08-04 10:49:29', 3, 'S', 'admin', 1358, '::1', 'country_id', 'MY'),
('sim_hr_generalclaim', 'employee_id=''A-Tester(16)''generalclaim_date=''2010-08-12''generalclaim_docno=''''generalclaim_remark=''''period_id=''wer(10)''created=''10/08/04 10:51:37''createdby=''admin(1)''updated=''10/08/04 10:51:37''updatedby=''admin(1)''organization_id=''1', 'I', 1, '2010-08-04 10:51:38', 3, 'S', 'admin', 1359, '::1', 'generalclaim_id', ''),
('sim_hr_generalclaim', 'employee_id=''16A-Tester'',<br/>issubmit=''1''', 'U', 1, '2010-08-04 10:51:41', 3, 'S', 'admin', 1360, '::1', 'generalclaim_id', ''),
('sim_workflowtransaction', 'workflowtransaction_datetime=''10/08/04 10:51:41''target_groupid=''1''target_uid=''0''targetparameter_name=''0,23''workflowstatus_id=''1''workflow_id=''4''tablename=''sim_hr_generalclaim''primarykey_name=''generalclaim_id''primarykey_value=''3''hyperlink=''../hr/generalclaim.php''title_description=''''created=''10/08/04 10:51:41''list_parameter=''''workflowtransaction_description=''Ok done''workflowtransaction_feedback=''''iscomplete=''0''createdby=''1''email_list=''1,0,23''sms_list=''1,0,23''email_body=''''sms_body=''''person_id=''16''issubmit=''1', 'I', 1, '2010-08-04 10:51:41', 100, 'S', 'admin', 1361, '::1', 'workflowtransaction_id', 'sim_hr_generalclaim'),
('sim_workflowtransactionhistory', 'workflowtransaction_id=''100''workflowstatus_id=''1''workflowtransaction_datetime=''10/08/04 10:51:41''uid=''1''workflowtransactionhistory_description=''', 'I', 1, '2010-08-04 10:51:41', 0, 'S', 'admin', 1362, '::1', 'workflowtransactionhistory_id', ''),
('sim_workflowtransaction', 'workflowtransaction_datetime=''10/08/04 10:51:57''target_groupid=''1''target_uid=''0''targetparameter_name=''1''workflowstatus_id=''5''workflow_id=''4''tablename=''sim_hr_generalclaim''primarykey_name=''generalclaim_id''primarykey_value=''3''hyperlink=''''title_description=''''created=''10/08/04 10:51:57''list_parameter=''''workflowtransaction_description=''''workflowtransaction_feedback=''''iscomplete=''0''createdby=''1''email_list=''''sms_list=''''email_body=''''sms_body=''''person_id=''16''issubmit=''0', 'I', 1, '2010-08-04 10:51:57', 101, 'S', 'admin', 1363, '::1', 'workflowtransaction_id', 'sim_hr_generalclaim'),
('sim_workflowtransactionhistory', 'workflowtransaction_id=''101''workflowstatus_id=''5''workflowtransaction_datetime=''10/08/04 10:51:57''uid=''1''workflowtransactionhistory_description=''', 'I', 1, '2010-08-04 10:51:57', 0, 'S', 'admin', 1364, '::1', 'workflowtransactionhistory_id', ''),
('sim_hr_leaveadjustment', 'adjustment_for=''''created=''10/08/04 11:51:00''createdby=''admin(1)''updated=''10/08/04 11:51:00''updatedby=''admin(1)''organization_id=''1', 'I', 1, '2010-08-04 11:51:00', 1, 'S', 'admin', 1365, '::1', 'leaveadjustment_id', 'admin'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''1''employee_id=''23''leavetype_id=''8''leaveadjustmentline_totalday=''2''created=''2010-08-04 11:51:00''createdby=''1''updated=''2010-08-04 11:51:00''updatedby=''1', 'I', 1, '2010-08-04 11:51:00', 127, 'S', 'admin', 1366, '::1', 'leaveadjustmentline_id', '1'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''1''employee_id=''23''leavetype_id=''10''leaveadjustmentline_totalday=''2''created=''2010-08-04 11:51:00''createdby=''1''updated=''2010-08-04 11:51:00''updatedby=''1', 'I', 1, '2010-08-04 11:51:00', 128, 'S', 'admin', 1367, '::1', 'leaveadjustmentline_id', '1'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''1''employee_id=''23''leavetype_id=''16''leaveadjustmentline_totalday=''2''created=''2010-08-04 11:51:00''createdby=''1''updated=''2010-08-04 11:51:00''updatedby=''1', 'I', 1, '2010-08-04 11:51:00', 129, 'S', 'admin', 1368, '::1', 'leaveadjustmentline_id', '1'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''1''employee_id=''23''leavetype_id=''9''leaveadjustmentline_totalday=''2''created=''2010-08-04 11:51:00''createdby=''1''updated=''2010-08-04 11:51:00''updatedby=''1', 'I', 1, '2010-08-04 11:51:00', 130, 'S', 'admin', 1369, '::1', 'leaveadjustmentline_id', '1'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''1''employee_id=''16''leavetype_id=''8''leaveadjustmentline_totalday=''2''created=''2010-08-04 11:51:00''createdby=''1''updated=''2010-08-04 11:51:00''updatedby=''1', 'I', 1, '2010-08-04 11:51:00', 131, 'S', 'admin', 1370, '::1', 'leaveadjustmentline_id', '1'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''1''employee_id=''16''leavetype_id=''10''leaveadjustmentline_totalday=''2''created=''2010-08-04 11:51:00''createdby=''1''updated=''2010-08-04 11:51:00''updatedby=''1', 'I', 1, '2010-08-04 11:51:00', 132, 'S', 'admin', 1371, '::1', 'leaveadjustmentline_id', '1'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''1''employee_id=''16''leavetype_id=''16''leaveadjustmentline_totalday=''2''created=''2010-08-04 11:51:00''createdby=''1''updated=''2010-08-04 11:51:00''updatedby=''1', 'I', 1, '2010-08-04 11:51:01', 133, 'S', 'admin', 1372, '::1', 'leaveadjustmentline_id', '1'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''1''employee_id=''16''leavetype_id=''9''leaveadjustmentline_totalday=''2''created=''2010-08-04 11:51:00''createdby=''1''updated=''2010-08-04 11:51:00''updatedby=''1', 'I', 1, '2010-08-04 11:51:01', 134, 'S', 'admin', 1373, '::1', 'leaveadjustmentline_id', '1'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''1''employee_id=''35''leavetype_id=''8''leaveadjustmentline_totalday=''2''created=''2010-08-04 11:51:00''createdby=''1''updated=''2010-08-04 11:51:00''updatedby=''1', 'I', 1, '2010-08-04 11:51:01', 135, 'S', 'admin', 1374, '::1', 'leaveadjustmentline_id', '1'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''1''employee_id=''35''leavetype_id=''10''leaveadjustmentline_totalday=''2''created=''2010-08-04 11:51:00''createdby=''1''updated=''2010-08-04 11:51:00''updatedby=''1', 'I', 1, '2010-08-04 11:51:01', 136, 'S', 'admin', 1375, '::1', 'leaveadjustmentline_id', '1'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''1''employee_id=''35''leavetype_id=''16''leaveadjustmentline_totalday=''2''created=''2010-08-04 11:51:00''createdby=''1''updated=''2010-08-04 11:51:00''updatedby=''1', 'I', 1, '2010-08-04 11:51:01', 137, 'S', 'admin', 1376, '::1', 'leaveadjustmentline_id', '1'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''1''employee_id=''35''leavetype_id=''9''leaveadjustmentline_totalday=''2''created=''2010-08-04 11:51:00''createdby=''1''updated=''2010-08-04 11:51:00''updatedby=''1', 'I', 1, '2010-08-04 11:51:01', 138, 'S', 'admin', 1377, '::1', 'leaveadjustmentline_id', '1');
INSERT INTO `sim_audit` (`tablename`, `changedesc`, `category`, `uid`, `updated`, `record_id`, `eventype`, `uname`, `audit_id`, `ip`, `primarykey`, `controlvalue`) VALUES
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''1''employee_id=''14''leavetype_id=''8''leaveadjustmentline_totalday=''2''created=''2010-08-04 11:51:00''createdby=''1''updated=''2010-08-04 11:51:00''updatedby=''1', 'I', 1, '2010-08-04 11:51:01', 139, 'S', 'admin', 1378, '::1', 'leaveadjustmentline_id', '1'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''1''employee_id=''14''leavetype_id=''10''leaveadjustmentline_totalday=''2''created=''2010-08-04 11:51:00''createdby=''1''updated=''2010-08-04 11:51:00''updatedby=''1', 'I', 1, '2010-08-04 11:51:01', 140, 'S', 'admin', 1379, '::1', 'leaveadjustmentline_id', '1'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''1''employee_id=''14''leavetype_id=''16''leaveadjustmentline_totalday=''2''created=''2010-08-04 11:51:00''createdby=''1''updated=''2010-08-04 11:51:00''updatedby=''1', 'I', 1, '2010-08-04 11:51:01', 141, 'S', 'admin', 1380, '::1', 'leaveadjustmentline_id', '1'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''1''employee_id=''14''leavetype_id=''9''leaveadjustmentline_totalday=''2''created=''2010-08-04 11:51:00''createdby=''1''updated=''2010-08-04 11:51:00''updatedby=''1', 'I', 1, '2010-08-04 11:51:01', 142, 'S', 'admin', 1381, '::1', 'leaveadjustmentline_id', '1'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''1''employee_id=''17''leavetype_id=''8''leaveadjustmentline_totalday=''2''created=''2010-08-04 11:51:00''createdby=''1''updated=''2010-08-04 11:51:00''updatedby=''1', 'I', 1, '2010-08-04 11:51:01', 143, 'S', 'admin', 1382, '::1', 'leaveadjustmentline_id', '1'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''1''employee_id=''17''leavetype_id=''10''leaveadjustmentline_totalday=''2''created=''2010-08-04 11:51:00''createdby=''1''updated=''2010-08-04 11:51:00''updatedby=''1', 'I', 1, '2010-08-04 11:51:01', 144, 'S', 'admin', 1383, '::1', 'leaveadjustmentline_id', '1'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''1''employee_id=''17''leavetype_id=''16''leaveadjustmentline_totalday=''2''created=''2010-08-04 11:51:00''createdby=''1''updated=''2010-08-04 11:51:00''updatedby=''1', 'I', 1, '2010-08-04 11:51:01', 145, 'S', 'admin', 1384, '::1', 'leaveadjustmentline_id', '1'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''1''employee_id=''17''leavetype_id=''9''leaveadjustmentline_totalday=''2''created=''2010-08-04 11:51:00''createdby=''1''updated=''2010-08-04 11:51:00''updatedby=''1', 'I', 1, '2010-08-04 11:51:01', 146, 'S', 'admin', 1385, '::1', 'leaveadjustmentline_id', '1'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''1''employee_id=''36''leavetype_id=''8''leaveadjustmentline_totalday=''2''created=''2010-08-04 11:51:00''createdby=''1''updated=''2010-08-04 11:51:00''updatedby=''1', 'I', 1, '2010-08-04 11:51:01', 147, 'S', 'admin', 1386, '::1', 'leaveadjustmentline_id', '1'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''1''employee_id=''36''leavetype_id=''10''leaveadjustmentline_totalday=''2''created=''2010-08-04 11:51:00''createdby=''1''updated=''2010-08-04 11:51:00''updatedby=''1', 'I', 1, '2010-08-04 11:51:01', 148, 'S', 'admin', 1387, '::1', 'leaveadjustmentline_id', '1'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''1''employee_id=''36''leavetype_id=''16''leaveadjustmentline_totalday=''2''created=''2010-08-04 11:51:00''createdby=''1''updated=''2010-08-04 11:51:00''updatedby=''1', 'I', 1, '2010-08-04 11:51:01', 149, 'S', 'admin', 1388, '::1', 'leaveadjustmentline_id', '1'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''1''employee_id=''36''leavetype_id=''9''leaveadjustmentline_totalday=''2''created=''2010-08-04 11:51:00''createdby=''1''updated=''2010-08-04 11:51:00''updatedby=''1', 'I', 1, '2010-08-04 11:51:02', 150, 'S', 'admin', 1389, '::1', 'leaveadjustmentline_id', '1'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''1''employee_id=''22''leavetype_id=''8''leaveadjustmentline_totalday=''2''created=''2010-08-04 11:51:00''createdby=''1''updated=''2010-08-04 11:51:00''updatedby=''1', 'I', 1, '2010-08-04 11:51:02', 151, 'S', 'admin', 1390, '::1', 'leaveadjustmentline_id', '1'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''1''employee_id=''22''leavetype_id=''10''leaveadjustmentline_totalday=''2''created=''2010-08-04 11:51:00''createdby=''1''updated=''2010-08-04 11:51:00''updatedby=''1', 'I', 1, '2010-08-04 11:51:02', 152, 'S', 'admin', 1391, '::1', 'leaveadjustmentline_id', '1'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''1''employee_id=''22''leavetype_id=''16''leaveadjustmentline_totalday=''2''created=''2010-08-04 11:51:00''createdby=''1''updated=''2010-08-04 11:51:00''updatedby=''1', 'I', 1, '2010-08-04 11:51:02', 153, 'S', 'admin', 1392, '::1', 'leaveadjustmentline_id', '1'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''1''employee_id=''22''leavetype_id=''9''leaveadjustmentline_totalday=''2''created=''2010-08-04 11:51:00''createdby=''1''updated=''2010-08-04 11:51:00''updatedby=''1', 'I', 1, '2010-08-04 11:51:02', 154, 'S', 'admin', 1393, '::1', 'leaveadjustmentline_id', '1'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''1''employee_id=''21''leavetype_id=''8''leaveadjustmentline_totalday=''2''created=''2010-08-04 11:51:00''createdby=''1''updated=''2010-08-04 11:51:00''updatedby=''1', 'I', 1, '2010-08-04 11:51:02', 155, 'S', 'admin', 1394, '::1', 'leaveadjustmentline_id', '1'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''1''employee_id=''21''leavetype_id=''10''leaveadjustmentline_totalday=''2''created=''2010-08-04 11:51:00''createdby=''1''updated=''2010-08-04 11:51:00''updatedby=''1', 'I', 1, '2010-08-04 11:51:02', 156, 'S', 'admin', 1395, '::1', 'leaveadjustmentline_id', '1'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''1''employee_id=''21''leavetype_id=''16''leaveadjustmentline_totalday=''2''created=''2010-08-04 11:51:00''createdby=''1''updated=''2010-08-04 11:51:00''updatedby=''1', 'I', 1, '2010-08-04 11:51:02', 157, 'S', 'admin', 1396, '::1', 'leaveadjustmentline_id', '1'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''1''employee_id=''21''leavetype_id=''9''leaveadjustmentline_totalday=''2''created=''2010-08-04 11:51:00''createdby=''1''updated=''2010-08-04 11:51:00''updatedby=''1', 'I', 1, '2010-08-04 11:51:02', 158, 'S', 'admin', 1397, '::1', 'leaveadjustmentline_id', '1'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''1''employee_id=''18''leavetype_id=''8''leaveadjustmentline_totalday=''2''created=''2010-08-04 11:51:00''createdby=''1''updated=''2010-08-04 11:51:00''updatedby=''1', 'I', 1, '2010-08-04 11:51:02', 159, 'S', 'admin', 1398, '::1', 'leaveadjustmentline_id', '1'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''1''employee_id=''18''leavetype_id=''10''leaveadjustmentline_totalday=''2''created=''2010-08-04 11:51:00''createdby=''1''updated=''2010-08-04 11:51:00''updatedby=''1', 'I', 1, '2010-08-04 11:51:02', 160, 'S', 'admin', 1399, '::1', 'leaveadjustmentline_id', '1'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''1''employee_id=''18''leavetype_id=''16''leaveadjustmentline_totalday=''2''created=''2010-08-04 11:51:00''createdby=''1''updated=''2010-08-04 11:51:00''updatedby=''1', 'I', 1, '2010-08-04 11:51:02', 161, 'S', 'admin', 1400, '::1', 'leaveadjustmentline_id', '1'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''1''employee_id=''18''leavetype_id=''9''leaveadjustmentline_totalday=''2''created=''2010-08-04 11:51:00''createdby=''1''updated=''2010-08-04 11:51:00''updatedby=''1', 'I', 1, '2010-08-04 11:51:02', 162, 'S', 'admin', 1401, '::1', 'leaveadjustmentline_id', '1'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''1''employee_id=''19''leavetype_id=''8''leaveadjustmentline_totalday=''2''created=''2010-08-04 11:51:00''createdby=''1''updated=''2010-08-04 11:51:00''updatedby=''1', 'I', 1, '2010-08-04 11:51:02', 163, 'S', 'admin', 1402, '::1', 'leaveadjustmentline_id', '1'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''1''employee_id=''19''leavetype_id=''10''leaveadjustmentline_totalday=''2''created=''2010-08-04 11:51:00''createdby=''1''updated=''2010-08-04 11:51:00''updatedby=''1', 'I', 1, '2010-08-04 11:51:02', 164, 'S', 'admin', 1403, '::1', 'leaveadjustmentline_id', '1'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''1''employee_id=''19''leavetype_id=''''leaveadjustmentline_totalday=''2''created=''2010-08-04 11:51:00''createdby=''1''updated=''2010-08-04 11:51:00''updatedby=''1', 'I', 1, '2010-08-04 11:51:02', 165, 'S', 'admin', 1404, '::1', 'leaveadjustmentline_id', '1'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''1''employee_id=''19''leavetype_id=''''leaveadjustmentline_totalday=''2''created=''2010-08-04 11:51:00''createdby=''1''updated=''2010-08-04 11:51:00''updatedby=''1', 'I', 1, '2010-08-04 11:51:02', 166, 'S', 'admin', 1405, '::1', 'leaveadjustmentline_id', '1'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''1''employee_id=''33''leavetype_id=''9''leaveadjustmentline_totalday=''2''created=''2010-08-04 11:51:00''createdby=''1''updated=''2010-08-04 11:51:00''updatedby=''1', 'I', 1, '2010-08-04 11:51:02', 167, 'S', 'admin', 1406, '::1', 'leaveadjustmentline_id', '1'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''1''employee_id=''33''leavetype_id=''8''leaveadjustmentline_totalday=''2''created=''2010-08-04 11:51:00''createdby=''1''updated=''2010-08-04 11:51:00''updatedby=''1', 'I', 1, '2010-08-04 11:51:02', 168, 'S', 'admin', 1407, '::1', 'leaveadjustmentline_id', '1'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''1''employee_id=''33''leavetype_id=''10''leaveadjustmentline_totalday=''2''created=''2010-08-04 11:51:00''createdby=''1''updated=''2010-08-04 11:51:00''updatedby=''1', 'I', 1, '2010-08-04 11:51:03', 169, 'S', 'admin', 1408, '::1', 'leaveadjustmentline_id', '1'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''1''employee_id=''33''leavetype_id=''16''leaveadjustmentline_totalday=''2''created=''2010-08-04 11:51:00''createdby=''1''updated=''2010-08-04 11:51:00''updatedby=''1', 'I', 1, '2010-08-04 11:51:03', 170, 'S', 'admin', 1409, '::1', 'leaveadjustmentline_id', '1'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''1''employee_id=''''leavetype_id=''9''leaveadjustmentline_totalday=''2''created=''2010-08-04 11:51:00''createdby=''1''updated=''2010-08-04 11:51:00''updatedby=''1', 'I', 1, '2010-08-04 11:51:03', 171, 'S', 'admin', 1410, '::1', 'leaveadjustmentline_id', '1'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''1''employee_id=''''leavetype_id=''8''leaveadjustmentline_totalday=''2''created=''2010-08-04 11:51:00''createdby=''1''updated=''2010-08-04 11:51:00''updatedby=''1', 'I', 1, '2010-08-04 11:51:03', 172, 'S', 'admin', 1411, '::1', 'leaveadjustmentline_id', '1'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''1''employee_id=''38''leavetype_id=''10''leaveadjustmentline_totalday=''2''created=''2010-08-04 11:51:00''createdby=''1''updated=''2010-08-04 11:51:00''updatedby=''1', 'I', 1, '2010-08-04 11:51:03', 173, 'S', 'admin', 1412, '::1', 'leaveadjustmentline_id', '1'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''1''employee_id=''38''leavetype_id=''16''leaveadjustmentline_totalday=''2''created=''2010-08-04 11:51:00''createdby=''1''updated=''2010-08-04 11:51:00''updatedby=''1', 'I', 1, '2010-08-04 11:51:03', 174, 'S', 'admin', 1413, '::1', 'leaveadjustmentline_id', '1'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''1''employee_id=''38''leavetype_id=''9''leaveadjustmentline_totalday=''2''created=''2010-08-04 11:51:00''createdby=''1''updated=''2010-08-04 11:51:00''updatedby=''1', 'I', 1, '2010-08-04 11:51:03', 175, 'S', 'admin', 1414, '::1', 'leaveadjustmentline_id', '1'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''1''employee_id=''24''leavetype_id=''8''leaveadjustmentline_totalday=''2''created=''2010-08-04 11:51:00''createdby=''1''updated=''2010-08-04 11:51:00''updatedby=''1', 'I', 1, '2010-08-04 11:51:03', 176, 'S', 'admin', 1415, '::1', 'leaveadjustmentline_id', '1'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''1''employee_id=''24''leavetype_id=''10''leaveadjustmentline_totalday=''2''created=''2010-08-04 11:51:00''createdby=''1''updated=''2010-08-04 11:51:00''updatedby=''1', 'I', 1, '2010-08-04 11:51:03', 177, 'S', 'admin', 1416, '::1', 'leaveadjustmentline_id', '1'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''1''employee_id=''24''leavetype_id=''16''leaveadjustmentline_totalday=''2''created=''2010-08-04 11:51:00''createdby=''1''updated=''2010-08-04 11:51:00''updatedby=''1', 'I', 1, '2010-08-04 11:51:03', 178, 'S', 'admin', 1417, '::1', 'leaveadjustmentline_id', '1'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''1''employee_id=''24''leavetype_id=''9''leaveadjustmentline_totalday=''2''created=''2010-08-04 11:51:00''createdby=''1''updated=''2010-08-04 11:51:00''updatedby=''1', 'I', 1, '2010-08-04 11:51:03', 179, 'S', 'admin', 1418, '::1', 'leaveadjustmentline_id', '1'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''1''employee_id=''30''leavetype_id=''8''leaveadjustmentline_totalday=''2''created=''2010-08-04 11:51:00''createdby=''1''updated=''2010-08-04 11:51:00''updatedby=''1', 'I', 1, '2010-08-04 11:51:03', 180, 'S', 'admin', 1419, '::1', 'leaveadjustmentline_id', '1'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''1''employee_id=''30''leavetype_id=''10''leaveadjustmentline_totalday=''2''created=''2010-08-04 11:51:00''createdby=''1''updated=''2010-08-04 11:51:00''updatedby=''1', 'I', 1, '2010-08-04 11:51:03', 181, 'S', 'admin', 1420, '::1', 'leaveadjustmentline_id', '1'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''1''employee_id=''30''leavetype_id=''16''leaveadjustmentline_totalday=''2''created=''2010-08-04 11:51:00''createdby=''1''updated=''2010-08-04 11:51:00''updatedby=''1', 'I', 1, '2010-08-04 11:51:03', 182, 'S', 'admin', 1421, '::1', 'leaveadjustmentline_id', '1'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''1''employee_id=''30''leavetype_id=''9''leaveadjustmentline_totalday=''2''created=''2010-08-04 11:51:00''createdby=''1''updated=''2010-08-04 11:51:00''updatedby=''1', 'I', 1, '2010-08-04 11:51:03', 183, 'S', 'admin', 1422, '::1', 'leaveadjustmentline_id', '1'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''1''employee_id=''15''leavetype_id=''8''leaveadjustmentline_totalday=''2''created=''2010-08-04 11:51:00''createdby=''1''updated=''2010-08-04 11:51:00''updatedby=''1', 'I', 1, '2010-08-04 11:51:03', 184, 'S', 'admin', 1423, '::1', 'leaveadjustmentline_id', '1'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''1''employee_id=''15''leavetype_id=''10''leaveadjustmentline_totalday=''2''created=''2010-08-04 11:51:00''createdby=''1''updated=''2010-08-04 11:51:00''updatedby=''1', 'I', 1, '2010-08-04 11:51:03', 185, 'S', 'admin', 1424, '::1', 'leaveadjustmentline_id', '1'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''1''employee_id=''15''leavetype_id=''16''leaveadjustmentline_totalday=''2''created=''2010-08-04 11:51:00''createdby=''1''updated=''2010-08-04 11:51:00''updatedby=''1', 'I', 1, '2010-08-04 11:51:03', 186, 'S', 'admin', 1425, '::1', 'leaveadjustmentline_id', '1'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''1''employee_id=''15''leavetype_id=''9''leaveadjustmentline_totalday=''2''created=''2010-08-04 11:51:00''createdby=''1''updated=''2010-08-04 11:51:00''updatedby=''1', 'I', 1, '2010-08-04 11:51:04', 187, 'S', 'admin', 1426, '::1', 'leaveadjustmentline_id', '1'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''1''employee_id=''20''leavetype_id=''8''leaveadjustmentline_totalday=''2''created=''2010-08-04 11:51:00''createdby=''1''updated=''2010-08-04 11:51:00''updatedby=''1', 'I', 1, '2010-08-04 11:51:04', 188, 'S', 'admin', 1427, '::1', 'leaveadjustmentline_id', '1'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''1''employee_id=''20''leavetype_id=''10''leaveadjustmentline_totalday=''2''created=''2010-08-04 11:51:00''createdby=''1''updated=''2010-08-04 11:51:00''updatedby=''1', 'I', 1, '2010-08-04 11:51:04', 189, 'S', 'admin', 1428, '::1', 'leaveadjustmentline_id', '1'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''1''employee_id=''20''leavetype_id=''16''leaveadjustmentline_totalday=''2''created=''2010-08-04 11:51:00''createdby=''1''updated=''2010-08-04 11:51:00''updatedby=''1', 'I', 1, '2010-08-04 11:51:04', 190, 'S', 'admin', 1429, '::1', 'leaveadjustmentline_id', '1'),
('sim_hr_leaveadjustment', 'issubmit=''1''', 'U', 1, '2010-08-04 11:51:12', 1, 'S', 'admin', 1430, '::1', 'leaveadjustment_id', '1'),
('sim_workflowtransaction', 'workflowtransaction_datetime=''10/08/04 11:51:12''target_groupid=''1''target_uid=''0''targetparameter_name=''10''workflowstatus_id=''1''workflow_id=''8''tablename=''sim_hr_leaveadjustment''primarykey_name=''leaveadjustment_id''primarykey_value=''1''hyperlink=''../hr/leaveadjustment.php''title_description=''''created=''10/08/04 11:51:12''list_parameter=''''workflowtransaction_description=''''workflowtransaction_feedback=''''iscomplete=''0''createdby=''1''email_list=''10''sms_list=''10''email_body=''''sms_body=''''person_id=''14''issubmit=''1', 'I', 1, '2010-08-04 11:51:12', 1, 'S', 'admin', 1431, '::1', 'workflowtransaction_id', 'sim_hr_leaveadjustment'),
('sim_workflowtransactionhistory', 'workflowtransaction_id=''1''workflowstatus_id=''1''workflowtransaction_datetime=''10/08/04 11:51:12''uid=''1''workflowtransactionhistory_description=''', 'I', 1, '2010-08-04 11:51:12', 0, 'S', 'admin', 1432, '::1', 'workflowtransactionhistory_id', ''),
('sim_hr_employeegroup', 'Record deleted permanentl', 'E', 1, '2010-08-04 11:53:08', 10, 'F', 'admin', 1433, '::1', 'employeegroup_id', 'LP'),
('sim_bpartnergroup', 'bpartnergroup_name=''WW''isactive=''1''seqno=''10''created=''2010-08-04 11:57:23''createdby=''1''updated=''2010-08-04 11:57:23''updatedby=''1''organization_id=''1''description=''EE', 'I', 1, '2010-08-04 11:57:23', 2, 'S', 'admin', 1434, '::1', 'bpartnergroup_id', 'WW'),
('sim_bpartnergroup', 'bpartnergroup_name=''asd''isactive=''1''seqno=''10''created=''2010-08-04 11:59:34''createdby=''1''updated=''2010-08-04 11:59:34''updatedby=''1''organization_id=''1''description=''asd', 'I', 1, '2010-08-04 11:59:34', 3, 'S', 'admin', 1435, '::1', 'bpartnergroup_id', 'asd'),
('sim_bpartnergroup', 'Record deleted permanentl', 'E', 1, '2010-08-04 12:00:20', 1, 'S', 'admin', 1436, '::1', 'bpartnergroup_id', ''),
('sim_industry', 'industry_name=''asd''isactive=''1''seqno=''10''created=''2010-08-04 12:04:23''createdby=''1''updated=''2010-08-04 12:04:23''updatedby=''1''organization_id=''1''description=''', 'I', 1, '2010-08-04 12:04:23', 3, 'S', 'admin', 1437, '::1', 'industry_id', 'asd'),
('sim_industry', 'industry_name=''22''isactive=''1''seqno=''10''created=''2010-08-04 12:04:33''createdby=''1''updated=''2010-08-04 12:04:33''updatedby=''1''organization_id=''1''description=''22', 'I', 1, '2010-08-04 12:04:33', 4, 'S', 'admin', 1438, '::1', 'industry_id', '22'),
('sim_industry', 'industry_name=''11''isactive=''1''seqno=''10''created=''2010-08-04 12:04:33''createdby=''1''updated=''2010-08-04 12:04:33''updatedby=''1''organization_id=''1''description=''11', 'I', 1, '2010-08-04 12:04:33', 5, 'S', 'admin', 1439, '::1', 'industry_id', '11'),
('sim_industry', 'isactive=''0''', 'U', 1, '2010-08-04 12:04:37', 5, 'S', 'admin', 1440, '::1', 'industry_id', '11'),
('sim_industry', 'industry_name=''222''', 'U', 1, '2010-08-04 12:04:43', 4, 'S', 'admin', 1441, '::1', 'industry_id', '222'),
('sim_industry', 'description=''2''', 'U', 1, '2010-08-04 12:04:43', 3, 'S', 'admin', 1442, '::1', 'industry_id', 'asd'),
('sim_industry', 'isdeleted=', 'D', 1, '2010-08-04 12:04:48', 4, 'S', 'admin', 1443, '::1', 'industry_id', ''),
('sim_industry', 'isdeleted=', 'D', 1, '2010-08-04 12:04:50', 3, 'S', 'admin', 1444, '::1', 'industry_id', ''),
('sim_bpartnergroup', 'bpartnergroup_name=''11''isactive=''1''seqno=''10''created=''2010-08-04 12:07:59''createdby=''1''updated=''2010-08-04 12:07:59''updatedby=''1''organization_id=''1''description=''22', 'I', 1, '2010-08-04 12:07:59', 4, 'S', 'admin', 1445, '::1', 'bpartnergroup_id', '11'),
('sim_bpartnergroup', 'bpartnergroup_name=''11''isactive=''1''seqno=''10''created=''2010-08-04 12:07:59''createdby=''1''updated=''2010-08-04 12:07:59''updatedby=''1''organization_id=''1''description=''22', 'I', 1, '2010-08-04 12:07:59', 5, 'S', 'admin', 1446, '::1', 'bpartnergroup_id', '11'),
('sim_bpartnergroup', 'description=''221''', 'U', 1, '2010-08-04 12:08:16', 5, 'S', 'admin', 1447, '::1', 'bpartnergroup_id', '11'),
('sim_bpartnergroup', 'description=''2212''', 'U', 1, '2010-08-04 12:08:16', 4, 'S', 'admin', 1448, '::1', 'bpartnergroup_id', '11'),
('sim_industry', 'industry_name=''11''isactive=''1''seqno=''0''created=''2010-08-04 12:09:10''createdby=''1''updated=''2010-08-04 12:09:10''updatedby=''1''organization_id=''1''description=''', 'I', 1, '2010-08-04 12:09:10', 6, 'S', 'admin', 1449, '::1', 'industry_id', '11'),
('sim_industry', 'industry_name=''11''isactive=''1''seqno=''10''created=''2010-08-04 12:09:10''createdby=''1''updated=''2010-08-04 12:09:10''updatedby=''1''organization_id=''1''description=''', 'I', 1, '2010-08-04 12:09:10', 7, 'S', 'admin', 1450, '::1', 'industry_id', '11'),
('sim_bpartnergroup', 'bpartnergroup_name=''qwe''isactive=''1''seqno=''10''created=''2010-08-04 12:09:32''createdby=''1''updated=''2010-08-04 12:09:32''updatedby=''1''organization_id=''1''description=''', 'I', 1, '2010-08-04 12:09:32', 6, 'S', 'admin', 1451, '::1', 'bpartnergroup_id', 'qwe'),
('sim_bpartnergroup', 'bpartnergroup_name=''qwe''', 'U', 1, '2010-08-04 12:09:32', 4, 'S', 'admin', 1452, '::1', 'bpartnergroup_id', 'qwe'),
('sim_bpartnergroup', 'bpartnergroup_name=''q''', 'U', 1, '2010-08-04 12:09:43', 4, 'S', 'admin', 1453, '::1', 'bpartnergroup_id', 'q'),
('sim_bpartnergroup', 'bpartnergroup_name=''q''', 'U', 1, '2010-08-04 12:09:43', 6, 'S', 'admin', 1454, '::1', 'bpartnergroup_id', 'q'),
('sim_bpartnergroup', 'Record deleted permanentl', 'E', 1, '2010-08-04 12:11:45', 4, 'S', 'admin', 1455, '::1', 'bpartnergroup_id', ''),
('sim_industry', 'isdeleted=', 'D', 1, '2010-08-04 12:11:49', 6, 'S', 'admin', 1456, '::1', 'industry_id', ''),
('sim_hr_employee', 'department_id=''9'',<br/>employeegroup_id=''18'',<br/>filephoto=''no-photo.jpg'',<br/>seqno='''',<br/>organization_id=''''', 'U', 1, '2010-08-04 12:22:28', 23, 'S', 'admin', 1457, '::1', 'employee_id', 'c'),
('sim_hr_employeegroup', 'employeegroup_name=''GeneralWWE''', 'U', 1, '2010-08-04 12:22:49', 18, 'S', 'admin', 1458, '::1', 'employeegroup_id', 'GN'),
('sim_hr_employeegroup', 'employeegroup_name=''General''', 'U', 1, '2010-08-04 12:23:27', 18, 'S', 'admin', 1459, '::1', 'employeegroup_id', 'GN'),
('sim_hr_employeegroup', 'isactive=''0''', 'U', 1, '2010-08-04 12:24:25', 30, 'S', 'admin', 1460, '::1', 'employeegroup_id', 'aa'),
('sim_hr_employeegroup', 'isactive=''0''', 'U', 1, '2010-08-04 12:24:36', 10, 'S', 'admin', 1461, '::1', 'employeegroup_id', 'LP'),
('sim_hr_employeegroup', 'Record deleted permanentl', 'E', 1, '2010-08-04 12:24:52', 10, 'F', 'admin', 1462, '::1', 'employeegroup_id', 'LP'),
('sim_hr_leaveadjustment', 'adjustment_for=''''created=''10/08/04 12:45:13''createdby=''admin(1)''updated=''10/08/04 12:45:13''updatedby=''admin(1)''organization_id=''1', 'I', 1, '2010-08-04 12:45:13', 2, 'S', 'admin', 1463, '::1', 'leaveadjustment_id', 'admin'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''2''employee_id=''16''leavetype_id=''8''leaveadjustmentline_totalday=''2''created=''2010-08-04 12:45:13''createdby=''1''updated=''2010-08-04 12:45:13''updatedby=''1', 'I', 1, '2010-08-04 12:45:13', 191, 'S', 'admin', 1464, '::1', 'leaveadjustmentline_id', '2'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''2''employee_id=''16''leavetype_id=''10''leaveadjustmentline_totalday=''2''created=''2010-08-04 12:45:13''createdby=''1''updated=''2010-08-04 12:45:13''updatedby=''1', 'I', 1, '2010-08-04 12:45:13', 192, 'S', 'admin', 1465, '::1', 'leaveadjustmentline_id', '2'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''2''employee_id=''16''leavetype_id=''16''leaveadjustmentline_totalday=''2''created=''2010-08-04 12:45:13''createdby=''1''updated=''2010-08-04 12:45:13''updatedby=''1', 'I', 1, '2010-08-04 12:45:13', 193, 'S', 'admin', 1466, '::1', 'leaveadjustmentline_id', '2'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''2''employee_id=''16''leavetype_id=''9''leaveadjustmentline_totalday=''2''created=''2010-08-04 12:45:13''createdby=''1''updated=''2010-08-04 12:45:13''updatedby=''1', 'I', 1, '2010-08-04 12:45:13', 194, 'S', 'admin', 1467, '::1', 'leaveadjustmentline_id', '2'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''2''employee_id=''14''leavetype_id=''8''leaveadjustmentline_totalday=''2''created=''2010-08-04 12:45:13''createdby=''1''updated=''2010-08-04 12:45:13''updatedby=''1', 'I', 1, '2010-08-04 12:45:13', 195, 'S', 'admin', 1468, '::1', 'leaveadjustmentline_id', '2'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''2''employee_id=''14''leavetype_id=''10''leaveadjustmentline_totalday=''2''created=''2010-08-04 12:45:13''createdby=''1''updated=''2010-08-04 12:45:13''updatedby=''1', 'I', 1, '2010-08-04 12:45:14', 196, 'S', 'admin', 1469, '::1', 'leaveadjustmentline_id', '2'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''2''employee_id=''14''leavetype_id=''16''leaveadjustmentline_totalday=''2''created=''2010-08-04 12:45:13''createdby=''1''updated=''2010-08-04 12:45:13''updatedby=''1', 'I', 1, '2010-08-04 12:45:14', 197, 'S', 'admin', 1470, '::1', 'leaveadjustmentline_id', '2'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''2''employee_id=''14''leavetype_id=''9''leaveadjustmentline_totalday=''2''created=''2010-08-04 12:45:13''createdby=''1''updated=''2010-08-04 12:45:13''updatedby=''1', 'I', 1, '2010-08-04 12:45:14', 198, 'S', 'admin', 1471, '::1', 'leaveadjustmentline_id', '2'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''2''employee_id=''17''leavetype_id=''8''leaveadjustmentline_totalday=''2''created=''2010-08-04 12:45:13''createdby=''1''updated=''2010-08-04 12:45:13''updatedby=''1', 'I', 1, '2010-08-04 12:45:14', 199, 'S', 'admin', 1472, '::1', 'leaveadjustmentline_id', '2'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''2''employee_id=''17''leavetype_id=''10''leaveadjustmentline_totalday=''2''created=''2010-08-04 12:45:13''createdby=''1''updated=''2010-08-04 12:45:13''updatedby=''1', 'I', 1, '2010-08-04 12:45:14', 200, 'S', 'admin', 1473, '::1', 'leaveadjustmentline_id', '2'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''2''employee_id=''17''leavetype_id=''16''leaveadjustmentline_totalday=''2''created=''2010-08-04 12:45:13''createdby=''1''updated=''2010-08-04 12:45:13''updatedby=''1', 'I', 1, '2010-08-04 12:45:14', 201, 'S', 'admin', 1474, '::1', 'leaveadjustmentline_id', '2'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''2''employee_id=''17''leavetype_id=''9''leaveadjustmentline_totalday=''2''created=''2010-08-04 12:45:13''createdby=''1''updated=''2010-08-04 12:45:13''updatedby=''1', 'I', 1, '2010-08-04 12:45:14', 202, 'S', 'admin', 1475, '::1', 'leaveadjustmentline_id', '2'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''2''employee_id=''22''leavetype_id=''8''leaveadjustmentline_totalday=''2''created=''2010-08-04 12:45:13''createdby=''1''updated=''2010-08-04 12:45:13''updatedby=''1', 'I', 1, '2010-08-04 12:45:14', 203, 'S', 'admin', 1476, '::1', 'leaveadjustmentline_id', '2'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''2''employee_id=''22''leavetype_id=''10''leaveadjustmentline_totalday=''2''created=''2010-08-04 12:45:13''createdby=''1''updated=''2010-08-04 12:45:13''updatedby=''1', 'I', 1, '2010-08-04 12:45:14', 204, 'S', 'admin', 1477, '::1', 'leaveadjustmentline_id', '2'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''2''employee_id=''22''leavetype_id=''16''leaveadjustmentline_totalday=''2''created=''2010-08-04 12:45:13''createdby=''1''updated=''2010-08-04 12:45:13''updatedby=''1', 'I', 1, '2010-08-04 12:45:14', 205, 'S', 'admin', 1478, '::1', 'leaveadjustmentline_id', '2'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''2''employee_id=''22''leavetype_id=''9''leaveadjustmentline_totalday=''2''created=''2010-08-04 12:45:13''createdby=''1''updated=''2010-08-04 12:45:13''updatedby=''1', 'I', 1, '2010-08-04 12:45:14', 206, 'S', 'admin', 1479, '::1', 'leaveadjustmentline_id', '2'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''2''employee_id=''21''leavetype_id=''8''leaveadjustmentline_totalday=''2''created=''2010-08-04 12:45:13''createdby=''1''updated=''2010-08-04 12:45:13''updatedby=''1', 'I', 1, '2010-08-04 12:45:14', 207, 'S', 'admin', 1480, '::1', 'leaveadjustmentline_id', '2'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''2''employee_id=''21''leavetype_id=''10''leaveadjustmentline_totalday=''2''created=''2010-08-04 12:45:13''createdby=''1''updated=''2010-08-04 12:45:13''updatedby=''1', 'I', 1, '2010-08-04 12:45:14', 208, 'S', 'admin', 1481, '::1', 'leaveadjustmentline_id', '2'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''2''employee_id=''21''leavetype_id=''16''leaveadjustmentline_totalday=''2''created=''2010-08-04 12:45:13''createdby=''1''updated=''2010-08-04 12:45:13''updatedby=''1', 'I', 1, '2010-08-04 12:45:14', 209, 'S', 'admin', 1482, '::1', 'leaveadjustmentline_id', '2'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''2''employee_id=''21''leavetype_id=''9''leaveadjustmentline_totalday=''2''created=''2010-08-04 12:45:13''createdby=''1''updated=''2010-08-04 12:45:13''updatedby=''1', 'I', 1, '2010-08-04 12:45:14', 210, 'S', 'admin', 1483, '::1', 'leaveadjustmentline_id', '2'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''2''employee_id=''18''leavetype_id=''8''leaveadjustmentline_totalday=''2''created=''2010-08-04 12:45:13''createdby=''1''updated=''2010-08-04 12:45:13''updatedby=''1', 'I', 1, '2010-08-04 12:45:14', 211, 'S', 'admin', 1484, '::1', 'leaveadjustmentline_id', '2'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''2''employee_id=''18''leavetype_id=''10''leaveadjustmentline_totalday=''2''created=''2010-08-04 12:45:13''createdby=''1''updated=''2010-08-04 12:45:13''updatedby=''1', 'I', 1, '2010-08-04 12:45:14', 212, 'S', 'admin', 1485, '::1', 'leaveadjustmentline_id', '2'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''2''employee_id=''18''leavetype_id=''16''leaveadjustmentline_totalday=''2''created=''2010-08-04 12:45:13''createdby=''1''updated=''2010-08-04 12:45:13''updatedby=''1', 'I', 1, '2010-08-04 12:45:14', 213, 'S', 'admin', 1486, '::1', 'leaveadjustmentline_id', '2'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''2''employee_id=''18''leavetype_id=''9''leaveadjustmentline_totalday=''2''created=''2010-08-04 12:45:13''createdby=''1''updated=''2010-08-04 12:45:13''updatedby=''1', 'I', 1, '2010-08-04 12:45:15', 214, 'S', 'admin', 1487, '::1', 'leaveadjustmentline_id', '2'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''2''employee_id=''33''leavetype_id=''8''leaveadjustmentline_totalday=''2''created=''2010-08-04 12:45:13''createdby=''1''updated=''2010-08-04 12:45:13''updatedby=''1', 'I', 1, '2010-08-04 12:45:15', 215, 'S', 'admin', 1488, '::1', 'leaveadjustmentline_id', '2'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''2''employee_id=''33''leavetype_id=''10''leaveadjustmentline_totalday=''2''created=''2010-08-04 12:45:13''createdby=''1''updated=''2010-08-04 12:45:13''updatedby=''1', 'I', 1, '2010-08-04 12:45:15', 216, 'S', 'admin', 1489, '::1', 'leaveadjustmentline_id', '2'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''2''employee_id=''33''leavetype_id=''16''leaveadjustmentline_totalday=''2''created=''2010-08-04 12:45:13''createdby=''1''updated=''2010-08-04 12:45:13''updatedby=''1', 'I', 1, '2010-08-04 12:45:15', 217, 'S', 'admin', 1490, '::1', 'leaveadjustmentline_id', '2'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''2''employee_id=''33''leavetype_id=''9''leaveadjustmentline_totalday=''2''created=''2010-08-04 12:45:13''createdby=''1''updated=''2010-08-04 12:45:13''updatedby=''1', 'I', 1, '2010-08-04 12:45:15', 218, 'S', 'admin', 1491, '::1', 'leaveadjustmentline_id', '2'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''2''employee_id=''38''leavetype_id=''8''leaveadjustmentline_totalday=''2''created=''2010-08-04 12:45:13''createdby=''1''updated=''2010-08-04 12:45:13''updatedby=''1', 'I', 1, '2010-08-04 12:45:15', 219, 'S', 'admin', 1492, '::1', 'leaveadjustmentline_id', '2'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''2''employee_id=''38''leavetype_id=''10''leaveadjustmentline_totalday=''2''created=''2010-08-04 12:45:13''createdby=''1''updated=''2010-08-04 12:45:13''updatedby=''1', 'I', 1, '2010-08-04 12:45:15', 220, 'S', 'admin', 1493, '::1', 'leaveadjustmentline_id', '2'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''2''employee_id=''38''leavetype_id=''16''leaveadjustmentline_totalday=''2''created=''2010-08-04 12:45:13''createdby=''1''updated=''2010-08-04 12:45:13''updatedby=''1', 'I', 1, '2010-08-04 12:45:15', 221, 'S', 'admin', 1494, '::1', 'leaveadjustmentline_id', '2'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''2''employee_id=''38''leavetype_id=''9''leaveadjustmentline_totalday=''2''created=''2010-08-04 12:45:13''createdby=''1''updated=''2010-08-04 12:45:13''updatedby=''1', 'I', 1, '2010-08-04 12:45:15', 222, 'S', 'admin', 1495, '::1', 'leaveadjustmentline_id', '2'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''2''employee_id=''24''leavetype_id=''8''leaveadjustmentline_totalday=''2''created=''2010-08-04 12:45:13''createdby=''1''updated=''2010-08-04 12:45:13''updatedby=''1', 'I', 1, '2010-08-04 12:45:15', 223, 'S', 'admin', 1496, '::1', 'leaveadjustmentline_id', '2'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''2''employee_id=''24''leavetype_id=''10''leaveadjustmentline_totalday=''2''created=''2010-08-04 12:45:13''createdby=''1''updated=''2010-08-04 12:45:13''updatedby=''1', 'I', 1, '2010-08-04 12:45:15', 224, 'S', 'admin', 1497, '::1', 'leaveadjustmentline_id', '2'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''2''employee_id=''24''leavetype_id=''16''leaveadjustmentline_totalday=''2''created=''2010-08-04 12:45:13''createdby=''1''updated=''2010-08-04 12:45:13''updatedby=''1', 'I', 1, '2010-08-04 12:45:15', 225, 'S', 'admin', 1498, '::1', 'leaveadjustmentline_id', '2'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''2''employee_id=''24''leavetype_id=''9''leaveadjustmentline_totalday=''2''created=''2010-08-04 12:45:13''createdby=''1''updated=''2010-08-04 12:45:13''updatedby=''1', 'I', 1, '2010-08-04 12:45:15', 226, 'S', 'admin', 1499, '::1', 'leaveadjustmentline_id', '2'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''2''employee_id=''30''leavetype_id=''8''leaveadjustmentline_totalday=''2''created=''2010-08-04 12:45:13''createdby=''1''updated=''2010-08-04 12:45:13''updatedby=''1', 'I', 1, '2010-08-04 12:45:15', 227, 'S', 'admin', 1500, '::1', 'leaveadjustmentline_id', '2'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''2''employee_id=''30''leavetype_id=''10''leaveadjustmentline_totalday=''2''created=''2010-08-04 12:45:13''createdby=''1''updated=''2010-08-04 12:45:13''updatedby=''1', 'I', 1, '2010-08-04 12:45:15', 228, 'S', 'admin', 1501, '::1', 'leaveadjustmentline_id', '2'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''2''employee_id=''30''leavetype_id=''''leaveadjustmentline_totalday=''2''created=''2010-08-04 12:45:13''createdby=''1''updated=''2010-08-04 12:45:13''updatedby=''1', 'I', 1, '2010-08-04 12:45:15', 229, 'S', 'admin', 1502, '::1', 'leaveadjustmentline_id', '2'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''2''employee_id=''30''leavetype_id=''''leaveadjustmentline_totalday=''2''created=''2010-08-04 12:45:13''createdby=''1''updated=''2010-08-04 12:45:13''updatedby=''1', 'I', 1, '2010-08-04 12:45:16', 230, 'S', 'admin', 1503, '::1', 'leaveadjustmentline_id', '2'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''2''employee_id=''15''leavetype_id=''9''leaveadjustmentline_totalday=''2''created=''2010-08-04 12:45:13''createdby=''1''updated=''2010-08-04 12:45:13''updatedby=''1', 'I', 1, '2010-08-04 12:45:16', 231, 'S', 'admin', 1504, '::1', 'leaveadjustmentline_id', '2'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''2''employee_id=''15''leavetype_id=''8''leaveadjustmentline_totalday=''2''created=''2010-08-04 12:45:13''createdby=''1''updated=''2010-08-04 12:45:13''updatedby=''1', 'I', 1, '2010-08-04 12:45:16', 232, 'S', 'admin', 1505, '::1', 'leaveadjustmentline_id', '2'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''2''employee_id=''15''leavetype_id=''10''leaveadjustmentline_totalday=''2''created=''2010-08-04 12:45:13''createdby=''1''updated=''2010-08-04 12:45:13''updatedby=''1', 'I', 1, '2010-08-04 12:45:16', 233, 'S', 'admin', 1506, '::1', 'leaveadjustmentline_id', '2'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''2''employee_id=''15''leavetype_id=''16''leaveadjustmentline_totalday=''2''created=''2010-08-04 12:45:13''createdby=''1''updated=''2010-08-04 12:45:13''updatedby=''1', 'I', 1, '2010-08-04 12:45:16', 234, 'S', 'admin', 1507, '::1', 'leaveadjustmentline_id', '2'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''2''employee_id=''''leavetype_id=''9''leaveadjustmentline_totalday=''2''created=''2010-08-04 12:45:13''createdby=''1''updated=''2010-08-04 12:45:13''updatedby=''1', 'I', 1, '2010-08-04 12:45:16', 235, 'S', 'admin', 1508, '::1', 'leaveadjustmentline_id', '2'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''2''employee_id=''''leavetype_id=''8''leaveadjustmentline_totalday=''2''created=''2010-08-04 12:45:13''createdby=''1''updated=''2010-08-04 12:45:13''updatedby=''1', 'I', 1, '2010-08-04 12:45:16', 236, 'S', 'admin', 1509, '::1', 'leaveadjustmentline_id', '2'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''2''employee_id=''20''leavetype_id=''10''leaveadjustmentline_totalday=''2''created=''2010-08-04 12:45:13''createdby=''1''updated=''2010-08-04 12:45:13''updatedby=''1', 'I', 1, '2010-08-04 12:45:16', 237, 'S', 'admin', 1510, '::1', 'leaveadjustmentline_id', '2'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''2''employee_id=''20''leavetype_id=''16''leaveadjustmentline_totalday=''2''created=''2010-08-04 12:45:13''createdby=''1''updated=''2010-08-04 12:45:13''updatedby=''1', 'I', 1, '2010-08-04 12:45:16', 238, 'S', 'admin', 1511, '::1', 'leaveadjustmentline_id', '2'),
('sim_hr_leaveadjustment', 'issubmit=''1''', 'U', 1, '2010-08-04 12:47:48', 2, 'S', 'admin', 1512, '::1', 'leaveadjustment_id', '2'),
('sim_workflowtransaction', 'workflowtransaction_datetime=''10/08/04 12:47:48''target_groupid=''1''target_uid=''0''targetparameter_name=''10''workflowstatus_id=''1''workflow_id=''8''tablename=''sim_hr_leaveadjustment''primarykey_name=''leaveadjustment_id''primarykey_value=''2''hyperlink=''../hr/leaveadjustment.php''title_description=''''created=''10/08/04 12:47:48''list_parameter=''''workflowtransaction_description=''''workflowtransaction_feedback=''''iscomplete=''0''createdby=''1''email_list=''10''sms_list=''10''email_body=''''sms_body=''''person_id=''14''issubmit=''1', 'I', 1, '2010-08-04 12:47:48', 2, 'S', 'admin', 1513, '::1', 'workflowtransaction_id', 'sim_hr_leaveadjustment'),
('sim_workflowtransactionhistory', 'workflowtransaction_id=''2''workflowstatus_id=''1''workflowtransaction_datetime=''10/08/04 12:47:48''uid=''1''workflowtransactionhistory_description=''', 'I', 1, '2010-08-04 12:47:48', 0, 'S', 'admin', 1514, '::1', 'workflowtransactionhistory_id', ''),
('sim_workflowtransaction', 'workflowtransaction_datetime=''10/08/04 12:48:02''target_groupid=''1''target_uid=''0''targetparameter_name=''10''workflowstatus_id=''2''workflow_id=''8''tablename=''sim_hr_leaveadjustment''primarykey_name=''leaveadjustment_id''primarykey_value=''2''hyperlink=''../hr/leaveadjustment.php''title_description=''''created=''10/08/04 12:48:02''list_parameter=''''workflowtransaction_description=''''workflowtransaction_feedback=''''iscomplete=''1''createdby=''1''email_list=''10''sms_list=''10''email_body=''''sms_body=''''person_id=''14''issubmit=''1', 'I', 1, '2010-08-04 12:48:02', 3, 'S', 'admin', 1515, '::1', 'workflowtransaction_id', 'sim_hr_leaveadjustment'),
('sim_workflowtransactionhistory', 'workflowtransaction_id=''3''workflowstatus_id=''2''workflowtransaction_datetime=''10/08/04 12:48:02''uid=''1''workflowtransactionhistory_description=''', 'I', 1, '2010-08-04 12:48:02', 0, 'S', 'admin', 1516, '::1', 'workflowtransactionhistory_id', ''),
('sim_hr_leaveadjustment', 'adjustment_for=''''created=''10/08/04 13:04:17''createdby=''admin(1)''updated=''10/08/04 13:04:17''updatedby=''admin(1)''organization_id=''1', 'I', 1, '2010-08-04 13:04:17', 1, 'S', 'admin', 1517, '::1', 'leaveadjustment_id', 'admin'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''1''employee_id=''23''leavetype_id=''8''leaveadjustmentline_totalday=''2''created=''2010-08-04 13:04:18''createdby=''1''updated=''2010-08-04 13:04:18''updatedby=''1', 'I', 1, '2010-08-04 13:04:18', 239, 'S', 'admin', 1518, '::1', 'leaveadjustmentline_id', '1'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''1''employee_id=''16''leavetype_id=''8''leaveadjustmentline_totalday=''2''created=''2010-08-04 13:04:18''createdby=''1''updated=''2010-08-04 13:04:18''updatedby=''1', 'I', 1, '2010-08-04 13:04:18', 240, 'S', 'admin', 1519, '::1', 'leaveadjustmentline_id', '1'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''1''employee_id=''35''leavetype_id=''8''leaveadjustmentline_totalday=''2''created=''2010-08-04 13:04:18''createdby=''1''updated=''2010-08-04 13:04:18''updatedby=''1', 'I', 1, '2010-08-04 13:04:18', 241, 'S', 'admin', 1520, '::1', 'leaveadjustmentline_id', '1'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''1''employee_id=''14''leavetype_id=''8''leaveadjustmentline_totalday=''2''created=''2010-08-04 13:04:18''createdby=''1''updated=''2010-08-04 13:04:18''updatedby=''1', 'I', 1, '2010-08-04 13:04:18', 242, 'S', 'admin', 1521, '::1', 'leaveadjustmentline_id', '1'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''1''employee_id=''17''leavetype_id=''8''leaveadjustmentline_totalday=''2''created=''2010-08-04 13:04:18''createdby=''1''updated=''2010-08-04 13:04:18''updatedby=''1', 'I', 1, '2010-08-04 13:04:18', 243, 'S', 'admin', 1522, '::1', 'leaveadjustmentline_id', '1'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''1''employee_id=''36''leavetype_id=''8''leaveadjustmentline_totalday=''2''created=''2010-08-04 13:04:18''createdby=''1''updated=''2010-08-04 13:04:18''updatedby=''1', 'I', 1, '2010-08-04 13:04:18', 244, 'S', 'admin', 1523, '::1', 'leaveadjustmentline_id', '1'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''1''employee_id=''22''leavetype_id=''8''leaveadjustmentline_totalday=''2''created=''2010-08-04 13:04:18''createdby=''1''updated=''2010-08-04 13:04:18''updatedby=''1', 'I', 1, '2010-08-04 13:04:18', 245, 'S', 'admin', 1524, '::1', 'leaveadjustmentline_id', '1'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''1''employee_id=''21''leavetype_id=''8''leaveadjustmentline_totalday=''2''created=''2010-08-04 13:04:18''createdby=''1''updated=''2010-08-04 13:04:18''updatedby=''1', 'I', 1, '2010-08-04 13:04:18', 246, 'S', 'admin', 1525, '::1', 'leaveadjustmentline_id', '1'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''1''employee_id=''18''leavetype_id=''8''leaveadjustmentline_totalday=''2''created=''2010-08-04 13:04:18''createdby=''1''updated=''2010-08-04 13:04:18''updatedby=''1', 'I', 1, '2010-08-04 13:04:18', 247, 'S', 'admin', 1526, '::1', 'leaveadjustmentline_id', '1'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''1''employee_id=''19''leavetype_id=''8''leaveadjustmentline_totalday=''2''created=''2010-08-04 13:04:18''createdby=''1''updated=''2010-08-04 13:04:18''updatedby=''1', 'I', 1, '2010-08-04 13:04:18', 248, 'S', 'admin', 1527, '::1', 'leaveadjustmentline_id', '1'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''1''employee_id=''33''leavetype_id=''8''leaveadjustmentline_totalday=''2''created=''2010-08-04 13:04:18''createdby=''1''updated=''2010-08-04 13:04:18''updatedby=''1', 'I', 1, '2010-08-04 13:04:18', 249, 'S', 'admin', 1528, '::1', 'leaveadjustmentline_id', '1'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''1''employee_id=''38''leavetype_id=''8''leaveadjustmentline_totalday=''2''created=''2010-08-04 13:04:18''createdby=''1''updated=''2010-08-04 13:04:18''updatedby=''1', 'I', 1, '2010-08-04 13:04:18', 250, 'S', 'admin', 1529, '::1', 'leaveadjustmentline_id', '1'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''1''employee_id=''24''leavetype_id=''8''leaveadjustmentline_totalday=''2''created=''2010-08-04 13:04:18''createdby=''1''updated=''2010-08-04 13:04:18''updatedby=''1', 'I', 1, '2010-08-04 13:04:19', 251, 'S', 'admin', 1530, '::1', 'leaveadjustmentline_id', '1'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''1''employee_id=''30''leavetype_id=''8''leaveadjustmentline_totalday=''2''created=''2010-08-04 13:04:18''createdby=''1''updated=''2010-08-04 13:04:18''updatedby=''1', 'I', 1, '2010-08-04 13:04:19', 252, 'S', 'admin', 1531, '::1', 'leaveadjustmentline_id', '1'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''1''employee_id=''15''leavetype_id=''8''leaveadjustmentline_totalday=''2''created=''2010-08-04 13:04:18''createdby=''1''updated=''2010-08-04 13:04:18''updatedby=''1', 'I', 1, '2010-08-04 13:04:19', 253, 'S', 'admin', 1532, '::1', 'leaveadjustmentline_id', '1'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''1''employee_id=''20''leavetype_id=''8''leaveadjustmentline_totalday=''2''created=''2010-08-04 13:04:18''createdby=''1''updated=''2010-08-04 13:04:18''updatedby=''1', 'I', 1, '2010-08-04 13:04:19', 254, 'S', 'admin', 1533, '::1', 'leaveadjustmentline_id', '1'),
('sim_hr_leaveadjustment', 'issubmit=''1''', 'U', 1, '2010-08-04 13:04:30', 1, 'S', 'admin', 1534, '::1', 'leaveadjustment_id', '1'),
('sim_workflowtransaction', 'workflowtransaction_datetime=''10/08/04 13:04:30''target_groupid=''1''target_uid=''0''targetparameter_name=''10''workflowstatus_id=''1''workflow_id=''8''tablename=''sim_hr_leaveadjustment''primarykey_name=''leaveadjustment_id''primarykey_value=''1''hyperlink=''../hr/leaveadjustment.php''title_description=''''created=''10/08/04 13:04:30''list_parameter=''''workflowtransaction_description=''''workflowtransaction_feedback=''''iscomplete=''0''createdby=''1''email_list=''10''sms_list=''10''email_body=''''sms_body=''''person_id=''14''issubmit=''1', 'I', 1, '2010-08-04 13:04:30', 1, 'S', 'admin', 1535, '::1', 'workflowtransaction_id', 'sim_hr_leaveadjustment'),
('sim_workflowtransactionhistory', 'workflowtransaction_id=''1''workflowstatus_id=''1''workflowtransaction_datetime=''10/08/04 13:04:30''uid=''1''workflowtransactionhistory_description=''', 'I', 1, '2010-08-04 13:04:30', 0, 'S', 'admin', 1536, '::1', 'workflowtransactionhistory_id', ''),
('sim_workflowtransaction', 'workflowtransaction_datetime=''10/08/04 13:06:20''target_groupid=''0''target_uid=''0''targetparameter_name=''1''workflowstatus_id=''5''workflow_id=''8''tablename=''sim_hr_leaveadjustment''primarykey_name=''leaveadjustment_id''primarykey_value=''1''hyperlink=''../hr/leaveadjustment.php''title_description=''''created=''10/08/04 13:06:20''list_parameter=''''workflowtransaction_description=''''workflowtransaction_feedback=''''iscomplete=''0''createdby=''1''email_list=''''sms_list=''''email_body=''''sms_body=''''person_id=''14''issubmit=''0', 'I', 1, '2010-08-04 13:06:20', 2, 'S', 'admin', 1537, '::1', 'workflowtransaction_id', 'sim_hr_leaveadjustment'),
('sim_workflowtransactionhistory', 'workflowtransaction_id=''2''workflowstatus_id=''5''workflowtransaction_datetime=''10/08/04 13:06:20''uid=''1''workflowtransactionhistory_description=''', 'I', 1, '2010-08-04 13:06:20', 0, 'S', 'admin', 1538, '::1', 'workflowtransactionhistory_id', ''),
('sim_hr_leaveadjustment', 'issubmit=''1''', 'U', 1, '2010-08-04 13:10:43', 1, 'S', 'admin', 1539, '::1', 'leaveadjustment_id', '1'),
('sim_workflowtransaction', 'workflowtransaction_datetime=''10/08/04 13:10:43''target_groupid=''1''target_uid=''0''targetparameter_name=''10''workflowstatus_id=''1''workflow_id=''8''tablename=''sim_hr_leaveadjustment''primarykey_name=''leaveadjustment_id''primarykey_value=''1''hyperlink=''../hr/leaveadjustment.php''title_description=''''created=''10/08/04 13:10:43''list_parameter=''''workflowtransaction_description=''''workflowtransaction_feedback=''''iscomplete=''0''createdby=''1''email_list=''10''sms_list=''10''email_body=''''sms_body=''''person_id=''14''issubmit=''1', 'I', 1, '2010-08-04 13:10:44', 3, 'S', 'admin', 1540, '::1', 'workflowtransaction_id', 'sim_hr_leaveadjustment'),
('sim_workflowtransactionhistory', 'workflowtransaction_id=''3''workflowstatus_id=''1''workflowtransaction_datetime=''10/08/04 13:10:44''uid=''1''workflowtransactionhistory_description=''', 'I', 1, '2010-08-04 13:10:44', 0, 'S', 'admin', 1541, '::1', 'workflowtransactionhistory_id', ''),
('sim_hr_employee', 'employee_name=''12312''employee_cardno=''''employee_no=''123312''uid=''''place_dob=''''employee_dob=''2010-08-01''races_id=''0''religion_id=''1''gender=''M''marital_status=''0''employee_citizenship=''3''employee_newicno=''''employee_oldicno=''''ic_color=''B''employee_passport=''''employee_bloodgroup=''''department_id=''4''jobposition_id=''56''employeegroup_id=''24''employee_joindate=''2010-08-04''filephoto=''''updated=''2010-08-04 13:14:52''updatedby=''1''seqno=''''organization_id=''''created=''2010-08-04 13:14:52''createdby=''1''employee_transport=''''employee_status=''1''isactive=''1''employee_altname=''''ic_placeissue=''''employee_passport_placeissue=''''employee_passport_issuedate=''''employee_passport_expirydate=''''employee_confirmdate=''2010-08-19''employee_enddate=''12312312', 'I', 1, '2010-08-04 13:14:52', 39, 'S', 'admin', 1542, '::1', 'employee_id', '12312'),
('sim_hr_qualificationline', 'qualification_name=''rrwe''', 'U', 1, '2010-08-04 13:31:47', 20, 'S', 'admin', 1543, '::1', 'qualification_id', 'rrwe');
INSERT INTO `sim_audit` (`tablename`, `changedesc`, `category`, `uid`, `updated`, `record_id`, `eventype`, `uname`, `audit_id`, `ip`, `primarykey`, `controlvalue`) VALUES
('sim_hr_qualificationline', 'qualification_name=''rrwe44''', 'U', 1, '2010-08-04 13:33:13', 20, 'S', 'admin', 1544, '::1', 'qualification_id', 'rrwe44'),
('sim_hr_attachmentline', 'Record deleted permanentl', 'E', 1, '2010-08-04 13:40:05', 9, 'S', 'admin', 1545, '::1', 'attachmentline_id', ''),
('sim_hr_employee', 'employee_name=''adasda''employee_cardno=''''employee_no=''112312''uid=''''place_dob=''''employee_dob=''2010-08-12''races_id=''0''religion_id=''1''gender=''M''marital_status=''0''employee_citizenship=''2''employee_newicno=''''employee_oldicno=''''ic_color=''B''employee_passport=''''employee_bloodgroup=''''department_id=''9''jobposition_id=''56''employeegroup_id=''18''employee_joindate=''2010-08-02''filephoto=''1280902463_photofile.png''updated=''2010-08-04 14:14:23''updatedby=''1''seqno=''''organization_id=''''created=''2010-08-04 14:14:23''createdby=''1''employee_transport=''''employee_status=''1''isactive=''1''employee_altname=''''ic_placeissue=''''employee_passport_placeissue=''''employee_passport_issuedate=''''employee_passport_expirydate=''''employee_confirmdate=''''employee_enddate=''', 'I', 1, '2010-08-04 14:14:23', 40, 'S', 'admin', 1546, '127.0.0.1', 'employee_id', 'adasda'),
('sim_hr_employee', 'employee_name=''dsadasdas''employee_cardno=''''employee_no=''2edsad''uid=''''place_dob=''''employee_dob=''2010-08-18''races_id=''0''religion_id=''1''gender=''M''marital_status=''0''employee_citizenship=''2''employee_newicno=''''employee_oldicno=''''ic_color=''B''employee_passport=''''employee_bloodgroup=''''department_id=''2''jobposition_id=''56''employeegroup_id=''26''employee_joindate=''2010-08-04''filephoto=''''updated=''2010-08-04 14:18:32''updatedby=''1''seqno=''''organization_id=''''created=''2010-08-04 14:18:32''createdby=''1''employee_transport=''''employee_status=''1''isactive=''1''employee_altname=''''ic_placeissue=''''employee_passport_placeissue=''''employee_passport_issuedate=''''employee_passport_expirydate=''''employee_confirmdate=''''employee_enddate=''', 'I', 1, '2010-08-04 14:18:32', 41, 'S', 'admin', 1547, '127.0.0.1', 'employee_id', 'dsadasdas'),
('sim_hr_employee', 'filephoto=''1280902724_photofile41.jpeg'',<br/>seqno='''',<br/>organization_id=''''', 'U', 1, '2010-08-04 14:18:44', 41, 'S', 'admin', 1548, '127.0.0.1', 'employee_id', '2edsad'),
('sim_hr_employee', 'filephoto=''no-photo.jpg'',<br/>seqno='''',<br/>organization_id=''''', 'U', 1, '2010-08-04 14:19:30', 41, 'S', 'admin', 1549, '127.0.0.1', 'employee_id', '2edsad'),
('sim_hr_employee', 'filephoto=''1280902785_photofile41.png'',<br/>seqno='''',<br/>organization_id=''''', 'U', 1, '2010-08-04 14:19:45', 41, 'S', 'admin', 1550, '127.0.0.1', 'employee_id', '2edsad'),
('sim_hr_attachmentline', 'attachmentline_name=''das''attachmentline_file=''1280902869_41.jpeg''attachmentline_remarks='' ''employee_id=''41''created=''2010-08-04 14:21:09''createdby=''1''updated=''2010-08-04 14:21:09''updatedby=''1', 'I', 1, '2010-08-04 14:21:09', 10, 'S', 'admin', 1551, '127.0.0.1', 'attachmentline_id', 'das'),
('sim_hr_employee', 'filephoto=''no-photo.jpg'',<br/>seqno='''',<br/>organization_id=''''', 'U', 1, '2010-08-04 14:21:29', 41, 'S', 'admin', 1552, '127.0.0.1', 'employee_id', '2edsad'),
('sim_hr_employee', 'filephoto=''1280902912_photofile41.png'',<br/>seqno='''',<br/>organization_id=''''', 'U', 1, '2010-08-04 14:21:52', 41, 'S', 'admin', 1553, '127.0.0.1', 'employee_id', '2edsad'),
('sim_hr_employee', 'filephoto=''no-photo.jpg'',<br/>seqno='''',<br/>organization_id=''''', 'U', 1, '2010-08-04 14:23:39', 41, 'S', 'admin', 1554, '127.0.0.1', 'employee_id', '2edsad'),
('sim_hr_employee', 'filephoto=''1280903038_photofile41.png'',<br/>seqno='''',<br/>organization_id=''''', 'U', 1, '2010-08-04 14:23:58', 41, 'S', 'admin', 1555, '127.0.0.1', 'employee_id', '2edsad'),
('sim_hr_employee', 'filephoto=''no-photo.jpg'',<br/>seqno='''',<br/>organization_id=''''', 'U', 1, '2010-08-04 15:38:24', 41, 'S', 'admin', 1556, '127.0.0.1', 'employee_id', '2edsad'),
('sim_hr_employee', 'filephoto=''1280907520_photofile41.png'',<br/>seqno='''',<br/>organization_id=''''', 'U', 1, '2010-08-04 15:38:40', 41, 'S', 'admin', 1557, '127.0.0.1', 'employee_id', '2edsad'),
('sim_hr_employeefamily', 'employeefamily_name=''eqweq''relationship_id=''1''employeefamily_dob=''1900-01-01''employeefamily_occupation=''''employeefamily_contactno=''''isnok=''1''isemergency=''0''employeefamily_remark=''''created=''2010-08-04 15:57:21''createdby=''1''updated=''2010-08-04 15:57:21''updatedby=''1''employee_id=''19', 'I', 1, '2010-08-04 15:57:21', 11, 'S', 'admin', 1558, '127.0.0.1', 'employeefamily_id', 'eqweq'),
('sim_hr_employeefamily', 'employeefamily_contactno=''as''', 'U', 1, '2010-08-04 15:58:13', 11, 'S', 'admin', 1559, '127.0.0.1', 'employeefamily_id', 'eqweq'),
('sim_hr_employeefamily', 'employeefamily_contactno=''12312'',<br/>isemergency=''1''', 'U', 1, '2010-08-04 15:58:25', 11, 'S', 'admin', 1560, '127.0.0.1', 'employeefamily_id', 'eqweq'),
('sim_hr_employeefamily', 'employeefamily_contactno=''adas''', 'U', 1, '2010-08-04 16:18:25', 11, 'S', 'admin', 1561, '127.0.0.1', 'employeefamily_id', 'eqweq'),
('sim_hr_employeefamily', 'employeefamily_name=''e''relationship_id=''1''employeefamily_dob=''1900-01-01''employeefamily_occupation=''''employeefamily_contactno=''123''isnok=''1''isemergency=''1''employeefamily_remark=''''created=''2010-08-04 17:07:09''createdby=''1''updated=''2010-08-04 17:07:09''updatedby=''1''employee_id=''19', 'I', 1, '2010-08-04 17:07:09', 12, 'S', 'admin', 1562, '127.0.0.1', 'employeefamily_id', 'e'),
('sim_hr_employeefamily', 'employeefamily_contactno=''123''', 'U', 1, '2010-08-04 17:07:09', 11, 'S', 'admin', 1563, '127.0.0.1', 'employeefamily_id', 'eqweq'),
('sim_hr_employee', 'permanent_address=''dasda'',<br/>permanent_postcode=''132'',<br/>permanent_state=''dsadas'',<br/>contact_address=''dasda'',<br/>contact_postcode=''132'',<br/>contact_state=''dsadas''', 'U', 1, '2010-08-04 17:19:31', 19, 'S', 'admin', 1564, '127.0.0.1', 'employee_id', ''),
('sim_hr_employee', 'permanent_city=''asda'',<br/>permanent_country=''2''', 'U', 1, '2010-08-04 17:19:43', 19, 'S', 'admin', 1565, '127.0.0.1', 'employee_id', ''),
('sim_hr_employee', 'contact_city=''asda'',<br/>contact_country=''2''', 'U', 1, '2010-08-04 17:19:50', 19, 'S', 'admin', 1566, '127.0.0.1', 'employee_id', ''),
('sim_hr_employeespouse', 'employee_id=''19''spouse_name=''dasdas''spouse_dob=''2010-08-10''spouse_placedob=''''spouse_placeissue=''''spouse_hpno=''12312''spouse_races=''0''spouse_religion=''1''spouse_gender=''M''spouse_bloodgroup=''''spouse_occupation=''''spouse_citizenship=''3''spouse_newicno=''''spouse_oldicno=''''spouse_ic_color=''B''spouse_passport=''''spouse_issuedate=''''spouse_expirydate=''''created=''2010-08-04 17:26:20''createdby=''1''updated=''2010-08-04 17:26:20''updatedby=''1', 'I', 1, '2010-08-04 17:26:20', 8, 'S', 'admin', 1567, '127.0.0.1', 'spouse_id', 'dasdas'),
('sim_hr_employeefamily', 'relationship=''qweqw''', 'U', 1, '2010-08-04 17:49:32', 11, 'S', 'admin', 1568, '127.0.0.1', 'employeefamily_id', 'eqweq'),
('sim_hr_employeefamily', 'employeefamily_name=''asdas''relationship=''adas''employeefamily_dob=''0000-00-00''employeefamily_occupation=''''employeefamily_contactno=''131321''isnok=''1''isemergency=''1''employeefamily_remark=''''created=''2010-08-04 17:52:01''createdby=''1''updated=''2010-08-04 17:52:01''updatedby=''1''employee_id=''19', 'I', 1, '2010-08-04 17:52:01', 13, 'S', 'admin', 1569, '127.0.0.1', 'employeefamily_id', 'asdas'),
('sim_hr_employee', 'employee_citizenship=''3'',<br/>seqno='''',<br/>organization_id=''''', 'U', 1, '2010-08-04 18:10:09', 19, 'S', 'admin', 1570, '127.0.0.1', 'employee_id', 'K001'),
('sim_hr_employee', 'seqno='''',<br/>organization_id=''''', 'U', 1, '2010-08-04 18:10:30', 19, 'S', 'admin', 1571, '127.0.0.1', 'employee_id', 'K001'),
('sim_hr_employee', 'seqno='''',<br/>organization_id=''''', 'U', 1, '2010-08-04 18:24:10', 19, 'S', 'admin', 1572, '127.0.0.1', 'employee_id', 'K001'),
('sim_hr_employee', 'seqno='''',<br/>organization_id=''''', 'U', 1, '2010-08-04 18:30:37', 19, 'S', 'admin', 1573, '127.0.0.1', 'employee_id', 'K001'),
('sim_hr_employee', 'employee_newicno=''123'',<br/>employee_oldicno=''213'',<br/>employee_passport=''312'',<br/>seqno='''',<br/>organization_id=''''', 'U', 1, '2010-08-04 18:32:16', 19, 'S', 'admin', 1574, '127.0.0.1', 'employee_id', 'K001'),
('sim_hr_employee', 'seqno='''',<br/>organization_id=''''', 'U', 1, '2010-08-04 18:33:24', 19, 'S', 'admin', 1575, '127.0.0.1', 'employee_id', 'K001'),
('sim_hr_employee', 'seqno='''',<br/>organization_id=''''', 'U', 1, '2010-08-04 18:33:40', 19, 'S', 'admin', 1576, '127.0.0.1', 'employee_id', 'K001'),
('sim_hr_employee', 'seqno='''',<br/>organization_id=''''', 'U', 1, '2010-08-04 18:34:17', 19, 'S', 'admin', 1577, '127.0.0.1', 'employee_id', 'K001'),
('sim_hr_employeespouse', 'spouse_placeissue_ic=''1'',<br/>spouse_placeissue_passport=''2''', 'U', 1, '2010-08-04 18:50:01', 8, 'S', 'admin', 1578, '127.0.0.1', 'spouse_id', ''),
('sim_hr_employeespouse', 'spouse_placeissue_passport=''333''', 'U', 1, '2010-08-04 18:59:09', 8, 'S', 'admin', 1579, '127.0.0.1', 'spouse_id', ''),
('sim_hr_employee', 'permanent_address=''AAAAA'',<br/>permanent_postcode=''123456'',<br/>permanent_city=''FFF'',<br/>permanent_state=''FGES'',<br/>contact_address=''AAAAA'',<br/>contact_postcode=''123456'',<br/>contact_city=''FFF'',<br/>contact_state=''FGES''', 'U', 1, '2010-08-04 19:05:49', 19, 'S', 'admin', 1580, '127.0.0.1', 'employee_id', ''),
('sim_hr_generalclaim', 'employee_id=''adasda(40)''generalclaim_date=''2010-08-11''generalclaim_docno=''''generalclaim_remark=''''period_id=''wer(10)''created=''10/08/04 19:18:50''createdby=''admin(1)''updated=''10/08/04 19:18:50''updatedby=''admin(1)''organization_id=''1', 'I', 1, '2010-08-04 19:18:50', 1, 'S', 'admin', 1581, '127.0.0.1', 'generalclaim_id', ''),
('sim_hr_generalclaim', 'employee_id=''40adasda'',<br/>issubmit=''1''', 'U', 1, '2010-08-04 19:19:02', 1, 'S', 'admin', 1582, '127.0.0.1', 'generalclaim_id', ''),
('sim_workflowtransaction', 'workflowtransaction_datetime=''10/08/04 19:19:02''target_groupid=''1''target_uid=''0''targetparameter_name=''0,23''workflowstatus_id=''1''workflow_id=''4''tablename=''sim_hr_generalclaim''primarykey_name=''generalclaim_id''primarykey_value=''1''hyperlink=''../hr/generalclaim.php''title_description=''''created=''10/08/04 19:19:02''list_parameter=''''workflowtransaction_description=''Ok done''workflowtransaction_feedback=''''iscomplete=''0''createdby=''1''email_list=''1,0,23''sms_list=''1,0,23''email_body=''''sms_body=''''person_id=''40''issubmit=''1', 'I', 1, '2010-08-04 19:19:02', 4, 'S', 'admin', 1583, '127.0.0.1', 'workflowtransaction_id', 'sim_hr_generalclaim'),
('sim_workflowtransactionhistory', 'workflowtransaction_id=''4''workflowstatus_id=''1''workflowtransaction_datetime=''10/08/04 19:19:02''uid=''1''workflowtransactionhistory_description=''', 'I', 1, '2010-08-04 19:19:02', 0, 'S', 'admin', 1584, '127.0.0.1', 'workflowtransactionhistory_id', ''),
('sim_hr_generalclaim', 'employee_id=''adasda(40)''generalclaim_date=''2010-08-19''generalclaim_docno=''''generalclaim_remark=''''period_id=''2010(2)''created=''10/08/04 19:27:33''createdby=''admin(1)''updated=''10/08/04 19:27:33''updatedby=''admin(1)''organization_id=''1', 'I', 1, '2010-08-04 19:27:33', 2, 'S', 'admin', 1585, '127.0.0.1', 'generalclaim_id', ''),
('sim_hr_generalclaim', 'employee_id=''A-Tester(16)''generalclaim_date=''2010-08-17''generalclaim_docno=''''generalclaim_remark=''''period_id=''wer(10)''created=''10/08/04 19:28:06''createdby=''admin(1)''updated=''10/08/04 19:28:06''updatedby=''admin(1)''organization_id=''1', 'I', 1, '2010-08-04 19:28:06', 3, 'S', 'admin', 1586, '127.0.0.1', 'generalclaim_id', ''),
('sim_hr_leave', 'leave_no=''''leave_date=''2010-08-04''employee_id=''A-Tester(16)''leave_fromdate=''2010-08-19''leave_todate=''2010-08-20''leave_day=''2''time_from=''08:00:00''time_to=''08:00:00''total_hours=''00:00:00''leave_address=''''leave_telno=''''leavetype_id=''DS(16)''lecturer_remarks=''''description=''sdfsd''created=''10/08/04 20:14:36''createdby=''1''updated=''10/08/04 20:14:36''updatedby=''1''organization_id=''1''panelclinic_id=''0''table_type=''L', 'I', 1, '2010-08-04 20:14:36', 1, 'S', 'admin', 1587, '192.168.1.202', 'leave_id', ''),
('sim_hr_generalclaim', 'employee_id=''A1(35)''generalclaim_date=''2010-08-12''generalclaim_docno=''''generalclaim_remark=''''period_id=''wer(10)''created=''10/08/04 20:15:15''createdby=''admin(1)''updated=''10/08/04 20:15:15''updatedby=''admin(1)''organization_id=''1', 'I', 1, '2010-08-04 20:15:15', 4, 'S', 'admin', 1588, '192.168.1.202', 'generalclaim_id', ''),
('sim_hr_leave', 'leave_no=''''leave_date=''2010-08-04''employee_id=''a(23)''leave_fromdate=''2010-08-20''leave_todate=''2010-08-20''leave_day=''1''time_from=''08:00:00''time_to=''08:00:00''total_hours=''00:00:00''leave_address=''''leave_telno=''''leavetype_id=''DS(16)''lecturer_remarks=''''description=''''created=''10/08/04 20:19:03''createdby=''1''updated=''10/08/04 20:19:03''updatedby=''1''organization_id=''1''panelclinic_id=''0''table_type=''L', 'I', 1, '2010-08-04 20:19:03', 2, 'S', 'admin', 1589, '192.168.1.202', 'leave_id', ''),
('sim_hr_generalclaim', 'employee_id=''A-Tester(16)''generalclaim_date=''2010-08-12''generalclaim_docno=''''generalclaim_remark=''''period_id=''wer(10)''created=''10/08/04 20:19:34''createdby=''admin(1)''updated=''10/08/04 20:19:34''updatedby=''admin(1)''organization_id=''1', 'I', 1, '2010-08-04 20:19:34', 5, 'S', 'admin', 1590, '192.168.1.202', 'generalclaim_id', ''),
('sim_hr_travellingclaim', 'employee_id=''A1(35)''travellingclaim_date=''2010-08-10''travellingclaim_docno=''''travellingclaim_remark=''''travellingclaim_transport=''g''period_id=''wer(10)''created=''10/08/04 20:20:10''createdby=''admin(1)''updated=''10/08/04 20:20:10''updatedby=''admin(1)''organization_id=''1', 'I', 1, '2010-08-04 20:20:10', 1, 'S', 'admin', 1591, '192.168.1.202', 'travellingclaim_id', ''),
('sim_hr_travellingclaim', 'issubmit='''',<br/>=''0''', 'U', 1, '2010-08-04 20:20:20', 1, 'S', 'admin', 1592, '192.168.1.202', 'travellingclaim_id', ''),
('sim_hr_generalclaim', 'employee_id=''a(23)''generalclaim_date=''2010-08-18''generalclaim_docno=''''generalclaim_remark=''''period_id=''wer(10)''created=''10/08/04 20:21:54''createdby=''admin(1)''updated=''10/08/04 20:21:54''updatedby=''admin(1)''organization_id=''1', 'I', 1, '2010-08-04 20:21:54', 6, 'S', 'admin', 1593, '192.168.1.202', 'generalclaim_id', ''),
('sim_hr_generalclaim', 'employee_id=''adasda(40)''generalclaim_date=''2010-08-10''generalclaim_docno=''''generalclaim_remark=''''period_id=''wer(10)''created=''10/08/04 20:22:37''createdby=''admin(1)''updated=''10/08/04 20:22:37''updatedby=''admin(1)''organization_id=''1', 'I', 1, '2010-08-04 20:22:37', 7, 'S', 'admin', 1594, '192.168.1.202', 'generalclaim_id', ''),
('sim_hr_generalclaim', 'employee_id=''A-Tester(16)''generalclaim_date=''2010-08-31''generalclaim_docno=''''generalclaim_remark=''''period_id=''wer(10)''created=''10/08/04 20:23:14''createdby=''admin(1)''updated=''10/08/04 20:23:14''updatedby=''admin(1)''organization_id=''1', 'I', 1, '2010-08-04 20:23:14', 8, 'S', 'admin', 1595, '127.0.0.1', 'generalclaim_id', ''),
('sim_hr_generalclaim', 'employee_id=''A-Tester(16)''generalclaim_date=''2010-08-17''generalclaim_docno=''''generalclaim_remark=''''period_id=''wer(10)''created=''10/08/04 20:23:52''createdby=''admin(1)''updated=''10/08/04 20:23:52''updatedby=''admin(1)''organization_id=''1', 'I', 1, '2010-08-04 20:23:52', 9, 'S', 'admin', 1596, '127.0.0.1', 'generalclaim_id', ''),
('sim_hr_generalclaim', 'employee_id=''Ali Bin Ahmad(14)''generalclaim_date=''2010-08-25''generalclaim_docno=''''generalclaim_remark=''''period_id=''wer(10)''created=''10/08/04 20:24:30''createdby=''admin(1)''updated=''10/08/04 20:24:30''updatedby=''admin(1)''organization_id=''1', 'I', 1, '2010-08-04 20:24:30', 10, 'S', 'admin', 1597, '127.0.0.1', 'generalclaim_id', ''),
('sim_hr_generalclaim', 'employee_id=''A1(35)''generalclaim_date=''2010-08-03''generalclaim_docno=''''generalclaim_remark=''''period_id=''wer(10)''created=''10/08/04 20:29:21''createdby=''admin(1)''updated=''10/08/04 20:29:21''updatedby=''admin(1)''organization_id=''1', 'I', 1, '2010-08-04 20:29:21', 11, 'S', 'admin', 1598, '127.0.0.1', 'generalclaim_id', ''),
('sim_hr_generalclaim', 'employee_id=''A-Tester(16)''generalclaim_date=''2010-08-05''generalclaim_docno=''''generalclaim_remark=''''period_id=''wer(10)''created=''10/08/04 20:29:22''createdby=''admin(1)''updated=''10/08/04 20:29:22''updatedby=''admin(1)''organization_id=''1', 'I', 1, '2010-08-04 20:29:22', 12, 'S', 'admin', 1599, '192.168.1.202', 'generalclaim_id', ''),
('sim_hr_generalclaim', 'issubmit=''''', 'U', 1, '2010-08-04 20:29:36', 11, 'S', 'admin', 1600, '127.0.0.1', 'generalclaim_id', ''),
('sim_hr_generalclaimline', 'generalclaim_id=''11''generalclaimline_date=''1900-01-01''generalclaimline_details=''''generalclaimline_porpose=''''generalclaimline_billno=''''generalclaimline_amount=''0''remarks=''''generalclaimline_acccode=''''created=''2010-08-04 20:29:37''createdby=''1''updated=''2010-08-04 20:29:37''updatedby=''1', 'I', 1, '2010-08-04 20:29:37', 1, 'S', 'admin', 1601, '127.0.0.1', 'generalclaimline_id', ''),
('sim_hr_generalclaim', 'employee_id=''Ali Bin Ahmad(14)''generalclaim_date=''2010-08-19''generalclaim_docno=''''generalclaim_remark=''''period_id=''wer(10)''created=''10/08/04 20:34:50''createdby=''admin(1)''updated=''10/08/04 20:34:50''updatedby=''admin(1)''organization_id=''1', 'I', 1, '2010-08-04 20:34:50', 13, 'S', 'admin', 1602, '127.0.0.1', 'generalclaim_id', ''),
('sim_hr_generalclaim', 'employee_id=''A-Tester''(16),<br/>generalclaim_date=''2010-08-24'',<br/>issubmit=''''', 'U', 1, '2010-08-04 20:35:44', 13, 'S', 'admin', 1603, '127.0.0.1', 'generalclaim_id', ''),
('sim_hr_generalclaim', 'employee_id=''adasda(40)''generalclaim_date=''2010-08-16''generalclaim_docno=''''generalclaim_remark=''''period_id=''wer(10)''created=''10/08/04 20:36:13''createdby=''admin(1)''updated=''10/08/04 20:36:13''updatedby=''admin(1)''organization_id=''1', 'I', 1, '2010-08-04 20:36:13', 14, 'S', 'admin', 1604, '127.0.0.1', 'generalclaim_id', ''),
('sim_hr_generalclaim', 'issubmit=''''', 'U', 1, '2010-08-04 20:36:27', 14, 'S', 'admin', 1605, '127.0.0.1', 'generalclaim_id', ''),
('sim_hr_generalclaimline', 'generalclaim_id=''14''generalclaimline_date=''1900-01-01''generalclaimline_details=''rfr''generalclaimline_porpose=''''generalclaimline_billno=''''generalclaimline_amount=''0''remarks=''''generalclaimline_acccode=''''created=''2010-08-04 20:36:27''createdby=''1''updated=''2010-08-04 20:36:27''updatedby=''1', 'I', 1, '2010-08-04 20:36:27', 2, 'S', 'admin', 1606, '127.0.0.1', 'generalclaimline_id', 'rfr'),
('sim_hr_generalclaim', 'employee_id=''Ali Bin Ahmad(14)''generalclaim_date=''2010-08-19''generalclaim_docno=''''generalclaim_remark=''''period_id=''wer(10)''created=''10/08/04 20:40:55''createdby=''admin(1)''updated=''10/08/04 20:40:55''updatedby=''admin(1)''organization_id=''1', 'I', 1, '2010-08-04 20:40:55', 15, 'S', 'admin', 1607, '127.0.0.1', 'generalclaim_id', ''),
('sim_hr_generalclaim', 'employee_id=''14Ali Bin Ahmad'',<br/>issubmit=''1''', 'U', 1, '2010-08-04 20:41:01', 15, 'S', 'admin', 1608, '127.0.0.1', 'generalclaim_id', ''),
('sim_workflowtransaction', 'workflowtransaction_datetime=''10/08/04 20:41:01''target_groupid=''1''target_uid=''0''targetparameter_name=''0,23''workflowstatus_id=''1''workflow_id=''4''tablename=''sim_hr_generalclaim''primarykey_name=''generalclaim_id''primarykey_value=''15''hyperlink=''../hr/generalclaim.php''title_description=''''created=''10/08/04 20:41:01''list_parameter=''''workflowtransaction_description=''Ok done''workflowtransaction_feedback=''''iscomplete=''0''createdby=''1''email_list=''1,0,23''sms_list=''1,0,23''email_body=''''sms_body=''''person_id=''14''issubmit=''1', 'I', 1, '2010-08-04 20:41:01', 5, 'S', 'admin', 1609, '127.0.0.1', 'workflowtransaction_id', 'sim_hr_generalclaim'),
('sim_workflowtransactionhistory', 'workflowtransaction_id=''5''workflowstatus_id=''1''workflowtransaction_datetime=''10/08/04 20:41:01''uid=''1''workflowtransactionhistory_description=''', 'I', 1, '2010-08-04 20:41:01', 0, 'S', 'admin', 1610, '127.0.0.1', 'workflowtransactionhistory_id', ''),
('sim_hr_travellingclaim', 'employee_id=''A1(35)''travellingclaim_date=''2010-08-11''travellingclaim_docno=''''travellingclaim_remark=''''travellingclaim_transport=''sddd''period_id=''wer(10)''created=''10/08/04 20:42:28''createdby=''admin(1)''updated=''10/08/04 20:42:28''updatedby=''admin(1)''organization_id=''1', 'I', 1, '2010-08-04 20:42:28', 2, 'S', 'admin', 1611, '192.168.1.202', 'travellingclaim_id', ''),
('sim_hr_generalclaim', 'employee_id=''A1(35)''generalclaim_date=''2010-08-10''generalclaim_docno=''''generalclaim_remark=''''period_id=''wer(10)''created=''10/08/04 20:43:02''createdby=''admin(1)''updated=''10/08/04 20:43:02''updatedby=''admin(1)''organization_id=''1', 'I', 1, '2010-08-04 20:43:02', 16, 'S', 'admin', 1612, '127.0.0.1', 'generalclaim_id', ''),
('sim_hr_generalclaim', 'employee_id=''35A1'',<br/>issubmit=''1''', 'U', 1, '2010-08-04 20:43:08', 16, 'S', 'admin', 1613, '127.0.0.1', 'generalclaim_id', ''),
('sim_workflowtransaction', 'workflowtransaction_datetime=''10/08/04 20:43:08''target_groupid=''1''target_uid=''0''targetparameter_name=''0,23''workflowstatus_id=''1''workflow_id=''4''tablename=''sim_hr_generalclaim''primarykey_name=''generalclaim_id''primarykey_value=''16''hyperlink=''../hr/generalclaim.php''title_description=''''created=''10/08/04 20:43:08''list_parameter=''''workflowtransaction_description=''Ok done''workflowtransaction_feedback=''''iscomplete=''0''createdby=''1''email_list=''1,0,23''sms_list=''1,0,23''email_body=''''sms_body=''''person_id=''35''issubmit=''1', 'I', 1, '2010-08-04 20:43:08', 6, 'S', 'admin', 1614, '127.0.0.1', 'workflowtransaction_id', 'sim_hr_generalclaim'),
('sim_workflowtransactionhistory', 'workflowtransaction_id=''6''workflowstatus_id=''1''workflowtransaction_datetime=''10/08/04 20:43:08''uid=''1''workflowtransactionhistory_description=''', 'I', 1, '2010-08-04 20:43:08', 0, 'S', 'admin', 1615, '127.0.0.1', 'workflowtransactionhistory_id', ''),
('sim_hr_travellingclaim', 'employee_id=''A-Tester(16)''travellingclaim_date=''2010-01-21''travellingclaim_docno=''''travellingclaim_remark=''''travellingclaim_transport=''dddd''period_id=''wer(10)''created=''10/08/04 20:43:13''createdby=''admin(1)''updated=''10/08/04 20:43:13''updatedby=''admin(1)''organization_id=''1', 'I', 1, '2010-08-04 20:43:13', 3, 'S', 'admin', 1616, '192.168.1.202', 'travellingclaim_id', ''),
('sim_hr_generalclaim', 'employee_id=''A1(35)''generalclaim_date=''2010-08-10''generalclaim_docno=''''generalclaim_remark=''''period_id=''wer(10)''created=''10/08/04 20:44:18''createdby=''admin(1)''updated=''10/08/04 20:44:18''updatedby=''admin(1)''organization_id=''1', 'I', 1, '2010-08-04 20:44:18', 17, 'S', 'admin', 1617, '192.168.1.202', 'generalclaim_id', ''),
('sim_hr_travellingclaim', 'employee_id=''A-Tester(16)''travellingclaim_date=''2010-08-11''travellingclaim_docno=''''travellingclaim_remark=''''travellingclaim_transport=''we''period_id=''wer(10)''created=''10/08/04 20:44:41''createdby=''admin(1)''updated=''10/08/04 20:44:41''updatedby=''admin(1)''organization_id=''1', 'I', 1, '2010-08-04 20:44:42', 4, 'S', 'admin', 1618, '192.168.1.202', 'travellingclaim_id', ''),
('sim_hr_overtimeclaim', 'employee_id=''A1(35)''overtimeclaim_date=''2010-08-10''overtimeclaim_docno=''''overtimeclaim_remark=''''created=''10/08/04 20:45:00''createdby=''admin(1)''updated=''10/08/04 20:45:00''updatedby=''admin(1)''organization_id=''1', 'I', 1, '2010-08-04 20:45:00', 1, 'S', 'admin', 1619, '192.168.1.202', 'overtimeclaim_id', ''),
('sim_hr_medicalclaim', 'employee_id=''a(23)''medicalclaim_date=''2010-08-18''medicalclaim_clinic=''sdf''medicalclaim_docno=''sd''medicalclaim_amount=''33''medicalclaim_treatment=''sdf''medicalclaim_remark=''''period_id=''wer(10)''created=''10/08/04 20:45:19''createdby=''admin(1)''updated=''10/08/04 20:45:19''updatedby=''admin(1)''organization_id=''1', 'I', 1, '2010-08-04 20:45:19', 1, 'S', 'admin', 1620, '192.168.1.202', 'medicalclaim_id', 'sd'),
('sim_hr_leave', 'leave_no=''''leave_date=''2010-08-04''employee_id=''A-Tester(16)''leave_fromdate=''2010-08-19''leave_todate=''2010-08-26''leave_day=''8''time_from=''08:00:00''time_to=''08:00:00''total_hours=''00:00:00''leave_address=''''leave_telno=''''leavetype_id=''DS(16)''lecturer_remarks=''''description=''''created=''10/08/04 20:46:09''createdby=''1''updated=''10/08/04 20:46:09''updatedby=''1''organization_id=''1''panelclinic_id=''0''table_type=''L', 'I', 1, '2010-08-04 20:46:09', 3, 'S', 'admin', 1621, '192.168.1.202', 'leave_id', ''),
('sim_hr_leave', 'leave_no=''''leave_date=''2010-08-04''employee_id=''A1(35)''leave_fromdate=''2010-08-11''leave_todate=''2010-08-12''leave_day=''2''time_from=''08:00:00''time_to=''08:00:00''total_hours=''00:00:00''leave_address=''''leave_telno=''''leavetype_id=''DS(16)''lecturer_remarks=''''description=''''created=''10/08/04 20:47:08''createdby=''1''updated=''10/08/04 20:47:08''updatedby=''1''organization_id=''1''panelclinic_id=''0''table_type=''L', 'I', 1, '2010-08-04 20:47:08', 4, 'S', 'admin', 1622, '192.168.1.202', 'leave_id', ''),
('sim_hr_medicalclaim', 'employee_id=''A-Tester(16)''medicalclaim_date=''2010-08-10''medicalclaim_clinic=''123''medicalclaim_docno=''123''medicalclaim_amount=''33''medicalclaim_treatment=''123''medicalclaim_remark=''''period_id=''wer(10)''created=''10/08/04 20:47:38''createdby=''admin(1)''updated=''10/08/04 20:47:38''updatedby=''admin(1)''organization_id=''1', 'I', 1, '2010-08-04 20:47:38', 2, 'S', 'admin', 1623, '192.168.1.202', 'medicalclaim_id', '123'),
('sim_hr_leaveadjustment', 'adjustment_for=''''created=''10/08/04 20:48:06''createdby=''admin(1)''updated=''10/08/04 20:48:06''updatedby=''admin(1)''organization_id=''1', 'I', 1, '2010-08-04 20:48:06', 2, 'S', 'admin', 1624, '192.168.1.202', 'leaveadjustment_id', 'admin'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''2''employee_id=''39''leavetype_id=''8''leaveadjustmentline_totalday=''10''created=''2010-08-04 20:48:06''createdby=''1''updated=''2010-08-04 20:48:06''updatedby=''1', 'I', 1, '2010-08-04 20:48:06', 255, 'S', 'admin', 1625, '192.168.1.202', 'leaveadjustmentline_id', '2'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''2''employee_id=''39''leavetype_id=''10''leaveadjustmentline_totalday=''10''created=''2010-08-04 20:48:06''createdby=''1''updated=''2010-08-04 20:48:06''updatedby=''1', 'I', 1, '2010-08-04 20:48:06', 256, 'S', 'admin', 1626, '192.168.1.202', 'leaveadjustmentline_id', '2'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''2''employee_id=''39''leavetype_id=''16''leaveadjustmentline_totalday=''10''created=''2010-08-04 20:48:06''createdby=''1''updated=''2010-08-04 20:48:06''updatedby=''1', 'I', 1, '2010-08-04 20:48:06', 257, 'S', 'admin', 1627, '192.168.1.202', 'leaveadjustmentline_id', '2'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''2''employee_id=''39''leavetype_id=''9''leaveadjustmentline_totalday=''10''created=''2010-08-04 20:48:06''createdby=''1''updated=''2010-08-04 20:48:06''updatedby=''1', 'I', 1, '2010-08-04 20:48:06', 258, 'S', 'admin', 1628, '192.168.1.202', 'leaveadjustmentline_id', '2'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''2''employee_id=''23''leavetype_id=''8''leaveadjustmentline_totalday=''10''created=''2010-08-04 20:48:06''createdby=''1''updated=''2010-08-04 20:48:06''updatedby=''1', 'I', 1, '2010-08-04 20:48:07', 259, 'S', 'admin', 1629, '192.168.1.202', 'leaveadjustmentline_id', '2'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''2''employee_id=''23''leavetype_id=''10''leaveadjustmentline_totalday=''10''created=''2010-08-04 20:48:06''createdby=''1''updated=''2010-08-04 20:48:06''updatedby=''1', 'I', 1, '2010-08-04 20:48:07', 260, 'S', 'admin', 1630, '192.168.1.202', 'leaveadjustmentline_id', '2'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''2''employee_id=''23''leavetype_id=''16''leaveadjustmentline_totalday=''10''created=''2010-08-04 20:48:06''createdby=''1''updated=''2010-08-04 20:48:06''updatedby=''1', 'I', 1, '2010-08-04 20:48:07', 261, 'S', 'admin', 1631, '192.168.1.202', 'leaveadjustmentline_id', '2'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''2''employee_id=''23''leavetype_id=''9''leaveadjustmentline_totalday=''10''created=''2010-08-04 20:48:06''createdby=''1''updated=''2010-08-04 20:48:06''updatedby=''1', 'I', 1, '2010-08-04 20:48:07', 262, 'S', 'admin', 1632, '192.168.1.202', 'leaveadjustmentline_id', '2'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''2''employee_id=''16''leavetype_id=''8''leaveadjustmentline_totalday=''10''created=''2010-08-04 20:48:06''createdby=''1''updated=''2010-08-04 20:48:06''updatedby=''1', 'I', 1, '2010-08-04 20:48:07', 263, 'S', 'admin', 1633, '192.168.1.202', 'leaveadjustmentline_id', '2'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''2''employee_id=''16''leavetype_id=''10''leaveadjustmentline_totalday=''10''created=''2010-08-04 20:48:06''createdby=''1''updated=''2010-08-04 20:48:06''updatedby=''1', 'I', 1, '2010-08-04 20:48:07', 264, 'S', 'admin', 1634, '192.168.1.202', 'leaveadjustmentline_id', '2'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''2''employee_id=''16''leavetype_id=''16''leaveadjustmentline_totalday=''10''created=''2010-08-04 20:48:06''createdby=''1''updated=''2010-08-04 20:48:06''updatedby=''1', 'I', 1, '2010-08-04 20:48:07', 265, 'S', 'admin', 1635, '192.168.1.202', 'leaveadjustmentline_id', '2'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''2''employee_id=''16''leavetype_id=''9''leaveadjustmentline_totalday=''10''created=''2010-08-04 20:48:06''createdby=''1''updated=''2010-08-04 20:48:06''updatedby=''1', 'I', 1, '2010-08-04 20:48:07', 266, 'S', 'admin', 1636, '192.168.1.202', 'leaveadjustmentline_id', '2'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''2''employee_id=''35''leavetype_id=''8''leaveadjustmentline_totalday=''10''created=''2010-08-04 20:48:06''createdby=''1''updated=''2010-08-04 20:48:06''updatedby=''1', 'I', 1, '2010-08-04 20:48:07', 267, 'S', 'admin', 1637, '192.168.1.202', 'leaveadjustmentline_id', '2'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''2''employee_id=''35''leavetype_id=''10''leaveadjustmentline_totalday=''10''created=''2010-08-04 20:48:06''createdby=''1''updated=''2010-08-04 20:48:06''updatedby=''1', 'I', 1, '2010-08-04 20:48:07', 268, 'S', 'admin', 1638, '192.168.1.202', 'leaveadjustmentline_id', '2'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''2''employee_id=''35''leavetype_id=''16''leaveadjustmentline_totalday=''10''created=''2010-08-04 20:48:06''createdby=''1''updated=''2010-08-04 20:48:06''updatedby=''1', 'I', 1, '2010-08-04 20:48:07', 269, 'S', 'admin', 1639, '192.168.1.202', 'leaveadjustmentline_id', '2'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''2''employee_id=''35''leavetype_id=''9''leaveadjustmentline_totalday=''10''created=''2010-08-04 20:48:06''createdby=''1''updated=''2010-08-04 20:48:06''updatedby=''1', 'I', 1, '2010-08-04 20:48:07', 270, 'S', 'admin', 1640, '192.168.1.202', 'leaveadjustmentline_id', '2'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''2''employee_id=''40''leavetype_id=''8''leaveadjustmentline_totalday=''10''created=''2010-08-04 20:48:06''createdby=''1''updated=''2010-08-04 20:48:06''updatedby=''1', 'I', 1, '2010-08-04 20:48:07', 271, 'S', 'admin', 1641, '192.168.1.202', 'leaveadjustmentline_id', '2'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''2''employee_id=''40''leavetype_id=''10''leaveadjustmentline_totalday=''10''created=''2010-08-04 20:48:06''createdby=''1''updated=''2010-08-04 20:48:06''updatedby=''1', 'I', 1, '2010-08-04 20:48:07', 272, 'S', 'admin', 1642, '192.168.1.202', 'leaveadjustmentline_id', '2'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''2''employee_id=''40''leavetype_id=''16''leaveadjustmentline_totalday=''10''created=''2010-08-04 20:48:06''createdby=''1''updated=''2010-08-04 20:48:06''updatedby=''1', 'I', 1, '2010-08-04 20:48:07', 273, 'S', 'admin', 1643, '192.168.1.202', 'leaveadjustmentline_id', '2'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''2''employee_id=''40''leavetype_id=''9''leaveadjustmentline_totalday=''10''created=''2010-08-04 20:48:06''createdby=''1''updated=''2010-08-04 20:48:06''updatedby=''1', 'I', 1, '2010-08-04 20:48:07', 274, 'S', 'admin', 1644, '192.168.1.202', 'leaveadjustmentline_id', '2'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''2''employee_id=''14''leavetype_id=''8''leaveadjustmentline_totalday=''10''created=''2010-08-04 20:48:06''createdby=''1''updated=''2010-08-04 20:48:06''updatedby=''1', 'I', 1, '2010-08-04 20:48:07', 275, 'S', 'admin', 1645, '192.168.1.202', 'leaveadjustmentline_id', '2'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''2''employee_id=''14''leavetype_id=''10''leaveadjustmentline_totalday=''10''created=''2010-08-04 20:48:06''createdby=''1''updated=''2010-08-04 20:48:06''updatedby=''1', 'I', 1, '2010-08-04 20:48:07', 276, 'S', 'admin', 1646, '192.168.1.202', 'leaveadjustmentline_id', '2'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''2''employee_id=''14''leavetype_id=''16''leaveadjustmentline_totalday=''10''created=''2010-08-04 20:48:06''createdby=''1''updated=''2010-08-04 20:48:06''updatedby=''1', 'I', 1, '2010-08-04 20:48:07', 277, 'S', 'admin', 1647, '192.168.1.202', 'leaveadjustmentline_id', '2'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''2''employee_id=''14''leavetype_id=''9''leaveadjustmentline_totalday=''10''created=''2010-08-04 20:48:06''createdby=''1''updated=''2010-08-04 20:48:06''updatedby=''1', 'I', 1, '2010-08-04 20:48:08', 278, 'S', 'admin', 1648, '192.168.1.202', 'leaveadjustmentline_id', '2'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''2''employee_id=''17''leavetype_id=''8''leaveadjustmentline_totalday=''10''created=''2010-08-04 20:48:06''createdby=''1''updated=''2010-08-04 20:48:06''updatedby=''1', 'I', 1, '2010-08-04 20:48:08', 279, 'S', 'admin', 1649, '192.168.1.202', 'leaveadjustmentline_id', '2'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''2''employee_id=''17''leavetype_id=''10''leaveadjustmentline_totalday=''10''created=''2010-08-04 20:48:06''createdby=''1''updated=''2010-08-04 20:48:06''updatedby=''1', 'I', 1, '2010-08-04 20:48:08', 280, 'S', 'admin', 1650, '192.168.1.202', 'leaveadjustmentline_id', '2'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''2''employee_id=''17''leavetype_id=''16''leaveadjustmentline_totalday=''10''created=''2010-08-04 20:48:06''createdby=''1''updated=''2010-08-04 20:48:06''updatedby=''1', 'I', 1, '2010-08-04 20:48:08', 281, 'S', 'admin', 1651, '192.168.1.202', 'leaveadjustmentline_id', '2'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''2''employee_id=''17''leavetype_id=''9''leaveadjustmentline_totalday=''10''created=''2010-08-04 20:48:06''createdby=''1''updated=''2010-08-04 20:48:06''updatedby=''1', 'I', 1, '2010-08-04 20:48:08', 282, 'S', 'admin', 1652, '192.168.1.202', 'leaveadjustmentline_id', '2'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''2''employee_id=''36''leavetype_id=''8''leaveadjustmentline_totalday=''10''created=''2010-08-04 20:48:06''createdby=''1''updated=''2010-08-04 20:48:06''updatedby=''1', 'I', 1, '2010-08-04 20:48:08', 283, 'S', 'admin', 1653, '192.168.1.202', 'leaveadjustmentline_id', '2'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''2''employee_id=''36''leavetype_id=''10''leaveadjustmentline_totalday=''10''created=''2010-08-04 20:48:06''createdby=''1''updated=''2010-08-04 20:48:06''updatedby=''1', 'I', 1, '2010-08-04 20:48:08', 284, 'S', 'admin', 1654, '192.168.1.202', 'leaveadjustmentline_id', '2'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''2''employee_id=''36''leavetype_id=''16''leaveadjustmentline_totalday=''10''created=''2010-08-04 20:48:06''createdby=''1''updated=''2010-08-04 20:48:06''updatedby=''1', 'I', 1, '2010-08-04 20:48:08', 285, 'S', 'admin', 1655, '192.168.1.202', 'leaveadjustmentline_id', '2'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''2''employee_id=''36''leavetype_id=''9''leaveadjustmentline_totalday=''10''created=''2010-08-04 20:48:06''createdby=''1''updated=''2010-08-04 20:48:06''updatedby=''1', 'I', 1, '2010-08-04 20:48:08', 286, 'S', 'admin', 1656, '192.168.1.202', 'leaveadjustmentline_id', '2'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''2''employee_id=''22''leavetype_id=''8''leaveadjustmentline_totalday=''10''created=''2010-08-04 20:48:06''createdby=''1''updated=''2010-08-04 20:48:06''updatedby=''1', 'I', 1, '2010-08-04 20:48:08', 287, 'S', 'admin', 1657, '192.168.1.202', 'leaveadjustmentline_id', '2'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''2''employee_id=''22''leavetype_id=''10''leaveadjustmentline_totalday=''10''created=''2010-08-04 20:48:06''createdby=''1''updated=''2010-08-04 20:48:06''updatedby=''1', 'I', 1, '2010-08-04 20:48:08', 288, 'S', 'admin', 1658, '192.168.1.202', 'leaveadjustmentline_id', '2'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''2''employee_id=''22''leavetype_id=''16''leaveadjustmentline_totalday=''10''created=''2010-08-04 20:48:06''createdby=''1''updated=''2010-08-04 20:48:06''updatedby=''1', 'I', 1, '2010-08-04 20:48:08', 289, 'S', 'admin', 1659, '192.168.1.202', 'leaveadjustmentline_id', '2'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''2''employee_id=''22''leavetype_id=''9''leaveadjustmentline_totalday=''10''created=''2010-08-04 20:48:06''createdby=''1''updated=''2010-08-04 20:48:06''updatedby=''1', 'I', 1, '2010-08-04 20:48:08', 290, 'S', 'admin', 1660, '192.168.1.202', 'leaveadjustmentline_id', '2'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''2''employee_id=''41''leavetype_id=''8''leaveadjustmentline_totalday=''10''created=''2010-08-04 20:48:06''createdby=''1''updated=''2010-08-04 20:48:06''updatedby=''1', 'I', 1, '2010-08-04 20:48:08', 291, 'S', 'admin', 1661, '192.168.1.202', 'leaveadjustmentline_id', '2'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''2''employee_id=''41''leavetype_id=''10''leaveadjustmentline_totalday=''10''created=''2010-08-04 20:48:06''createdby=''1''updated=''2010-08-04 20:48:06''updatedby=''1', 'I', 1, '2010-08-04 20:48:08', 292, 'S', 'admin', 1662, '192.168.1.202', 'leaveadjustmentline_id', '2'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''2''employee_id=''41''leavetype_id=''''leaveadjustmentline_totalday=''10''created=''2010-08-04 20:48:06''createdby=''1''updated=''2010-08-04 20:48:06''updatedby=''1', 'I', 1, '2010-08-04 20:48:08', 293, 'S', 'admin', 1663, '192.168.1.202', 'leaveadjustmentline_id', '2'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''2''employee_id=''41''leavetype_id=''''leaveadjustmentline_totalday=''10''created=''2010-08-04 20:48:06''createdby=''1''updated=''2010-08-04 20:48:06''updatedby=''1', 'I', 1, '2010-08-04 20:48:08', 294, 'S', 'admin', 1664, '192.168.1.202', 'leaveadjustmentline_id', '2'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''2''employee_id=''21''leavetype_id=''9''leaveadjustmentline_totalday=''10''created=''2010-08-04 20:48:06''createdby=''1''updated=''2010-08-04 20:48:06''updatedby=''1', 'I', 1, '2010-08-04 20:48:08', 295, 'S', 'admin', 1665, '192.168.1.202', 'leaveadjustmentline_id', '2'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''2''employee_id=''21''leavetype_id=''8''leaveadjustmentline_totalday=''10''created=''2010-08-04 20:48:06''createdby=''1''updated=''2010-08-04 20:48:06''updatedby=''1', 'I', 1, '2010-08-04 20:48:09', 296, 'S', 'admin', 1666, '192.168.1.202', 'leaveadjustmentline_id', '2'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''2''employee_id=''21''leavetype_id=''10''leaveadjustmentline_totalday=''10''created=''2010-08-04 20:48:06''createdby=''1''updated=''2010-08-04 20:48:06''updatedby=''1', 'I', 1, '2010-08-04 20:48:09', 297, 'S', 'admin', 1667, '192.168.1.202', 'leaveadjustmentline_id', '2'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''2''employee_id=''21''leavetype_id=''16''leaveadjustmentline_totalday=''10''created=''2010-08-04 20:48:06''createdby=''1''updated=''2010-08-04 20:48:06''updatedby=''1', 'I', 1, '2010-08-04 20:48:09', 298, 'S', 'admin', 1668, '192.168.1.202', 'leaveadjustmentline_id', '2'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''2''employee_id=''''leavetype_id=''9''leaveadjustmentline_totalday=''10''created=''2010-08-04 20:48:06''createdby=''1''updated=''2010-08-04 20:48:06''updatedby=''1', 'I', 1, '2010-08-04 20:48:09', 299, 'S', 'admin', 1669, '192.168.1.202', 'leaveadjustmentline_id', '2'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''2''employee_id=''''leavetype_id=''8''leaveadjustmentline_totalday=''10''created=''2010-08-04 20:48:06''createdby=''1''updated=''2010-08-04 20:48:06''updatedby=''1', 'I', 1, '2010-08-04 20:48:09', 300, 'S', 'admin', 1670, '192.168.1.202', 'leaveadjustmentline_id', '2'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''2''employee_id=''18''leavetype_id=''10''leaveadjustmentline_totalday=''10''created=''2010-08-04 20:48:06''createdby=''1''updated=''2010-08-04 20:48:06''updatedby=''1', 'I', 1, '2010-08-04 20:48:09', 301, 'S', 'admin', 1671, '192.168.1.202', 'leaveadjustmentline_id', '2'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''2''employee_id=''18''leavetype_id=''16''leaveadjustmentline_totalday=''10''created=''2010-08-04 20:48:06''createdby=''1''updated=''2010-08-04 20:48:06''updatedby=''1', 'I', 1, '2010-08-04 20:48:09', 302, 'S', 'admin', 1672, '192.168.1.202', 'leaveadjustmentline_id', '2'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''2''employee_id=''18''leavetype_id=''9''leaveadjustmentline_totalday=''10''created=''2010-08-04 20:48:06''createdby=''1''updated=''2010-08-04 20:48:06''updatedby=''1', 'I', 1, '2010-08-04 20:48:09', 303, 'S', 'admin', 1673, '192.168.1.202', 'leaveadjustmentline_id', '2'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''2''employee_id=''19''leavetype_id=''8''leaveadjustmentline_totalday=''10''created=''2010-08-04 20:48:06''createdby=''1''updated=''2010-08-04 20:48:06''updatedby=''1', 'I', 1, '2010-08-04 20:48:09', 304, 'S', 'admin', 1674, '192.168.1.202', 'leaveadjustmentline_id', '2'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''2''employee_id=''19''leavetype_id=''10''leaveadjustmentline_totalday=''10''created=''2010-08-04 20:48:06''createdby=''1''updated=''2010-08-04 20:48:06''updatedby=''1', 'I', 1, '2010-08-04 20:48:09', 305, 'S', 'admin', 1675, '192.168.1.202', 'leaveadjustmentline_id', '2'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''2''employee_id=''19''leavetype_id=''16''leaveadjustmentline_totalday=''10''created=''2010-08-04 20:48:06''createdby=''1''updated=''2010-08-04 20:48:06''updatedby=''1', 'I', 1, '2010-08-04 20:48:09', 306, 'S', 'admin', 1676, '192.168.1.202', 'leaveadjustmentline_id', '2'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''2''employee_id=''19''leavetype_id=''9''leaveadjustmentline_totalday=''10''created=''2010-08-04 20:48:06''createdby=''1''updated=''2010-08-04 20:48:06''updatedby=''1', 'I', 1, '2010-08-04 20:48:09', 307, 'S', 'admin', 1677, '192.168.1.202', 'leaveadjustmentline_id', '2'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''2''employee_id=''33''leavetype_id=''8''leaveadjustmentline_totalday=''10''created=''2010-08-04 20:48:06''createdby=''1''updated=''2010-08-04 20:48:06''updatedby=''1', 'I', 1, '2010-08-04 20:48:09', 308, 'S', 'admin', 1678, '192.168.1.202', 'leaveadjustmentline_id', '2'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''2''employee_id=''33''leavetype_id=''10''leaveadjustmentline_totalday=''10''created=''2010-08-04 20:48:06''createdby=''1''updated=''2010-08-04 20:48:06''updatedby=''1', 'I', 1, '2010-08-04 20:48:10', 309, 'S', 'admin', 1679, '192.168.1.202', 'leaveadjustmentline_id', '2'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''2''employee_id=''33''leavetype_id=''16''leaveadjustmentline_totalday=''10''created=''2010-08-04 20:48:06''createdby=''1''updated=''2010-08-04 20:48:06''updatedby=''1', 'I', 1, '2010-08-04 20:48:10', 310, 'S', 'admin', 1680, '192.168.1.202', 'leaveadjustmentline_id', '2'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''2''employee_id=''33''leavetype_id=''9''leaveadjustmentline_totalday=''10''created=''2010-08-04 20:48:06''createdby=''1''updated=''2010-08-04 20:48:06''updatedby=''1', 'I', 1, '2010-08-04 20:48:10', 311, 'S', 'admin', 1681, '192.168.1.202', 'leaveadjustmentline_id', '2'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''2''employee_id=''38''leavetype_id=''8''leaveadjustmentline_totalday=''10''created=''2010-08-04 20:48:06''createdby=''1''updated=''2010-08-04 20:48:06''updatedby=''1', 'I', 1, '2010-08-04 20:48:10', 312, 'S', 'admin', 1682, '192.168.1.202', 'leaveadjustmentline_id', '2'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''2''employee_id=''38''leavetype_id=''10''leaveadjustmentline_totalday=''10''created=''2010-08-04 20:48:06''createdby=''1''updated=''2010-08-04 20:48:06''updatedby=''1', 'I', 1, '2010-08-04 20:48:10', 313, 'S', 'admin', 1683, '192.168.1.202', 'leaveadjustmentline_id', '2'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''2''employee_id=''38''leavetype_id=''16''leaveadjustmentline_totalday=''10''created=''2010-08-04 20:48:06''createdby=''1''updated=''2010-08-04 20:48:06''updatedby=''1', 'I', 1, '2010-08-04 20:48:10', 314, 'S', 'admin', 1684, '192.168.1.202', 'leaveadjustmentline_id', '2'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''2''employee_id=''38''leavetype_id=''9''leaveadjustmentline_totalday=''10''created=''2010-08-04 20:48:06''createdby=''1''updated=''2010-08-04 20:48:06''updatedby=''1', 'I', 1, '2010-08-04 20:48:10', 315, 'S', 'admin', 1685, '192.168.1.202', 'leaveadjustmentline_id', '2'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''2''employee_id=''24''leavetype_id=''8''leaveadjustmentline_totalday=''10''created=''2010-08-04 20:48:06''createdby=''1''updated=''2010-08-04 20:48:06''updatedby=''1', 'I', 1, '2010-08-04 20:48:10', 316, 'S', 'admin', 1686, '192.168.1.202', 'leaveadjustmentline_id', '2'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''2''employee_id=''24''leavetype_id=''10''leaveadjustmentline_totalday=''10''created=''2010-08-04 20:48:06''createdby=''1''updated=''2010-08-04 20:48:06''updatedby=''1', 'I', 1, '2010-08-04 20:48:10', 317, 'S', 'admin', 1687, '192.168.1.202', 'leaveadjustmentline_id', '2'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''2''employee_id=''24''leavetype_id=''16''leaveadjustmentline_totalday=''10''created=''2010-08-04 20:48:06''createdby=''1''updated=''2010-08-04 20:48:06''updatedby=''1', 'I', 1, '2010-08-04 20:48:10', 318, 'S', 'admin', 1688, '192.168.1.202', 'leaveadjustmentline_id', '2'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''2''employee_id=''24''leavetype_id=''9''leaveadjustmentline_totalday=''10''created=''2010-08-04 20:48:06''createdby=''1''updated=''2010-08-04 20:48:06''updatedby=''1', 'I', 1, '2010-08-04 20:48:10', 319, 'S', 'admin', 1689, '192.168.1.202', 'leaveadjustmentline_id', '2'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''2''employee_id=''30''leavetype_id=''8''leaveadjustmentline_totalday=''10''created=''2010-08-04 20:48:06''createdby=''1''updated=''2010-08-04 20:48:06''updatedby=''1', 'I', 1, '2010-08-04 20:48:10', 320, 'S', 'admin', 1690, '192.168.1.202', 'leaveadjustmentline_id', '2'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''2''employee_id=''30''leavetype_id=''10''leaveadjustmentline_totalday=''10''created=''2010-08-04 20:48:06''createdby=''1''updated=''2010-08-04 20:48:06''updatedby=''1', 'I', 1, '2010-08-04 20:48:10', 321, 'S', 'admin', 1691, '192.168.1.202', 'leaveadjustmentline_id', '2'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''2''employee_id=''30''leavetype_id=''16''leaveadjustmentline_totalday=''10''created=''2010-08-04 20:48:06''createdby=''1''updated=''2010-08-04 20:48:06''updatedby=''1', 'I', 1, '2010-08-04 20:48:10', 322, 'S', 'admin', 1692, '192.168.1.202', 'leaveadjustmentline_id', '2'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''2''employee_id=''30''leavetype_id=''9''leaveadjustmentline_totalday=''10''created=''2010-08-04 20:48:06''createdby=''1''updated=''2010-08-04 20:48:06''updatedby=''1', 'I', 1, '2010-08-04 20:48:10', 323, 'S', 'admin', 1693, '192.168.1.202', 'leaveadjustmentline_id', '2'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''2''employee_id=''15''leavetype_id=''8''leaveadjustmentline_totalday=''10''created=''2010-08-04 20:48:06''createdby=''1''updated=''2010-08-04 20:48:06''updatedby=''1', 'I', 1, '2010-08-04 20:48:10', 324, 'S', 'admin', 1694, '192.168.1.202', 'leaveadjustmentline_id', '2'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''2''employee_id=''15''leavetype_id=''10''leaveadjustmentline_totalday=''10''created=''2010-08-04 20:48:06''createdby=''1''updated=''2010-08-04 20:48:06''updatedby=''1', 'I', 1, '2010-08-04 20:48:10', 325, 'S', 'admin', 1695, '192.168.1.202', 'leaveadjustmentline_id', '2'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''2''employee_id=''15''leavetype_id=''16''leaveadjustmentline_totalday=''10''created=''2010-08-04 20:48:06''createdby=''1''updated=''2010-08-04 20:48:06''updatedby=''1', 'I', 1, '2010-08-04 20:48:10', 326, 'S', 'admin', 1696, '192.168.1.202', 'leaveadjustmentline_id', '2'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''2''employee_id=''15''leavetype_id=''9''leaveadjustmentline_totalday=''10''created=''2010-08-04 20:48:06''createdby=''1''updated=''2010-08-04 20:48:06''updatedby=''1', 'I', 1, '2010-08-04 20:48:10', 327, 'S', 'admin', 1697, '192.168.1.202', 'leaveadjustmentline_id', '2');
INSERT INTO `sim_audit` (`tablename`, `changedesc`, `category`, `uid`, `updated`, `record_id`, `eventype`, `uname`, `audit_id`, `ip`, `primarykey`, `controlvalue`) VALUES
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''2''employee_id=''20''leavetype_id=''8''leaveadjustmentline_totalday=''10''created=''2010-08-04 20:48:06''createdby=''1''updated=''2010-08-04 20:48:06''updatedby=''1', 'I', 1, '2010-08-04 20:48:10', 328, 'S', 'admin', 1698, '192.168.1.202', 'leaveadjustmentline_id', '2'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''2''employee_id=''20''leavetype_id=''10''leaveadjustmentline_totalday=''10''created=''2010-08-04 20:48:06''createdby=''1''updated=''2010-08-04 20:48:06''updatedby=''1', 'I', 1, '2010-08-04 20:48:10', 329, 'S', 'admin', 1699, '192.168.1.202', 'leaveadjustmentline_id', '2'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''2''employee_id=''20''leavetype_id=''16''leaveadjustmentline_totalday=''10''created=''2010-08-04 20:48:06''createdby=''1''updated=''2010-08-04 20:48:06''updatedby=''1', 'I', 1, '2010-08-04 20:48:11', 330, 'S', 'admin', 1700, '192.168.1.202', 'leaveadjustmentline_id', '2'),
('sim_hr_leaveadjustment', 'issubmit=''1''', 'U', 1, '2010-08-04 20:49:23', 2, 'S', 'admin', 1701, '192.168.1.202', 'leaveadjustment_id', '2'),
('sim_workflowtransaction', 'workflowtransaction_datetime=''10/08/04 20:49:23''target_groupid=''1''target_uid=''0''targetparameter_name=''10''workflowstatus_id=''1''workflow_id=''8''tablename=''sim_hr_leaveadjustment''primarykey_name=''leaveadjustment_id''primarykey_value=''2''hyperlink=''../hr/leaveadjustment.php''title_description=''''created=''10/08/04 20:49:23''list_parameter=''''workflowtransaction_description=''''workflowtransaction_feedback=''''iscomplete=''0''createdby=''1''email_list=''10''sms_list=''10''email_body=''''sms_body=''''person_id=''14''issubmit=''1', 'I', 1, '2010-08-04 20:49:23', 7, 'S', 'admin', 1702, '192.168.1.202', 'workflowtransaction_id', 'sim_hr_leaveadjustment'),
('sim_workflowtransactionhistory', 'workflowtransaction_id=''7''workflowstatus_id=''1''workflowtransaction_datetime=''10/08/04 20:49:23''uid=''1''workflowtransactionhistory_description=''', 'I', 1, '2010-08-04 20:49:23', 0, 'S', 'admin', 1703, '192.168.1.202', 'workflowtransactionhistory_id', ''),
('sim_hr_leaveadjustment', 'adjustment_for=''''created=''10/08/04 20:49:51''createdby=''admin(1)''updated=''10/08/04 20:49:51''updatedby=''admin(1)''organization_id=''1', 'I', 1, '2010-08-04 20:49:51', 3, 'S', 'admin', 1704, '192.168.1.202', 'leaveadjustment_id', 'admin'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''3''employee_id=''39''leavetype_id=''8''leaveadjustmentline_totalday=''1''created=''2010-08-04 20:49:51''createdby=''1''updated=''2010-08-04 20:49:51''updatedby=''1', 'I', 1, '2010-08-04 20:49:51', 331, 'S', 'admin', 1705, '192.168.1.202', 'leaveadjustmentline_id', '3'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''3''employee_id=''39''leavetype_id=''10''leaveadjustmentline_totalday=''1''created=''2010-08-04 20:49:51''createdby=''1''updated=''2010-08-04 20:49:51''updatedby=''1', 'I', 1, '2010-08-04 20:49:51', 332, 'S', 'admin', 1706, '192.168.1.202', 'leaveadjustmentline_id', '3'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''3''employee_id=''39''leavetype_id=''16''leaveadjustmentline_totalday=''1''created=''2010-08-04 20:49:51''createdby=''1''updated=''2010-08-04 20:49:51''updatedby=''1', 'I', 1, '2010-08-04 20:49:51', 333, 'S', 'admin', 1707, '192.168.1.202', 'leaveadjustmentline_id', '3'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''3''employee_id=''39''leavetype_id=''9''leaveadjustmentline_totalday=''1''created=''2010-08-04 20:49:51''createdby=''1''updated=''2010-08-04 20:49:51''updatedby=''1', 'I', 1, '2010-08-04 20:49:52', 334, 'S', 'admin', 1708, '192.168.1.202', 'leaveadjustmentline_id', '3'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''3''employee_id=''23''leavetype_id=''8''leaveadjustmentline_totalday=''1''created=''2010-08-04 20:49:51''createdby=''1''updated=''2010-08-04 20:49:51''updatedby=''1', 'I', 1, '2010-08-04 20:49:52', 335, 'S', 'admin', 1709, '192.168.1.202', 'leaveadjustmentline_id', '3'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''3''employee_id=''23''leavetype_id=''10''leaveadjustmentline_totalday=''1''created=''2010-08-04 20:49:51''createdby=''1''updated=''2010-08-04 20:49:51''updatedby=''1', 'I', 1, '2010-08-04 20:49:52', 336, 'S', 'admin', 1710, '192.168.1.202', 'leaveadjustmentline_id', '3'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''3''employee_id=''23''leavetype_id=''16''leaveadjustmentline_totalday=''1''created=''2010-08-04 20:49:51''createdby=''1''updated=''2010-08-04 20:49:51''updatedby=''1', 'I', 1, '2010-08-04 20:49:52', 337, 'S', 'admin', 1711, '192.168.1.202', 'leaveadjustmentline_id', '3'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''3''employee_id=''23''leavetype_id=''9''leaveadjustmentline_totalday=''1''created=''2010-08-04 20:49:51''createdby=''1''updated=''2010-08-04 20:49:51''updatedby=''1', 'I', 1, '2010-08-04 20:49:52', 338, 'S', 'admin', 1712, '192.168.1.202', 'leaveadjustmentline_id', '3'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''3''employee_id=''16''leavetype_id=''8''leaveadjustmentline_totalday=''1''created=''2010-08-04 20:49:51''createdby=''1''updated=''2010-08-04 20:49:51''updatedby=''1', 'I', 1, '2010-08-04 20:49:52', 339, 'S', 'admin', 1713, '192.168.1.202', 'leaveadjustmentline_id', '3'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''3''employee_id=''16''leavetype_id=''10''leaveadjustmentline_totalday=''1''created=''2010-08-04 20:49:51''createdby=''1''updated=''2010-08-04 20:49:51''updatedby=''1', 'I', 1, '2010-08-04 20:49:52', 340, 'S', 'admin', 1714, '192.168.1.202', 'leaveadjustmentline_id', '3'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''3''employee_id=''16''leavetype_id=''16''leaveadjustmentline_totalday=''1''created=''2010-08-04 20:49:51''createdby=''1''updated=''2010-08-04 20:49:51''updatedby=''1', 'I', 1, '2010-08-04 20:49:52', 341, 'S', 'admin', 1715, '192.168.1.202', 'leaveadjustmentline_id', '3'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''3''employee_id=''16''leavetype_id=''9''leaveadjustmentline_totalday=''1''created=''2010-08-04 20:49:51''createdby=''1''updated=''2010-08-04 20:49:51''updatedby=''1', 'I', 1, '2010-08-04 20:49:52', 342, 'S', 'admin', 1716, '192.168.1.202', 'leaveadjustmentline_id', '3'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''3''employee_id=''35''leavetype_id=''8''leaveadjustmentline_totalday=''1''created=''2010-08-04 20:49:51''createdby=''1''updated=''2010-08-04 20:49:51''updatedby=''1', 'I', 1, '2010-08-04 20:49:52', 343, 'S', 'admin', 1717, '192.168.1.202', 'leaveadjustmentline_id', '3'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''3''employee_id=''35''leavetype_id=''10''leaveadjustmentline_totalday=''1''created=''2010-08-04 20:49:51''createdby=''1''updated=''2010-08-04 20:49:51''updatedby=''1', 'I', 1, '2010-08-04 20:49:52', 344, 'S', 'admin', 1718, '192.168.1.202', 'leaveadjustmentline_id', '3'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''3''employee_id=''35''leavetype_id=''16''leaveadjustmentline_totalday=''1''created=''2010-08-04 20:49:51''createdby=''1''updated=''2010-08-04 20:49:51''updatedby=''1', 'I', 1, '2010-08-04 20:49:52', 345, 'S', 'admin', 1719, '192.168.1.202', 'leaveadjustmentline_id', '3'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''3''employee_id=''35''leavetype_id=''9''leaveadjustmentline_totalday=''1''created=''2010-08-04 20:49:51''createdby=''1''updated=''2010-08-04 20:49:51''updatedby=''1', 'I', 1, '2010-08-04 20:49:52', 346, 'S', 'admin', 1720, '192.168.1.202', 'leaveadjustmentline_id', '3'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''3''employee_id=''40''leavetype_id=''8''leaveadjustmentline_totalday=''1''created=''2010-08-04 20:49:51''createdby=''1''updated=''2010-08-04 20:49:51''updatedby=''1', 'I', 1, '2010-08-04 20:49:52', 347, 'S', 'admin', 1721, '192.168.1.202', 'leaveadjustmentline_id', '3'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''3''employee_id=''40''leavetype_id=''10''leaveadjustmentline_totalday=''1''created=''2010-08-04 20:49:51''createdby=''1''updated=''2010-08-04 20:49:51''updatedby=''1', 'I', 1, '2010-08-04 20:49:52', 348, 'S', 'admin', 1722, '192.168.1.202', 'leaveadjustmentline_id', '3'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''3''employee_id=''40''leavetype_id=''16''leaveadjustmentline_totalday=''1''created=''2010-08-04 20:49:51''createdby=''1''updated=''2010-08-04 20:49:51''updatedby=''1', 'I', 1, '2010-08-04 20:49:52', 349, 'S', 'admin', 1723, '192.168.1.202', 'leaveadjustmentline_id', '3'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''3''employee_id=''40''leavetype_id=''9''leaveadjustmentline_totalday=''1''created=''2010-08-04 20:49:51''createdby=''1''updated=''2010-08-04 20:49:51''updatedby=''1', 'I', 1, '2010-08-04 20:49:52', 350, 'S', 'admin', 1724, '192.168.1.202', 'leaveadjustmentline_id', '3'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''3''employee_id=''14''leavetype_id=''8''leaveadjustmentline_totalday=''1''created=''2010-08-04 20:49:51''createdby=''1''updated=''2010-08-04 20:49:51''updatedby=''1', 'I', 1, '2010-08-04 20:49:52', 351, 'S', 'admin', 1725, '192.168.1.202', 'leaveadjustmentline_id', '3'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''3''employee_id=''14''leavetype_id=''10''leaveadjustmentline_totalday=''1''created=''2010-08-04 20:49:51''createdby=''1''updated=''2010-08-04 20:49:51''updatedby=''1', 'I', 1, '2010-08-04 20:49:53', 352, 'S', 'admin', 1726, '192.168.1.202', 'leaveadjustmentline_id', '3'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''3''employee_id=''14''leavetype_id=''16''leaveadjustmentline_totalday=''1''created=''2010-08-04 20:49:51''createdby=''1''updated=''2010-08-04 20:49:51''updatedby=''1', 'I', 1, '2010-08-04 20:49:53', 353, 'S', 'admin', 1727, '192.168.1.202', 'leaveadjustmentline_id', '3'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''3''employee_id=''14''leavetype_id=''9''leaveadjustmentline_totalday=''1''created=''2010-08-04 20:49:51''createdby=''1''updated=''2010-08-04 20:49:51''updatedby=''1', 'I', 1, '2010-08-04 20:49:53', 354, 'S', 'admin', 1728, '192.168.1.202', 'leaveadjustmentline_id', '3'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''3''employee_id=''17''leavetype_id=''8''leaveadjustmentline_totalday=''1''created=''2010-08-04 20:49:51''createdby=''1''updated=''2010-08-04 20:49:51''updatedby=''1', 'I', 1, '2010-08-04 20:49:53', 355, 'S', 'admin', 1729, '192.168.1.202', 'leaveadjustmentline_id', '3'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''3''employee_id=''17''leavetype_id=''10''leaveadjustmentline_totalday=''1''created=''2010-08-04 20:49:51''createdby=''1''updated=''2010-08-04 20:49:51''updatedby=''1', 'I', 1, '2010-08-04 20:49:53', 356, 'S', 'admin', 1730, '192.168.1.202', 'leaveadjustmentline_id', '3'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''3''employee_id=''17''leavetype_id=''16''leaveadjustmentline_totalday=''1''created=''2010-08-04 20:49:51''createdby=''1''updated=''2010-08-04 20:49:51''updatedby=''1', 'I', 1, '2010-08-04 20:49:53', 357, 'S', 'admin', 1731, '192.168.1.202', 'leaveadjustmentline_id', '3'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''3''employee_id=''17''leavetype_id=''9''leaveadjustmentline_totalday=''1''created=''2010-08-04 20:49:51''createdby=''1''updated=''2010-08-04 20:49:51''updatedby=''1', 'I', 1, '2010-08-04 20:49:53', 358, 'S', 'admin', 1732, '192.168.1.202', 'leaveadjustmentline_id', '3'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''3''employee_id=''36''leavetype_id=''8''leaveadjustmentline_totalday=''1''created=''2010-08-04 20:49:51''createdby=''1''updated=''2010-08-04 20:49:51''updatedby=''1', 'I', 1, '2010-08-04 20:49:53', 359, 'S', 'admin', 1733, '192.168.1.202', 'leaveadjustmentline_id', '3'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''3''employee_id=''36''leavetype_id=''10''leaveadjustmentline_totalday=''1''created=''2010-08-04 20:49:51''createdby=''1''updated=''2010-08-04 20:49:51''updatedby=''1', 'I', 1, '2010-08-04 20:49:53', 360, 'S', 'admin', 1734, '192.168.1.202', 'leaveadjustmentline_id', '3'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''3''employee_id=''36''leavetype_id=''16''leaveadjustmentline_totalday=''1''created=''2010-08-04 20:49:51''createdby=''1''updated=''2010-08-04 20:49:51''updatedby=''1', 'I', 1, '2010-08-04 20:49:53', 361, 'S', 'admin', 1735, '192.168.1.202', 'leaveadjustmentline_id', '3'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''3''employee_id=''36''leavetype_id=''9''leaveadjustmentline_totalday=''1''created=''2010-08-04 20:49:51''createdby=''1''updated=''2010-08-04 20:49:51''updatedby=''1', 'I', 1, '2010-08-04 20:49:53', 362, 'S', 'admin', 1736, '192.168.1.202', 'leaveadjustmentline_id', '3'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''3''employee_id=''22''leavetype_id=''8''leaveadjustmentline_totalday=''1''created=''2010-08-04 20:49:51''createdby=''1''updated=''2010-08-04 20:49:51''updatedby=''1', 'I', 1, '2010-08-04 20:49:53', 363, 'S', 'admin', 1737, '192.168.1.202', 'leaveadjustmentline_id', '3'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''3''employee_id=''22''leavetype_id=''10''leaveadjustmentline_totalday=''1''created=''2010-08-04 20:49:51''createdby=''1''updated=''2010-08-04 20:49:51''updatedby=''1', 'I', 1, '2010-08-04 20:49:53', 364, 'S', 'admin', 1738, '192.168.1.202', 'leaveadjustmentline_id', '3'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''3''employee_id=''22''leavetype_id=''16''leaveadjustmentline_totalday=''1''created=''2010-08-04 20:49:51''createdby=''1''updated=''2010-08-04 20:49:51''updatedby=''1', 'I', 1, '2010-08-04 20:49:53', 365, 'S', 'admin', 1739, '192.168.1.202', 'leaveadjustmentline_id', '3'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''3''employee_id=''22''leavetype_id=''9''leaveadjustmentline_totalday=''1''created=''2010-08-04 20:49:51''createdby=''1''updated=''2010-08-04 20:49:51''updatedby=''1', 'I', 1, '2010-08-04 20:49:53', 366, 'S', 'admin', 1740, '192.168.1.202', 'leaveadjustmentline_id', '3'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''3''employee_id=''41''leavetype_id=''8''leaveadjustmentline_totalday=''1''created=''2010-08-04 20:49:51''createdby=''1''updated=''2010-08-04 20:49:51''updatedby=''1', 'I', 1, '2010-08-04 20:49:53', 367, 'S', 'admin', 1741, '192.168.1.202', 'leaveadjustmentline_id', '3'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''3''employee_id=''41''leavetype_id=''10''leaveadjustmentline_totalday=''1''created=''2010-08-04 20:49:51''createdby=''1''updated=''2010-08-04 20:49:51''updatedby=''1', 'I', 1, '2010-08-04 20:49:53', 368, 'S', 'admin', 1742, '192.168.1.202', 'leaveadjustmentline_id', '3'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''3''employee_id=''41''leavetype_id=''''leaveadjustmentline_totalday=''1''created=''2010-08-04 20:49:51''createdby=''1''updated=''2010-08-04 20:49:51''updatedby=''1', 'I', 1, '2010-08-04 20:49:53', 369, 'S', 'admin', 1743, '192.168.1.202', 'leaveadjustmentline_id', '3'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''3''employee_id=''41''leavetype_id=''''leaveadjustmentline_totalday=''1''created=''2010-08-04 20:49:51''createdby=''1''updated=''2010-08-04 20:49:51''updatedby=''1', 'I', 1, '2010-08-04 20:49:53', 370, 'S', 'admin', 1744, '192.168.1.202', 'leaveadjustmentline_id', '3'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''3''employee_id=''21''leavetype_id=''9''leaveadjustmentline_totalday=''1''created=''2010-08-04 20:49:51''createdby=''1''updated=''2010-08-04 20:49:51''updatedby=''1', 'I', 1, '2010-08-04 20:49:53', 371, 'S', 'admin', 1745, '192.168.1.202', 'leaveadjustmentline_id', '3'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''3''employee_id=''21''leavetype_id=''8''leaveadjustmentline_totalday=''1''created=''2010-08-04 20:49:51''createdby=''1''updated=''2010-08-04 20:49:51''updatedby=''1', 'I', 1, '2010-08-04 20:49:54', 372, 'S', 'admin', 1746, '192.168.1.202', 'leaveadjustmentline_id', '3'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''3''employee_id=''21''leavetype_id=''10''leaveadjustmentline_totalday=''1''created=''2010-08-04 20:49:51''createdby=''1''updated=''2010-08-04 20:49:51''updatedby=''1', 'I', 1, '2010-08-04 20:49:54', 373, 'S', 'admin', 1747, '192.168.1.202', 'leaveadjustmentline_id', '3'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''3''employee_id=''21''leavetype_id=''16''leaveadjustmentline_totalday=''1''created=''2010-08-04 20:49:51''createdby=''1''updated=''2010-08-04 20:49:51''updatedby=''1', 'I', 1, '2010-08-04 20:49:54', 374, 'S', 'admin', 1748, '192.168.1.202', 'leaveadjustmentline_id', '3'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''3''employee_id=''''leavetype_id=''9''leaveadjustmentline_totalday=''1''created=''2010-08-04 20:49:51''createdby=''1''updated=''2010-08-04 20:49:51''updatedby=''1', 'I', 1, '2010-08-04 20:49:54', 375, 'S', 'admin', 1749, '192.168.1.202', 'leaveadjustmentline_id', '3'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''3''employee_id=''''leavetype_id=''8''leaveadjustmentline_totalday=''1''created=''2010-08-04 20:49:51''createdby=''1''updated=''2010-08-04 20:49:51''updatedby=''1', 'I', 1, '2010-08-04 20:49:54', 376, 'S', 'admin', 1750, '192.168.1.202', 'leaveadjustmentline_id', '3'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''3''employee_id=''18''leavetype_id=''10''leaveadjustmentline_totalday=''1''created=''2010-08-04 20:49:51''createdby=''1''updated=''2010-08-04 20:49:51''updatedby=''1', 'I', 1, '2010-08-04 20:49:54', 377, 'S', 'admin', 1751, '192.168.1.202', 'leaveadjustmentline_id', '3'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''3''employee_id=''18''leavetype_id=''16''leaveadjustmentline_totalday=''1''created=''2010-08-04 20:49:51''createdby=''1''updated=''2010-08-04 20:49:51''updatedby=''1', 'I', 1, '2010-08-04 20:49:54', 378, 'S', 'admin', 1752, '192.168.1.202', 'leaveadjustmentline_id', '3'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''3''employee_id=''18''leavetype_id=''9''leaveadjustmentline_totalday=''1''created=''2010-08-04 20:49:51''createdby=''1''updated=''2010-08-04 20:49:51''updatedby=''1', 'I', 1, '2010-08-04 20:49:54', 379, 'S', 'admin', 1753, '192.168.1.202', 'leaveadjustmentline_id', '3'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''3''employee_id=''19''leavetype_id=''8''leaveadjustmentline_totalday=''1''created=''2010-08-04 20:49:51''createdby=''1''updated=''2010-08-04 20:49:51''updatedby=''1', 'I', 1, '2010-08-04 20:49:54', 380, 'S', 'admin', 1754, '192.168.1.202', 'leaveadjustmentline_id', '3'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''3''employee_id=''19''leavetype_id=''10''leaveadjustmentline_totalday=''1''created=''2010-08-04 20:49:51''createdby=''1''updated=''2010-08-04 20:49:51''updatedby=''1', 'I', 1, '2010-08-04 20:49:54', 381, 'S', 'admin', 1755, '192.168.1.202', 'leaveadjustmentline_id', '3'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''3''employee_id=''19''leavetype_id=''16''leaveadjustmentline_totalday=''1''created=''2010-08-04 20:49:51''createdby=''1''updated=''2010-08-04 20:49:51''updatedby=''1', 'I', 1, '2010-08-04 20:49:54', 382, 'S', 'admin', 1756, '192.168.1.202', 'leaveadjustmentline_id', '3'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''3''employee_id=''19''leavetype_id=''9''leaveadjustmentline_totalday=''1''created=''2010-08-04 20:49:51''createdby=''1''updated=''2010-08-04 20:49:51''updatedby=''1', 'I', 1, '2010-08-04 20:49:54', 383, 'S', 'admin', 1757, '192.168.1.202', 'leaveadjustmentline_id', '3'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''3''employee_id=''33''leavetype_id=''8''leaveadjustmentline_totalday=''1''created=''2010-08-04 20:49:51''createdby=''1''updated=''2010-08-04 20:49:51''updatedby=''1', 'I', 1, '2010-08-04 20:49:54', 384, 'S', 'admin', 1758, '192.168.1.202', 'leaveadjustmentline_id', '3'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''3''employee_id=''33''leavetype_id=''10''leaveadjustmentline_totalday=''1''created=''2010-08-04 20:49:51''createdby=''1''updated=''2010-08-04 20:49:51''updatedby=''1', 'I', 1, '2010-08-04 20:49:54', 385, 'S', 'admin', 1759, '192.168.1.202', 'leaveadjustmentline_id', '3'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''3''employee_id=''33''leavetype_id=''16''leaveadjustmentline_totalday=''1''created=''2010-08-04 20:49:51''createdby=''1''updated=''2010-08-04 20:49:51''updatedby=''1', 'I', 1, '2010-08-04 20:49:54', 386, 'S', 'admin', 1760, '192.168.1.202', 'leaveadjustmentline_id', '3'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''3''employee_id=''33''leavetype_id=''9''leaveadjustmentline_totalday=''1''created=''2010-08-04 20:49:51''createdby=''1''updated=''2010-08-04 20:49:51''updatedby=''1', 'I', 1, '2010-08-04 20:49:55', 387, 'S', 'admin', 1761, '192.168.1.202', 'leaveadjustmentline_id', '3'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''3''employee_id=''38''leavetype_id=''8''leaveadjustmentline_totalday=''1''created=''2010-08-04 20:49:51''createdby=''1''updated=''2010-08-04 20:49:51''updatedby=''1', 'I', 1, '2010-08-04 20:49:55', 388, 'S', 'admin', 1762, '192.168.1.202', 'leaveadjustmentline_id', '3'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''3''employee_id=''38''leavetype_id=''10''leaveadjustmentline_totalday=''1''created=''2010-08-04 20:49:51''createdby=''1''updated=''2010-08-04 20:49:51''updatedby=''1', 'I', 1, '2010-08-04 20:49:55', 389, 'S', 'admin', 1763, '192.168.1.202', 'leaveadjustmentline_id', '3'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''3''employee_id=''38''leavetype_id=''16''leaveadjustmentline_totalday=''1''created=''2010-08-04 20:49:51''createdby=''1''updated=''2010-08-04 20:49:51''updatedby=''1', 'I', 1, '2010-08-04 20:49:55', 390, 'S', 'admin', 1764, '192.168.1.202', 'leaveadjustmentline_id', '3'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''3''employee_id=''38''leavetype_id=''9''leaveadjustmentline_totalday=''1''created=''2010-08-04 20:49:51''createdby=''1''updated=''2010-08-04 20:49:51''updatedby=''1', 'I', 1, '2010-08-04 20:49:55', 391, 'S', 'admin', 1765, '192.168.1.202', 'leaveadjustmentline_id', '3'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''3''employee_id=''24''leavetype_id=''8''leaveadjustmentline_totalday=''1''created=''2010-08-04 20:49:51''createdby=''1''updated=''2010-08-04 20:49:51''updatedby=''1', 'I', 1, '2010-08-04 20:49:55', 392, 'S', 'admin', 1766, '192.168.1.202', 'leaveadjustmentline_id', '3'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''3''employee_id=''24''leavetype_id=''10''leaveadjustmentline_totalday=''1''created=''2010-08-04 20:49:51''createdby=''1''updated=''2010-08-04 20:49:51''updatedby=''1', 'I', 1, '2010-08-04 20:49:55', 393, 'S', 'admin', 1767, '192.168.1.202', 'leaveadjustmentline_id', '3'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''3''employee_id=''24''leavetype_id=''16''leaveadjustmentline_totalday=''1''created=''2010-08-04 20:49:51''createdby=''1''updated=''2010-08-04 20:49:51''updatedby=''1', 'I', 1, '2010-08-04 20:49:55', 394, 'S', 'admin', 1768, '192.168.1.202', 'leaveadjustmentline_id', '3'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''3''employee_id=''24''leavetype_id=''9''leaveadjustmentline_totalday=''1''created=''2010-08-04 20:49:51''createdby=''1''updated=''2010-08-04 20:49:51''updatedby=''1', 'I', 1, '2010-08-04 20:49:55', 395, 'S', 'admin', 1769, '192.168.1.202', 'leaveadjustmentline_id', '3'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''3''employee_id=''30''leavetype_id=''8''leaveadjustmentline_totalday=''1''created=''2010-08-04 20:49:51''createdby=''1''updated=''2010-08-04 20:49:51''updatedby=''1', 'I', 1, '2010-08-04 20:49:55', 396, 'S', 'admin', 1770, '192.168.1.202', 'leaveadjustmentline_id', '3'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''3''employee_id=''30''leavetype_id=''10''leaveadjustmentline_totalday=''1''created=''2010-08-04 20:49:51''createdby=''1''updated=''2010-08-04 20:49:51''updatedby=''1', 'I', 1, '2010-08-04 20:49:55', 397, 'S', 'admin', 1771, '192.168.1.202', 'leaveadjustmentline_id', '3'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''3''employee_id=''30''leavetype_id=''16''leaveadjustmentline_totalday=''1''created=''2010-08-04 20:49:51''createdby=''1''updated=''2010-08-04 20:49:51''updatedby=''1', 'I', 1, '2010-08-04 20:49:55', 398, 'S', 'admin', 1772, '192.168.1.202', 'leaveadjustmentline_id', '3'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''3''employee_id=''30''leavetype_id=''9''leaveadjustmentline_totalday=''1''created=''2010-08-04 20:49:51''createdby=''1''updated=''2010-08-04 20:49:51''updatedby=''1', 'I', 1, '2010-08-04 20:49:55', 399, 'S', 'admin', 1773, '192.168.1.202', 'leaveadjustmentline_id', '3'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''3''employee_id=''15''leavetype_id=''8''leaveadjustmentline_totalday=''1''created=''2010-08-04 20:49:51''createdby=''1''updated=''2010-08-04 20:49:51''updatedby=''1', 'I', 1, '2010-08-04 20:49:55', 400, 'S', 'admin', 1774, '192.168.1.202', 'leaveadjustmentline_id', '3'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''3''employee_id=''15''leavetype_id=''10''leaveadjustmentline_totalday=''1''created=''2010-08-04 20:49:51''createdby=''1''updated=''2010-08-04 20:49:51''updatedby=''1', 'I', 1, '2010-08-04 20:49:55', 401, 'S', 'admin', 1775, '192.168.1.202', 'leaveadjustmentline_id', '3'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''3''employee_id=''15''leavetype_id=''16''leaveadjustmentline_totalday=''1''created=''2010-08-04 20:49:51''createdby=''1''updated=''2010-08-04 20:49:51''updatedby=''1', 'I', 1, '2010-08-04 20:49:55', 402, 'S', 'admin', 1776, '192.168.1.202', 'leaveadjustmentline_id', '3'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''3''employee_id=''15''leavetype_id=''9''leaveadjustmentline_totalday=''1''created=''2010-08-04 20:49:51''createdby=''1''updated=''2010-08-04 20:49:51''updatedby=''1', 'I', 1, '2010-08-04 20:49:56', 403, 'S', 'admin', 1777, '192.168.1.202', 'leaveadjustmentline_id', '3'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''3''employee_id=''20''leavetype_id=''8''leaveadjustmentline_totalday=''1''created=''2010-08-04 20:49:51''createdby=''1''updated=''2010-08-04 20:49:51''updatedby=''1', 'I', 1, '2010-08-04 20:49:56', 404, 'S', 'admin', 1778, '192.168.1.202', 'leaveadjustmentline_id', '3'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''3''employee_id=''20''leavetype_id=''10''leaveadjustmentline_totalday=''1''created=''2010-08-04 20:49:51''createdby=''1''updated=''2010-08-04 20:49:51''updatedby=''1', 'I', 1, '2010-08-04 20:49:56', 405, 'S', 'admin', 1779, '192.168.1.202', 'leaveadjustmentline_id', '3'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''3''employee_id=''20''leavetype_id=''16''leaveadjustmentline_totalday=''1''created=''2010-08-04 20:49:51''createdby=''1''updated=''2010-08-04 20:49:51''updatedby=''1', 'I', 1, '2010-08-04 20:49:56', 406, 'S', 'admin', 1780, '192.168.1.202', 'leaveadjustmentline_id', '3'),
('sim_workflowtransaction', 'workflowtransaction_datetime=''10/08/04 20:50:31''target_groupid=''1''target_uid=''0''targetparameter_name=''10''workflowstatus_id=''2''workflow_id=''8''tablename=''sim_hr_leaveadjustment''primarykey_name=''leaveadjustment_id''primarykey_value=''1''hyperlink=''../hr/leaveadjustment.php''title_description=''''created=''10/08/04 20:50:31''list_parameter=''''workflowtransaction_description=''''workflowtransaction_feedback=''''iscomplete=''1''createdby=''1''email_list=''10''sms_list=''10''email_body=''''sms_body=''''person_id=''14''issubmit=''1', 'I', 1, '2010-08-04 20:50:32', 8, 'S', 'admin', 1781, '192.168.1.202', 'workflowtransaction_id', 'sim_hr_leaveadjustment'),
('sim_workflowtransactionhistory', 'workflowtransaction_id=''8''workflowstatus_id=''2''workflowtransaction_datetime=''10/08/04 20:50:32''uid=''1''workflowtransactionhistory_description=''', 'I', 1, '2010-08-04 20:50:32', 0, 'S', 'admin', 1782, '192.168.1.202', 'workflowtransactionhistory_id', ''),
('sim_workflowtransaction', 'workflowtransaction_datetime=''10/08/04 20:53:51''target_groupid=''''target_uid=''''targetparameter_name=''''workflowstatus_id=''''workflow_id=''''tablename=''sim_hr_leaveadjustment''primarykey_name=''leaveadjustment_id''primarykey_value=''2''hyperlink=''''title_description=''''created=''10/08/04 20:53:51''list_parameter=''''workflowtransaction_description=''''workflowtransaction_feedback=''''iscomplete=''''createdby=''1''email_list=''''sms_list=''''email_body=''''sms_body=''''person_id=''14''issubmit=''', 'I', 1, '2010-08-04 20:53:51', 9, 'S', '', 1783, '192.168.1.202', 'workflowtransaction_id', 'sim_hr_leaveadjustment'),
('sim_workflowtransactionhistory', 'workflowtransaction_id=''9''workflowstatus_id=''''workflowtransaction_datetime=''10/08/04 20:53:51''uid=''1''workflowtransactionhistory_description=''', 'I', 1, '2010-08-04 20:53:51', 0, 'S', '', 1784, '192.168.1.202', 'workflowtransactionhistory_id', ''),
('sim_hr_supervisorline', 'supervisorline_supervisorid=''16''isdirect=''1''supervisorline_remarks=''''created=''2010-08-05 09:32:06''createdby=''1''updated=''2010-08-05 09:32:06''updatedby=''1''employee_id=''19', 'I', 1, '2010-08-05 09:32:06', 28, 'S', 'admin', 1785, '::1', 'supervisorline_id', '16'),
('sim_hr_leaveadjustment', 'adjustment_for=''''created=''10/08/05 09:37:07''createdby=''admin(1)''updated=''10/08/05 09:37:07''updatedby=''admin(1)''organization_id=''1', 'I', 1, '2010-08-05 09:37:07', 4, 'S', 'admin', 1786, '::1', 'leaveadjustment_id', 'admin'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''4''employee_id=''39''leavetype_id=''8''leaveadjustmentline_totalday=''2''created=''2010-08-05 09:37:07''createdby=''1''updated=''2010-08-05 09:37:07''updatedby=''1', 'I', 1, '2010-08-05 09:37:07', 407, 'S', 'admin', 1787, '::1', 'leaveadjustmentline_id', '4'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''4''employee_id=''39''leavetype_id=''10''leaveadjustmentline_totalday=''2''created=''2010-08-05 09:37:07''createdby=''1''updated=''2010-08-05 09:37:07''updatedby=''1', 'I', 1, '2010-08-05 09:37:07', 408, 'S', 'admin', 1788, '::1', 'leaveadjustmentline_id', '4'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''4''employee_id=''39''leavetype_id=''16''leaveadjustmentline_totalday=''2''created=''2010-08-05 09:37:07''createdby=''1''updated=''2010-08-05 09:37:07''updatedby=''1', 'I', 1, '2010-08-05 09:37:07', 409, 'S', 'admin', 1789, '::1', 'leaveadjustmentline_id', '4'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''4''employee_id=''39''leavetype_id=''9''leaveadjustmentline_totalday=''2''created=''2010-08-05 09:37:07''createdby=''1''updated=''2010-08-05 09:37:07''updatedby=''1', 'I', 1, '2010-08-05 09:37:07', 410, 'S', 'admin', 1790, '::1', 'leaveadjustmentline_id', '4'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''4''employee_id=''23''leavetype_id=''8''leaveadjustmentline_totalday=''2''created=''2010-08-05 09:37:07''createdby=''1''updated=''2010-08-05 09:37:07''updatedby=''1', 'I', 1, '2010-08-05 09:37:07', 411, 'S', 'admin', 1791, '::1', 'leaveadjustmentline_id', '4'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''4''employee_id=''23''leavetype_id=''10''leaveadjustmentline_totalday=''2''created=''2010-08-05 09:37:07''createdby=''1''updated=''2010-08-05 09:37:07''updatedby=''1', 'I', 1, '2010-08-05 09:37:07', 412, 'S', 'admin', 1792, '::1', 'leaveadjustmentline_id', '4'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''4''employee_id=''23''leavetype_id=''16''leaveadjustmentline_totalday=''2''created=''2010-08-05 09:37:07''createdby=''1''updated=''2010-08-05 09:37:07''updatedby=''1', 'I', 1, '2010-08-05 09:37:07', 413, 'S', 'admin', 1793, '::1', 'leaveadjustmentline_id', '4'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''4''employee_id=''23''leavetype_id=''9''leaveadjustmentline_totalday=''2''created=''2010-08-05 09:37:07''createdby=''1''updated=''2010-08-05 09:37:07''updatedby=''1', 'I', 1, '2010-08-05 09:37:08', 414, 'S', 'admin', 1794, '::1', 'leaveadjustmentline_id', '4'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''4''employee_id=''16''leavetype_id=''8''leaveadjustmentline_totalday=''2''created=''2010-08-05 09:37:07''createdby=''1''updated=''2010-08-05 09:37:07''updatedby=''1', 'I', 1, '2010-08-05 09:37:08', 415, 'S', 'admin', 1795, '::1', 'leaveadjustmentline_id', '4'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''4''employee_id=''16''leavetype_id=''10''leaveadjustmentline_totalday=''2''created=''2010-08-05 09:37:07''createdby=''1''updated=''2010-08-05 09:37:07''updatedby=''1', 'I', 1, '2010-08-05 09:37:08', 416, 'S', 'admin', 1796, '::1', 'leaveadjustmentline_id', '4'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''4''employee_id=''16''leavetype_id=''16''leaveadjustmentline_totalday=''2''created=''2010-08-05 09:37:07''createdby=''1''updated=''2010-08-05 09:37:07''updatedby=''1', 'I', 1, '2010-08-05 09:37:08', 417, 'S', 'admin', 1797, '::1', 'leaveadjustmentline_id', '4'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''4''employee_id=''16''leavetype_id=''9''leaveadjustmentline_totalday=''2''created=''2010-08-05 09:37:07''createdby=''1''updated=''2010-08-05 09:37:07''updatedby=''1', 'I', 1, '2010-08-05 09:37:08', 418, 'S', 'admin', 1798, '::1', 'leaveadjustmentline_id', '4'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''4''employee_id=''35''leavetype_id=''8''leaveadjustmentline_totalday=''2''created=''2010-08-05 09:37:07''createdby=''1''updated=''2010-08-05 09:37:07''updatedby=''1', 'I', 1, '2010-08-05 09:37:08', 419, 'S', 'admin', 1799, '::1', 'leaveadjustmentline_id', '4'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''4''employee_id=''35''leavetype_id=''10''leaveadjustmentline_totalday=''2''created=''2010-08-05 09:37:07''createdby=''1''updated=''2010-08-05 09:37:07''updatedby=''1', 'I', 1, '2010-08-05 09:37:08', 420, 'S', 'admin', 1800, '::1', 'leaveadjustmentline_id', '4'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''4''employee_id=''35''leavetype_id=''16''leaveadjustmentline_totalday=''2''created=''2010-08-05 09:37:07''createdby=''1''updated=''2010-08-05 09:37:07''updatedby=''1', 'I', 1, '2010-08-05 09:37:08', 421, 'S', 'admin', 1801, '::1', 'leaveadjustmentline_id', '4'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''4''employee_id=''35''leavetype_id=''9''leaveadjustmentline_totalday=''2''created=''2010-08-05 09:37:07''createdby=''1''updated=''2010-08-05 09:37:07''updatedby=''1', 'I', 1, '2010-08-05 09:37:08', 422, 'S', 'admin', 1802, '::1', 'leaveadjustmentline_id', '4'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''4''employee_id=''40''leavetype_id=''8''leaveadjustmentline_totalday=''2''created=''2010-08-05 09:37:07''createdby=''1''updated=''2010-08-05 09:37:07''updatedby=''1', 'I', 1, '2010-08-05 09:37:08', 423, 'S', 'admin', 1803, '::1', 'leaveadjustmentline_id', '4'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''4''employee_id=''40''leavetype_id=''10''leaveadjustmentline_totalday=''2''created=''2010-08-05 09:37:07''createdby=''1''updated=''2010-08-05 09:37:07''updatedby=''1', 'I', 1, '2010-08-05 09:37:08', 424, 'S', 'admin', 1804, '::1', 'leaveadjustmentline_id', '4'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''4''employee_id=''40''leavetype_id=''16''leaveadjustmentline_totalday=''2''created=''2010-08-05 09:37:07''createdby=''1''updated=''2010-08-05 09:37:07''updatedby=''1', 'I', 1, '2010-08-05 09:37:08', 425, 'S', 'admin', 1805, '::1', 'leaveadjustmentline_id', '4'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''4''employee_id=''40''leavetype_id=''9''leaveadjustmentline_totalday=''2''created=''2010-08-05 09:37:07''createdby=''1''updated=''2010-08-05 09:37:07''updatedby=''1', 'I', 1, '2010-08-05 09:37:08', 426, 'S', 'admin', 1806, '::1', 'leaveadjustmentline_id', '4'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''4''employee_id=''14''leavetype_id=''8''leaveadjustmentline_totalday=''2''created=''2010-08-05 09:37:07''createdby=''1''updated=''2010-08-05 09:37:07''updatedby=''1', 'I', 1, '2010-08-05 09:37:08', 427, 'S', 'admin', 1807, '::1', 'leaveadjustmentline_id', '4'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''4''employee_id=''14''leavetype_id=''10''leaveadjustmentline_totalday=''2''created=''2010-08-05 09:37:07''createdby=''1''updated=''2010-08-05 09:37:07''updatedby=''1', 'I', 1, '2010-08-05 09:37:08', 428, 'S', 'admin', 1808, '::1', 'leaveadjustmentline_id', '4'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''4''employee_id=''14''leavetype_id=''16''leaveadjustmentline_totalday=''2''created=''2010-08-05 09:37:07''createdby=''1''updated=''2010-08-05 09:37:07''updatedby=''1', 'I', 1, '2010-08-05 09:37:08', 429, 'S', 'admin', 1809, '::1', 'leaveadjustmentline_id', '4'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''4''employee_id=''14''leavetype_id=''9''leaveadjustmentline_totalday=''2''created=''2010-08-05 09:37:07''createdby=''1''updated=''2010-08-05 09:37:07''updatedby=''1', 'I', 1, '2010-08-05 09:37:08', 430, 'S', 'admin', 1810, '::1', 'leaveadjustmentline_id', '4'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''4''employee_id=''17''leavetype_id=''8''leaveadjustmentline_totalday=''2''created=''2010-08-05 09:37:07''createdby=''1''updated=''2010-08-05 09:37:07''updatedby=''1', 'I', 1, '2010-08-05 09:37:08', 431, 'S', 'admin', 1811, '::1', 'leaveadjustmentline_id', '4'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''4''employee_id=''17''leavetype_id=''10''leaveadjustmentline_totalday=''2''created=''2010-08-05 09:37:07''createdby=''1''updated=''2010-08-05 09:37:07''updatedby=''1', 'I', 1, '2010-08-05 09:37:08', 432, 'S', 'admin', 1812, '::1', 'leaveadjustmentline_id', '4'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''4''employee_id=''17''leavetype_id=''16''leaveadjustmentline_totalday=''2''created=''2010-08-05 09:37:07''createdby=''1''updated=''2010-08-05 09:37:07''updatedby=''1', 'I', 1, '2010-08-05 09:37:08', 433, 'S', 'admin', 1813, '::1', 'leaveadjustmentline_id', '4'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''4''employee_id=''17''leavetype_id=''9''leaveadjustmentline_totalday=''2''created=''2010-08-05 09:37:07''createdby=''1''updated=''2010-08-05 09:37:07''updatedby=''1', 'I', 1, '2010-08-05 09:37:08', 434, 'S', 'admin', 1814, '::1', 'leaveadjustmentline_id', '4'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''4''employee_id=''36''leavetype_id=''8''leaveadjustmentline_totalday=''2''created=''2010-08-05 09:37:07''createdby=''1''updated=''2010-08-05 09:37:07''updatedby=''1', 'I', 1, '2010-08-05 09:37:09', 435, 'S', 'admin', 1815, '::1', 'leaveadjustmentline_id', '4'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''4''employee_id=''36''leavetype_id=''10''leaveadjustmentline_totalday=''2''created=''2010-08-05 09:37:07''createdby=''1''updated=''2010-08-05 09:37:07''updatedby=''1', 'I', 1, '2010-08-05 09:37:09', 436, 'S', 'admin', 1816, '::1', 'leaveadjustmentline_id', '4'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''4''employee_id=''36''leavetype_id=''16''leaveadjustmentline_totalday=''2''created=''2010-08-05 09:37:07''createdby=''1''updated=''2010-08-05 09:37:07''updatedby=''1', 'I', 1, '2010-08-05 09:37:09', 437, 'S', 'admin', 1817, '::1', 'leaveadjustmentline_id', '4'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''4''employee_id=''36''leavetype_id=''9''leaveadjustmentline_totalday=''2''created=''2010-08-05 09:37:07''createdby=''1''updated=''2010-08-05 09:37:07''updatedby=''1', 'I', 1, '2010-08-05 09:37:09', 438, 'S', 'admin', 1818, '::1', 'leaveadjustmentline_id', '4'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''4''employee_id=''22''leavetype_id=''8''leaveadjustmentline_totalday=''2''created=''2010-08-05 09:37:07''createdby=''1''updated=''2010-08-05 09:37:07''updatedby=''1', 'I', 1, '2010-08-05 09:37:09', 439, 'S', 'admin', 1819, '::1', 'leaveadjustmentline_id', '4'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''4''employee_id=''22''leavetype_id=''10''leaveadjustmentline_totalday=''2''created=''2010-08-05 09:37:07''createdby=''1''updated=''2010-08-05 09:37:07''updatedby=''1', 'I', 1, '2010-08-05 09:37:09', 440, 'S', 'admin', 1820, '::1', 'leaveadjustmentline_id', '4'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''4''employee_id=''22''leavetype_id=''16''leaveadjustmentline_totalday=''2''created=''2010-08-05 09:37:07''createdby=''1''updated=''2010-08-05 09:37:07''updatedby=''1', 'I', 1, '2010-08-05 09:37:09', 441, 'S', 'admin', 1821, '::1', 'leaveadjustmentline_id', '4'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''4''employee_id=''22''leavetype_id=''9''leaveadjustmentline_totalday=''2''created=''2010-08-05 09:37:07''createdby=''1''updated=''2010-08-05 09:37:07''updatedby=''1', 'I', 1, '2010-08-05 09:37:09', 442, 'S', 'admin', 1822, '::1', 'leaveadjustmentline_id', '4'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''4''employee_id=''41''leavetype_id=''8''leaveadjustmentline_totalday=''2''created=''2010-08-05 09:37:07''createdby=''1''updated=''2010-08-05 09:37:07''updatedby=''1', 'I', 1, '2010-08-05 09:37:09', 443, 'S', 'admin', 1823, '::1', 'leaveadjustmentline_id', '4'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''4''employee_id=''41''leavetype_id=''10''leaveadjustmentline_totalday=''2''created=''2010-08-05 09:37:07''createdby=''1''updated=''2010-08-05 09:37:07''updatedby=''1', 'I', 1, '2010-08-05 09:37:09', 444, 'S', 'admin', 1824, '::1', 'leaveadjustmentline_id', '4'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''4''employee_id=''41''leavetype_id=''''leaveadjustmentline_totalday=''2''created=''2010-08-05 09:37:07''createdby=''1''updated=''2010-08-05 09:37:07''updatedby=''1', 'I', 1, '2010-08-05 09:37:09', 445, 'S', 'admin', 1825, '::1', 'leaveadjustmentline_id', '4'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''4''employee_id=''41''leavetype_id=''''leaveadjustmentline_totalday=''2''created=''2010-08-05 09:37:07''createdby=''1''updated=''2010-08-05 09:37:07''updatedby=''1', 'I', 1, '2010-08-05 09:37:09', 446, 'S', 'admin', 1826, '::1', 'leaveadjustmentline_id', '4'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''4''employee_id=''21''leavetype_id=''9''leaveadjustmentline_totalday=''2''created=''2010-08-05 09:37:07''createdby=''1''updated=''2010-08-05 09:37:07''updatedby=''1', 'I', 1, '2010-08-05 09:37:09', 447, 'S', 'admin', 1827, '::1', 'leaveadjustmentline_id', '4'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''4''employee_id=''21''leavetype_id=''8''leaveadjustmentline_totalday=''2''created=''2010-08-05 09:37:07''createdby=''1''updated=''2010-08-05 09:37:07''updatedby=''1', 'I', 1, '2010-08-05 09:37:09', 448, 'S', 'admin', 1828, '::1', 'leaveadjustmentline_id', '4'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''4''employee_id=''21''leavetype_id=''10''leaveadjustmentline_totalday=''2''created=''2010-08-05 09:37:07''createdby=''1''updated=''2010-08-05 09:37:07''updatedby=''1', 'I', 1, '2010-08-05 09:37:09', 449, 'S', 'admin', 1829, '::1', 'leaveadjustmentline_id', '4'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''4''employee_id=''21''leavetype_id=''16''leaveadjustmentline_totalday=''2''created=''2010-08-05 09:37:07''createdby=''1''updated=''2010-08-05 09:37:07''updatedby=''1', 'I', 1, '2010-08-05 09:37:09', 450, 'S', 'admin', 1830, '::1', 'leaveadjustmentline_id', '4'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''4''employee_id=''''leavetype_id=''9''leaveadjustmentline_totalday=''2''created=''2010-08-05 09:37:07''createdby=''1''updated=''2010-08-05 09:37:07''updatedby=''1', 'I', 1, '2010-08-05 09:37:09', 451, 'S', 'admin', 1831, '::1', 'leaveadjustmentline_id', '4'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''4''employee_id=''''leavetype_id=''8''leaveadjustmentline_totalday=''2''created=''2010-08-05 09:37:07''createdby=''1''updated=''2010-08-05 09:37:07''updatedby=''1', 'I', 1, '2010-08-05 09:37:09', 452, 'S', 'admin', 1832, '::1', 'leaveadjustmentline_id', '4'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''4''employee_id=''18''leavetype_id=''10''leaveadjustmentline_totalday=''2''created=''2010-08-05 09:37:07''createdby=''1''updated=''2010-08-05 09:37:07''updatedby=''1', 'I', 1, '2010-08-05 09:37:10', 453, 'S', 'admin', 1833, '::1', 'leaveadjustmentline_id', '4'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''4''employee_id=''18''leavetype_id=''16''leaveadjustmentline_totalday=''2''created=''2010-08-05 09:37:07''createdby=''1''updated=''2010-08-05 09:37:07''updatedby=''1', 'I', 1, '2010-08-05 09:37:10', 454, 'S', 'admin', 1834, '::1', 'leaveadjustmentline_id', '4'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''4''employee_id=''18''leavetype_id=''9''leaveadjustmentline_totalday=''2''created=''2010-08-05 09:37:07''createdby=''1''updated=''2010-08-05 09:37:07''updatedby=''1', 'I', 1, '2010-08-05 09:37:10', 455, 'S', 'admin', 1835, '::1', 'leaveadjustmentline_id', '4'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''4''employee_id=''19''leavetype_id=''8''leaveadjustmentline_totalday=''2''created=''2010-08-05 09:37:07''createdby=''1''updated=''2010-08-05 09:37:07''updatedby=''1', 'I', 1, '2010-08-05 09:37:10', 456, 'S', 'admin', 1836, '::1', 'leaveadjustmentline_id', '4'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''4''employee_id=''19''leavetype_id=''10''leaveadjustmentline_totalday=''2''created=''2010-08-05 09:37:07''createdby=''1''updated=''2010-08-05 09:37:07''updatedby=''1', 'I', 1, '2010-08-05 09:37:10', 457, 'S', 'admin', 1837, '::1', 'leaveadjustmentline_id', '4'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''4''employee_id=''19''leavetype_id=''16''leaveadjustmentline_totalday=''2''created=''2010-08-05 09:37:07''createdby=''1''updated=''2010-08-05 09:37:07''updatedby=''1', 'I', 1, '2010-08-05 09:37:10', 458, 'S', 'admin', 1838, '::1', 'leaveadjustmentline_id', '4'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''4''employee_id=''19''leavetype_id=''9''leaveadjustmentline_totalday=''2''created=''2010-08-05 09:37:07''createdby=''1''updated=''2010-08-05 09:37:07''updatedby=''1', 'I', 1, '2010-08-05 09:37:10', 459, 'S', 'admin', 1839, '::1', 'leaveadjustmentline_id', '4'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''4''employee_id=''33''leavetype_id=''8''leaveadjustmentline_totalday=''2''created=''2010-08-05 09:37:07''createdby=''1''updated=''2010-08-05 09:37:07''updatedby=''1', 'I', 1, '2010-08-05 09:37:10', 460, 'S', 'admin', 1840, '::1', 'leaveadjustmentline_id', '4'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''4''employee_id=''33''leavetype_id=''10''leaveadjustmentline_totalday=''2''created=''2010-08-05 09:37:07''createdby=''1''updated=''2010-08-05 09:37:07''updatedby=''1', 'I', 1, '2010-08-05 09:37:10', 461, 'S', 'admin', 1841, '::1', 'leaveadjustmentline_id', '4'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''4''employee_id=''33''leavetype_id=''16''leaveadjustmentline_totalday=''2''created=''2010-08-05 09:37:07''createdby=''1''updated=''2010-08-05 09:37:07''updatedby=''1', 'I', 1, '2010-08-05 09:37:10', 462, 'S', 'admin', 1842, '::1', 'leaveadjustmentline_id', '4'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''4''employee_id=''33''leavetype_id=''9''leaveadjustmentline_totalday=''2''created=''2010-08-05 09:37:07''createdby=''1''updated=''2010-08-05 09:37:07''updatedby=''1', 'I', 1, '2010-08-05 09:37:10', 463, 'S', 'admin', 1843, '::1', 'leaveadjustmentline_id', '4'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''4''employee_id=''38''leavetype_id=''8''leaveadjustmentline_totalday=''2''created=''2010-08-05 09:37:07''createdby=''1''updated=''2010-08-05 09:37:07''updatedby=''1', 'I', 1, '2010-08-05 09:37:10', 464, 'S', 'admin', 1844, '::1', 'leaveadjustmentline_id', '4'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''4''employee_id=''38''leavetype_id=''10''leaveadjustmentline_totalday=''2''created=''2010-08-05 09:37:07''createdby=''1''updated=''2010-08-05 09:37:07''updatedby=''1', 'I', 1, '2010-08-05 09:37:10', 465, 'S', 'admin', 1845, '::1', 'leaveadjustmentline_id', '4'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''4''employee_id=''38''leavetype_id=''16''leaveadjustmentline_totalday=''2''created=''2010-08-05 09:37:07''createdby=''1''updated=''2010-08-05 09:37:07''updatedby=''1', 'I', 1, '2010-08-05 09:37:10', 466, 'S', 'admin', 1846, '::1', 'leaveadjustmentline_id', '4'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''4''employee_id=''38''leavetype_id=''9''leaveadjustmentline_totalday=''2''created=''2010-08-05 09:37:07''createdby=''1''updated=''2010-08-05 09:37:07''updatedby=''1', 'I', 1, '2010-08-05 09:37:10', 467, 'S', 'admin', 1847, '::1', 'leaveadjustmentline_id', '4'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''4''employee_id=''24''leavetype_id=''8''leaveadjustmentline_totalday=''2''created=''2010-08-05 09:37:07''createdby=''1''updated=''2010-08-05 09:37:07''updatedby=''1', 'I', 1, '2010-08-05 09:37:10', 468, 'S', 'admin', 1848, '::1', 'leaveadjustmentline_id', '4'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''4''employee_id=''24''leavetype_id=''10''leaveadjustmentline_totalday=''2''created=''2010-08-05 09:37:07''createdby=''1''updated=''2010-08-05 09:37:07''updatedby=''1', 'I', 1, '2010-08-05 09:37:10', 469, 'S', 'admin', 1849, '::1', 'leaveadjustmentline_id', '4'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''4''employee_id=''24''leavetype_id=''16''leaveadjustmentline_totalday=''2''created=''2010-08-05 09:37:07''createdby=''1''updated=''2010-08-05 09:37:07''updatedby=''1', 'I', 1, '2010-08-05 09:37:11', 470, 'S', 'admin', 1850, '::1', 'leaveadjustmentline_id', '4'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''4''employee_id=''24''leavetype_id=''9''leaveadjustmentline_totalday=''2''created=''2010-08-05 09:37:07''createdby=''1''updated=''2010-08-05 09:37:07''updatedby=''1', 'I', 1, '2010-08-05 09:37:11', 471, 'S', 'admin', 1851, '::1', 'leaveadjustmentline_id', '4');
INSERT INTO `sim_audit` (`tablename`, `changedesc`, `category`, `uid`, `updated`, `record_id`, `eventype`, `uname`, `audit_id`, `ip`, `primarykey`, `controlvalue`) VALUES
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''4''employee_id=''30''leavetype_id=''8''leaveadjustmentline_totalday=''2''created=''2010-08-05 09:37:07''createdby=''1''updated=''2010-08-05 09:37:07''updatedby=''1', 'I', 1, '2010-08-05 09:37:11', 472, 'S', 'admin', 1852, '::1', 'leaveadjustmentline_id', '4'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''4''employee_id=''30''leavetype_id=''10''leaveadjustmentline_totalday=''2''created=''2010-08-05 09:37:07''createdby=''1''updated=''2010-08-05 09:37:07''updatedby=''1', 'I', 1, '2010-08-05 09:37:11', 473, 'S', 'admin', 1853, '::1', 'leaveadjustmentline_id', '4'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''4''employee_id=''30''leavetype_id=''16''leaveadjustmentline_totalday=''2''created=''2010-08-05 09:37:07''createdby=''1''updated=''2010-08-05 09:37:07''updatedby=''1', 'I', 1, '2010-08-05 09:37:11', 474, 'S', 'admin', 1854, '::1', 'leaveadjustmentline_id', '4'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''4''employee_id=''30''leavetype_id=''9''leaveadjustmentline_totalday=''2''created=''2010-08-05 09:37:07''createdby=''1''updated=''2010-08-05 09:37:07''updatedby=''1', 'I', 1, '2010-08-05 09:37:11', 475, 'S', 'admin', 1855, '::1', 'leaveadjustmentline_id', '4'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''4''employee_id=''15''leavetype_id=''8''leaveadjustmentline_totalday=''2''created=''2010-08-05 09:37:07''createdby=''1''updated=''2010-08-05 09:37:07''updatedby=''1', 'I', 1, '2010-08-05 09:37:11', 476, 'S', 'admin', 1856, '::1', 'leaveadjustmentline_id', '4'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''4''employee_id=''15''leavetype_id=''10''leaveadjustmentline_totalday=''2''created=''2010-08-05 09:37:07''createdby=''1''updated=''2010-08-05 09:37:07''updatedby=''1', 'I', 1, '2010-08-05 09:37:11', 477, 'S', 'admin', 1857, '::1', 'leaveadjustmentline_id', '4'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''4''employee_id=''15''leavetype_id=''16''leaveadjustmentline_totalday=''2''created=''2010-08-05 09:37:07''createdby=''1''updated=''2010-08-05 09:37:07''updatedby=''1', 'I', 1, '2010-08-05 09:37:11', 478, 'S', 'admin', 1858, '::1', 'leaveadjustmentline_id', '4'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''4''employee_id=''15''leavetype_id=''9''leaveadjustmentline_totalday=''2''created=''2010-08-05 09:37:07''createdby=''1''updated=''2010-08-05 09:37:07''updatedby=''1', 'I', 1, '2010-08-05 09:37:11', 479, 'S', 'admin', 1859, '::1', 'leaveadjustmentline_id', '4'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''4''employee_id=''20''leavetype_id=''8''leaveadjustmentline_totalday=''2''created=''2010-08-05 09:37:07''createdby=''1''updated=''2010-08-05 09:37:07''updatedby=''1', 'I', 1, '2010-08-05 09:37:11', 480, 'S', 'admin', 1860, '::1', 'leaveadjustmentline_id', '4'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''4''employee_id=''20''leavetype_id=''10''leaveadjustmentline_totalday=''2''created=''2010-08-05 09:37:07''createdby=''1''updated=''2010-08-05 09:37:07''updatedby=''1', 'I', 1, '2010-08-05 09:37:11', 481, 'S', 'admin', 1861, '::1', 'leaveadjustmentline_id', '4'),
('sim_hr_leaveadjustmentline', 'leaveadjustment_id=''4''employee_id=''20''leavetype_id=''16''leaveadjustmentline_totalday=''2''created=''2010-08-05 09:37:07''createdby=''1''updated=''2010-08-05 09:37:07''updatedby=''1', 'I', 1, '2010-08-05 09:37:11', 482, 'S', 'admin', 1862, '::1', 'leaveadjustmentline_id', '4'),
('sim_hr_leaveadjustment', 'issubmit=''1''', 'U', 1, '2010-08-05 09:37:19', 4, 'S', 'admin', 1863, '::1', 'leaveadjustment_id', '4'),
('sim_workflowtransaction', 'workflowtransaction_datetime=''10/08/05 09:37:19''target_groupid=''1''target_uid=''0''targetparameter_name=''10''workflowstatus_id=''1''workflow_id=''8''tablename=''sim_hr_leaveadjustment''primarykey_name=''leaveadjustment_id''primarykey_value=''4''hyperlink=''../hr/leaveadjustment.php''title_description=''''created=''10/08/05 09:37:19''list_parameter=''''workflowtransaction_description=''''workflowtransaction_feedback=''''iscomplete=''0''createdby=''1''email_list=''10''sms_list=''10''email_body=''''sms_body=''''person_id=''14''issubmit=''1', 'I', 1, '2010-08-05 09:37:19', 10, 'S', 'admin', 1864, '::1', 'workflowtransaction_id', 'sim_hr_leaveadjustment'),
('sim_workflowtransactionhistory', 'workflowtransaction_id=''10''workflowstatus_id=''1''workflowtransaction_datetime=''10/08/05 09:37:19''uid=''1''workflowtransactionhistory_description=''', 'I', 1, '2010-08-05 09:37:19', 0, 'S', 'admin', 1865, '::1', 'workflowtransactionhistory_id', ''),
('sim_hr_employee', 'uid=''1868'',<br/>seqno='''',<br/>organization_id=''''', 'U', 1, '2010-08-05 10:14:07', 19, 'S', 'admin', 1866, '::1', 'employee_id', 'K001'),
('sim_hr_employee', 'employee_hpno=''0167065064''', 'U', 1, '2010-08-05 11:52:43', 14, 'S', 'admin', 1867, '::1', 'employee_id', ''),
('sim_hr_employee', 'employee_hpno=''0197108680''', 'U', 1, '2010-08-05 11:53:52', 15, 'S', 'admin', 1868, '::1', 'employee_id', ''),
('sim_hr_employee', 'employee_hpno=''0197108680'',<br/>permanent_postcode=''1231'',<br/>contact_postcode=''123''', 'U', 1, '2010-08-05 11:54:45', 17, 'S', 'admin', 1869, '::1', 'employee_id', ''),
('sim_hr_generalclaim', 'employee_id=''Ali Bin Ahmad(14)''generalclaim_date=''2010-08-23''generalclaim_docno=''''generalclaim_remark=''''period_id=''wer(10)''created=''10/08/05 12:16:13''createdby=''admin(1)''updated=''10/08/05 12:16:13''updatedby=''admin(1)''organization_id=''1', 'I', 1, '2010-08-05 12:16:13', 1, 'S', 'admin', 1870, '::1', 'generalclaim_id', ''),
('sim_workflownode', 'target_uid='''',<br/>workflow_description=''Total Amount : {total_amount}\nPeriod : {period}''', 'U', 0, '2010-08-05 12:27:05', 9, 'S', '', 1871, '::1', 'workflownode_id', '1'),
('sim_workflownode', 'target_uid='''',<br/>workflow_description=''Clinic Name : {clinic_name}\nTreatment for : {treatment}\nTotal Amount : {total_amount}\nPeriod : {period}''', 'U', 0, '2010-08-05 12:30:01', 25, 'S', '', 1872, '::1', 'workflownode_id', '10'),
('sim_hr_overtimeclaim', 'employee_id=''A1(35)''overtimeclaim_date=''2010-08-10''overtimeclaim_docno=''''overtimeclaim_remark=''''created=''10/08/05 12:30:45''createdby=''admin(1)''updated=''10/08/05 12:30:45''updatedby=''admin(1)''organization_id=''1', 'I', 1, '2010-08-05 12:30:45', 1, 'S', 'admin', 1873, '::1', 'overtimeclaim_id', ''),
('sim_workflownode', 'target_uid='''',<br/>workflow_description=''Total Hours : {total_hour}''', 'U', 0, '2010-08-05 12:32:33', 27, 'S', '', 1874, '::1', 'workflownode_id', '10'),
('sim_workflownode', 'target_uid='''',<br/>workflow_description=''Total Amount : {total_amount}\nMode of Transportation : {transportation}\nPeriod : {period}''', 'U', 0, '2010-08-05 12:33:53', 30, 'S', '', 1875, '::1', 'workflownode_id', '10'),
('sim_window', 'mid=''69''windowsetting=''''seqno=''10''description=''''parentwindows_id=''''filename=''''isactive=''1''window_name=''Master Data''created=''2010-08-05 14:07:20''createdby=''1''updated=''2010-08-05 14:07:20''updatedby=''1''table_name=''', 'I', 0, '2010-08-05 14:07:20', 51, 'S', '', 1876, '::1', 'window_id', 'Master Data'),
('sim_window', 'mid=''69''windowsetting=''''seqno=''10''description=''''parentwindows_id=''51''filename=''accounts.php''isactive=''1''window_name=''Chart Of Accounts''created=''2010-08-05 14:08:02''createdby=''1''updated=''2010-08-05 14:08:02''updatedby=''1''table_name=''', 'I', 0, '2010-08-05 14:08:02', 52, 'S', '', 1877, '::1', 'window_id', 'Chart Of Accounts');

-- --------------------------------------------------------

--
-- Table structure for table `sim_avatar`
--

DROP TABLE IF EXISTS `sim_avatar`;
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

DROP TABLE IF EXISTS `sim_avatar_user_link`;
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

DROP TABLE IF EXISTS `sim_banner`;
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
(1, 1, 0, 153948, 0, 'http://localhost/simtrain/images/banners/xoops_banner.gif', 'http://www.xoops.org/', 1008813250, 0, ''),
(2, 1, 0, 154478, 0, 'http://localhost/simtrain/images/banners/xoops_banner_2.gif', 'http://www.xoops.org/', 1008813250, 0, ''),
(3, 1, 0, 153295, 0, 'http://localhost/simtrain/images/banners/banner.swf', 'http://www.xoops.org/', 1008813250, 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `sim_bannerclient`
--

DROP TABLE IF EXISTS `sim_bannerclient`;
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

DROP TABLE IF EXISTS `sim_bannerfinish`;
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

DROP TABLE IF EXISTS `sim_block_module_link`;
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

DROP TABLE IF EXISTS `sim_bpartner`;
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `sim_bpartner`
--

INSERT INTO `sim_bpartner` (`bpartner_id`, `bpartnergroup_id`, `bpartner_no`, `bpartner_name`, `isactive`, `seqno`, `created`, `createdby`, `updated`, `updatedby`, `currency_id`, `terms_id`, `salescreditlimit`, `organization_id`, `bpartner_url`, `debtoraccounts_id`, `description`, `tax_id`, `currentbalance`, `creditoraccounts_id`, `isdebtor`, `iscreditor`, `istransporter`, `purchasecreditlimit`, `enforcesalescreditlimit`, `enforcepurchasecreditlimit`, `currentsalescreditstatus`, `currentpurchasecreditstatus`, `bankaccountname`, `bankname`, `bankaccountno`, `isdealer`, `isprospect`, `employeecount`, `alternatename`, `companyno`, `industry_id`, `tooltips`, `salespricelist_id`, `purchasepricelist_id`, `employee_id`, `isdeleted`) VALUES
(1, 1, 'M001', 'Clinic Ali', 1, 10, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, 0, 0, '0.00', 0, '', 0, '', 0, '0.00', 0, 0, 0, 0, '0.00', 0, 0, '0.00', '0.00', '', '', '', 0, 0, 0, '', '', 1, '', 0, 0, 0, 0),
(2, 1, '', 'Clinic MM', 1, 10, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, 0, 0, '0.00', 0, '', 0, '', 0, '0.00', 0, 0, 0, 0, '0.00', 0, 0, '0.00', '0.00', '', '', '', 0, 0, 0, '', '', 1, '', 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `sim_bpartnergroup`
--

DROP TABLE IF EXISTS `sim_bpartnergroup`;
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `sim_bpartnergroup`
--

INSERT INTO `sim_bpartnergroup` (`bpartnergroup_id`, `bpartnergroup_name`, `isactive`, `seqno`, `created`, `createdby`, `updated`, `updatedby`, `organization_id`, `description`, `debtoraccounts_id`, `creditoraccounts_id`, `isdeleted`) VALUES
(2, 'WW', 1, 10, '2010-08-04 11:57:23', 1, '2010-08-04 11:57:23', 1, 1, 'EE', 0, 0, 0),
(3, 'asd', 1, 10, '2010-08-04 11:59:34', 1, '2010-08-04 11:59:34', 1, 1, 'asd', 0, 0, 0),
(5, '11', 1, 10, '2010-08-04 12:07:59', 1, '0000-00-00 00:00:00', 2010, 1, '221', 0, 0, 0),
(6, 'q', 1, 10, '2010-08-04 12:09:32', 1, '0000-00-00 00:00:00', 2010, 1, '', 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `sim_cache_model`
--

DROP TABLE IF EXISTS `sim_cache_model`;
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

DROP TABLE IF EXISTS `sim_config`;
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
(1, 0, 1, 'sitename', '_MD_AM_SITENAME', 'SimEDU', '_MD_AM_SITENAMEDSC', 'textbox', 'text', 0),
(2, 0, 1, 'slogan', '_MD_AM_SLOGAN', 'Because Of You, We Are Here', '_MD_AM_SLOGANDSC', 'textbox', 'text', 2),
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
(30, 0, 1, 'adminmail', '_MD_AM_ADMINML', 'marhan@simit.com.my', '_MD_AM_ADMINMLDSC', 'textbox', 'text', 3),
(31, 0, 2, 'self_delete', '_MD_AM_SELFDELETE', '0', '_MD_AM_SELFDELETEDSC', 'yesno', 'int', 22),
(32, 0, 1, 'com_mode', '_MD_AM_COMMODE', 'nest', '_MD_AM_COMMODEDSC', 'select', 'text', 34),
(33, 0, 1, 'com_order', '_MD_AM_COMORDER', '0', '_MD_AM_COMORDERDSC', 'select', 'int', 36),
(34, 0, 2, 'bad_unames', '_MD_AM_BADUNAMES', 'a:3:{i:0;s:9:"webmaster";i:1;s:6:"^xoops";i:2;s:6:"^admin";}', '_MD_AM_BADUNAMESDSC', 'textarea', 'array', 24),
(35, 0, 2, 'bad_emails', '_MD_AM_BADEMAILS', 'a:1:{i:0;s:10:"xoops.org$";}', '_MD_AM_BADEMAILSDSC', 'textarea', 'array', 26),
(36, 0, 2, 'maxuname', '_MD_AM_MAXUNAME', '10', '_MD_AM_MAXUNAMEDSC', 'textbox', 'int', 3),
(37, 0, 1, 'bad_ips', '_MD_AM_BADIPS', 'a:1:{i:0;s:9:"127.0.0.1";}', '_MD_AM_BADIPSDSC', 'textarea', 'array', 42),
(38, 0, 3, 'meta_keywords', '_MD_AM_METAKEY', '', '_MD_AM_METAKEYDSC', 'textarea', 'text', 0),
(39, 0, 3, 'footer', '_MD_AM_FOOTER', 'Powered by SIMIT @ 2001-2010 <a href="http://www.simit.edu.my/" target="_blank">The SIMEDU Project</a>', '_MD_AM_FOOTERDSC', 'textarea', 'text', 20),
(40, 0, 4, 'censor_enable', '_MD_AM_DOCENSOR', '0', '_MD_AM_DOCENSORDSC', 'yesno', 'int', 0),
(41, 0, 4, 'censor_words', '_MD_AM_CENSORWRD', 'a:2:{i:0;s:4:"fuck";i:1;s:4:"shit";}', '_MD_AM_CENSORWRDDSC', 'textarea', 'array', 1),
(42, 0, 4, 'censor_replace', '_MD_AM_CENSORRPLC', '#OOPS#', '_MD_AM_CENSORRPLCDSC', 'textbox', 'text', 2),
(43, 0, 3, 'meta_robots', '_MD_AM_METAROBOTS', 'index,follow', '_MD_AM_METAROBOTSDSC', 'select', 'text', 2),
(44, 0, 5, 'enable_search', '_MD_AM_DOSEARCH', '1', '_MD_AM_DOSEARCHDSC', 'yesno', 'int', 0),
(45, 0, 5, 'keyword_min', '_MD_AM_MINSEARCH', '5', '_MD_AM_MINSEARCHDSC', 'textbox', 'int', 1),
(46, 0, 2, 'avatar_minposts', '_MD_AM_AVATARMP', '0', '_MD_AM_AVATARMPDSC', 'textbox', 'int', 15),
(47, 0, 1, 'enable_badips', '_MD_AM_DOBADIPS', '0', '_MD_AM_DOBADIPSDSC', 'yesno', 'int', 40),
(48, 0, 3, 'meta_rating', '_MD_AM_METARATING', 'general', '_MD_AM_METARATINGDSC', 'select', 'text', 4),
(49, 0, 3, 'meta_author', '_MD_AM_METAAUTHOR', 'Simit', '_MD_AM_METAAUTHORDSC', 'textbox', 'text', 6),
(50, 0, 3, 'meta_copyright', '_MD_AM_METACOPYR', 'Copyright @ 2001-2010', '_MD_AM_METACOPYRDSC', 'textbox', 'text', 8),
(51, 0, 3, 'meta_description', '_MD_AM_METADESC', 'SimEDU Project', '_MD_AM_METADESCDSC', 'textarea', 'text', 1),
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
(62, 0, 1, 'module_cache', '_MD_AM_MODCACHE', 'a:12:{i:2;s:1:"0";i:3;s:1:"0";i:5;s:1:"0";i:22;s:1:"0";i:23;s:1:"0";i:24;s:1:"0";i:25;s:1:"0";i:27;s:1:"0";i:29;s:1:"0";i:30;s:1:"0";i:32;s:1:"0";i:38;s:1:"0";}', '_MD_AM_MODCACHEDSC', 'module_cache', 'array', 50),
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

DROP TABLE IF EXISTS `sim_configcategory`;
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

DROP TABLE IF EXISTS `sim_configoption`;
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
-- Table structure for table `sim_country`
--

DROP TABLE IF EXISTS `sim_country`;
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
  PRIMARY KEY (`country_id`),
  UNIQUE KEY `country_code` (`country_code`),
  UNIQUE KEY `country_name` (`country_name`),
  UNIQUE KEY `citizenship` (`citizenship`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `sim_country`
--

INSERT INTO `sim_country` (`country_id`, `country_code`, `country_name`, `citizenship`, `isactive`, `seqno`, `created`, `createdby`, `updated`, `updatedby`, `isdeleted`) VALUES
(0, '--', '', '', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, 0),
(2, 'SG', 'Singapore', 'Singaporian', 1, 20, '2010-07-25 15:19:14', 1, '2010-07-25 15:19:14', 1, 0),
(3, 'MY', 'Malaysia', 'Malaysian', 1, 10, '2010-07-25 15:19:14', 1, '2010-08-04 10:49:29', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `sim_currency`
--

DROP TABLE IF EXISTS `sim_currency`;
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `sim_currency`
--

INSERT INTO `sim_currency` (`currency_id`, `currency_code`, `currency_name`, `seqno`, `isactive`, `created`, `createdby`, `updated`, `updatedby`, `country_id`, `isdeleted`) VALUES
(0, '--', '', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, 0, 0),
(2, 'SGD', 'Singpore Dollar', 20, 1, '2010-07-25 15:19:45', 1, '2010-07-25 15:19:45', 1, 2, 0),
(3, 'MYR', 'Malaysia Ringgit', 10, 1, '2010-07-25 15:19:45', 1, '2010-07-25 15:19:45', 1, 3, 0),
(4, 'WE', 'FD', 0, 1, '2010-08-03 11:05:44', 1, '2010-08-03 11:05:52', 1, 2, 0);

-- --------------------------------------------------------

--
-- Table structure for table `sim_groups`
--

DROP TABLE IF EXISTS `sim_groups`;
CREATE TABLE IF NOT EXISTS `sim_groups` (
  `groupid` smallint(5) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '',
  `description` text,
  `group_type` varchar(10) NOT NULL DEFAULT '',
  PRIMARY KEY (`groupid`),
  KEY `group_type` (`group_type`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `sim_groups`
--

INSERT INTO `sim_groups` (`groupid`, `name`, `description`, `group_type`) VALUES
(1, 'Webmasters', 'Webmasters of this site', 'Admin'),
(2, 'Registered Users', 'Registered Users Group', 'User'),
(3, 'Anonymous Users', 'Anonymous Users Group', 'Anonymous');

-- --------------------------------------------------------

--
-- Table structure for table `sim_groups_users_link`
--

DROP TABLE IF EXISTS `sim_groups_users_link`;
CREATE TABLE IF NOT EXISTS `sim_groups_users_link` (
  `linkid` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `groupid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `uid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`linkid`),
  KEY `groupid_uid` (`groupid`,`uid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4140 ;

--
-- Dumping data for table `sim_groups_users_link`
--

INSERT INTO `sim_groups_users_link` (`linkid`, `groupid`, `uid`) VALUES
(4134, 1, 1),
(3835, 1, 534),
(4135, 2, 1),
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
(4138, 2, 1868),
(4139, 2, 1869);

-- --------------------------------------------------------

--
-- Table structure for table `sim_group_permission`
--

DROP TABLE IF EXISTS `sim_group_permission`;
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1738 ;

--
-- Dumping data for table `sim_group_permission`
--

INSERT INTO `sim_group_permission` (`gperm_id`, `gperm_groupid`, `gperm_itemid`, `gperm_modid`, `gperm_name`) VALUES
(1703, 2, 46, 1, 'block_read'),
(1532, 1, 1, 1, 'module_read'),
(1705, 3, 46, 1, 'block_read'),
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
(1704, 3, 61, 1, 'module_read'),
(1507, 1, 4, 1, 'module_admin'),
(1506, 1, 3, 1, 'module_admin'),
(1505, 1, 2, 1, 'module_admin'),
(1504, 1, 2, 1, 'system_admin'),
(1503, 1, 11, 1, 'system_admin'),
(1502, 1, 15, 1, 'system_admin'),
(1550, 3, 1, 1, 'module_read'),
(1501, 1, 12, 1, 'system_admin'),
(1500, 1, 3, 1, 'system_admin'),
(1499, 1, 4, 1, 'system_admin'),
(1498, 1, 8, 1, 'system_admin'),
(1497, 1, 9, 1, 'system_admin'),
(1496, 1, 1, 1, 'system_admin'),
(1495, 1, 7, 1, 'system_admin'),
(1702, 2, 61, 1, 'module_read'),
(1539, 3, 3, 1, 'module_read'),
(1538, 3, 2, 1, 'module_read'),
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
(1734, 1, 69, 1, 'module_admin'),
(1733, 3, 68, 1, 'module_read'),
(1722, 1, 66, 1, 'module_admin'),
(1723, 1, 66, 1, 'module_read'),
(1724, 2, 66, 1, 'module_read'),
(1725, 3, 66, 1, 'module_read'),
(1735, 1, 69, 1, 'module_read'),
(1736, 2, 69, 1, 'module_read'),
(1737, 3, 69, 1, 'module_read');

-- --------------------------------------------------------

--
-- Table structure for table `sim_image`
--

DROP TABLE IF EXISTS `sim_image`;
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

DROP TABLE IF EXISTS `sim_imagebody`;
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

DROP TABLE IF EXISTS `sim_imagecategory`;
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

DROP TABLE IF EXISTS `sim_imgset`;
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

DROP TABLE IF EXISTS `sim_imgsetimg`;
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

DROP TABLE IF EXISTS `sim_imgset_tplset_link`;
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

DROP TABLE IF EXISTS `sim_industry`;
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
  UNIQUE KEY `industry_name` (`industry_name`),
  KEY `organization_id` (`organization_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `sim_industry`
--

INSERT INTO `sim_industry` (`industry_id`, `industry_name`, `description`, `created`, `createdby`, `updated`, `updatedby`, `isactive`, `seqno`, `organization_id`, `isdeleted`) VALUES
(1, 'Medical', 'dasda', '2010-07-29 12:52:14', 1, '0000-00-00 00:00:00', 2010, 1, 10, 1, 0),
(2, 'rfer', '', '2010-07-29 12:55:39', 1, '2010-07-29 12:55:39', 1, 0, 10, 1, 1),
(3, 'asd', '2', '2010-08-04 12:04:23', 1, '0000-00-00 00:00:00', 2010, 0, 10, 1, 1),
(4, '222', '22', '2010-08-04 12:04:33', 1, '0000-00-00 00:00:00', 2010, 0, 10, 1, 1),
(5, '11', '11', '2010-08-04 12:04:33', 1, '0000-00-00 00:00:00', 2010, 0, 10, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `sim_loginevent`
--

DROP TABLE IF EXISTS `sim_loginevent`;
CREATE TABLE IF NOT EXISTS `sim_loginevent` (
  `event_id` int(11) NOT NULL AUTO_INCREMENT,
  `eventdatetime` datetime NOT NULL,
  `activity` char(1) NOT NULL,
  `uid` int(11) NOT NULL,
  `ip` varchar(20) NOT NULL,
  PRIMARY KEY (`event_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=68 ;

--
-- Dumping data for table `sim_loginevent`
--

INSERT INTO `sim_loginevent` (`event_id`, `eventdatetime`, `activity`, `uid`, `ip`) VALUES
(1, '2010-07-26 11:07:26', 'I', 1, '127.0.0.1'),
(2, '2010-07-26 11:07:26', 'O', 1, '127.0.0.1'),
(3, '2010-07-26 11:07:26', 'I', 1, '127.0.0.1'),
(4, '2010-07-26 01:07:26', 'I', 1, '127.0.0.1'),
(5, '2010-07-26 02:07:26', 'I', 1, '127.0.0.1'),
(6, '2010-07-26 03:07:26', 'I', 1, '127.0.0.1'),
(7, '2010-07-26 03:07:26', 'I', 1, '127.0.0.1'),
(8, '2010-07-26 03:07:26', 'I', 1, '127.0.0.1'),
(9, '2010-07-26 03:07:26', 'I', 1, '127.0.0.1'),
(10, '2010-07-26 03:07:26', 'I', 1, '127.0.0.1'),
(11, '2010-07-26 03:07:26', 'I', 1, '127.0.0.1'),
(12, '2010-07-26 03:07:26', 'I', 1, '127.0.0.1'),
(13, '2010-07-26 04:07:26', 'I', 1, '127.0.0.1'),
(14, '2010-07-26 06:07:26', 'I', 1, '192.168.1.202'),
(15, '2010-07-27 02:07:27', 'I', 1868, '127.0.0.1'),
(16, '2010-07-27 02:07:27', 'I', 1, '192.168.1.202'),
(17, '2010-07-27 04:07:27', 'I', 1, '192.168.1.202'),
(18, '2010-07-28 09:07:28', 'I', 1, '::1'),
(19, '2010-07-28 09:07:28', 'I', 1, '192.168.1.202'),
(20, '2010-07-28 03:07:28', 'I', 1868, '::1'),
(21, '2010-07-28 03:07:28', 'I', 1, '::1'),
(22, '2010-07-28 09:07:28', 'I', 1, '::1'),
(23, '2010-07-29 05:07:29', 'I', 1868, '::1'),
(24, '2010-07-29 06:07:29', 'I', 1, '::1'),
(25, '2010-07-29 11:07:29', 'I', 1, '127.0.0.1'),
(26, '2010-07-29 11:07:29', 'I', 1868, '::1'),
(27, '2010-07-29 11:07:29', 'I', 1868, '::1'),
(28, '2010-07-29 11:07:29', 'I', 1, '::1'),
(29, '2010-07-29 11:07:29', 'I', 1868, '::1'),
(30, '2010-07-29 11:07:29', 'I', 1, '::1'),
(31, '2010-07-29 11:07:29', 'I', 1868, '::1'),
(32, '2010-07-29 11:07:29', 'I', 1, '::1'),
(33, '2010-07-29 11:07:29', 'I', 1869, '::1'),
(34, '2010-07-29 11:07:29', 'I', 1, '::1'),
(35, '2010-07-29 11:07:29', 'I', 1868, '::1'),
(36, '2010-07-29 11:07:29', 'I', 1, '::1'),
(37, '2010-07-29 11:07:29', 'I', 1868, '::1'),
(38, '2010-07-29 11:07:29', 'I', 1, '::1'),
(39, '2010-07-29 11:07:29', 'I', 1868, '::1'),
(40, '2010-07-29 11:07:29', 'I', 1, '::1'),
(41, '2010-07-29 12:07:29', 'I', 1868, '::1'),
(42, '2010-07-29 12:07:29', 'I', 1, '127.0.0.1'),
(43, '2010-07-29 03:07:29', 'I', 1, '127.0.0.1'),
(44, '2010-07-29 06:07:29', 'I', 1868, '::1'),
(45, '2010-07-29 06:07:29', 'I', 1, '::1'),
(46, '2010-07-30 09:07:30', 'I', 1, '::1'),
(47, '2010-07-30 09:07:30', 'I', 1868, '::1'),
(48, '2010-07-30 09:07:30', 'I', 1, '::1'),
(49, '2010-07-30 10:07:30', 'I', 1, '::1'),
(50, '2010-08-01 05:08:01', 'I', 1868, '::1'),
(51, '2010-08-01 05:08:01', 'I', 1, '::1'),
(52, '2010-08-01 05:08:01', 'I', 1868, '::1'),
(53, '2010-08-01 05:08:01', 'I', 1, '127.0.0.1'),
(54, '2010-08-02 10:08:02', 'I', 1, '192.168.1.204'),
(55, '2010-08-02 12:08:02', 'I', 1, '192.168.1.204'),
(56, '2010-08-02 01:08:02', 'I', 1, '192.168.1.203'),
(57, '2010-08-02 05:08:02', 'I', 1, '192.168.1.201'),
(58, '2010-08-02 07:08:02', 'I', 1, '127.0.0.1'),
(59, '2010-08-03 08:08:03', 'I', 1, '::1'),
(60, '2010-08-03 08:08:03', 'I', 1868, '::1'),
(61, '2010-08-03 08:08:03', 'I', 1, '::1'),
(62, '2010-08-04 06:08:04', 'I', 1, '::1'),
(63, '2010-08-04 10:08:04', 'I', 1, '::1'),
(64, '2010-08-04 01:08:04', 'I', 1, '127.0.0.1'),
(65, '2010-08-04 08:08:04', 'I', 1, '192.168.1.202'),
(66, '2010-08-05 09:08:05', 'I', 1, '::1'),
(67, '2010-08-05 10:08:05', 'I', 1, '192.168.1.202');

-- --------------------------------------------------------

--
-- Table structure for table `sim_maritalstatus`
--

DROP TABLE IF EXISTS `sim_maritalstatus`;
CREATE TABLE IF NOT EXISTS `sim_maritalstatus` (
  `maritalstatus_id` int(11) NOT NULL AUTO_INCREMENT,
  `maritalstatus_name` varchar(40) NOT NULL,
  `isactive` smallint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`maritalstatus_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `sim_maritalstatus`
--

INSERT INTO `sim_maritalstatus` (`maritalstatus_id`, `maritalstatus_name`, `isactive`) VALUES
(0, '', 0),
(1, 'Single', 1),
(2, 'Married', 1),
(3, 'Divorced', 1),
(4, 'Widowed', 1);

-- --------------------------------------------------------

--
-- Table structure for table `sim_modules`
--

DROP TABLE IF EXISTS `sim_modules`;
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=70 ;

--
-- Dumping data for table `sim_modules`
--

INSERT INTO `sim_modules` (`mid`, `name`, `version`, `last_update`, `weight`, `isactive`, `dirname`, `hasmain`, `hasadmin`, `hassearch`, `hasconfig`, `hascomments`, `hasnotification`) VALUES
(1, 'System', 200, 1268966326, 0, 1, 'system', 0, 1, 0, 0, 0, 0),
(2, 'Private Messaging', 103, 1268966480, 1, 1, 'pm', 1, 1, 0, 1, 0, 0),
(3, 'User Profile', 157, 1268966480, 1, 1, 'profile', 1, 1, 0, 1, 0, 0),
(4, 'Protector', 340, 1268966480, 1, 1, 'protector', 0, 1, 0, 1, 0, 0),
(61, 'Simantz', 90, 1280070992, 1, 1, 'simantz', 1, 1, 0, 0, 0, 0),
(68, 'Approval Module', 90, 1280987862, 1, 1, 'approval', 1, 1, 0, 0, 0, 0),
(66, 'Bpartner Module', 90, 1280314920, 1, 1, 'bpartner', 1, 1, 0, 0, 0, 0),
(69, 'SimBiz Accounting System', 90, 1280988142, 1, 1, 'simbiz', 1, 1, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `sim_newblocks`
--

DROP TABLE IF EXISTS `sim_newblocks`;
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

DROP TABLE IF EXISTS `sim_online`;
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

DROP TABLE IF EXISTS `sim_organization`;
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
(1, 'SIMIT', 'SIM IT SDN BHD', '792899-U', '01-39, Jalan Mutiara Emas 9/3', 'Taman Mount Austin', '', 'Johor Bahru', 'Johor', 3, '0197725330', '', '075571757', 'http://www.simit.com.my', 'sales@simit.com.my', 10, 1, 1, '2009-01-06 22:58:05', 1, '2010-07-25 15:20:01', 3, 2, '81100', 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `sim_period`
--

DROP TABLE IF EXISTS `sim_period`;
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
(1, '2010-02', 1, 0, 2010, 2, '2010-07-29 14:36:33', 1, '2010-07-29 14:36:33', 1, 0),
(2, '2010-01', 1, 0, 2010, 1, '2010-07-29 14:36:33', 1, '2010-07-29 14:36:33', 1, 0),
(3, '2010-03', 1, 0, 2010, 3, '2010-07-30 03:01:00', 1, '2010-07-30 03:01:00', 1, 0),
(4, '2010-06', 1, 0, 2010, 6, '2010-07-30 03:01:00', 1, '2010-07-30 03:01:00', 1, 0),
(5, '2010-07', 1, 0, 2010, 7, '2010-07-30 03:01:00', 1, '2010-07-30 03:01:00', 1, 0),
(6, '2010-08', 1, 0, 2010, 8, '2010-07-30 03:01:00', 1, '2010-07-30 03:01:00', 1, 0),
(7, '2010-09', 1, 0, 2010, 9, '2010-07-30 03:01:00', 1, '2010-07-30 03:01:00', 1, 0),
(8, '2010-10', 1, 0, 2010, 10, '2010-07-30 03:01:00', 1, '2010-07-30 03:01:00', 1, 0),
(9, '2010-12', 1, 0, 2010, 12, '2010-07-30 03:01:00', 1, '2010-07-30 03:01:00', 1, 0),
(10, '2010-11', 1, 0, 2010, 11, '2010-07-30 03:01:00', 1, '2010-07-30 03:01:00', 1, 0),
(11, '2010-04', 1, 0, 2010, 4, '2010-07-30 03:01:00', 1, '2010-07-30 03:01:00', 1, 0),
(12, '2010-05', 1, 0, 2010, 5, '2010-07-30 03:01:00', 1, '2010-07-30 03:01:00', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `sim_permission`
--

DROP TABLE IF EXISTS `sim_permission`;
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=431 ;

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
(38, 32, '2010-07-26 18:16:39', 1, '2010-07-26 18:16:39', 1, 1, '', '0000-00-00', 0, 1),
(132, 37, '2010-07-29 12:48:47', 1, '2010-07-29 12:48:47', 1, 1, '', '0000-00-00', 0, 1),
(133, 34, '2010-07-29 12:48:47', 1, '2010-07-29 12:48:47', 1, 1, '', '0000-00-00', 0, 1),
(134, 35, '2010-07-29 12:48:47', 1, '2010-07-29 12:48:47', 1, 1, '', '0000-00-00', 0, 1),
(135, 36, '2010-07-29 12:48:47', 1, '2010-07-29 12:48:47', 1, 1, '', '0000-00-00', 0, 1),
(310, 15, '2010-08-01 17:24:23', 1, '2010-08-01 17:24:23', 1, 2, '', '0000-00-00', 0, 0),
(311, 18, '2010-08-01 17:24:23', 1, '2010-08-01 17:24:23', 1, 2, '', '0000-00-00', 0, 0),
(312, 19, '2010-08-01 17:24:23', 1, '2010-08-01 17:24:23', 1, 2, '', '0000-00-00', 0, 0),
(313, 20, '2010-08-01 17:24:23', 1, '2010-08-01 17:24:23', 1, 2, '', '0000-00-00', 0, 0),
(314, 21, '2010-08-01 17:24:23', 1, '2010-08-01 17:24:23', 1, 2, '', '0000-00-00', 0, 0),
(315, 22, '2010-08-01 17:24:23', 1, '2010-08-01 17:24:23', 1, 2, '', '0000-00-00', 0, 0),
(316, 23, '2010-08-01 17:24:23', 1, '2010-08-01 17:24:23', 1, 2, '', '0000-00-00', 0, 0),
(317, 24, '2010-08-01 17:24:23', 1, '2010-08-01 17:24:23', 1, 2, '', '0000-00-00', 0, 0),
(318, 16, '2010-08-01 17:24:23', 1, '2010-08-01 17:24:23', 1, 2, '', '0000-00-00', 0, 0),
(319, 25, '2010-08-01 17:24:23', 1, '2010-08-01 17:24:23', 1, 2, '', '0000-00-00', 0, 0),
(320, 26, '2010-08-01 17:24:23', 1, '2010-08-01 17:24:23', 1, 2, '', '0000-00-00', 0, 0),
(321, 27, '2010-08-01 17:24:23', 1, '2010-08-01 17:24:23', 1, 2, '', '0000-00-00', 0, 0),
(322, 28, '2010-08-01 17:24:23', 1, '2010-08-01 17:24:23', 1, 2, '', '0000-00-00', 0, 0),
(323, 29, '2010-08-01 17:24:23', 1, '2010-08-01 17:24:23', 1, 2, '', '0000-00-00', 0, 0),
(324, 30, '2010-08-01 17:24:23', 1, '2010-08-01 17:24:23', 1, 2, '', '0000-00-00', 0, 0),
(325, 31, '2010-08-01 17:24:23', 1, '2010-08-01 17:24:23', 1, 2, '', '0000-00-00', 0, 0),
(326, 17, '2010-08-01 17:24:23', 1, '2010-08-01 17:24:23', 1, 2, '', '0000-00-00', 0, 0),
(327, 33, '2010-08-01 17:24:23', 1, '2010-08-01 17:24:23', 1, 2, '', '0000-00-00', 0, 0),
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
(398, 15, '2010-08-03 17:48:37', 1, '2010-08-03 17:48:37', 1, 1, '', '0000-00-00', 0, 1),
(399, 18, '2010-08-03 17:48:37', 1, '2010-08-03 17:48:37', 1, 1, '', '0000-00-00', 0, 1),
(400, 19, '2010-08-03 17:48:37', 1, '2010-08-03 17:48:37', 1, 1, '', '0000-00-00', 0, 1),
(401, 20, '2010-08-03 17:48:37', 1, '2010-08-03 17:48:37', 1, 1, '', '0000-00-00', 0, 1),
(402, 21, '2010-08-03 17:48:37', 1, '2010-08-03 17:48:37', 1, 1, '', '0000-00-00', 0, 1),
(403, 22, '2010-08-03 17:48:37', 1, '2010-08-03 17:48:37', 1, 1, '', '0000-00-00', 0, 1),
(404, 23, '2010-08-03 17:48:37', 1, '2010-08-03 17:48:37', 1, 1, '', '0000-00-00', 0, 1),
(405, 24, '2010-08-03 17:48:37', 1, '2010-08-03 17:48:37', 1, 1, '', '0000-00-00', 0, 1),
(406, 16, '2010-08-03 17:48:37', 1, '2010-08-03 17:48:37', 1, 1, '', '0000-00-00', 0, 1),
(407, 25, '2010-08-03 17:48:37', 1, '2010-08-03 17:48:37', 1, 1, '', '0000-00-00', 0, 1),
(408, 26, '2010-08-03 17:48:37', 1, '2010-08-03 17:48:37', 1, 1, '', '0000-00-00', 0, 1),
(409, 27, '2010-08-03 17:48:37', 1, '2010-08-03 17:48:37', 1, 1, '', '0000-00-00', 0, 1),
(410, 28, '2010-08-03 17:48:37', 1, '2010-08-03 17:48:37', 1, 1, '', '0000-00-00', 0, 1),
(411, 29, '2010-08-03 17:48:37', 1, '2010-08-03 17:48:37', 1, 1, '', '0000-00-00', 0, 1),
(412, 30, '2010-08-03 17:48:37', 1, '2010-08-03 17:48:37', 1, 1, '', '0000-00-00', 0, 1),
(413, 31, '2010-08-03 17:48:37', 1, '2010-08-03 17:48:37', 1, 1, '', '0000-00-00', 0, 1),
(414, 17, '2010-08-03 17:48:37', 1, '2010-08-03 17:48:37', 1, 1, '', '0000-00-00', 0, 1),
(415, 38, '2010-08-03 17:48:37', 1, '2010-08-03 17:48:37', 1, 1, '', '0000-00-00', 0, 1),
(416, 39, '2010-08-03 17:48:37', 1, '2010-08-03 17:48:37', 1, 1, '', '0000-00-00', 0, 1),
(417, 40, '2010-08-03 17:48:37', 1, '2010-08-03 17:48:37', 1, 1, '', '0000-00-00', 0, 1),
(418, 41, '2010-08-03 17:48:37', 1, '2010-08-03 17:48:37', 1, 1, '', '0000-00-00', 0, 1),
(419, 42, '2010-08-03 17:48:37', 1, '2010-08-03 17:48:37', 1, 1, '', '0000-00-00', 0, 1),
(420, 43, '2010-08-03 17:48:37', 1, '2010-08-03 17:48:37', 1, 1, '', '0000-00-00', 0, 1),
(421, 44, '2010-08-03 17:48:37', 1, '2010-08-03 17:48:37', 1, 1, '', '0000-00-00', 0, 1),
(422, 45, '2010-08-03 17:48:37', 1, '2010-08-03 17:48:37', 1, 1, '', '0000-00-00', 0, 1),
(423, 46, '2010-08-03 17:48:37', 1, '2010-08-03 17:48:37', 1, 1, '', '0000-00-00', 0, 1),
(424, 47, '2010-08-03 17:48:37', 1, '2010-08-03 17:48:37', 1, 1, '', '0000-00-00', 0, 1),
(425, 48, '2010-08-03 17:48:37', 1, '2010-08-03 17:48:37', 1, 1, '', '0000-00-00', 0, 1),
(426, 49, '2010-08-03 17:48:37', 1, '2010-08-03 17:48:37', 1, 1, '', '0000-00-00', 0, 1),
(427, 50, '2010-08-03 17:48:37', 1, '2010-08-03 17:48:37', 1, 1, '', '0000-00-00', 0, 1),
(428, 33, '2010-08-03 17:48:37', 1, '2010-08-03 17:48:37', 1, 1, '', '0000-00-00', 0, 1),
(429, 51, '2010-08-05 14:08:37', 1, '2010-08-05 14:08:37', 1, 1, '', '0000-00-00', 0, 1),
(430, 52, '2010-08-05 14:08:37', 1, '2010-08-05 14:08:37', 1, 1, '', '0000-00-00', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `sim_priv_msgs`
--

DROP TABLE IF EXISTS `sim_priv_msgs`;
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

DROP TABLE IF EXISTS `sim_profile_category`;
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

DROP TABLE IF EXISTS `sim_profile_field`;
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

DROP TABLE IF EXISTS `sim_profile_profile`;
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

DROP TABLE IF EXISTS `sim_profile_regstep`;
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

DROP TABLE IF EXISTS `sim_profile_visibility`;
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

DROP TABLE IF EXISTS `sim_protector_access`;
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
('::1', '/simantz/simantz/trunk/modules/simbiz/', '', 1280989304),
('::1', '/simantz/simantz/trunk/modules/simbiz/chartsalesexpenses_6month.php', '', 1280989305),
('::1', '/simantz/simantz/trunk/modules/simbiz/chartretainearning_6month.php', '', 1280989305),
('::1', '/simantz/simantz/trunk/modules/simbiz/accounts.php', '', 1280989311),
('::1', '/simantz/simantz/trunk/modules/bpartner/', '', 1280989315),
('::1', '/simantz/simantz/trunk/modules/approval/', '', 1280989316),
('::1', '/simantz/simantz/trunk/modules/approval/approvallist.php', '', 1280989316),
('::1', '/simantz/simantz/trunk/modules/approval/approvallist.php?action=searchgrid&GridId=DataboundGridApprovalList&RequestType=GET&TableId=_default&StartRecordIndex=0&start=0&PageSize=10&SortColumn=&SortDirection=Asc&uid=1280989258246&nitobi_cachebust=1280989258', '', 1280989318),
('::1', '/simantz/simantz/trunk/modules/simantz/', '', 1280989319),
('::1', '/simantz/simantz/trunk/modules/approval/', '', 1280989343),
('::1', '/simantz/simantz/trunk/modules/approval/approvallist.php', '', 1280989344),
('::1', '/simantz/simantz/trunk/modules/approval/approvallist.php?action=searchgrid&GridId=DataboundGridApprovalList&RequestType=GET&TableId=_default&StartRecordIndex=0&start=0&PageSize=10&SortColumn=&SortDirection=Asc&uid=1280989285653&nitobi_cachebust=1280989285', '', 1280989345),
('::1', '/simantz/simantz/trunk/modules/bpartner/', '', 1280989346);

-- --------------------------------------------------------

--
-- Table structure for table `sim_protector_log`
--

DROP TABLE IF EXISTS `sim_protector_log`;
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=35 ;

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
(34, 1, '::1', 'CRAWLER', 'Mozilla/5.0 (X11; U; Linux i686; en-US; rv:1.9.2.6) Gecko/20100625 Firefox/3.6.6', '', NULL, '2010-07-30 20:37:25');

-- --------------------------------------------------------

--
-- Table structure for table `sim_races`
--

DROP TABLE IF EXISTS `sim_races`;
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
(0, '--', 1, '2010-07-25 23:16:41', 1, '0000-00-00 00:00:00', 0, '', 1, 0, 0),
(1, 'Chinese', 1, '2010-08-02 15:46:41', 1, '2010-07-27 09:53:56', 1, 'C', 0, 10, 1),
(2, 'Malay', 1, '2010-07-27 09:57:33', 1, '2010-07-27 09:53:56', 1, 'M', 0, 10, 1),
(3, 'Indian', 1, '2010-07-27 09:57:33', 1, '2010-07-27 09:53:56', 1, 'I', 0, 10, 1),
(4, 'Peribumi', 1, '2010-07-27 09:57:33', 1, '2010-07-27 09:53:56', 1, 'P', 0, 10, 1),
(5, 'Others', 1, '2010-08-02 15:47:10', 1, '2010-08-02 15:47:10', 1, 'O', 0, 10, 1);

-- --------------------------------------------------------

--
-- Table structure for table `sim_ranks`
--

DROP TABLE IF EXISTS `sim_ranks`;
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

DROP TABLE IF EXISTS `sim_region`;
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
  KEY `country_id` (`country_id`),
  KEY `organization_id` (`organization_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `sim_region`
--


-- --------------------------------------------------------

--
-- Table structure for table `sim_religion`
--

DROP TABLE IF EXISTS `sim_religion`;
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
(0, '--', '', '2010-07-25 23:16:41', 0, '0000-00-00 00:00:00', 0, '', 0, 0, 1),
(1, 'Buddhist', '1', '2010-07-27 10:05:07', 1, '2010-07-27 10:05:07', 1, 'B', 0, 10, 1),
(2, 'Christian', '1', '2010-07-27 10:05:23', 1, '2010-07-27 10:05:07', 1, 'C', 0, 10, 1),
(3, 'Hindu', '1', '2010-07-27 10:05:23', 1, '2010-07-27 10:05:07', 1, 'H', 0, 10, 1),
(4, 'Muslim', '1', '2010-07-27 10:05:07', 1, '2010-07-27 10:05:07', 1, 'M', 0, 10, 1),
(5, 'sd', '1', '2010-08-03 09:02:36', 1, '2010-08-03 09:02:36', 1, 'DS', 0, 10, 1);

-- --------------------------------------------------------

--
-- Table structure for table `sim_session`
--

DROP TABLE IF EXISTS `sim_session`;
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
('77eda2ac04fd762e4be336c2802bb6a2', 1280989286, '::1', 'xoopsUserId|s:1:"1";xoopsUserGroups|a:2:{i:0;s:1:"1";i:1;s:1:"2";}protector_last_ip|s:3:"::1";XOOPS_TOKEN_SESSION|a:0:{}defaultorganization_id|s:1:"1";');

-- --------------------------------------------------------

--
-- Table structure for table `sim_simbiz_accountclass`
--

DROP TABLE IF EXISTS `sim_simbiz_accountclass`;
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

DROP TABLE IF EXISTS `sim_simbiz_accountgroup`;
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

DROP TABLE IF EXISTS `sim_simbiz_accounts`;
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
(56, '2010-03-28 16:19:23', 1, '2010-03-28 16:20:30', 1, '4', 'Cash Drawer', 1, '0.00', 36, 0, 0, '1960.00', 1, 0, 10, '', 3, 7, '[28][36][56]', '114'),
(57, '2010-03-28 17:57:59', 1, '2010-03-28 17:57:59', 1, '5', 'Student', 1, '0.00', 36, 0, 0, '-100.00', 1, 0, 10, '', 3, 2, '[28][36][57]', '115'),
(58, '2010-08-01 17:41:05', 1, '2010-08-01 17:41:05', 1, '', 'Accrued Expenses', 1, '0.00', 29, 0, 0, '0.00', 1, 0, 10, '', 0, 1, NULL, '22');

-- --------------------------------------------------------

--
-- Table structure for table `sim_simbiz_bankreconcilation`
--

DROP TABLE IF EXISTS `sim_simbiz_bankreconcilation`;
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
(7, '2010-04-30', 50, 1, '2010-08-01 20:36:15', 0, '2010-08-01 13:33:58', 1, 1, '0', '1900.00', '1.00', '0.00', '0000-00-00', '7432.00', 11, '11.00', '1900.00'),
(11, '2010-08-01', 50, 1, '2010-08-01 13:39:39', 0, '2010-08-01 13:41:01', 1, 1, '1', '1896.00', '7432.00', '0.00', '2010-04-30', '1900.00', 6, '-4.00', '0.00');

-- --------------------------------------------------------

--
-- Table structure for table `sim_simbiz_batch`
--

DROP TABLE IF EXISTS `sim_simbiz_batch`;
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
  PRIMARY KEY (`batch_id`),
  KEY `organization_id` (`organization_id`),
  KEY `period_id` (`period_id`),
  KEY `batchdate` (`batchdate`),
  KEY `batchno` (`batchno`),
  KEY `batch_name` (`batch_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=56 ;

--
-- Dumping data for table `sim_simbiz_batch`
--

INSERT INTO `sim_simbiz_batch` (`batch_id`, `organization_id`, `period_id`, `iscomplete`, `batchno`, `batch_name`, `description`, `created`, `createdby`, `updated`, `updatedby`, `reuse`, `totaldebit`, `totalcredit`, `fromsys`, `batchdate`, `isreadonly`) VALUES
(-1, 0, 0, -1, 0, '', '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, 0, '0.00', '0.00', '', '0000-00-00', 0),
(0, 0, 0, -1, 0, '', '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, 0, '0.00', '0.00', '', '0000-00-00', 0),
(16, 1, 11, 1, 1, 'Post from Simbiz Official Receipt RC1', '', '2010-04-13 18:11:05', 1, '2010-08-01 13:33:31', 1, 0, '2000.00', '2000.00', 'Simbiz', '2010-04-13', 0),
(17, 1, 3, 1, 2, 'Post from Simbiz Official Receipt RC2', '', '2010-04-15 11:01:02', 1, '2010-04-15 11:01:02', 1, 0, '1000.00', '1000.00', 'Simbiz', '2010-04-15', 0),
(18, 1, 3, 1, 3, 'Student Invoice Batch (1)', 'STUDENT 3 (1)', '2010-04-15 15:12:13', 1, '2010-04-15 15:12:13', 1, 0, '100.00', '100.00', 'Finance', '2010-04-15', 0),
(19, 1, 11, 1, 4, 'reer er'' \\'' ew'' " w" \\"', 're rer'' " \\'' \\" \\n', '2010-04-15 23:29:06', 1, '2010-08-01 13:33:43', 1, 0, '100.00', '100.00', '', '2010-04-15', 0),
(20, 1, 3, 1, 5, 'student invoice batch', '', '2010-04-15 23:31:43', 1, '2010-04-15 23:31:55', 1, 0, '100.00', '100.00', '', '2010-04-15', 0),
(21, 1, 11, 1, 6, '34', '', '2010-04-22 17:49:08', 1, '2010-08-01 13:40:48', 1, 0, '4.00', '4.00', '', '2010-04-22', 0),
(22, 1, 6, 1, 7, 'dwdffr', '', '2010-08-01 19:39:55', 1, '2010-08-01 19:39:55', 1, 0, '100.00', '100.00', '', '0000-00-00', 0),
(23, 1, 6, 1, 8, 'fef', '', '2010-08-01 19:40:27', 1, '2010-08-01 19:44:04', 1, 0, '3.00', '3.00', '', '2010-08-18', 0),
(24, 1, 6, 1, 9, 'ewe', '', '2010-08-01 19:42:46', 1, '2010-08-01 19:57:51', 1, 0, '400.00', '400.00', '', '2010-08-24', 0),
(25, 1, 6, 1, 10, 'ferf tett', '', '2010-08-01 19:44:49', 1, '2010-08-01 19:44:49', 1, 0, '300.00', '300.00', '', '0000-00-00', 0),
(26, 1, 6, 0, 11, 'dwdw', ' re', '2010-08-01 19:46:06', 1, '2010-08-01 19:47:54', 1, 0, '302.00', '302.00', '', '2010-08-01', 0),
(27, 1, 6, 1, 12, 'erwerwer', 'fwe', '2010-08-01 19:50:33', 1, '2010-08-01 19:58:12', 1, 0, '300.00', '300.00', '', '2010-08-01', 0),
(28, 1, 6, 1, 13, ' erre', '', '2010-08-01 19:55:10', 1, '2010-08-01 19:55:10', 1, 0, '50.00', '50.00', '', '2010-08-01', 0),
(29, 1, 6, 0, 14, 'qwe', 'qwe', '2010-08-01 16:48:56', 1, '2010-08-01 16:48:56', 1, 0, '0.00', '0.00', '', '2010-08-01', 0),
(30, 1, 6, 0, 15, 'wer', '', '2010-08-01 16:52:51', 1, '2010-08-01 16:52:51', 1, 0, '400.00', '323.00', '', '2010-08-01', 0),
(31, 1, 6, 1, 16, 'sample', '', '2010-08-01 16:53:29', 1, '2010-08-01 16:54:47', 1, 0, '7000.00', '7000.00', '', '2010-08-01', 0),
(32, 1, 6, 1, 17, 'Payment from simtrain receipt no: 2', '', '2010-08-01 17:38:09', 1, '2010-08-01 17:38:09', 1, 0, '4462.00', '4462.00', 'simtrain', '2010-08-01', 0),
(33, 1, 6, 1, 18, 'Payment from simtrain receipt no: 2', '', '2010-08-01 17:39:05', 1, '2010-08-01 17:39:05', 1, 0, '4462.00', '4462.00', 'simtrain', '2010-08-01', 0),
(34, 1, 6, 1, 19, 'Payment from simtrain receipt no: 2', '', '2010-08-01 17:41:31', 1, '2010-08-01 17:41:31', 1, 0, '4462.00', '4462.00', 'simtrain', '2010-08-01', 0),
(35, 1, 6, 1, 20, 'Payment from simtrain receipt no: 2', '', '2010-08-01 17:42:06', 1, '2010-08-01 17:42:06', 1, 0, '4462.00', '4462.00', 'simtrain', '2010-08-01', 0),
(36, 1, 6, 1, 21, 'Payment from simtrain receipt no: 2', '', '2010-08-01 17:43:33', 1, '2010-08-01 17:43:33', 1, 0, '4462.00', '4462.00', 'simtrain', '2010-08-01', 0),
(37, 1, 6, 1, 22, 'Payment from simtrain receipt no: 2', '', '2010-08-01 17:45:25', 1, '2010-08-01 17:45:25', 1, 0, '4462.00', '4462.00', 'simtrain', '2010-08-01', 0),
(38, 1, 6, 1, 23, 'Payment from simtrain receipt no: 2', '', '2010-08-01 17:47:55', 1, '2010-08-01 17:47:55', 1, 0, '4462.00', '4462.00', 'simtrain', '2010-08-01', 0),
(39, 1, 6, 1, 24, 'Payment from simtrain receipt no: 2', '', '2010-08-01 17:49:18', 1, '2010-08-01 17:49:18', 1, 0, '4462.00', '4462.00', 'simtrain', '2010-08-01', 0),
(40, 1, 5, 1, 25, 'Payment from simtrain receipt no: 1', '', '2010-08-01 17:51:27', 1, '2010-08-01 17:51:27', 1, 0, '32.00', '32.00', 'simtrain', '2010-07-31', 0),
(41, 1, 6, 1, 26, 'Payment from simtrain receipt no: 2', '', '2010-08-01 17:53:06', 1, '2010-08-01 17:53:06', 1, 0, '4462.00', '4462.00', 'simtrain', '2010-08-01', 0),
(42, 1, 6, 1, 27, 'Payment from simtrain receipt no: 2', '', '2010-08-01 17:56:04', 1, '2010-08-01 17:56:04', 1, 0, '4462.00', '4462.00', 'simtrain', '2010-08-01', 0),
(43, 1, 6, 1, 28, 'Payment from simtrain receipt no: 2', '', '2010-08-01 17:58:14', 1, '2010-08-01 17:58:14', 1, 0, '4462.00', '4462.00', 'simtrain', '2010-08-01', 0),
(44, 1, 6, 1, 29, 'Payment from simtrain receipt no: 2', '', '2010-08-01 18:00:36', 1, '2010-08-01 18:00:36', 1, 0, '4462.00', '4462.00', 'simtrain', '2010-08-01', 0),
(45, 1, 6, 1, 30, 'Payment from simtrain receipt no: 2', '', '2010-08-01 18:06:40', 1, '2010-08-01 18:06:40', 1, 0, '4462.00', '4462.00', 'simtrain', '2010-08-01', 0),
(46, 1, 6, 1, 31, 'Payment from simtrain receipt no: 2', '', '2010-08-01 18:07:19', 1, '2010-08-01 18:07:19', 1, 0, '4462.00', '4462.00', 'simtrain', '2010-08-01', 0),
(47, 1, 6, 1, 32, 'Payment from simtrain receipt no: 2', '', '2010-08-01 18:10:17', 1, '2010-08-01 18:10:17', 1, 0, '4462.00', '4462.00', 'simtrain', '2010-08-01', 0),
(48, 1, 6, 1, 33, 'Payment from simtrain receipt no: 2', '', '2010-08-01 18:11:25', 1, '2010-08-01 18:11:25', 1, 0, '4462.00', '4462.00', 'simtrain', '2010-08-01', 0),
(49, 1, 6, 1, 34, 'Payment from simtrain receipt no: 2', '', '2010-08-01 18:12:30', 1, '2010-08-01 18:12:30', 1, 0, '4462.00', '4462.00', 'simtrain', '2010-08-01', 0),
(50, 1, 6, 1, 34, 'Payment from simtrain receipt no: 2', '', '2010-08-01 18:12:30', 1, '2010-08-01 18:12:30', 1, 0, '4462.00', '4462.00', 'simtrain', '2010-08-01', 0),
(52, 1, 6, 1, 35, 'Payment from simtrain receipt no: 2', '', '2010-08-01 18:14:21', 1, '2010-08-01 18:14:21', 1, 0, '4462.00', '4462.00', 'simtrain', '2010-08-01', 0),
(53, 1, 6, 1, 36, 'Payment from simtrain receipt no: 2', '', '2010-08-01 18:16:00', 1, '2010-08-01 18:16:00', 1, 0, '4462.00', '4462.00', 'simtrain', '2010-08-01', 0),
(54, 1, 5, 1, 37, 'sa', '', '2010-08-01 18:16:47', 1, '2010-08-01 18:16:47', 1, 0, '800.00', '800.00', '', '2010-07-01', 0),
(55, 1, 4, 1, 38, 'sales', '', '2010-08-01 18:17:31', 1, '2010-08-01 18:17:31', 1, 0, '4000.00', '4000.00', '', '2010-06-01', 0);

-- --------------------------------------------------------

--
-- Table structure for table `sim_simbiz_closing`
--

DROP TABLE IF EXISTS `sim_simbiz_closing`;
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

DROP TABLE IF EXISTS `sim_simbiz_debitcreditnote`;
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

DROP TABLE IF EXISTS `sim_simbiz_debitcreditnoteline`;
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

DROP TABLE IF EXISTS `sim_simbiz_financialyear`;
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

DROP TABLE IF EXISTS `sim_simbiz_financialyearline`;
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

DROP TABLE IF EXISTS `sim_simbiz_invoice`;
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

DROP TABLE IF EXISTS `sim_simbiz_invoiceline`;
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

DROP TABLE IF EXISTS `sim_simbiz_paymentvoucher`;
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

DROP TABLE IF EXISTS `sim_simbiz_paymentvoucherline`;
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

DROP TABLE IF EXISTS `sim_simbiz_permission`;
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

DROP TABLE IF EXISTS `sim_simbiz_receipt`;
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `sim_simbiz_receipt`
--

INSERT INTO `sim_simbiz_receipt` (`receipt_id`, `receipt_no`, `paidfrom`, `organization_id`, `description`, `currency_id`, `exchangerate`, `accountsfrom_id`, `created`, `createdby`, `updated`, `updatedby`, `originalamt`, `amt`, `batch_id`, `bpartner_id`, `receipt_date`, `receivedby`, `iscomplete`, `receipt_prefix`) VALUES
(1, '1', 'Students', 1, '', 3, '1.0000', 51, '2010-04-13 17:43:56', 1, '2010-04-13 18:11:05', 1, '2000.00', '2000.00', 16, 7, '2010-04-13', 'admin', 1, 'RC'),
(2, '2', 'Applicant 1', 1, '', 3, '1.0000', 51, '2010-04-15 11:00:18', 1, '2010-04-15 11:01:02', 1, '1000.00', '1000.00', 17, 7, '2010-04-15', '', 1, 'RC');

-- --------------------------------------------------------

--
-- Table structure for table `sim_simbiz_receiptline`
--

DROP TABLE IF EXISTS `sim_simbiz_receiptline`;
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `sim_simbiz_receiptline`
--

INSERT INTO `sim_simbiz_receiptline` (`receiptline_id`, `receipt_id`, `subject`, `amt`, `description`, `accounts_id`, `chequeno`) VALUES
(1, 1, 'Entry Registration', '2000.00', '', 50, '1234567'),
(2, 2, 'Entry Registration', '1000.00', '', 52, '');

-- --------------------------------------------------------

--
-- Table structure for table `sim_simbiz_tax`
--

DROP TABLE IF EXISTS `sim_simbiz_tax`;
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
  PRIMARY KEY (`tax_id`),
  KEY `organization_id` (`organization_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `sim_simbiz_tax`
--

INSERT INTO `sim_simbiz_tax` (`tax_id`, `tax_name`, `istax`, `isactive`, `created`, `createdby`, `updated`, `updatedby`, `organization_id`, `defaultlevel`, `description`) VALUES
(0, '-', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, 0, 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `sim_simbiz_transaction`
--

DROP TABLE IF EXISTS `sim_simbiz_transaction`;
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=70 ;

--
-- Dumping data for table `sim_simbiz_transaction`
--

INSERT INTO `sim_simbiz_transaction` (`trans_id`, `document_no`, `batch_id`, `amt`, `originalamt`, `tax_id`, `currency_id`, `document_no2`, `accounts_id`, `multiplyconversion`, `seqno`, `reference_id`, `bpartner_id`, `isreconciled`, `bankreconcilation_id`, `transtype`, `linedesc`, `reconciledate`) VALUES
(-1, '', 0, '0.00', '0.00', 0, 0, '', 0, '0.0000', 0, 0, 0, 0, 0, '', NULL, '0000-00-00'),
(0, '', 0, '0.00', '0.00', 0, 0, '', 0, '0.0000', 0, 0, 0, 0, 0, '', NULL, '0000-00-00'),
(18, 'RC1', 16, '-2000.00', '2000.00', 0, 3, '', 51, '1.0000', 1, 0, 0, 0, 0, '', 'yui', '0000-00-00'),
(19, 'RC1', 16, '2000.00', '2000.00', 0, 3, '1234567', 50, '1.0000', 2, 18, 0, 0, 7, '', 'Entry Registration', '2010-04-30'),
(20, 'RC2', 17, '-1000.00', '1000.00', 0, 3, '', 51, '1.0000', 0, 0, 7, 0, 0, '', '', '0000-00-00'),
(21, 'RC2', 17, '1000.00', '1000.00', 0, 3, '', 52, '1.0000', 1, 20, 0, 0, 0, '', 'Entry Registration', '0000-00-00'),
(22, '1', 18, '100.00', '100.00', 0, 0, '', 51, '1.0000', 0, 0, 7, 0, 0, 'IV', '', '0000-00-00'),
(23, '1', 18, '-100.00', '-100.00', 0, 0, '', 51, '1.0000', 1, 22, 0, 0, 0, 'IV', '', '0000-00-00'),
(24, '123', 19, '-100.00', '0.00', 0, 0, '7734567', 50, '0.0000', 1, 0, 0, 0, 7, '', '', '2010-04-30'),
(25, 'JV-4', 19, '100.00', '0.00', 0, 0, '', 52, '0.0000', 2, 24, 0, 0, 0, '', '', '0000-00-00'),
(26, 'JV-5', 20, '-100.00', '0.00', 0, 0, '', 51, '0.0000', 1, 0, 7, 0, 0, '', '', '0000-00-00'),
(27, 'JV-5', 20, '100.00', '0.00', 0, 0, '', 51, '0.0000', 2, 26, 7, 0, 0, '', '', '0000-00-00'),
(28, '-', 21, '4.00', '0.00', 0, 0, '', 51, '0.0000', 1, 0, 0, 0, 0, '', 'w', '0000-00-00'),
(29, '-', 21, '-4.00', '0.00', 0, 0, '34', 50, '0.0000', 2, 28, 0, 0, 11, '', '', '2010-08-01'),
(37, '-', 23, '3.00', '0.00', 0, 0, '', 43, '0.0000', 1, 0, 0, 0, 0, '', '', '0000-00-00'),
(38, '-', 23, '-3.00', '0.00', 0, 0, '', 46, '0.0000', 2, 37, 0, 0, 0, '', '', '0000-00-00'),
(39, '-', 25, '300.00', '0.00', 0, 0, '', 45, '0.0000', 1, 0, 0, 0, 0, '', '545wer', '0000-00-00'),
(40, '-', 25, '-300.00', '0.00', 0, 0, '', 46, '0.0000', 3, 39, 0, 0, 0, '', 'rew', '0000-00-00'),
(41, 'fe', 26, '300.00', '0.00', 0, 0, '', 44, '0.0000', 1, 0, 0, 0, 0, '', 'grdede', '0000-00-00'),
(42, '-', 26, '-300.00', '0.00', 0, 0, '', 47, '0.0000', 2, 41, 0, 0, 0, '', 'dwdw', '0000-00-00'),
(43, '-', 26, '2.00', '0.00', 0, 0, '', 42, '0.0000', 3, 0, 0, 0, 0, '', '', '0000-00-00'),
(44, '-', 26, '-2.00', '0.00', 0, 0, '', 41, '0.0000', 4, 43, 0, 0, 0, '', '', '0000-00-00'),
(45, 'we', 27, '300.00', '0.00', 0, 0, '', 46, '0.0000', 1, 0, 0, 0, 0, '', 're', '0000-00-00'),
(46, '-', 27, '-300.00', '0.00', 0, 0, '', 47, '0.0000', 2, 45, 0, 0, 0, '', 'fd', '0000-00-00'),
(47, 'wer', 28, '50.00', '0.00', 0, 0, '', 53, '0.0000', 1, 0, 0, 0, 0, '', '', '0000-00-00'),
(48, '-', 28, '-50.00', '0.00', 0, 0, '', 42, '0.0000', 3, 47, 0, 0, 0, '', '', '0000-00-00'),
(49, '-', 24, '400.00', '0.00', 0, 0, '', 55, '0.0000', 1, 0, 0, 0, 0, '', '', '0000-00-00'),
(50, '-', 24, '-400.00', '0.00', 0, 0, '', 42, '0.0000', 2, 49, 0, 0, 0, '', '', '0000-00-00'),
(51, '-', 29, '0.00', '0.00', 0, 0, '', 51, '0.0000', 1, 0, 0, 0, 0, '', '', '0000-00-00'),
(52, '-', 29, '0.00', '0.00', 0, 0, '', 38, '0.0000', 3, 51, 0, 0, 0, '', '', '0000-00-00'),
(53, '3424', 30, '-323.00', '0.00', 0, 0, '', 55, '0.0000', 1, 0, 0, 0, 0, '', '', '0000-00-00'),
(54, '-', 30, '400.00', '0.00', 0, 0, '', 44, '0.0000', 3, 53, 0, 0, 0, '', '', '0000-00-00'),
(55, '-', 31, '7000.00', '0.00', 0, 0, '', 51, '0.0000', 1, 0, 1, 0, 0, '', '', '0000-00-00'),
(56, '-', 31, '-7000.00', '0.00', 0, 0, '', 42, '0.0000', 2, 55, 0, 0, 0, '', '', '0000-00-00'),
(62, '2', -1, '4462.00', '4462.00', 0, 3, '', 56, '1.0000', 0, 0, 0, 0, 0, 'GN', '', '0000-00-00'),
(63, '2', -1, '-4462.00', '-4462.00', 0, 3, '', 42, '1.0000', 1, 62, 0, 0, 0, 'GN', '', '0000-00-00'),
(64, '2', -1, '4462.00', '4462.00', 0, 3, '', 56, '1.0000', 0, 0, 0, 0, 0, 'GN', '', '0000-00-00'),
(65, '2', -1, '-4462.00', '-4462.00', 0, 3, '', 42, '1.0000', 1, 64, 0, 0, 0, 'GN', '', '0000-00-00'),
(66, '-', 54, '-800.00', '0.00', 0, 0, '', 42, '0.0000', 1, 0, 0, 0, 0, '', '', '0000-00-00'),
(67, '-', 54, '800.00', '0.00', 0, 0, '', 50, '0.0000', 3, 66, 0, 0, 0, '', '', '0000-00-00'),
(68, '-', 55, '4000.00', '0.00', 0, 0, '', 52, '0.0000', 1, 0, 0, 0, 0, '', '', '0000-00-00'),
(69, '-', 55, '-4000.00', '0.00', 0, 0, '', 42, '0.0000', 3, 68, 0, 0, 0, '', '', '0000-00-00');

-- --------------------------------------------------------

--
-- Table structure for table `sim_simbiz_transsummary`
--

DROP TABLE IF EXISTS `sim_simbiz_transsummary`;
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
(5, 3, 51, 1, 5, '0.00', '0.00'),
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

DROP TABLE IF EXISTS `sim_simbiz_window`;
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

DROP TABLE IF EXISTS `sim_smiles`;
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
-- Table structure for table `sim_tplfile`
--

DROP TABLE IF EXISTS `sim_tplfile`;
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

DROP TABLE IF EXISTS `sim_tplset`;
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

DROP TABLE IF EXISTS `sim_tplsource`;
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
-- Table structure for table `sim_users`
--

DROP TABLE IF EXISTS `sim_users`;
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1870 ;

--
-- Dumping data for table `sim_users`
--

INSERT INTO `sim_users` (`uid`, `name`, `uname`, `email`, `url`, `user_avatar`, `user_regdate`, `user_icq`, `user_from`, `user_sig`, `user_viewemail`, `actkey`, `user_aim`, `user_yim`, `user_msnm`, `pass`, `posts`, `attachsig`, `rank`, `level`, `theme`, `timezone_offset`, `last_login`, `umode`, `uorder`, `notify_method`, `notify_mode`, `user_occ`, `bio`, `user_intrest`, `user_mailok`, `user_isactive`, `isstudent`) VALUES
(1, '--', 'admin', 'admin@simit.com.my', 'http://localhost/simedu/', 'blank.gif', 1205985656, 'e', '', '', 0, '', '', '', '', '21232f297a57a5a743894a0e4a801fc3', 0, 0, 7, 5, 'default', 8.0, 1280989244, 'thread', 0, 1, 0, '', '', 'admin', 0, 1, 0),
(1868, 'user', 'user1', 'user@hotmail.com', '', 'blank.gif', 1280211409, '', '', '', 0, '', '', '', '', '202cb962ac59075b964b07152d234b70', 0, 0, 0, 1, '', 0.0, 1280796990, 'nest', 0, 1, 0, '', '', '', 0, 0, 0),
(1869, '', 'user2', '123', '', 'blank.gif', 1280374690, '', '', '', 0, '', '', '', '', '202cb962ac59075b964b07152d234b70', 0, 0, 0, 1, '', 0.0, 1280375053, 'nest', 0, 1, 0, '', '', '', 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `sim_version`
--

DROP TABLE IF EXISTS `sim_version`;
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

DROP TABLE IF EXISTS `sim_window`;
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
  PRIMARY KEY (`window_id`),
  KEY `filename` (`filename`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=53 ;

--
-- Dumping data for table `sim_window`
--

INSERT INTO `sim_window` (`window_id`, `filename`, `isactive`, `window_name`, `updated`, `updatedby`, `created`, `createdby`, `parentwindows_id`, `seqno`, `mid`, `windowsetting`, `description`, `isdeleted`, `table_name`) VALUES
(0, '', 1, 'Top Parent', '2010-07-25 23:16:41', 1, '2010-07-24 13:16:24', 1, -1, 10, 61, '', '', 0, ''),
(1, '', 1, 'Master Data', '2010-07-25 23:16:41', 1, '2010-07-24 13:16:24', 1, 0, 10, 61, '', '', 0, ''),
(2, '', 1, 'Help/Support', '2010-07-25 23:16:41', 1, '2010-07-24 13:16:42', 1, 0, 20, 61, '', '', 0, ''),
(3, 'currency.php', 1, 'Add/Edit Currency', '2010-07-25 23:16:41', 1, '2010-07-24 13:17:16', 1, 1, 10, 61, '', '', 0, ''),
(4, 'country.php', 1, 'Add/Edit Country', '2010-07-25 23:16:41', 1, '2010-07-24 13:17:28', 1, 1, 10, 61, '', '', 0, ''),
(5, 'races.php', 1, 'Add/Edit Races', '2010-07-25 23:16:41', 1, '2010-07-24 13:17:51', 1, 1, 10, 61, '', '', 0, ''),
(6, 'religion.php', 1, 'Add/Edit Religion', '2010-07-25 23:16:41', 1, '2010-07-24 13:18:07', 1, 1, 10, 61, '', '', 0, ''),
(7, 'region.php', 0, 'Add/Edit Region', '2010-08-03 09:34:05', 1, '2010-07-24 13:18:19', 1, 1, 10, 61, '', '', 0, ''),
(8, 'period.php', 1, 'Add/Edit Period', '2010-07-25 23:16:41', 1, '2010-07-24 13:18:30', 1, 1, 10, 61, '', '', 0, ''),
(9, '', 1, 'License', '2010-07-25 23:16:41', 1, '2010-07-24 13:22:00', 1, 2, 10, 61, '', '', 0, ''),
(10, '', 1, 'Developer Help', '2010-07-25 23:16:41', 1, '2010-07-24 13:22:35', 1, 2, 10, 61, '', '', 0, ''),
(11, '', 1, 'About SIMIT Framework', '2010-07-25 23:16:41', 1, '2010-07-24 13:22:47', 1, 2, 10, 61, '', '', 0, ''),
(12, '', 1, 'Forums', '2010-07-25 23:16:41', 1, '2010-07-24 13:22:53', 1, 2, 10, 61, '', '', 0, ''),
(13, 'http://www.simit.com.my/wiki', 1, 'Wiki', '2010-07-25 23:16:41', 1, '2010-07-24 13:22:58', 1, 2, 10, 61, '', '', 0, ''),
(15, '', 1, 'Master Data', '2010-07-26 12:40:09', 1, '2010-07-26 12:31:42', 1, 0, 10, 64, '', '', 0, ''),
(16, '', 1, 'Transaction', '2010-07-26 12:55:03', 1, '2010-07-26 12:32:04', 1, 0, 20, 64, '', '', 0, ''),
(17, '', 1, 'Reports', '2010-07-26 12:55:52', 1, '2010-07-26 12:32:17', 1, 0, 30, 64, '', '', 0, ''),
(18, 'employeegroup.php', 1, 'Employee Group', '2010-07-26 12:56:53', 1, '2010-07-26 12:56:53', 1, 15, 10, 64, '', '', 0, 'sim_hr_employeegroup'),
(19, 'department.php', 1, 'Department', '2010-07-26 13:36:15', 1, '2010-07-26 13:34:39', 1, 15, 20, 64, '', '', 0, 'sim_hr_department'),
(20, 'jobposition.php', 1, 'Job Position', '2010-07-26 13:36:08', 1, '2010-07-26 13:35:04', 1, 15, 30, 64, '', '', 0, 'sim_hr_jobposition'),
(21, 'leavetype.php', 1, 'Leave Type', '2010-07-27 15:31:15', 1, '2010-07-26 13:35:27', 1, 15, 40, 64, '', '', 0, 'sim_hr_leavetype'),
(22, 'disciplinetype.php', 1, 'Discipline Type', '2010-07-26 13:35:57', 1, '2010-07-26 13:35:57', 1, 15, 50, 64, '', '', 0, 'sim_hr_disciplinetype'),
(23, 'trainingtype.php', 1, 'Training Type', '2010-07-26 13:36:46', 1, '2010-07-26 13:36:46', 1, 15, 60, 64, '', '', 0, 'sim_hr_trainingtype'),
(24, 'employee.php', 1, 'Employee', '2010-07-26 13:37:31', 1, '2010-07-26 13:37:31', 1, 15, 70, 64, '', '', 0, 'sim_hr_employee'),
(25, 'panelclinics.php', 1, 'Panel Clinic Visits', '2010-07-26 13:37:54', 1, '2010-07-26 13:37:54', 1, 16, 10, 64, '', '', 0, ''),
(26, 'leaveadjustment.php', 1, 'Leave Adjustment', '2010-07-26 13:38:47', 1, '2010-07-26 13:38:17', 1, 16, 20, 64, '', '', 0, 'sim_hr_leaveadjustment'),
(27, 'leave.php', 1, 'Apply Leave', '2010-07-26 13:38:41', 1, '2010-07-26 13:38:41', 1, 16, 30, 64, '', '', 0, 'sim_hr_leave'),
(28, 'generalclaim.php', 1, 'General Claim', '2010-07-26 13:39:17', 1, '2010-07-26 13:39:17', 1, 16, 50, 64, '', '', 0, 'sim_hr_generalclaim'),
(29, 'travellingclaim.php', 1, 'Travelling Claim', '2010-07-26 13:39:39', 1, '2010-07-26 13:39:39', 1, 16, 60, 64, '', '', 0, 'sim_hr_travellingclaim'),
(30, 'medicalclaim.php', 1, 'Medical Claim', '2010-07-26 13:40:03', 1, '2010-07-26 13:40:03', 1, 16, 70, 64, '', '', 0, 'sim_hr_medicalclaim'),
(31, 'overtimeclaim.php', 1, 'Overtime Claim', '2010-07-26 13:40:26', 1, '2010-07-26 13:40:26', 1, 16, 80, 64, '', '', 0, 'sim_hr_overtimeclaim'),
(32, 'approvallist.php', 0, 'Approval List', '2010-07-26 18:16:29', 1, '2010-07-26 18:16:29', 1, 0, 10, 65, '', '', 0, ''),
(33, 'recordinfo.php', 0, 'Record Info', '2010-07-27 09:39:33', 1, '2010-07-27 09:39:33', 1, 17, 400, 64, '', '', 0, ''),
(34, 'bpartner.php', 1, 'Business Partner', '2010-07-28 19:03:21', 1, '2010-07-28 19:00:06', 1, 37, 10, 66, '', '', 0, 'sim_bpartner'),
(35, 'bpartnergroup.php', 1, 'Business Partner Group', '2010-07-28 19:04:19', 1, '2010-07-28 19:00:51', 1, 37, 20, 66, '', '', 0, 'sim_bpartnergroup'),
(36, 'industry.php', 1, 'Industry', '2010-07-28 19:03:16', 1, '2010-07-28 19:01:20', 1, 37, 30, 66, '', '', 0, 'sim_industry'),
(37, '', 1, 'Master Data', '2010-07-28 19:04:19', 1, '2010-07-28 19:02:52', 1, 0, 10, 66, '', '', 0, ''),
(38, 'printemployeelist.php', 0, 'Print Employee List', '2010-07-30 10:56:47', 1, '2010-07-30 10:56:47', 1, 17, 10, 64, '', '', 0, ''),
(39, 'panelclinicrep.php', 1, 'Panel Clinic Visit', '2010-08-03 16:16:31', 1, '2010-07-30 12:15:22', 1, 17, 10, 64, '', '', 0, ''),
(40, 'printapplyleavelist.php', 0, 'Print Apply Leave List', '2010-07-30 12:30:39', 1, '2010-07-30 12:29:50', 1, 17, 10, 64, '', '', 0, ''),
(41, 'printgeneralclaimlist.php', 0, 'Print General Claim List', '2010-07-30 15:44:09', 1, '2010-07-30 15:44:09', 1, 17, 10, 64, '', '', 0, ''),
(42, 'printtravellingclaimlist.php', 0, 'Print Travelling Claim List', '2010-07-30 15:59:36', 1, '2010-07-30 15:59:36', 1, 17, 10, 64, '', '', 0, ''),
(43, 'printmedicalclaimlist.php', 0, 'Print Medical Claim List', '2010-07-30 16:09:06', 1, '2010-07-30 16:09:06', 1, 17, 10, 64, '', '', 0, ''),
(44, 'printovertimeclaimlist.php', 0, 'Print Overtime Claim List', '2010-07-30 16:09:30', 1, '2010-07-30 16:09:30', 1, 17, 10, 64, '', '', 0, ''),
(45, 'printadjustmentleavelist.php', 0, 'Print Adjustment Leave List', '2010-07-30 16:29:29', 1, '2010-07-30 16:29:17', 1, 17, 10, 64, '', '', 0, ''),
(46, 'employeeprofile.php', 0, 'Print Employee Cover', '2010-08-02 15:44:00', 1, '2010-08-02 15:44:00', 1, 17, 10, 64, '', '', 0, ''),
(47, 'viewemployeeprofile.php', 0, 'Print Employee Details', '2010-08-02 15:44:25', 1, '2010-08-02 15:44:25', 1, 17, 10, 64, '', '', 0, ''),
(48, 'statistics.php', 1, 'Statistics', '2010-08-03 16:15:56', 1, '2010-08-03 16:15:56', 1, 17, 10, 64, '', '', 0, ''),
(49, 'chartleave_1month.php', 0, 'Chart leave', '2010-08-03 17:47:54', 1, '2010-08-03 17:47:54', 1, 17, 10, 64, '', '', 0, ''),
(50, 'turnover_1month.php', 0, 'Turnover month', '2010-08-03 17:48:16', 1, '2010-08-03 17:48:16', 1, 17, 10, 64, '', '', 0, ''),
(51, '', 1, 'Master Data', '2010-08-05 14:07:20', 1, '2010-08-05 14:07:20', 1, 0, 10, 69, '', '', 0, ''),
(52, 'accounts.php', 1, 'Chart Of Accounts', '2010-08-05 14:08:02', 1, '2010-08-05 14:08:02', 1, 51, 10, 69, '', '', 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `sim_workflow`
--

DROP TABLE IF EXISTS `sim_workflow`;
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
(1, 'LEAVE', 'Leave Application', 1, '2010-06-22 15:38:14', 1, '0000-00-00 00:00:00', 0, 'leave workflow', 56, 25, 'marhan@simit.com.my', 0, 1),
(2, 'SUBREG', 'Subject Registration', 1, '2010-06-22 16:33:52', 1, '2010-06-22 12:05:45', 1, 'subject registration approval', 168, 26, 'admin@simit.com.my', 0, 1),
(3, 'OT', 'Overtime Application', 1, '2010-06-22 16:42:25', 1, '2010-06-22 12:20:25', 1, 'overtime workflow', 119, 30, 'adminhr@simit.com.my', 0, 1),
(4, 'GENERCLAIM', 'General Claim Application', 1, '2010-07-24 19:01:06', 1, '2010-06-22 15:22:29', 1, 'general claim workflow', 120, 30, 'lister@simit.com.my', 0, 1),
(5, 'dsfsdf', '', 1, '2010-06-22 16:26:26', 1, '2010-06-22 16:24:44', 1, '', 0, 0, '', 1, 1),
(6, 'FEEDBACK', 'Student Feedback s', 1, '2010-06-29 15:29:09', 1, '2010-06-22 16:37:12', 1, 'feedback', 0, 31, '', 0, 1),
(7, 'SUBEXC', 'Subject Exception', 1, '2010-06-22 16:43:01', 1, '2010-06-22 16:43:01', 1, 'subject exception approval', 0, 0, '', 0, 1),
(8, 'LEAVEADJ', 'Leave Adjustment', 1, '2010-07-23 17:13:38', 1, '2010-07-23 17:13:38', 1, 'leave adjustment', 0, 25, '', 0, 1),
(9, 'OVERCLAIM', 'Overtime Claim Application', 1, '2010-07-24 19:01:06', 1, '2010-07-24 19:01:06', 1, 'overtime claim workflow', 0, 30, '', 0, 1),
(10, 'MEDICCLAIM', 'Medical Claim Application', 1, '2010-07-24 19:01:06', 1, '2010-07-24 19:01:06', 1, 'medical claim workflow', 0, 30, '', 0, 1),
(11, 'TRAVECLAIM', 'Travelling Claim Application', 1, '2010-07-24 19:01:06', 1, '2010-07-24 19:01:06', 1, 'travelling claim workflow', 0, 30, '', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `sim_workflownode`
--

DROP TABLE IF EXISTS `sim_workflownode`;
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
(9, 4, 1, 1, 1, 0, '{hod_uid}', '{own_uid},{hod_uid}', '{own_uid},{hod_uid}', '', '', '', 1, 1, 0, 1, '', ',issubmit=1', '', '', 1, '2010-08-05 12:27:05', 1, '2010-06-28 16:27:02', 1, 'Total Amount : {total_amount}\nPeriod : {period}', 0, '../hr/generalclaim.php', 1, 0),
(10, 1, 1, 0, 1, 0, '{hod_uid}', '{own_uid},{hod_uid}', '{own_uid},{hod_uid}', '', '', '', 0, 0, 0, 10, '', '', '', '', 1, '2010-07-28 09:37:55', 1, '2010-07-05 14:50:14', 1, 'Leave Date : {leave_apply_date}\nReasons : {leave_reasons}\n', 0, '../hr/leave.php', 1, 0),
(11, 1, 2, 1, 1, 0, '{hod_uid}', '', '', '', '', '', 1, 1, 10, 10, '', '', '{bypassapprove}', '', 1, '2010-08-02 18:35:54', 1, '2010-07-06 10:01:53', 1, '', 0, '../hr/leave.php', 1, 1),
(12, 1, 4, 2, 1, 0, '{hod_uid}', '', '', '', '', '', 1, 1, 10, 10, '', '', '', '', 1, '2010-08-02 18:36:07', 1, '2010-07-06 10:02:11', 1, '', 0, '../hr/leave.php', 1, 1),
(13, 1, 5, 3, 1, 0, '{own_uid}', '', '', '', '', '', 1, 1, 10, 10, '', ', issubmit = 0', '{bypassapprove}', '', 1, '2010-08-02 18:36:50', 1, '2010-07-06 10:06:13', 1, '', 0, '../hr/leave.php', 0, 0),
(19, 4, 2, 1, 1, 0, '{hod_uid}', '{hod_uid}', '{hod_uid}', '', '', '', 1, 1, 9, 10, '', ',iscomplete=1', '', '', 1, '2010-08-02 18:37:12', 1, '2010-07-20 17:08:23', 1, 'Claim for {claim_details}', 0, '../hr/generalclaim.php', 1, 1),
(20, 4, 4, 2, 1, 0, '{hod_uid}', '{hod_uid}', '{hod_uid}', '', '', '', 1, 1, 9, 10, '', ',iscomplete=1', '', '', 1, '2010-08-02 18:37:35', 1, '2010-07-20 18:48:40', 1, '', 0, '../hr/generalclaim.php', 1, 1),
(21, 8, 1, 0, 1, 0, '{hod_uid}', '{hod_uid}', '{hod_uid}', '', '', '', 1, 1, 0, 10, '', ',issubmit=1', '', '', 1, '2010-08-02 18:37:46', 1, '2010-07-23 17:14:33', 1, '', 0, '../hr/leaveadjustment.php', 1, 0),
(22, 8, 2, 1, 1, 0, '{hod_uid}', '{hod_uid}', '{hod_uid}', '', '', '', 1, 1, 21, 10, '', ',issubmit=1,iscomplete=1', '', '', 1, '2010-08-02 18:37:54', 1, '2010-07-23 17:15:10', 1, '', 0, '../hr/leaveadjustment.php', 1, 1),
(23, 8, 4, 2, 1, 0, '{hod_uid}', '{hod_uid}', '{hod_uid}', '', '', '', 1, 1, 21, 10, '', ',issubmit=1,iscomplete=1', '', '', 1, '2010-08-02 18:38:06', 1, '2010-07-23 17:15:44', 1, '', 0, '', 1, 1),
(24, 8, 5, 3, 0, 0, '{own_uid}', '', '', '', '', '', 1, 0, 21, 10, '', ',issubmit=0,iscomplete=0', '', '', 1, '2010-08-02 17:02:52', 1, '2010-07-24 16:24:22', 1, '', 0, '../hr/leaveadjustment.php', 0, 0),
(25, 10, 1, 0, 1, 0, '{hod_uid}', '{own_uid},{hod_uid}', '{own_uid},{hod_uid}', '', '', '', 1, 1, 0, 10, '../hr/medicalclaim.php', ',issubmit=1', '', '', 1, '2010-08-05 12:30:01', 1, '2010-07-24 22:00:11', 1, 'Clinic Name : {clinic_name}\nTreatment for : {treatment}\nTotal Amount : {total_amount}\nPeriod : {period}', 0, '../hr/medicalclaim.php', 1, 0),
(26, 10, 2, 1, 1, 0, '{hod_uid}', '{hod_uid}', '{hod_uid}', '', '', '', 1, 1, 25, 10, '', ',issubmit=1,iscomplete=1', '', '', 1, '2010-08-02 18:38:20', 1, '2010-07-24 22:01:34', 1, '', 0, '../hr/medicalclaim.php', 1, 1),
(27, 9, 1, 0, 1, 0, '{hod_uid}', '{own_uid},{hod_uid}', '{own_uid},{hod_uid}', '', '', '', 1, 1, 0, 10, '', ',issubmit=1', '', '', 1, '2010-08-05 12:32:33', 1, '2010-07-24 22:01:52', 1, 'Total Hours : {total_hour}', 0, '../hr/overtimeclaim.php', 1, 0),
(28, 9, 2, 1, 1, 0, '{hod_uid}', '{hod_uid}', '{hod_uid}', '', '', '', 1, 1, 27, 10, '', ',issubmit=1,iscomplete=1', '', '', 1, '2010-08-02 18:39:02', 1, '2010-07-24 22:02:23', 1, '', 0, '../hr/overtimeclaim.php', 1, 1),
(29, 9, 4, 2, 1, 0, '{hod_uid}', '{hod_uid}', '', '', '', '', 1, 1, 27, 10, '', ',issubmit=1,iscomplete=1', '', '', 1, '2010-08-02 18:39:15', 1, '2010-07-24 22:02:39', 1, '', 0, '../hr/overtimeclaim.php', 1, 1),
(30, 11, 1, 0, 1, 0, '{hod_uid}', '{own_uid},{hod_uid}', '{own_uid},{hod_uid}', '', '', '', 1, 1, 0, 10, '', ',issubmit=1', '', '', 1, '2010-08-05 12:33:53', 1, '2010-07-24 22:10:05', 1, 'Total Amount : {total_amount}\nMode of Transportation : {transportation}\nPeriod : {period}', 0, '../hr/travellingclaim.php', 1, 0),
(31, 11, 2, 1, 1, 0, '{hod_uid}', '{hod_uid}', '{hod_uid}', '', '', '', 1, 1, 30, 10, '', ',issubmit=1,iscomplete=1', '', '', 1, '2010-08-02 18:39:37', 1, '2010-07-24 22:11:33', 1, '', 0, '../hr/travellingclaim.php', 1, 1),
(32, 11, 4, 2, 1, 0, '{hod_uid}', '{hod_uid}', '{hod_uid}', '', '', '', 1, 1, 30, 10, '', ',issubmit=1,iscomplete=1', '', '', 1, '2010-08-02 18:40:25', 1, '2010-07-24 22:12:06', 1, '', 0, '../hr/travellingclaim.php', 1, 1),
(33, 10, 4, 2, 1, 0, '{hod_uid}', '{hod_uid}', '{hod_uid}', '', '', '', 1, 1, 25, 10, '', ',issubmit=1,iscomplete=1', '', '', 1, '2010-08-02 18:38:47', 1, '2010-07-24 22:12:31', 1, '', 0, '../hr/medicalclaim.php', 1, 1),
(34, 4, 5, 3, 1, 0, '{own_uid}', '', '', '', '', '', 0, 0, 9, 10, '', ',issubmit = 0, iscomplete = 0', '', '', 1, '2010-08-02 16:54:29', 1, '2010-07-27 12:19:23', 1, '', 0, '', 0, 0),
(35, 11, 5, 3, 0, 0, '{own_uid}', '', '', '', '', '', 0, 0, 30, 10, '', ', issubmit=0, iscomplete=0', '', '', 1, '2010-08-02 17:01:17', 1, '2010-07-27 12:35:16', 1, '', 0, '../hr/travellingclaim.php', 0, 0),
(36, 9, 5, 3, 0, 0, '{own_uid}', '', '', '', '', '', 1, 0, 27, 10, '', ',issubmit=0,iscomplete=0', '', '', 1, '2010-08-02 17:00:23', 1, '2010-07-27 14:03:23', 1, '', 0, '', 0, 0),
(37, 0, 0, 0, 0, 0, '', '', '', '', '', '', 0, 0, 0, 0, '', '', '', '', 1, '2010-07-27 14:03:26', 1, '2010-07-27 14:03:26', 1, '', 0, '', 0, 0),
(38, 10, 5, 3, 0, 0, '{own_uid}', '', '', '', '', '', 0, 0, 25, 10, '', ',issubmit=0,iscomplete=0', '', '', 1, '2010-08-02 17:03:29', 1, '2010-07-27 14:03:57', 1, '', 0, '', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `sim_workflowstatus`
--

DROP TABLE IF EXISTS `sim_workflowstatus`;
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `sim_workflowstatus`
--

INSERT INTO `sim_workflowstatus` (`workflowstatus_id`, `image_path`, `workflowstatus_name`, `isactive`, `updated`, `updatedby`, `created`, `createdby`, `workflowstatus_description`, `isdeleted`, `organization_id`) VALUES
(0, '', '', 1, '2010-06-18 15:54:13', 0, '0000-00-00 00:00:00', 0, '', 0, 0),
(1, '', 'NEW', 1, '2010-06-22 16:17:32', 0, '0000-00-00 00:00:00', 0, '', 0, 1),
(2, '', 'APPROVE', 1, '2010-06-22 16:17:53', 0, '0000-00-00 00:00:00', 0, '', 0, 1),
(3, '', 'COMPLETE', 1, '2010-06-28 15:28:36', 0, '0000-00-00 00:00:00', 0, '', 0, 1),
(4, '', 'REJECT', 1, '2010-06-28 15:35:01', 0, '0000-00-00 00:00:00', 0, '', 0, 1),
(5, '', 'CANCEL', 1, '2010-07-06 10:03:40', 0, '0000-00-00 00:00:00', 0, '', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `sim_workflowtransaction`
--

DROP TABLE IF EXISTS `sim_workflowtransaction`;
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `sim_workflowtransaction`
--

INSERT INTO `sim_workflowtransaction` (`workflowtransaction_id`, `workflowtransaction_datetime`, `target_groupid`, `target_uid`, `targetparameter_name`, `workflowstatus_id`, `workflow_id`, `tablename`, `primarykey_name`, `primarykey_value`, `hyperlink`, `title_description`, `created`, `createdby`, `list_parameter`, `workflowtransaction_description`, `workflowtransaction_feedback`, `iscomplete`, `email_list`, `sms_list`, `email_body`, `sms_body`, `person_id`, `issubmit`) VALUES
(1, '2010-08-04 13:04:30', 1, 0, '10', 1, 8, 'sim_hr_leaveadjustment', 'leaveadjustment_id', '1', '../hr/leaveadjustment.php', '', '2010-08-04 13:04:30', 1, '', '', '', 0, '10', '10', '', '', 14, 0),
(2, '2010-08-04 13:06:20', 0, 0, '1', 5, 8, 'sim_hr_leaveadjustment', 'leaveadjustment_id', '1', '../hr/leaveadjustment.php', '', '2010-08-04 13:06:20', 1, '', '', '', 0, '', '', '', '', 14, 0),
(3, '2010-08-04 13:10:43', 1, 0, '10', 1, 8, 'sim_hr_leaveadjustment', 'leaveadjustment_id', '1', '../hr/leaveadjustment.php', '', '2010-08-04 13:10:43', 1, '', '', '', 0, '10', '10', '', '', 14, 0),
(4, '2010-08-04 19:19:02', 1, 0, '0,23', 1, 4, 'sim_hr_generalclaim', 'generalclaim_id', '1', '../hr/generalclaim.php', '', '2010-08-04 19:19:02', 1, '', 'Ok done', '', 0, '1,0,23', '1,0,23', '', '', 40, 1),
(5, '2010-08-04 20:41:01', 1, 0, '0,23', 1, 4, 'sim_hr_generalclaim', 'generalclaim_id', '15', '../hr/generalclaim.php', '', '2010-08-04 20:41:01', 1, '', 'Ok done', '', 0, '1,0,23', '1,0,23', '', '', 14, 1),
(6, '2010-08-04 20:43:08', 1, 0, '0,23', 1, 4, 'sim_hr_generalclaim', 'generalclaim_id', '16', '../hr/generalclaim.php', '', '2010-08-04 20:43:08', 1, '', 'Ok done', '', 0, '1,0,23', '1,0,23', '', '', 35, 1),
(7, '2010-08-04 20:49:23', 1, 0, '10', 1, 8, 'sim_hr_leaveadjustment', 'leaveadjustment_id', '2', '../hr/leaveadjustment.php', '', '2010-08-04 20:49:23', 1, '', '', '', 0, '10', '10', '', '', 14, 0),
(8, '2010-08-04 20:50:31', 1, 0, '10', 2, 8, 'sim_hr_leaveadjustment', 'leaveadjustment_id', '1', '../hr/leaveadjustment.php', '', '2010-08-04 20:50:31', 1, '', '', '', 1, '10', '10', '', '', 14, 1),
(9, '2010-08-04 20:53:51', 0, 0, '', 0, 0, 'sim_hr_leaveadjustment', 'leaveadjustment_id', '2', '', '', '2010-08-04 20:53:51', 1, '', '', '', 0, '', '', '', '', 14, 0),
(10, '2010-08-05 09:37:19', 1, 0, '10', 1, 8, 'sim_hr_leaveadjustment', 'leaveadjustment_id', '4', '../hr/leaveadjustment.php', '', '2010-08-05 09:37:19', 1, '', '', '', 0, '10', '10', '', '', 14, 1);

-- --------------------------------------------------------

--
-- Table structure for table `sim_workflowtransactionhistory`
--

DROP TABLE IF EXISTS `sim_workflowtransactionhistory`;
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=202 ;

--
-- Dumping data for table `sim_workflowtransactionhistory`
--

INSERT INTO `sim_workflowtransactionhistory` (`workflowtransactionhistory_id`, `workflowtransaction_id`, `workflowstatus_id`, `workflowtransaction_datetime`, `uid`, `workflowtransactionhistory_description`) VALUES
(192, 1, 1, '2010-08-04 13:04:30', 1, ''),
(193, 2, 5, '2010-08-04 13:06:20', 1, ''),
(194, 3, 1, '2010-08-04 13:10:44', 1, ''),
(195, 4, 1, '2010-08-04 19:19:02', 1, ''),
(196, 5, 1, '2010-08-04 20:41:01', 1, ''),
(197, 6, 1, '2010-08-04 20:43:08', 1, ''),
(198, 7, 1, '2010-08-04 20:49:23', 1, ''),
(199, 8, 2, '2010-08-04 20:50:32', 1, ''),
(200, 9, 0, '2010-08-04 20:53:51', 1, ''),
(201, 10, 1, '2010-08-05 09:37:19', 1, '');

-- --------------------------------------------------------

--
-- Table structure for table `sim_workflowuserchoice`
--

DROP TABLE IF EXISTS `sim_workflowuserchoice`;
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `sim_workflowuserchoice`
--

INSERT INTO `sim_workflowuserchoice` (`workflowuserchoice_id`, `workflowuserchoice_name`, `isactive`, `updated`, `updatedby`, `created`, `createdby`, `workflowuserchoice_description`, `isdeleted`, `organization_id`) VALUES
(0, '', 0, '2010-06-18 15:54:35', 0, '0000-00-00 00:00:00', 0, '', 0, 0),
(1, 'APPROVE', 1, '2010-07-06 10:42:32', 0, '0000-00-00 00:00:00', 0, '', 0, 1),
(2, 'REJECT', 1, '2010-07-06 10:42:52', 0, '0000-00-00 00:00:00', 0, '', 0, 1),
(3, 'CANCEL', 1, '2010-07-06 10:04:36', 0, '0000-00-00 00:00:00', 0, '', 0, 1),
(4, 'COMPLETE', 1, '2010-07-06 15:20:33', 0, '0000-00-00 00:00:00', 0, '', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `sim_workflowuserchoiceline`
--

DROP TABLE IF EXISTS `sim_workflowuserchoiceline`;
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `sim_workflowuserchoiceline`
--

INSERT INTO `sim_workflowuserchoiceline` (`workflowuserchoiceline_id`, `workflowuserchoiceline_name`, `workflowuserchoice_id`, `workflowstatus_id`, `isactive`, `updated`, `updatedby`, `created`, `createdby`, `workflowuserchoiceline_description`, `isdeleted`) VALUES
(1, 'Approve', 1, 2, 1, '2010-07-05 17:15:27', 0, '0000-00-00 00:00:00', 0, '', 0),
(2, 'Reject', 2, 4, 1, '2010-07-06 10:45:03', 0, '0000-00-00 00:00:00', 0, '', 0),
(3, 'Cancel', 3, 5, 1, '2010-07-06 10:05:26', 0, '0000-00-00 00:00:00', 0, '', 0),
(4, 'Complete', 4, 3, 1, '2010-07-06 10:46:26', 0, '0000-00-00 00:00:00', 0, '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `Tree`
--

DROP TABLE IF EXISTS `Tree`;
CREATE TABLE IF NOT EXISTS `Tree` (
  `Node` int(11) NOT NULL AUTO_INCREMENT,
  `ParentNode` int(11) DEFAULT NULL,
  `DeptID` int(11) NOT NULL,
  `Depth` tinyint(4) DEFAULT NULL,
  `Lineage` varchar(255) DEFAULT NULL,
  `uid` mediumint(8) NOT NULL,
  PRIMARY KEY (`Node`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `Tree`
--


--
-- Constraints for dumped tables
--

--
-- Constraints for table `sim_currency`
--
ALTER TABLE `sim_currency`
  ADD CONSTRAINT `sim_currency_ibfk_1` FOREIGN KEY (`country_id`) REFERENCES `sim_country` (`country_id`);

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
-- Constraints for table `sim_simbiz_transaction`
--
ALTER TABLE `sim_simbiz_transaction`
  ADD CONSTRAINT `sim_simbiz_transaction_ibfk_20` FOREIGN KEY (`accounts_id`) REFERENCES `sim_simbiz_accounts` (`accounts_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `sim_simbiz_transaction_ibfk_41` FOREIGN KEY (`batch_id`) REFERENCES `sim_simbiz_batch` (`batch_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sim_simbiz_transaction_ibfk_42` FOREIGN KEY (`tax_id`) REFERENCES `sim_simbiz_tax` (`tax_id`),
  ADD CONSTRAINT `sim_simbiz_transaction_ibfk_43` FOREIGN KEY (`currency_id`) REFERENCES `sim_currency` (`currency_id`),
  ADD CONSTRAINT `sim_simbiz_transaction_ibfk_45` FOREIGN KEY (`bpartner_id`) REFERENCES `sim_bpartner` (`bpartner_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sim_simbiz_transaction_ibfk_46` FOREIGN KEY (`reference_id`) REFERENCES `sim_simbiz_transaction` (`trans_id`);

--
-- Constraints for table `sim_simbiz_transsummary`
--
ALTER TABLE `sim_simbiz_transsummary`
  ADD CONSTRAINT `sim_simbiz_transsummary_ibfk_1` FOREIGN KEY (`bpartner_id`) REFERENCES `sim_bpartner` (`bpartner_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sim_simbiz_transsummary_ibfk_2` FOREIGN KEY (`accounts_id`) REFERENCES `sim_simbiz_accounts` (`accounts_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sim_simbiz_transsummary_ibfk_3` FOREIGN KEY (`organization_id`) REFERENCES `sim_organization` (`organization_id`) ON DELETE CASCADE;

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
DROP PROCEDURE IF EXISTS `completeInventoryMovement`$$
CREATE DEFINER=`ecitycommy_edu`@`localhost` PROCEDURE `completeInventoryMovement`(id INT,completestatus INT)
BEGIN

DECLARE done INT DEFAULT 0;

DECLARE varlotno varchar(30);

DECLARE varlotno_to varchar(30);

DECLARE varserialno varchar(30);

DECLARE varserialno_to varchar(30);

DECLARE varproduct_id INT;

DECLARE varlocation_id INT;

DECLARE varlocationto_id INT;

DECLARE varqty DECIMAL(14,4);

DECLARE varenterqty DECIMAL(14,4);



DECLARE varmovement_date DATE;

DECLARE vardocument_no varchar(20);

DECLARE varupdated DATETIME;

DECLARE varupdatedby INT;

DECLARE vartranstype char(2);

DECLARE varorganization_id INT;

DECLARE varmovementline_id INT;



DECLARE curProductMovementLine CURSOR FOR 

    SELECT icl.lotno, icl.serialno, icl.lotno_to, icl.serialno_to,  icl.product_id, icl.location_id,icl.locationto_id, icl.qty,icl.enterqty,

                ic.movement_date,ic.document_no,ic.updated,ic.updatedby,ic.organization_id,icl.movementline_id

    FROM sim_simiterp_productmovementline icl

    INNER JOIN sim_simiterp_productmovement ic on icl.movement_id=ic.movement_id

    where ic.movement_id=id;



DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = 1;





OPEN curProductMovementLine;

	REPEAT FETCH curProductMovementLine INTO varlotno, varserialno, varlotno_to,varserialno_to,  varproduct_id, varlocation_id,varlocationto_id, varqty,varenterqty,

                varmovement_date,vardocument_no,varupdated,varupdatedby,varorganization_id,varmovementline_id;

	   IF NOT done THEN



				SET vartranstype="MM";



	       

		IF(completestatus =0) THEN 

				SET varqty=varqty*-1;

		END IF;



				call insertProductTransactionHistory(varorganization_id,varproduct_id,varlocation_id,varqty * -1,

				varmovement_date,0,0,varmovementline_id,0,varupdatedby,varlotno,varserialno,vartranstype,vardocument_no,completestatus);



				call insertProductTransactionHistory(varorganization_id,varproduct_id,varlocationto_id,varqty,

				varmovement_date,0,0,varmovementline_id,0,varupdatedby,varlotno_to,varserialno_to,vartranstype,vardocument_no,completestatus);



				call updateStockDetailLine(varproduct_id,varlocation_id, varorganization_id, varlotno,varserialno, varupdatedby,varqty*-1, varmovement_date,vartranstype);



				call updateStockDetailLine(varproduct_id,varlocationto_id, varorganization_id, varlotno_to,varserialno_to, varupdatedby,varqty, varmovement_date,vartranstype);

	  END IF;	

        UNTIL done END REPEAT;



CLOSE curProductMovementLine;

UPDATE sim_simiterp_productmovement SET iscomplete=completestatus where movement_id=id;

SELECT "OK" as status;

END$$

DROP PROCEDURE IF EXISTS `fillTree`$$
CREATE DEFINER=`ecitycommy_edu`@`localhost` PROCEDURE `fillTree`()
BEGIN

WHILE EXISTS (SELECT * FROM Tree WHERE Depth Is Null) DO
UPDATE Tree T
INNER JOIN Tree P ON (T.ParentNode=P.Node) 
SET T.depth = P.Depth + 1, T.Lineage = concat(P.Lineage, T.ParentNode, '/' )
WHERE P.Depth>=0 
AND P.Lineage Is Not Null 
AND T.Depth Is Null;
END WHILE;

END$$

DROP PROCEDURE IF EXISTS `generateListIntoInventoryChange`$$
CREATE DEFINER=`ecitycommy_edu`@`localhost` PROCEDURE `generateListIntoInventoryChange`(IN input_inventorychange_id INT,IN input_WareHouse_id INT)
BEGIN

DECLARE done INT DEFAULT 0;

DECLARE varLotNo varchar(30);

DECLARE varSerialNo varchar(30);

DECLARE varProductID INT;

DECLARE varLocationID INT;

DECLARE varOnHandQty DECIMAL(14,4);

DECLARE nextno INT;



DECLARE curStorageLine CURSOR FOR 

    SELECT s.lotno, s.serialno, s.product_id, s.location_id, s.onhandqty

    FROM sim_simiterp_currentstock s 

    INNER JOIN sim_simiterp_location l on s.location_id=l.location_id

    where l.warehouse_id= input_WareHouse_id ;



DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = 1;



DELETE FROM sim_simiterp_inventorychangeline WHERE inventorychange_id=input_inventorychange_id;

SET nextno = 10;

OPEN curStorageLine;

	REPEAT FETCH curStorageLine INTO varLotNo,varSerialNo,varProductID,varLocationID,varOnHandQty;

	   IF NOT done THEN



		INSERT INTO sim_simiterp_inventorychangeline (inventorychange_id,serialno,lotno,product_id,location_id,bookqty,actualqty,qty,seqno) VALUES 

		(input_inventorychange_id,varSerialNo,varLotNo,varProductID,varLocationID,varOnHandQty,varOnHandQty,0,nextno);



	        SET nextno = nextno +10;

	  END IF;	

        UNTIL done END REPEAT;



CLOSE curStorageLine;



select "OK" as status,(nextno - 10 )/ 10  as lineqty from dual;







END$$

DROP PROCEDURE IF EXISTS `insertProductTransactionHistory`$$
CREATE DEFINER=`ecitycommy_edu`@`localhost` PROCEDURE `insertProductTransactionHistory`(

input_org_id INT, input_prd_id INT, input_loc_id INT, input_qty DECIMAL(14,4),

input_date DATE, input_sl_id INT, input_icl_id INT, input_pml_id  INT, input_pdl_id INT,

input_uid INT, input_lotno varchar(30), input_serialno varchar(30),input_type char(2),input_documentno varchar(20) ,input_completetype INT)
BEGIN

INSERT INTO sim_simiterp_producttransaction (

  organization_id,product_id,location_id,movement_qty,movement_date,

   shipmentline_id, inventorychangeline_id,productmovementline_id, productionline_id,

  created,createdby,updated,updatedby,lotno,serialno,transtype,documentno,completetype) VALUES (

 input_org_id,input_prd_id,input_loc_id,input_qty,input_date,

   input_sl_id, input_icl_id,input_pml_id, input_pdl_id,

  now(),input_uid,now(),input_uid,input_lotno,input_serialno,input_type,input_documentno,input_completetype );

  

END$$

DROP PROCEDURE IF EXISTS `updateInventoryChangeBookQty`$$
CREATE DEFINER=`ecitycommy_edu`@`localhost` PROCEDURE `updateInventoryChangeBookQty`(IN input_inventorychange_id INT)
BEGIN

DECLARE done INT DEFAULT 0;

DECLARE varLotNo varchar(30);

DECLARE varSerialNo varchar(30);

DECLARE varProductID INT;

DECLARE varLocationID INT;

DECLARE varQty DECIMAL(14,4);

DECLARE varOnHandQty DECIMAL(14,4);

DECLARE varActualQty DECIMAL(14,4);

DECLARE varBookQty DECIMAL(14,4);

DECLARE nextno INT;



DECLARE curInventoryChangeLine CURSOR FOR 

    SELECT lotno, serialno, product_id, location_id, qty,actualqty,bookqty

    FROM sim_simiterp_inventorychangeline 

    where inventorychange_id=input_inventorychange_id;



DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = 1;



OPEN curInventoryChangeLine;

	REPEAT FETCH curInventoryChangeLine INTO varLotNo,varSerialNo,varProductID,varLocationID,varQty,varActualQty,varBookQty;

	   IF NOT done THEN

		SELECT onhandqty INTO varOnHandQty FROM sim_simiterp_currentstock WHERE

			  serialno=varSerialNo AND

                         lotno=varLotNo AND

			 product_id=varProductID AND

			 location_id=varLocationID;



		UPDATE sim_simiterp_inventorychangeline 

			SET bookqty=varOnHandQty, 

			qty=actualqty-varOnHandQty

                WHERE  inventorychange_id=input_inventorychange_id AND

                         serialno=varSerialNo AND

                         lotno=varLotNo AND

			 product_id=varProductID AND

			 location_id=varLocationID;





	  END IF;	

        UNTIL done END REPEAT;



CLOSE curInventoryChangeLine;



select "OK" as status from dual;







END$$

DROP PROCEDURE IF EXISTS `updateStockDetailLine`$$
CREATE DEFINER=`ecitycommy_edu`@`localhost` PROCEDURE `updateStockDetailLine`(input_prd_id INT,input_loc_id INT, 

                     input_org_id INT, input_lotno varchar(30), input_serialno varchar(30),

                     input_uid INT, input_qty DECIMAL(14,4), input_date DATE,input_TransType char(2))
BEGIN

DECLARE isExist INT;

SELECT count(stock_id) INTO isExist FROM sim_simiterp_currentstock cs 

where cs.location_id=input_loc_id AND cs.product_id=input_prd_id 

AND cs.organization_id=input_org_id AND cs.lotno=input_lotno

AND cs.serialno=input_serialno;





IF(isExist=0)

  THEN  IF (input_TransType="ST") THEN

             INSERT INTO  sim_simiterp_currentstock 

              (created,createdby,updated,updatedby,lotno,serialno,

               product_id,location_id,organization_id, onhandqty, 

               lastinventorydate) VALUES  (

               now(), input_uid,now(), input_uid,input_lotno,input_serialno,

               input_prd_id,input_loc_id,input_org_id,input_qty,

               input_date );

	     ELSE

             INSERT INTO  sim_simiterp_currentstock 

              (created,createdby,updated,updatedby,lotno,serialno,

               product_id,location_id,organization_id, onhandqty) VALUES  (

               now(), input_uid,now(), input_uid,input_lotno,input_serialno,

               input_prd_id,input_loc_id,input_org_id,input_qty);

             END IF;



   ELSE IF (input_TransType="ST") THEN

    		UPDATE sim_simiterp_currentstock 

     		SET updated=now(),

     	       updatedby=input_uid,

    	        onhandqty=onhandqty+input_qty,

		lastinventorydate=input_date

		where location_id=input_loc_id AND product_id=input_prd_id 

		AND organization_id=input_org_id AND lotno=input_lotno

		AND serialno=input_serialno;

	    ELSE

    		UPDATE sim_simiterp_currentstock 

     		SET updated=now(),

     	       updatedby=input_uid,

    	        onhandqty=onhandqty+input_qty

		where location_id=input_loc_id AND product_id=input_prd_id 

		AND organization_id=input_org_id AND lotno=input_lotno

		AND serialno=input_serialno;



	    END IF;

END IF;



END$$

--
-- Functions
--
DROP FUNCTION IF EXISTS `isattendancecomplete`$$
CREATE DEFINER=`ecitycommy_edu`@`localhost` FUNCTION `isattendancecomplete`(student_id int, subject_id  int) RETURNS int(11)
BEGIN

DECLARE varAttTotal INT;
DECLARE varTotal INT;

SET varAttTotal = 0;
SET varTotal = 0;

SELECT count( attendance.student_id ) into varAttTotal
FROM sim_simedu_studentattendance attendance, sim_simedu_timetable tt, sim_simedu_subjectclass sc, sim_simedu_subject s
WHERE attendance.timetable_id = tt.timetable_id
AND tt.subjectclass_id = sc.subjectclass_id
AND sc.subject_id = s.subject_id
AND attendance.student_id =student_id
AND s.subject_id =subject_id
AND attendance.isactive =1;

SELECT count( attendance.student_id ) into varTotal
FROM sim_simedu_studentattendance attendance, sim_simedu_timetable tt, sim_simedu_subjectclass sc, sim_simedu_subject s
WHERE attendance.timetable_id = tt.timetable_id
AND tt.subjectclass_id = sc.subjectclass_id
AND sc.subject_id = s.subject_id
AND attendance.student_id =student_id
AND s.subject_id =subject_id;

RETURN varAttTotal/varTotal;

END$$

DELIMITER ;
SET FOREIGN_KEY_CHECKS=1;
