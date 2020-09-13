<div class="container-fluid">
	<div class="row justify-content-center">
		<div class="col-md-6">
			<?= form_open(); ?>
			<div class="card">
				<div class="card-body">
				<?php if($sess = $this->session->flashdata('msg-edit-pass')): ?>
					<div class="alert alert-<?= $sess['class']; ?>" role="alert"><?= $sess['text']; ?></div>
				<?php endif; ?>
					<div class="form-group">
						<label for="oldpass">Kata Sandi</label>
						<input type="password" name="oldpass" id="oldpass" class="form-control">
						<small class="text-danger"><?= form_error('oldpass'); ?></small>
					</div>
					<div class="form-group border-top">
						<label for="oldpass" class="mt-4">Kata Sandi Baru</label>
						<input type="password" name="newpass" id="newpass" class="form-control">
						<small class="text-danger"><?= form_error('newpass'); ?></small>
					</div>
					<div class="form-group">
						<label for="oldpass">Konfirmasi Kata Sandi</label>
						<input type="password" name="confirmpass" id="confirmpass" class="form-control">
						<small class="text-danger"><?= form_error('confirmpass'); ?></small>
					</div>
				</div>
				<div class="card-footer">
					<button type="submit" class="btn btn-primary float-right"><i class="icon-paper-plane"></i> Simpan</button>
				</div>
			</div>
			</form>
		</div>
	</div>
</div>