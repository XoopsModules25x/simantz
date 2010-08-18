SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
INSERT INTO  sim_bpartner  ( bpartner_id ,  bpartnergroup_id ,  bpartner_no ,  bpartner_name ,  isactive ,  seqno ,  created ,  createdby ,  updated ,  updatedby ,  currency_id ,  terms_id ,  salescreditlimit ,  organization_id ,  bpartner_url ,  debtoraccounts_id ,  description ,  shortremarks ,  tax_id ,  currentbalance ,  creditoraccounts_id ,  isdebtor ,  iscreditor ,  istransporter ,  purchasecreditlimit ,  enforcesalescreditlimit ,  enforcepurchasecreditlimit ,  currentsalescreditstatus ,  currentpurchasecreditstatus ,  bankaccountname ,  bankname ,  bankaccountno ,  isdealer ,  isprospect ,  employeecount ,  alternatename ,  companyno ,  industry_id ,  tooltips ,  salespricelist_id ,  purchasepricelist_id ,  employee_id ,  inchargeperson ,  isdeleted ) VALUES
(0, 0, '', '', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, 0, 0, '0.00', 0, '', 0, '', '', 0, '0.00', 0, 0, 0, 0, '0.00', 0, 0, '0.00', '0.00', '', '', '', 0, 0, 0, '', '', 0, '', 0, 0, 0, '', 0);

INSERT INTO  sim_bpartnergroup  ( bpartnergroup_id ,  bpartnergroup_name ,  isactive ,  seqno ,  created ,  createdby ,  updated ,  updatedby ,  organization_id ,  description ,  debtoraccounts_id ,  creditoraccounts_id ,  isdeleted ) VALUES
(0, '', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, 1, '', 0, 0, 0);


INSERT INTO  sim_followuptype  ( followuptype_id ,  followuptype_name ,  isactive ,  seqno ,  organization_id ,  description ,  created ,  createdby ,  updated ,  updatedby ) VALUES
(0, '', 0, 0, 0, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0);


INSERT INTO  sim_industry  ( industry_id ,  industry_name ,  description ,  created ,  createdby ,  updated ,  updatedby ,  isactive ,  seqno ,  organization_id ,  isdeleted ) VALUES
(0, '', NULL, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, 0, 0, 1, 0);


INSERT INTO  sim_terms  ( terms_id ,  terms_name ,  seqno ,  isactive ,  created ,  createdby ,  updated ,  updatedby ,  organization_id ,  daycount ,  description ) VALUES
(0, '', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, 0, 0, '');


ALTER TABLE  sim_bpartner 
  ADD CONSTRAINT  sim_bpartner_ibfk_1  FOREIGN KEY ( organization_id ) REFERENCES  sim_organization  ( organization_id ) ON DELETE CASCADE,
  ADD CONSTRAINT  sim_bpartner_ibfk_2  FOREIGN KEY ( currency_id ) REFERENCES  sim_currency  ( currency_id ),
  ADD CONSTRAINT  sim_bpartner_ibfk_3  FOREIGN KEY ( terms_id ) REFERENCES  sim_terms  ( terms_id ),
  ADD CONSTRAINT  sim_bpartner_ibfk_4  FOREIGN KEY ( bpartnergroup_id ) REFERENCES  sim_bpartnergroup  ( bpartnergroup_id );

ALTER TABLE  sim_contacts 
  ADD CONSTRAINT  sim_contacts_ibfk_1  FOREIGN KEY ( bpartner_id ) REFERENCES  sim_bpartner  ( bpartner_id ) ON DELETE CASCADE,
  ADD CONSTRAINT  sim_contacts_ibfk_3  FOREIGN KEY ( races_id ) REFERENCES  sim_races  ( races_id ),
  ADD CONSTRAINT  sim_contacts_ibfk_4  FOREIGN KEY ( religion_id ) REFERENCES  sim_religion  ( religion_id );

ALTER TABLE  sim_followup 
  ADD CONSTRAINT  sim_followup_ibfk_3  FOREIGN KEY ( bpartner_id ) REFERENCES  sim_bpartner  ( bpartner_id ) ON DELETE CASCADE,
  ADD CONSTRAINT  sim_followup_ibfk_4  FOREIGN KEY ( followuptype_id ) REFERENCES  sim_followuptype  ( followuptype_id ),
  ADD CONSTRAINT  sim_followup_ibfk_5  FOREIGN KEY ( employee_id ) REFERENCES  sim_hr_employee  ( employee_id );

ALTER TABLE  sim_followuptype 
  ADD CONSTRAINT  sim_followuptype_ibfk_1  FOREIGN KEY ( organization_id ) REFERENCES  sim_organization  ( organization_id ) ON DELETE CASCADE;

ALTER TABLE  sim_terms 
  ADD CONSTRAINT  sim_terms_ibfk_1  FOREIGN KEY ( organization_id ) REFERENCES  sim_organization  ( organization_id ) ON DELETE CASCADE;

ALTER TABLE  sim_industry 
  ADD CONSTRAINT  sim_industry_ibfk_1  FOREIGN KEY ( organization_id ) REFERENCES  sim_organization  ( organization_id ) ON DELETE CASCADE;
SET FOREIGN_KEY_CHECKS=1;
