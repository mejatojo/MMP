-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : mer. 05 août 2020 à 09:28
-- Version du serveur :  8.0.20
-- Version de PHP : 7.3.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `parc`
--

-- --------------------------------------------------------

--
-- Structure de la table `alertes`
--

CREATE TABLE `alertes` (
  `id` bigint UNSIGNED NOT NULL,
  `vehicule_id` bigint UNSIGNED NOT NULL,
  `message` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `dates`
--

CREATE TABLE `dates` (
  `id` bigint UNSIGNED NOT NULL,
  `datebloque` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `connection` text COLLATE utf8_unicode_ci NOT NULL,
  `queue` text COLLATE utf8_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `maintenances`
--

CREATE TABLE `maintenances` (
  `id` bigint UNSIGNED NOT NULL,
  `debut` datetime DEFAULT NULL,
  `fin` datetime DEFAULT NULL,
  `operations` text COLLATE utf8_unicode_ci,
  `observations` text COLLATE utf8_unicode_ci,
  `rdv_id` bigint UNSIGNED NOT NULL,
  `facture` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `imageIn1` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `imageIn2` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `hGommeIn` text COLLATE utf8_unicode_ci,
  `referenceIn` text COLLATE utf8_unicode_ci,
  `kilometrageIn` int DEFAULT NULL,
  `permutationIn` int DEFAULT NULL,
  `dControl` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `maintenances`
--

INSERT INTO `maintenances` (`id`, `debut`, `fin`, `operations`, `observations`, `rdv_id`, `facture`, `imageIn1`, `imageIn2`, `hGommeIn`, `referenceIn`, `kilometrageIn`, `permutationIn`, `dControl`, `created_at`, `updated_at`) VALUES
(133, '2020-07-31 00:00:00', '2020-07-31 00:00:00', 'Changement 2 pneus/\r\nPermutation 4 roues(pneus neufs à l\'arrière) Offert/Contrôle technique avant le 25/07/2023', 'Contrôle technique avant le 25/07/2023', 391, 'FACTURE_20-07-7_SOLTRACE.pdf', 'IMG_20200731_102942.jpg', 'IMG_20200731_103010.jpg', 'a:4:{i:0;s:3:\"4.8\";i:1;s:3:\"4.8\";i:2;s:1:\"7\";i:3;s:1:\"7\";}', 'a:4:{i:0;i:70022;i:1;i:70023;i:2;i:70050;i:3;i:70051;}', 29014, 10000, '2019-07-06', NULL, NULL),
(134, '2020-07-31 00:00:00', '2020-07-31 00:00:00', 'Contrôle pression/\r\nDevis pièce jointe/Contrôle technique avant le 28/06/2024', 'Contrôle technique avant le 28/06/2024', 392, 'Doc_31072020185534.PDF', 'IMG_20200731_110013.jpg', 'IMG_20200731_110028.jpg', 'a:4:{i:0;s:3:\"7.3\";i:1;s:3:\"7.3\";i:2;s:3:\"7.3\";i:3;s:3:\"7.3\";}', 'a:4:{i:0;i:70037;i:1;i:70038;i:2;i:70039;i:3;i:70040;}', 1649, 8351, '2020-06-29', NULL, NULL),
(135, '2020-07-31 00:00:00', '2020-07-31 00:00:00', 'Contrôle Pression /\r\nEssuie a remplacer/\r\nChoc arrière droit /\r\nPermutation a prévoir/\r\nContrôle pollution 20/02/2021/Contrôle technique 20/02/2022', 'Choc arrière droit/\r\nPermutation à prévoir/\r\nContrôle pollution 20/02/2021/\r\nContrôle technique 20/02/2022', 393, '', 'IMG_20200731_104443.jpg', 'IMG_20200731_111649.jpg', 'a:4:{i:0;s:3:\"5.4\";i:1;s:3:\"5.4\";i:2;s:3:\"7.2\";i:3;s:3:\"7.2\";}', 'a:4:{i:0;i:70024;i:1;i:70025;i:2;i:70026;i:3;i:70027;}', 59166, 0, '2016-03-04', NULL, NULL),
(136, '2020-07-31 00:00:00', '2020-07-31 00:00:00', 'Contrôle pression /\r\nPermutation à prévoir/Contrôle technique le 16/07/2023', 'Permutation à prévoir/\r\nContrôle technique le 16/07/2023', 394, '', 'IMG_20200731_112719.jpg', 'IMG_20200731_112730.jpg', 'a:4:{i:0;s:3:\"4.2\";i:1;s:3:\"4.2\";i:2;s:3:\"5.2\";i:3;s:3:\"5.2\";}', 'a:4:{i:0;i:70045;i:1;i:70046;i:2;i:70047;i:3;i:70048;}', 13408, 0, '2019-07-17', NULL, NULL),
(137, '2020-07-31 00:00:00', '2020-07-31 00:00:00', 'Contrôle Pression\r\nContrôle le 15/09/2023', 'Contrôle le 15/09/2023', 395, '', 'IMG_20200731_105447.jpg', 'IMG_20200731_105502.jpg', 'a:4:{i:0;s:3:\"5.6\";i:1;s:3:\"5.6\";i:2;s:3:\"5.9\";i:3;s:3:\"5.9\";}', 'a:4:{i:0;i:70028;i:1;i:70029;i:2;i:70030;i:3;i:70031;}', 20995, 10000, '2019-09-16', NULL, NULL),
(148, '2020-07-31 00:00:00', '2020-07-31 00:00:00', 'Contrôle pression\r\nContrôle technique 27/01/2022', 'Contrôle technique 27/01/2022', 407, '', 'IMG_20200731_105753.jpg', 'IMG_20200731_111630.jpg', 'a:4:{i:0;s:3:\"5.9\";i:1;s:3:\"5.9\";i:2;s:1:\"4\";i:3;s:1:\"4\";}', 'a:4:{i:0;i:70032;i:1;i:70033;i:2;i:70034;i:3;i:70035;}', 134964, 10000, '2020-07-31', NULL, NULL),
(149, '2020-07-31 00:00:00', '2020-07-31 00:00:00', 'Contrôle pression /\r\nDevis pièce jointe/\r\nUsure Prononcée des disques et plaquettes avant/\r\nContrôle technique 17/12/2021', 'Usure Prononcée des disques et plaquettes Avant/\r\nContrôle technique 17/12/2021', 408, 'Doc_31072020185534.PDF', 'IMG_20200731_111604.jpg', 'IMG_20200731_111557.jpg', 'a:4:{i:0;s:3:\"5.6\";i:1;s:3:\"5.6\";i:2;s:3:\"5.8\";i:3;s:3:\"5.8\";}', 'a:4:{i:0;i:70041;i:1;i:70042;i:2;i:70043;i:3;i:70044;}', 70313, 10000, '2020-07-31', NULL, NULL),
(151, '2020-08-02 00:00:00', '2020-08-02 00:00:00', 'Contrôle pression', 'RAS', 410, '', '', '', 'a:4:{i:0;s:3:\"6.3\";i:1;s:3:\"6.3\";i:2;s:3:\"6.8\";i:3;s:3:\"6.8\";}', 'a:4:{i:0;i:70080;i:1;i:70081;i:2;i:70082;i:3;i:70083;}', 5741, 4259, '2020-01-22', NULL, NULL),
(152, '2020-08-02 00:00:00', '2020-08-02 00:00:00', 'Contrôle', 'RAS', 411, '', '', '', 'a:4:{i:0;s:3:\"4.6\";i:1;s:3:\"4.6\";i:2;s:3:\"3.6\";i:3;s:3:\"3.6\";}', 'a:4:{i:0;i:70088;i:1;i:70089;i:2;i:70090;i:3;i:70091;}', 202869, 10000, '2003-06-24', NULL, NULL),
(153, '2020-08-02 00:00:00', '2020-08-02 00:00:00', 'Contrôle', 'RAS', 412, '', '', '', 'a:4:{i:0;s:3:\"5.2\";i:1;s:3:\"5.2\";i:2;s:3:\"6.1\";i:3;s:3:\"6.1\";}', 'a:4:{i:0;i:70084;i:1;i:70085;i:2;i:70086;i:3;i:70087;}', 157768, 10000, '2010-10-04', NULL, NULL),
(154, '2020-08-02 00:00:00', '2020-08-02 00:00:00', 'Contrôle', 'RAS', 413, '', '', '', 'a:4:{i:0;s:3:\"7.3\";i:1;s:3:\"7.3\";i:2;s:3:\"6.3\";i:3;s:3:\"6.3\";}', 'a:4:{i:0;i:70092;i:1;i:70093;i:2;i:70094;i:3;i:70095;}', 42111, 10000, '2018-03-31', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2020_04_16_191521_create_vehicules_table', 1),
(5, '2020_04_21_171810_create_rendez_vous_table', 1),
(6, '2020_05_01_084019_create_maintenances_table', 1),
(7, '2020_05_04_114543_create_references_table', 1),
(8, '2020_05_04_114618_create_stocks_table', 1),
(9, '2020_05_16_115622_create_dates_table', 1),
(10, '2020_05_18_125718_create_statistiques_table', 1),
(11, '2020_06_18_105048_create_alertes_table', 2);

-- --------------------------------------------------------

--
-- Structure de la table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `references`
--

CREATE TABLE `references` (
  `id` bigint UNSIGNED NOT NULL,
  `reference` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `prix` double(8,2) DEFAULT NULL,
  `indication` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `consommation` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `references`
--

INSERT INTO `references` (`id`, `reference`, `prix`, `indication`, `consommation`, `created_at`, `updated_at`) VALUES
(9003, 'BRIDGEST EP150 175/60 R16 82 H - C, B, 2, 69dB Démo', 60.00, 'C', 0.28, NULL, NULL),
(9004, 'BRIDGEST EP150 175/60 R16 82 H - C, B, 2, 69dB', 89.50, 'C', 0.28, NULL, NULL),
(9005, 'CONTI VACO2 175/70R14C 95 T - C, B, 2, 72dB', 86.00, 'C', 0.28, NULL, NULL),
(9006, 'BRIDGEST B250 175/60 R16 82 H - C, C, 2, 68dB ECOPIA', 76.00, 'C', 0.28, NULL, NULL),
(9007, 'MICHELIN EN-SA+ 205/60 R16 96 H XL - B, A, 2, 70dB', 102.00, 'B', 0.14, NULL, NULL),
(9008, 'PIRELLI NER-GT 225/40ZR18 (92Y) XL - E, B, 2, 72dB', 83.00, 'E', 0.45, NULL, NULL),
(9009, 'BRIDGEST D684II 195/80 R15 96 S - C, C, 2, 71dB', 76.00, 'C', 0.28, NULL, NULL),
(9015, 'GOODYEAR EFFIGR 215/55 R18 95 H - B, A, 2, 70dB PERFORMANCE', 100.00, 'B', 0.14, NULL, NULL),
(9016, 'CONTI ECO-6 205/55 R16 91 V - A, A, 2, 71dB', 63.18, 'A', 0, NULL, NULL),
(9017, 'FIRESTONE ROAD-H 205/55 R16 91 V - C, A, 2, 70dB', 55.18, 'C', 0.28, NULL, NULL),
(9018, 'MICHELIN CLIMA+ 175/65 R14 86 H XL - C, C, 1, 68dB ALLWETTER', 63.72, 'C', 0.28, NULL, NULL),
(9019, 'HANKOOK K425 175/65 R14 82 T - E, B, 2, 69dB', 50.00, 'E', 0.45, NULL, NULL),
(9020, 'CONTI VAN100 205/65 R16 107/105T - B, B, 2, 72dB', 105.00, 'B', 0.14, NULL, NULL),
(9021, 'HANKOOK RA28E 205/65R16C 107T 8PR - B, B, 2, 71dB', 83.40, 'B', 0.14, NULL, NULL),
(9022, 'ROSAVA 155/70/13 TRL50', 90.00, 'C', 0.28, NULL, NULL),
(9023, 'MICHELIN EN-SA+ 195/65 R15 95 T XL - B, A, 2, 70 dB DEMO', 50.00, 'B', 0.14, NULL, NULL),
(9024, 'MICHELIN PRIMA4 205/55 R16 91 H -A, A, 2, 69dB (S2) DEMO', 69.00, 'A', 0, NULL, NULL),
(9025, 'CONTI ECO-6 205/55 R16 91 V  -A, A, 2, 71 dB DEMO', 61.00, 'A', 0, NULL, NULL),
(9026, 'CONTI VC-ECO 205/65 R16 107/103T - A, A, 2, 71dB VW DEMO', 100.00, 'A', 0, NULL, NULL),
(9027, 'BF-GOODR ALL-TE 215/75 R15 100/97S - F, B, 2, 74dB ALLWETTER LRC RBL', 126.98, 'F', 0.62, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `rendez_vous`
--

CREATE TABLE `rendez_vous` (
  `id` bigint UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `heure` time NOT NULL,
  `vehicule_id` bigint UNSIGNED NOT NULL,
  `commentaire` text COLLATE utf8_unicode_ci,
  `accepted` tinyint(1) NOT NULL DEFAULT '0',
  `finished` tinyint(1) NOT NULL DEFAULT '0',
  `raison` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `calendarId` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `rendez_vous`
--

INSERT INTO `rendez_vous` (`id`, `date`, `heure`, `vehicule_id`, `commentaire`, `accepted`, `finished`, `raison`, `calendarId`, `created_at`, `updated_at`) VALUES
(391, '2020-07-31', '19:09:33', 25, 'Changement 2 pneus/\r\nPermutation 4 roues(pneus neufs à l\'arrière) Offert/Contrôle technique avant le 25/07/2023', 2, 2, '', '', '2020-07-31 16:09:33', NULL),
(392, '2020-07-31', '19:22:33', 29, 'Contrôle pression/\r\nDevis pièce jointe/Contrôle technique avant le 28/06/2024', 2, 2, '', '', '2020-07-31 16:22:33', NULL),
(393, '2020-07-31', '19:25:49', 26, 'Contrôle Pression /\r\nEssuie a remplacer/\r\nChoc arrière droit /\r\nPermutation a prévoir/\r\nContrôle pollution 20/02/2021/Contrôle technique 20/02/2022', 2, 2, '', '', '2020-07-31 16:25:49', NULL),
(394, '2020-07-31', '19:29:45', 31, 'Contrôle pression /\r\nPermutation à prévoir/Contrôle technique le 16/07/2023', 2, 2, '', '', '2020-07-31 16:29:45', NULL),
(395, '2020-07-31', '19:32:32', 27, 'Contrôle Pression\r\nContrôle le 15/09/2023', 2, 2, '', '', '2020-07-31 16:32:32', NULL),
(407, '2020-07-31', '09:47:07', 28, 'Contrôle pression\r\nContrôle technique 27/01/2022', 2, 2, '', '', '2020-08-01 06:47:07', NULL),
(408, '2020-07-31', '09:50:32', 30, 'Contrôle pression /\r\nDevis pièce jointe/\r\nUsure Prononcée des disques et plaquettes avant/\r\nContrôle technique 17/12/2021', 2, 2, '', '', '2020-08-01 06:50:32', NULL),
(410, '2020-08-02', '13:57:43', 33, 'Contrôle pression', 2, 2, '', '', '2020-08-02 10:57:43', NULL),
(411, '2020-08-02', '13:59:50', 35, 'Contrôle', 2, 2, '', '', '2020-08-02 10:59:50', NULL),
(412, '2020-08-02', '14:01:44', 34, 'Contrôle', 2, 2, '', '', '2020-08-02 11:01:44', NULL),
(413, '2020-08-02', '14:03:15', 36, 'Contrôle', 2, 2, '', '', '2020-08-02 11:03:15', NULL),
(415, '2020-08-03', '12:22:36', 33, '', 2, 1, '', '', '2020-08-03 09:22:36', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `statistiques`
--

CREATE TABLE `statistiques` (
  `id` bigint UNSIGNED NOT NULL,
  `nombre` int NOT NULL,
  `reference_id` bigint UNSIGNED NOT NULL,
  `vehicules_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `stocks`
--

CREATE TABLE `stocks` (
  `id` bigint UNSIGNED NOT NULL,
  `reference_id` bigint UNSIGNED NOT NULL,
  `quantite` int NOT NULL,
  `date` datetime NOT NULL,
  `source` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `hgInit` double(8,2) DEFAULT NULL,
  `kInit` int DEFAULT NULL,
  `hgFinal` double(8,2) DEFAULT NULL,
  `kFinal` int DEFAULT NULL,
  `id_vehicule` bigint UNSIGNED DEFAULT NULL,
  `cout` double DEFAULT NULL,
  `gazole` double DEFAULT NULL,
  `pose` date DEFAULT NULL,
  `depose` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `stocks`
--

INSERT INTO `stocks` (`id`, `reference_id`, `quantite`, `date`, `source`, `hgInit`, `kInit`, `hgFinal`, `kFinal`, `id_vehicule`, `cout`, `gazole`, `pose`, `depose`, `created_at`, `updated_at`) VALUES
(70014, 9003, 0, '2031-07-20 17:43:53', 'europe', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-07-31 14:43:53', NULL),
(70015, 9004, 0, '2031-07-20 17:45:02', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-07-31 14:45:02', NULL),
(70016, 9005, 0, '2031-07-20 17:53:40', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-07-31 14:53:40', NULL),
(70017, 9006, 0, '2031-07-20 17:59:28', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-07-31 14:59:28', NULL),
(70018, 9007, 0, '2031-07-20 18:14:09', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-07-31 15:14:09', NULL),
(70019, 9008, 0, '2031-07-20 18:16:51', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-07-31 15:16:51', NULL),
(70020, 9004, 0, '2019-07-06 00:00:00', '', 7.00, 0, 1.50, 29014, 25, 120, 1.6, '2019-07-06', '2020-07-31', '2020-07-31 15:27:17', NULL),
(70021, 9004, 0, '2019-07-06 00:00:00', '', 7.00, 0, 2.10, 29014, 25, 120, 1.6, '2019-07-06', '2020-07-31', '2020-07-31 15:27:17', NULL),
(70022, 9004, 0, '2019-07-06 00:00:00', 'FJ-201-DH (SOLTRACE/LADE/LABAL)', 7.00, 0, NULL, NULL, NULL, NULL, NULL, '2019-07-06', NULL, '2020-07-31 15:27:17', NULL),
(70023, 9004, 0, '2019-07-06 00:00:00', 'FJ-201-DH (SOLTRACE/LADE/LABAL)', 7.00, 0, NULL, NULL, NULL, NULL, NULL, '2019-07-06', NULL, '2020-07-31 15:27:17', NULL),
(70024, 9005, 0, '2016-03-04 00:00:00', 'EA-946-EZ (SOLTRACE/LADE/LABAL)', 8.00, 0, NULL, NULL, NULL, NULL, NULL, '2016-03-04', NULL, '2020-07-31 15:33:55', NULL),
(70025, 9005, 0, '2016-03-04 00:00:00', 'EA-946-EZ (SOLTRACE/LADE/LABAL)', 8.00, 0, NULL, NULL, NULL, NULL, NULL, '2016-03-04', NULL, '2020-07-31 15:33:55', NULL),
(70026, 9005, 0, '2016-03-04 00:00:00', 'EA-946-EZ (SOLTRACE/LADE/LABAL)', 8.00, 0, NULL, NULL, NULL, NULL, NULL, '2016-03-04', NULL, '2020-07-31 15:33:55', NULL),
(70027, 9005, 0, '2016-03-04 00:00:00', 'EA-946-EZ (SOLTRACE/LADE/LABAL)', 8.00, 0, NULL, NULL, NULL, NULL, NULL, '2016-03-04', NULL, '2020-07-31 15:33:55', NULL),
(70028, 9004, 0, '2019-09-16 00:00:00', 'FK-101-CS (test)', 7.00, 0, NULL, NULL, NULL, NULL, NULL, '2019-09-16', NULL, '2020-07-31 15:39:48', NULL),
(70029, 9004, 0, '2019-09-16 00:00:00', 'FK-101-CS (test)', 7.00, 0, NULL, NULL, NULL, NULL, NULL, '2019-09-16', NULL, '2020-07-31 15:39:48', NULL),
(70030, 9004, 0, '2019-09-16 00:00:00', 'FK-101-CS (test)', 7.00, 0, NULL, NULL, NULL, NULL, NULL, '2019-09-16', NULL, '2020-07-31 15:39:48', NULL),
(70031, 9004, 0, '2019-09-16 00:00:00', 'FK-101-CS (test)', 7.00, 0, NULL, NULL, NULL, NULL, NULL, '2019-09-16', NULL, '2020-07-31 15:39:48', NULL),
(70032, 9004, 0, '2020-07-31 00:00:00', 'AR-444-VE(Soltrace) (SOLTRACE/LADE/LABAL)', 5.90, 134964, NULL, NULL, NULL, NULL, NULL, '2020-07-31', NULL, '2020-07-31 15:46:56', NULL),
(70033, 9004, 0, '2020-07-31 00:00:00', 'AR-444-VE(Soltrace) (SOLTRACE/LADE/LABAL)', 5.90, 134964, NULL, NULL, NULL, NULL, NULL, '2020-07-31', NULL, '2020-07-31 15:46:56', NULL),
(70034, 9006, 0, '2020-07-31 00:00:00', 'AR-444-VE(Soltrace) (SOLTRACE/LADE/LABAL)', 4.00, 134964, NULL, NULL, NULL, NULL, NULL, '2020-07-31', NULL, '2020-07-31 15:46:56', NULL),
(70035, 9006, 0, '2020-07-31 00:00:00', 'AR-444-VE(Soltrace) (SOLTRACE/LADE/LABAL)', 4.00, 134964, NULL, NULL, NULL, NULL, NULL, '2020-07-31', NULL, '2020-07-31 15:46:56', NULL),
(70036, 9009, 0, '2031-07-20 18:52:43', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-07-31 15:52:43', NULL),
(70037, 9009, 0, '2020-06-29 00:00:00', 'FQ-217-ZM (SOLTRACE/LADE/LABAL)', 7.50, 0, NULL, NULL, NULL, NULL, NULL, '2020-06-29', NULL, '2020-07-31 15:58:19', NULL),
(70038, 9009, 0, '2020-06-29 00:00:00', 'FQ-217-ZM (SOLTRACE/LADE/LABAL)', 7.50, 0, NULL, NULL, NULL, NULL, NULL, '2020-06-29', NULL, '2020-07-31 15:58:19', NULL),
(70039, 9009, 0, '2020-06-29 00:00:00', 'FQ-217-ZM (SOLTRACE/LADE/LABAL)', 7.50, 0, NULL, NULL, NULL, NULL, NULL, '2020-06-29', NULL, '2020-07-31 15:58:19', NULL),
(70040, 9009, 0, '2020-06-29 00:00:00', 'FQ-217-ZM (SOLTRACE/LADE/LABAL)', 7.50, 0, NULL, NULL, NULL, NULL, NULL, '2020-06-29', NULL, '2020-07-31 15:58:19', NULL),
(70041, 9008, 0, '2020-07-31 00:00:00', 'DC-220-AY(SAS LADE) (test)', 5.60, 70313, NULL, NULL, NULL, NULL, NULL, '2020-07-31', NULL, '2020-07-31 16:03:17', NULL),
(70042, 9008, 0, '2020-07-31 00:00:00', 'DC-220-AY(SAS LADE) (test)', 5.60, 70313, NULL, NULL, NULL, NULL, NULL, '2020-07-31', NULL, '2020-07-31 16:03:17', NULL),
(70043, 9008, 0, '2020-07-31 00:00:00', 'DC-220-AY(SAS LADE) (test)', 5.80, 70313, NULL, NULL, NULL, NULL, NULL, '2020-07-31', NULL, '2020-07-31 16:03:17', NULL),
(70044, 9008, 0, '2020-07-31 00:00:00', 'DC-220-AY(SAS LADE) (test)', 5.80, 70313, NULL, NULL, NULL, NULL, NULL, '2020-07-31', NULL, '2020-07-31 16:03:17', NULL),
(70045, 9007, 0, '2019-07-17 00:00:00', 'FH-330-XL((LADE) (SOLTRACE/LADE/LABAL)', 7.00, 0, NULL, NULL, NULL, NULL, NULL, '2019-07-17', NULL, '2020-07-31 16:09:06', NULL),
(70046, 9007, 0, '2019-07-17 00:00:00', 'FH-330-XL((LADE) (SOLTRACE/LADE/LABAL)', 7.00, 0, NULL, NULL, NULL, NULL, NULL, '2019-07-17', NULL, '2020-07-31 16:09:06', NULL),
(70047, 9007, 0, '2019-07-17 00:00:00', 'FH-330-XL((LADE) (SOLTRACE/LADE/LABAL)', 7.00, 0, NULL, NULL, NULL, NULL, NULL, '2019-07-17', NULL, '2020-07-31 16:09:06', NULL),
(70048, 9007, 0, '2019-07-17 00:00:00', 'FH-330-XL((LADE) (SOLTRACE/LADE/LABAL)', 7.00, 0, NULL, NULL, NULL, NULL, NULL, '2019-07-17', NULL, '2020-07-31 16:09:06', NULL),
(70049, 9003, 2, '2031-07-20 19:11:02', 'europe', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-07-31 16:11:02', NULL),
(70050, 9003, -1, '2031-07-20 00:00:00', 'FJ-201-DH(Soltrace) (SOLTRACE/LADE/LABAL)', 7.00, 29014, NULL, NULL, NULL, NULL, NULL, '2020-07-31', NULL, '2020-07-31 16:11:15', NULL),
(70051, 9003, -1, '2031-07-20 00:00:00', 'FJ-201-DH(Soltrace) (SOLTRACE/LADE/LABAL)', 7.00, 29014, NULL, NULL, NULL, NULL, NULL, '2020-07-31', NULL, '2020-07-31 16:11:27', NULL),
(70063, 9015, 0, '2001-08-20 17:30:52', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-08-01 14:30:52', NULL),
(70064, 9016, 0, '2001-08-20 17:33:53', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-08-01 14:33:53', NULL),
(70065, 9017, 0, '2001-08-20 17:34:42', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-08-01 14:34:42', NULL),
(70066, 9018, 0, '2001-08-20 17:35:44', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-08-01 14:35:44', NULL),
(70067, 9019, 0, '2001-08-20 17:38:32', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-08-01 14:38:32', NULL),
(70068, 9020, 0, '2001-08-20 17:40:47', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-08-01 14:40:47', NULL),
(70069, 9021, 0, '2001-08-20 17:42:08', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-08-01 14:42:08', NULL),
(70070, 9022, 0, '2001-08-20 17:43:30', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-08-01 14:43:30', NULL),
(70071, 9023, 0, '2001-08-20 17:44:50', 'EUROPE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-08-01 14:44:50', NULL),
(70072, 9023, 10, '2001-08-20 17:45:38', 'EUROPE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-08-01 14:45:38', NULL),
(70073, 9024, 0, '2001-08-20 17:46:29', 'EUROPE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-08-01 14:46:29', NULL),
(70074, 9024, 3, '2001-08-20 17:47:00', 'EUROPE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-08-01 14:47:00', NULL),
(70075, 9025, 0, '2001-08-20 17:47:45', 'EUROPE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-08-01 14:47:45', NULL),
(70076, 9025, 4, '2001-08-20 17:48:09', 'EUROPE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-08-01 14:48:09', NULL),
(70077, 9026, 0, '2001-08-20 17:49:28', 'EUROPE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-08-01 14:49:28', NULL),
(70078, 9026, 2, '2001-08-20 17:49:55', 'EUROPE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-08-01 14:49:55', NULL),
(70079, 9027, 0, '2002-08-20 10:59:29', 'France', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-08-02 07:59:29', NULL),
(70080, 9015, 0, '2020-01-22 00:00:00', 'FN-808-EG (test)', 7.50, 0, NULL, NULL, NULL, NULL, NULL, '2020-01-22', NULL, '2020-08-02 09:31:22', NULL),
(70081, 9015, 0, '2020-01-22 00:00:00', 'FN-808-EG (test)', 7.50, 0, NULL, NULL, NULL, NULL, NULL, '2020-01-22', NULL, '2020-08-02 09:31:22', NULL),
(70082, 9015, 0, '2020-01-22 00:00:00', 'FN-808-EG (test)', 7.50, 0, NULL, NULL, NULL, NULL, NULL, '2020-01-22', NULL, '2020-08-02 09:31:22', NULL),
(70083, 9015, 0, '2020-01-22 00:00:00', 'FN-808-EG (test)', 7.50, 0, NULL, NULL, NULL, NULL, NULL, '2020-01-22', NULL, '2020-08-02 09:31:22', NULL),
(70084, 9017, 0, '2010-10-04 00:00:00', 'BB-967-AS (test)', 7.50, 0, NULL, NULL, NULL, NULL, NULL, '2010-10-04', NULL, '2020-08-02 09:35:37', NULL),
(70085, 9017, 0, '2010-10-04 00:00:00', 'BB-967-AS (test)', 7.50, 0, NULL, NULL, NULL, NULL, NULL, '2010-10-04', NULL, '2020-08-02 09:35:37', NULL),
(70086, 9025, 0, '2010-10-04 00:00:00', 'BB-967-AS (test)', 7.50, 0, NULL, NULL, NULL, NULL, NULL, '2010-10-04', NULL, '2020-08-02 09:35:37', NULL),
(70087, 9025, 0, '2010-10-04 00:00:00', 'BB-967-AS (test)', 7.50, 0, NULL, NULL, NULL, NULL, NULL, '2010-10-04', NULL, '2020-08-02 09:35:37', NULL),
(70088, 9019, 0, '2003-06-24 00:00:00', 'AJ-369-VE (test)', 7.00, 0, NULL, NULL, NULL, NULL, NULL, '2003-06-24', NULL, '2020-08-02 09:40:03', NULL),
(70089, 9019, 0, '2003-06-24 00:00:00', 'AJ-369-VE (test)', 7.00, 0, NULL, NULL, NULL, NULL, NULL, '2003-06-24', NULL, '2020-08-02 09:40:03', NULL),
(70090, 9019, 0, '2003-06-24 00:00:00', 'AJ-369-VE (test)', 7.00, 0, NULL, NULL, NULL, NULL, NULL, '2003-06-24', NULL, '2020-08-02 09:40:03', NULL),
(70091, 9019, 0, '2003-06-24 00:00:00', 'AJ-369-VE (test)', 7.00, 0, NULL, NULL, NULL, NULL, NULL, '2003-06-24', NULL, '2020-08-02 09:40:03', NULL),
(70092, 9020, 0, '2018-03-31 00:00:00', 'EW-323-GN (test)', 7.50, 0, NULL, NULL, NULL, NULL, NULL, '2018-03-31', NULL, '2020-08-02 09:44:06', NULL),
(70093, 9020, 0, '2018-03-31 00:00:00', 'EW-323-GN (test)', 7.50, 0, NULL, NULL, NULL, NULL, NULL, '2018-03-31', NULL, '2020-08-02 09:44:06', NULL),
(70094, 9021, 0, '2018-03-31 00:00:00', 'EW-323-GN (test)', 7.50, 0, NULL, NULL, NULL, NULL, NULL, '2018-03-31', NULL, '2020-08-02 09:44:06', NULL),
(70095, 9021, 0, '2018-03-31 00:00:00', 'EW-323-GN (test)', 7.50, 0, NULL, NULL, NULL, NULL, NULL, '2018-03-31', NULL, '2020-08-02 09:44:06', NULL),
(70096, 9022, 0, '2020-08-02 00:00:00', 'REMORQUE (test)', 4.20, 0, NULL, NULL, NULL, NULL, NULL, '2020-08-02', NULL, '2020-08-02 09:49:04', NULL),
(70097, 9022, 0, '2020-08-02 00:00:00', 'REMORQUE (test)', 4.20, 0, NULL, NULL, NULL, NULL, NULL, '2020-08-02', NULL, '2020-08-02 09:49:04', NULL),
(70098, 9022, 0, '2020-08-02 00:00:00', 'REMORQUE (test)', 4.20, 0, NULL, NULL, NULL, NULL, NULL, '2020-08-02', NULL, '2020-08-02 09:49:04', NULL),
(70099, 9022, 0, '2020-08-02 00:00:00', 'REMORQUE (test)', 4.20, 0, NULL, NULL, NULL, NULL, NULL, '2020-08-02', NULL, '2020-08-02 09:49:04', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `role` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `entreprise` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `logo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `role`, `phone`, `entreprise`, `logo`, `password`, `remember_token`, `active`, `created_at`, `updated_at`) VALUES
(97, 'spa', 'superadmin@gmail.com', NULL, 'superadmin', '02564', 'undefined', NULL, '$2y$10$ZjbiC6lenI6Gt8SbS8mUwud4hoFNo5gYOQ/hRnkrzRaQkmLHJhiTW', NULL, 0, '2020-07-29 07:21:07', '2020-07-29 07:21:07'),
(99, 'test', 'test@test.ts', NULL, 'responsable', '0', 'test', '', '$2y$10$Vr9SLEqMYCAT6WiaDwW87O83PgtT23kieypYn4cbAXn6A38miIwCW', NULL, 1, NULL, NULL),
(107, 'titi', 'thierrypuchades@gmail.com', NULL, 'responsable', '0682418692', 'Parc Privée', '', '$2y$10$wFOCUuu6q4aHX2BipbA2BOdhdLEBD1zJ0kBxhISBT9gzRkrWjF10u', NULL, 0, NULL, NULL),
(113, 'sitraka', 'onja.sitraka@gmail.com', NULL, 'responsable', '0347661767', 'MSV', '', '$2y$10$RR2pSqiAWge4QkR2s1H4OuxNXFPPfxNQAnuIUXfLAEFVhsPd9uoVi', NULL, 1, NULL, NULL),
(115, 'Aline / Loïc / Gaby', 'secretariat@soltrace.com', NULL, 'responsable', '04 93 63 45 04', 'SOLTRACE/LADE/LABAL', '', '$2y$10$7SDDU3rMPooHg9Lu2K/c.elB80ULP67hpX79aHrTVZs3dlbBjoQBi', NULL, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `vehicules`
--

CREATE TABLE `vehicules` (
  `id` bigint UNSIGNED NOT NULL,
  `immatriculation` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `marque` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `model` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `pneu` int NOT NULL,
  `derniereMaintenance` date NOT NULL,
  `etatPneu` text COLLATE utf8_unicode_ci,
  `dpression` date DEFAULT NULL,
  `control` date DEFAULT NULL,
  `cConstant` date DEFAULT NULL,
  `refPneus` text COLLATE utf8_unicode_ci,
  `refPneuInit` text COLLATE utf8_unicode_ci,
  `t1` text COLLATE utf8_unicode_ci,
  `t2` text COLLATE utf8_unicode_ci,
  `tConstant` text COLLATE utf8_unicode_ci,
  `kilometrage` int DEFAULT NULL,
  `permutation` int DEFAULT NULL,
  `dpermutation` date DEFAULT NULL,
  `etatPneuInit` text COLLATE utf8_unicode_ci,
  `dernierePerte` date DEFAULT NULL,
  `hGomme` text COLLATE utf8_unicode_ci,
  `conducteur_id` bigint UNSIGNED NOT NULL,
  `alert` tinyint(1) NOT NULL DEFAULT '0',
  `dateAlert` date DEFAULT NULL,
  `alertP` tinyint(1) NOT NULL DEFAULT '0',
  `dateAlertP` date DEFAULT NULL,
  `dateC` date DEFAULT NULL,
  `serrage` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `active` int DEFAULT NULL,
  `nomH` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `emailH` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `phoneH` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `information` text COLLATE utf8_unicode_ci,
  `imageV` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `imageV2` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `observations` text COLLATE utf8_unicode_ci,
  `factureV` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `stationnement` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `carburant` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `limiteHg` double NOT NULL,
  `limiteP` double NOT NULL,
  `limitePression` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `vehicules`
--

INSERT INTO `vehicules` (`id`, `immatriculation`, `marque`, `model`, `pneu`, `derniereMaintenance`, `etatPneu`, `dpression`, `control`, `cConstant`, `refPneus`, `refPneuInit`, `t1`, `t2`, `tConstant`, `kilometrage`, `permutation`, `dpermutation`, `etatPneuInit`, `dernierePerte`, `hGomme`, `conducteur_id`, `alert`, `dateAlert`, `alertP`, `dateAlertP`, `dateC`, `serrage`, `type`, `active`, `nomH`, `emailH`, `phoneH`, `information`, `imageV`, `imageV2`, `observations`, `factureV`, `stationnement`, `carburant`, `limiteHg`, `limiteP`, `limitePression`, `created_at`, `updated_at`) VALUES
(25, 'FJ-201-DH(Soltrace)', 'SUZUKI-SANTANA', 'IGNIS III 1.2i EH 90', 4, '2020-07-31', 'a:4:{i:0;d:2.5;i:1;d:2.5;i:2;d:2.6;i:3;d:2.6;}', '2020-07-31', '2020-07-31', '2019-07-06', 'a:4:{i:0;i:70022;i:1;i:70023;i:2;i:70050;i:3;i:70051;}', 'a:4:{i:0;i:70020;i:1;i:70021;i:2;i:70022;i:3;i:70023;}', 'a:6:{i:0;s:1:\"7\";i:1;s:1:\"7\";i:2;s:1:\"7\";i:3;s:1:\"7\";i:4;s:1:\"0\";i:5;s:10:\"2019-07-06\";}', 'a:6:{i:0;s:3:\"4.8\";i:1;s:3:\"4.8\";i:2;s:1:\"7\";i:3;s:1:\"7\";i:4;s:5:\"29014\";i:5;s:10:\"2020-07-31\";}', 'a:6:{i:0;s:1:\"7\";i:1;s:1:\"7\";i:2;s:1:\"7\";i:3;s:1:\"7\";i:4;s:1:\"0\";i:5;s:10:\"2019-07-06\";}', 29014, 10000, '2020-07-31', 'a:4:{i:0;s:3:\"2.5\";i:1;s:3:\"2.5\";i:2;s:3:\"2.6\";i:3;s:3:\"2.6\";}', '2020-08-05', 'a:4:{i:0;s:3:\"4.8\";i:1;s:3:\"4.8\";i:2;s:1:\"7\";i:3;s:1:\"7\";}', 115, 0, '2020-01-01', 0, '2020-01-01', '2019-07-26', '110', 'traction', 0, 'Gaby', 'loicbesson@soltrace.com', '06 31 94 38 38', 'Jante Alu\nécrou antivol dans le coffre\nvalves tpms', 'IMG_20200731_102942.jpg', 'IMG_20200731_103010.jpg', 'Contrôle technique avant le 25/07/2023', '', 'Parc', 'Essence', 1.6, 10000, 90, NULL, NULL),
(26, 'EA-946-EZ(soltrace)', 'NISSAN', 'NV 200 1.5DCI 110 FAP', 4, '2020-07-31', 'a:4:{i:0;d:2.4;i:1;d:2.4;i:2;d:3.1;i:3;d:3.1;}', '2020-07-31', '2020-07-31', '2016-03-04', 'a:4:{i:0;i:70024;i:1;i:70025;i:2;i:70026;i:3;i:70027;}', 'a:4:{i:0;i:70024;i:1;i:70025;i:2;i:70026;i:3;i:70027;}', 'a:6:{i:0;s:1:\"8\";i:1;s:1:\"8\";i:2;s:1:\"8\";i:3;s:1:\"8\";i:4;s:1:\"0\";i:5;s:10:\"2016-03-04\";}', 'a:6:{i:0;s:3:\"5.4\";i:1;s:3:\"5.4\";i:2;s:3:\"7.2\";i:3;s:3:\"7.2\";i:4;s:5:\"59166\";i:5;s:10:\"2020-07-31\";}', 'a:6:{i:0;s:1:\"8\";i:1;s:1:\"8\";i:2;s:1:\"8\";i:3;s:1:\"8\";i:4;s:1:\"0\";i:5;s:10:\"2016-03-04\";}', 59166, 0, '2016-03-04', 'a:4:{i:0;s:3:\"2.4\";i:1;s:3:\"2.4\";i:2;s:3:\"3.1\";i:3;s:3:\"3.1\";}', '2020-08-05', 'a:4:{i:0;s:3:\"5.4\";i:1;s:3:\"5.4\";i:2;s:3:\"7.2\";i:3;s:3:\"7.2\";}', 115, 0, '2020-01-01', 0, '2020-01-01', '2016-03-04', '110', 'traction', 0, 'Loic', 'loicbesson@soltrace.com', '06 31 94 38 38', 'RAS', 'IMG_20200731_104443.jpg', 'IMG_20200731_111649.jpg', 'Choc arrière droit/\r\nPermutation à prévoir/\r\nContrôle pollution 20/02/2021/\r\nContrôle technique 20/02/2022', '', 'Parc', 'Gazoil', 1.6, 10000, 90, NULL, NULL),
(27, 'FK-101-CS(soltrace)', 'SUZUKI-SANTANA', 'IGNIS III 1.2i EH 90', 4, '2020-07-31', 'a:4:{i:0;d:2.2;i:1;d:2.2;i:2;d:2.5;i:3;d:2.5;}', '2020-07-31', '2020-07-31', '2020-07-31', 'a:4:{i:0;i:70028;i:1;i:70029;i:2;i:70030;i:3;i:70031;}', 'a:4:{i:0;i:70028;i:1;i:70029;i:2;i:70030;i:3;i:70031;}', 'a:6:{i:0;s:1:\"7\";i:1;s:1:\"7\";i:2;s:1:\"7\";i:3;s:1:\"7\";i:4;s:1:\"0\";i:5;s:10:\"2019-09-16\";}', 'a:6:{i:0;s:3:\"5.6\";i:1;s:3:\"5.6\";i:2;s:3:\"5.9\";i:3;s:3:\"5.9\";i:4;s:5:\"20995\";i:5;s:10:\"2020-07-31\";}', 'a:6:{i:0;s:1:\"7\";i:1;s:1:\"7\";i:2;s:1:\"7\";i:3;s:1:\"7\";i:4;s:1:\"0\";i:5;s:10:\"2019-09-16\";}', 20995, 10000, '2020-07-31', 'a:4:{i:0;s:3:\"2.2\";i:1;s:3:\"2.2\";i:2;s:3:\"2.5\";i:3;s:3:\"2.5\";}', '2020-08-05', 'a:4:{i:0;s:3:\"5.6\";i:1;s:3:\"5.6\";i:2;s:3:\"5.9\";i:3;s:3:\"5.9\";}', 115, 0, '2020-01-01', 0, '2020-01-01', '2019-09-16', '110', 'traction', 0, 'Loic', 'loicbesson@soltrace.com', '06 31 94 38 38', 'ecro antivol\njante alu\ntpms', 'IMG_20200731_105447.jpg', 'IMG_20200731_105502.jpg', 'Contrôle le 15/09/2023', '', 'Parc', 'Essence', 1.6, 10000, 90, NULL, NULL),
(28, 'AR-444-VE(Soltrace)', 'TOYOTA', 'IQ 1.3i 100', 4, '2020-07-31', 'a:4:{i:0;d:2.4;i:1;d:2.4;i:2;d:2.3;i:3;d:2.3;}', '2020-07-31', '2020-07-31', '2020-07-31', 'a:4:{i:0;i:70032;i:1;i:70033;i:2;i:70034;i:3;i:70035;}', 'a:4:{i:0;i:70032;i:1;i:70033;i:2;i:70034;i:3;i:70035;}', 'a:6:{i:0;s:3:\"5.9\";i:1;s:3:\"5.9\";i:2;s:1:\"4\";i:3;s:1:\"4\";i:4;s:6:\"134964\";i:5;s:10:\"2020-07-31\";}', '', 'a:6:{i:0;s:3:\"5.9\";i:1;s:3:\"5.9\";i:2;s:1:\"4\";i:3;s:1:\"4\";i:4;s:6:\"134964\";i:5;s:10:\"2020-07-31\";}', 134964, 10000, '2020-07-31', 'a:4:{i:0;s:3:\"2.4\";i:1;s:3:\"2.4\";i:2;s:3:\"2.3\";i:3;s:3:\"2.3\";}', '2020-08-05', 'a:4:{i:0;s:3:\"5.9\";i:1;s:3:\"5.9\";i:2;s:1:\"4\";i:3;s:1:\"4\";}', 115, 0, '2020-01-01', 0, '2020-01-01', '2010-05-07', '90', 'traction', 0, 'Aline', 'loicbesson@soltrace.com', '06 31 94 38 38', 'écrou antivol', 'IMG_20200731_105753.jpg', 'IMG_20200731_111630.jpg', 'Contrôle technique 27/01/2022', '', 'Parc', 'Essence', 1.6, 10000, 90, NULL, NULL),
(29, 'FQ-217-ZM(LABAL)', 'SUZUKI-SANTANA', 'JIMNY II 1.5i 102 4x4', 4, '2020-07-31', 'a:4:{i:0;d:1.8;i:1;d:1.8;i:2;d:1.8;i:3;d:1.8;}', '2020-07-31', '2020-07-31', '2020-07-31', 'a:4:{i:0;i:70037;i:1;i:70038;i:2;i:70039;i:3;i:70040;}', 'a:4:{i:0;i:70037;i:1;i:70038;i:2;i:70039;i:3;i:70040;}', 'a:6:{i:0;s:3:\"7.5\";i:1;s:3:\"7.5\";i:2;s:3:\"7.5\";i:3;s:3:\"7.5\";i:4;s:1:\"0\";i:5;s:10:\"2020-06-29\";}', 'a:6:{i:0;s:3:\"7.3\";i:1;s:3:\"7.3\";i:2;s:3:\"7.3\";i:3;s:3:\"7.3\";i:4;s:4:\"1649\";i:5;s:10:\"2020-07-31\";}', 'a:6:{i:0;s:3:\"7.5\";i:1;s:3:\"7.5\";i:2;s:3:\"7.5\";i:3;s:3:\"7.5\";i:4;s:1:\"0\";i:5;s:10:\"2020-06-29\";}', 1649, 8351, '2020-07-31', 'a:4:{i:0;s:3:\"1.8\";i:1;s:3:\"1.8\";i:2;s:3:\"1.8\";i:3;s:3:\"1.8\";}', '2020-08-05', 'a:4:{i:0;s:3:\"7.3\";i:1;s:3:\"7.3\";i:2;s:3:\"7.3\";i:3;s:3:\"7.3\";}', 115, 0, '2020-01-01', 0, '2020-01-01', '2020-06-29', '110', '4*4', 0, 'Philippe', 'loicbesson@soltrace.com', '06 31 94 38 38', '2 jeux de 5 jantes\r\n6X15 5*139.7 ET 0\r\n5.5X15 5*139.7 ET0\r\nTPMS\r\nécrou antivol', 'IMG_20200731_110013.jpg', 'IMG_20200731_110028.jpg', 'Contrôle technique avant le 28/06/2024', '', 'Parc', 'Gazoil', 3, 10000, 90, NULL, NULL),
(30, 'DC-220-AY(LADE)', 'AUDI', '2.0TFSI 301 [S3] 4x4', 4, '2020-07-31', 'a:4:{i:0;d:2.9;i:1;d:2.9;i:2;d:2.9;i:3;d:2.9;}', '2020-07-31', '2020-07-31', '2020-07-31', 'a:4:{i:0;i:70041;i:1;i:70042;i:2;i:70043;i:3;i:70044;}', 'a:4:{i:0;i:70041;i:1;i:70042;i:2;i:70043;i:3;i:70044;}', 'a:6:{i:0;s:3:\"5.6\";i:1;s:3:\"5.6\";i:2;s:3:\"5.8\";i:3;s:3:\"5.8\";i:4;s:5:\"70313\";i:5;s:10:\"2020-07-31\";}', '', 'a:6:{i:0;s:3:\"5.6\";i:1;s:3:\"5.6\";i:2;s:3:\"5.8\";i:3;s:3:\"5.8\";i:4;s:5:\"70313\";i:5;s:10:\"2020-07-31\";}', 70313, 10000, '2020-07-31', 'a:4:{i:0;s:3:\"2.9\";i:1;s:3:\"2.9\";i:2;s:3:\"2.9\";i:3;s:3:\"2.9\";}', '2020-08-05', 'a:4:{i:0;s:3:\"5.6\";i:1;s:3:\"5.6\";i:2;s:3:\"5.8\";i:3;s:3:\"5.8\";}', 115, 0, '2020-01-01', 0, '2020-01-01', '2014-01-09', '130', '4*4', 0, 'Philippe', 'loicbesson@soltrace.com', '06 31 94 38 38', 'Jante Alu 5*112 18', 'IMG_20200731_111604.jpg', 'IMG_20200731_111557.jpg', 'Usure Prononcée des disques et plaquettes Avant/\r\nContrôle technique 17/12/2021', '', 'Parc', 'Essence', 1.6, 10000, 90, NULL, NULL),
(31, 'FH-330-XL((LADE)', 'PEUGEOT', 'PARTNER III  1.5HDI 130 FAP', 4, '2020-07-31', 'a:4:{i:0;d:2.5;i:1;d:2.5;i:2;d:3.2;i:3;d:3.2;}', '2020-07-31', '2020-07-31', '2019-07-17', 'a:4:{i:0;i:70045;i:1;i:70046;i:2;i:70047;i:3;i:70048;}', 'a:4:{i:0;i:70045;i:1;i:70046;i:2;i:70047;i:3;i:70048;}', 'a:6:{i:0;s:1:\"7\";i:1;s:1:\"7\";i:2;s:1:\"7\";i:3;s:1:\"7\";i:4;s:1:\"0\";i:5;s:10:\"2019-07-17\";}', 'a:6:{i:0;s:3:\"4.2\";i:1;s:3:\"4.2\";i:2;s:3:\"5.2\";i:3;s:3:\"5.2\";i:4;s:5:\"13408\";i:5;s:10:\"2020-07-31\";}', 'a:6:{i:0;s:1:\"7\";i:1;s:1:\"7\";i:2;s:1:\"7\";i:3;s:1:\"7\";i:4;s:1:\"0\";i:5;s:10:\"2019-07-17\";}', 13408, 0, '2019-07-17', 'a:4:{i:0;s:3:\"2.5\";i:1;s:3:\"2.5\";i:2;s:3:\"3.2\";i:3;s:3:\"3.2\";}', '2020-08-05', 'a:4:{i:0;s:3:\"4.2\";i:1;s:3:\"4.2\";i:2;s:3:\"5.2\";i:3;s:3:\"5.2\";}', 115, 0, '2020-01-01', 0, '2020-01-01', '2019-07-17', '110', 'traction', 0, 'Loic', 'loicbesson@soltrace.com', '06 31 94 38 38', 'ras', 'IMG_20200731_112719.jpg', 'IMG_20200731_112730.jpg', 'Permutation à prévoir/\r\nContrôle technique le 16/07/2023', '', 'Parc', 'Gazoil', 1.6, 10000, 90, NULL, NULL),
(33, 'FN-808-EG', 'RENAULT', 'CAPTUR II', 4, '2020-08-02', 'a:4:{i:0;d:2.3;i:1;d:2.3;i:2;d:2.1;i:3;d:2.1;}', '2020-08-02', '2020-08-02', '2020-01-22', 'a:4:{i:0;i:70080;i:1;i:70081;i:2;i:70082;i:3;i:70083;}', 'a:4:{i:0;i:70080;i:1;i:70081;i:2;i:70082;i:3;i:70083;}', 'a:6:{i:0;s:3:\"7.5\";i:1;s:3:\"7.5\";i:2;s:3:\"7.5\";i:3;s:3:\"7.5\";i:4;s:1:\"0\";i:5;s:10:\"2020-01-22\";}', 'a:6:{i:0;s:3:\"6.3\";i:1;s:3:\"6.3\";i:2;s:3:\"6.8\";i:3;s:3:\"6.8\";i:4;s:4:\"5741\";i:5;s:10:\"2020-08-02\";}', 'a:6:{i:0;s:3:\"7.5\";i:1;s:3:\"7.5\";i:2;s:3:\"7.5\";i:3;s:3:\"7.5\";i:4;s:1:\"0\";i:5;s:10:\"2020-01-22\";}', 5741, 4259, '2020-01-22', 'a:4:{i:0;s:3:\"2.3\";i:1;s:3:\"2.3\";i:2;s:3:\"2.1\";i:3;s:3:\"2.1\";}', '2020-08-05', 'a:4:{i:0;s:3:\"6.3\";i:1;s:3:\"6.3\";i:2;s:3:\"6.8\";i:3;s:3:\"6.8\";}', 107, 0, '2020-01-01', 0, '2020-01-01', '2020-01-22', '120', 'traction', 0, 'Leconte Anne-Sophie', 'annesophie.leconte@gmail.com', '0652809011', 'Jante Alu \nWheel Secure', '', '', 'RAS', '', '300 avenue antony fabre 06270 villeneuve loubet', 'Essence', 1.6, 10000, 30, NULL, NULL),
(34, 'BB-967-AS', 'VOLKSWAGEN', 'TOURAN II 1.6TDI 105 FAP', 4, '2020-08-02', 'a:4:{i:0;d:2.5;i:1;d:2.5;i:2;d:3;i:3;d:3;}', '2020-08-02', '2020-08-02', '2010-10-04', 'a:4:{i:0;i:70084;i:1;i:70085;i:2;i:70086;i:3;i:70087;}', 'a:4:{i:0;i:70084;i:1;i:70085;i:2;i:70086;i:3;i:70087;}', 'a:6:{i:0;s:3:\"7.5\";i:1;s:3:\"7.5\";i:2;s:3:\"7.5\";i:3;s:3:\"7.5\";i:4;s:1:\"0\";i:5;s:10:\"2010-10-04\";}', 'a:6:{i:0;s:3:\"5.2\";i:1;s:3:\"5.2\";i:2;s:3:\"6.1\";i:3;s:3:\"6.1\";i:4;s:6:\"157768\";i:5;s:10:\"2020-08-02\";}', 'a:6:{i:0;s:3:\"7.5\";i:1;s:3:\"7.5\";i:2;s:3:\"7.5\";i:3;s:3:\"7.5\";i:4;s:1:\"0\";i:5;s:10:\"2010-10-04\";}', 157768, 10000, '2020-08-02', 'a:4:{i:0;s:3:\"2.5\";i:1;s:3:\"2.5\";i:2;s:1:\"3\";i:3;s:1:\"3\";}', '2020-08-05', 'a:4:{i:0;s:3:\"5.2\";i:1;s:3:\"5.2\";i:2;s:3:\"6.1\";i:3;s:3:\"6.1\";}', 107, 0, '2020-01-01', 0, '2020-01-01', '2010-10-04', '110', 'traction', 0, 'Puchades Thierry', 'titi3005@hotmail.com', '0682418692', 'RAS', '', '', 'RAS', '', '300 avenue antony fabre 06270 villeneuve loubet', 'Gazoil', 1.6, 10000, 30, NULL, NULL),
(35, 'AJ-369-VE', 'TOYOTA', 'YARIS I 1.4D4D 75', 4, '2020-08-02', 'a:4:{i:0;d:2.5;i:1;d:2.5;i:2;d:2.3;i:3;d:2.3;}', '2020-08-02', '2020-08-02', '2003-06-24', 'a:4:{i:0;i:70088;i:1;i:70089;i:2;i:70090;i:3;i:70091;}', 'a:4:{i:0;i:70088;i:1;i:70089;i:2;i:70090;i:3;i:70091;}', 'a:6:{i:0;s:1:\"7\";i:1;s:1:\"7\";i:2;s:1:\"7\";i:3;s:1:\"7\";i:4;s:1:\"0\";i:5;s:10:\"2003-06-24\";}', 'a:6:{i:0;s:3:\"4.6\";i:1;s:3:\"4.6\";i:2;s:3:\"3.6\";i:3;s:3:\"3.6\";i:4;s:6:\"202869\";i:5;s:10:\"2020-08-02\";}', 'a:6:{i:0;s:1:\"7\";i:1;s:1:\"7\";i:2;s:1:\"7\";i:3;s:1:\"7\";i:4;s:1:\"0\";i:5;s:10:\"2003-06-24\";}', 202869, 10000, '2020-08-02', 'a:4:{i:0;s:3:\"2.5\";i:1;s:3:\"2.5\";i:2;s:3:\"2.3\";i:3;s:3:\"2.3\";}', '2020-08-05', 'a:4:{i:0;s:3:\"4.6\";i:1;s:3:\"4.6\";i:2;s:3:\"3.6\";i:3;s:3:\"3.6\";}', 107, 0, '2020-01-01', 0, '2020-01-01', '2003-06-24', '90', 'traction', 0, 'Leconte Cacrole', 'titi3005@hotmail.com', '0682418692', 'RAS', '', '', 'RAS', '', '300 avenue antony fabre 06270 villeneuve loubet', 'Gazoil', 1.6, 10000, 30, NULL, NULL),
(36, 'EW-323-GN', 'VOLKSWAGEN', 'TRANSPORTER VI  2.0TDI 102 FAP', 4, '2020-08-02', 'a:4:{i:0;d:4.2;i:1;d:4.2;i:2;d:4.2;i:3;d:4.2;}', '2020-08-02', '2020-08-02', '2018-03-31', 'a:4:{i:0;i:70092;i:1;i:70093;i:2;i:70094;i:3;i:70095;}', 'a:4:{i:0;i:70092;i:1;i:70093;i:2;i:70094;i:3;i:70095;}', 'a:6:{i:0;s:3:\"7.5\";i:1;s:3:\"7.5\";i:2;s:3:\"7.5\";i:3;s:3:\"7.5\";i:4;s:1:\"0\";i:5;s:10:\"2018-03-31\";}', 'a:6:{i:0;s:3:\"7.3\";i:1;s:3:\"7.3\";i:2;s:3:\"6.3\";i:3;s:3:\"6.3\";i:4;s:5:\"42111\";i:5;s:10:\"2020-08-02\";}', 'a:6:{i:0;s:3:\"7.5\";i:1;s:3:\"7.5\";i:2;s:3:\"7.5\";i:3;s:3:\"7.5\";i:4;s:1:\"0\";i:5;s:10:\"2018-03-31\";}', 42111, 10000, '2020-08-02', 'a:4:{i:0;s:3:\"4.2\";i:1;s:3:\"4.2\";i:2;s:3:\"4.2\";i:3;s:3:\"4.2\";}', '2020-08-05', 'a:4:{i:0;s:3:\"7.3\";i:1;s:3:\"7.3\";i:2;s:3:\"6.3\";i:3;s:3:\"6.3\";}', 107, 0, '2020-01-01', 0, '2020-01-01', '2018-03-31', '120', 'aucune', 0, 'Puchades Thierry', 'titi3005@hotmail.com', '0682418692', 'Wheel secure', '', '', 'RAS', '', '300 avenue antony fabre 06270 villeneuve loubet', 'Gazoil', 1.6, 10000, 30, NULL, NULL),
(37, 'REMORQUE', '.', '.', 4, '2020-08-02', 'a:4:{i:0;d:2.5;i:1;d:2.5;i:2;d:2.5;i:3;d:2.5;}', '2020-08-02', '2020-08-02', '2020-08-02', 'a:4:{i:0;i:70096;i:1;i:70097;i:2;i:70098;i:3;i:70099;}', 'a:4:{i:0;i:70096;i:1;i:70097;i:2;i:70098;i:3;i:70099;}', 'a:6:{i:0;s:3:\"4.2\";i:1;s:3:\"4.2\";i:2;s:3:\"4.2\";i:3;s:3:\"4.2\";i:4;s:1:\"0\";i:5;s:10:\"2020-08-02\";}', '', 'a:6:{i:0;s:3:\"4.2\";i:1;s:3:\"4.2\";i:2;s:3:\"4.2\";i:3;s:3:\"4.2\";i:4;s:1:\"0\";i:5;s:10:\"2020-08-02\";}', 0, 10000, '2020-08-02', 'a:4:{i:0;s:3:\"2.5\";i:1;s:3:\"2.5\";i:2;s:3:\"2.5\";i:3;s:3:\"2.5\";}', '2020-08-05', 'a:4:{i:0;s:3:\"4.2\";i:1;s:3:\"4.2\";i:2;s:3:\"4.2\";i:3;s:3:\"4.2\";}', 107, 0, '2020-01-01', 0, '2020-01-01', '2020-08-02', '90', 'aucune', 0, 'Puchades Thierry', 'titi3005@hotmail.com', '0682418692', 'RAS', '', '', '', '', '300 avenue antony fabre 06270 villeneuve loubet', 'Gazoil', 1.6, 10000, 30, NULL, NULL);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `alertes`
--
ALTER TABLE `alertes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `alertes_vehicule_id_foreign` (`vehicule_id`);

--
-- Index pour la table `dates`
--
ALTER TABLE `dates`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `maintenances`
--
ALTER TABLE `maintenances`
  ADD PRIMARY KEY (`id`),
  ADD KEY `maintenances_rdv_id_foreign` (`rdv_id`);

--
-- Index pour la table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Index pour la table `references`
--
ALTER TABLE `references`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `rendez_vous`
--
ALTER TABLE `rendez_vous`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rendez_vous_vehicule_id_foreign` (`vehicule_id`);

--
-- Index pour la table `statistiques`
--
ALTER TABLE `statistiques`
  ADD PRIMARY KEY (`id`),
  ADD KEY `statistiques_reference_id_foreign` (`reference_id`),
  ADD KEY `statistiques_vehicules_id_foreign` (`vehicules_id`);

--
-- Index pour la table `stocks`
--
ALTER TABLE `stocks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `stocks_reference_id_foreign` (`reference_id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Index pour la table `vehicules`
--
ALTER TABLE `vehicules`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vehicules_conducteur_id_foreign` (`conducteur_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `alertes`
--
ALTER TABLE `alertes`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;

--
-- AUTO_INCREMENT pour la table `dates`
--
ALTER TABLE `dates`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT pour la table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `maintenances`
--
ALTER TABLE `maintenances`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=155;

--
-- AUTO_INCREMENT pour la table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT pour la table `references`
--
ALTER TABLE `references`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9032;

--
-- AUTO_INCREMENT pour la table `rendez_vous`
--
ALTER TABLE `rendez_vous`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=416;

--
-- AUTO_INCREMENT pour la table `statistiques`
--
ALTER TABLE `statistiques`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=151;

--
-- AUTO_INCREMENT pour la table `stocks`
--
ALTER TABLE `stocks`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70114;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=124;

--
-- AUTO_INCREMENT pour la table `vehicules`
--
ALTER TABLE `vehicules`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1003;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `alertes`
--
ALTER TABLE `alertes`
  ADD CONSTRAINT `alertes_vehicule_id_foreign` FOREIGN KEY (`vehicule_id`) REFERENCES `vehicules` (`id`);

--
-- Contraintes pour la table `maintenances`
--
ALTER TABLE `maintenances`
  ADD CONSTRAINT `maintenances_rdv_id_foreign` FOREIGN KEY (`rdv_id`) REFERENCES `rendez_vous` (`id`);

--
-- Contraintes pour la table `rendez_vous`
--
ALTER TABLE `rendez_vous`
  ADD CONSTRAINT `rendez_vous_vehicule_id_foreign` FOREIGN KEY (`vehicule_id`) REFERENCES `vehicules` (`id`);

--
-- Contraintes pour la table `statistiques`
--
ALTER TABLE `statistiques`
  ADD CONSTRAINT `statistiques_reference_id_foreign` FOREIGN KEY (`reference_id`) REFERENCES `references` (`id`),
  ADD CONSTRAINT `statistiques_vehicules_id_foreign` FOREIGN KEY (`vehicules_id`) REFERENCES `vehicules` (`id`);

--
-- Contraintes pour la table `stocks`
--
ALTER TABLE `stocks`
  ADD CONSTRAINT `stocks_reference_id_foreign` FOREIGN KEY (`reference_id`) REFERENCES `references` (`id`);

--
-- Contraintes pour la table `vehicules`
--
ALTER TABLE `vehicules`
  ADD CONSTRAINT `vehicules_conducteur_id_foreign` FOREIGN KEY (`conducteur_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
