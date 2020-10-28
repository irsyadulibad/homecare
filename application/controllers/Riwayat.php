<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Riwayat extends CI_Controller {
	public function __construct(){
		parent::__construct();
		check_not_login();
		$this->load->model('invoice_m');
		$this->load->model('riwayat_m');
		$this->load->model('user_m');
		$this->load->model('medis_m');
		$this->load->model('alamat_m');
	}

	public function index(){
		$this->load->model('ulasan_m');
		$user = $this->fungsi->user_login();

		if($user['status'] == 'admin'){
			$riwayat = $this->riwayat_m->get();
		}else if($user['status'] == 'user'){
			$riwayat = $this->riwayat_m->get_by_user($user['id_pengguna']);
		}else{
			$riwayat = $this->riwayat_m->get_by_medis($user['id_medis']);
		}

		$data = [
			'histories' => $riwayat,
			'user' => $user
		];

		$this->template->load('template2', 'riwayat/index', $data);
	}

	function detail($id_riwayat = null){
		$this->load->model('pesanan_m');

		if(is_null($id_riwayat)) redirect('riwayat');
		$user = $this->fungsi->user_login();
		$riwayat = $this->riwayat_m->get($id_riwayat);
		if(is_null($riwayat)) redirect('riwayat');

		$data = [
			'head' => 'Detail Riwayat',
			'invoice' => $this->invoice_m->get($riwayat['id_invoice']),
			'pesanans' => $this->pesanan_m->get_by_invoice($riwayat['id_invoice'])
		];

		$this->template->load('template2', 'riwayat/detail', $data);
	}
}
