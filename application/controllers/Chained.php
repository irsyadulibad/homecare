<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Chained extends CI_Controller {

   public function __construct()
   {
      parent::__construct();
      $this->load->model('Daerah_m', 'model');
   }

   public function index()
   {
      $data['provinsi'] = $this->model->get_provinsi();
      $this->load->view('dropdown_chained', $data);
   }

   public function get_kota()
   {
      $provinsi = $this->input->get('provinsi', true);
      $kota = $this->model->get_kota($provinsi);
      $json = [];

      foreach($kota as $kt){
         $json[$kt->id_kota] = $kt->nama;
      }
      echo json_encode($json);
   }

   public function get_kecamatan()
   {
      $kota = $this->input->get('kota', true);
      $kecamatan = $this->model->get_kecamatan($kota);
      $json = [];

      foreach($kecamatan as $kec){
         $json[$kec->id] = $kec->nama;
      }
      echo json_encode($json);
   }

   public function get_desa()
   {
      $kecamatan = $this->input->get('kecamatan', true);
      $desa = $this->model->get_desa($kecamatan);
      $json = [];

      foreach($desa as $des){
         $json[$des->id] = $des->nama;
      }
      echo json_encode($json);
   }
}
