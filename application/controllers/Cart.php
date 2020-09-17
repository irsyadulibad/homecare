<?php

class Cart extends CI_Controller{

    function __construct(){
        parent::__construct();
        $this->load->model('cart_model');
        $this->load->model('pesanan_m');
        $this->load->model('layanan_m');
        $this->load->model('user_m');
        $this->load->model('model_invoice');
        $this->load->model('obat_m');
        check_not_login();
    }

    function index(){
        $data['data']=$this->cart_model->get_all_produk();
        $data['modal'] = 'cart';
        $data['head'] = 'Pilih Layanan';
        $data['cart'] = $this->cart_model->destruct_cart();
        $this->template->load('template2','cart/v_cart',$data);
    }

    function add_to_cart(){ //fungsi Add To Cart
        $id = $this->input->post('id_layanan');
        $layanan = $this->cart_model->get_layanan($id);

        if(!is_null($layanan)){
            $insert = $this->cart_model->insert($layanan);
            if($insert['status'] == true){
                $data = ['status' => 'success', 'rowid' => $insert['rowid']];
                echo json_encode($data);
            }else{
                $data = ['status' => 'failed', 'msg' => $insert['msg']];
                echo json_encode($data);
            }
        }else{
            echo json_encode(['status' => 'failed', 'msg' => 'Produk tidak ditemukan']);
        }
    }

    public function destroy(){
        $this->cart->destroy();
        $this->session->unset_userdata('obat');
    }

    public function var_dump(){
        var_dump($this->cart->contents());
        var_dump($this->session->userdata('obat'));
    }

    public function load_cart(){
        $string = $this->cart_model->show();
        echo $string;
    }

    function hapus_cart(){ //fungsi untuk menghapus item cart
        $res = $this->cart_model->delete();
        echo $res;
    }
    function checkout() {
        $user = $this->fungsi->user_login();
        if(is_null($user->alamat)){
            $this->session->set_flashdata('swal', ['type' => 'error', 'msg' => 'Alamat masih belum diisi']);
            redirect('profile/edit');
        }

        if($this->cart->total_items() < 1){
            $this->session->set_flashdata('swal', ['type' => 'error', 'msg' => 'Keranjang belanja masih kosong']);
            redirect('cart');
        }
        $this->form_validation->set_rules('tgl_kunjungan', 'Tgl Kunjungan', 'required');
        $this->form_validation->set_rules('jam_kunjungan', 'Jam Kunjungan', 'required');

        if($this->form_validation->run() == false){
            $data['layanan'] = $this->layanan_m->getlay();
            $data['user'] = $user;
            $id = $user->id_pengguna;
            $data['head'] = "Checkout Pesanan";
            $this->template->load('template2','cart/bayar',$data);
        }else{
            $fee = $this->cart_model->coverage_check($user);
            if(!$fee){
                $this->session->set_flashdata('swal', ['type' => 'error', 'msg' => 'Daerah anda belum tercover']);
                redirect('cart/checkout');
            }
            $res = $this->cart_model->checkout($fee);
            if($res > 0){
                $this->session->set_flashdata('swal', ['type' => 'success', 'msg' => 'Berhasil membuat pesanan']);
            }else{
                $this->session->set_flashdata('swal', ['type' => 'error', 'msg' => 'Gagal membuat pesanan']);
            }
            $role = $this->fungsi->user_login()->role;
            if($role == 3){
                redirect('pesanan/diuser');
            }else{
                redirect('invoice');
            }
        }
    }

    public function tes(){
        $this->load->view('cart/tes');
    }
}
