<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    class SubDepartment extends CI_Controller {
        public function __construct() {
            parent::__construct();
            ob_start();
            if(!$this->session->userdata('user_session')){
                redirect('home/index');
            }
            $this->load->model('DepartmentModel');
        }

        public function index(){
            $this->load->view('SubDepartment/Index');
        }

        public function getSubDeptData(){
            $searchVal = $_POST['search']['value'];
            $i = $_POST['start'];
            $rowperpage = $_POST['length']; // Rows display per page
            $columnIndex = $_POST['order'][0]['column']; // Column index
            $columnName = $_POST['columns'][$columnIndex]['data']; // Column name
            $columnSortOrder = $_POST['order'][0]['dir'];

            if($searchVal != ''){
                $deptData = $this->DepartmentModel->getSubDept($searchVal, $i, $rowperpage, $columnIndex, $columnName, $columnSortOrder);
            }else{
                $deptData = $this->DepartmentModel->getSubDept($searchVal, $i, $rowperpage, $columnIndex, $columnName, $columnSortOrder);
            }

            $data = array();
            
            
            if($deptData['data'] == ''){
                $data[] = array('sr_no' => '', 'department_name' => '', 'subdept_name' => 'No Data Found', 'date_added' => '', 'action' => '');
            }else{
                foreach($deptData['data'] as $keyData => $value){
                    $i++;

                    if($value['status'] == 1){
                        $edit = '<a href = '.base_url().'SubDepartment/edit/'.base64_encode($value['sub_id']).'/'.base64_encode($value['dept_id']).'><i class="fa fa-edit" aria-hidden="true"></i></a>';
                    }else{
                        $edit = "";
                    }

                    if($value['status'] == '1'){
                        $action = '<span class = "delete" data-subdept_id = "'.$value['sub_id'].'" data-status = "2"><i class="fa fa-trash" aria-hidden="true"></i></span> &nbsp&nbsp&nbsp'.$edit;
                    }else{
                        $action = '<span class = "delete" data-subdept_id = "'.$value['sub_id'].'" data-status = "1"><i class="fa fa-key" aria-hidden="true"></i></span>';
                    }

                    $data[] = array('sr_no' => $i, 'department_name' => $value['main_dept'], 'subdept_name' => $value['sub_name'], 'date_added' => $value['date_added'], 'action' => $action);
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

        public function deleteSubDept() {
            extract($_POST);
            $res = $this->DepartmentModel->deleteSubDept($subdept_id, $status);

            if($res){
                $data['success'] = 1;
                $data['message'] = ($status == 1) ? "Sub-Department Activated Successfully" : "Sub-Department Deleted Successfully";
            }else{
                $data['success'] = 2;
                $data['message'] = ($status == 1) ? "Sub-Department Activation Failed" : "Sub-Department Deletion Failed";
            }

            echo json_encode($data);
        }

        public function addSubDept() {
            $deptData = $this->DepartmentModel->getDepartment();
            
            $data['departmentData'] = $deptData;
            $this->load->view('SubDepartment/Add', $data);
        }

        public function createSubDepartment(){
            extract($_POST);

            if($deptName != 0){
                foreach($subDeptName as $ind => $val){
                    $insertArray = array(
                        'dept_id' => $deptName,
                        'sub_name' => $val
                    );
                    if($this->DepartmentModel->addSub($insertArray)){
                        $instData[] = 1;
                    }else{
                        break;
                    }
                    
                }

                if(count($subDeptName) == count($instData)){
                    $data['success'] = 1;
                    $data['message'] = "Sub-Department Created Successfully";
                }else{
                    $data['success'] = 2;
                    $data['message'] = "Error Occured Please Try Again";
                }
            }else{
                $data['success'] = 2;
                $data['message'] = "Main Department Should Not be Empty";
            }

            echo json_encode($data);
        }

        public function edit(){
            $subdept_id = base64_decode($this->uri->segment(3));
            $deptId = base64_decode($this->uri->segment(4));
            $dataDept = $this->DepartmentModel->getSubEditData($subdept_id, $deptId);
            $maindeptData = $this->DepartmentModel->getDepartment();
            
            
            if($subdept_id != ''){
                $data['deptId'] = $deptId;
                $data['subId']  = $subdept_id;
                $data['dataOfSubDept'] = $dataDept;
                $data['departmentData'] = $maindeptData;
                $this->load->view('SubDepartment/Edit', $data);
            }else{
                $this->load->view('errors/html/error_php');
            }
        }

        public function removeSubDept() {
            extract($_POST);

            $del = $this->DepartmentModel->removeSubDept($subdeptId);

            if($del){
                $data['success'] = 1;
                $data['message'] = "Sub-Department Deleted Successfully";
            }else{
                $data['success'] = 2;
                $data['message'] = "Erroe Occured Please Try Again";
            }

            echo json_encode($data);
        }

        public function editSubDepartment(){
			extract($_POST);

			if($deptName != ''){
                $updateArray = array(
                    'sub_name' => $subDeptName[0],
                    'dept_id' => $deptName
                );

                $res = $this->DepartmentModel->editSubDepartment($updateArray, $deptName, $subId);

                if($res){
                    $data['success'] = 1;
                    $data['message'] = "Edited Successfully";
                }else{
                    $data['success'] = 2;
                    $data['message'] = "Edition Failed";
                }
            }

            echo json_encode($data);
		}
    }
?>