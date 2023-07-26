<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transaction extends MY_Controller {

	public function index(){
		$startDate = $this->input->get('startDate');
		$endDate = $this->input->get('endDate');
		$search = $this->input->get('search');
		$this->load->view('admin/transaction');
	}
	public function invoice($id) {
		$book = $this->Book_model->find($id);
		$this->load->view('admin/invoice', ['book' => $book]);
	}
	public function cetak() {
		$awal = $this->input->post('awal');
		$akhir = $this->input->post('akhir');
		$bus = $this->input->post('bus');
		// $search = $this->input->post('search');

		if (!$awal) {
			$cek = '0';
			$data = $this->Book_model->getAll();
			$this->load->view('admin/cetak', ['data' => $data, 'cek' => $cek, 'bus' => $bus]);
		} else {
			// $busIds = $this->Bus_model->search($search);
			// $data = $this->Book_model->getBookDataByDateRanges($awal, $akhir, array_column($busIds, 'id'));
			// $data = $this->Book_model->range($awal, $akhir);
			$cek = '1';
			$awal1 = $this->input->post('awal');
			$akhir1 = $this->input->post('akhir');
			$this->load->view('admin/cetak', ['cek' => $cek, 'awal1' => $awal1, 'akhir1' => $akhir1, 'bus' => $bus]);
		}

	}
	public function delete($id)
    {
        $this->Book_model->delete($id);
        $this->session->set_flashdata('success', 'Transaksi deleted successfully.');
				redirect($_SERVER['HTTP_REFERER']);
    }

		public function fetch_data() {
			$startDate = $this->input->get('startDate');
			$endDate = $this->input->get('endDate');
			$search = $this->input->get('search');

			if (!$startDate && !$search) {
				$data = $this->Book_model->getBookDataByWDateRange();
			} else {
				$busIds = $this->Bus_model->search($search);
				$data = $this->Book_model->getBookDataByDateRange($startDate, $endDate, array_column($busIds, 'id'));
			}

			// Return the data as JSON response
			echo json_encode($data);
	}
	public function fetch_datab() {
		$startDate = $this->input->get('startDate');
		$endDate = $this->input->get('endDate');
		$search = $this->input->get('search');

		if (!$startDate && !$search) {
			$data = $this->Book_model->getBookDataByWDateRanges();
		} else {
			$busIds = $this->Bus_model->search($search);
			$data = $this->Book_model->getBookDataByDateRanges($startDate, $endDate, array_column($busIds, 'id'));
		}

		// Return the data as JSON response
		echo json_encode($data);
}
}
