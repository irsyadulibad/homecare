<!-- Modal -->
<div class="modal fade" id="tambahObatModal" tabindex="-1" role="dialog" aria-labelledby="tambahObatModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <?= form_open('obat/tambah'); ?>
      <div class="modal-header">
        <h5 class="modal-title" id="tambahObatModalLabel">Tambah Obat</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label for="">Nama Obat</label>
          <input type="text" class="form-control" name="name">
        </div>
        <div class="form-group">
          <label for="">Harga Obat</label>
          <input type="number" class="form-control" name="price">
        </div>
        <div class="form-group">
          <label for="">Stok Obat</label>
          <input type="number" class="form-control" name="stock">
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
