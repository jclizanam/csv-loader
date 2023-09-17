<?php

class Employee
{
  protected int $id;
  protected string $company;
  protected string $name;
  protected string $email;
  protected int $salary;
  private Database $database;
  private Helpers $helpers;

  /**
   * Constructor
   * @param
   * id INT
   * company STRING
   * name STRING
   * email STRING
   * salary INT // FOR NOW INT. CSV FILE HAS ONLY INT NUMBERS
   */
  public function __construct($company = '', $name = '', $email = '', $salary = 0, $id = 0)
  {
    $this->company = $company;
    $this->name = $name;
    $this->email = $email;
    $this->salary = $salary;
    $this->id = $id;
    //
    include_once __DIR__ . '/Database.php';
    include_once __DIR__ . '/Helpers.php';
    $this->database = new Database();
    $this->helpers = new Helpers();
  }


  public function setId(int $id)
  {
    $this->id = $id;
  }

  public function getId(): int
  {
    return $this->id;
  }

  public function setCompany(string $company)
  {
    $this->company = $company;
  }


  public function getCompany(): string
  {
    return $this->company;
  }

  public function setName(string $name)
  {
    $this->name = $name;
  }

  public function getName(): string
  {
    return $this->name;
  }

  public function setEmail(string $email)
  {
    $this->email = $email;
  }


  public function getEmail(): string
  {
    return $this->email;
  }

  public function setSalary(int $salary)
  {
    $this->salary = $salary;
  }

  public function getSalary(): int
  {
    return $this->salary;
  }

  public function save()
  {
    $fields = array();
    $fields[] = "company_name='" . $this->database->clean($this->getCompany()) . "'";
    $fields[] = "name='" . $this->database->clean($this->getName()) . "'";
    $fields[] = "email='" . $this->database->clean($this->getEmail()) . "'";
    $fields[] = "salary=" . $this->database->clean($this->getSalary());

    if (empty($this->getId())) {
      $fields[] = "created_at=" . time();
      // Store record into database
      $sql = "INSERT INTO employees SET " . implode(", ", $fields);
      $result = $this->database->insert($sql);
      if (!$result) {
        $this->helpers->api_response(
          500,
          "Error creating employee record."
        );
      }
    } else {
      $fields[] = "updated_at=" . time();
      $sql = "UPDATE employees SET " . implode(", ", $fields) . " WHERE id = " . $this->getId();
      $this->database->query($sql);
      $result = $this->getId();
    }
    return $result;
  }


  /**
   * @param $id
   * @return bool
   */
  function getEmployeeById($id): bool
  {
    $id = $this->database->clean($id);
    $sql = "SELECT id, company_name, name, email, salary FROM employees WHERE id = $id LIMIT 1;";
    $this->database->query($sql);
    $result = $this->database->getRecord();

    if (!empty($result)) {
      $this->setId($result['id']);
      $this->setCompany($result['company_name']);
      $this->setName($result['name']);
      $this->setEmail($result['email']);
      $this->setSalary($result['salary']);
    }
    return false;
  }

  /**
   * @param $email
   * @return bool
   */
  function isEmailTaken($email): bool
  {
    $email = $this->database->clean($email);
    $sql = "SELECT id, company_name, name, email, salary FROM employees WHERE email = '$email' LIMIT 1;";
    $this->database->query($sql);
    $result = $this->database->getRecord();
    return (!empty($result) && $result['id'] !== $this->getId());
  }

}