<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function register($data) {
        $this->db->insert('users', $data);
        return $this->db->insert_id();
    }

		public function emailExists($email) {
			$this->db->where('email', $email);
			$query = $this->db->get('users');
			return $query->num_rows() > 0;
		}
		public function find($id)
    {	
        return $this->db->get_where('users', ['id' => $id])->row();
    }

		public function login($email,$password) {
			$query = $this->db->get_where('users', array('email' => $email));
			$user = $query->row();
			if (password_verify($password, $user->password)) {
				return $user;
			} else {
				return null;
			}
		}
}
