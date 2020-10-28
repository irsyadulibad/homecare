
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ulasan_m extends CI_Model {
  private $table = 'ulasan';

  public function get_by_average($limit, $offset){
    $this->db->select('inv.id_medis AS mid,
      ROUND(AVG(rvw.rating), 1) AS rating,
      mds.foto AS foto_medis,
      mds.nama_lengkap AS nama_medis');
    $this->db->from('ulasan as rvw');
    $this->db->join('invoice as inv', 'rvw.id_invoice = inv.id_invoice');
    $this->db->join('medis as mds', 'inv.id_medis = mds.id_medis');
    $this->db->group_by('inv.id_medis');
    $this->db->limit($limit, $offset);
    return $this->db->get()->result_array();
  }

  public function get_ulasan($id, $limit, $start, $rating){
    $this->db->select('usr.nama_lengkap AS nama_user,
      mds.nama_lengkap AS nama_medis,
      mds.foto AS foto_medis,
      rvw.rating, rvw.deskripsi, rvw.id_ulasan');
    $this->db->from('ulasan AS rvw');
    $this->db->join('invoice AS inv', 'inv.id_invoice = rvw.id_invoice');
    $this->db->join('medis AS mds', 'inv.id_medis = mds.id_medis');
    $this->db->join('pengguna AS usr', 'inv.id_pengguna = usr.id_pengguna');
    if($rating != 0) $this->db->where('rvw.rating', $rating);
    $this->db->where('inv.id_medis', intval($id));
    $this->db->limit($limit, $start);
    return $this->db->get()->result_array();
  }

  public function get_ulasan_byid($id){
    $this->db->select('usr.nama_lengkap AS nama_user,
      mds.nama_lengkap AS nama_medis,
      mds.foto AS foto_medis,
      rvw.rating, rvw.deskripsi, rvw.id_ulasan, rvw.id_invoice,
      inv.id_pengguna');
    $this->db->from('ulasan as rvw');
    $this->db->join('invoice as inv', 'rvw.id_invoice = inv.id_invoice');
    $this->db->join('medis as mds', 'inv.id_medis = mds.id_medis');
    $this->db->join('pengguna as usr', 'inv.id_pengguna = usr.id_pengguna');
    $this->db->where('rvw.id_ulasan', $id);
    return $this->db->get()->row_array();
  }

  public function get_average_all(){
    $this->db->select('ROUND(AVG(rating), 1) AS average');
    $avg = $this->db->get('ulasan')->row_array()['average'];
    return is_null($avg) ? 0 : $avg;
  }

  public function get_average_by_medic($id){
    $this->db->select('ROUND(AVG(ulasan.rating), 1) AS average');
    $this->db->from('ulasan');
    $this->db->join('invoice', 'ulasan.id_invoice = invoice.id_invoice');
    $this->db->where('invoice.id_medis', $id);
    $avg = $this->db->get()->row_array()['average'];
    return is_null($avg) ? 0 : $avg;
  }

  public function num_rows($id, $rating=0){
    if($rating != 0) $this->db->where('rvw.rating', $rating);
    $this->db->from('ulasan as rvw');
    $this->db->join('invoice as inv', 'inv.id_invoice = rvw.id_invoice');
    $this->db->where('inv.id_medis', $id);
    return $this->db->get()->num_rows();
  }

  public function num_rows_avg(){
    $this->db->from('ulasan as rvw');
    $this->db->join('invoice as inv', 'rvw.id_invoice = inv.id_invoice');
    $this->db->group_by('inv.id_medis');
    return $this->db->get()->num_rows();
  }

  public function tambah_ulasan($riwayat){
    $rating = $this->input->post('rating', true);
    $descript = $this->input->post('description', true);
    $user = $this->fungsi->get_user($riwayat['id_pengguna']);

    $data = [
      'id_pengguna' => $riwayat['id_pengguna'],
      'id_medis' => $riwayat['id_medis'],
      'time' => date('Y-m-d H:i:s'),
      'rating' => $rating,
      'deskripsi' => $descript,
      'nama' => $user->nama_lengkap
    ];

    $this->db->insert('ulasan', $data);
    $id_ulasan = $this->db->insert_id();
    $this->db->update('riwayat', ['review' => $id_ulasan], ['id_riwayat' => $riwayat['id_riwayat']]);
    return $this->db->affected_rows();
  }

  public function edit($id){
    $rating = $this->input->post('rating', true);
    $deskrip = $this->input->post('description', true);
    $data = [
      'rating' => $rating,
      'deskripsi' => $deskrip
    ];

    $this->db->update('ulasan', $data, ['id_ulasan' => $id]);
    if($this->db->affected_rows() > 0){
      return [
        'type' => 'success',
        'msg' => 'Ulasan berhasil diedit'
      ];
    }else{
      return [
        'type' => 'error',
        'msg' => 'Ulasan gagal diedit'
      ];
    }
  }

  public function paginate($id, $per_page, $rating){
    $this->load->library('pagination');
    $config['base_url'] = base_url('ulasan/list/'.$id);
    $config['total_rows'] = $this->num_rows($id, $rating);
    $config['suffix'] = "?rating=$rating";
    $config['per_page'] = $per_page;
    $config['uri_segment'] = 3;
    $config['num_links'] = 2;
    $config['first_link'] = false;
    $config['last_link'] = false;
        // Styling
    $config['attributes'] = array('class' => 'page-link');
    $config['full_tag_open'] = '<nav aria-label="Page navigation example" class="m-auto"><ul class="pagination justify-content-center">';
    $config['full_tag_close'] = '</ul></nav>';

    $config['next_link'] = '&raquo';
    $config['next_tag_open'] = '<li class="page-item">';
    $config['next_tag_close'] = '</li>';

    $config['prev_link'] = '&laquo';
    $config['prev_tag_open'] = '<li class="page-item">';
    $config['prev_tag_close'] = '</li>';

    $config['num_tag_open'] = '<li class="page-item">';
    $config['num_tag_close'] = '</li>';

    $config['cur_tag_open'] = '<li class="page-item active" aria-current="page"><a class="page-link" href="#">';
    $config['cur_tag_close'] = '</a></li>';

    $this->pagination->initialize($config);
  }

  public function paginate_avg($per_page){
    $this->load->library('pagination');
    $config['base_url'] = base_url('ulasan/index');
    $config['total_rows'] = $this->num_rows_avg();
    $config['per_page'] = $per_page;
    $config['uri_segment'] = 3;
    $config['num_links'] = 2;
    $config['first_link'] = false;
    $config['last_link'] = false;
        // Styling
    $config['attributes'] = array('class' => 'page-link');
    $config['full_tag_open'] = '<nav aria-label="Page navigation example" class="m-auto"><ul class="pagination justify-content-center">';
    $config['full_tag_close'] = '</ul></nav>';

    $config['next_link'] = '&raquo';
    $config['next_tag_open'] = '<li class="page-item">';
    $config['next_tag_close'] = '</li>';

    $config['prev_link'] = '&laquo';
    $config['prev_tag_open'] = '<li class="page-item">';
    $config['prev_tag_close'] = '</li>';

    $config['num_tag_open'] = '<li class="page-item">';
    $config['num_tag_close'] = '</li>';

    $config['cur_tag_open'] = '<li class="page-item active" aria-current="page"><a class="page-link" href="#">';
    $config['cur_tag_close'] = '</a></li>';

    $this->pagination->initialize($config);
  }
}
