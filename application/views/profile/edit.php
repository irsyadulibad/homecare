<div class="container-fluid">
	<div class="row justify-content-center">
		<div class="col-md-6">
			<?= form_open_multipart(); ?>
			<div class="card">
				<div class="card-body text-center">
				<?php if($sess = $this->session->flashdata('msg-edit-img')): ?>
					<div class="alert alert-<?= $sess['class']; ?>" role="alert"><?= $sess['text']; ?></div>
				<?php endif; ?>
					<label for="edit-image" class="display-block" style="display: block;">
						<img src="<?= base_url('assets/img/profile/'.$user->foto); ?>" class="rounded-circle img-edit border" width="150" height="150" accept="image/*">
					</label>
					<input type="file" name="image" class="input-edit-img" style="display: none;" id="edit-image">
					<small class="mt-2">*Klik gambar untuk mengedit foto</small>
				</div>
				<div class="card-footer">
					<button type="submit" class="btn btn-primary text-white float-right"><i class="icon-paper-plane"></i> Simpan</button>
				</div>
			</div>
			</form>
		</div>
		<div class="col-md-6">
			<?= form_open(); ?>
			<div class="card">
				<div class="card-body">
				<?php if($sess = $this->session->flashdata('msg-edit-data')): ?>
					<div class="alert alert-<?= $sess['class']; ?>" role="alert"><?= $sess['text']; ?></div>
				<?php endif; ?>
					<div class="form-group">
						<label for="name">Nama Lengkap</label>
						<input type="text" name="name" class="form-control" id="name" value="<?= $user->nama_lengkap; ?>">
						<small class="text-danger"><?= form_error('name'); ?></small>
					</div>
					<div class="form-group">
						<label for="gender">Jenis Kelamin</label>
						<select class="form-control" id="gender" name="gender">
							<option value="1" <?= ($user->jenis_kelamin == 1)?'selected':''; ?>>Laki-Laki</option>
							<option value="2" <?= ($user->jenis_kelamin == 2)?'selected':''; ?>>Perempuan</option>
						</select>
						<small class="text-danger"><?= form_error('gender'); ?></small>
					</div>
					<div class="form-group">
						<label for="email">Email</label>
						<input type="text" name="email" class="form-control" id="email" value="<?= $user->email; ?>">
						<small class="text-danger"><?= form_error('email'); ?></small>
					</div>
					<div class="form-group">
						<label for="phone">No. HP</label>
						<input type="number" name="phone" class="form-control" id="phone" value="<?= $user->no_hp; ?>">
						<small class="text-danger"><?= form_error('phone'); ?></small>
					</div>
				</div>
				<div class="card-footer">
					<button class="btn btn-primary float-right"><i class="icon-paper-plane"></i> Simpan</button>
				</div>
			</div>
			</form>
		</div>
	</div>
</div>
