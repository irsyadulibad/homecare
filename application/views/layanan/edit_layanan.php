<?php
$status = $layanan['status'];
?>
<div class="row justify-content-center">
	<div class="col-12 col-md-6 col-lg-6">
		<div class="card">
			<div class="card-body">
			<?= form_open(''); ?>
				<div class="form-group">
					<label>Jenis Layanan</label>
					<input type="text" class="form-control" name="jenis_layanan" value="<?= $layanan['jenis_layanan'] ?>">
					<small class="text-danger"><?= form_error('jenis_layanan'); ?></small>
				</div>
				<div class="form-group">
					<label>Keterangan</label>
					<textarea class="form-control" name="keterangan"><?= $layanan['keterangan'] ?></textarea>
					<small class="text-danger"><?= form_error('keterangan'); ?></small>
				</div>
				<div class="form-group">
					<label>Harga</label>
					<input type="number" class="form-control" name="harga" value="<?= $layanan['harga'] ?>">
					<small class="text-danger"><?= form_error('harga'); ?></small>
				</div>
				<div class="form-group">
					<label for="status">Status</label>
					<select name="status" id="status" class="form-control">
						<option value="medis" <?= $status == 'medis' ? 'selected' : ''; ?>>Medis</option>
						<option value="paramedis" <?= $status == 'paramedis' ? 'selected' : ''; ?>>Paramedis</option>
					</select>
				</div>
				<div class="form-group">
					<button type="submit" name="submit" class="btn btn-primary float-right"><i class="fas fa-save"></i> Simpan</button>
				</div>
			</form>
			</div>
		</div>
	</div>
</div>
