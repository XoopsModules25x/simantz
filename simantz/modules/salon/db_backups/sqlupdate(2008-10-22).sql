ALTER TABLE `simit_simsalon_customer` ADD `joindate` DATE NULL DEFAULT '0000-00-00';
ALTER TABLE `simit_simsalon_productlist` ADD `safety_level` INT( 11 ) NULL DEFAULT '0';

INSERT INTO `simit_simsalon_tblwindows` (`windows_id`, `windows_no`, `windows_name`, `windows_filename`, `windows_type`, `groupid`, `isactive`, `created`, `createdby`, `updated`, `updatedby`) VALUES 
(28, '28', 'Sales Analysis Report', 'salesanalysis.php', 'R', 0, 'Y', NULL, NULL, NULL, NULL);


ALTER TABLE `simit_simsalon_sales` ADD `sales_paidamount` DECIMAL( 12, 2 ) NULL DEFAULT '0.00';
ALTER TABLE `simit_simsalon_salesline` ADD `salesline_oprice` DECIMAL( 12, 2 ) NULL DEFAULT '0.00';
