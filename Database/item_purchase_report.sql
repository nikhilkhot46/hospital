-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 12, 2018 at 03:05 PM
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
-- Structure for view `item_purchase_report`
--

CREATE ALGORITHM=UNDEFINED  VIEW `item_purchase_report`  AS  select `item_purchase`.`purchase_date` AS `purchase_date`,`item_purchase`.`chalan_no` AS `chalan_no`,`item_purchase`.`supplier_id` AS `supplier_id`,`item_purchase_details`.`purchase_detail_id` AS `purchase_detail_id`,`item_purchase_details`.`purchase_id` AS `purchase_id`,`item_purchase_details`.`item_id` AS `item_id`,`item_purchase_details`.`quantity` AS `quantity`,`item_purchase_details`.`rate` AS `rate`,`item_purchase_details`.`total_amount` AS `total_amount`,`item_purchase_details`.`status` AS `status` from (`item_purchase_details` left join `item_purchase` on((`item_purchase_details`.`purchase_id` = `item_purchase`.`purchase_id`))) ;

--
-- VIEW  `item_purchase_report`
-- Data: None
--

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
