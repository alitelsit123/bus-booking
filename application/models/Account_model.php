<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Account_model extends CI_Model
{
    protected $table = 'users';

    public function create($data)
		{
				return $this->db->insert($this->table, $data);
		}


    public function update($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update($this->table, $data);
    }

    public function delete($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete($this->table);
    }
		public function getAll()
    {
        return $this->db->get($this->table)->result();
    }
}
