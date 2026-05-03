<?php
/**
 * Event listener for Email Whitelist.
 *
 * @package hybridmind/emailwhitelist
 */

namespace hybridmind\emailwhitelist\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class listener implements EventSubscriberInterface
{
    /** @var \phpbb\config\config */
    protected $config;

    /** @var \phpbb\user */
    protected $user;

    /** @var \phpbb\request\request */
    protected $request;

    /** @var \hybridmind\emailwhitelist\service\domain_manager */
    protected $domain_manager;

    /** @var \hybridmind\emailwhitelist\service\log_repository */
    protected $log_repository;

    /**
     * @param \phpbb\config\config $config
     * @param \phpbb\user $user
     * @param \phpbb\request\request $request
     * @param \hybridmind\emailwhitelist\service\domain_manager $domain_manager
     * @param \hybridmind\emailwhitelist\service\log_repository $log_repository
     */
    public function __construct($config, $user, $request, $domain_manager, $log_repository)
    {
        $this->config = $config;
        $this->user = $user;
        $this->request = $request;
        $this->domain_manager = $domain_manager;
        $this->log_repository = $log_repository;
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return array(
            'core.ucp_register_data_after' => 'validate_registration_email_domain',
        );
    }

    /**
     * Validates submitted registration email domain against the ACP whitelist.
     *
     * @param \phpbb\event\data $event
     * @return void
     */
    public function validate_registration_email_domain($event)
    {
        if (empty($this->config['hm_emailwhitelist_enabled']))
        {
            return;
        }

        $this->user->add_lang_ext('hybridmind/emailwhitelist', 'common');

        $data = $event['data'];
        $email = isset($data['email']) ? (string) $data['email'] : '';
        $domain = $this->domain_manager->extract_domain($email);

        if ($email === '' || $domain === '' || $this->domain_manager->is_email_allowed($email))
        {
            return;
        }

        $error = $event['error'];
        $error[] = $this->build_error_message();
        $event['error'] = $error;

        if (!empty($this->config['hm_emailwhitelist_log_enabled']))
        {
            $store_mode = (string) ($this->config['hm_emailwhitelist_store_mode'] ?? 'masked');
            $this->log_repository->insert(
                $email,
                $domain,
                (string) $this->user->ip,
                (string) $this->request->server('HTTP_USER_AGENT', ''),
                $store_mode
            );
        }
    }

    /**
     * Builds a localized error message.
     *
     * @return string
     */
    protected function build_error_message()
    {
        $domains = $this->domain_manager->get_allowed_domains();
        $domains_display = !empty($domains) ? implode(', ', $domains) : $this->user->lang('HM_EW_NO_ALLOWED_DOMAINS_PUBLIC');

        $custom_message = trim((string) ($this->config['hm_emailwhitelist_error_message'] ?? ''));
        if ($custom_message !== '')
        {
            $message = str_replace('{DOMAINS}', $domains_display, $custom_message);
            return htmlspecialchars($message, ENT_COMPAT, 'UTF-8');
        }

        if (!empty($this->config['hm_emailwhitelist_show_domains']))
        {
            return $this->user->lang('HM_EW_EMAIL_NOT_ALLOWED_WITH_DOMAINS', $domains_display);
        }

        return $this->user->lang('HM_EW_EMAIL_NOT_ALLOWED');
    }
}
