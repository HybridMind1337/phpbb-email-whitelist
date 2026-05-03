<?php
/**
 * ACP Bulgarian language file for Email Whitelist.
 *
 * @package hybridmind/emailwhitelist
 */

if (!defined('IN_PHPBB'))
{
    exit;
}

$lang = array_merge($lang, array(
    'ACP_EMAILWHITELIST_TITLE' => 'Email Whitelist',
    'ACP_EMAILWHITELIST_SETTINGS' => 'Настройки',
    'ACP_EMAILWHITELIST_SETTINGS_EXPLAIN' => 'Контролира кои email домейни са позволени при регистрация.',
    'ACP_EMAILWHITELIST_EXPLAIN' => 'Позволява регистрации само от избрани email домейни и пази чисти статистики за блокираните опити.',

    'ACP_EMAILWHITELIST_OVERVIEW' => 'Общ преглед',
    'ACP_EMAILWHITELIST_STATUS' => 'Статус',
    'ACP_EMAILWHITELIST_STATUS_ACTIVE' => 'Активно',
    'ACP_EMAILWHITELIST_STATUS_DISABLED' => 'Изключено',
    'ACP_EMAILWHITELIST_ALLOWED_DOMAINS_COUNT' => 'Позволени домейни',
    'ACP_EMAILWHITELIST_NO_ALLOWED_DOMAINS' => 'Няма настроени позволени домейни',
    'ACP_EMAILWHITELIST_LOGGING_STATUS' => 'Логване',
    'ACP_EMAILWHITELIST_LOGGING_ENABLED' => 'Включено',
    'ACP_EMAILWHITELIST_LOGGING_DISABLED' => 'Изключено',
    'ACP_EMAILWHITELIST_PUBLIC_ERROR' => 'Публична грешка',
    'ACP_EMAILWHITELIST_DOMAINS_VISIBLE' => 'Домейните се показват',
    'ACP_EMAILWHITELIST_DOMAINS_HIDDEN' => 'Домейните са скрити',
    'ACP_EMAILWHITELIST_ALLOWED_PREVIEW' => 'Преглед на позволените домейни',
    'ACP_EMAILWHITELIST_EXAMPLES' => 'Примери',

    'ACP_EMAILWHITELIST_ENABLE' => 'Активирай email whitelist',
    'ACP_EMAILWHITELIST_ENABLE_EXPLAIN' => 'Когато е включено, потребителите могат да се регистрират само с email домейните, посочени по-долу.',

    'ACP_EMAILWHITELIST_ALLOWED_DOMAINS' => 'Позволени email домейни',
    'ACP_EMAILWHITELIST_ALLOWED_DOMAINS_EXPLAIN' => 'Въведете по един домейн на ред. Позволени са също запетаи и точка и запетая. Поддържат се wildcard домейни като *.example.com за поддомейни.',

    'ACP_EMAILWHITELIST_SHOW_DOMAINS' => 'Показвай позволените домейни в съобщението за грешка',
    'ACP_EMAILWHITELIST_SHOW_DOMAINS_EXPLAIN' => 'Ако е включено, блокираните потребители ще виждат списъка с позволени домейни при регистрация.',

    'ACP_EMAILWHITELIST_ERROR_MESSAGE' => 'Custom съобщение за грешка',
    'ACP_EMAILWHITELIST_ERROR_MESSAGE_EXPLAIN' => 'По желание. Използвайте {DOMAINS}, където трябва да се покаже списъкът с позволени домейни. Оставете празно, за да се използва стандартното преведено съобщение.',

    'ACP_EMAILWHITELIST_LOGGING' => 'Логове и поверителност',
    'ACP_EMAILWHITELIST_LOGGING_EXPLAIN' => 'Изберете дали блокираните опити да се записват и колко email информация да се пази.',
    'ACP_EMAILWHITELIST_LOG_ENABLE' => 'Записвай блокираните опити',
    'ACP_EMAILWHITELIST_LOG_ENABLE_EXPLAIN' => 'Ако е включено, блокираните email домейни се записват за статистики и преглед от администрацията.',
    'ACP_EMAILWHITELIST_STORE_MODE' => 'Начин на съхранение на email',
    'ACP_EMAILWHITELIST_STORE_MODE_EXPLAIN' => 'Изберете колко информация за email адреса да се пази в логовете.',
    'ACP_EMAILWHITELIST_STORE_NONE' => 'Не пази email адреса',
    'ACP_EMAILWHITELIST_STORE_MASKED' => 'Пази маскиран email адрес',
    'ACP_EMAILWHITELIST_STORE_FULL' => 'Пази пълния email адрес',
    'ACP_EMAILWHITELIST_STORE_FULL_WARNING' => 'Пълното съхранение на email може да съдържа лични данни. Използвай го само ако наистина ти трябва за модерация или security review.',

    'ACP_EMAILWHITELIST_STATS' => 'Статистики',
    'ACP_EMAILWHITELIST_TOTAL_BLOCKED' => 'Общо блокирани опити',
    'ACP_EMAILWHITELIST_TODAY_BLOCKED' => 'Блокирани днес',
    'ACP_EMAILWHITELIST_LAST_7_DAYS_BLOCKED' => 'Блокирани за последните 7 дни',
    'ACP_EMAILWHITELIST_TOP_DOMAINS' => 'Най-често блокирани домейни',
    'ACP_EMAILWHITELIST_TOP_DOMAINS_EXPLAIN' => 'Домейни, които най-често са били спрени от whitelist проверката.',
    'ACP_EMAILWHITELIST_LATEST_ATTEMPTS' => 'Последни блокирани опити',
    'ACP_EMAILWHITELIST_LATEST_ATTEMPTS_EXPLAIN' => 'Последни регистрации, блокирани от whitelist системата.',
    'ACP_EMAILWHITELIST_NO_STATS' => 'Все още няма налични статистики.',
    'ACP_EMAILWHITELIST_NO_LOGS' => 'Все още няма записани блокирани опити.',

    'ACP_EMAILWHITELIST_EMAIL' => 'Email',
    'ACP_EMAILWHITELIST_DOMAIN' => 'Домейн',
    'ACP_EMAILWHITELIST_IP' => 'IP адрес',
    'ACP_EMAILWHITELIST_DATE' => 'Дата',
    'ACP_EMAILWHITELIST_USER_AGENT' => 'User agent',
    'ACP_EMAILWHITELIST_ATTEMPTS' => 'Опити',
    'ACP_EMAILWHITELIST_EMAIL_NOT_STORED' => 'Не се пази',

    'ACP_EMAILWHITELIST_HELP_TITLE' => 'Как работи',
    'ACP_EMAILWHITELIST_HELP_TEXT' => 'При регистрация разширението взима домейна след @ и го сравнява с позволения списък. Ако домейнът не е позволен, регистрацията се спира и потребителят получава настроеното съобщение.',

    'ACP_EMAILWHITELIST_CLEAR_LOGS' => 'Изчисти логовете',
    'ACP_EMAILWHITELIST_CLEAR_LOGS_CONFIRM' => 'Сигурен ли си, че искаш да изчистиш всички логове за блокирани email-и?',
    'ACP_EMAILWHITELIST_LOGS_CLEARED' => 'Логовете за блокирани email-и бяха изчистени успешно.',
    'ACP_EMAILWHITELIST_SAVED' => 'Настройките на Email Whitelist бяха запазени успешно.',
    'ACP_EMAILWHITELIST_EMPTY_DOMAINS_ERROR' => 'Не можеш да активираш whitelist-а без поне един валиден позволен домейн.',
));
