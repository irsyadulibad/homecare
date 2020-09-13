<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dropdown_chained_model extends CI_Model {

   public function get_provinsi()
   {
      $this->db->order_by('nama','ASC');
      $get = $this->db->get('dd_provinsi');
      return $get;
   }

   public function get_kota($provinsi)
   {
      $this->db->where('id_provinsi', $provinsi);
      $get = $this->db->get('dd_kota');
      return $get;
   }

   public function get_kecamatan($kota)
   {
      $this->db->where('id_kota', $kota);
      $get = $this->db->get('dd_kecamatan');
      return $get;
   }

   public function get_desa($kecamatan)
   {
      $this->db->where('id_kecamatan', $kecamatan);
      $get = $this->db->get('dd_desa');
      return $get;
   }
}

/* End of file Dropdown_chained.php */
/* Location: ./application/models/Dropdown_chained.php */