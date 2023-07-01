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
}
