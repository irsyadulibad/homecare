<?php

Class Fungsi {
  public function __construct(){
    $this->ci =& get_instance();

  }
  public function user_login(){
    $this->ci->load->model('User_m', 'user');
    $this->ci->load->model('Medis_m', 'medis');
    $login = $this->ci->session->userdata('user');

    if($login['status'] == 'admin' || $login['status'] == 'user'){
      return $this->ci->user->get($login['id_pengguna']);
    }else if($login['status'] == 'medis' || $login['status'] == 'paramedis'){
      return $this->ci->medis->get($login['id_pengguna']);
    }
  }

  public function get_user($uid){
    $this->ci->load->model('user_m');
    $user =$this->ci->user_m->get($uid);
    $user['alamat'] = $this->get_address($user['id_alamat']);
    return $user; 
  }

  public function get_address($aid, $type = 'arr'){
    $addr = $this->ci->db->get_where('alamat_pengguna', ['id_alamat' => $aid])->row_array();
    $str = "";

    if($type == 'arr'){
      return $addr;
    }else if($type = 'str'){
      $this->ci->load->model('Daerah_m', 'daerah');
      $des = $this->ci->daerah->desa($addr['id_desa'])['nama'];
      $kec = $this->ci->daerah->kecamatan($addr['id_kecamatan'])['nama'];
      $kot = $this->ci->daerah->kabupaten($addr['id_kabupaten'])['nama'];
      $prov = $this->ci->daerah->get_provinsi($addr['id_provinsi'])['nama'];
      $addr = $addr['alamat'];
      return "$addr, $des - $kec - $kot - $prov";
    }
  }
}
