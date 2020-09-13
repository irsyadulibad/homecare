<div class="col-lg-12">
<div class="card">
<form action="" method="post">
                                    <div class="card-header">
                                        <strong>Pilih Paramedis</strong> Form
                                    </div>
                                    <div class="card-body card-block">
                                  
                                        
                                        
        <div class="form-group">
         <select name="id_medis" id="id_medis" name="id_medis" value="<?=set_value('id_medis')?>" style="width: 30%;" class="form-control"> 
            <option value="">Pilih Paramedis</option>
            <?php foreach($user->result() as $med): ?>
            <option value="<?php echo $med->id_pengguna; ?>"><?php echo $med->nama_lengkap; ?> </option>
            <?php endforeach; ?>
            
         </select>

      </div>
      <div class="form-group">
                                        <input type="hidden" name="id_pesanan" value="<?=$row->id_pesanan?>">
                                        <input type="hidden" name="tgl_kunjungan" value="<?=$row->tgl_kunjungan?>">
                                        <input type="hidden" name="jam_kunjungan" value="<?=$row->jam_kunjungan?>">
                                        <input type="hidden" name="id_pasien" value="<?=$row->id_pasien?>">
                                        <input type="hidden" name="id_layanan" value="<?=$row->id_layanan?>">
                                        <input type="hidden" name="id_pengguna" value="<?=$row->id_pengguna?>">
                                        <input type="hidden" name="provinsi" value="<?=$row->provinsi?>">
                                        <input type="hidden" name="kabupaten" value="<?=$row->kabupaten?>">
                                        <input type="hidden" name="kecamatan" value="<?=$row->kecamatan?>">
                                        <input type="hidden" name="desa" value="<?=$row->desa?>">
                                        <input type="hidden" name="kondisi" value="<?=$row->kondisi_terkini?>">
                                        <input type="hidden" name="alamat" value="<?=$row->alamat_pasien?>">
                                        </div>
                                       <div class="form-group">
                                       <button type="submit" class="btn btn-success btn-flat">
                                       <i class="fa fa-paper-plane"></i> Save
                                       </button>
                                       <button type="submit" class="btn btn-flat"> Reset
                                       </button>
                                       </div>
                                    </div>
                                </form>
                                    </div>
                                