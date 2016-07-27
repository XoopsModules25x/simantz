SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
INSERT INTO sim_country (country_id, country_code, country_name, citizenship, isactive, seqno, created, createdby, updated, updatedby, isdeleted) VALUES
(0, '--', '', '', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, 0);
UPDATE sim_country set country_id=country_id-1;

INSERT INTO sim_period (period_id, period_name, period_year, period_month, isactive, seqno, created, createdby, updated, updatedby, isdeleted) VALUES
(0, '',0, 0, 0, 0, '', 1,'', 0, 0);
UPDATE sim_period set period_id=period_id-1;

INSERT INTO sim_currency (currency_id, currency_code, currency_name, seqno, isactive, created, createdby, updated, updatedby, country_id, isdeleted) VALUES
(0, '--', '', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, 0, 0);
UPDATE sim_currency set currency_id=currency_id-1;

INSERT INTO sim_organization ( organization_code, organization_name, companyno, street1, street2, street3, city, state, country_id, tel_1, tel_2, fax, url, email, seqno, isactive, createdby, created, updatedby, updated, currency_id, groupid, postcode, accrued_acc, socso_acc, epf_acc, salary_acc) VALUES
( '--', '--', '', '', '', '', '', '', 0, '', '', '', '', '', 0, 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, 1, '', 0, 0, 0, 0),
('SIMIT', 'SIM IT SDN BHD', '792899-U', '01-39, Jalan Mutiara Emas 9/3', 'Taman Mount Austin', '', 'Johor Bahru', 'Johor', 1, '0197725330', '', '075571757', 'http://www.simit.com.my', 'sales@simit.com.my', 10, 1, 1, '2009-01-06 22:58:05', 1, '2010-05-13 23:29:45', 1, 2, '81100', 0, 0, 0, 0);
UPDATE sim_organization set organization_id=organization_id-1;

INSERT INTO sim_races (races_id, races_name, isactive, updated, updatedby, created, createdby, races_description, isdeleted, seqno, organization_id) VALUES
(0, '--', 1, '2010-06-14 22:10:50', 1, '0000-00-00 00:00:00', 0, '', 1, 0, 0);
UPDATE sim_races set races_id=races_id-1;

INSERT INTO sim_religion (religion_id, religion_name, isactive, updated, updatedby, created, createdby, religion_description, isdeleted, seqno, organization_id) VALUES
(0, '--', '', '2010-05-14 16:09:15', 0, '0000-00-00 00:00:00', 0, '', 0, 0, 1);
UPDATE sim_religion set religion_id=religion_id-1;

INSERT INTO sim_window (window_id, filename, isactive, window_name, updated, updatedby, created, createdby, parentwindows_id, seqno, mid, windowsetting, description, isdeleted, table_name) VALUES
(1, '', 1, 'Top Parent', '2010-07-24 13:16:24', 1, '2010-07-24 13:16:24', 1,  -1, 10, 0, '', '', 0, ''),
(2, '', 1, 'Master Data', '2010-07-24 13:16:24', 1, '2010-07-24 13:16:24', 1,  0, 10, 0, '', '', 0, ''),
(3, '', 1, 'Help/Support', '2010-07-24 13:21:39', 1, '2010-07-24 13:16:42', 1, 0, 20, 0, '', '', 0, ''),
(4, 'currency.php', 1, 'Add/Edit Currency', '2010-07-24 13:24:36', 1, '2010-07-24 13:17:16', 1, 1, 10, 0, '', '', 0, ''),
(5, 'country.php', 1, 'Add/Edit Country', '2010-07-24 13:24:31', 1, '2010-07-24 13:17:28', 1, 1, 10, 0, '', '', 0, ''),
(6, 'races.php', 1, 'Add/Edit Races', '2010-07-24 13:17:51', 1, '2010-07-24 13:17:51', 1, 1, 10, 0, '', '', 0, ''),
(7, 'religion.php', 1, 'Add/Edit Religion', '2010-07-24 13:18:07', 1, '2010-07-24 13:18:07', 1, 1, 10, 0, '', '', 0, ''),
(8, 'region.php', 1, 'Add/Edit Region', '2010-07-24 13:18:19', 1, '2010-07-24 13:18:19', 1, 1, 10, 0, '', '', 0, ''),
(9, 'period.php', 1, 'Add/Edit Period', '2010-07-24 13:18:30', 1, '2010-07-24 13:18:30', 1, 1, 10, 0, '', '', 0, ''),
(10, '', 1, 'License', '2010-07-24 13:22:00', 1, '2010-07-24 13:22:00', 1, 2, 10, 0, '', '', 0, ''),
(11, '', 1, 'Developer Help', '2010-07-24 13:22:35', 1, '2010-07-24 13:22:35', 1, 2, 10, 0, '', '', 0, ''),
(12, '', 1, 'About SIMIT Framework', '2010-07-24 13:22:47', 1, '2010-07-24 13:22:47', 1, 2, 10, 0, '', '', 0, ''),
(13, '', 1, 'Forums', '2010-07-24 13:22:53', 1, '2010-07-24 13:22:53', 1, 2, 10, 0, '', '', 0, ''),
(14, 'http://www.simit.com.my/wiki', 1, 'Wiki', '2010-07-24 13:23:15', 1, '2010-07-24 13:22:58', 1, 2, 10, 0, '', '', 0, '');
UPDATE sim_window set window_id=window_id-1, mid=(select max(mid) from sim_modules);

