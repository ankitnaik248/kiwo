<?php

    class ReqModel extends CI_Model{
        function __construct() {
            // Set table name
            $this->table = 'requesttype';
        }

        public function getData($searchVal = null, $i = null, $rowperpage = null, $columnIndex = null, $columnName = null, $columnSortOrder = null){
        	if($searchVal != ''){
        		$res = $this->db->query("SELECT * FROM `requesttype` WHERE req_name LIKE '%".$searchVal."%'")->result_array();
        	}else{
        		$res = $this->db->query("SELECT * FROM `requesttype`")->result_array();
        	}

        	$totalCnt = $this->db->query("SELECT count(request_id) as totalCnt FROM `requesttype`")->result_array(); 

        	$resData['data'] = $res;
        	$resData['filteredcount'] = count($res);
        	$resData['count'] = $totalCnt[0]['totalCnt'];
        	return $resData;
        }

        public function insert($reqArray = null){
            if(!empty($reqArray)){

            	$res = $this->db->insert($this->table,$reqArray);
            	if($res){
            		return $this->db->insert_id();
            	}else{
            		return null;
            	}
            }else{
            	return null;
            }
        }

        public function deleteReq($reqid = null, $status = null){
        	if($reqid != ''){

        		$res = $this->db->where('request_id', $reqid)
                                ->update($this->table, array('status' => $status));

        		if($res){
        			return true;
        		}else{
        			return false;
        		}
        	}
        }

        public function editReqData($req_id = null, $req_type = null){
        	if($req_id != ''){
        		$res = $this->db->query("UPDATE requesttype SET req_name = '".$req_type."' WHERE request_id = '".$req_id."'");

        		if($res){
        			return true;
        		}else{
        			return false;
        		}
        	}else{
        		return false;
        	}
        }

        public function getEditData($req_id = null){
        	if($req_id != ''){
        		$res = $this->db->query("SELECT * FROM `requesttype` WHERE request_id = '".$req_id."'")->result_array();

        		return $res;
        	}else{
        		return null;
        	}
        }
    }
?>    