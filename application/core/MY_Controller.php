<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        // Load the session library
        $this->load->library('session');

        // Check if the user is logged in

        $this->checkLogin();
    }

    protected function checkLogin()
    {
        // Add the controller and method names that should not require login
        $publicControllers = array(
            'AuthController' => array('login'),
            'HomeController' => array('login'),
            // Add more public controllers and methods as needed
        );

        // Get the current controller and method names
        $controller = $this->router->fetch_class();
        $method = $this->router->fetch_method();

        // Check if the current controller and method are public
        if (isset($publicControllers[$controller]) && in_array($method, $publicControllers[$controller])) {
            return; // Skip login check for public controllers and methods
        }

        // Check if the user is logged in
        if (!$this->isLoggedIn()) {
            // Set an error flashdata
            $this->session->set_flashdata('error', 'Please log in.');

            // Redirect to the login page or any other desired page
            redirect('/');
        }
    }

    protected function isLoggedIn()
    {
        // Check if the user is logged in by checking the presence of required session data
        return $this->session->userdata('user') !== null;
    }
		protected function updateAttribute()
		{
			$this->load->model('Base_model');
			$this->Base_model->setTable($this->input->post('table'));
			$payload[$this->input->post('attr')] = $this->input->post('value');
			$this->Base_model->update($this->input->post('id'), $payload);
			echo 'ok';
		}
}
