<div class="row">
<div class="col-lg-12">
<div class="card">
<form action="" method="POST">
   <fieldset>
   <div class="card-header">
      
                                        <strong>Tambah Pesanan</strong> Form
                                    </div>      <div class="card-body card-block">
 <div class="form-group">
         <select name="id_pasien" id="id_pasien" name="id_pasien" value="<?=set_value('id_pasien')?>" style="width: 30%;" class="form-control"> 
            <option value="">Pilih pasien</option>
            <?php foreach($pasien->result() as $pas): ?>
            <option value="<?php echo $pas->id_pasien; ?>"><?php echo $pas->nama_lengkap; ?></option>
            <?php endforeach; ?>
         </select>
      </div>

 <div class="form-group">
  <label>Kondisi terkini</label>
  <textarea class="form-control rounded-0" style="width: 30%;" name="kondisi" value="<?=set_value('kondisi')?>"></textarea>
</div>

<div class="form-group">
  <label>Alamat Lengkap</label>
  <textarea class="form-control rounded-0" style="width: 30%;" name="alamat" value="<?=set_value('alamat')?>"></textarea>
</div>

  
 <div class="has-success form-group">
         <label>Tgl Kunjungan </label>
         <input type="date" name="tgl_kunjungan" value="<?=set_value('tgl_kunjungan')?>" class= "form-control-success form-control" style="width: 30%;">
   </div>
                                    <p>             
  <div class="has-success form-group">
         <label>Jam Kunjungan </label>
         <input type="time" name="jam_kunjungan" value="<?=set_value('jam_kunjungan')?>" class= "form-control-success form-control" style="width: 30%;">
   </div>
     
      </p>
     
       <p>   
      <div class="form-group">
      
         <select name="id_layanan" id="id_layanan" name="id_layanan" value="<?=set_value('id_layanan')?>" style="width: 30%;" class="form-control"> 
            <option value="">Pilih Layanan</option>
            <?php foreach($layanan->result() as $lay): ?>
            <option value="<?=$lay->id_layanan; ?>"><?php echo $lay->jenis_layanan; ?></option>
            <?php endforeach; ?>
         </select>
      </div>
      </p>
      <p>   
      <div class="form-group">
         <select name="provinsi" id="provinsi" name="provinsi" value="<?=set_value('provinsi')?>" style="width: 30%;" class="form-control"> 
            <option value="">Pilih Provinsi</option>
            <?php foreach($provinsi->result() as $row_provinsi): ?>
            <option value="<?php echo $row_provinsi->id_provinsi; ?>"><?php echo $row_provinsi->nama; ?></option>
            <?php endforeach; ?>
         </select>
      </div>
      </p>
      
      <p>
      <div class="form-group">
         <select name="kota" id="kota" name="kota" value="<?=set_value('kota')?>" style="width: 30%;" class="form-control">
            <option value="">Pilih Kota</option>
         </select>
            </div>
      </p>
      
      <p>
      <div class="form-group">
         <select name="kecamatan" id="kecamatan" name="kecamatan" value="<?=set_value('kecamatan')?>" style="width: 30%;" class="form-control">
            <option value="">Pilih Kecamatan</option>
         </select>
         </div>
      </p>
      
      <p>
      <div class="form-group">
         <select name="desa" id="desa" name="desa" value="<?=set_value('desa')?>" style="width: 30%;" class="form-control">
            <option value="">Pilih Desa</option>
         </select>
         </div>
      </p>

      <div class="form-group">
                                       <button type="submit" class="btn btn-success btn-flat">
                                       <i class="fa fa-paper-plane"></i> Save
                                       </button>
                                       <button type="submit" class="btn btn-flat"> Reset
                                       </button>
                                       </div>
   </fieldset>
</form>
            </div>
            </div>
            </div>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo site_url('assets/js/chained/jquery.chained.js?v=1.0.0'); ?>" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo site_url('assets/js/chained/jquery.chained.remote.js?v=1.0.0'); ?>" type="text/javascript" charset="utf-8"></script>
<link href="<?php echo site_url('assets/css/select2.min.css'); ?>" rel="stylesheet" />
<script src="<?php echo site_url('assets/js/select2/select2.min.js'); ?>"></script>

<script>
   $(document).ready(function() {
       $('select').select2();
   });

   $("#kota").remoteChained({
      parents : "#provinsi",
      url : "<?php echo site_url('pesanan/get_kota'); ?>"
   });

   $("#kecamatan").remoteChained({
      parents : "#kota",
      url : "<?php echo site_url('pesanan/get_kecamatan'); ?>"
   });

   $("#desa").remoteChained({
      parents : "#kecamatan",
      url : "<?php echo site_url('pesanan/get_desa'); ?>"
   });
</script>