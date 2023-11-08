-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 08, 2023 at 10:24 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `yourthought-socmed`
--

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id_thought` int NOT NULL,
  `id` int NOT NULL,
  `thought` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `media` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id_thought`, `id`, `thought`, `created_at`, `media`) VALUES
(1, 1, 'Dating with Kafka :)', '2023-11-05 16:36:37', 'post_media/Dating with Kafka.jpg'),
(2, 1, 'Hello, World!', '2023-11-05 17:02:08', ''),
(3, 1, 'Iam the one who cook!', '2023-11-05 17:04:13', ''),
(4, 2, 'Hello, Friend!', '2023-11-05 17:04:53', ''),
(5, 1, 'Them: You are not Ryan Gosling, Me asf:', '2023-11-05 17:43:09', 'post_media/My honest reaction.mp4'),
(6, 1, 'In the bleak midwinter', '2023-11-05 17:47:48', ''),
(7, 1, 'Porsche 😋', '2023-11-05 18:06:32', 'post_media/Porsche 911.jpg'),
(8, 1, 'Interlinked', '2023-11-05 18:52:43', ''),
(15, 1, '', '2023-11-05 19:23:52', 'post_media/BMW M8 Modified.jpg'),
(16, 1, '', '2023-11-05 20:17:35', 'post_media/BMW M4.jpg'),
(18, 1, '', '2023-11-06 15:29:34', 'post_media/Aston Martin Vantage.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `profile_picture` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `email`, `password`, `profile_picture`) VALUES
(1, 'Dzaki Al', 'dzakial@gmail.com', '$2y$10$sz299DT9GY5yCzlF3sQ1dOfqWvNRPkPgaGcK01prRVU0x2itb5msi', 'pfp/Dzaki Al.png'),
(2, 'Wriothesley', 'wriothesley@gmail.com', '$2y$10$E/4t5NITJn7bnwXOUGe3KOi41zD12I8OoBJ2AhMnW43LAjCyFNt/6', 'pfp/Wriothesley.jpg'),
(3, 'Neuvillette', 'neuvillette@gmail.com', '$2y$10$t3jNe4kNy7TyoqYXr2NVtuUmRxPnNhRcHK5Hf5DHMi2g99tbny6ue', 'pfp/Neuvillette.jpg'),
(4, 'Kafka', 'kafka@gmail.com', '$2y$10$W9MLWhl90IKM7q7ziCnxO.0KJ1IK1noJGsOG2K7BsjpnmVH3ciys2', 'pfp/Kafka.jpg'),
(5, 'Dan Heng', 'danheng@gmail.com', '$2y$10$zgEF3ZV5n69usznopgr6QetMKsurZmkRr4CaEz3YVLajQ./UiKFyG', 'pfp/Dan Heng.png'),
(6, 'March 7th', 'march7th@gmail.com', '$2y$10$Lgl/W2c3986Um03DgoHFpO7oJILjyNBLOJmvuX6kq.RnaadVBdS32', 'pfp/March 7th.jpg'),
(7, 'Welt Yang', 'weltyang@gmail.com', '$2y$10$Nf5IBw9YxBSRwMOXDn.9H.BN2LVF3CrD6c.JCKX7B6MOmaeRKmOiO', 'pfp/Welt Yang.jpg'),
(8, 'Himeko', 'himeko@gmail.com', '$2y$10$f41qs0ApKHyILFlI13nzz.R8AeAoerEKd8QWga.gKvhSSe3G6hZXG', 'pfp/Himeko.jpg'),
(9, 'Herta', 'herta@gmail.com', '$2y$10$nw/AyxK7KvvQSdPKXm9sPOdXG8lChpwfif37UZXyVb410coWLYekG', 'pfp/Herta.jpg'),
(10, 'Gepard Landau', 'gepardlandau@gmail.com', '$2y$10$sWaX5E90Dp1OjgulBsAnYOegYgGs4VhK6mvoK7II3W22bBuOeW7L6', 'pfp/Gepard Landau.jpg'),
(11, 'Blade', 'blade@gmail.com', '$2y$10$H47oXoqpv/SN0TBbJysBVuc45.vpUFL9iGh1csAdDrugBOWIEIGHq', 'pfp/Blade.jpg'),
(12, 'Caelus', 'caelus@gmail.com', '$2y$10$qt25Vwqe7mJpHKzA6f2Oy..DB3aH25tgBicsgIu9xZapbs9TbiDKq', 'pfp/Caelus.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id_thought`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id_thought` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
