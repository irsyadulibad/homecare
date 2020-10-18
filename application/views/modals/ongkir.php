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
        <div class="form-group">
          <label for="jarak-awal">Jarak Awal (KM)</label>
          <input type="number" class="form-control" id="jarak-awal" name="jarak_awal">
        </div>
        <div class="form-group">
          <label for="jarak-akhir">Jarak Akhir (KM)</label>
          <input type="number" class="form-control" id="jarak-akhir" name="jarak_akhir">
        </div>
        <div class="form-group">
          <label for="biaya">Biaya</label>
          <input type="number" class="form-control" id="biaya" name="biaya">
        </div>
        <div class="form-group">
          <label for="keterangan">Keterangan (opsional)</label>
          <textarea class="form-control" id="keterangan" name="keterangan"></textarea>
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
