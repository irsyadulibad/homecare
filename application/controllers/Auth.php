<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

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

		$post = $this->input->post(null, TRUE);
		if(isset($post['login'])) {
		$this->load->model('user_m');
		$query = $this->user_m->login($post);
		if($query->num_rows() > 0 )
			{
				$row = $query->row();
				$params = array(
					'id_pengguna' => $row->id_pengguna,
					'role' => $row->role,
					'active'=> $row->active
				);
				$this->session->set_userdata($params);
				$this->session->set_flashdata('swal', ['type' => 'success', 'msg' => 'Berhasil Login']);
				redirect('homecare');
			}else {
				$this->session->set_flashdata('swal', ['type' => 'error', 'msg' => 'Login Gagal']);
				redirect('auth/login');
			}
	   }
	}
	public function logout(){
		$this->cart->destroy();
		$this->session->unset_userdata('obat');
		$params = array('id_pengguna', 'role');
		$this->session->unset_userdata($params);
		redirect('auth/login');

	}
}
