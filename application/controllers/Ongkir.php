<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ongkir extends CI_Controller {
	public function __construct(){
		parent::__construct();
		check_not_login();
		check_admin();
		$this->load->model('ongkir_m');
		$this->load->model('pesanan_m');
		$this->load->model('Daerah_m', 'daerah');
	}

	public function index(){
		$data['ongkirs'] = $this->ongkir_m->get_ongkir();
		$data['provinsi'] = $this->daerah->get_provinsi();
		$data['modal'] = 'ongkir';
		$this->template->load('template2', 'ongkir/index', $data);
	}

	public function tambah(){
		$this->form_validation->set_rules('provinsi', 'Provinsi', 'required');
		$this->form_validation->set_rules('kota', 'Kota', 'required');
		$this->form_validation->set_rules('kecamatan', 'Kecamatan', 'required');
		$this->form_validation->set_rules('tarif', 'tarif', 'required');

		if($this->form_validation->run() == false){
			$this->session->set_flashdata('form_err', validation_errors());
		}else{
			if($this->ongkir_m->tambah() > 0){
				$this->session->set_flashdata('swal', ['type' => 'success', 'msg' => 'Ongkir berhasil disimpan']);
			}else{
				$this->session->set_flashdata('swal', ['type' => 'error', 'msg' => 'Ongkir gagal disimpan']);
			}
		}
		redirect('ongkir');
	}

	public function edit(){
		$id = $this->input->post('id', true);
		$tarif = $this->input->post('tarif', true);

		$this->db->update('ongkir', ['tarif' => $tarif], ['id' => $id]);

		if($this->db->affected_rows() > 0){
			$this->session->set_flashdata('swal', ['type' => 'success', 'msg' => 'Data berhasil disimpan']);
		}else{
			$this->session->set_flashdata('swal', ['type' => 'error', 'msg' => 'Data gagal disimpan']);
		}
		redirect('ongkir');
	}

	public function hapus($id=null){
		if(is_null($id)) redirect('ongkir');
		$this->db->delete('ongkir', ['id' => $id]);
		if($this->db->affected_rows() > 0){
			$this->session->set_flashdata('swal', ['type' => 'success', 'msg' => 'Data berhasil disimpan']);
		}else{
			$this->session->set_flashdata('swal', ['type' => 'error', 'msg' => 'Data gagal disimpan']);
		}
		redirect('ongkir');
	}

	public function get_ongkir(){
		$id = $this->input->post('id', true);
		$ongkir = $this->ongkir_m->get_ongkir($id)[0];
		if(empty($ongkir)){
			echo '<h1 class="text-center">Data tidak dapat ditemukan</h1>';
		}else{
			echo $this->ongkir_m->get_ongkir_html($ongkir);
		}
	}
}
