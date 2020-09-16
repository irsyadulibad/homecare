<?php
$provinces = $this->daerah->get_provinsi(); 
if(!is_null($user->alamat)){
	$kota = $this->daerah->get_kota($user->alamat->provinsi);
	$kecamatan = $this->daerah->get_kecamatan($user->alamat->kota);
	$desa = $this->daerah->get_desa($user->alamat->kecamatan);
}
?>
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
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="card">
				<div class="card-body">
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
					<div class="form-group">
						<label for="address">Alamat</label>
						<?php if(is_null($user->alamat)): ?>
						<input type="text" id="address" class="form-control" name="address" placeholder="Belum Diisi">
						<?php else: ?>
						<input type="text" id="address" class="form-control" name="address" value="<?= $user->alamat->alamat; ?>">
						<?php endif; ?>
						<small class="text-danger"><?= form_error('address'); ?></small>
					</div>
					<div class="form-group">
						<label for="provinsi">Provinsi</label>
						<select name="provinsi" id="provinsi" class="form-control">
						<?php if(is_null($user->alamat)): ?>
							<option value="">-- Belum Dipilih --</option>
							<?php foreach($provinces as $province): ?>
							<option value="<?= $province->id_provinsi; ?>"><?= $province->nama; ?></option>
							<?php endforeach; ?>
						<?php else: ?>
							<?php foreach($provinces as $province): ?>
							<option value="<?= $province->id_provinsi; ?>" <?= ($province->id_provinsi == $user->alamat->provinsi) ? 'selected' : ''; ?>><?= $province->nama; ?></option>
							<?php endforeach; ?>
						<?php endif; ?>
						</select>
						<small class="text-danger"><?= form_error('provinsi'); ?></small>
					</div>
					<div class="form-group">
						<label for="kota">Kabupaten/Kota</label>
						<select name="kota" id="kota" class="form-control">
						<?php if(is_null($user->alamat)): ?>
							<option value="">-- Belum Dipilih --</option>
						<?php else: ?>
							<?php foreach($kota as $kt): ?>
							<option value="<?= $kt->id_kota; ?>" <?= ($kt->id_kota == $user->alamat->kota) ? 'selected' : ''; ?>><?= $kt->nama; ?></option>
							<?php endforeach; ?>
					<?php endif; ?>
						</select>
						<small class="text-danger"><?= form_error('kota'); ?></small>
					</div>
					<div class="form-group">
						<label for="kecamatan">Kecamatan</label>
						<select name="kecamatan" id="kecamatan" class="form-control">
						<?php if(is_null($user->alamat)): ?>
							<option value="">-- Belum Dipilih --</option>
						<?php else: ?>
							<?php foreach($kecamatan as $kc): ?>
							<option value="<?= $kc->id; ?>" <?= ($kc->id == $user->alamat->kecamatan) ? 'selected' : ''; ?>><?= $kc->nama; ?></option>
							<?php endforeach; ?>
						<?php endif; ?>
						</select>
						<small class="text-danger"><?= form_error('kecamatan'); ?></small>
					</div>
					<div class="form-group">
						<label for="desa">Desa</label>
						<select name="desa" id="desa" class="form-control">
						<?php foreach($desa as $ds): ?>
								<option value="<?= $ds->id; ?>" <?= ($ds->id == $user->alamat->desa) ? 'selected' : ''; ?>><?= $ds->nama; ?></option>
						<?php endforeach; ?>
						</select>
						<small class="text-danger"><?= form_error('desa'); ?></small>
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
