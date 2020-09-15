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
          <label for="">Alamat Lengkap</label>
          <textarea name="alamat" id="alamat" class="form-control"><?= set_value('alamat'); ?></textarea>
          <small class="text-danger"><?= form_error('alamat'); ?></small>
        </div>
        <div class="form-group">
          <label for="">Pilih Provinsi</label>
          <select name="provinsi" id="provinsi" class="form-control">
            <option value="">Pilih Provinsi</option>
            <?php foreach($provinsi->result() as $prov): ?>
              <option value="<?= $prov->id_provinsi; ?>"><?= $prov->nama; ?></option>
            <?php endforeach; ?>
          </select>
          <small class="text-danger"><?= form_error('provinsi'); ?></small>
        </div>
        <div class="form-group">
          <label for="">Pilih Kota</label>
          <select name="kota" id="kota" class="form-control">
            <option value="">Pilih Kota</option>
          </select>
          <small class="text-danger"><?= form_error('kota'); ?></small>
        </div>
        <div class="form-group">
          <label for="">Pilih Kecamatan</label>
          <select name="kecamatan" id="kecamatan" class="form-control">
            <option value="">Pilih Kecamatan</option>
          </select>
          <small class="text-danger"><?= form_error('kecamatan'); ?></small>
        </div>
        <div class="form-group">
          <label for="">Pilih Desa</label>
          <select name="desa" id="desa" class="form-control">
            <option value="">Pilih Desa</option>
          </select>
          <small class="text-danger"><?= form_error('desa'); ?></small>
        </div>
        <div class="form-group m-0">
          <small>*Cek ketersediaan untuk memastikan daerah anda telah tercover layanan kami</small>
        </div>
        <div class="form-group">
          <button type="button" class="btn btn-info coverage-check"><i class="fas fa-exclamation-circle"></i> Cek Ketersediaan</button>
          <button class="btn btn-success float-right" type="submit"><i class="fas fa-check"></i> Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>
</div>
