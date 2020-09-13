<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

	function __construct(){
		parent::__construct();
		check_not_login();
		check_admin();
		$this->load->model('user_m');
		$this->load->library('form_validation');


	}
	public function index()
	{
		$data ['users'] = $this->user_m->get()->result_array();
		$data['head'] = "Daftar Pengguna";
		$this->template->load('template2','user/user_data', $data);
		
	}
	public function medis(){
		$data ['users'] = $this->user_m->getmedis()->result_array();
		$this->template->load('template2','user/usermedis', $data);
	}
	public function pengguna(){
		$data ['users'] = $this->user_m->getpengguna()->result_array();
		$this->template->load('template2','user/pengguna', $data);
	}
	public function add(){

		$this->form_validation->set_rules('fullname', 'Nama', 'required');
		$this->form_validation->set_rules('email', 'Email', 'required|is_unique[pengguna.email]');
		$this->form_validation->set_rules('username', 'Username', 'required|is_unique[pengguna.nama_pengguna]');
		$this->form_validation->set_rules('nohp', 'No. HP', 'required|min_length[10]');
		$this->form_validation->set_rules('password', 'Password', 'required');
		$this->form_validation->set_rules('passconf', 'Konfirmasi Password', 'required|matches[password]',
		array(
			'matches' => '%s. Tidak Sesuai Dengan Password')
		);
		$this->form_validation->set_rules('level', 'Level', 'required');

		$this->form_validation->set_message('required', '%s Masih Kosong, Silahkan Diisi');
		$this->form_validation->set_message('min_lenght', '{field} Silahkan Isi Lebih Dari Minimal');
		$this->form_validation->set_message('is_unique', '{field} Ini Sudah Dipakai');



		if ($this->form_validation->run() == FALSE)
		{
			$this->template->load('template2','user/add_user');
		}
		else
		{
			$post = $this->input->post(null, TRUE);
			$this->user_m->add($post);
			if($this->db->affected_rows() > 0 ){
				$this->session->set_flashdata('swal', ['type' => 'success', 'msg' => 'Pengguna berhasil ditambahkan']);
			}else{
				$this->session->set_flashdata('swal', ['type' => 'error', 'msg' => 'Pengguna gagal ditambahkan']);
			}
			redirect('user');
		}

	}
	public function edit($id){

		$this->form_validation->set_rules('fullname', 'Nama', 'required');
		$this->form_validation->set_rules('email', 'Email', 'required|callback_email_check');
		$this->form_validation->set_rules('username', 'Username', 'required|callback_username_check');
		if($this->input->post('password')){
		$this->form_validation->set_rules('password', 'Password', '');
		$this->form_validation->set_rules('passconf', 'Password Confirmation', 'matches[password]',
		array(
			'matches' => '%s. Tidak Sesuai Dengan Password')
		);
	}
	if($this->input->post('passconf')){
		$this->form_validation->set_rules('passconf', 'Password Confirmation', 'required|matches[password]',
		array(
			'matches' => '%s. Tidak Sesuai Dengan Password')
		);
	}
		$this->form_validation->set_rules('level', 'Level', 'required');

		$this->form_validation->set_message('required', '%s Masih Kosong, Silahkan Diisi');
		$this->form_validation->set_message('min_lenght', '{field} Silahkan Isi Lebih Dari Minimal');
		$this->form_validation->set_message('is_unique', '{field} Ini Sudah Dipakai');



		if ($this->form_validation->run() == FALSE)
		{
			$query = $this->user_m->get($id)->row_array();
			if(!is_null($query)){
				$data ['user'] = $query;
				$data['head'] = "Edit Akun Pengguna";
				$this->template->load('template2','user/user_edit', $data);
			}else {
			echo "<script> alert('data tidak ditemukan disimpan');";
			echo " window.location='".site_url('user')."';</script>";
			}
		}
		else
		{
			$post = $this->input->post(null, TRUE);
			$this->user_m->edit($post, $id);
			if($this->db->affected_rows() > 0 ){
				$this->session->set_flashdata('swal', ['type' => 'success', 'msg' => 'Data berhasil disimpan']);
			}else{
				$this->session->set_flashdata('swal', ['type' => 'error', 'msg' => 'Data gagal disimpan']);
			}
				$prev =  $this->input->post('prev', true);
				redirect("user/$prev");
		}

	}
	function username_check(){
		$post = $this->input->post(null, TRUE);
		$query= $this->db->query("SELECT * FROM pengguna WHERE nama_pengguna = '$post[username]' AND id_pengguna != '$post[user_id]'");
		if($query->num_rows() > 0){
			$this->form_validation->set_message('username_check', '{field} user ini Sudah Dipakai');
			return FALSE;
		}else {
			return TRUE;
		}
	}
	function email_check(){
		$post = $this->input->post(null, TRUE);
		$query= $this->db->query("SELECT * FROM pengguna WHERE email = '$post[email]' AND id_pengguna != '$post[user_id]'");
		if($query->num_rows() > 0){
			$this->form_validation->set_message('email_check', '{field} Email ini Sudah Dipakai');
			return FALSE;
		}else {
			return TRUE;
		}
	}
	public function del($id=null){
		$user = $this->fungsi->user_login();
		$prev = $this->input->get('prev', true);
		if(is_null($id) || $user->role != 1) redirect('user');
		$this->db->delete('pengguna', ['id_pengguna' => $id]);
		if($this->db->affected_rows() > 0){
			$this->session->set_flashdata('swal', ['type' => 'success', 'msg' => 'Pengguna berhasil dihapus']);
			redirect("user/$prev");
		}else{
			$this->session->set_flashdata('swal', ['type' => 'error', 'msg' => 'Pengguna gagal dihapus']);
			redirect("user/$prev");
		}
	}
	public function profile(){
		$data ['row'] = $this->user_m->get();
		$this->template->load('template','user/profile',$data);
	}
}
