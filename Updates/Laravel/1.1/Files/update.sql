
-- ================== version 1.1 ==================
CREATE TABLE `coupons` (
  `id` bigint NOT NULL,
  `code` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1=fixed,2=percent',
  `amount` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `min_purchase_amount` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `start_date` datetime DEFAULT NULL,
  `end_date` datetime DEFAULT NULL,
  `use_limit` int NOT NULL DEFAULT '0',
  `per_user_limit` int NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1=available,0=disable',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

ALTER TABLE `coupons`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `coupons`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT;
COMMIT;

ALTER TABLE `plan_purchases` ADD `coupon_id` BIGINT UNSIGNED NOT NULL DEFAULT '0' AFTER `user_id`;
ALTER TABLE `deposits` ADD `coupon_id` BIGINT UNSIGNED NOT NULL DEFAULT '0' AFTER `plan_id`;

ALTER TABLE `general_settings` 
  ADD `meta_app_id` VARCHAR(255) NULL DEFAULT NULL AFTER `webhook_verify_token`, 
  ADD `meta_app_secret` TEXT NULL DEFAULT NULL AFTER `meta_app_id`,
  Add `meta_configuration_id` TEXT NULL DEFAULT NULL AFTER `meta_app_secret`,
  ADD `whatsapp_embedded_signup` TINYINT(1) NOT NULL DEFAULT '0' COMMENT '0=disable,1=enable' AFTER `webhook_verify_token`;


ALTER TABLE `admins` ADD `status` TINYINT(1) NOT NULL DEFAULT '1' COMMENT '1=active,0=disable' AFTER `remember_token`;


CREATE TABLE `roles` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `roles` (`id`, `name`, `guard_name`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin', 'admin', 1, NOW(), NOW());

ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

ALTER TABLE `roles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;




CREATE TABLE `permissions` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `group_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `group_name`, `created_at`, `updated_at`) VALUES
(1, 'view users', 'admin', 'manage user', '2025-08-18 14:14:01', '2025-08-18 14:14:01'),
(2, 'view user agents', 'admin', 'manage user', '2025-08-18 14:14:01', '2025-08-18 14:14:01'),
(3, 'send user notification', 'admin', 'manage user', '2025-08-18 14:14:01', '2025-08-18 14:14:01'),
(4, 'view user notifications', 'admin', 'manage user', '2025-08-18 14:14:01', '2025-08-18 14:14:01'),
(5, 'update user balance', 'admin', 'manage user', '2025-08-18 14:14:01', '2025-08-18 14:14:01'),
(6, 'ban user', 'admin', 'manage user', '2025-08-18 14:14:01', '2025-08-18 14:14:01'),
(7, 'login as user', 'admin', 'manage user', '2025-08-18 14:14:01', '2025-08-18 14:14:01'),
(8, 'update user', 'admin', 'manage user', '2025-08-18 14:14:01', '2025-08-18 14:14:01'),
(9, 'view pricing plans', 'admin', 'pricing plan', '2025-08-18 14:14:01', '2025-08-18 14:14:01'),
(10, 'add pricing plan', 'admin', 'pricing plan', '2025-08-18 14:14:01', '2025-08-18 14:14:01'),
(11, 'edit pricing plan', 'admin', 'pricing plan', '2025-08-18 14:14:01', '2025-08-18 14:14:01'),
(12, 'view contact', 'admin', 'system data', '2025-08-18 14:14:01', '2025-08-18 14:14:01'),
(13, 'view contact list', 'admin', 'system data', '2025-08-18 14:14:01', '2025-08-18 14:14:01'),
(14, 'view contact tag', 'admin', 'system data', '2025-08-18 14:14:01', '2025-08-18 14:14:01'),
(15, 'view campaign', 'admin', 'system data', '2025-08-18 14:14:01', '2025-08-18 14:14:01'),
(16, 'view chatbot', 'admin', 'system data', '2025-08-18 14:14:01', '2025-08-18 14:14:01'),
(17, 'view short link', 'admin', 'system data', '2025-08-18 14:14:01', '2025-08-18 14:14:01'),
(18, 'view deposit', 'admin', 'deposit', '2025-08-18 14:14:01', '2025-08-18 14:14:01'),
(19, 'approve deposit', 'admin', 'deposit', '2025-08-18 14:14:01', '2025-08-18 14:14:01'),
(20, 'reject deposit', 'admin', 'deposit', '2025-08-18 14:14:01', '2025-08-18 14:14:01'),
(21, 'view withdraw', 'admin', 'withdraw', '2025-08-18 14:14:01', '2025-08-18 14:14:01'),
(22, 'approve withdraw', 'admin', 'withdraw', '2025-08-18 14:14:01', '2025-08-18 14:14:01'),
(23, 'reject withdraw', 'admin', 'withdraw', '2025-08-18 14:14:01', '2025-08-18 14:14:01'),
(24, 'view admin', 'admin', 'admin', '2025-08-18 14:14:01', '2025-08-18 14:14:01'),
(25, 'add admin', 'admin', 'admin', '2025-08-18 14:14:01', '2025-08-18 14:14:01'),
(26, 'edit admin', 'admin', 'admin', '2025-08-18 14:14:01', '2025-08-18 14:14:01'),
(27, 'view roles', 'admin', 'role', '2025-08-18 14:14:01', '2025-08-18 14:14:01'),
(28, 'add role', 'admin', 'role', '2025-08-18 14:14:01', '2025-08-18 14:14:01'),
(29, 'edit role', 'admin', 'role', '2025-08-18 14:14:01', '2025-08-18 14:14:01'),
(30, 'assign permissions', 'admin', 'role', '2025-08-18 14:14:01', '2025-08-18 14:14:01'),
(31, 'manage gateways', 'admin', 'gateway', '2025-08-18 14:14:01', '2025-08-18 14:14:01'),
(32, 'manage withdraw methods', 'admin', 'gateway', '2025-08-18 14:14:01', '2025-08-18 14:14:01'),
(33, 'update general settings', 'admin', 'setting', '2025-08-18 14:14:01', '2025-08-18 14:14:01'),
(34, 'update brand settings', 'admin', 'setting', '2025-08-18 14:14:01', '2025-08-18 14:14:01'),
(35, 'system configuration', 'admin', 'setting', '2025-08-18 14:14:01', '2025-08-18 14:14:01'),
(36, 'pusher configuration', 'admin', 'setting', '2025-08-18 14:14:01', '2025-08-18 14:14:01'),
(37, 'notification settings', 'admin', 'setting', '2025-08-18 14:14:01', '2025-08-18 14:14:01'),
(38, 'kyc settings', 'admin', 'setting', '2025-08-18 14:14:01', '2025-08-18 14:14:01'),
(39, 'update maintenance mode', 'admin', 'setting', '2025-08-18 14:14:01', '2025-08-18 14:14:01'),
(40, 'social login settings', 'admin', 'setting', '2025-08-18 14:14:01', '2025-08-18 14:14:01'),
(41, 'seo settings', 'admin', 'setting', '2025-08-18 14:14:01', '2025-08-18 14:14:01'),
(42, 'in app payment settings', 'admin', 'setting', '2025-08-18 14:14:01', '2025-08-18 14:14:01'),
(43, 'view all transactions', 'admin', 'report', '2025-08-18 14:14:01', '2025-08-18 14:14:01'),
(44, 'view user transactions', 'admin', 'report', '2025-08-18 14:14:01', '2025-08-18 14:14:01'),
(45, 'view login history', 'admin', 'report', '2025-08-18 14:14:01', '2025-08-18 14:14:01'),
(46, 'view subscription history', 'admin', 'report', '2025-08-18 14:14:01', '2025-08-18 14:14:01'),
(47, 'view all notifications', 'admin', 'report', '2025-08-18 14:14:01', '2025-08-18 14:14:01'),
(48, 'view tickets', 'admin', 'support ticket', '2025-08-18 14:14:01', '2025-08-18 14:14:01'),
(49, 'answer tickets', 'admin', 'support ticket', '2025-08-18 14:14:01', '2025-08-18 14:14:01'),
(50, 'close tickets', 'admin', 'support ticket', '2025-08-18 14:14:01', '2025-08-18 14:14:01'),
(51, 'manage pages', 'admin', 'manage content', '2025-08-18 14:14:01', '2025-08-18 14:14:01'),
(52, 'manage sections', 'admin', 'manage content', '2025-08-18 14:14:01', '2025-08-18 14:14:01'),
(53, 'view dashboard', 'admin', 'other', '2025-08-18 14:14:01', '2025-08-18 14:14:01'),
(54, 'manage extensions', 'admin', 'other', '2025-08-18 14:14:01', '2025-08-18 14:14:01'),
(55, 'manage languages', 'admin', 'other', '2025-08-18 14:14:01', '2025-08-18 14:14:01'),
(56, 'manage subscribers', 'admin', 'other', '2025-08-18 14:14:01', '2025-08-18 14:14:01'),
(57, 'view application info', 'admin', 'other', '2025-08-18 14:14:01', '2025-08-18 14:14:01'),
(58, 'custom css', 'admin', 'other', '2025-08-18 14:14:01', '2025-08-18 14:14:01'),
(59, 'manage cron job', 'admin', 'other', '2025-08-18 14:14:01', '2025-08-18 14:14:01'),
(60, 'sitemap xml', 'admin', 'other', '2025-08-18 14:14:01', '2025-08-18 14:14:01'),
(61, 'robots txt', 'admin', 'other', '2025-08-18 14:14:01', '2025-08-18 14:14:01'),
(65, 'add coupon', 'admin', 'coupon', '2025-08-24 07:37:14', '2025-08-24 07:37:14'),
(66, 'edit coupon', 'admin', 'coupon', '2025-08-24 07:37:14', '2025-08-24 07:37:14'),
(67, 'cookie settings', 'admin', 'other', '2025-08-24 07:37:14', '2025-08-24 07:37:14'),
(68, 'view coupon', 'admin', 'coupon', '2025-08-24 07:37:46', '2025-08-24 07:37:46');

ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `permissions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;
COMMIT;




CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;
COMMIT;


CREATE TABLE IF NOT EXISTS `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_roles_role_id_foreign` 
    FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `roles` (`name`, `guard_name`, `status`, `created_at`, `updated_at`)
SELECT 'Super Admin', 'admin', 1, NOW(), NOW()
WHERE NOT EXISTS (
    SELECT 1 FROM `roles` WHERE `name` = 'Super Admin' AND `guard_name` = 'admin'
);

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`)
SELECT `id`, 'App\\Models\\Admin', 1
FROM `roles`
WHERE `name` = 'Super Admin' AND `guard_name` = 'admin'
ON DUPLICATE KEY UPDATE role_id = role_id;

