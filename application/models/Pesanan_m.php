<?php
class Pesanan_m extends CI_Model{
 
    public function getpes($id = null){
        $this->db->from('pesanan');
        if($id != null){
            $this->db->where('id_pesanan', $id);
        }
        $query = $this->db->get();
        return $query;

    }
    public function getpesmed($id){
        return $this->db->get_where('invoice', ['id_medis' => $id, 'status' => 'accepted'])->result_array();

    }
    public function getpesuser($id){
        $this->db->from('invoice');
        $this->db->where('id_pengguna', $id);
        $query = $this->db->get()->result_array();
        return $query;
    }
    public function addpes($post,$lay,$id){
        $params ['id_layanan'] = $post['id_layanan'];
        $params ['id_pasien'] = $post['id_pasien'];
        $params ['id_pengguna'] = $id;
        $params ['tgl_kunjungan'] = $post['tgl_kunjungan'];
        $params ['jam_kunjungan'] = $post['jam_kunjungan'];
        $params ['provinsi'] = $post['provinsi'];
        $params ['kabupaten'] = $post['kota'];
        $params ['kecamatan'] = $post['kecamatan'];
        $params ['desa'] = $post['desa'];
        $params ['kondisi_terkini'] = $post['kondisi'];
        $params ['alamat_pasien'] = $post['alamat'];

        $this->db->insert('pesanan',$params);
    }
    public function delpes($id){
        $this->db->where('id_pesanan',$id);
        $this->db->delete('pesanan');
    }
    public function edit($post){
        $params ['id_pesanan'] = $post['id_pesanan'];
        $params ['id_layanan'] = $post['id_layanan'];
        $params ['id_pasien'] = $post['id_pasien'];
        $params ['id_pengguna'] = $post['id_pengguna'];
        $params ['tgl_kunjungan'] = $post['tgl_kunjungan'];
        $params ['jam_kunjungan'] = $post['jam_kunjungan'];
        $params ['provinsi'] = $post['provinsi'];
        $params ['kabupaten'] = $post['kabupaten'];
        $params ['kecamatan'] = $post['kecamatan'];
        $params ['desa'] = $post['desa'];
        $params ['id_medis'] = $post['id_medis'];
        $params ['kondisi_terkini'] = $post['kondisi'];
        $params ['alamat_pasien'] = $post['alamat'];

        $this->db->where('id_pesanan',$post['id_pesanan']);
        $this->db->update('pesanan',$params);
    }
    public function diterima($post){
        $params ['id_pesanan'] = $post['id_pesanan'];
        $params ['id_layanan'] = $post['id_layanan'];
        $params ['id_pasien'] = $post['id_pasien'];
        $params ['id_pengguna'] = $post['id_pengguna'];
        $params ['tgl_kunjungan'] = $post['tgl_kunjungan'];
        $params ['jam_kunjungan'] = $post['jam_kunjungan'];
        $params ['provinsi'] = $post['provinsi'];
        $params ['kabupaten'] = $post['kabupaten'];
        $params ['kecamatan'] = $post['kecamatan'];
        $params ['desa'] = $post['desa'];
        $params ['id_medis'] = $post['id_medis'];
        $params ['status'] = $post['status'];
        $params ['kondisi_terkini'] = $post['kondisi'];
        $params ['alamat_pasien'] = $post['alamat'];
        

        $this->db->where('id_pesanan',$post['id_pesanan']);
        $this->db->update('pesanan',$params);
    }
    function selesaikan($id_invoice, $total){
        $lainnya = $this->input->post('biaya_lain', true);
        $obat = $this->model_invoice->ambil_id_obat($id_invoice);
        $biaya_obat = 0;
        foreach($obat as $ob){
            $biaya_obat += $ob['harga'] * $ob['qty'];
        }
        $data = [
            'status' => 'paying',
            'total' => $total,
            'biaya_obat' => $biaya_obat,
            'biaya_lain' => $lainnya
        ];
        
        $this->db->update('invoice', $data, ['id_invoice' => $id_invoice]);
        return $this->db->affected_rows();
    }
    function get_data($table){
		return $this->db->get($table);
	}
    
