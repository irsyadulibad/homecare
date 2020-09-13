<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Obat extends CI_Controller {
	public function __construct(){
		parent::__construct();
		check_not_login();
		$this->load->model('Obat_m', 'obat_m');
	}

	public function index(){
		$data['modal'] = 'obat';
		$data['obats'] = $this->obat_m->getObat();
		$this->template->load('template2', 'obat/index', $data);
	}

	public function tambah(){
		$this->form_validation->set_rules('name', 'Nama Obat', 'required');
		$this->form_validation->set_rules('price', 'Harga Obat', 'required|numeric');
		$this->form_validation->set_rules('stock', 'Stok Obat', 'required|numeric');

		if($this->form_validation->run() == false){
			$this->session->set_flashdata('form_err', validation_errors());
			redirect('obat');
		}else{
			if($this->obat_m->add() > 0){
				$this->session->set_flashdata('swal', ['type' => 'success', 'msg' => 'Data berhasil disimpan']);
				redirect('obat');
			}else{
				$this->session->set_flashdata('swal', ['type' => 'danger', 'msg' => 'Data gagal disimpan']);
				redirect('obat');
			}
		}
	}

	public function edit($id){
		if(is_null($id)) redirect('obat');

		$this->form_validation->set_rules('name', 'Nama Obat', 'required');
		$this->form_validation->set_rules('price', 'Harga Obat', 'required|numeric');

		if($this->form_validation->run() == false){
			$data['obat'] = $this->obat_m->getObat($id);
			$data['head'] = "Edit Data Obat";
			$this->template->load('template2', 'obat/edit', $data);
		}else{
			if($this->obat_m->edit($id) > 0){
				$this->session->set_flashdata('swal', ['type' => 'success', 'msg' => 'Data berhasil disimpan']);
			}else{
				$this->session->set_flashdata('swal', ['type' => 'danger', 'msg' => 'Data gagal disimpan']);
			}
			redirect('obat');
		}
	}

	public function hapus($id=null){
		if(is_null($id)) redirect('obat');
		$this->db->delete('obat', ['id_obat' => $id]);
		if($this->db->affected_rows() > 0){
			$this->session->set_flashdata('swal', ['type' => 'success', 'msg' => 'Data berhasil dihapus']);
		}else{
			$this->session->set_flashdata('swal', ['type' => 'danger', 'msg' => 'Data berhasil dihapus']);
		}
		redirect('obat');
	}

	public function update_stock($id=null){
		if(is_null($id)) redirect('obat');
		$this->form_validation->set_rules('stock', 'Stok', 'required|numeric');

		if($this->form_validation->run() == false){
			$this->session->set_flashdata('form_err', validation_errors());
			redirect('obat/edit/'.$id);
		}else{
			if($this->obat_m->uStock($id) > 0){
				$this->session->set_flashdata('swal', ['type' => 'success', 'msg' => 'Stok berhasil diupdate']);
			}else{
				$this->session->set_flashdata('swal', ['type' => 'danger', 'msg' => 'Stok gagal diupdate']);
			}
			redirect('obat/edit/'.$id);
		}
	}

	public function default(){
		$data['layanans'] = $this->obat_m->getLayanan();
		$this->template->load('template2', 'obat/default', $data);
	}

	public function set_default($id=null){
		if(is_null($id)) redirect('default');
		$data['layanan'] = $this->db->get_where('layanan', ['id_layanan' => $id])->row_array();
		$data['drugs'] = $this->obat_m->getObat();
		if(!isset($_POST['obat'])){
			$data['layobs'] = $this->obat_m->get_default_relation($id);
			$this->template->load('template2', 'obat/set_default', $data);
		}else{
			$obat = $this->input->post('obat', true);
			if(is_null($obat) || $obat == "" || $obat == 0){
				echo json_encode(['status' => 'error', 'msg' => 'Obat Harus Diisi']);
			}else{
				$res = $this->obat_m->set_default($id, $obat);
				echo json_encode($res);
			}
		}
	}

	public function del_default($id_lay=null){
		if(is_null($id_lay)) redirect('obat');
		$id = $this->input->post('id', true);
		$this->db->delete('lay_ob', ['id' => $id]);
		if($this->db->affected_rows() > 0){
			$items = $this->obat_m->get_default_relation($id_lay);
			echo json_encode(['status' => 'success', 'msg' => 'Data berhasil dihapus', 'items' => $items]);
		}else{
			echo json_encode(['status' => 'error', 'msg' => 'Data gagal dihapus']);
		}
	}

	public function cek_json(){
		$stok = $this->obat_m->cek_stok();
		echo json_encode(['stok' => $stok]);
	}
}
