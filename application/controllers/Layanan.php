<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Layanan extends CI_Controller {


    function __construct(){
        parent::__construct();
        $this->load->model('layanan_m');
		check_not_login();
		check_admin();
        $this->load->library('form_validation');
    }
	public function index()
	{
		$data ['layanans'] = $this->layanan_m->getlay()->result_array();
        if($this->session->userdata('role') == 1){
        $this->template->load('template2','layanan/jenislayanan', $data);
        }else{
			$this->session->set_flashdata('swal', ['type' => 'error', 'msg' => 'Khusus untuk admin']);
			redirect('homecare');
		}
    }
    public function add(){

		$this->form_validation->set_rules('jenis_layanan', 'Jenis Layanan', 'required');
		$this->form_validation->set_rules('harga', 'Harga', 'required|numeric');

		$this->form_validation->set_message('required', '%s Masih Kosong, Silahkan Diisi');

		if ($this->form_validation->run() == FALSE)
		{
			$data['head'] = "Tambah Layanan";
			$this->template->load('template2','layanan/tambah_layanan', $data);
		}
		else
		{
			$post = $this->input->post(null, TRUE);
			$this->layanan_m->addlay($post);
			if($this->db->affected_rows() > 0 ){
				$this->session->set_flashdata('swal', ['type' => 'success', 'msg' => 'Data berhasil ditambahkan']);
			}else{
				$this->session->set_flashdata('swal', ['type' => 'error', 'msg' => 'Data gagal ditambahkan']);
			}
				redirect('layanan');
		}

    }
    public function update($id){
		$this->form_validation->set_rules('jenis_layanan', 'Jenis Layanan', 'required');
		$this->form_validation->set_rules('harga', 'Harga', 'required|numeric');

		$this->form_validation->set_message('required', '%s Masih Kosong, Silahkan Diisi');

		if ($this->form_validation->run() == FALSE)
		{
			$query = $this->layanan_m->getlay($id);
			if($query->num_rows() > 0){
				$data ['layanan'] = $query->row_array();
				$this->template->load('template2','layanan/edit_layanan', $data);
			}else {
			$this->session->set_flashdata('swal', ['type' => 'error', 'msg' => 'Data tidak ditemukan']);
			redirect('layanan');
			}
		}
		else
		{
			$post = $this->input->post(null, TRUE);
			$this->layanan_m->edit($post, $id);
			if($this->db->affected_rows() > 0 ){
				$this->session->set_flashdata('swal', ['type' => 'success', 'msg' => 'Data berhasil diubah']);
			}else{
				$this->session->set_flashdata('swal', ['type' => 'error', 'msg' => 'Data gagal diubah']);
			}
				redirect('layanan');
		}

	}
	
    public function dellay($id=null){
		if(is_null($id)) redirect('layanan');
		$this->layanan_m->dellay($id);

		if($this->db->affected_rows() > 0 ){
			$this->session->set_flashdata('swal', ['type' => 'success', 'msg' => 'Data berhasil dihapus']);
		}else{
			$this->session->set_flashdata('swal', ['type' => 'error', 'msg' => 'Data gagal dihapus']);
		}
			redirect('layanan');
	}
	
}
