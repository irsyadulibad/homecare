<?php
$fullAddr = $this->fungsi->get_address($user['id_alamat'], 'str');
$addr = explode(',', $fullAddr);
?>
<div class="row justify-content-center">
  <div class="col-md-6">
    <div class="card">
      <div class="card-body">
      <?= form_open(); ?>
        <div class="form-group">
          <input type="hidden" value="<?= $user['id_pengguna']; ?>" name="id">
          <label for="fullname">Nama Pasien</label>
          <input type="text" class="form-control" id="fullname" value="<?= $user['nama_lengkap']; ?>" disabled>
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
        <div class="form-group">
          <button class="btn btn-success float-right" type="submit"><i class="fas fa-check"></i> Checkout</button>
        </div>
      </form>
    </div>
  </div>
</div>
</div>
