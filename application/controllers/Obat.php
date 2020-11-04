<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Obat extends CI_Controller {
	public function __construct(){
		parent::__construct();
		check_not_login();
		check_admin_medis();
		$this->load->model('obat_m');
		$this->load->model('layanan_m');
	}

	public function index(){
		$data = [
			'modal' => 'obat',
			'obats' => $this->obat_m->getObat()
		];

		$this->template->load('template2', 'obat/index', $data);
	}

	public function tambah(){

		if($this->form_validation->run('tambah_obat') == false){
			$this->session->set_flashdata('form_err', validation_errors());

			redirect('obat');
		}else{
			$res = $this->obat_m->add();
			if($res > 0){
				$this->session->set_flashdata('swal', [
					'type' => 'success',
					'msg' => 'Data berhasil disimpan'
				]);
			}else{
				$this->session->set_flashdata('swal', [
					'type' => 'danger',
					'msg' => 'Data gagal disimpan'
				]);
			}

			redirect('obat');
		}
	}

	public function edit($id = null){
		$obat = $this->obat_m->getObat($id);
		if(is_null($obat)) redirect('obat');

		if($this->form_validation->run('edit_obat') == false){
			$data = [
				'obat' => $obat,
				'head' => 'Edit Data Obat'
			];

			$this->template->load('template2', 'obat/edit', $data);
		}else{
			$res = $this->obat_m->edit($id);

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

			redirect('obat');
		}
	}

	public function hapus($id=null){
		$obat = $this->obat_m->getObat($id);
		if(is_null($obat)) redirect('obat');

		$res = $this->obat_m->delete($id);
		if($res > 0){
			$this->session->set_flashdata('swal', [
				'type' => 'success',
				'msg' => 'Data berhasil dihapus'
			]);
		}else{
			$this->session->set_flashdata('swal', [
				'type' => 'danger',
				'msg' => 'Data berhasil dihapus'
			]);
		}

		redirect('obat');
	}

	public function update_stock($id = null){
		$obat = $this->obat_m->getObat($id);
		if(is_null($obat)) redirect('obat');

		$this->form_validation->set_rules('stock', 'Stok', 'required|numeric');

		if($this->form_validation->run() == false){
			$this->session->set_flashdata('form_err', validation_errors());
			redirect('obat/edit/'.$id);
		}else{
			$res = $this->obat_m->uStock($id);
			if($res > 0){
				$this->session->set_flashdata('swal', [
					'type' => 'success',
					'msg' => 'Stok berhasil diupdate'
				]);
			}else{
				$this->session->set_flashdata('swal', [
					'type' => 'error',
					'msg' => 'Stok gagal diupdate'
				]);
			}

			redirect('obat/edit/'.$id);
		}
	}

	public function default(){
		$data = [
			'layanans' => $this->layanan_m->get()
		];

		$this->template->load('template2', 'obat/default', $data);
	}

	public function set_default($id = null){
		$layanan = $this->layanan_m->get($id);
		if(is_null($layanan)) redirect('obat/default');

		$data = [
			'layanan' => $layanan,
			'drugs' => $this->obat_m->getObat()
		];

		if(!isset($_POST['obat'])){
			$data['layobs'] = $this->obat_m->get_default_relation($id);
			$this->template->load('template2', 'obat/set_default', $data);
		}else{
			$obat = $this->input->post('obat', true);
			if(is_null($obat) || $obat == "" || $obat == 0){
				echo json_encode([
					'status' => 'error',
					'msg' => 'Obat Harus Diisi'
				]);
			}else{
				$res = $this->obat_m->set_default($id, $obat);
				echo json_encode($res);
			}
		}
	}

	public function del_default($id_lay = null){
		if(is_null($id_lay)) redirect('obat');
		$id = $this->input->post('id', true);
		
		$res = $this->obat_m->delete_default($id);
		if($res > 0){
			$items = $this->obat_m->get_default_relation($id_lay);
			echo json_encode([
				'status' => 'success',
				'msg' => 'Data berhasil dihapus',
				'items' => $items
			]);
		}else{
			echo json_encode([
				'status' => 'error',
				'msg' => 'Data gagal dihapus'
			]);
		}
	}

	public function cek_json(){
		$stok = $this->obat_m->cek_stok();
		echo json_encode(['stok' => $stok]);
	}
}
