-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 20, 2022 at 04:02 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gibjohn_web`
--

-- --------------------------------------------------------

--
-- Table structure for table `documents`
--

CREATE TABLE `documents` (
  `DocumentID` int(255) NOT NULL,
  `DocumentName` varchar(255) NOT NULL,
  `DocumentOwnerID` int(255) NOT NULL,
  `DocumentPublic` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `documents`
--

INSERT INTO `documents` (`DocumentID`, `DocumentName`, `DocumentOwnerID`, `DocumentPublic`) VALUES
(4, 'testdoc.txt', 33, 0),
(5, 'Task 2 - Project Overview.docx', 33, 0),
(6, 'Task 2 - Sprint 1 - Simple frontend and backend.docx', 33, 0),
(7, 'testdoc.txt', 33, 0);

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `GroupID` int(255) NOT NULL,
  `GroupNickname` varchar(250) NOT NULL,
  `GroupSubject` varchar(120) NOT NULL,
  `GroupLocation` varchar(200) DEFAULT NULL,
  `GroupStartDate` timestamp(6) NOT NULL DEFAULT current_timestamp(6),
  `GroupEndDate` timestamp(6) NULL DEFAULT NULL,
  `GroupOwnerID` int(255) DEFAULT NULL,
  `GroupStatus` varchar(150) NOT NULL DEFAULT 'AWAITING_APPROVAL'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`GroupID`, `GroupNickname`, `GroupSubject`, `GroupLocation`, `GroupStartDate`, `GroupEndDate`, `GroupOwnerID`, `GroupStatus`) VALUES
(1, 'The Cool Astrophysics Group', 'Science - Astrophysics ', 'Space', '2022-05-12 10:16:30.000000', NULL, 33, 'BANNED'),
(2, 'GibJohn Tutoring', 'Main Hub', 'Online', '0000-00-00 00:00:00.000000', NULL, 1, 'ACTIVE'),
(10, 'Connis test group', 'Clouds', 'The Sun', '2022-05-18 12:59:48.975665', '0000-00-00 00:00:00.000000', 33, 'AWAITING_APPROVAL'),
(11, 'Another test group', 'The Subject Here', 'The Moon', '2022-05-18 13:03:15.289780', '0000-00-00 00:00:00.000000', 33, 'ACTIVE'),
(12, 'Just a small group for testing', 'A subject idk', 'A game', '2022-05-19 15:15:26.263213', '0000-00-00 00:00:00.000000', 33, 'AWAITING_APPROVAL');

-- --------------------------------------------------------

--
-- Table structure for table `group_assignments`
--

CREATE TABLE `group_assignments` (
  `AssignmentID` int(255) NOT NULL,
  `TargetUserID` int(255) DEFAULT NULL,
  `TargetGroupID` int(255) DEFAULT NULL,
  `TargetRole` varchar(255) NOT NULL,
  `AssignerID` int(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `group_assignments`
--

INSERT INTO `group_assignments` (`AssignmentID`, `TargetUserID`, `TargetGroupID`, `TargetRole`, `AssignerID`) VALUES
(1, 35, 1, 'Student', 1),
(2, 33, 1, 'Tutor', 1),
(3, 33, 2, 'Student', 1),
(6, 33, 10, 'Tutor', 33),
(7, 33, 11, 'Tutor', 33),
(8, 33, 12, 'Tutor', 33),
(9, 36, 1, 'Student', 33);

-- --------------------------------------------------------

--
-- Table structure for table `submissions`
--

CREATE TABLE `submissions` (
  `SubmissionID` int(255) NOT NULL,
  `SubmitterID` int(255) NOT NULL,
  `SubmissionWorkID` int(255) NOT NULL,
  `SubmittedDocumentID` int(255) NOT NULL,
  `SubmissionDate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `submissions`
--

INSERT INTO `submissions` (`SubmissionID`, `SubmitterID`, `SubmissionWorkID`, `SubmittedDocumentID`, `SubmissionDate`) VALUES
(7, 33, 2, 7, '2022-05-20 13:26:56');

-- --------------------------------------------------------

--
-- Table structure for table `units`
--

