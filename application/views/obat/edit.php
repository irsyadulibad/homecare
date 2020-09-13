<div class="row">
	<div class="col-md-6">
		<?= form_open(''); ?>
			<div class="card">
				<div class="card-body">
					<div class="form-group">
						<label for="">Nama Obat</label>
						<input type="text" class="form-control" name="name" value="<?= $obat['nama']; ?>">
						<small class="text-danger"><?= form_error('name'); ?></small>
					</div>
					<div class="form-group">
						<label for="">Harga Obat</label>
						<input type="number" class="form-control" name="price" value="<?= $obat['harga']; ?>">
						<small class="text-danger"><?= form_error('price'); ?></small>
					</div>
					<div class="form-group">
						<button class="btn btn-primary float-right"><i class="fas fa-save"></i> Simpan</button>
					</div>
				</div>
			</div>
		</form>
	</div>
	<div class="col-md-6">
		<div class="card">
			<div class="card-body">
			<?php if($errs = $this->session->flashdata('form_err')): ?>
				<div class="alert alert-danger" role="alert">
					<?= $errs; ?>
				</div>
			<?php endif; ?>
				<?= form_open('obat/update_stock/'.$obat['id_obat']); ?>
				<div class="form-group">
					<label for="">Stok Sekarang</label>
					<input type="number" class="form-control" value="<?= $obat['stok']; ?>" disabled="true">
				</div>
				<div class="form-group">
					<label for="">Update Stok</label>
					<input type="number" class="form-control" name="stock">
				</div>
				<div class="form-group">
					<button class="btn btn-primary float-right"><i class="fas fa-save"></i> Simpan</button>
				</div>
				</form>
			</div>
		</div>
	</div>
</div>
