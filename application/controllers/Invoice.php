<?php 

class Invoice extends CI_Controller{
  function __construct(){
    parent::__construct();
    $this->load->model('invoice_m');
    $this->load->model('pesanan_m');
    $this->load->model('user_m');
    $this->load->model('medis_m');
  }

  public function index(){
    if($this->fungsi->user_login()->role != 1) redirect('pesanan');
    $data['invoice'] = $this->invoice_m->tampil_Data();
    $this->template->load('template2','cart/invoice',$data);
  }

  public function detail($id_invoice){
    if(is_null($id_invoice)) redirect();

    $data = [
      'invoice' => $this->invoice_m->get($id_invoice),
      'pesanans' => $this->pesanan_m->get_by_invoice($id_invoice),
      'head' => 'Detail Invoice'
    ];

    $this->template->load('template2','cart/detail',$data);
  }
  
  public function accept($id_invoice = null){
    if($this->fungsi->user_login()->role != 2) redirect();
    if(is_null($id_invoice)) redirect();
    $data['invoice'] = $this->invoice_m->ambil_id_invoice($id_invoice);
    if($data['invoice']->status != "pending") redirect();
    $data['pesanan'] = $this->invoice_m->ambil_id_pesanan($id_invoice);
    $data['obat'] = $this->invoice_m->ambil_id_obat($id_invoice);
    $data['medis'] = $this->fungsi->user_login();
    $this->form_validation->set_rules('biaya_lain', 'Biaya Lain', 'required', ['required' => 'Harus diisi']);
    if($this->form_validation->run() == FALSE){
      $this->template->load('template2', 'cart/accept', $data);
    }else{
      $res = $this->invoice_m->terima($id_invoice, $data['medis']);
      if($res > 0){
        $this->session->set_flashdata('swal', ['type' => 'success', 'msg' => 'Berhasil menerima pesanan']);
      }else{
        $this->session->set_flashdata('swal', ['type' => 'error', 'msg' => 'Gagal menerima pesanan']);
      }
      redirect('pesanan/dimedis');
    }
  }

  public function batal($id){
    $user = $this->fungsi->user_login();
    if(is_null($id)) redirect('pesanan');
    $pesanan = $this->db->get_where('invoice', ['id_invoice' => $id])->row_array();
    if($user->role == 1){
     if(is_null($pesanan)) redirect('pesanan');
     $this->db->delete('invoice', ['id_invoice' => $pesanan['id_invoice']]);
     $this->db->delete('pesanan', ['id_invoice' => $pesanan['id_invoice']]);
     if($this->db->affected_rows() > 0){
      echo "<script>
      alert('Pesanan berhasil dibatalkan');
      window.location='".site_url('invoice')."';
      </script>";
    }else{
      echo "<script>
      alert('Gagal');
      window.location='".site_url('invoice')."';
      </script>";
    }
  }else{
   redirect('pesanan');
 }
}
}
