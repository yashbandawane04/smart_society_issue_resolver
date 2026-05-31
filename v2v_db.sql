-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 31, 2026 at 08:09 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `v2v_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `issues`
--

CREATE TABLE `issues` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `category` varchar(100) DEFAULT NULL,
  `status` enum('Pending','In Progress','Resolved') DEFAULT 'Pending',
  `image` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `votes` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `issues`
--

INSERT INTO `issues` (`id`, `user_id`, `title`, `description`, `category`, `status`, `image`, `created_at`, `votes`) VALUES
(1, NULL, 'Water Leakage', NULL, 'Water', 'Pending', NULL, '2025-08-24 12:31:13', 1),
(2, NULL, 'Power Outage', NULL, 'Electricity', 'In Progress', NULL, '2025-08-24 12:31:13', 0),
(3, NULL, 'Lobby Cleaning', NULL, 'Cleanliness', 'Resolved', NULL, '2025-08-24 12:31:13', 8),
(5, NULL, 'Power Outage on 3rd Floor', NULL, 'Electricity', 'In Progress', NULL, '2025-08-24 12:58:10', 6),
(6, NULL, 'Broken Gym Equipment', NULL, 'Maintenance', 'Pending', NULL, '2025-08-24 12:58:10', 6),
(8, NULL, 'Elevator Malfunction', NULL, 'Maintenance', 'In Progress', NULL, '2025-08-24 12:58:10', 1),
(9, NULL, 'Garden Lights Not Working', NULL, 'Electricity', 'Pending', NULL, '2025-08-24 12:58:10', 0),
(10, NULL, 'Pool Area Needs Cleaning', NULL, 'Cleanliness', 'Pending', NULL, '2025-08-24 12:58:10', 7),
(11, NULL, 'Clogged Drain in Basement', NULL, 'Water', 'In Progress', NULL, '2025-08-24 12:58:10', 2),
(12, NULL, 'Parking Lot Potholes', NULL, 'Maintenance', 'Pending', NULL, '2025-08-24 12:58:10', 2),
(13, NULL, 'Fire Extinguisher Check', NULL, 'Safety', 'Resolved', NULL, '2025-08-24 12:58:10', 4),
(14, NULL, 'Roof Leakage', NULL, 'Water', 'Pending', NULL, '2025-08-24 12:58:10', 2),
(15, NULL, 'Broken Mailbox', NULL, 'Maintenance', 'Pending', NULL, '2025-08-24 12:58:10', 9),
(16, NULL, 'Street Lamp Not Working', NULL, 'Electricity', 'Pending', NULL, '2025-08-24 12:58:10', 9),
(17, NULL, 'Children Play Area Needs Cleaning', NULL, 'Cleanliness', 'Pending', NULL, '2025-08-24 12:58:10', 6),
(18, NULL, 'Security Camera Issue', NULL, 'Safety', 'In Progress', NULL, '2025-08-24 12:58:10', 2),
(19, NULL, 'Elevator Floor Button Broken', NULL, 'Maintenance', 'Pending', NULL, '2025-08-24 12:58:10', 7),
(20, NULL, 'Garden Fountain Not Working', NULL, 'Water', 'Resolved', NULL, '2025-08-24 12:58:10', 5),
(21, NULL, 'Lobby Air Conditioning Issue', NULL, 'Maintenance', 'Pending', NULL, '2025-08-24 12:58:10', 4),
(22, NULL, 'Waste Disposal Delay', NULL, 'Cleanliness', 'In Progress', NULL, '2025-08-24 12:58:10', 6),
(23, NULL, 'Main Gate Lock Issue', NULL, 'Safety', 'Pending', NULL, '2025-08-24 12:58:10', 9),
(24, 1, 'Water Leakage in Basement', 'Leak detected near water pump area', 'Water', 'Pending', NULL, '2025-08-24 13:25:46', 5),
(25, 2, 'Power Outage 3rd Floor', 'Frequent electricity cuts', 'Electricity', 'In Progress', NULL, '2025-08-24 13:25:46', 8),
(26, 1, 'Lobby Cleaning Required', 'Lobby area needs cleaning', 'Cleanliness', 'Resolved', NULL, '2025-08-24 13:25:46', 3),
(27, 3, 'Broken Gym Equipment', 'Treadmill and weights broken', 'Maintenance', 'Pending', NULL, '2025-08-24 13:25:46', 7),
(28, 2, 'Elevator Malfunction', 'Elevator stuck twice this week', 'Maintenance', 'In Progress', NULL, '2025-08-24 13:25:46', 12),
(29, 1, 'Garden Lights Not Working', 'Many garden lights not working', 'Electricity', 'Pending', NULL, '2025-08-24 13:25:46', 4),
(30, 2, 'Pool Area Needs Cleaning', 'Algae and dirt in pool', 'Cleanliness', 'Pending', NULL, '2025-08-24 13:25:46', 6),
(31, 1, 'Clogged Drain in Basement', 'Drainage blocked after rains', 'Water', 'In Progress', NULL, '2025-08-24 13:25:46', 9),
(32, 3, 'Parking Lot Potholes', 'Multiple potholes in parking', 'Maintenance', 'Pending', NULL, '2025-08-24 13:25:46', 2),
(33, 2, 'Fire Extinguisher Check', 'Check all fire extinguishers', 'Safety', 'Resolved', NULL, '2025-08-24 13:25:46', 1),
(34, 1, 'Roof Leakage', 'Water leaks in roof', 'Water', 'Pending', NULL, '2025-08-24 13:25:46', 10),
(35, 3, 'Broken Mailbox', 'Mailbox broken near entrance', 'Maintenance', 'Pending', NULL, '2025-08-24 13:25:46', 3),
(36, 2, 'Street Lamp Not Working', 'Street lamps need fixing', 'Electricity', 'Resolved', NULL, '2025-08-24 13:25:46', 5),
(37, 1, 'Children Play Area Needs Cleaning', 'Play area littered', 'Cleanliness', 'Pending', NULL, '2025-08-24 13:25:46', 6),
(38, 3, 'Security Camera Issue', 'CCTV camera offline', 'Safety', 'In Progress', NULL, '2025-08-24 13:25:46', 8),
(39, 2, 'Elevator Floor Button Broken', 'Button not working', 'Maintenance', 'Pending', NULL, '2025-08-24 13:25:46', 4),
(40, 1, 'Garden Fountain Not Working', 'Fountain not running', 'Water', 'Resolved', NULL, '2025-08-24 13:25:46', 7),
(41, 3, 'Lobby Air Conditioning Issue', 'AC leaking water', 'Maintenance', 'Pending', NULL, '2025-08-24 13:25:46', 5),
(42, 2, 'Waste Disposal Delay', 'Garbage collection delayed', 'Cleanliness', 'In Progress', NULL, '2025-08-24 13:25:46', 3),
(43, 1, 'Main Gate Lock Issue', 'Lock not functioning properly', 'Security', 'Pending', NULL, '2025-08-24 13:25:46', 9);

-- --------------------------------------------------------

--
-- Table structure for table `issue_votes`
--

CREATE TABLE `issue_votes` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `issue_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `issue_votes`
--

