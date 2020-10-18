<div class="row justify-content-center">
	<div class="col-md-6">
		<div class="card">
			<?= form_open(''); ?>
				<div class="card-body">
					<div class="form-group">
						<label for="jarak-awal">Jarak Awal (KM)</label>
						<input type="number" class="form-control" id="jarak-awal" name="jarak_awal" value="<?= $ongkir['jarak_awal']; ?>">
						<small class="text-danger"><?= form_error('jarak_awal'); ?></small>
					</div>
					<div class="form-group">
						<label for="jarak-akhir">Jarak Akhir (KM)</label>
						<input type="number" class="form-control" id="jarak-akhir" name="jarak_akhir" value="<?= $ongkir['jarak_akhir']; ?>">
						<small class="text-danger"><?= form_error('jarak_akhir'); ?></small>
					</div>
					<div class="form-group">
						<label for="biaya">Biaya</label>
						<input type="number" class="form-control" id="biaya" name="biaya" value="<?= $ongkir['biaya']; ?>">
						<small class="text-danger"><?= form_error('biaya'); ?></small>
					</div>
					<div class="form-group">
						<label for="keterangan">Keterangan (opsional)</label>
						<textarea class="form-control" id="keterangan" name="keterangan"><?= $ongkir['keterangan']; ?></textarea>
						<small class="text-danger"><?= form_error('keterangan'); ?></small>
					</div>
					<div class="form-group text-right">
						<button class="btn btn-primary" type="submit"><i class="fas fa-save"></i> Simpan</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
