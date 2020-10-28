<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Riwayat_m extends CI_Model{
	private $table = 'riwayat';
	public function set_riwayat($invoice){
		$data = [
			'id_invoice' => $invoice['id_invoice'],
			'id_pengguna' => $invoice['id_pengguna'],
			'tgl_kunjungan' => date('Y-m-d'),
			'jam_kunjungan' => date('H:i:s'),
			'tgl_pesan' => date('Y-m-d H:i:s'),
			'kondisi' => $this->input->post('kondisi', true),
			'riwayat_penyakit' => $this->input->post('riwayat_penyakit', true),
			'alergi' => $this->input->post('alergi', true)
		];

		if($this->invoice_m->set_finished($data['id_invoice']) > 0){
			$this->db->insert($this->table, $data);

			if($this->db->affected_rows() > 0){
	      return [
	        'type' => 'success',
	        'msg' => 'Berhasil mengkonfirmasi pembayaran'
	      ];
	    }else{
	      return [
	        'type' => 'error',
	        'msg' => 'Gagal mengkonfirmasi pembayaran'
	      ];
	    }

		}else{
			return [
				'type' => 'error',
				'msg' => 'Gagal melakukan konfirmasi pembayaran'
			];
		}
		
	}
}