INSERT INTO `issue_votes` (`id`, `user_id`, `issue_id`) VALUES
(1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE `members` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `flat_number` varchar(20) NOT NULL,
  `phone` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`id`, `name`, `flat_number`, `phone`) VALUES
(1, 'Purva Sonar', 'B-303', '+91 98765 43210'),
(2, 'Jane Smith', 'A-102', '+91 98765 43211'),
(3, 'Rohit Sharma', 'B-201', '+91 98765 43212'),
(4, 'Priya Singh', 'B-202', '+91 98765 43213'),
(5, 'Anil Kapoor', 'C-301', '+91 98765 43214'),
(6, 'Sunita Patil', 'C-302', '+91 98765 43215'),
(7, 'Amitabh Bachchan', 'D-401', '+91 98765 43216'),
(8, 'Kareena Kapoor', 'D-402', '+91 98765 43217'),
(9, 'Arjun Mehta', 'A-103', '+91 98765 43218'),
(10, 'Neha Verma', 'A-104', '+91 98765 43219'),
(11, 'Sanjay Kapoor', 'A-105', '+91 98765 43220'),
(12, 'Ritu Sharma', 'B-203', '+91 98765 43221'),
(13, 'Vikram Singh', 'B-204', '+91 98765 43222'),
(14, 'Ankita Jain', 'B-205', '+91 98765 43223'),
(15, 'Rajesh Khanna', 'C-303', '+91 98765 43224'),
(16, 'Deepika Padukone', 'C-304', '+91 98765 43225'),
(17, 'Salman Khan', 'C-305', '+91 98765 43226'),
(18, 'Karan Johar', 'D-403', '+91 98765 43227'),
(19, 'Alia Bhatt', 'D-404', '+91 98765 43228'),
(20, 'Shahid Kapoor', 'D-405', '+91 98765 43229'),
(21, 'Varun Dhawan', 'E-501', '+91 98765 43230'),
(22, 'Kriti Sanon', 'E-502', '+91 98765 43231'),
(23, 'Hrithik Roshan', 'E-503', '+91 98765 43232'),
(24, 'Tiger Shroff', 'F-601', '+91 98765 43233'),
(25, 'Sara Ali Khan', 'F-602', '+91 98765 43234'),
(26, 'Ranveer Singh', 'F-603', '+91 98765 43235'),
(27, 'Anushka Sharma', 'G-701', '+91 98765 43236'),
(28, 'Virat Kohli', 'G-702', '+91 98765 43237'),
(29, 'Rashmika Mandanna', 'G-703', '+91 98765 43238'),
(30, 'Prabhas', 'H-801', '+91 98765 43239'),
(31, 'Shraddha Kapoor', 'H-802', '+91 98765 43240'),
(32, 'Ranbir Kapoor', 'H-803', '+91 98765 43241'),
(33, 'Madhuri Dixit', 'I-901', '+91 98765 43242'),
(34, 'Sridevi', 'I-902', '+91 98765 43243'),
(35, 'Kajol', 'I-903', '+91 98765 43244'),
(36, 'Rani Mukerji', 'J-1001', '+91 98765 43245'),
(37, 'Aamir Khan', 'J-1002', '+91 98765 43246'),
(38, 'Kangana Ranaut', 'J-1003', '+91 98765 43247');

