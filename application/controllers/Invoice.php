<?php 

class Invoice extends CI_Controller{
  function __construct(){
    parent::__construct();
    $this->load->model('invoice_m');
    $this->load->model('pesanan_m');
    $this->load->model('layanan_m');
    $this->load->model('user_m');
    $this->load->model('medis_m');
  }

  public function index(){
    $user = $this->fungsi->user_login();
    if($user['status'] != 'admin') redirect('pesanan');

    $data = [
      'invoices' => $this->invoice_m->get()
    ];

    $this->template->load('template2','cart/invoice',$data);
  }

  public function detail($id_invoice){
    $this->load->model('alamat_m');
    if(is_null($id_invoice)) redirect();

    $data = [
      'invoice' => $this->invoice_m->get($id_invoice),
      'pesanans' => $this->pesanan_m->get_by_invoice($id_invoice),
      'head' => 'Detail Invoice'
    ];

    $this->template->load('template2','cart/detail',$data);
  }
  
  public function accept($id_invoice = null){
    $this->load->model('alamat_m');
    
    if(is_null($id_invoice)) redirect('');
    $user = $this->fungsi->user_login();
    $invoice = $this->invoice_m->get($id_invoice);
    $pesanans = $this->pesanan_m->get_by_invoice($id_invoice);

    // Khusus untuk pengecekan status
    if(!$this->invoice_m->check_accept_status($user, $pesanans)){
      $this->session->set_flashdata('swal', [
        'type' => 'error',
        'msg' => 'Maaf, anda tidak dapat menerima pesanan ini'
      ]);
      redirect('');
    }

    // Pengecekan alamat
    if($user['id_alamat'] == null){
      $this->session->set_flashdata('swal', [
        'type' => 'error',
        'msg' => 'Anda harus mengisikan alamat terlebih dahulu'
      ]);

      redirect('profile/editaddr');
    }

    $pasien = $this->fungsi->get_user($invoice['id_pengguna']);
    $bJalan = $this->alamat_m->get_biaya_jalan($user['id_alamat'], $pasien['id_alamat']);

    if(is_null($bJalan)){
      $this->session->set_flashdata('swal', [
        'type' => 'error',
        'msg' => 'Maaf, jarak anda dengan pasien belum tercover'
      ]);

      redirect('');
    }

    $this->form_validation->set_rules('id', 'ID', 'required');

    if(!$this->form_validation->run()){
      $data = [
        'invoice' => $invoice,
        'pesanans' => $pesanans,
        'medis' => $user,
        'user' => $pasien,
        'bJalan' => $bJalan,
        'head' => 'Terima Pesanan'
      ];

      $this->template->load('template2', 'cart/accept', $data);
    }else{
      $res = $this->invoice_m->accept_invoice($user, $invoice);
      $this->session->set_flashdata('swal', $res);

      redirect($res['rdr']);
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
