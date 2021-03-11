<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    ob_start();
    class ticket extends CI_Controller {
        public $sessionData;
        public function __construct() {
            // error_reporting(0);
            // ini_set('display_errors', 0);
            parent::__construct();
            $this->sessionData = $this->session->userdata("user_session");
            // print_r($this->session->userdata("user_session"));exit;
            $this->load->model('TicketModel');
        }

        public function index() {
            $data['dep_data'] = $this->TicketModel->getDepartment($this->sessionData[0]['emp_type'], $this->sessionData[0]['emp_dept']);
            $this->load->view('ticket/index', $data);
        }

        public function getData(){
            $searchVal = $_POST['search']['value'];
            $i = $_POST['start'];
            $rowperpage = $_POST['length']; // Rows display per page
            $columnIndex = $_POST['order'][0]['column']; // Column index
            $columnName = $_POST['columns'][$columnIndex]['data']; // Column name
            $columnSortOrder = $_POST['order'][0]['dir'];
            $statusType = $this->input->post("statusType");
            $requestType = $this->input->post("requestType");

            if($searchVal != ''){
                $ticketData = $this->TicketModel->getData($searchVal, $i, $rowperpage, $columnIndex, $columnName, $columnSortOrder, $this->sessionData[0]['emp_type'], $this->sessionData[0]['emp_dept'], $statusType, $requestType, $this->sessionData[0]['emp_id']);
            }else{
                $ticketData = $this->TicketModel->getData($searchVal, $i, $rowperpage, $columnIndex, $columnName, $columnSortOrder, $this->sessionData[0]['emp_type'], $this->sessionData[0]['emp_dept'], $statusType, $requestType, $this->sessionData[0]['emp_id']);
            }

            $data = array();

            if($ticketData['data'] == ''){
                $data = array('sr_no' => '', 'ticket_no' => '', 'request_type' => '', 'request_summary' => '', 'added_by' => 'No Data Found', 'added_by_dept' => '', 'assigned_to' => '', 'closed_by' => '', 'start_date' => '', 'end_date' => '', 'total_days' => '', 'remarks' => '', 'date_added' => '', 'action' => '');
            }else{
                foreach($ticketData['data'] as $keyData => $value){
                    $i++;
                    
                    if($value['ticket_closure'] == '1'){
                        $actionOpen = "<span class = 'closeFile' data-tckt_id = '".$value['ticket_id']."' data-toggle='tooltip' title='close File' style = 'cursor:pointer;'><i class='fas fa-times-circle'></i></span>&nbsp&nbsp";
                        $actionApprove = "&nbsp&nbsp<span class = 'approval' data-toggle='tooltip' title='Approve' data-tckt_id = '".$value['ticket_id']."' style = 'cursor:pointer;'><i class='fas fa-thumbs-up'></i></span>";
                    }else{
                        $actionOpen = "";
                        $actionApprove = "";
                    }
                    
                    if($value['ticket_closure'] == '2'){
                        $closedBy = $this->TicketModel->getEmpById($value['closed_by'])[0]['emp_name'];
                    }else{
                        $closedBy = "";
                    }

                    $action = $actionOpen."<a href = '".base_url()."ticket/edit/".base64_encode($value['ticket_id'])."' data-toggle='tooltip' title='Edit' style = 'cursor:pointer;'><i class='fa fa-edit' aria-hidden='true'></i></a>&nbsp<span class = 'delete' data-toggle='tooltip' title='Delete' data-tckt_id = '".$value['ticket_id']."' style = 'cursor:pointer;'><i class='fa fa-trash' aria-hidden='true'></i></span>".$actionApprove;

                    $remarks = '<button class = "btn btn-sm btn-info remarksBtn" data-tckt_id = "'.$value['ticket_id'].'">Remarks</button>';

                    if($value['file_attach'] != ''){

                        $file_attach = "<a href = '".base_url()."uploads/".$value['file_attach']."' target = '_blank' data-toggle='tooltip' title='".$value['file_attach']."'><i class='fa fa-file' aria-hidden='true'></i></a>";
                    }else{
                        $file_attach = "";
                    }

                    $data[] = array('sr_no' => $i, 'ticket_no' => $value['ticket_no'], 'request_type' => $value['req_type_name'], 'request_summary' => $value['ticket_remark'], 'added_by' => $value['added_by'], 'added_by_dept' => $value['added_by_dept'], 'assigned_to' => $value['assigned_to_dept'], 'closed_by' => $closedBy, 'start_date' => $value['start_date'], 'end_date' => $value['end_date'], 'total_days' => $value['total_days'], 'remarks' => $remarks, 'date_added' => $value['created_at'], 'action' => $action.'&nbsp&nbsp'.$file_attach);
                }
            }

            $output = array(
                "draw" => $_POST['draw'],
                "recordsTotal" => $ticketData['count'],
                "recordsFiltered" => $ticketData['filteredcount'],
                "data" => $data,
            );

            echo json_encode($output);
        }

        public function create(){
            $data['getreqtype'] = $this->TicketModel->getreqtype();
            $data['dep_data'] = $this->TicketModel->getDepartment($this->sessionData[0]['emp_type'], $this->sessionData[0]['emp_dept']);
            $data['dept_emp'] = $this->TicketModel->getEmp($this->sessionData[0]['emp_dept'], $this->sessionData[0]['emp_id'], $this->sessionData[0]['emp_type']);
            // echo "<pre>";print_r($data);exit;
            $this->load->view('ticket/create', $data);
        }

        public function edit(){
            $ticket_id = base64_decode($this->uri->segment(3));

            $data['ticketData'] = $this->TicketModel->getTicketData($ticket_id);
            $data['getreqtype'] = $this->TicketModel->getreqtype();
            $data['dep_data'] = $this->TicketModel->getDepartmentEdit($this->sessionData[0]['emp_type'], $this->sessionData[0]['emp_dept']);
            $data['dept_emp'] = $this->TicketModel->getEmp($this->sessionData[0]['emp_dept'], $this->sessionData[0]['emp_id'], $this->sessionData[0]['emp_type']);

            $this->load->view('ticket/edit', $data);
        }

        public function ticket_form_submit(){
            extract($_POST);
            $empId = "";$emp_dept = "";

            if($emp != 0){
                $empId = $emp;
                $emp_dept = $this->TicketModel->getEmpDept($empId)[0]['emp_dept'];
                $behalf = 1;
            }else{
                $empId = $this->sessionData[0]['emp_id'];
                $emp_dept = $this->sessionData[0]['emp_dept'];
                $behalf = 0;
            }
            
            $diff = strtotime(date("Y-m-d", strtotime($end_date))) - strtotime(date("Y-m-d", strtotime($start_date)));

            if($_FILES['req_attach']['name'] != ''){
                $config = array(
                    "upload_path" => './uploads/',
                    "allowed_types" => "pdf|jpg|png|docx|gif|jpeg",
                    "max_size" => "5000",
                    "file_name" => $_FILES['req_attach']['name'],
                    "encrypt_name" => TRUE,
                );

                $this->upload->initialize($config);

                if($this->upload->do_upload("req_attach")){
                    $uploadData = $this->upload->data();
                    // print_r($uploadData);
                    
                    $insertArray = array(
                        'ticket_no' => $ticket_no,
                        'req_type' => $req_type,
                        'ticket_remark' => $ticket_body,
                        'ticket_added_by' => $empId,
                        'ticket_added_by_dept' => $emp_dept,
                        'ticket_assigned_to' => $department,
                        'login_emp' => $this->sessionData[0]['emp_id'],
                        'file_attach' => $uploadData['file_name'],
                        'behalf' => $behalf,
                        'start_date' => date("Y-m-d", strtotime($start_date)),
                        'end_date' => date("Y-m-d", strtotime($end_date)),
                        'total_days' => abs(round($diff / 86400))
                    );

                    $res = $this->TicketModel->insert($insertArray);

                    if($res){
                        $data['success'] = 1;
                        $data['message'] = "Ticket Added Successfully";
                    }else{
                        $data['success'] = 2;
                        $data['message'] = "Some Error Occured Please Try Again";
                    }
                }else{
                    $error = array('error1' => $this->upload->display_errors());
                    // print_r($error);
                    $data['success'] = 2;
                    $data['message'] = "Some Error Occured Please Try Again";
                }
            }else{
                $insertArray = array(
                        'ticket_no' => $ticket_no,
                        'req_type' => $req_type,
                        'ticket_remark' => $ticket_body,
                        'ticket_added_by' => $empId,
                        'ticket_added_by_dept' => $emp_dept,
                        'ticket_assigned_to' => $department,
                        'login_emp' => $this->sessionData[0]['emp_id'],
                        'behalf' => $behalf,
                        'start_date' => date("Y-m-d", strtotime($start_date)),
                        'end_date' => date("Y-m-d", strtotime($end_date)),
                        'total_days' => abs(round($diff / 86400))
                    );

                    $res = $this->TicketModel->insert($insertArray);

                    if($res){
                        $data['success'] = 1;
                        $data['message'] = "Ticket Added Successfully";
                    }else{
                        $data['success'] = 2;
                        $data['message'] = "Some Error Occured Please Try Again";
                    }
            }

            echo json_encode($data);
        }

        public function add_remarks(){
            extract($_POST);

            if($status == '0'){
                $data['success'] = 2;
                $data['message'] = "Please Fill All The Details";
            }else if($status == '1'){
                $insertArray = array(
                    'ticket_id' => $ticket_ids,
                    'approved_by' => $this->sessionData[0]['emp_id'],
                    'remarks' => $remark
                );

                $res = $this->TicketModel->insert_remark($insertArray, $status, $ticket_ids);

                if($res){
                    $data['success'] = 1;
                    $data['message'] = "Remark Added Successfully";
                }else{
                    $data['success'] = 2;
                    $data['message'] = "Some Error Occured Please Try Again";
                }
            }else if($status == '2'){
                $insertArray = array(
                    'ticket_id' => $ticket_ids,
                    'approved_by' => $this->sessionData[0]['emp_id'],
                    'remarks' => $remark
                );

                $res = $this->TicketModel->insert_remark($insertArray, $status, $ticket_ids);

                if($res){
                    $data['success'] = 1;
                    $data['message'] = "Remark Added And File Closed Successfully";
                }else{
                    $data['success'] = 2;
                    $data['message'] = "Some Error Occured Please Try Again";
                }
            }

            echo json_encode($data);
        }

        public function getremarks(){
            extract($_POST);
            $res = $this->TicketModel->getremarks($ticket_id);
            $sr_no = 1;
            $rows = '';
            if($res){
                foreach ($res as $key => $val) {
                    $rows .= "<tr class = 'text-center'><td>".$sr_no."</td><td>".$val['remarks']."</td><td>".$val['approved_by_name']."</td><td>".$val['app_dept']."</td><td>".$val['date_added']."</td></tr>";
                    $sr_no++;
                }

                $data['success'] = 1;
                $data['rows'] = $rows;
            }else{
                $data['success'] = 2;
                $data['rows'] = "<tr class = 'text-center'><td></td><td>No Data Found</td><td></td><td></td><td></td></tr>";
            }

            echo json_encode($data);
        }

        public function delete(){
            extract($_POST);

            $res = $this->TicketModel->deleteremarks($ticket_id);

            if($res){
                $data['success'] = 1;
                $data['message'] = "Remark Deleted Successfully";
            }else{
                $data['success'] = 2;
                $data['message'] = "Some Error Occured Please Try Again";
            }

            echo json_encode($data);
        }

        public function closeFile(){
            extract($_POST);

            $res = $this->TicketModel->closefile($ticket_id, $this->sessionData[0]['emp_id']);

            if($res){
                $data['success'] = 1;
                $data['message'] = "File Closed Successfully";
            }else{
                $data['success'] = 2;
                $data['message'] = "Some Error Occured Please Try Again";
            }

            echo json_encode($data);
        }
    }
?>        