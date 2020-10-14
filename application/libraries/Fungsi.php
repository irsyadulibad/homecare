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
    $user_data =$this->ci->user_m->get($uid)->row();
    $user_data->alamat = $this->get_address($uid);
    return $user_data;
  }

  public function get_address($uid, $type = 'arr'){
    $addr = $this->ci->db->get_where('alamat', ['id_pengguna' => $uid])->row();
    $str = "";

    if($type == 'arr'){
      return $addr;
    }else if($type = 'str'){
      $this->ci->load->model('Daerah_m', 'daerah');
      $des = $this->ci->daerah->desa($addr->desa)->nama;
      $kec = $this->ci->daerah->kecamatan($addr->kecamatan)->nama;
      $kot = $this->ci->daerah->kota($addr->kota)->nama;
      $prov = $this->ci->daerah->get_provinsi($addr->provinsi)->nama;
      $addr = $addr->alamat;
      return "$addr, $des - $kec - $kot - $prov";
    }
  }
}
