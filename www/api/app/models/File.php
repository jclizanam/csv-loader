<?php

class File
{
  protected string $name;
  protected string $extension;
  protected int $size;
  protected string $tmp;
  private Settings $settings;

  /**
   * Construct
   */
  public function __construct()
  {
    include_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
    $this->settings = new Settings();
  }

  /**
   * @param string $name
   */
  public function setName(string $name): void
  {
    $this->name = $name;
  }

  /**
   * @param string $extension
   */
  public function setExtension(string $extension): void
  {
    $this->extension = $extension;
  }

  /**
   * @param int $size
   */
  public function setSize(int $size): void
  {
    $this->size = $size;
  }

  /**
   * @param string $tmp
   */
  public function setTmp(string $tmp): void
  {
    $this->tmp = $tmp;
  }

  /**
   * @return string
   */
  public function getName(): string
  {
    return $this->name;
  }

  /**
   * @return string
   */
  public function getExtension(): string
  {
    return $this->extension;
  }

  /**
   * @return int
   */
  public function getSize(): int
  {
    return $this->size;
  }

  /**
   * @return string
   */
  public function getTmp(): string
  {
    return $this->tmp;
  }

  /**
   * Validate if file exist
   * @return bool
   */
  private function validateFileExist(): bool
  {
    return file_exists($this->settings->tmp_store_files . $this->getName());
  }

  /**
   * Moving file to server
   * @return bool
   */
  public function saveFileInServer(): bool
  {
    try {
      move_uploaded_file($this->getTmp(), $this->settings->tmp_store_files . $this->getName());
      return true;
    } catch (Exception $e) {
      return false;
    }
  }

  /**
   * Store file
   * @return bool
   */
  public function processSaveFile(): bool
  {
    // Validate if file exist
    if ($this->validateFileExist()) {
      $rand = Rand(0, 999);
      $this->setName($rand . "-" . $this->getName());
    }

    // Moving file to tmp folder
    return $this->saveFileInServer();
  }

}