<?php

Class Fungsi {
    public function __construct(){
        $this->ci =& get_instance();

    }
    public function user_login(){
        $this->ci->load->model('user_m');
        $user_id=$this->ci->session->userdata('id_pengguna');
        $user_data=$this->ci->user_m->get($user_id)->row();
        $user_data->alamat = $this->get_address($user_id);
        return $user_data;
    }

    public function get_user($id){
    	$this->ci->load->model('user_m');
    	$user_data=$this->ci->user_m->get($id)->row();
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
