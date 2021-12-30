-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 05, 2019 at 08:33 AM
-- Server version: 10.1.37-MariaDB
-- PHP Version: 7.3.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mysqldatamanager`
--

-- --------------------------------------------------------

--
-- Table structure for table `buyer`
--

CREATE TABLE `buyer` (
  `buyer_name` varchar(255) NOT NULL,
  `buying_date` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `buyer`
--

INSERT INTO `buyer` (`buyer_name`, `buying_date`) VALUES
('4', '2019-08-07'),
('ASD', '2019-08-20'),
('d', '2019-08-13'),
('ds', '2019-08-07'),
('gg', '2019-08-07'),
('ggg', '2019-08-13'),
('test', '2019-08-20'),
('vj', '2019-08-07'),
('z', '2019-08-07');

-- --------------------------------------------------------

--
-- Table structure for table `country`
--

CREATE TABLE `country` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `shortDesc` text NOT NULL,
  `longDesc` longtext NOT NULL,
  `quantity` int(11) NOT NULL,
  `expiryDate` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `country`
--

INSERT INTO `country` (`id`, `name`, `shortDesc`, `longDesc`, `quantity`, `expiryDate`) VALUES
(23, 'Khanpur', 'shor', 'long', 200, '2020-12-01'),
(27, 'Karachi', 'short', 'long', 200, '2020-2-01'),
(28, 'Peshawar', 'short', 'long', 200, '2020-1-01'),
(29, 'Panadoll', 'abc', 'abc', 0, '2020-3-01'),
(45, 'Quetta', 'short', 'long', 345, '2019-12-27'),
(46, 'Multan', 'short', 'long', 345, '2020-01-18'),
(47, 'KTS', 'short', 'long', 435, '2020-02-27'),
(49, 'qwe', 'qwe', 'ewq', 435, '2019-12-19'),
(50, 'test1', 'short', 'long', 123, '2019-07-27'),
(51, 'test2', 'short', 'long', 123, '2019-07-18');

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `userId` varchar(255) NOT NULL,
  `userPwd` varchar(255) NOT NULL,
  `userType` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`userId`, `userPwd`, `userType`) VALUES
('irfan', '123', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `productlist`
--

CREATE TABLE `productlist` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `exp_date` varchar(50) NOT NULL,
  `pack_size` varchar(50) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` float NOT NULL,
  `purchase_price` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `productlist`
--

