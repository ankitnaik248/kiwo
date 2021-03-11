<?php
	
	class DashboardModel extends CI_Model{
        function __construct() {
            // Set table name
            $this->table = 'department';
        }

        public function getData($sessionData = null){
            $data = array();

            $departments = $this->db->query("SELECT dept_id, department_name FROM `department` WHERE status = '1'")->result_array();

            $deptArray = array();
            $totalTickets = array();
            $tickets_resolved = array();
            $ticket_pending = array();
            $average = array();

            $totalTicketsraised = array();
            $tickets_resolved_dept = array();
            $ticket_pending_dept = array();
            $average_dept = array();
            
            $max_empname = array();
            $min_empname = array();

            foreach($departments as $value){
                $deptArray[] = $value['department_name'];

                $deptWiseTotal = $this->db->query("SELECT COUNT(t2.ticket_id) total_tickets, COUNT(t2.avg_hr) tickets_resolved, COUNT(t2.pending) ticket_pending, ROUND(AVG(t2.avg_hr),2) average FROM (SELECT t1.*,(SELECT IFNULL(TIMESTAMPDIFF(Hour,closed_at,created_at),0) FROM ticket WHERE ticket_id = t1.ticket_id AND ticket_closure = '2') avg_hr, (SELECT ticket_id FROM ticket WHERE ticket_id = t1.ticket_id AND ticket_closure = '1') pending FROM (SELECT * FROM `ticket` WHERE status = '1' AND ticket_assigned_to = '".$value['dept_id']."' ) t1) t2")->result_array();

                $totalTickets[] = $deptWiseTotal[0]['total_tickets'];
                $tickets_resolved[] = $deptWiseTotal[0]['tickets_resolved'];
                $ticket_pending[] = $deptWiseTotal[0]['ticket_pending'];
                $average[] = $deptWiseTotal[0]['average'];

                $deptWiseRaised = $this->db->query("SELECT COUNT(t2.ticket_id) total_tickets, COUNT(t2.avg_hr) tickets_resolved, COUNT(t2.pending) ticket_pending, ROUND(AVG(t2.avg_hr),2) average FROM (SELECT t1.*,(SELECT IFNULL(TIMESTAMPDIFF(Hour,closed_at,created_at),0) FROM ticket WHERE ticket_id = t1.ticket_id AND ticket_closure = '2') avg_hr, (SELECT ticket_id FROM ticket WHERE ticket_id = t1.ticket_id AND ticket_closure = '1') pending FROM (SELECT * FROM `ticket` WHERE status = '1' AND ticket_added_by_dept = '".$value['dept_id']."' ) t1) t2")->result_array();

                $totalTicketsraised[] = $deptWiseRaised[0]['total_tickets'];
                $tickets_resolved_dept[] = $deptWiseRaised[0]['tickets_resolved'];
                $ticket_pending_dept[] = $deptWiseRaised[0]['ticket_pending'];
                $average_dept[] = $deptWiseRaised[0]['average'];
                
                $getmax_emp = $this->db->query("SELECT COUNT(tk.ticket_id) total, (SELECT emp_name FROM employee WHERE emp_id = tk.closed_by) empname FROM ticket tk WHERE tk.ticket_closure = '2' AND tk.status = '1' AND tk.ticket_assigned_to = '".$value['dept_id']."' GROUP BY tk.closed_by ORDER BY total DESC LIMIT 1")->result_array();
                
                if(!empty($getmax_emp)){
                    $max_empname[] = $getmax_emp[0]['empname'];
                }else{
                    $max_empname[] = 'No Data';
                }
                
                $getmin_emp = $this->db->query("SELECT COUNT(tk.ticket_id) total, (SELECT emp_name FROM employee WHERE emp_id = tk.closed_by) empname FROM ticket tk WHERE tk.ticket_closure = '2' AND tk.status = '1' AND tk.ticket_assigned_to = '".$value['dept_id']."' GROUP BY tk.closed_by ORDER BY total ASC LIMIT 1")->result_array();
                
                if(!empty($getmin_emp)){
                    $min_empname[] = $getmin_emp[0]['empname'];    
                }else{
                    $min_empname[] = 'No Data';
                }
            }

            $data['department'] = $deptArray;
            $data['total_ticket'] = $totalTickets;
            $data['ticket_resolved'] = $tickets_resolved;
            $data['ticket_pending'] = $ticket_pending;
            $data['average'] = $average;

            $data['tickets_raised'] = $totalTicketsraised;
            $data['ticket_resolved_dept'] = $tickets_resolved_dept;
            $data['ticket_pending_dept'] = $ticket_pending_dept;
            $data['average_dept'] = $average_dept;
            
            $data['max_empname'] = $max_empname;
            $data['min_empname'] = $min_empname;
            // echo "<pre>";print_r($data);exit;
            return $data;
        }
    }

?>