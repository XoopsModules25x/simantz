SET FOREIGN_KEY_CHECKS=0;

INSERT INTO sim_hr_disciplinetype (disciplinetype_id, disciplinetype_name, description, isactive, defaultlevel, organization_id, created, createdby, updated, updatedby, isdeleted) VALUES
(0, '', '', 0, 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, 0);

INSERT INTO sim_hr_employee (employee_id, employee_name, employee_altname, employee_newicno, employee_oldicno, employee_passport, employee_passport_placeissue, employee_passport_issuedate, employee_passport_expirydate, ic_placeissue, ic_color, employee_citizenship, employee_bloodgroup, employee_status, filephoto, employee_hpno, employee_officeno, employee_email, employee_networkacc, employee_msgacc, permanent_address, permanent_postcode, permanent_city, permanent_state, permanent_country, permanent_telno, contact_address, contact_postcode, contact_city, contact_state, contact_country, contact_telno, place_dob, races_id, religion_id, department_id, employeegroup_id, marital_status, gender, employee_epfno, employee_socsono, employee_taxno, employee_pencenno, employee_dob, employee_joindate, employee_confirmdate, employee_enddate, employee_salary, annual_leave, created, createdby, updated, updatedby, description, organization_id, employee_no, isactive, defaultlevel, uid, employee_salarymethod, employee_jobdescription, jobposition_id, employee_ottrip, employee_othour, employee_accno, employee_bankname, employee_epfrate, employee_cardno, employee_transport, isdeleted) VALUES
(0, '', '', '', '', '', '', '0000-00-00', '0000-00-00', '', '', 0, '', 1, '', '', '', '', '', '', '', '', '', '', 0, '', '', '', '', '', 0, '', '', 0, 0, 0, 0, '', '', '', 0, '', '', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0.00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, NULL, 0, 'E', 0, 0, 0, 'B', NULL, '', '0.00', '0.00', '', '', '', '', '', 0);

INSERT INTO sim_hr_employeegroup (employeegroup_id, employeegroup_name, created, createdby, updated, updatedby, description, organization_id, employeegroup_no, isactive, defaultlevel, islecturer, isovertime, isfulltime, isparttime, isdeleted) VALUES
(0, NULL, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, NULL, 0, NULL, 0, 10, 0, 0, 0, 0, 0);

INSERT INTO sim_hr_employeestatus (employeestatus_id, employeestatus_name, isactive) VALUES
(1, 'New', 1),
(2, 'Resign', 1);

INSERT INTO sim_hr_jobposition (jobposition_id, jobposition_name, isdeleted, created, createdby, updated, updatedby, description, organization_id, jobposition_no, isactive, defaultlevel) VALUES
(0, NULL, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, NULL, 0, NULL, 0, 10);

INSERT INTO sim_hr_leavetype (leavetype_id, leavetype_name, adjustment_id, isactive, created, createdby, updated, updatedby, isdeleted, isvalidate, defaultlevel, organization_id, description) VALUES
(0, '', 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, 0, 0, 0, 0, NULL);

INSERT INTO sim_hr_qualificationtype (qualificationtype_id, qualificationtype_name, isactive) VALUES
(1, 'Diploma', 1),
(2, 'SPM', 1);

INSERT INTO sim_hr_relationship (relationship_id, relationship_name, relationship_gender, relationship_remarks, isactive) VALUES
(1, 'Mother', 'M', '', 1),
(2, 'Father', 'M', '', 1);

INSERT INTO sim_hr_trainingtype (trainingtype_id, trainingtype_name, description, isactive, defaultlevel, organization_id, created, createdby, updated, updatedby, isdeleted) VALUES
(0, NULL, NULL, 0, 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, 0),

INSERT INTO sim_simedu_activitytype (activitytype_id, activitytype_name, isactive) VALUES
(0, 'Null', 1),
(1, 'College', 1);

ALTER TABLE sim_hr_appraisalline
  ADD CONSTRAINT sim_hr_appraisalline_ibfk_1 FOREIGN KEY (employee_id) REFERENCES sim_hr_employee (employee_id) ON DELETE CASCADE;


ALTER TABLE sim_hr_attachmentline
  ADD CONSTRAINT sim_hr_attachmentline_ibfk_1 FOREIGN KEY (employee_id) REFERENCES sim_hr_employee (employee_id) ON DELETE CASCADE;

ALTER TABLE sim_hr_disciplineline
  ADD CONSTRAINT sim_hr_disciplineline_ibfk_1 FOREIGN KEY (employee_id) REFERENCES sim_hr_employee (employee_id) ON DELETE CASCADE;

