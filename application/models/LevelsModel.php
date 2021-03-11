<?php
	class LevelsModel extends CI_Model{
        function __construct() {
            // Set table name
            $this->table = 'levels';
        }

        function getData($searchVal = null, $i = null, $rowperpage = null, $columnIndex = null, $columnName = null, $columnSortOrder = null){
            if($searchVal != ''){
        		$res = $this->db->query("SELECT * FROM `levels` WHERE is_deleted = '1' AND level_name LIKE '%".$searchVal."%'")->result_array();
        	}else{
        		$res = $this->db->query("SELECT * FROM `levels` WHERE is_deleted = '1'")->result_array();
        	}

        	$totalCnt = $this->db->query("SELECT count(level_id) as totalCnt FROM `levels`")->result_array(); 

        	$resData['data'] = $res;
        	$resData['filteredcount'] = count($res);
        	$resData['count'] = $totalCnt[0]['totalCnt'];
        	return $resData;
        }

        function createLevel($insertArray) {
            if(!empty($insertArray)){
                $res = $this->db->insert($this->table, $insertArray);

                if($res){
                    return true;
                }else{
                    return false;
                }
            }
        }

        function deleteLevel($levelid = null, $status = null) {
            $res = $this->db->where('level_id', $levelid)
                                ->update($this->table, array('status' => $status));

            if($res){
                return true;
            }else{
                return false;
            }
        }

        function getEditData($level_id = null){
            $res = $this->db->query("SELECT * FROM `levels` WHERE level_id = '".$level_id."'")->result_array();

            if(!empty($res)){
                return $res;
            }else{
                return null;
            }
        }

        public function editLevel($updateArray = null, $level_id = null) {
            if($level_id != ''){
                $res = $this->db->where('level_id', $level_id)
                                ->update($this->table, $updateArray);
                if($res){
                    return true;
                }else{
                    return true;
                }
            }else{
                return false;
            }
        }
    }
?>