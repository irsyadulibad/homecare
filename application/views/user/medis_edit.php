<div class="row justify-content-center">
	<div class="col-12 col-md-6 col-lg-6">
		<div class="card">
			<div class="card-body">
			<?= form_open(''); ?>
				<input type="hidden" name="id" value="<?= $user['id_medis']; ?>">
				<div class="form-group">
					<label>Nama Lengkap</label>
					<input type="text" class="form-control" name="fullname" value="<?= $user['nama_lengkap'] ?>">
					<small class="text-danger"><?= form_error('fullname'); ?></small>
				</div>
				<div class="form-group">
					<label>Email</label>
					<input type="email" class="form-control" name="email" value="<?= $user['email'] ?>">
					<small class="text-danger"><?= form_error('email'); ?></small>
				</div>
				<div class="form-group">
					<label>No. HP</label>
					<input type="text" class="form-control" name="nohp" value="<?= $user['no_hp'] ?>">
					<small class="text-danger"><?= form_error('nohp'); ?></small>
				</div>
				<div class="form-group">
					<label>Jenis Kelamin</label>
					<select name="jenkel" class="form-control">
						<option value="1"  <?= $user['jenis_kelamin'] == 1 ? 'selected' : ''; ?>>Laki-Laki</option>
						<option value="2"  <?= $user['jenis_kelamin'] == 2 ? 'selected' : ''; ?>>Perempuan</option>
					</select>
				</div>
				<div class="form-group">
					<label>Plih Level</label>
					<select name="level" class="form-control">
						<option value="medis"  <?= $user['status'] == 'medis' ? 'selected' : ''; ?>>Medis</option>
						<option value="paramedis"  <?= $user['status'] == 'paramedis' ? 'selected' : ''; ?>>Paramedis</option>
					</select>
				</div>
				<div class="form-group">
					<label>Password <small>(Kosongkan bila tidak diubah)</small></label>
					<input type="password" class="form-control" name="password">
					<small class="text-danger"><?= form_error('password'); ?></small>
				</div>
				<div class="form-group">
					<label>Konfirmasi Password</label>
					<input type="password" class="form-control" name="passconf">
					<small class="text-danger"><?= form_error('passconf'); ?></small>
				</div>
				<div class="form-group">
					<button type="submit" name="submit" class="btn btn-primary float-right"><i class="fas fa-save"></i> Simpan</button>
				</div>
			</form>
			</div>
		</div>
	</div>
</div>
