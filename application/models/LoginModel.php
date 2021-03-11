<?php
	
	class LoginModel extends CI_Model{
        function __construct() {
            // Set table name
            $this->table = 'employee';
        }

        public function checkLogin($email = null, $password = null, $usertype = null){
        	if($usertype != ''){
        		$res = $this->db->query("SELECT COUNT(emp_id) ttlcnt FROM employee WHERE emp_email = '".$email."' AND emp_password = '".md5($password)."' AND emp_type = '".$usertype."' AND status = '1'")->result_array();

        		if($res[0]['ttlcnt'] > 0){
        			$userData = $this->db->query("SELECT emp.*, (SELECT department_name FROM department WHERE dept_id = emp.emp_dept) dept_name FROM `employee` emp WHERE emp.emp_email = '".$email."' AND emp.emp_password = '".md5($password)."' AND emp.emp_type = '".$usertype."' AND emp.status = '1'")->result_array();

        			return $userData;
        		}else{
        			return false;
        		}
        	}
        }
    }

?>