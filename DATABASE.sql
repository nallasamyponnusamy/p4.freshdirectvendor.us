-- phpMyAdmin SQL Dump
-- version 4.0.8
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 23, 2013 at 02:25 PM
-- Server version: 5.1.70-cll
-- PHP Version: 5.3.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `freshdir_p4_freshdirectvendor_us`
--

-- --------------------------------------------------------

--
-- Table structure for table `GMPCategories`
--

CREATE TABLE IF NOT EXISTS `GMPCategories` (
  `GMPCategoryID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `GMPCategoryName` varchar(60) NOT NULL DEFAULT '',
  `isActive` tinyint(1) NOT NULL DEFAULT '1',
  `DateCreated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`GMPCategoryID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `GMPCategories`
--

INSERT INTO `GMPCategories` (`GMPCategoryID`, `GMPCategoryName`, `isActive`, `DateCreated`) VALUES
(1, 'Food products adulterated or unfit', 1, '0000-00-00 00:00:00'),
(2, 'Food handling and storage', 1, '0000-00-00 00:00:00'),
(3, 'Food protected from contamination from other sources', 1, '0000-00-00 00:00:00'),
(4, 'Employee hygiene practices', 1, '0000-00-00 00:00:00'),
(5, 'General Housekeeping and sanitation', 1, '0000-00-00 00:00:00'),
(6, 'Improper/Inadequate sanitary facilities and supplies', 1, '0000-00-00 00:00:00'),
(7, 'Sanitary facilities and supplies', 1, '0000-00-00 00:00:00'),
(8, 'Food protected from contamination from employees', 1, '0000-00-00 00:00:00'),
(9, 'Adequate temp control of PHFs', 1, '0000-00-00 00:00:00'),
(10, 'Food handling and protection', 1, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `NonProductionDeficienciesList`
--

CREATE TABLE IF NOT EXISTS `NonProductionDeficienciesList` (
  `NonProductionDeficiencyID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `NonProductionDeficiencyName` varchar(255) NOT NULL DEFAULT '',
  `NonProductionDeficiencyRiskFactor` varchar(3) NOT NULL DEFAULT '',
  `NonProductionDeficiencyScore` int(10) unsigned NOT NULL DEFAULT '0',
  `DateCreated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `isActive` tinyint(1) NOT NULL DEFAULT '1',
  `GMPCategoryID` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`NonProductionDeficiencyID`) USING BTREE,
  UNIQUE KEY `Unique_NonProductionDeficiencyName` (`NonProductionDeficiencyName`) USING BTREE,
  KEY `FK_NonProductionDeficienciesList_GMPCategories` (`GMPCategoryID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=50 ;

--
-- Dumping data for table `NonProductionDeficienciesList`
--

INSERT INTO `NonProductionDeficienciesList` (`NonProductionDeficiencyID`, `NonProductionDeficiencyName`, `NonProductionDeficiencyRiskFactor`, `NonProductionDeficiencyScore`, `DateCreated`, `isActive`, `GMPCategoryID`) VALUES
(1, 'Food infested with insects', 'C', 4, '0000-00-00 00:00:00', 1, 1),
(2, 'Foods defiled by rodent/bird activity', 'C', 4, '0000-00-00 00:00:00', 1, 1),
(3, 'Other  adulterated or unfit foods on storage/pick shelves', 'C', 4, '0000-00-00 00:00:00', 1, 1),
(4, 'Other damaged or unfit foods', 'C', 4, '0000-00-00 00:00:00', 1, 1),
(5, 'Expired products on pick shelves', 'M', 2, '0000-00-00 00:00:00', 1, 2),
(6, 'Frozen foods left outside freezer for extended periods of time (signs of thawing observed)', 'M', 2, '0000-00-00 00:00:00', 1, 2),
(7, 'Loading/receiving  dock doors & flaps kept closed when not in use', 'M', 2, '0000-00-00 00:00:00', 1, 2),
(8, 'Other receiving parameters for food quality and hygiene are checked and recorded ( condition of trucks and product)', 'M', 2, '0000-00-00 00:00:00', 1, 2),
(9, 'Temp of received products monitored and recorded', 'M', 2, '0000-00-00 00:00:00', 1, 2),
(10, 'At least 12 inch space maintained along perimeter wall', 'Mi', 1, '0000-00-00 00:00:00', 1, 2),
(11, 'Excessive build up of spilled product on shelves', 'Mi', 1, '0000-00-00 00:00:00', 1, 2),
(12, 'Fallen products removed from floor/bumper in a timely manner', 'Mi', 1, '0000-00-00 00:00:00', 1, 2),
(13, 'Frozen products held in a manner that prevents thawing', 'Mi', 1, '0000-00-00 00:00:00', 1, 2),
(14, 'Lighting and ventilation adequate', 'Mi', 1, '0000-00-00 00:00:00', 1, 2),
(15, 'Products stored off the floor', 'Mi', 1, '0000-00-00 00:00:00', 1, 2),
(16, 'Products stored off the floor after production', 'Mi', 1, '0000-00-00 00:00:00', 1, 2),
(17, 'Scrap products clearly identified and segregated from good  products', 'Mi', 1, '0000-00-00 00:00:00', 1, 2),
(18, 'Evidence of insect, rodent or bird activity likely to result in product contamination', 'M', 2, '0000-00-00 00:00:00', 1, 3),
(19, 'Toxic chemical properly labeled, stored & use in a manner that prevents contamination', 'M', 2, '0000-00-00 00:00:00', 1, 3),
(20, 'Loading/receiving dock and protective flaps in good condition', 'Mi', 1, '0000-00-00 00:00:00', 1, 3),
(21, 'Employees working with exposed jewelry', 'Mi', 1, '0000-00-00 00:00:00', 1, 4),
(22, 'Evidence of eating/drinking/smoking', 'Mi', 1, '0000-00-00 00:00:00', 1, 4),
(23, 'Exposed artificial nails', 'Mi', 1, '0000-00-00 00:00:00', 1, 4),
(24, 'Hairnet worn correctly', 'Mi', 1, '0000-00-00 00:00:00', 1, 4),
(25, 'Personal belongings properly stored in designated area and away from foods', 'Mi', 1, '0000-00-00 00:00:00', 1, 4),
(26, 'Sanitation supplies properly stored', 'Mi', 1, '0000-00-00 00:00:00', 1, 5),
(27, 'Conveyors clean - free of trash and fallen products', 'Mi', 1, '0000-00-00 00:00:00', 1, 5),
(28, 'Empty totes stored in orderly manner', 'Mi', 1, '0000-00-00 00:00:00', 1, 5),
(29, 'Empty/broken pallets properly stored', 'Mi', 1, '0000-00-00 00:00:00', 1, 5),
(30, 'Excessive accumulation of empty boxes on the floor', 'Mi', 1, '0000-00-00 00:00:00', 1, 5),
(31, 'Excessive accumulation of trash and debris on floor', 'Mi', 1, '0000-00-00 00:00:00', 1, 5),
(32, 'Work stations clean - no excessive build up dust/trash', 'Mi', 1, '0000-00-00 00:00:00', 1, 5),
(33, 'Floors clean - spills cleaned up and debris removed', 'Mi', 1, '0000-00-00 00:00:00', 1, 5),
(34, 'Ice packs etc stored properly off the  floor', 'Mi', 1, '0000-00-00 00:00:00', 1, 5),
(35, 'Inside sorter clean and spills and fallen products removed', 'Mi', 1, '0000-00-00 00:00:00', 1, 5),
(36, 'Locker areas clean ( room/cabinets)', 'Mi', 1, '0000-00-00 00:00:00', 1, 5),
(37, 'Pick carts clean and free of trash', 'Mi', 1, '0000-00-00 00:00:00', 1, 5),
(38, 'Sorting shelves clean - free of trash and fallen products', 'Mi', 1, '0000-00-00 00:00:00', 1, 5),
(39, 'Spills and damaged product removed from floor and bumpers', 'Mi', 1, '0000-00-00 00:00:00', 1, 5),
(40, 'Storage cabinets clean', 'Mi', 1, '0000-00-00 00:00:00', 1, 5),
(41, 'Tarps, ice packs etc stored properly off floor and bumpers', 'Mi', 1, '0000-00-00 00:00:00', 1, 5),
(42, 'Trash cans clean and lined', 'Mi', 1, '0000-00-00 00:00:00', 1, 5),
(43, 'Trash cans emptied at sufficient intervals/no overflow', 'Mi', 1, '0000-00-00 00:00:00', 1, 5),
(44, 'Hand wash station: Stocked and working properly', 'Mi', 1, '0000-00-00 00:00:00', 1, 6),
(45, 'Restroom clean', 'Mi', 1, '0000-00-00 00:00:00', 1, 6),
(46, 'Other food handling or storage issue', 'M', 2, '0000-00-00 00:00:00', 1, 2),
(47, 'Other potential contamination issue', 'Mi', 2, '0000-00-00 00:00:00', 1, 3),
(48, 'Other unacceptable employee practices', 'Mi', 1, '0000-00-00 00:00:00', 1, 4),
(49, 'Other housekeeping issue', 'Mi', 1, '0000-00-00 00:00:00', 1, 5);

-- --------------------------------------------------------

--
-- Table structure for table `NonProductionDeficienciesLog`
--

CREATE TABLE IF NOT EXISTS `NonProductionDeficienciesLog` (
  `NonProductionDeficienciesLogID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `NonProductionInspectionLogID` int(10) unsigned NOT NULL DEFAULT '0',
  `NonProductionDeficiencyID` int(10) unsigned NOT NULL DEFAULT '0',
  `Comments` text CHARACTER SET latin1 NOT NULL,
  `CorrectiveActions` text CHARACTER SET latin1 NOT NULL,
  `DateCreated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`NonProductionDeficienciesLogID`) USING BTREE,
  KEY `FK_NPDeficienciesLog_NPInspectionLog` (`NonProductionInspectionLogID`),
  KEY `FK_NPDeficienciesLog_NPDeficienciesList` (`NonProductionDeficiencyID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=88 ;

--
-- Dumping data for table `NonProductionDeficienciesLog`
--

INSERT INTO `NonProductionDeficienciesLog` (`NonProductionDeficienciesLogID`, `NonProductionInspectionLogID`, `NonProductionDeficiencyID`, `Comments`, `CorrectiveActions`, `DateCreated`) VALUES
(68, 1, 4, 'Broken MIlk Carton', 'Separate milk cartons from Eggs', '2013-12-22 15:48:27'),
(69, 1, 2, 'Sights of Bird Droppings', 'Close all  the vents', '2013-12-22 15:48:27'),
(70, 1, 3, 'Dirty Storage', 'Clean', '2013-12-22 15:48:27'),
(71, 1, 14, 'Dusty, faded or discolored containers', 'Replace all lights and clean the rest', '2013-12-22 15:48:27'),
(72, 2, 5, 'Allmost all Icecreams are expired and not removed', 'Pay attention to shelf life', '2013-12-22 15:49:58'),
(73, 2, 6, 'Lots of melted frozen yogurt', 'Found in delivery truck,  Use freezer chest', '2013-12-22 15:49:58'),
(74, 3, 22, 'Every one is drinking and smoking inside the kitchen', 'Employees should be instructed not to do that and GMP principles to be thought', '2013-12-22 15:54:30'),
(75, 4, 24, 'People are not wearing hairnet, possible hair contamination', 'Enforce Harinet', '2013-12-22 15:57:07'),
(76, 5, 9, 'Received product from vendor was not maintained the temperature which was recommened', 'Enforce, inbound validation and RFID temp measurement', '2013-12-22 15:59:32'),
(77, 6, 40, 'Food residue presents from previous storage', 'Clean Storage Cabins', '2013-12-22 16:01:36'),
(78, 26, 4, 'Test', 'Test', '2013-12-23 02:41:11'),
(79, 28, 4, 'Test', 'Test', '2013-12-23 02:41:39'),
(80, 30, 3, 'Test', 'Test', '2013-12-23 04:13:20'),
(81, 31, 19, 'Cynaide is not labeled', 'Label all of them', '2013-12-23 16:31:13'),
(82, 31, 31, 'No House Keeping at all', 'Please provide more people', '2013-12-23 16:31:13'),
(83, 31, 42, 'Filty Trash Can', 'Replace it', '2013-12-23 16:31:13'),
(84, 32, 4, 'v', 'vxcvz', '2013-12-23 18:57:41'),
(85, 33, 2, 'Test', 'TEst', '2013-12-23 19:07:04'),
(86, 34, 4, 'gg', 'gg', '2013-12-23 19:09:02'),
(87, 36, 4, 'Test', 'Test', '2013-12-23 19:17:07');

-- --------------------------------------------------------

--
-- Table structure for table `NonProductionDepartmentAuditChecklist`
--

CREATE TABLE IF NOT EXISTS `NonProductionDepartmentAuditChecklist` (
  `DepartmentAuditChecklistID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `DepartmentID` int(10) unsigned NOT NULL DEFAULT '0',
  `NonProductionDeficiencyID` int(10) unsigned NOT NULL DEFAULT '0',
  `isActive` tinyint(1) NOT NULL DEFAULT '1',
  `DateCreated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`DepartmentAuditChecklistID`),
  UNIQUE KEY `Unique_DepartmentDeficiency` (`DepartmentID`,`NonProductionDeficiencyID`),
  KEY `FK_NPDepartmentAuditChecklist_NPDeficienciesList` (`NonProductionDeficiencyID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=316 ;

--
-- Dumping data for table `NonProductionDepartmentAuditChecklist`
--

INSERT INTO `NonProductionDepartmentAuditChecklist` (`DepartmentAuditChecklistID`, `DepartmentID`, `NonProductionDeficiencyID`, `isActive`, `DateCreated`) VALUES
(79, 5, 1, 1, '2013-05-30 19:43:05'),
(80, 6, 1, 1, '2013-05-30 19:43:05'),
(81, 1, 2, 1, '2013-05-30 19:43:05'),
(82, 5, 2, 1, '2013-05-30 19:43:05'),
(83, 6, 2, 1, '2013-05-30 19:43:05'),
(84, 1, 3, 1, '2013-05-30 19:43:05'),
(85, 5, 3, 1, '2013-05-30 19:43:05'),
(86, 6, 3, 1, '2013-05-30 19:43:05'),
(87, 7, 3, 1, '2013-05-30 19:43:05'),
(88, 1, 4, 1, '2013-05-30 19:43:05'),
(89, 2, 4, 1, '2013-05-30 19:43:05'),
(90, 3, 4, 1, '2013-05-30 19:43:05'),
(91, 4, 4, 1, '2013-05-30 19:43:05'),
(92, 5, 4, 1, '2013-05-30 19:43:05'),
(93, 6, 4, 1, '2013-05-30 19:43:05'),
(94, 7, 4, 1, '2013-05-30 19:43:05'),
(95, 1, 5, 1, '2013-05-30 19:43:05'),
(96, 5, 5, 1, '2013-05-30 19:43:05'),
(97, 7, 5, 1, '2013-05-30 19:43:05'),
(98, 7, 6, 1, '2013-05-30 19:43:05'),
(99, 1, 7, 1, '2013-05-30 19:43:05'),
(100, 3, 7, 1, '2013-05-30 19:43:05'),
(101, 4, 7, 1, '2013-05-30 19:43:05'),
(102, 7, 7, 1, '2013-05-30 19:43:05'),
(103, 3, 8, 1, '2013-05-30 19:43:05'),
(104, 3, 9, 1, '2013-05-30 19:43:05'),
(105, 1, 10, 1, '2013-05-30 19:43:05'),
(106, 5, 10, 1, '2013-05-30 19:43:05'),
(107, 6, 10, 1, '2013-05-30 19:43:05'),
(108, 7, 10, 1, '2013-05-30 19:43:05'),
(109, 1, 11, 1, '2013-05-30 19:43:05'),
(110, 2, 11, 1, '2013-05-30 19:43:05'),
(111, 5, 11, 1, '2013-05-30 19:43:05'),
(112, 7, 11, 1, '2013-05-30 19:43:05'),
(113, 1, 12, 1, '2013-05-30 19:43:05'),
(114, 2, 12, 1, '2013-05-30 19:43:05'),
(115, 5, 12, 1, '2013-05-30 19:43:05'),
(116, 6, 12, 1, '2013-05-30 19:43:05'),
(117, 7, 12, 1, '2013-05-30 19:43:05'),
(118, 2, 13, 1, '2013-05-30 19:43:05'),
(119, 1, 14, 1, '2013-05-30 19:43:05'),
(120, 2, 14, 1, '2013-05-30 19:43:05'),
(121, 3, 14, 1, '2013-05-30 19:43:05'),
(122, 4, 14, 1, '2013-05-30 19:43:05'),
(123, 5, 14, 1, '2013-05-30 19:43:05'),
(124, 6, 14, 1, '2013-05-30 19:43:05'),
(125, 7, 14, 1, '2013-05-30 19:43:05'),
(126, 1, 15, 1, '2013-05-30 19:43:05'),
(127, 2, 15, 1, '2013-05-30 19:43:05'),
(128, 3, 15, 1, '2013-05-30 19:43:05'),
(129, 4, 15, 1, '2013-05-30 19:43:05'),
(130, 6, 15, 1, '2013-05-30 19:43:05'),
(131, 7, 15, 1, '2013-05-30 19:43:05'),
(132, 5, 16, 1, '2013-05-30 19:43:05'),
(133, 1, 17, 1, '2013-05-30 19:43:05'),
(134, 2, 17, 1, '2013-05-30 19:43:05'),
(135, 3, 17, 1, '2013-05-30 19:43:05'),
(136, 4, 17, 1, '2013-05-30 19:43:05'),
(137, 5, 17, 1, '2013-05-30 19:43:05'),
(138, 6, 17, 1, '2013-05-30 19:43:05'),
(139, 7, 17, 1, '2013-05-30 19:43:05'),
(140, 1, 18, 1, '2013-05-30 19:43:05'),
(141, 2, 18, 1, '2013-05-30 19:43:05'),
(142, 3, 18, 1, '2013-05-30 19:43:05'),
(143, 4, 18, 1, '2013-05-30 19:43:05'),
(144, 5, 18, 1, '2013-05-30 19:43:05'),
(145, 6, 18, 1, '2013-05-30 19:43:05'),
(146, 7, 18, 1, '2013-05-30 19:43:05'),
(147, 1, 19, 1, '2013-05-30 19:43:05'),
(148, 2, 19, 1, '2013-05-30 19:43:05'),
(149, 3, 19, 1, '2013-05-30 19:43:05'),
(150, 4, 19, 1, '2013-05-30 19:43:05'),
(151, 5, 19, 1, '2013-05-30 19:43:05'),
(152, 6, 19, 1, '2013-05-30 19:43:05'),
(153, 7, 19, 1, '2013-05-30 19:43:05'),
(154, 3, 20, 1, '2013-05-30 19:43:05'),
(155, 4, 20, 1, '2013-05-30 19:43:05'),
(156, 1, 21, 1, '2013-05-30 19:43:05'),
(157, 2, 21, 1, '2013-05-30 19:43:05'),
(158, 3, 21, 1, '2013-05-30 19:43:05'),
(159, 4, 21, 1, '2013-05-30 19:43:05'),
(160, 7, 21, 1, '2013-05-30 19:43:05'),
(161, 1, 22, 1, '2013-05-30 19:43:05'),
(162, 2, 22, 1, '2013-05-30 19:43:05'),
(163, 3, 22, 1, '2013-05-30 19:43:05'),
(164, 4, 22, 1, '2013-05-30 19:43:05'),
(165, 5, 22, 1, '2013-05-30 19:43:05'),
(166, 6, 22, 1, '2013-05-30 19:43:05'),
(167, 7, 22, 1, '2013-05-30 19:43:05'),
(168, 2, 23, 1, '2013-05-30 19:43:05'),
(169, 1, 24, 1, '2013-05-30 19:43:05'),
(170, 2, 24, 1, '2013-05-30 19:43:05'),
(171, 3, 24, 1, '2013-05-30 19:43:05'),
(172, 4, 24, 1, '2013-05-30 19:43:05'),
(173, 7, 24, 1, '2013-05-30 19:43:05'),
(174, 1, 25, 1, '2013-05-30 19:43:05'),
(175, 2, 25, 1, '2013-05-30 19:43:05'),
(176, 3, 25, 1, '2013-05-30 19:43:05'),
(177, 4, 25, 1, '2013-05-30 19:43:05'),
(178, 5, 25, 1, '2013-05-30 19:43:05'),
(179, 6, 25, 1, '2013-05-30 19:43:05'),
(180, 7, 25, 1, '2013-05-30 19:43:05'),
(181, 1, 26, 1, '2013-05-30 19:43:05'),
(182, 5, 26, 1, '2013-05-30 19:43:05'),
(183, 6, 26, 1, '2013-05-30 19:43:05'),
(184, 2, 27, 1, '2013-05-30 19:43:05'),
(185, 1, 28, 1, '2013-05-30 19:43:05'),
(186, 5, 28, 1, '2013-05-30 19:43:05'),
(187, 7, 28, 1, '2013-05-30 19:43:05'),
(188, 1, 29, 1, '2013-05-30 19:43:05'),
(189, 3, 29, 1, '2013-05-30 19:43:05'),
(190, 4, 29, 1, '2013-05-30 19:43:05'),
(191, 5, 29, 1, '2013-05-30 19:43:05'),
(192, 6, 29, 1, '2013-05-30 19:43:05'),
(193, 7, 29, 1, '2013-05-30 19:43:05'),
(194, 1, 30, 1, '2013-05-30 19:43:05'),
(195, 2, 30, 1, '2013-05-30 19:43:05'),
(196, 5, 30, 1, '2013-05-30 19:43:05'),
(197, 7, 30, 1, '2013-05-30 19:43:05'),
(198, 1, 31, 1, '2013-05-30 19:43:05'),
(199, 2, 31, 1, '2013-05-30 19:43:05'),
(200, 3, 31, 1, '2013-05-30 19:43:05'),
(201, 4, 31, 1, '2013-05-30 19:43:05'),
(202, 5, 31, 1, '2013-05-30 19:43:05'),
(203, 6, 31, 1, '2013-05-30 19:43:05'),
(204, 7, 31, 1, '2013-05-30 19:43:05'),
(205, 1, 32, 1, '2013-05-30 19:43:05'),
(206, 2, 32, 1, '2013-05-30 19:43:05'),
(207, 3, 32, 1, '2013-05-30 19:43:05'),
(208, 4, 32, 1, '2013-05-30 19:43:05'),
(209, 5, 32, 1, '2013-05-30 19:43:05'),
(210, 6, 32, 1, '2013-05-30 19:43:05'),
(211, 7, 32, 1, '2013-05-30 19:43:05'),
(212, 1, 33, 1, '2013-05-30 19:43:05'),
(213, 2, 33, 1, '2013-05-30 19:43:05'),
(214, 3, 33, 1, '2013-05-30 19:43:05'),
(215, 4, 33, 1, '2013-05-30 19:43:05'),
(216, 5, 33, 1, '2013-05-30 19:43:05'),
(217, 6, 33, 1, '2013-05-30 19:43:05'),
(218, 7, 33, 1, '2013-05-30 19:43:05'),
(219, 2, 34, 1, '2013-05-30 19:43:05'),
(220, 4, 34, 1, '2013-05-30 19:43:05'),
(221, 2, 36, 1, '2013-05-30 19:43:05'),
(222, 3, 36, 1, '2013-05-30 19:43:05'),
(223, 4, 36, 1, '2013-05-30 19:43:05'),
(224, 5, 36, 1, '2013-05-30 19:43:05'),
(225, 6, 36, 1, '2013-05-30 19:43:05'),
(226, 7, 36, 1, '2013-05-30 19:43:05'),
(227, 1, 37, 1, '2013-05-30 19:43:05'),
(228, 5, 37, 1, '2013-05-30 19:43:05'),
(229, 6, 37, 1, '2013-05-30 19:43:05'),
(230, 2, 38, 1, '2013-05-30 19:43:05'),
(231, 1, 40, 1, '2013-05-30 19:43:05'),
(232, 2, 40, 1, '2013-05-30 19:43:05'),
(233, 3, 40, 1, '2013-05-30 19:43:05'),
(234, 4, 40, 1, '2013-05-30 19:43:05'),
(235, 5, 40, 1, '2013-05-30 19:43:05'),
(236, 7, 40, 1, '2013-05-30 19:43:05'),
(237, 4, 41, 1, '2013-05-30 19:43:05'),
(238, 1, 42, 1, '2013-05-30 19:43:05'),
(239, 2, 42, 1, '2013-05-30 19:43:05'),
(240, 3, 42, 1, '2013-05-30 19:43:05'),
(241, 4, 42, 1, '2013-05-30 19:43:05'),
(242, 5, 42, 1, '2013-05-30 19:43:05'),
(243, 6, 42, 1, '2013-05-30 19:43:05'),
(244, 7, 42, 1, '2013-05-30 19:43:05'),
(245, 1, 43, 1, '2013-05-30 19:43:05'),
(246, 2, 43, 1, '2013-05-30 19:43:05'),
(247, 3, 43, 1, '2013-05-30 19:43:05'),
(248, 4, 43, 1, '2013-05-30 19:43:05'),
(249, 5, 43, 1, '2013-05-30 19:43:05'),
(250, 6, 43, 1, '2013-05-30 19:43:05'),
(251, 7, 43, 1, '2013-05-30 19:43:05'),
(252, 6, 44, 1, '2013-05-30 19:43:05'),
(253, 5, 45, 1, '2013-05-30 19:43:05'),
(254, 1, 46, 1, '2013-07-29 18:45:45'),
(255, 2, 46, 1, '2013-07-29 18:45:45'),
(256, 3, 46, 1, '2013-07-29 18:45:45'),
(257, 4, 46, 1, '2013-07-29 18:45:45'),
(258, 5, 46, 1, '2013-07-29 18:45:45'),
(259, 6, 46, 1, '2013-07-29 18:45:45'),
(260, 7, 46, 1, '2013-07-29 18:45:45'),
(261, 8, 46, 1, '2013-07-29 18:45:45'),
(262, 1, 47, 1, '2013-07-29 18:45:45'),
(263, 2, 47, 1, '2013-07-29 18:45:45'),
(264, 3, 47, 1, '2013-07-29 18:45:45'),
(265, 4, 47, 1, '2013-07-29 18:45:45'),
(266, 5, 47, 1, '2013-07-29 18:45:45'),
(267, 6, 47, 1, '2013-07-29 18:45:45'),
(268, 7, 47, 1, '2013-07-29 18:45:45'),
(269, 8, 47, 1, '2013-07-29 18:45:45'),
(270, 1, 48, 1, '2013-07-29 18:46:29'),
(271, 2, 48, 1, '2013-07-29 18:46:29'),
(272, 3, 48, 1, '2013-07-29 18:46:29'),
(273, 4, 48, 1, '2013-07-29 18:46:29'),
(274, 5, 48, 1, '2013-07-29 18:46:29'),
(275, 6, 48, 1, '2013-07-29 18:46:29'),
(276, 7, 48, 1, '2013-07-29 18:46:29'),
(277, 8, 48, 1, '2013-07-29 18:46:29'),
(278, 1, 49, 1, '2013-07-29 18:46:29'),
(279, 2, 49, 1, '2013-07-29 18:46:29'),
(280, 3, 49, 1, '2013-07-29 18:46:29'),
(281, 4, 49, 1, '2013-07-29 18:46:29'),
(282, 5, 49, 1, '2013-07-29 18:46:29'),
(283, 6, 49, 1, '2013-07-29 18:46:29'),
(284, 7, 49, 1, '2013-07-29 18:46:29'),
(285, 8, 49, 1, '2013-07-29 18:46:29'),
(286, 8, 1, 1, '2013-08-08 20:29:57'),
(287, 8, 2, 1, '2013-08-08 20:29:57'),
(288, 8, 3, 1, '2013-08-08 20:29:57'),
(289, 8, 4, 1, '2013-08-08 20:29:57'),
(290, 8, 5, 1, '2013-08-08 20:29:57'),
(291, 8, 6, 1, '2013-08-08 20:29:57'),
(292, 8, 10, 1, '2013-08-08 20:29:57'),
(293, 8, 11, 1, '2013-08-08 20:29:57'),
(294, 8, 12, 1, '2013-08-08 20:29:57'),
(295, 8, 14, 1, '2013-08-08 20:29:57'),
(296, 8, 15, 1, '2013-08-08 20:29:57'),
(297, 8, 17, 1, '2013-08-08 20:29:57'),
(298, 8, 18, 1, '2013-08-08 20:29:57'),
(299, 8, 19, 1, '2013-08-08 20:29:57'),
(300, 8, 20, 1, '2013-08-08 20:29:57'),
(301, 8, 21, 1, '2013-08-08 20:29:57'),
(302, 8, 22, 1, '2013-08-08 20:29:57'),
(303, 8, 23, 1, '2013-08-08 20:29:57'),
(304, 8, 24, 1, '2013-08-08 20:29:57'),
(305, 8, 25, 1, '2013-08-08 20:29:57'),
(306, 8, 26, 1, '2013-08-08 20:29:57'),
(307, 8, 28, 1, '2013-08-08 20:29:57'),
(308, 8, 29, 1, '2013-08-08 20:29:57'),
(309, 8, 30, 1, '2013-08-08 20:29:57'),
(310, 8, 31, 1, '2013-08-08 20:29:57'),
(311, 8, 39, 1, '2013-08-08 20:29:57'),
(312, 8, 40, 1, '2013-08-08 20:29:57'),
(313, 8, 42, 1, '2013-08-08 20:29:57'),
(314, 8, 43, 1, '2013-08-08 20:29:57'),
(315, 0, 0, 0, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `NonProductionDepartmentList`
--

CREATE TABLE IF NOT EXISTS `NonProductionDepartmentList` (
  `DepartmentID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `DepartmentName` varchar(45) NOT NULL DEFAULT '',
  `isActive` tinyint(1) NOT NULL DEFAULT '1',
  `DateCreated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `NotificationEmailAddresses` text NOT NULL,
  PRIMARY KEY (`DepartmentID`) USING BTREE,
  UNIQUE KEY `Unique_DepartmentName` (`DepartmentName`) USING BTREE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `NonProductionDepartmentList`
--

INSERT INTO `NonProductionDepartmentList` (`DepartmentID`, `DepartmentName`, `isActive`, `DateCreated`, `NotificationEmailAddresses`) VALUES
(1, 'Dairy Department', 1, '0000-00-00 00:00:00', 'ponnusamy@hotmail.com'),
(2, 'Packing Department', 1, '2013-12-04 10:00:00', 'packing@freshdirectvendor.us'),
(3, 'Receiving Department', 1, '2013-12-03 08:00:00', 'ponnusamy@hotmail.com'),
(4, 'Shipping Department', 1, '0000-00-00 00:00:00', 'ponnusamy@hotmail.com,shippingmanagement@freshdirectvendor.us'),
(5, 'Grocery Department', 1, '0000-00-00 00:00:00', 'Drygoods@freshdirectvendor.com,ponnusamy@hotmail.com'),
(6, 'Kitchen (Cooking and Preparation) Department', 1, '2013-12-12 13:00:00', 'ponnusamy@hotmail.com,kitchen@freshdirectvendor.us'),
(7, 'Freezer Department', 1, '2013-12-11 18:30:30', 'Freezer@freshdirectvendor.us,ponnusamy@hotmail.com'),
(8, 'HMR Warehouse', 1, '0000-00-00 00:00:00', 'laboratory@freshdirect.com,triaz@freshdirect.com,mstark@freshdirect.com,bakerypastryproduction@freshdirect.com,hmrsouschefs@freshdirect.com,hmrwarehousing@freshdirect.com');

-- --------------------------------------------------------

--
-- Table structure for table `NonProductionInspectionLog`
--

CREATE TABLE IF NOT EXISTS `NonProductionInspectionLog` (
  `NonProductionInspectionLogID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `DepartmentID` int(10) unsigned NOT NULL DEFAULT '0',
  `AuthUserID` int(10) unsigned NOT NULL DEFAULT '0',
  `isActive` tinyint(1) NOT NULL DEFAULT '1',
  `DateCreated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`NonProductionInspectionLogID`) USING BTREE,
  KEY `FK_NPInspectionLog_NPDepartmentList` (`DepartmentID`),
  KEY `FK_NPInspectionLog_AuthUSers` (`AuthUserID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=38 ;

--
-- Dumping data for table `NonProductionInspectionLog`
--

INSERT INTO `NonProductionInspectionLog` (`NonProductionInspectionLogID`, `DepartmentID`, `AuthUserID`, `isActive`, `DateCreated`) VALUES
(1, 1, 1, 1, '2013-12-22 15:48:27'),
(2, 7, 6, 1, '2013-12-22 15:49:58'),
(3, 6, 1, 1, '2013-12-22 15:54:30'),
(4, 4, 8, 1, '2013-12-22 15:57:07'),
(5, 3, 9, 1, '2013-12-22 15:59:32'),
(6, 5, 10, 1, '2013-12-22 16:01:36'),
(7, 3, 7, 1, '2013-12-22 17:00:19'),
(8, 3, 6, 1, '2013-12-23 02:18:38'),
(9, 6, 6, 1, '2013-12-23 02:18:59'),
(10, 4, 6, 1, '2013-12-23 02:19:32'),
(11, 5, 6, 1, '2013-12-23 02:21:25'),
(12, 3, 6, 1, '2013-12-23 02:21:52'),
(13, 3, 6, 1, '2013-12-23 02:22:16'),
(14, 3, 6, 1, '2013-12-23 02:23:56'),
(15, 3, 5, 1, '2013-12-23 02:24:24'),
(16, 5, 5, 1, '2013-12-23 02:26:11'),
(17, 5, 5, 1, '2013-12-23 02:26:37'),
(18, 2, 5, 1, '2013-12-23 02:28:46'),
(19, 2, 5, 1, '2013-12-23 02:29:02'),
(20, 6, 5, 1, '2013-12-23 02:29:35'),
(21, 6, 5, 1, '2013-12-23 02:31:24'),
(22, 3, 5, 1, '2013-12-23 02:32:18'),
(23, 4, 5, 1, '2013-12-23 02:34:01'),
(24, 6, 5, 1, '2013-12-23 02:37:25'),
(25, 8, 5, 1, '2013-12-23 02:37:55'),
(26, 2, 5, 1, '2013-12-23 02:41:11'),
(27, 5, 5, 1, '2013-12-23 02:41:21'),
(28, 5, 5, 1, '2013-12-23 02:41:39'),
(29, 5, 1, 1, '2013-12-23 04:13:00'),
(30, 7, 1, 1, '2013-12-23 04:13:20'),
(31, 6, 13, 1, '2013-12-23 16:31:13'),
(32, 3, 1, 1, '2013-12-23 18:57:41'),
(33, 6, 1, 1, '2013-12-23 19:07:04'),
(34, 3, 1, 1, '2013-12-23 19:09:01'),
(35, 4, 1, 1, '2013-12-23 19:16:30'),
(36, 2, 1, 1, '2013-12-23 19:17:07'),
(37, 7, 1, 1, '2013-12-23 19:17:23');

-- --------------------------------------------------------

--
-- Table structure for table `ProductionDeficienciesList`
--

CREATE TABLE IF NOT EXISTS `ProductionDeficienciesList` (
  `ProductionDeficiencyID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ProductionDeficiencyName` varchar(255) NOT NULL DEFAULT '',
  `ProductionDeficiencyRiskFactor` varchar(3) NOT NULL DEFAULT '',
  `ProductionDeficiencyScore` int(10) unsigned NOT NULL DEFAULT '0',
  `DateCreated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `isActive` tinyint(1) NOT NULL DEFAULT '1',
  `GMPCategoryID` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`ProductionDeficiencyID`) USING BTREE,
  UNIQUE KEY `Unique_ProductionDeficiencyName` (`ProductionDeficiencyName`) USING BTREE,
  KEY `FK_ProductionDeficienciesList_GMPCategories` (`GMPCategoryID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `ProductionDeficienciesLog`
--

CREATE TABLE IF NOT EXISTS `ProductionDeficienciesLog` (
  `ProductionDeficienciesLogID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ProductionInspectionLogID` int(10) unsigned NOT NULL DEFAULT '0',
  `ProductionDeficiencyID` int(10) unsigned NOT NULL DEFAULT '0',
  `Comments` text CHARACTER SET latin1 NOT NULL,
  `CorrectiveActions` text CHARACTER SET latin1 NOT NULL,
  `DateCreated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ProductionDeficienciesLogID`) USING BTREE,
  KEY `FK_PDeficienciesLog_PInspectionLog` (`ProductionInspectionLogID`),
  KEY `FK_PDeficienciesLog_PDeficienciesList` (`ProductionDeficiencyID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `ProductionDepartmentAuditChecklist`
--

CREATE TABLE IF NOT EXISTS `ProductionDepartmentAuditChecklist` (
  `DepartmentAuditChecklistID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `DepartmentID` int(10) unsigned NOT NULL DEFAULT '0',
  `ProductionDeficiencyID` int(10) unsigned NOT NULL DEFAULT '0',
  `isActive` tinyint(1) NOT NULL DEFAULT '1',
  `DateCreated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`DepartmentAuditChecklistID`),
  KEY `FK_ProductionDepartmentAuditChecklist_ProductionDepartmentList` (`DepartmentID`),
  KEY `FK_ProductionDepartmentAuditChecklist_ProductionDeficiencyList` (`ProductionDeficiencyID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `ProductionDepartmentList`
--

CREATE TABLE IF NOT EXISTS `ProductionDepartmentList` (
  `DepartmentID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `DepartmentName` varchar(45) NOT NULL DEFAULT '',
  `isActive` tinyint(1) NOT NULL DEFAULT '1',
  `DateCreated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `NotificationEmailAddresses` text NOT NULL,
  PRIMARY KEY (`DepartmentID`) USING BTREE,
  UNIQUE KEY `Unique_DepartmentName` (`DepartmentName`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `ProductionInspectionLog`
--

CREATE TABLE IF NOT EXISTS `ProductionInspectionLog` (
  `ProductionInspectionLogID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `DepartmentID` int(10) unsigned NOT NULL DEFAULT '0',
  `AuthUserID` int(10) unsigned NOT NULL DEFAULT '0',
  `isActive` tinyint(1) NOT NULL DEFAULT '1',
  `DateCreated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ProductionInspectionLogID`) USING BTREE,
  KEY `FK_PInspectionLog_PDepartmentList` (`DepartmentID`),
  KEY `FK_PInspectionLog_AuthUSers` (`AuthUserID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `AuthUserID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `first_name` varchar(45) NOT NULL,
  `last_name` varchar(45) DEFAULT NULL,
  `isAdmin` tinyint(1) NOT NULL DEFAULT '0',
  `isActive` tinyint(1) NOT NULL DEFAULT '1',
  `DateCreated` int(11) NOT NULL,
  `DateChanged` int(11) NOT NULL,
  `token` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `last_login` int(11) NOT NULL,
  `timezone` int(11) NOT NULL,
  PRIMARY KEY (`AuthUserID`),
  UNIQUE KEY `UniqueUserName` (`first_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`AuthUserID`, `first_name`, `last_name`, `isAdmin`, `isActive`, `DateCreated`, `DateChanged`, `token`, `password`, `email`, `last_login`, `timezone`) VALUES
(1, 'Nallasamy', 'Ponnusamy', 0, 1, 1387399175, 1387399175, '903bdb6cf68827de48ef23dcf583a377b10dfd64', 'cc01e984dea94b6089eccf83e48b056e732018d5', 'pnallasamy@freshdirect.com', 0, 0),
(3, 'Nalla', 'Ponnu', 0, 1, 1387400069, 1387400069, '33088f2512ab3cfe9cd57dfd8e0a595f4778e062', 'bf0ac8f4177843110d4ab9f9bd9a61231fa692d2', 'ponnul@yahoo.com', 0, 0),
(5, 'Kavitha', 'Ponnusamy', 0, 1, 1387402616, 1387402616, '64317e1250621bd8f9843f85124d15f93e4aa49e', '3ba603815f6a1e7e909b57f5f24eac7d024c2285', 'kavi_ps_2000@yahoo.com', 0, 0),
(6, 'Susan', 'Buck', 0, 1, 1387680936, 1387680936, 'f7fb29e2531b47c7400e2053b5ac0e54620ee932', '5f0f770d511181511fc073e58179f19df12cee4d', 'susan@harvard.edu', 0, 0),
(7, 'Naren', 'Ponnusamy', 0, 1, 1387690710, 1387690710, 'd22c4a112fcb43f0fca4fa76f05c27d5850ae977', '1a441608aa2fc654144d43317b1f24dd58af32ac', 'naren@harvard.edu', 0, 0),
(8, 'Johanna Bodnyk', 'TF', 0, 1, 1387727587, 1387727587, 'e6d5f40bfd631c1d4e557afadbe034c7336dbc7b', '5f0f770d511181511fc073e58179f19df12cee4d', 'JohannaBodnyk@mail.com', 0, 0),
(9, 'Anibal Cruz ', 'Harvard', 0, 1, 1387727895, 1387727895, 'bec839ad09cf8d7d17e2dd4e3a165e120fe999f5', '5f0f770d511181511fc073e58179f19df12cee4d', 'Anibal Cruz@mail.com', 0, 0),
(10, 'Alain Ibrahim', 'TF', 0, 1, 1387728028, 1387728028, 'e074d0591d292a29e5cbba6c60888a418ab28436', '5f0f770d511181511fc073e58179f19df12cee4d', 'Alain Ibrahim@mail.com', 0, 0),
(11, 'Dinesh', 'Ramalingam', 0, 1, 1387739281, 1387739281, 'f3c005bc33903a4e054f243b6be051e2b9a2aa24', '0da9966ed7d8237569752b888dbeee558e08b7b7', 'dinesh.sweetdreams@gmail.com', 0, 0),
(12, 'c', 'g', 0, 1, 1387762860, 1387762860, 'effc832cef845e42c14750b9a83cba28ce08a1ca', 'cee7bd1ef136aab596360411884e2437c5587bb0', 'cg@abc.com', 0, 0),
(13, 'Xin Xin', 'TF', 0, 1, 1387816182, 1387816182, '1a4f8b17607d9d2446d2b477dd9182fff9ef8f69', 'c3d9e94358e4d2647ef07a517d62a162990cb4ef', 'XINXIN@XIN.com', 0, 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
