<?php if($errs = $this->session->flashdata('form_err')): ?>
<div class="row">
	<div class="col-md-6">
		<div class="alert alert-danger" role="alert">
			<?= $errs; ?>
		</div>
	</div>
</div>
<?php endif; ?>

<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-body">
				<button type="button" class="btn btn-primary float-right mb-4" data-toggle="modal" data-target="#tambahObatModal"><i class="fas fa-plus"></i> Tambah</button>
				<div class="table-responsive">
					<table class="table table-striped" id="datatable">
						<thead>
							<tr>
								<th>#</th>
								<th>ID Obat</th>
								<th>Nama Obat</th>
								<th>Harga Obat</th>
								<th>Stok Obat</th>
								<th>Aksi</th>
							</tr>
						</thead>
						<tbody>
						<?php if(is_null($obats)): ?>
							<tr>
								<td colspan="6" align="center">Data masih kosong</td>
							</tr>
						<?php else: $i = 0; ?>
							<?php foreach($obats as $obat): $i++;?>
							<tr>
								<td><?= $i; ?></td>
								<td><?= $obat['id_obat']; ?></td>
								<td><?= $obat['nama']; ?></td>
								<td><?= number_format($obat['harga'],0,',','.'); ?></td>
								<td><?= $obat['stok']; ?></td>
								<td>
									<a href="<?= base_url('obat/edit/'.$obat['id_obat']); ?>?prev=" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i> Edit</a>
									<a href="<?= base_url('obat/hapus/'.$obat['id_obat']); ?>?prev=" class="btn btn-sm btn-danger confirm-href"><i class="fas fa-trash-alt"></i> Hapus</a>
								</td>
							</tr>
							<?php endforeach; ?>
						<?php endif; ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
