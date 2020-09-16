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
        $this->ci->load->model('Dropdown_chained_model', 'model');
        $des = $this->desa($addr->desa)->nama;
        $kec = $this->kecamatan($addr->kecamatan)->nama;
        $kot = $this->kota($addr->kota)->nama;
        $prov = $this->provinsi($addr->provinsi)->nama;
        $addr = $addr->alamat;
        return "$addr, $des - $kec - $kot - $prov";
      }
    }

    public function desa($id){
      return $this->ci->db->get_where('dd_desa', ['id' => $id])->row();
    }

    public function kecamatan($id){
      return $this->ci->db->get_where('dd_kecamatan', ['id' => $id])->row();
    }

    public function kota($id){
      return $this->ci->db->get_where('dd_kota', ['id_kota' => $id])->row();
    }

    public function provinsi($id){
      return $this->ci->db->get_where('dd_provinsi', ['id_provinsi' => $id])->row();
    }
}
