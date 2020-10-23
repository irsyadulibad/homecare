<?php
$alamat = (!is_null($alamat)) ? $alamat['alamat'] : null;
?>
<div class="section-body">
  <p class="section-lead">
    Ubah profil anda pada halaman ini.
  </p>

  <div class="row mt-sm-4">
    <div class="col-12 col-md-12 col-lg-5">
      <div class="card profile-widget">
        <div class="profile-widget-header">
          <img alt="image" src="<?= base_url('assets/img/profile/'.$user['foto']); ?>" class="rounded-circle profile-widget-picture">
        </div>
        <div class="profile-widget-description">
          <div class="profile-widget-name">
            <?= $user['nama_lengkap']; ?> -- 
            <span class="badge badge-sm badge-primary"><?= $user['status']; ?></span>
          </div>
        <?php if(!is_null($alamat)): ?>
          <span class="profile-widget-bio">
            <?= $alamat ?> <a href="<?= base_url('profile/editaddr') ?>"><i class="fas fa-pencil-alt"></i></a>
          </span>
        <?php else: ?>
          <span class="profile-widget-bio">
            Tambahkan Alamat <a href="<?= base_url('profile/editaddr') ?>"><i class="fas fa-pencil-alt"></i></a>
          </span>
        <?php endif; ?>
        </div>
      </div>
    </div>
    <div class="col-12 col-md-12 col-lg-7">
      <div class="card">
          <?= form_open('') ?>
            <div class="card-header">
              <h4>Edit Password</h4>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-12 form-message"></div>
              </div>
              <div class="row">
                <div class="form-group col-md-8">
                  <label for="old-pass">Password Lama</label>
                  <input type="password" class="form-control" id="old-pass" name="old-pass">
                  <small class="text-danger"><?= form_error('old-pass') ?></small>
                </div>
              </div>
              <div class="row">
                <div class="form-group col-md-6">
                  <label for="new-pass">Password Baru</label>
                  <input type="password" class="form-control" id="new-pass" name="new-pass">
                  <small class="text-danger"><?= form_error('new-pass') ?></small>
                </div>
                <div class="form-group col-md-6">
                  <label for="confirm-pass">Konfirmasi</label>
                  <input type="password" class="form-control" id="confirm-pass" name="confirm-pass">
                  <small class="text-danger"><?= form_error('confirm-pass') ?></small>
                </div>
              </div>
            </div>
            <div class="card-footer text-right">
              <button class="btn btn-primary" type="submit">Simpan</button>
            </div>
          </form>
      </div>
    </div>
  </div>
</div>