ALTER TABLE sim_hr_employee
  ADD CONSTRAINT sim_hr_employee_ibfk_36 FOREIGN KEY (races_id) REFERENCES sim_races (races_id),
  ADD CONSTRAINT sim_hr_employee_ibfk_37 FOREIGN KEY (religion_id) REFERENCES sim_religion (religion_id),
  ADD CONSTRAINT sim_hr_employee_ibfk_41 FOREIGN KEY (organization_id) REFERENCES sim_organization (organization_id) ON DELETE CASCADE;


ALTER TABLE sim_hr_employeefamily
  ADD CONSTRAINT sim_hr_employeefamily_ibfk_1 FOREIGN KEY (employee_id) REFERENCES sim_hr_employee (employee_id),
  ADD CONSTRAINT sim_hr_employeefamily_ibfk_2 FOREIGN KEY (relationship_id) REFERENCES sim_hr_relationship (relationship_id);

ALTER TABLE sim_hr_employeegroup
  ADD CONSTRAINT sim_hr_employeegroup_ibfk_1 FOREIGN KEY (organization_id) REFERENCES sim_organization (organization_id) ON DELETE CASCADE;


ALTER TABLE sim_hr_generalclaim
  ADD CONSTRAINT sim_hr_generalclaim_ibfk_1 FOREIGN KEY (employee_id) REFERENCES sim_hr_employee (employee_id);

ALTER TABLE sim_hr_generalclaimline
  ADD CONSTRAINT sim_hr_generalclaimline_ibfk_1 FOREIGN KEY (generalclaim_id) REFERENCES sim_hr_generalclaim (generalclaim_id) ON DELETE CASCADE;

ALTER TABLE sim_hr_jobposition
  ADD CONSTRAINT sim_hr_jobposition_ibfk_5 FOREIGN KEY (organization_id) REFERENCES sim_organization (organization_id) ON DELETE CASCADE;

ALTER TABLE sim_hr_leave
  ADD CONSTRAINT sim_hr_leave_ibfk_1 FOREIGN KEY (employee_id) REFERENCES sim_hr_employee (employee_id) ON DELETE CASCADE,
  ADD CONSTRAINT sim_hr_leave_ibfk_2 FOREIGN KEY (organization_id) REFERENCES sim_organization (organization_id) ON DELETE CASCADE,
  ADD CONSTRAINT sim_hr_leave_ibfk_5 FOREIGN KEY (panelclinic_id) REFERENCES sim_hr_panelclinic (panelclinic_id);

ALTER TABLE sim_hr_leaveadjustmentline
  ADD CONSTRAINT sim_hr_leaveadjustmentline_ibfk_1 FOREIGN KEY (leaveadjustment_id) REFERENCES sim_hr_leaveadjustment (leaveadjustment_id) ON DELETE CASCADE;


ALTER TABLE sim_hr_medicalclaim
  ADD CONSTRAINT sim_hr_medicalclaim_ibfk_1 FOREIGN KEY (employee_id) REFERENCES sim_hr_employee (employee_id);


ALTER TABLE sim_hr_overtimeclaim
  ADD CONSTRAINT sim_hr_overtimeclaim_ibfk_1 FOREIGN KEY (employee_id) REFERENCES sim_hr_employee (employee_id);


ALTER TABLE sim_hr_overtimeclaimline
  ADD CONSTRAINT sim_hr_overtimeclaimline_ibfk_1 FOREIGN KEY (overtimeclaim_id) REFERENCES sim_hr_overtimeclaim (overtimeclaim_id) ON DELETE CASCADE;


ALTER TABLE sim_hr_portfolioline
  ADD CONSTRAINT sim_hr_portfolioline_ibfk_1 FOREIGN KEY (employee_id) REFERENCES sim_hr_employee (employee_id) ON DELETE CASCADE;


ALTER TABLE sim_hr_travellingclaim
  ADD CONSTRAINT sim_hr_travellingclaim_ibfk_1 FOREIGN KEY (employee_id) REFERENCES sim_hr_employee (employee_id);


ALTER TABLE sim_hr_travellingclaimline
  ADD CONSTRAINT sim_hr_travellingclaimline_ibfk_1 FOREIGN KEY (travellingclaim_id) REFERENCES sim_hr_travellingclaim (travellingclaim_id) ON DELETE CASCADE;

ALTER TABLE sim_hr_activityline
  ADD CONSTRAINT sim_hr_activityline_ibfk_1 FOREIGN KEY (employee_id) REFERENCES sim_hr_employee (employee_id) ON DELETE CASCADE;
SET FOREIGN_KEY_CHECKS=1;
