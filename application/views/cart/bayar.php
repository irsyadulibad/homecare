<?php
$fullAddr = $this->fungsi->get_address($user['id_alamat'], 'str');
$addr = explode(',', $fullAddr);
?>
<div class="row justify-content-center">
  <div class="col-md-6">
    <div class="card">
      <div class="card-body">
        <?= form_open_multipart(); ?>
        <div class="form-group">
          <label for="fullname">Nama Pasien</label>
          <input type="text" class="form-control" id="fullname" value="<?= $user['nama_lengkap']; ?>" disabled>
          <small class="text-danger"><?= form_error('fullname'); ?></small>
        </div>
        <div class="form-group">
          <div class="card border">
            <div class="card-header bg-light pb-0">
              <h6 class="float-left">Alamat</h6>
            </div>
            <div class="card-body pt-0">
              <p><?= $addr[0]; ?></p>
              <strong><?= trim($addr[1]); ?></strong>
              <a href="<?= base_url('profile/editaddr'); ?>" class="badge badge-primary badge-sm float-right mt-4">Ubah Alamat</a>
            </div>
          </div>
        </div>
        <div class="form-group m-0">
          <small>*Cek ketersediaan untuk memastikan daerah anda telah tercover layanan kami</small>
        </div>
        <div class="form-group">
          <button type="button" class="btn btn-info coverage-check" data-kec="<?= $user['id_alamat']; ?>"><i class="fas fa-exclamation-circle"></i> Cek Ketersediaan</button>
          <button class="btn btn-success float-right" type="submit"><i class="fas fa-check"></i> Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>
</div>
