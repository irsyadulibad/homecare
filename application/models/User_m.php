<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_m extends CI_Model {
  private $table = 'pengguna';

  public function login($email, $pass){
    $data = [
      'email' => $email,
      'password' => sha1($pass)
    ];
    
    return $this->db->get_where($this->table, $data)->row_array();
  }

  public function get($id = null){
    $data = [
      'id_pengguna' => $id
    ];

    if(is_null($id)){
      return $this->db->get($this->table)->result_array();
    }else{
      return $this->db->get_where($this->table, $data)->row_array();
    }
  }

  public function total(){
    return count($this->db->get('pengguna')->result_array());
  }

  public function add(){

    $status = $this->input->post('level', true);
    $data = [
      'nama_lengkap' => $this->input->post('fullname', true),
      'no_hp' => $this->input->post('nohp', true),
      'jenis_kelamin' => $this->input->post('jenkel', true),
      'status' => $status,
      'email' => $this->input->post('email', true),
      'password' => sha1($this->input->post('password', true)),
      'foto' => 'default.jpg'
    ];

    if($status == 'admin' || $status == 'user'){
      $data['active'] = '1';

      $this->db->insert('pengguna', $data);
    }else{
      $this->db->insert('medis', $data);
    }

    return $this->db->affected_rows();
  }

  public function edit($id, $pass = false){
    $data = [
      'nama_lengkap' => $this->input->post('fullname', true),
      'no_hp' => $this->input->post('nohp', true),
      'jenis_kelamin' => $this->input->post('jenkel', true),
      'status' => $this->input->post('level', true),
      'email' => $this->input->post('email', true),
    ];

    if($pass) $data['password'] = sha1($this->input->post('password', true));

    $this->db->update($this->table, $data, ['id_pengguna' => $id]);
    return $this->db->affected_rows();
  }

  public function delete($id){
    $this->db->delete($this->table, ['id_pengguna' => $id]);

    return $this->db->affected_rows();
  }

  public function _uploadImage()
  {
    $config['upload_path']          = './assets/images/profile/';
    $config['allowed_types']        = 'gif|jpg|png';
    $config['file_name']            = $this->fungsi->user_login()->id_pengguna;
    $config['overwrite']			= true;
        $config['max_size']             = 1024; // 1MB
        // $config['max_width']            = 1024;
        // $config['max_height']           = 768;

        $this->load->library('upload', $config);

        if ($this->upload->do_upload('image')) {
          return $this->upload->data("file_name");
        }
        
        return "default.jpg";
      }
    }
