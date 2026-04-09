-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Mar 27, 2025 at 07:17 PM
-- Server version: 8.0.35
-- PHP Version: 8.2.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dbApprise`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbEvent`
--

CREATE TABLE `tbEvent` (
  `eventID` int NOT NULL,
  `name` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `date` date NOT NULL,
  `description` varchar(1000) NOT NULL,
  `imagename` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tbEvent`
--

INSERT INTO `tbEvent` (`eventID`, `name`, `date`, `description`, `imagename`) VALUES
(16, 'Apprize Premier League', '2024-12-01', 'The Apprize Premier League (APL) is an intra-institution cricket league designed to promote sportsmanship, teamwork, and a stronger bond between students and teachers. In this league, students and teachers form mixed teams and compete in a series of cricket matches, fostering a sense of unity and fun.', 'APL.jpeg,APL7.jpeg,APL6.jpeg,APL5.jpeg,APL4.jpeg,APL3.jpeg,APL2.jpeg,APL1.jpeg'),
(23, 'GARBHA', '2024-10-03', 'The Garba Night event was one such opportunity where education met vibrant tradition, bringing students, teachers, and the community together. The evening was filled with spirited dancing to traditional Gujarati folk songs, laughter, and joy. The participants showcased their vibrant attire, swirling lehengas, and dandiya sticks, making it a mesmerising spectacle. Our primary goal was to create a sense of unity and cultural pride among students, which was clearly reflected in the enthusiasm of all attendees.', 'garbha2.jpeg,Garbha1.jpeg,garbha4.jpeg,Garbha3.jpeg,garbha5.jpeg,Garbha6.jpeg'),
(26, 'Trekking', '2025-01-02', 'This was a wonderful event!', 'trek.jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `tbProgress`
--

CREATE TABLE `tbProgress` (
  `id` int NOT NULL,
  `studentID` int NOT NULL,
  `Name` varchar(250) NOT NULL,
  `Subject` varchar(50) NOT NULL,
  `Grade` varchar(10) NOT NULL,
  `attendanceP` decimal(5,2) NOT NULL,
  `Remarks` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tbProgress`
--

INSERT INTO `tbProgress` (`id`, `studentID`, `Name`, `Subject`, `Grade`, `attendanceP`, `Remarks`) VALUES
(1, 1, 'komal@gmail.com', 'English', '90', 44.44, 'WOW'),
(4, 1, 'komal@gmail.com', 'Math', '79', 98.00, 'Very Goooodddd');

-- --------------------------------------------------------

--
-- Table structure for table `tbResource`
--

CREATE TABLE `tbResource` (
  `ID` int NOT NULL,
  `subjectID` int NOT NULL,
  `resourceName` varchar(100) NOT NULL,
  `fileName` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `createdAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tbResource`
--

INSERT INTO `tbResource` (`ID`, `subjectID`, `resourceName`, `fileName`, `createdAt`) VALUES
(33, 1, 'Timetable', 'TT.jpg', '2024-12-10 04:07:13'),
(35, 2, 'Maths Formula booklet', 'Formula booklet MATHS.pdf', '2025-01-30 09:42:28'),
(41, 1, 'List of connectors', 'list_of_connectors.pdf', '2025-01-30 10:36:03');

-- --------------------------------------------------------

--
-- Table structure for table `tbSubject`
--

CREATE TABLE `tbSubject` (
  `SubjectID` int NOT NULL,
  `Name` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tbSubject`
--

INSERT INTO `tbSubject` (`SubjectID`, `Name`) VALUES
(1, 'English'),
(2, 'Math'),
(3, 'Economics'),
(4, 'Accounts');

-- --------------------------------------------------------

--
-- Table structure for table `tbTimetable`
--

CREATE TABLE `tbTimetable` (
  `id` int NOT NULL,
  `day` varchar(50) NOT NULL,
  `subject` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tbTimetable`
--

INSERT INTO `tbTimetable` (`id`, `day`, `subject`) VALUES
(31, 'mon', 'Math'),
(32, 'mon', 'Economics'),
(33, 'mon', 'Math'),
(34, 'tue', 'Math'),
(35, 'tue', 'Economics'),
(36, 'tue', 'English'),
(37, 'wed', 'Economics'),
(38, 'wed', 'English'),
(39, 'wed', 'Accounts'),
(40, 'thu', 'Math'),
(41, 'thu', 'Economics'),
(42, 'thu', 'Accounts'),
(43, 'fri', 'Economics'),
(44, 'fri', 'Accounts'),
(45, 'fri', 'Math');

-- --------------------------------------------------------

--
-- Table structure for table `tbUsers`
--

CREATE TABLE `tbUsers` (
  `id` int NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `status` enum('admin','teacher','student') NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tbUsers`
--

INSERT INTO `tbUsers` (`id`, `email`, `password`, `status`, `createdAt`) VALUES
(1, 'komal@gmail.com', 'secret', 'student', '2024-08-02 12:42:46'),
(6, 'parakhkomal3@gmail.com', 'secret', 'admin', '2024-12-09 13:19:35');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbEvent`
--
ALTER TABLE `tbEvent`
  ADD PRIMARY KEY (`eventID`);

--
-- Indexes for table `tbProgress`
--
ALTER TABLE `tbProgress`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbResource`
--
ALTER TABLE `tbResource`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tbSubject`
--
ALTER TABLE `tbSubject`
  ADD PRIMARY KEY (`SubjectID`);

--
-- Indexes for table `tbTimetable`
--
ALTER TABLE `tbTimetable`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbUsers`
--
ALTER TABLE `tbUsers`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbEvent`
--
ALTER TABLE `tbEvent`
  MODIFY `eventID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `tbProgress`
--
ALTER TABLE `tbProgress`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbResource`
--
ALTER TABLE `tbResource`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `tbSubject`
--
ALTER TABLE `tbSubject`
  MODIFY `SubjectID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbTimetable`
--
ALTER TABLE `tbTimetable`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT for table `tbUsers`
--
ALTER TABLE `tbUsers`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
