-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 17, 2023 at 10:37 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `testing`
--

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `attendanceID` int(11) NOT NULL,
  `employeeID` int(11) DEFAULT NULL,
  `managerID` varchar(255) DEFAULT NULL,
  `logdate` date NOT NULL,
  `timein` time NOT NULL,
  `timeout` time DEFAULT NULL,
  `shifttype` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`attendanceID`, `employeeID`, `managerID`, `logdate`, `timein`, `timeout`, `shifttype`) VALUES
(1, NULL, 'M1', '2023-06-13', '06:13:47', '09:15:05', '1'),
(2, NULL, 'M1', '2023-06-15', '06:27:20', '11:27:34', '1');

-- --------------------------------------------------------

--
-- Table structure for table `branch`
--

CREATE TABLE `branch` (
  `branchID` int(11) NOT NULL,
  `branchname` varchar(25) NOT NULL,
  `address` varchar(255) NOT NULL,
  `managerID` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `branch`
--

INSERT INTO `branch` (`branchID`, `branchname`, `address`, `managerID`) VALUES
(3, 'addis ababa', 'Addis Ababa, Gerji Near Unity University.', 'M1'),
(4, 'Bishoftu', 'Ethiopia,Bishoftu', 'M2');

-- --------------------------------------------------------

--
-- Table structure for table `branchmanager`
--

CREATE TABLE `branchmanager` (
  `managerID` varchar(255) NOT NULL,
  `branchID` int(11) NOT NULL,
  `managertype` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `branchmanager`
--

INSERT INTO `branchmanager` (`managerID`, `branchID`, `managertype`) VALUES
('M1', 3, 'General Manager'),
('M2', 4, 'Branch Manager');

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `departmentID` int(11) NOT NULL,
  `departmentname` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`departmentID`, `departmentname`) VALUES
(5, 'IT'),
(6, 'R&D'),
(7, 'Marketing'),
(8, 'sales'),
(9, 'manfacturing'),
(10, 'managment'),
(11, 'as');

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE `employee` (
  `employeeID` int(11) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `middlename` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `dateofbirth` date NOT NULL,
  `gender` enum('male','female') NOT NULL,
  `address` varchar(255) NOT NULL,
  `primary_phone` varchar(15) NOT NULL,
  `secondary_phone` varchar(15) NOT NULL,
  `dateofjoin` date NOT NULL,
  `education_status` varchar(255) NOT NULL,
  `employee_photo` blob NOT NULL,
  `email` varchar(255) NOT NULL,
  `employment_status` varchar(15) NOT NULL,
  `employeefile` mediumblob NOT NULL,
  `yearlyvacationdays` int(11) NOT NULL DEFAULT 16,
  `basesalary` double NOT NULL,
  `branchID` int(11) NOT NULL,
  `userID` int(11) DEFAULT NULL,
  `departmentID` int(11) NOT NULL,
  `positionID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employee_leave`
--

CREATE TABLE `employee_leave` (
  `leaveID` int(11) NOT NULL,
  `employeeID` int(11) DEFAULT NULL,
  `managerID` varchar(255) DEFAULT NULL,
  `date` date NOT NULL,
  `leavetype` varchar(50) NOT NULL,
  `startdate` date NOT NULL,
  `enddate` date NOT NULL,
  `status` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employee_leave`
--

INSERT INTO `employee_leave` (`leaveID`, `employeeID`, `managerID`, `date`, `leavetype`, `startdate`, `enddate`, `status`) VALUES
(1, NULL, 'M1', '2023-06-16', 'vacation', '2023-06-17', '2023-06-18', 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `userID` int(11) NOT NULL,
  `username` varchar(255) NOT NULL COMMENT 'email of employee',
  `password` varchar(255) NOT NULL,
  `role` enum('general manager(admin)','manger(branch manager)','employee','') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`userID`, `username`, `password`, `role`) VALUES
(1, 'kirubelast@gmail.com', '123456789', 'manger(branch manager)');

-- --------------------------------------------------------

--
-- Table structure for table `manager`
--

CREATE TABLE `manager` (
  `id` int(11) NOT NULL,
  `managerID` varchar(255) NOT NULL,
  `firstname` varchar(25) NOT NULL,
  `middlename` varchar(25) NOT NULL,
  `lastname` varchar(25) NOT NULL,
  `dateofbirth` date NOT NULL,
  `gender` enum('male','female') NOT NULL,
  `address` varchar(255) NOT NULL,
  `primary_phone` varchar(15) NOT NULL,
  `secondary_phone` varchar(15) NOT NULL,
  `dateofjoin` date NOT NULL,
  `education_status` varchar(255) NOT NULL,
  `manager_photo` longblob NOT NULL,
  `email` varchar(255) NOT NULL,
  `managerfile` blob NOT NULL,
  `yearlyvacationdays` int(11) NOT NULL DEFAULT 18,
  `basesalary` double NOT NULL,
  `userID` int(11) DEFAULT NULL,
  `departmentID` int(11) NOT NULL,
  `positionID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `manager`
--

INSERT INTO `manager` (`id`, `managerID`, `firstname`, `middlename`, `lastname`, `dateofbirth`, `gender`, `address`, `primary_phone`, `secondary_phone`, `dateofjoin`, `education_status`, `manager_photo`, `email`, `managerfile`, `yearlyvacationdays`, `basesalary`, `userID`, `departmentID`, `positionID`) VALUES
(1, 'M1', 'kirubel', 'astraye', 'dessie', '1999-12-28', 'male', 'Ethiopia,addis ababa,bole,gerji,house no 605 ', '+251946331281', '+2517', '2022-12-13', 'msc', 0x656d70312e6a7067, 'kirubelast@gmail.com', 0x436f757273657320746f20626520496e636c7564656420696e20436f6d707574657220536369656e63652045786974204578616d2e706466, 18, 25000, 1, 5, 1),
(3, 'M2', 'kaleab', 'solomon', 'mana', '1996-02-17', 'male', '   Ethiopia,bishoftu     ', '+251946331281', '+251746331281', '2022-07-17', 'msc', 0x656d70312e6a7067, 'kaleabsolomon@gmail.com', 0x436f757273657320746f20626520496e636c7564656420696e20436f6d707574657220536369656e63652045786974204578616d2e706466, 18, 20000, NULL, 10, 4);

-- --------------------------------------------------------

--
-- Table structure for table `position`
--

CREATE TABLE `position` (
  `positionID` int(11) NOT NULL,
  `departmentID` int(11) NOT NULL,
  `positionname` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `position`
--

INSERT INTO `position` (`positionID`, `departmentID`, `positionname`) VALUES
(1, 5, 'superviser'),
(2, 5, 'junior'),
(3, 10, 'general manager'),
(4, 10, 'branch manager');

-- --------------------------------------------------------

--
-- Table structure for table `qrcode`
--

CREATE TABLE `qrcode` (
  `id` int(11) NOT NULL,
  `employeeID` int(11) NOT NULL,
  `managerID` varchar(255) NOT NULL,
  `qrimage` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `salary`
--

CREATE TABLE `salary` (
  `salaryID` int(11) NOT NULL,
  `employeeID` int(11) DEFAULT NULL,
  `managerID` varchar(255) DEFAULT NULL,
  `datefrom` date NOT NULL,
  `dateto` date NOT NULL,
  `present_days` int(11) NOT NULL,
  `absent_days` int(11) NOT NULL DEFAULT 0,
  `late_days` int(11) NOT NULL,
  `salary` double NOT NULL,
  `allowance` double NOT NULL DEFAULT 0,
  `deduction` double NOT NULL DEFAULT 0,
  `net` double NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `salary`
--

INSERT INTO `salary` (`salaryID`, `employeeID`, `managerID`, `datefrom`, `dateto`, `present_days`, `absent_days`, `late_days`, `salary`, `allowance`, `deduction`, `net`, `date`) VALUES
(11, NULL, 'M1', '2023-05-15', '2023-06-14', 1, 0, 0, 0, 0, 0, 0, '2023-06-14'),
(12, NULL, 'M1', '2023-05-18', '2023-06-17', 2, 0, 0, 0, 0, 0, 0, '2023-06-17');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`attendanceID`),
  ADD KEY `employeeID` (`employeeID`),
  ADD KEY `managerID` (`managerID`);

--
-- Indexes for table `branch`
--
ALTER TABLE `branch`
  ADD PRIMARY KEY (`branchID`),
  ADD KEY `managerID` (`managerID`);

--
-- Indexes for table `branchmanager`
--
ALTER TABLE `branchmanager`
  ADD PRIMARY KEY (`managerID`,`branchID`),
  ADD KEY `branchID` (`branchID`);

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`departmentID`);

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`employeeID`),
  ADD KEY `departmentID` (`departmentID`),
  ADD KEY `branchID` (`branchID`),
  ADD KEY `userID` (`userID`),
  ADD KEY `positionID` (`positionID`);

--
-- Indexes for table `employee_leave`
--
ALTER TABLE `employee_leave`
  ADD PRIMARY KEY (`leaveID`),
  ADD KEY `employeeID` (`employeeID`),
  ADD KEY `managerID` (`managerID`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`userID`);

--
-- Indexes for table `manager`
--
ALTER TABLE `manager`
  ADD PRIMARY KEY (`managerID`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `departmentID` (`departmentID`),
  ADD KEY `positionID` (`positionID`),
  ADD KEY `userID` (`userID`);

--
-- Indexes for table `position`
--
ALTER TABLE `position`
  ADD PRIMARY KEY (`positionID`),
  ADD KEY `departmentID` (`departmentID`);

--
-- Indexes for table `qrcode`
--
ALTER TABLE `qrcode`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employeeID` (`employeeID`),
  ADD KEY `managerID` (`managerID`);

--
-- Indexes for table `salary`
--
ALTER TABLE `salary`
  ADD PRIMARY KEY (`salaryID`),
  ADD KEY `employeeID` (`employeeID`),
  ADD KEY `managerID` (`managerID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `attendanceID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `branch`
--
ALTER TABLE `branch`
  MODIFY `branchID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `department`
--
ALTER TABLE `department`
  MODIFY `departmentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `employee`
--
ALTER TABLE `employee`
  MODIFY `employeeID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `employee_leave`
--
ALTER TABLE `employee_leave`
  MODIFY `leaveID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `manager`
--
ALTER TABLE `manager`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `position`
--
ALTER TABLE `position`
  MODIFY `positionID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `qrcode`
--
ALTER TABLE `qrcode`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `salary`
--
ALTER TABLE `salary`
  MODIFY `salaryID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attendance`
--
ALTER TABLE `attendance`
  ADD CONSTRAINT `attendance_ibfk_1` FOREIGN KEY (`employeeID`) REFERENCES `employee` (`employeeID`),
  ADD CONSTRAINT `attendance_ibfk_2` FOREIGN KEY (`managerID`) REFERENCES `manager` (`managerID`);

--
-- Constraints for table `branch`
--
ALTER TABLE `branch`
  ADD CONSTRAINT `branch_ibfk_1` FOREIGN KEY (`managerID`) REFERENCES `manager` (`managerID`);

--
-- Constraints for table `branchmanager`
--
ALTER TABLE `branchmanager`
  ADD CONSTRAINT `branchmanager_ibfk_1` FOREIGN KEY (`branchID`) REFERENCES `branch` (`branchID`),
  ADD CONSTRAINT `branchmanager_ibfk_2` FOREIGN KEY (`managerID`) REFERENCES `manager` (`managerID`);

--
-- Constraints for table `employee`
--
ALTER TABLE `employee`
  ADD CONSTRAINT `employee_ibfk_1` FOREIGN KEY (`departmentID`) REFERENCES `department` (`departmentID`),
  ADD CONSTRAINT `employee_ibfk_2` FOREIGN KEY (`branchID`) REFERENCES `branch` (`branchID`),
  ADD CONSTRAINT `employee_ibfk_3` FOREIGN KEY (`userID`) REFERENCES `login` (`userID`),
  ADD CONSTRAINT `employee_ibfk_4` FOREIGN KEY (`positionID`) REFERENCES `position` (`positionID`);

--
-- Constraints for table `employee_leave`
--
ALTER TABLE `employee_leave`
  ADD CONSTRAINT `employee_leave_ibfk_1` FOREIGN KEY (`employeeID`) REFERENCES `employee` (`employeeID`),
  ADD CONSTRAINT `employee_leave_ibfk_2` FOREIGN KEY (`managerID`) REFERENCES `manager` (`managerID`);

--
-- Constraints for table `manager`
--
ALTER TABLE `manager`
  ADD CONSTRAINT `manager_ibfk_2` FOREIGN KEY (`departmentID`) REFERENCES `department` (`departmentID`),
  ADD CONSTRAINT `manager_ibfk_3` FOREIGN KEY (`positionID`) REFERENCES `position` (`positionID`),
  ADD CONSTRAINT `manager_ibfk_4` FOREIGN KEY (`userID`) REFERENCES `login` (`userID`);

--
-- Constraints for table `position`
--
ALTER TABLE `position`
  ADD CONSTRAINT `position_ibfk_1` FOREIGN KEY (`departmentID`) REFERENCES `department` (`departmentID`);

--
-- Constraints for table `qrcode`
--
ALTER TABLE `qrcode`
  ADD CONSTRAINT `qrcode_ibfk_1` FOREIGN KEY (`employeeID`) REFERENCES `employee` (`employeeID`),
  ADD CONSTRAINT `qrcode_ibfk_2` FOREIGN KEY (`managerID`) REFERENCES `manager` (`managerID`);

--
-- Constraints for table `salary`
--
ALTER TABLE `salary`
  ADD CONSTRAINT `salary_ibfk_1` FOREIGN KEY (`employeeID`) REFERENCES `employee` (`employeeID`),
  ADD CONSTRAINT `salary_ibfk_2` FOREIGN KEY (`managerID`) REFERENCES `manager` (`managerID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
