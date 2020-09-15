"use strict";
$(document).ready(function(){
	var baseUrl = $('#baseUrl').data('url');

  toastr.options = {
    "closeButton": false,
    "debug": false,
    "newestOnTop": false,
    "progressBar": false,
    "positionClass": "toast-bottom-center",
    "preventDuplicates": false,
    "onclick": null,
    "showDuration": "300",
    "hideDuration": "1000",
    "timeOut": "5000",
    "extendedTimeOut": "1000",
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
  }

  $('.confirm-href').on('click', function(e){
    e.preventDefault();
    let btn = $(this);
    Swal.fire({
     title: 'Apakah anda yakin?',
     icon: 'warning',
     showCancelButton: true,
     confirmButtonColor: '#3085d6',
     cancelButtonColor: '#d33',
     confirmButtonText: 'Ya',
     cancelButtonText: 'Tidak'
   }).then(result => {
     if(result.value){
      document.location.href = btn.attr('href');
    }
  });
 });

  $('#datatable').DataTable();
  /* Sweet Alert Condition */
  const al = $('#swal').data('type');
  if(al != ""){
    Swal.fire({
     icon: $('#swal').data('type'),
     text: $('#swal').data('msg')
   });
  }
  $('#id_pasien').select2();
  $('.obat').select2();
  $('.add-cart').click(function(){
    let idlayanan = $(this).data('id');
    let rowid = $(this).attr('data-rowid');
    let btn = $(this);
    $.ajax({
      url: baseUrl+'obat/cek_json',
      method: 'post',
      data: {id: idlayanan, rowid: rowid},
      dataType: 'json',
      success: function(e){
        if(e.stok < 1){
          Swal.fire({
            icon: 'error',
            text: 'Stok obat habis untuk layanan ini'
          });
          
        }else{
          $.ajax({
            url: baseUrl+'cart/add_to_cart',
            method: 'post',
            data: {id_layanan: idlayanan, rowid: rowid},
            dataType: 'json',
            success: function(e){
              if(e.status == 'success'){
                btn.attr('data-rowid', e.rowid);
                toastr["success"]("Berhasil Menambahkan ke Cart");
              }else{
                Swal.fire({
                  icon: 'error',
                  text: e.msg
                });
              }
            }
          });
        }
      },
      error: function(data){
        console.warn(data.responseText);
      }
    });
  });

  $('#btn-cart-checkout').click(function(){
    let cartContent = $('#cart-content');
    cartContent.html('<h1 class="text-center"><i class="fas fa-spinner fa-pulse"></i></h1>');
    $.ajax({
      url: baseUrl+'cart/load_cart',
      success: function(data){
        cartContent.html(data);
      }
    })
  });

  $('#cart-content').on('click', '.del-cart-item', function(){
    let rowid = $(this).data('rowid');
    let id = $(this).data('id');
    $(this).html('<i class="fas fa-spinner fa-pulse"></i> Loading');
    $.ajax({
      url: baseUrl+'cart/hapus_cart',
      method: 'post',
      data: {rowid: rowid, id, id},
      success: function(data){
        $('#cart-content').html(data);
      }
    });
  });

  $("#kota").remoteChained({
    parents : "#provinsi",
    url : baseUrl+'pesanan/get_kota'
  });

  $("#kecamatan").remoteChained({
    parents : "#kota",
    url : baseUrl+'pesanan/get_kecamatan'
  });

  $("#desa").remoteChained({
    parents : "#kecamatan",
    url : baseUrl+'pesanan/get_desa'
  });

  function readURL(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      
      reader.onload = function(e) {
        $('.img-edit').attr('src', e.target.result);
      }
      
      reader.readAsDataURL(input.files[0]); // convert to base64 string
    }
  }
  $('.input-edit-img').change(function(){
    readURL(this);
  });
  $('.coverage-check').click(function(e){
    let kecamatan = $('#kecamatan').val();
    $.ajax({
      url: baseUrl+'pesanan/coverage_check',
      method: 'post',
      data: {kecamatan: kecamatan},
      dataType: 'json',
      success: function(data){
        if(data.status == 'success'){
          Swal.fire({
            icon: 'success',
            text: 'Ongkos Kirim: Rp.'+data.fee
          });
        }else{
          Swal.fire({
            icon: 'error',
            text: data.msg
          });
        }
      }
    });
  });

  $('.btn-edit-ongkir').click(function(){
    let id = $(this).data('id');
    $('.edit-ongkir-content').html('<h1><i class="fas fa-spinner fa-pulse"></i></h1>');
    $.ajax({
      url: baseUrl+'ongkir/get_ongkir',
      data: {id: id},
      success: function(data){
        $('.edit-ongkir-content').html(data);
      }
    });
  });

  $('#form-default-drug').submit(function(e){
    e.preventDefault();
    let form = $(this);
    $.ajax({
      url: form.attr('action'),
      data: form.serialize(),
      method: 'post',
      dataType: 'json',
      success: function(data){
        if(data.status == 'success'){
          let content = $('.layobs-content');
          let html = '';
          $.each(data.items, function(i, item){
            html += `
            <span class="badge badge-primary mr-2 mb-2 btn-del-layob" data-id="${item.id}" data-layanan="${item.id_layanan}">
            <span class=""><i class="fas fa-times-circle mr-2"></i></span>
            ${item.nama}
            </span>
            `;
          });
          content.html(html);
          toastr['success'](data.msg);
        }else{
          toastr["error"](data.msg);
        }
      }
    });
  });

  $('#form-add-obat').submit(function(e){
    e.preventDefault();
    const form = $(this);
    $.ajax({
      url: form.attr('action'),
      method: 'post',
      data: form.serialize(),
      dataType: 'json',
      success: function(data){
        if(data.status == 'success'){
          const content = $('#obat-add-content');
          let html = '';
          toastr['success'](data.msg);
          $.each(data.items, function(i, item){
            html += `
            <tr>
            <td>${i+1}</td>
            <td>${item.nama}</td>
            <td>${item.qty}</td>
            <td>
            <button class="btn btn-danger btn-del-cart-obat" data-id="${item.id}"><i class="fas fa-trash-alt"></i> Hapus</button>
            </td>
            </tr>
            `;
          });
          content.html(html);
        }else{
          toastr['error'](data.msg);
        }
      }
    });
  });

  $('#obat-add-content').on('click', '.btn-del-cart-obat', function(e){
    const btn = $(this);
    $(this).html('<i class="fas fa-spinner fa-pulse"></i> Loading');
    $.ajax({
      url: baseUrl+'pesanan/hapus_obat',
      method: 'post',
      data: {id: btn.data('id')},
      dataType: 'json',
      success: function(data){
        if(data.status == 'success'){
          const content = $('#obat-add-content');
          let html = '';
          toastr['success'](data.msg);
          if(data.items.length == 0){
            html += `
            <tr>
            <td colspan="4" align="center">Daftar masih kosong</td>
            </tr>
            `;
          }
          $.each(data.items, function(i, item){
            html += `
            <tr>
            <td>${i+1}</td>
            <td>${item.nama}</td>
            <td>${item.qty}</td>
            <td>
            <button class="btn btn-danger btn-del-cart-obat" data-id="${item.id}"><i class="fas fa-trash-alt"></i> Hapus</button>
            </td>
            </tr>
            `;
          });
          content.html(html);
        }else{
          toastr['error'](data.msg);
        }
      }
    });
  });

  $('.layobs-content').on('click', '.btn-del-layob', function(){
    const btn = $(this);
    $.ajax({
      url: `${baseUrl}obat/del_default/${btn.data('layanan')}`,
      method: 'post',
      data: {id: btn.data('id')},
      dataType: 'json',
      success: function(data){
        if(data.status == 'success'){
          let content = $('.layobs-content');
          let html = '';
          $.each(data.items, function(i, item){
            html += `
            <span class="badge badge-primary mr-2 mb-2 btn-del-layob" data-id="${item.id}" data-layanan="${item.id_layanan}">
            <span class=""><i class="fas fa-times-circle mr-2"></i></span>
            ${item.nama}
            </span>
            `;
          });
          content.html(html);
          toastr['success'](data.msg);
        }else{
          toastr["error"](data.msg);
        }
      }
    });
  });
});
