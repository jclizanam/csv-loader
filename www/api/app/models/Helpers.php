<?php

include_once __DIR__ . "/Database.php";

class Helpers
{

  function __construct()
  {

  }


  function api_response(int $status, string $message, array $result = []): void
  {
    header("HTTP/1.1 $status $message");
    if (!empty($result)) {
      print json_encode(array("status" => $status, "message" => $message, 'result' => $result));
    } else {
      print json_encode(array("status" => $status, "message" => $message));
    }

    exit;
  }

  function parse_put_request()
  {
    $inputData = file_get_contents('php://input'); // Read the raw input

    // Parse the raw input based on the content type
    $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';

    if ($contentType === "application/json") {
      // If the content type is JSON
      return json_decode($inputData, true);
    } else {
      $this->api_response('400', 'Bad request');
    }

  }

  function v_string($string): bool
  {
    return (preg_match("/[a-z0-9\'\"\(\) _-]{2,}$/i", trim($string)));
  }

  function v_email($email): bool
  {
    $pattern = '/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/';
    return (preg_match($pattern, $email));
  }

  function v_number($number)
  {
    return preg_match('/^[0-9]+$/', $number);
  }

  function form_validation(array $fields, $request): array
  {
    $database = new Database();
    if (!empty($fields)) {
      $errors = [];
      $fieldsValidated = [];

      foreach ($fields as $name => $type) {
        $validation = "v_" . $type;
        if (!empty($request[$name]) && $this->$validation($request[$name])) {
          $fieldsValidated[$name] = $database->clean($request[$name]);
        } else {
          $fieldName = str_replace("_", ' ', $name);
          $errors[$name] = "Invalid $fieldName";
        }
      }

      if (count($fieldsValidated) === count($fields)) {
        return $fieldsValidated;
      } else {
        $this->api_response(400, 'The following fields have problems', $errors);
      }
    }
    $this->api_response(400, 'Invalid request');
    return [];
  }

}