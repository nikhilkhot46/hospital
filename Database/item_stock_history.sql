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
-- Structure for view `item_stock_history`
--

CREATE ALGORITHM=UNDEFINED  VIEW `item_stock_history`  AS  select `invoice`.`date` AS `vdate`,`invoice_details`.`product_id` AS `product_id`,sum(`invoice_details`.`quantity`) AS `sell`,0 AS `Purchase` from (`invoice_details` join `invoice` on((`invoice_details`.`invoice_id` = `invoice`.`invoice_id`))) group by `invoice_details`.`product_id`,`invoice`.`date` union select `item_purchase`.`purchase_date` AS `purchase_date`,`item_purchase_details`.`item_id` AS `item_id`,0 AS `0`,sum(`item_purchase_details`.`quantity`) AS `purchase` from (`item_purchase_details` join `item_purchase` on((`item_purchase_details`.`purchase_id` = `item_purchase`.`purchase_id`))) group by `item_purchase_details`.`item_id`,`item_purchase`.`purchase_date` ;

--
-- VIEW  `item_stock_history`
-- Data: None
--

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
