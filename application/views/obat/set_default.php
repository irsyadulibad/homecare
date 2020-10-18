<div class="row">
	<div class="col-md-6">
		<div class="card">
			<div class="card-header bg-light">
				<h6>Tambah Obat Default</h6>
			</div>
			<div class="card-body">
				<?= form_open('', ['id' => 'form-default-drug']); ?>
					<div class="form-group">
						<label for="">Layanan</label>
						<input type="text" disabled="true" class="form-control" value="<?= $layanan['jenis_layanan']; ?>">
					</div>
					<div class="form-group">
						<label for="">Obat</label>
						<div></div>
						<select class="obat form-control" name="obat" class="form-control">
						<?php foreach($drugs as $obat): ?>
							<option value="<?= $obat['id_obat']; ?>"><?= $obat['nama']; ?></option>
						<?php endforeach; ?>
						</select>
					</div>
					<div class="form-group text-center">
						<button class="btn btn-success" type="submit" name="submit"><i class="fas fa-plus"></i> Tambah</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="card">
			<div class="card-header bg-light">
				<h6>Daftar Obat Default</h6>
			</div>
			<div class="card-body layobs-content">
			<?php if(empty($layobs)): ?>
				<h6 class="text-center">Data masih kosong</h6>
			<?php else: ?>
				<?php foreach($layobs as $layob): ?>
				<span class="badge badge-primary btn-del-layob mr-2 mb-2" data-id="<?= $layob['id_obat_layanan']; ?>" data-layanan="<?= $layob['id_layanan']; ?>"><span class=""><i class="fas fa-times-circle mr-2"></i></span> <?= $layob['nama']; ?></span>
				<?php endforeach; ?>
			<?php endif; ?>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-12">
		<a href="<?= base_url('obat/default/'); ?>" class="btn btn-info float-left mt-4"><i class="fas fa-arrow-left"></i> Kembali</a>
	</div>
</div>
