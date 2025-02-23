-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 24, 2025 at 08:58 AM
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
-- Database: `users`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin1`
--

CREATE TABLE `admin1` (
  `id` int(11) NOT NULL,
  `user` varchar(30) NOT NULL,
  `email` varchar(225) NOT NULL,
  `password` varchar(100) NOT NULL,
  `role` varchar(500) NOT NULL,
  `contact_number` varchar(15) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin1`
--

INSERT INTO `admin1` (`id`, `user`, `email`, `password`, `role`, `contact_number`, `photo`) VALUES
(19, 'admin', 'admin@gmail.com', '$2y$10$2WBgnJVTHJl65KluHHilK.kqBA1CU5ZxD/Iz0Cd2pv5F775RP1VXS', 'Admin', '1234567890', NULL),
(22, 'Shou', 'shou@gmail.com', '$2y$10$HvMkC30nn1NHcszICMy1Ie3IBYnFEsZZcBRgN/aSOKaBkNPs7/Fe2', 'IT', '12345678', NULL),
(23, 'abellar', 'abellar@gmail.com', '$2y$10$jkTVxZ96NA.mliwoiWiZFuXpzYsiMrWE4FrH0cuWtJH31RKJ89xQW', 'IT', '09158541583', NULL),
(24, 'Clemente', 'clemente@gmail.com', '$2y$10$J95aBAUPxJkmgcoqQIEfzu.ao/FIC.ItabKal10bAZmb5EM90SG2O', 'IT', '09158541583', NULL),
(26, 'Sto. Tomas', 'tomas@gmail.com', '$2y$10$S22AkHb2qrxIriafQBlISuMMGPGfVHlRYHe2aRbO//NVzJQ76XNdW', 'IT', '09158541583', NULL),
(27, 'Cuescano', 'cuescano@gmail.com', '$2y$10$LhINlaPq3U5r6aWA1IiLaePCOUTJnFrgUMp6sWxxYneI9uzaPbu02', 'IT', '09158541583', NULL),
(28, 'Lledo', 'lledo@gmail.com', '$2y$10$ee3EewK/gYsNVickbbYBIOz7GEcEpReXs78D71EdatCahl9.H/lR2', 'IT', '09158541583', NULL),
(29, 'Egipto', 'egipto@gmail.com', '$2y$10$lvXs3LmetzgvaBsRjge3/O60An1lLGEpajt/QACnI5Ot/R1nHGMt6', 'IT', '09158541583', NULL),
(30, 'Rotaquio', 'rotaquio@gmail.com', '$2y$10$gJQmBKRjjSTmOmQuk6Dmb.KyuyJjXxeFhLECiySlICTYQrhJzwS2a', 'IT', '09158541583', NULL),
(31, 'Palomar', 'palomar@gmail.com', '$2y$10$ufXZScMgyXS34CcEzhhZde4h09iA8WEP1GAF0oUxVw6Ny17G.nDPm', 'IT', '09158541583', NULL),
(32, 'Velasquez', 'velasquez@gmail.com', '$2y$10$8RBHEAMyGdBoUCkDRzBZnuRVZYsAPD3nkeJQePATSUVrJWaWS5bIO', 'Tourism', '09158541583', NULL),
(33, 'Balboa', 'balboa@gmail.com', '$2y$10$zs2N04kQPqJz3pp8fIe63uIpCFCQyGIan.iLDtEG8xSVsF4x/.8HG', 'IT', '09158541583', NULL),
(34, 'Banguilan', 'banguilan@gmail.com', '$2y$10$36qTuqgyiK5xkJbF4UrYSOXLDvrEBTvimU3XuixzvAAm3pjOK1NGa', 'IT', '09158541583', NULL),
(35, 'Sorca', 'sorca@gmail.com', '$2y$10$7iBpZtjfi6Ss5W6gL0RwjuEUPR.jE0SAxiXERFRY/TdaUgM5OOsx2', 'IT', '09158541583', NULL),
(36, 'Sarraga', 'sarraga@gmail.com', '$2y$10$0YffhNasrShAryVQ7G5y3ujC2sRMkNxis.WJKR.ETG20Ysi6uOqgy', 'IT', '09158541583', NULL),
(37, 'Durian', 'durian@gmail.com', '$2y$10$4/.5NZPqoyEL0yHueiufNOIMLeztAMMUC.ejkFJNIUASDMr/pTDiC', 'CCTECH', '09158541583', NULL),
(38, 'Orbito', 'orbito@gmail.com', '$2y$10$po18ck/ylDwbN0AehXFwxOwerKrpwgi3TiTkrECzzArBzfu1C9LmS', 'CCTECH', '09158541583', NULL),
(40, 'Lars', 'lars@gmail.com', '', 'STEM', '1234567890', NULL),
(41, 'panget', 'panget@gmail.com', '$2y$10$uR2Fm19dafG3MG8ABdJvye35hexNISdtb33TcUR/E93n.uwW.9PiO', '', '09158541583', 'uploads/profile_41_1740298717.jpg'),
(42, 'supot', 'supot@gmail.com', '$2y$10$bouOmPJr4gCvY605oL063ey3z/O/uPCzk8soZ0o/vcr81OeROxOWq', '', '09158541583', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `uploads`
--

CREATE TABLE `uploads` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `location` enum('In','Out','Overtime','Undertime') NOT NULL,
  `uploaded_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `note` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `uploads`
--

INSERT INTO `uploads` (`id`, `user_id`, `image_path`, `location`, `uploaded_at`, `note`) VALUES
(117, 41, 'uploads/photo_67bbccb6e6f00.jpg', 'In', '2025-02-24 01:34:46', ''),
(118, 41, 'uploads/photo_67bbccc4d6ae7.jpg', 'Out', '2025-02-24 01:35:00', 'asdasfdsdf');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin1`
--
ALTER TABLE `admin1`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `uploads`
--
ALTER TABLE `uploads`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin1`
--
ALTER TABLE `admin1`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `uploads`
--
ALTER TABLE `uploads`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=119;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
