
-- please check this below data..if don't have..please run this sql

INSERT INTO `simit_simsalon_tblwindows` (`windows_id`, `windows_no`, `windows_name`, `windows_filename`, `windows_type`, `groupid`, `isactive`, `created`, `createdby`, `updated`, `updatedby`) VALUES 
(29, '29', 'Inactive Customer Report', 'inactivecustomerrpt.php', 'R', 0, 'Y', NULL, NULL, NULL, NULL),
(30, '30', 'Join Date Customer Report', 'joindate.php', 'R', 0, 'Y', NULL, NULL, NULL, NULL),
(31, '31', 'Sales Turn Over Report', 'salesturnover.php', 'R', 0, 'Y', NULL, NULL, NULL, NULL),
(32, '32', 'Customer Type Report', 'typecustomer.php', 'R', 0, 'Y', NULL, NULL, NULL, NULL);

-- please check this below field..at `simit_simsalon_sales`..if don't have..please run this sql

ALTER TABLE `simit_simsalon_sales` ADD `sales_paidamount` DECIMAL( 12, 2 ) NULL DEFAULT '0.00';
ALTER TABLE `simit_simsalon_salesline` ADD `salesline_oprice` DECIMAL( 12, 2 ) NULL DEFAULT '0.00';

-- new field..just run this sql

ALTER TABLE `simit_simsalon_customer` ADD `city` VARCHAR( 30 ) NULL ;
ALTER TABLE `simit_simsalon_vendor` ADD `vendor_city` VARCHAR( 30 ) NULL ;
ALTER TABLE `simit_simsalon_vinvoiceline` ADD `vinvoiceline_checkamount` CHAR( 1 ) NULL DEFAULT 'N';
