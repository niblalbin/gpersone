-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versione server:              10.4.32-MariaDB - mariadb.org binary distribution
-- S.O. server:                  Win64
-- HeidiSQL Versione:            12.8.0.6908
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dump della struttura del database gpersone
CREATE DATABASE IF NOT EXISTS `gpersone` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;
USE `gpersone`;

-- Dump della struttura di tabella gpersone.anagrafiche
CREATE TABLE IF NOT EXISTS `anagrafiche` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) DEFAULT NULL,
  `cognome` varchar(90) DEFAULT NULL,
  `sesso` enum('M','F','ND') NOT NULL,
  `nas_luogo` varchar(50) DEFAULT NULL,
  `nas_regione` varchar(40) DEFAULT NULL,
  `nas_prov` varchar(2) DEFAULT NULL,
  `nas_cap` varchar(5) DEFAULT NULL,
  `data_nascita` date DEFAULT NULL,
  `cod_fiscale` varchar(16) NOT NULL,
  `res_luogo` varchar(50) DEFAULT NULL,
  `res_regione` varchar(40) DEFAULT NULL,
  `res_prov` varchar(2) DEFAULT NULL,
  `res_cap` varchar(5) DEFAULT NULL,
  `indirizzo` varchar(90) DEFAULT NULL,
  `telefono` varchar(15) DEFAULT NULL,
  `email` varchar(60) DEFAULT NULL,
  `pass_email` varchar(255) DEFAULT NULL,
  `id_ruolo` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `cod_fiscale` (`cod_fiscale`),
  UNIQUE KEY `email` (`email`),
  KEY `id_ruolo` (`id_ruolo`),
  CONSTRAINT `anagrafiche_ibfk_1` FOREIGN KEY (`id_ruolo`) REFERENCES `ruoli` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dump dei dati della tabella gpersone.anagrafiche: ~6 rows (circa)
DELETE FROM `anagrafiche`;
INSERT INTO `anagrafiche` (`id`, `nome`, `cognome`, `sesso`, `nas_luogo`, `nas_regione`, `nas_prov`, `nas_cap`, `data_nascita`, `cod_fiscale`, `res_luogo`, `res_regione`, `res_prov`, `res_cap`, `indirizzo`, `telefono`, `email`, `pass_email`, `id_ruolo`) VALUES
	(6, 'Isaia', 'Busana', 'M', 'Bellegra', 'Lazio', 'RM', '00030', '1934-08-28', 'BSNSIA34M28A749L', 'Volpeglino', 'Piemonte', 'AL', '15050', 'Via G.Di Breganze, 19', '0131/949127', 'isaia.busana@lycos.it', '26fc1016ab895ec03ed31e58a1ae881c19318cf21f3919aea48bbbccf9f07f6b', 1),
	(7, 'Dionigi', 'Zen', 'M', 'Riva del Garda', 'Trentino Alto Adige', 'TN', '38066', '2017-11-21', 'ZNEDNG17S21H330J', 'Carapelle', 'Puglia', 'FG', '71041', 'Via G.Keplero, 278', '0881/479753', NULL, '1274f90cd77dbea37da0f30e395af15a50b872168dd5992ceaa90c0d34d29b37', 2),
	(8, 'Gesualdo', 'Luis', 'M', 'Loiano', 'Emilia Romagna', 'BO', '40050', '1982-04-30', 'LSUGLD82D30E655Q', 'Moliterno', 'Basilicata', 'PZ', '85047', 'Via I.Lanza, 29/g', '0971/203262', 'g.luis@gmail.it', '5fefeaa306cb6f3601c312fe2c47f12c1927f91339925c46446676b3f63380e1', 2),
	(9, 'Ausilia', 'Ghidoni', 'F', 'Molise', 'Molise', 'CB', '86020', '1997-08-04', 'GHDSLA97M44F294I', 'Carrù', 'Piemonte', 'CN', '12061', 'Via A.Brofferio, 89', '0173/169365', 'a.ghidoni@gmail.it', '9301e398e6691cebdc469372530578fe4cf307eda66a49b083453e8144fd8ca2', 2);

-- Dump della struttura di tabella gpersone.notifiche
CREATE TABLE IF NOT EXISTS `notifiche` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_richiedente` int(11) NOT NULL,
  `cf_target` varchar(16) NOT NULL,
  `grado_parentela_proposto` varchar(50) DEFAULT NULL,
  `stato` enum('In attesa','Approvata','Rifiutata') DEFAULT 'In attesa',
  `data_creazione` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `id_richiedente` (`id_richiedente`),
  CONSTRAINT `notifiche_ibfk_1` FOREIGN KEY (`id_richiedente`) REFERENCES `anagrafiche` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dump dei dati della tabella gpersone.notifiche: ~0 rows (circa)
DELETE FROM `notifiche`;

-- Dump della struttura di tabella gpersone.nuclei_familiari
CREATE TABLE IF NOT EXISTS `nuclei_familiari` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome_nucleo` varchar(100) DEFAULT NULL,
  `data_creazione` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dump dei dati della tabella gpersone.nuclei_familiari: ~1 rows (circa)
