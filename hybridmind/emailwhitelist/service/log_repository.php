<?php
/**
 * Log repository for Email Whitelist.
 *
 * @package hybridmind/emailwhitelist
 */

namespace hybridmind\emailwhitelist\service;

class log_repository
{
    /** @var \phpbb\db\driver\driver_interface */
    protected $db;

    /** @var string */
    protected $table_name;

    /**
     * @param \phpbb\db\driver\driver_interface $db
     * @param string $table_prefix
     */
    public function __construct($db, $table_prefix)
    {
        $this->db = $db;
        $this->table_name = $table_prefix . 'hm_emailwhitelist_logs';
    }

    /**
     * Inserts a blocked registration attempt.
     *
     * @param string $email
     * @param string $domain
     * @param string $ip
     * @param string $user_agent
     * @param string $store_mode none|masked|full
     * @return void
     */
    public function insert($email, $domain, $ip, $user_agent, $store_mode = 'masked')
    {
        $email = strtolower(trim((string) $email));
        $domain = strtolower(trim((string) $domain));
        $store_mode = in_array($store_mode, array('none', 'masked', 'full'), true) ? $store_mode : 'masked';

        $email_value = '';
        if ($store_mode === 'full')
        {
            $email_value = $email;
        }
        else if ($store_mode === 'masked')
        {
            $email_value = $this->mask_email($email);
        }

        $sql_ary = array(
            'email'        => $email_value,
            'email_hash'   => hash('sha256', $email),
            'domain'       => $domain,
            'ip'           => substr((string) $ip, 0, 45),
            'user_agent'   => substr((string) $user_agent, 0, 255),
            'attempt_time' => time(),
        );

        $sql = 'INSERT INTO ' . $this->table_name . ' ' . $this->db->sql_build_array('INSERT', $sql_ary);
        $this->db->sql_query($sql);
    }

    /**
     * Returns the total number of blocked attempts.
     *
     * @return int
     */
    public function get_total_count()
    {
        return $this->count_since(0);
    }

    /**
     * Returns the number of blocked attempts since midnight server time.
     *
     * @return int
     */
    public function get_today_count()
    {
        return $this->count_since(mktime(0, 0, 0));
    }

    /**
     * Returns the number of blocked attempts in the last N days.
     *
     * @param int $days
     * @return int
     */
    public function get_last_days_count($days)
    {
        $days = max(1, (int) $days);
        return $this->count_since(time() - ($days * 86400));
    }

    /**
     * Gets most blocked domains.
     *
     * @param int $limit
     * @return array<int,array<string,mixed>>
     */
    public function get_top_domains($limit = 10)
    {
        $limit = max(1, min(50, (int) $limit));

        $sql = 'SELECT domain, COUNT(log_id) AS attempts
            FROM ' . $this->table_name . '
            GROUP BY domain
            ORDER BY attempts DESC, domain ASC';
        $result = $this->db->sql_query_limit($sql, $limit);

        $rows = array();
        while ($row = $this->db->sql_fetchrow($result))
        {
            $rows[] = $row;
        }
        $this->db->sql_freeresult($result);

        return $rows;
    }

    /**
     * Gets latest blocked attempts.
     *
     * @param int $limit
     * @return array<int,array<string,mixed>>
     */
    public function get_latest_attempts($limit = 25)
    {
        $limit = max(1, min(100, (int) $limit));

        $sql = 'SELECT log_id, email, domain, ip, user_agent, attempt_time
            FROM ' . $this->table_name . '
            ORDER BY attempt_time DESC, log_id DESC';
        $result = $this->db->sql_query_limit($sql, $limit);

        $rows = array();
        while ($row = $this->db->sql_fetchrow($result))
        {
            $rows[] = $row;
        }
        $this->db->sql_freeresult($result);

        return $rows;
    }

    /**
     * Clears all blocked-attempt logs.
     *
     * @return void
     */
    public function clear()
    {
        $this->db->sql_query('DELETE FROM ' . $this->table_name);
    }

    /**
     * Counts attempts after a timestamp.
     *
     * @param int $timestamp
     * @return int
     */
    protected function count_since($timestamp)
    {
        $where = ((int) $timestamp > 0) ? ' WHERE attempt_time >= ' . (int) $timestamp : '';
        $sql = 'SELECT COUNT(log_id) AS total FROM ' . $this->table_name . $where;
        $result = $this->db->sql_query($sql);
        $total = (int) $this->db->sql_fetchfield('total');
        $this->db->sql_freeresult($result);

        return $total;
    }

    /**
     * Masks an email address for privacy-friendly logs.
     *
     * @param string $email
     * @return string
     */
    protected function mask_email($email)
    {
        $email = strtolower(trim((string) $email));
        $pos = strrpos($email, '@');

        if ($pos === false)
        {
            return '';
        }

        $local = substr($email, 0, $pos);
        $domain = substr($email, $pos + 1);

        if ($local === '')
        {
            return '***@' . $domain;
        }

        return substr($local, 0, 1) . str_repeat('*', min(8, max(3, strlen($local) - 1))) . '@' . $domain;
    }
}
