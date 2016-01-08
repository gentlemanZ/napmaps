<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Library extends CI_Controller {

	public function __construct() {
		parent::__construct();
		if (!$this->session->userdata('admin_lvl')) {
			die(redirect(base_url() . 'main/noaccess'));
		}
		$this->load->model('warehouse/library_model');
        $this->load->model('warehouse/map_model');
        $this->load->model('warehouse/log_model');
	}

	public function index() {
		$this->edit(0);
	}

	public function edit($id) {
		$data = array();
		$data['products'] = $this->library_model->getList();
        $data['reports'] = $this->log_model->getCommentList();
        $data['locations'] = $this->map_model->CommentParser($data['products'], $data['reports']);
        $data['map'] = $this->map_model->iniMapC($data['locations']);
		if ($id == 0) {
			// add new	
			if ($this->input->post('sent')) {
				$this->library_model->addProduct($this->input->post('name'), $this->input->post('lat'),$this->input->post('lng'),$this->input->post('desc'));
				redirect('warehouse/library', 'refresh');
			} else {
				$this->load->view('warehouse/edit_view', $data);
			}
		} else {
			// edit
			if ($this->input->post('sent')) {
				$this->library_model->updateProduct($id, $this->input->post('name'), $this->input->post('desc'));
				redirect('warehouse/library', 'refresh');
			} else {
				$data['user'] = $this->library_model->getProduct($id);
				$this->load->view('warehouse/edit_view', $data);
			}
		}
	}

	public function del($id) {
		if (!$this->session->userdata('admin_lvl')) {
			die(redirect(base_url() . 'main/noaccess'));
		}
		$this->library_model->delProduct($id);
		redirect('warehouse/library', 'refresh');
	}

}
