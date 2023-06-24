<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Type extends MY_Controller {
	public function __construct()
	{
			parent::__construct();
			$this->load->model('Type_model');
			$this->load->library('form_validation');
	}

	public function index(){
		$this->load->view('admin/type');
	}

	public function create()
	{
			// Set validation rules
			$this->form_validation->set_rules('name', 'Name', 'required');

			if ($this->form_validation->run() == false) {
					// Validation failed
					$this->session->set_flashdata('error', validation_errors());
			} else {
					// Validation passed, proceed with creating the record
					$name = $this->input->post('name');

					// Call the create() method in the Type_model
					$this->Type_model->create(['name' => $name]);

					// Set success flashdata
					$this->session->set_flashdata('success', 'Type created successfully.');
			}

			// Redirect back to the previous page
			redirect($_SERVER['HTTP_REFERER']);
	}

	public function update()
	{
			// Set validation rules
			$this->form_validation->set_rules('name', 'Name', 'required');

			if ($this->form_validation->run() == false) {
					// Validation failed
					$this->session->set_flashdata('error', validation_errors());
			} else {
					// Validation passed, proceed with updating the record
					$id = $this->input->post('id');
					$name = $this->input->post('name');

					// Call the update() method in the Type_model
					$this->Type_model->update($id, $name);

					// Set success flashdata
					$this->session->set_flashdata('success', 'Type updated successfully.');
			}

			// Redirect back to the previous page
			redirect($_SERVER['HTTP_REFERER']);
	}


	public function delete($id)
	{
			// Call the delete() method in the Type_model
			$this->Type_model->delete($id);
			$this->session->set_flashdata('success', 'Type delete successfully.');
			// Redirect or show success message
			redirect($_SERVER['HTTP_REFERER']);
	}
}
