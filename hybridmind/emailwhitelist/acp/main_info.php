<?php
/**
 * ACP info for Email Whitelist.
 *
 * @package hybridmind/emailwhitelist
 */

namespace hybridmind\emailwhitelist\acp;

class main_info
{
    public function module()
    {
        return array(
            'filename' => '\\hybridmind\\emailwhitelist\\acp\\main_module',
            'title'    => 'ACP_EMAILWHITELIST_TITLE',
            'modes'    => array(
                'settings' => array(
                    'title' => 'ACP_EMAILWHITELIST_SETTINGS',
                    'auth'  => 'ext_hybridmind/emailwhitelist && acl_a_board',
                    'cat'   => array('ACP_EMAILWHITELIST_TITLE'),
                ),
            ),
        );
    }
}
