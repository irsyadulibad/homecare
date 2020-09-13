<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ongkir_m extends CI_Model{
	public function get_ongkir($id=null){
		$this->db->select('*');
		$this->db->from('ongkir');
		if(!is_null($id)) $this->db->where('id', $id);
		$this->db->order_by('id_kecamatan', 'ASC');
		if(is_null($id)){
			return $this->db->get()->result_array();
		}else{
			return $this->db->get()->row_array();
		}
	}

	public function tambah(){
		$provinsi = $this->input->post('provinsi', true);
		$kota = $this->input->post('kota', true);
		$kecamatan = $this->input->post('kecamatan', true);
		$tarif = $this->input->post('tarif', true);

		$data = [
			'id_provinsi' => $provinsi,
			'id_kota' => $kota,
			'id_kecamatan' => $kecamatan,
			'tarif' => $tarif
		];

		$this->db->insert('ongkir', $data);
		return $this->db->affected_rows();
	}

	public function get_ongkir_html($ongkir){
		$prov = $this->pesanan_m->getProv($ongkir['id_provinsi'])['nama'];
		$kota = $this->pesanan_m->getKota($ongkir['id_kota'])['nama'];
		$kec = $this->pesanan_m->getKec($ongkir['id_kecamatan'])['nama'];
		return '
<div class="form-group">
	<input type="hidden" name="id" value="'.$ongkir['id'].'"
	<h6>Alamat: '."$prov - $kota - $kec".'</h6>
</div>
<div class="form-group">
	<label for="provinsi">Tarif</label>
	<input type="number" name="tarif" class="form-control" value="'.$ongkir['tarif'].'">
</div>
';
	}
}
