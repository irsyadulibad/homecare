<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('User_m', 'user');
		$this->load->model('Medis_m', 'medis');
	}

	public function login()
	{
		check_already_login();
		$this->load->view('login/template/head');
		$this->load->view('login/home');
		$this->load->view('login/template/foot');
	}
	public function register()
	{
		check_already_login();
		$this->load->view('login/template/head');
		$this->load->view('login/register');
		$this->load->view('login/template/foot');
	}
	public function process(){
		$email = htmlspecialchars($this->input->post('email', true));
		$pass = htmlspecialchars($this->input->post('password', true));

		$user = $this->user->login($email, $pass);
		$medis = $this->medis->login($email, $pass);

		if(!is_null($user)){
			if($user['active'] == '1'){
				$this->session->set_userdata('user', [
					'id_pengguna' => $user['id_pengguna'],
					'status' => $user['status']
				]);
				redirect('homecare');
			}else{
				$this->session->set_flashdata('swal', [
					'type' => 'error',
					'msg' => 'Akun belum diaktivasi'
				]);
				redirect('auth/login');
			}
		}else if(!is_null($medis)){
			$this->session->set_userdata('user', [
				'id_pengguna' => $medis['id_medis'],
				'status' => $medis['status']
			]);
			redirect('homecare');
		}else{
			$this->session->set_flashdata('swal', [
				'type' => 'error',
				'msg' => 'Email atau Passwrod tidak valid'
			]);
			redirect('auth/login');
		}
	}

	public function logout(){
		$this->cart->destroy();
		$this->session->unset_userdata('obat');
		$this->session->unset_userdata('user');
		redirect('auth/login');
	}
}
