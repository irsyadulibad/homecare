<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Chained extends CI_Controller {

   public function __construct()
   {
      parent::__construct();
      $this->load->model('daerah_m');
   }

   public function index()
   {
      $data['provinsi'] = $this->daerah_m->get_provinsi();
      $this->load->view('dropdown_chained', $data);
   }

   public function get_kabupaten()
   {
      $provinsi = $this->input->get('provinsi', true);
      $kabupaten = $this->daerah_m->get_kabupaten($provinsi);
      $json = [];

      foreach($kabupaten as $kt){
         $json[$kt['id_kabupaten']] = $kt['nama'];
      }
      echo json_encode($json);
   }

   public function get_kecamatan()
   {
      $kabupaten = $this->input->get('kabupaten', true);
      $kecamatan = $this->daerah_m->get_kecamatan($kabupaten);
      $json = [];

      foreach($kecamatan as $kec){
         $json[$kec['id_kecamatan']] = $kec['nama'];
      }
      echo json_encode($json);
   }

   public function get_desa()
   {
      $kecamatan = $this->input->get('kecamatan', true);
      $desa = $this->daerah_m->get_desa($kecamatan);
      $json = [];

      foreach($desa as $des){
         $json[$des['id_desa']] = $des['nama'];
      }
      echo json_encode($json);
   }
}
