<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Alamat_m extends CI_Model{
	public function get_alamat($user){

		if(is_null($user['id_alamat'])){
			return null;
		}else{
			return $this->db->get_where('alamat_pengguna', [
				'id_alamat' => $user['id_alamat']
			])->row_array();
		}

	}
}
