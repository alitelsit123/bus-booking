<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Book_model extends CI_Model
{
    protected $table;

    public function __construct()
    {
        parent::__construct();
				$this->table = 'bookings';
    }
    public function create($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    public function find($id)
    {	
        return $this->db->get_where($this->table, ['id' => $id])->row();
    }
		public function adminPendingCount() {
			return $this->db->get_where($this->table, ['status' => 'pending'])->num_rows();
		}
		public function pendingCount()
    {	
        return $this->db->get_where($this->table, ['status' => 'pending', 'user_id' => $this->session->userdata('user')->id])->num_rows();
    }
		public function myBooks()
    {
        return $this->db->get_where($this->table,[
					'user_id' => $this->session->userdata('user')->id
				])->result();
    }
		public function getAll()
    {
        return $this->db->get($this->table)->result();
    }

    public function update($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update($this->table, $data);
        return $this->db->affected_rows();
    }

    public function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete($this->table);
        return $this->db->affected_rows();
    }
}
