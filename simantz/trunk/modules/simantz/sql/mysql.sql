CREATE TABLE audit (
  tablename varchar(40) NOT NULL,
  changedesc text NOT NULL,
  category varchar(2) NOT NULL,
  uid int(11) NOT NULL,
  updated datetime NOT NULL,
  record_id int(11) NOT NULL,
  eventype varchar(2) NOT NULL,
  uname varchar(40) NOT NULL,
  audit_id int(11) NOT NULL AUTO_INCREMENT,
  ip varchar(25) NOT NULL,
  primarykey varchar(40) NOT NULL,
  controlvalue varchar(80) NOT NULL,
  PRIMARY KEY (audit_id),
  KEY record_id (record_id),
  KEY uid (uid),
  KEY category (category)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;

CREATE TABLE country (
  country_id int(11) NOT NULL AUTO_INCREMENT,
  country_code varchar(20) NOT NULL,
  country_name varchar(50) NOT NULL,
  citizenship varchar(30) NOT NULL,
  isactive smallint(6) NOT NULL,
  seqno smallint(6) NOT NULL,
  created datetime NOT NULL,
  createdby int(11) NOT NULL,
  updated datetime NOT NULL,
  updatedby int(11) NOT NULL,
  isdeleted smallint(1) NOT NULL,
  PRIMARY KEY (country_id),
  UNIQUE KEY country_code (country_code),
  UNIQUE KEY country_name (country_name)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;

CREATE TABLE currency (
  currency_id int(11) NOT NULL AUTO_INCREMENT,
  currency_code varchar(3) NOT NULL,
  currency_name varchar(30) NOT NULL,
  seqno smallint(6) NOT NULL,
  isactive smallint(6) NOT NULL,
  created datetime NOT NULL,
  createdby int(11) NOT NULL,
  updated datetime NOT NULL,
  updatedby int(11) NOT NULL,
  country_id int(11) NOT NULL,
  isdeleted smallint(1) NOT NULL,
  PRIMARY KEY (currency_id),
  UNIQUE KEY currency_code (currency_code),
  KEY country_id (country_id)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;

CREATE TABLE loginevent (
  event_id int(11) NOT NULL AUTO_INCREMENT,
  eventdatetime datetime NOT NULL,
  activity char(1) NOT NULL,
  uid int(11) NOT NULL,
  ip varchar(20) NOT NULL,
  PRIMARY KEY (event_id)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;


CREATE TABLE organization (
  organization_id int(11) NOT NULL AUTO_INCREMENT,
  organization_code varchar(7) NOT NULL,
  organization_name varchar(50) NOT NULL,
  companyno varchar(15) NOT NULL,
  street1 varchar(100) NOT NULL,
  street2 varchar(100) NOT NULL,
  street3 varchar(100) NOT NULL,
  city varchar(40) NOT NULL,
  state varchar(30) NOT NULL,
  country_id int(11) NOT NULL,
  tel_1 varchar(30) NOT NULL,
  tel_2 varchar(30) NOT NULL,
  fax varchar(30) NOT NULL,
  url varchar(120) NOT NULL,
  email varchar(120) NOT NULL,
  seqno smallint(6) NOT NULL,
  isactive smallint(6) NOT NULL,
  createdby int(11) NOT NULL,
  created datetime NOT NULL,
  updatedby int(11) NOT NULL,
  updated datetime NOT NULL,
  currency_id int(11) NOT NULL,
  groupid smallint(5) NOT NULL,
  postcode varchar(6) NOT NULL,
  accrued_acc int(11) NOT NULL,
  socso_acc int(11) NOT NULL,
  epf_acc int(11) NOT NULL,
  salary_acc int(11) NOT NULL,
  PRIMARY KEY (organization_id),
  UNIQUE KEY organization_code (organization_code),
  UNIQUE KEY organization_name (organization_name),
  KEY currency_id (currency_id),
  KEY country_id (country_id),
  KEY group_id (groupid)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;

CREATE TABLE period (
  period_id int(11) NOT NULL AUTO_INCREMENT,
  period_name varchar(50) NOT NULL,
  isactive smallint(6) NOT NULL,
  seqno smallint(6) NOT NULL,
  period_year smallint(6) NOT NULL,
  period_month smallint(6) NOT NULL,
  created datetime NOT NULL,
  createdby int(11) NOT NULL,
  updated datetime NOT NULL,
  updatedby int(11) NOT NULL,
  isdeleted smallint(1) NOT NULL,
  PRIMARY KEY (period_id),
  UNIQUE KEY period_name (period_name),
  UNIQUE KEY period_year (period_year,period_month)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;

CREATE TABLE permission (
  permission_id int(11) NOT NULL AUTO_INCREMENT,
  window_id smallint(5) NOT NULL DEFAULT '0',
  created timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  createdby int(5) NOT NULL DEFAULT '0',
  updated timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  updatedby int(5) NOT NULL DEFAULT '0',
  groupid smallint(6) NOT NULL DEFAULT '0',
  permissionsetting varchar(255) NOT NULL,
  validuntil date NOT NULL,
  isreadonlyperm smallint(6) NOT NULL,
  iswriteperm smallint(6) NOT NULL,
  PRIMARY KEY (permission_id),
  KEY groupid (groupid),
  KEY window_id (window_id)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;

CREATE TABLE races (
  races_id int(11) NOT NULL AUTO_INCREMENT,
  races_name varchar(20) NOT NULL DEFAULT '',
  isactive smallint(1) NOT NULL,
  updated timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  updatedby int(11) NOT NULL DEFAULT '0',
  created timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  createdby int(11) NOT NULL DEFAULT '0',
  races_description varchar(255) NOT NULL DEFAULT '',
  isdeleted smallint(6) NOT NULL,
  seqno int(11) NOT NULL,
  organization_id int(11) NOT NULL,
  PRIMARY KEY (races_id)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;

CREATE TABLE region (
  region_id int(11) NOT NULL AUTO_INCREMENT,
  country_id int(11) NOT NULL,
  region_name varchar(40) NOT NULL,
  isactive smallint(1) NOT NULL,
  seqno smallint(3) NOT NULL,
  created datetime NOT NULL,
  createdby int(11) NOT NULL,
  updated datetime NOT NULL,
  updatedby int(11) NOT NULL,
  organization_id int(11) NOT NULL,
  isdeleted smallint(6) NOT NULL,
  PRIMARY KEY (region_id),
  KEY country_id (country_id),
  KEY organization_id (organization_id)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;


CREATE TABLE religion (
  religion_id int(11) NOT NULL AUTO_INCREMENT,
  religion_name varchar(20) NOT NULL,
  isactive char(1) NOT NULL DEFAULT '',
  updated timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  updatedby int(11) NOT NULL DEFAULT '0',
  created timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  createdby int(11) NOT NULL DEFAULT '0',
  religion_description varchar(255) NOT NULL,
  isdeleted smallint(6) NOT NULL,
  seqno smallint(6) NOT NULL,
  organization_id int(11) NOT NULL,
  PRIMARY KEY (religion_id)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;

CREATE TABLE version (
  releasedate date NOT NULL,
  version varchar(20) NOT NULL,
  description text NOT NULL,
  upgradescript text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


CREATE TABLE window (
  window_id smallint(5) NOT NULL AUTO_INCREMENT,
  filename varchar(50) NOT NULL DEFAULT '',
  isactive smallint(1) NOT NULL DEFAULT '1',
  window_name varchar(50) NOT NULL DEFAULT '',
  updated timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  updatedby int(11) NOT NULL DEFAULT '0',
  created timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  createdby int(11) NOT NULL DEFAULT '0',
  parentwindows_id int(11) NOT NULL,
  seqno int(5) NOT NULL DEFAULT '0',
  mid int(11) NOT NULL,
  windowsetting text NOT NULL,
  description varchar(255) NOT NULL,
  isdeleted smallint(1) NOT NULL,
  table_name varchar(50) DEFAULT NULL,
  PRIMARY KEY (window_id),
  KEY filename (filename)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ;

CREATE TABLE workflow (
  workflow_id int(11) NOT NULL AUTO_INCREMENT,
  workflow_code varchar(10) NOT NULL,
  workflow_name varchar(100) NOT NULL DEFAULT '',
  isactive smallint(1) NOT NULL,
  updated timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  updatedby int(11) NOT NULL DEFAULT '0',
  created timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  createdby int(11) NOT NULL DEFAULT '0',
  workflow_description varchar(255) NOT NULL DEFAULT '',
  workflow_owneruid mediumint(8) NOT NULL DEFAULT '0',
  workflow_ownergroup smallint(5) NOT NULL DEFAULT '0',
  workflow_email text NOT NULL,
  isdeleted smallint(6) NOT NULL,
  organization_id int(11) NOT NULL,
  PRIMARY KEY (workflow_id),
  UNIQUE KEY workflow_code (workflow_code),
  KEY organization_id (organization_id),
  KEY workflow_owneruid (workflow_owneruid,workflow_ownergroup)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;

CREATE TABLE workflownode (
  workflownode_id int(11) NOT NULL AUTO_INCREMENT,
  workflow_id int(11) NOT NULL DEFAULT '0',
  workflowstatus_id int(11) NOT NULL DEFAULT '0',
  workflowuserchoice_id int(11) NOT NULL DEFAULT '0',
  target_groupid smallint(5) NOT NULL DEFAULT '0',
  target_uid mediumint(8) NOT NULL DEFAULT '0',
  targetparameter_name text,
  email_list text,
  sms_list text,
  email_subject text NOT NULL,
  email_body text,
  sms_body text,
  isemail smallint(6) NOT NULL DEFAULT '0',
  issms smallint(6) NOT NULL DEFAULT '0',
  parentnode_id int(11) NOT NULL DEFAULT '0',
  sequence_no int(11) NOT NULL DEFAULT '0',
  workflow_procedure varchar(100) NOT NULL DEFAULT '',
  workflow_sql text NOT NULL,
  workflow_bypass text NOT NULL,
  parameter_used text,
  isactive smallint(1) NOT NULL,
  updated timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  updatedby int(11) NOT NULL DEFAULT '0',
  created timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  createdby int(11) NOT NULL DEFAULT '0',
  workflow_description varchar(255) NOT NULL DEFAULT '',
  organization_id int(11) NOT NULL,
  hyperlink text NOT NULL,
  issubmit_node smallint(1) NOT NULL DEFAULT '1',
  iscomplete_node smallint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (workflownode_id),
  KEY organization_id (organization_id),
  KEY workflow_id (workflow_id),
  KEY target_groupid (target_groupid),
  KEY target_uid (target_uid),
  KEY workflowstatus_id (workflowstatus_id),
  KEY workflowuserchoice_id (workflowuserchoice_id),
  KEY parentnode_id (parentnode_id)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;


CREATE TABLE workflowstatus (
  workflowstatus_id int(11) NOT NULL AUTO_INCREMENT,
  image_path varchar(100) NOT NULL,
  workflowstatus_name varchar(100) NOT NULL DEFAULT '',
  isactive smallint(1) NOT NULL,
  updated timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  updatedby int(11) NOT NULL DEFAULT '0',
  created timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  createdby int(11) NOT NULL DEFAULT '0',
  workflowstatus_description varchar(255) NOT NULL DEFAULT '',
  isdeleted smallint(6) NOT NULL,
  organization_id int(11) NOT NULL,
  PRIMARY KEY (workflowstatus_id),
  KEY organization_id (organization_id),
  KEY workflowstatus_name (workflowstatus_name)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;


CREATE TABLE workflowtransaction (
  workflowtransaction_id int(11) NOT NULL AUTO_INCREMENT,
  workflowtransaction_datetime timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  target_groupid smallint(5) NOT NULL DEFAULT '0',
  target_uid mediumint(8) NOT NULL DEFAULT '0',
  targetparameter_name text,
  workflowstatus_id int(11) NOT NULL DEFAULT '0',
  workflow_id int(11) NOT NULL DEFAULT '0',
  tablename varchar(100) NOT NULL DEFAULT '',
  primarykey_name varchar(100) NOT NULL DEFAULT '',
  primarykey_value varchar(100) NOT NULL DEFAULT '',
  hyperlink varchar(100) NOT NULL DEFAULT '',
  title_description text NOT NULL,
  created timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  createdby int(11) NOT NULL DEFAULT '0',
  list_parameter text NOT NULL,
  workflowtransaction_description varchar(255) NOT NULL DEFAULT '',
  workflowtransaction_feedback text NOT NULL,
  iscomplete smallint(1) NOT NULL DEFAULT '0',
  email_list text NOT NULL,
  sms_list text NOT NULL,
  email_body text NOT NULL,
  sms_body text NOT NULL,
  person_id int(11) NOT NULL DEFAULT '0',
  issubmit smallint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (workflowtransaction_id),
  KEY workflow_id (workflow_id),
  KEY target_groupid (target_groupid),
  KEY target_uid (target_uid),
  KEY workflowstatus_id (workflowstatus_id),
  KEY person_id (person_id)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;

CREATE TABLE workflowtransactionhistory (
  workflowtransactionhistory_id int(11) NOT NULL AUTO_INCREMENT,
  workflowtransaction_id int(11) NOT NULL DEFAULT '0',
  workflowstatus_id int(11) NOT NULL DEFAULT '0',
  workflowtransaction_datetime timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  uid mediumint(8) NOT NULL DEFAULT '0',
  workflowtransactionhistory_description varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (workflowtransactionhistory_id),
  KEY workflowtransaction_id (workflowtransaction_id),
  KEY uid (uid),
  KEY workflowstatus_id (workflowstatus_id)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;


CREATE TABLE workflowuserchoice (
  workflowuserchoice_id int(11) NOT NULL AUTO_INCREMENT,
  workflowuserchoice_name varchar(100) NOT NULL DEFAULT '',
  isactive smallint(1) NOT NULL,
  updated timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  updatedby int(11) NOT NULL DEFAULT '0',
  created timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  createdby int(11) NOT NULL DEFAULT '0',
  workflowuserchoice_description varchar(255) NOT NULL DEFAULT '',
  isdeleted smallint(6) NOT NULL,
  organization_id int(11) NOT NULL,
  PRIMARY KEY (workflowuserchoice_id),
  KEY organization_id (organization_id)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;

CREATE TABLE workflowuserchoiceline (
  workflowuserchoiceline_id int(11) NOT NULL AUTO_INCREMENT,
  workflowuserchoiceline_name varchar(100) NOT NULL DEFAULT '',
  workflowuserchoice_id int(11) NOT NULL DEFAULT '0',
  workflowstatus_id int(11) NOT NULL DEFAULT '0',
  isactive smallint(1) NOT NULL,
  updated timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  updatedby int(11) NOT NULL DEFAULT '0',
  created timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  createdby int(11) NOT NULL DEFAULT '0',
  workflowuserchoiceline_description varchar(255) NOT NULL DEFAULT '',
  isdeleted smallint(6) NOT NULL,
  PRIMARY KEY (workflowuserchoiceline_id),
  KEY workflowuserchoice_id (workflowuserchoice_id),
  KEY workflowstatus_id (workflowstatus_id)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;

