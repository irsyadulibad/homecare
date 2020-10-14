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

    return $this->db->get_where($this->table, $data)->row_array();
  }
  
  public function getmedis($id = null){
    $this->db->from('pengguna');
    $this->db->where('role','2');
    if($id != null){
      $this->db->where('id_pengguna', $id);
    }
    $this->db->order_by('nama_pengguna', 'ASC');
    $query = $this->db->get();
    return $query;

  }
  public function getpengguna($id = null){
    $this->db->from('pengguna');
    $this->db->where('role','3');
    if($id != null){
      $this->db->where('id_pengguna', $id);
    }
    $this->db->order_by('nama_pengguna', 'ASC');
    $query = $this->db->get();
    return $query;

  }

  public function add($post){
    $params ['nama_lengkap'] = $post['fullname'];
    $params ['nama_pengguna'] = $post['username'];
    $params ['password'] = sha1($post['password']);
    $params ['no_hp'] = $post['nohp'];
    $params ['email'] = $post['email'];
    $params ['foto'] = "default.jpg";
    $params ['jenis_kelamin'] = $post['jenkel'];
    $params ['role'] = $post['level'];
    $this->db->insert('pengguna',$params);
  }
  public function edit($post, $id){
    $params ['nama_lengkap'] = $post['fullname'];
    $params ['nama_pengguna'] = $post['username'];
    if(!empty($post['password'])){
      $params ['password'] = sha1($post['password']);
    }
    $params ['no_hp'] = $post['nohp'];
    $params ['email'] = $post['email'];
    $params ['jenis_kelamin'] = $post['jenkel'];
    $params ['role'] = $post['level'];
    $this->db->where('id_pengguna', $id);
    $this->db->update('pengguna',$params);
  }
  public function del($id){
    $this->db->where('id_pengguna',$id);
    $this->db->delete('pengguna');
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
