<?php
class Pesanan extends CI_Controller{
    function __construct(){
        parent::__construct();
        check_not_login();
        $this->load->model('pesanan_m');
        $this->load->model('layanan_m');
        $this->load->model('pasien_m');
        $this->load->model('user_m');
        $this->load->model('obat_m');

        $this->load->model('dropdown_chained_model','model');
    }
    public function index(){
      $role = $this->fungsi->user_login()->role;
      if($role == 1) redirect('invoice');
      if($role == 2) redirect('pesanan/dimedis');
      if($role == 4) redirect('pesanan/dimedis');
      if($role == 3) redirect('pesanan/diuser');
    }
    public function diuser()
    {
         $id = $this->fungsi->user_login()->id_pengguna;
         $data ['pesanans'] = $this->pesanan_m->getpesuser($id);
         if($this->session->userdata('role') == 3 ){
         $this->template->load('template2','pesanan/pesananuser', $data);
         }else{
			$this->session->set_flashdata('swal', ['type' => 'warning', 'msg' => 'Anda tidak dapat mengakses halaman ini']);
			redirect('homecare');
		}
     }
    public function dimedis(){
      $id = $this->fungsi->user_login()->id_pengguna;
      $data ['pesanans'] = $this->pesanan_m->getpesmed($id);
      if($this->session->userdata('role') == 2 ){
      $this->template->load('template2','pesanan/pesanandimedis', $data);
      }      elseif($this->session->userdata('role') == 4 ){
        $this->template->load('template2','pesanan/pesanandimedis', $data);
      }
      else{
		$this->session->set_flashdata('swal', ['type' => 'warning', 'msg' => 'Anda tidak dapat mengakses halaman ini']);
		redirect('homecare');
	  }
    }
    public function detail($id_invoice = null){
      if(is_null($id_invoice)) redirect('pesanan/dimedis');
      $this->load->model('model_invoice');
      $data['invoice'] = $this->model_invoice->ambil_id_invoice($id_invoice);
      $data['pesanan'] = $this->model_invoice->ambil_id_pesanan($id_invoice);
      $data['medis'] = $this->db->get_where('pengguna', ['id_pengguna' => $data['invoice']->id_medis])->row_array();
      if($data['invoice']->id_medis != $data['medis']['id_pengguna']) redirect();
      $this->template->load('template','pesanan/detailpesanan',$data);
    }
    public function selesai($id_invoice=null){
      if(is_null($id_invoice)) redirect('pesanan/dimedis');

      $this->load->model('model_invoice');
      $data['invoice'] = $this->model_invoice->ambil_id_invoice($id_invoice);
      $data['pesanan'] = $this->model_invoice->ambil_id_pesanan($id_invoice);
      $data['obat'] = $this->model_invoice->ambil_id_obat($id_invoice);
      $data['medis'] = $this->db->get_where('pengguna', ['id_pengguna' => $data['invoice']->id_medis])->row_array();
      $this->form_validation->set_rules('biaya_lainnya', 'required', ['required' => 'harus diisi']);
      if($this->form_validation->run() == FALSE){
        $this->template->load('template2','pesanan/pesananselesai',$data);
      }else{
        $res = $this->pesanan_m->selesaikan($id_invoice, $data['invoice']->total);
        if($res > 0){
          $this->session->set_flashdata('swal', ['type' => 'success', 'msg' => 'Silahkan mengkonfirmasi pembayaran']);
			redirect('pembayaran');
        }else{
          $this->session->set_flashdata('swal', ['type' => 'danger', 'msg' => 'Gagal']);
			redirect('pesanan/dimedis');
        }
      }
    }
   public function terima($id){
      $data['user'] = $this->user_m->getmedis();
		$this->form_validation->set_rules('status', 'status', 'required');

		if ($this->form_validation->run() == FALSE)
		{
			$query = $this->pesanan_m->getpes($id);
			if($query->num_rows() > 0){
				$data ['row'] = $query->row();
				$this->template->load('template','pesanan/diterimamedis', $data);
			}else {
			echo "<script> alert('data tidak ditemukan disimpan');";
			echo " window.location='".site_url('pesanan')."';</script>";   
			}
		}
		else
		{

			$post = $this->input->post(null, TRUE);
			$this->pesanan_m->diterima($post);
			if($this->db->affected_rows() > 0 ){
				echo "<script> alert('data berhasil disimpan');</script>";
			}
				echo "<script> window.location='".site_url('pesanan/dimedis')."';</script>";
		}

	}
	
