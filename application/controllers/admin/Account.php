<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Account extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
    }
		public function index(){
			$this->load->view('admin/users');
		}

    public function update($id)
    {
			$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
			$this->form_validation->set_rules('name', 'Nama', 'required');
			$this->form_validation->set_rules('phone', 'Nomor HP', 'required');
			$this->form_validation->set_rules('nik', 'Nomor Induk', 'required');
			$this->form_validation->set_rules('address', 'Alamat', 'required');

			if ($this->form_validation->run() == FALSE) {
					$this->session->set_flashdata('error', 'Update gagal, '.str_replace(array("\r", "\n"), '', validation_errors()));
					redirect('/');
			} else {
				$email = $this->input->post('email');
				// if ($this->Users->emailExists($email)) {
				// 		$this->session->set_flashdata('error', 'The email is already registered.');
				// 		redirect($_SERVER['HTTP_REFERER']);
				// }

				$data = array(
					'email' => $this->input->post('email'),
					'name' => $this->input->post('name'),
					'phone' => $this->input->post('phone'),
					'nik' => $this->input->post('nik'),
					'address' => $this->input->post('address'),
					'role' => 'customer'
				);


				$this->Users->update($id,$data);

				$this->session->set_flashdata('success', 'Akun diubah!');
				redirect($_SERVER['HTTP_REFERER']);
    }
	}

    public function delete($id)
    {
        $this->Account_model->delete($id);
        $this->session->set_flashdata('success', 'Akun deleted successfully.');
				redirect($_SERVER['HTTP_REFERER']);
    }

    private function uploadImage()
    {
        // Logic to upload the image to {root_dir}/assets/image
        // Replace this with your actual implementation
    }

		public function validateImage()
		{
				// Check if a file is selected
				if (empty($_FILES['image']['name'])) {
						// No file selected, but it's not a required field
						return true;
				}

				// Set the allowed file types and maximum file size
				$config['upload_path'] = './assets/upload';
				$config['allowed_types'] = 'jpg|jpeg|png';
				$config['max_size'] = 2048; // 2MB
				$config['file_name'] = uniqid();

				// Load the upload library and initialize
				$this->load->library('upload', $config);

				// Perform the file upload
				if (!$this->upload->do_upload('image')) {
						// File upload failed, set validation error message
						$error = $this->upload->display_errors();
        		$this->session->set_flashdata('error', $error);
						return false;
				} else {
					$uploadData = $this->upload->data();
					$imagePath = $config['file_name'];
					$dname = explode(".", $_FILES['image']['name']);
					$ext = end($dname);
					if ($this->input->is_ajax_request()) {
						echo $imagePath.'.'.$ext;
					}
					return $imagePath.'.'.$ext;
				}

				// File uploaded successfully
				return true;
		}
		public function updateAttribute() {
			parent::updateAttribute();
		}
}
