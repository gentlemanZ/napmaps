<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Manage extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('users/manage_model');
        $this->load->model('warehouse/library_model');
        $this->load->model('warehouse/map_model');
        $this->load->model('warehouse/log_model');
	}

	public function index() {
		$data = array();
		$data['users'] = $this->manage_model->getList();
        $data['products'] = $this->library_model->getList();
        $data['reports'] = $this->log_model->getCommentList();
        $data['locations'] = $this->map_model->CommentParser($data['products'], $data['reports']);
        $data['map'] = $this->map_model->iniMap($data['locations']);
		$this->load->view('template/header_view.php');
        
		$this->load->view('index_view', $data);
	}

	public function edit($id) {
		$data = array();
		if (($id == 1) && (base_url() == DEMO_URL)) {
			die('Editing or deleting root on demo is forbidden!<br/> <a href="' . base_url() . '">Go to main page</a>');
		}
		if ($id == 0) {
			// add new	
			if ($this->input->post('sent')) {
				$this->manage_model->addUser($this->input->post('login'), $this->input->post('passwd'), $this->input->post('level'));
				redirect('users/manage', 'refresh');
			} else {
                $data['products'] = $this->library_model->getList();
                $data['reports'] = $this->log_model->getCommentList();
                $data['locations'] = $this->map_model->CommentParser($data['products'], $data['reports']);
                $data['map'] = $this->map_model->iniMap($data['locations']);
				$this->load->view('users/edit_view', $data);
			}
		} else {
			// edit
			if ($this->input->post('sent')) {
				$this->manage_model->updateUser($id, $this->input->post('login'), $this->input->post('passwd'), $this->input->post('level'));
				redirect('users/manage', 'refresh');
			} else {
				$data['user'] = $this->manage_model->getUser($id);
                $data['products'] = $this->library_model->getList();
                $data['reports'] = $this->log_model->getCommentList();
                $data['locations'] = $this->map_model->CommentParser($data['products'], $data['reports']);
                $data['map'] = $this->map_model->iniMap($data['locations']);
				$this->load->view('users/edit_view', $data);
			}
		}
	}

	public function del($id) {
		if (($id == 1) && (base_url() == DEMO_URL)) {
			die('Editing or deleting root on demo is forbidden!<br/> <a href="' . base_url() . '">Go to main page</a>');
		}
		$this->manage_model->delUser($id);
		redirect('users/manage', 'refresh');
	}

}
