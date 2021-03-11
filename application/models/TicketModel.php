<?php
	class TicketModel extends CI_Model{
        function __construct() {
            // Set table name
            $this->table = 'ticket';
        }

        public function getreqtype() {
        	$res = $this->db->query("SELECT * FROM `requesttype` WHERE status = '1'")->result_array();

        	if(!empty($res)){
        		return $res;
        	}else{
        		return false;
        	}
        }

        public function getDepartment($emp_type = null, $emp_dept = null){

            if($emp_type != '1'){
                $res = $this->db->query("SELECT * FROM `department` WHERE status = '1' AND dept_id != '".$emp_dept."'")->result_array();
            }else{
                $res = $this->db->query("SELECT * FROM `department` WHERE status = '1'")->result_array();
            }

            if(!empty($res)){
                return $res;
            }else{
                return false;
            }
        }
        
        public function getDepartmentEdit($emp_type = null, $emp_dept = null){

            if($emp_type != '1'){
                $res = $this->db->query("SELECT * FROM `department` WHERE status = '1' AND dept_id = '".$emp_dept."'")->result_array();
            }else{
                $res = $this->db->query("SELECT * FROM `department` WHERE status = '1'")->result_array();
            }

            if(!empty($res)){
                return $res;
            }else{
                return false;
            }
        }
        
        public function getEmpById($emp_id = null){
            $res = $this->db->query("SELECT emp_id, emp_name FROM `employee` WHERE emp_id = '".$emp_id."'")->result_array();
            
            if(!empty($res)){
                return $res;
            }else{
                return false;
            }
        }

        public function getEmp($dept_id = null, $emp_id = null, $emp_type = null){
            if($emp_type != '1'){
                $res = $this->db->query("SELECT emp_id, emp_name FROM `employee` WHERE emp_dept = '".$dept_id."' AND emp_id != '".$emp_id."' AND status = '1'")->result_array();
            }else{
                $res = $this->db->query("SELECT emp_id, emp_name FROM `employee` WHERE status = '1'")->result_array();
            }
            
            if(!empty($res)){
                return $res;
            }else{
                return false;
            }
        }

        public function getEmpDept($emp_id = null){
            $res = $this->db->query("SELECT emp_dept FROM `employee` WHERE emp_id = '".$emp_id."'")->result_array();

            if(!empty($res)){
                return $res;
            }else{
                return false;
            }
        }

        public function insert($insertArray = null){
            if (!empty($insertArray)) {
                $res = $this->db->insert($this->table, $insertArray);

                if($res){
                    return $this->db->insert_id();
                }else{
                    return false;
                }
            }else{
                return false;
            }
        }

        public function getData($searchVal = null, $i = null, $rowperpage = null, $columnIndex = null, $columnName = null, $columnSortOrder = null, $emp_type = null, $emp_dept = null, $statusType = null, $requestType = null, $emp_id = null){
            if($searchVal != ''){
                if($emp_type == '1'){
                    $res = $this->db->query("SELECT t1.* FROM ( SELECT tckt.*, (SELECT emp_name FROM employee WHERE emp_id = tckt.ticket_added_by) added_by, (SELECT department_name FROM department WHERE dept_id = tckt.ticket_added_by_dept) added_by_dept, (SELECT department_name FROM department WHERE dept_id = tckt.ticket_assigned_to) assigned_to_dept, (SELECT req_name FROM `requesttype`  WHERE request_id = tckt.req_type) req_type_name FROM `ticket` tckt WHERE tckt.status = '1' AND tckt.ticket_closure = '".$statusType."' ) t1 WHERE (t1.ticket_no like '%".$searchVal."%' OR t1.added_by like '%".$searchVal."%' OR t1.assigned_to_dept like '%".$searchVal."%' OR date(created_at) like '%".$searchVal."%')")->result_array();
                }else{
                    if($requestType == '2'){
                        //outgng
                        $res = $this->db->query("SELECT t1.* FROM ( SELECT tckt.*, (SELECT emp_name FROM employee WHERE emp_id = tckt.ticket_added_by) added_by, (SELECT department_name FROM department WHERE dept_id = tckt.ticket_added_by_dept) added_by_dept, (SELECT department_name FROM department WHERE dept_id = tckt.ticket_assigned_to) assigned_to_dept, (SELECT req_name FROM `requesttype`  WHERE request_id = tckt.req_type) req_type_name FROM `ticket` tckt WHERE tckt.status = '1' AND tckt.ticket_closure = '".$statusType."' ) t1 WHERE t1.ticket_added_by_dept = '".$emp_dept."' AND t1.ticket_added_by = '".$emp_id."' AND (t1.ticket_no like '%".$searchVal."%' OR t1.added_by like '%".$searchVal."%' OR t1.assigned_to_dept like '%".$searchVal."%' OR date(created_at) like '%".$searchVal."%')")->result_array();
                    }else{
                        $res = $this->db->query("SELECT t1.* FROM ( SELECT tckt.*, (SELECT emp_name FROM employee WHERE emp_id = tckt.ticket_added_by) added_by, (SELECT department_name FROM department WHERE dept_id = tckt.ticket_added_by_dept) added_by_dept, (SELECT department_name FROM department WHERE dept_id = tckt.ticket_assigned_to) assigned_to_dept, (SELECT req_name FROM `requesttype`  WHERE request_id = tckt.req_type) req_type_name FROM `ticket` tckt WHERE tckt.status = '1' AND tckt.ticket_closure = '".$statusType."' ) t1 WHERE t1.ticket_assigned_to = '".$emp_dept."' AND (t1.ticket_no like '%".$searchVal."%' OR t1.added_by like '%".$searchVal."%' OR t1.assigned_to_dept like '%".$searchVal."%' OR date(created_at) like '%".$searchVal."%')")->result_array();   
                    }        
                }    
            }else{
                if($emp_type == '1'){
                    $res = $this->db->query("SELECT tckt.*, (SELECT emp_name FROM employee WHERE emp_id = tckt.ticket_added_by) added_by, (SELECT department_name FROM department WHERE dept_id = tckt.ticket_added_by_dept) added_by_dept, (SELECT department_name FROM department WHERE dept_id = tckt.ticket_assigned_to) assigned_to_dept, (SELECT req_name FROM `requesttype`  WHERE request_id = tckt.req_type) req_type_name FROM `ticket` tckt WHERE tckt.status = '1' AND tckt.ticket_closure = '".$statusType."'")->result_array();        
                }else{
                    if($requestType == '2'){
                        //outgng
                        $res = $this->db->query("SELECT tckt.*, (SELECT emp_name FROM employee WHERE emp_id = tckt.ticket_added_by) added_by, (SELECT department_name FROM department WHERE dept_id = tckt.ticket_added_by_dept) added_by_dept, (SELECT department_name FROM department WHERE dept_id = tckt.ticket_assigned_to) assigned_to_dept, (SELECT req_name FROM `requesttype`  WHERE request_id = tckt.req_type) req_type_name FROM `ticket` tckt WHERE tckt.status = '1' AND tckt.ticket_closure = '".$statusType."' AND tckt.ticket_added_by_dept = '".$emp_dept."' AND tckt.ticket_added_by = '".$emp_id."'")->result_array();
                    }else{
                        //incomng
                        $res = $this->db->query("SELECT tckt.*, (SELECT emp_name FROM employee WHERE emp_id = tckt.ticket_added_by) added_by, (SELECT department_name FROM department WHERE dept_id = tckt.ticket_added_by_dept) added_by_dept, (SELECT department_name FROM department WHERE dept_id = tckt.ticket_assigned_to) assigned_to_dept, (SELECT req_name FROM `requesttype`  WHERE request_id = tckt.req_type) req_type_name FROM `ticket` tckt WHERE tckt.status = '1' AND tckt.ticket_closure = '".$statusType."' AND tckt.ticket_assigned_to = '".$emp_dept."'")->result_array();   
                    }
                }
            }

            $totalCnt = $this->db->query("SELECT count(ticket_id) as totalCnt FROM `ticket` WHERE status = '1'")->result_array();

            $resData['data'] = $res;
            $resData['filteredcount'] = count($res);
            $resData['count'] = $totalCnt[0]['totalCnt'];

            return $resData;
        }

        public function insert_remark($insertArray = null, $status = null, $ticket_ids = null){
            
            $res = $this->db->insert('approval_status', $insertArray);

            if($status == '1'){
                //pending

                if($res){
                    return $this->db->insert_id();
                }else{
                    return false;
                }
            }else if($status == '2'){
                //closed
                if($res){
                    $update = $this->db->where('ticket_id', $ticket_ids)
                                       ->update($this->table, array('ticket_closure' => '2', 'closed_at' => date("Y-m-d H:i:s"), 'closed_by' =>$insertArray['approved_by'] ));
                    return true;
                }else{
                    return false;
                }
            }
        }

        public function getremarks($ticket_id = null){
            $res = $this->db->query("SELECT ast.*, (SELECT emp_name FROM employee WHERE emp_id = ast.approved_by) approved_by_name, (SELECT (SELECT department_name FROM department WHERE dept_id = emp.emp_dept) dept_name FROM employee emp WHERE emp.emp_id = ast.approved_by) app_dept FROM `approval_status` ast WHERE ast.ticket_id = '".$ticket_id."' AND ast.status = '1'")->result_array();

            if(!empty($res)){
                return $res;
            }else{
                return false;
            }
        }

        public function deleteremarks($ticket_id = null){
            $res = $this->db->where('ticket_id', $ticket_id)
                            ->update($this->table, array('status' => '2'));

            if($res){
                $this->db->where('ticket_id', $ticket_id)
                         ->update('approval_status', array('status' => '2'));

                return true;
            }else{
                return false;
            }
        }

        public function closefile($ticket_id = null, $emp_id = null){
            $res = $this->db->where('ticket_id', $ticket_id)
                            ->update($this->table, array('ticket_closure'=>'2', 'closed_by' => $emp_id, 'closed_at' => date("Y-m-d H:i:s")));

            if($res){
                return true;
            }else{
                return false;
            }
        }

        public function getTicketData($ticket_id = null){
            $res = $this->db->query("SELECT * FROM ticket WHERE ticket_id = '$ticket_id'")->result_array();

            return $res;
        }
    }
?>