<?php
function parseEnv()
{
  $envPath = $_SERVER['DOCUMENT_ROOT'] . "/.env";

  $envFile = fopen($envPath, 'r');
  $envVariables = [];

  while (($line = fgets($envFile)) !== false) {
    $line = trim($line);
    if ($line && $line[0] !== '#') {
      list($key, $value) = explode('=', $line, 2);
      $envVariables[$key] = $value;
    }
  }

  fclose($envFile);
  return $envVariables;
}
