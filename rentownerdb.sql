-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 20, 2025 at 05:49 PM
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
-- Database: `rentownerdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `name`) VALUES
(1, 'Electronics'),
(2, 'Clothing'),
(3, 'Furniture'),
(4, 'Books'),
(5, 'Groceries');

-- --------------------------------------------------------

--
-- Table structure for table `lead`
--

CREATE TABLE `lead` (
  `Id` int(11) NOT NULL,
  `LeadName` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lead`
--

INSERT INTO `lead` (`Id`, `LeadName`) VALUES
(1, 'Lead A'),
(2, 'Lead B'),
(3, 'Lead C'),
(9, 'health');

-- --------------------------------------------------------

--
-- Table structure for table `priority`
--

CREATE TABLE `priority` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `priority`
--

INSERT INTO `priority` (`id`, `name`) VALUES
(1, 'Low'),
(2, 'Medium'),
(3, 'High'),
(4, 'Urgent');

-- --------------------------------------------------------

--
-- Table structure for table `project`
--

CREATE TABLE `project` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `project`
--

INSERT INTO `project` (`id`, `name`) VALUES
(1, 'Project Alpha'),
(2, 'Project Beta'),
(3, 'Project Gamma'),
(4, 'Project Delta');

-- --------------------------------------------------------

--
-- Table structure for table `proptype`
--

CREATE TABLE `proptype` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `proptype`
--

INSERT INTO `proptype` (`id`, `name`) VALUES
(1, 'Residential'),
(2, 'Commercial'),
(3, 'Industrial'),
(4, 'Agricultural'),
(5, 'Mixed-Use');

-- --------------------------------------------------------

--
-- Table structure for table `rent_owners`
--

CREATE TABLE `rent_owners` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `cast` varchar(255) DEFAULT NULL,
  `cell` varchar(20) NOT NULL,
  `cnic` varchar(20) NOT NULL,
  `lead` varchar(255) DEFAULT NULL,
  `category` varchar(255) DEFAULT NULL,
  `prop_type` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `priority` varchar(255) DEFAULT NULL,
  `overseas` tinyint(1) DEFAULT 0,
  `investor` tinyint(1) DEFAULT 0,
  `builder` tinyint(1) DEFAULT 0,
  `owner_photo` varchar(255) DEFAULT NULL,
  `bedrooms` int(11) DEFAULT 0,
  `bathrooms` int(11) DEFAULT 0,
  `floor` varchar(50) DEFAULT NULL,
  `block` varchar(50) DEFAULT NULL,
  `square_feet` varchar(50) DEFAULT NULL,
  `drawing` tinyint(1) DEFAULT 0,
  `roof` tinyint(1) DEFAULT 0,
  `separate_gate` tinyint(1) DEFAULT 0,
  `dining` tinyint(1) DEFAULT 0,
  `store` tinyint(1) DEFAULT 0,
  `basement` tinyint(1) DEFAULT 0,
  `common` tinyint(1) DEFAULT 0,
  `mezzanine` tinyint(1) DEFAULT 0,
  `west_open` tinyint(1) DEFAULT 0,
  `back` tinyint(1) DEFAULT 0,
  `gas` tinyint(1) DEFAULT 0,
  `corner` tinyint(1) DEFAULT 0,
  `front` tinyint(1) DEFAULT 0,
  `water` tinyint(1) DEFAULT 0,
  `possession` varchar(255) DEFAULT NULL,
  `possession_in_words` varchar(255) DEFAULT NULL,
  `document_charges` decimal(10,2) DEFAULT 0.00,
  `flat_maintenance` decimal(10,2) DEFAULT 0.00,
  `deposit` decimal(10,2) DEFAULT 0.00,
  `rent` decimal(10,2) DEFAULT 0.00,
  `project_entry_fee` decimal(10,2) DEFAULT 0.00,
  `office_charges` decimal(10,2) DEFAULT 0.00,
  `key_available` tinyint(1) DEFAULT 0,
  `project` varchar(255) DEFAULT NULL,
  `plot_no` varchar(50) DEFAULT NULL,
  `project_features` text DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `area` varchar(50) DEFAULT NULL,
  `project_bank_loan` tinyint(1) DEFAULT 0,
  `project_completion_certificate` tinyint(1) DEFAULT 0,
  `builder_name` varchar(255) DEFAULT NULL,
  `project_photo` varchar(255) DEFAULT NULL,
  `tenant_name` varchar(255) DEFAULT NULL,
  `tenant_cnic` varchar(20) DEFAULT NULL,
  `tenant_cell` varchar(20) DEFAULT NULL,
  `tenant_note` text DEFAULT NULL,
  `reference_name` varchar(255) DEFAULT NULL,
  `reference_cnic` varchar(20) DEFAULT NULL,
  `reference_cell` varchar(20) DEFAULT NULL,
  `reference_remarks` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rent_owners`
--

INSERT INTO `rent_owners` (`id`, `name`, `cast`, `cell`, `cnic`, `lead`, `category`, `prop_type`, `status`, `priority`, `overseas`, `investor`, `builder`, `owner_photo`, `bedrooms`, `bathrooms`, `floor`, `block`, `square_feet`, `drawing`, `roof`, `separate_gate`, `dining`, `store`, `basement`, `common`, `mezzanine`, `west_open`, `back`, `gas`, `corner`, `front`, `water`, `possession`, `possession_in_words`, `document_charges`, `flat_maintenance`, `deposit`, `rent`, `project_entry_fee`, `office_charges`, `key_available`, `project`, `plot_no`, `project_features`, `location`, `area`, `project_bank_loan`, `project_completion_certificate`, `builder_name`, `project_photo`, `tenant_name`, `tenant_cnic`, `tenant_cell`, `tenant_note`, `reference_name`, `reference_cnic`, `reference_cell`, `reference_remarks`, `created_at`) VALUES
(4, 'Unknown', NULL, '1221', '312312', '', '', NULL, NULL, NULL, 0, 0, 0, NULL, 0, 0, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-02-20 14:38:45'),
(6, 'Unknown', NULL, '13123', '2323', '', '', NULL, NULL, NULL, 0, 0, 0, NULL, 0, 0, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-02-20 14:39:48');

-- --------------------------------------------------------

--
-- Table structure for table `status`
--

CREATE TABLE `status` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `status`
--

INSERT INTO `status` (`id`, `name`) VALUES
(1, 'Active'),
(3, 'Pending'),
(4, 'Completed'),
(5, 'Cancelled');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lead`
--
ALTER TABLE `lead`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `priority`
--
ALTER TABLE `priority`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `project`
--
ALTER TABLE `project`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `proptype`
--
ALTER TABLE `proptype`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rent_owners`
--
ALTER TABLE `rent_owners`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cnic` (`cnic`);

--
-- Indexes for table `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `lead`
--
ALTER TABLE `lead`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `priority`
--
ALTER TABLE `priority`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `project`
--
ALTER TABLE `project`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `rent_owners`
--
ALTER TABLE `rent_owners`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `status`
--
ALTER TABLE `status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
