-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jul 29, 2025 at 10:04 AM
-- Server version: 8.0.41
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `MegDA`
--

-- --------------------------------------------------------

--
-- Table structure for table `connections`
--

CREATE TABLE `connections` (
  `id` int NOT NULL,
  `type` varchar(30) DEFAULT NULL,
  `conn_name` varchar(100) DEFAULT NULL,
  `conn_details` varchar(500) DEFAULT NULL,
  `status` varchar(30) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `created_by` varchar(30) DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `updated_by` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `data_archive`
--

CREATE TABLE `data_archive` (
  `id` int NOT NULL,
  `rule_id` int DEFAULT NULL,
  `job_id` int DEFAULT NULL,
  `batch_id` int DEFAULT NULL,
  `system_name` varchar(100) DEFAULT NULL,
  `data_entity` varchar(100) DEFAULT NULL,
  `data_id` varchar(30) DEFAULT NULL,
  `data_ref` varchar(50) DEFAULT NULL,
  `data_summary` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `parentid_kvp` varchar(500) DEFAULT NULL,
  `destination` varchar(100) DEFAULT NULL,
  `destination_path` varchar(200) DEFAULT NULL,
  `attachment_path` varchar(200) DEFAULT NULL,
  `archived` varchar(10) DEFAULT 'N',
  `deleted` varchar(10) DEFAULT 'N',
  `purged` varchar(10) DEFAULT 'N',
  `status` varchar(20) DEFAULT NULL,
  `archived_dt` datetime DEFAULT NULL,
  `deleted_dt` datetime DEFAULT NULL,
  `purged_dt` datetime DEFAULT NULL,
  `retain_till` date DEFAULT NULL,
  `created_dt` datetime DEFAULT CURRENT_TIMESTAMP,
  `created_by` varchar(30) DEFAULT NULL,
  `updated_dt` datetime DEFAULT NULL,
  `updated_by` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `data_archive`
--

INSERT INTO `data_archive` (`id`, `rule_id`, `job_id`, `batch_id`, `system_name`, `data_entity`, `data_id`, `data_ref`, `data_summary`, `parentid_kvp`, `destination`, `destination_path`, `attachment_path`, `archived`, `deleted`, `purged`, `status`, `archived_dt`, `deleted_dt`, `purged_dt`, `retain_till`, `created_dt`, `created_by`, `updated_dt`, `updated_by`) VALUES
(176, 15, NULL, NULL, 'Siebel CRM PROD', 'Service Request', '1-1BDV', NULL, '{\"SR Number\": \"1-61411\", \"Account\": \"TEST8\", \"Contact First Name\": \"CON08\", \"Contact Last Name\": \"CON08\", \"SR Type\": \"Case\", \"Severity\": \"4-Low\", \"Priority\": \"3-Medium\", \"SR Impact\": \"Low\", \"Description\": \"Problem while accessing internet\", \"Abstract\": \"There was a issue with Customer Handheld device settings. Pushed the settings\", \"SR Rootcause\": \"Human Error\", \"Status\": \"Closed\"}', '{\"Joined Account Id\": \"1-1AYW\", \"Contact Id\": \"1-1B2I\"}', 'filesystem', '/opt/megda/archive/rule_15_data_1-1BDV.json', NULL, 'Y', 'Y', 'N', 'COMPLETED', '2025-07-26 11:10:32', '2025-07-26 12:42:49', NULL, NULL, '2025-07-26 11:07:13', NULL, '2025-07-26 11:10:30', NULL),
(177, 15, NULL, NULL, 'Siebel CRM PROD', 'Service Request', '1-1BE3', NULL, '{\"SR Number\": \"1-61419\", \"Account\": \"TEST8\", \"Contact First Name\": \"CON08\", \"Contact Last Name\": \"CON08\", \"SR Type\": \"Case\", \"Severity\": \"4-Low\", \"Priority\": \"3-Medium\", \"SR Impact\": \"Low\", \"Description\": \"Wifi signal weak\", \"Abstract\": \"Device replaced\", \"SR Rootcause\": \"Human Error\", \"Status\": \"Closed\"}', '{\"Joined Account Id\": \"1-1AYW\", \"Contact Id\": \"1-1B2I\"}', 'filesystem', '/opt/megda/archive/rule_15_data_1-1BE3.json', NULL, 'Y', 'Y', 'N', 'COMPLETED', '2025-07-26 11:10:32', '2025-07-26 12:42:49', NULL, NULL, '2025-07-26 11:07:13', NULL, '2025-07-26 11:10:30', NULL),
(178, 15, NULL, NULL, 'Siebel CRM PROD', 'Service Request', '1-1BEA', NULL, '{\"SR Number\": \"1-61426\", \"Account\": \"TEST8\", \"Contact First Name\": \"CON08\", \"Contact Last Name\": \"CON08\", \"SR Type\": \"Case\", \"Severity\": \"4-Low\", \"Priority\": \"3-Medium\", \"SR Impact\": \"Low\", \"Description\": \"Frequent network disconnects\", \"Abstract\": \"Customer location is at 500m distance from the nearest tower. New tower request has been raised.\", \"SR Rootcause\": \"Human Error\", \"Status\": \"Closed\"}', '{\"Joined Account Id\": \"1-1AYW\", \"Contact Id\": \"1-1B2I\"}', 'filesystem', '/opt/megda/archive/rule_15_data_1-1BEA.json', NULL, 'Y', 'Y', 'N', 'COMPLETED', '2025-07-26 11:10:32', '2025-07-26 12:42:49', NULL, NULL, '2025-07-26 11:07:13', NULL, '2025-07-26 11:10:30', NULL),
(179, 15, NULL, NULL, 'Siebel CRM PROD', 'Service Request', '1-1BEH', NULL, '{\"SR Number\": \"1-61433\", \"Account\": \"TEST8\", \"Contact First Name\": \"CON08\", \"Contact Last Name\": \"CON08\", \"SR Type\": \"Case\", \"Severity\": \"4-Low\", \"Priority\": \"3-Medium\", \"SR Impact\": \"Low\", \"Description\": \"high bill on data usage\", \"Abstract\": \"customer has consumed the quota and exceeded by 10GB. Waived off for this month\", \"SR Rootcause\": \"Human Error\", \"Status\": \"Closed\"}', '{\"Joined Account Id\": \"1-1AYW\", \"Contact Id\": \"1-1B2I\"}', 'filesystem', '/opt/megda/archive/rule_15_data_1-1BEH.json', NULL, 'Y', 'Y', 'N', 'COMPLETED', '2025-07-26 11:10:32', '2025-07-26 12:42:49', NULL, NULL, '2025-07-26 11:07:13', NULL, '2025-07-26 11:10:31', NULL),
(180, 16, NULL, NULL, 'Siebel CRM PROD', 'Service Request', '1-1BA9', NULL, '{\"SR Number\": \"1-61281\", \"Account\": \"TEST0\", \"Contact First Name\": \"CON00\", \"Contact Last Name\": \"CON00\", \"SR Type\": \"Incident\", \"Severity\": \"4-Low\", \"Priority\": \"3-Medium\", \"SR Impact\": \"Low\", \"Description\": \"Problem accessing app\", \"Abstract\": \"Customer android version is old and not supported\", \"SR Rootcause\": \"Human Error\", \"Status\": \"Closed\"}', '{\"Joined Account Id\": \"1-1AZ6\", \"Contact Id\": \"1-1AZM\"}', 'cloudstorage', 'oci://megda-archive-bucket@axztm1exotmj/rule_16_data_1-1BA9.json', NULL, 'Y', 'Y', 'N', 'COMPLETED', '2025-07-26 11:10:31', '2025-07-26 12:42:50', NULL, NULL, '2025-07-26 11:07:17', NULL, '2025-07-26 11:10:29', NULL),
(181, 16, NULL, NULL, 'Siebel CRM PROD', 'Service Request', '1-1BAH', NULL, '{\"SR Number\": \"1-61289\", \"Account\": \"TEST1\", \"Contact First Name\": \"CON01\", \"Contact Last Name\": \"CON01\", \"SR Type\": \"Incident\", \"Severity\": \"4-Low\", \"Priority\": \"3-Medium\", \"SR Impact\": \"Low\", \"Description\": \"Prepaid to Postpaid conversion\", \"Abstract\": \"Transferred to Sales team\", \"SR Rootcause\": \"Human Error\", \"Status\": \"Closed\"}', '{\"Joined Account Id\": \"1-1AWX\", \"Contact Id\": \"1-1AZZ\"}', 'cloudstorage', 'oci://megda-archive-bucket@axztm1exotmj/rule_16_data_1-1BAH.json', NULL, 'Y', 'Y', 'N', 'COMPLETED', '2025-07-26 11:10:32', '2025-07-26 12:42:50', NULL, NULL, '2025-07-26 11:07:17', NULL, '2025-07-26 11:10:29', NULL),
(182, 16, NULL, NULL, 'Siebel CRM PROD', 'Service Request', '1-1BAS', NULL, '{\"SR Number\": \"1-61300\", \"Account\": \"TEST2\", \"Contact First Name\": \"CON02\", \"Contact Last Name\": \"CON02\", \"SR Type\": \"Incident\", \"Severity\": \"4-Low\", \"Priority\": \"3-Medium\", \"SR Impact\": \"Low\", \"Description\": \"Add-on data package requested\", \"Abstract\": \"Helped customer to recharge Add-on data package for 1 month.\", \"SR Rootcause\": \"Human Error\", \"Status\": \"Closed\"}', '{\"Joined Account Id\": \"1-1AX8\", \"Contact Id\": \"1-1B0C\"}', 'cloudstorage', 'oci://megda-archive-bucket@axztm1exotmj/rule_16_data_1-1BAS.json', NULL, 'Y', 'Y', 'N', 'COMPLETED', '2025-07-26 11:10:32', '2025-07-26 12:42:50', NULL, NULL, '2025-07-26 11:07:17', NULL, '2025-07-26 11:10:30', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `entities`
--

CREATE TABLE `entities` (
  `id` int NOT NULL,
  `entity_name` varchar(50) DEFAULT NULL,
  `IO_name` varchar(50) DEFAULT NULL,
  `table_name` varchar(50) DEFAULT NULL,
  `query_hierarchy` varchar(1000) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `query_fields` varchar(200) DEFAULT NULL,
  `query_field_map` varchar(500) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `parent_id_fields` varchar(200) DEFAULT NULL,
  `summary_fields` varchar(200) DEFAULT NULL,
  `status` varchar(30) DEFAULT NULL,
  `system` varchar(100) DEFAULT NULL,
  `created` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `entities`
--

INSERT INTO `entities` (`id`, `entity_name`, `IO_name`, `table_name`, `query_hierarchy`, `query_fields`, `query_field_map`, `parent_id_fields`, `summary_fields`, `status`, `system`, `created`) VALUES
(1, 'Accounts', 'Base_Accounts', 'S_ORG_EXT', '', '[Created],\n[Updated],\n[Status],\n[Account_Type],\n[Account_Region],\n[Account_Country],\n[Account_State]', NULL, '[Party_Id]', '[Account_Name],\n[Account_Type],\n[Account_Region],\n[Account_Country],\n[Account_State]', 'active', 'Siebel CRM PROD', '2025-06-19 18:46:29'),
(2, 'Service Request', 'Base Service Request', 'S_SRV_REQ', '{   \"Contact\": {     \"searchspec\": \"([Id]=\'REPLACE_ID\')\",     \"fields\": \"Job Title,Suffix,First Name,Last Name,Account Primary Address Id,Owned By,Status\",     \"Service Request\": {       \"fields\": \"Id,SR Impact,Service Request Type,Type,Sub Type,Severity,Priority,Area,Sub-Area,Status,Sub-Status,Abstract,Description,Comments,SR Rootcause,Resolution Code,Service Region,Created By Name,Owner,Opened Date\",     },     \"Action\": {       \"fields\": \"Type,Status,Description,Due,Priority,Comment,Primary Owned By,Created,Done Flag,\"     }   } }', '[Created],[Updated],[Status],[Closed Date],[SR Type]', '\'Created\'=>\'CREATED\',\n\'Updated\'=>\'LAST_UPD\',\n\'Closed Date\'=>\'ACT_CLOSE_DT\',\n\'Status\'=>\'SR_STAT_ID\',\n\'SR Type\'=>\'SR_CAT_TYPE_CD\',', '[AccountId],[ContactId],[AssetId]', '[SR Desc],[SR Summary]', 'active', 'Siebel CRM PROD', '2025-06-20 17:14:39'),
(3, 'Orders', 'Base Order Entry Orders', 'S_ORDER', '', '[Created],[Updated],[Region],[Revenue],[Status]', NULL, '[AccountId]', '[Region],[Revenue],[Status]', 'active', 'Siebel CRM PROD', '2025-06-20 18:19:16'),
(4, 'Contact', 'Base Contacts', 'S_CONTACT', '', '[Created],[Updated],[Status]', NULL, '[AccountId]', '[Desciption]', 'active', 'Siebel CRM PROD', '2025-06-20 18:22:06');

-- --------------------------------------------------------

--
-- Table structure for table `rules`
--

CREATE TABLE `rules` (
  `id` int NOT NULL,
  `rule_name` varchar(100) DEFAULT NULL,
  `rule_desc` varchar(200) DEFAULT NULL,
  `source_system` varchar(100) DEFAULT NULL,
  `data_entity` varchar(50) DEFAULT NULL,
  `IO_name` varchar(50) DEFAULT NULL,
  `base_table` varchar(30) DEFAULT NULL,
  `rule_criteria` varchar(200) DEFAULT NULL,
  `rule_criteria_sql` varchar(500) DEFAULT NULL,
  `rule_status` varchar(20) DEFAULT NULL,
  `archive_source` varchar(100) DEFAULT NULL,
  `archive_type` varchar(30) DEFAULT NULL,
  `archive_attachment` varchar(10) DEFAULT NULL,
  `activation_date` datetime DEFAULT '2999-01-01 00:00:00',
  `expiration_date` datetime DEFAULT '2999-01-01 00:00:00',
  `frequency` varchar(100) DEFAULT NULL,
  `execution_start_time` time DEFAULT NULL,
  `execution_end_time` time DEFAULT NULL,
  `reterival_required` varchar(10) DEFAULT NULL,
  `summary_required` varchar(10) DEFAULT NULL,
  `summary_type` varchar(20) DEFAULT NULL,
  `summary_fields` varchar(200) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `parent_id_fields` varchar(100) DEFAULT NULL,
  `query_fields` varchar(200) DEFAULT NULL,
  `query_hierarchy` varchar(1000) DEFAULT NULL,
  `retention_period` varchar(30) DEFAULT NULL,
  `archive_destination` varchar(50) DEFAULT NULL,
  `total_count` int DEFAULT NULL,
  `archive_count` int DEFAULT NULL,
  `summary_count` int DEFAULT NULL,
  `delete_count` int DEFAULT NULL,
  `created_dt` datetime DEFAULT CURRENT_TIMESTAMP,
  `created_by` varchar(50) DEFAULT NULL,
  `updated_dt` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_by` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rules`
--

INSERT INTO `rules` (`id`, `rule_name`, `rule_desc`, `source_system`, `data_entity`, `IO_name`, `base_table`, `rule_criteria`, `rule_criteria_sql`, `rule_status`, `archive_source`, `archive_type`, `archive_attachment`, `activation_date`, `expiration_date`, `frequency`, `execution_start_time`, `execution_end_time`, `reterival_required`, `summary_required`, `summary_type`, `summary_fields`, `parent_id_fields`, `query_fields`, `query_hierarchy`, `retention_period`, `archive_destination`, `total_count`, `archive_count`, `summary_count`, `delete_count`, `created_dt`, `created_by`, `updated_dt`, `updated_by`) VALUES
(11, 'Closed SR - Cloud', 'All Closed Service Requests', 'Siebel CRM PROD', 'Service Request', 'Service Request', 'S_SRV_REQ', '[Status] = \'Closed\'', 'SELECT ROW_ID FROM SIEBEL.S_SRV_REQ WHERE SR_STAT_ID = \'Closed\'', 'inactive', '', 'archive_with_delete', 'yes', '2025-07-12 11:30:33', '2025-07-15 12:49:16', 'FREQ=MINUTELY;INTERVAL=5', '00:00:00', '23:59:00', 'yes', 'yes', 'field_summary', '[SR Number],[Account],[Contact First Name],[Contact Last Name],[SR Type],[Severity],[Priority],[SR Impact],[Description],[Abstract],[SR Rootcause],[Status]', '[Joined Account Id],[Contact Id]', '[Created],[Updated],[Status]', NULL, '730', 'cloudstorage', 0, NULL, NULL, NULL, '2025-07-04 06:15:13', 'ragha', '2025-07-04 06:15:13', 'ragha'),
(14, 'Closed SR - filesystem', 'All Closed Service Requests', 'Siebel CRM PROD', 'Service Request', 'Service Request', 'S_SRV_REQ', '[Status] = \'Closed\'', 'SELECT ROW_ID FROM SIEBEL.S_SRV_REQ WHERE SR_STAT_ID = \'Closed\'', 'inactive', '', 'archive_with_delete', 'yes', '2025-07-12 05:08:09', '2025-07-12 09:36:11', 'FREQ=MINUTELY;INTERVAL=5', '00:00:00', '23:59:00', 'yes', 'yes', 'field_summary', '[SR Number],[Account],[Contact First Name],[Contact Last Name],[SR Type],[Severity],[Priority],[SR Impact],[Description],[Abstract],[SR Rootcause],[Status]', '[Joined Account Id],[Contact Id]', '[Created],[Updated],[Status]', NULL, '730', 'filesystem', 0, NULL, NULL, NULL, '2025-07-04 06:15:13', 'ragha', '2025-07-04 06:15:13', 'ragha'),
(15, 'Service Request - Closed SR - Case - FS', 'All Service Requests of type `Case` and are in `Closed` Status', 'Siebel CRM PROD', 'Service Request', 'Service Request', 'S_SRV_REQ', '[SR Type] = \'Case\' AND  [Status] = \'Closed\'', 'SELECT ROW_ID FROM SIEBEL.S_SRV_REQ WHERE SR_CAT_TYPE_CD = \'Case\' AND  SR_STAT_ID = \'Closed\'', 'active', '', 'archive_with_delete', 'yes', '2025-07-26 11:07:12', '2999-01-01 00:00:00', 'FREQ=MINUTELY;INTERVAL=5', '00:00:00', '23:59:00', 'yes', 'yes', 'field_summary', '[SR Number],[Account],[Contact First Name],[Contact Last Name],[SR Type],[Severity],[Priority],[SR Impact],[Description],[Abstract],[SR Rootcause],[Status]', '[Joined Account Id],[Contact Id]', '[Created],[Updated],[Status],[Closed Date],[SR Type]', '{   \"Contact\": {     \"searchspec\": \"([Id]=\'REPLACE_ID\')\",     \"fields\": \"Job Title,Suffix,First Name,Last Name,Account Primary Address Id,Owned By,Status\",     \"Service Request\": {       \"fields\": \"Id,SR Impact,Service Request Type,Type,Sub Type,Severity,Priority,Area,Sub-Area,Status,Sub-Status,Abstract,Description,Comments,SR Rootcause,Resolution Code,Service Region,Created By Name,Owner,Opened Date\",     },     \"Action\": {       \"fields\": \"Type,Status,Description,Due,Priority,Comment,Primary Owned By,Created,Done Flag,\"     }   } }', '365', 'filesystem', 0, NULL, NULL, NULL, '2025-07-15 12:45:02', 'ragha', '2025-07-15 12:45:02', 'ragha'),
(16, 'Service Request - Closed SR - Incident - Cloud', 'All Closed Service Request of type `Incident`', 'Siebel CRM PROD', 'Service Request', 'Service Request', 'S_SRV_REQ', '[SR Type] = \'Incident\' AND  [Status] = \'Closed\'', 'SELECT ROW_ID FROM SIEBEL.S_SRV_REQ WHERE SR_CAT_TYPE_CD = \'Incident\' AND  SR_STAT_ID = \'Closed\'', 'active', '', 'archive_with_delete', 'yes', '2025-07-26 11:07:17', '2999-01-01 00:00:00', 'FREQ=MINUTELY;INTERVAL=5', '00:00:00', '23:59:00', 'yes', 'yes', 'field_summary', '[SR Number],[Account],[Contact First Name],[Contact Last Name],[SR Type],[Severity],[Priority],[SR Impact],[Description],[Abstract],[SR Rootcause],[Status]', '[Joined Account Id],[Contact Id]', '[Created],[Updated],[Status],[Closed Date],[SR Type]', '{   \"Contact\": {     \"searchspec\": \"([Id]=\'REPLACE_ID\')\",     \"fields\": \"Job Title,Suffix,First Name,Last Name,Account Primary Address Id,Owned By,Status\",     \"Service Request\": {       \"fields\": \"Id,SR Impact,Service Request Type,Type,Sub Type,Severity,Priority,Area,Sub-Area,Status,Sub-Status,Abstract,Description,Comments,SR Rootcause,Resolution Code,Service Region,Created By Name,Owner,Opened Date\",     },     \"Action\": {       \"fields\": \"Type,Status,Description,Due,Priority,Comment,Primary Owned By,Created,Done Flag,\"     }   } }', '365', 'cloudstorage', 0, NULL, NULL, NULL, '2025-07-15 12:52:54', 'ragha', '2025-07-15 12:52:54', 'ragha'),
(17, 'TEST SR - Closed', 'All Closed SR\'s', 'Siebel CRM PROD', 'Service Request', 'Base Service Request', 'S_SRV_REQ', '[Status] = \'Closed\' AND  [Created] < \'31-12-2020\'', NULL, 'creating', '', 'archive_with_delete', 'yes', '2999-01-01 00:00:00', '2999-01-01 00:00:00', 'FREQ=WEEKLY;INTERVAL=1;BYDAY=SA,SU;UNTIL=20260101T000000Z', '22:00:00', '23:59:00', 'yes', 'yes', 'field_summary', '[SR Desc],[SR Summary]', '[AccountId],[ContactId],[AssetId]', '[Created],[Updated],[Status],[Closed Date],[SR Type]', NULL, '730', 'filesystem', 0, NULL, NULL, NULL, '2025-07-26 11:00:39', 'jdoe', '2025-07-26 11:00:39', 'jdoe');

-- --------------------------------------------------------

--
-- Table structure for table `scheduler_state`
--

CREATE TABLE `scheduler_state` (
  `rule_id` int NOT NULL,
  `last_run` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `system`
--

CREATE TABLE `system` (
  `id` int NOT NULL,
  `system_name` varchar(100) DEFAULT NULL,
  `system_details` varchar(100) DEFAULT NULL,
  `database_type` varchar(30) DEFAULT NULL,
  `database_name` varchar(100) DEFAULT NULL,
  `db_connect_string` varchar(500) DEFAULT NULL,
  `REST_endpoint` varchar(200) DEFAULT NULL,
  `REST_endpoint_delete` varchar(100) DEFAULT NULL,
  `filesystem_path` varchar(200) DEFAULT NULL,
  `status` varchar(30) DEFAULT NULL,
  `created_dt` datetime DEFAULT CURRENT_TIMESTAMP,
  `created_by` varchar(50) DEFAULT NULL,
  `updated_dt` datetime DEFAULT NULL,
  `updated_by` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `system`
--

INSERT INTO `system` (`id`, `system_name`, `system_details`, `database_type`, `database_name`, `db_connect_string`, `REST_endpoint`, `REST_endpoint_delete`, `filesystem_path`, `status`, `created_dt`, `created_by`, `updated_dt`, `updated_by`) VALUES
(1, 'Siebel CRM PROD', 'Siebel CRM on version 25.4 with Oracle Database. REST API Enabled', 'oracle', 'pdb1.us.oracle.com', '(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)(HOST=10.65.46.55)(PORT=1521))(CONNECT_DATA=(SERVER=DEDICATED)(SERVICE_NAME=pdb1.us.oracle.com)))', 'https://10.65.34.122/siebel/v1.0/data', 'https://10.65.34.122/siebel/v1.0/data', 'TBU', 'active', '2025-06-20 13:21:45', 'ragha', '2025-06-20 13:20:17', 'ragha'),
(2, 'Siebel CRM TEST', 'Siebel CRM on 25.4 - TEST Instance', 'oracle', 'TBU', NULL, 'TBU', NULL, 'TBU', 'active', '2025-06-20 13:40:31', NULL, NULL, NULL),
(3, 'BRM TEST', 'Billing and Revenue Management System. \nTest Environment', 'oracle', 'TBU', NULL, 'TBU', NULL, 'TBU', 'inactive', '2025-06-20 18:13:12', NULL, NULL, NULL),
(4, 'HCM TEST 1', 'Human Capital Management Software\nBased on Peoplesoft', 'oracle', 'TBU', NULL, 'TBU', NULL, 'TBU', 'inactive', '2025-06-20 18:15:21', NULL, NULL, NULL),
(5, 'ERP PERF TEST', 'ERP Performance Test Environment', NULL, NULL, NULL, NULL, NULL, NULL, 'creating', '2025-07-13 06:47:33', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int NOT NULL,
  `firstname` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `lastname` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `username` text COLLATE utf8mb4_general_ci NOT NULL,
  `password` text COLLATE utf8mb4_general_ci NOT NULL,
  `avatar` varchar(200) COLLATE utf8mb4_general_ci DEFAULT 'uploads/employee/admin_avatar.png',
  `phone` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `email` varchar(80) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `type` varchar(30) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `role` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_updated` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `firstname`, `lastname`, `username`, `password`, `avatar`, `phone`, `email`, `last_login`, `type`, `role`, `status`, `date_added`, `date_updated`) VALUES
(2, 'John', 'Doe', 'jdoe', '$2y$10$7pjg1lmqq7Tnr11p6hw0Subpl5oCyTrq.AV1rlSQuxb5Ny6qYNq3q', 'uploads/employee/photo.JPG', '1234567890', 'john.doe@techmh.com', '0000-00-00 00:00:00', 'employee', 'SUPER_ADMIN', 'active', '0000-00-00 00:00:00', '2025-07-26 10:01:06'),
(15, 'Wasim', 'Akram', 'wasim', '$2y$10$CnWHNyIQAyIbu6mZjqNwD.aVM56q7F9u2dDo9ukXXe3C.ansGq7Oq', 'uploads/employee/waseem.jpg', '1231231234', 'wasim@techmh.com', '0000-00-00 00:00:00', 'employee', 'SUPER_ADMIN', 'active', '0000-00-00 00:00:00', '2025-07-26 10:01:10'),
(19, 'Mahesh', 'Kumar', 'mahesh', '$2y$10$SHLdrLPszZuxUjkDxKB.3.tJ.O0MOnpDBS.cuqQ5Tjs5IiWtU9x7W', 'uploads/employee/admin_avatar.png', '1122334455', 'mahesh@techmh.com', '0000-00-00 00:00:00', 'contractor', 'SUPER_ADMIN', 'active', '0000-00-00 00:00:00', '2025-07-26 10:01:14'),
(27, 'Shreyas', 'Vuptoor', 'shreyas', '$2y$10$HXzqHVhZyvnMHIxBm5B9YOnxulOkLfafWkrUp2f0ejfCfNwFHFLh6', 'uploads/employee/photo.JPG', '1234512345', 'shreyas@techmh.con', '0000-00-00 00:00:00', 'employee', 'SUPER_ADMIN', 'active', '0000-00-00 00:00:00', '2025-07-26 10:01:16');

-- --------------------------------------------------------

--
-- Table structure for table `user_role`
--

CREATE TABLE `user_role` (
  `id` int NOT NULL,
  `role_name` varchar(30) NOT NULL,
  `role_disp_name` varchar(30) NOT NULL,
  `dashboard` varchar(8) NOT NULL DEFAULT '0000',
  `user` varchar(8) NOT NULL DEFAULT '0000',
  `products` varchar(8) NOT NULL DEFAULT '0000',
  `categories` varchar(8) NOT NULL DEFAULT '0000',
  `settings` varchar(8) NOT NULL DEFAULT '0000',
  `orders` varchar(8) NOT NULL DEFAULT '0000',
  `customers` varchar(8) NOT NULL DEFAULT '0000',
  `delivery` varchar(8) NOT NULL DEFAULT '0000',
  `reports` varchar(8) NOT NULL DEFAULT '0000',
  `inventory` varchar(8) NOT NULL DEFAULT '0000',
  `status` varchar(8) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_role`
--

INSERT INTO `user_role` (`id`, `role_name`, `role_disp_name`, `dashboard`, `user`, `products`, `categories`, `settings`, `orders`, `customers`, `delivery`, `reports`, `inventory`, `status`) VALUES
(2, 'SYSTEM_ADMIN', 'System Administrator', '1000', '', '1111', '1111', '0000', '1111', '0000', '0000', '1000', '0000', 'active'),
(3, 'RULE_ADMIN', 'Role Administraotor', '1000', '', '1000', '1000', '1110', '1000', '0000', '0000', '1000', '0000', 'active'),
(4, 'SRE_ADMIN', 'Site Reliability Engineer', '1000', '', '0000', '0000', '0000', '1000', '0000', '0000', '1000', '0000', 'active'),
(13, 'SUPER_ADMIN', 'Super Admin', '1000', '1111', '1111', '1111', '1111', '1111', '1111', '1111', '1000', '1111', 'active'),
(16, 'NO_ROLE', 'No Role', '0000', '0000', '0000', '0000', '0000', '0000', '0000', '0000', '0000', '0000', 'active');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `connections`
--
ALTER TABLE `connections`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `data_archive`
--
ALTER TABLE `data_archive`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_rule_data` (`rule_id`,`data_id`);

--
-- Indexes for table `entities`
--
ALTER TABLE `entities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rules`
--
ALTER TABLE `rules`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `scheduler_state`
--
ALTER TABLE `scheduler_state`
  ADD PRIMARY KEY (`rule_id`);

--
-- Indexes for table `system`
--
ALTER TABLE `system`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_role`
--
ALTER TABLE `user_role`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `connections`
--
ALTER TABLE `connections`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `data_archive`
--
ALTER TABLE `data_archive`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=183;

--
-- AUTO_INCREMENT for table `entities`
--
ALTER TABLE `entities`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `rules`
--
ALTER TABLE `rules`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `system`
--
ALTER TABLE `system`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `user_role`
--
ALTER TABLE `user_role`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
