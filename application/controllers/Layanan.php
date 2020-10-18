<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Layanan extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->model('layanan_m');
		check_not_login();
		check_admin();
		$this->load->library('form_validation');
	}

	public function index(){
		$data = [
			'layanans' => $this->layanan_m->get()
		];

		$this->template->load('template2','layanan/jenislayanan', $data);
	}

	public function add(){
		if(!$this->form_validation->run('validation_layanan')){
			$data = [
				'head' => "Tambah Layanan"
			];

			$this->template->load('template2','layanan/tambah_layanan', $data);
		}else{
			$res = $this->layanan_m->addlay();
			if($res > 0 ){
				$this->session->set_flashdata('swal', [
					'type' => 'success',
					'msg' => 'Layanan berhasil ditambahkan'
				]);
			}else{
				$this->session->set_flashdata('swal', [
					'type' => 'error',
					'msg' => 'Layanan gagal ditambahkan'
				]);
			}

			redirect('layanan');
		}
	}

	public function update($id){
		$layanan = $this->layanan_m->get($id);
		if(is_null($layanan)) redirect('layanan');

		if(!$this->form_validation->run('validation_layanan')){
			$data = [
				'layanan' => $layanan
			];

			$this->template->load('template2','layanan/edit_layanan', $data);
		}else{

			$res = $this->layanan_m->edit($id);
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

			redirect('layanan');
		}
	}
	
	public function dellay($id = null){
		$layanan = $this->layanan_m->get($id);
		if(is_null($layanan)) redirect('layanan');

		$res = $this->layanan_m->dellay($id);
		if($res > 0 ){
			$this->session->set_flashdata('swal', [
				'type' => 'success',
				'msg' => 'Data berhasil dihapus'
			]);
		}else{
			$this->session->set_flashdata('swal', [
				'type' => 'error',
				'msg' => 'Data gagal dihapus'
			]);
		}

		redirect('layanan');
	}
}
