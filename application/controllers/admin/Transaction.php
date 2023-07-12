<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transaction extends MY_Controller {

	public function index(){
		$this->load->view('admin/transaction');
	}
	public function invoice($id) {
		$book = $this->Book_model->find($id);
		$this->load->view('admin/invoice', ['book' => $book]);
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
