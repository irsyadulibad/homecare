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
				<button type="button" class="btn btn-primary float-right mb-4" data-toggle="modal" data-target="#tambahOngkirModal"><i class="fas fa-plus"></i> Tambah</button>
				<div class="table-responsive">
					<table class="table table-striped" id="datatable">
						<thead>
							<tr>
								<th>#</th>
								<th>Provinsi</th>
								<th>Kota</th>
								<th>Kecamatan</th>
								<th>Tarif</th>
								<th>Aksi</th>
							</tr>
						</thead>
						<tbody>
						<?php if(is_null($ongkirs)): ?>
							<tr>
								<td colspan="6" align="center">Data masih kosong</td>
							</tr>
						<?php else: $i = 0; ?>
							<?php foreach($ongkirs as $ongkir): $i++;?>
							<tr>
								<td><?= $i; ?></td>
								<td><?= $this->pesanan_m->getProv($ongkir['id_provinsi'])['nama']; ?></td>
								<td><?= $this->pesanan_m->getKota($ongkir['id_kota'])['nama']; ?></td>
								<td><?= $this->pesanan_m->getKec($ongkir['id_kecamatan'])['nama']; ?></td>
								<td>Rp.<?= number_format($ongkir['tarif'],0,',','.'); ?></td>
								<td>
									<button data-id="<?= $ongkir['id']; ?>" class="btn btn-sm btn-primary btn-edit-ongkir" data-toggle="modal" data-target="#editOngkirModal"><i class="fas fa-edit"></i> Edit</button>
									<a href="<?= base_url('ongkir/hapus/'.$ongkir['id']); ?>?prev=" class="btn btn-sm btn-danger confirm-href"><i class="fas fa-trash-alt"></i> Hapus</a>
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