DELETE FROM `nuclei_familiari`;
INSERT INTO `nuclei_familiari` (`id`, `nome_nucleo`, `data_creazione`) VALUES
	(1, 'Famiglia Guidoni', '2025-01-02 23:21:46');

-- Dump della struttura di tabella gpersone.relazioni_familiari
CREATE TABLE IF NOT EXISTS `relazioni_familiari` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_persona` int(11) NOT NULL,
  `id_nucleo` int(11) NOT NULL,
  `grado_parentela` varchar(50) NOT NULL,
  `data_creazione` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `id_persona` (`id_persona`),
  KEY `id_nucleo` (`id_nucleo`),
  CONSTRAINT `relazioni_familiari_ibfk_1` FOREIGN KEY (`id_persona`) REFERENCES `anagrafiche` (`id`) ON DELETE CASCADE,
  CONSTRAINT `relazioni_familiari_ibfk_2` FOREIGN KEY (`id_nucleo`) REFERENCES `nuclei_familiari` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dump dei dati della tabella gpersone.relazioni_familiari: ~2 rows (circa)
DELETE FROM `relazioni_familiari`;
INSERT INTO `relazioni_familiari` (`id`, `id_persona`, `id_nucleo`, `grado_parentela`, `data_creazione`) VALUES
	(1, 9, 1, 'Figlia', '2025-01-02 23:22:38'),
	(3, 8, 1, 'Figlio', '2025-01-03 00:08:10');

-- Dump della struttura di tabella gpersone.ruoli
CREATE TABLE IF NOT EXISTS `ruoli` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nome` (`nome`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dump dei dati della tabella gpersone.ruoli: ~2 rows (circa)
DELETE FROM `ruoli`;
INSERT INTO `ruoli` (`id`, `nome`) VALUES
	(1, 'Amministratore'),
	(2, 'Utente');

-- Dump della struttura di tabella gpersone.sessions
CREATE TABLE IF NOT EXISTS `sessions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `token` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `expires_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `sessions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `anagrafiche` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dump dei dati della tabella gpersone.sessions: ~5 rows (circa)
DELETE FROM `sessions`;
INSERT INTO `sessions` (`id`, `token`, `user_id`, `created_at`, `expires_at`) VALUES
	(40, '38cf326b9ac927c48c2b717a8f3363b795393b213fd3f484f9c9a62d70324946', 6, '2025-01-02 22:52:29', '2025-01-03 00:52:29'),
	(41, 'bbbaf3371c1ead1cfcd28caf60915057842f7285477aa19dff96056d119a6647', 8, '2025-01-02 23:41:23', '2025-01-03 01:41:23'),
	(42, 'a745a45d53b8542a72436f95ff6a6b5904b91d4691bf5f1631e867ef68f009ae', 6, '2025-01-03 00:32:25', '2025-01-03 02:32:25'),
	(43, '7a6c3a076b8cca52569a4932a7212b2e03b00c349971875fa995d8410c1baa28', 6, '2025-01-03 00:42:48', '2025-01-03 02:42:48'),
	(44, '7ef5783305a38552213ad72a5fdebb17523fe42f88c09a8163df21f6b6893e5b', 6, '2025-01-03 07:49:19', '2025-01-03 09:49:19'),
	(45, 'e691b14baa166d3bb3a67bfe886e255ba82a7df271c2b86c6d5171ee8bdc14c5', 6, '2025-01-03 10:04:43', '2025-01-03 12:04:43'),
	(46, 'c903b696fd9fdbdef31fcfbab57a5c5c136ba741f01183e1b5696dab7b43478a', 6, '2025-01-03 10:05:19', '2025-01-03 12:05:19'),
	(47, 'e7266503c7941a4faa553e78225c17cccf5fa7dc9db8047c3e5fe78a89807437', 6, '2025-01-03 10:05:20', '2025-01-03 12:05:20'),
	(48, 'afd137945dfa134de7441821df7235bb22f588425d52e920b1896f596077cceb', 6, '2025-01-03 10:18:26', '2025-01-03 12:18:26'),
	(49, '5344ae210d550b7d5798c870d209368a47bad44a72751cd5ddb84fc77f68bf9d', 8, '2025-01-03 10:19:31', '2025-01-03 12:19:31'),
	(50, '2658171e9dbe167e33b76620895c3fe3a59c0a650e4c06c91dca161077500b82', 8, '2025-01-03 10:21:21', '2025-01-03 12:21:21');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
