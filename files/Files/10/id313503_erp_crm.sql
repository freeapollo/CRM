-- phpMyAdmin SQL Dump
-- version 4.6.5.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 28, 2016 at 08:46 PM
-- Server version: 10.1.18-MariaDB
-- PHP Version: 7.0.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `id313503_erp_crm`
--

-- --------------------------------------------------------

--
-- Table structure for table `company`
--

CREATE TABLE `company` (
  `id` int(11) NOT NULL,
  `name` varchar(450) DEFAULT NULL,
  `areaOfWork` varchar(450) DEFAULT NULL,
  `establised` varchar(450) DEFAULT NULL,
  `employees` varchar(450) DEFAULT NULL,
  `revenue` varchar(450) DEFAULT NULL,
  `ofcAddress` varchar(450) DEFAULT NULL,
  `email` varchar(450) DEFAULT NULL,
  `phone` varchar(450) DEFAULT NULL,
  `logo` varchar(450) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `company`
--

INSERT INTO `company` (`id`, `name`, `areaOfWork`, `establised`, `employees`, `revenue`, `ofcAddress`, `email`, `phone`, `logo`) VALUES
(1, 'IBM', 'Technology', '1992', '156230', '$52468263545', 'Seatle, Chicago, US', 'support@ibm.com', '88989998899', 'cdn/Images/Ibm.jpg'),
(2, 'Apple', 'Computers', '1972', '1245230', '$1245512514213', 'YorkShire, London', 'support@apple.com', '89855458562', 'cdn/Imegs/Apple.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE `employee` (
  `id` int(11) NOT NULL,
  `name` varchar(450) DEFAULT NULL,
  `title` varchar(450) DEFAULT NULL,
  `industry` varchar(450) DEFAULT NULL,
  `location` varchar(450) DEFAULT NULL,
  `ratings` varchar(45) DEFAULT NULL,
  `companyId` varchar(45) DEFAULT NULL,
  `company` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`id`, `name`, `title`, `industry`, `location`, `ratings`, `companyId`, `company`) VALUES
(1, 'Sam Bay', 'Project Manager', 'Finance', 'New York', '4.5', '1', 'IBM'),
(2, 'Bob Robson', 'Engineer', 'Development', 'Chicago', '5.0', '1', 'IBM'),
(3, 'John Boo', 'Investor', 'Health tech', 'London', '5.0', '2', 'Apple'),
(4, 'Bob Kennedy', 'Director', 'Finance', 'Madrid', '4.5', '2', 'Apple');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `name` varchar(450) DEFAULT NULL,
  `department` varchar(455) DEFAULT NULL,
  `hireDate` varchar(450) DEFAULT NULL,
  `dob` varchar(450) DEFAULT NULL,
  `gender` varchar(450) DEFAULT NULL,
  `homeAddress` varchar(450) DEFAULT NULL,
  `email` varchar(450) DEFAULT NULL,
  `phone` varchar(45) DEFAULT NULL,
  `profilePic` varchar(450) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `department`, `hireDate`, `dob`, `gender`, `homeAddress`, `email`, `phone`, `profilePic`) VALUES
(1, 'Sherlocks J', 'Comp', '12-10-2014', '10-12-1988', 'Male', 'New homes.404, Drive Throu', 'sherlocks@gmail.com', '899889895', 'cdn/images/user_1.jpg'),
(2, 'Diana P', 'Engineering', '12-05-2015', '10-12-1978', 'Female', 'Drives D-420, New York', 'diana@gmail.com', '8985858696', 'cdn/images/user_2.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `company`
--
ALTER TABLE `company`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `company`
--
ALTER TABLE `company`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `employee`
--
ALTER TABLE `employee`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
