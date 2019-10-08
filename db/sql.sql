-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 01, 2018 at 07:33 AM
-- Server version: 10.1.36-MariaDB
-- PHP Version: 7.2.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
--

-- --------------------------------------------------------

--
-- Table structure for table `address`
--

CREATE TABLE `address` (
  `addressID` bigint(20) NOT NULL,
  `address` text NOT NULL,
  `city` varchar(100) NOT NULL,
  `state` varchar(100) NOT NULL,
  `country` varchar(100) NOT NULL,
  `postalCode` varchar(10) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `address`
--

INSERT INTO `address` (`addressID`, `address`, `city`, `state`, `country`, `postalCode`) VALUES
(2, '16 cedarwoods crescent, 1203', 'Kitchener', 'Ontario', 'Canada', NULL),
(3, '1 ceadrwoods', 'Kitchener', 'Ontario', 'Canada', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `education`
--

CREATE TABLE `education` (
  `educationID` bigint(20) NOT NULL,
  `userID` bigint(20) NOT NULL,
  `collegeName` text NOT NULL,
  `collegeBio` text NOT NULL,
  `educationLevel` varchar(100) NOT NULL,
  `addressID` bigint(20) DEFAULT NULL,
  `passingYear` bigint(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE `message` (
  `messageID` int(11) NOT NULL,
  `senderID` int(11) NOT NULL,
  `receiverID` int(11) NOT NULL,
  `message` text NOT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '0',
  `sentTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `message`
--

INSERT INTO `message` (`messageID`, `senderID`, `receiverID`, `message`, `status`, `sentTime`) VALUES
(1, 5, 3, 'HI', '0', '2018-10-31 05:41:03'),
(2, 5, 3, 'Hello', '0', '2018-10-31 05:43:22'),
(3, 5, 3, 'Hi', '0', '2018-10-31 05:43:49'),
(4, 5, 4, 'hELLO', '0', '2018-10-31 05:44:20'),
(5, 5, 4, 'HELLO', '0', '2018-10-31 05:44:29'),
(6, 5, 3, 'hI', '0', '2018-10-31 05:45:34'),
(7, 3, 5, 'Hello', '0', '2018-10-31 05:47:08'),
(8, 3, 4, 'cnxk', '0', '2018-11-01 06:12:46'),
(9, 6, 7, 'hhihoihoih', '0', '2018-11-01 06:26:37'),
(10, 6, 7, 'djcbdbjksc', '0', '2018-11-01 06:26:44');

-- --------------------------------------------------------

--
-- Table structure for table `personal_info`
--

CREATE TABLE `personal_info` (
  `personalInfoID` bigint(20) NOT NULL,
  `userID` bigint(20) NOT NULL,
  `userFirstName` varchar(255) NOT NULL,
  `userLastName` varchar(255) NOT NULL,
  `userGender` enum('male','female') NOT NULL,
  `userBirth` varchar(100) NOT NULL,
  `userImage` varchar(255) NOT NULL DEFAULT 'img/default-user.png',
  `addressID` bigint(20) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `personal_info`
--

INSERT INTO `personal_info` (`personalInfoID`, `userID`, `userFirstName`, `userLastName`, `userGender`, `userBirth`, `userImage`, `addressID`) VALUES
(3, 5, 'Rashmi', 'Sharma', 'female', '7-15-1993', 'img/default-user.png', NULL),
(4, 6, 'preeti', 'sharma', 'female', '8-12-1993', 'img/default-user.png', 3),
(5, 7, 'abhishek', 'kotnala', 'male', '4-5-1993', 'img/default-user.png', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

CREATE TABLE `post` (
  `postID` int(11) NOT NULL,
  `postType` enum('text','photo') NOT NULL,
  `userID` int(11) NOT NULL,
  `postContent` text NOT NULL,
  `postDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `post`
--

INSERT INTO `post` (`postID`, `postType`, `userID`, `postContent`, `postDate`) VALUES
(1, 'text', 3, 'Hello Everyone', '2017-10-29 04:00:00'),
(2, 'text', 4, 'Hello From Sandeep', '2018-10-30 00:31:42'),
(3, 'photo', 4, 'travel-2.jpg', '2018-10-30 00:31:42'),
(4, 'text', 3, 'kiddan', '2018-10-30 07:26:15'),
(5, 'text', 3, 'HI\n', '2018-10-30 07:30:03'),
(6, 'photo', 3, 'screencapture-localhost-meetpeople-2018-10-29-09_37_36.png', '2018-10-30 07:59:50'),
(7, 'text', 5, 'Hi Its Rashmi', '2018-10-30 21:28:37'),
(8, 'text', 6, 'hiii everyone', '2018-11-01 06:20:00'),
(9, 'photo', 6, 'download.jpg', '2018-11-01 06:21:18'),
(10, 'photo', 6, 'download.jpg', '2018-11-01 06:21:25'),
(11, 'text', 7, 'heyyyy', '2018-11-01 06:24:53');

-- --------------------------------------------------------

--
-- Table structure for table `post_comment`
--

CREATE TABLE `post_comment` (
  `commentID` bigint(20) NOT NULL,
  `postID` int(11) NOT NULL,
  `commentedUserID` int(11) NOT NULL,
  `comment` text NOT NULL,
  `commentDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `post_comment`
--

INSERT INTO `post_comment` (`commentID`, `postID`, `commentedUserID`, `comment`, `commentDate`) VALUES
(1, 1, 4, 'Good', '2018-10-30 05:08:30'),
(2, 1, 4, 'Nice', '2018-10-30 07:01:23'),
(8, 6, 3, 'Hello', '2018-10-30 21:08:20'),
(7, 6, 3, 'Nice', '2018-10-30 08:00:02');

-- --------------------------------------------------------

--
-- Table structure for table `post_likes`
--

CREATE TABLE `post_likes` (
  `postID` int(11) NOT NULL,
  `likedUserID` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `post_likes`
--

INSERT INTO `post_likes` (`postID`, `likedUserID`) VALUES
(1, 3),
(1, 4),
(2, 3),
(2, 4),
(3, 4),
(4, 3),
(6, 3),
(7, 5),
(8, 6),
(11, 7);

-- --------------------------------------------------------

--
-- Table structure for table `relationship`
--

CREATE TABLE `relationship` (
  `userOneID` bigint(20) NOT NULL,
  `userTwoID` bigint(20) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `actionUserID` bigint(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `relationship`
--

INSERT INTO `relationship` (`userOneID`, `userTwoID`, `status`, `actionUserID`) VALUES
(3, 4, 1, 3),
(5, 3, 2, 5),
(5, 4, 1, 4),
(7, 6, 0, 7);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `userID` bigint(20) NOT NULL,
  `userEmail` varchar(255) NOT NULL,
  `userPassword` varchar(255) NOT NULL,
  `userStatus` enum('0','1') NOT NULL DEFAULT '1',
  `registeredDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`userID`, `userEmail`, `userPassword`, `userStatus`, `registeredDate`) VALUES
(6, 'preeti@gmail.com', '1234', '1', '2018-11-01 06:17:42'),
(7, 'abhishek@gmail.com', '1234', '1', '2018-11-01 06:23:12');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `address`
--
ALTER TABLE `address`
  ADD PRIMARY KEY (`addressID`);

--
-- Indexes for table `education`
--
ALTER TABLE `education`
  ADD PRIMARY KEY (`educationID`);

--
-- Indexes for table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`messageID`);

--
-- Indexes for table `personal_info`
--
ALTER TABLE `personal_info`
  ADD PRIMARY KEY (`personalInfoID`);

--
-- Indexes for table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`postID`);

--
-- Indexes for table `post_comment`
--
ALTER TABLE `post_comment`
  ADD PRIMARY KEY (`commentID`);

--
-- Indexes for table `post_likes`
--
ALTER TABLE `post_likes`
  ADD UNIQUE KEY `postID` (`postID`,`likedUserID`);

--
-- Indexes for table `relationship`
--
ALTER TABLE `relationship`
  ADD UNIQUE KEY `userOneID` (`userOneID`,`userTwoID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`userID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `address`
--
ALTER TABLE `address`
  MODIFY `addressID` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `education`
--
ALTER TABLE `education`
  MODIFY `educationID` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `message`
  MODIFY `messageID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `personal_info`
--
ALTER TABLE `personal_info`
  MODIFY `personalInfoID` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `post`
--
ALTER TABLE `post`
  MODIFY `postID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `post_comment`
--
ALTER TABLE `post_comment`
  MODIFY `commentID` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `userID` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
