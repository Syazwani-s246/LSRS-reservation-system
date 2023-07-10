-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 17, 2023 at 10:33 AM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.0.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `s59246_lsrs2.0`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity`
--

CREATE TABLE `activity` (
  `activityId` int(11) NOT NULL,
  `activityName` varchar(200) DEFAULT NULL,
  `activityPrice` int(11) DEFAULT NULL,
  `activityImage` varchar(100) NOT NULL,
  `minPax` int(11) NOT NULL,
  `duration` int(11) NOT NULL,
  `activityDetails` mediumtext DEFAULT NULL,
  `creationDate` timestamp NULL DEFAULT current_timestamp(),
  `updationDate` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `activity`
--

INSERT INTO `activity` (`activityId`, `activityName`, `activityPrice`, `activityImage`, `minPax`, `duration`, `activityDetails`, `creationDate`, `updationDate`) VALUES
(1, 'Bengkel Batik Blok', 58, 'bengkel batik blok.jpeg', 5, 3, 'Testtt', '2023-01-24 10:13:42', '2023-06-17 02:57:14'),
(2, 'B3rbusana', 35, 'berbusana.jpeg', 5, 1, 'Maklumat', '2023-01-24 10:15:23', '2023-06-17 02:57:42'),
(3, 'Eksplorasi Lambo Sari', 50, 'lambo sari explorace.jpeg', 10, 5, 'Pelbagai aktiviti menarik di dalam satu pakej.', '2023-01-24 10:16:00', '2023-06-07 01:50:26'),
(4, 'Mewarna Batik Kit', 25, 'mewarna batik kit.jpeg', 6, 2, 'Warisan tradisional seperti mewarna Batik, pembuatan wau, mencanting batik dan tarian dapat disampaikan kepada generasi muda melalui latihan. Usaha ini memberikan peluang kepada mereka yang berminat untuk mengikutinya.', '2023-01-24 10:16:59', '2023-06-07 01:50:33'),
(5, 'Wau Batik Kit', 40, 'wau batik kit.jpeg', 5, 2, 'Cetusan idea inovasi baharu yang menggabungkan dua elemen budaya Wau dan Batik memberikan satu sinar baharu bagi memastikan warisan tersebut terus diminati oleh masyarakat. Lambo Sari, sebuah pusat budaya interaktif komuniti di Teluk Ketapang, Terengganu, mengambil langkah yang sangat proaktif dengan menghasilkan Wau Batik Kit, iaitu Wau yang dihiasi lakaran motif cantingan batik.', '2023-01-24 10:17:25', '2023-06-07 01:50:36'),
(9, 'testt', 12, 'Screenshot 2023-04-05 153549.png', 0, 0, 'makl', '2023-06-17 03:56:56', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `activityimages`
--

CREATE TABLE `activityimages` (
  `imageId` int(11) NOT NULL,
  `activityId` int(11) NOT NULL,
  `activityImage` varchar(100) NOT NULL,
  `creationDate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `userName` varchar(100) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `updationDate` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `name`, `userName`, `password`, `updationDate`) VALUES
