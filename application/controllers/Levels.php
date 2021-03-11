<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    class Levels extends CI_Controller {
        public function __construct() {
            parent::__construct();
            ob_start();
            if(!$this->session->userdata('user_session')){
                redirect('home/index');
            }
            $this->load->model('LevelsModel');
        }

        public function index() {
            $this->load->view('levels/index');
        }

        public function getData(){
            $searchVal = $_POST['search']['value'];
            $i = $_POST['start'];
            $rowperpage = $_POST['length']; // Rows display per page
            $columnIndex = $_POST['order'][0]['column']; // Column index
            $columnName = $_POST['columns'][$columnIndex]['data']; // Column name
            $columnSortOrder = $_POST['order'][0]['dir'];

            if($searchVal != ''){
                $levelData = $this->LevelsModel->getData($searchVal, $i, $rowperpage, $columnIndex, $columnName, $columnSortOrder);
            }else{
                $levelData = $this->LevelsModel->getData($searchVal, $i, $rowperpage, $columnIndex, $columnName, $columnSortOrder);
            }

            $data = array();

            if($levelData['data'] == ''){
                $data[] = array('sr_no' => '', 'level_name' => 'No Data Found', 'date_added' => '', 'action' => '');
            }else{
                foreach($levelData['data'] as $ind => $valLevel){
                    $i++;
                    if($valLevel['status'] == 1){
                        $edit = '<a href = '.base_url().'levels/edit/'.base64_encode($valLevel['level_id']).'><i class="fa fa-edit" aria-hidden="true"></i></a>';
                    }else{
                        $edit = "";
                    }

                    if($valLevel['status'] == '1'){
                        $action = '<span class = "delete" data-level_id = "'.$valLevel['level_id'].'" data-status = "2"><i class="fa fa-trash" aria-hidden="true"></i></span> &nbsp&nbsp&nbsp'.$edit;
                    }else{
                        $action = '<span class = "delete" data-level_id = "'.$valLevel['level_id'].'" data-status = "1"><i class="fa fa-key" aria-hidden="true"></i></span>';
                    }

                    $data[] = array('sr_no' => $i, 'level_name' => $valLevel['level_name'], 'date_added' => $valLevel['date_added'], 'action' => $action);
                }
            }

            $output = array(
                "draw" => $_POST['draw'],
                "recordsTotal" => $levelData['count'],
                "recordsFiltered" => $levelData['filteredcount'],
                "data" => $data,
            );

            echo json_encode($output);
        }

        public function create() {
            $this->load->view('levels/create');
        }

        public function createLevel() {
            extract($_POST);

            $insertArray = array(
                'level_name' => $name
            );

            $res = $this->LevelsModel->createLevel($insertArray);

            if($res){
                $data['success'] = 1;
                $data['message'] = "Level Created Successfully";
            }else{
                $data['success'] = 2;
                $data['message'] = "Error Occured Please Try Again";
            }

            echo json_encode($data);
        }

        public function deleteLevel() {
            extract($_POST);
            
            $res = $this->LevelsModel->deleteLevel($levelid, $status);

            if($res){
                $data['success'] = 1;
                $data['message'] = ($status == 1) ? "Level Activated Successfully" : "Level Deleted Successfully";
            }else{
                $data['success'] = 2;
                $data['message'] = "Error Occured Please Try Again";
            }

            echo json_encode($data);
        }

        public function edit(){
            $level_id = base64_decode($this->uri->segment(3));
            $dataLevel = $this->LevelsModel->getEditData($level_id);
            if($dataLevel != ''){
                $data['level_id'] = $level_id;
                $data['dataOfLevel'] = $dataLevel;
                $this->load->view('levels/edit', $data);
            }else{
                $this->load->view('errors/html/error_php');
            }
        }

        public function editLevel() {
            extract($_POST);

            $updateArray = array(
                'level_name' => $name
            );

            $res = $this->LevelsModel->editLevel($updateArray, $level_id);

            if($res){
                $data['success'] = 1;
                $data['message'] = "Level Updated Successfully";
            }else{
                $data['success'] = 2;
                $data['message'] = "Error Occured Please Try Again";
            }

            echo json_encode($data);
        }

    }
?>