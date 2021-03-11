<?php

    class EmployeeModel extends CI_Model{
        function __construct() {
            // Set table name
            $this->table = 'employee';
        }

        public function insert($empData = null){
            if(!empty($empData)){
                $result = $this->db->insert($this->table,$empData);
                if($result) {
                    return $this->db->insert_id();
                } else {
                    return null;
                }
            }else{
                return null;
            }
        }

        public function getData($searchVal = null, $i = null, $rowperpage = null, $columnIndex = null, $columnName = null, $columnSortOrder = null){
            if($searchVal != ''){
                $res = $this->db->query("SELECT t1.* FROM (SELECT emp.*, (SELECT department_name FROM department WHERE dept_id = emp.emp_dept) dept_name FROM `employee` emp) t1 WHERE (t1.emp_name LIKE '%".$searchVal."%' OR t1.emp_email LIKE '%".$searchVal."%' OR t1.emp_mobile LIKE '%".$searchVal."%' OR t1.dept_name LIKE '%".$searchVal."%' OR t1.date_added LIKE '%".$searchVal."%')")->result_array();
            }else{
                $res = $this->db->query("SELECT emp.*, (SELECT department_name FROM department WHERE dept_id = emp.emp_dept) dept_name FROM `employee` emp")->result_array();
            }

            $totalCnt = $this->db->query("SELECT count(emp_id) as totalCnt FROM `employee`")->result_array();

            $resData['data'] = $res;
            $resData['filteredcount'] = count($res);
            $resData['count'] = $totalCnt[0]['totalCnt'];

            return $resData;
        }

        public function checkEmail($email = null) {
            if($email != ''){
                $res = $this->db->query("SELECT COUNT(emp_id) ttlcnt FROM employee WHERE emp_email = '".$email."'")->result_array();

                return $res;
            }
        }

        public function getEmpData($emp_id = null){
            if($emp_id != ''){
                $empData = $this->db->query("SELECT * FROM `employee` WHERE emp_id = '".$emp_id."'")->result_array();
                if(!empty($empData)){
                    return $empData;
                }else{
                    return false;
                }
            }else{
                return false;
            }
        }

        public function getDept(){
            $deptData = $this->db->query("SELECT * FROM department WHERE status = '1'")->result_array();

            return $deptData;
        }

        public function editData($insertArray = null, $emp_id = null){
            if($emp_id != ''){
                $res = $this->db->where('emp_id', $emp_id)
                                ->update($this->table, $insertArray);
                return true;
            }else{
                return false;
            }
        }

        public function deleteEmp($empid = null, $status = null){
            if($empid != ''){
                $res = $this->db->where('emp_id', $empid)
                                ->update($this->table, array('status' => $status));
                if($res){
                    return true;
                }else{
                    return false;
                }
            }else{
                return false;
            }
        }
    }

?>