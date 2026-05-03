<?php
/**
 * Initial migration for Email Whitelist.
 *
 * @package hybridmind/emailwhitelist
 */

namespace hybridmind\emailwhitelist\migrations;

class v1_0_0 extends \phpbb\db\migration\migration
{
    public function effectively_installed()
    {
        return isset($this->config['hm_emailwhitelist_enabled']);
    }

    public static function depends_on()
    {
        return array();
    }

    public function update_schema()
    {
        return array(
            'add_tables' => array(
                $this->table_prefix . 'hm_emailwhitelist_logs' => array(
                    'COLUMNS' => array(
                        'log_id'       => array('UINT', null, 'auto_increment'),
                        'email'        => array('VCHAR_UNI:255', ''),
                        'email_hash'   => array('VCHAR:64', ''),
                        'domain'       => array('VCHAR_UNI:255', ''),
                        'ip'           => array('VCHAR:45', ''),
                        'user_agent'   => array('VCHAR_UNI:255', ''),
                        'attempt_time' => array('UINT:11', 0),
                    ),
                    'PRIMARY_KEY' => 'log_id',
                    'KEYS' => array(
                        'domain'       => array('INDEX', 'domain'),
                        'attempt_time' => array('INDEX', 'attempt_time'),
                        'email_hash'   => array('INDEX', 'email_hash'),
                    ),
                ),
            ),
        );
    }

    public function revert_schema()
    {
        return array(
            'drop_tables' => array(
                $this->table_prefix . 'hm_emailwhitelist_logs',
            ),
        );
    }

    public function update_data()
    {
        return array(
            array('config.add', array('hm_emailwhitelist_enabled', 1)),
            array('config.add', array('hm_emailwhitelist_allowed_domains', "abv.bg\ngmail.com\nyahoo.com")),
            array('config.add', array('hm_emailwhitelist_show_domains', 1)),
            array('config.add', array('hm_emailwhitelist_log_enabled', 1)),
            array('config.add', array('hm_emailwhitelist_store_mode', 'masked')),
            array('config.add', array('hm_emailwhitelist_error_message', '')),

            array('module.add', array('acp', 'ACP_CAT_DOT_MODS', 'ACP_EMAILWHITELIST_TITLE')),
            array('module.add', array('acp', 'ACP_EMAILWHITELIST_TITLE', array(
                'module_basename' => '\\hybridmind\\emailwhitelist\\acp\\main_module',
                'modes'           => array('settings'),
            ))),
        );
    }
}
