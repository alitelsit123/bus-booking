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
		public function find($id)
    {	
        return $this->db->get_where('users', ['id' => $id])->row();
    }

		public function emailExists($email) {
			$this->db->where('email', $email);
			$query = $this->db->get('users');
			return $query->num_rows() > 0;
		}
		public function getUserInfoByEmail($email)
    {
        $q = $this->db->get_where('users', array('email' => $email), 1);
        if ($this->db->affected_rows() > 0) {
            $row = $q->row();
            return $row;
        }
    }
		public function isTokenValid($token)
    {
        $tkn = substr($token, 0, 30);
        $uid = substr($token, 30);

        $q = $this->db->get_where('password_reset_tokens', array(
            'password_reset_tokens.token' => $tkn,
            'password_reset_tokens.user_id' => $uid
        ), 1);

        if ($this->db->affected_rows() > 0) {
            $row = $q->row();

            $created = $row->created;
            $createdTS = strtotime($created);
            $today = date('Y-m-d');
            $todayTS = strtotime($today);

            if ($createdTS != $todayTS) {
                return false;
            }

            $user_info = $this->find($row->user_id);
            return $user_info;
        } else {
            return false;
        }
    }
		public function updatePassword($post)
    {
        $this->db->where('id', $post['id']);
        $this->db->update('users', array('password' => $post['password']));
        return true;
    }
		public function insertToken($user_id)
    {
        $token = substr(sha1(rand()), 0, 30);
        $date = date('Y-m-d');

        $string = array(
            'token' => $token,
            'user_id' => $user_id,
            'created' => $date
        );
        $query = $this->db->insert_string('password_reset_tokens', $string);
        $this->db->query($query);
        return $token . $user_id;
    }
		public function update($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('users', $data);
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