ALTER TABLE sim_currency
  ADD CONSTRAINT sim_currency_ibfk_1 FOREIGN KEY (country_id) REFERENCES sim_country (country_id);
ALTER TABLE sim_workflow
  ADD CONSTRAINT sim_workflow_ibfk_1 FOREIGN KEY (organization_id) REFERENCES sim_organization (organization_id) ON DELETE CASCADE;
ALTER TABLE sim_workflownode
  ADD CONSTRAINT sim_workflownode_ibfk_1 FOREIGN KEY (workflow_id) REFERENCES sim_workflow (workflow_id) ON DELETE CASCADE,
  ADD CONSTRAINT sim_workflownode_ibfk_2 FOREIGN KEY (workflowstatus_id) REFERENCES sim_workflowstatus (workflowstatus_id),
  ADD CONSTRAINT sim_workflownode_ibfk_3 FOREIGN KEY (workflowuserchoice_id) REFERENCES sim_workflowuserchoice (workflowuserchoice_id),
  ADD CONSTRAINT sim_workflownode_ibfk_4 FOREIGN KEY (parentnode_id) REFERENCES sim_workflownode (workflownode_id),
  ADD CONSTRAINT sim_workflownode_ibfk_5 FOREIGN KEY (organization_id) REFERENCES sim_organization (organization_id) ON DELETE CASCADE;
ALTER TABLE sim_workflowstatus
  ADD CONSTRAINT sim_workflowstatus_ibfk_1 FOREIGN KEY (organization_id) REFERENCES sim_organization (organization_id) ON DELETE CASCADE;
ALTER TABLE sim_workflowtransaction
  ADD CONSTRAINT sim_workflowtransaction_ibfk_1 FOREIGN KEY (workflowstatus_id) REFERENCES sim_workflowstatus (workflowstatus_id),
  ADD CONSTRAINT sim_workflowtransaction_ibfk_2 FOREIGN KEY (workflow_id) REFERENCES sim_workflow (workflow_id);
ALTER TABLE sim_workflowtransactionhistory
  ADD CONSTRAINT sim_workflowtransactionhistory_ibfk_1 FOREIGN KEY (workflowtransaction_id) REFERENCES sim_workflowtransaction (workflowtransaction_id) ON DELETE CASCADE,
  ADD CONSTRAINT sim_workflowtransactionhistory_ibfk_2 FOREIGN KEY (workflowstatus_id) REFERENCES sim_workflowstatus (workflowstatus_id);
ALTER TABLE sim_workflowuserchoice
  ADD CONSTRAINT sim_workflowuserchoice_ibfk_1 FOREIGN KEY (organization_id) REFERENCES sim_organization (organization_id) ON DELETE CASCADE;
ALTER TABLE sim_workflowuserchoiceline
  ADD CONSTRAINT sim_workflowuserchoiceline_ibfk_1 FOREIGN KEY (workflowuserchoice_id) REFERENCES sim_workflowuserchoice (workflowuserchoice_id) ON DELETE CASCADE,
  ADD CONSTRAINT sim_workflowuserchoiceline_ibfk_2 FOREIGN KEY (workflowstatus_id) REFERENCES sim_workflowstatus (workflowstatus_id);
SET FOREIGN_KEY_CHECKS=1;
