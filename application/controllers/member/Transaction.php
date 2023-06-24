<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transaction extends MY_Controller {

	public function index(){
		$this->load->view('member/transaction');
	}
	public function invoice($id) {
		$book = $this->Book_model->find($id);
		$this->load->view('admin/invoice', ['book' => $book]);
	}
}
