<?php
	
	class DepartmentModel extends CI_Model{
        function __construct() {
            // Set table name
            $this->table = 'department';
        }

        public function insert($deptData = null){
            if(!empty($deptData)){

            	$res = $this->db->insert($this->table,$deptData);
            	if($res){
            		return $this->db->insert_id();
            	}else{
            		return null;
            	}
            }else{
            	return null;
            }
        }

        public function getData($searchVal = null, $i = null, $rowperpage = null, $columnIndex = null, $columnName = null, $columnSortOrder = null){
        	if($searchVal != ''){
        		$res = $this->db->query("SELECT * FROM `department` WHERE department_name LIKE '%".$searchVal."%'")->result_array();
        	}else{
        		$res = $this->db->query("SELECT * FROM `department`")->result_array();
        	}

        	$totalCnt = $this->db->query("SELECT count(dept_id) as totalCnt FROM `department`")->result_array(); 

        	$resData['data'] = $res;
        	$resData['filteredcount'] = count($res);
        	$resData['count'] = $totalCnt[0]['totalCnt'];
        	return $resData;
        }

        public function getEditData($dept_id = null){
        	if($dept_id != ''){
        		$res = $this->db->query("SELECT * FROM `department` WHERE dept_id = '".$dept_id."'")->result_array();

        		return $res;
        	}else{
        		return null;
        	}
        }

        public function editDeptData($dept_id = null, $dept_name = null){
        	if($dept_id != ''){
        		$res = $this->db->query("UPDATE department SET department_name = '".$dept_name."' WHERE dept_id = '".$dept_id."'");

        		if($res){
        			return true;
        		}else{
        			return false;
        		}
        	}else{
        		return false;
        	}
        }

        public function deleteDept($deptid = null, $status = null){
        	if($deptid != ''){

        		$res = $this->db->where('dept_id', $deptid)
                                ->update($this->table, array('status' => $status));

        		if($res){
        			return true;
        		}else{
        			return false;
        		}
        	}
        }
        
        //SubDepartment Section
		public function getSubDept($searchVal = null, $i = null, $rowperpage = null, $columnIndex = null, $columnName = null, $columnSortOrder = null){

			if($searchVal != ''){
        		$res = $this->db->query("SELECT t1.* FROM (SELECT sd.*, (SELECT department_name FROM department WHERE dept_id = sd.dept_id) main_dept FROM `sub_department` sd WHERE sd.is_deleted = '1') t1 WHERE (t1.main_dept LIKE '%".$searchVal."%' OR t1.sub_name LIKE '%".$searchVal."%')")->result_array();
        	}else{
        		$res = $this->db->query("SELECT sd.*, (SELECT department_name FROM department WHERE dept_id = sd.dept_id) main_dept FROM `sub_department` sd WHERE sd.is_deleted = '1'")->result_array();
        	}
			
			$totalCnt = $this->db->query("SELECT count(sub_id) as totalCnt FROM `sub_department` WHERE is_deleted = '1'")->result_array(); 

        	$resData['data'] = $res;
        	$resData['filteredcount'] = count($res);
        	$resData['count'] = $totalCnt[0]['totalCnt'];
        	return $resData;
		}

		public function getDepartment() {
			$res = $this->db->query("SELECT * FROM `department` WHERE status = '1'")->result_array();

			if(!empty($res)){
				return $res;
			}else{
				return null;
			}
		}

		public function addSub($insertData = null){
			if(!empty($insertData)){
				$res = $this->db->insert("sub_department",$insertData);
				if($res){
					return true;
				}else{
					return false;
				}
			}
		}

		public function deleteSubDept($subdept_id = null, $status = null) {
			if($subdept_id != ''){

        		$res = $this->db->where('sub_id', $subdept_id)
                                ->update("sub_department", array('status' => $status));

        		if($res){
        			return true;
        		}else{
        			return false;
        		}
        	}
		}

		public function getSubEditData($subdept_id = null, $deptId = null) {
			if($subdept_id != ''){
				$res = $this->db->query("SELECT * FROM `sub_department` WHERE sub_id = '".$subdept_id."' AND is_deleted = '1'")->result_array();
				if(!empty($res)){
					return $res;
				}else{
					return null;
				}
			}
		}

		public function removeSubDept($subdept_id = null) {
			if($subdept_id != ''){
				$res = $this->db->where('sub_id', $subdept_id)
								->update("sub_department", array('is_deleted' => '2'));
				if($res){
					return true;
				}else{
					return false;
				}
			}
		}

		public function editSubDepartment($updateArray = null, $deptName = null, $subId = null) {
			if($deptName != ''){
				$res = $this->db->where('sub_id', $subId)
								->update("sub_department", $updateArray);
				if($res){
					return true;
				}else{
					return false;
				}
			}
		}
    }    

?>