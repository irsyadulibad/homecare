<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pembayaran extends CI_Controller {

	function __construct(){
		parent::__construct();
		check_not_login();
		$this->load->model('Pembayaran_m', 'pembayaran_m');
		$this->load->library('form_validation');
		$this->load->model('Pesanan_m', 'pesanan_m');
		$this->load->model('Model_invoice', 'model_invoice');
	}
	public function index(){
		$id = $this->fungsi->user_login()->id_pengguna;
		$data['invoices'] = $this->db->get_where('invoice', ['id_medis' => $id, 'status' => 'paying'])->result_array();
		$this->template->load('template2', 'pembayaran/index', $data);
	}
	public function konfirmasi($id_invoice=null){
		if(is_null($id_invoice)) redirect('pesanan/dimedis');
      $this->load->model('model_invoice');
      $data['invoice'] = $this->model_invoice->ambil_id_invoice($id_invoice);
      if(!$data['invoice']) redirect('riwayat');
      $data['pesanan'] = $this->model_invoice->ambil_id_pesanan($id_invoice);
      $data['medis'] = $this->db->get_where('pengguna', ['id_pengguna' => $data['invoice']->id_medis])->row_array();
	  $data['head'] = "Selesaikan Pesanan";
	  $data['obat'] = $this->model_invoice->ambil_id_obat($id_invoice);
      $this->template->load('template2','pembayaran/konfirmasi',$data);
    }
    public function bayar($id_invoice = null){
    	$user = $this->fungsi->user_login();
    	if(is_null($id_invoice)) redirect('pesanan');
    	if($user->role != 2) redirect('pesanan');
    	$invoice = $this->db->get_where('invoice', ['id_invoice' => $id_invoice])->row_array();
    	if($invoice['id_medis'] != $user->id_pengguna) redirect('pembayaran');
    	if($this->pembayaran_m->set_history($invoice) > 0){
    		if($this->pembayaran_m->del_invoice($id_invoice) > 0 ){
    			$this->session->set_flashdata('swal', ['type' => 'success', 'msg' => 'Berhasil mengkonfirmasi']);
				redirect('riwayat');
    		}else{
    			$this->session->set_flashdata('swal', ['type' => 'danger', 'msg' => 'Terjadi kesalahan pada proses']);
				redirect("pembayaran/konfirmasi/$id_invoice");
    		}
    	}else{
    		$this->session->set_flashdata('swal', ['type' => 'danger', 'msg' => 'Terjadi kesalahan pada proses']);
			redirect("pembayaran/konfirmasi/$id_invoice");
    	}
    }
	public function batalkan($id = null){
		$user = $this->fungsi->user_login();
		if(is_null($id)) redirect('pesanan');
		$pesanan = $this->db->get_where('invoice', ['id_invoice' => $id])->row_array();
		if($user->role == 2){
			if(is_null($pesanan) || $pesanan['id_medis'] != $user->id_pengguna) redirect('pesanan');
			$this->db->update('invoice', ['status' => 'accepted', 'biaya_obat' => null], ['id_invoice' => $pesanan['id_invoice']]);
			if($this->db->affected_rows() > 0){
          		$this->session->set_flashdata('swal', ['type' => 'success', 'msg' => 'Berhasil membatalkan pembayaran']);
				redirect('pesanan/dimedis');
        	}else{
          		$this->session->set_flashdata('swal', ['type' => 'danger', 'msg' => 'Gagal membatalkan pembayaran']);
				redirect('pembayaran');
        	}
		}else{
			redirect('pesanan');
		}
	}
}
