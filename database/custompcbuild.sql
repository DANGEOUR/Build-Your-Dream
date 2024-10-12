-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 03, 2024 at 07:21 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `custompcbuild`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `email`, `password`) VALUES
(1, 'Huzaifa Ali', 'huzaifadx780@gmail.com', '123456');

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

CREATE TABLE `contact` (
  `id` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `phone` varchar(250) NOT NULL,
  `email` varchar(250) NOT NULL,
  `message` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact`
--

INSERT INTO `contact` (`id`, `name`, `phone`, `email`, `message`) VALUES
(1, 'Huzaifa Ali', '03321335442', 'huzaifadx780@gmail.com', '5646546'),
(2, 'Huzaifa ali', '03321335442', 'huzziali612@gmail.com', 'hi'),
(3, 'Huzaifa Ali', '03321335442', 'huzaifadx780@gmail.com', 'fdf');

-- --------------------------------------------------------

--
-- Table structure for table `cooler`
--

CREATE TABLE `cooler` (
  `cooler_id` int(11) NOT NULL,
  `cooler_name` varchar(255) NOT NULL,
  `manufacture` varchar(255) NOT NULL,
  `fanrpm` varchar(255) NOT NULL,
  `noiselvl` varchar(255) NOT NULL,
  `color` varchar(255) NOT NULL,
  `radiatorsize` varchar(255) NOT NULL,
  `cooler_price` int(11) NOT NULL,
  `img` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cooler`
--

INSERT INTO `cooler` (`cooler_id`, `cooler_name`, `manufacture`, `fanrpm`, `noiselvl`, `color`, `radiatorsize`, `cooler_price`, `img`) VALUES
(5, 'NZXT Kraken Elite 360 RGB', 'NZXT', '500 - 1800 ', '17.9 - 30.6', 'White', '360', 220, 'cooler.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `cpu`
--

CREATE TABLE `cpu` (
  `c_id` int(11) NOT NULL,
  `c_name` varchar(255) NOT NULL,
  `manufacture` varchar(255) NOT NULL,
  `core_count` int(11) NOT NULL,
  `threads` int(11) NOT NULL,
  `core_clock` varchar(255) NOT NULL,
  `core_boost_clock` varchar(255) NOT NULL,
  `TDP` int(11) NOT NULL,
  `int_gpu` varchar(255) NOT NULL,
  `socket` varchar(255) NOT NULL,
  `c_price` int(11) NOT NULL,
  `cpu_img` varchar(500) NOT NULL,
  `type` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cpu`
--

INSERT INTO `cpu` (`c_id`, `c_name`, `manufacture`, `core_count`, `threads`, `core_clock`, `core_boost_clock`, `TDP`, `int_gpu`, `socket`, `c_price`, `cpu_img`, `type`) VALUES
(4, 'Intel Core i5-12400F', 'INTEL', 6, 12, '2.5 GHz', '4.4 GHz', 65, 'None', 'LGA 1700', 110, 'i5.jpg', 'cpu'),
(5, 'AMD Ryzen 7 7800X3D', 'AMD', 8, 16, '4.2 GHz', '5 GHz', 120, 'Radeon', 'AM5', 383, 'cpu.jpg', 'cpu'),
(7, 'AMD Ryzen 5 7600X', 'AMD', 6, 12, '3.7 GHz', '4.6 GHz', 65, 'None', 'AM4', 128, 'cpu2.jpg', 'cpu'),
(8, 'Intel Core i9-14900K', 'INTEL', 8, 24, '3.2 GHz', '6 GHz', 125, 'Intel UHD Graphics 770', 'LGA 1700', 547, 'i9.jpg', 'cpu'),
(9, 'AMD Ryzen 7 7700X', 'AMD', 8, 16, '4.5 GHz', '5.4 GHz', 105, 'Radeon', 'AM5', 289, 'amd7.jpg', 'cpu');

-- --------------------------------------------------------

--
-- Table structure for table `customorder`
--

CREATE TABLE `customorder` (
  `id` int(11) NOT NULL,
  `order_number` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `cpu_id` int(11) NOT NULL,
  `cooler_id` int(11) NOT NULL,
  `mb_id` int(11) NOT NULL,
  `ram_id` int(11) NOT NULL,
  `s_id` int(11) NOT NULL,
  `gpu_id` int(11) NOT NULL,
  `case_id` int(11) NOT NULL,
  `psu_id` int(11) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gpu`
--

CREATE TABLE `gpu` (
  `g_id` int(11) NOT NULL,
  `g_name` varchar(255) NOT NULL,
  `manufacture` varchar(255) NOT NULL,
  `chipset` varchar(255) NOT NULL,
  `memory` int(11) NOT NULL,
  `core_clock` int(11) NOT NULL,
  `boost_clock` int(11) NOT NULL,
  `lenght` int(11) NOT NULL,
  `g_price` int(11) NOT NULL,
  `g_img` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `gpu`
--

INSERT INTO `gpu` (`g_id`, `g_name`, `manufacture`, `chipset`, `memory`, `core_clock`, `boost_clock`, `lenght`, `g_price`, `g_img`, `type`) VALUES
(1, 'MSI GeForce RTX 3060 Ventus 2X 12G', 'NVIDIA', 'GeForce RTX 3060 12GB', 12, 1320, 1777, 0, 285, 'gpu1.jpg\r\n', 'gpu'),
(2, 'Gigabyte WINDFORCE OC', 'NVIDIA', 'GeForce RTX 4070', 12, 1920, 2490, 261, 549, 'msi.jpg', 'gpu'),
(3, 'Gigabyte GAMING OC', 'AMD', 'RADEON RX 7800 XT', 16, 1295, 2565, 302, 499, 'amd.jpg', 'gpu'),
(4, 'ASRock Challenger D', 'AMD', 'Radeon RX 6600', 8, 1626, 1626, 269, 190, 'rx.jpg', 'gpu');

-- --------------------------------------------------------

--
-- Table structure for table `memory`
--

CREATE TABLE `memory` (
  `m_id` int(11) NOT NULL,
  `ram_name` varchar(255) NOT NULL,
  `manufacture` varchar(255) NOT NULL,
  `speed` varchar(255) NOT NULL,
  `modules` varchar(255) NOT NULL,
  `color` varchar(255) NOT NULL,
  `firstwordlatency` varchar(255) NOT NULL,
  `CASlatency` varchar(255) NOT NULL,
  `ram_price` int(11) NOT NULL,
  `img` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `memory`
--

INSERT INTO `memory` (`m_id`, `ram_name`, `manufacture`, `speed`, `modules`, `color`, `firstwordlatency`, `CASlatency`, `ram_price`, `img`) VALUES
(1, 'Corsair Vengeance 32 GB', 'CORSAIR', 'DDR5-6000', '2 x 16GB', 'Black/Grey', '10', '30', 110, 'ram.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `motherboard`
--

CREATE TABLE `motherboard` (
  `mb_id` int(11) NOT NULL,
  `mb_name` varchar(255) NOT NULL,
  `mb_manufacture` varchar(255) NOT NULL,
  `socket` varchar(255) NOT NULL,
  `Form Factor` varchar(255) NOT NULL,
  `maxram` int(11) NOT NULL,
  `slots` int(11) NOT NULL,
  `color` varchar(255) NOT NULL,
  `mb_price` int(11) NOT NULL,
  `img` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `motherboard`
--

INSERT INTO `motherboard` (`mb_id`, `mb_name`, `mb_manufacture`, `socket`, `Form Factor`, `maxram`, `slots`, `color`, `mb_price`, `img`) VALUES
(2, 'Asus ROG STRIX B650-A GAMING WIFI', 'ASUS', 'AM5', 'ATX', 192, 4, 'Black/Silver', 208, 'mb1.jpg'),
(3, 'MSI B760 GAMING PLUS WIFI', 'MSI', 'LGA 1700', 'ATX', 192, 4, 'Black/Silver', 90, 'lga.jpg'),
(4, 'MSI PRO Z790-A MAX WIFI', 'MSI', 'LGA 1700', 'ATX', 192, 4, 'Black/Silver', 240, 'lg2.jpg'),
(5, 'MSI B650 GAMING PLUS WIFI', 'MSI', 'AM5', 'ATX', 192, 4, 'Black', 650, 'board.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `pccase`
--

CREATE TABLE `pccase` (
  `case_id` int(11) NOT NULL,
  `case_name` varchar(255) NOT NULL,
  `manufacture` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `color` varchar(255) NOT NULL,
  `sidepanel` varchar(255) NOT NULL,
  `externalvolume` varchar(255) NOT NULL,
  `case_price` int(11) NOT NULL,
  `img` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pccase`
--

INSERT INTO `pccase` (`case_id`, `case_name`, `manufacture`, `type`, `color`, `sidepanel`, `externalvolume`, `case_price`, `img`) VALUES
(1, 'Corsair 4000D Airflow', 'CORSAIR', 'ATX Mid Tower', 'Black', 'Tinted Tempered Glass', '48.6 L', 105, 'case.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `prebuildorder`
--

CREATE TABLE `prebuildorder` (
  `id` int(11) NOT NULL,
  `order_number` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `pre_build_id` int(11) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pre_build`
--

CREATE TABLE `pre_build` (
  `pre_id` int(11) NOT NULL,
  `build_name` varchar(255) NOT NULL,
  `short_desc` text NOT NULL,
  `CPU` varchar(255) NOT NULL,
  `cpu_price` int(11) NOT NULL,
  `cpu_img` varchar(255) NOT NULL,
  `CpuCooler` varchar(255) NOT NULL,
  `cooler_price` int(11) NOT NULL,
  `cooler_img` varchar(255) NOT NULL,
  `MotherBoard` varchar(255) NOT NULL,
  `mb_price` int(11) NOT NULL,
  `mb_img` varchar(255) NOT NULL,
  `Memory` varchar(255) NOT NULL,
  `ram_price` int(11) NOT NULL,
  `ram_img` varchar(255) NOT NULL,
  `storage` varchar(255) NOT NULL,
  `storage_price` int(11) NOT NULL,
  `storage_img` varchar(255) NOT NULL,
  `GPU` varchar(255) NOT NULL,
  `gpu_price` int(11) NOT NULL,
  `gpu_img` varchar(255) NOT NULL,
  `pc_case` varchar(255) NOT NULL,
  `case_price` int(11) NOT NULL,
  `case_img` varchar(255) NOT NULL,
  `PSU` varchar(255) NOT NULL,
  `psu_price` int(11) NOT NULL,
  `psu_img` varchar(255) NOT NULL,
  `price` int(11) NOT NULL,
  `final_img` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pre_build`
--

INSERT INTO `pre_build` (`pre_id`, `build_name`, `short_desc`, `CPU`, `cpu_price`, `cpu_img`, `CpuCooler`, `cooler_price`, `cooler_img`, `MotherBoard`, `mb_price`, `mb_img`, `Memory`, `ram_price`, `ram_img`, `storage`, `storage_price`, `storage_img`, `GPU`, `gpu_price`, `gpu_img`, `pc_case`, `case_price`, `case_img`, `PSU`, `psu_price`, `psu_img`, `price`, `final_img`) VALUES
(5, 'The Zenith', 'A performance powerhouse designed for demanding tasks like gaming, video editing, and 3D rendering. High-end components ensure smooth gameplay and efficient multitasking.', 'Intel Core i9-13900K', 550, 'i91.jpg', 'Noctua NH-D15', 150, 'cooler1.jfif', 'ASUS ROG Maximus Z790 Hero', 500, 'mb1.jfif', 'Corsair Vengeance DDR5-6000 CL32 32GB (2x16GB)', 250, 'ram1.jfif', ' Samsung 990 Pro 2TB SSD', 250, 'ssd1.jfif', 'NVIDIA GeForce RTX 4090', 1500, 'gpu1.jfif', 'Lian Li O11 Dynamic XL', 250, 'case1.jpg', 'Corsair RM1000x PSU', 200, 'psu1.jfif', 3650, 'Gemini_Generated_Image_pbq2gxpbq2gxpbq2.jfif'),
(6, 'Sub-Thousand Titan', ' A balanced gaming PC capable of handling modern titles at high settings. Offers a strong foundation for future upgrades.', 'AMD Ryzen 5 7600X', 220, 'amd2.jpeg', 'Cooler Master Hyper 212 Black Edition', 30, 'col2.jpeg', 'MSI B550M-A Pro', 100, 'mbsub.jpeg', 'Crucial Ballistix 16GB (2x8GB) DDR4-3200 CL16', 70, 'ramsub.jpeg', 'Kingston Fury Renegade 500GB NVMe SSD', 60, 'ssub.jpeg', 'NVIDIA GeForce RTX 3060 Ti', 399, '3060.jpg', 'Fractal Design Meshify 2 Compact', 90, 'casesub.jpeg', 'Corsair VS650 650W', 60, 'psusub.jpeg', 1029, 'final sub.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `psu`
--

CREATE TABLE `psu` (
  `psu_id` int(11) NOT NULL,
  `psu_name` varchar(255) NOT NULL,
  `manufacture` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `efficiencyrating` varchar(255) NOT NULL,
  `wattage` int(11) NOT NULL,
  `modular` varchar(255) NOT NULL,
  `color` varchar(255) NOT NULL,
  `psu_price` int(11) NOT NULL,
  `img` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `psu`
--

INSERT INTO `psu` (`psu_id`, `psu_name`, `manufacture`, `type`, `efficiencyrating`, `wattage`, `modular`, `color`, `psu_price`, `img`) VALUES
(1, 'Corsair RM750e (2023)', 'CORSAIR', 'ATX', '80+ Gold', 750, 'Full', 'Black', 95, 'psu1.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `select_cpu`
--

CREATE TABLE `select_cpu` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `select_cpu`
--

INSERT INTO `select_cpu` (`id`, `name`) VALUES
(1, 'Intel'),
(2, 'AMD');

-- --------------------------------------------------------

--
-- Table structure for table `select_gpu`
--

CREATE TABLE `select_gpu` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `select_gpu`
--

INSERT INTO `select_gpu` (`id`, `name`) VALUES
(1, 'Nvidia'),
(2, 'AMD');

-- --------------------------------------------------------

--
-- Table structure for table `sign_up`
--

CREATE TABLE `sign_up` (
  `id` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `phone` varchar(256) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sign_up`
--

INSERT INTO `sign_up` (`id`, `Name`, `email`, `address`, `phone`, `password`) VALUES
(1, 'Huzaifa Ali', 'huzaifadx780@gmail.com', 'Nazimabad block 5c house no. 5/28', '03321335442', '$2y$10$DhNyEb/5AQKSgTKCoXgNb.1aDvA/zmnVnqovzbz8ZDyq/95XaZH16'),
(2, 'Huzaifa Ali', 'huzziali216@gmail.com', 'N.Nazimabad block 5d house no. 5/28(huzaifa treece) near abbasi shahid hospital', '03321335442', '$2y$10$cgqI83E6kqBF5T.MmkCJ5OekWy3lN6BVJ2fGQ5LG0ZW86qdSybalK');

-- --------------------------------------------------------

--
-- Table structure for table `storage`
--

CREATE TABLE `storage` (
  `s_id` int(11) NOT NULL,
  `s_name` varchar(255) NOT NULL,
  `manufacture` varchar(255) NOT NULL,
  `capacity` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `cache` varchar(255) NOT NULL,
  `formfactor` varchar(255) NOT NULL,
  `interface` varchar(255) NOT NULL,
  `s_price` int(11) NOT NULL,
  `img` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `storage`
--

INSERT INTO `storage` (`s_id`, `s_name`, `manufacture`, `capacity`, `type`, `cache`, `formfactor`, `interface`, `s_price`, `img`) VALUES
(1, 'Samsung 980 Pro', 'SAMSUNG', '2 TB', 'SSD', '2048 MB', 'M.2-2280', 'M.2 PCIe 4.0 X4', 169, 'ssd.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cooler`
--
ALTER TABLE `cooler`
  ADD PRIMARY KEY (`cooler_id`);

--
-- Indexes for table `cpu`
--
ALTER TABLE `cpu`
  ADD PRIMARY KEY (`c_id`);

--
-- Indexes for table `customorder`
--
ALTER TABLE `customorder`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gpu`
--
ALTER TABLE `gpu`
  ADD PRIMARY KEY (`g_id`);

--
-- Indexes for table `memory`
--
ALTER TABLE `memory`
  ADD PRIMARY KEY (`m_id`);

--
-- Indexes for table `motherboard`
--
ALTER TABLE `motherboard`
  ADD PRIMARY KEY (`mb_id`);

--
-- Indexes for table `pccase`
--
ALTER TABLE `pccase`
  ADD PRIMARY KEY (`case_id`);

--
-- Indexes for table `prebuildorder`
--
ALTER TABLE `prebuildorder`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pre_build`
--
ALTER TABLE `pre_build`
  ADD PRIMARY KEY (`pre_id`);

--
-- Indexes for table `psu`
--
ALTER TABLE `psu`
  ADD PRIMARY KEY (`psu_id`);

--
-- Indexes for table `select_cpu`
--
ALTER TABLE `select_cpu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `select_gpu`
--
ALTER TABLE `select_gpu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sign_up`
--
ALTER TABLE `sign_up`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `storage`
--
ALTER TABLE `storage`
  ADD PRIMARY KEY (`s_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `contact`
--
ALTER TABLE `contact`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `cooler`
--
ALTER TABLE `cooler`
  MODIFY `cooler_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `cpu`
--
ALTER TABLE `cpu`
  MODIFY `c_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `customorder`
--
ALTER TABLE `customorder`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `gpu`
--
ALTER TABLE `gpu`
  MODIFY `g_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `memory`
--
ALTER TABLE `memory`
  MODIFY `m_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `motherboard`
--
ALTER TABLE `motherboard`
  MODIFY `mb_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `pccase`
--
ALTER TABLE `pccase`
  MODIFY `case_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `prebuildorder`
--
ALTER TABLE `prebuildorder`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `pre_build`
--
ALTER TABLE `pre_build`
  MODIFY `pre_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `psu`
--
ALTER TABLE `psu`
  MODIFY `psu_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `select_cpu`
--
ALTER TABLE `select_cpu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `select_gpu`
--
ALTER TABLE `select_gpu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `sign_up`
--
ALTER TABLE `sign_up`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `storage`
--
ALTER TABLE `storage`
  MODIFY `s_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
