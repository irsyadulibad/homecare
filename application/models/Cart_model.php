<?php
class Cart_model extends CI_Model{
 
    public function get_all_produk(){
        $hasil=$this->db->get('layanan');
        return $hasil->result();
    }
    
    public function get_layanan($id){
        $layanan = $this->db->get_where('layanan', ['id_layanan' => $id])->row_array();
        return $layanan;
    }

    public function check_stock_obat($id){
        $obat = $this->db->get_where('obat', ['id_obat' => $id])->row_array();
        return intval($obat['stok']);
    }

    public function destruct_cart(){
        $arr = [];
        foreach ($this->cart->contents() as $cart) {
            $id = $cart['id'];
            $arr += ["$id" => $cart['rowid']];
        }
        return $arr;
    }

    public function insert($layanan){
        $rowid = $this->input->post('rowid', true);
        if(!$this->cart->get_item($rowid)){
            $rowid = $this->insert_cart($layanan);
            return ['status' => true, 'rowid' => $rowid];
        }else{
            $rowid = $this->insert_cart($layanan);
            return ['status' => true, 'rowid' => $rowid];
        }
    }

    public function insert_cart($layanan){
        $data = [
            'id' => $layanan['id_layanan'],
            'qty' => 1,
            'price' => $layanan['harga'],
            'name' => $layanan['jenis_layanan']
        ];

        $rowid = $this->cart->insert($data);
        $qty = $this->cart->get_item($rowid)['qty'];
        $obats = $this->db->get_where('lay_ob', ['id_layanan' => $layanan['id_layanan']])->result_array();
        $this->manage_session($obats, $qty);
        return $rowid;
    }

    public function manage_session($obats, $qty){
        $sess = $this->session->userdata('obat');

        foreach($obats as $obat){
            $obat_id = $obat['id_obat'];
            if(isset($sess[$obat_id])){
                $sess[$obat_id] = $sess[$obat_id] + 1;
            }else{
                $sess[$obat_id] = $qty;
            }
        }
        
        $this->session->set_userdata('obat', $sess);
    }

    public function show(){
        $carts = $this->cart->contents();
        $html = '<div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nama Layanan</th>
                    <th>Jumlah</th>
                    <th>Harga</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>';
        if(empty($carts)){
            $html .= '<tr>
                    <td colspan="4"><p class="text-center">Data masih kosong</p></td>
                </tr>
            </tbody>
            </table>
            </div>';
        }else{
            foreach($carts as $content){
                $html .= '<tr>
                    <td>'.$content['name'].'</td>'.
                    '<td>'.$content['qty'].'</td>'.
                    '<td>'.$content['subtotal'].'</td>'.
                    '<td>
                        <button class="btn btn-danger del-cart-item" data-rowid="'.$content['rowid'].'" data-id="'.$content['id'].'"><i class="fas fa-trash-alt"></i> Hapus</button>
                    </td>'.
                '</tr>';
            }
            $html .= '</tbody>
            </table></div>';
        }

        return $html;
    }

    public function delete(){
        $rowid = $this->input->post('rowid', true);
        $id = $this->input->post('id', true);

        $obats = $this->db->get_where('lay_ob', ['id_layanan' => $id])->result_array();
        $sess = $this->session->userdata('obat');
        foreach($obats as $obat){
            $id_obat = intval($obat['id_obat']);
            $sess[$id_obat] = $sess[$id_obat] - 1;
        }
        $this->session->set_userdata('obat', $sess);

        $qty = $this->cart->get_item($rowid)['qty'];
        $data = [
            'rowid' => $rowid,
            'qty' => $qty -1
        ];

        $this->cart->update($data);
        return $this->show();
    }

    public function checkout($fee){
        $user = $this->fungsi->user_login();
        $pasien = $this->input->post('id_pasien', true);
        $tgl = $this->input->post('tgl_kunjungan', true);
        $jam = $this->input->post('jam_kunjungan', true);
        $alamat = $this->input->post('alamat', true);
        $provinsi = $this->input->post('provinsi', true);
        $kota = $this->input->post('kota', true);
        $kecamatan = $this->input->post('kecamatan', true);
        $desa = $this->input->post('desa', true);
        $total = 0;
        $biaya_obat = 0;

        foreach ($this->cart->contents() as $cart) {
            $total += $cart['price'] * $cart['qty'];
        }
        foreach ($this->session->userdata('obat') as $id => $qty) {
            $price = $this->db->get_where('obat', ['id_obat' => $id])->row_array()['harga'];
            $biaya_obat += $price * $qty;
        }
        $pasien = explode('|', $pasien);

        $data = [
            'id_pengguna' => $user->id_pengguna,
            'id_pasien' => $pasien[1],
            'nama' => $pasien[0],
            'alamat' => $alamat,
            'provinsi' => $provinsi,
            'kota' => $kota,
            'kecamatan' => $kecamatan,
            'desa' => $desa,
            'jam_kunjungan' => $jam,
            'tgl_kunjungan' => $tgl,
            'kondisi' => $this->upload_kondisi(),
            'tgl_pesan' => date('Y-m-d'),
            'status' => 'pending',
            'total' => $total,
            'biaya_obat' => $biaya_obat,
            'biaya_kirim' => $fee
        ];
        
        $this->db->insert('invoice', $data);
        $id_invoice = $this->db->insert_id();

        foreach($this->cart->contents() as $content){
            $pesanan = [
                'id_invoice' => $id_invoice,
                'id_layanan' => $content['id'],
                'nama_layanan' => $content['name'],
                'jumlah' => $content['qty'],
                'harga' => $content['price']
            ];
            $this->db->insert('pesanan', $pesanan);
        }
        foreach($this->session->userdata('obat') as $id => $qty){
            $pesanan_obat = [
                'id_invoice' => $id_invoice,
                'id_obat' => $id,
                'qty' => $qty
            ];
            $this->obat_m->ambilStok($id, $qty);
            $this->db->insert('pesanan_obat', $pesanan_obat);
        }

        $this->cart->destroy();
        $this->session->unset_userdata('obat');
        return $this->db->affected_rows();
    }

    public function upload_kondisi(){
        $config['upload_path'] = './assets/img/kondisi/';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['encrypt_name'] = TRUE;
        $config['remove_spaces'] = TRUE;
        $config['max_size'] = 3000;

        $this->load->library('upload', $config);
        if(!$this->upload->do_upload('kondisi')){
            return 'default.jpg';
        }else{
            return $this->upload->data('file_name');
        }
    }

    public function coverage_check(){
        $id_kec = $this->input->post('kecamatan', true);
        $postfee = $this->db->get_where('ongkir', ['id_kecamatan' => $id_kec])->row_array();
        if(is_null($postfee)){
            return false;
        }else{
            return $postfee['tarif'];
        }
    }
}
