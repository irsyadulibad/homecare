<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Riwayat extends CI_Controller {
	public function __construct(){
		parent::__construct();
		check_not_login();
		$this->load->model('Model_invoice', 'model_invoice');
	}

	public function index(){
		$user = $this->fungsi->user_login();
		if($user->role == 2){
			$data['histories'] = $this->db->get_where('riwayat', ['id_medis' => $user->id_pengguna])->result_array();
		}elseif($user->role == 1){
			$data['histories'] = $this->db->get_where('riwayat')->result_array();
		}else{
			$data['histories'] = $this->db->get_where('riwayat', ['id_pengguna' => $user->id_pengguna])->result_array();
		}
		$data['user'] = $user;
		$this->template->load('template2', 'riwayat/index', $data);
	}
	function detail($id_riwayat){
		$user = $this->fungsi->user_login();
		if(is_null($id_riwayat)) rediect('riwayat');
		if($user->role == 2){
			$data['riwayat'] = $this->db->get_where('riwayat', ['id_riwayat' => $id_riwayat])->row_array();
			$data['medis'] = $this->db->get_where('pengguna', ['id_pengguna' => $data['riwayat']['id_medis']])->row_array();
			if($user->id_pengguna != $data['riwayat']['id_medis']) redirect('riwayat');
		}else{
			$data['riwayat'] = $this->db->get_where('riwayat', ['id_riwayat' => $id_riwayat])->row_array();
			$data['medis'] = $this->db->get_where('pengguna', ['id_pengguna' => $data['riwayat']['id_medis']])->row_array();
			if($user->id_pengguna != $data['riwayat']['id_pengguna']) redirect('riwayat');
		}
		$data['layanan'] = $this->model_invoice->ambil_id_pesanan($data['riwayat']['id_invoice']);
		$data['obat'] = $this->model_invoice->ambil_id_obat($data['riwayat']['id_invoice']);
		$data['user'] = $user;
		$this->template->load('template2', 'riwayat/detail', $data);
	}
}
