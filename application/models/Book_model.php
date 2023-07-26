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

    public function range($awal, $akhir)
    {
        // $this->db->get_where( ['date BETWEEN ' . $awal . ' AND ' . $akhir])->num_rows();
		$this->db->from('bookings');
		return $this->db->where('date BETWEEN "' . $awal . '" AND "' . $akhir . '"')->get();
        // return $this->db->affected_rows();
    }
	public function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete($this->table);
        return $this->db->affected_rows();
    }
		public function getBookDataByDateRange($startDate, $endDate, $bus_ids) {
			$this->db->select('DATE(payment_date) AS date, SUM(gross_amount) AS total');
			$this->db->from($this->table);
			if (sizeof($bus_ids) > 0) {
				$array = $bus_ids;
				for ($i = 0; $i < count($array); $i++) {
					$array[$i] = intval($array[$i]);
				}
				$this->db->where_in('bus_id', $array);
			}
			$where = "payment_date is  NOT NULL";
			$this->db->where($where);
			if ($startDate) {
				$this->db->where('payment_date >=', $startDate);
				$this->db->where('payment_date <=', $endDate);
			}
			$this->db->group_by('DATE(payment_date)');
			$query = $this->db->get();
			return $query->result();
	}
	public function getBookDataByWDateRange() {
		$this->db->select('DATE(payment_date) AS date, SUM(gross_amount) AS total');
		$this->db->from($this->table);
		$this->db->group_by('DATE(payment_date)');
		$query = $this->db->get();
		return $query->result();
}
public function getBookDataByDateRanges($startDate, $endDate, $bus_ids) {
	$this->db->select('busses.name as date, count(busses.name) AS total');
	$this->db->from($this->table);
	if (sizeof($bus_ids) > 0) {
		$array = $bus_ids;
		for ($i = 0; $i < count($array); $i++) {
			$array[$i] = intval($array[$i]);
		}
		$this->db->where_in('bookings.bus_id', $array);
	}
	$where = "bookings.payment_date is  NOT NULL";
	$this->db->where($where);
	if ($startDate) {
		$this->db->where('DATE(bookings.payment_date) >=', $startDate.' 00:00:00');
		$this->db->where('DATE(bookings.payment_date) <=', $endDate.' 00:00:00');
	}
$this->db->join('busses', 'busses.id=bookings.bus_id');
$this->db->group_by('busses.name');
$query = $this->db->get();
return $query->result();
}
public function getBookDataByWDateRanges() {
$this->db->select('busses.name as date, count(busses.name) AS total');
$this->db->from($this->table);
$this->db->join('busses', 'busses.id=bookings.bus_id');
$this->db->group_by('busses.name');
$query = $this->db->get();
return $query->result();
}
}
