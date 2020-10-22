<?php
class Cart_m extends CI_Model{
  public function __construct(){
    parent::__construct();
    $this->load->model('obat_m');
  }

  public function rowids(){
    $arr = [];

    foreach($this->cart->contents() as $cart){
      $id = $cart['id'];
      $arr += [
        "$id" => $cart['rowid']
      ];
    }

    return $arr;
  }

  public function add($layanan){
    $rowid = $this->input->post('rowid', true);
    $exist = $this->check_stock($layanan['id_layanan']);

    if(!$exist['status']){
      return [
        'status' => 'error',
        'msg' => $exist['msg']
      ];
    }

    if(!$this->cart->get_item($rowid)){
      $rowid = $this->insert($layanan);

      return [
        'status' => 'success', 
        'rowid' => $rowid,
        'msg' => 'Berhasil menambah pesanan'
      ];
    }else{
      $rowid = $this->insert($layanan);

      return [
        'status' => 'success',
        'rowid' => $rowid,
        'msg' => 'Berhasil menambah pesanan'
      ];
    }

  }

  public function delete($rowid, $id){
    $obats = $this->obat_m->get_default_relation($id);
    $sess = $this->session->userdata('obat');

    foreach($obats as $obat){
      $id_obat = intval($obat['id_obat']);
      $sess[$id_obat] = $sess[$id_obat] - 1;
    }

    $this->session->set_userdata('obat', $sess);

    $qty = $this->cart->get_item($rowid)['qty'];
    $data = [
      'rowid' => $rowid,
      'qty' => $qty - 1
    ];

    $this->cart->update($data);
    return $this->show();

  }

  private function insert($layanan){
    $data = [
      'id' => $layanan['id_layanan'],
      'qty' => 1,
      'price' => $layanan['harga'],
      'name' => $this->validate_name($layanan['jenis_layanan'])
    ];

    $rowid = $this->cart->insert($data);
    $qty = $this->cart->get_item($rowid)['qty'];
    $obats = $this->obat_m->get_default_relation($layanan['id_layanan']);

    $this->manage_obat_session($obats, $qty);
    return $rowid;
  }

  private function manage_obat_session($obats, $qty){
    $sess = $this->session->userdata('obat');

    foreach($obats as $obat){
      $id = $obat['id_obat'];

      if(isset($sess[$id])){
        $sess[$id] = $sess[$id] + 1;
      }else{
        $sess[$id] = $qty;
      }

    }

    $this->session->set_userdata('obat', $sess);
  }

  private function check_stock($id){
    $sess = $this->session->userdata('obat');
    $obats = $this->obat_m->get_default_relation($id);
    $stocks = [];

    if(empty($obats)){
      return [
        'status' => false,
        'msg' => 'Obat belum tersedia untuk layanan ini'
      ];
    }else{
      foreach($obats as $obat){
        $id_obat = intval($obat['id_obat']);
        $stock = intval($obat['stok']);
        $stocks[] = isset($sess[$id_obat]) ? $stock - $sess[$id_obat] : $stock;
      }

      foreach($stocks as $stock){
        if($stock < 1){
          return [
            'status' => false,
            'msg' => 'Stok obat untuk layanan ini habis'
          ];
        }
      }

      return ['status' => true];
    }
  }

  private function validate_name($name){
    $name = str_replace('(', '- --', $name);
    $name = str_replace(')', '-- -', $name);
    return $name;
  }

  private function reverse_name($name){
    $name = str_replace('- --', '(', $name);
    $name = str_replace('-- -', ')', $name);
    return $name;
  }

  public function show(){
    $carts = $this->cart->contents();

    if(empty($carts)){

      $content = '
        <tr>
          <td colspan="4">
            <p class="text-center">Data masih kosong</p>
          </td>
        </tr>
      ';

    }else{
      foreach($carts as $cart){
        $name = $this->reverse_name($cart['name']);
        $content = '
          <tr>
            <td>'.$name.'</td>
            <td>'.$cart['qty'].'</td>
            <td>'.$cart['subtotal'].'</td>
            <td>
              <button class="btn btn-danger del-cart-item" data-rowid="'.$cart['rowid'].'" data-id="'.$cart['id'].'">
                <i class="fas fa-trash-alt"></i> Hapus
              </button>
            </td>
          </tr>
        ';

      }
    }

    $html = '
      <div class="table-responsive">
        <table class="table table-bordered">
          <thead>
            <tr>
              <th>Nama Layanan</th>
              <th>Jumlah</th>
              <th>Harga</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            '.$content.'
          </tbody>
        </table>
      </div>
    ';

    return $html;
  }
}
