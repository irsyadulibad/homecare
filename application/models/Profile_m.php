<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Profile_m extends CI_Model{
	public function edit_data(){
		$id = $this->fungsi->user_login()->id_pengguna;
		$nama = $this->input->post('name', true);
		$phone = $this->input->post('phone', true);
		$email = $this->input->post('email', true);
		$gender = $this->input->post('gender', true);

		$data = [
			'nama_lengkap' => $nama,
			'email' => $email,
			'no_hp' => $phone,
			'jenis_kelamin' => $gender
		];

		$this->db->update('pengguna', $data, ['id_pengguna' => $id]);
		return $this->db->affected_rows();
	}

	public function edit_imgapi($id){

		$config['upload_path'] = './assets/img/profile/';
		$config['allowed_types'] = 'gif|jpg|png';
		$config['encrypt_name'] = TRUE;
		$config['remove_spaces'] = TRUE;
		$config['max_size'] = 1500;

		$this->load->library('upload', $config);
		if(!$this->upload->do_upload('image')){
			return [
				'status' => 'error',
				'error' => $this->upload->display_errors()
			];

		}else{
			// $user = $this->fungsi->user_login();
			$name = $this->upload->data('file_name');
			@unlink('./assets/img/profile/'.$user->foto);
			// $id = $user->id_pengguna;
		
				return [
					'status' => 'success',
					'class' => 'success',
					'text' => $name
				];

		}

	}
	
	
    public function edit_img(){
		$config['upload_path'] = './assets/img/profile/';
		$config['allowed_types'] = 'gif|jpg|png';
		$config['encrypt_name'] = TRUE;
		$config['remove_spaces'] = TRUE;
		$config['max_size'] = 1500;

		$this->load->library('upload', $config);
		if(!$this->upload->do_upload('image')){
			return [
				'status' => 'error',
				'error' => $this->upload->display_errors()
			];
		}else{
			$user = $this->fungsi->user_login();
			$name = $this->upload->data('file_name');
			@unlink('./assets/img/profile/'.$user->foto);
			$id = $user->id_pengguna;

			$this->db->update('pengguna', ['foto' => $name], ['id_pengguna' => $id]);
			if($this->db->affected_rows() > 0){
				return [
					'status' => 'success',
					'class' => 'success',
					'text' => 'Foto berhasil dirubah'
				];
			}else{
				return [
					'status' => 'success',
					'class' => 'danger',
					'text' => 'Foto gagal dirubah'
				];
			}
		}
	}

	public function edit_pass(){
		$oldpass = $this->input->post('oldpass', true);
		$newpass = $this->input->post('newpass', true);

		$res = $this->db->get_where('pengguna', ['password' => sha1($oldpass)])->row_array();
		if(is_null($res)){
			return [
				'status' => 'error',
				'class' => 'danger',
				'text' => 'kata sandi anda salah'
			];
		}else{
			$data = [
				'password' => sha1($newpass)
			];
			$id = $this->fungsi->user_login()->id_pengguna;
			$this->db->update('pengguna', $data, ['id_pengguna' => $id]);
			return [
				'status' => 'success',
				'class' => 'success',
				'text' => 'Kata sandi berhasil diubah'
			];
		}
	}
}
