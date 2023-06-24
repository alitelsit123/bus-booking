<?php

class Bus extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Bus_model');
        $this->load->model('Base_model');
				$this->Base_model->setTable('busses');
    }
		public function index(){
			$this->load->view('admin/bus');
		}
    public function create()
    {
        $this->form_validation->set_rules('name', 'Nama Bus', 'required');
        $this->form_validation->set_rules('plat', 'Plat', 'required');
        $this->form_validation->set_rules('mesin', 'Mesin', 'required');
        $this->form_validation->set_rules('type_id', 'Type ID', 'required|numeric');
        $this->form_validation->set_rules('year', 'Year', 'required|numeric');
        $this->form_validation->set_rules('seat', 'Seat', 'required|numeric');
        $this->form_validation->set_rules('price_daily', 'Harga per hari', 'required');

        if ($this->form_validation->run() == false) {
            $errors = validation_errors();
            $this->session->set_flashdata('error', $errors);
        } else {
						$img = $this->validateImage();
						if (!$img) {
							redirect('admin/bus');
						}
            $data = array(
								'name' => $this->input->post('name'),
								'description' => $this->input->post('description'),
                'code' => 'BUS-' . strtoupper(uniqid()),
                'image' => $img,
                'plat' => $this->input->post('plat'),
                'mesin' => $this->input->post('mesin'),
                'type_id' => $this->input->post('type_id'),
                'year' => $this->input->post('year'),
                'seat' => $this->input->post('seat'),
                'price_daily' => $this->input->post('price_daily'),
                'status' => 'activate'
            );

            $this->Bus_model->create($data);
            $this->session->set_flashdata('success', 'Bus created successfully.');
        }

        redirect('admin/bus');
    }

    public function update($id)
    {
				$this->form_validation->set_rules('name', 'Nama Bus', 'required'); 
        $this->form_validation->set_rules('plat', 'Plat', 'required');
        $this->form_validation->set_rules('mesin', 'Mesin', 'required');
        $this->form_validation->set_rules('type_id', 'Type ID', 'required|numeric');
        $this->form_validation->set_rules('year', 'Year', 'required|numeric');
        $this->form_validation->set_rules('seat', 'Seat', 'required|numeric');
        $this->form_validation->set_rules('price_daily', 'Harga per hari', 'required');


        if ($this->form_validation->run() == false) {
            $errors = validation_errors();
            $this->session->set_flashdata('error', $errors);
        } else {
            $data = array(
								'name' => $this->input->post('name'),
								'description' => $this->input->post('description'),
                'plat' => $this->input->post('plat'),
                'mesin' => $this->input->post('mesin'),
                'type_id' => $this->input->post('type_id'),
                'year' => $this->input->post('year'),
                'price_daily' => $this->input->post('price_daily'),
                'seat' => $this->input->post('seat'),
            );

            $this->Bus_model->update($id, $data);
            $this->session->set_flashdata('success', 'Bus updated successfully.');
        }
        redirect('admin/bus');
    }

    public function delete($id)
    {
        $this->Bus_model->delete($id);
        $this->session->set_flashdata('success', 'Bus deleted successfully.');
        redirect('admin/bus');
    }

    private function uploadImage()
    {
        // Logic to upload the image to {root_dir}/assets/image
        // Replace this with your actual implementation
    }

		public function validateImage()
		{
				// Check if a file is selected
				if (empty($_FILES['image']['name'])) {
						// No file selected, but it's not a required field
						return true;
				}

				// Set the allowed file types and maximum file size
				$config['upload_path'] = './assets/upload';
				$config['allowed_types'] = 'jpg|jpeg|png';
				$config['max_size'] = 2048; // 2MB
				$config['file_name'] = uniqid();

				// Load the upload library and initialize
				$this->load->library('upload', $config);

				// Perform the file upload
				if (!$this->upload->do_upload('image')) {
						// File upload failed, set validation error message
						$error = $this->upload->display_errors();
        		$this->session->set_flashdata('error', $error);
						return false;
				} else {
					$uploadData = $this->upload->data();
					$imagePath = $config['file_name'];
					$dname = explode(".", $_FILES['image']['name']);
					$ext = end($dname);
					if ($this->input->is_ajax_request()) {
						echo $imagePath.'.'.$ext;
					}
					return $imagePath.'.'.$ext;
				}

				// File uploaded successfully
				return true;
		}
		public function updateAttribute() {
			parent::updateAttribute();
		}
}
