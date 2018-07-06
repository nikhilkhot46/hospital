-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 12, 2018 at 03:07 PM
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
-- Structure for view `view_customer_transection`
--

CREATE ALGORITHM=UNDEFINED  VIEW `view_customer_transection`  AS  (select `i`.`transaction_id` AS `transaction_id`,`j`.`firstname` AS `customer_name`,`q`.`invoice_no` AS `invoice_no` from ((`transection` `i` left join `patient` `j` on((convert(`i`.`relation_id` using utf8) = `j`.`patient_id`))) left join `customer_ledger` `q` on((convert(`i`.`transaction_id` using utf8) = `q`.`transaction_id`)))) ;

--
-- VIEW  `view_customer_transection`
-- Data: None
--

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
