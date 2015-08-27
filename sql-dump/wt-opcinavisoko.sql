-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Aug 27, 2015 at 11:09 PM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `wt-opcinavisoko`
--

-- --------------------------------------------------------

--
-- Table structure for table `komentari`
--

CREATE TABLE IF NOT EXISTS `komentari` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ime` varchar(20) COLLATE utf8_slovenian_ci DEFAULT NULL,
  `email` varchar(30) COLLATE utf8_slovenian_ci DEFAULT NULL,
  `komentar` text COLLATE utf8_slovenian_ci NOT NULL,
  `vrijeme` timestamp NULL DEFAULT NULL,
  `vijest` int(11) NOT NULL,
  `korisnik` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `vijest` (`vijest`),
  KEY `korisnik` (`korisnik`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci AUTO_INCREMENT=93 ;

--
-- Dumping data for table `komentari`
--

INSERT INTO `komentari` (`id`, `ime`, `email`, `komentar`, `vrijeme`, `vijest`, `korisnik`) VALUES
(71, 'amir', 'asabanovic3@gmail.com', 'Trenutak istine...', '2015-08-22 02:38:46', 4, 10),
(73, NULL, NULL, 'Trenutak druge istine.', NULL, 4, NULL),
(74, 'admin', 'saban@live.com', 'Komentar kao ''admin''.', '2015-08-22 02:48:33', 4, 1),
(75, 'admin', 'saban@live.com', 'I još jedan komentar kao ''admin''.', '2015-08-22 02:49:46', 4, 1),
(76, NULL, NULL, 'Oni ti ga puše, Njegošeee!!!', NULL, 3, NULL),
(77, NULL, NULL, 'Bravo, majstore!', NULL, 3, NULL),
(78, 'admin', 'saban@live.com', 'Pazite na rječnik.', '2015-08-22 02:57:26', 3, 1),
(82, 'amir', 'asabanovic3@gmail.com', 'Trenutak istine!', '2015-08-22 03:20:52', 4, 10),
(83, NULL, NULL, 'Anonimni.', NULL, 4, NULL),
(84, NULL, NULL, 'Hehe.', NULL, 4, NULL),
(85, 'amir', 'asabanovic3@gmail.com', 'Kao ''amir''.', '2015-08-22 03:23:55', 4, 10),
(86, 'admin', 'saban@live.com', 'Kao ''admin''.', '2015-08-22 03:24:12', 4, 1),
(87, 'rasim', 'amir_rasim@yahoo.com', 'Njegoše maaajstoreee!', '2015-08-22 03:32:38', 3, 12),
(88, NULL, NULL, '20,3!!!', NULL, 3, NULL),
(89, NULL, NULL, 'Svaka čast, momci!', NULL, 2, NULL),
(90, 'rasim', 'amir_rasim@yahoo.com', 'Bravooo!!!', '2015-08-22 16:58:43', 2, 12),
(91, 'amir', 'asabanovic3@gmail.com', 'Šaaampioni!!! Šaaampioni!!!', '2015-08-22 17:02:38', 2, 10),
(92, NULL, NULL, 'Anonimno, hehe.', NULL, 4, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `korisnici`
--

CREATE TABLE IF NOT EXISTS `korisnici` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `korisnik` varchar(20) COLLATE utf8_slovenian_ci NOT NULL,
  `admin` tinyint(4) NOT NULL,
  `lozinka` varchar(50) COLLATE utf8_slovenian_ci NOT NULL,
  `email` varchar(30) COLLATE utf8_slovenian_ci NOT NULL,
  `imeprezime` varchar(30) COLLATE utf8_slovenian_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `korisnik` (`korisnik`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci AUTO_INCREMENT=13 ;

--
-- Dumping data for table `korisnici`
--

INSERT INTO `korisnici` (`id`, `korisnik`, `admin`, `lozinka`, `email`, `imeprezime`) VALUES
(1, 'admin', 1, '21232f297a57a5a743894a0e4a801fc3', 'saban@live.com', 'Amir Sabanovic'),
(10, 'amir', 0, '63eefbd45d89e8c91f24b609f7539942', 'asabanovic3@gmail.com', 'Amir Sabanovic'),
(12, 'rasim', 0, '351ac251388588c9574adf62a1900efb', 'amir_rasim@yahoo.com', 'Rasim Sabanovic');

-- --------------------------------------------------------

--
-- Table structure for table `vijesti`
--

CREATE TABLE IF NOT EXISTS `vijesti` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `naslov` varchar(100) COLLATE utf8_slovenian_ci NOT NULL,
  `autor` varchar(30) COLLATE utf8_slovenian_ci NOT NULL,
  `datum` timestamp NOT NULL,
  `tekst` text COLLATE utf8_slovenian_ci NOT NULL,
  `detaljnije` text COLLATE utf8_slovenian_ci NOT NULL,
  `slika` varchar(100) COLLATE utf8_slovenian_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci AUTO_INCREMENT=5 ;

--
-- Dumping data for table `vijesti`
--

INSERT INTO `vijesti` (`id`, `naslov`, `autor`, `datum`, `tekst`, `detaljnije`, `slika`) VALUES
(2, 'U16 košarkaši pokorili Evropu', 'Amir Šabanović', '2015-06-08 22:00:16', 'Zlatna medalja osvojena u Kaunasu, Litvaniji pred 5.000 ljudi!', 'Medalje pobjednicima uručio Arvydas Sabonis!', ''),
(3, 'Njegoš Sikiraš MVP Eurobasketa', 'Amir Šabanović', '2015-06-08 22:22:28', 'Reprezentativac BiH najkorisniji je igrač turnira.', 'U prosjeku je bilježio 20,0 poena, 11,3 skokova i 2,4 blokada.', ''),
(4, 'John Oliver osnovao crkvu', 'Amir Šabanović', '2015-08-21 20:35:38', 'U svojoj emisiji Last Week Tonight with John Oliver.', 'Emisija se emituje svake nedjelje na HBO.', '');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `komentari`
--
ALTER TABLE `komentari`
  ADD CONSTRAINT `komentari_ibfk_1` FOREIGN KEY (`vijest`) REFERENCES `vijesti` (`id`),
  ADD CONSTRAINT `komentari_ibfk_2` FOREIGN KEY (`korisnik`) REFERENCES `korisnici` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
