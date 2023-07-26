<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Lupa_password extends CI_Controller
{
    public function index()
    {

        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');

        if ($this->form_validation->run() == FALSE) {
            $data['title'] = 'Lupa Password';
            $this->load->view('forgot-password', $data);
        } else {
            $email = $this->input->post('email');
            $userInfo = $this->Users->getUserInfoByEmail($email);

            if (!$userInfo) {
                $this->session->set_flashdata('sukses', 'email address salah, silakan coba lagi.');
                redirect('/');
            }
						$config = Array(
								'protocol' => 'smtp',
								'smtp_crypto' => 'tls',
								'starttls' => true,
								'smtp_host' => 'smtp.gmail.com',
								'smtp_port' => 587,
								'smtp_user' => 'transsalimbarakatullah@gmail.com',
								'smtp_pass' => 'epbfwdedeljinekk',
								'mailtype'  => 'html',
								'charset'   => 'iso-8859-1'
						);
						$this->load->library('email', $config);
						$this->email->set_newline("\r\n");
																
            //build token   

            $token = $this->Users->insertToken($userInfo->id);
            $qstring = $this->base64url_encode($token);
            $url = site_url() . 'lupa_password/reset_password/token/' . $qstring;
            $link = '<a href="' . $url . '">' . $url . '</a>';

            $message = '';
            $message .= '<strong>Hai, anda menerima email ini karena ada permintaan untuk memperbaharui  
                 password anda.</strong><br>';
            $message .= '<strong>Silakan klik link ini:</strong> ' . $link;

						$this->email->from('transsalimbarakatullah.no-reply@gmail.com', 'Customer Service');
						$this->email->to($userInfo->email);

						$this->email->subject('Lupa Password');
						$this->email->message($message);  

            $data['title'] = 'Lupa Password Dikirim';
						$data['message'] = 'Password reset link berhasil dikirim';
						$result = $this->email->send();
            $this->load->view('forgot-password', $data);
        }
    }

    public function reset_password()
    {
        $token = $this->base64url_decode($this->uri->segment(4));
        $cleanToken = $this->security->xss_clean($token);

        $user_info = $this->Users->isTokenValid($cleanToken); //either false or array();          
        if (!$user_info) {
						// var_dump($user_info);return;exit(0);
            $this->session->set_flashdata('sukses', 'Token tidak valid atau kadaluarsa');
            redirect($_SERVER['HTTP_REFERER']);
        }

        $data = array(
            'title' => 'Reset Password',
            'nama' => $user_info->name,
            'email' => $user_info->email,
            'token' => $this->base64url_encode($token)
        );

        $this->form_validation->set_rules('password', 'Password', 'required|min_length[5]');
        $this->form_validation->set_rules('passconf', 'Password Confirmation', 'required|matches[password]');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('reset-password', $data);
        } else {

            $post = $this->input->post(NULL, TRUE);
            $cleanPost = $this->security->xss_clean($post);
            $hashed = password_hash($cleanPost['password'], PASSWORD_DEFAULT);
            $cleanPost['password'] = $hashed;
            $cleanPost['id'] = $user_info->id;
            unset($cleanPost['passconf']);
            if (!$this->Users->updatePassword($cleanPost)) {
                $this->session->set_flashdata('sukses', 'Update password gagal.');
            } else {
                $this->session->set_flashdata('sukses', 'Password anda sudah  
             diperbaharui. Silakan login.');
            }
						redirect($_SERVER['HTTP_REFERER']);
        }
    }

    public function base64url_encode($data)
    {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }

    public function base64url_decode($data)
    {
        return base64_decode(str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT));
    }
}