COMMIT;



CREATE TABLE `role_has_permissions` (
  `permission_id` bigint UNSIGNED NOT NULL,
  `role_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 1),
(5, 1),
(6, 1),
(7, 1),
(8, 1),
(9, 1),
(10, 1),
(11, 1),
(12, 1),
(13, 1),
(14, 1),
(15, 1),
(16, 1),
(17, 1),
(18, 1),
(19, 1),
(20, 1),
(21, 1),
(22, 1),
(23, 1),
(24, 1),
(25, 1),
(26, 1),
(27, 1),
(28, 1),
(29, 1),
(30, 1),
(31, 1),
(32, 1),
(33, 1),
(34, 1),
(35, 1),
(36, 1),
(37, 1),
(38, 1),
(39, 1),
(40, 1),
(41, 1),
(42, 1),
(43, 1),
(44, 1),
(45, 1),
(46, 1),
(47, 1),
(48, 1),
(49, 1),
(50, 1),
(51, 1),
(52, 1),
(53, 1),
(54, 1),
(55, 1),
(56, 1),
(57, 1),
(58, 1),
(59, 1),
(60, 1),
(61, 1),
(65, 1),
(66, 1),
(67, 1),
(68, 1);
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;
COMMIT;


ALTER TABLE `pricing_plans` CHANGE `campaign_limit` `campaign_limit` INT NOT NULL DEFAULT '0'; 

INSERT INTO `cron_jobs` (`name`, `alias`, `action`, `url`, `cron_schedule_id`, `next_run`, `last_run`, `is_running`, `is_default`, `created_at`, `updated_at`) VALUES
('Coupon Expiration', 'coupon_expiration', '[\"\\\\App\\\\Http\\\\Controllers\\\\CronController\",\"couponExpiration\"]', '', 3, '2025-04-15 14:43:43', '2025-04-14 14:43:43', 1, 1, '2024-09-09 03:36:44', '2025-04-14 08:43:43');