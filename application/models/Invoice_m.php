<?php

class Invoice_m extends CI_model{
  private $table = 'invoice';

  public function total(){
    return count($this->db->get($this->table)->result_array());
  }

  public function get_pending(){
    return $this->db->get($this->table)->result_array();
  }

  public function index(){
    $this->load->model('Obat_m', 'obat');

    $carts = $this->cart->contents();
    date_default_timezone_set('Asia/Makassar');
    $nama = $this->input->post('id_pasien');
    $alamat = $this->input->post('alamat');
    $provinsi = $this->input->post('provinsi');
    $kota = $this->input->post('kota');
    $kecamatan = $this->input->post('kecamatan');
    $desa = $this->input->post('desa'); 
    $tgl_kunjungan = $this->input->post('tgl_kunjungan');
    $jam_kunjungan = $this->input->post('jam_kunjungan');
    $kondisi = $this->input->post('kondisi');
    $id = $this->fungsi->user_login()->id_pengguna;
    $total = 0;

    foreach ($carts as $item) {
      $total += intval($item['price'] * $item['qty']);
    }

    $invoice = array(
      'id_pengguna'=> $id,
      'nama' => $nama,
      'alamat' => $alamat,
      'provinsi' => $provinsi,
      'kota' => $kota,
      'kecamatan' => $kecamatan,
      'desa' => $desa,
      'tgl_kunjungan' => $tgl_kunjungan,
      'jam_kunjungan' => $jam_kunjungan,
      'kondisi' => $kondisi,
      'total' => $total,
      'tgl_pesan' => date('Y-m-d H:i:s')
    );
    $this->db->insert('invoice',$invoice);
    $id_invoice = $this->db->insert_id();

    foreach ($carts as $item){
      $data = array(
        'id_invoice' => $id_invoice,
        'id_layanan' => $item['id'],
        'nama_layanan' => $item['name'],
        'jumlah'      => $item['qty'],
        'harga'     => $item['price']
      );

      $data_obat = [
        'id_invoice' => $id_invoice,
        'id_obat' => $item['obat_id'],
        'qty' => $item['qty']
      ];

      $this->db->insert('pesanan',$data);
      $this->db->insert('pesanan_obat', $data_obat);
      $this->obat->ambilStok($item['obat_id'], $item['qty']);
    }
    return true;
  }
  public function tampil_data(){
    $result = $this->db->get('invoice');
    if($result->num_rows() > 0){
      return $result->result();
    }else{
      return false;
    }

  }
  public function ambil_id_invoice($id_invoice){
    $result = $this->db->where('id_invoice',$id_invoice)->limit(1)->get('invoice');
    if($result->num_rows() > 0){
      return $result->row();
    }else {
      return false;
    }
  }
  public function ambil_id_pesanan($id_invoice){
    $result = $this->db->where('id_invoice',$id_invoice)->get('pesanan');
    if($result->num_rows() > 0){
      return $result->result();
    }else {
      return false;
    }
  }

  public function ambil_id_obat($id_invoice){
    $this->db->select('ps.id_obat, ps.id_invoice, ps.qty, ob.nama, ob.harga');
    $this->db->from('pesanan_obat as ps');
    $this->db->where('ps.id_invoice', $id_invoice);
    $this->db->join('obat as ob', 'ps.id_obat = ob.id_obat');
    return $this->db->get()->result_array();
  }

  public function terima($id_invoice, $medis){
    $biaya_lain = $this->input->post('biaya_lain', true);
    $this->db->where('id_invoice', $id_invoice);
    $this->db->update('invoice', [
      'status' => 'accepted',
      'biaya_lain' => intval($biaya_lain),
      'id_medis' => $medis->id_pengguna
    ]);
    return $this->db->affected_rows();
  }
}