CREATE TABLE `units` (
  `UnitID` int(255) NOT NULL,
  `UnitTitle` varchar(255) NOT NULL,
  `UnitTopic` varchar(255) NOT NULL,
  `UnitOrderIndex` int(255) NOT NULL,
  `UnitGroupID` int(255) NOT NULL,
  `UnitFinishDate` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `units`
--

INSERT INTO `units` (`UnitID`, `UnitTitle`, `UnitTopic`, `UnitOrderIndex`, `UnitGroupID`, `UnitFinishDate`) VALUES
(1, 'Deprecated', 'Space Math', 1, 1, '2022-05-26 09:46:09'),
(11, '', 'The Floor', 2, 1, '2022-07-10 07:30:00'),
(12, '', 'asd', 3, 1, '2022-06-01 07:30:00'),
(13, '', 'Test Unit 1', 0, 10, '2022-06-01 07:30:00'),
(14, '', 'Another test unit', 0, 11, '2022-06-01 07:30:00'),
(15, '', 'COnnis test unit', 1, 12, '2022-06-01 07:30:00');

-- --------------------------------------------------------

--
-- Table structure for table `unit_resources`
--

CREATE TABLE `unit_resources` (
  `UnitResourceID` int(255) NOT NULL,
  `UnitResourceName` varchar(255) NOT NULL,
  `UnitResourceDocumentID` int(255) NOT NULL,
  `UnitResourceUnitID` int(255) NOT NULL,
  `UnitResourceUploadDate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `unit_resources`
--

INSERT INTO `unit_resources` (`UnitResourceID`, `UnitResourceName`, `UnitResourceDocumentID`, `UnitResourceUnitID`, `UnitResourceUploadDate`) VALUES
(1, 'Test resource', 6, 1, '2022-05-20 09:49:53'),
(2, 'Unit test resource', 5, 1, '2022-05-20 09:49:53');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `UserID` int(255) NOT NULL,
  `LegalFullName` varchar(300) NOT NULL,
  `PrefferedFullName` varchar(300) NOT NULL,
  `PasswordHash` varchar(500) NOT NULL,
  `ContactEmail` varchar(300) NOT NULL,
  `PhoneNumber` varchar(75) NOT NULL,
  `UserRole` varchar(50) NOT NULL,
  `AccountStatus` varchar(75) NOT NULL DEFAULT 'PENDING_ACTIVATION',
  `DateOfBirth` timestamp(6) NULL DEFAULT NULL,
  `DateOfEnrollment` timestamp(6) NOT NULL DEFAULT current_timestamp(6),
  `MainRoleTitle` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserID`, `LegalFullName`, `PrefferedFullName`, `PasswordHash`, `ContactEmail`, `PhoneNumber`, `UserRole`, `AccountStatus`, `DateOfBirth`, `DateOfEnrollment`, `MainRoleTitle`) VALUES
(1, 'Admin', 'Admin', '$2y$10$q8XDyLkk9mltzg1Y6KhGg.V.ipQ5ZPr32L5jh8o1PCRQruuLfAOgm', 'admin@conni.lgbt', '1', 'Admin', 'ACTIVE', NULL, '2022-05-11 14:34:13.154756', 'Administrator'),
(37, '', '123', '$2y$10$q8XDyLkk9mltzg1Y6KhGg.V.ipQ5ZPr32L5jh8o1PCRQruuLfAOgm', 'Test@test.com123', '123', '', 'BANNED', NULL, '2022-05-18 08:28:50.870922', '123');

-- --------------------------------------------------------

--
-- Table structure for table `work`
--

CREATE TABLE `work` (
  `WorkID` int(255) NOT NULL,
  `WorkTitle` varchar(255) NOT NULL,
  `WorkDescription` varchar(3000) NOT NULL,
  `WorkDeadline` timestamp NULL DEFAULT NULL,
  `WorkRewardPoints` int(255) NOT NULL,
  `WorkUnitID` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `work`
--

INSERT INTO `work` (`WorkID`, `WorkTitle`, `WorkDescription`, `WorkDeadline`, `WorkRewardPoints`, `WorkUnitID`) VALUES
(2, 'Go back inside', 'Maybe play games on the computer\r\n3\r\n4\r\n5', '2022-05-31 12:49:19', 23, 11),
(15, 'Go the other way!', 'OH NO', '2022-06-01 07:30:00', 12, 11);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `documents`
--
ALTER TABLE `documents`
  ADD PRIMARY KEY (`DocumentID`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`GroupID`),
  ADD KEY `GroupsTable_GroupOwnerID___UsersTable_UserID` (`GroupOwnerID`);

--
-- Indexes for table `group_assignments`
--
ALTER TABLE `group_assignments`
  ADD PRIMARY KEY (`AssignmentID`),
  ADD KEY `GroupAssignments_TargetGroupID___Groups_GroupID` (`TargetGroupID`),
  ADD KEY `GroupAssignments_TargetUserID___UsersTable_UserID` (`TargetUserID`),
  ADD KEY `GroupAssignments_AssignerID___UsersTable_UserID` (`AssignerID`);

--
-- Indexes for table `submissions`
--
ALTER TABLE `submissions`
  ADD PRIMARY KEY (`SubmissionID`),
  ADD KEY `WorkID Link` (`SubmissionWorkID`),
  ADD KEY `Doc Link` (`SubmittedDocumentID`),
  ADD KEY `userID Link` (`SubmitterID`);

--
-- Indexes for table `units`
--
ALTER TABLE `units`
  ADD PRIMARY KEY (`UnitID`),
  ADD KEY `UnitGroupID___Groups_GroupID` (`UnitGroupID`);

--
-- Indexes for table `unit_resources`
--
ALTER TABLE `unit_resources`
  ADD PRIMARY KEY (`UnitResourceID`),
  ADD KEY `efassdad` (`UnitResourceDocumentID`),
  ADD KEY `fdgcb` (`UnitResourceUnitID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UserID`);

--
-- Indexes for table `work`
--
ALTER TABLE `work`
  ADD PRIMARY KEY (`WorkID`),
  ADD KEY `GroupID Link` (`WorkUnitID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `documents`
--
ALTER TABLE `documents`
  MODIFY `DocumentID` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `GroupID` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `group_assignments`
--
ALTER TABLE `group_assignments`
  MODIFY `AssignmentID` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `submissions`
--
ALTER TABLE `submissions`
  MODIFY `SubmissionID` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `units`
--
ALTER TABLE `units`
  MODIFY `UnitID` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `unit_resources`
--
ALTER TABLE `unit_resources`
  MODIFY `UnitResourceID` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `UserID` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `work`
--
ALTER TABLE `work`
  MODIFY `WorkID` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `groups`
--
ALTER TABLE `groups`
  ADD CONSTRAINT `GroupsTable_GroupOwnerID___UsersTable_UserID` FOREIGN KEY (`GroupOwnerID`) REFERENCES `users` (`UserID`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `group_assignments`
--
ALTER TABLE `group_assignments`
  ADD CONSTRAINT `GroupAssignments_AssignerID___UsersTable_UserID` FOREIGN KEY (`AssignerID`) REFERENCES `users` (`UserID`),
  ADD CONSTRAINT `GroupAssignments_TargetGroupID___Groups_GroupID` FOREIGN KEY (`TargetGroupID`) REFERENCES `groups` (`GroupID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `GroupAssignments_TargetUserID___UsersTable_UserID` FOREIGN KEY (`TargetUserID`) REFERENCES `users` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `submissions`
--
ALTER TABLE `submissions`
  ADD CONSTRAINT `Doc Link` FOREIGN KEY (`SubmittedDocumentID`) REFERENCES `documents` (`DocumentID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `WorkID Link` FOREIGN KEY (`SubmissionWorkID`) REFERENCES `work` (`WorkID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `userID Link` FOREIGN KEY (`SubmitterID`) REFERENCES `users` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `units`
--
ALTER TABLE `units`
  ADD CONSTRAINT `UnitGroupID___Groups_GroupID` FOREIGN KEY (`UnitGroupID`) REFERENCES `groups` (`GroupID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `unit_resources`
--
ALTER TABLE `unit_resources`
  ADD CONSTRAINT `efassdad` FOREIGN KEY (`UnitResourceDocumentID`) REFERENCES `documents` (`DocumentID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fdgcb` FOREIGN KEY (`UnitResourceUnitID`) REFERENCES `units` (`UnitID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `work`
--
ALTER TABLE `work`
  ADD CONSTRAINT `GroupID Link` FOREIGN KEY (`WorkUnitID`) REFERENCES `units` (`UnitID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
