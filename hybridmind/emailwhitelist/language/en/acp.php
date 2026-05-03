<?php
/**
 * ACP language file for Email Whitelist.
 *
 * @package hybridmind/emailwhitelist
 */

if (!defined('IN_PHPBB'))
{
    exit;
}

$lang = array_merge($lang, array(
    'ACP_EMAILWHITELIST_TITLE' => 'Email Whitelist',
    'ACP_EMAILWHITELIST_SETTINGS' => 'Settings',
    'ACP_EMAILWHITELIST_SETTINGS_EXPLAIN' => 'Control which email domains are allowed during registration.',
    'ACP_EMAILWHITELIST_EXPLAIN' => 'Allow registrations only from selected email domains and keep clean statistics for blocked attempts.',

    'ACP_EMAILWHITELIST_OVERVIEW' => 'Overview',
    'ACP_EMAILWHITELIST_STATUS' => 'Status',
    'ACP_EMAILWHITELIST_STATUS_ACTIVE' => 'Active',
    'ACP_EMAILWHITELIST_STATUS_DISABLED' => 'Disabled',
    'ACP_EMAILWHITELIST_ALLOWED_DOMAINS_COUNT' => 'Allowed domains',
    'ACP_EMAILWHITELIST_NO_ALLOWED_DOMAINS' => 'No allowed domains configured',
    'ACP_EMAILWHITELIST_LOGGING_STATUS' => 'Logging',
    'ACP_EMAILWHITELIST_LOGGING_ENABLED' => 'Enabled',
    'ACP_EMAILWHITELIST_LOGGING_DISABLED' => 'Disabled',
    'ACP_EMAILWHITELIST_PUBLIC_ERROR' => 'Public error',
    'ACP_EMAILWHITELIST_DOMAINS_VISIBLE' => 'Domains visible',
    'ACP_EMAILWHITELIST_DOMAINS_HIDDEN' => 'Domains hidden',
    'ACP_EMAILWHITELIST_ALLOWED_PREVIEW' => 'Allowed domain preview',
    'ACP_EMAILWHITELIST_EXAMPLES' => 'Examples',

    'ACP_EMAILWHITELIST_ENABLE' => 'Enable email whitelist',
    'ACP_EMAILWHITELIST_ENABLE_EXPLAIN' => 'When enabled, users can register only with email domains listed below.',

    'ACP_EMAILWHITELIST_ALLOWED_DOMAINS' => 'Allowed email domains',
    'ACP_EMAILWHITELIST_ALLOWED_DOMAINS_EXPLAIN' => 'Enter one domain per line. Commas and semicolons are also accepted. Wildcards such as *.example.com are supported for subdomains.',

    'ACP_EMAILWHITELIST_SHOW_DOMAINS' => 'Show allowed domains in error message',
    'ACP_EMAILWHITELIST_SHOW_DOMAINS_EXPLAIN' => 'If enabled, blocked users will see the list of allowed domains in the registration error message.',

    'ACP_EMAILWHITELIST_ERROR_MESSAGE' => 'Custom error message',
    'ACP_EMAILWHITELIST_ERROR_MESSAGE_EXPLAIN' => 'Optional. Use {DOMAINS} where the allowed domain list should appear. Leave empty to use the default translated message.',

    'ACP_EMAILWHITELIST_LOGGING' => 'Logging and privacy',
    'ACP_EMAILWHITELIST_LOGGING_EXPLAIN' => 'Choose if blocked attempts should be stored and how much email data should be retained.',
    'ACP_EMAILWHITELIST_LOG_ENABLE' => 'Log blocked attempts',
    'ACP_EMAILWHITELIST_LOG_ENABLE_EXPLAIN' => 'If enabled, blocked email domains are stored for statistics and moderation review.',
    'ACP_EMAILWHITELIST_STORE_MODE' => 'Email storage mode',
    'ACP_EMAILWHITELIST_STORE_MODE_EXPLAIN' => 'Choose how much email information is stored in the blocked attempts log.',
    'ACP_EMAILWHITELIST_STORE_NONE' => 'Do not store email address',
    'ACP_EMAILWHITELIST_STORE_MASKED' => 'Store masked email address',
    'ACP_EMAILWHITELIST_STORE_FULL' => 'Store full email address',
    'ACP_EMAILWHITELIST_STORE_FULL_WARNING' => 'Full email storage can contain personal data. Use it only if you really need it for moderation or security review.',

    'ACP_EMAILWHITELIST_STATS' => 'Statistics',
    'ACP_EMAILWHITELIST_TOTAL_BLOCKED' => 'Total blocked attempts',
    'ACP_EMAILWHITELIST_TODAY_BLOCKED' => 'Blocked today',
    'ACP_EMAILWHITELIST_LAST_7_DAYS_BLOCKED' => 'Blocked in the last 7 days',
    'ACP_EMAILWHITELIST_TOP_DOMAINS' => 'Most blocked domains',
    'ACP_EMAILWHITELIST_TOP_DOMAINS_EXPLAIN' => 'Domains that failed the whitelist check most often.',
    'ACP_EMAILWHITELIST_LATEST_ATTEMPTS' => 'Latest blocked attempts',
    'ACP_EMAILWHITELIST_LATEST_ATTEMPTS_EXPLAIN' => 'Recent registration attempts blocked by the whitelist.',
    'ACP_EMAILWHITELIST_NO_STATS' => 'No statistics available yet.',
    'ACP_EMAILWHITELIST_NO_LOGS' => 'No blocked attempts have been logged yet.',

    'ACP_EMAILWHITELIST_EMAIL' => 'Email',
    'ACP_EMAILWHITELIST_DOMAIN' => 'Domain',
    'ACP_EMAILWHITELIST_IP' => 'IP address',
    'ACP_EMAILWHITELIST_DATE' => 'Date',
    'ACP_EMAILWHITELIST_USER_AGENT' => 'User agent',
    'ACP_EMAILWHITELIST_ATTEMPTS' => 'Attempts',
    'ACP_EMAILWHITELIST_EMAIL_NOT_STORED' => 'Not stored',

    'ACP_EMAILWHITELIST_HELP_TITLE' => 'How it works',
    'ACP_EMAILWHITELIST_HELP_TEXT' => 'During registration, the extension extracts the domain after @ and compares it with your allowed list. If the domain is not allowed, registration is stopped and the user receives your configured message.',

    'ACP_EMAILWHITELIST_CLEAR_LOGS' => 'Clear logs',
    'ACP_EMAILWHITELIST_CLEAR_LOGS_CONFIRM' => 'Are you sure you want to clear all blocked email logs?',
    'ACP_EMAILWHITELIST_LOGS_CLEARED' => 'Blocked email logs have been cleared successfully.',
    'ACP_EMAILWHITELIST_SAVED' => 'Email whitelist settings have been saved successfully.',
    'ACP_EMAILWHITELIST_EMPTY_DOMAINS_ERROR' => 'You cannot enable the whitelist without at least one valid allowed domain.',
));
