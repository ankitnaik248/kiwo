<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ReqtypeController extends CI_Controller {
	public function __construct() {
        parent::__construct();
        ob_start();
        $this->load->model('ReqModel');
    }

    public function index(){
    	$this->load->view('requesttype/index');
    }

    public function create(){
    	$this->load->view('requesttype/create');
    }

    public function getData(){
    	$searchVal = $_POST['search']['value'];
        $i = $_POST['start'];
        $rowperpage = $_POST['length']; // Rows display per page
        $columnIndex = $_POST['order'][0]['column']; // Column index
        $columnName = $_POST['columns'][$columnIndex]['data']; // Column name
        $columnSortOrder = $_POST['order'][0]['dir'];

        if($searchVal != ''){
                $reqData = $this->ReqModel->getData($searchVal, $i, $rowperpage, $columnIndex, $columnName, $columnSortOrder);
            }else{
                $reqData = $this->ReqModel->getData($searchVal, $i, $rowperpage, $columnIndex, $columnName, $columnSortOrder);
            }

            $data = array();
            
            if($reqData['data'] == ''){
                $data[] = array('sr_no' => '', 'req_name' => 'No Data Found', 'date_added' => '', 'action' => '');
            }else{

            	foreach($reqData['data'] as $keyData => $value){
                    $i++;

                    if($value['status'] == 1){
                        $edit = '<a href = '.base_url().'reqtypeController/edit/'.base64_encode($value['request_id']).'><i class="fa fa-edit" aria-hidden="true"></i></a>';
                    }else{
                        $edit = "";
                    }

                    if($value['status'] == '1'){
                        $action = '<span class = "delete" data-req_id = "'.$value['request_id'].'" data-status = "2"><i class="fa fa-trash" aria-hidden="true"></i></span> &nbsp&nbsp&nbsp'.$edit;
                    }else{
                        $action = '<span class = "delete" data-req_id = "'.$value['request_id'].'" data-status = "1"><i class="fa fa-key" aria-hidden="true"></i></span>';
                    }

            	$data[] = array('sr_no' => $i, 'req_name' => $value['req_name'], 'date_added' => $value['date_added'], 'action' => $action);
            	}
            }

            $output = array(
                "draw" => $_POST['draw'],
                "recordsTotal" => $reqData['count'],
                "recordsFiltered" => $reqData['filteredcount'],
                "data" => $data,
            );

            echo json_encode($output);
        }


        public function createReq(){
        	extract($_POST);

            $reqArray = array(
                'req_name' => $req_type
            );

            $res = $this->ReqModel->insert($reqArray);

            if($res != ''){
                $data['success'] = 1;
                $data['message'] = "Request Type Created Successfully";
            }else{
                $data['success'] = 2;
                $data['message'] = "Failed to create Request Type";
            }

            echo json_encode($data);
        }


        public function deleteReq(){
        	extract($_POST);
            $res = $this->ReqModel->deleteReq($reqid, $status);

            if($res){
                $data['success'] = 1;
                $data['message'] = "Request Type Deleted Successfully";
            }else{
                $data['success'] = 2;
                $data['message'] = "Request Type Deletion Failed";
            }

            echo json_encode($data);
        }

        public function edit(){
            $req_id = base64_decode($this->uri->segment(3));
            $dataReq = $this->ReqModel->getEditData($req_id);
            if($dataReq != ''){
                $data['dataOfReq'] = $dataReq;
                $this->load->view('requesttype/edit', $data);
            }else{
                $this->load->view('errors/html/error_php');
            }
        }


        public function editReqSubmit(){
        	extract($_POST);

            $res = $this->ReqModel->editReqData($req_id, $req_type);

            if($res){
                $data['success'] = 1;
                $data['message'] = "Request Name Edited Successfully";
            }else{
                $data['success'] = 2;
                $data['message'] = "Request Edition Failed";
            }

            echo json_encode($data);
        }
        
 }

?>