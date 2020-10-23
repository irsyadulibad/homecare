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
          <?= form_open_multipart(''); ?>
            <div class="card-header">
              <h4>Edit Profile</h4>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="form-group col-md-6 col-12">
                  <label>Nama Lengkap</label>
                  <input type="text" class="form-control" value="<?= $user['nama_lengkap'] ?>" name="fullname">
                  <small class="text-danger"><?= form_error('fullname') ?></small>
                </div>
                <div class="form-group col-md-6 col-12">
                  <label>Email</label>
                  <input type="email" class="form-control" value="<?= $user['email'] ?>" name="email">
                  <small class="text-danger"><?= form_error('email') ?></small>
                </div>
              </div>
              <div class="row">
                <div class="form-group col-md-7 col-12">
                  <label>Jenis Kelamin</label>
                  <select name="gender" class="form-control">
                    <option value="1" <?= $user['jenis_kelamin'] == '1' ? 'selected' : ''; ?>>Pria</option>
                    <option value="2" <?= $user['jenis_kelamin'] == '2' ? 'selected' : ''; ?>>Wanita</option>
                  </select>
                  <small class="text-danger"><?= form_error('gender') ?></small>
                </div>
                <div class="form-group col-md-5 col-12 text-center">
                  <label for="img-profile" style="display: block;">
                    <img alt="image" src="<?= base_url('assets/img/profile/'.$user['foto']); ?>" class="rounded-circle profile-widget-picture img-edit" width="30%">
                  </label>
                  <input type="file" name="image" accept="image/*" id="img-profile" style="display: none;">
                  <small class="text-muted">* biarkan jika tidak ingin diubah</small>
                </div>
              </div>
              <div class="row">
                <div class="form-group col-md-6">
                  <label for="nohp">No HP</label>
                  <input type="number" class="form-control" id="nohp" name="phone" value="<?= $user['no_hp']; ?>">
                  <small class="text-danger"><?= form_error('phone') ?></small>
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
