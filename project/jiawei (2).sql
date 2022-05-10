-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: May 10, 2022 at 01:39 AM
-- Server version: 5.7.36
-- PHP Version: 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `jiawei`
--

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

DROP TABLE IF EXISTS `customers`;
CREATE TABLE IF NOT EXISTS `customers` (
  `username` varchar(55) NOT NULL,
  `customer_id` int(255) NOT NULL AUTO_INCREMENT,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `firstname` varchar(55) NOT NULL,
  `lastname` varchar(55) NOT NULL,
  `dob` date NOT NULL,
  `gender` enum('male','female','other') NOT NULL,
  `status` enum('active','deactivate') NOT NULL,
  `cust_image` varchar(255) DEFAULT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`customer_id`)
) ENGINE=InnoDB AUTO_INCREMENT=72 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`username`, `customer_id`, `password`, `email`, `firstname`, `lastname`, `dob`, `gender`, `status`, `cust_image`, `created`, `modified`) VALUES
('jameswoo', 55, '42f749ade7f9e195bf475f37a44cafcb', 'Password123@gmail.com', 'James', 'Woo', '1998-05-02', 'male', 'active', NULL, '2022-04-26 22:48:05', '2022-05-09 17:19:39'),
('peiein', 66, '725cb1b9cc08d80ac0f1f1744dcc02f0', 'Peiein822@gmail.com', 'Pei', 'Ein', '1990-04-02', 'female', 'active', '159c434164d8b1ac71beddbeb32ac2777754d13e-peiein.jpg', '2022-05-10 00:44:58', '2022-05-09 16:53:37'),
('jiawei', 67, '87fb81ff2cfdbd55b85e644895f3fee1', 'JiaWei328@gmail.com', 'Jia', 'Wei', '1991-06-15', 'female', 'active', '6ddb2caff679fae303db7f3e511b34668d29e64d-jiawei.jpg', '2022-05-10 01:00:29', '2022-05-09 17:00:29'),
('munteng', 68, '19bd342a7c33a3b07dad5152cecdd513', 'Mt123bloop@gmail.com', 'Mun', 'Teng', '1996-04-11', 'male', 'active', 'e3a58dfa137029a7cf2b1d658bf7a345704b593a-munteng.jpg', '2022-05-10 01:02:14', '2022-05-09 17:02:14'),
('esther', 69, '377ff91667eccb84fb69bf05c3032c16', 'Esther890@gmail.com', 'Esther', 'Yo', '1997-03-05', 'female', 'active', 'f8b545f2b2ec43843cfadaf43e16647da5e230f4-esther.jpg', '2022-05-10 01:03:27', '2022-05-09 17:03:27'),
('samantha', 70, '64dc43daa0c6d0d600c4fa72f7c4bac3', 'Sam895tha@gmail.com', 'Samantha', 'Yuu', '1999-03-03', 'female', 'deactivate', '5a9f02abab49d7203d4ce71533bb3950acc7480a-samantha.jpg', '2022-05-10 01:05:38', '2022-05-09 17:05:38'),
('meihong', 71, '4b22f80ab8682a05177647aba99d75e7', 'MeiHong253@gmail.com', 'Mei', 'Hong', '1997-08-13', 'other', 'active', '81300349b3d7eeea51a78ef304a88e5c83338377-meihong.jpg', '2022-05-10 01:13:26', '2022-05-09 17:13:26');

-- --------------------------------------------------------

--
-- Table structure for table `orderdetail`
--

