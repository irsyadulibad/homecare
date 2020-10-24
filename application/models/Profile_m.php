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
		$data = [
			'id_provinsi' => $this->input->post('provinsi', true),
			'id_kabupaten' => $this->input->post('kabupaten', true),
			'id_kecamatan' => $this->input->post('kecamatan', true),
			'id_desa' => $this->input->post('desa', true),
			'alamat' => $this->input->post('alamat', true),
		];

		$geo = $this->getLatLong($data['id_provinsi'], $data['id_kabupaten'], $data['id_kecamatan'], $data['id_desa']);

		if(!$geo['status']){
			return [
				'type' => 'error',
				'msg' => $geo['msg']
			];
		}else{
			$data['latitude'] = $geo['data'][0]['lat'];
			$data['longtitude'] = $geo['data'][0]['lon'];
		}

		$this->do_edit($user, $data);

		return [
			'type' => 'success',
			'msg' => 'Alamat berhasil diubah'
		];
	}

	private function do_edit($user, $data){
		$id = $user['id_alamat'];

		// Mendapatkan status dan user id
		if($user['status'] == 'admin' || $user['status'] == 'user'){
			$status = 'user';
			$uid = $user['id_pengguna'];
		}else{
			$status = 'medis';
			$uid = $user['id_medis'];
		}

		// Jika id_alamat pada tabel tidak bernilai null
		// Langsung update data pada tabel alamat_pengguna
		if(!is_null($user['id_alamat'])){
			$this->db->update('alamat_pengguna', $data, [
				'id_alamat' => $id
			]);
		// Menambah data pada tabel alamat dan mengupdate field pada tabel user
		}else{
			$aid = $this->alamat_m->max_id() + 1;
			$data['id_alamat'] = $aid;

			$this->db->insert('alamat_pengguna', $data);

			// Menimpa var data agar bernilai id_alamat saja
			$data = [
				'id_alamat' => $aid
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

		return true;
	}

	public function getLatLong($prov, $kab, $kec, $des){
		$prov = $this->daerah_m->get_provinsi($prov)['nama'];
		$kab = $this->daerah_m->kabupaten($kab)['nama'];
		$kec = $this->daerah_m->kecamatan($kec)['nama'];
		$des = $this->daerah_m->desa($des)['nama'];
		$kab = str_replace('KABUPATEN', '', $kab);

		$alamat = "$des-$kec-$kab-$prov-INDONESIA";
		$geo = $this->alamat_m->get_geocode($alamat);

		if(!$geo['status']){
			return [
				'status' => false,
				'msg' => $geo['msg']
			];
		}else{
			return [
				'status' => true,
				'data' => $geo['data']
			];
		}

	}
}
