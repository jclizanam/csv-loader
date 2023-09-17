<?php

class Database
{

  protected $db;
  protected $db_connection;
  protected $result_object;

  /**
   * Construct
   */
  public function __construct()
  {
    // Getting database credentials
    if (!class_exists('Settings')) {
      include_once $_SERVER['DOCUMENT_ROOT'] . "/config.php";
    }

    $settings = new Settings();
    $db = $settings->db;
    $this->db_connection = mysqli_init();
    
    mysqli_real_connect($this->db_connection, $db->db_hostname, $db->db_username, $db->db_password, $db->db_name);
    mysqli_set_charset($this->db_connection, 'utf8');
    mysqli_options($this->db_connection, MYSQLI_INIT_COMMAND, 'SET AUTOCOMMIT = 0');
    mysqli_options($this->db_connection, MYSQLI_OPT_CONNECT_TIMEOUT, 5);

    // Testing connection
    if (mysqli_connect_errno()) {
      print mysqli_connect_errno();
      exit;
    }

  }

  public function query($sql)
  {
    $this->result_object = null;
    $sql = trim($sql);
    $result = mysqli_query($this->db_connection, $sql);

    if (is_object($result)) {
      $this->result_object = $result;
      return true;

    } else {
      return $result;

    }
  } // -- query();

  public function insert($sql)
  {
    if (preg_match('/(insert)/i', $sql)) {
      if (mysqli_query($this->db_connection, $sql)) {
        $id = mysqli_insert_id($this->db_connection);
        return ($id > 0) ? $id : false;
      }
    }

    return false;

  } // -- insert();


  public function resultInfo($return_type = null)
  {
    return $this->result_object;
  } // -- resultInfo();

  public function getRecord($return_type = null)
  {
    if ($this->result_object->num_rows > 0) {
      return mysqli_fetch_assoc($this->result_object);
    }

  } // -- getRecord();

  public function allResults($return_type = null)
  {
    $records = array();
    if ($this->result_object->num_rows > 0) {
      if ($return_type == 'object') {
        while ($results = mysqli_fetch_object($this->result_object)) {
          $records[] = $results;
        }
      } else {
        while ($results = mysqli_fetch_assoc($this->result_object)) {
          $records[] = $results;
        }
      }
    }
    return $records;
  } // -- allResults();


  public function getAll($return_type = null)
  {

    $fields = mysqli_fetch_fields($this->result_object);

    if (isset($fields)) {
      foreach ($fields as $key => $field) {
        $field_list[$key] = $field->name;
      }
    }

    $records = array();

    while ($results = mysqli_fetch_assoc($this->result_object)) {
      $rec = null;

      foreach ($results as $fieldName => $data) {
        $rec->$fieldName = $data;
      }

      if (isset($rec->id)) {
        $records[$rec->id] = $rec;

      } else {
        $records[] = $rec;
      }
    }

    return $records;

  } // -- getAll();

  public function clean($value)
  {
    return mysqli_real_escape_string($this->db_connection, $value);
  } // -- clean();

}