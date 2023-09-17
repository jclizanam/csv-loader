<?php

class Csv
{

  protected string $error;
  protected array $csvContent;
  private File $csvFile;

  /**
   * @param File $csvFile
   */
  public function setCsvFile(File $csvFile): void
  {
    $this->csvFile = $csvFile;
  }

  private Settings $settings;
  private Helpers $helpers;

  function __construct()
  {
    # Include other classes to use
    include_once __DIR__ . '/Helpers.php';
    include_once __DIR__ . '/File.php';

    $this->csvFile = new File();
    $this->error = "";
    $this->csvContent = [];

    # Instance classes
    $this->helpers = new Helpers();
    $this->settings = new Settings();

  }

  public function setCsvContent(array $content)
  {
    $this->csvContent = $content;
  }

  public function getCsvContent(): array
  {
    return $this->csvContent;
  }

  public function setError(string $error)
  {
    $this->setError($error);
  }

  public function getError(): string
  {
    return $this->error;
  }

  /**
   * Process CVS file
   * @return bool
   */
  function processCsv(): bool
  {
    if (!$this->csvFile->processSaveFile()) {
      // Stopping process because we have a server error
      $this->helpers->api_response(
        400,
        'We have a problem processing your file, please try again.'
      );
    }

    if (!$this->validateFileFormat()) {
      return false;
    }

    return true;
  }

  /**
   * Validate CSV format
   * @return bool
   */
  private function validateFileFormat(): bool
  {
    $fileContent = fopen($this->settings->tmp_store_files . $this->csvFile->getName(), "r");
    if ($fileContent !== FALSE) {
      $csvLinesContent = array();
      while (!feof($fileContent)) {
        $csvLinesContent[] = fgetcsv($fileContent, 1000, ',');
      }
      fclose($fileContent);

      if (empty($csvLinesContent)) {
        $this->setError("We have a problem reading your file, please try again.");
        return false;
      }

      // I'm going to validate just per column quantity. The base number to use is going to be first row column quantity
      $columnsNumber = count($csvLinesContent[0]);
      $rowsWithProblems = array();
      foreach ($csvLinesContent as $key => $line) {
        if (count($line) < $columnsNumber) {
          $rowsWithProblems[] = $key;
        }
      }

      if (!empty($rowsWithProblems)) {
        $rowText = count($rowsWithProblems) > 1 ? 'rows have' : 'row has';
        $this->setError("The following $rowText an invalid format: " . implode(",", $rowsWithProblems));
        return false;
      }

      // Removing header
      unset($csvLinesContent[0]);
      $this->setCsvContent($csvLinesContent);
    }
    return true;
  }
}

