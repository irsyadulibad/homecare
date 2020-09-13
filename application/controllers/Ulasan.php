<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ulasan extends CI_Controller {
    function __construct(){
        parent::__construct();
        $this->load->model('ulasan_m');
		check_not_login();
        $this->load->library('form_validation');
    }
	public function index($start=0)
	{
		$rating = intval($this->input->get('rating', true));
		$per_page = 6;
		/* Pagination */
		$this->ulasan_m->paginate($per_page, $rating);

		$user = $this->fungsi->user_login();
		$data['reviews'] = $this->ulasan_m->get_ulasan($per_page, $start, $rating);
		$data['head'] = "Daftar Ulasan";
		$this->template->load('template2', 'ulasan/daftarulasan', $data);
    }
    public function tambah($id = null){
    	$user = $this->fungsi->user_login();
    	$data['riwayat'] = $this->db->get_where('riwayat', ['id_riwayat' => $id])->row_array();
    	if(is_null($data['riwayat']) || $data['riwayat']['id_pengguna'] != $user->id_pengguna) redirect('riwayat');
    	if(!is_null($data['riwayat']['review'])) redirect('ulasan');

		$this->form_validation->set_rules('rating', 'Rating', 'required');
		$this->form_validation->set_rules('description', 'Deskripsi','required');

		$this->form_validation->set_message('required', '%s Masih Kosong, Silahkan Diisi');

		if ($this->form_validation->run() == FALSE) {
			$this->template->load('template2','ulasan/tambahulasan', $data);
		}else{
			$res = $this->ulasan_m->tambah_ulasan($data['riwayat']);
			if($res>0){
				$this->session->set_flashdata('swal', ['type' => 'success', 'msg' => 'Berhasil menambahkan ulasan']);
				redirect('ulasan');
			}else{
				$this->session->set_flashdata('swal', ['type' => 'danger', 'msg' => 'Gagal menambahkan']);
				redirect('riwayat');
			}
		}

    }
    public function detail($id=null){
    	if(is_null($id)) redirect('ulasan');
    	$data['pengguna'] = $this->fungsi->user_login();
    	$data['ulasan'] = $this->ulasan_m->get_ulasan_byid($id);
    	if(is_null($data['ulasan'])) redirect('ulasan');
    	$data['pesanan'] = $this->ulasan_m->get_pesanan($data['ulasan']['id_invoice']);
		$data['head'] = "Detail Ulasan";
    	$this->template->load('template2', 'ulasan/detailulasan', $data);
    }
	public function edit($id=null){
		if(is_null($id)) redirect('ulasan');
		$user = $this->fungsi->user_login();
		$data['ulasan'] = $this->db->get_where('ulasan', ['id_ulasan' => $id])->row_array();
		if(is_null($data['ulasan']) || $data['ulasan']['id_pengguna'] != $user->id_pengguna) redirect('ulasan');

		$this->form_validation->set_rules('rating', 'Rating', 'required');
		$this->form_validation->set_rules('description', 'Deskripsi','required');
		$this->form_validation->set_message('required', '%s Masih Kosong, Silahkan Diisi');

		if($this->form_validation->run() == FALSE){
			$this->template->load('template2', 'ulasan/editulasan', $data);
		}else{
			if($this->ulasan_m->edit($id)>0){
				$this->session->set_flashdata('swal', ['type' => 'success', 'msg' => 'Berhasil mengubah data']);
				redirect("ulasan/detail/$id");
			}else{
				$this->session->set_flashdata('swal', ['type' => 'danger', 'msg' => 'Gagal mengubah data']);
				redirect("ulasan/detail/$id");
			}
		}
	}
	
}
