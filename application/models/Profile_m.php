<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Profile_m extends CI_Model{
	public function edit($user){
		$status = $user['status'];
		$image = $user['foto'];

		if(isset($_FILES['image']) && $_FILES['image']['name'] != ''){
			$upload = $this->upload_img($user);

			if(!$upload['status']){
				return [
					'type' => 'error',
					'msg' => $upload['error']
				];
			}else{
				$image = $upload['name'];
			}
		}

		$data = [
			'nama_lengkap' => $this->input->post('fullname', true),
			'no_hp' => $this->input->post('phone', true),
			'jenis_kelamin' => $this->input->post('gender', true),
			'email' => $this->input->post('email', true),
			'foto' => $image
		];

		if($status == 'admin' || $status == 'user'){
			$id = $user['id_pengguna'];
			$this->db->update('pengguna', $data, ['id_pengguna' => $id]);
		}else{
			$id = $user['id_medis'];
			$this->db->update('medis', $data, ['id_medis' => $id]);
		}

		return [
			'type' => 'success',
			'msg' => 'Data berhasil disimpan'
		];
	}

	public function upload_img($user){
		$config['upload_path'] = './assets/img/profile/';
		$config['allowed_types'] = 'gif|jpg|png';
		$config['encrypt_name'] = TRUE;
		$config['remove_spaces'] = TRUE;
		$config['max_size'] = 1500;

		$this->load->library('upload', $config);
		if(!$this->upload->do_upload('image')){
			return [
				'status' => false,
				'error' => $this->upload->display_errors()
			];
		}else{
			$name = $this->upload->data('file_name');
			$oldPict = $user['foto'];

			if($oldPict != 'default.jpg') @unlink('./assets/img/profile/'.$user['foto']);

			return [
				'status' => true,
				'name' => $name
			];
		}
	}

	public function editpass($user){
		$this->load->model('user_m');
		$this->load->model('medis_m');
		$oldpass = $this->input->post('old-pass', true);
		$newpass = $this->input->post('new-pass', true);
		// $user = $this->user_m->login($user['email'], $oldpass);

		if($user['status'] == 'admin' || $user['status'] == 'user'){
			$user = $this->user_m->login($user['email'], $oldpass);
			$status = 'user';
		}else{
			$user = $this->medis_m->login($user['email'], $oldpass);
			$status = 'medis';
		}

		if(is_null($user)){
			return [
				'type' => 'error',
				'msg' => 'Password yang anda masukan anda salah'
			];
		}

		$data = [
			'password' => sha1($newpass)
		];

		if($status == 'user'){
			$this->db->update('pengguna', $data, ['id_pengguna' => $user['id_pengguna']]);
		}else{
			$this->db->update('pengguna', $data, ['id_medis' => $user['id_medis']]);
		}

		return [
			'type' => 'success',
			'msg' => 'Password berhasil diubah'
		];
	}

	public function editaddr($user){
		$id = $user['id_alamat'];
		if($user['status'] == 'admin' || $user['status'] == 'user'){
			$status = 'user';
			$uid = $user['id_pengguna'];
		}else{
			$status = 'medis';
			$uid = $user['id_medis'];
		}

		$data = [
			'id_alamat' => $uid + 50,
			'id_provinsi' => $this->input->post('provinsi', true),
			'id_kabupaten' => $this->input->post('kabupaten', true),
			'id_kecamatan' => $this->input->post('kecamatan', true),
			'id_desa' => $this->input->post('desa', true),
			'alamat' => $this->input->post('alamat', true),
		];

		if(!is_null($user['id_alamat'])){
			$this->db->update('alamat_pengguna', $data, [
				'id_alamat' => $id
			]);
		}else{
			$this->db->insert('alamat_pengguna', $data);

			$data = [
				'id_alamat' => $uid + 50
			];

			if($status == 'user'){
				$this->db->update('pengguna', $data, [
					'id_pengguna' => $uid
				]);
			}else{
				$this->db->update('medis', $data, [
					'id_medis' => $uid
				]);
			}

		}
		echo $this->db->last_query();
		return [
			'type' => 'success',
			'msg' => 'Alamat berhasil diubah'
		];
	}
}