    public function batal($id = null){
		$user = $this->fungsi->user_login();
		if(is_null($id)) redirect('pesanan');
		$prev = $this->input->get('prev', true);
		$pesanan = $this->db->get_where('invoice', ['id_invoice' => $id])->row_array();
		if($user->role == 2){
			if(is_null($pesanan) || $pesanan['id_medis'] != $user->id_pengguna) redirect('pesanan');
			$this->db->update('invoice', ['status' => 'pending', 'id_medis' => null, 'biaya_lain' => null], ['id_invoice' => $pesanan['id_invoice']]);
			if($this->db->affected_rows() > 0){
          		$this->session->set_flashdata('swal', ['type' => 'success', 'msg' => 'Pesanan berhasil dibatalkan']);
				redirect("pesanan/$prev");
        	}else{
          		$this->session->set_flashdata('swal', ['type' => 'error', 'msg' => 'Pesanan gagal dibatalkan']);
				redirect("pesanan/$prev");
          }
          
		}else{
			if(is_null($pesanan) || $pesanan['id_pengguna'] != $user->id_pengguna) redirect('pesanan');
			$this->db->delete('invoice', ['id_invoice' => $pesanan['id_invoice']]);
      $this->pesanan_m->delKondisi($pesanan['kondisi']);
      $this->pesanan_m->manageObat($pesanan['id_invoice']);
			$this->db->delete('pesanan', ['id_invoice' => $pesanan['id_invoice']]);
			if($this->db->affected_rows() > 0){
          		$this->session->set_flashdata('swal', ['type' => 'success', 'msg' => 'Pesanan berhasil dibatalkan']);
				redirect("pesanan/$prev");
        	}else{
          		$this->session->set_flashdata('swal', ['type' => 'error', 'msg' => 'Pesanan gagal dibatalkan']);
				redirect("pesanan/$prev");
        	}
		}
  }

  public function tambah_obat($id=null){
    if(is_null($id)) redirect('pesanan');

    if(!isset($_POST['obat'])){
      $data['invoice'] = $this->db->get_where('invoice', ['id_invoice' => $id])->row_array();
      $data['layanans'] = $this->pesanan_m->get_layanan($id);
      $data['obats'] = $this->db->get('obat')->result_array();
      $data['carts'] = $this->session->userdata('obat');
      if(is_null($data['invoice'])) redirect('pesanan');
      $data['head'] = 'Tambah Obat';
      $this->template->load('template2', 'pesanan/tambahobat', $data);
    }else{
      $obat = intval($this->input->post('obat', true));
      $qty = intval($this->input->post('qty', true));
      

      if($obat == 0 || $qty == 0){
        echo json_encode(['status' => 'error', 'msg' => 'Obat atau jumlah belum diisi']);
      }else{
        $res = $this->pesanan_m->tambah_obat($obat, $qty);
        echo json_encode($res);
      }
    }
  }

  public function hapus_obat(){
    $id = intval($this->input->post('id', true));
    $sess = $this->session->userdata('obat');

    if(isset($sess[$id])){
      $res = $this->pesanan_m->hapus_obat($id, $sess);
      echo json_encode($res);
    }else{
      echo json_encode(['status' => 'error', 'msg' => 'Data tidak tersedia']);
    }
  }

  public function confirm_obat($id=null){
    if(is_null($id)) redirect('pesanan');
    $sess = $this->session->userdata('obat');
    if(is_null($sess)){
      $this->session->set_flashdata('swal', ['type' => 'error', 'msg' => 'Data obat masih kosong']);
      redirect('pesanan/tambah_obat/'.$id);
    }
    $res = $this->pesanan_m->confirm_obat($sess, $id);
    $this->session->set_flashdata('swal', $res);
    redirect('pesanan/selesai/'.$id);
  }

  public function var_dump(){
    var_dump($this->session->userdata('obat'));
    $this->session->unset_userdata('obat');
  }

   public function get_kota()
   {
      $provinsi = $_GET['provinsi'];

         $arr_data = array(
            'id_provinsi' => $provinsi
         );

         $get_kabkota = $this->model->get_kota($provinsi)->result();

         $arr_kabkota = [];
         foreach($get_kabkota as $row)
         {
            $arr_kabkota[$row->id_kota] = $row->nama;
         }

         $json = json_encode($arr_kabkota);
         echo $json;
   }

   public function get_kecamatan()
   {
      $kota = $_GET['kota'];

         $arr_data = array(
            'id_kota' => $kota
         );

         $get_kecamatan = $this->model->get_kecamatan($kota)->result();
         $arr_kecamatan = [];
         foreach($get_kecamatan as $row)
         {
            $arr_kecamatan[$row->id] = $row->nama;
         }

         $json = json_encode($arr_kecamatan);
         echo $json;
   }

   public function get_desa()
   {
      $kecamatan = $_GET['kecamatan'];

         $arr_data = array(
            'id_kecamatan' => $kecamatan
         );

         $get_desa = $this->model->get_desa($kecamatan)->result();

         $arr_desa = array();
         foreach($get_desa as $row)
         {
            $arr_desa[$row->id] = $row->nama;
         }
         if(empty($get_desa)) $arr_desa = ['' => 'Pilih Desa'];

         $json = json_encode($arr_desa);
         echo $json;
   }

   public function coverage_check(){
    $id_kec = $this->input->post('kecamatan', true);
    echo json_encode($this->pesanan_m->coverage_check($id_kec));
   }
}

