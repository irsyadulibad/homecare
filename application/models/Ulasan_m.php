
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ulasan_m extends CI_Model {
  public function get_average($limit, $start){
    $this->db->select('ulasan.id_medis as mid, ROUND(AVG(ulasan.rating),1) AS rating, pengguna.foto as foto_medis, pengguna.nama_lengkap as nama_medis');
    $this->db->from('ulasan');
    $this->db->join('pengguna', 'pengguna.id_pengguna = ulasan.id_medis');
    $this->db->group_by('id_medis');
    $this->db->limit($limit, $start);
    return $this->db->get()->result_array();
  }

  public function get_ulasan($id, $limit, $start, $rating){
    $this->db->select('user.nama_lengkap AS nama_user, medis.nama_lengkap AS nama_medis, medis.foto AS foto_medis, rating, deskripsi, id_ulasan');
    $this->db->from('ulasan');
    $this->db->join('pengguna as user', 'user.id_pengguna = ulasan.id_pengguna');
    $this->db->join('pengguna as medis', 'medis.id_pengguna = ulasan.id_medis');
    if($rating != 0) $this->db->where('ulasan.rating', $rating);
    $this->db->where('ulasan.id_medis', intval($id));
    $this->db->limit($limit, $start);
    return $this->db->get()->result_array();
  }

  public function get_ulasan_byid($id){
    $this->db->select('user.nama_lengkap AS nama_user, medis.nama_lengkap AS nama_medis, medis.foto AS foto_medis, rating, deskripsi, id_ulasan, id_invoice, ulasan.id_pengguna');
    $this->db->from('ulasan');
    $this->db->join('pengguna as user', 'user.id_pengguna = ulasan.id_pengguna');
    $this->db->join('pengguna as medis', 'medis.id_pengguna = ulasan.id_medis');
    $this->db->where('id_ulasan', $id);
    return $this->db->get()->row_array();
  }

  public function num_rows($id, $rating=0){
    if($rating != 0) $this->db->where('rating', $rating);
    $this->db->where('id_medis', $id);
    return $this->db->get('ulasan')->num_rows();
  }

  public function num_rows_avg(){
    $this->db->group_by('id_medis');
    return $this->db->get('ulasan')->num_rows();
  }

  public function get_pesanan($id){
    return $this->db->get_where('pesanan', ['id_invoice' => $id])->result_array();
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
    return $this->db->affected_rows();
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
