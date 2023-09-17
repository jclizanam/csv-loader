<?php

include_once $_SERVER['DOCUMENT_ROOT'] . "/app/models/Csv.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/app/models/Employee.php";
include_once $_SERVER['DOCUMENT_ROOT'] . '/app/models/Helpers.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/app/models/File.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/app/models/Company.php';

class api_controller
{
    private Helpers $helpers;

    function __construct()
    {


        // Instance
        $this->helpers = new Helpers();
    }

    /**
     * Process CSV Files
     * @return void
     */
    function upload()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            //Setting local
            $file = !empty($_FILES['user-csv']) ? $_FILES['user-csv'] : null;

            // No File attached in request
            if (empty($file)) {
                $this->helpers->api_response(400, 'You have to include your csv file.');
            }

            // Setting file
            $csvFile = new File();
            $csvFile->setName($file['name']);
            $csvFile->setExtension($file['type']);
            $csvFile->setSize($file['size']);
            $csvFile->setTmp($file['tmp_name']);

            // Seating file
            $csv = new Csv();
            $csv->setCsvFile($csvFile);

            // Store file data only if processCsv is true.
            if ($csv->processCsv()) {
                if (!empty($csv->getCsvContent())) {
                    foreach ($csv->getCsvContent() as $data) {
                        $employee = new Employee($data[0], $data[1], $data[2], $data[3]);
                        $employee->save();
                    }
                    $this->helpers->api_response(200, "Your file was successfully stored.");
                }
            }
        }
        $this->helpers->api_response(400, "No access");
    }

    /**
     * Get Employees
     */
    function employees()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $company = new Company();
            $this->helpers->api_response(200, "success", $company->getEmployees());
        }

        $this->helpers->api_response(400, "No access");
    }

    /**
     * Get Companies average salary
     */
    function companiesAverageSalary()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $company = new Company();
            $this->helpers->api_response(200, "success", $company->getAverageSalary());
        }

        $this->helpers->api_response(400, "No access");
        exit;
    }

    /**
     * Update employee
     */
    function updateEmployee()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'PUT' && isset($_GET['id'])) {

            $employee = new Employee();
            // Validate if employee exist
            if ($employee->getEmployeeById($_GET['id'])) {
                $this->helpers->api_response(
                    400,
                    "Employee doesn't exist"
                );
            }

            // Getting fields data from PUT
            $fields = $this->helpers->parse_put_request();

            // Validate fields
            $fieldToValidate = ["company_name" => "string", "name" => "string", "email" => "email", "salary" => "number"];
            $fields = $this->helpers->form_validation($fieldToValidate, $fields);

            // Validate email taken ONLY if they have the same company
            if (($employee->getEmail() !== $fields['email']) && $fields['company_name'] === $employee->getCompany()) {
                if ($employee->isEmailTaken($fields['email'])) {
                    $this->helpers->api_response(400, "The email address is already taken.");
                }
            }

            // Set new employee data
            $employee->setCompany($fields['company_name']);
            $employee->setName($fields['name']);
            $employee->setEmail($fields['email']);
            $employee->setSalary($fields['salary']);
            $employee->save();
            $this->helpers->api_response(200, "Employee information saved successfully.");
        }

        $this->helpers->api_response(400, "No access");
        exit;

    }

}
