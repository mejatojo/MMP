-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : jeu. 30 juil. 2020 à 09:12
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
(99, 'test', 'test@test.ts', NULL, 'responsable', '0', 'test', '', '$2y$10$Vr9SLEqMYCAT6WiaDwW87O83PgtT23kieypYn4cbAXn6A38miIwCW', NULL, 0, NULL, NULL);

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
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

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
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=133;

--
-- AUTO_INCREMENT pour la table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT pour la table `references`
--
ALTER TABLE `references`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9003;

--
-- AUTO_INCREMENT pour la table `rendez_vous`
--
ALTER TABLE `rendez_vous`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=391;

--
-- AUTO_INCREMENT pour la table `statistiques`
--
ALTER TABLE `statistiques`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=151;

--
-- AUTO_INCREMENT pour la table `stocks`
--
ALTER TABLE `stocks`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70014;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;

--
-- AUTO_INCREMENT pour la table `vehicules`
--
ALTER TABLE `vehicules`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

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