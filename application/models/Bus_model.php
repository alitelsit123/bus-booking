<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bus_model extends CI_Model
{
    protected $table = 'busses';

    public function create($data)
		{
				return $this->db->insert($this->table, $data);
		}


    public function update($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update($this->table, $data);
    }
		public function find($id)
    {	
        return $this->db->get_where($this->table, ['id' => $id])->row();
    }
		public function search($search)
    {	
			$this->db->select('id');
			$this->db->group_start();
			$this->db->like('name',$search);
			$this->db->group_end();
        return $this->db->get($this->table)->result_array();
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
