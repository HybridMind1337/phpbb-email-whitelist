<?php
/**
 * Common Bulgarian language file for Email Whitelist.
 *
 * @package hybridmind/emailwhitelist
 */

if (!defined('IN_PHPBB'))
{
    exit;
}

$lang = array_merge($lang, array(
    'HM_EW_EMAIL_NOT_ALLOWED' => 'Този email доставчик не е позволен. Моля, използвайте одобрен email доставчик.',
    'HM_EW_EMAIL_NOT_ALLOWED_WITH_DOMAINS' => 'Този email доставчик не е позволен. Моля, регистрирайте се с един от следните email домейни: %s.',
    'HM_EW_NO_ALLOWED_DOMAINS_PUBLIC' => 'одобрени email домейни',
));
