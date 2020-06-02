

CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
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
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


INSERT INTO users (`id`, `name`, `email`, `email_verified_at`, `role`, `phone`, `entreprise`, `logo`, `password`, `remember_token`, `active`, `created_at`, `updated_at`) VALUES 
('1','garage','operateur@gmail.com','','operateur','032 44 993 62','undefined','','$2y$10$52zCd.Pe.jgiv3eZVz3keuMksAdiYaYHZbcBZwQ8LI0Zv58WcHUJ.','','0','2020-04-27 04:51:47','2020-05-14 07:37:28');

INSERT INTO users (`id`, `name`, `email`, `email_verified_at`, `role`, `phone`, `entreprise`, `logo`, `password`, `remember_token`, `active`, `created_at`, `updated_at`) VALUES 
('16','superadmin','superadmin@gmail.com','','superadmin','032 44 993 62','undefined','','$2y$10$1TRFxdNCxqtJkkbvayxcWOZqFOPMaTIwz3kmkvs6eEzlxT5ypxqFe','','0','2020-04-27 04:51:47','2020-05-14 08:12:56');

INSERT INTO users (`id`, `name`, `email`, `email_verified_at`, `role`, `phone`, `entreprise`, `logo`, `password`, `remember_token`, `active`, `created_at`, `updated_at`) VALUES 
('22','BOb','bob@gmail.com','','responsable','03241065435','conti','','$2y$10$KLRaKLsGbTtHgPQED.ewgOk7QvD5uWPKbrWl9t5staeAG8WSlY79y','','0','2020-05-28 11:37:30','2020-05-28 11:37:30');

INSERT INTO migrations (`id`, `migration`, `batch`) VALUES 
('1','2014_10_12_000000_create_users_table','1');

INSERT INTO migrations (`id`, `migration`, `batch`) VALUES 
('2','2014_10_12_100000_create_password_resets_table','1');

INSERT INTO migrations (`id`, `migration`, `batch`) VALUES 
('3','2019_08_19_000000_create_failed_jobs_table','1');

INSERT INTO migrations (`id`, `migration`, `batch`) VALUES 
('4','2020_04_16_191521_create_vehicules_table','1');

INSERT INTO migrations (`id`, `migration`, `batch`) VALUES 
('5','2020_04_21_171810_create_rendez_vous_table','1');

INSERT INTO migrations (`id`, `migration`, `batch`) VALUES 
('6','2020_05_01_084019_create_maintenances_table','1');

INSERT INTO migrations (`id`, `migration`, `batch`) VALUES 
('7','2020_05_04_114543_create_references_table','1');

INSERT INTO migrations (`id`, `migration`, `batch`) VALUES 
('8','2020_05_04_114618_create_stocks_table','1');

INSERT INTO migrations (`id`, `migration`, `batch`) VALUES 
('9','2020_05_16_115622_create_dates_table','1');

INSERT INTO migrations (`id`, `migration`, `batch`) VALUES 
('10','2020_05_18_125718_create_statistiques_table','1');
