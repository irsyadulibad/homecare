<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Riwayat_m extends CI_Model{
	private $table = 'riwayat';

	public function get($id = null){
		if(!is_null($id)){
      return $this->db->get_where($this->table, [
        'id_riwayat' => $id
      ])->row_array();
    }else{
      return $this->db->get($this->table)->result_array();
    }
	}

	public function get_by_medis($mid){
		$this->db->from('riwayat as rwy');
		$this->db->join('invoice as inv', 'inv.id_invoice = rwy.id_invoice');
		$this->db->where('inv.id_medis', $mid);
		return $this->db->get()->result_array();
	}

	public function get_by_user($uid){
		return $this->db->get_where($this->table, [
			'id_pengguna' => $uid
		])->result_array();
	}

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
