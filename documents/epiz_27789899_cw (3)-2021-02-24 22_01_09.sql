-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: sql100.epizy.com
-- Generation Time: Feb 24, 2021 at 01:42 PM
-- Server version: 5.6.48-88.0
-- PHP Version: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `epiz_27789899_cw`
--

-- --------------------------------------------------------

--
-- Table structure for table `Author`
--

CREATE TABLE `Author` (
  `Author_ID` int(11) NOT NULL,
  `Name` varchar(50) DEFAULT NULL,
  `Email` varchar(100) DEFAULT NULL,
  `Image` varchar(30) DEFAULT NULL,
  `Password` char(32) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Author`
--

INSERT INTO `Author` (`Author_ID`, `Name`, `Email`, `Image`, `Password`) VALUES
(1, 'Souma Yukihira', 'SoumaY@mail.com', 'soma.jpg', '8d3a85614b6f848c085a4919e4a3b4c2'),
(2, 'Gordon Ramsey', 'adiulalam1@gmail.com', 'gordon.jpg', '8561cbe0f1c938bd544fd4c5a5991a32'),
(4, 'Adiul Alam Adil', 'aa6932u@gre.ac.uk', 'adil.jpeg', '17bb188cbd5cf11077844d66f1e0bc0e'),
(22, 'name', 'email', NULL, '8d3a85614b6f848c085a4919e4a3b4c2'),
(76, 'test', 'test', NULL, '560338aa285582354173e5b8cf2e2604'),
(88, 'admin', 'admin@admin.com', NULL, '8d3a85614b6f848c085a4919e4a3b4c2'),
(89, 'adiul', 'adiulalam@gmail.com', NULL, 'aefed5297b46a881979e140fb5cfe7c8'),
(109, 'Khin', 'khinsandarwin.sed@gmail.com', NULL, '524d00b0106182b6baf088364820a7b9'),
(108, 'adiul alam', 'adiulalam2015@gmail.com', NULL, '8d3a85614b6f848c085a4919e4a3b4c2'),
(6569, 'Bhumika Limbu', 'bhumika245limbu@icloud.com', NULL, '32bfe6a41f4e9293ae4b0d62672525ba'),
(111, '123', '111', NULL, 'f22128841b3cd2c1003dad969698b3f7'),
(112, '123@', '12444', NULL, 'a8bb33ee4132e160bf2a5748c4e52aac'),
(113, '123', 'gmal.com', NULL, '524d00b0106182b6baf088364820a7b9'),
(118, 'saif', 'mi3624g@gre.ac.uk', NULL, '1fd69e559006d52738c0e3af67ae623a'),
(115, 'Test', 'gmail.com', NULL, '524d00b0106182b6baf088364820a7b9'),
(119, 'DBtesting', 'williamspark1993@gmail.com', NULL, '8d3a85614b6f848c085a4919e4a3b4c2'),
(6565, 'tt', 'jh@gmail.com', NULL, 'tgtgtgtg'),
(6566, 'Fernandes', 'maisie123@gmail.com', NULL, 'e0cf8cc562b953926ec87d643ac94538');

-- --------------------------------------------------------

--
-- Table structure for table `AuthorRole`
--

CREATE TABLE `AuthorRole` (
  `AuthorID` int(11) NOT NULL,
  `RoleID` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `AuthorRole`
--

INSERT INTO `AuthorRole` (`AuthorID`, `RoleID`) VALUES
(1, 'Content Editor'),
(2, 'Account Administrator'),
(2, 'Content Editor'),
(4, 'Account Administrator'),
(4, 'Content Editor'),
(4, 'Site Administrator'),
(22, 'Account Administrator'),
(22, 'Content Editor'),
(22, 'Site Administrator'),
(22, 'User'),
(76, 'User'),
(88, 'Account Administrator'),
(88, 'Content Editor'),
(88, 'Site Administrator'),
(88, 'User'),
(108, 'User'),
(109, 'User'),
(111, 'User'),
(112, 'User'),
(113, 'User'),
(115, 'User'),
(118, 'User'),
(119, 'User'),
(6566, 'User'),
(6569, 'User');

-- --------------------------------------------------------

--
-- Table structure for table `Category`
--

CREATE TABLE `Category` (
  `ID` int(11) NOT NULL,
  `Name` varchar(255) DEFAULT NULL,
  `Image` varchar(30) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Category`
--

INSERT INTO `Category` (`ID`, `Name`, `Image`) VALUES
(1, 'Teaching Suggestions', 'meat.png'),
(2, 'Improvements for Equipment ', 'vegeterian.png'),
(3, 'Module Improvement', 'vegan.jpg'),
(4, 'Budget', 'seafood.png'),
(5, 'General Student Improvement', 'veg.png'),
(7, 'Other (Explain in Detail)', 'fruits.png');

-- --------------------------------------------------------

--
-- Table structure for table `Comment`
--

CREATE TABLE `Comment` (
  `CommentID` int(11) NOT NULL,
  `Comment` text,
  `IdeaID` int(11) DEFAULT NULL,
  `AuthorID` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Comment`
--

INSERT INTO `Comment` (`CommentID`, `Comment`, `IdeaID`, `AuthorID`) VALUES
(1, 'test', 1, 88),
(2, 'test', 1, 88),
(3, 'test9', 9, 1),
(4, 'test10', 10, 1),
(5, 'test1', 1, 1),
(6, 'test2', NULL, NULL),
(7, 'test3', NULL, NULL),
(8, 'test2', NULL, NULL),
(9, 'test2', NULL, NULL),
(10, 'test3', 0, NULL),
(11, 'test3', 1, 1),
(12, 'test3', 1, 1),
(13, 'test4', 1, NULL),
(14, 'test5', 1, NULL),
(15, 'test6', 1, NULL),
(16, 'test7', 1, NULL),
(17, 'test8', 1, NULL),
(18, 'test9', 1, NULL),
(19, 'test9', 1, NULL),
(20, 'test1', 9, 88),
(21, 'jiuoijioji', 1, NULL),
(22, 'test \r\n', 1, NULL),
(23, 'test2', 1, NULL),
(24, 'test4', 1, NULL),
(25, 'test4', 1, NULL),
(55, 'test5', 1, 88),
(27, 'test99', 1, 0),
(56, 'juhugyguy', 1, 6566),
(30, 'test', 0, 88),
(31, 'test', 0, 88),
(32, 'test', 0, 88),
(33, 'test', 0, 88),
(57, 'test', 39, 88),
(36, 'test1', 37, 88),
(37, 'test2', 37, 88),
(38, 'test3', 37, 88),
(39, 'test4', 37, 88),
(40, 'test5', 37, 88),
(41, 'test6', 37, 88),
(42, 'test7', 37, 88),
(43, 'test8', 37, 88),
(44, 'test8', 37, 88),
(45, 'test7', 37, 88),
(46, 'test9', 37, 88),
(47, 'test10', 37, 88),
(48, 'test11', 37, 88),
(49, 'tesy3', 37, 88),
(50, 'tesy3', 37, 88),
(51, 'test5', 37, 88),
(52, 'new comment', 37, 88),
(53, 'TEST comment', 39, NULL),
(58, 'testnew', 39, 88);

-- --------------------------------------------------------

--
-- Table structure for table `Department`
--

CREATE TABLE `Department` (
  `ID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Department`
--

INSERT INTO `Department` (`ID`, `Name`) VALUES
(1, 'Business & Economics'),
(3, 'Science & Engineering'),
(4, 'Social and Political Science');

-- --------------------------------------------------------

--
-- Table structure for table `Idea`
--

CREATE TABLE `Idea` (
  `ID` int(11) NOT NULL,
  `IdeaText` text COLLATE utf8_bin,
  `IdeaDate` date NOT NULL,
  `AuthorID` int(11) NOT NULL,
  `Image` varchar(30) COLLATE utf8_bin DEFAULT NULL,
  `Vote` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `Idea`
--

INSERT INTO `Idea` (`ID`, `IdeaText`, `IdeaDate`, `AuthorID`, `Image`, `Vote`) VALUES
(1, 'Vegetable Salad', '2012-04-01', 2, 'vegsalad.jpg', 106),
(9, 'Fruit Salad', '2020-01-09', 1, 'fruitsalad.jpg', 6),
(10, 'Lamb Curry', '2020-01-10', 4, 'lambcurry.jpg', 4),
(11, 'Sushi', '2020-01-11', 1, 'sushi.jpg', 0),
(20, '<p style=\"text-align: left;\"><em><strong>dfvhjsfvhjsvhsdvih Maisie</strong></em></p>', '2021-02-15', 118, NULL, 1),
(32, '<p><strong>testing</strong></p>', '2021-02-18', 76, NULL, 3),
(34, 'test idea', '2021-02-21', 6566, NULL, 0),
(35, 'test idea', '2021-02-21', 6566, NULL, 0),
(36, 'test test 1', '2021-02-21', 6566, NULL, 0),
(37, 'new idea', '2021-02-22', 108, NULL, 0),
(38, 'Test', '2021-02-23', 88, NULL, 0),
(39, 'Test', '2021-02-23', 88, NULL, 2),
(40, '', '2021-02-23', 88, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `IdeaCategory`
--

CREATE TABLE `IdeaCategory` (
  `IdeaID` int(11) NOT NULL,
  `CategoryID` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `IdeaCategory`
--

INSERT INTO `IdeaCategory` (`IdeaID`, `CategoryID`) VALUES
(1, 2),
(1, 5),
(9, 3),
(9, 7),
(10, 1),
(11, 4),
(34, 1),
(35, 1),
(36, 1),
(37, 1),
(38, 1),
(39, 1),
(39, 2);

-- --------------------------------------------------------

--
-- Table structure for table `Role`
--

CREATE TABLE `Role` (
  `ID` varchar(255) NOT NULL,
  `Description` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Role`
--

INSERT INTO `Role` (`ID`, `Description`) VALUES
('Account Administrator', 'Add, remove, and edit authors'),
('Content Editor', 'Add, remove, and edit recipes'),
('Site Administrator', 'Add, remove, and edit categories'),
('User', 'Member of the public');

-- --------------------------------------------------------

--
-- Table structure for table `Vote`
--

CREATE TABLE `Vote` (
  `IdeaID` int(11) DEFAULT NULL,
  `AuthorID` int(11) DEFAULT NULL,
  `VoteNumber` int(11) DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Vote`
--

INSERT INTO `Vote` (`IdeaID`, `AuthorID`, `VoteNumber`) VALUES
(1, 88, 1),
(9, 88, -1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Author`
--
ALTER TABLE `Author`
  ADD PRIMARY KEY (`Author_ID`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- Indexes for table `AuthorRole`
--
ALTER TABLE `AuthorRole`
  ADD PRIMARY KEY (`AuthorID`,`RoleID`);

--
-- Indexes for table `Category`
--
ALTER TABLE `Category`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `Comment`
--
ALTER TABLE `Comment`
  ADD PRIMARY KEY (`CommentID`),
  ADD KEY `IdeaID` (`IdeaID`),
  ADD KEY `AuthorID` (`AuthorID`);

--
-- Indexes for table `Department`
--
ALTER TABLE `Department`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `Idea`
--
ALTER TABLE `Idea`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `AuthorID` (`AuthorID`);

--
-- Indexes for table `IdeaCategory`
--
ALTER TABLE `IdeaCategory`
  ADD PRIMARY KEY (`IdeaID`,`CategoryID`),
  ADD KEY `CategoryID` (`CategoryID`);

--
-- Indexes for table `Role`
--
ALTER TABLE `Role`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `Vote`
--
ALTER TABLE `Vote`
  ADD KEY `AuthorID` (`AuthorID`) USING BTREE,
  ADD KEY `IdeaID` (`IdeaID`) USING BTREE;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Author`
--
ALTER TABLE `Author`
  MODIFY `Author_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6570;

--
-- AUTO_INCREMENT for table `Category`
--
ALTER TABLE `Category`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `Comment`
--
ALTER TABLE `Comment`
  MODIFY `CommentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `Department`
--
ALTER TABLE `Department`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `Idea`
--
ALTER TABLE `Idea`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
