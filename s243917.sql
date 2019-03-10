-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Creato il: Gen 21, 2019 alle 14:31
-- Versione del server: 5.7.24-0ubuntu0.16.04.1
-- Versione PHP: 7.0.32-0ubuntu0.16.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `s243917`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `locations`
--

CREATE TABLE `locations` (
  `user_id` varchar(255) NOT NULL,
  `x` int(255) NOT NULL,
  `y` int(255) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `locations`
--

INSERT INTO `locations` (`user_id`, `x`, `y`, `timestamp`) VALUES
('', 10, 20, '2019-01-18 19:05:07'),
('', 30, 30, '2019-01-18 19:05:07'),
('', 350, 144, '2019-01-21 13:22:52'),
('u1@p.it', 30, 180, '2019-01-21 13:22:10'),
('', 540, 203, '2019-01-21 12:06:21'),
('', 130, 241, '2019-01-21 12:11:25'),
('', 240, 241, '2019-01-21 13:22:51'),
('u1@p.it', 70, 290, '2019-01-21 13:22:10'),
('', 280, 302, '2019-01-21 13:22:51'),
('u2@p.it', 75, 360, '2019-01-21 13:33:35');

-- --------------------------------------------------------

--
-- Struttura della tabella `users`
--

CREATE TABLE `users` (
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `users`
--

INSERT INTO `users` (`username`, `password`) VALUES
('u1@p.it', 'a04b161ab2e84fd02cec052343c6b2d5'),
('u2@p.it', '520de810b803b99a62574cc403871741'),
('u3@p.it', '9257a160604e9aff5694770f77a1f921');

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `locations`
--
ALTER TABLE `locations`
  ADD PRIMARY KEY (`y`,`x`);

--
-- Indici per le tabelle `users`
--
ALTER TABLE `users`
  ADD UNIQUE KEY `user_id` (`username`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
