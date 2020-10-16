<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Homecare extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model('pesanan_m');
		$this->load->model('ulasan_m');
		$this->load->model('invoice_m');
	}

	public function index(){
		check_not_login();
		$user = $this->fungsi->user_login();

		if($user['status'] == 'admin'){

			$this->load->model('user_m');
			$this->load->model('medis_m');

			$data = [
				'rateaverage' => $this->ulasan_m->get_average_all(),
				'pesanan' => $this->invoice_m->total(),
				'pengguna' => $this->user_m->total(),
				'paramedis' => $this->medis_m->total()
			];

			$this->template->load('template2', 'dashboard/dashboard', $data);
		}else if($user['status'] == 'medis' || $user['status'] == 'paramedis'){
			
			$id = $user['id_medis'];
			$data = [
				'pending_invoice' => $this->invoice_m->get_pending(),
				'rateaverage' => $this->ulasan_m->get_average_by_medic($id),
				'pesanan' => count($this->pesanan_m->getpesmed($id))
			];

			$this->template->load('template2', 'dashboard/dasmedis', $data);
		}else{
			
			$id = $user['id_pengguna'];
			$data = [
				'pesanan' => count($this->pesanan_m->getpesuser($id))
			];

			$this->template->load('template2', 'dashboard/home', $data);
		}
	}
}
