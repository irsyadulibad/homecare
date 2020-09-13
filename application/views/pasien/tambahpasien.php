<div class="row justify-content-center">
	<div class="col-12 col-md-6 col-lg-6">
		<div class="card">
			<div class="card-body">
			<?= form_open(''); ?>
				<div class="form-group">
					<label>Nama Lengkap</label>
					<input type="text" class="form-control" name="fullname" value="<?= set_value('fullname'); ?>">
					<small class="text-danger"><?= form_error('fullname'); ?></small>
				</div>
				<div class="form-group">
					<label>Jenis Kelamin</label>
					<select name="jenkel" class="form-control">
						<option value="1"  <?= set_value('jenkel') == 1 ? 'selected' : ''; ?>>Laki-Laki</option>
						<option value="2"  <?= set_value('jenkel') == 2 ? 'selected' : ''; ?>>Perempuan</option>
					</select>
				</div>
				<div class="form-group">
					<label>Alamat</label>
					<input type="text" class="form-control" name="alamat" value="<?= set_value('alamat'); ?>">
					<small class="text-danger"><?= form_error('alamat'); ?></small>
				</div>
				<div class="form-group">
					<label>No. Darurat</label>
					<input type="number" class="form-control" name="nodarurat" value="<?= set_value('nodarurat'); ?>">
					<small class="text-danger"><?= form_error('nodarurat'); ?></small>
				</div>
				<div class="form-group">
					<label>Tgl. Lahir</label>
					<input type="date" class="form-control" name="tgl_lahir" value="<?= set_value('tgl_lahir'); ?>">
					<small class="text-danger"><?= form_error('tgl_lahir'); ?></small>
				</div>
				<div class="form-group">
					<label>Keterangan</label>
					<textarea class="form-control" name="keterangan"><?= set_value('keterangan'); ?></textarea>
					<small class="text-danger"><?= form_error('keterangan'); ?></small>
				</div>
				<div class="form-group">
					<button type="submit" name="submit" class="btn btn-primary float-right"><i class="fas fa-save"></i> Simpan</button>
				</div>
			</form>
			</div>
		</div>
	</div>
</div>