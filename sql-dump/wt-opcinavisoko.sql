-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jun 17, 2015 at 11:33 PM
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
  `ime` varchar(20) COLLATE utf8_slovenian_ci NOT NULL,
  `email` varchar(30) COLLATE utf8_slovenian_ci NOT NULL,
  `komentar` text COLLATE utf8_slovenian_ci NOT NULL,
  `vrijeme` timestamp NOT NULL,
  `vijest` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `vijest` (`vijest`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci AUTO_INCREMENT=35 ;

--
-- Dumping data for table `komentari`
--

INSERT INTO `komentari` (`id`, `ime`, `email`, `komentar`, `vrijeme`, `vijest`) VALUES
(1, 'Amir', 'saban@live.com', 'Prvi komentar.', '2015-06-09 21:40:46', 1),
(2, 'Vedran', 'saban@live.com', 'Drugi komentar.', '2015-06-09 12:51:30', 2),
(3, 'Saban', 'saban@live.com', 'Treći komentar.', '2015-06-09 12:52:21', 3),
(4, 'Vedran', 'saban@live.com', 'Drugi komentar na prvu vijest.', '2015-06-09 22:10:59', 1),
(5, 'Haris', 'saban@live.com', 'Treći komentar na prvu vijest.', '2015-06-09 22:10:59', 1),
(22, 'Amir', 'saban@live.com', 'Ovo je novi komentar.', '2015-06-11 15:15:13', 3),
(27, 'Amir', 'saban@live.com', 'Novi komentar.', '2015-06-11 15:27:19', 2),
(28, 'Amir', 'saban@live.com', 'Najnoviji komentar.', '2015-06-11 15:30:23', 3),
(29, 'Amir', 'saban@live.com', 'Najnajnoviji komentar.', '2015-06-11 15:30:55', 2),
(30, 'Amir', 'saban@live.com', 'Da vidimo radi li sad...', '2015-06-11 15:33:36', 3),
(31, 'Amir', 'saban@live.com', 'A sad?', '2015-06-11 15:36:26', 3),
(32, 'Amir', 'saban@live.com', 'A SAD?!?!', '2015-06-11 15:37:01', 3),
(33, 'Amir', 'saban@live.com', 'A SAD?!?!?!?!', '2015-06-11 15:37:47', 3),
(34, 'Amir', 'saban@live.com', 'Hajde OK...', '2015-06-11 15:38:11', 3);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `vijesti`
--

INSERT INTO `vijesti` (`id`, `naslov`, `autor`, `datum`, `tekst`, `detaljnije`, `slika`) VALUES
(1, 'Naslov prve vijesti', 'Vedran Ljubović', '2015-06-08 22:00:16', 'Sada ću napisati neki osnovni tekst. Ovaj osnovni tekst se nalazi u više redova. Lorem ipsum dolor sit amet i tako dalje mrsko mi je da kopiram.', 'Ovdje sada slijedi detaljniji tekst novosti. Lorem ipsum dolor sit amet i tako dalje mrsko mi je da kopiram. Lorem ipsum dolor sit amet i tako dalje mrsko mi je da kopiram.', 'visoko2.jpg'),
(2, 'Najnovija vijest!', 'Amir Šabanović', '2015-06-08 22:00:16', 'Tekst najnovije vijesti.', '', ''),
(3, 'Ovo je naslov novosti', 'Vedran Ljubović', '2015-06-08 22:22:28', 'Ovo je tekst novosti. Drugi red. Treća rečenica.', '', '');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `komentari`
--
ALTER TABLE `komentari`
  ADD CONSTRAINT `komentari_ibfk_1` FOREIGN KEY (`vijest`) REFERENCES `vijesti` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
