<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Type_model extends CI_Model
{
    protected $table = 'types';

    public function create($data)
		{
				return $this->db->insert($this->table, $data);
		}

		public function find($id)
    {	
        return $this->db->get_where($this->table, ['id' => $id])->row();
    }
    public function update($id, $name)
    {
        $data = array(
            'name' => $name,
        );
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
        return $this->db->get('types')->result();
    }
}
