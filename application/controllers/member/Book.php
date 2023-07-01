<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Book extends MY_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->library('midtrans');
	}
	public function index(){
		$this->load->view('member/book');
	}
	public function checkout($id){
		$startDate = explode(' - ', $this->input->get('date'))[0];
		$endDate = explode(' - ', $this->input->get('date'))[1];
		$data = [
			'bus' => $this->Bus_model->find($id),
			'start_date' => $startDate,
			'end_date' => $endDate,
			'data' => [
				'city_from' => $this->input->get('city_from'),
				'city_to' => $this->input->get('city_to'),
				'location_from' => $this->input->get('location_from'),
				'location_to' => $this->input->get('location_to')
			]
		];
		$start_book = $this->input->post('start_book');
		$end_book = $this->input->post('end_book');
		$bus_id = $id;
		
		// Calculate gross amount based on busses.price_daily and date difference
		$priceDaily = $this->db->select('price_daily')->get_where('busses', ['id' => $bus_id])->row()->price_daily;
		$dateDiff = strtotime($end_book) - strtotime($start_book);
		$dateDiff = floor($dateDiff / (60 * 60 * 24)); // Convert to days
		$gross_amount = $priceDaily * $dateDiff;
		
		// Get the current user's ID from authentication (assuming you have authentication implemented)
		$user_id = $this->session->userdata('user')->id;
		$this->create($bus_id,$startDate,$endDate);
		$this->load->view('member/book-checkout', $data);
	}
	public function getToken() {
		echo $this->create();
	}
	public function create($id = null,$startDate = null,$endDate = null)
	{
		$start_book = $this->input->post('start_book') ?? $startDate;
		$end_book = $this->input->post('end_book') ?? $endDate;
		$bus_id = $this->input->post('bus_id') ?? $id;
		
		// Calculate gross amount based on busses.price_daily and date difference
		$priceDaily = $this->db->select('price_daily')->get_where('busses', ['id' => $bus_id])->row()->price_daily;
		$dateDiff = strtotime($end_book) - strtotime($start_book);
		$dateDiff = floor($dateDiff / (60 * 60 * 24)); // Convert to days
		$gross_amount = $priceDaily * $dateDiff;
		
		// Get the current user's ID from authentication (assuming you have authentication implemented)
		$user_id = $this->session->userdata('user')->id;
		
		// Generate a random unique code
		$existingBook = $this->db->select('*')->get_where('bookings', ['status' => 'pending','bus_id' => $bus_id, 'user_id' => $this->session->userdata('user')->id])->row();
		$token = null;
		if (!$existingBook) {
			$code = 'INV-'.strtoupper(uniqid());

			// Get the Midtrans snap token (replace with your actual implementation)
			$token = $this->generateMidtransSnapToken($code, $this->db->select('name')->get_where('busses', ['id' => $bus_id])->row()->name, $gross_amount, $this->session->userdata('user'));
			
			// Prepare data for the transaction (replace with your actual implementation)
			$data = $this->prepareTransactionData();
			
			// Insert the transaction into the database
			$transactionData = array(
					'code' => $code,
					'token' => $token,
					'date' => date('Y-m-d'), // Current date
					'gross_amount' => $gross_amount,
					'start_book' => $start_book,
					'end_book' => $end_book,
					'data' => $data,
					'city_from' => $this->input->post('city_from'),
					'location_from' => $this->input->post('location_from'),
					'city_to' => $this->input->post('city_to'),
					'location_to' => $this->input->post('location_to'),
					'user_id' => $user_id,
					'bus_id' => $bus_id,
					'status' => 'pending'
			);
			
			$this->db->insert('bookings', $transactionData);
		} else {
			$token = $existingBook->token;
			$this->Book_model->update($existingBook->id, [
				'start_book' => $start_book,
				'end_book' => $end_book,
				'gross_amount' => $gross_amount,
			]);

			try {
				// $statusTransaction = $this->checkToken($existingBook->code);
			} catch (\Throwable $th) {
				// $code = 'INV-'.strtoupper(uniqid());

				// // // Get the Midtrans snap token (replace with your actual implementation)
				// $token = $this->generateMidtransSnapToken($code, $this->db->select('name')->get_where('busses', ['id' => $bus_id])->row()->name, $gross_amount, $this->session->userdata('user'));
					
				// // // Prepare data for the transaction (replace with your actual implementation)
				// // $data = $this->prepareTransactionData();
				
				// // // Insert the transaction into the database
				// $transactionData = array(
				// 		'code' => $code,
				// 		'token' => $token,
				// 		'date' => date('Y-m-d'), // Current date
				// 		'gross_amount' => $gross_amount,
				// 		'start_book' => $start_book,
				// 		'end_book' => $end_book,
				// 		'data' => $data,
				// 		'status' => 'pending'
				// );

				// $this->Book_model->update($existingBook->id,$transactionData);
			}
		}
		$newBooks = $this->db->select('*')->get_where('bookings', ['token' => $token,'bus_id' => $bus_id, 'user_id' => $this->session->userdata('user')->id])->row();
		return json_encode($newBooks, true);
	}
	public function checkToken($bookId) {
		// Load the necessary CI3 database library
		$this->load->database();
		
		// Retrieve the token from the bookings table based on bus_id
		$query = $this->db->get_where('bookings', array('id' => $bookId, 'user_id' => $this->session->userdata('user')->id));
		$result = $query->row_array();
		
		if ($result) {
				$token = $result['code'];
				
				// Make a request to Midtrans API with the token and get the status
				// Replace the following code with your actual implementation to send the status to Midtrans
				$midtransStatus = null;
				try {
					$midtransStatus = $this->getMidtransStatus($token,$result);
				} catch (\Throwable $th) {
					echo 'pending';
					return;					
				}
				
				// Process the Midtrans status and send appropriate response to the client
				// Replace the following code with your actual implementation
				if ($midtransStatus === 'settlement') {
						echo 'success';
				} else {
						echo 'Payment is pending or failed.';
				}
		} else {
				echo 'No booking found for the given bus ID.';
		}
	}

	// Function to get the status from Midtrans API (replace with your actual implementation)
	private function getMidtransStatus($token, $book) {
		// Get the status from Midtrans API
		$status = $this->midtrans->getStatus($token);

		// Process the status and return the relevant information
		if ($status->transaction_status === 'capture' || $status->transaction_status === 'settlement') {
			// Transaction is successful
			$this->Book_model->update($book['id'],['status' => 'settlement','payment_date' => date('Y-m-d H:i:s')]);
			return 'settlement';
		} elseif ($status->transaction_status === 'pending') {
			// Transaction is pending
			return 'pending';
		} else {
			// Transaction is failed or other status
			return 'failed';
		}
	}
	
	private function generateMidtransSnapToken($id,$bus_name, $gross_amount, $user_data)
	{
		
		// Set up your transaction details
		$params = array(
				'transaction_details' => array(
						'order_id' => $id,
						'gross_amount' => $gross_amount,
						'name' => 'Booking ' . $bus_name
				),
				'item_details' => array(
						array(
								'id' => '1',
								'price' => $gross_amount,
								'quantity' => 1,
								'name' => 'Booking ' . $bus_name
						)
				),
				'customer_details' => array(
						'first_name' => $user_data->name,
						'email' => $user_data->email,
						'phone' => $user_data->phone
				)
		);
		
		// Set your Midtrans server key
		
		// Get the snap token
		return $this->midtrans->getSnapToken($params);
	}
	
	private function prepareTransactionData()
	{
		// Replace with your implementation to prepare the transaction data
		// Example code:
		// $data = array(
		//     // Prepare your transaction data
		// );
		// return json_encode($data);
	}
}
