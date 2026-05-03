<?php
/**
 * ACP module for Email Whitelist.
 *
 * @package hybridmind/emailwhitelist
 */

namespace hybridmind\emailwhitelist\acp;

class main_module
{
    /** @var string */
    public $u_action;

    /** @var string */
    public $tpl_name;

    /** @var string */
    public $page_title;

    public function main($id, $mode)
    {
        global $phpbb_container, $template, $request, $user, $config;

        $user->add_lang_ext('hybridmind/emailwhitelist', 'acp');

        $this->tpl_name = 'acp_emailwhitelist';
        $this->page_title = $user->lang('ACP_EMAILWHITELIST_TITLE');

        /** @var \hybridmind\emailwhitelist\service\domain_manager $domain_manager */
        $domain_manager = $phpbb_container->get('hybridmind.emailwhitelist.domain_manager');

        /** @var \hybridmind\emailwhitelist\service\log_repository $log_repository */
        $log_repository = $phpbb_container->get('hybridmind.emailwhitelist.log_repository');

        $form_key = 'hm_emailwhitelist_acp';
        add_form_key($form_key);

        if ($request->is_set_post('submit') || $request->is_set_post('clear_logs'))
        {
            if (!check_form_key($form_key))
            {
                trigger_error($user->lang('FORM_INVALID') . adm_back_link($this->u_action), E_USER_WARNING);
            }
        }

        if ($request->is_set_post('clear_logs'))
        {
            $log_repository->clear();
            trigger_error($user->lang('ACP_EMAILWHITELIST_LOGS_CLEARED') . adm_back_link($this->u_action));
        }

        if ($request->is_set_post('submit'))
        {
            $enabled = (int) $request->variable('enabled', 0);
            $allowed_domains_raw = $request->variable('allowed_domains', '', true);
            $show_domains = (int) $request->variable('show_domains', 0);
            $log_enabled = (int) $request->variable('log_enabled', 0);
            $store_mode = $request->variable('store_mode', 'masked');
            $error_message = trim($request->variable('error_message', '', true));

            if (!in_array($store_mode, array('none', 'masked', 'full'), true))
            {
                $store_mode = 'masked';
            }

            $allowed_domains = $domain_manager->domains_to_config_value($allowed_domains_raw);
            if ($enabled && $allowed_domains === '')
            {
                trigger_error($user->lang('ACP_EMAILWHITELIST_EMPTY_DOMAINS_ERROR') . adm_back_link($this->u_action), E_USER_WARNING);
            }

            if (function_exists('set_config'))
            {
                set_config('hm_emailwhitelist_enabled', $enabled);
                set_config('hm_emailwhitelist_allowed_domains', $allowed_domains);
                set_config('hm_emailwhitelist_show_domains', $show_domains);
                set_config('hm_emailwhitelist_log_enabled', $log_enabled);
                set_config('hm_emailwhitelist_store_mode', $store_mode);
                set_config('hm_emailwhitelist_error_message', $error_message);
            }

            trigger_error($user->lang('ACP_EMAILWHITELIST_SAVED') . adm_back_link($this->u_action));
        }

        $store_mode = (string) ($config['hm_emailwhitelist_store_mode'] ?? 'masked');
        if (!in_array($store_mode, array('none', 'masked', 'full'), true))
        {
            $store_mode = 'masked';
        }

        $allowed_domains_config = (string) ($config['hm_emailwhitelist_allowed_domains'] ?? '');
        $allowed_domains = $domain_manager->normalize_domains($allowed_domains_config);
        $allowed_domains_count = count($allowed_domains);
        $allowed_domains_preview = !empty($allowed_domains) ? implode(', ', $allowed_domains) : $user->lang('ACP_EMAILWHITELIST_NO_ALLOWED_DOMAINS');

        $enabled = !empty($config['hm_emailwhitelist_enabled']);
        $show_domains = !empty($config['hm_emailwhitelist_show_domains']);
        $log_enabled = !empty($config['hm_emailwhitelist_log_enabled']);

        $status_label = $enabled ? $user->lang('ACP_EMAILWHITELIST_STATUS_ACTIVE') : $user->lang('ACP_EMAILWHITELIST_STATUS_DISABLED');
        $logging_label = $log_enabled ? $user->lang('ACP_EMAILWHITELIST_LOGGING_ENABLED') : $user->lang('ACP_EMAILWHITELIST_LOGGING_DISABLED');
        $visibility_label = $show_domains ? $user->lang('ACP_EMAILWHITELIST_DOMAINS_VISIBLE') : $user->lang('ACP_EMAILWHITELIST_DOMAINS_HIDDEN');

        switch ($store_mode)
        {
            case 'none':
                $store_mode_label = $user->lang('ACP_EMAILWHITELIST_STORE_NONE');
                break;

            case 'full':
                $store_mode_label = $user->lang('ACP_EMAILWHITELIST_STORE_FULL');
                break;

            case 'masked':
            default:
                $store_mode_label = $user->lang('ACP_EMAILWHITELIST_STORE_MASKED');
                break;
        }

        $top_domains = $log_repository->get_top_domains(10);
        foreach ($top_domains as $row)
        {
            $template->assign_block_vars('top_domains', array(
                'DOMAIN'   => $row['domain'],
                'ATTEMPTS' => (int) $row['attempts'],
            ));
        }

        $latest_attempts = $log_repository->get_latest_attempts(25);
        foreach ($latest_attempts as $row)
        {
            $template->assign_block_vars('latest_attempts', array(
                'EMAIL'      => $row['email'] !== '' ? $row['email'] : $user->lang('ACP_EMAILWHITELIST_EMAIL_NOT_STORED'),
                'DOMAIN'     => $row['domain'],
                'IP'         => $row['ip'],
                'USER_AGENT' => $row['user_agent'],
                'DATE'       => $user->format_date((int) $row['attempt_time']),
            ));
        }

        $template->assign_vars(array(
            'U_ACTION' => $this->u_action,

            'S_ENABLED'      => $enabled,
            'S_SHOW_DOMAINS' => $show_domains,
            'S_LOG_ENABLED'  => $log_enabled,
            'S_HAS_DOMAINS'  => $allowed_domains_count > 0,
            'S_STORE_NONE'   => $store_mode === 'none',
            'S_STORE_MASKED' => $store_mode === 'masked',
            'S_STORE_FULL'   => $store_mode === 'full',

            'ALLOWED_DOMAINS'         => $allowed_domains_config,
            'ALLOWED_DOMAINS_COUNT'   => $allowed_domains_count,
            'ALLOWED_DOMAINS_PREVIEW' => $allowed_domains_preview,
            'ERROR_MESSAGE'           => (string) ($config['hm_emailwhitelist_error_message'] ?? ''),

            'STATUS_LABEL'     => $status_label,
            'LOGGING_LABEL'    => $logging_label,
            'VISIBILITY_LABEL' => $visibility_label,
            'STORE_MODE_LABEL' => $store_mode_label,

            'TOTAL_BLOCKED'       => $log_repository->get_total_count(),
            'TODAY_BLOCKED'       => $log_repository->get_today_count(),
            'LAST_7_DAYS_BLOCKED' => $log_repository->get_last_days_count(7),

            'S_HAS_TOP_DOMAINS'     => !empty($top_domains),
            'S_HAS_LATEST_ATTEMPTS' => !empty($latest_attempts),
        ));
    }
}
