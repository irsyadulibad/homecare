<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ulasan extends CI_Controller {
	function __construct(){
		parent::__construct();
		check_not_login();
		$this->load->model('ulasan_m');
		$this->load->model('pesanan_m');
		$this->load->model('riwayat_m');
	}

	public function index($start=0){
		$per_page = 6;

		$this->ulasan_m->paginate_avg($per_page);
		$data = [
			'reviews' => $this->ulasan_m->get_by_average($per_page, $start),
			'head' => 'Ulasan Rata - Rata'
		];

		$this->template->load('template2', 'ulasan/ulasan', $data);
	}
	
	public function list($id, $start=0){
		$rating = intval($this->input->get('rating', true));
		$per_page = 6;
		/* Pagination */
		$this->ulasan_m->paginate($id, $per_page, $rating);

		$user = $this->fungsi->user_login();
		$data = [
			'id' => $id,
			'reviews' => $this->ulasan_m->get_ulasan($id, $per_page, $start, $rating),
			'head' => 'Daftar Ulasan'
		];

		$this->template->load('template2', 'ulasan/daftarulasan', $data);
	}

	public function tambah($id = null){
		$user = $this->fungsi->user_login();
		if(is_null($id) || $user['status'] != 'user') redirect('riwayat');
		$riwayat = $this->riwayat_m->get($id);
		if(is_null($riwayat)) redirect('riwayat');
		if($riwayat['id_pengguna'] != $user['id_pengguna']) redirect('');

		if(!$this->form_validation->run('manage_ulasan')){
			$data = [
				'head' => 'Tambah Ulasan'
			];

			$this->template->load('template2', 'ulasan/tambahulasan', $data);
		}else{
			$res = $this->ulasan_m->tambah_ulasan($riwayat);
			$this->session->set_flashdata('swal', $res);

			redirect('riwayat');
		}
	}

	public function detail($id = null){
		if(is_null($id)) redirect('ulasan');
		$ulasan = $this->ulasan_m->get_ulasan_byid($id);
		if(is_null($ulasan)) redirect('ulasan');

		$data = [
			'pengguna' => $this->fungsi->user_login(),
			'ulasan' => $this->ulasan_m->get_ulasan_byid($id),
			'pesanan' => $this->pesanan_m->get_by_invoice($ulasan['id_invoice']),
			'head' => 'Detail Pesanan'
		];
		
		$this->template->load('template2', 'ulasan/detailulasan', $data);
	}

	public function edit($id = null){
		$user = $this->fungsi->user_login();

		if(is_null($id) || $user['status'] != 'user') redirect('ulasan');
		$ulasan = $this->ulasan_m->get_ulasan_byid($id);
		if(is_null($ulasan)) redirect('ulasan');
		if($ulasan['id_pengguna'] != $user['id_pengguna']) redirect('');

		if(!$this->form_validation->run('manage_ulasan')){
			$data = [
				'ulasan' => $ulasan
			];

			$this->template->load('template2', 'ulasan/editulasan', $data);
		}else{
			$res = $this->ulasan_m->edit($id);
			$this->session->set_flashdata('swal', $res);

			redirect("ulasan/detail/$id");
		}

	}
	
}