INSERT INTO `productlist` (`product_id`, `product_name`, `exp_date`, `pack_size`, `quantity`, `price`, `purchase_price`) VALUES
(15, 'Aczofena 100mg', '2021-01-01', '10', 767, 4.391, 3.73235),
(16, 'augmentin 375mg', '2021-03-01', '6', 4, 14323.8, 20.2583),
(17, 'augmentin 1000mg', '2021-02-01', '6', 5, 182.83, 155155),
(19, 'Augmentin 625mg', '2021-03-01', '6', 5, 164, 139139),
(20, 'Arical d', '2021-04-01', '20', 21, 245, 90),
(22, 'Azifine 250mg', '2021-04-01', '6', 45, 153, 0),
(23, 'Axifen 50mg', '2021-04-01', '2*10', 42, 71.25, 0),
(24, 'Axifen SR', '2021-04-01', '10*3', 40, 200, 40),
(25, 'Anafortan plus', '2024-04-01', '3*10', 90, 14.6357, 12.4404),
(26, 'Adicobal 1ml', '2020-01-01', '10', 40, 460, 0),
(27, 'Azitma 250mg', '2000-12-01', '6', 5, 150, 127.5),
(28, 'Azitma 500mg', '2020-11-01', '6', 6, 45, 38.25),
(29, 'Arnil 50', '2024-02-01', '20', 120, 3.75, 3.1875),
(30, 'angised 0.5mg', '2021-03-01', '10*6', 20, 0.890833, 0.752083),
(31, 'Bestrix 250mg IV', '2023-04-01', '1', 6, 85, 65.6818),
(32, 'Bestrix 500mg IM', '2021-04-01', '1', 7, 145, 112.454),
(33, 'BESTRIX 250MG IM', '2021-04-01', '1', 9, 85, 65.6818),
(34, 'Bestrix 1000mg IV', '2020-12-01', '1', 5, 240, 185.455),
(35, 'BEFIAM 75mg', '2022-04-01', '10*2', 260, 5, 0.9),
(36, 'Bisleri tab', '2021-03-01', '10', 20, 101.16, 85.966),
(37, 'Brufen plus tab', '2020-07-17', '10*2', 30, 6.2975, 5.35288),
(38, 'Benzibiotic IM Inj', '2022-04-01', '1', 6, 31.61, 26.8685),
(39, 'Bactil 500mg cap', '2021-02-01', '12', 132, 210, 0),
(40, 'Bexacim 400mg', '2021-11-01', '5', 40, 325, 0),
(41, 'Cefradin 500mg cap', '2021-01-01', '12', 144, 170, 0),
(42, 'calamox 375mg cap', '2021-03-01', '6', 48, 97.62, 82.977),
(43, 'calamox 625mg', '2021-03-01', '6', 30, 142.89, 121.456),
(44, 'calbond D oral inj', '2021-03-01', '1', 5, 110, 0),
(45, 'Cephgen 1 500mg cap', '2021-08-01', '12', 132, 176.02, 149.617),
(46, 'CP Zaf 250mg tab', '2023-03-01', '10', 20, 81.14, 68.979),
(47, 'Codli-AD Cap', '2020-09-01', '120', 8, 293.15, 249.178),
(48, 'Capoten 25mg tab', '2022-01-01', '20', 9, 7.888, 6.7048),
(49, 'Citanew 10mg tab', '2021-03-01', '14', 14, 21.0714, 17.9107),
(50, 'Cefim 400mg Cap', '2021-01-01', '5', 5, 69.146, 58.7741),
(51, 'Conzyme 5mg tab ', '2021-12-01', '20', 20, 5.5, 4.675),
(52, 'Conzyme 15mg tab', '2021-12-01', '20', 20, 14.5, 12.325),
(53, 'Conzyme 10mg tab', '2022-01-01', '20', 20, 9.75, 8.2875),
(54, 'Cal One D Tab', '2021-04-01', '30', 310, 8.18133, 6.95413),
(55, 'Cefiget 400mg Cap', '2020-08-01', '5', 35, 67.2, 57.12);

-- --------------------------------------------------------

--
-- Table structure for table `sellingrecord`
--

CREATE TABLE `sellingrecord` (
  `buyer_name` varchar(255) NOT NULL,
  `buying_date` varchar(255) NOT NULL,
  `p_name` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `rate` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sellingrecord`
--

INSERT INTO `sellingrecord` (`buyer_name`, `buying_date`, `p_name`, `quantity`, `amount`, `rate`) VALUES
('vj', '2019-08-07', 'panadoll', 10, 34, 300),
('gg', '2019-08-07', 'augmentin 1000mg', 1, 183, 183),
('ds', '2019-08-07', 'augmentin 375mg', 1, 143, 143),
('4', '2019-08-07', 'augmentin 375mg', 4, 572, 143),
('z', '2019-08-07', 'Aczofena 100mg', 10, 40, 4),
('ASD', '2019-08-20', 'augmentin 1000mg', 3, 546, 182),
('test', '2019-08-20', 'Aczofena 100mg', 1, 4, 4),
('test', '2019-08-20', 'augmentin 375mg', 1, 14323, 14323),
('test', '2019-08-20', 'augmentin 1000mg', 1, 182, 182),
('test', '2019-08-20', 'Augmentin 625mg', 1, 164, 164),
('test', '2019-08-20', 'Arical d', 1, 245, 245);

-- --------------------------------------------------------

--
-- Table structure for table `tmp`
--

CREATE TABLE `tmp` (
  `tmp_name` varchar(255) NOT NULL,
  `tmp_quantity` int(11) NOT NULL,
  `tmp_rate` int(11) NOT NULL,
  `tmp_amount` int(11) NOT NULL,
  `tmp_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `buyer`
--
ALTER TABLE `buyer`
  ADD PRIMARY KEY (`buyer_name`,`buying_date`);

--
-- Indexes for table `country`
--
ALTER TABLE `country`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`userId`);

--
-- Indexes for table `productlist`
--
ALTER TABLE `productlist`
  ADD PRIMARY KEY (`product_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `country`
--
ALTER TABLE `country`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `productlist`
--
ALTER TABLE `productlist`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
