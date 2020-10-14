<?php
function check_already_login(){
  $ci =& get_instance();
  $user_session = $ci->session->userdata('user');
  if($user_session){
    redirect('homecare');
  }
}
function check_not_login(){
  $ci =& get_instance();
  $user_session = $ci->session->userdata('user');
  if(!$user_session){
    redirect('auth/login');
  }
}
function check_admin(){
  $ci =& get_instance();
  $ci->load->library('fungsi');
  if($ci->fungsi->user_login()->role != 1 ){
    redirect('homecare');
  }

}
function check_user(){
  $ci =& get_instance();
  $ci->load->library('fungsi');
  if($ci->fungsi->user_login()->role != 3 ){
    redirect('homecare');
  }
}
function check_both(){
  $ci =& get_instance();
  $ci->load->library('fungsi');
  if($ci->fungsi->user_login()->role != 3 && $ci->fungsi->user_login()->role != 1 ){
    redirect('homecare');
  }
}
