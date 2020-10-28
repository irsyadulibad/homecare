<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pembayaran extends CI_Controller {

	function __construct(){
		parent::__construct();
		check_not_login();
		$this->load->model('pembayaran_m');
		$this->load->model('pesanan_m');
		$this->load->model('invoice_m');
		$this->load->model('user_m');
		$this->load->model('alamat_m');
	}

	public function index(){
		$user = $this->fungsi->user_login();
		$data = [
			'invoices' => $this->invoice_m->get_paying($user['id_medis']),
			'head' => 'Pembayaran'
		];

		$this->template->load('template2', 'pembayaran/index', $data);
	}

	public function konfirmasi($id = null){
		$this->load->model('medis_m');
		$this->load->model('riwayat_m');
		$user = $this->fungsi->user_login();

		if(is_null($id)) redirect('pembayaran');
		$invoice = $this->invoice_m->get($id);
		if(is_null($invoice)) redirect('pembayaran');

		if(!$this->form_validation->run('konfir_pembayaran')){
			$data = [
				'invoice' => $invoice,
				'pesanans' => $this->pesanan_m->get_by_invoice($id),
				'user' => $user,
				'head' => 'Konfimasi Pembayaran'
			];

			$this->template->load('template2', 'pembayaran/konfirmasi', $data);
		}else{
			$res = $this->riwayat_m->set_riwayat($invoice);
			$this->session->set_flashdata('swal', $res);

			$red = ($res['type'] == 'success') ? 'riwayat' : 'pembayaran';
			redirect($red);
		}
		
	}

	public function batalkan($id = null){
		$user = $this->fungsi->user_login();
		if(is_null($id)) redirect('pembayaran');

		switch($user['status']){
			case 'admin':
				redirect('pesanan');
				break;
			case 'user':
				redirect('pesanan');
				break;
		}

		$res = $this->invoice_m->cancel_paying($id);
		$this->session->set_flashdata('swal', $res);

		redirect('pesanan/dimedis');
	}
}
