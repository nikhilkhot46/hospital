-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 12, 2018 at 03:06 PM
-- Server version: 10.1.30-MariaDB
-- PHP Version: 5.6.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hospital`
--

-- --------------------------------------------------------

--
-- Structure for view `sales_actual`
--

CREATE ALGORITHM=UNDEFINED  VIEW `sales_actual`  AS  select `sales_report`.`date` AS `DATE`,`sales_report`.`supplier_id` AS `supplier_id`,sum((`sales_report`.`quantity` * -(`sales_report`.`supplier_rate`))) AS `sub_total`,sum(`sales_report`.`cartoon`) AS `no_transection` from `sales_report` group by `sales_report`.`date`,`sales_report`.`supplier_id` union all select `supplier_ledger`.`date` AS `date`,`supplier_ledger`.`supplier_id` AS `supplier_id`,`supplier_ledger`.`amount` AS `sub_total`,`supplier_ledger`.`description` AS `no_transection` from `supplier_ledger` where isnull(`supplier_ledger`.`chalan_no`) group by `supplier_ledger`.`date`,`supplier_ledger`.`description`,`supplier_ledger`.`supplier_id` ;

--
-- VIEW  `sales_actual`
-- Data: None
--

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