    public function coverage_check($id_kec){
        $postfee = $this->db->get_where('ongkir', ['id_kecamatan' => $id_kec])->row_array();
        if(empty($postfee)){
            return ['status' => 'error', 'msg' => 'Maaf, daerah anda belum tercover'];
        }else{
            return ['status' => 'success', 'fee' => number_format($postfee['tarif'], 0, ',', '.')];
        }
    }

    public function manageObat($id){
        $this->load->model('Obat_m', 'obat');

        $obats = $this->db->get_where('pesanan_obat', ['id_invoice' => $id])->result_array();
        foreach ($obats as $obat) {
            $ob = $this->db->get_where('obat', ['id_obat' => $obat['id_obat']])->row_array();
            $stok = intval($ob['stok']) + intval($obat['qty']);
            $this->db->update('obat', ['stok' => $stok], ['id_obat' => $ob['id_obat']]);
        }
        $this->db->delete('pesanan_obat', ['id_invoice' => $id]);
    }

    public function tambah_obat($id, $qty){
        $obat = $this->db->get_where('obat', ['id_obat' => $id])->row_array();
        $sess = $this->session->userdata('obat');
        if(is_null($obat)) return ['status' => 'error', 'msg' => 'Obat tidak ditemukan'];
        if(isset($sess[$id])){
            $stock = $obat['stok'] - $sess[$id];
            if($stock < $qty){
                return ['status' => 'error', 'msg' => 'Stok tidak memadai'];
            }else{
                $sess[$id] = $sess[$id] + $qty;
                $this->session->set_userdata('obat', $sess);
                return ['status' => 'success', 'msg' => 'Berhasil menambahkan', 'items' => $this->cart_obat()];
            }
        }else{
            $stock = $obat['stok'];
            if($stock < $qty){
                return ['status' => 'error', 'msg' => 'Stok tidak memadai'];
            }else{
                $sess[$id] = $qty;
                $this->session->set_userdata('obat', $sess);
                return ['status' => 'success', 'msg' => 'Berhasil menambahkan', 'items' => $this->cart_obat()];
            }
        }
    }

    public function hapus_obat($id, $sess){
        $qty = $sess[$id] - 1;
        if($qty < 1){
            unset($sess[$id]);
        }else{
            $sess[$id] = $qty;
        }
        $this->session->set_userdata('obat', $sess);
        return ['status' => 'success', 'msg' => 'Berhasil menghapus', 'items' => $this->cart_obat()];
    }

    public function cart_obat(){
        $sess = $this->session->userdata('obat');
        $arr = [];
        foreach($sess as $id => $qty){
            $nama = $this->db->get_where('obat', ['id_obat' => $id])->row_array()['nama'];
            $arr[] = ['id' => $id, 'nama' => $nama, 'qty' => $qty];
        }
        return $arr;
    }

    public function confirm_obat($sess, $id){
        foreach($sess as $id_obat => $qty){
            $pes_ob = $this->db->get_where('pesanan_obat', ['id_invoice' => $id, 'id_obat' => $id_obat])->row_array();
            if(!is_null($pes_ob)){
                $jumlah = $pes_ob['qty'] + $qty;
                $where = ['id_invoice' => $id, 'id_obat' => $id_obat];
                $this->db->update('pesanan_obat', ['qty' => $jumlah], $where);
                $this->obat_m->ambilStok($id_obat, $qty);
            }else{
                $data = ['id_invoice' => $id, 'id_obat' => $id_obat, 'qty' => $qty];
                $this->db->insert('pesanan_obat', $data);
                $this->obat_m->ambilStok($id_obat, $qty);
            }
        }

        $this->session->unset_userdata('obat');
        
        if($this->db->affected_rows() > 0){
            return ['type' => 'success', 'msg' => 'Berhasil menambahkan obat'];
        }else{
            return ['type' => 'error', 'msg', 'Gagal menambahkan obat'];
        }
    }

    public function delKondisi($kondisi){
        if($kondisi != 'default.jpg'){
            @unlink('./assets/img/kondisi/'.$kondisi);
        }
    }

    public function get_layanan($id){
        return $this->db->get_where('pesanan', ['id_invoice' => $id])->result_array();
    }
}
