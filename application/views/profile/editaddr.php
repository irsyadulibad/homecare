<?php
if(!is_null($alamat)){
  $kabupaten = $this->daerah_m->get_kabupaten($alamat['id_provinsi']);
  $kecamatan = $this->daerah_m->get_kecamatan($alamat['id_kabupaten']);
  $desa = $this->daerah_m->get_desa($alamat['id_kecamatan']);
}
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
            <?= $alamat['alamat'] ?>
          </span>
        <?php endif; ?>
        </div>
      </div>
    </div>
    <div class="col-12 col-md-12 col-lg-7">
      <div class="card">
          <?= form_open('') ?>
            <div class="card-header">
              <h4>Edit Alamat</h4>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-12 form-message"></div>
              </div>
            <?php if(!is_null($alamat)): ?>
              <div class="row">
                <div class="form-group col-md-6">
                  <label for="provinsi">Provinsi</label>
                  <select name="provinsi" id="provinsi" class="form-control">
                    <option value="">--Pilih Provinsi--</option>
                  <?php foreach($provinces as $provinsi): ?>
                    <option <?= ($provinsi['id_provinsi'] == $alamat['id_provinsi']) ? 'selected' : ''; ?> value="<?= $provinsi['id_provinsi'] ?>"><?= $provinsi['nama'] ?></option>
                  <?php endforeach; ?>
                  </select>
                  <small class="text-danger"><?= form_error('provinsi') ?></small>
                </div>
                <div class="form-group col-md-6">
                  <label for="kabupaten">Kabupaten</label>
                  <select name="kabupaten" id="kabupaten" class="form-control">
                  <?php foreach($kabupaten as $kab): ?>
                    <option <?= ($kab['id_kabupaten'] == $alamat['id_kabupaten']) ? 'selected' : ''; ?> value="<?= $kab['id_kabupaten'] ?>"><?= $kab['nama']; ?></option>
                  <?php endforeach; ?>
                  </select>
                  <small class="text-danger"><?= form_error('kabupaten') ?></small>
                </div>
              </div>
              <div class="row">
                <div class="form-group col-md-6">
                  <label for="kecamatan">Kecamatan</label>
                  <select name="kecamatan" id="kecamatan" class="form-control">
                  <?php foreach($kecamatan as $kec): ?>
                    <option <?= ($kec['id_kecamatan'] == $alamat['id_kecamatan']) ? 'selected' : ''; ?> value="<?= $kec['id_kecamatan'] ?>"><?= $kec['nama']; ?></option>
                  <?php endforeach; ?>
                  </select>
                  <small class="text-danger"><?= form_error('kecamatan') ?></small>
                </div>
                <div class="form-group col-md-6">
                  <label for="desa">Desa</label>
                  <select name="desa" id="desa" class="form-control">
                    <?php foreach($desa as $des): ?>
                    <option <?= ($des['id_desa'] == $alamat['id_desa']) ? 'selected' : ''; ?> value="<?= $des['id_desa'] ?>"><?= $des['nama']; ?></option>
                  <?php endforeach; ?>
                  </select>
                  <small class="text-danger"><?= form_error('desa') ?></small>
                </div>
              </div>
              <div class="row">
                <div class="form-group col-12">
                  <label for="alamat">Alamat</label>
                  <textarea name="alamat" id="alamat" cols="30" rows="10" class="form-control"><?= $alamat['alamat'] ?></textarea>
                  <small class="text-danger"><?= form_error('alamat') ?></small>
                </div>
              </div>
            <?php else: ?>
              <div class="row">
                <div class="form-group col-md-6">
                  <label for="provinsi">Provinsi</label>
                  <select name="provinsi" id="provinsi" class="form-control">
                    <option value="">--Pilih Provinsi--</option>
                  <?php foreach($provinces as $provinsi): ?>
                    <option value="<?= $provinsi['id_provinsi'] ?>"><?= $provinsi['nama'] ?></option>
                  <?php endforeach; ?>
                  </select>
                  <small class="text-danger"><?= form_error('provinsi') ?></small>
                </div>
                <div class="form-group col-md-6">
                  <label for="kabupaten">Kabupaten</label>
                  <select name="kabupaten" id="kabupaten" class="form-control">
                    <option value="">--Pilih Kabupaten--</option>
                  </select>
                  <small class="text-danger"><?= form_error('kabupaten') ?></small>
                </div>
              </div>
              <div class="row">
                <div class="form-group col-md-6">
                  <label for="kecamatan">Kecamatan</label>
                  <select name="kecamatan" id="kecamatan" class="form-control">
                    <option value="">--Pilih Kecamatan--</option>
                  </select>
                  <small class="text-danger"><?= form_error('kecamatan') ?></small>
                </div>
                <div class="form-group col-md-6">
                  <label for="desa">Desa</label>
                  <select name="desa" id="desa" class="form-control">
                    <option value="">--Pilih Desa--</option>
                  </select>
                  <small class="text-danger"><?= form_error('desa') ?></small>
                </div>
              </div>
              <div class="row">
                <div class="form-group col-12">
                  <label for="alamat">Alamat</label>
                  <textarea name="alamat" id="alamat" cols="30" rows="10" class="form-control"></textarea>
                  <small class="text-danger"><?= form_error('alamat') ?></small>
                </div>
              </div>
            <?php endif; ?>
            </div>
            <div class="card-footer text-right">
              <button class="btn btn-primary" type="submit">Simpan</button>
            </div>
          </form>
      </div>
    </div>
  </div>
</div>