-- --------------------------------------------------------

--
-- Table structure for table `reminders`
--

CREATE TABLE `reminders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `datetime` datetime NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reminders`
--

INSERT INTO `reminders` (`id`, `user_id`, `title`, `description`, `datetime`, `created_at`) VALUES
(1, 1, 'Pay Maintenance', 'Pay society maintenance charges', '2025-08-25 10:00:00', '2025-08-24 07:54:12'),
(2, 1, 'Meeting with Committee', 'Monthly society meeting', '2025-08-26 18:00:00', '2025-08-24 07:54:12'),
(3, 1, 'Water Tank Cleaning', 'Reminder for water tank cleaning', '2025-08-27 09:00:00', '2025-08-24 07:54:12'),
(4, 1, 'Fire Drill Practice', 'Emergency drill at 5 PM', '2025-08-28 17:00:00', '2025-08-24 07:54:12'),
(5, 1, 'Garden Maintenance', 'Fertilizer and trimming schedule', '2025-08-29 08:00:00', '2025-08-24 07:54:12'),
(6, 1, 'Check Security Cameras', 'Inspect all camera feeds', '2025-08-30 15:00:00', '2025-08-24 07:54:12'),
(7, 1, 'Parking Lot Inspection', 'Check potholes and markings', '2025-08-31 09:30:00', '2025-08-24 07:54:12'),
(8, 1, 'Swimming Pool Cleaning', 'Clean pool and filters', '2025-09-01 07:00:00', '2025-08-24 07:54:12'),
(9, 1, 'Lobby Air Conditioning', 'Inspect AC units', '2025-09-02 14:00:00', '2025-08-24 07:54:12'),
(10, 1, 'Street Lamp Maintenance', 'Check all street lamps', '2025-09-03 08:00:00', '2025-08-24 07:54:12');

