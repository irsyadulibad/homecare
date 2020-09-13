<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-header">
				<h4>Daftar Pasien</h4>
			</div>
			<div class="card-body">
				<a href="<?= base_url('layanan/add'); ?>" class="btn btn-primary float-right mb-4"><i class="fas fa-plus"></i> Tambah</a>
				<div class="table-responsive">
					<table class="table table-striped" id="datatable">
						<thead>
							<tr>
								<th>#</th>
								<th>Nama Layanan</th>
								<th>Keterangan</th>
								<th>Harga</th>
								<th>Aksi</th>
							</tr>
						</thead>
						<tbody>
						<?php if(is_null($layanans)): ?>
							<tr>
								<td colspan="6" align="center">Data masih kosong</td>
							</tr>
						<?php else: $i = 0; ?>
							<?php foreach($layanans as $layanan): $i++;?>
							<tr>
								<td><?= $i; ?></td>
								<td><?= $layanan['jenis_layanan']; ?></td>
								<td><?= $layanan['keterangan']; ?></td>
								<td><?= $layanan['harga']; ?></td>
								<td>
									<a href="<?= base_url('layanan/update/'.$layanan['id_layanan']); ?>?prev=" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i> Edit</a>
									<a href="<?= base_url('layanan/dellay/'.$layanan['id_layanan']); ?>?prev=" class="btn btn-sm btn-danger confirm-href"><i class="fas fa-trash-alt"></i> Hapus</a>
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