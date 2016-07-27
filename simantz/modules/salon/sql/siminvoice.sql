
CREATE TABLE siminvoice_customer(
  customer_id int(5) unsigned NOT NULL auto_increment,
  name varchar(50) NOT NULL,
  telephone varchar(30) NOT NULL,
  email varchar(30) NOT NULL,
  city varchar(40) NOT NULL,
  personincharge varchar(30) default NULL,
  fax varchar(15) default NULL,
  isactive char(1) NOT NULL default 'Y',
  street1 varchar(40) NOT NULL,
  street2 varchar(40) NOT NULL,
  state varchar(40) NOT NULL,
  country varchar(40) NOT NULL,
  postcode varchar(5) NOT NULL,
  PRIMARY KEY  (customer_id),
  KEY name (name)
) ENGINE=MyISAM ;


CREATE TABLE siminvoice_invoice (
  invoice_id int(11) NOT NULL auto_increment,
  invoice_no int(11) NOT NULL default '0',
  customer_id int(11) NOT NULL default '0',
  invoice_date date NOT NULL,
  po_no varchar(14) default NULL,
  do_no varchar(14) default NULL,
  payment_terms varchar(30) NOT NULL default 'C.O.D',
  remarks varchar(255) NOT NULL,
  amt decimal(10,2) NOT NULL default '0.00',
  salestaxpersent int(11) NOT NULL default '0',
  granttotal decimal(10,2) NOT NULL default '0.00',
  transportcharge decimal(10,2) NOT NULL default '0.00',
  iscomplete char(1) NOT NULL default 'N',
  salestaxamt decimal(10,2) NOT NULL default '0.00',
  PRIMARY KEY  (invoice_id)
) ENGINE=MyISAM  ;


CREATE TABLE siminvoice_invoiceline (
  invoiceline_id int(11) NOT NULL auto_increment,
  invoice_id int(11) NOT NULL,
  seq int(11) NOT NULL,
  no int(11) default NULL,
  description varchar(255) default NULL,
  qty int(11) default NULL,
  price decimal(10,2) default NULL,
  uom varchar(10) default NULL,
  amt decimal(10,2) default NULL,
  PRIMARY KEY  (invoiceline_id)
) ENGINE=MyISAM  ;

