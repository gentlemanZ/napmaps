<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Main extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('warehouse/log_model');
		$this->load->model('warehouse/library_model');
		$this->load->model('warehouse/packing_model');
		$this->load->model('users/manage_model');
        $this->load->model('warehouse/map_model');
	}

	public function index() {
		$data = array();
        $data['products'] = $this->library_model->getList();
        $data['reports'] = $this->log_model->getCommentList();
        $data['locations'] = $this->map_model->CommentParser($data['products'], $data['reports']);
        $data['map'] = $this->map_model->iniMap($data['locations']);
        
        $this->load->view('template/header_view.php');
        
		$this->load->view('index_view', $data);
	}

	public function noaccess() {
		$data = array();
		$this->load->view('noaccess_view', $data);
	}
	
	public function version($requestor) {
		if($requestor != '') {
			// DDOS SEC log
			// log_message('error', 'REQ ' . $requestor);
			echo VERSION;
		}
	}
}
