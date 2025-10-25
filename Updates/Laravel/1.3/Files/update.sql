
-- ==================== Version 1.3 ======================
CREATE TABLE `cta_urls` (
  `id` bigint NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL DEFAULT '0',
  `name` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cta_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `header_format` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `header` text COLLATE utf8mb4_unicode_ci,
  `body` text COLLATE utf8mb4_unicode_ci,
  `action` text COLLATE utf8mb4_unicode_ci,
  `footer` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

ALTER TABLE `cta_urls`
  ADD PRIMARY KEY (`id`);

  ALTER TABLE `cta_urls`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT;
COMMIT;

ALTER TABLE `messages` ADD `agent_id` BIGINT UNSIGNED NOT NULL DEFAULT '0' AFTER `conversation_id`, ADD `cta_url_id` BIGINT UNSIGNED NOT NULL DEFAULT '0' AFTER `agent_id`;

INSERT INTO `agent_permissions` (`id`, `name`, `guard_name`, `group_name`, `created_at`, `updated_at`) 
VALUES
    (NULL, 'view contact name', 'web', 'whatsapp', NULL, NULL),
    (NULL, 'view contact mobile', 'web', 'whatsapp', NULL, NULL),
    (NULL, 'view contact profile', 'web', 'whatsapp', NULL, NULL),
    (NULL, 'view cta url', 'web', 'cta url', NULL, NULL),
    (NULL, 'add cta url', 'web', 'cta url', NULL, NULL),
    (NULL, 'delete cta url', 'web', 'cta url', NULL, NULL);


ALTER TABLE `messages` CHANGE `media_caption` `media_caption` LONGTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL;

CREATE TABLE `template_cards` (
  `id` bigint NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL DEFAULT '0',
  `template_id` bigint UNSIGNED NOT NULL DEFAULT '0',
  `header_format` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT 'IMAGE' COMMENT 'IMAGE or VIDEO',
  `header` text COLLATE utf8mb4_unicode_ci,
  `buttons` text COLLATE utf8mb4_unicode_ci,
  `media_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

ALTER TABLE `template_cards`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `template_cards`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT;
COMMIT;

INSERT INTO `notification_templates` (`id`, `act`, `name`, `subject`, `push_title`, `email_body`, `sms_body`, `push_body`, `shortcodes`, `email_status`, `email_sent_from_name`, `email_sent_from_address`, `sms_status`, `sms_sent_from`, `push_status`, `created_at`, `updated_at`) VALUES
(NULL, 'TEMPLATE_APPROVE', 'Whatsapp Template - Approved', 'WhatsApp message template approved', '{{site_name}} - WhatsApp Template Approved', '<div>We are writing to inform you that your WhatsApp message template has been approved by Meta. Now you can send this template to your customers.</div><div><br></div><div>Below are the details of your teamplate:</div><div><br></div><div><b>Name:</b> {{name}}</div><div><b>Template ID: </b>{{template_id}}</div><div><b>Approve Date: </b>{{time}}</div><div><br></div><div>Should you have any questions or require further assistance, feel free to reach out to our support team. We\'re here to help.</div>', 'Your submission for a WhatsApp message template has been approved.', 'Your WhatsApp message template has been approved', '{ \"name\" : \"Name of the whatsapp template\", \"template_id\" : \"Template ID\", \"time\" : \"Time\" }', '1', '{{site_name}} Verification Center', NULL, '1', NULL, '0', '2021-11-03 18:00:00', '2025-09-20 13:26:26'),
(NULL, 'TEMPLATE_REJECTED', 'Whatsapp Template - Rejected', 'WhatsApp message template rejected', '{{site_name}} - WhatsApp Template Rejected', '<div>We are writing to inform you that your WhatsApp message template has been rejected by Meta.</div><div><br></div><div>Below are the details of your teamplate:</div><div><br></div><div><b>Name:</b> {{name}}</div><div><b>Template ID: </b>{{template_id}}</div><div><b>Reason:&nbsp;</b><span style=\"display: inline !important;\">{{reason}}</span></div><div><b>Rejected Date: </b>{{time}}</div><div><br></div><div>Should you have any questions or require further assistance, feel free to reach out to our support team. We\'re here to help.</div>', 'Your submission for a WhatsApp message template has been rejected.', 'Your WhatsApp message template has been rejected', '{ \"name\": \"Name of the whatsapp template\", \"template_id\": \"Template ID\", \"time\": \"Time\", \"reason\": \"Reason provided by meta\" }', '1', '{{site_name}} Verification Center', NULL, '1', NULL, '0', '2021-11-03 18:00:00', '2025-09-22 01:39:23');

CREATE TABLE `ai_assistants` (
  `id` bigint NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `info` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `provider` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `config` text COLLATE utf8mb4_unicode_ci,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1=enable,0=disable',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


INSERT INTO `ai_assistants` (`id`, `name`, `info`, `provider`, `config`, `url`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Open AI', 'OpenAI provides advanced AI models capable of generating human-like text. It powers chatbots, content creation.', 'openai', '{\"api_key\":\"------------------\",\"model\":\"-------\",\"temperature\":\"0.7\"}', 'https://platform.openai.com/api-keys', 0, NULL, '2025-09-30 13:49:07'),
(2, 'Google Gemini', 'Google Gemini delivers powerful AI models designed for reasoning. It supports chat, content generation, and automation.', 'gemini', '{\"api_key\":\"-------------\",\"temperature\":\"0.7\",\"model\":\"----------\",\"max_output_tokens\":\"512\"}', 'https://aistudio.google.com/app/api-keys', 0, NULL, '2025-09-30 13:49:07');

ALTER TABLE `ai_assistants`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `ai_assistants`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

ALTER TABLE `templates` ADD `rejected_reason` VARCHAR(255) NULL DEFAULT NULL AFTER `status`;
ALTER TABLE `plan_purchases` ADD `discount_amount` DECIMAL(28,8) NOT NULL DEFAULT '0' AFTER `amount`;

ALTER TABLE `pricing_plans` ADD `ai_assistance` TINYINT(1) NOT NULL DEFAULT '0' COMMENT '1=yes,0=no' AFTER `welcome_message`;
ALTER TABLE `users` ADD `ai_assistance` TINYINT(1) NOT NULL DEFAULT '0' COMMENT '1=yes,0=no' AFTER `welcome_message`;

ALTER TABLE `pricing_plans` ADD `cta_url_message` TINYINT(1) NOT NULL DEFAULT '0' COMMENT '1=yes,0=no' AFTER `ai_assistance`;
ALTER TABLE `users` ADD `cta_url_message` TINYINT(1) NOT NULL DEFAULT '0' COMMENT '1=available,0=not available' AFTER `ai_assistance`; 

ALTER TABLE `conversations` ADD `needs_human_reply` TINYINT(1) NOT NULL DEFAULT '0' COMMENT '1=yes,0=no' AFTER `last_message_at`;

ALTER TABLE `messages` ADD `ai_reply` TINYINT(1) NOT NULL DEFAULT '0' COMMENT '1=yes,0=no' AFTER `ordering`;

INSERT INTO `agent_permissions` (`id`, `name`, `guard_name`, `group_name`, `created_at`, `updated_at`) VALUES (NULL, 'ai assistant settings', 'web', 'ai assistant', NULL, NULL);


CREATE TABLE `ai_user_settings` (
  `id` bigint NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL DEFAULT '0',
  `system_prompt` longtext COLLATE utf8mb4_unicode_ci,
  `fallback_response` longtext COLLATE utf8mb4_unicode_ci,
  `max_length` int NOT NULL DEFAULT '512' COMMENT 'Max length of reply',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1=on,0=off',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


ALTER TABLE `ai_user_settings`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `ai_user_settings`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `group_name`, `created_at`, `updated_at`) VALUES (69, 'ai assistant settings', 'admin', 'setting', NULL, NULL);
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES ('69', '1');

UPDATE `ai_assistants` SET `config` = '{\"api_key\":\"------------------\",\"model\":\"gpt-4o-mini\",\"temperature\":\"0.7\"}' WHERE `ai_assistants`.`id` = 1; 
UPDATE `ai_assistants` SET `config` = '{\"api_key\":\"-------------\",\"temperature\":\"0.7\",\"model\":\"gemini-2.5-flash\",\"max_output_tokens\":\"512\"}' WHERE `ai_assistants`.`id` = 2; 