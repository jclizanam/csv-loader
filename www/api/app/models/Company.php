<?php

include_once __DIR__ . '/Database.php';

class Company
{
    private Database $database;

    public function __construct()
    {
        $this->database = new Database();
    }


    public function getEmployees(): array
    {
        $sql = "SELECT created_at, updated_at, id, company_name as company, name, email, salary FROM employees ORDER BY id DESC";
        $this->database->query($sql);
        return $this->database->allResults($sql);
    }

    public function getAverageSalary(): array
    {
        $sql = "SELECT CAST(AVG(salary) AS DECIMAL(10,0)) as average_salary, company_name as company FROM employees GROUP BY company_name ORDER BY company_name ASC";
        $this->database->query($sql);
        return $this->database->allResults($sql);
    }

}