-- --------------------------------------------------------

--
-- Table structure for table `timetable`
--

CREATE TABLE `timetable` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `category` varchar(100) DEFAULT NULL,
  `event_date` date NOT NULL,
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `timetable`
--

INSERT INTO `timetable` (`id`, `user_id`, `title`, `description`, `category`, `event_date`, `start_time`, `end_time`, `created_at`) VALUES
(1, 1, 'Water Tank Cleaning', 'Clean the main water tank', 'Maintenance', '2025-08-25', '09:00:00', '11:00:00', '2025-08-24 07:54:26'),
(2, 1, 'Power Shutdown', 'Scheduled electricity outage', 'Electricity', '2025-08-26', '14:00:00', '16:00:00', '2025-08-24 07:54:26'),
(3, 1, 'Lobby Cleaning', 'Clean lobby and common areas', 'Cleanliness', '2025-08-27', '08:00:00', '10:00:00', '2025-08-24 07:54:26'),
(4, 1, 'Fire Drill', 'Conduct fire drill', 'Safety', '2025-08-28', '17:00:00', '18:00:00', '2025-08-24 07:54:26'),
(5, 1, 'Garden Maintenance', 'Trim and fertilize plants', 'Cleanliness', '2025-08-29', '07:00:00', '10:00:00', '2025-08-24 07:54:26'),
(6, 1, 'Elevator Inspection', 'Inspect all elevators', 'Maintenance', '2025-08-30', '11:00:00', '12:00:00', '2025-08-24 07:54:26'),
(7, 1, 'Swimming Pool Cleaning', 'Clean pool area', 'Cleanliness', '2025-08-31', '06:00:00', '08:00:00', '2025-08-24 07:54:26'),
(8, 1, 'Committee Meeting', 'Monthly committee discussion', 'Meeting', '2025-09-01', '18:00:00', '19:30:00', '2025-08-24 07:54:26'),
(9, 1, 'Street Light Check', 'Inspect all street lights', 'Electricity', '2025-09-02', '08:00:00', '09:00:00', '2025-08-24 07:54:26'),
(10, 1, 'Mailbox Repair', 'Repair broken mailboxes', 'Maintenance', '2025-09-03', '10:00:00', '12:00:00', '2025-08-24 07:54:26');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('resident','admin') NOT NULL DEFAULT 'resident',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `created_at`) VALUES
(1, 'Moksh Sonar', 'sonarmoksh@gmail.com', '1234', 'resident', '2025-08-24 05:04:42'),
(2, 'Yash Bandawane', 'yashadmin04@gmail.com', '1234', 'resident', '2025-08-24 10:19:21');

-- --------------------------------------------------------

--
-- Table structure for table `votes`
--

CREATE TABLE `votes` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `issue_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `votes`
--

INSERT INTO `votes` (`id`, `user_id`, `issue_id`) VALUES
(1, 1, 101),
(2, 1, 102);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `issues`
--
ALTER TABLE `issues`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `issue_votes`
--
ALTER TABLE `issue_votes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_vote` (`user_id`,`issue_id`);

--
-- Indexes for table `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reminders`
--
ALTER TABLE `reminders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `timetable`
--
ALTER TABLE `timetable`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `votes`
--
ALTER TABLE `votes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_vote` (`user_id`,`issue_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `issues`
--
ALTER TABLE `issues`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `issue_votes`
--
ALTER TABLE `issue_votes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `members`
--
ALTER TABLE `members`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `reminders`
--
ALTER TABLE `reminders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `timetable`
--
ALTER TABLE `timetable`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `votes`
--
ALTER TABLE `votes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `reminders`
--
ALTER TABLE `reminders`
  ADD CONSTRAINT `reminders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `timetable`
--
ALTER TABLE `timetable`
  ADD CONSTRAINT `timetable_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
