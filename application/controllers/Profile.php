<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Profile extends CI_Controller{
	public function __construct(){
		parent::__construct();
		check_not_login();
		$this->load->model('profile_m');
		$this->load->model('daerah_m');
		$this->load->model('alamat_m');
	}

	public function index(){
		$user = $this->fungsi->user_login();

		if(!$this->form_validation->run('edit_profile')){
			$data = [
				'user' => $user,
				'alamat' => $this->alamat_m->get_alamat($user)
			];

			$this->template->load('template2', 'profile/index', $data);
		}else{
			$res = $this->profile_m->edit($user);

			$this->session->set_flashdata('swal', $res);
			redirect('profile');
		}
	}
 
	public function editpass(){
		$user = $this->fungsi->user_login();
		
		if(!$this->form_validation->run('edit_profile_pass')){
			$data = [
				'head' => 'Edit Password',
				'user' => $user,
				'alamat' => $this->alamat_m->get_alamat($user)
			];

			$this->template->load('template2', 'profile/editpass', $data);
		}else{
			$res = $this->profile_m->editpass($user);

			$this->session->set_flashdata('swal', $res);
			redirect('profile/editpass');
		}

	}

	public function editaddr(){
		$user = $this->fungsi->user_login();

		if(!$this->form_validation->run('edit_profile_addr')){
			$data = [
				'user' => $user,
				'head' => 'Edit Alamat',
				'provinces' => $this->daerah_m->get_provinsi(),
				'alamat' => $this->alamat_m->get_alamat($user)
			];

			$this->template->load('template2', 'profile/editaddr', $data);
		}else{
			$res = $this->profile_m->editaddr($user);

			$this->session->set_flashdata('swal', $res);
			redirect('profile/editaddr');
		}

	}
	
}
