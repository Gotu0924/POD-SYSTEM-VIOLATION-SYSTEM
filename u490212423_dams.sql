-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jan 15, 2026 at 05:29 AM
-- Server version: 11.8.3-MariaDB-log
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u490212423_dams`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins_archive`
--

CREATE TABLE `admins_archive` (
  `a_ID` int(11) NOT NULL,
  `a_Firstname` varchar(100) DEFAULT NULL,
  `a_Lastname` varchar(100) DEFAULT NULL,
  `a_Role` varchar(50) DEFAULT NULL,
  `a_PhoneNumber` varchar(20) DEFAULT NULL,
  `a_username` varchar(100) DEFAULT NULL,
  `a_password` varchar(255) DEFAULT NULL,
  `a_gmail` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins_archive`
--

INSERT INTO `admins_archive` (`a_ID`, `a_Firstname`, `a_Lastname`, `a_Role`, `a_PhoneNumber`, `a_username`, `a_password`, `a_gmail`) VALUES
(1, 'Cyrel James', 'Baltucon', 'staff', '975-396-5505', 'user2', '$2y$10$XLMDhw0/z1q3cSOOJY0uYuLgvs49AVd0XAQmNeu9ooi4lPpmBR.a2', 'N/A');

-- --------------------------------------------------------

--
-- Table structure for table `appeals_archive`
--

CREATE TABLE `appeals_archive` (
  `appeal_ID` int(11) NOT NULL,
  `st_ID` varchar(50) DEFAULT NULL,
  `violation_number` varchar(4) DEFAULT NULL,
  `sender_name` varchar(100) DEFAULT NULL,
  `sender_email` varchar(100) DEFAULT NULL,
  `course` varchar(100) DEFAULT NULL,
  `year_level` varchar(20) DEFAULT NULL,
  `l_appeal_message` text DEFAULT NULL,
  `images` varchar(255) DEFAULT NULL,
  `videos` varchar(255) DEFAULT NULL,
  `l_Time` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appeals_archive`
--

INSERT INTO `appeals_archive` (`appeal_ID`, `st_ID`, `violation_number`, `sender_name`, `sender_email`, `course`, `year_level`, `l_appeal_message`, `images`, `videos`, `l_Time`) VALUES
(1, '123456', '2069', 'Jhunrey R. Martel', 'sdas@smcbi.edu.ph', 'BSIT', '2', 'test', 'podmaster/st_img/img_68de14e4aa8be_84f850b7-71a3-4042-8b9e-4fe5d60bd856.jpg', 'podmaster/st_vid/vid_68de14e4ab2a7_A114 03201510 C038.mp4', '2025-10-02 06:00:04');

-- --------------------------------------------------------

--
-- Table structure for table `guardian_archive`
--

CREATE TABLE `guardian_archive` (
  `g_ID` int(11) NOT NULL,
  `g_FirstName` varchar(50) DEFAULT NULL,
  `g_LastName` varchar(50) DEFAULT NULL,
  `st_ID` varchar(50) DEFAULT NULL,
  `st_name` varchar(255) DEFAULT NULL,
  `g_Address` text DEFAULT NULL,
  `g_PhoneNumber` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `guardian_archive`
--

INSERT INTO `guardian_archive` (`g_ID`, `g_FirstName`, `g_LastName`, `st_ID`, `st_name`, `g_Address`, `g_PhoneNumber`) VALUES
(1, 'Diana', 'Martel', '123456', 'Jhunrey R. Martel', 'Bansalan', '9101985380');

-- --------------------------------------------------------

--
-- Table structure for table `history_staff`
--

CREATE TABLE `history_staff` (
  `log_ID` int(11) NOT NULL,
  `violation_number` char(4) NOT NULL,
  `st_ID` varchar(50) NOT NULL,
  `st_name` varchar(255) DEFAULT NULL,
  `i_Category` varchar(100) NOT NULL,
  `list_Offense` text NOT NULL,
  `i_Sanctions` varchar(100) NOT NULL,
  `Suspension_Type` varchar(50) NOT NULL DEFAULT 'N/A',
  `i_Details` text DEFAULT NULL,
  `i_Recommendation` text DEFAULT NULL,
  `i_Status` varchar(50) NOT NULL,
  `a_username` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `history_staff`
--

INSERT INTO `history_staff` (`log_ID`, `violation_number`, `st_ID`, `st_name`, `i_Category`, `list_Offense`, `i_Sanctions`, `Suspension_Type`, `i_Details`, `i_Recommendation`, `i_Status`, `a_username`, `created_at`) VALUES
(1, '8565', '123456', 'Jhunrey R. Martel', 'Category C', 'Libel or malicious defamation', 'Reprimand', 'N/A', 'dsaas', 'dsads', 'Pending', 'user1', '2025-10-21 19:45:57'),
(2, '4857', '123456', 'Jhunrey R. Martel', 'Category B', 'Public disturbances', 'Reprimand', 'N/A', 'asddsa', 'asddsa', 'Pending', 'user1', '2025-10-24 23:21:55');

-- --------------------------------------------------------

--
-- Table structure for table `issues_archive`
--

CREATE TABLE `issues_archive` (
  `i_ID` int(11) NOT NULL,
  `st_ID` varchar(255) DEFAULT NULL,
  `i_Category` varchar(100) DEFAULT NULL,
  `list_Offense` text DEFAULT NULL,
  `i_Sanctions` text DEFAULT NULL,
  `Suspension_Type` varchar(50) DEFAULT NULL,
  `i_Details` text DEFAULT NULL,
  `i_Recommendation` text DEFAULT NULL,
  `i_Status` varchar(50) DEFAULT NULL,
  `violation_number` varchar(50) DEFAULT NULL,
  `a_username` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `issues_archive`
--

INSERT INTO `issues_archive` (`i_ID`, `st_ID`, `i_Category`, `list_Offense`, `i_Sanctions`, `Suspension_Type`, `i_Details`, `i_Recommendation`, `i_Status`, `violation_number`, `a_username`) VALUES
(15, '123456', 'Category A', 'Loitering and creating noise', 'Reprimand', 'N/A', 'test1', 'test1', 'Pending', '2069', 'user1');

-- --------------------------------------------------------

--
-- Table structure for table `logs_archive`
--

CREATE TABLE `logs_archive` (
  `i_ID` int(11) DEFAULT NULL,
  `st_ID` varchar(50) DEFAULT NULL,
  `i_Category` varchar(100) DEFAULT NULL,
  `list_Offense` text DEFAULT NULL,
  `i_Sanctions` text DEFAULT NULL,
  `Suspension_Type` varchar(50) DEFAULT NULL,
  `i_Details` text DEFAULT NULL,
  `i_Recommendation` text DEFAULT NULL,
  `i_Status` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `staff_archive`
--

CREATE TABLE `staff_archive` (
  `s_ID` int(11) NOT NULL,
  `s_Title` varchar(10) DEFAULT NULL,
  `s_Firstname` varchar(50) DEFAULT NULL,
  `s_Middlename` varchar(50) DEFAULT NULL,
  `s_Lastname` varchar(50) DEFAULT NULL,
  `st_ID` varchar(50) DEFAULT NULL,
  `s_DOB` date DEFAULT NULL,
  `s_CourseOfStudy` varchar(100) DEFAULT NULL,
  `year_level` varchar(20) DEFAULT NULL,
  `s_Gender` varchar(10) DEFAULT NULL,
  `s_Address` text DEFAULT NULL,
  `s_PhoneNumber` varchar(20) DEFAULT NULL,
  `religion` varchar(50) DEFAULT NULL,
  `if_licence` varchar(10) DEFAULT NULL,
  `if_licence_registration` varchar(100) DEFAULT NULL,
  `s_DateAdded` date DEFAULT NULL,
  `s_PicturePath` varchar(255) DEFAULT NULL,
  `s_Password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `st_archive`
--

CREATE TABLE `st_archive` (
  `s_ID` int(11) NOT NULL,
  `s_Firstname` varchar(50) DEFAULT NULL,
  `s_Middlename` varchar(50) DEFAULT NULL,
  `s_Lastname` varchar(50) DEFAULT NULL,
  `st_ID` varchar(50) DEFAULT NULL,
  `s_DOB` date DEFAULT NULL,
  `s_CourseOfStudy` varchar(100) DEFAULT NULL,
  `year_level` varchar(20) DEFAULT NULL,
  `s_Gender` varchar(10) DEFAULT NULL,
  `s_Address` text DEFAULT NULL,
  `s_PhoneNumber` varchar(20) DEFAULT NULL,
  `religion` varchar(50) DEFAULT NULL,
  `if_licence` varchar(10) DEFAULT NULL,
  `if_licence_registration` varchar(100) DEFAULT NULL,
  `s_DateAdded` date DEFAULT NULL,
  `s_PicturePath` varchar(255) DEFAULT NULL,
  `s_Password` varchar(255) DEFAULT NULL,
  `school_year` varchar(20) DEFAULT NULL,
  `s_gmail` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `st_archive`
--

INSERT INTO `st_archive` (`s_ID`, `s_Firstname`, `s_Middlename`, `s_Lastname`, `st_ID`, `s_DOB`, `s_CourseOfStudy`, `year_level`, `s_Gender`, `s_Address`, `s_PhoneNumber`, `religion`, `if_licence`, `if_licence_registration`, `s_DateAdded`, `s_PicturePath`, `s_Password`, `school_year`, `s_gmail`) VALUES
(1, 'Jhunrey', 'R.', 'Martel', '123456', '0000-00-00', 'BSIT', '2', 'Male', 'Bansalan', '9758317105', 'Catholic', 'N/A', 'N/A', '2025-10-02', '', '$2y$10$wzkKPC28uw4Ufo7y4FmpCueeyRzKLjrbGLO2bRVa3.qxzhdI5hlEm', '2026-2027', 'sdas@smcbi.edu.ph');

-- --------------------------------------------------------

--
-- Table structure for table `t_admins`
--

CREATE TABLE `t_admins` (
  `a_ID` int(11) NOT NULL,
  `a_Firstname` varchar(50) DEFAULT NULL,
  `a_Lastname` varchar(50) DEFAULT NULL,
  `a_Role` varchar(50) DEFAULT NULL,
  `a_PhoneNumber` varchar(20) DEFAULT NULL,
  `a_username` varchar(50) DEFAULT NULL,
  `a_password` varchar(255) DEFAULT NULL,
  `a_Gmail` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `t_admins`
--

INSERT INTO `t_admins` (`a_ID`, `a_Firstname`, `a_Lastname`, `a_Role`, `a_PhoneNumber`, `a_username`, `a_password`, `a_Gmail`) VALUES
(1, 'Christine Jiji', 'Sajol', 'staff', '9276059397', 'user1', '$2y$10$sMc.1tnt5SCrtnh8xTI93OvmUznYdfievP9kanZEFqPEkL2oK8mVC', 'N/A'),
(2, 'Cyrel James', 'Baltucon', 'staff', '9753965505', 'user2', '$2y$10$NphX.pq0w.l2ouI82yXH2u3cV/dc2t7x2LbgsZMbkUM/GtDsZ41A.', 'N/A'),
(3, 'Jonathan Jr.', 'Dacalanio', 'staff', '9382097984', 'user3', '$2y$10$Ih8d85qOmUxb1TaFs7dOQuBt3JRF4kABoYN1/gIVEL58FqHsiHlPm', 'N/A'),
(4, 'Melanie', 'Waskin', 'staff', '9387627169', 'user4', '$2y$10$KLHXAcZhhxSHwjRif5sHMu3xLgFxNAg89Y3AD9PueH33.0bYcf1Ma', 'N/A'),
(5, 'Sheila Mae', 'Bongabong', 'staff', '9260665570', 'user5', '$2y$10$xJpagvJJv9.Ko7AZrJntXO0h6ewPaCdpcpF50th3tOyufZHRI6dnS', 'N/A'),
(6, 'Carl Jacob', 'Quirante', 'staff', '9999056043', 'user6', '$2y$10$43.t7Uq8YnH56jOAOISege90ilvsjy3JYgtSVrW.s8iQWduDT5YmK', 'N/A'),
(7, 'Deither', 'Pasadilla', 'staff', '9952562628', 'user7', '$2y$10$T6n0HWex3XBHbd3vOPUjuOghTPb424.NI/tHhjqp0L.BXXlox9WoK', 'N/A'),
(8, 'John Gabriel', 'Gultimo', 'staff', '9568537171', 'user8', '$2y$10$CrntDbSCeiwIDxTXXfb2uerBQf06emvM3FkijqB4jq/pTK0u5Lgve', 'N/A'),
(9, 'Sheryl', 'Singkala', 'staff', '9308807074', 'user9', '$2y$10$pMNyTmmkX8B2UtDutEHP3.2WZo2cYiq8LK7q82RjZ1.HDQtXa7dvC', 'N/A'),
(10, 'Sheena', 'Cosmod', 'staff', '9382973540', 'user10', '$2y$10$.g3n5rkSmcwOKA6D1BEgTuR/t7ohBNm2AtUYenSu/MCHaahWfL5pq', 'N/A'),
(11, '(Joe) Gabriel', 'Rios', '(super)admin', '9308145849', 'admin', '$2y$10$o6dBLQvepb5MwIY01y56F.Z1va2B5vsYXky5KD6FgiA5marC56sRO', 'N/A'),
(12, 'Developer', 'Eiam Kurl', 'admin', '9308145850', 'Gotu', '$2y$10$bRS41IYaEdwWp9dx3VpNJuSGQHBCGMJbAF0oVuBSE./xLFJ7iCpGG', 'abaldeeiamkurl@smcbi.edu.ph'),
(13, 'Richel Mae', 'Wabingga', 'staff', '9466363605', 'user12', '$2y$10$6Wlru15RLKE8JTGnIWP30.ByUqrma51SSBdh2cX9sLSR8IpSO42VK', 'N/A'),
(14, 'Aidan Lloyd', 'Donaire', 'staff', '9305044742', 'user13', '$2y$10$aNGzweZOcYeCEafhkTX5JOve7cLplRsUAPbWkXxi0iU4o6AExyOw.', 'N/A'),
(15, 'Rosalinda', 'Dedal', 'staff', '9272430734', 'user14', '$2y$10$O193/idI49kqiYcOGLr8ReTbQT60WKm65lz5TLtH4SRBwmi3PSou.', 'N/A'),
(16, 'Rey Ann', 'Laranjo', 'staff', '9453348396', 'user15', '$2y$10$y/eEUIvBLqaFPpivn/.OMOwgFvg7IX.RxFQ/Jsol17MuEwUiSnbmu', 'N/A'),
(17, 'Ramon Barcena', 'Rega?a Jr.', 'staff', '9692019135', 'user16', '$2y$10$vjG2Lb543QGrhjtdjT4mueDTbe.hGX9QC3IYb2yQVF78n9QC2y.PO', 'N/A'),
(18, 'Lenie Jean', 'Gajera', 'staff', '9125957461', 'user17', '$2y$10$6rLyJS41YUpuIT/UrnyRu.0Zw3KSizUIidTxqnRHBQW4YsV7VZm3u', 'N/A'),
(19, 'Mayngel', 'Relatado', 'staff', '9603159721', 'user18', '$2y$10$0qYMUkSpRbv8TaX9lBL6g.0wX4Fswll/1M59B281GSraAiYRWxa9C', 'N/A'),
(20, 'Jhon Bryan', 'Cantil', 'staff', '9519025957', 'user19', '$2y$10$siOSWPPnEU.rEJMCxCaYhOveWLUydJMshbAWsG/7NRuvOtit7twN6', 'N/A'),
(21, 'Jay-Ann', 'Nuyad', 'staff', '9105067579', 'user20', '$2y$10$GXErmEfZxtRKDj/RuRbMouPe7oByn5QmxGjt6s84mhq9LgsKGg8O.', 'N/A'),
(22, 'Rhyven Jay', 'Caballero', 'staff', '9518529079', 'user21', '$2y$10$REuMg9VAMwVIZPGXzFuLyuifSGn6wT5RW8eONFsNNSeTkbGiNMvyi', 'N/A'),
(23, 'Benny Jr.', 'Ruguian', 'staff', '9487495662', 'user22', '$2y$10$g1.hbj2L7egmWLdkgq4MZec75M8ZCWebJ.orj3tk49ChHLUDrC8E2', 'N/A'),
(24, 'Rowena', 'Qui?o', 'staff', '9381528096', 'user23', '$2y$10$IVS3oSAYJquZho888o.PW.HB5AOqlkbiFTVXsoO0oItUkVija84RG', 'N/A'),
(25, 'Monaliza', 'Manaug', 'staff', '9510638492', 'user24', '$2y$10$oie9ACSoOqSqSrhR0r.hLOc./PIFbvGTzUbbt97L8msIopyKbnJwa', 'N/A');

-- --------------------------------------------------------

--
-- Table structure for table `t_appeals`
--

CREATE TABLE `t_appeals` (
  `appeal_ID` int(11) NOT NULL,
  `st_ID` varchar(11) NOT NULL,
  `violation_number` varchar(4) DEFAULT NULL,
  `sender_name` varchar(100) NOT NULL,
  `sender_email` varchar(100) NOT NULL,
  `course` varchar(100) NOT NULL,
  `year_level` varchar(20) NOT NULL,
  `l_appeal_message` text NOT NULL,
  `images` varchar(255) DEFAULT NULL,
  `videos` varchar(255) DEFAULT NULL,
  `l_Time` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `t_appeals`
--

INSERT INTO `t_appeals` (`appeal_ID`, `st_ID`, `violation_number`, `sender_name`, `sender_email`, `course`, `year_level`, `l_appeal_message`, `images`, `videos`, `l_Time`) VALUES
(2, '123456', '8565', 'Jhunrey R. Martel', 'sdas@smcbi.edu.ph', 'BSIT', '1', 'test1', 'podmaster/st_img/img_68fb7ebee87b3_553691588_1515312769482796_6613117895964678613_n.jpg', 'podmaster/st_vid/vid_68fb7ebee8a3b_A131 08082156 C227.mp4', '2025-10-24 13:27:26'),
(3, '123456', '8211', 'Jhunrey R. Martel', 'abaldeeiamkurl@smcbi.edu.ph', 'BSIT', '1', 'Jjj', 'podmaster/st_img/img_68fc0df316435_IMG20251024152756.jpg', 'podmaster/st_vid/vid_68fc0df317a99_lv_0_20251017223306.mp4', '2025-10-24 23:38:27'),
(4, '123456', '8211', 'Jhunrey R. Martel', 'abaldeeiamkurl@smcbi.edu.ph', 'BSIT', '1', 'Jjj', 'podmaster/st_img/img_68fc0dfb04d45_IMG20251024152756.jpg', 'podmaster/st_vid/vid_68fc0dfb069ec_lv_0_20251017223306.mp4', '2025-10-24 23:38:35'),
(5, '123456', '8211', 'Jhunrey R. Martel', 'abaldeeiamkurl@smcbi.edu.ph', 'BSIT', '1', 'Jjj', 'podmaster/st_img/img_68fc0e01251a4_IMG20251024152756.jpg', 'podmaster/st_vid/vid_68fc0e012670a_lv_0_20251017223306.mp4', '2025-10-24 23:38:41');

-- --------------------------------------------------------

--
-- Table structure for table `t_guardians`
--

CREATE TABLE `t_guardians` (
  `g_ID` int(11) NOT NULL,
  `g_FirstName` varchar(50) DEFAULT NULL,
  `g_LastName` varchar(50) DEFAULT NULL,
  `st_ID` varchar(11) DEFAULT NULL,
  `st_name` varchar(100) DEFAULT NULL,
  `g_Address` text DEFAULT NULL,
  `g_PhoneNumber` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `t_guardians`
--

INSERT INTO `t_guardians` (`g_ID`, `g_FirstName`, `g_LastName`, `st_ID`, `st_name`, `g_Address`, `g_PhoneNumber`) VALUES
(1, 'Diana', 'Martel', '123456', 'Jhunrey R. Martel', 'Bansalan', '9101985380'),
(2, 'Charmain', 'Alo', '123457', 'Charl Jade  Alo', 'Bansalan', '9121566439'),
(3, 'Roven', 'Seda', '123458', 'Roel C Seda', 'Bansalan', '9700405335'),
(4, 'Elmer', 'Danilo', '123459', 'Jay Bernard C, Benito', 'Bansalan', '9635355284'),
(5, 'Dannilo', 'Sode', '123460', 'James Kirbie G. Sode', 'Bansalan', '9991952476'),
(6, 'Arlyn', 'Amistad', '123461', 'Nino S. Amistad', 'Bansalan', '9126682193'),
(7, 'Estrelita', '', '123462', 'Adrian P. Nalla', 'Bansalan', 'N/A'),
(8, 'Charlito', 'Butlig', '123463', 'Charles Dave M. Butlig', 'Bansalan', '9055787242'),
(9, 'Emily', 'Comaling', '123464', 'Joseph Ryan G. Evarolo', 'Bansalan', '9634349142'),
(10, 'Mirecil', 'Valdevieso', '123465', 'John Paolo  Valdevieso', 'Bansalan', 'N/A'),
(11, 'Jerudimie', 'Estita', '123466', 'Jesa Mae  Panes', 'Bansalan', '9399553849'),
(12, 'Flordelina', 'Alonzo', '123467', 'Francis Faisal L. Alonzo', 'Bansalan', '9753809475'),
(13, 'Canchita', 'Luamanog', '123468', 'Emmanuel L. Jawod', 'Bansalan', '9127413935'),
(14, 'Lilia', 'Loon', '123469', 'Christopher C, Loon', 'Bansalan', '9100098537'),
(15, 'Jovelyn', 'Magquilat', '123470', 'Paul Emmanuel S. Magquilat', 'Bansalan', '9615282030'),
(16, 'N/A', 'N/A', '123471', 'Amber Alexcelle M. Sonza', 'Bansalan', 'N/A'),
(17, 'Estrella', 'Aberilla', '123472', 'Clemechy N. Carillo', 'Bansalan', '9635921727'),
(18, 'Gracia', 'Carillo', '123473', 'Louie Jay S. Carillo', 'Bansalan', '9702455082'),
(19, 'Derla', 'Beso', '123474', 'Kazumi M. Viray', 'Bansalan', '9103580354'),
(20, 'Juvy', 'Cabasug', '123475', 'Kevin  Cabasog', 'Bansalan', '9063881195'),
(21, 'Junrie', 'Borlaza', '123476', 'Pearl Marie M. Borlaza', 'Bansalan', '9678870120'),
(22, 'Celestina', 'Pancho', '123477', 'Peter Jr. A Caminade', 'Bansalan', '9107055070'),
(23, 'Antonia', 'Abella', '123478', 'Tiffany A. Laganse', 'Bansalan', '9675420441'),
(24, 'Solano Jr.', 'Sebios', '123479', 'Apple Kem T. Sebios', 'Bansalan', '9516839988'),
(25, 'Dante', 'Duran', '123480', 'Mary Grace L. Duran', 'Bansalan', '9553313016'),
(26, 'Concepcion', 'Ornopia', '123481', 'Mark Steven  Montano', 'Bansalan', '9913014008'),
(27, 'Mary Mae', 'Tapia', '123482', 'Harley Dave G. Tapia', 'Bansalan', '9757318122'),
(28, 'Maycris', 'Edianon', '123483', 'Jasper Glenn G. Edianon', 'Bansalan', '9536798847'),
(29, 'Beverlyn', 'Daplin', '123484', 'Carl Clark Vincent P. Daplin', 'Bansalan', '9633468876'),
(30, 'Judith', 'Alejandro', '123485', 'Princess C. Alejandro', 'Bansalan', '9309396034'),
(31, 'Genevive', 'Caballero', '123486', 'John Franz Z Caballero', 'Bansalan', '9504409361'),
(32, 'Aiza', 'Calboniro', '123487', 'Kent Rhyzel M. Calboniro', 'Bansalan', '9505535645'),
(33, 'Charita', 'Villanueva', '123488', 'Jillian Charles M. Villanueva', 'Bansalan', '9206227683'),
(34, 'Renante', 'Tongol', '123489', 'Nailyn T. Tongol', 'Bansalan', '9958843609'),
(35, 'Ely', 'Labajo', '123490', 'Ely Jay C. Labajo', 'Bansalan', '9518104867'),
(36, 'Jonabeth', 'Academia', '123491', 'Clark Vincent Maurice A. Morata', 'Bansalan', '9540787033'),
(37, 'Ednalyn', 'Gameng', '123492', 'Jenny F Gameng', 'Bansalan', '9473847974'),
(38, 'Francisco', 'Restauro', '123493', 'Lorenze Red E. Acuzar', 'Bansalan', '9488113064'),
(39, 'Helen', 'Estremos', '123494', 'Joseph B. Estremos', 'Bansalan', '9483130649'),
(40, 'Floriedy', 'Molino', '123495', 'John Lloyd M. Molino', 'Bansalan', '9810895194'),
(41, 'Guillrtmo', 'Reyes', '123496', 'Christian Jay C Reyes', 'Bansalan', '9633061806'),
(42, 'Minda', 'Pareja', '123497', 'Mariel T. Pareja', 'Bansalan', '9156606265'),
(43, 'Jessica', 'Batal', '123498', 'Rosmond Ronald M. Batal', 'Bansalan', '9487010364'),
(44, 'Joe', 'Corpuz', '123499', 'Jaspher Joe A Corpuz', 'Bansalan', '9487010364'),
(45, 'Mario', 'Valdez', '123500', 'Nicole P. Valdez', 'Bansalan', '9652518972'),
(46, 'Herman', 'Hewe', '123501', 'Kristel O. Hewe', 'Bansalan', '9300161096'),
(47, 'Glorioa', 'Sol', '123502', 'Nathaniel P. Sol', 'Bansalan', '9455481242'),
(48, 'Carmela', 'Tambis', '123503', 'Rocky Bpb S Tambis', 'Bansalan', '9163574228'),
(49, 'Genelyn', 'Pansoy', '123504', 'Jan Hiro P. Ceniza', 'Bansalan', '9169471192'),
(50, 'Josephine', 'Pallaya', '123505', 'Mayco Josh F Pallaya', 'Bansalan', '9518326974'),
(51, 'Lycel', 'Geyrozaga', '123506', 'Jannel  Geyrozaga', 'Bansalan', '9306405235'),
(52, 'Annaliza', 'Artajo', '123507', 'Clarence Q Artajo', 'Bansalan', '9218644192'),
(53, 'Amelita', 'Nisnisan', '123508', 'Stephanie Aime J Nisnisan', 'Bansalan', '9489767055'),
(54, 'Josephine', 'Antopina', '123509', 'Marilou Z Antopina', 'Bansalan', '9539961129'),
(55, 'Aida', 'Macabane', '123510', 'Jaymar G. Macabane', 'Bansalan', '9108628261'),
(56, 'Arnold', 'Rasonable', '123511', 'Rv Fender P. Rasonable', 'Bansalan', '9702760951'),
(57, 'Ronald', 'Apas', '123512', 'Aravela Grace R. Apas', 'Bansalan', '9054415362'),
(58, 'Jonna', 'Canezo', '123513', 'Jomari M. Canezo', 'Bansalan', '9504346552'),
(59, 'Nelly Mae', 'Onis', '123514', 'Jay Mark C Onis', 'Bansalan', '9667539770'),
(60, 'Rosalinda', 'Redondiez', '123515', 'Kirby  Redondiez', 'Bansalan', '9269362337'),
(61, 'Mary Rose', 'Balwit', '123516', 'Hymon Clark T. Balwit', 'Bansalan', '9126751500'),
(62, 'Emilona', 'Anda', '123517', 'Keith Stephen  Catubay', 'Bansalan', '9362111544'),
(63, 'Cepriana', 'Nilo', '123518', 'Christian  Nilo', 'Bansalan', '9558413231'),
(64, 'Myrna', 'Ondos', '123519', 'Crystal Amaze O. Espinosa', 'Bansalan', '93550368'),
(65, 'Irish', 'Corpuz', '123520', 'Cythea Joyce L Corpuz', 'Bansalan', '9094029611'),
(66, 'Joseph', 'Florentino', '123521', 'Kin Laurence Josh C Florentino', 'Bansalan', '9486277713'),
(67, 'Yul', 'Dinoy', '123522', 'Yullard A. Dinoy', 'Bansalan', '9750627924'),
(68, 'Normelita', 'Nasol', '123523', 'John Mark  Opong', 'Bansalan', 'N/A'),
(69, 'Maria Michelle', 'Dalaguit', '123524', 'John Philip G. Dalaguit', 'Bansalan', '9678026665'),
(70, 'Gary', 'Nasol', '123525', 'Gian  Gillo', 'Bansalan', 'N/A'),
(71, 'Elsa', 'Samson', '123526', 'Earnest Jay L. Samson', 'Bansalan', '9654382043'),
(72, 'Jocelyn', 'Bunzo', '123527', 'Aurelyn May  Palamara', 'Bansalan', '9106875359'),
(73, 'Mgray Jun', 'Canencia', '123528', 'Prince MJ D. Canencia', 'Bansalan', '9108900757'),
(74, 'Cezel', 'Gedaro', '123529', 'Tristan Michael G. Francisco', 'Bansalan', '9708865145'),
(75, 'Lornelyn', 'Llego', '123530', 'Eroll John Q. Llego', 'Bansalan', '9303725774'),
(76, 'Elena', 'Lozano', '123531', 'John Robert  Lozano', 'Bansalan', '9104697993'),
(77, 'Bernard', 'Dasmari?as', '123532', 'Ian Jake C Dasmari?as', 'Bansalan', '9486836628'),
(78, 'Jonavic', 'Arellano', '123533', 'Mark Anthony D. Arellano', 'Bansalan', '9260535794'),
(79, 'Brenda', 'Pinto', '123534', 'Pryncess Zanette C. Pinto', 'Bansalan', '9095292960'),
(80, 'Jino', 'Golosida', '123535', 'Jinrel J. Golosinda', 'Bansalan', '9307794655'),
(81, 'Evangeline', 'Vistacion', '123536', 'Jon Evan F. Vistacion', 'Bansalan', '9647237153'),
(82, 'Cepriana', 'Nilo', '123537', 'Cedric Jerome  Nilo', 'Bansalan', '9305042985'),
(83, 'Neresa', 'Jangalay', '123538', 'Jay C. Jangalay', 'Bansalan', '9758163341'),
(84, 'Nelson', 'Balunan', '123539', 'Crisnel Jee A. Balunan', 'Bansalan', '9639683062'),
(85, 'Iorinsa', 'Villamor', '123540', 'Christian V. Gabuya', 'Bansalan', '9466310692'),
(86, 'Annamae', 'Diantor', '123541', 'Russel S. Diantor', 'Bansalan', '9182923842'),
(87, 'Rosita', 'Toyco', '123542', 'Vincent M. Toyco', 'Bansalan', '9533523496'),
(88, 'Rodelo', 'Otom', '123543', 'Rovel John L. Otom', 'Bansalan', '9269645722'),
(89, 'Edna', 'Sanchez', '123544', 'Prince Joshua C. Sanchez', 'Bansalan', '9062586309'),
(90, 'Florina', 'Ybanez', '123545', 'Keirlstan  Ybanez', 'Bansalan', '9307980137'),
(91, 'N/A', 'N/A', '123546', 'Noveneil Jhon A. Molinas', 'Bansalan', 'N/A'),
(92, 'Genelyn', 'Pansoy', '123547', 'Jan Hiro P. Ceniza', 'Bansalan', '9169471192'),
(93, 'Lilia', 'Siatuca', '123548', 'Kerr Vincent  Jubahib', 'Bansalan', '9630633582'),
(94, 'Remielyn', 'Denaque', '123549', 'Mel Bhoy R, Denaque', 'Bansalan', '9129056011'),
(95, 'Virginia', 'Mosqueza', '123550', 'Joesil A. Mosquiza', 'Bansalan', '9285666161'),
(96, 'Elma', 'Sabanal', '123551', 'Daryl D. Sabanal', 'Bansalan', '9630771735'),
(97, 'Gilbert', 'Arellano', '123552', 'John Mc Clane H. Arellano', 'Bansalan', '9757541880'),
(98, 'Adel', 'Torres', '123553', 'Mark Louin B. Torres', 'Bansalan', '9462130983'),
(99, 'Marie Fe', 'Saguing', '123554', 'Jhyzie S. Cano', 'Bansalan', '9308007295'),
(100, 'Rodencio', 'Navor', '123555', 'Julie Ann P. Navor', 'Bansalan', '9076821897'),
(101, 'Ruvelyn', 'Alpuerto', '123556', 'Gwen S. Alpuerto', 'Bansalan', '9061260418'),
(102, 'Jasmine', 'Ramirez', '123557', 'Fritz E. Ramirez', 'Bansalan', '9557023573'),
(103, 'Sherill Chan', 'Aperocho', '123558', 'Hans Kurvey C. Filart', 'Bansalan', '9516184991'),
(104, 'Ritchie', 'Escobar', '123559', 'Kent Joshua L. Escobar', 'Bansalan', '9129152869'),
(105, 'Salome', 'Alcebar', '123560', 'Charles Arone R. Acebar', 'Bansalan', '9772709310'),
(106, 'Lynie', 'Abanid', '123561', 'Jade A Villagracia', 'Bansalan', '9855004337'),
(107, 'Richard', 'Ubat', '123562', 'Jeric Jay  Ubat', 'Bansalan', '9586878810'),
(108, 'Cecelia', 'Terambulo', '123563', 'Sharwin A. Terambulo', 'Bansalan', '9582264320'),
(109, 'Grace', 'Malubay', '123564', 'Mikailla C. Malubay', 'Bansalan', '9511299114'),
(110, 'Ginalyn', 'Bagnol', '123565', 'Nillyn Margarette  Bagnol', 'Bansalan', '9472509186'),
(111, 'John Alfonsus', 'Taruc', '123566', 'John Alfonsus B Taruc II', 'Bansalan', '9153273989'),
(112, 'Guillerma', 'Potestas', '123567', 'Jhon Christopher R. Potestas', 'Bansalan', '9389129262'),
(113, 'Mercy', 'Castillon', '123568', 'Edrian C. Castillion', 'Bansalan', '9486369503'),
(114, 'Estiela', 'Constantino', '123569', 'Van April C. Constantino', 'Bansalan', '9518127518'),
(115, 'Felix', 'Diano', '123570', 'John Louie  Diano', 'Bansalan', '9633638660'),
(116, 'Ceacyl', 'Ulep', '123571', 'Glenn Andrey Q. Ulep', 'Bansalan', '9502896712'),
(117, 'Grace', 'Balalio', '123572', 'Kent I. Balalio', 'Bansalan', '9700307888'),
(118, 'Editha', 'Samoranos', '123573', 'Lovely Jean  Samoranos', 'Bansalan', '9678752500'),
(119, 'Emilia', 'Cardeno', '123574', 'Julie Mae  Cardeno', 'Bansalan', '9513639070'),
(120, 'Jovelyn', 'Cabigas', '123575', 'Cesar C. Taclahan Jr.', 'Bansalan', '9538730099'),
(121, 'Jeremy', 'Escubido', '123576', 'Jeremiah F. Escubido', 'Bansalan', '9510573982'),
(122, 'Mia', 'Parcon', '123577', 'Peter Paul L. Parcon', 'Bansalan', '9197086523'),
(123, 'Raul', 'Ramirez', '123578', 'Jacqueline Dorothy S. Soriano', 'Bansalan', '9129476696'),
(124, 'Marivic', 'Dubria', '123579', 'Joemar C. Dubria', 'Bansalan', '9508233844'),
(125, 'Angelina Loma', 'Lauron', '123580', 'Jhon Dave  Bosbos', 'Bansalan', '9357425609'),
(126, 'Rosa', 'Gil', '123581', 'Jesasa Mae  Gil', 'Bansalan', '9123463267'),
(127, 'Helen', 'Mesamin', '123582', 'Lencer C Mesamin', 'Bansalan', '9917147827'),
(128, 'Eva-Miravilla', 'Pacure', '123583', 'Jolly R. Pacure', 'Bansalan', '9773274604'),
(129, 'Juliana', 'Amante', '123584', 'Jumelyn A Salende', 'Bansalan', '9350380805'),
(130, 'Catalina', 'Gocotano', '123585', 'Bridget John  Gocotano', 'Bansalan', '9123813726'),
(131, 'Edgar', 'Navidad', '123586', 'Karl  Navidad', 'Bansalan', '9396357292'),
(132, 'Randy', 'Aguirre', '123587', 'Alice Mae C Aguirre', 'Bansalan', '9679379098'),
(133, 'Cresilinda', 'Reyes', '123588', 'Ricahrd John M. Reyes', 'Bansalan', '9951986353'),
(134, 'Vicente', 'Saballegue', '123589', 'John Paolo M. Saballegue', 'Bansalan', '9985858345'),
(135, 'Shirley', 'Comaingking', '123590', 'Nina Jane Z. Comaingking', 'Bansalan', '9759791379'),
(136, 'Carmen', 'Fuentes', '123591', 'Joshua Dave F. Sescon', 'Bansalan', '9298036601'),
(137, 'Mayflor', 'Buhian', '123592', 'Mary Rose Q. Buhian', 'Bansalan', '9067612811'),
(138, 'Lajgavey Amor', 'Velasco', '123593', 'Rictherlaj  Velasco', 'Bansalan', '9508059882'),
(139, 'Rosaline', 'Bisanez', '123594', 'Denirose M. Bisanez', 'Bansalan', '9997288428'),
(140, 'Elisa', 'Lanterna', '123595', 'Angelou S. Lanterna', 'Bansalan', '9067897858'),
(141, 'Caridad', 'Roda', '123596', 'Ryan V. Roda', 'Bansalan', '9753060716'),
(142, 'Julita', 'Ogal', '123597', 'Jayson M. Ogal', 'Bansalan', '9488098541'),
(143, 'Ilen', 'Liano', '123598', 'Roderick S. Liano', 'Bansalan', '9485937300'),
(144, 'Alex', 'Laborte', '123599', 'Alexis Dale A. Laborte', 'Bansalan', '9498251695'),
(145, 'Ruben', 'Bansilan', '123600', 'Joseph Kayron G. Bansilan', 'Bansalan', '9704588782'),
(146, 'Ailyn', 'Colipino', '123601', 'Lloyd P. Colipano', 'Bansalan', '9813655947'),
(147, 'Henry', 'Maranan', '123602', 'Harvey B. Maranan', 'Bansalan', '9385409602'),
(148, 'Adin', 'Siaboc', '123603', 'John Michael B. Siaboc', 'Bansalan', 'N/A'),
(149, 'Milphy', 'Abalde', '123604', 'Eiam Kurl Nawa Abalde', 'Bansalan', '9198305571'),
(150, 'Iorna', 'Tangga-an', '123605', 'Thotchie M. Tangga-an', 'Bansalan', 'N/A'),
(151, 'Myrna', 'Dasmari?as', '123606', 'Emmanuel F. Quibuen', 'Bansalan', '9858186695'),
(152, 'Wardie', 'Daya', '123607', 'Karl Angelou A. Daya', 'Bansalan', 'N/A'),
(153, 'Floriedy', 'Molino', '123608', 'Lorenz Jay M. Molino', 'Bansalan', '9810895194'),
(154, 'Merry Gine', 'Ayop', '123609', 'Jay R. Ayop', 'Bansalan', '9102186465'),
(155, 'Ramil', 'Villasurda', '123610', 'Ramz Aaron S. Villasurda', 'Bansalan', '9483132520'),
(156, 'Ruth', 'Ponferrada', '123611', 'Axcel Ross  Ponferrada', 'Bansalan', '9069296725'),
(157, 'Jocelyn', 'Arendain', '123612', 'Kieven Mar A. Arendain', 'Bansalan', '9266254379'),
(158, 'Margarita', 'Tionas', '123613', 'Erna Fe  Tionas', 'Bansalan', '9515532372'),
(159, 'Ramel', 'Larecion', '123614', 'Ramsie  Larecion', 'Bansalan', 'N/A'),
(160, 'Jonicar', 'Clave', '123615', 'Marck Jhon A. Clave', 'Bansalan', '9079894482'),
(161, 'Jovelyn', 'Samonte', '123616', 'Ain James T. Samonte', 'Bansalan', 'N/A'),
(162, 'Rosita', 'Samoncino', '123617', 'Jairus Dela  Pena', 'Bansalan', '9518517781'),
(163, 'Grizelle', 'Respulo', '123618', 'Arelle Anthony P. Respulo', 'Bansalan', '9155168462'),
(164, 'Maria Victoria', 'Cabaron', '123619', 'Retchel Jr P. Cabaron', 'Bansalan', 'N/A'),
(165, 'Mario', 'Matanggo', '123620', 'Manilyn B. Matanggo', 'Bansalan', '9751281581'),
(166, 'Nerie', 'Mondejar', '123621', 'Mondejar E. Jesson Noel', 'Bansalan', '9385865144'),
(167, 'Narisca', 'Andelab', '123622', 'Jessica R. Andelab', 'Bansalan', '9559453408'),
(168, 'Narisca', 'Andelab', '123623', 'Jessa R. Andelab', 'Bansalan', '9559453409'),
(169, 'Dedith', 'Sab', '123624', 'Mardel Karl S. Sab', 'Bansalan', 'N/A'),
(170, 'Millieta', 'Del Socorro', '123625', 'Shawn Andrei A. Del Socorro', 'Bansalan', 'N/A'),
(171, 'Cecil', 'Rubia', '123626', 'Vince Johnroie C. Rubia', 'Bansalan', '9485936312'),
(172, 'Renly', 'Malik', '123627', 'Hadji Glenn  Malik', 'Bansalan', '9384076692'),
(173, '', '', '', '  ', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `t_issues`
--

CREATE TABLE `t_issues` (
  `i_ID` int(11) NOT NULL,
  `st_ID` varchar(255) NOT NULL,
  `st_name` varchar(255) DEFAULT NULL,
  `i_Category` varchar(255) NOT NULL,
  `list_Offense` text NOT NULL,
  `i_Sanctions` text NOT NULL,
  `Suspension_Type` varchar(255) NOT NULL,
  `i_Details` text NOT NULL,
  `i_Recommendation` text NOT NULL,
  `i_Status` varchar(255) NOT NULL,
  `a_username` varchar(255) NOT NULL,
  `violation_number` varchar(4) NOT NULL,
  `time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `t_issues`
--

INSERT INTO `t_issues` (`i_ID`, `st_ID`, `st_name`, `i_Category`, `list_Offense`, `i_Sanctions`, `Suspension_Type`, `i_Details`, `i_Recommendation`, `i_Status`, `a_username`, `violation_number`, `time`) VALUES
(16, '123456', 'Jhunrey R. Martel', 'Category B', 'Gambling', 'Exclusion', 'N/A', 'adss', 'asda', 'Pending', 'admin', '8211', '2025-10-14 17:48:48'),
(17, '123456', 'Jhunrey R. Martel', 'Category C', 'Libel or malicious defamation', 'Reprimand', 'N/A', 'dsaas', 'dsads', 'Pending', 'user1', '8565', '2025-10-21 19:45:57'),
(18, '123456', 'Jhunrey R. Martel', 'Category B', 'Public disturbances', 'Reprimand', 'N/A', 'asddsa', 'asddsa', 'Pending', 'user1', '4857', '2025-10-24 23:21:55');

-- --------------------------------------------------------

--
-- Table structure for table `t_logs`
--

CREATE TABLE `t_logs` (
  `i_ID` int(11) NOT NULL,
  `st_ID` varchar(255) NOT NULL,
  `st_name` varchar(255) DEFAULT NULL,
  `i_Category` varchar(255) NOT NULL,
  `list_Offense` text NOT NULL,
  `i_Sanctions` text NOT NULL,
  `Suspension_Type` varchar(255) NOT NULL,
  `i_Details` text NOT NULL,
  `i_Recommendation` text NOT NULL,
  `i_Status` varchar(255) NOT NULL,
  `a_username` varchar(100) DEFAULT NULL,
  `violation_number` varchar(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `t_logs`
--

INSERT INTO `t_logs` (`i_ID`, `st_ID`, `st_name`, `i_Category`, `list_Offense`, `i_Sanctions`, `Suspension_Type`, `i_Details`, `i_Recommendation`, `i_Status`, `a_username`, `violation_number`) VALUES
(1, '123456', 'Jhunrey R. Martel', 'Category A', 'Loitering and creating noise', 'Reprimand', 'N/A', 'test1', 'test1', 'Pending', 'user1', '2069'),
(2, '123456', 'Jhunrey R. Martel', 'Category C', 'Libel or malicious defamation', 'Reprimand', 'N/A', 'dsaas', 'dsads', 'Pending', 'user1', '8565'),
(3, '123456', 'Jhunrey R. Martel', 'Category B', 'Public disturbances', 'Reprimand', 'N/A', 'asddsa', 'asddsa', 'Pending', 'user1', '4857');

-- --------------------------------------------------------

--
-- Table structure for table `t_students`
--

CREATE TABLE `t_students` (
  `s_ID` int(11) NOT NULL,
  `s_Firstname` varchar(100) DEFAULT NULL,
  `s_Middlename` varchar(100) DEFAULT NULL,
  `s_Lastname` varchar(100) DEFAULT NULL,
  `st_ID` varchar(7) DEFAULT NULL,
  `s_DOB` date DEFAULT NULL,
  `s_CourseOfStudy` varchar(100) DEFAULT NULL,
  `year_level` varchar(50) DEFAULT NULL,
  `s_Gender` varchar(10) DEFAULT NULL,
  `s_Address` text DEFAULT NULL,
  `s_PhoneNumber` varchar(15) DEFAULT NULL,
  `religion` varchar(50) DEFAULT NULL,
  `if_licence` varchar(12) DEFAULT NULL,
  `if_licence_registration` varchar(7) DEFAULT NULL,
  `s_PicturePath` varchar(255) DEFAULT NULL,
  `s_Password` char(60) DEFAULT NULL,
  `school_year` varchar(20) DEFAULT NULL,
  `s_DateAdded` datetime DEFAULT current_timestamp(),
  `s_gmail` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `t_students`
--

INSERT INTO `t_students` (`s_ID`, `s_Firstname`, `s_Middlename`, `s_Lastname`, `st_ID`, `s_DOB`, `s_CourseOfStudy`, `year_level`, `s_Gender`, `s_Address`, `s_PhoneNumber`, `religion`, `if_licence`, `if_licence_registration`, `s_PicturePath`, `s_Password`, `school_year`, `s_DateAdded`, `s_gmail`) VALUES
(1, 'Jhunrey', 'R.', 'Martel', '123456', '2025-10-24', 'BSIT', '1', 'Male', 'Bansalan', '975-831-7105', 'Catholic', 'N/A', 'N/A', 'path/to/pic.jpg', '$2y$10$1BX57HDSlSoGQ1lWGhEkbukFchI110rFgtsLWm6Cuo4GM5R1fY7q2', '2025-2026', '2025-10-02 13:08:12', 'abaldeeiamkurl@smcbi.edu.ph'),
(2, 'Charl Jade', '', 'Alo', '123457', '0000-00-00', 'BSIT', '1', 'Male', 'Bansalan', '9859906702', 'Catholic', 'N/A', 'N/A', 'path/to/pic.jpg', '$2y$10$iR4E2s2rBWEpE0yQuhyD/ev0b6qvn5cyuE5Icr1U9tnEMLap6iG06', '2025-2026', '2025-10-02 13:08:12', 'sdas@smcbi.edu.ph'),
(3, 'Roel', 'C', 'Seda', '123458', '0000-00-00', 'BSIT', '1', 'Male', 'Bansalan', '9700405335', 'Catholic', 'N/A', 'N/A', 'path/to/pic.jpg', '$2y$10$HgFARtb6/Wn1M8GlXO7KAePaslTVHdXOQFFb388wjm.SUy8NY2FM6', '2025-2026', '2025-10-02 13:08:12', 's_gmail'),
(4, 'Jay Bernard', 'C,', 'Benito', '123459', '0000-00-00', 'BSIT', '1', 'Male', 'Bansalan', '9100040575', 'Catholic', 'N/A', 'N/A', 'path/to/pic.jpg', '$2y$10$vRugryplUFKuZ3ozubtcledSR7Iqstw9KV1W8TUf4ugjRS8ivFG8y', '2025-2026', '2025-10-02 13:08:12', 'sdas@smcbi.edu.ph'),
(5, 'James Kirbie', 'G.', 'Sode', '123460', '0000-00-00', 'BSIT', '1', 'Male', 'Bansalan', '9539569371', 'Catholic', 'N/A', 'N/A', 'path/to/pic.jpg', '$2y$10$gupsWTrq/VH6T1WPk/JDfeDUUUWAg9nccFKLukG3nDHPSsjcPoM2S', '2025-2026', '2025-10-02 13:08:12', 'sdas@smcbi.edu.ph'),
(6, 'Nino', 'S.', 'Amistad', '123461', '0000-00-00', 'BSIT', '1', 'Male', 'Bansalan', '9553282529', 'Catholic', 'N/A', 'N/A', 'path/to/pic.jpg', '$2y$10$MBTCUGstxfKA2GwBVOdBHeZtPKLBMNu5zQscOSi3dGDMFhlWRQQ0i', '2025-2026', '2025-10-02 13:08:12', 's_gmail'),
(7, 'Adrian', 'P.', 'Nalla', '123462', '0000-00-00', 'BSIT', '1', 'Male', 'Bansalan', '9660274366', 'Catholic', 'N/A', 'N/A', 'path/to/pic.jpg', '$2y$10$nZO2BNLac89fWv.sNo2fAe58BR.eIaqkhMMKlrkGsux9fwxxH7n8.', '2025-2026', '2025-10-02 13:08:12', 'sdas@smcbi.edu.ph'),
(8, 'Charles Dave', 'M.', 'Butlig', '123463', '0000-00-00', 'BSIT', '1', 'Male', 'Bansalan', '9541860899', 'Catholic', 'N/A', 'N/A', 'path/to/pic.jpg', '$2y$10$tA.fJ0XKaRZ9fQAs53RG5.RAZ8SgFnsSuOju5QLS9RMtENbna4eqC', '2025-2026', '2025-10-02 13:08:12', 'sdas@smcbi.edu.ph'),
(9, 'Joseph Ryan', 'G.', 'Evarolo', '123464', '0000-00-00', 'BSIT', '1', 'Male', 'Bansalan', '9637349142', 'Catholic', 'N/A', 'N/A', 'path/to/pic.jpg', '$2y$10$VTn9RIFtxP0op1Y0rU9ANOA6CZ68GfGjumcDHsQNT/mO0j4CdCMlq', '2025-2026', '2025-10-02 13:08:13', 's_gmail'),
(10, 'John Paolo', '', 'Valdevieso', '123465', '0000-00-00', 'BSIT', '1', 'Male', 'Bansalan', '9630923589', 'UCCP', 'N/A', 'N/A', 'path/to/pic.jpg', '$2y$10$Kvxha9birR2dLzPgsnqIqukcHpR/6vfshNRE30KY/KnH2BD1bKqZS', '2025-2026', '2025-10-02 13:08:13', 'sdas@smcbi.edu.ph'),
(11, 'Jesa Mae', '', 'Panes', '123466', '0000-00-00', 'BSIT', '1', 'Female', 'Bansalan', '9702503899', 'N/A', 'N/A', 'N/A', 'path/to/pic.jpg', '$2y$10$5WaQ1Oek2awvqMZOVXWG5.Zglvy1LWRwOiwAVErgSq4dv2v6rwQC2', '2025-2026', '2025-10-02 13:08:13', 'sdas@smcbi.edu.ph'),
(12, 'Francis Faisal', 'L.', 'Alonzo', '123467', '0000-00-00', 'BSIT', '1', 'Male', 'Bansalan', '9355792562', 'Catholic', 'N/A', 'N/A', 'path/to/pic.jpg', '$2y$10$3ojmYr9L9kyZnmTyaPWF0urMVuNKNbX28Hp4u3loCwPTdMLugs8uC', '2025-2026', '2025-10-02 13:08:13', 's_gmail'),
(13, 'Emmanuel', 'L.', 'Jawod', '123468', '0000-00-00', 'BSIT', '1', 'Male', 'Bansalan', '9855065420', 'Baptist', 'N/A', 'N/A', 'path/to/pic.jpg', '$2y$10$wFEERWMOqzRFkeyn17FOfOHpHf3zUJkH2UtCz4x/2vjX36UOkfRTC', '2025-2026', '2025-10-02 13:08:13', 'sdas@smcbi.edu.ph'),
(14, 'Christopher', 'C,', 'Loon', '123469', '0000-00-00', 'BSIT', '1', 'Male', 'Bansalan', '9120530553', 'Catholic', 'N/A', 'N/A', 'path/to/pic.jpg', '$2y$10$aRVharDVD0ahTcEIuRG8HO8NiHvkuloAF.j1zO462G/R3MzzO7Ltu', '2025-2026', '2025-10-02 13:08:13', 'sdas@smcbi.edu.ph'),
(15, 'Paul Emmanuel', 'S.', 'Magquilat', '123470', '0000-00-00', 'BSIT', '1', 'Male', 'Bansalan', '9615282030', 'Catholic', 'N/A', 'N/A', 'path/to/pic.jpg', '$2y$10$kqR2OK0AZ1ZpL1RoWNZ.Le3POQ6fWQ1qyq4m9TFPkFuh.Me03YRvG', '2025-2026', '2025-10-02 13:08:13', 's_gmail'),
(16, 'Amber Alexcelle', 'M.', 'Sonza', '123471', '0000-00-00', 'BSIT', '1', 'Female', 'Bansalan', '9686438665', 'Catholic', 'N/A', 'N/A', 'path/to/pic.jpg', '$2y$10$O52kUxSek3ka75kQRMq5YeHFK84Yfylx4tdGlQU/RCL8nmyOqK0jK', '2025-2026', '2025-10-02 13:08:13', 'sdas@smcbi.edu.ph'),
(17, 'Clemechy', 'N.', 'Carillo', '123472', '0000-00-00', 'BSIT', '1', 'Male', 'Bansalan', '994954005', 'N/A', 'N/A', 'N/A', 'path/to/pic.jpg', '$2y$10$8PrkocbItaboKS.ol6TjT.i9roZ4YUpxMhdL3cEa.JDV.ZjFs7e.G', '2025-2026', '2025-10-02 13:08:13', 'sdas@smcbi.edu.ph'),
(18, 'Louie Jay', 'S.', 'Carillo', '123473', '0000-00-00', 'BSIT', '1', 'Male', 'Bansalan', '9981801248', 'Catholic', 'N/A', 'N/A', 'path/to/pic.jpg', '$2y$10$CVgLR.k64tZHokdfDkhbVO7XdakvkhYugWFwgK7NzLixcAUHF7q0y', '2025-2026', '2025-10-02 13:08:13', 's_gmail'),
(19, 'Kazumi', 'M.', 'Viray', '123474', '0000-00-00', 'BSIT', '1', 'Female', 'Bansalan', '9369668298', 'Catholic', 'N/A', 'N/A', 'path/to/pic.jpg', '$2y$10$qe8bndz46VrhiK5bwiJEVuUAu9z5y7X7CdOMXcdePrnj29jXHILLW', '2025-2026', '2025-10-02 13:08:13', 'sdas@smcbi.edu.ph'),
(20, 'Kevin', '', 'Cabasog', '123475', '0000-00-00', 'BSIT', '1', 'Male', 'Bansalan', '9664625652', 'Catholic', 'N/A', 'N/A', 'path/to/pic.jpg', '$2y$10$X5CbKv0KHZI3q0Nt5uydOe/mb74JkdcUgnNp2PcyWlwWCHdi8JLkq', '2025-2026', '2025-10-02 13:08:13', 'sdas@smcbi.edu.ph'),
(21, 'Pearl Marie', 'M.', 'Borlaza', '123476', '0000-00-00', 'BSIT', '2', 'Female', 'Bansalan', '9292271268', 'UCCP', 'N/A', 'N/A', 'path/to/pic.jpg', '$2y$10$a4Wpr/lfWqZnofN4ON7XM.EbhuQaTBB/1LjvyVvwSHcT.MIrau4L.', '2025-2026', '2025-10-02 13:08:13', 's_gmail'),
(22, 'Peter Jr.', 'A', 'Caminade', '123477', '0000-00-00', 'BSIT', '2', 'Male', 'Bansalan', '9107055070', 'SDA', 'N/A', 'N/A', 'path/to/pic.jpg', '$2y$10$FOxSl7RtUTrgUNGF05XPQecKxA1cLXSP/lAmiSvXjJlcQnfUBXb5W', '2025-2026', '2025-10-02 13:08:13', 'sdas@smcbi.edu.ph'),
(23, 'Tiffany', 'A.', 'Laganse', '123478', '0000-00-00', 'BSIT', '2', 'Female', 'Bansalan', '9757944649', 'SDA', 'N/A', 'N/A', 'path/to/pic.jpg', '$2y$10$aN/aZkT4RDQJIk6sDJdsOOL7i5ZCpSk1wjBqePj8OCp2eonih8wXm', '2025-2026', '2025-10-02 13:08:13', 'sdas@smcbi.edu.ph'),
(24, 'Apple Kem', 'T.', 'Sebios', '123479', '0000-00-00', 'BSIT', '2', 'Female', 'Bansalan', '9516839988', 'Catholic', 'N/A', 'N/A', 'path/to/pic.jpg', '$2y$10$ZVtrdvLi21nw2moXRjOQG.v6pPPC8OYW3Y9bt5KNvE/O/n4vJsVla', '2025-2026', '2025-10-02 13:08:13', 's_gmail'),
(25, 'Mary Grace', 'L.', 'Duran', '123480', '0000-00-00', 'BSIT', '2', 'Female', 'Bansalan', '9553313016', 'Catholic', 'N/A', 'N/A', 'path/to/pic.jpg', '$2y$10$MzpTIgbe1bkYuKMNuMkxyeLy082MnpEiNh1LrWzrnbv4bzOQGtIN6', '2025-2026', '2025-10-02 13:08:13', 'sdas@smcbi.edu.ph'),
(26, 'Mark Steven', '', 'Montano', '123481', '0000-00-00', 'BSIT', '2', 'Male', 'Bansalan', '9358021136', 'Muslim', 'N/A', 'N/A', 'path/to/pic.jpg', '$2y$10$ZeISEClOTvv5aotndcSYour5aSFvStevny943hcP4creDnnNVOEZO', '2025-2026', '2025-10-02 13:08:13', 'sdas@smcbi.edu.ph'),
(27, 'Harley Dave', 'G.', 'Tapia', '123482', '0000-00-00', 'BSIT', '2', 'Male', 'Bansalan', '9757318122', 'Catholic', 'N/A', 'N/A', 'path/to/pic.jpg', '$2y$10$D/bg0eHAFxj84Hl0.k2HpuW3hWKK.Uwfa/1p2DKvj.yK5a.z8ENTO', '2025-2026', '2025-10-02 13:08:13', 's_gmail'),
(28, 'Jasper Glenn', 'G.', 'Edianon', '123483', '0000-00-00', 'BSIT', '2', 'Male', 'Bansalan', '9676778031', 'Alliance', 'N/A', 'N/A', 'path/to/pic.jpg', '$2y$10$Y6oO1FTu5DuerrQ8FEj/KuIA4UF9e6llUOv98Cqb1aBV9Y0Tr7acq', '2025-2026', '2025-10-02 13:08:13', 'sdas@smcbi.edu.ph'),
(29, 'Carl Clark Vincent', 'P.', 'Daplin', '123484', '0000-00-00', 'BSIT', '2', 'Male', 'Bansalan', '9633468876', 'Catholic', 'N/A', 'N/A', 'path/to/pic.jpg', '$2y$10$BZ/BxoNOkITAq2FhM4F.pup.sBg/kQ987nZZRwUDYC6Z9yRupxAx2', '2025-2026', '2025-10-02 13:08:14', 'sdas@smcbi.edu.ph'),
(30, 'Princess', 'C.', 'Alejandro', '123485', '0000-00-00', 'BSIT', '2', 'Female', 'Bansalan', '9127380323', 'Catholic', 'N/A', 'N/A', 'path/to/pic.jpg', '$2y$10$y/UrZ8DNEqJlMjLjl9AAtOV5VF/nk.wg552dDj7bjX1sXuQOJK8Te', '2025-2026', '2025-10-02 13:08:14', 's_gmail'),
(31, 'John Franz', 'Z', 'Caballero', '123486', '0000-00-00', 'BSIT', '2', 'Male', 'Bansalan', '9102297597', 'Catholic', 'N/A', 'N/A', 'path/to/pic.jpg', '$2y$10$LBbQiMt4mFPf1Twi.upZ/.KZqihwHU7nhTyGDEcEnXEQ3y76sP.aG', '2025-2026', '2025-10-02 13:08:14', 's_gmail'),
(32, 'Kent Rhyzel', 'M.', 'Calboniro', '123487', '0000-00-00', 'BSIT', '2', 'Male', 'Bansalan', '9125592627', 'Catholic', 'N/A', 'N/A', 'path/to/pic.jpg', '$2y$10$ewUUrv1fAWRyKfBfTe/FyeB5ewmQ/SInoFRLb0o3UWVMWJjQw1HSS', '2025-2026', '2025-10-02 13:08:14', 'sdas@smcbi.edu.ph'),
(33, 'Jillian Charles', 'M.', 'Villanueva', '123488', '0000-00-00', 'BSIT', '2', 'Male', 'Bansalan', '9638977656', 'Catholic', 'N/A', 'N/A', 'path/to/pic.jpg', '$2y$10$9at9y.qiUxzHrqIdzzLhXujcgnakNoeAzOAJiyIoQkMoOfcCKin0y', '2025-2026', '2025-10-02 13:08:14', 'sdas@smcbi.edu.ph'),
(34, 'Nailyn', 'T.', 'Tongol', '123489', '0000-00-00', 'BSIT', '2', 'Female', 'Bansalan', '9649178365', 'Free Methodist', 'N/A', 'N/A', 'path/to/pic.jpg', '$2y$10$wJ1VHdNSGx0sl4aa4WYQ5Oeh3kKZyaHA8ly0rYItORviIb7OGgbUq', '2025-2026', '2025-10-02 13:08:14', 's_gmail'),
(35, 'Ely Jay', 'C.', 'Labajo', '123490', '0000-00-00', 'BSIT', '2', 'Male', 'Bansalan', '9638231641', 'Catholic', 'N/A', 'N/A', 'path/to/pic.jpg', '$2y$10$sT7.mmmoT3Yv3DjNqxxCu.A6Y4xOUWXJa9c2cbyibTE7cb0SNcL8.', '2025-2026', '2025-10-02 13:08:14', 'sdas@smcbi.edu.ph'),
(36, 'Clark Vincent Maurice', 'A.', 'Morata', '123491', '0000-00-00', 'BSIT', '2', 'Male', 'Bansalan', '9540787033', 'Catholic', 'N/A', 'N/A', 'path/to/pic.jpg', '$2y$10$9PGFnSiGkVW4ev8z2X/OtOBl4b6N43RKQ/hZl1gF7TD7YETofgeXG', '2025-2026', '2025-10-02 13:08:14', 'sdas@smcbi.edu.ph'),
(37, 'Jenny', 'F', 'Gameng', '123492', '0000-00-00', 'BSIT', '2', 'Female', 'Bansalan', '9077741172', 'Catholic', 'N/A', 'N/A', 'path/to/pic.jpg', '$2y$10$RRrbAp/Rx7nHcPwmTZv2NOeEg/5xLU2TUj1w44NeBN.zgnIf0Yy9S', '2025-2026', '2025-10-02 13:08:14', 's_gmail'),
(38, 'Lorenze Red', 'E.', 'Acuzar', '123493', '0000-00-00', 'BSIT', '2', 'Male', 'Bansalan', '9483162177', 'Catholic', 'N/A', 'N/A', 'path/to/pic.jpg', '$2y$10$jBjIYhI0MoGcpIYsqeDYtejPi58JTERc3wm32hIs8OVczhdsjkWbO', '2025-2026', '2025-10-02 13:08:14', 'sdas@smcbi.edu.ph'),
(39, 'Joseph', 'B.', 'Estremos', '123494', '0000-00-00', 'BSIT', '2', 'Male', 'Bansalan', '9102795087', 'Catholic', 'N/A', 'N/A', 'path/to/pic.jpg', '$2y$10$4E3XM2e6keNKrV7nZhHBMO3m4o8L44z/RTpWXoKdwyxZ5i.kjmqAq', '2025-2026', '2025-10-02 13:08:14', 'sdas@smcbi.edu.ph'),
(40, 'John Lloyd', 'M.', 'Molino', '123495', '0000-00-00', 'BSIT', '2', 'Male', 'Bansalan', '9634280980', 'Church of Christ', 'N/A', 'N/A', 'path/to/pic.jpg', '$2y$10$zKWoGL33RN/NgkwaDiMe2OUMRRGW3ra44Y9LtPxiOMUt1LUNyB4Yu', '2025-2026', '2025-10-02 13:08:14', 's_gmail'),
(41, 'Christian Jay', 'C', 'Reyes', '123496', '0000-00-00', 'BSIT', '2', 'Male', 'Bansalan', '9976124182', 'Born Again', 'N/A', 'N/A', 'path/to/pic.jpg', '$2y$10$Xq5mSC7Q8/ur7J/Emkre8eOLQnoNhwTm4mV0usZVlk6vzCi9Zskym', '2025-2026', '2025-10-02 13:08:14', 'sdas@smcbi.edu.ph'),
(42, 'Mariel', 'T.', 'Pareja', '123497', '0000-00-00', 'BSIT', '2', 'Female', 'Bansalan', '9952949681', 'Catholic', 'N/A', 'N/A', 'path/to/pic.jpg', '$2y$10$o2NeheKWcDk2qDeotpZ8w.HGSBE6Lh2mZbQthJl7IjeUGtmipIJYS', '2025-2026', '2025-10-02 13:08:14', 'sdas@smcbi.edu.ph'),
(43, 'Rosmond Ronald', 'M.', 'Batal', '123498', '0000-00-00', 'BSIT', '2', 'Male', 'Bansalan', '9998386238', 'Catholic', 'N/A', 'N/A', 'path/to/pic.jpg', '$2y$10$0iOW6TbiJ2T3gc36bh0RZe7jWkH63wOXFFQqGhGq7R0pYByKK9.oS', '2025-2026', '2025-10-02 13:08:14', 's_gmail'),
(44, 'Jaspher Joe', 'A', 'Corpuz', '123499', '0000-00-00', 'BSIT', '2', 'Male', 'Bansalan', '9363721413', 'Catholic', 'N/A', 'N/A', 'path/to/pic.jpg', '$2y$10$FK49Zad.FICkli33aa6fxOPviuDaOcsp1q.VQpaGwq6DtnSQvdg1.', '2025-2026', '2025-10-02 13:08:14', 'sdas@smcbi.edu.ph'),
(45, 'Nicole', 'P.', 'Valdez', '123500', '0000-00-00', 'BSIT', '2', 'Female', 'Bansalan', '9512308138', 'UCCP', 'N/A', 'N/A', 'path/to/pic.jpg', '$2y$10$bmWa5HA4XZRRqpQmv1eNwOlMwcjoUkTJyE0LdAkLpEfo2/yOXqepS', '2025-2026', '2025-10-02 13:08:14', 'sdas@smcbi.edu.ph'),
(46, 'Kristel', 'O.', 'Hewe', '123501', '0000-00-00', 'BSIT', '2', 'Female', 'Bansalan', '9917629941', 'Catholic', 'N/A', 'N/A', 'path/to/pic.jpg', '$2y$10$m09i2iC.z4alI0bh9SSLeuvoe2sLVrfDQ6fcDtKVGVz/QmXCQwGVS', '2025-2026', '2025-10-02 13:08:14', 's_gmail'),
(47, 'Nathaniel', 'P.', 'Sol', '123502', '0000-00-00', 'BSIT', '2', 'Male', 'Bansalan', '9672250333', 'INC', 'N/A', 'N/A', 'path/to/pic.jpg', '$2y$10$Ek/ewt3QxFLRZnlIlFcUdeuZwIXzhQcE4j5BXJszsJAQduuk33x16', '2025-2026', '2025-10-02 13:08:14', 'sdas@smcbi.edu.ph'),
(48, 'Rocky Bpb', 'S', 'Tambis', '123503', '0000-00-00', 'BSIT', '2', 'Male', 'Bansalan', '9817794184', 'Catholic', 'N/A', 'N/A', 'path/to/pic.jpg', '$2y$10$OV9okz2wlUiGgcP03.wrw.NB9V6j5FhsPwr2YopV2Udgce0vgo27q', '2025-2026', '2025-10-02 13:08:14', 'sdas@smcbi.edu.ph'),
(49, 'Jan Hiro', 'P.', 'Ceniza', '123504', '0000-00-00', 'BSIT', '2', 'Male', 'Bansalan', '9632294080', 'Jehovah\'s Witness', 'N/A', 'N/A', 'path/to/pic.jpg', '$2y$10$I/Dd.ZBMai4P6MwCwLREXOKOdWYEQTM26ypVQRbZo.gPgHz7nVViO', '2025-2026', '2025-10-02 13:08:14', 's_gmail'),
(50, 'Mayco Josh', 'F', 'Pallaya', '123505', '0000-00-00', 'BSIT', '2', 'Male', 'Bansalan', '9815275600', 'Baptist', 'N/A', 'N/A', 'path/to/pic.jpg', '$2y$10$gVdFC.IUViUYmOB3TuGHUOn7jlm/FTTuzSNBHgTri9lUiQ0l0EB8K', '2025-2026', '2025-10-02 13:08:15', 'sdas@smcbi.edu.ph'),
(51, 'Jannel', '', 'Geyrozaga', '123506', '0000-00-00', 'BSIT', '2', 'Male', 'Bansalan', '9094160586', 'Catholic', 'N/A', 'N/A', 'path/to/pic.jpg', '$2y$10$AC57/p2U8XOdl0skKjzDg.11Gvw2JJYOzw8Ghq2DlQPbu7tpCQkEm', '2025-2026', '2025-10-02 13:08:15', 'sdas@smcbi.edu.ph'),
(52, 'Clarence', 'Q', 'Artajo', '123507', '0000-00-00', 'BSIT', '2', 'Male', 'Bansalan', '9982158662', 'Catholic', 'N/A', 'N/A', 'path/to/pic.jpg', '$2y$10$vwXTMUJbghIFhQiKQQUVBuGDn5ZJXBQfLkQym4x5GwPSKAcCGRzq2', '2025-2026', '2025-10-02 13:08:15', 's_gmail'),
(53, 'Stephanie Aime', 'J', 'Nisnisan', '123508', '0000-00-00', 'BSIT', '2', 'Female', 'Bansalan', '9382957176', 'Catholic', 'N/A', 'N/A', 'path/to/pic.jpg', '$2y$10$mbaG4mP44BJG.GVQH4oVyOgzdxPz7op3LP2H8/BZe6ZR6Cd/EeHpO', '2025-2026', '2025-10-02 13:08:15', 'sdas@smcbi.edu.ph'),
(54, 'Marilou', 'Z', 'Antopina', '123509', '0000-00-00', 'BSIT', '2', 'Female', 'Bansalan', '9354618768', 'Baptist', 'N/A', 'N/A', 'path/to/pic.jpg', '$2y$10$DMzKLQZBMnW/EhBbwf9GpOaVvYO1aUQUtB7h/.2dNyZeJJSLfjXxe', '2025-2026', '2025-10-02 13:08:15', 'sdas@smcbi.edu.ph'),
(55, 'Jaymar', 'G.', 'Macabane', '123510', '0000-00-00', 'BSIT', '2', 'Male', 'Bansalan', '9503329518', 'Catholic', 'N/A', 'N/A', 'path/to/pic.jpg', '$2y$10$NVwKhZ4DHDYpu5K/u4ou7OWOHViifAxtBfRVYjr.8Rd2o7spdfAxa', '2025-2026', '2025-10-02 13:08:15', 's_gmail'),
(56, 'Rv Fender', 'P.', 'Rasonable', '123511', '0000-00-00', 'BSIT', '2', 'Male', 'Bansalan', '9105673617', 'Catholic', 'N/A', 'N/A', 'path/to/pic.jpg', '$2y$10$7gSwzvcL.2ZusVfgg3wazOeko1er/KzCgT2CDOW5l1V0688ff1BFq', '2025-2026', '2025-10-02 13:08:15', 'sdas@smcbi.edu.ph'),
(57, 'Aravela Grace', 'R.', 'Apas', '123512', '0000-00-00', 'BSIT', '2', 'Female', 'Bansalan', '9065169435', 'Catholic', 'N/A', 'N/A', 'path/to/pic.jpg', '$2y$10$hoOV7uS0/brTaoUTTPjpfOtyFCivx//qrHmDosd7J.kwE4gUpQuoy', '2025-2026', '2025-10-02 13:08:15', 'sdas@smcbi.edu.ph'),
(58, 'Jomari', 'M.', 'Canezo', '123513', '0000-00-00', 'BSIT', '2', 'Male', 'Bansalan', '9500434655', 'Catholic', 'N/A', 'N/A', 'path/to/pic.jpg', '$2y$10$g1iagZoOM4hljTwUtA.fm.Q5fmHzzZ0Er1Jt3ZT3vD1wbQCTDvwxO', '2025-2026', '2025-10-02 13:08:15', 's_gmail'),
(59, 'Jay Mark', 'C', 'Onis', '123514', '0000-00-00', 'BSIT', '2', 'Male', 'Bansalan', '9285617608', 'Catholic', 'N/A', 'N/A', 'path/to/pic.jpg', '$2y$10$hXN7LyhwVLyWy8z4.ZnjLOVY9VRNgt6500O/DfholIedjdv5jD1HK', '2025-2026', '2025-10-02 13:08:15', 'sdas@smcbi.edu.ph'),
(60, 'Kirby', '', 'Redondiez', '123515', '0000-00-00', 'BSIT', '2', 'Male', 'Bansalan', '9063881122', 'Catholic', 'N/A', 'N/A', 'path/to/pic.jpg', '$2y$10$/dODX1ixMZzEMrEVUD/yMuElMjWrnn.udTmDQ8N4MUNhzsxem/b9K', '2025-2026', '2025-10-02 13:08:15', 'sdas@smcbi.edu.ph'),
(61, 'Hymon Clark', 'T.', 'Balwit', '123516', '0000-00-00', 'BSIT', '2', 'Male', 'Bansalan', '9304706677', 'Catholic', 'N/A', 'N/A', 'path/to/pic.jpg', '$2y$10$A0v/GBv40Mh812TU.nHn5uxJ2JqOwv.bN6ZDgORJKRegeJZhC6XH.', '2025-2026', '2025-10-02 13:08:15', 's_gmail'),
(62, 'Keith Stephen', '', 'Catubay', '123517', '0000-00-00', 'BSIT', '2', 'Male', 'Bansalan', '9362111544', 'Catholic', 'N/A', 'N/A', 'path/to/pic.jpg', '$2y$10$Yx62ewdNDeLhvNPQysezhei4tzDUQyPevT6xkKvF09ElAgkFug5qS', '2025-2026', '2025-10-02 13:08:15', 's_gmail'),
(63, 'Christian', '', 'Nilo', '123518', '0000-00-00', 'BSIT', '2', 'Male', 'Bansalan', '9360736328', 'INC', 'N/A', 'N/A', 'path/to/pic.jpg', '$2y$10$jNkjzA4HG1wpnrZjfm4nXewLyTrEmoE3tzYo9ICYVVHxqkHuAxaPG', '2025-2026', '2025-10-02 13:08:15', 'sdas@smcbi.edu.ph'),
(64, 'Crystal Amaze', 'O.', 'Espinosa', '123519', '0000-00-00', 'BSIT', '2', 'Female', 'Bansalan', '9093770536', 'Baptist', 'N/A', 'N/A', 'path/to/pic.jpg', '$2y$10$JZPkhVAFg.fcrofg9C3R7eCQdeiWT1F4CdOc293/cT/m3CncV.AXK', '2025-2026', '2025-10-02 13:08:15', 'sdas@smcbi.edu.ph'),
(65, 'Cythea Joyce', 'L', 'Corpuz', '123520', '0000-00-00', 'BSIT', '2', 'Female', 'Bansalan', '9513766151', 'Catholic', 'N/A', 'N/A', 'path/to/pic.jpg', '$2y$10$EG3dB6D75hMzaGkM9KJ21OXkQKIytwgDZzPaBNRAd/9PdfbZTmpaS', '2025-2026', '2025-10-02 13:08:15', 's_gmail'),
(66, 'Kin Laurence Josh', 'C', 'Florentino', '123521', '0000-00-00', 'BSIT', '2', 'Male', 'Bansalan', '9633409767', 'Catholic', 'N/A', 'N/A', 'path/to/pic.jpg', '$2y$10$r3ZJEnm6ZZezOOqJfuYxH.hzMxx0N9mfhNlowxgOVWcZP38fVLgoq', '2025-2026', '2025-10-02 13:08:15', 'sdas@smcbi.edu.ph'),
(67, 'Yullard', 'A.', 'Dinoy', '123522', '0000-00-00', 'BSIT', '2', 'Male', 'Bansalan', '9630539856', 'CAMACOP', 'N/A', 'N/A', 'path/to/pic.jpg', '$2y$10$fdHYzVa38TWgFUrVyZdcXOqe/rX9y7J0pXdw4rPhOlnyRrZ93FUau', '2025-2026', '2025-10-02 13:08:15', 'sdas@smcbi.edu.ph'),
(68, 'John Mark', '', 'Opong', '123523', '0000-00-00', 'BSIT', '2', 'Male', 'Bansalan', '9555096960', 'INC', 'N/A', 'N/A', 'path/to/pic.jpg', '$2y$10$GP2KFTSJvkkzAGexmG9kbeofvXu6LzdJ44DQg7GJ8Z4Nntmp0oKqm', '2025-2026', '2025-10-02 13:08:15', 's_gmail'),
(69, 'John Philip', 'G.', 'Dalaguit', '123524', '0000-00-00', 'BSIT', '2', 'Male', 'Bansalan', '9678026665', 'Catholic', 'N/A', 'N/A', 'path/to/pic.jpg', '$2y$10$E5gAhZKExRJi4PrU3iuS6OAFd6aI91snGFmG.jAl4kLYdOIe0FESq', '2025-2026', '2025-10-02 13:08:15', 'sdas@smcbi.edu.ph'),
(70, 'Gian', '', 'Gillo', '123525', '0000-00-00', 'BSIT', '2', 'Male', 'Bansalan', '9510262872', 'Catholic', 'N/A', 'N/A', 'path/to/pic.jpg', '$2y$10$XJZVTOrHD9/UYBF7.FjIGeQWGWhPwMq7jfmBO3LELCsGftWH36eR2', '2025-2026', '2025-10-02 13:08:16', 'sdas@smcbi.edu.ph'),
(71, 'Earnest Jay', 'L.', 'Samson', '123526', '0000-00-00', 'BSIT', '2', 'Male', 'Bansalan', '9362275809', 'Catholic', 'N/A', 'N/A', 'path/to/pic.jpg', '$2y$10$wPWgKY581s2EHZ2FDHWfTO6GuYMjtv7fKmuu3FdMvrLfogdQuEJIa', '2025-2026', '2025-10-02 13:08:16', 's_gmail'),
(72, 'Aurelyn May', '', 'Palamara', '123527', '0000-00-00', 'BSIT', '2', 'Female', 'Bansalan', '9106875359', 'Catholic', 'N/A', 'N/A', 'path/to/pic.jpg', '$2y$10$iZZJ82v7Fxp2xFDwqgNDO.VyfgV163fg0cvgb12DkiJzbSSLOImji', '2025-2026', '2025-10-02 13:08:16', 'sdas@smcbi.edu.ph'),
(73, 'Prince MJ', 'D.', 'Canencia', '123528', '0000-00-00', 'BSIT', '2', 'Male', 'Bansalan', '9950286676', 'Catholic', 'N/A', 'N/A', 'path/to/pic.jpg', '$2y$10$M4ab5a8hf7n9QK1RbiaJQuSRRVNMVmIHRHMW3UuJALzEVM70U7wN6', '2025-2026', '2025-10-02 13:08:16', 'sdas@smcbi.edu.ph'),
(74, 'Tristan Michael', 'G.', 'Francisco', '123529', '0000-00-00', 'BSIT', '2', 'Male', 'Bansalan', '9708865145', 'Catholic', 'N/A', 'N/A', 'path/to/pic.jpg', '$2y$10$CYXo.d/QtZqZEFJ.ANScPeL.0BzjIA5zkNcGt37tCTG//zxEVMooy', '2025-2026', '2025-10-02 13:08:16', 's_gmail'),
(75, 'Eroll John', 'Q.', 'Llego', '123530', '0000-00-00', 'BSIT', '2', 'Male', 'Bansalan', '9635442332', 'Catholic', 'N/A', 'N/A', 'path/to/pic.jpg', '$2y$10$zM.sImbWEQp9GDMIGCxF2.wVPbBeXV/QR0riw3K2QE1MJAlkFTehi', '2025-2026', '2025-10-02 13:08:16', 'sdas@smcbi.edu.ph'),
(76, 'John Robert', '', 'Lozano', '123531', '0000-00-00', 'BSIT', '2', 'Male', 'Bansalan', '9514080723', 'Catholic', 'N/A', 'N/A', 'path/to/pic.jpg', '$2y$10$jV1cDa/VYQCLWverJO665eG.2ohW1oWXS0ykbl2iagbIxJn4rq4rm', '2025-2026', '2025-10-02 13:08:16', 'sdas@smcbi.edu.ph'),
(77, 'Ian Jake', 'C', 'Dasmari?as', '123532', '0000-00-00', 'BSIT', '2', 'Male', 'Bansalan', '9538730154', 'Catholic', 'N/A', 'N/A', 'path/to/pic.jpg', '$2y$10$toX1/lFoZ2hoPkFFm10bmeMZz83qTdgPO6.y5Q7ub.X3DiFNQMjRG', '2025-2026', '2025-10-02 13:08:16', 's_gmail'),
(78, 'Mark Anthony', 'D.', 'Arellano', '123533', '0000-00-00', 'BSIT', '2', 'Male', 'Bansalan', '9054563786', 'Catholic', 'N/A', 'N/A', 'path/to/pic.jpg', '$2y$10$cE73Ab1deTxk4HJsrxpcx.CT/aRhBB2lER0sLVa4d9bi09owl4cqe', '2025-2026', '2025-10-02 13:08:16', 'sdas@smcbi.edu.ph'),
(79, 'Pryncess Zanette', 'C.', 'Pinto', '123534', '0000-00-00', 'BSIT', '2', 'Female', 'Bansalan', '9855975420', 'Baptist', 'N/A', 'N/A', 'path/to/pic.jpg', '$2y$10$2fRrbl2Z6MeDnEZRLie10.sHnkSyq0o.8GcRbM2wV7FoLuuKBoGXS', '2025-2026', '2025-10-02 13:08:16', 'sdas@smcbi.edu.ph'),
(80, 'Jinrel', 'J.', 'Golosinda', '123535', '0000-00-00', 'BSIT', '2', 'Male', 'Bansalan', '9109206034', 'Catholic', 'N/A', 'N/A', 'path/to/pic.jpg', '$2y$10$/wPyen5AtR0W89sxg76gA.5ONx8egmEB.uaE7k8MuXgzTxb4/GiLq', '2025-2026', '2025-10-02 13:08:16', 's_gmail'),
(81, 'Jon Evan', 'F.', 'Vistacion', '123536', '0000-00-00', 'BSIT', '2', 'Male', 'Bansalan', '9077515757', 'Church of Christ', 'N/A', 'N/A', 'path/to/pic.jpg', '$2y$10$eVJnyU3ooGB0QgSS/DpSieajC8sKS7tr9x3NjRtnyyxYz//6z1JzC', '2025-2026', '2025-10-02 13:08:16', 'sdas@smcbi.edu.ph'),
(82, 'Cedric Jerome', '', 'Nilo', '123537', '0000-00-00', 'BSIT', '2', 'Male', 'Bansalan', '9305042985', 'Church of Christ', 'N/A', 'N/A', 'path/to/pic.jpg', '$2y$10$HfluY3IvS5SMscVDFgJLveyhlnxJL2K/G7RX114vydTZ.kEA3RL8.', '2025-2026', '2025-10-02 13:08:16', 'sdas@smcbi.edu.ph'),
(83, 'Jay', 'C.', 'Jangalay', '123538', '0000-00-00', 'BSIT', '2', 'Male', 'Bansalan', '9513732643', 'WMS Church of God', 'N/A', 'N/A', 'path/to/pic.jpg', '$2y$10$CVWY4nj1oGrNh8rJjD2It.KIhnZ5epzuE/PvTPRGPxwwwIA8TTMQG', '2025-2026', '2025-10-02 13:08:16', 's_gmail'),
(84, 'Crisnel Jee', 'A.', 'Balunan', '123539', '0000-00-00', 'BSIT', '2', 'Male', 'Bansalan', '9639683063', 'N/A', 'N/A', 'N/A', 'path/to/pic.jpg', '$2y$10$RSR7wyOoczEYNp82/79.MOzcPFLYqcICSBJB9OFtXieXEvw4hUhai', '2025-2026', '2025-10-02 13:08:16', 'sdas@smcbi.edu.ph'),
(85, 'Christian', 'V.', 'Gabuya', '123540', '0000-00-00', 'BSIT', '2', 'Male', 'Bansalan', '9519349865', 'Catholic', 'N/A', 'N/A', 'path/to/pic.jpg', '$2y$10$GwJckYNgVTbcfW40vr9vV.AaolzZBO4TSnSADB4n9kx5s/TE8eNwe', '2025-2026', '2025-10-02 13:08:16', 'sdas@smcbi.edu.ph'),
(86, 'Russel', 'S.', 'Diantor', '123541', '0000-00-00', 'BSIT', '2', 'Male', 'Bansalan', '9519471722', 'Catholic', 'N/A', 'N/A', 'path/to/pic.jpg', '$2y$10$q1LiI01nacunXNpBHtUMPuoNo8vs77Hr5BvCMnrPKbvTd88ErRgci', '2025-2026', '2025-10-02 13:08:16', 's_gmail'),
(87, 'Vincent', 'M.', 'Toyco', '123542', '0000-00-00', 'BSIT', '2', 'Male', 'Bansalan', '9533523496', 'INC', 'N/A', 'N/A', 'path/to/pic.jpg', '$2y$10$Sz8ujwcNgXDRoX3uLjhKiuzdhBUSnS0144PXhdc36gYTbEjzavdoa', '2025-2026', '2025-10-02 13:08:16', 'sdas@smcbi.edu.ph'),
(88, 'Rovel John', 'L.', 'Otom', '123543', '0000-00-00', 'BSIT', '2', 'Male', 'Bansalan', '9351784360', 'Catholic', 'N/A', 'N/A', 'path/to/pic.jpg', '$2y$10$w.thWc6DUMyb4CCxpysZuO86HC1sn7ZimnOKgzEp2v25XSKiennkO', '2025-2026', '2025-10-02 13:08:16', 'sdas@smcbi.edu.ph'),
(89, 'Prince Joshua', 'C.', 'Sanchez', '123544', '0000-00-00', 'BSIT', '2', 'Male', 'Bansalan', '9062586309', 'Catholic', 'N/A', 'N/A', 'path/to/pic.jpg', '$2y$10$OjFjKFqccIe3MNRdFEGFCuoSiup.DL.hJcqqqzWZxBcunp9ppRqYK', '2025-2026', '2025-10-02 13:08:16', 's_gmail'),
(90, 'Keirlstan', '', 'Ybanez', '123545', '0000-00-00', 'BSIT', '2', 'Male', 'Bansalan', '9307980137', 'Catholic', 'N/A', 'N/A', 'path/to/pic.jpg', '$2y$10$WSxGXXXWyz7GpnVATSQe7e2sq4UULKLs9arjEnNC2Coaz.8GoWAMS', '2025-2026', '2025-10-02 13:08:17', 'sdas@smcbi.edu.ph'),
(91, 'Noveneil Jhon', 'A.', 'Molinas', '123546', '0000-00-00', 'BSIT', '2', 'Male', 'Bansalan', '9516424974', 'Catholic', 'N/A', 'N/A', 'path/to/pic.jpg', '$2y$10$mqLzd0.EjTqqGVaGDiFUTeC1LD9dQRPZ.b3hCMz.wTGGMDd.P6A8m', '2025-2026', '2025-10-02 13:08:17', 'sdas@smcbi.edu.ph'),
(92, 'Jan Hiro', 'P.', 'Ceniza', '123547', '0000-00-00', 'BSIT', '2', 'Male', 'Bansalan', '9632294080', 'Jehovah\'s Witness', 'N/A', 'N/A', 'path/to/pic.jpg', '$2y$10$qI6UPMrvg1rhoJ4j8gbXR.7k/0W93tNPVDrMJF7tMI6PuP6nMoxvm', '2025-2026', '2025-10-02 13:08:17', 's_gmail'),
(93, 'Kerr Vincent', '', 'Jubahib', '123548', '0000-00-00', 'BSIT', '3', 'Male', 'Bansalan', '9630633582', 'Aglipay', 'N/A', 'N/A', 'path/to/pic.jpg', '$2y$10$5hLNJckWkTuKvbxZOgRCSe4v4G4tRDmEm1.qb.vqQuYjvEh5X9itG', '2025-2026', '2025-10-02 13:08:17', 's_gmail'),
(94, 'Mel Bhoy', 'R,', 'Denaque', '123549', '0000-00-00', 'BSIT', '3', 'Male', 'Bansalan', '9129056011', 'Catholic', 'N/A', 'N/A', 'path/to/pic.jpg', '$2y$10$.d0hCme61qzdv8i0B55e6.Yz1yxVScIIVeD7r7Z2InpxlK4KZg7aW', '2025-2026', '2025-10-02 13:08:17', 'sdas@smcbi.edu.ph'),
(95, 'Joesil', 'A.', 'Mosquiza', '123550', '0000-00-00', 'BSIT', '3', 'Male', 'Bansalan', '9662418452', 'Catholic', 'N/A', 'N/A', 'path/to/pic.jpg', '$2y$10$lPvpea1H3pMBLzwBbW4lXuDaECbn.s2LxqZenZmHEYLKSwH4SvhT.', '2025-2026', '2025-10-02 13:08:17', 'sdas@smcbi.edu.ph'),
(96, 'Daryl', 'D.', 'Sabanal', '123551', '0000-00-00', 'BSIT', '3', 'Male', 'Bansalan', '9487502479', 'Catholic', 'N/A', 'N/A', 'path/to/pic.jpg', '$2y$10$GpYhyV/xLG.iufFQ8Ayeludv3UtLfjx55tP9ZtuzjqN4f7ldbbcly', '2025-2026', '2025-10-02 13:08:17', 's_gmail'),
(97, 'John Mc Clane', 'H.', 'Arellano', '123552', '0000-00-00', 'BSIT', '3', 'Male', 'Bansalan', '9631995437', 'Catholic', 'N/A', 'N/A', 'path/to/pic.jpg', '$2y$10$kmW2xPAqN4TDTfK9RGujw.zBokmK5TGcUeyM65Gfv0GYemmxpSMaK', '2025-2026', '2025-10-02 13:08:17', 'sdas@smcbi.edu.ph'),
(98, 'Mark Louin', 'B.', 'Torres', '123553', '0000-00-00', 'BSIT', '3', 'Male', 'Bansalan', '9462130983', 'Catholic', 'N/A', 'N/A', 'path/to/pic.jpg', '$2y$10$9y4HIEcQueRjNFZvysY/h.GmZ1mLWf8hMcwkmXniPdcfLfg1ME2Na', '2025-2026', '2025-10-02 13:08:17', 'sdas@smcbi.edu.ph'),
(99, 'Jhyzie', 'S.', 'Cano', '123554', '0000-00-00', 'BSIT', '3', 'Male', 'Bansalan', '9486274675', 'RFG', 'N/A', 'N/A', 'path/to/pic.jpg', '$2y$10$qCHZ6SjJfsg1GTizTOZU8OEeGxtMbOqT2IkB2RcLoF1ZKwE8IXgxW', '2025-2026', '2025-10-02 13:08:17', 's_gmail'),
(100, 'Julie Ann', 'P.', 'Navor', '123555', '0000-00-00', 'BSIT', '3', 'Female', 'Bansalan', '9076921897', 'Born Again', 'N/A', 'N/A', 'path/to/pic.jpg', '$2y$10$xFqfuBonCohvxeAxAJU9t.aIrUwpvm0CjfdZVQ2G7O5qQzJS68ipe', '2025-2026', '2025-10-02 13:08:17', 'sdas@smcbi.edu.ph'),
(101, 'Gwen', 'S.', 'Alpuerto', '123556', '0000-00-00', 'BSIT', '3', 'Female', 'Bansalan', '9709359544', 'Catholic', 'N/A', 'N/A', 'path/to/pic.jpg', '$2y$10$I/.7k5OMeLPRsQFxBi7IzOH/bMW9cbBzVQySH233FaZqg9n5P/e96', '2025-2026', '2025-10-02 13:08:17', 'sdas@smcbi.edu.ph'),
(102, 'Fritz', 'E.', 'Ramirez', '123557', '0000-00-00', 'BSIT', '3', 'Male', 'Bansalan', '9306793869', 'Catholic', 'N/A', 'N/A', 'path/to/pic.jpg', '$2y$10$Ol6dMK9hJoHNiJKxDdYKduo4qScbfqpavUEHLQ2RRmMu16gOn6acq', '2025-2026', '2025-10-02 13:08:17', 's_gmail'),
(103, 'Hans Kurvey', 'C.', 'Filart', '123558', '0000-00-00', 'BSIT', '3', 'Male', 'Bansalan', '9516184991', 'Catholic', 'N/A', 'N/A', 'path/to/pic.jpg', '$2y$10$iR4g2jFZnz8j0ePHi/AN.uUZ6veeS.AORy0Ps6DOgF5tLSEv2SvFq', '2025-2026', '2025-10-02 13:08:17', 'sdas@smcbi.edu.ph'),
(104, 'Kent Joshua', 'L.', 'Escobar', '123559', '0000-00-00', 'BSIT', '3', 'Male', 'Bansalan', '9630987753', 'Catholic', 'N/A', 'N/A', 'path/to/pic.jpg', '$2y$10$1MoBFf0iVmCp9Yd4gXPP9.uGSutKjkrwGhUnjzYiGKAzRp6mKzX2a', '2025-2026', '2025-10-02 13:08:17', 'sdas@smcbi.edu.ph'),
(105, 'Charles Arone', 'R.', 'Acebar', '123560', '0000-00-00', 'BSIT', '3', 'Male', 'Bansalan', '9216470705', 'Catholic', 'N/A', 'N/A', 'path/to/pic.jpg', '$2y$10$CFNqGk5jmzidmSpIydGnuuZ.4i3/ENSIQhJT1v52wfhFbi5WNouqy', '2025-2026', '2025-10-02 13:08:17', 's_gmail'),
(106, 'Jade', 'A', 'Villagracia', '123561', '0000-00-00', 'BSIT', '3', 'Male', 'Bansalan', '9855004337', 'Catholic', 'N/A', 'N/A', 'path/to/pic.jpg', '$2y$10$1eNAnlnKZU9B/tx40UPsVeqvDG//RXuHfHTp1y9ppAkPdWlZv5Kt2', '2025-2026', '2025-10-02 13:08:17', 'sdas@smcbi.edu.ph'),
(107, 'Jeric Jay', '', 'Ubat', '123562', '0000-00-00', 'BSIT', '3', 'Male', 'Bansalan', '9487200509', 'Catholic', 'N/A', 'N/A', 'path/to/pic.jpg', '$2y$10$25PVEnapJN2ux0e5S.zI7evzx2f/976PQNLKhb8nx0qKZXuA687YC', '2025-2026', '2025-10-02 13:08:17', 'sdas@smcbi.edu.ph'),
(108, 'Sharwin', 'A.', 'Terambulo', '123563', '0000-00-00', 'BSIT', '3', 'Male', 'Bansalan', '9519628432', 'Catholic', 'N/A', 'N/A', 'path/to/pic.jpg', '$2y$10$6WVSzcnDgw4gVJ3O2GJDjugZE06QOB2xFf6O0XcI6Y4XVyUvmtj.W', '2025-2026', '2025-10-02 13:08:17', 's_gmail'),
(109, 'Mikailla', 'C.', 'Malubay', '123564', '0000-00-00', 'BSIT', '3', 'Female', 'Bansalan', '9639358335', 'Catholic', 'N/A', 'N/A', 'path/to/pic.jpg', '$2y$10$/o7ELigpUNKxZuthx7k8D.ipxEz7nugotDnuHuPeF9KwH/gszknTS', '2025-2026', '2025-10-02 13:08:17', 'sdas@smcbi.edu.ph'),
(110, 'Nillyn Margarette', '', 'Bagnol', '123565', '0000-00-00', 'BSIT', '3', 'Female', 'Bansalan', '9705577276', 'Catholic', 'N/A', 'N/A', 'path/to/pic.jpg', '$2y$10$Mr3XFzrP0KOGltLai2t0JOckhLP94LKoVflz9PKDcyqEPkx3EqlTu', '2025-2026', '2025-10-02 13:08:18', 'sdas@smcbi.edu.ph'),
(111, 'John Alfonsus', 'B', 'Taruc II', '123566', '0000-00-00', 'BSIT', '3', 'Male', 'Bansalan', '9153273989', 'Catholic', 'N/A', 'N/A', 'path/to/pic.jpg', '$2y$10$xLxoT.SAfZwTXd2a2MRzFuA83yxYPPEsxyQphWWxdP1YllAZVS7ka', '2025-2026', '2025-10-02 13:08:18', 's_gmail'),
(112, 'Jhon Christopher', 'R.', 'Potestas', '123567', '0000-00-00', 'BSIT', '3', 'Male', 'Bansalan', '9389129262', 'Catholic', 'N/A', 'N/A', 'path/to/pic.jpg', '$2y$10$vT5IgtDog08MgbVMS.EvROgyFB6Lw8CqKLHJBPXk1.b0OZ9AG5ZRq', '2025-2026', '2025-10-02 13:08:18', 'sdas@smcbi.edu.ph'),
(113, 'Edrian', 'C.', 'Castillion', '123568', '0000-00-00', 'BSIT', '3', 'Male', 'Bansalan', '9486369503', 'Baptist', 'N/A', 'N/A', 'path/to/pic.jpg', '$2y$10$GTkP0qdfcYs8HvDCzJzoO.3zd6FMrwrqaCFbUWnwGL2pV/cmWutMu', '2025-2026', '2025-10-02 13:08:18', 'sdas@smcbi.edu.ph'),
(114, 'Van April', 'C.', 'Constantino', '123569', '0000-00-00', 'BSIT', '3', 'male', 'Bansalan', '9518127518', 'Alliance', 'N/A', 'N/A', 'path/to/pic.jpg', '$2y$10$J90hs9Osy6Iel2WO6iT6mO28RWxkxXlMv/sIZbdBO13Q3yj1dHeOW', '2025-2026', '2025-10-02 13:08:18', 's_gmail'),
(115, 'John Louie', '', 'Diano', '123570', '0000-00-00', 'BSIT', '3', 'Male', 'Bansalan', '9633638660', 'Pentecostal', 'N/A', 'N/A', 'path/to/pic.jpg', '$2y$10$G4vGl.pP41OEog/atRw7AOqa9ilrSldtgu61Wa0UcnBu423qx1iiy', '2025-2026', '2025-10-02 13:08:18', 'sdas@smcbi.edu.ph'),
(116, 'Glenn Andrey', 'Q.', 'Ulep', '123571', '0000-00-00', 'BSIT', '3', 'Male', 'Bansalan', '9512529022', 'Catholic', 'N/A', 'N/A', 'path/to/pic.jpg', '$2y$10$X2Wr4eBM3jbaOf2hW4PFE.bgVcIF7LdxCuoUxcANSdsQnR//0Yx42', '2025-2026', '2025-10-02 13:08:18', 'sdas@smcbi.edu.ph'),
(117, 'Kent', 'I.', 'Balalio', '123572', '0000-00-00', 'BSIT', '3', 'Male', 'Bansalan', '9700307888', 'Catholic', 'N/A', 'N/A', 'path/to/pic.jpg', '$2y$10$Il0mALJNGTQyQToUQYL.aeEfu5P2a4q05YyfWfL4OqrLxqmEa71g6', '2025-2026', '2025-10-02 13:08:18', 's_gmail'),
(118, 'Lovely Jean', '', 'Samoranos', '123573', '0000-00-00', 'BSIT', '3', 'Female', 'Bansalan', '9678752500', 'Catholic', 'N/A', 'N/A', 'path/to/pic.jpg', '$2y$10$zX/d3ESZhWEC8FN5Gz6YmeeLEZW1M.PFeW.0E4/f4hRuVs3W8QKiW', '2025-2026', '2025-10-02 13:08:18', 'sdas@smcbi.edu.ph'),
(119, 'Julie Mae', '', 'Cardeno', '123574', '0000-00-00', 'BSIT', '3', 'Female', 'Bansalan', '9513639070', 'Catholic', 'N/A', 'N/A', 'path/to/pic.jpg', '$2y$10$nJRBbdJEuJ3GrBt/p21u3u1axHI4r.xYoVTMTab5WpQjI88nAWygq', '2025-2026', '2025-10-02 13:08:18', 'sdas@smcbi.edu.ph'),
(120, 'Cesar', 'C.', 'Taclahan Jr.', '123575', '0000-00-00', 'BSIT', '3', 'Male', 'Bansalan', '9538730099', 'Catholic', 'N/A', 'N/A', 'path/to/pic.jpg', '$2y$10$o84Yk1gfgSgu5BImewhddOasvVdDGPGVzRjZ7DVaPDPjtOrGRuOAe', '2025-2026', '2025-10-02 13:08:18', 's_gmail'),
(121, 'Jeremiah', 'F.', 'Escubido', '123576', '0000-00-00', 'BSIT', '3', 'Male', 'Bansalan', '9774901239', 'Catholic', 'N/A', 'N/A', 'path/to/pic.jpg', '$2y$10$DaMGMpK8II2PTj4d2CSDI.pihO5kXCojSI2Xw3ivwwlJ5wruYu0Na', '2025-2026', '2025-10-02 13:08:18', 'sdas@smcbi.edu.ph'),
(122, 'Peter Paul', 'L.', 'Parcon', '123577', '0000-00-00', 'BSIT', '3', 'Male', 'Bansalan', '9943604119', 'Catholic', 'N/A', 'N/A', 'path/to/pic.jpg', '$2y$10$IAj7ll3hpqxMJum/6neYFOf/hh1ffV345eMfcOjAuRvJGl8hKx77e', '2025-2026', '2025-10-02 13:08:18', 'sdas@smcbi.edu.ph'),
(123, 'Jacqueline Dorothy', 'S.', 'Soriano', '123578', '0000-00-00', 'BSIT', '3', 'Female', 'Bansalan', '9952286486', 'Latter Day Saints', 'N/A', 'N/A', 'path/to/pic.jpg', '$2y$10$IVznlkxqQ8mlzWNLkv9JMeIa.4TU1v/NwF6kmFqCcttamS5q1jqGe', '2025-2026', '2025-10-02 13:08:18', 's_gmail'),
(124, 'Joemar', 'C.', 'Dubria', '123579', '0000-00-00', 'BSIT', '3', 'Male', 'Bansalan', '9083813514', 'Catholic', 'N/A', 'N/A', 'path/to/pic.jpg', '$2y$10$m1Zbexx2qDXPKQdHTdNcoOHsRffK.kTPiTSAqfUf6eb2ajXbIUvyG', '2025-2026', '2025-10-02 13:08:18', 's_gmail'),
(125, 'Jhon Dave', '', 'Bosbos', '123580', '0000-00-00', 'BSIT', '3', 'Male', 'Bansalan', '9083813514', 'Christian', 'N/A', 'N/A', 'path/to/pic.jpg', '$2y$10$k/nfrsmYRYHHhIEKyJCViuutQBIj8A8Vop0v/Y/eliGy31O5ijaZK', '2025-2026', '2025-10-02 13:08:18', 'sdas@smcbi.edu.ph'),
(126, 'Jesasa Mae', '', 'Gil', '123581', '0000-00-00', 'BSIT', '3', 'Female', 'Bansalan', '9700258170', 'Catholic', 'N/A', 'N/A', 'path/to/pic.jpg', '$2y$10$.AL5g1aax8Y1yHjVrvc3fORpdI0vhiKY2/0VLU.fMNa7TCDrzdaaO', '2025-2026', '2025-10-02 13:08:18', 'sdas@smcbi.edu.ph'),
(127, 'Lencer', 'C', 'Mesamin', '123582', '0000-00-00', 'BSIT', '4', 'Male', 'Bansalan', '9306268971', 'Catholic', 'N/A', 'N/A', 'path/to/pic.jpg', '$2y$10$7KIjMncyGYelWZ2P7uWak.lZ.xUnNunvN08DhRswGStt/gxXVNCom', '2025-2026', '2025-10-02 13:08:18', 's_gmail'),
(128, 'Jolly', 'R.', 'Pacure', '123583', '0000-00-00', 'BSIT', '4', 'Male', 'Bansalan', '9453553360', 'Catholic', 'N/A', 'N/A', 'path/to/pic.jpg', '$2y$10$CEd2BlwiFyd.qE3i87gcuuAHROvxIjAx70Wr/JDEz.i9jwIHFl1yi', '2025-2026', '2025-10-02 13:08:18', 'sdas@smcbi.edu.ph'),
(129, 'Jumelyn', 'A', 'Salende', '123584', '0000-00-00', 'BSIT', '4', 'Female', 'Bansalan', '9385918877', 'Alliance', 'N/A', 'N/A', 'path/to/pic.jpg', '$2y$10$Wq4eXUVV/O8ixQX.j.NjQecKY.C2CQ0UscRpyIqtXlIBcKL3JkJCG', '2025-2026', '2025-10-02 13:08:18', 'sdas@smcbi.edu.ph'),
(130, 'Bridget John', '', 'Gocotano', '123585', '0000-00-00', 'BSIT', '4', 'Male', 'Bansalan', '9128565539', 'Catholic', 'N/A', 'N/A', 'path/to/pic.jpg', '$2y$10$91GDW/Ry9rHcTb2IZZRBsu1Ylk.gCG9Y3bqnDuPe7GAxF6bXm.sdW', '2025-2026', '2025-10-02 13:08:19', 's_gmail'),
(131, 'Karl', '', 'Navidad', '123586', '0000-00-00', 'BSIT', '4', 'Male', 'Bansalan', '9635762921', 'Catholic', 'N/A', 'N/A', 'path/to/pic.jpg', '$2y$10$YFBe7U7q2Bi4lmgDtj7RSuZonyChMURc1Wp74hacj8o6D4vaSkmTS', '2025-2026', '2025-10-02 13:08:19', 'sdas@smcbi.edu.ph'),
(132, 'Alice Mae', 'C', 'Aguirre', '123587', '0000-00-00', 'BSIT', '4', 'Female', 'Bansalan', '9054559879', 'UCCP', 'N/A', 'N/A', 'path/to/pic.jpg', '$2y$10$BDsxmX6FnT.wcY.9He7nX.tfFu9WQlnDgScE5Nj8EnQcky10b9FRS', '2025-2026', '2025-10-02 13:08:19', 'sdas@smcbi.edu.ph'),
(133, 'Ricahrd John', 'M.', 'Reyes', '123588', '0000-00-00', 'BSIT', '4', 'Male', 'Bansalan', '9063664298', 'Catholic', 'N/A', 'N/A', 'path/to/pic.jpg', '$2y$10$f1oI/96r9IPwx5wMJHqareOKBBEu356BGZ0TdJgy1UkZB2j4x3feK', '2025-2026', '2025-10-02 13:08:19', 's_gmail'),
(134, 'John Paolo', 'M.', 'Saballegue', '123589', '0000-00-00', 'BSIT', '4', 'Male', 'Bansalan', '9391538645', 'COC', 'N/A', 'N/A', 'path/to/pic.jpg', '$2y$10$hAyuiYZizW8.BI.g91SN2.hA6M5d7vJjdAGjc4NIqZNfp5L9PGvi.', '2025-2026', '2025-10-02 13:08:19', 'sdas@smcbi.edu.ph'),
(135, 'Nina Jane', 'Z.', 'Comaingking', '123590', '0000-00-00', 'BSIT', '4', 'Female', 'Bansalan', '9972990701', 'Catholic', 'N/A', 'N/A', 'path/to/pic.jpg', '$2y$10$lciY.8ExCx0JzJhXn9yx1.V1ndrGwc/zLNaZAGqiNBTfbV6N/rwVq', '2025-2026', '2025-10-02 13:08:19', 'sdas@smcbi.edu.ph'),
(136, 'Joshua Dave', 'F.', 'Sescon', '123591', '0000-00-00', 'BSIT', '4', 'Male', 'Bansalan', '9989375163', 'Catholic', 'N/A', 'N/A', 'path/to/pic.jpg', '$2y$10$Zy4lOKSBhA0YWsrviNxG3OrBaVDUGtR2fiEr0V1nonKQJyFauF.6O', '2025-2026', '2025-10-02 13:08:19', 's_gmail'),
(137, 'Mary Rose', 'Q.', 'Buhian', '123592', '0000-00-00', 'BSIT', '4', 'Female', 'Bansalan', '9273191931', 'Catholic', 'N/A', 'N/A', 'path/to/pic.jpg', '$2y$10$h2HVSDnE.3CO0y.qmPunKuqhC7cyymEjNcqjcLoZa/RoymYb4OWT6', '2025-2026', '2025-10-02 13:08:19', 'sdas@smcbi.edu.ph'),
(138, 'Rictherlaj', '', 'Velasco', '123593', '0000-00-00', 'BSIT', '4', 'Male', 'Bansalan', '9555092921', 'SDA', 'N/A', 'N/A', 'path/to/pic.jpg', '$2y$10$/wDzyyuTc6Fy5HdGd9xif.tObxIFqY.jTpdg1NcxCNsyFSOdF163y', '2025-2026', '2025-10-02 13:08:19', 'sdas@smcbi.edu.ph'),
(139, 'Denirose', 'M.', 'Bisanez', '123594', '0000-00-00', 'BSIT', '4', 'Female', 'Bansalan', '9484696286', 'Catholic', 'N/A', 'N/A', 'path/to/pic.jpg', '$2y$10$CP1JnVLLltsaeYSHT5/SPed0I.HJQTJf8i7UkR9lmW8D.bJQyQo4C', '2025-2026', '2025-10-02 13:08:19', 's_gmail'),
(140, 'Angelou', 'S.', 'Lanterna', '123595', '0000-00-00', 'BSIT', '4', 'Male', 'Bansalan', '9709748637', 'Bangkal Cristian Community Church', 'N/A', 'N/A', 'path/to/pic.jpg', '$2y$10$IoTO/teXz/NT6io3hW/ETePGvzfvDp33rlfU3sJ13d8abix.ZdsiW', '2025-2026', '2025-10-02 13:08:19', 'sdas@smcbi.edu.ph'),
(141, 'Ryan', 'V.', 'Roda', '123596', '0000-00-00', 'BSIT', '4', 'Male', 'Bansalan', '9539566677', 'Catholic', 'N/A', 'N/A', 'path/to/pic.jpg', '$2y$10$4IH9RPSJPlrATRkz2T6xk.w3isnvJaF1Jk9s0.43ZPY7IhpZ1xwf.', '2025-2026', '2025-10-02 13:08:19', 'sdas@smcbi.edu.ph'),
(142, 'Jayson', 'M.', 'Ogal', '123597', '0000-00-00', 'BSIT', '4', 'Male', 'Bansalan', '9517462236', 'Alliance', 'N/A', 'N/A', 'path/to/pic.jpg', '$2y$10$hZQesJ7.6RDAsYrxWm3pG.0kaZIeAODcKfu6F6ldzt9kf7D4yzEKq', '2025-2026', '2025-10-02 13:08:19', 's_gmail'),
(143, 'Roderick', 'S.', 'Liano', '123598', '0000-00-00', 'BSIT', '4', 'Male', 'Bansalan', '9308012333', 'Catholic', 'N/A', 'N/A', 'path/to/pic.jpg', '$2y$10$smDGrQ6gG1qa8Dd.A4zGs.lnXFJxENj0XP9JbKtjBpym9EgHfxRz2', '2025-2026', '2025-10-02 13:08:19', 'sdas@smcbi.edu.ph'),
(144, 'Alexis Dale', 'A.', 'Laborte', '123599', '0000-00-00', 'BSIT', '4', 'Male', 'Bansalan', '9633454391', 'Catholic', 'N/A', 'N/A', 'path/to/pic.jpg', '$2y$10$8lcbK54Q8qyTc.51DJMxRO32wrpzK18jsFKQ5R61450cpfLP1SqD6', '2025-2026', '2025-10-02 13:08:19', 'sdas@smcbi.edu.ph'),
(145, 'Joseph Kayron', 'G.', 'Bansilan', '123600', '0000-00-00', 'BSIT', '4', 'Male', 'Bansalan', '9772495411', 'Baptist', 'N/A', 'N/A', 'path/to/pic.jpg', '$2y$10$zPt0MmD0J1mS5B/CXCtbJu7jLE/c6tUK.nGXO/pQlo2UinjPq7sE.', '2025-2026', '2025-10-02 13:08:19', 's_gmail'),
(146, 'Lloyd', 'P.', 'Colipano', '123601', '0000-00-00', 'BSIT', '4', 'Male', 'Bansalan', '9455136767', 'Catholic', 'N/A', 'N/A', 'path/to/pic.jpg', '$2y$10$3zeQ9ppfCHqIByGbonTOZ.8cOYtvMAevNS7II0KEC7cHDKsjpXy1m', '2025-2026', '2025-10-02 13:08:19', 'sdas@smcbi.edu.ph'),
(147, 'Harvey', 'B.', 'Maranan', '123602', '0000-00-00', 'BSIT', '4', 'Male', 'Bansalan', '9385409602', 'AG', 'N/A', 'N/A', 'path/to/pic.jpg', '$2y$10$U4eKDjUtC8I3bb.fCb5EMO5FKpEqhQvCczNecT1dyDR89YoADCAai', '2025-2026', '2025-10-02 13:08:19', 'sdas@smcbi.edu.ph'),
(148, 'John Michael', 'B.', 'Siaboc', '123603', '0000-00-00', 'BSIT', '4', 'Male', 'Bansalan', '9762193416', 'Catholic', 'N/A', 'N/A', 'path/to/pic.jpg', '$2y$10$1a1rHSiLR3zL8iWbUTFEQeI9qNuEQ3O3AJ7wRfYAWBWjTLlHRe8xK', '2025-2026', '2025-10-02 13:08:19', 's_gmail'),
(149, 'Eiam Kurl', 'Nawa', 'Abalde', '123604', '0000-00-00', 'BSIT', '4', 'Male', 'Bansalan', '9066906099', 'Baptist', 'N/A', 'N/A', 'path/to/pic.jpg', '$2y$10$WuWBCg1oec0rt/4GHhhUBOKvWGVON0wo8N0dN1f8Q/IJI4Yn07Z/y', '2025-2026', '2025-10-02 13:08:19', 'sdas@smcbi.edu.ph'),
(150, 'Thotchie', 'M.', 'Tangga-an', '123605', '0000-00-00', 'BSIT', '4', 'Male', 'Bansalan', '9061738297', 'Catholic', 'N/A', 'N/A', 'path/to/pic.jpg', '$2y$10$.0cj6tk.FSVNgupNA/k/4eNRILtZAzde1k8uhgCzNBXvvAhX7j7xy', '2025-2026', '2025-10-02 13:08:19', 'sdas@smcbi.edu.ph'),
(151, 'Emmanuel', 'F.', 'Quibuen', '123606', '0000-00-00', 'BSIT', '4', 'Male', 'Bansalan', '9506878448', 'Catholic', 'N/A', 'N/A', 'path/to/pic.jpg', '$2y$10$o6DqXnSJI9P.dqu56/xCw.TSs80oCmTM.WuTy/cZ1hPK8ZDv2kYAy', '2025-2026', '2025-10-02 13:08:20', 's_gmail'),
(152, 'Karl Angelou', 'A.', 'Daya', '123607', '0000-00-00', 'BSIT', '4', 'Male', 'Bansalan', '9510951254', 'INC', 'N/A', 'N/A', 'path/to/pic.jpg', '$2y$10$XMcY.ZUQqjewCpSVAMGpGuNoMaX0dgN9w.Nh05iTPxPbCn6F2aOsy', '2025-2026', '2025-10-02 13:08:20', 'sdas@smcbi.edu.ph'),
(153, 'Lorenz Jay', 'M.', 'Molino', '123608', '0000-00-00', 'BSIT', '4', 'Male', 'Bansalan', '9635751101', 'CJCLHS', 'N/A', 'N/A', 'path/to/pic.jpg', '$2y$10$I5beWJmv4GwFdzLBjQD13e8OVBJkox9dxgr68SOlCil/e.l2xcF1u', '2025-2026', '2025-10-02 13:08:20', 'sdas@smcbi.edu.ph'),
(154, 'Jay', 'R.', 'Ayop', '123609', '0000-00-00', 'BSIT', '4', 'Male', 'Bansalan', '9706055063', 'Catholic', 'N/A', 'N/A', 'path/to/pic.jpg', '$2y$10$oUgHIeGEW484l9eq2CC5nuudE4QjuejaVfAf4ovSOPQ/nxsl./9nK', '2025-2026', '2025-10-02 13:08:20', 's_gmail'),
(155, 'Ramz Aaron', 'S.', 'Villasurda', '123610', '0000-00-00', 'BSIT', '4', 'Male', 'Bansalan', '9483132520', 'Catholic', 'N/A', 'N/A', 'path/to/pic.jpg', '$2y$10$1jbUjWpu1xjI5OKPbbcd4eoD1FW.epH/vQ9rXhkS2k/Cae2e8DK.a', '2025-2026', '2025-10-02 13:08:20', 's_gmail'),
(156, 'Axcel Ross', '', 'Ponferrada', '123611', '0000-00-00', 'BSIT', '4', 'Male', 'Bansalan', '9069296725', 'UCCP', 'N/A', 'N/A', 'path/to/pic.jpg', '$2y$10$3I0LsKq5aOugsbF8wKbf9uZEsqIgGJXijBkBDUmndVYCIsCDGjcXe', '2025-2026', '2025-10-02 13:08:20', 'sdas@smcbi.edu.ph'),
(157, 'Kieven Mar', 'A.', 'Arendain', '123612', '0000-00-00', 'BSIT', '4', 'Male', 'Bansalan', '9266254379', 'INC', 'N/A', 'N/A', 'path/to/pic.jpg', '$2y$10$AHt.cSIvuytBRjNL4diVbuzG1pnxr7fM3gVLFywhZ1eSiB26IS2nK', '2025-2026', '2025-10-02 13:08:20', 'sdas@smcbi.edu.ph'),
(158, 'Erna Fe', '', 'Tionas', '123613', '0000-00-00', 'BSIT', '4', 'Female', 'Bansalan', '9615827309', 'Catholic', 'N/A', 'N/A', 'path/to/pic.jpg', '$2y$10$8861by.8TWUTEazA8ueKA.htY96o5/VH2tURHNaKySDaMpoLpU1.6', '2025-2026', '2025-10-02 13:08:20', 's_gmail'),
(159, 'Ramsie', '', 'Larecion', '123614', '0000-00-00', 'BSIT', '4', 'Male', 'Bansalan', '9760176035', 'Mormons', 'N/A', 'N/A', 'path/to/pic.jpg', '$2y$10$k2ZI5vP7Ad4elM.r1Eykd.v8f7NdXI3x1a6TrRQZkmq1dxYgN0g/W', '2025-2026', '2025-10-02 13:08:20', 'sdas@smcbi.edu.ph'),
(160, 'Marck Jhon', 'A.', 'Clave', '123615', '0000-00-00', 'BSIT', '4', 'Male', 'Bansalan', '9079894468', 'Catholic', 'N/A', 'N/A', 'path/to/pic.jpg', '$2y$10$gv.6wUu/6EAqk7C6rmZAu.9.LRtOkIbwgEiux/c5UbfVz0HwnLLuO', '2025-2026', '2025-10-02 13:08:20', 'sdas@smcbi.edu.ph'),
(161, 'Ain James', 'T.', 'Samonte', '123616', '0000-00-00', 'BSIT', '4', 'Male', 'Bansalan', '9518834635', 'Catholic', 'N/A', 'N/A', 'path/to/pic.jpg', '$2y$10$xGoSoJLEV7RW8QPlbzMw8.0.X9Fm.wz9JyN3MHuxj/TzR3DYATExy', '2025-2026', '2025-10-02 13:08:20', 's_gmail'),
(162, 'Jairus Dela', '', 'Pena', '123617', '0000-00-00', 'BSIT', '4', 'Male', 'Bansalan', '9163959992', 'Born Again', 'N/A', 'N/A', 'path/to/pic.jpg', '$2y$10$8WlSpFReeXyqMhxdpEe4suibKPstqXxuzviMKoNW91FVmZxJqTeNG', '2025-2026', '2025-10-02 13:08:20', 'sdas@smcbi.edu.ph'),
(163, 'Arelle Anthony', 'P.', 'Respulo', '123618', '0000-00-00', 'BSIT', '4', 'Male', 'Bansalan', '9954444264', 'Catholic', 'N/A', 'N/A', 'path/to/pic.jpg', '$2y$10$lV5WX5mA7KTzix0D4LNpXe9KxbLPg3OF6N5WDCRlclanZWsOEpB/G', '2025-2026', '2025-10-02 13:08:20', 'sdas@smcbi.edu.ph'),
(164, 'Retchel Jr', 'P.', 'Cabaron', '123619', '0000-00-00', 'BSIT', '4', 'Male', 'Bansalan', '9456142017', 'Catholic', 'N/A', 'N/A', 'path/to/pic.jpg', '$2y$10$DP5hK9BWNFhDhmN4yVdDXe.CTK0ne.C1SVGzPoPeu2nuz0ed28HlG', '2025-2026', '2025-10-02 13:08:20', 's_gmail'),
(165, 'Manilyn', 'B.', 'Matanggo', '123620', '0000-00-00', 'BSIT', '4', 'Female', 'Bansalan', '9361507875', 'CAMACOP', 'N/A', 'N/A', 'path/to/pic.jpg', '$2y$10$2D3oZwGv20Iw4X6djMonoetNsZiKxzYWjITcCQXw7yyfULhSppVYe', '2025-2026', '2025-10-02 13:08:20', 'sdas@smcbi.edu.ph'),
(166, 'Mondejar', 'E.', 'Jesson Noel', '123621', '0000-00-00', 'BSIT', '4', 'Male', 'Bansalan', '9502376954', 'INC', 'N/A', 'N/A', 'path/to/pic.jpg', '$2y$10$siYe0OFtGZGEN4HUNo22SOdpq3uev7tIpETs6mIyTG.c7JV58cfPq', '2025-2026', '2025-10-02 13:08:20', 'sdas@smcbi.edu.ph'),
(167, 'Jessica', 'R.', 'Andelab', '123622', '0000-00-00', 'BSIT', '4', 'Female', 'Bansalan', '9559070538', 'Born Again', 'N/A', 'N/A', 'path/to/pic.jpg', '$2y$10$Kp.YfHSGE4nCA4SApTfTU.HDGqSBf05V0nO/7KCpiRKIDAkM3K1wW', '2025-2026', '2025-10-02 13:08:20', 's_gmail'),
(168, 'Jessa', 'R.', 'Andelab', '123623', '0000-00-00', 'BSIT', '4', 'Female', 'Bansalan', '9559070535', 'Born Again', 'N/A', 'N/A', 'path/to/pic.jpg', '$2y$10$5wKyDVb1w7thtuFzNO.a9.vtK7i/r.xqj6aeAr/2fHEB.XdXU7ptq', '2025-2026', '2025-10-02 13:08:20', 'sdas@smcbi.edu.ph'),
(169, 'Mardel Karl', 'S.', 'Sab', '123624', '0000-00-00', 'BSIT', '4', 'Male', 'Bansalan', 'N/A', 'Catholic', 'N/A', 'N/A', 'path/to/pic.jpg', '$2y$10$YrUDX3swBdAl7UtK8E/2/OR8UguWCE8f6x5Nhr7b16Ox6hlHQiuIW', '2025-2026', '2025-10-02 13:08:20', 'sdas@smcbi.edu.ph'),
(170, 'Shawn Andrei', 'A.', 'Del Socorro', '123625', '0000-00-00', 'BSIT', '4', 'Male', 'Bansalan', '9914345548', 'Catholic', 'N/A', 'N/A', 'path/to/pic.jpg', '$2y$10$hKmy2nxa4mn.mL5hXZ8e3O1D2P/VdnSdTXUy6t2mdWPYjGe3qbnde', '2025-2026', '2025-10-02 13:08:20', 's_gmail'),
(171, 'Vince Johnroie', 'C.', 'Rubia', '123626', '0000-00-00', 'BSIT', '4', 'Male', 'Bansalan', '9685885042', 'Catholic', 'N/A', 'N/A', 'path/to/pic.jpg', '$2y$10$jDsVtSRaN8cxUZ6J6j0Rx.xoDTMaL7oUArfY1imoIv5QQgMC0M6ZG', '2025-2026', '2025-10-02 13:08:21', 'sdas@smcbi.edu.ph'),
(172, 'Hadji Glenn', '', 'Malik', '123627', '0000-00-00', 'BSIT', '4', 'Male', 'Bansalan', '9098845995', 'CAMACOP', 'N/A', 'N/A', 'path/to/pic.jpg', '$2y$10$QQN/V4AFSmwsz/Qk9YzwdOPnHNFC4Gm4kQ85REgykm4VznpsvMAsK', '2025-2026', '2025-10-02 13:08:21', 'sdas@smcbi.edu.ph'),
(173, '', '', '', '0', '0000-00-00', '', NULL, '', '', '', '', '', '', '', '$2y$10$XoJI1jLgxasr/ZKqNdcC7uXKw24LfGNDOOc51Ugm5kDgpyJrTiMUm', '', '2025-10-02 13:08:21', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins_archive`
--
ALTER TABLE `admins_archive`
  ADD PRIMARY KEY (`a_ID`);

--
-- Indexes for table `appeals_archive`
--
ALTER TABLE `appeals_archive`
  ADD PRIMARY KEY (`appeal_ID`);

--
-- Indexes for table `guardian_archive`
--
ALTER TABLE `guardian_archive`
  ADD PRIMARY KEY (`g_ID`);

--
-- Indexes for table `history_staff`
--
ALTER TABLE `history_staff`
  ADD PRIMARY KEY (`log_ID`);

--
-- Indexes for table `issues_archive`
--
ALTER TABLE `issues_archive`
  ADD PRIMARY KEY (`i_ID`);

--
-- Indexes for table `staff_archive`
--
ALTER TABLE `staff_archive`
  ADD PRIMARY KEY (`s_ID`);

--
-- Indexes for table `st_archive`
--
ALTER TABLE `st_archive`
  ADD PRIMARY KEY (`s_ID`);

--
-- Indexes for table `t_admins`
--
ALTER TABLE `t_admins`
  ADD PRIMARY KEY (`a_ID`),
  ADD UNIQUE KEY `a_username` (`a_username`);

--
-- Indexes for table `t_appeals`
--
ALTER TABLE `t_appeals`
  ADD PRIMARY KEY (`appeal_ID`);

--
-- Indexes for table `t_guardians`
--
ALTER TABLE `t_guardians`
  ADD PRIMARY KEY (`g_ID`);

--
-- Indexes for table `t_issues`
--
ALTER TABLE `t_issues`
  ADD PRIMARY KEY (`i_ID`);

--
-- Indexes for table `t_logs`
--
ALTER TABLE `t_logs`
  ADD PRIMARY KEY (`i_ID`);

--
-- Indexes for table `t_students`
--
ALTER TABLE `t_students`
  ADD PRIMARY KEY (`s_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins_archive`
--
ALTER TABLE `admins_archive`
  MODIFY `a_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `appeals_archive`
--
ALTER TABLE `appeals_archive`
  MODIFY `appeal_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `guardian_archive`
--
ALTER TABLE `guardian_archive`
  MODIFY `g_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `history_staff`
--
ALTER TABLE `history_staff`
  MODIFY `log_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `issues_archive`
--
ALTER TABLE `issues_archive`
  MODIFY `i_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `staff_archive`
--
ALTER TABLE `staff_archive`
  MODIFY `s_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `st_archive`
--
ALTER TABLE `st_archive`
  MODIFY `s_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `t_admins`
--
ALTER TABLE `t_admins`
  MODIFY `a_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `t_appeals`
--
ALTER TABLE `t_appeals`
  MODIFY `appeal_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `t_guardians`
--
ALTER TABLE `t_guardians`
  MODIFY `g_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=174;

--
-- AUTO_INCREMENT for table `t_issues`
--
ALTER TABLE `t_issues`
  MODIFY `i_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `t_logs`
--
ALTER TABLE `t_logs`
  MODIFY `i_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `t_students`
--
ALTER TABLE `t_students`
  MODIFY `s_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=174;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
