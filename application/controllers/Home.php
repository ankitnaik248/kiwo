<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
    
    public $dashboard;
    
	public function __construct() {
        parent::__construct();
        ob_start();
        $this->load->model('LoginModel');
        $this->load->model('DashboardModel');
		
		$this->dashboard['data'] = $this->DashboardModel->getData($this->session->userdata('user_session'));
    }

	public function index()
	{
		if($this->session->userdata('user_session')){
			$this->load->view('dashboard', $this->dashboard);
		}else{
			$this->load->view('login');	
		}
	}

	public function logincheck(){
		extract($_POST);
		$res = $this->LoginModel->checkLogin($email, $password, $usertype);
        
		if($res){
			$this->session->set_userdata('user_session',$res);
		
			$data['success'] = 1;
			$data['message'] = "Login Successful";
		}else{
			$data['success'] = 2;
			$data['message'] = "Login Failed";
		}

		echo json_encode($data);
	}

	public function dashboard(){
		if($this->session->userdata('user_session')){
			$this->load->view('dashboard', $this->dashboard);
		}else{
			$this->load->view('login');
		}
	}

	public function logout(){
		$this->session->sess_destroy();

		redirect('home/index');
	}
	
}
