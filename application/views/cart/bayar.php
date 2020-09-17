<?php
$fullAddr = $this->fungsi->get_address($user->id_pengguna, 'str');
$addr = explode(',', $fullAddr);
?>
<div class="row justify-content-center">
  <div class="col-md-6">
    <div class="card">
      <div class="card-body">
        <?= form_open_multipart(); ?>
        <div class="form-group">
          <label for="id_pasien">Nama Pasien</label>
          <input type="text" class="form-control" value="<?= $user->nama_lengkap; ?>" disabled>
          <small class="text-danger"><?= form_error('id_pasien'); ?></small>
        </div>
        <div class="form-group">
          <label for="">Tanggal Kunjungan</label>
          <input type="date" name="tgl_kunjungan" class="form-control input-tgl" placeholder="2020-05-05" id="mdate" value="<?= date('d-m-Y') ?>">
          <small class="text-danger"><?= form_error('tgl_kunjungan'); ?></small>
        </div>
        <div class="form-group">
          <label for="">Jam Kunjungan</label>
          <input type="time" class="form-control timepicker" name="jam_kunjungan" value="<?= date('H:i') ?>">
          <small class="text-danger"><?= form_error('jam_kunjungan'); ?></small>
        </div>
        <div class="form-group">
          <label for="img_kondisi" class="display-block" style="display: block;">
            <div class="btn btn-primary"><i class="fas fa-image"></i> Kondisi Terkini</div>
          </label>
          <input type="file" name="kondisi" class="input-edit-img" style="display: none;" id="img_kondisi">
          <img src="" alt="kondisi" height="50" class="img-edit">
        </div>
        <div class="form-group">
          <div class="card border">
            <div class="card-header bg-light pb-0">
              <h6 class="float-left">Alamat</h6>
            </div>
            <div class="card-body pt-0">
              <p><?= $addr[0]; ?></p>
              <strong><?= trim($addr[1]); ?></strong>
              <a href="<?= base_url('profile/edit'); ?>" class="badge badge-primary badge-sm float-right mt-4">Ubah Alamat</a>
            </div>
          </div>
        </div>
        <div class="form-group m-0">
          <small>*Cek ketersediaan untuk memastikan daerah anda telah tercover layanan kami</small>
        </div>
        <div class="form-group">
          <button type="button" class="btn btn-info coverage-check" data-kec="<?= $user->alamat->kecamatan; ?>"><i class="fas fa-exclamation-circle"></i> Cek Ketersediaan</button>
          <button class="btn btn-success float-right" type="submit"><i class="fas fa-check"></i> Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>
</div>
