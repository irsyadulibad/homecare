<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Daerah_m extends CI_Model{
	public function get_provinsi($id = null){
		$this->db->select('*');
		$this->db->from('dd_provinsi');
		$this->db->order_by('nama', 'ASC');

		if(is_null($id)){
			return $this->db->get()->result_array();
		}else{
			$this->db->where('id_provinsi', $id);
			return $this->db->get()->row_array();
		}
	}

	public function get_kabupaten($pid = null){
		$this->db->select('*');
		$this->db->from('dd_kabupaten');
		$this->db->order_by('nama', 'ASC');

		if(is_null($pid)){
			return $this->db->get()->result_array();
		}else{
			$this->db->where('id_provinsi', $pid);
			return $this->db->get()->result_array();
		}
	}

	public function get_kecamatan($kid = null){
		$this->db->select('*');
		$this->db->from('dd_kecamatan');
		$this->db->order_by('nama', 'ASC');

		if(is_null($kid)){
			return $this->db->get()->result_array();
		}else{
			$this->db->where('id_kabupaten', $kid);
			return $this->db->get()->result_array();
		}
	}

	public function get_desa($kcid = null){
		$this->db->select('*');
		$this->db->from('dd_desa');
		$this->db->order_by('nama', 'ASC');

		if(is_null($kcid)){
			return $this->db->get()->result_array();
		}else{
			$this->db->where('id_kecamatan', $kcid);
			return $this->db->get()->result_array();
		}
	}

	public function kabupaten($kid){
		return $this->db->get_where('dd_kabupaten', ['id_kabupaten' => $kid])->row_array();
	}

	public function kecamatan($kcid){
		return $this->db->get_where('dd_kecamatan', ['id_kecamatan' => $kcid])->row_array();
	}

	public function desa($did){
		return $this->db->get_where('dd_desa', ['id_desa' => $did])->row_array();
	}
}
