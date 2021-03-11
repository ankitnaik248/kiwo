<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    class Employee extends CI_Controller{
        public function __construct() {
            parent::__construct();
            ob_start();
            if(!$this->session->userdata('user_session')){
                redirect('home/index');
            }
            $this->load->model('EmployeeModel');
        }

        public function index() {
            $this->load->view('employee/index');
        }

        public function checkemail(){
            extract($_POST);
            $res = $this->EmployeeModel->checkEmail($email);

            if($res[0]['ttlcnt'] > 0){
                echo 'false';
            }else{
                echo 'true';
            }
        }

        public function getData(){
            $searchVal = $_POST['search']['value'];
            $i = $_POST['start'];
            $rowperpage = $_POST['length']; // Rows display per page
            $columnIndex = $_POST['order'][0]['column']; // Column index
            $columnName = $_POST['columns'][$columnIndex]['data']; // Column name
            $columnSortOrder = $_POST['order'][0]['dir'];

            if($searchVal != ''){
                $empData = $this->EmployeeModel->getData($searchVal, $i, $rowperpage, $columnIndex, $columnName, $columnSortOrder);
            }else{
                $empData = $this->EmployeeModel->getData($searchVal, $i, $rowperpage, $columnIndex, $columnName, $columnSortOrder);
            }

            $data = array();

            if($empData['data'] == ''){
                $data = array('sr_no' => '', 'emp_name' => '', 'emp_email' => 'No Data Found', 'emp_mobile' => '', 'department' => '', 'emp_type' => '', 'date_added' => '', 'action' => '');
            }else{
                foreach($empData['data'] as $keyData => $value){
                    $i++;

                    $emp_type = "";
                    if($value['emp_type'] == '1'){
                        $emp_type = "Admin";
                    }else{
                        $emp_type = "Employee";
                    }

                    $action = '';

                    if($value['status'] == '1'){
                        $action = '<span class = "delete" data-emp_id = "'.$value['emp_id'].'"><i class="fa fa-trash" aria-hidden="true" data-status = "2"></i></span>&nbsp&nbsp&nbsp<a href = "'.base_url().'employee/edit/'.base64_encode($value['emp_id']).'"><i class="fa fa-edit" aria-hidden="true"></i></a>';
                    }else{
                        $action = '<span class = "delete" data-emp_id = "'.$value['emp_id'].'" data-status = "1"><i class="fa fa-key" aria-hidden="true"></i></span>';
                    }

                    $data[] = array('sr_no' => $i, 'emp_name' => $value['emp_name'], 'emp_email' => $value['emp_email'], 'emp_mobile' => $value['emp_mobile'], 'department' => $value['dept_name'], 'emp_type' => $emp_type, 'date_added' => $value['date_added'], 'action' => $action);
                }
            }

            $output = array(
                "draw" => $_POST['draw'],
                "recordsTotal" => $empData['count'],
                "recordsFiltered" => $empData['filteredcount'],
                "data" => $data,
            );

            echo json_encode($output);
        }

        public function create(){
            $data['dept'] = $this->EmployeeModel->getDept();

            $this->load->view('employee/create', $data);
        }

        public function edit(){
            $emp_id = base64_decode($this->uri->segment(3));
            $empData = $this->EmployeeModel->getEmpData($emp_id);
            $data['empData'] = $empData;
            $data['deptData'] = $this->EmployeeModel->getDept();
            $this->load->view('employee/edit', $data);
        }

        public function createemp(){
            extract($_POST);
            $empArray = array(
                'emp_name' => $name,
                'emp_email' => $email,
                'emp_password' => md5($password),
                'emp_mobile' => $mobile,
                'emp_dept' => $department,
                'emp_type' => $type
            );

            $res = $this->EmployeeModel->insert($empArray);

            if($res != ''){
                $data['success'] = 1;
                $data['message'] = "Employee Created Successfully";
            }else{
                $data['success'] = 2;
                $data['message'] = "Failed to create employee";
            }

            echo json_encode($data);
        }

        public function editEmp(){
            extract($_POST);
            // print_r($_POST);

            if($password != ''){
                $insertArray = array(
                    'emp_name' => $name,
                    'emp_email' => $email,
                    'emp_password' => md5($password),
                    'emp_mobile' => $mobile,
                    'emp_dept' => $department,
                    'emp_type' => $type
                );
            }else{
                $insertArray = array(
                    'emp_name' => $name,
                    'emp_email' => $email,
                    'emp_mobile' => $mobile,
                    'emp_dept' => $department,
                    'emp_type' => $type
                );
            }

            $res = $this->EmployeeModel->editData($insertArray, $emp_id);

            if($res){
                $data['success'] = 1;
                $data['message'] = "Employee Edited Successfully";
            }else{
                $data['success'] = 2;
                $data['message'] = "Employee Edition Failed";
            }

            echo json_encode($data);
        }

        public function deleteEmp(){
            extract($_POST);
            $res = $this->EmployeeModel->deleteEmp($empid, $status);

            if($res){
                $data['success'] = 1;
                $data['message'] = "Employee Deleted Successfully";
            }else{
                $data['success'] = 2;
                $data['message'] = "Employee Deletion Failed";
            }

            echo json_encode($data);
        }
    }
?>