(1, 'Puan A', 'admin1', 'admin', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `blockedslots`
--

CREATE TABLE `blockedslots` (
  `slotId` int(11) NOT NULL,
  `activityId` int(11) NOT NULL,
  `blockedDate` date DEFAULT NULL,
  `blockedTimeSlot` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `bookingId` int(11) NOT NULL,
  `activityId` int(11) DEFAULT NULL,
  `customerId` int(11) NOT NULL,
  `noOfParticipant` int(11) DEFAULT NULL,
  `timeSlot` varchar(100) NOT NULL,
  `bookDate` varchar(100) DEFAULT NULL,
  `comment` mediumtext DEFAULT NULL,
  `updationDate` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(11) NOT NULL,
  `fullName` varchar(100) DEFAULT NULL,
  `mobileNumber` varchar(15) DEFAULT NULL,
  `emailId` varchar(70) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `regDate` timestamp NULL DEFAULT current_timestamp(),
  `updationDate` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `fullName`, `mobileNumber`, `emailId`, `password`, `regDate`, `updationDate`) VALUES
(1, 'Amira Adnan', '012345678', 'amira@gmail.com', 'amira', '2023-05-30 19:42:05', '2023-06-07 01:58:50'),
(2, 'SYUKRIAH ADILIN BINTI YUSOF', '012345678', 'syukriah@gmail.com', 'syukriah', '2023-06-07 01:56:03', NULL),
(3, 'ZAMRI BIN MOHAMAD', '012345678', 'zamri@gmail.com', 'zamri', '2023-06-07 01:56:42', NULL),
(4, 'PERSATUAN WANITA NEGERI SEMBILAN', '012345678', 'unita@gmail.com', 'unita', '2023-06-07 01:58:12', NULL),
(5, 'GHAZALI MOHAMAD', '012345678', 'ghazali@gmail.com', 'ghazali', '2023-06-07 01:58:43', NULL),
(6, 'SITI NUR ROSMANI ', '012345678', 'rosmani@gmail.com', 'rosmani', '2023-06-07 01:59:26', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `feedbacks`
--

CREATE TABLE `feedbacks` (
  `feedbackId` int(11) NOT NULL,
  `bookingId` int(11) NOT NULL,
  `feedbackImage` varchar(100) DEFAULT NULL,
  `rating` int(11) DEFAULT NULL,
  `comment` mediumtext DEFAULT NULL,
  `creationDate` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `gallery`
--

CREATE TABLE `gallery` (
  `id` int(11) NOT NULL,
  `imagePath` varchar(100) NOT NULL,
  `imageType` varchar(50) NOT NULL,
  `creationDate` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `paymentId` int(11) NOT NULL,
  `bookingId` int(11) NOT NULL,
  `paymentAmount` decimal(10,2) DEFAULT NULL,
  `paymentReceipt` varchar(100) DEFAULT NULL,
  `creationDate` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `id` int(11) NOT NULL,
  `fullName` varchar(100) NOT NULL,
  `phoneNumber` varchar(15) NOT NULL,
  `role` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`id`, `fullName`, `phoneNumber`, `role`, `username`, `password`) VALUES
(1, 'Iman', '012345678', 'Staff1', 'S-Iman', 'Staf1'),
(2, 'aa', 'aa', 'aaaa', 'staff2', 'staff2');

-- --------------------------------------------------------

--
-- Table structure for table `tblenquiry`
--

CREATE TABLE `tblenquiry` (
  `id` int(11) NOT NULL,
  `fullName` varchar(100) DEFAULT NULL,
  `emailId` varchar(100) DEFAULT NULL,
  `mobileNumber` varchar(10) DEFAULT NULL,
  `subject` varchar(100) DEFAULT NULL,
  `description` mediumtext DEFAULT NULL,
  `postingDate` timestamp NULL DEFAULT current_timestamp(),
  `status` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity`
--
ALTER TABLE `activity`
  ADD PRIMARY KEY (`activityId`);

--
-- Indexes for table `activityimages`
--
ALTER TABLE `activityimages`
  ADD PRIMARY KEY (`imageId`),
  ADD KEY `activityId` (`activityId`);

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blockedslots`
--
ALTER TABLE `blockedslots`
  ADD PRIMARY KEY (`slotId`),
  ADD KEY `activityId` (`activityId`);

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`bookingId`),
  ADD KEY `activityId` (`activityId`),
  ADD KEY `customerId` (`customerId`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `feedbacks`
--
ALTER TABLE `feedbacks`
  ADD PRIMARY KEY (`feedbackId`),
  ADD KEY `bookingId` (`bookingId`);

--
-- Indexes for table `gallery`
--
ALTER TABLE `gallery`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`paymentId`),
  ADD KEY `bookingId` (`bookingId`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblenquiry`
--
ALTER TABLE `tblenquiry`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity`
--
ALTER TABLE `activity`
  MODIFY `activityId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `activityimages`
--
ALTER TABLE `activityimages`
  MODIFY `imageId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `blockedslots`
--
ALTER TABLE `blockedslots`
  MODIFY `slotId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `bookingId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `feedbacks`
--
ALTER TABLE `feedbacks`
  MODIFY `feedbackId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gallery`
--
ALTER TABLE `gallery`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `paymentId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tblenquiry`
--
ALTER TABLE `tblenquiry`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `activityimages`
--
ALTER TABLE `activityimages`
  ADD CONSTRAINT `activityimages_ibfk_1` FOREIGN KEY (`activityId`) REFERENCES `activity` (`activityId`) ON DELETE CASCADE;

--
-- Constraints for table `blockedslots`
--
ALTER TABLE `blockedslots`
  ADD CONSTRAINT `blockedslots_ibfk_1` FOREIGN KEY (`activityId`) REFERENCES `activity` (`activityId`);

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`activityId`) REFERENCES `activity` (`activityId`) ON DELETE CASCADE,
  ADD CONSTRAINT `bookings_ibfk_2` FOREIGN KEY (`customerId`) REFERENCES `customers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `feedbacks`
--
ALTER TABLE `feedbacks`
  ADD CONSTRAINT `feedbacks_ibfk_1` FOREIGN KEY (`bookingId`) REFERENCES `bookings` (`bookingId`) ON DELETE CASCADE;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`bookingId`) REFERENCES `bookings` (`bookingId`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
