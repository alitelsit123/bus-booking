<?php

class Company extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Company_model');
        $this->load->model('Base_model');
				$this->Base_model->setTable('companies');
    }
		public function index(){
			$this->load->view('admin/company');
		}
		public function update() {
			// Set validation rules
			$this->form_validation->set_rules('name', 'Nama', 'required');
			$this->form_validation->set_rules('address', 'Alamat', 'required');
			$this->form_validation->set_rules('phone', 'Nomor Telepon', 'required');
			$this->form_validation->set_rules('email', 'Email', 'required');
			$this->form_validation->set_rules('address', 'Alamat', 'required');

			if ($this->form_validation->run() == false) {
					// Validation failed
					$this->session->set_flashdata('error', validation_errors());
			} else {
					// Validation passed, proceed with updating the record
					$id = $this->input->post('id');
					$name = $this->input->post('name');
					$alias = $this->input->post('alias');
					$phone = $this->input->post('phone');
					$email = $this->input->post('email');
					$address = $this->input->post('address');
					$data = [
						'name' => $name,
						'alias' => $alias,
						'phone' => $phone,
						'email' => $email,
						'address' => $address
					];
					// Call the update() method in the Type_model
					$this->Company_model->update($id, $data);

					// Set success flashdata
					$this->session->set_flashdata('success', 'Type updated successfully.');
			}

			// Redirect back to the previous page
			redirect($_SERVER['HTTP_REFERER']);
		}
}
