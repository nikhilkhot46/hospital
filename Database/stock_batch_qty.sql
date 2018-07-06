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
-- Structure for view `stock_batch_qty`
--

CREATE ALGORITHM=UNDEFINED  VIEW `stock_batch_qty`  AS  select `invoice_details`.`batch_id` AS `batch_id`,`invoice_details`.`product_id` AS `product_id`,sum(`invoice_details`.`quantity`) AS `sell`,0 AS `Purchase`,0 AS `expeire_date` from `invoice_details` group by `invoice_details`.`batch_id`,`invoice_details`.`product_id` union select `product_purchase_details`.`batch_id` AS `batch_id`,`product_purchase_details`.`product_id` AS `product_id`,0 AS `Sell`,sum(`product_purchase_details`.`quantity`) AS `purchase`,`product_purchase_details`.`expeire_date` AS `expeire_date` from `product_purchase_details` group by `product_purchase_details`.`batch_id`,`product_purchase_details`.`product_id` ;

--
-- VIEW  `stock_batch_qty`
-- Data: None
--

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
