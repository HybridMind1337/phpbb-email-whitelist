<?php
/**
 * Common language file for Email Whitelist.
 *
 * @package hybridmind/emailwhitelist
 */

if (!defined('IN_PHPBB'))
{
    exit;
}

$lang = array_merge($lang, array(
    'HM_EW_EMAIL_NOT_ALLOWED' => 'This email provider is not allowed. Please use an approved email provider.',
    'HM_EW_EMAIL_NOT_ALLOWED_WITH_DOMAINS' => 'This email provider is not allowed. Please register using one of the following email domains: %s.',
    'HM_EW_NO_ALLOWED_DOMAINS_PUBLIC' => 'approved email domains',
));
