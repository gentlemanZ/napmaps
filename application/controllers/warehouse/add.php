<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Add extends CI_Controller {

	public function __construct() {
		parent::__construct();
		if (!$this->session->userdata('user_lvl')) {
			die(redirect(base_url() . 'main/noaccess'));
		}
		$this->load->model('warehouse/library_model');
		$this->load->model('warehouse/log_model');
        $this->load->model('warehouse/map_model');
	}

	public function index() {
		
	}

	// id = 1
	public function production() {
		if (!$this->session->userdata('admin_lvl')) {
			die(redirect(base_url() . 'main/noaccess'));
		}
		$data = array();
		if ($this->input->post('sent')) {
			$this->log_model->addAction($this->input->post('id'), $this->input->post('amount'), 1, 0, $this->input->post('oid'));
            $this->library_model->updateStatus($this->input->post('id'), $this->input->post('status'));
		}

		$data['products'] = $this->library_model->getList();
		$data['reports'] = $this->log_model->getCommentList();
        $data['locations'] = $this->map_model->CommentParser($data['products'], $data['reports']);
        $data['map'] = $this->map_model->iniMap($data['locations']);
        
        
		$this->load->view('warehouse/add/production_view', $data);
	}



}
