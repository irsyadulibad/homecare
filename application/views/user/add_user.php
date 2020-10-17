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
					<label>Email</label>
					<input type="email" class="form-control" name="email" value="<?= set_value('email'); ?>">
					<small class="text-danger"><?= form_error('email'); ?></small>
				</div>
				<div class="form-group">
					<label>No. HP</label>
					<input type="text" class="form-control" name="nohp" value="<?= set_value('nohp'); ?>">
					<small class="text-danger"><?= form_error('nohp'); ?></small>
				</div>
				<div class="form-group">
					<label>Jenis Kelamin</label>
					<select name="jenkel" class="form-control">
						<option value="1"  <?= set_value('jenkel') == 1 ? 'selected' : ''; ?>>Laki-Laki</option>
						<option value="2"  <?= set_value('jenkel') == 2 ? 'selected' : ''; ?>>Perempuan</option>
					</select>
				</div>
				<div class="form-group">
					<label>Plih Level</label>
					<select name="level" class="form-control">
						<option value="admin"  <?= set_value('level') == 'admin' ? 'selected' : ''; ?>>Admin</option>
						<option value="medis"  <?= set_value('level') == 'medis' ? 'selected' : ''; ?>>Medis</option>
						<option value="paramedis"  <?= set_value('level') == 'paramedis' ? 'selected' : ''; ?>>Paramedis</option>
						<option value="user"  <?= set_value('level') == 'user' ? 'selected' : ''; ?>>User</option>
					</select>
				</div>
				<div class="form-group">
					<label>Password</label>
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
