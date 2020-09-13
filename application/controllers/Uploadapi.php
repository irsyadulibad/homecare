<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Uploadapi extends CI_Controller{
	public function __construct(){
		parent::__construct();
		$this->load->model('Profile_m', 'profile_m');
	}
	public function editapi(){
		$idusr = $this->input->post('idusr');
		if($_FILES['image']){
			$res = $this->profile_m->edit_imgapi($idusr);
			if($res['status'] == "error"){
				// $this->session->set_flashdata('msg-edit-img', [
				// 	'class' => 'danger',
				// 	'text' => $res['error']
				// ]);
				$data['message'] = "gagal";
				echo(json_encode($data));
			}else{
				// $this->session->set_flashdata('msg-edit-img', [
				// 	'class' => $res['class'],
				// 	'text' => $res['text']
				// ]);
				$data['message'] = $res['text'];
				echo(json_encode($data));
			}
		}
	}
	
	public function fotokondisi()
	{
		if($_FILES['kondisi']){
			$config['upload_path'] = './assets/img/kondisi/';
			$config['allowed_types'] = 'gif|jpg|png';
			$config['encrypt_name'] = TRUE;
			$config['remove_spaces'] = TRUE;
			$config['max_size'] = 3000;

			$this->load->library('upload', $config);
			if(!$this->upload->do_upload('kondisi')){
				$namepic = 'default.jpg';
				$data['status'] = false;
				$data['message'] = "default.jpg";
				echo(json_encode($data));
			}else{
				$namepic = $this->upload->data('file_name');
				$data['status'] = true;
				$data['message'] = $namepic;
				echo(json_encode($data));
			}
	
		}  
	}
    
}
