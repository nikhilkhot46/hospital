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
-- Structure for view `product_supplier`
--

CREATE ALGORITHM=UNDEFINED  VIEW `product_supplier`  AS  select `b`.`product_id` AS `product_id`,`c`.`product_name` AS `product_name`,`c`.`product_model` AS `product_model`,`a`.`supplier_id` AS `supplier_id` from ((`product_purchase` `a` join `product_purchase_details` `b`) join `product_information` `c`) where ((`a`.`purchase_id` = `b`.`purchase_id`) and (convert(`c`.`product_id` using utf8) = `b`.`product_id`)) group by `b`.`product_id` ;

--
-- VIEW  `product_supplier`
-- Data: None
--

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
