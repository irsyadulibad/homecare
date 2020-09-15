<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pembayaran_m extends CI_Model{
  public function set_history($invoice){
    $prov = $this->pesanan_m->getProv($invoice['provinsi'])['nama'];
    $kota = $this->pesanan_m->getKota($invoice['kota'])['nama'];
    $kec = $this->pesanan_m->getKec($invoice['kecamatan'])['nama'];
    $desa = $this->pesanan_m->getDesa($invoice['desa'])['nama'];

    $data = [
      'id_invoice' => $invoice['id_invoice'],
      'id_pengguna' => $invoice['id_pengguna'],
      'tgl_kunjungan' => $invoice['tgl_kunjungan'],
      'jam_kunjungan' => $invoice['jam_kunjungan'],
      'tgl_pesan' => $invoice['tgl_pesan'],
      'total' => intval($invoice['total']) + intval($invoice['biaya_obat']),
      'biaya_kirim' => intval($invoice['biaya_kirim']),
      'biaya_lain' => $invoice['biaya_lain'],
      'id_medis' => $invoice['id_medis']
    ];
    $this->db->insert('riwayat', $data);
    return $this->db->affected_rows();
  }
  public function del_invoice($id_invoice){
    $invoice = $this->db->get_where('invoice', ['id_invoice' => $id_invoice])->row_array();
    if($invoice['kondisi'] != 'default.jpg'){
      @unlink('./assets/img/kondisi/'.$invoice['kondisi']);
    }
    $this->db->delete('invoice', ['id_invoice' => $id_invoice]);
    return $this->db->affected_rows();
  }
}
