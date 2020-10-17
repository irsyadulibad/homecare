<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

	function __construct(){
		parent::__construct();
		check_not_login();
		check_admin();
		$this->load->model('user_m');
		$this->load->model('medis_m');
		$this->load->library('form_validation');
	}
	public function index(){
		$data = [
			'user' => $this->user_m->get(),
			'medis' => $this->medis_m->get(),
			'head' => "Daftar Pengguna"
		];

		$this->template->load('template2','user/user_data', $data);
	}

	public function medis(){
		$data ['users'] = $this->user_m->getmedis()->result_array();
		$this->template->load('template2','user/usermedis', $data);
	}

	public function add(){

		if(!$this->form_validation->run('add_user')){
			$this->template->load('template2','user/add_user');
		}else{
			$res = $this->user_m->add();

			if($res > 0 ){
				$this->session->set_flashdata('swal', [
					'type' => 'success',
					'msg' => 'Pengguna berhasil ditambahkan'
				]);
			}else{
				$this->session->set_flashdata('swal', [
					'type' => 'error',
					'msg' => 'Pengguna gagal ditambahkan'
				]);
			}

			redirect('user');
		}

	}

	public function edit($id){
		$user = $this->user_m->get($id);
		$is_pass = false;

		if(!is_null($user)){
			$pass = $this->input->post('password', true);
		
			if(strlen($pass) < 1){
				$validation = $this->form_validation->run('edit_user');
			}else{
				$is_pass = true;
				$validation = $this->form_validation->run('edit_user_pass');
			}

			if(!$validation){
				$data = [
					'user' => $user,
					'head' => 'Edit Akun Pengguna'
				];

				$this->template->load('template2','user/user_edit', $data);
			}else{
				$res = $this->user_m->edit($id, $is_pass);

				if($res > 0 ){
					$this->session->set_flashdata('swal', [
						'type' => 'success',
						'msg' => 'Data berhasil diubah'
					]);
				}else{
					$this->session->set_flashdata('swal', [
						'type' => 'error',
						'msg' => 'Data gagal diubah'
					]);
				}

				redirect('user');
			}

		}else{
			$this->session->set_flashdata('swal', [
				'type' => 'error',
				'msg' => 'Pengguna tidak ditemukan'
			]);

			redirect('user');
		}
	}

	public function editmedis($id = null){
		$user = $this->medis_m->get($id);
		$is_pass = false;

		if(!is_null($user)){
			$pass = $this->input->post('password', true);
		
			if(strlen($pass) < 1){
				$validation = $this->form_validation->run('edit_medis');
			}else{
				$is_pass = true;
				$validation = $this->form_validation->run('edit_medis_pass');
			}

			if(!$validation){
				$data = [
					'user' => $user,
					'head' => 'Edit Akun Pengguna'
				];

				$this->template->load('template2','user/medis_edit', $data);
			}else{
				$res = $this->medis_m->edit($id, $is_pass);

				if($res > 0 ){
					$this->session->set_flashdata('swal', [
						'type' => 'success',
						'msg' => 'Data berhasil diubah'
					]);
				}else{
					$this->session->set_flashdata('swal', [
						'type' => 'error',
						'msg' => 'Data gagal diubah'
					]);
				}

				redirect('user');
			}

		}else{
			$this->session->set_flashdata('swal', [
				'type' => 'error',
				'msg' => 'Pengguna tidak ditemukan'
			]);

			redirect('user');
		}
	}

	public function del($id=null){
		$id = intval($id);
		$res = $this->user_m->delete($id);

		if($res > 0 ){
			$this->session->set_flashdata('swal', [
				'type' => 'success',
				'msg' => 'Pengguna berhasil dihapus'
			]);
		}else{
			$this->session->set_flashdata('swal', [
				'type' => 'error',
				'msg' => 'Pengguna gagal dihapus'
			]);
		}

		redirect('user');
	}

	public function delmedis($id = null){
		$id = intval($id);
		$res = $this->medis_m->delete($id);

		if($res > 0 ){
			$this->session->set_flashdata('swal', [
				'type' => 'success',
				'msg' => 'Medis berhasil dihapus'
			]);
		}else{
			$this->session->set_flashdata('swal', [
				'type' => 'error',
				'msg' => 'Medis gagal dihapus'
			]);
		}

		redirect('user');
	}

	public function profile(){
		$data ['row'] = $this->user_m->get();
		$this->template->load('template','user/profile',$data);
	}
}