DROP TABLE IF EXISTS `orderdetail`;
CREATE TABLE IF NOT EXISTS `orderdetail` (
  `orderdetail_id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  PRIMARY KEY (`orderdetail_id`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `orderdetail`
--

INSERT INTO `orderdetail` (`orderdetail_id`, `order_id`, `product_id`, `quantity`) VALUES
(1, 1, 4, 2),
(2, 1, 121, 5),
(3, 1, 13, 1),
(4, 2, 117, 3),
(5, 2, 112, 8),
(6, 3, 114, 7),
(7, 6, 118, 3),
(8, 7, 113, 15),
(9, 7, 114, 2),
(10, 7, 117, 1),
(11, 7, 121, 4),
(12, 7, 13, 5),
(13, 8, 13, 3),
(14, 8, 113, 8),
(15, 8, 118, 1),
(16, 8, 121, 1),
(17, 9, 114, 1),
(18, 9, 4, 5),
(19, 10, 4, 3),
(20, 11, 13, 5),
(21, 11, 113, 8),
(22, 12, 117, 2),
(23, 13, 113, 1),
(24, 13, 114, 3),
(25, 13, 121, 8),
(26, 14, 117, 5),
(27, 14, 113, 10),
(28, 14, 121, 2),
(29, 14, 114, 8),
(30, 14, 13, 5),
(31, 14, 4, 2),
(32, 15, 113, 2),
(33, 15, 118, 1);

-- --------------------------------------------------------

--
-- Table structure for table `ordersummary`
--

DROP TABLE IF EXISTS `ordersummary`;
CREATE TABLE IF NOT EXISTS `ordersummary` (
  `order_id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(255) NOT NULL,
  `orderdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`order_id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ordersummary`
--

INSERT INTO `ordersummary` (`order_id`, `customer_id`, `orderdate`, `modified`) VALUES
(1, 55, '2022-05-09 17:50:01', '2022-05-09 17:50:01'),
(2, 55, '2022-05-09 17:51:09', '2022-05-09 17:51:09'),
(3, 55, '2022-05-09 17:51:33', '2022-05-09 17:51:33'),
(6, 55, '2022-05-09 17:52:58', '2022-05-09 17:52:58'),
(7, 71, '2022-05-09 18:21:14', '2022-05-09 18:21:14'),
(8, 68, '2022-05-09 18:22:19', '2022-05-09 18:22:19'),
(9, 68, '2022-05-09 18:22:41', '2022-05-09 18:22:41'),
(10, 67, '2022-05-09 18:22:56', '2022-05-09 18:22:56'),
(11, 67, '2022-05-09 18:23:10', '2022-05-09 18:23:10'),
(12, 67, '2022-05-09 18:23:17', '2022-05-09 18:23:17'),
(13, 67, '2022-05-09 18:23:37', '2022-05-09 18:23:37'),
(14, 66, '2022-05-09 18:24:30', '2022-05-09 18:24:30'),
(15, 66, '2022-05-09 18:24:53', '2022-05-09 18:24:53');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  `description` text NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `product_image` varchar(255) DEFAULT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=130 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `product_image`, `created`, `modified`) VALUES
(4, 'Eye Glasses', 'It will make you read better.', '6.00', '', '2015-08-02 12:15:04', '2015-08-05 22:59:18'),
(13, 'Scissors', 'An instrument used for cutting cloth, paper, and other material', '6.00', 'scissor.jpg', '2022-04-14 15:16:50', '2022-05-09 17:18:50'),
(112, 'Basketball', 'A ball used in the NBA', '49.10', 'df758a2c72df210452092504a44f1cdcadfeeacc-Basketball.png', '2022-05-09 17:16:27', '2022-05-09 17:16:53'),
(113, 'Pencil', 'To write on paper', '2.20', 'e7b64683cdc6b45a52f1f55fe87e1350387ce6f6-pencil.jpg', '2022-05-09 17:18:35', '2022-05-09 17:18:43'),
(114, 'Gatorade', 'Good drink for athletes.', '2.50', '1ba4a07e5ed8a7046629e5646c1440f13423a6a0-gatorade.jpg', '2022-05-09 17:21:30', '2022-05-09 17:37:32'),
(117, 'Trash Can', 'Help to maintain cleanliness.', '20.90', '006d50ad75d4cf7b25aa352dcb564dfb02502107-trashcan.jpg', '2022-05-09 17:32:34', '2022-05-09 17:32:34'),
(118, 'Earphone', 'For music lover.', '5.60', '521d6e04ee8f7fa289e98f802707a931f853eb03-earphone.jpg', '2022-05-09 17:33:21', '2022-05-09 17:33:21'),
(119, 'Eraser', 'Rub out something written.', '1.50', 'e162aebd92b0f44561d60faa548998f5900d0b04-eraser.jpg', '2022-05-09 17:35:24', '2022-05-09 17:35:24'),
(120, 'Pillow', 'Sleeping well is important.', '30.80', 'a0c7089dfec0af3ef63651d0f514c10b499feefe-pillow.jpeg', '2022-05-09 17:35:56', '2022-05-09 17:35:56'),
(121, 'Mouse', 'Very useful if you love your computer.', '15.20', '0f3548687e832aa56469bc2de1c27c6bb449869f-mouse.jpg', '2022-05-09 17:37:19', '2022-05-09 17:37:19');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
