<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Profile extends CI_Controller{
	public function __construct(){
		parent::__construct();
		check_not_login();
		$this->load->model('Profile_m', 'profile_m');
		$this->load->model('Daerah_m', 'daerah');
	}

	public function index(){
		$data['user'] = $this->fungsi->user_login();
		$this->template->load('template2', 'profile/index', $data);
	}

	public function edit(){
		if(isset($_FILES['image'])){
			$res = $this->profile_m->edit_img();
			if($res['status'] == "error"){
				$this->session->set_flashdata('msg-edit-img', [
					'class' => 'danger',
					'text' => $res['error']
				]);
				redirect('profile/edit');
			}else{
				$this->session->set_flashdata('msg-edit-img', [
					'class' => $res['class'],
					'text' => $res['text']
				]);
				redirect('profile/edit');
			}
		}

		$this->form_validation->set_rules('name', 'Nama', 'required');
		$this->form_validation->set_rules('gender', 'Jenis Kelamin', 'required');
		$this->form_validation->set_rules('phone', 'No HP', 'required');
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
		$this->form_validation->set_rules('address', 'Alamat', 'required');
		$this->form_validation->set_rules('provinsi', 'provinsi', 'required|is_numeric');
		$this->form_validation->set_rules('kota', 'kota', 'required|is_numeric');
		$this->form_validation->set_rules('kecamatan', 'kecamatan', 'required|is_numeric');
		$this->form_validation->set_rules('desa', 'desa', 'required|is_numeric');


		if($this->form_validation->run() == FALSE){
			$data['user'] = $this->fungsi->user_login();
			$data['head'] = "Edit Profil";
			$this->template->load('template2', 'profile/edit', $data);
		}else{
			if($this->profile_m->edit_data() > 0){
				$this->session->set_flashdata('msg-edit-data', [
					'class' => 'success',
					'text' => 'Data berhasil diubah'
				]);
				redirect('profile/edit');
			}else{
				$this->session->set_flashdata('msg-edit-data', [
					'class' => 'danger',
					'text' => 'Data gagal diubah'
				]);
				redirect('profile/edit');
			}
		}
	}

	public function editpass(){
		$this->form_validation->set_rules('oldpass', 'Kata Sandi', 'required');
		$this->form_validation->set_rules('newpass', 'Kata Sandi', 'required|min_length[6]');
		$this->form_validation->set_rules('confirmpass', 'Konfirmasi Sandi', 'required|matches[newpass]');

		if($this->form_validation->run() == FALSE){
			$data['user'] = $this->fungsi->user_login();
			$this->template->load('template2', 'profile/editpass', $data);
		}else{
			$res = $this->profile_m->edit_pass();
			if($res['status'] == "error"){
				$this->session->set_flashdata('msg-edit-pass', [
					'class' => $res['class'],
					'text' => $res['text']
				]);
				redirect('profile/editpass');
			}else{
				$this->session->set_flashdata('msg-edit-pass', [
					'class' => $res['class'],
					'text' => $res['text']
				]);
				redirect('profile/editpass');
			}
		}
	}
}
