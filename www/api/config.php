<?php
include_once __DIR__ . "/_parse_env.php";

class Settings
{
    function __construct()
    {
        // Env conf
        $env = parseEnv();

        $this->api = new stdClass();
        $this->emails = new stdClass();
        $this->db = new stdClass();

        $this->db->db_hostname = $env['MYSQL_HOSTNAME'];
        $this->db->db_username = $env['MYSQL_USER'];
        $this->db->db_password = $env['MYSQL_PASSWORD'];
        $this->db->db_name = $env['MYSQL_DATABASE'];
        $this->tmp_store_files = "tmp/";
    }
}

?>