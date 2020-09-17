<!-- Modal -->
<div class="modal fade" id="tambahOngkirModal" tabindex="-1" role="dialog" aria-labelledby="tambahOngkirModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <?= form_open('ongkir/tambah'); ?>
      <div class="modal-header">
        <h5 class="modal-title" id="tambahOngkirModalLabel">Tambah Ongkir</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="container">
          <div class="form-group">
            <label for="provinsi">Provinsi</label>
            <select name="provinsi" id="provinsi" class="form-control">
              <option value="">-Pilih Provinsi-</option>
            <?php foreach($provinsi as $prov): ?>
              <option value="<?= $prov->id_provinsi; ?>"><?= $prov->nama; ?></option>
            <?php endforeach; ?>
            </select>
          </div>
          <div class="form-group">
            <label for="kota">Kota</label>
            <select name="kota" id="kota" class="form-control">
              <option value="">-Pilih Kabupaten-</option>
            </select>
          </div>
          <div class="form-group">
            <label for="kecamatan">Kecamtan</label>
            <select name="kecamatan" id="kecamatan" class="form-control">
              <option value="">-Pilih Kecamatan-</option>
            </select>
          </div>
          <div class="form-group">
            <label for="">Tarif</label>
            <input type="number" class="form-control" name="tarif">
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-primary">Simpan</button>
      </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="editOngkirModal" tabindex="-1" role="dialog" aria-labelledby="editOngkirModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <?= form_open('ongkir/edit'); ?>
      <div class="modal-header">
        <h5 class="modal-title" id="editOngkirModalLabel">Edit Ongkir</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="container edit-ongkir-content">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-primary">Simpan</button>
      </div>
      </form>
    </div>
  </div>
</div>
