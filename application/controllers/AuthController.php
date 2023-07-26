<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AuthController extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->model('Users');
	}
	public function i() {
		var_dump('test');
	}
	public function action_register() {
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[users.email]');
		$this->form_validation->set_rules('password', 'Password', 'required');
		$this->form_validation->set_rules('name', 'Nama', 'required|is_unique[users.name]');
		$this->form_validation->set_rules('phone', 'Nomor HP', 'required|is_unique[users.phone]');
		$this->form_validation->set_rules('nik', 'Nomor Induk', 'required');
		$this->form_validation->set_rules('address', 'Alamat', 'required');

		if ($this->form_validation->run() == FALSE) {
				$this->session->set_flashdata('error', 'Registration gagal, '.str_replace(array("\r", "\n"), '', validation_errors()));
        redirect('/');
		} else {
			$email = $this->input->post('email');
			if ($this->Users->emailExists($email)) {
					$this->session->set_flashdata('error', 'The email is already registered.');
					redirect('home');
			}

			$data = array(
				'email' => $this->input->post('email'),
				'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
				'name' => $this->input->post('name'),
				'phone' => $this->input->post('phone'),
				'nik' => $this->input->post('nik'),
				'address' => $this->input->post('address'),
				'role' => 'customer'
			);

			$this->Users->register($data);

			$this->session->set_flashdata('success', 'Registration successful!');
			redirect($_SERVER['HTTP_REFERER']);
		}
	}
	public function action_login()
	{
			// Load the form validation library
			$this->load->library('form_validation');

			// Set validation rules
			$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
			$this->form_validation->set_rules('password', 'Password', 'required');

			// Run the validation
			if ($this->form_validation->run() == false) {
					// Validation failed

					// Store validation errors and old form data in flashdata
					$this->session->set_flashdata('error', 'Login gagal, '.str_replace(array("\r", "\n"), '', validation_errors()));
					$this->session->set_flashdata('old', $this->input->post());

					// Redirect to the login page
					redirect('/');
			} else {
				// Validation passed

        // Get the email and password from the POST data
        $email = $this->input->post('email');
        $password = $this->input->post('password');

        $user = $this->Users->login($email,$password);
        if ($user) {
            // Login successful
						$this->session->set_userdata('user', $user);

						// Redirect to the home page
						if ($user->role == 'admin') {
							redirect('/admin/dashboard');
						}
            redirect('/member/dashboard');
        } else {
            // Login failed

            // Set error flashdata
            $this->session->set_flashdata('error', 'Invalid email or password.');

            // Redirect to the login page
            redirect('/');
        }
			}
	}

	public function logout()
	{
			$this->session->unset_userdata('user');
			redirect('/');
	}

}
