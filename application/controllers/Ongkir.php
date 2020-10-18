<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ongkir extends CI_Controller {
	public function __construct(){
		parent::__construct();
		check_not_login();
		check_admin();
		$this->load->model('ongkir_m');
		$this->load->model('pesanan_m');
		$this->load->model('daerah_m');
	}

	public function index(){
		$data = [
			'ongkirs' => $this->ongkir_m->get(),
			'provinsi' => $this->daerah_m->get_provinsi(),
			'modal' => 'ongkir'
		];
		
		$this->template->load('template2', 'ongkir/index', $data);
	}

	public function tambah(){
		if(!$this->form_validation->run('validasi_ongkir')){
			$this->session->set_flashdata('form_err', validation_errors());
		}else{
			$res = $this->ongkir_m->tambah();

			if($res > 0){
				$this->session->set_flashdata('swal', [
					'type' => 'success',
					'msg' => 'Biaya berhasil disimpan'
				]);
			}else{
				$this->session->set_flashdata('swal', [
					'type' => 'error',
					'msg' => 'Biaya gagal disimpan'
				]);
			}
		}

		redirect('ongkir');
	}

	public function edit($id = null){
		$ongkir = $this->ongkir_m->get($id);
		if(is_null($ongkir)) redirect('ongkir');

		if(!$this->form_validation->run('validasi_ongkir')){
			$data = [
				'ongkir' => $ongkir,
				'head' => 'Edit Data Biaya'
			];

			$this->template->load('template2', 'ongkir/edit', $data);
		}else{
			$res = $this->ongkir_m->edit($id);

			if($res > 0){
				$this->session->set_flashdata('swal', [
					'type' => 'success',
					'msg' => 'Data berhasil disimpan'
				]);
			}else{
				$this->session->set_flashdata('swal', [
					'type' => 'error',
					'msg' => 'Data gagal disimpan'
				]);
			}

			redirect('ongkir');
		}
	}

	public function hapus($id=null){
		$ongkir = $this->ongkir_m->get($id);
		if(is_null($ongkir)) redirect('ongkir');

		$res = $this->ongkir_m->delete($id);

		if($res > 0){
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

		redirect('ongkir');
	}
}
