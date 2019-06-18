-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Gazdă: 127.0.0.1
-- Timp de generare: iun. 16, 2019 la 05:32 PM
-- Versiune server: 10.1.38-MariaDB
-- Versiune PHP: 7.3.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Bază de date: `onlinecontacts`
--

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `contacts`
--

CREATE TABLE `contacts` (
  `IDContact` int(11) NOT NULL,
  `Nume` varchar(25) DEFAULT NULL,
  `Prenume` varchar(30) DEFAULT NULL,
  `Address` varchar(30) DEFAULT NULL,
  `Birthday` date DEFAULT NULL,
  `Phone` varchar(10) DEFAULT NULL,
  `Email` varchar(40) DEFAULT NULL,
  `Description` text,
  `WebAddress` varchar(30) DEFAULT NULL,
  `UserGroup` varchar(10) DEFAULT 'Default',
  `Pic` longblob,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Eliminarea datelor din tabel `contacts`
--

INSERT INTO `contacts` (`IDContact`, `Nume`, `Prenume`, `Address`, `Birthday`, `Phone`, `Email`, `Description`, `WebAddress`, `UserGroup`, `Pic`, `id`) VALUES
(2, 'george', 'dsadas', '', '0000-00-00', '2313', '', 'castor pisica', '', '', NULL, 1),
(2, 'george', 'haifmm', '', '0000-00-00', 'dassad', '', 'pava pisica', '', '', NULL, 2),
(2, 'dsadsadasdsa', 'sadasdas', 'dsa', '0000-00-00', 'dsadasdas', '', '', '', '', NULL, 3),
(2, 'dasdsa', 'dasda', '', '0000-00-00', '213', '', '', '', 'prosti', NULL, 4),
(2, 'test1', 'test1', '', '0000-00-00', '0732978999', '', 'ta', '', '', NULL, 5),
(2, 'kjdfslfkdsf', 'gerge', '', '0000-00-00', '0732978999', '', '', '', '', NULL, 6),
(2, 'boss', 'valentin', '', '0000-00-00', '0732978999', '', 'are mere ana', '', '', NULL, 7);

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `tokens`
--

CREATE TABLE `tokens` (
  `iduser` int(11) NOT NULL,
  `token` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Eliminarea datelor din tabel `tokens`
--

INSERT INTO `tokens` (`iduser`, `token`) VALUES
(2, 'e65701b48832709569f6f3dec00fce91');

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `user`
--

CREATE TABLE `user` (
  `IDUser` int(11) NOT NULL,
  `Nume` varchar(25) NOT NULL,
  `Prenume` varchar(30) NOT NULL,
  `Password` varchar(40) NOT NULL,
  `Email` varchar(40) NOT NULL,
  `Phone` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Eliminarea datelor din tabel `user`
--

INSERT INTO `user` (`IDUser`, `Nume`, `Prenume`, `Password`, `Email`, `Phone`) VALUES
(2, 'sddsa', 'dsa', 'sadasd', 'dasdsa@ffs.com', '0732978888');

--
-- Indexuri pentru tabele eliminate
--

--
-- Indexuri pentru tabele `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- Indexuri pentru tabele `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`IDUser`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- AUTO_INCREMENT pentru tabele eliminate
--

--
-- AUTO_INCREMENT pentru tabele `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pentru tabele `user`
--
ALTER TABLE `user`
  MODIFY `IDUser` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
