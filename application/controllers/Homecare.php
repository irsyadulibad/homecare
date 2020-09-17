<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Homecare extends CI_Controller {

  function __construct(){
    parent::__construct();
    $this->load->model('layanan_m');
    $this->load->model('pesanan_m');
  }
	public function index()
	{
    check_not_login();
    $id=$this->fungsi->user_login()->id_pengguna;
	$user = $this->fungsi->user_login();
    $data['row'] = $this->layanan_m->getrating();
    if($this->fungsi->user_login()->role == 1){
		$rating = $this->db->get('ulasan')->result_array();
		$data['rateaverage'] = 0;
		if(!is_null($rating)){
			$total = 0;
			$qty = 0;
			foreach($rating as $rate){
				$total += intval($rate['rating']);
				$qty++;
			}
			if($total == 0 && $qty == 0){
				$data['rateaverage'] = 0;
			}else{
				$data['rateaverage'] = number_format($total/$qty, 1, '.', '');
			}
			
		}
		$data['pesanan'] = $this->db->get('invoice')->num_rows();
		$data['pengguna'] = $this->db->get('pengguna')->num_rows();
		$data['paramedis'] = $this->db->get_where('pengguna', ['id_pengguna' => 2])->num_rows();
		
		$this->template->load('template2', 'dashboard/dashboard', $data);
  }else if($this->fungsi->user_login()->role == 2){
    $data['pending_invoice'] = $this->db->get_where('invoice', ['status' => 'pending'])->result_array();
    	$rating = $this->db->get_where('ulasan', ['id_medis' => $user->id_pengguna])->result_array();
		$data['rateaverage'] = 0;
		if(!is_null($rating)){
			$total = 0;
			$qty = 0;
			foreach($rating as $rate){
				$total += intval($rate['rating']);
				$qty++;
			}
			if($total == 0 && $qty == 0){
				$data['rateaverage'] = 0.0;
			}else{
				$data['rateaverage'] = number_format(intval($total)/intval($qty), 1, '.', '');
			}
		}
		$data['pesanan'] = $this->db->get_where('invoice', ['id_medis' => $user->id_pengguna])->num_rows();
		
		$this->template->load('template2', 'dashboard/dasmedis', $data);
  }else{
   		$data['pesanan'] = $this->db->get_where('invoice', ['id_pengguna' => $user->id_pengguna])->num_rows();
		$this->template->load('template2', 'dashboard/home', $data);
  }
}
	public function index2(){
		$user = $this->fungsi->user_login();
		$rating = $this->db->get_where('ulasan', ['id_medis' => $user->id_pengguna])->result_array();
		$data['rateaverage'] = 0;
		if(!is_null($rating)){
			$total = 0;
			$qty = 0;
			foreach($rating as $rate){
				$total += intval($rate['rating']);
				$qty++;
			}
			$data['rateaverage'] = number_format($total/$qty, 1, '.', '');
		}
		$data['pesanan'] = $this->db->get_where('invoice', ['id_medis' => $user->id_pengguna])->num_rows();
		
		$this->template->load('template2', 'dashboard/dasmedis2', $data);
	}
  public function admin(){
    check_admin();
    $this->template->load('template','dashboard/dashboard');

  }
	public function dummymail()
 {
  
  $config = array(
    'protocol' => 'smtp',
    'smtp_host' => 'ssl://smtp.gmail.com',
    'smtp_port' => 465,
    'smtp_user' => 'abangantos512@gmail.com',
    'smtp_pass' => '11224433',
    'mailtype'  => 'html', 
    'charset'   => 'iso-8859-1'
      );
  $this->load->library('email', $config);
  
  $this->email->set_newline("\r\n");
  
  $this->email->from($config['smtp_user']);
  $this->email->to('antosfery@gmail.com');

  $this->email->subject('Email Test');
  $this->email->message('Testing at home the email class of CodeIgniter.');

  if($this->email->send()) {
   echo 'Your email was sent.';
  } else {
   show_error($this->email->print_debugger());
  }
 }

}
