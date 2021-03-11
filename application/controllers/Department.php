<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    class Department extends CI_Controller {
        public function __construct() {
            parent::__construct();
            ob_start();
            if(!$this->session->userdata('user_session')){
                redirect('home/index');
            }
            $this->load->model('DepartmentModel');
        }

        public function index() {
            $this->load->view('department/index');
        }

        public function getData(){
            $searchVal = $_POST['search']['value'];
            $i = $_POST['start'];
            $rowperpage = $_POST['length']; // Rows display per page
            $columnIndex = $_POST['order'][0]['column']; // Column index
            $columnName = $_POST['columns'][$columnIndex]['data']; // Column name
            $columnSortOrder = $_POST['order'][0]['dir'];

            if($searchVal != ''){
                $deptData = $this->DepartmentModel->getData($searchVal, $i, $rowperpage, $columnIndex, $columnName, $columnSortOrder);
            }else{
                $deptData = $this->DepartmentModel->getData($searchVal, $i, $rowperpage, $columnIndex, $columnName, $columnSortOrder);
            }

            $data = array();
            
            if($deptData['data'] == ''){
                $data[] = array('sr_no' => '', 'department_name' => 'No Data Found', 'date_added' => '', 'action' => '');
            }else{
                foreach($deptData['data'] as $keyData => $value){
                    $i++;

                    if($value['status'] == 1){
                        $edit = '<a href = '.base_url().'department/edit/'.base64_encode($value['dept_id']).'><i class="fa fa-edit" aria-hidden="true"></i></a>';
                    }else{
                        $edit = "";
                    }

                    if($value['status'] == '1'){
                        $action = '<span class = "delete" data-dept_id = "'.$value['dept_id'].'" data-status = "2"><i class="fa fa-trash" aria-hidden="true"></i></span> &nbsp&nbsp&nbsp'.$edit;
                    }else{
                        $action = '<span class = "delete" data-dept_id = "'.$value['dept_id'].'" data-status = "1"><i class="fa fa-key" aria-hidden="true"></i></span>';
                    }

                    $data[] = array('sr_no' => $i, 'department_name' => $value['department_name'], 'date_added' => $value['date_added'], 'action' => $action);
                }
            }

            $output = array(
                "draw" => $_POST['draw'],
                "recordsTotal" => $deptData['count'],
                "recordsFiltered" => $deptData['filteredcount'],
                "data" => $data,
            );

            echo json_encode($output);
        }

        public function create(){
            $this->load->view('department/create');
        }

        public function createDept(){
            extract($_POST);

            $deptArray = array(
                'department_name' => $name 
            );

            $res = $this->DepartmentModel->insert($deptArray);

            if($res != ''){
                $data['success'] = 1;
                $data['message'] = "Department Created Successfully";
            }else{
                $data['success'] = 2;
                $data['message'] = "Failed to create department";
            }

            echo json_encode($data);
        }

        public function edit(){
            $dept_id = base64_decode($this->uri->segment(3));
            $dataDept = $this->DepartmentModel->getEditData($dept_id);
            if($dataDept != ''){
                $data['dataOfDept'] = $dataDept;
                $this->load->view('department/edit', $data);
            }else{
                $this->load->view('errors/html/error_php');
            }
        }

        public function editDeptSubmit(){
            extract($_POST);

            $res = $this->DepartmentModel->editDeptData($dept_id, $name);

            if($res){
                $data['success'] = 1;
                $data['message'] = "Department Edited Successfully";
            }else{
                $data['success'] = 2;
                $data['message'] = "Department Edition Failed";
            }

            echo json_encode($data);
        }

        public function deleteDept(){
            extract($_POST);
            $res = $this->DepartmentModel->deleteDept($deptid, $status);

            if($res){
                $data['success'] = 1;
                $data['message'] = "Department Deleted Successfully";
            }else{
                $data['success'] = 2;
                $data['message'] = "Department Deletion Failed";
            }

            echo json_encode($data);
        }
    }
?>