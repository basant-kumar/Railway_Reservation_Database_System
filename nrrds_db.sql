-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 12, 2016 at 01:09 PM
-- Server version: 10.1.10-MariaDB
-- PHP Version: 7.0.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `nrrds`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `p1` ()  BEGIN
	SELECT *  from user_profile;
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `search_trains` (IN `train_no` INTEGER(10))  begin

SELECT * FROM trains;


END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `emp`
--

CREATE TABLE `emp` (
  `eid` int(11) NOT NULL,
  `name` varchar(11) NOT NULL,
  `sal` int(11) NOT NULL,
  `dno` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `emp`
--

INSERT INTO `emp` (`eid`, `name`, `sal`, `dno`) VALUES
(1, 'basant', 1342, 23),
(2, 'avd', 1000, 10),
(3, 'doggy', -1002, 20),
(4, 'bkm', -5000, 15),
(2, 'avd', 1000, 10),
(3, 'doggy', -1002, 20),
(4, 'bkm', -5000, 15);

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE `members` (
  `memberID` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `active` varchar(255) NOT NULL,
  `resetToken` varchar(255) DEFAULT NULL,
  `resetComplete` varchar(3) DEFAULT 'No'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `passenger`
--

CREATE TABLE `passenger` (
  `PNR_no` int(10) DEFAULT NULL,
  `p_name` varchar(30) DEFAULT NULL,
  `age` int(10) DEFAULT NULL,
  `Gender` varchar(10) DEFAULT NULL,
  `seat_no` varchar(10) DEFAULT NULL,
  `coach` varchar(10) DEFAULT NULL,
  `t_status` varchar(10) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `schedule`
--

CREATE TABLE `schedule` (
  `train_no` int(10) DEFAULT NULL,
  `stn_code` varchar(10) DEFAULT NULL,
  `arrival_time` time DEFAULT NULL,
  `departure_time` time DEFAULT NULL,
  `dist_so_far` int(10) DEFAULT NULL,
  `fair_so_far` int(10) DEFAULT NULL,
  `current_day` int(10) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `schedule`
--

INSERT INTO `schedule` (`train_no`, `stn_code`, `arrival_time`, `departure_time`, `dist_so_far`, `fair_so_far`, `current_day`) VALUES
(12345, 'JU', NULL, '19:00:00', 0, 0, 0),
(12345, 'MTD', '20:14:00', '20:35:00', 102, 100, 0),
(12345, 'Dna', '21:08:00', '21:11:00', 146, 200, 0),
(12345, 'MKN', '21:46:00', '21:48:00', 190, 300, 0),
(12345, 'JP', '00:15:00', '00:25:00', 310, 400, 1),
(12345, 'AWR', '02:20:00', '02:30:00', 460, 500, 1),
(12345, 'DEC', '05:06:00', NULL, 604, 600, 1);

-- --------------------------------------------------------

--
-- Table structure for table `stations`
--

CREATE TABLE `stations` (
  `stn_code` varchar(10) NOT NULL,
  `stn_name` varchar(30) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `stations`
--

INSERT INTO `stations` (`stn_code`, `stn_name`) VALUES
('JU', 'Jodhpur Junction'),
('MTD', 'Merta Road Junction'),
('DNA', 'Degana Junction'),
('MKN', 'Makrana Junction'),
('JP', 'Jaipur Junction'),
('AWR', 'Alwar Junction'),
('DEC', 'Delhi');

-- --------------------------------------------------------

--
-- Table structure for table `status`
--

CREATE TABLE `status` (
  `train_no` int(10) DEFAULT NULL,
  `category` varchar(10) DEFAULT NULL,
  `total_seats` int(10) DEFAULT NULL,
  `booked_seats` int(10) DEFAULT NULL,
  `no_of_coaches` int(10) DEFAULT NULL,
  `available_date` date DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE `tickets` (
  `PNR_no` int(10) NOT NULL,
  `train_no` int(10) DEFAULT NULL,
  `User_name` varchar(30) DEFAULT NULL,
  `t_from` varchar(30) DEFAULT NULL,
  `t_to` varchar(30) DEFAULT NULL,
  `doj` date DEFAULT NULL,
  `t_class` varchar(10) DEFAULT NULL,
  `quota` varchar(10) DEFAULT NULL,
  `total_fair` int(10) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `trains`
--

CREATE TABLE `trains` (
  `train_no` int(10) NOT NULL,
  `train_type` varchar(30) DEFAULT NULL,
  `train_name` varchar(30) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `trains`
--

INSERT INTO `trains` (`train_no`, `train_type`, `train_name`) VALUES
(12345, 'Express', 'Rajasthan Sampark kranti expre');

-- --------------------------------------------------------

--
-- Table structure for table `trains_availability`
--

CREATE TABLE `trains_availability` (
  `train_no` int(10) DEFAULT NULL,
  `available_day` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `trains_availability`
--

INSERT INTO `trains_availability` (`train_no`, `available_day`) VALUES
(12345, 0),
(12345, 1),
(12345, 2),
(12345, 3),
(12345, 4),
(12345, 5),
(12345, 6);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(8) NOT NULL,
  `name` varchar(30) NOT NULL,
  `email` varchar(60) NOT NULL,
  `password` varchar(40) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`) VALUES
(1, 'basant kumar meena', 'basa@gmail.com', 'c755e21fd5999980e17032aacb549653'),
(2, 'basant kumar', 'basant@gmail.com', 'c755e21fd5999980e17032aacb549653');

-- --------------------------------------------------------

--
-- Table structure for table `user_profile`
--

CREATE TABLE `user_profile` (
  `User_name` varchar(30) NOT NULL,
  `passwd` varchar(30) DEFAULT NULL,
  `first_name` varchar(30) DEFAULT NULL,
  `last_name` varchar(30) DEFAULT NULL,
  `Gender` varchar(10) DEFAULT NULL,
  `email` varchar(30) DEFAULT NULL,
  `mobile` bigint(10) DEFAULT NULL,
  `dob` date DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_profile`
--

INSERT INTO `user_profile` (`User_name`, `passwd`, `first_name`, `last_name`, `Gender`, `email`, `mobile`, `dob`) VALUES
('bkm', 'bkm', 'bkm', 'bkm', 'bkm', 'bkm', 9437379453, '2016-11-16'),
('basant', 'basant', 'Basant', 'Kumar', 'male', 'basant@gmail.com', 1234567890, '2016-11-17'),
('012skp', '012skp', 'shailesh', 'kumar', 'male', '012skp@gmail.com', 1234567878, '2016-11-10');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`memberID`);

--
-- Indexes for table `passenger`
--
ALTER TABLE `passenger`
  ADD KEY `fk5` (`PNR_no`);

--
-- Indexes for table `schedule`
--
ALTER TABLE `schedule`
  ADD KEY `fk3` (`train_no`),
  ADD KEY `fk4` (`stn_code`);

--
-- Indexes for table `stations`
--
ALTER TABLE `stations`
  ADD PRIMARY KEY (`stn_code`);

--
-- Indexes for table `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`PNR_no`),
  ADD KEY `fk1` (`User_name`),
  ADD KEY `fk2` (`train_no`);

--
-- Indexes for table `trains`
--
ALTER TABLE `trains`
  ADD PRIMARY KEY (`train_no`);

--
-- Indexes for table `trains_availability`
--
ALTER TABLE `trains_availability`
  ADD KEY `fk6` (`train_no`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `user_profile`
--
ALTER TABLE `user_profile`
  ADD PRIMARY KEY (`User_name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `members`
--
ALTER TABLE `members`
  MODIFY `memberID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
