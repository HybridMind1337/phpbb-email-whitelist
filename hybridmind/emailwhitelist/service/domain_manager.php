<?php
/**
 * Domain manager for Email Whitelist.
 *
 * @package hybridmind/emailwhitelist
 */

namespace hybridmind\emailwhitelist\service;

class domain_manager
{
    /** @var \phpbb\config\config */
    protected $config;

    /**
     * @param \phpbb\config\config $config
     */
    public function __construct($config)
    {
        $this->config = $config;
    }

    /**
     * Returns normalized allowed domains from phpBB config.
     *
     * @return string[]
     */
    public function get_allowed_domains()
    {
        return $this->normalize_domains((string) ($this->config['hm_emailwhitelist_allowed_domains'] ?? ''));
    }

    /**
     * Converts a textarea/string domain list into a clean, unique config value.
     *
     * @param string $input
     * @return string
     */
    public function domains_to_config_value($input)
    {
        return implode("\n", $this->normalize_domains($input));
    }

    /**
     * Checks whether the given email is allowed.
     *
     * @param string $email
     * @return bool
     */
    public function is_email_allowed($email)
    {
        $domain = $this->extract_domain($email);

        if ($domain === '')
        {
            return false;
        }

        $allowed_domains = $this->get_allowed_domains();

        if (empty($allowed_domains))
        {
            // Safe default: no domains configured means no external domains are allowed.
            return false;
        }

        foreach ($allowed_domains as $allowed_domain)
        {
            if ($domain === $allowed_domain)
            {
                return true;
            }

            // Optional wildcard support: *.example.com allows user@mail.example.com.
            if (strpos($allowed_domain, '*.') === 0)
            {
                $base_domain = substr($allowed_domain, 2);
                if ($base_domain !== '' && substr($domain, -strlen('.' . $base_domain)) === '.' . $base_domain)
                {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Extracts and normalizes the domain part from an email address.
     *
     * @param string $email
     * @return string
     */
    public function extract_domain($email)
    {
        $email = strtolower(trim((string) $email));
        $pos = strrpos($email, '@');

        if ($pos === false)
        {
            return '';
        }

        return $this->normalize_domain(substr($email, $pos + 1));
    }

    /**
     * Normalizes a list of domains from textarea/comma/semicolon input.
     *
     * @param string $input
     * @return string[]
     */
    public function normalize_domains($input)
    {
        $input = (string) $input;
        $parts = preg_split('/[\r\n,;]+/', $input);
        $domains = array();

        foreach ($parts as $part)
        {
            $domain = $this->normalize_domain($part);

            if ($domain !== '' && $this->is_valid_domain_pattern($domain))
            {
                $domains[] = $domain;
            }
        }

        $domains = array_values(array_unique($domains));
        sort($domains, SORT_NATURAL | SORT_FLAG_CASE);

        return $domains;
    }

    /**
     * Normalizes a single domain or wildcard domain pattern.
     *
     * @param string $domain
     * @return string
     */
    protected function normalize_domain($domain)
    {
        $domain = strtolower(trim((string) $domain));
        $domain = trim($domain, " \t\n\r\0\x0B.\"'");

        if ($domain === '')
        {
            return '';
        }

        // Allow admins to paste email addresses; only the domain is stored.
        if (strpos($domain, '@') !== false)
        {
            $domain = substr($domain, strrpos($domain, '@') + 1);
        }

        // Remove protocol/path if an admin pasted a URL.
        $domain = preg_replace('#^https?://#i', '', $domain);
        $domain = preg_replace('#/.*$#', '', $domain);
        $domain = trim($domain, '.');

        $is_wildcard = false;
        if (strpos($domain, '*.') === 0)
        {
            $is_wildcard = true;
            $domain = substr($domain, 2);
        }

        if (function_exists('idn_to_ascii'))
        {
            $ascii = defined('INTL_IDNA_VARIANT_UTS46')
                ? idn_to_ascii($domain, 0, INTL_IDNA_VARIANT_UTS46)
                : idn_to_ascii($domain);

            if ($ascii !== false)
            {
                $domain = strtolower($ascii);
            }
        }

        return $is_wildcard ? '*.' . $domain : $domain;
    }

    /**
     * Validates a normalized domain pattern.
     *
     * @param string $domain
     * @return bool
     */
    protected function is_valid_domain_pattern($domain)
    {
        if (strpos($domain, '*.') === 0)
        {
            $domain = substr($domain, 2);
        }

        if ($domain === '' || strlen($domain) > 253)
        {
            return false;
        }

        if (strpos($domain, '..') !== false)
        {
            return false;
        }

        return (bool) preg_match('/^(?:[a-z0-9](?:[a-z0-9-]{0,61}[a-z0-9])?\.)+[a-z0-9][a-z0-9-]{1,62}$/', $domain);
    }
}
