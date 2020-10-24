<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Alamat_m extends CI_Model{
	private $IQtoken = 'pk.1e92a9b4535e5f6d479128da69367c8b';
	private $APIurl = 'https://us1.locationiq.com/v1/search.php';
	private $APIformat = 'json';

	public function get_alamat($user){

		if(is_null($user['id_alamat'])){
			return null;
		}else{
			return $this->db->get_where('alamat_pengguna', [
				'id_alamat' => $user['id_alamat']
			])->row_array();
		}

	}

	public function max_id(){
		$this->db->order_by('id_alamat', 'DESC');
		$this->db->limit(1);
		$result = $this->db->get('alamat_pengguna')->row_array();

		return intval($result['id_alamat']);
	}

	public function get_geocode($alamat){
		$result = @file_get_contents("{$this->APIurl}?key={$this->IQtoken}&format={$this->APIformat}&q={$alamat}");

		if(!$result){
			return [
				'status' => false,
				'msg' => 'Terjadi kesalahan saat mengambil data, silahkan coba lagi'
			];
		}else{
			return [
				'status' => true,
				'data' => json_decode($result, true)
			];
		}
		
	}

	public function del_alamat($aid){
		$this->db->delete('alamat_pengguna', ['id_alamat' => $aid]);
		return ($this->db->affected_rows() > 0) ? true : false;
	}
}
